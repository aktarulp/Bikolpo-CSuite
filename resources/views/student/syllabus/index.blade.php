@extends('layouts.student-layout')

@section('title', 'My Syllabus')

@section('content')
<!-- Ultra Modern Syllabus - Mobile First -->
<div class="min-h-screen bg-gradient-to-br from-emerald-50 via-green-50/30 to-teal-50/20 dark:from-slate-950 dark:via-emerald-950/20 dark:to-slate-900 relative overflow-hidden">
    
    <!-- Animated Background Pattern -->
    <div class="fixed inset-0 bg-[linear-gradient(to_right,#8080800a_1px,transparent_1px),linear-gradient(to_bottom,#8080800a_1px,transparent_1px)] bg-[size:24px_24px] pointer-events-none"></div>
    <div class="fixed top-0 left-1/4 w-96 h-96 bg-emerald-400/20 dark:bg-emerald-600/10 rounded-full blur-3xl animate-pulse pointer-events-none"></div>
    <div class="fixed bottom-0 right-1/4 w-96 h-96 bg-teal-400/20 dark:bg-teal-600/10 rounded-full blur-3xl animate-pulse delay-1000 pointer-events-none"></div>

    <div class="relative">
        <!-- Premium Page Header -->
        <div class="px-4 sm:px-6 lg:px-8 py-4 sm:py-5">
            <div class="max-w-7xl mx-auto">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                    <!-- Title Section -->
                    <div class="flex items-center gap-3">
                        <div class="relative">
                            <div class="absolute inset-0 bg-gradient-to-br from-emerald-600 to-teal-600 rounded-xl blur opacity-50"></div>
                            <div class="relative bg-gradient-to-br from-emerald-600 to-teal-600 p-2 rounded-xl shadow-lg">
                                <svg class="w-6 h-6 sm:w-7 sm:h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                </svg>
                            </div>
                        </div>
            <div>
                            <h1 class="text-xl sm:text-2xl lg:text-3xl font-bold bg-gradient-to-r from-emerald-600 via-green-600 to-teal-600 bg-clip-text text-transparent">
                    My Syllabus
                </h1>
                            <p class="text-xs sm:text-sm text-slate-600 dark:text-slate-400 mt-0.5">
                                Track your journey, unlock achievements 🎯
                            </p>
                        </div>
                    </div>
                    
                    <!-- Back Button -->
                    <a href="{{ route('student.dashboard') }}" 
                       class="inline-flex items-center gap-2 px-3 py-2 bg-white/80 dark:bg-slate-800/80 backdrop-blur-sm border border-slate-200 dark:border-slate-700 rounded-lg text-sm font-medium text-slate-700 dark:text-slate-300 hover:bg-white dark:hover:bg-slate-800 hover:shadow-md transition-all duration-300 hover:scale-105 active:scale-95">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                        <span class="hidden sm:inline">Back to Dashboard</span>
                        <span class="sm:hidden">Back</span>
                    </a>
            </div>
        </div>
    </div>

    <!-- Main Content -->
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-8 space-y-4">
            
        @if(!$course)
                <!-- No Course Assigned - Premium Empty State -->
                <div class="relative group">
                    <div class="absolute inset-0 bg-gradient-to-br from-emerald-600/10 to-teal-600/10 rounded-2xl blur-xl group-hover:blur-2xl transition-all duration-300"></div>
                    <div class="relative bg-white/90 dark:bg-slate-800/90 backdrop-blur-xl rounded-2xl border border-slate-200/50 dark:border-slate-700/50 p-6 sm:p-8 text-center shadow-lg">
                        <div class="relative inline-block">
                            <div class="absolute inset-0 bg-gradient-to-br from-emerald-400 to-teal-400 rounded-full blur-2xl opacity-30 animate-pulse"></div>
                            <div class="relative bg-gradient-to-br from-emerald-100 to-teal-100 dark:from-emerald-900/30 dark:to-teal-900/30 p-4 rounded-full">
                                <svg class="w-12 h-12 sm:w-14 sm:h-14 text-emerald-600 dark:text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                </svg>
                            </div>
                        </div>
                        <h3 class="mt-4 text-lg sm:text-xl font-bold text-slate-900 dark:text-white">No Course Assigned Yet</h3>
                        <p class="mt-2 text-sm text-slate-600 dark:text-slate-400 max-w-md mx-auto">
                            Your learning journey hasn't started yet. Please contact your administrator to get enrolled! 🚀
                        </p>
                    </div>
            </div>
        @else
                <!-- Course Info Card - Premium Design -->
                <div class="relative group">
                    <div class="absolute inset-0 bg-gradient-to-br from-emerald-600 to-teal-600 rounded-2xl blur-xl group-hover:blur-2xl transition-all duration-300 opacity-20"></div>
                    <div class="relative bg-white dark:bg-slate-800 rounded-2xl border border-slate-200 dark:border-slate-700 overflow-hidden shadow-lg">
                        <!-- Decorative Header -->
                        <div class="absolute top-0 left-0 right-0 h-1 bg-gradient-to-r from-emerald-600 via-green-600 to-teal-600"></div>
                        
                        <div class="p-3 sm:p-4">
                            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
            <!-- Course Info -->
                                <div class="flex items-center gap-3">
                                    <div class="relative flex-shrink-0">
                                        <div class="absolute inset-0 bg-gradient-to-br from-emerald-500 to-teal-500 rounded-xl blur opacity-40"></div>
                                        <div class="relative bg-gradient-to-br from-emerald-500 to-teal-500 p-2 rounded-xl">
                                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z"></path>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"></path>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14zm-4 6v-7.5l4-2.222"></path>
                                            </svg>
                                        </div>
                                    </div>
                    <div>
                                        <h2 class="text-base sm:text-lg font-bold text-slate-900 dark:text-white">{{ $course->name }}</h2>
                        @if($course->code)
                                            <p class="text-xs text-slate-500 dark:text-slate-400 mt-0.5 font-mono">{{ $course->code }}</p>
                        @endif
                    </div>
                                </div>
                                
                                <!-- Stats Badges -->
                                <div class="flex flex-wrap gap-2">
                                    <div class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-gradient-to-r from-emerald-50 to-green-50 dark:from-emerald-900/20 dark:to-green-900/20 border border-emerald-200 dark:border-emerald-700 rounded-lg">
                                        <div class="w-1.5 h-1.5 bg-emerald-500 rounded-full animate-pulse"></div>
                                        <span class="text-xs font-bold text-emerald-700 dark:text-emerald-300">
                            {{ $subjects->count() }} Subjects
                        </span>
                                    </div>
                                    <div class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-gradient-to-r from-teal-50 to-cyan-50 dark:from-teal-900/20 dark:to-cyan-900/20 border border-teal-200 dark:border-teal-700 rounded-lg">
                                        <svg class="w-3.5 h-3.5 text-teal-600 dark:text-teal-400" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                        </svg>
                                        <span class="text-xs font-bold text-teal-700 dark:text-teal-300">
                                            {{ $subjects->sum(fn($s) => $s->topics->count()) }} Topics
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                </div>
            </div>

            <!-- Subjects and Topics -->
                <div class="space-y-3 sm:space-y-4">
                    @forelse($subjects as $subjectIndex => $subject)
                        <div class="relative group" data-subject-id="{{ $subject->id }}">
                            <!-- Glow Effect -->
                            <div class="absolute inset-0 bg-gradient-to-br from-emerald-600/5 to-teal-600/5 rounded-2xl blur-xl group-hover:blur-2xl transition-all duration-300"></div>
                            
                            <!-- Subject Card -->
                            <div class="relative bg-white dark:bg-slate-800 rounded-2xl border border-slate-200 dark:border-slate-700 shadow-md hover:shadow-lg transition-all duration-300 overflow-hidden">
                                <!-- Color-coded Top Border -->
                                @php
                                    $gradients = [
                                        'from-emerald-500 to-teal-500',
                                        'from-green-500 to-emerald-500',
                                        'from-teal-500 to-cyan-500',
                                        'from-lime-500 to-green-500',
                                        'from-cyan-500 to-teal-500',
                                        'from-emerald-600 to-green-600',
                                    ];
                                    $gradient = $gradients[$subjectIndex % count($gradients)];
                                @endphp
                                <div class="absolute top-0 left-0 right-0 h-1 bg-gradient-to-r {{ $gradient }}"></div>
                                
                                <!-- Subject Header - Collapsible -->
                                <div class="px-3 sm:px-4 py-3 cursor-pointer subject-header" onclick="toggleSubject(this)">
                                    <div class="flex items-center justify-between gap-3">
                                        <div class="flex items-center gap-2 sm:gap-3 flex-1 min-w-0">
                                            <!-- Subject Icon -->
                                            <div class="flex-shrink-0">
                                                <div class="relative">
                                                    <div class="absolute inset-0 bg-gradient-to-br {{ $gradient }} rounded-lg blur opacity-40"></div>
                                                    <div class="relative bg-gradient-to-br {{ $gradient }} p-1.5 sm:p-2 rounded-lg">
                                                        <svg class="w-4 h-4 sm:w-5 sm:h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                                        </svg>
                                                    </div>
                            </div>
                        </div>

                                            <!-- Subject Name -->
                                            <div class="flex-1 min-w-0">
                                                <h3 class="text-sm sm:text-base font-bold text-slate-900 dark:text-white truncate">
                                                    {{ $subject->name }}
                                                </h3>
                                                @if($subject->code)
                                                    <p class="text-xs text-slate-500 dark:text-slate-400 font-mono mt-0.5">{{ $subject->code }}</p>
                                                @endif
                                            </div>
                                            </div>
                                            
                                        <!-- Topics Count & Expand Arrow -->
                                        <div class="flex items-center gap-2 flex-shrink-0">
                                            <span class="inline-flex items-center gap-1 px-2 py-1 bg-slate-100 dark:bg-slate-700/50 text-slate-700 dark:text-slate-300 text-xs font-bold rounded-md">
                                                <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                                    <path d="M9 4.804A7.968 7.968 0 005.5 4c-1.255 0-2.443.29-3.5.804v10A7.969 7.969 0 015.5 14c1.669 0 3.218.51 4.5 1.385A7.962 7.962 0 0114.5 14c1.255 0 2.443.29 3.5.804v-10A7.968 7.968 0 0014.5 4c-1.255 0-2.443.29-3.5.804V12a1 1 0 11-2 0V4.804z"></path>
                                                </svg>
                                                {{ $subject->topics->count() }}
                                            </span>
                                            <svg class="w-4 h-4 text-slate-400 dark:text-slate-500 transform transition-transform duration-300 expand-arrow" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                            </svg>
                                        </div>
                                    </div>
                                </div>

                                <!-- Topics List - Collapsible Content -->
                                <div class="topics-container max-h-0 overflow-hidden transition-all duration-500 ease-in-out">
                                    <div class="px-3 sm:px-4 pb-3 sm:pb-4 pt-1 space-y-2 sm:space-y-3">
                                        @if($subject->topics->isEmpty())
                                            <div class="py-6 text-center">
                                                <div class="inline-flex items-center justify-center w-12 h-12 bg-slate-100 dark:bg-slate-700/50 rounded-full mb-2">
                                                    <svg class="w-6 h-6 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
                                                    </svg>
                                                </div>
                                                <p class="text-xs text-slate-500 dark:text-slate-400">No topics available yet</p>
                                            </div>
                                        @else
                                            @foreach($subject->topics as $topicIndex => $topic)
                                                @php
                                                    $currentProgress = $progressData->get($topic->id)->completion_percentage ?? 0;
                                                @endphp
                                                <!-- Topic Card -->
                                                <div class="group/topic bg-slate-50/50 dark:bg-slate-900/30 backdrop-blur-sm border border-slate-200/50 dark:border-slate-700/50 rounded-xl p-3 sm:p-3.5 hover:bg-white dark:hover:bg-slate-900/50 hover:shadow-md transition-all duration-300 hover:scale-[1.01]" 
                                                     data-topic-id="{{ $topic->id }}">
                                                    
                                                    <!-- Topic Header -->
                                                    <div class="flex items-start justify-between gap-2 mb-3">
                                                        <div class="flex items-start gap-3 flex-1 min-w-0">
                                                            <!-- Chapter Number Badge -->
                                                            @if($topic->chapter_number)
                                                                <div class="flex-shrink-0">
                                                                    <div class="relative">
                                                                        <div class="absolute inset-0 bg-gradient-to-br {{ $gradient }} rounded-lg blur opacity-30"></div>
                                                                        <div class="relative flex items-center justify-center w-9 h-9 sm:w-10 sm:h-10 bg-gradient-to-br {{ $gradient }} rounded-lg text-white text-sm sm:text-base font-bold shadow-lg">
                                                                            {{ $topic->chapter_number }}
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            @endif
                                                            
                                                            <!-- Topic Name & Description -->
                                                            <div class="flex-1 min-w-0 pt-1">
                                                                <h4 class="text-sm sm:text-base font-bold text-slate-900 dark:text-white leading-snug">
                                                                    {{ $topic->name }}
                                                                </h4>
                                                                @if($topic->description)
                                                                    <p class="text-xs text-slate-500 dark:text-slate-400 mt-1 line-clamp-2">
                                                                        {{ $topic->description }}
                                                                    </p>
                                                                @endif
                                                            </div>
                                        </div>
                                        
                                                        <!-- Progress Percentage Badge -->
                                                        <div class="flex-shrink-0">
                                                            <div class="relative">
                                                                @if($currentProgress == 100)
                                                                    <!-- 100% Complete - Trophy -->
                                                                    <div class="flex items-center justify-center w-14 h-14 bg-gradient-to-br from-amber-400 to-yellow-500 rounded-xl shadow-lg topic-percentage animate-bounce-slow">
                                                                        <svg class="w-7 h-7 text-white" fill="currentColor" viewBox="0 0 20 20">
                                                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                                                        </svg>
                                                                    </div>
                                                                @else
                                                                    <!-- Progress Circle -->
                                                                    <div class="flex flex-col items-center justify-center w-14 h-14 bg-gradient-to-br from-slate-100 to-slate-200 dark:from-slate-700 dark:to-slate-600 rounded-xl shadow-md topic-percentage">
                                                                        <span class="text-lg font-bold text-slate-900 dark:text-white">{{ $currentProgress }}</span>
                                                                        <span class="text-[10px] font-semibold text-slate-500 dark:text-slate-400">%</span>
                                                                    </div>
                                                                @endif
                                                            </div>
                                            </div>
                                        </div>
                                        
                                                    <!-- Interactive Progress Slider & Update Button -->
                                        <div class="flex items-center gap-3">
                                                        <!-- Premium Range Slider with Handle & Percentage Display -->
                                                        <div class="flex-1 relative">
                                                            <!-- Percentage Indicator on Bar -->
                                                            <div class="flex items-center justify-between mb-1.5">
                                                                <span class="text-xs font-medium text-slate-600 dark:text-slate-400">Progress</span>
                                                                <span class="text-xs font-bold text-emerald-600 dark:text-emerald-400 topic-percentage-text">{{ $currentProgress }}%</span>
                                                            </div>
                                                            <!-- Slider with Floating Percentage -->
                                                            <div class="relative py-1">
                                                                <!-- Floating Percentage Badge on Handle -->
                                                                <div class="slider-percentage-badge absolute -top-8 bg-gradient-to-r from-emerald-600 to-teal-600 text-white text-xs font-bold px-2.5 py-1 rounded-lg shadow-lg pointer-events-none transition-all duration-150 ease-out"
                                                                     style="left: calc({{ $currentProgress }}% - 20px);">
                                                                    <span class="percentage-value">{{ $currentProgress }}%</span>
                                                                    <div class="absolute -bottom-1 left-1/2 -translate-x-1/2 w-2 h-2 bg-gradient-to-br from-emerald-600 to-teal-600 rotate-45"></div>
                                                                </div>
                                            <input 
                                                type="range" 
                                                min="0" 
                                                max="100" 
                                                                value="{{ $currentProgress }}" 
                                                                class="w-full h-2.5 rounded-full appearance-none cursor-pointer topic-progress-slider transition-all duration-300"
                                                                style="background: linear-gradient(to right, rgb(16, 185, 129) 0%, rgb(16, 185, 129) {{ $currentProgress }}%, rgb(226, 232, 240) {{ $currentProgress }}%, rgb(226, 232, 240) 100%);"
                                                data-topic-id="{{ $topic->id }}"
                                                data-topic-name="{{ $topic->name }}"
                                                                data-gradient="{{ $gradient }}"
                                            >
                                                            </div>
                                                        </div>
                                                        
                                                        <!-- Update Button -->
                                            <button 
                                                            class="update-progress-btn group/btn flex-shrink-0 px-4 sm:px-5 py-2.5 bg-gradient-to-r {{ $gradient }} hover:shadow-lg text-white text-xs sm:text-sm font-bold rounded-xl transition-all duration-300 hover:scale-105 active:scale-95 disabled:opacity-50 disabled:cursor-not-allowed"
                                                data-topic-id="{{ $topic->id }}"
                                            >
                                                            <span class="flex items-center gap-2">
                                                                <svg class="w-4 h-4 transition-transform group-hover/btn:rotate-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                                                </svg>
                                                                <span class="hidden sm:inline">Update</span>
                                                            </span>
                                            </button>
                                        </div>
                                    </div>
                                @endforeach
                            @endif
                                    </div>
                                </div>
                        </div>
                    </div>
                @empty
                        <!-- No Subjects - Premium Empty State -->
                        <div class="relative group">
                            <div class="absolute inset-0 bg-gradient-to-br from-slate-600/10 to-slate-600/10 rounded-3xl blur-xl group-hover:blur-2xl transition-all duration-300"></div>
                            <div class="relative bg-white/90 dark:bg-slate-800/90 backdrop-blur-xl rounded-3xl border border-slate-200/50 dark:border-slate-700/50 p-8 sm:p-12 text-center shadow-xl">
                                <div class="relative inline-block">
                                    <div class="absolute inset-0 bg-slate-400 rounded-full blur-2xl opacity-20 animate-pulse"></div>
                                    <div class="relative bg-slate-100 dark:bg-slate-700/50 p-6 rounded-full">
                                        <svg class="w-16 h-16 sm:w-20 sm:h-20 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                        </svg>
                                    </div>
                                </div>
                                <h3 class="mt-6 text-xl sm:text-2xl font-bold text-slate-900 dark:text-white">No Subjects Found</h3>
                                <p class="mt-3 text-sm sm:text-base text-slate-600 dark:text-slate-400 max-w-md mx-auto">
                                    No subjects are available for your course yet. Check back soon! 📚
                                </p>
                            </div>
                    </div>
                @endforelse
            </div>
        @endif
    </div>
