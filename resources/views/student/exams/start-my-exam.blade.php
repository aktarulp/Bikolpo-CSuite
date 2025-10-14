@extends('layouts.student-layout')

@section('title', 'Start Exam - ' . $exam->title)

@section('content')
<div class="min-h-screen py-6">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Header -->
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-6">
            <div>
                <h1 class="text-2xl md:text-3xl font-bold text-gray-900 dark:text-white">Start Exam</h1>
                <p class="text-gray-600 dark:text-gray-400 mt-1">Review exam details before beginning</p>
            </div>
            <a href="{{ route('student.exams.available') }}" 
               class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-gray-600 to-gray-700 hover:from-gray-700 hover:to-gray-800 text-white rounded-lg shadow-md hover:shadow-lg transition-all duration-300 transform hover:-translate-y-0.5">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Back to Exams
            </a>
        </div>

        <!-- Main Content -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg overflow-hidden">
            <div class="p-5 md:p-6 border-b border-gray-200 dark:border-gray-700">
                <h2 class="text-xl md:text-2xl font-bold text-gray-900 dark:text-white">
                    {{ $exam->title }}
                </h2>
                <p class="text-gray-600 dark:text-gray-400 mt-1">Please review the exam information carefully before starting</p>
            </div>

            <div class="p-5 md:p-6">
                <!-- Exam Information Grid -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
                    <!-- Duration -->
                    <div class="bg-gradient-to-br from-primaryGreen/10 to-emerald-50 dark:from-primaryGreen/20 dark:to-emerald-900/30 rounded-xl p-4 border border-primaryGreen/20">
                        <div class="flex items-center">
                            <div class="p-2 rounded-lg bg-primaryGreen/10">
                                <svg class="w-5 h-5 text-primaryGreen" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <div class="ml-3">
                                <h3 class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wide">Duration</h3>
                                <p class="text-lg font-bold text-gray-900 dark:text-white">{{ $exam->duration }} min</p>
                            </div>
                        </div>
                    </div>

                    <!-- Questions -->
                    <div class="bg-gradient-to-br from-blue-50 to-blue-100 dark:from-blue-900/30 dark:to-blue-800/20 rounded-xl p-4 border border-blue-200 dark:border-blue-800/50">
                        <div class="flex items-center">
                            <div class="p-2 rounded-lg bg-blue-100 dark:bg-blue-900/50">
                                <svg class="w-5 h-5 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <div class="ml-3">
                                <h3 class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wide">Questions</h3>
                                <p class="text-lg font-bold text-gray-900 dark:text-white">{{ $exam->total_questions ?? 'N/A' }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Passing Marks -->
                    <div class="bg-gradient-to-br from-amber-50 to-amber-100 dark:from-amber-900/30 dark:to-amber-800/20 rounded-xl p-4 border border-amber-200 dark:border-amber-800/50">
                        <div class="flex items-center">
                            <div class="p-2 rounded-lg bg-amber-100 dark:bg-amber-900/50">
                                <svg class="w-5 h-5 text-amber-600 dark:text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <div class="ml-3">
                                <h3 class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wide">Passing</h3>
                                <p class="text-lg font-bold text-gray-900 dark:text-white">{{ $exam->passing_marks }}%</p>
                            </div>
                        </div>
                    </div>

                    <!-- Status -->
                    <div class="bg-gradient-to-br from-purple-50 to-purple-100 dark:from-purple-900/30 dark:to-purple-800/20 rounded-xl p-4 border border-purple-200 dark:border-purple-800/50">
                        <div class="flex items-center">
                            <div class="p-2 rounded-lg bg-purple-100 dark:bg-purple-900/50">
                                <svg class="w-5 h-5 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <div class="ml-3">
                                <h3 class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wide">Status</h3>
                                <p class="text-lg font-bold text-gray-900 dark:text-white">Available</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Schedule Information -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-8">
                    <div class="bg-gray-50 dark:bg-gray-750 rounded-xl p-4">
                        <div class="flex items-center">
                            <div class="p-2 rounded-lg bg-gray-200 dark:bg-gray-700">
                                <svg class="w-5 h-5 text-gray-600 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                            </div>
                            <div class="ml-3">
                                <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400">Start Time</h3>
                                <p class="text-base font-medium text-gray-900 dark:text-white">{{ $exam->start_time->format('M d, Y g:i A') }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="bg-gray-50 dark:bg-gray-750 rounded-xl p-4">
                        <div class="flex items-center">
                            <div class="p-2 rounded-lg bg-gray-200 dark:bg-gray-700">
                                <svg class="w-5 h-5 text-gray-600 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                            </div>
                            <div class="ml-3">
                                <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400">End Time</h3>
                                <p class="text-base font-medium text-gray-900 dark:text-white">{{ $exam->end_time->format('M d, Y g:i A') }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Exam Description -->
                @if($exam->description)
                <div class="mb-8">
                    <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-3">Exam Description</h3>
                    <div class="bg-gray-50 dark:bg-gray-750 rounded-xl p-4">
                        <p class="text-gray-700 dark:text-gray-300">{{ $exam->description }}</p>
                    </div>
                </div>
                @endif

                <!-- Important Instructions -->
                <div class="mb-8">
                    <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-3 flex items-center">
                        <svg class="w-5 h-5 text-amber-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                        </svg>
                        Important Instructions
                    </h3>
                    <div class="bg-amber-50 dark:bg-amber-900/20 rounded-xl p-4 border border-amber-200 dark:border-amber-800/50">
                        <ul class="space-y-2">
                            <li class="flex items-start">
                                <svg class="w-5 h-5 text-amber-500 mr-2 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <span class="text-amber-800 dark:text-amber-200">You have <strong>{{ $exam->duration }} minutes</strong> to complete this exam</span>
                            </li>
                            <li class="flex items-start">
                                <svg class="w-5 h-5 text-amber-500 mr-2 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <span class="text-amber-800 dark:text-amber-200">The timer starts immediately when you begin the exam</span>
                            </li>
                            <li class="flex items-start">
                                <svg class="w-5 h-5 text-amber-500 mr-2 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <span class="text-amber-800 dark:text-amber-200">Do not refresh or close the browser during the exam</span>
                            </li>
                            <li class="flex items-start">
                                <svg class="w-5 h-5 text-amber-500 mr-2 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <span class="text-amber-800 dark:text-amber-200">Ensure you have a stable internet connection</span>
                            </li>
                            <li class="flex items-start">
                                <svg class="w-5 h-5 text-amber-500 mr-2 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <span class="text-amber-800 dark:text-amber-200">You cannot pause or restart the exam once started</span>
                            </li>
                        </ul>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="flex flex-col sm:flex-row gap-3">
                    <a href="{{ route('student.exams.take', $exam) }}" 
                       class="flex-1 inline-flex items-center justify-center py-3 px-6 bg-gradient-to-r from-primaryGreen to-emerald-600 hover:from-primaryGreen/90 hover:to-emerald-700 text-white font-medium rounded-lg shadow-md hover:shadow-lg transition-all duration-300 transform hover:-translate-y-0.5">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"></path>
                        </svg>
                        Start Exam Now
                    </a>
                    
                    <a href="{{ route('student.exams.available') }}" 
                       class="inline-flex items-center justify-center py-3 px-6 bg-gray-200 dark:bg-gray-700 hover:bg-gray-300 dark:hover:bg-gray-600 text-gray-800 dark:text-white font-medium rounded-lg shadow transition-all duration-300">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                        Cancel
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection