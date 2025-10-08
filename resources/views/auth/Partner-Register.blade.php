<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Bikolpo Pathshala - Partner Registration</title>
  
  <!-- Favicon -->
  <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
  <link rel="shortcut icon" type="image/x-xicon" href="{{ asset('favicon.ico') }}">
  
  @vite(['resources/css/app.css', 'resources/js/app.js'])
  <link href="https://fonts.googleapis.com/css2?family=Nikosh:wght@300;400;500;600;700&display=swap" rel="stylesheet" />
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
          <i class="fas fa-user-plus text-white text-2xl"></i>
        </div>
        <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-2">
          Partner Registration
        </h1>
        <p class="text-lg text-gray-600 dark:text-gray-400">
          Create your partner account to get started
        </p>
      </div>

      <!-- Registration Form -->
      <div class="bg-white dark:bg-gray-800 rounded-3xl shadow-2xl overflow-hidden">
        <div class="p-8">
          <form method="POST" action="{{ route('register') }}" class="space-y-6">
            @csrf
            <input type="hidden" name="is_partner_registration" value="1">

            <!-- Organization Name -->
            <div>
              <label for="organization_name" class="block text-sm font-semibold text-gray-700 dark:text-gray-200 mb-2">
                Organization Name <span class="text-red-500">*</span>
              </label>
              <input type="text" id="organization_name" name="organization_name" value="{{ old('organization_name') }}" required autofocus autocomplete="organization_name"
                class="w-full px-4 py-3 rounded-xl border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white placeholder-gray-500 dark:placeholder-gray-400 focus:ring-2 focus:ring-primaryGreen focus:border-transparent transition-all duration-200" />
              @error('organization_name')
                <p class="text-sm text-red-600 mt-2">{{ $message }}</p>
              @enderror
            </div>

            <!-- Email Address -->
            <div class="mt-6">
              <label for="email" class="block text-sm font-semibold text-gray-700 dark:text-gray-200 mb-2">
                Email Address <span class="text-red-500">*</span>
              </label>
              <input type="email" id="email" name="email" value="{{ old('email') }}" required autocomplete="username"
                class="w-full px-4 py-3 rounded-xl border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white placeholder-gray-500 dark:placeholder-gray-400 focus:ring-2 focus:ring-primaryGreen focus:border-transparent transition-all duration-200" />
              @error('email')
                <p class="text-sm text-red-600 mt-2">{{ $message }}</p>
              @enderror
            </div>

            <!-- Password -->
            <div class="mt-6">
              <label for="password" class="block text-sm font-semibold text-gray-700 dark:text-gray-200 mb-2">
                Password <span class="text-red-500">*</span>
              </label>
              <input type="password" id="password" name="password" required autocomplete="new-password"
                class="w-full px-4 py-3 rounded-xl border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white placeholder-gray-500 dark:placeholder-gray-400 focus:ring-2 focus:ring-primaryGreen focus:border-transparent transition-all duration-200" />
              @error('password')
                <p class="text-sm text-red-600 mt-2">{{ $message }}</p>
              @enderror
            </div>

            <!-- Confirm Password -->
            <div>
              <label for="password_confirmation" class="block text-sm font-semibold text-gray-700 dark:text-gray-200 mb-2">
                Confirm Password <span class="text-red-500">*</span>
              </label>
              <input type="password" id="password_confirmation" name="password_confirmation" required autocomplete="new-password"
                class="w-full px-4 py-3 rounded-xl border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white placeholder-gray-500 dark:placeholder-gray-400 focus:ring-2 focus:ring-primaryGreen focus:border-transparent transition-all duration-200" />
              @error('password_confirmation')
                <p class="text-sm text-red-600 mt-2">{{ $message }}</p>
              @enderror
            </div>

            <!-- Submit Button -->
            <div class="pt-2">
              <button type="submit"
                class="w-full py-4 px-6 bg-gradient-to-r from-primaryGreen to-green-600 hover:from-green-600 hover:to-green-700 text-white font-bold rounded-xl shadow-lg hover:shadow-xl focus:ring-2 focus:ring-offset-2 focus:ring-primaryGreen transition-all duration-300 transform hover:-translate-y-0.5">
                <i class="fas fa-user-plus mr-2"></i>
                Register as Partner
              </button>
            </div>
          </form>

          <!-- Already Registered Link -->
          <div class="mt-8 text-center">
            <p class="text-gray-600 dark:text-gray-400">
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
  </script>
</body>
</html>
