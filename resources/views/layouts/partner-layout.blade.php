<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+Bengali:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

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

        /* Layout for Desktop and Mobile */
        .sidebar-container {
            position: fixed;
            top: 0;
            left: 0;
            height: 100vh;
            z-index: 50;
            width: 16rem; /* Tailwind's w-64 */
            transform: translateX(0); /* Default for desktop */
            transition: transform 0.3s ease-in-out;
            box-shadow: 0 4px 12px rgba(0,0,0,0.25);
        }

        /* Dark mode styles for full view */
        .dark .sidebar-container {
            background: #111827;
            border-color: #374151;
        }

        .dark .main-content-wrapper {
            background: #111827;
        }

        .dark body {
            background: #111827;
        }

        .dark html {
            background: #111827;
        }

        .dark .min-h-screen {
            background: #111827;
        }

        .main-content-wrapper, .sticky-top-bar {
            margin-left: 0;
            transition: margin-left 0.3s ease-in-out;
        }

        /* Ensure top bar is properly contained within main content wrapper */
        .main-content-wrapper {
            position: relative;
            overflow-x: hidden;
        }

        /* Desktop Styles (lg breakpoint) */
        @media (min-width: 1024px) {
            .sidebar-container {
                box-shadow: none; /* No shadow on desktop */
            }
            .main-content-wrapper {
                margin-left: 16rem !important; /* Align with sidebar width - force override */
            }
            .sticky-top-bar {
                margin-left: 0; /* Reset margin for top bar since it's inside main-content-wrapper */
                width: 100%; /* Take full width of its container */
            }
            .sticky-top-bar > div {
                max-width: 100%; /* Ensure inner content doesn't overflow */
            }

            #sidebar-toggle {
                display: none !important; /* Hide hamburger on desktop */
            }
        }

        /* Mobile Styles (up to lg breakpoint) */
        @media (max-width: 1023px) {
            .sidebar-container {
                transform: translateX(-100%); /* Hide sidebar by default on mobile */
            }
            .sidebar-container.open {
                transform: translateX(0); /* Show sidebar when 'open' class is present */
            }
            #sidebar-toggle {
                display: block !important; /* Show hamburger on mobile */
                position: fixed;
                top: 1rem;
                right: 1rem;
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

        /* Mobile Sidebar Backdrop */
        #sidebar-backdrop {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 40;
            display: none; /* Hidden by default */
        }
        #sidebar-backdrop.active {
            display: block; /* Show when active */
        }

        /* Mobile top bar styles */
        .mobile-top-bar {
            position: sticky;
            top: 0;
            z-index: 60;
            background: white;
            border-bottom: 1px solid #e5e7eb;
        }

        .dark .mobile-top-bar {
            background: #111827;
            border-color: #374151;
        }

        /* Sticky top bar styles */
        .sticky-top-bar {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 50;
            background: white;
            border-bottom: 1px solid #e5e7eb;
            box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06);
        }

        .dark .sticky-top-bar {
            background: #111827;
            border-color: #374151;
        }

        /* Adjust main content to account for fixed top bar */
        .main-content-wrapper {
            padding-top: 120px; /* Account for single top bar */
        }

        /* Mobile specific adjustments */
        @media (max-width: 1023px) {
            .sticky-top-bar {
                top: 0; /* At the very top on mobile */
                left: 0; /* Full width on mobile */
                right: 0;
            }

            .main-content-wrapper {
                padding-top: 120px; /* Account for single sticky bar */
            }
        }

        /* Desktop specific adjustments */
        @media (min-width: 1024px) {
            .mobile-top-bar {
                display: none; /* Hide on desktop */
            }

            .sticky-top-bar {
                top: 0; /* At very top on desktop */
                left: 16rem; /* Start where sidebar ends */
                right: 0;
            }

            .main-content-wrapper {
                padding-top: 120px; /* Account for single sticky top bar */
            }
        }

        /* Mobile touch improvements */
        @media (max-width: 1023px) {
            .mobile-top-bar button {
                min-height: 44px;
                min-width: 44px;
            }

            .mobile-top-bar .group:hover .group-hover\:opacity-100 {
                opacity: 1;
                visibility: visible;
            }
        }

        /* Dark mode for main content area */
        .dark .main-content-wrapper {
            background: #111827;
        }

        .dark main {
            background: #111827;
        }

        /* Ensure right-aligned menu items are always visible */
        /* UPDATED: This block now uses flexbox properties for correct positioning */
        .sticky-top-bar .flex.items-center.justify-between {
            position: relative;
            min-width: 0;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        
        .sticky-top-bar .flex.items-center.justify-between > div:first-child {
            min-width: 0;
            flex-shrink: 1;
            max-width: calc(100% - 400px);
        }
        
        .sticky-top-bar .flex.items-center.justify-between > div:last-child {
            min-width: 0;
            flex-shrink: 0;
            position: static; /* Fixed: Remove absolute positioning */
            transform: none; /* Fixed: Remove transform */
            background: transparent; /* Fixed: Remove white background */
            padding: 0; /* Fixed: Remove padding */
            border-radius: 0; /* Fixed: Remove border-radius */
            box-shadow: none; /* Fixed: Remove box-shadow */
            z-index: 10;
        }
        
        /* Dark mode support */
        .dark .sticky-top-bar .flex.items-center.justify-between > div:last-child {
            background: transparent;
            box-shadow: none;
        }
        
        /* Mobile adjustments */
        @media (max-width: 1023px) {
            .sticky-top-bar .flex.items-center.justify-between {
                flex-direction: column;
                align-items: flex-start;
                gap: 1rem;
            }
            
            .sticky-top-bar .flex.items-center.justify-between > div:first-child {
                align-self: flex-start;
                width: 100%;
                max-width: 100%;
            }
            
            .sticky-top-bar .flex.items-center.justify-between > div:last-child {
                position: static;
                transform: none;
                background: transparent;
                box-shadow: none;
                width: 100%;
                justify-content: center;
                margin-top: 1rem;
            }
            
            /* Ensure quick stats are visible on mobile */
            .sticky-top-bar .flex.items-center.space-x-2 {
                display: flex !important;
                flex-wrap: wrap;
                gap: 0.5rem;
                width: 100%;
                justify-content: center;
            }
            
            /* Ensure action buttons are visible on mobile */
            .sticky-top-bar .flex.items-center.space-x-3 {
                display: flex !important;
                flex-wrap: nowrap !important;
                gap: 0.25rem;
                width: auto;
                min-width: fit-content;
                justify-content: flex-end;
                overflow-x: auto;
            }
        }

        /* Grid-based layout for better control */
        .sticky-top-bar .grid {
            width: 100%;
        }
        
        /* Ensure left side doesn't overflow */
        .sticky-top-bar .lg\:col-span-8 {
            min-width: 0;
            overflow: hidden;
        }
        
        /* Ensure right side is always visible */
        .sticky-top-bar .lg\:col-span-4 {
            min-width: 0;
            flex-shrink: 0;
        }
        
        /* Mobile adjustments */
        @media (max-width: 1023px) {
            .sticky-top-bar .grid {
                grid-template-columns: 1fr;
                gap: 1rem;
            }
            
            .sticky-top-bar .lg\:col-span-8 {
                order: 1;
            }
            
            .sticky-top-bar .lg\:col-span-4 {
                order: 2;
                justify-content: center;
                width: 100%;
            }
        }

        /* Hide sideNavToggler button on desktop */
        @media (min-width: 1024px) {
            #sideNavToggler {
                display: none !important;
                visibility: hidden !important;
                opacity: 0 !important;
                pointer-events: none !important;
            }
        }

        /* Hide quick stats container on mobile */
        @media (max-width: 1023px) {
            .sticky-top-bar .flex.items-center.space-x-2 {
                display: none !important;
                visibility: hidden !important;
                opacity: 0 !important;
                height: 0 !important;
                overflow: hidden !important;
            }
        }
    </style>
