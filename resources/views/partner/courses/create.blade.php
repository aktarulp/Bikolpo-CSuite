@extends('layouts.partner-layout')

@section('title', 'Add Course')

@section('content')
@can('courses-add')
<!-- Slim, professional layout -->
<div class="min-h-screen bg-gray-50 dark:bg-gray-900 py-4">
    <div class="max-w-3xl mx-auto space-y-4">
        
        <!-- Slim Header with action button -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow border border-gray-200 dark:border-gray-700 p-4">
            <div class="flex items-center justify-between gap-3">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-lg bg-indigo-600 text-white flex items-center justify-center">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253"></path>
                        </svg>
                    </div>
                    <div>
                        <h1 class="text-xl sm:text-2xl font-bold text-gray-900 dark:text-white">Add Course</h1>
                        <p class="text-sm text-gray-600 dark:text-gray-400">Create a new academic course</p>
                    </div>
                </div>
                <div class="flex items-center gap-2">
                    <a href="{{ route('partner.courses.index') }}" class="hidden sm:inline-flex items-center gap-2 px-4 py-2 rounded-lg border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                        <span>Back</span>
                    </a>
                    <button type="submit" form="courseCreateForm" class="inline-flex items-center gap-2 px-4 py-2 rounded-lg bg-indigo-600 text-white hover:bg-indigo-700">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                        </svg>
                        <span>Create</span>
                    </button>
                </div>
            </div>
        </div>

        <!-- Form Card -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow border border-gray-200 dark:border-gray-700">
            <div class="p-4 sm:p-6">
                <form id="courseCreateForm" action="{{ route('partner.courses.store') }}" method="POST" class="space-y-5">
                    @csrf

                    <!-- Course Name & Code -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Course Name -->
                        <div class="space-y-2">
                            <label class="flex items-center space-x-2 text-sm font-bold text-gray-700 dark:text-gray-300">
                                <svg class="w-4 h-4 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                </svg>
                                <span>Course Name</span>
                                <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <input type="text" 
                                       name="name" 
                                       value="{{ old('name') }}" 
                                       required
                                       placeholder="e.g., Computer Science"
                                       class="w-full px-4 py-3.5 bg-white dark:bg-gray-700 border-2 border-gray-200 dark:border-gray-600 rounded-xl focus:ring-4 focus:ring-blue-500/20 focus:border-blue-500 dark:focus:border-blue-400 transition-all duration-300 text-gray-900 dark:text-white placeholder-gray-400 dark:placeholder-gray-500 font-medium shadow-sm hover:shadow-md">
                                <div class="absolute inset-y-0 right-0 flex items-center pr-4 pointer-events-none">
                                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path>
                                    </svg>
                                </div>
                            </div>
                            @error('name')
                                <div class="flex items-center space-x-2 text-red-600 dark:text-red-400 text-sm font-medium bg-red-50 dark:bg-red-900/20 px-3 py-2 rounded-lg">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    <span>{{ $message }}</span>
                                </div>
                            @enderror
                        </div>

                        <!-- Course Code -->
                        <div class="space-y-2">
                            <label class="flex items-center space-x-2 text-sm font-bold text-gray-700 dark:text-gray-300">
                                <svg class="w-4 h-4 text-indigo-600 dark:text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 20l4-16m2 16l4-16M6 9h14M4 15h14"></path>
                                </svg>
                                <span>Course Code</span>
                                <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <input type="text" 
                                       name="code" 
                                       value="{{ old('code') }}" 
                                       required
                                       placeholder="e.g., CS101"
                                       class="w-full px-4 py-3.5 bg-white dark:bg-gray-700 border-2 border-gray-200 dark:border-gray-600 rounded-xl focus:ring-4 focus:ring-indigo-500/20 focus:border-indigo-500 dark:focus:border-indigo-400 transition-all duration-300 text-gray-900 dark:text-white placeholder-gray-400 dark:placeholder-gray-500 font-medium shadow-sm hover:shadow-md uppercase">
                                <div class="absolute inset-y-0 right-0 flex items-center pr-4 pointer-events-none">
                                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"></path>
                                    </svg>
                                </div>
                            </div>
                            @error('code')
                                <div class="flex items-center space-x-2 text-red-600 dark:text-red-400 text-sm font-medium bg-red-50 dark:bg-red-900/20 px-3 py-2 rounded-lg">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    <span>{{ $message }}</span>
                                </div>
                            @enderror
                        </div>
                    </div>

                    <!-- Description -->
                    <div class="space-y-2">
                        <label class="flex items-center space-x-2 text-sm font-bold text-gray-700 dark:text-gray-300">
                            <svg class="w-4 h-4 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7"></path>
                            </svg>
                            <span>Description</span>
                            <span class="text-gray-400 text-xs font-normal">(Optional)</span>
                        </label>
                        <div class="relative">
                            <textarea name="description" 
                                      rows="4" 
                                      placeholder="Enter course description, objectives, or any additional information..."
                                      class="w-full px-4 py-3.5 bg-white dark:bg-gray-700 border-2 border-gray-200 dark:border-gray-600 rounded-xl focus:ring-4 focus:ring-purple-500/20 focus:border-purple-500 dark:focus:border-purple-400 transition-all duration-300 text-gray-900 dark:text-white placeholder-gray-400 dark:placeholder-gray-500 font-medium shadow-sm hover:shadow-md resize-none">{{ old('description') }}</textarea>
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

                    <!-- Footer (only cancel) -->
                    <div class="flex justify-end pt-4 border-t border-gray-200 dark:border-gray-700">
                        <a href="{{ route('partner.courses.index') }}" class="inline-flex items-center gap-2 px-4 py-2 rounded-lg border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700">
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
                            <span>Use a clear, descriptive name for your course</span>
                        </li>
                        <li class="flex items-start space-x-2">
                            <span class="text-blue-600 dark:text-blue-400 mt-0.5">•</span>
                            <span>Course codes should be unique and follow your institution's format</span>
                        </li>
                        <li class="flex items-start space-x-2">
                            <span class="text-blue-600 dark:text-blue-400 mt-0.5">•</span>
                            <span>Add a description to help students understand the course content</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endcan
@endsection 
