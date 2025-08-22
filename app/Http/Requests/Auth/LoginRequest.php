<?php

namespace App\Http\Requests\Auth;

use Illuminate\Auth\Events\Lockout;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Hash;

class LoginRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $loginType = $this->input('login_type', 'partner');
        
        if ($loginType === 'student') {
            return [
                'phone' => ['required', 'string', 'regex:/^01[3-9][0-9]{8}$/'],
                'password' => ['required', 'string'],
                'login_type' => ['required', 'string', 'in:partner,student'],
            ];
        }
        
        // Default to partner login (email-based)
        return [
            'email' => ['required', 'string', 'email'],
            'password' => ['required', 'string'],
            'login_type' => ['required', 'string', 'in:partner,student'],
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'phone.regex' => 'Phone number must be in format 01XXXXXXXXX (11 digits, starting with 01)',
            'email.email' => 'Please enter a valid email address',
        ];
    }

    /**
     * Attempt to authenticate the request's credentials.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function authenticate(): void
    {
        $this->ensureIsNotRateLimited();

        $loginType = $this->input('login_type', 'partner');
        $credentials = $this->only('password');
        
        if ($loginType === 'student') {
            // Student login with phone
            $identifier = $this->input('phone');
        } else {
            // Partner login with email
            $identifier = $this->input('email');
        }

        // Use custom authentication logic
        $user = \App\Models\User::findByEmailOrPhone($identifier)->first();
        
        if (!$user || !Hash::check($this->input('password'), $user->password)) {
            RateLimiter::hit($this->throttleKey());

            throw ValidationException::withMessages([
                $loginType === 'student' ? 'phone' : 'email' => trans('auth.failed'),
            ]);
        }

        // Manually login the user
        Auth::login($user, $this->boolean('remember'));
        RateLimiter::clear($this->throttleKey());
    }

    /**
     * Ensure the login request is not rate limited.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function ensureIsNotRateLimited(): void
    {
        if (!RateLimiter::tooManyAttempts($this->throttleKey(), 5)) {
            return;
        }

        event(new Lockout($this));

        $seconds = RateLimiter::availableIn($this->throttleKey());

        throw ValidationException::withMessages([
            'email' => trans('auth.throttle', [
                'seconds' => $seconds,
                'minutes' => ceil($seconds / 60),
            ]),
        ]);
    }

    /**
     * Get the rate limiting throttle key for the request.
     */
    public function throttleKey(): string
    {
        $identifier = $this->input('login_type') === 'student' 
            ? $this->string('phone') 
            : $this->string('email');
            
        return Str::transliterate(Str::lower($identifier).'|'.$this->ip());
    }
}
