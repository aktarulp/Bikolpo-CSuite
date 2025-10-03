<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\VerificationCode;
use App\Models\User;
use App\Models\Partner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
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

            // Find the Partner role
            $partnerRole = \App\Models\EnhancedRole::where('name', 'Partner')->first();
            if (!$partnerRole) {
                // Fallback to a default role if Partner role doesn't exist
                $partnerRole = \App\Models\EnhancedRole::where('is_default', true)->first();
            }

            // Get system user ID for registration tracking
            $systemUser = \App\Models\EnhancedUser::where('email', 'system@bikolpo.com')->first();
            $systemUserId = $systemUser ? $systemUser->id : null;

            // Create user with all required fields
            $user = \App\Models\EnhancedUser::create([
                'name' => $registrationData['name'],
                'email' => $email,
                'password' => Hash::make($registrationData['password']),
                'role' => $partnerRole ? $partnerRole->name : 'Partner',
                'role_id' => $partnerRole ? $partnerRole->id : null,
                'status' => 'active',
                'partner_id' => $partner->id,
                'email_verified_at' => now(), // Mark as verified since OTP is verified
                'created_by' => $systemUserId, // Web Registration System
                'updated_by' => $systemUserId,
            ]);

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
            
            // Log the error for debugging
            \Log::error('Partner registration failed: ' . $e->getMessage(), [
                'email' => $email,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            // Clear session data
            $request->session()->forget(['registration_email', 'registration_data']);
            
            // Check if it's a duplicate email error
            if (str_contains($e->getMessage(), 'Duplicate entry') && str_contains($e->getMessage(), 'email')) {
                return redirect()->route('register')->withErrors([
                    'email' => 'This email address is already registered. Please use a different email address or try logging in.'
                ]);
            }
            
            // Generic error message for other issues
            return redirect()->route('register')->withErrors([
                'email' => 'Registration failed due to a technical issue. Please try again or contact support if the problem persists.'
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
