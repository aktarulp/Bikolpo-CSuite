@extends('layouts.app')

@section('title', 'Taking Exam - ' . $exam->title)

@section('content')
<div class="min-h-screen bg-gradient-to-br from-blue-50 via-indigo-50 to-purple-50 py-8">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Exam Header -->
        <div class="bg-white rounded-2xl shadow-xl p-6 mb-8">
            <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center gap-4">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900 mb-2">{{ $exam->title }}</h1>
                    <p class="text-gray-600">{{ $exam->description ?? 'Online Examination' }}</p>
                </div>
                
                <!-- Timer and Progress -->
                <div class="flex flex-col items-center lg:items-end gap-4">
                    <div class="text-center">
                        <div class="text-2xl font-bold text-primaryGreen" id="timer">--:--</div>
                        <div class="text-sm text-gray-600">Time Remaining</div>
                    </div>
                    
                    <div class="text-center">
                        <div class="text-lg font-semibold text-gray-900">
                            <span id="currentQuestion">1</span> / <span id="totalQuestions">{{ $result->total_questions }}</span>
                        </div>
                        <div class="text-sm text-gray-600">Questions</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Exam Instructions -->
        <div class="bg-yellow-50 border border-yellow-200 rounded-xl p-6 mb-8">
            <h3 class="text-lg font-semibold text-yellow-800 mb-3 flex items-center">
                <svg class="w-6 h-6 text-yellow-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.34 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                </svg>
                Important Instructions
            </h3>
            <ul class="space-y-2 text-yellow-700">
                <li class="flex items-start">
                    <span class="inline-block w-2 h-2 bg-yellow-500 rounded-full mt-2 mr-3 flex-shrink-0"></span>
                    <span>Read each question carefully before answering</span>
                </li>
                <li class="flex items-start">
                    <span class="inline-block w-2 h-2 bg-yellow-500 rounded-full mt-2 mr-3 flex-shrink-0"></span>
                    <span>You can review and change your answers before submitting</span>
                </li>
                @if($exam->has_negative_marking)
                <li class="flex items-start">
                    <span class="inline-block w-2 h-2 bg-red-500 rounded-full mt-2 mr-3 flex-shrink-0"></span>
                    <span><strong>Warning:</strong> This exam has negative marking. Each wrong answer deducts {{ $exam->negative_marks_per_question }} marks</span>
                </li>
                @endif
                <li class="flex items-start">
                    <span class="inline-block w-2 h-2 bg-yellow-500 rounded-full mt-2 mr-3 flex-shrink-0"></span>
                    <span>Ensure you have a stable internet connection</span>
                </li>
                <li class="flex items-start">
                    <span class="inline-block w-2 h-2 bg-yellow-500 rounded-full mt-2 mr-3 flex-shrink-0"></span>
                    <span>Do not refresh the page or navigate away during the exam</span>
                </li>
            </ul>
        </div>

        <!-- Exam Form -->
        <form id="examForm" action="{{ route('student.exams.submit', $exam) }}" method="POST" class="space-y-8">
            @csrf
            
            <!-- Questions Container -->
            <div id="questionsContainer" class="space-y-8">
                @if($questions->count() > 0)
                    @foreach($questions as $index => $question)
                        <div class="bg-white rounded-xl shadow-lg p-6 question-card" data-question="{{ $index + 1 }}">
                            <div class="flex items-start justify-between mb-4">
                                <h3 class="text-lg font-semibold text-gray-900">
                                    Question {{ $index + 1 }}
                                </h3>
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800">
                                    {{ $question->marks ?? 1 }} mark{{ ($question->marks ?? 1) > 1 ? 's' : '' }}
                                </span>
                            </div>
                            
                            <div class="mb-6">
                                <p class="text-gray-700 text-lg leading-relaxed">{{ $question->question_text }}</p>
                            </div>

                            @if($question->question_type === 'mcq')
                                <div class="space-y-3">
                                    @foreach(['A', 'B', 'C', 'D'] as $option)
                                        @if($question->{'option_' . strtolower($option)})
                                            <label class="flex items-center p-3 border border-gray-200 rounded-lg hover:bg-gray-50 cursor-pointer transition-colors duration-200">
                                                <input type="radio" 
                                                       name="answers[{{ $question->id }}]" 
                                                       value="{{ $option }}" 
                                                       class="w-4 h-4 text-primaryGreen border-gray-300 focus:ring-primaryGreen"
                                                       onchange="updateProgress()">
                                                <span class="ml-3 text-gray-700">{{ $option }}. {{ $question->{'option_' . strtolower($option)} }}</span>
                                            </label>
                                        @endif
                                    @endforeach
                                </div>
                            @elseif($question->question_type === 'descriptive')
                                <div>
                                    <textarea name="answers[{{ $question->id }}]" 
                                              rows="4" 
                                              class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primaryGreen focus:border-transparent"
                                              placeholder="Type your answer here..."
                                              onchange="updateProgress()"></textarea>
                                </div>
                            @endif
                        </div>
                    @endforeach
                @else
                    <!-- Demo Questions for Testing -->
                    <div class="bg-white rounded-xl shadow-lg p-6 question-card" data-question="1">
                        <div class="flex items-start justify-between mb-4">
                            <h3 class="text-lg font-semibold text-gray-900">Question 1</h3>
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800">
                                1 mark
                            </span>
                        </div>
                        
                        <div class="mb-6">
                            <p class="text-gray-700 text-lg leading-relaxed">What is the capital of France?</p>
                        </div>

                        <div class="space-y-3">
                            <label class="flex items-center p-3 border border-gray-200 rounded-lg hover:bg-gray-50 cursor-pointer transition-colors duration-200">
                                <input type="radio" name="answers[1]" value="A" class="w-4 h-4 text-primaryGreen border-gray-300 focus:ring-primaryGreen" onchange="updateProgress()">
                                <span class="ml-3 text-gray-700">A. London</span>
                            </label>
                            <label class="flex items-center p-3 border border-gray-200 rounded-lg hover:bg-gray-50 cursor-pointer transition-colors duration-200">
                                <input type="radio" name="answers[1]" value="B" class="w-4 h-4 text-primaryGreen border-gray-300 focus:ring-primaryGreen" onchange="updateProgress()">
                                <span class="ml-3 text-gray-700">B. Paris</span>
                            </label>
                            <label class="flex items-center p-3 border border-gray-200 rounded-lg hover:bg-gray-50 cursor-pointer transition-colors duration-200">
                                <input type="radio" name="answers[1]" value="C" class="w-4 h-4 text-primaryGreen border-gray-300 focus:ring-primaryGreen" onchange="updateProgress()">
                                <span class="ml-3 text-gray-700">C. Berlin</span>
                            </label>
                            <label class="flex items-center p-3 border border-gray-200 rounded-lg hover:bg-gray-50 cursor-pointer transition-colors duration-200">
                                <input type="radio" name="answers[1]" value="D" class="w-4 h-4 text-primaryGreen border-gray-300 focus:ring-primaryGreen" onchange="updateProgress()">
                                <span class="ml-3 text-gray-700">D. Madrid</span>
                            </label>
                        </div>
                    </div>

                    <div class="bg-white rounded-xl shadow-lg p-6 question-card" data-question="2">
                        <div class="flex items-start justify-between mb-4">
                            <h3 class="text-lg font-semibold text-gray-900">Question 2</h3>
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800">
                                2 marks
                            </span>
                        </div>
                        
                        <div class="mb-6">
                            <p class="text-gray-700 text-lg leading-relaxed">Explain the concept of gravity in your own words.</p>
                        </div>

                        <div>
                            <textarea name="answers[2]" 
                                      rows="4" 
                                      class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primaryGreen focus:border-transparent"
                                      placeholder="Type your answer here..."
                                      onchange="updateProgress()"></textarea>
                        </div>
                    </div>
                @endif
            </div>

            <!-- Progress Bar -->
            <div class="bg-white rounded-xl shadow-lg p-6">
                <div class="mb-4">
                    <div class="flex justify-between items-center mb-2">
                        <span class="text-sm font-medium text-gray-700">Progress</span>
                        <span class="text-sm font-medium text-gray-700"><span id="progressPercent">0</span>%</span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-2">
                        <div id="progressBar" class="bg-primaryGreen h-2 rounded-full transition-all duration-300" style="width: 0%"></div>
                    </div>
                </div>
                
                <div class="text-center text-sm text-gray-600">
                    <span id="answeredCount">0</span> of {{ $result->total_questions }} questions answered
                </div>
            </div>

            <!-- Submit Button -->
            <div class="flex justify-center">
                <button type="submit" 
                        id="submitBtn"
                        class="bg-primaryGreen hover:bg-green-600 text-white font-bold py-4 px-8 rounded-xl shadow-lg hover:shadow-xl transition-all duration-200 transform hover:-translate-y-1 disabled:opacity-50 disabled:cursor-not-allowed disabled:transform-none"
                        onclick="return confirmSubmit()">
                    <svg class="w-6 h-6 mr-2 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    Submit Exam
                </button>
            </div>
        </form>
    </div>
