@extends('layouts.partner-layout')

@section('title', 'Add Subject')

@section('content')
<!-- Mobile-First Professional Subject Create -->
<div class="min-h-screen bg-gray-50 dark:bg-gray-900">
    <div class="max-w-4xl mx-auto px-4 py-4 sm:px-6 lg:px-8">
        
        <!-- Header Section -->
        <div class="mb-4">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                <!-- Title & Breadcrumb -->
                <div class="flex-1">
                    <div class="flex items-center gap-2 text-sm text-gray-600 dark:text-gray-400 mb-2">
                        <a href="{{ route('partner.dashboard') }}" class="hover:text-primaryGreen transition-colors">Dashboard</a>
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                        <a href="{{ route('partner.subjects.index') }}" class="hover:text-primaryGreen transition-colors">Subjects</a>
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                        <span class="text-primaryGreen font-medium">Add New</span>
                    </div>
                    <h1 class="text-2xl sm:text-3xl lg:text-4xl font-black text-gray-900 dark:text-white flex items-center gap-3">
                        <span class="inline-flex items-center justify-center w-10 h-10 sm:w-12 sm:h-12 bg-gradient-to-br from-blue-500 to-indigo-500 rounded-xl shadow-lg">
                            <svg class="w-5 h-5 sm:w-6 sm:h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                            </svg>
                        </span>
                        Add New Subject
                    </h1>
                    <p class="text-sm sm:text-base text-gray-600 dark:text-gray-400 mt-2">Create a new subject and assign it to a course</p>
                </div>
                
                <div class="flex items-center gap-2">
                    <a href="{{ route('partner.subjects.index') }}" 
                       class="hidden sm:inline-flex items-center gap-2 px-4 py-2 rounded-lg border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                        <span>Back</span>
                    </a>
                    <button type="submit" form="subjectCreateForm" 
                            class="inline-flex items-center gap-2 px-4 py-2 rounded-lg bg-blue-600 text-white hover:bg-blue-700">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                        </svg>
                        <span>Create</span>
                    </button>
                </div>
            </div>
        </div>

        <!-- Form Card -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow border border-gray-200 dark:border-gray-700 overflow-hidden">
            <!-- Form Header -->
            <div class="px-4 py-3 border-b border-gray-200 dark:border-gray-700">
                <h2 class="text-base font-semibold text-gray-900 dark:text-white">Subject Information</h2>
                <p class="text-xs text-gray-600 dark:text-gray-400">Fill in the details below</p>
            </div>

            <!-- Form Body -->
            <form id="subjectCreateForm" action="{{ route('partner.subjects.store') }}" method="POST" class="p-4 sm:p-6 space-y-5">
                @csrf

                <!-- Course Selection -->
                <div class="space-y-2">
                    <label class="flex items-center gap-2 text-sm font-bold text-gray-700 dark:text-gray-300">
                        <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                        </svg>
                        Course <span class="text-red-500">*</span>
                    </label>
                    <p class="text-xs text-gray-500 dark:text-gray-400">Select the course this subject belongs to</p>
                    <div class="relative">
                        <select name="course_id" required 
                                class="w-full px-4 py-3 bg-gray-50 dark:bg-gray-700 border-2 border-gray-200 dark:border-gray-600 rounded-xl focus:ring-4 focus:ring-blue-500/20 focus:border-blue-500 transition-all duration-200 appearance-none text-gray-900 dark:text-white font-medium">
                            <option value="">Choose a course...</option>
                            @foreach($courses as $course)
                                <option value="{{ $course->id }}" {{ old('course_id') == $course->id ? 'selected' : '' }}>
                                    {{ $course->name }} ({{ $course->code }})
                                </option>
                            @endforeach
                        </select>
                        <div class="absolute right-4 top-1/2 -translate-y-1/2 pointer-events-none">
                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </div>
                    </div>
                    @error('course_id')
                        <p class="flex items-center gap-1 text-red-500 text-sm mt-1">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <!-- Subject Name & Code -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Subject Name -->
                    <div class="space-y-2">
                        <label class="flex items-center gap-2 text-sm font-bold text-gray-700 dark:text-gray-300">
                            <svg class="w-5 h-5 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                            </svg>
                            Subject Name <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="name" value="{{ old('name') }}" required
                               placeholder="e.g., Mathematics, Physics, Chemistry"
                               class="w-full px-4 py-3 bg-gray-50 dark:bg-gray-700 border-2 border-gray-200 dark:border-gray-600 rounded-xl focus:ring-4 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all duration-200 text-gray-900 dark:text-white placeholder-gray-400">
                        @error('name')
                            <p class="flex items-center gap-1 text-red-500 text-sm mt-1">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <!-- Subject Code -->
                    <div class="space-y-2">
                        <label class="flex items-center gap-2 text-sm font-bold text-gray-700 dark:text-gray-300">
                            <svg class="w-5 h-5 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 20l4-16m2 16l4-16M6 9h14M4 15h14"></path>
                            </svg>
                            Subject Code <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="code" value="{{ old('code') }}" required
                               placeholder="e.g., MATH101, PHY201"
                               class="w-full px-4 py-3 bg-gray-50 dark:bg-gray-700 border-2 border-gray-200 dark:border-gray-600 rounded-xl focus:ring-4 focus:ring-purple-500/20 focus:border-purple-500 transition-all duration-200 text-gray-900 dark:text-white placeholder-gray-400 uppercase">
                        @error('code')
                            <p class="flex items-center gap-1 text-red-500 text-sm mt-1">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>
                </div>

                <!-- Description -->
                <div class="space-y-2">
                    <label class="flex items-center gap-2 text-sm font-bold text-gray-700 dark:text-gray-300">
                        <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7"></path>
                        </svg>
                        Description <span class="text-gray-400 text-xs font-normal">(Optional)</span>
                    </label>
                    <textarea name="description" rows="4" 
                              placeholder="Provide a brief description of this subject..."
                              class="w-full px-4 py-3 bg-gray-50 dark:bg-gray-700 border-2 border-gray-200 dark:border-gray-600 rounded-xl focus:ring-4 focus:ring-green-500/20 focus:border-green-500 transition-all duration-200 text-gray-900 dark:text-white placeholder-gray-400 resize-none">{{ old('description') }}</textarea>
                    @error('description')
                        <p class="flex items-center gap-1 text-red-500 text-sm mt-1">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <!-- Form Actions -->
                <div class="flex justify-end pt-4 border-t border-gray-200 dark:border-gray-700">
                    <a href="{{ route('partner.subjects.index') }}" 
                       class="inline-flex items-center gap-2 px-4 py-2 rounded-lg border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                        Cancel
                    </a>
                </div>
            </form>
        </div>

        <!-- Help Card -->
        <div class="mt-4 bg-blue-50 dark:bg-blue-900/20 rounded-xl p-4 border border-blue-200 dark:border-blue-800">
            <div class="flex items-start gap-3">
                <div class="flex-shrink-0 w-10 h-10 bg-blue-100 dark:bg-blue-900/50 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div class="flex-1">
                    <h3 class="text-sm font-bold text-blue-900 dark:text-blue-300 mb-1">Quick Tips</h3>
                    <ul class="text-xs text-blue-800 dark:text-blue-400 space-y-1">
                        <li>• Subject codes should be unique and follow your institution's naming convention</li>
                        <li>• Choose a descriptive name that clearly identifies the subject</li>
                        <li>• The description helps students understand what the subject covers</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 
