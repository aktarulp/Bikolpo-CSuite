@extends('layouts.student-layout')

@section('title', 'Exam Result - ' . ($exam->title ?? 'Unknown Exam'))

@section('content')
<div class="min-h-screen py-6">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center w-16 h-16 md:w-18 md:h-18 bg-gradient-to-br from-primaryGreen to-emerald-500 rounded-full shadow-lg mb-3">
                <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
            <h1 class="text-2xl md:text-3xl font-bold text-gray-900 mb-1.5">Exam Result</h1>
            <p class="text-base md:text-lg text-gray-600">Congratulations on completing {{ $exam->title ?? 'your exam' }}</p>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg overflow-hidden mb-8">
            <div class="bg-gradient-to-r from-primaryGreen to-emerald-600 text-white p-6 md:p-7">
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 md:gap-8 items-center">
                    <div class="text-center lg:text-left">
                        <h2 class="text-xl md:text-2xl font-bold mb-1.5">{{ $exam->title ?? 'Unknown Exam' }}</h2>
                        <p class="text-emerald-100 text-sm md:text-base">{{ $exam->description ?? 'Online Examination' }}</p>
                    </div>

                    <div class="text-center">
                        <div class="inline-flex items-center justify-center w-28 h-28 md:w-30 md:h-30 bg-white/20 rounded-full backdrop-blur-sm">
                            <div class="text-center">
                                <div class="text-2xl md:text-3xl font-bold">{{ $result->percentage !== null ? number_format($result->percentage, 1) : '0.0' }}%</div>
                                <div class="text-[10px] md:text-xs text-emerald-100">Score</div>
                            </div>
                        </div>
                    </div>

                    <div class="text-center lg:text-right">
                        <div class="text-lg md:text-xl font-bold mb-1.5">{{ $result->grade ?? 'N/A' }}</div>
                        <div class="text-emerald-100">
                            @if($result->percentage !== null && $result->percentage >= ($exam->passing_marks ?? 50))
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-500 text-white">
                                    PASSED
                                </span>
                            @elseif($result->percentage !== null)
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-500 text-white">
                                    FAILED
                                </span>
                            @else
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-500 text-white">
                                    NO RESULT
                                </span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <div class="p-7">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-7 mb-7">
                    <div class="bg-gray-50 dark:bg-gray-700 rounded-xl p-5">
                        <h3 class="text-lg font-semibold text-gray-900 mb-3 flex items-center">
                            <svg class="w-5 h-5 text-primaryGreen mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                            Student Information
                        </h3>
                        <div class="space-y-2">
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-600 font-medium">Name:</span>
                                <span class="text-gray-900 font-semibold">{{ $result->student->full_name ?? 'Student Name' }}</span>
                            </div>
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-600 font-medium">Student ID:</span>
                                <span class="text-gray-900 font-semibold">{{ $result->student->student_id ?? 'N/A' }}</span>
                            </div>
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-600 font-medium">Email:</span>
                                <span class="text-gray-900 font-semibold">{{ $result->student->email ?? 'N/A' }}</span>
                            </div>
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-600 font-medium">Class/Grade:</span>
                                <span class="text-gray-900 font-semibold">{{ $result->student->class_grade ?? 'N/A' }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="bg-gray-50 dark:bg-gray-700 rounded-xl p-5">
                        <h3 class="text-lg font-semibold text-gray-900 mb-3 flex items-center">
                            <svg class="w-5 h-5 text-primaryGreen mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                            </svg>
                            Institute Information
                        </h3>
                        <div class="space-y-2">
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-600 font-medium">Institute:</span>
                                <span class="text-gray-900 font-semibold">{{ ($result->student->partner->name ?? $result->student->school_college) ?? 'Institute Name' }}</span>
                            </div>
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-600 font-medium">School/College:</span>
                                <span class="text-gray-900 font-semibold">{{ $result->student->school_college ?? 'N/A' }}</span>
                            </div>
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-600 font-medium">Address:</span>
                                <span class="text-gray-900 font-semibold">{{ $result->student->city ?? 'N/A' }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-gradient-to-r from-blue-50 to-indigo-50 dark:bg-gradient-to-r dark:from-gray-700 dark:to-gray-800 rounded-xl p-6 mb-7">
                    <h3 class="text-lg font-semibold text-gray-900 mb-5 text-center">Exam Performance Summary</h3>
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-5">
                        <div class="text-center">
                            <div class="bg-white dark:bg-gray-700 rounded-lg p-3 shadow-sm">
                                <div class="text-2xl font-bold text-blue-600 mb-1.5">{{ $result->total_questions ?? 0 }}</div>
                                <div class="text-xs text-gray-600 font-medium">Total Questions</div>
                            </div>
                        </div>

                        <div class="text-center">
                            <div class="bg-white dark:bg-gray-700 rounded-lg p-3 shadow-sm">
                                <div class="text-2xl font-bold text-green-600 mb-1.5">{{ $result->correct_answers ?? 0 }}</div>
                                <div class="text-xs text-gray-600 font-medium">Correct Answers</div>
                            </div>
                        </div>

                        <div class="text-center">
                            <div class="bg-white dark:bg-gray-700 rounded-lg p-3 shadow-sm">
                                <div class="text-2xl font-bold text-red-600 mb-1.5">{{ $result->wrong_answers ?? 0 }}</div>
                                <div class="text-xs text-gray-600 font-medium">Wrong Answers</div>
                            </div>
                        </div>

                        <div class="text-center">
                            <div class="bg-white dark:bg-gray-700 rounded-lg p-3 shadow-sm">
                                <div class="text-2xl font-bold text-orange-600 mb-1.5">{{ $result->unanswered ?? 0 }}</div>
                                <div class="text-xs text-gray-600 font-medium">Unanswered</div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-7 mb-7">
                    <div class="bg-white border border-gray-200 dark:bg-gray-700 dark:border-gray-600 rounded-xl p-5 shadow-sm">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                            <svg class="w-5 h-5 text-green-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            Marks Earned
                        </h3>
                        <div class="space-y-3">
                            <div class="flex justify-between items-center p-3 bg-green-50 dark:bg-green-900 rounded-lg text-sm">
                                <span class="text-gray-700 font-medium">Correct Answers:</span>
                                <span class="text-green-600 font-bold">
                                    @if(($result->correct_answers ?? 0) > 0)
                                        {{ $result->correct_answers }} &times; {{ round(($result->score ?? 0) / ($result->correct_answers ?? 1), 2) }} = {{ $result->score ?? 0 }}
                                    @else
                                        {{ $result->correct_answers ?? 0 }} &times; 0 = {{ $result->score ?? 0 }}
                                    @endif
                                </span>
                            </div>
                            @if($exam->has_negative_marking)
                            <div class="flex justify-between items-center p-3 bg-red-50 dark:bg-red-900 rounded-lg text-sm">
                                <span class="text-gray-700 font-medium">Wrong Answers (Deduction):</span>
                                <span class="text-red-600 font-bold">-{{ $result->wrong_answers ?? 0 }} &times; {{ $exam->negative_marks_per_question ?? 0 }} = -{{ number_format(($result->wrong_answers ?? 0) * ($exam->negative_marks_per_question ?? 0), 2) }}</span>
                            </div>
                            @endif
                            <div class="flex justify-between items-center p-3 bg-blue-50 dark:bg-blue-900 rounded-lg text-sm">
                                <span class="text-gray-700 font-medium">Final Score:</span>
                                <span class="text-blue-600 font-bold text-lg">{{ $result->score ?? 0 }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white border border-gray-200 dark:bg-gray-700 dark:border-gray-600 rounded-xl p-5 shadow-sm">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                            <svg class="w-5 h-5 text-purple-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                            </svg>
                            Performance Metrics
                        </h3>
                        <div class="space-y-3">
                            <div class="flex justify-between items-center p-3 bg-purple-50 dark:bg-purple-900 rounded-lg text-sm">
                                <span class="text-gray-700 font-medium">Score Percentage:</span>
                                <span class="text-purple-600 font-bold text-lg">{{ $result->percentage !== null ? number_format($result->percentage, 1) : '0.0' }}%</span>
                            </div>
                            <div class="flex justify-between items-center p-3 bg-indigo-50 dark:bg-indigo-900 rounded-lg text-sm">
                                <span class="text-gray-700 font-medium">Grade:</span>
                                <span class="text-indigo-600 font-bold text-lg">{{ $result->grade ?? 'N/A' }}</span>
                            </div>
                            <div class="flex justify-between items-center p-3 bg-yellow-50 dark:bg-yellow-900 rounded-lg text-sm">
                                <span class="text-gray-700 font-medium">Passing Marks:</span>
                                <span class="text-yellow-600 font-bold">{{ $exam->passing_marks ?? 0 }}%</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-gray-50 dark:bg-gray-700 rounded-xl p-6 mb-7">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                        <svg class="w-5 h-5 text-gray-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Time Information
                    </h3>
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                        <div class="text-center">
                            <div class="bg-white dark:bg-gray-700 rounded-lg p-3 shadow-sm">
                                <div class="text-xs text-gray-600 mb-1.5">Started At</div>
                                <div class="text-base font-semibold text-gray-900">{{ $result->started_at ? $result->started_at->format('M d, Y g:i A') : 'N/A' }}</div>
                            </div>
                        </div>

                        <div class="text-center">
                            <div class="bg-white dark:bg-gray-700 rounded-lg p-3 shadow-sm">
                                <div class="text-xs text-gray-600 mb-1.5">Completed At</div>
                                <div class="text-base font-semibold text-gray-900">{{ $result->completed_at ? $result->completed_at->format('M d, Y g:i A') : 'N/A' }}</div>
                            </div>
                        </div>

                        <div class="text-center">
                            <div class="bg-white dark:bg-gray-700 rounded-lg p-3 shadow-sm">
                                <div class="text-xs text-gray-600 mb-1.5">Time Taken</div>
                                <div class="text-base font-semibold text-gray-900">
                                    @if($result->started_at && $result->completed_at)
                                        {{ $result->started_at->diffInMinutes($result->completed_at) }} min
                                    @else
                                        N/A
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="text-center">
                            <div class="bg-white dark:bg-gray-700 rounded-lg p-3 shadow-sm">
                                <div class="text-xs text-gray-600 mb-1.5">Time Limit</div>
                                <div class="text-base font-semibold text-gray-900">{{ $exam->duration ?? 'N/A' }} min</div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-gradient-to-r from-yellow-50 to-orange-50 dark:bg-gradient-to-r dark:from-gray-700 dark:to-gray-800 rounded-xl p-6 mb-7">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4 text-center">Performance Insights</h3>
                    <div class="space-y-3">
                        @if($result->percentage !== null)
                            @if($result->percentage >= 90)
                                <div class="flex items-start p-3 bg-green-100 dark:bg-green-900 rounded-lg border border-green-200 dark:border-green-800">
                                    <svg class="w-5 h-5 text-green-600 mr-3 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                    <span class="text-green-800 font-medium text-xs">Outstanding performance! You've mastered this material with exceptional understanding.</span>
                                </div>
                            @elseif($result->percentage >= 80)
                                <div class="flex items-start p-3 bg-blue-100 dark:bg-blue-900 rounded-lg border border-blue-200 dark:border-blue-800">
                                    <svg class="w-5 h-5 text-blue-600 mr-3 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                    <span class="text-blue-800 font-medium text-xs">Excellent work! You have a solid understanding of the subject matter.</span>
                                </div>
                            @elseif($result->percentage >= 70)
                                <div class="flex items-start p-3 bg-yellow-100 dark:bg-yellow-900 rounded-lg border border-yellow-200 dark:border-yellow-800">
                                    <svg class="w-5 h-5 text-yellow-600 mr-3 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                    <span class="text-yellow-800 font-medium text-xs">Good job! Consider reviewing areas where you struggled for improvement.</span>
                                </div>
                            @else
                                <div class="flex items-start p-3 bg-red-100 dark:bg-red-900 rounded-lg border border-red-200 dark:border-red-800">
                                    <svg class="w-5 h-5 text-red-600 mr-3 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.34 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                                    </svg>
                                    <span class="text-red-800 font-medium text-xs">Keep practicing! Review the material thoroughly and try again for better results.</span>
                                </div>
                            @endif
                        @else
                            <div class="flex items-start p-3 bg-gray-100 dark:bg-gray-900 rounded-lg border border-gray-200 dark:border-gray-800">
                                <svg class="w-5 h-5 text-gray-600 mr-3 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.34 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                                </svg>
                                <span class="text-gray-800 font-medium text-xs">No score available for this exam.</span>
                            </div>
                        @endif

                        @if(($result->unanswered ?? 0) > 0)
                            <div class="flex items-start p-3 bg-orange-100 dark:bg-orange-900 rounded-lg border border-orange-200 dark:border-orange-800">
                                <svg class="w-5 h-5 text-orange-600 mr-3 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <span class="text-orange-800 font-medium text-xs">You left {{ $result->unanswered }} question(s) unanswered. Try to answer all questions next time for maximum points.</span>
                            </div>
                        @endif

                        @if($exam->has_negative_marking && ($result->wrong_answers ?? 0) > 0)
                            <div class="flex items-start p-3 bg-purple-100 dark:bg-purple-900 rounded-lg border border-purple-200 dark:border-purple-800">
                                <svg class="w-5 h-5 text-purple-600 mr-3 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.34 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                                </svg>
                                <span class="text-purple-800 font-medium text-xs">This exam has negative marking. Each wrong answer deducts {{ $exam->negative_marks_per_question ?? 0 }} marks.</span>
                            </div>
                        @endif
                    </div>
                </div>

                <div class="flex flex-col sm:flex-row gap-3 justify-center">
                    <a href="{{ route('student.dashboard') }}"
                       class="flex-1 sm:flex-none flex justify-center items-center py-2.5 px-6 bg-primaryGreen hover:bg-green-600 text-white font-semibold rounded-lg shadow-lg hover:shadow-xl transition-all duration-200 transform hover:-translate-y-0.5 text-sm">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                        </svg>
                        Back to Dashboard
                    </a>

                    <a href="{{ route('student.exams.history') }}"
                       class="flex-1 sm:flex-none flex justify-center items-center py-2.5 px-6 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg shadow-lg hover:shadow-xl transition-all duration-200 transform hover:-translate-y-0.5 text-sm">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                        </svg>
                        View History
                    </a>

                    <button onclick="window.print()"
                            class="flex-1 sm:flex-none flex justify-center items-center py-2.5 px-6 bg-gray-600 hover:bg-gray-700 text-white font-semibold rounded-lg shadow-lg hover:shadow-xl transition-all duration-200 transform hover:-translate-y-0.5 text-sm">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path>
                        </svg>
                        Print Report
                    </button>
                </div>
            </div>
        </div>

        <div class="text-center text-gray-500">
            <p class="text-xs">
                &copy; {{ date('Y') }} CSuite. All rights reserved. |
                Report generated on {{ now()->format('M d, Y g:i A') }}
            </p>
        </div>
    </div>
</div>

<style>
    @media print {
        body {
            background: white !important;
        }
        .bg-gradient-to-br {
            background: white !important;
        }
        .shadow-2xl, .shadow-xl, .shadow-lg, .shadow-sm {
            box-shadow: none !important;
        }
        .rounded-2xl, .rounded-xl, .rounded-lg {
            border-radius: 0 !important;
        }
        .bg-gradient-to-r {
            background: #f8fafc !important;
        }
        .bg-primaryGreen {
            background: #10b981 !important;
        }
        .text-primaryGreen {
            color: #10b981 !important;
        }
        .bg-emerald-600 {
            background: #059669 !important;
        }
        .text-emerald-600 {
            color: #059669 !important;
        }
        .bg-emerald-100 {
            background: #d1fae5 !important;
        }
        .text-emerald-100 {
            color: #059669 !important;
        }
        .bg-blue-50 {
            background: #eff6ff !important;
        }
        .bg-indigo-50 {
            background: #eef2ff !important;
        }
        .bg-yellow-50 {
            background: #fffbeb !important;
        }
        .bg-orange-50 {
            background: #fff7ed !important;
        }
        .bg-purple-50 {
            background: #faf5ff !important;
        }
        .bg-gray-50 {
            background: #f9fafb !important;
        }
        .bg-green-100 {
            background: #dcfce7 !important;
        }
        .bg-blue-100 {
            background: #dbeafe !important;
        }
        .bg-yellow-100 {
            background: #fef3c7 !important;
        }
        .bg-red-100 {
            background: #fee2e2 !important;
        }
        .bg-orange-100 {
            background: #fed7aa !important;
        }
        .bg-purple-100 {
            background: #f3e8ff !important;
        }
        .border-green-200 {
            border-color: #bbf7d0 !important;
        }
        .border-blue-200 {
            border-color: #bfdbfe !important;
        }
        .border-yellow-200 {
            border-color: #fde68a !important;
        }
        .border-red-200 {
            border-color: #fecaca !important;
        }
        .border-orange-200 {
            border-color: #fed7aa !important;
        }
        .border-purple-200 {
            border-color: #e9d5ff !important;
        }
        .text-green-800 {
            color: #166534 !important;
        }
        .text-blue-800 {
            color: #1e40af !important;
        }
        .text-yellow-800 {
            color: #92400e !important;
        }
        .text-red-800 {
            color: #991b1b !important;
        }
        .text-orange-800 {
            color: #9a3412 !important;
        }
        .text-purple-800 {
            color: #6b21a8 !important;
        }
        .text-green-600 {
            color: #059669 !important;
        }
        .text-blue-600 {
            color: #2563eb !important;
        }
        .text-yellow-600 {
            color: #d97706 !important;
        }
        .text-red-600 {
            color: #dc2626 !important;
        }
        .text-orange-600 {
            color: #ea580c !important;
        }
        .text-purple-600 {
            color: #9333ea !important;
        }
        .text-indigo-600 {
            color: #4f46e5 !important;
        }
        .text-gray-600 {
            color: #4b5563 !important;
        }
        .text-gray-700 {
            color: #374151 !important;
        }
        .text-gray-900 {
            color: #111827 !important;
        }
        .text-white {
            color: #000000 !important;
        }
        .text-emerald-100 {
            color: #000000 !important;
        }
        .text-emerald-600 {
            color: #000000 !important;
        }
        .text-primaryGreen {
            color: #000000 !important;
        }
        .bg-white\/20 {
            background: #ffffff !important;
        }
        .backdrop-blur-sm {
            backdrop-filter: none !important;
        }
    }
</style>
@endsection