@extends('layouts.partner-layout')

@section('title', 'Create New Exam')

@section('content')
<style>
    /* Custom scrollbar */
    .custom-scrollbar::-webkit-scrollbar {
        width: 6px;
    }
    .custom-scrollbar::-webkit-scrollbar-track {
        background: #f1f5f9;
        border-radius: 3px;
    }
    .custom-scrollbar::-webkit-scrollbar-thumb {
        background: #cbd5e1;
        border-radius: 3px;
    }
    .custom-scrollbar::-webkit-scrollbar-thumb:hover {
        background: #94a3b8;
    }

    /* Gradient backgrounds */
    .gradient-bg {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    }
    
    .gradient-bg-secondary {
        background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
    }

    /* Card hover effects */
    .card-hover {
        transition: all 0.3s ease;
    }
    
    .card-hover:hover {
        transform: translateY(-2px);
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
    }

    /* Toggle switch styling */
    .toggle-switch {
        position: relative;
        display: inline-block;
        width: 60px;
        height: 30px;
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
        border-radius: 30px;
    }
    
    .slider:before {
        position: absolute;
        content: "";
        height: 22px;
        width: 22px;
        left: 4px;
        bottom: 4px;
        background-color: white;
        transition: 0.3s;
        border-radius: 50%;
        box-shadow: 0 2px 4px rgba(0,0,0,0.2);
    }
    
    input:checked + .slider {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    }
    
    input:checked + .slider:before {
        transform: translateX(30px);
    }

    /* Progress indicator */
    .progress-step {
        transition: all 0.3s ease;
    }
    
    .progress-step.active {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        transform: scale(1.1);
    }

    /* Form section animations */
    .form-section {
        opacity: 0;
        transform: translateY(20px);
        animation: fadeInUp 0.6s ease forwards;
    }
    
    @keyframes fadeInUp {
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    .form-section:nth-child(1) { animation-delay: 0.1s; }
    .form-section:nth-child(2) { animation-delay: 0.2s; }
    .form-section:nth-child(3) { animation-delay: 0.3s; }
    .form-section:nth-child(4) { animation-delay: 0.4s; }
</style>

<div class="min-h-screen bg-gradient-to-br from-slate-50 via-blue-50 to-indigo-50 dark:from-slate-900 dark:via-slate-800 dark:to-slate-900 py-8">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Header Section -->
        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center w-16 h-16 bg-gradient-to-r from-indigo-500 to-purple-600 rounded-full mb-4 shadow-lg">
                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                </svg>
            </div>
            <h1 class="text-4xl font-bold text-gray-900 dark:text-white mb-2">Create New Exam</h1>
            <p class="text-lg text-gray-600 dark:text-gray-300">Set up your exam with all the necessary details and configurations</p>
        </div>

        <!-- Progress Indicator -->
        <div class="flex justify-center mb-8">
            <div class="flex items-center space-x-4">
                <div class="progress-step active flex items-center justify-center w-10 h-10 bg-gradient-to-r from-indigo-500 to-purple-600 text-white rounded-full font-semibold shadow-lg">
                    1
                </div>
                <div class="w-16 h-1 bg-gray-200 dark:bg-gray-700 rounded-full"></div>
                <div class="progress-step flex items-center justify-center w-10 h-10 bg-gray-200 dark:bg-gray-700 text-gray-600 dark:text-gray-400 rounded-full font-semibold">
                    2
                </div>
                <div class="w-16 h-1 bg-gray-200 dark:bg-gray-700 rounded-full"></div>
                <div class="progress-step flex items-center justify-center w-10 h-10 bg-gray-200 dark:bg-gray-700 text-gray-600 dark:text-gray-400 rounded-full font-semibold">
                    3
                </div>
            </div>
        </div>

        <!-- Error Messages -->
        @if ($errors->any())
            <div class="mb-8 p-6 bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-2xl shadow-lg">
                <div class="flex items-start">
                    <div class="flex-shrink-0">
                        <svg class="h-6 w-6 text-red-400 dark:text-red-500 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.34 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-lg font-medium text-red-800 dark:text-red-200">Please fix the following errors:</h3>
                        <div class="mt-3 text-sm text-red-700 dark:text-red-300">
                            <ul class="list-disc pl-5 space-y-2">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        <!-- Form -->
        <form id="examForm" action="{{ route('partner.exams.store') }}" method="POST" class="space-y-8">
            @csrf

            <!-- Section 1: Basic Details -->
            <div class="form-section bg-white dark:bg-slate-800 rounded-3xl shadow-xl p-8 card-hover">
                <div class="flex items-center mb-6">
                    <div class="w-12 h-12 bg-gradient-to-r from-blue-500 to-cyan-500 rounded-2xl flex items-center justify-center mr-4">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div>
                        <h2 class="text-2xl font-bold text-gray-900 dark:text-white">Basic Details</h2>
                        <p class="text-gray-600 dark:text-gray-300">Essential information about your exam</p>
                    </div>
                </div>

                <div class="grid md:grid-cols-2 gap-8">
                    <div class="space-y-6">
                        <div>
                            <label for="examTitle" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-3">Exam Title *</label>
                            <input type="text" id="examTitle" name="title" value="{{ old('title') }}" 
                                   placeholder="e.g., Mid-Term Mathematics Exam" required 
                                   class="w-full px-4 py-4 border-2 border-gray-200 dark:border-gray-600 rounded-2xl focus:ring-4 focus:ring-blue-500/20 focus:border-blue-500 dark:bg-slate-700 dark:text-white transition-all duration-300 text-lg">
                            @error('title')
                                <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="examType" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-3">Exam Type *</label>
                            <select id="examType" name="exam_type" required 
                                    class="w-full px-4 py-4 border-2 border-gray-200 dark:border-gray-600 rounded-2xl focus:ring-4 focus:ring-blue-500/20 focus:border-blue-500 dark:bg-slate-700 dark:text-white transition-all duration-300 text-lg">
                                <option value="online" {{ old('exam_type', 'online') === 'online' ? 'selected' : '' }}>🖥️ Online Exam</option>
                                <option value="offline" {{ old('exam_type', 'online') === 'offline' ? 'selected' : '' }}>📝 Offline Exam</option>
                            </select>
                            @error('exam_type')
                                <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="description" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-3">Description</label>
                            <textarea id="description" name="description" rows="4" 
                                      placeholder="Provide a detailed description of the exam, topics covered, and any special instructions..." 
                                      class="w-full px-4 py-4 border-2 border-gray-200 dark:border-gray-600 rounded-2xl focus:ring-4 focus:ring-blue-500/20 focus:border-blue-500 dark:bg-slate-700 dark:text-white transition-all duration-300 resize-none">{{ old('description') }}</textarea>
                            @error('description')
                                <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="space-y-6">
                        <div>
                            <label for="totalQuestions" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-3">Total Questions *</label>
                            <input type="number" id="totalQuestions" name="total_questions" value="{{ old('total_questions') }}" 
                                   min="1" max="100" required 
                                   class="w-full px-4 py-4 border-2 border-gray-200 dark:border-gray-600 rounded-2xl focus:ring-4 focus:ring-blue-500/20 focus:border-blue-500 dark:bg-slate-700 dark:text-white transition-all duration-300 text-lg">
                            @error('total_questions')
                                <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="duration" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-3">Duration (minutes) *</label>
                            <input type="number" id="duration" name="duration" value="{{ old('duration') }}" 
                                   min="15" max="480" required 
                                   class="w-full px-4 py-4 border-2 border-gray-200 dark:border-gray-600 rounded-2xl focus:ring-4 focus:ring-blue-500/20 focus:border-blue-500 dark:bg-slate-700 dark:text-white transition-all duration-300 text-lg">
                            @error('duration')
                                <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="passingMarks" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-3">Passing Marks (%) *</label>
                            <input type="number" id="passingMarks" name="passing_marks" value="{{ old('passing_marks') }}" 
                                   min="0" max="100" required 
                                   class="w-full px-4 py-4 border-2 border-gray-200 dark:border-gray-600 rounded-2xl focus:ring-4 focus:ring-blue-500/20 focus:border-blue-500 dark:bg-slate-700 dark:text-white transition-all duration-300 text-lg">
                            @error('passing_marks')
                                <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="questionHeader" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-3">Question Header</label>
                            <div class="relative">
                                <div id="questionHeaderEditor" class="w-full min-h-[120px] border-2 border-gray-200 dark:border-gray-600 rounded-2xl focus-within:ring-4 focus-within:ring-blue-500/20 focus-within:border-blue-500 dark:bg-slate-700 dark:text-white transition-all duration-300" contenteditable="true" data-placeholder="Enter question header text... You can use formatting, multiple lines, and styling."></div>
                                <input type="hidden" id="questionHeader" name="question_header" value="{{ old('question_header') }}">
                            </div>
                            @error('question_header')
                                <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            <!-- Section 2: Schedule & Timing -->
            <div class="form-section bg-white dark:bg-slate-800 rounded-3xl shadow-xl p-8 card-hover">
                <div class="flex items-center mb-6">
                    <div class="w-12 h-12 bg-gradient-to-r from-emerald-500 to-teal-500 rounded-2xl flex items-center justify-center mr-4">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h.01M9 16h.01M15 16h.01M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                    <div>
                        <h2 class="text-2xl font-bold text-gray-900 dark:text-white">Schedule & Timing</h2>
                        <p class="text-gray-600 dark:text-gray-300">Set when your exam starts and ends</p>
                    </div>
                </div>

                <div class="grid md:grid-cols-2 gap-8">
                    <div>
                        <label for="startDateTime" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-3">Start Date & Time *</label>
                        <input type="datetime-local" id="startDateTime" name="startDateTime" 
                               value="{{ old('startDateTime', now()->format('Y-m-d\TH:i')) }}" required 
                               class="w-full px-4 py-4 border-2 border-gray-200 dark:border-gray-600 rounded-2xl focus:ring-4 focus:ring-emerald-500/20 focus:border-emerald-500 dark:bg-slate-700 dark:text-white transition-all duration-300 text-lg" 
                               onchange="validateDateTime()">
                        <div id="startDateTimeError" class="mt-2 text-sm text-red-600 dark:text-red-400 hidden"></div>
                        <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">📅 Choose a future date and time</p>
                    </div>

                    <div>
                        <label for="endDateTime" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-3">End Date & Time *</label>
                        <input type="datetime-local" id="endDateTime" name="endDateTime" 
                               value="{{ old('endDateTime', now()->addHours(2)->format('Y-m-d\TH:i')) }}" required 
                               class="w-full px-4 py-4 border-2 border-gray-200 dark:border-gray-600 rounded-2xl focus:ring-4 focus:ring-emerald-500/20 focus:border-emerald-500 dark:bg-slate-700 dark:text-white transition-all duration-300 text-lg" 
                               onchange="validateDateTime()">
                        <div id="endDateTimeError" class="mt-2 text-sm text-red-600 dark:text-red-400 hidden"></div>
                        <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">⏰ Must be after start time</p>
                    </div>
                </div>

                <!-- DateTime Validation Summary -->
                <div id="dateTimeValidationSummary" class="mt-6 p-4 rounded-2xl hidden">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <span class="text-sm font-medium" id="validationMessage"></span>
                    </div>
                </div>
            </div>

            <!-- Section 3: Exam Settings -->
            <div class="form-section bg-white dark:bg-slate-800 rounded-3xl shadow-xl p-8 card-hover">
                <div class="flex items-center mb-6">
                    <div class="w-12 h-12 bg-gradient-to-r from-purple-500 to-pink-500 rounded-2xl flex items-center justify-center mr-4">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                    </div>
                    <div>
                        <h2 class="text-2xl font-bold text-gray-900 dark:text-white">Exam Settings</h2>
                        <p class="text-gray-600 dark:text-gray-300">Configure advanced options and preferences</p>
                    </div>
                </div>

                <div class="grid md:grid-cols-2 gap-8">
                    <div class="space-y-6">
                        <div class="flex items-center justify-between p-4 bg-gray-50 dark:bg-slate-700 rounded-2xl">
                            <div>
                                <h3 class="font-semibold text-gray-900 dark:text-white">Allow Retake</h3>
                                <p class="text-sm text-gray-600 dark:text-gray-400">Students can retake the exam if they fail</p>
                            </div>
                            <label class="toggle-switch">
                                <input type="checkbox" id="allowRetake" name="allow_retake" value="1" {{ old('allow_retake') ? 'checked' : '' }}>
                                <span class="slider"></span>
                            </label>
                        </div>

                        <div class="flex items-center justify-between p-4 bg-gray-50 dark:bg-slate-700 rounded-2xl">
                            <div>
                                <h3 class="font-semibold text-gray-900 dark:text-white">Show Results Immediately</h3>
                                <p class="text-sm text-gray-600 dark:text-gray-400">Display results right after exam completion</p>
                            </div>
                            <label class="toggle-switch">
                                <input type="checkbox" id="showResults" name="show_results_immediately" value="1" {{ old('show_results_immediately', true) ? 'checked' : '' }}>
                                <span class="slider"></span>
                            </label>
                        </div>
                    </div>

                    <div class="space-y-6">
                        <div class="p-4 bg-gray-50 dark:bg-slate-700 rounded-2xl">
                            <div class="flex items-center justify-between mb-4">
                                <h3 class="font-semibold text-gray-900 dark:text-white">Negative Marking</h3>
                                <label class="toggle-switch">
                                    <input type="checkbox" id="negativeMarking" name="has_negative_marking" value="1" {{ old('has_negative_marking') ? 'checked' : '' }} onchange="toggleNegativeMarkingInput(this)">
                                    <span class="slider"></span>
                                </label>
                            </div>
                            <div id="negativeMarkingInputContainer" class="{{ old('has_negative_marking') ? '' : 'hidden' }}">
                                <label for="negativeMarkingInput" class="block text-sm text-gray-600 dark:text-gray-400 mb-2">Marks per wrong answer:</label>
                                <input type="number" id="negativeMarkingInput" name="negative_marks_per_question" 
                                       value="{{ old('negative_marks_per_question') }}" min="0" max="5" step="0.25" 
                                       class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-purple-500 dark:bg-slate-600 dark:text-white">
                            </div>
                        </div>


                    </div>
                </div>
            </div>

            <!-- Section 4: Action Buttons -->
            <div class="form-section bg-white dark:bg-slate-800 rounded-3xl shadow-xl p-8 card-hover">
                <div class="flex flex-col sm:flex-row items-center justify-between space-y-4 sm:space-y-0">
                    <div class="text-center sm:text-left">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Ready to create your exam?</h3>
                        <p class="text-gray-600 dark:text-gray-400">Review all details before proceeding</p>
                    </div>
                    <div class="flex space-x-4">
                        <a href="{{ route('partner.exams.index') }}" 
                           class="px-8 py-4 border-2 border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 font-semibold rounded-2xl hover:bg-gray-50 dark:hover:bg-slate-700 transition-all duration-300">
                            Cancel
                        </a>
                        <button type="button" id="saveDraftBtn" 
                                class="px-8 py-4 bg-gradient-to-r from-amber-500 to-orange-500 text-white font-semibold rounded-2xl hover:from-amber-600 hover:to-orange-600 transform hover:scale-105 transition-all duration-300 shadow-lg" 
                                onclick="saveAsDraft()">
                            💾 Save Draft
                        </button>
                        <button type="submit" form="examForm" 
                                class="px-8 py-4 bg-gradient-to-r from-indigo-500 to-purple-600 text-white font-semibold rounded-2xl hover:from-indigo-600 hover:to-purple-700 transform hover:scale-105 transition-all duration-300 shadow-lg" 
                                onclick="return validateFormBeforeSubmit()">
                            🚀 Create Exam
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
        if (checkbox.checked) {
            inputContainer.classList.remove('hidden');
        } else {
            inputContainer.classList.add('hidden');
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
        
        field.classList.add('border-red-500', 'focus:border-red-500', 'focus:ring-red-500/20');
        errorDiv.textContent = message;
        errorDiv.classList.remove('hidden');
    }
    
    function clearDateTimeErrors() {
        const fields = ['startDateTime', 'endDateTime'];
        fields.forEach(fieldId => {
            const field = document.getElementById(fieldId);
            const errorDiv = document.getElementById(fieldId + 'Error');
            
            field.classList.remove('border-red-500', 'focus:border-red-500', 'focus:ring-red-500/20');
            field.classList.add('border-gray-200', 'dark:border-gray-600');
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

    // Initialize on page load
    document.addEventListener('DOMContentLoaded', function() {
        const negativeMarkingCheckbox = document.getElementById('negativeMarking');
        if (negativeMarkingCheckbox.checked) {
            document.getElementById('negativeMarkingInputContainer').classList.remove('hidden');
        }
        
        // Initial validation
        validateDateTime();
        
        // Add progress step functionality
        const progressSteps = document.querySelectorAll('.progress-step');
        progressSteps.forEach((step, index) => {
            step.addEventListener('click', () => {
                progressSteps.forEach(s => s.classList.remove('active'));
                step.classList.add('active');
            });
        });

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
        toolbar.className = 'flex items-center space-x-2 p-2 bg-gray-50 dark:bg-slate-600 border-b border-gray-200 dark:border-gray-600 rounded-t-2xl';
        toolbar.innerHTML = `
            <button type="button" class="p-2 text-gray-600 hover:text-gray-800 dark:text-gray-300 dark:hover:text-white hover:bg-gray-200 dark:hover:bg-slate-500 rounded transition-colors" onclick="execCommand('bold')" title="Bold">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 12h8a4 4 0 100-8H6v8z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 12h8a4 4 0 110 8H6v8z"></path></svg>
            </button>
            <button type="button" class="p-2 text-gray-600 hover:text-gray-800 dark:text-gray-300 dark:hover:text-white hover:bg-gray-200 dark:hover:bg-slate-500 rounded transition-colors" onclick="execCommand('italic')" title="Italic">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"></path></svg>
            </button>
            <button type="button" class="p-2 text-gray-600 hover:text-gray-800 dark:text-gray-300 dark:hover:text-white hover:bg-gray-200 dark:hover:bg-slate-500 rounded transition-colors" onclick="execCommand('underline')" title="Underline">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16V4m0 0L3 8m4-4l4 4m6 0v12m0 0l4-4m-4 4l-4-4"></path></svg>
            </button>
            <div class="w-px h-6 bg-gray-300 dark:bg-gray-500"></div>
            <button type="button" class="p-2 text-gray-600 hover:text-gray-800 dark:text-gray-300 dark:hover:text-white hover:bg-gray-200 dark:hover:bg-slate-500 rounded transition-colors" onclick="execCommand('justifyLeft')" title="Align Left">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
            </button>
            <button type="button" class="p-4 text-gray-600 hover:text-gray-800 dark:text-gray-300 dark:hover:text-white hover:bg-gray-200 dark:hover:bg-slate-500 rounded transition-colors" onclick="execCommand('justifyCenter')" title="Align Center">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h10M4 18h10"></path></svg>
            </button>
            <button type="button" class="p-2 text-gray-600 hover:text-gray-800 dark:text-gray-300 dark:hover:text-white hover:bg-gray-200 dark:hover:bg-slate-500 rounded transition-colors" onclick="execCommand('justifyRight')" title="Align Right">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h6M4 18h6"></path></svg>
            </button>
            <div class="w-px h-6 bg-gray-300 dark:bg-gray-500"></div>
            <select class="p-2 text-sm border border-gray-300 dark:border-gray-600 rounded bg-white dark:bg-slate-700 text-gray-700 dark:text-gray-300" onchange="execCommand('fontSize', this.value)">
                <option value="1">Small</option>
                <option value="3" selected>Normal</option>
                <option value="5">Large</option>
                <option value="7">Extra Large</option>
            </select>
            <select class="p-2 text-sm border border-gray-300 dark:border-gray-600 rounded bg-white dark:bg-slate-700 text-gray-700 dark:text-gray-300" onchange="execCommand('fontName', this.value)">
                <option value="Arial">Arial</option>
                <option value="Times New Roman">Times New Roman</option>
                <option value="Courier New">Courier New</option>
                <option value="Georgia">Georgia</option>
                <option value="Verdana">Verdana</option>
            </select>
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

    // Save as Draft functionality
    function saveAsDraft() {
        const form = document.getElementById('examForm');
        const formData = new FormData(form);
        
        // Add a flag to indicate this is a draft save
        formData.append('is_draft', '1');
        
        // Show loading state
        const saveDraftBtn = document.getElementById('saveDraftBtn');
        const originalText = saveDraftBtn.innerHTML;
        saveDraftBtn.innerHTML = '💾 Saving...';
        saveDraftBtn.disabled = true;
        
        // Send AJAX request to save draft
        fetch('{{ route("partner.exams.store") }}', {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
                'Accept': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Show success message
                showNotification('Draft saved successfully!', 'success');
                
                // Optionally redirect to the exam edit page or index
                setTimeout(() => {
                    if (data.exam_id) {
                        window.location.href = `{{ route('partner.exams.index') }}?draft_saved=1`;
                    } else {
                        window.location.href = '{{ route("partner.exams.index") }}';
                    }
                }, 1500);
            } else {
                showNotification('Error saving draft: ' + (data.message || 'Unknown error'), 'error');
                // Restore button state
                saveDraftBtn.innerHTML = originalText;
                saveDraftBtn.disabled = false;
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showNotification('An error occurred while saving the draft.', 'error');
            // Restore button state
            saveDraftBtn.innerHTML = originalText;
            saveDraftBtn.disabled = false;
        });
    }

    // Notification system
    function showNotification(message, type = 'info') {
        // Remove existing notifications
        const existingNotifications = document.querySelectorAll('.notification');
        existingNotifications.forEach(notification => notification.remove());
        
        // Create notification element
        const notification = document.createElement('div');
        notification.className = `notification fixed top-4 right-4 z-50 p-4 rounded-lg shadow-lg max-w-sm transform transition-all duration-300 translate-x-full`;
        
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
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
                <span>${message}</span>
                <button onclick="this.parentElement.parentElement.remove()" class="ml-4 text-white hover:text-gray-200">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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
</script>
@endsection 
