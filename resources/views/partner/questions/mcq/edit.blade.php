@extends('layouts.app')

@section('title', 'Edit MCQ Question')

@section('content')
<div class="space-y-6">
    <!-- Page Header -->
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Edit MCQ Question</h1>
            <p class="text-gray-600 dark:text-gray-400">Update the multiple choice question</p>
        </div>
        <a href="{{ route('partner.questions.mcq.index') }}" 
           class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg transition-colors duration-200">
            Back to Questions
        </a>
    </div>

    <!-- MCQ Question Form -->
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md">
        <div class="p-6 border-b border-gray-200 dark:border-gray-700">
            <h2 class="text-lg font-semibold text-gray-900 dark:text-white">Question Details</h2>
        </div>

        <form action="{{ route('partner.questions.mcq.update', $question) }}" method="POST" enctype="multipart/form-data" class="p-6 space-y-6">
            @csrf
            @method('PUT')
            
            <!-- Course, Subject, Topic Selection -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div>
                    <label for="course_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Course *</label>
                    <select name="course_id" id="course_id" required class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:border-primaryGreen focus:ring-primaryGreen">
                        <option value="">Select Course</option>
                        @foreach($courses ?? [] as $course)
                            <option value="{{ $course->id }}" {{ old('course_id', $question->course_id) == $course->id ? 'selected' : '' }}>
                                {{ $course->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('course_id')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="subject_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Subject *</label>
                    <select name="subject_id" id="subject_id" required class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:border-primaryGreen focus:ring-primaryGreen">
                        <option value="">Select Subject</option>
                        @foreach($subjects ?? [] as $subject)
                            <option value="{{ $subject->id }}" {{ old('subject_id', $question->subject_id) == $subject->id ? 'selected' : '' }}>
                                {{ $subject->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('subject_id')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="topic_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Topic *</label>
                    <select name="topic_id" id="topic_id" required class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:border-primaryGreen focus:ring-primaryGreen">
                        <option value="">Select Topic</option>
                        @foreach($topics ?? [] as $topic)
                            <option value="{{ $topic->id }}" {{ old('topic_id', $question->topic_id) == $topic->id ? 'selected' : '' }}>
                                {{ $topic->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('topic_id')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Question Text -->
            <div>
                <label for="question_text" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Question Text *</label>
                <textarea name="question_text" id="question_text" rows="4" required 
                           class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:border-primaryGreen focus:ring-primaryGreen"
                           placeholder="Enter your question here...">{{ old('question_text', $question->question_text) }}</textarea>
                @error('question_text')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- MCQ Options -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="option_a" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Option A *</label>
                    <input type="text" name="option_a" id="option_a" required 
                           class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:border-primaryGreen focus:ring-primaryGreen"
                           value="{{ old('option_a', $question->option_a) }}" placeholder="Enter option A">
                    @error('option_a')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="option_b" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Option B *</label>
                    <input type="text" name="option_b" id="option_b" required 
                           class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:border-primaryGreen focus:ring-primaryGreen"
                           value="{{ old('option_b', $question->option_b) }}" placeholder="Enter option B">
                    @error('option_b')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="option_c" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Option C *</label>
                    <input type="text" name="option_c" id="option_c" required 
                           class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:border-primaryGreen focus:ring-primaryGreen"
                           value="{{ old('option_c', $question->option_c) }}" placeholder="Enter option C">
                    @error('option_c')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="option_d" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Option D *</label>
                    <input type="text" name="option_d" id="option_d" required 
                           class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:border-primaryGreen focus:ring-primaryGreen"
                           value="{{ old('option_d', $question->option_d) }}" placeholder="Enter option D">
                    @error('option_d')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Correct Answer and Status -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="correct_answer" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Correct Answer *</label>
                    <select name="correct_answer" id="correct_answer" required class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:border-primaryGreen focus:ring-primaryGreen">
                        <option value="">Select</option>
                        <option value="a" {{ old('correct_answer', $question->correct_answer) == 'a' ? 'selected' : '' }}>A</option>
                        <option value="b" {{ old('correct_answer', $question->correct_answer) == 'b' ? 'selected' : '' }}>B</option>
                        <option value="c" {{ old('correct_answer', $question->correct_answer) == 'c' ? 'selected' : '' }}>C</option>
                        <option value="d" {{ old('correct_answer', $question->correct_answer) == 'd' ? 'selected' : '' }}>D</option>
                    </select>
                    @error('correct_answer')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="status" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Status</label>
                    <select name="status" id="status" class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:border-primaryGreen focus:ring-primaryGreen">
                        <option value="active" {{ old('status', $question->status) == 'active' ? 'selected' : '' }}>Active</option>
                        <option value="inactive" {{ old('status', $question->status) == 'inactive' ? 'selected' : '' }}>Inactive</option>
                    </select>
                    @error('status')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Explanation -->
            <div>
                <label for="explanation" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Explanation</label>
                <textarea name="explanation" id="explanation" rows="3" 
                           class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:border-primaryGreen focus:ring-primaryGreen"
                           placeholder="Explain why this answer is correct...">{{ old('explanation', $question->explanation) }}</textarea>
                @error('explanation')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Marks -->
            <div>
                <label for="marks" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Marks *</label>
                <input type="number" name="marks" id="marks" required min="1" max="100"
                       class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:border-primaryGreen focus:ring-primaryGreen"
                       value="{{ old('marks', $question->marks) }}" placeholder="Enter marks">
                @error('marks')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Question Image -->
            <div>
                <label for="image" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Question Image (Optional)</label>
                @if($question->image)
                    <div class="mb-3">
                        <p class="text-sm text-gray-600 dark:text-gray-400 mb-2">Current image:</p>
                        <img src="{{ asset('storage/' . $question->image) }}" alt="Current question image" class="w-32 h-32 object-cover rounded-md border">
                    </div>
                @endif
                <input type="file" name="image" id="image" accept="image/*" 
                       class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:border-primaryGreen focus:ring-primaryGreen">
                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Supported formats: JPEG, PNG, JPG, GIF (Max: 2MB)</p>
                @error('image')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Submit Buttons -->
            <div class="flex justify-end space-x-3 pt-6 border-t border-gray-200 dark:border-gray-700">
                <a href="{{ route('partner.questions.mcq.index') }}" 
                   class="px-6 py-2 border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 rounded-md hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors duration-200">
                    Cancel
                </a>
                <button type="submit" 
                        class="px-6 py-2 bg-primaryGreen hover:bg-green-600 text-white rounded-md transition-colors duration-200">
                    Update Question
                </button>
            </div>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const courseSelect = document.getElementById('course_id');
    const subjectSelect = document.getElementById('subject_id');
    const topicSelect = document.getElementById('topic_id');

    // Course change handler
    courseSelect.addEventListener('change', function() {
        const courseId = this.value;
        if (courseId) {
            // Fetch subjects for selected course
            fetch(`/partner/questions/subjects?course_id=${courseId}`)
                .then(response => response.json())
                .then(data => {
                    subjectSelect.innerHTML = '<option value="">Select Subject</option>';
                    topicSelect.innerHTML = '<option value="">Select Topic</option>';
                    
                    data.forEach(subject => {
                        const option = document.createElement('option');
                        option.value = subject.id;
                        option.textContent = subject.name;
                        subjectSelect.appendChild(option);
                    });
                    
                    // Set the current subject if it belongs to the selected course
                    const currentSubjectId = '{{ $question->subject_id }}';
                    if (currentSubjectId) {
                        subjectSelect.value = currentSubjectId;
                        // Trigger subject change to load topics
                        subjectSelect.dispatchEvent(new Event('change'));
                    }
                });
        } else {
            subjectSelect.innerHTML = '<option value="">Select Subject</option>';
            topicSelect.innerHTML = '<option value="">Select Topic</option>';
        }
    });

    // Subject change handler
    subjectSelect.addEventListener('change', function() {
        const subjectId = this.value;
        if (subjectId) {
            // Fetch topics for selected subject
            fetch(`/partner/questions/topics?subject_id=${subjectId}`)
                .then(response => response.json())
                .then(data => {
                    topicSelect.innerHTML = '<option value="">Select Topic</option>';
                    
                    data.forEach(topic => {
                        const option = document.createElement('option');
                        option.value = topic.id;
                        option.textContent = topic.name;
                        topicSelect.appendChild(option);
                    });
                    
                    // Set the current topic if it belongs to the selected subject
                    const currentTopicId = '{{ $question->topic_id }}';
                    if (currentTopicId) {
                        topicSelect.value = currentTopicId;
                    }
                });
        } else {
            topicSelect.innerHTML = '<option value="">Select Topic</option>';
        }
    });
    
    // Initialize dependent dropdowns on page load
    if (courseSelect.value) {
        courseSelect.dispatchEvent(new Event('change'));
    }
});
</script>
@endsection
