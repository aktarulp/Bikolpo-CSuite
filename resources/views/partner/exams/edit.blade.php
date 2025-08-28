@extends('layouts.partner-layout')

@section('title', 'Edit Exam')

@section('content')
<div class="min-h-screen bg-gray-50 dark:bg-gray-900 py-6">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Compact Header -->
        <div class="mb-6">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Edit Exam</h1>
                    <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">Update exam configuration and settings</p>
                </div>
                <div class="flex space-x-3">
                    <a href="{{ route('partner.exams.show', $exam) }}" 
                       class="inline-flex items-center px-3 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:bg-gray-800 dark:border-gray-600 dark:text-gray-300 dark:hover:bg-gray-700">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                        View Exam
                    </a>
                    <a href="{{ route('partner.exams.index') }}" 
                       class="inline-flex items-center px-3 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:bg-gray-800 dark:border-gray-600 dark:text-gray-300 dark:hover:bg-gray-700">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                        Back
                    </a>
                </div>
            </div>
        </div>

        <!-- Compact Form -->
        <div class="bg-white dark:bg-gray-800 shadow-lg rounded-lg overflow-hidden">
            <!-- Error Messages -->
            @if ($errors->any())
                <div class="px-4 py-3 bg-red-50 border-b border-red-200">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-4 w-4 text-red-400" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-sm font-medium text-red-800">Please fix the following errors:</h3>
                            <div class="mt-1 text-sm text-red-700">
                                <ul class="list-disc pl-5 space-y-1">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            <form action="{{ route('partner.exams.update', $exam) }}" method="POST" class="space-y-6">
                @csrf
                @method('PUT')

                <!-- Basic Information -->
                <div class="px-4 py-4 border-b border-gray-200 dark:border-gray-700">
                    <div class="flex items-center mb-4">
                        <div class="w-6 h-6 bg-blue-100 dark:bg-blue-900 rounded-lg flex items-center justify-center mr-3">
                            <svg class="w-4 h-4 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                        </div>
                        <h2 class="text-lg font-semibold text-gray-900 dark:text-white">Basic Information</h2>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                Exam Title <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="title" value="{{ old('title', $exam->title) }}" required
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:focus:ring-blue-400 dark:focus:border-blue-400 transition-colors duration-200"
                                   placeholder="Enter exam title">
                            @error('title')
                                <p class="mt-1 text-xs text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                Exam Type <span class="text-red-500">*</span>
                            </label>
                            <select name="exam_type" required
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:focus:ring-blue-400 dark:focus:border-blue-400 transition-colors duration-200">
                                <option value="online" {{ old('exam_type', $exam->exam_type) === 'online' ? 'selected' : '' }}>Online Exam</option>
                                <option value="offline" {{ old('exam_type', $exam->exam_type) === 'offline' ? 'selected' : '' }}>Offline Exam</option>
                            </select>
                            @error('exam_type')
                                <p class="mt-1 text-xs text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="mt-4 space-y-3">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Description</label>
                            <textarea name="description" rows="2" 
                                      class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:focus:ring-blue-400 dark:focus:border-blue-400 transition-colors duration-200"
                                      placeholder="Provide a detailed description of the exam">{{ old('description', $exam->description) }}</textarea>
                            @error('description')
                                <p class="mt-1 text-xs text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Exam Schedule -->
                <div class="px-4 py-4 border-b border-gray-200 dark:border-gray-700">
                    <div class="flex items-center mb-4">
                        <div class="w-6 h-6 bg-green-100 dark:bg-green-900 rounded-lg flex items-center justify-center mr-3">
                            <svg class="w-4 h-4 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                        <h2 class="text-lg font-semibold text-gray-900 dark:text-white">Exam Schedule</h2>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                Start Date & Time <span class="text-red-500">*</span>
                            </label>
                            <input type="datetime-local" name="start_time" 
                                   value="{{ old('start_time', $exam->start_time ? $exam->start_time->format('Y-m-d\TH:i') : '') }}" required
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:focus:ring-blue-400 dark:focus:border-blue-400 transition-colors duration-200">
                            @error('start_time')
                                <p class="mt-1 text-xs text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                End Date & Time <span class="text-red-500">*</span>
                            </label>
                            <input type="datetime-local" name="end_time" 
                                   value="{{ old('end_time', $exam->end_time ? $exam->end_time->format('Y-m-d\TH:i') : '') }}" required
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:focus:ring-blue-400 dark:focus:border-blue-400 transition-colors duration-200">
                            @error('end_time')
                                <p class="mt-1 text-xs text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                Duration (minutes) <span class="text-red-500">*</span>
                            </label>
                            <input type="number" name="duration" min="1" max="1440"
                                   value="{{ old('duration', $exam->duration) }}" required
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:focus:ring-blue-400 dark:focus:border-blue-400 transition-colors duration-200"
                                   placeholder="e.g., 120">
                            @error('duration')
                                <p class="mt-1 text-xs text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Exam Configuration -->
                <div class="px-4 py-4 border-b border-gray-200 dark:border-gray-700">
                    <div class="flex items-center mb-4">
                        <div class="w-6 h-6 bg-purple-100 dark:bg-purple-900 rounded-lg flex items-center justify-center mr-3">
                            <svg class="w-4 h-4 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                        </div>
                        <h2 class="text-lg font-semibold text-gray-900 dark:text-white">Exam Configuration</h2>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                Total Questions <span class="text-red-500">*</span>
                            </label>
                            <input type="number" name="total_questions" min="1" max="1000"
                                   value="{{ old('total_questions', $exam->total_questions) }}" required
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:focus:ring-blue-400 dark:focus:border-blue-400 transition-colors duration-200"
                                   placeholder="e.g., 50">
                            @error('total_questions')
                                <p class="mt-1 text-xs text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                Passing Marks (%) <span class="text-red-500">*</span>
                            </label>
                            <input type="number" name="passing_marks" min="0" max="100"
                                   value="{{ old('passing_marks', $exam->passing_marks) }}" required
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:focus:ring-blue-400 dark:focus:border-blue-400 transition-colors duration-200"
                                   placeholder="e.g., 60">
                            @error('passing_marks')
                                <p class="mt-1 text-xs text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="mt-4 space-y-3">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Question Head</label>
                            <input type="text" name="question_head" 
                                   value="{{ old('question_head', $exam->question_head) }}"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:focus:ring-blue-400 dark:focus:border-blue-400 transition-colors duration-200"
                                   placeholder="Optional question header text">
                            @error('question_head')
                                <p class="mt-1 text-xs text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Exam Options -->
                <div class="px-4 py-4 border-b border-gray-200 dark:border-gray-700">
                    <div class="flex items-center mb-4">
                        <div class="w-6 h-6 bg-yellow-100 dark:bg-yellow-900 rounded-lg flex items-center justify-center mr-3">
                            <svg class="w-4 h-4 text-yellow-600 dark:text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                            </svg>
                        </div>
                        <h2 class="text-lg font-semibold text-gray-900 dark:text-white">Exam Options</h2>
                    </div>

                    <div class="space-y-4">
                        <div class="flex items-center">
                            <input type="checkbox" name="allow_retake" id="allow_retake" value="1"
                                   {{ old('allow_retake', $exam->allow_retake) ? 'checked' : '' }}
                                   class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                            <label for="allow_retake" class="ml-2 block text-sm text-gray-700 dark:text-gray-300">
                                Allow students to retake the exam
                            </label>
                        </div>

                        <div class="flex items-center">
                            <input type="checkbox" name="show_results_immediately" id="show_results_immediately" value="1"
                                   {{ old('show_results_immediately', $exam->show_results_immediately) ? 'checked' : '' }}
                                   class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                            <label for="show_results_immediately" class="ml-2 block text-sm text-gray-700 dark:text-gray-300">
                                Show results immediately after submission
                            </label>
                        </div>

                        <div class="flex items-center">
                            <input type="checkbox" name="has_negative_marking" id="has_negative_marking" value="1"
                                   {{ old('has_negative_marking', $exam->has_negative_marking) ? 'checked' : '' }}
                                   class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                            <label for="has_negative_marking" class="ml-2 block text-sm text-gray-700 dark:text-gray-300">
                                Enable negative marking for wrong answers
                            </label>
                        </div>

                        <div id="negative_marking_details" class="ml-6 {{ old('has_negative_marking', $exam->has_negative_marking) ? '' : 'hidden' }}">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                Negative Marks per Wrong Answer
                            </label>
                            <input type="number" name="negative_marks_per_question" step="0.01" min="0" max="5"
                                   value="{{ old('negative_marks_per_question', $exam->negative_marks_per_question) }}"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:focus:ring-blue-400 dark:focus:border-blue-400 transition-colors duration-200"
                                   placeholder="e.g., 0.25">
                            @error('negative_marks_per_question')
                                <p class="mt-1 text-xs text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="px-4 py-4 bg-gray-50 dark:bg-gray-700/50">
                    <div class="flex justify-end space-x-3">
                        <a href="{{ route('partner.exams.index') }}" 
                           class="px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:bg-gray-800 dark:border-gray-600 dark:text-gray-300 dark:hover:bg-gray-700">
                            Cancel
                        </a>
                        <button type="submit" 
                                class="px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            Update Exam
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const negativeMarkingCheckbox = document.getElementById('has_negative_marking');
    const negativeMarkingDetails = document.getElementById('negative_marking_details');

    function toggleNegativeMarking() {
        if (negativeMarkingCheckbox.checked) {
            negativeMarkingDetails.classList.remove('hidden');
        } else {
            negativeMarkingDetails.classList.add('hidden');
        }
    }

    negativeMarkingCheckbox.addEventListener('change', toggleNegativeMarking);
    
    // Initialize on page load
    toggleNegativeMarking();
});
</script>
@endpush
