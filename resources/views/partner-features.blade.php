<!DOCTYPE html>
<html lang="bn" class="scroll-smooth">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Partner Features - Bikolpo LQ</title>
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
    <section class="relative bg-gradient-to-br from-primaryGreen/10 via-blue-50 to-indigo-100 dark:from-primaryGreen/20 dark:via-gray-800 dark:to-gray-900 py-16 lg:py-20">
        <div class="absolute inset-0 bg-grid-pattern opacity-5"></div>
        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <div class="animate-fade-in">
                <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold text-gray-900 dark:text-white mb-6 leading-tight">
                    <span class="bg-gradient-to-r from-primaryGreen via-primaryBlue to-primaryPurple bg-clip-text text-transparent">
                        Partner Features
                    </span>
                </h1>
                <p class="text-xl md:text-2xl text-gray-600 dark:text-gray-400 mb-8 max-w-3xl mx-auto leading-relaxed">
                    Comprehensive tools and features designed specifically for educational partners to manage exams, students, and courses effectively.
                </p>
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <a href="{{ route('partner.area') }}" class="bg-gradient-to-r from-primaryGreen to-green-600 hover:from-green-600 hover:to-green-700 text-white px-8 py-4 rounded-full font-bold text-lg transition-all duration-300 transform hover:scale-105 shadow-xl hover:shadow-2xl">
                        <i class="fas fa-rocket mr-2"></i>
                        Get Started as Partner
                    </a>
                    <a href="{{ route('contact') }}" class="bg-white dark:bg-gray-800 text-gray-700 dark:text-gray-300 border-2 border-gray-300 dark:border-gray-600 hover:border-primaryGreen dark:hover:border-primaryGreen px-8 py-4 rounded-full font-bold text-lg transition-all duration-300 hover:shadow-lg">
                        <i class="fas fa-phone mr-2"></i>
                        Contact Us
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Main Content -->
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
        
        <!-- Core Features Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-16">
            
            <!-- Course Management -->
            <div class="bg-gradient-to-br from-blue-50 to-blue-100 dark:from-blue-900/30 dark:to-blue-800/30 p-8 rounded-3xl shadow-lg border border-blue-200 dark:border-blue-700 hover:shadow-xl transition-all duration-300 transform hover:-translate-y-2">
                <div class="text-center">
                    <div class="w-20 h-20 bg-blue-500 rounded-full flex items-center justify-center mx-auto mb-6 shadow-lg">
                        <i class="fas fa-book text-white text-3xl"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">Course Management</h3>
                    <p class="text-gray-600 dark:text-gray-300 mb-6">Create and manage multiple courses with subjects and topics</p>
                    <ul class="text-left text-gray-600 dark:text-gray-300 space-y-2">
                        <li class="flex items-center"><i class="fas fa-check text-blue-500 mr-2"></i>Unlimited courses</li>
                        <li class="flex items-center"><i class="fas fa-check text-blue-500 mr-2"></i>Subject organization</li>
                        <li class="flex items-center"><i class="fas fa-check text-blue-500 mr-2"></i>Topic management</li>
                    </ul>
                </div>
            </div>

            <!-- Question Bank -->
            <div class="bg-gradient-to-br from-green-50 to-green-100 dark:from-green-900/30 dark:to-green-800/30 p-8 rounded-3xl shadow-lg border border-green-200 dark:border-green-700 hover:shadow-xl transition-all duration-300 transform hover:-translate-y-2">
                <div class="text-center">
                    <div class="w-20 h-20 bg-green-500 rounded-full flex items-center justify-center mx-auto mb-6 shadow-lg">
                        <i class="fas fa-question-circle text-white text-3xl"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">Question Bank</h3>
                    <p class="text-gray-600 dark:text-gray-300 mb-6">Build comprehensive question banks with multiple question types</p>
                    <ul class="text-left text-gray-600 dark:text-gray-300 space-y-2">
                        <li class="flex items-center"><i class="fas fa-check text-green-500 mr-2"></i>MCQ questions</li>
                        <li class="flex items-center"><i class="fas fa-check text-green-500 mr-2"></i>Descriptive questions</li>
                        <li class="flex items-center"><i class="fas fa-check text-green-500 mr-2"></i>Question categories</li>
                    </ul>
                </div>
            </div>

            <!-- Exam Creation -->
            <div class="bg-gradient-to-br from-purple-50 to-purple-100 dark:from-purple-900/30 dark:to-purple-800/30 p-8 rounded-3xl shadow-lg border border-purple-200 dark:border-purple-700 hover:shadow-xl transition-all duration-300 transform hover:-translate-y-2">
                <div class="text-center">
                    <div class="w-20 h-20 bg-purple-500 rounded-full flex items-center justify-center mx-auto mb-6 shadow-lg">
                        <i class="fas fa-file-alt text-white text-3xl"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">Exam Creation</h3>
                    <p class="text-gray-600 dark:text-gray-300 mb-6">Design and schedule exams with custom settings</p>
                    <ul class="text-left text-gray-600 dark:text-gray-300 space-y-2">
                        <li class="flex items-center"><i class="fas fa-check text-purple-500 mr-2"></i>Custom time limits</li>
                        <li class="flex items-center"><i class="fas fa-check text-purple-500 mr-2"></i>Question randomization</li>
                        <li class="flex items-center"><i class="fas fa-check text-purple-500 mr-2"></i>Passing criteria</li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Detailed Features Section -->
        <div class="space-y-12">
            
            <!-- Student Management -->
            <div class="bg-white dark:bg-gray-800 rounded-3xl shadow-xl p-8 border border-gray-200 dark:border-gray-700">
                <div class="flex items-center mb-6">
                    <div class="w-16 h-16 bg-gradient-to-br from-primaryGreen to-green-600 rounded-2xl flex items-center justify-center mr-6">
                        <i class="fas fa-users text-white text-2xl"></i>
                    </div>
                    <div>
                        <h2 class="text-3xl font-bold text-gray-900 dark:text-white">Student Management</h2>
                        <p class="text-gray-600 dark:text-gray-400">Efficiently manage student batches and individual profiles</p>
                    </div>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-4">
                        <h3 class="text-xl font-semibold text-gray-900 dark:text-white">Batch Management</h3>
                        <ul class="space-y-2 text-gray-600 dark:text-gray-300">
                            <li class="flex items-center"><i class="fas fa-check text-primaryGreen mr-3"></i>Create multiple student batches</li>
                            <li class="flex items-center"><i class="fas fa-check text-primaryGreen mr-3"></i>Assign courses to batches</li>
                            <li class="flex items-center"><i class="fas fa-check text-primaryGreen mr-3"></i>Track batch progress</li>
                            <li class="flex items-center"><i class="fas fa-check text-primaryGreen mr-3"></i>Batch performance analytics</li>
                        </ul>
                    </div>
                    <div class="space-y-4">
                        <h3 class="text-xl font-semibold text-gray-900 dark:text-white">Individual Profiles</h3>
                        <ul class="space-y-2 text-gray-600 dark:text-gray-300">
                            <li class="flex items-center"><i class="fas fa-check text-primaryGreen mr-3"></i>Student registration</li>
                            <li class="flex items-center"><i class="fas fa-check text-primaryGreen mr-3"></i>Profile management</li>
                            <li class="flex items-center"><i class="fas fa-check text-primaryGreen mr-3"></i>Progress tracking</li>
                            <li class="flex items-center"><i class="fas fa-check text-primaryGreen mr-3"></i>Performance history</li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Advanced Analytics -->
            <div class="bg-white dark:bg-gray-800 rounded-3xl shadow-xl p-8 border border-gray-200 dark:border-gray-700">
                <div class="flex items-center mb-6">
                    <div class="w-16 h-16 bg-gradient-to-br from-primaryBlue to-blue-600 rounded-2xl flex items-center justify-center mr-6">
                        <i class="fas fa-chart-line text-white text-2xl"></i>
                    </div>
                    <div>
                        <h2 class="text-3xl font-bold text-gray-900 dark:text-white">Advanced Analytics</h2>
                        <p class="text-gray-600 dark:text-gray-400">Comprehensive insights into student performance and exam statistics</p>
                    </div>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="text-center p-6 bg-gray-50 dark:bg-gray-700 rounded-2xl">
                        <i class="fas fa-chart-bar text-4xl text-primaryBlue mb-4"></i>
                        <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-2">Performance Metrics</h3>
                        <p class="text-gray-600 dark:text-gray-400">Detailed analysis of student performance across all exams</p>
                    </div>
                    <div class="text-center p-6 bg-gray-50 dark:bg-gray-700 rounded-2xl">
                        <i class="fas fa-clock text-4xl text-primaryOrange mb-4"></i>
                        <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-2">Time Analysis</h3>
                        <p class="text-gray-600 dark:text-gray-400">Track completion times and identify bottlenecks</p>
                    </div>
                    <div class="text-center p-6 bg-gray-50 dark:bg-gray-700 rounded-2xl">
                        <i class="fas fa-trophy text-4xl text-primaryGreen mb-4"></i>
                        <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-2">Achievement Tracking</h3>
                        <p class="text-gray-600 dark:text-gray-400">Monitor student achievements and certifications</p>
                    </div>
                </div>
            </div>

            <!-- Security Features -->
            <div class="bg-white dark:bg-gray-800 rounded-3xl shadow-xl p-8 border border-gray-200 dark:border-gray-700">
                <div class="flex items-center mb-6">
                    <div class="w-16 h-16 bg-gradient-to-br from-red-500 to-red-600 rounded-2xl flex items-center justify-center mr-6">
                        <i class="fas fa-shield-alt text-white text-2xl"></i>
                    </div>
                    <div>
                        <h2 class="text-3xl font-bold text-gray-900 dark:text-white">Security & Control</h2>
                        <p class="text-gray-600 dark:text-gray-400">Enterprise-grade security features to protect your content</p>
                    </div>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div>
                        <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-4">Content Protection</h3>
                        <ul class="space-y-3 text-gray-600 dark:text-gray-300">
                            <li class="flex items-start">
                                <i class="fas fa-lock text-red-500 mr-3 mt-1"></i>
                                <span>Secure question bank with access controls</span>
                            </li>
                            <li class="flex items-start">
                                <i class="fas fa-eye-slash text-red-500 mr-3 mt-1"></i>
                                <span>Prevent question copying and sharing</span>
                            </li>
                            <li class="flex items-start">
                                <i class="fas fa-user-shield text-red-500 mr-3 mt-1"></i>
                                <span>Role-based access management</span>
                            </li>
                        </ul>
                    </div>
                    <div>
                        <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-4">Exam Security</h3>
                        <ul class="space-y-3 text-gray-600 dark:text-gray-300">
                            <li class="flex items-start">
                                <i class="fas fa-stopwatch text-red-500 mr-3 mt-1"></i>
                                <span>Time-limited exam sessions</span>
                            </li>
                            <li class="flex items-start">
                                <i class="fas fa-random text-red-500 mr-3 mt-1"></i>
                                <span>Question randomization</span>
                            </li>
                            <li class="flex items-start">
                                <i class="fas fa-history text-red-500 mr-3 mt-1"></i>
                                <span>Complete audit trails</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Integration & API -->
            <div class="bg-white dark:bg-gray-800 rounded-3xl shadow-xl p-8 border border-gray-200 dark:border-gray-700">
                <div class="flex items-center mb-6">
                    <div class="w-16 h-16 bg-gradient-to-br from-primaryPurple to-purple-600 rounded-2xl flex items-center justify-center mr-6">
                        <i class="fas fa-plug text-white text-2xl"></i>
                    </div>
                    <div>
                        <h2 class="text-3xl font-bold text-gray-900 dark:text-white">Integration & API</h2>
                        <p class="text-gray-600 dark:text-gray-400">Seamlessly integrate with your existing systems</p>
                    </div>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div>
                        <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-4">API Access</h3>
                        <ul class="space-y-3 text-gray-600 dark:text-gray-300">
                            <li class="flex items-start">
                                <i class="fas fa-code text-purple-500 mr-3 mt-1"></i>
                                <span>RESTful API for custom integrations</span>
                            </li>
                            <li class="flex items-start">
                                <i class="fas fa-database text-purple-500 mr-3 mt-1"></i>
                                <span>Data export in multiple formats</span>
                            </li>
                            <li class="flex items-start">
                                <i class="fas fa-sync text-purple-500 mr-3 mt-1"></i>
                                <span>Real-time data synchronization</span>
                            </li>
                        </ul>
                    </div>
                    <div>
                        <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-4">Third-party Tools</h3>
                        <ul class="space-y-3 text-gray-600 dark:text-gray-300">
                            <li class="flex items-start">
                                <i class="fas fa-upload text-purple-500 mr-3 mt-1"></i>
                                <span>Bulk import from Excel/CSV</span>
                            </li>
                            <li class="flex items-start">
                                <i class="fas fa-download text-purple-500 mr-3 mt-1"></i>
                                <span>Export results and reports</span>
                            </li>
                            <li class="flex items-start">
                                <i class="fas fa-link text-purple-500 mr-3 mt-1"></i>
                                <span>LMS integration support</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <!-- CTA Section -->
        <div class="mt-16 bg-gradient-to-r from-primaryGreen to-green-600 rounded-3xl p-8 text-white text-center">
            <h3 class="text-3xl font-bold mb-6">Ready to Become a Partner?</h3>
            <p class="text-xl text-green-100 mb-8 max-w-3xl mx-auto">
                Join hundreds of educational institutions already using Bikolpo LQ to transform their exam management.
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="{{ route('partner.area') }}" class="bg-white text-primaryGreen px-8 py-4 rounded-full font-bold text-lg hover:bg-gray-100 transition-colors duration-200 transform hover:scale-105 shadow-lg">
                    <i class="fas fa-rocket mr-2"></i>
                    Start Partner Journey
                </a>
                <a href="{{ route('contact') }}" class="border-2 border-white text-white px-8 py-4 rounded-full font-bold text-lg hover:bg-white hover:text-primaryGreen transition-all duration-200">
                    <i class="fas fa-phone mr-2"></i>
                    Contact Sales Team
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