</head>
<body class="font-sans antialiased">
    <div class="min-h-screen bg-gray-100 flex">
        <div id="sidebar" class="sidebar-container bg-white dark:bg-gray-900 border-r border-gray-200 dark:border-gray-700">
            <div class="flex flex-col flex-grow pt-5 h-full overflow-y-auto">
                <div class="flex flex-col items-center flex-shrink-0 px-6 mb-5">
                    <a href="{{ route('partner.dashboard') }}" class="w-12 h-12 bg-gradient-to-br from-primaryGreen to-emerald-500 rounded-xl flex items-center justify-center shadow-lg mb-4 transform hover:scale-110 transition-all duration-300 overflow-hidden">
                        <img src="{{ asset('images/logo.png') }}" alt="Logo" class="w-8 h-8 object-contain">
                    </a>
                    <div id="logo-text" class="text-center transition-all duration-300">
                        <h1 class="text-2xl font-extrabold bg-gradient-to-r from-primaryGreen via-emerald-600 to-blue-600 bg-clip-text text-transparent drop-shadow-sm hover:drop-shadow-md transition-all duration-300 font-bengali p-0 m-0">বিকল্প পাঠশালা</h1>
                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-1 font-medium">Partner Portal</p>
                    </div>
                </div>

                <nav class="flex-1 px-4">
                    <a href="{{ route('partner.dashboard') }}"
                       class="group flex items-center px-3 py-3 text-sm font-medium rounded-lg transition-all duration-200 {{ request()->routeIs('partner.dashboard') ? 'bg-primaryGreen/10 text-primaryGreen border border-primaryGreen/20' : 'text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800 hover:text-gray-900 dark:hover:text-white' }}">
                        <svg class="h-5 w-5 {{ request()->routeIs('partner.dashboard') ? 'text-primaryGreen' : 'text-gray-400 group-hover:text-gray-500' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 01-2-2z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5a2 2 0 012-2h4a2 2 0 012 2v6H8V5z"></path>
                        </svg>
                        <span id="nav-dashboard" class="ml-3 transition-all duration-300">Dashboard</span>
                    </a>

                    <a href="{{ route('partner.questions.all') }}"
                       class="group flex items-center px-3 py-3 text-sm font-medium rounded-lg transition-all duration-200 {{ request()->routeIs('partner.questions.*') ? 'bg-primaryGreen/10 text-primaryGreen border border-primaryGreen/20' : 'text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800 hover:text-gray-900 dark:hover:text-white' }}">
                        <svg class="h-5 w-5 {{ request()->routeIs('partner.questions.*') ? 'text-primaryGreen' : 'text-gray-400 group-hover:text-gray-500' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <span id="nav-questions" class="ml-3 transition-all duration-300">Questions</span>
                    </a>

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
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                        <span id="nav-partners" class="ml-3 transition-all duration-300">Partners</span>
                    </a>
                </nav>

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

        <div id="sidebar-backdrop" class="lg:hidden"></div>

        <div class="main-content-wrapper flex-1 flex flex-col">
            <div class="sticky-top-bar">
                <div class="px-8 py-6">
                    <div class="flex items-center justify-between mobile-layout">
                        <div class="flex items-center space-x-8 mobile-content">
                            <div class="flex items-center space-x-4">
                                <div class="w-8 h-8 lg:w-12 lg:h-12 flex items-center justify-center">
                                    @if(!empty($partner?->logo))
                                        <img src="{{ asset('storage/' . $partner->logo) }}" alt="Partner Logo" class="w-8 h-8 lg:w-12 lg:h-12 object-cover">
                                    @else
                                        <svg class="w-4 h-4 lg:w-6 lg:h-6 text-gray-600 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                        </svg>
                                    @endif
                                </div>
                                <div>
                                    <h2 class="text-lg lg:text-2xl font-semibold text-gray-900 dark:text-white whitespace-nowrap">
                                        Welcome back,<br/> <span class="text-blue-600 dark:text-blue-400 whitespace-nowrap">{{ $partner?->slug ?? $partner?->name ?? Auth::user()->name ?? 'Partner' }}</span>
                                    </h2>
                                    <p class="text-gray-600 dark:text-gray-400 text-xs lg:text-sm">Manage your exam system efficiently</p>
                                </div>
                            </div>

                            <div class="w-px h-12 bg-gray-300 dark:bg-gray-600"></div>

                            <div class="flex items-center space-x-2" style="padding: 4px;">
                                <div class="text-center">
                                    <div class="flex items-center space-x-1 lg:space-x-2">
                                        <div class="w-6 h-6 lg:w-8 lg:h-8 bg-orange-100 dark:bg-orange-900/30 rounded-lg flex items-center justify-center">
                                            <svg class="w-3 h-3 lg:w-4 lg:h-4 text-orange-600 dark:text-orange-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                            </svg>
                                        </div>
                                        <div class="text-left">
                                            <p class="text-lg lg:text-2xl font-bold text-orange-600 dark:text-orange-400">{{ $stats['total_courses'] ?? 0 }}</p>
                                            <p class="text-xs text-gray-500 dark:text-gray-400">Courses</p>
                                        </div>
                                    </div>
                                </div>

                                <div class="w-px h-8 lg:h-10 bg-gray-300 dark:bg-gray-600"></div>

                                <div class="text-center">
                                    <div class="flex items-center space-x-1 lg:space-x-2">
                                        <div class="w-6 h-6 lg:w-8 lg:h-8 bg-indigo-100 dark:bg-indigo-900/30 rounded-lg flex items-center justify-center">
                                            <svg class="w-3 h-3 lg:w-4 lg:h-4 text-indigo-600 dark:text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                                            </svg>
                                        </div>
                                        <div class="text-left">
                                            <p class="text-lg lg:text-2xl font-bold text-indigo-600 dark:text-indigo-400">{{ $stats['total_batches'] ?? 0 }}</p>
                                            <p class="text-xs text-gray-500 dark:text-gray-400">Batches</p>
                                        </div>
                                    </div>
                                </div>

                                <div class="w-px h-8 lg:h-10 bg-gray-300 dark:bg-gray-600"></div>

                                <div class="text-center">
                                    <div class="flex items-center space-x-1 lg:space-x-2">
                                        <div class="w-6 h-6 lg:w-8 lg:h-8 bg-emerald-100 dark:bg-emerald-900/30 rounded-lg flex items-center justify-center">
                                            <svg class="w-3 h-3 lg:w-4 lg:h-4 text-emerald-600 dark:text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                        </div>
                                        <div class="text-left">
                                            <p class="text-lg lg:text-2xl font-bold text-emerald-600 dark:text-emerald-400">{{ $stats['total_questions'] ?? 0 }}</p>
                                            <p class="text-xs text-gray-500 dark:text-gray-400">Questions</p>
                                        </div>
                                    </div>
                                </div>

                                <div class="w-px h-8 lg:h-10 bg-gray-300 dark:bg-gray-600"></div>

                                <div class="text-center">
                                    <div class="flex items-center space-x-1 lg:space-x-2">
                                        <div class="w-6 h-6 lg:w-8 lg:h-8 bg-blue-100 dark:bg-blue-900/30 rounded-lg flex items-center justify-center">
                                            <svg class="w-3 h-3 lg:w-4 lg:h-4 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                                            </svg>
                                        </div>
                                        <div class="text-left">
                                            <p class="text-lg lg:text-2xl font-bold text-blue-600 dark:text-blue-400">{{ $stats['total_exams'] ?? 0 }}</p>
                                            <p class="text-xs text-gray-500 dark:text-gray-400">Exams</p>
                                        </div>
                                    </div>
                                </div>

                                <div class="w-px h-8 lg:h-10 bg-gray-300 dark:bg-gray-600"></div>

                                <div class="text-center">
                                    <div class="flex items-center space-x-1 lg:space-x-2">
                                        <div class="w-6 h-6 lg:w-8 lg:h-8 bg-purple-100 dark:bg-purple-900/30 rounded-lg flex items-center justify-center">
                                            <svg class="w-3 h-3 lg:w-4 lg:h-4 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                                            </svg>
                                        </div>
                                        <div class="text-left">
                                            <p class="text-lg lg:text-2xl font-bold text-purple-600 dark:text-purple-400">{{ $stats['total_students'] ?? 0 }}</p>
                                            <p class="text-xs text-gray-500 dark:text-gray-400">Students</p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="flex items-center space-x-3">
                                <button class="relative p-2 text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white hover:bg-gray-100 dark:hover:bg-gray-800 rounded-lg transition-all duration-200 lg:block hidden">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
                                    </svg>
                                    <span class="absolute -top-1 -right-1 w-4 h-4 bg-red-500 rounded-full flex items-center justify-center">
                                        <span class="text-xs font-bold text-white text-[10px]">3</span>
                                    </span>
                                </button>

                                <button id="theme-toggle" class="p-2 text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white hover:bg-gray-100 dark:hover:bg-gray-800 rounded-lg transition-all duration-200 lg:block hidden">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m8.66-13.66l-.71.71M4.05 19.95l.71-.71M21 12h-1M4 12H3m16.95 7.95l-.71-.71M4.05 4.05l.71.71M16 12a4 4 0 11-8 0 4 4 0 018 0z"></path>
                                    </svg>
                                </button>

                                <div class="relative group lg:block hidden">
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
                                
                                <!-- SideNavToggler Button - Visible only on mobile -->
                                <button id="sideNavToggler" class="lg:hidden p-4 text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white hover:bg-gray-100 dark:hover:bg-gray-800 rounded-lg transition-all duration-200">
                                    <svg class="w-12 h-12" viewBox="0 0 24 24">
                                        <defs>
                                            <linearGradient id="skyblueGradient" x1="0%" y1="0%" x2="100%" y2="100%">
                                                <stop offset="0%" style="stop-color:#87CEEB;stop-opacity:1" />
                                                <stop offset="100%" style="stop-color:#4682B4;stop-opacity:1" />
                                            </linearGradient>
                                        </defs>
                                        <circle cx="12" cy="12" r="10" fill="url(#skyblueGradient)" />
                                        <line x1="6" y1="8" x2="18" y2="8" stroke="white" stroke-width="2" stroke-linecap="round" />
                                        <line x1="7" y1="12" x2="17" y2="12" stroke="white" stroke-width="2" stroke-linecap="round" />
                                        <line x1="6" y1="16" x2="18" y2="16" stroke="white" stroke-width="2" stroke-linecap="round" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="border-t border-gray-200 dark:border-gray-700"></div>
                </div>

                <div class="border-t border-gray-200 dark:border-gray-700"></div>
            </div>

            <main class="flex-1 overflow-y-auto px-6 pb-6 pt-6">
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

        <script>
            document.addEventListener('DOMContentLoaded', () => {
                const sidebar = document.getElementById('sidebar');
                const sidebarToggle = document.getElementById('sidebar-toggle');
                const sidebarBackdrop = document.getElementById('sidebar-backdrop');
                const themeToggle = document.getElementById('theme-toggle');
                const mobileThemeToggle = document.getElementById('mobile-theme-toggle');
                const htmlTag = document.documentElement;

                // Handle mobile sidebar toggle
                if (sidebarToggle && sidebar && sidebarBackdrop) {
                    sidebarToggle.addEventListener('click', () => {
                        sidebar.classList.toggle('open');
                        sidebarBackdrop.classList.toggle('active');
                        document.body.classList.toggle('overflow-hidden');
                    });

                    sidebarBackdrop.addEventListener('click', () => {
                        sidebar.classList.remove('open');
                        sidebarBackdrop.classList.remove('active');
                        document.body.classList.remove('overflow-hidden');
                    });
                }

                // Handle window resize to manage mobile vs desktop view
                function handleResize() {
                    if (window.innerWidth >= 1024) {
                        // Desktop view
                        sidebar.classList.remove('open');
                        sidebarBackdrop.classList.remove('active');
                        document.body.classList.remove('overflow-hidden');
                    }
                }

                window.addEventListener('resize', handleResize);
                handleResize(); // Initial check on load

                // Theme toggle function
                function toggleTheme() {
                    if (htmlTag.classList.contains('dark')) {
                        htmlTag.classList.remove('dark');
                        localStorage.setItem('theme', 'light');
                    } else {
                        htmlTag.classList.add('dark');
                        localStorage.setItem('theme', 'dark');
                    }
                }

                // Theme toggle for desktop
                if (themeToggle) {
                    const currentTheme = localStorage.getItem('theme');
                    if (currentTheme) {
                        htmlTag.classList.add(currentTheme);
                    } else if (window.matchMedia('(prefers-color-scheme: dark)').matches) {
                        htmlTag.classList.add('dark');
                    }

                    themeToggle.addEventListener('click', toggleTheme);
                }

                // Theme toggle for mobile
                if (mobileThemeToggle) {
                    mobileThemeToggle.addEventListener('click', toggleTheme);
                }
            });
        </script>

        @stack('scripts')
    </body>
    </html>