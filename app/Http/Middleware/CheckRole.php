<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     * Check if the authenticated user has one of the required roles.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        $user = auth()->user();
        
        // If no specific roles are required, allow access
        if (empty($roles)) {
            return $next($request);
        }
        
        // Check if user has any of the required roles
        if (in_array($user->role, $roles)) {
            return $next($request);
        }
        
        // Redirect based on user role
        if ($user->role === 'student') {
            return redirect()->route('student.dashboard')->with('error', 'Access denied. Insufficient permissions.');
        }
        
        // Default redirect for other roles
        return redirect()->route('partner.dashboard')->with('error', 'Access denied. Insufficient permissions.');
    }
}