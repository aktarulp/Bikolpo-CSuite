@extends('system-admin.system-admin-layout')

@section('title', 'Edit Exam')

@section('content')
@can('exams-edit')
<!-- Slim, professional layout -->
<div class="min-h-screen bg-gray-50 dark:bg-gray-900 py-4">
    <div class="max-w-4xl mx-auto space-y-4">
        
        <!-- Slim Header with action button -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow border border-gray-200 dark:border-gray-700 p-4">
            <div class="flex items-center justify-between gap-3">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-lg bg-indigo-600 text-white flex items-center justify-center">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                        </svg>
                    </div>
                    <div>
                        <h1 class="text-xl sm:text-2xl font-bold text-gray-900 dark:text-white">Edit Exam</h1>
                        <p class="text-sm text-gray-600 dark:text-gray-400">Update your exam configuration</p>
                    </div>
                </div>
                <div class="flex items-center gap-2">
                    <a href="{{ route('system-admin.public-exams.index') }}" class="hidden sm:inline-flex items-center gap-2 px-4 py-2 rounded-lg border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                        <span>Back</span>
                    </a>
                    <button type="submit" form="examEditForm" class="inline-flex items-center gap-2 px-4 py-2 rounded-lg bg-indigo-600 text-white hover:bg-indigo-700">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                        </svg>
                        <span>Update</span>
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
                <form id="examEditForm" action="{{ route('system-admin.public-exams.update', $exam) }}" method="POST" class="space-y-5">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="status" value="{{ $exam->status }}">
                    <input type="hidden" name="is_public" value="1">

                    <!-- Course, Creator, Exam Number & Price -->
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                        <!-- Target -->
                        <div class="space-y-2">
                            <label class="flex items-center space-x-2 text-sm font-bold text-gray-700 dark:text-gray-300">
                                <svg class="w-4 h-4 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                </svg>
                                <span>Target</span>
                                <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <select name="course_id" 
                                        required
                                        class="w-full px-4 py-3.5 bg-white dark:bg-gray-700 border-2 border-gray-200 dark:border-gray-600 rounded-xl focus:ring-4 focus:ring-blue-500/20 focus:border-blue-500 dark:focus:border-blue-400 transition-all duration-300 text-gray-900 dark:text-white placeholder-gray-400 dark:placeholder-gray-500 font-medium shadow-sm hover:shadow-md appearance-none">
                                    <option value="">Select a target</option>
                                    @foreach($courses as $course)
                                        <option value="{{ $course->id }}" {{ (old('course_id', $exam->course_id) == $course->id) ? 'selected' : '' }}>
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

                        <!-- Creator -->
                        <div class="space-y-2">
                            <label class="flex items-center space-x-2 text-sm font-bold text-gray-700 dark:text-gray-300">
                                <svg class="w-4 h-4 text-indigo-600 dark:text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                                <span>Creator</span>
                                <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <select name="qcreator_id" 
                                        required
                                        class="w-full px-4 py-3.5 bg-white dark:bg-gray-700 border-2 border-gray-200 dark:border-gray-600 rounded-xl focus:ring-4 focus:ring-indigo-500/20 focus:border-indigo-500 dark:focus:border-indigo-400 transition-all duration-300 text-gray-900 dark:text-white placeholder-gray-400 dark:placeholder-gray-500 font-medium shadow-sm hover:shadow-md appearance-none">
                                    <option value="">Select a creator</option>
                                    @foreach($qcreators as $qcreator)
                                        <option value="{{ $qcreator->id }}" {{ (old('qcreator_id', $exam->qcreator_id) == $qcreator->id) ? 'selected' : '' }}>
                                            {{ $qcreator->full_name }}
                                        </option>
                                    @endforeach
                                </select>
                                <div class="absolute inset-y-0 right-0 flex items-center pr-4 pointer-events-none">
                                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                    </svg>
                                </div>
                            </div>
                            @error('qcreator_id')
                                <div class="flex items-center space-x-2 text-red-600 dark:text-red-400 text-sm font-medium bg-red-50 dark:bg-red-900/20 px-3 py-2 rounded-lg">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    <span>{{ $message }}</span>
                                </div>
                            @enderror
                        </div>

                        <!-- Exam Number -->
                        <div class="space-y-2">
                            <label class="flex items-center space-x-2 text-sm font-bold text-gray-700 dark:text-gray-300">
                                <svg class="w-4 h-4 text-indigo-600 dark:text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 20l4-16m2 16l4-16M6 9h14M4 15h14"></path>
                                </svg>
                                <span>Exam Number</span>
                            </label>
                            <div class="relative">
                                <input type="text" 
                                       name="exam_number" 
                                       value="{{ old('exam_number', $exam->exam_number) }}" 
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

                        <!-- Price -->
                        <div class="space-y-2">
                            <label class="flex items-center space-x-2 text-sm font-bold text-gray-700 dark:text-gray-300">
                                <svg class="w-4 h-4 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <span>Price (BDT)</span>
                            </label>
                            <div class="relative">
                                <input type="number" 
                                       name="price" 
                                       value="{{ old('price', $exam->price) }}" 
                                       min="0" 
                                       placeholder="e.g., 100"
                                       class="w-full px-4 py-3.5 bg-white dark:bg-gray-700 border-2 border-gray-200 dark:border-gray-600 rounded-xl focus:ring-4 focus:ring-green-500/20 focus:border-green-500 dark:focus:border-green-400 transition-all duration-300 text-gray-900 dark:text-white placeholder-gray-400 dark:placeholder-gray-500 font-medium shadow-sm hover:shadow-md">
                                <div class="absolute inset-y-0 right-0 flex items-center pr-4 pointer-events-none">
                                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                            </div>
                            @error('price')
                                <div class="flex items-center space-x-2 text-red-600 dark:text-red-400 text-sm font-medium bg-red-50 dark:bg-red-900/20 px-3 py-2 rounded-lg">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    <span>{{ $message }}</span>
                                </div>
                            @enderror
                        </div>
                    </div>

                    <!-- Exam Title -->
                    <div class="space-y-2 pt-4">
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
                                   value="{{ old('title', $exam->title) }}" 
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

                    <!-- Description -->
                    <div class="space-y-2">
                        <label class="flex items-center space-x-2 text-sm font-bold text-gray-700 dark:text-gray-300">
                            <svg class="w-4 h-4 text-gray-600 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"></path>
                            </svg>
                            <span>Description</span>
                        </label>
                        <div class="relative">
                            <textarea name="description" 
                                      rows="3" 
                                      placeholder="Enter exam description..."
                                      class="w-full px-4 py-3.5 bg-white dark:bg-gray-700 border-2 border-gray-200 dark:border-gray-600 rounded-xl focus:ring-4 focus:ring-gray-500/20 focus:border-gray-500 dark:focus:border-gray-400 transition-all duration-300 text-gray-900 dark:text-white placeholder-gray-400 dark:placeholder-gray-500 font-medium shadow-sm hover:shadow-md">{{ old('description', $exam->description) }}</textarea>
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

                    <!-- Exam Configuration -->
                    <div class="space-y-3 pt-2">
                        <h3 class="text-sm font-bold text-gray-900 dark:text-white flex items-center gap-2">
                            <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"></path>
                            </svg>
                            Exam Configuration
                        </h3>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <!-- Duration -->
                            <div class="space-y-2">
                                <label class="flex items-center space-x-2 text-sm font-bold text-gray-700 dark:text-gray-300">
                                    <svg class="w-4 h-4 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    <span>Duration (min)</span>
                                    <span class="text-red-500">*</span>
                                </label>
                                <div class="relative">
                                    <input type="number" 
                                           name="duration" 
                                           value="{{ old('duration', $exam->duration) }}" 
                                           min="1" required
                                           placeholder="e.g., 60"
                                           class="w-full px-4 py-3.5 bg-white dark:bg-gray-700 border-2 border-gray-200 dark:border-gray-600 rounded-xl focus:ring-4 focus:ring-blue-500/20 focus:border-blue-500 dark:focus:border-blue-400 transition-all duration-300 text-gray-900 dark:text-white placeholder-gray-400 dark:placeholder-gray-500 font-medium shadow-sm hover:shadow-md">
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

                            <!-- Total Questions -->
                            <div class="space-y-2">
                                <label class="flex items-center space-x-2 text-sm font-bold text-gray-700 dark:text-gray-300">
                                    <svg class="w-4 h-4 text-indigo-600 dark:text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                                    </svg>
                                    <span>Total Questions</span>
                                    <span class="text-red-500">*</span>
                                </label>
                                <div class="relative">
                                    <input type="number" 
                                           name="total_questions" 
                                           value="{{ old('total_questions', $exam->total_questions) }}" 
                                           min="1" required
                                           placeholder="e.g., 50"
                                           class="w-full px-4 py-3.5 bg-white dark:bg-gray-700 border-2 border-gray-200 dark:border-gray-600 rounded-xl focus:ring-4 focus:ring-indigo-500/20 focus:border-indigo-500 dark:focus:border-indigo-400 transition-all duration-300 text-gray-900 dark:text-white placeholder-gray-400 dark:placeholder-gray-500 font-medium shadow-sm hover:shadow-md">
                                    <div class="absolute inset-y-0 right-0 flex items-center pr-4 pointer-events-none">
                                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
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
                                           value="{{ old('passing_marks', $exam->passing_marks) }}" 
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
                                        <option value="english" {{ old('question_language', $exam->question_language) === 'english' ? 'selected' : '' }}>🇺🇸 English</option>
                                        <option value="bangla" {{ old('question_language', $exam->question_language) === 'bangla' ? 'selected' : '' }}>🇧🇩 Bangla</option>
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
                    </div>

                    <!-- Schedule Section -->
                    <div class="space-y-3 pt-2">
                        <h3 class="text-sm font-bold text-gray-900 dark:text-white flex items-center gap-2">
                            <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h.01M9 16h.01M15 16h.01M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                            Schedule & Timing
                        </h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <!-- Start Date & Time -->
                            <div class="space-y-2">
                                <label class="text-xs font-medium text-gray-600 dark:text-gray-400">Start Date & Time <span class="text-red-500">*</span></label>
                                <div class="relative">
                                    <input type="datetime-local" 
                                           name="startDateTime" 
                                           value="{{ old('startDateTime', $exam->start_time ? $exam->start_time->format('Y-m-d\TH:i') : now()->addHours(2)->format('Y-m-d\TH:i')) }}" 
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
                                           value="{{ old('endDateTime', $exam->end_time ? $exam->end_time->format('Y-m-d\TH:i') : now()->addHours(4)->format('Y-m-d\TH:i')) }}" 
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
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
                            <!-- Allow Review -->
                            <div class="flex items-center justify-between p-3 bg-gray-50 dark:bg-gray-700 rounded-xl">
                                <div>
                                    <h4 class="text-sm font-medium text-gray-900 dark:text-white">Allow Review</h4>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">Students can review answers</p>
                                </div>
                                <input type="checkbox" name="allow_review" value="1" {{ old('allow_review', $exam->allow_review) ? 'checked' : '' }} class="w-5 h-5 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600" id="allowReviewToggle">
                            </div>

                            <!-- Negative Marking -->
                            <div class="flex items-center justify-between p-3 bg-gray-50 dark:bg-gray-700 rounded-xl">
                                <div>
                                    <h4 class="text-sm font-medium text-gray-900 dark:text-white">Negative Marking</h4>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">Deduct marks for wrong answers</p>
                                </div>
                                <input type="checkbox" name="has_negative_marking" value="1" {{ old('has_negative_marking', $exam->has_negative_marking) ? 'checked' : '' }} class="w-5 h-5 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600" id="negativeMarkingToggle" onchange="toggleNegativeMarkingInput()">
                            </div>

                            <!-- Marks per Wrong Answer -->
                            <div class="md:col-span-3 flex flex-col sm:flex-row sm:items-center sm:justify-between p-3 bg-gray-50 dark:bg-gray-700 rounded-xl gap-3">
                                <div>
                                    <h4 class="text-sm font-medium text-gray-900 dark:text-white">Deduct Marks</h4>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">Negative marking value</p>
                                </div>
                                <div class="flex items-center gap-3">
                                    <div id="negativeMarkingInputContainer" class="{{ old('has_negative_marking', $exam->has_negative_marking) ? '' : 'hidden' }}">
                                        <input type="number" 
                                               name="negative_marks_per_question" 
                                               value="{{ old('negative_marks_per_question', $exam->negative_marks_per_question) }}" 
                                               min="0" max="5" step="0.25"
                                               class="w-24 px-3 py-2 bg-white dark:bg-gray-600 border border-gray-300 dark:border-gray-500 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:text-white text-center">
                                    </div>
                                    <div id="negativeMarkingPlaceholder" class="{{ old('has_negative_marking', $exam->has_negative_marking) ? 'hidden' : '' }} text-sm text-gray-400">
                                        Disabled
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex flex-wrap gap-3 pt-4 border-t border-gray-200 dark:border-gray-700">
                        <!-- Back Button -->
                        <a href="{{ route('system-admin.public-exams.index') }}" class="inline-flex items-center gap-2 px-4 py-2 rounded-lg border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                            </svg>
                            <span>Back</span>
                        </a>
                        
                        <!-- Publish/Unpublish Button -->
                        @if($exam->status === 'draft')
                            <form action="{{ route('system-admin.public-exams.publish', $exam) }}" method="POST" class="inline">
                                @csrf
                                <button type="submit" class="inline-flex items-center gap-2 px-4 py-2 rounded-lg bg-green-600 text-white hover:bg-green-700">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                    <span>Publish Exam</span>
                                </button>
                            </form>
                        @else
                            <form action="{{ route('system-admin.public-exams.unpublish', $exam) }}" method="POST" class="inline">
                                @csrf
                                <button type="submit" class="inline-flex items-center gap-2 px-4 py-2 rounded-lg bg-yellow-600 text-white hover:bg-yellow-700">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                    </svg>
                                    <span>Unpublish Exam</span>
                                </button>
                            </form>
                        @endif
                        
                        <!-- Update Button -->
                        <button type="submit" form="examEditForm" class="inline-flex items-center gap-2 px-4 py-2 rounded-lg bg-indigo-600 text-white hover:bg-indigo-700">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                            </svg>
                            <span>Update Exam</span>
                        </button>
                        
                        <!-- Delete Button -->
                        <button type="button" onclick="confirmDelete({{ $exam->id }})" class="inline-flex items-center gap-2 px-4 py-2 rounded-lg bg-red-600 text-white hover:bg-red-700">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                            </svg>
                            <span>Delete Exam</span>
                        </button>
                    </div>
                </form>
                
                <!-- Delete Form (Hidden) -->
                <form id="deleteForm" action="{{ route('system-admin.public-exams.destroy', $exam) }}" method="POST" class="hidden">
                    @csrf
                    @method('DELETE')
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
                            <span>Exams can be edited at any time before publishing</span>
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
        const marksInput = document.querySelector('input[name="negative_marks_per_question"]');
        
        if (checkbox && inputContainer && placeholder) {
            if (checkbox.checked) {
                inputContainer.classList.remove('hidden');
                placeholder.classList.add('hidden');
                // Add required attribute when checkbox is checked
                if (marksInput) {
                    marksInput.required = true;
                }
            } else {
                inputContainer.classList.add('hidden');
                placeholder.classList.remove('hidden');
                // Remove required attribute when checkbox is unchecked
                if (marksInput) {
                    marksInput.required = false;
                }
            }
        }
    }
    
    // Initialize on page load
    document.addEventListener('DOMContentLoaded', function() {
        // Set initial state for negative marking input
        const negativeMarkingCheckbox = document.getElementById('negativeMarkingToggle');
        if (negativeMarkingCheckbox) {
            // Add event listener for negative marking toggle
            negativeMarkingCheckbox.addEventListener('change', toggleNegativeMarkingInput);
            // Set initial state
            toggleNegativeMarkingInput();
        }
    });
    
    // Confirm delete function
    function confirmDelete(examId) {
        if (confirm('Are you sure you want to delete this exam? This action cannot be undone.')) {
            document.getElementById('deleteForm').submit();
        }
    }
</script>
@endcan
@endsection