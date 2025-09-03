<!DOCTYPE html>
<html lang="bn" class="scroll-smooth">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Student Features - Bikolpo LQ</title>
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
                    Experience seamless online exams with powerful tools designed to enhance your learning journey and assessment experience.
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

    <!-- Main Content -->
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
        
        <!-- Core Features Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-16">
            
            <!-- Online Exams -->
            <div class="bg-gradient-to-br from-blue-50 to-blue-100 dark:from-blue-900/30 dark:to-blue-800/30 p-8 rounded-3xl shadow-lg border border-blue-200 dark:border-blue-700 hover:shadow-xl transition-all duration-300 transform hover:-translate-y-2">
                <div class="text-center">
                    <div class="w-20 h-20 bg-blue-500 rounded-full flex items-center justify-center mx-auto mb-6 shadow-lg">
                        <i class="fas fa-laptop text-white text-3xl"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">Online Exams</h3>
                    <p class="text-gray-600 dark:text-gray-300 mb-6">Take exams from anywhere with our secure online platform</p>
                    <ul class="text-left text-gray-600 dark:text-gray-300 space-y-2">
                        <li class="flex items-center"><i class="fas fa-check text-blue-500 mr-2"></i>24/7 accessibility</li>
                        <li class="flex items-center"><i class="fas fa-check text-blue-500 mr-2"></i>Auto-save progress</li>
                        <li class="flex items-center"><i class="fas fa-check text-blue-500 mr-2"></i>Instant results</li>
                    </ul>
                </div>
            </div>

            <!-- Practice Tests -->
            <div class="bg-gradient-to-br from-green-50 to-green-100 dark:from-green-900/30 dark:to-green-800/30 p-8 rounded-3xl shadow-lg border border-green-200 dark:border-green-700 hover:shadow-xl transition-all duration-300 transform hover:-translate-y-2">
                <div class="text-center">
                    <div class="w-20 h-20 bg-green-500 rounded-full flex items-center justify-center mx-auto mb-6 shadow-lg">
                        <i class="fas fa-dumbbell text-white text-3xl"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">Practice Tests</h3>
                    <p class="text-gray-600 dark:text-gray-300 mb-6">Improve your skills with unlimited practice opportunities</p>
                    <ul class="text-left text-gray-600 dark:text-gray-300 space-y-2">
                        <li class="flex items-center"><i class="fas fa-check text-green-500 mr-2"></i>Unlimited attempts</li>
                        <li class="flex items-center"><i class="fas fa-check text-green-500 mr-2"></i>Performance feedback</li>
                        <li class="flex items-center"><i class="fas fa-check text-green-500 mr-2"></i>Topic-wise practice</li>
                    </ul>
                </div>
            </div>

            <!-- Progress Tracking -->
            <div class="bg-gradient-to-br from-purple-50 to-purple-100 dark:from-purple-900/30 dark:to-purple-800/30 p-8 rounded-3xl shadow-lg border border-purple-200 dark:border-purple-700 hover:shadow-xl transition-all duration-300 transform hover:-translate-y-2">
                <div class="text-center">
                    <div class="w-20 h-20 bg-purple-500 rounded-full flex items-center justify-center mx-auto mb-6 shadow-lg">
                        <i class="fas fa-chart-line text-white text-3xl"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">Progress Tracking</h3>
                    <p class="text-gray-600 dark:text-gray-300 mb-6">Monitor your learning progress with detailed analytics</p>
                    <ul class="text-left text-gray-600 dark:text-gray-300 space-y-2">
                        <li class="flex items-center"><i class="fas fa-check text-purple-500 mr-2"></i>Performance graphs</li>
                        <li class="flex items-center"><i class="fas fa-check text-purple-500 mr-2"></i>Weak area identification</li>
                        <li class="flex items-center"><i class="fas fa-check text-purple-500 mr-2"></i>Learning milestones</li>
                    </ul>
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
