<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Event;
use Laravel\Horizon\Horizon;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // // Allow Horizon dashboard
        // Horizon::auth(function ($request) {
        //     return true; // dev only!
        // });

        // Gate::define('viewHorizon', function ($user = null) {
        //     return true;
        // });

        // Allow Log Viewer dashboard
         Gate::define('viewLogViewer', function ($user = null) {
             //return true;   // ⚠️ wide open for dev
             return $user?->isAdminUser() ?? false;
         });

         // This controls access to the Horizon dashboard
        Horizon::auth(function ($request) {
            /** @var \App\Models\User|null $user */
            $user = $request->user();

            return $user?->isAdminUser() ?? false;
        });

        // Extra safety: some Horizon bits can also rely on this gate
        Gate::define('viewHorizon', function (?User $user = null): bool {
            return $user?->isAdminUser() ?? false;
        });
    }
}
