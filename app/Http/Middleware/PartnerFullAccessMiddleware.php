<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class PartnerFullAccessMiddleware
{
    /**
     * Handle an incoming request.
     * Grant full access to partner users by overriding all permission checks,
     * but only for authenticated requests and respect role-based access control for students.
     */
    public function handle(Request $request, Closure $next)
    {
        // Log middleware execution for debugging
        Log::info('PartnerFullAccessMiddleware executed', [
            'request_path' => $request->path(),
            'user_authenticated' => Auth::check(),
        ]);

        // Only apply this middleware to authenticated requests
        if (!Auth::check()) {
            return $next($request);
        }

        // Get the authenticated user
        $user = Auth::user();
        
        // Log user details
        Log::info('Authenticated user in PartnerFullAccessMiddleware', [
            'user_id' => $user->id,
            'user_role' => $user->role,
            'user_role_id' => $user->role_id,
        ]);

        // For student users, don't apply full access - let other middleware handle role checking
        if ($user->role === 'student' || $user->role_id == 3) {
            Log::info('Student user detected, not applying full access', [
                'user_id' => $user->id,
            ]);
            return $next($request);
        }

        // For non-student users (partners, admins, etc.), apply full access
        Log::info('Non-student user detected, applying full access', [
            'user_id' => $user->id,
            'user_role' => $user->role,
        ]);
        
        // Gate::before is registered once in AuthServiceProvider; keep middleware lean
        return $next($request);
    }
}