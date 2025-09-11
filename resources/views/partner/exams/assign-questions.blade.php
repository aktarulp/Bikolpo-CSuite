@extends('layouts.partner-layout')

@section('title', 'Assign Questions to Exam')

@section('content')
<!-- Success/Error Messages -->
@if (session('success'))
    <div class="fixed top-4 right-4 z-50 bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg transform transition-all duration-300 translate-x-0">
        <div class="flex items-center gap-2">
            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
            </svg>
            <span class="font-medium">{{ session('success') }}</span>
        </div>
    </div>
@endif

@if (session('import_errors'))
    <div class="fixed top-4 right-4 z-50 bg-yellow-500 text-white px-6 py-3 rounded-lg shadow-lg max-w-md">
        <div class="flex items-start gap-2">
            <svg class="w-5 h-5 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
            </svg>
            <div>
                <h3 class="font-medium">Import completed with errors</h3>
                <div class="mt-1 text-sm opacity-90 max-h-32 overflow-y-auto">
                    <ul class="list-disc pl-4 space-y-1">
                        @foreach (session('import_errors') as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endif

<div class="min-h-screen bg-gray-50 dark:bg-gray-900">
    <!-- Header Section -->
    <div class="bg-white dark:bg-gray-800 shadow-sm border-b border-gray-200 dark:border-gray-700">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="py-6">
                <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
                    <!-- Title Section -->
                    <div class="flex-1 min-w-0">
                        <div class="flex items-center gap-3 mb-2">
                            <div class="p-2 bg-blue-100 dark:bg-blue-900 rounded-lg">
                                <svg class="w-6 h-6 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                                </svg>
                            </div>
                <div>
                                <h1 class="text-2xl lg:text-3xl font-bold text-gray-900 dark:text-white">Assign Questions</h1>
                                <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">{{ $exam->title }}</p>
                </div>
                        </div>
                    </div>
                    
                    <!-- Action Buttons -->
                    <div class="flex flex-col sm:flex-row gap-3">
                    <a href="{{ route('partner.exams.show', $exam) }}" 
                           class="inline-flex items-center justify-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-300 dark:hover:bg-gray-600 transition-colors">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                            </svg>
                        View Exam
                    </a>
                    <a href="{{ route('partner.exams.index') }}" 
                           class="inline-flex items-center justify-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-300 dark:hover:bg-gray-600 transition-colors">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                            </svg>
                        Back
                    </a>
                    </div>
                </div>
                </div>
            </div>
        </div>

        <!-- Main Content -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
        <div class="space-y-6">
            <!-- Exam Info Cards -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div class="bg-white dark:bg-gray-800 rounded-xl p-6 shadow-sm border border-gray-200 dark:border-gray-700">
                    <div class="flex items-center gap-3">
                        <div class="p-3 bg-blue-100 dark:bg-blue-900 rounded-lg">
                            <svg class="w-6 h-6 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Max Questions</p>
                            <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $exam->total_questions }}</p>
                        </div>
                    </div>
                </div>
                
                <div class="bg-white dark:bg-gray-800 rounded-xl p-6 shadow-sm border border-gray-200 dark:border-gray-700">
                    <div class="flex items-center gap-3">
                        <div class="p-3 bg-green-100 dark:bg-green-900 rounded-lg">
                            <svg class="w-6 h-6 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Duration</p>
                            <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $exam->duration }} min</p>
                        </div>
                    </div>
                </div>
                
                <div class="bg-white dark:bg-gray-800 rounded-xl p-6 shadow-sm border border-gray-200 dark:border-gray-700">
                    <div class="flex items-center gap-3">
                        <div class="p-3 bg-purple-100 dark:bg-purple-900 rounded-lg">
                            <svg class="w-6 h-6 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Status</p>
                            <span class="inline-flex items-center px-2 py-1 rounded-full text-sm font-medium
                                {{ $exam->status === 'published' ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200' : 
                                   ($exam->status === 'draft' ? 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200' : 'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-200') }}">
                                <div class="w-2 h-2 rounded-full mr-2 {{ $exam->status === 'published' ? 'bg-green-500' : ($exam->status === 'draft' ? 'bg-yellow-500' : 'bg-gray-500') }}"></div>
                            {{ ucfirst($exam->status) }}
                        </span>
                        </div>
                    </div>
                    </div>
                </div>

            <!-- Main Form Card -->
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700">
                <form action="{{ route('partner.exams.store-assigned-questions', $exam) }}" method="POST">
                    @csrf

                    <!-- Header Section -->
                    <div class="px-6 py-6 border-b border-gray-200 dark:border-gray-700">
                        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-6">
                            <div class="flex-1">
                                <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-2">Select Questions</h2>
                                <p class="text-gray-600 dark:text-gray-400">Choose questions to assign to this exam</p>
                                </div>
                            
                            <!-- Progress Display -->
                            <div class="flex items-center gap-6">
                                <div class="text-center">
                                    <div class="text-3xl font-bold text-blue-600 dark:text-blue-400" id="selected-count">0</div>
                                    <div class="text-sm text-gray-500 dark:text-gray-400">Selected</div>
                            </div>
                                <div class="text-gray-400 dark:text-gray-500 text-2xl">/</div>
                                <div class="text-center">
                                    <div class="text-3xl font-bold text-gray-700 dark:text-gray-300" id="total-allowed">{{ $exam->total_questions }}</div>
                                    <div class="text-sm text-gray-500 dark:text-gray-400">Max</div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Enhanced Progress Bar -->
                        <div class="mt-6">
                            <div class="flex items-center justify-between mb-2">
                                <span class="text-sm font-medium text-gray-700 dark:text-gray-300">Progress</span>
                                <span class="text-sm font-semibold text-blue-600 dark:text-blue-400" id="progress-percentage">0%</span>
                            </div>
                            <div class="relative w-full h-3 bg-gray-200 dark:bg-gray-700 rounded-full overflow-hidden shadow-inner">
                                <div class="absolute inset-0 bg-gradient-to-r from-gray-100 to-gray-200 dark:from-gray-600 dark:to-gray-700 rounded-full"></div>
                                <div class="relative h-full bg-gradient-to-r from-blue-500 via-blue-600 to-indigo-600 rounded-full transition-all duration-700 ease-out shadow-lg" 
                                     id="progress-bar" 
                                     style="width: 0%">
                                    <div class="absolute inset-0 bg-gradient-to-r from-transparent via-white to-transparent opacity-30 animate-shimmer"></div>
                                </div>
                                <div class="absolute inset-0 flex items-center justify-center">
                                    <div class="w-2 h-2 bg-white rounded-full shadow-lg opacity-0 transition-opacity duration-300" id="progress-dot"></div>
                                </div>
                            </div>
                            <div class="flex items-center justify-between mt-3">
                                <div class="text-sm text-gray-600 dark:text-gray-400">
                                    <span id="selected-count-display">0</span> of <span id="total-allowed-display">{{ $exam->total_questions }}</span> selected
                                </div>
                                <div class="text-sm font-medium text-gray-500 dark:text-gray-400">
                                    <span id="remaining-count">{{ $exam->total_questions }}</span> remaining
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Limit Warning -->
                    <div id="limit-warning" class="hidden mb-4 p-3 bg-yellow-50 border border-yellow-200 rounded-lg dark:bg-yellow-900/20 dark:border-yellow-800">
                        <div class="flex items-center">
                            <svg class="w-5 h-5 text-yellow-600 dark:text-yellow-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                            </svg>
                            <span class="text-sm text-yellow-800 dark:text-yellow-200">
                                You have reached the maximum number of questions allowed for this exam. Deselect some questions to select others.
                            </span>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-700/50">
                        <div class="flex flex-col sm:flex-row gap-4 sm:justify-end">
                            <a href="{{ route('partner.exams.show', $exam) }}" 
                               class="inline-flex items-center justify-center px-6 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 dark:bg-gray-800 dark:border-gray-600 dark:text-gray-300 dark:hover:bg-gray-700 transition-colors">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                </svg>
                                Cancel
                            </a>
                            @if($questions->count() > 0)
                                <button type="submit" 
                                        class="inline-flex items-center justify-center px-8 py-2 text-sm font-medium text-white bg-blue-600 border border-transparent rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-colors">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    Assign
                                </button>
                            @else
                                <button type="button" 
                                        class="inline-flex items-center justify-center px-8 py-2 text-sm font-medium text-gray-400 bg-gray-200 border border-transparent rounded-lg cursor-not-allowed dark:bg-gray-700 dark:text-gray-500">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    No Questions Available
                                </button>
                            @endif
                        </div>
                    </div>
                    
                    <!-- Stats Section -->
                    <div class="py-2 px-4 sm:px-6">
                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3 sm:gap-4 lg:gap-6">
                            <!-- Total Questions Card -->
                            <div class="stats-card rounded-xl p-3 sm:p-4">
                                <div class="flex items-center justify-between">
                                    <div class="w-10 h-10 sm:w-12 sm:h-12 bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl flex items-center justify-center shadow-lg">
                                        <svg class="w-5 h-5 sm:w-6 sm:h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                        </svg>
                                    </div>
                                    <div class="text-right">
                                        <div class="text-2xl sm:text-3xl font-bold text-gray-900 dark:text-white">{{ $questions->count() }}</div>
                                        <div class="text-xs sm:text-sm font-medium text-gray-600 dark:text-gray-400">Total Questions</div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- MCQ Card -->
                            <div class="stats-card rounded-xl p-3 sm:p-4">
                                <div class="flex items-center justify-between">
                                    <div class="w-10 h-10 sm:w-12 sm:h-12 bg-gradient-to-br from-indigo-500 to-indigo-600 rounded-xl flex items-center justify-center shadow-lg">
                                        <img src="{{ asset('images/mcq.png') }}" alt="MCQ" class="w-5 h-5 sm:w-6 sm:h-6">
                                    </div>
                                    <div class="text-right">
                                        <div class="text-2xl sm:text-3xl font-bold text-gray-900 dark:text-white">{{ $questions->where('question_type', 'mcq')->count() }}</div>
                                        <div class="text-xs sm:text-sm font-medium text-gray-600 dark:text-gray-400">MCQ</div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Descriptive Card -->
                            <div class="stats-card rounded-xl p-3 sm:p-4">
                                <div class="flex items-center justify-between">
                                    <div class="w-10 h-10 sm:w-12 sm:h-12 bg-gradient-to-br from-green-500 to-green-600 rounded-xl flex items-center justify-center shadow-lg">
                                        <img src="{{ asset('images/cq.png') }}" alt="CQ" class="w-5 h-5 sm:w-6 sm:h-6">
                                    </div>
                                    <div class="text-right">
                                        <div class="text-2xl sm:text-3xl font-bold text-gray-900 dark:text-white">{{ $questions->where('question_type', 'descriptive')->count() }}</div>
                                        <div class="text-xs sm:text-sm font-medium text-gray-600 dark:text-gray-400">Descriptive</div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- True/False Card -->
                            <div class="stats-card rounded-xl p-3 sm:p-4">
                                <div class="flex items-center justify-between">
                                    <div class="w-10 h-10 sm:w-12 sm:h-12 bg-gradient-to-br from-orange-500 to-orange-600 rounded-xl flex items-center justify-center shadow-lg">
                                        <svg class="w-5 h-5 sm:w-6 sm:h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                    </div>
                                    <div class="text-right">
                                        <div class="text-2xl sm:text-3xl font-bold text-gray-900 dark:text-white">{{ $questions->where('question_type', 'true_false')->count() }}</div>
                                        <div class="text-xs sm:text-sm font-medium text-gray-600 dark:text-gray-400">True/False</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Search and Filters -->
                    <div class="px-6 py-6 space-y-6">
                        <!-- Enhanced Search Bar -->
                        <div class="search-container">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 search-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                </svg>
                            </div>
                            <input type="text" 
                                   id="search" 
                                   name="search" 
                                   placeholder="Search questions by text, course, subject, or topic..."
                                   class="search-input block w-full"
                                   autocomplete="off">
                            <div class="absolute inset-y-0 right-0 flex items-center pr-3">
                                <button type="button" 
                                        id="clear-search" 
                                        class="clear-button">
                                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                    </svg>
                            </button>
                                <div id="search-loading" class="search-loading">
                                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                    </svg>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Search Results Info -->
                        <div id="search-results-info" class="search-results-info">
                            <span id="search-results-count">0</span> questions found
                        </div>

                        <!-- Filters -->
                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Question Type</label>
                                <select id="type-filter" class="block w-full px-3 py-2 border border-gray-300 rounded-lg text-sm bg-white dark:bg-gray-700 dark:border-gray-600 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200">
                                    <option value="">All Types</option>
                                    @foreach($questionTypes as $questionType)
                                        <option value="{{ $questionType['value'] }}">{{ $questionType['label'] }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Course</label>
                                <select id="course-filter" class="block w-full px-3 py-2 border border-gray-300 rounded-lg text-sm bg-white dark:bg-gray-700 dark:border-gray-600 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200">
                                    <option value="">All Courses</option>
                                    @foreach($courses as $course)
                                        <option value="{{ $course->id }}">{{ $course->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Subject</label>
                                <select id="subject-filter" class="block w-full px-3 py-2 border border-gray-300 rounded-lg text-sm bg-white dark:bg-gray-700 dark:border-gray-600 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200">
                                    <option value="">All Subjects</option>
                                    @foreach($subjects as $subject)
                                        <option value="{{ $subject->id }}">{{ $subject->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Topic</label>
                                <select id="topic-filter" class="block w-full px-3 py-2 border border-gray-300 rounded-lg text-sm bg-white dark:bg-gray-700 dark:border-gray-600 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200">
                                    <option value="">All Topics</option>
                                    @foreach($topics as $topic)
                                        <option value="{{ $topic->id }}">{{ $topic->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            </div>
                            
                        <!-- Action Buttons -->
                        <div class="flex flex-col sm:flex-row gap-3 sm:justify-between">
                            <div class="flex flex-col sm:flex-row gap-3">
                                <button type="button" id="select-all" 
                                        class="inline-flex items-center px-4 py-2 text-sm font-medium text-blue-600 bg-blue-50 border border-blue-200 rounded-lg hover:bg-blue-100 dark:bg-blue-900/20 dark:border-blue-800 dark:text-blue-400 dark:hover:bg-blue-900/30 transition-colors">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    Select All
                                </button>
                                <button type="button" id="clear-all" 
                                        class="inline-flex items-center px-4 py-2 text-sm font-medium text-red-600 bg-red-50 border border-red-200 rounded-lg hover:bg-red-100 dark:bg-red-900/20 dark:border-red-800 dark:text-red-400 dark:hover:bg-red-900/30 transition-colors">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                    </svg>
                                    Clear All
                                </button>
                            </div>
                            
                            <div class="flex flex-col sm:flex-row gap-3">
                                <button type="button" id="refresh-filters" 
                                        class="inline-flex items-center px-4 py-2 text-sm font-medium text-blue-600 bg-blue-50 border border-blue-200 rounded-lg hover:bg-blue-100 dark:bg-blue-900/20 dark:border-blue-800 dark:text-blue-400 dark:hover:bg-blue-900/30 transition-colors">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                                    </svg>
                                    Refresh
                                </button>
                                <button type="button" id="clear-filters" 
                                        class="inline-flex items-center px-4 py-2 text-sm font-medium text-red-600 bg-red-50 border border-red-200 rounded-lg hover:bg-red-100 dark:bg-red-900/20 dark:border-red-800 dark:text-red-400 dark:hover:bg-red-900/30 transition-colors">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                    </svg>
                                    Clear Filters
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Questions List -->
                    @if($questions->count() > 0)
                        <div class="px-4 py-4 border-t border-gray-200 dark:border-gray-700">
                            <div class="grid grid-cols-1 gap-2">
                            @foreach($questions as $question)
                                    <div class="question-card group bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-600 rounded-md p-3 hover:shadow-sm transition-all duration-200 draggable-question"
                                     data-type="{{ $question->question_type }}"
                                     data-course="{{ $question->course->id ?? '' }}"
                                     data-subject="{{ $question->subject->name ?? '' }}"
                                     data-topic="{{ $question->topic->name ?? '' }}"
                                     data-question-id="{{ $question->id }}"
                                     draggable="true">
                                    
                                    <!-- Mobile Layout -->
                                    <div class="block sm:hidden">
                                        <!-- Top Row: Checkbox, Question Number, Type Badge, Drag Handle -->
                                        <div class="mobile-controls">
                                            <div class="mobile-controls-left">
                                                <input type="checkbox" name="question_ids[]" value="{{ $question->id }}" 
                                                       class="question-checkbox mobile-touch-target h-5 w-5 text-blue-600 focus:ring-blue-500 border-gray-300 rounded transition-all duration-200"
                                                       {{ $assignedQuestions->contains($question->id) ? 'checked' : '' }}>
                                                
                                                <div class="flex items-center space-x-1 question-number-container">
                                                    <label class="text-xs text-green-600 dark:text-green-400 font-semibold">Q#:</label>
                                                    <input type="number" 
                                                           name="question_numbers[{{ $question->id }}]" 
                                                           value="{{ $assignedQuestionsWithOrder[$question->id] ?? '' }}" 
                                                           min="1" 
                                                           max="999" 
                                                           class="question-number mobile-input w-12 border border-green-400 rounded bg-gray-100 dark:bg-gray-600 dark:border-green-500 dark:text-white font-semibold text-center"
                                                           style="-moz-appearance: textfield; -webkit-appearance: none; appearance: none;"
                                                           readonly>
                                                </div>
                                                
                                                <span class="mobile-badge
                                                    {{ $question->question_type === 'mcq' ? 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200' : 
                                                       ($question->question_type === 'descriptive' ? 'bg-purple-100 text-purple-800 dark:bg-purple-900 dark:text-purple-200' : 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200') }}">
                                                    {{ strtoupper($question->question_type) }}
                                                </span>
                                            </div>
                                            
                                            <div class="mobile-controls-right">
                                                <!-- Marks Input -->
                                                <div class="flex items-center space-x-1 question-marks-container">
                                                    <label class="text-xs text-blue-600 dark:text-blue-400 font-semibold">Marks:</label>
                                                    <input type="number" 
                                                           name="question_marks[{{ $question->id }}]" 
                                                           value="{{ $assignedQuestionsWithMarks[$question->id] ?? 1 }}" 
                                                           min="1" 
                                                           max="100" 
                                                           class="question-marks mobile-input w-14 border border-blue-400 rounded bg-gray-100 dark:bg-gray-600 dark:border-blue-500 dark:text-white font-semibold text-center"
                                                           style="-moz-appearance: textfield; -webkit-appearance: none; appearance: none;">
                                                </div>
                                                
                                                <!-- Drag Handle -->
                                                <div class="drag-handle mobile-drag-handle mobile-touch-target text-gray-400 hover:text-gray-600 dark:text-gray-500 dark:hover:text-gray-300 cursor-move transition-colors">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8h16M4 16h16"></path>
                                                    </svg>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <!-- Question Text -->
                                        <div class="mb-3">
                                            <div class="mobile-question-text text-gray-900 dark:text-white font-medium">
                                                {{ Str::limit($question->question_text, 120) }}
                                            </div>
                                        </div>
                                        
                                        <!-- Answer Options (Mobile) -->
                                        @if($question->question_type === 'mcq' || $question->question_type === 'true_false')
                                            <div class="mb-3">
                                                <div class="text-xs text-gray-600 dark:text-gray-400 font-medium mb-2">Answer Options:</div>
                                                <div class="mobile-answer-grid">
                                                    @if($question->option_a)
                                                        <div class="mobile-answer-option">
                                                            <div class="flex items-center space-x-2">
                                                                <span class="compact-answer-option bg-blue-100 dark:bg-blue-900 text-blue-800 dark:text-blue-200 font-bold rounded-full flex items-center justify-center {{ $question->correct_answer === 'a' ? 'bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-200' : '' }}">{{ $question->correct_answer === 'a' ? '✓' : 'A' }}</span>
                                                                <span class="text-xs text-gray-700 dark:text-gray-300 flex-1">{{ Str::limit($question->option_a, 40) }}</span>
                                                            </div>
                                                        </div>
                                                    @endif
                                                    @if($question->option_b)
                                                        <div class="mobile-answer-option">
                                                            <div class="flex items-center space-x-2">
                                                                <span class="compact-answer-option bg-blue-100 dark:bg-blue-900 text-blue-800 dark:text-blue-200 font-bold rounded-full flex items-center justify-center {{ $question->correct_answer === 'b' ? 'bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-200' : '' }}">{{ $question->correct_answer === 'b' ? '✓' : 'B' }}</span>
                                                                <span class="text-xs text-gray-700 dark:text-gray-300 flex-1">{{ Str::limit($question->option_b, 40) }}</span>
                                                            </div>
                                                        </div>
                                                    @endif
                                                    @if($question->option_c)
                                                        <div class="mobile-answer-option">
                                                            <div class="flex items-center space-x-2">
                                                                <span class="compact-answer-option bg-blue-100 dark:bg-blue-900 text-blue-800 dark:text-blue-200 font-bold rounded-full flex items-center justify-center {{ $question->correct_answer === 'c' ? 'bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-200' : '' }}">{{ $question->correct_answer === 'c' ? '✓' : 'C' }}</span>
                                                                <span class="text-xs text-gray-700 dark:text-gray-300 flex-1">{{ Str::limit($question->option_c, 40) }}</span>
                                                            </div>
                                                        </div>
                                                    @endif
                                                    @if($question->option_d)
                                                        <div class="mobile-answer-option">
                                                            <div class="flex items-center space-x-2">
                                                                <span class="compact-answer-option bg-blue-100 dark:bg-blue-900 text-blue-800 dark:text-blue-200 font-bold rounded-full flex items-center justify-center {{ $question->correct_answer === 'd' ? 'bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-200' : '' }}">{{ $question->correct_answer === 'd' ? '✓' : 'D' }}</span>
                                                                <span class="text-xs text-gray-700 dark:text-gray-300 flex-1">{{ Str::limit($question->option_d, 40) }}</span>
                                                            </div>
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                        @endif
                                        
                                        <!-- Tags Row -->
                                        <div class="mobile-tags">
                                            <span class="mobile-tag">
                                                {{ $question->course->name ?? 'N/A' }}
                                            </span>
                                            <span class="mobile-tag">
                                                {{ $question->subject->name ?? 'N/A' }}
                                            </span>
                                            <span class="mobile-tag">
                                                {{ $question->topic->name ?? 'N/A' }}
                                            </span>
                                        </div>
                                    </div>
                                    
                                    <!-- Desktop Layout -->
                                    <div class="hidden sm:flex items-center gap-3">
                                        <!-- Checkbox -->
                                        <input type="checkbox" name="question_ids[]" value="{{ $question->id }}" 
                                               class="question-checkbox h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded transition-all duration-200"
                                               {{ $assignedQuestions->contains($question->id) ? 'checked' : '' }}>
                                        
                                        <!-- Question Number -->
                                        <div class="flex items-center space-x-1 question-number-container">
                                            <label class="text-xs text-green-600 dark:text-green-400 font-semibold">Q#:</label>
                                            <input type="number" 
                                                   name="question_numbers[{{ $question->id }}]" 
                                                   value="{{ $assignedQuestionsWithOrder[$question->id] ?? '' }}" 
                                                   min="1" 
                                                   max="999" 
                                                   class="question-number slim-input w-10 border border-green-400 rounded bg-gray-100 dark:bg-gray-600 dark:border-green-500 dark:text-white font-semibold text-center"
                                                   style="-moz-appearance: textfield; -webkit-appearance: none; appearance: none;"
                                                   readonly>
                                        </div>
                                        
                                        <!-- Question Type Badge -->
                                        <span class="compact-badge
                                            {{ $question->question_type === 'mcq' ? 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200' : 
                                               ($question->question_type === 'descriptive' ? 'bg-purple-100 text-purple-800 dark:bg-purple-900 dark:text-purple-200' : 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200') }}">
                                            {{ strtoupper($question->question_type) }}
                                        </span>
                                        
                                        <!-- Question Text -->
                                        <div class="flex-1 min-w-0">
                                            <div class="text-sm text-gray-900 dark:text-white font-medium question-text-slim">
                                                {{ Str::limit($question->question_text, 80) }}
                                            </div>
                                            <div class="tags-slim mt-1">
                                                {{ $question->course->name ?? 'N/A' }} • {{ $question->subject->name ?? 'N/A' }} • {{ $question->topic->name ?? 'N/A' }}
                                            </div>
                                        </div>
                                        
                                        <!-- Answer Options (Compact) -->
                                        @if($question->question_type === 'mcq' || $question->question_type === 'true_false')
                                            <div class="flex-shrink-0">
                                                <div class="flex items-center gap-1">
                                                    @if($question->option_a)
                                                        <span class="compact-answer-option bg-blue-100 dark:bg-blue-900 text-blue-800 dark:text-blue-200 font-bold rounded-full flex items-center justify-center {{ $question->correct_answer === 'a' ? 'bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-200' : '' }}">{{ $question->correct_answer === 'a' ? '✓' : 'A' }}</span>
                                                    @endif
                                                    @if($question->option_b)
                                                        <span class="compact-answer-option bg-blue-100 dark:bg-blue-900 text-blue-800 dark:text-blue-200 font-bold rounded-full flex items-center justify-center {{ $question->correct_answer === 'b' ? 'bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-200' : '' }}">{{ $question->correct_answer === 'b' ? '✓' : 'B' }}</span>
                                                    @endif
                                                    @if($question->option_c)
                                                        <span class="compact-answer-option bg-blue-100 dark:bg-blue-900 text-blue-800 dark:text-blue-200 font-bold rounded-full flex items-center justify-center {{ $question->correct_answer === 'c' ? 'bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-200' : '' }}">{{ $question->correct_answer === 'c' ? '✓' : 'C' }}</span>
                                                    @endif
                                                    @if($question->option_d)
                                                        <span class="compact-answer-option bg-blue-100 dark:bg-blue-900 text-blue-800 dark:text-blue-200 font-bold rounded-full flex items-center justify-center {{ $question->correct_answer === 'd' ? 'bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-200' : '' }}">{{ $question->correct_answer === 'd' ? '✓' : 'D' }}</span>
                                                    @endif
                                                </div>
                                            </div>
                                        @endif
                                        
                                        <!-- Marks Input -->
                                        <div class="flex items-center space-x-1 question-marks-container">
                                            <label class="text-xs text-blue-600 dark:text-blue-400 font-semibold">Marks:</label>
                                            <input type="number" 
                                                   name="question_marks[{{ $question->id }}]" 
                                                   value="{{ $assignedQuestionsWithMarks[$question->id] ?? 1 }}" 
                                                   min="1" 
                                                   max="100" 
                                                   class="question-marks slim-input w-12 border border-blue-400 rounded bg-gray-100 dark:bg-gray-600 dark:border-blue-500 dark:text-white font-semibold text-center"
                                                   style="-moz-appearance: textfield; -webkit-appearance: none; appearance: none;">
                                        </div>
                                        
                                        <!-- Drag Handle -->
                                        <div class="drag-handle text-gray-400 hover:text-gray-600 dark:text-gray-500 dark:hover:text-gray-300 cursor-move p-1 rounded hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8h16M4 16h16"></path>
                                            </svg>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-16">
                            <div class="mx-auto w-24 h-24 bg-gray-100 dark:bg-gray-700 rounded-full flex items-center justify-center mb-6">
                                <svg class="h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                            </svg>
                            </div>
                            <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-2">No questions available</h3>
                            <p class="text-gray-500 dark:text-gray-400 mb-8 max-w-md mx-auto">
                                Create some questions first before assigning them to exams.
                            </p>
                            <div class="flex flex-col sm:flex-row gap-3 sm:justify-center">
                                <a href="{{ route('partner.questions.create') }}" 
                                   class="inline-flex items-center px-6 py-3 border border-transparent shadow-sm text-sm font-medium rounded-lg text-white bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all duration-200">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                                    </svg>
                                    Create Question
                                </a>
                                <a href="{{ route('partner.questions.all') }}" 
                                   class="inline-flex items-center px-6 py-3 border border-gray-300 shadow-sm text-sm font-medium rounded-lg text-gray-700 bg-white hover:bg-gray-50 dark:bg-gray-800 dark:border-gray-600 dark:text-gray-300 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all duration-200">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"/>
                                    </svg>
                                    View All Questions
                                </a>
                            </div>
                        </div>
                    @endif
                </div>

            </form>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
/* Professional Mobile-First Design */

/* Stats Card Styling */
.stats-card {
    background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%);
    border: 1px solid #e2e8f0;
    box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06);
    transition: all 0.3s ease;
}

.stats-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
}

.dark .stats-card {
    background: linear-gradient(135deg, #1f2937 0%, #111827 100%);
    border: 1px solid #374151;
    box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.3), 0 1px 2px 0 rgba(0, 0, 0, 0.2);
}

.dark .stats-card:hover {
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.3), 0 2px 4px -1px rgba(0, 0, 0, 0.2);
}

/* Enhanced Search Bar Styling */
.search-container {
    position: relative;
    background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
    border-radius: 16px;
    padding: 4px;
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}

.search-container:focus-within {
    background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%);
    box-shadow: 0 10px 25px -5px rgba(59, 130, 246, 0.1), 0 10px 10px -5px rgba(59, 130, 246, 0.04);
    transform: translateY(-1px);
}

.dark .search-container {
    background: linear-gradient(135deg, #374151 0%, #1f2937 100%);
}

.dark .search-container:focus-within {
    background: linear-gradient(135deg, #4b5563 0%, #374151 100%);
    box-shadow: 0 10px 25px -5px rgba(59, 130, 246, 0.2), 0 10px 10px -5px rgba(59, 130, 246, 0.1);
}

.search-input {
    background: rgba(255, 255, 255, 0.9);
    backdrop-filter: blur(10px);
    border: 2px solid transparent;
    border-radius: 12px;
    padding: 12px 48px 12px 48px;
    font-size: 14px;
    font-weight: 500;
    color: #1f2937;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    box-shadow: inset 0 1px 3px rgba(0, 0, 0, 0.1);
}

.search-input:focus {
    background: rgba(255, 255, 255, 1);
    border-color: #3b82f6;
    box-shadow: inset 0 1px 3px rgba(0, 0, 0, 0.1), 0 0 0 3px rgba(59, 130, 246, 0.1);
    outline: none;
}

.dark .search-input {
    background: rgba(31, 41, 55, 0.9);
    color: #f9fafb;
}

.dark .search-input:focus {
    background: rgba(31, 41, 55, 1);
    border-color: #60a5fa;
    box-shadow: inset 0 1px 3px rgba(0, 0, 0, 0.3), 0 0 0 3px rgba(96, 165, 250, 0.1);
}

.search-input::placeholder {
    color: #9ca3af;
    font-weight: 400;
    transition: color 0.3s ease;
}

.search-input:focus::placeholder {
    color: #6b7280;
}

.dark .search-input::placeholder {
    color: #6b7280;
}

.dark .search-input:focus::placeholder {
    color: #9ca3af;
}

/* Search Icon Styling */
.search-icon {
    color: #9ca3af;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    transform: scale(1);
}

.search-container:focus-within .search-icon {
    color: #3b82f6;
    transform: scale(1.1);
}

.dark .search-icon {
    color: #6b7280;
}

.dark .search-container:focus-within .search-icon {
    color: #60a5fa;
}

/* Clear Button Styling */
.clear-button {
    background: rgba(239, 68, 68, 0.1);
    border: 1px solid rgba(239, 68, 68, 0.2);
    border-radius: 8px;
    padding: 6px;
    color: #ef4444;
    transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
    opacity: 0;
    transform: scale(0.8);
}

.clear-button:hover {
    background: rgba(239, 68, 68, 0.2);
    border-color: rgba(239, 68, 68, 0.3);
    transform: scale(1);
    color: #dc2626;
}

.clear-button.show {
    opacity: 1;
    transform: scale(1);
}

.dark .clear-button {
    background: rgba(239, 68, 68, 0.2);
    border-color: rgba(239, 68, 68, 0.3);
    color: #f87171;
}

.dark .clear-button:hover {
    background: rgba(239, 68, 68, 0.3);
    border-color: rgba(239, 68, 68, 0.4);
    color: #fca5a5;
}

/* Loading Spinner Styling */
.search-loading {
    animation: spin 1s linear infinite;
    color: #3b82f6;
    opacity: 0;
    transform: scale(0.8);
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}

.search-loading.show {
    opacity: 1;
    transform: scale(1);
}

@keyframes spin {
    from { transform: rotate(0deg); }
    to { transform: rotate(360deg); }
}

/* Search Results Info Styling */
.search-results-info {
    background: linear-gradient(135deg, #eff6ff 0%, #dbeafe 100%);
    border: 1px solid #bfdbfe;
    border-radius: 8px;
    padding: 8px 16px;
    margin-top: 8px;
    font-size: 13px;
    font-weight: 500;
    color: #1e40af;
    opacity: 0;
    transform: translateY(-10px);
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}

.search-results-info.show {
    opacity: 1;
    transform: translateY(0);
}

.dark .search-results-info {
    background: linear-gradient(135deg, #1e3a8a 0%, #1e40af 100%);
    border-color: #3b82f6;
    color: #dbeafe;
}

/* Question Selection Limit Styling */
.question-limit-container {
    transition: all 0.3s ease-in-out;
}

/* Selection Counter Styling */
#selected-count {
    font-weight: 700;
    transition: color 0.3s ease;
}

#total-allowed {
    font-weight: 600;
    color: #6b7280;
}

/* Remaining Count Styling */
#remaining-count {
    transition: all 0.3s ease;
    font-weight: 600;
    padding: 2px 8px;
    border-radius: 12px;
    background-color: rgba(34, 197, 94, 0.1);
}

#remaining-count.warning {
    background-color: rgba(245, 158, 11, 0.1);
    animation: pulse-warning 2s infinite;
}

#remaining-count.danger {
    background-color: rgba(239, 68, 68, 0.1);
    animation: pulse-danger 1.5s infinite;
}

/* Warning Banner Styling */
#limit-warning {
    transition: all 0.3s ease-in-out;
    animation: slideDown 0.3s ease-out;
}

#limit-warning.show {
    transform: translateY(0);
    opacity: 1;
}

/* Question Card Styling */
.question-card {
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    border: 2px solid transparent;
    cursor: move;
    position: relative;
    background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%);
    backdrop-filter: blur(10px);
}

.dark .question-card {
    background: linear-gradient(135deg, #1f2937 0%, #111827 100%);
}

.question-card.dragging {
    opacity: 0.9;
    transform: scale(1.05) rotate(2deg);
    z-index: 1000;
    box-shadow: 0 20px 40px rgba(0, 0, 0, 0.2);
    transition: none;
    border-color: #3b82f6;
}

.question-card.drag-over {
    border-color: #22c55e;
    background: linear-gradient(135deg, rgba(34, 197, 94, 0.1) 0%, rgba(16, 185, 129, 0.05) 100%);
    transform: scale(1.02);
    box-shadow: 0 8px 25px rgba(34, 197, 94, 0.2);
}

.question-card.disabled {
    opacity: 0.5;
    cursor: not-allowed;
    background-color: #f3f4f6;
}

.question-card:hover:not(.disabled):not(.dragging) {
    transform: translateY(-2px);
    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
    border-color: #3b82f6;
    background: linear-gradient(135deg, rgba(59, 130, 246, 0.05) 0%, rgba(99, 102, 241, 0.05) 100%);
}

.dark .question-card:hover:not(.disabled):not(.dragging) {
    background: linear-gradient(135deg, rgba(59, 130, 246, 0.1) 0%, rgba(99, 102, 241, 0.1) 100%);
}

.question-card:hover:not(.disabled):not(.dragging) .question-number-container {
    background: linear-gradient(135deg, rgba(34, 197, 94, 0.1) 0%, rgba(16, 185, 129, 0.05) 100%);
    border-radius: 8px;
    padding: 4px;
    transform: scale(1.05);
}

.question-card:hover:not(.disabled):not(.dragging) .question-marks-container {
    background: linear-gradient(135deg, rgba(59, 130, 246, 0.1) 0%, rgba(99, 102, 241, 0.05) 100%);
    border-radius: 8px;
    padding: 4px;
    transform: scale(1.05);
}

/* Drop indicator styling */
.drop-indicator {
    height: 3px;
    background: linear-gradient(90deg, #22c55e, #16a34a);
    border-radius: 2px;
    margin: 8px 0;
    opacity: 0;
    transform: scaleX(0);
    transition: all 0.2s ease;
    box-shadow: 0 2px 8px rgba(34, 197, 94, 0.3);
}

.drop-indicator.show {
    opacity: 1;
    transform: scaleX(1);
}

.drop-indicator::before {
    content: '';
    position: absolute;
    left: 50%;
    top: -4px;
    transform: translateX(-50%);
    width: 0;
    height: 0;
    border-left: 6px solid transparent;
    border-right: 6px solid transparent;
    border-bottom: 6px solid #22c55e;
}

.drop-indicator::after {
    content: '';
    position: absolute;
    left: 50%;
    bottom: -4px;
    transform: translateX(-50%);
    width: 0;
    height: 0;
    border-left: 6px solid transparent;
    border-right: 6px solid transparent;
    border-top: 6px solid #22c55e;
}

.question-card:hover:not(.disabled):not(.dragging) {
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
    border-color: #3b82f6;
    background-color: rgba(59, 130, 246, 0.02);
}

.question-card:hover:not(.disabled):not(.dragging) .question-number-container {
    background-color: rgba(34, 197, 94, 0.05);
    border-radius: 6px;
    padding: 2px;
}

.question-card:hover:not(.disabled):not(.dragging) .question-marks-container {
    background-color: rgba(59, 130, 246, 0.05);
    border-radius: 6px;
    padding: 2px;
}

.question-card.disabled {
    opacity: 0.5;
    cursor: not-allowed;
    background-color: #f9fafb;
    border-color: #e5e7eb;
}

.question-card.disabled:hover {
    transform: none;
    box-shadow: none;
    border-color: #e5e7eb;
}

.question-card.selected {
    border-color: #10b981;
    background-color: rgba(16, 185, 129, 0.05);
}

.question-card.selected:hover {
    border-color: #059669;
    background-color: rgba(16, 185, 129, 0.1);
}

/* Checkbox Styling */
.question-checkbox {
    transition: all 0.2s ease;
}

.question-checkbox:disabled {
    cursor: not-allowed;
    opacity: 0.5;
}

.question-checkbox:checked {
    transform: scale(1.1);
}

/* Button Styling */
#select-all {
    transition: all 0.3s ease;
    position: relative;
    overflow: hidden;
}

#select-all:disabled {
    cursor: not-allowed;
    opacity: 0.6;
}

#select-all:not(:disabled):hover {
    transform: translateY(-1px);
    box-shadow: 0 2px 4px rgba(59, 130, 246, 0.3);
}

#clear-all {
    transition: all 0.3s ease;
}

#clear-all:hover {
    transform: translateY(-1px);
    box-shadow: 0 2px 4px rgba(239, 68, 68, 0.3);
}

/* Enhanced Progress Bar Styling */
.selection-progress {
    height: 4px;
    background-color: #e5e7eb;
    border-radius: 2px;
    overflow: hidden;
    margin-top: 8px;
}

.selection-progress-bar {
    height: 100%;
    background: linear-gradient(90deg, #10b981, #3b82f6);
    border-radius: 2px;
    transition: width 0.3s ease;
}

.selection-progress-bar.warning {
    background: linear-gradient(90deg, #f59e0b, #f97316);
}

.selection-progress-bar.danger {
    background: linear-gradient(90deg, #ef4444, #dc2626);
    animation: pulse-progress 1s infinite;
}

/* Enhanced Progress Bar Container */
.progress-container {
    position: relative;
    background: linear-gradient(135deg, #f1f5f9 0%, #e2e8f0 100%);
    border-radius: 12px;
    padding: 8px;
    box-shadow: inset 0 2px 4px rgba(0, 0, 0, 0.1);
}

.dark .progress-container {
    background: linear-gradient(135deg, #374151 0%, #1f2937 100%);
}

#progress-bar {
    position: relative;
    background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 50%, #7c3aed 100%);
    border-radius: 8px;
    transition: all 0.7s cubic-bezier(0.4, 0, 0.2, 1);
    box-shadow: 0 2px 8px rgba(59, 130, 246, 0.3);
    overflow: hidden;
}

#progress-bar::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.4), transparent);
    animation: shimmer 2s infinite;
}

@keyframes shimmer {
    0% { left: -100%; }
    100% { left: 100%; }
}

#progress-dot {
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    box-shadow: 0 0 8px rgba(255, 255, 255, 0.5);
}

#progress-dot.show {
    opacity: 1;
    transform: scale(1.2);
}

.progress-percentage {
    font-weight: 600;
    background: linear-gradient(135deg, #3b82f6, #1d4ed8);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}

.dark .progress-percentage {
    background: linear-gradient(135deg, #60a5fa, #3b82f6);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}

/* Progress Bar States */
.progress-bar-warning {
    background: linear-gradient(135deg, #f59e0b 0%, #d97706 50%, #b45309 100%);
    box-shadow: 0 2px 8px rgba(245, 158, 11, 0.3);
}

.progress-bar-danger {
    background: linear-gradient(135deg, #ef4444 0%, #dc2626 50%, #b91c1c 100%);
    box-shadow: 0 2px 8px rgba(239, 68, 68, 0.3);
}

.progress-bar-success {
    background: linear-gradient(135deg, #10b981 0%, #059669 50%, #047857 100%);
    box-shadow: 0 2px 8px rgba(16, 185, 129, 0.3);
}

/* Progress Bar Animations */
@keyframes progressPulse {
    0%, 100% { 
        box-shadow: 0 2px 8px rgba(59, 130, 246, 0.3);
    }
    50% { 
        box-shadow: 0 4px 16px rgba(59, 130, 246, 0.5);
    }
}

.progress-bar-pulse {
    animation: progressPulse 2s infinite;
}

/* Progress Bar Glow Effect */
.progress-glow {
    position: relative;
}

.progress-glow::after {
    content: '';
    position: absolute;
    top: -2px;
    left: -2px;
    right: -2px;
    bottom: -2px;
    background: linear-gradient(135deg, #3b82f6, #1d4ed8, #7c3aed);
    border-radius: 10px;
    z-index: -1;
    opacity: 0;
    transition: opacity 0.3s ease;
}

.progress-glow.active::after {
    opacity: 0.3;
}

/* Answer Options Styling */
.answer-options {
    background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
    border: 1px solid #e2e8f0;
    border-radius: 8px;
    padding: 8px;
    transition: all 0.2s ease;
}

.dark .answer-options {
    background: linear-gradient(135deg, #374151 0%, #1f2937 100%);
    border-color: #4b5563;
}

.answer-option {
    display: flex;
    align-items: center;
    gap: 8px;
    padding: 4px 6px;
    border-radius: 6px;
    transition: all 0.2s ease;
    background: rgba(255, 255, 255, 0.5);
}

.dark .answer-option {
    background: rgba(31, 41, 55, 0.5);
}

.answer-option:hover {
    background: rgba(59, 130, 246, 0.1);
    transform: translateX(2px);
}

.dark .answer-option:hover {
    background: rgba(59, 130, 246, 0.2);
}

.answer-option-letter {
    width: 20px;
    height: 20px;
    background: linear-gradient(135deg, #3b82f6, #1d4ed8);
    color: white;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 10px;
    font-weight: bold;
    flex-shrink: 0;
    box-shadow: 0 2px 4px rgba(59, 130, 246, 0.3);
}

.answer-option-letter.correct {
    background: linear-gradient(135deg, #10b981, #059669);
    box-shadow: 0 2px 4px rgba(16, 185, 129, 0.3);
}

.dark .answer-option-letter {
    background: linear-gradient(135deg, #60a5fa, #3b82f6);
}

.dark .answer-option-letter.correct {
    background: linear-gradient(135deg, #34d399, #10b981);
}

.answer-option-text {
    font-size: 11px;
    line-height: 1.3;
    color: #374151;
    flex: 1;
    min-width: 0;
}

.dark .answer-option-text {
    color: #d1d5db;
}

/* Slim Question Card Styling */
.question-card {
    transition: all 0.2s ease;
    border-left: 3px solid transparent;
}

.question-card:hover {
    border-left-color: #3b82f6;
    transform: translateX(2px);
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
}

.dark .question-card:hover {
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.3);
}

.question-card.dragging {
    opacity: 0.5;
    transform: rotate(2deg);
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
}

/* Compact Answer Options */
.compact-answer-option {
    width: 20px;
    height: 20px;
    font-size: 10px;
    transition: all 0.2s ease;
}

.compact-answer-option:hover {
    transform: scale(1.1);
}

/* Slim Input Styling */
.slim-input {
    font-size: 11px;
    padding: 2px 4px;
    border-width: 1px;
    transition: all 0.2s ease;
}

.slim-input:focus {
    transform: scale(1.05);
    box-shadow: 0 0 0 2px rgba(59, 130, 246, 0.2);
}

/* Compact Badge Styling */
.compact-badge {
    font-size: 10px;
    padding: 2px 6px;
    border-radius: 6px;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

/* Question Text Truncation */
.question-text-slim {
    line-height: 1.3;
    max-height: 2.6em;
    overflow: hidden;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
}

/* Auto-Sort Animation */
.question-card {
    transition: all 0.3s ease;
}

.question-card.sorting {
    transform: scale(1.02);
    box-shadow: 0 4px 12px rgba(59, 130, 246, 0.3);
    border-left-color: #3b82f6;
}

.question-card.newly-selected {
    animation: highlightNew 0.6s ease-out;
}

@keyframes highlightNew {
    0% {
        background-color: rgba(59, 130, 246, 0.1);
        transform: scale(1.05);
    }
    50% {
        background-color: rgba(59, 130, 246, 0.2);
        transform: scale(1.02);
    }
    100% {
        background-color: transparent;
        transform: scale(1);
    }
}

/* Tags in Single Line */
.tags-slim {
    font-size: 10px;
    color: #6b7280;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

.dark .tags-slim {
    color: #9ca3af;
}

/* Mobile-Specific Styling */
@media (max-width: 640px) {
    .question-card {
        padding: 12px;
        margin-bottom: 8px;
    }
    
    .question-card:hover {
        transform: none;
        border-left-color: #3b82f6;
    }
    
    /* Mobile Answer Options Grid */
    .mobile-answer-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 8px;
    }
    
    .mobile-answer-option {
        background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
        border: 1px solid #e2e8f0;
        border-radius: 8px;
        padding: 8px;
        transition: all 0.2s ease;
    }
    
    .dark .mobile-answer-option {
        background: linear-gradient(135deg, #374151 0%, #1f2937 100%);
        border-color: #4b5563;
    }
    
    .mobile-answer-option:hover {
        background: rgba(59, 130, 246, 0.1);
        transform: translateY(-1px);
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }
    
    .dark .mobile-answer-option:hover {
        background: rgba(59, 130, 246, 0.2);
    }
    
    /* Mobile Touch Targets */
    .mobile-touch-target {
        min-height: 44px;
        min-width: 44px;
    }
    
    /* Mobile Question Text */
    .mobile-question-text {
        font-size: 14px;
        line-height: 1.4;
        margin-bottom: 12px;
    }
    
    /* Mobile Tags */
    .mobile-tags {
        display: flex;
        flex-wrap: wrap;
        gap: 4px;
        margin-top: 8px;
    }
    
    .mobile-tag {
        font-size: 10px;
        padding: 4px 8px;
        border-radius: 6px;
        background: #f3f4f6;
        color: #6b7280;
        font-weight: 500;
    }
    
    .dark .mobile-tag {
        background: #374151;
        color: #9ca3af;
    }
    
    /* Mobile Controls Row */
    .mobile-controls {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 12px;
    }
    
    .mobile-controls-left {
        display: flex;
        align-items: center;
        gap: 8px;
    }
    
    .mobile-controls-right {
        display: flex;
        align-items: center;
        gap: 8px;
    }
    
    /* Mobile Input Sizing */
    .mobile-input {
        font-size: 12px;
        padding: 6px 8px;
        min-height: 32px;
    }
    
    /* Mobile Badge Sizing */
    .mobile-badge {
        font-size: 10px;
        padding: 4px 8px;
        border-radius: 6px;
        font-weight: 600;
    }
    
    /* Mobile Drag Handle */
    .mobile-drag-handle {
        padding: 8px;
        border-radius: 6px;
        background: #f9fafb;
        border: 1px solid #e5e7eb;
    }
    
    .dark .mobile-drag-handle {
        background: #374151;
        border-color: #4b5563;
    }
    
    .mobile-drag-handle:active {
        background: #e5e7eb;
        transform: scale(0.95);
    }
    
    .dark .mobile-drag-handle:active {
        background: #4b5563;
    }
}

/* Animations */
@keyframes pulse-warning {
    0%, 100% { opacity: 1; }
    50% { opacity: 0.7; }
}

@keyframes pulse-danger {
    0%, 100% { opacity: 1; }
    50% { opacity: 0.6; }
}

@keyframes pulse-progress {
    0%, 100% { opacity: 1; }
    50% { opacity: 0.8; }
}

@keyframes slideDown {
    from {
        opacity: 0;
        transform: translateY(-10px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

@keyframes shake {
    0%, 100% { transform: translateX(0); }
    25% { transform: translateX(-5px); }
    75% { transform: translateX(5px); }
}

.shake {
    animation: shake 0.5s ease-in-out;
}

/* Dark mode adjustments */
.dark .question-card.disabled {
    background-color: #374151;
    border-color: #4b5563;
}

.dark .selection-progress {
    background-color: #4b5563;
}

/* Mobile-first responsive design */
@media (max-width: 640px) {
    .question-card {
        margin-bottom: 1rem;
        border-radius: 1rem;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    }
    
    .question-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
    }
    
    .question-checkbox {
        transform: scale(1.2);
    }
    
    .question-number,
    .question-marks {
        font-size: 0.875rem;
        padding: 0.5rem;
    }
    
    .drag-handle {
        padding: 0.75rem;
        border-radius: 0.75rem;
    }
}

/* Enhanced Mobile Responsive Design */
@media (max-width: 768px) {
    .question-card:hover:not(.disabled) {
        transform: translateY(-1px);
    }
    
    .question-card:hover:not(.disabled) .question-number-container,
    .question-card:hover:not(.disabled) .question-marks-container {
        transform: scale(1.02);
    }
    
    #select-all:not(:disabled):hover,
    #clear-all:hover {
        transform: translateY(-1px);
    }
    
    .selection-progress {
        height: 8px;
        margin-top: 12px;
    }
    
    .selection-progress-bar {
        border-radius: 4px;
    }
}

@media (max-width: 640px) {
    .question-card {
        padding: 1rem;
        margin-bottom: 0.75rem;
    }
    
    .question-checkbox {
        transform: scale(1.3);
        margin-right: 0.5rem;
    }
    
    .question-number,
    .question-marks {
        font-size: 0.875rem;
        padding: 0.5rem 0.75rem;
        border-radius: 0.5rem;
    }
    
    .drag-handle {
        padding: 0.5rem;
        border-radius: 0.5rem;
        background: rgba(156, 163, 175, 0.1);
    }
    
    .question-card:hover .drag-handle {
        background: rgba(156, 163, 175, 0.2);
    }
}

/* Touch-friendly interactions */
@media (hover: none) and (pointer: coarse) {
    .question-card:hover {
        transform: none;
    }
    
    .question-card:active {
        transform: scale(0.98);
    }
    
    .question-checkbox:active {
        transform: scale(1.1);
    }
    
    .drag-handle:active {
        background: rgba(156, 163, 175, 0.3);
        transform: scale(1.1);
    }
}

/* Focus states for accessibility */
.question-checkbox:focus {
    outline: 2px solid #3b82f6;
    outline-offset: 2px;
}

#select-all:focus,
#clear-all:focus {
    outline: 2px solid #3b82f6;
    outline-offset: 2px;
}

/* Question number input styling */
.question-number {
    transition: all 0.3s ease;
    background: linear-gradient(135deg, #f0fdf4 0%, #dcfce7 100%);
    border: 2px solid #bbf7d0;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    font-weight: 600;
    color: #166534;
    text-align: center;
    cursor: default;
    /* Remove spinner arrows */
    -moz-appearance: textfield;
}

.question-number:read-only {
    background: linear-gradient(135deg, #f0fdf4 0%, #dcfce7 100%);
    color: #166534;
    cursor: default;
}

/* Mark input styling */
.question-marks {
    transition: all 0.3s ease;
    background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
    border: 2px solid #cbd5e1;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    font-weight: 600;
    color: #1e293b;
    text-align: center;
    /* Remove spinner arrows */
    -moz-appearance: textfield;
}

/* Remove spinner arrows for webkit browsers */
.question-number::-webkit-outer-spin-button,
.question-number::-webkit-inner-spin-button,
.question-marks::-webkit-outer-spin-button,
.question-marks::-webkit-inner-spin-button {
    -webkit-appearance: none;
    margin: 0;
    display: none;
}

/* Additional spinner removal for all browsers */
.question-number,
.question-marks {
    -moz-appearance: textfield !important;
    -webkit-appearance: none !important;
    appearance: none !important;
}

/* Ensure no spinner arrows in any browser */
.question-number::-webkit-outer-spin-button,
.question-number::-webkit-inner-spin-button,
.question-number::-ms-clear,
.question-number::-ms-reveal,
.question-marks::-webkit-outer-spin-button,
.question-marks::-webkit-inner-spin-button,
.question-marks::-ms-clear,
.question-marks::-ms-reveal {
    display: none !important;
    -webkit-appearance: none !important;
    -moz-appearance: none !important;
    appearance: none !important;
}

.question-number:hover {
    border-color: #22c55e;
    box-shadow: 0 4px 8px rgba(34, 197, 94, 0.2);
    transform: translateY(-1px);
    background: linear-gradient(135deg, #dcfce7 0%, #bbf7d0 100%);
}

.question-number:focus {
    outline: none;
    border-color: #22c55e;
    box-shadow: 0 0 0 3px rgba(34, 197, 94, 0.3), 0 4px 12px rgba(34, 197, 94, 0.2);
    transform: scale(1.1);
    background: linear-gradient(135deg, #bbf7d0 0%, #86efac 100%);
}

.question-marks:hover {
    border-color: #3b82f6;
    box-shadow: 0 4px 8px rgba(59, 130, 246, 0.2);
    transform: translateY(-1px);
    background: linear-gradient(135deg, #eff6ff 0%, #dbeafe 100%);
}

.question-marks:focus {
    outline: none;
    border-color: #3b82f6;
    box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.3), 0 4px 12px rgba(59, 130, 246, 0.2);
    transform: scale(1.1);
    background: linear-gradient(135deg, #dbeafe 0%, #bfdbfe 100%);
}

.question-number.border-red-500,
.question-marks.border-red-500 {
    border-color: #ef4444 !important;
    box-shadow: 0 0 0 3px rgba(239, 68, 68, 0.3), 0 4px 12px rgba(239, 68, 68, 0.2);
    background: linear-gradient(135deg, #fef2f2 0%, #fecaca 100%);
    animation: shake 0.5s ease-in-out;
}

/* Question number input container */
.question-number-container {
    transition: all 0.3s ease;
    position: relative;
}

/* Drag handle styling */
.drag-handle {
    transition: all 0.2s ease;
    opacity: 0.4;
    border-radius: 4px;
}

.question-card:hover .drag-handle {
    opacity: 0.8;
    background-color: rgba(156, 163, 175, 0.1);
}

.question-card.dragging .drag-handle {
    opacity: 1;
    background-color: rgba(156, 163, 175, 0.2);
}

.drag-handle:hover {
    opacity: 1 !important;
    background-color: rgba(156, 163, 175, 0.15) !important;
}

/* Mark input container */
.question-marks-container {
    transition: all 0.3s ease;
    position: relative;
}

.question-number-container::before {
    content: '';
    position: absolute;
    top: -2px;
    left: -2px;
    right: -2px;
    bottom: -2px;
    background: linear-gradient(45deg, #22c55e, #16a34a, #15803d, #166534);
    border-radius: 6px;
    opacity: 0;
    transition: opacity 0.3s ease;
    z-index: -1;
}

.question-marks-container::before {
    content: '';
    position: absolute;
    top: -2px;
    left: -2px;
    right: -2px;
    bottom: -2px;
    background: linear-gradient(45deg, #3b82f6, #8b5cf6, #06b6d4, #10b981);
    border-radius: 6px;
    opacity: 0;
    transition: opacity 0.3s ease;
    z-index: -1;
}

.question-card:hover .question-number-container::before {
    opacity: 0.3;
}

.question-card:hover .question-number-container {
    background-color: rgba(34, 197, 94, 0.05);
    border-radius: 6px;
    padding: 2px;
    transform: translateY(-1px);
}

.question-card:hover .question-marks-container::before {
    opacity: 0.3;
}

.question-card:hover .question-marks-container {
    background-color: rgba(59, 130, 246, 0.05);
    border-radius: 6px;
    padding: 2px;
    transform: translateY(-1px);
}

/* Question number label styling */
.question-number-container label {
    font-weight: 600;
    color: #166534;
    text-shadow: 0 1px 2px rgba(0, 0, 0, 0.1);
    transition: color 0.3s ease;
}

/* Mark label styling */
.question-marks-container label {
    font-weight: 600;
    color: #475569;
    text-shadow: 0 1px 2px rgba(0, 0, 0, 0.1);
    transition: color 0.3s ease;
}

.question-card:hover .question-number-container label {
    color: #22c55e;
}

.question-card:hover .question-marks-container label {
    color: #3b82f6;
}

/* Dark mode adjustments */
.dark .question-number {
    background: linear-gradient(135deg, #14532d 0%, #166534 100%);
    border-color: #22c55e;
    color: #f0fdf4;
}

.dark .question-number:read-only {
    background: linear-gradient(135deg, #14532d 0%, #166534 100%);
    color: #f0fdf4;
    cursor: default;
}

.dark .question-marks {
    background: linear-gradient(135deg, #374151 0%, #4b5563 100%);
    border-color: #6b7280;
    color: #f9fafb;
}

.dark .question-number:hover {
    background: linear-gradient(135deg, #166534 0%, #15803d 100%);
    border-color: #4ade80;
}

.dark .question-number:focus {
    background: linear-gradient(135deg, #15803d 0%, #16a34a 100%);
}

.dark .question-marks:hover {
    background: linear-gradient(135deg, #1e40af 0%, #3730a3 100%);
    border-color: #3b82f6;
}

.dark .question-marks:focus {
    background: linear-gradient(135deg, #1e3a8a 0%, #312e81 100%);
}

.dark .question-number-container label {
    color: #bbf7d0;
}

.dark .question-marks-container label {
    color: #d1d5db;
}

.dark .question-card:hover .question-number-container label {
    color: #4ade80;
}

.dark .question-card:hover .question-marks-container label {
    color: #60a5fa;
}
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Get filter elements
    const searchInput = document.getElementById('search');
    const searchHidden = document.getElementById('searchHidden');
    const filterForm = document.getElementById('filterForm');
    const questionsContainer = document.querySelector('.questions-container');
    
    const courseFilter = document.getElementById('course-filter');
    const subjectFilter = document.getElementById('subject-filter');
    const topicFilter = document.getElementById('topic-filter');
    const questionTypeFilter = document.getElementById('type-filter');
    const dateFilter = document.getElementById('date-filter');
    const clearAllFiltersBtn = document.getElementById('clear-filters');
    const refreshQuestionsBtn = document.getElementById('refresh-filters');
    
    if (!searchInput || !searchHidden || !filterForm) {
        console.error('Required elements not found');
        return;
    }
    
    // Load initial filter data
    loadFilterData();
    
    // Search functionality with debouncing
    let searchTimeout;
    searchInput.addEventListener('input', function() {
        clearTimeout(searchTimeout);
        searchHidden.value = this.value;
        
        searchTimeout = setTimeout(function() {
            performAjaxSearch();
        }, 300);
    });
    
    // Filter change handlers
    if (courseFilter) {
        courseFilter.addEventListener('change', function() {
            const courseId = this.value;
            console.log('Course filter changed to:', courseId);
            
            // Clear dependent filters
            if (subjectFilter) subjectFilter.value = '';
            if (topicFilter) topicFilter.value = '';
            
            // Update subjects for selected course
            updateSubjectsForCourse(courseId);
            
            // Trigger search
            performAjaxSearch();
        });
    }
    
    if (subjectFilter) {
        subjectFilter.addEventListener('change', function() {
            const subjectId = this.value;
            console.log('Subject filter changed to:', subjectId);
            
            // Clear dependent filters
            if (topicFilter) topicFilter.value = '';
            
            // Update topics for selected subject
            updateTopicsForSubject(subjectId);
            
            // Trigger search
            performAjaxSearch();
        });
    }
    
    if (topicFilter) {
        topicFilter.addEventListener('change', function() {
            console.log('Topic filter changed to:', this.value);
            performAjaxSearch();
        });
    }
    
    if (questionTypeFilter) {
        questionTypeFilter.addEventListener('change', function() {
            console.log('Question type filter changed to:', this.value);
            performAjaxSearch();
        });
    }
    
    // Date filter event handlers
    if (dateFilter) {
        dateFilter.addEventListener('change', function() {
            console.log('Date filter CHANGE event triggered, value:', this.value);
            console.log('Triggering AJAX search from change event...');
            performAjaxSearchWithDate(this.value);
        });
        
        // Also add input event for immediate feedback
        dateFilter.addEventListener('input', function() {
            console.log('Date filter INPUT event triggered, value:', this.value);
        });
    }
    
    if (clearAllFiltersBtn) {
        clearAllFiltersBtn.addEventListener('click', function() {
            console.log('Clear all filters clicked');
            
            // Clear all filter values
            if (courseFilter) courseFilter.value = '';
            if (subjectFilter) subjectFilter.value = '';
            if (topicFilter) topicFilter.value = '';
            if (questionTypeFilter) questionTypeFilter.value = '';
            if (dateFilter) dateFilter.value = '';
            if (searchInput) searchInput.value = '';
            if (searchHidden) searchHidden.value = '';
            
            // Update subjects and topics for no course selection
            updateSubjectsForCourse('');
            updateTopicsForSubject('');
            
            // Trigger search
            performAjaxSearch();
        });
    }
    
    // Refresh questions functionality
    if (refreshQuestionsBtn) {
        refreshQuestionsBtn.addEventListener('click', function() {
            console.log('Refresh questions clicked');
            
            // Add loading state
            const button = this;
            const originalText = button.innerHTML;
            button.innerHTML = '<svg class="w-4 h-4 animate-spin" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg> Refreshing...';
            button.disabled = true;
            
            // Reload the page
            window.location.reload();
        });
    }
    
    // AJAX Search Function
    function performAjaxSearchWithDate(selectedDate) {
        const searchValue = searchInput.value;
        const currentUrl = new URL(window.location);
        
        // Add updating class to questions container
        if (questionsContainer) {
            questionsContainer.classList.add('updating');
        }
        
        // Update URL parameters
        if (searchValue) {
            currentUrl.searchParams.set('search', searchValue);
        } else {
            currentUrl.searchParams.delete('search');
        }
        
        // Handle filter parameters
        const courseFilterValue = courseFilter ? courseFilter.value : '';
        const subjectFilterValue = subjectFilter ? subjectFilter.value : '';
        const topicFilterValue = topicFilter ? topicFilter.value : '';
        const questionTypeFilterValue = questionTypeFilter ? questionTypeFilter.value : '';
        const dateFilterValue = selectedDate || '';
        
        console.log('Filter values:', {
            course: courseFilterValue,
            subject: subjectFilterValue,
            topic: topicFilterValue,
            questionType: questionTypeFilterValue,
            date: dateFilterValue,
            dateType: typeof dateFilterValue,
            dateLength: dateFilterValue ? dateFilterValue.length : 0
        });
        
        if (courseFilterValue) {
            currentUrl.searchParams.set('course_filter', courseFilterValue);
        } else {
            currentUrl.searchParams.delete('course_filter');
        }
        
        if (subjectFilterValue) {
            currentUrl.searchParams.set('subject_filter', subjectFilterValue);
        } else {
            currentUrl.searchParams.delete('subject_filter');
        }
        
        if (topicFilterValue) {
            currentUrl.searchParams.set('topic_filter', topicFilterValue);
        } else {
            currentUrl.searchParams.delete('topic_filter');
        }
        
        if (questionTypeFilterValue) {
            currentUrl.searchParams.set('question_type_filter', questionTypeFilterValue);
        } else {
            currentUrl.searchParams.delete('question_type_filter');
        }
        
        if (dateFilterValue) {
            currentUrl.searchParams.set('date_filter', dateFilterValue);
        } else {
            currentUrl.searchParams.delete('date_filter');
        }
        
        console.log('Making AJAX request to:', currentUrl.toString());
        
        // Update browser URL without reloading
        window.history.pushState({}, '', currentUrl);
        
        // Perform AJAX request
        fetch(currentUrl.toString(), {
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => {
            console.log('AJAX response status:', response.status);
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            return response.text();
        })
        .then(html => {
            console.log('AJAX response received, HTML length:', html.length);
            
            // Create a temporary div to parse the HTML
            const tempDiv = document.createElement('div');
            tempDiv.innerHTML = html;
            
            // Extract the questions grid with better selectors
            const newQuestionsGrid = tempDiv.querySelector('.questions-container');
            const newEmptyState = tempDiv.querySelector('.p-12.text-center') || tempDiv.querySelector('.text-center');
            const newQuestionsCount = tempDiv.querySelector('.text-sm.text-gray-600.dark\\:text-gray-400') || tempDiv.querySelector('.questions-count');
            
            console.log('Extracted elements:', {
                questionsGrid: newQuestionsGrid ? 'found' : 'not found',
                emptyState: newEmptyState ? 'found' : 'not found',
                questionsCount: newQuestionsCount ? newQuestionsCount.textContent : 'not found'
            });
            
            // Update the page content
            const existingQuestionsContainer = document.querySelector('.questions-container');
            if (existingQuestionsContainer) {
                if (newQuestionsGrid) {
                    // There are questions - show the questions grid
                    console.log('Updating with questions grid');
                    existingQuestionsContainer.innerHTML = newQuestionsGrid.innerHTML;
                    
                    // Count questions in the new content
                    const questionItems = existingQuestionsContainer.querySelectorAll('[data-question-id]');
                    console.log('Questions displayed after update:', questionItems.length);
                } else if (newEmptyState) {
                    // No questions - show empty state
                    console.log('Updating with empty state');
                    existingQuestionsContainer.innerHTML = newEmptyState.outerHTML;
                    console.log('Empty state displayed');
                } else {
                    // Fallback: try to find any content with questions
                    const fallbackContent = tempDiv.querySelector('.questions-container') || tempDiv.querySelector('[data-question-id]');
                    if (fallbackContent) {
                        console.log('Using fallback content');
                        existingQuestionsContainer.innerHTML = fallbackContent.innerHTML;
                    }
                }
            }
            
            if (newQuestionsCount) {
                const existingQuestionsCount = document.querySelector('.text-sm.text-gray-600.dark\\:text-gray-400');
                if (existingQuestionsCount) {
                    existingQuestionsCount.textContent = newQuestionsCount.textContent;
                }
            }
            
            // Hide loading indicators
            if (questionsContainer) {
                questionsContainer.classList.remove('updating');
            }
        })
        .catch(error => {
            console.error('Search error:', error);
            // Hide loading indicators on error
            if (questionsContainer) {
                questionsContainer.classList.remove('updating');
            }
            
            // Show error message to user
            alert('Search failed. Please try again. Error: ' + error.message);
        });
    }
    
    // Function to load initial filter data
    function loadFilterData() {
        // Load courses first
        loadCourses().then(() => {
            // After courses are loaded, check if there's a selected course
            const selectedCourseId = '{{ request("course_filter") }}';
            
            if (selectedCourseId) {
                // Load subjects for the selected course
                loadSubjects(selectedCourseId).then(() => {
                    // After subjects are loaded, check if there's a selected subject
                    const selectedSubjectId = '{{ request("subject_filter") }}';
                    
                    if (selectedSubjectId) {
                        // Load topics for the selected subject
                        loadTopics(selectedSubjectId);
                    } else {
                        // Load all topics if no subject is selected
                        loadTopics();
                    }
                });
            } else {
                // Load all subjects and topics if no course is selected
                loadSubjects();
                loadTopics();
            }
        });
        
        // Load question types
        loadQuestionTypes();
    }
    
    // Function to load courses
    function loadCourses() {
        return fetch('{{ route("partner.questions.courses-for-filter") }}', {
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => response.json())
        .then(data => {
            courseFilter.innerHTML = '<option value="">All Courses</option>';
            
            if (data.courses && data.courses.length > 0) {
                data.courses.forEach(course => {
                    const option = document.createElement('option');
                    option.value = course.id;
                    option.textContent = course.name;
                    
                    // Check if this course was previously selected
                    if (course.id == '{{ request("course_filter") }}') {
                        option.selected = true;
                    }
                    
                    courseFilter.appendChild(option);
                });
            }
        })
        .catch(error => {
            console.error('Error loading courses:', error);
            courseFilter.innerHTML = '<option value="">Error loading courses</option>';
        });
    }
    
    // Function to load subjects
    function loadSubjects(courseId = null) {
        return fetch(`{{ route("partner.questions.subjects-for-filter") }}?course_id=${courseId || ''}`, {
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => response.json())
        .then(data => {
            subjectFilter.innerHTML = '<option value="">All Subjects</option>';
            
            if (data.subjects && data.subjects.length > 0) {
                data.subjects.forEach(subject => {
                    const option = document.createElement('option');
                    option.value = subject.id;
                    option.textContent = subject.name;
                    
                    // Check if this subject was previously selected
                    if (subject.id == '{{ request("subject_filter") }}') {
                        option.selected = true;
                    }
                    
                    subjectFilter.appendChild(option);
                });
            }
        })
        .catch(error => {
            console.error('Error loading subjects:', error);
            subjectFilter.innerHTML = '<option value="">Error loading subjects</option>';
        });
    }
    
    // Function to load topics
    function loadTopics(subjectId = null) {
        return fetch(`{{ route("partner.questions.topics-for-filter") }}?subject_id=${subjectId || ''}`, {
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => response.json())
        .then(data => {
            topicFilter.innerHTML = '<option value="">All Topics</option>';
            
            if (data.topics && data.topics.length > 0) {
                data.topics.forEach(topic => {
                    const option = document.createElement('option');
                    option.value = topic.id;
                    option.textContent = topic.name;
                    
                    // Check if this topic was previously selected
                    if (topic.id == '{{ request("topic_filter") }}') {
                        option.selected = true;
                    }
                    
                    topicFilter.appendChild(option);
                });
            }
        })
        .catch(error => {
            console.error('Error loading topics:', error);
            topicFilter.innerHTML = '<option value="">Error loading topics</option>';
        });
    }
    
    // Function to load question types
    function loadQuestionTypes() {
        return fetch('{{ route("partner.questions.question-types-for-filter") }}', {
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => response.json())
        .then(data => {
            questionTypeFilter.innerHTML = '<option value="">All Types</option>';
            
            if (data.questionTypes && data.questionTypes.length > 0) {
                data.questionTypes.forEach(questionType => {
                    const option = document.createElement('option');
                    option.value = questionType.q_type_code;
                    option.textContent = questionType.q_type_name;
                    
                    // Check if this question type was previously selected
                    if (questionType.q_type_code == '{{ request("question_type_filter") }}') {
                        option.selected = true;
                    }
                    
                    questionTypeFilter.appendChild(option);
                });
            }
        })
        .catch(error => {
            console.error('Error loading question types:', error);
            questionTypeFilter.innerHTML = '<option value="">Error loading question types</option>';
        });
    }
    
    // Function to update subjects based on selected course
    function updateSubjectsForCourse(courseId) {
        if (!subjectFilter) return;
        
        console.log('updateSubjectsForCourse called with courseId:', courseId);
        
        // Show loading state
        subjectFilter.disabled = true;
        subjectFilter.innerHTML = '<option value="">Loading subjects...</option>';
        
        // Load subjects for the selected course
        loadSubjects(courseId);
        
        // Re-enable the dropdown after loading
        setTimeout(() => {
            subjectFilter.disabled = false;
            console.log('Subjects updated for course:', courseId);
        }, 500);
    }
    
    // Function to update topics based on selected subject
    function updateTopicsForSubject(subjectId) {
        if (!topicFilter) return;
        
        console.log('updateTopicsForSubject called with subjectId:', subjectId);
        
        // Show loading state
        topicFilter.disabled = true;
        topicFilter.innerHTML = '<option value="">Loading topics...</option>';
        
        // Load topics for the selected subject
        loadTopics(subjectId);
        
        // Re-enable the dropdown after loading
        setTimeout(() => {
            topicFilter.disabled = false;
            console.log('Topics updated for subject:', subjectId);
        }, 500);
    }
    
    // Original AJAX Search Function (for non-date filters)
    function performAjaxSearch() {
        const searchValue = searchInput.value;
        const currentUrl = new URL(window.location);
        
        // Add updating class to questions container
        if (questionsContainer) {
            questionsContainer.classList.add('updating');
        }
        
        // Update URL parameters
        if (searchValue) {
            currentUrl.searchParams.set('search', searchValue);
        } else {
            currentUrl.searchParams.delete('search');
        }
        
        // Handle filter parameters
        const courseFilterValue = courseFilter ? courseFilter.value : '';
        const subjectFilterValue = subjectFilter ? subjectFilter.value : '';
        const topicFilterValue = topicFilter ? topicFilter.value : '';
        const questionTypeFilterValue = questionTypeFilter ? questionTypeFilter.value : '';
        const dateFilterValue = dateFilter ? dateFilter.value : '';
        
        console.log('Filter values:', {
            course: courseFilterValue,
            subject: subjectFilterValue,
            topic: topicFilterValue,
            questionType: questionTypeFilterValue,
            date: dateFilterValue,
            dateType: typeof dateFilterValue,
            dateLength: dateFilterValue ? dateFilterValue.length : 0
        });
        
        if (courseFilterValue) {
            currentUrl.searchParams.set('course_filter', courseFilterValue);
        } else {
            currentUrl.searchParams.delete('course_filter');
        }
        
        if (subjectFilterValue) {
            currentUrl.searchParams.set('subject_filter', subjectFilterValue);
        } else {
            currentUrl.searchParams.delete('subject_filter');
        }
        
        if (topicFilterValue) {
            currentUrl.searchParams.set('topic_filter', topicFilterValue);
        } else {
            currentUrl.searchParams.delete('topic_filter');
        }
        
        if (questionTypeFilterValue) {
            currentUrl.searchParams.set('question_type_filter', questionTypeFilterValue);
        } else {
            currentUrl.searchParams.delete('question_type_filter');
        }
        
        if (dateFilterValue) {
            currentUrl.searchParams.set('date_filter', dateFilterValue);
        } else {
            currentUrl.searchParams.delete('date_filter');
        }
        
        console.log('Making AJAX request to:', currentUrl.toString());
        
        // Update browser URL without reloading
        window.history.pushState({}, '', currentUrl);
        
        // Perform AJAX request
        fetch(currentUrl.toString(), {
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => {
            console.log('AJAX response status:', response.status);
            return response.text();
        })
        .then(html => {
            console.log('AJAX response received, HTML length:', html.length);
            
            // Parse the response HTML
            const parser = new DOMParser();
            const doc = parser.parseFromString(html, 'text/html');
            
            // Extract the questions grid
            const questionsGrid = doc.querySelector('.questions-container');
            const emptyState = doc.querySelector('.empty-state');
            const questionsCount = doc.querySelector('.questions-count');
            
            console.log('Extracted elements:', {
                questionsGrid: questionsGrid ? 'found' : 'not found',
                emptyState: emptyState ? 'found' : 'not found',
                questionsCount: questionsCount ? questionsCount.textContent.trim() : 'not found'
            });
            
            // Update the questions grid
            if (questionsContainer) {
                if (questionsGrid) {
                    questionsContainer.innerHTML = questionsGrid.innerHTML;
                } else if (emptyState) {
                    questionsContainer.innerHTML = emptyState.outerHTML;
                }
            }
            
            // Update questions count
            if (questionsCountElement && questionsCount) {
                questionsCountElement.textContent = questionsCount.textContent;
            }
            
            // Hide loading indicators
            if (questionsContainer) {
                questionsContainer.classList.remove('updating');
            }
        })
        .catch(error => {
            console.error('Search error:', error);
            // Hide loading indicators on error
            if (questionsContainer) {
                questionsContainer.classList.remove('updating');
            }
        });
    }
    
    // Load available dates for dropdown
    function loadAvailableDates() {
        console.log('Loading available dates...');
        fetch('/partner/questions/available-dates', {
            method: 'GET',
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => {
            console.log('Response status:', response.status);
            console.log('Response headers:', response.headers);
            return response.json();
        })
        .then(data => {
            console.log('Available dates response:', data);
            if (data.dates && data.dates.length > 0) {
                populateDateDropdown(data.dates);
            } else if (data.error) {
                console.error('API Error:', data.error);
                // Show error message to user
                if (dateFilter) {
                    dateFilter.innerHTML = '<option value="">Error loading dates</option>';
                }
            } else {
                console.log('No available dates found');
                if (dateFilter) {
                    dateFilter.innerHTML = '<option value="">No dates available</option>';
                }
            }
        })
        .catch(error => {
            console.error('Error loading available dates:', error);
            if (dateFilter) {
                dateFilter.innerHTML = '<option value="">Error loading dates</option>';
            }
        });
    }
    
    // Populate date dropdown with available dates
    function populateDateDropdown(dates) {
        if (!dateFilter) return;
        
        // Clear existing options except "All Dates"
        dateFilter.innerHTML = '<option value="">All Dates</option>';
        
        // Add available dates
        dates.forEach(dateStr => {
            const option = document.createElement('option');
            option.value = dateStr;
            
            // Format date for display as 'DD-Mmm-YYYY' (e.g., "2025-08-30" -> "30-Aug-2025")
            const date = new Date(dateStr);
            const day = date.getDate().toString().padStart(2, '0');
            const month = date.toLocaleDateString('en-US', { month: 'short' });
            const year = date.getFullYear();
            const formattedDate = `${day}-${month}-${year}`;
            
            option.textContent = formattedDate;
            dateFilter.appendChild(option);
        });
        
        console.log(`Populated date dropdown with ${dates.length} dates`);
    }
    
    // Initialize date dropdown
    if (dateFilter) {
        // Load available dates on page load
        loadAvailableDates();
        
        // Add change event listener for auto-search
        dateFilter.addEventListener('change', function() {
            console.log('Date filter changed to:', this.value);
            // Trigger search with the selected date value
            performAjaxSearchWithDate(this.value);
        });
    }

    const form = document.querySelector('form');
    const questionCheckboxes = document.querySelectorAll('.question-checkbox');
    const selectAllBtn = document.getElementById('select-all');
    const clearAllBtn = document.getElementById('clear-all');
    
    console.log('Found question checkboxes:', questionCheckboxes.length);
    console.log('Question checkboxes:', questionCheckboxes);
    
    // Test Q# input finding
    const testQuestionId = questionCheckboxes[0]?.value;
    if (testQuestionId) {
        const testNumberInput = document.querySelector(`input[name="question_numbers[${testQuestionId}]"]`);
        console.log('Test Q# input for question', testQuestionId, ':', testNumberInput);
    }
    
    // Add global test function for debugging
    window.testQNumber = function(questionId, number) {
        const input = document.querySelector(`input[name="question_numbers[${questionId}]"]`);
        if (input) {
            input.removeAttribute('readonly');
            input.value = number;
            input.setAttribute('readonly', 'readonly');
            console.log('Set Q# for question', questionId, 'to', number);
            return true;
        } else {
            console.error('Q# input not found for question', questionId);
            return false;
        }
    };
    
    console.log('Test function available: window.testQNumber(questionId, number)');
    
    const selectedCountSpan = document.getElementById('selected-count');
    const totalAllowedSpan = document.getElementById('total-allowed');
    const remainingCountSpan = document.getElementById('remaining-count');
    const progressBar = document.getElementById('progress-bar');
    const maxQuestions = parseInt(totalAllowedSpan.textContent);
    
    // Filter elements
    const searchInput = document.getElementById('search');
    const clearSearchBtn = document.getElementById('clear-search');
    const typeFilter = document.getElementById('type-filter');
    const courseFilter = document.getElementById('course-filter');
    const subjectFilter = document.getElementById('subject-filter');
    const topicFilter = document.getElementById('topic-filter');
    const clearFiltersBtn = document.getElementById('clear-filters');
    const refreshFiltersBtn = document.getElementById('refresh-filters');
    
    // Store all questions for filtering
    const allQuestions = Array.from(document.querySelectorAll('.question-checkbox')).map(checkbox => {
        const questionDiv = checkbox.closest('.question-card');
        return {
            checkbox: checkbox,
            element: questionDiv,
            text: questionDiv.textContent.toLowerCase(),
            type: questionDiv.dataset.type || '',
            course: questionDiv.dataset.course || '',
            subject: questionDiv.dataset.subject || '',
            topic: questionDiv.dataset.topic || ''
        };
    });
    
    function updateSelectedCount() {
        const selectedCount = document.querySelectorAll('.question-checkbox:checked').length;
        selectedCountSpan.textContent = selectedCount;
        
        // Update the remaining count display
        const remaining = maxQuestions - selectedCount;
        remainingCountSpan.textContent = remaining;
        
        // Update remaining count styling based on how many are left
        remainingCountSpan.className = 'text-xs';
        if (remaining <= 0) {
            remainingCountSpan.classList.add('text-red-600', 'font-semibold');
        } else if (remaining <= 2) {
            remainingCountSpan.classList.add('text-yellow-600', 'font-semibold');
        } else {
            remainingCountSpan.classList.add('text-gray-500');
        }
        
        // Update enhanced progress bar elements
        const selectedCountDisplay = document.getElementById('selected-count-display');
        const totalAllowedDisplay = document.getElementById('total-allowed-display');
        const progressPercentage = document.getElementById('progress-percentage');
        const progressDot = document.getElementById('progress-dot');
        
        if (selectedCountDisplay) selectedCountDisplay.textContent = selectedCount;
        if (totalAllowedDisplay) totalAllowedDisplay.textContent = maxQuestions;
        
        const progressPercent = Math.min((selectedCount / maxQuestions) * 100, 100);
        progressBar.style.width = progressPercent + '%';
        
        if (progressPercentage) {
            progressPercentage.textContent = Math.round(progressPercent) + '%';
        }
        
        // Show progress dot when there's progress
        if (progressDot) {
            if (progressPercent > 0) {
                progressDot.classList.add('show');
            } else {
                progressDot.classList.remove('show');
            }
        }
        
        // Update progress bar color and effects based on selection level
        progressBar.className = 'relative h-full bg-gradient-to-r from-blue-500 via-blue-600 to-indigo-600 rounded-full transition-all duration-700 ease-out shadow-lg';
        
        if (progressPercent >= 100) {
            progressBar.className = 'relative h-full bg-gradient-to-r from-red-500 via-red-600 to-red-700 rounded-full transition-all duration-700 ease-out shadow-lg progress-bar-pulse';
        } else if (progressPercent >= 80) {
            progressBar.className = 'relative h-full bg-gradient-to-r from-yellow-500 via-yellow-600 to-orange-600 rounded-full transition-all duration-700 ease-out shadow-lg';
        } else if (progressPercent >= 50) {
            progressBar.className = 'relative h-full bg-gradient-to-r from-green-500 via-green-600 to-emerald-600 rounded-full transition-all duration-700 ease-out shadow-lg';
        }
        
        // Disable/enable checkboxes based on limit
        const isAtLimit = selectedCount >= maxQuestions;
        document.querySelectorAll('.question-card').forEach(card => {
            const checkbox = card.querySelector('.question-checkbox');
            if (!checkbox.checked && isAtLimit) {
                card.classList.add('disabled');
                checkbox.disabled = true;
            } else {
                card.classList.remove('disabled');
                checkbox.disabled = false;
            }
        });
        
        // Show/hide limit warning
        const limitWarning = document.getElementById('limit-warning');
        if (isAtLimit) {
            limitWarning.classList.remove('hidden');
        } else {
            limitWarning.classList.add('hidden');
        }
        
        // Update button states
        selectAllBtn.disabled = isAtLimit;
        
        // Sort questions: selected questions on top, sorted by Q# order
        sortQuestionsBySelection();
    }
    
    function selectAll() {
        const visibleQuestions = document.querySelectorAll('.question-checkbox:not(.hidden)');
        const selectedCount = document.querySelectorAll('.question-checkbox:checked').length;
        const remaining = maxQuestions - selectedCount;
        
        let selected = 0;
        const currentTime = Date.now();
        visibleQuestions.forEach((checkbox, index) => {
            if (!checkbox.checked && selected < remaining) {
                checkbox.checked = true;
                // Add timestamp with slight offset to maintain order
                checkbox.setAttribute('data-check-time', currentTime + index);
                selected++;
            }
        });
        
        // Renumber all checked questions sequentially based on check order
        const checkedQuestions = Array.from(document.querySelectorAll('.question-checkbox:checked'));
        
        // Sort by check time to maintain proper sequence
        checkedQuestions.sort((a, b) => {
            const timeA = parseInt(a.getAttribute('data-check-time') || '0');
            const timeB = parseInt(b.getAttribute('data-check-time') || '0');
            return timeA - timeB;
        });
        
        checkedQuestions.forEach((checkbox, index) => {
            const questionId = checkbox.value;
            let numberInput = document.querySelector(`input[name="question_numbers[${questionId}]"]`);
            
            // Fallback: try to find the input within the same question card
            if (!numberInput) {
                const questionCard = checkbox.closest('.question-card');
                if (questionCard) {
                    numberInput = questionCard.querySelector('.question-number');
                }
            }
            
            if (numberInput) {
                // Force value update by removing and re-adding readonly
                numberInput.removeAttribute('readonly');
                numberInput.value = index + 1;
                numberInput.setAttribute('readonly', 'readonly');
            }
        });
        
        updateSelectedCount();
        
        // Auto-sort questions after selecting all
        sortQuestionsBySelection();
    }
    
    function clearAll() {
        questionCheckboxes.forEach(checkbox => {
            checkbox.checked = false;
            // Remove timestamps
            checkbox.removeAttribute('data-check-time');
        });
        // Clear all question numbers
        document.querySelectorAll('.question-number').forEach(input => {
            input.value = '';
        });
        updateSelectedCount();
        
        // Auto-sort questions after clearing all
        sortQuestionsBySelection();
    }
    
    function applyFilters() {
        const searchTerm = searchInput.value.toLowerCase();
        const selectedType = typeFilter.value;
        const selectedCourse = courseFilter.value;
        const selectedSubject = subjectFilter.value;
        const selectedTopic = topicFilter.value;
        
        allQuestions.forEach(question => {
            let shouldShow = true;
            
            if (searchTerm && !question.text.includes(searchTerm)) shouldShow = false;
            if (selectedType && question.type !== selectedType) shouldShow = false;
            if (selectedCourse && question.course !== selectedCourse) shouldShow = false;
            if (selectedSubject && question.subject !== selectedSubject) shouldShow = false;
            if (selectedTopic && question.topic !== selectedTopic) shouldShow = false;
            
            if (shouldShow) {
                question.element.classList.remove('hidden');
            } else {
                question.element.classList.add('hidden');
            }
        });
        
        // Sort questions after filtering
        sortQuestionsBySelection();
        
        // Update search results info
        updateSearchResultsInfo();
    }
    
    function clearAllFilters() {
        searchInput.value = '';
        typeFilter.value = '';
        courseFilter.value = '';
        subjectFilter.value = '';
        topicFilter.value = '';
        allQuestions.forEach(question => {
            question.element.classList.remove('hidden');
        });
        
        // Sort questions after clearing filters
        sortQuestionsBySelection();
    }
    
    function refreshFilters() {
        // Reapply current filters to refresh the view
        applyFilters();
    }
    
    function sortQuestionsBySelection() {
        const questionsContainer = document.querySelector('.grid.grid-cols-1.gap-2');
        if (!questionsContainer) return;
        
        const questionCards = Array.from(questionsContainer.querySelectorAll('.question-card'));
        
        // Add sorting animation to all cards
        questionCards.forEach(card => {
            card.classList.add('sorting');
        });
        
        // Separate selected and unselected questions
        const selectedQuestions = [];
        const unselectedQuestions = [];
        
        questionCards.forEach(card => {
            const checkbox = card.querySelector('.question-checkbox');
            if (checkbox && checkbox.checked) {
                selectedQuestions.push(card);
            } else {
                unselectedQuestions.push(card);
            }
        });
        
        // Sort selected questions by their check time (check sequence)
        selectedQuestions.sort((a, b) => {
            const checkboxA = a.querySelector('.question-checkbox');
            const checkboxB = b.querySelector('.question-checkbox');
            const timeA = parseInt(checkboxA?.getAttribute('data-check-time') || '0');
            const timeB = parseInt(checkboxB?.getAttribute('data-check-time') || '0');
            return timeA - timeB;
        });
        
        // Reassign Q# numbers based on check sequence order
        selectedQuestions.forEach((card, index) => {
            const numberInput = card.querySelector('.question-number');
            if (numberInput) {
                // Force value update by removing and re-adding readonly
                numberInput.removeAttribute('readonly');
                numberInput.value = index + 1;
                numberInput.setAttribute('readonly', 'readonly');
                console.log('Setting Q# for card', index + 1, ':', numberInput.value);
            } else {
                console.error('Q# input not found in card:', card);
            }
        });
        
        // Clear the container
        questionsContainer.innerHTML = '';
        
        // Add selected questions first (sorted by Q#)
        selectedQuestions.forEach((card, index) => {
            questionsContainer.appendChild(card);
            
            // Add highlight animation to newly selected questions
            if (card.querySelector('.question-checkbox')?.checked) {
                card.classList.add('newly-selected');
                setTimeout(() => {
                    card.classList.remove('newly-selected');
                }, 600);
            }
        });
        
        // Add unselected questions after
        unselectedQuestions.forEach(card => {
            questionsContainer.appendChild(card);
        });
        
        // Remove sorting animation after a short delay
        setTimeout(() => {
            questionCards.forEach(card => {
                card.classList.remove('sorting');
            });
        }, 300);
        
        // Update allQuestions array to reflect new order
        const newOrder = [...selectedQuestions, ...unselectedQuestions];
        allQuestions.forEach((question, index) => {
            const newIndex = newOrder.findIndex(card => card === question.element);
            if (newIndex !== -1) {
                allQuestions[index] = {
                    ...question,
                    element: newOrder[newIndex]
                };
            }
        });
    }
    
    // Event listeners
    questionCheckboxes.forEach(checkbox => {
        checkbox.addEventListener('change', function(e) {
            // If checking a checkbox, verify we haven't exceeded the limit
            if (e.target.checked) {
                const selectedCount = document.querySelectorAll('.question-checkbox:checked').length;
                if (selectedCount > maxQuestions) {
                    e.target.checked = false;
                    alert(`Maximum ${maxQuestions} questions allowed`);
                    return;
                }
                
                // Auto-assign sequential question number based on check sequence
                const questionId = e.target.value;
                let numberInput = document.querySelector(`input[name="question_numbers[${questionId}]"]`);
                
                console.log('Checking question:', questionId);
                console.log('Number input found:', numberInput);
                
                // Fallback: try to find the input within the same question card
                if (!numberInput) {
                    const questionCard = e.target.closest('.question-card');
                    if (questionCard) {
                        numberInput = questionCard.querySelector('.question-number');
                        console.log('Found Q# input in card:', numberInput);
                    }
                }
                
                if (numberInput) {
                    // Count currently checked questions to get the next sequential number
                    const checkedQuestions = document.querySelectorAll('.question-checkbox:checked');
                    const newNumber = checkedQuestions.length;
                    
                    console.log('Setting Q# to:', newNumber);
                    
                    // Force value update by removing and re-adding readonly
                    numberInput.removeAttribute('readonly');
                    numberInput.value = newNumber;
                    numberInput.setAttribute('readonly', 'readonly');
                    
                    // Add visual feedback
                    numberInput.style.backgroundColor = '#dbeafe';
                    numberInput.style.borderColor = '#3b82f6';
                    numberInput.style.fontWeight = 'bold';
                    numberInput.style.color = '#1e40af';
                    setTimeout(() => {
                        numberInput.style.backgroundColor = '';
                        numberInput.style.borderColor = '';
                        numberInput.style.fontWeight = '';
                        numberInput.style.color = '';
                    }, 1000);
                    
                    // Add timestamp to track check order
                    e.target.setAttribute('data-check-time', Date.now());
                    
                    // Trigger change event to ensure the value is updated
                    numberInput.dispatchEvent(new Event('change', { bubbles: true }));
                    
                    console.log('Q# value after setting:', numberInput.value);
                } else {
                    console.error('Number input not found for question:', questionId);
                    console.log('Available inputs:', document.querySelectorAll('input[type="number"]'));
                }
            } else {
                // Clear question number when deselected
                const questionId = e.target.value;
                let numberInput = document.querySelector(`input[name="question_numbers[${questionId}]"]`);
                
                // Fallback: try to find the input within the same question card
                if (!numberInput) {
                    const questionCard = e.target.closest('.question-card');
                    if (questionCard) {
                        numberInput = questionCard.querySelector('.question-number');
                    }
                }
                
                if (numberInput) {
                    // Force value update by removing and re-adding readonly
                    numberInput.removeAttribute('readonly');
                    numberInput.value = '';
                    numberInput.setAttribute('readonly', 'readonly');
                }
                
                // Remove timestamp
                e.target.removeAttribute('data-check-time');
                
                // Renumber all remaining checked questions sequentially based on check order
                const checkedQuestions = Array.from(document.querySelectorAll('.question-checkbox:checked'));
                
                // Sort by check time to maintain original check sequence
                checkedQuestions.sort((a, b) => {
                    const timeA = parseInt(a.getAttribute('data-check-time') || '0');
                    const timeB = parseInt(b.getAttribute('data-check-time') || '0');
                    return timeA - timeB;
                });
                
                // Assign sequential numbers based on check order
                checkedQuestions.forEach((checkbox, index) => {
                    const qId = checkbox.value;
                    let qNumberInput = document.querySelector(`input[name="question_numbers[${qId}]"]`);
                    
                    // Fallback: try to find the input within the same question card
                    if (!qNumberInput) {
                        const questionCard = checkbox.closest('.question-card');
                        if (questionCard) {
                            qNumberInput = questionCard.querySelector('.question-number');
                        }
                    }
                    
                    if (qNumberInput) {
                        // Force value update by removing and re-adding readonly
                        qNumberInput.removeAttribute('readonly');
                        qNumberInput.value = index + 1;
                        qNumberInput.setAttribute('readonly', 'readonly');
                    }
                });
            }
            // Always update the count and UI state
            updateSelectedCount();
            
            // Auto-sort questions when selection changes
            sortQuestionsBySelection();
        });
    });
    
    selectAllBtn.addEventListener('click', selectAll);
    clearAllBtn.addEventListener('click', clearAll);
    
    // Enhanced Search functionality
    const searchLoading = document.getElementById('search-loading');
    const searchResultsInfo = document.getElementById('search-results-info');
    const searchResultsCount = document.getElementById('search-results-count');
    let searchTimeout;
    
    searchInput.addEventListener('input', function() {
        const searchTerm = this.value.trim();
        
        // Clear previous timeout
        clearTimeout(searchTimeout);
        
        // Show loading indicator for longer searches
        if (searchTerm.length > 2) {
            searchLoading.classList.add('show');
            clearSearchBtn.classList.remove('show');
        }
        
        // Debounce search to avoid excessive filtering
        searchTimeout = setTimeout(() => {
            applyFilters();
            searchLoading.classList.remove('show');
            
            // Show/hide clear button and results info
            if (searchTerm.length > 0) {
                clearSearchBtn.classList.add('show');
                searchResultsInfo.classList.add('show');
                updateSearchResultsInfo();
            } else {
                clearSearchBtn.classList.remove('show');
                searchResultsInfo.classList.remove('show');
            }
        }, searchTerm.length > 2 ? 300 : 100);
    });
    
    clearSearchBtn.addEventListener('click', () => {
        searchInput.value = '';
        clearSearchBtn.classList.remove('show');
        searchResultsInfo.classList.remove('show');
        searchLoading.classList.remove('show');
        clearTimeout(searchTimeout);
        applyFilters();
        searchInput.focus();
    });
    
    // Focus search on Ctrl+K
    document.addEventListener('keydown', function(e) {
        if ((e.ctrlKey || e.metaKey) && e.key === 'k') {
            e.preventDefault();
            searchInput.focus();
        }
    });
    
    function updateSearchResultsInfo() {
        const visibleQuestions = document.querySelectorAll('.question-card:not(.hidden)');
        const searchTerm = searchInput.value.trim();
        
        if (searchTerm.length > 0) {
            searchResultsCount.textContent = visibleQuestions.length;
            searchResultsInfo.classList.add('show');
        } else {
            searchResultsInfo.classList.remove('show');
        }
    }
    typeFilter.addEventListener('change', applyFilters);
    courseFilter.addEventListener('change', applyFilters);
    subjectFilter.addEventListener('change', applyFilters);
    topicFilter.addEventListener('change', applyFilters);
    clearFiltersBtn.addEventListener('click', clearAllFilters);
    refreshFiltersBtn.addEventListener('click', refreshFilters);
    
    // Form validation
    form.addEventListener('submit', function(e) {
        const questionIds = new FormData(form).getAll('question_ids[]');
        if (questionIds.length === 0) {
            e.preventDefault();
            alert('Please select at least one question before submitting.');
            return false;
        }
        
        // Clear question numbers for unchecked questions before submission
        const allQuestionNumbers = document.querySelectorAll('input[name^="question_numbers["]');
        allQuestionNumbers.forEach(input => {
            const questionId = input.name.match(/\[(\d+)\]/)[1];
            const checkbox = document.querySelector(`input[name="question_ids[]"][value="${questionId}"]`);
            if (!checkbox || !checkbox.checked) {
                input.value = '';
            }
        });
        
        // Validate mark inputs for selected questions
        let hasInvalidMarks = false;
        
        questionIds.forEach(questionId => {
            const markInput = document.querySelector(`input[name="question_marks[${questionId}]"]`);
            
            // Validate marks
            if (markInput) {
                const markValue = parseInt(markInput.value);
                if (isNaN(markValue) || markValue < 1 || markValue > 100) {
                    hasInvalidMarks = true;
                    markInput.classList.add('border-red-500');
                } else {
                    markInput.classList.remove('border-red-500');
                }
            }
        });
        
        if (hasInvalidMarks) {
            e.preventDefault();
            alert('Please enter valid marks (1-100) for all selected questions.');
            return false;
        }
    });
    
    // Drag and Drop functionality
    function initializeDragAndDrop() {
        const questionsContainer = document.querySelector('.grid.grid-cols-1.gap-4');
        if (!questionsContainer) return;
        
        let draggedElement = null;
        let draggedIndex = -1;
        let indicatorTimeout = null;
        
        // Add drag event listeners to all question cards
        function addDragListeners() {
            const questionCards = document.querySelectorAll('.question-card');
            console.log('Adding drag listeners to', questionCards.length, 'question cards');
            
            questionCards.forEach((card, index) => {
                // Remove existing listeners to prevent duplicates
                card.removeEventListener('dragstart', handleDragStart);
                card.removeEventListener('dragend', handleDragEnd);
                card.removeEventListener('dragover', handleDragOver);
                card.removeEventListener('drop', handleDrop);
                card.removeEventListener('dragenter', handleDragEnter);
                card.removeEventListener('dragleave', handleDragLeave);
                
                // Add new listeners
                card.addEventListener('dragstart', handleDragStart);
                card.addEventListener('dragend', handleDragEnd);
                card.addEventListener('dragover', handleDragOver);
                card.addEventListener('drop', handleDrop);
                card.addEventListener('dragenter', handleDragEnter);
                card.addEventListener('dragleave', handleDragLeave);
                
                // Ensure draggable attribute is set
                card.setAttribute('draggable', 'true');
            });
        }
        
        function handleDragStart(e) {
            console.log('Drag start triggered');
            
            // Find the question card (might be triggered by child elements)
            const questionCard = e.target.closest('.question-card');
            if (!questionCard) {
                console.log('No question card found');
                e.preventDefault();
                return;
            }
            
            // Only allow dragging if the question is selected
            const checkbox = questionCard.querySelector('.question-checkbox');
            if (!checkbox) {
                console.log('No checkbox found');
                e.preventDefault();
                return;
            }
            
            if (!checkbox.checked) {
                console.log('Question not selected, preventing drag');
                e.preventDefault();
                return;
            }
            
            console.log('Drag allowed for selected question');
            draggedElement = questionCard;
            draggedIndex = Array.from(questionsContainer.children).indexOf(draggedElement);
            questionCard.classList.add('dragging');
            e.dataTransfer.effectAllowed = 'move';
            e.dataTransfer.setData('text/html', questionCard.outerHTML);
        }
        
        function handleDragEnd(e) {
            const questionCard = e.target.closest('.question-card');
            if (questionCard) {
                questionCard.classList.remove('dragging');
            }
            hideDropIndicator();
            clearTimeout(indicatorTimeout);
            draggedElement = null;
            draggedIndex = -1;
        }
        
        function handleDragOver(e) {
            e.preventDefault();
            e.dataTransfer.dropEffect = 'move';
        }
        
        function handleDragEnter(e) {
            e.preventDefault();
            const targetCard = e.target.closest('.question-card');
            if (targetCard && targetCard !== draggedElement && targetCard.querySelector('.question-checkbox').checked) {
                targetCard.classList.add('drag-over');
                
                // Debounce indicator showing to prevent rapid changes
                clearTimeout(indicatorTimeout);
                indicatorTimeout = setTimeout(() => {
                    showDropIndicator(targetCard);
                }, 50);
            }
        }
        
        function handleDragLeave(e) {
            const targetCard = e.target.closest('.question-card');
            if (targetCard && !targetCard.contains(e.relatedTarget)) {
                targetCard.classList.remove('drag-over');
                hideDropIndicator();
            }
        }
        
        function showDropIndicator(targetCard) {
            // Don't show indicator if already showing for the same target
            const existingIndicator = document.querySelector('.drop-indicator');
            if (existingIndicator && existingIndicator.getAttribute('data-drop-target') === targetCard.dataset.questionId) {
                return;
            }
            
            hideDropIndicator(); // Remove any existing indicator
            
            const indicator = document.createElement('div');
            indicator.className = 'drop-indicator show';
            indicator.setAttribute('data-drop-target', targetCard.dataset.questionId);
            
            // Add event listeners to the indicator
            indicator.addEventListener('dragover', handleDragOver);
            indicator.addEventListener('drop', handleDrop);
            indicator.addEventListener('dragenter', (e) => e.preventDefault());
            
            // Insert the indicator before the target card
            targetCard.parentNode.insertBefore(indicator, targetCard);
        }
        
        function hideDropIndicator() {
            const existingIndicator = document.querySelector('.drop-indicator');
            if (existingIndicator) {
                existingIndicator.remove();
            }
        }
        
        function handleDrop(e) {
            e.preventDefault();
            hideDropIndicator();
            
            if (!draggedElement) return;
            
            // Clean up all drag-over states
            document.querySelectorAll('.question-card.drag-over').forEach(card => {
                card.classList.remove('drag-over');
            });
            
            // Check if we're dropping on a drop indicator
            const dropIndicator = e.target.closest('.drop-indicator');
            let dropTarget;
            
            if (dropIndicator) {
                // Find the question card that comes after the indicator
                const nextSibling = dropIndicator.nextSibling;
                dropTarget = nextSibling && nextSibling.classList.contains('question-card') ? nextSibling : null;
            } else {
                // Fallback to dropping on the question card itself
                dropTarget = e.target.closest('.question-card');
            }
            
            if (!dropTarget || dropTarget === draggedElement) return;
            
            // Only allow dropping on selected questions
            const dropCheckbox = dropTarget.querySelector('.question-checkbox');
            if (!dropCheckbox || !dropCheckbox.checked) return;
            
            const currentIndex = Array.from(questionsContainer.children).indexOf(draggedElement);
            const dropIndex = Array.from(questionsContainer.children).indexOf(dropTarget);
            
            // Only move if the position actually changed
            if (currentIndex !== dropIndex) {
                // Move the dragged element to the new position
                if (currentIndex < dropIndex) {
                    questionsContainer.insertBefore(draggedElement, dropTarget.nextSibling);
                } else {
                    questionsContainer.insertBefore(draggedElement, dropTarget);
                }
                
                // Update question numbers based on new order
                updateQuestionNumbersAfterDrag();
            }
        }
        
        function updateQuestionNumbersAfterDrag() {
            const selectedQuestions = Array.from(questionsContainer.querySelectorAll('.question-card'))
                .filter(card => {
                    const checkbox = card.querySelector('.question-checkbox');
                    return checkbox && checkbox.checked;
                });
            
            selectedQuestions.forEach((card, index) => {
                const numberInput = card.querySelector('.question-number');
                if (numberInput) {
                    numberInput.value = index + 1;
                }
            });
            
            // Update the allQuestions array to reflect new order
            updateAllQuestionsArray();
        }
        
        function updateAllQuestionsArray() {
            const questionCards = Array.from(questionsContainer.querySelectorAll('.question-card'));
            const newOrder = questionCards.map(card => {
                const questionId = card.dataset.questionId;
                return allQuestions.find(q => q.element === card);
            }).filter(Boolean);
            
            // Update allQuestions array
            allQuestions.splice(0, allQuestions.length, ...newOrder);
        }
        
        // Initialize drag and drop
        addDragListeners();
        
        // Re-initialize when questions are filtered or sorted
        const originalSortQuestions = sortQuestionsBySelection;
        sortQuestionsBySelection = function() {
            originalSortQuestions();
            addDragListeners();
        };
    }
    
    // Initialize drag and drop
    initializeDragAndDrop();
    
    // Initial setup
    updateSelectedCount();
});
</script>
@endpush
