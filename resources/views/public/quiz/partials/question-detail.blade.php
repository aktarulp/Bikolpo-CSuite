<div class="border border-gray-200 rounded-lg p-2 sm:p-3 hover:shadow-sm transition-shadow">
    <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between mb-2 space-y-2 sm:space-y-0">
        <div class="flex items-start space-x-2 min-w-0 flex-1">
            <div class="min-w-0 flex-1">
                <h3 class="text-xs sm:text-sm font-semibold text-gray-900">
                    <span class="inline-flex items-center">
                        Q{{ $index + 1 }}
                        @if($questionStat->question->question_type === 'mcq')
                            <span class="ml-1 inline-flex items-center px-1 sm:px-1.5 py-0.5 rounded text-xs font-medium bg-blue-100 text-blue-800">
                                MCQ
                            </span>
                        @elseif($questionStat->question->question_type === 'descriptive')
                            <span class="ml-1 inline-flex items-center px-1 sm:px-1.5 py-0.5 rounded text-xs font-medium bg-purple-100 text-purple-800">
                                CQ
                            </span>
                        @endif
                    </span>
                    <div class="mt-1 text-xs sm:text-sm font-normal text-gray-700 leading-relaxed">{{ Str::limit($questionStat->question->question_text, 100) }}</div>
                </h3>
            </div>
        </div>
        <div class="flex flex-wrap items-center gap-1 sm:gap-2 sm:flex-nowrap">
            @if($questionStat->is_correct)
                <span class="inline-flex items-center px-2 sm:px-3 py-1 rounded-full text-xs font-bold bg-green-100 text-green-800 border border-green-200">
                    <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                    </svg>
                    <span class="hidden sm:inline">Correct</span>
                    <span class="sm:hidden">✓</span>
                </span>
            @elseif($questionStat->is_answered && !$questionStat->is_correct)
                <span class="inline-flex items-center px-2 sm:px-3 py-1 rounded-full text-xs font-bold bg-red-100 text-red-800 border border-red-200">
                    <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                    </svg>
                    <span class="hidden sm:inline">Incorrect</span>
                    <span class="sm:hidden">✗</span>
                </span>
            @else
                <span class="inline-flex items-center px-2 sm:px-3 py-1 rounded-full text-xs font-bold bg-orange-100 text-orange-800 border border-orange-200">
                    <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                    </svg>
                    <span class="hidden sm:inline">Skipped</span>
                    <span class="sm:hidden">-</span>
                </span>
            @endif
            <div class="inline-flex items-center px-2 py-1 rounded-full text-xs font-bold bg-blue-100 text-blue-800 border border-blue-200">
                <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                </svg>
                @php
                    $maxMarks = $questionStat->question->expected_answer_points ?? $questionStat->question->marks ?? 1;
                    $negativeMarks = $exam->has_negative_marking ? $exam->negative_marks_per_question : 0;
                @endphp
                @if($questionStat->is_correct)
                    {{ $questionStat->marks }}/{{ $maxMarks }}
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
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-2 sm:gap-1">
                <div class="flex items-start space-x-2 p-2 sm:p-2 rounded text-xs
                    @if($questionStat->student_answer === 'a' && $questionStat->correct_answer === 'a') bg-green-50 border-2 border-green-300
                    @elseif($questionStat->student_answer === 'a') bg-red-50 border-2 border-red-300
                    @elseif($questionStat->correct_answer === 'a') bg-green-50 border-2 border-green-300
                    @else bg-gray-50 border border-gray-200 @endif">
                    <div class="flex items-center justify-center w-5 h-5 sm:w-6 sm:h-6 rounded-full text-xs font-bold flex-shrink-0
                        @if($questionStat->student_answer === 'a' && $questionStat->correct_answer === 'a') bg-green-600 text-white
                        @elseif($questionStat->student_answer === 'a') bg-red-600 text-white
                        @elseif($questionStat->correct_answer === 'a') bg-green-600 text-white
                        @else bg-gray-600 text-white @endif">
                        A
                    </div>
                    <div class="flex-1 min-w-0">
                        <span class="text-gray-700 block text-xs sm:text-xs leading-relaxed">{{ Str::limit($questionStat->question->option_a, 30) }}</span>
                        @if($questionStat->student_answer === 'a')
                            <span class="inline-flex items-center px-1.5 py-0.5 rounded-full text-xs font-bold bg-blue-100 text-blue-800 border border-blue-200 mt-1">
                                <svg class="w-2 h-2 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path>
                                </svg>
                                <span class="hidden sm:inline">Your Answer</span>
                                <span class="sm:hidden">You</span>
                            </span>
                        @endif
                        @if($questionStat->correct_answer === 'a')
                            <span class="inline-flex items-center px-1.5 py-0.5 rounded-full text-xs font-bold bg-green-100 text-green-800 border border-green-200 mt-1 ml-1">
                                <svg class="w-2 h-2 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                </svg>
                                <span class="hidden sm:inline">Correct</span>
                                <span class="sm:hidden">✓</span>
                            </span>
                        @endif
                    </div>
                </div>
                
                <div class="flex items-start space-x-2 p-2 sm:p-2 rounded text-xs
                    @if($questionStat->student_answer === 'b' && $questionStat->correct_answer === 'b') bg-green-50 border-2 border-green-300
                    @elseif($questionStat->student_answer === 'b') bg-red-50 border-2 border-red-300
                    @elseif($questionStat->correct_answer === 'b') bg-green-50 border-2 border-green-300
                    @else bg-gray-50 border border-gray-200 @endif">
                    <div class="flex items-center justify-center w-5 h-5 sm:w-6 sm:h-6 rounded-full text-xs font-bold flex-shrink-0
                        @if($questionStat->student_answer === 'b' && $questionStat->correct_answer === 'b') bg-green-600 text-white
                        @elseif($questionStat->student_answer === 'b') bg-red-600 text-white
                        @elseif($questionStat->correct_answer === 'b') bg-green-600 text-white
                        @else bg-gray-600 text-white @endif">
                        B
                    </div>
                    <div class="flex-1 min-w-0">
                        <span class="text-gray-700 block text-xs sm:text-xs leading-relaxed">{{ Str::limit($questionStat->question->option_b, 30) }}</span>
                        @if($questionStat->student_answer === 'b')
                            <span class="inline-flex items-center px-1.5 py-0.5 rounded-full text-xs font-bold bg-blue-100 text-blue-800 border border-blue-200 mt-1">
                                <svg class="w-2 h-2 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path>
                                </svg>
                                <span class="hidden sm:inline">Your Answer</span>
                                <span class="sm:hidden">You</span>
                            </span>
                        @endif
                        @if($questionStat->correct_answer === 'b')
                            <span class="inline-flex items-center px-1.5 py-0.5 rounded-full text-xs font-bold bg-green-100 text-green-800 border border-green-200 mt-1 ml-1">
                                <svg class="w-2 h-2 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                </svg>
                                <span class="hidden sm:inline">Correct</span>
                                <span class="sm:hidden">✓</span>
                            </span>
                        @endif
                    </div>
                </div>
                
                <div class="flex items-start space-x-2 p-2 sm:p-2 rounded text-xs
                    @if($questionStat->student_answer === 'c' && $questionStat->correct_answer === 'c') bg-green-50 border-2 border-green-300
                    @elseif($questionStat->student_answer === 'c') bg-red-50 border-2 border-red-300
                    @elseif($questionStat->correct_answer === 'c') bg-green-50 border-2 border-green-300
                    @else bg-gray-50 border border-gray-200 @endif">
                    <div class="flex items-center justify-center w-5 h-5 sm:w-6 sm:h-6 rounded-full text-xs font-bold flex-shrink-0
                        @if($questionStat->student_answer === 'c' && $questionStat->correct_answer === 'c') bg-green-600 text-white
                        @elseif($questionStat->student_answer === 'c') bg-red-600 text-white
                        @elseif($questionStat->correct_answer === 'c') bg-green-600 text-white
                        @else bg-gray-600 text-white @endif">
                        C
                    </div>
                    <div class="flex-1 min-w-0">
                        <span class="text-gray-700 block text-xs sm:text-xs leading-relaxed">{{ Str::limit($questionStat->question->option_c, 30) }}</span>
                        @if($questionStat->student_answer === 'c')
                            <span class="inline-flex items-center px-1.5 py-0.5 rounded-full text-xs font-bold bg-blue-100 text-blue-800 border border-blue-200 mt-1">
                                <svg class="w-2 h-2 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path>
                                </svg>
                                <span class="hidden sm:inline">Your Answer</span>
                                <span class="sm:hidden">You</span>
                            </span>
                        @endif
                        @if($questionStat->correct_answer === 'c')
                            <span class="inline-flex items-center px-1.5 py-0.5 rounded-full text-xs font-bold bg-green-100 text-green-800 border border-green-200 mt-1 ml-1">
                                <svg class="w-2 h-2 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                </svg>
                                <span class="hidden sm:inline">Correct</span>
                                <span class="sm:hidden">✓</span>
                            </span>
                        @endif
                    </div>
                </div>
                
                <div class="flex items-start space-x-2 p-2 sm:p-2 rounded text-xs
                    @if($questionStat->student_answer === 'd' && $questionStat->correct_answer === 'd') bg-green-50 border-2 border-green-300
                    @elseif($questionStat->student_answer === 'd') bg-red-50 border-2 border-red-300
                    @elseif($questionStat->correct_answer === 'd') bg-green-50 border-2 border-green-300
                    @else bg-gray-50 border border-gray-200 @endif">
                    <div class="flex items-center justify-center w-5 h-5 sm:w-6 sm:h-6 rounded-full text-xs font-bold flex-shrink-0
                        @if($questionStat->student_answer === 'd' && $questionStat->correct_answer === 'd') bg-green-600 text-white
                        @elseif($questionStat->student_answer === 'd') bg-red-600 text-white
                        @elseif($questionStat->correct_answer === 'd') bg-green-600 text-white
                        @else bg-gray-600 text-white @endif">
                        D
                    </div>
                    <div class="flex-1 min-w-0">
                        <span class="text-gray-700 block text-xs sm:text-xs leading-relaxed">{{ Str::limit($questionStat->question->option_d, 30) }}</span>
                        @if($questionStat->student_answer === 'd')
                            <span class="inline-flex items-center px-1.5 py-0.5 rounded-full text-xs font-bold bg-blue-100 text-blue-800 border border-blue-200 mt-1">
                                <svg class="w-2 h-2 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path>
                                </svg>
                                <span class="hidden sm:inline">Your Answer</span>
                                <span class="sm:hidden">You</span>
                            </span>
                        @endif
                        @if($questionStat->correct_answer === 'd')
                            <span class="inline-flex items-center px-1.5 py-0.5 rounded-full text-xs font-bold bg-green-100 text-green-800 border border-green-200 mt-1 ml-1">
                                <svg class="w-2 h-2 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                </svg>
                                <span class="hidden sm:inline">Correct</span>
                                <span class="sm:hidden">✓</span>
                            </span>
                        @endif
                    </div>
                </div>
            </div>
        @else
            <div class="space-y-2">
                <div class="p-2 sm:p-2 bg-blue-50 border border-blue-200 rounded text-xs">
                    <h4 class="font-medium text-blue-900 mb-1 text-xs sm:text-sm">Your Answer:</h4>
                    <p class="text-blue-800 text-xs sm:text-sm leading-relaxed">{{ Str::limit($questionStat->student_answer, 120) }}</p>
                </div>
            </div>
        @endif
    </div>

    <div id="explanation-{{ $index }}" class="hidden p-2 sm:p-2 bg-yellow-50 border border-yellow-200 rounded text-xs">
        <h4 class="font-medium text-yellow-900 mb-1 text-xs sm:text-sm">Explanation:</h4>
        @if($questionStat->question->explanation && trim($questionStat->question->explanation) !== '')
            <p class="text-yellow-800 text-xs sm:text-sm leading-relaxed">{{ Str::limit($questionStat->question->explanation, 100) }}</p>
        @else
            <p class="text-yellow-600 italic text-xs sm:text-sm">Not Filled Yet</p>
        @endif
    </div>

    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mt-2 pt-2 border-t border-gray-200 text-xs text-gray-500 space-y-1 sm:space-y-0">
        <div class="flex items-center space-x-2 sm:space-x-3">
            <span class="text-xs">{{ $questionStat->marks }}m</span>
            @if($questionStat->time_spent_seconds)
                <span class="text-xs">{{ $questionStat->time_spent_formatted }}</span>
            @endif
        </div>
        <div class="text-gray-400 text-xs">
            {{ $questionStat->question->subject->name ?? 'General' }}
        </div>
    </div>
</div>
