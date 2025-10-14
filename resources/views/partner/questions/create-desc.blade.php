@extends('layouts.partner-layout')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-slate-50 to-blue-50 py-8">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
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
                    <a href="{{ route('partner.questions.drafts') }}" 
                       class="inline-flex items-center px-4 py-2 bg-yellow-600 hover:bg-yellow-700 text-white rounded-lg text-sm font-medium transition-colors duration-200">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        View Drafts
                    </a>
                    <a href="{{ route('partner.questions.index') }}" 
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
                                    <option value="{{ $course->id }}">{{ $course->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Subject Selection -->
                        <div class="space-y-2">
                            <label for="subject_id" class="block text-sm font-medium text-gray-700">
                                Subject <span class="text-red-500">*</span>
                            </label>
                            <select name="subject_id" id="subject_id" required disabled
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 bg-gray-100">
                                <option value="">Please select a course first</option>
                            </select>
                        </div>

                        <!-- Topic Selection -->
                        <div class="space-y-2">
                            <label for="topic_id" class="block text-sm font-medium text-gray-700">
                                Topic <span class="text-gray-400">(Optional)</span>
                            </label>
                            <select name="topic_id" id="topic_id" disabled
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 bg-gray-100">
                                <option value="">Please select a subject first</option>
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
                             <label for="question_text" class="block text-sm font-medium text-gray-700 mb-2">
                                 Question Text<span class="text-red-500">*</span>
                             </label>
                             
                             <!-- CKEditor Textarea -->
                             <textarea name="question_text" id="question_text" rows="10" required
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                       placeholder="Enter your descriptive question here..."></textarea>
                             <input type="hidden" name="q_type_id" value="1">
                             
                             <div class="text-sm text-gray-500 mt-2">
                                 <span>💡 Use the ∑ (equation) button in the toolbar to add math or chemistry equations.</span>
                             </div>
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
    const form = document.getElementById('descriptiveForm');
    const resetBtn = document.getElementById('resetBtn');
    const submitBtn = document.getElementById('submitBtn');
    
    // Form validation
    form.addEventListener('submit', function(e) {
        if (!validateForm()) {
            e.preventDefault();
            return false;
        }
        
        
        // Show loading state
        const originalText = submitBtn.innerHTML;
        submitBtn.innerHTML = `
            <svg class="animate-spin -ml-1 mr-3 h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
            Creating...
        `;
        submitBtn.disabled = true;
        
        return true;
    });
    
    // Form validation function
    function validateForm() {
        const requiredFields = [
            'course_id', 'subject_id'
        ];
        
        for (const fieldName of requiredFields) {
            const field = document.querySelector(`[name="${fieldName}"]`);
            if (!field || !field.value.trim()) {
                showNotification(`Please fill in all required fields. Missing: ${fieldName.replace('_', ' ')}`, 'error');
                field?.focus();
                return false;
            }
        }

        // Validate CKEditor content
        if (window.questionEditor) {
            window.questionEditor.updateElement(); // Sync CKEditor to textarea
            const editorData = window.questionEditor.getData();
            
            if (!editorData || editorData.trim() === '') {
                showNotification('Please enter a question text.', 'error');
                window.questionEditor.focus();
                return false;
            }
        } else {
            // Fallback if CKEditor not ready
            const questionText = document.getElementById('question_text').value;
            if (!questionText || questionText.trim() === '') {
                showNotification('Please enter a question text.', 'error');
                return false;
            }
        }
        
        return true;
    }
    
    // Reset form function
    function resetForm() {
        form.reset();
        
        // Reset CKEditor
        if (window.questionEditor) {
            window.questionEditor.setData('');
        } else {
            document.getElementById('question_text').value = '';
        }
        
        // Reset dropdowns to initial state
        subjectSelect.innerHTML = '<option value="">Please select a course first</option>';
        subjectSelect.disabled = true;
        subjectSelect.className = 'w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 bg-gray-100';
        
        topicSelect.innerHTML = '<option value="">Please select a subject first</option>';
        topicSelect.disabled = true;
        topicSelect.className = 'w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 bg-gray-100';
        
        
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

<!-- Ensure Math Button is Visible -->
<style>
    /* Make sure the Math Equation button is visible */
    .cke_button__mathequation {
        display: inline-block !important;
        visibility: visible !important;
    }
    
    .cke_button__mathequation_label {
        display: inline !important;
        padding: 0 4px !important;
    }
    
    /* Note: Equation styling is global in partner-layout.blade.php */
</style>

<!-- Suppress CKEditor License Warning -->
<script>
(function() {
    const originalError = console.error;
    const originalWarn = console.warn;
    
    console.error = function() {
        const message = Array.from(arguments).join(' ');
        if (message.includes('CKEDITOR') && message.includes('license')) {
            return; // Suppress license warnings
        }
        originalError.apply(console, arguments);
    };
    
    console.warn = function() {
        const message = Array.from(arguments).join(' ');
        if (message.includes('CKEDITOR') && message.includes('license')) {
            return; // Suppress license warnings
        }
        originalWarn.apply(console, arguments);
    };
})();
</script>

<!-- Load CKEditor 4 -->
<script src="{{ asset('ckeditor/ckeditor.js') }}"></script>

<!-- Load MathLive from CDN (for visual equation editor) -->
<link rel="stylesheet" href="https://unpkg.com/mathlive/dist/mathlive-static.css">
<script src="https://unpkg.com/mathlive"></script>

<!-- Note: MathJax is loaded globally in partner-layout.blade.php -->

<!-- Define CKEditor Math Equation Plugin -->
<script>
(function() {
    if (typeof CKEDITOR !== 'undefined') {
        console.log('Registering mathequation plugin...');
        
        CKEDITOR.plugins.add('mathequation', {
            init: function(editor) {
                console.log('mathequation plugin init() called for:', editor.name);
                
                editor.addCommand('insertMathEquation', {
                    exec: function(editor) {
                        console.log('Math equation button clicked!');
                        if (typeof window.openMathEditor === 'function') {
                            window.openMathEditor();
                        } else {
                            alert('Math editor is loading. Please wait a moment and try again.');
                        }
                    }
                });
                
                editor.ui.addButton('MathEquation', {
                    label: 'Math/Chemistry Equation (∑)',
                    command: 'insertMathEquation',
                    toolbar: 'insert',
                    icon: false // Use text instead of icon
                });
                
                console.log('✓ MathEquation button registered');
            }
        });
        
        console.log('✓ mathequation plugin added to CKEDITOR.plugins');
    } else {
        console.error('CKEDITOR not available when trying to register mathequation plugin!');
    }
})();
</script>

<!-- Initialize CKEditor -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    console.log('Initializing CKEditor...');
    
    // Destroy existing instance if any
    if (CKEDITOR.instances['question_text']) {
        CKEDITOR.instances['question_text'].destroy(true);
    }
    
    // Initialize CKEditor
    const questionEditor = CKEDITOR.replace('question_text', {
        height: 200,
        versionCheck: false, // Suppress license warnings
        extraPlugins: 'mathequation',
        removePlugins: 'elementspath',
        allowedContent: true,
        toolbarCanCollapse: false,
        // Explicit toolbar with Math button
        toolbar: [
            { name: 'document', items: [ 'Source', '-', 'Save', 'NewPage', 'Preview', 'Print', '-', 'Templates' ] },
            { name: 'clipboard', items: [ 'Cut', 'Copy', 'Paste', 'PasteText', 'PasteFromWord', '-', 'Undo', 'Redo' ] },
            { name: 'editing', items: [ 'Find', 'Replace', '-', 'SelectAll', '-', 'Scayt' ] },
            '/',
            { name: 'basicstyles', items: [ 'Bold', 'Italic', 'Underline', 'Strike', 'Subscript', 'Superscript', '-', 'CopyFormatting', 'RemoveFormat' ] },
            { name: 'paragraph', items: [ 'NumberedList', 'BulletedList', '-', 'Outdent', 'Indent', '-', 'Blockquote', 'CreateDiv', '-', 'JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock', '-', 'BidiLtr', 'BidiRtl' ] },
            { name: 'links', items: [ 'Link', 'Unlink', 'Anchor' ] },
            { name: 'insert', items: [ 'Image', 'Table', 'HorizontalRule', 'SpecialChar', 'MathEquation' ] }, // Math button here!
            '/',
            { name: 'styles', items: [ 'Styles', 'Format', 'Font', 'FontSize' ] },
            { name: 'colors', items: [ 'TextColor', 'BGColor' ] },
            { name: 'tools', items: [ 'Maximize', 'ShowBlocks' ] }
        ]
    });
    
    questionEditor.on('instanceReady', function() {
        console.log('✓ CKEditor ready!');
        console.log('✓ Loaded plugins:', Object.keys(questionEditor.plugins));
        console.log('✓ Has mathequation plugin?', questionEditor.plugins.mathequation !== undefined);
        console.log('✓ Toolbar items:', questionEditor.ui.items);
        console.log('✓ Has MathEquation button?', questionEditor.ui.items.MathEquation !== undefined);
        
        // Render any existing LaTeX equations
        if (typeof MathJax !== 'undefined') {
            MathJax.typesetPromise([questionEditor.container.$]).catch((err) => console.log('MathJax error:', err));
        }
    });
    
    // Re-render equations when content changes
    questionEditor.on('change', function() {
        if (typeof MathJax !== 'undefined') {
            setTimeout(() => {
                MathJax.typesetPromise([questionEditor.container.$]).catch((err) => console.log('MathJax error:', err));
            }, 100);
        }
    });
    
    // Update form validation
    const form = document.getElementById('descriptive-question-form');
    if (form) {
        form.addEventListener('submit', function(e) {
            questionEditor.updateElement();
        });
    }
    
    // Store globally for access
    window.questionEditor = questionEditor;
});
</script>

<!-- Initialize MathLive -->
<script>
window.addEventListener('load', function() {
    const mathFieldElement = document.getElementById('mathfield');
    const mathPreview = document.getElementById('mathPreview');
    const latexCodeField = document.getElementById('latexCode');
    const modal = document.getElementById('mathEditorModal');
    
    // Tab switching
    document.getElementById('mathTab').addEventListener('click', function() {
        document.getElementById('mathButtons').classList.remove('hidden');
        document.getElementById('chemButtons').classList.add('hidden');
        this.classList.add('border-b-2', 'border-blue-500', 'text-blue-600');
        this.classList.remove('text-gray-600');
        document.getElementById('chemTab').classList.remove('border-b-2', 'border-blue-500', 'text-blue-600');
        document.getElementById('chemTab').classList.add('text-gray-600');
    });
    
    document.getElementById('chemTab').addEventListener('click', function() {
        document.getElementById('mathButtons').classList.add('hidden');
        document.getElementById('chemButtons').classList.remove('hidden');
        this.classList.add('border-b-2', 'border-blue-500', 'text-blue-600');
        this.classList.remove('text-gray-600');
        document.getElementById('mathTab').classList.remove('border-b-2', 'border-blue-500', 'text-blue-600');
        document.getElementById('mathTab').classList.add('text-gray-600');
    });
    
    // Quick insert buttons
    document.querySelectorAll('.math-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            const latex = this.getAttribute('data-latex');
            mathFieldElement.executeCommand(['insert', latex]);
            mathFieldElement.focus();
        });
    });
    
    // Sync MathField with LaTeX code
    mathFieldElement.addEventListener('input', function() {
        const latex = this.value;
        latexCodeField.value = latex;
        // Render with MathJax
        mathPreview.innerHTML = `$$${latex}$$`;
        if (typeof MathJax !== 'undefined') {
            MathJax.typesetPromise([mathPreview]).catch((err) => console.log('MathJax preview error:', err));
        }
    });
    
    // Sync LaTeX code with MathField
    latexCodeField.addEventListener('input', function() {
        mathFieldElement.value = this.value;
        // Render with MathJax
        mathPreview.innerHTML = `$$${this.value}$$`;
        if (typeof MathJax !== 'undefined') {
            MathJax.typesetPromise([mathPreview]).catch((err) => console.log('MathJax preview error:', err));
        }
    });
    
    // Initial preview render
    setTimeout(() => {
        const initialLatex = mathFieldElement.value;
        mathPreview.innerHTML = `$$${initialLatex}$$`;
        if (typeof MathJax !== 'undefined') {
            MathJax.typesetPromise([mathPreview]).catch((err) => console.log('MathJax preview error:', err));
        }
    }, 500);
    
    // Open modal function
    window.openMathEditor = function() {
        modal.classList.remove('hidden');
        mathFieldElement.focus();
    };
    
    // Close modal
    document.getElementById('closeMathModal').addEventListener('click', function() {
        modal.classList.add('hidden');
    });
    
    document.getElementById('cancelMathModal').addEventListener('click', function() {
        modal.classList.add('hidden');
    });
    
    // Insert equation
    document.getElementById('insertEquation').addEventListener('click', function() {
        const latex = mathFieldElement.value;
        if (window.questionEditor && latex) {
            // Insert LaTeX wrapped in $$ for display or $ for inline
            window.questionEditor.insertHtml('$$ ' + latex + ' $$');
            modal.classList.add('hidden');
            mathFieldElement.value = 'x=\\frac{-b\\pm\\sqrt{b^2-4ac}}{2a}';
        }
    });
    
    console.log('✓ MathLive initialized');
});
</script>

