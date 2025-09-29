@extends('layouts.partner-layout')

@section('title', 'Exam Results - ' . $exam->title)

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-50 via-white to-gray-100 dark:from-gray-900 dark:via-gray-800 dark:to-gray-900">
    <div class="space-y-6 p-4 sm:p-6 lg:p-8">
        <!-- Header -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl border border-gray-200 dark:border-gray-700 p-6">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div class="flex flex-col sm:flex-row sm:items-center gap-4">
                    <a href="{{ route('partner.exams.show', $exam) }}" 
                       class="inline-flex items-center px-4 py-2.5 text-sm font-semibold text-gray-700 bg-gray-100 hover:bg-gray-200 border border-gray-300 rounded-xl transition-all duration-200 hover:shadow-md dark:bg-gray-700 dark:border-gray-600 dark:text-gray-300 dark:hover:bg-gray-600">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                        Back to Exam
                    </a>
                    <div>
                        <h1 class="text-2xl sm:text-3xl font-bold bg-gradient-to-r from-blue-600 to-purple-600 bg-clip-text text-transparent dark:from-blue-400 dark:to-purple-400">
                            Exam Results
                        </h1>
                        <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">Comprehensive performance analytics</p>
                    </div>
                </div>
                <div class="flex flex-col sm:flex-row gap-3">
                    <a href="{{ route('partner.exams.paper-parameters', $exam) }}" 
                       class="inline-flex items-center justify-center px-6 py-2.5 text-sm font-semibold text-white bg-gradient-to-r from-green-500 to-green-600 hover:from-green-600 hover:to-green-700 rounded-xl shadow-lg hover:shadow-xl transition-all duration-200 transform hover:-translate-y-0.5">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path>
                        </svg>
                        <span class="hidden sm:inline">Download Question Paper</span>
                        <span class="sm:hidden">Download</span>
                    </a>
                </div>
            </div>
        </div>

        <!-- Exam Information Card -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl border border-gray-200 dark:border-gray-700 overflow-hidden">
            <div class="bg-gradient-to-r from-blue-50 to-indigo-50 dark:from-blue-900/20 dark:to-indigo-900/20 px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                <div class="flex flex-col sm:flex-row sm:items-center gap-4">
                    <div class="flex items-center space-x-3">
                        <div class="inline-flex items-center px-3 py-1.5 rounded-xl text-sm font-bold bg-gradient-to-r from-blue-500 to-indigo-600 text-white shadow-lg">
                            #{{ $exam->id }}
                        </div>
                        <h2 class="text-lg sm:text-xl font-bold text-gray-900 dark:text-white">{{ $exam->title }}</h2>
                    </div>
                </div>
            </div>
            <div class="p-6">
                <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6">
                    <div class="text-center p-4 bg-gray-50 dark:bg-gray-700 rounded-xl">
                        <div class="text-xs font-semibold text-gray-500 dark:text-gray-400 mb-2 uppercase tracking-wide">Status</div>
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold
                            @if($exam->status === 'published') bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-300
                            @elseif($exam->status === 'draft') bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300
                            @elseif($exam->status === 'ongoing') bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-300
                            @elseif($exam->status === 'completed') bg-purple-100 text-purple-800 dark:bg-purple-900/30 dark:text-purple-300
                            @else bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-300 @endif">
                            {{ ucfirst($exam->status) }}
                        </span>
                    </div>
                    <div class="text-center p-4 bg-gray-50 dark:bg-gray-700 rounded-xl">
                        <div class="text-xs font-semibold text-gray-500 dark:text-gray-400 mb-2 uppercase tracking-wide">Questions</div>
                        <div class="text-lg font-bold text-gray-900 dark:text-white">{{ $exam->total_questions }}</div>
                    </div>
                    <div class="text-center p-4 bg-gray-50 dark:bg-gray-700 rounded-xl">
                        <div class="text-xs font-semibold text-gray-500 dark:text-gray-400 mb-2 uppercase tracking-wide">Passing</div>
                        <div class="text-lg font-bold text-gray-900 dark:text-white">{{ $exam->passing_marks }}%</div>
                    </div>
                    <div class="text-center p-4 bg-gray-50 dark:bg-gray-700 rounded-xl">
                        <div class="text-xs font-semibold text-gray-500 dark:text-gray-400 mb-2 uppercase tracking-wide">Duration</div>
                        <div class="text-lg font-bold text-gray-900 dark:text-white">
                            @php
                                $hours = floor($exam->duration / 60);
                                $minutes = $exam->duration % 60;
                            @endphp
                            @if($hours > 0)
                                {{ $hours }}H{{ $minutes > 0 ? ' ' . $minutes . 'M' : '' }}
                            @else
                                {{ $minutes }}M
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Statistics Cards -->
        @if($results->count() > 0)
        @php
            $totalStudents = $results->count();
            $attemptedStudents = $results->where('status', '!=', 'absent')->count();
            $absentStudents = $results->where('status', 'absent')->count();
            $passedStudents = $results->where('status', '!=', 'absent')
                                     ->where('percentage', '>=', $exam->passing_marks)
                                     ->count();
            $failedStudents = $attemptedStudents - $passedStudents;
            
            // If you're using pagination, you might want to use the total() method from the paginator
            // $totalStudents = $results instanceof \Illuminate\Pagination\LengthAwarePaginator ? $results->total() : $results->count();
            
            $avgScore = $results->where('status', '!=', 'absent')
                               ->avg('percentage') ?? 0;
            
            // Calculate average time based on exam duration for students who completed
            $avgTime = $results->where('status', '!=', 'absent')
                              ->whereNotNull('completed_at')
                              ->count() > 0 ? $exam->duration : null;
        @endphp
        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-3 sm:gap-4">
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 border border-gray-200 dark:border-gray-700 p-4">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-10 h-10 bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl flex items-center justify-center shadow-lg">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="ml-3">
                        <p class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wide">Total</p>
                        <p class="text-lg font-bold text-gray-900 dark:text-white">{{ $totalStudents }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 border border-gray-200 dark:border-gray-700 p-4">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-10 h-10 bg-gradient-to-br from-orange-500 to-orange-600 rounded-xl flex items-center justify-center shadow-lg">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="ml-3">
                        <p class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wide">Attempted</p>
                        <p class="text-lg font-bold text-gray-900 dark:text-white">{{ $attemptedStudents }}</p>
                        <p class="text-xs text-gray-500 dark:text-gray-400">{{ $totalStudents > 0 ? round(($attemptedStudents / $totalStudents) * 100, 1) : 0 }}%</p>
                    </div>
                </div>
            </div>

            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 border border-gray-200 dark:border-gray-700 p-4">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-10 h-10 bg-gradient-to-br from-green-500 to-green-600 rounded-xl flex items-center justify-center shadow-lg">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 1 1-18 0 9 9 0 0 1 18 0z"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="ml-3">
                        <p class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wide">Passed</p>
                        <p class="text-lg font-bold text-gray-900 dark:text-white">{{ $passedStudents }}</p>
                        <p class="text-xs text-gray-500 dark:text-gray-400">{{ $totalStudents > 0 ? round(($passedStudents / $totalStudents) * 100, 1) : 0 }}%</p>
                    </div>
                </div>
            </div>

            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 border border-gray-200 dark:border-gray-700 p-4">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-10 h-10 bg-gradient-to-br from-red-500 to-red-600 rounded-xl flex items-center justify-center shadow-lg">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 1 1-18 0 9 9 0 0 1 18 0z"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="ml-3">
                        <p class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wide">Failed</p>
                        <p class="text-lg font-bold text-gray-900 dark:text-white">{{ $failedStudents }}</p>
                        <p class="text-xs text-gray-500 dark:text-gray-400">{{ $totalStudents > 0 ? round(($failedStudents / $totalStudents) * 100, 1) : 0 }}%</p>
                    </div>
                </div>
            </div>

            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 border border-gray-200 dark:border-gray-700 p-4">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-10 h-10 bg-gradient-to-br from-gray-500 to-gray-600 rounded-xl flex items-center justify-center shadow-lg">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192L5.636 18.364M12 2.25a9.75 9.75 0 100 19.5 9.75 9.75 0 000-19.5z"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="ml-3">
                        <p class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wide">Absent</p>
                        <p class="text-lg font-bold text-gray-900 dark:text-white">{{ $absentStudents }}</p>
                        <p class="text-xs text-gray-500 dark:text-gray-400">{{ $totalStudents > 0 ? round(($absentStudents / $totalStudents) * 100, 1) : 0 }}%</p>
                    </div>
                </div>
            </div>

            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 border border-gray-200 dark:border-gray-700 p-4">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-10 h-10 bg-gradient-to-br from-purple-500 to-purple-600 rounded-xl flex items-center justify-center shadow-lg">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="ml-3">
                        <p class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wide">Avg Score</p>
                        <p class="text-lg font-bold text-gray-900 dark:text-white">{{ $attemptedStudents > 0 ? round($avgScore, 1) : 0 }}%</p>
                        <p class="text-xs text-gray-500 dark:text-gray-400">{{ $exam->duration }}m Duration</p>
                    </div>
                </div>
            </div>
    </div>

        <!-- Results Table -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl border border-gray-200 dark:border-gray-700 overflow-hidden">
            <div class="bg-gradient-to-r from-gray-50 to-gray-100 dark:from-gray-700 dark:to-gray-800 px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                    <div>
                        <h3 class="text-lg sm:text-xl font-bold text-gray-900 dark:text-white">Student Results</h3>
                        <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">Performance overview and detailed analytics</p>
                    </div>
                    <div class="flex flex-col sm:flex-row sm:items-center gap-3">
                        <a href="{{ route('partner.exams.result-entry', $exam) }}" 
                           class="inline-flex items-center px-4 py-2.5 text-sm font-semibold text-white bg-gradient-to-r from-indigo-500 to-indigo-600 hover:from-indigo-600 hover:to-indigo-700 rounded-xl shadow-lg hover:shadow-xl transition-all duration-200 transform hover:-translate-y-0.5">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                            </svg>
                            Result Entry
                        </a>
                    </div>
                </div>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                    <thead class="bg-gray-50 dark:bg-gray-700">
                        <tr>
                            <th class="px-4 py-4 text-left text-xs font-semibold text-gray-500 dark:text-gray-300 uppercase tracking-wider">Student</th>
                            <th class="px-3 py-4 text-left text-xs font-semibold text-gray-500 dark:text-gray-300 uppercase tracking-wider">Type</th>
                            <th class="px-3 py-4 text-left text-xs font-semibold text-gray-500 dark:text-gray-300 uppercase tracking-wider">Score</th>
                            <th class="px-3 py-4 text-left text-xs font-semibold text-gray-500 dark:text-gray-300 uppercase tracking-wider">%</th>
                            <th class="px-3 py-4 text-left text-xs font-semibold text-gray-500 dark:text-gray-300 uppercase tracking-wider">Status</th>
                            <th class="px-3 py-4 text-left text-xs font-semibold text-gray-500 dark:text-gray-300 uppercase tracking-wider">Duration</th>
                            <th class="px-3 py-4 text-left text-xs font-semibold text-gray-500 dark:text-gray-300 uppercase tracking-wider">Completed</th>
                            <th class="px-4 py-4 text-left text-xs font-semibold text-gray-500 dark:text-gray-300 uppercase tracking-wider">Details</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                        @forelse($results as $result)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors duration-200">
                            <td class="px-4 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-10 w-10">
                                        @if($result->student->photo && file_exists(public_path('storage/' . $result->student->photo)))
                                            <img class="h-10 w-10 rounded-full object-cover border-2 border-gray-200 dark:border-gray-600" 
                                                 src="{{ asset('storage/' . $result->student->photo) }}" 
                                                 alt="{{ $result->student->full_name }}">
                                        @else
                                            <div class="h-10 w-10 rounded-full bg-gradient-to-br from-blue-500 to-purple-600 flex items-center justify-center border-2 border-gray-200 dark:border-gray-600 shadow-lg">
                                                <span class="text-sm font-bold text-white">
                                                    {{ strtoupper(substr($result->student->full_name, 0, 1)) }}{{ strtoupper(substr(explode(' ', $result->student->full_name)[1] ?? '', 0, 1)) }}
                                                </span>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-semibold text-gray-900 dark:text-white">{{ $result->student->full_name }}</div>
                                        <div class="text-xs text-gray-500 dark:text-gray-400">{{ $result->student->student_id }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-3 py-4 whitespace-nowrap">
                                @if($result->status === 'absent')
                                    <div class="flex items-center justify-center">
                                        <svg class="w-5 h-5 text-gray-400 dark:text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" title="Absent">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192L5.636 18.364M12 2.25a9.75 9.75 0 100 19.5 9.75 9.75 0 000-19.5z"></path>
                                        </svg>
                                    </div>
                                @elseif($result->result_type === 'auto')
                                    <div class="flex items-center justify-center">
                                        <svg class="w-5 h-5 text-green-500 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" title="Auto Generated">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 1 1-18 0 9 9 0 0 1 18 0z"></path>
                                        </svg>
                                    </div>
                                @else
                                    <div class="flex items-center justify-center">
                                        <a href="{{ route('partner.exams.result-edit', ['exam' => $exam, 'result' => $result]) }}" 
                                           class="inline-flex items-center justify-center p-1 rounded-lg hover:bg-blue-50 dark:hover:bg-blue-900/20 transition-colors duration-200 group"
                                           title="Edit Manual Result">
                                            <svg class="w-5 h-5 text-blue-500 dark:text-blue-400 group-hover:text-blue-600 dark:group-hover:text-blue-300 transition-colors duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                            </svg>
                                        </a>
                                    </div>
                                @endif
                            </td>
                            <td class="px-3 py-4 whitespace-nowrap">
                                @if($result->status === 'absent')
                                    <div class="text-sm text-gray-500 dark:text-gray-400">N/A</div>
                                    <div class="text-xs text-gray-500 dark:text-gray-400">Not attempted</div>
                                @else
                                    <div class="text-sm font-bold text-gray-900 dark:text-white">{{ $result->score }}/{{ $result->total_questions }}</div>
                                    <div class="text-xs text-gray-500 dark:text-gray-400">
                                        {{ $result->correct_answers }}✓ {{ $result->wrong_answers }}✗
                                    </div>
                                @endif
                            </td>
                            <td class="px-3 py-4 whitespace-nowrap">
                                @if($result->status === 'absent')
                                    <div class="flex items-center">
                                        <span class="text-sm font-medium text-gray-500 dark:text-gray-400">N/A</span>
                                        <div class="ml-2 w-12 bg-gray-200 dark:bg-gray-700 rounded-full h-2">
                                            <div class="bg-gray-400 h-2 rounded-full" style="width: 0%"></div>
                                        </div>
                                    </div>
                                @else
                                    <div class="flex items-center">
                                        <span class="text-sm font-bold text-gray-900 dark:text-white">{{ $result->percentage }}%</span>
                                        <div class="ml-2 w-12 bg-gray-200 dark:bg-gray-700 rounded-full h-2">
                                            <div class="bg-gradient-to-r from-blue-500 to-blue-600 h-2 rounded-full" style="width: {{ $result->percentage }}%"></div>
                                        </div>
                                    </div>
                                @endif
                            </td>
                            <td class="px-3 py-4 whitespace-nowrap">
                                @if($result->status === 'absent')
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300">
                                        Absent
                                    </span>
                                @elseif($result->percentage >= $exam->passing_marks)
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-300">
                                        Pass
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-300">
                                        Fail
                                    </span>
                                @endif
                            </td>
                            <td class="px-3 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white">
                                @if($result->status === 'absent')
                                    <span class="text-gray-500 dark:text-gray-400">N/A</span>
                                @else
                                    <div class="font-bold">{{ $exam->duration }}m</div>
                                    <div class="text-xs text-gray-500 dark:text-gray-400">Exam Duration</div>
                                @endif
                            </td>
                            <td class="px-3 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white">
                                @if($result->status === 'absent')
                                    <span class="text-gray-500 dark:text-gray-400">N/A</span>
                                @elseif($result->completed_at)
                                    <div class="font-bold">{{ $result->completed_at->format('M d, H:i') }}</div>
                                @else
                                    <span class="text-gray-500 dark:text-gray-400">-</span>
                                @endif
                            </td>
                            <td class="px-4 py-4 whitespace-nowrap text-sm font-medium">
                                @if($result->status === 'absent')
                                    <span class="text-gray-400 dark:text-gray-500">N/A</span>
                                @else
                                    <div class="flex items-center space-x-2">
                                        <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm font-semibold rounded-xl text-white bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 shadow-lg hover:shadow-xl transition-all duration-200 transform hover:-translate-y-0.5" 
                                                onclick="showResultDetails({{ $result->id }})">
                                            View
                                        </button>
                                    </div>
                                @endif
                            </td>
                    </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="px-6 py-12 text-center">
                                <div class="flex flex-col items-center">
                                    <svg class="mx-auto h-16 w-16 text-gray-400 dark:text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                                    </svg>
                                    <h3 class="mt-4 text-lg font-semibold text-gray-900 dark:text-white">No results found</h3>
                                    <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">No students have taken this exam yet.</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            <!-- Pagination -->
            @if(method_exists($results, 'hasPages') && $results->hasPages())
            <div class="px-6 py-4 border-t border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-700/50">
                {{ $results->links() }}
            </div>
            @endif
        </div>
        @else
        <!-- No Results State -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl border border-gray-200 dark:border-gray-700 p-12 text-center">
            <svg class="mx-auto h-20 w-20 text-gray-400 dark:text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
            </svg>
            <h3 class="mt-4 text-xl font-bold text-gray-900 dark:text-white">No results yet</h3>
            <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">
                Students haven't taken this exam yet or results haven't been processed.
            </p>
        </div>
        @endif
</div>

        <!-- Result Details Modal -->
        <div id="resultModal" class="fixed inset-0 bg-black bg-opacity-50 overflow-y-auto h-full w-full hidden" style="z-index: 99999;">
            <div class="relative top-4 sm:top-10 mx-auto p-4 w-11/12 sm:w-5/6 md:w-4/5 lg:w-3/4 xl:w-2/3 max-w-6xl shadow-2xl rounded-2xl bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700" style="z-index: 100000;">
                <div class="mt-3">
                    <div class="flex items-center justify-between mb-6">
                        <div>
                            <h3 class="text-xl sm:text-2xl font-bold text-gray-900 dark:text-white">Result Details</h3>
                            <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">Comprehensive performance analysis</p>
                        </div>
                        <button onclick="closeResultModal()" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 transition-colors duration-200 p-2 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>
                    <div id="resultDetails" class="space-y-6">
                        <!-- Result details will be loaded here -->
                    </div>
                </div>
    </div>
</div>


<script>
function showResultDetails(resultId) {
    // Show loading state
    document.getElementById('resultDetails').innerHTML = `
        <div class="text-center py-8">
            <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-blue-600 mx-auto"></div>
            <p class="mt-4 text-gray-500 dark:text-gray-400">Loading result details...</p>
        </div>
    `;
    document.getElementById('resultModal').classList.remove('hidden');

    // Fetch detailed result data
    fetch(`/partner/exams/{{ $exam->id }}/results/${resultId}/details`)
        .then(response => response.json())
        .then(data => {
            if (data.error) {
                document.getElementById('resultDetails').innerHTML = `
                    <div class="text-center py-8">
                        <div class="text-red-500 text-lg font-medium">Error</div>
                        <p class="mt-2 text-gray-500 dark:text-gray-400">${data.error}</p>
                    </div>
                `;
                return;
            }

            // Debug: Log the data to console to help identify issues
            console.log('Modal data:', data);
            if (data.questions) {
                console.log('Questions with options:', data.questions.filter(q => q.question_type === 'mcq').map(q => ({
                    id: q.id,
                    question_type: q.question_type,
                    has_options: !!q.options,
                    options_keys: q.options ? Object.keys(q.options) : null,
                    options: q.options
                })));
            }

            // Display the detailed result information
            document.getElementById('resultDetails').innerHTML = `
                <div class="space-y-6">
                    <!-- Student Information -->
                    <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4">
                        <h4 class="text-lg font-semibold text-gray-900 dark:text-white mb-3">Student Information</h4>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="text-sm font-medium text-gray-500 dark:text-gray-400">Name</label>
                                <p class="text-gray-900 dark:text-white">${data.result.student_name}</p>
                            </div>
                            <div>
                                <label class="text-sm font-medium text-gray-500 dark:text-gray-400">Student ID</label>
                                <p class="text-gray-900 dark:text-white">${data.result.student_id}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Exam Performance Summary -->
                    <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4">
                        <h4 class="text-lg font-semibold text-gray-900 dark:text-white mb-3">Exam Performance Summary</h4>
                        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                            <div class="text-center">
                                <div class="text-2xl font-bold text-blue-600 dark:text-blue-400">${data.result.percentage}%</div>
                                <div class="text-sm text-gray-500 dark:text-gray-400">Score</div>
                            </div>
                            <div class="text-center">
                                <div class="text-2xl font-bold text-green-600 dark:text-green-400">${data.result.correct_answers}</div>
                                <div class="text-sm text-gray-500 dark:text-gray-400">Correct</div>
                            </div>
                            <div class="text-center">
                                <div class="text-2xl font-bold text-red-600 dark:text-red-400">${data.result.wrong_answers}</div>
                                <div class="text-sm text-gray-500 dark:text-gray-400">Wrong</div>
                            </div>
                            <div class="text-center">
                                <div class="text-2xl font-bold text-gray-600 dark:text-gray-400">${data.result.unanswered}</div>
                                <div class="text-sm text-gray-500 dark:text-gray-400">Unanswered</div>
                            </div>
                        </div>
                        <div class="mt-4 text-center">
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium ${data.result.is_passed ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200' : 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200'}">
                                ${data.result.is_passed ? 'Passed' : 'Failed'} (${data.result.passing_marks}% required)
                            </span>
                        </div>
                    </div>

                    <!-- Time Information -->
                    <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4">
                        <h4 class="text-lg font-semibold text-gray-900 dark:text-white mb-3">Time Information</h4>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div>
                                <label class="text-sm font-medium text-gray-500 dark:text-gray-400">Started At</label>
                                <p class="text-gray-900 dark:text-white">${data.result.started_at || 'N/A'}</p>
                            </div>
                            <div>
                                <label class="text-sm font-medium text-gray-500 dark:text-gray-400">Completed At</label>
                                <p class="text-gray-900 dark:text-white">${data.result.completed_at || 'N/A'}</p>
                            </div>
                            <div>
                                <label class="text-sm font-medium text-gray-500 dark:text-gray-400">Time Taken</label>
                                <p class="text-gray-900 dark:text-white">${data.result.time_taken ? data.result.time_taken + ' minutes' : 'N/A'}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Question-by-Question Details -->
                    <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4">
                        <h4 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Question-by-Question Analysis</h4>
                        <div class="space-y-4">
                            ${data.questions ? data.questions.map((question, index) => `
                                <div class="border border-gray-200 dark:border-gray-600 rounded-lg p-4 ${question.is_correct ? 'bg-green-50 dark:bg-green-900/20' : question.is_skipped ? 'bg-yellow-50 dark:bg-yellow-900/20' : 'bg-red-50 dark:bg-red-900/20'}">
                                    <div class="flex items-start justify-between mb-3">
                                        <div class="flex items-center space-x-3">
                                            <span class="inline-flex items-center justify-center w-8 h-8 rounded-full text-sm font-medium ${question.is_correct ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200' : question.is_skipped ? 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200' : 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200'}">
                                                ${index + 1}
                                            </span>
                                            <div>
                                                <h5 class="font-medium text-gray-900 dark:text-white">Question ${index + 1}</h5>
                                                <p class="text-sm text-gray-500 dark:text-gray-400">${question.question_type?.toUpperCase() || 'MCQ'} • ${question.marks || 1} mark${(question.marks || 1) > 1 ? 's' : ''}</p>
                                            </div>
                                        </div>
                                        <div class="text-right">
                                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium ${question.is_correct ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200' : question.is_skipped ? 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200' : 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200'}">
                                                ${question.is_correct ? 'Correct' : question.is_skipped ? 'Skipped' : 'Wrong'}
                                            </span>
                                            <p class="text-sm font-medium text-gray-900 dark:text-white mt-1">${question.score || 0}/${question.marks || 1}</p>
                                        </div>
                                    </div>
                                    
                                    <div class="mb-4">
                                        <p class="text-gray-900 dark:text-white font-medium mb-2">${question.question_text || 'Question text not available'}</p>
                                    </div>

                                    ${question.question_type === 'mcq' ? `
                                        <div class="space-y-2 mb-4">
                                            <h6 class="text-sm font-medium text-gray-700 dark:text-gray-300">Answer Options:</h6>
                                            <div class="grid grid-cols-1 md:grid-cols-2 gap-2">
                                                ${question.options && Object.keys(question.options).length > 0 ? Object.entries(question.options).map(([key, value]) => `
                                                    <div class="flex items-center space-x-2 p-2 rounded ${key === question.correct_answer ? 'bg-green-100 dark:bg-green-900/30' : key === question.submitted_answer ? 'bg-blue-100 dark:bg-blue-900/30' : 'bg-gray-100 dark:bg-gray-800'}">
                                                        <span class="text-sm font-medium ${key === question.correct_answer ? 'text-green-800 dark:text-green-200' : key === question.submitted_answer ? 'text-blue-800 dark:text-blue-200' : 'text-gray-700 dark:text-gray-300'}">${key.toUpperCase()}</span>
                                                        <span class="text-sm ${key === question.correct_answer ? 'text-green-700 dark:text-green-300' : key === question.submitted_answer ? 'text-blue-700 dark:text-blue-300' : 'text-gray-600 dark:text-gray-400'}">${value}</span>
                                                        ${key === question.correct_answer ? '<span class="text-green-600 dark:text-green-400">✓</span>' : ''}
                                                        ${key === question.submitted_answer && key !== question.correct_answer ? '<span class="text-red-600 dark:text-red-400">✗</span>' : ''}
                                                    </div>
                                                `).join('') : `
                                                    <div class="text-center p-4 bg-yellow-50 dark:bg-yellow-900/20 rounded-lg border border-yellow-200 dark:border-yellow-800">
                                                        <p class="text-sm text-yellow-800 dark:text-yellow-200 font-medium">No options available for this question</p>
                                                        <p class="text-xs text-yellow-600 dark:text-yellow-400 mt-1">This might be a descriptive question or options were not saved properly</p>
                                                    </div>
                                                `}
                                            </div>
                                        </div>
                                    ` : `
                                        <div class="space-y-2 mb-4">
                                            <h6 class="text-sm font-medium text-gray-700 dark:text-gray-300">Answer:</h6>
                                            <div class="p-3 bg-gray-100 dark:bg-gray-800 rounded-lg">
                                                <p class="text-sm text-gray-900 dark:text-white">${question.submitted_answer || 'No answer submitted'}</p>
                                            </div>
                                        </div>
                                    `}

                                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-sm">
                                        <div>
                                            <span class="font-medium text-gray-700 dark:text-gray-300">Correct Answer:</span>
                                            <p class="text-gray-900 dark:text-white">${question.correct_answer || 'N/A'}</p>
                                        </div>
                                        <div>
                                            <span class="font-medium text-gray-700 dark:text-gray-300">Submitted Answer:</span>
                                            <p class="text-gray-900 dark:text-white">${question.submitted_answer || 'Not answered'}</p>
                                        </div>
                                        <div>
                                            <span class="font-medium text-gray-700 dark:text-gray-300">Time Taken:</span>
                                            <p class="text-gray-900 dark:text-white">${question.time_taken ? question.time_taken + 's' : 'N/A'}</p>
                                        </div>
                                    </div>
                                </div>
                            `).join('') : '<p class="text-gray-500 dark:text-gray-400 text-center py-4">Question details not available</p>'}
                        </div>
                    </div>

                    <!-- Detailed Analytics -->
                    ${data.analytics ? `
                    <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4">
                        <h4 class="text-lg font-semibold text-gray-900 dark:text-white mb-3">Performance Analytics</h4>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="text-sm font-medium text-gray-500 dark:text-gray-400">Accuracy</label>
                                <p class="text-gray-900 dark:text-white">${data.analytics.accuracy}%</p>
                            </div>
                            <div>
                                <label class="text-sm font-medium text-gray-500 dark:text-gray-400">Average Time per Question</label>
                                <p class="text-gray-900 dark:text-white">${data.analytics.average_time_per_question} seconds</p>
                            </div>
                        </div>
                    </div>
                    ` : ''}
                </div>
            `;
        })
        .catch(error => {
            console.error('Error fetching result details:', error);
            document.getElementById('resultDetails').innerHTML = `
                <div class="text-center py-8">
                    <div class="text-red-500 text-lg font-medium">Error</div>
                    <p class="mt-2 text-gray-500 dark:text-gray-400">Failed to load result details. Please try again.</p>
                </div>
            `;
        });
}

function closeResultModal() {
    document.getElementById('resultModal').classList.add('hidden');
}

// Close modal when clicking outside
document.getElementById('resultModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeResultModal();
    }
});

</script>
@endsection
