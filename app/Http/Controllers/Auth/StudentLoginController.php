<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;

class StudentLoginController extends Controller
{
    /**
     * Display the student login view.
     */
    public function create(): View
    {
        Log::info('Student login page accessed', [
            'user_authenticated' => Auth::check(),
            'user_id' => Auth::id(),
            'user_role' => Auth::user()?->role ?? 'none'
        ]);
        
        return view('auth.student.login');
    }

    /**
     * Handle an incoming student authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

        // Get the user and their role from the database
        $user = Auth::user();
        
        // Check if the user's role is student
        if ($user->role && $user->role->name !== 'student') {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            
            return back()->withErrors([
                'email' => 'Invalid credentials for Student account.',
            ]);
        }
        
        // Redirect to student dashboard
        return redirect()->intended(route('student.dashboard', absolute: false));
    }
}
