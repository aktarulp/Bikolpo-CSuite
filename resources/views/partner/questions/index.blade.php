@extends('layouts.partner-layout')

@section('title', 'Questions')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900 dark:text-gray-100">
                <!-- Header Section -->
                <div class="mb-6">
                    <div class="flex flex-col lg:flex-row lg:justify-between lg:items-start gap-4">
                        <!-- Title Section -->
                        <div class="flex-1">
                            <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-2">All Questions</h1>
                            <p class="text-gray-600 dark:text-gray-400">Manage and filter your questions</p>
                        </div>
                        
                        <!-- Action Buttons -->
                        <div class="flex flex-wrap gap-3">
                            <a href="{{ route('partner.questions.drafts') }}" 
                               class="px-4 py-2 bg-orange-500 hover:bg-orange-600 text-white rounded-lg transition-colors duration-200 flex items-center gap-2 text-sm font-medium">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                                View Drafts
                            </a>
                            <div class="relative group">
                                <button class="px-4 py-2 bg-gradient-to-r from-green-500 to-blue-500 hover:from-green-600 hover:to-blue-600 text-white rounded-lg transition-all duration-200 flex items-center gap-2 text-sm font-medium">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                                    </svg>
                                    Add Question
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                    </svg>
                                </button>
                                <!-- Dropdown Menu -->
                                <div class="absolute right-0 mt-2 w-48 bg-white dark:bg-gray-800 rounded-lg shadow-lg border border-gray-200 dark:border-gray-700 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 z-10">
                                    <div class="py-1">
                                        <a href="{{ route('partner.questions.mcq.create') }}" 
                                           class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors duration-200">
                                            Create MCQ Question
                                        </a>
                                        <a href="{{ route('partner.questions.descriptive.create') }}" 
                                           class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors duration-200">
                                            Create Descriptive Question
                                        </a>
                                        <hr class="my-1 border-gray-200 dark:border-gray-600">
                                        <a href="{{ route('partner.check-session') }}" 
                                           class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors duration-200">
                                            Session & Seed MCQ
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Search and Filters Section -->
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 p-6 mb-6">
                    <form method="GET" class="space-y-4">
                        <!-- Search Bar -->
                        <div class="relative">
                            <input type="text" 
                                   name="search" 
                                   value="{{ request('search') }}"
                                   placeholder="Search questions..."
                                   class="w-full pl-10 pr-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg text-sm bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                </svg>
                            </div>
                        </div>

                        <!-- Filters -->
                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                            <div>
                                <select name="course" class="w-full rounded-lg border border-gray-300 dark:border-gray-600 p-3 text-sm bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200">
                                    <option value="">All Courses</option>
                                    @foreach($courses ?? [] as $course)
                                        <option value="{{ $course->id }}" {{ request('course') == $course->id ? 'selected' : '' }}>
                                            {{ $course->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <select name="subject" class="w-full rounded-lg border border-gray-300 dark:border-gray-600 p-3 text-sm bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200">
                                    <option value="">All Subjects</option>
                                    @foreach($subjects ?? [] as $subject)
                                        <option value="{{ $subject->id }}" {{ request('subject') == $subject->id ? 'selected' : '' }}>
                                            {{ $subject->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <select name="topic" class="w-full rounded-lg border border-gray-300 dark:border-gray-600 p-3 text-sm bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200">
                                    <option value="">All Topics</option>
                                    @foreach($topics ?? [] as $topic)
                                        <option value="{{ $topic->id }}" {{ request('topic') == $topic->id ? 'selected' : '' }}>
                                            {{ $topic->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <select name="question_type" class="w-full rounded-lg border border-gray-300 dark:border-gray-600 p-3 text-sm bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200">
                                    <option value="">All Types</option>
                                    @foreach($questionTypes ?? [] as $questionType)
                                        <option value="{{ $questionType->q_type_id }}" {{ request('question_type') == $questionType->q_type_id ? 'selected' : '' }}>
                                            {{ $questionType->q_type_name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="flex justify-end gap-3">
                            <button type="submit" 
                                    class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition-colors duration-200 text-sm flex items-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                                </svg>
                                Refresh
                            </button>
                            @if(request()->hasAny(['search', 'course', 'subject', 'topic', 'question_type']))
                                <a href="{{ route('partner.questions.index') }}" 
                                   class="px-4 py-2 bg-gray-500 hover:bg-gray-600 text-white rounded-lg transition-colors duration-200 text-sm flex items-center gap-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                    </svg>
                                    Clear All
                                </a>
                            @endif
                        </div>
                    </form>
                </div>

    <!-- Questions List -->
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700">
        <div class="px-4 py-3 border-b border-gray-200 dark:border-gray-700">
            <h2 class="text-base font-semibold text-gray-900 dark:text-white">
                Questions ({{ $questions->total() }})
            </h2>
        </div>

        @if($questions->count() > 0)
            <div class="divide-y divide-gray-200 dark:divide-gray-700">
                @foreach($questions as $index => $question)
                    <div class="px-4 py-3 hover:bg-gray-50 dark:hover:bg-gray-700 transition-all duration-200 border-l-4 border-transparent hover:border-primaryGreen {{ $index % 2 == 0 ? 'bg-white dark:bg-gray-800' : 'bg-gray-50 dark:bg-gray-750' }}">
                        <div class="flex items-start gap-3">
                            <div class="flex flex-col items-start gap-1.5 min-w-[100px]">
                                <a href="{{ route('partner.questions.edit', $question) }}" 
                                   class="inline-flex items-center gap-1.5 px-2 py-1 text-xs text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300 hover:bg-blue-50 dark:hover:bg-blue-900/20 rounded-md transition-colors duration-200">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                    </svg>
                                    Edit
                                </a>
                                <form action="{{ route('partner.questions.destroy', $question) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                            class="inline-flex items-center gap-1.5 px-2 py-1 text-xs text-red-600 hover:text-red-800 dark:text-red-400 dark:hover:text-red-300 hover:bg-red-50 dark:hover:bg-red-900/20 rounded-md transition-colors duration-200"
                                            onclick="return confirm('Are you sure you want to delete this question?')">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                        </svg>
                                        Delete
                                    </button>
                                </form>
                            </div>
                            <div class="flex-1">
                                <div class="flex items-center gap-2 mb-2 flex-wrap">
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-blue-50 dark:bg-blue-900/30 text-blue-700 dark:text-blue-300 border border-blue-200 dark:border-blue-800">
                                        {{ $question->topic->subject->course->name }}
                                    </span>
                                    <span class="text-gray-400 dark:text-gray-500 text-xs">→</span>
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-purple-50 dark:bg-purple-900/30 text-purple-700 dark:text-purple-300 border border-purple-200 dark:border-purple-800">
                                        {{ $question->topic->subject->name }}
                                    </span>
                                    <span class="text-gray-400 dark:text-gray-500 text-xs">→</span>
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-green-50 dark:bg-green-900/30 text-green-700 dark:text-green-300 border border-green-200 dark:border-green-800">
                                        {{ $question->topic->name }}
                                    </span>

                                    @if($question->questionType)
                                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-indigo-50 dark:bg-indigo-900/30 text-indigo-700 dark:text-indigo-300 border border-indigo-200 dark:border-indigo-800">
                                            {{ $question->questionType->q_type_code }}
                                        </span>
                                    @endif
                                </div>
                                
                                <h3 class="text-sm font-medium text-gray-900 dark:text-white mb-2 leading-relaxed flex items-center gap-2">
                                    {!! Str::limit($question->question_text, 120) !!}
                                    @if($question->image)
                                        <div class="relative group">
                                            <svg class="w-4 h-4 text-blue-500 hover:text-blue-700 cursor-pointer transition-colors duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24" title="View Image">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                            </svg>
                                            <!-- Image Preview Tooltip -->
                                            <div class="absolute bottom-full left-1/2 transform -translate-x-1/2 mb-2 opacity-0 group-hover:opacity-100 transition-all duration-300 pointer-events-none z-50 scale-95 group-hover:scale-100 image-preview-tooltip">
                                                <div class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-600 rounded-lg shadow-xl p-3">
                                                    <img src="{{ asset('storage/' . $question->image) }}" 
                                                         alt="Question Image" 
                                                         class="rounded">
                                                </div>
                                                <!-- Arrow -->
                                                <div class="absolute top-full left-1/2 transform -translate-x-1/2 w-0 h-0 border-l-4 border-r-4 border-t-4 border-transparent border-t-gray-200 dark:border-t-gray-600"></div>
                                                <div class="absolute top-full left-1/2 transform -translate-x-1/2 w-0 h-0 border-l-3 border-r-3 border-t-3 border-transparent border-t-white dark:border-t-gray-800 -mt-1"></div>
                                            </div>
                                        </div>
                                    @endif
                                </h3>
                                
                                <div class="flex gap-2 text-xs">
                                    <span class="inline-flex items-center px-2 py-1 rounded-md shadow-sm {{ $question->correct_answer === 'a' ? 'bg-gradient-to-r from-green-50 to-emerald-50 dark:from-green-900/40 dark:to-emerald-900/40 border-2 border-green-300 dark:border-green-600 text-green-800 dark:text-green-200 font-medium shadow-green-100 dark:shadow-green-900/20' : 'bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-600 text-gray-700 dark:text-gray-300 hover:border-gray-300 dark:hover:border-gray-500 transition-colors duration-200' }}">
                                        <span class="font-bold mr-1.5 text-xs {{ $question->correct_answer === 'a' ? 'text-green-700 dark:text-green-300' : 'text-gray-500 dark:text-gray-400' }}">A</span> 
                                        {!! Str::limit($question->option_a, 35) !!}
                                        @if($question->correct_answer === 'a')
                                            <svg class="w-3 h-3 ml-1.5 text-green-600 dark:text-green-400" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                            </svg>
                                        @endif
                                    </span>
                                    <span class="inline-flex items-center px-2 py-1 rounded-md shadow-sm {{ $question->correct_answer === 'b' ? 'bg-gradient-to-r from-green-50 to-emerald-50 dark:from-green-900/40 dark:to-emerald-900/40 border-2 border-green-300 dark:border-green-600 text-green-800 dark:text-green-200 font-medium shadow-green-100 dark:shadow-green-900/20' : 'bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-600 text-gray-700 dark:text-gray-300 hover:border-gray-300 dark:hover:border-gray-500 transition-colors duration-200' }}">
                                        <span class="font-bold mr-1.5 text-xs {{ $question->correct_answer === 'b' ? 'text-green-700 dark:text-green-300' : 'text-gray-500 dark:text-gray-400' }}">B</span> 
                                        {!! Str::limit($question->option_b, 35) !!}
                                        @if($question->correct_answer === 'b')
                                            <svg class="w-3 h-3 ml-1.5 text-green-600 dark:text-green-400" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                            </svg>
                                        @endif
                                    </span>
                                    <span class="inline-flex items-center px-2 py-1 rounded-md shadow-sm {{ $question->correct_answer === 'c' ? 'bg-gradient-to-r from-green-50 to-emerald-50 dark:from-green-900/40 dark:to-emerald-900/40 border-2 border-green-300 dark:border-green-600 text-green-800 dark:text-green-200 font-medium shadow-green-100 dark:shadow-green-900/20' : 'bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-600 text-gray-700 dark:text-gray-300 hover:border-gray-300 dark:hover:border-gray-500 transition-colors duration-200' }}">
                                        <span class="font-bold mr-1.5 text-xs {{ $question->correct_answer === 'c' ? 'text-green-700 dark:text-green-300' : 'text-gray-500 dark:text-gray-400' }}">C</span> 
                                        {!! Str::limit($question->option_c, 35) !!}
                                        @if($question->correct_answer === 'c')
                                            <svg class="w-3 h-3 ml-1.5 text-green-600 dark:text-green-400" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                            </svg>
                                        @endif
                                    </span>
                                    <span class="inline-flex items-center px-2 py-1 rounded-md shadow-sm {{ $question->correct_answer === 'd' ? 'bg-gradient-to-r from-green-50 to-emerald-50 dark:from-green-900/40 dark:to-emerald-900/40 border-2 border-green-300 dark:border-green-600 text-green-800 dark:text-green-200 font-medium shadow-green-100 dark:shadow-green-900/20' : 'bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-600 text-gray-700 dark:text-gray-300 hover:border-gray-300 dark:hover:border-gray-500 transition-colors duration-200' }}">
                                        <span class="font-bold mr-1.5 text-xs {{ $question->correct_answer === 'd' ? 'text-green-700 dark:text-green-300' : 'text-gray-500 dark:text-gray-400' }}">D</span> 
                                        {!! Str::limit($question->option_d, 35) !!}
                                        @if($question->correct_answer === 'd')
                                            <svg class="w-3 h-3 ml-1.5 text-green-600 dark:text-green-400" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                            </svg>
                                        @endif
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            
            <!-- Pagination -->
            <div class="px-4 py-3 border-t border-gray-200 dark:border-gray-700">
                {{ $questions->links() }}
            </div>
        @else
            <div class="p-8 text-center">
                <svg class="mx-auto h-10 w-10 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <h3 class="mt-2 text-sm font-medium text-gray-900 dark:text-white">No questions</h3>
                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Get started by creating a new question.</p>
                <div class="mt-4 flex gap-2 justify-center">
                    <a href="{{ route('partner.questions.mcq.create') }}" 
                       class="inline-flex items-center px-3 py-1.5 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700">
                        + MCQ
                    </a>
                    <a href="{{ route('partner.questions.descriptive.create') }}" 
                       class="inline-flex items-center px-3 py-1.5 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-green-600 hover:bg-green-700">
                        + Descriptive
                    </a>
                    
                </div>
            </div>
        @endif
    </div>
</div>

<style>
.image-preview-tooltip {
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    transform-origin: bottom center;
}

.image-preview-tooltip.group:hover\:opacity-100 {
    transition-delay: 0.1s;
}

.image-preview-tooltip img {
    max-width: 300px;
    max-height: 200px;
    object-fit: contain;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Get all filter select elements
    const filterSelects = document.querySelectorAll('select[name="course"], select[name="subject"], select[name="topic"], select[name="question_type"]');
    const searchInput = document.querySelector('input[name="search"]');
    const form = document.querySelector('form');
    
    // Add change event listener to each filter
    filterSelects.forEach(select => {
        select.addEventListener('change', function() {
            // Submit the form automatically when any filter changes
            form.submit();
        });
    });
    
    // Handle search input with debouncing
    let searchTimeout;
    if (searchInput) {
        searchInput.addEventListener('input', function() {
            clearTimeout(searchTimeout);
            searchTimeout = setTimeout(() => {
                // Only search if input has 2+ characters or is empty
                if (this.value.length >= 2 || this.value.length === 0) {
                    form.submit();
                }
            }, 500);
        });
    }
    
    // Add loading indicator when form is submitted
    form.addEventListener('submit', function() {
        const submitBtn = this.querySelector('button[type="submit"]');
        if (submitBtn) {
            submitBtn.innerHTML = `
                <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                Searching...
            `;
            submitBtn.disabled = true;
        }
    });
    
    // Show active filters count
    function updateActiveFiltersCount() {
        const activeFilters = [];
        
        if (searchInput && searchInput.value.trim()) {
            activeFilters.push('Search');
        }
        
        filterSelects.forEach(select => {
            if (select.value) {
                activeFilters.push(select.previousElementSibling.textContent.trim());
            }
        });
        
        // Update or create filter count badge
        let badge = document.querySelector('.filter-count-badge');
        if (activeFilters.length > 0) {
            if (!badge) {
                badge = document.createElement('span');
                badge.className = 'filter-count-badge ml-2 inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200';
                document.querySelector('h2').appendChild(badge);
            }
            badge.textContent = `${activeFilters.length} filter${activeFilters.length > 1 ? 's' : ''} active`;
        } else if (badge) {
            badge.remove();
        }
    }
    
    // Initialize filter count
    updateActiveFiltersCount();
    
    // Update count when filters change
    filterSelects.forEach(select => {
        select.addEventListener('change', updateActiveFiltersCount);
    });
    
    if (searchInput) {
        searchInput.addEventListener('input', updateActiveFiltersCount);
    }
});
</script>

@endsection 
