<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $registerType = $request->input('register_type', 'partner');
        
        // Base validation rules
        $rules = [
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'register_type' => ['required', 'string', 'in:partner,student'],
        ];

        // Add conditional validation based on registration type
        if ($registerType === 'partner') {
            $rules['name'] = ['required', 'string', 'max:255'];
            $rules['email'] = ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class];
        } else {
            $rules['phone'] = [
                'required', 
                'string', 
                'regex:/^01[3-9][0-9]{8}$/', 
                'unique:'.User::class
            ];
        }

        $request->validate($rules, [
            'phone.regex' => 'Please enter a valid Bangladeshi phone number (e.g., 01XXXXXXXXX)',
            'name.required' => 'Organization Name is required.',
            'name.string' => 'Organization Name must be a valid text.',
            'name.max' => 'Organization Name cannot exceed 255 characters.',
        ]);

        // Prepare user data
        $userData = [
            'password' => Hash::make($request->password),
            'role' => $registerType,
        ];

        // Add email or phone based on registration type
        if ($registerType === 'partner') {
            $userData['name'] = $request->name;
            $userData['email'] = $request->email;
        } else {
            $userData['phone'] = $request->phone;
        }

        $user = User::create($userData);

        event(new Registered($user));

        Auth::login($user);

        // Redirect based on registration type
        if ($registerType === 'student') {
            return redirect(route('student.dashboard', absolute: false));
        } else {
            // Default to partner dashboard
            return redirect(route('partner.dashboard', absolute: false));
        }
    }
}
