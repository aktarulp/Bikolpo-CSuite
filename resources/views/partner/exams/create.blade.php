@extends('layouts.partner-layout')

@section('title', 'Create Exam')

@section('content')
<style>
    /* Style for the negative marking toggle */
    input:checked + .dot {
        transform: translateX(100%);
        background-color: #6366f1; /* Indigo-500 */
    }
    
    /* Dark mode support for toggle */
    .dark input:checked + .dot {
        background-color: #818cf8; /* Indigo-400 */
    }
</style>
<div class="flex items-center justify-center min-h-screen py-6">
    <div class="bg-white dark:bg-gray-800 p-6 md:p-8 lg:p-12 rounded-3xl shadow-2xl w-full max-w-5xl mx-auto">

        <!-- Header -->
        <div class="flex items-center justify-between pb-8 mb-8 border-b border-gray-200 dark:border-gray-600">
            <h1 class="text-3xl font-bold text-gray-800 dark:text-white">Create New Exam</h1>
            <div class="flex items-center space-x-2 text-indigo-500 hover:text-indigo-700 dark:text-indigo-400 dark:hover:text-indigo-300 cursor-pointer transition duration-200">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd" />
                </svg>
                <span>Back</span>
            </div>
        </div>

        <!-- Error Messages -->
        @if ($errors->any())
            <div class="mb-6 p-4 bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-2xl">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-red-400 dark:text-red-500" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <h3 class="text-sm font-medium text-red-800 dark:text-red-200">Please fix the following errors:</h3>
                        <div class="mt-1 text-sm text-red-700 dark:text-red-300">
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

        <!-- Form Section -->
        <form id="examForm" action="{{ route('partner.exams.store') }}" method="POST" class="space-y-10">
            @csrf

            <!-- Basic Information -->
            <div class="bg-gray-50 dark:bg-gray-700/50 p-6 rounded-2xl border border-gray-100 dark:border-gray-600">
                <h2 class="text-xl font-semibold text-gray-700 dark:text-gray-200 flex items-center mb-6">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2 text-indigo-500 dark:text-indigo-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    Basic Information
                </h2>
                <div class="grid md:grid-cols-4 gap-6">
                    <div>
                        <label for="examTitle" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Exam Title *</label>
                        <input type="text" id="examTitle" name="title" value="{{ old('title') }}" placeholder="Enter exam title" required class="w-full px-4 py-3 border border-gray-300 dark:border-gray-500 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-600 dark:text-white transition duration-200 shadow-sm">
                        @error('title')
                            <p class="mt-1 text-xs text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="examType" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Exam Type *</label>
                        <select id="examType" name="exam_type" required class="w-full px-4 py-3 border border-gray-300 dark:border-gray-500 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-600 dark:text-white transition duration-200 shadow-sm">
                            <option value="online" {{ old('exam_type', 'online') === 'online' ? 'selected' : '' }}>Online Exam</option>
                            <option value="offline" {{ old('exam_type', 'online') === 'offline' ? 'selected' : '' }}>Offline Exam</option>
                        </select>
                        @error('exam_type')
                            <p class="mt-1 text-xs text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="flex items-center space-x-2">
                        <input type="checkbox" id="allowRetake" name="allow_retake" value="1" {{ old('allow_retake') ? 'checked' : '' }} class="h-5 w-5 rounded-md text-indigo-600 border-gray-300 dark:border-gray-500 focus:ring-indigo-500">
                        <label for="allowRetake" class="text-sm font-medium text-gray-700 dark:text-gray-300">Allow Retake</label>
                    </div>
                    <div class="flex items-center space-x-4">
                        <span class="text-sm font-medium text-gray-700 dark:text-gray-300">Negative Marking</span>
                        <label for="negativeMarking" class="flex items-center cursor-pointer">
                            <div class="relative">
                                <input type="checkbox" id="negativeMarking" name="has_negative_marking" value="1" {{ old('has_negative_marking') ? 'checked' : '' }} class="sr-only" onchange="toggleNegativeMarkingInput(this)">
                                <div class="block bg-gray-300 dark:bg-gray-500 w-14 h-8 rounded-full"></div>
                                <div class="dot absolute left-1 top-1 bg-white dark:bg-gray-200 w-6 h-6 rounded-full transition-transform"></div>
                            </div>
                        </label>
                        <div id="negativeMarkingInputContainer" class="flex items-center space-x-2 {{ old('has_negative_marking') ? '' : 'hidden' }}">
                            <input type="number" id="negativeMarkingInput" name="negative_marks_per_question" value="{{ old('negative_marks_per_question', 0.25) }}" min="0" max="5" step="0.25" placeholder="Mark" class="w-20 px-3 py-2 border border-gray-300 dark:border-gray-500 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-600 dark:text-white transition duration-200 text-sm shadow-sm">
                        </div>
                    </div>
                </div>
                <div class="mt-6">
                    <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Description</label>
                    <textarea id="description" name="description" rows="3" placeholder="Provide a detailed description of the exam" class="w-full px-4 py-3 border border-gray-300 dark:border-gray-500 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-600 dark:text-white transition duration-200 shadow-sm">{{ old('description') }}</textarea>
                    @error('description')
                        <p class="mt-1 text-xs text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>
                <div class="mt-6">
                    <label for="instructions" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Question Head/Instructions</label>
                    <textarea id="instructions" name="question_head" rows="3" placeholder="Special instructions or header text for questions" class="w-full px-4 py-3 border border-gray-300 dark:border-gray-500 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-600 dark:text-white transition duration-200 shadow-sm">{{ old('question_head') }}</textarea>
                    @error('question_head')
                        <p class="mt-1 text-xs text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Schedule & Duration -->
            <div class="bg-gray-50 dark:bg-gray-700/50 p-6 rounded-2xl border border-gray-100 dark:border-gray-600">
                <h2 class="text-xl font-semibold text-gray-700 dark:text-gray-200 flex items-center mb-6">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2 text-emerald-500 dark:text-emerald-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h.01M9 16h.01M15 16h.01M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                    Schedule & Duration
                </h2>
                <div class="grid md:grid-cols-4 gap-6">
                    <!-- Start Date and Time -->
                    <div>
                        <label for="startDate" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Start Date *</label>
                        <input type="date" id="startDate" name="startDate" value="{{ old('startDate', now()->addDay()->format('Y-m-d')) }}" required class="w-40 px-4 py-3 border border-gray-300 dark:border-gray-500 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 dark:bg-gray-600 dark:text-white transition duration-200 shadow-sm">
                    </div>
                    <div>
                        <label for="startTime" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Start Time *</label>
                        <input type="time" id="startTime" name="startTime" value="{{ old('startTime', '19:15') }}" required class="w-36 px-4 py-3 border border-gray-300 dark:border-gray-500 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 dark:bg-gray-600 dark:text-white transition duration-200 shadow-sm">
                    </div>
                    <div>
                        <label for="duration" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Duration *</label>
                        <div class="flex items-center">
                            <input type="number" id="duration" name="duration" value="{{ old('duration', 120) }}" min="15" max="480" required class="w-2/3 px-4 py-3 border border-gray-300 dark:border-gray-500 rounded-l-xl focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 dark:bg-gray-600 dark:text-white transition duration-200 shadow-sm">
                            <span class="w-1/3 px-4 py-3 bg-gray-200 dark:bg-gray-500 text-gray-600 dark:text-gray-300 rounded-r-xl text-center border border-gray-300 dark:border-gray-500 border-l-0">min</span>
                        </div>
                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Minutes (15 min - 8 hours)</p>
                        @error('duration')
                            <p class="mt-1 text-xs text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="flex items-center space-x-2">
                        <label for="passingMarks" class="text-sm font-medium text-gray-700 dark:text-gray-300">Passing Marks (%):</label>
                        <input type="number" id="passingMarks" name="passing_marks" value="{{ old('passing_marks', 60) }}" min="0" max="100" required class="w-20 px-3 py-2 border border-gray-300 dark:border-gray-500 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 dark:bg-gray-600 dark:text-white transition duration-200 shadow-sm text-center">
                        @error('passing_marks')
                            <p class="mt-1 text-xs text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                <div class="grid md:grid-cols-4 gap-6 mt-6">
                    <!-- End Date and Time -->
                    <div>
                        <label for="endDate" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">End Date *</label>
                        <input type="date" id="endDate" name="endDate" value="{{ old('endDate', now()->addDay()->format('Y-m-d')) }}" required class="w-40 px-4 py-3 border border-gray-300 dark:border-gray-500 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 dark:bg-gray-600 dark:text-white transition duration-200 shadow-sm">
                    </div>
                    <div>
                        <label for="endTime" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">End Time</label>
                        <input type="time" id="endTime" name="endTime" value="{{ old('endTime', '21:15') }}" required class="w-36 px-4 py-3 border border-gray-300 dark:border-gray-500 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-blue-500 transition duration-200 shadow-sm">
                    </div>
                    <div>
                        <label for="totalQuestions" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Total Questions</label>
                        <input type="number" id="totalQuestions" name="total_questions" value="{{ old('total_questions', 10) }}" min="1" max="100" required class="w-full px-4 py-3 border border-gray-300 dark:border-gray-500 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 dark:bg-gray-600 dark:text-white transition duration-200 shadow-sm">
                        @error('total_questions')
                            <p class="mt-1 text-xs text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="flex items-center space-x-2">
                        <input type="checkbox" id="showResults" name="show_results_immediately" value="1" {{ old('show_results_immediately', true) ? 'checked' : '' }} class="h-5 w-5 rounded-md text-emerald-600 border-gray-300 dark:border-gray-500 focus:ring-emerald-500">
                        <label for="showResults" class="text-sm font-medium text-gray-700 dark:text-gray-300">Show Results Immediately</label>
                    </div>
                </div>
            </div>

        </form>

        <!-- Footer Buttons -->
        <div class="flex justify-end space-x-4 mt-10 pt-6 border-t border-gray-200 dark:border-gray-600">
            <a href="{{ route('partner.exams.index') }}" class="px-6 py-3 border border-gray-300 dark:border-gray-500 rounded-xl text-gray-700 dark:text-gray-300 font-semibold hover:bg-gray-100 dark:hover:bg-gray-600 transition duration-200 shadow-sm">
                Cancel
            </a>
            <button type="submit" form="examForm" class="px-6 py-3 bg-indigo-600 dark:bg-indigo-500 text-white font-semibold rounded-xl hover:bg-indigo-700 dark:hover:bg-indigo-600 transition duration-200 shadow-lg">
                Create Exam
            </button>
        </div>

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

    // Initialize negative marking toggle on page load
    document.addEventListener('DOMContentLoaded', function() {
        const negativeMarkingCheckbox = document.getElementById('negativeMarking');
        if (negativeMarkingCheckbox.checked) {
            document.getElementById('negativeMarkingInputContainer').classList.remove('hidden');
        }
    });
</script>
@endsection 
