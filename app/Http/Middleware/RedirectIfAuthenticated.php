<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string ...$guards): Response
    {
        $guards = empty($guards) ? [null] : $guards;

        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {
                $user = Auth::guard($guard)->user();
                
                // Log the request for debugging
                Log::info('RedirectIfAuthenticated middleware', [
                    'route' => $request->route()->getName(),
                    'user_role' => $user->role ?? 'none',
                    'is_login_route' => $request->routeIs('login') || $request->routeIs('partner.login') || $request->routeIs('student.login')
                ]);
                
                // If the authenticated user is on a login/register page intentionally, allow access
                if ($request->routeIs('login') || $request->routeIs('partner.login') || $request->routeIs('student.login')) {
                    Log::info('Allowing authenticated user to access login page');
                    return $next($request);
                }

                // Redirect authenticated users to partner dashboard by default
                $effectiveRole = strtolower((string)($user->role ?? 'partner'));
                
                if ($effectiveRole === 'student') {
                    Log::info('Redirecting student to student dashboard');
                    if (!$request->routeIs('student.dashboard')) {
                        return redirect()->route('student.dashboard');
                    }
                } else {
                    // All other users (including partner and undefined roles) go to partner dashboard
                    Log::info('Redirecting to partner dashboard', ['role' => $user->role, 'effectiveRole' => $effectiveRole]);
                    if (!$request->routeIs('partner.dashboard')) {
                        return redirect()->route('partner.dashboard');
                    }
                }
            }
        }

        return $next($request);
    }
}
