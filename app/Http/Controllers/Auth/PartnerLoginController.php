<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;

class PartnerLoginController extends Controller
{
    /**
     * Display the partner login view.
     */
    public function create(): View
    {
        Log::info('Partner login page accessed', [
            'user_authenticated' => Auth::check(),
            'user_id' => Auth::id(),
            'user_role' => Auth::user()?->role ?? 'none'
        ]);
        
        return view('auth.partner.onboarding');
    }

    /**
     * Handle an incoming partner authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

        // Get the user and their role from the database
        $user = Auth::user();
        
        Log::info('Partner login attempt', [
            'user_id' => $user->id,
            'user_email' => $user->email,
            'has_role' => isset($user->role),
            'role_name' => $user->role->name ?? 'no role',
            'role_id' => $user->role_id ?? 'no role_id'
        ]);
        
        // Check if the user's role is partner
        if (!$user->role || $user->role->name !== 'partner') {
            Log::warning('User attempted partner login but is not a partner', [
                'user_id' => $user->id,
                'user_email' => $user->email,
                'role_name' => $user->role->name ?? 'no role',
                'role_id' => $user->role_id
            ]);
            
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            
            return back()->withErrors([
                'email' => 'Invalid credentials for Partner account.',
            ]);
        }
        
        Log::info('Partner login successful', [
            'user_id' => $user->id,
            'user_email' => $user->email,
            'role_name' => $user->role->name
        ]);
        
        // Redirect to partner dashboard
        return redirect()->intended(route('partner.dashboard', absolute: false));
    }
}
