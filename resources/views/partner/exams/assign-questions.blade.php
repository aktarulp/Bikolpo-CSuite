@extends('layouts.partner-layout')

@section('title', 'Assign Questions to Exam')

@section('content')
<div class="min-h-screen bg-gray-50 dark:bg-gray-900 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Page Header -->
        <div class="mb-4">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Assign Questions</h1>
                    <p class="text-sm text-gray-600 dark:text-gray-400">{{ $exam->title }}</p>
                </div>
                <div class="flex space-x-2">
                    <a href="{{ route('partner.exams.show', $exam) }}" 
                       class="px-3 py-1 text-sm border border-gray-300 rounded text-gray-700 bg-white hover:bg-gray-50 dark:bg-gray-800 dark:border-gray-600 dark:text-gray-300">
                        View Exam
                    </a>
                    <a href="{{ route('partner.exams.index') }}" 
                       class="px-3 py-1 text-sm border border-gray-300 rounded text-gray-700 bg-white hover:bg-gray-50 dark:bg-gray-800 dark:border-gray-600 dark:text-gray-300">
                        Back
                    </a>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="bg-white dark:bg-gray-800 shadow-xl rounded-lg overflow-hidden">
            <form action="{{ route('partner.exams.store-assigned-questions', $exam) }}" method="POST">
                @csrf
                
                <!-- Exam Info -->
                <div class="px-4 py-2 border-b border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-700">
                    <div class="flex items-center justify-between text-sm">
                        <div class="flex items-center space-x-4">
                            <span class="text-gray-700 dark:text-gray-300">Max: <strong>{{ $exam->total_questions }}</strong></span>
                            <span class="text-gray-700 dark:text-gray-300">Duration: <strong>{{ $exam->duration }}min</strong></span>
                        </div>
                        <span class="px-2 py-1 text-xs font-medium rounded-full 
                            {{ $exam->status === 'published' ? 'bg-green-100 text-green-800' : 
                               ($exam->status === 'draft' ? 'bg-yellow-100 text-yellow-800' : 'bg-gray-100 text-gray-800') }}">
                            {{ ucfirst($exam->status) }}
                        </span>
                    </div>
                </div>

                <!-- Questions Selection -->
                <div class="px-4 py-4">
                    <div class="flex items-center justify-between mb-4">
                        <h2 class="text-lg font-semibold text-gray-900 dark:text-white">Select Questions</h2>
                        <div class="flex items-center space-x-3">
                            <div class="flex flex-col items-end">
                                <span class="text-sm text-gray-600 dark:text-gray-400">
                                    <span id="selected-count">0</span>/<span id="total-allowed">{{ $exam->total_questions }}</span>
                                    <span class="ml-2 text-xs text-gray-500 dark:text-gray-400">
                                        (<span id="remaining-count">{{ $exam->total_questions }}</span> remaining)
                                    </span>
                                </span>
                                <div class="selection-progress w-32 mt-1">
                                    <div class="selection-progress-bar" id="progress-bar" style="width: 0%"></div>
                                </div>
                            </div>
                            <button type="button" id="select-all" class="text-sm text-blue-600 hover:text-blue-800 dark:text-blue-400">
                                Select All
                            </button>
                            <button type="button" id="clear-all" class="text-sm text-red-600 hover:text-red-800 dark:text-red-400">
                                Clear
                            </button>
                            @if($questions->count() > 0)
                                <div class="flex space-x-2">
                                    <a href="{{ route('partner.exams.show', $exam) }}" 
                                       class="px-3 py-1 text-sm border border-gray-300 rounded text-gray-700 bg-white hover:bg-gray-50 dark:bg-gray-800 dark:border-gray-600 dark:text-gray-300">
                                        Cancel
                                    </a>
                                    <button type="submit" 
                                            class="px-3 py-1 text-sm border border-transparent rounded text-white bg-blue-600 hover:bg-blue-700">
                                        Assign Questions
                                    </button>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Limit Warning -->
                    <div id="limit-warning" class="hidden mb-4 p-3 bg-yellow-50 border border-yellow-200 rounded-lg dark:bg-yellow-900/20 dark:border-yellow-800">
                        <div class="flex items-center">
                            <svg class="w-5 h-5 text-yellow-600 dark:text-yellow-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                            </svg>
                            <span class="text-sm text-yellow-800 dark:text-yellow-200">
                                You have reached the maximum number of questions allowed for this exam. Deselect some questions to select others.
                            </span>
                        </div>
                    </div>

                    <!-- Search and Filters -->
                    <div class="mb-4 space-y-3">
                        <!-- Search Bar -->
                        <div class="flex items-center space-x-2">
                            <div class="flex-1">
                                <input type="text" id="search" name="search" placeholder="Search questions..."
                                       class="block w-full px-3 py-2 border border-gray-300 rounded text-sm bg-white dark:bg-gray-700 dark:border-gray-600 dark:text-white focus:ring-1 focus:ring-blue-500 focus:border-blue-500">
                            </div>
                            <button type="button" id="clear-search" class="px-3 py-2 text-sm text-gray-700 bg-white border border-gray-300 rounded hover:bg-gray-50 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-300">
                                Clear
                            </button>
                        </div>

                        <!-- Filters -->
                        <div class="flex items-center space-x-3">
                            <select id="type-filter" class="px-3 py-2 border border-gray-300 rounded text-sm bg-white dark:bg-gray-700 dark:border-gray-600 dark:text-white focus:ring-1 focus:ring-blue-500">
                                <option value="">All Types</option>
                                <option value="mcq">MCQ</option>
                                <option value="descriptive">Descriptive</option>
                            </select>

                            <select id="subject-filter" class="px-3 py-2 border border-gray-300 rounded text-sm bg-white dark:bg-gray-700 dark:border-gray-600 dark:text-white focus:ring-1 focus:ring-blue-500">
                                <option value="">All Subjects</option>
                                @foreach($subjects ?? [] as $subject)
                                    <option value="{{ $subject->id }}">{{ $subject->name }}</option>
                                @endforeach
                            </select>

                            <select id="topic-filter" class="px-3 py-2 border border-gray-300 rounded text-sm bg-white dark:bg-gray-700 dark:border-gray-600 dark:text-white focus:ring-1 focus:ring-blue-500">
                                <option value="">All Topics</option>
                                @foreach($topics ?? [] as $topic)
                                    <option value="{{ $topic->id }}">{{ $topic->name }}</option>
                                @endforeach
                            </select>

                            <button type="button" id="clear-filters" class="px-3 py-2 text-sm text-red-600 hover:text-red-800 dark:text-red-400">
                                Clear Filters
                            </button>
                        </div>
                    </div>

                    @if($questions->count() > 0)
                        <div class="grid grid-cols-1 lg:grid-cols-2 gap-3 max-h-80 overflow-y-auto">
                            @foreach($questions as $question)
                                <div class="question-card border border-gray-200 dark:border-gray-600 rounded p-3 hover:bg-gray-50 dark:hover:bg-gray-700"
                                     data-type="{{ $question->question_type }}"
                                     data-subject="{{ $question->subject->name ?? '' }}"
                                     data-topic="{{ $question->topic->name ?? '' }}">
                                    <label class="flex items-start space-x-2 cursor-pointer">
                                        <input type="checkbox" name="question_ids[]" value="{{ $question->id }}" 
                                               class="question-checkbox mt-1 h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded"
                                               {{ $assignedQuestions->contains($question->id) ? 'checked' : '' }}>
                                        <div class="flex-1 min-w-0">
                                            <div class="flex items-center justify-between">
                                                <span class="text-sm text-gray-900 dark:text-white">
                                                    {{ Str::limit($question->question_text, 60) }}
                                                </span>
                                                <span class="text-xs px-2 py-1 rounded
                                                    {{ $question->question_type === 'mcq' ? 'bg-blue-100 text-blue-800' : 'bg-purple-100 text-purple-800' }}">
                                                    {{ strtoupper($question->question_type) }}
                                                </span>
                                            </div>
                                            <div class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                                                {{ $question->subject->name ?? 'N/A' }} | {{ $question->topic->name ?? 'N/A' }}
                                            </div>
                                        </div>
                                    </label>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-12">
                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                            </svg>
                            <h3 class="mt-2 text-sm font-medium text-gray-900 dark:text-white">No questions available</h3>
                            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Create some questions first before assigning them to exams.</p>
                            <div class="mt-6">
                                <a href="{{ route('partner.questions.create') }}" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                    Create Question
                                </a>
                            </div>
                        </div>
                    @endif
                </div>


            </form>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
