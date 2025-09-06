@extends('layouts.partner-layout')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-slate-50 to-blue-50 py-8">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header Section -->
        <div class="mb-8">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900 bg-gradient-to-r from-blue-600 to-purple-600 bg-clip-text text-transparent">
                        Edit True/False Question
                    </h1>
                    <p class="mt-2 text-gray-600">Modify your true/false question content and settings</p>
                </div>
                <div class="flex items-center space-x-3">
                    <a href="{{ route('partner.questions.drafts') }}" 
                       class="inline-flex items-center px-4 py-2 bg-yellow-600 hover:bg-yellow-700 text-white rounded-lg text-sm font-medium transition-colors duration-200">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        View Drafts
                    </a>
                    <a href="{{ route('partner.questions.index') }}" 
                       class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all duration-200">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                        Back to Questions
                    </a>
                </div>
            </div>
        </div>

        <!-- Main Form Container -->
        <div class="bg-white rounded-2xl shadow-xl border border-gray-100 overflow-hidden">
            <form action="{{ route('partner.questions.tf.update', $question->id) }}" method="POST" id="tfEditForm" class="p-8" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <input type="hidden" name="question_type" value="true_false">
                <input type="hidden" name="q_type_id" value="3">
                <input type="hidden" name="question_id" value="{{ $question->id }}">
                
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
                            <p class="text-gray-600">Select course, subject, and topic for your question</p>
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
                                    <option value="{{ $course->id }}" {{ old('course_id', $question->course_id) == $course->id ? 'selected' : '' }}>{{ $course->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Subject Selection -->
                        <div class="space-y-2">
                            <label for="subject_id" class="block text-sm font-medium text-gray-700">
                                Subject <span class="text-red-500">*</span>
                            </label>
                            <select name="subject_id" id="subject_id" required
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 bg-white">
                                <option value="">Please select a course first</option>
                                @foreach($subjects ?? [] as $subject)
                                    <option value="{{ $subject->id }}" data-course-id="{{ $subject->course_id }}" {{ old('subject_id', $question->subject_id) == $subject->id ? 'selected' : '' }}>{{ $subject->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Topic Selection -->
                        <div class="space-y-2">
                            <label for="topic_id" class="block text-sm font-medium text-gray-700">
                                Topic <span class="text-gray-400">(Optional)</span>
                            </label>
                            <select name="topic_id" id="topic_id"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 bg-white">
                                <option value="">Please select a subject first</option>
                                @foreach($topics ?? [] as $topic)
                                    <option value="{{ $topic->id }}" data-subject-id="{{ $topic->subject_id }}" {{ old('topic_id', $question->topic_id) == $topic->id ? 'selected' : '' }}>{{ $topic->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                <!-- Question Text Section -->
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
                     </div>

                     <div class="space-y-2">
                         <div class="w-full">
                             <!-- Rich Text Editor -->
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
                                 <textarea name="question_text" id="question_text" class="hidden" required></textarea>
                                 <input type="hidden" name="q_type_id" value="1">
                                 
                                 <div class="flex justify-between items-center text-sm text-gray-500 mt-2">
                                     <span>Use the toolbar above for formatting, equations, and images.</span>
                                     <span id="charCount">0 characters</span>
                                 </div>
                         </div>
                     </div>
                     

                </div>

                <!-- True/False Answer Options Section -->
                <div class="mb-8">
                    <div class="flex items-start gap-6">
                        <!-- Question Text Area (Left) -->
                        <div class="flex-1">
                            <div class="flex items-center mb-4">
                                <div class="flex-shrink-0">
                                    <div class="w-8 h-8 bg-gradient-to-r from-orange-500 to-red-600 rounded-full flex items-center justify-center">
                                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                    </div>
                                </div>
                                <div class="ml-3">
                                    <h3 class="text-lg font-semibold text-gray-900">Correct Answer</h3>
                                    <p class="text-sm text-gray-600">Select the correct answer</p>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Answer Options (Right) -->
                        <div class="w-80">
                            <div class="space-y-3">
                                <!-- True Option -->
                                <label class="flex items-center p-3 border border-gray-200 rounded-lg cursor-pointer hover:border-blue-300 hover:bg-blue-50 transition-all duration-200 group">
                                    <input type="radio" name="correct_answer" value="a" 
                                           class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 focus:ring-2" required
                                           {{ old('correct_answer', $question->correct_answer) == 'a' ? 'checked' : '' }}>
                                    <div class="flex items-center space-x-2 ml-3">
                                        <div class="w-5 h-5 bg-green-100 rounded-full flex items-center justify-center group-hover:bg-green-200 transition-colors duration-200">
                                            <svg class="w-3 h-3 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                            </svg>
                                        </div>
                                        <span class="text-sm font-medium text-gray-900 group-hover:text-blue-600 transition-colors duration-200">
                                            True
                                        </span>
                                    </div>
                                </label>

                                <!-- False Option -->
                                <label class="flex items-center p-3 border border-gray-200 rounded-lg cursor-pointer hover:border-red-300 hover:bg-red-50 transition-all duration-200 group">
                                    <input type="radio" name="correct_answer" value="b" 
                                           class="w-4 h-4 text-red-600 bg-gray-100 border-gray-300 focus:ring-red-500 focus:ring-2" required
                                           {{ old('correct_answer', $question->correct_answer) == 'b' ? 'checked' : '' }}>
                                    <div class="flex items-center space-x-2 ml-3">
                                        <div class="w-5 h-5 bg-red-100 rounded-full flex items-center justify-center group-hover:bg-red-200 transition-colors duration-200">
                                            <svg class="w-3 h-3 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                            </svg>
                                        </div>
                                        <span class="text-sm font-medium text-gray-900 group-hover:text-red-600 transition-colors duration-200">
                                            False
                                        </span>
                                    </div>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Tags Section -->
                <div class="mb-8">
                    <div class="flex items-center mb-6">
                        <div class="flex-shrink-0">
                            <div class="w-10 h-10 bg-gradient-to-r from-pink-500 to-rose-600 rounded-full flex items-center justify-center">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                                </svg>
                            </div>
                        </div>
                        <div class="ml-4">
                            <h2 class="text-xl font-semibold text-gray-900">Tags</h2>
                            <p class="text-gray-600">Add relevant tags for easy categorization</p>
                        </div>
                    </div>
                    
                    <div class="space-y-2">
                        <label for="tags" class="block text-sm font-medium text-gray-700">
                            Tags
                        </label>
                        <div class="relative">
                            <!-- Two-line tag display -->
                            <div id="tags-container" class="w-full min-h-[80px] px-4 py-3 border border-gray-300 rounded-lg focus-within:ring-2 focus-within:ring-blue-500 focus-within:border-blue-500 transition-all duration-200 bg-white cursor-text">
                                <!-- Upper line for completed tags -->
                                <div id="tags-upper-line" class="flex flex-wrap gap-2 mb-2 min-h-[32px] items-center">
                                    <!-- Completed tags will appear here -->
                                </div>
                                <!-- Lower line for current input -->
                                <div id="tags-lower-line" class="flex items-center">
                                    <input type="text" id="tags-input" 
                                           placeholder="Type a tag and press comma to complete"
                                           class="flex-1 border-none outline-none bg-transparent text-sm placeholder-gray-400"
                                           autocomplete="off">
                                </div>
                            </div>
                            <div id="tag-suggestions" class="absolute z-10 w-full bg-white border border-gray-300 rounded-lg shadow-lg max-h-48 overflow-y-auto hidden mt-1">
                                <!-- Tag suggestions will appear here -->
                            </div>
                        </div>
                        <p class="text-sm text-gray-500">Tags help organize and search questions. Press comma to complete each tag and move it to the upper line.</p>
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="flex items-center justify-end space-x-4 pt-6 border-t border-gray-200">
                        <button type="button" id="resetBtn"
                            class="px-6 py-3 border border-gray-300 rounded-lg text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition-all duration-200">
                        Reset Form
                        </button>
                        <button type="submit" id="submitBtn"
                            class="px-8 py-3 bg-gradient-to-r from-blue-600 to-purple-600 text-white rounded-lg font-medium hover:from-blue-700 hover:to-purple-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all duration-200 transform hover:scale-105">
                        Update Question
                        </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Success Notification -->
<div id="successNotification" class="fixed top-4 right-4 bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg transform translate-x-full transition-transform duration-300 z-50">
    <span></span>
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


// Two-Line Tags Management Function
function initializeTagsAutoCompletion() {
    const tagsInput = document.getElementById('tags-input');
    const tagsUpperLine = document.getElementById('tags-upper-line');
    const tagsContainer = document.getElementById('tags-container');
    const suggestionsContainer = document.getElementById('tag-suggestions');
    const hiddenTagsInput = document.createElement('input');
    hiddenTagsInput.type = 'hidden';
    hiddenTagsInput.name = 'tags';
    hiddenTagsInput.id = 'tags-hidden';
    tagsContainer.parentNode.appendChild(hiddenTagsInput);
    
    console.log('Initializing two-line tag auto-completion:', {
        tagsInput: !!tagsInput,
        tagsUpperLine: !!tagsUpperLine,
        suggestionsContainer: !!suggestionsContainer
    });
    
    if (!tagsInput || !tagsUpperLine || !suggestionsContainer) {
        console.log('Two-line tag auto-completion initialization failed - missing elements');
        return;
    }
    
    // Sample tags for auto-completion
    const commonTags = [
        'algebra', 'geometry', 'calculus', 'trigonometry', 'statistics', 'probability',
        'equations', 'inequalities', 'functions', 'graphs', 'derivatives', 'integrals',
        'matrices', 'vectors', 'complex numbers', 'sequences', 'series', 'limits',
        'continuity', 'differentiation', 'integration', 'applications', 'word problems',
        'proofs', 'theorems', 'definitions', 'examples', 'exercises', 'practice',
        'basic', 'intermediate', 'advanced', 'fundamental', 'conceptual', 'procedural'
    ];
    
    // Store all tags
    let allTags = [];
    
    // Function to update hidden input with all tags
    function updateHiddenInput() {
        hiddenTagsInput.value = allTags.join(', ');
        console.log('Updated hidden input with tags:', hiddenTagsInput.value);
    }
    
    // Function to create a tag element
    function createTagElement(tagText) {
        const tagElement = document.createElement('span');
        tagElement.className = 'inline-flex items-center px-3 py-1 rounded-full text-sm bg-blue-100 text-blue-800 border border-blue-200 hover:bg-blue-200 transition-colors duration-200';
        tagElement.innerHTML = `
            <span class="mr-1">${tagText}</span>
            <button type="button" class="ml-1 text-blue-600 hover:text-blue-800 focus:outline-none" onclick="removeTag('${tagText}')">
                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        `;
        return tagElement;
    }
    
    // Function to add a tag to the upper line
    function addTag(tagText) {
        if (tagText.trim() === '') return;
        
        const trimmedTag = tagText.trim();
        console.log('Adding tag:', trimmedTag);
        
        // Check if tag already exists
        if (allTags.includes(trimmedTag)) {
            console.log('Tag already exists:', trimmedTag);
            return;
        }
        
        // Add to tags array
        allTags.push(trimmedTag);
        console.log('Current tags array:', allTags);
        
        // Create and add tag element to upper line
        const tagElement = createTagElement(trimmedTag);
        tagsUpperLine.appendChild(tagElement);
        
        // Clear input
        tagsInput.value = '';
        
        // Update hidden input
        updateHiddenInput();
        
        // Hide suggestions
        suggestionsContainer.classList.add('hidden');
    }
    
    // Function to remove a tag
    window.removeTag = function(tagText) {
        // Remove from array
        allTags = allTags.filter(tag => tag !== tagText);
        
        // Remove from DOM
        const tagElements = tagsUpperLine.querySelectorAll('span');
        tagElements.forEach(element => {
            if (element.textContent.includes(tagText)) {
                element.remove();
            }
        });
        
        // Update hidden input
        updateHiddenInput();
    }
    
    // Function to show suggestions
    function showSuggestions(filteredTags) {
        if (filteredTags.length === 0) {
            suggestionsContainer.classList.add('hidden');
            return;
        }
        
        suggestionsContainer.innerHTML = '';
        filteredTags.forEach(tag => {
            const suggestionItem = document.createElement('div');
            suggestionItem.className = 'px-4 py-2 hover:bg-blue-50 cursor-pointer text-sm text-gray-700 border-b border-gray-100 last:border-b-0';
            suggestionItem.textContent = tag;
            
            suggestionItem.addEventListener('click', function() {
                addTag(tag);
                suggestionsContainer.classList.add('hidden');
            });
            
            suggestionsContainer.appendChild(suggestionItem);
        });
        
        suggestionsContainer.classList.remove('hidden');
    }
    
    // Handle input events for auto-completion
    tagsInput.addEventListener('input', function(e) {
        const value = this.value.trim();
        
        if (value.length > 1) {
            const filteredTags = commonTags.filter(tag => 
                tag.toLowerCase().startsWith(value.toLowerCase()) && 
                tag.toLowerCase() !== value.toLowerCase() &&
                !allTags.includes(tag)
            );
            showSuggestions(filteredTags);
        } else {
            suggestionsContainer.classList.add('hidden');
        }
    });
    
    // Handle keydown events
    tagsInput.addEventListener('keydown', function(e) {
        if (e.key === 'Enter') {
            e.preventDefault();
            const value = this.value.trim();
            if (value) {
                addTag(value);
            }
            suggestionsContainer.classList.add('hidden');
        } else if (e.key === 'Escape') {
            suggestionsContainer.classList.add('hidden');
        } else if (e.key === ',') {
            e.preventDefault();
            const value = this.value.trim();
            if (value) {
                addTag(value);
            }
        } else if (e.key === 'Backspace' && this.value === '') {
            // If input is empty and backspace is pressed, focus on the last tag for removal
            const lastTag = tagsUpperLine.lastElementChild;
            if (lastTag) {
                const removeButton = lastTag.querySelector('button');
                if (removeButton) {
                    removeButton.focus();
                }
            }
        }
    });
    
    // Handle focus events
    tagsInput.addEventListener('focus', function() {
        const value = this.value.trim();
        if (value.length > 1) {
            const filteredTags = commonTags.filter(tag => 
                tag.toLowerCase().startsWith(value.toLowerCase()) && 
                tag.toLowerCase() !== value.toLowerCase() &&
                !allTags.includes(tag)
            );
            showSuggestions(filteredTags);
        }
    });
    
    // Handle container click to focus input
    tagsContainer.addEventListener('click', function(e) {
        if (e.target === tagsContainer || e.target === tagsUpperLine) {
            tagsInput.focus();
        }
    });
    
    // Hide suggestions when clicking outside
    document.addEventListener('click', function(e) {
        if (!tagsContainer.contains(e.target) && !suggestionsContainer.contains(e.target)) {
            suggestionsContainer.classList.add('hidden');
        }
    });
    
    // Initialize tags from existing question data
    const existingTags = @json(old('tags', $question->tags ?? []));
    if (existingTags && existingTags.length > 0) {
        if (Array.isArray(existingTags)) {
            existingTags.forEach(tag => {
                if (tag.trim()) {
                    allTags.push(tag.trim());
                    const tagElement = createTagElement(tag.trim());
                    tagsUpperLine.appendChild(tagElement);
                }
            });
        } else if (typeof existingTags === 'string') {
            const tags = existingTags.split(',').map(tag => tag.trim()).filter(tag => tag);
            tags.forEach(tag => {
                allTags.push(tag);
                const tagElement = createTagElement(tag);
                tagsUpperLine.appendChild(tagElement);
            });
        }
        updateHiddenInput();
    }
    
    console.log('Two-line tag auto-completion initialized successfully');
}

document.addEventListener('DOMContentLoaded', function() {
    console.log('DOM Content Loaded - Starting initialization');
    
    try {
        // Initialize Custom Rich Text Editor
        console.log('Initializing Rich Text Editor...');
        initializeRichTextEditor();
        console.log('Rich Text Editor initialized');
        
        // Initialize Tags Auto Completion
        console.log('Initializing Tags Auto Completion...');
        initializeTagsAutoCompletion();
        console.log('Tags Auto Completion initialization completed');
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
            // Enable subject select
            subjectSelect.disabled = false;
            subjectSelect.className = 'w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 bg-white';
            
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
        } else {
            // Disable subject select if no course selected
            subjectSelect.disabled = true;
            subjectSelect.className = 'w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 bg-gray-100';
        }
    });
    
    // Subject change handler
    subjectSelect.addEventListener('change', function() {
        const subjectId = this.value;
        
        // Reset topic selection
        topicSelect.innerHTML = '<option value="">Select a topic</option>';
        
        if (subjectId) {
            // Enable topic select
            topicSelect.disabled = false;
            topicSelect.className = 'w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 bg-white';
            
            // Filter topics by subject
            const filteredTopics = allTopics.filter(topic => topic.subject_id == subjectId);
            filteredTopics.forEach(topic => {
                        const option = document.createElement('option');
                        option.value = topic.id;
                        option.textContent = topic.name;
                        topicSelect.appendChild(option);
            });
        } else {
            // Disable topic select if no subject selected
            topicSelect.disabled = true;
            topicSelect.className = 'w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 bg-gray-100';
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
    const form = document.getElementById('tfEditForm');
    const resetBtn = document.getElementById('resetBtn');
    const submitBtn = document.getElementById('submitBtn');
    
    // Form validation
    form.addEventListener('submit', function(e) {
        if (!validateForm()) {
            e.preventDefault();
            return false;
        }
        
        // Debug: Check tags before submission
        const hiddenTagsInput = document.getElementById('tags-hidden');
        console.log('Tags being submitted:', hiddenTagsInput ? hiddenTagsInput.value : 'No hidden input found');
        
        // Show loading state
        const originalText = submitBtn.innerHTML;
        submitBtn.innerHTML = `
            <svg class="animate-spin -ml-1 mr-3 h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
            Updating...
        `;
        submitBtn.disabled = true;
        
        return true;
    });
    
    // Form validation function
    function validateForm() {
        const requiredFields = [
            'course_id', 'subject_id', 'question_text', 'correct_answer'
        ];
        
        for (const fieldName of requiredFields) {
            const field = document.querySelector(`[name="${fieldName}"]`);
            if (!field || !field.value.trim()) {
                showNotification(`Please fill in all required fields. Missing: ${fieldName.replace('_', ' ')}`, 'error');
                field?.focus();
                return false;
            }
        }

        // Special validation for rich text editor
        const editor = document.getElementById('richTextEditor');
        const editorText = editor ? (editor.innerText || editor.textContent || '') : '';
        
        if (editorText.trim() === '' || editorText.includes('Enter your question here')) {
            showNotification('Please enter a question text.', 'error');
            editor?.focus();
            return false;
        }
        
        return true;
    }
    
    // Reset form function
    function resetForm() {
        form.reset();
        
        // Reset rich text editor
        const editor = document.getElementById('richTextEditor');
        editor.innerHTML = '';
        document.getElementById('question_text').value = '';
        updateCharCount();
        
        // Reset dropdowns to initial state
        subjectSelect.innerHTML = '<option value="">Please select a course first</option>';
        subjectSelect.disabled = true;
        subjectSelect.className = 'w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 bg-gray-100';
        
        topicSelect.innerHTML = '<option value="">Please select a subject first</option>';
        topicSelect.disabled = true;
        topicSelect.className = 'w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 bg-gray-100';
        
        // Reset tags
        const tagsUpperLine = document.getElementById('tags-upper-line');
        const tagsInput = document.getElementById('tags-input');
        if (tagsUpperLine) {
            tagsUpperLine.innerHTML = '';
        }
        if (tagsInput) {
            tagsInput.value = '';
        }
        
        showNotification('Form reset successfully!', 'success');
    }

    // Reset functionality
    resetBtn.addEventListener('click', function() {
        if (confirm('Are you sure you want to reset the form? All data will be lost.')) {
            resetForm();
        }
    });
    
    // Update character count function
    function updateCharCount() {
        const editor = document.getElementById('richTextEditor');
        const charCount = document.getElementById('charCount');
        if (editor && charCount) {
            const text = editor.textContent || '';
            charCount.textContent = text.length + ' characters';
        }
    }
});
</script>
@endsection
