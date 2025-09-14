@extends('layouts.partner-layout')

@section('content')
<div class="min-h-screen bg-gray-50 dark:bg-gray-900">
    <!-- Page Header -->
    <div class="bg-white dark:bg-gray-800 shadow-sm border-b border-gray-200 dark:border-gray-700">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="py-6">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
                    <div class="flex-1 min-w-0">
                        <h1 class="text-2xl sm:text-3xl font-bold text-gray-900 dark:text-white">
                            Question Analytics
                        </h1>
                        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                            Comprehensive insights into question performance and difficulty analysis
                        </p>
                    </div>
                    <div class="mt-4 sm:mt-0 sm:ml-4">
                        <div class="flex flex-col sm:flex-row gap-3">
                            <div class="inline-flex items-center px-3 py-2 rounded-lg bg-green-50 dark:bg-green-900/20 text-green-700 dark:text-green-400 text-sm font-medium border border-green-200 dark:border-green-800">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                </svg>
                                Live Data
                            </div>
                            <a href="{{ route('partner.questions.all') }}" 
                               class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg transition-colors duration-200">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                </svg>
                                Manage Questions
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Key Metrics Cards -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6 mb-8">
            <!-- Total Questions Card -->
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6 hover:shadow-md transition-shadow duration-200">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-12 h-12 bg-blue-100 dark:bg-blue-900/20 rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="ml-4 flex-1">
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Total Questions</p>
                        <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ number_format($totalQuestions) }}</p>
                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">In question bank</p>
                    </div>
                </div>
            </div>

            <!-- Total Attempts Card -->
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6 hover:shadow-md transition-shadow duration-200">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-12 h-12 bg-green-100 dark:bg-green-900/20 rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="ml-4 flex-1">
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Total Attempts</p>
                        <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ number_format($totalAttempts) }}</p>
                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Student responses</p>
                    </div>
                </div>
            </div>

            <!-- Overall Accuracy Card -->
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6 hover:shadow-md transition-shadow duration-200">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-12 h-12 bg-purple-100 dark:bg-purple-900/20 rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="ml-4 flex-1">
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Overall Accuracy</p>
                        <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $overallAccuracy }}%</p>
                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Average performance</p>
                    </div>
                </div>
            </div>

            <!-- Questions with Data Card -->
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6 hover:shadow-md transition-shadow duration-200">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-12 h-12 bg-orange-100 dark:bg-orange-900/20 rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6 text-orange-600 dark:text-orange-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="ml-4 flex-1">
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">With Sufficient Data</p>
                        <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ number_format($questionsWithSufficientData) }}</p>
                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">For analysis</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Charts Section -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
            <!-- Difficulty Distribution Chart -->
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Difficulty Distribution</h3>
                    <div class="flex items-center space-x-2">
                        <div class="w-2 h-2 bg-green-500 rounded-full"></div>
                        <span class="text-sm text-gray-500 dark:text-gray-400">Real-time</span>
                    </div>
                </div>
                <div class="h-64 sm:h-80">
                    <canvas id="difficultyChart"></canvas>
                </div>
            </div>

            <!-- Performance Distribution Chart -->
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Answer Distribution</h3>
                    <div class="flex items-center space-x-2">
                        <div class="w-2 h-2 bg-blue-500 rounded-full"></div>
                        <span class="text-sm text-gray-500 dark:text-gray-400">Live data</span>
                    </div>
                </div>
                <div class="h-64 sm:h-80">
                    <canvas id="performanceChart"></canvas>
                </div>
            </div>
        </div>

        <!-- Detailed Statistics -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
            <!-- Answer Status Breakdown -->
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-6">Answer Status Breakdown</h3>
                <div class="space-y-4">
                    <div class="flex items-center justify-between p-4 bg-green-50 dark:bg-green-900/20 rounded-lg border border-green-200 dark:border-green-800">
                        <div class="flex items-center space-x-3">
                            <div class="w-3 h-3 bg-green-500 rounded-full"></div>
                            <span class="font-medium text-gray-900 dark:text-white">Correct Answers</span>
                        </div>
                        <div class="text-right">
                            <span class="text-xl font-bold text-green-600 dark:text-green-400">{{ number_format($totalCorrect) }}</span>
                            <p class="text-sm text-gray-500 dark:text-gray-400">{{ $totalAttempts > 0 ? round(($totalCorrect / $totalAttempts) * 100, 1) : 0 }}%</p>
                        </div>
                    </div>
                    
                    <div class="flex items-center justify-between p-4 bg-red-50 dark:bg-red-900/20 rounded-lg border border-red-200 dark:border-red-800">
                        <div class="flex items-center space-x-3">
                            <div class="w-3 h-3 bg-red-500 rounded-full"></div>
                            <span class="font-medium text-gray-900 dark:text-white">Incorrect Answers</span>
                        </div>
                        <div class="text-right">
                            <span class="text-xl font-bold text-red-600 dark:text-red-400">{{ number_format($totalIncorrect) }}</span>
                            <p class="text-sm text-gray-500 dark:text-gray-400">{{ $totalAttempts > 0 ? round(($totalIncorrect / $totalAttempts) * 100, 1) : 0 }}%</p>
                        </div>
                    </div>
                    
                    <div class="flex items-center justify-between p-4 bg-yellow-50 dark:bg-yellow-900/20 rounded-lg border border-yellow-200 dark:border-yellow-800">
                        <div class="flex items-center space-x-3">
                            <div class="w-3 h-3 bg-yellow-500 rounded-full"></div>
                            <span class="font-medium text-gray-900 dark:text-white">Skipped Questions</span>
                        </div>
                        <div class="text-right">
                            <span class="text-xl font-bold text-yellow-600 dark:text-yellow-400">{{ number_format($totalSkipped) }}</span>
                            <p class="text-sm text-gray-500 dark:text-gray-400">{{ $totalAttempts > 0 ? round(($totalSkipped / $totalAttempts) * 100, 1) : 0 }}%</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Difficulty Statistics -->
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-6">Difficulty Statistics</h3>
                <div class="space-y-3">
                    @foreach($questionsByDifficulty as $level => $count)
                        @php
                            $percentage = $totalQuestions > 0 ? round(($count / $totalQuestions) * 100, 1) : 0;
                            $colors = [
                                'very_easy' => 'bg-green-100 dark:bg-green-900/20 text-green-800 dark:text-green-400 border-green-200 dark:border-green-800',
                                'easy' => 'bg-blue-100 dark:bg-blue-900/20 text-blue-800 dark:text-blue-400 border-blue-200 dark:border-blue-800',
                                'medium' => 'bg-yellow-100 dark:bg-yellow-900/20 text-yellow-800 dark:text-yellow-400 border-yellow-200 dark:border-yellow-800',
                                'hard' => 'bg-orange-100 dark:bg-orange-900/20 text-orange-800 dark:text-orange-400 border-orange-200 dark:border-orange-800',
                                'very_hard' => 'bg-red-100 dark:bg-red-900/20 text-red-800 dark:text-red-400 border-red-200 dark:border-red-800'
                            ];
                            $colorClass = $colors[$level] ?? 'bg-gray-100 dark:bg-gray-900/20 text-gray-800 dark:text-gray-400 border-gray-200 dark:border-gray-800';
                        @endphp
                        <div class="flex items-center justify-between p-3 rounded-lg border {{ $colorClass }}">
                            <div class="flex items-center space-x-3">
                                <span class="font-medium capitalize">{{ str_replace('_', ' ', $level) }}</span>
                            </div>
                            <div class="text-right">
                                <span class="text-lg font-bold">{{ number_format($count) }}</span>
                                <p class="text-sm">{{ $percentage }}%</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Question Performance Analysis -->
        <div class="grid grid-cols-1 xl:grid-cols-2 gap-6 mb-8">
            <!-- Top Performing Questions -->
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700">
                <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                    <div class="flex items-center justify-between">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Top Performing Questions</h3>
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 dark:bg-green-900/20 text-green-800 dark:text-green-400">
                            {{ count($topQuestions) }} questions
                        </span>
                    </div>
                </div>
                <div class="p-6">
                    <div class="space-y-4">
                        @forelse($topQuestions as $index => $questionStat)
                            @php
                                $question = $questionStat->question;
                            @endphp
                            <div class="flex items-center justify-between p-4 bg-green-50 dark:bg-green-900/20 rounded-lg border border-green-200 dark:border-green-800 hover:shadow-sm transition-shadow duration-200">
                                <div class="flex items-center space-x-4 flex-1 min-w-0">
                                    <div class="flex-shrink-0 w-8 h-8 bg-green-500 text-white rounded-full flex items-center justify-center text-sm font-bold">
                                        {{ $index + 1 }}
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <a href="{{ route('analytics.questions.show', $questionStat->question_id) }}" 
                                           class="text-sm font-medium text-gray-900 dark:text-white hover:text-blue-600 dark:hover:text-blue-400 transition-colors duration-200 truncate block">
                                            {{ $question->question_text ?? 'Question #' . $questionStat->question_id }}
                                        </a>
                                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                                            {{ $questionStat->total_attempts }} attempts • {{ $questionStat->correct_attempts }} correct
                                        </p>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <span class="text-lg font-bold text-green-600 dark:text-green-400">{{ $questionStat->accuracy_percentage }}%</span>
                                </div>
                            </div>
                        @empty
                            <div class="text-center py-8">
                                <svg class="mx-auto h-12 w-12 text-gray-400 dark:text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                                </svg>
                                <p class="text-gray-500 dark:text-gray-400 mt-2">No data available</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>

            <!-- Questions Needing Attention -->
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700">
                <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-3">
                            <div class="p-2 bg-red-100 dark:bg-red-900/20 rounded-lg">
                                <svg class="w-5 h-5 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Questions Needing Attention</h3>
                                <p class="text-sm text-gray-500 dark:text-gray-400">Low accuracy questions</p>
                            </div>
                        </div>
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 dark:bg-red-900/20 text-red-800 dark:text-red-400">
                            {{ count($worstQuestions) }} issues
                        </span>
                    </div>
                </div>
                <div class="p-6">
                    <div class="space-y-3">
                        @forelse($worstQuestions as $index => $questionStat)
                            @php
                                $question = $questionStat->question;
                                $alertLevel = $questionStat->accuracy_percentage <= 25 ? 'critical' : ($questionStat->accuracy_percentage <= 50 ? 'high' : 'medium');
                                $alertColors = [
                                    'critical' => 'border-l-red-500 bg-red-50 dark:bg-red-900/20',
                                    'high' => 'border-l-orange-500 bg-orange-50 dark:bg-orange-900/20',
                                    'medium' => 'border-l-yellow-500 bg-yellow-50 dark:bg-yellow-900/20'
                                ];
                                $alertColor = $alertColors[$alertLevel] ?? 'border-l-gray-500 bg-gray-50 dark:bg-gray-900/20';
                            @endphp
                            <div class="relative p-4 rounded-lg border-l-4 {{ $alertColor }} hover:shadow-sm transition-shadow duration-200">
                                <div class="flex items-start justify-between">
                                    <div class="flex-1 min-w-0">
                                        <a href="{{ route('analytics.questions.show', $questionStat->question_id) }}" 
                                           class="text-sm font-medium text-gray-900 dark:text-white hover:text-blue-600 dark:hover:text-blue-400 transition-colors duration-200 block truncate">
                                            {{ $question->question_text ?? 'Question #' . $questionStat->question_id }}
                                        </a>
                                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                                            {{ $questionStat->total_attempts }} attempts • {{ $questionStat->correct_attempts }} correct
                                        </p>
                                    </div>
                                    <div class="ml-4 flex items-center space-x-2">
                                        <span class="text-lg font-bold text-red-600 dark:text-red-400">{{ $questionStat->accuracy_percentage }}%</span>
                                        @if($alertLevel === 'critical')
                                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-red-100 dark:bg-red-900/20 text-red-800 dark:text-red-400">
                                                Critical
                                            </span>
                                        @elseif($alertLevel === 'high')
                                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-orange-100 dark:bg-orange-900/20 text-orange-800 dark:text-orange-400">
                                                High
                                            </span>
                                        @else
                                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-yellow-100 dark:bg-yellow-900/20 text-yellow-800 dark:text-yellow-400">
                                                Review
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="text-center py-8">
                                <div class="mx-auto w-16 h-16 bg-green-100 dark:bg-green-900/20 rounded-full flex items-center justify-center mb-4">
                                    <svg class="w-8 h-8 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                                <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-2">No Issues Found</h3>
                                <p class="text-gray-500 dark:text-gray-400">All questions are performing well!</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>

        <!-- System Information -->
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-6">System Information</h3>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                <div class="p-4 bg-blue-50 dark:bg-blue-900/20 rounded-lg border border-blue-200 dark:border-blue-800">
                    <div class="flex items-center space-x-3">
                        <div class="p-2 bg-blue-500 rounded-lg">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                            </svg>
                        </div>
                        <div>
                            <h4 class="font-medium text-gray-900 dark:text-white">Calculation Method</h4>
                            <p class="text-sm text-gray-600 dark:text-gray-400">Real-time analysis</p>
                        </div>
                    </div>
                </div>

                <div class="p-4 bg-green-50 dark:bg-green-900/20 rounded-lg border border-green-200 dark:border-green-800">
                    <div class="flex items-center space-x-3">
                        <div class="p-2 bg-green-500 rounded-lg">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div>
                            <h4 class="font-medium text-gray-900 dark:text-white">Average Difficulty</h4>
                            <p class="text-sm text-gray-600 dark:text-gray-400">{{ $difficultyStats['average_difficulty'] ?? 0 }}/5</p>
                        </div>
                    </div>
                </div>

                <div class="p-4 bg-purple-50 dark:bg-purple-900/20 rounded-lg border border-purple-200 dark:border-purple-800">
                    <div class="flex items-center space-x-3">
                        <div class="p-2 bg-purple-500 rounded-lg">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div>
                            <h4 class="font-medium text-gray-900 dark:text-white">Min Attempts</h4>
                            <p class="text-sm text-gray-600 dark:text-gray-400">≥5 for analysis</p>
                        </div>
                    </div>
                </div>

                <div class="p-4 bg-orange-50 dark:bg-orange-900/20 rounded-lg border border-orange-200 dark:border-orange-800">
                    <div class="flex items-center space-x-3">
                        <div class="p-2 bg-orange-500 rounded-lg">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                            </svg>
                        </div>
                        <div>
                            <h4 class="font-medium text-gray-900 dark:text-white">Data Quality</h4>
                            <p class="text-sm text-gray-600 dark:text-gray-400">Auto-calculated</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
    /* Simple chart legend styling */
    .chartjs-legend {
        font-family: Arial, sans-serif !important;
        font-size: 11px !important;
        font-weight: 400 !important;
        color: #374151 !important;
        line-height: 1.2 !important;
    }
    
    .chartjs-legend li {
        font-size: 11px !important;
        font-weight: 400 !important;
        color: #374151 !important;
        margin: 4px 0 !important;
    }
    
    .chartjs-legend li span {
        font-size: 11px !important;
        font-weight: 400 !important;
        color: #374151 !important;
    }
    
    /* Ensure chart containers have proper spacing */
    .h-64, .h-80 {
        padding-bottom: 20px;
    }
    
    /* Mobile responsiveness for chart legends */
    @media (max-width: 640px) {
        .chartjs-legend {
            font-size: 10px !important;
        }
        
        .chartjs-legend li {
            font-size: 10px !important;
            margin: 3px 0 !important;
        }
        
        .chartjs-legend li span {
            font-size: 10px !important;
        }
    }
