@extends('layouts.partner-layout')

@section('title', 'Create New User')

@section('content')
<div class="min-h-screen bg-gray-50 dark:bg-gray-900">
    <!-- Navigation Header -->
    <div class="bg-white dark:bg-gray-800 shadow-sm border-b border-gray-200 dark:border-gray-700">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16">
                <!-- Back Navigation -->
                <div class="flex items-center space-x-4">
                    <a href="{{ route('partner.settings.user-management') }}"
                       class="inline-flex items-center px-3 py-2 text-sm font-medium text-gray-700 bg-gray-100 hover:bg-gray-200 dark:bg-gray-700 dark:text-gray-300 dark:hover:bg-gray-600 rounded-lg transition duration-200">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                        </svg>
                        Back to Users
                    </a>
                </div>

                <!-- Page Title -->
                <div class="flex items-center space-x-3">
                    <div class="w-8 h-8 bg-indigo-100 dark:bg-indigo-900/50 rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 text-indigo-600 dark:text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path>
                        </svg>
                    </div>
                    <h1 class="text-lg font-semibold text-gray-900 dark:text-white">Create New User</h1>
                </div>

                <!-- Spacer for balance -->
                <div class="w-24"></div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-6 sm:py-8">
        <!-- Create User Form -->
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
            <form action="{{ route('partner.settings.users.store') }}" method="POST" class="divide-y divide-gray-200 dark:divide-gray-700" id="create-user-form">
                @csrf

                <!-- User Role Selection -->
                <div class="px-6 py-6 sm:px-8">
                    <div class="space-y-6">
                        <div>
                            <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">User Role Selection</h2>
                            <p class="text-sm text-gray-600 dark:text-gray-400 mb-4">Select the role to determine what type of user you're creating and show relevant options.</p>

                            <label for="user_type" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Select Role</label>
                            <select name="user_type" id="user_type" required
                                    class="block w-full px-3 py-2.5 text-sm border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-white transition duration-200">
                                <option value="">Select a role...</option>
                                @foreach($roles as $role)
                                    <option value="{{ $role->name }}">{{ $role->display_name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                <!-- Teacher Selection Section -->
                <div id="teacher_selection" class="px-6 py-6 sm:px-8" style="display: none;">
                    <div class="space-y-4">
                        <div>
                            <h3 class="text-md font-medium text-gray-900 dark:text-white mb-2">Select Teacher</h3>
                            <p class="text-sm text-gray-600 dark:text-gray-400 mb-4">Choose an existing teacher account to link this user to.</p>

                            <label for="teacher_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Available Teachers</label>
                            <select name="teacher_id" id="teacher_id"
                                    class="block w-full px-3 py-2.5 text-sm border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-white transition duration-200">
                                <option value="">Select a teacher...</option>
                                @foreach($teachers as $teacher)
                                    <option value="{{ $teacher->id }}">{{ $teacher->full_name }} ({{ $teacher->email }})</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                <!-- Student Selection Section -->
                <div id="student_selection" class="px-6 py-6 sm:px-8" style="display: none;">
                    <div class="space-y-4">
                        <div>
                            <h3 class="text-md font-medium text-gray-900 dark:text-white mb-2">Select Student</h3>
                            <p class="text-sm text-gray-600 dark:text-gray-400 mb-4">Choose an existing student account to link this user to.</p>

                            <label for="student_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Available Students</label>
                            <select name="student_id" id="student_id"
                                    class="block w-full px-3 py-2.5 text-sm border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-white transition duration-200">
                                <option value="">Select a student...</option>
                                @foreach($students as $student)
                                    <option value="{{ $student->id }}">{{ $student->full_name }} ({{ $student->student_id }})</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                <!-- User Information Section -->
                <div id="user_info_section" class="px-6 py-6 sm:px-8">
                    <div class="space-y-6">
                        <div>
                            <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">User Information</h2>

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 sm:gap-6">
                                <!-- Full Name -->
                                <div id="name_field" class="sm:col-span-2">
                                    <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Full Name</label>
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                            </svg>
                                        </div>
                                        <input type="text" name="name" id="name" required
                                               class="block w-full pl-10 pr-3 py-2.5 text-sm border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-white transition duration-200">
                                    </div>
                                </div>

                                <!-- Email -->
                                <div id="email_field">
                                    <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Email Address</label>
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                            </svg>
                                        </div>
                                        <input type="email" name="email" id="email" required
                                               class="block w-full pl-10 pr-3 py-2.5 text-sm border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-white transition duration-200">
                                    </div>
                                </div>

                                <!-- Phone -->
                                <div id="phone_field">
                                    <label for="phone" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Phone Number</label>
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                                            </svg>
                                        </div>
                                        <input type="text" name="phone" id="phone"
                                               class="block w-full pl-10 pr-3 py-2.5 text-sm border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-white transition duration-200">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Security Section -->
                <div class="px-6 py-6 sm:px-8">
                    <div class="space-y-6">
                        <div>
                            <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">Security</h2>

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 sm:gap-6">
                                <!-- Password -->
                                <div>
                                    <label for="password" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Password</label>
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                                            </svg>
                                        </div>
                                        <input type="password" name="password" id="password" required
                                               class="block w-full pl-10 pr-3 py-2.5 text-sm border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-white transition duration-200">
                                    </div>
                                </div>

                                <!-- Confirm Password -->
                                <div>
                                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Confirm Password</label>
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                        </div>
                                        <input type="password" name="password_confirmation" id="password_confirmation" required
                                               class="block w-full pl-10 pr-3 py-2.5 text-sm border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-white transition duration-200">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Role Assignment Section -->
                <div class="px-6 py-6 sm:px-8">
                    <div class="space-y-4">
                        <div>
                            <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">Role Assignment <span class="text-red-500">*</span></h2>
                            <p class="text-sm text-gray-600 dark:text-gray-400 mb-4">Select one or more roles for this user. At least one role is required.</p>

                            <div class="space-y-3">
                                @foreach($roles as $role)
                                <div class="flex items-center">
                                    <input type="checkbox" name="role_ids[]" value="{{ $role->id }}" id="role_{{ $role->id }}"
                                           data-role-name="{{ $role->name }}"
                                           class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 dark:border-gray-600 rounded">
                                    <label for="role_{{ $role->id }}" class="ml-3 block text-sm font-medium text-gray-700 dark:text-gray-300">
                                        {{ $role->display_name }}
                                        @if($role->description)
                                            <span class="text-gray-500 dark:text-gray-400">- {{ $role->description }}</span>
                                        @endif
                                    </label>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Account Status Section -->
                <div class="px-6 py-6 sm:px-8">
                    <div class="space-y-4">
                        <div>
                            <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">Account Status</h2>

                            <label for="status" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Account Status</label>
                            <select name="status" id="status" required
                                    class="block w-full px-3 py-2.5 text-sm border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-white transition duration-200">
                                <option value="active">Active</option>
                                <option value="inactive">Inactive</option>
                                <option value="pending">Pending</option>
                                <option value="suspended">Suspended</option>
                            </select>
                        </div>
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="px-6 py-4 sm:px-8 bg-gray-50 dark:bg-gray-800/50 border-t border-gray-200 dark:border-gray-700">
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between space-y-3 sm:space-y-0 sm:space-x-4">
                        <a href="{{ route('partner.settings.user-management') }}"
                           class="inline-flex items-center justify-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 hover:bg-gray-50 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-600 dark:hover:bg-gray-600 rounded-lg transition duration-200">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                            Cancel
                        </a>

                        <button type="submit" id="submit-btn"
                                class="inline-flex items-center justify-center px-6 py-2 text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 dark:bg-indigo-500 dark:hover:bg-indigo-600 rounded-lg shadow-sm hover:shadow-md transition duration-200">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            Create User
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const userTypeSelect = document.getElementById('user_type');
    const teacherSelection = document.getElementById('teacher_selection');
    const studentSelection = document.getElementById('student_selection');
    const userInfoSection = document.getElementById('user_info_section');

    // Form field elements
    const nameField = document.getElementById('name_field');
    const emailField = document.getElementById('email_field');
    const phoneField = document.getElementById('phone_field');
    const nameInput = document.getElementById('name');
    const emailInput = document.getElementById('email');
    const phoneInput = document.getElementById('phone');

    function toggleSections() {
        const selectedRole = userTypeSelect.value;

        // Hide all sections initially
        teacherSelection.style.display = 'none';
        studentSelection.style.display = 'none';

        // Show user info section by default
        userInfoSection.style.display = 'block';

        // Clear field values
        nameInput.value = '';
        emailInput.value = '';
        phoneInput.value = '';

        // Clear all role checkboxes first
        const roleCheckboxes = document.querySelectorAll('input[name="role_ids[]"]');
        roleCheckboxes.forEach(checkbox => checkbox.checked = false);

        // Auto-select corresponding role checkbox based on user_type
        if (selectedRole) {
            const matchingRoleCheckbox = document.querySelector(`input[name="role_ids[]"][data-role-name="${selectedRole}"]`);
            if (matchingRoleCheckbox) {
                matchingRoleCheckbox.checked = true;
            } else {
                // If no exact match, try to find a similar role or select the first available role
                const firstRoleCheckbox = document.querySelector('input[name="role_ids[]"]');
                if (firstRoleCheckbox) {
                    firstRoleCheckbox.checked = true;
                }
            }
        }

        // Show appropriate section and hide user info section based on selected role
        if (selectedRole === 'teacher' || selectedRole === 'teacher_role') {
            teacherSelection.style.display = 'block';
            userInfoSection.style.display = 'none';
        } else if (selectedRole === 'student' || selectedRole === 'student_role') {
            studentSelection.style.display = 'block';
            userInfoSection.style.display = 'none';
        }
    }

    userTypeSelect.addEventListener('change', toggleSections);
    toggleSections();

    // Success message function
    function showSuccessMessage(message) {
        // Create toast notification
        const toast = document.createElement('div');
        toast.className = 'fixed top-4 right-4 bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg z-50 transform translate-x-full transition-transform duration-300';
        toast.innerHTML = `
            <div class="flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
                ${message}
            </div>
        `;
        
        document.body.appendChild(toast);
        
        // Animate in
        setTimeout(() => {
            toast.classList.remove('translate-x-full');
        }, 100);
        
        // Remove after delay
        setTimeout(() => {
            toast.classList.add('translate-x-full');
            setTimeout(() => {
                document.body.removeChild(toast);
            }, 300);
        }, 3000);
    }

    // Form submission validation
    const form = document.getElementById('create-user-form');
    const submitBtn = document.getElementById('submit-btn');
    
    form.addEventListener('submit', function(e) {
        e.preventDefault();
        
        // Check if at least one role is selected
        const checkedRoles = document.querySelectorAll('input[name="role_ids[]"]:checked');
        
        if (checkedRoles.length === 0) {
            alert('Please select at least one role for the user.');
            return false;
        }
        
        // Show loading state
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<svg class="animate-spin -ml-1 mr-3 h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>Creating...';
        
        // Submit form via AJAX
        const formData = new FormData(form);
        
        fetch(form.action, {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || document.querySelector('input[name="_token"]').value
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Show success message and redirect
                showSuccessMessage('User created successfully!');
                setTimeout(() => {
                    window.location.href = '{{ route("partner.settings.index") }}';
                }, 1500);
            } else {
                // Show error message
                let errorMsg = 'Failed to create user.';
                if (data.errors) {
                    errorMsg += '\n\nErrors:\n';
                    Object.keys(data.errors).forEach(key => {
                        errorMsg += `- ${data.errors[key].join(', ')}\n`;
                    });
                } else if (data.message) {
                    errorMsg = data.message;
                }
                alert(errorMsg);
                
                // Reset button state
                submitBtn.disabled = false;
                submitBtn.innerHTML = '<svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>Create User';
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('An error occurred while creating the user. Please try again.');
            
            // Reset button state
            submitBtn.disabled = false;
            submitBtn.innerHTML = '<svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>Create User';
        });
    });
});
</script>
@endsection
