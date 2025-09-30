@extends('layouts.partner-layout')

@section('title', 'Students')

@section('content')
<div class="space-y-4 md:space-y-6">
    <!-- Page Header - Mobile First -->
    <div class="bg-gradient-to-br from-purple-600 via-pink-500 to-orange-500 rounded-2xl shadow-2xl p-4 md:p-6 lg:p-8">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <div class="flex-1">
                <div class="flex items-center space-x-3 mb-2">
                    <div class="bg-white/20 backdrop-blur-sm p-2 md:p-3 rounded-xl">
                        <svg class="w-6 h-6 md:w-8 md:h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                        </svg>
                    </div>
                    <div>
                        <h1 class="text-2xl md:text-3xl lg:text-4xl font-bold text-white drop-shadow-lg">Students</h1>
                        <p class="text-white/90 text-sm md:text-base">Manage your student community</p>
                    </div>
                </div>
            </div>
            <a href="{{ route('partner.students.create') }}" 
               class="w-full sm:w-auto bg-white hover:bg-gray-100 text-purple-600 font-semibold px-4 md:px-6 py-2.5 md:py-3 rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 flex items-center justify-center space-x-2 group">
                <svg class="w-5 h-5 group-hover:rotate-90 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                </svg>
                <span>Add Student</span>
            </a>
        </div>
    </div>

    <!-- Filters Section - Collapsible on Mobile -->
    <div class="bg-white dark:bg-gray-800 rounded-xl md:rounded-2xl shadow-lg border-2 border-gray-100 dark:border-gray-700">
        <div class="p-4 md:p-6 border-b border-gray-200 dark:border-gray-700">
            <div class="flex items-center justify-between mb-4">
                <div class="flex items-center space-x-2">
                    <div class="bg-gradient-to-r from-indigo-500 to-purple-500 p-2 rounded-lg">
                        <svg class="w-4 h-4 md:w-5 md:h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path>
                        </svg>
                    </div>
                    <h2 class="text-base md:text-lg font-bold text-gray-900 dark:text-white">Filters</h2>
                </div>
                <button type="button" id="toggle-filters" class="text-sm font-medium text-indigo-600 hover:text-indigo-700 dark:text-indigo-400 flex items-center space-x-1 transition-colors">
                    <span id="toggle-text">Hide</span>
                    <svg id="toggle-icon" class="w-4 h-4 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"></path>
                    </svg>
                </button>
            </div>
            
            <div id="filters-content">
                <form method="GET" action="{{ route('partner.students.index') }}" class="space-y-3 md:space-y-4">
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-5 gap-3 md:gap-4">
                        <!-- Search -->
                        <div class="sm:col-span-2 lg:col-span-1">
                            <label for="search" class="block text-xs font-semibold text-gray-700 dark:text-gray-300 mb-1.5 flex items-center space-x-1">
                                <svg class="w-3 h-3 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                </svg>
                                <span>Search</span>
                            </label>
                            <input type="text" name="search" id="search" 
                                   value="{{ request('search') }}"
                                   placeholder="Name, Email, ID..."
                                   class="w-full px-3 py-2 text-sm border-2 border-gray-200 dark:border-gray-600 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white transition-all">
                        </div>
                        
                        <!-- Status -->
                        <div>
                            <label for="status" class="block text-xs font-semibold text-gray-700 dark:text-gray-300 mb-1.5 flex items-center space-x-1">
                                <svg class="w-3 h-3 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <span>Status</span>
                            </label>
                            <select name="status" id="status" 
                                    class="w-full px-3 py-2 text-sm border-2 border-gray-200 dark:border-gray-600 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 dark:bg-gray-700 dark:text-white transition-all">
                                <option value="all" {{ request('status') == 'all' || !request('status') ? 'selected' : '' }}>All Status</option>
                                <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
                                <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                            </select>
                        </div>
                        
                        <!-- Course -->
                        <div>
                            <label for="course_id" class="block text-xs font-semibold text-gray-700 dark:text-gray-300 mb-1.5 flex items-center space-x-1">
                                <svg class="w-3 h-3 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                </svg>
                                <span>Course</span>
                            </label>
                            <select name="course_id" id="course_id" 
                                    class="w-full px-3 py-2 text-sm border-2 border-gray-200 dark:border-gray-600 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-orange-500 dark:bg-gray-700 dark:text-white transition-all">
                                <option value="all" {{ request('course_id') == 'all' || !request('course_id') ? 'selected' : '' }}>All Courses</option>
                                @foreach($courses as $course)
                                    <option value="{{ $course->id }}" {{ request('course_id') == $course->id ? 'selected' : '' }}>
                                        {{ $course->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        
                        <!-- Batch -->
                        <div>
                            <label for="batch_id" class="block text-xs font-semibold text-gray-700 dark:text-gray-300 mb-1.5 flex items-center space-x-1">
                                <svg class="w-3 h-3 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                                </svg>
                                <span>Batch</span>
                            </label>
                            <select name="batch_id" id="batch_id" 
                                    class="w-full px-3 py-2 text-sm border-2 border-gray-200 dark:border-gray-600 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-purple-500 dark:bg-gray-700 dark:text-white transition-all">
                                <option value="all" {{ request('batch_id') == 'all' || !request('batch_id') ? 'selected' : '' }}>All Batches</option>
                                @foreach($batches as $batch)
                                    <option value="{{ $batch->id }}" {{ request('batch_id') == $batch->id ? 'selected' : '' }}>
                                        {{ $batch->display_name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        
                        <!-- Gender -->
                        <div>
                            <label for="gender" class="block text-xs font-semibold text-gray-700 dark:text-gray-300 mb-1.5 flex items-center space-x-1">
                                <svg class="w-3 h-3 text-pink-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                                <span>Gender</span>
                            </label>
                            <select name="gender" id="gender" 
                                    class="w-full px-3 py-2 text-sm border-2 border-gray-200 dark:border-gray-600 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-pink-500 focus:border-pink-500 dark:bg-gray-700 dark:text-white transition-all">
                                <option value="all" {{ request('gender') == 'all' || !request('gender') ? 'selected' : '' }}>All Genders</option>
                                <option value="male" {{ request('gender') == 'male' ? 'selected' : '' }}>Male</option>
                                <option value="female" {{ request('gender') == 'female' ? 'selected' : '' }}>Female</option>
                                <option value="other" {{ request('gender') == 'other' ? 'selected' : '' }}>Other</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="flex items-center space-x-3 pt-2">
                        <a href="{{ route('partner.students.index') }}" 
                           class="bg-gradient-to-r from-gray-500 to-gray-600 hover:from-gray-600 hover:to-gray-700 text-white px-4 py-2 rounded-lg transition-all duration-200 shadow-md hover:shadow-lg flex items-center space-x-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                            <span>Clear Filters</span>
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Students List - Mobile Optimized -->
    <div class="bg-white dark:bg-gray-800 rounded-xl md:rounded-2xl shadow-lg border-2 border-gray-100 dark:border-gray-700 overflow-hidden">
        <div class="bg-gradient-to-r from-indigo-500 via-purple-500 to-pink-500 p-4 md:p-6">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-3">
                    <div class="bg-white/20 backdrop-blur-sm p-2 rounded-lg">
                        <svg class="w-5 h-5 md:w-6 md:h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                        </svg>
                    </div>
                    <div>
                        <h2 class="text-lg md:text-xl font-bold text-white">
                            Student List
                        </h2>
                        <p class="text-xs md:text-sm text-white/90">
                            @if(request()->anyFilled(['search', 'status', 'course_id', 'batch_id', 'gender']))
                                Filtered: {{ $students->total() }} students
                            @else
                                Total: {{ $students->total() }} students
                            @endif
                        </p>
                    </div>
                </div>
                @if(request()->anyFilled(['search', 'status', 'course_id', 'batch_id', 'gender']))
                    <span class="bg-white/20 backdrop-blur-sm text-white text-xs font-semibold px-3 py-1 rounded-full">
                        Filtered
                    </span>
                @endif
            </div>
        </div>

        @if($students->count() > 0)
            <!-- Mobile Card View -->
            <div class="block lg:hidden">
                <div class="divide-y divide-gray-200 dark:divide-gray-700">
                    @foreach($students as $student)
                    <div class="p-4 hover:bg-gradient-to-r hover:from-blue-50 hover:to-purple-50 dark:hover:from-gray-700 dark:hover:to-gray-600 transition-all duration-200">
                        <div class="flex items-start space-x-3">
                            <div class="flex-shrink-0">
                                @if($student->photo)
                                    <img class="h-14 w-14 rounded-xl object-cover shadow-lg ring-2 ring-purple-500" 
                                         src="{{ Storage::url($student->photo) }}" 
                                         alt="{{ $student->full_name }}">
                                @else
                                    <div class="h-14 w-14 rounded-xl bg-gradient-to-br from-blue-500 via-purple-500 to-pink-500 flex items-center justify-center shadow-lg ring-2 ring-purple-500">
                                        <span class="text-xl font-bold text-white">{{ substr($student->full_name, 0, 1) }}</span>
                                    </div>
                                @endif
                            </div>
                            <div class="flex-1 min-w-0">
                                <div class="flex items-start justify-between">
                                    <div class="flex-1">
                                        <h3 class="text-base font-bold text-gray-900 dark:text-white truncate">{{ $student->full_name }}</h3>
                                        <p class="text-xs text-gray-500 dark:text-gray-400 truncate">{{ $student->email }}</p>
                                    </div>
                                    <span class="ml-2 inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium
                                        @if($student->status === 'active') bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400
                                        @else bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400 @endif">
                                        {{ ucfirst($student->status) }}
                                    </span>
                                </div>
                                <div class="mt-2 flex flex-wrap gap-2">
                                    <div class="inline-flex items-center px-2 py-1 rounded-lg text-xs font-mono font-semibold bg-gradient-to-r from-gray-100 to-gray-200 dark:from-gray-700 dark:to-gray-800 text-gray-700 dark:text-gray-300 border border-gray-300 dark:border-gray-600">
                                        <svg class="w-3 h-3 mr-1 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 20l4-16m2 16l4-16M6 9h14M4 15h14"></path>
                                        </svg>
                                        {{ $student->student_id ?? 'N/A' }}
                                    </div>
                                    <div class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium {{ $student->course ? 'bg-orange-100 text-orange-800 dark:bg-orange-900/30 dark:text-orange-400' : 'bg-gray-100 text-gray-600 dark:bg-gray-700 dark:text-gray-400' }}">
                                        <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                        </svg>
                                        {{ $student->course?->name ?? 'No Course' }}
                                    </div>
                                    <div class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium {{ $student->batch ? 'bg-purple-100 text-purple-800 dark:bg-purple-900/30 dark:text-purple-400' : 'bg-gray-100 text-gray-600 dark:bg-gray-700 dark:text-gray-400' }}">
                                        <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                                        </svg>
                                        {{ $student->batch?->display_name ?? 'No Batch' }}
                                    </div>
                                </div>
                                <div class="mt-3 flex flex-wrap gap-2">
                                    <a href="{{ route('partner.students.show', $student) }}" 
                                       class="inline-flex items-center px-3 py-1.5 text-xs font-medium text-blue-700 bg-blue-100 dark:bg-blue-900/30 dark:text-blue-400 rounded-lg hover:bg-blue-200 dark:hover:bg-blue-900/50 transition-colors">
                                        <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                        </svg>
                                        View
                                    </a>
                                    <a href="{{ route('partner.students.edit', $student) }}" 
                                       class="inline-flex items-center px-3 py-1.5 text-xs font-medium text-green-700 bg-green-100 dark:bg-green-900/30 dark:text-green-400 rounded-lg hover:bg-green-200 dark:hover:bg-green-900/50 transition-colors">
                                        <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                        </svg>
                                        Edit
                                    </a>
                                    <a href="{{ route('analytics.students.show', $student->id) }}" 
                                       class="inline-flex items-center px-3 py-1.5 text-xs font-medium text-purple-700 bg-purple-100 dark:bg-purple-900/30 dark:text-purple-400 rounded-lg hover:bg-purple-200 dark:hover:bg-purple-900/50 transition-colors">
                                        <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                                        </svg>
                                        Analytics
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            <!-- Desktop Table View -->
            <div class="hidden lg:block overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                    <thead class="bg-gradient-to-r from-gray-50 to-gray-100 dark:from-gray-700/50 dark:to-gray-800/50">
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-bold text-gray-700 dark:text-gray-200 uppercase tracking-wider border-b-2 border-primaryGreen/30">
                                <div class="flex items-center space-x-2">
                                    <svg class="w-4 h-4 text-primaryGreen" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                    </svg>
                                    <span>Student</span>
                                </div>
                            </th>
                            <th class="px-4 py-3 text-left text-xs font-bold text-gray-700 dark:text-gray-200 uppercase tracking-wider border-b-2 border-gray-500/30">
                                <div class="flex items-center space-x-2">
                                    <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 20l4-16m2 16l4-16M6 9h14M4 15h14"></path>
                                    </svg>
                                    <span>Student ID</span>
                                </div>
                            </th>
                            <th class="px-4 py-3 text-left text-xs font-bold text-gray-700 dark:text-gray-200 uppercase tracking-wider border-b-2 border-green-500/30">
                                <div class="flex items-center space-x-2">
                                    <svg class="w-4 h-4 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 5.477 5.754 5 7.5 5c1.747 0 3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.523 18.246 19 16.5 19c-1.746 0-3.332-.477-4.5-1.253"></path>
                                    </svg>
                                    <span>Course</span>
                                </div>
                            </th>
                            <th class="px-4 py-3 text-left text-xs font-bold text-gray-700 dark:text-gray-200 uppercase tracking-wider border-b-2 border-blue-500/30">
                                <div class="flex items-center space-x-2">
                                    <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                                    </svg>
                                    <span>Batch</span>
                                </div>
                            </th>
                            <th class="px-4 py-3 text-left text-xs font-bold text-gray-700 dark:text-gray-200 uppercase tracking-wider border-b-2 border-yellow-500/30">
                                <div class="flex items-center space-x-2">
                                    <svg class="w-4 h-4 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    <span>Status</span>
                                </div>
                            </th>
                            <th class="px-4 py-3 text-left text-xs font-bold text-gray-700 dark:text-gray-200 uppercase tracking-wider border-b-2 border-orange-500/30">
                                <div class="flex items-center space-x-2">
                                    <svg class="w-4 h-4 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 001.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    </svg>
                                    <span>Actions</span>
                                </div>
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white/50 dark:bg-gray-800/50 divide-y divide-gray-100 dark:divide-gray-700/30">
                        @foreach($students as $student)
                        <tr class="hover:bg-gray-50/80 dark:hover:bg-gray-700/50 student-row transition-all duration-200 group">
                            <td class="px-4 py-3 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-10 w-10">
                                        @if($student->photo)
                                            <img class="h-10 w-10 rounded-full object-cover shadow-lg group-hover:scale-110 transition-transform duration-200" 
                                                 src="{{ Storage::url($student->photo) }}" 
                                                 alt="{{ $student->full_name }}">
                                        @else
                                            <div class="h-10 w-10 rounded-full bg-gradient-to-br from-blue-500 to-indigo-600 flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform duration-200">
                                                <span class="text-base font-bold text-white">{{ substr($student->full_name, 0, 1) }}</span>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="ml-3">
                                        <div class="text-sm font-semibold text-gray-900 dark:text-white group-hover:text-primaryGreen transition-colors duration-200 truncate max-w-32">{{ $student->full_name }}</div>
                                        <div class="text-xs text-gray-500 dark:text-gray-400 truncate max-w-32">{{ $student->email }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-4 py-3 whitespace-nowrap">
                                <div class="inline-flex items-center px-3 py-1.5 rounded-lg text-sm font-mono font-semibold bg-gradient-to-r from-gray-100 to-gray-200 dark:from-gray-700/60 dark:to-gray-800/60 text-gray-700 dark:text-gray-300 border border-gray-300 dark:border-gray-600 shadow-sm hover:shadow-md transition-all duration-200 group-hover:scale-105 group-hover:from-gray-200 group-hover:to-gray-300 dark:group-hover:from-gray-600 dark:group-hover:to-gray-700">
                                    <svg class="w-3 h-3 mr-2 text-gray-500 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 20l4-16m2 16l4-16M6 9h14M4 15h14"></path>
                                    </svg>
                                    {{ $student->student_id ?? 'N/A' }}
                                </div>
                            </td>
                            <td class="px-4 py-3 whitespace-nowrap">
                                <div class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium {{ $student->course ? 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400' : 'bg-amber-50 text-amber-700 dark:bg-amber-900/20 dark:text-amber-400 border border-amber-200 dark:border-amber-800' }}">
                                    {{ $student->course?->name ?? 'Not Assigned' }}
                                </div>
                            </td>
                            <td class="px-4 py-3 whitespace-nowrap">
                                <div class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium {{ $student->batch ? 'bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-400' : 'bg-amber-50 text-amber-700 dark:bg-amber-900/20 dark:text-amber-400 border border-amber-200 dark:border-amber-800' }}">
                                    {{ $student->batch?->display_name ?? 'Not Assigned' }}
                                </div>
                            </td>
                            <td class="px-4 py-3 whitespace-nowrap">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                    @if($student->status === 'active') bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400
                                    @else bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400 @endif">
                                    {{ ucfirst($student->status) }}
                                </span>
                            </td>
                            <td class="px-4 py-3 whitespace-nowrap text-sm font-medium relative z-[100]">
                                <!-- Action Menu -->
                                <div class="relative inline-block text-left z-[100]" x-data="{ open: false }">
                                    <button @click="open = !open" 
                                            @click.away="open = false"
                                            type="button"
                                            class="inline-flex items-center px-3 py-2 text-xs font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm hover:bg-gray-50 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primaryGreen transition-all duration-200">
                                        <span>Actions</span>
                                        <svg class="w-4 h-4 ml-2 -mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                        </svg>
                                    </button>
                                    
                                    <div x-show="open" 
                                         x-transition:enter="transition ease-out duration-200"
                                         x-transition:enter-start="transform opacity-0 scale-95"
                                         x-transition:enter-end="transform opacity-100 scale-100"
                                         x-transition:leave="transition ease-in duration-150"
                                         x-transition:leave-start="transform opacity-100 scale-100"
                                         x-transition:leave-end="transform opacity-0 scale-95"
                                         class="absolute right-0 mt-2 w-56 origin-top-right rounded-md bg-white dark:bg-gray-800 shadow-2xl ring-1 ring-black ring-opacity-5 dark:ring-gray-600 focus:outline-none z-[99999]"
                                         style="z-index: 99999 !important;"
                                         @click.away="open = false">
                                        
                                        <div class="py-1" role="menu" aria-orientation="vertical" aria-labelledby="menu-button">
                                            <a href="{{ route('partner.students.show', $student) }}" 
                                               class="flex items-center px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors duration-200"
                                               role="menuitem">
                                                <svg class="w-4 h-4 mr-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                                </svg>
                                                View Details
                                            </a>
                                            
                                            <a href="{{ route('partner.students.edit', $student) }}" 
                                               class="flex items-center px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors duration-200"
                                               role="menuitem">
                                                <svg class="w-4 h-4 mr-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                                </svg>
                                                Edit Student
                                            </a>
                                            
                                            <a href="{{ route('partner.students.assignment') }}?student_id={{ $student->id }}" 
                                               class="flex items-center px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors duration-200"
                                               role="menuitem">
                                                <svg class="w-4 h-4 mr-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                                                </svg>
                                                Assign Course/Batch
                                            </a>
                                            
                                            <a href="{{ route('analytics.students.show', $student->id) }}" 
                                               class="flex items-center px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors duration-200"
                                               role="menuitem">
                                                <svg class="w-4 h-4 mr-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                                                </svg>
                                                View Analytics
                                            </a>
                                            
                                            <div class="border-t border-gray-100 dark:border-gray-700 my-1"></div>
                                            
                                            <form action="{{ route('partner.students.destroy', $student) }}" method="POST" class="block" role="none">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" 
                                                        onclick="return confirm('Are you sure you want to delete this student?')"
                                                        class="w-full flex items-center px-4 py-2 text-sm text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-900/20 transition-colors duration-200"
                                                        role="menuitem">
                                                    <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                    </svg>
                                                    Delete Student
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            <!-- Pagination -->
            <div class="p-4 md:p-6 border-t border-gray-200 dark:border-gray-700 bg-gradient-to-r from-gray-50 to-white dark:from-gray-800 dark:to-gray-700">
                {{ $students->appends(request()->query())->links() }}
            </div>
        @else
            <div class="p-8 md:p-12 text-center">
                <div class="bg-gradient-to-br from-purple-100 via-pink-100 to-orange-100 dark:from-purple-900/20 dark:via-pink-900/20 dark:to-orange-900/20 rounded-2xl p-8 md:p-12 inline-block">
                    <svg class="mx-auto h-16 w-16 md:h-20 md:w-20 text-purple-500 dark:text-purple-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z" />
                    </svg>
                    <h3 class="mt-4 text-lg md:text-xl font-bold text-gray-900 dark:text-white">No students found</h3>
                    <p class="mt-2 text-sm md:text-base text-gray-600 dark:text-gray-400">
                        @if(request()->anyFilled(['search', 'status', 'course_id', 'batch_id', 'gender']))
                            Try adjusting your filters or search terms.
                        @else
                            Get started by adding your first student.
                        @endif
                    </p>
                    <div class="mt-6 flex flex-col sm:flex-row gap-3 justify-center">
                        @if(request()->anyFilled(['search', 'status', 'course_id', 'batch_id', 'gender']))
                            <a href="{{ route('partner.students.index') }}" 
                               class="inline-flex items-center justify-center px-5 py-2.5 bg-white hover:bg-gray-50 border-2 border-gray-300 shadow-md text-sm font-semibold rounded-xl text-gray-700 transition-all duration-200 hover:shadow-lg">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                                Clear Filters
                            </a>
                        @endif
                        <a href="{{ route('partner.students.create') }}" 
                           class="inline-flex items-center justify-center px-5 py-2.5 bg-gradient-to-r from-purple-600 to-pink-600 hover:from-purple-700 hover:to-pink-700 shadow-lg text-sm font-semibold rounded-xl text-white transition-all duration-200 hover:shadow-xl">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                            </svg>
                            Add Student
                        </a>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const filterForm = document.querySelector('form[method="GET"]');
    const filterSelects = filterForm.querySelectorAll('select');
    const searchInput = document.getElementById('search');
    
    // Filter toggle functionality
    const toggleButton = document.getElementById('toggle-filters');
    const toggleText = document.getElementById('toggle-text');
    const toggleIcon = document.getElementById('toggle-icon');
    const filtersContent = document.getElementById('filters-content');
    
    // Check if filters should be hidden by default (stored in localStorage)
    const filtersHidden = localStorage.getItem('filtersHidden') === 'true';
    if (filtersHidden) {
        filtersContent.style.display = 'none';
        toggleText.textContent = 'Show';
        toggleIcon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>';
    }
    
    toggleButton.addEventListener('click', function() {
        const isHidden = filtersContent.style.display === 'none';
        filtersContent.style.display = isHidden ? 'block' : 'none';
        toggleText.textContent = isHidden ? 'Hide' : 'Show';
        toggleIcon.innerHTML = isHidden 
            ? '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"></path>'
            : '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>';
        localStorage.setItem('filtersHidden', !isHidden);
    });
    
    // Auto-submit form when select filters change
    filterSelects.forEach(select => {
        select.addEventListener('change', function() {
            filterForm.submit();
        });
    });
    
    // Debounced search input
    let searchTimeout;
    searchInput.addEventListener('input', function() {
        clearTimeout(searchTimeout);
        searchTimeout = setTimeout(() => {
            if (this.value.length >= 2 || this.value.length === 0) {
                filterForm.submit();
            }
        }, 500);
    });
    
    // Add filter count badges
    function updateFilterCounts() {
        const activeFilters = [];
        
        if (searchInput.value) activeFilters.push('Search');
        if (document.getElementById('status').value !== 'all') activeFilters.push('Status');
        if (document.getElementById('course_id').value !== 'all') activeFilters.push('Course');
        if (document.getElementById('batch_id').value !== 'all') activeFilters.push('Batch');
        if (document.getElementById('gender').value !== 'all') activeFilters.push('Gender');
        
        const filterHeader = document.querySelector('h2');
        if (activeFilters.length > 0) {
            const badge = document.createElement('span');
            badge.className = 'ml-2 inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-primaryGreen text-white';
            badge.textContent = activeFilters.length;
            
            // Remove existing badge if any
            const existingBadge = filterHeader.querySelector('span');
            if (existingBadge) {
                existingBadge.remove();
            }
            
            filterHeader.appendChild(badge);
        }
    }
    
    // Initialize filter counts
    updateFilterCounts();
    
    // Update counts when filters change
    filterSelects.forEach(select => {
        select.addEventListener('change', updateFilterCounts);
    });
    searchInput.addEventListener('input', updateFilterCounts);
    
    // Add loading indicator when filters are being applied
    filterForm.addEventListener('submit', function() {
        // Add a subtle loading state to the page
        const loadingOverlay = document.createElement('div');
        loadingOverlay.id = 'loading-overlay';
        loadingOverlay.className = 'fixed inset-0 bg-black bg-opacity-20 z-50 flex items-center justify-center';
        loadingOverlay.innerHTML = `
            <div class="bg-white dark:bg-gray-800 rounded-lg p-6 shadow-lg">
                <div class="flex items-center space-x-3">
                    <div class="animate-spin rounded-full h-6 w-6 border-b-2 border-primaryGreen"></div>
                    <span class="text-gray-700 dark:text-gray-300">Applying filters...</span>
                </div>
            </div>
        `;
        document.body.appendChild(loadingOverlay);
    });
});
</script>
@endpush

@push('styles')
<style>
.custom-scrollbar {
    scrollbar-width: thin;
    scrollbar-color: #9CA3AF #F3F4F6;
}

.custom-scrollbar::-webkit-scrollbar {
    height: 8px;
    width: 8px;
}

.custom-scrollbar::-webkit-scrollbar-track {
    background: #F3F4F6;
    border-radius: 4px;
}

.custom-scrollbar::-webkit-scrollbar-thumb {
    background: #9CA3AF;
    border-radius: 4px;
}

.custom-scrollbar::-webkit-scrollbar-thumb:hover {
    background: #6B7280;
}

.dark .custom-scrollbar {
    scrollbar-color: #4B5563 #1F2937;
}

.dark .custom-scrollbar::-webkit-scrollbar-track {
    background: #1F2937;
}

.dark .custom-scrollbar::-webkit-scrollbar-thumb {
    background: #4B5563;
}

.dark .custom-scrollbar::-webkit-scrollbar-thumb:hover {
    background: #6B7280;
}

/* Mobile-first colorful animations */
@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

@keyframes pulse-soft {
    0%, 100% {
        opacity: 1;
    }
    50% {
        opacity: 0.8;
    }
}

.animate-fade-in-up {
    animation: fadeInUp 0.5s ease-out;
}

/* Gradient text effect */
.gradient-text {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}

/* Mobile touch feedback */
@media (hover: none) and (pointer: coarse) {
    button:active, a:active {
        transform: scale(0.98);
        transition: transform 0.1s;
    }
}

/* Smooth transitions for all interactive elements */
* {
    -webkit-tap-highlight-color: transparent;
}

/* Loading overlay animation */
@keyframes spin {
    to {
        transform: rotate(360deg);
    }
}

#loading-overlay {
    backdrop-filter: blur(4px);
}
</style>
@endpush 
