@extends('layouts.partner-layout')

@section('title', 'Create Exam')

@section('content')
<div class="min-h-screen bg-gray-50 dark:bg-gray-900 py-6">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Compact Header -->
        <div class="mb-6">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Create New Exam</h1>
                    <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">Schedule and configure a new examination</p>
                </div>
                <a href="{{ route('partner.exams.index') }}" 
                   class="inline-flex items-center px-3 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:bg-gray-800 dark:border-gray-600 dark:text-gray-300 dark:hover:bg-gray-700">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Back
                </a>
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

            <form action="{{ route('partner.exams.store') }}" method="POST" class="space-y-6">
                @csrf

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
                            <input type="text" name="title" value="{{ old('title') }}" required
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
                                <option value="online" {{ old('exam_type', 'online') === 'online' ? 'selected' : '' }}>Online Exam</option>
                                <option value="offline" {{ old('exam_type', 'online') === 'offline' ? 'selected' : '' }}>Offline Exam</option>
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
                                      placeholder="Provide a detailed description of the exam">{{ old('description') }}</textarea>
                            @error('description')
                                <p class="mt-1 text-xs text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Question Head/Instructions</label>
                            <textarea name="question_head" rows="2" 
                                      class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:focus:ring-blue-400 dark:focus:border-blue-400 transition-colors duration-200"
                                      placeholder="Special instructions or header text for questions">{{ old('question_head') }}</textarea>
                            @error('question_head')
                                <p class="mt-1 text-xs text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Schedule & Duration -->
                <div class="px-4 py-4 border-b border-gray-200 dark:border-gray-700">
                    <div class="flex items-center mb-4">
                        <div class="w-6 h-6 bg-green-100 dark:bg-green-900 rounded-lg flex items-center justify-center mr-3">
                            <svg class="w-4 h-4 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                        <h2 class="text-lg font-semibold text-gray-900 dark:text-white">Schedule & Duration</h2>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                Schedule <span class="text-red-500">*</span>
                            </label>
                            <div class="space-y-3">
                                <div>
                                    <label class="block text-xs font-medium text-gray-600 dark:text-gray-400 mb-1">Start Date & Time</label>
                                    <input type="datetime-local" name="start_time" id="start_time"
                                           value="{{ old('start_time', now()->addDay()->format('Y-m-d\TH:i')) }}" 
                                           min="{{ now()->addHour()->format('Y-m-d\TH:i') }}"
                                           required
                                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-green-500 focus:border-green-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:focus:ring-green-400 dark:focus:border-green-400 transition-colors duration-200"
                                           onchange="updateEndTime()">
                                    @error('start_time')
                                        <p class="mt-1 text-xs text-red-600 dark:text-red-400">{{ $message }}</p>
                                    @enderror
                                </div>
                                
                                <div>
                                    <label class="block text-xs font-medium text-gray-600 dark:text-gray-400 mb-1">End Date & Time</label>
                                    <input type="datetime-local" name="end_time" id="end_time"
                                           value="{{ old('end_time', now()->addDay()->addHours(2)->format('Y-m-d\TH:i')) }}" 
                                           required
                                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-green-500 focus:border-green-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:focus:ring-green-400 dark:focus:border-green-400 transition-colors duration-200"
                                           onchange="calculateDuration()">
                                    @error('end_time')
                                        <p class="mt-1 text-xs text-red-600 dark:text-red-400">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                Duration <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <input type="number" name="duration" id="duration" value="{{ old('duration', 120) }}" min="15" max="480" required
                                       class="w-full px-3 py-2 pr-16 border border-gray-300 rounded-md focus:ring-2 focus:ring-green-500 focus:border-green-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:focus:ring-green-400 dark:focus:border-green-400 transition-colors duration-200"
                                       placeholder="120"
                                       onchange="updateEndTimeFromDuration()">
                                <div class="absolute inset-y-0 right-0 flex items-center pr-3">
                                    <span class="text-sm text-gray-500 dark:text-gray-400">min</span>
                                </div>
                            </div>
                            <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Minutes (15 min - 8 hours)</p>
                            @error('duration')
                                <p class="mt-1 text-xs text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                            
                            <!-- Duration Preview -->
                            <div class="mt-3 p-3 bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 rounded-lg">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center space-x-2">
                                        <svg class="w-4 h-4 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        <span class="text-sm font-medium text-green-800 dark:text-green-200">Duration Preview:</span>
                                    </div>
                                    <span class="text-sm text-green-700 dark:text-green-300" id="duration-preview">
                                        Set start and end times to see duration
                                    </span>
                                </div>
                                
                                <!-- Quick Duration Presets -->
                                <div class="mt-3 pt-3 border-t border-green-200 dark:border-green-700">
                                    <div class="flex items-center space-x-2">
                                        <span class="text-xs font-medium text-green-700 dark:text-green-300">Quick Presets:</span>
                                        <div class="flex flex-wrap gap-2">
                                            <button type="button" onclick="setDuration(30)" class="px-2 py-1 text-xs bg-green-100 hover:bg-green-200 text-green-700 rounded border border-green-300 transition-colors duration-200">30 min</button>
                                            <button type="button" onclick="setDuration(60)" class="px-2 py-1 text-xs bg-green-100 hover:bg-green-200 text-green-700 rounded border border-green-300 transition-colors duration-200">1 hour</button>
                                            <button type="button" onclick="setDuration(90)" class="px-2 py-1 text-xs bg-green-100 hover:bg-green-200 text-green-700 rounded border border-green-300 transition-colors duration-200">1.5 hours</button>
                                            <button type="button" onclick="setDuration(120)" class="px-2 py-1 text-xs bg-green-100 hover:bg-green-200 text-green-700 rounded border border-green-300 transition-colors duration-200">2 hours</button>
                                            <button type="button" onclick="setDuration(180)" class="px-2 py-1 text-xs bg-green-100 hover:bg-green-200 text-green-700 rounded border border-green-300 transition-colors duration-200">3 hours</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Exam Configuration -->
                <div class="px-4 py-4 border-b border-gray-200 dark:border-gray-700">
                    <div class="flex items-center mb-4">
                        <div class="w-6 h-6 bg-purple-100 dark:bg-purple-900 rounded-lg flex items-center justify-center mr-3">
                            <svg class="w-4 h-4 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                            </svg>
                        </div>
                        <h2 class="text-lg font-semibold text-gray-900 dark:text-white">Exam Configuration</h2>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                Total Questions <span class="text-red-500">*</span>
                            </label>
                            <input type="number" name="total_questions" value="{{ old('total_questions', 10) }}" min="1" max="100" required
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-purple-500 focus:border-purple-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:focus:ring-purple-400 dark:focus:border-purple-400 transition-colors duration-200"
                                   placeholder="e.g., 25">
                            @error('total_questions')
                                <p class="mt-1 text-xs text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                Passing Marks (%) <span class="text-red-500">*</span>
                            </label>
                            <input type="number" name="passing_marks" value="{{ old('passing_marks', 60) }}" min="0" max="100" required
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-purple-500 focus:border-purple-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:focus:ring-purple-400 dark:focus:border-purple-400 transition-colors duration-200"
                                   placeholder="e.g., 60">
                            @error('passing_marks')
                                <p class="mt-1 text-xs text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Exam Options -->
                <div class="px-4 py-4 border-b border-gray-200 dark:border-gray-700">
                    <div class="flex items-center mb-4">
                        <div class="w-6 h-6 bg-orange-100 dark:bg-orange-900 rounded-lg flex items-center justify-center mr-3">
                            <svg class="w-4 h-4 text-orange-600 dark:text-orange-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                        </div>
                        <h2 class="text-lg font-semibold text-gray-900 dark:text-white">Exam Options & Settings</h2>
                    </div>

                    <div class="space-y-4">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="space-y-3">
                                <label class="flex items-center">
                                    <input type="checkbox" name="allow_retake" value="1" {{ old('allow_retake') ? 'checked' : '' }}
                                           class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                                    <span class="ml-2 text-sm text-gray-700 dark:text-gray-300">Allow Retake</span>
                                </label>
                                <label class="flex items-center">
                                    <input type="checkbox" name="show_results_immediately" value="1" {{ old('show_results_immediately', true) ? 'checked' : '' }}
                                           class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                                    <span class="ml-2 text-sm text-gray-700 dark:text-gray-300">Show Results Immediately</span>
                                </label>
                            </div>

                            <div class="space-y-3">
                                <div class="flex items-center justify-between">
                                    <label class="text-sm font-medium text-gray-700 dark:text-gray-300">
                                        Enable Negative Marking
                                    </label>
                                    <div class="relative inline-block w-12 mr-2 align-middle select-none transition duration-200 ease-in">
                                        <input type="checkbox" name="has_negative_marking" value="1" {{ old('has_negative_marking') ? 'checked' : '' }}
                                               id="has_negative_marking" 
                                               class="toggle-checkbox absolute block w-6 h-6 rounded-full bg-white border-4 appearance-none cursor-pointer transition-all duration-200 ease-in-out"
                                               style="transform: {{ old('has_negative_marking') ? 'translateX(1.5rem)' : 'translateX(0)' }};">
                                        <label for="has_negative_marking" 
                                               class="toggle-label block overflow-hidden h-6 rounded-full cursor-pointer transition-all duration-200 ease-in-out {{ old('has_negative_marking') ? 'bg-emerald-500' : 'bg-gray-300' }} dark:{{ old('has_negative_marking') ? 'bg-emerald-600' : 'bg-gray-600' }}"></label>
                                    </div>
                                    <span class="text-sm font-medium text-gray-700 dark:text-gray-300" id="negative_marking_status">
                                        {{ old('has_negative_marking') ? 'Yes' : 'No' }}
                                    </span>
                                </div>
                                
                                <!-- Negative Marks Input Field -->
                                <div id="negative_marking_fields" class="hidden ml-6">
                                    <div class="flex items-center space-x-3">
                                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                            (-) Marks/Wrong Answer <span class="text-red-500">*</span>
                                        </label>
                                        <input type="number" name="negative_marks_per_question" 
                                               value="{{ old('negative_marks_per_question', 0.25) }}" 
                                               min="0" max="5" step="0.25" required
                                               class="w-20 px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-purple-500 focus:border-purple-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:focus:ring-purple-400 dark:focus:border-purple-400 transition-colors duration-200"
                                               placeholder="0.25">
                                        <p class="text-xs text-gray-500 dark:text-gray-400">per wrong answer</p>
                                    </div>
                                    @error('negative_marks_per_question')
                                        <p class="mt-1 text-xs text-red-600 dark:text-red-400">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="px-4 py-4 bg-gray-50 dark:bg-gray-700">
                    <div class="flex flex-col sm:flex-row justify-end space-y-3 sm:space-y-0 sm:space-x-3">
                        <a href="{{ route('partner.exams.index') }}" 
                           class="inline-flex justify-center items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 dark:bg-gray-800 dark:border-gray-600 dark:text-gray-300 dark:hover:bg-gray-700 transition-colors duration-200">
                            Cancel
                        </a>
                        <button type="submit" 
                                class="inline-flex justify-center items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-200">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                            </svg>
                            Create Exam
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<style>
/* Toggle Switch Styles */
.toggle-checkbox {
    transform: translateX(0);
    transition: transform 0.2s ease-in-out;
}

