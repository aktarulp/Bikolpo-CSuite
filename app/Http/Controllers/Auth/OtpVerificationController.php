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

        try {
            DB::beginTransaction();

            // Create user
            $user = User::create([
                'name' => $registrationData['name'],
                'email' => $email,
                'password' => Hash::make($registrationData['password']),
                'role' => 'partner',
                'email_verified_at' => now(), // Mark as verified since OTP is verified
            ]);

            // Create partner
            $partner = Partner::create([
                'name' => $registrationData['name'],
                'email' => $email,
                'user_id' => $user->id,
                'status' => 'active',
                'flag' => 'active',
            ]);

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
            dd($e);
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
