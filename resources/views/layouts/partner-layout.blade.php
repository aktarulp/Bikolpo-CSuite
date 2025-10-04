<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="theme-color" content="#10b981">
    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />
    <link href="{{ asset('css/fonts.css') }}" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <style>
        /* Bengali Font */
        .font-bengali {
            font-family: 'Hind Siliguri', 'Noto Sans Bengali', 'Noto Sans', 'Arial Unicode MS', sans-serif;
        }

        /* Mobile-First Sidebar - Hidden by default on mobile */
        .mobile-sidebar {
            position: fixed;
            inset: 0;
            z-index: 50;
            transform: translateX(-100%);
            transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .mobile-sidebar.open {
            transform: translateX(0);
        }

        /* Desktop Sidebar - Always visible */
        @media (min-width: 1024px) {
            .mobile-sidebar {
                position: sticky;
                top: 0;
                transform: translateX(0);
                height: 100vh;
            }
        }

        /* Backdrop */
        .sidebar-backdrop {
            position: fixed;
            inset: 0;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 40;
            opacity: 0;
            visibility: hidden;
            transition: opacity 0.3s ease, visibility 0.3s ease;
        }

        .sidebar-backdrop.active {
            opacity: 1;
            visibility: visible;
        }

        @media (min-width: 1024px) {
            .sidebar-backdrop {
                display: none;
            }
        }

        /* Smooth scrolling */
        html {
            scroll-behavior: smooth;
        }

        /* Custom scrollbar */
        .custom-scrollbar::-webkit-scrollbar {
            width: 6px;
        }

        .custom-scrollbar::-webkit-scrollbar-track {
            background: transparent;
        }

        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 3px;
        }

        .dark .custom-scrollbar::-webkit-scrollbar-thumb {
            background: #475569;
        }

        /* Safe area for mobile notches */
        @supports (padding: max(0px)) {
            .safe-top {
                padding-top: max(1rem, env(safe-area-inset-top));
            }
            .safe-bottom {
                padding-bottom: max(1rem, env(safe-area-inset-bottom));
            }
        }

        /* Prevent text selection on double tap (mobile) */
        .no-tap-highlight {
            -webkit-tap-highlight-color: transparent;
            -webkit-touch-callout: none;
            user-select: none;
        }

        /* Smooth transitions */
        * {
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
        }

        /* Alpine.js cloak */
        [x-cloak] {
            display: none !important;
        }
    </style>
