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
                    'user_id' => $user->id,
                    'user_role' => $user->role,
                    'is_login_route' => $request->routeIs('login') || $request->routeIs('partner.login') || $request->routeIs('student.login')
                ]);
                
                // If the authenticated user is on a login/register page intentionally, allow access
                if ($request->routeIs('login') || $request->routeIs('partner.login') || $request->routeIs('student.login')) {
                    Log::info('Allowing authenticated user to access login page');
                    return $next($request);
                }

                // Redirect based on user role for other guest-only pages.
                // Use safe fallbacks to avoid redirect loops.
                if ($user->role === 'student') {
                    Log::info('Redirecting student to student dashboard');
                    // If current route already points to student.dashboard, avoid redirect
                    if (!$request->routeIs('student.dashboard')) {
                        return redirect()->route('student.dashboard');
                    }
                } elseif ($user->role === 'partner') {
                    Log::info('Redirecting partner to partner dashboard');
                    if (!$request->routeIs('partner.dashboard')) {
                        return redirect()->route('partner.dashboard');
                    }
                } else {
                    // Unknown role: send to home to avoid redirecting into protected routes
                    Log::warning('Authenticated user has unknown role, redirecting to home', ['role' => $user->role]);
                    return redirect('/');
                }
            }
        }

        return $next($request);
    }
}
