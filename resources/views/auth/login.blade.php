@extends('layouts.public')

@section('title', 'Login | Bikolpo Live')

@section('content')
<div class="min-h-screen flex items-center justify-center px-4 py-2 sm:px-6 lg:px-8">
  <div class="w-full max-w-4xl bg-white dark:bg-gray-800 rounded-3xl shadow-2xl overflow-hidden">
    <div class="flex flex-col lg:flex-row">
      <!-- Left Panel - Information -->
      <div class="lg:w-2/5 bg-gradient-to-br from-primaryBlue to-primaryPurple p-5 text-white flex flex-col justify-center">
        <div class="text-center mb-5">
          <div class="inline-flex items-center justify-center w-14 h-14 bg-white/20 rounded-2xl shadow-lg mb-3">
            <i class="fas fa-sign-in-alt text-white text-xl"></i>
          </div>
          <h2 class="text-xl font-bold mb-2">Welcome Back</h2>
          <p class="text-white/90 text-sm">
            Sign in to access your dashboard and continue your journey
          </p>
        </div>
        
        <div class="space-y-4">
          <div class="flex items-start space-x-2">
            <div class="mt-1 w-6 h-6 bg-white/20 rounded-full flex items-center justify-center flex-shrink-0">
              <i class="fas fa-tachometer-alt text-xs"></i>
            </div>
            <div>
              <h3 class="font-semibold text-sm">Dashboard Access</h3>
              <p class="text-white/80 text-xs">Manage your account and settings</p>
            </div>
          </div>
          
          <div class="flex items-start space-x-2">
            <div class="mt-1 w-6 h-6 bg-white/20 rounded-full flex items-center justify-center flex-shrink-0">
              <i class="fas fa-users text-xs"></i>
            </div>
            <div>
              <h3 class="font-semibold text-sm">Student Management</h3>
              <p class="text-white/80 text-xs">Create and manage student accounts</p>
            </div>
          </div>
          
          <div class="flex items-start space-x-2">
            <div class="mt-1 w-6 h-6 bg-white/20 rounded-full flex items-center justify-center flex-shrink-0">
              <i class="fas fa-chart-line text-xs"></i>
            </div>
            <div>
              <h3 class="font-semibold text-sm">Performance Tracking</h3>
              <p class="text-white/80 text-xs">Monitor progress with analytics</p>
            </div>
          </div>
        </div>
      </div>
      
      <!-- Right Panel - Login Form -->
      <div class="lg:w-3/5 p-5">
        <div class="text-center mb-5">
          <h1 class="text-xl font-bold text-gray-900 dark:text-white mb-1">
            Sign In to Your Account
          </h1>
          <p class="text-gray-600 dark:text-gray-400 text-sm">
            Enter your credentials to access your dashboard
          </p>
        </div>

        <!-- Login Form -->
        <form method="POST" action="{{ route('login') }}" class="space-y-4" id="loginForm">
          @csrf
          
          <!-- Hidden input for login type - will be set automatically -->
          <input type="hidden" name="login_type" value="auto" id="loginTypeInput">
        
          <!-- Email/Phone Input -->
          <div>
            <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1">
              Email Address or Phone Number
            </label>
            <div class="relative">
              <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <svg class="h-4 w-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" id="inputIcon">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"/>
                </svg>
              </div>
              <input type="text" name="login_credential" id="loginInput" required 
                class="w-full pl-8 pr-3 py-2 rounded-lg border border-gray-300 dark:border-gray-600 focus:ring-2 focus:ring-primaryBlue/30 focus:border-primaryBlue dark:focus:border-primaryBlue bg-white dark:bg-gray-700 text-gray-900 dark:text-white placeholder-gray-500 dark:placeholder-gray-400 transition-all duration-200 text-sm" 
                placeholder="Enter your email or phone number"
                value="{{ old('login_credential', old('email', old('phone'))) }}">
            </div>
            @error('email')
              <p class="mt-1 text-xs text-red-600 flex items-center">
                <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                  <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                </svg>
                {{ $message }}
              </p>
            @enderror
            @error('phone')
              <p class="mt-1 text-xs text-red-600 flex items-center">
                <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                  <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                </svg>
                {{ $message }}
              </p>
            @enderror
            @error('login_credential')
              <p class="mt-1 text-xs text-red-600 flex items-center">
                <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                  <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                </svg>
                {{ $message }}
              </p>
            @enderror
          </div>
        
          <!-- Password Input -->
          <div>
            <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1">Password</label>
            <div class="relative">
              <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <svg class="h-4 w-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                </svg>
              </div>
              <input type="password" name="password" required 
                class="w-full pl-8 pr-3 py-2 rounded-lg border border-gray-300 dark:border-gray-600 focus:ring-2 focus:ring-primaryBlue/30 focus:border-primaryBlue dark:focus:border-primaryBlue bg-white dark:bg-gray-700 text-gray-900 dark:text-white placeholder-gray-500 dark:placeholder-gray-400 transition-all duration-200 text-sm" 
                placeholder="Enter your password">
            </div>
            @error('password')
              <p class="mt-1 text-xs text-red-600 flex items-center">
                <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                  <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                </svg>
                {{ $message }}
              </p>
            @enderror
          </div>
          
          <!-- Remember Me and Forgot Password -->
          <div class="flex items-center justify-between text-xs">
            <label class="flex items-center cursor-pointer group">
              <input type="checkbox" name="remember" class="w-3 h-3 text-primaryBlue border-gray-300 rounded focus:ring-primaryBlue/20 focus:ring-2">
              <span class="ml-1.5 text-gray-700 dark:text-gray-300 group-hover:text-gray-900 dark:group-hover:text-white transition-colors duration-200">Remember me</span>
            </label>
            @if (Route::has('password.request'))
              <a href="{{ route('password.request') }}" class="text-primaryBlue hover:text-primaryBlue/80 hover:underline transition-colors duration-200">
                Forgot password?
              </a>
            @endif
          </div>

          <!-- Submit Button -->
          <div class="pt-1">
            <button type="submit" 
              class="w-full py-2.5 px-4 bg-gradient-to-r from-primaryBlue to-primaryPurple hover:from-primaryBlue/90 hover:to-primaryPurple/90 text-white font-bold rounded-lg shadow-md hover:shadow-lg transform hover:-translate-y-0.5 transition-all duration-300 overflow-hidden text-sm">
              <span class="relative flex items-center justify-center">
                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/>
                </svg>
                Sign In
              </span>
            </button>
          </div>
        </form>

        <!-- Registration Link -->
        <div class="text-center mt-5 pt-3 border-t border-gray-200/50 dark:border-gray-700/50">
          <p class="text-gray-600 dark:text-gray-300 text-xs mb-2">
            Don't have an account?
          </p>
          <a href="{{ route('register') }}" class="inline-flex items-center px-3 py-2 bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-200 hover:text-gray-800 dark:hover:text-white rounded-lg border border-gray-200 dark:border-gray-600 hover:border-gray-300 dark:hover:border-gray-500 transition-all duration-200 font-medium text-xs">
            <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/>
            </svg>
            Create Account
          </a>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Keep existing scripts -->
<script>
  // Removed back-to-top inline script to avoid global redeclaration conflicts on login page
</script>
@endsection