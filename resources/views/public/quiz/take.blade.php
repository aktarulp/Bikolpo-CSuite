<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Taking Quiz - {{ $exam->title }}</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-gray-50">
    <!-- Header with Timer -->
    <div class="bg-white shadow-sm border-b border-gray-200 sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center py-4">
                <div class="flex items-center">
                    <div class="w-10 h-10 bg-gradient-to-br from-primaryGreen to-emerald-500 rounded-lg flex items-center justify-center mr-3">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                        </svg>
                    </div>
                    <div>
                        <h1 class="text-lg font-semibold text-gray-900">{{ $exam->title }}</h1>
                        <p class="text-sm text-gray-600">Question {{ $result->total_questions - $questions->count() + 1 }} of {{ $result->total_questions }}</p>
                    </div>
                </div>
                
                <!-- Timer -->
                <div class="flex items-center space-x-4">
                    <div class="text-center">
                        <div class="text-2xl font-bold text-gray-900" id="timer">--:--</div>
                        <div class="text-xs text-gray-500">Time Remaining</div>
                    </div>
                    <div class="w-16 h-16 relative">
                        <svg class="w-16 h-16 transform -rotate-90" viewBox="0 0 36 36">
                            <path class="text-gray-200" stroke="currentColor" stroke-width="2" fill="none" d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831"/>
                            <path class="text-primaryGreen" stroke="currentColor" stroke-width="2" fill="none" stroke-dasharray="100, 100" stroke-dashoffset="0" d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831" id="timer-circle"/>
                        </svg>
                        <div class="absolute inset-0 flex items-center justify-center">
                            <span class="text-sm font-medium text-gray-700" id="timer-percentage">100%</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <form id="quiz-form" method="POST" action="{{ route('public.quiz.submit', $exam->id) }}" class="space-y-8">
            @csrf
            
            @foreach($questions as $index => $question)
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 question-container" data-question="{{ $question->id }}">
                <div class="flex items-start justify-between mb-4">
                    <h3 class="text-lg font-medium text-gray-900">
                        Question {{ $index + 1 }}
                        @if($question->pivot && $question->pivot->marks)
                            <span class="text-sm text-gray-500 ml-2">({{ $question->pivot->marks }} marks)</span>
                        @endif
                    </h3>
                    
                    <!-- Question Type Badge -->
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                        {{ $question->question_type === 'mcq' ? 'bg-blue-100 text-blue-800' : 'bg-purple-100 text-purple-800' }}">
                        {{ strtoupper($question->question_type) }}
                    </span>
                </div>

                <!-- Question Text -->
                <div class="mb-6">
                    <p class="text-gray-700 text-base leading-relaxed">{{ $question->question_text }}</p>
                </div>

                <!-- Question Image (if any) -->
                @if($question->image)
                <div class="mb-6">
                    <img src="{{ asset('storage/' . $question->image) }}" alt="Question Image" class="max-w-full h-auto rounded-lg border border-gray-200">
                </div>
                @endif

                <!-- MCQ Options -->
                @if($question->question_type === 'mcq')
                <div class="space-y-3">
                    @foreach(['a', 'b', 'c', 'd'] as $option)
                        @if($question->{'option_' . $option})
                        <label class="flex items-center p-3 border border-gray-200 rounded-lg cursor-pointer hover:bg-gray-50 transition-colors">
                            <input type="radio" 
                                   name="answers[{{ $question->id }}]" 
                                   value="{{ $option }}"
                                   class="h-4 w-4 text-primaryGreen focus:ring-primaryGreen border-gray-300">
                            <span class="ml-3 text-gray-700">{{ strtoupper($option) }}. {{ $question->{'option_' . $option} }}</span>
                        </label>
                        @endif
                    @endforeach
                </div>
                @endif

                <!-- Descriptive Answer -->
                @if($question->question_type === 'descriptive')
                <div class="space-y-3">
                    <div>
                        <label for="answer_{{ $question->id }}" class="block text-sm font-medium text-gray-700 mb-2">
                            Your Answer
                            @if($question->min_words || $question->max_words)
                                <span class="text-sm text-gray-500 ml-2">
                                    ({{ $question->min_words ?? 0 }}-{{ $question->max_words ?? 'unlimited' }} words)
                                </span>
                            @endif
                        </label>
                        <textarea id="answer_{{ $question->id }}"
                                  name="answers[{{ $question->id }}]"
                                  rows="4"
                                  class="block w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-primaryGreen focus:border-primaryGreen transition-colors"
                                  placeholder="Type your answer here..."></textarea>
                        <div class="flex justify-between items-center mt-2">
                            <span class="text-sm text-gray-500" id="word-count-{{ $question->id }}">0 words</span>
                            @if($question->min_words)
                                <span class="text-sm text-gray-500">Minimum: {{ $question->min_words }} words</span>
                            @endif
                        </div>
                    </div>
                </div>
                @endif
            </div>
            @endforeach

            <!-- Submit Section -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <div class="flex items-center justify-between">
                    <div class="text-sm text-gray-600">
                        <p>Make sure you have answered all questions before submitting.</p>
                        <p class="mt-1">You cannot change your answers after submission.</p>
                    </div>
                    
                    <button type="submit" 
                            id="submit-btn"
                            class="px-8 py-3 bg-gradient-to-r from-primaryGreen to-emerald-600 text-white font-medium rounded-lg hover:from-primaryGreen/90 hover:to-emerald-600/90 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primaryGreen transition-all duration-200 transform hover:scale-105">
                        <svg class="w-5 h-5 mr-2 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        Submit Quiz
                    </button>
                </div>
            </div>
        </form>
    </div>

    <!-- Auto-submit Modal -->
    <div id="auto-submit-modal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
            <div class="mt-3 text-center">
                <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-red-100">
                    <svg class="h-6 w-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <h3 class="text-lg font-medium text-gray-900 mt-4">Time's Up!</h3>
                <div class="mt-2 px-7">
                    <p class="text-sm text-gray-500">Your quiz time has expired. The quiz will be submitted automatically.</p>
                </div>
                <div class="items-center px-4 py-3">
                    <button id="auto-submit-btn" class="px-4 py-2 bg-red-600 text-white text-base font-medium rounded-md w-full shadow-sm hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-300">
                        Submit Now
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Timer functionality
        let timeRemaining = {{ $remainingTime }};
        const totalTime = {{ $exam->duration * 60 }};
        let timerInterval;
        
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
            const circumference = 2 * Math.PI * 15.9155; // 2πr where r = 15.9155
            const offset = circumference - (percentage / 100) * circumference;
            
            document.getElementById('timer-circle').style.strokeDashoffset = offset;
            document.getElementById('timer-percentage').textContent = Math.round(percentage) + '%';
            
            // Change color based on time remaining
            if (timeRemaining <= 300) { // 5 minutes
                document.getElementById('timer-circle').classList.remove('text-primaryGreen');
                document.getElementById('timer-circle').classList.add('text-red-500');
                document.getElementById('timer').classList.add('text-red-600');
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
        document.querySelectorAll('textarea').forEach(textarea => {
            textarea.addEventListener('input', function() {
                const questionId = this.id.replace('answer_', '');
                const wordCount = this.value.trim().split(/\s+/).filter(word => word.length > 0).length;
                document.getElementById(`word-count-${questionId}`).textContent = `${wordCount} words`;
            });
        });
        
        // Start timer
        timerInterval = setInterval(updateTimer, 1000);
        updateTimer();
        
        // Auto-submit button
        document.getElementById('auto-submit-btn').addEventListener('click', autoSubmit);
        
        // Form submission confirmation
        document.getElementById('quiz-form').addEventListener('submit', function(e) {
            if (timeRemaining > 0) {
                const confirmed = confirm('Are you sure you want to submit your quiz? You cannot change your answers after submission.');
                if (!confirmed) {
                    e.preventDefault();
                }
            }
        });
        
        // Prevent form submission on Enter key in textareas
        document.querySelectorAll('textarea').forEach(textarea => {
            textarea.addEventListener('keydown', function(e) {
                if (e.key === 'Enter' && e.ctrlKey) {
                    e.preventDefault();
                    this.form.submit();
                }
            });
        });
        
        // Warn before leaving page
        window.addEventListener('beforeunload', function(e) {
            if (timeRemaining > 0) {
                e.preventDefault();
                e.returnValue = 'Are you sure you want to leave? Your quiz progress will be lost.';
            }
        });
    </script>
</body>
</html>
