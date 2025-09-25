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
        $loginType = $request->input('login_type', 'partner');
        
        // Check if the user's role matches the login type
        if ($user->role !== $loginType) {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            
            return back()->withErrors([
                'email' => 'Invalid credentials for ' . ucfirst($loginType) . ' account.',
            ]);
        }
        
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
        if ($user->role === 'student') {
            Log::info('Redirecting to student dashboard', ['user_id' => $user->id]);
            return redirect()->route('student.dashboard');
        } elseif ($user->role === 'partner') {
            Log::info('Redirecting to partner dashboard', ['user_id' => $user->id]);
            Log::debug('Login Debug: User Role and Login Type', [
            'user_id' => $user->id,
            'user_role' => $user->role,
            'login_type' => $loginType,
            'redirect_target' => 'partner.dashboard'
        ]);
            return redirect()->route('partner.dashboard');
        }

        // Unknown role: log and redirect to welcome (safe) page
        Log::warning('User role unknown during login redirect, sending to welcome', ['user_id' => $user->id, 'role' => $user->role]);
        Log::debug('Login Debug: User Role and Login Type', [
            'user_id' => $user->id,
            'user_role' => $user->role,
            'login_type' => $loginType,
            'redirect_target' => '/'
        ]);
        return redirect('/');
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
