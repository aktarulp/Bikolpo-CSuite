@extends('layouts.partner-layout')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-50 via-white to-blue-50 dark:from-gray-900 dark:via-gray-800 dark:to-gray-900">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-4 space-y-4">
        <!-- Header Section -->
        <div class="relative overflow-hidden bg-gradient-to-r from-primaryGreen to-emerald-600 rounded-2xl shadow-xl border-0">
            <div class="absolute inset-0 bg-black/10"></div>
            <div class="relative px-6 py-6 sm:px-8 sm:py-8">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between space-y-4 sm:space-y-0">
                    <div class="space-y-2">
                        <div class="flex items-center space-x-3">
                            <div class="p-2 bg-white/20 rounded-xl backdrop-blur-sm">
                                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 5.477 5.754 5 7.5 5c1.747 0 3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.523 18.246 19 16.5 19c-1.746 0-3.332-.477-4.5-1.253"></path>
                                </svg>
                            </div>
                            <div>
                                <h1 class="text-3xl sm:text-4xl font-bold text-white drop-shadow-lg">Student Assignment</h1>
                                <p class="text-green-100 text-lg mt-2 font-medium">Manage student course and batch assignments</p>
                            </div>
                        </div>
                    </div>
                    <div class="flex items-center space-x-3">
                        <button type="button" id="bulk-assign-btn" 
                                class="group relative inline-flex items-center px-6 py-3 bg-white/20 backdrop-blur-sm text-white text-sm font-semibold rounded-xl hover:bg-white/30 focus:outline-none focus:ring-2 focus:ring-white/50 focus:ring-offset-2 focus:ring-offset-primaryGreen transition-all duration-300 transform hover:scale-105 hover:shadow-lg border border-white/30">
                            <svg class="w-5 h-5 mr-2 group-hover:rotate-12 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                            </svg>
                            Bulk Assign
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filters and Search Section -->
        <div class="bg-white/80 dark:bg-gray-800/90 backdrop-blur-sm rounded-2xl shadow-xl border border-white/20 dark:border-gray-700/50">
            <div class="px-6 py-4">
                <div class="flex items-center space-x-3 mb-4">
                    <div class="p-2 bg-primaryGreen/10 rounded-lg">
                        <svg class="w-5 h-5 text-primaryGreen" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path>
                        </svg>
                    </div>
                    <h2 class="text-xl font-semibold text-gray-900 dark:text-white">Filters & Search</h2>
                </div>
                
                <div class="flex flex-wrap items-end gap-4">
                    <!-- Search Students -->
                    <div class="space-y-2 min-w-[200px]">
                        <label for="student-search" class="block text-sm font-semibold text-gray-700 dark:text-gray-300">Search Students</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                </svg>
                            </div>
                            <input type="text" id="student-search" name="student_search" 
                                   class="w-full pl-10 pr-4 py-3 border-0 bg-gray-50 dark:bg-gray-700 rounded-xl focus:ring-2 focus:ring-primaryGreen focus:bg-white dark:focus:bg-gray-600 dark:text-white transition-all duration-200 shadow-sm"
                                   placeholder="Search by name, email, or ID">
                        </div>
                    </div>

                    <!-- Filter by Course -->
                    <div class="space-y-2 min-w-[180px]">
                        <label for="course-filter" class="block text-sm font-semibold text-gray-700 dark:text-gray-300">Filter by Course</label>
                        <select id="course-filter" name="course_filter" 
                                class="w-full px-4 py-3 border-0 bg-gray-50 dark:bg-gray-700 rounded-xl focus:ring-2 focus:ring-primaryGreen focus:bg-white dark:focus:bg-gray-600 dark:text-white transition-all duration-200 shadow-sm appearance-none cursor-pointer">
                            <option value="">All Courses</option>
                            @foreach($courses ?? [] as $course)
                                <option value="{{ $course->id }}">{{ $course->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Filter by Batch -->
                    <div class="space-y-2 min-w-[180px]">
                        <label for="batch-filter" class="block text-sm font-semibold text-gray-700 dark:text-gray-300">Filter by Batch</label>
                        <select id="batch-filter" name="batch_filter" 
                                class="w-full px-4 py-3 border-0 bg-gray-50 dark:bg-gray-700 rounded-xl focus:ring-2 focus:ring-primaryGreen focus:bg-white dark:focus:bg-gray-600 dark:text-white transition-all duration-200 shadow-sm appearance-none cursor-pointer">
                            <option value="">All Batches</option>
                            @foreach($batches ?? [] as $batch)
                                <option value="{{ $batch->id }}">{{ $batch->display_name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Filter by Assignment Status -->
                    <div class="space-y-2 min-w-[180px]">
                        <label for="status-filter" class="block text-sm font-semibold text-gray-700 dark:text-gray-300">Assignment Status</label>
                        <select id="status-filter" name="status_filter" 
                                class="w-full px-4 py-3 border-0 bg-gray-50 dark:bg-gray-700 rounded-xl focus:ring-2 focus:ring-primaryGreen focus:bg-white dark:focus:bg-gray-600 dark:text-white transition-all duration-200 shadow-sm appearance-none cursor-pointer">
                            <option value="">All Status</option>
                            <option value="assigned">Assigned</option>
                            <option value="unassigned">Unassigned</option>
                        </select>
                    </div>
                </div>
                
                <!-- Filter Summary and Clear Button -->
                <div class="mt-4 flex flex-col sm:flex-row sm:items-center sm:justify-between space-y-3 sm:space-y-0">
                    <div id="filter-summary" class="hidden text-sm text-gray-600 dark:text-gray-400 bg-gradient-to-r from-emerald-50 to-teal-50 dark:from-emerald-900/20 dark:to-teal-900/20 border border-emerald-200 dark:border-emerald-800 px-4 py-2 rounded-xl font-medium">
                        <!-- Filter summary will be populated by JavaScript -->
                    </div>
                    <button type="button" onclick="clearFilters()" 
                            class="hidden group inline-flex items-center px-4 py-2 text-sm font-medium text-red-700 dark:text-red-300 bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-xl hover:bg-red-100 dark:hover:bg-red-900/30 transition-all duration-200 hover:shadow-md hover:scale-105">
                        <svg class="w-4 h-4 mr-2 group-hover:rotate-90 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                        Clear Filters
                    </button>
                </div>
            </div>
        </div>

        <!-- Students Table -->
        <div class="bg-white/80 dark:bg-gray-800/90 backdrop-blur-sm rounded-2xl shadow-xl border border-white/20 dark:border-gray-700/50">
            <div class="px-6 py-4 border-b border-gray-100 dark:border-gray-700/50">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between space-y-3 sm:space-y-0">
                    <div class="flex items-center space-x-3">
                        <div class="p-2 bg-blue-100 dark:bg-blue-900/30 rounded-lg">
                            <svg class="w-5 h-5 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-semibold text-gray-900 dark:text-white">Students</h3>
                    </div>
                    <div class="flex items-center space-x-3">
                                                 <div id="filtered-count" class="inline-flex items-center space-x-2 bg-gradient-to-r from-blue-50 to-indigo-50 dark:from-blue-900/20 dark:to-indigo-900/20 border border-blue-200 dark:border-blue-800 px-4 py-2 rounded-xl font-medium">
                             <div class="w-2 h-2 bg-blue-500 rounded-full animate-pulse"></div>
                             <span class="text-sm text-blue-700 dark:text-blue-300 font-semibold">
                                 Showing <span class="text-blue-900 dark:text-blue-100 font-bold">{{ $students->count() }}</span> of <span class="text-blue-900 dark:text-blue-100 font-bold">{{ $students->total() }}</span> students
                                 @if($students->hasPages())
                                     <span class="text-blue-600 dark:text-blue-400">• Page {{ $students->currentPage() }}/{{ $students->lastPage() }}</span>
                                 @endif
                             </span>
                         </div>
                        <div id="loading-indicator" class="hidden">
                            <div class="p-2 bg-primaryGreen/10 rounded-lg">
                                <svg class="animate-spin h-5 w-5 text-primaryGreen" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="overflow-x-auto custom-scrollbar">
                <table class="min-w-full divide-y divide-gray-100 dark:divide-gray-700/50">
                    <thead class="bg-gradient-to-r from-gray-50 to-gray-100 dark:from-gray-700/50 dark:to-gray-800/50">
                        <tr>
                            <th class="px-4 py-3 text-left">
                                <input type="checkbox" id="select-all" class="rounded border-gray-300 text-primaryGreen focus:ring-primaryGreen shadow-sm">
                            </th>
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
                                    <span>Current Course</span>
                                </div>
                            </th>
                            <th class="px-4 py-3 text-left text-xs font-bold text-gray-700 dark:text-gray-200 uppercase tracking-wider border-b-2 border-blue-500/30">
                                <div class="flex items-center space-x-2">
                                    <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                                    </svg>
                                    <span>Current Batch</span>
                                </div>
                            </th>
                            
                            <th class="px-4 py-3 text-left text-xs font-bold text-gray-700 dark:text-gray-200 uppercase tracking-wider border-b-2 border-orange-500/30">
                                <div class="flex items-center space-x-2">
                                    <svg class="w-4 h-4 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    </svg>
                                    <span>Actions</span>
                                </div>
                            </th>
                        </tr>
                    </thead>
                                    <tbody class="bg-white/50 dark:bg-gray-800/50 divide-y divide-gray-100 dark:divide-gray-700/30">
                        @forelse($students ?? [] as $student)
                        <tr class="hover:bg-gray-50/80 dark:hover:bg-gray-700/50 student-row transition-all duration-200 group" 
                            data-student-name="{{ strtolower($student->full_name) }}"
                            data-student-email="{{ strtolower($student->email) }}"
                            data-student-id="{{ strtolower($student->student_id ?? '') }}"
                            data-batch-id="{{ $student->batch_id ?? '' }}"
                            data-course-id="{{ $student->course_id ?? '' }}"
                            data-student-db-id="{{ $student->id }}"
                            data-assignment-status="{{ $student->batch_id && $student->course_id ? 'assigned' : 'unassigned' }}">
                            <td class="px-4 py-3 whitespace-nowrap">
                                <input type="checkbox" name="selected_students[]" value="{{ $student->id }}" 
                                       class="student-checkbox rounded border-gray-300 text-primaryGreen focus:ring-primaryGreen shadow-sm">
                            </td>
                                                         <td class="px-4 py-3 whitespace-nowrap">
                                 <div class="flex items-center">
                                     <div class="flex-shrink-0 h-10 w-10">
                                         <div class="h-10 w-10 rounded-full bg-gradient-to-br from-blue-500 to-indigo-600 flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform duration-200">
                                             <span class="text-base font-bold text-white">{{ substr($student->full_name ?? 'S', 0, 1) }}</span>
                                         </div>
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
                             
                             <td class="px-4 py-3 whitespace-nowrap text-sm font-medium">
                                                                 <div class="flex items-center space-x-1">
                                     @if($student->batch_id && $student->course_id)
                                         <button type="button" onclick="editAssignment({{ $student->id }})" 
                                                 data-student-id="{{ $student->id }}"
                                                 data-debug="DB:{{ $student->id }}, Batch:{{ $student->batch_id }}, Course:{{ $student->course_id }}"
                                                 class="inline-flex items-center px-2 py-1.5 text-xs font-medium text-primaryGreen bg-primaryGreen/10 rounded-md hover:bg-primaryGreen/20 hover:text-primaryGreen/80 transition-all duration-200 hover:shadow-md">
                                             <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                 <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                             </svg>
                                             Edit
                                         </button>
                                     @else
                                         <button type="button" onclick="editAssignment({{ $student->id }})" 
                                                 data-student-id="{{ $student->id }}"
                                                 data-debug="DB:{{ $student->id }}, Batch:{{ $student->batch_id }}, Course:{{ $student->course_id }}"
                                                 class="inline-flex items-center px-2 py-1.5 text-xs font-medium text-white bg-gradient-to-r from-orange-500 to-red-500 rounded-md hover:from-orange-600 hover:to-red-600 transition-all duration-200 hover:shadow-md">
                                             <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                 <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                             </svg>
                                             Assign
                                         </button>
                                     @endif
                                     <button type="button" onclick="viewHistory({{ $student->id }})" 
                                             class="inline-flex items-center px-2 py-1.5 text-xs font-medium text-blue-600 bg-blue-100 dark:bg-blue-900/30 dark:text-blue-400 rounded-md hover:bg-blue-200 dark:hover:bg-blue-800/50 transition-all duration-200 hover:shadow-md">
                                         <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                             <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                         </svg>
                                         History
                                     </button>
                                 </div>
                            </td>
                        </tr>
                                         @empty
                     <tr>
                                                   <td colspan="6" class="px-4 py-16 text-center">
                             <div class="text-center">
                                 <div class="mx-auto w-24 h-24 bg-gradient-to-br from-gray-100 to-gray-200 dark:from-gray-700 dark:to-gray-800 rounded-full flex items-center justify-center mb-6">
                                     <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                         <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                                     </svg>
                                 </div>
                                 <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">No students found</h3>
                                 <p class="text-gray-500 dark:text-gray-400 mb-6 max-w-md mx-auto">Get started by adding some students to your institution. You can import them from a file or add them manually.</p>
                                 <button type="button" class="inline-flex items-center px-4 py-2 bg-primaryGreen text-white text-sm font-medium rounded-lg hover:bg-primaryGreen/90 transition-all duration-200 hover:shadow-lg">
                                     <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                         <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                     </svg>
                                     Add First Student
                                 </button>
                             </div>
                         </td>
                     </tr>
                     @endforelse
                 </tbody>
             </table>
         </div>

                   <!-- No Results Message -->
          <div id="no-results-message" class="hidden px-4 py-16 text-center">
             <div class="text-center">
                 <div class="mx-auto w-24 h-24 bg-gradient-to-br from-yellow-100 to-yellow-200 dark:from-yellow-900/30 dark:to-yellow-800/30 rounded-full flex items-center justify-center mb-6">
                     <svg class="w-12 h-12 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                         <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                     </svg>
                 </div>
                 <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">No students found</h3>
                 <p class="text-gray-500 dark:text-gray-400 mb-6 max-w-md mx-auto">Try adjusting your search criteria or filters to find the students you're looking for.</p>
                 <button type="button" onclick="clearFilters()" 
                         class="inline-flex items-center px-4 py-2 text-sm font-medium text-primaryGreen bg-primaryGreen/10 rounded-lg hover:bg-primaryGreen/20 transition-all duration-200 hover:shadow-md">
                     <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                         <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                     </svg>
                     Clear All Filters
                 </button>
             </div>
         </div>

                 <!-- Pagination -->
         @if(isset($students) && $students->hasPages())
         <div class="px-4 py-4 border-t border-gray-100 dark:border-gray-700/50">
             <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between space-y-3 sm:space-y-0">
                 <!-- Page Info -->
                 <div class="flex items-center space-x-3">
                     <div class="p-2 bg-blue-100 dark:bg-blue-900/30 rounded-lg">
                         <svg class="w-5 h-5 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                             <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                         </svg>
                     </div>
                     <div class="text-sm text-gray-600 dark:text-gray-400">
                         <span class="font-semibold text-blue-600 dark:text-blue-400">Page {{ $students->currentPage() }}</span> of 
                         <span class="font-semibold text-blue-600 dark:text-blue-400">{{ $students->lastPage() }}</span>
                     </div>
                 </div>
                 
                 <!-- Pagination Links -->
                 <div class="flex items-center justify-center">
                     {{ $students->links() }}
                 </div>
                 
                 <!-- Results Summary -->
                 <div class="flex items-center space-x-3">
                     <div class="p-2 bg-green-100 dark:bg-green-900/30 rounded-lg">
                         <svg class="w-5 h-5 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                             <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                         </svg>
                     </div>
                     <div class="text-sm text-gray-600 dark:text-gray-400">
                         Showing <span class="font-semibold text-green-600 dark:text-green-400">{{ $students->firstItem() ?? 0 }}</span> to 
                         <span class="font-semibold text-green-600 dark:text-green-400">{{ $students->lastItem() ?? 0 }}</span> of 
                         <span class="font-semibold text-green-600 dark:text-green-400">{{ $students->total() }}</span> results
                     </div>
                 </div>
             </div>
         </div>
         @endif
     </div>
 </div>
 </div>

 <!-- Edit Assignment Modal -->
 <div id="edit-assignment-modal" class="fixed inset-0 bg-black/50 backdrop-blur-sm overflow-y-auto h-full w-full hidden z-50">
     <div class="relative top-20 mx-auto p-0 border-0 w-full max-w-md shadow-2xl">
         <div class="relative bg-white dark:bg-gray-800 rounded-2xl overflow-hidden">
             <!-- Modal Header -->
             <div class="bg-gradient-to-r from-primaryGreen to-emerald-600 px-6 py-4">
                 <div class="flex items-center justify-between">
                     <div class="flex items-center space-x-3">
                         <div class="p-2 bg-white/20 rounded-lg backdrop-blur-sm">
                             <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                 <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                             </svg>
                         </div>
                         <h3 class="text-lg font-semibold text-white">Edit Student Assignment</h3>
                     </div>
                     <button type="button" onclick="closeEditModal()" class="text-white/80 hover:text-white transition-colors duration-200">
                         <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                             <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                         </svg>
                     </button>
                 </div>
             </div>
             
             <!-- Modal Body -->
             <div class="px-6 py-6">
                 <form id="edit-assignment-form" method="POST">
                     @csrf
                     @method('PUT')
                     
                     <!-- Hidden input for student ID -->
                     <input type="hidden" id="edit-student-id" name="student_id" value="">
                     
                     <!-- Hidden input for form action -->
                     <input type="hidden" name="_action" value="update_assignment">
                     
                     <div class="space-y-4">
                         <div>
                             <label for="edit-batch" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Batch</label>
                             <select id="edit-batch" name="batch_id" required 
                                     class="w-full px-4 py-3 border-0 bg-gray-50 dark:bg-gray-700 rounded-xl focus:ring-2 focus:ring-primaryGreen focus:bg-white dark:focus:bg-gray-600 dark:text-white transition-all duration-200 shadow-sm appearance-none cursor-pointer">
                                 <option value="">Select Batch</option>
                                 @foreach($batches ?? [] as $batch)
                                     <option value="{{ $batch->id }}">{{ $batch->display_name }}</option>
                                 @endforeach
                             </select>
                         </div>

                         <div>
                             <label for="edit-course" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Course</label>
                             <select id="edit-course" name="course_id" required 
                                     class="w-full px-4 py-3 border-0 bg-gray-50 dark:bg-gray-700 rounded-xl focus:ring-2 focus:ring-primaryGreen focus:bg-white dark:focus:bg-gray-600 dark:text-white transition-all duration-200 shadow-sm appearance-none cursor-pointer">
                                 <option value="">Select Course</option>
                                 @foreach($courses ?? [] as $course)
                                     <option value="{{ $course->id }}">{{ $course->name }}</option>
                                 @endforeach
                             </select>
                         </div>
                     </div>

                     <div class="flex justify-end space-x-3 mt-6">
                         <button type="button" onclick="closeEditModal()" 
                                 class="px-4 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 bg-gray-100 dark:bg-gray-700 rounded-lg hover:bg-gray-200 dark:hover:bg-gray-600 transition-all duration-200">
                             Cancel
                         </button>
                         <button type="submit" 
                                 class="px-4 py-2 text-sm font-medium text-white bg-primaryGreen rounded-lg hover:bg-primaryGreen/90 transition-all duration-200 hover:shadow-lg">
                             Update Assignment
                         </button>
                     </div>
                     
                     <!-- Debug info -->
                     <div class="mt-4 p-3 bg-gray-100 rounded-lg text-xs text-gray-600">
                         <strong>Debug Info:</strong><br>
                         Student ID: <span id="debug-student-id">-</span><br>
                         Current Batch: <span id="debug-batch-id">-</span><br>
                         Current Course: <span id="debug-course-id">-</span>
                     </div>
                 </form>
             </div>
         </div>
     </div>
 </div>

 <!-- Bulk Assignment Modal -->
 <div id="bulk-assignment-modal" class="fixed inset-0 bg-black/50 backdrop-blur-sm overflow-y-auto h-full w-full hidden z-50">
     <div class="relative top-20 mx-auto p-0 border-0 w-full max-w-md shadow-2xl">
         <div class="relative bg-white dark:bg-gray-800 rounded-2xl overflow-hidden">
             <!-- Modal Header -->
             <div class="bg-gradient-to-r from-purple-600 to-indigo-600 px-6 py-4">
                 <div class="flex items-center justify-between">
                     <div class="flex items-center space-x-3">
                         <div class="p-2 bg-white/20 rounded-lg backdrop-blur-sm">
                             <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                 <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                             </svg>
                         </div>
                         <h3 class="text-lg font-semibold text-white">Bulk Assignment</h3>
                     </div>
                     <button type="button" onclick="closeBulkModal()" class="text-white/80 hover:text-white transition-colors duration-200">
                         <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                             <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                         </svg>
                     </button>
                 </div>
             </div>
             
             <!-- Modal Body -->
             <div class="px-6 py-6">
                 <form id="bulk-assignment-form" method="POST" action="{{ route('partner.students.bulk-assignment') }}">
                     @csrf
                     
                     <div class="space-y-4">
                         <div>
                             <label for="bulk-batch" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Batch</label>
                             <select id="bulk-batch" name="batch_id" required 
                                     class="w-full px-4 py-3 border-0 bg-gray-50 dark:bg-gray-700 rounded-xl focus:ring-2 focus:ring-primaryGreen focus:bg-white dark:focus:bg-gray-600 dark:text-white transition-all duration-200 shadow-sm appearance-none cursor-pointer">
                                 <option value="">Select Batch</option>
                                 @foreach($batches ?? [] as $batch)
                                     <option value="{{ $batch->id }}">{{ $batch->display_name }}</option>
                                 @endforeach
                             </select>
                         </div>

                         <div>
                             <label for="bulk-course" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Course</label>
                             <select id="bulk-course" name="course_id" required 
                                     class="w-full px-4 py-3 border-0 bg-gray-50 dark:bg-gray-700 rounded-xl focus:ring-2 focus:ring-primaryGreen focus:bg-white dark:focus:bg-gray-600 dark:text-white transition-all duration-200 shadow-sm appearance-none cursor-pointer">
                                 <option value="">Select Course</option>
                                 @foreach($courses ?? [] as $course)
                                     <option value="{{ $course->id }}">{{ $course->name }}</option>
                                 @endforeach
                             </select>
                         </div>

                         <!-- Hidden input for selected student IDs -->
                         <input type="hidden" id="bulk-student-ids" name="student_ids" value="">

                         <div class="bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-xl p-4">
                             <div class="flex items-center space-x-2">
                                 <svg class="w-5 h-5 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                     <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                 </svg>
                                 <p class="text-sm text-blue-800 dark:text-blue-300 font-medium">
                                     <span id="selected-count" class="font-bold">0</span> students will be assigned
                                 </p>
                             </div>
                         </div>
                     </div>

                     <div class="flex justify-end space-x-3 mt-6">
                         <button type="button" onclick="closeBulkModal()" 
                                 class="px-4 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 bg-gray-100 dark:bg-gray-700 rounded-lg hover:bg-gray-200 dark:hover:bg-gray-600 transition-all duration-200">
                             Cancel
                         </button>
                         <button type="submit" 
                                 class="px-4 py-2 text-sm font-medium text-white bg-gradient-to-r from-purple-600 to-indigo-600 rounded-lg hover:from-purple-700 hover:to-indigo-700 transition-all duration-200 hover:shadow-lg">
                             Assign to Selected
                         </button>
                     </div>
                 </form>
             </div>
         </div>
     </div>
 </div>

@endsection

@push('styles')
<style>
    /* Custom scrollbar for webkit browsers */
    .custom-scrollbar::-webkit-scrollbar {
        width: 6px;
        height: 6px;
    }
    
    .custom-scrollbar::-webkit-scrollbar-track {
        background: #f1f5f9;
        border-radius: 3px;
    }
    
    .custom-scrollbar::-webkit-scrollbar-thumb {
        background: #cbd5e1;
        border-radius: 3px;
    }
    
    .custom-scrollbar::-webkit-scrollbar-thumb:hover {
        background: #94a3b8;
    }
    
    /* Dark mode scrollbar */
    .dark .custom-scrollbar::-webkit-scrollbar-track {
        background: #374151;
    }
    
    .dark .custom-scrollbar::-webkit-scrollbar-thumb {
        background: #6b7280;
    }
    
    .dark .custom-scrollbar::-webkit-scrollbar-thumb:hover {
        background: #9ca3af;
    }
    
    /* Smooth animations */
    .animate-fade-in {
        animation: fadeIn 0.3s ease-in-out;
    }
    
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(-10px); }
        to { opacity: 1; transform: translateY(0); }
    }
    
         /* Mobile optimizations */
     @media (max-width: 640px) {
         .mobile-stack {
             flex-direction: column;
             align-items: stretch;
         }
         
         .mobile-full {
             width: 100%;
             max-width: none;
         }
     }
     
     /* Prevent horizontal scrolling */
     .custom-scrollbar {
         overflow-x: auto;
         max-width: 100%;
     }
     
           /* Ensure table fits within container */
      table {
          min-width: 800px;
          max-width: 100%;
      }
      
      /* Responsive table adjustments */
      @media (max-width: 1024px) {
          table {
              min-width: 700px;
          }
      }
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Select all functionality
    const selectAllCheckbox = document.getElementById('select-all');
    const studentCheckboxes = document.querySelectorAll('.student-checkbox');
    
    if (selectAllCheckbox) {
        selectAllCheckbox.addEventListener('change', function() {
            studentCheckboxes.forEach(checkbox => {
                checkbox.checked = this.checked;
            });
            updateSelectedCount();
        });
    }

    // Individual checkbox change
    studentCheckboxes.forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            updateSelectedCount();
            updateSelectAllState();
        });
    });

    // Bulk assign button
    const bulkAssignBtn = document.getElementById('bulk-assign-btn');
    if (bulkAssignBtn) {
        bulkAssignBtn.addEventListener('click', function() {
            const selectedCount = getSelectedCount();
            if (selectedCount === 0) {
                alert('Please select at least one student');
                return;
            }
            openBulkModal();
        });
    }

    // Bulk assignment form submission
    const bulkAssignmentForm = document.getElementById('bulk-assignment-form');
    if (bulkAssignmentForm) {
        bulkAssignmentForm.addEventListener('submit', function(e) {
            const selectedStudentIds = getSelectedStudentIds();
            if (selectedStudentIds.length === 0) {
                e.preventDefault();
                alert('Please select at least one student');
                return;
            }
            
            // Populate hidden input with selected student IDs
            document.getElementById('bulk-student-ids').value = JSON.stringify(selectedStudentIds);
        });
    }

    // Search functionality
    const searchInput = document.getElementById('student-search');
    if (searchInput) {
        searchInput.addEventListener('input', debounce(function() {
            applyFilters();
        }, 300));
    }

    // Filter functionality
    const filters = ['batch-filter', 'course-filter', 'status-filter'];
    filters.forEach(filterId => {
        const filter = document.getElementById(filterId);
        if (filter) {
            filter.addEventListener('change', function() {
                applyFilters();
            });
        }
    });
    
    // Initialize filter summary
    updateFilterSummary();
    
    // Handle edit assignment form submission
    const editAssignmentForm = document.getElementById('edit-assignment-form');
    if (editAssignmentForm) {
        editAssignmentForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const formData = new FormData(this);
            const studentId = formData.get('student_id');
            const batchId = formData.get('batch_id');
            const courseId = formData.get('course_id');
            
            console.log('Form submitted:', { studentId, batchId, courseId });
            
            // Submit the form
            this.submit();
        });
    }
});

