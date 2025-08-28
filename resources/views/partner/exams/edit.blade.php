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
                                    <div class="grid grid-cols-2 gap-2">
                                        <input type="date" name="startDate" id="startDate"
                                               value="{{ old('startDate', $exam->start_time ? $exam->start_time->format('Y-m-d') : '') }}" required
                                               min="{{ now()->format('Y-m-d') }}"
                                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:focus:ring-blue-400 dark:focus:border-blue-400 transition-colors duration-200"
                                               onchange="updateEndTime()">
                                        <input type="time" name="startTime" id="startTime"
                                               value="{{ old('startTime', $exam->start_time ? $exam->start_time->format('H:i') : '') }}" required
                                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:focus:ring-blue-400 dark:focus:border-blue-400 transition-colors duration-200"
                                               onchange="updateEndTime()">
                                    </div>
                                    <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Select when the exam will start</p>
                                    @error('startDate')
                                        <p class="mt-1 text-xs text-red-600 dark:text-red-400">{{ $message }}</p>
                                    @enderror
                                    @error('startTime')
                                        <p class="mt-1 text-xs text-red-600 dark:text-red-400">{{ $message }}</p>
                                    @enderror
                                </div>
                                
                                <div>
                                    <label class="block text-xs font-medium text-gray-600 dark:text-gray-400 mb-1">End Date & Time</label>
                                    <div class="grid grid-cols-2 gap-2">
                                        <input type="date" name="endDate" id="endDate"
                                               value="{{ old('endDate', $exam->end_time ? $exam->end_time->format('Y-m-d') : '') }}" required
                                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:focus:ring-blue-400 dark:focus:border-blue-400 transition-colors duration-200"
                                               onchange="calculateDuration()">
                                        <input type="time" name="endTime" id="endTime"
                                               value="{{ old('endTime', $exam->end_time ? $exam->end_time->format('H:i') : '') }}" required
                                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:focus:ring-blue-400 dark:focus:border-blue-400 transition-colors duration-200"
                                               onchange="calculateDuration()">
                                    </div>
                                    <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Select when the exam will end</p>
                                    @error('endDate')
                                        <p class="mt-1 text-xs text-red-600 dark:text-red-400">{{ $message }}</p>
                                    @enderror
                                    @error('endTime')
                                        <p class="mt-1 text-xs text-red-600 dark:text-red-400">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                Duration (minutes) <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <input type="number" name="duration" id="duration" min="15" max="480"
                                       value="{{ old('duration', $exam->duration) }}" required
                                       class="w-full px-3 py-2 pr-16 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:focus:ring-blue-400 dark:focus:border-blue-400 transition-colors duration-200"
                                       placeholder="e.g., 120"
                                       onchange="updateEndTimeFromDuration()">
                                <div class="absolute inset-y-0 right-0 flex items-center pr-3">
                                    <span class="text-sm text-gray-500 dark:text-gray-400">min</span>
                                </div>
                            </div>
                            <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Auto-calculated from start/end times</p>
                            @error('duration')
                                <p class="mt-1 text-xs text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                            
                            <!-- Duration Preview -->
                            <div class="mt-3 p-3 bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center space-x-2">
                                        <svg class="w-4 h-4 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        <span class="text-sm font-medium text-blue-800 dark:text-blue-200">Duration Preview:</span>
                                    </div>
                                    <span class="text-sm text-blue-700 dark:text-blue-300" id="duration-preview">
                                        @if($exam->start_time && $exam->end_time)
                                            {{ $exam->start_time->diffInMinutes($exam->end_time) }} minutes
                                        @else
                                            Set start and end times to see duration
                                        @endif
                                    </span>
                                </div>
                                
                                <!-- Quick Duration Presets -->
                                <div class="mt-3 pt-3 border-t border-blue-200 dark:border-blue-700">
                                    <div class="flex items-center space-x-2">
                                        <span class="text-xs font-medium text-blue-700 dark:text-blue-300">Quick Presets:</span>
                                        <div class="flex flex-wrap gap-2">
                                            <button type="button" onclick="setDuration(30)" class="px-2 py-1 text-xs bg-blue-100 hover:bg-blue-200 text-blue-700 rounded border border-blue-300 transition-colors duration-200">30 min</button>
                                            <button type="button" onclick="setDuration(60)" class="px-2 py-1 text-xs bg-blue-100 hover:bg-blue-200 text-blue-700 rounded border border-blue-300 transition-colors duration-200">1 hour</button>
                                            <button type="button" onclick="setDuration(90)" class="px-2 py-1 text-xs bg-blue-100 hover:bg-blue-200 text-blue-700 rounded border border-blue-300 transition-colors duration-200">1.5 hours</button>
                                            <button type="button" onclick="setDuration(120)" class="px-2 py-1 text-xs bg-blue-100 hover:bg-blue-200 text-blue-700 rounded border border-blue-300 transition-colors duration-200">2 hours</button>
                                            <button type="button" onclick="setDuration(180)" class="px-2 py-1 text-xs bg-blue-100 hover:bg-blue-200 text-blue-700 rounded border border-blue-300 transition-colors duration-200">3 hours</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>



                    <!-- Validation Messages -->
                    <div class="mt-3 p-3 bg-yellow-50 dark:bg-yellow-900/20 border border-yellow-200 dark:border-yellow-800 rounded-lg" id="validation-message" style="display: none;">
                        <div class="flex items-center space-x-2">
                            <svg class="w-4 h-4 text-yellow-600 dark:text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                            </svg>
                            <span class="text-sm text-yellow-700 dark:text-yellow-300" id="validation-text"></span>
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

    // Function to update min attribute of endTime input
    function updateEndTimeMin() {
        const startDateTime = new Date(document.getElementById('startDate').value + 'T' + document.getElementById('startTime').value);
        const endDateTime = new Date(document.getElementById('endDate').value + 'T' + document.getElementById('endTime').value);

        if (startDateTime > endDateTime) {
            endDateTime.setMinutes(startDateTime.getMinutes() + 1); // Ensure end time is at least 1 minute after start
            document.getElementById('endTime').value = endDateTime.toISOString().slice(11, 16); // Format to HH:MM
        }
    }

    // Function to update end time when start time changes
    function updateEndTime() {
        const startDate = document.getElementById('startDate').value;
        const startTime = document.getElementById('startTime').value;
        const duration = parseInt(document.getElementById('duration').value) || 120;
        
        if (startDate && startTime && duration > 0) {
            try {
                const startDateTime = new Date(startDate + 'T' + startTime);
                if (isNaN(startDateTime.getTime())) {
                    console.error('Invalid start time:', startDate + 'T' + startTime);
                    return;
                }
                
                const endDateTime = new Date(startDateTime.getTime() + (duration * 60 * 1000));
                const endTimeString = endDateTime.toISOString().slice(0, 16); // YYYY-MM-DDTHH:MM
                document.getElementById('endTime').value = endTimeString.slice(11, 16); // HH:MM
                
                updateDurationPreview();
                console.log('End time updated:', endTimeString);
            } catch (error) {
                console.error('Error updating end time:', error);
            }
        }
    }

    // Function to calculate duration and update endTime input
    function calculateDuration() {
        const startDate = document.getElementById('startDate').value;
        const startTime = document.getElementById('startTime').value;
        const endDate = document.getElementById('endDate').value;
        const endTime = document.getElementById('endTime').value;
        const durationInput = document.getElementById('duration');
        const durationPreview = document.getElementById('duration-preview');

        if (startDate && startTime && endDate && endTime) {
            const startDateTime = new Date(startDate + 'T' + startTime);
            const endDateTime = new Date(endDate + 'T' + endTime);
            const duration = endDateTime.getTime() - startDateTime.getTime();
            const minutes = Math.floor(duration / (1000 * 60));
            durationInput.value = minutes;
            durationPreview.textContent = `${minutes} minutes`;
        } else {
            durationInput.value = '';
            durationPreview.textContent = 'Set start and end times to see duration';
        }
    }

    // Function to update endTime input from duration input
    function updateEndTimeFromDuration() {
        const startDate = document.getElementById('startDate').value;
        const startTime = document.getElementById('startTime').value;
        const durationInput = document.getElementById('duration');
        const durationPreview = document.getElementById('duration-preview');

        if (startDate && startTime) {
            const startDateTime = new Date(startDate + 'T' + startTime);
            const minutes = parseInt(durationInput.value) || 0;
            const endDateTime = new Date(startDateTime.getTime() + minutes * 60000); // Add minutes in milliseconds
            const endTimeString = endDateTime.toISOString().slice(0, 16); // YYYY-MM-DDTHH:MM
            document.getElementById('endTime').value = endTimeString.slice(11, 16); // HH:MM
            durationPreview.textContent = `${minutes} minutes`;
        } else {
            document.getElementById('endTime').value = '';
            durationPreview.textContent = 'Set start and end times to see duration';
        }
    }

    // Function to update duration preview
    function updateDurationPreview() {
        const startDate = document.getElementById('startDate').value;
        const startTime = document.getElementById('startTime').value;
        const endDate = document.getElementById('endDate').value;
        const endTime = document.getElementById('endTime').value;
        const durationPreview = document.getElementById('duration-preview');
        
        if (startDate && startTime && endDate && endTime) {
            try {
                const startDateTime = new Date(startDate + 'T' + startTime);
                const endDateTime = new Date(endDate + 'T' + endTime);
                
                if (isNaN(startDateTime.getTime()) || isNaN(endDateTime.getTime())) {
                    durationPreview.textContent = 'Set start and end times to see duration';
                    return;
                }
                
                const durationMinutes = Math.round((endDateTime.getTime() - startDateTime.getTime()) / (1000 * 60));
                
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

    // Function to set duration from quick presets
    function setDuration(minutes) {
        const startDate = document.getElementById('startDate').value;
        const startTime = document.getElementById('startTime').value;
        if (!startDate || !startTime) {
            showValidationMessage('Please set a start date and time first');
            return;
        }
        
        const startDateTime = new Date(startDate + 'T' + startTime);
        if (isNaN(startDateTime.getTime())) {
            showValidationMessage('Invalid start date/time');
            return;
        }
        
        const endDateTime = new Date(startDateTime.getTime() + minutes * 60000); // Add minutes in milliseconds
        const endTimeString = endDateTime.toISOString().slice(0, 16); // YYYY-MM-DDTHH:MM
        document.getElementById('endTime').value = endTimeString.slice(11, 16); // HH:MM
        document.getElementById('duration').value = minutes;
        updateDurationPreview(); // Update preview
        hideValidationMessage();
    }

    // Function to show validation message
    function showValidationMessage(message) {
        document.getElementById('validation-text').textContent = message;
        document.getElementById('validation-message').style.display = 'block';
    }

    // Function to hide validation message
    function hideValidationMessage() {
        document.getElementById('validation-message').style.display = 'none';
    }

    // Function to validate datetime inputs
    function validateDateTimeInputs() {
        const startDate = document.getElementById('startDate').value;
        const startTime = document.getElementById('startTime').value;
        const endDate = document.getElementById('endDate').value;
        const endTime = document.getElementById('endTime').value;
        
        if (!startDate || !startTime || !endDate || !endTime) {
            return true; // Let HTML5 validation handle required fields
        }
        
        const startDateTime = new Date(startDate + 'T' + startTime);
        const endDateTime = new Date(endDate + 'T' + endTime);
        const now = new Date();
        
        // Check if start time is in the past
        if (startDateTime < now) {
            showValidationMessage('Start time cannot be in the past');
            return false;
        }
        
        // Check if end time is before start time
        if (endDateTime <= startDateTime) {
            showValidationMessage('End time must be after start time');
            return false;
        }
        
        // Check if duration is reasonable (not more than 24 hours)
        const duration = endDateTime.getTime() - startDateTime.getTime();
        const hours = duration / (1000 * 60 * 60);
        if (hours > 24) {
            showValidationMessage('Exam duration cannot exceed 24 hours');
            return false;
        }
        
        hideValidationMessage();
        return true;
    }

    // Add event listeners for validation and updates
    document.getElementById('startDate').addEventListener('change', function() {
        updateEndTimeMin(); // Update end time min based on new start date
        validateDateTimeInputs();
        updateEndTime();
    });
    document.getElementById('startTime').addEventListener('change', function() {
        updateEndTimeMin(); // Update end time min based on new start time
        validateDateTimeInputs();
        updateEndTime();
    });
    document.getElementById('endDate').addEventListener('change', function() {
        validateDateTimeInputs();
        calculateDuration();
    });
    document.getElementById('endTime').addEventListener('change', function() {
        validateDateTimeInputs();
        calculateDuration();
    });
    
    // Initialize duration preview on page load
    window.addEventListener('load', function() {
        updateDurationPreview();
    });
    document.getElementById('duration').addEventListener('change', validateDateTimeInputs);

    // Form submission validation
    document.querySelector('form').addEventListener('submit', function(e) {
        if (!validateDateTimeInputs()) {
            e.preventDefault();
            return false;
        }
    });

    // Initial calculation on page load
    calculateDuration();
    validateDateTimeInputs();
});
</script>
@endpush
