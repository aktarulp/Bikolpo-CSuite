@extends('layouts.app')

@section('title', 'Create MCQ Question')

@section('content')
<style>
.rich-text-btn {
    @apply px-3 py-2 rounded-md text-gray-700 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-600 transition-all duration-200 border border-transparent hover:border-gray-300 dark:hover:border-gray-500;
}

.rich-text-btn:hover {
    @apply text-gray-900 dark:text-white shadow-sm;
}

.rich-text-btn:active {
    @apply bg-gray-300 dark:bg-gray-500 transform scale-95;
}

.rich-text-btn svg {
    @apply transition-colors duration-200;
}

.rich-text-btn:hover svg {
    @apply text-gray-900 dark:text-white;
}

#question_text_editor:empty:before {
    content: attr(data-placeholder);
    color: #9ca3af;
    pointer-events: none;
}

.math-equation {
    @apply inline-block px-2 py-1 mx-1 bg-gray-100 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded text-sm font-mono;
}

/* Toolbar styling improvements */
.rich-text-toolbar {
    @apply bg-gradient-to-r from-gray-50 to-gray-100 dark:from-gray-700 dark:to-gray-800;
}

.rich-text-toolbar .w-px {
    @apply bg-gray-300 dark:bg-gray-500;
}
</style>

