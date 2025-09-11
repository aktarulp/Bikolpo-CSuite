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
    <div class="container mx-auto px-4 py-4 space-y-2 relative" style="padding-bottom: 200px;">
        <div class="space-y-6">

            <!-- Main Form Card -->
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700">
                <form id="filterForm" action="{{ route('partner.exams.store-assigned-questions', $exam) }}" method="POST">
                    @csrf

                    <!-- Header Section -->
                    <div class="px-6 py-6 border-b border-gray-200 dark:border-gray-700">
                        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-6">
                            <div class="flex-1">
                                <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-2">Select Questions</h2>
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
                    </div>
                    

                    <!-- Search and Filters Section -->
                    <div class="bg-gradient-to-br from-white to-gray-50 dark:from-gray-800 dark:to-gray-900 rounded-2xl shadow-xl border border-gray-200 dark:border-gray-700 overflow-visible backdrop-blur-sm relative z-20">
                        <div class="py-2 px-3">
                            <form method="GET" id="filterForm" class="space-y-3">
                                <input type="hidden" name="search" id="searchHidden" value="{{ request('search') }}">
                                
                                <!-- Filters Grid -->
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
                                        </select>
                                    </div>
                                </div>
                                
                                <!-- Search Bar with Action Buttons -->
                                <div class="flex flex-col lg:flex-row gap-1 py-6">
                                    <!-- Search Bar -->
                                    <div class="flex-1">
                                        <div class="flex items-center w-full bg-white dark:bg-gray-700 rounded-full shadow-lg p-1 border border-gray-200 dark:border-gray-600 h-10">
                                        
                                            <!-- Input Field -->
                                            <input 
                                                type="text" 
                                                id="search"
                                                name="search"
                                                placeholder="Search by course, subject, topic, question, answer or tag" 
                                                class="flex-grow py-2 px-3 text-gray-800 dark:text-white focus:outline-none placeholder-gray-400 dark:placeholder-gray-500 rounded-full bg-transparent text-sm h-full"
                                                value="{{ request('search') }}"
                                            />
                                                                  
                                        </div>
                                      
                            </div>
                            
                        <!-- Action Buttons -->
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
                            </form>
                        </div>
                    </div>

                    <!-- Assign and Cancel Buttons -->
                    <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-700/50">
                        <div class="flex flex-col sm:flex-row gap-4 sm:items-center sm:justify-between">
                    <!-- Total Questions Counter and Selection Buttons -->
                    <div class="flex items-center gap-3">
                        <div class="flex items-center gap-2 px-3 py-2 bg-blue-50 dark:bg-blue-900/20 rounded-lg border border-blue-200 dark:border-blue-800">
                            <svg class="w-4 h-4 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                            <span class="text-sm font-medium text-blue-700 dark:text-blue-300">
                                Total Questions: <span id="total-questions-count">{{ $questions->count() }}</span>
                            </span>
                        </div>
                        
                                
                                <!-- Selection Buttons -->
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
                                
                                <!-- Selection Counter -->
                                <div class="flex items-center">
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-300 border border-blue-200 dark:border-blue-700">
                                        Selected: <span id="selected-count">0</span>/<span id="total-count">{{ $exam->total_questions }}</span>
                                    </span>
                                </div>
                                </div>
                            </div>
                            
                            <!-- Action Buttons -->
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

                    <!-- Questions List -->
                    <div class="px-4 pt-10 border-t border-gray-200 dark:border-gray-700">
                        <div class="questions-container">
                            @include('partner.exams.partials.questions-grid', ['questions' => $questions, 'assignedQuestions' => $assignedQuestions, 'assignedQuestionsWithMarks' => $assignedQuestionsWithMarks, 'assignedQuestionsWithOrder' => $assignedQuestionsWithOrder])
                        </div>
                    </div>
@endsection

