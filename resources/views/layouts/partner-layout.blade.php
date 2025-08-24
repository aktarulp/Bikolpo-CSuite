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

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased">
    <div class="min-h-screen bg-gray-100 flex">
        <!-- Left Sidebar (same as layouts/dashboard) -->
        <div id="sidebar" class="flex flex-col transition-all duration-300 ease-in-out w-64">
            <div class="flex flex-col flex-grow pt-5 bg-white dark:bg-gray-900 border-r border-gray-200 dark:border-gray-700">
                <!-- Logo Section -->
                <div id="sidebar-header" class="flex items-center flex-shrink-0 px-6 mb-8">
                    <div id="logo-icon" class="w-10 h-10 bg-gradient-to-br from-primaryGreen to-emerald-500 rounded-xl flex items-center justify-center shadow-lg">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                        </svg>
                    </div>
                    <div id="logo-text" class="ml-3 transition-all duration-300">
                        <h1 class="text-xl font-bold text-gray-900 dark:text-white">CSuite</h1>
                        <p class="text-xs text-gray-500 dark:text-gray-400">Partner Portal</p>
                    </div>
                    <button id="sidebar-toggle" aria-label="Toggle sidebar" class="group ml-auto p-2 rounded-full bg-primaryGreen/10 text-primaryGreen ring-1 ring-primaryGreen/20 hover:bg-primaryGreen/20 hover:ring-primaryGreen/30 dark:bg-emerald-900/20 dark:text-emerald-300 dark:ring-emerald-800/30 dark:hover:bg-emerald-900/30 shadow-sm transition-colors duration-200">
                        <!-- Icon when expanded (action: push left / collapse) -->
                        <svg id="icon-push-left" class="h-5 w-5 transition-transform duration-200 group-hover:scale-110" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                        </svg>
                        <!-- Icon when collapsed (action: push right / expand) -->
                        <svg id="icon-push-right" class="h-5 w-5 hidden transition-transform duration-200 group-hover:scale-110" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </button>
                </div>

                <!-- Navigation Menu -->
                <nav class="flex-1 px-4 space-y-1">
                    <a href="{{ route('partner.dashboard') }}" 
                       class="group nav-link flex items-center px-3 py-2 text-sm font-medium rounded-lg transition-all duration-200 {{ request()->routeIs('partner.dashboard') ? 'bg-primaryGreen/10 text-primaryGreen border border-primaryGreen/20' : 'text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800 hover:text-gray-900 dark:hover:text-white' }}">
                        <span class="nav-icon w-8 h-8 rounded-md bg-blue-50 dark:bg-blue-900/20 flex items-center justify-center">
                            <svg class="h-5 w-5 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 01-2-2z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5a2 2 0 012-2h4a2 2 0 012 2v6H8V5z"></path>
                            </svg>
                        </span>
                        <span id="nav-dashboard" class="ml-3 transition-all duration-300">Dashboard</span>
                    </a>

                    <!-- Questions Menu -->
                    <a href="{{ route('partner.questions.all') }}" 
                       class="group nav-link flex items-center px-3 py-2 text-sm font-medium rounded-lg transition-all duration-200 {{ request()->routeIs('partner.questions.*') ? 'bg-primaryGreen/10 text-primaryGreen border border-primaryGreen/20' : 'text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800 hover:text-gray-900 dark:hover:text-white' }}">
                        <span class="nav-icon w-8 h-8 rounded-md bg-emerald-50 dark:bg-emerald-900/20 flex items-center justify-center">
                            <svg class="h-5 w-5 text-emerald-600 dark:text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </span>
                        <span id="nav-questions" class="ml-3 transition-all duration-300">Questions</span>
                    </a>

                    <a href="{{ route('partner.question-sets.index') }}" 
                       class="group nav-link flex items-center px-3 py-2 text-sm font-medium rounded-lg transition-all duration-200 {{ request()->routeIs('partner.question-sets.*') ? 'bg-primaryGreen/10 text-primaryGreen border border-primaryGreen/20' : 'text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800 hover:text-gray-900 dark:hover:text-white' }}">
                        <span class="nav-icon w-8 h-8 rounded-md bg-green-50 dark:bg-green-900/20 flex items-center justify-center">
                            <svg class="h-5 w-5 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                        </span>
                        <span id="nav-question-sets" class="ml-3 transition-all duration-300">Question Sets</span>
                    </a>

                    <a href="{{ route('partner.exams.index') }}" 
                       class="group nav-link flex items-center px-3 py-2 text-sm font-medium rounded-lg transition-all duration-200 {{ request()->routeIs('partner.exams.*') ? 'bg-primaryGreen/10 text-primaryGreen border border-primaryGreen/20' : 'text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800 hover:text-gray-900 dark:hover:text-white' }}">
                        <span class="nav-icon w-8 h-8 rounded-md bg-orange-50 dark:bg-orange-900/20 flex items-center justify-center">
                            <svg class="h-5 w-5 text-orange-600 dark:text-orange-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                            </svg>
                        </span>
                        <span id="nav-exams" class="ml-3 transition-all duration-300">Exams</span>
                    </a>

                    <a href="{{ route('partner.students.index') }}" 
                       class="group nav-link flex items-center px-3 py-2 text-sm font-medium rounded-lg transition-all duration-200 {{ request()->routeIs('partner.students.*') ? 'bg-primaryGreen/10 text-primaryGreen border border-primaryGreen/20' : 'text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800 hover:text-gray-900 dark:hover:text-white' }}">
                        <span class="nav-icon w-8 h-8 rounded-md bg-purple-50 dark:bg-purple-900/20 flex items-center justify-center">
                            <svg class="h-5 w-5 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l6.16-3.422A12.083 12.083 0 0112 21.5 12.083 12.083 0 015.84 10.578L12 14z"></path>
                            </svg>
                        </span>
                        <span id="nav-students" class="ml-3 transition-all duration-300">Students</span>
                    </a>

                    <a href="{{ route('partner.batches.index') }}" 
                       class="group nav-link flex items-center px-3 py-2 text-sm font-medium rounded-lg transition-all duration-200 {{ request()->routeIs('partner.batches.*') ? 'bg-primaryGreen/10 text-primaryGreen border border-primaryGreen/20' : 'text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800 hover:text-gray-900 dark:hover:text-white' }}">
                        <span class="nav-icon w-8 h-8 rounded-md bg-rose-50 dark:bg-rose-900/20 flex items-center justify-center">
                            <svg class="h-5 w-5 text-rose-600 dark:text-rose-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                            </svg>
                        </span>
                        <span id="nav-batches" class="ml-3 transition-all duration-300">Batches</span>
                    </a>

                    <a href="{{ route('partner.courses.index') }}" 
                       class="group nav-link flex items-center px-3 py-2 text-sm font-medium rounded-lg transition-all duration-200 {{ request()->routeIs('partner.courses.*') ? 'bg-primaryGreen/10 text-primaryGreen border border-primaryGreen/20' : 'text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800 hover:text-gray-900 dark:hover:text-white' }}">
                        <span class="nav-icon w-8 h-8 rounded-md bg-indigo-50 dark:bg-indigo-900/20 flex items-center justify-center">
                            <svg class="h-5 w-5 text-indigo-600 dark:text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l6.16-3.422A12.083 12.083 0 0112 21.5 12.083 12.083 0 015.84 10.578L12 14z"></path>
                            </svg>
                        </span>
                        <span id="nav-courses" class="ml-3 transition-all duration-300">Courses</span>
                    </a>

                    <a href="{{ route('partner.subjects.index') }}" 
                       class="group nav-link flex items-center px-3 py-2 text-sm font-medium rounded-lg transition-all duration-200 {{ request()->routeIs('partner.subjects.*') ? 'bg-primaryGreen/10 text-primaryGreen border border-primaryGreen/20' : 'text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800 hover:text-gray-900 dark:hover:text-white' }}">
                        <span class="nav-icon w-8 h-8 rounded-md bg-teal-50 dark:bg-teal-900/20 flex items-center justify-center">
                            <svg class="h-5 w-5 text-teal-600 dark:text-teal-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6l-2-2H6a2 2 0 00-2 2v13a2 2 0 002 2h4l2-2" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6l2-2h4a2 2 0 012 2v13a2 2 0 01-2 2h-4l-2-2" />
                            </svg>
                        </span>
                        <span id="nav-subjects" class="ml-3 transition-all duration-300">Subjects</span>
                    </a>

                    <a href="{{ route('partner.topics.index') }}" 
                       class="group nav-link flex items-center px-3 py-2 text-sm font-medium rounded-lg transition-all duration-200 {{ request()->routeIs('partner.topics.*') ? 'bg-primaryGreen/10 text-primaryGreen border border-primaryGreen/20' : 'text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800 hover:text-gray-900 dark:hover:text-white' }}">
                        <span class="nav-icon w-8 h-8 rounded-md bg-amber-50 dark:bg-amber-900/20 flex items-center justify-center">
                            <svg class="h-5 w-5 text-amber-600 dark:text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                            </svg>
                        </span>
                        <span id="nav-topics" class="ml-3 transition-all duration-300">Topics</span>
                    </a>

                    <a href="{{ route('partner.question-history.index') }}" 
                       class="group nav-link flex items-center px-3 py-2 text-sm font-medium rounded-lg transition-all duration-200 {{ request()->routeIs('partner.question-history.*') ? 'bg-primaryGreen/10 text-primaryGreen border border-primaryGreen/20' : 'text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800 hover:text-gray-900 dark:hover:text-white' }}">
                        <span class="nav-icon w-8 h-8 rounded-md bg-cyan-50 dark:bg-cyan-900/20 flex items-center justify-center">
                            <svg class="h-5 w-5 text-cyan-600 dark:text-cyan-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </span>
                        <span id="nav-question-history" class="ml-3 transition-all duration-300">Question History</span>
                    </a>
                  

                <!-- Bottom Section -->
                <div class="flex-shrink-0 p-4 border-t border-gray-200 dark:border-gray-700">
                    <div id="bottom-row" class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="w-8 h-8 rounded-full overflow-hidden bg-gradient-to-br from-primaryGreen to-emerald-500 flex items-center justify-center">
                                @php $partner = $partner ?? \App\Models\Partner::where('user_id', auth()->id())->first(); @endphp
                                @if(!empty($partner?->logo))
                                    <img src="{{ asset('storage/' . $partner->logo) }}" alt="Partner Logo" class="w-full h-full object-cover">
                                @else
                                    <span class="text-sm font-bold text-white">{{ strtoupper(substr($partner?->slug ?? $partner?->name ?? (Auth::user()->name ?? 'P'), 0, 1)) }}</span>
                                @endif
                            </div>
                        </div>
                        <div id="user-info" class="ml-3 min-w-0 flex-1 transition-all duration-300">
                            <p class="text-sm font-medium text-gray-900 dark:text-white truncate">{{ $partner?->slug ?? $partner?->name ?? Auth::user()->name ?? 'Partner' }}</p>
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

        <!-- Main Content Area with Partner Top Banner -->
        <div class="flex-1 flex flex-col">
            <main class="flex-1 overflow-y-auto p-6">
                @php
                    $partner = $partner ?? \App\Models\Partner::where('user_id', auth()->id())->first();
                    if (!isset($stats)) {
                        $partnerId = $partner?->id;
                        $stats = [
                            'total_questions' => $partnerId ? \App\Models\Question::where('partner_id', $partnerId)->count() : 0,
                            'total_question_sets' => $partnerId ? \App\Models\QuestionSet::where('partner_id', $partnerId)->count() : 0,
                            'total_exams' => $partnerId ? \App\Models\Exam::where('partner_id', $partnerId)->count() : 0,
                            'total_students' => $partnerId ? \App\Models\Student::whereHas('examResults.exam', function ($query) use ($partnerId) { $query->where('partner_id', $partnerId); })->distinct()->count() : 0,
                        ];
                    }
                @endphp
                <!-- Professional Welcome Banner with Navigation Tabs -->
                <div class="sticky top-0 z-50 bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-700 rounded-xl shadow-sm">
                    <div class="px-8 py-2">
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
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
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
                                            <a href="{{ route('partner.profile.show') }}" class="flex items-center px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors duration-200">
                                                <svg class="w-4 h-4 mr-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                                </svg>
                                                View Profile
                                            </a>
                                            <a href="{{ route('partner.profile.edit') }}" class="flex items-center px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors duration-200">
                                                <svg class="w-4 h-4 mr-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                                </svg>
                                                Edit Profile
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
                        <div class="border-t border-gray-200 dark:border-gray-700">
                            <nav class="flex items-center space-x-1">
                                <a href="{{ route('partner.dashboard') }}" 
                                   class="px-4 py-1 text-sm font-medium text-primaryGreen bg-green-50 dark:bg-green-900/20 rounded-lg border border-green-200 dark:border-green-800">
                                    Overview
                                </a>
                                <a href="{{ route('partner.questions.all') }}" 
                                   class="px-4 py-1 text-sm font-medium text-gray-600 dark:text-gray-300 hover:text-gray-900 dark:hover:text-white hover:bg-gray-50 dark:hover:bg-gray-800 rounded-lg transition-all duration-200">
                                    Questions
                                </a>
                                <a href="{{ route('partner.exams.index') }}" 
                                   class="px-4 py-1 text-sm font-medium text-gray-600 dark:text-gray-300 hover:text-gray-900 dark:hover:text-white hover:bg-gray-50 dark:hover:bg-gray-800 rounded-lg transition-all duration-200">
                                    Exams
                                </a>
                                <a href="{{ route('partner.students.index') }}" 
                                   class="px-4 py-1 text-sm font-medium text-gray-600 dark:text-gray-300 hover:text-gray-900 dark:hover:text-white hover:bg-gray-50 dark:hover:bg-gray-800 rounded-lg transition-all duration-200">
                                    Students
                                </a>
                            </nav>
                        </div>
                    </div>
                </div>

                @yield('content')
            </main>
        </div>
    </div>

    <!-- JavaScript for Sidebar Toggle, Mobile Sidebar, and Theme -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            // Sidebar state management
            let sidebarOpen = localStorage.getItem('sidebarOpen') !== 'false'; // Default to open
            
            const sidebar = document.getElementById('sidebar');
            const sidebarToggle = document.getElementById('sidebar-toggle');
            const themeToggle = document.getElementById('theme-toggle');
            const htmlTag = document.documentElement;

            // Elements to show/hide
            const logoText = document.getElementById('logo-text');
            const userInfo = document.getElementById('user-info');
            const logoutButton = document.getElementById('logout-button');
            const navTexts = [
                'nav-dashboard', 'nav-questions', 'nav-question-sets', 'nav-exams',
                'nav-students', 'nav-batches', 'nav-courses', 'nav-subjects',
                'nav-topics', 'nav-question-history', 'nav-partners'
            ];
            
            // Submenu elements
            const submenuTexts = [
                'nav-questions-view', 'nav-questions-create', 'nav-questions-mcq', 'nav-questions-descriptive',
                'nav-profile-view', 'nav-profile-edit'
            ];

            function updateSidebar() {
                if (sidebarOpen) {
                    sidebar.classList.remove('w-16');
                    sidebar.classList.add('w-64');
                    
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
                    
                    submenuTexts.forEach(id => {
                        const element = document.getElementById(id);
                        if (element) {
                            element.style.opacity = '1';
                            element.style.display = 'block';
                        }
                    });
                    // Centering reset for nav links when expanded
                    const navLinksExpanded = sidebar.querySelectorAll('nav a.nav-link');
                    navLinksExpanded.forEach(link => {
                        link.classList.remove('justify-center');
                        link.classList.remove('px-0');
                        if (!link.classList.contains('px-3')) link.classList.add('px-3');
                    });
                } else {
                    sidebar.classList.remove('w-64');
                    sidebar.classList.add('w-16');
                    
                    logoText.style.opacity = '0';
                    logoText.style.display = 'none';
                    userInfo.style.opacity = '0';
                    userInfo.style.display = 'none';
                    logoutButton.style.opacity = '0';
                    logoutButton.style.display = 'none';
                    
                    navTexts.forEach(id => {
                        const element = document.getElementById(id);
                        if (element) {
                            element.style.opacity = '0';
                            element.style.display = 'none';
                        }
                    });
                    
                    submenuTexts.forEach(id => {
                        const element = document.getElementById(id);
                        if (element) {
                            element.style.opacity = '0';
                            element.style.display = 'none';
                        }
                    });
                    // Center nav items horizontally in collapsed state
                    const navLinksCollapsed = sidebar.querySelectorAll('nav a.nav-link');
                    navLinksCollapsed.forEach(link => {
                        link.classList.add('justify-center');
                        link.classList.add('px-0');
                        link.classList.remove('px-3');
                    });
                }
                localStorage.setItem('sidebarOpen', sidebarOpen);
                if (sidebarToggle) {
                    sidebarToggle.setAttribute('aria-expanded', sidebarOpen ? 'true' : 'false');
                    sidebarToggle.title = sidebarOpen ? 'Collapse sidebar' : 'Expand sidebar';
                }
                // When collapsed, also hide the big logo icon for a cleaner look
                const logoIcon = document.getElementById('logo-icon');
                const sidebarHeader = document.getElementById('sidebar-header');
                const bottomRow = document.getElementById('bottom-row');
                if (logoIcon) {
                    if (sidebarOpen) {
                        logoIcon.classList.remove('hidden');
                        if (sidebarHeader) {
                            sidebarHeader.classList.remove('justify-center');
                            sidebarHeader.classList.add('px-6');
                            sidebarHeader.classList.remove('px-2');
                        }
                        if (sidebarToggle) {
                            sidebarToggle.classList.add('ml-auto');
                            sidebarToggle.classList.remove('mx-auto');
                        }
                        if (bottomRow) {
                            bottomRow.classList.remove('justify-center');
                            bottomRow.classList.add('justify-start');
                        }
                    } else {
                        logoIcon.classList.add('hidden');
                        if (sidebarHeader) {
                            sidebarHeader.classList.add('justify-center');
                            sidebarHeader.classList.remove('px-6');
                            sidebarHeader.classList.add('px-2');
                        }
                        if (sidebarToggle) {
                            sidebarToggle.classList.remove('ml-auto');
                            sidebarToggle.classList.add('mx-auto');
                        }
                        if (bottomRow) {
                            bottomRow.classList.add('justify-center');
                            bottomRow.classList.remove('justify-start');
                        }
                    }
                }
            }

            updateSidebar();

            // Sidebar toggle button handler
            if (sidebarToggle) {
                sidebarToggle.addEventListener('click', () => {
                    sidebarOpen = !sidebarOpen;
                    updateSidebar();
                });
            }

            // Update toggle icons to reflect current state
            function updateToggleIcons() {
                const iconLeft = document.getElementById('icon-push-left');
                const iconRight = document.getElementById('icon-push-right');
                if (iconLeft && iconRight) {
                    if (sidebarOpen) {
                        iconLeft.classList.remove('hidden');
                        iconRight.classList.add('hidden');
                    } else {
                        iconLeft.classList.add('hidden');
                        iconRight.classList.remove('hidden');
                    }
                }
            }

            // Sync icons on init and whenever state changes
            updateToggleIcons();
            const originalUpdateSidebar = updateSidebar;
            updateSidebar = function() {
                originalUpdateSidebar();
                updateToggleIcons();
                // Enlarge icons when collapsed
                const icons = document.querySelectorAll('.nav-icon svg');
                icons.forEach(svg => {
                    if (sidebarOpen) {
                        svg.classList.remove('h-10', 'w-10');
                        svg.classList.add('h-5', 'w-5');
                    } else {
                        svg.classList.remove('h-5', 'w-5');
                        svg.classList.add('h-10', 'w-10');
                    }
                });
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

            function attachTooltips() {
                const navItems = sidebar.querySelectorAll('nav a.nav-link');
                navItems.forEach(item => {
                    item.addEventListener('mouseenter', () => {
                        if (sidebarOpen) return;
                        const text = item.querySelector('span[id^="nav-"]')?.textContent || '';
                        if (text) {
                            const tooltip = document.createElement('div');
                            tooltip.className = 'absolute left-full ml-2 px-2 py-1 bg-gray-900 text-white text-xs rounded shadow-lg z-50 whitespace-nowrap';
                            tooltip.textContent = text;
                            item.style.position = 'relative';
                            item.appendChild(tooltip);
                        }
                    });
                    item.addEventListener('mouseleave', () => {
                        const tooltip = item.querySelector('div');
                        if (tooltip) tooltip.remove();
                    });
                });
            }

            attachTooltips();

            // Profile submenu toggle
            const profileMenuToggle = document.getElementById('profile-menu-toggle');
            const profileSubmenu = document.getElementById('profile-submenu');
            const profileArrow = document.getElementById('profile-arrow');
            
            if (profileMenuToggle && profileSubmenu && profileArrow) {
                profileMenuToggle.addEventListener('click', () => {
                    const isOpen = profileSubmenu.classList.contains('hidden');
                    
                    if (isOpen) {
                        profileSubmenu.classList.remove('hidden');
                        profileArrow.style.transform = 'rotate(90deg)';
                    } else {
                        profileSubmenu.classList.add('hidden');
                        profileArrow.style.transform = 'rotate(0deg)';
                    }
                });
                
                if (window.location.pathname.includes('/profile/')) {
                    profileSubmenu.classList.remove('hidden');
                    profileArrow.style.transform = 'rotate(90deg)';
                }
            }
        });
    </script>
    
    @stack('scripts')
</body>
</html>
