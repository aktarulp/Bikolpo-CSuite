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
                            বিকল্প পাঠশালা
                        </h1>
                        <p class="text-xs text-gray-500 dark:text-gray-400">Your Smart Exam Partner</p>
                    </div>
                </a>
            </div>

            <!-- Desktop Navigation -->
            <nav class="hidden md:flex items-center space-x-8">
                <a href="#about" class="text-gray-700 dark:text-white hover:text-primaryGreen dark:hover:text-primaryGreen transition-colors duration-200 font-medium">
                    About
                </a>
                <a href="{{ route('contact') }}" class="text-gray-700 dark:text-white hover:text-primaryGreen dark:hover:text-primaryGreen transition-colors duration-200 font-medium">
                    Contact
                </a>
                <a href="{{ route('partner.features') }}" class="text-gray-700 dark:text-white hover:text-primaryGreen dark:hover:text-primaryGreen transition-colors duration-200 font-medium">
                    For Partner
                </a>
                </a>
                <a href="{{ route('student.features') }}" class="text-gray-700 dark:text-white hover:text-primaryGreen dark:hover:text-primaryGreen transition-colors duration-200 font-medium">
                    For Student
                </a>
                <a href="{{ route('login') }}" class="bg-gradient-to-r from-primaryGreen to-green-600 hover:from-green-600 hover:to-green-700 text-white px-6 py-2 rounded-full font-semibold transition-all duration-300 transform hover:scale-105 shadow-lg hover:shadow-xl">
                    Sign In
                </a>
                <a href="{{ route('public.quiz.access') }}" class="bg-white dark:bg-gray-800 hover:bg-gray-100 dark:hover:bg-gray-700 text-primaryBlue dark:text-primaryBlue font-bold px-4 py-2 rounded-full shadow-lg transition-all duration-300 transform hover:scale-105 border-2 border-primaryBlue">
                    Live Exam
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
