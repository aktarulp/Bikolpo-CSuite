@extends('layouts.partner-layout')

@section('title', 'Edit Descriptive Question')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-slate-50 to-blue-50 py-8">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header Section -->
        <div class="mb-8">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900 bg-gradient-to-r from-blue-600 to-purple-600 bg-clip-text text-transparent">
                        Edit Descriptive Question
                    </h1>
                    <p class="mt-2 text-gray-600">Update your descriptive question</p>
                </div>
                <div class="flex items-center space-x-3">
                    <a href="{{ route('partner.questions.descriptive.index') }}" 
                       class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition-all duration-200">
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
            <form action="{{ route('partner.questions.descriptive.update', $question) }}" method="POST" id="descriptiveForm" class="p-8" enctype="multipart/form-data">
                @csrf
                @method('PUT')
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
                            <p class="text-gray-600">Update the main question and basic information</p>
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
                                @foreach($courses as $course)
                                    <option value="{{ $course->id }}" {{ $question->course_id == $course->id ? 'selected' : '' }}>
                                        {{ $course->name }}
                                    </option>
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
                                @foreach($subjects as $subject)
                                    <option value="{{ $subject->id }}" {{ $question->subject_id == $subject->id ? 'selected' : '' }}>
                                        {{ $subject->name }}
                                    </option>
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
                                @foreach($topics as $topic)
                                    <option value="{{ $topic->id }}" {{ $question->topic_id == $topic->id ? 'selected' : '' }}>
                                        {{ $topic->name }}
                                    </option>
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
                            <p class="text-gray-600">Update your question clearly and concisely</p>
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
                                </div>
                                
                                <!-- Rich Text Editor Content -->
                                <div id="richTextEditor" class="border border-t-0 border-gray-300 rounded-b-lg min-h-[150px] p-4 focus-within:ring-2 focus-within:ring-blue-500 focus-within:border-blue-500 transition-all duration-200" contenteditable="true" data-placeholder="Enter your question here... You can use formatting, images, and equations.">
                                    {!! $question->question_text !!}
                                </div>
                                
                                <!-- Hidden textarea for form submission -->
                                <textarea name="question_text" id="question_text" class="hidden" required>{{ $question->question_text }}</textarea>
                                
                                <div class="flex justify-between items-center text-sm text-gray-500 mt-2">
                                    <span>Use the toolbar above for formatting, equations, and images.</span>
                                    <span id="charCount">0 characters</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Question Image Section -->
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
                            <h2 class="text-xl font-semibold text-gray-900">Question Image</h2>
                            <p class="text-gray-600">Update or add an image to support your question</p>
                        </div>
                    </div>
                    
                    <div class="space-y-4">
                        @if($question->image)
                            <div class="flex items-center space-x-4">
                                <div class="w-32 h-24 bg-gray-100 rounded-lg flex items-center justify-center overflow-hidden">
                                    <img src="{{ Storage::url($question->image) }}" alt="Question Image" class="w-full h-full object-cover">
                                </div>
                                <div>
                                    <p class="text-sm text-gray-600">Current image</p>
                                    <p class="text-xs text-gray-500">{{ basename($question->image) }}</p>
                                </div>
                            </div>
                        @endif
                        
                        <div class="space-y-2">
                            <label for="image" class="block text-sm font-medium text-gray-700">
                                {{ $question->image ? 'Replace Image' : 'Upload Image' }}
                            </label>
                            <input type="file" name="image" id="image" accept="image/*"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 bg-white file:mr-4 file:px-4 file:py-2 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                            <p class="text-sm text-gray-500">Leave empty to keep current image</p>
                        </div>
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="flex items-center justify-end space-x-4 pt-6 border-t border-gray-200">
                    <a href="{{ route('partner.questions.descriptive.index') }}"
                       class="px-6 py-3 border border-gray-300 rounded-lg text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition-all duration-200">
                        Cancel
                    </a>
                    <button type="submit" id="submitBtn"
                            class="px-8 py-3 bg-gradient-to-r from-blue-600 to-purple-600 text-white rounded-lg font-medium hover:from-blue-700 hover:to-purple-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all duration-200 transform hover:scale-105">
                        Update Question
                    </button>
                </div>
            </form>
        </div>
    </div>
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
    const charCount = document.getElementById('charCount');
    
    // Text formatting
    boldBtn.addEventListener('click', () => document.execCommand('bold', false, null));
    italicBtn.addEventListener('click', () => document.execCommand('italic', false, null));
    underlineBtn.addEventListener('click', () => document.execCommand('underline', false, null));
    
    // Character counter
    function updateCharCount() {
        const text = richTextEditor.innerText || richTextEditor.textContent || '';
        charCount.textContent = text.length + ' characters';
    }
    
    richTextEditor.addEventListener('input', updateCharCount);
    updateCharCount(); // Initial count

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
            Updating...
        `;
        submitBtn.disabled = true;
        
        return true;
    });
    
    // Form validation function
    function validateForm() {
        const requiredFields = ['course_id', 'subject_id', 'question_text'];
        
        for (const fieldName of requiredFields) {
            const field = document.querySelector(`[name="${fieldName}"]`);
            if (!field || !field.value.trim()) {
                alert(`Please fill in all required fields. Missing: ${fieldName.replace('_', ' ')}`);
                field?.focus();
                return false;
            }
        }
        
        // Check if question text has content
        const questionText = document.getElementById('richTextEditor').innerHTML.trim();
        if (!questionText || questionText === '<br>') {
            alert('Please enter question text');
            document.getElementById('richTextEditor').focus();
            return false;
        }
        
        return true;
    }
});
</script>
@endsection
