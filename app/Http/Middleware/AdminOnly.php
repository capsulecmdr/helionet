<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class AdminOnly
{
    public function handle($request, Closure $next)
    {
        // Must be logged in
        if (!Auth::check()) {
            abort(403, 'Unauthorized.');
        }

        $user = Auth::user();

        // Allowed if:
        // 1. User is the system admin
        // 2. User has is_admin = true
        if (! Auth::user()->isAdminUser()) {
            abort(403, 'Unauthorized.');
        }

        return $next($request);
    }
}