function updateSelectedCount() {
    const selectedCount = getSelectedCount();
    const selectedCountElement = document.getElementById('selected-count');
    if (selectedCountElement) {
        selectedCountElement.textContent = selectedCount;
    }
}

function getSelectedCount() {
    return document.querySelectorAll('.student-checkbox:checked').length;
}

function getSelectedStudentIds() {
    const selectedCheckboxes = document.querySelectorAll('.student-checkbox:checked');
    return Array.from(selectedCheckboxes).map(checkbox => checkbox.value);
}

function updateSelectAllState() {
    const selectAllCheckbox = document.getElementById('select-all');
    const studentCheckboxes = document.querySelectorAll('.student-checkbox');
    const checkedCount = getSelectedCount();
    
    if (selectAllCheckbox) {
        selectAllCheckbox.checked = checkedCount === studentCheckboxes.length;
        selectAllCheckbox.indeterminate = checkedCount > 0 && checkedCount < studentCheckboxes.length;
    }
}

function editAssignment(studentId) {
    console.log('editAssignment called with studentId:', studentId);
    
    // Populate modal with current student data
    const modal = document.getElementById('edit-assignment-modal');
    const form = document.getElementById('edit-assignment-form');
    
    // Set the student ID in the hidden input
    document.getElementById('edit-student-id').value = studentId;
    
    // Set form action to the assignment page (we'll handle the update via AJAX or redirect)
    form.action = '{{ route("partner.students.assignment") }}';
    
    // Get the student row to extract current batch and course values
    const studentRow = document.querySelector(`tr[data-student-db-id="${studentId}"]`);
    console.log('Looking for row with data-student-db-id:', studentId);
    console.log('All student rows:', document.querySelectorAll('.student-row'));
    
    if (studentRow) {
        const currentBatchId = studentRow.getAttribute('data-batch-id');
        const currentCourseId = studentRow.getAttribute('data-course-id');
        
        console.log('Student row found:', studentRow);
        console.log('Current batch ID:', currentBatchId, 'Current course ID:', currentCourseId);
        console.log('Row data attributes:', {
            'data-student-db-id': studentRow.getAttribute('data-student-db-id'),
            'data-batch-id': studentRow.getAttribute('data-batch-id'),
            'data-course-id': studentRow.getAttribute('data-course-id')
        });
        
        // Populate the batch dropdown with current value
        const batchSelect = document.getElementById('edit-batch');
        if (batchSelect) {
            batchSelect.value = currentBatchId || '';
            console.log('Batch select populated with:', currentBatchId);
        }
        
        // Populate the course dropdown with current value
        const courseSelect = document.getElementById('edit-course');
        if (courseSelect) {
            courseSelect.value = currentCourseId || '';
            console.log('Course select populated with:', currentCourseId);
        }
        
        // Update debug info
        document.getElementById('debug-student-id').textContent = studentId;
        document.getElementById('debug-batch-id').textContent = currentBatchId || 'Not assigned';
        document.getElementById('debug-course-id').textContent = currentCourseId || 'Not assigned';
    } else {
        console.error('Student row not found for ID:', studentId);
        // Try alternative selector
        const altRow = document.querySelector(`tr[data-student-id="${studentId}"]`);
        if (altRow) {
            console.log('Found row with alternative selector:', altRow);
        }
    }
    
    modal.classList.remove('hidden');
}

