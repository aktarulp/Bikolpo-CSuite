@extends('layouts.partner-layout')

@section('title', 'Student Analytics - ' . $student->full_name)

@section('content')
<div class="min-h-screen bg-gradient-to-br from-slate-50 via-blue-50/30 to-indigo-50 dark:from-gray-900 dark:via-gray-800 dark:to-gray-900">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Page Header -->
        <div class="mb-8">
            <div class="bg-white/80 dark:bg-gray-800/80 backdrop-blur-sm rounded-2xl shadow-xl border border-white/20 dark:border-gray-700/50 p-6 sm:p-8">
                <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-6">
                    <!-- Student Profile -->
                    <div class="flex items-center space-x-6">
                        <!-- Avatar with Glow Effect -->
                        <div class="relative">
                            <div class="absolute -inset-1 bg-gradient-to-r from-blue-600 to-purple-600 rounded-full blur opacity-30 animate-pulse"></div>
                            @if($student->photo)
                                <img class="relative h-20 w-20 sm:h-24 sm:w-24 rounded-full border-4 border-white dark:border-gray-800 shadow-2xl object-cover"
                                     src="{{ Storage::url($student->photo) }}"
                                     alt="{{ $student->full_name }}">
                            @else
                                <div class="relative h-20 w-20 sm:h-24 sm:w-24 rounded-full bg-gradient-to-br from-blue-500 via-purple-500 to-pink-500 flex items-center justify-center border-4 border-white dark:border-gray-800 shadow-2xl">
                                    <span class="text-white font-bold text-2xl sm:text-3xl">
                                        {{ substr($student->full_name, 0, 1) }}
                                    </span>
                                </div>
                            @endif
                            <!-- Online Status Indicator -->
                            <div class="absolute -bottom-1 -right-1 h-6 w-6 bg-gradient-to-r from-green-400 to-emerald-500 rounded-full border-4 border-white dark:border-gray-800 flex items-center justify-center shadow-lg">
                                <svg class="w-3 h-3 text-white" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                </svg>
                            </div>
                        </div>
                        
                        <!-- Student Information -->
                        <div class="flex-1 min-w-0">
                            <h1 class="text-3xl sm:text-4xl font-bold bg-gradient-to-r from-gray-900 via-blue-800 to-purple-800 dark:from-white dark:via-blue-200 dark:to-purple-200 bg-clip-text text-transparent mb-2">
                                {{ $student->full_name }}
                            </h1>
                            <div class="flex flex-wrap gap-3 text-sm">
                                <div class="flex items-center bg-white/60 dark:bg-gray-700/60 backdrop-blur-sm px-4 py-2 rounded-full shadow-md border border-white/20 dark:border-gray-600/20">
                                    <div class="w-2 h-2 bg-blue-500 rounded-full mr-3"></div>
                                    <span class="font-medium text-gray-700 dark:text-gray-300">ID: {{ $student->student_id }}</span>
                                </div>
                                <div class="flex items-center bg-white/60 dark:bg-gray-700/60 backdrop-blur-sm px-4 py-2 rounded-full shadow-md border border-white/20 dark:border-gray-600/20">
                                    <div class="w-2 h-2 bg-purple-500 rounded-full mr-3"></div>
                                    <span class="font-medium text-gray-700 dark:text-gray-300">{{ $student->partner->name ?? 'No Institute' }}</span>
                                </div>
                                @if($student->email)
                                <div class="flex items-center bg-white/60 dark:bg-gray-700/60 backdrop-blur-sm px-4 py-2 rounded-full shadow-md border border-white/20 dark:border-gray-600/20">
                                    <div class="w-2 h-2 bg-green-500 rounded-full mr-3"></div>
                                    <span class="font-medium text-gray-700 dark:text-gray-300">{{ $student->email }}</span>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Performance Summary Card -->
                    <div class="bg-gradient-to-br from-white via-blue-50/50 to-indigo-50/50 dark:from-gray-800/50 dark:via-blue-900/20 dark:to-indigo-900/20 backdrop-blur-sm rounded-2xl shadow-xl p-6 text-center min-w-[200px] border border-blue-200/50 dark:border-blue-700/30">
                        <div class="relative">
                            <div class="absolute inset-0 bg-gradient-to-r from-blue-400 to-purple-500 rounded-2xl opacity-10 animate-pulse"></div>
                            <div class="relative">
                                <div class="text-4xl sm:text-5xl font-bold bg-gradient-to-r from-blue-600 to-purple-600 dark:from-blue-400 dark:to-purple-400 bg-clip-text text-transparent mb-2">
                                    {{ $comprehensiveAnalytics['overall_accuracy'] }}%
                                </div>
                                <div class="text-sm font-semibold text-gray-600 dark:text-gray-400 mb-4">Overall Performance</div>
                                @if($comprehensiveAnalytics['overall_accuracy'] >= 80)
                                    <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-medium bg-gradient-to-r from-green-100 to-emerald-100 text-green-800 dark:from-green-900 dark:to-emerald-900 dark:text-green-200 shadow-lg">
                                        <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                        </svg>
                                        Excellent
                                    </span>
                                @elseif($comprehensiveAnalytics['overall_accuracy'] >= 60)
                                    <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-medium bg-gradient-to-r from-yellow-100 to-amber-100 text-yellow-800 dark:from-yellow-900 dark:to-amber-900 dark:text-yellow-200 shadow-lg">
                                        <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"></path>
                                        </svg>
                                        Good
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-medium bg-gradient-to-r from-red-100 to-rose-100 text-red-800 dark:from-red-900 dark:to-rose-900 dark:text-red-200 shadow-lg">
                                        <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                                        </svg>
                                        Needs Improvement
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Key Metrics Cards -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <!-- Correct Answers Card -->
            <div class="group relative bg-gradient-to-br from-white via-green-50 to-emerald-50 dark:from-gray-800 dark:via-green-900/20 dark:to-emerald-900/20 rounded-2xl shadow-lg hover:shadow-2xl p-6 border border-green-200 dark:border-green-700/50 transform hover:scale-105 transition-all duration-300">
                <div class="absolute inset-0 bg-gradient-to-r from-green-400/20 to-emerald-400/20 rounded-2xl opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                <div class="relative">
                    <div class="flex items-center justify-between mb-4">
                        <div class="p-4 bg-gradient-to-br from-green-400 to-emerald-500 rounded-2xl shadow-lg transform group-hover:scale-110 transition-transform duration-300">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div class="text-right">
                            <div class="text-3xl font-bold bg-gradient-to-r from-green-600 to-emerald-600 dark:from-green-400 dark:to-emerald-400 bg-clip-text text-transparent">
                                {{ $comprehensiveAnalytics['total_correct_answers'] }}
                            </div>
                            <div class="text-sm font-medium text-gray-600 dark:text-gray-400">Correct</div>
                        </div>
                    </div>
                    <div class="space-y-3">
                        <div class="flex justify-between text-sm">
                            <span class="font-medium text-gray-700 dark:text-gray-300">Accuracy</span>
                            <span class="font-bold text-green-600 dark:text-green-400">
                                {{ $comprehensiveAnalytics['total_questions_attempted'] > 0 ? round(($comprehensiveAnalytics['total_correct_answers'] / $comprehensiveAnalytics['total_questions_attempted']) * 100, 1) : 0 }}%
                            </span>
                        </div>
                        <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-3 overflow-hidden">
                            <div class="bg-gradient-to-r from-green-400 to-emerald-500 h-3 rounded-full transition-all duration-1000 ease-out" 
                                 style="width: {{ $comprehensiveAnalytics['total_questions_attempted'] > 0 ? round(($comprehensiveAnalytics['total_correct_answers'] / $comprehensiveAnalytics['total_questions_attempted']) * 100, 1) : 0 }}%"></div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Incorrect Answers Card -->
            <div class="group relative bg-gradient-to-br from-white via-red-50 to-rose-50 dark:from-gray-800 dark:via-red-900/20 dark:to-rose-900/20 rounded-2xl shadow-lg hover:shadow-2xl p-6 border border-red-200 dark:border-red-700/50 transform hover:scale-105 transition-all duration-300">
                <div class="absolute inset-0 bg-gradient-to-r from-red-400/20 to-rose-400/20 rounded-2xl opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                <div class="relative">
                    <div class="flex items-center justify-between mb-4">
                        <div class="p-4 bg-gradient-to-br from-red-400 to-rose-500 rounded-2xl shadow-lg transform group-hover:scale-110 transition-transform duration-300">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </div>
                        <div class="text-right">
                            <div class="text-3xl font-bold bg-gradient-to-r from-red-600 to-rose-600 dark:from-red-400 dark:to-rose-400 bg-clip-text text-transparent">
                                {{ $comprehensiveAnalytics['total_incorrect_answers'] }}
                            </div>
                            <div class="text-sm font-medium text-gray-600 dark:text-gray-400">Incorrect</div>
                        </div>
                    </div>
                    <div class="space-y-3">
                        <div class="flex justify-between text-sm">
                            <span class="font-medium text-gray-700 dark:text-gray-300">Error Rate</span>
                            <span class="font-bold text-red-600 dark:text-red-400">
                                {{ $comprehensiveAnalytics['total_questions_attempted'] > 0 ? round(($comprehensiveAnalytics['total_incorrect_answers'] / $comprehensiveAnalytics['total_questions_attempted']) * 100, 1) : 0 }}%
                            </span>
                        </div>
                        <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-3 overflow-hidden">
                            <div class="bg-gradient-to-r from-red-400 to-rose-500 h-3 rounded-full transition-all duration-1000 ease-out" 
                                 style="width: {{ $comprehensiveAnalytics['total_questions_attempted'] > 0 ? round(($comprehensiveAnalytics['total_incorrect_answers'] / $comprehensiveAnalytics['total_questions_attempted']) * 100, 1) : 0 }}%"></div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Skipped Questions Card -->
            <div class="group relative bg-gradient-to-br from-white via-yellow-50 to-amber-50 dark:from-gray-800 dark:via-yellow-900/20 dark:to-amber-900/20 rounded-2xl shadow-lg hover:shadow-2xl p-6 border border-yellow-200 dark:border-yellow-700/50 transform hover:scale-105 transition-all duration-300">
                <div class="absolute inset-0 bg-gradient-to-r from-yellow-400/20 to-amber-400/20 rounded-2xl opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                <div class="relative">
                    <div class="flex items-center justify-between mb-4">
                        <div class="p-4 bg-gradient-to-br from-yellow-400 to-amber-500 rounded-2xl shadow-lg transform group-hover:scale-110 transition-transform duration-300">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div class="text-right">
                            <div class="text-3xl font-bold bg-gradient-to-r from-yellow-600 to-amber-600 dark:from-yellow-400 dark:to-amber-400 bg-clip-text text-transparent">
                                {{ $comprehensiveAnalytics['total_skipped_questions'] }}
                            </div>
                            <div class="text-sm font-medium text-gray-600 dark:text-gray-400">Skipped</div>
                        </div>
                    </div>
                    <div class="space-y-3">
                        <div class="flex justify-between text-sm">
                            <span class="font-medium text-gray-700 dark:text-gray-300">Skip Rate</span>
                            <span class="font-bold text-yellow-600 dark:text-yellow-400">
                                {{ $comprehensiveAnalytics['total_questions_attempted'] > 0 ? round(($comprehensiveAnalytics['total_skipped_questions'] / $comprehensiveAnalytics['total_questions_attempted']) * 100, 1) : 0 }}%
                            </span>
                        </div>
                        <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-3 overflow-hidden">
                            <div class="bg-gradient-to-r from-yellow-400 to-amber-500 h-3 rounded-full transition-all duration-1000 ease-out" 
                                 style="width: {{ $comprehensiveAnalytics['total_questions_attempted'] > 0 ? round(($comprehensiveAnalytics['total_skipped_questions'] / $comprehensiveAnalytics['total_questions_attempted']) * 100, 1) : 0 }}%"></div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Exams Taken Card -->
            <div class="group relative bg-gradient-to-br from-white via-blue-50 to-indigo-50 dark:from-gray-800 dark:via-blue-900/20 dark:to-indigo-900/20 rounded-2xl shadow-lg hover:shadow-2xl p-6 border border-blue-200 dark:border-blue-700/50 transform hover:scale-105 transition-all duration-300">
                <div class="absolute inset-0 bg-gradient-to-r from-blue-400/20 to-indigo-400/20 rounded-2xl opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                <div class="relative">
                    <div class="flex items-center justify-between mb-4">
                        <div class="p-4 bg-gradient-to-br from-blue-400 to-indigo-500 rounded-2xl shadow-lg transform group-hover:scale-110 transition-transform duration-300">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                            </svg>
                        </div>
                        <div class="text-right">
                            <div class="text-3xl font-bold bg-gradient-to-r from-blue-600 to-indigo-600 dark:from-blue-400 dark:to-indigo-400 bg-clip-text text-transparent">
                                {{ $comprehensiveAnalytics['total_exams_taken'] }}
                            </div>
                            <div class="text-sm font-medium text-gray-600 dark:text-gray-400">Exams</div>
                        </div>
                    </div>
                    <div class="space-y-3">
                        <div class="flex justify-between text-sm">
                            <span class="font-medium text-gray-700 dark:text-gray-300">Avg Score</span>
                            <span class="font-bold text-blue-600 dark:text-blue-400">
                                {{ $comprehensiveAnalytics['average_exam_score'] ?? 'N/A' }}%
                            </span>
                        </div>
                        <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-3 overflow-hidden">
                            <div class="bg-gradient-to-r from-blue-400 to-indigo-500 h-3 rounded-full transition-all duration-1000 ease-out" 
                                 style="width: {{ $comprehensiveAnalytics['average_exam_score'] ?? 0 }}%"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Performance Analysis Section -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
            <!-- Question Type Performance -->
            <div class="bg-gradient-to-br from-white via-blue-50 to-indigo-50 dark:from-gray-800 dark:via-blue-900/20 dark:to-indigo-900/20 rounded-2xl shadow-xl p-8 border border-blue-200 dark:border-blue-700/50 hover:shadow-2xl transition-all duration-300">
                <div class="flex items-center mb-6">
                    <div class="p-3 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-xl shadow-lg mr-4">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold bg-gradient-to-r from-blue-600 to-indigo-600 dark:from-blue-400 dark:to-indigo-400 bg-clip-text text-transparent">Performance by Question Type</h3>
                </div>
                <div class="space-y-6">
                    @foreach($questionTypePerformance as $type => $stats)
                    <div class="bg-white/60 dark:bg-gray-700/60 backdrop-blur-sm rounded-xl p-4 border border-blue-100 dark:border-blue-800/50">
                        <div class="flex justify-between items-center mb-3">
                            <span class="text-sm font-semibold text-gray-800 dark:text-gray-200 capitalize flex items-center">
                                @if($type === 'mcq')
                                    <svg class="w-4 h-4 mr-2 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    Multiple Choice
                                @else
                                    <svg class="w-4 h-4 mr-2 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                    </svg>
                                    Constructed Response
                                @endif
                            </span>
                            <span class="text-sm font-bold text-blue-600 dark:text-blue-400 bg-blue-100 dark:bg-blue-900/50 px-3 py-1 rounded-full">
                                {{ $stats['correct'] }}/{{ $stats['total'] }}
                            </span>
                        </div>
                        <div class="w-full bg-gray-200 dark:bg-gray-600 rounded-full h-3 overflow-hidden">
                            <div class="bg-gradient-to-r from-blue-400 to-indigo-500 h-3 rounded-full transition-all duration-1000 ease-out" style="width: {{ $stats['total'] > 0 ? round(($stats['correct'] / $stats['total']) * 100, 2) : 0 }}%"></div>
                        </div>
                        <div class="text-xs font-medium text-gray-600 dark:text-gray-400 mt-2 text-center">
                            {{ $stats['total'] > 0 ? round(($stats['correct'] / $stats['total']) * 100, 2) : 0 }}% accuracy
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            <!-- Difficulty Performance -->
            <div class="bg-gradient-to-br from-white via-purple-50 to-pink-50 dark:from-gray-800 dark:via-purple-900/20 dark:to-pink-900/20 rounded-2xl shadow-xl p-8 border border-purple-200 dark:border-purple-700/50 hover:shadow-2xl transition-all duration-300">
                <div class="flex items-center mb-6">
                    <div class="p-3 bg-gradient-to-br from-purple-500 to-pink-600 rounded-xl shadow-lg mr-4">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold bg-gradient-to-r from-purple-600 to-pink-600 dark:from-purple-400 dark:to-pink-400 bg-clip-text text-transparent">Performance by Difficulty</h3>
                </div>
                <div class="space-y-6">
                    @foreach($difficultyPerformance as $difficulty => $stats)
                    <div class="bg-white/60 dark:bg-gray-700/60 backdrop-blur-sm rounded-xl p-4 border border-purple-100 dark:border-purple-800/50">
                        <div class="flex justify-between items-center mb-3">
                            <span class="text-sm font-semibold text-gray-800 dark:text-gray-200 capitalize flex items-center">
                                @if($difficulty === 'easy')
                                    <svg class="w-4 h-4 mr-2 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="color: rgb(34 197 94);">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    Easy
                                @elseif($difficulty === 'medium')
                                    <svg class="w-4 h-4 mr-2 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="color: rgb(234 179 8);">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    Medium
                                @else
                                    <svg class="w-4 h-4 mr-2 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="color: rgb(239 68 68);">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                    </svg>
                                    Hard
                                @endif
                            </span>
                            <span class="text-sm font-bold {{ $difficulty === 'easy' ? 'text-green-600 dark:text-green-400 bg-green-100 dark:bg-green-900/50' : ($difficulty === 'medium' ? 'text-yellow-600 dark:text-yellow-400 bg-yellow-100 dark:bg-yellow-900/50' : 'text-red-600 dark:text-red-400 bg-red-100 dark:bg-red-900/50') }} px-3 py-1 rounded-full">
                                {{ $stats['correct'] }}/{{ $stats['total'] }}
                            </span>
                        </div>
                        <div class="w-full bg-gray-200 dark:bg-gray-600 rounded-full h-3 overflow-hidden">
                            <div class="bg-gradient-to-r {{ $difficulty === 'easy' ? 'from-green-400 to-emerald-500' : ($difficulty === 'medium' ? 'from-yellow-400 to-amber-500' : 'from-red-400 to-rose-500') }} h-3 rounded-full transition-all duration-1000 ease-out" style="width: {{ $stats['total'] > 0 ? round(($stats['correct'] / $stats['total']) * 100, 2) : 0 }}%"></div>
                        </div>
                        <div class="text-xs font-medium text-gray-600 dark:text-gray-400 mt-2 text-center">
                            {{ $stats['total'] > 0 ? round(($stats['correct'] / $stats['total']) * 100, 2) : 0 }}% accuracy
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Exam Results -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 mb-6">
            <div class="px-4 py-3 border-b border-gray-200 dark:border-gray-700">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Exam Results</h3>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                    <thead class="bg-gray-50 dark:bg-gray-700">
                        <tr>
                            <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Exam</th>
                            <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Score</th>
                            <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Grade</th>
                            <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Status</th>
                            <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Date</th>
                            <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                        @foreach($examResults as $result)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors duration-200">
                            <td class="px-3 py-3">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-8 w-8 bg-blue-100 dark:bg-blue-900/50 rounded-full flex items-center justify-center">
                                        <svg class="w-4 h-4 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                                        </svg>
                                    </div>
                                    <div class="ml-3 min-w-0 flex-1">
                                        <div class="text-sm font-medium text-gray-900 dark:text-white truncate">{{ $result->exam->title ?? 'Unknown Exam' }}</div>
                                        <div class="text-xs text-gray-500 dark:text-gray-400">{{ $result->correct_answers }}/{{ $result->total_questions }} questions</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-3 py-3 whitespace-nowrap">
                                <div class="text-lg font-bold text-blue-600 dark:text-blue-400">{{ $result->percentage }}%</div>
                                <div class="text-xs text-gray-500 dark:text-gray-400">{{ $result->score }} pts</div>
                            </td>
                            <td class="px-3 py-3 whitespace-nowrap">
                                <span class="px-2 py-1 text-xs font-medium rounded-full
                                    {{ $result->grade === 'A+' || $result->grade === 'A' ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200' :
                                       ($result->grade === 'B' ? 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200' :
                                       ($result->grade === 'C' ? 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200' :
                                       'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200')) }}">
                                    {{ $result->grade }}
                                </span>
                            </td>
                            <td class="px-3 py-3 whitespace-nowrap">
                                <span class="px-2 py-1 text-xs font-medium rounded-full
                                    {{ $result->is_passed ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200' : 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200' }}">
                                    {{ $result->is_passed ? 'Passed' : 'Failed' }}
                                </span>
                            </td>
                            <td class="px-3 py-3 whitespace-nowrap text-xs text-gray-600 dark:text-gray-400">
                                {{ $result->completed_at ? $result->completed_at->format('M j, Y') : 'N/A' }}
                            </td>
                            <td class="px-3 py-3 whitespace-nowrap text-xs">
                                <button onclick="showExamDetails({{ $result->id }})" class="text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-300 font-medium transition-colors duration-200">
                                    View
                                </button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Recent Performance -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 mb-6">
            <div class="px-4 py-3 border-b border-gray-200 dark:border-gray-700">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Recent Performance</h3>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                    <thead class="bg-gray-50 dark:bg-gray-700">
                        <tr>
                            <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Question</th>
                            <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Type</th>
                            <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Result</th>
                            <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Exam</th>
                            <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Date</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                        @foreach($recentPerformance as $performance)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors duration-200">
                            <td class="px-3 py-3 max-w-xs">
                                <div class="text-sm font-medium text-gray-900 dark:text-white truncate">
                                    {{ $performance->question->question_text ?? 'N/A' }}
                                </div>
                            </td>
                            <td class="px-3 py-3 whitespace-nowrap">
                                <span class="px-2 py-1 text-xs font-medium rounded-full
                                    {{ $performance->question_type === 'mcq' ? 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200' : 'bg-purple-100 text-purple-800 dark:bg-purple-900 dark:text-purple-200' }}">
                                    {{ strtoupper($performance->question_type) }}
                                </span>
                            </td>
                            <td class="px-3 py-3 whitespace-nowrap">
                                @if($performance->is_correct)
                                    <span class="px-2 py-1 text-xs font-medium rounded-full bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200">
                                        Correct
                                    </span>
                                @elseif($performance->is_skipped)
                                    <span class="px-2 py-1 text-xs font-medium rounded-full bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200">
                                        Skipped
                                    </span>
                                @else
                                    <span class="px-2 py-1 text-xs font-medium rounded-full bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200">
                                        Incorrect
                                    </span>
                                @endif
                            </td>
                            <td class="px-3 py-3 whitespace-nowrap text-xs text-gray-500 dark:text-gray-400 truncate max-w-24">
                                {{ $performance->exam->title ?? 'N/A' }}
                            </td>
                            <td class="px-3 py-3 whitespace-nowrap text-xs text-gray-500 dark:text-gray-400">
                                {{ $performance->created_at->format('M j, Y') }}
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        @if($improvementTrend['trend'] !== 'insufficient_data')
        <!-- Performance Trend -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 p-4 sm:p-6 mb-6">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Performance Trend</h3>
            <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 text-center">
                <div>
                    <p class="text-xs text-gray-600 dark:text-gray-400 mb-1">Overall Change</p>
                    <p class="text-xl sm:text-2xl font-bold {{ $improvementTrend['change'] > 0 ? 'text-green-600 dark:text-green-400' : ($improvementTrend['change'] < 0 ? 'text-red-600 dark:text-red-400' : 'text-gray-600 dark:text-gray-400') }}">
                        {{ $improvementTrend['change'] > 0 ? '+' : '' }}{{ $improvementTrend['change'] }}%
                    </p>
                </div>
                <div>
                    <p class="text-xs text-gray-600 dark:text-gray-400 mb-1">First Score</p>
                    <p class="text-xl sm:text-2xl font-bold text-gray-900 dark:text-white">{{ $improvementTrend['first_score'] }}%</p>
                </div>
                <div>
                    <p class="text-xs text-gray-600 dark:text-gray-400 mb-1">Latest Score</p>
                    <p class="text-xl sm:text-2xl font-bold text-gray-900 dark:text-white">{{ $improvementTrend['last_score'] }}%</p>
                </div>
                <div>
                    <p class="text-xs text-gray-600 dark:text-gray-400 mb-1">Total Exams</p>
                    <p class="text-xl sm:text-2xl font-bold text-gray-900 dark:text-white">{{ $improvementTrend['total_exams'] }}</p>
                </div>
            </div>
        </div>
        @endif

        @if($difficultQuestions->count() > 0)
        <!-- Questions to Review -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 mb-6">
            <div class="px-4 py-3 border-b border-gray-200 dark:border-gray-700">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Questions to Review</h3>
                <p class="text-xs text-gray-600 dark:text-gray-400">Questions you found difficult</p>
            </div>
            <div class="p-4">
                <div class="space-y-3">
                    @foreach($difficultQuestions as $question)
                    <div class="bg-gray-50 dark:bg-gray-700/50 rounded-lg p-3">
                        <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-2">
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-medium text-gray-900 dark:text-white mb-1 truncate">
                                    {{ $question->question->question_text ?? 'Question not available' }}
                                </p>
                                <div class="flex flex-wrap items-center gap-2 text-xs text-gray-500 dark:text-gray-400">
                                    <span>Type: {{ strtoupper($question->question_type) }}</span>
                                    <span>•</span>
                                    <span class="truncate">Exam: {{ $question->exam->title ?? 'N/A' }}</span>
                                    <span>•</span>
                                    <span>Date: {{ $question->created_at->format('M j, Y') }}</span>
                                </div>
                            </div>
                            <div class="flex-shrink-0">
                                <span class="px-2 py-1 text-xs font-medium rounded-full bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200">
                                    Incorrect
                                </span>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
        @endif
    </div>
</div>

<div id="examDetailsModal" class="fixed inset-0 bg-gray-900 bg-opacity-75 flex items-center justify-center p-4 z-50 transition-opacity duration-300 opacity-0 pointer-events-none">
    <div class="relative w-full max-w-4xl bg-white dark:bg-gray-800 rounded-3xl shadow-2xl transition-transform duration-300 transform scale-95 p-6 md:p-8">
        <div class="flex items-center justify-between border-b pb-4 mb-4 border-gray-200 dark:border-gray-700">
            <h3 class="text-2xl font-bold text-gray-900 dark:text-white">Exam Details</h3>
            <button onclick="closeExamDetails()" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 transition-colors duration-200">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>
        <div id="examDetailsContent" class="modal-content overflow-y-auto max-h-[80vh] pb-4">
            </div>
    </div>
</div>

<script>
function showExamDetails(examResultId) {
    const modal = document.getElementById('examDetailsModal');
    const content = document.getElementById('examDetailsContent');

    // Show loading state
    content.innerHTML = `
        <div class="text-center py-12">
            <div class="animate-spin rounded-full h-12 w-12 border-4 border-blue-500 border-t-transparent mx-auto"></div>
            <p class="text-gray-500 dark:text-gray-400 mt-4 text-lg font-medium">Loading exam details...</p>
        </div>
    `;

    // Show modal with animation
    modal.classList.remove('hidden', 'opacity-0', 'pointer-events-none');
    setTimeout(() => {
        modal.classList.remove('opacity-0');
        modal.querySelector('div').classList.remove('scale-95');
    }, 10);

    // Fetch detailed exam results
    fetch(`/analytics/api/students/{{ $student->id }}/exam-results/${examResultId}`)
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => {
            displayExamDetails(data);
        })
        .catch(error => {
            console.error('Error:', error);
            content.innerHTML = `
                <div class="text-center py-12">
                    <p class="text-red-500 text-lg font-medium">Error loading exam details. Please try again.</p>
                    <p class="text-sm text-gray-500 dark:text-gray-400 mt-2">Check the console for more information.</p>
                </div>
            `;
        });
}

function displayExamDetails(data) {
    const { exam_result, detailed_analytics, correct_questions, incorrect_questions, skipped_questions } = data;

    const content = document.getElementById('examDetailsContent'); // Ensure this refers to the content element

    content.innerHTML = `
        <div class="space-y-8">
            <div class="bg-gray-100 dark:bg-gray-700 rounded-xl p-6 md:p-8 text-center">
                <h4 class="text-3xl font-extrabold text-gray-900 dark:text-white mb-4">${exam_result.exam.title}</h4>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                    <div>
                        <div class="text-4xl font-extrabold text-blue-600 dark:text-blue-400">${exam_result.percentage}%</div>
                        <div class="text-sm text-gray-600 dark:text-gray-400 mt-1">Score</div>
                    </div>
                    <div>
                        <div class="text-4xl font-extrabold text-gray-900 dark:text-white">${exam_result.grade}</div>
                        <div class="text-sm text-gray-600 dark:text-gray-400 mt-1">Grade</div>
                    </div>
                    <div>
                        <div class="text-4xl font-extrabold ${exam_result.is_passed ? 'text-green-600 dark:text-green-400' : 'text-red-600 dark:text-red-400'}">${exam_result.is_passed ? 'PASSED' : 'FAILED'}</div>
                        <div class="text-sm text-gray-600 dark:text-gray-400 mt-1">Status</div>
                    </div>
                    <div>
                        <div class="text-4xl font-extrabold text-gray-900 dark:text-white">${exam_result.time_taken || 'N/A'}</div>
                        <div class="text-sm text-gray-600 dark:text-gray-400 mt-1">Minutes</div>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 md:gap-6">
                <div class="bg-green-50 dark:bg-green-900/50 rounded-lg p-4 text-center">
                    <div class="text-3xl font-bold text-green-600 dark:text-green-400">${detailed_analytics.correct_answers}</div>
                    <div class="text-sm font-semibold text-green-700 dark:text-green-300 mt-1">Correct</div>
                </div>
                <div class="bg-red-50 dark:bg-red-900/50 rounded-lg p-4 text-center">
                    <div class="text-3xl font-bold text-red-600 dark:text-red-400">${detailed_analytics.incorrect_answers}</div>
                    <div class="text-sm font-semibold text-red-700 dark:text-red-300 mt-1">Incorrect</div>
                </div>
                <div class="bg-yellow-50 dark:bg-yellow-900/50 rounded-lg p-4 text-center">
                    <div class="text-3xl font-bold text-yellow-600 dark:text-yellow-400">${detailed_analytics.skipped_questions}</div>
                    <div class="text-sm font-semibold text-yellow-700 dark:text-yellow-300 mt-1">Skipped</div>
                </div>
                <div class="bg-gray-50 dark:bg-gray-700/50 rounded-lg p-4 text-center">
                    <div class="text-3xl font-bold text-gray-600 dark:text-gray-400">${detailed_analytics.unanswered_questions}</div>
                    <div class="text-sm font-semibold text-gray-700 dark:text-gray-300 mt-1">Unanswered</div>
                </div>
            </div>

            <div>
                <h5 class="text-xl font-bold text-gray-900 dark:text-white mb-4">Performance by Question Type</h5>
                <div class="space-y-4">
                    ${Object.entries(detailed_analytics.question_type_breakdown).map(([type, stats]) => `
                        <div class="bg-gray-100 dark:bg-gray-700/50 rounded-lg p-4">
                            <div class="flex justify-between items-center mb-2">
                                <span class="text-base font-semibold text-gray-800 dark:text-gray-200 capitalize">${type}</span>
                                <span class="text-sm font-medium text-gray-600 dark:text-gray-400">${stats.correct}/${stats.total}</span>
                            </div>
                            <div class="w-full bg-gray-200 dark:bg-gray-600 rounded-full h-2.5">
                                <div class="bg-blue-600 dark:bg-blue-400 h-2.5 rounded-full" style="width: ${stats.total > 0 ? Math.round((stats.correct / stats.total) * 100) : 0}%"></div>
                            </div>
                        </div>
                    `).join('')}
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div>
                    <h5 class="text-xl font-bold text-green-600 dark:text-green-400 mb-4">Correct Answers (${correct_questions.length})</h5>
                    <div class="space-y-3 max-h-96 overflow-y-auto pr-2">
                        ${correct_questions.map(q => `
                            <div class="bg-green-50 dark:bg-green-900/50 border border-green-200 dark:border-green-700 rounded-lg p-4">
                                <p class="text-sm text-gray-900 dark:text-white">${q.question ? q.question.question_text.substring(0, 100) + '...' : 'Question not available'}</p>
                                <p class="text-xs text-green-600 dark:text-green-400 mt-2 font-medium">Type: ${q.question_type.toUpperCase()}</p>
                            </div>
                        `).join('')}
                    </div>
                </div>

                <div>
                    <h5 class="text-xl font-bold text-red-600 dark:text-red-400 mb-4">Incorrect Answers (${incorrect_questions.length})</h5>
                    <div class="space-y-3 max-h-96 overflow-y-auto pr-2">
                        ${incorrect_questions.map(q => `
                            <div class="bg-red-50 dark:bg-red-900/50 border border-red-200 dark:border-red-700 rounded-lg p-4">
                                <p class="text-sm text-gray-900 dark:text-white">${q.question ? q.question.question_text.substring(0, 100) + '...' : 'Question not available'}</p>
                                <p class="text-xs text-red-600 dark:text-red-400 mt-2 font-medium">Type: ${q.question_type.toUpperCase()}</p>
                                <p class="text-xs text-gray-600 dark:text-gray-400 mt-1 font-medium">Your Answer: <span class="font-bold">${q.student_answer || 'N/A'}</span></p>
                                <p class="text-xs text-gray-600 dark:text-gray-400 font-medium">Correct Answer: <span class="font-bold">${q.correct_answer || 'N/A'}</span></p>
                            </div>
                        `).join('')}
                    </div>
                </div>

                <div>
                    <h5 class="text-xl font-bold text-yellow-600 dark:text-yellow-400 mb-4">Skipped Questions (${skipped_questions.length})</h5>
                    <div class="space-y-3 max-h-96 overflow-y-auto pr-2">
                        ${skipped_questions.map(q => `
                            <div class="bg-yellow-50 dark:bg-yellow-900/50 border border-yellow-200 dark:border-yellow-700 rounded-lg p-4">
                                <p class="text-sm text-gray-900 dark:text-white">${q.question ? q.question.question_text.substring(0, 100) + '...' : 'Question not available'}</p>
                                <p class="text-xs text-yellow-600 dark:text-yellow-400 mt-2 font-medium">Type: ${q.question_type.toUpperCase()}</p>
                            </div>
                        `).join('')}
                    </div>
                </div>
            </div>
        </div>
    `;
}

function closeExamDetails() {
    const modal = document.getElementById('examDetailsModal');
    modal.querySelector('div').classList.add('scale-95');
    modal.classList.add('opacity-0');
    setTimeout(() => {
        modal.classList.add('hidden', 'pointer-events-none');
    }, 300);
}

// Close modal when clicking outside
document.getElementById('examDetailsModal').addEventListener('click', function(e) {
    if (e.target.id === 'examDetailsModal') {
        closeExamDetails();
    }
});
</script>
@endsection