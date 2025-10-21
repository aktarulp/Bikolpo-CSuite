@extends('layouts.partner-layout')

@section('title', $student->full_name . ' - Student Profile')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-indigo-50 via-purple-50 to-pink-50 dark:from-gray-900 dark:via-indigo-900 dark:to-purple-900 -m-6 p-4 sm:p-6 lg:p-8">
    <div class="max-w-6xl mx-auto space-y-4 sm:space-y-6">
        
        <!-- Back Button & Quick Actions (Mobile Optimized) -->
        <div class="flex flex-col sm:flex-row gap-2 sm:gap-3">
            <a href="{{ route('partner.students.index') }}" 
               class="inline-flex items-center justify-center gap-2 px-4 py-2.5 bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700 text-gray-700 dark:text-gray-300 rounded-xl font-semibold shadow-md hover:shadow-lg transition-all duration-200 border border-gray-200 dark:border-gray-700">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                <span class="text-sm">Back to Students</span>
            </a>
            
            <!-- Quick Actions -->
            <div class="flex flex-wrap gap-2 sm:ml-auto">
                <a href="{{ route('partner.students.edit', $student) }}" 
                   class="flex-1 sm:flex-none inline-flex items-center justify-center gap-2 px-4 py-2.5 bg-gradient-to-r from-blue-500 to-indigo-600 hover:from-blue-600 hover:to-indigo-700 text-white rounded-xl font-semibold shadow-lg hover:shadow-xl transition-all duration-200 transform hover:scale-105">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                    </svg>
                    <span class="text-sm">Edit</span>
                </a>
                
                <a href="{{ route('analytics.students.show', $student->id) }}" 
                   class="flex-1 sm:flex-none inline-flex items-center justify-center gap-2 px-4 py-2.5 bg-gradient-to-r from-purple-500 to-pink-600 hover:from-purple-600 hover:to-pink-700 text-white rounded-xl font-semibold shadow-lg hover:shadow-xl transition-all duration-200 transform hover:scale-105">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                    </svg>
                    <span class="text-sm hidden sm:inline">Analytics</span>
                    <span class="text-sm sm:hidden">Stats</span>
                </a>
            </div>
        </div>

        <!-- Profile Header Card with Cover -->
        <div class="bg-white dark:bg-gray-800 rounded-3xl shadow-2xl overflow-hidden border border-gray-200 dark:border-gray-700 transform transition-all duration-300 hover:shadow-3xl">
            <!-- Cover Background -->
            <div class="h-32 sm:h-40 bg-gradient-to-r from-indigo-500 via-purple-500 to-pink-500 relative overflow-hidden">
                <!-- Animated Pattern -->
                <div class="absolute inset-0 opacity-20">
                    <div class="absolute top-0 left-0 w-40 h-40 bg-white rounded-full -translate-x-1/2 -translate-y-1/2"></div>
                    <div class="absolute bottom-0 right-0 w-48 h-48 bg-white rounded-full translate-x-1/3 translate-y-1/3"></div>
                    <div class="absolute top-1/2 left-1/2 w-32 h-32 bg-white rounded-full -translate-x-1/2 -translate-y-1/2"></div>
                </div>
                
                <!-- Status Badge (Top Right) -->
                <div class="absolute top-4 right-4 z-10">
                    <span class="inline-flex items-center gap-1.5 px-4 py-2 rounded-full text-sm font-bold shadow-lg backdrop-blur-md
                        @if($student->status === 'active') 
                            bg-green-500/90 text-white
                        @else 
                            bg-red-500/90 text-white
                        @endif">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                            <circle cx="10" cy="10" r="4"/>
                        </svg>
                        {{ ucfirst($student->status) }}
                    </span>
                </div>
            </div>

            <!-- Profile Info Section -->
            <div class="relative px-4 sm:px-6 lg:px-8 pb-6">
                <!-- Profile Photo (Overlapping) -->
                <div class="flex flex-col sm:flex-row items-center sm:items-end gap-4 sm:gap-6 -mt-16 sm:-mt-20">
                    <div class="relative group">
                        @if($student->photo)
                            <img class="w-28 h-28 sm:w-32 sm:h-32 lg:w-36 lg:h-36 rounded-2xl object-cover border-4 border-white dark:border-gray-800 shadow-2xl ring-4 ring-purple-200 dark:ring-purple-900 transition-transform duration-300 group-hover:scale-105" 
                                 src="{{ asset('uploads/' . $student->photo) }}" 
                                 alt="{{ $student->full_name }}">
                        @else
                            <div class="w-28 h-28 sm:w-32 sm:h-32 lg:w-36 lg:h-36 rounded-2xl bg-gradient-to-br from-indigo-400 to-purple-600 flex items-center justify-center border-4 border-white dark:border-gray-800 shadow-2xl ring-4 ring-purple-200 dark:ring-purple-900 transition-transform duration-300 group-hover:scale-105">
                                <span class="text-white font-black text-4xl sm:text-5xl lg:text-6xl">
                                    {{ substr($student->full_name, 0, 1) }}
                                </span>
                            </div>
                        @endif
                        
                        <!-- Online Indicator (if active) -->
                        @if($student->status === 'active')
                            <div class="absolute bottom-2 right-2 w-5 h-5 bg-green-500 border-4 border-white dark:border-gray-800 rounded-full animate-pulse"></div>
                        @endif
                    </div>

                    <!-- Name & Info -->
                    <div class="flex-1 text-center sm:text-left pt-2 sm:pt-0 pb-2">
                        <h1 class="text-2xl sm:text-3xl lg:text-4xl font-black bg-gradient-to-r from-indigo-600 via-purple-600 to-pink-600 bg-clip-text text-transparent mb-1">
                            {{ $student->full_name }}
                        </h1>
                        
                        <!-- Quick Info Pills -->
                        <div class="flex flex-wrap items-center justify-center sm:justify-start gap-2 mt-3">
                            @if($student->student_id)
                                <div class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-gradient-to-r from-blue-100 to-indigo-100 dark:from-blue-900/30 dark:to-indigo-900/30 rounded-full border border-blue-200 dark:border-blue-800">
                                    <svg class="w-3.5 h-3.5 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2"></path>
                                    </svg>
                                    <span class="text-xs font-bold text-blue-900 dark:text-blue-300">ID: {{ $student->student_id }}</span>
                                </div>
                            @endif
                            
                            @if($student->gender)
                                <div class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-gradient-to-r from-purple-100 to-pink-100 dark:from-purple-900/30 dark:to-pink-900/30 rounded-full border border-purple-200 dark:border-purple-800">
                                    <svg class="w-3.5 h-3.5 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                    </svg>
                                    <span class="text-xs font-bold text-purple-900 dark:text-purple-300 capitalize">{{ $student->gender }}</span>
                                </div>
                            @endif
                            
                            @if($student->date_of_birth)
                                <div class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-gradient-to-r from-emerald-100 to-teal-100 dark:from-emerald-900/30 dark:to-teal-900/30 rounded-full border border-emerald-200 dark:border-emerald-800">
                                    <svg class="w-3.5 h-3.5 text-emerald-600 dark:text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                    <span class="text-xs font-bold text-emerald-900 dark:text-emerald-300">{{ $student->date_of_birth->format('M d, Y') }}</span>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Contact Information Cards -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
            <!-- Email Card -->
            <div class="bg-gradient-to-br from-blue-500 to-indigo-600 rounded-2xl p-5 shadow-lg transform transition-all duration-300 hover:scale-105 hover:shadow-2xl">
                <div class="flex items-start gap-4">
                    <div class="w-12 h-12 bg-white/20 backdrop-blur-md rounded-xl flex items-center justify-center flex-shrink-0">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-xs font-semibold text-blue-100 mb-1">Email Address</p>
                        <p class="text-sm font-bold text-white truncate">{{ $student->email ?? 'Not provided' }}</p>
                    </div>
                </div>
            </div>

            <!-- Phone Card -->
            <div class="bg-gradient-to-br from-emerald-500 to-teal-600 rounded-2xl p-5 shadow-lg transform transition-all duration-300 hover:scale-105 hover:shadow-2xl">
                <div class="flex items-start gap-4">
                    <div class="w-12 h-12 bg-white/20 backdrop-blur-md rounded-xl flex items-center justify-center flex-shrink-0">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                        </svg>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-xs font-semibold text-emerald-100 mb-1">Phone Number</p>
                        <p class="text-sm font-bold text-white truncate">{{ $student->phone ?? 'Not provided' }}</p>
                    </div>
                </div>
            </div>

            <!-- Enrollment Date Card -->
            <div class="bg-gradient-to-br from-purple-500 to-pink-600 rounded-2xl p-5 shadow-lg transform transition-all duration-300 hover:scale-105 hover:shadow-2xl sm:col-span-2 lg:col-span-1">
                <div class="flex items-start gap-4">
                    <div class="w-12 h-12 bg-white/20 backdrop-blur-md rounded-xl flex items-center justify-center flex-shrink-0">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-xs font-semibold text-purple-100 mb-1">Enrollment Date</p>
                        <p class="text-sm font-bold text-white truncate">{{ $student->enroll_date ? $student->enroll_date->format('M d, Y') : 'Not set' }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-4 sm:gap-6">
            
            <!-- Left Column (Personal & Academic Info) -->
            <div class="lg:col-span-2 space-y-4 sm:space-y-6">
                
                <!-- Personal Information Card -->
                <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl overflow-hidden border border-gray-200 dark:border-gray-700">
                    <div class="bg-gradient-to-r from-indigo-50 to-purple-50 dark:from-indigo-900/20 dark:to-purple-900/20 px-5 py-4 border-b border-gray-200 dark:border-gray-700">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-xl flex items-center justify-center shadow-lg">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-base sm:text-lg font-bold text-gray-900 dark:text-white">Personal Information</h3>
                                <p class="text-xs text-gray-600 dark:text-gray-400">Basic details about the student</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="p-5 sm:p-6">
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                            <!-- School/College -->
                            @if($student->school_college)
                                <div class="group">
                                    <div class="flex items-center gap-2 mb-2">
                                        <svg class="w-4 h-4 text-indigo-500 dark:text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                        </svg>
                                        <label class="text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wide">School/College</label>
                                    </div>
                                    <p class="text-sm sm:text-base font-semibold text-gray-900 dark:text-white pl-6">{{ $student->school_college }}</p>
                                </div>
                            @endif

                            <!-- Class/Grade -->
                            @if($student->class_grade)
                                <div class="group">
                                    <div class="flex items-center gap-2 mb-2">
                                        <svg class="w-4 h-4 text-purple-500 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                        </svg>
                                        <label class="text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wide">Class/Grade</label>
                                    </div>
                                    <p class="text-sm sm:text-base font-semibold text-gray-900 dark:text-white pl-6">{{ $student->class_grade }}</p>
                                </div>
                            @endif

                            <!-- Blood Group -->
                            @if($student->blood_group)
                                <div class="group">
                                    <div class="flex items-center gap-2 mb-2">
                                        <svg class="w-4 h-4 text-red-500 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                                        </svg>
                                        <label class="text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wide">Blood Group</label>
                                    </div>
                                    <p class="text-sm sm:text-base font-semibold text-gray-900 dark:text-white pl-6">{{ $student->blood_group }}</p>
                                </div>
                            @endif

                            <!-- Religion -->
                            @if($student->religion)
                                <div class="group">
                                    <div class="flex items-center gap-2 mb-2">
                                        <svg class="w-4 h-4 text-amber-500 dark:text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                        </svg>
                                        <label class="text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wide">Religion</label>
                                    </div>
                                    <p class="text-sm sm:text-base font-semibold text-gray-900 dark:text-white pl-6">{{ $student->religion }}</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Address Information Card -->
                @if($student->address || $student->city)
                    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl overflow-hidden border border-gray-200 dark:border-gray-700">
                        <div class="bg-gradient-to-r from-emerald-50 to-teal-50 dark:from-emerald-900/20 dark:to-teal-900/20 px-5 py-4 border-b border-gray-200 dark:border-gray-700">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 bg-gradient-to-br from-emerald-500 to-teal-600 rounded-xl flex items-center justify-center shadow-lg">
                                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="text-base sm:text-lg font-bold text-gray-900 dark:text-white">Address Information</h3>
                                    <p class="text-xs text-gray-600 dark:text-gray-400">Location details</p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="p-5 sm:p-6">
                            <div class="space-y-4">
                                @if($student->address)
                                    <div class="flex items-start gap-3">
                                        <svg class="w-5 h-5 text-emerald-500 dark:text-emerald-400 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                                        </svg>
                                        <div class="flex-1">
                                            <p class="text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wide mb-1">Full Address</p>
                                            <p class="text-sm sm:text-base font-semibold text-gray-900 dark:text-white">{{ $student->address }}</p>
                                        </div>
                                    </div>
                                @endif
                                
                                @if($student->city)
                                    <div class="flex items-start gap-3">
                                        <svg class="w-5 h-5 text-teal-500 dark:text-teal-400 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                        </svg>
                                        <div class="flex-1">
                                            <p class="text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wide mb-1">City</p>
                                            <p class="text-sm sm:text-base font-semibold text-gray-900 dark:text-white">{{ $student->city }}</p>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Parent Information Card -->
                @if($student->father_name || $student->mother_name)
                    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl overflow-hidden border border-gray-200 dark:border-gray-700">
                        <div class="bg-gradient-to-r from-orange-50 to-amber-50 dark:from-orange-900/20 dark:to-amber-900/20 px-5 py-4 border-b border-gray-200 dark:border-gray-700">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 bg-gradient-to-br from-orange-500 to-amber-600 rounded-xl flex items-center justify-center shadow-lg">
                                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="text-base sm:text-lg font-bold text-gray-900 dark:text-white">Parent Information</h3>
                                    <p class="text-xs text-gray-600 dark:text-gray-400">Guardian details</p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="p-5 sm:p-6">
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                                @if($student->father_name)
                                    <div class="group">
                                        <div class="flex items-center gap-2 mb-2">
                                            <svg class="w-4 h-4 text-orange-500 dark:text-orange-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                            </svg>
                                            <label class="text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wide">Father's Name</label>
                                        </div>
                                        <p class="text-sm sm:text-base font-semibold text-gray-900 dark:text-white pl-6">{{ $student->father_name }}</p>
                                    </div>
                                @endif

                                @if($student->mother_name)
                                    <div class="group">
                                        <div class="flex items-center gap-2 mb-2">
                                            <svg class="w-4 h-4 text-amber-500 dark:text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                            </svg>
                                            <label class="text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wide">Mother's Name</label>
                                        </div>
                                        <p class="text-sm sm:text-base font-semibold text-gray-900 dark:text-white pl-6">{{ $student->mother_name }}</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                @endif

            </div>

            <!-- Right Column (Enrollments & Stats) -->
            <div class="space-y-4 sm:space-y-6">
                
                <!-- Course Enrollments Card -->
                <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl overflow-hidden border border-gray-200 dark:border-gray-700">
                    <div class="bg-gradient-to-r from-blue-50 to-indigo-50 dark:from-blue-900/20 dark:to-indigo-900/20 px-5 py-4 border-b border-gray-200 dark:border-gray-700">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-xl flex items-center justify-center shadow-lg">
                                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="text-base font-bold text-gray-900 dark:text-white">Enrollments</h3>
                                    <p class="text-xs text-gray-600 dark:text-gray-400">Active courses</p>
                                </div>
                            </div>
                            <a href="{{ route('partner.enrollments.create', ['student_id' => $student->id]) }}" 
                               class="inline-flex items-center gap-1 px-3 py-1.5 bg-gradient-to-r from-green-500 to-emerald-600 hover:from-green-600 hover:to-emerald-700 text-white text-xs font-bold rounded-lg shadow-md hover:shadow-lg transition-all duration-200 transform hover:scale-105">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                </svg>
                                <span>Add</span>
                            </a>
                        </div>
                    </div>
                    
                    <div class="p-4">
                        @php
                            $activeEnrollments = $student->enrollments()->where('status', 'active')->with(['course', 'batch'])->get();
                        @endphp
                        
                        @if($activeEnrollments->count() > 0)
                            <div class="space-y-3">
                                @foreach($activeEnrollments as $enrollment)
                                    <div class="p-4 bg-gradient-to-br from-blue-50 to-indigo-50 dark:from-blue-900/10 dark:to-indigo-900/10 rounded-xl border border-blue-200 dark:border-blue-800 hover:shadow-md transition-all duration-200">
                                        <div class="flex items-start justify-between gap-3 mb-2">
                                            <h4 class="text-sm font-bold text-gray-900 dark:text-white flex-1">
                                                {{ $enrollment->course->name }}
                                            </h4>
                                            <span class="inline-flex px-2 py-0.5 bg-green-500 text-white text-xs font-bold rounded-full flex-shrink-0">
                                                Active
                                            </span>
                                        </div>
                                        
                                        @if($enrollment->batch)
                                            <div class="flex items-center gap-1.5 text-xs text-gray-600 dark:text-gray-400 mb-2">
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                                                </svg>
                                                <span class="font-semibold">{{ $enrollment->batch->name }} ({{ $enrollment->batch->year }})</span>
                                            </div>
                                        @endif
                                        
                                        <div class="flex items-center gap-1.5 text-xs text-gray-500 dark:text-gray-400">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                            </svg>
                                            <span>Enrolled: {{ $enrollment->enrolled_at->format('M d, Y') }}</span>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-8">
                                <div class="w-16 h-16 bg-gray-100 dark:bg-gray-700 rounded-full flex items-center justify-center mx-auto mb-3">
                                    <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                    </svg>
                                </div>
                                <p class="text-sm text-gray-600 dark:text-gray-400 mb-3">No active enrollments</p>
                                <a href="{{ route('partner.enrollments.create', ['student_id' => $student->id]) }}" 
                                   class="inline-flex items-center gap-2 px-4 py-2 bg-gradient-to-r from-blue-500 to-indigo-600 hover:from-blue-600 hover:to-indigo-700 text-white text-sm font-semibold rounded-lg shadow-md hover:shadow-lg transition-all duration-200">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                    </svg>
                                    Enroll Now
                                </a>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Quick Stats Card -->
                <div class="bg-gradient-to-br from-pink-500 via-purple-500 to-indigo-500 rounded-2xl p-6 shadow-xl text-white">
                    <div class="flex items-center gap-3 mb-4">
                        <div class="w-10 h-10 bg-white/20 backdrop-blur-md rounded-xl flex items-center justify-center">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-base font-bold">Quick Stats</h3>
                            <p class="text-xs text-white/80">At a glance</p>
                        </div>
                    </div>
                    
                    <div class="space-y-3">
                        <div class="flex items-center justify-between p-3 bg-white/10 backdrop-blur-md rounded-xl">
                            <span class="text-sm font-semibold">Total Enrollments</span>
                            <span class="text-lg font-black">{{ $student->enrollments()->count() }}</span>
                        </div>
                        <div class="flex items-center justify-between p-3 bg-white/10 backdrop-blur-md rounded-xl">
                            <span class="text-sm font-semibold">Active Courses</span>
                            <span class="text-lg font-black">{{ $activeEnrollments->count() }}</span>
                        </div>
                        @php
                            $completedCount = $student->enrollments()->where('status', 'completed')->count();
                        @endphp
                        <div class="flex items-center justify-between p-3 bg-white/10 backdrop-blur-md rounded-xl">
                            <span class="text-sm font-semibold">Completed</span>
                            <span class="text-lg font-black">{{ $completedCount }}</span>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <!-- Exam Results Section (Full Width) -->
        @if($student->examResults && $student->examResults->count() > 0)
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl overflow-hidden border border-gray-200 dark:border-gray-700">
                <div class="bg-gradient-to-r from-orange-50 to-amber-50 dark:from-orange-900/20 dark:to-amber-900/20 px-5 py-4 border-b border-gray-200 dark:border-gray-700">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-gradient-to-br from-orange-500 to-amber-600 rounded-xl flex items-center justify-center shadow-lg">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-base sm:text-lg font-bold text-gray-900 dark:text-white">Exam Results</h3>
                            <p class="text-xs text-gray-600 dark:text-gray-400">Performance overview</p>
                        </div>
                    </div>
                </div>
                
                <div class="p-5 sm:p-6">
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                        @foreach($student->examResults as $result)
                            <div class="p-5 bg-gradient-to-br from-gray-50 to-gray-100 dark:from-gray-700 dark:to-gray-800 rounded-xl border border-gray-200 dark:border-gray-600 hover:shadow-lg transition-all duration-200">
                                <div class="flex items-start justify-between mb-3">
                                    <div class="flex-1">
                                        <h4 class="text-sm font-bold text-gray-900 dark:text-white mb-1">{{ $result->exam->title }}</h4>
                                        <p class="text-xs text-gray-600 dark:text-gray-400 flex items-center gap-1">
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                            </svg>
                                            {{ $result->created_at->format('M d, Y') }}
                                        </p>
                                    </div>
                                    <div class="flex-shrink-0 w-14 h-14 bg-gradient-to-br from-orange-500 to-amber-600 rounded-xl flex items-center justify-center shadow-lg">
                                        <span class="text-white font-black text-lg">{{ $result->score ?? 'N/A' }}</span>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        @endif

    </div>
</div>
@endsection
