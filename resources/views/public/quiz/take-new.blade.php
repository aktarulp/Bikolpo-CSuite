<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $exam->title }} - Quiz</title>
    
    
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
</head>
<body class="antialiased">
    <!-- Header -->
    <header class="sticky top-0 z-50 glass-effect border-b border-white/20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between py-4">
                <!-- Logo & Title -->
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 bg-gradient-to-br from-blue-500 to-purple-600 rounded-xl flex items-center justify-center shadow-lg">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div>
                        <h1 class="text-lg font-bold text-white">{{ $exam->title }}</h1>
                        <p class="text-sm text-white/80">Professional Assessment</p>
                    </div>
                </div>
                
                <!-- Timer & Progress -->
                <div class="flex items-center space-x-6">
                    <!-- Progress -->
                    <div class="hidden sm:block text-center">
                        <div class="text-sm text-white/80 mb-1">Progress</div>
                        <div class="text-lg font-bold text-white" id="progress-text">0/{{ $questions->count() }}</div>
                        <div class="w-24 h-2 bg-white/20 rounded-full overflow-hidden">
                            <div class="h-full bg-gradient-to-r from-green-400 to-blue-500 rounded-full transition-all duration-300" id="progress-bar" style="width: 0%"></div>
                        </div>
                    </div>
                    
                    <!-- Timer -->
                    <div class="text-center">
                        <div class="text-2xl font-bold text-white" id="timer">--:--</div>
                        <div class="text-sm text-white/80">Time Left</div>
                    </div>
                    
                    <!-- Timer Circle -->
                    <div class="relative w-12 h-12">
                        <svg class="w-12 h-12 transform -rotate-90" viewBox="0 0 100 100">
                            <circle cx="50" cy="50" r="45" fill="none" stroke="rgba(255,255,255,0.2)" stroke-width="4"/>
                            <circle cx="50" cy="50" r="45" fill="none" stroke="white" stroke-width="4" 
                                    class="timer-circle" id="timer-circle" stroke-linecap="round"/>
                        </svg>
                        <div class="absolute inset-0 flex items-center justify-center">
                            <span class="text-xs font-medium text-white" id="timer-percentage">100%</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="flex gap-8">
            <!-- Question Area -->
            <div class="flex-1">
                <form id="quiz-form" method="POST" action="{{ route('public.quiz.submit', $exam->id) }}">
                    @csrf
                    
                    @foreach($questions as $index => $question)
                    <div class="question-card p-8 mb-8 {{ $index === 0 ? 'fade-in' : 'hidden' }}" 
                         id="question-{{ $index }}" data-question="{{ $index }}">
                        
                        <!-- Question Header -->
                        <div class="flex items-start justify-between mb-6">
                            <div class="flex items-center space-x-4">
                                <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-purple-600 rounded-xl flex items-center justify-center text-white font-bold text-lg shadow-lg">
                                    {{ $index + 1 }}
                                </div>
                                <div>
                                    <h2 class="text-xl font-bold text-gray-900">Question {{ $index + 1 }} of {{ $questions->count() }}</h2>
                                    @if($question->pivot && $question->pivot->marks)
                                        <p class="text-sm text-gray-600">Worth {{ $question->pivot->marks }} marks</p>
                                    @endif
                                </div>
                            </div>
                            
                            <!-- Question Type Badge -->
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium 
                                       {{ $question->question_type === 'mcq' ? 'bg-blue-100 text-blue-800' : 'bg-purple-100 text-purple-800' }}">
                                {{ strtoupper($question->question_type) }}
                            </span>
                        </div>

                        <!-- Question Text -->
                        <div class="mb-8">
                            <p class="text-lg text-gray-800 leading-relaxed">{{ $question->question_text }}</p>
                        </div>

                        <!-- Question Image -->
                        @if($question->image)
                        <div class="mb-8 text-center">
                            <img src="{{ asset('storage/' . $question->image) }}" 
                                 alt="Question Image" 
                                 class="max-w-full h-auto rounded-lg border border-gray-200 shadow-md">
                        </div>
                        @endif

                        <!-- MCQ Options -->
                        @if($question->question_type === 'mcq')
                        <div class="space-y-4 mb-8">
                            @foreach(['a', 'b', 'c', 'd'] as $option)
                                @if($question->{'option_' . $option})
                                <label class="option-card block p-4">
                                    <input type="radio" 
                                           name="answers[{{ $question->id }}]" 
                                           value="{{ $option }}"
                                           class="sr-only"
                                           onchange="markQuestionAnswered({{ $index }})">
                                    <div class="option-content flex items-center space-x-4">
                                        <div class="w-8 h-8 bg-gray-100 rounded-lg flex items-center justify-center text-sm font-bold text-gray-600">
                                            @if($exam->question_language === 'bangla')
                                                @switch($option)
                                                    @case('a')
                                                        {{ $exam->ba ?? 'ক' }}
                                                        @break
                                                    @case('b')
                                                        {{ $exam->bb ?? 'খ' }}
                                                        @break
                                                    @case('c')
                                                        {{ $exam->bc ?? 'গ' }}
                                                        @break
                                                    @case('d')
                                                        {{ $exam->bd ?? 'ঘ' }}
                                                        @break
                                                @endswitch
                                            @else
                                                {{ strtoupper($option) }}
                                            @endif
                                        </div>
                                        <span class="text-gray-700 flex-1">{{ $question->{'option_' . $option} }}</span>
                                    </div>
                                </label>
                                @endif
                            @endforeach
                        </div>
                        @endif

                        <!-- Descriptive Answer -->
                        @if($question->question_type === 'descriptive')
                        <div class="space-y-4 mb-8">
                            <div>
                                <label for="answer_{{ $question->id }}" class="block text-lg font-medium text-gray-700 mb-3">
                                    Your Answer
                                    @if($question->min_words || $question->max_words)
                                        <span class="text-sm text-gray-500 ml-2">
                                            ({{ $question->min_words ?? 0 }}-{{ $question->max_words ?? 'unlimited' }} words)
                                        </span>
                                    @endif
                                </label>
                                <textarea id="answer_{{ $question->id }}"
                                          name="answers[{{ $question->id }}]"
                                          rows="6"
                                          class="block w-full border-2 border-gray-300 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 resize-none"
                                          placeholder="Type your detailed answer here..."
                                          oninput="updateWordCount({{ $question->id }}, this.value); markQuestionAnswered({{ $index }})"></textarea>
                                <div class="flex justify-between items-center mt-2">
                                    <span class="text-sm text-gray-500" id="word-count-{{ $question->id }}">0 words</span>
                                    @if($question->min_words)
                                        <span class="text-sm text-gray-500">Minimum: {{ $question->min_words }} words</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        @endif

                        <!-- Navigation -->
                        <div class="flex items-center justify-between pt-6 border-t border-gray-200">
                            <div class="flex space-x-3">
                                @if($index > 0)
                                <button type="button" 
                                        onclick="navigateToQuestion({{ $index - 1 }})"
                                        class="px-6 py-3 border-2 border-gray-300 text-gray-700 font-medium rounded-lg hover:bg-gray-50 hover:border-gray-400 transition-all duration-200 flex items-center space-x-2">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                                    </svg>
                                    <span>Previous</span>
                                </button>
                                @endif
                                
                                <button type="button" 
                                        onclick="skipQuestion({{ $index }})"
                                        class="px-6 py-3 border-2 border-yellow-300 text-yellow-700 font-medium rounded-lg hover:bg-yellow-50 hover:border-yellow-400 transition-all duration-200 flex items-center space-x-2">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 17l5-5-5-5"></path>
                                    </svg>
                                    <span>Skip</span>
                                </button>
                            </div>
                            
                            <div class="flex space-x-3">
                                @if($index < $questions->count() - 1)
                                <button type="button" 
                                        onclick="navigateToQuestion({{ $index + 1 }})"
                                        class="px-6 py-3 bg-gradient-to-r from-blue-500 to-purple-600 text-white font-medium rounded-lg hover:from-blue-600 hover:to-purple-700 transition-all duration-200 flex items-center space-x-2">
                                    <span>Next</span>
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                    </svg>
                                </button>
                                @else
                                <button type="button" 
                                        onclick="showReviewModal()"
                                        class="px-6 py-3 bg-gradient-to-r from-green-500 to-emerald-600 text-white font-medium rounded-lg hover:from-green-600 hover:to-emerald-700 transition-all duration-200 flex items-center space-x-2">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    <span>Review & Submit</span>
                                </button>
                                @endif
                            </div>
                        </div>
                    </div>
                    @endforeach
                </form>
            </div>

            <!-- Question Navigator -->
            <div class="w-80 bg-white rounded-2xl shadow-xl border border-gray-200 h-fit sticky top-24">
                <div class="p-6 border-b border-gray-200">
                    <h3 class="text-lg font-bold text-gray-900 flex items-center space-x-2">
                        <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                        </svg>
                        <span>Question Navigator</span>
                    </h3>
                </div>
                
                <!-- Legend -->
                <div class="px-6 py-4 border-b border-gray-200">
                    <div class="grid grid-cols-2 gap-3 text-xs">
                        <div class="flex items-center space-x-2">
                            <div class="w-3 h-3 rounded-full bg-blue-500"></div>
                            <span class="text-gray-600">Current</span>
                        </div>
                        <div class="flex items-center space-x-2">
                            <div class="w-3 h-3 rounded-full bg-green-500"></div>
                            <span class="text-gray-600">Answered</span>
                        </div>
                        <div class="flex items-center space-x-2">
                            <div class="w-3 h-3 rounded-full bg-yellow-500"></div>
                            <span class="text-gray-600">Skipped</span>
                        </div>
                        <div class="flex items-center space-x-2">
                            <div class="w-3 h-3 rounded-full bg-gray-300"></div>
                            <span class="text-gray-600">Unanswered</span>
                        </div>
                    </div>
                </div>
                
                <!-- Question Grid -->
                <div class="p-6">
                    <div class="question-nav-grid grid grid-cols-8 gap-2 mb-6">
                        @foreach($questions as $index => $question)
                        <button type="button" 
                                class="question-nav-btn {{ $index === 0 ? 'current' : 'unanswered' }}"
                                onclick="navigateToQuestion({{ $index }})"
                                data-question="{{ $index }}">
                            {{ $index + 1 }}
                        </button>
                        @endforeach
                    </div>
                    
                    <!-- Progress Summary -->
                    <div class="bg-gray-50 rounded-xl p-4">
                        <h4 class="text-sm font-semibold text-gray-900 mb-3">Progress Summary</h4>
                        <div class="space-y-2 text-sm">
                            <div class="flex justify-between">
                                <span class="text-gray-600">Total:</span>
                                <span class="font-medium text-gray-900">{{ $questions->count() }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Answered:</span>
                                <span class="font-medium text-green-600" id="answered-count">0</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Skipped:</span>
                                <span class="font-medium text-yellow-600" id="skipped-count">0</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Remaining:</span>
                                <span class="font-medium text-gray-900" id="remaining-count">{{ $questions->count() }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- Review Modal -->
    <div id="review-modal" class="fixed inset-0 bg-black/50 backdrop-blur-sm hidden z-50">
        <div class="min-h-screen flex items-center justify-center p-4">
            <div class="bg-white rounded-2xl shadow-2xl max-w-2xl w-full max-h-[90vh] overflow-hidden">
                <div class="p-6 border-b border-gray-200">
                    <div class="flex items-center justify-between">
                        <h3 class="text-2xl font-bold text-gray-900">Review Your Answers</h3>
                        <button onclick="hideReviewModal()" class="text-gray-400 hover:text-gray-600">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>
                </div>
                
                <div class="p-6 max-h-96 overflow-y-auto">
                    <div id="review-content" class="space-y-3">
                        <!-- Review content will be populated here -->
                    </div>
                </div>
                
                <div class="p-6 border-t border-gray-200 bg-gray-50">
                    <div class="flex items-center justify-between mb-4">
                        <div class="text-sm text-gray-600">
                            <p>Total: <span class="font-semibold text-gray-900">{{ $questions->count() }}</span></p>
                            <p>Answered: <span class="font-semibold text-green-600" id="modal-answered-count">0</span></p>
                            <p>Skipped: <span class="font-semibold text-yellow-600" id="modal-skipped-count">0</span></p>
                        </div>
                        
                        <div class="flex space-x-3">
                            <button onclick="hideReviewModal()" 
                                    class="px-6 py-3 border-2 border-gray-300 text-gray-700 font-medium rounded-lg hover:bg-gray-50 transition-all duration-200">
                                Continue Quiz
                            </button>
                            <button onclick="submitQuiz()" 
                                    class="px-8 py-3 bg-gradient-to-r from-green-500 to-emerald-600 text-white font-medium rounded-lg hover:from-green-600 hover:to-emerald-700 transition-all duration-200">
                                Submit Quiz
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Auto-submit Modal -->
    <div id="auto-submit-modal" class="fixed inset-0 bg-black/50 backdrop-blur-sm hidden z-50">
        <div class="min-h-screen flex items-center justify-center p-4">
            <div class="bg-white rounded-2xl shadow-2xl max-w-md w-full text-center p-8">
                <div class="w-16 h-16 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-2">Time's Up!</h3>
                <p class="text-gray-600 mb-6">The exam time has ended. Your quiz will be submitted automatically.</p>
                <button id="auto-submit-btn" 
                        class="w-full px-6 py-3 bg-red-600 text-white font-medium rounded-lg hover:bg-red-700 transition-all duration-200">
                    Submit Now
                </button>
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
        let timerInterval;
        
        // Initialize timer
        if (timeRemaining <= 0) {
            timeRemaining = 0;
        }
        
        // Navigation functions
        function navigateToQuestion(questionIndex) {
            if (questionIndex < 0 || questionIndex >= totalQuestions) return;
            
            // Hide current question
            document.querySelectorAll('.question-card').forEach(q => q.classList.add('hidden'));
            
            // Show target question
            document.getElementById(`question-${questionIndex}`).classList.remove('hidden');
            document.getElementById(`question-${questionIndex}`).classList.add('fade-in');
            
            // Update current question
            currentQuestion = questionIndex;
            
            // Update navigation
            updateNavigationButtons();
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
        
        function skipQuestion(questionIndex) {
            skippedQuestions.add(questionIndex);
            updateQuestionStatus(questionIndex, 'skipped');
            
            if (questionIndex < totalQuestions - 1) {
                navigateToQuestion(questionIndex + 1);
            } else {
                showReviewModal();
            }
        }
        
        function markQuestionAnswered(questionIndex) {
            answeredQuestions.add(questionIndex);
            updateQuestionStatus(questionIndex, 'answered');
            updateProgress();
        }
        
        function updateQuestionStatus(questionIndex, status) {
            const btn = document.querySelector(`[data-question="${questionIndex}"]`);
            btn.className = `question-nav-btn ${status}`;
        }
        
        function updateProgress() {
            const progress = (answeredQuestions.size / totalQuestions) * 100;
            document.getElementById('progress-bar').style.width = `${progress}%`;
            document.getElementById('progress-text').textContent = `${answeredQuestions.size}/${totalQuestions}`;
            
            // Update counts
            document.getElementById('answered-count').textContent = answeredQuestions.size;
            document.getElementById('skipped-count').textContent = skippedQuestions.size;
            document.getElementById('remaining-count').textContent = totalQuestions - answeredQuestions.size - skippedQuestions.size;
        }
        
        function updateNavigationButtons() {
            document.querySelectorAll('.question-nav-btn').forEach((btn, index) => {
                btn.classList.remove('current');
                if (index === currentQuestion) {
                    btn.classList.add('current');
                }
            });
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
                        <span class="px-3 py-1 rounded-full text-xs font-medium ${statusClass} flex-shrink-0 ml-2">
                            ${status}
                        </span>
                    </div>
                `;
            }
            
            reviewContent.innerHTML = content;
            
            // Update modal counts
            document.getElementById('modal-answered-count').textContent = answeredQuestions.size;
            document.getElementById('modal-skipped-count').textContent = skippedQuestions.size;
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
            if (typeof window.initialTimeRemaining === 'undefined') {
                window.initialTimeRemaining = timeRemaining;
            }
            const percentage = (timeRemaining / window.initialTimeRemaining) * 100;
            const circumference = 283;
            const offset = circumference - (percentage / 100) * circumference;
            
            document.getElementById('timer-circle').style.strokeDashoffset = offset;
            document.getElementById('timer-percentage').textContent = Math.round(percentage) + '%';
            
            // Change color based on time remaining
            if (timeRemaining <= 300) { // 5 minutes
                document.getElementById('timer').classList.add('text-red-400');
            } else if (timeRemaining <= 600) { // 10 minutes
                document.getElementById('timer').classList.add('text-yellow-400');
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
