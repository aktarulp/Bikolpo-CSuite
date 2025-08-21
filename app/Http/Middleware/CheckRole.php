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

        if (!auth()->user()->hasRole($role)) {
            // Redirect based on user's actual role
            if (auth()->user()->isStudent()) {
                return redirect()->route('student.dashboard');
            } elseif (auth()->user()->isPartner()) {
                return redirect()->route('partner.dashboard');
            } else {
                return redirect()->route('login');
            }
        }

        return $next($request);
    }
}
