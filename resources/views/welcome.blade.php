<!DOCTYPE html>
<html lang="bn" class="scroll-smooth">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>বিকল্প কম্পিউটার - Online Test Platform</title>
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

<body class="bg-gradient-to-br from-gray-50 to-gray-100 dark:from-gray-900 dark:to-gray-800 text-gray-800 dark:text-gray-100 font-bangla">
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
                             <h1 class="text-2xl font-bold bg-gradient-to-r from-primaryGreen to-primaryBlue bg-clip-text bg-clip-text text-transparent">
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

    <!-- Hero Section -->
    <section class="relative overflow-hidden bg-gradient-to-br from-white via-blue-50 to-indigo-100 dark:from-gray-900 dark:via-gray-800 dark:to-gray-900 py-12 lg:py-20">
        <div class="absolute inset-0 bg-grid-pattern opacity-5"></div>
        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <div class="animate-fade-in">
                <h1 class="text-4xl md:text-6xl lg:text-7xl font-bold text-gray-900 dark:text-white mb-6 leading-tight">
                    <span class="bg-gradient-to-r from-primaryGreen via-primaryBlue to-primaryPurple bg-clip-text text-transparent">
                        বিকল্প কম্পিউটার
                    </span>
                    <br />
                    <span class="text-3xl md:text-4xl lg:text-5xl text-gray-700 dark:text-gray-300">
                        Your Smart Exam Partner
                    </span>
                </h1>
                <p class="text-xl md:text-2xl text-gray-600 dark:text-gray-400 mb-8 max-w-3xl mx-auto leading-relaxed">
                    Transform your learning experience with our comprehensive online testing platform. 
                    Practice, improve, and excel with বিকল্প কম্পিউটার.
                </p>
                <div class="flex flex-col sm:flex-row gap-4 justify-center items-center">
                    <a href="{{ route('partner.register') }}" class="group bg-gradient-to-r from-primaryGreen to-green-600 hover:from-green-600 hover:to-green-700 text-white px-8 py-4 rounded-full font-bold text-lg transition-all duration-300 transform hover:scale-105 shadow-xl hover:shadow-2xl">
                        Get Started Free
                        <i class="fas fa-arrow-right ml-2 group-hover:translate-x-1 transition-transform duration-200"></i>
                    </a>
                    <a href="{{ route('typing.test') }}" class="group bg-gradient-to-r from-primaryOrange to-orange-600 hover:from-orange-600 hover:to-orange-700 text-white px-8 py-4 rounded-full font-bold text-lg transition-all duration-300 transform hover:scale-105 shadow-xl hover:shadow-2xl">
                        Try Typing Test
                        <i class="fas fa-keyboard ml-2 group-hover:scale-110 transition-transform duration-200"></i>
                    </a>
                    <a href="#features" class="group bg-white dark:bg-gray-800 text-gray-700 dark:text-gray-300 border-2 border-gray-300 dark:border-gray-600 hover:border-primaryGreen dark:hover:border-primaryGreen px-8 py-4 rounded-full font-bold text-lg transition-all duration-300 hover:shadow-lg">
                        Learn More
                        <i class="fas fa-chevron-down ml-2 group-hover:translate-y-1 transition-transform duration-200"></i>
                    </a>
                </div>
            </div>
        </div>
        
        <!-- Floating Elements -->
        <div class="absolute top-20 left-10 w-20 h-20 bg-primaryGreen/20 rounded-full animate-bounce-slow"></div>
        <div class="absolute top-40 right-20 w-16 h-16 bg-primaryOrange/20 rounded-full animate-pulse-slow"></div>
        <div class="absolute bottom-20 left-20 w-12 h-12 bg-primaryBlue/20 rounded-full animate-bounce-slow animation-delay-1000"></div>
    </section>

    <!-- Features Section -->
    <section id="features" class="py-20 bg-white dark:bg-gray-900">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-3xl md:text-4xl lg:text-5xl font-bold text-gray-900 dark:text-white mb-6">
                    Powerful Features for Modern Learning
                </h2>
                <p class="text-xl text-gray-600 dark:text-gray-400 max-w-3xl mx-auto">
                    Everything you need to create, manage, and take online exams with ease
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <!-- Feature Card 1 -->
                <div class="group bg-gradient-to-br from-white to-gray-50 dark:from-gray-800 dark:to-gray-900 p-8 rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2 border border-gray-200 dark:border-gray-700">
                    <div class="w-16 h-16 bg-gradient-to-br from-primaryGreen to-green-600 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-300">
                        <i class="fas fa-question-circle text-white text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-4">MCQ Testing</h3>
                    <p class="text-gray-600 dark:text-gray-400 leading-relaxed">
                        Create and take multiple choice questions with instant scoring and detailed analytics.
                    </p>
                </div>

                <!-- Feature Card 2 -->
                <div class="group bg-gradient-to-br from-white to-gray-50 dark:from-gray-800 dark:to-gray-900 p-8 rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2 border border-gray-200 dark:border-gray-700">
                    <div class="w-16 h-16 bg-gradient-to-br from-primaryOrange to-orange-600 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-300">
                        <i class="fas fa-keyboard text-white text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-4">Typing Tests</h3>
                    <p class="text-gray-600 dark:text-gray-400 leading-relaxed">
                        Improve your typing speed and accuracy with our comprehensive typing assessment tools.
                    </p>
                </div>

                <!-- Feature Card 3 -->
                <div class="group bg-gradient-to-br from-white to-gray-50 dark:from-gray-800 dark:to-gray-900 p-8 rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2 border border-gray-200 dark:border-gray-700">
                    <div class="w-16 h-16 bg-gradient-to-br from-primaryBlue to-blue-600 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-300">
                        <i class="fas fa-chart-line text-white text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-4">Progress Tracking</h3>
                    <p class="text-gray-600 dark:text-gray-400 leading-relaxed">
                        Monitor your performance with detailed progress reports and performance analytics.
                    </p>
                </div>

                <!-- Feature Card 4 -->
                <div class="group bg-gradient-to-br from-white to-gray-50 dark:from-gray-800 dark:to-gray-900 p-8 rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2 border border-gray-200 dark:border-gray-700">
                    <div class="w-16 h-16 bg-gradient-to-br from-primaryPurple to-purple-600 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-300">
                        <i class="fas fa-users text-white text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-4">Partner Management</h3>
                    <p class="text-gray-600 dark:text-gray-400 leading-relaxed">
                        Manage multiple partners, courses, and student batches with our comprehensive admin tools.
                    </p>
                </div>

                <!-- Feature Card 5 -->
                <div class="group bg-gradient-to-br from-white to-gray-50 dark:from-gray-800 dark:to-gray-900 p-8 rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2 border border-gray-200 dark:border-gray-700">
                    <div class="w-16 h-16 bg-gradient-to-br from-green-500 to-emerald-600 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-300">
                        <i class="fas fa-shield-alt text-white text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-4">Secure Platform</h3>
                    <p class="text-gray-600 dark:text-gray-400 leading-relaxed">
                        Enterprise-grade security with encrypted data transmission and secure authentication.
                    </p>
                </div>

                <!-- Feature Card 6 -->
                <div class="group bg-gradient-to-br from-white to-gray-50 dark:from-gray-800 dark:to-gray-900 p-8 rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2 border border-gray-200 dark:border-gray-700">
                    <div class="w-16 h-16 bg-gradient-to-br from-pink-500 to-rose-600 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-300">
                        <i class="fas fa-mobile-alt text-white text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-4">Mobile Responsive</h3>
                    <p class="text-gray-600 dark:text-gray-400 leading-relaxed">
                        Take exams anywhere with our fully responsive design that works on all devices.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Stats Section -->
    <section class="py-20 bg-gradient-to-r from-primaryGreen to-green-600 text-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8 text-center">
                <div class="group">
                    <div class="text-4xl md:text-5xl font-bold mb-2 group-hover:scale-110 transition-transform duration-300">
                        <span class="counter" data-target="1000">0</span>+
                    </div>
                    <p class="text-green-100 text-lg">Active Users</p>
                </div>
                <div class="group">
                    <div class="text-4xl md:text-5xl font-bold mb-2 group-hover:scale-110 transition-transform duration-300">
                        <span class="counter" data-target="500">0</span>+
                    </div>
                    <p class="text-green-100 text-lg">Exams Created</p>
                </div>
                <div class="group">
                    <div class="text-4xl md:text-5xl font-bold mb-2 group-hover:scale-110 transition-transform duration-300">
                        <span class="counter" data-target="50">0</span>+
                    </div>
                    <p class="text-green-100 text-lg">Partners</p>
                </div>
                <div class="group">
                    <div class="text-4xl md:text-5xl font-bold mb-2 group-hover:scale-110 transition-transform duration-300">
                        <span class="counter" data-target="99">0</span>%
                    </div>
                    <p class="text-green-100 text-lg">Uptime</p>
                </div>
            </div>
        </div>
    </section>

    <!-- About Section -->
    <section id="about" class="py-20 bg-gray-50 dark:bg-gray-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                <div class="animate-slide-up">
                    <h2 class="text-3xl md:text-4xl font-bold text-gray-900 dark:text-white mb-6">
                        Why Choose বিকল্প কম্পিউটার?
                    </h2>
                    <p class="text-lg text-gray-600 dark:text-gray-400 mb-6 leading-relaxed">
                        বিকল্প কম্পিউটার is designed to revolutionize online education and testing. Our platform combines cutting-edge technology with user-friendly design to provide the best learning experience.
                    </p>
                    <div class="space-y-4">
                        <div class="flex items-start space-x-3">
                            <div class="w-6 h-6 bg-primaryGreen rounded-full flex items-center justify-center flex-shrink-0 mt-1">
                                <i class="fas fa-check text-white text-xs"></i>
                            </div>
                            <p class="text-gray-700 dark:text-gray-300">Advanced question management system</p>
                        </div>
                        <div class="flex items-start space-x-3">
                            <div class="w-6 h-6 bg-primaryGreen rounded-full flex items-center justify-center flex-shrink-0 mt-1">
                                <i class="fas fa-check text-white text-xs"></i>
                            </div>
                            <p class="text-gray-700 dark:text-gray-300">Real-time analytics and reporting</p>
                        </div>
                        <div class="flex items-start space-x-3">
                            <div class="w-6 h-6 bg-primaryGreen rounded-full flex items-center justify-center flex-shrink-0 mt-1">
                                <i class="fas fa-check text-white text-xs"></i>
                            </div>
                            <p class="text-gray-700 dark:text-gray-300">Multi-language support</p>
                        </div>
                        <div class="flex items-start space-x-3">
                            <div class="w-6 h-6 bg-primaryGreen rounded-full flex items-center justify-center flex-shrink-0 mt-1">
                                <i class="fas fa-check text-white text-xs"></i>
                            </div>
                            <p class="text-gray-700 dark:text-gray-300">24/7 customer support</p>
                        </div>
                    </div>
                </div>
                <div class="relative">
                    <div class="bg-gradient-to-br from-primaryGreen to-green-600 rounded-3xl p-8 shadow-2xl">
                        <div class="text-center text-white">
                            <i class="fas fa-rocket text-6xl mb-6"></i>
                            <h3 class="text-2xl font-bold mb-4">Ready to Get Started?</h3>
                            <p class="text-green-100 mb-6">Join thousands of users who trust Bikolpo C-Suitee for their online testing needs.</p>
                                                <a href="{{ route('partner.register') }}" class="bg-white text-primaryGreen px-8 py-3 rounded-full font-bold hover:bg-gray-100 transition-colors duration-200 inline-block">
                        Start Free Trial
                    </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-20 bg-gradient-to-r from-primaryBlue to-indigo-600 text-white">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h2 class="text-3xl md:text-4xl font-bold mb-6">
                Ready to Transform Your Learning Experience?
            </h2>
            <p class="text-xl text-blue-100 mb-8 leading-relaxed">
                Join বিকল্প কম্পিউটার today and discover a smarter way to learn, test, and grow.
            </p>
                            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <a href="{{ route('partner.register') }}" class="bg-white text-primaryBlue px-8 py-4 rounded-full font-bold text-lg hover:bg-gray-100 transition-colors duration-200 transform hover:scale-105 shadow-lg">
                        Become a Partner
                    </a>
                    <a href="{{ route('partner.register') }}" class="border-2 border-white text-white px-8 py-4 rounded-full font-bold text-lg hover:bg-white hover:text-primaryBlue transition-all duration-200">
                        Get Started Free
                    </a>
                </div>
                <div class="mt-4 text-center">
                    <p class="text-blue-100 text-sm">
                        Already have an account? 
                        <a href="{{ route('login') }}" class="text-white hover:text-blue-200 underline font-medium transition-colors duration-200">
                            Sign In here
                        </a>
                    </p>
                </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-900 text-gray-200 py-5 mt-auto">
        <div class="max-w-6xl mx-auto px-3 sm:flex sm:justify-between sm:items-center">
            <!-- Logo & Name -->
            <div class="flex items-center space-x-4 mb-6 sm:mb-0">
              <a href="#" class="flex items-center gap-3">
                <img src="{{ asset('images/logo.png') }}" alt="Bikolpo Computer Logo" class="w-20 h-20 rounded-full shadow-md" />
                <div>
                    <h1 class="text-white text-xl font-bold">বিকল্প কম্পিউটার</h1>
                    <p class="text-sm">Your Smart Exam Partner</p>
                </div>
              </a>
            </div>

            <!-- Contact Info -->
            <div class="text-sm space-y-1 mb-5 sm:mb-0 ">
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

    <!-- Back to Top Button -->
    <button id="backToTop" class="fixed bottom-8 right-8 w-12 h-12 bg-primaryGreen hover:bg-green-600 text-white rounded-full shadow-lg hover:shadow-xl transition-all duration-300 transform hover:scale-110 opacity-0 invisible">
        <i class="fas fa-arrow-up"></i>
    </button>

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

        // Smooth Scrolling for Anchor Links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });

        // Back to Top Button
        const backToTopBtn = document.getElementById('backToTop');
        
        window.addEventListener('scroll', () => {
            if (window.pageYOffset > 300) {
                backToTopBtn.classList.remove('opacity-0', 'invisible');
                backToTopBtn.classList.add('opacity-100', 'visible');
            } else {
                backToTopBtn.classList.add('opacity-0', 'invisible');
                backToTopBtn.classList.remove('opacity-100', 'visible');
            }
        });
        
        backToTopBtn.addEventListener('click', () => {
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        });

        // Counter Animation
        const counters = document.querySelectorAll('.counter');
        const speed = 200;

        const animateCounters = () => {
            counters.forEach(counter => {
                const target = +counter.getAttribute('data-target');
                const count = +counter.innerText;
                const increment = target / speed;

                if (count < target) {
                    counter.innerText = Math.ceil(count + increment);
                    setTimeout(animateCounters, 1);
                } else {
                    counter.innerText = target;
                }
            });
        };

        // Intersection Observer for counter animation
        const observerOptions = {
            threshold: 0.7
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    animateCounters();
                    observer.unobserve(entry.target);
                }
            });
        }, observerOptions);

        const statsSection = document.querySelector('.bg-gradient-to-r.from-primaryGreen');
        if (statsSection) {
            observer.observe(statsSection);
        }

        // Header scroll effect
        const header = document.querySelector('header');
        window.addEventListener('scroll', () => {
            if (window.scrollY > 100) {
                header.classList.add('shadow-lg', 'bg-white/95', 'dark:bg-gray-900/95');
            } else {
                header.classList.remove('shadow-lg', 'bg-white/95', 'dark:bg-gray-900/95');
            }
        });
    </script>

    <style>
        .bg-grid-pattern {
            background-image: 
                linear-gradient(rgba(0,0,0,0.1) 1px, transparent 1px),
                linear-gradient(90deg, rgba(0,0,0,0.1) 1px, transparent 1px);
            background-size: 20px 20px;
        }
        
        .animation-delay-1000 {
            animation-delay: 1s;
        }
        
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        @keyframes slideUp {
            from { opacity: 0; transform: translateY(40px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
</body>
</html>