/* Question Selection Limit Styling */
.question-limit-container {
    transition: all 0.3s ease-in-out;
}

/* Selection Counter Styling */
#selected-count {
    font-weight: 700;
    transition: color 0.3s ease;
}

#total-allowed {
    font-weight: 600;
    color: #6b7280;
}

/* Remaining Count Styling */
#remaining-count {
    transition: all 0.3s ease;
    font-weight: 600;
    padding: 2px 8px;
    border-radius: 12px;
    background-color: rgba(34, 197, 94, 0.1);
}

#remaining-count.warning {
    background-color: rgba(245, 158, 11, 0.1);
    animation: pulse-warning 2s infinite;
}

#remaining-count.danger {
    background-color: rgba(239, 68, 68, 0.1);
    animation: pulse-danger 1.5s infinite;
}

/* Warning Banner Styling */
#limit-warning {
    transition: all 0.3s ease-in-out;
    animation: slideDown 0.3s ease-out;
}

#limit-warning.show {
    transform: translateY(0);
    opacity: 1;
}

/* Question Card Styling */
.question-card {
    transition: all 0.3s ease;
    border: 2px solid transparent;
}

.question-card:hover:not(.disabled) {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    border-color: #3b82f6;
}

.question-card.disabled {
    opacity: 0.5;
    cursor: not-allowed;
    background-color: #f9fafb;
    border-color: #e5e7eb;
}

