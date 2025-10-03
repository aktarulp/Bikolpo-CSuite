<?php

namespace App\Http\Requests\Auth;

use Illuminate\Auth\Events\Lockout;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

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
        return [
            'email' => ['nullable', 'string', 'email'],
            'phone' => ['nullable', 'string'],
            'login_credential' => ['nullable', 'string'],
            'password' => ['required', 'string'],
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

        $authenticated = false;
        $fieldName = 'email';
        $lastError = null;

        // Try authentication with multiple methods
        $password = $this->password;
        $remember = $this->boolean('remember');

        // Debug for opt@gg.com
        if ($this->email === 'opt@gg.com') {
            \Log::info('LoginRequest: Attempting authentication for opt@gg.com', [
                'email' => $this->email,
                'password_length' => strlen($password),
                'remember' => $remember,
            ]);
        }

        // Method 1: Try with email if provided
        if ($this->email) {
            $credentials = ['email' => $this->email, 'password' => $password];
            $fieldName = 'email';
            
            // Debug for opt@gg.com
            if ($this->email === 'opt@gg.com') {
                \Log::info('LoginRequest: Trying email authentication', [
                    'credentials' => ['email' => $this->email, 'password' => '[HIDDEN]'],
                ]);
            }
            
            if (Auth::attempt($credentials, $remember)) {
                $authenticated = true;
                if ($this->email === 'opt@gg.com') {
                    \Log::info('LoginRequest: Email authentication SUCCESS for opt@gg.com');
                }
            } else {
                if ($this->email === 'opt@gg.com') {
                    \Log::warning('LoginRequest: Email authentication FAILED for opt@gg.com');
                }
            }
        }

        // Method 2: Try with phone if provided and email failed
        if (!$authenticated && $this->phone) {
            $credentials = ['phone' => $this->phone, 'password' => $password];
            $fieldName = 'phone';
            if (Auth::attempt($credentials, $remember)) {
                $authenticated = true;
            }
        }

        // Method 3: Try with login_credential as email if no specific field worked
        if (!$authenticated && $this->login_credential) {
            // First try as email
            $credentials = ['email' => $this->login_credential, 'password' => $password];
            $fieldName = 'email';
            if (Auth::attempt($credentials, $remember)) {
                $authenticated = true;
            }
            
            // Then try as phone if email failed
            if (!$authenticated) {
                $credentials = ['phone' => $this->login_credential, 'password' => $password];
                $fieldName = 'phone';
                if (Auth::attempt($credentials, $remember)) {
                    $authenticated = true;
                }
            }
        }

        if (!$authenticated) {
            RateLimiter::hit($this->throttleKey());

            throw ValidationException::withMessages([
                $fieldName => trans('auth.failed'),
            ]);
        }

        // Debug: Log successful authentication
        \Log::info('LoginRequest: Authentication successful', [
            'authenticated_user_id' => Auth::user()->id,
            'authenticated_user_role' => Auth::user()->role,
            'authenticated_user_email' => Auth::user()->email ?? 'null',
            'authenticated_user_phone' => Auth::user()->phone ?? 'null',
        ]);

        RateLimiter::clear($this->throttleKey());
    }

    /**
     * Ensure the login request is not rate limited.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function ensureIsNotRateLimited(): void
    {
        if (! RateLimiter::tooManyAttempts($this->throttleKey(), 5)) {
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
        $identifier = $this->email ?? $this->phone ?? $this->login_credential ?? 'unknown';
        return Str::transliterate(Str::lower($identifier).'|'.$this->ip());
    }
}
