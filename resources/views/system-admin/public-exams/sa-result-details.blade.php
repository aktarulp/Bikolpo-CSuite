@extends('system-admin.system-admin-layout')

@section('title', 'Exam Result Details')

@section('content')

<div class="min-h-screen bg-gradient-to-br from-gray-50 via-white to-gray-100 dark:from-gray-900 dark:via-gray-800 dark:to-gray-900">
    <div class="space-y-6 p-4 sm:p-6 lg:p-8">
        <!-- Header -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl border border-gray-200 dark:border-gray-700 p-6">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div class="flex flex-col sm:flex-row sm:items-center gap-4">
                    <a href="{{ route('partner.exams.results', $exam) }}" 
                       class="inline-flex items-center px-4 py-2.5 text-sm font-semibold text-gray-700 bg-gray-100 hover:bg-gray-200 border border-gray-300 rounded-xl transition-all duration-200 hover:shadow-md dark:bg-gray-700 dark:border-gray-600 dark:text-gray-300 dark:hover:bg-gray-600">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                        Back to Results
                    </a>
                    <div>
                        <h1 class="text-2xl sm:text-3xl font-bold bg-gradient-to-r from-indigo-600 to-purple-600 bg-clip-text text-transparent dark:from-indigo-400 dark:to-purple-400">
                            Exam Result Details
                        </h1>
                        <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">Detailed question-wise result for {{ $exam['title'] }}</p>
                    </div>
                </div>
                <div class="flex flex-col sm:flex-row gap-3">
                    <div class="text-right">
                        <div class="text-sm text-gray-500 dark:text-gray-400">Total Questions</div>
                        <div class="text-lg font-bold text-gray-900 dark:text-white">{{ $exam['total_questions'] }}</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Result Summary -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl border border-gray-200 dark:border-gray-700 p-6 mb-8">
            <h2 class="text-2xl font-semibold mb-6 text-gray-800 dark:text-gray-200 text-center print:text-left print:text-xl print:mb-4">Exam: {{ $exam['title'] }}</h2>
            <div class="grid grid-cols-1 md:grid-cols-1 lg:grid-cols-3 gap-6 text-gray-600 dark:text-gray-400 print:grid-cols-1 print:gap-4">
                <!-- Column 1: Exam Info Card -->
                <div class="bg-blue-50 dark:bg-blue-950 rounded-2xl shadow-xl border border-blue-200 dark:border-blue-700 p-4">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-base sm:text-lg font-bold bg-gradient-to-r from-blue-600 to-indigo-600 bg-clip-text text-transparent dark:from-blue-400 dark:to-indigo-400">Exam Information</h3>
                        <span class="inline-flex items-center rounded-full bg-blue-100 dark:bg-blue-900/30 px-3 py-1 text-sm font-semibold text-blue-800 dark:text-blue-200">{{ $exam['id'] }}</span>
                    </div>
                    <div class="space-y-4">
                        <div class="flex items-center justify-between p-2 rounded-lg bg-blue-50 dark:bg-blue-900/20 print:bg-gray-100">
                            <p class="text-xs font-medium text-blue-600 dark:text-blue-300 print:text-black print:font-semibold">Exam ID:</p>
                            <p class="text-sm font-bold text-blue-800 dark:text-blue-100 print:text-gray-900 print:text-base">{{ $exam['id'] }}</p>
                        </div>
                        <div class="flex items-center justify-between p-2 rounded-lg bg-indigo-50 dark:bg-indigo-900/20 print:bg-gray-100">
                            <p class="text-xs font-medium text-indigo-600 dark:text-indigo-300 print:text-black print:font-semibold">Total Questions:</p>
                            <p class="text-sm font-bold text-indigo-800 dark:text-indigo-100 print:text-gray-900 print:text-base">{{ $exam['total_questions'] }}</p>
                        </div>
                        <div class="flex items-center justify-between p-2 rounded-lg bg-purple-50 dark:bg-purple-900/20 print:bg-gray-100">
                            <p class="text-xs font-medium text-purple-600 dark:text-purple-300 print:text-black print:font-semibold">Passing Marks:</p>
                            <p class="text-sm font-bold text-purple-800 dark:text-purple-100 print:text-gray-900 print:text-base">{{ $exam['passing_marks'] }}%</p>
                        </div>
                    </div>
                </div>
                
                <!-- Column 2: Student Info Card -->
                <div class="bg-green-50 dark:bg-green-950 rounded-2xl shadow-xl border border-green-200 dark:border-green-700 p-4">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-base sm:text-lg font-bold bg-gradient-to-r from-green-600 to-teal-600 bg-clip-text text-transparent dark:from-green-400 dark:to-teal-400">Student Information</h3>
                        <span class="inline-flex items-center rounded-full bg-green-100 dark:bg-green-900/30 px-3 py-1 text-sm font-semibold text-green-800 dark:text-green-200">{{ $student['student_id'] }}</span>
                    </div>
                    <div class="space-y-4">
                        <div class="flex items-center justify-between p-2 rounded-lg bg-green-50 dark:bg-green-900/20 print:bg-gray-100">
                            <p class="text-xs font-medium text-green-600 dark:text-green-300 print:text-black print:font-semibold">Student Name:</p>
                            <p class="text-sm font-bold text-green-800 dark:text-green-100 print:text-gray-900 print:text-base">{{ $student['full_name'] }}</p>
                        </div>
                        <div class="flex items-center justify-between p-2 rounded-lg bg-red-50 dark:bg-red-900/20 print:bg-gray-100">
                            <p class="text-xs font-medium text-red-600 dark:text-red-300 print:text-black print:font-semibold">Course:</p>
                            <p class="text-sm font-bold text-red-800 dark:text-red-100 print:text-gray-900 print:text-base">{{ $student['course'] ? $student['course']['name'] : 'N/A' }}</p>
                        </div>
                        <div class="flex items-center justify-between p-2 rounded-lg bg-teal-50 dark:bg-teal-900/20 print:bg-gray-100">
                            <p class="text-xs font-medium text-teal-600 dark:text-teal-300 print:text-black print:font-semibold">Batch:</p>
                            <p class="text-sm font-bold text-teal-800 dark:text-teal-100 print:text-gray-900 print:text-base">{{ $student['batch'] ? $student['batch']['name'] : 'N/A' }}</p>
                        </div>
                    </div>
                </div>

                <!-- Column 3: Result Info Card -->
                <div class="bg-purple-50 dark:bg-purple-950 rounded-2xl shadow-xl border border-purple-200 dark:border-purple-700 p-4">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-base sm:text-lg font-bold bg-gradient-to-r from-purple-600 to-pink-600 bg-clip-text text-transparent dark:from-purple-400 dark:to-pink-400">Result Summary</h3>
                        <span class="inline-flex items-center rounded-full bg-purple-100 dark:bg-purple-900/30 px-3 py-1 text-sm font-semibold text-purple-800 dark:text-purple-200">Score: {{ $result['score'] }}</span>
                    </div>
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-2 gap-4 text-center print:grid-cols-1 print:gap-2">
                        <div class="flex items-center justify-between p-2 rounded-lg bg-green-100 dark:bg-green-900/20 print:bg-gray-100">
                            <p class="text-xs font-medium text-green-600 dark:text-green-300 print:text-black print:font-semibold">Correct%:</p>
                            <p class="text-sm font-bold text-green-800 dark:text-green-100 print:text-gray-900 print:text-base">{{ $result['percentage'] }}%</p>
                        </div>
                        <div class="flex items-center justify-between p-2 rounded-lg bg-yellow-100 dark:bg-yellow-900/20 print:bg-gray-100">
                            <p class="text-xs font-medium text-yellow-600 dark:text-yellow-300 print:text-black print:font-semibold">Status:</p>
                            <p class="text-sm font-bold text-yellow-800 dark:text-yellow-100 print:text-gray-900 print:text-base">{{ $result['status'] }}</p>
                        </div>
                        <div class="flex items-center justify-between p-2 rounded-lg bg-purple-100 dark:bg-purple-900/20 print:bg-gray-100">
                            <p class="text-xs font-medium text-purple-600 dark:text-purple-300 print:text-black print:font-semibold">Pass/Fail:</p>
                            <p class="text-sm font-bold text-purple-800 dark:text-purple-100 print:text-gray-900 print:text-base">{{ $result['is_passed'] ? 'Passed' : 'Failed' }}</p>
                        </div>
                        <div class="flex items-center justify-between p-2 rounded-lg bg-green-100 dark:bg-green-900/20 print:bg-gray-100">
                            <p class="text-xs font-medium text-green-600 dark:text-green-300 print:text-black print:font-semibold">Correct:</p>
                            <p class="text-sm font-bold text-green-800 dark:text-green-100 print:text-gray-900 print:text-base">{{ $result['correct_answers'] }}</p>
                        </div>
                        <div class="flex items-center justify-between p-2 rounded-lg bg-red-100 dark:bg-red-900/20 print:bg-gray-100">
                            <p class="text-xs font-medium text-red-600 dark:text-red-300 print:text-black print:font-semibold">Wrong:</p>
                            <p class="text-sm font-bold text-red-800 dark:text-red-100 print:text-gray-900 print:text-base">{{ $result['wrong_answers'] }}</p>
                        </div>
                        <div class="flex items-center justify-between p-2 rounded-lg bg-yellow-100 dark:bg-yellow-900/20 print:bg-gray-100">
                            <p class="text-xs font-medium text-yellow-600 dark:text-yellow-300 print:text-black print:font-semibold">Skipped:</p>
                            <p class="text-sm font-bold text-yellow-800 dark:text-yellow-100 print:text-gray-900 print:text-base">{{ $result['unanswered'] }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Questions Section -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl border border-gray-200 dark:border-gray-700 overflow-hidden">
            <div class="bg-gradient-to-r from-gray-50 to-gray-100 dark:from-gray-700 dark:to-gray-800 px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                <h3 class="text-lg sm:text-xl font-bold text-gray-900 dark:text-white">Question-wise Results</h3>
                <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">Review student's answers for each question</p>
            </div>
            
            <div class="p-6">
                @if($questions->count() > 0)
                    <div class="space-y-6">
                        @foreach($questions as $index => $question)
                            <div class="border border-gray-200 dark:border-gray-600 rounded-xl p-3 sm:p-4 bg-gray-50 dark:bg-gray-700/50">
                                @if($question['question_type'] === 'mcq')
                                    <div class="flex flex-col sm:flex-row sm:items-center gap-2 sm:gap-3">
                                        <div class="flex-shrink-0">
                                            <span class="inline-flex items-center justify-center w-6 h-6 sm:w-8 sm:h-8 rounded-full text-xs sm:text-sm font-bold bg-gradient-to-r from-indigo-500 to-purple-600 text-white shadow-lg">
                                                {{ $index + 1 }}
                                            </span>
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <span class="text-sm sm:text-base text-gray-900 dark:text-white font-medium leading-tight">{{ $question['question_text'] }}</span>
                                        </div>
                                        <div class="grid grid-cols-2 sm:grid-cols-4 gap-2 sm:gap-3 flex-shrink-0 w-full max-w-2xl">
                                            @foreach(['option_a' => 'A', 'option_b' => 'B', 'option_c' => 'C', 'option_d' => 'D'] as $optionKey => $label)
                                                @if($question[$optionKey])
                                                    @php
                                                        $isStudentAnswer = (strtolower($question['student_answer']) === strtolower($label));
                                                        $isCorrectOption = (strtolower($question['correct_answer']) === strtolower($label));
                                                    @endphp
                                                    <div class="flex items-center gap-1 sm:gap-2 p-2 rounded-lg transition-all duration-200
                                                        @if($isCorrectOption)
                                                            bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 shadow-sm
                                                        @elseif($isStudentAnswer && !$isCorrectOption)
                                                            bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 shadow-sm
                                                        @endif">
                                                        <label class="flex items-center justify-center w-6 h-6 sm:w-8 sm:h-8 border rounded relative group
                                                            @if($isCorrectOption)
                                                                border-green-500 bg-green-100 dark:bg-green-800/30
                                                            @elseif($isStudentAnswer && !$isCorrectOption)
                                                                border-red-500 bg-red-100 dark:bg-red-800/30
                                                            @else
                                                                border-gray-300 dark:border-gray-600
                                                            @endif">
                                                            <span class="font-bold text-xs sm:text-sm
                                                                @if($isCorrectOption)
                                                                    text-green-800 dark:text-green-200
                                                                @elseif($isStudentAnswer && !$isCorrectOption)
                                                                    text-red-800 dark:text-red-200
                                                                @else
                                                                    text-gray-900 dark:text-white
                                                                @endif">{{ strtolower($label) }}</span>
                                                        </label>
                                                        <span class="text-xs sm:text-sm break-words font-medium
                                                            @if($isCorrectOption)
                                                                text-green-800 dark:text-green-200
                                                            @elseif($isStudentAnswer && !$isCorrectOption)
                                                                text-red-800 dark:text-red-200
                                                            @else
                                                                text-gray-600 dark:text-gray-400
                                                            @endif">{{ $question[$optionKey] }}</span>
                                                    </div>
                                                @else
                                                    <div></div>
                                                @endif
                                            @endforeach
                                        </div>
                                    </div>
                                @else
                                    <!-- Constructed Question Layout -->
                                    <div class="flex flex-col sm:flex-row sm:items-center gap-2 sm:gap-3">
                                        <div class="flex-shrink-0">
                                            <span class="inline-flex items-center justify-center w-6 h-6 sm:w-8 sm:h-8 rounded-full text-xs sm:text-sm font-bold bg-gradient-to-r from-indigo-500 to-purple-600 text-white shadow-lg">
                                                {{ $index + 1 }}
                                            </span>
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <span class="text-sm sm:text-base text-gray-900 dark:text-white font-medium leading-tight">{{ $question['question_text'] }}</span>
                                        </div>
                                    </div>
                                    <div class="mt-4 p-3 bg-gray-100 dark:bg-gray-700 rounded-lg">
                                        <p class="text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Your Answer:</p>
                                        <p class="text-sm text-gray-800 dark:text-gray-200">{!! nl2br(e($question['student_answer'] ?? 'N/A')) !!}</p>
                                    </div>
                                    <div class="mt-4 p-3 bg-green-100 dark:bg-green-900/20 rounded-lg border border-green-200 dark:border-green-800">
                                        <p class="text-sm font-semibold text-green-800 dark:text-green-200 mb-2">Correct Answer:</p>
                                        <p class="text-sm text-green-800 dark:text-green-200">{!! nl2br(e($question['correct_answer'] ?? 'N/A')) !!}</p>
                                    </div>
                                @endif
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-12">
                        <svg class="mx-auto h-16 w-16 text-gray-400 dark:text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                        </svg>
                        <h3 class="mt-4 text-lg font-semibold text-gray-900 dark:text-white">No questions found</h3>
                        <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">This exam doesn't have any questions assigned yet.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
