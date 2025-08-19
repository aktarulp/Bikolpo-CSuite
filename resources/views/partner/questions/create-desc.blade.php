@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-slate-50 to-blue-50 py-8">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header Section -->
        <div class="mb-8">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900 bg-gradient-to-r from-blue-600 to-purple-600 bg-clip-text text-transparent">
                        Create Descriptive Question
                    </h1>
                    <p class="mt-2 text-gray-600">Design engaging descriptive questions for your students</p>
                </div>
                <div class="flex items-center space-x-3">
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
            <form action="{{ route('partner.questions.descriptive.store') }}" method="POST" id="descriptiveForm" class="p-8" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="question_type" value="descriptive">
                <input type="hidden" name="q_type_id" value="2">
                
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
                                    <option value="{{ $course->id }}">{{ $course->name }}</option>
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
                                <option value="">Select a subject</option>
                                @foreach($subjects ?? [] as $subject)
                                    <option value="{{ $subject->id }}">{{ $subject->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Topic Selection -->
                        <div class="space-y-2">
                            <label for="topic_id" class="block text-sm font-medium text-gray-700">
                                Topic <span class="text-gray-500">(Optional)</span>
                            </label>
                            <select name="topic_id" id="topic_id"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 bg-white">
                                <option value="">Select a topic (optional)</option>
                                @foreach($topics ?? [] as $topic)
                                    <option value="{{ $topic->id }}">{{ $topic->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                <!-- Question Text Section -->
                 <div class="mb-8">
                    <div class="flex items-center mb-6">
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
                                     <button type="button" id="uploadImageBtn" class="p-2 hover:bg-gray-200 rounded" title="Upload Local Image">
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
                                     </button>
                                 </div>
                                 
                                 <!-- Rich Text Editor Content -->
                                 <div id="richTextEditor" class="border border-t-0 border-gray-300 rounded-b-lg min-h-[150px] p-4 focus-within:ring-2 focus-within:ring-blue-500 focus-within:border-blue-500 transition-all duration-200" contenteditable="true" data-placeholder="Enter your question here... You can use formatting, images, and equations."></div>
                                 
                                 <!-- Hidden textarea for form submission -->
                                 <textarea name="question_text" id="question_text" class="hidden" required></textarea>
                                 
                                 <div class="flex justify-between items-center text-sm text-gray-500 mt-2">
                                     <span>Use the toolbar above for formatting, equations, and images.</span>
                                     <span id="charCount">0 characters</span>
                                 </div>
                             </div>
                         </div>
                     </div>
                </div>

                <!-- Question Image (Optional) -->
                <div class="mb-8">
                    <div class="flex items-center mb-6">
                            <div class="flex-shrink-0">
                            <div class="w-10 h-10 bg-gradient-to-r from-green-500 to-emerald-600 rounded-full flex items-center justify-center">
                                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>
                                </div>
                            </div>
                            <div class="ml-4">
                            <h2 class="text-xl font-semibold text-gray-900">Question Image (Optional)</h2>
                            <p class="text-gray-600">Add an image to support your question</p>
                            </div>
                        </div>
                        
                            <div class="space-y-2">
                        <label for="image" class="block text-sm font-medium text-gray-700">
                            Upload Image
                                </label>
                        <input type="file" name="image" id="image" accept="image/*"
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 bg-white file:mr-4 file:px-4 file:py-2 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                    </div>
                </div>

                <!-- Tags Section -->
                <div class="mb-8">
                    <div class="flex items-center mb-6">
                        <div class="flex-shrink-0">
                            <div class="w-10 h-10 bg-gradient-to-r from-pink-500 to-rose-600 rounded-full flex items-center justify-center">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a1.994 1.994 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
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
                        <div id="tag-list" class="flex flex-wrap gap-2 mb-2 min-h-[44px] p-2 border border-gray-300 rounded-lg bg-white">
                            <!-- Tags will be dynamically added here -->
                        </div>
                        <input type="text" id="new-tag" 
                               placeholder="Type and press Enter or comma to add tags"
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200">
                        <input type="hidden" name="tags" id="tagsInput" value="">
                        <p class="text-sm text-gray-500">Tags help organize and search questions</p>
                    </div>
                </div>

                <!-- Question Appearance History -->
                <div class="mb-8">
                    <div class="flex items-center mb-6">
                        <div class="flex-shrink-0">
                            <div class="w-10 h-10 bg-gradient-to-r from-amber-500 to-orange-500 rounded-full flex items-center justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5 text-white">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm.75-11.25a.75.75 0 00-1.5 0v2.5h-2.5a.75.75 0 000 1.5h2.5v2.5a.75.75 0 001.5 0v-2.5h2.5a.75.75 0 000-1.5h-2.5v-2.5z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </div>
                        <div>
                            <h2 class="text-lg font-semibold leading-6 text-slate-800">Question Appearance History</h2>
                            <p class="text-sm text-gray-500">Add where and when this question has appeared before.</p>
                        </div>
                    </div>
                    
                    <div class="space-y-4">
                        <div id="history-list" class="space-y-2 mb-4">
                            <!-- History items will be added here dynamically -->
                        </div>
                        <div class="flex gap-2">
                            <div class="w-48">
                                <input type="text" id="exam-name" placeholder="Exam/Test name (e.g., SSC, HSC, JEE)"
                                    class="block w-full rounded-md border-0 py-1.5 px-3 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                            </div>
                            <div class="w-40">
                                <select id="exam-board" class="block w-full rounded-md border-0 py-1.5 px-3 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                    <option value="">Exam Board (Optional)</option>
                                    <option value="Barisal">Barisal</option>
                                    <option value="Chattogram">Chattogram</option>
                                    <option value="Cumilla">Cumilla</option>
                                    <option value="Dhaka">Dhaka</option>
                                    <option value="Dinajpur">Dinajpur</option>
                                    <option value="Jashore">Jashore</option>
                                    <option value="Mymensingh">Mymensingh</option>
                                    <option value="Rajshahi">Rajshahi</option>
                                    <option value="Sylhet">Sylhet</option>
                                    <option value="Madrasah">Madrasah</option>
                                    <option value="Technical">Technical</option>
                                </select>
                            </div>
                            <div class="w-24">
                                <input type="number" id="exam-year" placeholder="Year"
                                    min="1972" max="{{ date('Y') }}" pattern="\d{4}"
                                    title="Enter a 4-digit year between 1972 and {{ date('Y') }}"
                                    class="block w-full rounded-md border-0 py-1.5 px-3 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                            </div>
                            <div class="w-32">
                                <select id="exam-month" class="block w-full rounded-md border-0 py-1.5 px-3 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                    <option value="">Month</option>
                                    <option value="January">January</option>
                                    <option value="February">February</option>
                                    <option value="March">March</option>
                                    <option value="April">April</option>
                                    <option value="May">May</option>
                                    <option value="June">June</option>
                                    <option value="July">July</option>
                                    <option value="August">August</option>
                                    <option value="September">September</option>
                                    <option value="October">October</option>
                                    <option value="November">November</option>
                                    <option value="December">December</option>
                                </select>
                            </div>
                            <button type="button" onclick="addHistory()" class="flex items-center justify-center h-9 w-9 rounded-full bg-indigo-600 text-white hover:bg-indigo-500 focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition duration-150">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5">
                                    <path d="M10.75 4.75a.75.75 0 00-1.5 0v4.5h-4.5a.75.75 0 000 1.5h4.5v4.5a.75.75 0 001.5 0v-4.5h4.5a.75.75 0 000-1.5h-4.5v-4.5z" />
                                </svg>
                            </button>
                        </div>
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
                        Create Question
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

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Rich text editor functionality
    const richTextEditor = document.getElementById('richTextEditor');
    const boldBtn = document.getElementById('boldBtn');
    const italicBtn = document.getElementById('italicBtn');
    const underlineBtn = document.getElementById('underlineBtn');
    const equationBtn = document.getElementById('equationBtn');
    const uploadImageBtn = document.getElementById('uploadImageBtn');
    const imageFileInput = document.getElementById('imageFileInput');
    const resizeBtn = document.getElementById('resizeBtn');
    const charCount = document.getElementById('charCount');
    
    // Text formatting
    boldBtn.addEventListener('click', () => document.execCommand('bold', false, null));
    italicBtn.addEventListener('click', () => document.execCommand('italic', false, null));
    underlineBtn.addEventListener('click', () => document.execCommand('underline', false, null));
    
    // Character counter
    richTextEditor.addEventListener('input', function() {
        const text = this.innerText || this.textContent || '';
        charCount.textContent = text.length + ' characters';
    });

    // Image upload
    uploadImageBtn.addEventListener('click', () => imageFileInput.click());
    
    imageFileInput.addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                                 const img = document.createElement('img');
                 img.src = e.target.result;
                 img.style.maxWidth = '100%';
                 img.style.height = 'auto';
                richTextEditor.appendChild(img);
            };
            reader.readAsDataURL(file);
        }
    });

    // Form submission
    const form = document.getElementById('descriptiveForm');
    form.addEventListener('submit', function(e) {
        // Update the hidden textarea with rich text editor content before submission
        const questionContent = document.getElementById('richTextEditor').innerHTML;
        document.getElementById('question_text').value = questionContent;
        
        // Ensure tags and appearance history are properly set
        const tagsInput = document.getElementById('tagsInput');
        const historyInput = document.getElementById('historyInput');
        
        if (tagsInput && !tagsInput.value) {
            tagsInput.value = '[]';
        }
        
        if (historyInput && !historyInput.value) {
            historyInput.value = '[]';
        }
        
        // Validate form
        if (!validateForm()) {
            e.preventDefault();
            return false;
        }
        
        // Show loading state
        const submitBtn = document.getElementById('submitBtn');
        const originalText = submitBtn.innerHTML;
        submitBtn.innerHTML = `
            <svg class="animate-spin -ml-1 mr-3 h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
            Publishing...
        `;
        submitBtn.disabled = true;
        
        // Allow form to submit normally
        return true;
    });
    
    // Form validation function
    function validateForm() {
        const requiredFields = [
            'course_id', 'subject_id', 'question_text'
        ];
        
        for (const fieldName of requiredFields) {
            const field = document.querySelector(`[name="${fieldName}"]`);
            if (!field || !field.value.trim()) {
                showNotification(`Please fill in all required fields. Missing: ${fieldName.replace('_', ' ')}`, 'error');
                field?.focus();
                return false;
            }
        }
        
        // Check if question text has content
        const questionText = document.getElementById('richTextEditor').innerHTML.trim();
        if (!questionText || questionText === '<br>') {
            showNotification('Please enter question text', 'error');
            document.getElementById('richTextEditor').focus();
            return false;
        }
        
        return true;
    }
    
    // Reset form function
    function resetForm() {
        // Reset form fields
        form.reset();
        
        // Reset rich text editor
        document.getElementById('richTextEditor').innerHTML = '';
        document.getElementById('richTextEditor').classList.add('text-gray-400');
        
        // Reset character count
        document.getElementById('charCount').textContent = '0 characters';
        
        // Reset course/subject/topic dropdowns
        document.getElementById('subject_id').innerHTML = '<option value="">Select a subject</option>';
        document.getElementById('topic_id').innerHTML = '<option value="">Select a topic (optional)</option>';
        
        // Reset tags
        const tagList = document.getElementById('tag-list');
        if (tagList) {
            tagList.innerHTML = '';
        }
        const tagsInput = document.getElementById('tagsInput');
        if (tagsInput) {
            tagsInput.value = '';
        }
        
        // Reset appearance history
        const historyList = document.getElementById('history-list');
        if (historyList) {
            historyList.innerHTML = '';
        }
        const historyInput = document.getElementById('historyInput');
        if (historyInput) {
            historyInput.value = '';
        }
        
        showNotification('Form reset successfully!', 'success');
    }

    // Reset functionality
    const resetBtn = document.getElementById('resetBtn');
    resetBtn.addEventListener('click', function() {
        if (confirm('Are you sure you want to reset the form? All data will be lost.')) {
            resetForm();
        }
    });

    // Initialize Tags and Appearance History
    initializeTagsAutoCompletion();
    initializeQuestionHistory();

    // Notification function
    function showNotification(message, type = 'success') {
        const notification = document.getElementById('successNotification');
        if (!notification) {
            console.error('Notification element not found');
            return;
        }
        
        const notificationSpan = notification.querySelector('span');
        if (!notificationSpan) {
            console.error('Notification span not found');
            return;
        }
        
        // Update message
        notificationSpan.textContent = message;
        
        // Show notification
        notification.classList.remove('translate-x-full');
        
        // Hide after 3 seconds
        setTimeout(() => {
            notification.classList.add('translate-x-full');
        }, 3000);
    }
});

