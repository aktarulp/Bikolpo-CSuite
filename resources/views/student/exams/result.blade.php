@extends('layouts.app')

@section('title', 'Exam Result - ' . $exam->title)

@section('content')
<div class="min-h-screen bg-gradient-to-br from-blue-50 via-indigo-50 to-purple-50 py-8">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center w-20 h-20 bg-gradient-to-br from-primaryGreen to-emerald-500 rounded-full shadow-lg mb-4">
                <svg class="w-12 h-12 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
            <h1 class="text-4xl font-bold text-gray-900 mb-2">Exam Result</h1>
            <p class="text-xl text-gray-600">Congratulations on completing {{ $exam->title }}</p>
        </div>

        <!-- Main Report Card -->
        <div class="bg-white rounded-2xl shadow-2xl overflow-hidden mb-8">
            <!-- Report Card Header -->
            <div class="bg-gradient-to-r from-primaryGreen to-emerald-600 text-white p-8">
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 items-center">
                    <div class="text-center lg:text-left">
                        <h2 class="text-3xl font-bold mb-2">{{ $exam->title }}</h2>
                        <p class="text-emerald-100 text-lg">{{ $exam->description ?? 'Online Examination' }}</p>
                    </div>
                    
                    <div class="text-center">
                        <div class="inline-flex items-center justify-center w-32 h-32 bg-white/20 rounded-full backdrop-blur-sm">
                            <div class="text-center">
                                <div class="text-4xl font-bold">{{ number_format($result->percentage, 1) }}%</div>
                                <div class="text-sm text-emerald-100">Score</div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="text-center lg:text-right">
                        <div class="text-2xl font-bold mb-2">{{ $result->grade }}</div>
                        <div class="text-emerald-100">
                            @if($result->percentage >= $exam->passing_marks)
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-500 text-white">
                                    PASSED
                                </span>
                            @else
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-red-500 text-white">
                                    FAILED
                                </span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Report Card Body -->
            <div class="p-8">
                <!-- Student and Institute Information -->
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
                    <div class="bg-gray-50 rounded-xl p-6">
                        <h3 class="text-xl font-semibold text-gray-900 mb-4 flex items-center">
                            <svg class="w-6 h-6 text-primaryGreen mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                            Student Information
                        </h3>
                        <div class="space-y-3">
                            <div class="flex justify-between">
                                <span class="text-gray-600 font-medium">Name:</span>
                                <span class="text-gray-900 font-semibold">{{ $result->student->full_name ?? 'Student Name' }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600 font-medium">Student ID:</span>
                                <span class="text-gray-900 font-semibold">{{ $result->student->student_id ?? 'N/A' }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600 font-medium">Email:</span>
                                <span class="text-gray-900 font-semibold">{{ $result->student->email ?? 'N/A' }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600 font-medium">Class/Grade:</span>
                                <span class="text-gray-900 font-semibold">{{ $result->student->class_grade ?? 'N/A' }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="bg-gray-50 rounded-xl p-6">
                        <h3 class="text-xl font-semibold text-gray-900 mb-4 flex items-center">
                            <svg class="w-6 h-6 text-primaryGreen mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                            </svg>
                            Institute Information
                        </h3>
                        <div class="space-y-3">
                            <div class="flex justify-between">
                                <span class="text-gray-600 font-medium">Institute:</span>
                                <span class="text-gray-900 font-semibold">{{ $result->student->partner->name ?? 'Institute Name' }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600 font-medium">School/College:</span>
                                <span class="text-gray-900 font-semibold">{{ $result->student->school_college ?? 'N/A' }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600 font-medium">Address:</span>
                                <span class="text-gray-900 font-semibold">{{ $result->student->city ?? 'N/A' }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Exam Performance Summary -->
                <div class="bg-gradient-to-r from-blue-50 to-indigo-50 rounded-xl p-6 mb-8">
                    <h3 class="text-xl font-semibold text-gray-900 mb-6 text-center">Exam Performance Summary</h3>
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                        <div class="text-center">
                            <div class="bg-white rounded-lg p-4 shadow-sm">
                                <div class="text-3xl font-bold text-blue-600 mb-2">{{ $result->total_questions }}</div>
                                <div class="text-sm text-gray-600 font-medium">Total Questions</div>
                            </div>
                        </div>
                        
                        <div class="text-center">
                            <div class="bg-white rounded-lg p-4 shadow-sm">
                                <div class="text-3xl font-bold text-green-600 mb-2">{{ $result->correct_answers }}</div>
                                <div class="text-sm text-gray-600 font-medium">Correct Answers</div>
                            </div>
                        </div>
                        
                        <div class="text-center">
                            <div class="bg-white rounded-lg p-4 shadow-sm">
                                <div class="text-3xl font-bold text-red-600 mb-2">{{ $result->wrong_answers }}</div>
                                <div class="text-sm text-gray-600 font-medium">Wrong Answers</div>
                            </div>
                        </div>
                        
                        <div class="text-center">
                            <div class="bg-white rounded-lg p-4 shadow-sm">
                                <div class="text-3xl font-bold text-orange-600 mb-2">{{ $result->unanswered }}</div>
                                <div class="text-sm text-gray-600 font-medium">Unanswered</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Detailed Scoring -->
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
                    <div class="bg-white border border-gray-200 rounded-xl p-6 shadow-sm">
                        <h3 class="text-xl font-semibold text-gray-900 mb-4 flex items-center">
                            <svg class="w-6 h-6 text-green-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            Marks Earned
                        </h3>
                        <div class="space-y-4">
                            <div class="flex justify-between items-center p-3 bg-green-50 rounded-lg">
                                <span class="text-gray-700 font-medium">Correct Answers:</span>
                                <span class="text-green-600 font-bold">{{ $result->correct_answers }} × {{ $exam->total_questions > 0 ? round($result->score / $result->correct_answers, 2) : 0 }} = {{ $result->score }}</span>
                            </div>
                            @if($exam->has_negative_marking)
                            <div class="flex justify-between items-center p-3 bg-red-50 rounded-lg">
                                <span class="text-gray-700 font-medium">Wrong Answers (Deduction):</span>
                                <span class="text-red-600 font-bold">-{{ $result->wrong_answers }} × {{ $exam->negative_marks_per_question }} = -{{ number_format($result->wrong_answers * $exam->negative_marks_per_question, 2) }}</span>
                            </div>
                            @endif
                            <div class="flex justify-between items-center p-3 bg-blue-50 rounded-lg">
                                <span class="text-gray-700 font-medium">Final Score:</span>
                                <span class="text-blue-600 font-bold text-xl">{{ $result->score }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white border border-gray-200 rounded-xl p-6 shadow-sm">
                        <h3 class="text-xl font-semibold text-gray-900 mb-4 flex items-center">
                            <svg class="w-6 h-6 text-purple-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                            </svg>
                            Performance Metrics
                        </h3>
                        <div class="space-y-4">
                            <div class="flex justify-between items-center p-3 bg-purple-50 rounded-lg">
                                <span class="text-gray-700 font-medium">Score Percentage:</span>
                                <span class="text-purple-600 font-bold text-xl">{{ number_format($result->percentage, 1) }}%</span>
                            </div>
                            <div class="flex justify-between items-center p-3 bg-indigo-50 rounded-lg">
                                <span class="text-gray-700 font-medium">Grade:</span>
                                <span class="text-indigo-600 font-bold text-xl">{{ $result->grade }}</span>
                            </div>
                            <div class="flex justify-between items-center p-3 bg-yellow-50 rounded-lg">
                                <span class="text-gray-700 font-medium">Passing Marks:</span>
                                <span class="text-yellow-600 font-bold">{{ $exam->passing_marks }}%</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Time Information -->
                <div class="bg-gray-50 rounded-xl p-6 mb-8">
                    <h3 class="text-xl font-semibold text-gray-900 mb-4 flex items-center">
                        <svg class="w-6 h-6 text-gray-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Time Information
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                        <div class="text-center">
                            <div class="bg-white rounded-lg p-4 shadow-sm">
                                <div class="text-sm text-gray-600 mb-2">Started At</div>
                                <div class="text-lg font-semibold text-gray-900">{{ $result->started_at->format('M d, Y g:i A') }}</div>
                            </div>
                        </div>
                        
                        <div class="text-center">
                            <div class="bg-white rounded-lg p-4 shadow-sm">
                                <div class="text-sm text-gray-600 mb-2">Completed At</div>
                                <div class="text-lg font-semibold text-gray-900">{{ $result->completed_at->format('M d, Y g:i A') }}</div>
                            </div>
                        </div>
                        
                        <div class="text-center">
                            <div class="bg-white rounded-lg p-4 shadow-sm">
                                <div class="text-sm text-gray-600 mb-2">Time Taken</div>
                                <div class="text-lg font-semibold text-gray-900">{{ $result->started_at->diffInMinutes($result->completed_at) }} min</div>
                            </div>
                        </div>
                        
                        <div class="text-center">
                            <div class="bg-white rounded-lg p-4 shadow-sm">
                                <div class="text-sm text-gray-600 mb-2">Time Limit</div>
                                <div class="text-lg font-semibold text-gray-900">{{ $exam->duration }} min</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Performance Insights -->
                <div class="bg-gradient-to-r from-yellow-50 to-orange-50 rounded-xl p-6 mb-8">
                    <h3 class="text-xl font-semibold text-gray-900 mb-4 text-center">Performance Insights</h3>
                    <div class="space-y-3">
                        @if($result->percentage >= 90)
                            <div class="flex items-center p-4 bg-green-100 rounded-lg border border-green-200">
                                <svg class="w-6 h-6 text-green-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                <span class="text-green-800 font-medium">Outstanding performance! You've mastered this material with exceptional understanding.</span>
                            </div>
                        @elseif($result->percentage >= 80)
                            <div class="flex items-center p-4 bg-blue-100 rounded-lg border border-blue-200">
                                <svg class="w-6 h-6 text-blue-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                <span class="text-blue-800 font-medium">Excellent work! You have a solid understanding of the subject matter.</span>
                            </div>
                        @elseif($result->percentage >= 70)
                            <div class="flex items-center p-4 bg-yellow-100 rounded-lg border border-yellow-200">
                                <svg class="w-6 h-6 text-yellow-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                <span class="text-yellow-800 font-medium">Good job! Consider reviewing areas where you struggled for improvement.</span>
                            </div>
                        @else
                            <div class="flex items-center p-4 bg-red-100 rounded-lg border border-red-200">
                                <svg class="w-6 h-6 text-red-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.34 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                                </svg>
                                <span class="text-red-800 font-medium">Keep practicing! Review the material thoroughly and try again for better results.</span>
                            </div>
                        @endif
                        
                        @if($result->unanswered > 0)
                            <div class="flex items-center p-4 bg-orange-100 rounded-lg border border-orange-200">
                                <svg class="w-6 h-6 text-orange-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <span class="text-orange-800 font-medium">You left {{ $result->unanswered }} question(s) unanswered. Try to answer all questions next time for maximum points.</span>
                            </div>
                        @endif

                        @if($exam->has_negative_marking && $result->wrong_answers > 0)
                            <div class="flex items-center p-4 bg-purple-100 rounded-lg border border-purple-200">
                                <svg class="w-6 h-6 text-purple-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.34 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                                </svg>
                                <span class="text-purple-800 font-medium">This exam has negative marking. Each wrong answer deducts {{ $exam->negative_marks_per_question }} marks.</span>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <a href="{{ route('student.dashboard') }}" 
                       class="flex-1 sm:flex-none flex justify-center items-center py-3 px-8 bg-primaryGreen hover:bg-green-600 text-white font-semibold rounded-lg shadow-lg hover:shadow-xl transition-all duration-200 transform hover:-translate-y-1">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                        </svg>
                        Back to Dashboard
                    </a>
                    
                    <a href="{{ route('student.exams.history') }}" 
                       class="flex-1 sm:flex-none flex justify-center items-center py-3 px-8 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg shadow-lg hover:shadow-xl transition-all duration-200 transform hover:-translate-y-1">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                        </svg>
                        View History
                    </a>
                    
                    <button onclick="window.print()" 
                            class="flex-1 sm:flex-none flex justify-center items-center py-3 px-8 bg-gray-600 hover:bg-gray-700 text-white font-semibold rounded-lg shadow-lg hover:shadow-xl transition-all duration-200 transform hover:-translate-y-1">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path>
                        </svg>
                        Print Report
                    </button>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <div class="text-center text-gray-500">
            <p class="text-sm">
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
