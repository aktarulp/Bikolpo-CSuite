@extends('layouts.student-layout')

@section('title', 'My Profile')

@section('content')
<!-- Main Container with Premium Background -->
<div class="min-h-screen relative overflow-x-hidden bg-gradient-to-br from-slate-50 via-blue-50 to-indigo-100 dark:from-slate-950 dark:via-slate-900 dark:to-indigo-950">
    <!-- Animated Background Pattern -->
    <div class="absolute inset-0 bg-grid-slate-900/[0.02] dark:bg-grid-white/[0.02] bg-[size:60px_60px]"></div>
    
    <!-- Decorative Blobs (Properly positioned within viewport) -->
    <div class="absolute top-0 right-0 w-64 h-64 sm:w-80 sm:h-80 bg-gradient-to-br from-blue-400 to-indigo-600 rounded-full opacity-10 blur-3xl transform translate-x-1/3 -translate-y-1/3"></div>
    <div class="absolute bottom-0 left-0 w-64 h-64 sm:w-80 sm:h-80 bg-gradient-to-tr from-emerald-400 to-cyan-600 rounded-full opacity-10 blur-3xl transform -translate-x-1/3 translate-y-1/3"></div>
    
    <div class="relative max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Premium Page Header -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-10">
            <div class="flex items-center gap-4">
                <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-blue-600 via-indigo-600 to-purple-600 flex items-center justify-center shadow-xl shadow-blue-500/30">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                    </svg>
                </div>
            <div>
                    <h1 class="text-3xl sm:text-4xl font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-blue-600 via-indigo-600 to-purple-600 dark:from-blue-400 dark:via-indigo-400 dark:to-purple-400">
                        My Profile
                    </h1>
                    <p class="text-slate-600 dark:text-slate-400 mt-1">Your academic journey at a glance</p>
                </div>
            </div>
            <div class="flex items-center gap-3">
                <a href="{{ route('student.profile.edit') }}" 
                   class="inline-flex items-center gap-2 px-5 py-2.5 bg-gradient-to-r from-emerald-600 to-green-600 hover:from-emerald-700 hover:to-green-700 text-white font-semibold rounded-xl shadow-lg shadow-emerald-500/30 hover:shadow-xl hover:shadow-emerald-500/40 transition-all duration-300 hover:-translate-y-0.5">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                    </svg>
                    <span>Edit Profile</span>
                </a>
            <a href="{{ route('student.dashboard') }}" 
                   class="inline-flex items-center gap-2 px-5 py-2.5 bg-white/80 dark:bg-slate-800/80 backdrop-blur-sm hover:bg-white dark:hover:bg-slate-800 text-slate-700 dark:text-slate-300 font-semibold rounded-xl border border-slate-200 dark:border-slate-700 shadow-sm hover:shadow-md transition-all duration-300 hover:-translate-y-0.5">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                    <span>Dashboard</span>
            </a>
            </div>
        </div>

        <!-- Ultra Premium Profile Hero Card -->
        <div class="relative mb-8 group">
            <!-- Main Card with 3D Effect -->
            <div class="relative bg-white dark:bg-slate-900 rounded-3xl shadow-2xl overflow-hidden border border-slate-200/50 dark:border-slate-700/50 transition-all duration-500 hover:shadow-3xl hover:-translate-y-1">
                
                <!-- Premium Gradient Header with Patterns -->
                <div class="relative h-72 bg-gradient-to-br from-blue-600 via-indigo-600 to-purple-700 overflow-hidden">
                    <!-- Animated Pattern Overlay -->
                    <div class="absolute inset-0 bg-grid-white/5 bg-[size:30px_30px]"></div>
                    <div class="absolute inset-0 bg-gradient-to-t from-black/20 to-transparent"></div>
                    
                    <!-- Floating Decorative Circles (Contained within bounds) -->
                    <div class="absolute top-4 right-4 w-32 h-32 bg-white/10 rounded-full blur-2xl animate-pulse"></div>
                    <div class="absolute bottom-4 left-4 w-40 h-40 bg-indigo-300/10 rounded-full blur-3xl animate-pulse" style="animation-delay: 1s;"></div>
                    <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-48 h-48 bg-purple-400/10 rounded-full blur-3xl animate-pulse" style="animation-delay: 0.5s;"></div>
                    
                    <!-- Glass Morphism Icons -->
                    <div class="absolute top-8 right-8 flex flex-col gap-3">
                        <!-- Share Button -->
                        <button onclick="shareProfile()" class="group/btn w-12 h-12 rounded-xl bg-white/10 backdrop-blur-md border border-white/20 flex items-center justify-center hover:bg-white/20 transition-all duration-300 hover:scale-110">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z"></path>
                            </svg>
                        </button>
                        <!-- Download Button -->
                        <button onclick="window.print()" class="group/btn w-12 h-12 rounded-xl bg-white/10 backdrop-blur-md border border-white/20 flex items-center justify-center hover:bg-white/20 transition-all duration-300 hover:scale-110">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                            </svg>
                        </button>
                    </div>
                    
                    <!-- Profile Info Section -->
                    <div class="relative h-full flex flex-col justify-end p-8 sm:p-10">
                        <div class="flex flex-col sm:flex-row items-center sm:items-end gap-6 sm:gap-8">
                            <!-- Stunning Circular Profile Picture with Premium Effects -->
                            <div class="relative flex-shrink-0 group/avatar" style="padding: 20px;">
                                <!-- Outermost Animated Glow Ring (Contained) -->
                                <div class="absolute inset-2 rounded-full bg-gradient-to-tr from-blue-400 via-purple-400 to-pink-400 opacity-20 blur-xl group-hover/avatar:opacity-30 transition-opacity duration-500 animate-pulse"></div>
                                
                                <!-- Rotating Gradient Ring (Contained) -->
                                <div class="absolute inset-3 rounded-full bg-gradient-to-r from-blue-500 via-purple-500 to-pink-500 opacity-25 blur-lg group-hover/avatar:blur-xl transition-all duration-500"></div>
                                
                                <!-- Middle Glass Ring with Gradient -->
                                <div class="relative w-32 h-32 sm:w-40 sm:h-40 rounded-full bg-gradient-to-br from-white/40 via-white/20 to-white/10 p-2 backdrop-blur-md shadow-2xl group-hover/avatar:shadow-3xl group-hover/avatar:scale-105 transition-all duration-500">
                                    
                                    <!-- Secondary Inner Ring -->
                                    <div class="w-full h-full rounded-full bg-gradient-to-br from-white/30 to-transparent p-1.5 shadow-inner">
                                        
                                        <!-- Main Photo Container -->
                                        <div class="relative w-full h-full rounded-full overflow-hidden ring-4 ring-white/60 group-hover/avatar:ring-white/80 transition-all duration-500 shadow-xl">
                                @if($student->photo)
                                                <img src="{{ asset('storage/' . $student->photo) }}" 
                                                     alt="{{ $student->full_name }}" 
                                                     class="w-full h-full object-cover group-hover/avatar:scale-110 transition-transform duration-700">
                                @else
                                                <div class="w-full h-full bg-gradient-to-br from-blue-400 via-indigo-500 to-purple-600 flex items-center justify-center relative overflow-hidden">
                                                    <!-- Animated Background Gradient -->
                                                    <div class="absolute inset-0 bg-gradient-to-tr from-transparent via-white/10 to-transparent animate-pulse"></div>
                                                    <span class="relative text-5xl sm:text-6xl font-extrabold text-white drop-shadow-2xl">
                                        {{ strtoupper(substr($student->full_name, 0, 1)) }}
                                    </span>
                                                </div>
                                @endif
                                            
                                            <!-- Shine Effect Overlay -->
                                            <div class="absolute inset-0 bg-gradient-to-tr from-transparent via-white/20 to-transparent opacity-0 group-hover/avatar:opacity-100 transition-opacity duration-500"></div>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Premium Verified Badge with Pulse Animation -->
                                <div class="absolute bottom-4 right-4 sm:bottom-3 sm:right-3">
                                    <div class="relative">
                                        <!-- Badge Glow (Reduced) -->
                                        <div class="absolute inset-0 rounded-full bg-emerald-400 blur-sm opacity-40 animate-pulse"></div>
                                        <!-- Badge Container -->
                                        <div class="relative w-12 h-12 sm:w-14 sm:h-14 rounded-full bg-gradient-to-br from-emerald-400 via-green-500 to-emerald-600 border-4 border-white dark:border-blue-900 flex items-center justify-center shadow-xl group-hover/avatar:scale-110 group-hover/avatar:rotate-12 transition-all duration-500">
                                            <svg class="w-6 h-6 sm:w-7 sm:h-7 text-white drop-shadow-lg" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path>
                                            </svg>
                                            <!-- Sparkle Effect (Contained) -->
                                            <div class="absolute top-0 right-0 w-2 h-2 bg-white rounded-full opacity-70 animate-ping"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Student Information -->
                            <div class="flex-1 text-center sm:text-left text-white mb-4">
                                <div class="flex flex-col sm:flex-row sm:items-end gap-3 mb-3">
                                    <h2 class="text-3xl sm:text-4xl font-extrabold drop-shadow-lg">
                                        {{ $student->full_name }}
                                    </h2>
                                    <!-- Premium Badge -->
                                    <span class="inline-flex items-center gap-1.5 px-4 py-1.5 rounded-full bg-gradient-to-r from-amber-400 to-orange-500 text-white text-sm font-bold shadow-lg">
                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                            </svg>
                                        <span>Student</span>
                                    </span>
                    </div>
                    
                                <!-- Course & Details -->
                                <div class="flex flex-col gap-2">
                                    <p class="text-lg sm:text-xl font-semibold text-white/95 flex items-center justify-center sm:justify-start gap-2">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                            </svg>
                                        {{ $student->course->name ?? 'Not Enrolled' }}
                                    </p>
                                    
                                    <!-- Info Pills -->
                                    <div class="flex flex-wrap items-center gap-3 justify-center sm:justify-start">
                                        <span class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-white/15 backdrop-blur-md border border-white/20 text-sm font-medium">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2"></path>
                                            </svg>
                                            ID: <span class="font-mono font-bold">{{ $student->student_id }}</span>
                                        </span>
                                        <span class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-white/15 backdrop-blur-md border border-white/20 text-sm font-medium">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                            </svg>
                                {{ $student->batch->name ?? 'No Batch' }}
                            </span>
                                        <span class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-white/15 backdrop-blur-md border border-white/20 text-sm font-medium">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                            </svg>
                                {{ ucfirst($student->gender) }}
                            </span>
                                    </div>
                                </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Premium Stats Section -->
            <div class="p-8 sm:p-10">
                <div class="flex items-center justify-between mb-8">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-blue-500 to-indigo-600 flex items-center justify-center">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                    </svg>
                        </div>
                        <div>
                            <h3 class="text-2xl font-extrabold text-slate-900 dark:text-white">
                    Academic Performance
                </h3>
                            <p class="text-sm text-slate-600 dark:text-slate-400">Your exam statistics at a glance</p>
                        </div>
                    </div>
                </div>
                
                <!-- Ultra Premium Stats Grid -->
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5 mb-10">
                    <!-- Exams Taken - Premium Card -->
                    <div class="group relative bg-gradient-to-br from-blue-500 to-indigo-600 rounded-2xl p-6 shadow-xl hover:shadow-2xl transition-all duration-500 hover:-translate-y-1 overflow-hidden">
                        <!-- Decorative Background (Contained) -->
                        <div class="absolute top-0 right-0 w-20 h-20 bg-white/10 rounded-full -translate-y-4 translate-x-4 group-hover:scale-125 transition-transform duration-500"></div>
                        <div class="absolute bottom-0 left-0 w-16 h-16 bg-white/10 rounded-full translate-y-4 -translate-x-4 group-hover:scale-125 transition-transform duration-500"></div>
                        
                        <div class="relative z-10">
                            <div class="flex items-start justify-between mb-4">
                                <div class="w-14 h-14 rounded-2xl bg-white/20 backdrop-blur-md flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform duration-300">
                                    <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                    </svg>
                                </div>
                                <div class="px-3 py-1 rounded-lg bg-white/20 backdrop-blur-sm">
                                    <p class="text-white text-xs font-semibold">Total</p>
                                </div>
                            </div>
                            <h4 class="text-5xl font-extrabold text-white mb-2">{{ $examStats['total'] }}</h4>
                            <p class="text-white/90 text-sm font-medium">Exams Taken</p>
                            <div class="mt-4 flex items-center gap-2 text-white/80 text-xs">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                                </svg>
                                <span>Journey started</span>
                            </div>
                        </div>
                    </div>

                    <!-- Passed Exams - Premium Card -->
                    <div class="group relative bg-gradient-to-br from-emerald-500 to-green-600 rounded-2xl p-6 shadow-xl hover:shadow-2xl transition-all duration-500 hover:-translate-y-1 overflow-hidden">
                        <!-- Decorative Background (Contained) -->
                        <div class="absolute top-0 right-0 w-20 h-20 bg-white/10 rounded-full -translate-y-4 translate-x-4 group-hover:scale-125 transition-transform duration-500"></div>
                        <div class="absolute bottom-0 left-0 w-16 h-16 bg-white/10 rounded-full translate-y-4 -translate-x-4 group-hover:scale-125 transition-transform duration-500"></div>
                        
                        <div class="relative z-10">
                            <div class="flex items-start justify-between mb-4">
                                <div class="w-14 h-14 rounded-2xl bg-white/20 backdrop-blur-md flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform duration-300">
                                    <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                                <div class="px-3 py-1 rounded-lg bg-white/20 backdrop-blur-sm">
                                    <p class="text-white text-xs font-semibold">
                                        @if($examStats['total'] > 0)
                                            {{ round(($examStats['passed'] / $examStats['total']) * 100) }}%
                                        @else
                                            0%
                                        @endif
                                    </p>
                                </div>
                            </div>
                            <h4 class="text-5xl font-extrabold text-white mb-2">{{ $examStats['passed'] }}</h4>
                            <p class="text-white/90 text-sm font-medium">Exams Passed</p>
                            <div class="mt-4 flex items-center gap-2 text-white/80 text-xs">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <span>Success rate</span>
                            </div>
                        </div>
                    </div>

                    <!-- Average Score - Premium Card -->
                    <div class="group relative bg-gradient-to-br from-amber-500 to-orange-600 rounded-2xl p-6 shadow-xl hover:shadow-2xl transition-all duration-500 hover:-translate-y-1 overflow-hidden">
                        <!-- Decorative Background (Contained) -->
                        <div class="absolute top-0 right-0 w-20 h-20 bg-white/10 rounded-full -translate-y-4 translate-x-4 group-hover:scale-125 transition-transform duration-500"></div>
                        <div class="absolute bottom-0 left-0 w-16 h-16 bg-white/10 rounded-full translate-y-4 -translate-x-4 group-hover:scale-125 transition-transform duration-500"></div>
                        
                        <div class="relative z-10">
                            <div class="flex items-start justify-between mb-4">
                                <div class="w-14 h-14 rounded-2xl bg-white/20 backdrop-blur-md flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform duration-300">
                                    <svg class="w-7 h-7 text-white" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                    </svg>
                                </div>
                                <div class="px-3 py-1 rounded-lg bg-white/20 backdrop-blur-sm">
                                    <p class="text-white text-xs font-semibold">Performance</p>
                                </div>
                            </div>
                            <h4 class="text-5xl font-extrabold text-white mb-2">{{ $examStats['average'] }}<span class="text-3xl">%</span></h4>
                            <p class="text-white/90 text-sm font-medium">Average Score</p>
                            <div class="mt-4 w-full bg-white/20 rounded-full h-2">
                                <div class="bg-white h-2 rounded-full transition-all duration-700" style="width: {{ $examStats['average'] }}%"></div>
                            </div>
                        </div>
                    </div>

                    <!-- Enrollment Duration - Premium Card -->
                    <div class="group relative bg-gradient-to-br from-purple-500 to-pink-600 rounded-2xl p-6 shadow-xl hover:shadow-2xl transition-all duration-500 hover:-translate-y-1 overflow-hidden">
                        <!-- Decorative Background (Contained) -->
                        <div class="absolute top-0 right-0 w-20 h-20 bg-white/10 rounded-full -translate-y-4 translate-x-4 group-hover:scale-125 transition-transform duration-500"></div>
                        <div class="absolute bottom-0 left-0 w-16 h-16 bg-white/10 rounded-full translate-y-4 -translate-x-4 group-hover:scale-125 transition-transform duration-500"></div>
                        
                        <div class="relative z-10">
                            <div class="flex items-start justify-between mb-4">
                                <div class="w-14 h-14 rounded-2xl bg-white/20 backdrop-blur-md flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform duration-300">
                                    <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                </div>
                                <div class="px-3 py-1 rounded-lg bg-white/20 backdrop-blur-sm">
                                    <p class="text-white text-xs font-semibold">Member</p>
                                </div>
                            </div>
                            <h4 class="text-3xl font-extrabold text-white mb-2">
                                @if($student->enroll_date)
                                    {{ $student->enroll_date->format('M Y') }}
                                @else
                                    N/A
                                @endif
                            </h4>
                            <p class="text-white/90 text-sm font-medium">Enrolled Since</p>
                            <div class="mt-4 flex items-center gap-2 text-white/80 text-xs">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <span>
                                    @if($student->enroll_date)
                                        {{ $student->enroll_date->diffForHumans(null, true) }} ago
                                    @else
                                        Not set
                                    @endif
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Premium Achievements & Badges Section -->
                <div class="mb-10">
                    <div class="flex items-center gap-3 mb-6">
                        <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-amber-500 to-orange-600 flex items-center justify-center">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                        </svg>
                        </div>
                        <div>
                            <h3 class="text-2xl font-extrabold text-slate-900 dark:text-white">
                                Achievements & Badges
                    </h3>
                            <p class="text-sm text-slate-600 dark:text-slate-400">Earn badges by completing milestones</p>
                        </div>
                    </div>
                    
                    <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-4">
                        <!-- Top Performer Badge -->
                        @if($examStats['passed'] >= 10)
                            <div class="group relative bg-gradient-to-br from-yellow-400 via-amber-500 to-orange-600 rounded-2xl p-5 shadow-xl hover:shadow-2xl transition-all duration-300 hover:-translate-y-2 hover:rotate-1 overflow-hidden">
                                <div class="absolute inset-0 bg-grid-white/10 bg-[size:20px_20px]"></div>
                                <div class="absolute top-0 right-0 w-16 h-16 bg-white/20 rounded-full -translate-y-8 translate-x-8"></div>
                                <div class="relative flex flex-col items-center text-center">
                                    <div class="w-16 h-16 rounded-full bg-white/20 backdrop-blur-sm flex items-center justify-center mb-3 ring-4 ring-white/30">
                                        <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                    </svg>
                                    </div>
                                    <h4 class="font-extrabold text-white text-sm mb-1">Top Performer</h4>
                                    <p class="text-xs text-white/90">10+ passed</p>
                                </div>
                            </div>
                        @endif
                        
                        <!-- Consistent Badge -->
                        @if($examStats['average'] >= 80)
                            <div class="group relative bg-gradient-to-br from-blue-500 via-indigo-600 to-purple-700 rounded-2xl p-5 shadow-xl hover:shadow-2xl transition-all duration-300 hover:-translate-y-2 hover:rotate-1 overflow-hidden">
                                <div class="absolute inset-0 bg-grid-white/10 bg-[size:20px_20px]"></div>
                                <div class="absolute top-0 right-0 w-16 h-16 bg-white/20 rounded-full -translate-y-8 translate-x-8"></div>
                                <div class="relative flex flex-col items-center text-center">
                                    <div class="w-16 h-16 rounded-full bg-white/20 backdrop-blur-sm flex items-center justify-center mb-3 ring-4 ring-white/30">
                                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    </div>
                                    <h4 class="font-extrabold text-white text-sm mb-1">Consistent</h4>
                                    <p class="text-xs text-white/90">80%+ avg</p>
                                </div>
                            </div>
                        @endif
                        
                        <!-- Dedicated Badge -->
                        @if($examStats['total'] >= 5)
                            <div class="group relative bg-gradient-to-br from-emerald-500 via-green-600 to-teal-700 rounded-2xl p-5 shadow-xl hover:shadow-2xl transition-all duration-300 hover:-translate-y-2 hover:rotate-1 overflow-hidden">
                                <div class="absolute inset-0 bg-grid-white/10 bg-[size:20px_20px]"></div>
                                <div class="absolute top-0 right-0 w-16 h-16 bg-white/20 rounded-full -translate-y-8 translate-x-8"></div>
                                <div class="relative flex flex-col items-center text-center">
                                    <div class="w-16 h-16 rounded-full bg-white/20 backdrop-blur-sm flex items-center justify-center mb-3 ring-4 ring-white/30">
                                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                    </svg>
                                    </div>
                                    <h4 class="font-extrabold text-white text-sm mb-1">Dedicated</h4>
                                    <p class="text-xs text-white/90">5+ exams</p>
                                </div>
                            </div>
                        @endif
                        
                        <!-- Early Adopter Badge -->
                        @if($student->enroll_date && $student->enroll_date->diffInMonths(now()) >= 6)
                            <div class="group relative bg-gradient-to-br from-pink-500 via-rose-600 to-red-700 rounded-2xl p-5 shadow-xl hover:shadow-2xl transition-all duration-300 hover:-translate-y-2 hover:rotate-1 overflow-hidden">
                                <div class="absolute inset-0 bg-grid-white/10 bg-[size:20px_20px]"></div>
                                <div class="absolute top-0 right-0 w-16 h-16 bg-white/20 rounded-full -translate-y-8 translate-x-8"></div>
                                <div class="relative flex flex-col items-center text-center">
                                    <div class="w-16 h-16 rounded-full bg-white/20 backdrop-blur-sm flex items-center justify-center mb-3 ring-4 ring-white/30">
                                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                    </div>
                                    <h4 class="font-extrabold text-white text-sm mb-1">Veteran</h4>
                                    <p class="text-xs text-white/90">6+ months</p>
                                </div>
                            </div>
                        @endif
                        
                        <!-- Newcomer/Starter Badge -->
                        @if($examStats['total'] == 0 || $examStats['total'] < 5)
                            <div class="group relative bg-gradient-to-br from-slate-400 via-slate-500 to-slate-600 rounded-2xl p-5 shadow-xl hover:shadow-2xl transition-all duration-300 hover:-translate-y-2 hover:rotate-1 overflow-hidden">
                                <div class="absolute inset-0 bg-grid-white/10 bg-[size:20px_20px]"></div>
                                <div class="absolute top-0 right-0 w-16 h-16 bg-white/20 rounded-full -translate-y-8 translate-x-8"></div>
                                <div class="relative flex flex-col items-center text-center">
                                    <div class="w-16 h-16 rounded-full bg-white/20 backdrop-blur-sm flex items-center justify-center mb-3 ring-4 ring-white/30">
                                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                    </svg>
                                    </div>
                                    <h4 class="font-extrabold text-white text-sm mb-1">
                                        @if($examStats['total'] == 0)
                                            Newcomer
                                        @else
                                            Starter
                                        @endif
                                    </h4>
                                    <p class="text-xs text-white/90">Begin journey</p>
                                </div>
                            </div>
                        @endif
                        
                        <!-- Achievement in Progress -->
                        <div class="group relative bg-slate-100 dark:bg-slate-800 rounded-2xl p-5 border-2 border-dashed border-slate-300 dark:border-slate-600 hover:border-blue-400 dark:hover:border-blue-500 transition-all duration-300">
                            <div class="flex flex-col items-center text-center h-full justify-center">
                                <div class="w-16 h-16 rounded-full bg-slate-200 dark:bg-slate-700 flex items-center justify-center mb-3">
                                    <svg class="w-8 h-8 text-slate-400 dark:text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                                    </svg>
                                </div>
                                <h4 class="font-bold text-slate-600 dark:text-slate-400 text-xs">Locked</h4>
                                <p class="text-xs text-slate-500 dark:text-slate-500 mt-1">Keep going!</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Premium Social Sharing Section -->
                <div class="mt-10 pt-8 border-t border-slate-200 dark:border-slate-700">
                    <div class="flex items-center gap-3 mb-6">
                        <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-pink-500 to-rose-600 flex items-center justify-center">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z"></path>
                        </svg>
                        </div>
                        <div>
                            <h3 class="text-2xl font-extrabold text-slate-900 dark:text-white">
                        Share Your Success
                    </h3>
                            <p class="text-sm text-slate-600 dark:text-slate-400">Inspire others with your achievements</p>
                        </div>
                    </div>
                    
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <!-- Facebook Share -->
                        <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(route('student.profile.show', $student->id)) }}&quote=🌟 Check out my academic journey on Bikolpo Live! I'm a student at {{ $student->course->name ?? 'Bikolpo Live' }} and I've taken {{ $examStats['total'] }} exams with an average score of {{ $examStats['average'] }}%. #BikolpoLive #Education #StudentLife" 
                           target="_blank"
                           class="group relative bg-gradient-to-br from-blue-600 to-indigo-700 hover:from-blue-700 hover:to-indigo-800 text-white rounded-2xl p-6 shadow-xl hover:shadow-2xl transition-all duration-300 hover:-translate-y-1 overflow-hidden">
                            <div class="absolute top-0 right-0 w-24 h-24 bg-white/10 rounded-full -translate-y-12 translate-x-12"></div>
                            <div class="relative flex items-center gap-4">
                                <div class="w-14 h-14 rounded-xl bg-white/20 backdrop-blur-sm flex items-center justify-center">
                                    <svg class="w-7 h-7 text-white" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z"></path>
                            </svg>
                                </div>
                                <div class="flex-1">
                                    <h4 class="font-bold text-lg mb-1">Facebook</h4>
                                    <p class="text-sm text-white/90">Share on Facebook</p>
                                </div>
                                <svg class="w-5 h-5 text-white/70 group-hover:text-white group-hover:translate-x-1 transition-all duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                </svg>
                            </div>
                        </a>
                        
                        <!-- Twitter Share -->
                        <a href="https://twitter.com/intent/tweet?text=🌟 Check out my academic progress on Bikolpo Live! {{ $examStats['total'] }} exams taken with {{ $examStats['average'] }}% average score. %23BikolpoLive %23Education&url={{ urlencode(route('student.profile.show', $student->id)) }}" 
                           target="_blank"
                           class="group relative bg-gradient-to-br from-sky-500 to-blue-600 hover:from-sky-600 hover:to-blue-700 text-white rounded-2xl p-6 shadow-xl hover:shadow-2xl transition-all duration-300 hover:-translate-y-1 overflow-hidden">
                            <div class="absolute top-0 right-0 w-24 h-24 bg-white/10 rounded-full -translate-y-12 translate-x-12"></div>
                            <div class="relative flex items-center gap-4">
                                <div class="w-14 h-14 rounded-xl bg-white/20 backdrop-blur-sm flex items-center justify-center">
                                    <svg class="w-7 h-7 text-white" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"></path>
                                    </svg>
                                </div>
                                <div class="flex-1">
                                    <h4 class="font-bold text-lg mb-1">Twitter</h4>
                                    <p class="text-sm text-white/90">Tweet your progress</p>
                                </div>
                                <svg class="w-5 h-5 text-white/70 group-hover:text-white group-hover:translate-x-1 transition-all duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                </svg>
                            </div>
                        </a>
                    </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Premium Branding Footer -->
        <div class="mt-12 text-center">
            <div class="inline-flex items-center gap-2 px-6 py-3 rounded-2xl bg-white/60 dark:bg-slate-900/60 backdrop-blur-lg border border-slate-200/50 dark:border-slate-700/50 shadow-lg">
                <div class="w-8 h-8 rounded-lg bg-gradient-to-br from-emerald-500 to-green-600 flex items-center justify-center">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                    </svg>
                </div>
                <p class="text-sm font-medium text-slate-700 dark:text-slate-300">
                Proudly powered by 
                    <span class="font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-emerald-600 via-green-600 to-teal-600 dark:from-emerald-400 dark:via-green-400 dark:to-teal-400">
                        Bikolpo Live
                    </span>
            </p>
            </div>
        </div>
    </div>
