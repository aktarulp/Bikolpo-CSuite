<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Models\EnhancedUser;
use App\Models\Student;
use App\Models\EnhancedRole;
use App\Models\VerificationCode;
use App\Services\SmsService;

class PublicStudentRegistrationWithOtpController extends Controller
{
    protected $smsService;

    public function __construct(SmsService $smsService)
    {
        $this->smsService = $smsService;
    }

    /**
     * Show the phone number input form (Step 1)
     */
    public function showPhoneForm()
    {
        return view('public.student-register-step1');
    }

    /**
     * Process phone number and send OTP (Step 1)
     */
    public function sendOtp(Request $request)
    {
        try {
            // Validate phone number
            $validated = $request->validate([
                'phone' => ['required', 'string', 'regex:/^(01[3-9][0-9]{8}|8801[3-9][0-9]{8})$/u', 'unique:students,phone', 'unique:ac_users,phone'],
            ], [
                'phone.required' => 'Phone number is required.',
                'phone.regex' => 'Please enter a valid Bangladeshi phone number (11 digits starting with 01).',
                'phone.unique' => 'This phone number is already registered.',
            ]);

            // Format phone number
            $phoneNumber = $this->formatPhoneNumber($validated['phone']);

            // Generate OTP
            try {
                $verificationCode = VerificationCode::generateCode($phoneNumber, 'student_registration', 'phone');
            } catch (\Exception $e) {
                \Log::error('Failed to generate verification code', [
                    'phone' => $phoneNumber,
                    'error' => $e->getMessage()
                ]);
                throw new \Exception('Failed to generate verification code: ' . $e->getMessage());
            }

            // Send OTP via SMS
            $message = "Your OTP for BikolpoLive student registration is: {$verificationCode->code}. This code is valid for 10 minutes.";
            
            \Log::info('Attempting to send OTP SMS', [
                'phone' => $phoneNumber,
                'otp_code' => $verificationCode->code,
                'message_length' => strlen($message)
            ]);
            
            $smsResult = $this->smsService->sendSms($phoneNumber, $message);

            if (!$smsResult['success']) {
                // Log the error for debugging
                \Log::error('OTP SMS sending failed', [
                    'phone' => $phoneNumber,
                    'error' => $smsResult['message'],
                    'data' => $smsResult['data'] ?? null,
                    'response_status' => $smsResult['data']['status'] ?? 'unknown'
                ]);
                
                // Show specific error message to user
                $errorMessage = $smsResult['message'] ?? 'An error occurred while sending OTP. Please try again.';
                
                // Provide more helpful error message
                if (strpos($errorMessage, 'Insufficient balance') !== false) {
                    $errorMessage = 'SMS service temporarily unavailable. Please try again later.';
                } elseif (strpos($errorMessage, 'API key') !== false || strpos($errorMessage, 'Sender ID') !== false) {
                    $errorMessage = 'SMS service configuration error. Please contact support.';
                }
                
                return back()->withErrors(['phone' => $errorMessage])->withInput();
            }
            
            \Log::info('OTP SMS sent successfully', [
                'phone' => $phoneNumber,
                'verification_code_id' => $verificationCode->id
            ]);

            // Store phone number in session for next steps
            session(['registration_phone' => $phoneNumber]);
            session(['registration_otp_id' => $verificationCode->id]);

            return redirect()->route('public.student.register.otp');

        } catch (\Illuminate\Validation\ValidationException $e) {
            return back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            \Log::error('Error sending OTP: ' . $e->getMessage(), [
                'exception' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'file' => $e->getFile(),
                'line' => $e->getLine()
            ]);
            
            // Return more specific error if it's a validation or known error
            $errorMessage = 'An error occurred while sending OTP. Please try again.';
            if ($e instanceof \Illuminate\Validation\ValidationException) {
                return back()->withErrors($e->errors())->withInput();
            }
            
            return back()->withErrors(['phone' => $errorMessage])->withInput();
        }
    }

    /**
     * Show the OTP verification form (Step 2)
     */
    public function showOtpForm()
    {
        // Check if phone number is in session
        if (!session()->has('registration_phone')) {
            return redirect()->route('public.student.register.phone');
        }

        $phoneNumber = session('registration_phone');
        return view('public.student-register-step2', compact('phoneNumber'));
    }

