<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="theme-color" content="#10b981">
    <title>{{ config('app.name', 'BokolpoLive') }}</title>

    <!-- Favicon -->
    <link rel="icon" href="{{ asset('images/BikolpoLive.svg') }}" type="image/svg+xml">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('images/favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('images/favicon-16x16.png') }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('images/apple-touch-icon-180x180.png') }}">
    <link rel="mask-icon" href="{{ asset('images/BikolpoLive.svg') }}" color="#10b981">

    <!-- Fonts - Using our custom Inter + HindSiliguri setup -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <!-- Font Fix CSS (load first) -->
    <link href="{{ asset('css/font-fix.css') }}" rel="stylesheet">
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Font Loading Debug & Fix -->
    <script>
        // Enhanced font loading detection and debugging
        document.addEventListener('DOMContentLoaded', function() {
            // Test content for font verification
            const testText = 'Test আমি বাংলায় গান গাই English 123';
            console.log('🎨 Font Debug: Testing text = ', testText);
            
            // Check if browser supports font loading API
            if (document.fonts) {
                document.fonts.ready.then(function() {
                    console.log('✅ Font API: All fonts loaded successfully');
                    
                    // Additional verification
                    const testDiv = document.createElement('div');
                    testDiv.style.fontFamily = "Inter, 'Hind Siliguri', system-ui, sans-serif";
                    testDiv.textContent = testText;
                    testDiv.style.position = 'absolute';
                    testDiv.style.visibility = 'hidden';
                    document.body.appendChild(testDiv);
                    
                    const computedStyle = window.getComputedStyle(testDiv);
                    console.log('🎭 Computed font-family:', computedStyle.fontFamily);
                    
                    document.body.removeChild(testDiv);
                }).catch(function(error) {
                    console.error('❌ Font loading error:', error);
                    document.body.classList.add('font-fallback');
                });
            } else {
                console.warn('⚠️ Font Loading API not supported, using fallback detection');
                
                // Fallback detection for older browsers
                setTimeout(function() {
                    console.log('🔄 Applying safety fallback fonts');
                    document.body.classList.add('font-fallback');
                }, 3000);
            }
            
            // Debug SVG icons
            const svgElements = document.querySelectorAll('svg use');
            console.log(`🎯 Found ${svgElements.length} SVG icons`);
            
            // Report any text nodes that might be showing symbols
            setTimeout(function() {
                const allText = document.body.innerText;
                const hasWeirdSymbols = /[\u{1F300}-\u{1F9FF}]|[\u{2600}-\u{26FF}]|[\u{2700}-\u{27BF}]/u.test(allText);
                if (hasWeirdSymbols) {
                    console.warn('⚠️ Potential symbol/emoji detected in text - check for font loading issues');
                }
            }, 1000);
        });
    </script>
    
    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <style>
        /* Force proper font rendering */
        body, html {
            font-family: 'Inter', 'Hind Siliguri', ui-sans-serif, system-ui, sans-serif;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
            text-rendering: optimizeLegibility;
        }
        
        /* Bengali/Bangla Font */
        .font-bengali, .font-bangla {
            font-family: 'Hind Siliguri', ui-sans-serif, system-ui, sans-serif;
        }
        
        /* English Font */
        .font-english {
            font-family: 'Inter', ui-sans-serif, system-ui, sans-serif;
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

        /* Smooth transitions for elements */
        * {
            transition-property: color, background-color, border-color, outline-color, text-decoration-color, fill, stroke;
            transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
            transition-duration: 150ms;
        }

        /* Alpine.js cloak */
        [x-cloak] {
            display: none !important;
        }
    </style>
</head>
<body class="h-full bg-gray-50 dark:bg-gray-900">
    @php
        $user = Auth::user();
        $role = strtolower($user->role ?? '');
        $homeRouteName = 'partner.dashboard';
        if ($role === 'student') {
            $homeRouteName = 'student.dashboard';

        }
    @endphp
    <!-- SVG Sprites -->
    @include('partials.svg-sprites')
    
    <!-- Mobile Backdrop -->
    <div id="sidebar-backdrop" class="sidebar-backdrop lg:hidden"></div>

    <!-- Layout Container -->
    <div class="flex h-full">
        <!-- Left Sidebar Navigation (Collapsible) -->
        <aside id="sidebar" class="mobile-sidebar w-64 lg:w-72 border-r border-slate-700 flex flex-col" style="background-color: #0F172A;">
            <div class="flex flex-col h-full overflow-y-auto custom-scrollbar">
                <!-- Sidebar Header -->
                <div class="relative px-4 py-4 border-b" style="border-color: #1E293B;">
                    <div class="flex items-center justify-between">
                        <a href="{{ route('system-admin.system-admin-dashboard') }}" class="flex items-center space-x-3 group flex-1 min-w-0">
                            <div class="relative flex-shrink-0">
                                <div class="w-12 h-12 bg-white dark:bg-gray-800 rounded-xl flex items-center justify-center shadow-lg ring-2 ring-primaryGreen/20 group-hover:ring-primaryGreen/40 transition-all duration-300 group-hover:scale-105 overflow-hidden">
                                    <img src="{{ asset('images/BikolpoLive.svg') }}" alt="Bikolpo Live" class="w-full h-full object-contain p-1">
                                </div>
                                <div class="absolute -top-0.5 -right-0.5 w-2.5 h-2.5 bg-emerald-400 rounded-full animate-pulse"></div>
                            </div>
                            <div class="flex flex-col min-w-0 flex-1">
                                <h2 class="text-lg font-extrabold tracking-tight leading-tight" style="color: #F1F5F9;">
                                    Bikolpo Live
                                </h2>
                                <p class="text-xs font-medium" style="color: #F1F5F9;">Super User Dashboard</p>
                            </div>
                        </a>
                        <!-- Close button for mobile -->
                        <button id="sidebar-close" class="lg:hidden p-1.5 rounded-lg transition-all duration-200 flex-shrink-0" style="color: #F1F5F9;" onmouseover="this.style.backgroundColor='#15803D'" onmouseout="this.style.backgroundColor='transparent'">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>
                </div>

                <!-- Navigation -->
                <nav class="flex-1 px-3 py-4 space-y-2">
                    <!-- Dashboard Overview -->
                    <div class="mb-6">
                        <h3 class="px-3 text-xs font-semibold uppercase tracking-wider mb-3" style="color: #F1F5F9;">Main Sections</h3>
                        
                        <a href="{{ route('system-admin.system-admin-dashboard') }}"
                           class="group flex items-center px-3 py-2.5 text-sm font-semibold rounded-lg transition-all duration-200"
                           style="{{ request()->routeIs('system-admin.system-admin-dashboard') ? 'background-color: #16A34A; color: #F1F5F9;' : 'color: #F1F5F9;' }}"
                           onmouseover="if (!this.classList.contains('active')) { this.style.backgroundColor = '#15803D'; }"
                           onmouseout="if (!this.classList.contains('active')) { this.style.backgroundColor = 'transparent'; }">
                            <div class="w-8 h-8 flex-shrink-0 rounded-lg flex items-center justify-center transition-all duration-200"
                                 style="{{ request()->routeIs('system-admin.system-admin-dashboard') ? 'background-color: rgba(241, 245, 249, 0.2);' : 'background-color: rgba(241, 245, 249, 0.1);' }}">
                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="color: #F1F5F9;">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                            </svg>
                        </div>
                            <span class="ml-3 flex-1">Dashboard Overview</span>
                        </a>
                    </div>

                    <!-- User Management -->
                    <div class="mb-6" x-data="{ open: true }">
                        <button @click="open = !open" class="w-full flex items-center justify-between px-3 py-2 text-xs font-semibold uppercase tracking-wider transition-colors" style="color: #F1F5F9;" onmouseover="this.style.color='#15803D'" onmouseout="this.style.color='#F1F5F9'">
                            <span>User Management</span>
                            <svg class="w-4 h-4 transition-transform duration-200" :class="{ 'rotate-180': open }" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="color: #F1F5F9;">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>
                        
                        <div x-show="open" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 -translate-y-2" x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 -translate-y-2" class="space-y-1 mt-2">
                            <a href="#" class="group flex items-center px-3 py-2.5 text-sm font-medium rounded-lg transition-all duration-200" style="color: #F1F5F9;" onmouseover="this.style.backgroundColor='#15803D'" onmouseout="this.style.backgroundColor='transparent'">
                                <div class="w-8 h-8 flex-shrink-0 rounded-lg flex items-center justify-center transition-all duration-200" style="background-color: rgba(241, 245, 249, 0.1);">
                                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="color: #F1F5F9;">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                            </svg>
                        </div>
                                <span class="ml-3 flex-1">Students List</span>
                            </a>
                            
                            <a href="#" class="group flex items-center px-3 py-2.5 text-sm font-medium rounded-lg transition-all duration-200" style="color: #F1F5F9;" onmouseover="this.style.backgroundColor='#15803D'" onmouseout="this.style.backgroundColor='transparent'">
                                <div class="w-8 h-8 flex-shrink-0 rounded-lg flex items-center justify-center transition-all duration-200" style="background-color: rgba(241, 245, 249, 0.1);">
                                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="color: #F1F5F9;">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                            </svg>
                        </div>
                                <span class="ml-3 flex-1">Partners / Coaching Centers</span>
                            </a>
                            
                            <a href="#" class="group flex items-center px-3 py-2.5 text-sm font-medium rounded-lg transition-all duration-200" style="color: #F1F5F9;" onmouseover="this.style.backgroundColor='#15803D'" onmouseout="this.style.backgroundColor='transparent'">
                                <div class="w-8 h-8 flex-shrink-0 rounded-lg flex items-center justify-center transition-all duration-200" style="background-color: rgba(241, 245, 249, 0.1);">
                                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="color: #F1F5F9;">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                            </svg>
                        </div>
                                <span class="ml-3 flex-1">Admin / Moderator Roles</span>
                            </a>
                            
                            <a href="#" class="group flex items-center px-3 py-2.5 text-sm font-medium rounded-lg transition-all duration-200" style="color: #F1F5F9;" onmouseover="this.style.backgroundColor='#15803D'" onmouseout="this.style.backgroundColor='transparent'">
                                <div class="w-8 h-8 flex-shrink-0 rounded-lg flex items-center justify-center transition-all duration-200" style="background-color: rgba(241, 245, 249, 0.1);">
                                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="color: #F1F5F9;">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
                            </svg>
                        </div>
                                <span class="ml-3 flex-1">Activity Logs</span>
                            </a>
                        </div>
                    </div>

                    <!-- MCQ & Test Management -->
                    <div class="mb-6" x-data="{ open: true }">
                        <button @click="open = !open" class="w-full flex items-center justify-between px-3 py-2 text-xs font-semibold uppercase tracking-wider transition-colors" style="color: #F1F5F9;" onmouseover="this.style.color='#15803D'" onmouseout="this.style.color='#F1F5F9'">
                            <span>MCQ & Test Management</span>
                            <svg class="w-4 h-4 transition-transform duration-200" :class="{ 'rotate-180': open }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>
                        
                        <div x-show="open" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 -translate-y-2" x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 -translate-y-2" class="space-y-1 mt-2">
                            <a href="#" class="group flex items-center px-3 py-2.5 text-sm font-medium rounded-lg transition-all duration-200" style="color: #F1F5F9;" onmouseover="this.style.backgroundColor='#15803D'" onmouseout="this.style.backgroundColor='transparent'">
                                <div class="w-8 h-8 flex-shrink-0 rounded-lg flex items-center justify-center transition-all duration-200" style="background-color: rgba(241, 245, 249, 0.1);">
                                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="color: #F1F5F9;">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                                <span class="ml-3 flex-1">Question Bank</span>
                            </a>
                            
                            <a href="#" class="group flex items-center px-3 py-2.5 text-sm font-medium rounded-lg transition-all duration-200" style="color: #F1F5F9;" onmouseover="this.style.backgroundColor='#15803D'" onmouseout="this.style.backgroundColor='transparent'">
                                <div class="w-8 h-8 flex-shrink-0 rounded-lg flex items-center justify-center transition-all duration-200" style="background-color: rgba(241, 245, 249, 0.1);">
                                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="color: #F1F5F9;">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                        </div>
                                <span class="ml-3 flex-1">Test Sets / Scheduling</span>
                            </a>
                        </div>
                    </div>

                    <!-- Reports & Analytics -->
                    <div class="mb-6" x-data="{ open: true }">
                        <button @click="open = !open" class="w-full flex items-center justify-between px-3 py-2 text-xs font-semibold uppercase tracking-wider transition-colors" style="color: #F1F5F9;" onmouseover="this.style.color='#15803D'" onmouseout="this.style.color='#F1F5F9'">
                            <span>Reports & Analytics</span>
                            <svg class="w-4 h-4 transition-transform duration-200" :class="{ 'rotate-180': open }" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="color: #F1F5F9;">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>
                        
                        <div x-show="open" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 -translate-y-2" x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 -translate-y-2" class="space-y-1 mt-2">
                            <a href="#" class="group flex items-center px-3 py-2.5 text-sm font-medium rounded-lg transition-all duration-200" style="color: #F1F5F9;" onmouseover="this.style.backgroundColor='#15803D'" onmouseout="this.style.backgroundColor='transparent'">
                                <div class="w-8 h-8 flex-shrink-0 rounded-lg flex items-center justify-center transition-all duration-200" style="background-color: rgba(241, 245, 249, 0.1);">
                                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="color: #F1F5F9;">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                            </svg>
                        </div>
                                <span class="ml-3 flex-1">Analytics Summary</span>
                            </a>
                        </div>
                    </div>

                    <!-- System Settings -->
                    <div class="mb-6" x-data="{ open: true }">
                        <button @click="open = !open" class="w-full flex items-center justify-between px-3 py-2 text-xs font-semibold uppercase tracking-wider transition-colors" style="color: #F1F5F9;" onmouseover="this.style.color='#15803D'" onmouseout="this.style.color='#F1F5F9'">
                            <span>System</span>
                            <svg class="w-4 h-4 transition-transform duration-200" :class="{ 'rotate-180': open }" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="color: #F1F5F9;">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>
                        
                        <div x-show="open" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 -translate-y-2" x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 -translate-y-2" class="space-y-1 mt-2">
                            <a href="#" class="group flex items-center px-3 py-2.5 text-sm font-medium rounded-lg transition-all duration-200" style="color: #F1F5F9;" onmouseover="this.style.backgroundColor='#15803D'" onmouseout="this.style.backgroundColor='transparent'">
                                <div class="w-8 h-8 flex-shrink-0 rounded-lg flex items-center justify-center transition-all duration-200" style="background-color: rgba(241, 245, 249, 0.1);">
                                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="color: #F1F5F9;">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    </svg>
                                </div>
                                <span class="ml-3 flex-1">System Settings</span>
                            </a>
                        </div>
                    </div>
                </nav>

                <!-- User Profile Section -->
                <div class="flex-shrink-0 p-3 border-t" style="border-color: #1E293B;">
                    <div class="relative" x-data="{ open: false }" @click.away="open = false">
                        <!-- User Menu Button -->
                        <button @click="open = !open" class="w-full group flex items-center space-x-3 p-2 rounded-lg transition-all duration-200" onmouseover="this.style.backgroundColor='#15803D'" onmouseout="this.style.backgroundColor='transparent'">
                            <div class="flex-shrink-0">
                                <div class="w-10 h-10 bg-gradient-to-br from-primaryGreen to-emerald-600 rounded-full flex items-center justify-center ring-2 ring-white dark:ring-gray-800 overflow-hidden">
                                    @php
                                        $authUser = Auth::user();
                                        $name = $authUser->name ?? 'Super User';
                                        $initials = '';
                                        $nameParts = array_filter(explode(' ', $name));
                                        if (count($nameParts) >= 2) {
                                            $initials = strtoupper(substr($nameParts[0], 0, 1) . substr(end($nameParts), 0, 1));
                                        } else {
                                            $initials = strtoupper(substr($name, 0, 2));
                                        }
                                    @endphp
                                    <span class="text-sm font-bold text-white">{{ $initials }}</span>
                                </div>
                            </div>
                            <div class="flex-1 min-w-0 text-left">
                                <p class="text-sm font-bold truncate" style="color: #F1F5F9;">{{ Auth::user()->name ?? 'Super User' }}</p>
                                <p class="text-xs font-medium truncate" style="color: #F1F5F9;">System Administrator</p>
                            </div>
                            <svg class="w-4 h-4 transition-all duration-300 transform group-hover:rotate-180" :class="{ 'rotate-180': open }" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="color: #F1F5F9;">
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
                             class="absolute bottom-full left-0 mb-2 w-64 rounded-lg shadow-lg z-50 overflow-hidden" style="background-color: #0F172A; border: 1px solid #1E293B;">
                            
                            <!-- Menu Body -->
                            <div class="p-0.5">
                                <!-- System Section -->
                                <div class="mb-1">
                                    <p class="px-3 py-1 text-xs font-semibold uppercase tracking-wider" style="color: #F1F5F9;">System</p>
                                    <div class="space-y-1">
                                        <a href="#" class="group flex items-center px-3 py-2 text-sm font-medium rounded-lg transition-colors duration-150" style="color: #F1F5F9;" onmouseover="this.style.backgroundColor='#15803D'" onmouseout="this.style.backgroundColor='transparent'">
                                            <div class="w-7 h-7 rounded-md flex items-center justify-center mr-2 group-hover:scale-110 transition-transform duration-200" style="background-color: rgba(241, 245, 249, 0.1);">
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="color: #F1F5F9;">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                </svg>
                                            </div>
                                            <div class="flex-1">
                                                <p class="font-medium">Settings</p>
                                            </div>
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="color: #F1F5F9;">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                            </svg>
                                        </a>
                                    </div>
                                </div>
                                
                                <!-- Logout Section -->
                                <div class="border-t pt-2 mt-2" style="border-color: #1E293B;">
                                    <form method="POST" action="{{ route('logout') }}" class="block">
                                        @csrf
                                        <button type="submit" class="group w-full flex items-center px-3 py-2 text-sm font-medium rounded-lg transition-colors duration-150" style="color: #F1F5F9;" onmouseover="this.style.backgroundColor='#15803D'" onmouseout="this.style.backgroundColor='transparent'">
                                            <div class="w-7 h-7 rounded-md flex items-center justify-center mr-2 group-hover:scale-110 transition-transform duration-200" style="background-color: rgba(241, 245, 249, 0.1);">
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="color: #F1F5F9;">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                                                </svg>
                                            </div>
                                            <div class="flex-1 text-left">
                                                <p class="font-medium">Logout</p>
                                            </div>
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="color: #F1F5F9;">
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
            <!-- Top Navbar (Fixed Header) -->
            <header class="sticky top-0 z-30 backdrop-blur-sm shadow-sm" style="background-color: #16A34A; border-bottom: 1px solid #15803D;">
                <div class="flex items-center justify-between px-4 lg:px-6 py-3">
                    <!-- Left Section: Logo + Tagline -->
                    <div class="flex items-center space-x-4">
                        <!-- Mobile sidebar toggle -->
                        <button id="sidebar-toggle" class="lg:hidden p-2 rounded-lg transition-colors" style="color: #FFFFFF;" onmouseover="this.style.backgroundColor='#15803D'" onmouseout="this.style.backgroundColor='transparent'">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                        </svg>
                    </button>
                        
                        <!-- Logo and Tagline -->
                        <div class="flex items-center space-x-3">
                            <div class="w-10 h-10 rounded-xl flex items-center justify-center shadow-sm" style="background-color: rgba(255, 255, 255, 0.2);">
                                <img src="{{ asset('images/BikolpoLive.svg') }}" alt="Bikolpo Live" class="w-6 h-6">
                            </div>
                            <div class="hidden sm:block">
                                <h1 class="text-lg font-bold" style="color: #FFFFFF;">Bikolpo Live</h1>
                                <p class="text-xs" style="color: #FFFFFF;">Super User Dashboard</p>
                            </div>
                            </div>
                        </div>

                    <!-- Center Section: Search Bar -->
                    <div class="hidden md:flex flex-1 max-w-md mx-4">
                        <div class="relative w-full">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="color: #FFFFFF;">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                    </svg>
                                </div>
                            <input type="text" 
                                   placeholder="Quick search for users/tests..." 
                                   class="w-full pl-10 pr-4 py-2 text-sm rounded-lg transition-colors"
                                   style="border: 1px solid #15803D; background-color: rgba(255, 255, 255, 0.2); color: #FFFFFF;"
                                   onfocus="this.style.borderColor='#FFFFFF'; this.style.backgroundColor='rgba(255, 255, 255, 0.3)'"
                                   onblur="this.style.borderColor='#15803D'; this.style.backgroundColor='rgba(255, 255, 255, 0.2)'">
                                </div>
                            </div>

                    <!-- Right Section: Notifications + Profile -->
                    <div class="flex items-center space-x-3">
                        <!-- Search Button (Mobile) -->
                        <button class="md:hidden p-2 rounded-lg transition-colors" style="color: #FFFFFF;" onmouseover="this.style.backgroundColor='#15803D'" onmouseout="this.style.backgroundColor='transparent'">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                    </svg>
                        </button>

                        <!-- Notification Bell -->
                        <div class="relative" x-data="{ open: false }" @click.away="open = false">
                            <button @click="open = !open" class="p-2 rounded-lg transition-colors relative" style="color: #FFFFFF;" onmouseover="this.style.backgroundColor='#15803D'" onmouseout="this.style.backgroundColor='transparent'">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-5 5v-5zM4.5 19.5L9 15l4.5 4.5L9 24l-4.5-4.5zM15 3a3 3 0 100 6 3 3 0 000-6zM9 3a3 3 0 100 6 3 3 0 000-6z"></path>
                                </svg>
                                <span class="absolute -top-1 -right-1 w-3 h-3 bg-red-500 rounded-full text-xs"></span>
                            </button>
                            
                            <!-- Notification Dropdown -->
                            <div x-show="open" 
                                 x-transition:enter="transition ease-out duration-200"
                                 x-transition:enter-start="opacity-0 transform scale-95 -translate-y-2"
                                 x-transition:enter-end="opacity-100 transform scale-100 translate-y-0"
                                 x-transition:leave="transition ease-in duration-150"
                                 x-transition:leave-start="opacity-100 transform scale-100 translate-y-0"
                                 x-transition:leave-end="opacity-0 transform scale-95 -translate-y-2"
                                 class="absolute right-0 mt-2 w-80 rounded-lg shadow-lg z-50" style="background-color: #16A34A; border: 1px solid #15803D;">
                                <div class="p-4">
                                    <h3 class="text-sm font-semibold mb-3" style="color: #FFFFFF;">Notifications</h3>
                                    <div class="space-y-3">
                                        <div class="flex items-start space-x-3 p-2 rounded-lg" onmouseover="this.style.backgroundColor='#15803D'" onmouseout="this.style.backgroundColor='transparent'">
                                            <div class="w-2 h-2 bg-blue-500 rounded-full mt-2 flex-shrink-0"></div>
                                            <div class="flex-1 min-w-0">
                                                <p class="text-sm" style="color: #FFFFFF;">New user registered</p>
                                                <p class="text-xs" style="color: #FFFFFF;">2 minutes ago</p>
                                </div>
                                </div>
                                        <div class="flex items-start space-x-3 p-2 rounded-lg" onmouseover="this.style.backgroundColor='#15803D'" onmouseout="this.style.backgroundColor='transparent'">
                                            <div class="w-2 h-2 bg-green-500 rounded-full mt-2 flex-shrink-0"></div>
                                            <div class="flex-1 min-w-0">
                                                <p class="text-sm" style="color: #FFFFFF;">System backup completed</p>
                                                <p class="text-xs" style="color: #FFFFFF;">1 hour ago</p>
                            </div>
                                </div>
                                    </div>
                                </div>
                                </div>
                            </div>

                        <!-- Profile Dropdown -->
                            <div class="relative" x-data="{ open: false }" @click.away="open = false">
                            <button @click="open = !open" class="flex items-center space-x-2 p-1.5 rounded-lg transition-colors" style="color: #FFFFFF;" onmouseover="this.style.backgroundColor='#15803D'" onmouseout="this.style.backgroundColor='transparent'">
                                <div class="w-8 h-8 bg-gradient-to-br from-primaryGreen to-emerald-600 rounded-full flex items-center justify-center">
                                        @php
                                            $authUser = Auth::user();
                                        $name = $authUser->name ?? 'Super User';
                                            $initials = '';
                                            $nameParts = array_filter(explode(' ', $name));
                                            if (count($nameParts) >= 2) {
                                                $initials = strtoupper(substr($nameParts[0], 0, 1) . substr(end($nameParts), 0, 1));
                                            } else {
                                                $initials = strtoupper(substr($name, 0, 2));
                                            }
                                        @endphp
                                            <span class="text-sm font-bold text-white">{{ $initials }}</span>
                                    </div>
                                <div class="hidden sm:block text-left">
                                    <p class="text-sm font-medium" style="color: #FFFFFF;">{{ Auth::user()->name ?? 'Super User' }}</p>
                                    <p class="text-xs" style="color: #FFFFFF;">System Administrator</p>
                                </div>
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="color: #FFFFFF;">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                </svg>
                                </button>

                            <!-- Profile Dropdown Menu -->
                                <div x-show="open" 
                                 x-transition:enter="transition ease-out duration-200"
                                     x-transition:enter-start="opacity-0 transform scale-95 -translate-y-2"
                                     x-transition:enter-end="opacity-100 transform scale-100 translate-y-0"
                                 x-transition:leave="transition ease-in duration-150"
                                     x-transition:leave-start="opacity-100 transform scale-100 translate-y-0"
                                     x-transition:leave-end="opacity-0 transform scale-95 -translate-y-2"
                                 class="absolute right-0 mt-2 w-56 rounded-lg shadow-lg z-50" style="background-color: #16A34A; border: 1px solid #15803D;">
                                <div class="p-2">
                                    <div class="px-3 py-2 border-b" style="border-color: #15803D;">
                                        <p class="text-sm font-medium" style="color: #FFFFFF;">{{ Auth::user()->name ?? 'Super User' }}</p>
                                        <p class="text-xs" style="color: #FFFFFF;">{{ Auth::user()->email ?? 'admin@bikolpolive.com' }}</p>
                                                    </div>
                                    <div class="py-1">
                                        <a href="#" class="flex items-center px-3 py-2 text-sm rounded-lg" style="color: #FFFFFF;" onmouseover="this.style.backgroundColor='#15803D'" onmouseout="this.style.backgroundColor='transparent'">
                                            <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="color: #FFFFFF;">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                    </svg>
                                            Settings
                                        </a>
                                        <a href="#" class="flex items-center px-3 py-2 text-sm rounded-lg" style="color: #FFFFFF;" onmouseover="this.style.backgroundColor='#15803D'" onmouseout="this.style.backgroundColor='transparent'">
                                            <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="color: #FFFFFF;">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                                        </svg>
                                            Profile
                                        </a>
                                            </div>
                                    <div class="border-t pt-1" style="border-color: #15803D;">
                                        <form method="POST" action="{{ route('logout') }}">
                                                @csrf
                                            <button type="submit" class="flex items-center w-full px-3 py-2 text-sm rounded-lg" style="color: #FFFFFF;" onmouseover="this.style.backgroundColor='#15803D'" onmouseout="this.style.backgroundColor='transparent'">
                                                <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="color: #FFFFFF;">
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
                    </div>
            </header>


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
