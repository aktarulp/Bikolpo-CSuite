@extends('layouts.student-layout')

@section('title', 'My Analytics')

@section('content')
<!-- Ultra Modern Analytics Dashboard -->
<div class="min-h-screen relative overflow-x-hidden bg-gradient-to-br from-slate-50 via-indigo-50 to-purple-100 dark:from-slate-950 dark:via-indigo-950 dark:to-purple-950">
    <!-- Animated Background Pattern -->
    <div class="absolute inset-0 bg-grid-slate-900/[0.02] dark:bg-grid-white/[0.02] bg-[size:60px_60px]"></div>
    
    <!-- Decorative Blobs -->
    <div class="absolute top-0 right-0 w-64 h-64 sm:w-96 sm:h-96 bg-gradient-to-br from-blue-400 to-indigo-600 rounded-full opacity-10 blur-3xl transform translate-x-1/3 -translate-y-1/3"></div>
    <div class="absolute bottom-0 left-0 w-64 h-64 sm:w-96 sm:h-96 bg-gradient-to-tr from-purple-400 to-pink-600 rounded-full opacity-10 blur-3xl transform -translate-x-1/3 translate-y-1/3"></div>
    
    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        
        <!-- Premium Hero Header -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-10">
            <div class="flex items-center gap-4">
                <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-indigo-600 via-purple-600 to-pink-600 flex items-center justify-center shadow-xl shadow-indigo-500/30">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                    </svg>
                </div>
                <div>
                    <h1 class="text-3xl sm:text-4xl font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-indigo-600 via-purple-600 to-pink-600 dark:from-indigo-400 dark:via-purple-400 dark:to-pink-400">
                        Analytics Dashboard
                    </h1>
                    <p class="text-slate-600 dark:text-slate-400 mt-1">Track your academic performance & insights</p>
                </div>
            </div>
            <a href="{{ route('student.dashboard') }}" 
               class="inline-flex items-center gap-2 px-5 py-2.5 bg-white/80 dark:bg-slate-800/80 backdrop-blur-sm hover:bg-white dark:hover:bg-slate-800 text-slate-700 dark:text-slate-300 font-semibold rounded-xl border border-slate-200 dark:border-slate-700 shadow-sm hover:shadow-md transition-all duration-300 hover:-translate-y-0.5">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                <span>Dashboard</span>
            </a>
        </div>

        <!-- Premium Stats Grid -->
        <section class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
            <!-- Total Exams Card -->
            <div class="group relative bg-gradient-to-br from-blue-500 to-indigo-600 rounded-xl p-3 shadow-lg hover:shadow-xl transition-all duration-500 hover:-translate-y-0.5 overflow-hidden">
                <div class="absolute top-0 right-0 w-16 h-16 bg-white/10 rounded-full -translate-y-2 translate-x-2 group-hover:scale-125 transition-transform duration-500"></div>
                <div class="absolute bottom-0 left-0 w-12 h-12 bg-white/10 rounded-full translate-y-2 -translate-x-2 group-hover:scale-125 transition-transform duration-500"></div>
                
                <div class="relative z-10">
                    <div class="flex items-start justify-between mb-2">
                        <div class="w-10 h-10 rounded-xl bg-white/20 backdrop-blur-md flex items-center justify-center shadow-md group-hover:scale-110 transition-transform duration-300">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                        </div>
                        <span class="px-2 py-0.5 rounded bg-white/20 backdrop-blur-sm text-white text-xs font-semibold">Total</span>
                    </div>
                    <h4 class="text-3xl font-extrabold text-white mb-1">{{ $stats['totalExams'] }}</h4>
                    <p class="text-white/90 text-xs font-medium">Exams Taken</p>
                </div>
            </div>

            <!-- Average Score Card -->
            <div class="group relative bg-gradient-to-br from-emerald-500 to-green-600 rounded-xl p-3 shadow-lg hover:shadow-xl transition-all duration-500 hover:-translate-y-0.5 overflow-hidden">
                <div class="absolute top-0 right-0 w-16 h-16 bg-white/10 rounded-full -translate-y-2 translate-x-2 group-hover:scale-125 transition-transform duration-500"></div>
                <div class="absolute bottom-0 left-0 w-12 h-12 bg-white/10 rounded-full translate-y-2 -translate-x-2 group-hover:scale-125 transition-transform duration-500"></div>
                
                <div class="relative z-10">
                    <div class="flex items-start justify-between mb-2">
                        <div class="w-10 h-10 rounded-xl bg-white/20 backdrop-blur-md flex items-center justify-center shadow-md group-hover:scale-110 transition-transform duration-300">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                            </svg>
                        </div>
                        <span class="px-2 py-0.5 rounded bg-white/20 backdrop-blur-sm text-white text-xs font-semibold">Avg</span>
                    </div>
                    <h4 class="text-3xl font-extrabold text-white mb-1">{{ $stats['averageScore'] }}<span class="text-xl">%</span></h4>
                    <p class="text-white/90 text-xs font-medium">Average Score</p>
                    <div class="mt-2 w-full bg-white/20 rounded-full h-1">
                        <div class="bg-white h-1 rounded-full transition-all duration-700" style="width: {{ $stats['averageScore'] }}%"></div>
                    </div>
                </div>
            </div>

            <!-- Accuracy Card -->
            <div class="group relative bg-gradient-to-br from-amber-500 to-orange-600 rounded-xl p-3 shadow-lg hover:shadow-xl transition-all duration-500 hover:-translate-y-0.5 overflow-hidden">
                <div class="absolute top-0 right-0 w-16 h-16 bg-white/10 rounded-full -translate-y-2 translate-x-2 group-hover:scale-125 transition-transform duration-500"></div>
                <div class="absolute bottom-0 left-0 w-12 h-12 bg-white/10 rounded-full translate-y-2 -translate-x-2 group-hover:scale-125 transition-transform duration-500"></div>
                
                <div class="relative z-10">
                    <div class="flex items-start justify-between mb-2">
                        <div class="w-10 h-10 rounded-xl bg-white/20 backdrop-blur-md flex items-center justify-center shadow-md group-hover:scale-110 transition-transform duration-300">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <span class="px-2 py-0.5 rounded bg-white/20 backdrop-blur-sm text-white text-xs font-semibold">Rate</span>
                    </div>
                    <h4 class="text-3xl font-extrabold text-white mb-1">{{ $stats['accuracy'] }}<span class="text-xl">%</span></h4>
                    <p class="text-white/90 text-xs font-medium">Accuracy Rate</p>
                </div>
            </div>

            <!-- Passed Exams Card -->
            <div class="group relative bg-gradient-to-br from-purple-500 to-pink-600 rounded-xl p-3 shadow-lg hover:shadow-xl transition-all duration-500 hover:-translate-y-0.5 overflow-hidden">
                <div class="absolute top-0 right-0 w-16 h-16 bg-white/10 rounded-full -translate-y-2 translate-x-2 group-hover:scale-125 transition-transform duration-500"></div>
                <div class="absolute bottom-0 left-0 w-12 h-12 bg-white/10 rounded-full translate-y-2 -translate-x-2 group-hover:scale-125 transition-transform duration-500"></div>
                
                <div class="relative z-10">
                    <div class="flex items-start justify-between mb-2">
                        <div class="w-10 h-10 rounded-xl bg-white/20 backdrop-blur-md flex items-center justify-center shadow-md group-hover:scale-110 transition-transform duration-300">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                        </div>
                        <span class="px-2 py-0.5 rounded bg-white/20 backdrop-blur-sm text-white text-xs font-semibold">Success</span>
                    </div>
                    <h4 class="text-3xl font-extrabold text-white mb-1">{{ $stats['passedExams'] }}</h4>
                    <p class="text-white/90 text-xs font-medium">
                        @if($stats['totalExams'] > 0)
                            {{ round(($stats['passedExams'] / $stats['totalExams']) * 100) }}% Success
                        @else
                            Passed Exams
                        @endif
                    </p>
                </div>
            </div>
        </section>

        <!-- Charts Section -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-10">
            <!-- Performance Trend Chart -->
            <div class="bg-white/80 dark:bg-slate-900/80 backdrop-blur-lg rounded-2xl shadow-xl border border-slate-200/50 dark:border-slate-700/50 p-6 sm:p-8">
                <div class="flex items-center gap-3 mb-6">
                    <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-blue-500 to-indigo-600 flex items-center justify-center">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 12l3-3 3 3 4-4M8 21l4-4 4 4M3 4h18M4 4h16v12a1 1 0 01-1 1H5a1 1 0 01-1-1V4z"></path>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-xl font-extrabold text-slate-900 dark:text-white">Performance Trend</h3>
                        <p class="text-sm text-slate-600 dark:text-slate-400">Your score progression over time</p>
                    </div>
                </div>

                <div class="h-72 flex items-end justify-between gap-2 sm:gap-3">
                    @forelse($performanceTrend as $index => $trend)
                        <div class="flex flex-col items-center flex-1 group/bar">
                            <!-- Score Label -->
                            <div class="mb-2 opacity-0 group-hover/bar:opacity-100 transition-opacity duration-300">
                                <span class="text-sm font-bold text-slate-900 dark:text-white">{{ $trend['score'] }}%</span>
                            </div>
                            
                            <!-- Bar -->
                            <div class="relative w-full max-w-[40px]">
                                <div 
                                    class="w-full bg-gradient-to-t from-blue-500 via-indigo-500 to-purple-600 rounded-t-xl transition-all duration-500 group-hover/bar:from-blue-600 group-hover/bar:via-indigo-600 group-hover/bar:to-purple-700 relative overflow-hidden"
                                    style="height: {{ $trend['score'] > 0 ? max(($trend['score'] / 100) * 240, 8) : 8 }}px"
                                >
                                    <!-- Shine Effect -->
                                    <div class="absolute inset-0 bg-gradient-to-t from-transparent via-white/20 to-transparent"></div>
                                </div>
                                
                                <!-- Tooltip -->
                                <div class="absolute bottom-full left-1/2 -translate-x-1/2 mb-2 opacity-0 group-hover/bar:opacity-100 transition-opacity duration-300 pointer-events-none z-10">
                                    <div class="bg-slate-900 dark:bg-white text-white dark:text-slate-900 text-xs rounded-lg py-2 px-3 whitespace-nowrap shadow-xl">
                                        <div class="font-bold">{{ $trend['exam'] }}</div>
                                        <div class="text-slate-300 dark:text-slate-600">{{ $trend['score'] }}%</div>
                                        <div class="absolute bottom-0 left-1/2 -translate-x-1/2 translate-y-full w-0 h-0 border-l-4 border-r-4 border-t-4 border-l-transparent border-r-transparent border-t-slate-900 dark:border-t-white"></div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Date Label -->
                            <div class="mt-2 text-xs text-slate-600 dark:text-slate-400 whitespace-nowrap transform rotate-0 sm:rotate-0">
                                {{ $trend['date'] }}
                            </div>
                        </div>
                    @empty
                        <div class="w-full flex flex-col items-center justify-center h-72 text-center">
                            <svg class="w-16 h-16 text-slate-300 dark:text-slate-600 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 12l3-3 3 3 4-4M8 21l4-4 4 4M3 4h18M4 4h16v12a1 1 0 01-1 1H5a1 1 0 01-1-1V4z"></path>
                            </svg>
                            <h4 class="text-lg font-bold text-slate-900 dark:text-white mb-1">No Performance Data</h4>
                            <p class="text-sm text-slate-600 dark:text-slate-400">Take some exams to see your progress</p>
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- Subject Performance -->
            <div class="bg-white/80 dark:bg-slate-900/80 backdrop-blur-lg rounded-2xl shadow-xl border border-slate-200/50 dark:border-slate-700/50 p-6 sm:p-8">
                <div class="flex items-center gap-3 mb-6">
                    <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-emerald-500 to-green-600 flex items-center justify-center">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-xl font-extrabold text-slate-900 dark:text-white">Subject Performance</h3>
                        <p class="text-sm text-slate-600 dark:text-slate-400">Performance by subject area</p>
                    </div>
                </div>

                @if($subjectPerformance->count() > 0)
                    <div class="space-y-5 max-h-72 overflow-y-auto pr-2 custom-scrollbar">
                        @foreach($subjectPerformance as $subject)
                            <div class="group">
                                <div class="flex justify-between items-center mb-2">
                                    <span class="text-sm font-semibold text-slate-900 dark:text-white">{{ $subject['subject'] }}</span>
                                    <span class="text-sm font-bold text-slate-900 dark:text-white">{{ $subject['average'] }}%</span>
                                </div>
                                
                                <div class="relative w-full bg-slate-200 dark:bg-slate-700 rounded-full h-3 overflow-hidden">
                                    <div 
                                        class="bg-gradient-to-r from-emerald-500 to-green-600 h-3 rounded-full transition-all duration-700 relative overflow-hidden group-hover:from-emerald-600 group-hover:to-green-700" 
                                        style="width: {{ $subject['average'] }}%">
                                        <div class="absolute inset-0 bg-gradient-to-r from-transparent via-white/30 to-transparent animate-shimmer"></div>
                                    </div>
                                </div>
                                
                                <div class="flex justify-between mt-1.5 text-xs text-slate-500 dark:text-slate-400">
                                    <span class="flex items-center gap-1">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                        </svg>
                                        {{ $subject['exams'] }} exams
                                    </span>
                                    <span>High: {{ $subject['highest'] }}% | Low: {{ $subject['lowest'] }}%</span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="flex flex-col items-center justify-center h-72 text-center">
                        <svg class="w-16 h-16 text-slate-300 dark:text-slate-600 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                        </svg>
                        <h4 class="text-lg font-bold text-slate-900 dark:text-white mb-1">No Subject Data</h4>
                        <p class="text-sm text-slate-600 dark:text-slate-400">Take some exams to see subject performance</p>
                    </div>
                @endif
            </div>
        </div>

        <!-- Detailed Statistics -->
        <section class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-10">
            <!-- Exam Statistics -->
            <div class="bg-white/80 dark:bg-slate-900/80 backdrop-blur-lg rounded-2xl shadow-xl border border-slate-200/50 dark:border-slate-700/50 p-6">
                <div class="flex items-center gap-3 mb-6">
                    <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-cyan-500 to-blue-600 flex items-center justify-center">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                    </div>
                    <h3 class="text-lg font-extrabold text-slate-900 dark:text-white">Exam Stats</h3>
                </div>
                
                <div class="space-y-4">
                    <div class="flex justify-between items-center p-3 rounded-xl bg-emerald-50 dark:bg-emerald-900/20 border border-emerald-200 dark:border-emerald-800/30">
                        <span class="text-sm text-slate-700 dark:text-slate-300 font-medium">Passed Exams</span>
                        <span class="text-lg font-bold text-emerald-600 dark:text-emerald-400">{{ $stats['passedExams'] }}</span>
                    </div>
                    
                    <div class="flex justify-between items-center p-3 rounded-xl bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800/30">
                        <span class="text-sm text-slate-700 dark:text-slate-300 font-medium">Failed Exams</span>
                        <span class="text-lg font-bold text-red-600 dark:text-red-400">{{ $stats['failedExams'] }}</span>
                    </div>
                    
                    <div class="flex justify-between items-center p-3 rounded-xl bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800/30">
                        <span class="text-sm text-slate-700 dark:text-slate-300 font-medium">Highest Score</span>
                        <span class="text-lg font-bold text-blue-600 dark:text-blue-400">{{ $stats['highestScore'] }}%</span>
                    </div>
                    
                    <div class="flex justify-between items-center p-3 rounded-xl bg-amber-50 dark:bg-amber-900/20 border border-amber-200 dark:border-amber-800/30">
                        <span class="text-sm text-slate-700 dark:text-slate-300 font-medium">Lowest Score</span>
                        <span class="text-lg font-bold text-amber-600 dark:text-amber-400">{{ $stats['lowestScore'] }}%</span>
                    </div>
                </div>
            </div>

            <!-- Question Statistics -->
            <div class="bg-white/80 dark:bg-slate-900/80 backdrop-blur-lg rounded-2xl shadow-xl border border-slate-200/50 dark:border-slate-700/50 p-6">
                <div class="flex items-center gap-3 mb-6">
                    <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-pink-500 to-rose-600 flex items-center justify-center">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-lg font-extrabold text-slate-900 dark:text-white">Question Stats</h3>
                </div>
                
                <div class="space-y-4">
                    <div class="flex justify-between items-center p-3 rounded-xl bg-indigo-50 dark:bg-indigo-900/20 border border-indigo-200 dark:border-indigo-800/30">
                        <span class="text-sm text-slate-700 dark:text-slate-300 font-medium">Total Questions</span>
                        <span class="text-lg font-bold text-indigo-600 dark:text-indigo-400">{{ $questionStats['total_questions'] }}</span>
                    </div>
                    
                    <div class="flex justify-between items-center p-3 rounded-xl bg-emerald-50 dark:bg-emerald-900/20 border border-emerald-200 dark:border-emerald-800/30">
                        <span class="text-sm text-slate-700 dark:text-slate-300 font-medium">Correct Answers</span>
                        <span class="text-lg font-bold text-emerald-600 dark:text-emerald-400">{{ $questionStats['correct_answers'] }}</span>
                    </div>
                    
                    <div class="flex justify-between items-center p-3 rounded-xl bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800/30">
                        <span class="text-sm text-slate-700 dark:text-slate-300 font-medium">Wrong Answers</span>
                        <span class="text-lg font-bold text-red-600 dark:text-red-400">{{ $questionStats['wrong_answers'] }}</span>
                    </div>
                    
                    <div class="flex justify-between items-center p-3 rounded-xl bg-amber-50 dark:bg-amber-900/20 border border-amber-200 dark:border-amber-800/30">
                        <span class="text-sm text-slate-700 dark:text-slate-300 font-medium">Unanswered</span>
                        <span class="text-lg font-bold text-amber-600 dark:text-amber-400">{{ $questionStats['unanswered'] }}</span>
                    </div>
                </div>
            </div>

            <!-- Subject Statistics -->
            <div class="bg-white/80 dark:bg-slate-900/80 backdrop-blur-lg rounded-2xl shadow-xl border border-slate-200/50 dark:border-slate-700/50 p-6">
                <div class="flex items-center gap-3 mb-6">
                    <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-violet-500 to-purple-600 flex items-center justify-center">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                        </svg>
                    </div>
                    <h3 class="text-lg font-extrabold text-slate-900 dark:text-white">Subject Performance</h3>
                </div>
                
                <div class="space-y-3 max-h-96 overflow-y-auto custom-scrollbar">
                    @if($subjectPerformance && $subjectPerformance->count() > 0)
                        @foreach($subjectPerformance as $index => $subject)
                            @php
                                $gradients = [
                                    'from-blue-500 to-indigo-600',
                                    'from-emerald-500 to-green-600',
                                    'from-amber-500 to-orange-600',
                                    'from-purple-500 to-pink-600',
                                    'from-cyan-500 to-blue-600',
                                    'from-rose-500 to-red-600',
                                ];
                                $gradient = $gradients[$index % count($gradients)];
                            @endphp
                            <div class="p-4 rounded-xl bg-gradient-to-br {{ $gradient }} shadow-md hover:shadow-lg transition-all duration-300">
                                <div class="flex items-center justify-between mb-2">
                                    <h4 class="text-sm font-bold text-white">{{ $subject['subject'] }}</h4>
                                    <span class="px-2 py-0.5 rounded bg-white/20 text-white text-xs font-semibold">{{ $subject['exams'] }} exam{{ $subject['exams'] > 1 ? 's' : '' }}</span>
                                </div>
                                
                                <div class="grid grid-cols-3 gap-3 mb-3">
                                    <div class="text-center">
                                        <div class="text-xs text-white/80 mb-1">Average</div>
                                        <div class="text-xl font-extrabold text-white">{{ $subject['average'] }}%</div>
                                    </div>
                                    <div class="text-center">
                                        <div class="text-xs text-white/80 mb-1">Highest</div>
                                        <div class="text-xl font-extrabold text-white">{{ $subject['highest'] }}%</div>
                                    </div>
                                    <div class="text-center">
                                        <div class="text-xs text-white/80 mb-1">Lowest</div>
                                        <div class="text-xl font-extrabold text-white">{{ $subject['lowest'] }}%</div>
                                    </div>
                                </div>
                                
                                <div class="w-full bg-white/20 rounded-full h-1.5">
                                    <div class="bg-white h-1.5 rounded-full transition-all duration-700" style="width: {{ $subject['average'] }}%"></div>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div class="text-center py-8">
                            <div class="w-16 h-16 mx-auto mb-4 rounded-xl bg-slate-100 dark:bg-slate-800 flex items-center justify-center">
                                <svg class="w-8 h-8 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                </svg>
                            </div>
                            <p class="text-sm text-slate-600 dark:text-slate-400">No subject data available yet</p>
                        </div>
                    @endif
                </div>
            </div>
        </section>

        <!-- Recent Exams Table -->
        @if($examResults->count() > 0)
            <section class="bg-white/80 dark:bg-slate-900/80 backdrop-blur-lg rounded-2xl shadow-xl border border-slate-200/50 dark:border-slate-700/50 overflow-hidden">
                <div class="p-6 border-b border-slate-200 dark:border-slate-700">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-teal-500 to-cyan-600 flex items-center justify-center">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-xl font-extrabold text-slate-900 dark:text-white">Recent Exams</h3>
                            <p class="text-sm text-slate-600 dark:text-slate-400">Your latest exam results</p>
                        </div>
                    </div>
                </div>

                <!-- Mobile View: Cards -->
                <div class="lg:hidden divide-y divide-slate-200 dark:divide-slate-700">
                    @foreach($examResults->take(5) as $result)
                        <div class="p-4 hover:bg-slate-50 dark:hover:bg-slate-800/50 transition-colors duration-200">
                            <div class="flex justify-between items-start mb-3">
                                <div class="flex-1">
                                    <h4 class="font-bold text-slate-900 dark:text-white text-sm">{{ $result->exam->title ?? 'Unknown Exam' }}</h4>
                                    <p class="text-xs text-slate-500 dark:text-slate-400 mt-1">{{ $result->created_at->format('M d, Y') }}</p>
                                </div>
                                <span class="inline-flex items-center px-3 py-1 rounded-lg text-xs font-bold
                                    @if($result->percentage >= 50)
                                        bg-emerald-100 text-emerald-800 dark:bg-emerald-900/50 dark:text-emerald-300
                                    @else
                                        bg-red-100 text-red-800 dark:bg-red-900/50 dark:text-red-300
                                    @endif">
                                    @if($result->percentage >= 50)
                                        ✓ Passed
                                    @else
                                        ✗ Failed
                                    @endif
                                </span>
                            </div>
                            <div class="flex items-center gap-2">
                                <div class="flex-1 bg-slate-200 dark:bg-slate-700 rounded-full h-2">
                                    <div class="h-2 rounded-full transition-all duration-500 
                                        @if($result->percentage >= 50)
                                            bg-gradient-to-r from-emerald-500 to-green-600
                                        @else
                                            bg-gradient-to-r from-red-500 to-red-600
                                        @endif"
                                        style="width: {{ $result->percentage }}%">
                                    </div>
                                </div>
                                <span class="text-sm font-bold text-slate-900 dark:text-white">{{ round($result->percentage, 1) }}%</span>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Desktop View: Table -->
                <div class="hidden lg:block overflow-x-auto">
                    <table class="min-w-full divide-y divide-slate-200 dark:divide-slate-700">
                        <thead class="bg-slate-50 dark:bg-slate-800/50">
                            <tr>
                                <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider">Exam Title</th>
                                <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider">Date</th>
                                <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider">Score</th>
                                <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider">Status</th>
                                <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider">Progress</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-200 dark:divide-slate-700">
                            @foreach($examResults->take(5) as $result)
                                <tr class="hover:bg-slate-50 dark:hover:bg-slate-800/50 transition-colors duration-200">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-semibold text-slate-900 dark:text-white">{{ $result->exam->title ?? 'Unknown Exam' }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-slate-600 dark:text-slate-400">{{ $result->created_at->format('M d, Y') }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-bold text-slate-900 dark:text-white">{{ round($result->percentage, 1) }}%</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-bold
                                            @if($result->percentage >= 50)
                                                bg-emerald-100 text-emerald-800 dark:bg-emerald-900/50 dark:text-emerald-300
                                            @else
                                                bg-red-100 text-red-800 dark:bg-red-900/50 dark:text-red-300
                                            @endif">
                                            <div class="w-1.5 h-1.5 rounded-full 
                                                @if($result->percentage >= 50)
                                                    bg-emerald-500
                                                @else
                                                    bg-red-500
                                                @endif">
                                            </div>
                                            @if($result->percentage >= 50)
                                                Passed
                                            @else
                                                Failed
                                            @endif
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="w-full bg-slate-200 dark:bg-slate-700 rounded-full h-2.5">
                                            <div class="h-2.5 rounded-full transition-all duration-500
                                                @if($result->percentage >= 50)
                                                    bg-gradient-to-r from-emerald-500 to-green-600
                                                @else
                                                    bg-gradient-to-r from-red-500 to-red-600
                                                @endif"
                                                style="width: {{ $result->percentage }}%">
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </section>
        @endif
    </div>
</div>

<!-- Custom Styles -->
<style>
/* Grid Background Pattern */
.bg-grid-slate-900\/\[0\.02\] {
    background-image: linear-gradient(rgba(15, 23, 42, 0.02) 1px, transparent 1px),
                      linear-gradient(90deg, rgba(15, 23, 42, 0.02) 1px, transparent 1px);
}

.dark .bg-grid-white\/\[0\.02\] {
    background-image: linear-gradient(rgba(255, 255, 255, 0.02) 1px, transparent 1px),
                      linear-gradient(90deg, rgba(255, 255, 255, 0.02) 1px, transparent 1px);
}

/* Custom Scrollbar */
.custom-scrollbar::-webkit-scrollbar {
    width: 6px;
}

.custom-scrollbar::-webkit-scrollbar-track {
    background: rgba(148, 163, 184, 0.1);
    border-radius: 10px;
}

.custom-scrollbar::-webkit-scrollbar-thumb {
    background: linear-gradient(to bottom, #10b981, #059669);
    border-radius: 10px;
}

.custom-scrollbar::-webkit-scrollbar-thumb:hover {
    background: linear-gradient(to bottom, #059669, #047857);
}

/* Shimmer Animation */
@keyframes shimmer {
    0% { transform: translateX(-100%); }
    100% { transform: translateX(100%); }
}

.animate-shimmer {
    animation: shimmer 2s infinite;
}

/* Responsive Typography */
@media (max-width: 640px) {
    h1 {
        font-size: 1.875rem;
        line-height: 2.25rem;
    }
}
</style>
@endsection