    /**
     * Verify OTP (Step 2)
     */
    public function verifyOtp(Request $request)
    {
        // Check if phone number is in session
        if (!session()->has('registration_phone') || !session()->has('registration_otp_id')) {
            return redirect()->route('public.student.register.phone');
        }

        try {
            $validated = $request->validate([
                'otp' => 'required|string|size:6',
            ], [
                'otp.required' => 'OTP is required.',
                'otp.size' => 'OTP must be 6 digits.',
            ]);

            $phoneNumber = session('registration_phone');
            $otpId = session('registration_otp_id');

            // Verify OTP
            $verificationCode = VerificationCode::find($otpId);
            
            if (!$verificationCode || !$verificationCode->isValid()) {
                return back()->withErrors(['otp' => 'OTP has expired. Please request a new one.']);
            }

            if ($verificationCode->code !== $validated['otp']) {
                return back()->withErrors(['otp' => 'Invalid OTP. Please try again.']);
            }

            // Mark OTP as used
            $verificationCode->markAsUsed();

            // Store verified phone number in session for next step
            session(['verified_phone' => $phoneNumber]);

            return redirect()->route('public.student.register.password');

        } catch (\Illuminate\Validation\ValidationException $e) {
            return back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            \Log::error('Error verifying OTP: ' . $e->getMessage(), [
                'exception' => $e,
                'trace' => $e->getTraceAsString()
            ]);
            return back()->withErrors(['otp' => 'An error occurred while verifying OTP. Please try again.']);
        }
    }

    /**
     * Show the password setup form (Step 3)
     */
    public function showPasswordForm()
    {
        // Check if phone is verified
        if (!session()->has('verified_phone')) {
            return redirect()->route('public.student.register.phone');
        }

        return view('public.student-register-step3');
    }

    /**
     * Show registration success page
     */
    public function showSuccess(Request $request)
    {
        // Check if registration was successful
        if (!session()->has('registration_success')) {
            return redirect()->route('public.student.register.phone');
        }

        $userEmail = session('registered_email');
        $userName = session('registered_name');

        // Clear success session when page loads
        session()->forget(['registration_success', 'registered_email', 'registered_name']);

        return view('public.student-register-success', [
            'email' => $userEmail ?? '',
            'name' => $userName ?? ''
        ]);
    }

    /**
     * Process password setup and complete registration (Step 3)
     */
    public function completeRegistration(Request $request)
    {
        // Check if phone is verified
        if (!session()->has('verified_phone')) {
            return redirect()->route('public.student.register.phone');
        }

        try {
            $validated = $request->validate([
                'full_name' => 'required|string|max:255',
                'email' => 'required|email|max:255|unique:students,email|unique:ac_users,email',
                'password' => 'required|string|min:8|confirmed',
            ], [
                'full_name.required' => 'Full name is required.',
                'email.required' => 'Email address is required.',
                'email.email' => 'Please enter a valid email address.',
                'email.unique' => 'This email is already registered.',
                'password.required' => 'Password is required.',
                'password.min' => 'Password must be at least 8 characters.',
                'password.confirmed' => 'Password confirmation does not match.',
            ]);

            $phoneNumber = session('verified_phone');

            DB::beginTransaction();

            try {
                // Get the student role
                $studentRole = EnhancedRole::where('name', 'student')->first();
                
                if (!$studentRole) {
                    throw new \Exception("Student role not found");
                }
                
                // Create the student record with null partner_id (system admin ownership)
                $student = new Student();
                $student->full_name = $validated['full_name'];
                $student->email = $validated['email'];
                $student->phone = $phoneNumber;
                $student->partner_id = null; // System admin ownership
                $student->status = 'active';
                $student->enable_login = 'y';
                $student->created_by = 1; // System admin user ID
                // Optional fields - can be updated later in profile
                $student->date_of_birth = null; // Can be added later
                $student->gender = null; // Can be added later
                
                // Save the student
                if (!$student->save()) {
                    throw new \Exception('Failed to save student');
                }
                
                // Create the user account
                $user = new EnhancedUser();
                $user->name = $validated['full_name'];
                $user->email = $validated['email'];
                $user->phone = $phoneNumber;
                $user->password = Hash::make($validated['password']);
                $user->role_id = $studentRole->id;
                $user->role = 'student';
                $user->partner_id = null; // System admin ownership
                $user->status = 'active';
                $user->email_verified_at = now();
                $user->created_by = 1; // System admin user ID
                $user->updated_by = 1; // System admin user ID
                $user->student_id = $student->id; // Link to student record
                
                // Save the user with error handling
                if (!$user->save()) {
                    throw new \Exception('Failed to save user');
                }
                
                // Update the student record to link to the user
                $student->user_id = $user->id;
                $student->save();

                DB::commit();

                // Store registration success in session with user details
                session([
                    'registration_success' => true,
                    'registered_email' => $validated['email'],
                    'registered_name' => $validated['full_name']
                ]);

                // Clear registration session data but keep success data
                session()->forget(['registration_phone', 'registration_otp_id', 'verified_phone']);

                // Redirect to success page
                return redirect()->route('public.student.register.success');

            } catch (\Exception $e) {
                DB::rollBack();
                
                // Handle specific database errors
                if (strpos($e->getMessage(), 'Duplicate entry') !== false) {
                    if (strpos($e->getMessage(), 'students_email_unique') !== false || 
                        strpos($e->getMessage(), 'users_email_unique') !== false) {
                        return back()->withErrors(['email' => 'A user with this email address already exists.'])->withInput();
                    }
                }
                
                \Log::error('Error creating public student registration: ' . $e->getMessage(), [
                    'exception' => $e,
                    'trace' => $e->getTraceAsString()
                ]);
                
                return back()->withErrors(['error' => 'Error creating account. Please try again.'])->withInput();
            }
        } catch (\Illuminate\Validation\ValidationException $e) {
            return back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            \Log::error('Unexpected error creating public student registration: ' . $e->getMessage(), [
                'exception' => $e,
                'trace' => $e->getTraceAsString()
            ]);
            return back()->withErrors(['error' => 'An unexpected error occurred while creating the account. Please try again.'])->withInput();
        }
    }

