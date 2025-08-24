@extends('layouts.partner-layout')

@section('title', 'All Questions')

@section('content')
<div class="space-y-6">
    <!-- Search Bar -->
    <div class="search-bar-container bg-gradient-to-r from-blue-50 to-indigo-50 dark:from-blue-900/20 dark:to-indigo-900/20 rounded-xl shadow-lg border-2 border-blue-200 dark:border-blue-700 p-6">
        <!-- Page Header Moved Here -->
        <div class="flex justify-between items-center mb-6">
            <div class="text-left">
                <h1 class="text-3xl font-bold text-gray-900 dark:text-white">All Questions</h1>
                <p class="text-gray-600 dark:text-gray-400">Manage your questions of all types</p>
            </div>
            
            <!-- Action Buttons -->
            <div class="flex gap-3">
                <a href="{{ route('partner.questions.mcq.create') }}" 
                   class="bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white px-4 py-2.5 rounded-lg transition-all duration-300 flex items-center gap-2.5 shadow-lg hover:shadow-xl transform hover:-translate-y-1 border-2 border-blue-400">
                    <div class="w-6 h-6 bg-white/20 rounded-lg flex items-center justify-center">
                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/>
                        </svg>
                    </div>
                    <div class="text-left">
                        <div class="font-bold text-base">+ MCQ</div>
                        <div class="text-xs text-blue-100">Multiple Choice</div>
                    </div>
                </a>
                <a href="{{ route('partner.questions.descriptive.create') }}" 
                   class="bg-gradient-to-r from-green-500 to-emerald-600 hover:from-green-600 hover:to-emerald-700 text-white px-4 py-2.5 rounded-lg transition-all duration-300 flex items-center gap-2.5 shadow-lg hover:shadow-xl transform hover:-translate-y-1 border-2 border-green-400">
                    <div class="w-6 h-6 bg-white/20 rounded-lg flex items-center justify-center">
                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                        </svg>
                    </div>
                    <div class="text-left">
                        <div class="font-bold text-base">+ CQ</div>
                        <div class="text-xs text-green-100">Comprehensive</div>
                    </div>
                </a>
            </div>
        </div>

        <div class="relative">
            <input type="text" 
                   id="searchInput" 
                   name="search" 
                   value="{{ request('search') }}"
                   placeholder="🔍 Type to search questions, options, explanations, courses, subjects, topics..." 
                   class="block w-full {{ request('search') ? 'pl-4 pr-16' : 'pl-4 pr-14' }} py-4 border-2 border-blue-300 dark:border-blue-600 rounded-xl leading-6 bg-white dark:bg-gray-800 text-gray-900 dark:text-white placeholder-gray-500 dark:placeholder-gray-400 focus:outline-none focus:ring-4 focus:ring-blue-500/20 focus:border-blue-500 dark:focus:ring-blue-400/20 dark:focus:border-blue-400 transition-all duration-300 text-lg shadow-inner search-input">
            
            <!-- Loading Indicator -->
            <div id="searchLoading" class="absolute inset-y-0 right-0 pr-16 flex items-center hidden">
                <svg class="animate-spin h-6 w-6 text-blue-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
            </div>
            
            <!-- Search Status Indicator -->
            <div id="searchStatus" class="absolute inset-y-0 right-0 pr-20 flex items-center hidden">
                <span class="text-xs text-blue-500 font-medium">Searching...</span>
            </div>
            
            <!-- Clear Search Button -->
            @if(request('search'))
                <button type="button" 
                        id="clearSearch" 
                        class="absolute inset-y-0 right-0 pr-4 flex items-center text-gray-400 hover:text-red-500 dark:hover:text-red-400 transition-colors duration-200"
                        title="Clear search">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            @endif
        </div>
        
        <!-- Search Results Info -->
        @if(request('search'))
            <div class="mt-4 p-3 bg-blue-100 dark:bg-blue-900/30 rounded-lg border border-blue-200 dark:border-blue-700">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-2 text-sm text-blue-800 dark:text-blue-200">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <span class="font-medium">Search results for:</span> "<span class="font-bold">{{ request('search') }}</span>"
                    </div>
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-blue-200 dark:bg-blue-700 text-blue-800 dark:text-blue-200">
                        {{ $questions->total() }} questions found
                    </span>
                </div>
            </div>
        @endif
        
        <!-- Filters -->
        <div class="mt-6">
            <form method="GET" id="filterForm" class="grid grid-cols-1 md:grid-cols-5 gap-4">
                <input type="hidden" name="search" id="searchHidden" value="{{ request('search') }}">
                <div>
                    <select name="course_filter" class="w-full rounded-md border border-gray-300 dark:border-gray-600 p-2 bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
                        <option value="">All Courses</option>
                        @foreach($courses ?? [] as $course)
                            <option value="{{ $course->id }}" {{ request('course_filter') == $course->id ? 'selected' : '' }}>
                                {{ $course->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <select name="subject_filter" class="w-full rounded-md border border-gray-300 dark:border-gray-600 p-2 bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
                        <option value="">All Subjects</option>
                        @foreach($subjects ?? [] as $subject)
                            <option value="{{ $subject->id }}" {{ request('subject_filter') == $subject->id ? 'selected' : '' }}>
                                {{ $subject->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <select name="topic_filter" class="w-full rounded-md border border-gray-300 dark:border-gray-600 p-2 bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
                        <option value="">All Topics</option>
                        @foreach($topics ?? [] as $topic)
                            <option value="{{ $topic->id }}" {{ request('topic_filter') == $topic->id ? 'selected' : '' }}>
                                {{ $topic->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <select name="question_type_filter" class="w-full rounded-md border border-gray-300 dark:border-gray-600 p-2 bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
                        <option value="">All Types</option>
                        @foreach($questionTypes ?? [] as $questionType)
                            <option value="{{ $questionType->q_type_code }}" {{ request('question_type_filter') == $questionType->q_type_code ? 'selected' : '' }}>
                                {{ $questionType->q_type_name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                
                <div class="flex items-end gap-2">
                    <a href="{{ route('partner.questions.all') }}" class="px-4 py-2 bg-gray-500 hover:bg-gray-600 text-white rounded-md transition-colors duration-200 text-center">
                        Clear All
                    </a>
                </div>
            </form>
        </div>
    </div>

    <!-- Questions List -->
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md">
        <div class="p-6 border-b border-gray-200 dark:border-gray-700">
            <h2 class="text-lg font-semibold text-gray-900 dark:text-white">
                Questions ({{ $questions->total() }})
            </h2>
        </div>

        @if($questions->count() > 0)
            <div class="divide-y divide-gray-200 dark:divide-gray-700 questions-container">
                @foreach($questions as $question)
                    <div class="p-4 hover:bg-gray-50 dark:hover:bg-gray-700 transition-all duration-200 border-l-4 border-transparent hover:border-primaryGreen">
                        <div class="flex items-start gap-4">
                            <div class="flex flex-col items-start gap-2 min-w-[120px]">
                                <a href="{{ route('partner.questions.mcq.show', $question) }}" 
                                   class="inline-flex items-center gap-2 px-3 py-2 text-sm text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300 hover:bg-blue-50 dark:hover:bg-blue-900/20 rounded-md transition-colors duration-200">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                    </svg>
                                    View
                                </a>
                                <a href="{{ route('partner.questions.mcq.edit', $question) }}" 
                                   class="inline-flex items-center gap-2 px-3 py-2 text-sm text-green-600 hover:text-green-800 dark:text-green-400 dark:hover:text-green-300 hover:bg-green-50 dark:hover:bg-green-900/20 rounded-md transition-colors duration-200">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                    </svg>
                                    Edit
                                </a>
                            </div>
                            <div class="flex-1">
                                <div class="flex items-center gap-3 mb-3">
                                    <span class="inline-flex items-center px-3 py-1.5 rounded-full text-sm font-bold bg-gradient-to-r from-orange-400 to-red-500 text-white border-2 border-orange-300 shadow-lg shadow-orange-200 dark:shadow-orange-900/30 transform hover:scale-105 transition-all duration-200">
                                        @if($question->questionType->q_type_name === 'Descriptive')
                                            CQ
                                        @else
                                            {{ $question->questionType->q_type_name ?? 'N/A' }}
                                        @endif
                                        @if($question->questionType->q_type_name === 'MCQ')
                                            <svg class="w-4 h-4 ml-1.5" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M3 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z" clip-rule="evenodd"/>
                                            </svg>
                                        @elseif($question->questionType->q_type_name === 'Descriptive')
                                            <svg class="w-4 h-4 ml-1.5" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4zm2 6a1 1 0 011-1h6a1 1 0 110 2H8a1 1 0 01-1-1zm1 3a1 0 100 2h6a1 1 0 100-2H8z" clip-rule="evenodd"/>
                                            </svg>
                                        @endif
                                    </span>
                                    <span class="text-gray-400 dark:text-gray-500">→</span>
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-blue-50 dark:bg-blue-900/30 text-blue-700 dark:text-blue-300 border border-blue-200 dark:border-blue-800">
                                        {{ $question->course->name ?? 'N/A' }}
                                    </span>
                                    <span class="text-gray-400 dark:text-gray-500">→</span>
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-purple-50 dark:bg-purple-900/30 text-purple-700 dark:text-purple-300 border border-purple-200 dark:border-purple-800">
                                        {{ $question->subject->name ?? 'N/A' }}
                                    </span>
                                    <span class="text-gray-400 dark:text-gray-500">→</span>
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-green-50 dark:bg-green-900/30 text-green-700 dark:text-green-300 border border-green-200 dark:border-green-800">
                                        {{ $question->topic->name ?? 'N/A' }}
                                    </span>
                                    <span class="text-gray-400 dark:text-gray-500">→</span>
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-gray-50 dark:bg-gray-900/30 text-gray-700 dark:text-gray-300 border border-gray-200 dark:border-gray-800" title="Created by">
                                        👤 {{ $question->createdBy->name ?? 'Unknown' }}
                                    </span>
                                </div>
                                
                                <!-- Question Text and Answer Options -->
                                <div class="flex-1">
                                    <h3 class="text-base font-medium text-gray-900 dark:text-white mb-3 leading-relaxed flex items-center gap-2">
                                        {!! Str::limit($question->question_text, 150) !!}
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
                                        
                                        <!-- Answer Options in One Line -->
                                        <div class="flex items-center gap-2 text-sm ml-4">
                                            <span class="inline-flex items-center px-2 py-1 rounded-lg shadow-sm {{ $question->correct_answer === 'a' ? 'bg-gradient-to-r from-green-50 to-emerald-50 dark:from-green-900/40 dark:to-emerald-900/40 border-2 border-green-300 dark:border-green-600 text-green-800 dark:text-green-200 font-medium shadow-green-100 dark:shadow-green-900/20' : 'bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-600 text-gray-700 dark:text-gray-300 hover:border-gray-300 dark:hover:border-gray-500 transition-colors duration-200' }}">
                                                <span class="font-bold mr-1 text-xs {{ $question->correct_answer === 'a' ? 'text-green-700 dark:text-green-300' : 'text-gray-500 dark:text-gray-400' }}">A</span> 
                                                {!! Str::limit($question->option_a, 25) !!}
                                                @if($question->correct_answer === 'a')
                                                    <svg class="w-3 h-3 ml-1 text-green-600 dark:text-green-400" fill="currentColor" viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                                    </svg>
                                                @endif
                                            </span>
                                            <span class="text-gray-400 dark:text-gray-500">|</span>
                                            <span class="inline-flex items-center px-2 py-1 rounded-lg shadow-sm {{ $question->correct_answer === 'b' ? 'bg-gradient-to-r from-green-50 to-emerald-50 dark:from-green-900/40 dark:to-emerald-900/40 border-2 border-green-300 dark:border-green-600 text-green-800 dark:text-green-200 font-medium shadow-green-100 dark:shadow-green-900/20' : 'bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-600 text-gray-700 dark:text-gray-300 hover:border-gray-300 dark:hover:border-gray-500 transition-colors duration-200' }}">
                                                <span class="font-bold mr-1 text-xs {{ $question->correct_answer === 'b' ? 'text-green-700 dark:text-green-300' : 'text-gray-500 dark:text-gray-400' }}">B</span> 
                                                {!! Str::limit($question->option_b, 25) !!}
                                                @if($question->correct_answer === 'b')
                                                    <svg class="w-3 h-3 ml-1 text-green-600 dark:text-green-400" fill="currentColor" viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                                    </svg>
                                                @endif
                                            </span>
                                            <span class="text-gray-400 dark:text-gray-500">|</span>
                                            <span class="inline-flex items-center px-2 py-1 rounded-lg shadow-sm {{ $question->correct_answer === 'c' ? 'bg-gradient-to-r from-green-50 to-emerald-50 dark:from-green-900/40 dark:to-emerald-900/40 border-2 border-green-300 dark:border-green-600 text-green-800 dark:text-green-200 font-medium shadow-green-100 dark:shadow-green-900/20' : 'bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-600 text-gray-700 dark:text-gray-300 hover:border-gray-300 dark:hover:border-gray-500 transition-colors duration-200' }}">
                                                <span class="font-bold mr-1 text-xs {{ $question->correct_answer === 'c' ? 'text-green-700 dark:text-green-300' : 'text-gray-500 dark:text-gray-400' }}">C</span> 
                                                {!! Str::limit($question->option_c, 25) !!}
                                                @if($question->correct_answer === 'c')
                                                    <svg class="w-3 h-3 ml-1 text-green-600 dark:text-green-400" fill="currentColor" viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                                    </svg>
                                                @endif
                                            </span>
                                            <span class="text-gray-400 dark:text-gray-500">|</span>
                                            <span class="inline-flex items-center px-2 py-1 rounded-lg shadow-sm {{ $question->correct_answer === 'd' ? 'bg-gradient-to-r from-green-50 to-emerald-50 dark:from-green-900/40 dark:to-emerald-900/40 border-2 border-green-300 dark:border-green-600 text-green-800 dark:text-green-200 font-medium shadow-green-100 dark:shadow-green-900/20' : 'bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-600 text-gray-700 dark:text-gray-300 hover:border-gray-300 dark:hover:border-gray-500 transition-colors duration-200' }}">
                                                <span class="font-bold mr-1 text-xs {{ $question->correct_answer === 'd' ? 'text-green-700 dark:text-green-300' : 'text-gray-500 dark:text-gray-400' }}">D</span> 
                                                {!! Str::limit($question->option_d, 25) !!}
                                                @if($question->correct_answer === 'd')
                                                    <svg class="w-3 h-3 ml-1 text-green-600 dark:text-green-400" fill="currentColor" viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                                    </svg>
                                                @endif
                                            </span>
                                        </div>
                                    </h3>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            
            <!-- Pagination -->
            <div class="p-6 border-t border-gray-200 dark:border-gray-700">
                {{ $questions->links() }}
            </div>
        @else
            <div class="p-12 text-center questions-container">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <h3 class="mt-2 text-sm font-medium text-gray-900 dark:text-white">
                    @if(request('search'))
                        No questions found for "{{ request('search') }}"
                    @else
                        No questions found
                    @endif
                </h3>
                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                    @if(request('search'))
                        Try adjusting your search terms or filters.
                    @else
                        Get started by creating a new question.
                    @endif
                </p>
                <div class="mt-6 flex gap-3">
                    <a href="{{ route('partner.questions.mcq.create') }}" 
                       class="inline-flex items-center gap-2.5 px-4 py-2.5 border border-transparent shadow-lg text-sm font-bold rounded-lg text-white bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 transition-all duration-300 transform hover:-translate-y-1">
                        <div class="w-5 h-5 bg-white/20 rounded-lg flex items-center justify-center">
                            <svg class="w-3.5 h-3.5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/>
                            </svg>
                        </div>
                        + MCQ
                    </a>
                    <a href="{{ route('partner.questions.descriptive.create') }}" 
                       class="inline-flex items-center gap-2.5 px-4 py-2.5 border border-transparent shadow-lg text-sm font-bold rounded-lg text-white bg-gradient-to-r from-green-500 to-emerald-600 hover:from-green-600 hover:to-emerald-700 transition-all duration-300 transform hover:-translate-y-1">
                        <div class="w-5 h-5 bg-white/20 rounded-lg flex items-center justify-center">
                            <svg class="w-3.5 h-3.5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                            </svg>
                        </div>
                        + CQ
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

/* Search input transitions */
#searchInput {
    transition: all 0.3s ease-in-out;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

#searchInput:focus {
    box-shadow: 0 4px 12px rgba(59, 130, 246, 0.15);
    transform: translateY(-1px);
}

/* Enhanced search input animations */
.search-input {
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}

.search-input:focus {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(59, 130, 246, 0.15);
}

.search-input.searching {
    border-color: #3b82f6;
    box-shadow: 0 0 0 3px rgba(59, 82, 246, 0.1);
}

/* Loading indicator positioning */
#searchLoading {
    z-index: 10;
}

/* Search status indicator */
#searchStatus {
    z-index: 15;
    animation: pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
}

@keyframes pulse {
    0%, 100% {
        opacity: 1;
    }
    50% {
        opacity: .5;
    }
}

/* Clear button positioning */
#clearSearch {
    z-index: 20;
}

/* Search bar animations */
.search-bar-container {
    animation: slideInDown 0.5s ease-out;
}

@keyframes slideInDown {
    from {
        opacity: 0;
        transform: translateY(-20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

/* Hover effects for search tips */
.search-tip {
    transition: all 0.2s ease-in-out;
}

.search-tip:hover {
    transform: translateX(5px);
    color: #3b82f6;
}

/* Search results animation */
.questions-container {
    transition: opacity 0.3s ease-in-out;
}

.questions-container.updating {
    opacity: 0.6;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Get all required elements
    const searchInput = document.getElementById('searchInput');
    const searchHidden = document.getElementById('searchHidden');
    const filterForm = document.getElementById('filterForm');
    const searchLoading = document.getElementById('searchLoading');
    const searchStatus = document.getElementById('searchStatus');
    
    // Check if all required elements exist
    if (!searchInput || !searchHidden || !filterForm) {
        console.error('Required search elements not found');
        return;
    }
    
    // Initialize clear button visibility on page load
    updateClearButtonVisibility();
    
    // Get all filter select elements
    const filterSelects = document.querySelectorAll('select[name="course_filter"], select[name="subject_filter"], select[name="topic_filter"], select[name="question_type_filter"]');
    
    // Add change event listener to each filter
    filterSelects.forEach(select => {
        select.addEventListener('change', function() {
            // Perform AJAX search when filters change
            performFilterSearch();
        });
    });

    // AJAX Search Function
    function performAjaxSearch() {
        const searchValue = searchInput.value;
        const currentUrl = new URL(window.location);
        
        // Add searching class to input and updating class to questions container
        searchInput.classList.add('searching');
        const questionsContainer = document.querySelector('.questions-container');
        if (questionsContainer) {
            questionsContainer.classList.add('updating');
        }
        
        // Show loading indicators
        if (searchLoading) searchLoading.classList.remove('hidden');
        if (searchStatus) searchStatus.classList.remove('hidden');
        
        // Update URL parameters
        if (searchValue) {
            currentUrl.searchParams.set('search', searchValue);
        } else {
            currentUrl.searchParams.delete('search');
        }
        
        // Preserve existing filters
        const courseFilter = document.querySelector('select[name="course_filter"]')?.value || '';
        const subjectFilter = document.querySelector('select[name="subject_filter"]')?.value || '';
        const topicFilter = document.querySelector('select[name="topic_filter"]')?.value || '';
        const questionTypeFilter = document.querySelector('select[name="question_type_filter"]')?.value || '';
        
        if (courseFilter) currentUrl.searchParams.set('course_filter', courseFilter);
        if (subjectFilter) currentUrl.searchParams.set('subject_filter', subjectFilter);
        if (topicFilter) currentUrl.searchParams.set('topic_filter', topicFilter);
        if (questionTypeFilter) currentUrl.searchParams.set('question_type_filter', questionTypeFilter);
        
        // Update browser URL without reloading
        window.history.pushState({}, '', currentUrl);
        
        // Perform AJAX request
        fetch(currentUrl.toString(), {
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => {
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            return response.text();
        })
        .then(html => {
            // Create a temporary div to parse the HTML
            const tempDiv = document.createElement('div');
            tempDiv.innerHTML = html;
            
            // Extract the questions list and pagination
            const newQuestionsList = tempDiv.querySelector('.divide-y');
            const newPagination = tempDiv.querySelector('.p-6.border-t');
            const newQuestionsCount = tempDiv.querySelector('.text-lg.font-semibold');
            const newSearchInfo = tempDiv.querySelector('.mt-4.p-3.bg-blue-100');
            
            // Update the page content
            if (newQuestionsList) {
                const existingQuestionsList = document.querySelector('.divide-y');
                if (existingQuestionsList) {
                    existingQuestionsList.innerHTML = newQuestionsList.innerHTML;
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
                    existingQuestionsCount.innerHTML = newQuestionsCount.innerHTML;
                }
            }
            
            // Update search info section
            const existingSearchInfo = document.querySelector('.mt-4.p-3.bg-blue-100');
            if (newSearchInfo) {
                if (existingSearchInfo) {
                    existingSearchInfo.innerHTML = newSearchInfo.innerHTML;
                } else {
                    // Insert search info if it doesn't exist
                    const searchBar = document.querySelector('.search-bar-container');
                    const searchTips = document.querySelector('.mt-4.grid');
                    if (searchBar && searchTips) {
                        searchBar.insertBefore(newSearchInfo.cloneNode(true), searchTips);
                    }
                }
            } else {
                // Remove search info if no search results
                if (existingSearchInfo) {
                    existingSearchInfo.remove();
                }
            }
            
            // Hide loading indicator and remove searching class
            if (searchLoading) searchLoading.classList.add('hidden');
            if (searchStatus) searchStatus.classList.add('hidden');
            searchInput.classList.remove('searching');
            if (questionsContainer) {
                questionsContainer.classList.remove('updating');
            }
            
            // Update clear button visibility
            updateClearButtonVisibility();
        })
        .catch(error => {
            console.error('Search error:', error);
            // Hide loading indicators on error
            if (searchLoading) searchLoading.classList.add('hidden');
            if (searchStatus) searchStatus.classList.add('hidden');
            searchInput.classList.remove('searching');
            if (questionsContainer) {
                questionsContainer.classList.remove('updating');
            }
            
            // Show error message to user
            alert('Search failed. Please try again. Error: ' + error.message);
        });
    }
    
    // Update clear button visibility
    function updateClearButtonVisibility() {
        const clearBtn = document.getElementById('clearSearch');
        if (searchInput.value.length > 0) {
            if (!clearBtn) {
                // Create clear button if it doesn't exist
                const clearButton = document.createElement('button');
                clearButton.type = 'button';
                clearButton.id = 'clearSearch';
                clearButton.className = 'absolute inset-y-0 right-0 pr-4 flex items-center text-gray-400 hover:text-red-500 dark:hover:text-red-400 transition-colors duration-200';
                clearButton.title = 'Clear search';
                clearButton.innerHTML = '<svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>';
                
                // Add click event
                clearButton.addEventListener('click', function() {
                    searchInput.value = '';
                    searchHidden.value = '';
                    searchInput.classList.remove('pr-16');
                    searchInput.classList.add('pr-4');
                    performAjaxSearch();
                });
                
                // Insert before loading indicator
                const loadingIndicator = document.getElementById('searchLoading');
                if (loadingIndicator) {
                    loadingIndicator.parentNode.insertBefore(clearButton, loadingIndicator);
                }
                
                // Update padding
                searchInput.classList.remove('pr-4');
                searchInput.classList.add('pr-16');
            }
        } else {
            if (clearBtn) {
                clearBtn.remove();
                searchInput.classList.remove('pr-16');
                searchInput.classList.add('pr-4');
            }
        }
    }
    
    // Function to handle filter changes with AJAX
    function performFilterSearch() {
        // Update hidden search field
        if (searchHidden) {
            searchHidden.value = searchInput.value;
        }
        // Perform AJAX search
        performAjaxSearch();
    }

    // Search functionality with debouncing and AJAX
    let searchTimeout;
    
    // Add input event listener for real-time search
    searchInput.addEventListener('input', function() {
        
        // Clear the previous timeout
        clearTimeout(searchTimeout);
        
        // Update hidden field
        if (searchHidden) {
            searchHidden.value = this.value;
        }
        
        // Show loading indicator
        if (searchLoading) searchLoading.classList.remove('hidden');
        if (searchStatus) searchStatus.classList.remove('hidden');
        
        // Adjust padding based on search content
        if (this.value.length > 0) {
            this.classList.remove('pr-4');
            this.classList.add('pr-16');
        } else {
            this.classList.remove('pr-16');
            this.classList.add('pr-4');
        }
        
        // Set a new timeout to perform AJAX search after 300ms of no typing
        searchTimeout = setTimeout(function() {
            performAjaxSearch();
        }, 300);
    });

    // Handle Enter key press
    searchInput.addEventListener('keypress', function(e) {
        if (e.key === 'Enter') {
            e.preventDefault();
            clearTimeout(searchTimeout);
            if (searchHidden) {
                searchHidden.value = this.value;
            }
            performAjaxSearch();
        }
    });

    // Clear search functionality
    const clearSearchBtn = document.getElementById('clearSearch');
    if (clearSearchBtn) {
        clearSearchBtn.addEventListener('click', function() {
            searchInput.value = '';
            if (searchHidden) {
                searchHidden.value = '';
            }
            // Reset padding
            searchInput.classList.remove('pr-16');
            searchInput.classList.add('pr-4');
            performAjaxSearch();
        });
    }
    
    // Handle pagination clicks with AJAX
    document.addEventListener('click', function(e) {
        if (e.target.matches('.pagination a, .pagination button')) {
            e.preventDefault();
            const href = e.target.href || e.target.getAttribute('data-href');
            if (href) {
                // Update URL and perform AJAX request
                const url = new URL(href);
                window.history.pushState({}, '', url);
                
                fetch(url.toString(), {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error(`HTTP error! status: ${response.status}`);
                    }
                    return response.text();
                })
                .then(html => {
                    const tempDiv = document.createElement('div');
                    tempDiv.innerHTML = html;
                    
                    // Update questions list and pagination
                    const newQuestionsList = tempDiv.querySelector('.divide-y');
                    const newPagination = tempDiv.querySelector('.p-6.border-t');
                    const newQuestionsCount = tempDiv.querySelector('.text-lg.font-semibold');
                    
                    if (newQuestionsList) {
                        const existingQuestionsList = document.querySelector('.divide-y');
                        if (existingQuestionsList) {
                            existingQuestionsList.innerHTML = newQuestionsList.innerHTML;
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
                            existingQuestionsCount.innerHTML = newQuestionsCount.innerHTML;
                        }
                    }
                })
                .catch(error => {
                    console.error('Pagination error:', error);
                    // Reload page on pagination error
                    window.location.reload();
                });
            }
        }
    });
    
});
</script>

@endsection