</div>

<!-- JavaScript for Share Functions -->
<script>
function shareProfile() {
    if (navigator.share) {
        navigator.share({
            title: '{{ $student->full_name }} - Bikolpo Live Profile',
            text: '🌟 Check out my academic journey on Bikolpo Live! I have taken {{ $examStats['total'] }} exams with an average score of {{ $examStats['average'] }}%.',
            url: '{{ route('student.profile.show', $student->id) }}'
        }).then(() => {
            console.log('Thanks for sharing!');
        }).catch(console.error);
    } else {
        // Fallback - copy to clipboard
        const url = '{{ route('student.profile.show', $student->id) }}';
        navigator.clipboard.writeText(url).then(() => {
            alert('Profile link copied to clipboard!');
        });
    }
}
</script>

<!-- Premium Custom Styles -->
<style>
/* Grid Background Pattern */
.bg-grid-white\/5 {
    background-image: linear-gradient(rgba(255, 255, 255, 0.05) 1px, transparent 1px),
                      linear-gradient(90deg, rgba(255, 255, 255, 0.05) 1px, transparent 1px);
}

.bg-grid-white\/10 {
    background-image: linear-gradient(rgba(255, 255, 255, 0.1) 1px, transparent 1px),
                      linear-gradient(90deg, rgba(255, 255, 255, 0.1) 1px, transparent 1px);
}

