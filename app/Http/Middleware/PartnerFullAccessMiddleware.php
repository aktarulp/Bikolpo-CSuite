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
        // Gate::before is registered once in AuthServiceProvider; keep middleware lean
        return $next($request);
    }
}
