<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Taking Quiz - {{ $exam->title }}</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <style>
        .question-transition { transition: all 0.3s ease-in-out; }
        .question-fade-in { animation: fadeIn 0.5s ease-in-out; }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .progress-bar { transition: width 0.3s ease-in-out; }
        .timer-warning { animation: pulse 2s infinite; }
        @keyframes pulse {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.7; }
        }
        
        /* Mobile-specific styles */
        @media (max-width: 768px) {
            .mobile-nav-toggle {
                display: block;
            }
            .mobile-nav-toggle.hidden {
                display: none;
            }
            .question-navigation {
                max-height: none;
                overflow: visible;
            }
            .question-grid-mobile {
                grid-template-columns: repeat(4, 1fr);
                gap: 0.5rem;
            }
            .question-nav-btn-mobile {
                width: 2.5rem;
                height: 2.5rem;
                font-size: 0.75rem;
            }
        }
        
        /* Hide desktop elements on mobile */
        @media (max-width: 768px) {
            .desktop-only {
                display: none !important;
            }
        }
        
        /* Show mobile elements only on mobile */
        @media (min-width: 769px) {
            .mobile-only {
                display: none !important;
            }
        }
    </style>
</head>
<body class="font-sans antialiased bg-gradient-to-br from-slate-50 via-blue-50 to-indigo-50">
    <!-- Header with Timer and Progress -->
    <div class="bg-white shadow-lg border-b border-gray-200 sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center py-4 space-y-3 sm:space-y-0">
                <!-- Exam Info -->
                <div class="flex items-center w-full sm:w-auto">
                    <div class="w-10 h-10 sm:w-12 sm:h-12 bg-gradient-to-br from-primaryGreen to-emerald-500 rounded-xl flex items-center justify-center mr-3 shadow-lg">
                        <svg class="w-5 h-5 sm:w-7 sm:h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                        </svg>
                    </div>
                    <div class="flex-1 min-w-0">
                        <h1 class="text-lg sm:text-xl font-bold text-gray-900 truncate">{{ $exam->title }}</h1>
                        <p class="text-xs sm:text-sm text-gray-600">Professional Quiz System</p>
                    </div>
                </div>
                
                <!-- Timer and Progress -->
                <div class="flex items-center space-x-3 sm:space-x-6 w-full sm:w-auto justify-between sm:justify-end">
                    <!-- Progress Bar - Mobile -->
                    <div class="sm:hidden flex-1 max-w-32">
                        <div class="flex items-center justify-between text-xs text-gray-600 mb-1">
                            <span>Progress</span>
                            <span id="progress-text-mobile">0/{{ $questions->count() }}</span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-2">
                            <div class="bg-gradient-to-r from-primaryGreen to-emerald-500 h-2 rounded-full progress-bar" id="progress-bar-mobile" style="width: 0%"></div>
                        </div>
                    </div>
                    
                    <!-- Progress Bar - Desktop -->
                    <div class="hidden sm:block w-48 desktop-only">
                        <div class="flex items-center justify-between text-sm text-gray-600 mb-1">
                            <span>Progress</span>
                            <span id="progress-text">0/{{ $questions->count() }}</span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-2">
                            <div class="bg-gradient-to-r from-primaryGreen to-emerald-500 h-2 rounded-full progress-bar" id="progress-bar" style="width: 0%"></div>
                        </div>
                    </div>
                    
                    <!-- Timer -->
                    <div class="text-center">
                        <div class="text-xl sm:text-3xl font-bold text-gray-900" id="timer">--:--</div>
                        <div class="text-xs text-gray-500">Time</div>
                    </div>
                    
                    <!-- Timer Circle -->
                    <div class="w-16 h-16 sm:w-20 sm:h-20 relative">
                        <svg class="w-16 h-16 sm:w-20 sm:h-20 transform -rotate-90" viewBox="0 0 36 36">
                            <path class="text-gray-200" stroke="currentColor" stroke-width="2" fill="none" d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831"/>
                            <path class="text-primaryGreen" stroke="currentColor" stroke-width="2" fill="none" stroke-dasharray="100, 100" stroke-dashoffset="0" d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831" id="timer-circle"/>
                        </svg>
                        <div class="absolute inset-0 flex items-center justify-center">
                            <span class="text-xs sm:text-sm font-medium text-gray-700" id="timer-percentage">100%</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="max-w-6xl mx-auto px-3 sm:px-4 lg:px-8 py-4 sm:py-8">
        <!-- Question Navigator - Top of Quiz Window -->
        <div class="mb-6 sm:mb-8">
            <div class="bg-white rounded-xl shadow-lg border border-gray-200 p-4 sm:p-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                        <svg class="w-5 h-5 mr-2 text-primaryGreen" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                        </svg>
                        Question Navigator:
                    </h3>
                    
                    <!-- Legend -->
                    <div class="flex items-center space-x-4 text-xs sm:text-sm text-gray-600">
                        <div class="flex items-center space-x-2">
                            <div class="w-3 h-3 rounded-full border-2 border-primaryGreen bg-primaryGreen"></div>
                            <span>Current</span>
                        </div>
                        <div class="flex items-center space-x-2">
                            <div class="w-3 h-3 rounded-full border-2 border-green-300 bg-green-100"></div>
                            <span>Answered</span>
                        </div>
                        <div class="flex items-center space-x-2">
                            <div class="w-3 h-3 rounded-full border-2 border-gray-300 bg-gray-100"></div>
                            <span>Unanswered</span>
                        </div>
                    </div>
                </div>
                
                <div class="question-navigation">
                    <!-- Desktop Grid - Landscape Layout -->
                    <div class="hidden sm:flex flex-wrap justify-center gap-1" id="question-grid">
                        @foreach($questions as $index => $question)
                        <button type="button" 
                                class="question-nav-btn w-7 h-7 rounded-full border-2 text-sm font-medium transition-all duration-200 {{ $index === 0 ? 'border-primaryGreen bg-primaryGreen text-white' : 'border-gray-300 text-gray-600 hover:border-primaryGreen hover:text-primaryGreen' }}"
                                data-question="{{ $index }}"
                                onclick="navigateToQuestion({{ $index }})">
                            {{ $index + 1 }}
                        </button>
                        @endforeach
                    </div>
                    
                    <!-- Mobile Grid - Landscape Layout -->
                    <div class="sm:hidden flex flex-wrap justify-center gap-1.5" id="question-grid-mobile">
                        @foreach($questions as $index => $question)
                        <button type="button" 
                                class="question-nav-btn-mobile w-9 h-9 rounded-full border-2 text-xs font-medium transition-all duration-200 {{ $index === 0 ? 'border-primaryGreen bg-primaryGreen text-white' : 'border-gray-300 text-gray-600 hover:border-primaryGreen hover:text-primaryGreen' }}"
                                data-question="{{ $index }}"
                                onclick="navigateToQuestion({{ $index }})">
                            {{ $index + 1 }}
                        </button>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        <!-- Question Content - Full Width -->
        <div class="w-full">
            <form id="quiz-form" method="POST" action="{{ route('public.quiz.submit', $exam->id) }}" class="space-y-4 sm:space-y-6">
                @csrf
                
                @foreach($questions as $index => $question)
                <div class="question-container bg-white rounded-xl shadow-lg border border-gray-200 p-4 sm:p-8 question-transition {{ $index === 0 ? 'question-fade-in' : 'hidden' }}" 
                     data-question="{{ $index }}" 
                     id="question-{{ $index }}">
                    
                    <!-- Question Header -->
                    <div class="flex flex-col sm:flex-row sm:items-start justify-between mb-4 sm:mb-6 space-y-3 sm:space-y-0">
                        <div class="flex items-center space-x-3 sm:space-x-4">
                            <div class="w-10 h-10 sm:w-12 sm:h-12 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-xl flex items-center justify-center text-white font-bold text-base sm:text-lg shadow-lg">
                                {{ $index + 1 }}
                            </div>
                            <div class="flex-1 min-w-0">
                                <h3 class="text-lg sm:text-xl font-semibold text-gray-900">Question {{ $index + 1 }} of {{ $questions->count() }}</h3>
                                @if($question->pivot && $question->pivot->marks)
                                    <p class="text-sm text-gray-500">Worth {{ $question->pivot->marks }} marks</p>
                                @endif
                            </div>
                        </div>
                        
                        <!-- Question Type Badge -->
                        <span class="inline-flex items-center px-2 sm:px-3 py-1 rounded-full text-xs sm:text-sm font-medium 
                            {{ $question->question_type === 'mcq' ? 'bg-blue-100 text-blue-800' : 'bg-purple-100 text-purple-800' }}">
                            {{ strtoupper($question->question_type) }}
                        </span>
                    </div>

                    <!-- Question Text -->
                    <div class="mb-6 sm:mb-8">
                        <p class="text-gray-800 text-base sm:text-lg leading-relaxed font-medium">{{ $question->question_text }}</p>
                    </div>

                    <!-- Question Image (if any) -->
                    @if($question->image)
                    <div class="mb-6 sm:mb-8 text-center">
                        <img src="{{ asset('storage/' . $question->image) }}" alt="Question Image" class="max-w-full h-auto rounded-lg border border-gray-200 shadow-md">
                    </div>
                    @endif

                    <!-- MCQ Options -->
                    @if($question->question_type === 'mcq')
                    <div class="space-y-3 sm:space-y-4 mb-6 sm:mb-8">
                        @foreach(['a', 'b', 'c', 'd'] as $option)
                            @if($question->{'option_' . $option})
                            <label class="flex items-center p-3 sm:p-4 border-2 border-gray-200 rounded-xl cursor-pointer hover:bg-gray-50 hover:border-primaryGreen transition-all duration-200 group">
                                <input type="radio" 
                                       name="answers[{{ $question->id }}]" 
                                       value="{{ $option }}"
                                       class="h-4 w-4 sm:h-5 sm:w-5 text-primaryGreen focus:ring-primaryGreen border-gray-300"
                                       onchange="markQuestionAnswered({{ $index }})">
                                <div class="ml-3 sm:ml-4 flex items-center flex-1 min-w-0">
                                    <div class="w-6 h-6 sm:w-8 sm:h-8 bg-gray-100 rounded-lg flex items-center justify-center text-xs sm:text-sm font-bold text-gray-600 group-hover:bg-primaryGreen group-hover:text-white transition-all duration-200 flex-shrink-0">
                                        {{ strtoupper($option) }}
                                    </div>
                                    <span class="ml-2 sm:ml-3 text-gray-700 text-sm sm:text-lg truncate">{{ $question->{'option_' . $option} }}</span>
                                </div>
                            </label>
                            @endif
                        @endforeach
                    </div>
                    @endif

                    <!-- Descriptive Answer -->
                    @if($question->question_type === 'descriptive')
                    <div class="space-y-3 sm:space-y-4 mb-6 sm:mb-8">
                        <div>
                            <label for="answer_{{ $question->id }}" class="block text-base sm:text-lg font-medium text-gray-700 mb-2 sm:mb-3">
                                Your Answer
                                @if($question->min_words || $question->max_words)
                                    <span class="text-xs sm:text-sm text-gray-500 ml-2">
                                        ({{ $question->min_words ?? 0 }}-{{ $question->max_words ?? 'unlimited' }} words)
                                    </span>
                                @endif
                            </label>
                            <textarea id="answer_{{ $question->id }}"
                                      name="answers[{{ $question->id }}]"
                                      rows="4"
                                      class="block w-full border-2 border-gray-300 rounded-xl px-3 sm:px-4 py-2 sm:py-3 focus:outline-none focus:ring-2 focus:ring-primaryGreen focus:border-primaryGreen transition-all duration-200 text-sm sm:text-lg"
                                      placeholder="Type your detailed answer here..."
                                      oninput="updateWordCount({{ $question->id }}, this.value); markQuestionAnswered({{ $index }})"></textarea>
                            <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center mt-2 sm:mt-3 space-y-1 sm:space-y-0">
                                <span class="text-xs sm:text-sm text-gray-500" id="word-count-{{ $question->id }}">0 words</span>
                                @if($question->min_words)
                                    <span class="text-xs sm:text-sm text-gray-500">Minimum: {{ $question->min_words }} words</span>
                                @endif
                            </div>
                        </div>
                    </div>
                    @endif

                    <!-- Question Actions -->
                    <div class="flex flex-col sm:flex-row items-stretch sm:items-center justify-between pt-4 sm:pt-6 border-t border-gray-200 space-y-3 sm:space-y-0">
                        <div class="flex flex-col sm:flex-row items-stretch sm:items-center space-y-2 sm:space-y-0 sm:space-x-3">
                            @if($index > 0)
                            <button type="button" 
                                    onclick="previousQuestion()"
                                    class="w-full sm:w-auto px-4 sm:px-6 py-3 border-2 border-gray-300 text-gray-700 font-medium rounded-lg hover:bg-gray-50 hover:border-gray-400 transition-all duration-200 flex items-center justify-center">
                                <svg class="w-4 h-4 sm:w-5 sm:h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                                </svg>
                                Previous
                            </button>
                            @endif
                            
                            <button type="button" 
                                    onclick="skipQuestion()"
                                    class="w-full sm:w-auto px-4 sm:px-6 py-3 border-2 border-yellow-300 text-yellow-700 font-medium rounded-lg hover:bg-yellow-50 hover:border-yellow-400 transition-all duration-200 flex items-center justify-center">
                                <svg class="w-4 h-4 sm:w-5 sm:h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 17l5-5-5-5"></path>
                                </svg>
                                Skip
                            </button>
                        </div>
                        
                        <div class="flex flex-col sm:flex-row items-stretch sm:items-center space-y-2 sm:space-y-0 sm:space-x-3">
                            @if($index < $questions->count() - 1)
                            <button type="button" 
                                    onclick="nextQuestion()"
                                    class="w-full sm:w-auto px-4 sm:px-6 py-3 bg-gradient-to-r from-primaryGreen to-emerald-600 text-white font-medium rounded-lg hover:from-primaryGreen/90 hover:to-emerald-600/90 transition-all duration-200 flex items-center justify-center">
                                Next
                                <svg class="w-4 h-4 sm:w-5 sm:h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                </svg>
                            </button>
                            @else
                            <button type="button" 
                                    onclick="showReviewModal()"
                                    class="w-full sm:w-auto px-4 sm:px-6 py-3 bg-gradient-to-r from-blue-500 to-indigo-600 text-white font-medium rounded-lg hover:from-blue-500/90 hover:to-indigo-600/90 transition-all duration-200 flex items-center justify-center">
                                <svg class="w-4 h-4 sm:w-5 sm:h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                Review & Submit
                            </button>
                            @endif
                        </div>
                    </div>
                </div>
                @endforeach
            </form>
        </div>
    </div>

    <!-- Review Modal -->
    <div id="review-modal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
        <div class="relative top-4 sm:top-10 mx-auto p-4 sm:p-5 border w-11/12 md:w-3/4 lg:w-1/2 shadow-lg rounded-xl bg-white">
            <div class="mt-3">
                <div class="flex items-center justify-between mb-4 sm:mb-6">
                    <h3 class="text-xl sm:text-2xl font-bold text-gray-900">Review Your Answers</h3>
                    <button onclick="hideReviewModal()" class="text-gray-400 hover:text-gray-600">
                        <svg class="w-5 h-5 sm:w-6 sm:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
                
                <div class="max-h-64 sm:max-h-96 overflow-y-auto mb-4 sm:mb-6">
                    <div id="review-content" class="space-y-3 sm:space-y-4">
                        <!-- Review content will be populated here -->
                    </div>
                </div>
                
                <div class="flex flex-col sm:flex-row items-stretch sm:items-center justify-between pt-4 border-t border-gray-200 space-y-3 sm:space-y-0">
                    <div class="text-xs sm:text-sm text-gray-600 space-y-1">
                        <p>Total Questions: <span class="font-semibold">{{ $questions->count() }}</span></p>
                        <p>Answered: <span class="font-semibold text-green-600" id="answered-count">0</span></p>
                        <p>Skipped: <span class="font-semibold text-yellow-600" id="skipped-count">0</span></p>
                    </div>
                    
                    <div class="flex flex-col sm:flex-row space-y-2 sm:space-y-0 sm:space-x-3">
                        <button onclick="hideReviewModal()" 
                                class="w-full sm:w-auto px-4 sm:px-6 py-3 border-2 border-gray-300 text-gray-700 font-medium rounded-lg hover:bg-gray-50 transition-all duration-200">
                            Continue Quiz
                        </button>
                        <button onclick="submitQuiz()" 
                                class="w-full sm:w-auto px-6 sm:px-8 py-3 bg-gradient-to-r from-primaryGreen to-emerald-600 text-white font-medium rounded-lg hover:from-primaryGreen/90 hover:to-emerald-600/90 transition-all duration-200">
                            Submit Quiz
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Auto-submit Modal -->
    <div id="auto-submit-modal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
        <div class="relative top-4 sm:top-20 mx-auto p-4 sm:p-5 border w-11/12 sm:w-96 shadow-lg rounded-xl bg-white">
            <div class="mt-3 text-center">
                <div class="mx-auto flex items-center justify-center h-12 w-12 sm:h-16 sm:w-16 rounded-full bg-red-100">
                    <svg class="h-6 w-6 sm:h-8 sm:w-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <h3 class="text-lg sm:text-xl font-bold text-gray-900 mt-4">Time's Up!</h3>
                <div class="mt-2 px-4 sm:px-7">
                    <p class="text-xs sm:text-sm text-gray-500">Your quiz time has expired. The quiz will be submitted automatically.</p>
                </div>
                <div class="items-center px-4 py-3">
                    <button id="auto-submit-btn" class="w-full px-4 sm:px-6 py-2 sm:py-3 bg-red-600 text-white text-sm sm:text-base font-medium rounded-lg shadow-sm hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-300 transition-all duration-200">
                        Submit Now
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Quiz state management
        let currentQuestion = 0;
        let totalQuestions = {{ $questions->count() }};
        let answeredQuestions = new Set();
        let skippedQuestions = new Set();
        let timeRemaining = {{ $remainingTime }};
        const totalTime = {{ $exam->duration * 60 }};
        let timerInterval;
        
        // Debug information
        console.log('Debug Timer Info:', {
            timeRemaining: {{ $remainingTime }},
            examDuration: {{ $exam->duration }},
            totalTimeSeconds: {{ $exam->duration * 60 }},
            startedAt: '{{ $result->started_at }}',
            currentTime: '{{ now() }}'
        });
        
        // Fallback for negative or zero remaining time
        if (timeRemaining <= 0) {
            console.warn('Timer shows expired or negative time, using exam duration as fallback');
            timeRemaining = totalTime;
        }
        
        // Fallback for invalid exam duration
        if (totalTime <= 0) {
            console.error('Invalid exam duration detected:', totalTime);
            timeRemaining = 3600; // Default to 1 hour
        }
        
        // Navigation functions
        function navigateToQuestion(questionIndex) {
            if (questionIndex < 0 || questionIndex >= totalQuestions) return;
            
            // Hide current question
            document.querySelectorAll('.question-container').forEach(q => q.classList.add('hidden'));
            
            // Show target question
            document.getElementById(`question-${questionIndex}`).classList.remove('hidden');
            document.getElementById(`question-${questionIndex}`).classList.add('question-fade-in');
            
            // Update current question
            currentQuestion = questionIndex;
            
            // Update navigation buttons
            updateNavigationButtons();
            
            // Update progress
            updateProgress();
        }
        
        function nextQuestion() {
            if (currentQuestion < totalQuestions - 1) {
                navigateToQuestion(currentQuestion + 1);
            }
        }
        
        function previousQuestion() {
            if (currentQuestion > 0) {
                navigateToQuestion(currentQuestion - 1);
            }
        }
        
        function skipQuestion() {
            skippedQuestions.add(currentQuestion);
            updateQuestionStatus(currentQuestion, 'skipped');
            
            if (currentQuestion < totalQuestions - 1) {
                nextQuestion();
            } else {
                showReviewModal();
            }
        }
        
        function updateNavigationButtons() {
            // Update question grid (desktop)
            document.querySelectorAll('#question-grid .question-nav-btn').forEach((btn, index) => {
                btn.classList.remove('border-primaryGreen', 'bg-primaryGreen', 'text-white', 'border-green-300', 'bg-green-100', 'text-green-700', 'border-yellow-300', 'bg-yellow-100', 'text-yellow-700');
                
                if (index === currentQuestion) {
                    btn.classList.add('border-primaryGreen', 'bg-primaryGreen', 'text-white');
                } else if (answeredQuestions.has(index)) {
                    btn.classList.add('border-green-300', 'bg-green-100', 'text-green-700');
                } else {
                    btn.classList.add('border-gray-300', 'text-gray-600');
                }
            });
            
            // Update question grid (mobile)
            document.querySelectorAll('#question-grid-mobile .question-nav-btn-mobile').forEach((btn, index) => {
                btn.classList.remove('border-primaryGreen', 'bg-primaryGreen', 'text-white', 'border-green-300', 'bg-green-100', 'text-green-700', 'border-yellow-300', 'bg-yellow-100', 'text-yellow-700');
                
                if (index === currentQuestion) {
                    btn.classList.add('border-primaryGreen', 'bg-primaryGreen', 'text-white');
                } else if (answeredQuestions.has(index)) {
                    btn.classList.add('border-green-300', 'bg-green-100', 'text-green-700');
                } else {
                    btn.classList.add('border-gray-300', 'text-gray-600');
                }
            });
            
            // Update action buttons
            const prevBtn = document.querySelector('button[onclick="previousQuestion()"]');
            const nextBtn = document.querySelector('button[onclick="nextQuestion()"]');
            const reviewBtn = document.querySelector('button[onclick="showReviewModal()"]');
            
            if (prevBtn) prevBtn.style.display = currentQuestion > 0 ? 'block' : 'none';
            if (nextBtn) nextBtn.style.display = currentQuestion < totalQuestions - 1 ? 'block' : 'none';
            if (reviewBtn) reviewBtn.style.display = currentQuestion === totalQuestions - 1 ? 'block' : 'none';
        }
        
        function markQuestionAnswered(questionIndex) {
            answeredQuestions.add(questionIndex);
            skippedQuestions.delete(questionIndex);
            updateQuestionStatus(questionIndex, 'answered');
            updateProgress();
        }
        
        function updateQuestionStatus(questionIndex, status) {
            // Update desktop buttons
            const btn = document.querySelector(`#question-grid [data-question="${questionIndex}"]`);
            if (btn) {
                btn.classList.remove('border-primaryGreen', 'bg-primaryGreen', 'text-white', 'border-green-300', 'bg-green-100', 'text-green-700', 'border-yellow-300', 'bg-yellow-100', 'text-yellow-700');
                
                if (status === 'answered') {
                    btn.classList.add('border-green-300', 'bg-green-100', 'text-green-700');
                } else if (status === 'skipped') {
                    btn.classList.add('border-yellow-300', 'bg-yellow-100', 'text-yellow-700');
                }
            }
            
            // Update mobile buttons
            const mobileBtn = document.querySelector(`#question-grid-mobile [data-question="${questionIndex}"]`);
            if (mobileBtn) {
                mobileBtn.classList.remove('border-primaryGreen', 'bg-primaryGreen', 'text-white', 'border-green-300', 'bg-green-100', 'text-green-700', 'border-yellow-300', 'bg-yellow-100', 'text-yellow-700');
                
                if (status === 'answered') {
                    mobileBtn.classList.add('border-green-300', 'bg-green-100', 'text-green-700');
                } else if (status === 'skipped') {
                    mobileBtn.classList.add('border-yellow-300', 'bg-yellow-100', 'text-yellow-700');
                }
            }
        }
        
        function updateProgress() {
            const progress = (answeredQuestions.size / totalQuestions) * 100;
            
            // Update desktop progress
            const progressBar = document.getElementById('progress-bar');
            const progressText = document.getElementById('progress-text');
            if (progressBar && progressText) {
                progressBar.style.width = progress + '%';
                progressText.textContent = `${answeredQuestions.size}/${totalQuestions}`;
            }
            
            // Update mobile progress
            const progressBarMobile = document.getElementById('progress-bar-mobile');
            const progressTextMobile = document.getElementById('progress-text-mobile');
            if (progressBarMobile && progressTextMobile) {
                progressBarMobile.style.width = progress + '%';
                progressTextMobile.textContent = `${answeredQuestions.size}/${totalQuestions}`;
            }
        }
        
        // Review modal functions
        function showReviewModal() {
            populateReviewContent();
            document.getElementById('review-modal').classList.remove('hidden');
        }
        
        function hideReviewModal() {
            document.getElementById('review-modal').classList.add('hidden');
        }
        
        function populateReviewContent() {
            const reviewContent = document.getElementById('review-content');
            let content = '';
            
            for (let i = 0; i < totalQuestions; i++) {
                const question = document.querySelector(`#question-${i}`);
                const questionText = question.querySelector('p').textContent;
                const status = answeredQuestions.has(i) ? 'Answered' : (skippedQuestions.has(i) ? 'Skipped' : 'Unanswered');
                const statusClass = answeredQuestions.has(i) ? 'text-green-600' : (skippedQuestions.has(i) ? 'text-yellow-600' : 'text-gray-500');
                
                content += `
                    <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                        <div class="flex-1 min-w-0">
                            <p class="font-medium text-gray-900 text-sm">Question ${i + 1}</p>
                            <p class="text-xs text-gray-600 truncate">${questionText}</p>
                        </div>
                        <span class="px-2 sm:px-3 py-1 rounded-full text-xs font-medium ${statusClass} flex-shrink-0 ml-2">
                            ${status}
                        </span>
                    </div>
                `;
            }
            
            reviewContent.innerHTML = content;
            
            // Update counts
            document.getElementById('answered-count').textContent = answeredQuestions.size;
            document.getElementById('skipped-count').textContent = skippedQuestions.size;
        }
        
        function submitQuiz() {
            const confirmed = confirm('Are you sure you want to submit your quiz? You cannot change your answers after submission.');
            if (confirmed) {
                document.getElementById('quiz-form').submit();
            }
        }
        
        // Timer functionality
        function updateTimer() {
            if (timeRemaining <= 0) {
                clearInterval(timerInterval);
                showAutoSubmitModal();
                return;
            }
            
            const minutes = Math.floor(timeRemaining / 60);
            const seconds = timeRemaining % 60;
            const timeString = `${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`;
            
            document.getElementById('timer').textContent = timeString;
            
            // Update progress circle
            const percentage = (timeRemaining / totalTime) * 100;
            const circumference = 2 * Math.PI * 15.9155;
            const offset = circumference - (percentage / 100) * circumference;
            
            document.getElementById('timer-circle').style.strokeDashoffset = offset;
            document.getElementById('timer-percentage').textContent = Math.round(percentage) + '%';
            
            // Change color based on time remaining
            if (timeRemaining <= 300) { // 5 minutes
                document.getElementById('timer-circle').classList.remove('text-primaryGreen', 'text-yellow-500');
                document.getElementById('timer-circle').classList.add('text-red-500');
                document.getElementById('timer').classList.add('text-red-600', 'timer-warning');
            } else if (timeRemaining <= 600) { // 10 minutes
                document.getElementById('timer-circle').classList.remove('text-primaryGreen');
                document.getElementById('timer-circle').classList.add('text-yellow-500');
                document.getElementById('timer').classList.add('text-yellow-600');
            }
            
            timeRemaining--;
        }
        
        function showAutoSubmitModal() {
            document.getElementById('auto-submit-modal').classList.remove('hidden');
        }
        
        function autoSubmit() {
            document.getElementById('quiz-form').submit();
        }
        
        // Word count for descriptive questions
        function updateWordCount(questionId, value) {
            const wordCount = value.trim().split(/\s+/).filter(word => word.length > 0).length;
            document.getElementById(`word-count-${questionId}`).textContent = `${wordCount} words`;
        }
        
        // Initialize
        document.addEventListener('DOMContentLoaded', function() {
            // Start timer
            timerInterval = setInterval(updateTimer, 1000);
            updateTimer();
            
            // Auto-submit button
            document.getElementById('auto-submit-btn').addEventListener('click', autoSubmit);
            
            // Initialize progress
            updateProgress();
            updateNavigationButtons();
            
            // Word count for existing textareas
            document.querySelectorAll('textarea').forEach(textarea => {
                const questionId = textarea.id.replace('answer_', '');
                if (textarea.value) {
                    updateWordCount(questionId, textarea.value);
                }
            });
            
            // Warn before leaving page
            window.addEventListener('beforeunload', function(e) {
                if (timeRemaining > 0) {
                    e.preventDefault();
                    e.returnValue = 'Are you sure you want to leave? Your quiz progress will be lost.';
                }
            });
        });
    </script>
</body>
</html>
