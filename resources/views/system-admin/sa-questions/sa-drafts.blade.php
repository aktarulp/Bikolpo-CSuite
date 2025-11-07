@extends('layouts.partner-layout')

@section('title', 'Draft Questions - Review & Publish')

@section('content')
<style>
.error-highlight {
    border-color: #ef4444 !important;
    box-shadow: 0 0 0 3px rgba(239, 68, 68, 0.1) !important;
    background-color: #fef2f2 !important;
}
.error-highlight:focus {
    border-color: #ef4444 !important;
    box-shadow: 0 0 0 3px rgba(239, 68, 68, 0.2) !important;
}
</style>
<div class="space-y-6">
    <!-- Page Header -->
    <div class="bg-blue-50 border border-blue-200 rounded-lg p-6">
        <div class="flex justify-between items-center mb-6">
            <div class="text-left">
                <h1 class="text-3xl font-bold text-gray-900">Draft Questions</h1>
                <p class="text-gray-600">Review and publish your uploaded questions</p>
            </div>
            
            <div class="flex gap-3">
                <a href="{{ route('partner.questions.bulk-upload') }}" 
                   class="bg-green-600 hover:bg-green-700 text-white px-4 py-2.5 rounded-lg transition-colors duration-200 flex items-center gap-2.5">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                    </svg>
                    Upload More Questions
                </a>
                <a href="{{ route('partner.questions.all') }}" 
                   class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2.5 rounded-lg transition-colors duration-200 flex items-center gap-2.5">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    Back to Questions
                </a>
            </div>
        </div>
        
        <!-- Success Message -->
        @if (session('success'))
            <div class="bg-green-100 border border-green-300 rounded-lg p-4">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-green-400" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm font-medium text-green-800">{{ session('success') }}</p>
                    </div>
                </div>
            </div>
        @endif
    </div>

    <!-- Draft Questions List -->
    <div class="bg-white border border-gray-200 rounded-lg">
        <div class="px-6 py-4 border-b border-gray-200">
            <div class="flex justify-between items-center">
                <h2 class="text-lg font-medium text-gray-900">
                    Draft Questions ({{ $draftQuestions->total() }})
                </h2>
                <div class="flex gap-2">
                    <button id="selectAllBtn" class="text-sm text-blue-600 hover:text-blue-800 font-medium">
                        Select All
                    </button>
                    <button id="deselectAllBtn" class="text-sm text-gray-600 hover:text-gray-800 font-medium hidden">
                        Deselect All
                    </button>
                </div>
            </div>
        </div>

        @if($draftQuestions->count() > 0)
            <form id="draftsForm">
                @csrf
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    <input type="checkbox" id="selectAll" class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Question</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Options</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Course</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Subject</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Topic</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($draftQuestions as $question)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <input type="checkbox" name="selected_questions[]" value="{{ $question->id }}" class="question-checkbox rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="text-sm text-gray-900 max-w-xs">
                                            {{ Str::limit($question->question_text, 100) }}
                                        </div>
                                        <div class="text-xs text-gray-500 mt-1">
                                            Correct: <span class="font-medium">{{ strtoupper($question->correct_answer) }}</span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="text-xs text-gray-600 space-y-1">
                                            <div><strong>A:</strong> {{ Str::limit($question->option_a, 30) }}</div>
                                            <div><strong>B:</strong> {{ Str::limit($question->option_b, 30) }}</div>
                                            <div><strong>C:</strong> {{ Str::limit($question->option_c, 30) }}</div>
                                            <div><strong>D:</strong> {{ Str::limit($question->option_d, 30) }}</div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <select name="questions[{{ $question->id }}][course_id]" class="course-select block w-full text-sm border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500">
                                            <option value="">Select Course</option>
                                            @foreach($courses as $course)
                                                <option value="{{ $course->id }}" {{ $question->course_id == $course->id ? 'selected' : '' }}>
                                                    {{ $course->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td class="px-6 py-4">
                                        <select name="questions[{{ $question->id }}][subject_id]" class="subject-select block w-full text-sm border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500" disabled data-selected="{{ $question->subject_id ?? '' }}">
                                            <option value="">Select Subject</option>
                                        </select>
                                    </td>
                                    <td class="px-6 py-4">
                                        <select name="questions[{{ $question->id }}][topic_id]" class="topic-select block w-full text-sm border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500" disabled data-selected="{{ $question->topic_id ?? '' }}">
                                            <option value="">Select Topic</option>
                                        </select>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex gap-2">
                                            <button type="button" 
                                                    onclick="publishSingleQuestion({{ $question->id }})"
                                                    class="bg-green-600 hover:bg-green-700 text-white px-3 py-1.5 rounded text-xs font-medium transition-colors duration-200">
                                                Publish
                                            </button>
                                            <button type="button" 
                                                    onclick="deleteSingleQuestion({{ $question->id }})"
                                                    class="bg-red-600 hover:bg-red-700 text-white px-3 py-1.5 rounded text-xs font-medium transition-colors duration-200">
                                                Delete
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Action Buttons -->
                <div class="px-6 py-4 bg-gray-50 border-t border-gray-200">
                    <div class="flex justify-between items-center">
                        <div class="text-sm text-gray-600">
                            <span id="selectedCount">0</span> questions selected
                        </div>
                        <div class="flex gap-3">
                            <button type="button" id="deleteSelectedBtn" class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg transition-colors duration-200 text-sm font-medium hidden">
                                Delete Selected
                            </button>
                            <button type="submit" id="publishBtn" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg transition-colors duration-200 text-sm font-medium hidden">
                                Publish Selected Questions
                            </button>
                        </div>
                    </div>
                </div>
            </form>

            <!-- Pagination -->
            @if($draftQuestions->hasPages())
                <div class="px-6 py-4 border-t border-gray-200">
                    {{ $draftQuestions->links() }}
                </div>
            @endif
        @else
            <div class="px-6 py-12 text-center">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
                <h3 class="mt-2 text-sm font-medium text-gray-900">No draft questions</h3>
                <p class="mt-1 text-sm text-gray-500">Get started by uploading some questions.</p>
                <div class="mt-6">
                    <a href="{{ route('partner.questions.bulk-upload') }}" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700">
                        Upload Questions
                    </a>
                </div>
            </div>
        @endif
    </div>
</div>

<!-- Success Modal -->
<div id="successModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <div class="mt-3 text-center">
            <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-green-100">
                <svg class="h-6 w-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                </svg>
            </div>
            <h3 class="text-lg font-medium text-gray-900 mt-4">Success!</h3>
            <div class="mt-2 px-7 py-3">
                <p class="text-sm text-gray-500" id="successMessage"></p>
            </div>
            <div class="items-center px-4 py-3">
                <button id="closeSuccessModal" class="px-4 py-2 bg-blue-500 text-white text-base font-medium rounded-md w-full shadow-sm hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-300">
                    Close
                </button>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const selectAll = document.getElementById('selectAll');
    const selectAllBtn = document.getElementById('selectAllBtn');
    const deselectAllBtn = document.getElementById('deselectAllBtn');
    const questionCheckboxes = document.querySelectorAll('.question-checkbox');
    const selectedCount = document.getElementById('selectedCount');
    const publishBtn = document.getElementById('publishBtn');
    const deleteSelectedBtn = document.getElementById('deleteSelectedBtn');
    const draftsForm = document.getElementById('draftsForm');
    const successModal = document.getElementById('successModal');
    const successMessage = document.getElementById('successMessage');
    const closeSuccessModal = document.getElementById('closeSuccessModal');

    // Course, Subject, Topic dropdowns
    const courseSelects = document.querySelectorAll('.course-select');
    const subjectSelects = document.querySelectorAll('.subject-select');
    const topicSelects = document.querySelectorAll('.topic-select');

    // Initialize subject and topic dropdowns
    courseSelects.forEach((courseSelect, index) => {
        const subjectSelect = subjectSelects[index];
        const topicSelect = topicSelects[index];
        
        // Initialize dropdowns if question already has values
        if (courseSelect.value) {
            // Load subjects for the selected course
            const courseId = courseSelect.value;
            fetch(`/partner/questions/subjects?course_id=${courseId}`)
                .then(response => response.json())
                .then(subjects => {
                    subjects.forEach(subject => {
                        const option = document.createElement('option');
                        option.value = subject.id;
                        option.textContent = subject.name;
                        if (subject.id == subjectSelect.dataset.selected) {
                            option.selected = true;
                        }
                        subjectSelect.appendChild(option);
                    });
                    subjectSelect.disabled = false;
                    
                    // If subject is already selected, load topics
                    if (subjectSelect.value) {
                        const subjectId = subjectSelect.value;
                        fetch(`/partner/questions/topics?subject_id=${subjectId}`)
                            .then(response => response.json())
                            .then(topics => {
                                topics.forEach(topic => {
                                    const option = document.createElement('option');
                                    option.value = topic.id;
                                    option.textContent = topic.name;
                                    if (topic.id == topicSelect.dataset.selected) {
                                        option.selected = true;
                                    }
                                    topicSelect.appendChild(option);
                                });
                                topicSelect.disabled = false;
                            });
                    }
                });
        }
        
        // Load subjects when course changes
        courseSelect.addEventListener('change', function() {
            const courseId = this.value;
            const subjectSelect = this.closest('tr').querySelector('.subject-select');
            const topicSelect = this.closest('tr').querySelector('.topic-select');
            
            // Clear error highlights
            this.classList.remove('error-highlight');
            subjectSelect.classList.remove('error-highlight');
            topicSelect.classList.remove('error-highlight');
            
            // Reset subject and topic
            subjectSelect.innerHTML = '<option value="">Select Subject</option>';
            topicSelect.innerHTML = '<option value="">Select Topic</option>';
            subjectSelect.disabled = !courseId;
            topicSelect.disabled = true;
            
            if (courseId) {
                console.log('Fetching subjects for course:', courseId);
                fetch(`/partner/questions/subjects?course_id=${courseId}`)
                    .then(response => {
                        console.log('Response status:', response.status);
                        return response.json();
                    })
                    .then(subjects => {
                        console.log('Subjects received:', subjects);
                        subjects.forEach(subject => {
                            const option = document.createElement('option');
                            option.value = subject.id;
                            option.textContent = subject.name;
                            subjectSelect.appendChild(option);
                        });
                        subjectSelect.disabled = false;
                    })
                    .catch(error => {
                        console.error('Error fetching subjects:', error);
                        subjectSelect.innerHTML = '<option value="">Error loading subjects</option>';
                    });
            }
        });
        
        // Load topics when subject changes
        subjectSelect.addEventListener('change', function() {
            const subjectId = this.value;
            const topicSelect = this.closest('tr').querySelector('.topic-select');
            
            // Clear error highlights
            this.classList.remove('error-highlight');
            topicSelect.classList.remove('error-highlight');
            
            // Reset topic
            topicSelect.innerHTML = '<option value="">Select Topic</option>';
            topicSelect.disabled = !subjectId;
            
            if (subjectId) {
                console.log('Fetching topics for subject:', subjectId);
                fetch(`/partner/questions/topics?subject_id=${subjectId}`)
                    .then(response => {
                        console.log('Response status:', response.status);
                        return response.json();
                    })
                    .then(topics => {
                        console.log('Topics received:', topics);
                        topics.forEach(topic => {
                            const option = document.createElement('option');
                            option.value = topic.id;
                            option.textContent = topic.name;
                            topicSelect.appendChild(option);
                        });
                        topicSelect.disabled = false;
                    })
                    .catch(error => {
                        console.error('Error fetching topics:', error);
                        topicSelect.innerHTML = '<option value="">Error loading topics</option>';
                    });
            }
        });
    });

    // Select all functionality
    selectAll.addEventListener('change', function() {
        questionCheckboxes.forEach(checkbox => {
            checkbox.checked = this.checked;
        });
        updateUI();
    });

    selectAllBtn.addEventListener('click', function() {
        selectAll.checked = true;
        questionCheckboxes.forEach(checkbox => {
            checkbox.checked = true;
        });
        updateUI();
    });

    deselectAllBtn.addEventListener('click', function() {
        selectAll.checked = false;
        questionCheckboxes.forEach(checkbox => {
            checkbox.checked = false;
        });
        updateUI();
    });

    // Individual checkbox change
    questionCheckboxes.forEach(checkbox => {
        checkbox.addEventListener('change', updateUI);
    });

    function updateUI() {
        const checkedCount = document.querySelectorAll('.question-checkbox:checked').length;
        const totalCount = questionCheckboxes.length;
        
        selectedCount.textContent = checkedCount;
        
        if (checkedCount > 0) {
            publishBtn.classList.remove('hidden');
            deleteSelectedBtn.classList.remove('hidden');
            selectAllBtn.classList.add('hidden');
            deselectAllBtn.classList.remove('hidden');
        } else {
            publishBtn.classList.add('hidden');
            deleteSelectedBtn.classList.add('hidden');
            selectAllBtn.classList.remove('hidden');
            deselectAllBtn.classList.add('hidden');
        }
        
        selectAll.checked = checkedCount === totalCount;
        selectAll.indeterminate = checkedCount > 0 && checkedCount < totalCount;
    }

    // Form submission
    draftsForm.addEventListener('submit', function(e) {
        e.preventDefault();
        
        const selectedQuestions = document.querySelectorAll('.question-checkbox:checked');
        if (selectedQuestions.length === 0) {
            alert('Please select questions to publish.');
            return;
        }

        const questions = [];
        
        selectedQuestions.forEach(checkbox => {
            const questionId = checkbox.value;
            const row = checkbox.closest('tr');
            
            questions.push({
                id: questionId,
                course_id: row.querySelector('.course-select').value,
                subject_id: row.querySelector('.subject-select').value,
                topic_id: row.querySelector('.topic-select').value
            });
        });
        
        // Clear previous error highlights
        document.querySelectorAll('.error-highlight').forEach(el => {
            el.classList.remove('error-highlight');
        });
        
        // Validate required fields
        const invalidQuestions = questions.filter(q => !q.course_id || !q.subject_id);
        if (invalidQuestions.length > 0) {
            // Highlight invalid rows
            invalidQuestions.forEach(q => {
                const row = document.querySelector(`input[value="${q.id}"]`).closest('tr');
                const courseSelect = row.querySelector('.course-select');
                const subjectSelect = row.querySelector('.subject-select');
                
                if (!q.course_id) {
                    courseSelect.classList.add('error-highlight');
                }
                if (!q.subject_id) {
                    subjectSelect.classList.add('error-highlight');
                }
            });
            
            const questionNumbers = invalidQuestions.map((q, index) => {
                const row = document.querySelector(`input[value="${q.id}"]`).closest('tr');
                const questionText = row.querySelector('td:nth-child(2)').textContent.trim();
                return `${index + 1}. "${questionText.substring(0, 50)}..."`;
            }).join('\n');
            
            alert(`Please select course and subject for the following questions:\n\n${questionNumbers}\n\nCourse and Subject are required for publishing.`);
            return;
        }

        // Submit form
        fetch('{{ route("partner.questions.drafts.update") }}', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({ questions: questions })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                successMessage.textContent = data.message;
                successModal.classList.remove('hidden');
                
                // Remove published questions from the list
                selectedQuestions.forEach(checkbox => {
                    checkbox.closest('tr').remove();
                });
                
                updateUI();
            } else {
                alert('Error: ' + data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('An error occurred while publishing questions.');
        });
    });

    // Delete selected questions
    deleteSelectedBtn.addEventListener('click', function() {
        if (!confirm('Are you sure you want to delete the selected questions? This action cannot be undone.')) {
            return;
        }

        const selectedQuestions = document.querySelectorAll('.question-checkbox:checked');
        const questionIds = Array.from(selectedQuestions).map(checkbox => checkbox.value);
        
        fetch('{{ route("partner.questions.drafts.delete") }}', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({ question_ids: questionIds })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Remove deleted questions from the list
                selectedQuestions.forEach(checkbox => {
                    checkbox.closest('tr').remove();
                });
                
                updateUI();
                alert(data.message);
            } else {
                alert('Error: ' + data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('An error occurred while deleting questions.');
        });
    });

    // Close success modal
    closeSuccessModal.addEventListener('click', function() {
        successModal.classList.add('hidden');
        location.reload(); // Refresh to show updated list
    });

    // Initialize UI
    updateUI();

    // Single question publish function
    window.publishSingleQuestion = function(questionId) {
        const row = document.querySelector(`input[value="${questionId}"]`).closest('tr');
        const courseSelect = row.querySelector('.course-select');
        const subjectSelect = row.querySelector('.subject-select');
        const topicSelect = row.querySelector('.topic-select');
        
        if (!courseSelect.value || !subjectSelect.value) {
            const questionText = row.querySelector('td:nth-child(2)').textContent.trim();
            alert(`Please select course and subject for this question:\n\n"${questionText.substring(0, 100)}..."\n\nCourse and Subject are required for publishing.`);
            return;
        }
        
        const questionData = {
            id: questionId,
            course_id: courseSelect.value,
            subject_id: subjectSelect.value,
            topic_id: topicSelect.value
        };
        
        fetch('{{ route("partner.questions.drafts.update") }}', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({ questions: [questionData] })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Remove the published question from the list
                row.remove();
                updateUI();
                alert('Question published successfully!');
            } else {
                alert('Error: ' + data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('An error occurred while publishing the question.');
        });
    };

    // Single question delete function
    window.deleteSingleQuestion = function(questionId) {
        if (!confirm('Are you sure you want to delete this question? This action cannot be undone.')) {
            return;
        }
        
        fetch('{{ route("partner.questions.drafts.delete") }}', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({ question_ids: [questionId] })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Remove the deleted question from the list
                const row = document.querySelector(`input[value="${questionId}"]`).closest('tr');
                row.remove();
                updateUI();
                alert('Question deleted successfully!');
            } else {
                alert('Error: ' + data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('An error occurred while deleting the question.');
        });
    };
});
</script>
@endsection
