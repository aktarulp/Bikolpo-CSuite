<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Partner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;

class PartnerRegistrationController extends Controller
{
    public function showRegistrationForm()
    {
        return view('auth.partner.register');
    }

    public function register(Request $request)
    {
        Log::info('Partner registration attempt', ['request_data' => $request->except(['password', 'password_confirmation'])]);
        
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'phone' => 'required|string|max:20|unique:users',
            'organization_name' => 'required|string|max:255',
            'organization_type' => 'required|string|in:coaching_center,school,college,university,training_institute,other',
            'address' => 'required|string|max:500',
            'city' => 'required|string|max:100',
            'state' => 'required|string|max:100',
            'postal_code' => 'required|string|max:20',
            'country' => 'required|string|max:100',
            'password' => 'required|string|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Generate OTP
        $otp = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);
        
        // Store registration data in session for OTP verification
        $sessionData = [
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'organization_name' => $request->organization_name,
            'organization_type' => $request->organization_type,
            'address' => $request->address,
            'city' => $request->city,
            'state' => $request->state,
            'postal_code' => $request->postal_code,
            'country' => $request->country,
            'password' => $request->password,
            'otp' => $otp,
            'otp_expires_at' => now()->addMinutes(10), // OTP expires in 10 minutes
        ];
        
        Session::put('partner_registration', $sessionData);
        
        // Debug: Log session data
        Log::info('Session data stored', [
            'session_data' => $sessionData, 
            'session_id' => $request->session()->getId(),
            'session_driver' => config('session.driver'),
            'session_lifetime' => config('session.lifetime')
        ]);
        
        // Verify session was stored
        if (!Session::has('partner_registration')) {
            Log::error('Failed to store session data');
            return redirect()->back()
                ->withErrors(['email' => 'Failed to store registration data. Please try again.'])
                ->withInput();
        }
        
        // Force session save
        $request->session()->save();
        
        // Additional verification
        Log::info('Session verification after save', [
            'session_id' => $request->session()->getId(),
            'has_partner_registration' => Session::has('partner_registration'),
            'session_data_after_save' => Session::get('partner_registration') ? 'exists' : 'missing'
        ]);

