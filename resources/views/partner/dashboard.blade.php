@extends('layouts.dashboard')

@section('title', 'Partner Dashboard')

@section('content')
<div class="space-y-6">
    <!-- Modern Dashboard Top Bar -->
    <header class="sticky top-0 z-50 w-full bg-gradient-to-r from-blue-600 to-blue-700 dark:from-gray-800 dark:to-gray-900 shadow-lg px-4 py-3 flex items-center justify-between transition-all duration-300 backdrop-blur-sm bg-opacity-95">
        <!-- Left side: Logo + Title -->
        <div class="flex items-center space-x-3">
            <div class="relative">
                <div class="w-10 h-10 bg-gradient-to-br from-primaryGreen to-emerald-500 rounded-xl flex items-center justify-center shadow-lg">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                    </svg>
                </div>
                <div class="absolute -top-1 -right-1 w-3 h-3 bg-emerald-400 rounded-full border-2 border-white dark:border-gray-900"></div>
            </div>
            <div>
                <h1 class="text-xl font-bold text-white">CSuite</h1>
                <p class="text-xs text-blue-100 font-medium">Partner Dashboard</p>
            </div>
        </div>

        <!-- Right side: Actions -->
        <div class="flex items-center space-x-4">
            <!-- Search Bar -->
            <div class="relative hidden md:block">
                <input type="text"
                       placeholder="Search questions, exams, students..."
                       class="pl-10 pr-4 py-2 rounded-lg border-0
                              focus:outline-none focus:ring-2 focus:ring-white focus:ring-opacity-50
                              bg-white bg-opacity-20 text-white placeholder-blue-100
                              backdrop-blur-sm">
                <svg class="w-5 h-5 text-blue-100 absolute left-3 top-2.5"
                     xmlns="http://www.w3.org/2000/svg" fill="none"
                     viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M21 21l-4.35-4.35m0 0A7.5 7.5 0 104.5 4.5a7.5 7.5 0 0012.15 12.15z" />
                </svg>
            </div>

            <!-- Quick Actions -->
            <div class="hidden lg:flex items-center space-x-2">
                <a href="{{ route('partner.questions.create') }}" 
                   class="inline-flex items-center px-3 py-2 text-sm font-medium text-white bg-white bg-opacity-20 hover:bg-white hover:bg-opacity-30 rounded-lg transition-all duration-200 group backdrop-blur-sm">
                    <svg class="w-4 h-4 mr-2 text-blue-100 group-hover:text-white transition-colors duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                    Add Question
                </a>
                <a href="{{ route('partner.exams.create') }}" 
                   class="inline-flex items-center px-3 py-2 text-sm font-medium text-white bg-white bg-opacity-20 hover:bg-white hover:bg-opacity-30 rounded-lg transition-all duration-200 group backdrop-blur-sm">
                    <svg class="w-4 h-4 mr-2 text-blue-100 group-hover:text-white transition-colors duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                    </svg>
                    Create Exam
                </a>
            </div>

            <!-- Stats Summary -->
            <div class="hidden xl:flex items-center space-x-4 pl-4 border-l border-white border-opacity-20">
                <div class="text-center">
                    <div class="text-lg font-bold text-white">{{ $stats['total_questions'] ?? 0 }}</div>
                    <div class="text-xs text-blue-100">Questions</div>
                </div>
                <div class="text-center">
                    <div class="text-lg font-bold text-white">{{ $stats['total_exams'] ?? 0 }}</div>
                    <div class="text-xs text-blue-100">Exams</div>
                </div>
                <div class="text-center">
                    <div class="text-lg font-bold text-white">{{ $stats['total_students'] ?? 0 }}</div>
                    <div class="text-xs text-blue-100">Students</div>
                </div>
            </div>

            <!-- Notification Bell -->
            <button class="relative text-white hover:text-blue-200 p-2 rounded-lg hover:bg-white hover:bg-opacity-20 transition-all duration-200">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6"
                     fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002
                             6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67
                             6.165 6 8.388 6 11v3.159c0 .538-.214
                             1.055-.595 1.436L4 17h5m6 0v1a3
                             3 0 11-6 0v-1m6 0H9" />
                </svg>
                <span class="absolute -top-1 -right-1 px-1.5 text-xs bg-red-600 text-white rounded-full">3</span>
            </button>

            <!-- Dark Mode Toggle -->
            <button id="theme-toggle" class="text-white hover:text-blue-200 p-2 rounded-lg hover:bg-white hover:bg-opacity-20 transition-all duration-200">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6"
                     fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M12 3v1m0 16v1m8.66-13.66l-.71.71M4.05
                             19.95l.71-.71M21 12h-1M4 12H3m16.95
                             7.95l-.71-.71M4.05 4.05l.71.71M16 12a4
                             4 0 11-8 0 4 4 0 018 0z" />
                </svg>
            </button>

            <!-- User Menu with Dropdown -->
            <div class="relative group">
                <button class="flex items-center space-x-2 focus:outline-none p-2 rounded-lg hover:bg-white hover:bg-opacity-20 transition-all duration-200">
                    <div class="w-8 h-8 bg-gradient-to-br from-primaryGreen to-emerald-500 rounded-full flex items-center justify-center">
                        <span class="text-sm font-bold text-white">{{ substr(Auth::user()->name ?? 'P', 0, 1) }}</span>
                    </div>
                    <span class="hidden md:block text-white">{{ Auth::user()->name ?? 'Partner' }}</span>
                    <svg class="w-4 h-4 text-blue-100 transition-transform duration-200 group-hover:rotate-180" fill="none"
                         stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M19 9l-7 7-7-7" />
                    </svg>
                </button>
                <!-- Dropdown Menu -->
                <div class="absolute right-0 mt-2 w-48 bg-white dark:bg-gray-800 border
                            border-gray-200 dark:border-gray-700 rounded-lg shadow-lg
                            transform scale-95 opacity-0 invisible group-hover:scale-100 group-hover:opacity-100 group-hover:visible transition-all duration-200 z-50">
                    <a href="{{ route('partner.profile.show') }}" class="block px-4 py-2 text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700">Profile</a>
                    <a href="{{ route('partner.profile.edit') }}" class="block px-4 py-2 text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700">Settings</a>
                    <form method="POST" action="{{ route('logout') }}" class="block">
                        @csrf
                        <button type="submit" class="w-full text-left px-4 py-2 text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700">
                            Logout
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </header>

    <!-- Navigation Tabs -->
    <div class="bg-white dark:bg-gray-900 border-b border-gray-200 dark:border-gray-800">
        <div class="px-6 py-3">
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

    <!-- Welcome Banner -->
    <div class="bg-gradient-to-r from-primaryGreen/10 via-green-50 to-emerald-50 dark:from-primaryGreen/20 dark:via-green-900/20 dark:to-emerald-900/20 border border-green-100 dark:border-green-800/50 rounded-lg">
        <div class="px-6 py-4">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-3">
                    <div class="w-8 h-8 bg-primaryGreen rounded-lg flex items-center justify-center">
                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                        </svg>
                    </div>
                    <div>
                        <h2 class="text-lg font-semibold text-gray-900 dark:text-white">
                            Welcome back, {{ Auth::user()->name ?? 'Partner' }}! 👋
                        </h2>
                        <p class="text-sm text-gray-600 dark:text-gray-400">
                            Here's what's happening with your exam management system today
                        </p>
                    </div>
                </div>
                
                <!-- Quick Stats -->
                <div class="hidden lg:flex items-center space-x-6">
                    <div class="text-center">
                        <div class="text-2xl font-bold text-primaryGreen">{{ $stats['total_questions'] ?? 0 }}</div>
                        <div class="text-xs text-gray-500 dark:text-gray-400 font-medium">Total Questions</div>
                    </div>
                    <div class="text-center">
                        <div class="text-2xl font-bold text-primaryGreen">{{ $stats['total_exams'] ?? 0 }}</div>
                        <div class="text-xs text-gray-500 dark:text-gray-400 font-medium">Active Exams</div>
                    </div>
                    <div class="text-center">
                        <div class="text-2xl font-bold text-primaryGreen">{{ $stats['total_students'] ?? 0 }}</div>
                        <div class="text-xs text-gray-500 dark:text-gray-400 font-medium">Enrolled Students</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <!-- Total Questions -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6 border border-gray-200 dark:border-gray-700">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-blue-100 dark:bg-blue-900">
                    <svg class="w-6 h-6 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Total Questions</p>
                    <p class="text-2xl font-semibold text-gray-900 dark:text-white">{{ $stats['total_questions'] }}</p>
                </div>
            </div>
        </div>

        <!-- Question Sets -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6 border border-gray-200 dark:border-gray-700">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-green-100 dark:bg-green-900">
                    <svg class="w-6 h-6 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Question Sets</p>
                    <p class="text-2xl font-semibold text-gray-900 dark:text-white">{{ $stats['total_question_sets'] }}</p>
                </div>
            </div>
        </div>

        <!-- Total Exams -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6 border border-gray-200 dark:border-gray-700">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-orange-100 dark:bg-orange-900">
                    <svg class="w-6 h-6 text-orange-600 dark:text-orange-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Total Exams</p>
                    <p class="text-2xl font-semibold text-gray-900 dark:text-white">{{ $stats['total_exams'] }}</p>
                </div>
            </div>
        </div>

        <!-- Total Students -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6 border border-gray-200 dark:border-gray-700">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-purple-100 dark:bg-purple-900">
                    <svg class="w-6 h-6 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Total Students</p>
                    <p class="text-2xl font-semibold text-gray-900 dark:text-white">{{ $stats['total_students'] }}</p>
                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">From Database</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Activities -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Recent Exams -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md border border-gray-200 dark:border-gray-700">
            <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Recent Exams</h3>
            </div>
            <div class="p-6">
                @if($recent_exams->count() > 0)
                    <div class="space-y-4">
                        @foreach($recent_exams as $exam)
                            <div class="flex items-center justify-between p-4 bg-gray-50 dark:bg-gray-700 rounded-lg">
                                <div>
                                    <h4 class="font-medium text-gray-900 dark:text-white">{{ $exam->title }}</h4>
                                    <p class="text-sm text-gray-600 dark:text-gray-400">
                                        {{ $exam->questionSet->name }} • {{ $exam->status }}
                                    </p>
                                </div>
                                <div class="text-right">
                                    <p class="text-sm text-gray-600 dark:text-gray-400">
                                        {{ $exam->start_time->format('M d, Y') }}
                                    </p>
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                        @if($exam->status === 'published') bg-green-100 text-green-800
                                        @elseif($exam->status === 'draft') bg-gray-100 text-gray-800
                                        @else bg-yellow-100 text-yellow-800 @endif">
                                        {{ ucfirst($exam->status) }}
                                    </span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-gray-500 dark:text-gray-400 text-center py-4">No recent exams</p>
                @endif
            </div>
        </div>

        <!-- Recent Results -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md border border-gray-200 dark:border-gray-700">
            <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Recent Results</h3>
            </div>
            <div class="p-6">
                @if($recent_results->count() > 0)
                    <div class="space-y-4">
                        @foreach($recent_results as $result)
                            <div class="flex items-center justify-between p-4 bg-gray-50 dark:bg-gray-700 rounded-lg">
                                <div>
                                    <h4 class="font-medium text-gray-900 dark:text-white">{{ $result->student->full_name }}</h4>
                                    <p class="text-sm text-gray-600 dark:text-gray-400">{{ $result->exam->title }}</p>
                                </div>
                                <div class="text-right">
                                    <p class="text-lg font-semibold text-gray-900 dark:text-white">
                                        {{ number_format($result->percentage, 1) }}%
                                    </p>
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                        @if($result->percentage >= 80) bg-green-100 text-green-800
                                        @elseif($result->percentage >= 60) bg-yellow-100 text-yellow-800
                                        @else bg-red-100 text-red-800 @endif">
                                        {{ $result->grade }}
                                    </span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-gray-500 dark:text-gray-400 text-center py-4">No recent results</p>
                @endif
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md border border-gray-200 dark:border-gray-700">
        <div class="p-6 border-b border-gray-200 dark:border-gray-700">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Quick Actions</h3>
        </div>
        <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                <a href="{{ route('partner.questions.create') }}" 
                   class="flex items-center p-4 bg-blue-50 dark:bg-blue-900/20 rounded-lg hover:bg-blue-100 dark:hover:bg-blue-900/30 transition-colors duration-200">
                    <svg class="w-8 h-8 text-blue-600 dark:text-blue-400 mr-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                    <div>
                        <h4 class="font-medium text-gray-900 dark:text-white">Add Question</h4>
                        <p class="text-sm text-gray-600 dark:text-gray-400">Create new MCQ question</p>
                    </div>
                </a>

                <a href="{{ route('partner.question-sets.create') }}" 
                   class="flex items-center p-4 bg-green-50 dark:bg-green-900/20 rounded-lg hover:bg-green-100 dark:hover:bg-green-900/30 transition-colors duration-200">
                    <svg class="w-8 h-8 text-green-600 dark:text-green-400 mr-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    <div>
                        <h4 class="font-medium text-gray-900 dark:text-white">Create Question Set</h4>
                        <p class="text-sm text-gray-600 dark:text-gray-400">Group questions together</p>
                    </div>
                </a>

                <a href="{{ route('partner.exams.create') }}" 
                   class="flex items-center p-4 bg-orange-50 dark:bg-orange-900/20 rounded-lg hover:bg-orange-100 dark:hover:bg-orange-900/30 transition-colors duration-200">
                    <svg class="w-8 h-8 text-orange-600 dark:text-orange-400 mr-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                    </svg>
                    <div>
                        <h4 class="font-medium text-gray-900 dark:text-white">Schedule Exam</h4>
                        <p class="text-sm text-gray-600 dark:text-gray-400">Create new exam</p>
                    </div>
                </a>

                <a href="#" 
                   class="flex items-center p-4 bg-indigo-50 dark:bg-indigo-900/20 rounded-lg hover:bg-indigo-100 dark:hover:bg-indigo-900/30 transition-colors duration-200">
                    <svg class="w-8 h-8 text-indigo-600 dark:text-indigo-400 mr-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                    </svg>
                    <div>
                        <h4 class="font-medium text-gray-900 dark:text-white">Typing Test</h4>
                        <p class="text-sm text-gray-600 dark:text-gray-400">Create typing assessment</p>
                    </div>
                </a>

                <!-- Logout Action -->
                <form method="POST" action="{{ route('logout') }}" class="block">
                    @csrf
                    <button type="submit" 
                            onclick="return confirm('Are you sure you want to logout?')"
                            class="w-full flex items-center p-4 bg-red-50 dark:bg-red-900/20 rounded-lg hover:bg-red-100 dark:hover:bg-red-900/30 transition-colors duration-200 text-left">
                        <svg class="w-8 h-8 text-red-600 dark:text-red-400 mr-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                        </svg>
                        <div>
                            <h4 class="font-medium text-gray-900 dark:text-white">Logout</h4>
                            <p class="text-sm text-gray-600 dark:text-gray-400">Sign out of your account</p>
                        </div>
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- JavaScript for Dark Mode Toggle -->
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const themeToggle = document.getElementById('theme-toggle');
        const htmlTag = document.documentElement;
        
        // Check for saved theme preference in local storage
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
    });
</script>
@endsection 