.bg-grid-slate-900\/\[0\.02\] {
    background-image: linear-gradient(rgba(15, 23, 42, 0.02) 1px, transparent 1px),
                      linear-gradient(90deg, rgba(15, 23, 42, 0.02) 1px, transparent 1px);
}

.dark .bg-grid-white\/\[0\.02\] {
    background-image: linear-gradient(rgba(255, 255, 255, 0.02) 1px, transparent 1px),
                      linear-gradient(90deg, rgba(255, 255, 255, 0.02) 1px, transparent 1px);
}

/* 3D Shadow Effect */
.hover\:shadow-3xl:hover {
    box-shadow: 0 35px 60px -15px rgba(0, 0, 0, 0.3);
}

/* Smooth Animations */
@keyframes float {
    0%, 100% { transform: translateY(0px); }
    50% { transform: translateY(-10px); }
}

.animate-float {
    animation: float 3s ease-in-out infinite;
}

/* Print Styles for Screenshot */
@media print {
    body * {
        visibility: hidden;
    }
    .max-w-6xl, .max-w-6xl * {
        visibility: visible;
    }
    .max-w-6xl {
        position: absolute;
        left: 0;
        top: 0;
        width: 100%;
    }
    button, a[href*="dashboard"] {
        display: none !important;
    }
}

/* Responsive Typography */
@media (max-width: 640px) {
    h1 {
        font-size: 1.875rem;
        line-height: 2.25rem;
    }
    h2 {
        font-size: 1.5rem;
        line-height: 2rem;
    }
    }
</style>
@endsection