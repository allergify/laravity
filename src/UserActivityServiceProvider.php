<?php

namespace Laravity;

use Illuminate\Contracts\Http\Kernel;
use Illuminate\Support\ServiceProvider;
use Laravity\Http\Middleware\UserActivityMonitoringMiddleware;

class UserActivityServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register()
    {
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(Kernel $kernel)
    {
        if (app()->environment('production')) {
            $this->app['router']->pushMiddlewareToGroup('web', UserActivityMonitoringMiddleware::class);
        }
    }
}
