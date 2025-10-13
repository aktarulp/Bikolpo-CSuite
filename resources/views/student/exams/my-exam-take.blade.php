@extends('layouts.student-layout')

@section('title', 'Taking Exam - ' . $exam->title)

@section('content')
<div class="flex items-center justify-center min-h-screen p-4 bg-gray-100">
    <div class="w-full max-w-4xl bg-white rounded-3xl shadow-2xl p-8 md:p-12">
        <!-- Header and Progress -->
        <header class="text-center mb-8">
            <h1 class="text-4xl md:text-5xl font-extrabold text-blue-700 tracking-tight mb-2">{{ $exam->title }}</h1>
            <p class="text-sm text-gray-500 font-medium">{{ $exam->description ?? 'Test your knowledge with our curated questions!' }}</p>
            
            <!-- Countdown Timer and Progress Bar -->
            <div class="flex items-center justify-between mt-6">
                <div id="countdown-timer" class="w-20 h-20 rounded-full flex items-center justify-center p-2 watch-bezel">
                    <div id="countdown-display" class="w-full h-full rounded-full flex items-center justify-center text-center font-bold text-sm text-gray-100 bg-gray-900 shadow-inner watch-face">
                        --:--
                    </div>
                </div>
                <div class="relative flex-1 mx-4">
                    <div class="overflow-hidden h-3 mb-2 text-xs flex rounded-full bg-gray-200 shadow-inner">
                        <div id="progress-bar" style="width:0%" class="shadow-none flex flex-col text-center whitespace-nowrap text-white justify-center bg-blue-500 transition-all duration-500 ease-in-out rounded-full shadow-lg"></div>
                    </div>
                    <div class="flex justify-between text-xs font-semibold text-gray-500">
                        <span id="current-question-display">Question 1</span>
                        <span id="total-questions-display">of {{ $result->total_questions ?? 1 }}</span>
                    </div>
                </div>
            </div>
        </header>

        <!-- Main Quiz Section with Navigator -->
        <div class="flex flex-col lg:flex-row gap-8">
            <!-- Question Block -->
            <main class="w-full lg:w-2/3">
                <form id="examForm" action="{{ route('student.exams.submit', $exam) }}" method="POST">
            @csrf
            
                    <div class="mb-8">
                        <h2 id="question-text" class="text-xl md:text-2xl font-bold mb-6"></h2>
                        <div id="options-container" class="space-y-4">
                            <!-- Options will be dynamically added here -->
                        </div>
                        </div>
                        
                    <!-- Navigation Buttons -->
                    <div class="flex justify-between items-center mt-10">
                        <button type="button" id="prev-btn" class="px-6 py-3 rounded-full text-sm font-semibold text-gray-700 bg-gray-200 hover:bg-gray-300 transition-colors duration-200 disabled:opacity-50 disabled:cursor-not-allowed">
                            Previous
                        </button>
                        <div class="flex items-center space-x-4">
                            <button type="button" id="skip-btn" class="px-6 py-3 rounded-full text-sm font-semibold text-white bg-orange-500 hover:bg-orange-600 transition-colors duration-200 shadow-lg">Skip</button>
                            <button type="button" id="submit-btn" class="px-6 py-3 rounded-full text-sm font-bold text-white bg-green-500 hover:bg-green-600 transition-colors duration-200 shadow-lg">
                                🚀 Submit Quiz
                            </button>
                        </div>
                        <button type="button" id="next-btn" class="px-6 py-3 rounded-full text-sm font-semibold text-white bg-blue-500 hover:bg-blue-600 transition-colors duration-200 disabled:opacity-50 disabled:cursor-not-allowed">
                            Next
                        </button>
                    </div>
                </form>
            </main>
            
            <!-- Question Navigator and Legend -->
            <div class="w-full lg:w-1/3 bg-gray-50 p-6 rounded-xl shadow-inner">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Question Navigator</h3>
                <div id="navigator-container" class="grid grid-cols-5 md:grid-cols-6 lg:grid-cols-7 gap-2 mb-6">
                    <!-- Navigator buttons dynamically added here -->
                    </div>

                <!-- Legend -->
                <div>
                    <h4 class="text-sm font-semibold text-gray-600 mb-2">Legend</h4>
                    <div class="space-y-2">
                        <div class="flex items-center">
                            <span class="block w-4 h-4 rounded-full bg-blue-500"></span>
                            <span class="ml-2 text-sm text-gray-700">Current Question</span>
                        </div>
                        <div class="flex items-center">
                            <span class="block w-4 h-4 rounded-full bg-green-500"></span>
                            <span class="ml-2 text-sm text-gray-700">Answered</span>
                        </div>
                        <div class="flex items-center">
                            <span class="block w-4 h-4 rounded-full bg-orange-500"></span>
                            <span class="ml-2 text-sm text-gray-700">Skipped</span>
                        </div>
                    </div>
                </div>
                </div>
            </div>

        <!-- Result Modal -->
        <div id="result-modal" class="fixed inset-0 bg-gray-900 bg-opacity-75 flex items-center justify-center p-4 transition-opacity duration-300 hidden z-50">
            <div class="bg-white rounded-xl p-8 md:p-10 text-center shadow-lg transform transition-transform duration-300 scale-95">
                <h3 id="modal-title" class="text-2xl font-bold mb-4"></h3>
                <p id="modal-message" class="text-lg text-gray-700 mb-6"></p>
                <button id="close-modal-btn" class="px-6 py-2 rounded-full font-semibold text-white bg-green-500 hover:bg-green-600 transition-colors duration-200">
                    Okay
                </button>
            </div>
        </div>
    </div>
