<!DOCTYPE html>
<html lang="bn" class="scroll-smooth">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Bikolpo Live - Online Test Platform for Students & Educational Partners</title>
    <meta name="description" content="Bikolpo Live is a smart online exam platform for students and educational partners. Practice MCQs, take tests, and track your progress with real-time analytics.">
    <meta name="keywords" content="online exam, MCQ test, educational platform, student testing, exam preparation, learning platform, Bangladesh education">
    <meta name="author" content="Bikolpo Live">
    
    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="https://bikolpolive.com/">
    <meta property="og:title" content="Bikolpo Live - Smart Online Exam Platform">
    <meta property="og:description" content="Revolutionize your learning journey with our AI-powered online testing platform. Practice smarter, perform better, achieve more.">
    <meta property="og:image" content="https://bikolpolive.com/images/bikolpoLive_TR.png">
    
    <!-- Twitter -->
    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:url" content="https://bikolpolive.com/">
    <meta property="twitter:title" content="Bikolpo Live - Smart Online Exam Platform">
    <meta property="twitter:description" content="Revolutionize your learning journey with our AI-powered online testing platform. Practice smarter, perform better, achieve more.">
    <meta property="twitter:image" content="https://bikolpolive.com/images/bikolpoLive_TR.png">
    
    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script>
        // Only set Tailwind config when using the CDN build
        if (typeof tailwind !== 'undefined') {
            tailwind.config = {
                darkMode: 'class',
                theme: {
                    extend: {
                        fontFamily: {
                            bangla: ['"Nikosh"', '"Hind Siliguri"', 'sans-serif'],
                            brand: ['"Poppins"', 'sans-serif'],
                            modern: ['"Inter"', 'sans-serif'],
                            display: ['"Space Grotesk"', 'sans-serif']
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
            };
        }
    </script>
    <link href="https://fonts.googleapis.com/css2?family=Nikosh:wght@300;400;500;600;700&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@300;400;500;600;700&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Lilita+One&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />

</head>

<body class="bg-gradient-to-br from-gray-50 to-gray-100 dark:from-gray-900 dark:to-gray-800 text-gray-800 dark:text-gray-100 font-bangla">
    
    @include('navigation-layout')

    <!-- Hero Section -->
    <section class="relative overflow-hidden bg-gradient-to-br from-white via-blue-50 to-indigo-100 dark:from-gray-900 dark:via-gray-800 dark:to-gray-900 pt-6 pb-12 lg:pt-8 lg:pb-16">
        <div class="absolute inset-0 bg-grid-pattern opacity-5"></div>
        <div class="absolute inset-0 bg-gradient-to-r from-primaryGreen/5 via-transparent to-primaryBlue/5"></div>
        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <div class="animate-fade-in">
                <!-- Badge -->
                <div class="inline-flex items-center px-4 py-0 rounded-full bg-primaryGreen/10 text-primaryGreen text-sm font-medium mb-4 border border-primaryGreen/20">
                    <i class="fas fa-star mr-2"></i>
                    Trusted by 1000+ Students & 50+ Partners
                </div>
                
                <h1 class="text-5xl md:text-7xl lg:text-8xl font-black text-gray-900 dark:text-white mb-4 leading-tight">
                    <div class="brand-visible font-brand tracking-wide flex flex-col items-center">
                        <img src="{{ asset('images/bikolpoLive_TR.png') }}" alt="Bikolpo Live - Smart Online Exam Platform" class="h-48 md:h-32 lg:h-40 mb-1">
                        <span class="text-4xl md:text-5xl lg:text-6xl text-gray-700 dark:text-gray-300 font-light font-modern mt-2">
                            Your Smart Exam Partner
                        </span>
                    </div>
                </h1>
                <p class="text-xl md:text-2xl lg:text-3xl text-gray-600 dark:text-gray-400 mb-6 max-w-4xl mx-auto leading-relaxed font-light">
                    Revolutionize your learning journey with our AI-powered online testing platform. 
                    <span class="text-primaryGreen font-semibold">Practice smarter, perform better, achieve more.</span>
                </p>
                
                <!-- Key Benefits -->
                <div class="flex flex-wrap justify-center gap-6 mb-6 text-sm md:text-base">
                    <div class="flex items-center text-gray-600 dark:text-gray-400">
                        <i class="fas fa-check-circle text-primaryGreen mr-2"></i>
                        Instant Results & Analytics
                    </div>
                    <div class="flex items-center text-gray-600 dark:text-gray-400">
                        <i class="fas fa-check-circle text-primaryGreen mr-2"></i>
                        Multi-Device Support
                    </div>
                    <div class="flex items-center text-gray-600 dark:text-gray-400">
                        <i class="fas fa-check-circle text-primaryGreen mr-2"></i>
                        24/7 Access
                    </div>
                </div>
                
                <div class="flex justify-center">
                    <a href="{{ route('register') }}" class="group bg-gradient-to-r from-primaryGreen to-green-600 hover:from-green-600 hover:to-green-700 text-white px-10 py-5 rounded-full font-bold text-lg transition-all duration-300 transform hover:scale-105 shadow-xl hover:shadow-2xl">
                        Start your partner journey
                        <i class="fas fa-arrow-right ml-2 group-hover:translate-x-1 transition-transform duration-200"></i>
                    </a>
                </div>
                
                <!-- Trust Indicators -->
                <div class="mt-8 flex flex-wrap justify-center items-center gap-8 opacity-60">
                    <div class="text-sm text-gray-500 dark:text-gray-400">
                        <i class="fas fa-shield-alt text-primaryGreen mr-1"></i>
                        Secure & Reliable
                    </div>
                    <div class="text-sm text-gray-500 dark:text-gray-400">
                        <i class="fas fa-clock text-primaryBlue mr-1"></i>
                        Real-time Results
                    </div>
                    <div class="text-sm text-gray-500 dark:text-gray-400">
                        <i class="fas fa-users text-primaryPurple mr-1"></i>
                        Community Driven
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Enhanced Floating Elements -->
        <div class="absolute top-20 left-10 w-24 h-24 bg-gradient-to-br from-primaryGreen/20 to-green-400/20 rounded-full animate-bounce-slow"></div>
        <div class="absolute top-40 right-20 w-20 h-20 bg-gradient-to-br from-primaryOrange/20 to-orange-400/20 rounded-full animate-pulse-slow"></div>
        <div class="absolute bottom-20 left-20 w-16 h-16 bg-gradient-to-br from-primaryBlue/20 to-blue-400/20 rounded-full animate-bounce-slow animation-delay-1000"></div>
        <div class="absolute top-60 left-1/4 w-12 h-12 bg-gradient-to-br from-primaryPurple/20 to-purple-400/20 rounded-full animate-pulse-slow animation-delay-2000"></div>
    </section>

    <!-- Features Section -->
    <section id="features" class="py-16 bg-white dark:bg-gray-900">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-20">
                <div class="inline-flex items-center px-4 py-2 rounded-full bg-primaryBlue/10 text-primaryBlue text-sm font-medium mb-6 border border-primaryBlue/20">
                    <i class="fas fa-rocket mr-2"></i>
                    Powerful Features
                </div>
                <h2 class="text-4xl md:text-5xl lg:text-6xl font-bold text-gray-900 dark:text-white mb-6">
                    Everything You Need to 
                    <span class="bg-gradient-to-r from-primaryGreen to-primaryBlue bg-clip-text text-transparent">Excel</span>
                </h2>
                <p class="text-xl md:text-2xl text-gray-600 dark:text-gray-400 max-w-4xl mx-auto leading-relaxed">
                    From comprehensive testing to detailed analytics, we provide all the tools you need for modern learning
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <!-- Feature Card 1 -->
                <div class="group bg-gradient-to-br from-white to-gray-50 dark:from-gray-800 dark:to-gray-900 p-8 rounded-3xl shadow-lg hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-3 border border-gray-200 dark:border-gray-700 relative overflow-hidden">
                    <div class="absolute top-0 right-0 w-32 h-32 bg-gradient-to-br from-primaryGreen/10 to-transparent rounded-full -translate-y-16 translate-x-16"></div>
                    <div class="relative">
                        <div class="w-20 h-20 bg-gradient-to-br from-primaryGreen to-green-600 rounded-3xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-300 shadow-lg">
                            <img src="{{ asset('images/mcq.png') }}" alt="MCQ Testing" class="w-10 h-10 filter brightness-0 invert">
                        </div>
                        <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">Smart MCQ Testing</h3>
                        <p class="text-gray-600 dark:text-gray-400 leading-relaxed mb-4">
                            Advanced multiple choice questions with instant scoring, detailed explanations, and performance analytics.
                        </p>
                        <ul class="text-sm text-gray-500 dark:text-gray-400 space-y-1">
                            <li>• Instant feedback & results</li>
                            <li>• Detailed answer explanations</li>
                            <li>• Performance tracking</li>
                        </ul>
                    </div>
                </div>

                <!-- Feature Card 2 -->
                <div class="group bg-gradient-to-br from-white to-gray-50 dark:from-gray-800 dark:to-gray-900 p-8 rounded-3xl shadow-lg hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-3 border border-gray-200 dark:border-gray-700 relative overflow-hidden">
                    <div class="absolute top-0 right-0 w-32 h-32 bg-gradient-to-br from-primaryOrange/10 to-transparent rounded-full -translate-y-16 translate-x-16"></div>
                    <div class="relative">
                        <div class="w-20 h-20 bg-gradient-to-br from-primaryOrange to-orange-600 rounded-3xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-300 shadow-lg">
                            <i class="fas fa-database text-white text-3xl"></i>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">Advanced Question Bank</h3>
                        <p class="text-gray-600 dark:text-gray-400 leading-relaxed mb-4">
                            Comprehensive question database with multiple difficulty levels, subject categorization, and detailed explanations.
                        </p>
                        <ul class="text-sm text-gray-500 dark:text-gray-400 space-y-1">
                            <li>• Multiple difficulty levels</li>
                            <li>• Subject-wise categorization</li>
                            <li>• Detailed explanations</li>
                        </ul>
                    </div>
                </div>

                <!-- Feature Card 3 -->
                <div class="group bg-gradient-to-br from-white to-gray-50 dark:from-gray-800 dark:to-gray-900 p-8 rounded-3xl shadow-lg hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-3 border border-gray-200 dark:border-gray-700 relative overflow-hidden">
                    <div class="absolute top-0 right-0 w-32 h-32 bg-gradient-to-br from-primaryBlue/10 to-transparent rounded-full -translate-y-16 translate-x-16"></div>
                    <div class="relative">
                        <div class="w-20 h-20 bg-gradient-to-br from-primaryBlue to-blue-600 rounded-3xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-300 shadow-lg">
                            <i class="fas fa-chart-line text-white text-3xl"></i>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">Advanced Analytics</h3>
                        <p class="text-gray-600 dark:text-gray-400 leading-relaxed mb-4">
                            Detailed progress tracking with comprehensive reports, performance insights, and learning recommendations.
                        </p>
                        <ul class="text-sm text-gray-500 dark:text-gray-400 space-y-1">
                            <li>• Detailed progress reports</li>
                            <li>• Performance insights</li>
                            <li>• Learning recommendations</li>
                        </ul>
                    </div>
                </div>

                <!-- Feature Card 4 -->
                <div class="group bg-gradient-to-br from-white to-gray-50 dark:from-gray-800 dark:to-gray-900 p-8 rounded-3xl shadow-lg hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-3 border border-gray-200 dark:border-gray-700 relative overflow-hidden">
                    <div class="absolute top-0 right-0 w-32 h-32 bg-gradient-to-br from-primaryPurple/10 to-transparent rounded-full -translate-y-16 translate-x-16"></div>
                    <div class="relative">
                        <div class="w-20 h-20 bg-gradient-to-br from-primaryPurple to-purple-600 rounded-3xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-300 shadow-lg">
                            <i class="fas fa-users text-white text-3xl"></i>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">Partner Ecosystem</h3>
                        <p class="text-gray-600 dark:text-gray-400 leading-relaxed mb-4">
                            Comprehensive partner management system for institutions, teachers, and educational organizations.
                        </p>
                        <ul class="text-sm text-gray-500 dark:text-gray-400 space-y-1">
                            <li>• Multi-partner support</li>
                            <li>• Batch management</li>
                            <li>• Custom branding</li>
                        </ul>
                    </div>
                </div>

                <!-- Feature Card 5 -->
                <div class="group bg-gradient-to-br from-white to-gray-50 dark:from-gray-800 dark:to-gray-900 p-8 rounded-3xl shadow-lg hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-3 border border-gray-200 dark:border-gray-700 relative overflow-hidden">
                    <div class="absolute top-0 right-0 w-32 h-32 bg-gradient-to-br from-emerald-500/10 to-transparent rounded-full -translate-y-16 translate-x-16"></div>
                    <div class="relative">
                        <div class="w-20 h-20 bg-gradient-to-br from-emerald-500 to-emerald-600 rounded-3xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-300 shadow-lg">
                            <i class="fas fa-shield-alt text-white text-3xl"></i>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">Enterprise Security</h3>
                        <p class="text-gray-600 dark:text-gray-400 leading-relaxed mb-4">
                            Bank-grade security with encrypted data transmission, secure authentication, and privacy protection.
                        </p>
                        <ul class="text-sm text-gray-500 dark:text-gray-400 space-y-1">
                            <li>• End-to-end encryption</li>
                            <li>• Secure authentication</li>
                            <li>• Privacy protection</li>
                        </ul>
                    </div>
                </div>

                <!-- Feature Card 6 -->
                <div class="group bg-gradient-to-br from-white to-gray-50 dark:from-gray-800 dark:to-gray-900 p-8 rounded-3xl shadow-lg hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-3 border border-gray-200 dark:border-gray-700 relative overflow-hidden">
                    <div class="absolute top-0 right-0 w-32 h-32 bg-gradient-to-br from-rose-500/10 to-transparent rounded-full -translate-y-16 translate-x-16"></div>
                    <div class="relative">
                        <div class="w-20 h-20 bg-gradient-to-br from-rose-500 to-rose-600 rounded-3xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-300 shadow-lg">
                            <i class="fas fa-mobile-alt text-white text-3xl"></i>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">Universal Access</h3>
                        <p class="text-gray-600 dark:text-gray-400 leading-relaxed mb-4">
                            Seamless experience across all devices with responsive design and offline capabilities.
                        </p>
                        <ul class="text-sm text-gray-500 dark:text-gray-400 space-y-1">
                            <li>• Cross-platform support</li>
                            <li>• Offline capabilities</li>
                            <li>• Touch-optimized interface</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Stats Section -->
    <section class="py-16 bg-gradient-to-br from-slate-900 via-gray-900 to-black text-white relative overflow-hidden">
        <!-- Animated Background Elements -->
        <div class="absolute inset-0">
            <div class="absolute top-0 left-0 w-full h-full bg-gradient-to-br from-primaryGreen/5 via-transparent to-primaryBlue/5"></div>
            <div class="absolute top-20 left-10 w-72 h-72 bg-primaryGreen/10 rounded-full blur-3xl animate-pulse"></div>
            <div class="absolute bottom-20 right-10 w-96 h-96 bg-primaryBlue/10 rounded-full blur-3xl animate-pulse animation-delay-1000"></div>
            <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-64 h-64 bg-primaryPurple/10 rounded-full blur-3xl animate-pulse animation-delay-2000"></div>
        </div>
        
        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 bg-gradient-to-br from-white/10 to-gray-100/20 backdrop-blur-sm rounded-3xl p-8">
            <!-- Header -->
            <div class="text-center mb-20">
                <div class="inline-flex items-center px-6 py-3 rounded-full bg-white/10 backdrop-blur-sm border border-white/20 mb-8">
                    <i class="fas fa-chart-line text-primaryGreen mr-3 text-lg"></i>
                    <span class="text-sm font-medium text-gray-300">Our Impact in Numbers</span>
                </div>
                <h2 class="text-4xl md:text-5xl lg:text-6xl font-bold mb-6 bg-gradient-to-r from-white via-gray-200 to-gray-400 bg-clip-text text-transparent">
                    Trusted by Thousands
                </h2>
                <p class="text-xl text-gray-400 max-w-3xl mx-auto leading-relaxed">
                    Join the growing community of learners and educators who trust Bikolpo Live for their educational success
                </p>
            </div>
            
            <!-- Main Stats Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8 mb-16">
                <!-- Stat Card 1 -->
                <div class="group relative">
                    <div class="absolute inset-0 bg-gradient-to-br from-primaryGreen/20 to-green-600/20 rounded-3xl blur-xl group-hover:blur-2xl transition-all duration-500"></div>
                    <div class="relative bg-white/5 backdrop-blur-xl rounded-3xl p-8 border border-white/10 hover:border-primaryGreen/30 transition-all duration-500 group-hover:bg-white/10">
                        <div class="flex items-center justify-between mb-6">
                            <div class="w-14 h-14 bg-gradient-to-br from-primaryGreen to-green-600 rounded-2xl flex items-center justify-center group-hover:scale-110 transition-transform duration-300 shadow-lg">
                                <i class="fas fa-users text-white text-xl"></i>
                            </div>
                            <div class="text-right">
                                <div class="text-4xl md:text-5xl font-black mb-1 group-hover:scale-110 transition-transform duration-300 bg-gradient-to-r from-primaryGreen to-green-400 bg-clip-text text-transparent">
                                    <span class="counter" data-target="2500">0</span>+
                                </div>
                                <p class="text-sm text-gray-400 font-medium">Active Students</p>
                            </div>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-gray-300 text-sm">Growing daily</span>
                            <div class="flex items-center text-primaryGreen text-sm">
                                <i class="fas fa-arrow-up mr-1"></i>
                                <span>+12%</span>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Stat Card 2 -->
                <div class="group relative">
                    <div class="absolute inset-0 bg-gradient-to-br from-primaryBlue/20 to-blue-600/20 rounded-3xl blur-xl group-hover:blur-2xl transition-all duration-500"></div>
                    <div class="relative bg-white/5 backdrop-blur-xl rounded-3xl p-8 border border-white/10 hover:border-primaryBlue/30 transition-all duration-500 group-hover:bg-white/10">
                        <div class="flex items-center justify-between mb-6">
                            <div class="w-14 h-14 bg-gradient-to-br from-primaryBlue to-blue-600 rounded-2xl flex items-center justify-center group-hover:scale-110 transition-transform duration-300 shadow-lg">
                                <i class="fas fa-graduation-cap text-white text-xl"></i>
                            </div>
                            <div class="text-right">
                                <div class="text-4xl md:text-5xl font-black mb-1 group-hover:scale-110 transition-transform duration-300 bg-gradient-to-r from-primaryBlue to-blue-400 bg-clip-text text-transparent">
                                    <span class="counter" data-target="1500">0</span>+
                                </div>
                                <p class="text-sm text-gray-400 font-medium">Exams Completed</p>
                            </div>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-gray-300 text-sm">This month</span>
                            <div class="flex items-center text-primaryBlue text-sm">
                                <i class="fas fa-arrow-up mr-1"></i>
                                <span>+8%</span>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Stat Card 3 -->
                <div class="group relative">
                    <div class="absolute inset-0 bg-gradient-to-br from-primaryPurple/20 to-purple-600/20 rounded-3xl blur-xl group-hover:blur-2xl transition-all duration-500"></div>
                    <div class="relative bg-white/5 backdrop-blur-xl rounded-3xl p-8 border border-white/10 hover:border-primaryPurple/30 transition-all duration-500 group-hover:bg-white/10">
                        <div class="flex items-center justify-between mb-6">
                            <div class="w-14 h-14 bg-gradient-to-br from-primaryPurple to-purple-600 rounded-2xl flex items-center justify-center group-hover:scale-110 transition-transform duration-300 shadow-lg">
                                <i class="fas fa-building text-white text-xl"></i>
                            </div>
                            <div class="text-right">
                                <div class="text-4xl md:text-5xl font-black mb-1 group-hover:scale-110 transition-transform duration-300 bg-gradient-to-r from-primaryPurple to-purple-400 bg-clip-text text-transparent">
                                    <span class="counter" data-target="75">0</span>+
                                </div>
                                <p class="text-sm text-gray-400 font-medium">Partner Institutions</p>
                            </div>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-gray-300 text-sm">Across Bangladesh</span>
                            <div class="flex items-center text-primaryPurple text-sm">
                                <i class="fas fa-arrow-up mr-1"></i>
                                <span>+5%</span>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Stat Card 4 -->
                <div class="group relative">
                    <div class="absolute inset-0 bg-gradient-to-br from-primaryOrange/20 to-orange-600/20 rounded-3xl blur-xl group-hover:blur-2xl transition-all duration-500"></div>
                    <div class="relative bg-white/5 backdrop-blur-xl rounded-3xl p-8 border border-white/10 hover:border-primaryOrange/30 transition-all duration-500 group-hover:bg-white/10">
                        <div class="flex items-center justify-between mb-6">
                            <div class="w-14 h-14 bg-gradient-to-br from-primaryOrange to-orange-600 rounded-2xl flex items-center justify-center group-hover:scale-110 transition-transform duration-300 shadow-lg">
                                <i class="fas fa-clock text-white text-xl"></i>
                            </div>
                            <div class="text-right">
                                <div class="text-4xl md:text-5xl font-black mb-1 group-hover:scale-110 transition-transform duration-300 bg-gradient-to-r from-primaryOrange to-orange-400 bg-clip-text text-transparent">
                                    <span class="counter" data-target="99">0</span>.<span class="counter" data-target="9">0</span>%
                                </div>
                                <p class="text-sm text-gray-400 font-medium">Uptime</p>
                            </div>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-gray-300 text-sm">Reliable service</span>
                            <div class="flex items-center text-primaryOrange text-sm">
                                <i class="fas fa-check mr-1"></i>
                                <span>99.9%</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Additional Stats Row -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="group bg-white/5 backdrop-blur-xl rounded-2xl p-6 border border-white/10 hover:border-white/20 transition-all duration-300 text-center">
                    <div class="text-3xl md:text-4xl font-black mb-2 group-hover:scale-110 transition-transform duration-300 bg-gradient-to-r from-emerald-400 to-emerald-600 bg-clip-text text-transparent">
                        <span class="counter" data-target="50000">0</span>+
                    </div>
                    <p class="text-gray-300 text-lg font-medium">Questions Answered</p>
                    <p class="text-gray-500 text-sm mt-1">And counting...</p>
                </div>
                <div class="group bg-white/5 backdrop-blur-xl rounded-2xl p-6 border border-white/10 hover:border-white/20 transition-all duration-300 text-center">
                    <div class="text-3xl md:text-4xl font-black mb-2 group-hover:scale-110 transition-transform duration-300 bg-gradient-to-r from-cyan-400 to-cyan-600 bg-clip-text text-transparent">
                        <span class="counter" data-target="24">0</span>/7
                    </div>
                    <p class="text-gray-300 text-lg font-medium">Support Available</p>
                    <p class="text-gray-500 text-sm mt-1">Always here for you</p>
                </div>
                <div class="group bg-white/5 backdrop-blur-xl rounded-2xl p-6 border border-white/10 hover:border-white/20 transition-all duration-300 text-center">
                    <div class="text-3xl md:text-4xl font-black mb-2 group-hover:scale-110 transition-transform duration-300 bg-gradient-to-r from-rose-400 to-rose-600 bg-clip-text text-transparent">
                        <span class="counter" data-target="15">0</span>+
                    </div>
                    <p class="text-gray-300 text-lg font-medium">Subjects Covered</p>
                    <p class="text-gray-500 text-sm mt-1">Comprehensive learning</p>
                </div>
            </div>
        </div>
    </section>


    <!-- Why Choose Bikolpo Live? -->
    <section id="about" class="py-16 bg-gradient-to-br from-white via-blue-50 to-indigo-100 dark:from-gray-900 dark:via-gray-800 dark:to-gray-900 relative overflow-hidden">
        <!-- Background Elements -->
        <div class="absolute inset-0">
            <div class="absolute top-0 right-0 w-96 h-96 bg-primaryGreen/5 rounded-full blur-3xl"></div>
            <div class="absolute bottom-0 left-0 w-80 h-80 bg-primaryBlue/5 rounded-full blur-3xl"></div>
            <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-64 h-64 bg-primaryPurple/5 rounded-full blur-3xl"></div>
        </div>
        
        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="text-center mb-20">
                <div class="inline-flex items-center px-6 py-3 rounded-full bg-primaryGreen/10 border border-primaryGreen/20 mb-8">
                    <i class="fas fa-star text-primaryGreen mr-3 text-lg"></i>
                    <span class="text-sm font-medium text-primaryGreen">Why Choose Us</span>
                </div>
                <h2 class="text-4xl md:text-5xl lg:text-6xl font-bold mb-6 bg-gradient-to-r from-gray-900 via-primaryGreen to-primaryBlue dark:from-white dark:via-primaryGreen dark:to-primaryBlue bg-clip-text text-transparent">
                    Why Choose Bikolpo Live?
                </h2>
                <p class="text-xl text-gray-600 dark:text-gray-400 max-w-4xl mx-auto leading-relaxed">
                    Experience the future of online education with our cutting-edge platform designed to transform how you learn, test, and succeed.
                </p>
            </div>

            <div class="max-w-4xl mx-auto">
                <!-- Left Content -->
                <div class="space-y-8">
                    <!-- Feature Cards -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Feature 1 -->
                        <div class="group bg-white/80 dark:bg-gray-800/80 backdrop-blur-sm rounded-2xl p-6 border border-gray-200/50 dark:border-gray-700/50 hover:border-primaryGreen/30 transition-all duration-300 hover:shadow-xl hover:-translate-y-1">
                            <div class="w-12 h-12 bg-gradient-to-br from-primaryGreen to-green-600 rounded-xl flex items-center justify-center mb-4 group-hover:scale-110 transition-transform duration-300">
                                <i class="fas fa-cogs text-white text-lg"></i>
                            </div>
                            <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-2">Advanced Question Management</h3>
                            <p class="text-gray-600 dark:text-gray-400 text-sm leading-relaxed">Smart question categorization, auto-grading, and comprehensive analytics for optimal learning outcomes.</p>
                        </div>

                        <!-- Feature 2 -->
                        <div class="group bg-white/80 dark:bg-gray-800/80 backdrop-blur-sm rounded-2xl p-6 border border-gray-200/50 dark:border-gray-700/50 hover:border-primaryBlue/30 transition-all duration-300 hover:shadow-xl hover:-translate-y-1">
                            <div class="w-12 h-12 bg-gradient-to-br from-primaryBlue to-blue-600 rounded-xl flex items-center justify-center mb-4 group-hover:scale-110 transition-transform duration-300">
                                <i class="fas fa-chart-line text-white text-lg"></i>
                            </div>
                            <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-2">Real-time Analytics</h3>
                            <p class="text-gray-600 dark:text-gray-400 text-sm leading-relaxed">Instant performance insights, detailed reports, and personalized learning recommendations.</p>
                        </div>

                        <!-- Feature 3 -->
                        <div class="group bg-white/80 dark:bg-gray-800/80 backdrop-blur-sm rounded-2xl p-6 border border-gray-200/50 dark:border-gray-700/50 hover:border-primaryPurple/30 transition-all duration-300 hover:shadow-xl hover:-translate-y-1">
                            <div class="w-12 h-12 bg-gradient-to-br from-primaryPurple to-purple-600 rounded-xl flex items-center justify-center mb-4 group-hover:scale-110 transition-transform duration-300">
                                <i class="fas fa-globe text-white text-lg"></i>
                            </div>
                            <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-2">Multi-language Support</h3>
                            <p class="text-gray-600 dark:text-gray-400 text-sm leading-relaxed">Seamless experience in Bengali, English, and other languages for inclusive learning.</p>
                        </div>

                        <!-- Feature 4 -->
                        <div class="group bg-white/80 dark:bg-gray-800/80 backdrop-blur-sm rounded-2xl p-6 border border-gray-200/50 dark:border-gray-700/50 hover:border-primaryOrange/30 transition-all duration-300 hover:shadow-xl hover:-translate-y-1">
                            <div class="w-12 h-12 bg-gradient-to-br from-primaryOrange to-orange-600 rounded-xl flex items-center justify-center mb-4 group-hover:scale-110 transition-transform duration-300">
                                <i class="fas fa-headset text-white text-lg"></i>
                            </div>
                            <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-2">24/7 Support</h3>
                            <p class="text-gray-600 dark:text-gray-400 text-sm leading-relaxed">Round-the-clock customer support to ensure your learning journey is never interrupted.</p>
                        </div>
                    </div>

                    <!-- Additional Benefits -->
                    <div class="bg-gradient-to-r from-primaryGreen/10 to-primaryBlue/10 rounded-2xl p-6 border border-primaryGreen/20">
                        <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-4 flex items-center">
                            <i class="fas fa-trophy text-primaryGreen mr-3"></i>
                            Proven Results
                        </h3>
                        <div class="grid grid-cols-2 gap-4">
                            <div class="text-center">
                                <div class="text-2xl font-bold text-primaryGreen">95%</div>
                                <div class="text-sm text-gray-600 dark:text-gray-400">Success Rate</div>
                            </div>
                            <div class="text-center">
                                <div class="text-2xl font-bold text-primaryBlue">40%</div>
                                <div class="text-sm text-gray-600 dark:text-gray-400">Performance Boost</div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-16 bg-gradient-to-br from-primaryBlue via-indigo-600 to-purple-600 text-white relative overflow-hidden">
        <div class="absolute inset-0 bg-black/10"></div>
        <div class="absolute inset-0 bg-grid-pattern opacity-5"></div>
        <div class="relative max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <div class="mb-12">
                <div class="inline-flex items-center px-4 py-2 rounded-full bg-white/20 text-white text-sm font-medium mb-6 border border-white/30">
                    <i class="fas fa-star mr-2"></i>
                    Join the Revolution
                </div>
                <h2 class="text-4xl md:text-6xl font-bold mb-6 leading-tight">
                    Ready to Transform Your 
                    <span class="bg-gradient-to-r from-yellow-300 to-orange-300 bg-clip-text text-transparent">Learning Journey?</span>
            </h2>
                <p class="text-xl md:text-2xl text-blue-100 mb-10 leading-relaxed max-w-4xl mx-auto">
                    Join over 2,500 students and 75+ institutions who trust Bikolpo Live for their educational success. 
                    <span class="text-yellow-300 font-semibold">Start your transformation today!</span>
                </p>
            </div>
            
            <div class="flex justify-center mb-10">
                <a href="{{ route('register') }}" class="group bg-white text-primaryBlue px-10 py-5 rounded-full font-bold text-lg hover:bg-gray-100 transition-all duration-300 transform hover:scale-105 shadow-xl hover:shadow-2xl">
                    <i class="fas fa-rocket mr-2 group-hover:translate-x-1 transition-transform duration-200"></i>
                    Start your partner journey
                </a>
            </div>
            
            <!-- Trust Indicators -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-10">
                <div class="bg-white/10 backdrop-blur-sm rounded-2xl p-6 border border-white/20">
                    <i class="fas fa-shield-alt text-3xl mb-3 text-yellow-300"></i>
                    <h4 class="font-bold mb-2">100% Secure</h4>
                    <p class="text-blue-100 text-sm">Bank-grade security for all your data</p>
                </div>
                <div class="bg-white/10 backdrop-blur-sm rounded-2xl p-6 border border-white/20">
                    <i class="fas fa-clock text-3xl mb-3 text-yellow-300"></i>
                    <h4 class="font-bold mb-2">Instant Results</h4>
                    <p class="text-blue-100 text-sm">Get immediate feedback and analytics</p>
                </div>
                <div class="bg-white/10 backdrop-blur-sm rounded-2xl p-6 border border-white/20">
                    <i class="fas fa-mobile-alt text-3xl mb-3 text-yellow-300"></i>
                    <h4 class="font-bold mb-2">Mobile Ready</h4>
                    <p class="text-blue-100 text-sm">Access from any device, anywhere</p>
                </div>
            </div>
            
            <div class="text-center">
                <p class="text-blue-100 text-lg mb-4">
                        Already have an account? 
                    <a href="{{ route('login') }}" class="text-yellow-300 hover:text-yellow-200 underline font-semibold transition-colors duration-200">
                            Sign In here
                        </a>
                    </p>
                <p class="text-blue-200 text-sm">
                    No credit card required • Free forever plan available • 24/7 support
                    </p>
                </div>
        </div>
    </section>

    <!-- Testimonials Section -->
    <section class="py-12 bg-gray-50 dark:bg-gray-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <div class="inline-flex items-center px-4 py-2 rounded-full bg-primaryPurple/10 text-primaryPurple text-sm font-medium mb-6 border border-primaryPurple/20">
                    <i class="fas fa-quote-left mr-2"></i>
                    What Our Users Say
                </div>
                <h2 class="text-4xl md:text-5xl font-bold text-gray-900 dark:text-white mb-6">
                    Loved by Students & 
                    <span class="bg-gradient-to-r from-primaryPurple to-primaryBlue bg-clip-text text-transparent">Educators</span>
                </h2>
                <p class="text-xl text-gray-600 dark:text-gray-400 max-w-3xl mx-auto">
                    Don't just take our word for it - hear from our community of successful learners and educators
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <!-- Testimonial 1 -->
                <div class="bg-white dark:bg-gray-900 p-8 rounded-3xl shadow-lg hover:shadow-xl transition-all duration-300 border border-gray-200 dark:border-gray-700">
                    <div class="flex items-center mb-6">
                        <div class="w-12 h-12 bg-gradient-to-br from-primaryGreen to-green-600 rounded-full flex items-center justify-center text-white font-bold text-lg">
                            R
                        </div>
                        <div class="ml-4">
                            <h4 class="font-bold text-gray-900 dark:text-white">Rahman Ahmed</h4>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Student, Dhaka University</p>
                        </div>
                    </div>
                    <div class="flex text-yellow-400 mb-4">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                    </div>
                    <p class="text-gray-600 dark:text-gray-400 leading-relaxed">
                        "Bikolpo Live has completely transformed my exam preparation. The instant feedback and detailed analytics help me identify my weak areas and improve systematically."
                    </p>
                </div>

                <!-- Testimonial 2 -->
                <div class="bg-white dark:bg-gray-900 p-8 rounded-3xl shadow-lg hover:shadow-xl transition-all duration-300 border border-gray-200 dark:border-gray-700">
                    <div class="flex items-center mb-6">
                        <div class="w-12 h-12 bg-gradient-to-br from-primaryBlue to-blue-600 rounded-full flex items-center justify-center text-white font-bold text-lg">
                            F
                        </div>
                        <div class="ml-4">
                            <h4 class="font-bold text-gray-900 dark:text-white">Fatima Begum</h4>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Teacher, Chittagong College</p>
                        </div>
                    </div>
                    <div class="flex text-yellow-400 mb-4">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                    </div>
                    <p class="text-gray-600 dark:text-gray-400 leading-relaxed">
                        "As an educator, I love how easy it is to create and manage exams. The platform saves me hours of work and provides valuable insights into student performance."
                    </p>
                </div>

                <!-- Testimonial 3 -->
                <div class="bg-white dark:bg-gray-900 p-8 rounded-3xl shadow-lg hover:shadow-xl transition-all duration-300 border border-gray-200 dark:border-gray-700">
                    <div class="flex items-center mb-6">
                        <div class="w-12 h-12 bg-gradient-to-br from-primaryOrange to-orange-600 rounded-full flex items-center justify-center text-white font-bold text-lg">
                            K
                        </div>
                        <div class="ml-4">
                            <h4 class="font-bold text-gray-900 dark:text-white">Karim Hassan</h4>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Student, BUET</p>
                        </div>
                    </div>
                    <div class="flex text-yellow-400 mb-4">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                    </div>
                    <p class="text-gray-600 dark:text-gray-400 leading-relaxed">
                        "The comprehensive question bank is incredible! I've improved my exam performance by 40% in just 2 months. The detailed explanations make learning so much more effective."
                    </p>
                </div>

                <!-- Testimonial 4 -->
                <div class="bg-white dark:bg-gray-900 p-8 rounded-3xl shadow-lg hover:shadow-xl transition-all duration-300 border border-gray-200 dark:border-gray-700">
                    <div class="flex items-center mb-6">
                        <div class="w-12 h-12 bg-gradient-to-br from-primaryPurple to-purple-600 rounded-full flex items-center justify-center text-white font-bold text-lg">
                            S
                        </div>
                        <div class="ml-4">
                            <h4 class="font-bold text-gray-900 dark:text-white">Sultana Akter</h4>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Principal, Rangpur School</p>
                        </div>
                    </div>
                    <div class="flex text-yellow-400 mb-4">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                    </div>
                    <p class="text-gray-600 dark:text-gray-400 leading-relaxed">
                        "Our school has been using Bikolpo Live for over a year. The results speak for themselves - our students' performance has improved significantly."
                    </p>
                </div>

                <!-- Testimonial 5 -->
                <div class="bg-white dark:bg-gray-900 p-8 rounded-3xl shadow-lg hover:shadow-xl transition-all duration-300 border border-gray-200 dark:border-gray-700">
                    <div class="flex items-center mb-6">
                        <div class="w-12 h-12 bg-gradient-to-br from-emerald-500 to-emerald-600 rounded-full flex items-center justify-center text-white font-bold text-lg">
                            M
                        </div>
                        <div class="ml-4">
                            <h4 class="font-bold text-gray-900 dark:text-white">Mohammad Ali</h4>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Student, Rajshahi University</p>
                        </div>
                    </div>
                    <div class="flex text-yellow-400 mb-4">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                    </div>
                    <p class="text-gray-600 dark:text-gray-400 leading-relaxed">
                        "The mobile app is fantastic! I can practice anywhere, anytime. The offline mode is a game-changer for my daily commute."
                    </p>
                </div>

                <!-- Testimonial 6 -->
                <div class="bg-white dark:bg-gray-900 p-8 rounded-3xl shadow-lg hover:shadow-xl transition-all duration-300 border border-gray-200 dark:border-gray-700">
                    <div class="flex items-center mb-6">
                        <div class="w-12 h-12 bg-gradient-to-br from-rose-500 to-rose-600 rounded-full flex items-center justify-center text-white font-bold text-lg">
                            N
                        </div>
                        <div class="ml-4">
                            <h4 class="font-bold text-gray-900 dark:text-white">Nusrat Jahan</h4>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Coaching Center Owner</p>
                        </div>
                    </div>
                    <div class="flex text-yellow-400 mb-4">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                    </div>
                    <p class="text-gray-600 dark:text-gray-400 leading-relaxed">
                        "The partner management features are excellent. I can easily track all my students' progress and generate detailed reports for parents."
                    </p>
                </div>
            </div>
        </div>
    </section>

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

        // Enhanced Counter Animation for decimal values
        const animateDecimalCounters = () => {
            const decimalCounters = document.querySelectorAll('.counter[data-target="9"]');
            decimalCounters.forEach(counter => {
                const target = 9;
                const count = +counter.innerText;
                const increment = target / speed;

                if (count < target) {
                    counter.innerText = Math.ceil(count + increment);
                    setTimeout(() => animateDecimalCounters(), 1);
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
                    animateDecimalCounters();
                    observer.unobserve(entry.target);
                }
            });
        }, observerOptions);

        const statsSection = document.querySelector('.bg-gradient-to-br.from-primaryGreen');
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
        
        .animation-delay-2000 {
            animation-delay: 2s;
        }
        
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        @keyframes slideUp {
            from { opacity: 0; transform: translateY(40px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-10px); }
        }
        
        .animate-float {
            animation: float 3s ease-in-out infinite;
        }
        
        /* Brand Name Special Effects */
        .brand-name {
            position: relative;
        }
        
        .brand-name::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(45deg, transparent 30%, rgba(255, 255, 255, 0.1) 50%, transparent 70%);
            animation: shimmer 3s ease-in-out infinite;
            pointer-events: none;
        }
        
        @keyframes shimmer {
            0% { transform: translateX(-100%); }
            100% { transform: translateX(100%); }
        }
        
        /* Enhanced gradient text */
        .brand-gradient {
            background: linear-gradient(135deg, #059669 0%, #2563eb 30%, #7c3aed 70%, #dc2626 100%);
            background-size: 200% 200%;
            animation: gradientShift 4s ease infinite;
            -webkit-background-clip: text;
            background-clip: text;
            -webkit-text-fill-color: transparent;
            color: #16a34a; /* Fallback color */
        }
        
        @keyframes gradientShift {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }
        
        /* Alternative gradient for better visibility */
        .brand-gradient-alt {
            background: linear-gradient(135deg, #16a34a 0%, #3b82f6 50%, #8b5cf6 100%);
            -webkit-background-clip: text;
            background-clip: text;
            -webkit-text-fill-color: transparent;
            color: #16a34a; /* Fallback color */
            text-shadow: 0 0 30px rgba(22, 163, 74, 0.5);
        }
        
        /* High contrast version */
        .brand-gradient-contrast {
            background: linear-gradient(135deg, #047857 0%, #1d4ed8 50%, #6d28d9 100%);
            -webkit-background-clip: text;
            background-clip: text;
            -webkit-text-fill-color: transparent;
            color: #047857; /* Fallback color */
            filter: contrast(1.2) brightness(1.1);
        }
        
        /* Simple solid color fallback */
        .brand-solid {
            color: #16a34a;
            text-shadow: 0 0 20px rgba(22, 163, 74, 0.3);
        }
        
        /* Ensure visibility on all backgrounds */
        .brand-visible {
            background: linear-gradient(135deg, #047857 0%, #1d4ed8 50%, #6d28d9 100%);
            -webkit-background-clip: text;
            background-clip: text;
            -webkit-text-fill-color: transparent;
            color: #047857;
        }
    </style>
</body>
</html>
