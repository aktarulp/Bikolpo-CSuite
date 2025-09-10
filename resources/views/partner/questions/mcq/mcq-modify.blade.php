@extends('layouts.partner-layout')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-slate-50 to-blue-50 py-8">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header Section -->
        <div class="mb-8">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900 bg-gradient-to-r from-blue-600 to-purple-600 bg-clip-text text-transparent">
                        Edit Multiple Choice Question
                    </h1>
                    <p class="mt-2 text-gray-600">Update and modify your existing question</p>
                </div>
                <div class="flex items-center space-x-3">
                    <a href="{{ route('partner.questions.all') }}"
                       class="group inline-flex items-center px-6 py-3 bg-gradient-to-r from-slate-100 to-gray-100 hover:from-slate-200 hover:to-gray-200 border border-gray-300 rounded-xl text-sm font-semibold text-gray-700 hover:text-gray-900 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all duration-300 transform hover:scale-105 shadow-sm hover:shadow-md">
                        <div class="flex items-center justify-center w-8 h-8 mr-3 bg-white rounded-lg shadow-sm group-hover:shadow-md transition-all duration-300">
                            <svg class="w-4 h-4 text-gray-600 group-hover:text-gray-800 transition-colors duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                            </svg>
                        </div>
                        <span class="font-medium">Back to Questions</span>
                    </a>
                </div>
            </div>
        </div>

        <!-- Main Form Container -->
        <div class="bg-white rounded-2xl shadow-xl border border-gray-100 overflow-hidden">
            <form action="{{ route('partner.questions.mcq.update', $question) }}" method="POST" id="mcqForm" class="p-8" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <input type="hidden" name="question_type" value="mcq">
                
                <!-- Question Details Section -->
                <div class="mb-8">
                    <div class="flex items-center mb-6">
                        <div class="flex-shrink-0">
                            <div class="w-10 h-10 bg-gradient-to-r from-blue-500 to-purple-600 rounded-full flex items-center justify-center">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                        </div>
                        <div class="ml-4">
                            <h2 class="text-xl font-semibold text-gray-900">Question Details</h2>
                            <p class="text-gray-600">Enter the main question and basic information</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                        <!-- Course Selection -->
                        <div class="space-y-2">
                            <label for="course_id" class="block text-sm font-medium text-gray-700">
                                Course <span class="text-red-500">*</span>
                            </label>
                            <select name="course_id" id="course_id" required
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 bg-white">
                                <option value="">Select a course</option>
                                @foreach($courses ?? [] as $course)
                                    <option value="{{ $course->id }}" {{ old('course_id', $question->course_id ?? $question->course->id ?? '') == $course->id ? 'selected' : '' }}>
                                        {{ $course->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('course_id')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Subject Selection -->
                        <div class="space-y-2">
                            <label for="subject_id" class="block text-sm font-medium text-gray-700">
                                Subject <span class="text-red-500">*</span>
                            </label>
                            <select name="subject_id" id="subject_id" required
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 bg-white">
                                <option value="">Select a subject</option>
                                @foreach($subjects ?? [] as $subject)
                                    <option value="{{ $subject->id }}" {{ old('subject_id', $question->subject_id ?? $question->subject->id ?? '') == $subject->id ? 'selected' : '' }}>
                                        {{ $subject->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('subject_id')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Topic Selection -->
                        <div class="space-y-2">
                            <label for="topic_id" class="block text-sm font-medium text-gray-700">
                                Topic <span class="text-gray-400">(Optional)</span>
                            </label>
                            <select name="topic_id" id="topic_id"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 bg-white">
                                <option value="">Select a topic (optional)</option>
                                @foreach($topics ?? [] as $topic)
                                    <option value="{{ $topic->id }}" {{ old('topic_id', $question->topic_id ?? $question->topic->id ?? '') == $topic->id ? 'selected' : '' }}>
                                        {{ $topic->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('topic_id')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Question Text and Answer Options Section -->
                 <div class="mb-8">
                     <div class="flex items-center justify-between mb-6">
                         <div class="flex items-center">
                             <div class="flex-shrink-0">
                                 <div class="w-10 h-10 bg-gradient-to-r from-green-500 to-teal-600 rounded-full flex items-center justify-center">
                                     <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                         <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                     </svg>
                                 </div>
                             </div>
                             <div class="ml-4">
                                 <h2 class="text-xl font-semibold text-gray-900">Question Text</h2>
                                 <p class="text-gray-600">Write your question clearly and concisely</p>
                             </div>
                         </div>
                         
                         <!-- Answer Options Header -->
                         <div class="flex items-center">
                             <div class="flex-shrink-0">
                                 <div class="w-10 h-10 bg-gradient-to-r from-orange-500 to-red-600 rounded-full flex items-center justify-center">
                                     <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                         <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                                     </svg>
                                 </div>
                             </div>
                             <div class="ml-4">
                                 <h2 class="text-xl font-semibold text-gray-900">Answer Options</h2>
                                 <p class="text-gray-600">Select the correct answer and provide options</p>
                             </div>
                         </div>
                     </div>

                     <div class="space-y-2">
                         
                         <div class="flex gap-3">
                             <!-- Left Side: Rich Text Editor -->
                             <div class="flex-1">
                                 <!-- Rich Text Editor Toolbar -->
                                 <div class="border border-gray-300 rounded-t-lg bg-gray-50 p-2 flex flex-wrap items-center gap-2">
                                     <!-- Text Formatting -->
                                     <button type="button" id="boldBtn" class="p-2 hover:bg-gray-200 rounded" title="Bold">
                                         <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                             <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 12h8a4 4 0 100-8H6v8zm0 0h8a4 4 0 110 8H6v-8z"></path>
                                         </svg>
                                     </button>
                                     <button type="button" id="italicBtn" class="p-2 hover:bg-gray-200 rounded" title="Italic">
                                         <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                             <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"></path>
                                         </svg>
                                     </button>
                                     <button type="button" id="underlineBtn" class="p-2 hover:bg-gray-200 rounded" title="Underline">
                                         <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                             <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16V4m0 0L3 8m4-4l4 4m6 0v12m0 0l4-4m-4 4l-4-4"></path>
                                         </svg>
                                     </button>
                                     
                                     <div class="w-px h-6 bg-gray-300"></div>
                                     
                                     <!-- Equation -->
                                     <button type="button" id="equationBtn" class="p-2 hover:bg-gray-200 rounded text-sm font-medium" title="Insert Equation">
                                         ∑
                                     </button>
                                     
                                     <!-- Local Image Upload -->
                                     <button type="button" id="uploadImageBtn" class="p-2 hover:bg-gray-200 rounded" title="Upload Image with Caption">
                                         <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                             <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                                         </svg>
                                     </button>
                                     
                                     
                                     <!-- Hidden file input for image upload -->
                                     <input type="file" id="imageFileInput" accept="image/*" class="hidden">
                                     
                                     <!-- Image Resize -->
                                     <button type="button" id="resizeBtn" class="p-2 hover:bg-gray-200 rounded bg-blue-50 border border-blue-200" title="Resize Selected Image" style="display: inline-flex !important; visibility: visible !important;">
                                         <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                             <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8V4m0 0h4M4 4l5 5m11-1V4m0 0h-4m4 0l-5 5M4 16v4m0 0h4m-4 0l5-5m11 5l-5-5m5 5v-4m0 4h-4"></path>
                                         </svg>
                                         <span class="ml-1 text-xs text-blue-600 font-medium">Resize</span>
                                     </button>
                                    
                                     <div class="w-px h-6 bg-gray-300"></div>
                                     
                                     <!-- Hyperlink -->
                                     <button type="button" id="linkBtn" class="p-2 hover:bg-gray-200 rounded" title="Insert Hyperlink">
                                         <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                             <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"></path>
                                         </svg>
                                     </button>
                                    
                                     <div class="w-px h-6 bg-gray-300"></div>
                                     
                                     <!-- Clear Formatting -->
                                     <button type="button" id="clearFormatBtn" class="p-2 hover:bg-gray-200 rounded text-sm font-medium" title="Clear Formatting">
                                         Clear
                                     </button>
                                 </div>
                                 
                                 <!-- Rich Text Editor Content -->
                                 <div id="richTextEditor" class="border border-t-0 border-gray-300 rounded-b-lg min-h-[150px] p-4 focus-within:ring-2 focus-within:ring-blue-500 focus-within:border-blue-500 transition-all duration-200" contenteditable="true" data-placeholder="Enter your question here... You can use formatting, images, and equations.">{!! old('question_text', $question->question_text) !!}</div>
                                 
                                 <!-- Hidden textarea for form submission -->
                                 <textarea name="question_text" id="question_text" class="hidden" required>{{ old('question_text', $question->question_text) }}</textarea>
                                 <input type="hidden" name="q_type_id" value="1">
                                 
                                 <div class="flex justify-between items-center text-sm text-gray-500 mt-2">
                                     <span>Use the toolbar above for formatting, equations, and images.</span>
                                     <span id="charCount">0 characters</span>
                                 </div>
                             </div>

                             <!-- Right Side: Answer Options -->
                             <div class="w-72">
                                 <div class="space-y-1">
                                     <!-- Option A -->
                                     <div class="option-item bg-gray-50 rounded-lg p-2 border-2 border-transparent hover:border-blue-200 transition-all duration-200">
                                         <div class="flex items-center space-x-2">
                                             <div class="flex-shrink-0">
                                                 <input type="radio" name="correct_answer" value="a" id="correct_A" required
                                                        class="w-4 h-4 text-blue-600 border-gray-300 focus:ring-blue-500 focus:ring-2"
                                                        {{ old('correct_answer', $question->correct_answer) == 'a' ? 'checked' : '' }}>
                                             </div>
                                             <label for="correct_A" class="flex-1">
                                                 <div class="flex items-center space-x-2">
                                                     <span class="option-bullet w-6 h-6 bg-gray-200 text-gray-600 rounded-full flex items-center justify-center text-xs font-semibold">A</span>
                                                     <input type="text" name="option_a" placeholder="Option A" required
                                                            class="flex-1 px-2 py-1 text-sm border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200"
                                                            value="{{ old('option_a', $question->option_a) }}">
                                                 </div>
                                             </label>
                                         </div>
                                     </div>
                                     
                                     <!-- Option B -->
                                     <div class="option-item bg-gray-50 rounded-lg p-2 border-2 border-transparent hover:border-blue-200 transition-all duration-200">
                                         <div class="flex items-center space-x-2">
                                             <div class="flex-shrink-0">
                                                 <input type="radio" name="correct_answer" value="b" id="correct_B" required
                                                        class="w-4 h-4 text-blue-600 border-gray-300 focus:ring-blue-500 focus:ring-2"
                                                        {{ old('correct_answer', $question->correct_answer) == 'b' ? 'checked' : '' }}>
                                             </div>
                                             <label for="correct_B" class="flex-1">
                                                 <div class="flex items-center space-x-2">
                                                     <span class="option-bullet w-6 h-6 bg-gray-200 text-gray-600 rounded-full flex items-center justify-center text-xs font-semibold">B</span>
                                                     <input type="text" name="option_b" placeholder="Option B" required
                                                            class="flex-1 px-2 py-2 text-sm border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200"
                                                            value="{{ old('option_b', $question->option_b) }}">
                                                 </div>
                                             </label>
                                         </div>
                                     </div>
                                     
                                     <!-- Option C -->
                                     <div class="option-item bg-gray-50 rounded-lg p-2 border-2 border-transparent hover:border-blue-200 transition-all duration-200">
                                         <div class="flex items-center space-x-2">
                                             <div class="flex-shrink-0">
                                                 <input type="radio" name="correct_answer" value="c" id="correct_C" required
                                                        class="w-4 h-4 text-blue-600 border-gray-300 focus:ring-blue-500 focus:ring-2"
                                                        {{ old('correct_answer', $question->correct_answer) == 'c' ? 'checked' : '' }}>
                                             </div>
                                             <label for="correct_C" class="flex-1">
                                                 <div class="flex items-center space-x-2">
                                                     <span class="option-bullet w-6 h-6 bg-gray-200 text-gray-600 rounded-full flex items-center justify-center text-xs font-semibold">C</span>
                                                     <input type="text" name="option_c" placeholder="Option C" required
                                                            class="flex-1 px-2 py-1 text-sm border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200"
                                                            value="{{ old('option_c', $question->option_c) }}">
                                                 </div>
                                             </label>
                                         </div>
                                     </div>
                                     
                                     <!-- Option D -->
                                     <div class="option-item bg-gray-50 rounded-lg p-2 border-2 border-transparent hover:border-blue-200 transition-all duration-200">
                                         <div class="flex items-center space-x-2">
                                             <div class="flex-shrink-0">
                                                 <input type="radio" name="correct_answer" value="d" id="correct_D" required
                                                        class="w-4 h-4 text-blue-600 border-gray-300 focus:ring-blue-500 focus:ring-2"
                                                        {{ old('correct_answer', $question->correct_answer) == 'd' ? 'checked' : '' }}>
                                             </div>
                                             <label for="correct_D" class="flex-1">
                                                 <div class="flex items-center space-x-2">
                                                     <span class="option-bullet w-6 h-6 bg-gray-200 text-gray-600 rounded-full flex items-center justify-center text-xs font-semibold">D</span>
                                                     <input type="text" name="option_d" placeholder="Option D" required
                                                            class="flex-1 px-2 py-1 text-sm border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200"
                                                            value="{{ old('option_d', $question->option_d) }}">
                                                 </div>
                                             </label>
                                         </div>
                                     </div>
                                 </div>
                             </div>
                         </div>
                     </div>
                     

                </div>







                <!-- Action Buttons -->
                <div class="flex items-center justify-end pt-6 border-t border-gray-200">
                    <div class="flex items-center space-x-4">
                        <a href="{{ route('partner.questions.all') }}" 
                           class="inline-flex items-center px-6 py-3 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-offset-2 focus:ring-blue-500 transition-all duration-200">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                            Cancel
                        </a>
                        
                        <button type="submit" id="submitBtn"
                                class="inline-flex items-center px-8 py-3 border border-transparent rounded-lg text-sm font-medium text-white bg-gradient-to-r from-blue-600 to-purple-600 hover:from-blue-700 hover:to-purple-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transform hover:scale-105 transition-all duration-200 shadow-lg">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            Update Question
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Image Resize Modal -->
<div id="resizeModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <div class="mt-3">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-medium text-gray-900">Resize Image</h3>
                <button id="closeResizeModal" class="text-gray-400 hover:text-gray-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            <div class="space-y-4">
                <div class="flex items-center space-x-2">
                    <input type="checkbox" id="resizeProportionally" class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                    <label for="resizeProportionally" class="text-sm text-gray-700">Resize proportionally</label>
                </div>
                
                <div id="proportionalControls" class="space-y-3">
                    <div class="flex items-center space-x-2">
                        <input type="checkbox" id="maintainAspectRatio" class="rounded border-gray-300 text-blue-600 focus:ring-blue-500" checked>
                        <label for="maintainAspectRatio" class="text-sm text-gray-700">Maintain aspect ratio</label>
                    </div>
                    
                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label for="resizeWidth" class="block text-sm font-medium text-gray-700">Width (px)</label>
                            <input type="number" id="resizeWidth" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                        </div>
                        <div>
                            <label for="resizeHeight" class="block text-sm font-medium text-gray-700">Height (px)</label>
                            <input type="number" id="resizeHeight" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                        </div>
                    </div>
                </div>
                
                <div>
                    <label for="resizeScale" class="block text-sm font-medium text-gray-700">Scale (%)</label>
                    <input type="range" id="resizeScale" min="10" max="200" value="100" class="mt-1 block w-full">
                    <div class="text-center text-sm text-gray-600 mt-1">
                        <span id="scaleValue">100%</span>
                    </div>
                </div>
                
                <div class="flex items-center space-x-2">
                    <input type="checkbox" id="resizeQuality" class="rounded border-gray-300 text-blue-600 focus:ring-blue-500" checked>
                    <label for="resizeQuality" class="text-sm text-gray-700">Optimize quality</label>
                </div>
            </div>
            
            <div class="flex justify-end space-x-3 mt-6">
                <button id="cancelResize" class="px-4 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    Cancel
                </button>
                <button id="applyResize" class="px-4 py-2 bg-blue-600 border border-transparent rounded-md text-sm font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    Apply
                </button>
            </div>
        </div>
    </div>
</div>


<!-- Notification Container -->
<div id="notificationContainer" class="fixed top-4 right-4 z-50"></div>

<script>
// Notification function
function showNotification(message, type = 'info') {
    const container = document.getElementById('notificationContainer');
    const notification = document.createElement('div');
    
    const bgColor = type === 'success' ? 'bg-green-500' : type === 'error' ? 'bg-red-500' : 'bg-blue-500';
    const icon = type === 'success' ? '✓' : type === 'error' ? '✗' : 'ℹ';
    
    notification.className = `${bgColor} text-white px-6 py-4 rounded-lg shadow-lg mb-4 flex items-center space-x-3 transform transition-all duration-300 translate-x-full`;
    notification.innerHTML = `
        <span class="text-lg">${icon}</span>
        <span>${message}</span>
        <button onclick="this.parentElement.remove()" class="ml-auto text-white hover:text-gray-200">✗</button>
    `;
    
    container.appendChild(notification);
    
    // Animate in
    setTimeout(() => notification.classList.remove('translate-x-full'), 100);
    
    // Auto remove after 5 seconds
    setTimeout(() => {
        notification.classList.add('translate-x-full');
        setTimeout(() => notification.remove(), 300);
    }, 5000);
}

// Custom Rich Text Editor Functions
function initializeRichTextEditor() {
    const editor = document.getElementById('richTextEditor');
    const hiddenTextarea = document.getElementById('question_text');
    const charCount = document.getElementById('charCount');
    
    if (!editor || !hiddenTextarea || !charCount) return;
    
    // Set initial content
    const initialContent = editor.innerHTML;
    if (initialContent.trim()) {
        hiddenTextarea.value = initialContent;
        updateCharCount();
    }
    
    // Character counter
    function updateCharCount() {
        const text = editor.textContent || '';
        charCount.textContent = text.length + ' characters';
        hiddenTextarea.value = editor.innerHTML;
    }
    
    editor.addEventListener('input', updateCharCount);
    editor.addEventListener('keyup', updateCharCount);
    editor.addEventListener('paste', updateCharCount);
    
    // Initialize character count
    updateCharCount();
    
    // Text formatting functions
    function formatText(command, value = null) {
        document.execCommand(command, false, value);
        editor.focus();
        updateCharCount();
    }
    
    // Bold button
    document.getElementById('boldBtn')?.addEventListener('click', function() {
        formatText('bold');
        this.classList.toggle('bg-blue-200');
    });
    
    // Italic button
    document.getElementById('italicBtn')?.addEventListener('click', function() {
        formatText('italic');
        this.classList.toggle('bg-blue-200');
    });
    
    // Underline button
    document.getElementById('underlineBtn')?.addEventListener('click', function() {
        formatText('underline');
        this.classList.toggle('bg-blue-200');
    });
    
    // Clear formatting button
    document.getElementById('clearFormatBtn')?.addEventListener('click', function() {
        formatText('removeFormat');
        document.getElementById('boldBtn')?.classList.remove('bg-blue-200');
        document.getElementById('italicBtn')?.classList.remove('bg-blue-200');
        document.getElementById('underlineBtn')?.classList.remove('bg-blue-200');
    });
    
    // Equation button
    document.getElementById('equationBtn')?.addEventListener('click', function() {
        const equation = prompt('Enter your equation (e.g., x² + y² = r²):');
        if (equation) {
            const equationSpan = document.createElement('span');
            equationSpan.innerHTML = equation;
            equationSpan.style.fontFamily = 'serif';
            equationSpan.style.fontSize = '1.1em';
            equationSpan.style.color = '#1f2937';
            
            const selection = window.getSelection();
            if (selection.rangeCount > 0) {
                const range = selection.getRangeAt(0);
                range.deleteContents();
                range.insertNode(equationSpan);
            } else {
                editor.appendChild(equationSpan);
            }
            updateCharCount();
        }
    });
    
    // Hyperlink button
    document.getElementById('linkBtn')?.addEventListener('click', function() {
        const url = prompt('Enter URL:');
        if (url) {
            const linkText = prompt('Enter link text (or leave empty to use URL):') || url;
            const link = document.createElement('a');
            link.href = url;
            link.textContent = linkText;
            link.target = '_blank';
            link.style.color = '#2563eb';
            link.style.textDecoration = 'underline';
            link.title = 'Click to edit, Ctrl+Click to visit';
            
            const selection = window.getSelection();
            if (selection.rangeCount > 0) {
                const range = selection.getRangeAt(0);
                range.deleteContents();
                range.insertNode(link);
            } else {
                editor.appendChild(link);
            }
            updateCharCount();
        }
    });
    
    // Local image upload button
    document.getElementById('uploadImageBtn')?.addEventListener('click', function() {
        document.getElementById('imageFileInput').click();
    });
    
    
    // Handle file input change
    document.getElementById('imageFileInput')?.addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            if (!file.type.startsWith('image/')) {
                showNotification('Please select a valid image file', 'error');
                return;
            }
            
            if (file.size > 5 * 1024 * 1024) {
                showNotification('Image size must be less than 5MB', 'error');
                return;
            }
            
            const reader = new FileReader();
            reader.onload = function(e) {
                insertImage(e.target.result, file.name);
            };
            reader.readAsDataURL(file);
            document.getElementById('imageFileInput').value = '';
        }
    });
    
    // Helper function to insert local image with enhanced features
    function insertImage(src, alt) {
        // Create image container for better layout
        const imageContainer = document.createElement('div');
        imageContainer.className = 'question-image-container';
        imageContainer.style.margin = '15px 0';
        imageContainer.style.textAlign = 'center';
        imageContainer.style.border = '1px solid #e5e7eb';
        imageContainer.style.borderRadius = '8px';
        imageContainer.style.padding = '10px';
        imageContainer.style.backgroundColor = '#f9fafb';
        
        // Create the image element
        const img = document.createElement('img');
        img.src = src;
        img.alt = alt;
        img.style.maxWidth = '100%';
        img.style.height = 'auto';
        img.style.borderRadius = '6px';
        img.style.boxShadow = '0 2px 4px rgba(0,0,0,0.1)';
        img.title = 'Click to select image for resizing, right-click to remove';
        
        // Create caption input
        const captionInput = document.createElement('input');
        captionInput.type = 'text';
        captionInput.placeholder = 'Add image caption (optional)';
        captionInput.style.width = '100%';
        captionInput.style.marginTop = '8px';
        captionInput.style.padding = '4px 8px';
        captionInput.style.border = '1px solid #d1d5db';
        captionInput.style.borderRadius = '4px';
        captionInput.style.fontSize = '12px';
        captionInput.style.backgroundColor = 'white';
        
        // Create caption display
        const captionDisplay = document.createElement('div');
        captionDisplay.style.fontSize = '12px';
        captionDisplay.style.color = '#6b7280';
        captionDisplay.style.fontStyle = 'italic';
        captionDisplay.style.marginTop = '4px';
        captionDisplay.style.display = 'none';
        
        // Handle caption input
        captionInput.addEventListener('input', function() {
            if (this.value.trim()) {
                captionDisplay.textContent = this.value;
                captionDisplay.style.display = 'block';
                this.style.display = 'none';
            }
        });
        
        captionInput.addEventListener('blur', function() {
            if (!this.value.trim()) {
                this.style.display = 'block';
                captionDisplay.style.display = 'none';
            }
        });
        
        // Make caption editable
        captionDisplay.addEventListener('click', function() {
            this.style.display = 'none';
            captionInput.style.display = 'block';
            captionInput.focus();
        });
        
        // Image click handlers
        img.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            
            const prevSelected = editor.querySelector('img.selected-for-resize');
            if (prevSelected) {
                prevSelected.classList.remove('selected-for-resize');
            }
            
            this.classList.add('selected-for-resize');
            selectedImage = this;
            showNotification('Image selected! Click the Resize button to resize it.', 'success');
        });
        
        img.addEventListener('contextmenu', function(e) {
            e.preventDefault();
            if (confirm('Remove this image and its caption?')) {
                imageContainer.remove();
                updateCharCount();
                if (selectedImage === this) {
                    selectedImage = null;
                }
            }
        });
        
        // Assemble the container
        imageContainer.appendChild(img);
        imageContainer.appendChild(captionInput);
        imageContainer.appendChild(captionDisplay);
        
        // Insert into editor
        const selection = window.getSelection();
        if (selection.rangeCount > 0) {
            const range = selection.getRangeAt(0);
            range.deleteContents();
            range.insertNode(imageContainer);
        } else {
            editor.appendChild(imageContainer);
        }
        
        // Add a line break after the image for better spacing
        const br = document.createElement('br');
        imageContainer.parentNode.insertBefore(br, imageContainer.nextSibling);
        
        updateCharCount();
    }
    
    
    // Handle paste events
    editor.addEventListener('paste', function(e) {
        e.preventDefault();
        const text = e.clipboardData.getData('text/plain');
        document.execCommand('insertText', false, text);
        updateCharCount();
    });
    
    // Handle link clicks
    editor.addEventListener('click', function(e) {
        if (e.target.tagName === 'A') {
            e.preventDefault();
            if (e.ctrlKey || e.metaKey) {
                window.open(e.target.href, '_blank');
                return;
            }
            const newUrl = prompt('Edit URL:', e.target.href);
            if (newUrl !== null) {
                e.target.href = newUrl;
                updateCharCount();
            }
        }
    });
    
    // Handle drag and drop for images
    editor.addEventListener('dragover', function(e) {
        e.preventDefault();
        this.style.borderColor = '#3b82f6';
    });
    
    editor.addEventListener('dragleave', function(e) {
        e.preventDefault();
        this.style.borderColor = '#d1d5db';
    });
    
    editor.addEventListener('drop', function(e) {
        e.preventDefault();
        this.style.borderColor = '#d1d5db';
        
        const files = e.dataTransfer.files;
        if (files.length > 0 && files[0].type.startsWith('image/')) {
            const reader = new FileReader();
            reader.onload = function(e) {
                insertImage(e.target.result, 'Dropped image');
            };
            reader.readAsDataURL(files[0]);
        }
    });
    
    // Image resize functionality
    let selectedImage = null;
    
    // Resize button click handler
    document.getElementById('resizeBtn')?.addEventListener('click', function() {
        if (selectedImage) {
            openResizeModal(selectedImage);
        } else {
            showNotification('Please select an image first. Click on an image to select it.', 'error');
        }
    });
    
    // Make images selectable for resizing
    editor.addEventListener('click', function(e) {
        if (e.target.tagName === 'IMG') {
            // Remove previous selection
            const prevSelected = editor.querySelector('img.selected-for-resize');
            if (prevSelected) {
                prevSelected.classList.remove('selected-for-resize');
            }
            
            // Add selection to clicked image
            e.target.classList.add('selected-for-resize');
            selectedImage = e.target;
            
            // Update resize button state
            updateResizeButtonState();
        }
    });
    
    // Function to update resize button state
    function updateResizeButtonState() {
        const resizeBtn = document.getElementById('resizeBtn');
        if (selectedImage) {
            resizeBtn.classList.add('bg-green-100', 'border-green-300', 'text-green-700');
            resizeBtn.classList.remove('bg-blue-50', 'border-blue-200', 'text-blue-600');
            resizeBtn.title = 'Resize Selected Image (Click to resize)';
        } else {
            resizeBtn.classList.remove('bg-green-100', 'border-green-300', 'text-green-700');
            resizeBtn.classList.add('bg-blue-50', 'border-blue-200', 'text-blue-600');
            resizeBtn.title = 'Resize Selected Image (No image selected)';
        }
    }
    
    // Initialize resize button state
    updateResizeButtonState();
    
    // Function to open resize modal
    function openResizeModal(img) {
        const modal = document.getElementById('resizeModal');
        const widthInput = document.getElementById('resizeWidth');
        const heightInput = document.getElementById('resizeHeight');
        const scaleInput = document.getElementById('resizeScale');
        const scaleValue = document.getElementById('scaleValue');
        
        // Set current dimensions
        widthInput.value = Math.round(img.naturalWidth || img.offsetWidth);
        heightInput.value = Math.round(img.naturalHeight || img.offsetHeight);
        scaleInput.value = 100;
        scaleValue.textContent = '100%';
        
        // Show modal
        modal.classList.remove('hidden');
        
        // Store original dimensions for calculations
        const originalWidth = parseInt(widthInput.value);
        const originalHeight = parseInt(heightInput.value);
        
        // Handle proportional resizing
        const maintainAspectRatio = document.getElementById('maintainAspectRatio');
        const resizeProportionally = document.getElementById('resizeProportionally');
        const proportionalControls = document.getElementById('proportionalControls');
        
        // Show/hide proportional controls
        resizeProportionally.addEventListener('change', function() {
            proportionalControls.classList.toggle('hidden', !this.checked);
            if (this.checked) {
                maintainAspectRatio.checked = true;
                maintainAspectRatio.disabled = true;
            } else {
                maintainAspectRatio.disabled = false;
            }
        });
        
        // Handle width/height changes with aspect ratio
        function updateDimensions() {
            if (maintainAspectRatio.checked && !resizeProportionally.checked) {
                if (this === widthInput) {
                    const ratio = originalHeight / originalWidth;
                    heightInput.value = Math.round(parseInt(this.value) * ratio);
                } else {
                    const ratio = originalWidth / originalHeight;
                    widthInput.value = Math.round(parseInt(this.value) * ratio);
                }
            }
        }
        
        widthInput.addEventListener('input', updateDimensions);
        heightInput.addEventListener('input', updateDimensions);
        
        // Handle proportional scaling
        scaleInput.addEventListener('input', function() {
            const scale = parseInt(this.value) / 100;
            widthInput.value = Math.round(originalWidth * scale);
            heightInput.value = Math.round(originalHeight * scale);
            scaleValue.textContent = this.value + '%';
        });
        
        // Apply resize
        document.getElementById('applyResize').addEventListener('click', function() {
            const newWidth = parseInt(widthInput.value);
            const newHeight = parseInt(heightInput.value);
            const optimizeQuality = document.getElementById('resizeQuality').checked;
            
            if (newWidth < 50 || newWidth > 1200) {
                showNotification('Width must be between 50px and 1200px', 'error');
                return;
            }
            
            if (newHeight < 50 || newHeight > 1200) {
                showNotification('Height must be between 50px and 1200px', 'error');
                return;
            }
            
            // Resize the image
            resizeImage(selectedImage, newWidth, newHeight, optimizeQuality);
            
            // Close modal
            modal.classList.add('hidden');
            
            // Clean up event listeners
            widthInput.removeEventListener('input', updateDimensions);
            heightInput.removeEventListener('input', updateDimensions);
        });
        
        // Cancel resize
        document.getElementById('cancelResize').addEventListener('click', function() {
            modal.classList.add('hidden');
        });
        
        // Close modal button
        document.getElementById('closeResizeModal')?.addEventListener('click', function() {
            modal.classList.add('hidden');
        });
        
        // Close modal when clicking outside
        modal.addEventListener('click', function(e) {
            if (e.target === modal) {
                modal.classList.add('hidden');
            }
        });
    }
    
    // Function to resize image
    function resizeImage(img, newWidth, newHeight, optimizeQuality) {
        const canvas = document.createElement('canvas');
        const ctx = canvas.getContext('2d');
        
        canvas.width = newWidth;
        canvas.height = newHeight;
        
        // Set image smoothing quality
        if (optimizeQuality) {
            ctx.imageSmoothingEnabled = true;
            ctx.imageSmoothingQuality = 'high';
        } else {
            ctx.imageSmoothingQuality = 'low';
        }
        
        // Draw resized image
        ctx.drawImage(img, 0, 0, newWidth, newHeight);
        
        // Convert to data URL
        const resizedDataUrl = canvas.toDataURL('image/jpeg', optimizeQuality ? 0.9 : 0.7);
        
        // Update image
        img.src = resizedDataUrl;
        img.style.width = newWidth + 'px';
        img.style.height = newHeight + 'px';
        
        // Remove selection class
        img.classList.remove('selected-for-resize');
        
        // Update character count
        updateCharCount();
        
        // Show success message
        showNotification('Image resized successfully!', 'success');
    }
}



document.addEventListener('DOMContentLoaded', function() {
    console.log('DOM Content Loaded - Starting initialization');
    
    try {
        // Initialize Custom Rich Text Editor
        console.log('Initializing Rich Text Editor...');
        initializeRichTextEditor();
        console.log('Rich Text Editor initialized');
    } catch (error) {
        console.error('Error during initialization:', error);
    }

    // Course and Subject cascading dropdowns
    const courseSelect = document.getElementById('course_id');
    const subjectSelect = document.getElementById('subject_id');
    const topicSelect = document.getElementById('topic_id');
    
    // Store all subjects and topics for filtering
    const allSubjects = @json($subjects ?? []);
    const allTopics = @json($topics ?? []);
    
    // Course change handler
    courseSelect.addEventListener('change', function() {
        const courseId = this.value;
        
        // Reset subject and topic selections
        subjectSelect.innerHTML = '<option value="">Select a subject</option>';
        topicSelect.innerHTML = '<option value="">Select a topic</option>';
        
        if (courseId) {
            // Filter subjects by course using the simple relationship
            const filteredSubjects = allSubjects.filter(subject => 
                subject.course_id == courseId
            );
            filteredSubjects.forEach(subject => {
                const option = document.createElement('option');
                option.value = subject.id;
                option.textContent = subject.name;
                subjectSelect.appendChild(option);
            });
        }
    });
    
    // Subject change handler
    subjectSelect.addEventListener('change', function() {
        const subjectId = this.value;
        
        // Reset topic selection
        topicSelect.innerHTML = '<option value="">Select a topic</option>';
        
        if (subjectId) {
            // Filter topics by subject
            const filteredTopics = allTopics.filter(topic => topic.subject_id == subjectId);
            filteredTopics.forEach(topic => {
                const option = document.createElement('option');
                option.value = topic.id;
                option.textContent = topic.name;
                topicSelect.appendChild(option);
            });
        }
    });
    
    // Function to initialize dependent dropdowns with current values
    function initializeDependentDropdowns() {
        if (courseSelect.value) {
            // Store the original selected values before clearing
            const originalSubjectId = subjectSelect.value;
            const originalTopicId = topicSelect.value;
            
            // Populate subjects based on current course
            const courseId = courseSelect.value;
            const filteredSubjects = allSubjects.filter(subject => 
                subject.course_id == courseId
            );
            
            // Clear and populate subjects
            subjectSelect.innerHTML = '<option value="">Select a subject</option>';
            filteredSubjects.forEach(subject => {
                const option = document.createElement('option');
                option.value = subject.id;
                option.textContent = subject.name;
                if (subject.id == originalSubjectId) {
                    option.selected = true;
                }
                subjectSelect.appendChild(option);
            });
            
            // If subject is selected, populate topics
            if (originalSubjectId) {
                const subjectId = originalSubjectId;
                const filteredTopics = allTopics.filter(topic => topic.subject_id == subjectId);
                
                // Clear and populate topics
                topicSelect.innerHTML = '<option value="">Select a topic</option>';
                filteredTopics.forEach(topic => {
                    const option = document.createElement('option');
                    option.value = topic.id;
                    option.textContent = topic.name;
                    if (topic.id == originalTopicId) {
                        option.selected = true;
                    }
                    topicSelect.appendChild(option);
                });
            }
        }
    }
    
    // Initialize dependent dropdowns on page load
    initializeDependentDropdowns();
    
    // Form validation and submission
    const form = document.getElementById('mcqForm');
    const submitBtn = document.getElementById('submitBtn');
    
    function validateForm() {
        const courseId = document.getElementById('course_id').value;
        const subjectId = document.getElementById('subject_id').value;
        const questionText = document.getElementById('question_text').value;
        const optionA = document.querySelector('input[name="option_a"]').value;
        const optionB = document.querySelector('input[name="option_b"]').value;
        const optionC = document.querySelector('input[name="option_c"]').value;
        const optionD = document.querySelector('input[name="option_d"]').value;
        const correctAnswer = document.querySelector('input[name="correct_answer"]:checked');
        
        if (!courseId) {
            showNotification('Please select a course', 'error');
            return false;
        }
        
        if (!subjectId) {
            showNotification('Please select a subject', 'error');
            return false;
        }
        
        if (!questionText.trim()) {
            showNotification('Please enter question text', 'error');
            return false;
        }
        
        if (!optionA.trim()) {
            showNotification('Please enter option A', 'error');
            return false;
        }
        
        if (!optionB.trim()) {
            showNotification('Please enter option B', 'error');
            return false;
        }
        
        if (!optionC.trim()) {
            showNotification('Please enter option C', 'error');
            return false;
        }
        
        if (!optionD.trim()) {
            showNotification('Please enter option D', 'error');
            return false;
        }
        
        if (!correctAnswer) {
            showNotification('Please select the correct answer', 'error');
            return false;
        }
        
        return true;
    }
    
    form.addEventListener('submit', function(e) {
        e.preventDefault();
        
        if (!validateForm()) {
            return;
        }
        
        
        // Update hidden textarea with current editor content
        const editor = document.getElementById('richTextEditor');
        const hiddenTextarea = document.getElementById('question_text');
        hiddenTextarea.value = editor.innerHTML;
        
        // Disable submit button to prevent double submission
        submitBtn.disabled = true;
        submitBtn.innerHTML = `
            <svg class="w-4 h-4 mr-2 animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
            </svg>
            Updating...
        `;
        
        // Submit the form
        this.submit();
    });
    
});
</script>
@endsection
