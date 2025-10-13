@extends('layouts.student-layout')

@section('title', 'My Analytics')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100 dark:from-gray-900 dark:to-gray-800 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-8">
            <div>
                <h1 class="text-3xl font-bold text-gray-900 dark:text-white">My Analytics</h1>
                <p class="text-gray-600 dark:text-gray-400 mt-1">Track your academic performance and progress</p>
            </div>
            <a href="{{ route('student.dashboard') }}" 
               class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-gray-600 to-gray-700 hover:from-gray-700 hover:to-gray-800 text-white rounded-xl shadow-md hover:shadow-lg transition-all duration-300 transform hover:-translate-y-0.5">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Back to Dashboard
            </a>
        </div>

        <!-- Summary Stats -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <!-- Total Exams -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg p-6 border border-gray-200 dark:border-gray-700 transition-all duration-300 hover:shadow-xl">
                <div class="flex items-center">
                    <div class="p-3 rounded-xl bg-blue-100 dark:bg-blue-900/30">
                        <svg class="w-6 h-6 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-lg font-medium text-gray-500 dark:text-gray-400">Total Exams</h3>
                        <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $stats['totalExams'] }}</p>
                    </div>
                </div>
            </div>

            <!-- Average Score -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg p-6 border border-gray-200 dark:border-gray-700 transition-all duration-300 hover:shadow-xl">
                <div class="flex items-center">
                    <div class="p-3 rounded-xl bg-green-100 dark:bg-green-900/30">
                        <svg class="w-6 h-6 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-lg font-medium text-gray-500 dark:text-gray-400">Average Score</h3>
                        <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $stats['averageScore'] }}%</p>
                    </div>
                </div>
            </div>

            <!-- Accuracy -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg p-6 border border-gray-200 dark:border-gray-700 transition-all duration-300 hover:shadow-xl">
                <div class="flex items-center">
                    <div class="p-3 rounded-xl bg-amber-100 dark:bg-amber-900/30">
                        <svg class="w-6 h-6 text-amber-600 dark:text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-lg font-medium text-gray-500 dark:text-gray-400">Accuracy</h3>
                        <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $stats['accuracy'] }}%</p>
                    </div>
                </div>
            </div>

            <!-- Passed Exams -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg p-6 border border-gray-200 dark:border-gray-700 transition-all duration-300 hover:shadow-xl">
                <div class="flex items-center">
                    <div class="p-3 rounded-xl bg-purple-100 dark:bg-purple-900/30">
                        <svg class="w-6 h-6 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-lg font-medium text-gray-500 dark:text-gray-400">Passed Exams</h3>
                        <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $stats['passedExams'] }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Charts and Performance Section -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
            <!-- Performance Trend Chart -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg p-6 border border-gray-200 dark:border-gray-700">
                <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-6">Performance Trend</h3>
                <div class="h-64 flex items-end justify-between gap-2">
                    @foreach($performanceTrend as $index => $trend)
                        <div class="flex flex-col items-center flex-1">
                            <div class="w-full flex justify-center mb-2">
                                <span class="text-sm font-medium text-gray-900 dark:text-white">{{ $trend['score'] }}%</span>
                            </div>
                            <div class="w-8 md:w-10 relative group">
                                <div 
                                    class="w-full bg-gradient-to-t from-primaryGreen to-emerald-500 rounded-t-lg transition-all duration-300 hover:opacity-75"
                                    style="height: {{ $trend['score'] > 0 ? ($trend['score'] / 100) * 200 : 5 }}px"
                                ></div>
                                <div class="absolute -bottom-8 left-1/2 transform -translate-x-1/2 text-xs text-gray-500 dark:text-gray-400 whitespace-nowrap">
                                    {{ $trend['date'] }}
                                </div>
                                <div class="absolute -top-8 left-1/2 transform -translate-x-1/2 bg-gray-900 text-white text-xs rounded py-1 px-2 opacity-0 group-hover:opacity-100 transition-opacity duration-300 whitespace-nowrap">
                                    {{ $trend['exam'] }}
                                    <div class="absolute bottom-0 left-1/2 transform -translate-x-1/2 translate-y-full w-0 h-0 border-l-4 border-r-4 border-t-4 border-l-transparent border-r-transparent border-t-gray-900"></div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Subject Performance -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg p-6 border border-gray-200 dark:border-gray-700">
                <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-6">Subject Performance</h3>
                @if($subjectPerformance->count() > 0)
                    <div class="space-y-4">
                        @foreach($subjectPerformance as $subject)
                            <div>
                                <div class="flex justify-between mb-1">
                                    <span class="text-sm font-medium text-gray-900 dark:text-white">{{ $subject['subject'] }}</span>
                                    <span class="text-sm font-medium text-gray-900 dark:text-white">{{ $subject['average'] }}%</span>
                                </div>
                                <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-2.5">
                                    <div 
                                        class="bg-gradient-to-r from-primaryGreen to-emerald-500 h-2.5 rounded-full" 
                                        style="width: {{ $subject['average'] }}%">
                                    </div>
                                </div>
                                <div class="flex justify-between mt-1 text-xs text-gray-500 dark:text-gray-400">
                                    <span>{{ $subject['exams'] }} exams</span>
                                    <span>H: {{ $subject['highest'] }}% | L: {{ $subject['lowest'] }}%</span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-8">
                        <svg class="mx-auto h-12 w-12 text-gray-400 dark:text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                        </svg>
                        <h3 class="mt-2 text-sm font-medium text-gray-900 dark:text-white">No subject data</h3>
                        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Take some exams to see your subject performance.</p>
                    </div>
                @endif
            </div>
        </div>

        <!-- Detailed Stats -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Exam Stats -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg p-6 border border-gray-200 dark:border-gray-700">
                <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-6">Exam Statistics</h3>
                <div class="space-y-4">
                    <div class="flex justify-between">
                        <span class="text-gray-600 dark:text-gray-400">Passed Exams</span>
                        <span class="font-medium text-gray-900 dark:text-white">{{ $stats['passedExams'] }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600 dark:text-gray-400">Failed Exams</span>
                        <span class="font-medium text-gray-900 dark:text-white">{{ $stats['failedExams'] }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600 dark:text-gray-400">Highest Score</span>
                        <span class="font-medium text-gray-900 dark:text-white">{{ $stats['highestScore'] }}%</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600 dark:text-gray-400">Lowest Score</span>
                        <span class="font-medium text-gray-900 dark:text-white">{{ $stats['lowestScore'] }}%</span>
                    </div>
                </div>
            </div>

            <!-- Question Stats -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg p-6 border border-gray-200 dark:border-gray-700">
                <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-6">Question Statistics</h3>
                <div class="space-y-4">
                    <div class="flex justify-between">
                        <span class="text-gray-600 dark:text-gray-400">Total Questions</span>
                        <span class="font-medium text-gray-900 dark:text-white">{{ $questionStats['total_questions'] }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600 dark:text-gray-400">Correct Answers</span>
                        <span class="font-medium text-green-600 dark:text-green-400">{{ $questionStats['correct_answers'] }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600 dark:text-gray-400">Wrong Answers</span>
                        <span class="font-medium text-red-600 dark:text-red-400">{{ $questionStats['wrong_answers'] }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600 dark:text-gray-400">Unanswered</span>
                        <span class="font-medium text-amber-600 dark:text-amber-400">{{ $questionStats['unanswered'] }}</span>
                    </div>
                </div>
            </div>

            <!-- Time Stats -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg p-6 border border-gray-200 dark:border-gray-700">
                <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-6">Time Statistics</h3>
                <div class="space-y-4">
                    <div class="flex justify-between">
                        <span class="text-gray-600 dark:text-gray-400">Total Time</span>
                        <span class="font-medium text-gray-900 dark:text-white">{{ gmdate('H:i:s', $stats['totalTime']) }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600 dark:text-gray-400">Average Time</span>
                        <span class="font-medium text-gray-900 dark:text-white">{{ gmdate('H:i:s', $stats['averageTime']) }}</span>
                    </div>
                    <div class="pt-4">
                        <div class="flex items-center justify-center p-4 bg-gradient-to-br from-primaryGreen/10 to-emerald-50 dark:from-primaryGreen/20 dark:to-emerald-900/30 rounded-xl">
                            <div class="text-center">
                                <div class="text-2xl font-bold text-gray-900 dark:text-white">{{ $stats['averageScore'] }}%</div>
                                <div class="text-sm text-gray-600 dark:text-gray-400">Overall Performance</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Exams -->
        @if($examResults->count() > 0)
            <div class="mt-8 bg-white dark:bg-gray-800 rounded-2xl shadow-lg p-6 border border-gray-200 dark:border-gray-700">
                <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-6">Recent Exams</h3>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                        <thead class="bg-gray-50 dark:bg-gray-700">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Exam</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Date</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Score</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Status</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200 dark:bg-gray-800 dark:divide-gray-700">
                            @foreach($examResults->take(5) as $result)
                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-750 transition-colors duration-200">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-white">
                                        {{ $result->exam->title ?? 'Unknown Exam' }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                        {{ $result->created_at->format('M d, Y') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white">
                                        {{ round($result->percentage, 1) }}%
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                            @if($result->percentage >= 50)
                                                bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200
                                            @else
                                                bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200
                                            @endif">
                                            @if($result->percentage >= 50)
                                                Passed
                                            @else
                                                Failed
                                            @endif
                                        </span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @endif
    </div>
</div>

<!-- Custom Styles -->
<style>
    .dark .bg-gradient-to-r {
        background: linear-gradient(90deg, #10b981, #059669);
    }
    
    .dark .bg-gradient-to-t {
        background: linear-gradient(0deg, #10b981, #059669);
    }
    
    .dark .bg-gradient-to-br {
        background: linear-gradient(135deg, #10b981, #059669);
    }
</style>
@endsection