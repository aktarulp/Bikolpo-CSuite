@extends('layouts.partner-layout')

@section('title', 'Assignment Details')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-50 via-orange-50/30 to-gray-50 dark:from-gray-900 dark:via-gray-800 dark:to-gray-900 py-4 sm:py-6 lg:py-8 px-4 sm:px-6 lg:px-8">
    <div class="max-w-5xl mx-auto space-y-4 sm:space-y-6 animate-fade-in">
        
        {{-- Header Section --}}
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div class="flex items-center gap-3">
                <a href="{{ route('partner.enrollments.index') }}" 
                   class="flex-shrink-0 w-10 h-10 flex items-center justify-center rounded-xl bg-white dark:bg-gray-800 border-2 border-gray-200 dark:border-gray-700 hover:border-orange-500 dark:hover:border-orange-500 transition-all duration-200 hover:scale-110 shadow-sm">
                    <svg class="w-5 h-5 text-gray-600 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                </a>
                <div>
                    <h1 class="text-2xl sm:text-3xl font-extrabold text-gray-900 dark:text-white">
                        Assignment Details
                    </h1>
                    <p class="text-sm text-gray-500 dark:text-gray-400 mt-0.5">
                        View enrollment information and progress
                    </p>
                </div>
            </div>
            
            <div class="flex flex-wrap gap-2">
                <a href="{{ route('partner.enrollments.edit', $enrollment) }}" 
                   class="inline-flex items-center px-4 py-2.5 bg-gradient-to-r from-orange-500 to-orange-600 hover:from-orange-600 hover:to-orange-700 text-white text-sm font-semibold rounded-xl transition-all duration-200 shadow-md hover:shadow-lg hover:scale-105">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                    </svg>
                    Edit
                </a>
            </div>
        </div>

        @if(session('success'))
        <div class="bg-gradient-to-r from-green-50 to-emerald-50 dark:from-green-900/20 dark:to-emerald-900/20 border-l-4 border-green-500 p-4 rounded-xl shadow-sm">
            <div class="flex items-center">
                <svg class="w-5 h-5 text-green-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <p class="text-sm font-medium text-green-800 dark:text-green-300">{{ session('success') }}</p>
            </div>
        </div>
        @endif

        {{-- Status Badge - Large and prominent --}}
        <div class="p-6 rounded-2xl text-white shadow-xl transition-all duration-300 hover:scale-[1.02]
                    @if($enrollment->status === 'active') bg-gradient-to-r from-green-500 to-emerald-600 @endif
                    @if($enrollment->status === 'completed') bg-gradient-to-r from-blue-500 to-indigo-600 @endif
                    @if($enrollment->status === 'dropped') bg-gradient-to-r from-red-500 to-pink-600 @endif
                    @if($enrollment->status === 'suspended') bg-gradient-to-r from-yellow-500 to-amber-600 @endif
                    @if($enrollment->status === 'transferred') bg-gradient-to-r from-purple-500 to-violet-600 @endif">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-4">
                    <div class="w-16 h-16 bg-white/20 backdrop-blur rounded-2xl flex items-center justify-center">
                        @if($enrollment->status === 'active')
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                            </svg>
                        @elseif($enrollment->status === 'completed')
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        @elseif($enrollment->status === 'dropped')
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        @elseif($enrollment->status === 'suspended')
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 9v6m4-6v6m7-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        @else
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"></path>
                            </svg>
                        @endif
                    </div>
                    <div>
                        <p class="text-sm font-medium text-white/80">Current Status</p>
                        <h2 class="text-2xl sm:text-3xl font-bold text-white capitalize mt-1">{{ $enrollment->status }}</h2>
                        @if($enrollment->enrolledBy)
                        <p class="text-xs text-white/70 mt-2">
                            Enrolled by: <span class="font-semibold">{{ $enrollment->enrolledBy->name ?? $enrollment->enrolledBy->username ?? 'System' }}</span>
                        </p>
                        @endif
                    </div>
                </div>
                <div class="hidden sm:block w-3 h-3 bg-white rounded-full animate-pulse"></div>
            </div>
        </div>

        {{-- Main Content Grid --}}
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-4 sm:gap-6">
            
            {{-- Left Column - Student & Course Info --}}
            <div class="lg:col-span-2 space-y-4 sm:space-y-6">
                
                {{-- Student Information Card --}}
                <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-md overflow-hidden border border-gray-100 dark:border-gray-700 transition-all duration-300 hover:shadow-lg hover:-translate-y-1">
                    <div class="bg-gradient-to-r from-emerald-500 to-green-600 px-6 py-4">
                        <div class="flex items-center gap-3">
                            <div class="w-12 h-12 bg-white/20 backdrop-blur rounded-xl flex items-center justify-center">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                            </div>
                            <h3 class="text-lg font-bold text-white">Student Information</h3>
                        </div>
                    </div>
                    <div class="p-6 space-y-4">
                        <div class="flex items-start gap-4">
                            <div class="flex-shrink-0 w-16 h-16 sm:w-20 sm:h-20 rounded-2xl bg-gradient-to-br from-emerald-100 to-green-100 dark:from-emerald-900/30 dark:to-green-900/30 flex items-center justify-center border-2 border-emerald-200 dark:border-emerald-700 overflow-hidden">
                                @if($enrollment->student->photo)
                                    <img src="{{ asset('uploads/' . $enrollment->student->photo) }}" alt="{{ $enrollment->student->full_name }}" class="w-full h-full object-cover">
                                @else
                                    <svg class="w-10 h-10 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                    </svg>
                                @endif
                            </div>
                            <div class="flex-1 min-w-0">
                                <h4 class="text-xl font-bold text-gray-900 dark:text-white truncate">{{ $enrollment->student->full_name }}</h4>
                                <p class="text-sm text-gray-500 dark:text-gray-400">ID: {{ $enrollment->student->student_id }}</p>
                                @if($enrollment->student->email)
                                <p class="text-sm text-emerald-600 dark:text-emerald-400 mt-1 truncate">{{ $enrollment->student->email }}</p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Course Information Card --}}
                <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-md overflow-hidden border border-gray-100 dark:border-gray-700 transition-all duration-300 hover:shadow-lg hover:-translate-y-1">
                    <div class="bg-gradient-to-r from-orange-500 to-amber-600 px-6 py-4">
                        <div class="flex items-center gap-3">
                            <div class="w-12 h-12 bg-white/20 backdrop-blur rounded-xl flex items-center justify-center">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                </svg>
                            </div>
                            <h3 class="text-lg font-bold text-white">Course Details</h3>
                        </div>
                    </div>
                    <div class="p-6 space-y-4">
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <p class="text-xs text-gray-500 dark:text-gray-400 uppercase tracking-wide font-semibold">Course Name</p>
                                <h4 class="text-lg font-bold text-gray-900 dark:text-white mt-1">{{ $enrollment->course->name }}</h4>
                            </div>
                            <div>
                                <p class="text-xs text-gray-500 dark:text-gray-400 uppercase tracking-wide font-semibold">Course Code</p>
                                <p class="text-base font-semibold text-orange-600 dark:text-orange-400 mt-1">{{ $enrollment->course->code ?? 'N/A' }}</p>
                            </div>
                        </div>
                        @if($enrollment->batch)
                        <div class="pt-4 border-t border-gray-100 dark:border-gray-700">
                            <p class="text-xs text-gray-500 dark:text-gray-400 uppercase tracking-wide font-semibold">Assigned Batch</p>
                            <div class="flex items-center gap-2 mt-2">
                                <div class="w-8 h-8 bg-orange-100 dark:bg-orange-900/30 rounded-lg flex items-center justify-center">
                                    <svg class="w-4 h-4 text-orange-600 dark:text-orange-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                    </svg>
                                </div>
                                <p class="text-base font-bold text-gray-900 dark:text-white">{{ $enrollment->batch->name }}</p>
                            </div>
                        </div>
                        @else
                        <div class="pt-4 border-t border-gray-100 dark:border-gray-700">
                            <p class="text-xs text-gray-500 dark:text-gray-400 uppercase tracking-wide font-semibold">Assigned Batch</p>
                            <p class="text-sm text-gray-400 dark:text-gray-500 italic mt-2">No batch assigned</p>
                        </div>
                        @endif
                    </div>
                </div>

                {{-- Grades & Completion --}}
                @if($enrollment->status === 'completed')
                <div class="bg-gradient-to-br from-blue-50 to-indigo-50 dark:from-blue-900/20 dark:to-indigo-900/20 rounded-2xl shadow-md p-6 border border-blue-200 dark:border-blue-800 transition-all duration-300 hover:shadow-lg">
                    <div class="flex items-center gap-3 mb-4">
                        <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-xl flex items-center justify-center">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"></path>
                            </svg>
                        </div>
                        <h3 class="text-lg font-bold text-gray-900 dark:text-white">Final Results</h3>
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div class="bg-white dark:bg-gray-800 rounded-xl p-4 text-center shadow-sm">
                            <p class="text-xs text-gray-500 dark:text-gray-400 uppercase font-semibold">Final Grade</p>
                            <p class="text-3xl font-extrabold text-blue-600 dark:text-blue-400 mt-2">{{ $enrollment->final_grade ?? 'N/A' }}</p>
                        </div>
                        <div class="bg-white dark:bg-gray-800 rounded-xl p-4 text-center shadow-sm">
                            <p class="text-xs text-gray-500 dark:text-gray-400 uppercase font-semibold">Grade Letter</p>
                            <p class="text-3xl font-extrabold text-indigo-600 dark:text-indigo-400 mt-2">{{ $enrollment->grade_letter ?? 'N/A' }}</p>
                        </div>
                    </div>
                    @if($enrollment->completion_date)
                    <div class="mt-4 pt-4 border-t border-blue-200 dark:border-blue-800">
                        <p class="text-xs text-gray-500 dark:text-gray-400 uppercase font-semibold">Completed On</p>
                        <p class="text-base font-bold text-gray-900 dark:text-white mt-1">{{ $enrollment->completion_date->format('F d, Y') }}</p>
                    </div>
                    @endif
                </div>
                @endif

                {{-- Remarks --}}
                @if($enrollment->remarks)
                <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-md p-6 border border-gray-100 dark:border-gray-700 transition-all duration-300 hover:shadow-lg">
                    <div class="flex items-center gap-3 mb-4">
                        <div class="w-10 h-10 bg-gradient-to-br from-purple-100 to-pink-100 dark:from-purple-900/30 dark:to-pink-900/30 rounded-xl flex items-center justify-center">
                            <svg class="w-5 h-5 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"></path>
                            </svg>
                        </div>
                        <h3 class="text-base font-bold text-gray-900 dark:text-white">Remarks</h3>
                    </div>
                    <p class="text-sm text-gray-600 dark:text-gray-300 leading-relaxed">{{ $enrollment->remarks }}</p>
                </div>
                @endif

            </div>

            {{-- Right Column - Timeline & Meta Info --}}
            <div class="lg:col-span-1 space-y-4 sm:space-y-6">
                
                {{-- Timeline Card --}}
                <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-md p-6 border border-gray-100 dark:border-gray-700">
                    <h3 class="text-base font-bold text-gray-900 dark:text-white mb-6 flex items-center gap-2">
                        <svg class="w-5 h-5 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Timeline
                    </h3>
                    
                    <div class="space-y-6 relative before:absolute before:left-2 before:top-3 before:bottom-3 before:w-0.5 before:bg-gradient-to-b before:from-orange-200 before:via-orange-300 before:to-orange-200 dark:before:from-orange-800 dark:before:via-orange-700 dark:before:to-orange-800">
                        
                        {{-- Enrolled Date --}}
                        <div class="relative pl-8">
                            <div class="absolute left-0 top-1 w-4 h-4 bg-gradient-to-br from-orange-500 to-orange-600 rounded-full border-2 border-white dark:border-gray-800 shadow-sm"></div>
                            <p class="text-xs text-gray-500 dark:text-gray-400 font-semibold">Enrolled</p>
                            <p class="text-sm font-bold text-gray-900 dark:text-white mt-0.5">{{ $enrollment->enrolled_at->format('M d, Y') }}</p>
                        </div>
                        
                        {{-- Enrolled By --}}
                        @if($enrollment->enrolledBy)
                        <div class="relative pl-8">
                            <div class="absolute left-0 top-1 w-4 h-4 bg-gradient-to-br from-purple-500 to-purple-600 rounded-full border-2 border-white dark:border-gray-800 shadow-sm"></div>
                            <p class="text-xs text-gray-500 dark:text-gray-400 font-semibold">Enrolled By</p>
                            <p class="text-sm font-bold text-gray-900 dark:text-white mt-0.5">{{ $enrollment->enrolledBy->name ?? $enrollment->enrolledBy->username ?? 'System' }}</p>
                        </div>
                        @endif
                        
                        {{-- Updated By (if different from enrolled by) --}}
                        @if($enrollment->updatedBy && $enrollment->updatedBy->id !== $enrollment->enrolledBy?->id)
                        <div class="relative pl-8">
                            <div class="absolute left-0 top-1 w-4 h-4 bg-gradient-to-br from-indigo-500 to-indigo-600 rounded-full border-2 border-white dark:border-gray-800 shadow-sm"></div>
                            <p class="text-xs text-gray-500 dark:text-gray-400 font-semibold">Last Updated By</p>
                            <p class="text-sm font-bold text-gray-900 dark:text-white mt-0.5">{{ $enrollment->updatedBy->name ?? $enrollment->updatedBy->username ?? 'System' }}</p>
                        </div>
                        @endif
                        
                        {{-- Completion Date if completed --}}
                        @if($enrollment->completion_date)
                        <div class="relative pl-8">
                            <div class="absolute left-0 top-1 w-4 h-4 bg-gradient-to-br from-blue-500 to-blue-600 rounded-full border-2 border-white dark:border-gray-800 shadow-sm"></div>
                            <p class="text-xs text-gray-500 dark:text-gray-400 font-semibold">Completed</p>
                            <p class="text-sm font-bold text-gray-900 dark:text-white mt-0.5">{{ $enrollment->completion_date->format('M d, Y') }}</p>
                        </div>
                        @endif
                        
                        {{-- Transfer info if transferred --}}
                        @if($enrollment->status === 'transferred' && $enrollment->transferred_at)
                        <div class="relative pl-8">
                            <div class="absolute left-0 top-1 w-4 h-4 bg-gradient-to-br from-purple-500 to-purple-600 rounded-full border-2 border-white dark:border-gray-800 shadow-sm"></div>
                            <p class="text-xs text-gray-500 dark:text-gray-400 font-semibold">Transferred</p>
                            <p class="text-sm font-bold text-gray-900 dark:text-white mt-0.5">{{ $enrollment->transferred_at->format('M d, Y') }}</p>
                        </div>
                        @endif
                        
                    </div>
                </div>

                {{-- Meta Information --}}
                <div class="bg-gradient-to-br from-gray-50 to-gray-100 dark:from-gray-800 dark:to-gray-700 rounded-2xl shadow-md p-6 border border-gray-200 dark:border-gray-600">
                    <h3 class="text-base font-bold text-gray-900 dark:text-white mb-4 flex items-center gap-2">
                        <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Meta Information
                    </h3>
                    
                    <div class="space-y-3 text-sm">
                        @if($enrollment->enrolledBy)
                        <div class="flex justify-between items-start gap-2">
                            <span class="text-gray-500 dark:text-gray-400">Enrolled by:</span>
                            <span class="font-semibold text-gray-900 dark:text-white text-right">{{ $enrollment->enrolledBy->full_name }}</span>
                        </div>
                        @endif
                        
                        @if($enrollment->updatedBy)
                        <div class="flex justify-between items-start gap-2">
                            <span class="text-gray-500 dark:text-gray-400">Updated by:</span>
                            <span class="font-semibold text-gray-900 dark:text-white text-right">{{ $enrollment->updatedBy->full_name }}</span>
                        </div>
                        @endif
                        
                        <div class="flex justify-between items-start gap-2">
                            <span class="text-gray-500 dark:text-gray-400">Created:</span>
                            <span class="font-semibold text-gray-900 dark:text-white text-right">{{ $enrollment->created_at->format('M d, Y') }}</span>
                        </div>
                        
                        <div class="flex justify-between items-start gap-2">
                            <span class="text-gray-500 dark:text-gray-400">Last updated:</span>
                            <span class="font-semibold text-gray-900 dark:text-white text-right">{{ $enrollment->updated_at->diffForHumans() }}</span>
                        </div>
                    </div>
                </div>

                {{-- Quick Actions --}}
                <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-md p-6 border border-gray-100 dark:border-gray-700">
                    <h3 class="text-base font-bold text-gray-900 dark:text-white mb-4 flex items-center gap-2">
                        <svg class="w-5 h-5 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                        </svg>
                        Quick Actions
                    </h3>
                    
                    <div class="space-y-2">
                        <a href="{{ route('partner.students.show', $enrollment->student) }}" 
                           class="flex items-center justify-between w-full px-4 py-3 bg-gradient-to-r from-emerald-50 to-green-50 dark:from-emerald-900/20 dark:to-green-900/20 hover:from-emerald-100 hover:to-green-100 dark:hover:from-emerald-900/30 dark:hover:to-green-900/30 text-emerald-700 dark:text-emerald-400 rounded-xl transition-all duration-200 border border-emerald-200 dark:border-emerald-800">
                            <span class="text-sm font-semibold">View Student</span>
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                        </a>
                        
                        <a href="{{ route('partner.courses.index') }}" 
                           class="flex items-center justify-between w-full px-4 py-3 bg-gradient-to-r from-orange-50 to-amber-50 dark:from-orange-900/20 dark:to-amber-900/20 hover:from-orange-100 hover:to-amber-100 dark:hover:from-orange-900/30 dark:hover:to-amber-900/30 text-orange-700 dark:text-orange-400 rounded-xl transition-all duration-200 border border-orange-200 dark:border-orange-800">
                            <span class="text-sm font-semibold">View All Courses</span>
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                        </a>
                    </div>
                </div>

            </div>
        </div>

    </div>
</div>
@endsection
