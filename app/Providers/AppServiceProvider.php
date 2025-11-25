<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Event;

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
        Event::listen(RouteMatched::class, function (RouteMatched $event) {
            $route = $event->route;

            if (! $route) {
                return;
            }

            $name = $route->getName();          // e.g. "horizon.index", "log-viewer.index"
            $uri  = ltrim($route->uri(), '/');  // e.g. "horizon", "log-viewer/api/logs"

            // Helper to decide if this route should be admin-protected
            $protect = false;

            // Horizon routes: often named "horizon.*" and URI starts with "horizon"
            if (($name && str_starts_with($name, 'horizon.')) ||
                str_starts_with($uri, 'horizon')) {
                $protect = true;
            }

            // Log Viewer routes: often named "log-viewer.*" and URI starts with "log-viewer"
            if (($name && str_starts_with($name, 'log-viewer.')) ||
                str_starts_with($uri, 'log-viewer')) {
                $protect = true;
            }

            if ($protect) {
                // Apply your alias-based middleware
                $route->middleware('admin');
            }
        });
    }
}
