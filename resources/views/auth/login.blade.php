<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login | Bikolpo-LQ</title>
  
  <!-- Favicon -->
  <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
  <link rel="shortcut icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
  
  @vite(['resources/css/app.css', 'resources/js/app.js'])
  
  <script>
    // Ensure backToTopBtn is only declared once
    if (typeof backToTopBtn === 'undefined') {
      var backToTopBtn = document.getElementById('back-to-top');
      if (backToTopBtn) {
        window.addEventListener('scroll', function() {
          if (window.pageYOffset > 300) {
            backToTopBtn.classList.add('block');
            backToTopBtn.classList.remove('hidden');
          } else {
            backToTopBtn.classList.add('hidden');
            backToTopBtn.classList.remove('block');
          }
        });

        backToTopBtn.addEventListener('click', function(e) {
          e.preventDefault();
          window.scrollTo({
            top: 0,
            behavior: 'smooth'
          });
        });
      }
    }
  </script>
  <link href="https://fonts.googleapis.com/css2?family=Nikosh:wght@300;400;500;600;700&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
</head>
<body class="min-h-screen bg-gradient-to-br from-slate-50 via-blue-50 to-indigo-100 font-bangla overflow-x-hidden">
    @include('navigation-layout')
    
    <!-- Enhanced Background Decorative Elements -->
  <div class="fixed inset-0 overflow-hidden pointer-events-none">
    <!-- Large floating orbs -->
    <div class="absolute -top-40 -right-40 w-80 h-80 bg-gradient-to-br from-blue-200/30 to-transparent rounded-full blur-3xl"></div>
    <div class="absolute -bottom-40 -left-40 w-80 h-80 bg-gradient-to-tr from-purple-200/30 to-transparent rounded-full blur-3xl"></div>
    <div class="absolute top-1/2 left-1/4 w-40 h-40 bg-gradient-to-r from-indigo-200/20 to-transparent rounded-full blur-2xl animate-pulse"></div>
    
    <!-- Additional abstract shapes -->
    <div class="absolute top-20 left-20 w-32 h-32 bg-gradient-to-br from-pink-200/20 to-transparent rounded-full blur-xl animate-bounce"></div>
    <div class="absolute bottom-20 right-20 w-24 h-24 bg-gradient-to-tl from-yellow-200/20 to-transparent rounded-full blur-lg animate-pulse"></div>
    
    <!-- Geometric shapes -->
    <div class="absolute top-1/3 right-1/4 w-16 h-16 bg-gradient-to-r from-cyan-200/30 to-transparent rotate-45 blur-md"></div>
    <div class="absolute bottom-1/3 left-1/3 w-20 h-20 bg-gradient-to-l from-emerald-200/30 to-transparent rotate-12 blur-md"></div>
    
    <!-- Floating dots -->
    <div class="absolute top-1/4 right-1/3 w-3 h-3 bg-blue-300/40 rounded-full animate-ping"></div>
    <div class="absolute bottom-1/4 left-1/4 w-2 h-2 bg-purple-300/40 rounded-full animate-ping" style="animation-delay: 1s;"></div>
    <div class="absolute top-3/4 right-1/2 w-2.5 h-2.5 bg-indigo-300/40 rounded-full animate-ping" style="animation-delay: 2s;"></div>
  </div>

  



    <!-- Main Content -->
    <div class="relative min-h-screen flex items-center justify-center px-4 py-8">
      <div class="w-full max-w-md mx-auto">
      
        <!-- Login Card -->
        <div class="relative bg-white/95 backdrop-blur-lg shadow-2xl rounded-3xl p-8 border border-white/50 overflow-hidden animate-fade-in">
        
          <!-- Decorative elements -->
          <div class="absolute top-0 right-0 w-20 h-20 bg-gradient-to-bl from-blue-100/40 to-transparent rounded-full -translate-y-10 translate-x-10"></div>
          <div class="absolute bottom-0 left-0 w-16 h-16 bg-gradient-to-tr from-purple-100/40 to-transparent rounded-full translate-y-8 -translate-x-8"></div>
          
          <!-- Header Section -->
          <div class="relative text-center mb-8">
            <!-- Logo/Icon -->
            <div class="inline-flex items-center justify-center w-16 h-16 bg-gradient-to-br from-primaryBlue to-primaryPurple rounded-2xl shadow-lg mb-4 animate-float">
              <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
              </svg>
            </div>
            
            <!-- Title -->
            <h1 class="text-2xl md:text-3xl font-bold bg-gradient-to-r from-gray-800 via-primaryBlue to-primaryPurple bg-clip-text text-transparent mb-2">
              Welcome Back
            </h1>
            <p class="text-gray-600 text-sm md:text-base">Sign in to access your dashboard</p>
          </div>

          <!-- Login Form -->
          <form method="POST" action="{{ route('login') }}" class="relative space-y-6" id="loginForm">
            @csrf
            
            <!-- Hidden input for login type - will be set automatically -->
            <input type="hidden" name="login_type" value="auto" id="loginTypeInput">
          
            <!-- Email/Phone Input -->
            <div class="relative">
              <label class="block text-sm font-semibold text-gray-700 mb-2">
                Email Address or Phone Number
              </label>
              <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                  <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" id="inputIcon">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"/>
                  </svg>
                </div>
                <input type="text" name="login_credential" id="loginInput" required 
                  class="w-full pl-12 pr-4 py-4 rounded-xl border-2 border-gray-200 focus:ring-2 focus:ring-primaryBlue/20 focus:border-primaryBlue bg-gray-50/50 transition-all duration-200 text-base" 
                  placeholder="Enter your email or phone number"
                  value="{{ old('login_credential', old('email', old('phone'))) }}">
              </div>
              @error('email')
                <p class="mt-2 text-sm text-red-600 flex items-center">
                  <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                  </svg>
                  {{ $message }}
                </p>
              @enderror
              @error('phone')
                <p class="mt-2 text-sm text-red-600 flex items-center">
                  <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                  </svg>
                  {{ $message }}
                </p>
              @enderror
              @error('login_credential')
                <p class="mt-2 text-sm text-red-600 flex items-center">
                  <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                  </svg>
                  {{ $message }}
                </p>
              @enderror
            </div>
          
            <!-- Password Input -->
            <div class="relative">
              <label class="block text-sm font-semibold text-gray-700 mb-2">Password</label>
              <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                  <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                  </svg>
                </div>
                <input type="password" name="password" required 
                  class="w-full pl-12 pr-4 py-4 rounded-xl border-2 border-gray-200 focus:ring-2 focus:ring-primaryBlue/20 focus:border-primaryBlue bg-gray-50/50 transition-all duration-200 text-base" 
                  placeholder="Enter your password">
              </div>
              @error('password')
                <p class="mt-2 text-sm text-red-600 flex items-center">
                  <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                  </svg>
                  {{ $message }}
                </p>
              @enderror
            </div>
            <!-- Remember Me and Forgot Password -->
            <div class="flex items-center justify-between text-sm">
              <label class="flex items-center cursor-pointer group">
                <input type="checkbox" name="remember" class="w-4 h-4 text-primaryBlue border-gray-300 rounded focus:ring-primaryBlue/20 focus:ring-2">
                <span class="ml-2 text-gray-700 group-hover:text-gray-900 transition-colors duration-200">Remember me</span>
              </label>
              @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}" class="text-primaryBlue hover:text-primaryBlue/80 hover:underline transition-colors duration-200">
                  Forgot password?
                </a>
              @endif
            </div>

            <!-- Submit Button -->
            <button type="submit" 
              class="relative w-full py-4 px-6 bg-gradient-to-r from-primaryBlue to-primaryPurple hover:from-primaryBlue/90 hover:to-primaryPurple/90 text-white font-semibold rounded-xl shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-200 overflow-hidden group text-base">
              <span class="relative flex items-center justify-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/>
                </svg>
                Sign In
              </span>
            </button>
          </form>

          <!-- Registration Link -->
          <div class="text-center pt-6 border-t border-gray-200/50">
            <p class="text-gray-600 text-sm mb-3">
              Don't have an account?
            </p>
            <a href="{{ route('register') }}" class="inline-flex items-center px-6 py-3 bg-gray-100 hover:bg-gray-200 text-gray-700 hover:text-gray-800 rounded-xl border border-gray-200 hover:border-gray-300 transition-all duration-200 font-medium text-sm">
              <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/>
              </svg>
              Create Account
            </a>
          </div>

          <!-- Trust Indicators -->
          <div class="text-center pt-6">
            <div class="flex items-center justify-center space-x-6 text-xs text-gray-500">
              <div class="flex items-center space-x-1">
                <div class="w-2 h-2 bg-green-500 rounded-full"></div>
                <span>Secure Login</span>
              </div>
              <div class="flex items-center space-x-1">
                <div class="w-2 h-2 bg-blue-500 rounded-full"></div>
                <span>SSL Protected</span>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- JavaScript for Auto-Detection -->
    <script>
      document.addEventListener('DOMContentLoaded', function() {
        const loginForm = document.getElementById('loginForm');
        const loginInput = document.getElementById('loginInput');
        const loginTypeInput = document.getElementById('loginTypeInput');

        // Function to detect if input is email or phone
        function detectInputType(value) {
          // Check if it looks like an email
          const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
          // Check if it looks like a Bangladeshi phone number
          const phoneRegex = /^01[3-9][0-9]{8}$/;
          
          if (emailRegex.test(value)) {
            return 'email';
          } else if (phoneRegex.test(value.replace(/\D/g, ''))) {
            return 'phone';
          }
          return 'auto';
        }

        // Before form submission, detect the input type and set appropriate fields
        loginForm.addEventListener('submit', function(e) {
          const inputValue = loginInput.value.trim();
          const inputType = detectInputType(inputValue);
          
          // Create hidden inputs based on detected type
          const existingEmail = loginForm.querySelector('input[name="email"]');
          const existingPhone = loginForm.querySelector('input[name="phone"]');
          
          // Remove existing hidden inputs
          if (existingEmail) existingEmail.remove();
          if (existingPhone) existingPhone.remove();
          
          // Add appropriate hidden input based on detection
          if (inputType === 'email') {
            // Email can be used by: Partner, Teacher, Operator, System Administrator, System
            const emailInput = document.createElement('input');
            emailInput.type = 'hidden';
            emailInput.name = 'email';
            emailInput.value = inputValue;
            loginForm.appendChild(emailInput);
            loginTypeInput.value = 'email_based';
          } else if (inputType === 'phone') {
            // Phone is primarily used by Students
            const phoneInput = document.createElement('input');
            phoneInput.type = 'hidden';
            phoneInput.name = 'phone';
            phoneInput.value = inputValue;
            loginForm.appendChild(phoneInput);
            loginTypeInput.value = 'phone_based';
          } else {
            // If we can't detect, try email first (covers most roles)
            const emailInput = document.createElement('input');
            emailInput.type = 'hidden';
            emailInput.name = 'email';
            emailInput.value = inputValue;
            loginForm.appendChild(emailInput);
            loginTypeInput.value = 'auto_detected';
          }
        });
      });
    </script> 
</body>
</html>

