<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Support\Facades\Route;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
        then: function () {
            Route::middleware('web')
                ->prefix('partner')
                ->group(base_path('routes/partner_students.php'));
        },
    )
    ->withProviders([
        \App\Providers\MenuServiceProvider::class,
    ])
    ->withMiddleware(function (Middleware $middleware): void {
        // Add global middleware for partner full access
        $middleware->web(append: [
            \App\Http\Middleware\PartnerFullAccessMiddleware::class,
            // Local-only request timing (very low overhead when disabled)
            \App\Http\Middleware\RequestTimingMiddleware::class,
        ]);
        
        $middleware->alias([
            'role' => \App\Http\Middleware\CheckRole::class,
            'partner' => \App\Http\Middleware\CheckPartnerRole::class,
            'system_admin' => \App\Http\Middleware\SystemAdminMiddleware::class,
            // Permission middleware removed
            // Keep explicit alias if you still want to call Spatie's role for any legacy route
            'spatie_role' => \Spatie\Permission\Middleware\RoleMiddleware::class,
            'guest' => \App\Http\Middleware\RedirectIfAuthenticated::class,
            'refresh.csrf' => \App\Http\Middleware\RefreshCSRFToken::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
