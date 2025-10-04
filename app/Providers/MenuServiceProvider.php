<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;
use App\Services\MenuPermissionService;

class MenuServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->singleton(MenuPermissionService::class, function ($app) {
            return new MenuPermissionService();
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        // Register Blade directive for menu permission checking
        Blade::if('canAccessMenu', function (string $menuName) {
            $service = app(MenuPermissionService::class);
            return $service->canAccessMenu($menuName);
        });
        
        // Register helper for multiple menus
        Blade::if('canAccessAnyMenu', function (...$menuNames) {
            $service = app(MenuPermissionService::class);
            return $service->canAccessAnyMenu($menuNames);
        });
    }
}