</div>

<script>
let examDuration = {{ $exam->duration * 60 }}; // Convert to seconds
let timeRemaining = examDuration;
let timerInterval;

// Initialize timer
function initTimer() {
    timerInterval = setInterval(() => {
        timeRemaining--;
        updateTimerDisplay();
        
        if (timeRemaining <= 0) {
            clearInterval(timerInterval);
            alert('Time is up! Your exam will be submitted automatically.');
            document.getElementById('examForm').submit();
        }
        
        // Warning when 5 minutes remaining
        if (timeRemaining === 300) {
            alert('Warning: Only 5 minutes remaining!');
        }
    }, 1000);
}

function updateTimerDisplay() {
    const minutes = Math.floor(timeRemaining / 60);
    const seconds = timeRemaining % 60;
    document.getElementById('timer').textContent = 
        `${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`;
}

function updateProgress() {
    const form = document.getElementById('examForm');
    const formData = new FormData(form);
    const answers = formData.getAll('answers[]');
    
    let answeredCount = 0;
    const totalQuestions = {{ $result->total_questions }};
    
    // Count answered questions
    for (let i = 1; i <= totalQuestions; i++) {
        const answer = formData.get(`answers[${i}]`);
        if (answer && answer.trim() !== '') {
            answeredCount++;
        }
    }
    
    const progressPercent = Math.round((answeredCount / totalQuestions) * 100);
    
    document.getElementById('answeredCount').textContent = answeredCount;
    document.getElementById('progressPercent').textContent = progressPercent;
    document.getElementById('progressBar').style.width = progressPercent + '%';
    
    // Update current question display
    if (answeredCount > 0) {
        document.getElementById('currentQuestion').textContent = answeredCount;
    }
}

