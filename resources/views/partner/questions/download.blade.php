@extends('layouts.partner-layout')

@section('title', 'Question Download')

@section('content')
<div class="min-h-screen bg-gray-50 dark:bg-gray-900">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Header -->
        <div class="mb-8">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Question Download</h1>
                    <p class="mt-2 text-gray-600 dark:text-gray-400">Download questions with paper parameter for offline use</p>
                </div>
                <div class="flex items-center space-x-3">
                    <a href="{{ route('partner.questions.all') }}" 
                       class="inline-flex items-center px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors duration-200">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                        Back to Questions
                    </a>
                </div>
            </div>
        </div>

        <!-- Download Form -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700">
            <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                <h2 class="text-lg font-semibold text-gray-900 dark:text-white">Download Questions</h2>
                <p class="text-sm text-gray-600 dark:text-gray-400">Select filters and paper parameter to download questions</p>
            </div>

            <form action="{{ route('partner.questions.download.process') }}" method="POST" class="p-6">
                @csrf
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Exam Selection -->
                    <div class="md:col-span-2">
                        <label for="exam_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Select Exam (Optional)
                        </label>
                        <select name="exam_id" id="exam_id"
                                class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primaryGreen focus:border-primaryGreen dark:bg-gray-700 dark:text-white">
                            <option value="">Choose an exam to auto-fill paper parameter</option>
                            @foreach($exams as $exam)
                                <option value="{{ $exam->id }}" {{ old('exam_id') == $exam->id ? 'selected' : '' }}>
                                    {{ $exam->title }} ({{ $exam->exam_type }}) - {{ $exam->start_time->format('M d, Y') }}
                                </option>
                            @endforeach
                        </select>
                        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                            Selecting an exam will automatically populate the paper parameter field.
                        </p>
                        @error('exam_id')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Course Selection -->
                    <div>
                        <label for="course_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Course <span class="text-red-500">*</span>
                        </label>
                        <select name="course_id" id="course_id" required
                                class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primaryGreen focus:border-primaryGreen dark:bg-gray-700 dark:text-white">
                            <option value="">Select a course</option>
                            @foreach($courses as $course)
                                <option value="{{ $course->id }}" {{ old('course_id') == $course->id ? 'selected' : '' }}>
                                    {{ $course->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('course_id')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Subject Selection -->
                    <div>
                        <label for="subject_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Subject
                        </label>
                        <select name="subject_id" id="subject_id"
                                class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primaryGreen focus:border-primaryGreen dark:bg-gray-700 dark:text-white">
                            <option value="">All subjects</option>
                            @foreach($subjects as $subject)
                                <option value="{{ $subject->id }}" {{ old('subject_id') == $subject->id ? 'selected' : '' }}>
                                    {{ $subject->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('subject_id')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Topic Selection -->
                    <div>
                        <label for="topic_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Topic
                        </label>
                        <select name="topic_id" id="topic_id"
                                class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primaryGreen focus:border-primaryGreen dark:bg-gray-700 dark:text-white">
                            <option value="">All topics</option>
                            @foreach($topics as $topic)
                                <option value="{{ $topic->id }}" {{ old('topic_id') == $topic->id ? 'selected' : '' }}>
                                    {{ $topic->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('topic_id')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Question Type Selection -->
                    <div>
                        <label for="question_type_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Question Type
                        </label>
                        <select name="question_type_id" id="question_type_id"
                                class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primaryGreen focus:border-primaryGreen dark:bg-gray-700 dark:text-white">
                            <option value="">All question types</option>
                            @foreach($questionTypes as $questionType)
                                <option value="{{ $questionType->q_type_id }}" {{ old('question_type_id') == $questionType->q_type_id ? 'selected' : '' }}>
                                    {{ $questionType->q_type_name }}
                                </option>
                            @endforeach
                        </select>
                        @error('question_type_id')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Paper Parameter -->
                    <div class="md:col-span-2">
                        <label for="paper_parameter" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Paper Parameter <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="paper_parameter" id="paper_parameter" required
                               value="{{ old('paper_parameter') }}"
                               placeholder="e.g., Mid Term 2024, Final Exam, Practice Test"
                               class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primaryGreen focus:border-primaryGreen dark:bg-gray-700 dark:text-white">
                        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                            This parameter will be included in the filename and as a header in the downloaded file.
                        </p>
                        @error('paper_parameter')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Download Format -->
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-3">
                            Download Format <span class="text-red-500">*</span>
                        </label>
                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                            <label class="relative flex items-center p-4 border border-gray-300 dark:border-gray-600 rounded-lg cursor-pointer hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors duration-200">
                                <input type="radio" name="format" value="csv" {{ old('format', 'csv') == 'csv' ? 'checked' : '' }}
                                       class="sr-only">
                                <div class="flex items-center">
                                    <div class="w-4 h-4 border-2 border-gray-300 dark:border-gray-600 rounded-full mr-3 flex items-center justify-center">
                                        <div class="w-2 h-2 bg-primaryGreen rounded-full opacity-0 transition-opacity duration-200"></div>
                                    </div>
                                    <div>
                                        <div class="text-sm font-medium text-gray-900 dark:text-white">CSV</div>
                                        <div class="text-xs text-gray-500 dark:text-gray-400">Comma-separated values</div>
                                    </div>
                                </div>
                            </label>

                            <label class="relative flex items-center p-4 border border-gray-300 dark:border-gray-600 rounded-lg cursor-pointer hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors duration-200">
                                <input type="radio" name="format" value="excel" {{ old('format') == 'excel' ? 'checked' : '' }}
                                       class="sr-only">
                                <div class="flex items-center">
                                    <div class="w-4 h-4 border-2 border-gray-300 dark:border-gray-600 rounded-full mr-3 flex items-center justify-center">
                                        <div class="w-2 h-2 bg-primaryGreen rounded-full opacity-0 transition-opacity duration-200"></div>
                                    </div>
                                    <div>
                                        <div class="text-sm font-medium text-gray-900 dark:text-white">Excel</div>
                                        <div class="text-xs text-gray-500 dark:text-gray-400">Excel spreadsheet</div>
                                    </div>
                                </div>
                            </label>

                            <label class="relative flex items-center p-4 border border-gray-300 dark:border-gray-600 rounded-lg cursor-pointer hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors duration-200">
                                <input type="radio" name="format" value="pdf" {{ old('format') == 'pdf' ? 'checked' : '' }}
                                       class="sr-only">
                                <div class="flex items-center">
                                    <div class="w-4 h-4 border-2 border-gray-300 dark:border-gray-600 rounded-full mr-3 flex items-center justify-center">
                                        <div class="w-2 h-2 bg-primaryGreen rounded-full opacity-0 transition-opacity duration-200"></div>
                                    </div>
                                    <div>
                                        <div class="text-sm font-medium text-gray-900 dark:text-white">PDF</div>
                                        <div class="text-xs text-gray-500 dark:text-gray-400">Portable document</div>
                                    </div>
                                </div>
                            </label>
                        </div>
                        @error('format')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="mt-8 flex items-center justify-end space-x-4">
                    <a href="{{ route('partner.questions.all') }}" 
                       class="px-4 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors duration-200">
                        Cancel
                    </a>
                    <button type="submit"
                            class="inline-flex items-center px-6 py-2 bg-primaryGreen text-white text-sm font-medium rounded-lg hover:bg-primaryGreen/90 focus:outline-none focus:ring-2 focus:ring-primaryGreen focus:ring-offset-2 transition-colors duration-200">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        Download Questions
                    </button>
                </div>
            </form>
        </div>

        <!-- Information Card -->
        <div class="mt-6 bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg p-4">
            <div class="flex items-start">
                <svg class="w-5 h-5 text-blue-600 dark:text-blue-400 mt-0.5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <div>
                    <h3 class="text-sm font-medium text-blue-800 dark:text-blue-200">Download Information</h3>
                    <div class="mt-2 text-sm text-blue-700 dark:text-blue-300">
                        <ul class="list-disc list-inside space-y-1">
                            <li>The downloaded file will include the paper parameter in the filename</li>
                            <li>Questions will be filtered based on your selected criteria</li>
                            <li>MCQ options will be included in the options column for multiple choice questions</li>
                            <li>All question metadata (course, subject, topic, type) will be included</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Add radio button selection styling and exam selection functionality
document.addEventListener('DOMContentLoaded', function() {
    const radioInputs = document.querySelectorAll('input[type="radio"][name="format"]');
    const examSelect = document.getElementById('exam_id');
    const paperParameterInput = document.getElementById('paper_parameter');
    
    
    // Handle radio button selection styling
    radioInputs.forEach(input => {
        input.addEventListener('change', function() {
            // Remove selected styling from all labels
            document.querySelectorAll('label[for*="format"]').forEach(label => {
                label.classList.remove('border-primaryGreen', 'bg-primaryGreen/5');
                label.classList.add('border-gray-300', 'dark:border-gray-600');
            });
            
            // Add selected styling to current label
            if (this.checked) {
                const label = this.closest('label');
                label.classList.remove('border-gray-300', 'dark:border-gray-600');
                label.classList.add('border-primaryGreen', 'bg-primaryGreen/5');
                
                // Show the radio button indicator
                const indicator = label.querySelector('.w-2.h-2');
                if (indicator) {
                    indicator.classList.remove('opacity-0');
                    indicator.classList.add('opacity-100');
                }
            }
        });
        
        // Initialize styling for pre-selected option
        if (input.checked) {
            input.dispatchEvent(new Event('change'));
        }
    });
    
    // Handle exam selection
    examSelect.addEventListener('change', function() {
        const examId = this.value;
        
        if (examId) {
            // Show loading state
            paperParameterInput.value = 'Loading exam details...';
            paperParameterInput.disabled = true;
            
            // Fetch exam details
            fetch(`{{ route('partner.questions.download.exam', '') }}/${examId}`)
                .then(response => response.json())
                .then(data => {
                    if (data.error) {
                        alert('Error loading exam details: ' + data.error);
                        paperParameterInput.value = '';
                    } else {
                        paperParameterInput.value = data.paper_parameter;
                    }
                    paperParameterInput.disabled = false;
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Error loading exam details. Please try again.');
                    paperParameterInput.value = '';
                    paperParameterInput.disabled = false;
                });
        } else {
            // Clear paper parameter if no exam selected
            paperParameterInput.value = '';
        }
    });
    
    // Initialize exam selection if there's a pre-selected value
    if (examSelect.value) {
        examSelect.dispatchEvent(new Event('change'));
    }
    
});
</script>
@endsection
