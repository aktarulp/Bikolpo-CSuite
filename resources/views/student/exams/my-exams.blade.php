@extends('layouts.student-layout')

@section('title', 'My Exams')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-slate-50 via-white to-slate-100 dark:from-slate-900 dark:via-slate-800 dark:to-slate-900">
    <!-- Hero Header -->
    <div class="relative overflow-hidden bg-gradient-to-r from-blue-600 via-indigo-600 to-purple-600 dark:from-blue-800 dark:via-indigo-800 dark:to-purple-800">
        <!-- Decorative Background Pattern -->
        <div class="absolute inset-0 bg-grid-white/5"></div>
        <div class="absolute inset-0 bg-gradient-to-b from-transparent to-black/10"></div>
        
        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 sm:py-12">
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                <div>
                    <div class="flex items-center gap-3 mb-2">
                        <div class="w-12 h-12 rounded-2xl bg-white/10 backdrop-blur-sm flex items-center justify-center">
                            <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                        </div>
                        <h1 class="text-3xl sm:text-4xl font-extrabold text-white">
                            My Exams
                        </h1>
                    </div>
                    <p class="text-blue-100 dark:text-blue-200 text-sm sm:text-base ml-0 sm:ml-15">
                        Track your exams, view schedules, and manage your assessments
                    </p>
                </div>
                <a href="{{ route('student.dashboard') }}" 
                   class="inline-flex items-center px-4 py-2.5 bg-white/10 hover:bg-white/20 backdrop-blur-sm text-white rounded-xl border border-white/20 transition-all duration-300 hover:-translate-y-0.5 hover:shadow-lg hover:shadow-white/20">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    <span class="font-medium">Back to Dashboard</span>
                </a>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 -mt-8 pb-12 space-y-6">
        
        <!-- Performance Stats -->
        <section class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            <!-- Total Exams -->
            <div class="group relative bg-white dark:bg-slate-800 rounded-2xl shadow-sm hover:shadow-xl border border-slate-200 dark:border-slate-700 overflow-hidden transition-all duration-300 hover:-translate-y-1">
                <div class="absolute top-0 right-0 w-24 h-24 bg-gradient-to-br from-blue-500/10 to-transparent rounded-bl-full"></div>
                <div class="relative p-4 sm:p-5">
                    <div class="flex items-start justify-between mb-3">
                        <div class="flex-1">
                            <p class="text-xs font-medium text-slate-500 dark:text-slate-400 uppercase tracking-wide">Total Exams</p>
                            <p class="text-3xl sm:text-4xl font-bold text-slate-900 dark:text-white mt-2">{{ $assignedExams->count() }}</p>
                        </div>
                        <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-blue-500 to-blue-600 flex items-center justify-center shadow-lg shadow-blue-500/30">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                        </div>
                    </div>
                    <p class="text-xs text-slate-500 dark:text-slate-400">Assigned to you</p>
                </div>
            </div>

            <!-- Available Now -->
            <div class="group relative bg-white dark:bg-slate-800 rounded-2xl shadow-sm hover:shadow-xl border border-slate-200 dark:border-slate-700 overflow-hidden transition-all duration-300 hover:-translate-y-1">
                <div class="absolute top-0 right-0 w-24 h-24 bg-gradient-to-br from-emerald-500/10 to-transparent rounded-bl-full"></div>
                <div class="relative p-4 sm:p-5">
                    <div class="flex items-start justify-between mb-3">
                        <div class="flex-1">
                            <p class="text-xs font-medium text-slate-500 dark:text-slate-400 uppercase tracking-wide">Available</p>
                            <p class="text-3xl sm:text-4xl font-bold text-slate-900 dark:text-white mt-2">{{ $assignedExams->where('status', 'published')->filter(function($exam) { return now()->between($exam->start_time, $exam->end_time); })->count() }}</p>
                        </div>
                        <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-emerald-500 to-emerald-600 flex items-center justify-center shadow-lg shadow-emerald-500/30">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                        </div>
                    </div>
                    <p class="text-xs text-emerald-600 dark:text-emerald-400 font-semibold">Ready to start</p>
                </div>
            </div>

            <!-- Upcoming -->
            <div class="group relative bg-white dark:bg-slate-800 rounded-2xl shadow-sm hover:shadow-xl border border-slate-200 dark:border-slate-700 overflow-hidden transition-all duration-300 hover:-translate-y-1">
                <div class="absolute top-0 right-0 w-24 h-24 bg-gradient-to-br from-amber-500/10 to-transparent rounded-bl-full"></div>
                <div class="relative p-4 sm:p-5">
                    <div class="flex items-start justify-between mb-3">
                        <div class="flex-1">
                            <p class="text-xs font-medium text-slate-500 dark:text-slate-400 uppercase tracking-wide">Upcoming</p>
                            <p class="text-3xl sm:text-4xl font-bold text-slate-900 dark:text-white mt-2">{{ $assignedExams->where('status', 'published')->filter(function($exam) { return now()->lt($exam->start_time); })->count() }}</p>
                        </div>
                        <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-amber-500 to-amber-600 flex items-center justify-center shadow-lg shadow-amber-500/30">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                    </div>
                    <p class="text-xs text-slate-500 dark:text-slate-400">Scheduled soon</p>
                </div>
            </div>

            <!-- Completed -->
            <div class="group relative bg-white dark:bg-slate-800 rounded-2xl shadow-sm hover:shadow-xl border border-slate-200 dark:border-slate-700 overflow-hidden transition-all duration-300 hover:-translate-y-1">
                <div class="absolute top-0 right-0 w-24 h-24 bg-gradient-to-br from-purple-500/10 to-transparent rounded-bl-full"></div>
                <div class="relative p-4 sm:p-5">
                    <div class="flex items-start justify-between mb-3">
                        <div class="flex-1">
                            <p class="text-xs font-medium text-slate-500 dark:text-slate-400 uppercase tracking-wide">Completed</p>
                            <p class="text-3xl sm:text-4xl font-bold text-slate-900 dark:text-white mt-2">
                                {{ $assignedExams->filter(function($exam) { 
                                    $result = $exam->studentResults->first(); 
                                    return $result && $result->status === 'completed'; 
                                })->count() }}
                            </p>
                        </div>
                        <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-purple-500 to-purple-600 flex items-center justify-center shadow-lg shadow-purple-500/30">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                    </div>
                    <p class="text-xs text-slate-500 dark:text-slate-400">Successfully finished</p>
                </div>
            </div>
        </section>

        <!-- Exams List Section -->
        <section>
            <div class="flex items-center justify-between mb-5">
                <div>
                    <h2 class="text-xl sm:text-2xl font-bold text-slate-900 dark:text-white">
                        📚 All Exams
                    </h2>
                    <p class="text-sm text-slate-600 dark:text-slate-400 mt-1">
                        Manage and track your examination schedule
                    </p>
                </div>
                <div class="flex items-center gap-2 px-3 py-1.5 bg-gradient-to-r from-blue-50 to-indigo-50 dark:from-blue-900/30 dark:to-indigo-900/30 border border-blue-200 dark:border-blue-800/50 rounded-xl">
                    <div class="w-2 h-2 rounded-full bg-blue-500 animate-pulse"></div>
                    <span class="text-sm font-semibold text-slate-900 dark:text-white">{{ $assignedExams->count() }}</span>
                    <span class="text-xs text-slate-600 dark:text-slate-400">Total</span>
                </div>
            </div>

        @if($assignedExams->count() > 0)
            <!-- Modern Card Grid Layout -->
            <div class="grid grid-cols-1 gap-4 sm:gap-5">
                @foreach($assignedExams as $exam)
                    @php
                        $canTakeExam = $exam->status === 'published' && 
                                      now()->between($exam->start_time, $exam->end_time);
                        $isUpcoming = $exam->status === 'published' && 
                                     now()->lt($exam->start_time);
                        $result = $exam->studentResults->first();
                    @endphp
                    
                    <div class="group relative bg-white dark:bg-slate-800 rounded-xl shadow-sm hover:shadow-md border border-slate-200 dark:border-slate-700 overflow-hidden transition-all duration-300">
                        <!-- Status Indicator Bar -->
                        <div class="absolute top-0 left-0 right-0 h-0.5 
                            @if($canTakeExam)
                                bg-gradient-to-r from-emerald-500 to-green-500
                            @elseif($isUpcoming)
                                bg-gradient-to-r from-amber-500 to-orange-500
                            @elseif($result && $result->status === 'completed')
                                bg-gradient-to-r from-blue-500 to-indigo-500
                            @else
                                bg-gradient-to-r from-slate-400 to-slate-500
                            @endif">
                        </div>

                        <div class="p-3 sm:p-4">
                            <!-- Single Row Layout -->
                            <div class="flex items-center gap-3 flex-wrap xl:flex-nowrap">
                                <!-- Exam Title -->
                                <div class="flex items-center gap-2 flex-shrink-0 min-w-[200px] w-full sm:w-auto">
                                    <div class="w-8 h-8 rounded-lg 
                                        @if($canTakeExam)
                                            bg-gradient-to-br from-emerald-500 to-green-600
                                        @elseif($isUpcoming)
                                            bg-gradient-to-br from-amber-500 to-orange-600
                                        @elseif($result && $result->status === 'completed')
                                            bg-gradient-to-br from-blue-500 to-indigo-600
                                        @else
                                            bg-gradient-to-br from-slate-400 to-slate-500
                                        @endif
                                        flex items-center justify-center shadow-md flex-shrink-0">
                                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                        </svg>
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <h3 class="text-sm font-bold text-slate-900 dark:text-white truncate">
                                            {{ $exam->title }}
                                        </h3>
                                        <p class="text-xs text-slate-500 dark:text-slate-400">
                                            ID: #{{ $exam->id }}
                                        </p>
                                    </div>
                                </div>

                                <!-- Questions -->
                                <div class="flex items-center gap-1.5 text-xs px-2 py-1 rounded bg-slate-50 dark:bg-slate-900/50">
                                    <span class="text-slate-500 dark:text-slate-400">Q:</span>
                                    <span class="font-bold text-slate-900 dark:text-white">{{ $exam->total_questions ?? 0 }}</span>
                                </div>

                                <!-- Start Date -->
                                <div class="flex items-center gap-1.5 text-xs px-2 py-1 rounded bg-slate-50 dark:bg-slate-900/50">
                                    <span class="text-slate-500 dark:text-slate-400">Start:</span>
                                    <span class="font-semibold text-slate-900 dark:text-white">
                                        @if($exam->start_time)
                                            {{ $exam->start_time->format('M d') }}
                                        @else
                                            -
                                        @endif
                                    </span>
                                </div>

                                <!-- End Date -->
                                <div class="flex items-center gap-1.5 text-xs px-2 py-1 rounded bg-slate-50 dark:bg-slate-900/50">
                                    <span class="text-slate-500 dark:text-slate-400">End:</span>
                                    <span class="font-semibold text-slate-900 dark:text-white">
                                        @if($exam->end_time)
                                            {{ $exam->end_time->format('M d') }}
                                        @else
                                            -
                                        @endif
                                    </span>
                                </div>

                                <!-- Score/Duration -->
                                @if($result && $result->status === 'completed')
                                    <div class="flex items-center gap-1.5 text-xs px-2 py-1 rounded bg-emerald-50 dark:bg-emerald-900/30">
                                        <span class="text-emerald-700 dark:text-emerald-300">Score:</span>
                                        <span class="font-bold text-emerald-900 dark:text-white">{{ number_format($result->score ?? 0, 1) }}%</span>
                                    </div>
                                @else
                                    <div class="flex items-center gap-1.5 text-xs px-2 py-1 rounded bg-slate-50 dark:bg-slate-900/50">
                                        <span class="text-slate-500 dark:text-slate-400">Duration:</span>
                                        <span class="font-semibold text-slate-900 dark:text-white">{{ $exam->duration ?? '-' }}m</span>
                                    </div>
                                @endif

                                <!-- Spacer (pushes buttons to the right on larger screens) -->
                                <div class="hidden xl:block flex-1"></div>

                                <!-- Action Buttons - Combined in single row -->
                                <div class="flex items-center gap-2 flex-shrink-0 w-full sm:w-auto justify-end">
                                @if($canTakeExam)
                                    <a href="{{ route('student.exams.start', $exam) }}" 
                                       class="inline-flex items-center justify-center gap-1.5 px-4 py-2 bg-gradient-to-r from-emerald-500 to-green-600 hover:from-emerald-600 hover:to-green-700 text-white text-sm font-semibold rounded-lg shadow-sm hover:shadow-md transition-all duration-300">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"></path>
                                        </svg>
                                        <span class="hidden sm:inline">Start</span>
                                    </a>
                                @elseif($isUpcoming)
                                    <span class="inline-flex items-center justify-center gap-1.5 px-3 py-2 bg-slate-100 dark:bg-slate-700 text-slate-500 dark:text-slate-400 text-xs font-semibold rounded-lg">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        <span>Upcoming</span>
                                    </span>
                                @else
                                    <span class="inline-flex items-center justify-center gap-1.5 px-3 py-2 bg-slate-100 dark:bg-slate-700 text-slate-500 dark:text-slate-400 text-xs font-semibold rounded-lg">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"></path>
                                        </svg>
                                        <span>Not Available</span>
                                    </span>
                                @endif

                                @if($result && $result->status === 'completed')
                                    <a href="{{ route('student.exams.result', $exam) }}" 
                                       class="inline-flex items-center justify-center gap-1.5 px-4 py-2 bg-gradient-to-r from-blue-500 to-indigo-600 hover:from-blue-600 hover:to-indigo-700 text-white text-sm font-semibold rounded-lg shadow-sm hover:shadow-md transition-all duration-300">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                        </svg>
                                        <span class="hidden sm:inline">View Result</span>
                                        <span class="sm:hidden">Result</span>
                                    </a>
                                @elseif($result && $result->status === 'in_progress')
                                    <span class="inline-flex items-center justify-center gap-1.5 px-3 py-2 bg-amber-100 dark:bg-amber-900/50 text-amber-800 dark:text-amber-200 text-xs font-semibold rounded-lg">
                                        <svg class="w-3.5 h-3.5 animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                                        </svg>
                                        <span>In Progress</span>
                                    </span>
                                @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <!-- Enhanced Empty State -->
            <div class="relative bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-slate-200 dark:border-slate-700 overflow-hidden">
                <div class="absolute inset-0 bg-gradient-to-br from-blue-50 via-indigo-50 to-purple-50 dark:from-slate-800 dark:via-slate-800 dark:to-slate-800 opacity-50"></div>
                <div class="relative px-6 py-16 sm:py-20 text-center">
                    <!-- Animated Icon -->
                    <div class="mx-auto flex items-center justify-center w-20 h-20 rounded-2xl bg-gradient-to-br from-blue-500 to-indigo-600 shadow-xl shadow-blue-500/30 mb-6">
                        <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                    </div>
                    
                    <h3 class="text-2xl font-bold text-slate-900 dark:text-white mb-2">
                        No Exams Yet
                    </h3>
                    <p class="text-sm sm:text-base text-slate-600 dark:text-slate-400 max-w-md mx-auto mb-8">
                        You don't have any exams assigned to you at the moment. Check back later or contact your instructor.
                    </p>
                    
                    <div class="flex flex-col sm:flex-row items-center justify-center gap-3">
                        <a href="{{ route('student.dashboard') }}" 
                           class="inline-flex items-center gap-2 px-6 py-3 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white font-semibold rounded-xl shadow-lg shadow-blue-500/30 hover:shadow-xl hover:shadow-blue-500/40 transition-all duration-300 hover:-translate-y-0.5">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                            </svg>
                            <span>Go to Dashboard</span>
                        </a>
                    </div>
                    
                    <!-- Decorative Elements -->
                    <div class="absolute top-0 left-0 w-32 h-32 bg-gradient-to-br from-blue-500/5 to-transparent rounded-full -translate-x-16 -translate-y-16"></div>
                    <div class="absolute bottom-0 right-0 w-40 h-40 bg-gradient-to-tl from-indigo-500/5 to-transparent rounded-full translate-x-20 translate-y-20"></div>
                </div>
            </div>
        @endif
        </section>
    </div>
