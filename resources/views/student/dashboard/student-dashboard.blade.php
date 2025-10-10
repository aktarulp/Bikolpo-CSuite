@extends('layouts.student-layout')

@section('title', 'Student Dashboard')

@section('content')
<div class="min-h-screen bg-gray-50 dark:bg-gray-900">
    <!-- Header -->
    <div class="px-4 sm:px-6 lg:px-8 py-6">
        <div class="flex items-start justify-between gap-4 flex-col sm:flex-row">
            <div>
                <h1 class="text-2xl sm:text-3xl font-bold text-gray-900 dark:text-white">Welcome{{ isset($student->full_name) ? ', '.$student->full_name : '' }}</h1>
                <p class="text-gray-600 dark:text-gray-400 text-sm">Your personalized learning dashboard</p>
            </div>
            <div class="flex items-center gap-2 sm:gap-3">
                <a href="{{ route('student.exams.available') }}" class="px-4 py-2 rounded-lg bg-green-600 hover:bg-green-700 text-white text-sm">Take Exam</a>
                <a href="{{ route('student.exams.history') }}" class="px-4 py-2 rounded-lg bg-orange-600 hover:bg-orange-700 text-white text-sm">Exam History</a>
                <a href="{{ route('typing.test') }}" class="px-4 py-2 rounded-lg bg-blue-600 hover:bg-blue-700 text-white text-sm">Typing Test</a>
            </div>
        </div>
    </div>

    <div class="px-4 sm:px-6 lg:px-8 pb-10 space-y-6">
        <!-- Top Stats -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-4">
                <div class="flex items-center gap-3">
                    <div class="p-3 rounded-lg bg-blue-100 dark:bg-blue-900">
                        <svg class="w-5 h-5 text-blue-600 dark:text-blue-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500 dark:text-gray-400">Exams Taken</p>
                        <p class="text-xl font-semibold text-gray-900 dark:text-white">{{ $stats['total_exams_taken'] ?? 0 }}</p>
                    </div>
                </div>
            </div>
            <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-4">
                <div class="flex items-center gap-3">
                    <div class="p-3 rounded-lg bg-green-100 dark:bg-green-900">
                        <svg class="w-5 h-5 text-green-600 dark:text-green-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500 dark:text-gray-400">Passed Exams</p>
                        <p class="text-xl font-semibold text-gray-900 dark:text-white">{{ $stats['passed_exams'] ?? 0 }}</p>
                    </div>
                </div>
            </div>
            <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-4">
                <div class="flex items-center gap-3">
                    <div class="p-3 rounded-lg bg-purple-100 dark:bg-purple-900">
                        <svg class="w-5 h-5 text-purple-600 dark:text-purple-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/></svg>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500 dark:text-gray-400">Average Score</p>
                        <p class="text-xl font-semibold text-gray-900 dark:text-white">{{ number_format($stats['average_score'] ?? 0, 1) }}%</p>
                    </div>
                </div>
            </div>
            <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-4">
                <div class="flex items-center gap-3">
                    <div class="p-3 rounded-lg bg-amber-100 dark:bg-amber-900">
                        <svg class="w-5 h-5 text-amber-600 dark:text-amber-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 1.343-3 3 0 2.25 3 5 3 5s3-2.75 3-5c0-1.657-1.343-3-3-3z"/></svg>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500 dark:text-gray-400">Upcoming Exams</p>
                        <p class="text-xl font-semibold text-gray-900 dark:text-white">{{ $stats['upcoming_exams'] ?? 0 }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Course & Batch Overview -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-4">
            <div class="lg:col-span-2 space-y-4">
                <!-- My Course Card -->
                <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-5">
                    <div class="flex items-start justify-between">
                        <div>
                            <h2 class="text-lg font-semibold text-gray-900 dark:text-white">My Course</h2>
                            <p class="text-sm text-gray-500 dark:text-gray-400">{{ $my_course->name ?? 'Not assigned' }} <span class="text-gray-400">{{ isset($my_course->code) ? "( {$my_course->code} )" : '' }}</span></p>
                        </div>
                        <div class="text-right text-sm text-gray-500 dark:text-gray-400">
                            @if(isset($my_course) && $my_course?->duration)
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full bg-blue-100 text-blue-800">{{ $my_course->duration }} days</span>
                            @endif
                        </div>
                    </div>

                    <!-- Syllabus Progress -->
                    <div class="mt-4">
                        <div class="flex items-center justify-between">
                            <span class="text-sm font-medium text-gray-700 dark:text-gray-300">Syllabus Completion</span>
                            <span class="text-sm text-gray-600 dark:text-gray-400">{{ $stats['syllabus_completion'] ?? 0 }}%</span>
                        </div>
                        <div class="w-full h-3 bg-gray-200 dark:bg-gray-700 rounded-full mt-2">
                            <div class="h-3 rounded-full bg-gradient-to-r from-emerald-500 to-emerald-600" style="width: {{ $stats['syllabus_completion'] ?? 0 }}%"></div>
                        </div>

                        <!-- Subject Progress Bars -->
                        <div class="mt-4 grid grid-cols-1 sm:grid-cols-2 gap-3">
                            @foreach(($subjectProgress ?? collect()) as $sp)
                                <div>
                                    <div class="flex items-center justify-between text-xs">
                                        <span class="text-gray-600 dark:text-gray-300">{{ $sp['subject']->name }}</span>
                                        <span class="text-gray-500 dark:text-gray-400">{{ $sp['percent'] }}%</span>
                                    </div>
                                    <div class="w-full h-2 bg-gray-200 dark:bg-gray-700 rounded-full mt-1">
                                        <div class="h-2 rounded-full bg-indigo-500" style="width: {{ $sp['percent'] }}%"></div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- Upcoming Exams -->
                <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700">
                    <div class="p-5 border-b border-gray-200 dark:border-gray-700 flex items-center justify-between">
                        <h2 class="text-lg font-semibold text-gray-900 dark:text-white">Upcoming Exams</h2>
                        <span class="text-xs px-2 py-1 rounded-full bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-300">{{ ($upcoming_exams ?? collect())->count() }}</span>
                    </div>
                    <div class="p-5">
                        @if(($upcoming_exams ?? collect())->count() > 0)
                            <div class="space-y-3">
                                @foreach(($upcoming_exams ?? collect()) as $exam)
                                    <div class="flex items-center justify-between p-4 rounded-lg border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800">
                                        <div>
                                            <h3 class="text-sm font-semibold text-gray-900 dark:text-white">{{ $exam->title }}</h3>
                                            <p class="text-xs text-gray-500 dark:text-gray-400">Starts: {{ optional($exam->start_time)->format('M d, Y H:i') ?? 'TBA' }}</p>
                                        </div>
                                        <a href="{{ route('student.exams.start', $exam) }}" class="px-3 py-1.5 rounded-md text-xs bg-emerald-600 hover:bg-emerald-700 text-white">Start</a>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <p class="text-sm text-gray-500 dark:text-gray-400 text-center py-4">No upcoming exams assigned.</p>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Right Column: Rankings & Batchmates -->
            <div class="space-y-4">
                <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-5">
                    <h2 class="text-lg font-semibold text-gray-900 dark:text-white">My Standings</h2>
                    <div class="mt-4 grid grid-cols-1 gap-3">
                        <div class="flex items-center justify-between p-3 rounded-lg bg-gray-50 dark:bg-gray-700">
<span class="text-sm text-gray-600 dark:text-gray-300">Rank In Course</span>
                            <span class="text-sm font-semibold text-gray-900 dark:text-white">{{ $stats['course_rank'] ?? '—' }}</span>
                        </div>
                        <div class="flex items-center justify-between p-3 rounded-lg bg-gray-50 dark:bg-gray-700">
<span class="text-sm text-gray-600 dark:text-gray-300">Rank In Batch</span>
                            <span class="text-sm font-semibold text-gray-900 dark:text-white">{{ $stats['batch_rank'] ?? '—' }}</span>
                        </div>
                        <div class="flex items-center justify-between p-3 rounded-lg bg-gray-50 dark:bg-gray-700">
                            <span class="text-sm text-gray-600 dark:text-gray-300">Batchmates' Exams Faced</span>
                            <span class="text-sm font-semibold text-gray-900 dark:text-white">{{ $stats['batchmate_exam_faced'] ?? 0 }}</span>
                        </div>
                    </div>
                </div>

                <!-- Recent Results -->
                <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700">
                    <div class="p-5 border-b border-gray-200 dark:border-gray-700">
                        <h2 class="text-lg font-semibold text-gray-900 dark:text-white">Recent Results</h2>
                    </div>
                    <div class="p-5">
                        @if(($recent_results ?? collect())->count() > 0)
                            <div class="space-y-3">
                                @foreach(($recent_results ?? collect()) as $result)
                                    <div class="flex items-center justify-between p-4 rounded-lg border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-700">
                                        <div>
                                            <h3 class="text-sm font-semibold text-gray-900 dark:text-white">{{ $result->exam->title }}</h3>
                                            <p class="text-xs text-gray-500 dark:text-gray-300">{{ optional($result->completed_at)->format('M d, Y H:i') }}</p>
                                        </div>
                                        <div class="text-right">
                                            <p class="text-sm font-semibold text-gray-900 dark:text-white">{{ number_format($result->percentage ?? 0, 1) }}%</p>
                                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-medium
                                                @if(($result->percentage ?? 0) >= 80) bg-green-100 text-green-800
                                                @elseif(($result->percentage ?? 0) >= 60) bg-yellow-100 text-yellow-800
                                                @else bg-red-100 text-red-800 @endif">
                                                {{ $result->grade }}
                                            </span>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <p class="text-sm text-gray-500 dark:text-gray-400 text-center py-4">No exam results yet.</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