.toggle-checkbox:checked {
    transform: translateX(1.5rem);
}

.toggle-label {
    transition: background-color 0.2s ease-in-out;
}

/* Ensure smooth transitions */
.toggle-checkbox,
.toggle-label {
    transition: all 0.2s ease-in-out;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Negative marking functionality
    const negativeMarkingCheckbox = document.getElementById('has_negative_marking');
    const negativeMarkingFields = document.getElementById('negative_marking_fields');
    const negativeMarksInput = document.querySelector('input[name="negative_marks_per_question"]');
    const negativeMarkingStatus = document.getElementById('negative_marking_status');
    const toggleLabel = document.querySelector('.toggle-label');

    function toggleNegativeMarkingFields() {
        if (negativeMarkingCheckbox.checked) {
            negativeMarkingFields.classList.remove('hidden');
            negativeMarksInput.required = true;
            negativeMarksInput.disabled = false;
            negativeMarkingStatus.textContent = 'Yes';
            toggleLabel.classList.remove('bg-gray-300', 'dark:bg-gray-600');
            toggleLabel.classList.add('bg-emerald-500', 'dark:bg-emerald-600');
        } else {
            negativeMarkingFields.classList.add('hidden');
            negativeMarksInput.required = false;
            negativeMarksInput.disabled = true;
            negativeMarkingStatus.textContent = 'No';
            toggleLabel.classList.remove('bg-emerald-500', 'dark:bg-emerald-600');
            toggleLabel.classList.add('bg-gray-300', 'dark:bg-gray-600');
            // Clear the value when unchecked
            negativeMarksInput.value = '';
        }
    }

    // Initial state
    toggleNegativeMarkingFields();

    // Listen for changes
    negativeMarkingCheckbox.addEventListener('change', toggleNegativeMarkingFields);

    // Schedule and duration functionality
    const startTimeInput = document.getElementById('start_time');
    const endTimeInput = document.getElementById('end_time');
    const durationInput = document.getElementById('duration');
    const durationPreview = document.getElementById('duration-preview');
    const form = document.querySelector('form');

    // Update end time when start time changes
    function updateEndTime() {
        const startTime = startTimeInput.value;
        const duration = parseInt(durationInput.value) || 120;
        
        if (startTime && duration > 0) {
            try {
                const startDate = new Date(startTime);
                if (isNaN(startDate.getTime())) {
                    console.error('Invalid start time:', startTime);
                    return;
                }
                
                const endDate = new Date(startDate.getTime() + (duration * 60 * 1000));
                const endTimeString = endDate.toISOString().slice(0, 16);
                endTimeInput.value = endTimeString;
                
                updateDurationPreview();
                console.log('End time updated:', endTimeString);
            } catch (error) {
                console.error('Error updating end time:', error);
            }
        }
    }

    // Calculate duration when end time changes
    function calculateDuration() {
        const startTime = startTimeInput.value;
        const endTime = endTimeInput.value;
        
        if (startTime && endTime) {
            try {
                const startDate = new Date(startTime);
                const endDate = new Date(endTime);
                
                if (isNaN(startDate.getTime()) || isNaN(endDate.getTime())) {
                    return;
                }
                
                const durationMinutes = Math.round((endDate.getTime() - startDate.getTime()) / (1000 * 60));
                
                if (durationMinutes > 0) {
                    durationInput.value = durationMinutes;
                    updateDurationPreview();
                    console.log('Duration calculated:', durationMinutes, 'minutes');
                }
            } catch (error) {
                console.error('Error calculating duration:', error);
            }
        }
    }

    // Update end time when duration changes
    function updateEndTimeFromDuration() {
        const startTime = startTimeInput.value;
        const duration = parseInt(durationInput.value) || 0;
        
        if (startTime && duration > 0) {
            try {
                const startDate = new Date(startTime);
                if (isNaN(startDate.getTime())) {
                    return;
                }
                
                const endDate = new Date(startDate.getTime() + (duration * 60 * 1000));
                const endTimeString = endDate.toISOString().slice(0, 16);
                endTimeInput.value = endTimeString;
                
                updateDurationPreview();
                console.log('End time updated from duration:', endTimeString);
            } catch (error) {
                console.error('Error updating end time from duration:', error);
            }
        }
    }

    // Update duration preview
    function updateDurationPreview() {
        const startTime = startTimeInput.value;
        const endTime = endTimeInput.value;
        
        if (startTime && endTime) {
            try {
                const startDate = new Date(startTime);
                const endDate = new Date(endTime);
                
                if (isNaN(startDate.getTime()) || isNaN(endDate.getTime())) {
                    durationPreview.textContent = 'Set start and end times to see duration';
                    return;
                }
                
                const durationMinutes = Math.round((endDate.getTime() - startDate.getTime()) / (1000 * 60));
                
                if (durationMinutes > 0) {
                    const hours = Math.floor(durationMinutes / 60);
                    const minutes = durationMinutes % 60;
                    
                    if (hours > 0) {
                        durationPreview.textContent = `${hours} hour${hours > 1 ? 's' : ''} ${minutes > 0 ? minutes + ' min' : ''}`.trim();
                    } else {
                        durationPreview.textContent = `${minutes} minutes`;
                    }
                } else {
                    durationPreview.textContent = 'End time must be after start time';
                }
            } catch (error) {
                console.error('Error updating duration preview:', error);
                durationPreview.textContent = 'Error calculating duration';
            }
        } else {
            durationPreview.textContent = 'Set start and end times to see duration';
        }
    }

    // Set duration from preset buttons
    function setDuration(minutes) {
        durationInput.value = minutes;
        updateEndTimeFromDuration();
    }

    // Set minimum start time to current time + 1 hour
    const now = new Date();
    const minStartTime = new Date(now.getTime() + (60 * 60 * 1000));
    const minStartTimeString = minStartTime.toISOString().slice(0, 16);
    startTimeInput.min = minStartTimeString;
    
    // If start time is before minimum, update it
    if (startTimeInput.value && new Date(startTimeInput.value) < minStartTime) {
        startTimeInput.value = minStartTimeString;
    }

    // Form validation
    form.addEventListener('submit', function(e) {
        const startTime = new Date(startTimeInput.value);
        const endTime = new Date(endTimeInput.value);
        
        if (isNaN(startTime.getTime()) || isNaN(endTime.getTime())) {
            e.preventDefault();
            alert('Please ensure both start time and end time are valid.');
            return false;
        }
        
        if (endTime <= startTime) {
            e.preventDefault();
            alert('End time must be after start time. Please check your settings.');
            return false;
        }
        
        console.log('Form submitted with:', {
            startTime: startTimeInput.value,
            endTime: endTimeInput.value,
            duration: durationInput.value
        });
    });

    // Initialize on page load
    window.addEventListener('load', function() {
        updateDurationPreview();
    });
});
</script>
@endpush 
