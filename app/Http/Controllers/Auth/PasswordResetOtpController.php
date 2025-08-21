<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class PasswordResetOtpController extends Controller
{
    /**
     * Display the password reset OTP request view.
     */
    public function create()
    {
        return view('auth.forgot-password-otp');
    }

    /**
     * Handle an incoming password reset OTP request.
     */
    public function store(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email'],
        ]);

        // Check if user exists
        $user = User::where('email', $request->email)->first();
        
        if (!$user) {
            // Don't reveal if user exists or not for security
            return back()->with('status', 'If your email address exists in our database, you will receive a password recovery OTP at your email address in a few minutes.');
        }

        // Generate OTP
        $otp = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);
        
        // Store reset data in session for OTP verification
        $resetData = [
            'email' => $request->email,
            'otp' => $otp,
            'otp_expires_at' => now()->addMinutes(10), // OTP expires in 10 minutes
            'reset_token' => Str::random(64), // Generate a unique token for security
        ];
        
        Session::put('password_reset_otp', $resetData);
        
        // Send OTP email
        try {
            Mail::send('emails.password-reset-otp', ['otp' => $otp, 'name' => $user->name ?? 'User'], function ($message) use ($request) {
                $message->to($request->email)
                    ->subject('Password Reset OTP - বিকল্প কম্পিউটার')
                    ->from('bikolpo247@gmail.com', 'বিকল্প কম্পিউটার');
            });

            Log::info('Password reset OTP sent successfully', ['email' => $request->email]);
            
            return redirect()->route('password.verify-otp')
                ->with('status', 'OTP has been sent to your email address. Please check your inbox and enter the OTP to reset your password.');
        } catch (\Exception $e) {
            Log::error('Failed to send password reset OTP email', ['email' => $request->email, 'error' => $e->getMessage()]);
            
            return back()->withErrors(['email' => 'Failed to send OTP. Please try again later.']);
        }
    }

    /**
     * Display the OTP verification form.
     */
    public function showOtpVerificationForm()
    {
        if (!Session::has('password_reset_otp')) {
            return redirect()->route('password.request');
        }

        return view('auth.verify-password-reset-otp');
    }

    /**
     * Verify OTP and show password reset form.
     */
    public function verifyOtp(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'otp' => 'required|string|size:6',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $resetData = Session::get('password_reset_otp');
        
        if (!$resetData) {
            return redirect()->route('password.request')
                ->withErrors(['otp' => 'Password reset session expired. Please try again.']);
        }

        // Check if OTP is expired
        if (now()->isAfter($resetData['otp_expires_at'])) {
            Session::forget('password_reset_otp');
            return redirect()->route('password.request')
                ->withErrors(['otp' => 'OTP has expired. Please request a new one.']);
        }

        // Verify OTP
        if ($request->otp !== $resetData['otp']) {
            return redirect()->back()
                ->withErrors(['otp' => 'Invalid OTP. Please check and try again.'])
                ->withInput();
        }

        // OTP verified, show password reset form
        Session::put('password_reset_verified', true);
        
        Log::info('OTP verified successfully for password reset', ['email' => $resetData['email']]);
        
        return redirect()->route('password.reset-form')
            ->with('status', 'OTP verified successfully. Please enter your new password.');
    }

    /**
     * Display the password reset form.
     */
    public function showResetForm()
    {
        if (!Session::get('password_reset_verified')) {
            return redirect()->route('password.request');
        }

        $resetData = Session::get('password_reset_otp');
        return view('auth.reset-password-otp', ['email' => $resetData['email'] ?? '']);
    }

    /**
     * Handle the password reset.
     */
    public function resetPassword(Request $request)
    {
        Log::info('Password reset request received', [
            'email' => $request->email,
            'has_password' => !empty($request->password),
            'has_confirmation' => !empty($request->password_confirmation),
            'session_verified' => Session::get('password_reset_verified'),
            'session_has_reset_data' => Session::has('password_reset_otp')
        ]);

        if (!Session::get('password_reset_verified')) {
            Log::error('Password reset not verified', ['email' => $request->email]);
            return redirect()->route('password.request');
        }

        $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'confirmed', 'min:8'],
        ]);

        $resetData = Session::get('password_reset_otp');
        
        Log::info('Reset data from session', [
            'has_reset_data' => !empty($resetData),
            'reset_email' => $resetData['email'] ?? 'none',
            'request_email' => $request->email,
            'emails_match' => $resetData['email'] === $request->email
        ]);
        
        if (!$resetData || $resetData['email'] !== $request->email) {
            Log::error('Invalid reset session', [
                'reset_data' => $resetData,
                'request_email' => $request->email
            ]);
            return redirect()->route('password.request')
                ->withErrors(['email' => 'Invalid reset session. Please try again.']);
        }

        // Find and update user
        $user = User::where('email', $request->email)->first();
        
        if (!$user) {
            Log::error('User not found for password reset', ['email' => $request->email]);
            return redirect()->route('password.request')
                ->withErrors(['email' => 'User not found.']);
        }

        Log::info('Attempting to reset password', [
            'email' => $request->email,
            'user_id' => $user->id,
            'old_password_hash' => substr($user->password, 0, 20) . '...'
        ]);

        try {
            DB::beginTransaction();

            // Update password
            $user->forceFill([
                'password' => Hash::make($request->password),
                'remember_token' => Str::random(60),
            ])->save();

            DB::commit();

            Log::info('Password reset successfully', [
                'email' => $request->email,
                'user_id' => $user->id,
                'new_password_hash' => substr($user->password, 0, 20) . '...'
            ]);

            // Clear session data
            Session::forget('password_reset_otp');
            Session::forget('password_reset_verified');

            return redirect()->route('login')
                ->with('status', 'Your password has been reset successfully. You can now login with your new password.');

        } catch (\Exception $e) {
            DB::rollBack();
            
            Log::error('Failed to reset password', [
                'email' => $request->email,
                'user_id' => $user->id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return redirect()->route('password.request')
                ->withErrors(['email' => 'Failed to reset password. Please try again later.']);
        }
    }

    /**
     * Resend OTP.
     */
    public function resendOtp(Request $request)
    {
        if (!Session::has('password_reset_otp')) {
            return redirect()->route('password.request');
        }

        $resetData = Session::get('password_reset_otp');
        
        // Generate new OTP
        $otp = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);
        
        // Update session with new OTP
        $resetData['otp'] = $otp;
        $resetData['otp_expires_at'] = now()->addMinutes(10);
        
        Session::put('password_reset_otp', $resetData);

        // Send new OTP email
        try {
            $user = User::where('email', $resetData['email'])->first();
            
            Mail::send('emails.password-reset-otp', ['otp' => $otp, 'name' => $user->name ?? 'User'], function ($message) use ($resetData) {
                $message->to($resetData['email'])
                    ->subject('Password Reset OTP - বিকল্প কম্পিউটার')
                    ->from('bikolpo247@gmail.com', 'বিকল্প কম্পিউটার');
            });

            return back()->with('status', 'New OTP has been sent to your email address.');
        } catch (\Exception $e) {
            Log::error('Failed to resend password reset OTP', ['email' => $resetData['email'], 'error' => $e->getMessage()]);
            
            return back()->withErrors(['otp' => 'Failed to resend OTP. Please try again later.']);
        }
    }
}
