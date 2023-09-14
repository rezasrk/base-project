<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by($request->user()?->id ?: $request->ip());
        });

        $this->registerRoute();
    }

    private function registerRoute()
    {
        $this->routes(function () {
            $this->registerAPIRoute();
            $this->registerSettingsRoute();
            $this->registerSuppliesAPI();
        });
    }

    private function registerAPIRoute()
    {
        Route::middleware('api')
            ->prefix('api')
            ->group(base_path('routes/api.php'));
    }

    private function registerSettingsRoute()
    {
        Route::middleware(['api', 'auth:sanctum', 'access.control'])
            ->group(base_path('routes/settings/settings_v1.php'));
    }

    private function registerSuppliesAPI()
    {
        Route::middleware(['api', 'auth:sanctum', 'access.control'])
            ->group(base_path('routes/supply/supplies_v1.php'));
    }
}
