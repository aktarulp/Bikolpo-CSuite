<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Partner Login - CSuite</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <script>
    tailwind.config = {
      darkMode: 'class',
      theme: {
        extend: {
          fontFamily: {
            bangla: ['"Hind Siliguri"', 'sans-serif']
          },
          colors: {
            primaryGreen: '#16a34a',
            primaryOrange: '#f97316',
            primaryBlue: '#3b82f6',
            primaryPurple: '#8b5cf6'
          },
          animation: {
            'fade-in': 'fadeIn 0.5s ease-in-out',
            'slide-up': 'slideUp 0.6s ease-out',
            'bounce-slow': 'bounce 2s infinite',
            'pulse-slow': 'pulse 3s infinite'
          }
        }
      }
    }
  </script>
  <link href="https://fonts.googleapis.com/css2?family=Hind+Siliguri:wght@300;400;500;600;700&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
</head>
<body class="min-h-screen bg-gradient-to-br from-blue-50 via-indigo-50 to-purple-50 font-bangla">

  <!-- Header -->
  <header class="bg-white/90 dark:bg-gray-900/95 backdrop-blur-md border-b border-gray-200 dark:border-gray-700 sticky top-0 z-50 transition-all duration-300">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="flex justify-between items-center py-4">
        <!-- Logo -->
        <div class="flex items-center space-x-3">
          <a href="{{ route('landing') }}" class="flex items-center space-x-3 hover:scale-105 transition-transform duration-200">
            <div class="relative">
              <div class="w-12 h-12 bg-gradient-to-br from-primaryGreen to-green-600 rounded-2xl flex items-center justify-center shadow-lg">
                <i class="fas fa-graduation-cap text-white text-xl"></i>
              </div>
              <div class="absolute -top-1 -right-1 w-4 h-4 bg-primaryOrange rounded-full animate-pulse"></div>
            </div>
            <div>
              <h1 class="text-2xl font-bold bg-gradient-to-r from-primaryGreen to-primaryBlue bg-clip-text text-transparent">
                বিকল্প কম্পিউটার
              </h1>
              <p class="text-xs text-gray-500 dark:text-gray-400">Your Smart Exam Partner</p>
            </div>
          </a>
        </div>

        <!-- Desktop Navigation -->
        <nav class="hidden md:flex items-center space-x-8">
          <a href="#features" class="text-gray-700 dark:text-white hover:text-primaryGreen dark:hover:text-primaryGreen transition-colors duration-200 font-medium">
            Features
          </a>
          <a href="#about" class="text-gray-700 dark:text-white hover:text-primaryGreen dark:hover:text-primaryGreen transition-colors duration-200 font-medium">
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
          <a href="#features" class="text-gray-700 dark:text-white hover:text-primaryGreen dark:hover:text-primaryGreen transition-colors duration-200 font-medium py-2">
            Features
          </a>
          <a href="#about" class="text-gray-700 dark:text-white hover:text-primaryGreen dark:hover:text-primaryGreen transition-colors duration-200 font-medium py-2">
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

  



    <div class="relative min-h-screen flex items-center justify-center p-4">
    
    <!-- Two Column Layout -->
    <div class="w-full max-w-6xl grid grid-cols-1 lg:grid-cols-2 gap-8 items-center">
      
      <!-- Left Column: Promotional Content -->
      <div class="text-center lg:text-left space-y-6">
        
        <!-- Hero Section -->
        <div class="space-y-4">
          
          <h1 class="text-3xl lg:text-4xl font-bold bg-gradient-to-r from-primaryGreen via-primaryBlue to-primaryPurple bg-clip-text text-transparent leading-tight">
            Welcome Back to বিকল্প কম্পিউটার
          </h1>
          
          <p class="text-lg text-gray-600 max-w-lg mx-auto lg:mx-0 leading-relaxed">
            Access your partner dashboard and continue empowering students with quality education through our smart exam platform
          </p>
        </div>

        <!-- Features Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 max-w-xl mx-auto lg:mx-0">
          
          <div class="bg-white/80 backdrop-blur-sm rounded-xl p-4 border border-white/30 shadow-lg hover:shadow-xl transition-all duration-300 hover:-translate-y-1">
            <div class="w-10 h-10 bg-gradient-to-br from-green-500 to-emerald-600 rounded-xl flex items-center justify-center mx-auto lg:mx-0 mb-3">
              <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
              </svg>
            </div>
            <h3 class="text-base font-bold text-gray-800 mb-2">Student Management</h3>
            <p class="text-gray-600 text-sm leading-relaxed">Easily manage your student roster and track progress</p>
          </div>
          
          <div class="bg-white/80 backdrop-blur-sm rounded-xl p-4 border border-white/30 shadow-lg hover:shadow-xl transition-all duration-300 hover:-translate-y-1">
            <div class="w-10 h-10 bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl flex items-center justify-center mx-auto lg:mx-0 mb-3">
              <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                <path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z"/>
                <path fill-rule="evenodd" d="M4 5a2 2 0 012-2 3 3 0 003 3h2a3 3 0 003-3 2 2 0 012 2v11a2 2 0 01-2 2H6a2 2 0 01-2-2V5zm3 4a1 1 0 000 2h.01a1 1 0 100-2H7zm3 0a1 1 0 000 2h3a1 1 0 100-2h-3zm-3 4a1 1 0 100 2h.01a1 1 0 100-2H7zm3 0a1 1 0 100 2h3a1 1 0 100-2h-3z" clip-rule="evenodd"/>
              </svg>
            </div>
            <h3 class="text-base font-bold text-gray-800 mb-2">Exam Creation</h3>
            <p class="text-gray-600 text-sm leading-relaxed">Create and customize exams for your students</p>
          </div>
          
          <div class="bg-white/80 backdrop-blur-sm rounded-xl p-4 border border-white/30 shadow-lg hover:shadow-xl transition-all duration-300 hover:-translate-y-1">
            <div class="w-10 h-10 bg-gradient-to-br from-purple-500 to-purple-600 rounded-xl flex items-center justify-center mx-auto lg:mx-0 mb-3">
              <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                <path d="M9 19c-5 1.5-5-2.5-7-3m14 6v-3.87a3.37 3.37 0 0 0-1.94-2.61c3.14-.35 6.44-1.54 6.44-7A5.44 5.44 0 0 0 20 4.77 5.07 5.07 0 0 0 19.91 1S18.73.65 16 2.48a13.38 13.38 0 0 0-7 0C6.27.65 5.09 1 5.09 1A5.07 5.07 0 0 0 5 4.77a5.44 5.44 0 0 0-1.5 3.78c0 5.42 3.3 6.61 6.44 7A3.37 3.37 0 0 0 9 18.13V22"/>
              </svg>
            </div>
            <h3 class="text-base font-bold text-gray-800 mb-2">Analytics Dashboard</h3>
            <p class="text-gray-600 text-sm leading-relaxed">Get insights into student performance and trends</p>
          </div>
          
          <div class="bg-white/80 backdrop-blur-sm rounded-xl p-4 border border-white/30 shadow-lg hover:shadow-xl transition-all duration-300 hover:-translate-y-1">
            <div class="w-10 h-10 bg-gradient-to-br from-orange-500 to-orange-600 rounded-xl flex items-center justify-center mx-auto lg:mx-0 mb-3">
              <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z"/>
                <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z"/>
              </svg>
            </div>
            <h3 class="text-base font-bold text-gray-800 mb-2">24/7 Support</h3>
            <p class="text-gray-600 text-sm leading-relaxed">Round-the-clock assistance for your success</p>
          </div>
        </div>

        <!-- Trust Indicators -->
        <div class="pt-4">
          <p class="text-sm text-gray-500 mb-4 text-center lg:text-left">Trusted by 1000+ educational institutions</p>
          <div class="flex items-center justify-center lg:justify-start space-x-6">
            <div class="flex items-center space-x-2">
              <div class="w-2 h-2 bg-primaryGreen rounded-full animate-pulse"></div>
              <span class="text-sm text-gray-600 font-medium">99.9% Uptime</span>
            </div>
            <div class="flex items-center space-x-2">
              <div class="w-2 h-2 bg-primaryGreen rounded-full animate-pulse"></div>
              <span class="text-sm text-gray-600 font-medium">SSL Secured</span>
            </div>
            <div class="flex items-center space-x-2">
              <div class="w-2 h-2 bg-primaryGreen rounded-full animate-pulse"></div>
              <span class="text-sm text-gray-600 font-medium">GDPR Compliant</span>
            </div>
          </div>
        </div>
      </div>

      <!-- Right Column: Enhanced Login Card -->
      <div class="flex justify-center lg:justify-end">
        <div class="relative w-full max-w-lg">
          <!-- Abstract shapes around the card -->
          <div class="absolute -top-8 -left-8 w-32 h-32 bg-gradient-to-br from-blue-400/20 to-transparent rounded-full blur-xl"></div>
          <div class="absolute -bottom-8 -right-8 w-28 h-28 bg-gradient-to-tl from-purple-400/20 to-transparent rounded-full blur-xl"></div>
          <div class="absolute top-1/2 -right-10 w-20 h-20 bg-gradient-to-r from-green-400/20 to-transparent rounded-full blur-lg"></div>
          <div class="absolute top-1/3 -left-6 w-16 h-16 bg-gradient-to-l from-pink-400/20 to-transparent rounded-full blur-md"></div>
          
          <!-- Main login card -->
          <div class="relative bg-white/95 backdrop-blur-sm shadow-2xl rounded-3xl p-8 border border-white/30 overflow-hidden">
            <!-- Decorative elements inside the card -->
            <div class="absolute top-0 right-0 w-24 h-24 bg-gradient-to-bl from-blue-100/30 to-transparent rounded-full -translate-y-12 translate-x-12"></div>
            <div class="absolute bottom-0 left-0 w-20 h-20 bg-gradient-to-tr from-purple-100/30 to-transparent rounded-full translate-y-10 -translate-x-10"></div>
            
            <!-- Subtle geometric accent -->
            <div class="absolute top-3 right-3 w-6 h-6 border-2 border-blue-200/30 rounded-lg rotate-45"></div>
            <div class="absolute bottom-3 left-3 w-5 h-5 border-2 border-purple-200/30 rounded-full"></div>
            
            <!-- Title with enhanced styling -->
            <div class="relative text-center mb-6">
              <div class="inline-flex items-center justify-center w-12 h-12 bg-gradient-to-br from-green-500 to-emerald-600 rounded-xl shadow-lg mb-3">
                <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                  <path fill-rule="evenodd" d="M3 3a1 1 0 000 2v8a2 2 0 002 2h2l1 1h2l1-1h2a2 2 0 002-2V5a1 1 0 100-2H3zm11.707 4.707a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                </svg>
              </div>
              <h2 class="text-2xl font-bold bg-gradient-to-r from-gray-800 to-green-600 bg-clip-text text-transparent">
                Partner Login
              </h2>
              <p class="text-gray-500 mt-1 text-sm">Access your dashboard</p>
            </div>

            <!-- Enhanced Form -->
            <form method="POST" action="{{ route('login') }}" class="relative space-y-4">
              @csrf
              <input type="hidden" name="login_type" value="partner">
              
              <!-- Email with enhanced styling -->
              <div class="relative">
                <label class="block text-sm font-semibold text-gray-700 mb-2">Email Address</label>
                <div class="relative">
                  <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"/>
                    </svg>
                  </div>
                  <input type="email" name="email" required 
                    class="w-full pl-10 pr-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-green-500/20 focus:border-green-500 bg-gray-50/50 transition-all duration-200" 
                    placeholder="Enter your email"
                    value="{{ old('email') }}">
                </div>
                @error('email')
                  <p class="mt-2 text-sm text-red-600 flex items-center">
                    <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                      <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                    </svg>
                    {{ $message }}
                  </p>
                @enderror
              </div>

              <!-- Password with enhanced styling -->
              <div class="relative">
                <label class="block text-sm font-semibold text-gray-700 mb-2">Password</label>
                <div class="relative">
                  <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                    </svg>
                  </div>
                  <input type="password" name="password" required 
                    class="w-full pl-10 pr-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-green-500/20 focus:border-green-500 bg-gray-50/50 transition-all duration-200" 
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
              <div class="flex items-center justify-between">
                <label class="flex items-center cursor-pointer group">
                  <div class="relative">
                    <input type="checkbox" name="remember" class="sr-only">
                    <div class="w-5 h-5 border-2 border-gray-300 rounded-md group-hover:border-green-500 transition-colors duration-200"></div>
                    <div class="absolute inset-0 w-5 h-5 bg-green-500 rounded-md scale-0 transition-transform duration-200 peer-checked:scale-100"></div>
                  </div>
                  <span class="ml-3 text-sm text-gray-700 group-hover:text-gray-900 transition-colors duration-200">Remember me</span>
                </label>
                @if (Route::has('password.request'))
                  <a href="{{ route('password.request') }}" class="text-sm text-green-600 hover:text-green-700 hover:underline transition-colors duration-200">
                    Forgot password?
                  </a>
                @endif
              </div>

              <!-- Enhanced Submit Button -->
              <button type="submit" 
                class="relative w-full py-3 px-6 bg-gradient-to-r from-green-500 to-emerald-600 hover:from-green-600 hover:to-emerald-700 text-white font-semibold rounded-xl shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-200 overflow-hidden group">
                <!-- Button background animation -->
                <div class="absolute inset-0 bg-gradient-to-r from-green-400 to-emerald-500 opacity-0 group-hover:opacity-100 transition-opacity duration-200"></div>
                <!-- Button content -->
                <span class="relative flex items-center justify-center">
                  Sign In
                  <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                  </svg>
                </span>
              </button>

              <!-- Registration link -->
              <div class="text-center pt-4">
                <p class="text-sm text-gray-600 mb-3">
                  Don't have an account?
                </p>
                <a href="{{ route('register') }}" class="inline-block px-6 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 hover:text-gray-800 rounded-lg border border-gray-200 hover:border-gray-300 transition-all duration-200 font-medium text-sm">
                  Register Now
                </a>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- JavaScript for Header Functionality -->
  <script>
    // Mobile menu toggle
    const mobileMenuBtn = document.getElementById('mobileMenuBtn');
    const mobileMenu = document.getElementById('mobileMenu');
    
    mobileMenuBtn.addEventListener('click', () => {
      mobileMenu.classList.toggle('hidden');
    });

    // Dark mode toggle
    const darkToggle = document.getElementById('darkToggle');
    const html = document.documentElement;
    
    // Check for saved dark mode preference
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
