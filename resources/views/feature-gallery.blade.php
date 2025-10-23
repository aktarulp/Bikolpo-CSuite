<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Feature Gallery - Bikolpo Live</title>
    
    <!-- Favicon -->
    <link rel="icon" type="image/svg+xml" href="{{ asset('images/BikolpoLive.svg') }}">
    <link rel="shortcut icon" type="image/svg+xml" href="{{ asset('images/BikolpoLive.svg') }}">
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script>
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
                        'pulse-slow': 'pulse 3s infinite',
                        'float': 'float 6s ease-in-out infinite',
                        'glow': 'glow 2s ease-in-out infinite alternate'
                    }
                }
            }
        }
    </script>

</head>

<body class="bg-gradient-to-br from-gray-50 to-gray-100 dark:from-gray-900 dark:to-gray-800 text-gray-800 dark:text-gray-100 font-sans">
    
    @include('navigation-layout')

    <!-- Hero Section -->
    <section class="relative overflow-hidden bg-gradient-to-br from-white via-purple-50 to-indigo-100 dark:from-gray-900 dark:via-gray-800 dark:to-gray-900 py-12 lg:py-16">
        <div class="absolute inset-0 bg-grid-pattern opacity-5"></div>
        <div class="absolute inset-0 bg-gradient-to-r from-primaryPurple/5 via-transparent to-primaryBlue/5"></div>
        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <div class="animate-fade-in">
                <div class="inline-flex items-center px-6 py-3 rounded-full bg-primaryPurple/10 border border-primaryPurple/20 mb-8">
                    <svg class="w-5 h-5 text-primaryPurple mr-3" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z" clip-rule="evenodd"></path>
                    </svg>
                    <span class="text-sm font-medium text-primaryPurple">Feature Gallery</span>
                </div>
                
                <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold mb-6 bg-gradient-to-r from-gray-900 via-primaryPurple to-primaryBlue dark:from-white dark:via-primaryPurple dark:to-primaryBlue bg-clip-text text-transparent">
                    Visual Showcase
                </h1>
                <p class="text-xl text-gray-600 dark:text-gray-400 max-w-4xl mx-auto leading-relaxed">
                    Explore our platform's features through stunning visuals and interactive demonstrations.
                </p>
            </div>
        </div>
    </section>

    <!-- Slideshow Gallery Section -->
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
        
        <!-- Slideshow Container -->
        <div class="relative bg-white dark:bg-gray-800 rounded-3xl shadow-2xl overflow-hidden border border-gray-200 dark:border-gray-700">
            
            <!-- Main Slideshow Display -->
            <div class="relative h-[70vh] min-h-[500px] overflow-hidden bg-gray-100 dark:bg-gray-700">
                <!-- Debug: Slideshow Container -->
                <div class="absolute top-4 left-4 z-50 bg-red-500 text-white px-2 py-1 text-xs rounded">
                    Slideshow Active
                </div>
                <!-- Slides -->
                <div id="slideshow-container" class="relative w-full h-full">
                    
                    <!-- Slide 1: Course Grid -->
                    <div class="slide absolute inset-0 transition-all duration-1000 ease-in-out opacity-100 bg-gradient-to-br from-purple-100 to-blue-100 dark:from-purple-900 dark:to-blue-900" data-slide="0">
                        <div class="flex flex-col md:flex-row h-full">
                            <!-- Image Section -->
                            <div class="w-full md:w-1/2 h-1/2 md:h-full relative overflow-hidden bg-gradient-to-br from-primaryPurple/20 to-primaryBlue/20">
                                <img src="/images/FeatureGallery/Course Grid.png" 
                                     alt="Course Grid Feature" 
                                     class="w-full h-full object-cover"
                                     onerror="this.style.display='none'; this.nextElementSibling.style.display='block';">
                                <div class="w-full h-full bg-gradient-to-br from-primaryPurple/20 to-primaryBlue/20 flex items-center justify-center" style="display:none;">
                                    <div class="text-center">
                                        <svg class="w-16 h-16 text-primaryPurple mx-auto mb-4" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z" clip-rule="evenodd"></path>
                                        </svg>
                                        <p class="text-primaryPurple font-medium">Course Grid Feature</p>
                                    </div>
                                </div>
                                <div class="absolute inset-0 bg-gradient-to-r from-transparent via-transparent to-black/20"></div>
                            </div>
                            
                            <!-- Content Section -->
                            <div class="w-full md:w-1/2 h-1/2 md:h-full flex flex-col justify-center p-4 sm:p-6 md:p-8 lg:p-12">
                                <!-- Debug: Content Visible -->
                                <div class="bg-yellow-200 text-black px-2 py-1 text-xs rounded mb-4">
                                    Content Section Active
                                </div>
                                <div class="flex items-center mb-6">
                                    <div class="w-12 h-12 bg-gradient-to-br from-primaryPurple to-purple-600 rounded-xl flex items-center justify-center mr-4">
                                        <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                    </div>
                                    <h2 class="text-2xl sm:text-3xl lg:text-4xl font-bold text-gray-900 dark:text-white">Course Grid</h2>
                                </div>
                                
                                <p class="text-base sm:text-lg text-gray-600 dark:text-gray-400 leading-relaxed mb-6">
                                    Organized course layout with intuitive navigation and visual course cards for easy browsing and selection. 
                                    Students can quickly find and enroll in courses with our modern grid-based interface.
                                </p>
                                
                                <div class="flex flex-wrap gap-3 mb-8">
                                    <span class="px-4 py-2 bg-primaryPurple/10 text-primaryPurple text-sm font-medium rounded-full">Grid Layout</span>
                                    <span class="px-4 py-2 bg-blue-500/10 text-blue-500 text-sm font-medium rounded-full">Navigation</span>
                                    <span class="px-4 py-2 bg-green-500/10 text-green-500 text-sm font-medium rounded-full">User-Friendly</span>
                                </div>
                                
                                <div class="flex items-center text-sm text-gray-500 dark:text-gray-400">
                                    <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                    </svg>
                                    Feature 1 of 3
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Slide 2: Enrollment -->
                    <div class="slide absolute inset-0 transition-all duration-1000 ease-in-out opacity-0" data-slide="1">
                        <div class="flex flex-col md:flex-row h-full">
                            <!-- Image Section -->
                            <div class="w-full md:w-1/2 h-1/2 md:h-full relative overflow-hidden">
                                <img src="/images/FeatureGallery/Enrollment.png" 
                                     alt="Enrollment Feature" 
                                     class="w-full h-full object-cover"
                                     onerror="this.style.display='none'; this.nextElementSibling.style.display='block';">
                                <div class="w-full h-full bg-gradient-to-br from-primaryGreen/20 to-green-600/20 flex items-center justify-center" style="display:none;">
                                    <div class="text-center">
                                        <svg class="w-16 h-16 text-primaryGreen mx-auto mb-4" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                        </svg>
                                        <p class="text-primaryGreen font-medium">Enrollment Feature</p>
                                    </div>
                                </div>
                                <div class="absolute inset-0 bg-gradient-to-r from-transparent via-transparent to-black/20"></div>
                            </div>
                            
                            <!-- Content Section -->
                            <div class="w-full md:w-1/2 h-1/2 md:h-full flex flex-col justify-center p-4 sm:p-6 md:p-8 lg:p-12">
                                <div class="flex items-center mb-6">
                                    <div class="w-12 h-12 bg-gradient-to-br from-primaryGreen to-green-600 rounded-xl flex items-center justify-center mr-4">
                                        <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                        </svg>
                                    </div>
                                    <h2 class="text-2xl sm:text-3xl lg:text-4xl font-bold text-gray-900 dark:text-white">Enrollment</h2>
                                </div>
                                
                                <p class="text-base sm:text-lg text-gray-600 dark:text-gray-400 leading-relaxed mb-6">
                                    Streamlined enrollment process with step-by-step guidance and real-time validation for seamless student registration. 
                                    Our intuitive system makes course enrollment quick and hassle-free.
                                </p>
                                
                                <div class="flex flex-wrap gap-3 mb-8">
                                    <span class="px-4 py-2 bg-primaryGreen/10 text-primaryGreen text-sm font-medium rounded-full">Registration</span>
                                    <span class="px-4 py-2 bg-orange-500/10 text-orange-500 text-sm font-medium rounded-full">Validation</span>
                                    <span class="px-4 py-2 bg-blue-500/10 text-blue-500 text-sm font-medium rounded-full">Step-by-Step</span>
                                </div>
                                
                                <div class="flex items-center text-sm text-gray-500 dark:text-gray-400">
                                    <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                    </svg>
                                    Feature 2 of 3
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Slide 3: Partner Dashboard -->
                    <div class="slide absolute inset-0 transition-all duration-1000 ease-in-out opacity-0" data-slide="2">
                        <div class="flex flex-col md:flex-row h-full">
                            <!-- Image Section -->
                            <div class="w-full md:w-1/2 h-1/2 md:h-full relative overflow-hidden">
                                <img src="/images/FeatureGallery/Partner Dashboard.png" 
                                     alt="Partner Dashboard Feature" 
                                     class="w-full h-full object-cover"
                                     onerror="this.style.display='none'; this.nextElementSibling.style.display='block';">
                                <div class="w-full h-full bg-gradient-to-br from-primaryBlue/20 to-blue-600/20 flex items-center justify-center" style="display:none;">
                                    <div class="text-center">
                                        <svg class="w-16 h-16 text-primaryBlue mx-auto mb-4" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M2 11a1 1 0 011-1h2a1 1 0 011 1v5a1 1 0 01-2 0v-5zM8 7a1 1 0 011-1h2a1 1 0 011 1v9a1 1 0 01-2 0V7zM14 4a1 1 0 011-1h2a1 1 0 011 1v12a1 1 0 01-2 0V4z"></path>
                                        </svg>
                                        <p class="text-primaryBlue font-medium">Partner Dashboard Feature</p>
                                    </div>
                                </div>
                                <div class="absolute inset-0 bg-gradient-to-r from-transparent via-transparent to-black/20"></div>
                            </div>
                            
                            <!-- Content Section -->
                            <div class="w-full md:w-1/2 h-1/2 md:h-full flex flex-col justify-center p-4 sm:p-6 md:p-8 lg:p-12">
                                <div class="flex items-center mb-6">
                                    <div class="w-12 h-12 bg-gradient-to-br from-primaryBlue to-blue-600 rounded-xl flex items-center justify-center mr-4">
                                        <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M2 11a1 1 0 011-1h2a1 1 0 011 1v5a1 1 0 01-2 0v-5zM8 7a1 1 0 011-1h2a1 1 0 011 1v9a1 1 0 01-2 0V7zM14 4a1 1 0 011-1h2a1 1 0 011 1v12a1 1 0 01-2 0V4z"></path>
                                        </svg>
                                    </div>
                                    <h2 class="text-2xl sm:text-3xl lg:text-4xl font-bold text-gray-900 dark:text-white">Partner Dashboard</h2>
                                </div>
                                
                                <p class="text-base sm:text-lg text-gray-600 dark:text-gray-400 leading-relaxed mb-6">
                                    Comprehensive analytics dashboard with real-time insights, performance metrics, and management tools for educational partners. 
                                    Track progress and manage your educational programs effectively.
                                </p>
                                
                                <div class="flex flex-wrap gap-3 mb-8">
                                    <span class="px-4 py-2 bg-primaryBlue/10 text-primaryBlue text-sm font-medium rounded-full">Analytics</span>
                                    <span class="px-4 py-2 bg-purple-500/10 text-purple-500 text-sm font-medium rounded-full">Management</span>
                                    <span class="px-4 py-2 bg-orange-500/10 text-orange-500 text-sm font-medium rounded-full">Real-time</span>
                                </div>
                                
                                <div class="flex items-center text-sm text-gray-500 dark:text-gray-400">
                                    <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                    </svg>
                                    Feature 3 of 3
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Navigation Arrows -->
                <button id="prev-slide" class="absolute left-2 md:left-4 top-1/2 transform -translate-y-1/2 w-10 h-10 md:w-12 md:h-12 bg-white/90 dark:bg-gray-800/90 backdrop-blur-sm rounded-full flex items-center justify-center shadow-lg hover:bg-white dark:hover:bg-gray-700 transition-all duration-300 group">
                    <svg class="w-5 h-5 md:w-6 md:h-6 text-gray-700 dark:text-gray-300 group-hover:text-primaryPurple transition-colors duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                    </svg>
                </button>
                
                <button id="next-slide" class="absolute right-2 md:right-4 top-1/2 transform -translate-y-1/2 w-10 h-10 md:w-12 md:h-12 bg-white/90 dark:bg-gray-800/90 backdrop-blur-sm rounded-full flex items-center justify-center shadow-lg hover:bg-white dark:hover:bg-gray-700 transition-all duration-300 group">
                    <svg class="w-5 h-5 md:w-6 md:h-6 text-gray-700 dark:text-gray-300 group-hover:text-primaryPurple transition-colors duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </button>
            </div>

            <!-- Slide Indicators -->
            <div class="absolute bottom-6 left-1/2 transform -translate-x-1/2 flex space-x-3">
                <button class="slide-indicator w-3 h-3 rounded-full bg-primaryPurple transition-all duration-300" data-slide="0"></button>
                <button class="slide-indicator w-3 h-3 rounded-full bg-gray-300 dark:bg-gray-600 hover:bg-primaryPurple/50 transition-all duration-300" data-slide="1"></button>
                <button class="slide-indicator w-3 h-3 rounded-full bg-gray-300 dark:bg-gray-600 hover:bg-primaryPurple/50 transition-all duration-300" data-slide="2"></button>
            </div>

            <!-- Auto-play Controls -->
            <div class="absolute top-4 right-4 md:top-6 md:right-6 flex items-center space-x-3">
                <button id="autoplay-toggle" class="w-8 h-8 md:w-10 md:h-10 bg-white/90 dark:bg-gray-800/90 backdrop-blur-sm rounded-full flex items-center justify-center shadow-lg hover:bg-white dark:hover:bg-gray-700 transition-all duration-300 group">
                    <svg id="play-icon" class="w-4 h-4 md:w-5 md:h-5 text-gray-700 dark:text-gray-300 group-hover:text-primaryPurple transition-colors duration-300" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM9.555 7.168A1 1 0 008 8v4a1 1 0 001.555.832l3-2a1 1 0 000-1.664l-3-2z" clip-rule="evenodd"></path>
                    </svg>
                    <svg id="pause-icon" class="w-4 h-4 md:w-5 md:h-5 text-gray-700 dark:text-gray-300 group-hover:text-primaryPurple transition-colors duration-300 hidden" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zM7 8a1 1 0 00-1 1v2a1 1 0 102 0V9a1 1 0 00-1-1zm4 0a1 1 0 00-1 1v2a1 1 0 102 0V9a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                    </svg>
                </button>
            </div>
        </div>

        <!-- Gallery Stats -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-16">
            <div class="bg-white dark:bg-gray-800 rounded-2xl p-6 shadow-lg border border-gray-200 dark:border-gray-700 text-center">
                <div class="w-12 h-12 bg-gradient-to-br from-primaryPurple to-purple-600 rounded-xl flex items-center justify-center mx-auto mb-4">
                    <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z" clip-rule="evenodd"></path>
                    </svg>
                </div>
                <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-2">3+</h3>
                <p class="text-gray-600 dark:text-gray-400">Feature Screenshots</p>
            </div>
            
            <div class="bg-white dark:bg-gray-800 rounded-2xl p-6 shadow-lg border border-gray-200 dark:border-gray-700 text-center">
                <div class="w-12 h-12 bg-gradient-to-br from-primaryGreen to-green-600 rounded-xl flex items-center justify-center mx-auto mb-4">
                    <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-2">100%</h3>
                <p class="text-gray-600 dark:text-gray-400">Mobile Optimized</p>
            </div>
            
            <div class="bg-white dark:bg-gray-800 rounded-2xl p-6 shadow-lg border border-gray-200 dark:border-gray-700 text-center">
                <div class="w-12 h-12 bg-gradient-to-br from-primaryBlue to-blue-600 rounded-xl flex items-center justify-center mx-auto mb-4">
                    <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" d="M3 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z" clip-rule="evenodd"></path>
                    </svg>
                </div>
                <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-2">HD</h3>
                <p class="text-gray-600 dark:text-gray-400">High Quality Images</p>
            </div>
        </div>

        <!-- CTA Section -->
        <div class="mt-16 bg-gradient-to-r from-primaryPurple to-purple-600 rounded-3xl p-8 lg:p-12 text-white text-center relative overflow-hidden">
            <div class="absolute inset-0 bg-black/10"></div>
            <div class="relative">
                <h3 class="text-3xl md:text-4xl font-bold mb-6">Ready to Experience Our Platform?</h3>
                <p class="text-xl text-purple-100 mb-8 max-w-3xl mx-auto">
                    Join thousands of students and educators who are already using Bikolpo Live for their educational needs.
                </p>
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <a href="{{ route('public.quiz.access') }}" class="bg-white text-primaryPurple px-8 py-4 rounded-full font-bold text-lg hover:bg-gray-100 transition-colors duration-200 transform hover:scale-105 shadow-lg">
                        Try Live Demo
                    </a>
                    <a href="{{ route('contact') }}" class="border-2 border-white text-white px-8 py-4 rounded-full font-bold text-lg hover:bg-white hover:text-primaryPurple transition-all duration-200">
                        Get Started
                    </a>
                </div>
            </div>
        </div>
    </main>

    <!-- Footer -->
    <x-footer />

    <script>
        // Slideshow functionality
        class SlideshowGallery {
            constructor() {
                this.currentSlide = 0;
                this.totalSlides = 3;
                this.autoplayInterval = null;
                this.autoplayDelay = 5000; // 5 seconds
                this.isAutoplayActive = false;
                
                this.init();
            }
            
            init() {
                this.slides = document.querySelectorAll('.slide');
                this.indicators = document.querySelectorAll('.slide-indicator');
                this.prevBtn = document.getElementById('prev-slide');
                this.nextBtn = document.getElementById('next-slide');
                this.autoplayToggle = document.getElementById('autoplay-toggle');
                this.playIcon = document.getElementById('play-icon');
                this.pauseIcon = document.getElementById('pause-icon');
                
                this.bindEvents();
                this.startAutoplay();
            }
            
            bindEvents() {
                // Navigation buttons
                if (this.prevBtn) {
                    this.prevBtn.addEventListener('click', () => this.previousSlide());
                }
                
                if (this.nextBtn) {
                    this.nextBtn.addEventListener('click', () => this.nextSlide());
                }
                
                // Slide indicators
                this.indicators.forEach((indicator, index) => {
                    indicator.addEventListener('click', () => this.goToSlide(index));
                });
                
                // Autoplay toggle
                if (this.autoplayToggle) {
                    this.autoplayToggle.addEventListener('click', () => this.toggleAutoplay());
                }
                
                // Keyboard navigation
                document.addEventListener('keydown', (e) => {
                    if (e.key === 'ArrowLeft') this.previousSlide();
                    if (e.key === 'ArrowRight') this.nextSlide();
                    if (e.key === ' ') {
                        e.preventDefault();
                        this.toggleAutoplay();
                    }
                });
                
                // Touch/swipe support
                this.addTouchSupport();
                
                // Pause autoplay on hover
                const slideshowContainer = document.getElementById('slideshow-container');
                if (slideshowContainer) {
                    slideshowContainer.addEventListener('mouseenter', () => this.pauseAutoplay());
                    slideshowContainer.addEventListener('mouseleave', () => {
                        if (this.isAutoplayActive) this.startAutoplay();
                    });
                }
            }
            
            addTouchSupport() {
                const container = document.getElementById('slideshow-container');
                if (!container) return;
                
                let startX = 0;
                let startY = 0;
                let endX = 0;
                let endY = 0;
                
                container.addEventListener('touchstart', (e) => {
                    startX = e.touches[0].clientX;
                    startY = e.touches[0].clientY;
                });
                
                container.addEventListener('touchend', (e) => {
                    endX = e.changedTouches[0].clientX;
                    endY = e.changedTouches[0].clientY;
                    
                    const diffX = startX - endX;
                    const diffY = startY - endY;
                    
                    // Only trigger if horizontal swipe is more significant than vertical
                    if (Math.abs(diffX) > Math.abs(diffY) && Math.abs(diffX) > 50) {
                        if (diffX > 0) {
                            this.nextSlide();
                        } else {
                            this.previousSlide();
                        }
                    }
                });
            }
            
            showSlide(index) {
                // Hide all slides
                this.slides.forEach((slide, i) => {
                    slide.style.opacity = i === index ? '1' : '0';
                    slide.style.zIndex = i === index ? '10' : '1';
                });
                
                // Update indicators
                this.indicators.forEach((indicator, i) => {
                    if (i === index) {
                        indicator.classList.remove('bg-gray-300', 'dark:bg-gray-600');
                        indicator.classList.add('bg-primaryPurple');
                    } else {
                        indicator.classList.remove('bg-primaryPurple');
                        indicator.classList.add('bg-gray-300', 'dark:bg-gray-600');
                    }
                });
                
                this.currentSlide = index;
            }
            
            nextSlide() {
                const nextIndex = (this.currentSlide + 1) % this.totalSlides;
                this.showSlide(nextIndex);
            }
            
            previousSlide() {
                const prevIndex = (this.currentSlide - 1 + this.totalSlides) % this.totalSlides;
                this.showSlide(prevIndex);
            }
            
            goToSlide(index) {
                this.showSlide(index);
            }
            
            startAutoplay() {
                this.pauseAutoplay();
                this.autoplayInterval = setInterval(() => {
                    this.nextSlide();
                }, this.autoplayDelay);
                this.isAutoplayActive = true;
                this.updateAutoplayIcon();
            }
            
            pauseAutoplay() {
                if (this.autoplayInterval) {
                    clearInterval(this.autoplayInterval);
                    this.autoplayInterval = null;
                }
                this.isAutoplayActive = false;
                this.updateAutoplayIcon();
            }
            
            toggleAutoplay() {
                if (this.isAutoplayActive) {
                    this.pauseAutoplay();
                } else {
                    this.startAutoplay();
                }
            }
            
            updateAutoplayIcon() {
                if (this.playIcon && this.pauseIcon) {
                    if (this.isAutoplayActive) {
                        this.playIcon.classList.add('hidden');
                        this.pauseIcon.classList.remove('hidden');
                    } else {
                        this.playIcon.classList.remove('hidden');
                        this.pauseIcon.classList.add('hidden');
                    }
                }
            }
        }
        
        // Initialize slideshow when DOM is loaded
        document.addEventListener('DOMContentLoaded', () => {
            new SlideshowGallery();
        });

        // Dark Mode Toggle
        const darkToggle = document.getElementById('darkToggle');
        const html = document.documentElement;
        
        // Check for saved theme preference
        if (localStorage.getItem('theme') === 'dark' || (!localStorage.getItem('theme') && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            html.classList.add('dark');
        }
        
        if (darkToggle) {
            darkToggle.addEventListener('click', () => {
                html.classList.toggle('dark');
                localStorage.setItem('theme', html.classList.contains('dark') ? 'dark' : 'light');
            });
        }

        // Mobile Menu Toggle
        const mobileMenuBtn = document.getElementById('mobileMenuBtn');
        const mobileMenu = document.getElementById('mobileMenu');
        
        if (mobileMenuBtn && mobileMenu) {
            mobileMenuBtn.addEventListener('click', () => {
                mobileMenu.classList.toggle('hidden');
            });
        }

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

        // Image lazy loading and intersection observer
        const images = document.querySelectorAll('img');
        const imageObserver = new IntersectionObserver((entries, observer) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const img = entry.target;
                    img.style.opacity = '0';
                    img.style.transform = 'scale(1.1)';
                    
                    setTimeout(() => {
                        img.style.transition = 'all 0.6s ease-out';
                        img.style.opacity = '1';
                        img.style.transform = 'scale(1)';
                    }, 100);
                    
                    observer.unobserve(img);
                }
            });
        });

        images.forEach(img => {
            imageObserver.observe(img);
        });

        // Parallax effect for hero section
        window.addEventListener('scroll', () => {
            const scrolled = window.pageYOffset;
            const parallax = document.querySelector('.bg-grid-pattern');
            if (parallax) {
                const speed = scrolled * 0.5;
                parallax.style.transform = `translateY(${speed}px)`;
            }
        });
    </script>

</body>
</html>
