<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

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
        // Allow Horizon dashboard
        Gate::define('viewHorizon', function ($user = null) {
            return true;   // ⚠️ wide open for dev
        });

        // Allow Log Viewer dashboard
        Gate::define('viewLogViewer', function ($user = null) {
            return true;   // ⚠️ wide open for dev
        });
    }
}
