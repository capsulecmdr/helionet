<?php

namespace App\Console\Commands;

use App\Models\AdminLoginLink;
use App\Models\User;
use App\Support\HelionetLogger;
use Illuminate\Console\Command;
use Illuminate\Support\Str;

class GenerateAdminLoginUrl extends Command
{
    protected $signature = 'helionet:admin:login';

    protected $description = 'Generate a one-time admin login URL for the System administrator';

    public function handle(): int
    {
        $this->info('HelioNET Admin Login URL Generator');
        $this->line('Target user: System (built-in administrator)');

        $systemAdminId = config('auth.system_admin_id', 1);

        /** @var \App\Models\User|null $user */
        $user = User::find($systemAdminId);

        if (! $user) {
            $this->error("System admin user with ID {$systemAdminId} not found.");
            HelionetLogger::error('ADMIN01', 'System admin user not found', [
                'system_admin_id' => $systemAdminId,
            ]);
            return self::FAILURE;
        }

        $ttlSeconds = (int) config('auth.admin_magic_link_ttl', 60);
        $plainToken = Str::random(64);

        // For max security, hash for storage (but still show plain token in URL)
        $storedToken = hash('sha256', $plainToken);

        $link = AdminLoginLink::create([
            'user_id'    => $user->id,
            'token'      => $storedToken,
            'expires_at' => now()->addSeconds($ttlSeconds),
            'created_ip' => 'cli',
        ]);

        $appUrl = rtrim(config('app.url'), '/');
        $path   = route('admin.magic-login', ['token' => $plainToken], false);
        $url    = $appUrl . $path;

        HelionetLogger::info('ADMIN02', 'Admin login URL generated', [
            'user_id'      => $user->id,
            'link_id'      => $link->id,
            'expires_at'   => $link->expires_at?->toIso8601String(),
            'ttl_seconds'  => $ttlSeconds,
        ]);

        $this->newLine();
        $this->info("Your admin authentication URL is valid for {$ttlSeconds} seconds:");
        $this->line($url);
        $this->newLine();

        return self::SUCCESS;
    }
}
