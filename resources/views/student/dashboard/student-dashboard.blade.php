@extends('layouts.student-layout')

@section('title', 'Dashboard')

@section('content')
<!-- Mobile-First Professional Dashboard -->
<div class="min-h-screen bg-gradient-to-br from-slate-50 via-blue-50/30 to-indigo-50/20 dark:from-slate-950 dark:via-slate-900 dark:to-slate-900">
    
    <!-- Main Content Container -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4 sm:py-6 space-y-4 sm:space-y-6">
        
        <!-- Performance Metrics - Mobile First Grid -->
        <section class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3">
            <!-- Exams Taken Card -->
            <div class="group relative bg-white dark:bg-slate-800 rounded-xl shadow-sm hover:shadow-lg border border-slate-200 dark:border-slate-700 overflow-hidden transition-all duration-300 hover:-translate-y-0.5">
                <div class="absolute top-0 right-0 w-20 h-20 bg-gradient-to-br from-blue-500/10 to-transparent rounded-bl-full"></div>
                <div class="relative p-3 sm:p-4">
                    <div class="flex items-start justify-between mb-2">
                        <div class="flex-1">
                            <p class="text-xs font-medium text-slate-500 dark:text-slate-400 uppercase tracking-wide">Exams Taken</p>
                            <p class="text-2xl sm:text-3xl font-bold text-slate-900 dark:text-white mt-1">{{ $stats['total_exams_taken'] ?? 0 }}</p>
                    </div>
                        <div class="w-10 h-10 rounded-lg bg-gradient-to-br from-blue-500 to-blue-600 flex items-center justify-center shadow-md shadow-blue-500/30">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                        </svg>
                    </div>
                </div>
                    @php
                        $examsThisMonth = 0;
                        if (isset($recent_results)) {
                            $examsThisMonth = $recent_results->filter(function($result) {
                                return $result->completed_at && $result->completed_at->month == now()->month && $result->completed_at->year == now()->year;
                            })->count();
                        }
                    @endphp
                    <div class="flex items-center gap-2 text-xs">
                    @if($examsThisMonth > 0)
                            <span class="flex items-center gap-1 text-emerald-600 dark:text-emerald-400 font-semibold">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"></path>
                                </svg>
                                +{{ $examsThisMonth }} this month
                            </span>
                    @else
                            <span class="text-slate-500 dark:text-slate-400">No exams this month</span>
                    @endif
                    </div>
                </div>
            </div>

            <!-- Passed Exams Card -->
            <div class="group relative bg-white dark:bg-slate-800 rounded-xl shadow-sm hover:shadow-lg border border-slate-200 dark:border-slate-700 overflow-hidden transition-all duration-300 hover:-translate-y-0.5">
                <div class="absolute top-0 right-0 w-20 h-20 bg-gradient-to-br from-emerald-500/10 to-transparent rounded-bl-full"></div>
                <div class="relative p-3 sm:p-4">
                    <div class="flex items-start justify-between mb-2">
                        <div class="flex-1">
                            <p class="text-xs font-medium text-slate-500 dark:text-slate-400 uppercase tracking-wide">Passed</p>
                            <p class="text-2xl sm:text-3xl font-bold text-slate-900 dark:text-white mt-1">{{ $stats['passed_exams'] ?? 0 }}</p>
                    </div>
                        <div class="w-10 h-10 rounded-lg bg-gradient-to-br from-emerald-500 to-emerald-600 flex items-center justify-center shadow-md shadow-emerald-500/30">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                </div>
                    <div class="flex items-center gap-2 text-xs">
                    @if(($stats['total_exams_taken'] ?? 0) > 0)
                            <span class="text-slate-900 dark:text-white font-bold">{{ round((($stats['passed_exams'] ?? 0) / ($stats['total_exams_taken'] ?? 1)) * 100) }}%</span>
                            <span class="text-slate-500 dark:text-slate-400">success rate</span>
                    @else
                            <span class="text-slate-500 dark:text-slate-400">Start your journey</span>
                    @endif
                    </div>
                </div>
            </div>

            <!-- Average Score Card -->
            <div class="group relative bg-white dark:bg-slate-800 rounded-xl shadow-sm hover:shadow-lg border border-slate-200 dark:border-slate-700 overflow-hidden transition-all duration-300 hover:-translate-y-0.5">
                <div class="absolute top-0 right-0 w-20 h-20 bg-gradient-to-br from-purple-500/10 to-transparent rounded-bl-full"></div>
                <div class="relative p-3 sm:p-4">
                    <div class="flex items-start justify-between mb-2">
                        <div class="flex-1">
                            <p class="text-xs font-medium text-slate-500 dark:text-slate-400 uppercase tracking-wide">Avg Score</p>
                            <p class="text-2xl sm:text-3xl font-bold text-slate-900 dark:text-white mt-1">{{ number_format($stats['average_score'] ?? 0, 1) }}%</p>
                    </div>
                        <div class="w-10 h-10 rounded-lg bg-gradient-to-br from-purple-500 to-purple-600 flex items-center justify-center shadow-md shadow-purple-500/30">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                        </svg>
                    </div>
                </div>
                    <div class="w-full bg-slate-200 dark:bg-slate-700 rounded-full h-1.5 overflow-hidden">
                        <div class="bg-gradient-to-r from-purple-500 to-indigo-600 h-1.5 rounded-full transition-all duration-700" 
                             style="width: {{ min(($stats['average_score'] ?? 0), 100) }}%"></div>
                    </div>
                </div>
            </div>

            <!-- Upcoming Exams Card -->
            <div class="group relative bg-white dark:bg-slate-800 rounded-xl shadow-sm hover:shadow-lg border border-slate-200 dark:border-slate-700 overflow-hidden transition-all duration-300 hover:-translate-y-0.5">
                <div class="absolute top-0 right-0 w-20 h-20 bg-gradient-to-br from-amber-500/10 to-transparent rounded-bl-full"></div>
                <div class="relative p-3 sm:p-4">
                    <div class="flex items-start justify-between mb-2">
                        <div class="flex-1">
                            <p class="text-xs font-medium text-slate-500 dark:text-slate-400 uppercase tracking-wide">Upcoming</p>
                            <p class="text-2xl sm:text-3xl font-bold text-slate-900 dark:text-white mt-1">{{ $stats['upcoming_exams'] ?? 0 }}</p>
                        </div>
                        <div class="w-10 h-10 rounded-lg bg-gradient-to-br from-amber-500 to-amber-600 flex items-center justify-center shadow-md shadow-amber-500/30">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="flex items-center gap-2 text-xs">
                    @if(($stats['upcoming_exams'] ?? 0) > 0)
                            <span class="text-amber-600 dark:text-amber-400 font-semibold">Get ready!</span>
                    @else
                            <span class="text-emerald-600 dark:text-emerald-400 font-semibold">All clear</span>
                    @endif
                    </div>
                </div>
            </div>
        </section>

        <!-- Learning Journey Section -->
        <section class="grid grid-cols-1 lg:grid-cols-3 gap-4">
            <!-- Course Progress - Takes 2 columns on large screens -->
            <div class="lg:col-span-2 bg-white dark:bg-slate-800 rounded-xl shadow-sm border border-slate-200 dark:border-slate-700 overflow-hidden">
                <!-- Header -->
                <div class="bg-gradient-to-r from-indigo-500 to-purple-600 px-4 py-3">
                    <h2 class="text-base font-bold text-white">My Course Progress</h2>
                    <p class="text-xs text-indigo-100 mt-1">{{ $my_course->name ?? 'Not assigned' }}</p>
                    </div>

                <!-- Course Completion -->
                <div class="p-4">
                    <div class="bg-gradient-to-br from-emerald-50 to-teal-50 dark:from-slate-700 dark:to-slate-700 rounded-xl p-4 mb-5">
                        <div class="flex items-center justify-between mb-3">
                            <span class="text-sm font-semibold text-slate-700 dark:text-slate-200">Overall Completion</span>
                            <span class="text-2xl font-extrabold text-emerald-600 dark:text-emerald-400">{{ $stats['syllabus_completion'] ?? 0 }}%</span>
                        </div>
                        <div class="w-full bg-slate-200 dark:bg-slate-600 rounded-full h-3 overflow-hidden">
                            <div class="bg-gradient-to-r from-emerald-500 to-teal-500 h-3 rounded-full transition-all duration-1000 ease-out shadow-lg" 
                                 style="width: {{ $stats['syllabus_completion'] ?? 0 }}%"></div>
                        </div>
                    </div>

                    <!-- Subject Progress -->
                        <div class="space-y-4">
                        <h3 class="text-sm font-bold text-slate-700 dark:text-slate-200 flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                            </svg>
                            Subject Breakdown
                        </h3>
                        <div class="space-y-3">
                            @forelse($subjectProgress ?? collect() as $sp)
                                <div class="group p-3 rounded-lg bg-slate-50 dark:bg-slate-700/50 hover:bg-slate-100 dark:hover:bg-slate-700 transition-colors">
                                    <div class="flex items-center justify-between mb-2">
                                        <span class="text-sm font-semibold text-slate-900 dark:text-white">{{ $sp['subject']->name }}</span>
                                        <span class="text-sm font-bold text-indigo-600 dark:text-indigo-400">{{ number_format($sp['percent'], 1) }}%</span>
                                    </div>
                                    <div class="w-full bg-slate-200 dark:bg-slate-600 rounded-full h-2 overflow-hidden">
                                        <div class="bg-gradient-to-r from-indigo-500 to-purple-600 h-2 rounded-full transition-all duration-700" style="width: {{ $sp['percent'] }}%"></div>
                                    </div>
                                </div>
                            @empty
                                <div class="text-center py-8">
                                    <svg class="mx-auto h-12 w-12 text-slate-300 dark:text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                    </svg>
                                    <p class="mt-3 text-sm text-slate-500 dark:text-slate-400">No progress yet. Start learning!</p>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sidebar: Rankings & Recent Results -->
            <div class="lg:col-span-1 space-y-4">
                <!-- Rankings Card -->
                <div class="bg-white dark:bg-slate-800 rounded-xl shadow-sm border border-slate-200 dark:border-slate-700 overflow-hidden">
                    <div class="bg-gradient-to-r from-amber-500 to-orange-600 px-4 py-3">
                        <h2 class="text-base font-bold text-white flex items-center gap-2">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                    </svg>
                            My Rankings
                        </h2>
                    </div>
                    <div class="p-4 space-y-3">
                        <div class="flex items-center justify-between p-3 rounded-xl bg-gradient-to-r from-blue-50 to-indigo-50 dark:from-slate-700 dark:to-slate-700">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-full bg-blue-500 flex items-center justify-center text-white font-bold text-sm shadow-lg">
                                    #{{ explode(' / ', $stats['course_rank'] ?? '— / —')[0] }}
                                </div>
                                <div>
                                    <p class="text-xs text-slate-500 dark:text-slate-400">Course Rank</p>
                                    <p class="text-sm font-bold text-slate-900 dark:text-white">{{ $stats['course_rank'] ?? '—' }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="flex items-center justify-between p-3 rounded-xl bg-gradient-to-r from-emerald-50 to-teal-50 dark:from-slate-700 dark:to-slate-700">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-full bg-emerald-500 flex items-center justify-center text-white font-bold text-sm shadow-lg">
                                    #{{ explode(' / ', $stats['batch_rank'] ?? '— / —')[0] }}
                                </div>
                                <div>
                                    <p class="text-xs text-slate-500 dark:text-slate-400">Batch Rank</p>
                                    <p class="text-sm font-bold text-slate-900 dark:text-white">{{ $stats['batch_rank'] ?? '—' }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Recent Results Card -->
                <div class="bg-white dark:bg-slate-800 rounded-xl shadow-sm border border-slate-200 dark:border-slate-700 overflow-hidden">
                    <div class="px-4 py-3 border-b border-slate-200 dark:border-slate-700">
                        <h2 class="text-base font-bold text-slate-900 dark:text-white">Recent Results</h2>
                    </div>
                    <div class="p-4">
                        @if(($recent_results ?? collect())->count() > 0)
                            <div class="space-y-2">
                                @foreach(($recent_results ?? collect())->take(4) as $result)
                                    @php
                                        $percentage = $result->percentage ?? 0;
                                        if ($percentage >= 80) {
                                            $bgClass = 'from-emerald-50 to-teal-50 dark:from-emerald-900/20 dark:to-teal-900/20';
                                            $badgeClass = 'bg-emerald-500 text-white';
                                            $textClass = 'text-emerald-700 dark:text-emerald-300';
                                        } elseif ($percentage >= 60) {
                                            $bgClass = 'from-amber-50 to-yellow-50 dark:from-amber-900/20 dark:to-yellow-900/20';
                                            $badgeClass = 'bg-amber-500 text-white';
                                            $textClass = 'text-amber-700 dark:text-amber-300';
                                        } else {
                                            $bgClass = 'from-red-50 to-rose-50 dark:from-red-900/20 dark:to-rose-900/20';
                                            $badgeClass = 'bg-red-500 text-white';
                                            $textClass = 'text-red-700 dark:text-red-300';
                                        }
                                    @endphp
                                    
                                    <div class="group bg-gradient-to-r {{ $bgClass }} rounded-xl p-3 hover:shadow-md transition-all duration-200">
                                        <div class="flex items-center justify-between">
                                            <div class="flex-1 min-w-0">
                                                <h3 class="text-sm font-bold text-slate-900 dark:text-white truncate mb-1">{{ $result->exam->title }}</h3>
                                                <p class="text-xs text-slate-500 dark:text-slate-400">
                                                    {{ optional($result->completed_at)->format('M d, Y') }}
                                            </p>
                                        </div>
                                            <div class="flex items-center gap-2 ml-3">
                                                <div class="text-right">
                                                    <p class="text-lg font-extrabold {{ $textClass }}">{{ number_format($percentage, 0) }}%</p>
                                                    <span class="text-xs text-slate-500 dark:text-slate-400 font-medium">{{ $result->grade }}</span>
                                                </div>
                                                <div class="w-10 h-10 rounded-full {{ $badgeClass }} flex items-center justify-center shadow-lg">
                                                    @if($percentage >= 80)
                                                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                                        </svg>
                                                    @elseif($percentage >= 60)
                                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 10h4.764a2 2 0 011.789 2.894l-3.5 7A2 2 0 0115.263 21h-4.017c-.163 0-.326-.02-.485-.06L7 20m7-10V5a2 2 0 00-2-2h-.095c-.5 0-.905.405-.905.905 0 .714-.211 1.412-.608 2.006L7 11v9m7-10h-2M7 20H5a2 2 0 01-2-2v-6a2 2 0 012-2h2.5"></path>
                                                        </svg>
                                                    @else
                                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                                        </svg>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            @if(($recent_results ?? collect())->count() > 4)
                                <div class="mt-4 text-center">
                                    <a href="{{ route('student.exams.history') }}" 
                                       class="inline-flex items-center gap-2 text-sm font-semibold text-blue-600 hover:text-blue-700 dark:text-blue-400 dark:hover:text-blue-300 transition-colors">
                                        View all results 
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                                        </svg>
                                    </a>
                                </div>
                            @endif
                        @else
                            <div class="text-center py-8">
                                <div class="mx-auto w-16 h-16 rounded-full bg-gradient-to-br from-blue-100 to-indigo-100 dark:from-blue-900/30 dark:to-indigo-900/30 flex items-center justify-center mb-4">
                                    <svg class="w-8 h-8 text-blue-500 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                                </div>
                                <h3 class="text-sm font-bold text-slate-900 dark:text-white mb-1">No results yet</h3>
                                <p class="text-xs text-slate-500 dark:text-slate-400 mb-4">Start your journey by taking your first exam!</p>
                                <a href="{{ route('student.exams.my-exams') }}" 
                                   class="inline-flex items-center gap-2 px-4 py-2 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white text-sm font-semibold rounded-xl shadow-lg transition-all duration-200 hover:scale-105">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                    </svg>
                                    View My Exams
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
// No scripts needed for this page
</script>
@endsection