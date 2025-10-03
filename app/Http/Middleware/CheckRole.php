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

        $userRole = strtolower(auth()->user()->role);
        $requiredRole = strtolower($role);
        
        // Handle role variations and aliases
        $roleMatches = false;
        
        if ($requiredRole === 'partner') {
            // Partner role variations (case-insensitive)
            $roleMatches = in_array($userRole, ['partner', 'partner_admin', 'institution_admin']);
        } elseif ($requiredRole === 'teacher') {
            // Teacher role variations
            $roleMatches = in_array($userRole, ['teacher', 'instructor']);
        } elseif ($requiredRole === 'student') {
            // Student role variations
            $roleMatches = in_array($userRole, ['student', 'learner']);
        } elseif ($requiredRole === 'operator') {
            // Operator role variations
            $roleMatches = in_array($userRole, ['operator', 'staff']);
        } else {
            // Exact match for other roles
            $roleMatches = ($userRole === $requiredRole);
        }
        
        if (!$roleMatches) {
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

            // Use the same role matching logic for redirects
            if (in_array($actualRole, ['student', 'learner'])) {
                return redirect()->route('student.dashboard');
            } elseif (in_array($actualRole, ['partner', 'partner_admin', 'institution_admin'])) {
                return redirect()->route('partner.dashboard');
            } elseif (in_array($actualRole, ['teacher', 'instructor'])) {
                return redirect()->route('teacher.dashboard');
            } elseif (in_array($actualRole, ['operator', 'staff'])) {
                return redirect()->route('operator.dashboard');
            } elseif (in_array($actualRole, ['system_administrator', 'admin', 'system'])) {
                return redirect()->route('admin.dashboard');
            } else {
                // Fallback: send to home page to avoid loops for unexpected roles
                return redirect('/');
            }
        }

        return $next($request);
    }
}