function closeEditModal() {
    const modal = document.getElementById('edit-assignment-modal');
    modal.classList.add('hidden');
}

function openBulkModal() {
    const modal = document.getElementById('bulk-assignment-modal');
    modal.classList.remove('hidden');
    updateSelectedCount();
}

function closeBulkModal() {
    const modal = document.getElementById('bulk-assignment-modal');
    modal.classList.add('hidden');
}

function viewHistory(studentId) {
    // Implement view history functionality
    console.log('Viewing history for student:', studentId);
}

function applyFilters() {
    const searchTerm = document.getElementById('student-search').value.toLowerCase();
    const batchFilter = document.getElementById('batch-filter').value;
    const courseFilter = document.getElementById('course-filter').value;
    const statusFilter = document.getElementById('status-filter').value;
    
    // Show loading indicator
    document.getElementById('loading-indicator').classList.remove('hidden');
    
    // Get all student rows
    const studentRows = document.querySelectorAll('.student-row');
    let visibleCount = 0;
    
    studentRows.forEach(row => {
        const studentName = row.getAttribute('data-student-name') || '';
        const studentEmail = row.getAttribute('data-student-email') || '';
        const studentId = row.getAttribute('data-student-id') || '';
        const batchId = row.getAttribute('data-batch-id') || '';
        const courseId = row.getAttribute('data-course-id') || '';
        const assignmentStatus = row.getAttribute('data-assignment-status') || '';
        
        // Check if row matches search term
        const matchesSearch = !searchTerm || 
            studentName.includes(searchTerm) || 
            studentEmail.includes(searchTerm) || 
            studentId.includes(searchTerm);
        
        // Check if row matches batch filter
        const matchesBatch = !batchFilter || batchId === batchFilter;
        
        // Check if row matches course filter
        const matchesCourse = !courseFilter || courseId === courseFilter;
        
        // Check if row matches status filter
        const matchesStatus = !statusFilter || assignmentStatus === statusFilter;
        
        // Show/hide row based on all filters
        if (matchesSearch && matchesBatch && matchesCourse && matchesStatus) {
            row.style.display = '';
            visibleCount++;
        } else {
            row.style.display = 'none';
        }
    });
    
         // Update filtered count
     const totalCount = studentRows.length;
     const currentPage = 1; // When filtering, we're always on page 1
     const totalPages = Math.ceil(visibleCount / 15); // Assuming 15 items per page
     document.getElementById('filtered-count').innerHTML = `
         <div class="w-2 h-2 bg-blue-500 rounded-full animate-pulse"></div>
         <span class="text-sm text-blue-700 dark:text-blue-300 font-semibold">
             Showing <span class="text-blue-900 dark:text-blue-100 font-bold">${visibleCount}</span> of <span class="text-blue-900 dark:text-blue-100 font-bold">${totalCount}</span> students
             <span class="text-blue-600 dark:text-blue-400">• Page ${currentPage}/${totalPages || 1}</span>
         </span>
     `;
    
    // Show/hide no results message
    const noResultsMessage = document.getElementById('no-results-message');
    if (visibleCount === 0) {
        noResultsMessage.classList.remove('hidden');
    } else {
        noResultsMessage.classList.add('hidden');
    }
    
    // Hide loading indicator
    document.getElementById('loading-indicator').classList.add('hidden');
    
    // Update select all checkbox state
    updateSelectAllState();
    
    // Update filter summary
    updateFilterSummary();
}

