@extends('layouts.partner-layout')

@section('title', 'Create New Student User')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-slate-50 via-blue-50 to-indigo-50 py-8">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Header Section -->
        <div class="mb-8">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-4">
                    <a href="{{ route('partner.settings.index') }}" 
                       class="group inline-flex items-center px-4 py-2 text-sm font-medium text-gray-600 hover:text-gray-900 bg-white hover:bg-gray-50 border border-gray-300 hover:border-gray-400 rounded-lg shadow-sm transition-all duration-200">
                        <svg class="w-4 h-4 mr-2 transition-transform group-hover:-translate-x-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                        Back to Settings
                    </a>
                </div>
                <div class="text-right">
                    <h1 class="text-2xl font-bold text-gray-900">Create New Student User</h1>
                    <p class="text-sm text-gray-600 mt-1">Add a new student user to your organization</p>
                </div>
            </div>
        </div>

        <!-- Error Messages -->
        @if ($errors->any())
            <div class="mb-6 bg-red-50 border border-red-200 rounded-lg p-4">
                <div class="flex items-center">
                    <svg class="w-5 h-5 text-red-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <h3 class="text-sm font-medium text-red-800">Please fix the following errors:</h3>
                </div>
                <ul class="mt-2 text-sm text-red-700 list-disc pl-5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Main Form Card -->
        <div class="bg-white rounded-xl shadow-lg border border-gray-200 overflow-hidden">
            <form id="createUserForm" action="{{ route('partner.settings.users.store') }}" method="POST" class="divide-y divide-gray-200">
                @csrf
                
                <!-- Hidden field for role ID (student role hardcoded) -->
                <input type="hidden" name="role_id" value="3">
                <input type="hidden" name="user_type" value="student">
                
                <!-- Step 1: Select Student -->
                <div class="p-6 sm:p-8">
                    <div class="flex items-center mb-6">
                        <div class="flex-shrink-0">
                            <div class="w-10 h-10 bg-gradient-to-r from-blue-500 to-indigo-600 rounded-full flex items-center justify-center">
                                <span class="text-white font-semibold text-lg">1</span>
                            </div>
                        </div>
                        <div class="ml-4">
                            <h2 class="text-lg font-semibold text-gray-900">Select Student</h2>
                            <p class="text-sm text-gray-600">Choose the student to create an account for</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 gap-6">
                        <!-- Student Selection -->
                        <div>
                            <label for="student_id" class="block text-sm font-medium text-gray-700 mb-2">
                                Select Student <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <select name="student_id" id="student_id" required
                                        class="block w-full px-4 py-3 pr-10 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200 bg-white">
                                    <option value="">Select a student</option>
                                    @foreach($students as $student)
                                        <option value="{{ $student->id }}" 
                                                data-name="{{ $student->full_name }}"
                                                data-email="{{ $student->email ?? 'N/A' }}"
                                                data-phone="{{ $student->phone ?? 'N/A' }}">
                                            {{ $student->full_name }} ({{ $student->student_id ?? 'No ID' }})
                                        </option>
                                    @endforeach
                                </select>
                                <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Step 2: Account Information -->
                <div class="p-6 sm:p-8">
                    <div class="flex items-center mb-6">
                        <div class="flex-shrink-0">
                            <div class="w-10 h-10 bg-gradient-to-r from-purple-500 to-pink-600 rounded-full flex items-center justify-center">
                                <span class="text-white font-semibold text-lg">2</span>
                            </div>
                        </div>
                        <div class="ml-4">
                            <h2 class="text-lg font-semibold text-gray-900">Account Information</h2>
                            <p class="text-sm text-gray-600">Set up login credentials for the student</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Display Name -->
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Student Name
                            </label>
                            <div id="display_name" class="block w-full px-3 py-2 bg-gray-50 border border-gray-300 rounded-lg shadow-sm text-gray-700">
                                Select a student above
                            </div>
                        </div>

                        <!-- Email -->
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Email Address
                            </label>
                            <div id="display_email" class="block w-full px-3 py-2 bg-gray-50 border border-gray-300 rounded-lg shadow-sm text-gray-700">
                                Select a student above
                            </div>
                        </div>

                        <!-- Phone -->
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Phone Number
                            </label>
                            <div id="display_phone" class="block w-full px-3 py-2 bg-gray-50 border border-gray-300 rounded-lg shadow-sm text-gray-700">
                                Select a student above
                            </div>
                        </div>

                        <!-- Password, Confirm Password - 2 Column Grid -->
                        <div class="md:col-span-2">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <!-- Password -->
                                <div>
                                    <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                                        Password <span class="text-red-500">*</span>
                                    </label>
                                    <input type="password" name="password" id="password" required
                                           class="block w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200"
                                           placeholder="Enter password">
                                </div>
                                
                                <!-- Confirm Password -->
                                <div>
                                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">
                                        Confirm Password <span class="text-red-500">*</span>
                                    </label>
                                    <input type="password" name="password_confirmation" id="password_confirmation" required
                                           class="block w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200"
                                           placeholder="Confirm password">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="px-6 py-4 sm:px-8 bg-gray-50 flex items-center justify-between">
                    <div class="text-sm text-gray-500">
                        <span class="text-red-500">*</span> Required fields
                    </div>
                    <div class="flex items-center space-x-3">
                        <button type="button" id="resetBtn"
                                class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition-colors duration-200">
                            Reset
                        </button>
                        <button type="submit" id="submitBtn"
                                class="px-6 py-2 text-sm font-medium text-white bg-gradient-to-r from-blue-600 to-indigo-600 rounded-lg hover:from-blue-700 hover:to-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all duration-200 transform hover:scale-105">
                            <span id="submitText">Create User</span>
                            <svg id="submitIcon" class="w-4 h-4 ml-2 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                            </svg>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Loading Overlay -->
