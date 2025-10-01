@extends('layouts.partner-layout')

@section('title', 'Edit Student')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-slate-50 via-blue-50 to-indigo-50 dark:from-gray-900 dark:via-gray-800 dark:to-gray-900 py-4 sm:py-6 lg:py-8">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Professional Header Section -->
        <div class="mb-6 sm:mb-8 lg:mb-10">
            <!-- Breadcrumb Navigation -->
            <nav class="flex items-center space-x-2 text-sm text-gray-600 dark:text-gray-400 mb-4 sm:mb-6" aria-label="Breadcrumb">
                <a href="{{ route('partner.dashboard') }}" class="hover:text-blue-600 dark:hover:text-blue-400 transition-colors duration-200">Dashboard</a>
                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                </svg>
                <a href="{{ route('partner.students.index') }}" class="hover:text-blue-600 dark:hover:text-blue-400 transition-colors duration-200">Students</a>
                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                </svg>
                <span class="text-gray-900 dark:text-gray-100 font-medium">Edit Student</span>
            </nav>
            
            <!-- Main Header -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg border border-gray-200 dark:border-gray-700 p-6 sm:p-8 lg:p-10">
                <div class="flex flex-col lg:flex-row lg:justify-between lg:items-center gap-6">
                    <div class="flex-1">
                        <div class="flex items-center gap-4 mb-4">
                            <div class="w-12 h-12 sm:w-14 sm:h-14 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-xl flex items-center justify-center shadow-lg overflow-hidden">
                                @if($student->photo)
                                    <img src="{{ Storage::url($student->photo) }}" alt="{{ $student->full_name }}" class="w-full h-full object-cover">
                                @else
                                    <svg class="w-6 h-6 sm:w-7 sm:h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                    </svg>
                                @endif
                            </div>
                            <div>
                                <h1 class="text-2xl sm:text-3xl lg:text-4xl font-bold bg-gradient-to-r from-blue-600 via-indigo-600 to-purple-600 bg-clip-text text-transparent dark:from-blue-400 dark:via-indigo-400 dark:to-purple-400">
                                    Edit {{ $student->full_name }}
                                </h1>
                            </div>
                        </div>
                        
                        <!-- Student Quick Info -->
                        <div class="flex flex-wrap gap-3 sm:gap-4 mt-4">
                            <div class="flex items-center gap-2 px-3 py-1.5 bg-blue-50 dark:bg-blue-900/20 rounded-lg border border-blue-200 dark:border-blue-800">
                                <svg class="w-4 h-4 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2"></path>
                                </svg>
                                <span class="text-sm font-medium text-blue-700 dark:text-blue-300">ID: {{ $student->student_id }}</span>
                            </div>
                            <div class="flex items-center gap-2 px-3 py-1.5 bg-green-50 dark:bg-green-900/20 rounded-lg border border-green-200 dark:border-green-800">
                                <svg class="w-4 h-4 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <span class="text-sm font-medium text-green-700 dark:text-green-300">Joined: {{ $student->enroll_date?->format('M j, Y') }}</span>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Action Buttons -->
                    <div class="flex flex-col sm:flex-row gap-3 lg:ml-6">
                        <a href="{{ route('partner.students.index') }}" 
                           class="inline-flex items-center justify-center px-4 py-2.5 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-xl shadow-sm hover:shadow-md transition-all duration-200 text-sm font-semibold text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-600 min-h-[48px] touch-manipulation group">
                            <svg class="w-4 h-4 mr-2 text-gray-500 group-hover:text-gray-700 dark:text-gray-400 dark:group-hover:text-gray-200 transition-colors duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                            </svg>
                            Back to Students
                        </a>
                        <button type="submit" form="student-form" 
                                class="inline-flex items-center justify-center px-6 py-2.5 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white rounded-xl shadow-lg hover:shadow-xl transition-all duration-200 text-sm font-semibold min-h-[48px] touch-manipulation group transform hover:scale-105">
                            <svg class="w-4 h-4 mr-2 group-hover:rotate-12 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path>
                            </svg>
                            Update Student
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Form Container -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl border border-gray-200 dark:border-gray-700 overflow-hidden">
    <form id="student-form" action="{{ route('partner.students.update', $student) }}" method="POST" enctype="multipart/form-data" class="space-y-8">
        @csrf
        @method('PUT')
        
        <!-- Basic Information Section -->
        <div class="border-b border-gray-200 dark:border-gray-700">
            <!-- Section Header -->
            <div class="w-full px-8 sm:px-10 py-6 sm:py-8 bg-gradient-to-r from-blue-50 to-indigo-50 dark:from-blue-900/20 dark:to-indigo-900/20 flex items-center justify-between">
                <div class="flex items-center gap-4">
                    <div class="w-10 h-10 sm:w-12 sm:h-12 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-xl flex items-center justify-center shadow-lg">
                        <svg class="w-5 h-5 sm:w-6 sm:h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                    </div>
                    <div class="text-left">
                        <h2 class="text-lg sm:text-xl font-bold text-gray-900 dark:text-white">
                            Basic Information
                        </h2>
                        <p class="text-sm text-gray-600 dark:text-gray-400 mt-0.5">
                            Essential student details and enrollment information
                        </p>
                    </div>
                </div>
                <!-- Status Field -->
                <div class="relative min-w-[200px]">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <select name="status" required 
                            class="w-full pl-10 pr-4 py-3 text-sm border-2 border-gray-300 dark:border-gray-600 rounded-xl bg-white dark:bg-gray-700 focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 transition-all duration-200 appearance-none min-h-[52px] touch-manipulation">
                        <option value="">Select Status</option>
                        <option value="active" {{ old('status', $student->status) == 'active' ? 'selected' : '' }}>🟢 Active</option>
                        <option value="inactive" {{ old('status', $student->status) == 'inactive' ? 'selected' : '' }}>⚪ Inactive</option>
                        <option value="suspended" {{ old('status', $student->status) == 'suspended' ? 'selected' : '' }}>🟡 Suspended</option>
                        <option value="graduated" {{ old('status', $student->status) == 'graduated' ? 'selected' : '' }}>🎓 Graduated</option>
                    </select>
                    <div class="absolute inset-y-0 right-0 flex items-center px-2 pointer-events-none">
                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </div>
                    <label class="absolute -top-2.5 left-10 px-2 bg-gradient-to-r from-blue-50 to-indigo-50 dark:from-blue-900/20 dark:to-indigo-900/20 text-xs font-semibold text-blue-700 dark:text-blue-400">
                        Status *
                    </label>
                    @error('status')
                        <p class="text-red-500 text-xs mt-2 flex items-center gap-1">
                            <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                            </svg>
                            {{ $message }}
                        </p>
                    @enderror
                </div>
            </div>
            
            <!-- Section Content -->
            <div id="basic-info" class="px-6 sm:px-8 py-6 sm:py-8">
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-6">
                    <!-- Full Name with Icon -->
                    <div class="sm:col-span-2 lg:col-span-1 relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                        </div>
                        <input type="text" name="full_name" value="{{ old('full_name', $student->full_name) }}" required
                               class="w-full pl-10 pr-4 py-3 text-sm border-2 border-gray-300 dark:border-gray-600 rounded-xl bg-white dark:bg-gray-700 focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 transition-all duration-200 min-h-[52px] touch-manipulation"
                               placeholder="Full Name">
                        <label class="absolute -top-2.5 left-10 px-2 bg-white dark:bg-gray-800 text-xs font-semibold text-gray-600 dark:text-gray-400">
                            Full Name *
                        </label>
                        @error('full_name')
                            <p class="text-red-500 text-xs mt-2 flex items-center gap-1">
                                <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                </svg>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <!-- Student ID with Icon -->
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2"></path>
                            </svg>
                        </div>
                        <input type="text" name="student_id" value="{{ old('student_id', $student->student_id) }}" required
                               class="w-full pl-10 pr-4 py-3 text-sm border-2 border-gray-300 dark:border-gray-600 rounded-xl bg-white dark:bg-gray-700 focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 transition-all duration-200 min-h-[52px] touch-manipulation"
                               placeholder="Student ID">
                        <label class="absolute -top-2.5 left-10 px-2 bg-white dark:bg-gray-800 text-xs font-semibold text-gray-600 dark:text-gray-400">
                            Student ID *
                        </label>
                        @error('student_id')
                            <p class="text-red-500 text-xs mt-2 flex items-center gap-1">
                                <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                </svg>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <!-- Date of Birth with Icon -->
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                        <input type="date" name="date_of_birth" value="{{ old('date_of_birth', $student->date_of_birth?->format('Y-m-d')) }}" required
                               class="w-full pl-10 pr-4 py-3 text-sm border-2 border-gray-300 dark:border-gray-600 rounded-xl bg-white dark:bg-gray-700 focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 transition-all duration-200 min-h-[52px] touch-manipulation">
                        <label class="absolute -top-2.5 left-10 px-2 bg-white dark:bg-gray-800 text-xs font-semibold text-gray-600 dark:text-gray-400">
                            Date of Birth *
                        </label>
                        @error('date_of_birth')
                            <p class="text-red-500 text-xs mt-2 flex items-center gap-1">
                                <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                </svg>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <!-- Gender with Icon -->
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                        </div>
                        <select name="gender" required 
                                class="w-full pl-10 pr-10 py-3 text-sm border-2 border-gray-300 dark:border-gray-600 rounded-xl bg-white dark:bg-gray-700 focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 transition-all duration-200 appearance-none min-h-[52px] touch-manipulation">
                            <option value="">Select Gender</option>
                            <option value="male" {{ old('gender', $student->gender) == 'male' ? 'selected' : '' }}>👨 Male</option>
                            <option value="female" {{ old('gender', $student->gender) == 'female' ? 'selected' : '' }}>👩 Female</option>
                            <option value="other" {{ old('gender', $student->gender) == 'other' ? 'selected' : '' }}>⚧ Other</option>
                        </select>
                        <div class="absolute inset-y-0 right-0 flex items-center px-2 pointer-events-none">
                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </div>
                        <label class="absolute -top-2.5 left-10 px-2 bg-white dark:bg-gray-800 text-xs font-semibold text-gray-600 dark:text-gray-400">
                            Gender *
                        </label>
                        @error('gender')
                            <p class="text-red-500 text-xs mt-2 flex items-center gap-1">
                                <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                </svg>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <!-- Blood Group with Icon -->
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"></path>
                            </svg>
                        </div>
                        <select name="blood_group" required 
                                class="w-full pl-10 pr-10 py-3 text-sm border-2 border-gray-300 dark:border-gray-600 rounded-xl bg-white dark:bg-gray-700 focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 transition-all duration-200 appearance-none min-h-[52px] touch-manipulation">
                            <option value="">Select Blood Group</option>
                            <option value="A+" {{ old('blood_group', $student->blood_group) == 'A+' ? 'selected' : '' }}>🩸 A+</option>
                            <option value="A-" {{ old('blood_group', $student->blood_group) == 'A-' ? 'selected' : '' }}>🩸 A-</option>
                            <option value="B+" {{ old('blood_group', $student->blood_group) == 'B+' ? 'selected' : '' }}>🩸 B+</option>
                            <option value="B-" {{ old('blood_group', $student->blood_group) == 'B-' ? 'selected' : '' }}>🩸 B-</option>
                            <option value="AB+" {{ old('blood_group', $student->blood_group) == 'AB+' ? 'selected' : '' }}>🩸 AB+</option>
                            <option value="AB-" {{ old('blood_group', $student->blood_group) == 'AB-' ? 'selected' : '' }}>🩸 AB-</option>
                            <option value="O+" {{ old('blood_group', $student->blood_group) == 'O+' ? 'selected' : '' }}>🩸 O+</option>
                            <option value="O-" {{ old('blood_group', $student->blood_group) == 'O-' ? 'selected' : '' }}>🩸 O-</option>
                        </select>
                        <div class="absolute inset-y-0 right-0 flex items-center px-2 pointer-events-none">
                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </div>
                        <label class="absolute -top-2.5 left-10 px-2 bg-white dark:bg-gray-800 text-xs font-semibold text-gray-600 dark:text-gray-400">
                            Blood Group *
                        </label>
                        @error('blood_group')
                            <p class="text-red-500 text-xs mt-2 flex items-center gap-1">
                                <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                </svg>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <!-- Religion with Icon -->
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                            </svg>
                        </div>
                        <select name="religion" required 
                                class="w-full pl-10 pr-10 py-3 text-sm border-2 border-gray-300 dark:border-gray-600 rounded-xl bg-white dark:bg-gray-700 focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 transition-all duration-200 appearance-none min-h-[52px] touch-manipulation">
                            <option value="">Select Religion</option>
                            <option value="Islam" {{ old('religion', $student->religion) == 'Islam' ? 'selected' : '' }}>☪️ Islam</option>
                            <option value="Hinduism" {{ old('religion', $student->religion) == 'Hinduism' ? 'selected' : '' }}>🕉️ Hinduism</option>
                            <option value="Christianity" {{ old('religion', $student->religion) == 'Christianity' ? 'selected' : '' }}>✝️ Christianity</option>
                            <option value="Buddhism" {{ old('religion', $student->religion) == 'Buddhism' ? 'selected' : '' }}>☸️ Buddhism</option>
                        </select>
                        <div class="absolute inset-y-0 right-0 flex items-center px-2 pointer-events-none">
                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </div>
                        <label class="absolute -top-2.5 left-10 px-2 bg-white dark:bg-gray-800 text-xs font-semibold text-gray-600 dark:text-gray-400">
                            Religion *
                        </label>
                        @error('religion')
                            <p class="text-red-500 text-xs mt-2 flex items-center gap-1">
                                <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                </svg>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <!-- Enroll Date -->
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <input type="date" name="enroll_date" value="{{ old('enroll_date', date('Y-m-d')) }}" required
                               class="w-full pl-10 pr-4 py-3 text-sm border-2 border-gray-300 dark:border-gray-600 rounded-xl bg-white dark:bg-gray-700 focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 transition-all duration-200 min-h-[52px] touch-manipulation">
                        <label class="absolute -top-2.5 left-10 px-2 bg-white dark:bg-gray-800 text-xs font-semibold text-gray-600 dark:text-gray-400">
                            Enroll Date *
                        </label>
                        @error('enroll_date')
                            <p class="text-red-500 text-xs mt-2 flex items-center gap-1">
                                <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                </svg>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <!-- Course with Icon -->
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                            </svg>
                        </div>
                        <select name="course_id" required 
                                class="w-full pl-10 pr-10 py-3 text-sm border-2 border-gray-300 dark:border-gray-600 rounded-xl bg-white dark:bg-gray-700 focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 transition-all duration-200 appearance-none min-h-[52px] touch-manipulation">
                            <option value="">Select Course</option>
                            @foreach($courses as $course)
                                <option value="{{ $course->id }}" {{ old('course_id', $student->course_id) == $course->id ? 'selected' : '' }}>
                                    📚 {{ $course->name }}
                                </option>
                            @endforeach
                        </select>
                        <div class="absolute inset-y-0 right-0 flex items-center px-2 pointer-events-none">
                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </div>
                        <label class="absolute -top-2.5 left-10 px-2 bg-white dark:bg-gray-800 text-xs font-semibold text-gray-600 dark:text-gray-400">
                            Course *
                        </label>
                        @error('course_id')
                            <p class="text-red-500 text-xs mt-2 flex items-center gap-1">
                                <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                </svg>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <!-- Batch with Icon -->
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                            </svg>
                        </div>
                        <select name="batch_id" required 
                                class="w-full pl-10 pr-10 py-3 text-sm border-2 border-gray-300 dark:border-gray-600 rounded-xl bg-white dark:bg-gray-700 focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 transition-all duration-200 appearance-none min-h-[52px] touch-manipulation">
                            <option value="">Select Batch</option>
                            @foreach($batches as $batch)
                                <option value="{{ $batch->id }}" {{ old('batch_id', $student->batch_id) == $batch->id ? 'selected' : '' }}>
                                    👥 {{ $batch->name }}
                                </option>
                            @endforeach
                        </select>
                        <div class="absolute inset-y-0 right-0 flex items-center px-2 pointer-events-none">
                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </div>
                        <label class="absolute -top-2.5 left-10 px-2 bg-white dark:bg-gray-800 text-xs font-semibold text-gray-600 dark:text-gray-400">
                            Batch *
                        </label>
                        @error('batch_id')
                            <p class="text-red-500 text-xs mt-2 flex items-center gap-1">
                                <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                </svg>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                </div>
            </div>
        </div>

        <!-- Contact Information Section -->
        <div class="border-b border-gray-200 dark:border-gray-700">
            <!-- Section Header -->
            <div class="w-full px-8 sm:px-10 py-6 sm:py-8 bg-gradient-to-r from-green-50 to-emerald-50 dark:from-green-900/20 dark:to-emerald-900/20 flex items-center gap-4">
                <div class="w-10 h-10 sm:w-12 sm:h-12 bg-gradient-to-br from-green-500 to-emerald-600 rounded-xl flex items-center justify-center shadow-lg">
                    <svg class="w-5 h-5 sm:w-6 sm:h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                    </svg>
                </div>
                <div class="text-left">
                    <h2 class="text-lg sm:text-xl font-bold text-gray-900 dark:text-white">
                        Contact Information
                    </h2>
                    <p class="text-sm text-gray-600 dark:text-gray-400 mt-0.5">
                        Communication details and address information
                    </p>
                </div>
            </div>
            
            <!-- Section Content -->
            <div id="contact-info" class="px-6 sm:px-8 py-6 sm:py-8">
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-6">
                    <!-- Email Address with Icon -->
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                        <input type="email" name="email" value="{{ old('email', $student->email) }}" required
                               pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$"
                               title="Please enter a valid email address"
                               class="w-full pl-10 pr-4 py-3 text-sm border-2 border-gray-300 dark:border-gray-600 rounded-xl bg-white dark:bg-gray-700 focus:border-green-500 focus:ring-2 focus:ring-green-500/20 transition-all duration-200 min-h-[52px] touch-manipulation"
                               placeholder="student@example.com">
                        <label class="absolute -top-2.5 left-10 px-2 bg-white dark:bg-gray-800 text-xs font-semibold text-gray-600 dark:text-gray-400">
                            Email Address *
                        </label>
                        @error('email')
                            <p class="text-red-500 text-xs mt-2 flex items-center gap-1">
                                <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                </svg>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <!-- Phone Number with Icon -->
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                            </svg>
                        </div>
                        <input type="tel" name="phone" value="{{ old('phone', $student->phone) }}" required
                               placeholder="01XXXXXXXXX"
                               pattern="01[3-9][0-9]{8}"
                               title="Please enter a valid Bangladeshi phone number (01XXXXXXXXX)"
                               maxlength="11"
                               class="w-full pl-10 pr-4 py-3 text-sm border-2 border-gray-300 dark:border-gray-600 rounded-xl bg-white dark:bg-gray-700 focus:border-orange-500 focus:ring-2 focus:ring-orange-500/20 transition-all duration-200 min-h-[52px] touch-manipulation">
                        <label class="absolute -top-2.5 left-10 px-2 bg-white dark:bg-gray-800 text-xs font-semibold text-gray-600 dark:text-gray-400">
                            Phone Number *
                        </label>
                        @error('phone')
                            <p class="text-red-500 text-xs mt-2 flex items-center gap-1">
                                <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                </svg>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <!-- Home District with Location Icon -->
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                        </div>
                        <input type="text" name="city" value="{{ old('city', $student->city) }}"
                               class="w-full pl-10 pr-4 py-3 text-sm border-2 border-gray-300 dark:border-gray-600 rounded-xl bg-white dark:bg-gray-700 focus:border-green-500 focus:ring-2 focus:ring-green-500/20 transition-all duration-200 min-h-[52px] touch-manipulation"
                               placeholder="Enter district name">
                        <label class="absolute -top-2.5 left-10 px-2 bg-white dark:bg-gray-800 text-xs font-semibold text-gray-600 dark:text-gray-400">
                            Home District
                        </label>
                        @error('city')
                            <p class="text-red-500 text-xs mt-2 flex items-center gap-1">
                                <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                </svg>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>
                </div>
                
                <!-- Full Width Address Field with Enhanced Styling -->
                <div class="mt-6">
                    <div class="relative">
                        <div class="absolute top-3 left-3 flex items-start pointer-events-none">
                            <svg class="w-5 h-5 text-gray-400 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                            </svg>
                        </div>
                        <textarea name="address" 
                                  class="w-full pl-10 pr-4 py-3 text-sm border-2 border-gray-300 dark:border-gray-600 rounded-xl bg-white dark:bg-gray-700 focus:border-green-500 focus:ring-2 focus:ring-green-500/20 transition-all duration-200 resize-none touch-manipulation"
                                  rows="4"
                                  placeholder="Enter detailed address including street, area, and landmarks">{{ old('address', $student->address) }}</textarea>
                        <label class="absolute -top-2.5 left-10 px-2 bg-white dark:bg-gray-800 text-xs font-semibold text-gray-600 dark:text-gray-400">
                            Detailed Address
                        </label>
                        @error('address')
                            <p class="text-red-500 text-xs mt-2 flex items-center gap-1">
                                <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                </svg>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>
                </div>
            </div>
        </div>

        <!-- Academic Information Section -->
        <div class="border-b border-gray-200 dark:border-gray-700">
            <!-- Section Header -->
            <div class="w-full px-8 sm:px-10 py-6 sm:py-8 bg-gradient-to-r from-purple-50 to-violet-50 dark:from-purple-900/20 dark:to-violet-900/20 flex items-center gap-4">
                <div class="w-10 h-10 sm:w-12 sm:h-12 bg-gradient-to-br from-purple-500 to-violet-600 rounded-xl flex items-center justify-center shadow-lg">
                    <svg class="w-5 h-5 sm:w-6 sm:h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                    </svg>
                </div>
                <div class="text-left">
                    <h2 class="text-lg sm:text-xl font-bold text-gray-900 dark:text-white">
                        Academic Information
                    </h2>
                    <p class="text-sm text-gray-600 dark:text-gray-400 mt-0.5">
                        Previous education and academic background
                    </p>
                </div>
            </div>
            
            <!-- Section Content -->
            <div id="academic-info" class="px-6 sm:px-8 py-6 sm:py-8">
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 sm:gap-6">
                    <!-- Last Institute with Icon -->
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                            </svg>
                        </div>
                        <input type="text" name="school_college" value="{{ old('school_college', $student->school_college) }}"
                               class="w-full pl-10 pr-4 py-3 text-sm border-2 border-gray-300 dark:border-gray-600 rounded-xl bg-white dark:bg-gray-700 focus:border-purple-500 focus:ring-2 focus:ring-purple-500/20 transition-all duration-200 min-h-[52px] touch-manipulation"
                               placeholder="Enter school/college name">
                        <label class="absolute -top-2.5 left-10 px-2 bg-white dark:bg-gray-800 text-xs font-semibold text-gray-600 dark:text-gray-400">
                            Last Institute
                        </label>
                        @error('school_college')
                            <p class="text-red-500 text-xs mt-2 flex items-center gap-1">
                                <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                </svg>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <!-- Last Degree/Class with Icon -->
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14zm-4 6v-7.5l4-2.222"></path>
                            </svg>
                        </div>
                        <input type="text" name="class_grade" value="{{ old('class_grade', $student->class_grade) }}"
                               class="w-full pl-10 pr-4 py-3 text-sm border-2 border-gray-300 dark:border-gray-600 rounded-xl bg-white dark:bg-gray-700 focus:border-purple-500 focus:ring-2 focus:ring-purple-500/20 transition-all duration-200 min-h-[52px] touch-manipulation"
                               placeholder="e.g., HSC, SSC, Class 10">
                        <label class="absolute -top-2.5 left-10 px-2 bg-white dark:bg-gray-800 text-xs font-semibold text-gray-600 dark:text-gray-400">
                            Last Degree/Class
                        </label>
                        @error('class_grade')
                            <p class="text-red-500 text-xs mt-2 flex items-center gap-1">
                                <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                </svg>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>
                </div>
            </div>
        </div>

        <!-- Parent & Guardian Information Section -->
        <div class="border-b border-gray-200 dark:border-gray-700">
            <!-- Section Header -->
            <div class="w-full px-8 sm:px-10 py-6 sm:py-8 bg-gradient-to-r from-orange-50 to-amber-50 dark:from-orange-900/20 dark:to-amber-900/20 flex items-center gap-4">
                <div class="w-10 h-10 sm:w-12 sm:h-12 bg-gradient-to-br from-orange-500 to-amber-600 rounded-xl flex items-center justify-center shadow-lg">
                    <svg class="w-5 h-5 sm:w-6 sm:h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                    </svg>
                </div>
                <div class="text-left">
                    <h2 class="text-lg sm:text-xl font-bold text-gray-900 dark:text-white">
                        Parent & Guardian Information
                    </h2>
                    <p class="text-sm text-gray-600 dark:text-gray-400 mt-0.5">
                        Family details and guardian contact information
                    </p>
                </div>
            </div>
            
            <!-- Section Content -->
            <div id="parent-info" class="px-6 sm:px-8 py-6 sm:py-8">
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-6">
                    <!-- Father's Name with Icon -->
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                        </div>
                        <input type="text" name="father_name" value="{{ old('father_name', $student->father_name) }}"
                               class="w-full pl-10 pr-4 py-3 text-sm border-2 border-gray-300 dark:border-gray-600 rounded-xl bg-white dark:bg-gray-700 focus:border-orange-500 focus:ring-2 focus:ring-orange-500/20 transition-all duration-200 min-h-[52px] touch-manipulation"
                               placeholder="Enter father's name">
                        <label class="absolute -top-2.5 left-10 px-2 bg-white dark:bg-gray-800 text-xs font-semibold text-gray-600 dark:text-gray-400">
                            Father's Name
                        </label>
                        @error('father_name')
                            <p class="text-red-500 text-xs mt-2 flex items-center gap-1">
                                <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                </svg>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <!-- Father's Phone with Icon -->
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                            </svg>
                        </div>
                        <input type="tel" name="father_phone" value="{{ old('father_phone', $student->father_phone) }}"
                               placeholder="01XXXXXXXXX"
                               pattern="01[3-9][0-9]{8}"
                               title="Please enter a valid Bangladeshi phone number (01XXXXXXXXX)"
                               maxlength="11"
                               class="w-full pl-10 pr-4 py-3 text-sm border-2 border-gray-300 dark:border-gray-600 rounded-xl bg-white dark:bg-gray-700 focus:border-orange-500 focus:ring-2 focus:ring-orange-500/20 transition-all duration-200 min-h-[52px] touch-manipulation">
                        <label class="absolute -top-2.5 left-10 px-2 bg-white dark:bg-gray-800 text-xs font-semibold text-gray-600 dark:text-gray-400">
                            Father's Phone
                        </label>
                        @error('father_phone')
                            <p class="text-red-500 text-xs mt-2 flex items-center gap-1">
                                <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                </svg>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <!-- Mother's Name with Icon -->
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                        </div>
                        <input type="text" name="mother_name" value="{{ old('mother_name', $student->mother_name) }}"
                               class="w-full pl-10 pr-4 py-3 text-sm border-2 border-gray-300 dark:border-gray-600 rounded-xl bg-white dark:bg-gray-700 focus:border-orange-500 focus:ring-2 focus:ring-orange-500/20 transition-all duration-200 min-h-[52px] touch-manipulation"
                               placeholder="Enter mother's name">
                        <label class="absolute -top-2.5 left-10 px-2 bg-white dark:bg-gray-800 text-xs font-semibold text-gray-600 dark:text-gray-400">
                            Mother's Name
                        </label>
                        @error('mother_name')
                            <p class="text-red-500 text-xs mt-2 flex items-center gap-1">
                                <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                </svg>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <!-- Mother's Phone with Icon -->
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                            </svg>
                        </div>
                        <input type="tel" name="mother_phone" value="{{ old('mother_phone', $student->mother_phone) }}"
                               placeholder="01XXXXXXXXX"
                               pattern="01[3-9][0-9]{8}"
                               title="Please enter a valid Bangladeshi phone number (01XXXXXXXXX)"
                               maxlength="11"
                               class="w-full pl-10 pr-4 py-3 text-sm border-2 border-gray-300 dark:border-gray-600 rounded-xl bg-white dark:bg-gray-700 focus:border-orange-500 focus:ring-2 focus:ring-orange-500/20 transition-all duration-200 min-h-[52px] touch-manipulation">
                        <label class="absolute -top-2.5 left-10 px-2 bg-white dark:bg-gray-800 text-xs font-semibold text-gray-600 dark:text-gray-400">
                            Mother's Phone
                        </label>
                        @error('mother_phone')
                            <p class="text-red-500 text-xs mt-2 flex items-center gap-1">
                                <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                </svg>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <!-- Guardian with Modern Select -->
                    <div class="relative">
                        <select name="guardian" 
                                class="w-full px-4 py-3 text-sm border-2 border-gray-300 dark:border-gray-600 rounded-xl bg-white dark:bg-gray-700 focus:border-orange-500 focus:ring-2 focus:ring-orange-500/20 transition-all duration-200 appearance-none min-h-[52px] touch-manipulation">
                            <option value="">Select Guardian</option>
                            <option value="Father" {{ old('guardian', $student->guardian) == 'Father' ? 'selected' : '' }}>👨 Father</option>
                            <option value="Mother" {{ old('guardian', $student->guardian) == 'Mother' ? 'selected' : '' }}>👩 Mother</option>
                            <option value="Other" {{ old('guardian', $student->guardian) == 'Other' ? 'selected' : '' }}>⚧ Other</option>
                        </select>
                        <div class="absolute inset-y-0 right-0 flex items-center px-2 pointer-events-none">
                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </div>
                        <label class="absolute -top-2.5 left-4 px-2 bg-white dark:bg-gray-800 text-xs font-semibold text-gray-600 dark:text-gray-400">
                            Guardian
                        </label>
                        @error('guardian')
                            <p class="text-red-500 text-xs mt-2 flex items-center gap-1">
                                <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                </svg>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <!-- Guardian Name with Icon -->
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                            </svg>
                        </div>
                        <input type="text" name="guardian_name" value="{{ old('guardian_name', $student->guardian_name) }}"
                               class="w-full pl-10 pr-4 py-3 text-sm border-2 border-gray-300 dark:border-gray-600 rounded-xl bg-white dark:bg-gray-700 focus:border-orange-500 focus:ring-2 focus:ring-orange-500/20 transition-all duration-200 min-h-[52px] touch-manipulation"
                               placeholder="Enter guardian's name">
                        <label class="absolute -top-2.5 left-10 px-2 bg-white dark:bg-gray-800 text-xs font-semibold text-gray-600 dark:text-gray-400">
                            Guardian Name
                        </label>
                        @error('guardian_name')
                            <p class="text-red-500 text-xs mt-2 flex items-center gap-1">
                                <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                </svg>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <!-- Guardian Phone with Icon -->
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                            </svg>
                        </div>
                        <input type="tel" name="guardian_phone" value="{{ old('guardian_phone', $student->guardian_phone) }}"
                               placeholder="01XXXXXXXXX"
                               pattern="01[3-9][0-9]{8}"
                               title="Please enter a valid Bangladeshi phone number (01XXXXXXXXX)"
                               maxlength="11"
                               class="w-full pl-10 pr-4 py-3 text-sm border-2 border-gray-300 dark:border-gray-600 rounded-xl bg-white dark:bg-gray-700 focus:border-orange-500 focus:ring-2 focus:ring-orange-500/20 transition-all duration-200 min-h-[52px] touch-manipulation">
                        <label class="absolute -top-2.5 left-10 px-2 bg-white dark:bg-gray-800 text-xs font-semibold text-gray-600 dark:text-gray-400">
                            Guardian Phone
                        </label>
                        @error('guardian_phone')
                            <p class="text-red-500 text-xs mt-2 flex items-center gap-1">
                                <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                </svg>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <!-- Student Photo with Icon -->
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                        <input type="file" name="photo" accept="image/*"
                               class="w-full pl-10 pr-4 py-3 text-sm border-2 border-gray-300 dark:border-gray-600 rounded-xl bg-white dark:bg-gray-700 focus:border-orange-500 focus:ring-2 focus:ring-orange-500/20 transition-all duration-200 min-h-[52px] touch-manipulation">
                        <label class="absolute -top-2.5 left-10 px-2 bg-white dark:bg-gray-800 text-xs font-semibold text-gray-600 dark:text-gray-400">
                            Student Photo
                        </label>
                        @error('photo')
                            <p class="text-red-500 text-xs mt-2 flex items-center gap-1">
                                <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                </svg>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>
                </div>
            </div>


        </form>
    </div>
