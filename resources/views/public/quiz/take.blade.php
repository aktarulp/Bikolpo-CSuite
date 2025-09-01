<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $exam->title ?? 'Quiz' }} - Online Exam</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <!-- Header -->
    <header class="bg-blue-600 text-white shadow-lg">
        <div class="max-w-7xl mx-auto px-4 py-4">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-xl font-bold">{{ $exam->title ?? 'Online Quiz' }}</h1>
                    <p class="text-sm opacity-90">Professional Assessment</p>
                </div>
                <div class="text-center">
                    <div class="text-2xl font-bold" id="timer">--:--</div>
                    <div class="text-sm opacity-90">Time Left</div>
                </div>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="max-w-6xl mx-auto px-4 py-8">
        <div class="flex flex-col lg:flex-row gap-8">
            <!-- Question Area -->
            <div class="flex-1">
                @if($questions && $questions->count() > 0)
                    <form id="quiz-form" method="POST" action="{{ route('public.quiz.submit', $exam->id ?? 1) }}">
                        @csrf
                        
                        @foreach($questions as $index => $question)
                        <div class="bg-white rounded-lg shadow-md p-6 mb-6 {{ $index === 0 ? '' : 'hidden' }}" 
                             id="question-{{ $index }}" data-question="{{ $index }}">
                            
                            <!-- Question Header -->
                            <div class="flex items-center justify-between mb-4">
                                <div class="flex items-center space-x-3">
                                    <span class="w-10 h-10 bg-blue-500 text-white rounded-full flex items-center justify-center font-bold">
                                        {{ $index + 1 }}
                                    </span>
                                    <div>
                                        <h2 class="text-lg font-bold">Question {{ $index + 1 }} of {{ $questions->count() }}</h2>
                                        <span class="text-sm text-gray-600">{{ strtoupper($question->question_type ?? 'MCQ') }}</span>
                                    </div>
                                </div>
                            </div>

                            <!-- Question Text -->
                            <div class="mb-6">
                                <p class="text-gray-800 text-lg">{{ $question->question_text ?? 'Question text not available' }}</p>
                            </div>

                            <!-- MCQ Options -->
                            @if(($question->question_type ?? 'mcq') === 'mcq')
                            <div class="space-y-3 mb-6">
                                @foreach(['a', 'b', 'c', 'd'] as $option)
                                    @if(isset($question->{'option_' . $option}) && $question->{'option_' . $option})
                                    <label class="block border-2 border-gray-200 rounded-lg p-4 cursor-pointer hover:border-blue-300 transition-colors">
                                        <input type="radio" 
                                               name="answers[{{ $question->id ?? $index }}]" 
                                               value="{{ $option }}"
                                               class="mr-3"
                                               onchange="markQuestionAnswered({{ $index }})">
                                        <span class="font-medium">{{ strtoupper($option) }}.</span>
                                        <span class="ml-2">{{ $question->{'option_' . $option} }}</span>
                                    </label>
                                    @endif
                                @endforeach
                            </div>
                            @endif

                            <!-- Descriptive Answer -->
                            @if(($question->question_type ?? 'mcq') === 'descriptive')
                            <div class="mb-6">
                                <label class="block text-lg font-medium mb-3">Your Answer</label>
                                <textarea name="answers[{{ $question->id ?? $index }}]"
                                          rows="6"
                                          class="w-full border-2 border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                          placeholder="Type your detailed answer here..."
                                          oninput="markQuestionAnswered({{ $index }})"></textarea>
                            </div>
                            @endif

                            <!-- Navigation -->
                            <div class="flex justify-between pt-4 border-t border-gray-200">
                                <div>
                                    @if($index > 0)
                                    <button type="button" 
                                            onclick="navigateToQuestion({{ $index - 1 }})"
                                            class="px-6 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50">
                                        Previous
                                    </button>
                                    @endif
                                </div>
                                
                                <div class="flex space-x-3">
                                    <button type="button" 
                                            onclick="skipQuestion({{ $index }})"
                                            class="px-6 py-2 border border-yellow-300 text-yellow-700 rounded-lg hover:bg-yellow-50">
                                        Skip
                                    </button>
                                    
                                    @if($index < $questions->count() - 1)
                                    <button type="button" 
                                            onclick="navigateToQuestion({{ $index + 1 }})"
                                            class="px-6 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600">
                                        Next
                                    </button>
                                    @else
                                    <button type="button" 
                                            onclick="showReviewModal()"
                                            class="px-6 py-2 bg-green-500 text-white rounded-lg hover:bg-green-600">
                                        Review & Submit
                                    </button>
                                    @endif
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </form>
                @else
                    <div class="bg-white rounded-lg shadow-md p-8 text-center">
                        <h3 class="text-xl font-bold text-gray-900 mb-2">No Questions Available</h3>
                        <p class="text-gray-600 mb-6">This exam doesn't have any questions assigned yet.</p>
                        <a href="{{ route('public.quiz.access') }}" 
                           class="px-6 py-3 bg-blue-600 text-white font-medium rounded-lg hover:bg-blue-700">
                            Return to Access Page
                        </a>
                    </div>
                @endif
            </div>

            <!-- Question Navigator -->
            @if($questions && $questions->count() > 0)
            <div class="w-full lg:w-64 bg-white rounded-lg shadow-md p-6 h-fit">
                <h3 class="text-lg font-bold mb-4">Question Navigator</h3>
                
                <!-- Question Grid -->
                <div class="grid grid-cols-5 gap-2 mb-6">
                    @foreach($questions as $index => $question)
                    <button type="button" 
                            class="w-10 h-10 rounded-lg border-2 {{ $index === 0 ? 'bg-blue-500 text-white border-blue-500' : 'bg-gray-100 text-gray-700 border-gray-300' }}"
                            onclick="navigateToQuestion({{ $index }})"
                            data-question="{{ $index }}">
                        {{ $index + 1 }}
                    </button>
                    @endforeach
                </div>
                
                <!-- Progress Summary -->
                <div class="bg-gray-50 rounded-lg p-4">
                    <h4 class="font-semibold mb-3">Progress</h4>
                    <div class="space-y-2 text-sm">
                        <div class="flex justify-between">
                            <span>Total:</span>
                            <span class="font-medium">{{ $questions->count() }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span>Answered:</span>
                            <span class="font-medium text-green-600" id="answered-count">0</span>
                        </div>
                        <div class="flex justify-between">
                            <span>Skipped:</span>
                            <span class="font-medium text-yellow-600" id="skipped-count">0</span>
                        </div>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </main>

    <!-- Review Modal -->
    <div id="review-modal" class="fixed inset-0 bg-black/50 hidden z-50">
        <div class="min-h-screen flex items-center justify-center p-4">
            <div class="bg-white rounded-lg shadow-xl max-w-2xl w-full">
                <div class="p-6 border-b">
                    <h3 class="text-2xl font-bold">Review Your Answers</h3>
                </div>
                
                <div class="p-6">
                    <div id="review-content"></div>
                </div>
                
                <div class="p-6 border-t bg-gray-50">
                    <div class="flex justify-end space-x-3">
                        <button onclick="hideReviewModal()" 
                                class="px-6 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50">
                            Continue Quiz
                        </button>
                        <button onclick="submitQuiz()" 
                                class="px-6 py-2 bg-green-500 text-white rounded-lg hover:bg-green-600">
                            Submit Quiz
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        let currentQuestion = 0;
        let totalQuestions = {{ $questions->count() ?? 0 }};
        let answeredQuestions = new Set();
        let skippedQuestions = new Set();
        let timeRemaining = {{ $remainingTime ?? 0 }};
        let timerInterval;
        
        function navigateToQuestion(questionIndex) {
            if (questionIndex < 0 || questionIndex >= totalQuestions) return;
            
            document.querySelectorAll('.question-card, [id^="question-"]').forEach(q => q.classList.add('hidden'));
            
            const targetQuestion = document.getElementById(`question-${questionIndex}`);
            if (targetQuestion) {
                targetQuestion.classList.remove('hidden');
            }
            
            currentQuestion = questionIndex;
            updateNavigation();
            updateProgress();
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
            if (btn) {
                btn.className = `w-10 h-10 rounded-lg border-2 ${
                    status === 'answered' ? 'bg-green-500 text-white border-green-500' :
                    status === 'skipped' ? 'bg-yellow-500 text-white border-yellow-500' :
                    questionIndex === currentQuestion ? 'bg-blue-500 text-white border-blue-500' :
                    'bg-gray-100 text-gray-700 border-gray-300'
                }`;
            }
        }
        
        function updateProgress() {
            const answeredCount = document.getElementById('answered-count');
            const skippedCount = document.getElementById('skipped-count');
            
            if (answeredCount) answeredCount.textContent = answeredQuestions.size;
            if (skippedCount) skippedCount.textContent = skippedQuestions.size;
        }
        
        function updateNavigation() {
            document.querySelectorAll('[data-question]').forEach((btn, index) => {
                if (index === currentQuestion) {
                    btn.classList.add('bg-blue-500', 'text-white', 'border-blue-500');
                    btn.classList.remove('bg-gray-100', 'text-gray-700', 'border-gray-300');
                }
            });
        }
        
        function showReviewModal() {
            const modal = document.getElementById('review-modal');
            const content = document.getElementById('review-content');
            
            let html = '';
            for (let i = 0; i < totalQuestions; i++) {
                const status = answeredQuestions.has(i) ? 'Answered' : (skippedQuestions.has(i) ? 'Skipped' : 'Unanswered');
                const color = answeredQuestions.has(i) ? 'text-green-600' : (skippedQuestions.has(i) ? 'text-yellow-600' : 'text-gray-500');
                
                html += `<div class="flex justify-between items-center p-3 bg-gray-50 rounded mb-2">
                    <span>Question ${i + 1}</span>
                    <span class="${color} font-medium">${status}</span>
                </div>`;
            }
            
            content.innerHTML = html;
            modal.classList.remove('hidden');
        }
        
        function hideReviewModal() {
            document.getElementById('review-modal').classList.add('hidden');
        }
        
        function submitQuiz() {
            if (confirm('Are you sure you want to submit your quiz?')) {
                document.getElementById('quiz-form').submit();
            }
        }
        
        function updateTimer() {
            if (timeRemaining <= 0) {
                clearInterval(timerInterval);
                submitQuiz();
                return;
            }
            
            const minutes = Math.floor(timeRemaining / 60);
            const seconds = timeRemaining % 60;
            document.getElementById('timer').textContent = 
                `${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`;
            
            timeRemaining--;
        }
        
        document.addEventListener('DOMContentLoaded', function() {
            if (timeRemaining > 0) {
                timerInterval = setInterval(updateTimer, 1000);
                updateTimer();
            }
            
            updateProgress();
            updateNavigation();
        });
    </script>
</body>
</html>
