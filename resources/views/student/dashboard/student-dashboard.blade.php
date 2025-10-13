@extends('layouts.student-layout')

@section('title', 'Student Dashboard')

@section('content')
<div class="min-h-screen bg-gray-50 dark:bg-gray-900">
    <!-- Header Section -->
    <div class="px-4 sm:px-6 lg:px-8 py-6">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div>
                <h1 class="text-2xl sm:text-3xl font-bold text-gray-900 dark:text-white">
                    Student Dashboard
                </h1>
                <p class="text-gray-600 dark:text-gray-400 text-sm mt-1">
                    Your personalized learning overview
                </p>
            </div>
            <div class="flex flex-wrap gap-2">
                <a href="{{ route('student.exams.available') }}" 
                   class="px-4 py-2 rounded-lg bg-green-600 hover:bg-green-700 text-white text-sm font-medium transition-colors duration-200 flex items-center">
                    <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    Take Exam
                </a>
                <a href="{{ route('student.exams.history') }}" 
                   class="px-4 py-2 rounded-lg bg-orange-600 hover:bg-orange-700 text-white text-sm font-medium transition-colors duration-200 flex items-center">
                    <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                    </svg>
                    Exam History
                </a>
                <a href="{{ route('typing.test') }}" 
                   class="px-4 py-2 rounded-lg bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium transition-colors duration-200 flex items-center">
                    <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 4a2 2 0 114 0v1a1 1 0 001 1h3a1 1 0 011 1v3a1 1 0 01-1 1h-1a2 2 0 100 4h1a1 1 0 001 1v3a1 1 0 011 1h-3a1 1 0 01-1-1v-1a2 2 0 10-4 0v1a1 1 0 01-1 1H7a1 1 0 01-1-1v-3a1 1 0 00-1-1H4a2 2 0 110-4h1a1 1 0 001-1V4z"></path>
                    </svg>
                    Typing Test
                </a>
            </div>
        </div>
    </div>

    <!-- Status Cards Section -->
    <div class="px-4 sm:px-6 lg:px-8 pb-6">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            <!-- Enrollment Status -->
            <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-4 shadow-sm">
                <div class="flex items-center">
                    <div class="p-2 rounded-lg bg-blue-100 dark:bg-blue-900/50">
                        <svg class="w-5 h-5 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-xs text-gray-500 dark:text-gray-400 font-medium">Enrollment</p>
                        <p class="text-sm font-semibold text-gray-900 dark:text-white mt-1">
                            @if(isset($student) && $student->isCurrentlyEnrolled())
                                <span class="inline-flex items-center text-green-600 dark:text-green-400">
                                    <span class="h-2 w-2 rounded-full bg-green-600 dark:bg-green-400 mr-1"></span>
                                    Active
                                </span>
                            @else
                                <span class="inline-flex items-center text-amber-600 dark:text-amber-400">
                                    <span class="h-2 w-2 rounded-full bg-amber-600 dark:bg-amber-400 mr-1"></span>
                                    Inactive
                                </span>
                            @endif
                        </p>
                    </div>
                </div>
            </div>

            <!-- Course Information -->
            <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-4 shadow-sm">
                <div class="flex items-center">
                    <div class="p-2 rounded-lg bg-purple-100 dark:bg-purple-900/50">
                        <svg class="w-5 h-5 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-xs text-gray-500 dark:text-gray-400 font-medium">Course</p>
                        <p class="text-sm font-semibold text-gray-900 dark:text-white mt-1 truncate max-w-[120px]">
                            {{ $my_course->name ?? 'Not assigned' }}
                        </p>
                    </div>
                </div>
            </div>

            <!-- Batch Information -->
            <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-4 shadow-sm">
                <div class="flex items-center">
                    <div class="p-2 rounded-lg bg-green-100 dark:bg-green-900/50">
                        <svg class="w-5 h-5 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-xs text-gray-500 dark:text-gray-400 font-medium">Batch</p>
                        <p class="text-sm font-semibold text-gray-900 dark:text-white mt-1 truncate max-w-[120px]">
                            {{ $my_batch->name ?? 'Not assigned' }}
                        </p>
                    </div>
                </div>
            </div>

            <!-- Learning Strike -->
            <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-4 shadow-sm">
                <div class="flex items-center">
                    <div class="p-2 rounded-lg bg-amber-100 dark:bg-amber-900/50">
                        <svg class="w-5 h-5 text-amber-600 dark:text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-xs text-gray-500 dark:text-gray-400 font-medium">Learning Strike</p>
                        <p class="text-sm font-semibold text-gray-900 dark:text-white mt-1">
                            @if(isset($student) && $student->enroll_date)
                                <span class="inline-flex items-center text-green-600 dark:text-green-400">
                                    <span class="h-2 w-2 rounded-full bg-green-600 dark:bg-green-400 mr-1"></span>
                                    {{ abs($student->enroll_date->startOfDay()->diffInDays(now()->startOfDay())) }} days
                                </span>
                            @else
                                <span class="inline-flex items-center text-gray-500 dark:text-gray-400">
                                    <span class="h-2 w-2 rounded-full bg-gray-500 dark:bg-gray-400 mr-1"></span>
                                    Not available
                                </span>
                            @endif
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Dashboard Content -->
    <div class="px-4 sm:px-6 lg:px-8 pb-10 space-y-6">
        <!-- Performance Overview Cards -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            <!-- Exams Taken -->
            <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-5 shadow-sm hover:shadow-md transition-shadow duration-200">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-500 dark:text-gray-400 font-medium">Exams Taken</p>
                        <p class="text-2xl font-bold text-gray-900 dark:text-white mt-1">{{ $stats['total_exams_taken'] ?? 0 }}</p>
                    </div>
                    <div class="p-3 rounded-lg bg-blue-100 dark:bg-blue-900/50">
                        <svg class="w-6 h-6 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                        </svg>
                    </div>
                </div>
                <div class="mt-3">
                    <p class="text-xs text-gray-500 dark:text-gray-400">
                        @php
                            // Calculate exams taken this month
                            $examsThisMonth = 0;
                            if (isset($recent_results)) {
                                $examsThisMonth = $recent_results->filter(function($result) {
                                    return $result->completed_at && $result->completed_at->month == now()->month && $result->completed_at->year == now()->year;
                                })->count();
                            }
                        @endphp
                        @if($examsThisMonth > 0)
                            <span class="text-green-600 dark:text-green-400 font-medium">+{{ $examsThisMonth }} this month</span>
                        @else
                            <span class="text-gray-500 dark:text-gray-400">No exams this month</span>
                        @endif
                    </p>
                </div>
            </div>

            <!-- Passed Exams -->
            <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-5 shadow-sm hover:shadow-md transition-shadow duration-200">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-500 dark:text-gray-400 font-medium">Passed Exams</p>
                        <p class="text-2xl font-bold text-gray-900 dark:text-white mt-1">{{ $stats['passed_exams'] ?? 0 }}</p>
                    </div>
                    <div class="p-3 rounded-lg bg-green-100 dark:bg-green-900/50">
                        <svg class="w-6 h-6 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                </div>
                <div class="mt-3">
                    <p class="text-xs text-gray-500 dark:text-gray-400">
                        @if(($stats['total_exams_taken'] ?? 0) > 0)
                            <span class="font-medium">{{ round((($stats['passed_exams'] ?? 0) / ($stats['total_exams_taken'] ?? 1)) * 100) }}%</span>
                            <span class="ml-1">success rate</span>
                        @else
                            <span class="ml-1">No exams taken yet</span>
                        @endif
                    </p>
                </div>
            </div>

            <!-- Average Score -->
            <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-5 shadow-sm hover:shadow-md transition-shadow duration-200">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-500 dark:text-gray-400 font-medium">Average Score</p>
                        <p class="text-2xl font-bold text-gray-900 dark:text-white mt-1">{{ number_format($stats['average_score'] ?? 0, 1) }}%</p>
                    </div>
                    <div class="p-3 rounded-lg bg-purple-100 dark:bg-purple-900/50">
                        <svg class="w-6 h-6 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 8v8m-4-5v5m-4-2v2m-2 4h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                </div>
                <div class="mt-3">
                    <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-2">
                        <div class="bg-purple-600 h-2 rounded-full" style="width: {{ min(($stats['average_score'] ?? 0), 100) }}%"></div>
                    </div>
                </div>
            </div>

            <!-- Upcoming Exams -->
            <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-5 shadow-sm hover:shadow-md transition-shadow duration-200">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-500 dark:text-gray-400 font-medium">Upcoming Exams</p>
                        <p class="text-2xl font-bold text-gray-900 dark:text-white mt-1">{{ $stats['upcoming_exams'] ?? 0 }}</p>
                    </div>
                    <div class="p-3 rounded-lg bg-amber-100 dark:bg-amber-900/50">
                        <svg class="w-6 h-6 text-amber-600 dark:text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                </div>
                <div class="mt-3">
                    <p class="text-xs text-gray-500 dark:text-gray-400">
                        @if(($stats['upcoming_exams'] ?? 0) > 0)
                            <span class="text-amber-600 dark:text-amber-400 font-medium">Prepare now</span>
                        @else
                            <span class="text-green-600 dark:text-green-400 font-medium">No upcoming exams</span>
                        @endif
                    </p>
                </div>
            </div>
        </div>

        <!-- Course Progress & Upcoming Exams -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Left Column: Course Progress -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Course Information -->
                <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-6 shadow-sm">
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
                        <div>
                            <h2 class="text-lg font-semibold text-gray-900 dark:text-white">My Progress</h2>
                            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                                {{ $my_course->name ?? 'Not assigned' }} 
                                @if(isset($my_course) && $my_course->code)
                                    <span class="text-gray-400">({{ $my_course->code }})</span>
                                @endif
                            </p>
                        </div>
                        @if(isset($my_course) && $my_course->duration)
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-900/50 dark:text-blue-300">
                                {{ $my_course->duration }} days duration
                            </span>
                        @endif
                    </div>

                    <!-- Syllabus Progress -->
                    <div class="mb-6">
                        <div class="flex items-center justify-between mb-2">
                            <span class="text-sm font-medium text-gray-700 dark:text-gray-300">Overall Progress</span>
                            <span class="text-sm font-medium text-gray-900 dark:text-white">{{ $stats['syllabus_completion'] ?? 0 }}%</span>
                        </div>
                        <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-3">
                            <div class="bg-gradient-to-r from-emerald-500 to-emerald-600 h-3 rounded-full" 
                                 style="width: {{ $stats['syllabus_completion'] ?? 0 }}%"></div>
                        </div>
                    </div>

                    <!-- Subject Progress -->
                    <div>
                        <h3 class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-3">Subject Progress</h3>
                        <div class="space-y-4">
                            @forelse($subjectProgress ?? collect() as $sp)
                                <div>
                                    <div class="flex items-center justify-between text-sm mb-1">
                                        <span class="font-medium text-gray-900 dark:text-white">{{ $sp['subject']->name }}</span>
                                        <span class="text-gray-600 dark:text-gray-400">{{ $sp['percent'] }}%</span>
                                    </div>
                                    <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-2">
                                        <div class="bg-indigo-500 h-2 rounded-full" style="width: {{ $sp['percent'] }}%"></div>
                                    </div>
                                </div>
                            @empty
                                <p class="text-sm text-gray-500 dark:text-gray-400">No subject progress data available.</p>
                            @endforelse
                        </div>
                    </div>
                </div>

                <!-- Upcoming Exams -->
                {{-- Removed as per user request --}}
            </div>

            <!-- Right Column: Rankings & Recent Results -->
            <div class="space-y-6">
                <!-- Rankings -->
                <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-6 shadow-sm">
                    <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">My Standings</h2>
                    <div class="space-y-4">
                        <div class="flex items-center justify-between p-3 rounded-lg bg-gray-50 dark:bg-gray-700/50">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 w-8 h-8 rounded-full bg-blue-100 dark:bg-blue-900/50 flex items-center justify-center mr-3">
                                    <svg class="w-4 h-4 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                    </svg>
                                </div>
                                <span class="text-sm font-medium text-gray-600 dark:text-gray-300">Rank In Course</span>
                            </div>
                            <span class="text-sm font-semibold text-gray-900 dark:text-white">{{ $stats['course_rank'] ?? '—' }}</span>
                        </div>
                        
                        <div class="flex items-center justify-between p-3 rounded-lg bg-gray-50 dark:bg-gray-700/50">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 w-8 h-8 rounded-full bg-green-100 dark:bg-green-900/50 flex items-center justify-center mr-3">
                                    <svg class="w-4 h-4 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                    </svg>
                                </div>
                                <span class="text-sm font-medium text-gray-600 dark:text-gray-300">Rank In Batch</span>
                            </div>
                            <span class="text-sm font-semibold text-gray-900 dark:text-white">{{ $stats['batch_rank'] ?? '—' }}</span>
                        </div>
                        
                        <div class="flex items-center justify-between p-3 rounded-lg bg-gray-50 dark:bg-gray-700/50">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 w-8 h-8 rounded-full bg-purple-100 dark:bg-purple-900/50 flex items-center justify-center mr-3">
                                    <svg class="w-4 h-4 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                                <span class="text-sm font-medium text-gray-600 dark:text-gray-300">Batchmates' Exams Faced</span>
                            </div>
                            <span class="text-sm font-semibold text-gray-900 dark:text-white">{{ $stats['batchmate_exam_faced'] ?? 0 }}</span>
                        </div>
                    </div>
                </div>

                <!-- Recent Results -->
                <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 shadow-sm">
                    <div class="p-5 border-b border-gray-200 dark:border-gray-700">
                        <h2 class="text-lg font-semibold text-gray-900 dark:text-white">Recent Results</h2>
                    </div>
                    <div class="p-5">
                        @if(($recent_results ?? collect())->count() > 0)
                            <div class="space-y-4">
                                @foreach(($recent_results ?? collect())->take(4) as $result)
                                    <div class="flex items-center justify-between p-4 rounded-lg border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-700/50">
                                        <div class="flex-1 min-w-0">
                                            <h3 class="text-sm font-semibold text-gray-900 dark:text-white truncate">{{ $result->exam->title }}</h3>
                                            <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                                                {{ optional($result->completed_at)->format('M d, Y') }}
                                            </p>
                                        </div>
                                        <div class="ml-4 text-right">
                                            <p class="text-sm font-semibold text-gray-900 dark:text-white">{{ number_format($result->percentage ?? 0, 1) }}%</p>
                                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-medium
                                                @if(($result->percentage ?? 0) >= 80) bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-300
                                                @elseif(($result->percentage ?? 0) >= 60) bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-300
                                                @else bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-300 @endif">
                                                {{ $result->grade }}
                                            </span>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            @if(($recent_results ?? collect())->count() > 4)
                                <div class="mt-4 text-center">
                                    <a href="{{ route('student.exams.history') }}" 
                                       class="text-sm font-medium text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300">
                                        View all results
                                    </a>
                                </div>
                            @endif
                        @else
                            <div class="text-center py-8">
                                <svg class="mx-auto h-12 w-12 text-gray-400 dark:text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                                <h3 class="mt-2 text-sm font-medium text-gray-900 dark:text-white">No exam results yet</h3>
                                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Take your first exam to see results here.</p>
                                <div class="mt-4">
                                    <a href="{{ route('student.exams.available') }}" 
                                       class="inline-flex items-center px-3 py-1.5 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                                        Take Exam
                                    </a>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection