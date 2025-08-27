@extends('layouts.partner-layout')

@section('title', 'Create Exam')

@section('content')
<div class="min-h-screen bg-gray-50 dark:bg-gray-900 py-8">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Page Header -->
        <div class="mb-8">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Create New Exam</h1>
                    <p class="mt-2 text-gray-600 dark:text-gray-400">Schedule and configure a new examination</p>
                </div>
                <a href="{{ route('partner.exams.index') }}" 
                   class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:bg-gray-800 dark:border-gray-600 dark:text-gray-300 dark:hover:bg-gray-700">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Back to Exams
                </a>
            </div>
        </div>

        <!-- Main Form -->
        <div class="bg-white dark:bg-gray-800 shadow-xl rounded-lg overflow-hidden">
            <!-- Error Messages -->
            @if ($errors->any())
                <div class="px-6 py-4 bg-red-50 border-b border-red-200">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-sm font-medium text-red-800">
                                There were some errors with your submission:
                            </h3>
                            <div class="mt-2 text-sm text-red-700">
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

            <form action="{{ route('partner.exams.store') }}" method="POST" class="space-y-8">
                @csrf

                <!-- Basic Information Section -->
                <div class="px-6 py-6 border-b border-gray-200 dark:border-gray-700">
                    <div class="flex items-center mb-6">
                        <div class="flex-shrink-0">
                            <div class="w-8 h-8 bg-blue-100 dark:bg-blue-900 rounded-lg flex items-center justify-center">
                                <svg class="w-5 h-5 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                            </div>
                        </div>
                        <div class="ml-4">
                            <h2 class="text-xl font-semibold text-gray-900 dark:text-white">Basic Information</h2>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Enter the fundamental details of your exam</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Exam Title <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="title" value="{{ old('title') }}" required
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:focus:ring-blue-400 dark:focus:border-blue-400 transition-colors duration-200"
                                   placeholder="Enter exam title">
                            @error('title')
                                <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Exam Type <span class="text-red-500">*</span>
                            </label>
                            <select name="exam_type" required
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:focus:ring-blue-400 dark:focus:border-blue-400 transition-colors duration-200">
                                <option value="online" {{ old('exam_type', 'online') === 'online' ? 'selected' : '' }}>Online Exam</option>
                                <option value="offline" {{ old('exam_type', 'online') === 'offline' ? 'selected' : '' }}>Offline Exam</option>
                            </select>
                            @error('exam_type')
                                <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="mt-6">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Description
                        </label>
                        <textarea name="description" rows="3" 
                                  class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:focus:ring-blue-400 dark:focus:border-blue-400 transition-colors duration-200"
                                  placeholder="Provide a detailed description of the exam">{{ old('description') }}</textarea>
                        @error('description')
                            <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mt-6">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Question Head/Instructions
                        </label>
                        <textarea name="question_head" rows="2" 
                                  class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:focus:ring-blue-400 dark:focus:border-blue-400 transition-colors duration-200"
                                  placeholder="Special instructions or header text for questions">{{ old('question_head') }}</textarea>
                        @error('question_head')
                            <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Timing & Duration Section -->
                <div class="px-6 py-6 border-b border-gray-200 dark:border-gray-700">
                    <div class="flex items-center mb-6">
                        <div class="flex-shrink-0">
                            <div class="w-8 h-8 bg-green-100 dark:bg-green-900 rounded-lg flex items-center justify-center">
                                <svg class="w-5 h-5 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                        </div>
                        <div class="ml-4">
                            <h2 class="text-xl font-semibold text-gray-900 dark:text-white">Timing & Duration</h2>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Set exam schedule and time limits</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Start Date & Time <span class="text-red-500">*</span>
                            </label>
                            <input type="datetime-local" name="start_time" 
                                   value="{{ old('start_time', now()->addDay()->format('Y-m-d\TH:i')) }}" 
                                   min="{{ now()->addHour()->format('Y-m-d\TH:i') }}"
                                   required
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:focus:ring-green-400 dark:focus:border-green-400 transition-colors duration-200">
                            <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Select when the exam will start</p>
                            @error('start_time')
                                <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Duration <span class="text-red-500">*</span>
                            </label>
                            <input type="number" name="duration" value="{{ old('duration', 120) }}" min="15" max="480" required
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:focus:ring-green-400 dark:focus:border-green-400 transition-colors duration-200"
                                   placeholder="120">
                            <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Minutes (15 min - 8 hours)</p>
                            @error('duration')
                                <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                End Time <span class="text-red-500">*</span>
                            </label>
                            <input type="datetime-local" name="end_time" 
                                   value="{{ old('end_time', now()->addDay()->addHours(2)->format('Y-m-d\TH:i')) }}" 
                                   required
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:focus:ring-green-400 dark:focus:border-green-400 transition-colors duration-200">
                            <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Auto-calculated based on start time + duration</p>
                            @error('end_time')
                                <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Exam Configuration Section -->
                <div class="px-6 py-6 border-b border-gray-200 dark:border-gray-700">
                    <div class="flex items-center mb-6">
                        <div class="flex-shrink-0">
                            <div class="w-8 h-8 bg-purple-100 dark:bg-purple-900 rounded-lg flex items-center justify-center">
                                <svg class="w-5 h-5 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                                </svg>
                            </div>
                        </div>
                        <div class="ml-4">
                            <h2 class="text-xl font-semibold text-gray-900 dark:text-white">Exam Configuration</h2>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Configure exam settings and requirements</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                        <div class="max-w-[10rem]">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Total Questions <span class="text-red-500">*</span>
                            </label>
                            <input type="number" name="total_questions" value="{{ old('total_questions', 10) }}" min="1" max="100" required
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:focus:ring-purple-400 dark:focus:border-purple-400 transition-colors duration-200"
                                   placeholder="e.g., 25">
                            @error('total_questions')
                                <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="max-w-[10rem]">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Passing Marks (%) <span class="text-red-500">*</span>
                            </label>
                            <input type="number" name="passing_marks" value="{{ old('passing_marks', 60) }}" min="0" max="100" required
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:focus:ring-purple-400 dark:focus:border-purple-400 transition-colors duration-200"
                                   placeholder="e.g., 60">
                            @error('passing_marks')
                                <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Language
                            </label>
                            <select name="language" 
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:focus:ring-purple-400 dark:focus:border-purple-400 transition-colors duration-200">
                                <option value="english" {{ old('language', 'english') === 'english' ? 'selected' : '' }}>English</option>
                                <option value="hindi" {{ old('language', 'english') === 'hindi' ? 'selected' : '' }}>Hindi</option>
                                <option value="spanish" {{ old('language', 'english') === 'spanish' ? 'selected' : '' }}>Spanish</option>
                                <option value="french" {{ old('language', 'english') === 'french' ? 'selected' : '' }}>French</option>
                                <option value="german" {{ old('language', 'english') === 'german' ? 'selected' : '' }}>German</option>
                                <option value="chinese" {{ old('language', 'english') === 'chinese' ? 'selected' : '' }}>Chinese</option>
                                <option value="arabic" {{ old('language', 'english') === 'arabic' ? 'selected' : '' }}>Arabic</option>
                            </select>
                            @error('language')
                                <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="mt-6">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Question Limit
                        </label>
                        <input type="number" name="question_limit" value="{{ old('question_limit') }}" min="1" max="1000"
                               class="w-full max-w-[10rem] px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:focus:ring-purple-400 dark:focus:border-purple-400 transition-colors duration-200"
                               placeholder="Optional question limit">
                        <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Maximum number of questions to display (optional)</p>
                        @error('question_limit')
                            <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Exam Options Section -->
                <div class="px-6 py-6 border-b border-gray-200 dark:border-gray-700">
                    <div class="flex items-center mb-6">
                        <div class="flex-shrink-0">
                            <div class="w-8 h-8 bg-orange-100 dark:bg-orange-900 rounded-lg flex items-center justify-center">
                                <svg class="w-5 h-5 text-orange-600 dark:text-orange-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                            </div>
                        </div>
                        <div class="ml-4">
                            <h2 class="text-xl font-semibold text-gray-900 dark:text-white">Exam Options & Settings</h2>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Configure additional exam preferences</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Exam Status
                            </label>
                            <select name="status" 
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:focus:ring-orange-400 dark:focus:border-orange-400 transition-colors duration-200">
                                <option value="draft" {{ old('status', 'draft') === 'draft' ? 'selected' : '' }}>Draft</option>
                                <option value="published" {{ old('status', 'draft') === 'published' ? 'selected' : '' }}>Published</option>
                                <option value="ongoing" {{ old('status', 'draft') === 'ongoing' ? 'selected' : '' }}>Ongoing</option>
                                <option value="completed" {{ old('status', 'draft') === 'completed' ? 'selected' : '' }}>Completed</option>
                                <option value="cancelled" {{ old('status', 'draft') === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                            </select>
                            <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Set the initial status of the exam</p>
                            @error('status')
                                <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Exam Flag
                            </label>
                            <select name="flag" 
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:focus:ring-orange-400 dark:focus:border-orange-400 transition-colors duration-200">
                                <option value="active" {{ old('flag', 'active') === 'active' ? 'selected' : '' }}>Active</option>
                                <option value="deleted" {{ old('flag', 'active') === 'deleted' ? 'selected' : '' }}>Deleted</option>
                            </select>
                            <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Set the exam flag status</p>
                            @error('flag')
                                <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="mt-6">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Exam Options
                        </label>
                        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
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
                                <label class="flex items-center">
                                    <input type="checkbox" name="has_negative_marking" value="1" {{ old('has_negative_marking') ? 'checked' : '' }}
                                           id="has_negative_marking" 
                                           class="h-4 w-4 text-red-600 focus:ring-red-500 border-gray-300 rounded">
                                    <span class="ml-2 text-sm text-gray-700 dark:text-gray-300">Enable Negative Marking</span>
                                </label>
                                
                                <!-- Negative Marks Input Field -->
                                <div id="negative_marking_fields" class="hidden ml-6">
                                    <div class="flex items-center space-x-3">
                                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                            (-) Marks/Wrong Answer <span class="text-red-500">*</span>
                                        </label>
                                        <input type="number" name="negative_marks_per_question" 
                                               value="{{ old('negative_marks_per_question', 0.25) }}" 
                                               min="0" max="5" step="0.25" required
                                               class="w-20 px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:focus:ring-purple-400 dark:focus:border-purple-400 transition-colors duration-200"
                                               placeholder="0.25">
                                        <p class="text-xs text-gray-500 dark:text-gray-400">per wrong answer</p>
                                    </div>
                                    @error('negative_marks_per_question')
                                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="space-y-3">
                                <label class="flex items-center">
                                    <input type="checkbox" name="is_verified" value="1" {{ old('is_verified') ? 'checked' : '' }}
                                           class="h-4 w-4 text-green-600 focus:ring-green-500 border-gray-300 rounded">
                                    <span class="ml-2 text-sm text-gray-700 dark:text-gray-300">Mark as Verified</span>
                                </label>
                                <label class="flex items-center">
                                    <input type="checkbox" name="is_public" value="1" {{ old('is_public') ? 'checked' : '' }}
                                           class="w-4 h-4 text-green-600 focus:ring-green-500 border-gray-300 rounded">
                                    <span class="ml-2 text-sm text-gray-700 dark:text-gray-300">Public Exam</span>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="px-6 py-6 bg-gray-50 dark:bg-gray-700">
                    <div class="flex flex-col sm:flex-row justify-end space-y-3 sm:space-y-0 sm:space-x-3">
                        <a href="{{ route('partner.exams.index') }}" 
                           class="inline-flex justify-center items-center px-6 py-3 border border-gray-300 rounded-lg shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 dark:bg-gray-800 dark:border-gray-600 dark:text-gray-300 dark:hover:bg-gray-700 transition-colors duration-200">
                            Cancel
                        </a>
                        <button type="submit" 
                                class="inline-flex justify-center items-center px-6 py-3 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-200">
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
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Negative marking functionality
    const negativeMarkingCheckbox = document.getElementById('has_negative_marking');
    const negativeMarkingFields = document.getElementById('negative_marking_fields');
    const negativeMarksInput = document.querySelector('input[name="negative_marks_per_question"]');

    function toggleNegativeMarkingFields() {
        if (negativeMarkingCheckbox.checked) {
            negativeMarkingFields.classList.remove('hidden');
            negativeMarksInput.required = true;
            negativeMarksInput.disabled = false;
        } else {
            negativeMarkingFields.classList.add('hidden');
            negativeMarksInput.required = false;
            negativeMarksInput.disabled = true;
            // Clear the value when unchecked
            negativeMarksInput.value = '';
        }
    }

    // Initial state
    toggleNegativeMarkingFields();

    // Listen for changes
    negativeMarkingCheckbox.addEventListener('change', toggleNegativeMarkingFields);

    // Auto-calculate end time functionality
    const startTimeInput = document.querySelector('input[name="start_time"]');
    const durationInput = document.querySelector('input[name="duration"]');
    const endTimeInput = document.querySelector('input[name="end_time"]');
    const form = document.querySelector('form');

    function calculateEndTime() {
        const startTime = startTimeInput.value;
        const duration = parseInt(durationInput.value) || 0;
        
        if (startTime && duration > 0) {
            try {
                const startDate = new Date(startTime);
                if (isNaN(startDate.getTime())) {
                    console.error('Invalid start time:', startTime);
                    return;
                }
                
                const endDate = new Date(startDate.getTime() + (duration * 60 * 1000));
                
                // Format to datetime-local format (YYYY-MM-DDTHH:MM)
                const year = endDate.getFullYear();
                const month = String(endDate.getMonth() + 1).padStart(2, '0');
                const day = String(endDate.getDate()).padStart(2, '0');
                const hours = String(endDate.getHours()).padStart(2, '0');
                const minutes = String(endDate.getMinutes()).padStart(2, '0');
                
                const endTimeString = `${year}-${month}-${day}T${hours}:${minutes}`;
                endTimeInput.value = endTimeString;
                console.log('End time calculated:', endTimeString, 'from start:', startTime, 'duration:', duration);
            } catch (error) {
                console.error('Error calculating end time:', error);
            }
        }
    }

    // Calculate end time when start time or duration changes
    startTimeInput.addEventListener('change', calculateEndTime);
    durationInput.addEventListener('input', calculateEndTime);

    // Set minimum start time to current time + 1 hour
    const now = new Date();
    const minStartTime = new Date(now.getTime() + (60 * 60 * 1000)); // Current time + 1 hour
    const minStartTimeString = minStartTime.toISOString().slice(0, 16);
    startTimeInput.min = minStartTimeString;
    
    // If start time is before minimum, update it
    if (startTimeInput.value && new Date(startTimeInput.value) < minStartTime) {
        startTimeInput.value = minStartTimeString;
    }

    // Ensure end time is calculated before form submission
    form.addEventListener('submit', function(e) {
        // Recalculate end time before submission to ensure it's correct
        calculateEndTime();
        
        // Validate that end time is after start time
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

    // Initial calculation with multiple attempts to ensure it works
    function initializeEndTime() {
        if (startTimeInput.value && durationInput.value) {
            calculateEndTime();
        } else {
            // Wait a bit more and try again
            setTimeout(initializeEndTime, 200);
        }
    }
    
    // Try to calculate end time multiple times to ensure it works
    setTimeout(initializeEndTime, 100);
    setTimeout(initializeEndTime, 500);
    setTimeout(initializeEndTime, 1000);
    
    // Also calculate when the page is fully loaded
    window.addEventListener('load', initializeEndTime);
});
</script>
@endpush 