</div>

<style>
.option-btn.selected {
    background-color: #22c55e;
    color: white;
    border-color: #22c55e;
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
    position: relative;
}
.option-btn.selected:hover {
    background-color: #16a34a;
}
.navigator-btn.current {
    background-color: #3b82f6;
    color: white;
    border-color: #3b82f6;
}
.navigator-btn.answered {
    background-color: #22c55e;
    color: white;
    border-color: #22c55e;
}
.navigator-btn.skipped {
    background-color: #f97316;
    color: white;
    border-color: #f97316;
}
.selected-icon {
    position: absolute;
    right: 1rem;
    top: 50%;
    transform: translateY(-50%);
    width: 1.5rem;
    height: 1.5rem;
}
@keyframes pulse-once {
    0% { transform: scale(1); }
    50% { transform: scale(1.05); }
    100% { transform: scale(1); }
}
.animate-pulse-once {
    animation: pulse-once 0.5s ease-in-out;
}
.watch-bezel {
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1), inset 0 2px 4px rgba(255, 255, 255, 0.5), inset 0 -2px 4px rgba(0, 0, 0, 0.2);
    background-image: linear-gradient(145deg, #e0e0e0, #ffffff);
}
.watch-face {
    box-shadow: inset 0 2px 4px rgba(0, 0, 0, 0.6);
}
</style>

<script>
// Questions data
@php
$questionsData = $questions->count() > 0 ? $questions->map(function($q) {
    $options = [];
    if (!empty($q->option_a)) $options[] = $q->option_a;
    if (!empty($q->option_b)) $options[] = $q->option_b;
    if (!empty($q->option_c)) $options[] = $q->option_c;
    if (!empty($q->option_d)) $options[] = $q->option_d;
    
    return [
        'id' => $q->id,
        'question' => $q->question_text,
        'type' => $q->question_type ?? 'mcq',
        'options' => $options,
        'marks' => $q->marks ?? 1
    ];
})->toArray() : [
    [
        'id' => 1,
        'question' => 'What is the capital of France?',
        'type' => 'mcq',
        'options' => ['London', 'Paris', 'Berlin', 'Madrid'],
        'marks' => 1
    ]
];
@endphp
const questions = @json($questionsData);

// State management
const state = {
    currentQuestionIndex: 0,
    answers: new Array(questions.length).fill(null),
    skipped: new Array(questions.length).fill(false),
    isSubmitted: false,
    timer: null
};

const QUIZ_DURATION = {{ $exam->duration * 60 }};
let timeRemaining = QUIZ_DURATION;

// DOM elements
const questionTextEl = document.getElementById('question-text');
const optionsContainerEl = document.getElementById('options-container');
const prevBtn = document.getElementById('prev-btn');
const nextBtn = document.getElementById('next-btn');
const skipBtn = document.getElementById('skip-btn');
const submitBtn = document.getElementById('submit-btn');
const progressBar = document.getElementById('progress-bar');
const currentQuestionDisplay = document.getElementById('current-question-display');
const countdownDisplayEl = document.getElementById('countdown-display');
const navigatorContainer = document.getElementById('navigator-container');
const resultModal = document.getElementById('result-modal');
const modalTitle = document.getElementById('modal-title');
const modalMessage = document.getElementById('modal-message');
const closeModalBtn = document.getElementById('close-modal-btn');
const examForm = document.getElementById('examForm');

