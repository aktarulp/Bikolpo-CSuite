<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SystemAdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        $userRole = auth()->user()->role;
        if ($userRole !== 'system-admin' && $userRole !== 'system_administrator') {
            abort(403, 'Access denied. System administrator role required.');
        }

        return $next($request);
    }
}