// Tags Management Function
function initializeTagsAutoCompletion() {
    const tagList = document.getElementById('tag-list');
    const newTagInput = document.getElementById('new-tag');
    const tagsInput = document.getElementById('tagsInput');
    
    if (!tagList || !newTagInput || !tagsInput) {
        console.error('Tags elements not found');
        return;
    }
    
    // Sample tags for auto-completion (you can replace these with actual tags from your database)
    const commonTags = [
        'algebra', 'geometry', 'calculus', 'trigonometry', 'statistics', 'probability',
        'equations', 'inequalities', 'functions', 'graphs', 'derivatives', 'integrals',
        'matrices', 'vectors', 'complex numbers', 'sequences', 'series', 'limits',
        'continuity', 'differentiation', 'integration', 'applications', 'word problems',
        'proofs', 'theorems', 'definitions', 'examples', 'exercises', 'practice',
        'basic', 'intermediate', 'advanced', 'fundamental', 'conceptual', 'procedural'
    ];
    
    // Create suggestions container
    const suggestionsContainer = document.createElement('div');
    suggestionsContainer.id = 'tagsSuggestions';
    suggestionsContainer.className = 'absolute z-10 w-full bg-white border border-gray-300 rounded-lg shadow-lg max-h-48 overflow-y-auto hidden';
    suggestionsContainer.style.top = '100%';
    suggestionsContainer.style.left = '0';
    
    // Insert suggestions container after the new tag input
    newTagInput.parentNode.style.position = 'relative';
    newTagInput.parentNode.appendChild(suggestionsContainer);
    
    // Function to add a new tag
    function addTag(tagText) {
        if (tagText.trim() === '') return;
        
        // Check if tag already exists
        const existingTags = Array.from(tagList.children).map(tag => tag.textContent.trim());
        if (existingTags.includes(tagText.trim())) return;
        
        // Create tag element
        const tag = document.createElement('div');
        tag.className = 'inline-flex items-center gap-2 px-3 py-1 bg-blue-100 text-blue-800 text-sm font-medium rounded-full border border-blue-200';
        tag.innerHTML = `
            <span>${tagText.trim()}</span>
            <button type="button" class="text-blue-600 hover:text-blue-800 focus:outline-none" onclick="removeTag(this)">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        `;
        
        tagList.appendChild(tag);
        updateTagsInput();
        newTagInput.value = '';
    }
    
    // Function to remove a tag
    window.removeTag = function(button) {
        button.parentElement.remove();
        updateTagsInput();
    };
    
    // Function to update hidden input for form submission
    function updateTagsInput() {
        const tags = Array.from(tagList.children).map(tag => tag.querySelector('span').textContent.trim());
        tagsInput.value = JSON.stringify(tags);
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
    newTagInput.addEventListener('input', function(e) {
        const value = this.value;
        
        // Check if comma was pressed
        if (e.data === ',') {
            const tagText = value.slice(0, -1).trim(); // Remove the comma
            if (tagText) {
                addTag(tagText);
            }
            return;
        }
        
        // Show suggestions based on current input
        if (value.length > 1) {
            const filteredTags = commonTags.filter(tag => 
                tag.toLowerCase().startsWith(value.toLowerCase()) && 
                tag.toLowerCase() !== value.toLowerCase()
            );
            showSuggestions(filteredTags);
        } else {
            suggestionsContainer.classList.add('hidden');
        }
    });
    
    // Handle keydown events
    newTagInput.addEventListener('keydown', function(e) {
        if (e.key === 'Enter') {
            e.preventDefault();
            addTag(this.value);
            suggestionsContainer.classList.add('hidden');
        } else if (e.key === 'Escape') {
            suggestionsContainer.classList.add('hidden');
        }
    });
    
    // Hide suggestions when clicking outside
    document.addEventListener('click', function(e) {
        if (!newTagInput.contains(e.target) && !suggestionsContainer.contains(e.target)) {
            suggestionsContainer.classList.add('hidden');
        }
    });
    
    // Handle focus to show suggestions if there's text
    newTagInput.addEventListener('focus', function() {
        const value = this.value;
        if (value.length > 1) {
            const filteredTags = commonTags.filter(tag => 
                tag.toLowerCase().startsWith(value.toLowerCase()) && 
                tag.toLowerCase() !== value.toLowerCase()
            );
            showSuggestions(filteredTags);
        }
    });
    
    // Initialize tags from old input if available
    const oldTags = @json(old('tags', []));
    if (oldTags && oldTags.length > 0) {
        oldTags.forEach(tag => addTag(tag));
    }
}

// Question Appearance History Management Functions
function initializeQuestionHistory() {
    const historyList = document.getElementById('history-list');
    
    if (!historyList) {
        console.error('History list element not found');
        return;
    }

    // Add history item
    window.addHistory = function() {
        const examName = document.getElementById('exam-name').value.trim();
        const examBoard = document.getElementById('exam-board').value;
        const examYear = document.getElementById('exam-year').value.trim();
        const examMonth = document.getElementById('exam-month').value;
        
        if (!examName || !examYear) {
            alert('Please enter both Exam/Test name and Year');
            return;
        }
        
        // Validate year format and range
        const currentYear = new Date().getFullYear();
        const yearRegex = /^\d{4}$/;
        
        if (!yearRegex.test(examYear)) {
            alert('Year must be a 4-digit number (e.g., 2025)');
            return;
        }
        
        const yearNum = parseInt(examYear);
        if (yearNum < 1972 || yearNum > currentYear) {
            alert(`Year must be between 1972 and ${currentYear}`);
            return;
        }

        // Create history text for display
        let historyText = `${examName} ${examYear}`;
        if (examBoard) {
            historyText += `, ${examBoard}`;
        }
        if (examMonth) {
            historyText += `, ${examMonth}`;
        }

        // Check if history already exists
        const existingHistory = Array.from(historyList.children).map(item => 
            item.querySelector('span').textContent.trim()
        );
        if (existingHistory.includes(historyText)) {
            alert('This history entry already exists');
            return;
        }

        // Create history item
        const historyItem = document.createElement('div');
        historyItem.className = 'flex items-center justify-between p-3 bg-gray-50 rounded-lg border border-gray-200';
        historyItem.innerHTML = `
            <div class="flex items-center space-x-3">
                <div class="flex items-center justify-center w-6 h-6 rounded-full bg-amber-100">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4 text-amber-600">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd" />
                    </svg>
                </div>
                <div class="flex flex-col">
                    <span class="text-sm font-medium text-gray-700">${historyText}</span>
                    <span class="text-xs text-gray-500">${examName}${examBoard ? ` • ${examBoard}` : ''} • ${examYear}${examMonth ? ` • ${examMonth}` : ''}</span>
                </div>
            </div>
            <button type="button" onclick="removeHistory(this)" class="text-red-500 hover:text-red-700 transition-colors duration-200">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4">
                    <path fill-rule="evenodd" d="M8.75 4A.75.75 0 018 3.25a.75.75 0 01.75-.75h2.5a.75.75 0 01.75.75v2.5a.75.75 0 01-.75.75h-2.5A.75.75 0 018 5.75v-2.5zM8 8.75A.75.75 0 018.75 8h2.5a.75.75 0 01.75.75v2.5a.75.75 0 01-.75.75h-2.5A.75.75 0 018 11.25v-2.5zM8.75 13A.75.75 0 018 12.25a.75.75 0 01.75-.75h2.5a.75.75 0 01.75.75v2.5a.75.75 0 01-.75.75h-2.5A.75.75 0 018 14.75v-2.5z" clip-rule="evenodd" />
                </svg>
            </button>
        `;
        
        // Store the detailed data as a data attribute
        historyItem.setAttribute('data-exam-name', examName);
        historyItem.setAttribute('data-exam-board', examBoard);
        historyItem.setAttribute('data-exam-year', examYear);
        historyItem.setAttribute('data-exam-month', examMonth);
        
        historyList.appendChild(historyItem);
        
        // Clear the input fields
        document.getElementById('exam-name').value = '';
        document.getElementById('exam-board').value = '';
        document.getElementById('exam-year').value = '';
        document.getElementById('exam-month').value = '';
        
        updateHistoryInput();
    };

    // Remove history item
    window.removeHistory = function(button) {
        const historyItem = button.closest('div');
        historyItem.remove();
        updateHistoryInput();
    };

    // Update hidden input for form submission
    function updateHistoryInput() {
        const historyItems = Array.from(historyList.children).map(item => ({
            exam_name: item.getAttribute('data-exam-name'),
            exam_board: item.getAttribute('data-exam-board'),
            exam_year: item.getAttribute('data-exam-year'),
            exam_month: item.getAttribute('data-exam-month')
        }));
        
        // Create or update hidden input for form submission
        let hiddenInput = document.getElementById('historyInput');
        if (!hiddenInput) {
            hiddenInput = document.createElement('input');
            hiddenInput.type = 'hidden';
            hiddenInput.name = 'appearance_history';
            hiddenInput.id = 'historyInput';
            document.getElementById('descriptiveForm').appendChild(hiddenInput);
        }
        hiddenInput.value = JSON.stringify(historyItems);
    }

    // Handle Enter key press on input fields
    const examNameInput = document.getElementById('exam-name');
    const examBoardInput = document.getElementById('exam-board');
    const examYearInput = document.getElementById('exam-year');
    const examMonthInput = document.getElementById('exam-month');
    
    if (examNameInput) {
        examNameInput.addEventListener('keydown', function(e) {
            if (e.key === 'Enter') {
                e.preventDefault();
                addHistory();
            }
        });
    }
    
    if (examBoardInput) {
        examBoardInput.addEventListener('keydown', function(e) {
            if (e.key === 'Enter') {
                e.preventDefault();
                addHistory();
            }
        });
    }
    
    if (examYearInput) {
        examYearInput.addEventListener('keydown', function(e) {
            if (e.key === 'Enter') {
                e.preventDefault();
                addHistory();
            }
        });
    }
    
    if (examMonthInput) {
        examYearInput.addEventListener('keydown', function(e) {
            if (e.key === 'Enter') {
                e.preventDefault();
                addHistory();
            }
        });
    }

    // Load history from old input if available (for edit mode)
    const oldHistory = @json(old('appearance_history', []));
    if (oldHistory && oldHistory.length > 0) {
        oldHistory.forEach(history => {
            // Populate the input fields
            if (history.exam_name) document.getElementById('exam-name').value = history.exam_name;
            if (history.exam_board) document.getElementById('exam-board').value = history.exam_board;
            if (history.exam_year) document.getElementById('exam-year').value = history.exam_year;
            if (history.exam_month) document.getElementById('exam-month').value = history.exam_month;
            
            // Add the history item
            addHistory();
        });
    }
}
</script>
@endsection

@push('styles')
<style>
/* Tags Auto-completion Styling */
#tagsSuggestions {
    position: absolute;
    z-index: 10;
    width: 100%;
    background: white;
    border: 1px solid #d1d5db;
    border-radius: 0.5rem;
    box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
    max-height: 12rem;
    overflow-y: auto;
    display: none;
}

#tagsSuggestions:not(.hidden) {
    display: block;
}

/* Question Appearance History Styling */
#history-list .bg-gray-50 {
    transition: all 0.2s ease-in-out;
}

#history-list .bg-gray-50:hover {
    background-color: #f9fafb;
    border-color: #d1d5db;
}

/* Form validation styling */
.error {
    border-color: #ef4444 !important;
    box-shadow: 0 0 0 3px rgba(239, 68, 68, 0.1) !important;
}

.success {
    border-color: #10b981 !important;
    box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.1) !important;
}
</style>
@endpush
