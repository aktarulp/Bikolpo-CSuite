<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RefreshCSRFToken
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // For AJAX requests, allow CSRF token refresh
        if ($request->ajax() && $request->header('X-Requested-With') === 'XMLHttpRequest') {
            // Regenerate CSRF token for AJAX requests to prevent 419 errors
            $request->session()->regenerateToken();
        }

        return $next($request);
    }
}
