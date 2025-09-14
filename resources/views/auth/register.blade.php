<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Bikolpo LQ - Partner Registration</title>
  
  <!-- Favicon -->
  <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
  <link rel="shortcut icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
  
  @vite(['resources/css/app.css', 'resources/js/app.js'])
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
  <link href="https://fonts.googleapis.com/css2?family=Nikosh:wght@300;400;500;600;700&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
</head>
<body class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100 dark:from-gray-900 dark:to-gray-800 text-gray-800 dark:text-gray-100 font-bangla">
  
  <!-- Header -->
  <header class="bg-white/90 dark:bg-gray-900/95 backdrop-blur-md border-b border-gray-200 dark:border-gray-700 sticky top-0 z-50 transition-all duration-300">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="flex justify-between items-center py-4">
        <!-- Logo -->
        <div class="flex items-center space-x-3">
          <x-brand-logo 
            size="lg" 
            variant="default" 
            :href="route('landing')" 
            :show-tagline="true" 
          />
        </div>

        <!-- Desktop Navigation -->
        <nav class="hidden md:flex items-center space-x-8">
          <a href="{{ route('landing') }}#features" class="text-gray-700 dark:text-white hover:text-primaryGreen dark:hover:text-primaryGreen transition-colors duration-200 font-medium">
            Features
          </a>
          <a href="{{ route('landing') }}#about" class="text-gray-700 dark:text-white hover:text-primaryGreen dark:hover:text-primaryGreen transition-colors duration-200 font-medium">
            About
          </a>
          <a href="{{ route('contact') }}" class="text-gray-700 dark:text-white hover:text-primaryGreen dark:hover:text-primaryGreen transition-colors duration-200 font-medium">
            Contact
          </a>
          <a href="{{ route('partner.features') }}" class="bg-white dark:bg-gray-800 hover:bg-gray-100 dark:hover:bg-gray-700 text-primaryGreen dark:text-primaryGreen font-bold px-4 py-2 rounded-full shadow-lg transition-all duration-300 transform hover:scale-105 border-2 border-primaryGreen">
            For Partner
          </a>
          <a href="{{ route('student.features') }}" class="bg-white dark:bg-gray-800 hover:bg-gray-100 dark:hover:bg-gray-700 text-primaryBlue dark:text-primaryBlue font-bold px-4 py-2 rounded-full shadow-lg transition-all duration-300 transform hover:scale-105 border-2 border-primaryBlue">
            For Student
          </a>
          <a href="{{ route('login') }}" class="bg-gradient-to-r from-primaryGreen to-green-600 hover:from-green-600 hover:to-green-700 text-white px-6 py-2 rounded-full font-semibold transition-all duration-300 transform hover:scale-105 shadow-lg hover:shadow-xl">
            Sign In
          </a>
        </nav>

        <!-- Dark Mode Toggle & Mobile Menu -->
        <div class="flex items-center space-x-4">
          <button id="darkToggle" class="p-2 rounded-lg bg-gray-100 dark:bg-gray-800 text-gray-600 dark:text-gray-400 hover:bg-gray-200 dark:hover:bg-gray-700 transition-colors duration-200">
            <i class="fas fa-moon dark:hidden"></i>
            <i class="fas fa-sun hidden dark:block"></i>
          </button>
          
          <button id="mobileMenuBtn" class="md:hidden p-2 rounded-lg bg-gray-100 dark:bg-gray-800 text-gray-600 dark:text-gray-400 hover:bg-gray-200 dark:hover:bg-gray-700 transition-colors duration-200">
            <i class="fas fa-bars"></i>
          </button>
        </div>
      </div>

      <!-- Mobile Menu -->
      <div id="mobileMenu" class="hidden md:hidden pb-4">
        <div class="flex flex-col space-y-3">
          <a href="{{ route('landing') }}#features" class="text-gray-700 dark:text-white hover:text-primaryGreen dark:hover:text-primaryGreen transition-colors duration-200 font-medium py-2">
            Features
          </a>
          <a href="{{ route('landing') }}#about" class="text-gray-700 dark:text-white hover:text-primaryGreen dark:hover:text-primaryGreen transition-colors duration-200 font-medium py-2">
            About
          </a>
          <a href="{{ route('contact') }}" class="text-gray-700 dark:text-white hover:text-primaryGreen dark:hover:text-primaryGreen transition-colors duration-200 font-medium py-2">
            Contact
          </a>
          <a href="{{ route('partner.features') }}" class="bg-white dark:bg-gray-800 hover:bg-gray-100 dark:hover:bg-gray-700 text-primaryGreen dark:text-primaryGreen font-bold px-4 py-3 rounded-full shadow-lg transition-all duration-300 text-center border-2 border-primaryGreen">
            For Partner
          </a>
          <a href="{{ route('student.features') }}" class="bg-white dark:bg-gray-800 hover:bg-gray-100 dark:hover:bg-gray-700 text-primaryBlue dark:text-primaryBlue font-bold px-4 py-3 rounded-full shadow-lg transition-all duration-300 text-center border-2 border-primaryBlue">
            For Student
          </a>
          <a href="{{ route('login') }}" class="bg-gradient-to-r from-primaryGreen to-green-600 hover:from-green-600 hover:to-green-700 text-white px-6 py-3 rounded-full font-semibold transition-all duration-300 text-center">
            Sign In
          </a>
        </div>
      </div>
    </div>
  </header>

  <!-- Main Content -->
  <div class="min-h-screen flex items-center justify-center py-8 px-4">
    <div class="w-full max-w-5xl">
      
      <!-- Main Container -->
      <div class="bg-white dark:bg-gray-800 rounded-3xl shadow-2xl overflow-hidden">
        <div class="grid lg:grid-cols-2 min-h-[600px]">
          
          <!-- Left Side - Benefits & Features -->
          <div class="bg-gradient-to-br from-teal-500 via-cyan-500 to-blue-500 p-8 lg:p-12 text-white relative overflow-hidden">
            <!-- Animated Background Pattern -->
            <div class="absolute inset-0 opacity-20">
              <!-- Animated Triangle -->
              <div class="absolute top-8 left-8 w-0 h-0 border-l-[12px] border-r-[12px] border-b-[20px] border-l-transparent border-r-transparent border-b-white animate-bounce"></div>
              
              <!-- Animated Square -->
              <div class="absolute bottom-12 right-12 w-16 h-16 bg-white rotate-45 animate-spin"></div>
              
              <!-- Animated Hexagon -->
              <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-20 h-20 bg-white animate-pulse" style="clip-path: polygon(50% 0%, 100% 25%, 100% 75%, 50% 100%, 0% 75%, 0% 25%);"></div>
              
              <!-- Floating Circles -->
              <div class="absolute top-1/4 right-1/4 w-8 h-8 bg-white rounded-full animate-ping"></div>
              <div class="absolute bottom-1/4 left-1/4 w-6 h-6 bg-white rounded-full animate-bounce"></div>
              
              <!-- Animated Diamond -->
              <div class="absolute top-3/4 right-1/3 w-0 h-0 border-l-[8px] border-r-[8px] border-t-[12px] border-b-[12px] border-l-transparent border-r-transparent border-t-white border-b-white animate-pulse"></div>
            </div>
            
            <div class="relative z-10 h-full flex flex-col justify-center">
              <!-- Page Header moved here -->
              <div class="text-center mb-8">
                <div class="flex justify-center mb-4">
                  <div class="w-32 h-32 bg-white/20 rounded-2xl shadow-lg flex items-center justify-center">
                    <img src="{{ asset('images/Bikolpo_LQ_Transparent.png') }}" alt="Bikolpo LQ Logo" class="w-64 h-64 object-contain">
                  </div>
                </div>
                <h1 class="text-3xl md:text-4xl font-bold text-white mb-2">
                  Join Bikolpo LQ
                </h1>
                <p class="text-lg text-green-100 max-w-2xl mx-auto">
                  Transform your educational institution with our comprehensive online testing platform
                </p>
              </div>

              <h2 class="text-2xl lg:text-3xl font-bold mb-6">Why Choose Bikolpo LQ?</h2>
              
              <div class="space-y-6">
                <!-- Benefit 1 -->
                <div class="flex items-start space-x-4">
                  <div class="flex-shrink-0 w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center">
                    <i class="fas fa-chart-line text-white text-lg"></i>
                  </div>
                  <div>
                    <h3 class="font-semibold text-lg mb-1">Advanced Analytics</h3>
                    <p class="text-green-100 text-sm">Track student performance with detailed insights and progress reports</p>
                  </div>
                </div>

                <!-- Benefit 2 -->
                <div class="flex items-start space-x-4">
                  <div class="flex-shrink-0 w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center">
                    <i class="fas fa-users text-white text-lg"></i>
                  </div>
                  <div>
                    <h3 class="font-semibold text-lg mb-1">Student Management</h3>
                    <p class="text-green-100 text-sm">Organize and monitor student progress with ease</p>
                  </div>
                </div>

                <!-- Benefit 3 -->
                <div class="flex items-start space-x-4">
                  <div class="flex-shrink-0 w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center">
                    <i class="fas fa-shield-alt text-white text-lg"></i>
                  </div>
                  <div>
                    <h3 class="font-semibold text-lg mb-1">Secure Platform</h3>
                    <p class="text-green-100 text-sm">Enterprise-grade security to protect your data</p>
                  </div>
                </div>

                <!-- Benefit 4 -->
                <div class="flex items-start space-x-4">
                  <div class="flex-shrink-0 w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center">
                    <i class="fas fa-rocket text-white text-lg"></i>
                  </div>
                  <div>
                    <h3 class="font-semibold text-lg mb-1">Easy Setup</h3>
                    <p class="text-green-100 text-sm">Get started in minutes with our intuitive interface</p>
                  </div>
                </div>
              </div>

              <!-- Stats -->
              <div class="mt-8 pt-6 border-t border-white/20">
                <div class="grid grid-cols-2 gap-4 text-center">
                  <div>
                    <div class="text-2xl font-bold">1000+</div>
                    <div class="text-sm text-green-100">Institutions</div>
                  </div>
                  <div>
                    <div class="text-2xl font-bold">50K+</div>
                    <div class="text-sm text-green-100">Students</div>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- Right Side - Registration Form -->
          <div class="p-8 lg:p-12">
            <div class="max-w-md mx-auto">
              <div class="text-center mb-8">
                <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-2">Create Your Account</h3>
                <p class="text-gray-600 dark:text-gray-400">Start your journey today</p>
              </div>

              <!-- Registration Form -->
              <form action="{{ route('register') }}" method="POST" class="space-y-5">
                @csrf
                <input type="hidden" name="register_type" value="partner">
                
                <!-- Institute Category -->
                <div>
                  <label class="block text-sm font-semibold text-gray-700 dark:text-gray-200 mb-2">
                    Institute Category <span class="text-red-500">*</span>
                  </label>
                  <select name="organization_type" required
                    class="w-full px-4 py-3 rounded-xl border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-primaryGreen focus:border-transparent transition-all duration-200">
                    <option value="">Select your institution type</option>
                    <option value="Kinder Garten" {{ old('organization_type') == 'Kinder Garten' ? 'selected' : '' }}>Kinder Garten</option>
                    <option value="School" {{ old('organization_type') == 'School' ? 'selected' : '' }}>School</option>
                    <option value="College" {{ old('organization_type') == 'College' ? 'selected' : '' }}>College</option>
                    <option value="University" {{ old('organization_type') == 'University' ? 'selected' : '' }}>University</option>
                    <option value="Academic Coaching" {{ old('organization_type') == 'Academic Coaching' ? 'selected' : '' }}>Academic Coaching</option>
                    <option value="Job Coaching" {{ old('organization_type') == 'Job Coaching' ? 'selected' : '' }}>Job Coaching</option>
                    <option value="Admission Coaching" {{ old('organization_type') == 'Admission Coaching' ? 'selected' : '' }}>Admission Coaching</option>
                    <option value="Training Institute" {{ old('organization_type') == 'Training Institute' ? 'selected' : '' }}>Training Institute</option>
                    <option value="Other" {{ old('organization_type') == 'Other' ? 'selected' : '' }}>Other</option>
                  </select>
                  @error('organization_type')
                    <p class="text-sm text-red-600 mt-2">{{ $message }}</p>
                  @enderror
                </div>

                <!-- Institute Name -->
                <div>
                  <label class="block text-sm font-semibold text-gray-700 dark:text-gray-200 mb-2">
                    Institute Name <span class="text-red-500">*</span>
                  </label>
                  <input type="text" name="name" required placeholder="Enter your institution name"
                    value="{{ old('name') }}"
                    class="w-full px-4 py-3 rounded-xl border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white placeholder-gray-500 dark:placeholder-gray-400 focus:ring-2 focus:ring-primaryGreen focus:border-transparent transition-all duration-200" />
                  @error('name')
                    <p class="text-sm text-red-600 mt-2">{{ $message }}</p>
                  @enderror
                </div>

                <!-- Email -->
                <div>
                  <label class="block text-sm font-semibold text-gray-700 dark:text-gray-200 mb-2">
                    Email Address <span class="text-red-500">*</span>
                  </label>
                  <input type="email" name="email" required placeholder="Enter your email address"
                    value="{{ old('email') }}"
                    class="w-full px-4 py-3 rounded-xl border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white placeholder-gray-500 dark:placeholder-gray-400 focus:ring-2 focus:ring-primaryGreen focus:border-transparent transition-all duration-200" />
                  @error('email')
                    <p class="text-sm text-red-600 mt-2">{{ $message }}</p>
                  @enderror
                </div>

                <!-- Password -->
                <div>
                  <label class="block text-sm font-semibold text-gray-700 dark:text-gray-200 mb-2">
                    Password <span class="text-red-500">*</span>
                  </label>
                  <input type="password" name="password" required placeholder="Create a strong password"
                    class="w-full px-4 py-3 rounded-xl border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white placeholder-gray-500 dark:placeholder-gray-400 focus:ring-2 focus:ring-primaryGreen focus:border-transparent transition-all duration-200" />
                  @error('password')
                    <p class="text-sm text-red-600 mt-2">{{ $message }}</p>
                  @enderror
                </div>

                <!-- Confirm Password -->
                <div>
                  <label class="block text-sm font-semibold text-gray-700 dark:text-gray-200 mb-2">
                    Confirm Password <span class="text-red-500">*</span>
                  </label>
                  <input type="password" name="password_confirmation" required placeholder="Confirm your password"
                    class="w-full px-4 py-3 rounded-xl border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white placeholder-gray-500 dark:placeholder-gray-400 focus:ring-2 focus:ring-primaryGreen focus:border-transparent transition-all duration-200" />
                  @error('password_confirmation')
                    <p class="text-sm text-red-600 mt-2">{{ $message }}</p>
                  @enderror
                </div>

                <!-- Submit Button -->
                <div class="pt-2">
                  <button type="submit"
                    class="w-full py-4 px-6 bg-gradient-to-r from-primaryGreen to-green-600 hover:from-green-600 hover:to-green-700 text-white font-bold rounded-xl shadow-lg hover:shadow-xl focus:ring-2 focus:ring-offset-2 focus:ring-primaryGreen transition-all duration-300 transform hover:-translate-y-0.5">
                    <i class="fas fa-rocket mr-2"></i>
                    Create Account
                  </button>
                </div>
              </form>

              <!-- Footer -->
              <div class="text-center mt-8 pt-6 border-t border-gray-200 dark:border-gray-700">
                <p class="text-gray-600 dark:text-gray-400 mb-3">
                  Already have an account?
                </p>
                <a href="{{ route('login') }}" 
                   class="inline-flex items-center text-primaryGreen dark:text-green-400 font-semibold hover:text-green-600 dark:hover:text-green-300 transition-colors duration-200">
                  <i class="fas fa-sign-in-alt mr-2"></i>
                  Sign In to Your Account
                </a>
              </div>
            </div>
          </div>

        </div>
      </div>

      <!-- Bottom CTA -->
      <div class="text-center mt-8">
        <p class="text-gray-600 dark:text-gray-400 mb-4">
          Have questions? We're here to help!
        </p>
        <div class="flex flex-col sm:flex-row gap-3 justify-center">
          <a href="{{ route('contact') }}" 
             class="inline-flex items-center px-6 py-3 bg-gray-100 dark:bg-gray-800 text-gray-700 dark:text-gray-300 rounded-xl hover:bg-gray-200 dark:hover:bg-gray-700 transition-colors duration-200">
            <i class="fas fa-envelope mr-2"></i>
            Contact Support
          </a>
          <a href="{{ route('partner.features') }}" 
             class="inline-flex items-center px-6 py-3 bg-primaryBlue text-white rounded-xl hover:bg-blue-600 transition-colors duration-200">
            <i class="fas fa-info-circle mr-2"></i>
            Learn More
          </a>
        </div>
      </div>

    </div>
  </div>

  <!-- JavaScript for Mobile Menu and Dark Mode Toggle -->
  <script>
    // Mobile Menu Toggle
    const mobileMenuBtn = document.getElementById('mobileMenuBtn');
    const mobileMenu = document.getElementById('mobileMenu');
    
    mobileMenuBtn.addEventListener('click', () => {
      mobileMenu.classList.toggle('hidden');
    });

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
