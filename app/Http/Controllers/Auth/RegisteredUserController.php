<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Partner;
use App\Models\VerificationCode;
use App\Notifications\OtpVerificationNotification;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
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
            $rules['email'] = ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:users,email'];
        } else {
            $rules['phone'] = [
                'required', 
                'string', 
                'regex:/^01[3-9][0-9]{8}$/', 
                'unique:users,phone'
            ];
        }

        $request->validate($rules, [
            'phone.regex' => 'Please enter a valid Bangladeshi phone number (e.g., 01XXXXXXXXX)',
            'phone.unique' => 'This phone number is already registered. Please use a different phone number or try logging in.',
            'email.unique' => 'This email address is already registered. Please use a different email address or try logging in.',
            'name.required' => 'Organization Name is required.',
            'name.string' => 'Organization Name must be a valid text.',
            'name.max' => 'Organization Name cannot exceed 255 characters.',
        ]);

        // For partner registration, implement OTP verification
        if ($registerType === 'partner') {
            try {
                // Store registration data in session
                $request->session()->put('registration_data', [
                    'name' => $request->name,
                    'email' => $request->email,
                    'password' => $request->password,
                    'organization_type' => $request->organization_type,
                ]);
                
                $request->session()->put('registration_email', $request->email);

                // Generate OTP
                $verificationCode = VerificationCode::generateCode($request->email, 'registration');

                // Send OTP email
                $this->sendOtpEmail($request->email, $verificationCode->code);

                // Redirect to OTP verification page
                return redirect()->route('otp.verify');
            } catch (\Exception $e) {
                // Log the error for debugging
                \Log::error('OTP registration failed: ' . $e->getMessage());
                
                return back()->withErrors(['email' => 'Failed to send verification code. Please try again.']);
            }
        }

        // For student registration, continue with existing logic
        try {
            // Find the Student role
            $studentRole = \App\Models\EnhancedRole::where('name', 'Student')->first();
            if (!$studentRole) {
                // Fallback to a default role if Student role doesn't exist
                $studentRole = \App\Models\EnhancedRole::where('is_default', true)->first();
            }

            // Get system user ID for registration tracking
            $systemUser = \App\Models\EnhancedUser::where('email', 'system@bikolpo.com')->first();
            $systemUserId = $systemUser ? $systemUser->id : null;

            // Prepare user data with all required fields
            $userData = [
                'phone' => $request->phone,
                'password' => Hash::make($request->password),
                'role' => $studentRole ? $studentRole->name : 'Student',
                'role_id' => $studentRole ? $studentRole->id : null,
                'status' => 'active',
                'partner_id' => null, // Students don't belong to a partner initially
                'created_by' => $systemUserId, // Web Registration System
                'updated_by' => $systemUserId,
            ];

            $user = \App\Models\EnhancedUser::create($userData);

            event(new Registered($user));
            Auth::login($user);

            return redirect(route('student.dashboard', absolute: false));
        } catch (\Exception $e) {
            return back()->withErrors(['email' => 'Registration failed. Please try again.']);
        }
    }

    /**
     * Send OTP email
     */
    private function sendOtpEmail(string $email, string $otp): void
    {
        try {
            $user = new User(['email' => $email]);
            $user->notify(new OtpVerificationNotification($otp));
        } catch (\Exception $e) {
            \Log::error('Failed to send OTP email: ' . $e->getMessage());
            throw new \Exception('Failed to send verification code: ' . $e->getMessage());
        }
    }
}
