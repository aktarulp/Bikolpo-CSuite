@extends('layouts.partner-layout')

@section('title', 'MCQ Questions')

@section('content')
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

    <!-- Search Bar -->
    <div class="bg-blue-50 border border-blue-200 rounded-lg p-6">
        <!-- Page Header -->
        <div class="flex justify-between items-center mb-6">
            <div class="text-left">
                <h1 class="text-3xl font-bold text-gray-900">All Questions</h1>
                <p class="text-gray-600">Manage your questions of all types</p>
            </div>
            
            <!-- Action Buttons -->
            <div class="flex gap-3">
                <a href="{{ route('partner.questions.bulk-upload') }}"
                   class="bg-green-600 hover:bg-green-700 text-white px-4 py-2.5 rounded-lg transition-colors duration-200 flex items-center gap-2.5">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                    </svg>
                    Bulk Upload
                </a>
                <a href="{{ route('partner.questions.drafts') }}"
                   class="bg-yellow-600 hover:bg-yellow-700 text-white px-4 py-2.5 rounded-lg transition-colors duration-200 flex items-center gap-2.5">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    Drafts
                </a>
                <a href="{{ route('partner.questions.mcq.create') }}" 
                   class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2.5 rounded-lg transition-colors duration-200 flex items-center gap-2.5">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/>
                    </svg>
                    <span>+ MCQ</span>
                </a>
                <a href="{{ route('partner.questions.descriptive.create') }}" 
                   class="bg-green-600 hover:bg-green-700 text-white px-4 py-2.5 rounded-lg transition-colors duration-200 flex items-center gap-2.5">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                    </svg>
                    <span>+ CQ</span>
                </a>
            </div>
        </div>

        <div class="relative">
            <input type="text" 
                   id="searchInput" 
                   name="search" 
                   value="{{ request('search') }}"
                   placeholder="🔍 Type to search questions, options, explanations, courses, subjects, topics..." 
                   class="block w-full pl-4 pr-14 py-3 border border-gray-300 rounded-lg leading-6 bg-white text-gray-900 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200 text-base">
            
            <!-- Loading Indicator -->
            <div id="searchLoading" class="absolute inset-y-0 right-0 pr-4 flex items-center hidden">
                <svg class="animate-spin h-5 w-5 text-blue-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
            </div>
            
            <!-- Clear Search Button -->
            @if(request('search'))
                <button type="button" 
                        id="clearSearch" 
                        class="absolute inset-y-0 right-0 pr-4 flex items-center text-gray-400 hover:text-red-500 transition-colors duration-200"
                        title="Clear search">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            @endif
        </div>
        
        <!-- Search Results Info -->
        @if(request('search'))
            <div class="mt-4 p-3 bg-blue-100 rounded-lg border border-blue-200">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-2 text-sm text-blue-800">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <span class="font-medium">Search results for:</span> "<span class="font-bold">{{ request('search') }}</span>"
                    </div>
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-blue-200 text-blue-800">
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
                    <select name="course_filter" class="w-full rounded-md border border-gray-300 p-2 bg-white text-gray-900">
                        <option value="">All Courses</option>
                        @foreach($courses ?? [] as $course)
                            <option value="{{ $course->id }}" {{ request('course_filter') == $course->id ? 'selected' : '' }}>
                                {{ $course->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <select name="subject_filter" class="w-full rounded-md border border-gray-300 p-2 bg-white text-gray-900">
                        <option value="">All Subjects</option>
                        @foreach($subjects ?? [] as $subject)
                            <option value="{{ $subject->id }}" {{ request('subject_filter') == $subject->id ? 'selected' : '' }}>
                                {{ $subject->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <select name="topic_filter" class="w-full rounded-md border border-gray-300 p-2 bg-white text-gray-900">
                        <option value="">All Topics</option>
                        @foreach($topics ?? [] as $topic)
                            <option value="{{ $topic->id }}" {{ request('topic_filter') == $topic->id ? 'selected' : '' }}>
                                {{ $topic->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <select name="question_type_filter" class="w-full rounded-md border border-gray-300 p-2 bg-white text-gray-900">
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
    <div class="bg-white rounded-lg shadow border border-gray-200">
        <div class="p-6 border-b border-gray-200">
            <h2 class="text-lg font-semibold text-gray-900">
                Questions ({{ $questions->total() }})
            </h2>
        </div>

        @if($questions->count() > 0)
            <div class="divide-y divide-gray-200 questions-container">
                @foreach($questions as $question)
                    <div class="p-4 hover:bg-gray-50 transition-colors duration-200 border-l-4 border-transparent hover:border-green-500">
                        <div class="flex items-start gap-4">
                            <div class="flex flex-col items-start gap-2 min-w-[120px]">
                                <a href="{{ route('partner.questions.mcq.show', $question) }}" 
                                   class="inline-flex items-center gap-2 px-3 py-2 text-sm text-blue-600 hover:text-blue-800 hover:bg-blue-50 rounded-md transition-colors duration-200">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                    </svg>
                                    View
                                </a>
                                <a href="{{ route('partner.questions.mcq.edit', $question) }}" 
                                   class="inline-flex items-center gap-2 px-3 py-2 text-sm text-green-600 hover:text-green-800 hover:bg-green-50 rounded-md transition-colors duration-200">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                    </svg>
                                    Edit
                                </a>
                            </div>
                            <div class="flex-1">
                                <div class="flex items-center gap-3 mb-3">
                                    <span class="inline-flex items-center px-3 py-1.5 rounded-full text-sm font-bold bg-orange-500 text-white">
                                        @if($question->questionType->q_type_name === 'Descriptive')
                                            CQ
                                        @else
                                            {{ $question->questionType->q_type_name ?? 'N/A' }}
                                        @endif
                                    </span>
                                    <span class="text-gray-400">→</span>
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800 border border-blue-200">
                                        {{ $question->course->name ?? 'N/A' }}
                                    </span>
                                    <span class="text-gray-400">→</span>
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-purple-100 text-purple-800 border border-purple-200">
                                        {{ $question->subject->name ?? 'N/A' }}
                                    </span>
                                    <span class="text-gray-400">→</span>
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800 border border-green-200">
                                        {{ $question->topic->name ?? 'N/A' }}
                                    </span>
                                </div>
                                
                                <!-- Question Text and Answer Options -->
                                <div class="flex-1">
                                    <h3 class="text-base font-medium text-gray-900 mb-3 leading-relaxed flex items-center gap-2">
                                        {!! Str::limit($question->question_text, 150) !!}
                                        @if($question->image)
                                            <div class="relative group">
                                                <svg class="w-4 h-4 text-blue-500 hover:text-blue-700 cursor-pointer transition-colors duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24" title="View Image">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                                </svg>
                                                <!-- Image Preview Tooltip -->
                                                <div class="absolute bottom-full left-1/2 transform -translate-x-1/2 mb-2 opacity-0 group-hover:opacity-100 transition-opacity duration-200 pointer-events-none z-50 image-preview-tooltip">
                                                    <div class="bg-white border border-gray-200 rounded-lg shadow-lg p-3">
                                                        <img src="{{ asset('storage/' . $question->image) }}" 
                                                             alt="Question Image" 
                                                             class="rounded">
                                                    </div>
                                                    <!-- Arrow -->
                                                    <div class="absolute top-full left-1/2 transform -translate-x-1/2 w-0 h-0 border-l-4 border-r-4 border-t-4 border-transparent border-t-gray-200"></div>
                                                    <div class="absolute top-full left-1/2 transform -translate-x-1/2 w-0 h-0 border-l-3 border-r-3 border-t-3 border-transparent border-t-white -mt-1"></div>
                                                </div>
                                            </div>
                                        @endif
                                        
                                        <!-- Answer Options in One Line -->
                                        <div class="flex items-center gap-2 text-sm ml-4">
                                            <span class="inline-flex items-center px-2 py-1 rounded-lg {{ $question->correct_answer === 'a' ? 'bg-green-100 border-2 border-green-300 text-green-800 font-medium' : 'bg-white border border-gray-200 text-gray-700 hover:border-gray-300 transition-colors duration-200' }}">
                                                <span class="font-bold mr-1 text-xs {{ $question->correct_answer === 'a' ? 'text-green-700' : 'text-gray-500' }}">A</span> 
                                                {!! Str::limit($question->option_a, 25) !!}
                                                @if($question->correct_answer === 'a')
                                                    <svg class="w-3 h-3 ml-1 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                                    </svg>
                                                @endif
                                            </span>
                                            <span class="text-gray-400">|</span>
                                            <span class="inline-flex items-center px-2 py-1 rounded-lg {{ $question->correct_answer === 'b' ? 'bg-green-100 border-2 border-green-300 text-green-800 font-medium' : 'bg-white border border-gray-200 text-gray-700 hover:border-gray-300 transition-colors duration-200' }}">
                                                <span class="font-bold mr-1 text-xs {{ $question->correct_answer === 'b' ? 'text-green-700' : 'text-gray-500' }}">B</span> 
                                                {!! Str::limit($question->option_b, 25) !!}
                                                @if($question->correct_answer === 'b')
                                                    <svg class="w-3 h-3 ml-1 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                                    </svg>
                                                @endif
                                            </span>
                                            <span class="text-gray-400">|</span>
                                            <span class="inline-flex items-center px-2 py-1 rounded-lg {{ $question->correct_answer === 'c' ? 'bg-green-100 border-2 border-green-300 text-green-800 font-medium' : 'bg-white border border-gray-200 text-gray-700 hover:border-gray-300 transition-colors duration-200' }}">
                                                <span class="font-bold mr-1 text-xs {{ $question->correct_answer === 'c' ? 'text-green-700' : 'text-gray-500' }}">C</span> 
                                                {!! Str::limit($question->option_c, 25) !!}
                                                @if($question->correct_answer === 'c')
                                                    <svg class="w-3 h-3 ml-1 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                                    </svg>
                                                @endif
                                            </span>
                                            <span class="text-gray-400">|</span>
                                            <span class="inline-flex items-center px-2 py-1 rounded-lg {{ $question->correct_answer === 'd' ? 'bg-green-100 border-2 border-green-300 text-green-800 font-medium' : 'bg-white border border-gray-200 text-gray-700 hover:border-gray-300 transition-colors duration-200' }}">
                                                <span class="font-bold mr-1 text-xs {{ $question->correct_answer === 'd' ? 'text-green-700' : 'text-gray-500' }}">D</span> 
                                                {!! Str::limit($question->option_d, 25) !!}
                                                @if($question->correct_answer === 'd')
                                                    <svg class="w-3 h-3 ml-1 text-green-600" fill="currentColor" viewBox="0 0 20 20">
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
                    <a href="{{ route('partner.questions.mcq.create') }}" 
                       class="inline-flex items-center gap-2.5 px-4 py-2.5 border border-transparent shadow text-sm font-bold rounded-lg text-white bg-blue-600 hover:bg-blue-700 transition-colors duration-200">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/>
                        </svg>
                        + MCQ
                    </a>
                    <a href="{{ route('partner.questions.descriptive.create') }}" 
                       class="inline-flex items-center gap-2.5 px-4 py-2.5 border border-transparent shadow text-sm font-bold rounded-lg text-white bg-green-600 hover:bg-green-700 transition-colors duration-200">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                        </svg>
                        + CQ
                    </a>
                </div>
            </div>
        @endif
    </div>
</div>

<style>
.image-preview-tooltip img {
    max-width: 300px;
    max-height: 200px;
    object-fit: contain;
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
        
        // Add updating class to questions container
        const questionsContainer = document.querySelector('.questions-container');
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
                    const searchBar = document.querySelector('.bg-blue-50');
                    const searchTips = document.querySelector('.mt-6');
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
            
            // Hide loading indicator and remove updating class
            if (searchLoading) searchLoading.classList.add('hidden');
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
                clearButton.className = 'absolute inset-y-0 right-0 pr-4 flex items-center text-gray-400 hover:text-red-500 transition-colors duration-200';
                clearButton.title = 'Clear search';
                clearButton.innerHTML = '<svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>';
                
                // Add click event
                clearButton.addEventListener('click', function() {
                    searchInput.value = '';
                    searchHidden.value = '';
                    performAjaxSearch();
                });
                
                // Insert before loading indicator
                const loadingIndicator = document.getElementById('searchLoading');
                if (loadingIndicator) {
                    loadingIndicator.parentNode.insertBefore(clearButton, loadingIndicator);
                }
            }
        } else {
            if (clearBtn) {
                clearBtn.remove();
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
