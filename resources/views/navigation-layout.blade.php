<header class="bg-white/90 dark:bg-gray-900/95 backdrop-blur-md border-b border-gray-200 dark:border-gray-700 sticky top-0 z-50 transition-all duration-300">
    <!-- Font Imports -->
    <link href="https://fonts.googleapis.com/css2?family=Fredoka:wght@300;400;500;600;700&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@300;400;500;600;700&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Lilita+One&display=swap" rel="stylesheet" />
    
    <style>
        /* Brand gradient styles for navigation */
        .brand-gradient-contrast {
            background: linear-gradient(135deg, #047857 0%, #1d4ed8 50%, #6d28d9 100%);
            -webkit-background-clip: text;
            background-clip: text;
            -webkit-text-fill-color: transparent;
            color: #047857; /* Fallback color */
        }
    </style>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center py-4">
            <!-- Logo -->
            <div class="flex items-center space-x-3">
                <x-branding size="lg" :href="route('landing')" bg="bg-white/90 dark:bg-gray-900/70" />
            </div>

            <!-- Desktop Navigation -->
            <nav class="hidden md:flex items-center space-x-8">
                <a href="{{ route('about') }}" class="text-gray-700 dark:text-white hover:text-primaryGreen dark:hover:text-primaryGreen transition-colors duration-200 font-medium">
                    About
                </a>
                <a href="{{ route('contact') }}" class="text-gray-700 dark:text-white hover:text-primaryGreen dark:hover:text-primaryGreen transition-colors duration-200 font-medium">
                    Contact
                </a>
                <a href="{{ route('partner.features') }}" class="text-gray-700 dark:text-white hover:text-primaryGreen dark:hover:text-primaryGreen transition-colors duration-200 font-medium">
                    For Partner
                </a>
                <a href="{{ route('student.features') }}" class="text-gray-700 dark:text-white hover:text-primaryGreen dark:hover:text-primaryGreen transition-colors duration-200 font-medium">
                    For Student
                </a>
                <a href="{{ route('login') }}" class="bg-gradient-to-r from-primaryGreen to-green-600 hover:from-green-600 hover:to-green-700 text-white px-6 py-2 rounded-full font-semibold transition-all duration-300 transform hover:scale-105 shadow-lg hover:shadow-xl">
                    Sign In
                </a>
                <a href="{{ route('public.quiz.access') }}" target="_blank" class="bg-white dark:bg-gray-800 hover:bg-gray-100 dark:hover:bg-gray-700 text-primaryBlue dark:text-primaryBlue font-bold px-4 py-2 rounded-full shadow-lg transition-all duration-300 transform hover:scale-105 border-2 border-primaryBlue">
                    Live Exam
                </a>
            </nav>

            <!-- Dark Mode Toggle & Mobile Menu -->
            <div class="flex items-center space-x-4">
                <button id="darkToggle" class="p-2.5 rounded-lg bg-gray-100 dark:bg-gray-800 text-gray-600 dark:text-gray-400 hover:bg-gray-200 dark:hover:bg-gray-700 transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-primaryGreen/20">
                    <svg class="w-6 h-6 dark:hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"></path>
                    </svg>
                    <svg class="w-6 h-6 hidden dark:block" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"></path>
                    </svg>
                </button>
                
                <button id="mobileMenuBtn" class="md:hidden p-2.5 rounded-lg bg-gray-100 dark:bg-gray-800 text-gray-600 dark:text-gray-400 hover:bg-gray-200 dark:hover:bg-gray-700 transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-primaryGreen/20">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                </button>
            </div>
        </div>

        <!-- Mobile Menu -->
        <div id="mobileMenu" class="md:hidden pb-6 border-t border-gray-200 dark:border-gray-700 mt-4 bg-white dark:bg-gray-900 shadow-lg transform transition-all duration-300 ease-in-out" style="display: none; position: relative; z-index: 40; opacity: 1; transform: translateY(0);">
            <div class="flex flex-col pt-4 px-4">
                <!-- All Menu Items -->
                <div class="space-y-1">
                    <a href="{{ route('about') }}" class="block text-gray-700 dark:text-white hover:text-primaryGreen dark:hover:text-primaryGreen transition-all duration-200 font-medium py-3 px-4 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-800 active:bg-gray-100 dark:active:bg-gray-800 touch-manipulation">
                        <div class="flex items-center">
                            <svg class="w-4 h-4 mr-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1a3 3 0 01-3-3V6a3 3 0 013-3h1m-1 0v18m0 0h1a3 3 0 013 3v7a3 3 0 01-3 3h-1"></path>
                            </svg>
                            About
                        </div>
                    </a>
                    <a href="{{ route('contact') }}" class="block text-gray-700 dark:text-white hover:text-primaryGreen dark:hover:text-primaryGreen transition-all duration-200 font-medium py-3 px-4 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-800 active:bg-gray-100 dark:active:bg-gray-800 touch-manipulation">
                        <div class="flex items-center">
                            <svg class="w-4 h-4 mr-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                            </svg>
                            Contact
                        </div>
                    </a>
                    <a href="{{ route('partner.features') }}" class="block text-primaryGreen dark:text-primaryGreen hover:text-green-600 dark:hover:text-green-400 transition-all duration-200 font-medium py-3 px-4 rounded-lg hover:bg-green-50 dark:hover:bg-green-900/20 active:bg-green-100 dark:active:bg-green-900/30 touch-manipulation">
                        <div class="flex items-center">
                            <svg class="w-4 h-4 mr-3 text-primaryGreen" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                            </svg>
                            For Partner
                        </div>
                    </a>
                    <a href="{{ route('student.features') }}" class="block text-primaryBlue dark:text-primaryBlue hover:text-blue-600 dark:hover:text-blue-400 transition-all duration-200 font-medium py-3 px-4 rounded-lg hover:bg-blue-50 dark:hover:bg-blue-900/20 active:bg-blue-100 dark:active:bg-blue-900/30 touch-manipulation">
                        <div class="flex items-center">
                            <svg class="w-4 h-4 mr-3 text-primaryBlue" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                            </svg>
                            For Student
                        </div>
                    </a>
                    <a href="{{ route('login') }}" class="block text-primaryGreen dark:text-primaryGreen hover:text-green-600 dark:hover:text-green-400 transition-all duration-200 font-medium py-3 px-4 rounded-lg hover:bg-green-50 dark:hover:bg-green-900/20 active:bg-green-100 dark:active:bg-green-900/30 touch-manipulation">
                        <div class="flex items-center">
                            <svg class="w-4 h-4 mr-3 text-primaryGreen" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path>
                            </svg>
                            Sign In
                        </div>
                    </a>
                    <a href="{{ route('public.quiz.access') }}" target="_blank" class="block text-primaryBlue dark:text-primaryBlue hover:text-blue-600 dark:hover:text-blue-400 transition-all duration-200 font-medium py-3 px-4 rounded-lg hover:bg-blue-50 dark:hover:bg-blue-900/20 active:bg-blue-100 dark:active:bg-blue-900/30 touch-manipulation">
                        <div class="flex items-center">
                            <svg class="w-4 h-4 mr-3 text-primaryBlue" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                            </svg>
                            Live Exam
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- JavaScript for Header Functionality -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            console.log('Navigation layout script loaded');
            
            // Dark Mode Toggle
            const darkToggle = document.getElementById('darkToggle');
            const html = document.documentElement;
            
            if (darkToggle) {
                // Check for saved theme preference
                if (localStorage.getItem('theme') === 'dark' || (!localStorage.getItem('theme') && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
                    html.classList.add('dark');
                }
                
                darkToggle.addEventListener('click', () => {
                    html.classList.toggle('dark');
                    localStorage.setItem('theme', html.classList.contains('dark') ? 'dark' : 'light');
                });
            }

            // Mobile Menu Toggle
            const mobileMenuBtn = document.getElementById('mobileMenuBtn');
            const mobileMenu = document.getElementById('mobileMenu');
            
            console.log('Mobile menu elements:', { mobileMenuBtn, mobileMenu });
            
            if (mobileMenuBtn && mobileMenu) {
                console.log('Mobile menu button found, adding click listener');
                mobileMenuBtn.addEventListener('click', () => {
                    console.log('Mobile menu button clicked');
                    const isHidden = mobileMenu.style.display === 'none';
                    
                    if (isHidden) {
                        // Show menu with animation
                        mobileMenu.style.display = 'block';
                        mobileMenu.style.opacity = '0';
                        mobileMenu.style.transform = 'translateY(-10px)';
                        
                        // Trigger animation
                        setTimeout(() => {
                            mobileMenu.style.opacity = '1';
                            mobileMenu.style.transform = 'translateY(0)';
                        }, 10);
                    } else {
                        // Hide menu with animation
                        mobileMenu.style.opacity = '0';
                        mobileMenu.style.transform = 'translateY(-10px)';
                        
                        setTimeout(() => {
                            mobileMenu.style.display = 'none';
                        }, 200);
                    }
                    
                    console.log('Mobile menu hidden:', !isHidden);
                });
            } else {
                console.error('Mobile menu elements not found:', { mobileMenuBtn, mobileMenu });
            }

            // Header scroll effect
            const header = document.querySelector('header');
            if (header) {
                window.addEventListener('scroll', () => {
                    if (window.scrollY > 100) {
                        header.classList.add('shadow-lg', 'bg-white/95', 'dark:bg-gray-900/95');
                    } else {
                        header.classList.remove('shadow-lg', 'bg-white/95', 'dark:bg-gray-900/95');
                    }
                });
            }
        });
    </script>
</header>