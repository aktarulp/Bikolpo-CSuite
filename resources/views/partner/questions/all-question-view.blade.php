@extends('layouts.partner-layout')

@section('title', 'All Questions - Bikolpo LQ')

@section('content')
<style>
    .question-card {
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        border: 1px solid #e5e7eb;
    }
    
    .question-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        border-color: #3b82f6;
    }
    
    .question-type-badge {
        position: relative;
        overflow: hidden;
    }
    
    .question-type-badge::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255,255,255,0.3), transparent);
        transition: left 0.6s;
    }
    
    .question-type-badge:hover::before {
        left: 100%;
    }
    
    .filter-section {
        backdrop-filter: blur(10px);
        background: rgba(255, 255, 255, 0.8);
    }
    
    .dark .filter-section {
        background: rgba(31, 41, 55, 0.8);
    }
    
    .stats-card {
        background: linear-gradient(135deg, rgba(255,255,255,0.9), rgba(255,255,255,0.7));
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255,255,255,0.2);
    }
    
    .dark .stats-card {
        background: linear-gradient(135deg, rgba(31,41,55,0.9), rgba(31,41,55,0.7));
        border: 1px solid rgba(255,255,255,0.1);
    }
    
    .loading-shimmer {
        background: linear-gradient(90deg, #f0f0f0 25%, #e0e0e0 50%, #f0f0f0 75%);
        background-size: 200% 100%;
        animation: shimmer 1.5s infinite;
    }
    
    @keyframes shimmer {
        0% { background-position: -200% 0; }
        100% { background-position: 200% 0; }
    }
    
    .dark .loading-shimmer {
        background: linear-gradient(90deg, #374151 25%, #4b5563 50%, #374151 75%);
        background-size: 200% 100%;
    }
</style>
<div class="min-h-screen bg-gradient-to-br from-gray-50 via-blue-50 to-indigo-100 dark:from-gray-900 dark:via-gray-800 dark:to-gray-900">
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

    <!-- Main Container -->
    <div class="container mx-auto px-4 py-6 space-y-6">
        <!-- Header Section -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl border border-gray-200 dark:border-gray-700 overflow-hidden">
            <div class="bg-gradient-to-r from-blue-600 to-indigo-600 px-6 py-8">
                <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-6">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center backdrop-blur-sm">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div>
                            <h1 class="text-3xl font-bold text-white">Question Bank</h1>
                            <p class="text-blue-100 mt-1">Manage and organize your questions efficiently</p>
                        </div>
                    </div>
                    
                    <!-- Action Buttons -->
                    <div class="flex flex-wrap gap-3">
                        <a href="{{ route('partner.questions.drafts') }}" 
                           class="px-4 py-2 bg-yellow-500 hover:bg-yellow-600 text-white rounded-lg transition-all duration-200 flex items-center gap-2 font-medium">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                            Drafts
                        </a>
                        
                        <div class="relative group">
                            <button class="px-4 py-2 bg-green-500 hover:bg-green-600 text-white rounded-lg transition-all duration-200 flex items-center gap-2 font-medium">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                </svg>
                                Add Question
                                <svg class="w-3 h-3 transition-transform group-hover:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </button>
                            
                            <!-- Dropdown Menu -->
                            <div class="absolute right-0 mt-2 w-64 bg-white dark:bg-gray-800 rounded-xl shadow-xl border border-gray-200 dark:border-gray-700 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300 transform translate-y-2 group-hover:translate-y-0 z-50">
                                <div class="py-2">
                                    <a href="{{ route('partner.questions.mcq.create') }}" class="flex items-center px-4 py-3 text-gray-700 dark:text-gray-300 hover:bg-blue-50 dark:hover:bg-blue-900/20 transition-colors">
                                        <img src="{{ asset('images/mcq.png') }}" alt="MCQ" class="w-5 h-5 mr-3">
                                        <div>
                                            <div class="font-medium">Multiple Choice</div>
                                            <div class="text-xs text-gray-500">Create MCQ with options</div>
                                        </div>
                                    </a>
                                    <a href="{{ route('partner.questions.descriptive.create') }}" class="flex items-center px-4 py-3 text-gray-700 dark:text-gray-300 hover:bg-green-50 dark:hover:bg-green-900/20 transition-colors">
                                        <img src="{{ asset('images/cq.png') }}" alt="CQ" class="w-5 h-5 mr-3">
                                        <div>
                                            <div class="font-medium">Descriptive</div>
                                            <div class="text-xs text-gray-500">Open-ended questions</div>
                                        </div>
                                    </a>
                                    <a href="{{ route('partner.questions.tf.create') }}" class="flex items-center px-4 py-3 text-gray-700 dark:text-gray-300 hover:bg-orange-50 dark:hover:bg-orange-900/20 transition-colors">
                                        <svg class="w-5 h-5 mr-3 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        <div>
                                            <div class="font-medium">True/False</div>
                                            <div class="text-xs text-gray-500">Binary choice questions</div>
                                        </div>
                                    </a>
                                    <div class="border-t border-gray-200 dark:border-gray-600 my-2"></div>
                                    <a href="{{ route('partner.questions.bulk-upload') }}" class="flex items-center px-4 py-3 text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700/20 transition-colors">
                                        <svg class="w-5 h-5 mr-3 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                                        </svg>
                                        <div>
                                            <div class="font-medium">Bulk Upload</div>
                                            <div class="text-xs text-gray-500">Upload via CSV/Excel</div>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Stats Section -->
            <div class="p-6">
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                    <div class="stats-card rounded-lg p-4">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 bg-blue-100 dark:bg-blue-900/30 rounded-lg flex items-center justify-center">
                                <svg class="w-5 h-5 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                            </div>
                            <div>
                                <div class="text-2xl font-bold text-gray-900 dark:text-white">{{ $questions->total() }}</div>
                                <div class="text-sm text-gray-600 dark:text-gray-400">Total Questions</div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="stats-card rounded-lg p-4">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 bg-blue-100 dark:bg-blue-900/30 rounded-lg flex items-center justify-center">
                                <img src="{{ asset('images/mcq.png') }}" alt="MCQ" class="w-5 h-5">
                            </div>
                            <div>
                                <div class="text-2xl font-bold text-gray-900 dark:text-white">{{ $questions->where('question_type', 'mcq')->count() }}</div>
                                <div class="text-sm text-gray-600 dark:text-gray-400">MCQ</div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="stats-card rounded-lg p-4">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 bg-green-100 dark:bg-green-900/30 rounded-lg flex items-center justify-center">
                                <img src="{{ asset('images/cq.png') }}" alt="CQ" class="w-5 h-5">
                            </div>
                            <div>
                                <div class="text-2xl font-bold text-gray-900 dark:text-white">{{ $questions->where('question_type', 'descriptive')->count() }}</div>
                                <div class="text-sm text-gray-600 dark:text-gray-400">Descriptive</div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="stats-card rounded-lg p-4">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 bg-orange-100 dark:bg-orange-900/30 rounded-lg flex items-center justify-center">
                                <svg class="w-5 h-5 text-orange-600 dark:text-orange-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <div>
                                <div class="text-2xl font-bold text-gray-900 dark:text-white">{{ $questions->where('question_type', 'true_false')->count() }}</div>
                                <div class="text-sm text-gray-600 dark:text-gray-400">True/False</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Search and Filters Section -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg border border-gray-200 dark:border-gray-700 overflow-hidden">
            <div class="p-6">
                <form method="GET" id="filterForm" class="space-y-6">
                    <input type="hidden" name="search" id="searchHidden" value="{{ request('search') }}">
                    
                    <!-- Search Bar -->
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                            </svg>
                        </div>
                        <input type="text" 
                               id="searchInput" 
                               class="block w-full pl-12 pr-16 py-4 border border-gray-300 dark:border-gray-600 rounded-xl bg-white dark:bg-gray-700 text-gray-900 dark:text-white placeholder-gray-500 dark:placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 text-lg" 
                               placeholder="Search questions by text, course, subject, or topic..." 
                               value="{{ request('search') }}">
                        <div class="absolute inset-y-0 right-0 flex items-center pr-4">
                            <div id="searchLoading" class="hidden">
                                <svg class="animate-spin h-5 w-5 text-blue-500" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                            </div>
                        </div>
                    </div>

                    <!-- Filters Grid -->
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                        <div class="space-y-2">
                            <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300">Course</label>
                            <select name="course_filter" id="course_filter" class="w-full rounded-lg border border-gray-300 dark:border-gray-600 p-3 bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200">
                                <option value="">All Courses</option>
                            </select>
                        </div>
                        
                        <div class="space-y-2">
                            <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300">Subject</label>
                            <select name="subject_filter" id="subject_filter" class="w-full rounded-lg border border-gray-300 dark:border-gray-600 p-3 bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200">
                                <option value="">All Subjects</option>
                            </select>
                        </div>
                        
                        <div class="space-y-2">
                            <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300">Topic</label>
                            <select name="topic_filter" id="topic_filter" class="w-full rounded-lg border border-gray-300 dark:border-gray-600 p-3 bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200">
                                <option value="">All Topics</option>
                            </select>
                        </div>
                        
                        <div class="space-y-2">
                            <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300">Question Type</label>
                            <select name="question_type_filter" id="question_type_filter" class="w-full rounded-lg border border-gray-300 dark:border-gray-600 p-3 bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200">
                                <option value="">All Types</option>
                            </select>
                        </div>
                    </div>
                    
                    <!-- Action Buttons -->
                    <div class="flex flex-wrap gap-3 justify-end">
                        <button type="button" id="refreshQuestions" class="px-6 py-3 bg-blue-500 hover:bg-blue-600 text-white rounded-lg transition-all duration-200 flex items-center gap-2 font-medium">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                            </svg>
                            Refresh
                        </button>
                        <button type="button" id="clearAllFilters" class="px-6 py-3 bg-gray-500 hover:bg-gray-600 text-white rounded-lg transition-all duration-200 font-medium">
                            Clear Filters
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Questions Grid Section -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg border border-gray-200 dark:border-gray-700 overflow-hidden">
            <!-- Header -->
            <div class="bg-gray-50 dark:bg-gray-700 px-6 py-4 border-b border-gray-200 dark:border-gray-600">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                    <div>
                        <h2 class="text-xl font-bold text-gray-900 dark:text-white">Questions</h2>
                        <p class="text-sm text-gray-600 dark:text-gray-400">Showing {{ $questions->count() }} of {{ $questions->total() }} questions</p>
                    </div>
                    <div class="flex items-center gap-2 text-sm text-gray-500 dark:text-gray-400">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1a3 3 0 01-3-3V6a3 3 0 013-3h1m-1 0v18m0 0h1a3 3 0 013 3v7a3 3 0 01-3 3h-1"></path>
                        </svg>
                        <span>{{ $questions->total() }} total</span>
                    </div>
                </div>
            </div>

            @if($questions->count() > 0)
                <!-- Questions Grid -->
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 questions-container">
                        @foreach($questions as $question)
                            <div class="question-card bg-white dark:bg-gray-800 rounded-xl p-6 shadow-sm border border-gray-200 dark:border-gray-700" data-question-id="{{ $question->id }}">
                                <!-- Question Header -->
                                <div class="flex items-start justify-between mb-4">
                                    <div class="flex items-center gap-3">
                                        <div class="question-type-badge w-10 h-10 rounded-lg flex items-center justify-center
                                            {{ $question->question_type === 'mcq' ? 'bg-blue-100 dark:bg-blue-900/30' : ($question->question_type === 'true_false' ? 'bg-orange-100 dark:bg-orange-900/30' : 'bg-green-100 dark:bg-green-900/30') }}">
                                            @if($question->question_type === 'mcq')
                                                <img src="{{ asset('images/mcq.png') }}" alt="MCQ" class="w-5 h-5">
                                            @elseif($question->question_type === 'descriptive')
                                                <img src="{{ asset('images/cq.png') }}" alt="CQ" class="w-5 h-5">
                                            @else
                                                <svg class="w-5 h-5 text-orange-600 dark:text-orange-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                                </svg>
                                            @endif
                                        </div>
                                        <div>
                                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold
                                                {{ $question->question_type === 'mcq' ? 'bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-300' : ($question->question_type === 'true_false' ? 'bg-orange-100 text-orange-800 dark:bg-orange-900/30 dark:text-orange-300' : 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-300') }}">
                                                {{ $question->question_type === 'mcq' ? 'MCQ' : ($question->question_type === 'true_false' ? 'T/F' : 'Descriptive') }}
                                            </span>
                                        </div>
                                    </div>
                                    
                                    <!-- Action Buttons -->
                                    <div class="flex gap-2">
                                        <a href="{{ route('partner.questions.common-view', $question) }}" 
                                           class="p-2 bg-green-500 hover:bg-green-600 text-white rounded-lg transition-all duration-200 group">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                            </svg>
                                        </a>
                                        @if($question->question_type === 'descriptive')
                                            <a href="{{ route('partner.questions.descriptive.edit', $question) }}" 
                                               class="p-2 bg-blue-500 hover:bg-blue-600 text-white rounded-lg transition-all duration-200 group">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                                </svg>
                                            </a>
                                        @elseif($question->question_type === 'mcq')
                                            <a href="{{ route('partner.questions.mcq.edit', $question) }}" 
                                               class="p-2 bg-blue-500 hover:bg-blue-600 text-white rounded-lg transition-all duration-200 group">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                                </svg>
                                            </a>
                                        @elseif($question->question_type === 'true_false')
                                            <a href="{{ route('partner.questions.tf.edit', $question) }}" 
                                               class="p-2 bg-blue-500 hover:bg-blue-600 text-white rounded-lg transition-all duration-200 group">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                                </svg>
                                            </a>
                                        @else
                                            <a href="{{ route('partner.questions.edit', $question) }}" 
                                               class="p-2 bg-blue-500 hover:bg-blue-600 text-white rounded-lg transition-all duration-200 group">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                                </svg>
                                            </a>
                                        @endif
                                    </div>
                                </div>
                                
                                <!-- Question Content -->
                                <div class="mb-4">
                                    <div class="text-gray-900 dark:text-white text-sm leading-relaxed line-clamp-3">
                                        {!! Str::limit(strip_tags($question->question_text, '<b><i><u><strong><em><br><p><span><div>'), 150) !!}
                                    </div>
                                </div>
                                
                                <!-- Question Metadata -->
                                <div class="space-y-2 text-xs text-gray-600 dark:text-gray-400">
                                    <div class="flex items-center gap-2">
                                        <svg class="w-3 h-3 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                        </svg>
                                        <span class="font-medium">{{ $question->course->name ?? 'N/A' }}</span>
                                    </div>
                                    <div class="flex items-center gap-2">
                                        <svg class="w-3 h-3 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                        </svg>
                                        <span class="font-medium">{{ $question->subject->name ?? 'N/A' }}</span>
                                    </div>
                                    <div class="flex items-center gap-2">
                                        <svg class="w-3 h-3 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                                        </svg>
                                        <span class="font-medium">{{ $question->topic->name ?? 'N/A' }}</span>
                                    </div>
                                    <div class="flex items-center gap-2">
                                        <svg class="w-3 h-3 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                        <span class="font-medium">{{ $question->created_at->format('M d, Y') }}</span>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                
                <!-- Pagination -->
                <div class="bg-gray-50 dark:bg-gray-700 px-6 py-4 border-t border-gray-200 dark:border-gray-600">
                    <div class="flex justify-center">
                        {{ $questions->links() }}
                    </div>
                </div>
            @else
                <!-- Empty State -->
                <div class="p-12 text-center questions-container">
                    <div class="max-w-md mx-auto">
                        <div class="w-20 h-20 bg-gradient-to-br from-blue-100 to-green-100 dark:from-blue-900/30 dark:to-green-900/30 rounded-full flex items-center justify-center mx-auto mb-6">
                            <svg class="w-10 h-10 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-3">
                            @if(request('search'))
                                No questions found for "{{ request('search') }}"
                            @else
                                No questions found
                            @endif
                        </h3>
                        <p class="text-gray-600 dark:text-gray-400 mb-8">
                            @if(request('search'))
                                Try adjusting your search terms or filters to find what you're looking for.
                            @else
                                Get started by creating your first question to build your question bank.
                            @endif
                        </p>
                        <div class="flex flex-wrap gap-3 justify-center">
                            <a href="{{ route('partner.questions.mcq.create') }}" class="px-6 py-3 bg-blue-500 hover:bg-blue-600 text-white rounded-lg transition-all duration-200 flex items-center gap-2 font-medium">
                                <img src="{{ asset('images/mcq.png') }}" alt="MCQ" class="w-4 h-4">
                                Create MCQ
                            </a>
                            <a href="{{ route('partner.questions.descriptive.create') }}" class="px-6 py-3 bg-green-500 hover:bg-green-600 text-white rounded-lg transition-all duration-200 flex items-center gap-2 font-medium">
                                <img src="{{ asset('images/cq.png') }}" alt="CQ" class="w-4 h-4">
                                Create Descriptive
                            </a>
                            <a href="{{ route('partner.questions.tf.create') }}" class="px-6 py-3 bg-orange-500 hover:bg-orange-600 text-white rounded-lg transition-all duration-200 flex items-center gap-2 font-medium">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                Create T/F
                            </a>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>

<style>
.questions-container.updating {
    opacity: 0.6;
    pointer-events: none;
}

.filter-group select:disabled {
    background-color: #f9fafb;
    color: #6b7280;
    cursor: not-allowed;
}

.line-clamp-3 {
    display: -webkit-box;
    -webkit-line-clamp: 3;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

/* Mobile optimizations */
@media (max-width: 640px) {
    .questions-container .question-card {
        padding: 1rem;
    }
    
    .questions-container .grid {
        grid-template-columns: 1fr;
        gap: 1rem;
    }
}

/* Animation for question cards */
@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.question-card {
    animation: fadeInUp 0.3s ease-out;
}

/* Loading state for cards */
.question-card.loading {
    background: linear-gradient(90deg, #f0f0f0 25%, #e0e0e0 50%, #f0f0f0 75%);
    background-size: 200% 100%;
    animation: shimmer 1.5s infinite;
}

.dark .question-card.loading {
    background: linear-gradient(90deg, #374151 25%, #4b5563 50%, #374151 75%);
    background-size: 200% 100%;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Get elements
    const searchInput = document.getElementById('searchInput');
    const searchHidden = document.getElementById('searchHidden');
    const searchLoading = document.getElementById('searchLoading');
    const filterForm = document.getElementById('filterForm');
    const questionsContainer = document.querySelector('.questions-container');
    
    const courseFilter = document.getElementById('course_filter');
    const subjectFilter = document.getElementById('subject_filter');
    const topicFilter = document.getElementById('topic_filter');
    const questionTypeFilter = document.getElementById('question_type_filter');
    const clearAllFiltersBtn = document.getElementById('clearAllFilters');
    const refreshQuestionsBtn = document.getElementById('refreshQuestions');
    
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
        
        if (searchLoading) searchLoading.classList.remove('hidden');
        
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
    
    
    if (clearAllFiltersBtn) {
        clearAllFiltersBtn.addEventListener('click', function() {
            console.log('Clear all filters clicked');
            
            // Clear all filter values
            if (courseFilter) courseFilter.value = '';
            if (subjectFilter) subjectFilter.value = '';
            if (topicFilter) topicFilter.value = '';
            if (questionTypeFilter) questionTypeFilter.value = '';
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
    function performAjaxSearch() {
        const searchValue = searchInput.value;
        const currentUrl = new URL(window.location);
        
        // Add updating class to questions container
        if (questionsContainer) {
            questionsContainer.classList.add('updating');
        }
        
        // Show loading indicators
        if (searchLoading) searchLoading.classList.remove('hidden');
        
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
            
            // Extract the questions grid and pagination
            const newQuestionsGrid = tempDiv.querySelector('.questions-container .grid');
            const newEmptyState = tempDiv.querySelector('.p-12.text-center');
            const newPagination = tempDiv.querySelector('.bg-gray-50.dark\\:bg-gray-700');
            const newQuestionsCount = tempDiv.querySelector('.text-sm.text-gray-600.dark\\:text-gray-400');
            
            console.log('Extracted elements:', {
                questionsGrid: newQuestionsGrid ? 'found' : 'not found',
                emptyState: newEmptyState ? 'found' : 'not found',
                pagination: newPagination ? 'found' : 'not found',
                questionsCount: newQuestionsCount ? newQuestionsCount.textContent : 'not found'
            });
            
            // Update the page content
            const existingQuestionsContainer = document.querySelector('.questions-container');
            if (existingQuestionsContainer) {
                if (newQuestionsGrid) {
                    // There are questions - show the questions grid
                    console.log('Updating with questions grid');
                    existingQuestionsContainer.innerHTML = newQuestionsGrid.outerHTML;
                    
                    // Count questions in the new content
                    const questionItems = newQuestionsGrid.querySelectorAll('[data-question-id]');
                    console.log('Questions displayed after update:', questionItems.length);
                } else if (newEmptyState) {
                    // No questions - show empty state
                    console.log('Updating with empty state');
                    existingQuestionsContainer.innerHTML = newEmptyState.outerHTML;
                    console.log('Empty state displayed');
                }
            }
            
            if (newPagination) {
                const existingPagination = document.querySelector('.bg-gray-50.dark\\:bg-gray-700');
                if (existingPagination) {
                    existingPagination.innerHTML = newPagination.innerHTML;
                }
            }
            
            if (newQuestionsCount) {
                const existingQuestionsCount = document.querySelector('.text-sm.text-gray-600.dark\\:text-gray-400');
                if (existingQuestionsCount) {
                    existingQuestionsCount.textContent = newQuestionsCount.textContent;
                }
            }
            
            // Hide loading indicators
            if (searchLoading) searchLoading.classList.add('hidden');
            if (questionsContainer) {
                questionsContainer.classList.remove('updating');
            }
        })
        .catch(error => {
            console.error('Search error:', error);
            // Hide loading indicators on error
            if (searchLoading) searchLoading.classList.add('hidden');
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
    
    // Dropdown Menu Functionality
    const dropdownButton = document.querySelector('.group button');
    const dropdownMenu = document.querySelector('.group .absolute');
    let isMenuOpen = false;
    
    // Toggle dropdown on click
    dropdownButton.addEventListener('click', function(e) {
        e.preventDefault();
        e.stopPropagation();
        
        isMenuOpen = !isMenuOpen;
        
        if (isMenuOpen) {
            dropdownMenu.classList.add('show');
            dropdownMenu.style.opacity = '1';
            dropdownMenu.style.visibility = 'visible';
            dropdownMenu.style.transform = 'translateY(0)';
        } else {
            dropdownMenu.classList.remove('show');
            dropdownMenu.style.opacity = '0';
            dropdownMenu.style.visibility = 'hidden';
            dropdownMenu.style.transform = 'translateY(8px)';
        }
    });
    
    // Close dropdown when clicking outside
    document.addEventListener('click', function(e) {
        if (!dropdownButton.contains(e.target) && !dropdownMenu.contains(e.target)) {
            isMenuOpen = false;
            dropdownMenu.classList.remove('show');
            dropdownMenu.style.opacity = '0';
            dropdownMenu.style.visibility = 'hidden';
            dropdownMenu.style.transform = 'translateY(8px)';
        }
    });
    
    // Add click animation to menu items
    const menuItems = document.querySelectorAll('.menu-item');
    menuItems.forEach(item => {
        item.addEventListener('click', function() {
            // Add a small delay to show the click animation
            this.style.transform = 'scale(0.98)';
            setTimeout(() => {
                this.style.transform = 'scale(1)';
            }, 150);
        });
    });
    
    // Add keyboard navigation
    dropdownButton.addEventListener('keydown', function(e) {
        if (e.key === 'Enter' || e.key === ' ') {
            e.preventDefault();
            dropdownButton.click();
        }
    });
    
    // Close dropdown on Escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape' && isMenuOpen) {
            isMenuOpen = false;
            dropdownMenu.classList.remove('show');
            dropdownMenu.style.opacity = '0';
            dropdownMenu.style.visibility = 'hidden';
            dropdownMenu.style.transform = 'translateY(8px)';
        }
    });
});
</script>
@endsection