<div class="space-y-6">
    <!-- Page Header -->
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Create MCQ Question</h1>
            <p class="text-gray-600 dark:text-gray-400">Add a new multiple choice question</p>
        </div>
                 <a href="{{ route('partner.questions.mcq.index') }}" 
            class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg transition-colors duration-200">
             Back to MCQ Questions
         </a>
    </div>

    <!-- MCQ Question Form -->
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md">
        <div class="p-6 border-b border-gray-200 dark:border-gray-700">
            <h2 class="text-lg font-semibold text-gray-900 dark:text-white">Question Details</h2>
        </div>

        <form action="{{ route('partner.questions.mcq.store') }}" method="POST" enctype="multipart/form-data" class="p-6 space-y-6">
            @csrf
            
            <!-- Course, Subject, Topic Selection -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div>
                    <label for="course_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Course *</label>
                    <select name="course_id" id="course_id" required class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:border-primaryGreen focus:ring-primaryGreen">
                        <option value="">Select Course</option>
                        @foreach($courses ?? [] as $course)
                            <option value="{{ $course->id }}" {{ old('course_id') == $course->id ? 'selected' : '' }}>
                                {{ $course->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('course_id')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="subject_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Subject *</label>
                    <select name="subject_id" id="subject_id" required class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:border-primaryGreen focus:ring-primaryGreen">
                        <option value="">Select Subject</option>
                        @foreach($subjects ?? [] as $subject)
                            <option value="{{ $subject->id }}" {{ old('subject_id') == $subject->id ? 'selected' : '' }}>
                                {{ $subject->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('subject_id')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="topic_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Topic *</label>
                    <select name="topic_id" id="topic_id" required class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:border-primaryGreen focus:ring-primaryGreen">
                        <option value="">Select Topic</option>
                        @foreach($topics ?? [] as $topic)
                            <option value="{{ $topic->id }}" {{ old('topic_id') == $topic->id ? 'selected' : '' }}>
                                {{ $topic->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('topic_id')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Question Text and MCQ Options Side by Side -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Question Text - Takes 2/3 of the width -->
                <div class="lg:col-span-2">
                    <label for="question_text" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Question Text *</label>
                    <div class="border border-gray-300 dark:border-gray-600 rounded-md overflow-hidden">
                        <!-- Rich Text Toolbar -->
                        <div class="rich-text-toolbar border-b border-gray-300 dark:border-gray-600 p-2 flex flex-wrap gap-1">
                            <button type="button" class="rich-text-btn" data-command="bold" title="Bold">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M15.6 11.79c.97-.67 1.65-1.77 1.65-2.79 0-2.26-1.75-4-4-4H7v14h7.04c2.09 0 3.71-1.7 3.71-3.79 0-1.52-.86-2.82-2.15-3.42zM10 7.5h3c.83 0 1.5.67 1.5 1.5s-.67 1.5-1.5 1.5h-3v-3zm3.5 9H10v-3h3.5c.83 0 1.5.67 1.5 1.5s-.67 1.5-1.5 1.5z"/>
                                </svg>
                            </button>
                            <button type="button" class="rich-text-btn" data-command="italic" title="Italic">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M10 4v3h2.21l-3.42 8H6v3h8v-3h-2.21l3.42-8H18V4z"/>
                                </svg>
                            </button>
                            <button type="button" class="rich-text-btn" data-command="underline" title="Underline">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M12 17c3.31 0 6-2.69 6-6V3h-2.5v8c0 1.93-1.57 3.5-3.5 3.5S8.5 12.93 8.5 11V3H6v8c0 3.31 2.69 6 6 6zm-7 2v2h14v-2H5z"/>
                                </svg>
                            </button>
                            <div class="w-px h-6 bg-gray-300 dark:bg-gray-600 mx-1"></div>
                            <button type="button" class="rich-text-btn" data-command="insertUnorderedList" title="Bullet List">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M3 13h2v-2H3v2zm0 4h2v-2H3v2zm0-8h2V7H3v2zm4 4h14v-2H7v2zm0 4h14v-2H7v2zM7 7v2h14V7H7z"/>
                                </svg>
                            </button>
                            <button type="button" class="rich-text-btn" data-command="insertOrderedList" title="Numbered List">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M2 17h2v.5H2v-1zm0-6h2v.5H2v-1zm0 3h2v.5H2v-1zm4-3h14v-2H6v2zm0 4h14v-2H6v2zM6 7v2h14V7H6z"/>
                                </svg>
                            </button>
                            <div class="w-px h-6 bg-gray-300 dark:bg-gray-600 mx-1"></div>
                            <button type="button" class="rich-text-btn" data-command="justifyLeft" title="Align Left">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M15 15H3v2h12v-2zm0-8H3v2h12V7zm0 4H3v2h12v-2z"/>
                                </svg>
                            </button>
                            <button type="button" class="rich-text-btn" data-command="justifyCenter" title="Align Center">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M7 15h10v-2H7v2zm0-8h10V5H7v2zm0 4h10v-2H7v2z"/>
                                </svg>
                            </button>
                            <button type="button" class="rich-text-btn" data-command="justifyRight" title="Align Right">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M9 15h10v-2H9v2zm0-8h10V5H9v2zm0 4h10v-2H9v2z"/>
                                </svg>
                            </button>
                            <div class="w-px h-6 bg-gray-300 dark:bg-gray-600 mx-1"></div>
                            <button type="button" class="rich-text-btn" id="mathBtn" title="Insert Math Equation">
                                <span class="text-lg font-bold">∑</span>
                            </button>
                        </div>
                        <!-- Rich Text Editor - Smaller height -->
                        <div id="question_text_editor" class="min-h-[80px] p-3 bg-white dark:bg-gray-800 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-primaryGreen focus:ring-opacity-50" contenteditable="true" data-placeholder="Enter your question here..."></div>
                        <input type="hidden" name="question_text" id="question_text" required>
                    </div>
                    @error('question_text')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror

                    <!-- Question Image - Moved below question text -->
                    <div class="mt-4">
                        <label for="image" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Question Image (Optional)</label>
                        <input type="file" name="image" id="image" accept="image/*" 
                               class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:border-primaryGreen focus:ring-primaryGreen">
                        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Supported formats: JPEG, PNG, JPG, GIF (Max: 2MB)</p>
                        @error('image')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- MCQ Options - Takes 1/3 of the width, arranged in 2 lines -->
                <div class="space-y-4">
                    <!-- First line: Option A & B -->
                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label for="option_a" class="inline-block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Option A *</label>
                            <input type="text" name="option_a" id="option_a" required 
                                   class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:border-primaryGreen focus:ring-primaryGreen"
                                   value="{{ old('option_a') }}" placeholder="Enter option A">
                            @error('option_a')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="option_b" class="inline-block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Option B *</label>
                            <input type="text" name="option_b" id="option_b" required 
                                   class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:border-primaryGreen focus:ring-primaryGreen"
                                   value="{{ old('option_b') }}" placeholder="Enter option B">
                            @error('option_b')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Second line: Option C & D with Correct Answer and Status below -->
                    <div class="grid grid-cols-2 gap-3">
                        <div class="space-y-2">
                            <label for="option_c" class="inline-block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Option C *</label>
                            <input type="text" name="option_c" id="option_c" required 
                                   class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:border-primaryGreen focus:ring-primaryGreen"
                                   value="{{ old('option_c') }}" placeholder="Enter option C">
                            @error('option_c')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                            
                            <!-- Correct Answer - Below Option C -->
                            <div>
                                <label for="correct_answer" class="block text-xs font-medium text-gray-600 dark:text-gray-400 mb-1">Correct Answer *</label>
                                <select name="correct_answer" id="correct_answer" required class="w-full text-xs rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:border-primaryGreen focus:ring-primaryGreen h-10">
                                    <option value="">Select</option>
                                    <option value="a" {{ old('correct_answer') == 'a' ? 'selected' : '' }}>A</option>
                                    <option value="b" {{ old('correct_answer') == 'b' ? 'selected' : '' }}>B</option>
                                    <option value="c" {{ old('correct_answer') == 'c' ? 'selected' : '' }}>C</option>
                                    <option value="d" {{ old('correct_answer') == 'd' ? 'selected' : '' }}>D</option>
                                </select>
                                @error('correct_answer')
                                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="space-y-2">
                            <label for="option_d" class="inline-block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Option D *</label>
                            <input type="text" name="option_d" id="option_d" required 
                                   class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:border-primaryGreen focus:ring-primaryGreen"
                                   value="{{ old('option_d') }}" placeholder="Enter option D">
                            @error('option_d')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                            
                            <!-- Status - Below Option D -->
                            <div>
                                <label for="status" class="block text-xs font-medium text-gray-600 dark:text-gray-400 mb-1">Status</label>
                                <select name="status" id="status" class="w-full text-xs rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:border-primaryGreen focus:ring-primaryGreen h-10">
                                    <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>Active</option>
                                    <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                                </select>
                                @error('status')
                                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Explanation -->
            <div>
                <label for="explanation" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Explanation</label>
                <textarea name="explanation" id="explanation" rows="3" 
                           class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:border-primaryGreen focus:ring-primaryGreen"
                           placeholder="Explain why this answer is correct...">{{ old('explanation') }}</textarea>
                @error('explanation')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Marks -->
            <div>
                <label for="marks" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Marks *</label>
                <input type="number" name="marks" id="marks" required min="1" max="100"
                       class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:border-primaryGreen focus:ring-primaryGreen"
                       value="{{ old('marks', 1) }}" placeholder="Enter marks">
                @error('marks')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Question Appearance History and Tags Side by Side -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- Question Appearance History -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Question Appearance History</label>
                    <p class="text-sm text-gray-500 dark:text-gray-400 mb-3">Add where and when this question has appeared before.</p>
                    
                    <div id="historyContainer" class="space-y-3">
                        <!-- History items will be added here -->
                    </div>
                    
                    <button type="button" onclick="addHistory()" 
                            class="mt-2 px-3 py-2 text-sm bg-blue-600 hover:bg-blue-700 text-white rounded-md transition-colors duration-200 flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                        </svg>
                        Add History
                    </button>
                </div>

                <!-- Question Tags -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Question Tags</label>
                    <p class="text-sm text-gray-500 dark:text-gray-400 mb-3">Add tags to make the question easily searchable. (e.g., #biology, #genetics)</p>
                    
                    <div class="flex flex-wrap gap-2 mb-3" id="tagsContainer">
                        <!-- Tags will be displayed here -->
                    </div>
                    
                    <div class="flex gap-2">
                        <input type="text" id="tagInput" placeholder="Enter tag (e.g., biology)" 
                               class="flex-1 rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:border-primaryGreen focus:ring-primaryGreen">
                        <button type="button" onclick="addTag()" 
                                class="px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-md transition-colors duration-200">
                            Add Tag
                        </button>
                    </div>
                    
                    <!-- Hidden input to store tags data -->
                    <input type="hidden" name="tags" id="tagsInput" value="{{ old('tags', '[]') }}">
                    <!-- Hidden input to store history data -->
                    <input type="hidden" name="appearance_history" id="historyInput" value="{{ old('appearance_history', '[]') }}">
                </div>
            </div>


            <!-- Submit Buttons -->
            <div class="flex justify-end space-x-3 pt-6 border-t border-gray-200 dark:border-gray-700">
                                 <a href="{{ route('partner.questions.mcq.index') }}" 
                    class="px-6 py-2 border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 rounded-md hover:bg-gray-700 dark:hover:bg-gray-700 transition-colors duration-200">
                     Cancel
                 </a>
                <button type="submit" 
                        class="px-6 py-2 bg-primaryGreen hover:bg-green-600 text-white rounded-md transition-colors duration-200">
                    Create Question
                </button>
            </div>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Rich Text Editor functionality
    const editor = document.getElementById('question_text_editor');
    const hiddenInput = document.getElementById('question_text');
    const mathBtn = document.getElementById('mathBtn');
    
    // Set initial content if there's old input
    if (hiddenInput.value) {
        editor.innerHTML = hiddenInput.value;
    }
    
    // Update hidden input when editor content changes
    editor.addEventListener('input', function() {
        hiddenInput.value = this.innerHTML;
    });
    
    // Handle toolbar button clicks
    document.querySelectorAll('.rich-text-btn').forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            const command = this.dataset.command;
            
            if (command) {
                document.execCommand(command, false, null);
                editor.focus();
            }
        });
    });
    
    // Math equation button
    mathBtn.addEventListener('click', function(e) {
        e.preventDefault();
        const equation = prompt('Enter LaTeX equation (e.g., x^2 + y^2 = r^2):');
        if (equation) {
            const mathSpan = document.createElement('span');
            mathSpan.className = 'math-equation';
            mathSpan.innerHTML = `\\(${equation}\\)`;
            mathSpan.contentEditable = false;
            
            // Insert at cursor position
            const selection = window.getSelection();
            if (selection.rangeCount > 0) {
                const range = selection.getRangeAt(0);
                range.insertNode(mathSpan);
                range.collapse(false);
            } else {
                editor.appendChild(mathSpan);
            }
            
            // Update hidden input
            hiddenInput.value = editor.innerHTML;
            editor.focus();
        }
    });
    
    // Placeholder functionality
    editor.addEventListener('focus', function() {
        if (this.innerHTML === '' || this.innerHTML === this.dataset.placeholder) {
            this.innerHTML = '';
        }
    });
    
    editor.addEventListener('blur', function() {
        if (this.innerHTML === '') {
            this.innerHTML = this.dataset.placeholder;
        }
    });
    
    // Initialize placeholder if empty
    if (editor.innerHTML === '') {
        editor.innerHTML = editor.dataset.placeholder;
    }

    // Question Appearance History functionality
    let historyCounter = 0;
    
    window.addHistory = function() {
        const container = document.getElementById('historyContainer');
        const historyId = 'history_' + historyCounter++;
        
        const historyDiv = document.createElement('div');
        historyDiv.id = historyId;
        historyDiv.className = 'flex gap-3 p-3 bg-gray-50 dark:bg-gray-700 rounded-md border border-gray-200 dark:border-gray-600';
        
        historyDiv.innerHTML = `
            <div class="flex-1">
                <input type="text" name="history_exam[${historyId}]" placeholder="Exam/Test name" 
                       class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:border-primaryGreen focus:ring-primaryGreen text-sm">
            </div>
            <div class="flex-1">
                <input type="number" name="history_year[${historyId}]" placeholder="Year (e.g., 2024)" 
                       min="1900" max="2100" step="1"
                       class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:border-primaryGreen focus:ring-primaryGreen text-sm">
            </div>
            <button type="button" onclick="removeHistory('${historyId}')" 
                    class="px-2 py-1 text-red-600 hover:text-red-800 hover:bg-red-100 dark:hover:bg-red-900 rounded transition-colors duration-200">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                </svg>
            </button>
        `;
        
        container.appendChild(historyDiv);
        updateHistoryInput();
    };
    
    window.removeHistory = function(historyId) {
        const element = document.getElementById(historyId);
        if (element) {
            element.remove();
            updateHistoryInput();
        }
    };
    
    function updateHistoryInput() {
        const historyInput = document.getElementById('historyInput');
        const historyItems = document.querySelectorAll('[id^="history_"]');
        const historyData = [];
        
        historyItems.forEach(item => {
            const examInput = item.querySelector('input[name^="history_exam"]');
            const yearInput = item.querySelector('input[name^="history_year"]');
            
            if (examInput && yearInput) {
                historyData.push({
                    exam: examInput.value,
                    year: yearInput.value
                });
            }
        });
        
        historyInput.value = JSON.stringify(historyData);
    }
    
    // Question Tags functionality
    let tags = [];
    
    window.addTag = function() {
        const tagInput = document.getElementById('tagInput');
        const tagText = tagInput.value.trim();
        
        if (tagText) {
            // Split by comma and process each tag
            const tagArray = tagText.split(',').map(tag => tag.trim()).filter(tag => tag.length > 0);
            
            tagArray.forEach(tag => {
                if (tag && !tags.includes(tag)) {
                    tags.push(tag);
                }
            });
            
            displayTags();
            updateTagsInput();
            tagInput.value = '';
        }
    };
    
    window.removeTag = function(tagToRemove) {
        tags = tags.filter(tag => tag !== tagToRemove);
        displayTags();
        updateTagsInput();
    };
    
    function displayTags() {
        const container = document.getElementById('tagsContainer');
        container.innerHTML = '';
        
        tags.forEach(tag => {
            const tagElement = document.createElement('span');
            tagElement.className = 'inline-flex items-center gap-1 px-3 py-1 bg-blue-100 dark:bg-blue-900 text-blue-800 dark:text-blue-200 rounded-full text-sm';
            tagElement.innerHTML = `
                #${tag}
                <button type="button" onclick="removeTag('${tag}')" class="ml-1 text-blue-600 hover:text-blue-800">
                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            `;
            container.appendChild(tagElement);
        });
    }
    
    function updateTagsInput() {
        const tagsInput = document.getElementById('tagsInput');
        tagsInput.value = JSON.stringify(tags);
    }
    
    // Initialize tags from old input if available
    const oldTags = document.getElementById('tagsInput').value;
    if (oldTags && oldTags !== '[]') {
        try {
            tags = JSON.parse(oldTags);
            displayTags();
        } catch (e) {
            console.error('Error parsing old tags:', e);
        }
    }
    
    // Initialize history from old input if available
    const oldHistory = document.getElementById('historyInput').value;
    if (oldHistory && oldHistory !== '[]') {
        try {
            const historyData = JSON.parse(oldHistory);
            historyData.forEach(item => {
                // Recreate history items from old data
                const container = document.getElementById('historyContainer');
                const historyId = 'history_' + historyCounter++;
                
                const historyDiv = document.createElement('div');
                historyDiv.id = historyId;
                historyDiv.className = 'flex gap-3 p-3 bg-gray-50 dark:bg-gray-700 rounded-md border border-gray-200 dark:border-gray-600';
                
                historyDiv.innerHTML = `
                    <div class="flex-1">
                        <input type="text" name="history_exam[${historyId}]" placeholder="Exam/Test name" 
                               value="${item.exam || ''}"
                               class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:border-primaryGreen focus:ring-primaryGreen text-sm">
                    </div>
                    <div class="flex-1">
                        <input type="number" name="history_year[${historyId}]" placeholder="Year (e.g., 2024)" 
                               value="${item.year || ''}"
                               class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:border-primaryGreen focus:ring-primaryGreen text-sm">
                    </div>
                    <button type="button" onclick="removeHistory('${historyId}')" 
                            class="px-2 py-1 text-red-600 hover:text-red-800 hover:bg-red-100 dark:hover:bg-red-900 rounded transition-colors duration-200">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                        </svg>
                    </button>
                `;
                
                container.appendChild(historyDiv);
            });
        } catch (e) {
            console.error('Error parsing old history:', e);
        }
    }
    
    // Add event listeners for real-time updates
    document.addEventListener('input', function(e) {
        if (e.target.name && e.target.name.startsWith('history_')) {
            updateHistoryInput();
        }
    });
    
    // Add enter key support for tag input
    document.getElementById('tagInput').addEventListener('keypress', function(e) {
        if (e.key === 'Enter') {
            e.preventDefault();
            addTag();
        }
    });
    
    // Add comma support for automatic tag completion
    document.getElementById('tagInput').addEventListener('input', function(e) {
        if (e.target.value.includes(',')) {
            addTag();
        }
    });



    const courseSelect = document.getElementById('course_id');
    const subjectSelect = document.getElementById('subject_id');
    const topicSelect = document.getElementById('topic_id');

    // Course change handler
    courseSelect.addEventListener('change', function() {
        const courseId = this.value;
        if (courseId) {
            // Fetch subjects for selected course
            fetch(`/partner/questions/subjects?course_id=${courseId}`)
                .then(response => response.json())
                .then(data => {
                    subjectSelect.innerHTML = '<option value="">Select Subject</option>';
                    topicSelect.innerHTML = '<option value="">Select Topic</option>';
                    
                    data.forEach(subject => {
                        const option = document.createElement('option');
                        option.value = subject.id;
                        option.textContent = subject.name;
                        subjectSelect.appendChild(option);
                    });
                });
        } else {
            subjectSelect.innerHTML = '<option value="">Select Subject</option>';
            topicSelect.innerHTML = '<option value="">Select Topic</option>';
        }
    });

    // Subject change handler
    subjectSelect.addEventListener('change', function() {
        const subjectId = this.value;
        if (subjectId) {
            // Fetch topics for selected subject
            fetch(`/partner/questions/topics?subject_id=${subjectId}`)
                .then(response => response.json())
                .then(data => {
                    topicSelect.innerHTML = '<option value="">Select Topic</option>';
                    
                    data.forEach(topic => {
                        const option = document.createElement('option');
                        option.value = topic.id;
                        option.textContent = topic.name;
                        topicSelect.appendChild(option);
                    });
                });
        } else {
            topicSelect.innerHTML = '<option value="">Select Topic</option>';
        }
    });
});
</script>
@endsection