<div id="loadingOverlay" class="fixed inset-0 bg-gray-900 bg-opacity-50 flex items-center justify-center z-50 hidden">
    <div class="bg-white rounded-lg p-6 flex items-center space-x-3">
        <svg class="animate-spin h-5 w-5 text-blue-600" fill="none" viewBox="0 0 24 24">
            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
        </svg>
        <span class="text-gray-900 font-medium">Creating user...</span>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    console.log('🚀 Script loaded and DOM ready!');
    
    const form = document.getElementById('createUserForm');
    const studentSelect = document.getElementById('student_id');
    const submitBtn = document.getElementById('submitBtn');
    const submitText = document.getElementById('submitText');
    const submitIcon = document.getElementById('submitIcon');
    const loadingOverlay = document.getElementById('loadingOverlay');
    const resetBtn = document.getElementById('resetBtn');
    
    // Display elements
    const displayName = document.getElementById('display_name');
    const displayEmail = document.getElementById('display_email');
    const displayPhone = document.getElementById('display_phone');

    // Handle student selection changes
    function handleStudentChange() {
        console.log('=== handleStudentChange called ===');
        const selectedOption = studentSelect.options[studentSelect.selectedIndex];
        console.log('Selected option:', selectedOption);
        console.log('Selected value:', selectedOption.value);
        
        if (selectedOption.value && selectedOption.value !== '') {
            const name = selectedOption.getAttribute('data-name');
            const email = selectedOption.getAttribute('data-email');
            const phone = selectedOption.getAttribute('data-phone');
            
            console.log('Student data:', { name, email, phone });
            
            // Populate display fields
            displayName.textContent = name || 'N/A';
            displayEmail.textContent = email || 'N/A';
            displayPhone.textContent = phone || 'N/A';
        } else {
            // Clear fields if no student selected
            displayName.textContent = 'Select a student above';
            displayEmail.textContent = 'Select a student above';
            displayPhone.textContent = 'Select a student above';
            console.log('No student selected, fields cleared');
        }
    }
    
    studentSelect.addEventListener('change', function() {
        console.log('Student changed to:', studentSelect.value);
        handleStudentChange();
    });
    
    // Initialize on page load if there's a selected value
    if (studentSelect.value) {
        console.log('Initial student value:', studentSelect.value);
        handleStudentChange();
    }
    
    // Form submission
    form.addEventListener('submit', function(e) {
        e.preventDefault();
        
        console.log('Form submit triggered');
        
        // Ensure a student is selected
        if (!studentSelect.value) {
            alert('Please select a student');
            studentSelect.focus();
            return false;
        }
        
        // Debug: Log form data before submission
        const formData = new FormData(form);
        console.log('Form data being submitted:');
        for (let [key, value] of formData.entries()) {
            console.log(key + ': ' + value);
        }
        
        // Show loading state
        submitBtn.disabled = true;
        submitText.textContent = 'Creating...';
        submitIcon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>';
        loadingOverlay.classList.remove('hidden');

        // Submit form via AJAX (reuse the formData from above)
        
        fetch(form.action, {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => {
            // If response is not JSON, handle as error
            if (!response.headers.get('content-type') || !response.headers.get('content-type').includes('application/json')) {
                throw new Error('Server returned an invalid response');
            }
            return response.json();
        })
        .then(data => {
            if (data.success) {
                showNotification('User created successfully!', 'success');
                setTimeout(() => {
                    window.location.href = data.redirect || '{{ route("partner.settings.index") }}';
                }, 1500);
            } else {
                // Handle validation errors
                if (data.errors) {
                    let errorMessages = [];
                    for (let field in data.errors) {
                        errorMessages = errorMessages.concat(data.errors[field]);
                    }
                    showNotification(errorMessages.join('\n'), 'error');
                } else {
                    showNotification(data.message || 'Failed to create user', 'error');
                }
                
                // Reset button state
                submitBtn.disabled = false;
                submitText.textContent = 'Create User';
                submitIcon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>';
                loadingOverlay.classList.add('hidden');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showNotification('An unexpected error occurred while creating the user. Please try again.', 'error');
            
            // Reset button state
            submitBtn.disabled = false;
            submitText.textContent = 'Create User';
            submitIcon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>';
            loadingOverlay.classList.add('hidden');
        });
    });

    // Reset form
    resetBtn.addEventListener('click', function() {
        if (confirm('Are you sure you want to reset the form? All entered data will be lost.')) {
            form.reset();
            handleStudentChange(); // Reset the display fields
        }
    });

    // Notification function
    function showNotification(message, type = 'info') {
        const notification = document.createElement('div');
        const bgColor = type === 'success' ? 'bg-green-500' : type === 'error' ? 'bg-red-500' : 'bg-blue-500';
        const icon = type === 'success' ? '✓' : type === 'error' ? '✗' : 'ℹ';
        
        notification.className = `fixed top-4 right-4 ${bgColor} text-white px-6 py-4 rounded-lg shadow-lg z-50 flex items-center space-x-3 transform transition-all duration-300 translate-x-full`;
        notification.innerHTML = `
            <span class="text-lg">${icon}</span>
            <span>${message}</span>
            <button onclick="this.parentElement.remove()" class="ml-auto text-white hover:text-gray-200">✗</button>
        `;
        
        document.body.appendChild(notification);
        
        // Animate in
        setTimeout(() => notification.classList.remove('translate-x-full'), 100);
        
        // Auto remove after 5 seconds
        setTimeout(() => {
            notification.classList.add('translate-x-full');
            setTimeout(() => notification.remove(), 300);
        }, 5000);
    }
});
</script>
@endsection