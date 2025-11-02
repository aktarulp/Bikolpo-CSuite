@extends('layouts.partner-layout')

@section('title', 'Create New Exam')

@section('content')
@can('exams-add')
<!-- Slim, professional layout -->
<div class="min-h-screen bg-gray-50 dark:bg-gray-900 py-4">
    <div class="max-w-4xl mx-auto space-y-4">
        
        <!-- Slim Header with action button -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow border border-gray-200 dark:border-gray-700 p-4">
            <div class="flex items-center justify-between gap-3">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-lg bg-indigo-600 text-white flex items-center justify-center">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                    </div>
                    <div>
                        <h1 class="text-xl sm:text-2xl font-bold text-gray-900 dark:text-white">Create Exam</h1>
                        <p class="text-sm text-gray-600 dark:text-gray-400">Set up a new exam draft</p>
                    </div>
                </div>
                <div class="flex items-center gap-2">
                    <a href="{{ route('partner.exams.index') }}" class="hidden sm:inline-flex items-center gap-2 px-4 py-2 rounded-lg border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                        <span>Back</span>
                    </a>
                    <button type="submit" form="examCreateForm" class="inline-flex items-center gap-2 px-4 py-2 rounded-lg bg-indigo-600 text-white hover:bg-indigo-700">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                        </svg>
                        <span>Create</span>
                    </button>
                </div>
            </div>
        </div>

        <!-- Error Messages -->
        @if ($errors->any())
        <div class="bg-red-50 dark:bg-red-900/20 rounded-xl border border-red-200 dark:border-red-800 p-4">
            <div class="flex items-start space-x-4">
                <div class="flex-shrink-0 w-10 h-10 bg-red-600 rounded-xl flex items-center justify-center">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div>
                    <h3 class="text-sm font-bold text-red-900 dark:text-red-100 mb-1">Please fix the following errors:</h3>
                    <ul class="text-xs text-red-700 dark:text-red-300 space-y-1">
                        @foreach ($errors->all() as $error)
                        <li class="flex items-start space-x-2">
                            <span class="text-red-600 dark:text-red-400 mt-0.5">•</span>
                            <span>{{ $error }}</span>
                        </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
        @endif

        <!-- Form Card -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow border border-gray-200 dark:border-gray-700">
            <div class="p-4 sm:p-6">
                <form id="examCreateForm" action="{{ route('partner.exams.store') }}" method="POST" class="space-y-5">
                    @csrf
                    <input type="hidden" name="status" value="draft">

                    <!-- Course, Exam Number & Title -->
                    <div class="grid grid-cols-1 md:grid-cols-12 gap-4">
                        <!-- Course -->
                        <div class="md:col-span-2 space-y-2">
                            <label class="flex items-center space-x-2 text-sm font-bold text-gray-700 dark:text-gray-300">
                                <svg class="w-4 h-4 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                </svg>
                                <span>Course</span>
                                <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <select name="course_id" 
                                        required
                                        class="w-full px-4 py-3.5 bg-white dark:bg-gray-700 border-2 border-gray-200 dark:border-gray-600 rounded-xl focus:ring-4 focus:ring-blue-500/20 focus:border-blue-500 dark:focus:border-blue-400 transition-all duration-300 text-gray-900 dark:text-white placeholder-gray-400 dark:placeholder-gray-500 font-medium shadow-sm hover:shadow-md appearance-none">
                                    <option value="">Select a course</option>
                                    @foreach($courses as $course)
                                        <option value="{{ $course->id }}" {{ old('course_id') == $course->id ? 'selected' : '' }}>
                                            {{ $course->name }}
                                        </option>
                                    @endforeach
                                </select>
                                <div class="absolute inset-y-0 right-0 flex items-center pr-4 pointer-events-none">
                                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                    </svg>
                                </div>
                            </div>
                            @error('course_id')
                                <div class="flex items-center space-x-2 text-red-600 dark:text-red-400 text-sm font-medium bg-red-50 dark:bg-red-900/20 px-3 py-2 rounded-lg">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    <span>{{ $message }}</span>
                                </div>
                            @enderror
                        </div>

                        <!-- Exam Number & Title Row -->
                        <div class="md:col-span-10 grid grid-cols-1 md:grid-cols-16 gap-4">
                            <!-- Exam Number -->
                            <div class="md:col-span-1 space-y-2">
                                <label class="flex items-center space-x-2 text-sm font-bold text-gray-700 dark:text-gray-300">
                                    <svg class="w-4 h-4 text-indigo-600 dark:text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 20l4-16m2 16l4-16M6 9h14M4 15h14"></path>
                                    </svg>
                                    <span>Exam Number</span>
                                </label>
                                <div class="relative">
                                    <input type="text" 
                                           name="exam_number" 
                                           value="{{ old('exam_number') }}" 
                                           placeholder="e.g., 10, 25"
                                           class="w-full px-4 py-3.5 bg-white dark:bg-gray-700 border-2 border-gray-200 dark:border-gray-600 rounded-xl focus:ring-4 focus:ring-indigo-500/20 focus:border-indigo-500 dark:focus:border-indigo-400 transition-all duration-300 text-gray-900 dark:text-white placeholder-gray-400 dark:placeholder-gray-500 font-medium shadow-sm hover:shadow-md">
                                    <div class="absolute inset-y-0 right-0 flex items-center pr-4 pointer-events-none">
                                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 20l4-16m2 16l4-16M6 9h14M4 15h14"></path>
                                        </svg>
                                    </div>
                                </div>
                                @error('exam_number')
                                    <div class="flex items-center space-x-2 text-red-600 dark:text-red-400 text-sm font-medium bg-red-50 dark:bg-red-900/20 px-3 py-2 rounded-lg">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        <span>{{ $message }}</span>
                                    </div>
                                @enderror
                            </div>

                            <!-- Exam Title -->
                            <div class="md:col-span-15 space-y-2">
                                <label class="flex items-center space-x-2 text-sm font-bold text-gray-700 dark:text-gray-300">
                                    <svg class="w-4 h-4 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                    </svg>
                                    <span>Exam Title</span>
                                    <span class="text-red-500">*</span>
                                </label>
                                <div class="relative">
                                    <input type="text" 
                                           name="title" 
                                           value="{{ old('title') }}" 
                                           required
                                           placeholder="e.g., Mid-Term Mathematics"
                                           class="w-full px-4 py-3.5 bg-white dark:bg-gray-700 border-2 border-gray-200 dark:border-gray-600 rounded-xl focus:ring-4 focus:ring-purple-500/20 focus:border-purple-500 dark:focus:border-purple-400 transition-all duration-300 text-gray-900 dark:text-white placeholder-gray-400 dark:placeholder-gray-500 font-medium shadow-sm hover:shadow-md">
                                    <div class="absolute inset-y-0 right-0 flex items-center pr-4 pointer-events-none">
                                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                        </svg>
                                    </div>
                                </div>
                                @error('title')
                                    <div class="flex items-center space-x-2 text-red-600 dark:text-red-400 text-sm font-medium bg-red-50 dark:bg-red-900/20 px-3 py-2 rounded-lg">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        <span>{{ $message }}</span>
                                    </div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Description -->
                    <div class="space-y-2">
                        <label class="flex items-center space-x-2 text-sm font-bold text-gray-700 dark:text-gray-300">
                            <svg class="w-4 h-4 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7"></path>
                            </svg>
                            <span>Description</span>
                            <span class="text-gray-400 text-xs font-normal">(Optional)</span>
                        </label>
                        <div class="relative">
                            <textarea name="description" 
                                      rows="3" 
                                      placeholder="Provide a detailed description of the exam, topics covered, and any special instructions..."
                                      class="w-full px-4 py-3.5 bg-white dark:bg-gray-700 border-2 border-gray-200 dark:border-gray-600 rounded-xl focus:ring-4 focus:ring-green-500/20 focus:border-green-500 dark:focus:border-green-400 transition-all duration-300 text-gray-900 dark:text-white placeholder-gray-400 dark:placeholder-gray-500 font-medium shadow-sm hover:shadow-md resize-none">{{ old('description') }}</textarea>
                            <div class="absolute bottom-3 right-3 pointer-events-none">
                                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                </svg>
                            </div>
                        </div>
                        @error('description')
                            <div class="flex items-center space-x-2 text-red-600 dark:text-red-400 text-sm font-medium bg-red-50 dark:bg-red-900/20 px-3 py-2 rounded-lg">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <span>{{ $message }}</span>
                            </div>
                        @enderror
                    </div>

                    <!-- Exam Details Grid -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4">
                        <!-- Exam Type -->
                        <div class="space-y-2">
                            <label class="flex items-center space-x-2 text-sm font-bold text-gray-700 dark:text-gray-300">
                                <svg class="w-4 h-4 text-yellow-600 dark:text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                                </svg>
                                <span>Exam Type</span>
                                <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <select name="exam_type" 
                                        required
                                        class="w-full px-4 py-3.5 bg-white dark:bg-gray-700 border-2 border-gray-200 dark:border-gray-600 rounded-xl focus:ring-4 focus:ring-yellow-500/20 focus:border-yellow-500 dark:focus:border-yellow-400 transition-all duration-300 text-gray-900 dark:text-white placeholder-gray-400 dark:placeholder-gray-500 font-medium shadow-sm hover:shadow-md appearance-none">
                                    <option value="online" {{ old('exam_type', 'online') === 'online' ? 'selected' : '' }}>🖥️ Online</option>
                                    <option value="offline" {{ old('exam_type') === 'offline' ? 'selected' : '' }}>📝 Offline</option>
                                </select>
                                <div class="absolute inset-y-0 right-0 flex items-center pr-4 pointer-events-none">
                                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                    </svg>
                                </div>
                            </div>
                            @error('exam_type')
                                <div class="flex items-center space-x-2 text-red-600 dark:text-red-400 text-sm font-medium bg-red-50 dark:bg-red-900/20 px-3 py-2 rounded-lg">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    <span>{{ $message }}</span>
                                </div>
                            @enderror
                        </div>

                        <!-- Total Questions -->
                        <div class="space-y-2">
                            <label class="flex items-center space-x-2 text-sm font-bold text-gray-700 dark:text-gray-300">
                                <svg class="w-4 h-4 text-pink-600 dark:text-pink-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <span>Questions</span>
                                <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <input type="number" 
                                       name="total_questions" 
                                       value="{{ old('total_questions') }}" 
                                       min="1" max="100" required
                                       placeholder="e.g., 50"
                                       class="w-full px-4 py-3.5 bg-white dark:bg-gray-700 border-2 border-gray-200 dark:border-gray-600 rounded-xl focus:ring-4 focus:ring-pink-500/20 focus:border-pink-500 dark:focus:border-pink-400 transition-all duration-300 text-gray-900 dark:text-white placeholder-gray-400 dark:placeholder-gray-500 font-medium shadow-sm hover:shadow-md">
                                <div class="absolute inset-y-0 right-0 flex items-center pr-4 pointer-events-none">
                                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                            </div>
                            @error('total_questions')
                                <div class="flex items-center space-x-2 text-red-600 dark:text-red-400 text-sm font-medium bg-red-50 dark:bg-red-900/20 px-3 py-2 rounded-lg">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    <span>{{ $message }}</span>
                                </div>
                            @enderror
                        </div>

                        <!-- Duration -->
                        <div class="space-y-2">
                            <label class="flex items-center space-x-2 text-sm font-bold text-gray-700 dark:text-gray-300">
                                <svg class="w-4 h-4 text-teal-600 dark:text-teal-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <span>Duration (min)</span>
                                <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <input type="number" 
                                       name="duration" 
                                       value="{{ old('duration') }}" 
                                       min="15" max="480" required
                                       placeholder="e.g., 60"
                                       class="w-full px-4 py-3.5 bg-white dark:bg-gray-700 border-2 border-gray-200 dark:border-gray-600 rounded-xl focus:ring-4 focus:ring-teal-500/20 focus:border-teal-500 dark:focus:border-teal-400 transition-all duration-300 text-gray-900 dark:text-white placeholder-gray-400 dark:placeholder-gray-500 font-medium shadow-sm hover:shadow-md">
                                <div class="absolute inset-y-0 right-0 flex items-center pr-4 pointer-events-none">
                                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                            </div>
                            @error('duration')
                                <div class="flex items-center space-x-2 text-red-600 dark:text-red-400 text-sm font-medium bg-red-50 dark:bg-red-900/20 px-3 py-2 rounded-lg">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    <span>{{ $message }}</span>
                                </div>
                            @enderror
                        </div>

                        <!-- Passing Marks -->
                        <div class="space-y-2">
                            <label class="flex items-center space-x-2 text-sm font-bold text-gray-700 dark:text-gray-300">
                                <svg class="w-4 h-4 text-orange-600 dark:text-orange-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <span>Passing (%)</span>
                                <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <input type="number" 
                                       name="passing_marks" 
                                       value="{{ old('passing_marks') }}" 
                                       min="0" max="100" required
                                       placeholder="e.g., 40"
                                       class="w-full px-4 py-3.5 bg-white dark:bg-gray-700 border-2 border-gray-200 dark:border-gray-600 rounded-xl focus:ring-4 focus:ring-orange-500/20 focus:border-orange-500 dark:focus:border-orange-400 transition-all duration-300 text-gray-900 dark:text-white placeholder-gray-400 dark:placeholder-gray-500 font-medium shadow-sm hover:shadow-md">
                                <div class="absolute inset-y-0 right-0 flex items-center pr-4 pointer-events-none">
                                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                            </div>
                            @error('passing_marks')
                                <div class="flex items-center space-x-2 text-red-600 dark:text-red-400 text-sm font-medium bg-red-50 dark:bg-red-900/20 px-3 py-2 rounded-lg">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    <span>{{ $message }}</span>
                                </div>
                            @enderror
                        </div>

                        <!-- Language -->
                        <div class="space-y-2">
                            <label class="flex items-center space-x-2 text-sm font-bold text-gray-700 dark:text-gray-300">
                                <svg class="w-4 h-4 text-cyan-600 dark:text-cyan-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5h12M9 3v2m1.048 9.5A18.022 18.022 0 016.412 9m6.088 9h7M11 21l5-10 5 10M12.751 5C11.783 10.77 8.07 15.61 3 18.129"></path>
                                </svg>
                                <span>Language</span>
                                <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <select name="question_language" 
                                        required
                                        class="w-full px-4 py-3.5 bg-white dark:bg-gray-700 border-2 border-gray-200 dark:border-gray-600 rounded-xl focus:ring-4 focus:ring-cyan-500/20 focus:border-cyan-500 dark:focus:border-cyan-400 transition-all duration-300 text-gray-900 dark:text-white placeholder-gray-400 dark:placeholder-gray-500 font-medium shadow-sm hover:shadow-md appearance-none">
                                    <option value="english" {{ old('question_language', 'english') === 'english' ? 'selected' : '' }}>🇺🇸 English</option>
                                    <option value="bangla" {{ old('question_language') === 'bangla' ? 'selected' : '' }}>🇧🇩 Bangla</option>
                                </select>
                                <div class="absolute inset-y-0 right-0 flex items-center pr-4 pointer-events-none">
                                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                    </svg>
                                </div>
                            </div>
                            @error('question_language')
                                <div class="flex items-center space-x-2 text-red-600 dark:text-red-400 text-sm font-medium bg-red-50 dark:bg-red-900/20 px-3 py-2 rounded-lg">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    <span>{{ $message }}</span>
                                </div>
                            @enderror
                        </div>
                    </div>

                    <!-- Schedule Section -->
                    <div class="space-y-3 pt-2">
                        <h3 class="text-sm font-bold text-gray-900 dark:text-white flex items-center gap-2">
                            <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h.01M9 16h.01M15 16h.01M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                            Schedule & Timing
                        </h3>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <!-- Start Date & Time -->
                            <div class="space-y-2">
                                <label class="text-xs font-medium text-gray-600 dark:text-gray-400">Start Date & Time <span class="text-red-500">*</span></label>
                                <div class="relative">
                                    <input type="datetime-local" 
                                           name="startDateTime" 
                                           value="{{ old('startDateTime', now()->addHours(2)->format('Y-m-d\TH:i')) }}" 
                                           required
                                           class="w-full px-4 py-3 bg-white dark:bg-gray-700 border-2 border-gray-200 dark:border-gray-600 rounded-xl focus:ring-4 focus:ring-blue-500/20 focus:border-blue-500 dark:focus:border-blue-400 transition-all duration-300 text-gray-900 dark:text-white font-medium shadow-sm hover:shadow-md">
                                </div>
                                <p class="text-xs text-gray-500 dark:text-gray-400">📅 Default: 2 hours from now</p>
                                @error('startDateTime')
                                    <div class="flex items-center space-x-2 text-red-600 dark:text-red-400 text-sm font-medium bg-red-50 dark:bg-red-900/20 px-3 py-2 rounded-lg">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        <span>{{ $message }}</span>
                                    </div>
                                @enderror
                            </div>

                            <!-- End Date & Time -->
                            <div class="space-y-2">
                                <label class="text-xs font-medium text-gray-600 dark:text-gray-400">End Date & Time <span class="text-red-500">*</span></label>
                                <div class="relative">
                                    <input type="datetime-local" 
                                           name="endDateTime" 
                                           value="{{ old('endDateTime', now()->addHours(4)->format('Y-m-d\TH:i')) }}" 
                                           required
                                           class="w-full px-4 py-3 bg-white dark:bg-gray-700 border-2 border-gray-200 dark:border-gray-600 rounded-xl focus:ring-4 focus:ring-blue-500/20 focus:border-blue-500 dark:focus:border-blue-400 transition-all duration-300 text-gray-900 dark:text-white font-medium shadow-sm hover:shadow-md">
                                </div>
                                <p class="text-xs text-gray-500 dark:text-gray-400">⏰ Default: 4 hours from now</p>
                                @error('endDateTime')
                                    <div class="flex items-center space-x-2 text-red-600 dark:text-red-400 text-sm font-medium bg-red-50 dark:bg-red-900/20 px-3 py-2 rounded-lg">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        <span>{{ $message }}</span>
                                    </div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Settings Section -->
                    <div class="space-y-3 pt-2">
                        <h3 class="text-sm font-bold text-gray-900 dark:text-white flex items-center gap-2">
                            <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                            Exam Settings
                        </h3>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                            <!-- Allow Review -->
                            <div class="flex items-center justify-between p-3 bg-gray-50 dark:bg-gray-700 rounded-xl">
                                <div>
                                    <h4 class="text-sm font-medium text-gray-900 dark:text-white">Allow Review</h4>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">Students can review answers</p>
                                </div>
                                <label class="relative inline-flex items-center cursor-pointer">
                                    <input type="checkbox" name="allow_review" value="1" {{ old('allow_review') ? 'checked' : '' }} class="sr-only peer" id="allowReviewToggle">
                                    <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600"></div>
                                </label>
                            </div>

                            <!-- Negative Marking -->
                            <div class="flex items-center justify-between p-3 bg-gray-50 dark:bg-gray-700 rounded-xl">
                                <div>
                                    <h4 class="text-sm font-medium text-gray-900 dark:text-white">Negative Marking</h4>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">Deduct marks for wrong answers</p>
                                </div>
                                <label class="relative inline-flex items-center cursor-pointer">
                                    <input type="checkbox" name="has_negative_marking" value="1" {{ old('has_negative_marking') ? 'checked' : '' }} class="sr-only peer" id="negativeMarkingToggle" onchange="toggleNegativeMarkingInput()">
                                    <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600"></div>
                                </label>
                            </div>

                            <!-- Marks per Wrong Answer -->
                            <div class="sm:col-span-2 flex items-center justify-between p-3 bg-gray-50 dark:bg-gray-700 rounded-xl">
                                <div>
                                    <h4 class="text-sm font-medium text-gray-900 dark:text-white">Marks per Wrong Answer</h4>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">Negative marking value</p>
                                </div>
                                <div id="negativeMarkingInputContainer" class="{{ old('has_negative_marking') ? '' : 'hidden' }}">
                                    <input type="number" 
                                           name="negative_marks_per_question" 
                                           value="{{ old('negative_marks_per_question') }}" 
                                           min="0" max="5" step="0.25"
                                           class="w-24 px-3 py-2 bg-white dark:bg-gray-600 border border-gray-300 dark:border-gray-500 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:text-white text-center">
                                </div>
                                <div id="negativeMarkingPlaceholder" class="{{ old('has_negative_marking') ? 'hidden' : '' }} text-sm text-gray-400">
                                    Disabled
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Footer -->
                    <div class="flex justify-end pt-4 border-t border-gray-200 dark:border-gray-700">
                        <a href="{{ route('partner.exams.index') }}" class="inline-flex items-center gap-2 px-4 py-2 rounded-lg border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                            <span>Cancel</span>
                        </a>
                    </div>
                </form>
            </div>
        </div>

        <!-- Help Card -->
        <div class="bg-blue-50 dark:bg-blue-900/20 rounded-xl border border-blue-200 dark:border-blue-800 p-4">
            <div class="flex items-start space-x-4">
                <div class="flex-shrink-0 w-10 h-10 bg-blue-600 rounded-xl flex items-center justify-center">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div>
                    <h3 class="text-sm font-bold text-blue-900 dark:text-blue-100 mb-1">Quick Tips</h3>
                    <ul class="text-xs text-blue-700 dark:text-blue-300 space-y-1">
                        <li class="flex items-start space-x-2">
                            <span class="text-blue-600 dark:text-blue-400 mt-0.5">•</span>
                            <span>Exams are created as drafts and can be edited later</span>
                        </li>
                        <li class="flex items-start space-x-2">
                            <span class="text-blue-600 dark:text-blue-400 mt-0.5">•</span>
                            <span>Exam numbers should be unique identifiers for your exams</span>
                        </li>
                        <li class="flex items-start space-x-2">
                            <span class="text-blue-600 dark:text-blue-400 mt-0.5">•</span>
                            <span>Set appropriate time limits based on the number of questions</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function toggleNegativeMarkingInput() {
        const checkbox = document.getElementById('negativeMarkingToggle');
        const inputContainer = document.getElementById('negativeMarkingInputContainer');
        const placeholder = document.getElementById('negativeMarkingPlaceholder');
        
        if (checkbox.checked) {
            inputContainer.classList.remove('hidden');
            placeholder.classList.add('hidden');
        } else {
            inputContainer.classList.add('hidden');
            placeholder.classList.remove('hidden');
        }
    }
    
    // Initialize on page load
    document.addEventListener('DOMContentLoaded', function() {
        // Set initial state for negative marking input
        const negativeMarkingCheckbox = document.getElementById('negativeMarkingToggle');
        if (negativeMarkingCheckbox) {
            toggleNegativeMarkingInput();
        }
    });
</script>
@endcan
@endsection