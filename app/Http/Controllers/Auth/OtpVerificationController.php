<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\VerificationCode;
use App\Models\EnhancedUser;
use App\Models\Partner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;
use Illuminate\Validation\ValidationException;

class OtpVerificationController extends Controller
{
    /**
     * Show the OTP verification form
     */
    public function show(Request $request)
    {
        $email = $request->session()->get('email'); // Retrieve from flash data
        
        if (!$email) {
            return redirect()->route('register');
        }

        return view('auth.verify-otp', compact('email'));
    }

    /**
     * Verify the OTP and complete registration
     */
    public function verify(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'otp' => 'required|string|size:6',
        ]);

        $email = $request->email;
        $otp = $request->otp;

        // Verify the OTP
        $verificationCode = VerificationCode::verify($email, $otp, 'registration');

        if (!$verificationCode) {
            throw ValidationException::withMessages([
                'otp' => ['Invalid or expired verification code.'],
            ]);
        }

        // Get registration data from session
        $registrationData = $request->session()->get('registration_data');
        
        if (!$registrationData) {
            return redirect()->route('register')->withErrors(['email' => 'Registration session expired. Please try again.']);
        }

        // Double-check email uniqueness before creating user (safety check)
        $existingUser = \App\Models\EnhancedUser::where('email', $email)->first();
        if ($existingUser) {
            // Mark the verification code as used to prevent reuse
            $verificationCode->markAsUsed();
            
            // Clear session data
            $request->session()->forget(['registration_email', 'registration_data']);
            
            return redirect()->route('register')->withErrors([
                'email' => 'This email address is already registered. Please use a different email address or try logging in.'
            ]);
        }

        try {
            DB::beginTransaction();

            // First create the partner to get partner_id
            $partner = Partner::create([
                'name' => $registrationData['name'],
                'email' => $email,
                'status' => 'active',
                'flag' => 'active',
            ]);

            // Role assignment disabled - skip role creation/assignment

            // Create user with only the fields that exist in the database
            $userData = [
                'name' => $registrationData['name'],
                'email' => $email,
                'password' => Hash::make($registrationData['password']),
                'email_verified_at' => now(),
            ];
            
            // Add optional fields if they exist in the database
            if (Schema::hasColumn('ac_users', 'status')) {
                $userData['status'] = 'active';
            }
            if (Schema::hasColumn('ac_users', 'partner_id')) {
                $userData['partner_id'] = $partner->id;
            }
            // Role assignment disabled - skip role_id
            // if (Schema::hasColumn('ac_users', 'role_id')) {
            //     $userData['role_id'] = $partnerRole->id;
            // }
            
            // Create the user first
            $user = \App\Models\EnhancedUser::create($userData);
            
            // Now update created_by and updated_by with the user's own ID (self-registration)
            if (Schema::hasColumn('ac_users', 'created_by')) {
                $user->created_by = $user->id;
            }
            if (Schema::hasColumn('ac_users', 'updated_by')) {
                $user->updated_by = $user->id;
            }
            $user->save();
            



            // Mark OTP as used
            $verificationCode->markAsUsed();

            // Clear session data
            $request->session()->forget(['registration_email', 'registration_data']);

            DB::commit();

            // Show success message and redirect to login
            return redirect()->route('login')
                ->with('success', 'Registration successful! Your account has been created. Please sign in with your credentials.');

        } catch (\Exception $e) {
            DB::rollBack();
            
            // Get detailed error information
            $errorMessage = $e->getMessage();
            $errorDetails = [
                'message' => $errorMessage,
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString()
            ];
            
            // Log the error for debugging
            \Log::error('Partner registration failed', $errorDetails);
            
            // Clear session data
            $request->session()->forget(['registration_email', 'registration_data']);
            
            // Check specific error types
            if (str_contains($errorMessage, 'Duplicate entry') && str_contains($errorMessage, 'email')) {
                return redirect()->route('register')->withErrors([
                    'email' => 'This email address is already registered. Please use a different email address or try logging in.'
                ]);
            }
            
            // For development, show detailed error
            if (config('app.debug')) {
                return redirect()->route('register')
                    ->withErrors([
                        'email' => 'Registration error: ' . $errorMessage . ' in ' . $e->getFile() . ' on line ' . $e->getLine()
                    ]);
            }
            
            // Production error message
            return redirect()->route('register')->withErrors([
                'email' => 'Registration failed due to a technical issue. Please try again or contact support if the problem persists. Error: ' . $errorMessage
            ]);
        }
    }

    /**
     * Resend OTP
     */
    public function resend(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);

        $email = $request->email;

        // Generate new OTP
        $verificationCode = VerificationCode::generateCode($email, 'registration');

        // Send email with new OTP using our custom notification
        try {
            $user = new EnhancedUser(['email' => $email]);
            $user->notify(new \App\Notifications\OtpVerificationNotification($verificationCode->code));
            
            return back()->with('status', 'A new verification code has been sent to your email.');
        } catch (\Exception $e) {
            return back()->withErrors(['email' => 'Failed to send verification code. Please try again.']);
        }
    }
}
