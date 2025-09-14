@extends('layouts.partner-layout')

@section('title', 'Student Analytics - ' . $student->full_name)

@section('content')
<div class="min-h-screen bg-gradient-to-br from-indigo-50 via-white to-cyan-50 dark:from-gray-900 dark:via-gray-800 dark:to-gray-900">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Page Header -->
        <div class="mb-8">
            <div class="bg-gradient-to-r from-white to-gray-50 dark:from-gray-800 dark:to-gray-700 rounded-2xl shadow-xl p-8 border border-gray-100 dark:border-gray-600">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
                    <div class="flex items-center space-x-6 mb-4 sm:mb-0">
                        <!-- Student Avatar -->
                        <div class="relative group">
                            <div class="absolute -inset-1 bg-gradient-to-r from-blue-600 to-purple-600 rounded-full blur opacity-75 group-hover:opacity-100 transition duration-1000 group-hover:duration-200 animate-pulse"></div>
                            @if($student->photo)
                                <img class="relative h-20 w-20 rounded-full border-4 border-white shadow-2xl object-cover transform hover:scale-110 transition-all duration-300" 
                                     src="{{ Storage::url($student->photo) }}" 
                                     alt="{{ $student->full_name }}">
                            @else
                                <div class="relative h-20 w-20 rounded-full bg-gradient-to-br from-blue-500 via-purple-500 to-pink-500 flex items-center justify-center border-4 border-white shadow-2xl transform hover:scale-110 transition-all duration-300">
                                    <span class="text-white font-bold text-2xl">
                                        {{ substr($student->full_name, 0, 1) }}
                                    </span>
                                </div>
                            @endif
                            <div class="absolute -bottom-2 -right-2 h-7 w-7 bg-gradient-to-r from-green-400 to-emerald-500 rounded-full border-4 border-white flex items-center justify-center shadow-lg animate-bounce">
                                <svg class="w-3 h-3 text-white" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                </svg>
                            </div>
                        </div>
                        
                        <!-- Student Info -->
                        <div>
                            <h1 class="text-3xl font-bold bg-gradient-to-r from-gray-900 via-blue-800 to-purple-800 dark:from-white dark:via-blue-200 dark:to-purple-200 bg-clip-text text-transparent mb-2">
                                {{ $student->full_name }}
                            </h1>
                            <div class="flex flex-wrap items-center gap-6 text-sm">
                                <span class="flex items-center bg-white/60 dark:bg-gray-700/60 backdrop-blur-sm px-3 py-2 rounded-full shadow-md">
                                    <svg class="w-4 h-4 mr-2 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2"></path>
                                    </svg>
                                    <span class="font-medium text-gray-700 dark:text-gray-300">ID: {{ $student->student_id }}</span>
                                </span>
                                <span class="flex items-center bg-white/60 dark:bg-gray-700/60 backdrop-blur-sm px-3 py-2 rounded-full shadow-md">
                                    <svg class="w-4 h-4 mr-2 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                    </svg>
                                    <span class="font-medium text-gray-700 dark:text-gray-300">{{ $student->partner->name ?? 'No Institute' }}</span>
                                </span>
                                @if($student->email)
                                <span class="flex items-center bg-white/60 dark:bg-gray-700/60 backdrop-blur-sm px-3 py-2 rounded-full shadow-md">
                                    <svg class="w-4 h-4 mr-2 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                    </svg>
                                    <span class="font-medium text-gray-700 dark:text-gray-300">{{ $student->email }}</span>
                                </span>
                                @endif
                            </div>
                        </div>
                    </div>
                    
                    <!-- Overall Performance -->
                    <div class="bg-gradient-to-br from-white via-blue-50 to-indigo-100 dark:from-gray-800 dark:via-gray-700 dark:to-gray-600 rounded-2xl shadow-2xl p-8 text-center min-w-[220px] border border-blue-200 dark:border-gray-600 transform hover:scale-105 transition-all duration-300">
                        <div class="relative">
                            <div class="absolute inset-0 bg-gradient-to-r from-blue-400 to-purple-500 rounded-full opacity-20 animate-pulse"></div>
                            <div class="relative">
                                <div class="text-4xl font-bold bg-gradient-to-r from-blue-600 to-purple-600 dark:from-blue-400 dark:to-purple-400 bg-clip-text text-transparent mb-2">
                                    {{ $comprehensiveAnalytics['overall_accuracy'] }}%
                                </div>
                                <div class="text-sm font-medium text-gray-600 dark:text-gray-400 mb-4">Overall Accuracy</div>
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
                                    <svg class="w-4 h-4 mr-2 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    Easy
                                @elseif($difficulty === 'medium')
                                    <svg class="w-4 h-4 mr-2 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    Medium
                                @else
                                    <svg class="w-4 h-4 mr-2 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                    </svg>
                                    Hard
                                @endif
                            </span>
                            <span class="text-sm font-bold bg-gradient-to-r {{ $difficulty === 'easy' ? 'from-green-400 to-emerald-400' : ($difficulty === 'medium' ? 'from-yellow-400 to-amber-400' : 'from-red-400 to-rose-400') }} bg-clip-text text-transparent bg-{{ $difficulty === 'easy' ? 'green' : ($difficulty === 'medium' ? 'yellow' : 'red') }}-100 dark:bg-{{ $difficulty === 'easy' ? 'green' : ($difficulty === 'medium' ? 'yellow' : 'red') }}-900/50 px-3 py-1 rounded-full">
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
        <div class="bg-gradient-to-br from-white via-gray-50 to-blue-50 dark:from-gray-800 dark:via-gray-700 dark:to-blue-900/20 rounded-2xl shadow-xl overflow-hidden mb-8 border border-gray-200 dark:border-gray-600">
            <div class="bg-gradient-to-r from-blue-500 to-indigo-600 px-8 py-6">
                <div class="flex items-center">
                    <div class="p-3 bg-white/20 backdrop-blur-sm rounded-xl mr-4">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-white">Exam Results</h3>
                </div>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-600">
                    <thead class="bg-gradient-to-r from-gray-50 to-gray-100 dark:from-gray-700 dark:to-gray-600">
                        <tr>
                            <th class="px-8 py-4 text-left text-sm font-bold text-gray-700 dark:text-gray-200 uppercase tracking-wider">Exam</th>
                            <th class="px-8 py-4 text-left text-sm font-bold text-gray-700 dark:text-gray-200 uppercase tracking-wider">Score</th>
                            <th class="px-8 py-4 text-left text-sm font-bold text-gray-700 dark:text-gray-200 uppercase tracking-wider">Grade</th>
                            <th class="px-8 py-4 text-left text-sm font-bold text-gray-700 dark:text-gray-200 uppercase tracking-wider">Status</th>
                            <th class="px-8 py-4 text-left text-sm font-bold text-gray-700 dark:text-gray-200 uppercase tracking-wider">Date</th>
                            <th class="px-8 py-4 text-left text-sm font-bold text-gray-700 dark:text-gray-200 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-600">
                        @foreach($examResults as $result)
                        <tr class="hover:bg-gradient-to-r hover:from-blue-50 hover:to-indigo-50 dark:hover:from-gray-700 dark:hover:to-gray-600 transition-all duration-200">
                            <td class="px-8 py-6">
                                <div class="flex items-center">
                                    <div class="p-2 bg-gradient-to-br from-blue-100 to-indigo-100 dark:from-blue-900/50 dark:to-indigo-900/50 rounded-lg mr-4">
                                        <svg class="w-5 h-5 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                                        </svg>
                                    </div>
                                    <div>
                                        <div class="text-sm font-bold text-gray-900 dark:text-white">{{ $result->exam->title ?? 'Unknown Exam' }}</div>
                                        <div class="text-sm text-gray-500 dark:text-gray-400">{{ $result->correct_answers }}/{{ $result->total_questions }} questions</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-8 py-6 whitespace-nowrap">
                                <div class="text-center">
                                    <div class="text-2xl font-bold bg-gradient-to-r from-blue-600 to-indigo-600 dark:from-blue-400 dark:to-indigo-400 bg-clip-text text-transparent">{{ $result->percentage }}%</div>
                                    <div class="text-sm text-gray-500 dark:text-gray-400">{{ $result->score }} points</div>
                                </div>
                            </td>
                            <td class="px-8 py-6 whitespace-nowrap">
                                <span class="inline-flex px-4 py-2 text-sm font-bold rounded-full shadow-lg
                                    {{ $result->grade === 'A+' || $result->grade === 'A' ? 'bg-gradient-to-r from-green-100 to-emerald-100 text-green-800 dark:from-green-900 dark:to-emerald-900 dark:text-green-200' : 
                                       ($result->grade === 'B' ? 'bg-gradient-to-r from-blue-100 to-indigo-100 text-blue-800 dark:from-blue-900 dark:to-indigo-900 dark:text-blue-200' : 
                                       ($result->grade === 'C' ? 'bg-gradient-to-r from-yellow-100 to-amber-100 text-yellow-800 dark:from-yellow-900 dark:to-amber-900 dark:text-yellow-200' : 
                                       'bg-gradient-to-r from-red-100 to-rose-100 text-red-800 dark:from-red-900 dark:to-rose-900 dark:text-red-200')) }}">
                                    {{ $result->grade }}
                                </span>
                            </td>
                            <td class="px-8 py-6 whitespace-nowrap">
                                <span class="inline-flex px-4 py-2 text-sm font-bold rounded-full shadow-lg
                                    {{ $result->is_passed ? 'bg-gradient-to-r from-green-100 to-emerald-100 text-green-800 dark:from-green-900 dark:to-emerald-900 dark:text-green-200' : 'bg-gradient-to-r from-red-100 to-rose-100 text-red-800 dark:from-red-900 dark:to-rose-900 dark:text-red-200' }}">
                                    {{ $result->is_passed ? 'Passed' : 'Failed' }}
                                </span>
                            </td>
                            <td class="px-8 py-6 whitespace-nowrap text-sm text-gray-600 dark:text-gray-400">
                                {{ $result->completed_at ? $result->completed_at->format('M j, Y g:i A') : 'N/A' }}
                            </td>
                            <td class="px-8 py-6 whitespace-nowrap text-sm font-medium">
                                <button onclick="showExamDetails({{ $result->id }})" class="bg-gradient-to-r from-blue-500 to-indigo-600 hover:from-blue-600 hover:to-indigo-700 text-white px-4 py-2 rounded-lg shadow-lg hover:shadow-xl transition-all duration-200 transform hover:scale-105">
                                    View Details
                                </button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Recent Performance -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md overflow-hidden mb-8">
            <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Recent Performance</h3>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                    <thead class="bg-gray-50 dark:bg-gray-700">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Question</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Type</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Result</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Exam</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Date</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                        @foreach($recentPerformance as $performance)
                        <tr>
                            <td class="px-6 py-4">
                                <div class="text-sm font-medium text-gray-900 dark:text-white">
                                    {{ Str::limit($performance->question->question_text ?? 'N/A', 50) }}
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full
                                    {{ $performance->question_type === 'mcq' ? 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200' : 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200' }}">
                                    {{ strtoupper($performance->question_type) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($performance->is_correct)
                                    <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200">
                                        Correct
                                    </span>
                                @elseif($performance->is_skipped)
                                    <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200">
                                        Skipped
                                    </span>
                                @else
                                    <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200">
                                        Incorrect
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                {{ $performance->exam->title ?? 'N/A' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                {{ $performance->created_at->format('M j, Y g:i A') }}
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Improvement Trend -->
        @if($improvementTrend['trend'] !== 'insufficient_data')
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6 mb-8">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Performance Trend</h3>
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600 dark:text-gray-400">Overall Change</p>
                    <p class="text-2xl font-bold {{ $improvementTrend['change'] > 0 ? 'text-green-600' : ($improvementTrend['change'] < 0 ? 'text-red-600' : 'text-gray-600') }}">
                        {{ $improvementTrend['change'] > 0 ? '+' : '' }}{{ $improvementTrend['change'] }}%
                    </p>
                </div>
                <div class="text-right">
                    <p class="text-sm text-gray-600 dark:text-gray-400">First Score</p>
                    <p class="text-lg font-semibold text-gray-900 dark:text-white">{{ $improvementTrend['first_score'] }}%</p>
                </div>
                <div class="text-right">
                    <p class="text-sm text-gray-600 dark:text-gray-400">Latest Score</p>
                    <p class="text-lg font-semibold text-gray-900 dark:text-white">{{ $improvementTrend['last_score'] }}%</p>
                </div>
                <div class="text-right">
                    <p class="text-sm text-gray-600 dark:text-gray-400">Total Exams</p>
                    <p class="text-lg font-semibold text-gray-900 dark:text-white">{{ $improvementTrend['total_exams'] }}</p>
                </div>
            </div>
        </div>
        @endif

        <!-- Difficult Questions -->
        @if($difficultQuestions->count() > 0)
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md overflow-hidden mb-8">
            <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Questions to Review</h3>
                <p class="text-sm text-gray-600 dark:text-gray-400">Questions you found difficult</p>
            </div>
            <div class="p-6">
                <div class="space-y-4">
                    @foreach($difficultQuestions as $question)
                    <div class="border border-gray-200 dark:border-gray-700 rounded-lg p-4">
                        <div class="flex justify-between items-start">
                            <div class="flex-1">
                                <p class="text-sm font-medium text-gray-900 dark:text-white mb-2">
                                    {{ $question->question->question_text ?? 'Question not available' }}
                                </p>
                                <div class="flex items-center space-x-4 text-xs text-gray-500 dark:text-gray-400">
                                    <span>Type: {{ strtoupper($question->question_type) }}</span>
                                    <span>Exam: {{ $question->exam->title ?? 'N/A' }}</span>
                                    <span>Date: {{ $question->created_at->format('M j, Y') }}</span>
                                </div>
                            </div>
                            <div class="ml-4">
                                <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200">
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

<!-- Exam Details Modal -->
<div id="examDetailsModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
    <div class="relative top-20 mx-auto p-5 border w-11/12 md:w-3/4 lg:w-1/2 shadow-lg rounded-md bg-white dark:bg-gray-800">
        <div class="mt-3">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-medium text-gray-900 dark:text-white">Exam Details</h3>
                <button onclick="closeExamDetails()" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            <div id="examDetailsContent">
                <!-- Content will be loaded here -->
            </div>
        </div>
    </div>
</div>

<script>
function showExamDetails(examResultId) {
    // Show loading state
    document.getElementById('examDetailsContent').innerHTML = `
        <div class="text-center py-8">
            <div class="animate-spin rounded-full h-8 w-8 border-b-2 border-blue-600 mx-auto"></div>
            <p class="text-gray-500 dark:text-gray-400 mt-2">Loading exam details...</p>
        </div>
    `;
    document.getElementById('examDetailsModal').classList.remove('hidden');
    
    // Fetch detailed exam results
    fetch(`/analytics/api/students/{{ $student->id }}/exam-results/${examResultId}`)
        .then(response => response.json())
        .then(data => {
            displayExamDetails(data);
        })
        .catch(error => {
            console.error('Error:', error);
            document.getElementById('examDetailsContent').innerHTML = `
                <div class="text-center py-8">
                    <p class="text-red-500">Error loading exam details. Please try again.</p>
                </div>
            `;
        });
}

function displayExamDetails(data) {
    const { exam_result, detailed_analytics, correct_questions, incorrect_questions, skipped_questions } = data;
    
    const content = `
        <div class="space-y-6">
            <!-- Exam Header -->
            <div class="bg-gradient-to-r from-blue-50 to-purple-50 dark:from-gray-700 dark:to-gray-600 rounded-lg p-4">
                <h4 class="text-xl font-bold text-gray-900 dark:text-white">${exam_result.exam.title}</h4>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mt-4">
                    <div class="text-center">
                        <div class="text-2xl font-bold text-blue-600 dark:text-blue-400">${exam_result.percentage}%</div>
                        <div class="text-sm text-gray-600 dark:text-gray-400">Score</div>
                    </div>
                    <div class="text-center">
                        <div class="text-2xl font-bold text-gray-900 dark:text-white">${exam_result.grade}</div>
                        <div class="text-sm text-gray-600 dark:text-gray-400">Grade</div>
                    </div>
                    <div class="text-center">
                        <div class="text-2xl font-bold ${exam_result.is_passed ? 'text-green-600 dark:text-green-400' : 'text-red-600 dark:text-red-400'}">${exam_result.is_passed ? 'PASSED' : 'FAILED'}</div>
                        <div class="text-sm text-gray-600 dark:text-gray-400">Status</div>
                    </div>
                    <div class="text-center">
                        <div class="text-2xl font-bold text-gray-900 dark:text-white">${exam_result.time_taken || 'N/A'}</div>
                        <div class="text-sm text-gray-600 dark:text-gray-400">Minutes</div>
                    </div>
                </div>
            </div>
            
            <!-- Performance Breakdown -->
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                <div class="bg-green-50 dark:bg-green-900 rounded-lg p-4 text-center">
                    <div class="text-2xl font-bold text-green-600 dark:text-green-400">${detailed_analytics.correct_answers}</div>
                    <div class="text-sm text-green-700 dark:text-green-300">Correct</div>
                </div>
                <div class="bg-red-50 dark:bg-red-900 rounded-lg p-4 text-center">
                    <div class="text-2xl font-bold text-red-600 dark:text-red-400">${detailed_analytics.incorrect_answers}</div>
                    <div class="text-sm text-red-700 dark:text-red-300">Incorrect</div>
                </div>
                <div class="bg-yellow-50 dark:bg-yellow-900 rounded-lg p-4 text-center">
                    <div class="text-2xl font-bold text-yellow-600 dark:text-yellow-400">${detailed_analytics.skipped_questions}</div>
                    <div class="text-sm text-yellow-700 dark:text-yellow-300">Skipped</div>
                </div>
                <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4 text-center">
                    <div class="text-2xl font-bold text-gray-600 dark:text-gray-400">${detailed_analytics.unanswered_questions}</div>
                    <div class="text-sm text-gray-700 dark:text-gray-300">Unanswered</div>
                </div>
            </div>
            
            <!-- Question Type Breakdown -->
            <div>
                <h5 class="text-lg font-semibold text-gray-900 dark:text-white mb-3">Performance by Question Type</h5>
                <div class="space-y-3">
                    ${Object.entries(detailed_analytics.question_type_breakdown).map(([type, stats]) => `
                        <div>
                            <div class="flex justify-between items-center mb-1">
                                <span class="text-sm font-medium text-gray-700 dark:text-gray-300 capitalize">${type}</span>
                                <span class="text-sm text-gray-600 dark:text-gray-400">${stats.correct}/${stats.total}</span>
                            </div>
                            <div class="w-full bg-gray-200 dark:bg-gray-600 rounded-full h-2">
                                <div class="bg-blue-600 h-2 rounded-full" style="width: ${stats.total > 0 ? Math.round((stats.correct / stats.total) * 100) : 0}%"></div>
                            </div>
                        </div>
                    `).join('')}
                </div>
            </div>
            
            <!-- Question Details -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Correct Questions -->
                <div>
                    <h5 class="text-lg font-semibold text-green-600 dark:text-green-400 mb-3">Correct Answers (${correct_questions.length})</h5>
                    <div class="space-y-2 max-h-64 overflow-y-auto">
                        ${correct_questions.map(q => `
                            <div class="bg-green-50 dark:bg-green-900 border border-green-200 dark:border-green-700 rounded p-3">
                                <p class="text-sm text-gray-900 dark:text-white">${q.question ? q.question.question_text.substring(0, 100) + '...' : 'Question not available'}</p>
                                <p class="text-xs text-green-600 dark:text-green-400 mt-1">Type: ${q.question_type.toUpperCase()}</p>
                            </div>
                        `).join('')}
                    </div>
                </div>
                
                <!-- Incorrect Questions -->
                <div>
                    <h5 class="text-lg font-semibold text-red-600 dark:text-red-400 mb-3">Incorrect Answers (${incorrect_questions.length})</h5>
                    <div class="space-y-2 max-h-64 overflow-y-auto">
                        ${incorrect_questions.map(q => `
                            <div class="bg-red-50 dark:bg-red-900 border border-red-200 dark:border-red-700 rounded p-3">
                                <p class="text-sm text-gray-900 dark:text-white">${q.question ? q.question.question_text.substring(0, 100) + '...' : 'Question not available'}</p>
                                <p class="text-xs text-red-600 dark:text-red-400 mt-1">Type: ${q.question_type.toUpperCase()}</p>
                                <p class="text-xs text-gray-600 dark:text-gray-400 mt-1">Your Answer: ${q.student_answer || 'N/A'}</p>
                                <p class="text-xs text-gray-600 dark:text-gray-400">Correct Answer: ${q.correct_answer || 'N/A'}</p>
                            </div>
                        `).join('')}
                    </div>
                </div>
                
                <!-- Skipped Questions -->
                <div>
                    <h5 class="text-lg font-semibold text-yellow-600 dark:text-yellow-400 mb-3">Skipped Questions (${skipped_questions.length})</h5>
                    <div class="space-y-2 max-h-64 overflow-y-auto">
                        ${skipped_questions.map(q => `
                            <div class="bg-yellow-50 dark:bg-yellow-900 border border-yellow-200 dark:border-yellow-700 rounded p-3">
                                <p class="text-sm text-gray-900 dark:text-white">${q.question ? q.question.question_text.substring(0, 100) + '...' : 'Question not available'}</p>
                                <p class="text-xs text-yellow-600 dark:text-yellow-400 mt-1">Type: ${q.question_type.toUpperCase()}</p>
                            </div>
                        `).join('')}
                    </div>
                </div>
            </div>
        </div>
    `;
    
    document.getElementById('examDetailsContent').innerHTML = content;
}

function closeExamDetails() {
    document.getElementById('examDetailsModal').classList.add('hidden');
}

// Close modal when clicking outside
document.getElementById('examDetailsModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeExamDetails();
    }
});
</script>
@endsection
