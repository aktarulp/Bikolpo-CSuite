<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\EnhancedRole;
use App\Models\EnhancedUser;
use App\Models\Partner;
use App\Models\VerificationCode;
use App\Providers\RouteServiceProvider;
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
        return view('auth.Partner-Register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $isPartnerRegistration = $request->has('is_partner_registration');

        $rules = [
            'organization_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:ac_users,email'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ];

        $messages = [
            'email.unique' => 'This email address is already registered. Please use a different email address or try logging in.',
            'organization_name.required' => 'Organization Name is required.',
            'email.required' => 'Email Address is required.',
            'email.email' => 'Please enter a valid email address.',
            'password.required' => 'Password is required.',
            'password.confirmed' => 'Password confirmation does not match.',
        ];

        if ($isPartnerRegistration) {
            // These fields are now directly in the form, so no need for conditional rules here
            // $rules['phone'] = ['required', 'string', 'max:20'];
            // $rules['address'] = ['required', 'string', 'max:255'];
            // $rules['trade_license'] = ['nullable', 'string', 'max:255'];
            // $rules['tin_number'] = ['nullable', 'string', 'max:255'];
            // $rules['bin_number'] = ['nullable', 'string', 'max:255'];

            // $messages['phone.required'] = 'Phone number is required.';
            // $messages['address.required'] = 'Address is required.';
        }

        $request->validate($rules, $messages);

        $roleName = $isPartnerRegistration ? 'partner_admin' : 'student';
        $role = EnhancedRole::where('name', $roleName)->first();

        $user = \App\Models\EnhancedUser::create([
            'name' => $request->organization_name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role_id' => $role->id,
            'status' => 'active',
        ]);

        if ($isPartnerRegistration) {
            $partner = Partner::create([
                'name' => $request->organization_name,
                'email' => $request->email,
                'status' => 'active',
            ]);
            $user->partner_id = $partner->id;
            $user->save();
        }

        event(new Registered($user));

        // Generate and store verification code
        VerificationCode::generateCode($user->email, 'email_verification');

        // Auth::login($user); // Do not log in automatically, email verification is required

        return redirect()->route('otp.verify')->with('email', $user->email);
    }


}