function clearFilters() {
    // Reset all filter inputs
    document.getElementById('student-search').value = '';
    document.getElementById('batch-filter').value = '';
    document.getElementById('course-filter').value = '';
    document.getElementById('status-filter').value = '';
    
    // Apply filters (which will show all rows)
    applyFilters();
}

function updateFilterSummary() {
     const searchTerm = document.getElementById('student-search').value;
     const batchFilter = document.getElementById('batch-filter');
     const courseFilter = document.getElementById('course-filter');
     const statusFilter = document.getElementById('status-filter');
     
     const activeFilters = [];
     
     if (searchTerm) {
         activeFilters.push(`<span class="inline-flex items-center px-2 py-1 bg-blue-100 dark:bg-blue-900/30 text-blue-800 dark:text-blue-300 text-xs font-medium rounded-lg mr-2"><svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>Search: "${searchTerm}"</span>`);
     }
     
     if (batchFilter.value) {
         activeFilters.push(`<span class="inline-flex items-center px-2 py-1 bg-blue-100 dark:bg-blue-900/30 text-blue-800 dark:text-blue-300 text-xs font-medium rounded-lg mr-2"><svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>Batch: ${batchFilter.options[batchFilter.selectedIndex].text}</span>`);
     }
     
     if (courseFilter.value) {
         activeFilters.push(`<span class="inline-flex items-center px-2 py-1 bg-green-100 dark:bg-green-900/30 text-green-800 dark:text-green-300 text-xs font-medium rounded-lg mr-2"><svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 5.477 5.754 5 7.5 5c1.747 0 3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.523 18.246 19 16.5 19c-1.746 0-3.332-.477-4.5-1.253"></path></svg>Course: ${courseFilter.options[courseFilter.selectedIndex].text}</span>`);
     }
     
     if (statusFilter.value) {
         activeFilters.push(`<span class="inline-flex items-center px-2 py-1 bg-purple-100 dark:bg-purple-900/30 text-purple-800 dark:text-purple-300 text-xs font-medium rounded-lg mr-2"><svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>Status: ${statusFilter.options[statusFilter.selectedIndex].text}</span>`);
     }
     
     const filterSummary = document.getElementById('filter-summary');
     const clearFilterBtn = document.querySelector('button[onclick="clearFilters()"]');
     
     if (activeFilters.length > 0) {
         filterSummary.innerHTML = `<div class="flex items-center space-x-2"><svg class="w-4 h-4 text-emerald-600 dark:text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path></svg><span class="font-semibold text-emerald-700 dark:text-emerald-300">Active Filters:</span></div><div class="flex flex-wrap gap-2 mt-2">${activeFilters.join('')}</div>`;
         filterSummary.classList.remove('hidden');
         if (clearFilterBtn) clearFilterBtn.classList.remove('hidden');
     } else {
         filterSummary.classList.add('hidden');
         if (clearFilterBtn) clearFilterBtn.classList.add('hidden');
     }
 }

function debounce(func, wait) {
    let timeout;
    return function executedFunction(...args) {
        const later = () => {
            clearTimeout(timeout);
            func(...args);
        };
        clearTimeout(timeout);
        timeout = setTimeout(later, wait);
    };
}
</script>
@endpush
