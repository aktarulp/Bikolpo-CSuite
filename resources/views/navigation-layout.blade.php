<!-- Ultra-Modern Navigation Header -->
<header class="relative bg-white/95 dark:bg-gray-900/95 backdrop-blur-xl border-b border-gray-200/50 dark:border-gray-700/50 sticky top-0 z-50 transition-all duration-500 shadow-sm hover:shadow-lg">
    <!-- Animated Background Gradient -->
    <div class="absolute inset-0 bg-gradient-to-r from-primaryGreen/5 via-transparent to-primaryBlue/5 opacity-50"></div>
    
    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center py-3 lg:py-4">
            <!-- Enhanced Logo Section -->
            <div class="flex items-center space-x-3 group">
                <div class="relative">
                    <div class="absolute inset-0 bg-gradient-to-r from-primaryGreen to-primaryBlue rounded-2xl blur-sm opacity-30 group-hover:opacity-50 transition-opacity duration-300"></div>
                    <x-branding size="lg" :href="route('landing')" bg="bg-white/90 dark:bg-gray-900/70" />
                </div>
            </div>

            <!-- Ultra-Modern Desktop Navigation -->
            <nav class="hidden md:flex items-center space-x-1">
                <a href="{{ route('about') }}" class="group relative px-4 py-2.5 rounded-xl text-gray-700 dark:text-white hover:text-primaryGreen dark:hover:text-primaryGreen transition-all duration-300 font-medium hover:bg-gradient-to-r hover:from-primaryGreen/10 hover:to-transparent">
                    <span class="relative z-10">About</span>
                    <div class="absolute inset-0 bg-gradient-to-r from-primaryGreen/20 to-transparent rounded-xl opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                </a>
                <a href="{{ route('contact') }}" class="group relative px-4 py-2.5 rounded-xl text-gray-700 dark:text-white hover:text-primaryGreen dark:hover:text-primaryGreen transition-all duration-300 font-medium hover:bg-gradient-to-r hover:from-primaryGreen/10 hover:to-transparent">
                    <span class="relative z-10">Contact</span>
                    <div class="absolute inset-0 bg-gradient-to-r from-primaryGreen/20 to-transparent rounded-xl opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                </a>
                <a href="{{ route('partner.features') }}" class="group relative px-4 py-2.5 rounded-xl text-gray-700 dark:text-white hover:text-primaryGreen dark:hover:text-primaryGreen transition-all duration-300 font-medium hover:bg-gradient-to-r hover:from-primaryGreen/10 hover:to-transparent">
                    <span class="relative z-10">For Partner</span>
                    <div class="absolute inset-0 bg-gradient-to-r from-primaryGreen/20 to-transparent rounded-xl opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                </a>
                <a href="/feature-gallery" class="group relative px-4 py-2.5 rounded-xl text-gray-700 dark:text-white hover:text-primaryPurple dark:hover:text-primaryPurple transition-all duration-300 font-medium hover:bg-gradient-to-r hover:from-primaryPurple/10 hover:to-transparent">
                    <span class="relative z-10">Feature Gallery</span>
                    <div class="absolute inset-0 bg-gradient-to-r from-primaryPurple/20 to-transparent rounded-xl opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                </a>
                <a href="{{ route('student.features') }}" class="group relative px-4 py-2.5 rounded-xl text-gray-700 dark:text-white hover:text-primaryGreen dark:hover:text-primaryGreen transition-all duration-300 font-medium hover:bg-gradient-to-r hover:from-primaryGreen/10 hover:to-transparent">
                    <span class="relative z-10">For Student</span>
                    <div class="absolute inset-0 bg-gradient-to-r from-primaryGreen/20 to-transparent rounded-xl opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                </a>
                
                <!-- Enhanced Action Buttons -->
                <div class="flex items-center space-x-3 ml-4 pl-4 border-l border-gray-200 dark:border-gray-700">
                    <a href="{{ route('login') }}" class="group relative bg-gradient-to-r from-primaryGreen to-green-600 hover:from-green-600 hover:to-green-700 text-white px-6 py-2.5 rounded-2xl font-semibold transition-all duration-300 transform hover:scale-105 shadow-lg hover:shadow-xl overflow-hidden">
                        <span class="relative z-10 flex items-center">
                            <svg class="w-4 h-4 mr-2 group-hover:translate-x-0.5 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path>
                            </svg>
                            Sign In
                        </span>
                        <div class="absolute inset-0 bg-gradient-to-r from-white/20 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                    </a>
                    <a href="{{ route('public.quiz.access') }}" target="_blank" class="group relative bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700 text-primaryBlue dark:text-primaryBlue font-bold px-5 py-2.5 rounded-2xl shadow-lg transition-all duration-300 transform hover:scale-105 border-2 border-primaryBlue/30 hover:border-primaryBlue/60 overflow-hidden">
                        <span class="relative z-10 flex items-center">
                            <svg class="w-4 h-4 mr-2 group-hover:rotate-12 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                            </svg>
                            Live Exam
                        </span>
                        <div class="absolute inset-0 bg-gradient-to-r from-primaryBlue/10 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                    </a>
                </div>
            </nav>

            <!-- Enhanced Mobile Controls -->
            <div class="flex items-center space-x-2">
                <!-- Dark Mode Toggle with Enhanced Design -->
                <button id="darkToggle" class="group relative p-3 rounded-2xl bg-gradient-to-br from-gray-100 to-gray-200 dark:from-gray-800 dark:to-gray-700 text-gray-600 dark:text-gray-400 hover:from-primaryGreen/20 hover:to-primaryGreen/10 dark:hover:from-primaryGreen/20 dark:hover:to-primaryGreen/10 transition-all duration-300 focus:outline-none focus:ring-2 focus:ring-primaryGreen/30 transform hover:scale-105">
                    <svg class="w-5 h-5 dark:hidden group-hover:rotate-180 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"></path>
                    </svg>
                    <svg class="w-5 h-5 hidden dark:block group-hover:rotate-180 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"></path>
                    </svg>
                </button>
                
                <!-- Enhanced Mobile Menu Button -->
                <button id="mobileMenuBtn" class="md:hidden group relative p-3 rounded-2xl bg-gradient-to-br from-gray-100 to-gray-200 dark:from-gray-800 dark:to-gray-700 text-gray-600 dark:text-gray-400 hover:from-primaryGreen/20 hover:to-primaryGreen/10 dark:hover:from-primaryGreen/20 dark:hover:to-primaryGreen/10 transition-all duration-300 focus:outline-none focus:ring-2 focus:ring-primaryGreen/30 transform hover:scale-105">
                    <svg class="w-5 h-5 group-hover:rotate-90 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                </button>
            </div>
        </div>

        <!-- Ultra-Modern Mobile Menu -->
        <div id="mobileMenu" class="md:hidden relative overflow-hidden" style="display: none;">
            <!-- Animated Background -->
            <div class="absolute inset-0 bg-gradient-to-br from-primaryGreen/5 via-transparent to-primaryBlue/5"></div>
            
            <!-- Mobile Menu Content -->
            <div class="relative bg-white/95 dark:bg-gray-900/95 backdrop-blur-xl border-t border-gray-200/50 dark:border-gray-700/50 mt-4 rounded-2xl shadow-2xl mx-2 overflow-hidden">
                <!-- Menu Header -->
                <div class="px-6 py-4 border-b border-gray-200/50 dark:border-gray-700/50">
                    <div class="flex items-center justify-between">
                        <h3 class="text-lg font-bold text-gray-900 dark:text-white">Navigation</h3>
                        <div class="w-2 h-2 bg-gradient-to-r from-primaryGreen to-primaryBlue rounded-full animate-pulse"></div>
                    </div>
                </div>
                
                <!-- Menu Items -->
                <div class="px-4 py-4 space-y-2">
                    <!-- About -->
                    <a href="{{ route('about') }}" class="group relative flex items-center w-full px-4 py-4 rounded-2xl text-gray-700 dark:text-white hover:text-primaryGreen dark:hover:text-primaryGreen transition-all duration-300 font-medium hover:bg-gradient-to-r hover:from-primaryGreen/10 hover:to-transparent active:scale-95 touch-manipulation">
                        <div class="flex items-center w-full">
                            <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-gray-100 to-gray-200 dark:from-gray-800 dark:to-gray-700 flex items-center justify-center mr-4 group-hover:from-primaryGreen/20 group-hover:to-primaryGreen/10 transition-all duration-300">
                                <svg class="w-5 h-5 text-gray-600 dark:text-gray-400 group-hover:text-primaryGreen transition-colors duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1a3 3 0 01-3-3V6a3 3 0 013-3h1m-1 0v18m0 0h1a3 3 0 013 3v7a3 3 0 01-3 3h-1"></path>
                                </svg>
                            </div>
                            <span class="text-lg font-medium">About</span>
                            <svg class="w-4 h-4 ml-auto text-gray-400 group-hover:text-primaryGreen group-hover:translate-x-1 transition-all duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                        </div>
                    </a>

                    <!-- Contact -->
                    <a href="{{ route('contact') }}" class="group relative flex items-center w-full px-4 py-4 rounded-2xl text-gray-700 dark:text-white hover:text-primaryGreen dark:hover:text-primaryGreen transition-all duration-300 font-medium hover:bg-gradient-to-r hover:from-primaryGreen/10 hover:to-transparent active:scale-95 touch-manipulation">
                        <div class="flex items-center w-full">
                            <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-gray-100 to-gray-200 dark:from-gray-800 dark:to-gray-700 flex items-center justify-center mr-4 group-hover:from-primaryGreen/20 group-hover:to-primaryGreen/10 transition-all duration-300">
                                <svg class="w-5 h-5 text-gray-600 dark:text-gray-400 group-hover:text-primaryGreen transition-colors duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                </svg>
                            </div>
                            <span class="text-lg font-medium">Contact</span>
                            <svg class="w-4 h-4 ml-auto text-gray-400 group-hover:text-primaryGreen group-hover:translate-x-1 transition-all duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                        </div>
                    </a>

                    <!-- For Partner -->
                    <a href="{{ route('partner.features') }}" class="group relative flex items-center w-full px-4 py-4 rounded-2xl text-primaryGreen dark:text-primaryGreen hover:text-green-600 dark:hover:text-green-400 transition-all duration-300 font-medium hover:bg-gradient-to-r hover:from-primaryGreen/20 hover:to-transparent active:scale-95 touch-manipulation">
                        <div class="flex items-center w-full">
                            <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-primaryGreen/20 to-primaryGreen/10 flex items-center justify-center mr-4 group-hover:from-primaryGreen/30 group-hover:to-primaryGreen/20 transition-all duration-300">
                                <svg class="w-5 h-5 text-primaryGreen group-hover:text-green-600 transition-colors duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                </svg>
                            </div>
                            <span class="text-lg font-medium">For Partner</span>
                            <svg class="w-4 h-4 ml-auto text-primaryGreen group-hover:text-green-600 group-hover:translate-x-1 transition-all duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                        </div>
                    </a>

                    <!-- Feature Gallery -->
                    <a href="/feature-gallery" class="group relative flex items-center w-full px-4 py-4 rounded-2xl text-primaryPurple dark:text-primaryPurple hover:text-purple-600 dark:hover:text-purple-400 transition-all duration-300 font-medium hover:bg-gradient-to-r hover:from-primaryPurple/20 hover:to-transparent active:scale-95 touch-manipulation">
                        <div class="flex items-center w-full">
                            <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-primaryPurple/20 to-primaryPurple/10 flex items-center justify-center mr-4 group-hover:from-primaryPurple/30 group-hover:to-primaryPurple/20 transition-all duration-300">
                                <svg class="w-5 h-5 text-primaryPurple group-hover:text-purple-600 transition-colors duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                            </div>
                            <span class="text-lg font-medium">Feature Gallery</span>
                            <svg class="w-4 h-4 ml-auto text-primaryPurple group-hover:text-purple-600 group-hover:translate-x-1 transition-all duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                        </div>
                    </a>

                    <!-- For Student -->
                    <a href="{{ route('student.features') }}" class="group relative flex items-center w-full px-4 py-4 rounded-2xl text-primaryBlue dark:text-primaryBlue hover:text-blue-600 dark:hover:text-blue-400 transition-all duration-300 font-medium hover:bg-gradient-to-r hover:from-primaryBlue/20 hover:to-transparent active:scale-95 touch-manipulation">
                        <div class="flex items-center w-full">
                            <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-primaryBlue/20 to-primaryBlue/10 flex items-center justify-center mr-4 group-hover:from-primaryBlue/30 group-hover:to-primaryBlue/20 transition-all duration-300">
                                <svg class="w-5 h-5 text-primaryBlue group-hover:text-blue-600 transition-colors duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                </svg>
                            </div>
                            <span class="text-lg font-medium">For Student</span>
                            <svg class="w-4 h-4 ml-auto text-primaryBlue group-hover:text-blue-600 group-hover:translate-x-1 transition-all duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                        </div>
                    </a>
                </div>

                <!-- Action Buttons Section -->
                <div class="px-4 py-4 border-t border-gray-200/50 dark:border-gray-700/50 space-y-3">
                    <!-- Sign In Button -->
                    <a href="{{ route('login') }}" class="group relative flex items-center justify-center w-full px-6 py-4 rounded-2xl bg-gradient-to-r from-primaryGreen to-green-600 hover:from-green-600 hover:to-green-700 text-white font-semibold transition-all duration-300 transform hover:scale-105 shadow-lg hover:shadow-xl overflow-hidden">
                        <span class="relative z-10 flex items-center">
                            <svg class="w-5 h-5 mr-2 group-hover:translate-x-0.5 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path>
                            </svg>
                            Sign In
                        </span>
                        <div class="absolute inset-0 bg-gradient-to-r from-white/20 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                    </a>

                    <!-- Live Exam Button -->
                    <a href="{{ route('public.quiz.access') }}" target="_blank" class="group relative flex items-center justify-center w-full px-6 py-4 rounded-2xl bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700 text-primaryBlue dark:text-primaryBlue font-bold transition-all duration-300 transform hover:scale-105 border-2 border-primaryBlue/30 hover:border-primaryBlue/60 shadow-lg hover:shadow-xl overflow-hidden">
                        <span class="relative z-10 flex items-center">
                            <svg class="w-5 h-5 mr-2 group-hover:rotate-12 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                            </svg>
                            Live Exam
                        </span>
                        <div class="absolute inset-0 bg-gradient-to-r from-primaryBlue/10 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Enhanced JavaScript for Ultra-Modern Navigation -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Enhanced Dark Mode Toggle with Smooth Transitions
            const darkToggle = document.getElementById('darkToggle');
            const html = document.documentElement;
            
            if (darkToggle) {
                // Check for saved theme preference
                if (localStorage.getItem('theme') === 'dark' || (!localStorage.getItem('theme') && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
                    html.classList.add('dark');
                }
                
                darkToggle.addEventListener('click', () => {
                    // Add transition class for smooth theme switching
                    html.style.transition = 'background-color 0.3s ease, color 0.3s ease';
                    html.classList.toggle('dark');
                    localStorage.setItem('theme', html.classList.contains('dark') ? 'dark' : 'light');
                    
                    // Remove transition after animation
                    setTimeout(() => {
                        html.style.transition = '';
                    }, 300);
                });
            }

            // Ultra-Modern Mobile Menu with Advanced Animations
            const mobileMenuBtn = document.getElementById('mobileMenuBtn');
            const mobileMenu = document.getElementById('mobileMenu');
            
            if (mobileMenuBtn && mobileMenu) {
                let isMenuOpen = false;
                
                mobileMenuBtn.addEventListener('click', () => {
                    if (!isMenuOpen) {
                        // Show menu with enhanced animation
                        mobileMenu.style.display = 'block';
                        mobileMenu.style.opacity = '0';
                        mobileMenu.style.transform = 'translateY(-20px) scale(0.95)';
                        
                        // Trigger enhanced animation
                        requestAnimationFrame(() => {
                            mobileMenu.style.transition = 'all 0.4s cubic-bezier(0.4, 0, 0.2, 1)';
                            mobileMenu.style.opacity = '1';
                            mobileMenu.style.transform = 'translateY(0) scale(1)';
                        });
                        
                        isMenuOpen = true;
                        
                        // Add backdrop blur effect
                        document.body.style.overflow = 'hidden';
                        document.body.classList.add('backdrop-blur-sm');
                    } else {
                        // Hide menu with enhanced animation
                        mobileMenu.style.transition = 'all 0.3s cubic-bezier(0.4, 0, 0.2, 1)';
                        mobileMenu.style.opacity = '0';
                        mobileMenu.style.transform = 'translateY(-20px) scale(0.95)';
                        
                        setTimeout(() => {
                            mobileMenu.style.display = 'none';
                            document.body.style.overflow = '';
                            document.body.classList.remove('backdrop-blur-sm');
                        }, 300);
                        
                        isMenuOpen = false;
                    }
                });

                // Close menu when clicking outside
                document.addEventListener('click', (e) => {
                    if (isMenuOpen && !mobileMenu.contains(e.target) && !mobileMenuBtn.contains(e.target)) {
                        mobileMenu.style.transition = 'all 0.3s cubic-bezier(0.4, 0, 0.2, 1)';
                        mobileMenu.style.opacity = '0';
                        mobileMenu.style.transform = 'translateY(-20px) scale(0.95)';
                        
                        setTimeout(() => {
                            mobileMenu.style.display = 'none';
                            document.body.style.overflow = '';
                            document.body.classList.remove('backdrop-blur-sm');
                        }, 300);
                        
                        isMenuOpen = false;
                    }
                });

                // Close menu on escape key
                document.addEventListener('keydown', (e) => {
                    if (e.key === 'Escape' && isMenuOpen) {
                        mobileMenu.style.transition = 'all 0.3s cubic-bezier(0.4, 0, 0.2, 1)';
                        mobileMenu.style.opacity = '0';
                        mobileMenu.style.transform = 'translateY(-20px) scale(0.95)';
                        
                        setTimeout(() => {
                            mobileMenu.style.display = 'none';
                            document.body.style.overflow = '';
                            document.body.classList.remove('backdrop-blur-sm');
                        }, 300);
                        
                        isMenuOpen = false;
                    }
                });
            }

            // Enhanced Header Scroll Effect with Parallax
            const header = document.querySelector('header');
            if (header) {
                let lastScrollY = window.scrollY;
                
                window.addEventListener('scroll', () => {
                    const currentScrollY = window.scrollY;
                    
                    if (currentScrollY > 100) {
                        header.classList.add('shadow-xl', 'bg-white/95', 'dark:bg-gray-900/95', 'backdrop-blur-xl');
                        header.style.transform = 'translateY(0)';
                    } else {
                        header.classList.remove('shadow-xl', 'bg-white/95', 'dark:bg-gray-900/95', 'backdrop-blur-xl');
                        header.style.transform = 'translateY(0)';
                    }
                    
                    // Hide header on scroll down, show on scroll up (optional)
                    if (currentScrollY > lastScrollY && currentScrollY > 200) {
                        header.style.transform = 'translateY(-100%)';
                    } else {
                        header.style.transform = 'translateY(0)';
                    }
                    
                    lastScrollY = currentScrollY;
                });
            }

            // Enhanced Navigation Link Hover Effects
            const navLinks = document.querySelectorAll('nav a');
            navLinks.forEach(link => {
                link.addEventListener('mouseenter', () => {
                    link.style.transform = 'translateY(-2px)';
                });
                
                link.addEventListener('mouseleave', () => {
                    link.style.transform = 'translateY(0)';
                });
            });

            // Add smooth scrolling to all anchor links
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

            // Performance optimization: Throttle scroll events
            let ticking = false;
            function updateHeader() {
                // Header scroll logic here
                ticking = false;
            }

            function requestTick() {
                if (!ticking) {
                    requestAnimationFrame(updateHeader);
                    ticking = true;
                }
            }

            window.addEventListener('scroll', requestTick);
        });
    </script>
</header>