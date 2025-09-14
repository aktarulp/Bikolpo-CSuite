@extends('layouts.partner-layout')

@section('title', 'Result Entry - ' . $exam->title)

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-50 via-white to-gray-100 dark:from-gray-900 dark:via-gray-800 dark:to-gray-900">
    <div class="space-y-6 p-4 sm:p-6 lg:p-8">
        <!-- Header -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl border border-gray-200 dark:border-gray-700 p-6">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div class="flex flex-col sm:flex-row sm:items-center gap-4">
                    <a href="{{ route('partner.exams.results', $exam) }}" 
                       class="inline-flex items-center px-4 py-2.5 text-sm font-semibold text-gray-700 bg-gray-100 hover:bg-gray-200 border border-gray-300 rounded-xl transition-all duration-200 hover:shadow-md dark:bg-gray-700 dark:border-gray-600 dark:text-gray-300 dark:hover:bg-gray-600">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                        Back to Results
                    </a>
                    <div>
                        <h1 class="text-2xl sm:text-3xl font-bold bg-gradient-to-r from-indigo-600 to-purple-600 bg-clip-text text-transparent dark:from-indigo-400 dark:to-purple-400">
                            Result Entry
                        </h1>
                        <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">Detailed question-wise result entry for {{ $exam->title }}</p>
                    </div>
                </div>
                <div class="flex flex-col sm:flex-row gap-3">
                    <div class="text-right">
                        <div class="text-sm text-gray-500 dark:text-gray-400">Total Questions</div>
                        <div class="text-lg font-bold text-gray-900 dark:text-white">{{ $exam->questions->count() }}</div>
                    </div>
                </div>
            </div>
        </div>

       

        <!-- Result Entry Form -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl border border-gray-200 dark:border-gray-700 overflow-hidden">
            <div class="bg-gradient-to-r from-gray-50 to-gray-100 dark:from-gray-700 dark:to-gray-800 px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                <h3 class="text-lg sm:text-xl font-bold text-gray-900 dark:text-white">Student Selection & Basic Info</h3>
                <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">Select an absent student and enter basic exam information</p>
                @if($absentStudents->count() === 0)
                    <div class="mt-2 p-3 bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg">
                        <div class="flex items-center">
                            <svg class="w-4 h-4 text-blue-600 dark:text-blue-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <span class="text-sm text-blue-800 dark:text-blue-200 font-medium">No absent students found. All students have completed the exam.</span>
                        </div>
                    </div>
                @endif
            </div>
            
            <form id="detailedResultForm" class="p-6 space-y-6" @if($absentStudents->count() === 0) style="pointer-events: none; opacity: 0.6;" @endif>
                @csrf
                
                <!-- Student Selection and Basic Info -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div>
                        <label for="student_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Select Student</label>
                        <select id="student_id" name="student_id" required @if($absentStudents->count() === 0) disabled @endif class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-white @if($absentStudents->count() === 0) bg-gray-100 dark:bg-gray-600 @endif">
                            <option value="">Choose a student...</option>
                            @foreach($absentStudents as $student)
                                <option value="{{ $student->id }}">{{ $student->full_name }} ({{ $student->student_id }})</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label for="started_at" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Started At</label>
                        <input type="datetime-local" id="started_at" name="started_at" @if($absentStudents->count() === 0) disabled @endif class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-white @if($absentStudents->count() === 0) bg-gray-100 dark:bg-gray-600 @endif">
                    </div>
                    <div>
                        <label for="completed_at" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Completed At</label>
                        <input type="datetime-local" id="completed_at" name="completed_at" @if($absentStudents->count() === 0) disabled @endif class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-white @if($absentStudents->count() === 0) bg-gray-100 dark:bg-gray-600 @endif">
                    </div>
                </div>
            </form>
        </div>

        <!-- Questions Section -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl border border-gray-200 dark:border-gray-700 overflow-hidden">
            <div class="bg-gradient-to-r from-gray-50 to-gray-100 dark:from-gray-700 dark:to-gray-800 px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                <h3 class="text-lg sm:text-xl font-bold text-gray-900 dark:text-white">Question-wise Answer Entry</h3>
                <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">Enter answers for each question in the exam</p>
            </div>
            
            <div class="p-6">
                @if($exam->questions->count() > 0)
                    <div class="space-y-6">
                        @foreach($exam->questions as $index => $question)
                            <div class="border border-gray-200 dark:border-gray-600 rounded-xl p-3 sm:p-4 bg-gray-50 dark:bg-gray-700/50">
                                @if($question->question_type === 'mcq')
                                    <!-- MCQ Layout: Single Line with Question Number, Text, and Options -->
                                    <div class="flex flex-col sm:flex-row sm:items-center gap-2 sm:gap-3">
                                        <!-- Question Number -->
                                        <div class="flex-shrink-0">
                                            <span class="inline-flex items-center justify-center w-6 h-6 sm:w-8 sm:h-8 rounded-full text-xs sm:text-sm font-bold bg-gradient-to-r from-indigo-500 to-purple-600 text-white shadow-lg">
                                                {{ $index + 1 }}
                                            </span>
                                        </div>
                                        
                                        <!-- Question Text -->
                                        <div class="flex-1 min-w-0">
                                            <span class="text-sm sm:text-base text-gray-900 dark:text-white font-medium leading-tight">{{ $question->question_text }}</span>
                                        </div>
                                        
                                        <!-- Answer Options -->
                                        <!-- Debug: Correct Answer = {{ $question->correct_answer }} -->
                                        <div class="grid grid-cols-4 gap-2 sm:gap-3 flex-shrink-0 w-full max-w-2xl">
                                            @if($question->option_a)
                                                <div class="flex items-center gap-1 sm:gap-2 p-2 rounded-lg transition-all duration-200
                                                    @if(strtoupper($question->correct_answer) === 'A' || $question->correct_answer === '1' || $question->correct_answer === 1)
                                                        bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 shadow-sm
                                                    @else
                                                        hover:bg-gray-50 dark:hover:bg-gray-700/50
                                                    @endif">
                                                    <label class="flex items-center justify-center w-6 h-6 sm:w-8 sm:h-8 border rounded cursor-pointer transition-colors
                                                        @if(strtoupper($question->correct_answer) === 'A' || $question->correct_answer === '1' || $question->correct_answer === 1)
                                                            border-green-500 bg-green-100 dark:bg-green-800/30 hover:bg-green-200 dark:hover:bg-green-700/40 shadow-md
                                                        @else
                                                            border-gray-300 dark:border-gray-600 hover:bg-gray-50 dark:hover:bg-gray-600
                                                        @endif">
                                                        <input type="radio" name="answers[{{ $question->id }}]" value="A" class="sr-only">
                                                        <span class="font-bold text-xs sm:text-sm
                                                            @if(strtoupper($question->correct_answer) === 'A' || $question->correct_answer === '1' || $question->correct_answer === 1)
                                                                text-green-800 dark:text-green-200
                                                            @else
                                                                text-gray-900 dark:text-white
                                                            @endif">a</span>
                                                    </label>
                                                    <span class="text-xs sm:text-sm break-words font-medium
                                                        @if(strtoupper($question->correct_answer) === 'A' || $question->correct_answer === '1' || $question->correct_answer === 1)
                                                            text-green-800 dark:text-green-200
                                                        @else
                                                            text-gray-600 dark:text-gray-400
                                                        @endif">{{ $question->option_a }}</span>
                                                </div>
                                            @else
                                                <div></div>
                                            @endif
                                            @if($question->option_b)
                                                <div class="flex items-center gap-1 sm:gap-2 p-2 rounded-lg transition-all duration-200
                                                    @if(strtoupper($question->correct_answer) === 'B' || $question->correct_answer === '2' || $question->correct_answer === 2)
                                                        bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 shadow-sm
                                                    @else
                                                        hover:bg-gray-50 dark:hover:bg-gray-700/50
                                                    @endif">
                                                    <label class="flex items-center justify-center w-6 h-6 sm:w-8 sm:h-8 border rounded cursor-pointer transition-colors
                                                        @if(strtoupper($question->correct_answer) === 'B' || $question->correct_answer === '2' || $question->correct_answer === 2)
                                                            border-green-500 bg-green-100 dark:bg-green-800/30 hover:bg-green-200 dark:hover:bg-green-700/40 shadow-md
                                                        @else
                                                            border-gray-300 dark:border-gray-600 hover:bg-gray-50 dark:hover:bg-gray-600
                                                        @endif">
                                                        <input type="radio" name="answers[{{ $question->id }}]" value="B" class="sr-only">
                                                        <span class="font-bold text-xs sm:text-sm
                                                            @if(strtoupper($question->correct_answer) === 'B' || $question->correct_answer === '2' || $question->correct_answer === 2)
                                                                text-green-800 dark:text-green-200
                                                            @else
                                                                text-gray-900 dark:text-white
                                                            @endif">b</span>
                                                    </label>
                                                    <span class="text-xs sm:text-sm break-words font-medium
                                                        @if(strtoupper($question->correct_answer) === 'B' || $question->correct_answer === '2' || $question->correct_answer === 2)
                                                            text-green-800 dark:text-green-200
                                                        @else
                                                            text-gray-600 dark:text-gray-400
                                                        @endif">{{ $question->option_b }}</span>
                                                </div>
                                            @else
                                                <div></div>
                                            @endif
                                            @if($question->option_c)
                                                <div class="flex items-center gap-1 sm:gap-2 p-2 rounded-lg transition-all duration-200
                                                    @if(strtoupper($question->correct_answer) === 'C' || $question->correct_answer === '3' || $question->correct_answer === 3)
                                                        bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 shadow-sm
                                                    @else
                                                        hover:bg-gray-50 dark:hover:bg-gray-700/50
                                                    @endif">
                                                    <label class="flex items-center justify-center w-6 h-6 sm:w-8 sm:h-8 border rounded cursor-pointer transition-colors
                                                        @if(strtoupper($question->correct_answer) === 'C' || $question->correct_answer === '3' || $question->correct_answer === 3)
                                                            border-green-500 bg-green-100 dark:bg-green-800/30 hover:bg-green-200 dark:hover:bg-green-700/40 shadow-md
                                                        @else
                                                            border-gray-300 dark:border-gray-600 hover:bg-gray-50 dark:hover:bg-gray-600
                                                        @endif">
                                                        <input type="radio" name="answers[{{ $question->id }}]" value="C" class="sr-only">
                                                        <span class="font-bold text-xs sm:text-sm
                                                            @if(strtoupper($question->correct_answer) === 'C' || $question->correct_answer === '3' || $question->correct_answer === 3)
                                                                text-green-800 dark:text-green-200
                                                            @else
                                                                text-gray-900 dark:text-white
                                                            @endif">c</span>
                                                    </label>
                                                    <span class="text-xs sm:text-sm break-words font-medium
                                                        @if(strtoupper($question->correct_answer) === 'C' || $question->correct_answer === '3' || $question->correct_answer === 3)
                                                            text-green-800 dark:text-green-200
                                                        @else
                                                            text-gray-600 dark:text-gray-400
                                                        @endif">{{ $question->option_c }}</span>
                                                </div>
                                            @else
                                                <div></div>
                                            @endif
                                            @if($question->option_d)
                                                <div class="flex items-center gap-1 sm:gap-2 p-2 rounded-lg transition-all duration-200
                                                    @if(strtoupper($question->correct_answer) === 'D' || $question->correct_answer === '4' || $question->correct_answer === 4)
                                                        bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 shadow-sm
                                                    @else
                                                        hover:bg-gray-50 dark:hover:bg-gray-700/50
                                                    @endif">
                                                    <label class="flex items-center justify-center w-6 h-6 sm:w-8 sm:h-8 border rounded cursor-pointer transition-colors
                                                        @if(strtoupper($question->correct_answer) === 'D' || $question->correct_answer === '4' || $question->correct_answer === 4)
                                                            border-green-500 bg-green-100 dark:bg-green-800/30 hover:bg-green-200 dark:hover:bg-green-700/40 shadow-md
                                                        @else
                                                            border-gray-300 dark:border-gray-600 hover:bg-gray-50 dark:hover:bg-gray-600
                                                        @endif">
                                                        <input type="radio" name="answers[{{ $question->id }}]" value="D" class="sr-only">
                                                        <span class="font-bold text-xs sm:text-sm
                                                            @if(strtoupper($question->correct_answer) === 'D' || $question->correct_answer === '4' || $question->correct_answer === 4)
                                                                text-green-800 dark:text-green-200
                                                            @else
                                                                text-gray-900 dark:text-white
                                                            @endif">d</span>
                                                    </label>
                                                    <span class="text-xs sm:text-sm break-words font-medium
                                                        @if(strtoupper($question->correct_answer) === 'D' || $question->correct_answer === '4' || $question->correct_answer === 4)
                                                            text-green-800 dark:text-green-200
                                                        @else
                                                            text-gray-600 dark:text-gray-400
                                                        @endif">{{ $question->option_d }}</span>
                                                </div>
                                            @else
                                                <div></div>
                                            @endif
                                        </div>
                                        
                                    </div>
                                @else
                                    <!-- Constructed Question Layout: Single Line with Question Number, Text, and Answer Field -->
                                    <div class="flex flex-col sm:flex-row sm:items-center gap-2 sm:gap-3">
                                        <!-- Question Number -->
                                        <div class="flex-shrink-0">
                                            <span class="inline-flex items-center justify-center w-6 h-6 sm:w-8 sm:h-8 rounded-full text-xs sm:text-sm font-bold bg-gradient-to-r from-indigo-500 to-purple-600 text-white shadow-lg">
                                                {{ $index + 1 }}
                                            </span>
                                        </div>
                                        
                                        <!-- Question Text -->
                                        <div class="flex-1 min-w-0">
                                            <span class="text-sm sm:text-base text-gray-900 dark:text-white font-medium leading-tight">{{ $question->question_text }}</span>
                                        </div>
                                        
                                        <!-- Answer Field -->
                                        <div class="flex items-center gap-2 flex-shrink-0">
                                            <span class="text-xs sm:text-sm font-medium text-gray-700 dark:text-gray-300 whitespace-nowrap">Answer:</span>
                                            <textarea id="answer_{{ $question->id }}" 
                                                      name="answers[{{ $question->id }}]" 
                                                      rows="1" 
                                                      class="w-24 sm:w-32 px-2 py-1 border border-gray-300 dark:border-gray-600 rounded focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-white resize-none text-xs sm:text-sm"
                                                      placeholder="Answer..."></textarea>
                                            @if($question->min_words)
                                                <span class="text-xs text-gray-500 dark:text-gray-400 whitespace-nowrap">Min {{ $question->min_words }}w</span>
                                            @endif
                                        </div>
                                        
                                    </div>
                                @endif
                                
                            </div>
                        @endforeach
                    </div>

                    <!-- Submit Button -->
                    <div class="mt-8 flex items-center justify-end space-x-4 pt-6 border-t border-gray-200 dark:border-gray-700">
                        <button type="button" onclick="resetForm()" @if($absentStudents->count() === 0) disabled @endif class="px-6 py-3 text-sm font-semibold text-gray-700 bg-gray-100 hover:bg-gray-200 border border-gray-300 rounded-xl transition-all duration-200 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-300 dark:hover:bg-gray-600 @if($absentStudents->count() === 0) opacity-50 cursor-not-allowed @endif">
                            Reset Form
                        </button>
                        <button type="submit" form="detailedResultForm" @if($absentStudents->count() === 0) disabled @endif class="px-8 py-3 text-sm font-semibold text-white bg-gradient-to-r from-indigo-500 to-indigo-600 hover:from-indigo-600 hover:to-indigo-700 rounded-xl shadow-lg hover:shadow-xl transition-all duration-200 transform hover:-translate-y-0.5 @if($absentStudents->count() === 0) opacity-50 cursor-not-allowed @endif">
                            Save Detailed Result
                        </button>
                    </div>
                @else
                    <div class="text-center py-12">
                        <svg class="mx-auto h-16 w-16 text-gray-400 dark:text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                        </svg>
                        <h3 class="mt-4 text-lg font-semibold text-gray-900 dark:text-white">No questions found</h3>
                        <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">This exam doesn't have any questions assigned yet.</p>
                        <div class="mt-6">
                            <a href="{{ route('partner.exams.assign-questions', $exam) }}" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-semibold rounded-xl text-white bg-gradient-to-r from-indigo-500 to-indigo-600 hover:from-indigo-600 hover:to-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                Assign Questions
                            </a>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('detailedResultForm');
    const studentSelect = document.getElementById('student_id');
    const startedAtInput = document.getElementById('started_at');
    const completedAtInput = document.getElementById('completed_at');

    // Set default times
    const now = new Date();
    const startedTime = new Date(now.getTime() - (2 * 60 * 60 * 1000)); // 2 hours ago
    startedAtInput.value = startedTime.toISOString().slice(0, 16);
    completedAtInput.value = now.toISOString().slice(0, 16);

    // Form submission
    form.addEventListener('submit', function(e) {
        e.preventDefault();
        
        if (!studentSelect.value) {
            alert('Please select a student');
            return;
        }

        const formData = new FormData(form);
        
        // Show loading state
        const submitBtn = form.querySelector('button[type="submit"]');
        const originalText = submitBtn.textContent;
        submitBtn.textContent = 'Saving...';
        submitBtn.disabled = true;

        // Submit the form
        fetch('{{ route("partner.exams.result-entry.store", $exam) }}', {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Show success message
                alert('Result saved successfully!');
                // Redirect to results page
                window.location.href = data.redirect_url;
            } else {
                alert('Error: ' + (data.message || 'Failed to save result'));
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error saving result. Please try again.');
        })
        .finally(() => {
            submitBtn.textContent = originalText;
            submitBtn.disabled = false;
        });
    });

    // Auto-save functionality (optional)
    let autoSaveTimeout;
    function autoSave() {
        clearTimeout(autoSaveTimeout);
        autoSaveTimeout = setTimeout(() => {
            // Auto-save logic can be implemented here
            console.log('Auto-saving...');
        }, 5000); // Auto-save after 5 seconds of inactivity
    }

    // Add auto-save listeners
    studentSelect.addEventListener('change', autoSave);
    startedAtInput.addEventListener('change', autoSave);
    completedAtInput.addEventListener('change', autoSave);
    
    // Add auto-save for all answer inputs
    document.querySelectorAll('input[name^="answers"], textarea[name^="answers"]').forEach(input => {
        input.addEventListener('change', autoSave);
    });
});

function resetForm() {
    if (confirm('Are you sure you want to reset the form? All entered data will be lost.')) {
        document.getElementById('detailedResultForm').reset();
        
        // Reset times to defaults
        const now = new Date();
        const startedTime = new Date(now.getTime() - (2 * 60 * 60 * 1000));
        document.getElementById('started_at').value = startedTime.toISOString().slice(0, 16);
        document.getElementById('completed_at').value = now.toISOString().slice(0, 16);
    }
}

// Keyboard shortcuts
document.addEventListener('keydown', function(e) {
    // Ctrl+S to save
    if (e.ctrlKey && e.key === 's') {
        e.preventDefault();
        document.getElementById('detailedResultForm').dispatchEvent(new Event('submit'));
    }
    
    // Ctrl+R to reset
    if (e.ctrlKey && e.key === 'r') {
        e.preventDefault();
        resetForm();
    }
});
</script>
@endsection
