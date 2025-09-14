@extends('layouts.partner-layout')

@section('title', 'Create New Exam Draft')

@section('content')
<style>
    /* Custom scrollbar */
    .custom-scrollbar::-webkit-scrollbar {
        width: 4px;
    }
    .custom-scrollbar::-webkit-scrollbar-track {
        background: #f1f5f9;
        border-radius: 2px;
    }
    .custom-scrollbar::-webkit-scrollbar-thumb {
        background: #cbd5e1;
        border-radius: 2px;
    }
    .custom-scrollbar::-webkit-scrollbar-thumb:hover {
        background: #94a3b8;
    }

    /* Form animations */
    .form-group {
        animation: slideInUp 0.6s ease-out;
    }
    
    @keyframes slideInUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    /* Toggle switch styling */
    .toggle-switch {
        position: relative;
        display: inline-block;
        width: 50px;
        height: 24px;
    }
    
    .toggle-switch input {
        opacity: 0;
        width: 0;
        height: 0;
    }
    
    .slider {
        position: absolute;
        cursor: pointer;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: #e2e8f0;
        transition: 0.3s;
        border-radius: 24px;
    }
    
    .slider:before {
        position: absolute;
        content: "";
        height: 18px;
        width: 18px;
        left: 3px;
        bottom: 3px;
        background-color: white;
        transition: 0.3s;
        border-radius: 50%;
        box-shadow: 0 2px 4px rgba(0,0,0,0.2);
    }
    
    input:checked + .slider {
        background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%);
    }
    
    input:checked + .slider:before {
        transform: translateX(26px);
    }

    /* Rich text editor styling */
    .rich-editor {
        min-height: 120px;
        border: 1px solid #d1d5db;
        border-radius: 8px;
        padding: 12px;
        background: white;
        transition: all 0.2s ease;
    }
    
    .rich-editor:focus {
        outline: none;
        border-color: #3b82f6;
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
    }
    
    .rich-editor[contenteditable="true"]:empty:before {
        content: attr(data-placeholder);
        color: #9ca3af;
        pointer-events: none;
    }

    /* Notification styles */
    .notification {
        animation: slideInRight 0.3s ease-out;
    }
    
    @keyframes slideInRight {
        from {
            transform: translateX(100%);
        }
        to {
            transform: translateX(0);
        }
    }

    /* Mobile optimizations */
    @media (max-width: 640px) {
        .form-container {
            padding: 1rem;
        }
        
        .section-header {
            flex-direction: column;
            align-items: flex-start;
            gap: 0.5rem;
        }
        
        .button-group {
            flex-direction: column;
            width: 100%;
        }
        
        .button-group button {
            width: 100%;
        }
    }
</style>