// Rendering functions
function render() {
    renderQuestion();
    updateNavigation();
    updateProgress();
    renderNavigator();
}

function renderQuestion() {
    const question = questions[state.currentQuestionIndex];
    // Clean question text by removing any "(Question #)" patterns
    const cleanQuestionText = question.question.replace(/\s*\(Question\s*#?\d*\)/gi, '').trim();
    questionTextEl.textContent = `${state.currentQuestionIndex + 1}. ${cleanQuestionText}`;
    optionsContainerEl.innerHTML = '';
    
    if (question.type === 'mcq' && question.options.length > 0) {
        question.options.forEach((option, index) => {
            const optionBtn = document.createElement('button');
            optionBtn.type = 'button';
            optionBtn.className = 'option-btn w-full text-left px-6 py-4 rounded-xl border-2 border-gray-200 text-lg font-medium transition-colors duration-200 hover:bg-gray-100 flex items-center gap-4';
            
            // Create option label (A, B, C, D)
            const optionLabel = document.createElement('div');
            optionLabel.className = 'flex-shrink-0 w-8 h-8 rounded-full bg-blue-100 text-blue-600 font-bold text-sm flex items-center justify-center border-2 border-blue-200';
            optionLabel.textContent = String.fromCharCode(65 + index); // A, B, C, D
            
            // Create option text
            const optionText = document.createElement('span');
            optionText.className = 'flex-1';
            optionText.textContent = option;
            
            optionBtn.appendChild(optionLabel);
            optionBtn.appendChild(optionText);
            
            if (state.answers[state.currentQuestionIndex] === option) {
                optionBtn.classList.add('selected');
                optionLabel.classList.remove('bg-blue-100', 'text-blue-600', 'border-blue-200');
                optionLabel.classList.add('bg-white', 'text-white', 'border-white');
                
                const checkIcon = document.createElementNS("http://www.w3.org/2000/svg", "svg");
                checkIcon.setAttribute("class", "selected-icon");
                checkIcon.setAttribute("viewBox", "0 0 24 24");
                checkIcon.setAttribute("fill", "none");
                checkIcon.setAttribute("stroke", "currentColor");
                checkIcon.setAttribute("stroke-width", "2");
                checkIcon.setAttribute("stroke-linecap", "round");
                checkIcon.setAttribute("stroke-linejoin", "round");
                checkIcon.innerHTML = '<polyline points="20 6 9 17 4 12"></polyline>';
                optionBtn.appendChild(checkIcon);
            }

            optionBtn.addEventListener('click', () => {
                if (!state.isSubmitted) {
                    state.answers[state.currentQuestionIndex] = option;
                    state.skipped[state.currentQuestionIndex] = false;
                    render();
                }
            });

            optionsContainerEl.appendChild(optionBtn);
        });
    } else if (question.type === 'descriptive') {
        const textarea = document.createElement('textarea');
        textarea.name = `answers[${question.id}]`;
        textarea.rows = 6;
        textarea.className = 'w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 resize-none';
        textarea.placeholder = 'Type your detailed answer here...';
        textarea.value = state.answers[state.currentQuestionIndex] || '';
        
        textarea.addEventListener('input', () => {
            if (!state.isSubmitted) {
                state.answers[state.currentQuestionIndex] = textarea.value;
                state.skipped[state.currentQuestionIndex] = false;
                updateProgress();
                updateNavigation();
                renderNavigator();
            }
        });
        
        optionsContainerEl.appendChild(textarea);
    }
}

function renderNavigator() {
    navigatorContainer.innerHTML = '';
    questions.forEach((q, index) => {
        const navBtn = document.createElement('button');
        navBtn.type = 'button';
        navBtn.textContent = index + 1;
        navBtn.className = 'navigator-btn w-8 h-8 rounded-full text-xs font-semibold flex items-center justify-center border-2 border-gray-300';

        if (index === state.currentQuestionIndex) {
            navBtn.classList.add('current');
        } else if (state.answers[index] !== null) {
            navBtn.classList.add('answered');
        } else if (state.skipped[index]) {
            navBtn.classList.add('skipped');
        }
        
        navBtn.addEventListener('click', () => {
            if (!state.isSubmitted) {
                state.currentQuestionIndex = index;
                render();
            }
        });
        navigatorContainer.appendChild(navBtn);
    });
}

function updateNavigation() {
    const currentAnswer = state.answers[state.currentQuestionIndex];
    const hasAnswer = currentAnswer !== null && currentAnswer.trim() !== '';
    
    prevBtn.disabled = state.currentQuestionIndex === 0 || state.isSubmitted;
    nextBtn.disabled = state.currentQuestionIndex === questions.length - 1 || state.isSubmitted || !hasAnswer;
    skipBtn.style.display = state.isSubmitted ? 'none' : 'block';
    submitBtn.style.display = state.isSubmitted ? 'none' : 'block';
    
    // Skip button always shows "Skip"
    skipBtn.textContent = 'Skip';
    skipBtn.classList.remove('bg-green-500', 'hover:bg-green-600');
    skipBtn.classList.add('bg-orange-500', 'hover:bg-orange-600');
}

function updateProgress() {
    const answeredCount = state.answers.filter(answer => answer !== null && answer.trim() !== '').length;
    const progressPercentage = (answeredCount / questions.length) * 100;
    progressBar.style.width = `${progressPercentage}%`;
    progressBar.classList.add('animate-pulse-once');
    setTimeout(() => {
        progressBar.classList.remove('animate-pulse-once');
    }, 500);
    
    currentQuestionDisplay.textContent = `Question ${state.currentQuestionIndex + 1}`;
}

function updateTimer() {
    const minutes = Math.floor(timeRemaining / 60);
    const seconds = timeRemaining % 60;
    countdownDisplayEl.textContent = `${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`;
    
    if (timeRemaining <= 0) {
        clearInterval(state.timer);
        submitQuiz(true);
    } else {
        timeRemaining--;
    }
}

// Event handlers
function handlePrev() {
    if (state.currentQuestionIndex > 0) {
        state.currentQuestionIndex--;
        render();
    }
}

function handleNext() {
    if (state.currentQuestionIndex < questions.length - 1) {
        state.currentQuestionIndex++;
        render();
    }
}

function handleSkip() {
    state.skipped[state.currentQuestionIndex] = true;
    state.answers[state.currentQuestionIndex] = null;
    handleNext();
}

function handleSubmit() {
    // Show confirmation modal before submitting
    if (confirm('Are you sure you want to submit your quiz? You can still answer more questions if you continue.')) {
        submitQuiz();
    }
}

function submitQuiz(timedOut = false) {
    if (state.isSubmitted) return;
    
    // Prepare form data
    const formData = new FormData();
    formData.append('_token', document.querySelector('meta[name="csrf-token"]').getAttribute('content'));
    
    questions.forEach((question, index) => {
        if (state.answers[index] !== null) {
            formData.append(`answers[${question.id}]`, state.answers[index]);
        }
    });
    
    if (timedOut) {
        showResult('Time\'s Up!', 'Your time has run out. Your exam has been submitted automatically.', true);
    } else {
        showResult('Exam Complete!', 'Your exam has been submitted successfully.', true);
    }
    
    // Submit the form and redirect
    fetch(examForm.action, {
        method: 'POST',
        body: formData,
        redirect: 'follow'
    }).then(response => {
        if (response.ok) {
            // Server will handle the redirect to results page
            window.location.href = '{{ route("student.exams.result", $exam) }}';
        } else {
            console.error('Error submitting exam');
            alert('There was an error submitting your exam. Please try again.');
        }
    }).catch(error => {
        console.error('Error submitting exam:', error);
        alert('There was an error submitting your exam. Please try again.');
    });
}

function showResult(title, message, shouldSubmit = false) {
    modalTitle.textContent = title;
    modalMessage.textContent = message;
    resultModal.classList.remove('hidden');
    
    if (shouldSubmit) {
        state.isSubmitted = true;
        clearInterval(state.timer);
        render();
    }
}

function hideResult() {
    resultModal.classList.add('hidden');
}

// Initialization
document.addEventListener('DOMContentLoaded', () => {
    prevBtn.addEventListener('click', handlePrev);
    nextBtn.addEventListener('click', handleNext);
    skipBtn.addEventListener('click', handleSkip);
    submitBtn.addEventListener('click', handleSubmit);
    closeModalBtn.addEventListener('click', hideResult);
    
    state.timer = setInterval(updateTimer, 1000);
    render();

// Prevent accidental navigation
window.addEventListener('beforeunload', function(e) {
        if (timeRemaining > 0 && !state.isSubmitted) {
        e.preventDefault();
        e.returnValue = 'Are you sure you want to leave? Your exam progress will be lost.';
        return e.returnValue;
    }
    });
});
</script>
@endsection
