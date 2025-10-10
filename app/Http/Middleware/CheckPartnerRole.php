<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Log;

class CheckPartnerRole
{
    /**
     * Handle an incoming request.
     * Only allow users with partner-related roles to access partner routes.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Log middleware execution for debugging
        Log::info('CheckPartnerRole middleware executed', [
            'user_authenticated' => auth()->check(),
            'user_id' => auth()->check() ? auth()->id() : null,
            'user_role' => auth()->check() ? auth()->user()->role : null,
            'request_path' => $request->path(),
        ]);

        // Check if user is authenticated
        if (!auth()->check()) {
            Log::info('User not authenticated, redirecting to login');
            return redirect()->route('login');
        }

        // Get the authenticated user
        $user = auth()->user();

        // Log user details
        Log::info('Authenticated user details', [
            'user_id' => $user->id,
            'user_role' => $user->role,
            'user_role_id' => $user->role_id,
        ]);

        // Check if user has a student role
        // Students can be identified by:
        // 1. role field = 'student'
        // 2. role_id field = 3 (student role ID)
        $isStudent = ($user->role === 'student' || $user->role_id == 3);

        if ($isStudent) {
            Log::info('Student user denied access to partner area', [
                'user_id' => $user->id,
                'user_role' => $user->role,
                'user_role_id' => $user->role_id,
                'redirecting_to' => 'student.dashboard',
            ]);
            // Students should be redirected to their dashboard
            return redirect()->route('student.dashboard')->with('error', 'Access denied. Students cannot access partner areas.');
        }

        // Allow access for non-student roles
        Log::info('Non-student user granted access to partner area', [
            'user_id' => $user->id,
            'user_role' => $user->role,
            'user_role_id' => $user->role_id,
        ]);
        return $next($request);
    }
}