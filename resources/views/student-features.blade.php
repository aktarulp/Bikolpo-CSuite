<!DOCTYPE html>
<html lang="bn" class="scroll-smooth">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Student Features - Bikolpo LQ</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    fontFamily: {
                        bangla: ['"Nikosh"', '"Hind Siliguri"', 'sans-serif']
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
    <link href="https://fonts.googleapis.com/css2?family=Nikosh:wght@300;400;500;600;700&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
</head>

<body class="bg-gradient-to-br from-gray-50 to-gray-100 dark:from-gray-900 dark:to-gray-800 text-gray-800 dark:text-gray-100 font-bangla">
   @include('navigation-layout');

    <!-- Hero Section -->
    <section class="relative bg-gradient-to-br from-primaryBlue/10 via-blue-50 to-indigo-100 dark:from-primaryBlue/20 dark:via-gray-800 dark:to-gray-900 py-16 lg:py-20">
        <div class="absolute inset-0 bg-grid-pattern opacity-5"></div>
        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <div class="animate-fade-in">
                <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold text-gray-900 dark:text-white mb-6 leading-tight">
                    <span class="bg-gradient-to-r from-primaryBlue via-primaryGreen to-primaryPurple bg-clip-text text-transparent">
                        Student Features
                    </span>
                </h1>
                <p class="text-xl md:text-2xl text-gray-600 dark:text-gray-400 mb-8 max-w-3xl mx-auto leading-relaxed">
                    Access thousands of online tests from renowned academic institutions. Practice with real exam questions and excel in your studies.
                </p>
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <a href="{{ route('student.dashboard') }}" class="bg-gradient-to-r from-primaryBlue to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white px-8 py-4 rounded-full font-bold text-lg transition-all duration-300 transform hover:scale-105 shadow-xl hover:shadow-2xl">
                        <i class="fas fa-graduation-cap mr-2"></i>
                        Start Learning Journey
                    </a>
                    <a href="{{ route('contact') }}" class="bg-white dark:bg-gray-800 text-gray-700 dark:text-gray-300 border-2 border-gray-300 dark:border-gray-600 hover:border-primaryBlue dark:hover:border-primaryBlue px-8 py-4 rounded-full font-bold text-lg transition-all duration-300 hover:shadow-lg">
                        <i class="fas fa-phone mr-2"></i>
                        Get Support
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Statistics Section -->
    <section class="bg-white dark:bg-gray-800 py-16 border-b border-gray-200 dark:border-gray-700">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-900 dark:text-white mb-4">
                    Join the Largest Online Test Community
                </h2>
                <p class="text-xl text-gray-600 dark:text-gray-400 max-w-3xl mx-auto">
                    Access thousands of tests from top academic institutions and educational partners
                </p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <!-- Total Tests -->
                <div class="text-center p-6 bg-gradient-to-br from-blue-50 to-blue-100 dark:from-blue-900/30 dark:to-blue-800/30 rounded-2xl border border-blue-200 dark:border-blue-700">
                    <div class="w-16 h-16 bg-blue-500 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-file-alt text-white text-2xl"></i>
                    </div>
                    <div class="text-3xl font-bold text-blue-600 dark:text-blue-400 mb-2">10,000+</div>
                    <div class="text-gray-600 dark:text-gray-300 font-medium">Online Tests</div>
                </div>

                <!-- Partner Institutions -->
                <div class="text-center p-6 bg-gradient-to-br from-green-50 to-green-100 dark:from-green-900/30 dark:to-green-800/30 rounded-2xl border border-green-200 dark:border-green-700">
                    <div class="w-16 h-16 bg-green-500 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-university text-white text-2xl"></i>
                    </div>
                    <div class="text-3xl font-bold text-green-600 dark:text-green-400 mb-2">500+</div>
                    <div class="text-gray-600 dark:text-gray-300 font-medium">Partner Institutions</div>
                </div>

                <!-- Active Students -->
                <div class="text-center p-6 bg-gradient-to-br from-purple-50 to-purple-100 dark:from-purple-900/30 dark:to-purple-800/30 rounded-2xl border border-purple-200 dark:border-purple-700">
                    <div class="w-16 h-16 bg-purple-500 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-users text-white text-2xl"></i>
                    </div>
                    <div class="text-3xl font-bold text-purple-600 dark:text-purple-400 mb-2">50,000+</div>
                    <div class="text-gray-600 dark:text-gray-300 font-medium">Active Students</div>
                </div>

                <!-- Test Categories -->
                <div class="text-center p-6 bg-gradient-to-br from-orange-50 to-orange-100 dark:from-orange-900/30 dark:to-orange-800/30 rounded-2xl border border-orange-200 dark:border-orange-700">
                    <div class="w-16 h-16 bg-orange-500 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-layer-group text-white text-2xl"></i>
                    </div>
                    <div class="text-3xl font-bold text-orange-600 dark:text-orange-400 mb-2">25+</div>
                    <div class="text-gray-600 dark:text-gray-300 font-medium">Subject Categories</div>
                </div>
            </div>
        </div>
    </section>

    <!-- Main Content -->
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
        
        <!-- Core Features Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-16">
            
            <!-- Thousands of Tests -->
            <div class="bg-gradient-to-br from-blue-50 to-blue-100 dark:from-blue-900/30 dark:to-blue-800/30 p-8 rounded-3xl shadow-lg border border-blue-200 dark:border-blue-700 hover:shadow-xl transition-all duration-300 transform hover:-translate-y-2">
                <div class="text-center">
                    <div class="w-20 h-20 bg-blue-500 rounded-full flex items-center justify-center mx-auto mb-6 shadow-lg">
                        <i class="fas fa-database text-white text-3xl"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">10,000+ Online Tests</h3>
                    <p class="text-gray-600 dark:text-gray-300 mb-6">Access thousands of tests across multiple subjects and difficulty levels</p>
                    <ul class="text-left text-gray-600 dark:text-gray-300 space-y-2">
                        <li class="flex items-center"><i class="fas fa-check text-blue-500 mr-2"></i>Multiple choice questions</li>
                        <li class="flex items-center"><i class="fas fa-check text-blue-500 mr-2"></i>Descriptive questions</li>
                        <li class="flex items-center"><i class="fas fa-check text-blue-500 mr-2"></i>Subject-wise categorization</li>
                    </ul>
                </div>
            </div>

            <!-- Public Tests from Renowned Institutes -->
            <div class="bg-gradient-to-br from-green-50 to-green-100 dark:from-green-900/30 dark:to-green-800/30 p-8 rounded-3xl shadow-lg border border-green-200 dark:border-green-700 hover:shadow-xl transition-all duration-300 transform hover:-translate-y-2">
                <div class="text-center">
                    <div class="w-20 h-20 bg-green-500 rounded-full flex items-center justify-center mx-auto mb-6 shadow-lg">
                        <i class="fas fa-university text-white text-3xl"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">Public Tests from Renowned Institutes</h3>
                    <p class="text-gray-600 dark:text-gray-300 mb-6">Access real exam questions from top universities and educational institutions</p>
                    <ul class="text-left text-gray-600 dark:text-gray-300 space-y-2">
                        <li class="flex items-center"><i class="fas fa-check text-green-500 mr-2"></i>University-level questions</li>
                        <li class="flex items-center"><i class="fas fa-check text-green-500 mr-2"></i>Professional exam patterns</li>
                        <li class="flex items-center"><i class="fas fa-check text-green-500 mr-2"></i>Real exam experience</li>
                    </ul>
                </div>
            </div>

            <!-- Diverse Test Categories -->
            <div class="bg-gradient-to-br from-purple-50 to-purple-100 dark:from-purple-900/30 dark:to-purple-800/30 p-8 rounded-3xl shadow-lg border border-purple-200 dark:border-purple-700 hover:shadow-xl transition-all duration-300 transform hover:-translate-y-2">
                <div class="text-center">
                    <div class="w-20 h-20 bg-purple-500 rounded-full flex items-center justify-center mx-auto mb-6 shadow-lg">
                        <i class="fas fa-layer-group text-white text-3xl"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">25+ Subject Categories</h3>
                    <p class="text-gray-600 dark:text-gray-300 mb-6">Comprehensive coverage across all major academic and professional subjects</p>
                    <ul class="text-left text-gray-600 dark:text-gray-300 space-y-2">
                        <li class="flex items-center"><i class="fas fa-check text-purple-500 mr-2"></i>Science & Technology</li>
                        <li class="flex items-center"><i class="fas fa-check text-purple-500 mr-2"></i>Business & Economics</li>
                        <li class="flex items-center"><i class="fas fa-check text-purple-500 mr-2"></i>Arts & Humanities</li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Typing Test Feature Section -->
        <div class="bg-gradient-to-br from-orange-50 via-amber-50 to-yellow-50 dark:from-orange-900/30 dark:via-amber-900/30 dark:to-yellow-900/30 rounded-3xl p-8 lg:p-12 mb-16 border border-orange-200 dark:border-orange-700">
            <div class="text-center mb-12">
                <div class="w-20 h-20 bg-gradient-to-br from-orange-500 to-amber-600 rounded-full flex items-center justify-center mx-auto mb-6 shadow-lg">
                    <i class="fas fa-keyboard text-white text-3xl"></i>
                </div>
                <h2 class="text-3xl md:text-4xl font-bold text-gray-900 dark:text-white mb-4">
                    Advanced Typing Test System
                </h2>
                <p class="text-xl text-gray-600 dark:text-gray-400 max-w-4xl mx-auto">
                    Master your typing skills with our comprehensive typing test platform featuring real-time feedback, speed tracking, and accuracy measurement
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <!-- Real-time Speed Tracking -->
                <div class="bg-white dark:bg-gray-800 rounded-2xl p-6 shadow-lg border border-gray-200 dark:border-gray-700 hover:shadow-xl transition-all duration-300">
                    <div class="flex items-center mb-4">
                        <div class="w-12 h-12 bg-orange-500 rounded-lg flex items-center justify-center mr-4">
                            <i class="fas fa-tachometer-alt text-white text-xl"></i>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 dark:text-white">Real-time Speed Tracking</h3>
                    </div>
                    <p class="text-gray-600 dark:text-gray-400 mb-4">Monitor your typing speed in real-time with instant WPM calculations</p>
                    <ul class="space-y-2 text-sm text-gray-600 dark:text-gray-400">
                        <li class="flex items-center"><i class="fas fa-check text-orange-500 mr-2"></i>Live WPM display</li>
                        <li class="flex items-center"><i class="fas fa-check text-orange-500 mr-2"></i>Instant feedback</li>
                        <li class="flex items-center"><i class="fas fa-check text-orange-500 mr-2"></i>Progress tracking</li>
                    </ul>
                </div>

                <!-- Accuracy Measurement -->
                <div class="bg-white dark:bg-gray-800 rounded-2xl p-6 shadow-lg border border-gray-200 dark:border-gray-700 hover:shadow-xl transition-all duration-300">
                    <div class="flex items-center mb-4">
                        <div class="w-12 h-12 bg-amber-500 rounded-lg flex items-center justify-center mr-4">
                            <i class="fas fa-bullseye text-white text-xl"></i>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 dark:text-white">Accuracy Measurement</h3>
                    </div>
                    <p class="text-gray-600 dark:text-gray-400 mb-4">Track your typing accuracy with detailed error analysis and correction suggestions</p>
                    <ul class="space-y-2 text-sm text-gray-600 dark:text-gray-400">
                        <li class="flex items-center"><i class="fas fa-check text-amber-500 mr-2"></i>Error highlighting</li>
                        <li class="flex items-center"><i class="fas fa-check text-amber-500 mr-2"></i>Accuracy percentage</li>
                        <li class="flex items-center"><i class="fas fa-check text-amber-500 mr-2"></i>Mistake analysis</li>
                    </ul>
                </div>

                <!-- Skill Improvement -->
                <div class="bg-white dark:bg-gray-800 rounded-2xl p-6 shadow-lg border border-gray-200 dark:border-gray-700 hover:shadow-xl transition-all duration-300">
                    <div class="flex items-center mb-4">
                        <div class="w-12 h-12 bg-yellow-500 rounded-lg flex items-center justify-center mr-4">
                            <i class="fas fa-chart-line text-white text-xl"></i>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 dark:text-white">Skill Improvement</h3>
                    </div>
                    <p class="text-gray-600 dark:text-gray-400 mb-4">Personalized recommendations and practice exercises to enhance your typing skills</p>
                    <ul class="space-y-2 text-sm text-gray-600 dark:text-gray-400">
                        <li class="flex items-center"><i class="fas fa-check text-yellow-500 mr-2"></i>Personalized tips</li>
                        <li class="flex items-center"><i class="fas fa-check text-yellow-500 mr-2"></i>Practice exercises</li>
                        <li class="flex items-center"><i class="fas fa-check text-yellow-500 mr-2"></i>Progress reports</li>
                    </ul>
                </div>
            </div>

            <!-- Typing Test Features -->
            <div class="mt-12 text-center">
                <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-8">Typing Test Features</h3>
                <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-4 items-center">
                    <div class="bg-gradient-to-br from-orange-500 to-orange-600 rounded-xl p-4 shadow-lg hover:shadow-xl transform hover:-translate-y-1 transition-all duration-300">
                        <div class="text-white font-bold text-lg">Bengali</div>
                        <div class="text-orange-100 text-sm">Typing</div>
                    </div>
                    <div class="bg-gradient-to-br from-amber-500 to-amber-600 rounded-xl p-4 shadow-lg hover:shadow-xl transform hover:-translate-y-1 transition-all duration-300">
                        <div class="text-white font-bold text-lg">English</div>
                        <div class="text-amber-100 text-sm">Typing</div>
                    </div>
                    <div class="bg-gradient-to-br from-yellow-500 to-yellow-600 rounded-xl p-4 shadow-lg hover:shadow-xl transform hover:-translate-y-1 transition-all duration-300">
                        <div class="text-white font-bold text-lg">Numbers</div>
                        <div class="text-yellow-100 text-sm">Typing</div>
                    </div>
                    <div class="bg-gradient-to-br from-orange-600 to-red-600 rounded-xl p-4 shadow-lg hover:shadow-xl transform hover:-translate-y-1 transition-all duration-300">
                        <div class="text-white font-bold text-lg">Symbols</div>
                        <div class="text-orange-100 text-sm">Typing</div>
                    </div>
                    <div class="bg-gradient-to-br from-amber-600 to-orange-600 rounded-xl p-4 shadow-lg hover:shadow-xl transform hover:-translate-y-1 transition-all duration-300">
                        <div class="text-white font-bold text-lg">Mixed</div>
                        <div class="text-amber-100 text-sm">Typing</div>
                    </div>
                    <div class="bg-gradient-to-br from-yellow-600 to-amber-600 rounded-xl p-4 shadow-lg hover:shadow-xl transform hover:-translate-y-1 transition-all duration-300">
                        <div class="text-white font-bold text-lg">Custom</div>
                        <div class="text-yellow-100 text-sm">Text</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Public Tests from Renowned Institutes Section -->
        <div class="bg-gradient-to-br from-indigo-50 via-blue-50 to-cyan-50 dark:from-indigo-900/30 dark:via-blue-900/30 dark:to-cyan-900/30 rounded-3xl p-8 lg:p-12 mb-16 border border-indigo-200 dark:border-indigo-700">
            <div class="text-center mb-12">
                <div class="w-20 h-20 bg-gradient-to-br from-indigo-500 to-blue-600 rounded-full flex items-center justify-center mx-auto mb-6 shadow-lg">
                    <i class="fas fa-graduation-cap text-white text-3xl"></i>
                </div>
                <h2 class="text-3xl md:text-4xl font-bold text-gray-900 dark:text-white mb-4">
                    Public Tests from Renowned Academic Institutions
                </h2>
                <p class="text-xl text-gray-600 dark:text-gray-400 max-w-4xl mx-auto">
                    Access real exam questions and test patterns from top universities, colleges, and educational institutions across the country
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <!-- University Tests -->
                <div class="bg-white dark:bg-gray-800 rounded-2xl p-6 shadow-lg border border-gray-200 dark:border-gray-700 hover:shadow-xl transition-all duration-300">
                    <div class="flex items-center mb-4">
                        <div class="w-12 h-12 bg-blue-500 rounded-lg flex items-center justify-center mr-4">
                            <i class="fas fa-university text-white text-xl"></i>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 dark:text-white">University Tests</h3>
                    </div>
                    <p class="text-gray-600 dark:text-gray-400 mb-4">Access entrance and semester exam questions from leading universities</p>
                    <ul class="space-y-2 text-sm text-gray-600 dark:text-gray-400">
                        <li class="flex items-center"><i class="fas fa-check text-blue-500 mr-2"></i>Admission tests</li>
                        <li class="flex items-center"><i class="fas fa-check text-blue-500 mr-2"></i>Semester exams</li>
                        <li class="flex items-center"><i class="fas fa-check text-blue-500 mr-2"></i>Research methodology</li>
                    </ul>
                </div>

                <!-- College Tests -->
                <div class="bg-white dark:bg-gray-800 rounded-2xl p-6 shadow-lg border border-gray-200 dark:border-gray-700 hover:shadow-xl transition-all duration-300">
                    <div class="flex items-center mb-4">
                        <div class="w-12 h-12 bg-green-500 rounded-lg flex items-center justify-center mr-4">
                            <i class="fas fa-school text-white text-xl"></i>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 dark:text-white">College Tests</h3>
                    </div>
                    <p class="text-gray-600 dark:text-gray-400 mb-4">Practice with questions from prestigious colleges and institutions</p>
                    <ul class="space-y-2 text-sm text-gray-600 dark:text-gray-400">
                        <li class="flex items-center"><i class="fas fa-check text-green-500 mr-2"></i>HSC level tests</li>
                        <li class="flex items-center"><i class="fas fa-check text-green-500 mr-2"></i>Honors programs</li>
                        <li class="flex items-center"><i class="fas fa-check text-green-500 mr-2"></i>Professional courses</li>
                    </ul>
                </div>

                <!-- Coaching Center Tests -->
                <div class="bg-white dark:bg-gray-800 rounded-2xl p-6 shadow-lg border border-gray-200 dark:border-gray-700 hover:shadow-xl transition-all duration-300">
                    <div class="flex items-center mb-4">
                        <div class="w-12 h-12 bg-purple-500 rounded-lg flex items-center justify-center mr-4">
                            <i class="fas fa-chalkboard-teacher text-white text-xl"></i>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 dark:text-white">Coaching Center Tests</h3>
                    </div>
                    <p class="text-gray-600 dark:text-gray-400 mb-4">Access tests from renowned coaching centers and training institutes</p>
                    <ul class="space-y-2 text-sm text-gray-600 dark:text-gray-400">
                        <li class="flex items-center"><i class="fas fa-check text-purple-500 mr-2"></i>Competitive exams</li>
                        <li class="flex items-center"><i class="fas fa-check text-purple-500 mr-2"></i>Job preparation</li>
                        <li class="flex items-center"><i class="fas fa-check text-purple-500 mr-2"></i>Skill assessments</li>
                    </ul>
                </div>
            </div>

            <!-- Featured Partners -->
            <div class="mt-12 text-center">
                <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-8">Admission Test Available For</h3>
                <div class="grid grid-cols-2 md:grid-cols-5 lg:grid-cols-5 gap-4 items-center">
                    <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl p-4 shadow-lg hover:shadow-xl transform hover:-translate-y-1 transition-all duration-300">
                        <div class="text-white font-bold text-lg">BUET</div>
                        <div class="text-blue-100 text-sm">Engineering</div>
                    </div>
                    <div class="bg-gradient-to-br from-green-500 to-green-600 rounded-xl p-4 shadow-lg hover:shadow-xl transform hover:-translate-y-1 transition-all duration-300">
                        <div class="text-white font-bold text-lg">RUET</div>
                        <div class="text-green-100 text-sm">Engineering</div>
                    </div>
                    <div class="bg-gradient-to-br from-purple-500 to-purple-600 rounded-xl p-4 shadow-lg hover:shadow-xl transform hover:-translate-y-1 transition-all duration-300">
                        <div class="text-white font-bold text-lg">KUET</div>
                        <div class="text-purple-100 text-sm">Engineering</div>
                    </div>
                    <div class="bg-gradient-to-br from-orange-500 to-orange-600 rounded-xl p-4 shadow-lg hover:shadow-xl transform hover:-translate-y-1 transition-all duration-300">
                        <div class="text-white font-bold text-lg">CUET</div>
                        <div class="text-orange-100 text-sm">Engineering</div>
                    </div>
                    <div class="bg-gradient-to-br from-red-500 to-red-600 rounded-xl p-4 shadow-lg hover:shadow-xl transform hover:-translate-y-1 transition-all duration-300">
                        <div class="text-white font-bold text-lg">DU</div>
                        <div class="text-red-100 text-sm">University</div>
                    </div>
                    <div class="bg-gradient-to-br from-indigo-500 to-indigo-600 rounded-xl p-4 shadow-lg hover:shadow-xl transform hover:-translate-y-1 transition-all duration-300">
                        <div class="text-white font-bold text-lg">JU</div>
                        <div class="text-indigo-100 text-sm">University</div>
                    </div>
                    <div class="bg-gradient-to-br from-teal-500 to-teal-600 rounded-xl p-4 shadow-lg hover:shadow-xl transform hover:-translate-y-1 transition-all duration-300">
                        <div class="text-white font-bold text-lg">RU</div>
                        <div class="text-teal-100 text-sm">University</div>
                    </div>
                    <div class="bg-gradient-to-br from-pink-500 to-pink-600 rounded-xl p-4 shadow-lg hover:shadow-xl transform hover:-translate-y-1 transition-all duration-300">
                        <div class="text-white font-bold text-lg">CU</div>
                        <div class="text-pink-100 text-sm">University</div>
                    </div>
                    <div class="bg-gradient-to-br from-yellow-500 to-yellow-600 rounded-xl p-4 shadow-lg hover:shadow-xl transform hover:-translate-y-1 transition-all duration-300">
                        <div class="text-white font-bold text-lg">KU</div>
                        <div class="text-yellow-100 text-sm">University</div>
                    </div>
                    <div class="bg-gradient-to-br from-cyan-500 to-cyan-600 rounded-xl p-4 shadow-lg hover:shadow-xl transform hover:-translate-y-1 transition-all duration-300">
                        <div class="text-white font-bold text-lg">SUST</div>
                        <div class="text-cyan-100 text-sm">University</div>
                    </div>
                </div>
            </div>

            <!-- Government & Bank Job Tests -->
            <div class="mt-12 text-center">
                <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-8">Govt. & Bank Job Test Available for</h3>
                <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-4 gap-4 items-center">
                    <div class="bg-gradient-to-br from-emerald-500 to-emerald-600 rounded-xl p-4 shadow-lg hover:shadow-xl transform hover:-translate-y-1 transition-all duration-300">
                        <div class="text-white font-bold text-lg">BCS</div>
                        <div class="text-emerald-100 text-sm">Civil Service</div>
                    </div>
                    <div class="bg-gradient-to-br from-amber-500 to-amber-600 rounded-xl p-4 shadow-lg hover:shadow-xl transform hover:-translate-y-1 transition-all duration-300">
                        <div class="text-white font-bold text-lg">Bank Job</div>
                        <div class="text-amber-100 text-sm">Banking</div>
                    </div>
                    <div class="bg-gradient-to-br from-rose-500 to-rose-600 rounded-xl p-4 shadow-lg hover:shadow-xl transform hover:-translate-y-1 transition-all duration-300">
                        <div class="text-white font-bold text-lg">NTRCA</div>
                        <div class="text-rose-100 text-sm">Teacher</div>
                    </div>
                    <div class="bg-gradient-to-br from-violet-500 to-violet-600 rounded-xl p-4 shadow-lg hover:shadow-xl transform hover:-translate-y-1 transition-all duration-300">
                        <div class="text-white font-bold text-lg">PSC</div>
                        <div class="text-violet-100 text-sm">Public Service</div>
                    </div>
                    <div class="bg-gradient-to-br from-sky-500 to-sky-600 rounded-xl p-4 shadow-lg hover:shadow-xl transform hover:-translate-y-1 transition-all duration-300">
                        <div class="text-white font-bold text-lg">UPSC</div>
                        <div class="text-sky-100 text-sm">Union Service</div>
                    </div>
                    <div class="bg-gradient-to-br from-lime-500 to-lime-600 rounded-xl p-4 shadow-lg hover:shadow-xl transform hover:-translate-y-1 transition-all duration-300">
                        <div class="text-white font-bold text-lg">Railway</div>
                        <div class="text-lime-100 text-sm">Railway Job</div>
                    </div>
                    <div class="bg-gradient-to-br from-fuchsia-500 to-fuchsia-600 rounded-xl p-4 shadow-lg hover:shadow-xl transform hover:-translate-y-1 transition-all duration-300">
                        <div class="text-white font-bold text-lg">Police</div>
                        <div class="text-fuchsia-100 text-sm">Police Job</div>
                    </div>
                    <div class="bg-gradient-to-br from-stone-500 to-stone-600 rounded-xl p-4 shadow-lg hover:shadow-xl transform hover:-translate-y-1 transition-all duration-300">
                        <div class="text-white font-bold text-lg">Defense</div>
                        <div class="text-stone-100 text-sm">Military</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Detailed Features Section -->
        <div class="space-y-12">
            
            <!-- Exam Experience -->
            <div class="bg-white dark:bg-gray-800 rounded-3xl shadow-xl p-8 border border-gray-200 dark:border-gray-700">
                <div class="flex items-center mb-6">
                    <div class="w-16 h-16 bg-gradient-to-br from-primaryBlue to-blue-600 rounded-2xl flex items-center justify-center mr-6">
                        <i class="fas fa-file-alt text-white text-2xl"></i>
                    </div>
                    <div>
                        <h2 class="text-3xl font-bold text-gray-900 dark:text-white">Seamless Exam Experience</h2>
                        <p class="text-gray-600 dark:text-gray-400">User-friendly interface designed for optimal exam performance</p>
                    </div>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-4">
                        <h3 class="text-xl font-semibold text-gray-900 dark:text-white">Exam Interface</h3>
                        <ul class="space-y-2 text-gray-600 dark:text-gray-300">
                            <li class="flex items-center"><i class="fas fa-check text-primaryBlue mr-3"></i>Clean, distraction-free design</li>
                            <li class="flex items-center"><i class="fas fa-check text-primaryBlue mr-3"></i>Easy navigation between questions</li>
                            <li class="flex items-center"><i class="fas fa-check text-primaryBlue mr-3"></i>Question bookmarking feature</li>
                            <li class="flex items-center"><i class="fas fa-check text-primaryBlue mr-3"></i>Progress indicator</li>
                        </ul>
                    </div>
                    <div class="space-y-4">
                        <h3 class="text-xl font-semibold text-gray-900 dark:text-white">Smart Features</h3>
                        <ul class="space-y-2 text-gray-600 dark:text-gray-300">
                            <li class="flex items-center"><i class="fas fa-check text-primaryBlue mr-3"></i>Auto-save every 30 seconds</li>
                            <li class="flex items-center"><i class="fas fa-check text-primaryBlue mr-3"></i>Time remaining display</li>
                            <li class="flex items-center"><i class="fas fa-check text-primaryBlue mr-3"></i>Question review panel</li>
                            <li class="flex items-center"><i class="fas fa-check text-primaryBlue mr-3"></i>Answer confirmation</li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Learning Tools -->
            <div class="bg-white dark:bg-gray-800 rounded-3xl shadow-xl p-8 border border-gray-200 dark:border-gray-700">
                <div class="flex items-center mb-6">
                    <div class="w-16 h-16 bg-gradient-to-br from-primaryGreen to-green-600 rounded-2xl flex items-center justify-center mr-6">
                        <i class="fas fa-tools text-white text-2xl"></i>
                    </div>
                    <div>
                        <h2 class="text-3xl font-bold text-gray-900 dark:text-white">Learning Tools</h2>
                        <p class="text-gray-600 dark:text-gray-400">Comprehensive tools to enhance your learning experience</p>
                    </div>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="text-center p-6 bg-gray-50 dark:bg-gray-700 rounded-2xl">
                        <i class="fas fa-book-open text-4xl text-primaryGreen mb-4"></i>
                        <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-2">Study Materials</h3>
                        <p class="text-gray-600 dark:text-gray-400">Access to course materials, notes, and reference documents</p>
                    </div>
                    <div class="text-center p-6 bg-gray-50 dark:bg-gray-700 rounded-2xl">
                        <i class="fas fa-comments text-4xl text-primaryOrange mb-4"></i>
                        <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-2">Discussion Forums</h3>
                        <p class="text-gray-600 dark:text-gray-400">Connect with peers and instructors for collaborative learning</p>
                    </div>
                    <div class="text-center p-6 bg-gray-50 dark:bg-gray-700 rounded-2xl">
                        <i class="fas fa-video text-4xl text-primaryPurple mb-4"></i>
                        <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-2">Video Tutorials</h3>
                        <p class="text-gray-600 dark:text-gray-400">Visual learning resources for complex topics</p>
                    </div>
                </div>
            </div>

            <!-- Performance Analytics -->
            <div class="bg-white dark:bg-gray-800 rounded-3xl shadow-xl p-8 border border-gray-200 dark:border-gray-700">
                <div class="flex items-center mb-6">
                    <div class="w-16 h-16 bg-gradient-to-br from-primaryOrange to-orange-600 rounded-2xl flex items-center justify-center mr-6">
                        <i class="fas fa-analytics text-white text-2xl"></i>
                    </div>
                    <div>
                        <h2 class="text-3xl font-bold text-gray-900 dark:text-white">Performance Analytics</h2>
                        <p class="text-gray-600 dark:text-gray-400">Detailed insights to track and improve your performance</p>
                    </div>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div>
                        <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-4">Score Analysis</h3>
                        <ul class="space-y-3 text-gray-600 dark:text-gray-300">
                            <li class="flex items-start">
                                <i class="fas fa-chart-bar text-orange-500 mr-3 mt-1"></i>
                                <span>Subject-wise performance breakdown</span>
                            </li>
                            <li class="flex items-start">
                                <i class="fas fa-trending-up text-orange-500 mr-3 mt-1"></i>
                                <span>Progress tracking over time</span>
                            </li>
                            <li class="flex items-start">
                                <i class="fas fa-target text-orange-500 mr-3 mt-1"></i>
                                <span>Goal setting and achievement</span>
                            </li>
                        </ul>
                    </div>
                    <div>
                        <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-4">Detailed Reports</h3>
                        <ul class="space-y-3 text-gray-600 dark:text-gray-300">
                            <li class="flex items-start">
                                <i class="fas fa-file-chart text-orange-500 mr-3 mt-1"></i>
                                <span>Comprehensive exam reports</span>
                            </li>
                            <li class="flex items-start">
                                <i class="fas fa-lightbulb text-orange-500 mr-3 mt-1"></i>
                                <span>Improvement suggestions</span>
                            </li>
                            <li class="flex items-start">
                                <i class="fas fa-share-alt text-orange-500 mr-3 mt-1"></i>
                                <span>Share results with mentors</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Mobile Experience -->
            <div class="bg-white dark:bg-gray-800 rounded-3xl shadow-xl p-8 border border-gray-200 dark:border-gray-700">
                <div class="flex items-center mb-6">
                    <div class="w-16 h-16 bg-gradient-to-br from-primaryPurple to-purple-600 rounded-2xl flex items-center justify-center mr-6">
                        <i class="fas fa-mobile-alt text-white text-2xl"></i>
                    </div>
                    <div>
                        <h2 class="text-3xl font-bold text-gray-900 dark:text-white">Mobile-First Design</h2>
                        <p class="text-gray-600 dark:text-gray-400">Study and take exams on any device, anywhere, anytime</p>
                    </div>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div>
                        <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-4">Responsive Design</h3>
                        <ul class="space-y-3 text-gray-600 dark:text-gray-300">
                            <li class="flex items-start">
                                <i class="fas fa-tablet-alt text-purple-500 mr-3 mt-1"></i>
                                <span>Optimized for all screen sizes</span>
                            </li>
                            <li class="flex items-start">
                                <i class="fas fa-touch text-purple-500 mr-3 mt-1"></i>
                                <span>Touch-friendly interface</span>
                            </li>
                            <li class="flex items-start">
                                <i class="fas fa-sync text-purple-500 mr-3 mt-1"></i>
                                <span>Seamless device switching</span>
                            </li>
                        </ul>
                    </div>
                    <div>
                        <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-4">Offline Capabilities</h3>
                        <ul class="space-y-3 text-gray-600 dark:text-gray-300">
                            <li class="flex items-start">
                                <i class="fas fa-download text-purple-500 mr-3 mt-1"></i>
                                <span>Download study materials</span>
                            </li>
                            <li class="flex items-start">
                                <i class="fas fa-wifi text-purple-500 mr-3 mt-1"></i>
                                <span>Sync when online</span>
                            </li>
                            <li class="flex items-start">
                                <i class="fas fa-clock text-purple-500 mr-3 mt-1"></i>
                                <span>Study at your own pace</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <!-- CTA Section -->
        <div class="mt-16 bg-gradient-to-r from-primaryBlue to-blue-600 rounded-3xl p-8 text-white text-center">
            <h3 class="text-3xl font-bold mb-6">Ready to Start Your Learning Journey?</h3>
            <p class="text-xl text-blue-100 mb-8 max-w-3xl mx-auto">
                Join thousands of students already using Bikolpo LQ to excel in their exams and achieve their academic goals.
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="{{ route('student.dashboard') }}" class="bg-white text-primaryBlue px-8 py-4 rounded-full font-bold text-lg hover:bg-gray-100 transition-colors duration-200 transform hover:scale-105 shadow-lg">
                    <i class="fas fa-graduation-cap mr-2"></i>
                    Start Learning Now
                </a>
                <a href="{{ route('typing.test') }}" class="bg-orange-500 hover:bg-orange-600 text-white px-8 py-4 rounded-full font-bold text-lg transition-colors duration-200 transform hover:scale-105 shadow-lg">
                    <i class="fas fa-keyboard mr-2"></i>
                    Try Typing Test
                </a>
                <a href="{{ route('contact') }}" class="border-2 border-white text-white px-8 py-4 rounded-full font-bold text-lg hover:bg-white hover:text-primaryBlue transition-all duration-200">
                    <i class="fas fa-phone mr-2"></i>
                    Get Help & Support
                </a>
            </div>
        </div>
    </main>

    <!-- Footer -->
    <x-footer />

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

        // Header scroll effect
        const header = document.querySelector('header');
        window.addEventListener('scroll', () => {
            if (window.scrollY > 100) {
                header.classList.add('shadow-lg', 'bg-white/95', 'dark:bg-gray-800/95');
            } else {
                header.classList.remove('shadow-lg', 'bg-white/95', 'dark:bg-gray-800/95');
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