<div class="min-h-screen bg-gray-50 dark:bg-gray-900">
    <div class="max-w-4xl mx-auto px-4 py-6 sm:px-6 lg:px-8">
        
        <!-- Header -->
        <div class="mb-8">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-2xl sm:text-3xl font-bold text-gray-900 dark:text-white">Create New Exam Draft</h1>
                    <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">Set up your exam draft with all necessary details</p>
                </div>
                <a href="{{ route('partner.exams.index') }}" 
                   class="inline-flex items-center px-3 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Back to Exams
                </a>
            </div>
        </div>

        <!-- Error Messages -->
        @if ($errors->any())
            <div class="mb-6 p-4 bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-lg">
                <div class="flex">
                    <svg class="h-5 w-5 text-red-400 mt-0.5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.34 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                    </svg>
                    <div>
                        <h3 class="text-sm font-medium text-red-800 dark:text-red-200">Please fix the following errors:</h3>
                        <ul class="mt-2 text-sm text-red-700 dark:text-red-300 list-disc list-inside space-y-1">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        @endif

        <!-- Form -->
        <form id="examForm" action="{{ route('partner.exams.store') }}" method="POST" class="space-y-6">
            @csrf
            <input type="hidden" name="status" value="draft">

            <!-- Basic Details Section -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700">
                <div class="px-4 py-3 border-b border-gray-200 dark:border-gray-700">
                    <div class="flex items-center">
                        <div class="w-8 h-8 bg-blue-100 dark:bg-blue-900/30 rounded-lg flex items-center justify-center mr-3">
                            <svg class="w-4 h-4 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <h2 class="text-lg font-semibold text-gray-900 dark:text-white">Basic Details</h2>
                    </div>
                </div>
                <div class="p-4 space-y-4">
                    <div class="form-group">
                        <label for="questionHeader" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Question Header
                        </label>
                        <div class="relative">
                            <div id="questionHeaderEditor" class="rich-editor" contenteditable="true" data-placeholder="Enter question header text... You can use formatting, multiple lines, and styling."></div>
                            <input type="hidden" id="questionHeader" name="question_header" value="{{ old('question_header') }}">
                        </div>
                        @error('question_header')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="examTitle" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Exam Title <span class="text-red-500">*</span>
                        </label>
                        <input type="text" id="examTitle" name="title" value="{{ old('title') }}" 
                               placeholder="e.g., Mid-Term Mathematics Exam" required 
                               class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white transition-colors">
                        @error('title')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Description
                        </label>
                        <textarea id="description" name="description" rows="3" 
                                  placeholder="Provide a detailed description of the exam, topics covered, and any special instructions..." 
                                  class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white transition-colors resize-none">{{ old('description') }}</textarea>
                        @error('description')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4">
                        <div class="form-group">
                            <label for="examType" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Exam Type <span class="text-red-500">*</span>
                            </label>
                            <select id="examType" name="exam_type" required 
                                    class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white transition-colors">
                                <option value="online" {{ old('exam_type', 'online') === 'online' ? 'selected' : '' }}>🖥️ Online Exam</option>
                                <option value="offline" {{ old('exam_type', 'online') === 'offline' ? 'selected' : '' }}>📝 Offline Exam</option>
                            </select>
                            @error('exam_type')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="totalQuestions" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Total Questions <span class="text-red-500">*</span>
                            </label>
                            <input type="number" id="totalQuestions" name="total_questions" value="{{ old('total_questions') }}" 
                                   min="1" max="100" required 
                                   class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white transition-colors">
                            @error('total_questions')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="duration" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Duration (minutes) <span class="text-red-500">*</span>
                            </label>
                            <input type="number" id="duration" name="duration" value="{{ old('duration') }}" 
                                   min="15" max="480" required 
                                   class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white transition-colors">
                            @error('duration')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="passingMarks" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Passing Marks (%) <span class="text-red-500">*</span>
                            </label>
                            <input type="number" id="passingMarks" name="passing_marks" value="{{ old('passing_marks') }}" 
                                   min="0" max="100" required 
                                   class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white transition-colors">
                            @error('passing_marks')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="questionLanguage" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Language <span class="text-red-500">*</span>
                            </label>
                            <select id="questionLanguage" name="question_language" required 
                                    class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white transition-colors">
                                <option value="english" {{ old('question_language', 'english') === 'english' ? 'selected' : '' }}>🇺🇸 English</option>
                                <option value="bangla" {{ old('question_language') === 'bangla' ? 'selected' : '' }}>🇧🇩 Bangla</option>
                            </select>
                            @error('question_language')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                </div>
            </div>

            <!-- Schedule Section -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700">
                <div class="px-4 py-3 border-b border-gray-200 dark:border-gray-700">
                    <div class="flex items-center">
                        <div class="w-8 h-8 bg-green-100 dark:bg-green-900/30 rounded-lg flex items-center justify-center mr-3">
                            <svg class="w-4 h-4 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h.01M9 16h.01M15 16h.01M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                        <h2 class="text-lg font-semibold text-gray-900 dark:text-white">Schedule & Timing</h2>
                    </div>
                </div>
                <div class="p-4 space-y-4">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div class="form-group">
                            <label for="startDateTime" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Start Date & Time <span class="text-red-500">*</span>
                            </label>
                            <input type="datetime-local" id="startDateTime" name="startDateTime" 
                                   value="{{ old('startDateTime', now()->addHours(2)->format('Y-m-d\TH:i')) }}" required 
                                   class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 dark:bg-gray-700 dark:text-white transition-colors" 
                                   onchange="validateDateTime()">
                            <div id="startDateTimeError" class="mt-1 text-sm text-red-600 dark:text-red-400 hidden"></div>
                            <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">📅 Default: 2 hours from now</p>
                        </div>

                        <div class="form-group">
                            <label for="endDateTime" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                End Date & Time <span class="text-red-500">*</span>
                            </label>
                            <input type="datetime-local" id="endDateTime" name="endDateTime" 
                                   value="{{ old('endDateTime', now()->addHours(4)->format('Y-m-d\TH:i')) }}" required 
                                   class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 dark:bg-gray-700 dark:text-white transition-colors" 
                                   onchange="validateDateTime()">
                            <div id="endDateTimeError" class="mt-1 text-sm text-red-600 dark:text-red-400 hidden"></div>
                            <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">⏰ Default: 4 hours from now (2 hours duration)</p>
                        </div>
                    </div>

                    <!-- DateTime Validation Summary -->
                    <div id="dateTimeValidationSummary" class="hidden p-3 rounded-lg">
                        <div class="flex items-center">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <span class="text-sm font-medium" id="validationMessage"></span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Settings Section -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700">
                <div class="px-4 py-3 border-b border-gray-200 dark:border-gray-700">
                    <div class="flex items-center">
                        <div class="w-8 h-8 bg-purple-100 dark:bg-purple-900/30 rounded-lg flex items-center justify-center mr-3">
                            <svg class="w-4 h-4 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                        </div>
                        <h2 class="text-lg font-semibold text-gray-900 dark:text-white">Exam Settings</h2>
                    </div>
                </div>
                <div class="p-4">
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3">
                        <div class="form-group">
                            <div class="flex items-center justify-between p-2 bg-gray-50 dark:bg-gray-700 rounded-lg">
                                <h3 class="text-sm font-medium text-gray-900 dark:text-white">Allow Retake</h3>
                                <label class="toggle-switch">
                                    <input type="checkbox" id="allowRetake" name="allow_retake" value="1" {{ old('allow_retake') ? 'checked' : '' }}>
                                    <span class="slider"></span>
                                </label>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="flex items-center justify-between p-2 bg-gray-50 dark:bg-gray-700 rounded-lg">
                                <h3 class="text-sm font-medium text-gray-900 dark:text-white">Show Results Immediately</h3>
                                <label class="toggle-switch">
                                    <input type="checkbox" id="showResults" name="show_results_immediately" value="1" {{ old('show_results_immediately', true) ? 'checked' : '' }}>
                                    <span class="slider"></span>
                                </label>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="flex items-center justify-between p-2 bg-gray-50 dark:bg-gray-700 rounded-lg">
                                <h3 class="text-sm font-medium text-gray-900 dark:text-white">Negative Marking</h3>
                                <label class="toggle-switch">
                                    <input type="checkbox" id="negativeMarking" name="has_negative_marking" value="1" {{ old('has_negative_marking') ? 'checked' : '' }} onchange="toggleNegativeMarkingInput(this)">
                                    <span class="slider"></span>
                                </label>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="flex items-center justify-between p-2 bg-gray-50 dark:bg-gray-700 rounded-lg">
                                <h3 class="text-sm font-medium text-gray-900 dark:text-white">Marks per Wrong Answer</h3>
                                <div class="flex items-center space-x-2">
                                    <div id="negativeMarkingInputContainer" class="{{ old('has_negative_marking') ? '' : 'hidden' }}">
                                        <input type="number" id="negativeMarkingInput" name="negative_marks_per_question" 
                                               value="{{ old('negative_marks_per_question') }}" min="0" max="5" step="0.25" 
                                               class="w-16 px-2 py-1 text-sm border border-gray-300 dark:border-gray-600 rounded focus:ring-2 focus:ring-purple-500 focus:border-purple-500 dark:bg-gray-600 dark:text-white text-center">
                                    </div>
                                    <div id="negativeMarkingPlaceholder" class="{{ old('has_negative_marking') ? 'hidden' : '' }} text-xs text-gray-400">
                                        -
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 p-4">
                <div class="flex flex-col sm:flex-row items-center justify-between space-y-3 sm:space-y-0">
                    <div class="text-center sm:text-left">
                        <h3 class="text-sm font-medium text-gray-900 dark:text-white">Ready to create your exam draft?</h3>
                        <p class="text-xs text-gray-600 dark:text-gray-400">All exams are created as drafts and can be edited later</p>
                    </div>
                    <div class="button-group flex space-x-3 w-full sm:w-auto">
                        <a href="{{ route('partner.exams.index') }}" 
                           class="flex-1 sm:flex-none px-4 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-600 transition-colors text-center">
                            Cancel
                        </a>
                        <button type="submit" form="examForm" 
                                class="flex-1 sm:flex-none px-4 py-2 text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 rounded-lg transition-colors" 
                                onclick="return validateFormBeforeSubmit()">
                            🚀 Create Draft
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
    function toggleNegativeMarkingInput(checkbox) {
        const inputContainer = document.getElementById('negativeMarkingInputContainer');
        const placeholder = document.getElementById('negativeMarkingPlaceholder');
        
        if (checkbox.checked) {
            inputContainer.classList.remove('hidden');
            placeholder.classList.add('hidden');
        } else {
            inputContainer.classList.add('hidden');
            placeholder.classList.remove('hidden');
        }
    }

    function validateDateTime() {
        const startDateTimeInput = document.getElementById('startDateTime').value;
        const endDateTimeInput = document.getElementById('endDateTime').value;
        
        // Reset error states
        clearDateTimeErrors();
        
        if (!startDateTimeInput || !endDateTimeInput) {
            return true; // Don't validate if fields are empty
        }
        
        const now = new Date();
        const startDateTime = new Date(startDateTimeInput);
        const endDateTime = new Date(endDateTimeInput);
        
        let hasErrors = false;
        
        // Check if start datetime is in the future
        if (startDateTime <= now) {
            showDateTimeError('startDateTime', 'Start date and time must be in the future');
            hasErrors = true;
        }
        
        // Check if end datetime is after start datetime
        if (endDateTime <= startDateTime) {
            showDateTimeError('endDateTime', 'End date and time must be after start date and time');
            hasErrors = true;
        }
        
        // Show validation summary
        showValidationSummary(hasErrors);
        
        return !hasErrors;
    }
    
    function showDateTimeError(fieldId, message) {
        const field = document.getElementById(fieldId);
        const errorDiv = document.getElementById(fieldId + 'Error');
        
        field.classList.add('border-red-500', 'focus:border-red-500', 'focus:ring-red-500');
        errorDiv.textContent = message;
        errorDiv.classList.remove('hidden');
    }
    
    function clearDateTimeErrors() {
        const fields = ['startDateTime', 'endDateTime'];
        fields.forEach(fieldId => {
            const field = document.getElementById(fieldId);
            const errorDiv = document.getElementById(fieldId + 'Error');
            
            field.classList.remove('border-red-500', 'focus:border-red-500', 'focus:ring-red-500');
            field.classList.add('border-gray-300', 'dark:border-gray-600');
            errorDiv.classList.add('hidden');
        });
    }
    
    function showValidationSummary(hasErrors) {
        const summary = document.getElementById('dateTimeValidationSummary');
        const message = document.getElementById('validationMessage');
        
        if (hasErrors) {
            summary.classList.remove('hidden');
            summary.classList.remove('bg-green-50', 'border-green-200', 'text-green-800');
            summary.classList.add('bg-red-50', 'border-red-200', 'text-red-800');
            message.textContent = 'Please fix the date and time validation errors above.';
        } else {
            summary.classList.remove('hidden');
            summary.classList.remove('bg-red-50', 'border-red-200', 'text-red-800');
            summary.classList.add('bg-green-50', 'border-green-200', 'text-green-800');
            message.textContent = '✅ Date and time validation passed!';
        }
    }
    
    function validateFormBeforeSubmit() {
        return validateDateTime();
    }


    // Notification system
    function showNotification(message, type = 'info') {
        // Remove existing notifications
        const existingNotifications = document.querySelectorAll('.notification');
        existingNotifications.forEach(notification => notification.remove());
        
        // Create notification element
        const notification = document.createElement('div');
        notification.className = `notification fixed top-4 right-4 z-50 p-3 rounded-lg shadow-lg max-w-sm transform transition-all duration-300 translate-x-full`;
        
        // Set colors based on type
        if (type === 'success') {
            notification.classList.add('bg-green-500', 'text-white');
        } else if (type === 'error') {
            notification.classList.add('bg-red-500', 'text-white');
        } else {
            notification.classList.add('bg-blue-500', 'text-white');
        }
        
        notification.innerHTML = `
            <div class="flex items-center">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
                <span class="text-sm">${message}</span>
                <button onclick="this.parentElement.parentElement.remove()" class="ml-3 text-white hover:text-gray-200">
                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
        `;
        
        document.body.appendChild(notification);
        
        // Animate in
        setTimeout(() => {
            notification.classList.remove('translate-x-full');
        }, 100);
        
        // Auto remove after 5 seconds
        setTimeout(() => {
            notification.classList.add('translate-x-full');
            setTimeout(() => notification.remove(), 300);
        }, 5000);
    }

    // Initialize on page load
    document.addEventListener('DOMContentLoaded', function() {
        const negativeMarkingCheckbox = document.getElementById('negativeMarking');
        if (negativeMarkingCheckbox.checked) {
            document.getElementById('negativeMarkingInputContainer').classList.remove('hidden');
        }
        
        // Initial validation
        validateDateTime();
        
        // Initialize rich text editor for question header
        initializeQuestionHeaderEditor();
    });

    // Rich Text Editor for Question Header
    function initializeQuestionHeaderEditor() {
        const editor = document.getElementById('questionHeaderEditor');
        const hiddenInput = document.getElementById('questionHeader');
        
        if (!editor || !hiddenInput) {
            return;
        }

        // Add toolbar above the editor
        const toolbar = document.createElement('div');
        toolbar.className = 'flex items-center space-x-1 p-2 bg-gray-50 dark:bg-gray-600 border-b border-gray-200 dark:border-gray-600 rounded-t-lg';
        toolbar.innerHTML = `
            <button type="button" class="p-1 text-gray-600 hover:text-gray-800 dark:text-gray-300 dark:hover:text-white hover:bg-gray-200 dark:hover:bg-gray-500 rounded transition-colors" onclick="execCommand('bold')" title="Bold">
                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 12h8a4 4 0 100-8H6v8z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 12h8a4 4 0 110 8H6v8z"></path></svg>
            </button>
            <button type="button" class="p-1 text-gray-600 hover:text-gray-800 dark:text-gray-300 dark:hover:text-white hover:bg-gray-200 dark:hover:bg-gray-500 rounded transition-colors" onclick="execCommand('italic')" title="Italic">
                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"></path></svg>
            </button>
            <button type="button" class="p-1 text-gray-600 hover:text-gray-800 dark:text-gray-300 dark:hover:text-white hover:bg-gray-200 dark:hover:bg-gray-500 rounded transition-colors" onclick="execCommand('underline')" title="Underline">
                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16V4m0 0L3 8m4-4l4 4m6 0v12m0 0l4-4m-4 4l-4-4"></path></svg>
            </button>
            <div class="w-px h-4 bg-gray-300 dark:bg-gray-500"></div>
            <button type="button" class="p-1 text-gray-600 hover:text-gray-800 dark:text-gray-300 dark:hover:text-white hover:bg-gray-200 dark:hover:bg-gray-500 rounded transition-colors" onclick="execCommand('justifyLeft')" title="Align Left">
                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
            </button>
            <button type="button" class="p-1 text-gray-600 hover:text-gray-800 dark:text-gray-300 dark:hover:text-white hover:bg-gray-200 dark:hover:bg-gray-500 rounded transition-colors" onclick="execCommand('justifyCenter')" title="Align Center">
                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h10M4 18h10"></path></svg>
            </button>
            <button type="button" class="p-1 text-gray-600 hover:text-gray-800 dark:text-gray-300 dark:hover:text-white hover:bg-gray-200 dark:hover:bg-gray-500 rounded transition-colors" onclick="execCommand('justifyRight')" title="Align Right">
                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h6M4 18h6"></path></svg>
            </button>
        `;
        
        // Insert toolbar before the editor
        editor.parentNode.insertBefore(toolbar, editor);
        
        // Update hidden input when editor content changes
        editor.addEventListener('input', function() {
            hiddenInput.value = editor.innerHTML;
        });
        
        // Handle paste to strip unwanted formatting
        editor.addEventListener('paste', function(e) {
            e.preventDefault();
            const text = e.clipboardData.getData('text/plain');
            document.execCommand('insertText', false, text);
        });
        
        // Handle focus and blur for placeholder
        editor.addEventListener('focus', function() {
            if (editor.textContent === '') {
                editor.classList.add('placeholder-shown');
            }
        });
        
        editor.addEventListener('blur', function() {
            if (editor.textContent === '') {
                editor.classList.remove('placeholder-shown');
            }
        });
    }

    function execCommand(command, value = null) {
        document.execCommand(command, false, value);
        document.getElementById('questionHeaderEditor').focus();
    }
</script>
@endsection