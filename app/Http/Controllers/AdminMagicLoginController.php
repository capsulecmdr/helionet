<?php

namespace App\Http\Controllers;

use App\Models\AdminLoginLink;
use App\Support\HelionetLogger;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers;

class AdminMagicLoginController extends Controller
{
    public function login(string $token, Request $request)
    {
        $systemAdminId = config('auth.system_admin_id', 1);

        // We stored the hash, so hash incoming token
        $hashed = hash('sha256', $token);

        $link = AdminLoginLink::where('token', $hashed)->first();

        if (! $link) {
            HelionetLogger::warn('ADMIN03', 'Attempt to use unknown admin login token', [
                'ip'          => $request->ip(),
                'user_agent'  => $request->userAgent(),
            ]);

            abort(404);
        }

        if ($link->isUsed() || $link->isExpired()) {
            HelionetLogger::warn('ADMIN04', 'Attempt to use expired or used admin login token', [
                'link_id'     => $link->id,
                'user_id'     => $link->user_id,
                'ip'          => $request->ip(),
                'expired'     => $link->isExpired(),
                'used'        => $link->isUsed(),
            ]);

            return response()->view('auth.admin-link-expired', [], 403);
        }

        $user = $link->user;

        if (! $user || $user->id !== $systemAdminId || ! $user->is_admin) {
            HelionetLogger::error('ADMIN01', 'Admin login link points to invalid admin user', [
                'link_id'    => $link->id,
                'user_id'    => $link->user_id,
                'ip'         => $request->ip(),
            ]);

            abort(403, 'Not authorized');
        }

        // Mark link as used BEFORE login
        $link->used_at         = now();
        $link->used_ip         = $request->ip();
        $link->used_user_agent = (string) $request->userAgent();
        $link->save();

        // Alternatively, you could delete it:
        // $link->delete();

        Auth::guard('web')->login($user, false);
        $request->session()->regenerate();

        HelionetLogger::info('ADMIN05', 'Admin magic login successful', [
            'user_id' => $user->id,
            'ip'      => $request->ip(),
        ]);

        return redirect()->route('admin.dashboard'); // adjust route name if needed
    }
}