.question-card.disabled:hover {
    transform: none;
    box-shadow: none;
    border-color: #e5e7eb;
}

.question-card.selected {
    border-color: #10b981;
    background-color: rgba(16, 185, 129, 0.05);
}

.question-card.selected:hover {
    border-color: #059669;
    background-color: rgba(16, 185, 129, 0.1);
}

/* Checkbox Styling */
.question-checkbox {
    transition: all 0.2s ease;
}

.question-checkbox:disabled {
    cursor: not-allowed;
    opacity: 0.5;
}

.question-checkbox:checked {
    transform: scale(1.1);
}

/* Button Styling */
#select-all {
    transition: all 0.3s ease;
    position: relative;
    overflow: hidden;
}

#select-all:disabled {
    cursor: not-allowed;
    opacity: 0.6;
}

#select-all:not(:disabled):hover {
    transform: translateY(-1px);
    box-shadow: 0 2px 4px rgba(59, 130, 246, 0.3);
}

#clear-all {
    transition: all 0.3s ease;
}

#clear-all:hover {
    transform: translateY(-1px);
    box-shadow: 0 2px 4px rgba(239, 68, 68, 0.3);
}

/* Progress Bar Styling */
.selection-progress {
    height: 4px;
    background-color: #e5e7eb;
    border-radius: 2px;
    overflow: hidden;
    margin-top: 8px;
}

