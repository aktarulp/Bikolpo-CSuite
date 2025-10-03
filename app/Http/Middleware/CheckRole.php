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

        if (strtolower(auth()->user()->role) !== strtolower($role)) {
            // Log role mismatch for debugging
            \Log::warning('Role mismatch in CheckRole middleware', [
                'user_id' => auth()->user()->id,
                'user_role' => auth()->user()->role,
                'required_role' => $role,
                'url' => $request->url()
            ]);
            
            // Redirect based on user's actual role when possible.
            // Avoid redirecting to the same protected route which can cause infinite loops.
            $actualRole = strtolower(auth()->user()->role);

            switch ($actualRole) {
                case 'student':
                    return redirect()->route('student.dashboard');
                case 'partner':
                    return redirect()->route('partner.dashboard');
                case 'teacher':
                    return redirect()->route('teacher.dashboard');
                case 'operator':
                    return redirect()->route('operator.dashboard');
                case 'system_administrator':
                case 'admin':
                case 'system':
                    return redirect()->route('admin.dashboard');
                default:
                    // Fallback: send to home page to avoid loops for unexpected roles
                    return redirect('/');
            }
        }

        return $next($request);
    }
}