<!-- Note: Global MathJax rendering helpers are in partner-layout.blade.php -->

<!-- MathLive Equation Editor Modal -->
<div id="mathEditorModal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50 flex items-center justify-center">
    <div class="bg-white rounded-lg shadow-xl max-w-4xl w-full m-4 max-h-[90vh] overflow-y-auto">
        <div class="p-6">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-xl font-bold text-gray-900">Math & Chemistry Equation Editor</h3>
                <button type="button" id="closeMathModal" class="text-gray-400 hover:text-gray-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>

            <!-- Tabs -->
            <div class="flex border-b mb-4">
                <button type="button" id="mathTab" class="px-4 py-2 font-medium border-b-2 border-blue-500 text-blue-600">
                    Mathematics
                </button>
                <button type="button" id="chemTab" class="px-4 py-2 font-medium text-gray-600 hover:text-gray-900">
                    Chemistry
                </button>
            </div>

            <!-- Math Field (Visual Editor) -->
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-2">Enter Equation:</label>
                <math-field id="mathfield" class="w-full p-4 border border-gray-300 rounded-lg text-2xl" style="font-size: 24px;">
                    x=\frac{-b\pm\sqrt{b^2-4ac}}{2a}
                </math-field>
            </div>

            <!-- Quick Insert Buttons -->
            <div id="mathButtons" class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-2">Quick Insert:</label>
                <div class="grid grid-cols-4 gap-2">
                    <button type="button" class="math-btn p-2 border rounded hover:bg-gray-100" data-latex="\frac{}{}">Fraction</button>
                    <button type="button" class="math-btn p-2 border rounded hover:bg-gray-100" data-latex="\sqrt{}">Square Root</button>
                    <button type="button" class="math-btn p-2 border rounded hover:bg-gray-100" data-latex="^{}">Superscript</button>
                    <button type="button" class="math-btn p-2 border rounded hover:bg-gray-100" data-latex="_{}">Subscript</button>
                    <button type="button" class="math-btn p-2 border rounded hover:bg-gray-100" data-latex="\sum">Summation (∑)</button>
                    <button type="button" class="math-btn p-2 border rounded hover:bg-gray-100" data-latex="\int">Integral (∫)</button>
                    <button type="button" class="math-btn p-2 border rounded hover:bg-gray-100" data-latex="\pi">Pi (π)</button>
                    <button type="button" class="math-btn p-2 border rounded hover:bg-gray-100" data-latex="\theta">Theta (θ)</button>
                    <button type="button" class="math-btn p-2 border rounded hover:bg-gray-100" data-latex="\alpha">Alpha (α)</button>
                    <button type="button" class="math-btn p-2 border rounded hover:bg-gray-100" data-latex="\beta">Beta (β)</button>
                    <button type="button" class="math-btn p-2 border rounded hover:bg-gray-100" data-latex="\lim">Limit</button>
                    <button type="button" class="math-btn p-2 border rounded hover:bg-gray-100" data-latex="\infty">Infinity (∞)</button>
                </div>
            </div>

            <div id="chemButtons" class="mb-4 hidden">
                <label class="block text-sm font-medium text-gray-700 mb-2">Quick Insert (Chemistry):</label>
                <div class="grid grid-cols-4 gap-2">
                    <button type="button" class="math-btn p-2 border rounded hover:bg-gray-100" data-latex="\ce{H2O}">H₂O</button>
                    <button type="button" class="math-btn p-2 border rounded hover:bg-gray-100" data-latex="\ce{CO2}">CO₂</button>
                    <button type="button" class="math-btn p-2 border rounded hover:bg-gray-100" data-latex="\ce{H2SO4}">H₂SO₄</button>
                    <button type="button" class="math-btn p-2 border rounded hover:bg-gray-100" data-latex="\ce{->}">Arrow (→)</button>
                    <button type="button" class="math-btn p-2 border rounded hover:bg-gray-100" data-latex="\ce{<->}">Equilibrium (⇌)</button>
                    <button type="button" class="math-btn p-2 border rounded hover:bg-gray-100" data-latex="^{}">Superscript</button>
                    <button type="button" class="math-btn p-2 border rounded hover:bg-gray-100" data-latex="_{}">Subscript</button>
                    <button type="button" class="math-btn p-2 border rounded hover:bg-gray-100" data-latex="+">Plus (+)</button>
                </div>
            </div>

            <!-- LaTeX Code -->
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-2">LaTeX Code:</label>
                <textarea id="latexCode" class="w-full p-3 border border-gray-300 rounded-lg font-mono text-sm" rows="3"></textarea>
            </div>

            <!-- Preview -->
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-2">Preview:</label>
                <div id="mathPreview" class="w-full p-4 border border-gray-300 rounded-lg bg-gray-50 min-h-[60px] text-center text-2xl"></div>
            </div>

            <!-- Actions -->
            <div class="flex justify-end gap-2">
                <button type="button" id="cancelMathModal" class="px-4 py-2 border border-gray-300 rounded-lg hover:bg-gray-50">
                    Cancel
                </button>
                <button type="button" id="insertEquation" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                    Insert Equation
                </button>
            </div>
        </div>
    </div>
</div>

@endsection
