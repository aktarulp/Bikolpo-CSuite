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
        $request->authenticate();

        $request->session()->regenerate();

        // Get the user and their role from the database
        $user = Auth::user();
        $loginType = $request->input('login_type', 'auto');
        
        // Allow login for all roles - automatic detection based on credentials
        
        // Log role and intended redirect for debugging
        Log::info('User logged in', [
            'user_id' => $user->id,
            'user_role' => $user->role,
            'login_type' => $loginType,
        ]);

        Log::debug('Login Debug: User Role and Login Type', [
            'user_id' => $user->id,
            'user_role' => $user->role,
            'login_type' => $loginType,
            'redirect_target' => 'student.dashboard'
        ]);

        // Redirect based on user's actual role in database
        switch ($user->role) {
            case 'student':
            case 'Student':
                Log::info('Redirecting to student dashboard', ['user_id' => $user->id]);
                return redirect()->route('student.dashboard');
                
            case 'partner':
            case 'Partner':
                Log::info('Redirecting to partner dashboard', ['user_id' => $user->id]);
                return redirect()->route('partner.dashboard');
                
            case 'teacher':
            case 'Teacher':
                Log::info('Redirecting to teacher dashboard', ['user_id' => $user->id]);
                return redirect()->route('teacher.dashboard');
                
            case 'admin':
            case 'Admin':
            case 'System':
                Log::info('Redirecting to admin dashboard', ['user_id' => $user->id]);
                return redirect()->route('admin.dashboard');
                
            default:
                // For other roles, redirect to partner dashboard as fallback
                Log::info('Unknown role, redirecting to partner dashboard', ['user_id' => $user->id, 'role' => $user->role]);
                return redirect()->route('partner.dashboard');
        }
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
