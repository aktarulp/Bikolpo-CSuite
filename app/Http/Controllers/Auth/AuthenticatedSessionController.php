<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        Log::info('Login page accessed', [
            'user_authenticated' => Auth::check(),
            'user_id' => Auth::id(),
            'user_role' => Auth::user()?->role ?? 'none'
        ]);
        
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        \Log::info('AuthenticatedSessionController: Login attempt started', [
            'request_data' => $request->only(['email', 'phone', 'login_credential', 'login_type']),
            'session_id' => $request->session()->getId(),
        ]);

        // Authenticate the user
        $request->authenticate();

        // Regenerate session
        $request->session()->regenerate();

        // Get the authenticated user
        $user = Auth::user();
        
        // Determine login type for fallback logic
        $loginType = $request->input('login_type', 'auto');
        
        // Determine effective role (prefer string role, fallback to role relationship)
        $effectiveRole = strtolower((string)($user->role ?? ''));
        if ($effectiveRole === '' && $user->role) {
            $effectiveRole = strtolower($user->role->name ?? '');
        }
        
        // Debug: Log the authenticated user
        \Log::info('User authenticated', [
            'user_id' => $user->id,
            'email' => $user->email,
            'role' => $user->role,
            'role_id' => $user->role_id,
            'status' => $user->status,
            'effective_role' => $effectiveRole,
        ]);

        // Redirect based on role
        switch ($effectiveRole) {
            case 'system_administrator':
                \Log::info('Redirecting system administrator to system admin dashboard');
                return redirect()->route('system-admin.system-admin-dashboard');
                
            case 'partner':
            case 'partner_admin':
                \Log::info('Redirecting partner to partner dashboard');
                return redirect()->route('partner.dashboard');
                
            // Operator role removed - redirect to partner dashboard as fallback
            case 'operator':
                // Operator role omitted; fall back to partner dashboard
                \Log::info('Redirecting operator to partner dashboard');
                return redirect()->route('partner.dashboard');
                
            case 'student':
                \Log::info('Redirecting student to student dashboard');
                return redirect()->route('student.dashboard');
                
            default:
                \Log::warning('Unknown role detected, attempting intelligent redirect', [
                    'user_id' => $user->id, 
                    'role' => $user->role,
                    'role_lowercase' => strtolower($user->role),
                    'role_id' => $user->role_id ?? 'null'
                ]);
                
                // Try to determine appropriate dashboard based on role_id if role string doesn't match
                if ($user->role_id) {
                    Log::info('Attempting redirect via role_id', ['user_id' => $user->id, 'role_id' => $user->role_id, 'role' => $user->role]);
                    switch ($user->role_id) {
                        case 3: // Partner
                            Log::info('Redirecting to partner dashboard via role_id', ['user_id' => $user->id, 'role_id' => $user->role_id]);
                            return redirect()->route('partner.dashboard');
                        case 6: // Student
                            Log::info('Redirecting to student dashboard via role_id', ['user_id' => $user->id, 'role_id' => $user->role_id]);
                            return redirect()->route('student.dashboard');
                        default:
                            Log::info('Unknown role_id, redirecting to partner dashboard', ['user_id' => $user->id, 'role_id' => $user->role_id]);
                            return redirect()->route('partner.dashboard');
                    }
                }
                
                // Try to determine appropriate dashboard based on login type and role string
                if (in_array(strtolower($user->role), ['partner_admin', 'institution_admin'])) {
                    Log::info('Redirecting to partner dashboard via role string match', ['user_id' => $user->id]);
                    return redirect()->route('partner.dashboard');
                } elseif (isset($loginType) && $loginType === 'phone_based') {
                    Log::info('Redirecting to student dashboard via phone login type', ['user_id' => $user->id]);
                    return redirect()->route('student.dashboard');
                } else {
                    // Default fallback to partner dashboard for any other role
                    Log::info('Redirecting to partner dashboard as final fallback', ['user_id' => $user->id]);
                    return redirect()->route('partner.dashboard');
                }
        }

        // As a final safety net, send authenticated users to partner dashboard
        return redirect()->route('partner.dashboard');
    }

    /**
     * Log the user out of the application.
     */
    public function destroy(Request $request): RedirectResponse
    {
        // Get user info before logging out
        $user = Auth::user();
        $userId = $user ? $user->id : null;
        $userRole = $user ? $user->role : null;
        
        // Log the logout attempt
        Log::info('User logging out', [
            'user_id' => $userId,
            'role' => $userRole,
            'session_id' => $request->session()->getId()
        ]);

        // Logout the user
        Auth::guard('web')->logout();

        // Invalidate the session
        $request->session()->invalidate();

        // Regenerate CSRF token
        $request->session()->regenerateToken();

        // Log successful logout
        Log::info('User logged out successfully', [
            'user_id' => $userId,
            'session_id' => $request->session()->getId()
        ]);

        // Redirect to login page
        return redirect('/login');
    }
}
