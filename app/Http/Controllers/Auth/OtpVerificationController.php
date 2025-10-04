<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\VerificationCode;
use App\Models\User;
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
        $email = $request->session()->get('registration_email');
        
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

            // Find the partner role
            $partnerRole = \App\Models\EnhancedRole::where('name', 'partner')->first();
            
            // If partner role not found, try to find any role
            if (!$partnerRole) {
                $partnerRole = \App\Models\EnhancedRole::first();
            }
            
            // If still no role found, create a default partner role with only the fields that exist in the database
            if (!$partnerRole) {
                try {
                    $partnerRole = \App\Models\EnhancedRole::create([
                        'name' => 'partner',
                        'description' => 'Partner role with basic permissions'
                    ]);
                } catch (\Exception $e) {
                    \Log::error('Failed to create partner role: ' . $e->getMessage());
                    throw new \RuntimeException('Failed to create partner role. Please contact support.');
                }
            }

            // Get system user ID for registration tracking
            $systemUser = \App\Models\EnhancedUser::where('email', 'system@bikolpo.com')->first();
            $systemUserId = $systemUser ? $systemUser->id : null;

                // Create user with only the fields that exist in the database
                $userData = [
                    'name' => $registrationData['name'],
                    'email' => $email,
                    'password' => Hash::make($registrationData['password']),
                    'email_verified_at' => now(),
                    'role' => $partnerRole->name,
                ];
                
                // Add optional fields if they exist in the database
                if (Schema::hasColumn('users', 'status')) {
                    $userData['status'] = 'active';
                }
                if (Schema::hasColumn('users', 'partner_id')) {
                    $userData['partner_id'] = $partner->id;
                }
                if (Schema::hasColumn('users', 'created_by') && $systemUserId) {
                    $userData['created_by'] = $systemUserId;
                }
                if (Schema::hasColumn('users', 'updated_by') && $systemUserId) {
                    $userData['updated_by'] = $systemUserId;
                }
                
                // Create the user
                $user = \App\Models\EnhancedUser::create($userData);

                // Update partner with user_id
            $partner->update(['user_id' => $user->id]);

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
            $user = new User(['email' => $email]);
            $user->notify(new \App\Notifications\OtpVerificationNotification($verificationCode->code));
            
            return back()->with('status', 'A new verification code has been sent to your email.');
        } catch (\Exception $e) {
            return back()->withErrors(['email' => 'Failed to send verification code. Please try again.']);
        }
    }
}