</head>
<body class="h-full font-sans antialiased bg-gray-50 dark:bg-gray-900">
    <!-- Mobile Backdrop -->
    <div id="sidebar-backdrop" class="sidebar-backdrop lg:hidden"></div>

    <!-- Layout Container -->
    <div class="flex h-full">
        <!-- Sidebar -->
        <aside id="sidebar" class="mobile-sidebar w-56 lg:w-60 bg-white dark:bg-gray-900 border-r border-gray-200 dark:border-gray-700 flex flex-col">
            <div class="flex flex-col h-full overflow-y-auto custom-scrollbar">
                <!-- Sidebar Header -->
                <div class="relative px-3 py-3 lg:py-4 border-b border-gray-200 dark:border-gray-700 bg-gradient-to-br from-primaryGreen/5 to-emerald-50 dark:from-primaryGreen/10 dark:to-gray-900">
                    <div class="flex items-center justify-between">
                        <a href="{{ route('partner.dashboard') }}" class="flex items-center space-x-2 group flex-1 min-w-0">
                            <div class="relative flex-shrink-0">
                                <div class="w-14 h-14 bg-white dark:bg-gray-800 rounded-xl flex items-center justify-center shadow-lg ring-2 ring-primaryGreen/20 group-hover:ring-primaryGreen/40 transition-all duration-300 group-hover:scale-105 overflow-hidden">
                                    <img src="{{ asset('images/only_logo.png') }}" alt="Bikolpo Live Question" class="w-full h-full object-contain p-1">
                                </div>
                                <div class="absolute -top-0.5 -right-0.5 w-2.5 h-2.5 bg-emerald-400 rounded-full animate-pulse"></div>
                            </div>
                            <div class="flex flex-col min-w-0 flex-1">
                                <h2 class="text-lg font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-gray-900 via-primaryGreen to-emerald-600 dark:from-white dark:via-emerald-400 dark:to-primaryGreen tracking-tight leading-tight">
                                    Bikolpo<br/>Live Question
                                </h2>
                            </div>
                        </a>
                        <!-- Close button for mobile -->
                        <button id="sidebar-close" class="lg:hidden p-1.5 rounded-lg text-gray-400 hover:text-gray-600 hover:bg-white/50 dark:hover:bg-gray-800 transition-all duration-200 flex-shrink-0">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>
                </div>

                <!-- Navigation -->
                <nav class="flex-1 px-2 py-3 lg:px-3 space-y-1">
                    @if(auth()->check())
                    <a href="{{ route('partner.dashboard') }}"
                       class="group flex items-center px-3 py-1.5 text-sm font-semibold rounded-lg transition-all duration-200 {{ request()->routeIs('partner.dashboard') ? 'bg-gradient-to-r from-primaryGreen/10 to-emerald-50 text-primaryGreen border border-primaryGreen/20 shadow-sm' : 'text-gray-700 dark:text-gray-300 hover:bg-gradient-to-r hover:from-gray-50 hover:to-gray-100 dark:hover:from-gray-800 dark:hover:to-gray-800 hover:text-gray-900 dark:hover:text-white' }}">
                        <div class="w-8 h-8 flex-shrink-0 rounded-lg {{ request()->routeIs('partner.dashboard') ? 'bg-primaryGreen/10' : 'bg-gray-100 dark:bg-gray-800 group-hover:bg-primaryGreen/10' }} flex items-center justify-center transition-all duration-200">
                            <svg class="h-4 w-4 {{ request()->routeIs('partner.dashboard') ? 'text-primaryGreen' : 'text-gray-500 group-hover:text-primaryGreen' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                            </svg>
                        </div>
                        <span class="ml-2 flex-1">Dashboard</span>
                    </a>
                    @endif

                    @if(auth()->check())
                    <a href="{{ route('partner.courses.index') }}"
                       class="group flex items-center px-3 py-1.5 text-sm font-semibold rounded-lg transition-all duration-200 {{ request()->routeIs('partner.courses.*') ? 'bg-gradient-to-r from-orange-50 to-orange-100 text-orange-700 border border-orange-200 shadow-sm' : 'text-gray-700 dark:text-gray-300 hover:bg-gradient-to-r hover:from-orange-50/50 hover:to-orange-50 dark:hover:from-gray-800 dark:hover:to-gray-800 hover:text-orange-700 dark:hover:text-white' }}">
                        <div class="w-8 h-8 flex-shrink-0 rounded-lg {{ request()->routeIs('partner.courses.*') ? 'bg-orange-100' : 'bg-gray-100 dark:bg-gray-800 group-hover:bg-orange-50' }} flex items-center justify-center transition-all duration-200">
                            <svg class="h-4 w-4 {{ request()->routeIs('partner.courses.*') ? 'text-orange-600' : 'text-gray-500 group-hover:text-orange-500' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                            </svg>
                        </div>
                        <span class="ml-2 flex-1">Courses</span>
                        <span class="ml-auto inline-flex items-center justify-center min-w-[22px] h-5 px-1.5 text-[10px] font-semibold rounded-full bg-orange-100 text-orange-700 dark:bg-orange-900/50 dark:text-orange-300 border border-orange-300 dark:border-orange-700">{{ $stats['total_courses'] ?? 0 }}</span>
                    </a>
                    @endif
                    

                    @if(auth()->check())
                    <a href="{{ route('partner.subjects.index') }}"
                       class="group flex items-center px-3 py-1.5 text-sm font-semibold rounded-lg transition-all duration-200 {{ request()->routeIs('partner.subjects.*') ? 'bg-gradient-to-r from-purple-50 to-purple-100 text-purple-700 border border-purple-200 shadow-sm' : 'text-gray-700 dark:text-gray-300 hover:bg-gradient-to-r hover:from-purple-50/50 hover:to-purple-50 dark:hover:from-gray-800 dark:hover:to-gray-800 hover:text-purple-700 dark:hover:text-white' }}">
                        <div class="w-8 h-8 flex-shrink-0 rounded-lg {{ request()->routeIs('partner.subjects.*') ? 'bg-purple-100' : 'bg-gray-100 dark:bg-gray-800 group-hover:bg-purple-50' }} flex items-center justify-center transition-all duration-200">
                            <svg class="h-4 w-4 {{ request()->routeIs('partner.subjects.*') ? 'text-purple-600' : 'text-gray-500 group-hover:text-purple-500' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                        </div>
                        <span class="ml-2 flex-1">Subjects</span>
                        <span class="ml-auto inline-flex items-center justify-center min-w-[22px] h-5 px-1.5 text-[10px] font-semibold rounded-full bg-purple-100 text-purple-700 dark:bg-purple-900/50 dark:text-purple-300 border border-purple-300 dark:border-purple-700">{{ $stats['total_subjects'] ?? 0 }}</span>
                    </a>
                    @endif

                    @if(auth()->check())
                    <a href="{{ route('partner.topics.index') }}"
                       class="group flex items-center px-3 py-1.5 text-sm font-semibold rounded-lg transition-all duration-200 {{ request()->routeIs('partner.topics.*') ? 'bg-gradient-to-r from-pink-50 to-pink-100 text-pink-700 border border-pink-200 shadow-sm' : 'text-gray-700 dark:text-gray-300 hover:bg-gradient-to-r hover:from-pink-50/50 hover:to-pink-50 dark:hover:from-gray-800 dark:hover:to-gray-800 hover:text-pink-700 dark:hover:text-white' }}">
                        <div class="w-8 h-8 flex-shrink-0 rounded-lg {{ request()->routeIs('partner.topics.*') ? 'bg-pink-100' : 'bg-gray-100 dark:bg-gray-800 group-hover:bg-pink-50' }} flex items-center justify-center transition-all duration-200">
                            <svg class="h-4 w-4 {{ request()->routeIs('partner.topics.*') ? 'text-pink-600' : 'text-gray-500 group-hover:text-pink-500' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                            </svg>
                        </div>
                        <span class="ml-2 flex-1">Topics</span>
                        <span class="ml-auto inline-flex items-center justify-center min-w-[22px] h-5 px-1.5 text-[10px] font-semibold rounded-full bg-pink-100 text-pink-700 dark:bg-pink-900/50 dark:text-pink-300 border border-pink-300 dark:border-pink-700">{{ $stats['total_topics'] ?? 0 }}</span>
                    </a>
                    @endif
                    @if(auth()->check())
                    <a href="{{ route('partner.batches.index') }}"
                       class="group flex items-center px-3 py-1.5 text-sm font-semibold rounded-lg transition-all duration-200 {{ request()->routeIs('partner.batches.*') ? 'bg-gradient-to-r from-indigo-50 to-indigo-100 text-indigo-700 border border-indigo-200 shadow-sm' : 'text-gray-700 dark:text-gray-300 hover:bg-gradient-to-r hover:from-indigo-50/50 hover:to-indigo-50 dark:hover:from-gray-800 dark:hover:to-gray-800 hover:text-indigo-700 dark:hover:text-white' }}">
                        <div class="w-8 h-8 flex-shrink-0 rounded-lg {{ request()->routeIs('partner.batches.*') ? 'bg-indigo-100' : 'bg-gray-100 dark:bg-gray-800 group-hover:bg-indigo-50' }} flex items-center justify-center transition-all duration-200">
                            <svg class="h-4 w-4 {{ request()->routeIs('partner.batches.*') ? 'text-indigo-600' : 'text-gray-500 group-hover:text-indigo-500' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                            </svg>
                        </div>
                        <span class="ml-2 flex-1">Batches</span>
                        <span class="ml-auto inline-flex items-center justify-center min-w-[22px] h-5 px-1.5 text-[10px] font-semibold rounded-full bg-indigo-100 text-indigo-700 dark:bg-indigo-900/50 dark:text-indigo-300 border border-indigo-300 dark:border-indigo-700">{{ $stats['total_batches'] ?? 0 }}</span>
                    </a>
                    @endif
                    @if(auth()->check())
                    <a href="{{ route('partner.students.index') }}"
                       class="group flex items-center px-3 py-1.5 text-sm font-semibold rounded-lg transition-all duration-200 {{ request()->routeIs('partner.students.*') ? 'bg-gradient-to-r from-emerald-50 to-emerald-100 text-emerald-700 border border-emerald-200 shadow-sm' : 'text-gray-700 dark:text-gray-300 hover:bg-gradient-to-r hover:from-emerald-50/50 hover:to-emerald-50 dark:hover:from-gray-800 dark:hover:to-gray-800 hover:text-emerald-700 dark:hover:text-white' }}">
                        <div class="w-8 h-8 flex-shrink-0 rounded-lg {{ request()->routeIs('partner.students.*') ? 'bg-emerald-100' : 'bg-gray-100 dark:bg-gray-800 group-hover:bg-emerald-50' }} flex items-center justify-center transition-all duration-200">
                            <svg class="h-4 w-4 {{ request()->routeIs('partner.students.*') ? 'text-emerald-600' : 'text-gray-500 group-hover:text-emerald-500' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                            </svg>
                        </div>
                        <span class="ml-2 flex-1">Students</span>
                        <span class="ml-auto inline-flex items-center justify-center min-w-[22px] h-5 px-1.5 text-[10px] font-semibold rounded-full bg-emerald-100 text-emerald-700 dark:bg-emerald-900/50 dark:text-emerald-300 border border-emerald-300 dark:border-emerald-700">{{ $stats['total_students'] ?? 0 }}</span>
                    </a>
                    @endif
                    @if(auth()->check())
                    <a href="{{ route('partner.teachers.index') }}"
                       class="group flex items-center px-3 py-1.5 text-sm font-semibold rounded-lg transition-all duration-200 {{ request()->routeIs('partner.teachers.*') ? 'bg-gradient-to-r from-teal-50 to-teal-100 text-teal-700 border border-teal-200 shadow-sm' : 'text-gray-700 dark:text-gray-300 hover:bg-gradient-to-r hover:from-teal-50/50 hover:to-teal-50 dark:hover:from-gray-800 dark:hover:to-gray-800 hover:text-teal-700 dark:hover:text-white' }}">
                        <div class="w-8 h-8 flex-shrink-0 rounded-lg {{ request()->routeIs('partner.teachers.*') ? 'bg-teal-100' : 'bg-gray-100 dark:bg-gray-800 group-hover:bg-teal-50' }} flex items-center justify-center transition-all duration-200">
                            <svg class="h-4 w-4 {{ request()->routeIs('partner.teachers.*') ? 'text-teal-600' : 'text-gray-500 group-hover:text-teal-500' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14zm-4 6v-7.5l4-2.222"></path>
                            </svg>
                        </div>
                        <span class="ml-2 flex-1">Teachers</span>
                        <span class="ml-auto inline-flex items-center justify-center min-w-[22px] h-5 px-1.5 text-[10px] font-semibold rounded-full bg-teal-100 text-teal-700 dark:bg-teal-900/50 dark:text-teal-300 border border-teal-300 dark:border-teal-700">{{ $stats['total_teachers'] ?? 0 }}</span>
                    </a>
                    @endif
                    @if(auth()->check())
                    <a href="{{ route('partner.questions.all') }}"
                       class="group flex items-center px-3 py-1.5 text-sm font-semibold rounded-lg transition-all duration-200 {{ request()->routeIs('partner.questions.*') ? 'bg-gradient-to-r from-blue-50 to-blue-100 text-blue-700 border border-blue-200 shadow-sm' : 'text-gray-700 dark:text-gray-300 hover:bg-gradient-to-r hover:from-blue-50/50 hover:to-blue-50 dark:hover:from-gray-800 dark:hover:to-gray-800 hover:text-blue-700 dark:hover:text-white' }}">
                        <div class="w-8 h-8 flex-shrink-0 rounded-lg {{ request()->routeIs('partner.questions.*') ? 'bg-blue-100' : 'bg-gray-100 dark:bg-gray-800 group-hover:bg-blue-50' }} flex items-center justify-center transition-all duration-200">
                            <svg class="h-4 w-4 {{ request()->routeIs('partner.questions.*') ? 'text-blue-600' : 'text-gray-500 group-hover:text-blue-500' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <span class="ml-2 flex-1">Questions</span>
                        <span class="ml-auto inline-flex items-center justify-center min-w-[22px] h-5 px-1.5 text-[10px] font-semibold rounded-full bg-blue-100 text-blue-700 dark:bg-blue-900/50 dark:text-blue-300 border border-blue-300 dark:border-blue-700">{{ $stats['total_questions'] ?? 0 }}</span>
                    </a>
                    @endif


                    @if(auth()->check())
                    <a href="{{ route('partner.exams.index') }}"
                       class="group flex items-center px-3 py-1.5 text-sm font-semibold rounded-lg transition-all duration-200 {{ request()->routeIs('partner.exams.*') ? 'bg-gradient-to-r from-cyan-50 to-cyan-100 text-cyan-700 border border-cyan-200 shadow-sm' : 'text-gray-700 dark:text-gray-300 hover:bg-gradient-to-r hover:from-cyan-50/50 hover:to-cyan-50 dark:hover:from-gray-800 dark:hover:to-gray-800 hover:text-cyan-700 dark:hover:text-white' }}">
                        <div class="w-8 h-8 flex-shrink-0 rounded-lg {{ request()->routeIs('partner.exams.*') ? 'bg-cyan-100' : 'bg-gray-100 dark:bg-gray-800 group-hover:bg-cyan-50' }} flex items-center justify-center transition-all duration-200">
                            <svg class="h-4 w-4 {{ request()->routeIs('partner.exams.*') ? 'text-cyan-600' : 'text-gray-500 group-hover:text-cyan-500' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                        </div>
                        <span class="ml-2 flex-1">Exams</span>
                        <span class="ml-auto inline-flex items-center justify-center min-w-[22px] h-5 px-1.5 text-[10px] font-semibold rounded-full bg-cyan-100 text-cyan-700 dark:bg-cyan-900/50 dark:text-cyan-300 border border-cyan-300 dark:border-cyan-700">{{ $stats['total_exams'] ?? 0 }}</span>
                    </a>
                    @endif

                    @if(auth()->check())
                    <a href="{{ route('analytics.questions.index') }}"
                       class="group flex items-center px-3 py-1.5 text-sm font-semibold rounded-lg transition-all duration-200 {{ request()->routeIs('analytics.questions.*') ? 'bg-gradient-to-r from-violet-50 to-violet-100 text-violet-700 border border-violet-200 shadow-sm' : 'text-gray-700 dark:text-gray-300 hover:bg-gradient-to-r hover:from-violet-50/50 hover:to-violet-50 dark:hover:from-gray-800 dark:hover:to-gray-800 hover:text-violet-700 dark:hover:text-white' }}">
                        <div class="w-8 h-8 flex-shrink-0 rounded-lg {{ request()->routeIs('analytics.questions.*') ? 'bg-violet-100' : 'bg-gray-100 dark:bg-gray-800 group-hover:bg-violet-50' }} flex items-center justify-center transition-all duration-200">
                            <svg class="h-4 w-4 {{ request()->routeIs('analytics.questions.*') ? 'text-violet-600' : 'text-gray-500 group-hover:text-violet-500' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                            </svg>
                        </div>
                        <span class="ml-2 flex-1">Analytics</span>
                        <span class="ml-auto inline-flex items-center justify-center min-w-[22px] h-5 px-1.5 text-[10px] font-semibold rounded-full bg-violet-100 text-violet-700 dark:bg-violet-900/50 dark:text-violet-300 border border-violet-300 dark:border-violet-700">{{ $stats['total_question_attempts'] ?? 0 }}</span>
                    </a>
                    @endif

                    @if(auth()->check())
                    <a href="{{ route('partner.sms.index') }}"
                       class="group flex items-center px-3 py-1.5 text-sm font-semibold rounded-lg transition-all duration-200 {{ request()->routeIs('partner.sms.*') ? 'bg-gradient-to-r from-teal-50 to-teal-100 text-teal-700 border border-teal-200 shadow-sm' : 'text-gray-700 dark:text-gray-300 hover:bg-gradient-to-r hover:from-teal-50/50 hover:to-teal-50 dark:hover:from-gray-800 dark:hover:to-gray-800 hover:text-teal-700 dark:hover:text-white' }}">
                        <div class="w-8 h-8 flex-shrink-0 rounded-lg {{ request()->routeIs('partner.sms.*') ? 'bg-teal-100' : 'bg-gray-100 dark:bg-gray-800 group-hover:bg-teal-50' }} flex items-center justify-center transition-all duration-200">
                            <svg class="h-4 w-4 {{ request()->routeIs('partner.sms.*') ? 'text-teal-600' : 'text-gray-500 group-hover:text-teal-500' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"></path>
                            </svg>
                        </div>
                        <span class="ml-2 flex-1">SMS</span>
                        <span class="ml-auto inline-flex items-center justify-center min-w-[22px] h-5 px-1.5 text-[10px] font-semibold rounded-full bg-teal-100 text-teal-700 dark:bg-teal-900/50 dark:text-teal-300 border border-teal-300 dark:border-teal-700">{{ $stats['total_sms'] ?? 0 }}</span>
                    </a>
                    @endif
                </nav>

                <!-- Sidebar Footer -->
                <div class="flex-shrink-0 p-2 border-t border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-800/50">
                    <div class="relative" x-data="{ open: false }" @click.away="open = false">
                        <!-- User Menu Button -->
                        <button @click="open = !open" class="w-full group flex items-center space-x-2 p-1.5 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 transition-all duration-200">
                            <div class="flex-shrink-0">
                                <div class="w-8 h-8 bg-gradient-to-br from-primaryGreen to-emerald-600 rounded-full flex items-center justify-center ring-2 ring-white dark:ring-gray-800">
                                    <span class="text-xs font-bold text-white">{{ substr(Auth::user()->name ?? 'P', 0, 1) }}</span>
                                </div>
                            </div>
                            <div class="flex-1 min-w-0 text-left">
                                <p class="text-sm font-bold text-gray-900 dark:text-white truncate">{{ Auth::user()->name ?? 'Partner' }}</p>
                                <p class="text-xs font-medium text-gray-500 dark:text-gray-400 truncate">{{ Auth::user()->email ?? 'partner@example.com' }}</p>
                            </div>
                            <svg class="w-4 h-4 text-gray-400 group-hover:text-gray-600 transition-all duration-300 transform group-hover:rotate-180" :class="{ 'rotate-180': open }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>

                        <!-- Dropdown Menu -->
                        <div x-show="open" 
                             x-transition:enter="transition ease-out duration-200"
                             x-transition:enter-start="opacity-0 transform scale-95 -translate-y-2"
                             x-transition:enter-end="opacity-100 transform scale-100 translate-y-0"
                             x-transition:leave="transition ease-in duration-150"
                             x-transition:leave-start="opacity-100 transform scale-100 translate-y-0"
                             x-transition:leave-end="opacity-0 transform scale-95 -translate-y-2"
                             class="absolute bottom-full left-0 mb-2 w-64 bg-white dark:bg-gray-800 rounded-lg shadow-lg border border-gray-200 dark:border-gray-700 z-50 overflow-hidden">
                            
                            <!-- Menu Body -->
                            <div class="p-0.5">
                                <!-- Institution Section -->
                                <div class="mb-1">
                                    <p class="px-3 py-1 text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Institution</p>
                                    <div class="space-y-1">
                                        <a href="{{ route('partner.profile.show-partnar') }}" class="group flex items-center px-3 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 hover:bg-primaryGreen/10 dark:hover:bg-primaryGreen/20 hover:text-primaryGreen dark:hover:text-emerald-400 rounded-lg transition-colors duration-150">
                                            <div class="w-7 h-7 bg-primaryGreen/10 dark:bg-primaryGreen/20 rounded-md flex items-center justify-center mr-2 group-hover:scale-110 transition-transform duration-200">
                                                <svg class="w-3.5 h-3.5 text-primaryGreen dark:text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                                </svg>
                                            </div>
                                            <div class="flex-1">
                                                <p class="font-medium">Institution Profile</p>
                                            </div>
                                            <svg class="w-4 h-4 text-gray-400 group-hover:text-primaryGreen" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                            </svg>
                                        </a>
                                        
                                        <a href="{{ route('partner.profile.edit-partnar') }}" class="group flex items-center px-3 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 hover:bg-orange-100 dark:hover:bg-orange-900/30 hover:text-orange-700 dark:hover:text-orange-400 rounded-lg transition-colors duration-150">
                                            <div class="w-7 h-7 bg-orange-100 dark:bg-orange-900/50 rounded-md flex items-center justify-center mr-2 group-hover:scale-110 transition-transform duration-200">
                                                <svg class="w-3.5 h-3.5 text-orange-600 dark:text-orange-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                                </svg>
                                            </div>
                                            <div class="flex-1">
                                                <p class="font-medium">Edit Institution</p>
                                            </div>
                                            <svg class="w-4 h-4 text-gray-400 group-hover:text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                            </svg>
                                        </a>
                                    </div>
                                </div>
                                
                                <!-- User Section -->
                                <div class="mb-1">
                                    <p class="px-3 py-1 text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Personal</p>
                                    <div class="space-y-1">
                                        <a href="{{ route('partner.profile.show-user-profile') }}" class="group flex items-center px-3 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 hover:bg-blue-100 dark:hover:bg-blue-900/30 hover:text-blue-700 dark:hover:text-blue-400 rounded-lg transition-colors duration-150">
                                            <div class="w-7 h-7 bg-blue-100 dark:bg-blue-900/50 rounded-md flex items-center justify-center mr-2 group-hover:scale-110 transition-transform duration-200">
                                                <svg class="w-3.5 h-3.5 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                                </svg>
                                            </div>
                                            <div class="flex-1">
                                                <p class="font-medium">User Profile</p>
                                            </div>
                                            <svg class="w-4 h-4 text-gray-400 group-hover:text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                            </svg>
                                        </a>
                                        
                                        <a href="{{ route('partner.profile.edit-user-profile') }}" class="group flex items-center px-3 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 hover:bg-purple-100 dark:hover:bg-purple-900/30 hover:text-purple-700 dark:hover:text-purple-400 rounded-lg transition-colors duration-150">
                                            <div class="w-7 h-7 bg-purple-100 dark:bg-purple-900/50 rounded-md flex items-center justify-center mr-2 group-hover:scale-110 transition-transform duration-200">
                                                <svg class="w-3.5 h-3.5 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                                </svg>
                                            </div>
                                            <div class="flex-1">
                                                <p class="font-medium">Edit User Profile</p>
                                            </div>
                                            <svg class="w-4 h-4 text-gray-400 group-hover:text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                            </svg>
                                        </a>
                                        
                                        <a href="#" class="group flex items-center px-3 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 hover:bg-green-100 dark:hover:bg-green-900/30 hover:text-green-700 dark:hover:text-green-400 rounded-lg transition-colors duration-150">
                                            <div class="w-7 h-7 bg-green-100 dark:bg-green-900/50 rounded-md flex items-center justify-center mr-2 group-hover:scale-110 transition-transform duration-200">
                                                <svg class="w-3.5 h-3.5 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                                </svg>
                                            </div>
                                            <div class="flex-1">
                                                <p class="font-medium">Teacher</p>
                                            </div>
                                            <svg class="w-4 h-4 text-gray-400 group-hover:text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                            </svg>
                                        </a>
                                    </div>
                                </div>
                                
                                <!-- System Section -->
                                <div class="mb-1">
                                    <p class="px-3 py-1 text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">System</p>
                                    <div class="space-y-1">
                                        <a href="{{ route('partner.settings.index') }}" class="group flex items-center px-3 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 hover:text-gray-900 dark:hover:text-white rounded-lg transition-colors duration-150">
                                            <div class="w-7 h-7 bg-gray-100 dark:bg-gray-700 rounded-md flex items-center justify-center mr-2 group-hover:scale-110 transition-transform duration-200">
                                                <svg class="w-3.5 h-3.5 text-gray-600 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                </svg>
                                            </div>
                                            <div class="flex-1">
                                                <p class="font-medium">Settings</p>
                                            </div>
                                            <svg class="w-4 h-4 text-gray-400 group-hover:text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                            </svg>
                                        </a>
                                    </div>
                                </div>
                                
                                <!-- Logout Section -->
                                <div class="border-t border-gray-200 dark:border-gray-700 pt-2 mt-2">
                                    <form method="POST" action="{{ route('logout') }}" class="block">
                                        @csrf
                                        <button type="submit" class="group w-full flex items-center px-3 py-2 text-sm font-medium text-red-600 dark:text-red-400 hover:bg-red-100 dark:hover:bg-red-900/30 hover:text-red-700 dark:hover:text-red-300 rounded-lg transition-colors duration-150">
                                            <div class="w-7 h-7 bg-red-100 dark:bg-red-900/50 rounded-md flex items-center justify-center mr-2 group-hover:scale-110 transition-transform duration-200">
                                                <svg class="w-3.5 h-3.5 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                                                </svg>
                                            </div>
                                            <div class="flex-1 text-left">
                                                <p class="font-medium">Logout</p>
                                            </div>
                                            <svg class="w-4 h-4 text-red-400 group-hover:text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </aside>

        <!-- Main Content Area -->
        <main class="flex-1 flex flex-col min-h-screen lg:min-h-0 overflow-hidden">
            <!-- Mobile Header -->
            <header class="lg:hidden sticky top-0 z-30 bg-gradient-to-r from-white to-gray-50 dark:from-gray-900 dark:to-gray-800 border-b border-gray-200 dark:border-gray-700 safe-top backdrop-blur-sm bg-white/95 dark:bg-gray-900/95 shadow-sm">
                <div class="flex items-center justify-between px-4 py-3">
                    <button id="sidebar-toggle" class="p-2.5 rounded-xl text-gray-600 dark:text-gray-400 hover:bg-primaryGreen/10 hover:text-primaryGreen dark:hover:bg-primaryGreen/20 transition-all duration-200 no-tap-highlight active:scale-95">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 6h16M4 12h16M4 18h16"></path>
                        </svg>
                    </button>
                    <h1 class="text-lg font-bold text-transparent bg-clip-text bg-gradient-to-r from-gray-900 via-primaryGreen to-emerald-600 dark:from-white dark:via-emerald-400 dark:to-primaryGreen">
                        {{ $partner?->name ?? 'Partner Portal' }}
                    </h1>
                    <div class="w-10"></div> <!-- Spacer for centering -->
                </div>
            </header>

            <!-- Desktop Top Bar -->
            <div class="hidden lg:block sticky top-0 z-20 bg-gradient-to-r from-white via-gray-50 to-white dark:from-gray-900 dark:via-gray-800 dark:to-gray-900 border-b border-gray-200 dark:border-gray-700 shadow-md backdrop-blur-sm bg-white/95 dark:bg-gray-900/95">
                <div class="px-4 lg:px-8 py-4">
                    <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
                        <div class="flex items-center space-x-4">
                            <div class="w-12 h-12 flex items-center justify-center bg-gradient-to-br from-primaryGreen/10 to-emerald-100 dark:from-primaryGreen/20 dark:to-emerald-900/30 rounded-xl ring-2 ring-primaryGreen/20 shadow-lg">
                                @if(!empty($partner?->logo))
                                    <img src="{{ asset('storage/' . $partner->logo) }}" alt="Partner Logo" class="w-10 h-10 object-cover rounded-lg">
                                @else
                                    <svg class="w-6 h-6 text-primaryGreen dark:text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                    </svg>
                                @endif
                            </div>
                            <div>
                                <h2 class="text-xl lg:text-2xl font-bold text-gray-900 dark:text-white">
                                    Welcome back, <span class="text-transparent bg-clip-text bg-gradient-to-r from-primaryGreen to-emerald-600 dark:from-emerald-400 dark:to-primaryGreen">{{ $partner?->name ?? Auth::user()->name ?? 'Partner' }}</span>
                                </h2>
                                <p class="text-gray-600 dark:text-gray-400 text-sm flex items-center mt-1">
                                    <svg class="w-4 h-4 mr-1.5 text-primaryGreen" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    Manage your exam system efficiently
                                </p>
                            </div>
                        </div>

                        <!-- Stats Container - Mobile First -->
                        <div class="stats-container flex flex-wrap gap-3 lg:gap-4">
                            <!-- Courses Card -->
                            <div class="group flex items-center gap-2 px-3 py-2 bg-gradient-to-br from-orange-50 to-orange-100 dark:from-orange-900/20 dark:to-orange-900/30 rounded-xl border border-orange-200 dark:border-orange-800/50 hover:shadow-lg hover:scale-105 transition-all duration-200">
                                <div class="w-10 h-10 bg-white dark:bg-orange-900/50 rounded-lg flex items-center justify-center shadow-sm group-hover:rotate-12 transition-transform duration-200">
                                    <svg class="w-5 h-5 text-orange-600 dark:text-orange-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-xl font-bold text-orange-600 dark:text-orange-400 leading-none">{{ $stats['total_courses'] ?? 0 }}</p>
                                    <p class="text-xs font-medium text-orange-700 dark:text-orange-300 mt-0.5">Courses</p>
                                </div>
                            </div>

                            <!-- Questions Card -->
                            <div class="group flex items-center gap-2 px-3 py-2 bg-gradient-to-br from-blue-50 to-blue-100 dark:from-blue-900/20 dark:to-blue-900/30 rounded-xl border border-blue-200 dark:border-blue-800/50 hover:shadow-lg hover:scale-105 transition-all duration-200">
                                <div class="w-10 h-10 bg-white dark:bg-blue-900/50 rounded-lg flex items-center justify-center shadow-sm group-hover:rotate-12 transition-transform duration-200">
                                    <svg class="w-5 h-5 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-xl font-bold text-blue-600 dark:text-blue-400 leading-none">{{ $stats['total_questions'] ?? 0 }}</p>
                                    <p class="text-xs font-medium text-blue-700 dark:text-blue-300 mt-0.5">Questions</p>
                                </div>
                            </div>

                            <!-- Exams Card -->
                            <div class="group flex items-center gap-2 px-3 py-2 bg-gradient-to-br from-cyan-50 to-cyan-100 dark:from-cyan-900/20 dark:to-cyan-900/30 rounded-xl border border-cyan-200 dark:border-cyan-800/50 hover:shadow-lg hover:scale-105 transition-all duration-200">
                                <div class="w-10 h-10 bg-white dark:bg-cyan-900/50 rounded-lg flex items-center justify-center shadow-sm group-hover:rotate-12 transition-transform duration-200">
                                    <svg class="w-5 h-5 text-cyan-600 dark:text-cyan-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-xl font-bold text-cyan-600 dark:text-cyan-400 leading-none">{{ $stats['total_exams'] ?? 0 }}</p>
                                    <p class="text-xs font-medium text-cyan-700 dark:text-cyan-300 mt-0.5">Exams</p>
                                </div>
                            </div>

                            <!-- Enhanced User Menu -->
                            <div class="relative" x-data="{ open: false }" @click.away="open = false">
                                <!-- User Menu Button -->
                                <button @click="open = !open" class="group flex items-center space-x-3 p-2.5 bg-gradient-to-r from-white to-gray-50 dark:from-gray-800 dark:to-gray-700 hover:from-primaryGreen/5 hover:to-primaryGreen/10 dark:hover:from-primaryGreen/10 dark:hover:to-primaryGreen/20 rounded-xl border border-gray-200 dark:border-gray-600 hover:border-primaryGreen/30 dark:hover:border-primaryGreen/50 transition-all duration-300 focus:outline-none focus:ring-2 focus:ring-primaryGreen/20 shadow-sm hover:shadow-md">
                                    
                                    
                                    <!-- User Info (Hidden on Mobile) -->
                                    <div class="hidden sm:block text-left">
                                        <p class="text-sm font-semibold text-gray-900 dark:text-white group-hover:text-primaryGreen dark:group-hover:text-emerald-400 transition-colors duration-200">
                                            {{ Auth::user()->name ?? 'Partner' }}
                                        </p>
                                        <p class="text-xs font-medium text-gray-500 dark:text-gray-400 group-hover:text-gray-600 dark:group-hover:text-gray-300 transition-colors duration-200">
                                            {{ $partner?->name ?? 'Institution' }}
                                        </p>
                                    </div>
                                    
                                    <!-- Dropdown Arrow -->
                                    <svg class="w-5 h-5 text-gray-400 group-hover:text-primaryGreen dark:group-hover:text-emerald-400 transition-all duration-300 transform group-hover:rotate-180" :class="{ 'rotate-180': open }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                    </svg>
                                </button>

                                <!-- Enhanced Dropdown Menu -->
                                <div x-show="open" 
                                     x-transition:enter="transition ease-out duration-300"
                                     x-transition:enter-start="opacity-0 transform scale-95 -translate-y-2"
                                     x-transition:enter-end="opacity-100 transform scale-100 translate-y-0"
                                     x-transition:leave="transition ease-in duration-200"
                                     x-transition:leave-start="opacity-100 transform scale-100 translate-y-0"
                                     x-transition:leave-end="opacity-0 transform scale-95 -translate-y-2"
                                     class="absolute right-0 mt-2 w-64 sm:w-72 bg-white dark:bg-gray-800 rounded-lg shadow-lg border border-gray-200 dark:border-gray-700 z-50 overflow-hidden">
                                    
                                  
                                    <!-- Menu Body -->
                                    <div class="p-0.5">
                                        <!-- Institution Section -->
                                        <div class="mb-1">
                                            <p class="px-3 py-1 text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Institution</p>
                                            <div class="space-y-1">
                                                <a href="{{ route('partner.profile.show-partnar') }}" class="group flex items-center px-3 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 hover:bg-primaryGreen/10 dark:hover:bg-primaryGreen/20 hover:text-primaryGreen dark:hover:text-emerald-400 rounded-lg transition-colors duration-150">
                                                    <div class="w-7 h-7 bg-primaryGreen/10 dark:bg-primaryGreen/20 rounded-md flex items-center justify-center mr-2 group-hover:scale-110 transition-transform duration-200">
                                                        <svg class="w-3.5 h-3.5 text-primaryGreen dark:text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                                        </svg>
                                                    </div>
                                                    <div class="flex-1">
                                                        <p class="font-medium">Institution Profile</p>
                                                    </div>
                                                    <svg class="w-4 h-4 text-gray-400 group-hover:text-primaryGreen" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                                    </svg>
                                                </a>
                                                
                                                <a href="{{ route('partner.profile.edit-partnar') }}" class="group flex items-center px-3 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 hover:bg-orange-100 dark:hover:bg-orange-900/30 hover:text-orange-700 dark:hover:text-orange-400 rounded-lg transition-colors duration-150">
                                                    <div class="w-7 h-7 bg-orange-100 dark:bg-orange-900/50 rounded-md flex items-center justify-center mr-2 group-hover:scale-110 transition-transform duration-200">
                                                        <svg class="w-3.5 h-3.5 text-orange-600 dark:text-orange-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                                        </svg>
                                                    </div>
                                                    <div class="flex-1">
                                                        <p class="font-medium">Edit Institution</p>
                                                    </div>
                                                    <svg class="w-4 h-4 text-gray-400 group-hover:text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                                    </svg>
                                                </a>
                                            </div>
                                        </div>
                                        
                                        <!-- User Section -->
                                        <div class="mb-1">
                                            <p class="px-3 py-1 text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Personal</p>
                                            <div class="space-y-1">
                                                <a href="{{ route('partner.profile.show-user-profile') }}" class="group flex items-center px-3 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 hover:bg-blue-100 dark:hover:bg-blue-900/30 hover:text-blue-700 dark:hover:text-blue-400 rounded-lg transition-colors duration-150">
                                                    <div class="w-7 h-7 bg-blue-100 dark:bg-blue-900/50 rounded-md flex items-center justify-center mr-2 group-hover:scale-110 transition-transform duration-200">
                                                        <svg class="w-3.5 h-3.5 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                                        </svg>
                                                    </div>
                                                    <div class="flex-1">
                                                        <p class="font-medium">User Profile</p>
                                                    </div>
                                                    <svg class="w-4 h-4 text-gray-400 group-hover:text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                                    </svg>
                                                </a>
                                                
                                                <a href="{{ route('partner.profile.edit-user-profile') }}" class="group flex items-center px-3 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 hover:bg-purple-100 dark:hover:bg-purple-900/30 hover:text-purple-700 dark:hover:text-purple-400 rounded-lg transition-colors duration-150">
                                                    <div class="w-7 h-7 bg-purple-100 dark:bg-purple-900/50 rounded-md flex items-center justify-center mr-2 group-hover:scale-110 transition-transform duration-200">
                                                        <svg class="w-3.5 h-3.5 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                                        </svg>
                                                    </div>
                                                    <div class="flex-1">
                                                        <p class="font-medium">Edit User Profile</p>
                                                    </div>
                                                    <svg class="w-4 h-4 text-gray-400 group-hover:text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                                    </svg>
                                                </a>
                                                
                                                <a href="#" class="group flex items-center px-3 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 hover:bg-green-100 dark:hover:bg-green-900/30 hover:text-green-700 dark:hover:text-green-400 rounded-lg transition-colors duration-150">
                                                    <div class="w-7 h-7 bg-green-100 dark:bg-green-900/50 rounded-md flex items-center justify-center mr-2 group-hover:scale-110 transition-transform duration-200">
                                                        <svg class="w-3.5 h-3.5 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                                        </svg>
                                                    </div>
                                                    <div class="flex-1">
                                                        <p class="font-medium">Teacher</p>
                                                    </div>
                                                    <svg class="w-4 h-4 text-gray-400 group-hover:text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                                    </svg>
                                                </a>
                                            </div>
                                        </div>
                                        
                                        <!-- System Section -->
                                        <div class="mb-1">
                                            <p class="px-3 py-1 text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">System</p>
                                            <div class="space-y-1">
                                                @if(auth()->check())
                                                <a href="{{ route('partner.settings.index') }}" class="group flex items-center px-3 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 hover:text-gray-900 dark:hover:text-white rounded-lg transition-colors duration-150">
                                                    <div class="w-7 h-7 bg-gray-100 dark:bg-gray-700 rounded-md flex items-center justify-center mr-2 group-hover:scale-110 transition-transform duration-200">
                                                        <svg class="w-3.5 h-3.5 text-gray-600 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                        </svg>
                                                    </div>
                                                    <div class="flex-1">
                                                        <p class="font-medium">Settings</p>
                                                    </div>
                                                    <svg class="w-4 h-4 text-gray-400 group-hover:text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                                    </svg>
                                                </a>
                                                @endif
                                            </div>
                                        </div>
                                        
                                        <!-- Logout Section -->
                                        <div class="border-t border-gray-200 dark:border-gray-700 pt-2 mt-2">
                                            <form method="POST" action="{{ route('logout') }}" class="block">
                                                @csrf
                                                <button type="submit" class="group w-full flex items-center px-3 py-2 text-sm font-medium text-red-600 dark:text-red-400 hover:bg-red-100 dark:hover:bg-red-900/30 hover:text-red-700 dark:hover:text-red-300 rounded-lg transition-colors duration-150">
                                                    <div class="w-7 h-7 bg-red-100 dark:bg-red-900/50 rounded-md flex items-center justify-center mr-2 group-hover:scale-110 transition-transform duration-200">
                                                        <svg class="w-3.5 h-3.5 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                                                        </svg>
                                                    </div>
                                                    <div class="flex-1 text-left">
                                                        <p class="font-medium">Logout</p>
                                                    </div>
                                                    <svg class="w-4 h-4 text-red-400 group-hover:text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                                    </svg>
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Page Content -->
            <div class="flex-1 overflow-y-auto custom-scrollbar bg-gray-50 dark:bg-gray-900">
                <div class="p-4 lg:p-6 xl:p-8 max-w-7xl mx-auto safe-bottom">
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
                </div>
            </div>
        </main>
    </div>

    <!-- JavaScript -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const sidebar = document.getElementById('sidebar');
            const sidebarToggle = document.getElementById('sidebar-toggle');
            const sidebarClose = document.getElementById('sidebar-close');
            const sidebarBackdrop = document.getElementById('sidebar-backdrop');

            // Toggle sidebar
            function toggleSidebar() {
                sidebar.classList.toggle('open');
                sidebarBackdrop.classList.toggle('active');
                document.body.classList.toggle('overflow-hidden');
            }

            // Close sidebar
            function closeSidebar() {
                sidebar.classList.remove('open');
                sidebarBackdrop.classList.remove('active');
                document.body.classList.remove('overflow-hidden');
            }

            // Event listeners
            if (sidebarToggle) {
                sidebarToggle.addEventListener('click', toggleSidebar);
            }

            if (sidebarClose) {
                sidebarClose.addEventListener('click', closeSidebar);
            }

            if (sidebarBackdrop) {
                sidebarBackdrop.addEventListener('click', closeSidebar);
            }

            // Close sidebar on navigation (mobile)
            const navLinks = sidebar?.querySelectorAll('a');
            navLinks?.forEach(link => {
                link.addEventListener('click', () => {
                    if (window.innerWidth < 1024) {
                        closeSidebar();
                    }
                });
            });

            // Handle window resize
            let resizeTimer;
            window.addEventListener('resize', () => {
                clearTimeout(resizeTimer);
                resizeTimer = setTimeout(() => {
                    if (window.innerWidth >= 1024) {
                        closeSidebar();
                    }
                }, 250);
            });

            // Prevent body scroll when sidebar is open on mobile
            const observer = new MutationObserver(() => {
                if (sidebar?.classList.contains('open') && window.innerWidth < 1024) {
                    document.body.style.overflow = 'hidden';
                } else {
                    document.body.style.overflow = '';
                }
            });

            if (sidebar) {
                observer.observe(sidebar, { attributes: true, attributeFilter: ['class'] });
            }

            // Theme management
            const htmlTag = document.documentElement;
            const currentTheme = localStorage.getItem('theme');
            
            if (currentTheme) {
                htmlTag.classList.add(currentTheme);
            } else if (window.matchMedia('(prefers-color-scheme: dark)').matches) {
                htmlTag.classList.add('dark');
                localStorage.setItem('theme', 'dark');
            }

            // Optional: Add theme toggle button handler if you have one
            const themeToggle = document.getElementById('theme-toggle');
            if (themeToggle) {
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
        });
    </script>

    @stack('scripts')
</body>
</html>
