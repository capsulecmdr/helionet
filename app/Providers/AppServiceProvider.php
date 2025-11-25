<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;
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

        // // Allow Log Viewer dashboard
        // Gate::define('viewLogViewer', function ($user = null) {
        //     return true;   // ⚠️ wide open for dev
        // });
    }
}
