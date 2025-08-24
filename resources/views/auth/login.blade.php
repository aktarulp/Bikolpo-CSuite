<!DOCTYPE html>
<html lang="bn" class="scroll-smooth">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>বিকল্প কম্পিউটার - Login</title>
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

<body class="bg-gradient-to-br from-gray-50 to-gray-100 dark:from-gray-900 dark:to-gray-800 text-gray-800 dark:text-gray-100 font-bangla min-h-screen flex flex-col">
    
    <!-- Header -->
    <header class="bg-white/90 dark:bg-gray-900/95 backdrop-blur-md border-b border-gray-200 dark:border-gray-700 sticky top-0 z-50 transition-all duration-300">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center py-4">
                <!-- Logo -->
                <div class="flex items-center space-x-4">
                    <a href="{{ route('landing') }}" class="flex items-center space-x-4 group">
                        <div class="relative">
                            <div class="w-14 h-14 bg-gradient-to-br from-primaryGreen via-green-500 to-green-600 rounded-2xl flex items-center justify-center shadow-lg group-hover:shadow-xl transition-all duration-300 transform group-hover:scale-105">
                                <img src="{{ asset('images/logo.png') }}" alt="Logo" class="w-10 h-10 object-contain" />
                            </div>
                            <div class="absolute -inset-1 bg-gradient-to-r from-primaryGreen to-green-600 rounded-2xl blur opacity-25 group-hover:opacity-40 transition-opacity duration-300"></div>
                        </div>
                        <div class="transform group-hover:translate-x-1 transition-transform duration-300">
                            <h1 class="text-3xl font-bold bg-gradient-to-r from-primaryGreen to-green-600 bg-clip-text text-transparent">
                                বিকল্প কম্পিউটার
                            </h1>
                            <p class="text-sm text-gray-600 dark:text-gray-400 font-medium">Your Smart Exam Partner</p>
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
                    <a href="#blogs" class="text-gray-700 dark:text-white hover:text-primaryGreen dark:hover:text-primaryGreen transition-colors duration-200 font-medium">
                        Learning Blogs
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
                    <a href="#blogs" class="text-gray-700 dark:text-white hover:text-primaryGreen dark:hover:text-primaryGreen transition-colors duration-200 font-medium py-2">
                        Learning Blogs
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
    <main class="flex-grow flex items-center justify-center p-4">
        <!-- Full-page Container with Enhanced Background and Border -->
        <div class="bg-gradient-to-br from-white via-blue-50 to-green-50 dark:from-gray-800 dark:via-gray-700 dark:to-gray-600 rounded-[3rem] p-8 shadow-2xl max-w-6xl w-full h-[70vh] flex flex-col relative overflow-hidden">
            
            <!-- Decorative Background Elements -->
            <div class="absolute inset-0 overflow-hidden pointer-events-none">
                <div class="absolute -top-20 -right-20 w-40 h-40 bg-gradient-to-br from-primaryGreen/10 to-transparent rounded-full blur-3xl"></div>
                <div class="absolute -bottom-20 -left-20 w-40 h-40 bg-gradient-to-tr from-primaryBlue/10 to-transparent rounded-full blur-3xl"></div>
                <div class="absolute top-1/2 left-1/4 w-20 h-20 bg-gradient-to-r from-primaryOrange/20 to-transparent rounded-full blur-2xl animate-pulse"></div>
            </div>
            
            <!-- Success Message with Enhanced Styling -->
    @if (session('success'))
                <div class="mb-8 p-6 bg-gradient-to-r from-green-50 via-emerald-50 to-green-100 dark:from-green-900/30 dark:via-emerald-900/30 dark:to-green-900/30 border-2 border-green-200 dark:border-green-600 rounded-3xl shadow-lg relative overflow-hidden">
                    <div class="absolute inset-0 bg-gradient-to-r from-green-400/5 to-emerald-400/5"></div>
                    <div class="relative flex items-start space-x-4">
                <div class="flex-shrink-0">
                            <div class="w-14 h-14 bg-gradient-to-br from-green-500 via-emerald-500 to-green-600 rounded-2xl flex items-center justify-center shadow-lg animate-bounce">
                                <i class="fas fa-check text-white text-2xl"></i>
                    </div>
                </div>
                <div class="flex-1">
                            <h3 class="text-xl font-bold text-green-800 dark:text-green-200 mb-2 flex items-center">
                                🎉 Registration Successful! 🚀
                    </h3>
                            <p class="text-green-700 dark:text-green-300 leading-relaxed text-lg">
                        {{ session('success') }}
                    </p>
                    <div class="mt-4 p-3 bg-white/50 dark:bg-gray-800/50 rounded-xl border border-green-200 dark:border-green-600">
                        <p class="text-sm text-green-600 dark:text-green-400 font-medium">
                            <i class="fas fa-info-circle mr-2"></i>
                            You can now login with your credentials to access your dashboard.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    @endif

            <!-- Session Status -->
            <x-auth-session-status class="mb-4" :status="session('status')" />

                         <!-- Main Content Area with Enhanced 3 Columns -->
             <div class="flex-grow grid grid-cols-1 md:grid-cols-3 gap-8 items-start relative z-10">
                
                                 <!-- Left Column: Enhanced Illustration -->
                 <div class="flex items-center justify-center p-4">
                    <div class="text-center space-y-6">
                        <!-- Enhanced Logo with Floating Animation -->
                        <div class="flex items-center justify-center mb-8">
                            <div class="relative group">
                                <div class="w-28 h-28 bg-gradient-to-br from-primaryGreen via-green-500 to-green-600 rounded-3xl flex items-center justify-center shadow-2xl group-hover:shadow-3xl transition-all duration-500 transform group-hover:scale-110 group-hover:rotate-3 animate-float">
                                    <img src="{{ asset('images/logo.png') }}" alt="Logo" class="w-20 h-20 object-contain" />
                                </div>
                                <div class="absolute -inset-2 bg-gradient-to-r from-primaryGreen to-green-600 rounded-3xl blur opacity-30 group-hover:opacity-50 transition-opacity duration-500"></div>
                                <!-- Floating Particles -->
                                <div class="absolute -top-2 -right-2 w-4 h-4 bg-yellow-400 rounded-full animate-bounce"></div>
                                <div class="absolute -bottom-2 -left-2 w-3 h-3 bg-blue-400 rounded-full animate-bounce" style="animation-delay: 0.5s;"></div>
                            </div>
                        </div>
                        
                        <!-- Enhanced Welcome Text -->
                        <div class="space-y-4">
                            <h2 class="text-3xl font-bold text-gray-800 dark:text-white mb-4 animate-fade-in">
                                Welcome Back to <br/>
                            </h2>
                            <h1 class="text-4xl font-bold bg-gradient-to-r from-primaryGreen via-green-600 to-emerald-600 bg-clip-text text-transparent animate-gradient-x">
                                বিকল্প কম্পিউটার
            </h1>
                            <p class="text-lg text-gray-600 dark:text-gray-300 leading-relaxed animate-fade-in-up">
                                Sign in to your account to continue your learning journey! 🎓✨
                            </p>
                        </div>
                    </div>
                                 </div>
 
                 <!-- Right Column: Enhanced Login Form -->
                 <div class="flex flex-col justify-start text-center md:text-left p-4 space-y-6">
                    <div class="space-y-4">
                        <h1 class="text-4xl md:text-5xl font-extrabold bg-gradient-to-r from-gray-900 via-primaryGreen to-green-600 dark:from-white dark:via-primaryGreen dark:to-green-400 bg-clip-text text-transparent animate-fade-in-up">
                            Sign In
                        </h1>
                        
        </div>

                    <!-- Enhanced Login Form -->
                    <div class="animate-fade-in-up" style="animation-delay: 0.4s;">
                        <div class="w-full max-w-md mx-auto" id="loginFormContainer">
        <!-- Logout Section for Authenticated Users -->
        @auth
                            <div class="mb-6 p-4 bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-700 rounded-xl">
            <div class="text-center">
                <p class="text-sm text-blue-700 dark:text-blue-300 mb-3">
                    <i class="fas fa-info-circle mr-2"></i>
                    You are currently logged in as <strong>{{ Auth::user()->name ?? 'User' }}</strong>
                </p>
                <div class="flex flex-col sm:flex-row gap-2 justify-center">
                    <a 
                        href="{{ route('logout') }}" 
                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                        class="inline-flex items-center justify-center bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors duration-200"
                    >
                        <i class="fas fa-sign-out-alt mr-2"></i>
                        Logout Current Account
                    </a>
                    <a 
                        href="{{ Auth::user()->role === 'student' ? route('student.dashboard') : route('partner.dashboard') }}" 
                        class="inline-flex items-center justify-center bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors duration-200"
                    >
                        <i class="fas fa-tachometer-alt mr-2"></i>
                        Go to Dashboard
                    </a>
                </div>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
                    @csrf
                </form>
            </div>
        </div>
        @endauth

        <!-- Login Type Switch -->
        <div class="mb-6">
            <div class="flex items-center justify-center bg-gray-100 dark:bg-gray-700 rounded-xl p-1">
                <button 
                    type="button" 
                    id="partnerLoginBtn" 
                    class="flex-1 py-2 px-4 rounded-lg font-medium transition-all duration-200 bg-primaryGreen text-white shadow-md text-sm flex items-center justify-center"
                    onclick="switchLoginType('partner')"
                >
                    <i class="fas fa-handshake mr-2"></i>
                    Partner
                </button>
                <button 
                    type="button" 
                    id="studentLoginBtn" 
                    class="flex-1 py-2 px-4 rounded-lg font-medium transition-all duration-200 text-gray-600 dark:text-gray-400 hover:text-gray-800 dark:hover:text-gray-200 text-sm flex items-center justify-center"
                    onclick="switchLoginType('student')"
                >
                    <i class="fas fa-graduation-cap mr-2"></i>
                    Student
                </button>
            </div>
        </div>

        <!-- Login Type Indicator -->
        <div class="mb-6 text-center" id="loginTypeIndicator">
            <div class="inline-flex items-center px-4 py-2 bg-primaryGreen/10 dark:bg-primaryGreen/20 border border-primaryGreen/30 dark:border-primaryGreen/40 rounded-full">
                <div class="w-3 h-3 bg-primaryGreen rounded-full mr-2"></div>
                <span class="text-sm font-medium text-primaryGreen dark:text-primaryGreen-400" id="indicatorText">
                    Partner Login
                </span>
            </div>
        </div>

        <!-- Login Form -->
        <form method="POST" action="{{ route('login') }}" id="loginForm" class="space-y-4">
            @csrf
            <input type="hidden" name="login_type" id="loginType" value="partner">

            <!-- Email Address (Partner) / Phone Number (Student) -->
            <div class="space-y-1" id="emailField">
                <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                    Email Address
                </label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-envelope text-gray-400"></i>
                    </div>
                    <input 
                        id="email" 
                        type="email" 
                        name="email" 
                        value="{{ old('email') }}" 
                        autofocus 
                        autocomplete="username"
                        class="block w-full pl-10 pr-3 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-800 text-gray-900 dark:text-white placeholder-gray-500 dark:placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-primaryGreen focus:border-transparent transition-all duration-200"
                        placeholder="Enter your email"
                    />
                </div>
                <x-input-error :messages="$errors->get('email')" class="mt-1" />
            </div>

            <!-- Phone Number Field (Student) - Hidden by default -->
            <div class="space-y-1 hidden" id="phoneField">
                <label for="phone" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                    Phone Number
                </label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-phone text-gray-400"></i>
                    </div>
                    <input 
                        id="phone" 
                        type="tel" 
                        name="phone" 
                        value="{{ old('phone') }}" 
                        autocomplete="tel"
                        class="block w-full pl-10 pr-3 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-800 text-gray-900 dark:text-white placeholder-gray-500 dark:placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-primaryGreen focus:border-transparent transition-all duration-200"
                        placeholder="01XXXXXXXXX (11 digits)"
                        pattern="01[3-9][0-9]{8}"
                        maxlength="11"
                    />
                </div>
                <p class="text-xs text-gray-500 dark:text-gray-400">
                    Format: 01XXXXXXXXX (11 digits, starting with 01)
                </p>
                <x-input-error :messages="$errors->get('phone')" class="mt-1" />
            </div>

            <!-- Password -->
            <div class="space-y-1">
                <label for="password" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                    Password
                </label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-lock text-gray-400"></i>
                    </div>
                    <input 
                        id="password" 
                        type="password" 
                        name="password" 
                        required 
                        autocomplete="current-password"
                        class="block w-full pl-10 pr-3 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-800 text-gray-900 dark:text-white placeholder-gray-500 dark:placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-primaryGreen focus:border-transparent transition-all duration-200"
                        placeholder="Enter your password"
                    />
                </div>
                <x-input-error :messages="$errors->get('password')" class="mt-1" />
            </div>

            <!-- Remember Me & Forgot Password -->
            <div class="flex items-center justify-between">
                <label for="remember_me" class="flex items-center">
                    <input 
                        id="remember_me" 
                        type="checkbox" 
                        name="remember"
                        class="w-4 h-4 text-primaryGreen bg-gray-100 border-gray-300 rounded focus:ring-primaryGreen focus:ring-2"
                    >
                    <span class="ml-2 text-xs text-gray-600 dark:text-gray-400">
                        Remember me
                    </span>
                </label>

                @if (Route::has('password.request'))
                    <a 
                        href="{{ route('password.request') }}" 
                        class="text-xs text-primaryGreen hover:text-green-700 dark:text-green-400 dark:hover:text-green-300 transition-colors duration-200"
                    >
                        Forgot password?
                    </a>
                @endif
            </div>

            <!-- Submit Button -->
            <button 
                type="submit"
                class="w-full bg-gradient-to-r from-primaryGreen to-green-600 hover:from-green-600 hover:to-green-700 text-white font-semibold py-2.5 px-4 rounded-lg shadow-lg hover:shadow-xl transform hover:scale-[1.02] transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primaryGreen"
            >
                <i class="fas fa-sign-in-alt mr-2"></i>
                <span id="submitText">Sign In as Partner</span>
            </button>
        </form>

        <!-- Back to Home -->
        <div class="text-center mt-4">
            <a 
                href="{{ route('landing') }}" 
                class="text-xs text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-200 transition-colors duration-200"
            >
                <i class="fas fa-arrow-left mr-1"></i>
                Back to Home
            </a>
        </div>
    </div>
                                         </div>
                 </div>
 
                 <!-- Third Column: Additional Content -->
                 <div class="flex flex-col justify-start text-center md:text-left p-4 space-y-6">
                     <div class="space-y-4">
                         <h1 class="text-3xl md:text-4xl font-bold bg-gradient-to-r from-gray-900 via-primaryGreen to-green-600 dark:from-white dark:via-primaryGreen dark:to-green-400 bg-clip-text text-transparent animate-fade-in-up">
                             New to বিকল্প কম্পিউটার!
                         </h1>
                         <p class="text-lg text-gray-600 dark:text-gray-400 mb-6 animate-fade-in-up" style="animation-delay: 0.2s;">
                             Join our learning community today! 🎓✨
                         </p>
                     </div>
                     
                     <!-- Become a Partner Button -->
                     <div class="animate-fade-in-up" style="animation-delay: 0.4s;">
                         <a href="{{ route('partner.register') }}" class="group inline-block w-full bg-gradient-to-r from-primaryGreen via-green-500 to-emerald-600 hover:from-emerald-600 hover:via-green-600 hover:to-primaryGreen text-white font-bold py-4 px-6 rounded-2xl shadow-xl transition-all duration-500 transform hover:scale-105 hover:shadow-2xl hover:-translate-y-1 relative overflow-hidden">
                             <div class="absolute inset-0 bg-gradient-to-r from-white/20 to-transparent transform -skew-x-12 -translate-x-full group-hover:translate-x-full transition-transform duration-700"></div>
                             <span class="relative flex items-center justify-center">
                                 <i class="fas fa-handshake mr-3 text-lg"></i>
                                 Become a Partner
                                 <i class="fas fa-arrow-right ml-3 group-hover:translate-x-2 transition-transform duration-300"></i>
                             </span>
                         </a>
                     </div>
                     
                     <!-- Enroll as a Student Button -->
                     <div class="animate-fade-in-up" style="animation-delay: 0.6s;">
                         <a href="{{ route('student.register') }}" class="group inline-block w-full bg-gradient-to-r from-primaryBlue via-blue-500 to-indigo-600 hover:from-indigo-600 hover:via-blue-600 hover:to-primaryBlue text-white font-bold py-4 px-6 rounded-2xl shadow-xl transition-all duration-500 transform hover:scale-105 hover:shadow-2xl hover:-translate-y-1 relative overflow-hidden">
                             <div class="absolute inset-0 bg-gradient-to-r from-white/20 to-transparent transform -skew-x-12 -translate-x-full group-hover:translate-x-full transition-transform duration-700"></div>
                             <span class="relative flex items-center justify-center">
                                 <i class="fas fa-graduation-cap mr-3 text-lg"></i>
                                 Enroll as a Student
                                 <i class="fas fa-arrow-right ml-3 group-hover:translate-x-2 transition-transform duration-300"></i>
                             </span>
                         </a>
                     </div>
                     
                     <!-- Additional Info -->
                     <div class="mt-8 space-y-4 animate-fade-in-up" style="animation-delay: 0.8s;">
                         <div class="p-4 bg-gradient-to-r from-blue-50 to-indigo-50 dark:from-blue-900/20 dark:to-indigo-900/20 rounded-2xl border border-blue-200 dark:border-blue-700">
                             <div class="flex items-center space-x-3 mb-2">
                                 <i class="fas fa-lightbulb text-yellow-500 text-xl"></i>
                                 <h3 class="font-semibold text-blue-800 dark:text-blue-200">Why Choose Us?</h3>
                             </div>
                             <ul class="text-sm text-blue-700 dark:text-blue-300 space-y-1">
                                 <li class="flex items-center space-x-2">
                                     <i class="fas fa-check text-green-500 text-xs"></i>
                                     <span>Interactive Learning Experience</span>
                                 </li>
                                 <li class="flex items-center space-x-2">
                                     <i class="fas fa-check text-green-500 text-xs"></i>
                                     <span>Expert-Led Content</span>
                                 </li>
                                 <li class="flex items-center space-x-2">
                                     <i class="fas fa-check text-green-500 text-xs"></i>
                                     <span>Flexible Study Schedule</span>
                                 </li>
                             </ul>
                         </div>
                     </div>
                 </div>
 
             </div>
        </div>
    </main>

    <!-- Footer -->
    <footer class="bg-gray-900 text-gray-200 py-5 mt-auto">
        <div class="max-w-6xl mx-auto px-3 sm:flex sm:justify-between sm:items-center">
            <!-- Logo & Name -->
            <div class="flex items-center space-x-4 mb-6 sm:mb-0">
                <a href="#" class="flex items-center gap-3">
                    <div class="relative">
                        <div class="w-20 h-20 bg-gradient-to-br from-primaryGreen via-green-500 to-green-600 rounded-2xl flex items-center justify-center shadow-lg">
                            <img src="{{ asset('images/logo.png') }}" alt="Bikolpo Computer Logo" class="w-12 h-12 object-contain" />
                        </div>
                        <div class="absolute -inset-1 bg-gradient-to-r from-primaryGreen to-green-600 rounded-2xl blur opacity-25"></div>
                    </div>
                    <div>
                        <h1 class="text-white text-xl font-bold">বিকল্প কম্পিউটার</h1>
                        <p class="text-sm">Your Smart Exam Partner</p>
                    </div>
                </a>
            </div>

            <!-- Contact Info -->
            <div class="text-sm space-y-1 mb-5 sm:mb-0">
                <p>🏠 ঠিকানা: উদ্ভাস কোচিং এর নিচ তলা, কলেজ রোড, আলমনগর, রংপুর।</p>
                <p>📞 ফোন: <a href="https://wa.me/8801610800060" class="hover:text-white">+880 1610800060</a></p>
                <p>✉️ ইমেইল: <a href="mailto:bikolpo247@gmail.com" class="hover:text-white">bikolpo247@gmail.com</a></p>
            </div>

            <!-- Social Links -->
            <div class="flex space-x-5 text-white text-2xl">
                <a href="https://facebook.com/bikolpocomputer.rangpur" target="_blank" aria-label="Facebook" class="hover:text-blue-600 transition">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="w-7 h-7" viewBox="0 0 24 24">
                        <path d="M22.675 0H1.325C.593 0 0 .593 0 1.325v21.351C0 23.407.593 24 1.325 24H12.82v-9.294H9.692v-3.622h3.128V8.413c0-3.1 1.894-4.788 4.659-4.788 1.325 0 2.464.099 2.797.143v3.24l-1.92.001c-1.506 0-1.798.716-1.798 1.767v2.317h3.594l-.468 3.622h-3.126V24h6.127c.73 0 1.323-.593 1.323-1.324V1.325C24 .593 23.407 0 22.675 0z"/>
                    </svg>
                </a>
            </div>
        </div>

        <div class="mt-4 text-center text-s text-white">
            © 2025 Bikolpo Computer. All rights reserved.
        </div>
    </footer>

    <script>
        // Dark Mode Toggle
        const darkToggle = document.getElementById('darkToggle');
        const html = document.documentElement;
        
        // Check for saved theme preference
        if (localStorage.getItem('theme') === 'dark' || (!localStorage.getItem('theme') && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            html.classList.add('dark');
        }
        
        darkToggle.addEventListener('click', () => {
            html.classList.toggle('dark');
            localStorage.setItem('theme', html.classList.contains('dark') ? 'dark' : 'light');
        });

        // Mobile Menu Toggle
        const mobileMenuBtn = document.getElementById('mobileMenuBtn');
        const mobileMenu = document.getElementById('mobileMenu');
        
        mobileMenuBtn.addEventListener('click', () => {
            mobileMenu.classList.toggle('hidden');
        });

        function switchLoginType(type) {
            const partnerBtn = document.getElementById('partnerLoginBtn');
            const studentBtn = document.getElementById('studentLoginBtn');
            const loginType = document.getElementById('loginType');
            const submitText = document.getElementById('submitText');
            const form = document.getElementById('loginForm');
            const emailField = document.getElementById('emailField');
            const phoneField = document.getElementById('phoneField');
            const emailInput = document.getElementById('email');
            const phoneInput = document.getElementById('phone');
            const registerLink = document.getElementById('registerLink');
            const registerText = document.getElementById('registerText');
            const indicatorText = document.getElementById('indicatorText');
            const loginFormContainer = document.getElementById('loginFormContainer');


            if (type === 'partner') {
                // Partner login
                partnerBtn.className = 'flex-1 py-2 px-4 rounded-lg font-medium transition-all duration-200 bg-primaryGreen text-white shadow-md text-sm flex items-center justify-center';
                studentBtn.className = 'flex-1 py-2 px-4 rounded-lg font-medium transition-all duration-200 text-gray-600 dark:text-gray-400 hover:text-gray-800 dark:hover:text-gray-200 text-sm flex items-center justify-center';
                loginType.value = 'partner';
                submitText.textContent = 'Sign In as Partner';
                form.action = '{{ route("login") }}';
                
                // Update register link for partner
                registerLink.href = '{{ route("partner.register") }}';
                registerText.textContent = 'Create Partner Account';
                
                // Show email field, hide phone field
                emailField.classList.remove('hidden');
                phoneField.classList.add('hidden');
                
                // Set required attributes and field names
                emailInput.required = true;
                phoneInput.required = false;
                emailInput.name = 'email';
                phoneInput.name = 'phone_disabled';
                
                // Clear phone input when switching to partner
                phoneInput.value = '';
                indicatorText.textContent = 'Partner Login';
                loginFormContainer.classList.remove('bg-gray-100', 'dark:bg-gray-700');
                 

            } else {
                // Student login
                studentBtn.className = 'flex-1 py-2 px-4 rounded-lg font-medium transition-all duration-200 bg-primaryGreen text-white shadow-md text-sm flex items-center justify-center';
                partnerBtn.className = 'flex-1 py-2 px-4 rounded-lg font-medium transition-all duration-200 text-gray-600 dark:text-gray-400 hover:text-gray-800 dark:hover:text-gray-200 text-sm flex items-center justify-center';
                loginType.value = 'student';
                submitText.textContent = 'Sign In as Student';
                form.action = '{{ route("login") }}';
                
                // Update register link for student
                registerLink.href = '{{ route("student.register") }}';
                registerText.textContent = 'Create Student Account';
                
                // Show phone field, hide email field
                emailField.classList.add('hidden');
                phoneField.classList.remove('hidden');
                
                // Set required attributes and field names
                emailInput.required = false;
                phoneInput.required = true;
                emailInput.name = 'email_disabled';
                phoneInput.name = 'phone';
                
                // Clear email input when switching to student
                emailInput.value = '';
                indicatorText.textContent = 'Student Login';
                loginFormContainer.classList.add('bg-gray-100', 'dark:bg-gray-700');
                 

            }
        }

        // Initialize with partner login selected
        document.addEventListener('DOMContentLoaded', function() {
            switchLoginType('partner');
        });
    </script>

    <style>
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        @keyframes slideUp {
            from { opacity: 0; transform: translateY(40px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        @keyframes float {
            0%, 100% { transform: translateY(0px) rotate(0deg); }
            50% { transform: translateY(-10px) rotate(1deg); }
        }
        
        @keyframes gradient-x {
            0%, 100% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
        }
        
        .animate-float {
            animation: float 3s ease-in-out infinite;
        }
        
        .animate-gradient-x {
            background-size: 200% 200%;
            animation: gradient-x 3s ease infinite;
        }
        
        .animate-fade-in {
            animation: fadeIn 0.8s ease-out;
        }
        
        .animate-fade-in-up {
            animation: fadeIn 0.8s ease-out, slideUp 1s ease-out;
        }
        
        .shadow-3xl {
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
        }
    </style>
</body>
</html>