</div>
</div>

<!-- Confetti Container for 100% Completion -->
<div id="confetti-container" class="fixed inset-0 pointer-events-none z-50"></div>

<style>
/* Custom Scrollbar */
::-webkit-scrollbar {
    width: 10px;
}

::-webkit-scrollbar-track {
    background: rgb(241, 245, 249);
}

::-webkit-scrollbar-thumb {
    background: linear-gradient(to bottom, #10b981, #14b8a6);
    border-radius: 5px;
}

::-webkit-scrollbar-thumb:hover {
    background: linear-gradient(to bottom, #059669, #0d9488);
}

.dark ::-webkit-scrollbar-track {
    background: rgb(15, 23, 42);
}

/* Shimmer Animation */
@keyframes shimmer {
    0% { transform: translateX(-100%); }
    100% { transform: translateX(100%); }
}

.animate-shimmer {
    animation: shimmer 2s infinite;
}

/* Bounce Slow Animation */
@keyframes bounce-slow {
    0%, 100% {
        transform: translateY(-5%);
        animation-timing-function: cubic-bezier(0.8, 0, 1, 1);
    }
    50% {
        transform: translateY(0);
        animation-timing-function: cubic-bezier(0, 0, 0.2, 1);
    }
}

.animate-bounce-slow {
    animation: bounce-slow 2s infinite;
}

/* Floating Percentage Badge on Slider */
.slider-percentage-badge {
    z-index: 10;
    white-space: nowrap;
    opacity: 1;
}

.slider-percentage-badge:hover,
.slider-percentage-badge.active {
    transform: translateY(0) scale(1.05);
}

/* Premium Range Slider with Prominent Handle */
.topic-progress-slider {
    position: relative;
}

.topic-progress-slider::-webkit-slider-thumb {
    appearance: none;
    width: 24px;
    height: 24px;
    border-radius: 50%;
    background: linear-gradient(135deg, #10b981, #14b8a6);
    cursor: grab;
    border: 4px solid white;
    box-shadow: 0 4px 16px rgba(16, 185, 129, 0.6), 0 0 0 1px rgba(16, 185, 129, 0.2);
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}

.topic-progress-slider::-webkit-slider-thumb:hover {
    transform: scale(1.15);
    box-shadow: 0 6px 20px rgba(16, 185, 129, 0.8), 0 0 0 2px rgba(16, 185, 129, 0.3);
    border-color: #f0fdfa;
}

.topic-progress-slider::-webkit-slider-thumb:active {
    cursor: grabbing;
    transform: scale(1.05);
    box-shadow: 0 2px 12px rgba(16, 185, 129, 0.9), 0 0 0 3px rgba(16, 185, 129, 0.4);
}

.topic-progress-slider::-moz-range-thumb {
    width: 24px;
    height: 24px;
    border-radius: 50%;
    background: linear-gradient(135deg, #10b981, #14b8a6);
    cursor: grab;
    border: 4px solid white;
    box-shadow: 0 4px 16px rgba(16, 185, 129, 0.6), 0 0 0 1px rgba(16, 185, 129, 0.2);
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}

.topic-progress-slider::-moz-range-thumb:hover {
    transform: scale(1.15);
    box-shadow: 0 6px 20px rgba(16, 185, 129, 0.8), 0 0 0 2px rgba(16, 185, 129, 0.3);
    border-color: #f0fdfa;
}

.topic-progress-slider::-moz-range-thumb:active {
    cursor: grabbing;
    transform: scale(1.05);
    box-shadow: 0 2px 12px rgba(16, 185, 129, 0.9), 0 0 0 3px rgba(16, 185, 129, 0.4);
}

/* Dark mode slider thumb */
.dark .topic-progress-slider::-webkit-slider-thumb {
    border-color: rgba(30, 41, 59, 0.9);
}

.dark .topic-progress-slider::-moz-range-thumb {
    border-color: rgba(30, 41, 59, 0.9);
}

/* Confetti */
.confetti {
    position: absolute;
    width: 10px;
    height: 10px;
    background: #f0f;
    animation: confetti-fall 3s linear forwards;
    opacity: 0;
}

@keyframes confetti-fall {
    0% {
        opacity: 1;
        transform: translateY(0) rotate(0deg);
    }
    100% {
        opacity: 0;
        transform: translateY(100vh) rotate(720deg);
    }
}
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const sliders = document.querySelectorAll('.topic-progress-slider');
        const updateButtons = document.querySelectorAll('.update-progress-btn');
        
    // Toggle subject collapse/expand
    window.toggleSubject = function(header) {
        const container = header.nextElementSibling;
        const arrow = header.querySelector('.expand-arrow');
        const isOpen = container.style.maxHeight && container.style.maxHeight !== '0px';
        
        if (isOpen) {
            container.style.maxHeight = '0px';
            arrow.style.transform = 'rotate(0deg)';
        } else {
            container.style.maxHeight = container.scrollHeight + 'px';
            arrow.style.transform = 'rotate(180deg)';
        }
    };
    
    // Auto-expand first subject
    const firstSubject = document.querySelector('.subject-header');
    if (firstSubject) {
        setTimeout(() => toggleSubject(firstSubject), 100);
    }
    
    // Update slider background and styling when slider changes
    sliders.forEach(slider => {
        // Add active class when dragging starts
        slider.addEventListener('mousedown', function() {
            const topicCard = this.closest('[data-topic-id]');
            const floatingBadge = topicCard.querySelector('.slider-percentage-badge');
            if (floatingBadge) {
                floatingBadge.classList.add('active');
            }
        });
        
        // Remove active class when dragging ends
        slider.addEventListener('mouseup', function() {
            const topicCard = this.closest('[data-topic-id]');
            const floatingBadge = topicCard.querySelector('.slider-percentage-badge');
            if (floatingBadge) {
                floatingBadge.classList.remove('active');
            }
        });
        
        slider.addEventListener('input', function() {
            const topicId = this.dataset.topicId;
            const value = this.value;
            const gradient = this.dataset.gradient || 'from-emerald-500 to-teal-500';
            
            // Update slider background gradient with green color
            this.style.background = `linear-gradient(to right, rgb(16, 185, 129) 0%, rgb(16, 185, 129) ${value}%, rgb(226, 232, 240) ${value}%, rgb(226, 232, 240) 100%)`;
            
            const topicCard = this.closest('[data-topic-id]');
            
            // Update percentage text above slider
            const percentageText = topicCard.querySelector('.topic-percentage-text');
            if (percentageText) {
                percentageText.textContent = value + '%';
            }
            
            // Update floating badge on handle
            const floatingBadge = topicCard.querySelector('.slider-percentage-badge');
            if (floatingBadge) {
                floatingBadge.style.left = `calc(${value}% - 20px)`;
                const badgeValue = floatingBadge.querySelector('.percentage-value');
                if (badgeValue) {
                    badgeValue.textContent = value + '%';
                }
            }
            
            // Update percentage display badge
            const percentageDisplay = topicCard.querySelector('.topic-percentage');
            
            if (value == 100) {
                // Show trophy for 100%
                percentageDisplay.innerHTML = `
                    <svg class="w-7 h-7 text-white" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                    </svg>
                `;
                percentageDisplay.className = 'flex items-center justify-center w-14 h-14 bg-gradient-to-br from-amber-400 to-yellow-500 rounded-xl shadow-lg topic-percentage animate-bounce-slow';
            } else {
                // Show percentage
                percentageDisplay.innerHTML = `
                    <span class="text-lg font-bold text-slate-900 dark:text-white">${value}</span>
                    <span class="text-[10px] font-semibold text-slate-500 dark:text-slate-400">%</span>
                `;
                percentageDisplay.className = 'flex flex-col items-center justify-center w-14 h-14 bg-gradient-to-br from-slate-100 to-slate-200 dark:from-slate-700 dark:to-slate-600 rounded-xl shadow-md topic-percentage';
                }
            });
        });
        
        // Update progress when update button is clicked
        updateButtons.forEach(button => {
            button.addEventListener('click', function() {
                const topicId = this.dataset.topicId;
                const slider = document.querySelector(`.topic-progress-slider[data-topic-id="${topicId}"]`);
                const value = slider.value;
            const topicName = slider.dataset.topicName;
            
            // Disable button during request
            this.disabled = true;
            const originalContent = this.innerHTML;
            this.innerHTML = `
                <svg class="animate-spin w-4 h-4" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
            `;
                
                // Send AJAX request to update progress
                fetch('{{ route("student.syllabus.update-topic-progress") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({
                        topic_id: topicId,
                        completion_percentage: value
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Show success feedback
                    this.innerHTML = `
                        <span class="flex items-center gap-2">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                            </svg>
                            <span class="hidden sm:inline">Saved!</span>
                        </span>
                    `;
                    
                    // Trigger confetti if 100%
                    if (value == 100) {
                        triggerConfetti(topicName);
                    }
                        
                        setTimeout(() => {
                        this.innerHTML = originalContent;
                        this.disabled = false;
                    }, 2000);
                    } else {
                    alert('Error: ' + (data.error || 'Failed to update progress'));
                    this.innerHTML = originalContent;
                    this.disabled = false;
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Error updating progress. Please try again.');
                this.innerHTML = originalContent;
                this.disabled = false;
            });
        });
    });
    
    // Confetti effect for 100% completion
    function triggerConfetti(topicName) {
        const container = document.getElementById('confetti-container');
        const colors = ['#10b981', '#14b8a6', '#22c55e', '#84cc16', '#34d399', '#6ee7b7'];
        
        // Show toast notification
        showToast(`🎉 Congratulations! "${topicName}" completed!`);
        
        // Create confetti
        for (let i = 0; i < 50; i++) {
            const confetti = document.createElement('div');
            confetti.className = 'confetti';
            confetti.style.left = Math.random() * 100 + '%';
            confetti.style.backgroundColor = colors[Math.floor(Math.random() * colors.length)];
            confetti.style.animationDelay = Math.random() * 0.5 + 's';
            confetti.style.animationDuration = (Math.random() * 2 + 2) + 's';
            container.appendChild(confetti);
            
            setTimeout(() => confetti.remove(), 3000);
        }
    }
    
    // Toast notification
    function showToast(message) {
        const toast = document.createElement('div');
        toast.className = 'fixed top-4 right-4 bg-gradient-to-r from-emerald-600 to-teal-600 text-white px-6 py-4 rounded-2xl shadow-2xl z-50 transform translate-x-0 transition-all duration-500 animate-bounce-slow';
        toast.innerHTML = `
            <div class="flex items-center gap-3">
                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                </svg>
                <span class="font-bold">${message}</span>
            </div>
        `;
        document.body.appendChild(toast);
        
        setTimeout(() => {
            toast.style.transform = 'translateX(150%)';
            setTimeout(() => toast.remove(), 500);
        }, 3000);
    }
    });
</script>
@endsection
