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
                    'is_login_route' => $request->routeIs('login') || $request->routeIs('partner.onboarding') || $request->routeIs('student.login')
                ]);
                
                // Allow authenticated users to access login page if they want to switch accounts
                if ($request->routeIs('login') || $request->routeIs('partner.onboarding') || $request->routeIs('student.login')) {
                    Log::info('Allowing authenticated user to access login page');
                    return $next($request);
                }
                
                // Redirect based on user role for other guest-only pages
                if ($user->isStudent()) {
                    Log::info('Redirecting student to student dashboard');
                    return redirect()->route('student.dashboard');
                } else {
                    Log::info('Redirecting partner to partner dashboard');
                    return redirect()->route('partner.dashboard');
                }
            }
        }

        return $next($request);
    }
}
