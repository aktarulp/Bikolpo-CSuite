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
                $effectiveRole = strtolower((string)($user->role ?? ''));
                if ($effectiveRole === '' && method_exists($user, 'roles')) {
                    $firstRole = $user->roles()->orderBy('level')->first();
                    if ($firstRole) {
                        $effectiveRole = strtolower($firstRole->name ?? '');
                    }
                }

                if ($effectiveRole === 'student') {
                    Log::info('Redirecting student to student dashboard');
                    if (!$request->routeIs('student.dashboard')) {
                        return redirect()->route('student.dashboard');
                    }
                } elseif ($effectiveRole === 'teacher') {
                    Log::info('Redirecting teacher to teacher dashboard');
                    if (!$request->routeIs('teacher.dashboard')) {
                        return redirect()->route('teacher.dashboard');
                    }
                } else {
                    // Partner and any other roles fall back to partner dashboard
                    Log::info('Redirecting to partner dashboard', ['role' => $user->role, 'effectiveRole' => $effectiveRole]);
                    if (!$request->routeIs('partner.dashboard')) {
                        return redirect()->route('partner.dashboard');
                    }
                }
                    // Unknown role or custom role: send to partner dashboard
                    Log::warning('Authenticated user has unknown role, redirecting to partner dashboard', ['role' => $user->role, 'effectiveRole' => $effectiveRole]);
                    return redirect()->route('partner.dashboard');
            }
        }

        return $next($request);
    }
}
