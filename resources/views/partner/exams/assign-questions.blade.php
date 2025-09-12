@extends('layouts.partner-layout')

@section('title', 'Assign Questions to Exam')

@section('content')
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
    <div class="bg-white dark:bg-gray-800 shadow-sm border-b border-gray-200 dark:border-gray-700">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="py-6">
                <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
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

    <div class="container mx-auto px-4 py-4 space-y-2 relative" style="padding-bottom: 200px;">
        <!-- Display validation errors if any -->
        @if ($errors->any())
            <div class="bg-red-50 border border-red-200 rounded-lg p-4 mb-6">
                <div class="flex items-center">
                    <svg class="w-5 h-5 text-red-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                    </svg>
                    <h3 class="text-sm font-medium text-red-800">Please fix the following errors:</h3>
                </div>
                <ul class="mt-2 text-sm text-red-700 list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="space-y-6">

            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700">
                <form id="filterForm" action="{{ route('partner.exams.store-assigned-questions', $exam) }}" method="POST">
                    @csrf

                    <div class="px-6 py-6 border-b border-gray-200 dark:border-gray-700">
                        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-6">
                            <div class="flex-1">
                                <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-2">Select Questions</h2>
                            </div>
                        </div>
                    </div>

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

                    <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-700/50">
                    </div>
                    

                    <div class="bg-gradient-to-br from-white to-gray-50 dark:from-gray-800 dark:to-gray-900 rounded-2xl shadow-xl border border-gray-200 dark:border-gray-700 overflow-visible backdrop-blur-sm relative z-20">
                        <div class="py-2 px-3">
                            <form method="GET" id="searchFilterForm" class="space-y-3">
                                <input type="hidden" name="search" id="searchHidden" value="{{ request('search') }}">
                                
                                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-3">
                                    <div class="space-y-1">
                                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1">Course</label>
                                        <select name="course_filter" id="course-filter" class="filter-select w-full rounded-xl p-2 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-300 shadow-sm hover:shadow-md focus:shadow-lg">
                                            <option value="">All Courses</option>
                                            @foreach($courses as $course)
                                                <option value="{{ $course->id }}">{{ $course->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="space-y-1">
                                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1">Subject</label>
                                        <select name="subject_filter" id="subject-filter" class="filter-select w-full rounded-xl p-2 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-300 shadow-sm hover:shadow-md focus:shadow-lg">
                                            <option value="">All Subjects</option>
                                            @foreach($subjects as $subject)
                                                <option value="{{ $subject->id }}">{{ $subject->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="space-y-1">
                                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1">Topic</label>
                                        <select name="topic_filter" id="topic-filter" class="filter-select w-full rounded-xl p-2 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-300 shadow-sm hover:shadow-md focus:shadow-lg">
                                            <option value="">All Topics</option>
                                            @foreach($topics as $topic)
                                                <option value="{{ $topic->id }}">{{ $topic->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                            
                                    <div class="space-y-1">
                                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1">Question Type</label>
                                        <select name="question_type_filter" id="type-filter" class="filter-select w-full rounded-xl p-2 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-300 shadow-sm hover:shadow-md focus:shadow-lg">
                                            <option value="">All Types</option>
                                            @foreach($questionTypes as $questionType)
                                                <option value="{{ $questionType['value'] }}">{{ $questionType['label'] }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                            
                                    <div class="space-y-1">
                                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1">Date Created</label>
                                        <select name="date_filter" 
                                                id="date-filter" 
                                                class="filter-select w-full rounded-xl p-2 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-300 shadow-sm hover:shadow-md focus:shadow-lg">
                                            <option value="">All Dates</option>
                                            @foreach($availableDates as $date)
                                                <option value="{{ $date['value'] }}" {{ request('date_filter') == $date['value'] ? 'selected' : '' }}>
                                                    {{ $date['label'] }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="flex flex-col lg:flex-row gap-1 py-6">
                                    <div class="flex-1">
                                        <div class="flex items-center w-full bg-white dark:bg-gray-700 rounded-full shadow-lg p-1 border border-gray-200 dark:border-gray-600 h-10">
                                        
                                            <input 
                                                type="text" 
                                                id="searchInput"
                                                name="search"
                                                placeholder="Search by course, subject, topic, question, answer or tag" 
                                                class="flex-grow py-2 px-3 text-gray-800 dark:text-white focus:outline-none placeholder-gray-400 dark:placeholder-gray-500 rounded-full bg-transparent text-sm h-full"
                                                value="{{ request('search') }}"
                                            />
                                            
                                            <div id="searchLoading" class="hidden mr-2">
                                                <svg class="animate-spin h-4 w-4 text-blue-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                                </svg>
                                            </div>
                                                                  
                                        </div>
                                    </div>
                                            
                                    <div class="flex gap-2 flex-shrink-0">
                                        <button type="button" id="refresh-filters" class="px-4 py-2 h-10 bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white rounded-xl transition-all duration-300 flex items-center gap-2 font-medium shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                                            </svg>
                                            Refresh
                                        </button>
                                        <button type="button" id="clear-filters" class="px-4 py-2 h-10 bg-gradient-to-r from-gray-500 to-gray-600 hover:from-gray-600 hover:to-gray-700 text-white rounded-xl transition-all duration-300 font-medium shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                                            Clear Filters
                                        </button>
                                    </div>
                                </div>
                        </div>
                    </div>
                                        
                    <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-700/50">
                        <div class="flex flex-col sm:flex-row gap-4 sm:items-center sm:justify-between">
                            <div class="flex items-center gap-3">
                                <div class="flex items-center gap-2 px-3 py-2 bg-blue-50 dark:bg-blue-900/20 rounded-lg border border-blue-200 dark:border-blue-800">
                                    <svg class="w-4 h-4 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                    </svg>
                                    <span class="text-sm font-medium text-blue-700 dark:text-blue-300">
                                        Total Questions: <span id="total-questions-count">{{ $questions->count() }}</span>
                                    </span>
                                </div>
                                    
                                
                                <div class="flex gap-2">
                                    <button type="button" id="select-all" class="px-3 py-2 h-8 bg-gradient-to-r from-green-500 to-green-600 hover:from-green-600 hover:to-green-700 text-white rounded-lg transition-all duration-300 flex items-center gap-1.5 text-xs font-medium shadow-md hover:shadow-lg">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                        Select All
                                    </button>
                                    <button type="button" id="clear-all" class="px-3 py-2 h-8 bg-gradient-to-r from-red-500 to-red-600 hover:from-red-600 hover:to-red-700 text-white rounded-lg transition-all duration-300 flex items-center gap-1.5 text-xs font-medium shadow-md hover:shadow-lg">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                        </svg>
                                        Clear All
                                    </button>
                                
                                    <div class="flex items-center space-x-2">
                                        <span class="text-xs font-medium text-gray-600 dark:text-gray-400">Selected:</span>
                                        <div class="flex items-center space-x-2">
                                            <div class="w-32 h-4 rounded-full overflow-hidden shadow-inner relative" style="background: linear-gradient(to right, #fecaca, #fca5a5);" data-bg-light="linear-gradient(to right, #fecaca, #fca5a5)" data-bg-dark="linear-gradient(to right, #991b1b, #7f1d1d)">
                                                <div id="progress-bar" class="h-full transition-all duration-500 ease-out shadow-lg" style="width: 0%; background: linear-gradient(to right, #8b5cf6, #ec4899, #ef4444);"></div>
                                                <div class="absolute inset-0 flex items-center justify-center">
                                                    <span id="progress-percentage" class="text-xs font-bold text-gray-800 dark:text-gray-200" style="text-shadow: 1px 1px 2px rgba(255,255,255,0.8);">0%</span>
                                                </div>
                                            </div>
                                            <span class="text-xs font-medium text-gray-700 dark:text-gray-300">
                                                <span id="selected-count">0</span>/<span id="total-count">{{ $exam->total_questions }}</span>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="flex flex-col sm:flex-row gap-4">
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
                    </div>

                    <div class="px-4 pt-10 border-t border-gray-200 dark:border-gray-700">
                        <div class="questions-container">
                            @include('partner.exams.partials.questions-grid', ['questions' => $questions, 'assignedQuestions' => $assignedQuestions, 'assignedQuestionsWithMarks' => $assignedQuestionsWithMarks, 'assignedQuestionsWithOrder' => $assignedQuestionsWithOrder])
                        </div>
                    </div>
                </form>
            </div>
@endsection

<style>
/* Drag and Drop Styles */
.question-card {
    transition: all 0.3s ease;
}

.question-card.dragging {
    opacity: 0.5;
    transform: rotate(2deg) scale(1.02);
    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
    z-index: 1000;
}

.question-card.drag-over {
    border: 2px dashed #3b82f6;
    background-color: rgba(59, 130, 246, 0.05);
    transform: scale(1.01);
}

.drag-handle {
    transition: all 0.2s ease;
    cursor: grab; /* Set the cursor here */
}

.drag-handle:hover {
    background-color: rgba(59, 130, 246, 0.1);
    transform: scale(1.1);
}

.drop-indicator {
    position: relative;
    overflow: visible;
}

@keyframes pulse {
    0%, 100% {
        opacity: 0.4;
        transform: scale(0.8);
    }
    50% {
        opacity: 1;
        transform: scale(1.2);
    }
}

/* Smooth transitions for question reordering */
.questions-container {
    transition: all 0.3s ease;
}

/* Search feedback styles */
.questions-container.searching {
    opacity: 0.7;
    pointer-events: none;
}

.questions-container.searching::after {
    content: 'Searching...';
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    background: rgba(59, 130, 246, 0.9);
    color: white;
    padding: 8px 16px;
    border-radius: 8px;
    font-size: 14px;
    font-weight: 500;
    z-index: 10;
}

.question-card {
    transition: transform 0.3s ease, opacity 0.3s ease, box-shadow 0.3s ease;
}

/* Enhanced drag handle styling */
.drag-handle svg {
    transition: transform 0.2s ease;
}

.drag-handle:hover svg {
    transform: scale(1.1);
    color: #3b82f6;
}

/* Question number highlight during drag */
.question-number {
    transition: all 0.3s ease;
}

.question-card.dragging .question-number {
    background-color: #dbeafe;
    border-color: #3b82f6;
    color: #1e40af;
    font-weight: bold;
}

/* Mobile drag and drop styles */
@media (max-width: 768px) {
    .question-card.dragging {
        opacity: 0.8;
        transform: scale(1.02);
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.3);
        border: 2px solid #3b82f6;
    }
    
    .drag-handle {
        touch-action: none;
        -webkit-touch-callout: none;
        -webkit-user-select: none;
        user-select: none;
    }
    
    .question-card {
        touch-action: none;
        -webkit-touch-callout: none;
        -webkit-user-select: none;
        user-select: none;
    }
    
    /* Improve touch target size for mobile */
    .drag-handle {
        min-height: 44px;
        min-width: 44px;
        display: flex;
        align-items: center;
        justify-content: center;
    }
}
</style>

<script>
    // =========================================================================
    //  Global Variables
    // =========================================================================
    
    let draggedElement = null;
    let dropIndicator = null;

    // =========================================================================
    //  Marks Field Validation
    // =========================================================================
    
    function validateMarksField(input) {
        const value = parseInt(input.value);
        const questionId = input.getAttribute('data-question-id');
        const errorElement = document.querySelector(`.marks-error[data-question-id="${questionId}"]`);
        
        // Remove any existing error styling
        input.classList.remove('border-red-500', 'bg-red-50', 'dark:bg-red-900/20');
        input.classList.add('border-blue-400', 'bg-gray-100', 'dark:bg-gray-600');
        
        // Hide error message
        if (errorElement) {
            errorElement.classList.add('hidden');
        }
        
        // Validate marks
        if (isNaN(value) || value < 1 || value > 100) {
            // Show error
            input.classList.remove('border-blue-400', 'bg-gray-100', 'dark:bg-gray-600');
            input.classList.add('border-red-500', 'bg-red-50', 'dark:bg-red-900/20');
            
            if (errorElement) {
                errorElement.classList.remove('hidden');
            }
            
            return false;
        }
        
        return true;
    }
    
    function validateAllMarksFields() {
        const marksInputs = document.querySelectorAll('.question-marks');
        let isValid = true;
        
        marksInputs.forEach(input => {
            if (!validateMarksField(input)) {
                isValid = false;
            }
        });
        
        return isValid;
    }
    
    // =========================================================================
    //  Function Definitions (Defined first to avoid hoisting issues)
    // =========================================================================
    
    function attachCheckboxListeners() {
        // Remove any existing listeners first to avoid duplicates
        document.querySelectorAll('.question-checkbox').forEach(checkbox => {
            // Clone the checkbox to remove all event listeners
            const newCheckbox = checkbox.cloneNode(true);
            checkbox.parentNode.replaceChild(newCheckbox, checkbox);
        });
        
        // Add fresh event listeners
        document.querySelectorAll('.question-checkbox').forEach(checkbox => {
            checkbox.addEventListener('change', function() {
                console.log('Checkbox changed:', this.value, 'checked:', this.checked);
                updateSelectedCount();
                if (this.checked) {
                    assignQuestionNumber(this);
                } else {
                    clearQuestionNumber(this);
                }
            });
        });
        
        console.log('Attached checkbox listeners to', document.querySelectorAll('.question-checkbox').length, 'checkboxes');
        
        // Ensure initial state is correct
        updateAllQuestionNumbers();
    }

    function assignQuestionNumber(checkbox) {
        const questionCard = checkbox.closest('.question-card');
        const questionNumberInput = questionCard.querySelector('.question-number');
        if (questionNumberInput) {
            // Enable the input field
            questionNumberInput.disabled = false;
            
            // Assign sequential number if empty
            if (!questionNumberInput.value) {
                questionNumberInput.value = getNextQuestionNumber();
            }
            
            // Update all question numbers to ensure sequential order
            updateAllQuestionNumbers();
        }
    }

    function clearQuestionNumber(checkbox) {
        const questionCard = checkbox.closest('.question-card');
        const questionNumberInput = questionCard.querySelector('.question-number');
        if (questionNumberInput) {
            questionNumberInput.value = '';
            questionNumberInput.disabled = true;
            console.log('Cleared question number for question:', checkbox.value);
        }
        
        // Update all question numbers to ensure sequential order
        updateAllQuestionNumbers();
    }

    function getNextQuestionNumber() {
        // Count currently selected questions to get the next number
        const checkedBoxes = document.querySelectorAll('.question-checkbox:checked');
        return checkedBoxes.length;
    }

    function updateAllQuestionNumbers() {
        const questionCards = Array.from(document.querySelectorAll('.question-card'));
        
        console.log('updateAllQuestionNumbers called - processing', questionCards.length, 'question cards');
        
        // First, clear all question numbers and disable unselected ones
        questionCards.forEach(card => {
            const checkbox = card.querySelector('.question-checkbox');
            const questionNumberInput = card.querySelector('.question-number');
            if (checkbox && !checkbox.checked && questionNumberInput) {
                questionNumberInput.value = '';
                questionNumberInput.disabled = true;
                console.log('Disabled Q# field for unchecked question:', checkbox.value);
            }
        });
        
        // Get checked questions in their visual order (DOM order)
        const checkedQuestions = questionCards.filter(card => {
            const checkbox = card.querySelector('.question-checkbox');
            return checkbox && checkbox.checked;
        });
        
        console.log('Found', checkedQuestions.length, 'checked questions');
        
        // Assign sequential numbers starting from 1
        checkedQuestions.forEach((questionCard, index) => {
            const questionNumberInput = questionCard.querySelector('.question-number');
            if (questionNumberInput) {
                questionNumberInput.value = index + 1;
                questionNumberInput.disabled = false;
                console.log('Assigned Q#', index + 1, 'to question');
            }
        });
        
        console.log(`Updated ${checkedQuestions.length} question numbers to be sequential starting from 1`);
    }

    function updateSelectedCount() {
        const checkboxes = document.querySelectorAll('.question-checkbox');
        const checkedBoxes = document.querySelectorAll('.question-checkbox:checked');
        const selectedCountElement = document.getElementById('selected-count');
        const totalCountElement = document.getElementById('total-count');
        const progressBar = document.getElementById('progress-bar');
        const progressPercentageElement = document.getElementById('progress-percentage');

        const selectedCount = checkedBoxes.length;
        const totalCount = parseInt(totalCountElement?.textContent) || 0;
        const percentage = totalCount > 0 ? Math.round((selectedCount / totalCount) * 100) : 0;

        if (selectedCountElement) {
            selectedCountElement.textContent = selectedCount;
        }

        if (progressBar) {
            progressBar.style.width = percentage + '%';
        }

        if (progressPercentageElement) {
            progressPercentageElement.textContent = percentage + '%';
        } else if (progressPercentageElement) {
            progressPercentageElement.textContent = '0%';
        }
    }

    function updateProgressBarTheme() {
        const progressContainer = document.querySelector('.w-32.h-4.rounded-full');
        if (progressContainer) {
            const isDark = document.documentElement.classList.contains('dark');
            const bgStyle = progressContainer.getAttribute(isDark ? 'data-bg-dark' : 'data-bg-light');
            if (bgStyle) {
                progressContainer.style.background = bgStyle;
            }
        }
    }

    function initializeDragAndDrop() {
        createDropIndicator();
        attachDragListeners();
    }

    function createDropIndicator() {
        if (dropIndicator) return;
        
        dropIndicator = document.createElement('div');
        dropIndicator.className = 'drop-indicator';
        dropIndicator.style.cssText = `
            height: 3px;
            background: linear-gradient(90deg, #3b82f6, #8b5cf6);
            border-radius: 2px;
            margin: 8px 0;
            opacity: 0;
            transition: opacity 0.2s ease;
            position: relative;
        `;
        
        const dots = document.createElement('div');
        dots.style.cssText = `
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 20px;
            height: 3px;
            background: repeating-linear-gradient(
                90deg,
                #ffffff 0px,
                #ffffff 2px,
                transparent 2px,
                transparent 4px
            );
            border-radius: 1px;
        `;
        dropIndicator.appendChild(dots);
    }

    function attachDragListeners() {
        document.querySelectorAll('.question-card').forEach((card) => {
            // Desktop drag and drop events
            card.addEventListener('dragover', handleDragOver);
            card.addEventListener('drop', handleDrop);
            card.addEventListener('dragenter', handleDragEnter);
            card.addEventListener('dragleave', handleDragLeave);
            
            // Mobile touch events
            card.addEventListener('touchmove', handleTouchMove, { passive: false });
            card.addEventListener('touchend', handleTouchEnd);
        });
        
        document.querySelectorAll('.drag-handle').forEach((handle) => {
            // Desktop drag and drop events
            handle.draggable = true;
            handle.addEventListener('dragstart', handleDragStart);
            handle.addEventListener('dragend', handleDragEnd);
            
            // Mobile touch events
            handle.addEventListener('touchstart', handleTouchStart, { passive: false });
        });
    }

    function handleDragStart(e) {
        // Find the parent question card and set it as the element to drag
        const questionCard = this.closest('.question-card');
        if (questionCard) {
            draggedElement = questionCard;
            questionCard.classList.add('dragging');
            e.dataTransfer.effectAllowed = 'move';
            e.dataTransfer.setData('text/plain', 'moving'); // Required for Firefox
        }
    }

    function handleDragEnd(e) {
        // Find the parent question card and remove the dragging class
        const questionCard = this.closest('.question-card');
        if (questionCard) {
            questionCard.classList.remove('dragging');
        }
        
        if (dropIndicator && dropIndicator.parentNode) {
            dropIndicator.parentNode.removeChild(dropIndicator);
        }
        draggedElement = null;
    }

    function handleDragOver(e) {
        e.preventDefault();
        e.dataTransfer.dropEffect = 'move';
        if (this === draggedElement) return;
        
        const rect = this.getBoundingClientRect();
        const isAfter = e.clientY > (rect.top + rect.height / 2);
        showDropIndicator(this, isAfter);
    }

    function handleDragEnter(e) {
        e.preventDefault();
        this.classList.add('drag-over');
    }

    function handleDragLeave() {
        this.classList.remove('drag-over');
    }

    // =========================================================================
    //  Mobile Touch Event Handlers
    // =========================================================================
    
    let touchStartY = 0;
    let touchStartElement = null;
    let isDragging = false;
    let touchOffset = { x: 0, y: 0 };

    function handleTouchStart(e) {
        e.preventDefault();
        const touch = e.touches[0];
        const questionCard = this.closest('.question-card');
        
        if (questionCard) {
            touchStartY = touch.clientY;
            touchStartElement = questionCard;
            draggedElement = questionCard;
            isDragging = true;
            
            // Get the position of the touch relative to the element
            const rect = questionCard.getBoundingClientRect();
            touchOffset.x = touch.clientX - rect.left;
            touchOffset.y = touch.clientY - rect.top;
            
            // Add dragging class
            questionCard.classList.add('dragging');
            questionCard.style.position = 'relative';
            questionCard.style.zIndex = '1000';
            
            console.log('Touch start - dragging element:', questionCard);
        }
    }

    function handleTouchMove(e) {
        if (!isDragging || !draggedElement) return;
        
        e.preventDefault();
        const touch = e.touches[0];
        const questionCard = this.closest('.question-card');
        
        // Move the dragged element
        draggedElement.style.transform = `translateY(${touch.clientY - touchStartY}px)`;
        
        // Find the element under the touch point
        const elementBelow = document.elementFromPoint(touch.clientX, touch.clientY);
        const targetCard = elementBelow?.closest('.question-card');
        
        if (targetCard && targetCard !== draggedElement) {
            // Remove drag-over class from all cards
            document.querySelectorAll('.question-card').forEach(card => {
                card.classList.remove('drag-over');
            });
            
            // Add drag-over class to target
            targetCard.classList.add('drag-over');
            
            // Show drop indicator
            const rect = targetCard.getBoundingClientRect();
            const isAfter = touch.clientY > (rect.top + rect.height / 2);
            showDropIndicator(targetCard, isAfter);
        }
    }

    function handleTouchEnd(e) {
        if (!isDragging || !draggedElement) return;
        
        e.preventDefault();
        const touch = e.changedTouches[0];
        const elementBelow = document.elementFromPoint(touch.clientX, touch.clientY);
        const targetCard = elementBelow?.closest('.question-card');
        
        if (targetCard && targetCard !== draggedElement) {
            // Perform the drop
            const rect = targetCard.getBoundingClientRect();
            const isAfter = touch.clientY > (rect.top + rect.height / 2);
            
            moveElement(draggedElement, targetCard, isAfter);
            updateQuestionNumbersAfterDrag();
        }
        
        // Clean up
        draggedElement.style.transform = '';
        draggedElement.style.position = '';
        draggedElement.style.zIndex = '';
        draggedElement.classList.remove('dragging');
        
        // Remove drag-over classes
        document.querySelectorAll('.question-card').forEach(card => {
            card.classList.remove('drag-over');
        });
        
        // Remove drop indicator
        if (dropIndicator && dropIndicator.parentNode) {
            dropIndicator.parentNode.removeChild(dropIndicator);
        }
        
        // Reset variables
        draggedElement = null;
        touchStartElement = null;
        isDragging = false;
        touchStartY = 0;
        touchOffset = { x: 0, y: 0 };
        
        console.log('Touch end - drag completed');
    }

    function handleDrop(e) {
        e.preventDefault();
        this.classList.remove('drag-over');
        
        if (!draggedElement || this === draggedElement) {
            return;
        }
        
        const isAfter = e.clientY > (this.getBoundingClientRect().top + this.offsetHeight / 2);
        
        moveElement(draggedElement, this, isAfter);
        updateQuestionNumbersAfterDrag();
        
        // Remove drop indicator
        if (dropIndicator && dropIndicator.parentNode) {
            dropIndicator.parentNode.removeChild(dropIndicator);
        }
    }

    function showDropIndicator(targetElement, isAfter) {
        if (!dropIndicator) createDropIndicator();
        if (dropIndicator.parentNode) {
            dropIndicator.parentNode.removeChild(dropIndicator);
        }
        if (isAfter) {
            targetElement.parentNode.insertBefore(dropIndicator, targetElement.nextSibling);
        } else {
            targetElement.parentNode.insertBefore(dropIndicator, targetElement);
        }
        setTimeout(() => dropIndicator.style.opacity = '1', 10);
    }

    function moveElement(draggedEl, targetEl, isAfter) {
        const container = draggedEl.parentNode;
        
        if (isAfter) {
            // Insert after the target element
            container.insertBefore(draggedEl, targetEl.nextSibling);
        } else {
            // Insert before the target element
            container.insertBefore(draggedEl, targetEl);
        }
    }

    function updateQuestionNumbersAfterDrag() {
        // Use the same function to ensure consistent sequential numbering
        updateAllQuestionNumbers();
        updateSelectedCount();
    }

    // =========================================================================
    //  Cascading Dropdown Functions
    // =========================================================================
    
    function updateSubjectsForCourse(courseId) {
        const subjectFilter = document.getElementById('subject-filter');
        if (!subjectFilter) return;
        
        // Show loading state
        subjectFilter.disabled = true;
        subjectFilter.innerHTML = '<option value="">Loading subjects...</option>';
        
        // Load subjects for the selected course
        loadSubjects(courseId);
        
        // Re-enable the dropdown after loading
        setTimeout(() => {
            subjectFilter.disabled = false;
        }, 500);
    }
    
    function updateTopicsForSubject(subjectId) {
        const topicFilter = document.getElementById('topic-filter');
        if (!topicFilter) return;
        
        // Show loading state
        topicFilter.disabled = true;
        topicFilter.innerHTML = '<option value="">Loading topics...</option>';
        
        // Load topics for the selected subject
        loadTopics(subjectId);
        
        // Re-enable the dropdown after loading
        setTimeout(() => {
            topicFilter.disabled = false;
        }, 500);
    }
    
    function loadSubjects(courseId = null) {
        const subjectFilter = document.getElementById('subject-filter');
        if (!subjectFilter) return Promise.resolve();
        
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
    
    function loadTopics(subjectId = null) {
        const topicFilter = document.getElementById('topic-filter');
        if (!topicFilter) return Promise.resolve();
        
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

    // =========================================================================
    //  AJAX Search and Filter Functions
    // =========================================================================
    function performAjaxSearch() {
        const searchInput = document.getElementById('searchInput');
        const questionsContainer = document.querySelector('.questions-container');
        const searchLoading = document.getElementById('searchLoading');
        const courseFilter = document.getElementById('course-filter');
        const subjectFilter = document.getElementById('subject-filter');
        const topicFilter = document.getElementById('topic-filter');
        const questionTypeFilter = document.getElementById('type-filter');
        const dateFilter = document.getElementById('date-filter');

        if (!searchInput || !questionsContainer || !searchLoading) {
            console.error('One or more search elements are missing.');
            return;
        }

        const searchValue = searchInput.value;
        const currentUrl = new URL(window.location.href);

        // Add updating class to questions container
        questionsContainer.classList.add('updating');
        questionsContainer.classList.add('searching');
        searchLoading.classList.remove('hidden');

        // Update URL parameters
        if (searchValue) {
            currentUrl.searchParams.set('search', searchValue);
        } else {
            currentUrl.searchParams.delete('search');
        }

        // Handle filter parameters
        if (courseFilter && courseFilter.value) {
            currentUrl.searchParams.set('course_filter', courseFilter.value);
        } else {
            currentUrl.searchParams.delete('course_filter');
        }

        // Repeat for other filters...
        if (subjectFilter && subjectFilter.value) {
            currentUrl.searchParams.set('subject_filter', subjectFilter.value);
        } else {
            currentUrl.searchParams.delete('subject_filter');
        }
        
        if (topicFilter && topicFilter.value) {
            currentUrl.searchParams.set('topic_filter', topicFilter.value);
        } else {
            currentUrl.searchParams.delete('topic_filter');
        }

        if (questionTypeFilter && questionTypeFilter.value) {
            currentUrl.searchParams.set('question_type_filter', questionTypeFilter.value);
        } else {
            currentUrl.searchParams.delete('question_type_filter');
        }

        if (dateFilter && dateFilter.value) {
            currentUrl.searchParams.set('date_filter', dateFilter.value);
        } else {
            currentUrl.searchParams.delete('date_filter');
        }

        // Update browser URL without reloading
        window.history.pushState({}, '', currentUrl);

        fetch(currentUrl.toString(), {
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => response.text())
        .then(html => {
            const parser = new DOMParser();
            const doc = parser.parseFromString(html, 'text/html');
            const questionsGrid = doc.querySelector('.questions-container');
            const emptyState = doc.querySelector('.empty-state');

            if (questionsGrid) {
                questionsContainer.innerHTML = questionsGrid.innerHTML;
                attachCheckboxListeners();
                initializeDragAndDrop();
                updateSelectedCount();
            } else if (emptyState) {
                questionsContainer.innerHTML = emptyState.outerHTML;
            }

            // Hide loading indicator and remove classes
            searchLoading.classList.add('hidden');
            questionsContainer.classList.remove('updating', 'searching');
        })
        .catch(error => {
            searchLoading.classList.add('hidden');
            questionsContainer.classList.remove('updating', 'searching');
            console.error('Search failed:', error);
        });
    }

    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.getElementById('searchInput');
        const searchLoading = document.getElementById('searchLoading');
        const questionsContainer = document.querySelector('.questions-container');
        const courseFilter = document.getElementById('course-filter');
        const subjectFilter = document.getElementById('subject-filter');
        const topicFilter = document.getElementById('topic-filter');
        const questionTypeFilter = document.getElementById('type-filter');
        const dateFilter = document.getElementById('date-filter');
        const clearAllFiltersBtn = document.getElementById('clear-filters');
        const refreshQuestionsBtn = document.getElementById('refresh-filters');
        const selectAllBtn = document.getElementById('select-all');
        const clearAllBtn = document.getElementById('clear-all');
        const form = document.getElementById('filterForm');

        // Drag and Drop Variables
        let draggedElement = null;
        let dropIndicator = null;

        // =========================================================================
        //  Event Listeners
        // =========================================================================

        // Search input event listener with a debounce
        if (searchInput) {
            let searchTimeout;
            searchInput.addEventListener('input', function() {
                clearTimeout(searchTimeout);
                searchTimeout = setTimeout(performAjaxSearch, 300);
            });
        }
        
        // Filter change handlers with cascading functionality
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
        
        if (dateFilter) {
            dateFilter.addEventListener('change', function() {
                console.log('Date filter changed to:', this.value);
                performAjaxSearch();
            });
        }

        // Clear all filters button
        if (clearAllFiltersBtn) {
            clearAllFiltersBtn.addEventListener('click', function(e) {
                e.preventDefault();
                clearAllFilters();
            });
        }
        
        // Refresh button
        if (refreshQuestionsBtn) {
            refreshQuestionsBtn.addEventListener('click', function(e) {
                e.preventDefault();
                performAjaxSearch();
            });
        }

        // Select All and Clear All buttons
        if (selectAllBtn) {
            selectAllBtn.addEventListener('click', selectAllQuestions);
        }
        
        if (clearAllBtn) {
            clearAllBtn.addEventListener('click', clearAllQuestions);
        }
        
        // Form submit handler to add question IDs
        if (form) {
            form.addEventListener('submit', function(e) {
                const selectedQuestions = Array.from(document.querySelectorAll('.question-checkbox:checked'));
                console.log('Form submission triggered');
                console.log('Selected questions:', selectedQuestions.length);
                console.log('Selected question IDs:', selectedQuestions.map(cb => cb.value));
                
                // Allow form submission even with no questions selected (for removing all questions)
                
                // Validate all marks fields
                if (!validateAllMarksFields()) {
                    e.preventDefault();
                    alert('Please fix the marks validation errors before submitting.');
                    return false;
                }
                
                // Log whether questions are selected or not
                if (selectedQuestions.length === 0) {
                    console.log('No questions selected - will clear all questions from exam');
                } else {
                    console.log(`${selectedQuestions.length} questions selected - will assign to exam`);
                }
                
                // Log form data for debugging
                const formData = new FormData(this);
                console.log('Form data being submitted:');
                for (let [key, value] of formData.entries()) {
                    console.log(key, value);
                }
            });
        }

        // Add click event listener to Assign button for debugging
        const assignButton = document.querySelector('button[type="submit"]');
        if (assignButton) {
            assignButton.addEventListener('click', function(e) {
                console.log('Assign button clicked');
                console.log('Button type:', this.type);
                console.log('Form element:', this.form);
                console.log('Form action:', this.form?.action);
                console.log('Form method:', this.form?.method);
            });
        } else {
            console.log('Assign button not found');
        }

        // =========================================================================
        //  Helper Functions
        // =========================================================================

        function clearAllFilters() {
            if (searchInput) searchInput.value = '';
            if (courseFilter) courseFilter.value = '';
            if (subjectFilter) subjectFilter.value = '';
            if (topicFilter) topicFilter.value = '';
            if (questionTypeFilter) questionTypeFilter.value = '';
            if (dateFilter) dateFilter.value = '';
            
            // Update subjects and topics for no course selection
            updateSubjectsForCourse('');
            updateTopicsForSubject('');
            
            performAjaxSearch();
        }
        
        function selectAllQuestions() {
            document.querySelectorAll('.question-checkbox').forEach(checkbox => {
                checkbox.checked = true;
                assignQuestionNumber(checkbox);
            });
            updateSelectedCount();
        }

        function clearAllQuestions() {
            document.querySelectorAll('.question-checkbox').forEach(checkbox => {
                checkbox.checked = false;
                clearQuestionNumber(checkbox);
            });
            updateSelectedCount();
        }
        
        // =========================================================================
        //  Initial Setup
        // =========================================================================
        
        // Initialize all functionality on page load
        console.log('Initializing page functionality...');
        attachCheckboxListeners();
        initializeDragAndDrop();
        updateSelectedCount();
        console.log('Page initialization complete');

    });
</script>