</div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Function to update countdown
    function updateCountdown() {
        const countdownElements = document.querySelectorAll('[id^="countdown-"], [id^="countdown-table-"]');
        
        countdownElements.forEach(element => {
            const startTime = parseInt(element.dataset.startTime);
            const examStartTime = new Date(startTime * 1000);
            const now = new Date();
            
            // If exam time has passed, redirect to refresh the page
            if (now >= examStartTime) {
                window.location.reload();
                return;
            }
            
            // Calculate time difference
            const diff = examStartTime - now;
            
            // Calculate days, hours, minutes, seconds
            const days = Math.floor(diff / (1000 * 60 * 60 * 24));
            const hours = Math.floor((diff % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            const minutes = Math.floor((diff % (1000 * 60 * 60)) / (1000 * 60));
            const seconds = Math.floor((diff % (1000 * 60)) / 1000);
            
            // Format the display
            let displayText = '';
            if (days > 0) {
                displayText = `${days}d ${hours}h ${minutes}m`;
            } else if (hours > 0) {
                displayText = `${hours}h ${minutes}m ${seconds}s`;
            } else if (minutes > 0) {
                displayText = `${minutes}m ${seconds}s`;
            } else {
                displayText = `${seconds}s`;
            }
            
            element.textContent = displayText;
        });
    }
    
    // Update countdown immediately and then every second
    updateCountdown();
    setInterval(updateCountdown, 1000);
});
</script>
@endsection