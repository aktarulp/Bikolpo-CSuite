@extends('layouts.partner-layout')

@section('title', 'Student Analytics - ' . $student->full_name)

@section('content')
<div class="min-h-screen bg-gray-50 dark:bg-gray-900 font-sans antialiased text-gray-900 dark:text-gray-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 md:py-12">
        <div class="mb-8 md:mb-12">
            <div class="bg-white dark:bg-gray-800 rounded-3xl shadow-2xl p-6 md:p-10 border border-gray-200 dark:border-gray-700">
                <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between">
                    <div class="flex flex-col sm:flex-row items-center space-y-4 sm:space-y-0 sm:space-x-6 mb-6 lg:mb-0 w-full lg:w-auto">
                        <div class="relative group flex-shrink-0">
                            @if($student->photo)
                                <img class="h-24 w-24 sm:h-28 sm:w-28 rounded-full border-4 border-white dark:border-gray-800 shadow-xl object-cover transition-all duration-300 transform hover:scale-105 hover:shadow-2xl"
                                     src="{{ Storage::url($student->photo) }}"
                                     alt="{{ $student->full_name }}">
                            @else
                                <div class="h-24 w-24 sm:h-28 sm:w-28 rounded-full bg-gradient-to-br from-blue-500 to-purple-500 flex items-center justify-center border-4 border-white dark:border-gray-800 shadow-xl transition-all duration-300 transform hover:scale-105 hover:shadow-2xl">
                                    <span class="text-white font-bold text-3xl sm:text-4xl">
                                        {{ substr($student->full_name, 0, 1) }}
                                    </span>
                                </div>
                            @endif
                        </div>

                        <div class="text-center sm:text-left">
                            <h1 class="text-3xl sm:text-4xl font-extrabold text-gray-900 dark:text-white leading-tight mb-2">
                                {{ $student->full_name }}
                            </h1>
                            <div class="flex flex-wrap justify-center sm:justify-start items-center gap-2 md:gap-4 text-sm">
                                <span class="flex items-center bg-gray-100 dark:bg-gray-700/50 px-3 py-1.5 rounded-full text-gray-700 dark:text-gray-300 font-medium">
                                    <svg class="w-4 h-4 mr-2 text-blue-500 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2"></path>
                                    </svg>
                                    ID: <span class="ml-1 font-semibold">{{ $student->student_id }}</span>
                                </span>
                                <span class="flex items-center bg-gray-100 dark:bg-gray-700/50 px-3 py-1.5 rounded-full text-gray-700 dark:text-gray-300 font-medium">
                                    <svg class="w-4 h-4 mr-2 text-purple-500 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                    </svg>
                                    <span class="font-semibold">{{ $student->partner->name ?? 'No Institute' }}</span>
                                </span>
                                @if($student->email)
                                <span class="flex items-center bg-gray-100 dark:bg-gray-700/50 px-3 py-1.5 rounded-full text-gray-700 dark:text-gray-300 font-medium">
                                    <svg class="w-4 h-4 mr-2 text-green-500 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                    </svg>
                                    <span class="font-semibold">{{ $student->email }}</span>
                                </span>
                                @endif
                            </div>
                        </div>
                    </div>

                     {{-- START: Updated Overall Accuracy Card --}}
                     <div class="bg-gray-100 dark:bg-gray-700/50 rounded-2xl shadow-inner p-3 text-center sm:w-40 lg:w-36 flex-shrink-0 border border-gray-300 dark:border-gray-600 transition-all duration-300 hover:shadow-xl mt-6 lg:mt-0">
                        <div class="relative">
                            <div class="text-4xl font-extrabold text-blue-600 dark:text-blue-400 mb-1">
                                {{ $comprehensiveAnalytics['overall_accuracy'] }}<span class="text-2xl">%</span>
                            </div>
                            <div class="text-sm font-semibold text-gray-600 dark:text-gray-400 mb-3">Overall Accuracy</div>
                            @if($comprehensiveAnalytics['overall_accuracy'] >= 80)
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-200 shadow-sm">
                                    <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                    </svg>
                                    Excellent
                                </span>
                            @elseif($comprehensiveAnalytics['overall_accuracy'] >= 60)
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-yellow-100 dark:bg-yellow-900 text-yellow-800 dark:text-yellow-200 shadow-sm">
                                    <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"></path>
                                    </svg>
                                    Good
                                </span>
                            @else
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-red-100 dark:bg-red-900 text-red-800 dark:text-red-200 shadow-sm">
                                    <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                                    </svg>
                                    Needs Improvement
                                </span>
                            @endif
                        </div>
                    </div>
                    {{-- END: Updated Overall Accuracy Card --}}
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 md:gap-8 mb-8 md:mb-12">
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg p-6 md:p-8 flex flex-col justify-between border border-gray-200 dark:border-gray-700 transition-all duration-300 transform hover:-translate-y-1 hover:shadow-2xl">
                <div class="flex items-center justify-between mb-4">
                    <div class="p-4 rounded-xl bg-green-500 dark:bg-green-600 text-white shadow-lg">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div class="text-right">
                        <div class="text-4xl font-extrabold text-green-600 dark:text-green-400">
                            {{ $comprehensiveAnalytics['total_correct_answers'] }}
                        </div>
                        <div class="text-sm font-semibold text-gray-600 dark:text-gray-400">Correct Answers</div>
                    </div>
                </div>
                <div class="mt-4">
                    <div class="flex justify-between text-sm font-semibold text-gray-700 dark:text-gray-300">
                        <span>Accuracy</span>
                        <span class="text-green-600 dark:text-green-400">{{ $comprehensiveAnalytics['total_questions_attempted'] > 0 ? round(($comprehensiveAnalytics['total_correct_answers'] / $comprehensiveAnalytics['total_questions_attempted']) * 100, 1) : 0 }}%</span>
                    </div>
                    <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-2.5 mt-2">
                        <div class="bg-green-500 h-2.5 rounded-full" style="width: {{ $comprehensiveAnalytics['total_questions_attempted'] > 0 ? round(($comprehensiveAnalytics['total_correct_answers'] / $comprehensiveAnalytics['total_questions_attempted']) * 100, 1) : 0 }}%"></div>
                    </div>
                </div>
            </div>

            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg p-6 md:p-8 flex flex-col justify-between border border-gray-200 dark:border-gray-700 transition-all duration-300 transform hover:-translate-y-1 hover:shadow-2xl">
                <div class="flex items-center justify-between mb-4">
                    <div class="p-4 rounded-xl bg-red-500 dark:bg-red-600 text-white shadow-lg">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </div>
                    <div class="text-right">
                        <div class="text-4xl font-extrabold text-red-600 dark:text-red-400">
                            {{ $comprehensiveAnalytics['total_incorrect_answers'] }}
                        </div>
                        <div class="text-sm font-semibold text-gray-600 dark:text-gray-400">Incorrect Answers</div>
                    </div>
                </div>
                <div class="mt-4">
                    <div class="flex justify-between text-sm font-semibold text-gray-700 dark:text-gray-300">
                        <span>Error Rate</span>
                        <span class="text-red-600 dark:text-red-400">{{ $comprehensiveAnalytics['total_questions_attempted'] > 0 ? round(($comprehensiveAnalytics['total_incorrect_answers'] / $comprehensiveAnalytics['total_questions_attempted']) * 100, 1) : 0 }}%</span>
                    </div>
                    <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-2.5 mt-2">
                        <div class="bg-red-500 h-2.5 rounded-full" style="width: {{ $comprehensiveAnalytics['total_questions_attempted'] > 0 ? round(($comprehensiveAnalytics['total_incorrect_answers'] / $comprehensiveAnalytics['total_questions_attempted']) * 100, 1) : 0 }}%"></div>
                    </div>
                </div>
            </div>

            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg p-6 md:p-8 flex flex-col justify-between border border-gray-200 dark:border-gray-700 transition-all duration-300 transform hover:-translate-y-1 hover:shadow-2xl">
                <div class="flex items-center justify-between mb-4">
                    <div class="p-4 rounded-xl bg-yellow-500 dark:bg-yellow-600 text-white shadow-lg">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div class="text-right">
                        <div class="text-4xl font-extrabold text-yellow-600 dark:text-yellow-400">
                            {{ $comprehensiveAnalytics['total_skipped_questions'] }}
                        </div>
                        <div class="text-sm font-semibold text-gray-600 dark:text-gray-400">Skipped Questions</div>
                    </div>
                </div>
                <div class="mt-4">
                    <div class="flex justify-between text-sm font-semibold text-gray-700 dark:text-gray-300">
                        <span>Skip Rate</span>
                        <span class="text-yellow-600 dark:text-yellow-400">{{ $comprehensiveAnalytics['total_questions_attempted'] > 0 ? round(($comprehensiveAnalytics['total_skipped_questions'] / $comprehensiveAnalytics['total_questions_attempted']) * 100, 1) : 0 }}%</span>
                    </div>
                    <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-2.5 mt-2">
                        <div class="bg-yellow-500 h-2.5 rounded-full" style="width: {{ $comprehensiveAnalytics['total_questions_attempted'] > 0 ? round(($comprehensiveAnalytics['total_skipped_questions'] / $comprehensiveAnalytics['total_questions_attempted']) * 100, 1) : 0 }}%"></div>
                    </div>
                </div>
            </div>

            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg p-6 md:p-8 flex flex-col justify-between border border-gray-200 dark:border-gray-700 transition-all duration-300 transform hover:-translate-y-1 hover:shadow-2xl">
                <div class="flex items-center justify-between mb-4">
                    <div class="p-4 rounded-xl bg-blue-500 dark:bg-blue-600 text-white shadow-lg">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                        </svg>
                    </div>
                    <div class="text-right">
                        <div class="text-4xl font-extrabold text-blue-600 dark:text-blue-400">
                            {{ $comprehensiveAnalytics['total_exams_taken'] }}
                        </div>
                        <div class="text-sm font-semibold text-gray-600 dark:text-gray-400">Exams Taken</div>
                    </div>
                </div>
                <div class="mt-4">
                    <div class="flex justify-between text-sm font-semibold text-gray-700 dark:text-gray-300">
                        <span>Avg Score</span>
                        <span class="text-blue-600 dark:text-blue-400">{{ $comprehensiveAnalytics['average_exam_score'] ?? 'N/A' }}%</span>
                    </div>
                    <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-2.5 mt-2">
                        <div class="bg-blue-500 h-2.5 rounded-full" style="width: {{ $comprehensiveAnalytics['average_exam_score'] ?? 0 }}%"></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 md:gap-8 mb-8 md:mb-12">
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg p-6 md:p-8 border border-gray-200 dark:border-gray-700 transition-all duration-300 hover:shadow-2xl">
                <div class="flex items-center mb-6">
                    <div class="p-3 bg-blue-500 dark:bg-blue-600 rounded-xl text-white shadow-lg mr-4">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 dark:text-white">Performance by Question Type</h3>
                </div>
                <div class="space-y-6">
                    @foreach($questionTypePerformance as $type => $stats)
                    <div class="bg-gray-100 dark:bg-gray-700/50 rounded-lg p-4">
                        <div class="flex justify-between items-center mb-2">
                            <span class="text-sm font-semibold text-gray-800 dark:text-gray-200 capitalize flex items-center">
                                @if($type === 'mcq')
                                    <svg class="w-4 h-4 mr-2 text-blue-500 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    Multiple Choice
                                @else
                                    <svg class="w-4 h-4 mr-2 text-purple-500 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                    </svg>
                                    Constructed Response
                                @endif
                            </span>
                            <span class="text-sm font-bold text-gray-700 dark:text-gray-300">
                                {{ $stats['correct'] }}/{{ $stats['total'] }}
                            </span>
                        </div>
                        <div class="w-full bg-gray-200 dark:bg-gray-600 rounded-full h-2.5 overflow-hidden">
                            <div class="bg-blue-500 dark:bg-blue-400 h-2.5 rounded-full" style="width: {{ $stats['total'] > 0 ? round(($stats['correct'] / $stats['total']) * 100, 2) : 0 }}%"></div>
                        </div>
                        <div class="text-xs font-medium text-gray-600 dark:text-gray-400 mt-2">
                            {{ $stats['total'] > 0 ? round(($stats['correct'] / $stats['total']) * 100, 2) : 0 }}% accuracy
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg p-6 md:p-8 border border-gray-200 dark:border-gray-700 transition-all duration-300 hover:shadow-2xl">
                <div class="flex items-center mb-6">
                    <div class="p-3 bg-purple-500 dark:bg-purple-600 rounded-xl text-white shadow-lg mr-4">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 dark:text-white">Performance by Difficulty</h3>
                </div>
                <div class="space-y-6">
                    @foreach($difficultyPerformance as $difficulty => $stats)
                    <div class="bg-gray-100 dark:bg-gray-700/50 rounded-lg p-4">
                        <div class="flex justify-between items-center mb-2">
                            <span class="text-sm font-semibold text-gray-800 dark:text-gray-200 capitalize flex items-center">
                                @if($difficulty === 'easy')
                                    <svg class="w-4 h-4 mr-2 text-green-500 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    Easy
                                @elseif($difficulty === 'medium')
                                    <svg class="w-4 h-4 mr-2 text-yellow-500 dark:text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    Medium
                                @else
                                    <svg class="w-4 h-4 mr-2 text-red-500 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                    </svg>
                                    Hard
                                @endif
                            </span>
                            <span class="text-sm font-bold {{ $difficulty === 'easy' ? 'text-green-600 dark:text-green-400' : ($difficulty === 'medium' ? 'text-yellow-600 dark:text-yellow-400' : 'text-red-600 dark:text-red-400') }}">
                                {{ $stats['correct'] }}/{{ $stats['total'] }}
                            </span>
                        </div>
                        <div class="w-full bg-gray-200 dark:bg-gray-600 rounded-full h-2.5 overflow-hidden">
                            <div class="{{ $difficulty === 'easy' ? 'bg-green-500' : ($difficulty === 'medium' ? 'bg-yellow-500' : 'bg-red-500') }} h-2.5 rounded-full" style="width: {{ $stats['total'] > 0 ? round(($stats['correct'] / $stats['total']) * 100, 2) : 0 }}%"></div>
                        </div>
                        <div class="text-xs font-medium text-gray-600 dark:text-gray-400 mt-2">
                            {{ $stats['total'] > 0 ? round(($stats['correct'] / $stats['total']) * 100, 2) : 0 }}% accuracy
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg overflow-hidden mb-8 md:mb-12 border border-gray-200 dark:border-gray-700">
            <div class="bg-gray-100 dark:bg-gray-700 px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                <h3 class="text-xl font-bold text-gray-900 dark:text-white">Exam Results</h3>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                    <thead class="bg-gray-50 dark:bg-gray-700">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Exam</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Score</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Grade</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Status</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Date</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                        @foreach($examResults as $result)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors duration-200">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-10 w-10 bg-gray-100 dark:bg-gray-700 rounded-full flex items-center justify-center text-blue-500 dark:text-blue-400">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                                        </svg>
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-bold text-gray-900 dark:text-white">{{ $result->exam->title ?? 'Unknown Exam' }}</div>
                                        <div class="text-sm text-gray-500 dark:text-gray-400">{{ $result->correct_answers }}/{{ $result->total_questions }} questions</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                <div class="text-xl font-bold text-blue-600 dark:text-blue-400">{{ $result->percentage }}%</div>
                                <div class="text-sm text-gray-500 dark:text-gray-400">{{ $result->score }} points</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                <span class="px-3 py-1.5 rounded-full font-semibold
                                    {{ $result->grade === 'A+' || $result->grade === 'A' ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200' :
                                       ($result->grade === 'B' ? 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200' :
                                       ($result->grade === 'C' ? 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200' :
                                       'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200')) }}">
                                    {{ $result->grade }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                <span class="px-3 py-1.5 rounded-full font-semibold
                                    {{ $result->is_passed ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200' : 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200' }}">
                                    {{ $result->is_passed ? 'Passed' : 'Failed' }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600 dark:text-gray-400">
                                {{ $result->completed_at ? $result->completed_at->format('M j, Y') : 'N/A' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <button onclick="showExamDetails({{ $result->id }})" class="text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-300 font-semibold transition-colors duration-200">
                                    View Details
                                </button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg overflow-hidden mb-8 md:mb-12 border border-gray-200 dark:border-gray-700">
            <div class="bg-gray-100 dark:bg-gray-700 px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                <h3 class="text-xl font-bold text-gray-900 dark:text-white">Recent Performance</h3>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                    <thead class="bg-gray-50 dark:bg-gray-700">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Question</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Type</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Result</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Exam</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Date</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                        @foreach($recentPerformance as $performance)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors duration-200">
                            <td class="px-6 py-4 max-w-sm">
                                <div class="text-sm font-medium text-gray-900 dark:text-white truncate">
                                    {{ $performance->question->question_text ?? 'N/A' }}
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 py-1 text-xs font-semibold rounded-full
                                    {{ $performance->question_type === 'mcq' ? 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200' : 'bg-purple-100 text-purple-800 dark:bg-purple-900 dark:text-purple-200' }}">
                                    {{ strtoupper($performance->question_type) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($performance->is_correct)
                                    <span class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200">
                                        Correct
                                    </span>
                                @elseif($performance->is_skipped)
                                    <span class="px-2 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200">
                                        Skipped
                                    </span>
                                @else
                                    <span class="px-2 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200">
                                        Incorrect
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                {{ $performance->exam->title ?? 'N/A' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                {{ $performance->created_at->format('M j, Y') }}
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        @if($improvementTrend['trend'] !== 'insufficient_data')
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg p-6 md:p-8 mb-8 md:mb-12 border border-gray-200 dark:border-gray-700">
            <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-6">Performance Trend</h3>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 md:gap-8 text-center">
                <div>
                    <p class="text-sm font-medium text-gray-600 dark:text-gray-400 mb-1">Overall Change</p>
                    <p class="text-3xl font-extrabold {{ $improvementTrend['change'] > 0 ? 'text-green-600 dark:text-green-400' : ($improvementTrend['change'] < 0 ? 'text-red-600 dark:text-red-400' : 'text-gray-600 dark:text-gray-400') }}">
                        {{ $improvementTrend['change'] > 0 ? '+' : '' }}{{ $improvementTrend['change'] }}%
                    </p>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-600 dark:text-gray-400 mb-1">First Score</p>
                    <p class="text-3xl font-extrabold text-gray-900 dark:text-white">{{ $improvementTrend['first_score'] }}%</p>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-600 dark:text-gray-400 mb-1">Latest Score</p>
                    <p class="text-3xl font-extrabold text-gray-900 dark:text-white">{{ $improvementTrend['last_score'] }}%</p>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-600 dark:text-gray-400 mb-1">Total Exams</p>
                    <p class="text-3xl font-extrabold text-gray-900 dark:text-white">{{ $improvementTrend['total_exams'] }}</p>
                </div>
            </div>
        </div>
        @endif

        @if($difficultQuestions->count() > 0)
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg overflow-hidden border border-gray-200 dark:border-gray-700">
            <div class="bg-gray-100 dark:bg-gray-700 px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                <h3 class="text-xl font-bold text-gray-900 dark:text-white">Questions to Review</h3>
                <p class="text-sm text-gray-600 dark:text-gray-400">Questions you found difficult</p>
            </div>
            <div class="p-6">
                <div class="space-y-4">
                    @foreach($difficultQuestions as $question)
                    <div class="bg-gray-50 dark:bg-gray-700/50 rounded-lg p-4 transition-colors duration-200 hover:bg-gray-100 dark:hover:bg-gray-700">
                        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
                            <div class="flex-1 mb-2 sm:mb-0">
                                <p class="text-sm font-semibold text-gray-900 dark:text-white mb-1">
                                    {{ $question->question->question_text ?? 'Question not available' }}
                                </p>
                                <div class="flex flex-wrap items-center gap-2 text-xs text-gray-500 dark:text-gray-400">
                                    <span class="font-medium">Type: {{ strtoupper($question->question_type) }}</span>
                                    <span class="mx-1">•</span>
                                    <span class="font-medium">Exam: {{ $question->exam->title ?? 'N/A' }}</span>
                                    <span class="mx-1">•</span>
                                    <span class="font-medium">Date: {{ $question->created_at->format('M j, Y') }}</span>
                                </div>
                            </div>
                            <div class="flex-shrink-0">
                                <span class="px-2 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200">
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