.selection-progress-bar {
    height: 100%;
    background: linear-gradient(90deg, #10b981, #3b82f6);
    border-radius: 2px;
    transition: width 0.3s ease;
}

.selection-progress-bar.warning {
    background: linear-gradient(90deg, #f59e0b, #f97316);
}

.selection-progress-bar.danger {
    background: linear-gradient(90deg, #ef4444, #dc2626);
    animation: pulse-progress 1s infinite;
}

/* Animations */
@keyframes pulse-warning {
    0%, 100% { opacity: 1; }
    50% { opacity: 0.7; }
}

@keyframes pulse-danger {
    0%, 100% { opacity: 1; }
    50% { opacity: 0.6; }
}

@keyframes pulse-progress {
    0%, 100% { opacity: 1; }
    50% { opacity: 0.8; }
}

@keyframes slideDown {
    from {
        opacity: 0;
        transform: translateY(-10px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

@keyframes shake {
    0%, 100% { transform: translateX(0); }
    25% { transform: translateX(-5px); }
    75% { transform: translateX(5px); }
}

.shake {
    animation: shake 0.5s ease-in-out;
}

/* Dark mode adjustments */
.dark .question-card.disabled {
    background-color: #374151;
    border-color: #4b5563;
}

.dark .selection-progress {
    background-color: #4b5563;
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .question-card:hover:not(.disabled) {
        transform: none;
    }
    
    #select-all:not(:disabled):hover,
    #clear-all:hover {
        transform: none;
    }
}

/* Focus states for accessibility */
.question-checkbox:focus {
    outline: 2px solid #3b82f6;
    outline-offset: 2px;
}

#select-all:focus,
#clear-all:focus {
    outline: 2px solid #3b82f6;
    outline-offset: 2px;
}
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.querySelector('form');
    const questionCheckboxes = document.querySelectorAll('.question-checkbox');
    const selectAllBtn = document.getElementById('select-all');
    const clearAllBtn = document.getElementById('clear-all');
    const selectedCountSpan = document.getElementById('selected-count');
    const totalAllowedSpan = document.getElementById('total-allowed');
    const remainingCountSpan = document.getElementById('remaining-count');
    const progressBar = document.getElementById('progress-bar');
    const maxQuestions = parseInt(totalAllowedSpan.textContent);
    
    // Filter elements
    const searchInput = document.getElementById('search');
    const clearSearchBtn = document.getElementById('clear-search');
    const typeFilter = document.getElementById('type-filter');
    const subjectFilter = document.getElementById('subject-filter');
    const topicFilter = document.getElementById('topic-filter');
    const clearFiltersBtn = document.getElementById('clear-filters');
    
    // Store all questions for filtering
    const allQuestions = Array.from(document.querySelectorAll('.question-checkbox')).map(checkbox => {
        const questionDiv = checkbox.closest('.question-card');
        return {
            checkbox: checkbox,
            element: questionDiv,
            text: questionDiv.textContent.toLowerCase(),
            type: questionDiv.dataset.type || '',
            subject: questionDiv.dataset.subject || '',
            topic: questionDiv.dataset.topic || ''
        };
    });
    
    function updateSelectedCount() {
        const selectedCount = document.querySelectorAll('.question-checkbox:checked').length;
        selectedCountSpan.textContent = selectedCount;
        
        // Update the remaining count display
        const remaining = maxQuestions - selectedCount;
        remainingCountSpan.textContent = remaining;
        
        // Update remaining count styling based on how many are left
        remainingCountSpan.className = 'text-xs';
        if (remaining <= 0) {
            remainingCountSpan.classList.add('text-red-600', 'font-semibold');
        } else if (remaining <= 2) {
            remainingCountSpan.classList.add('text-yellow-600', 'font-semibold');
        } else {
            remainingCountSpan.classList.add('text-gray-500');
        }
        
        // Update progress bar
        const progressPercentage = (selectedCount / maxQuestions) * 100;
        progressBar.style.width = progressPercentage + '%';
        
        // Update progress bar color based on selection level
        progressBar.className = 'selection-progress-bar';
        if (progressPercentage >= 100) {
            progressBar.classList.add('danger');
        } else if (progressPercentage >= 80) {
            progressBar.classList.add('warning');
        }
        
        // Disable/enable checkboxes based on limit
        const isAtLimit = selectedCount >= maxQuestions;
        document.querySelectorAll('.question-card').forEach(card => {
            const checkbox = card.querySelector('.question-checkbox');
            if (!checkbox.checked && isAtLimit) {
                card.classList.add('disabled');
                checkbox.disabled = true;
            } else {
                card.classList.remove('disabled');
                checkbox.disabled = false;
            }
        });
        
        // Show/hide limit warning
        const limitWarning = document.getElementById('limit-warning');
        if (isAtLimit) {
            limitWarning.classList.remove('hidden');
        } else {
            limitWarning.classList.add('hidden');
        }
        
        // Update button states
        selectAllBtn.disabled = isAtLimit;
    }
    
    function selectAll() {
        const visibleQuestions = document.querySelectorAll('.question-checkbox:not(.hidden)');
        const selectedCount = document.querySelectorAll('.question-checkbox:checked').length;
        const remaining = maxQuestions - selectedCount;
        
        let selected = 0;
        visibleQuestions.forEach(checkbox => {
            if (!checkbox.checked && selected < remaining) {
                checkbox.checked = true;
                selected++;
            }
        });
        updateSelectedCount();
    }
    
    function clearAll() {
        questionCheckboxes.forEach(checkbox => {
            checkbox.checked = false;
        });
        updateSelectedCount();
    }
    
    function applyFilters() {
        const searchTerm = searchInput.value.toLowerCase();
        const selectedType = typeFilter.value;
        const selectedSubject = subjectFilter.value;
        const selectedTopic = topicFilter.value;
        
        allQuestions.forEach(question => {
            let shouldShow = true;
            
            if (searchTerm && !question.text.includes(searchTerm)) shouldShow = false;
            if (selectedType && question.type !== selectedType) shouldShow = false;
            if (selectedSubject && question.subject !== selectedSubject) shouldShow = false;
            if (selectedTopic && question.topic !== selectedTopic) shouldShow = false;
            
            if (shouldShow) {
                question.element.classList.remove('hidden');
            } else {
                question.element.classList.add('hidden');
            }
        });
    }
    
    function clearAllFilters() {
        searchInput.value = '';
        typeFilter.value = '';
        subjectFilter.value = '';
        topicFilter.value = '';
        allQuestions.forEach(question => {
            question.element.classList.remove('hidden');
        });
    }
    
    // Event listeners
    questionCheckboxes.forEach(checkbox => {
        checkbox.addEventListener('change', function(e) {
            // If checking a checkbox, verify we haven't exceeded the limit
            if (e.target.checked) {
                const selectedCount = document.querySelectorAll('.question-checkbox:checked').length;
                if (selectedCount > maxQuestions) {
                    e.target.checked = false;
                    alert(`Maximum ${maxQuestions} questions allowed`);
                    return;
                }
            }
            // Always update the count and UI state
            updateSelectedCount();
        });
    });
    
    selectAllBtn.addEventListener('click', selectAll);
    clearAllBtn.addEventListener('click', clearAll);
    searchInput.addEventListener('input', applyFilters);
    clearSearchBtn.addEventListener('click', () => {
        searchInput.value = '';
        applyFilters();
    });
    typeFilter.addEventListener('change', applyFilters);
    subjectFilter.addEventListener('change', applyFilters);
    topicFilter.addEventListener('change', applyFilters);
    clearFiltersBtn.addEventListener('click', clearAllFilters);
    
    // Form validation
    form.addEventListener('submit', function(e) {
        const questionIds = new FormData(form).getAll('question_ids[]');
        if (questionIds.length === 0) {
            e.preventDefault();
            alert('Please select at least one question before submitting.');
            return false;
        }
    });
    
    // Initial setup
    updateSelectedCount();
});
</script>
@endpush
