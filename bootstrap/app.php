<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
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
