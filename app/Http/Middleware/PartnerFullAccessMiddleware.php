<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class PartnerFullAccessMiddleware
{
    /**
     * Handle an incoming request.
     * Grant full access to partner users by overriding all permission checks.
     */
    public function handle(Request $request, Closure $next)
    {
        // If user is authenticated and has partner role, grant all permissions
        if (auth()->check() && auth()->user()->role === 'partner') {
            // Override the Gate to always return true for partner users
            Gate::before(function ($user, $ability) {
                if ($user->role === 'partner') {
                    return true; // Grant all permissions
                }
            });
        }

        return $next($request);
    }
}
