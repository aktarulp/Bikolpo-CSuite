@extends('layouts.public')

@section('title', 'Partner Registration - BikolpoLive')

@section('content')
<div class="min-h-screen flex items-center justify-center px-4 py-2 sm:px-6 lg:px-8">
  <div class="w-full max-w-4xl bg-white dark:bg-gray-800 rounded-3xl shadow-2xl overflow-hidden">
    <div class="flex flex-col lg:flex-row">
      <!-- Left Panel - Information -->
      <div class="lg:w-2/5 bg-gradient-to-br from-primaryGreen to-green-600 p-5 text-white flex flex-col justify-center">
        <div class="text-center mb-5">
          <div class="inline-flex items-center justify-center w-14 h-14 bg-white/20 rounded-2xl shadow-lg mb-3">
            <i class="fas fa-handshake text-white text-xl"></i>
          </div>
          <h2 class="text-xl font-bold mb-2">Partner Registration</h2>
          <p class="text-white/90 text-sm">
            Join our network of educational partners and expand your reach
          </p>
        </div>
        
        <div class="space-y-4">
          <div class="flex items-start space-x-2">
            <div class="mt-1 w-6 h-6 bg-white/20 rounded-full flex items-center justify-center flex-shrink-0">
              <i class="fas fa-users text-xs"></i>
            </div>
            <div>
              <h3 class="font-semibold text-sm">Manage Students</h3>
              <p class="text-white/80 text-xs">Create and manage student accounts with ease</p>
            </div>
          </div>
          
          <div class="flex items-start space-x-2">
            <div class="mt-1 w-6 h-6 bg-white/20 rounded-full flex items-center justify-center flex-shrink-0">
              <i class="fas fa-book text-xs"></i>
            </div>
            <div>
              <h3 class="font-semibold text-sm">Create Exams</h3>
              <p class="text-white/80 text-xs">Design and administer exams with our powerful tools</p>
            </div>
          </div>
          
          <div class="flex items-start space-x-2">
            <div class="mt-1 w-6 h-6 bg-white/20 rounded-full flex items-center justify-center flex-shrink-0">
              <i class="fas fa-chart-line text-xs"></i>
            </div>
            <div>
              <h3 class="font-semibold text-sm">Track Progress</h3>
              <p class="text-white/80 text-xs">Monitor student performance with detailed analytics</p>
            </div>
          </div>
        </div>
      </div>
      
      <!-- Right Panel - Registration Form -->
      <div class="lg:w-3/5 p-5">
        <div class="text-center mb-5">
          <h1 class="text-xl font-bold text-gray-900 dark:text-white mb-1">
            Create Your Account
          </h1>
          <p class="text-gray-600 dark:text-gray-400 text-sm">
            Fill in your organization details to get started
          </p>
        </div>

        <form method="POST" action="{{ route('register') }}" class="space-y-4">
          @csrf
          <input type="hidden" name="is_partner_registration" value="1">

          <!-- Organization Name -->
          <div>
            <label for="organization_name" class="block text-sm font-semibold text-gray-700 dark:text-gray-200 mb-1">
              Organization Name <span class="text-red-500">*</span>
            </label>
            <input type="text" id="organization_name" name="organization_name" value="{{ old('organization_name') }}" required autofocus autocomplete="organization_name"
              class="w-full px-3 py-2 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white placeholder-gray-500 dark:placeholder-gray-400 focus:ring-2 focus:ring-primaryGreen focus:border-transparent transition-all duration-200 text-sm" />
            @error('organization_name')
              <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
            @enderror
          </div>

          <!-- Email Address -->
          <div>
            <label for="email" class="block text-sm font-semibold text-gray-700 dark:text-gray-200 mb-1">
              Email Address <span class="text-red-500">*</span>
            </label>
            <input type="email" id="email" name="email" value="{{ old('email') }}" required autocomplete="username"
              class="w-full px-3 py-2 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white placeholder-gray-500 dark:placeholder-gray-400 focus:ring-2 focus:ring-primaryGreen focus:border-transparent transition-all duration-200 text-sm" />
            @error('email')
              <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
            @enderror
          </div>

          <!-- Password -->
          <div>
            <label for="password" class="block text-sm font-semibold text-gray-700 dark:text-gray-200 mb-1">
              Password <span class="text-red-500">*</span>
            </label>
            <div class="relative">
              <input type="password" id="password" name="password" required autocomplete="new-password"
                class="w-full px-3 py-2 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white placeholder-gray-500 dark:placeholder-gray-400 focus:ring-2 focus:ring-primaryGreen focus:border-transparent transition-all duration-200 pr-8 text-sm" />
              <button type="button" class="absolute inset-y-0 right-0 pr-2 flex items-center text-gray-500 dark:text-gray-400" id="togglePassword">
                <i class="fas fa-eye text-xs"></i>
              </button>
            </div>
            @error('password')
              <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
            @enderror
          </div>

          <!-- Confirm Password -->
          <div>
            <label for="password_confirmation" class="block text-sm font-semibold text-gray-700 dark:text-gray-200 mb-1">
              Confirm Password <span class="text-red-500">*</span>
            </label>
            <div class="relative">
              <input type="password" id="password_confirmation" name="password_confirmation" required autocomplete="new-password"
                class="w-full px-3 py-2 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white placeholder-gray-500 dark:placeholder-gray-400 focus:ring-2 focus:ring-primaryGreen focus:border-transparent transition-all duration-200 pr-8 text-sm" />
              <button type="button" class="absolute inset-y-0 right-0 pr-2 flex items-center text-gray-500 dark:text-gray-400" id="togglePasswordConfirmation">
                <i class="fas fa-eye text-xs"></i>
              </button>
            </div>
            @error('password_confirmation')
              <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
            @enderror
          </div>

          <!-- Submit Button -->
          <div class="pt-1">
            <button type="submit"
              class="w-full py-2.5 px-4 bg-gradient-to-r from-primaryGreen to-green-600 hover:from-green-600 hover:to-green-700 text-white font-bold rounded-lg shadow-md hover:shadow-lg focus:ring-2 focus:ring-offset-2 focus:ring-primaryGreen transition-all duration-300 transform hover:-translate-y-0.5 text-sm">
              <i class="fas fa-user-plus mr-1 text-sm"></i>
              Register as Partner
            </button>
          </div>
        </form>

        <!-- Already Registered Link -->
        <div class="mt-5 text-center">
          <p class="text-gray-600 dark:text-gray-400 text-xs">
            Already have an account?
            <a href="{{ route('login') }}" class="text-primaryGreen dark:text-green-400 font-semibold hover:text-green-600 dark:hover:text-green-300 transition-colors duration-200">
              Sign In
            </a>
          </p>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- JavaScript for Password Visibility Toggle -->
<script>
  document.addEventListener('DOMContentLoaded', function() {
    // Password visibility toggle
    const togglePassword = document.querySelector('#togglePassword');
    const password = document.querySelector('#password');
    
    if (togglePassword && password) {
      togglePassword.addEventListener('click', function() {
        const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
        password.setAttribute('type', type);
        this.querySelector('i').classList.toggle('fa-eye');
        this.querySelector('i').classList.toggle('fa-eye-slash');
      });
    }
    
    // Confirm password visibility toggle
    const togglePasswordConfirmation = document.querySelector('#togglePasswordConfirmation');
    const passwordConfirmation = document.querySelector('#password_confirmation');
    
    if (togglePasswordConfirmation && passwordConfirmation) {
      togglePasswordConfirmation.addEventListener('click', function() {
        const type = passwordConfirmation.getAttribute('type') === 'password' ? 'text' : 'password';
        passwordConfirmation.setAttribute('type', type);
        this.querySelector('i').classList.toggle('fa-eye');
        this.querySelector('i').classList.toggle('fa-eye-slash');
      });
    }
  });
</script>
@endsection