@extends('layouts.public')

@section('title', 'Verify OTP - BikolpoLive')

@section('content')
<div class="min-h-screen flex items-center justify-center px-4 py-8 sm:px-6 lg:px-8">
  <div class="w-full max-w-4xl bg-white dark:bg-gray-800 rounded-3xl shadow-2xl overflow-hidden">
    <div class="flex flex-col lg:flex-row">
      <!-- Left Panel - Information -->
      <div class="lg:w-2/5 bg-gradient-to-br from-primaryGreen to-green-600 p-6 text-white flex flex-col justify-center">
        <div class="text-center mb-6">
          <div class="inline-flex items-center justify-center w-16 h-16 bg-white/20 rounded-2xl shadow-lg mb-4">
            <i class="fas fa-shield-check text-white text-2xl"></i>
          </div>
          <h2 class="text-2xl font-bold mb-3">Email Verification</h2>
          <p class="text-white/90">
            Protecting your account with secure verification
          </p>
        </div>
        
        <div class="space-y-5">
          <div class="flex items-start space-x-3">
            <div class="mt-1 w-7 h-7 bg-white/20 rounded-full flex items-center justify-center flex-shrink-0">
              <i class="fas fa-lock text-xs"></i>
            </div>
            <div>
              <h3 class="font-semibold">Secure Access</h3>
              <p class="text-white/80 text-sm">Ensures only you can access your account</p>
            </div>
          </div>
          
          <div class="flex items-start space-x-3">
            <div class="mt-1 w-7 h-7 bg-white/20 rounded-full flex items-center justify-center flex-shrink-0">
              <i class="fas fa-envelope text-xs"></i>
            </div>
            <div>
              <h3 class="font-semibold">Email Confirmation</h3>
              <p class="text-white/80 text-sm">Verifies your email address is valid</p>
            </div>
          </div>
          
          <div class="flex items-start space-x-3">
            <div class="mt-1 w-7 h-7 bg-white/20 rounded-full flex items-center justify-center flex-shrink-0">
              <i class="fas fa-shield-alt text-xs"></i>
            </div>
            <div>
              <h3 class="font-semibold">Account Protection</h3>
              <p class="text-white/80 text-sm">Adds an extra layer of security to your account</p>
            </div>
          </div>
        </div>
      </div>
      
      <!-- Right Panel - OTP Verification Form -->
      <div class="lg:w-3/5 p-6">
        <div class="text-center mb-6">
          <h1 class="text-2xl font-bold text-gray-900 dark:text-white mb-2">
            Verify Your Email
          </h1>
          <p class="text-gray-600 dark:text-gray-400">
            We've sent a 6-digit verification code to
          </p>
          <p class="text-lg font-semibold text-primaryGreen dark:text-green-400 mt-1">
            {{ $email }}
          </p>
        </div>

        <!-- OTP Verification Form -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg overflow-hidden">
          <div class="p-6">
            <div class="text-center mb-6">
              <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-1">Enter Verification Code</h3>
              <p class="text-gray-600 dark:text-gray-400">Please check your email and enter the code below</p>
            </div>

            <!-- OTP Form -->
            <form action="{{ route('otp.verify') }}" method="POST" class="space-y-5">
              @csrf
              <input type="hidden" name="email" value="{{ $email }}">
              
              <!-- OTP Input -->
              <div>
                <label class="block text-sm font-semibold text-gray-700 dark:text-gray-200 mb-1">
                  Verification Code <span class="text-red-500">*</span>
                </label>
                <input type="text" name="otp" required 
                  placeholder="Enter 6-digit code"
                  maxlength="6"
                  class="w-full px-4 py-3 text-center text-2xl font-bold tracking-widest rounded-xl border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white placeholder-gray-500 dark:placeholder-gray-400 focus:ring-2 focus:ring-primaryGreen focus:border-transparent transition-all duration-200" />
                @error('otp')
                  <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                @enderror
              </div>

              <!-- Submit Button -->
              <div class="pt-2">
                <button type="submit"
                  class="w-full py-3 px-4 bg-gradient-to-r from-primaryGreen to-green-600 hover:from-green-600 hover:to-green-700 text-white font-bold rounded-xl shadow-lg hover:shadow-xl focus:ring-2 focus:ring-offset-2 focus:ring-primaryGreen transition-all duration-300 transform hover:-translate-y-0.5">
                  <i class="fas fa-check mr-2"></i>
                  Verify & Complete Registration
                </button>
              </div>
            </form>

            <!-- Resend OTP -->
            <div class="mt-6 text-center">
              <p class="text-gray-600 dark:text-gray-400 mb-3">
                Didn't receive the code?
              </p>
              <form action="{{ route('otp.resend') }}" method="POST" class="inline">
                @csrf
                <input type="hidden" name="email" value="{{ $email }}">
                <button type="submit" 
                  class="inline-flex items-center text-primaryGreen dark:text-green-400 font-semibold hover:text-green-600 dark:hover:text-green-300 transition-colors duration-200">
                  <i class="fas fa-redo mr-2"></i>
                  Resend Code
                </button>
              </form>
            </div>

            <!-- Back to Registration -->
            <div class="text-center mt-6 pt-4 border-t border-gray-200 dark:border-gray-700">
              <p class="text-gray-600 dark:text-gray-400 mb-2">
                Need to change your email?
              </p>
              <a href="{{ route('register') }}" 
                 class="inline-flex items-center text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-200 transition-colors duration-200">
                <i class="fas fa-arrow-left mr-2"></i>
                Back to Registration
              </a>
            </div>
          </div>
        </div>

        <!-- Help Text -->
        <div class="text-center mt-6">
          <div class="bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-xl p-4">
            <div class="flex items-start space-x-3">
              <i class="fas fa-info-circle text-blue-500 mt-1"></i>
              <div class="text-left">
                <h4 class="font-semibold text-blue-800 dark:text-blue-200 mb-1">Verification Code</h4>
                <p class="text-sm text-blue-700 dark:text-blue-300">
                  The verification code is valid for 10 minutes. If you don't receive it, check your spam folder or request a new code.
                </p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- JavaScript for OTP Input -->
<script>
  document.addEventListener('DOMContentLoaded', function() {
    // Auto-focus OTP input
    const otpInput = document.querySelector('input[name="otp"]');
    if (otpInput) {
      otpInput.focus();

      // Auto-format OTP input (only allow numbers)
      otpInput.addEventListener('input', function(e) {
        this.value = this.value.replace(/[^0-9]/g, '');
      });
    }
  });
</script>
@endsection