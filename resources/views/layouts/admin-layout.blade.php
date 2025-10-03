<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="theme-color" content="#dc2626">
    <title>{{ config('app.name', 'Laravel') }} - Admin</title>

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <style>
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
        @media (min-width: 1024px) {
            .mobile-sidebar {
                position: sticky;
                top: 0;
                transform: translateX(0);
                height: 100vh;
            }
        }
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
        <!-- Admin Sidebar -->
        <aside id="sidebar" class="mobile-sidebar w-56 lg:w-60 bg-white dark:bg-gray-900 border-r border-gray-200 dark:border-gray-700 flex flex-col">
            <div class="flex flex-col h-full overflow-y-auto custom-scrollbar">
                <!-- Sidebar Header -->
                <div class="relative px-3 py-3 lg:py-4 border-b border-gray-200 dark:border-gray-700 bg-gradient-to-br from-red-50 to-orange-50 dark:from-red-900/20 dark:to-orange-900/20">
                    <div class="flex items-center justify-between">
                        <a href="{{ route('admin.dashboard') }}" class="flex items-center space-x-2 group flex-1 min-w-0">
                            <div class="relative flex-shrink-0">
                                <div class="w-14 h-14 bg-white dark:bg-gray-800 rounded-xl flex items-center justify-center shadow-lg ring-2 ring-red-500/20 group-hover:ring-red-500/40 transition-all duration-300 group-hover:scale-105 overflow-hidden">
                                    <img src="{{ asset('images/only_logo.png') }}" alt="Admin Panel" class="w-full h-full object-contain p-1">
                                </div>
                                <div class="absolute -top-0.5 -right-0.5 w-2.5 h-2.5 bg-red-400 rounded-full animate-pulse"></div>
                            </div>
                            <div class="flex flex-col min-w-0 flex-1">
                                <h2 class="text-lg font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-gray-900 via-red-600 to-orange-600 dark:from-white dark:via-red-400 dark:to-orange-400 tracking-tight leading-tight">
                                    Admin<br/>Panel
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
                    <a href="{{ route('admin.dashboard') }}"
                       class="group flex items-center px-3 py-1.5 text-sm font-semibold rounded-lg transition-all duration-200 {{ request()->routeIs('admin.dashboard') ? 'bg-gradient-to-r from-red-50 to-red-100 text-red-700 border border-red-200 shadow-sm' : 'text-gray-700 dark:text-gray-300 hover:bg-gradient-to-r hover:from-red-50/50 hover:to-red-50 dark:hover:from-gray-800 dark:hover:to-gray-800 hover:text-red-700 dark:hover:text-white' }}">
                        <div class="w-8 h-8 flex-shrink-0 rounded-lg {{ request()->routeIs('admin.dashboard') ? 'bg-red-100' : 'bg-gray-100 dark:bg-gray-800 group-hover:bg-red-50' }} flex items-center justify-center transition-all duration-200">
                            <svg class="h-4 w-4 {{ request()->routeIs('admin.dashboard') ? 'text-red-600' : 'text-gray-500 group-hover:text-red-500' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                            </svg>
                        </div>
                        <span class="ml-2 flex-1">Dashboard</span>
                    </a>

                    <!-- System Management -->
                    <div class="pt-2">
                        <p class="px-3 text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-2">System Management</p>
                        
                        <a href="#" class="group flex items-center px-3 py-1.5 text-sm font-semibold rounded-lg transition-all duration-200 text-gray-700 dark:text-gray-300 hover:bg-gradient-to-r hover:from-blue-50/50 hover:to-blue-50 dark:hover:from-gray-800 dark:hover:to-gray-800 hover:text-blue-700 dark:hover:text-white">
                            <div class="w-8 h-8 flex-shrink-0 rounded-lg bg-gray-100 dark:bg-gray-800 group-hover:bg-blue-50 flex items-center justify-center transition-all duration-200">
                                <svg class="h-4 w-4 text-gray-500 group-hover:text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                            </div>
                            <span class="ml-2 flex-1">User Management</span>
                        </a>

                        <a href="#" class="group flex items-center px-3 py-1.5 text-sm font-semibold rounded-lg transition-all duration-200 text-gray-700 dark:text-gray-300 hover:bg-gradient-to-r hover:from-green-50/50 hover:to-green-50 dark:hover:from-gray-800 dark:hover:to-gray-800 hover:text-green-700 dark:hover:text-white">
                            <div class="w-8 h-8 flex-shrink-0 rounded-lg bg-gray-100 dark:bg-gray-800 group-hover:bg-green-50 flex items-center justify-center transition-all duration-200">
                                <svg class="h-4 w-4 text-gray-500 group-hover:text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                </svg>
                            </div>
                            <span class="ml-2 flex-1">Partner Management</span>
                        </a>

                        <a href="#" class="group flex items-center px-3 py-1.5 text-sm font-semibold rounded-lg transition-all duration-200 text-gray-700 dark:text-gray-300 hover:bg-gradient-to-r hover:from-purple-50/50 hover:to-purple-50 dark:hover:from-gray-800 dark:hover:to-gray-800 hover:text-purple-700 dark:hover:text-white">
                            <div class="w-8 h-8 flex-shrink-0 rounded-lg bg-gray-100 dark:bg-gray-800 group-hover:bg-purple-50 flex items-center justify-center transition-all duration-200">
                                <svg class="h-4 w-4 text-gray-500 group-hover:text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                            </div>
                            <span class="ml-2 flex-1">System Settings</span>
                        </a>
                    </div>
                </nav>

                <!-- Sidebar Footer -->
                <div class="flex-shrink-0 p-2 border-t border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-800/50">
                    <div class="relative" x-data="{ open: false }" @click.away="open = false">
                        <!-- User Menu Button -->
                        <button @click="open = !open" class="w-full group flex items-center space-x-2 p-1.5 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 transition-all duration-200">
                            <div class="flex-shrink-0">
                                <div class="w-8 h-8 bg-gradient-to-br from-red-500 to-orange-600 rounded-full flex items-center justify-center ring-2 ring-white dark:ring-gray-800">
                                    <span class="text-xs font-bold text-white">{{ substr(Auth::user()->name ?? 'A', 0, 1) }}</span>
                                </div>
                            </div>
                            <div class="flex-1 min-w-0 text-left">
                                <p class="text-sm font-bold text-gray-900 dark:text-white truncate">{{ Auth::user()->name ?? 'Admin' }}</p>
                                <p class="text-xs font-medium text-gray-500 dark:text-gray-400 truncate">{{ ucfirst(Auth::user()->role ?? 'Administrator') }}</p>
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
            <header class="lg:hidden sticky top-0 z-30 bg-gradient-to-r from-white to-gray-50 dark:from-gray-900 dark:to-gray-800 border-b border-gray-200 dark:border-gray-700 backdrop-blur-sm bg-white/95 dark:bg-gray-900/95 shadow-sm">
                <div class="flex items-center justify-between px-4 py-3">
                    <button id="sidebar-toggle" class="p-2.5 rounded-xl text-gray-600 dark:text-gray-400 hover:bg-red-500/10 hover:text-red-600 dark:hover:bg-red-500/20 transition-all duration-200 active:scale-95">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 6h16M4 12h16M4 18h16"></path>
                        </svg>
                    </button>
                    <h1 class="text-lg font-bold text-transparent bg-clip-text bg-gradient-to-r from-gray-900 via-red-600 to-orange-600 dark:from-white dark:via-red-400 dark:to-orange-400">
                        Admin Panel
                    </h1>
                    <div class="w-10"></div>
                </div>
            </header>

            <!-- Desktop Top Bar -->
            <div class="hidden lg:block sticky top-0 z-20 bg-gradient-to-r from-white via-gray-50 to-white dark:from-gray-900 dark:via-gray-800 dark:to-gray-900 border-b border-gray-200 dark:border-gray-700 shadow-md backdrop-blur-sm bg-white/95 dark:bg-gray-900/95">
                <div class="px-4 lg:px-8 py-4">
                    <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
                        <div class="flex items-center space-x-4">
                            <div class="w-12 h-12 flex items-center justify-center bg-gradient-to-br from-red-500/10 to-orange-100 dark:from-red-500/20 dark:to-orange-900/30 rounded-xl ring-2 ring-red-500/20 shadow-lg">
                                <svg class="w-6 h-6 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                                </svg>
                            </div>
                            <div>
                                <h2 class="text-xl lg:text-2xl font-bold text-gray-900 dark:text-white">
                                    System Administration
                                </h2>
                                <p class="text-gray-600 dark:text-gray-400 text-sm flex items-center mt-1">
                                    <svg class="w-4 h-4 mr-1.5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    Full system control and management
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Page Content -->
            <div class="flex-1 overflow-y-auto custom-scrollbar bg-gray-50 dark:bg-gray-900">
                <div class="p-4 lg:p-6 xl:p-8 max-w-7xl mx-auto">
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

            function toggleSidebar() {
                sidebar.classList.toggle('open');
                sidebarBackdrop.classList.toggle('active');
                document.body.classList.toggle('overflow-hidden');
            }

            function closeSidebar() {
                sidebar.classList.remove('open');
                sidebarBackdrop.classList.remove('active');
                document.body.classList.remove('overflow-hidden');
            }

            if (sidebarToggle) {
                sidebarToggle.addEventListener('click', toggleSidebar);
            }

            if (sidebarClose) {
                sidebarClose.addEventListener('click', closeSidebar);
            }

            if (sidebarBackdrop) {
                sidebarBackdrop.addEventListener('click', closeSidebar);
            }

            const navLinks = sidebar?.querySelectorAll('a');
            navLinks?.forEach(link => {
                link.addEventListener('click', () => {
                    if (window.innerWidth < 1024) {
                        closeSidebar();
                    }
                });
            });

            let resizeTimer;
            window.addEventListener('resize', () => {
                clearTimeout(resizeTimer);
                resizeTimer = setTimeout(() => {
                    if (window.innerWidth >= 1024) {
                        closeSidebar();
                    }
                }, 250);
            });
        });
    </script>

    @stack('scripts')
</body>
</html>