function confirmSubmit() {
    const answeredCount = parseInt(document.getElementById('answeredCount').textContent);
    const totalQuestions = {{ $result->total_questions }};
    
    if (answeredCount === 0) {
        return confirm('You haven\'t answered any questions. Are you sure you want to submit?');
    }
    
    if (answeredCount < totalQuestions) {
        return confirm(`You have answered ${answeredCount} out of ${totalQuestions} questions. Are you sure you want to submit?`);
    }
    
    return confirm('Are you sure you want to submit your exam? You cannot change your answers after submission.');
}

// Start timer when page loads
document.addEventListener('DOMContentLoaded', function() {
    initTimer();
    updateProgress();
    
    // Prevent form resubmission
    if (window.history.replaceState) {
        window.history.replaceState(null, null, window.location.href);
    }
});

// Prevent accidental navigation
window.addEventListener('beforeunload', function(e) {
    if (timeRemaining > 0) {
        e.preventDefault();
        e.returnValue = 'Are you sure you want to leave? Your exam progress will be lost.';
        return e.returnValue;
    }
});
</script>

<style>
.question-card {
    transition: all 0.3s ease;
}

.question-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
}

input[type="radio"]:checked + span {
    color: #059669;
    font-weight: 600;
}

textarea:focus {
    outline: none;
    border-color: #059669;
    box-shadow: 0 0 0 3px rgba(5, 150, 105, 0.1);
}
</style>
@endsection
