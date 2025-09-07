<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Exam Review - {{ $exam->title }}</title>
    
    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-gradient-to-br from-blue-50 via-indigo-50 to-purple-50 min-h-screen">
    <div class="min-h-screen py-4">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="text-center mb-4">
                <div class="inline-flex items-center justify-center w-12 h-12 bg-gradient-to-br from-primaryGreen to-emerald-500 rounded-full shadow-lg mb-2">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                </div>
                <h1 class="text-2xl font-bold text-gray-900 mb-1">Exam Review</h1>
                <p class="text-sm text-gray-600">{{ $exam->title }}</p>
            </div>

            <!-- Performance Summary -->
            <div class="bg-white rounded-xl shadow-lg overflow-hidden mb-4">
                <div class="bg-gradient-to-r from-primaryGreen to-emerald-600 text-white p-4">
                    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 items-center">
                        <div class="text-center lg:text-left">
                            <h2 class="text-lg font-bold">{{ $exam->title }}</h2>
                            <p class="text-emerald-100 text-sm">Performance Review</p>
                        </div>
                        
                        <div class="text-center">
                            <div class="inline-flex items-center justify-center w-16 h-16 bg-white/20 rounded-full backdrop-blur-sm">
                                <div class="text-center">
                                    <div class="text-xl font-bold">{{ number_format($result->percentage ?? 0, 1) }}%</div>
                                    <div class="text-xs text-emerald-100">Score</div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="text-center">
                            <div class="text-lg font-bold">{{ $result->grade ?? 'N/A' }}</div>
                            <div class="text-emerald-100 text-sm">Grade</div>
                        </div>
                        
                        <div class="text-center lg:text-right">
                            <div class="text-lg font-bold">{{ $analytics['correct_answers'] ?? 0 }}/{{ $analytics['total_questions'] ?? 0 }}</div>
                            <div class="text-emerald-100 text-sm">Correct</div>
                        </div>
                    </div>
                </div>

                <!-- Performance Metrics -->
                <div class="p-4">
                    <div class="grid grid-cols-4 gap-3">
                        <div class="text-center">
                            <div class="bg-green-50 rounded-lg p-3 border border-green-200">
                                <div class="text-xl font-bold text-green-600">{{ $analytics['correct_answers'] ?? 0 }}</div>
                                <div class="text-xs text-gray-600 font-medium">Correct</div>
                            </div>
                        </div>
                        
                        <div class="text-center">
                            <div class="bg-red-50 rounded-lg p-3 border border-red-200">
                                <div class="text-xl font-bold text-red-600">{{ $analytics['incorrect_answers'] ?? 0 }}</div>
                                <div class="text-xs text-gray-600 font-medium">Incorrect</div>
                            </div>
                        </div>
                        
                        <div class="text-center">
                            <div class="bg-orange-50 rounded-lg p-3 border border-orange-200">
                                <div class="text-xl font-bold text-orange-600">{{ $analytics['skipped_questions'] ?? 0 }}</div>
                                <div class="text-xs text-gray-600 font-medium">Skipped</div>
                            </div>
                        </div>
                        
                        <div class="text-center">
                            <div class="bg-blue-50 rounded-lg p-3 border border-blue-200">
                                <div class="text-xl font-bold text-blue-600">{{ number_format($analytics['accuracy_percentage'] ?? 0, 1) }}%</div>
                                <div class="text-xs text-gray-600 font-medium">Accuracy</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Review Tabs -->
            <div class="bg-white rounded-xl shadow-lg overflow-hidden mb-4">
                <div class="border-b border-gray-200">
                    <div class="flex items-center justify-between px-4">
                        <nav class="flex space-x-4" aria-label="Tabs">
                            <button onclick="showTab('all')" id="tab-all" class="tab-button active py-3 px-2 border-b-2 border-primaryGreen font-medium text-xs text-primaryGreen">
                                All ({{ $analytics['total_questions'] ?? 0 }})
                            </button>
                            <button onclick="showTab('correct')" id="tab-correct" class="tab-button py-3 px-2 border-b-2 border-transparent font-medium text-xs text-gray-500 hover:text-gray-700 hover:border-gray-300">
                                Correct ({{ $analytics['correct_answers'] ?? 0 }})
                            </button>
                            <button onclick="showTab('incorrect')" id="tab-incorrect" class="tab-button py-3 px-2 border-b-2 border-transparent font-medium text-xs text-gray-500 hover:text-gray-700 hover:border-gray-300">
                                Wrong ({{ $analytics['incorrect_answers'] ?? 0 }})
                            </button>
                            <button onclick="showTab('skipped')" id="tab-skipped" class="tab-button py-3 px-2 border-b-2 border-transparent font-medium text-xs text-gray-500 hover:text-gray-700 hover:border-gray-300">
                                Skipped ({{ $analytics['skipped_questions'] ?? 0 }})
                            </button>
                            <button onclick="showTab('analytics')" id="tab-analytics" class="tab-button py-3 px-2 border-b-2 border-transparent font-medium text-xs text-gray-500 hover:text-gray-700 hover:border-gray-300">
                                Analytics
                            </button>
                        </nav>
                        
                        <!-- Global Explanation Toggle Button -->
                        <button onclick="toggleAllExplanations()" 
                                class="inline-flex items-center px-4 py-2.5 rounded-xl text-sm font-semibold bg-gradient-to-r from-blue-500 to-blue-600 text-white hover:from-blue-600 hover:to-blue-700 border-0 shadow-lg hover:shadow-xl transform hover:scale-105 transition-all duration-300 focus:outline-none focus:ring-4 focus:ring-blue-300"
                                id="global-explanation-btn">
                            <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                            </svg>
                            Show Explanation
                        </button>
                    </div>
                </div>

                <!-- Tab Content -->
                <div class="p-4">
                    <!-- All Questions Tab -->
                    <div id="content-all" class="tab-content">
                        <div class="space-y-3">
                            @foreach($questionStats as $index => $questionStat)
                                <div class="border border-gray-200 rounded-lg p-3 hover:shadow-sm transition-shadow">
                                    <div class="flex items-start justify-between mb-2">
                                        <div class="flex items-center space-x-2">
                                            <div>
                                                <h3 class="text-sm font-semibold text-gray-900">
                                                    Q{{ $index + 1 }}
                                                    @if($questionStat->question->question_type === 'mcq')
                                                        <span class="ml-1 inline-flex items-center px-1.5 py-0.5 rounded text-xs font-medium bg-blue-100 text-blue-800">
                                                            MCQ
                                                        </span>
                                                    @elseif($questionStat->question->question_type === 'descriptive')
                                                        <span class="ml-1 inline-flex items-center px-1.5 py-0.5 rounded text-xs font-medium bg-purple-100 text-purple-800">
                                                            CQ
                                                        </span>
                                                    @endif
                                                    <span class="ml-2 text-sm font-normal text-gray-700">{{ Str::limit($questionStat->question->question_text, 120) }}</span>
                                                </h3>
                                            </div>
                                        </div>
                                        <div class="flex items-center space-x-2">
                                            <!-- Status Tag -->
                                            @if($questionStat->is_correct)
                                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-green-100 text-green-800 border border-green-200">
                                                    <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                                    </svg>
                                                    Correct
                                                </span>
                                            @elseif($questionStat->is_answered)
                                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-red-100 text-red-800 border border-red-200">
                                                    <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                                                    </svg>
                                                    Incorrect
                                                </span>
                                            @else
                                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-orange-100 text-orange-800 border border-orange-200">
                                                    <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd" d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                                                    </svg>
                                                    Skipped
                                                </span>
                                            @endif
                                            
                                            <!-- Question Score -->
                                            <div class="inline-flex items-center px-2 py-1 rounded-full text-xs font-bold bg-blue-100 text-blue-800 border border-blue-200">
                                                <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                                </svg>
                                                @php
                                                    $maxMarks = $questionStat->question->expected_answer_points ?? $questionStat->question->marks ?? 1;
                                                    $negativeMarks = $exam->has_negative_marking ? $exam->negative_marks_per_question : 0;
                                                @endphp
                                                @if($questionStat->is_correct)
                                                    {{ $maxMarks }}/{{ $maxMarks }}
                                                @elseif($questionStat->is_answered && $negativeMarks > 0)
                                                    -{{ $negativeMarks }}/{{ $maxMarks }}
                                                @else
                                                    0/{{ $maxMarks }}
                                                @endif
                                            </div>
                                        </div>
                                    </div>

                                    <div class="mb-2">
                                        @if($questionStat->question->question_type === 'mcq')
                                            <div class="grid grid-cols-4 gap-1">
                                                <div class="flex items-center space-x-2 p-2 rounded text-xs
                                                    @if($questionStat->student_answer === 'a' && $questionStat->correct_answer === 'a') bg-green-50 border-2 border-green-300
                                                    @elseif($questionStat->student_answer === 'a') bg-red-50 border-2 border-red-300
                                                    @elseif($questionStat->correct_answer === 'a') bg-green-50 border-2 border-green-300
                                                    @else bg-gray-50 border border-gray-200 @endif">
                                                    <div class="flex items-center justify-center w-6 h-6 rounded-full text-xs font-bold
                                                        @if($questionStat->student_answer === 'a' && $questionStat->correct_answer === 'a') bg-green-600 text-white
                                                        @elseif($questionStat->student_answer === 'a') bg-red-600 text-white
                                                        @elseif($questionStat->correct_answer === 'a') bg-green-600 text-white
                                                        @else bg-gray-600 text-white @endif">
                                                        A
                                                    </div>
                                                    <span class="text-gray-700 flex-1">{{ Str::limit($questionStat->question->option_a, 25) }}</span>
                                                    <div class="flex flex-col items-end text-xs">
                                                        @if($questionStat->student_answer === 'a')
                                                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-bold bg-blue-100 text-blue-800 border border-blue-200">
                                                                <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                                    <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path>
                                                                </svg>
                                                                Your Answer
                                                            </span>
                                                        @endif
                                                    </div>
                                                </div>
                                                
                                                <div class="flex items-center space-x-2 p-2 rounded text-xs
                                                    @if($questionStat->student_answer === 'b' && $questionStat->correct_answer === 'b') bg-green-50 border-2 border-green-300
                                                    @elseif($questionStat->student_answer === 'b') bg-red-50 border-2 border-red-300
                                                    @elseif($questionStat->correct_answer === 'b') bg-green-50 border-2 border-green-300
                                                    @else bg-gray-50 border border-gray-200 @endif">
                                                    <div class="flex items-center justify-center w-6 h-6 rounded-full text-xs font-bold
                                                        @if($questionStat->student_answer === 'b' && $questionStat->correct_answer === 'b') bg-green-600 text-white
                                                        @elseif($questionStat->student_answer === 'b') bg-red-600 text-white
                                                        @elseif($questionStat->correct_answer === 'b') bg-green-600 text-white
                                                        @else bg-gray-600 text-white @endif">
                                                        B
                                                    </div>
                                                    <span class="text-gray-700 flex-1">{{ Str::limit($questionStat->question->option_b, 25) }}</span>
                                                    <div class="flex flex-col items-end text-xs">
                                                        @if($questionStat->student_answer === 'b')
                                                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-bold bg-blue-100 text-blue-800 border border-blue-200">
                                                                <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                                    <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path>
                                                                </svg>
                                                                Your Answer
                                                            </span>
                                                        @endif
                                                    </div>
                                                </div>
                                                
                                                <div class="flex items-center space-x-2 p-2 rounded text-xs
                                                    @if($questionStat->student_answer === 'c' && $questionStat->correct_answer === 'c') bg-green-50 border-2 border-green-300
                                                    @elseif($questionStat->student_answer === 'c') bg-red-50 border-2 border-red-300
                                                    @elseif($questionStat->correct_answer === 'c') bg-green-50 border-2 border-green-300
                                                    @else bg-gray-50 border border-gray-200 @endif">
                                                    <div class="flex items-center justify-center w-6 h-6 rounded-full text-xs font-bold
                                                        @if($questionStat->student_answer === 'c' && $questionStat->correct_answer === 'c') bg-green-600 text-white
                                                        @elseif($questionStat->student_answer === 'c') bg-red-600 text-white
                                                        @elseif($questionStat->correct_answer === 'c') bg-green-600 text-white
                                                        @else bg-gray-600 text-white @endif">
                                                        C
                                                    </div>
                                                    <span class="text-gray-700 flex-1">{{ Str::limit($questionStat->question->option_c, 25) }}</span>
                                                    <div class="flex flex-col items-end text-xs">
                                                        @if($questionStat->student_answer === 'c')
                                                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-bold bg-blue-100 text-blue-800 border border-blue-200">
                                                                <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                                    <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path>
                                                                </svg>
                                                                Your Answer
                                                            </span>
                                                        @endif
                                                    </div>
                                                </div>
                                                
                                                <div class="flex items-center space-x-2 p-2 rounded text-xs
                                                    @if($questionStat->student_answer === 'd' && $questionStat->correct_answer === 'd') bg-green-50 border-2 border-green-300
                                                    @elseif($questionStat->student_answer === 'd') bg-red-50 border-2 border-red-300
                                                    @elseif($questionStat->correct_answer === 'd') bg-green-50 border-2 border-green-300
                                                    @else bg-gray-50 border border-gray-200 @endif">
                                                    <div class="flex items-center justify-center w-6 h-6 rounded-full text-xs font-bold
                                                        @if($questionStat->student_answer === 'd' && $questionStat->correct_answer === 'd') bg-green-600 text-white
                                                        @elseif($questionStat->student_answer === 'd') bg-red-600 text-white
                                                        @elseif($questionStat->correct_answer === 'd') bg-green-600 text-white
                                                        @else bg-gray-600 text-white @endif">
                                                        D
                                                    </div>
                                                    <span class="text-gray-700 flex-1">{{ Str::limit($questionStat->question->option_d, 25) }}</span>
                                                    <div class="flex flex-col items-end text-xs">
                                                        @if($questionStat->student_answer === 'd')
                                                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-bold bg-blue-100 text-blue-800 border border-blue-200">
                                                                <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                                    <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path>
                                                                </svg>
                                                                Your Answer
                                                            </span>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        @else
                                            <div class="space-y-2">
                                                <div class="p-2 bg-blue-50 border border-blue-200 rounded text-xs">
                                                    <h4 class="font-medium text-blue-900 mb-1">Your Answer:</h4>
                                                    <p class="text-blue-800">{{ Str::limit($questionStat->student_answer ?? 'No answer provided', 100) }}</p>
                                                </div>
                                                
                                                <div class="p-2 bg-green-50 border border-green-200 rounded text-xs">
                                                    <h4 class="font-medium text-green-900 mb-1">Expected:</h4>
                                                    <p class="text-green-800">{{ Str::limit($questionStat->question->sample_answer ?? 'No sample answer available', 100) }}</p>
                                                </div>
                                            </div>
                                        @endif
                                    </div>

                                    <div id="explanation-{{ $index }}" class="hidden p-2 bg-yellow-50 border border-yellow-200 rounded text-xs">
                                        <h4 class="font-medium text-yellow-900 mb-1">Explanation:</h4>
                                        @if($questionStat->question->explanation && trim($questionStat->question->explanation) !== '')
                                            <p class="text-yellow-800">{{ Str::limit($questionStat->question->explanation, 80) }}</p>
                                        @else
                                            <p class="text-yellow-600 italic">Not Filled Yet</p>
                                        @endif
                                    </div>

                                    <div class="flex items-center justify-between mt-2 pt-2 border-t border-gray-200 text-xs text-gray-500">
                                        <div class="flex items-center space-x-3">
                                            <span>{{ $questionStat->marks }}m</span>
                                            @if($questionStat->time_spent_seconds)
                                                <span>{{ $questionStat->time_spent_formatted }}</span>
                                            @endif
                                        </div>
                                        <div>
                                            {{ $questionStat->question_answered_at ? $questionStat->question_answered_at->format('M d, g:i A') : 'N/A' }}
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Other tabs content will be populated by JavaScript -->
                    <div id="content-correct" class="tab-content hidden">
                        <div class="text-center py-8">
                            <div class="animate-spin rounded-full h-8 w-8 border-b-2 border-primaryGreen mx-auto"></div>
                            <p class="mt-2 text-gray-500">Loading correct answers...</p>
                        </div>
                    </div>

                    <div id="content-incorrect" class="tab-content hidden">
                        <div class="text-center py-8">
                            <div class="animate-spin rounded-full h-8 w-8 border-b-2 border-primaryGreen mx-auto"></div>
                            <p class="mt-2 text-gray-500">Loading incorrect answers...</p>
                        </div>
                    </div>

                    <div id="content-skipped" class="tab-content hidden">
                        <div class="text-center py-8">
                            <div class="animate-spin rounded-full h-8 w-8 border-b-2 border-primaryGreen mx-auto"></div>
                            <p class="mt-2 text-gray-500">Loading skipped questions...</p>
                        </div>
                    </div>

                    <div id="content-analytics" class="tab-content hidden">
                        <div class="text-center py-8">
                            <div class="animate-spin rounded-full h-8 w-8 border-b-2 border-primaryGreen mx-auto"></div>
                            <p class="mt-2 text-gray-500">Loading analytics...</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex flex-col sm:flex-row gap-2 justify-center">
                <a href="{{ route('public.quiz.result', ['exam' => $exam->id, 'result' => $result->id]) }}" 
                   class="flex-1 sm:flex-none flex justify-center items-center py-2 px-6 bg-gray-600 hover:bg-gray-700 text-white font-medium rounded-lg shadow-md hover:shadow-lg transition-all duration-200">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Back to Result
                </a>
                
                <a href="{{ route('public.quiz.access') }}" 
                   class="flex-1 sm:flex-none flex justify-center items-center py-2 px-6 bg-primaryGreen hover:bg-green-600 text-white font-medium rounded-lg shadow-md hover:shadow-lg transition-all duration-200">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                    Take Another Quiz
                </a>
            </div>
        </div>
    </div>

    <script>
        function showTab(tabName) {
            // Hide all tab contents
            document.querySelectorAll('.tab-content').forEach(content => {
                content.classList.add('hidden');
            });
            
            // Remove active class from all tab buttons
            document.querySelectorAll('.tab-button').forEach(button => {
                button.classList.remove('active', 'border-primaryGreen', 'text-primaryGreen');
                button.classList.add('border-transparent', 'text-gray-500');
            });
            
            // Show selected tab content
            document.getElementById('content-' + tabName).classList.remove('hidden');
            
            // Add active class to selected tab button
            const activeButton = document.getElementById('tab-' + tabName);
            activeButton.classList.add('active', 'border-primaryGreen', 'text-primaryGreen');
            activeButton.classList.remove('border-transparent', 'text-gray-500');
            
            // Load content for specific tabs
            if (tabName === 'correct' || tabName === 'incorrect' || tabName === 'skipped' || tabName === 'analytics') {
                loadTabContent(tabName);
            }
        }
        
        function loadTabContent(tabName) {
            const contentDiv = document.getElementById('content-' + tabName);
            
            // Show loading state
            contentDiv.innerHTML = `
                <div class="text-center py-8">
                    <div class="animate-spin rounded-full h-8 w-8 border-b-2 border-primaryGreen mx-auto"></div>
                    <p class="mt-2 text-gray-500">Loading ${tabName} questions...</p>
                </div>
            `;
            
            // Load content via AJAX
            fetch(`/api/exam-review/{{ $exam->id }}/{{ $result->id }}/data`)
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        renderTabContent(tabName, data.data);
                    } else {
                        contentDiv.innerHTML = `
                            <div class="text-center py-8">
                                <p class="text-red-500">Error loading content. Please try again.</p>
                            </div>
                        `;
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    contentDiv.innerHTML = `
                        <div class="text-center py-8">
                            <p class="text-red-500">Error loading content. Please try again.</p>
                        </div>
                    `;
                });
        }
        
        function renderTabContent(tabName, data) {
            const contentDiv = document.getElementById('content-' + tabName);
            let questions = [];
            
            switch(tabName) {
                case 'correct':
                    questions = data.correct_questions || [];
                    break;
                case 'incorrect':
                    questions = data.incorrect_questions || [];
                    break;
                case 'skipped':
                    questions = data.skipped_questions || [];
                    break;
                case 'analytics':
                    renderAnalytics(data.analytics);
                    return;
            }
            
            if (questions.length === 0) {
                contentDiv.innerHTML = `
                    <div class="text-center py-8">
                        <p class="text-gray-500">No ${tabName} questions found.</p>
                    </div>
                `;
                return;
            }
            
            // Render questions (simplified version)
            let html = '<div class="space-y-6">';
            questions.forEach((questionStat, index) => {
                html += renderQuestionCard(questionStat, index);
            });
            html += '</div>';
            
            contentDiv.innerHTML = html;
        }
        
        function renderQuestionCard(questionStat, index) {
            // This is a simplified version - you can expand this based on your needs
            return `
                <div class="border border-gray-200 rounded-lg p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">
                        Question ${index + 1}
                    </h3>
                    <p class="text-gray-700 mb-4">${questionStat.question.question_text}</p>
                    <!-- Add more question details here -->
                </div>
            `;
        }
        
        function renderAnalytics(analytics) {
            const contentDiv = document.getElementById('content-analytics');
            
            let html = `
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    <div class="bg-blue-50 rounded-lg p-6">
                        <h3 class="text-lg font-semibold text-blue-900 mb-2">Accuracy</h3>
                        <p class="text-3xl font-bold text-blue-600">${analytics.accuracy_percentage || 0}%</p>
                    </div>
                    <div class="bg-green-50 rounded-lg p-6">
                        <h3 class="text-lg font-semibold text-green-900 mb-2">Correct Answers</h3>
                        <p class="text-3xl font-bold text-green-600">${analytics.correct_answers || 0}</p>
                    </div>
                    <div class="bg-red-50 rounded-lg p-6">
                        <h3 class="text-lg font-semibold text-red-900 mb-2">Incorrect Answers</h3>
                        <p class="text-3xl font-bold text-red-600">${analytics.incorrect_answers || 0}</p>
                    </div>
                </div>
            `;
            
            contentDiv.innerHTML = html;
        }

        // Toggle all explanations visibility
        function toggleAllExplanations() {
            const button = document.getElementById('global-explanation-btn');
            const allExplanations = document.querySelectorAll('[id^="explanation-"]');
            
            if (button && allExplanations.length > 0) {
                const isCurrentlyHidden = allExplanations[0].classList.contains('hidden');
                
                allExplanations.forEach(explanation => {
                    if (isCurrentlyHidden) {
                        explanation.classList.remove('hidden');
                    } else {
                        explanation.classList.add('hidden');
                    }
                });
                
                if (isCurrentlyHidden) {
                    button.innerHTML = `
                        <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M3.707 2.293a1 1 0 00-1.414 1.414l14 14a1 1 0 001.414-1.414l-1.473-1.473A10.014 10.014 0 0019.542 10C18.268 5.943 14.478 3 10 3a9.958 9.958 0 00-4.512 1.074l-1.78-1.781zm4.261 4.26l1.514 1.515a2.003 2.003 0 012.45 2.45l1.514 1.514a4 4 0 00-5.478-5.478z" clip-rule="evenodd"></path>
                            <path d="M12.454 16.697L9.75 13.992a4 4 0 01-3.742-3.741L2.335 6.578A9.98 9.98 0 00.458 10c1.274 4.057 5.065 7 9.542 7 .847 0 1.669-.105 2.454-.303z"></path>
                        </svg>
                        Hide Explanation
                    `;
                    button.className = 'inline-flex items-center px-4 py-2.5 rounded-xl text-sm font-semibold bg-gradient-to-r from-red-500 to-red-600 text-white hover:from-red-600 hover:to-red-700 border-0 shadow-lg hover:shadow-xl transform hover:scale-105 transition-all duration-300 focus:outline-none focus:ring-4 focus:ring-red-300';
                } else {
                    button.innerHTML = `
                        <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                        </svg>
                        Show Explanation
                    `;
                    button.className = 'inline-flex items-center px-4 py-2.5 rounded-xl text-sm font-semibold bg-gradient-to-r from-blue-500 to-blue-600 text-white hover:from-blue-600 hover:to-blue-700 border-0 shadow-lg hover:shadow-xl transform hover:scale-105 transition-all duration-300 focus:outline-none focus:ring-4 focus:ring-blue-300';
                }
            }
        }
    </script>
</body>
</html>
