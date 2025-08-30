<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }}</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+Bengali:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <!-- Custom Styles -->
    <style>
        .font-bengali {
            font-family: 'Noto Sans Bengali', 'Noto Sans', 'Arial Unicode MS', sans-serif;
        }
        
        .bg-gradient-to-r {
            background: linear-gradient(135deg, #10b981 0%, #059669 50%, #2563eb 100%);
        }
        
        .bg-clip-text {
            -webkit-background-clip: text;
            background-clip: text;
        }
        
        .text-transparent {
            color: transparent;
        }
        
        /* Sticky top bar styles */
        .sticky-top-bar {
            position: sticky;
            top: 0;
            z-index: 30;
            background: white;
            border-bottom: 1px solid #e5e7eb;
            box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06);
            transition: margin-left 0.3s ease-in-out;
        }
        
        .dark .sticky-top-bar {
            background: #111827;
            border-bottom-color: #374151;
        }
        
        /* Ensure sidebar is always visible */
        .sidebar-container {
            position: fixed;
            top: 0;
            left: 0;
            height: 100vh;
            z-index: 50;
            transition: transform 0.3s ease-in-out;
        }
        
        /* Mobile hamburger button styles */
        @media (max-width: 1023px) {
            #sidebar-toggle {
                position: fixed;
                top: 1rem;
                left: 1rem;
                z-index: 60;
                background: white;
                border: 1px solid #e5e7eb;
                box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            }
            
            .dark #sidebar-toggle {
                background: #1f2937;
                border-color: #4b5563;
            }
        }
        
        /* Desktop: Completely hide sidebar toggle button */
        @media (min-width: 1024px) {
            #sidebar-toggle {
                display: none !important;
                visibility: hidden !important;
                opacity: 0 !important;
                pointer-events: none !important;
                position: absolute !important;
                left: -9999px !important;
                top: -9999px !important;
            }
        }
        
        /* Additional desktop hiding with higher specificity */
        .lg\:hidden {
            display: none !important;
        }
        
        /* Force hide on all desktop breakpoints */
        @media (min-width: 640px) and (min-width: 1024px) {
            #sidebar-toggle {
                display: none !important;
            }
        }
        

        
        /* Mobile sidebar styles */
        @media (max-width: 1023px) {
            .sidebar-container {
                transform: translateX(-100%);
                z-index: 50; /* Ensure sidebar is above top bar on mobile */
            }
            
            /* Ensure mobile hamburger button doesn't overlap content */
            .main-content-wrapper {
                padding-top: 4rem;
            }
            
            /* Ensure proper layering on mobile */
            .sticky-top-bar {
                position: relative; /* Change to relative on mobile for proper stacking */
            }
        }
        
        .main-content-wrapper {
            margin-left: 16rem; /* 256px for sidebar width */
            min-height: 100vh;
            transition: margin-left 0.3s ease-in-out, padding-top 0.3s ease-in-out;
        }
        

        
        @media (max-width: 1023px) {
            .main-content-wrapper {
                margin-left: 0;
            }
        }
    </style>