</style>
@endpush

@push('scripts')
<!-- Chart.js for data visualization -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    // Chart.js configuration for better mobile responsiveness and readability
    Chart.defaults.font.family = 'Arial, sans-serif';
    Chart.defaults.font.size = 12;
    Chart.defaults.font.weight = '400';
    Chart.defaults.color = '#374151';
    
    // Ensure proper font loading
    Chart.defaults.plugins.legend.labels.font = {
        family: 'Arial, sans-serif',
        size: 12,
        weight: '400'
    };
    Chart.defaults.plugins.legend.labels.color = '#374151';

    // Difficulty Distribution Chart
    const difficultyCtx = document.getElementById('difficultyChart').getContext('2d');
    new Chart(difficultyCtx, {
        type: 'doughnut',
        data: {
            labels: ['Very Easy', 'Easy', 'Medium', 'Hard', 'Very Hard'],
            datasets: [{
                data: [
                    {{ $questionsByDifficulty['very_easy'] }},
                    {{ $questionsByDifficulty['easy'] }},
                    {{ $questionsByDifficulty['medium'] }},
                    {{ $questionsByDifficulty['hard'] }},
                    {{ $questionsByDifficulty['very_hard'] }}
                ],
                backgroundColor: [
                    '#10B981',
                    '#3B82F6',
                    '#F59E0B',
                    '#F97316',
                    '#EF4444'
                ],
                borderWidth: 0,
                hoverOffset: 4
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom',
                    align: 'center',
                    labels: {
                        padding: 15,
                        usePointStyle: true,
                        pointStyle: 'circle',
                        font: {
                            size: 11,
                            weight: '400',
                            family: 'Arial, sans-serif',
                            lineHeight: 1.2
                        },
                        color: '#374151',
                        boxWidth: 10,
                        boxHeight: 10,
                        generateLabels: function(chart) {
                            const data = chart.data;
                            if (data.labels.length && data.datasets.length) {
                                return data.labels.map((label, i) => {
                                    const dataset = data.datasets[0];
                                    const value = dataset.data[i];
                                    const total = dataset.data.reduce((a, b) => a + b, 0);
                                    const percentage = total > 0 ? ((value / total) * 100).toFixed(1) : 0;
                                    
                                    return {
                                        text: `${label}: ${value} (${percentage}%)`,
                                        fillStyle: dataset.backgroundColor[i],
                                        strokeStyle: dataset.backgroundColor[i],
                                        lineWidth: 0,
                                        pointStyle: 'circle',
                                        hidden: false,
                                        index: i
                                    };
                                });
                            }
                            return [];
                        }
                    }
                },
                tooltip: {
                    backgroundColor: 'rgba(0, 0, 0, 0.8)',
                    titleColor: 'white',
                    bodyColor: 'white',
                    borderColor: 'rgba(255, 255, 255, 0.1)',
                    borderWidth: 1,
                    cornerRadius: 8,
                    displayColors: true,
                    callbacks: {
                        label: function(context) {
                            const total = context.dataset.data.reduce((a, b) => a + b, 0);
                            const percentage = ((context.parsed / total) * 100).toFixed(1);
                            return context.label + ': ' + context.parsed + ' (' + percentage + '%)';
                        }
                    }
                }
            },
            cutout: '60%'
        }
    });

    // Performance Distribution Chart
    const performanceCtx = document.getElementById('performanceChart').getContext('2d');
    new Chart(performanceCtx, {
        type: 'doughnut',
        data: {
            labels: ['Correct', 'Incorrect', 'Skipped'],
            datasets: [{
                data: [{{ $totalCorrect }}, {{ $totalIncorrect }}, {{ $totalSkipped }}],
                backgroundColor: [
                    '#10B981',
                    '#EF4444',
                    '#F59E0B'
                ],
                borderWidth: 0,
                hoverOffset: 4
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom',
                    align: 'center',
                    labels: {
                        padding: 15,
                        usePointStyle: true,
                        pointStyle: 'circle',
                        font: {
                            size: 11,
                            weight: '400',
                            family: 'Arial, sans-serif',
                            lineHeight: 1.2
                        },
                        color: '#374151',
                        boxWidth: 10,
                        boxHeight: 10,
                        generateLabels: function(chart) {
                            const data = chart.data;
                            if (data.labels.length && data.datasets.length) {
                                return data.labels.map((label, i) => {
                                    const dataset = data.datasets[0];
                                    const value = dataset.data[i];
                                    const total = dataset.data.reduce((a, b) => a + b, 0);
                                    const percentage = total > 0 ? ((value / total) * 100).toFixed(1) : 0;
                                    
                                    return {
                                        text: `${label}: ${value} (${percentage}%)`,
                                        fillStyle: dataset.backgroundColor[i],
                                        strokeStyle: dataset.backgroundColor[i],
                                        lineWidth: 0,
                                        pointStyle: 'circle',
                                        hidden: false,
                                        index: i
                                    };
                                });
                            }
                            return [];
                        }
                    }
                },
                tooltip: {
                    backgroundColor: 'rgba(0, 0, 0, 0.8)',
                    titleColor: 'white',
                    bodyColor: 'white',
                    borderColor: 'rgba(255, 255, 255, 0.1)',
                    borderWidth: 1,
                    cornerRadius: 8,
                    displayColors: true,
                    callbacks: {
                        label: function(context) {
                            const total = context.dataset.data.reduce((a, b) => a + b, 0);
                            const percentage = ((context.parsed / total) * 100).toFixed(1);
                            return context.label + ': ' + context.parsed + ' (' + percentage + '%)';
                        }
                    }
                }
            },
            cutout: '60%'
        }
    });

    // Handle window resize for better mobile responsiveness
    window.addEventListener('resize', function() {
        Chart.helpers.each(Chart.instances, function(chart) {
            chart.resize();
        });
    });
    
    // Ensure chart legends are properly styled after rendering
    function enhanceChartLegends() {
        Chart.helpers.each(Chart.instances, function(chart) {
            if (chart.legend && chart.legend.legendItems) {
                chart.legend.legendItems.forEach(function(item) {
                    if (item.textElement) {
                        item.textElement.style.fontSize = '11px';
                        item.textElement.style.fontWeight = '400';
                        item.textElement.style.color = '#374151';
                        item.textElement.style.fontFamily = 'Arial, sans-serif';
                    }
                });
            }
        });
    }
    
    // Apply legend enhancements after charts are rendered
    setTimeout(enhanceChartLegends, 100);
    setTimeout(enhanceChartLegends, 500);
</script>
@endpush
@endsection