</div>
@endsection 

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const guardianSelect = document.querySelector('select[name="guardian"]');
    const guardianNameInput = document.querySelector('input[name="guardian_name"]');
    const guardianPhoneInput = document.querySelector('input[name="guardian_phone"]');
    const fatherNameInput = document.querySelector('input[name="father_name"]');
    const fatherPhoneInput = document.querySelector('input[name="father_phone"]');
    const motherNameInput = document.querySelector('input[name="mother_name"]');
    const motherPhoneInput = document.querySelector('input[name="mother_phone"]');

    // Store original values to restore if "Other" is selected
    let originalGuardianName = '';
    let originalGuardianPhone = '';

    guardianSelect.addEventListener('change', function() {
        const selectedGuardian = this.value;
        
        // Store current values before auto-populating (only if not already auto-populated)
        if (selectedGuardian === 'Father' || selectedGuardian === 'Mother') {
            if (!originalGuardianName && !originalGuardianPhone) {
                originalGuardianName = guardianNameInput.value;
                originalGuardianPhone = guardianPhoneInput.value;
            }
        }

        if (selectedGuardian === 'Father') {
            // Auto-populate with father's information
            guardianNameInput.value = fatherNameInput.value;
            guardianPhoneInput.value = fatherPhoneInput.value;
            
            // Add visual indication that fields are auto-populated
            guardianNameInput.style.backgroundColor = '#f0f9ff';
            guardianPhoneInput.style.backgroundColor = '#f0f9ff';
            guardianNameInput.title = 'Auto-populated from Father\'s information';
            guardianPhoneInput.title = 'Auto-populated from Father\'s information';
            
        } else if (selectedGuardian === 'Mother') {
            // Auto-populate with mother's information
            guardianNameInput.value = motherNameInput.value;
            guardianPhoneInput.value = motherPhoneInput.value;
            
            // Add visual indication that fields are auto-populated
            guardianNameInput.style.backgroundColor = '#f0f9ff';
            guardianPhoneInput.style.backgroundColor = '#f0f9ff';
            guardianNameInput.title = 'Auto-populated from Mother\'s information';
            guardianPhoneInput.title = 'Auto-populated from Mother\'s information';
            
        } else {
            // For "Other" or empty selection, restore original values and reset styling
            guardianNameInput.value = originalGuardianName;
            guardianPhoneInput.value = originalGuardianPhone;
            guardianNameInput.style.backgroundColor = '';
            guardianPhoneInput.style.backgroundColor = '';
            guardianNameInput.title = '';
            guardianPhoneInput.title = '';
        }
    });

    // Update guardian fields if father/mother information changes while they are selected as guardian
    function updateGuardianFields() {
        const selectedGuardian = guardianSelect.value;
        
        if (selectedGuardian === 'Father') {
            guardianNameInput.value = fatherNameInput.value;
            guardianPhoneInput.value = fatherPhoneInput.value;
        } else if (selectedGuardian === 'Mother') {
            guardianNameInput.value = motherNameInput.value;
            guardianPhoneInput.value = motherPhoneInput.value;
        }
    }

    // Listen for changes in father/mother fields
    fatherNameInput.addEventListener('input', updateGuardianFields);
    fatherPhoneInput.addEventListener('input', updateGuardianFields);
    motherNameInput.addEventListener('input', updateGuardianFields);
    motherPhoneInput.addEventListener('input', updateGuardianFields);

    // Trigger change event on page load if guardian is already selected
    if (guardianSelect.value) {
        guardianSelect.dispatchEvent(new Event('change'));
    }
});
</script>
@endpush