    /**
     * Resend OTP
     */
    public function resendOtp()
    {
        // Check if phone number is in session
        if (!session()->has('registration_phone')) {
            return redirect()->route('public.student.register.phone');
        }

        try {
            $phoneNumber = session('registration_phone');

            // Generate new OTP
            $verificationCode = VerificationCode::generateCode($phoneNumber, 'student_registration', 'phone');

            // Send OTP via SMS
            $message = "Your OTP for BikolpoLive student registration is: {$verificationCode->code}. This code is valid for 10 minutes.";
            $smsResult = $this->smsService->sendSms($phoneNumber, $message);

            if (!$smsResult['success']) {
                // Log the error for debugging
                \Log::error('OTP SMS resend failed', [
                    'phone' => $phoneNumber,
                    'error' => $smsResult['message'],
                    'data' => $smsResult['data'] ?? null
                ]);
                
                return back()->withErrors(['otp' => 'Failed to resend OTP. Please try again. Error: ' . $smsResult['message']]);
            }

            // Update OTP ID in session
            session(['registration_otp_id' => $verificationCode->id]);

            return back()->with('success', 'OTP has been resent successfully.');

        } catch (\Exception $e) {
            \Log::error('Error resending OTP: ' . $e->getMessage(), [
                'exception' => $e,
                'trace' => $e->getTraceAsString()
            ]);
            return back()->withErrors(['otp' => 'An error occurred while resending OTP. Please try again.']);
        }
    }

    /**
     * Format Bangladeshi phone number
     *
     * @param string $phoneNumber
     * @return string
     */
    protected function formatPhoneNumber($phoneNumber)
    {
        // Remove all non-digit characters
        $phoneNumber = preg_replace('/[^0-9]/', '', $phoneNumber);

        // Handle different formats
        if (strlen($phoneNumber) == 11 && substr($phoneNumber, 0, 2) == '01') {
            // Convert 01xxxxxxxxx to 8801xxxxxxxxx
            return '88' . $phoneNumber;
        } elseif (strlen($phoneNumber) == 13 && substr($phoneNumber, 0, 3) == '880') {
            // Already in correct format
            return $phoneNumber;
        } elseif (strlen($phoneNumber) == 10 && substr($phoneNumber, 0, 1) == '1') {
            // Convert 1xxxxxxxxx to 8801xxxxxxxxx
            return '880' . $phoneNumber;
        }

        // Return as is if no match
        return $phoneNumber;
    }
}