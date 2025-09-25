<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string $role): Response
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        if (auth()->user()->role !== $role) {
            // Redirect based on user's actual role when possible.
            // Avoid redirecting to the same protected route which can cause infinite loops.
            $actualRole = auth()->user()->role;

            if ($actualRole === 'student') {
                return redirect()->route('student.dashboard');
            }

            if ($actualRole === 'partner') {
                return redirect()->route('partner.dashboard');
            }

            // Fallback: send to home page to avoid loops for unexpected roles (admin, super-admin, etc.)
            return redirect('/');
        }

        return $next($request);
    }
}
