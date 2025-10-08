@extends('layouts.partner-layout')

@section('title', 'Typing Speed Test')

@section('content')
<div class="py-12">
    <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="text-center mb-8">
            <h1 class="text-4xl font-bold text-gray-900 mb-4">Typing Speed Test</h1>
            <p class="text-xl text-gray-600">Test your typing speed and accuracy</p>
        </div>

        <!-- Test Configuration -->
        <div class="bg-white rounded-2xl shadow-lg p-8 border border-gray-100 mb-8">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-2xl font-bold text-gray-900">Test Settings</h2>
                <button id="settingsBtn" class="p-2 text-gray-600 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition-colors" title="Manage Typing Passages">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    </svg>
                </button>
            </div>
            
            <div class="text-center">
                <p class="text-gray-600">Click the settings gear to manage typing passages</p>
            </div>
        </div>
    </div>
</div>

<!-- Passage Management Modal -->
<div id="passageModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
    <div class="relative top-20 mx-auto p-5 border w-11/12 md:w-4/5 lg:w-3/5 shadow-lg rounded-md bg-white">
        <div class="mt-3">
            <!-- Modal Header -->
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-2xl font-bold text-gray-900">Manage Typing Passages</h3>
                <button id="closeModalBtn" class="text-gray-400 hover:text-gray-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>

            <!-- Add New Passage Form -->
            <div class="bg-gray-50 rounded-lg p-6 mb-6">
                <h4 class="text-lg font-semibold text-gray-800 mb-4">Add New Passage</h4>
                <form id="passageForm" class="space-y-4">
                    <div class="grid md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Title</label>
                            <input type="text" id="passageTitle" name="title" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" required>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Category</label>
                            <select id="passageCategory" name="category" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" required>
                                <option value="">Select Category</option>
                                <option value="general">General</option>
                                <option value="technical">Technical</option>
                                <option value="literature">Literature</option>
                                <option value="news">News</option>
                                <option value="academic">Academic</option>
                                <option value="business">Business</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="grid md:grid-cols-3 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Language</label>
                            <select id="passageLanguage" name="language" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" required>
                                <option value="">Select Language</option>
                                <option value="english">English</option>
                                <option value="bangla">বাংলা</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Difficulty</label>
                            <select id="passageDifficulty" name="difficulty" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" required>
                                <option value="">Select Difficulty</option>
                                <option value="easy">Easy</option>
                                <option value="medium">Medium</option>
                                <option value="hard">Hard</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Author (Optional)</label>
                            <input type="text" id="passageAuthor" name="author" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        </div>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Passage Text</label>
                        <textarea id="passageText" name="passage_text" rows="6" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 resize-none" placeholder="Enter the text for the typing passage..." required></textarea>
                        <div class="flex justify-between text-sm text-gray-500 mt-2">
                            <span id="wordCount">Words: 0</span>
                            <span id="charCount">Characters: 0</span>
                        </div>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Description (Optional)</label>
                        <textarea id="passageDescription" name="description" rows="3" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 resize-none" placeholder="Add notes or description about this passage..."></textarea>
                    </div>
                    
                    <div class="flex justify-end space-x-3">
                        <button type="button" id="cancelBtn" class="px-4 py-2 text-gray-600 bg-gray-200 rounded-lg hover:bg-gray-300 transition-colors">
                            Cancel
                        </button>
                        <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                            Add Passage
                        </button>
                    </div>
                </form>
            </div>

            <!-- Existing Passages Table -->
            <div class="bg-white rounded-lg border border-gray-200">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h4 class="text-lg font-semibold text-gray-800">Existing Passages</h4>
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Title</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Language</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Difficulty</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Category</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Words</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Usage</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody id="passagesTableBody" class="bg-white divide-y divide-gray-200">
                            <!-- Passages will be loaded here dynamically -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    console.log('DOM loaded, initializing typing test...'); // Debug log
    
    // Passage Management Modal Functionality
    const passageModal = document.getElementById('passageModal');
    const settingsBtn = document.getElementById('settingsBtn');
    const closeModalBtn = document.getElementById('closeModalBtn');
    const cancelBtn = document.getElementById('cancelBtn');
    const passageForm = document.getElementById('passageForm');
    const passageText = document.getElementById('passageText');
    const wordCount = document.getElementById('wordCount');
    const charCount = document.getElementById('charCount');
    const passagesTableBody = document.getElementById('passagesTableBody');
    
    console.log('Elements found:', { // Debug log
        passageModal: !!passageModal,
        settingsBtn: !!settingsBtn,
        closeModalBtn: !!closeModalBtn,
        cancelBtn: !!cancelBtn,
        passageForm: !!passageForm,
        passageText: !!passageText,
        wordCount: !!wordCount,
        passagesTableBody: !!passagesTableBody
    });

    // Show modal
    settingsBtn.addEventListener('click', function() {
        console.log('Settings button clicked!'); // Debug log
        console.log('Modal element:', passageModal); // Debug log
        console.log('Modal classes before:', passageModal.classList.toString()); // Debug log
        passageModal.classList.remove('hidden');
        console.log('Modal classes after:', passageModal.classList.toString()); // Debug log
        loadPassages();
    });

    // Hide modal
    function hideModal() {
        passageModal.classList.add('hidden');
        passageForm.reset();
        wordCount.textContent = 'Words: 0';
        charCount.textContent = 'Characters: 0';
    }

    closeModalBtn.addEventListener('click', hideModal);
    cancelBtn.addEventListener('click', hideModal);

    // Close modal when clicking outside
    passageModal.addEventListener('click', function(e) {
        if (e.target === passageModal) {
            hideModal();
        }
    });

    // Word and character count
    passageText.addEventListener('input', function() {
        const text = this.value;
        const words = text.trim() ? text.trim().split(/\s+/).length : 0;
        const chars = text.length;
        
        wordCount.textContent = `Words: ${words}`;
        charCount.textContent = `Characters: ${chars}`;
    });

    // Handle form submission
    passageForm.addEventListener('submit', function(e) {
        e.preventDefault();
        console.log('Form submitted!'); // Debug log
        
        const formData = new FormData(this);
        const passageData = {
            title: formData.get('title'),
            category: formData.get('category'),
            language: formData.get('language'),
            difficulty: formData.get('difficulty'),
            author: formData.get('author'),
            passage_text: formData.get('passage_text'),
            description: formData.get('description')
        };

        console.log('Passage data:', passageData); // Debug log
        console.log('CSRF Token:', document.querySelector('meta[name="csrf-token"]').getAttribute('content')); // Debug log

        // Send data to backend
        fetch('/typing-passages', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify(passageData)
        })
        .then(response => {
            console.log('Response status:', response.status); // Debug log
            console.log('Response headers:', response.headers); // Debug log
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            return response.json();
        })
        .then(data => {
            console.log('Response data:', data); // Debug log
            if (data.success) {
                alert('Passage added successfully!');
                hideModal();
                loadPassages();
            } else {
                alert('Error: ' + Object.values(data.errors).flat().join(', '));
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('An error occurred while adding the passage: ' + error.message);
        });
    });

        // Load passages from backend
    function loadPassages() {
        console.log('Loading passages...'); // Debug log
        fetch('/typing-passages')
        .then(response => {
            console.log('Load passages response status:', response.status); // Debug log
            console.log('Load passages response headers:', response.headers); // Debug log
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            return response.json();
        })
        .then(data => {
            console.log('Load passages data:', data); // Debug log
            if (data.data && data.data.length > 0) {
                displayPassages(data.data);
            } else {
                passagesTableBody.innerHTML = `
                    <tr>
                        <td colspan="7" class="px-6 py-4 text-center text-gray-500">
                            No passages found. Add your first passage above!
                        </td>
                    </tr>
                `;
            }
        })
        .catch(error => {
            console.error('Error loading passages:', error);
            passagesTableBody.innerHTML = `
                <tr>
                    <td colspan="7" class="px-6 py-4 text-center text-red-500">
                        Error loading passages: ${error.message}
                </td>
            </tr>
            `;
        });
    }

    // Display passages in table
    function displayPassages(passages) {
        passagesTableBody.innerHTML = passages.map(passage => `
            <tr class="hover:bg-gray-50">
                <td class="px-6 py-4 whitespace-nowrap">
                    <div class="text-sm font-medium text-gray-900">${passage.title}</div>
                    ${passage.author ? `<div class="text-sm text-gray-500">by ${passage.author}</div>` : ''}
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                    <span class="text-sm text-gray-900">${passage.language_flag} ${passage.language}</span>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                    <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full ${passage.difficulty_color}">
                        ${passage.difficulty}
                    </span>
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                    ${passage.category}
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                    ${passage.formatted_word_count}
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                    ${passage.usage_count}
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                    <button onclick="editPassage(${passage.id})" class="text-blue-600 hover:text-blue-900 mr-3">Edit</button>
                    <button onclick="deletePassage(${passage.id})" class="text-red-600 hover:text-red-900">Delete</button>
                </td>
            </tr>
        `).join('');
    }

    // Initialize passage management
    loadPassages();
});

// Global functions for passage management
function editPassage(passageId) {
    alert('Edit functionality coming soon!');
}

function deletePassage(passageId) {
    if (confirm('Are you sure you want to delete this passage?')) {
        fetch(`/typing-passages/${passageId}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('Passage deleted successfully!');
                loadPassages();
            } else {
                alert('Error deleting passage.');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('An error occurred while deleting the passage.');
        });
    }
}
</script>
@endsection