</head>
<body class="font-sans antialiased">
    <div class="min-h-screen bg-gray-100 flex">
        <!-- Left Sidebar - Always visible -->
        <div id="sidebar" class="sidebar-container w-64 bg-white dark:bg-gray-900 border-r border-gray-200 dark:border-gray-700">
            <div class="flex flex-col flex-grow pt-5 h-full overflow-y-auto">
                <!-- Logo Section -->
                <div class="flex flex-col items-center flex-shrink-0 px-6 mb-8">
                    <div class="w-12 h-12 bg-gradient-to-br from-primaryGreen to-emerald-500 rounded-xl flex items-center justify-center shadow-lg mb-4 transform hover:scale-110 transition-all duration-300">
                        <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                        </svg>
                    </div>
                    <div id="logo-text" class="text-center transition-all duration-300">
                        <h1 class="text-2xl font-extrabold bg-gradient-to-r from-primaryGreen via-emerald-600 to-blue-600 bg-clip-text text-transparent drop-shadow-sm hover:drop-shadow-md transition-all duration-300 font-bengali">বিকল্প পাঠশালা</h1>
                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-1 font-medium">Partner Portal</p>
                    </div>
                </div>
                


                <!-- Navigation Menu -->
                <nav class="flex-1 px-4">
                    <a href="{{ route('partner.dashboard') }}" 
                       class="group flex items-center px-3 py-3 text-sm font-medium rounded-lg transition-all duration-200 {{ request()->routeIs('partner.dashboard') ? 'bg-primaryGreen/10 text-primaryGreen border border-primaryGreen/20' : 'text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800 hover:text-gray-900 dark:hover:text-white' }}">
                        <svg class="h-5 w-5 {{ request()->routeIs('partner.dashboard') ? 'text-primaryGreen' : 'text-gray-400 group-hover:text-gray-500' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 01-2-2z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5a2 2 0 012-2h4a2 2 0 012 2v6H8V5z"></path>
                        </svg>
                        <span id="nav-dashboard" class="ml-3 transition-all duration-300">Dashboard</span>
                    </a>

                    <!-- Questions Menu -->
                    <a href="{{ route('partner.questions.all') }}" 
                       class="group flex items-center px-3 py-3 text-sm font-medium rounded-lg transition-all duration-200 {{ request()->routeIs('partner.questions.*') ? 'bg-primaryGreen/10 text-primaryGreen border border-primaryGreen/20' : 'text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800 hover:text-gray-900 dark:hover:text-white' }}">
                        <svg class="h-5 w-5 {{ request()->routeIs('partner.questions.*') ? 'text-primaryGreen' : 'text-gray-400 group-hover:text-gray-500' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <span id="nav-questions" class="ml-3 transition-all duration-300">Questions</span>
                    </a>

                    <!-- Questions Menu -->
                    <a href="{{ route('partner.exams.index') }}" 
                       class="group flex items-center px-3 py-3 text-sm font-medium rounded-lg transition-all duration-200 {{ request()->routeIs('partner.exams.*') ? 'bg-primaryGreen/10 text-primaryGreen border border-primaryGreen/20' : 'text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800 hover:text-gray-900 dark:hover:text-white' }}">
                        <svg class="h-5 w-5 {{ request()->routeIs('partner.exams.*') ? 'text-primaryGreen' : 'text-gray-400 group-hover:text-gray-500' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                        </svg>
                        <span id="nav-exams" class="ml-3 transition-all duration-300">Exams</span>
                    </a>



                    <a href="{{ route('partner.students.index') }}" 
                       class="group flex items-center px-3 py-3 text-sm font-medium rounded-lg transition-all duration-200 {{ request()->routeIs('partner.students.*') ? 'bg-primaryGreen/10 text-primaryGreen border border-primaryGreen/20' : 'text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800 hover:text-gray-900 dark:hover:text-white' }}">
                        <svg class="h-5 w-5 {{ request()->routeIs('partner.students.*') ? 'text-primaryGreen' : 'text-gray-400 group-hover:text-gray-500' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                        </svg>
                        <span id="nav-students" class="ml-3 transition-all duration-300">Students</span>
                    </a>

                    <a href="{{ route('partner.batches.index') }}" 
                       class="group flex items-center px-3 py-3 text-sm font-medium rounded-lg transition-all duration-200 {{ request()->routeIs('partner.batches.*') ? 'bg-primaryGreen/10 text-primaryGreen border border-primaryGreen/20' : 'text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800 hover:text-gray-900 dark:hover:text-white' }}">
                        <svg class="h-5 w-5 {{ request()->routeIs('partner.batches.*') ? 'text-primaryGreen' : 'text-gray-400 group-hover:text-gray-500' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                        </svg>
                        <span id="nav-batches" class="ml-3 transition-all duration-300">Batches</span>
                    </a>

                    <a href="{{ route('partner.courses.index') }}" 
                       class="group flex items-center px-3 py-3 text-sm font-medium rounded-lg transition-all duration-200 {{ request()->routeIs('partner.courses.*') ? 'bg-primaryGreen/10 text-primaryGreen border border-primaryGreen/20' : 'text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800 hover:text-gray-900 dark:hover:text-white' }}">
                        <svg class="h-5 w-5 {{ request()->routeIs('partner.courses.*') ? 'text-primaryGreen' : 'text-gray-400 group-hover:text-gray-500' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                        </svg>
                        <span id="nav-courses" class="ml-3 transition-all duration-300">Courses</span>
                    </a>

                    <a href="{{ route('partner.subjects.index') }}" 
                       class="group flex items-center px-3 py-3 text-sm font-medium rounded-lg transition-all duration-200 {{ request()->routeIs('partner.subjects.*') ? 'bg-primaryGreen/10 text-primaryGreen border border-primaryGreen/20' : 'text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800 hover:text-gray-900 dark:hover:text-white' }}">
                        <svg class="h-5 w-5 {{ request()->routeIs('partner.subjects.*') ? 'text-primaryGreen' : 'text-gray-400 group-hover:text-gray-500' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"></path>
                        </svg>
                        <span id="nav-subjects" class="ml-3 transition-all duration-300">Subjects</span>
                    </a>

                    <a href="{{ route('partner.topics.index') }}" 
                       class="group flex items-center px-3 py-3 text-sm font-medium rounded-lg transition-all duration-200 {{ request()->routeIs('partner.topics.*') ? 'bg-primaryGreen/10 text-primaryGreen border border-primaryGreen/20' : 'text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800 hover:text-gray-900 dark:hover:text-white' }}">
                        <svg class="h-5 w-5 {{ request()->routeIs('partner.topics.*') ? 'text-primaryGreen' : 'text-gray-400 group-hover:text-gray-500' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                        </svg>
                        <span id="nav-topics" class="ml-3 transition-all duration-300">Topics</span>
                    </a>

                    <a href="{{ route('partner.question-history.index') }}" 
                       class="group flex items-center px-3 py-3 text-sm font-medium rounded-lg transition-all duration-200 {{ request()->routeIs('partner.question-history.*') ? 'bg-primaryGreen/10 text-primaryGreen border border-primaryGreen/20' : 'text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800 hover:text-gray-900 dark:hover:text-white' }}">
                        <svg class="h-5 w-5 {{ request()->routeIs('partner.question-history.*') ? 'text-primaryGreen' : 'text-gray-400 group-hover:text-gray-500' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <span id="nav-question-history" class="ml-3 transition-all duration-300">Question History</span>
                    </a>

                    <a href="{{ route('partner.partners.index') }}" 
                       class="group flex items-center px-3 py-3 text-sm font-medium rounded-lg transition-all duration-200 {{ request()->routeIs('partner.partners.*') ? 'bg-primaryGreen/10 text-primaryGreen border border-primaryGreen/20' : 'text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800 hover:text-gray-900 dark:hover:text-white' }}">
                        <svg class="h-5 w-5 {{ request()->routeIs('partner.partners.*') ? 'text-primaryGreen' : 'text-gray-400 group-hover:text-gray-500' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                        <span id="nav-partners" class="ml-3 transition-all duration-300">Partners</span>
                    </a>


                </nav>

                <!-- Bottom Section -->
                <div class="flex-shrink-0 p-4 border-t border-gray-200 dark:border-gray-700">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="w-8 h-8 bg-gradient-to-br from-primaryGreen to-emerald-500 rounded-full flex items-center justify-center">
                                <span class="text-sm font-bold text-white">{{ substr(Auth::user()->name ?? 'P', 0, 1) }}</span>
                            </div>
                        </div>
                        <div id="user-info" class="ml-3 min-w-0 flex-1 transition-all duration-300">
                            <p class="text-sm font-medium text-gray-900 dark:text-white truncate">{{ Auth::user()->name ?? 'Partner' }}</p>
                            <p class="text-xs text-gray-500 dark:text-gray-400 truncate">{{ Auth::user()->email ?? 'partner@example.com' }}</p>
                        </div>
                        <div id="logout-button" class="ml-auto flex-shrink-0 transition-all duration-300">
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="text-gray-400 hover:text-gray-500 dark:hover:text-gray-300 transition-colors duration-200">
                                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                                    </svg>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Mobile Sidebar Backdrop -->
        <div id="sidebar-backdrop" class="fixed inset-0 bg-black bg-opacity-50 z-45 lg:hidden hidden"></div>

        <!-- Main Content Area -->
        <div class="main-content-wrapper flex-1 flex flex-col">
            <!-- Mobile Hamburger Menu Button - Positioned outside top bar -->
            <div class="lg:hidden fixed top-4 left-4 z-50">
                <button id="sidebar-toggle" class="p-3 bg-white dark:bg-gray-800 text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white hover:bg-gray-100 dark:hover:bg-gray-700 rounded-lg shadow-lg border border-gray-200 dark:border-gray-600 transition-all duration-200">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                </button>
            </div>
            
            <!-- Sticky Top Bar -->
            <div class="sticky-top-bar">
                <div class="px-8 py-6">
                    <div class="flex items-center justify-between">
                        <!-- Left Side: Welcome & Stats -->
                        <div class="flex items-center space-x-8">
                            <!-- Welcome Section -->
                            <div class="flex items-center space-x-4">
                                <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-lg flex items-center justify-center shadow-sm">
                                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <h2 class="text-2xl font-semibold text-gray-900 dark:text-white">
                                        Welcome back, <span class="text-blue-600 dark:text-blue-400">{{ $partner?->slug ?? $partner?->name ?? Auth::user()->name ?? 'Partner' }}</span>
                                    </h2>
                                    <p class="text-gray-600 dark:text-gray-400 text-sm">Manage your exam system efficiently</p>
                                </div>
                            </div>
                            
                            <!-- Divider -->
                            <div class="w-px h-12 bg-gray-300 dark:bg-gray-600"></div>
                            
                            <!-- Quick Stats -->
                            <div class="flex items-center space-x-6">
                                <div class="text-center">
                                    <div class="flex items-center space-x-2">
                                        <div class="w-8 h-8 bg-emerald-100 dark:bg-emerald-900/30 rounded-lg flex items-center justify-center">
                                            <svg class="w-4 h-4 text-emerald-600 dark:text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                        </div>
                                        <div class="text-left">
                                            <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $stats['total_questions'] ?? 0 }}</p>
                                            <p class="text-xs text-gray-500 dark:text-gray-400">Questions</p>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="text-center">
                                    <div class="flex items-center space-x-2">
                                        <div class="w-8 h-8 bg-blue-100 dark:bg-blue-900/30 rounded-lg flex items-center justify-center">
                                            <svg class="w-4 h-4 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                                            </svg>
                                        </div>
                                        <div class="text-left">
                                            <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $stats['total_exams'] ?? 0 }}</p>
                                            <p class="text-xs text-gray-500 dark:text-gray-400">Exams</p>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="text-center">
                                    <div class="flex items-center space-x-2">
                                        <div class="w-8 h-8 bg-purple-100 dark:bg-purple-900/30 rounded-lg flex items-center justify-center">
                                            <svg class="w-4 h-4 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                                            </svg>
                                        </div>
                                        <div class="text-left">
                                            <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $stats['total_students'] ?? 0 }}</p>
                                            <p class="text-xs text-gray-500 dark:text-gray-400">Students</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Right Side: User Controls -->
                        <div class="flex items-center space-x-3">
                            
                            <!-- Notification Bell -->
                            <button class="relative p-2 text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white hover:bg-gray-100 dark:hover:bg-gray-800 rounded-lg transition-all duration-200">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
                                </svg>
                                <span class="absolute -top-1 -right-1 w-4 h-4 bg-red-500 rounded-full flex items-center justify-center">
                                    <span class="text-xs font-bold text-white text-[10px]">3</span>
                                </span>
                            </button>
                            
                            <!-- Dark Mode Toggle -->
                            <button id="theme-toggle" class="p-2 text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white hover:bg-gray-100 dark:hover:bg-gray-800 rounded-lg transition-all duration-200">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m8.66-13.66l-.71.71M4.05 19.95l.71-.71M21 12h-1M4 12H3m16.95 7.95l-.71-.71M4.05 4.05l.71.71M16 12a4 4 0 11-8 0 4 4 0 018 0z"></path>
                                </svg>
                            </button>
                            
                            <!-- Profile Menu -->
                            <div class="relative group">
                                <button class="flex items-center space-x-2 p-2 hover:bg-gray-100 dark:hover:bg-gray-800 rounded-lg transition-all duration-200 focus:outline-none">
                                    <div class="w-8 h-8 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-lg flex items-center justify-center overflow-hidden">
                                        @if(!empty($partner?->logo))
                                            <img src="{{ asset('storage/' . $partner->logo) }}" alt="Partner Logo" class="w-full h-full object-cover">
                                        @else
                                            <span class="text-sm font-bold text-white">{{ substr($partner?->slug ?? $partner?->name ?? Auth::user()->name ?? 'P', 0, 1) }}</span>
                                        @endif
                                    </div>
                                    <svg class="w-4 h-4 text-gray-400 group-hover:text-gray-500 transition-colors duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                    </svg>
                                </button>
                                
                                <!-- Profile Dropdown Menu -->
                                <div class="absolute right-0 mt-2 w-48 bg-white dark:bg-gray-800 rounded-lg shadow-lg border border-gray-200 dark:border-gray-700 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 z-50">
                                    <div class="py-1">
                                        <a href="{{ route('partner.profile.show-partnar') }}" class="flex items-center px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors duration-200">
                                            <svg class="w-4 h-4 mr-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                            </svg>
                                            Institution Profile
                                        </a>
                                        <a href="{{ route('partner.profile.edit-partnar') }}" class="flex items-center px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors duration-200">
                                            <svg class="w-4 h-4 mr-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                            </svg>
                                            Edit Institution
                                        </a>
                                        <hr class="my-1 border-gray-200 dark:border-gray-700">
                                        <a href="{{ route('partner.profile.show-user-profile') }}" class="flex items-center px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors duration-200">
                                            <svg class="w-4 h-4 mr-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                            </svg>
                                            User Profile
                                        </a>
                                        <a href="{{ route('partner.profile.edit-user-profile') }}" class="flex items-center px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors duration-200">
                                            <svg class="w-4 h-4 mr-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                            </svg>
                                            Edit User Profile
                                        </a>
                                        <hr class="my-1 border-gray-200 dark:border-gray-700">
                                        <form method="POST" action="{{ route('logout') }}" class="block">
                                            @csrf
                                            <button type="submit" class="w-full flex items-center px-4 py-2 text-sm text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-900/20 transition-colors duration-200 text-left">
                                                <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                                                </svg>
                                                Logout
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Navigation Tabs -->
                    <div class="border-t border-gray-200 dark:border-gray-700 mt-4 pt-4">
                        <nav class="flex items-center space-x-1">
                            <a href="{{ route('partner.dashboard') }}" 
                               class="px-4 py-2 text-sm font-medium text-primaryGreen bg-green-50 dark:bg-green-900/20 rounded-lg border border-green-200 dark:border-green-800">
                                Overview
                            </a>
                            <a href="{{ route('partner.questions.all') }}" 
                               class="px-4 py-2 text-sm font-medium text-gray-600 dark:text-gray-300 hover:text-gray-900 dark:hover:text-white hover:bg-gray-50 dark:hover:bg-gray-800 rounded-lg transition-all duration-200">
                                Questions
                            </a>
                            <a href="{{ route('partner.exams.index') }}" 
                               class="px-4 py-2 text-sm font-medium text-gray-600 dark:text-gray-300 hover:text-gray-900 dark:hover:text-white hover:bg-gray-50 dark:hover:bg-gray-800 rounded-lg transition-all duration-200">
                                Exams
                            </a>
                            <a href="{{ route('partner.students.index') }}" 
                               class="px-4 py-2 text-sm font-medium text-gray-600 dark:text-gray-300 hover:text-gray-900 dark:hover:text-white hover:bg-gray-50 dark:hover:bg-gray-800 rounded-lg transition-all duration-200">
                                Students
                            </a>
                        </nav>
                    </div>
                </div>
            </div>

            <!-- Main Content -->
            <main class="flex-1 overflow-y-auto px-6 pb-6 pt-6">
                <!-- Session Messages -->
                @if(session('success'))
                    <div class="fixed top-4 right-4 z-50 max-w-sm w-full bg-green-50 border border-green-200 rounded-lg shadow-lg p-4 transition-all duration-300 transform translate-x-full" id="success-message">
                        <div class="flex items-start">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm font-medium text-green-800">{{ session('success') }}</p>
                            </div>
                            <div class="ml-auto pl-3">
                                <button type="button" class="inline-flex text-green-400 hover:text-green-600" onclick="this.parentElement.parentElement.parentElement.remove()">
                                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>
                    <script>
                        document.addEventListener('DOMContentLoaded', function() {
                            const message = document.getElementById('success-message');
                            if (message) {
                                message.classList.remove('translate-x-full');
                                setTimeout(() => {
                                    message.classList.add('translate-x-full');
                                    setTimeout(() => message.remove(), 300);
                                }, 5000);
                            }
                        });
                    </script>
                @endif

                @if(session('error'))
                    <div class="fixed top-4 right-4 z-50 max-w-sm w-full bg-red-50 border border-red-200 rounded-lg shadow-lg p-4 transition-all duration-300 transform translate-x-full" id="error-message">
                        <div class="flex items-start">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                                </svg>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm font-medium text-red-800">{{ session('error') }}</p>
                            </div>
                            <div class="ml-auto pl-3">
                                <button type="button" class="inline-flex text-red-400 hover:text-red-600" onclick="this.parentElement.parentElement.parentElement.remove()">
                                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>
                    <script>
                        document.addEventListener('DOMContentLoaded', function() {
                            const message = document.getElementById('error-message');
                            if (message) {
                                message.classList.remove('translate-x-full');
                                setTimeout(() => {
                                    message.classList.add('translate-x-full');
                                    setTimeout(() => message.remove(), 300);
                                }, 5000);
                            }
                        });
                    </script>
                @endif

                @yield('content')
            </main>
        </div>
    </div>

    <!-- JavaScript for Sidebar Toggle, Mobile Sidebar, and Theme -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            // Sidebar state management - always open on desktop
            let sidebarOpen = true; // Always keep sidebar open
            
            const sidebar = document.getElementById('sidebar');
            const sidebarToggle = document.getElementById('sidebar-toggle');
            const sidebarBackdrop = document.getElementById('sidebar-backdrop');
            const mainContentWrapper = document.querySelector('.main-content-wrapper');
            const themeToggle = document.getElementById('theme-toggle');
            const htmlTag = document.documentElement;

            // Elements to show/hide
            const logoText = document.getElementById('logo-text');
            const userInfo = document.getElementById('user-info');
            const logoutButton = document.getElementById('logout-button');
            const navTexts = [
                'nav-dashboard', 'nav-questions', 'nav-exams',
                'nav-students', 'nav-batches', 'nav-courses', 'nav-subjects',
                'nav-topics', 'nav-question-history', 'nav-partners'
            ];

            // Mobile sidebar toggle
            if (sidebarToggle) {
                sidebarToggle.addEventListener('click', () => {
                    const isMobile = window.innerWidth < 1024; // lg breakpoint
                    
                    if (isMobile) {
                        // Mobile: toggle sidebar visibility
                        const isHidden = sidebar.style.transform === 'translateX(-100%)';
                        sidebar.style.transform = isHidden ? 'translateX(0)' : 'translateX(-100%)';
                        sidebarBackdrop.classList.toggle('hidden');
                        
                        // Adjust top bar positioning on mobile
                        const topBar = document.querySelector('.sticky-top-bar');
                        if (topBar) {
                            if (isHidden) {
                                topBar.style.marginLeft = '16rem'; // 256px - same as sidebar width
                            } else {
                                topBar.style.marginLeft = '0';
                            }
                        }
                        
                        // Also adjust main content wrapper on mobile
                        if (mainContentWrapper) {
                            if (isHidden) {
                                mainContentWrapper.style.marginLeft = '16rem'; // 256px - same as sidebar width
                            } else {
                                mainContentWrapper.style.marginLeft = '0';
                            }
                        }
                        
                        // Add/remove body scroll lock for mobile
                        if (isHidden) {
                            document.body.style.overflow = 'hidden';
                        } else {
                            document.body.style.overflow = '';
                        }
                    }
                });
            }
            


            // Close mobile sidebar when backdrop is clicked
            if (sidebarBackdrop) {
                sidebarBackdrop.addEventListener('click', () => {
                    sidebar.style.transform = 'translateX(-100%)';
                    sidebarBackdrop.classList.add('hidden');
                    
                    // Reset top bar positioning
                    const topBar = document.querySelector('.sticky-top-bar');
                    if (topBar) {
                        topBar.style.marginLeft = '0';
                    }
                    
                    // Reset main content wrapper positioning
                    if (mainContentWrapper) {
                        mainContentWrapper.style.marginLeft = '0';
                    }
                    
                    document.body.style.overflow = '';
                });
            }

            // Close mobile sidebar on window resize
            window.addEventListener('resize', () => {
                if (window.innerWidth >= 1024) {
                    // On desktop, restore sidebar state
                    sidebar.style.transform = 'translateX(0)';
                    sidebarBackdrop.classList.add('hidden');
                    document.body.style.overflow = '';
                    updateSidebar();
                    
                    // Hide sidebar toggle button on desktop
                    if (sidebarToggle) {
                        sidebarToggle.style.display = 'none';
                        sidebarToggle.style.visibility = 'hidden';
                        sidebarToggle.style.opacity = '0';
                        sidebarToggle.style.pointerEvents = 'none';
                    }
                } else {
                    // On mobile, ensure sidebar is hidden by default
                    sidebar.style.transform = 'translateX(-100%)';
                    sidebarBackdrop.classList.add('hidden');
                    document.body.style.overflow = '';
                    
                    // Show sidebar toggle button on mobile
                    if (sidebarToggle) {
                        sidebarToggle.style.display = 'block';
                        sidebarToggle.style.visibility = 'visible';
                        sidebarToggle.style.opacity = '1';
                        sidebarToggle.style.pointerEvents = 'auto';
                    }
                    
                    // Reset top bar positioning on mobile
                    const topBar = document.querySelector('.sticky-top-bar');
                    if (topBar) {
                        topBar.style.marginLeft = '0';
                    }
                    
                    // Reset main content wrapper positioning on mobile
                    if (mainContentWrapper) {
                        mainContentWrapper.style.marginLeft = '0';
                    }
                }
            });

            function updateSidebar() {
                // Always keep sidebar expanded on desktop
                sidebar.classList.remove('w-16');
                sidebar.classList.add('w-64');
                
                // Adjust main content margin for expanded sidebar
                if (mainContentWrapper) {
                    mainContentWrapper.classList.remove('sidebar-collapsed');
                }
                
                logoText.style.opacity = '1';
                logoText.style.display = 'block';
                userInfo.style.opacity = '1';
                userInfo.style.display = 'block';
                logoutButton.style.opacity = '1';
                logoutButton.style.display = 'block';
                
                navTexts.forEach(id => {
                    const element = document.getElementById(id);
                    if (element) {
                        element.style.opacity = '1';
                        element.style.display = 'block';
                    }
                });
                
                // Always set sidebar as open
                sidebarOpen = true;
            }

            updateSidebar();
            
            // Initialize sidebar visibility based on screen size
            if (window.innerWidth >= 1024) {
                sidebar.style.transform = 'translateX(0)';
                sidebarBackdrop.classList.add('hidden');
                
                // Ensure sidebar toggle button is hidden on desktop
                if (sidebarToggle) {
                    sidebarToggle.style.display = 'none';
                    sidebarToggle.style.visibility = 'hidden';
                    sidebarToggle.style.opacity = '0';
                    sidebarToggle.style.pointerEvents = 'none';
                }
            } else {
                sidebar.style.transform = 'translateX(-100%)';
                sidebarBackdrop.classList.add('hidden');
                
                // Show sidebar toggle button on mobile
                if (sidebarToggle) {
                    sidebarToggle.style.display = 'block';
                    sidebarToggle.style.visibility = 'visible';
                    sidebarToggle.style.opacity = '1';
                    sidebarToggle.style.pointerEvents = 'auto';
                }
            }

            if (themeToggle) {
                const currentTheme = localStorage.getItem('theme');
                if (currentTheme) {
                    htmlTag.classList.add(currentTheme);
                } else if (window.matchMedia('(prefers-color-scheme: dark)').matches) {
                    htmlTag.classList.add('dark');
                }

                themeToggle.addEventListener('click', () => {
                    if (htmlTag.classList.contains('dark')) {
                        htmlTag.classList.remove('dark');
                        localStorage.setItem('theme', 'light');
                    } else {
                        htmlTag.classList.add('dark');
                        localStorage.setItem('theme', 'dark');
                    }
                });
            }



            // Profile submenu functionality removed - simplified to direct links
        });
    </script>
    
    @stack('scripts')
</body>
</html>
