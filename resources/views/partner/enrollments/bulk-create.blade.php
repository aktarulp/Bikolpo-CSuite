@extends('layouts.partner-layout')

@section('title', 'Bulk Enrollment')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-emerald-50 via-teal-50 to-cyan-50 dark:from-gray-900 dark:via-emerald-900 dark:to-teal-900 -m-6 p-4 sm:p-6 lg:p-8">
    <div class="max-w-6xl mx-auto space-y-6">
        
        <!-- Header with Back Button -->
        <div class="flex flex-col sm:flex-row items-start sm:items-center gap-4">
            <a href="{{ route('partner.enrollments.index') }}" 
               class="inline-flex items-center gap-2 px-4 py-2.5 bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700 text-gray-700 dark:text-gray-300 rounded-xl font-semibold shadow-md hover:shadow-lg transition-all duration-200 border border-gray-200 dark:border-gray-700">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                <span class="text-sm">Back</span>
            </a>
            
            <div class="flex-1">
                <h1 class="text-2xl sm:text-3xl lg:text-4xl font-black bg-gradient-to-r from-emerald-600 via-teal-600 to-cyan-600 bg-clip-text text-transparent flex items-center gap-3">
                    <svg class="w-8 h-8 sm:w-10 sm:h-10 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path>
                    </svg>
                    Bulk Enrollment
                </h1>
                <p class="text-sm sm:text-base text-gray-600 dark:text-gray-400 mt-1">Enroll multiple students in a course at once</p>
            </div>
        </div>

        <!-- Main Form Card -->
        <div class="bg-white dark:bg-gray-800 rounded-3xl shadow-2xl overflow-hidden border border-gray-200 dark:border-gray-700" 
             x-data="bulkEnrollmentData()">
            
            <!-- Form Header -->
            <div class="bg-gradient-to-r from-emerald-500 via-teal-500 to-cyan-500 px-6 py-5 relative overflow-hidden">
                <!-- Animated Background Pattern -->
                <div class="absolute inset-0 opacity-10">
                    <div class="absolute top-0 left-0 w-32 h-32 bg-white rounded-full -translate-x-1/2 -translate-y-1/2"></div>
                    <div class="absolute bottom-0 right-0 w-40 h-40 bg-white rounded-full translate-x-1/3 translate-y-1/3"></div>
                    <div class="absolute top-1/2 left-1/2 w-24 h-24 bg-white rounded-full -translate-x-1/2 -translate-y-1/2"></div>
                </div>
                
                <div class="relative z-10 flex items-center gap-4">
                    <div class="w-12 h-12 sm:w-14 sm:h-14 bg-white/20 backdrop-blur-md rounded-xl flex items-center justify-center shadow-lg">
                        <svg class="w-6 h-6 sm:w-7 sm:h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path>
                        </svg>
                    </div>
                    <div>
                        <h2 class="text-xl sm:text-2xl font-bold text-white">Bulk Enrollment Details</h2>
                        <p class="text-sm text-white/90 mt-0.5">Select students and assign them to a course</p>
                    </div>
                </div>
            </div>

            <!-- Form Body -->
            <form method="POST" action="{{ route('partner.enrollments.bulk-store') }}" class="p-6 sm:p-8 space-y-6">
                @csrf

                <!-- Course Selection -->
                <div class="space-y-3">
                    <label for="course_id" class="flex items-center gap-2 text-sm font-bold text-gray-700 dark:text-gray-300">
                        <svg class="w-5 h-5 text-orange-500 dark:text-orange-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                        </svg>
                        <span>Select Course</span>
                        <span class="text-red-500">*</span>
                    </label>
                    
                    <div class="relative">
                        <select name="course_id" 
                                id="course_id" 
                                required
                                x-model="selectedCourse"
                                @change="updateBatchDropdown()"
                                class="w-full px-4 py-3.5 pl-12 bg-gradient-to-r from-orange-50 to-amber-50 dark:from-orange-900/20 dark:to-amber-900/20 border-2 border-orange-200 dark:border-orange-700 rounded-xl focus:ring-4 focus:ring-orange-500/20 focus:border-orange-500 dark:focus:border-orange-400 transition-all duration-300 text-gray-900 dark:text-white font-medium shadow-sm hover:shadow-md appearance-none @error('course_id') border-red-500 @enderror">
                            <option value="">-- Choose a course --</option>
                            @foreach($courses as $course)
                                <option value="{{ $course->id }}">{{ $course->name }} ({{ $course->code }})</option>
                            @endforeach
                        </select>
                        
                        <!-- Icon -->
                        <div class="absolute inset-y-0 left-0 flex items-center pl-4 pointer-events-none">
                            <svg class="w-5 h-5 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                            </svg>
                        </div>
                        
                        <!-- Dropdown Arrow -->
                        <div class="absolute inset-y-0 right-0 flex items-center pr-4 pointer-events-none">
                            <svg class="w-5 h-5 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </div>
                    </div>
                    
                    @error('course_id')
                        <div class="flex items-center gap-2 text-red-600 dark:text-red-400 text-sm font-medium bg-red-50 dark:bg-red-900/20 px-4 py-2 rounded-lg">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <span>{{ $message }}</span>
                        </div>
                    @enderror
                </div>

                <!-- Batch Selection (Child - Cascading) -->
                <div class="space-y-3">
                    <label for="batch_id" class="flex items-center gap-2 text-sm font-bold text-gray-700 dark:text-gray-300">
                        <svg class="w-5 h-5 text-purple-500 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                        </svg>
                        <span>Select Batch</span>
                        <span class="text-red-500">*</span>
                    </label>
                    
                    <div class="relative">
                        <select name="batch_id" 
                                id="batch_id"
                                x-model="selectedBatch"
                                required
                                :disabled="!selectedCourse"
                                class="w-full px-4 py-3.5 pl-12 bg-gray-50 dark:bg-gray-700 border-2 border-gray-200 dark:border-gray-600 rounded-xl focus:ring-4 focus:ring-purple-500/20 focus:border-purple-500 dark:focus:border-purple-400 transition-all duration-300 text-gray-900 dark:text-white font-medium shadow-sm hover:shadow-md appearance-none disabled:opacity-50 disabled:cursor-not-allowed @error('batch_id') border-red-500 @enderror">
                            <option value="">-- Select batch --</option>
                            <template x-for="batch in courseBatches" :key="batch.id">
                                <option :value="batch.id" x-text="`${batch.name} (${batch.year})`"></option>
                            </template>
                        </select>
                        
                        <!-- Icon -->
                        <div class="absolute inset-y-0 left-0 flex items-center pl-4 pointer-events-none">
                            <svg class="w-5 h-5 text-gray-400" :class="{ 'text-purple-500': selectedCourse }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                            </svg>
                        </div>
                        
                        <!-- Dropdown Arrow -->
                        <div class="absolute inset-y-0 right-0 flex items-center pr-4 pointer-events-none">
                            <svg class="w-5 h-5 text-gray-500" :class="{ 'text-purple-500': selectedCourse }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </div>
                    </div>
                    
                    <!-- Helper Text -->
                    <div x-show="!selectedCourse" 
                         class="flex items-center gap-2 text-amber-700 dark:text-amber-400 text-xs font-medium bg-amber-50 dark:bg-amber-900/20 px-4 py-2 rounded-lg">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                        </svg>
                        <span>Please select a course first to see available batches</span>
                    </div>
                    
                    <div x-show="selectedCourse && courseBatches.length === 0" 
                         class="flex items-center gap-2 text-blue-700 dark:text-blue-400 text-xs font-medium bg-blue-50 dark:bg-blue-900/20 px-4 py-2 rounded-lg">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <span>No batches available for this course</span>
                    </div>
                    
                    @error('batch_id')
                        <div class="flex items-center gap-2 text-red-600 dark:text-red-400 text-sm font-medium bg-red-50 dark:bg-red-900/20 px-4 py-2 rounded-lg">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <span>{{ $message }}</span>
                        </div>
                    @enderror
                </div>

                <!-- Date & Remarks -->
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    <!-- Enrollment Date -->
                    <div class="space-y-3">
                        <label for="enrolled_at" class="flex items-center gap-2 text-sm font-bold text-gray-700 dark:text-gray-300">
                            <svg class="w-5 h-5 text-blue-500 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                            <span>Enrollment Date</span>
                            <span class="text-red-500">*</span>
                        </label>
                        
                        <div class="relative">
                            <input type="date" 
                                   name="enrolled_at" 
                                   id="enrolled_at" 
                                   required
                                   value="{{ old('enrolled_at', date('Y-m-d')) }}"
                                   class="w-full px-4 py-3.5 pl-12 bg-gray-50 dark:bg-gray-700 border-2 border-gray-200 dark:border-gray-600 rounded-xl focus:ring-4 focus:ring-blue-500/20 focus:border-blue-500 dark:focus:border-blue-400 transition-all duration-300 text-gray-900 dark:text-white font-medium shadow-sm hover:shadow-md @error('enrolled_at') border-red-500 @enderror">
                            
                            <!-- Icon -->
                            <div class="absolute inset-y-0 left-0 flex items-center pl-4 pointer-events-none">
                                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                            </div>
                        </div>
                        
                        @error('enrolled_at')
                            <div class="flex items-center gap-2 text-red-600 dark:text-red-400 text-sm font-medium bg-red-50 dark:bg-red-900/20 px-4 py-2 rounded-lg">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <span>{{ $message }}</span>
                            </div>
                        @enderror
                    </div>

                    <!-- Remarks -->
                    <div class="space-y-3">
                        <label for="remarks" class="flex items-center gap-2 text-sm font-bold text-gray-700 dark:text-gray-300">
                            <svg class="w-5 h-5 text-gray-500 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"></path>
                            </svg>
                            <span>Remarks</span>
                            <span class="text-xs text-gray-500 dark:text-gray-400 font-normal">(Optional)</span>
                        </label>
                        
                        <textarea name="remarks" 
                                  id="remarks" 
                                  rows="3"
                                  placeholder="Add any notes, comments, or special instructions for these enrollments..."
                                  class="w-full px-4 py-3.5 bg-gray-50 dark:bg-gray-700 border-2 border-gray-200 dark:border-gray-600 rounded-xl focus:ring-4 focus:ring-gray-500/20 focus:border-gray-500 dark:focus:border-gray-400 transition-all duration-300 text-gray-900 dark:text-white placeholder-gray-400 dark:placeholder-gray-500 font-medium shadow-sm hover:shadow-md resize-none">{{ old('remarks') }}</textarea>
                    </div>
                </div>

                <!-- Student Selection -->
                <div class="space-y-4">
                    <div class="flex flex-col sm:flex-row sm:items-center gap-4">
                        <h3 class="flex items-center gap-2 text-lg font-bold text-gray-900 dark:text-white">
                            <svg class="w-5 h-5 text-emerald-500 dark:text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                            </svg>
                            Select Students
                            <span class="text-red-500">*</span>
                        </h3>
                        
                        <div class="flex flex-wrap gap-2">
                            <button type="button" 
                                    @click="selectAll()"
                                    class="inline-flex items-center gap-2 px-3 py-1.5 text-xs font-semibold bg-emerald-100 hover:bg-emerald-200 text-emerald-800 rounded-lg transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                Select All
                            </button>
                            <button type="button" 
                                    @click="deselectAll()"
                                    class="inline-flex items-center gap-2 px-3 py-1.5 text-xs font-semibold bg-gray-100 hover:bg-gray-200 text-gray-800 rounded-lg transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                                Deselect All
                            </button>
                        </div>
                    </div>
                    
                    <!-- Student Search -->
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 flex items-center pl-4 pointer-events-none">
                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                        </div>
                        <input type="text" 
                               x-model="search"
                               placeholder="Search students by name or ID..." 
                               class="w-full pl-12 pr-4 py-3 bg-gray-50 dark:bg-gray-700 border-2 border-gray-200 dark:border-gray-600 rounded-xl focus:ring-4 focus:ring-emerald-500/20 focus:border-emerald-500 dark:focus:border-emerald-400 transition-all duration-300 text-gray-900 dark:text-white placeholder-gray-400 dark:placeholder-gray-500 font-medium shadow-sm hover:shadow-md">
                    </div>
                    
                    <!-- Student Grid -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 max-h-[500px] overflow-y-auto p-2 custom-scrollbar">
                        <template x-for="student in filteredStudents" :key="student.id">
                            <div 
                                @click="toggleStudent(student.id)"
                                :class="{
                                    'ring-4 ring-emerald-500 bg-emerald-50 dark:bg-emerald-900/20 border-emerald-300 dark:border-emerald-700': isStudentSelected(student.id),
                                    'bg-white dark:bg-gray-700 border-gray-200 dark:border-gray-600': !isStudentSelected(student.id),
                                    'border-l-4 border-l-amber-500': isEnrolled(student.id, selectedCourse)
                                }"
                                class="relative p-4 rounded-xl border-2 cursor-pointer transition-all duration-200 hover:shadow-md group">
                                
                                <!-- Enrollment Status Badge -->
                                <div x-show="isEnrolled(student.id, selectedCourse)" class="absolute top-2 right-2">
                                    <span class="inline-flex items-center px-2 py-1 text-xs font-bold rounded-full bg-amber-100 text-amber-800 dark:bg-amber-900/30 dark:text-amber-400 border border-amber-200 dark:border-amber-800">
                                        <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        Enrolled
                                    </span>
                                </div>
                                
                                <!-- Selection Indicator - Positioned at top left with proper spacing -->
                                <div class="absolute -top-2 -left-2 z-10">
                                    <div :class="{
                                        'bg-emerald-500 border-emerald-500': isStudentSelected(student.id),
                                        'bg-white border-gray-300 dark:bg-gray-600 dark:border-gray-500': !isStudentSelected(student.id)
                                    }" class="w-6 h-6 rounded-full border-2 flex items-center justify-center transition-colors shadow-md">
                                        <svg x-show="isStudentSelected(student.id)" class="w-3 h-3 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path>
                                        </svg>
                                    </div>
                                </div>
                                
                                <div class="flex items-center gap-3 pt-2">
                                    <!-- Student Initial Circle -->
                                    <div class="w-10 h-10 bg-emerald-500 rounded-full flex items-center justify-center text-white font-bold flex-shrink-0">
                                        <span x-text="student.full_name.charAt(0)"></span>
                                    </div>
                                    <!-- Student Info -->
                                    <div class="min-w-0">
                                        <p class="font-bold text-gray-900 dark:text-white truncate" x-text="student.full_name"></p>
                                        <p class="text-sm text-gray-600 dark:text-gray-400 truncate" x-text="student.student_id || 'No ID'"></p>
                                    </div>
                                </div>
                            </div>
                        </template>
                    </div>
                    
                    <!-- Hidden input for selected students -->
                    <template x-for="studentId in selectedStudents" :key="studentId">
                        <input type="hidden" name="student_ids[]" :value="studentId">
                    </template>
                    
                    <!-- Validation Error -->
                    @error('student_ids')
                        <div class="flex items-center gap-2 text-red-600 dark:text-red-400 text-sm font-medium bg-red-50 dark:bg-red-900/20 px-4 py-2 rounded-lg">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <span>{{ $message }}</span>
                        </div>
                    @enderror
                    
                    <!-- Selection Summary -->
                    <div class="bg-gradient-to-r from-emerald-50 to-teal-50 dark:from-emerald-900/20 dark:to-teal-900/20 rounded-xl p-4 border border-emerald-200 dark:border-emerald-800">
                        <div class="flex flex-wrap items-center justify-between gap-3">
                            <div class="flex items-center gap-2">
                                <svg class="w-5 h-5 text-emerald-600 dark:text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                </svg>
                                <span class="font-bold text-gray-900 dark:text-white">
                                    <span x-text="selectedStudents.length"></span> student(s) selected
                                </span>
                            </div>
                            
                            <div x-show="selectedStudents.length === 0" class="text-sm text-amber-700 dark:text-amber-400">
                                Please select at least one student
                            </div>
                            
                            <div x-show="selectedStudents.length > 0" class="text-sm text-emerald-700 dark:text-emerald-400">
                                Ready to enroll selected students
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="flex flex-col-reverse sm:flex-row items-center gap-3 pt-6 border-t border-gray-200 dark:border-gray-700">
                    <a href="{{ route('partner.enrollments.index') }}" 
                       class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-6 py-3.5 bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-300 rounded-xl font-semibold transition-all duration-200 shadow-md hover:shadow-lg">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                        <span>Cancel</span>
                    </a>
                    
                    <button type="submit" 
                            :disabled="selectedStudents.length === 0 || !selectedCourse || !selectedBatch"
                            class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-8 py-3.5 bg-gradient-to-r from-emerald-500 via-teal-500 to-cyan-500 hover:from-emerald-600 hover:via-teal-600 hover:to-cyan-600 text-white rounded-xl font-bold transition-all duration-200 shadow-lg hover:shadow-xl transform hover:scale-105 disabled:opacity-50 disabled:cursor-not-allowed disabled:transform-none">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path>
                        </svg>
                        <span>Enroll <span x-text="selectedStudents.length"></span> Student(s)</span>
                    </button>
                </div>
            </form>
        </div>

        <!-- Info Cards -->
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <!-- Bulk Enrollment Tips -->
            <div class="bg-gradient-to-br from-blue-500 to-indigo-600 rounded-2xl p-5 shadow-lg text-white">
                <div class="flex items-start gap-3 mb-3">
                    <div class="w-10 h-10 bg-white/20 backdrop-blur-md rounded-xl flex items-center justify-center flex-shrink-0">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-base font-bold mb-1">Bulk Enrollment Tips</h3>
                        <p class="text-sm text-blue-100">Efficiently enroll multiple students</p>
                    </div>
                </div>
                <div class="space-y-1 text-sm text-blue-100">
                    <p>• Select a course first to see enrolled status</p>
                    <p>• Students already enrolled will be marked</p>
                    <p>• Use Select All/Deselect All for quick selection</p>
                </div>
            </div>

            <!-- Status Legend -->
            <div class="bg-gradient-to-br from-purple-500 to-pink-600 rounded-2xl p-5 shadow-lg text-white">
                <div class="flex items-start gap-3 mb-3">
                    <div class="w-10 h-10 bg-white/20 backdrop-blur-md rounded-xl flex items-center justify-center flex-shrink-0">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"></path>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-base font-bold mb-1">Status Legend</h3>
                        <p class="text-sm text-purple-100">Visual indicators for student status</p>
                    </div>
                </div>
                <div class="space-y-2 text-sm text-purple-100">
                    <div class="flex items-center gap-2">
                        <div class="w-4 h-4 rounded-full bg-emerald-500 border-2 border-emerald-500"></div>
                        <span>Selected for enrollment</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <div class="w-4 h-4 rounded-full bg-amber-500 border-2 border-amber-500"></div>
                        <span>Already enrolled in selected course</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function bulkEnrollmentData() {
    return {
        selectedCourse: '',
        selectedBatch: '',
        selectedStudents: [],
        search: '',
        courseBatches: [],
        
        // Initialize with data from the server
        init() {
            // Initialize with the data passed from the server
            this.students = @json($students);
            this.enrolledStudents = @json($enrolledStudents);
            this.batchesData = @json($batchesData ?? $courses->pluck('batches', 'id'));
        },
        
        // Update batch dropdown when course changes
        updateBatchDropdown() {
            this.selectedBatch = '';
            if (this.selectedCourse && this.batchesData[this.selectedCourse]) {
                // Convert the batches data to the format we need
                this.courseBatches = this.batchesData[this.selectedCourse].map(batch => {
                    return {
                        id: batch.id,
                        name: batch.name,
                        year: batch.year
                    };
                });
            } else {
                this.courseBatches = [];
            }
        },
        
        // Toggle student selection
        toggleStudent(studentId) {
            const index = this.selectedStudents.indexOf(studentId);
            if (index === -1) {
                this.selectedStudents.push(studentId);
            } else {
                this.selectedStudents.splice(index, 1);
            }
        },
        
        // Select all students (filtered by search)
        selectAll() {
            this.filteredStudents.forEach(student => {
                if (!this.isStudentSelected(student.id)) {
                    this.selectedStudents.push(student.id);
                }
            });
        },
        
        // Deselect all students
        deselectAll() {
            this.selectedStudents = [];
        },
        
        // Check if student is selected
        isStudentSelected(studentId) {
            return this.selectedStudents.includes(studentId);
        },
        
        // Check if student is already enrolled in the selected course
        isEnrolled(studentId, courseId) {
            if (!courseId) return false;
            return this.enrolledStudents[courseId] && this.enrolledStudents[courseId].includes(studentId);
        },
        
        // Get filtered students based on search term
        get filteredStudents() {
            if (this.search === '') return this.students;
            return this.students.filter(student => 
                student.full_name.toLowerCase().includes(this.search.toLowerCase()) || 
                (student.student_id && student.student_id.toLowerCase().includes(this.search.toLowerCase()))
            );
        }
    }
}
</script>

<style>
.custom-scrollbar::-webkit-scrollbar {
    width: 8px;
}

.custom-scrollbar::-webkit-scrollbar-track {
    background: #f1f1f1;
    border-radius: 4px;
}

.custom-scrollbar::-webkit-scrollbar-thumb {
    background: #c5c5c5;
    border-radius: 4px;
}

.custom-scrollbar::-webkit-scrollbar-thumb:hover {
    background: #a0a0a0;
}

.dark .custom-scrollbar::-webkit-scrollbar-track {
    background: #2d3748;
}

.dark .custom-scrollbar::-webkit-scrollbar-thumb {
    background: #4a5568;
}

.dark .custom-scrollbar::-webkit-scrollbar-thumb:hover {
    background: #718096;
}
</style>
@endsection