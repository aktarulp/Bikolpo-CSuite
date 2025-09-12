@if($questions->count() > 0)
    <div class="questions-container">
        @foreach($questions as $question)
            <div class="question-card border-b border-gray-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors duration-200" data-question-id="{{ $question->id }}">
                <div class="px-4 py-3">
                    <!-- Mobile-First Question Layout -->
                    <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-3 mb-2">
                        <!-- Left Side: Checkbox, Type Badge, ID, and Question Text -->
                        <div class="flex items-center justify-between sm:justify-start gap-3 flex-1 min-w-0">
                            <div class="flex items-center gap-2 flex-shrink-0">
                                <!-- Checkbox -->
                                <input type="checkbox" 
                                       name="question_ids[]" 
                                       value="{{ $question->id }}" 
                                       class="question-checkbox h-5 w-5 text-blue-600 focus:ring-blue-500 border-gray-300 rounded transition-all duration-200"
                                       {{ $assignedQuestions->contains($question->id) ? 'checked' : '' }}>
                                
                                <!-- Question Number -->
                                <div class="flex items-center space-x-1 question-number-container">
                                    <label class="text-xs">Q#:</label>
                                    <input type="number" 
                                           name="question_numbers[{{ $question->id }}]" 
                                           value="{{ $assignedQuestions->contains($question->id) ? ($assignedQuestionsWithOrder[$question->id] ?? '') : '' }}" 
                                           min="1" 
                                           max="999" 
                                           class="question-number w-10 border rounded text-center text-xs"
                                           style="-moz-appearance: textfield; -webkit-appearance: none; appearance: none;"
                                           {{ !$assignedQuestions->contains($question->id) ? 'disabled' : '' }}>
                                </div>
                                
                                <!-- Question Type Icon -->
                                <div class="w-6 h-6 rounded-md flex items-center justify-center
                                    {{ $question->question_type === 'mcq' ? 'bg-blue-100 dark:bg-blue-900/30' : ($question->question_type === 'true_false' ? 'bg-orange-100 dark:bg-orange-900/30' : 'bg-green-100 dark:bg-green-900/30') }}">
                                    @if($question->question_type === 'mcq')
                                        <img src="{{ asset('images/mcq.png') }}" alt="MCQ" class="w-4 h-4">
                                    @elseif($question->question_type === 'descriptive')
                                        <img src="{{ asset('images/cq.png') }}" alt="CQ" class="w-4 h-4">
                                    @else
                                        <svg class="w-4 h-4 text-orange-600 dark:text-orange-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                    @endif
                                </div>
                                
                                <span class="text-xs font-semibold text-gray-500 dark:text-gray-400">#{{ $question->id }}</span>
                            </div>
                            
                            <!-- Question Type Badge -->
                            <span class="inline-flex items-center px-2 py-1 rounded-md text-xs font-medium flex-shrink-0
                                {{ $question->question_type === 'mcq' ? 'bg-blue-100 text-blue-700 dark:bg-blue-900/30 dark:text-blue-300' : ($question->question_type === 'true_false' ? 'bg-orange-100 text-orange-700 dark:bg-orange-900/30 dark:text-orange-300' : 'bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-300') }}">
                                {{ $question->question_type === 'mcq' ? 'MCQ' : ($question->question_type === 'true_false' ? 'T/F' : 'Descriptive') }}
                            </span>
                            
                            <!-- Question Text with Answer Options - Right after type badge on desktop -->
                            <div class="hidden sm:block text-gray-900 dark:text-white text-sm leading-relaxed flex-1 min-w-0">
                                <span class="text-gray-900 dark:text-white">
                                    {!! Str::limit(strip_tags($question->question_text, '<b><i><u><strong><em><br><p><span><div>'), 200) !!}
                                </span>
                                
                                @if($question->question_type === 'mcq' && ($question->option_a || $question->option_b || $question->option_c || $question->option_d))
                                    <span class="text-gray-500 dark:text-gray-400 ml-2">|</span>
                                    <span class="text-gray-600 dark:text-gray-300 text-xs ml-1">
                                        @if($question->option_a)
                                            <span class="inline-flex items-center justify-center w-4 h-4 rounded-full text-xs font-bold mr-1 border-2
                                                {{ $question->correct_answer === 'A' || $question->correct_answer === 'a' ? 'bg-green-100 text-green-700 border-green-500 dark:bg-green-900 dark:text-green-300 dark:border-green-400' : 'bg-white text-black border-gray-800 dark:bg-gray-800 dark:text-white dark:border-gray-200' }}">
                                                A
                                            </span>
                                            <span class="text-xs">{{ Str::limit(strip_tags($question->option_a), 18) }}</span>
                                        @endif
                                        @if($question->option_b)
                                            <span class="text-gray-400 mx-1">•</span>
                                            <span class="inline-flex items-center justify-center w-4 h-4 rounded-full text-xs font-bold mr-1 border-2
                                                {{ $question->correct_answer === 'B' || $question->correct_answer === 'b' ? 'bg-green-100 text-green-700 border-green-500 dark:bg-green-900 dark:text-green-300 dark:border-green-400' : 'bg-white text-black border-gray-800 dark:bg-gray-800 dark:text-white dark:border-gray-200' }}">
                                                B
                                            </span>
                                            <span class="text-xs">{{ Str::limit(strip_tags($question->option_b), 18) }}</span>
                                        @endif
                                        @if($question->option_c)
                                            <span class="text-gray-400 mx-1">•</span>
                                            <span class="inline-flex items-center justify-center w-4 h-4 rounded-full text-xs font-bold mr-1 border-2
                                                {{ $question->correct_answer === 'C' || $question->correct_answer === 'c' ? 'bg-green-100 text-green-700 border-green-500 dark:bg-green-900 dark:text-green-300 dark:border-green-400' : 'bg-white text-black border-gray-800 dark:bg-gray-800 dark:text-white dark:border-gray-200' }}">
                                                C
                                            </span>
                                            <span class="text-xs">{{ Str::limit(strip_tags($question->option_c), 18) }}</span>
                                        @endif
                                        @if($question->option_d)
                                            <span class="text-gray-400 mx-1">•</span>
                                            <span class="inline-flex items-center justify-center w-4 h-4 rounded-full text-xs font-bold mr-1 border-2
                                                {{ $question->correct_answer === 'D' || $question->correct_answer === 'd' ? 'bg-green-100 text-green-700 border-green-500 dark:bg-green-900 dark:text-green-300 dark:border-green-400' : 'bg-white text-black border-gray-800 dark:bg-gray-800 dark:text-white dark:border-gray-200' }}">
                                                D
                                            </span>
                                            <span class="text-xs">{{ Str::limit(strip_tags($question->option_d), 18) }}</span>
                                        @endif
                                    </span>
                                @elseif($question->question_type === 'true_false')
                                    <span class="text-gray-500 dark:text-gray-400 ml-2">|</span>
                                    <span class="text-gray-600 dark:text-gray-300 text-xs ml-1">
                                        <span class="inline-flex items-center justify-center w-4 h-4 rounded-full text-xs font-bold mr-1 border-2
                                            {{ $question->correct_answer === 'A' || $question->correct_answer === 'a' || $question->correct_answer === 'true' || $question->correct_answer === 'True' ? 'bg-green-100 text-green-700 border-green-500 dark:bg-green-900 dark:text-green-300 dark:border-green-400' : 'bg-white text-black border-gray-800 dark:bg-gray-800 dark:text-white dark:border-gray-200' }}">
                                            A
                                        </span>
                                        <span class="text-xs">{{ $question->option_a ? Str::limit(strip_tags($question->option_a), 28) : 'True' }}</span>
                                        <span class="text-gray-400 mx-1">•</span>
                                        <span class="inline-flex items-center justify-center w-4 h-4 rounded-full text-xs font-bold mr-1 border-2
                                            {{ $question->correct_answer === 'B' || $question->correct_answer === 'b' || $question->correct_answer === 'false' || $question->correct_answer === 'False' ? 'bg-green-100 text-green-700 border-green-500 dark:bg-green-900 dark:text-green-300 dark:border-green-400' : 'bg-white text-black border-gray-800 dark:bg-gray-800 dark:text-white dark:border-gray-200' }}">
                                            B
                                        </span>
                                        <span class="text-xs">{{ $question->option_b ? Str::limit(strip_tags($question->option_b), 28) : 'False' }}</span>
                                    </span>
                                @elseif($question->question_type === 'fill_in_blank' && $question->option_a)
                                    <span class="text-gray-500 dark:text-gray-400 ml-2">|</span>
                                    <span class="text-gray-600 dark:text-gray-300 text-xs ml-1">
                                        <span class="inline-flex items-center justify-center w-4 h-4 rounded-full text-xs font-bold mr-1 border-2 bg-green-100 text-green-700 border-green-500 dark:bg-green-900 dark:text-green-300 dark:border-green-400">
                                            ✓
                                        </span>
                                        <span class="text-xs">{{ Str::limit(strip_tags($question->option_a), 38) }}</span>
                                    </span>
                                @endif
                            </div>
                        </div>
                        
                        <!-- Right Side: Marks Input and Drag Handle -->
                        <div class="flex items-center gap-2 flex-shrink-0">
                            <!-- Marks Input -->
                            <div class="flex items-center space-x-1 question-marks-container">
                                <label class="text-xs text-blue-600 dark:text-blue-400 font-semibold">Marks:</label>
                                <div class="relative">
                                    <input type="number" 
                                           name="question_marks[{{ $question->id }}]" 
                                           value="{{ $assignedQuestionsWithMarks[$question->id] ?? 1 }}" 
                                           min="1" 
                                           max="100" 
                                           step="1"
                                           class="appearance-none question-marks h-6 w-12 border border-blue-400 rounded bg-gray-100 dark:bg-gray-600 dark:border-blue-500 dark:text-white font-semibold text-center text-xs focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                           style="-moz-appearance: textfield; -webkit-appearance: none; appearance: none;"
                                           data-question-id="{{ $question->id }}"
                                           oninput="validateMarksField(this)">
                                    <div class="marks-error absolute -bottom-5 left-0 text-xs text-red-500 hidden" data-question-id="{{ $question->id }}">
                                        Marks must be 1-100
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Drag Handle -->
                            <div class="drag-handle text-gray-400 hover:text-gray-600 dark:text-gray-500 dark:hover:text-gray-300 cursor-move p-1 rounded hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
                                <svg width="24px" height="24px" viewBox="0 0 15 15" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                    <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                                    <g id="SVGRepo_iconCarrier"> 
                                        <path fill-rule="evenodd" clip-rule="evenodd" d="M1 1H0V0H1V1ZM5 1H4V0H5V1ZM9 1H8V0H9V1ZM3 3H14V7H13V4H4V13H7V14H3V3ZM1 5H0V4H1V5ZM7.14645 7.14645C7.27485 7.01805 7.46276 6.96935 7.63736 7.01924L14.6374 9.01924C14.8408 9.07736 14.9856 9.25723 14.999 9.46837C15.0124 9.67952 14.8914 9.87623 14.697 9.95957L11.3808 11.3808L9.95957 14.697C9.87623 14.8914 9.67952 15.0124 9.46837 14.999C9.25723 14.9856 9.07736 14.8408 9.01924 14.6374L7.01924 7.63736C6.96935 7.46276 7.01805 7.27485 7.14645 7.14645ZM8.22801 8.22801L9.59441 13.0104L10.5404 10.803C10.591 10.685 10.685 10.591 10.803 10.5404L13.0104 9.59441L8.22801 8.22801ZM1 9H0V8H1V9Z" fill="currentColor"></path> 
                                    </g>
                                </svg>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Question Text - Full Width on Mobile -->
                    <div class="w-full sm:hidden">
                        <div class="text-gray-900 dark:text-white text-sm leading-relaxed mb-2">
                            {!! Str::limit(strip_tags($question->question_text, '<b><i><u><strong><em><br><p><span><div>'), 200) !!}
                        </div>
                        
                        <!-- Answer Options - Stacked on Mobile -->
                        @if($question->question_type === 'mcq' && ($question->option_a || $question->option_b || $question->option_c || $question->option_d))
                            <div class="flex flex-wrap gap-2 text-xs">
                                @if($question->option_a)
                                    <div class="flex items-center gap-1">
                                        <span class="inline-flex items-center justify-center w-4 h-4 rounded-full text-xs font-bold border-2
                                            {{ $question->correct_answer === 'A' || $question->correct_answer === 'a' ? 'bg-green-100 text-green-700 border-green-500 dark:bg-green-900 dark:text-green-300 dark:border-green-400' : 'bg-white text-black border-gray-800 dark:bg-gray-800 dark:text-white dark:border-gray-200' }}">
                                            A
                                        </span>
                                        <span class="text-gray-600 dark:text-gray-300">{{ Str::limit(strip_tags($question->option_a), 25) }}</span>
                                    </div>
                                @endif
                                @if($question->option_b)
                                    <div class="flex items-center gap-1">
                                        <span class="inline-flex items-center justify-center w-4 h-4 rounded-full text-xs font-bold border-2
                                            {{ $question->correct_answer === 'B' || $question->correct_answer === 'b' ? 'bg-green-100 text-green-700 border-green-500 dark:bg-green-900 dark:text-green-300 dark:border-green-400' : 'bg-white text-black border-gray-800 dark:bg-gray-800 dark:text-white dark:border-gray-200' }}">
                                            B
                                        </span>
                                        <span class="text-gray-600 dark:text-gray-300">{{ Str::limit(strip_tags($question->option_b), 25) }}</span>
                                    </div>
                                @endif
                                @if($question->option_c)
                                    <div class="flex items-center gap-1">
                                        <span class="inline-flex items-center justify-center w-4 h-4 rounded-full text-xs font-bold border-2
                                            {{ $question->correct_answer === 'C' || $question->correct_answer === 'c' ? 'bg-green-100 text-green-700 border-green-500 dark:bg-green-900 dark:text-green-300 dark:border-green-400' : 'bg-white text-black border-gray-800 dark:bg-gray-800 dark:text-white dark:border-gray-200' }}">
                                            C
                                        </span>
                                        <span class="text-gray-600 dark:text-gray-300">{{ Str::limit(strip_tags($question->option_c), 25) }}</span>
                                    </div>
                                @endif
                                @if($question->option_d)
                                    <div class="flex items-center gap-1">
                                        <span class="inline-flex items-center justify-center w-4 h-4 rounded-full text-xs font-bold border-2
                                            {{ $question->correct_answer === 'D' || $question->correct_answer === 'd' ? 'bg-green-100 text-green-700 border-green-500 dark:bg-green-900 dark:text-green-300 dark:border-green-400' : 'bg-white text-black border-gray-800 dark:bg-gray-800 dark:text-white dark:border-gray-200' }}">
                                            D
                                        </span>
                                        <span class="text-gray-600 dark:text-gray-300">{{ Str::limit(strip_tags($question->option_d), 25) }}</span>
                                    </div>
                                @endif
                            </div>
                        @elseif($question->question_type === 'true_false')
                            <div class="flex flex-wrap gap-3 text-xs">
                                <div class="flex items-center gap-1">
                                    <span class="inline-flex items-center justify-center w-4 h-4 rounded-full text-xs font-bold border-2
                                        {{ $question->correct_answer === 'A' || $question->correct_answer === 'a' || $question->correct_answer === 'true' || $question->correct_answer === 'True' ? 'bg-green-100 text-green-700 border-green-500 dark:bg-green-900 dark:text-green-300 dark:border-green-400' : 'bg-white text-black border-gray-800 dark:bg-gray-800 dark:text-white dark:border-gray-200' }}">
                                        A
                                    </span>
                                    <span class="text-gray-600 dark:text-gray-300">{{ $question->option_a ? Str::limit(strip_tags($question->option_a), 30) : 'True' }}</span>
                                </div>
                                <div class="flex items-center gap-1">
                                    <span class="inline-flex items-center justify-center w-4 h-4 rounded-full text-xs font-bold border-2
                                        {{ $question->correct_answer === 'B' || $question->correct_answer === 'b' || $question->correct_answer === 'false' || $question->correct_answer === 'False' ? 'bg-green-100 text-green-700 border-green-500 dark:bg-green-900 dark:text-green-300 dark:border-green-400' : 'bg-white text-black border-gray-800 dark:bg-gray-800 dark:text-white dark:border-gray-200' }}">
                                        B
                                    </span>
                                    <span class="text-gray-600 dark:text-gray-300">{{ $question->option_b ? Str::limit(strip_tags($question->option_b), 30) : 'False' }}</span>
                                </div>
                            </div>
                        @elseif($question->question_type === 'fill_in_blank' && $question->option_a)
                            <div class="flex items-center gap-1 text-xs">
                                <span class="inline-flex items-center justify-center w-4 h-4 rounded-full text-xs font-bold border-2 bg-green-100 text-green-700 border-green-500 dark:bg-green-900 dark:text-green-300 dark:border-green-400">
                                    ✓
                                </span>
                                <span class="text-gray-600 dark:text-gray-300">{{ Str::limit(strip_tags($question->option_a), 40) }}</span>
                            </div>
                        @endif
                    </div>
                </div>
                
                <!-- Metadata Row -->
                <div class="flex flex-wrap items-center gap-4 text-xs text-gray-500 dark:text-gray-400">
                    <div class="flex items-center gap-1">
                        <svg class="w-3 h-3 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                        </svg>
                        <span class="font-medium">{{ $question->course->name ?? 'N/A' }}</span>
                    </div>
                    <div class="flex items-center gap-1">
                        <svg class="w-3 h-3 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        <span class="font-medium">{{ $question->subject->name ?? 'N/A' }}</span>
                    </div>
                    <div class="flex items-center gap-1">
                        <svg class="w-3 h-3 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                        </svg>
                        <span class="font-medium">{{ $question->topic->name ?? 'N/A' }}</span>
                    </div>
                    <div class="flex items-center gap-1">
                        <svg class="w-3 h-3 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <span class="font-medium">{{ $question->created_at->format('M d, Y') }}</span>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@else
    <div class="text-center py-16">
        <div class="mx-auto w-24 h-24 bg-gray-100 dark:bg-gray-700 rounded-full flex items-center justify-center mb-6">
            <svg class="h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
            </svg>
        </div>
        <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-2">No questions available</h3>
        <p class="text-gray-500 dark:text-gray-400 mb-8 max-w-md mx-auto">
            Create some questions first before assigning them to exams.
        </p>
        <div class="flex flex-col sm:flex-row gap-3 sm:justify-center">
            <a href="{{ route('partner.questions.create') }}" 
               class="inline-flex items-center px-6 py-3 border border-transparent shadow-sm text-sm font-medium rounded-lg text-white bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all duration-200">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                </svg>
                Create Question
            </a>
            <a href="{{ route('partner.questions.all') }}" 
               class="inline-flex items-center px-6 py-3 border border-gray-300 shadow-sm text-sm font-medium rounded-lg text-gray-700 bg-white hover:bg-gray-50 dark:bg-gray-800 dark:border-gray-600 dark:text-gray-300 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all duration-200">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"/>
                </svg>
                View All Questions
            </a>
        </div>
    </div>
@endif