        // Send OTP email
        try {
            Log::info('Attempting to send OTP email', ['email' => $request->email, 'otp' => $otp]);
            
            Mail::send('emails.partner-otp', ['otp' => $otp, 'name' => $request->name], function ($message) use ($request) {
                $message->to($request->email)
                    ->subject('Partner Registration OTP - বিকল্প কম্পিউটার')
                    ->from('bikolpo247@gmail.com', 'বিকল্প কম্পিউটার');
            });

            Log::info('Partner registration OTP sent successfully', ['email' => $request->email]);
            
            return redirect()->route('partner.verify-otp')
                ->with('success', 'OTP has been sent to your email address. Please check your inbox and enter the OTP to complete registration.');
        } catch (\Exception $e) {
            Log::error('Failed to send OTP email', ['email' => $request->email, 'error' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
            
            return redirect()->back()
                ->withErrors(['email' => 'Failed to send OTP: ' . $e->getMessage()])
                ->withInput();
        }
    }

    public function showOtpVerificationForm()
    {
        Log::info('OTP verification form accessed', [
            'session_id' => request()->session()->getId(),
            'has_partner_registration' => Session::has('partner_registration'),
            'session_data' => Session::get('partner_registration') ? 'exists' : 'missing'
        ]);
        
        if (!Session::has('partner_registration')) {
            Log::error('No partner registration session found when accessing OTP form');
            return redirect()->route('partner.register');
        }

        return view('auth.partner.verify-otp');
    }

    public function verifyOtp(Request $request)
    {
        Log::info('OTP verification attempt', [
            'otp' => $request->otp, 
            'session_id' => $request->session()->getId(),
            'has_partner_registration_session' => Session::has('partner_registration')
        ]);
        
        $validator = Validator::make($request->all(), [
            'otp' => 'required|string|size:6',
        ]);

        if ($validator->fails()) {
            Log::error('OTP validation failed', ['errors' => $validator->errors()]);
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $registrationData = Session::get('partner_registration');
        
        // Debug: Log session data retrieval
        Log::info('Session data retrieved', [
            'has_data' => !empty($registrationData), 
            'session_id' => $request->session()->getId(),
            'session_data_keys' => $registrationData ? array_keys($registrationData) : [],
            'session_data_sample' => $registrationData ? array_slice($registrationData, 0, 3) : []
        ]);

        if (!$registrationData) {
            Log::error('No registration data found in session');
            return redirect()->route('partner.register')
                ->withErrors(['otp' => 'Registration session expired. Please register again.']);
        }

        // Check if OTP is expired
        if (now()->isAfter($registrationData['otp_expires_at'])) {
            Log::error('OTP expired', ['otp_expires_at' => $registrationData['otp_expires_at'], 'current_time' => now()]);
            Session::forget('partner_registration');
            return redirect()->route('partner.register')
                ->withErrors(['otp' => 'OTP has expired. Please register again.']);
        }

        // Verify OTP
        if ($request->otp !== $registrationData['otp']) {
            Log::error('Invalid OTP', [
                'provided_otp' => $request->otp, 
                'expected_otp' => $registrationData['otp'],
                'otp_match' => $request->otp === $registrationData['otp']
            ]);
            return redirect()->back()
                ->withErrors(['otp' => 'Invalid OTP. Please check and try again.'])
                ->withInput();
        }

        Log::info('OTP verified successfully, creating user and partner accounts');

        // Create user and partner
        try {
            \DB::beginTransaction();

            // Debug: Log the data being used to create user
            Log::info('Creating user with data', [
                'name' => $registrationData['name'],
                'email' => $registrationData['email'],
                'phone' => $registrationData['phone'],
                'role' => 'partner',
                'has_password' => !empty($registrationData['password'])
            ]);

            // Create user with email verified since OTP was sent to email
            $user = User::create([
                'name' => $registrationData['name'],
                'email' => $registrationData['email'],
                'phone' => $registrationData['phone'],
                'password' => Hash::make($registrationData['password']),
                'role' => 'partner',
                'email_verified_at' => now(), // Mark as verified since OTP was sent to email
            ]);
            
            Log::info('User created successfully', [
                'user_id' => $user->id,
                'user_email' => $user->email,
                'user_role' => $user->role,
                'user_exists_in_db' => User::find($user->id) ? 'yes' : 'no'
            ]);

            // Create partner
            $partner = Partner::create([
                'user_id' => $user->id,
                'organization_name' => $registrationData['organization_name'],
                'organization_type' => $registrationData['organization_type'],
                'address' => $registrationData['address'],
                'city' => $registrationData['city'],
                'state' => $registrationData['state'],
                'postal_code' => $registrationData['postal_code'],
                'country' => $registrationData['country'],
                'status' => 'active',
            ]);
            
            Log::info('Partner created successfully', [
                'partner_id' => $partner->id,
                'user_id' => $partner->user_id,
                'organization_name' => $partner->organization_name,
                'partner_exists_in_db' => Partner::find($partner->id) ? 'yes' : 'no'
            ]);

            \DB::commit();

            Log::info('Partner registration completed successfully', ['user_id' => $user->id, 'email' => $user->email]);
            
            // Verify user exists in database
            $freshUser = User::find($user->id);
            if (!$freshUser) {
                Log::error('User not found in database after creation');
                return redirect()->back()
                    ->withErrors(['otp' => 'User creation failed. Please try again.']);
            }
            
            Log::info('User verified in database', [
                'user_id' => $freshUser->id,
                'user_role' => $freshUser->role,
                'user_email' => $freshUser->email
            ]);

            // Auto-login the user
            auth()->login($user);
            
            // Debug: Log authentication status
            Log::info('User authentication status', [
                'user_id' => $user->id,
                'is_authenticated' => auth()->check(),
                'authenticated_user_id' => auth()->id(),
                'user_role' => $user->role,
                'auth_guard' => config('auth.defaults.guard'),
                'session_user_id' => $request->session()->get('user_id')
            ]);
            
            // Ensure user is authenticated before redirecting
            if (!auth()->check()) {
                Log::error('User authentication failed after login attempt');
                return redirect()->back()
                    ->withErrors(['otp' => 'Authentication failed. Please try logging in manually.']);
            }
            
            // Store user info in session for verification
            $request->session()->put('user_id', $user->id);
            $request->session()->put('user_role', $user->role);
            
            Log::info('Session data stored', [
                'session_user_id' => $request->session()->get('user_id'),
                'session_user_role' => $request->session()->get('user_role')
            ]);

            // Clear session after successful registration
            Session::forget('partner_registration');
            
            // Log before redirect
            Log::info('About to redirect to success page', [
                'route_name' => 'partner.registration.success',
                'route_url' => route('partner.registration.success'),
                'user_authenticated' => auth()->check(),
                'session_id' => $request->session()->getId()
            ]);
            
            // Redirect to success page first, then user can navigate to dashboard
            return redirect()->route('partner.registration.success')
                ->with('success', 'Registration completed successfully! Welcome to বিকল্প কম্পিউটার.');

        } catch (\Exception $e) {
            \DB::rollBack();
            Log::error('Failed to create partner account', ['error' => $e->getMessage()]);

            return redirect()->back()
                ->withErrors(['otp' => 'Registration failed. Please try again.'])
                ->withInput();
        }
    }

    public function showRegistrationSuccess()
    {
        return view('auth.partner.registration-success');
    }

    public function resendOtp()
    {
        $registrationData = Session::get('partner_registration');

        if (!$registrationData) {
            return redirect()->route('partner.register')
                ->withErrors(['email' => 'Registration session expired. Please register again.']);
        }

        // Generate new OTP
        $otp = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);
        
        // Update session with new OTP
        $registrationData['otp'] = $otp;
        $registrationData['otp_expires_at'] = now()->addMinutes(10);
        Session::put('partner_registration', $registrationData);

        // Send new OTP email
        try {
            Mail::send('emails.partner-otp', ['otp' => $otp, 'name' => $registrationData['name']], function ($message) use ($registrationData) {
                $message->to($registrationData['email'])
                    ->subject('New Partner Registration OTP - বিকল্প কম্পিউটার')
                    ->from('bikolpo247@gmail.com', 'বিকল্প কম্পিউটার');
            });

            Log::info('Partner registration OTP resent', ['email' => $registrationData['email']]);
            
            return redirect()->back()
                ->with('success', 'New OTP has been sent to your email address.');
        } catch (\Exception $e) {
            Log::error('Failed to resend OTP email', ['email' => $registrationData['email'], 'error' => $e->getMessage()]);
            
            return redirect()->back()
                ->withErrors(['otp' => 'Failed to send new OTP. Please try again.']);
        }
    }
}
