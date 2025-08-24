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
        Log::info('Starting authentication process', [
            'login_type' => $request->input('login_type', 'partner'),
            'email' => $request->input('email'),
            'phone' => $request->input('phone'),
            'session_id' => $request->session()->getId(),
        ]);

        $request->authenticate();

        Log::info('Authentication successful', [
            'user_id' => Auth::id(),
            'user_authenticated' => Auth::check(),
            'session_id' => $request->session()->getId(),
        ]);

        $request->session()->regenerate();

        Log::info('Session regenerated', [
            'new_session_id' => $request->session()->getId(),
            'user_authenticated' => Auth::check(),
        ]);

        // Get the user and their role from the database
        $user = Auth::user();
        $loginType = $request->input('login_type', 'partner');
        
        // Log the login attempt for debugging
        Log::info('Login attempt', [
            'user_id' => $user->id,
            'user_email' => $user->email,
            'user_phone' => $user->phone,
            'login_type' => $loginType,
            'user_role' => $user->role ? $user->role->name : 'no_role',
            'has_role_method' => method_exists($user, 'hasRole'),
            'is_partner' => $user->isPartner(),
            'is_student' => $user->isStudent(),
            'role_loaded' => $user->relationLoaded('role'),
            'role_data' => $user->role ? $user->role->toArray() : 'no_role_data',
            'user_data' => $user->toArray(),
        ]);
        
        // Check if the user's role matches the login type
        if (!$user->hasRole($loginType)) {
            Log::warning('Role mismatch during login', [
                'user_id' => $user->id,
                'expected_role' => $loginType,
                'actual_role' => $user->role ? $user->role->name : 'no_role',
            ]);
            
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            
            return back()->withErrors([
                'email' => 'Invalid credentials for ' . ucfirst($loginType) . ' account.',
            ]);
        }
        
        // Redirect based on user's actual role in database
        if ($user->isStudent()) {
            Log::info('Redirecting to student dashboard', [
                'user_id' => $user->id,
                'redirect_url' => route('student.dashboard', absolute: false)
            ]);
            Log::info('About to redirect to student dashboard');
            return redirect()->route('student.dashboard');
        } else {
            // Default to partner dashboard
            Log::info('Redirecting to partner dashboard', [
                'user_id' => $user->id,
                'redirect_url' => route('partner.dashboard', absolute: false),
                'user_role' => $user->role ? $user->role->name : 'no_role',
                'is_partner' => $user->isPartner(),
                'is_student' => $user->isStudent(),
            ]);
            Log::info('About to redirect to partner dashboard');
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
