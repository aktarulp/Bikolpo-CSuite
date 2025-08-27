@extends('layouts.partner-layout')

@section('title', 'Assign Questions to Exam')

@section('content')
<div class="min-h-screen bg-gray-50 dark:bg-gray-900 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Page Header -->
        <div class="mb-8">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-4">
                    <div>
                        <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Assign Questions to Exam</h1>
                        <p class="mt-2 text-gray-600 dark:text-gray-400">Select questions for: {{ $exam->title }}</p>
                    </div>
                    <div class="hidden lg:block">
                        <div class="px-4 py-2 bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg">
                            <span class="text-sm font-medium text-blue-800 dark:text-blue-200">Exam:</span>
                            <span class="ml-2 text-lg font-semibold text-blue-900 dark:text-blue-100">{{ $exam->title }}</span>
                        </div>
                    </div>
                </div>
                <div class="flex space-x-3">
                    <a href="{{ route('partner.exams.show', $exam) }}" 
                       class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:bg-gray-800 dark:border-gray-600 dark:text-gray-300 dark:hover:bg-gray-700">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                        View Exam
                    </a>
                    <a href="{{ route('partner.exams.index') }}" 
                       class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:bg-gray-800 dark:border-gray-600 dark:text-gray-300 dark:hover:bg-gray-700">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                        Back to Exams
                    </a>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="bg-white dark:bg-gray-800 shadow-xl rounded-lg overflow-hidden">
            <form action="{{ route('partner.exams.store-assigned-questions', $exam) }}" method="POST">
                @csrf
                
                <!-- Exam Info -->
                <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-700">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-sm">
                        <div>
                            <span class="font-medium text-gray-700 dark:text-gray-300">Total Questions:</span>
                            <span class="ml-2 text-gray-900 dark:text-white">{{ $exam->total_questions }}</span>
                        </div>
                        <div>
                            <span class="font-medium text-gray-700 dark:text-gray-300">Duration:</span>
                            <span class="ml-2 text-gray-900 dark:text-white">{{ $exam->duration }} minutes</span>
                        </div>
                        <div>
                            <span class="font-medium text-gray-700 dark:text-gray-300">Status:</span>
                            <span class="ml-2 px-2 py-1 text-xs font-medium rounded-full 
                                {{ $exam->status === 'published' ? 'bg-green-100 text-green-800' : 
                                   ($exam->status === 'draft' ? 'bg-yellow-100 text-yellow-800' : 'bg-gray-100 text-gray-800') }}">
                                {{ ucfirst($exam->status) }}
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Questions Selection -->
                <div class="px-6 py-6">
                    <div class="flex items-center justify-between mb-6">
                        <h2 class="text-xl font-semibold text-gray-900 dark:text-white">Select Questions</h2>
                        <div class="flex items-center space-x-4">
                            <span class="text-sm text-gray-600 dark:text-gray-400">
                                Selected: <span id="selected-count">0</span> questions
                            </span>
                            <button type="button" id="select-all" class="text-sm text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300">
                                Select All
                            </button>
                            <button type="button" id="clear-all" class="text-sm text-red-600 hover:text-red-800 dark:text-red-400 dark:hover:text-red-300">
                                Clear All
                            </button>
                        </div>
                    </div>

                    <!-- Search and Filters -->
                    <div class="mb-6 space-y-4">
                        <!-- Search Bar -->
                        <div class="flex items-center space-x-4">
                            <div class="flex-1 max-w-md">
                                <label for="search" class="sr-only">Search questions</label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                        </svg>
                                    </div>
                                    <input type="text" id="search" name="search" placeholder="Search questions by text, subject, or topic..."
                                           class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-lg leading-5 bg-white dark:bg-gray-700 dark:border-gray-600 dark:text-white placeholder-gray-500 dark:placeholder-gray-400 focus:outline-none focus:placeholder-gray-400 focus:ring-1 focus:ring-blue-500 focus:border-blue-500 dark:focus:ring-blue-400 dark:focus:border-blue-400">
                                </div>
                            </div>
                            <button type="button" id="clear-search" class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-300 dark:hover:bg-gray-600">
                                Clear
                            </button>
                        </div>

                        <!-- Dynamic Filters -->
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                            <!-- Question Type Filter -->
                            <div>
                                <label for="type-filter" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Question Type</label>
                                <select id="type-filter" class="block w-full px-3 py-2 border border-gray-300 rounded-lg bg-white dark:bg-gray-700 dark:border-gray-600 dark:text-white focus:ring-1 focus:ring-blue-500 focus:border-blue-500 dark:focus:ring-blue-400 dark:focus:border-blue-400">
                                    <option value="">All Types</option>
                                    <option value="mcq">MCQ</option>
                                    <option value="descriptive">Descriptive</option>
                                </select>
                            </div>

                            <!-- Subject Filter -->
                            <div>
                                <label for="subject-filter" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Subject</label>
                                <select id="subject-filter" class="block w-full px-3 py-2 border border-gray-300 rounded-lg bg-white dark:bg-gray-700 dark:border-gray-600 dark:text-white focus:ring-1 focus:ring-blue-500 focus:border-blue-500 dark:focus:ring-blue-400 dark:focus:border-blue-400">
                                    <option value="">All Subjects</option>
                                    @foreach($subjects ?? [] as $subject)
                                        <option value="{{ $subject->id }}">{{ $subject->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Topic Filter -->
                            <div>
                                <label for="topic-filter" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Topic</label>
                                <select id="topic-filter" class="block w-full px-3 py-2 border border-gray-300 rounded-lg bg-white dark:bg-gray-700 dark:border-gray-600 dark:text-white focus:ring-1 focus:ring-blue-500 focus:border-blue-500 dark:focus:ring-blue-400 dark:focus:border-blue-400">
                                    <option value="">All Topics</option>
                                    @foreach($topics ?? [] as $topic)
                                        <option value="{{ $topic->id }}">{{ $topic->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Difficulty Filter -->
                            <div>
                                <label for="difficulty-filter" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Difficulty</label>
                                <select id="difficulty-filter" class="block w-full px-3 py-2 border border-gray-300 rounded-lg bg-white dark:bg-gray-700 dark:border-gray-600 dark:text-white focus:ring-1 focus:ring-blue-500 focus:border-blue-500 dark:focus:ring-blue-400 dark:focus:border-blue-400">
                                    <option value="">All Levels</option>
                                    <option value="1">Easy</option>
                                    <option value="2">Medium</option>
                                    <option value="3">Hard</option>
                                </select>
                            </div>
                        </div>

                        <!-- Active Filters Display -->
                        <div id="active-filters" class="hidden">
                            <div class="flex items-center space-x-2">
                                <span class="text-sm font-medium text-gray-700 dark:text-gray-300">Active Filters:</span>
                                <div id="filter-tags" class="flex flex-wrap gap-2"></div>
                                <button type="button" id="clear-filters" class="text-sm text-red-600 hover:text-red-800 dark:text-red-400 dark:hover:text-red-300">
                                    Clear All Filters
                                </button>
                            </div>
                        </div>
                    </div>

                    @if($questions->count() > 0)
                        <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 max-h-96 overflow-y-auto">
                            @foreach($questions as $question)
                                <div class="border border-gray-200 dark:border-gray-600 rounded-lg p-4 hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors"
                                     data-type="{{ $question->question_type }}"
                                     data-subject="{{ $question->subject->name ?? '' }}"
                                     data-topic="{{ $question->topic->name ?? '' }}"
                                     data-difficulty="{{ $question->difficulty_level ?? '' }}">
                                    <label class="flex items-start space-x-3 cursor-pointer">
                                        <input type="checkbox" name="question_ids[]" value="{{ $question->id }}" 
                                               class="question-checkbox mt-1 h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded"
                                               {{ $assignedQuestions->contains($question->id) ? 'checked' : '' }}>
                                        <div class="flex-1 min-w-0">
                                            <div class="flex items-center justify-between">
                                                <span class="text-sm font-medium text-gray-900 dark:text-white">
                                                    {{ Str::limit($question->question_text, 80) }}
                                                </span>
                                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium
                                                    {{ $question->question_type === 'mcq' ? 'bg-blue-100 text-blue-800' : 'bg-purple-100 text-purple-800' }}">
                                                    {{ strtoupper($question->question_type) }}
                                                </span>
                                            </div>
                                            <div class="mt-2 text-xs text-gray-500 dark:text-gray-400">
                                                <span class="font-medium">Subject:</span> {{ $question->subject->name ?? 'N/A' }} |
                                                <span class="font-medium">Topic:</span> {{ $question->topic->name ?? 'N/A' }} |
                                                <span class="font-medium">Marks:</span> {{ $question->marks ?? 1 }}
                                                @if($question->difficulty_level)
                                                    | <span class="font-medium">Difficulty:</span> 
                                                    <span class="
                                                        {{ $question->difficulty_level == 1 ? 'text-green-600' : 
                                                           ($question->difficulty_level == 2 ? 'text-yellow-600' : 'text-red-600') }}">
                                                        {{ $question->difficulty_level == 1 ? 'Easy' : 
                                                           ($question->difficulty_level == 2 ? 'Medium' : 'Hard') }}
                                                    </span>
                                                @endif
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

                <!-- Form Actions -->
                @if($questions->count() > 0)
                    <div class="px-6 py-4 bg-gray-50 dark:bg-gray-700 border-t border-gray-200 dark:border-gray-600">
                        <div class="flex flex-col sm:flex-row justify-end space-y-3 sm:space-y-0 sm:space-x-3">
                            <a href="{{ route('partner.exams.show', $exam) }}" 
                               class="inline-flex justify-center items-center px-6 py-3 border border-gray-300 rounded-lg shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 dark:bg-gray-800 dark:border-gray-600 dark:text-gray-300 dark:hover:bg-gray-700 transition-colors duration-200">
                                Cancel
                            </a>
                            <button type="submit" 
                                    class="inline-flex justify-center items-center px-6 py-3 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-200">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                Assign Selected Questions
                            </button>
                        </div>
                    </div>
                @endif
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const questionCheckboxes = document.querySelectorAll('.question-checkbox');
    const selectAllBtn = document.getElementById('select-all');
    const clearAllBtn = document.getElementById('clear-all');
    const selectedCountSpan = document.getElementById('selected-count');
    
    // Filter elements
    const searchInput = document.getElementById('search');
    const clearSearchBtn = document.getElementById('clear-search');
    const typeFilter = document.getElementById('type-filter');
    const subjectFilter = document.getElementById('subject-filter');
    const topicFilter = document.getElementById('topic-filter');
    const difficultyFilter = document.getElementById('difficulty-filter');
    const clearFiltersBtn = document.getElementById('clear-filters');
    const activeFiltersDiv = document.getElementById('active-filters');
    const filterTagsDiv = document.getElementById('filter-tags');
    
    // Store all questions for filtering
    const allQuestions = Array.from(document.querySelectorAll('.question-checkbox')).map(checkbox => {
        const questionDiv = checkbox.closest('.border');
        return {
            checkbox: checkbox,
            element: questionDiv,
            text: questionDiv.textContent.toLowerCase(),
            type: questionDiv.dataset.type || '',
            subject: questionDiv.dataset.subject || '',
            topic: questionDiv.dataset.topic || '',
            difficulty: questionDiv.dataset.difficulty || ''
        };
    });
    
    function updateSelectedCount() {
        const selectedCount = document.querySelectorAll('.question-checkbox:checked').length;
        selectedCountSpan.textContent = selectedCount;
    }
    
    function selectAll() {
        const visibleQuestions = document.querySelectorAll('.question-checkbox:not(.hidden)');
        visibleQuestions.forEach(checkbox => {
            checkbox.checked = true;
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
        const selectedDifficulty = difficultyFilter.value;
        
        let visibleCount = 0;
        
        allQuestions.forEach(question => {
            let shouldShow = true;
            
            // Search filter
            if (searchTerm && !question.text.includes(searchTerm)) {
                shouldShow = false;
            }
            
            // Type filter
            if (selectedType && question.type !== selectedType) {
                shouldShow = false;
            }
            
            // Subject filter
            if (selectedSubject && question.subject !== selectedSubject) {
                shouldShow = false;
            }
            
            // Topic filter
            if (selectedTopic && question.topic !== selectedTopic) {
                shouldShow = false;
            }
            
            // Difficulty filter
            if (selectedDifficulty && question.difficulty !== selectedDifficulty) {
                shouldShow = false;
            }
            
            if (shouldShow) {
                question.element.classList.remove('hidden');
                visibleCount++;
            } else {
                question.element.classList.add('hidden');
            }
        });
        
        // Update active filters display
        updateActiveFiltersDisplay();
        
        // Update select all functionality for visible questions only
        updateSelectAllButtons();
    }
    
    function updateActiveFiltersDisplay() {
        const filters = [];
        
        if (searchInput.value) filters.push(`Search: "${searchInput.value}"`);
        if (typeFilter.value) filters.push(`Type: ${typeFilter.options[typeFilter.selectedIndex].text}`);
        if (subjectFilter.value) filters.push(`Subject: ${subjectFilter.options[subjectFilter.selectedIndex].text}`);
        if (topicFilter.value) filters.push(`Topic: ${topicFilter.options[topicFilter.selectedIndex].text}`);
        if (difficultyFilter.value) filters.push(`Difficulty: ${difficultyFilter.options[difficultyFilter.selectedIndex].text}`);
        
        if (filters.length > 0) {
            activeFiltersDiv.classList.remove('hidden');
            filterTagsDiv.innerHTML = filters.map(filter => 
                `<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200">${filter}</span>`
            ).join('');
        } else {
            activeFiltersDiv.classList.add('hidden');
        }
    }
    
    function updateSelectAllButtons() {
        const visibleQuestions = document.querySelectorAll('.question-checkbox:not(.hidden)');
        const allVisibleChecked = Array.from(visibleQuestions).every(checkbox => checkbox.checked);
        
        if (visibleQuestions.length > 0) {
            selectAllBtn.textContent = allVisibleChecked ? 'Deselect All' : 'Select All';
        }
    }
    
    function clearAllFilters() {
        searchInput.value = '';
        typeFilter.value = '';
        subjectFilter.value = '';
        topicFilter.value = '';
        difficultyFilter.value = '';
        
        // Show all questions
        allQuestions.forEach(question => {
            question.element.classList.remove('hidden');
        });
        
        activeFiltersDiv.classList.add('hidden');
        updateSelectAllButtons();
    }
    
    // Event listeners
    questionCheckboxes.forEach(checkbox => {
        checkbox.addEventListener('change', updateSelectedCount);
    });
    
    selectAllBtn.addEventListener('click', selectAll);
    clearAllBtn.addEventListener('click', clearAll);
    
    // Filter event listeners
    searchInput.addEventListener('input', applyFilters);
    clearSearchBtn.addEventListener('click', () => {
        searchInput.value = '';
        applyFilters();
    });
    
    typeFilter.addEventListener('change', applyFilters);
    subjectFilter.addEventListener('change', applyFilters);
    topicFilter.addEventListener('change', applyFilters);
    difficultyFilter.addEventListener('change', applyFilters);
    
    clearFiltersBtn.addEventListener('click', clearAllFilters);
    
    // Initial setup
    updateSelectedCount();
    updateSelectAllButtons();
});
</script>
@endpush
