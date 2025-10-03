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
                    <a href="{{ url('/partner/settings') }}"
                       class="inline-flex items-center px-3 py-2 text-sm font-medium text-gray-700 bg-gray-100 hover:bg-gray-200 dark:bg-gray-700 dark:text-gray-300 dark:hover:bg-gray-600 rounded-lg transition duration-200">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                        </svg>
                        Back to Settings
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
        <!-- Progress Indicator -->
        <div class="mb-8">
            <div class="flex items-center justify-center space-x-4">
                <div class="flex items-center">
                    <div id="step1-indicator" class="w-8 h-8 bg-indigo-600 text-white rounded-full flex items-center justify-center text-sm font-semibold">1</div>
                    <span class="ml-2 text-sm font-medium text-gray-900 dark:text-white">Select Role</span>
                </div>
                <div class="w-12 h-px bg-gray-300 dark:bg-gray-600"></div>
                <div class="flex items-center">
                    <div id="step2-indicator" class="w-8 h-8 bg-gray-300 text-gray-600 dark:bg-gray-600 dark:text-gray-400 rounded-full flex items-center justify-center text-sm font-semibold">2</div>
                    <span class="ml-2 text-sm font-medium text-gray-500 dark:text-gray-400">User Details</span>
                </div>
            </div>
        </div>

        <!-- Create User Form -->
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
            <form id="createUserForm" action="{{ route('partner.settings.users.store') }}" method="POST" class="divide-y divide-gray-200 dark:divide-gray-700">
                @csrf

                <!-- Step 1: Role Selection -->
                <div id="step1" class="px-6 py-6 sm:px-8">
                    <div class="space-y-6">
                        <div>
                            <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">Step 1: Select User Role</h2>
                            <p class="text-sm text-gray-600 dark:text-gray-400 mb-4">Choose the type of user account you want to create.</p>

                            @php
                                // Define role configurations with default values
                                $roleIcons = [
                                    'admin' => 'M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10',
                                    'student' => 'M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2',
                                    'teacher' => 'M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253',
                                    'default' => 'M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z'
                                ];

                                $roleColors = [
                                    'admin' => 'purple',
                                    'student' => 'green',
                                    'teacher' => 'blue',
                                    'default' => 'indigo'
                                ];
                            @endphp
                            
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                @foreach($roles as $role)
                                    @php
                                        $roleKey = strtolower($role->name);
                                        $icon = $roleIcons[$roleKey] ?? $roleIcons['default'];
                                        $bgColor = $roleColors[$roleKey] ?? $roleColors['default'];
                                        $description = $role->description ?? 'User with ' . ucfirst(str_replace('_', ' ', $role->name)) . ' role';
                                    @endphp
                                    <div class="relative">
                                        <input type="radio" name="role_id" id="role_{{ $role->id }}" value="{{ $role->id }}" class="sr-only peer" {{ $loop->first ? 'checked' : '' }}>
                                        <label for="role_{{ $role->id }}" class="block cursor-pointer">
                                            <div class="p-4 border-2 border-gray-200 dark:border-gray-600 rounded-lg transition duration-200 h-full peer-checked:border-{{ $bgColor }}-500 peer-checked:ring-2 peer-checked:ring-{{ $bgColor }}-200 dark:peer-checked:ring-{{ $bgColor }}-900/20 peer-checked:bg-{{ $bgColor }}-50/50 dark:peer-checked:bg-{{ $bgColor }}-900/10 hover:bg-gray-50 dark:hover:bg-gray-700/50">
                                                <div class="flex items-center space-x-3">
                                                    <div class="w-10 h-10 rounded-lg flex items-center justify-center flex-shrink-0 bg-{{ $bgColor }}-100 dark:bg-{{ $bgColor }}-900/50">
                                                        <svg class="w-6 h-6 text-{{ $bgColor }}-600 dark:text-{{ $bgColor }}-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $icon }}" />
                                                        </svg>
                                                    </div>
                                                    <div>
                                                        <h3 class="font-medium text-gray-900 dark:text-white">{{ $role->display_name ?? ucfirst(str_replace('_', ' ', $role->name)) }}</h3>
                                                        <p class="text-sm text-gray-500 dark:text-gray-400">{{ $description }}</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <!-- Step Navigation -->
                        <div class="flex justify-end">
                            <button type="button" id="nextToStep2" class="inline-flex items-center px-6 py-2 text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 dark:bg-indigo-500 dark:hover:bg-indigo-600 rounded-lg shadow-sm transition duration-200 disabled:opacity-50 disabled:cursor-not-allowed">
                                Next: User Details
                                <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Step 2: User Details -->
                <div id="step2" class="px-6 py-6 sm:px-8" style="display: none;">
                    <!-- Dynamic Entity Selection Section -->
                    <div id="entity_selection" class="space-y-4 mb-6" style="display: none;">
                        <div id="entity_selection_content">
                            <!-- Will be populated dynamically based on role -->
                        </div>
                    </div>

                    <!-- User Information Section -->
                    <div id="user_info_section" class="space-y-6 mb-6">
                        <div>
                            <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">User Information</h2>

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 sm:gap-6">
                                <!-- Full Name -->
                                <div id="name_field" class="sm:col-span-2">
                                    <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                        Full Name
                                        <span id="name-source" class="text-xs text-gray-500 ml-1" style="display: none;">(from database)</span>
                                    </label>
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                            </svg>
                                        </div>
                                        <input type="text" name="name" id="name"
                                               class="name-field block w-full pl-10 pr-3 py-2.5 text-sm border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-white transition duration-200"
                                               readonly>
                                    </div>
                                </div>

                                <!-- Email -->
                                <div id="email_field">
                                    <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                        Email Address
                                        <span id="email-source" class="text-xs text-gray-500 ml-1" style="display: none;">(from database)</span>
                                    </label>
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                            </svg>
                                        </div>
                                        <input type="email" name="email" id="email"
                                               class="email-field block w-full pl-10 pr-3 py-2.5 text-sm border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-white transition duration-200"
                                               readonly>
                                    </div>
                                </div>

                                <!-- Phone -->
                                <div id="phone_field">
                                    <label for="phone" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                        Phone Number
                                        <span id="phone-source" class="text-xs text-gray-500 ml-1" style="display: none;">(from database)</span>
                                    </label>
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                                            </svg>
                                        </div>
                                        <input type="text" name="phone" id="phone"
                                               class="block w-full pl-10 pr-3 py-2.5 text-sm border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-white transition duration-200"
                                               readonly>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Security Section -->
                    <div class="space-y-6 mb-6">
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

                    <!-- Account Status Section -->
                    <div class="space-y-4 mb-6">
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

                    <!-- Step Navigation -->
                    <div class="flex justify-between">
                        <button type="button" id="backToStep1" class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 hover:bg-gray-200 dark:bg-gray-700 dark:text-gray-300 dark:hover:bg-gray-600 rounded-lg transition duration-200">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                            </svg>
                            Back
                        </button>

                        <button type="submit" id="submitBtn"
                                class="inline-flex items-center justify-center px-6 py-2 text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 dark:bg-indigo-500 dark:hover:bg-indigo-600 rounded-lg shadow-sm hover:shadow-md transition duration-200 disabled:opacity-50 disabled:cursor-not-allowed">
                            <svg id="submitIcon" class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            <span id="submitText">Create User</span>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const step1 = document.getElementById('step1');
    const step2 = document.getElementById('step2');
    const step1Indicator = document.getElementById('step1-indicator');
    const step2Indicator = document.getElementById('step2-indicator');
    const nextToStep2Btn = document.getElementById('nextToStep2');
    const backToStep1Btn = document.getElementById('backToStep1');

    const userTypeInputs = document.querySelectorAll('input[name="user_type"]');
    const teacherSelection = document.getElementById('teacher_selection');
    const studentSelection = document.getElementById('student_selection');
    const userInfoSection = document.getElementById('user_info_section');

    const createUserForm = document.getElementById('createUserForm');
    const submitBtn = document.getElementById('submitBtn');
    const submitText = document.getElementById('submitText');
    const submitIcon = document.getElementById('submitIcon');

    // Form field elements
    const nameInput = document.getElementById('name');
    const emailInput = document.getElementById('email');
    const phoneInput = document.getElementById('phone');

    let currentStep = 1;
    let selectedRole = '';

    // Initialize step visibility
    function showStep(step) {
        if (step === 1) {
            step1.style.display = 'block';
            step2.style.display = 'none';
            step1Indicator.className = 'w-8 h-8 bg-indigo-600 text-white rounded-full flex items-center justify-center text-sm font-semibold';
            step2Indicator.className = 'w-8 h-8 bg-gray-300 text-gray-600 dark:bg-gray-600 dark:text-gray-400 rounded-full flex items-center justify-center text-sm font-semibold';
            currentStep = 1;
        } else {
            step1.style.display = 'none';
            step2.style.display = 'block';
            step1Indicator.className = 'w-8 h-8 bg-green-600 text-white rounded-full flex items-center justify-center text-sm font-semibold';
            step2Indicator.className = 'w-8 h-8 bg-indigo-600 text-white rounded-full flex items-center justify-center text-sm font-semibold';
            currentStep = 2;
        }
    }

    // Handle role selection in step 1
    function handleRoleSelection() {
        const selectedRoleInput = document.querySelector('input[name="role_id"]:checked');
        if (selectedRoleInput) {
            selectedRole = selectedRoleInput.value;
            // All roles use the same user info section
            userInfoSection.style.display = 'block';
            nextToStep2Btn.disabled = false;
        } else {
            nextToStep2Btn.disabled = true;
        }
    }

    // Generic function to populate form fields from selected entity
    function populateEntityFields(selectId, emailField = '') {
        const select = document.getElementById(selectId);
        if (!select) return;
        
        const selectedOption = select.options[select.selectedIndex];
        if (selectedOption && selectedOption.value) {
            const optionText = selectedOption.textContent;
            // Match name (and optionally ID/email) in format: "Name (ID/Email)"
            const match = optionText.match(/(.+?)(?:\s*\(([^)]+)\))?$/);
            
            if (match) {
                nameInput.value = match[1].trim();
                
                // If we have a second group and it looks like an email, use it
                if (match[2] && match[2].includes('@')) {
                    emailInput.value = match[2].trim();
                }
                
                document.getElementById('name-source').style.display = 'inline';
                document.getElementById('email-source').style.display = match[2] && match[2].includes('@') ? 'inline' : 'none';
            }
        } else {
            nameInput.value = '';
            emailInput.value = '';
            phoneInput.value = '';
            
            document.getElementById('name-source').style.display = 'none';
            document.getElementById('email-source').style.display = 'none';
            document.getElementById('phone-source').style.display = 'none';
        }
    }

    // Show loading state
    function showLoading() {
        submitBtn.disabled = true;
        submitText.textContent = 'Creating...';
        submitIcon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>';
    }

    // Reset button state
    function resetButton() {
        submitBtn.disabled = false;
        submitText.textContent = 'Create User';
        submitIcon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>';
    }

    // Show success message
    function showSuccess(message) {
        const notification = document.createElement('div');
        notification.className = 'fixed top-4 right-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg shadow-lg z-50';
        notification.innerHTML = `
            <div class="flex items-center">
                <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                </svg>
                <span>${message}</span>
            </div>
        `;

        document.body.appendChild(notification);

        setTimeout(() => {
            notification.remove();
        }, 3000);
    }

    // Show error message
    function showError(message) {
        const notification = document.createElement('div');
        notification.className = 'fixed top-4 right-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg shadow-lg z-50';
        notification.innerHTML = `
            <div class="flex items-center">
                <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                </svg>
                <span>${message}</span>
            </div>
        `;

        document.body.appendChild(notification);

        setTimeout(() => {
            notification.remove();
        }, 5000);
    }

    // Event Listeners
    document.querySelectorAll('input[name="role_id"]').forEach(input => {
        input.addEventListener('change', handleRoleSelection);
    });

    // Add change listeners to any entity selection dropdowns
    const entitySelects = document.querySelectorAll('select[id$="_id"]');
    entitySelects.forEach(select => {
        select.addEventListener('change', () => populateEntityFields(select.id));
    });

    nextToStep2Btn.addEventListener('click', function() {
        const selectedRoleInput = document.querySelector('input[name="role_id"]:checked');
        if (selectedRoleInput) {
            selectedRole = selectedRoleInput.value;
            showStep(2);
        }
    });

    backToStep1Btn.addEventListener('click', function() {
        showStep(1);
        selectedRole = '';
        const checkedInput = document.querySelector('input[name="role_id"]:checked');
        if (checkedInput) {
            checkedInput.checked = false;
        }
        nextToStep2Btn.disabled = true;
    });

    // Form submission
    createUserForm.addEventListener('submit', function(e) {
        e.preventDefault();

        // Client-side validation
        let isValid = true;
        let errorMessage = '';

        // Basic validation for all roles
        if (!nameInput.value.trim()) {
            isValid = false;
            errorMessage = 'Please enter a full name.';
        } else if (!emailInput.value.trim()) {
            isValid = false;
            errorMessage = 'Please enter an email address.';
        } else if (!document.getElementById('password').value) {
            isValid = false;
            errorMessage = 'Please enter a password.';
        } else if (document.getElementById('password').value !== document.getElementById('password_confirmation').value) {
            isValid = false;
            errorMessage = 'Password confirmation does not match.';
        }

        if (!isValid) {
            showError(errorMessage);
            return;
        }

        // Show loading state
        showLoading();

        // Make AJAX request
        fetch(createUserForm.action, {
            method: 'POST',
            body: new FormData(createUserForm),
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            resetButton();

            if (data.success) {
                showSuccess(data.message || 'User created successfully!');

                setTimeout(() => {
                    window.location.href = '{{ route("partner.settings.user-management") }}';
                }, 1500);
            } else {
                if (data.errors) {
                    let errorMessage = 'Please fix the following errors:\n';
                    for (let field in data.errors) {
                        errorMessage += `• ${data.errors[field].join(', ')}\n`;
                    }
                    showError(errorMessage);
                } else {
                    showError(data.message || 'Failed to create user');
                }
            }
        })
        .catch(error => {
            resetButton();
            console.error('Error:', error);
            showError('An unexpected error occurred. Please try again.');
        });
    });

    // Initialize
    showStep(1);
    nextToStep2Btn.disabled = true;
});
</script>
@endsection
