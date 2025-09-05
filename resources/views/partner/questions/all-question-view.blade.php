@extends('layouts.partner-layout')

@section('title', 'All Questions')

@section('content')
<style>
    /* Custom styles for the dropdown menu */
    .dropdown-menu {
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }
    
    .dropdown-menu.show {
        opacity: 1 !important;
        visibility: visible !important;
        transform: translateY(0) !important;
    }
    
    /* Hover effects for menu items */
    .menu-item {
        position: relative;
        overflow: hidden;
    }
    
    .menu-item::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
        transition: left 0.5s;
    }
    
    .menu-item:hover::before {
        left: 100%;
    }
    
    /* Icon animations */
    .icon-bounce {
        animation: bounce 0.6s ease-in-out;
    }
    
    @keyframes bounce {
        0%, 20%, 50%, 80%, 100% {
            transform: translateY(0);
        }
        40% {
            transform: translateY(-3px);
        }
        60% {
            transform: translateY(-2px);
        }
    }
</style>
<div class="space-y-6">
    <!-- Success/Error Messages -->
    @if (session('success'))
        <div class="bg-green-50 border border-green-200 rounded-lg p-4">
            <div class="flex">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-green-400" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                    </svg>
                </div>
                <div class="ml-3">
                    <p class="text-sm font-medium text-green-800">{{ session('success') }}</p>
                </div>
            </div>
        </div>
    @endif

    @if (session('import_errors'))
        <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
            <div class="flex">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-yellow-400" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                    </svg>
                </div>
                <div class="ml-3">
                    <h3 class="text-sm font-medium text-yellow-800">Import completed with some errors</h3>
                    <div class="mt-2 text-sm text-yellow-700">
                        <ul class="list-disc pl-5 space-y-1 max-h-40 overflow-y-auto">
                            @foreach (session('import_errors') as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <!-- Page Header -->
    <div class="bg-blue-50 border border-blue-200 rounded-lg p-6">
        <div class="flex justify-between items-center mb-6">
            <div class="text-left">
                <h1 class="text-3xl font-bold text-gray-900">All Questions</h1>
                <p class="mt-2 text-gray-600">Manage and filter your questions</p>
            </div>
            <!-- Decorative Add Question Menu -->
            <div class="relative group">
                <button type="button" class="group relative px-6 py-3 bg-gradient-to-r from-purple-600 to-blue-600 hover:from-purple-700 hover:to-blue-700 text-white rounded-lg shadow-lg hover:shadow-xl transition-all duration-300 transform hover:scale-105 flex items-center gap-3 font-medium">
                    <div class="flex items-center gap-2">
                        <svg class="w-6 h-6 transition-transform duration-300 group-hover:rotate-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                        </svg>
                        <span class="text-lg font-semibold">Add Question</span>
                    </div>
                    <svg class="w-4 h-4 transition-transform duration-300 group-hover:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                    </svg>
                    <div class="absolute inset-0 bg-white opacity-0 group-hover:opacity-10 rounded-lg transition-opacity duration-300"></div>
                </button>
                
                <!-- Dropdown Menu -->
                <div class="absolute right-0 mt-2 w-64 bg-white rounded-lg shadow-xl border border-gray-200 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300 transform translate-y-2 group-hover:translate-y-0 z-50">
                    <div class="py-2">
                        <!-- MCQ Option -->
                        <a href="{{ route('partner.questions.mcq.create') }}" class="menu-item flex items-center px-4 py-3 text-gray-700 hover:bg-blue-50 hover:text-blue-700 transition-colors duration-200 group/item">
                            <div class="flex-shrink-0 w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center mr-3 group-hover/item:bg-blue-200 transition-colors duration-200">
                                <svg class="w-5 h-5 text-blue-600 icon-bounce" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                </svg>
                            </div>
                            <div class="flex-1">
                                <div class="font-medium text-sm">Multiple Choice Question</div>
                                <div class="text-xs text-gray-500">Create MCQ with 4 options</div>
                            </div>
                            <svg class="w-4 h-4 text-gray-400 group-hover/item:text-blue-600 transition-colors duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                            </svg>
                        </a>
                        
                        <!-- Descriptive Option -->
                        <a href="{{ route('partner.questions.descriptive.create') }}" class="menu-item flex items-center px-4 py-3 text-gray-700 hover:bg-green-50 hover:text-green-700 transition-colors duration-200 group/item">
                            <div class="flex-shrink-0 w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center mr-3 group-hover/item:bg-green-200 transition-colors duration-200">
                                <svg class="w-5 h-5 text-green-600 icon-bounce" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                </svg>
                            </div>
                            <div class="flex-1">
                                <div class="font-medium text-sm">Descriptive Question</div>
                                <div class="text-xs text-gray-500">Create open-ended questions</div>
                            </div>
                            <svg class="w-4 h-4 text-gray-400 group-hover/item:text-green-600 transition-colors duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                            </svg>
                        </a>
                        
                        <!-- True/False Option -->
                        <a href="{{ route('partner.questions.tf.create') }}" class="menu-item flex items-center px-4 py-3 text-gray-700 hover:bg-orange-50 hover:text-orange-700 transition-colors duration-200 group/item">
                            <div class="flex-shrink-0 w-10 h-10 bg-orange-100 rounded-lg flex items-center justify-center mr-3 group-hover/item:bg-orange-200 transition-colors duration-200">
                                <svg class="w-5 h-5 text-orange-600 icon-bounce" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </div>
                            <div class="flex-1">
                                <div class="font-medium text-sm">True/False Question</div>
                                <div class="text-xs text-gray-500">Create binary choice questions</div>
                            </div>
                            <svg class="w-4 h-4 text-gray-400 group-hover/item:text-orange-600 transition-colors duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                            </svg>
                        </a>
                        
                        <!-- Divider -->
                        <div class="border-t border-gray-100 my-2"></div>
                        
                        <!-- Bulk Upload Option -->
                        <a href="{{ route('partner.questions.bulk-upload') }}" class="menu-item flex items-center px-4 py-3 text-gray-700 hover:bg-gray-50 hover:text-gray-900 transition-colors duration-200 group/item">
                            <div class="flex-shrink-0 w-10 h-10 bg-gray-100 rounded-lg flex items-center justify-center mr-3 group-hover/item:bg-gray-200 transition-colors duration-200">
                                <svg class="w-5 h-5 text-gray-600 icon-bounce" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                                </svg>
                            </div>
                            <div class="flex-1">
                                <div class="font-medium text-sm">Bulk Upload</div>
                                <div class="text-xs text-gray-500">Upload multiple questions via CSV/Excel</div>
                            </div>
                            <svg class="w-4 h-4 text-gray-400 group-hover/item:text-gray-600 transition-colors duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Search and Filters -->
        <div class="mt-6">
            <form method="GET" id="filterForm" class="space-y-4">
                <input type="hidden" name="search" id="searchHidden" value="{{ request('search') }}">
                
                <!-- Search Bar -->
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                    </div>
                    <input type="text" 
                           id="searchInput" 
                           class="block w-full pl-10 pr-12 py-2 border border-gray-300 rounded-md leading-5 bg-white placeholder-gray-500 focus:outline-none focus:placeholder-gray-400 focus:ring-1 focus:ring-blue-500 focus:border-blue-500" 
                           placeholder="Search questions..." 
                           value="{{ request('search') }}">
                    <div class="absolute inset-y-0 right-0 flex items-center">
                        <div id="searchLoading" class="hidden pr-3">
                            <svg class="animate-spin h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Filters -->
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <div class="filter-group">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Course</label>
                        <select name="course_filter" id="course_filter" class="w-full rounded-md border border-gray-300 p-2 bg-white text-gray-900 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            <option value="">All Courses</option>
                        </select>
                    </div>
                    
                    <div class="filter-group">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Subject</label>
                        <select name="subject_filter" id="subject_filter" class="w-full rounded-md border border-gray-300 p-2 bg-white text-gray-900 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            <option value="">All Subjects</option>
                        </select>
                    </div>
                    
                    <div class="filter-group">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Topic</label>
                        <select name="topic_filter" id="topic_filter" class="w-full rounded-md border border-gray-300 p-2 bg-white text-gray-900 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            <option value="">All Topics</option>
                        </select>
                    </div>
                    
                    <div class="filter-group">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Question Type</label>
                        <select name="question_type_filter" id="question_type_filter" class="w-full rounded-md border border-gray-300 p-2 bg-white text-gray-900 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            <option value="">All Types</option>
                        </select>
                    </div>
                    
                </div>
                
                <div class="flex items-center gap-2">
                    <button type="button" id="refreshQuestions" class="px-4 py-2 bg-blue-500 hover:bg-blue-600 text-white rounded-md transition-colors duration-200 flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                        </svg>
                        Refresh
                    </button>
                    <button type="button" id="clearAllFilters" class="px-4 py-2 bg-gray-500 hover:bg-gray-600 text-white rounded-md transition-colors duration-200">
                        Clear All
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Questions List -->
    <div class="bg-white rounded-lg shadow border border-gray-200">
        <div class="p-6 border-b border-gray-200">
            <h2 class="text-lg font-semibold text-gray-900">
                Questions ({{ $questions->total() }})
            </h2>
        </div>

        @if($questions->count() > 0)
            <div class="divide-y divide-gray-200 questions-container">
                @foreach($questions as $question)
                    <div class="p-4 hover:bg-gray-50 transition-colors duration-200 border-l-4 border-transparent hover:border-green-500" data-question-id="{{ $question->id }}">
                        <div class="flex items-start gap-4">
                            <div class="flex flex-col items-start gap-2 min-w-[120px]">
                                <a href="{{ route('partner.questions.common-view', $question) }}"
                                   class="text-sm font-medium text-blue-600 hover:text-blue-800 transition-colors duration-200">
                                    View Question
                                </a>
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                    {{ $question->question_type === 'mcq' ? 'bg-blue-100 text-blue-800' : ($question->question_type === 'true_false' ? 'bg-orange-100 text-orange-800' : 'bg-green-100 text-green-800') }}">
                                    {{ $question->question_type === 'mcq' ? 'MCQ' : ($question->question_type === 'true_false' ? 'True/False' : 'Descriptive') }}
                                </span>
                            </div>
                            
                            <div class="flex-1 min-w-0">
                                <div class="text-sm text-gray-900 mb-2 prose prose-sm max-w-none">
                                    {!! Str::limit(strip_tags($question->question_text, '<b><i><u><strong><em><br><p><span><div>'), 200) !!}
                                </div>
                                
                                <div class="flex flex-wrap gap-4 text-xs text-gray-500">
                                    <span><strong>Course:</strong> {{ $question->course->name ?? 'N/A' }}</span>
                                    <span><strong>Subject:</strong> {{ $question->subject->name ?? 'N/A' }}</span>
                                    <span><strong>Topic:</strong> {{ $question->topic->name ?? 'N/A' }}</span>
                                    @if($question->questionType)
                                        <span><strong>Type:</strong> {{ $question->questionType->q_type_name }}</span>
                                    @endif
                                </div>
                            </div>
                            
                            <div class="flex flex-col items-end gap-2">
                                <div class="text-xs text-gray-500">
                                    Created: {{ $question->created_at->format('M d, Y') }}
                                </div>
                                <div class="flex gap-2">
                                    <a href="{{ route('partner.questions.common-view', $question) }}" 
                                       class="text-green-600 hover:text-green-800 text-sm font-medium transition-colors duration-200">
                                        View
                                    </a>
                                    @if($question->question_type === 'descriptive')
                                        <a href="{{ route('partner.questions.descriptive.edit', $question) }}" 
                                           class="text-blue-600 hover:text-blue-800 text-sm font-medium transition-colors duration-200">
                                            Edit
                                        </a>
                                    @elseif($question->question_type === 'mcq')
                                    <a href="{{ route('partner.questions.mcq.edit', $question) }}" 
                                       class="text-blue-600 hover:text-blue-800 text-sm font-medium transition-colors duration-200">
                                        Edit
                                    </a>
                                    @elseif($question->question_type === 'true_false')
                                        <a href="{{ route('partner.questions.tf.edit', $question) }}" 
                                           class="text-blue-600 hover:text-blue-800 text-sm font-medium transition-colors duration-200">
                                            Edit
                                        </a>
                                    @else
                                        <a href="{{ route('partner.questions.edit', $question) }}" 
                                           class="text-blue-600 hover:text-blue-800 text-sm font-medium transition-colors duration-200">
                                            Edit
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            
            <!-- Pagination -->
            <div class="p-6 border-t border-gray-200">
                {{ $questions->links() }}
            </div>
        @else
            <div class="p-12 text-center questions-container">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <h3 class="mt-2 text-sm font-medium text-gray-900">
                    @if(request('search'))
                        No questions found for "{{ request('search') }}"
                    @else
                        No questions found
                    @endif
                </h3>
                <p class="mt-1 text-sm text-gray-500">
                    @if(request('search'))
                        Try adjusting your search terms or filters.
                    @else
                        Get started by creating a new question.
                    @endif
                </p>
                <div class="mt-6 flex gap-3">
                    <a href="{{ route('partner.questions.mcq.create') }}" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-md transition-colors duration-200">
                        Create MCQ
                    </a>
                    <a href="{{ route('partner.questions.descriptive.create') }}" class="px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-md transition-colors duration-200">
                        Create Descriptive
                    </a>
                    <a href="{{ route('partner.questions.tf.create') }}" class="group relative px-6 py-3 bg-gradient-to-r from-orange-500 to-orange-600 hover:from-orange-600 hover:to-orange-700 text-white rounded-lg shadow-lg hover:shadow-xl transition-all duration-300 transform hover:scale-105 flex items-center gap-2 font-medium">
                        <svg class="w-5 h-5 transition-transform duration-300 group-hover:rotate-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        Create True/False
                        <div class="absolute inset-0 bg-white opacity-0 group-hover:opacity-10 rounded-lg transition-opacity duration-300"></div>
                    </a>
                </div>
            </div>
        @endif
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
            
            // Extract the questions list and pagination
            const newQuestionsList = tempDiv.querySelector('.divide-y.divide-gray-200');
            const newEmptyState = tempDiv.querySelector('.p-12.text-center');
            const newPagination = tempDiv.querySelector('.p-6.border-t');
            const newQuestionsCount = tempDiv.querySelector('.text-lg.font-semibold');
            
            console.log('Extracted elements:', {
                questionsList: newQuestionsList ? 'found' : 'not found',
                emptyState: newEmptyState ? 'found' : 'not found',
                pagination: newPagination ? 'found' : 'not found',
                questionsCount: newQuestionsCount ? newQuestionsCount.textContent : 'not found'
            });
            
            // Update the page content
            const existingQuestionsContainer = document.querySelector('.questions-container');
            if (existingQuestionsContainer) {
                if (newQuestionsList) {
                    // There are questions - show the questions list
                    console.log('Updating with questions list');
                    existingQuestionsContainer.innerHTML = newQuestionsList.outerHTML;
                    
                    // Count questions in the new content
                    const questionItems = newQuestionsList.querySelectorAll('[data-question-id]');
                    console.log('Questions displayed after update:', questionItems.length);
                } else if (newEmptyState) {
                    // No questions - show empty state
                    console.log('Updating with empty state');
                    existingQuestionsContainer.innerHTML = newEmptyState.outerHTML;
                    console.log('Empty state displayed');
                }
            }
            
            if (newPagination) {
                const existingPagination = document.querySelector('.p-6.border-t');
                if (existingPagination) {
                    existingPagination.innerHTML = newPagination.innerHTML;
                }
            }
            
            if (newQuestionsCount) {
                const existingQuestionsCount = document.querySelector('.text-lg.font-semibold');
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