<style>
/* Drag and Drop Styles */
.question-card {
    transition: all 0.3s ease;
    cursor: grab;
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
</style>

<script>

// Move the main script here temporarily to test
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
        return;
    }
    // Load initial filter data
    loadFilterData();
    
    // Filter change handlers with parent-child relationships
    if (courseFilter) {
        courseFilter.addEventListener('change', function() {
            const courseId = this.value;
            
            // Clear dependent filters
            if (subjectFilter) {
                subjectFilter.value = '';
            }
            if (topicFilter) {
                topicFilter.value = '';
            }
            
            // Update subjects for selected course
            updateSubjectsForCourse(courseId);
            
            // Trigger search
            performAjaxSearch();
        });
    } else {
    }
    
    if (subjectFilter) {
        subjectFilter.addEventListener('change', function() {
            const subjectId = this.value;
            
            // Clear dependent filters
            if (topicFilter) {
                topicFilter.value = '';
            }
            
            // Update topics for selected subject
            updateTopicsForSubject(subjectId);
            
            // Trigger search
            performAjaxSearch();
        });
    } else {
    }
    
    if (topicFilter) {
        topicFilter.addEventListener('change', function() {
            performAjaxSearch();
        });
    } else {
    }
    
    if (questionTypeFilter) {
        questionTypeFilter.addEventListener('change', function() {
            performAjaxSearch();
        });
    } else {
    }
    
    if (dateFilter) {
        dateFilter.addEventListener('change', function() {
            performAjaxSearch();
        });
        } else {
    }
    
    // Clear all filters button
    if (clearAllFiltersBtn) {
        clearAllFiltersBtn.addEventListener('click', function(e) {
            e.preventDefault();
            clearAllFilters();
        });
    }
    
    // Select All and Clear All buttons
    const selectAllBtn = document.getElementById('select-all');
    const clearAllBtn = document.getElementById('clear-all');
    
    if (selectAllBtn) {
        selectAllBtn.addEventListener('click', function(e) {
            e.preventDefault();
            selectAllQuestions();
        });
    }
    
    if (clearAllBtn) {
        clearAllBtn.addEventListener('click', function(e) {
            e.preventDefault();
            clearAllQuestions();
        });
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
                    if (course.id == '{{ request("course_filter") ?? "" }}') {
                        option.selected = true;
                    }
                    
                    courseFilter.appendChild(option);
                });
            }
            
            // Clear and reset subjects and topics dropdowns when courses change
            if (subjectFilter) {
                subjectFilter.innerHTML = '<option value="">All Subjects</option>';
            }
            if (topicFilter) {
                topicFilter.innerHTML = '<option value="">All Topics</option>';
            }
        })
        .catch(error => {
            courseFilter.innerHTML = '<option value="">Error loading courses</option>';
        });
    }
    
    // Function to load subjects
    function loadSubjects(courseId = null) {
        const url = `{{ route("partner.questions.subjects-for-filter") }}?course_id=${courseId || ''}`;
        
        return fetch(url, {
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => {
            return response.json();
        })
        .then(data => {
            subjectFilter.innerHTML = '<option value="">All Subjects</option>';
            
            if (data.subjects && data.subjects.length > 0) {
                data.subjects.forEach(subject => {
                    const option = document.createElement('option');
                    option.value = subject.id;
                    option.textContent = subject.name;
                    
                    // Check if this subject was previously selected
                    if (subject.id == '{{ request("subject_filter") ?? "" }}') {
                        option.selected = true;
                    }
                    
                    subjectFilter.appendChild(option);
                });
            } else {
            }
            
            // Clear and reset topics dropdown when subjects change
            if (topicFilter) {
                topicFilter.innerHTML = '<option value="">All Topics</option>';
            }
        })
        .catch(error => {
            subjectFilter.innerHTML = '<option value="">Error loading subjects</option>';
        });
    }
    
    // Function to load initial filter data
    function loadFilterData() {
        // Clear all filters on reload
        
        // Reset all filter dropdowns to default values
        if (courseFilter) {
            courseFilter.value = '';
        }
        if (subjectFilter) {
            subjectFilter.value = '';
        }
        if (topicFilter) {
            topicFilter.value = '';
        }
        if (questionTypeFilter) {
            questionTypeFilter.value = '';
        }
        
        // Clear search input
        if (searchInput) {
            searchInput.value = '';
        }
        
        // Load courses first
        loadCourses().then(() => {
            // Load all subjects and topics (no specific selections)
            loadSubjects();
            loadTopics();
        });
        
        // Load question types
        loadQuestionTypes();
        
        // Load available dates
        loadDates();
        
        // Trigger search to show all questions
        performAjaxSearch();
    }
    
    // Function to load topics
    function loadTopics(subjectId = null) {
        const url = `{{ route("partner.questions.topics-for-filter") }}?subject_id=${subjectId || ''}`;
        
        return fetch(url, {
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => {
            return response.json();
        })
        .then(data => {
            topicFilter.innerHTML = '<option value="">All Topics</option>';
            
            if (data.topics && data.topics.length > 0) {
                data.topics.forEach(topic => {
                    const option = document.createElement('option');
                    option.value = topic.id;
                    option.textContent = topic.name;
                    
                    // Check if this topic was previously selected
                    if (topic.id == '{{ request("topic_filter") ?? "" }}') {
                        option.selected = true;
                    }
                    
                    topicFilter.appendChild(option);
                });
            } else {
            }
        })
        .catch(error => {
            topicFilter.innerHTML = '<option value="">Error loading topics</option>';
        });
    }
    
    // Function to update subjects when course changes
    function updateSubjectsForCourse(courseId) {
        loadSubjects(courseId).then(() => {
            // After subjects are loaded, clear topics
            if (topicFilter) {
                topicFilter.innerHTML = '<option value="">All Topics</option>';
            }
        });
    }
    
    // Function to update topics when subject changes
    function updateTopicsForSubject(subjectId) {
        loadTopics(subjectId);
    }
    
    // Function to clear all filters
    function clearAllFilters() {
        // Clear all filter dropdowns
        if (courseFilter) courseFilter.value = '';
        if (subjectFilter) subjectFilter.value = '';
        if (topicFilter) topicFilter.value = '';
        if (questionTypeFilter) questionTypeFilter.value = '';
        if (dateFilter) dateFilter.value = '';
        
        // Clear search input
        if (searchInput) searchInput.value = '';
        
        // Reset dependent filters
        if (subjectFilter) {
            subjectFilter.innerHTML = '<option value="">All Subjects</option>';
        }
        if (topicFilter) {
            topicFilter.innerHTML = '<option value="">All Topics</option>';
        }
        
        // Trigger search to reload all questions
        performAjaxSearch();
    }
    
    // Function to select all visible questions
    function selectAllQuestions() {
        const checkboxes = document.querySelectorAll('.question-checkbox');
        checkboxes.forEach(checkbox => {
            checkbox.checked = true;
            assignQuestionNumber(checkbox);
        });
        updateSelectedCount();
    }
    
    // Function to clear all selected questions
    function clearAllQuestions() {
        const checkboxes = document.querySelectorAll('.question-checkbox');
        checkboxes.forEach(checkbox => {
            checkbox.checked = false;
            clearQuestionNumber(checkbox);
        });
        updateSelectedCount();
    }
    
    // Function to update selected count display
    function updateSelectedCount() {
        const checkboxes = document.querySelectorAll('.question-checkbox');
        const selectedCount = document.querySelectorAll('.question-checkbox:checked').length;
        const totalCountElement = document.getElementById('total-count');
        const examQuestionCount = totalCountElement ? parseInt(totalCountElement.textContent) : 0;
        
        // Update any selected count display if it exists
        const selectedCountElement = document.getElementById('selected-count');
        if (selectedCountElement) {
            selectedCountElement.textContent = selectedCount;
        }
        // Keep the total count as the exam's assigned questions count (already set in HTML)
    }
    
    // Add event listeners to individual checkboxes for count updates
    function attachCheckboxListeners() {
        const checkboxes = document.querySelectorAll('.question-checkbox');
        checkboxes.forEach(checkbox => {
            checkbox.addEventListener('change', function() {
                updateSelectedCount();
                if (this.checked) {
                    assignQuestionNumber(this);
                } else {
                    clearQuestionNumber(this);
                }
            });
        });
    }
    
    // Function to assign question number in order
    function assignQuestionNumber(checkbox) {
        const questionCard = checkbox.closest('.question-card');
        const questionNumberInput = questionCard.querySelector('.question-number');
        
        if (questionNumberInput) {
            // Get the next available question number
            const nextNumber = getNextQuestionNumber();
            questionNumberInput.value = nextNumber;
            
            // Scroll to top of questions grid
            const questionsContainer = document.querySelector('.questions-container');
            if (questionsContainer) {
                questionsContainer.scrollIntoView({ behavior: 'smooth', block: 'start' });
            }
            
            // Sort questions by question number
            sortQuestionsByNumber();
        }
    }
    
    // Function to clear question number when unchecked
    function clearQuestionNumber(checkbox) {
        const questionCard = checkbox.closest('.question-card');
        const questionNumberInput = questionCard.querySelector('.question-number');
        
        if (questionNumberInput) {
            questionNumberInput.value = '';
            // Re-sort questions after clearing
            sortQuestionsByNumber();
        }
    }
    
    // Function to get the next available question number
    function getNextQuestionNumber() {
        const questionNumbers = Array.from(document.querySelectorAll('.question-number'))
            .map(input => parseInt(input.value) || 0)
            .filter(num => num > 0)
            .sort((a, b) => a - b);
        
        let nextNumber = 1;
        for (let num of questionNumbers) {
            if (nextNumber === num) {
                nextNumber++;
            } else {
                break;
            }
        }
        return nextNumber;
    }
    
    // Function to sort questions by question number
    function sortQuestionsByNumber() {
        const questionsContainer = document.querySelector('.questions-container');
        if (!questionsContainer) return;
        
        const questionCards = Array.from(questionsContainer.querySelectorAll('.question-card'));
        
        questionCards.sort((a, b) => {
            const aNumber = parseInt(a.querySelector('.question-number')?.value) || 999999;
            const bNumber = parseInt(b.querySelector('.question-number')?.value) || 999999;
            return aNumber - bNumber;
        });
        
        // Re-append sorted questions
        questionCards.forEach(card => {
            questionsContainer.appendChild(card);
        });
    }
    
    // Call this function when questions are loaded/updated
    attachCheckboxListeners();
    
    // Drag and Drop Variables
    let draggedElement = null;
    let draggedIndex = -1;
    let dropIndicator = null;
    
    // Initialize drag and drop functionality
    initializeDragAndDrop();
    
    // Function to initialize drag and drop
    function initializeDragAndDrop() {
        const questionsContainer = document.querySelector('.questions-container');
        if (!questionsContainer) return;
        
        // Create drop indicator element
        createDropIndicator();
        
        // Attach drag listeners to all question cards
        attachDragListeners();
    }
    
    // Function to create drop indicator
    function createDropIndicator() {
        if (dropIndicator) {
            return; // Already created
        }
        
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
        
        // Add animated dots
        const dots = document.createElement('div');
        dots.style.cssText = `
            position: absolute;
            top: -2px;
            left: 50%;
            transform: translateX(-50%);
            display: flex;
            gap: 4px;
        `;
        
        for (let i = 0; i < 3; i++) {
            const dot = document.createElement('div');
            dot.style.cssText = `
                width: 6px;
                height: 6px;
                background: #3b82f6;
                border-radius: 50%;
                animation: pulse 1.5s infinite;
                animation-delay: ${i * 0.2}s;
            `;
            dots.appendChild(dot);
        }
        
        dropIndicator.appendChild(dots);
    }
    
    // Function to attach drag listeners
    function attachDragListeners() {
        const questionCards = document.querySelectorAll('.question-card');
        questionCards.forEach((card, index) => {
            const dragHandle = card.querySelector('.drag-handle');
            if (dragHandle) {
                // Make the entire card draggable
                card.draggable = true;
                card.dataset.index = index;
                
                // Add drag event listeners
                card.addEventListener('dragstart', handleDragStart);
                card.addEventListener('dragend', handleDragEnd);
                card.addEventListener('dragover', handleDragOver);
                card.addEventListener('drop', handleDrop);
                card.addEventListener('dragenter', handleDragEnter);
                card.addEventListener('dragleave', handleDragLeave);
                
                // Add visual feedback to drag handle
                dragHandle.addEventListener('mousedown', () => {
                    card.style.cursor = 'grabbing';
                });
                
                dragHandle.addEventListener('mouseup', () => {
                    card.style.cursor = 'grab';
                });
            }
        });
    }
    
    // Drag start handler
    function handleDragStart(e) {
        draggedElement = this;
        draggedIndex = parseInt(this.dataset.index);
        
        // Add dragging class for visual feedback
        this.classList.add('dragging');
        this.style.opacity = '0.5';
        this.style.transform = 'rotate(2deg)';
        
        // Set drag effect
        e.dataTransfer.effectAllowed = 'move';
        e.dataTransfer.setData('text/html', this.outerHTML);
    }
    
    // Drag end handler
    function handleDragEnd(e) {
        // Remove dragging class
        this.classList.remove('dragging');
        this.style.opacity = '1';
        this.style.transform = 'rotate(0deg)';
        this.style.cursor = 'grab';
        
        // Hide drop indicator
        if (dropIndicator && dropIndicator.parentNode) {
            dropIndicator.parentNode.removeChild(dropIndicator);
        }
        
        // Reset variables
        draggedElement = null;
        draggedIndex = -1;
    }
    
    // Drag over handler
    function handleDragOver(e) {
        e.preventDefault();
        e.dataTransfer.dropEffect = 'move';
        
        if (this === draggedElement) return;
        
        const rect = this.getBoundingClientRect();
        const midpoint = rect.top + rect.height / 2;
        const isAfter = e.clientY > midpoint;
        
        // Show drop indicator
        showDropIndicator(this, isAfter);
    }
    
    // Drag enter handler
    function handleDragEnter(e) {
        e.preventDefault();
        this.classList.add('drag-over');
    }
    
    // Drag leave handler
    function handleDragLeave(e) {
        this.classList.remove('drag-over');
    }
    
    // Drop handler
    function handleDrop(e) {
        e.preventDefault();
        this.classList.remove('drag-over');
        
        if (this === draggedElement) return;
        
        const rect = this.getBoundingClientRect();
        const midpoint = rect.top + rect.height / 2;
        const isAfter = e.clientY > midpoint;
        
        // Move the element
        moveElement(draggedElement, this, isAfter);
        
        // Update question numbers
        updateQuestionNumbersAfterDrag();
    }
    
    // Function to show drop indicator
    function showDropIndicator(targetElement, isAfter) {
        // Ensure drop indicator is created
        if (!dropIndicator) {
            createDropIndicator();
        }
        
        if (!dropIndicator) return;
        
        // Remove existing indicator
        if (dropIndicator.parentNode) {
            dropIndicator.parentNode.removeChild(dropIndicator);
        }
        
        // Insert indicator
        if (isAfter) {
            targetElement.parentNode.insertBefore(dropIndicator, targetElement.nextSibling);
        } else {
            targetElement.parentNode.insertBefore(dropIndicator, targetElement);
        }
        
        // Show with animation
        setTimeout(() => {
            if (dropIndicator) {
                dropIndicator.style.opacity = '1';
            }
        }, 10);
    }
    
    // Function to move element
    function moveElement(draggedEl, targetEl, isAfter) {
        const container = draggedEl.parentNode;
        
        if (isAfter) {
            container.insertBefore(draggedEl, targetEl.nextSibling);
        } else {
            container.insertBefore(draggedEl, targetEl);
        }
        
        // Update indices
        updateElementIndices();
    }
    
    // Function to update element indices
    function updateElementIndices() {
        const questionCards = document.querySelectorAll('.question-card');
        questionCards.forEach((card, index) => {
            card.dataset.index = index;
        });
    }
    
    // Function to update question numbers after drag
    function updateQuestionNumbersAfterDrag() {
        const questionCards = document.querySelectorAll('.question-card');
        let questionNumber = 1;
        
        questionCards.forEach(card => {
            const checkbox = card.querySelector('.question-checkbox');
            const questionNumberInput = card.querySelector('.question-number');
            
            if (checkbox && checkbox.checked && questionNumberInput) {
                questionNumberInput.value = questionNumber;
                questionNumber++;
            }
        });
    }
    
    // Function to load available dates
    function loadDates() {
        return fetch('{{ route("partner.questions.available-dates") }}', {
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.dates && data.dates.length > 0) {
                const dateFilter = document.getElementById('date-filter');
                if (dateFilter) {
                    // Clear existing options except the first one
                    dateFilter.innerHTML = '<option value="">All Dates</option>';
                    
                    // Add date options
                    data.dates.forEach(date => {
                        const option = document.createElement('option');
                        option.value = date;
                        // Format date as 'dd-Mon-YYYY'
                        const dateObj = new Date(date);
                        const day = dateObj.getDate().toString().padStart(2, '0');
                        const month = dateObj.toLocaleDateString('en-US', { month: 'short' });
                        const year = dateObj.getFullYear();
                        option.textContent = `${day}-${month}-${year}`;
                        dateFilter.appendChild(option);
                    });
                }
            }
        })
        .catch(error => {
            console.error('Error loading dates:', error);
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
                    if (questionType.q_type_code == '{{ request("question_type_filter") ?? "" }}') {
                        option.selected = true;
                    }
                    
                    questionTypeFilter.appendChild(option);
                });
            }
        })
        .catch(error => {
            questionTypeFilter.innerHTML = '<option value="">Error loading question types</option>';
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
        
        
        // Update browser URL without reloading
        window.history.pushState({}, '', currentUrl);
        
        // Perform AJAX request
        fetch(currentUrl.toString(), {
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => {
            return response.json();
        })
        .then(data => {
            // Update questions container
            if (data.questions_html && questionsContainer) {
                questionsContainer.innerHTML = data.questions_html;
                // Reattach checkbox listeners for new questions
                attachCheckboxListeners();
                // Reinitialize drag and drop for new questions
                initializeDragAndDrop();
            }
            
            // Update total questions count
            const currentTotalCount = document.getElementById('total-questions-count');
            if (data.total_count !== undefined && currentTotalCount) {
                currentTotalCount.textContent = data.total_count;
            }
            
            // Remove updating class
            if (questionsContainer) {
                questionsContainer.classList.remove('updating');
            }
            
        })
        .catch(error => {
            if (questionsContainer) {
                questionsContainer.classList.remove('updating');
            }
            alert('Search failed. Please try again. Error: ' + error.message);
        });
    }
});
</script>
