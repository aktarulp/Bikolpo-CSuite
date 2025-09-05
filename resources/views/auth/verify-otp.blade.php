<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Bikolpo Pathshala - Verify OTP</title>
  
  <!-- Favicon -->
  <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
  <link rel="shortcut icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
  
  <script src="https://cdn.tailwindcss.com"></script>
  <script>
    tailwind.config = {
      theme: {
        extend: {
          colors: {
            primaryGreen: '#16a34a',
            primaryOrange: '#f97316',
            primaryBlue: '#3b82f6',
            primaryPurple: '#8b5cf6'
          }
        }
      }
    }
  </script>
  <link href="https://fonts.googleapis.com/css2?family=Hind+Siliguri:wght@300;400;500;600;700&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
</head>
<body class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100 dark:from-gray-900 dark:to-gray-800 text-gray-800 dark:text-gray-100 font-bangla">
  
  <!-- Header -->
  <header class="bg-white/90 dark:bg-gray-900/95 backdrop-blur-md border-b border-gray-200 dark:border-gray-700 sticky top-0 z-50 transition-all duration-300">
    <div class="max-w-7xl mx-auto px-1 sm:px-6 lg:px-8">
      <div class="flex justify-between items-center py-0">
        <!-- Logo -->
        <div class="flex items-center space-x-3">
          <x-brand-logo 
            size="lg" 
            variant="default" 
            :href="route('landing')" 
            :show-tagline="true" 
          />
        </div>

        <!-- Dark Mode Toggle -->
        <div class="flex items-center space-x-4">
          <button id="darkToggle" class="p-2 rounded-lg bg-gray-100 dark:bg-gray-800 text-gray-600 dark:text-gray-400 hover:bg-gray-200 dark:hover:bg-gray-700 transition-colors duration-200">
            <i class="fas fa-moon dark:hidden"></i>
            <i class="fas fa-sun hidden dark:block"></i>
          </button>
        </div>
      </div>
    </div>
  </header>

  <!-- Main Content -->
  <div class="min-h-screen flex items-center justify-center py-8 px-4">
    <div class="w-full max-w-md">
      
      <!-- Page Header -->
      <div class="text-center mb-8">
        <div class="inline-flex items-center justify-center w-16 h-16 bg-gradient-to-br from-primaryGreen to-green-600 rounded-2xl shadow-lg mb-4">
          <i class="fas fa-shield-check text-white text-2xl"></i>
        </div>
        <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-2">
          Verify Your Email
        </h1>
        <p class="text-lg text-gray-600 dark:text-gray-400">
          We've sent a 6-digit verification code to
        </p>
        <p class="text-lg font-semibold text-primaryGreen dark:text-green-400">
          {{ $email }}
        </p>
      </div>

      <!-- OTP Verification Form -->
      <div class="bg-white dark:bg-gray-800 rounded-3xl shadow-2xl overflow-hidden">
        <div class="p-8">
          <div class="text-center mb-8">
            <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-2">Enter Verification Code</h3>
            <p class="text-gray-600 dark:text-gray-400">Please check your email and enter the code below</p>
          </div>

          <!-- OTP Form -->
          <form action="{{ route('otp.verify') }}" method="POST" class="space-y-6">
            @csrf
            <input type="hidden" name="email" value="{{ $email }}">
            
            <!-- OTP Input -->
            <div>
              <label class="block text-sm font-semibold text-gray-700 dark:text-gray-200 mb-2">
                Verification Code <span class="text-red-500">*</span>
              </label>
              <input type="text" name="otp" required 
                placeholder="Enter 6-digit code"
                maxlength="6"
                class="w-full px-4 py-4 text-center text-2xl font-bold tracking-widest rounded-xl border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white placeholder-gray-500 dark:placeholder-gray-400 focus:ring-2 focus:ring-primaryGreen focus:border-transparent transition-all duration-200" />
              @error('otp')
                <p class="text-sm text-red-600 mt-2">{{ $message }}</p>
              @enderror
            </div>

            <!-- Submit Button -->
            <div class="pt-2">
              <button type="submit"
                class="w-full py-4 px-6 bg-gradient-to-r from-primaryGreen to-green-600 hover:from-green-600 hover:to-green-700 text-white font-bold rounded-xl shadow-lg hover:shadow-xl focus:ring-2 focus:ring-offset-2 focus:ring-primaryGreen transition-all duration-300 transform hover:-translate-y-0.5">
                <i class="fas fa-check mr-2"></i>
                Verify & Complete Registration
              </button>
            </div>
          </form>

          <!-- Resend OTP -->
          <div class="mt-8 text-center">
            <p class="text-gray-600 dark:text-gray-400 mb-4">
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
          <div class="text-center mt-8 pt-6 border-t border-gray-200 dark:border-gray-700">
            <p class="text-gray-600 dark:text-gray-400 mb-3">
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
      <div class="text-center mt-8">
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

  <!-- JavaScript for Dark Mode Toggle -->
  <script>
    // Dark Mode Toggle
    const darkToggle = document.getElementById('darkToggle');
    const html = document.documentElement;
    
    // Check for saved dark mode preference or default to light mode
    if (localStorage.getItem('darkMode') === 'true' || 
        (!localStorage.getItem('darkMode') && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
      html.classList.add('dark');
    }
    
    darkToggle.addEventListener('click', () => {
      html.classList.toggle('dark');
      localStorage.setItem('darkMode', html.classList.contains('dark'));
    });

    // Auto-focus OTP input
    document.querySelector('input[name="otp"]').focus();

    // Auto-format OTP input (only allow numbers)
    document.querySelector('input[name="otp"]').addEventListener('input', function(e) {
      this.value = this.value.replace(/[^0-9]/g, '');
    });
  </script>
</body>
</html>
