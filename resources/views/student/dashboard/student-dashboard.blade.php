@extends('layouts.student-layout')

@section('title', 'Student Dashboard')

@section('content')
<div class="min-h-screen bg-gray-50 dark:bg-[#0d1117] transition-colors duration-500">
    <div class="sticky top-0 z-10 bg-white/95 dark:bg-[#161b22]/95 backdrop-blur-sm shadow-md border-b border-gray-200 dark:border-gray-800 px-4 sm:px-6 lg:px-8 py-3">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-2">
            <div>
                <h1 class="text-xl sm:text-2xl font-extrabold text-gray-900 dark:text-white leading-tight">
                    🚀 Student Dashboard
                </h1>
                <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">
                    Your personalized learning overview and performance insights
                </p>
            </div>
            </div>
    </div>

    <div class="px-4 sm:px-6 lg:px-8 py-6 space-y-7">
        
        <section class="grid grid-cols-2 md:grid-cols-4 gap-4" aria-labelledby="status-cards-heading">
            <h2 id="status-cards-heading" class="sr-only">Enrollment and Status Information</h2>
            
            <div class="bg-white dark:bg-[#161b22] rounded-xl shadow-lg border border-gray-100 dark:border-gray-800 p-4 transition-all duration-300 hover:shadow-xl hover:scale-[1.01]">
                <div class="flex flex-col items-start">
                    <div class="p-2 rounded-lg bg-blue-500/10 dark:bg-blue-900/40">
                        <svg class="w-5 h-5 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                        </svg>
                    </div>
                    <p class="text-[10px] text-gray-500 dark:text-gray-400 font-medium mt-3 uppercase tracking-wider">Enrollment</p>
                    <p class="text-base font-extrabold text-gray-900 dark:text-white mt-1">
                        @if(isset($student) && $student->isCurrentlyEnrolled())
                            <span class="inline-flex items-center text-green-500 dark:text-green-400">
                                <span class="h-2 w-2 rounded-full bg-green-500 dark:bg-green-400 mr-1 animate-pulse"></span>
                                Active
                            </span>
                        @else
                            <span class="inline-flex items-center text-amber-500 dark:text-amber-400">
                                <span class="h-2 w-2 rounded-full bg-amber-500 dark:bg-amber-400 mr-1"></span>
                                Inactive
                            </span>
                        @endif
                    </p>
                </div>
            </div>

            <div class="bg-white dark:bg-[#161b22] rounded-xl shadow-lg border border-gray-100 dark:border-gray-800 p-4 transition-all duration-300 hover:shadow-xl hover:scale-[1.01]">
                <div class="flex flex-col items-start">
                    <div class="p-2 rounded-lg bg-purple-500/10 dark:bg-purple-900/40">
                        <svg class="w-5 h-5 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                        </svg>
                    </div>
                    <p class="text-[10px] text-gray-500 dark:text-gray-400 font-medium mt-3 uppercase tracking-wider">Course</p>
                    <p class="text-base font-extrabold text-gray-900 dark:text-white mt-1 truncate max-w-full">
                        {{ $my_course->name ?? 'Not assigned' }}
                    </p>
                </div>
            </div>

            <div class="bg-white dark:bg-[#161b22] rounded-xl shadow-lg border border-gray-100 dark:border-gray-800 p-4 transition-all duration-300 hover:shadow-xl hover:scale-[1.01]">
                <div class="flex flex-col items-start">
                    <div class="p-2 rounded-lg bg-green-500/10 dark:bg-green-900/40">
                        <svg class="w-5 h-5 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                    </div>
                    <p class="text-[10px] text-gray-500 dark:text-gray-400 font-medium mt-3 uppercase tracking-wider">Batch</p>
                    <p class="text-base font-extrabold text-gray-900 dark:text-white mt-1 truncate max-w-full">
                        {{ $my_batch->name ?? 'Not assigned' }}
                    </p>
                </div>
            </div>

            <div class="bg-white dark:bg-[#161b22] rounded-xl shadow-lg border border-gray-100 dark:border-gray-800 p-4 transition-all duration-300 hover:shadow-xl hover:scale-[1.01]">
                <div class="flex flex-col items-start">
                    <div class="p-2 rounded-lg bg-amber-500/10 dark:bg-amber-900/40">
                        <svg class="w-5 h-5 text-amber-600 dark:text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                    </div>
                    <p class="text-[10px] text-gray-500 dark:text-gray-400 font-medium mt-3 uppercase tracking-wider">Learning Streak</p>
                    <p class="text-base font-extrabold text-gray-900 dark:text-white mt-1">
                        @if(isset($student) && $student->enroll_date)
                            <span class="inline-flex items-center text-amber-600 dark:text-amber-400">
                                {{ abs($student->enroll_date->startOfDay()->diffInDays(now()->startOfDay())) }} days 🔥
                            </span>
                        @else
                            <span class="inline-flex items-center text-gray-500 dark:text-gray-400">
                                Not available
                            </span>
                        @endif
                    </p>
                </div>
            </div>
        </section>

        <section class="grid grid-cols-2 md:grid-cols-4 gap-4" aria-labelledby="performance-metrics-heading">
             <h2 id="performance-metrics-heading" class="sr-only">Performance Metrics</h2>

            <div class="bg-white dark:bg-[#161b22] rounded-xl shadow-lg border border-gray-100 dark:border-gray-800 p-5 transition-all duration-300 hover:shadow-xl hover:border-blue-500 dark:hover:border-blue-700">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs text-gray-500 dark:text-gray-400 font-medium">Exams Taken</p>
                        <p class="text-2xl font-extrabold text-gray-900 dark:text-white mt-1">{{ $stats['total_exams_taken'] ?? 0 }}</p>
                    </div>
                    <div class="p-3 rounded-full bg-blue-500/10 dark:bg-blue-900/40">
                        <svg class="w-6 h-6 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                        </svg>
                    </div>
                </div>
                <div class="mt-3 text-[10px]">
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
                        <span class="text-green-500 dark:text-green-400 font-semibold">+{{ $examsThisMonth }} this month</span>
                    @else
                        <span class="text-gray-500 dark:text-gray-400">No exams this month</span>
                    @endif
                </div>
            </div>

            <div class="bg-white dark:bg-[#161b22] rounded-xl shadow-lg border border-gray-100 dark:border-gray-800 p-5 transition-all duration-300 hover:shadow-xl hover:border-green-500 dark:hover:border-green-700">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs text-gray-500 dark:text-gray-400 font-medium">Passed Exams</p>
                        <p class="text-2xl font-extrabold text-gray-900 dark:text-white mt-1">{{ $stats['passed_exams'] ?? 0 }}</p>
                    </div>
                    <div class="p-3 rounded-full bg-green-500/10 dark:bg-green-900/40">
                        <svg class="w-6 h-6 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                </div>
                <div class="mt-3 text-[10px]">
                    @if(($stats['total_exams_taken'] ?? 0) > 0)
                        <span class="text-gray-900 dark:text-white font-semibold">{{ round((($stats['passed_exams'] ?? 0) / ($stats['total_exams_taken'] ?? 1)) * 100) }}%</span>
                        <span class="text-gray-500 dark:text-gray-400">success rate</span>
                    @else
                        <span class="text-gray-500 dark:text-gray-400">No exams taken yet</span>
                    @endif
                </div>
            </div>

            <div class="bg-white dark:bg-[#161b22] rounded-xl shadow-lg border border-gray-100 dark:border-gray-800 p-5 transition-all duration-300 hover:shadow-xl hover:border-purple-500 dark:hover:border-purple-700">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs text-gray-500 dark:text-gray-400 font-medium">Average Score</p>
                        <p class="text-2xl font-extrabold text-gray-900 dark:text-white mt-1">{{ number_format($stats['average_score'] ?? 0, 1) }}%</p>
                    </div>
                    <div class="p-3 rounded-full bg-purple-500/10 dark:bg-purple-900/40">
                        <svg class="w-6 h-6 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 8v8m-4-5v5m-4-2v2m-2 4h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                </div>
                <div class="mt-3">
                    <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-2">
                        <div class="bg-gradient-to-r from-purple-500 to-indigo-600 h-2 rounded-full transition-all duration-500" style="width: {{ min(($stats['average_score'] ?? 0), 100) }}%"></div>
                    </div>
                </div>
            </div>

            <div class="bg-white dark:bg-[#161b22] rounded-xl shadow-lg border border-gray-100 dark:border-gray-800 p-5 transition-all duration-300 hover:shadow-xl hover:border-amber-500 dark:hover:border-amber-700">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs text-gray-500 dark:text-gray-400 font-medium">Upcoming Exams</p>
                        <p class="text-2xl font-extrabold text-gray-900 dark:text-white mt-1">{{ $stats['upcoming_exams'] ?? 0 }}</p>
                    </div>
                    <div class="p-3 rounded-full bg-amber-500/10 dark:bg-amber-900/40">
                        <svg class="w-6 h-6 text-amber-600 dark:text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                </div>
                <div class="mt-3 text-[10px]">
                    @if(($stats['upcoming_exams'] ?? 0) > 0)
                        <span class="text-amber-500 dark:text-amber-400 font-semibold">Ready to test your knowledge!</span>
                    @else
                        <span class="text-green-500 dark:text-green-400 font-semibold">No upcoming exams</span>
                    @endif
                </div>
            </div>
        </section>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            
            <div class="lg:col-span-2 space-y-6">
                
                <div class="bg-white dark:bg-[#161b22] rounded-2xl shadow-xl border border-gray-100 dark:border-gray-800 p-5">
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-5">
                        <div>
                            <h2 class="text-lg font-extrabold text-gray-900 dark:text-white">🎓 My Course Progress</h2>
                            <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                                {{ $my_course->name ?? 'Not assigned' }} 
                                @if(isset($my_course) && $my_course->code)
                                    <span class="text-gray-400 dark:text-gray-500">({{ $my_course->code }})</span>
                                @endif
                            </p>
                        </div>
                        <div class="flex items-center space-x-2">
                            @if(isset($my_course) && $my_course->duration)
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[10px] font-medium bg-blue-500/10 text-blue-600 dark:bg-blue-900/30 dark:text-blue-300 border border-blue-200 dark:border-blue-900">
                                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                    {{ $my_course->duration }} days duration
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="mb-7 p-4 bg-gray-50 dark:bg-gray-800/50 rounded-lg border border-dashed border-gray-200 dark:border-gray-700">
                        <div class="flex items-center justify-between mb-2">
                            <span class="text-sm font-semibold text-gray-700 dark:text-gray-300">Overall Course Completion</span>
                            <span class="text-xl font-extrabold text-emerald-600 dark:text-emerald-400">{{ $stats['syllabus_completion'] ?? 0 }}%</span>
                        </div>
                        <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-3 shadow-inner">
                            <div class="bg-gradient-to-r from-emerald-500 to-teal-600 h-3 rounded-full transition-all duration-700 ease-out" 
                                 style="width: {{ $stats['syllabus_completion'] ?? 0 }}%"></div>
                        </div>
                    </div>

                    <div>
                        <h3 class="text-sm font-bold text-gray-700 dark:text-gray-300 mb-3 border-b border-gray-100 dark:border-gray-800 pb-2">Subject Breakdown</h3>
                        <div class="space-y-4">
                            @forelse($subjectProgress ?? collect() as $sp)
                                <div class="group">
                                    <div class="flex items-center justify-between text-xs mb-1">
                                        <span class="font-semibold text-gray-900 dark:text-white group-hover:text-indigo-500 transition-colors">{{ $sp['subject']->name }}</span>
                                        <span class="text-sm font-bold text-gray-600 dark:text-gray-400">{{ number_format($sp['percent'], 1) }}%</span>
                                    </div>
                                    <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-1.5">
                                        <div class="bg-gradient-to-r from-indigo-500 to-purple-600 h-1.5 rounded-full shadow-md transition-all duration-700 ease-out" style="width: {{ $sp['percent'] }}%"></div>
                                    </div>
                                </div>
                            @empty
                                <p class="text-sm text-gray-500 dark:text-gray-400 py-3 text-center">No subject progress data available. Start your first lesson!</p>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>

            <div class="lg:col-span-1 space-y-6">
                
                <div class="bg-white dark:bg-[#161b22] rounded-2xl shadow-xl border border-gray-100 dark:border-gray-800 p-5">
                    <h2 class="text-lg font-extrabold text-gray-900 dark:text-white mb-4">🏆 My Standings</h2>
                    <div class="space-y-3">
                        
                        <div class="flex items-center justify-between p-3 rounded-xl bg-gray-50 dark:bg-gray-800/50 border border-gray-200 dark:border-gray-700 transition-shadow duration-300 hover:shadow-md">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 w-7 h-7 rounded-full bg-blue-500/20 dark:bg-blue-900/40 flex items-center justify-center mr-3">
                                    <svg class="w-4 h-4 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                    </svg>
                                </div>
                                <span class="text-xs font-medium text-gray-600 dark:text-gray-300">Rank In Course</span>
                            </div>
                            <span class="text-base font-extrabold text-blue-600 dark:text-blue-400">{{ $stats['course_rank'] ?? '—' }}</span>
                        </div>
                        
                        <div class="flex items-center justify-between p-3 rounded-xl bg-gray-50 dark:bg-gray-800/50 border border-gray-200 dark:border-gray-700 transition-shadow duration-300 hover:shadow-md">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 w-7 h-7 rounded-full bg-green-500/20 dark:bg-green-900/40 flex items-center justify-center mr-3">
                                    <svg class="w-4 h-4 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                    </svg>
                                </div>
                                <span class="text-xs font-medium text-gray-600 dark:text-gray-300">Rank In Batch</span>
                            </div>
                            <span class="text-base font-extrabold text-green-600 dark:text-green-400">{{ $stats['batch_rank'] ?? '—' }}</span>
                        </div>
                        
                        <div class="flex items-center justify-between p-3 rounded-xl bg-gray-50 dark:bg-gray-800/50 border border-gray-200 dark:border-gray-700 transition-shadow duration-300 hover:shadow-md">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 w-7 h-7 rounded-full bg-purple-500/20 dark:bg-purple-900/40 flex items-center justify-center mr-3">
                                    <svg class="w-4 h-4 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                                <span class="text-xs font-medium text-gray-600 dark:text-gray-300">Batchmates' Exams Faced</span>
                            </div>
                            <span class="text-base font-extrabold text-purple-600 dark:text-purple-400">{{ $stats['batchmate_exam_faced'] ?? 0 }}</span>
                        </div>
                    </div>
                </div>

                <div class="bg-white dark:bg-[#161b22] rounded-2xl shadow-xl border border-gray-100 dark:border-gray-800">
                    <div class="p-4 border-b border-gray-100 dark:border-gray-800">
                        <h2 class="text-lg font-extrabold text-gray-900 dark:text-white">📝 Recent Results</h2>
                    </div>
                    <div class="p-4">
                        @if(($recent_results ?? collect())->count() > 0)
                            <div class="space-y-3">
                                @foreach(($recent_results ?? collect())->take(4) as $result)
                                    @php
                                        $percentage = $result->percentage ?? 0;
                                        if ($percentage >= 80) {
                                            $colorClass = 'bg-green-500/10 text-green-600 dark:bg-green-900/40 dark:text-green-300';
                                            $badgeClass = 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-300';
                                        } elseif ($percentage >= 60) {
                                            $colorClass = 'bg-yellow-500/10 text-yellow-600 dark:bg-yellow-900/40 dark:text-yellow-300';
                                            $badgeClass = 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-300';
                                        } else {
                                            $colorClass = 'bg-red-500/10 text-red-600 dark:bg-red-900/40 dark:text-red-300';
                                            $badgeClass = 'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-300';
                                        }
                                    @endphp
                                    
                                    <div class="flex items-center justify-between p-3 rounded-xl border border-gray-200 dark:border-gray-700 {{ $colorClass }} transition-transform duration-300 hover:scale-[1.02]">
                                        <div class="flex-1 min-w-0 pr-4">
                                            <h3 class="text-xs font-semibold text-gray-900 dark:text-white truncate">{{ $result->exam->title }}</h3>
                                            <p class="text-[10px] text-gray-500 dark:text-gray-400 mt-0.5">
                                                Completed: {{ optional($result->completed_at)->format('M d, Y') }}
                                            </p>
                                        </div>
                                        <div class="ml-4 text-right">
                                            <p class="text-sm font-extrabold text-gray-900 dark:text-white">{{ number_format($percentage, 1) }}%</p>
                                            <span class="inline-flex items-center px-1.5 py-0.5 rounded-full text-[9px] font-medium {{ $badgeClass }} mt-0.5">
                                                {{ $result->grade }}
                                            </span>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            @if(($recent_results ?? collect())->count() > 4)
                                <div class="mt-4 text-center">
                                    <a href="{{ route('student.exams.history') }}" 
                                       class="text-xs font-semibold text-blue-500 hover:text-blue-700 dark:text-blue-400 dark:hover:text-blue-300 transition-colors duration-200 flex items-center justify-center">
                                        View all results 
                                        <svg class="w-3 h-3 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                                    </a>
                                </div>
                            @endif
                        @else
                            <div class="text-center py-7">
                                <svg class="mx-auto h-10 w-10 text-gray-300 dark:text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                                <h3 class="mt-2 text-sm font-semibold text-gray-900 dark:text-white">No exam results yet</h3>
                                <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Take your first exam to see results here and start your journey!</p>
                                <div class="mt-4">
                                    <a href="{{ route('student.exams.available') }}" 
                                       class="inline-flex items-center px-3 py-1.5 border border-transparent text-xs font-medium rounded-full shadow-lg text-white bg-gradient-to-r from-emerald-500 to-green-600 hover:from-emerald-600 hover:to-green-700 transition-all duration-300 transform hover:scale-[1.03]">
                                        <svg class="w-3 h-3 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                                        Start Exam
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

@section('scripts')
<script>
// No scripts needed for this page
</script>
@endsection