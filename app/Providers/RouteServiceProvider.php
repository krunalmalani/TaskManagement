<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->routes(function () {
            Route::middleware('web')
                ->prefix('admin') // Applies "admin" prefix to all admin routes
                ->group(base_path('routes/admin.php'));

            Route::middleware('web')
                ->prefix('sadmin') // Applies "admin" prefix to all admin routes
                ->group(base_path('routes/superadmin.php'));

            Route::middleware('api')
                ->prefix('api')
                ->group(base_path('routes/api.php'));
        });
    }
}