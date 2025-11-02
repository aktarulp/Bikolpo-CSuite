@extends('layouts.partner-layout')

@section('title', 'New Enrollment')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-emerald-50 via-teal-50 to-cyan-50 dark:from-gray-900 dark:via-emerald-900 dark:to-teal-900 -m-6 p-4 sm:p-6 lg:p-8">
    <div class="max-w-4xl mx-auto space-y-4 sm:space-y-6">
        
        <!-- Header with Back Button -->
        <div class="flex flex-col sm:flex-row items-start sm:items-center gap-3 sm:gap-4">
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
                    Enroll Student in Course
                </h1>
                <p class="text-sm sm:text-base text-gray-600 dark:text-gray-400 mt-1">Create a new course enrollment for a student</p>
            </div>
        </div>

        <!-- Main Form Card -->
        <div class="bg-white dark:bg-gray-800 rounded-3xl shadow-2xl overflow-hidden border border-gray-200 dark:border-gray-700" 
             x-data="{
                 selectedCourse: '{{ old('course_id', '') }}',
                 batches: {{ $courses->pluck('batches', 'id')->toJson() }},
                 getCourseBatches() {
                     if (!this.selectedCourse) return [];
                     return this.batches[this.selectedCourse] || [];
                 },
                 // Student autocomplete data
                 students: {{ $students->map(function($student) { return ['id' => $student->id, 'name' => $student->full_name, 'student_id' => $student->student_id]; })->toJson() }},
                 search: '',
                 selectedStudent: null,
                 isOpen: false,
                 filteredStudents() {
                     if (this.search === '') return this.students.slice(0, 10);
                     return this.students.filter(student => 
                         student.name.toLowerCase().includes(this.search.toLowerCase()) || 
                         (student.student_id && student.student_id.toLowerCase().includes(this.search.toLowerCase()))
                     ).slice(0, 10);
                 },
                 selectStudent(student) {
                     this.selectedStudent = student;
                     this.search = student.name + (student.student_id ? ' (ID: ' + student.student_id + ')' : '');
                     this.isOpen = false;
                     // Update the hidden input
                     document.getElementById('student_id').value = student.id;
                 },
                 clearSelection() {
                     this.selectedStudent = null;
                     this.search = '';
                     document.getElementById('student_id').value = '';
                 },
                 init() {
                     // If there's a pre-selected student, set it
                     @if($selectedStudent)
                         const preselected = this.students.find(s => s.id == {{ $selectedStudent->id }});
                         if (preselected) {
                             this.selectStudent(preselected);
                         }
                     @endif
                 }
             }">
            
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
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                    </div>
                    <div>
                        <h2 class="text-xl sm:text-2xl font-bold text-white">Enrollment Details</h2>
                        <p class="text-sm text-white/90 mt-0.5">Fill in the required information below</p>
                    </div>
                </div>
            </div>

            <!-- Form Body -->
            <form method="POST" action="{{ route('partner.enrollments.store') }}" class="p-6 sm:p-8 space-y-6">
                @csrf

                <!-- Student Selection -->
                <div class="space-y-3">
                    <label for="student_search" class="flex items-center gap-2 text-sm font-bold text-gray-700 dark:text-gray-300">
                        <svg class="w-5 h-5 text-emerald-500 dark:text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                        <span>Select Student</span>
                        <span class="text-red-500">*</span>
                    </label>
                    
                    <!-- Hidden input for the actual student ID -->
                    <input type="hidden" name="student_id" id="student_id" value="{{ old('student_id', $selectedStudent?->id) }}" required>
                    
                    <!-- Autocomplete search input -->
                    <div class="relative" x-data="{ isFocused: false }">
                        <div class="relative">
                            <input 
                                type="text" 
                                id="student_search"
                                x-model="search"
                                @focus="isOpen = true; isFocused = true"
                                @blur="setTimeout(() => { isOpen = false; isFocused = false; }, 200)"
                                @keydown.arrow-down.prevent="isOpen = true"
                                @keydown.arrow-up.prevent="isOpen = true"
                                @keydown.enter.prevent="if(filteredStudents().length > 0) selectStudent(filteredStudents()[0])"
                                placeholder="Search for a student by name or ID..."
                                class="w-full px-4 py-3.5 pl-12 bg-gray-50 dark:bg-gray-700 border-2 border-gray-200 dark:border-gray-600 rounded-xl focus:ring-4 focus:ring-emerald-500/20 focus:border-emerald-500 dark:focus:border-emerald-400 transition-all duration-300 text-gray-900 dark:text-white font-medium shadow-sm hover:shadow-md @error('student_id') border-red-500 @enderror"
                                autocomplete="off"
                            >
                            
                            <!-- Clear button -->
                            <button 
                                type="button"
                                @click="clearSelection()"
                                x-show="selectedStudent || search"
                                class="absolute inset-y-0 right-0 flex items-center pr-4 text-gray-400 hover:text-gray-600 dark:hover:text-gray-300"
                            >
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                            </button>
                            
                            <!-- Search icon -->
                            <div class="absolute inset-y-0 left-0 flex items-center pl-4 pointer-events-none">
                                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                </svg>
                            </div>
                        </div>
                        
                        <!-- Dropdown results -->
                        <div 
                            x-show="isOpen && filteredStudents().length > 0"
                            class="absolute z-10 mt-1 w-full bg-white dark:bg-gray-800 rounded-xl shadow-lg border border-gray-200 dark:border-gray-700 max-h-60 overflow-y-auto"
                            x-transition:enter="transition ease-out duration-100"
                            x-transition:enter-start="transform opacity-0 scale-95"
                            x-transition:enter-end="transform opacity-100 scale-100"
                            x-transition:leave="transition ease-in duration-75"
                            x-transition:leave-start="transform opacity-100 scale-100"
                            x-transition:leave-end="transform opacity-0 scale-95"
                        >
                            <template x-for="student in filteredStudents()" :key="student.id">
                                <div 
                                    @click="selectStudent(student)"
                                    class="px-4 py-3 hover:bg-emerald-50 dark:hover:bg-emerald-900/20 cursor-pointer flex items-center gap-3"
                                >
                                    <div class="w-8 h-8 bg-emerald-500 rounded-full flex items-center justify-center text-white font-bold text-sm">
                                        <span x-text="student.name.charAt(0)"></span>
                                    </div>
                                    <div>
                                        <div class="font-medium text-gray-900 dark:text-white" x-text="student.name"></div>
                                        <div class="text-sm text-gray-500 dark:text-gray-400" x-text="student.student_id ? 'ID: ' + student.student_id : ''"></div>
                                    </div>
                                </div>
                            </template>
                        </div>
                        
                        <!-- No results message -->
                        <div 
                            x-show="isOpen && search && filteredStudents().length === 0"
                            class="absolute z-10 mt-1 w-full bg-white dark:bg-gray-800 rounded-xl shadow-lg border border-gray-200 dark:border-gray-700 py-4 px-4"
                        >
                            <div class="text-center text-gray-500 dark:text-gray-400">
                                <svg class="w-12 h-12 mx-auto text-gray-300 dark:text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <p class="mt-2">No students found</p>
                                <p class="text-sm">Try a different search term</p>
                            </div>
                        </div>
                    </div>
                    
                    @error('student_id')
                        <div class="flex items-center gap-2 text-red-600 dark:text-red-400 text-sm font-medium bg-red-50 dark:bg-red-900/20 px-4 py-2 rounded-lg">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <span>{{ $message }}</span>
                        </div>
                    @enderror
                    
                    <!-- Selected student preview -->
                    <div x-show="selectedStudent" class="flex items-center gap-3 p-4 bg-gradient-to-r from-emerald-50 to-teal-50 dark:from-emerald-900/20 dark:to-teal-900/20 rounded-xl border border-emerald-200 dark:border-emerald-800">
                        <div class="w-10 h-10 bg-emerald-500 rounded-full flex items-center justify-center text-white font-bold shadow-lg">
                            <span x-text="selectedStudent.name.charAt(0)"></span>
                        </div>
                        <div>
                            <p class="text-sm font-bold text-gray-900 dark:text-white" x-text="selectedStudent.name"></p>
                            <p class="text-xs text-gray-600 dark:text-gray-400" x-text="selectedStudent.student_id ? 'ID: ' + selectedStudent.student_id : 'Student'"></p>
                        </div>
                    </div>
                </div>

                <!-- Divider -->
                <div class="border-t border-gray-200 dark:border-gray-700"></div>

                <!-- Course Selection (Parent) -->
                <div class="space-y-3">
                    <label for="course_id" class="flex items-center gap-2 text-sm font-bold text-gray-700 dark:text-gray-300">
                        <svg class="w-5 h-5 text-orange-500 dark:text-orange-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                        </svg>
                        <span>Select Course</span>
                        <span class="text-red-500">*</span>
                        <span class="text-xs text-gray-500 dark:text-gray-400 font-normal">(Parent)</span>
                    </label>
                    
                    <div class="relative">
                        <select name="course_id" 
                                id="course_id" 
                                required
                                x-model="selectedCourse"
                                @change="$refs.batch_select.value = ''"
                                class="w-full px-4 py-3.5 pl-12 bg-gradient-to-r from-orange-50 to-amber-50 dark:from-orange-900/20 dark:to-amber-900/20 border-2 border-orange-200 dark:border-orange-700 rounded-xl focus:ring-4 focus:ring-orange-500/20 focus:border-orange-500 dark:focus:border-orange-400 transition-all duration-300 text-gray-900 dark:text-white font-medium shadow-sm hover:shadow-md appearance-none @error('course_id') border-red-500 @enderror">
                            <option value="">-- Choose a course first --</option>
                            @foreach($courses as $course)
                                <option value="{{ $course->id }}" {{ old('course_id') == $course->id ? 'selected' : '' }}>
                                    {{ $course->name }} ({{ $course->code }})
                                </option>
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
                    
                    <p class="text-xs text-gray-500 dark:text-gray-400 italic flex items-center gap-1.5">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Select the course first, then choose a batch below
                    </p>
                </div>

                <!-- Batch Selection (Child - Cascading) -->
                <div class="space-y-3">
                    <label for="batch_id" class="flex items-center gap-2 text-sm font-bold text-gray-700 dark:text-gray-300">
                        <svg class="w-5 h-5 text-purple-500 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                        </svg>
                        <span>Select Batch</span>
                        <span class="text-xs text-gray-500 dark:text-gray-400 font-normal">(Optional - Child of Course)</span>
                    </label>
                    
                    <div class="relative">
                        <select name="batch_id" 
                                id="batch_id"
                                x-ref="batch_select"
                                :disabled="!selectedCourse"
                                class="w-full px-4 py-3.5 pl-12 bg-gray-50 dark:bg-gray-700 border-2 border-gray-200 dark:border-gray-600 rounded-xl focus:ring-4 focus:ring-purple-500/20 focus:border-purple-500 dark:focus:border-purple-400 transition-all duration-300 text-gray-900 dark:text-white font-medium shadow-sm hover:shadow-md appearance-none disabled:opacity-50 disabled:cursor-not-allowed">
                            <option value="">-- Select batch (optional) --</option>
                            <template x-for="batch in getCourseBatches()" :key="batch.id">
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
                    
                    <div x-show="selectedCourse && getCourseBatches().length === 0" 
                         class="flex items-center gap-2 text-blue-700 dark:text-blue-400 text-xs font-medium bg-blue-50 dark:bg-blue-900/20 px-4 py-2 rounded-lg">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <span>No batches available for this course</span>
                    </div>
                    
                    <p class="text-xs text-gray-500 dark:text-gray-400 italic flex items-center gap-1.5">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"></path>
                        </svg>
                        Batches are filtered based on the selected course
                    </p>
                </div>

                <!-- Divider -->
                <div class="border-t border-gray-200 dark:border-gray-700"></div>

                <!-- Date & Status Row -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    
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

                    <!-- Status (Auto-set to Active) -->
                    <div class="space-y-3">
                        <label class="flex items-center gap-2 text-sm font-bold text-gray-700 dark:text-gray-300">
                            <svg class="w-5 h-5 text-green-500 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <span>Status</span>
                        </label>
                        
                        <div class="flex items-center h-[50px] px-4 bg-gradient-to-r from-green-50 to-emerald-50 dark:from-green-900/20 dark:to-emerald-900/20 border-2 border-green-200 dark:border-green-700 rounded-xl">
                            <div class="flex items-center gap-3">
                                <div class="w-3 h-3 bg-green-500 rounded-full animate-pulse"></div>
                                <span class="text-sm font-bold text-gray-900 dark:text-white">Active (Default)</span>
                            </div>
                        </div>
                        <input type="hidden" name="status" value="active">
                    </div>
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
                              rows="4"
                              placeholder="Add any notes, comments, or special instructions for this enrollment..."
                              class="w-full px-4 py-3.5 bg-gray-50 dark:bg-gray-700 border-2 border-gray-200 dark:border-gray-600 rounded-xl focus:ring-4 focus:ring-gray-500/20 focus:border-gray-500 dark:focus:border-gray-400 transition-all duration-300 text-gray-900 dark:text-white placeholder-gray-400 dark:placeholder-gray-500 font-medium shadow-sm hover:shadow-md resize-none">{{ old('remarks') }}</textarea>
                    
                    <p class="text-xs text-gray-500 dark:text-gray-400 italic">Optional notes about this enrollment</p>
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
                            class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-8 py-3.5 bg-gradient-to-r from-emerald-500 via-teal-500 to-cyan-500 hover:from-emerald-600 hover:via-teal-600 hover:to-cyan-600 text-white rounded-xl font-bold transition-all duration-200 shadow-lg hover:shadow-xl transform hover:scale-105">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path>
                        </svg>
                        <span>Enroll Student</span>
                    </button>
                </div>
            </form>
        </div>

        <!-- Info Cards -->
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <!-- Hierarchy Info -->
            <div class="bg-gradient-to-br from-blue-500 to-indigo-600 rounded-2xl p-5 shadow-lg text-white">
                <div class="flex items-start gap-3 mb-3">
                    <div class="w-10 h-10 bg-white/20 backdrop-blur-md rounded-xl flex items-center justify-center flex-shrink-0">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-base font-bold mb-1">Enrollment Hierarchy</h3>
                        <p class="text-sm text-blue-100">Course → Batch → Student</p>
                    </div>
                </div>
                <div class="space-y-1 text-sm text-blue-100">
                    <p>• Select course first</p>
                    <p>• Then choose a batch (optional)</p>
                    <p>• Batches are course-specific</p>
                </div>
            </div>

            <!-- Quick Tip -->
            <div class="bg-gradient-to-br from-purple-500 to-pink-600 rounded-2xl p-5 shadow-lg text-white">
                <div class="flex items-start gap-3 mb-3">
                    <div class="w-10 h-10 bg-white/20 backdrop-blur-md rounded-xl flex items-center justify-center flex-shrink-0">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"></path>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-base font-bold mb-1">Quick Tip</h3>
                        <p class="text-sm text-purple-100">Students can be enrolled in multiple courses</p>
                    </div>
                </div>
                <div class="space-y-1 text-sm text-purple-100">
                    <p>• Track each enrollment separately</p>
                    <p>• View history anytime</p>
                    <p>• Update status as needed</p>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection