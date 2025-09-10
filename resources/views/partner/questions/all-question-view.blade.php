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
    
    /* Professional Filter Section Styling */
    .filter-section {
        background: linear-gradient(135deg, rgba(255,255,255,0.9), rgba(248,250,252,0.8));
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255,255,255,0.2);
    }
    
    .dark .filter-section {
        background: linear-gradient(135deg, rgba(31,41,55,0.9), rgba(17,24,39,0.8));
        border: 1px solid rgba(255,255,255,0.1);
    }
    
    .filter-select {
        background: linear-gradient(135deg, #ffffff, #f8fafc);
        border: 2px solid #e2e8f0;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }
    
    .filter-select:hover {
        border-color: #3b82f6;
        box-shadow: 0 4px 6px -1px rgba(59, 130, 246, 0.1);
        transform: translateY(-1px);
    }
    
    .filter-select:focus {
        border-color: #3b82f6;
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1), 0 4px 6px -1px rgba(59, 130, 246, 0.1);
        transform: translateY(-1px);
    }
    
    .dark .filter-select {
        background: linear-gradient(135deg, #1f2937, #111827);
        border-color: #374151;
    }
    
    .dark .filter-select:hover {
        border-color: #60a5fa;
        box-shadow: 0 4px 6px -1px rgba(96, 165, 250, 0.1);
    }
    
    .dark .filter-select:focus {
        border-color: #60a5fa;
        box-shadow: 0 0 0 3px rgba(96, 165, 250, 0.1), 0 4px 6px -1px rgba(96, 165, 250, 0.1);
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
    <div class="container mx-auto px-4 py-4 space-y-2 relative" style="padding-bottom: 200px;">
        <!-- Header Section -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl border border-gray-200 dark:border-gray-700 overflow-visible relative z-40">
            <div class="bg-gradient-to-r from-blue-600 to-indigo-600 px-6 py-8">
                <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-6">
                    <div class="flex items-center gap-4">
                        <div class="w-10 h-10 sm:w-12 sm:h-12 bg-white/20 rounded-xl flex items-center justify-center backdrop-blur-sm">
                            <svg class="w-5 h-5 sm:w-6 sm:h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div>
                            <h1 class="text-xl sm:text-2xl lg:text-3xl font-bold text-white">Question Bank</h1>
                            <p class="text-blue-100 mt-1 text-sm sm:text-base">Manage and organize your questions efficiently</p>
                        </div>
                    </div>
                    
                    <!-- Action Buttons -->
                    <div class="flex gap-2 sm:gap-3">
                        <a href="{{ route('partner.questions.drafts') }}" 
                           class="px-3 py-2 sm:px-4 bg-yellow-500 hover:bg-yellow-600 text-white rounded-lg transition-all duration-200 flex items-center gap-1 sm:gap-2 font-medium text-sm sm:text-base">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                            <span class="hidden sm:inline">Drafts</span>
                            <span class="sm:hidden">Drafts</span>
                        </a>
                        
                        <div class="relative group">
                            <button class="px-3 py-2 sm:px-4 bg-green-500 hover:bg-green-600 text-white rounded-lg transition-all duration-200 flex items-center gap-1 sm:gap-2 font-medium text-sm sm:text-base">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                </svg>
                                <span class="hidden sm:inline">Add Question</span>
                                <span class="sm:hidden">Add</span>
                                <svg class="w-3 h-3 transition-transform group-hover:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </button>
                            
                            <!-- New Dropdown Menu -->
                            <div class="absolute right-0 top-full mt-2 w-56 bg-white dark:bg-gray-800 rounded-xl shadow-2xl border border-gray-200 dark:border-gray-700 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300 transform translate-y-2 group-hover:translate-y-0 z-50">
                                <div class="py-2">
                                    <!-- Multiple Choice -->
                                    <a href="{{ route('partner.questions.mcq.create') }}" class="flex items-center px-4 py-3 text-gray-700 dark:text-gray-300 hover:bg-blue-50 dark:hover:bg-blue-900/20 transition-colors">
                                        <img src="{{ asset('images/mcq.png') }}" alt="MCQ" class="w-5 h-5 mr-3">
                                        <span class="font-medium">Multiple Choice</span>
                                    </a>
                                    
                                    <!-- Descriptive -->
                                    <a href="{{ route('partner.questions.descriptive.create') }}" class="flex items-center px-4 py-3 text-gray-700 dark:text-gray-300 hover:bg-green-50 dark:hover:bg-green-900/20 transition-colors">
                                        <img src="{{ asset('images/cq.png') }}" alt="CQ" class="w-5 h-5 mr-3">
                                        <span class="font-medium">Descriptive</span>
                                    </a>
                                    
                                    <!-- True/False -->
                                    <a href="{{ route('partner.questions.tf.create') }}" class="flex items-center px-4 py-3 text-gray-700 dark:text-gray-300 hover:bg-orange-50 dark:hover:bg-orange-900/20 transition-colors">
                                        <svg class="w-5 h-5 mr-3 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        <span class="font-medium">True/False</span>
                                    </a>
                                    
                                    <!-- Divider -->
                                    <div class="border-t border-gray-200 dark:border-gray-600 my-1"></div>
                                    
                                    <!-- Bulk Upload -->
                                    <a href="{{ route('partner.questions.bulk-upload') }}" class="flex items-center px-4 py-3 text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700/20 transition-colors">
                                        <svg class="w-5 h-5 mr-3 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                                        </svg>
                                        <span class="font-medium">Bulk Upload</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
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
        </div>


        <!-- Search and Filters Section -->
        <div class="bg-gradient-to-br from-white to-gray-50 dark:from-gray-800 dark:to-gray-900 rounded-2xl shadow-xl border border-gray-200 dark:border-gray-700 overflow-visible backdrop-blur-sm relative z-20">
            <div class="py-4 px-4 sm:px-6">
                <form method="GET" id="filterForm" class="space-y-6">
                    <input type="hidden" name="search" id="searchHidden" value="{{ request('search') }}">
                    
                    <!-- Filters Grid -->
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-4">
                        <div class="space-y-2">
                            <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Course</label>
                            <select name="course_filter" id="course_filter" class="filter-select w-full rounded-xl p-3 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-300 shadow-sm hover:shadow-md focus:shadow-lg">
                                <option value="">All Courses</option>
                            </select>
                        </div>
                        
                        <div class="space-y-2">
                            <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Subject</label>
                            <select name="subject_filter" id="subject_filter" class="filter-select w-full rounded-xl p-3 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-300 shadow-sm hover:shadow-md focus:shadow-lg">
                                <option value="">All Subjects</option>
                            </select>
                        </div>
                        
                        <div class="space-y-2">
                            <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Topic</label>
                            <select name="topic_filter" id="topic_filter" class="filter-select w-full rounded-xl p-3 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-300 shadow-sm hover:shadow-md focus:shadow-lg">
                                <option value="">All Topics</option>
                            </select>
                        </div>
                        
                        <div class="space-y-2">
                            <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Question Type</label>
                            <select name="question_type_filter" id="question_type_filter" class="filter-select w-full rounded-xl p-3 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-300 shadow-sm hover:shadow-md focus:shadow-lg">
                                <option value="">All Types</option>
                            </select>
                        </div>
                        
                        <div class="space-y-2">
                            <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Date Created</label>
                            <select name="date_filter" 
                                    id="date_filter" 
                                    class="filter-select w-full rounded-xl p-3 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-300 shadow-sm hover:shadow-md focus:shadow-lg">
                                <option value="">All Dates</option>
                            </select>
                        </div>
                    </div>
                    
                    <!-- Search Bar with Action Buttons -->
                    <div class="flex flex-col lg:flex-row gap-2">
                        <!-- Search Bar -->
                        <div class="flex-1">
                            <div class="flex items-center w-full bg-white dark:bg-gray-700 rounded-full shadow-lg p-1 border border-gray-200 dark:border-gray-600">
                            
                                <!-- Input Field -->
                                <input 
                                    type="text" 
                                    id="searchInput"
                                    placeholder="Search by course, subject, topic, question, answer or tag" 
                                    class="flex-grow py-2 px-2 text-gray-800 dark:text-white focus:outline-none placeholder-gray-400 dark:placeholder-gray-500 rounded-full bg-transparent text-base"
                                    value="{{ request('search') }}"
                                />
                                <!-- Action Button with SVG Search Icon -->
         
                                
                            </div>
                          
                        </div>
                        
                        <!-- Action Buttons -->
                        <div class="flex gap-3 flex-shrink-0">
                            <button type="button" id="refreshQuestions" class="px-6 py-3 bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white rounded-xl transition-all duration-300 flex items-center gap-2 font-medium shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                                </svg>
                                Refresh
                            </button>
                            <button type="button" id="clearAllFilters" class="px-6 py-3 bg-gradient-to-r from-gray-500 to-gray-600 hover:from-gray-600 hover:to-gray-700 text-white rounded-xl transition-all duration-300 font-medium shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                                Clear Filters
                            </button>
                        </div>
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
                        <p class="text-sm text-gray-600 dark:text-gray-400">Showing {{ $questions->count() }} questions</p>
                    </div>
                    <div class="flex items-center gap-2 text-sm text-gray-500 dark:text-gray-400">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1a3 3 0 01-3-3V6a3 3 0 013-3h1m-1 0v18m0 0h1a3 3 0 013 3v7a3 3 0 01-3 3h-1"></path>
                        </svg>
                        <span>{{ $questions->count() }} total</span>
                    </div>
                </div>
            </div>

            @if($questions->count() > 0)
                <!-- Questions List - Compact Single Column -->
                <div class="questions-container">
                    @foreach($questions as $question)
                        <div class="question-card border-b border-gray-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors duration-200" data-question-id="{{ $question->id }}">
                            <div class="px-4 py-3">
                                <!-- Mobile-First Question Layout -->
                                <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-3 mb-2">
                                    <!-- Top Row: Type Badge, ID, and Actions (Mobile) / Left Side (Desktop) -->
                                    <div class="flex items-center justify-between sm:justify-start gap-3 flex-1 min-w-0">
                                        <div class="flex items-center gap-2 flex-shrink-0">
                                            <div class="w-6 h-6 rounded-md flex items-center justify-center
                                                {{ $question->question_type === 'mcq' ? 'bg-blue-100 dark:bg-blue-900/30' : ($question->question_type === 'true_false' ? 'bg-orange-100 dark:bg-orange-900/30' : 'bg-green-100 dark:bg-green-900/30') }}">
                                                @if($question->question_type === 'mcq')
                                                    <img src="{{ asset('images/mcq.png') }}" alt="MCQ" class="w-4 h-4">
                                                @elseif($question->question_type === 'descriptive')
                                                    <img src="{{ asset('images/cq.png') }}" alt="CQ" class="w-4 h-4">
                                                @else
                                                    <svg class="w-4 h-4 text-orange-600 dark:text-orange-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                                    </svg>
                                                @endif
                                            </div>
                                            <span class="text-xs font-semibold text-gray-500 dark:text-gray-400">#{{ $question->id }}</span>
                                        </div>
                                        
                                        <span class="inline-flex items-center px-2 py-1 rounded-md text-xs font-medium flex-shrink-0
                                            {{ $question->question_type === 'mcq' ? 'bg-blue-100 text-blue-700 dark:bg-blue-900/30 dark:text-blue-300' : ($question->question_type === 'true_false' ? 'bg-orange-100 text-orange-700 dark:bg-orange-900/30 dark:text-orange-300' : 'bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-300') }}">
                                            {{ $question->question_type === 'mcq' ? 'MCQ' : ($question->question_type === 'true_false' ? 'T/F' : 'Descriptive') }}
                                        </span>
                                        
                                        <!-- Question Text with Answer Options - Right after type badge on desktop -->
                                        <div class="hidden sm:block text-gray-900 dark:text-white text-sm leading-relaxed flex-1 min-w-0">
                                            <span class="text-gray-900 dark:text-white">
                                                {!! Str::limit(strip_tags($question->question_text, '<b><i><u><strong><em><br><p><span><div>'), 200) !!}
                                            </span>
                                            
                                            @if($question->question_type === 'mcq' && ($question->option_a || $question->option_b || $question->option_c || $question->option_d))
                                                <span class="text-gray-500 dark:text-gray-400 ml-2">|</span>
                                                <span class="text-gray-600 dark:text-gray-300 text-xs ml-1">
                                                    @if($question->option_a)
                                                        <span class="inline-flex items-center justify-center w-4 h-4 rounded-full text-xs font-bold mr-1 border-2
                                                            {{ $question->correct_answer === 'A' || $question->correct_answer === 'a' ? 'bg-green-100 text-green-700 border-green-500 dark:bg-green-900 dark:text-green-300 dark:border-green-400' : 'bg-white text-black border-gray-800 dark:bg-gray-800 dark:text-white dark:border-gray-200' }}">
                                                            A
                                                        </span>
                                                        <span class="text-xs">{{ Str::limit(strip_tags($question->option_a), 18) }}</span>
                                                    @endif
                                                    @if($question->option_b)
                                                        <span class="text-gray-400 mx-1">•</span>
                                                        <span class="inline-flex items-center justify-center w-4 h-4 rounded-full text-xs font-bold mr-1 border-2
                                                            {{ $question->correct_answer === 'B' || $question->correct_answer === 'b' ? 'bg-green-100 text-green-700 border-green-500 dark:bg-green-900 dark:text-green-300 dark:border-green-400' : 'bg-white text-black border-gray-800 dark:bg-gray-800 dark:text-white dark:border-gray-200' }}">
                                                            B
                                                        </span>
                                                        <span class="text-xs">{{ Str::limit(strip_tags($question->option_b), 18) }}</span>
                                                    @endif
                                                    @if($question->option_c)
                                                        <span class="text-gray-400 mx-1">•</span>
                                                        <span class="inline-flex items-center justify-center w-4 h-4 rounded-full text-xs font-bold mr-1 border-2
                                                            {{ $question->correct_answer === 'C' || $question->correct_answer === 'c' ? 'bg-green-100 text-green-700 border-green-500 dark:bg-green-900 dark:text-green-300 dark:border-green-400' : 'bg-white text-black border-gray-800 dark:bg-gray-800 dark:text-white dark:border-gray-200' }}">
                                                            C
                                                        </span>
                                                        <span class="text-xs">{{ Str::limit(strip_tags($question->option_c), 18) }}</span>
                                                    @endif
                                                    @if($question->option_d)
                                                        <span class="text-gray-400 mx-1">•</span>
                                                        <span class="inline-flex items-center justify-center w-4 h-4 rounded-full text-xs font-bold mr-1 border-2
                                                            {{ $question->correct_answer === 'D' || $question->correct_answer === 'd' ? 'bg-green-100 text-green-700 border-green-500 dark:bg-green-900 dark:text-green-300 dark:border-green-400' : 'bg-white text-black border-gray-800 dark:bg-gray-800 dark:text-white dark:border-gray-200' }}">
                                                            D
                                                        </span>
                                                        <span class="text-xs">{{ Str::limit(strip_tags($question->option_d), 18) }}</span>
                                                    @endif
                                                </span>
                                            @elseif($question->question_type === 'true_false')
                                                <span class="text-gray-500 dark:text-gray-400 ml-2">|</span>
                                                <span class="text-gray-600 dark:text-gray-300 text-xs ml-1">
                                                    <span class="inline-flex items-center justify-center w-4 h-4 rounded-full text-xs font-bold mr-1 border-2
                                                        {{ $question->correct_answer === 'A' || $question->correct_answer === 'a' || $question->correct_answer === 'true' || $question->correct_answer === 'True' ? 'bg-green-100 text-green-700 border-green-500 dark:bg-green-900 dark:text-green-300 dark:border-green-400' : 'bg-white text-black border-gray-800 dark:bg-gray-800 dark:text-white dark:border-gray-200' }}">
                                                        A
                                                    </span>
                                                    <span class="text-xs">{{ $question->option_a ? Str::limit(strip_tags($question->option_a), 28) : 'True' }}</span>
                                                    <span class="text-gray-400 mx-1">•</span>
                                                    <span class="inline-flex items-center justify-center w-4 h-4 rounded-full text-xs font-bold mr-1 border-2
                                                        {{ $question->correct_answer === 'B' || $question->correct_answer === 'b' || $question->correct_answer === 'false' || $question->correct_answer === 'False' ? 'bg-green-100 text-green-700 border-green-500 dark:bg-green-900 dark:text-green-300 dark:border-green-400' : 'bg-white text-black border-gray-800 dark:bg-gray-800 dark:text-white dark:border-gray-200' }}">
                                                        B
                                                    </span>
                                                    <span class="text-xs">{{ $question->option_b ? Str::limit(strip_tags($question->option_b), 28) : 'False' }}</span>
                                                </span>
                                            @elseif($question->question_type === 'fill_in_blank' && $question->option_a)
                                                <span class="text-gray-500 dark:text-gray-400 ml-2">|</span>
                                                <span class="text-gray-600 dark:text-gray-300 text-xs ml-1">
                                                    <span class="inline-flex items-center justify-center w-4 h-4 rounded-full text-xs font-bold mr-1 border-2 bg-green-100 text-green-700 border-green-500 dark:bg-green-900 dark:text-green-300 dark:border-green-400">
                                                        ✓
                                                    </span>
                                                    <span class="text-xs">{{ Str::limit(strip_tags($question->option_a), 38) }}</span>
                                                </span>
                                            @endif
                                        </div>
                                        
                                        <!-- Actions - Mobile -->
                                        <div class="flex items-center gap-1 sm:hidden">
                                            <a href="{{ route('partner.questions.common-view', $question) }}" 
                                               class="p-1.5 text-gray-400 hover:text-green-600 hover:bg-green-50 dark:hover:bg-green-900/20 rounded transition-all duration-200" 
                                               title="View">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                                </svg>
                                            </a>
                                            @if($question->question_type === 'descriptive')
                                                <a href="{{ route('partner.questions.descriptive.edit', $question) }}" 
                                                   class="p-1.5 text-gray-400 hover:text-blue-600 hover:bg-blue-50 dark:hover:bg-blue-900/20 rounded transition-all duration-200" 
                                                   title="Edit">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                                    </svg>
                                                </a>
                                            @elseif($question->question_type === 'mcq')
                                                <a href="{{ route('partner.questions.mcq.edit', $question) }}" 
                                                   class="p-1.5 text-gray-400 hover:text-blue-600 hover:bg-blue-50 dark:hover:bg-blue-900/20 rounded transition-all duration-200" 
                                                   title="Edit">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                                    </svg>
                                                </a>
                                            @elseif($question->question_type === 'true_false')
                                                <a href="{{ route('partner.questions.tf.edit', $question) }}" 
                                                   class="p-1.5 text-gray-400 hover:text-blue-600 hover:bg-blue-50 dark:hover:bg-blue-900/20 rounded transition-all duration-200" 
                                                   title="Edit">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                                    </svg>
                                                </a>
                                            @endif
                                        </div>
                                    </div>
                                    
                                    <!-- Question Text - Full Width on Mobile -->
                                    <div class="w-full sm:hidden">
                                        <div class="text-gray-900 dark:text-white text-sm leading-relaxed mb-2">
                                            {!! Str::limit(strip_tags($question->question_text, '<b><i><u><strong><em><br><p><span><div>'), 200) !!}
                                        </div>
                                        
                                        <!-- Answer Options - Stacked on Mobile -->
                                        @if($question->question_type === 'mcq' && ($question->option_a || $question->option_b || $question->option_c || $question->option_d))
                                            <div class="flex flex-wrap gap-2 text-xs">
                                                @if($question->option_a)
                                                    <div class="flex items-center gap-1">
                                                        <span class="inline-flex items-center justify-center w-4 h-4 rounded-full text-xs font-bold border-2
                                                            {{ $question->correct_answer === 'A' || $question->correct_answer === 'a' ? 'bg-green-100 text-green-700 border-green-500 dark:bg-green-900 dark:text-green-300 dark:border-green-400' : 'bg-white text-black border-gray-800 dark:bg-gray-800 dark:text-white dark:border-gray-200' }}">
                                                            A
                                                        </span>
                                                        <span class="text-gray-600 dark:text-gray-300">{{ Str::limit(strip_tags($question->option_a), 25) }}</span>
                                                    </div>
                                                @endif
                                                @if($question->option_b)
                                                    <div class="flex items-center gap-1">
                                                        <span class="inline-flex items-center justify-center w-4 h-4 rounded-full text-xs font-bold border-2
                                                            {{ $question->correct_answer === 'B' || $question->correct_answer === 'b' ? 'bg-green-100 text-green-700 border-green-500 dark:bg-green-900 dark:text-green-300 dark:border-green-400' : 'bg-white text-black border-gray-800 dark:bg-gray-800 dark:text-white dark:border-gray-200' }}">
                                                            B
                                                        </span>
                                                        <span class="text-gray-600 dark:text-gray-300">{{ Str::limit(strip_tags($question->option_b), 25) }}</span>
                                                    </div>
                                                @endif
                                                @if($question->option_c)
                                                    <div class="flex items-center gap-1">
                                                        <span class="inline-flex items-center justify-center w-4 h-4 rounded-full text-xs font-bold border-2
                                                            {{ $question->correct_answer === 'C' || $question->correct_answer === 'c' ? 'bg-green-100 text-green-700 border-green-500 dark:bg-green-900 dark:text-green-300 dark:border-green-400' : 'bg-white text-black border-gray-800 dark:bg-gray-800 dark:text-white dark:border-gray-200' }}">
                                                            C
                                                        </span>
                                                        <span class="text-gray-600 dark:text-gray-300">{{ Str::limit(strip_tags($question->option_c), 25) }}</span>
                                                    </div>
                                                @endif
                                                @if($question->option_d)
                                                    <div class="flex items-center gap-1">
                                                        <span class="inline-flex items-center justify-center w-4 h-4 rounded-full text-xs font-bold border-2
                                                            {{ $question->correct_answer === 'D' || $question->correct_answer === 'd' ? 'bg-green-100 text-green-700 border-green-500 dark:bg-green-900 dark:text-green-300 dark:border-green-400' : 'bg-white text-black border-gray-800 dark:bg-gray-800 dark:text-white dark:border-gray-200' }}">
                                                            D
                                                        </span>
                                                        <span class="text-gray-600 dark:text-gray-300">{{ Str::limit(strip_tags($question->option_d), 25) }}</span>
                                                    </div>
                                                @endif
                                            </div>
                                        @elseif($question->question_type === 'true_false')
                                            <div class="flex flex-wrap gap-3 text-xs">
                                                <div class="flex items-center gap-1">
                                                    <span class="inline-flex items-center justify-center w-4 h-4 rounded-full text-xs font-bold border-2
                                                        {{ $question->correct_answer === 'A' || $question->correct_answer === 'a' || $question->correct_answer === 'true' || $question->correct_answer === 'True' ? 'bg-green-100 text-green-700 border-green-500 dark:bg-green-900 dark:text-green-300 dark:border-green-400' : 'bg-white text-black border-gray-800 dark:bg-gray-800 dark:text-white dark:border-gray-200' }}">
                                                        A
                                                    </span>
                                                    <span class="text-gray-600 dark:text-gray-300">{{ $question->option_a ? Str::limit(strip_tags($question->option_a), 30) : 'True' }}</span>
                                                </div>
                                                <div class="flex items-center gap-1">
                                                    <span class="inline-flex items-center justify-center w-4 h-4 rounded-full text-xs font-bold border-2
                                                        {{ $question->correct_answer === 'B' || $question->correct_answer === 'b' || $question->correct_answer === 'false' || $question->correct_answer === 'False' ? 'bg-green-100 text-green-700 border-green-500 dark:bg-green-900 dark:text-green-300 dark:border-green-400' : 'bg-white text-black border-gray-800 dark:bg-gray-800 dark:text-white dark:border-gray-200' }}">
                                                        B
                                                    </span>
                                                    <span class="text-gray-600 dark:text-gray-300">{{ $question->option_b ? Str::limit(strip_tags($question->option_b), 30) : 'False' }}</span>
                                                </div>
                                            </div>
                                        @elseif($question->question_type === 'fill_in_blank' && $question->option_a)
                                            <div class="flex items-center gap-1 text-xs">
                                                <span class="inline-flex items-center justify-center w-4 h-4 rounded-full text-xs font-bold border-2 bg-green-100 text-green-700 border-green-500 dark:bg-green-900 dark:text-green-300 dark:border-green-400">
                                                    ✓
                                                </span>
                                                <span class="text-gray-600 dark:text-gray-300">{{ Str::limit(strip_tags($question->option_a), 40) }}</span>
                                            </div>
                                        @endif
                                    </div>
                                    
                                    
                                    <!-- Actions - Desktop -->
                                    <div class="hidden sm:flex items-center gap-1 flex-shrink-0 ml-3">
                                        <a href="{{ route('partner.questions.common-view', $question) }}" 
                                           class="p-1.5 text-gray-400 hover:text-green-600 hover:bg-green-50 dark:hover:bg-green-900/20 rounded transition-all duration-200" 
                                           title="View">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                            </svg>
                                        </a>
                                        @if($question->question_type === 'descriptive')
                                            <a href="{{ route('partner.questions.descriptive.edit', $question) }}" 
                                               class="p-1.5 text-gray-400 hover:text-blue-600 hover:bg-blue-50 dark:hover:bg-blue-900/20 rounded transition-all duration-200" 
                                               title="Edit">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                                </svg>
                                            </a>
                                        @elseif($question->question_type === 'mcq')
                                            <a href="{{ route('partner.questions.mcq.edit', $question) }}" 
                                               class="p-1.5 text-gray-400 hover:text-blue-600 hover:bg-blue-50 dark:hover:bg-blue-900/20 rounded transition-all duration-200" 
                                               title="Edit">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                                </svg>
                                            </a>
                                        @elseif($question->question_type === 'true_false')
                                            <a href="{{ route('partner.questions.tf.edit', $question) }}" 
                                               class="p-1.5 text-gray-400 hover:text-blue-600 hover:bg-blue-50 dark:hover:bg-blue-900/20 rounded transition-all duration-200" 
                                               title="Edit">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                                </svg>
                                            </a>
                                        @else
                                            <a href="{{ route('partner.questions.edit', $question) }}" 
                                               class="p-1.5 text-gray-400 hover:text-blue-600 hover:bg-blue-50 dark:hover:bg-blue-900/20 rounded transition-all duration-200" 
                                               title="Edit">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                                </svg>
                                            </a>
                                        @endif
                                    </div>
                                </div>
                                
                                <!-- Metadata Row -->
                                <div class="flex flex-wrap items-center gap-4 text-xs text-gray-500 dark:text-gray-400">
                                    <div class="flex items-center gap-1">
                                        <svg class="w-3 h-3 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                        </svg>
                                        <span class="font-medium">{{ $question->course->name ?? 'N/A' }}</span>
                                    </div>
                                    <div class="flex items-center gap-1">
                                        <svg class="w-3 h-3 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                        </svg>
                                        <span class="font-medium">{{ $question->subject->name ?? 'N/A' }}</span>
                                    </div>
                                    <div class="flex items-center gap-1">
                                        <svg class="w-3 h-3 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                                        </svg>
                                        <span class="font-medium">{{ $question->topic->name ?? 'N/A' }}</span>
                                    </div>
                                    <div class="flex items-center gap-1">
                                        <svg class="w-3 h-3 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                        <span class="font-medium">{{ $question->created_at->format('M d, Y') }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
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

.line-clamp-2 {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
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
        padding: 0.5rem;
    }
    
    .questions-container .question-card .px-4 {
        padding-left: 0.5rem;
        padding-right: 0.5rem;
    }
    
    .questions-container .question-card .py-3 {
        padding-top: 0.5rem;
        padding-bottom: 0.5rem;
    }
    
    /* Ensure proper spacing on mobile */
    .questions-container .question-card .gap-3 {
        gap: 0.75rem;
    }
    
    /* Make answer options more compact on mobile */
    .questions-container .question-card .flex.flex-wrap.gap-2 {
        gap: 0.5rem;
    }
    
    .questions-container .question-card .flex.flex-wrap.gap-3 {
        gap: 0.75rem;
    }
    
    /* Smaller circles for mobile */
    .questions-container .question-card .w-4.h-4 {
        width: 0.875rem;
        height: 0.875rem;
    }
    
    /* Better text sizing for mobile */
    .questions-container .question-card .text-xs {
        font-size: 0.6875rem;
    }
    
    /* Ensure question text is readable on mobile */
    .questions-container .question-card .text-sm {
        font-size: 0.8125rem;
        line-height: 1.4;
    }
    
    /* Better spacing for metadata */
    .questions-container .question-card .gap-4 {
        gap: 0.75rem;
    }
}

/* Hover effects for better UX */
.question-card:hover {
    transform: translateY(-1px);
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
}

.question-card {
    transition: all 0.2s ease-in-out;
}

/* Answer options styling */
.question-card .text-gray-600 {
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

.question-card .line-clamp-2 {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
    white-space: normal;
}

/* Ensure answer options don't break the layout */
.question-card .flex-1 {
    min-width: 0;
    overflow: hidden;
}

/* Removed checkmark styling - no longer needed */

/* Circular answer option styling */
.question-card .inline-flex {
    flex-shrink: 0;
    min-width: 1.25rem;
    min-height: 1.25rem;
}

/* Ensure proper spacing between circular options */
.question-card .mx-1 {
    margin-left: 0.25rem;
    margin-right: 0.25rem;
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
    const dateFilter = document.getElementById('date_filter');
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
            
            // Debug: Log what we found in the response
            console.log('Available elements in response:', {
                questionsContainer: tempDiv.querySelector('.questions-container') ? 'found' : 'not found',
                gridElements: tempDiv.querySelectorAll('.grid').length,
                questionCards: tempDiv.querySelectorAll('[data-question-id]').length,
                allElements: Array.from(tempDiv.querySelectorAll('*')).map(el => el.className).filter(c => c)
            });
            
            // Debug: Check if there are any questions in the response
            const questionCards = tempDiv.querySelectorAll('[data-question-id]');
            console.log('Question cards found in response:', questionCards.length);
            if (questionCards.length > 0) {
                console.log('First question card:', questionCards[0].outerHTML.substring(0, 200));
            }
            
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
            
            // No pagination to update
            
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
            
            // Note: No need to reload available dates after search
            // The available dates don't change during a single session
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
    
    // Original AJAX Search Function (for non-date filters)
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
            
            // No pagination to update
            
            // Update questions count
            if (questionsCountElement && questionsCount) {
                questionsCountElement.textContent = questionsCount.textContent;
            }
            
            // Hide loading indicators
            if (searchLoading) searchLoading.classList.add('hidden');
            if (questionsContainer) {
                questionsContainer.classList.remove('updating');
            }
            
            // Note: No need to reload available dates after search
            // The available dates don't change during a single session
        })
        .catch(error => {
            console.error('Search error:', error);
            // Hide loading indicators on error
            if (searchLoading) searchLoading.classList.add('hidden');
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
    
});
</script>


@endsection
