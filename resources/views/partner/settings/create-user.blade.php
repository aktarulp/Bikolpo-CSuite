@extends('layouts.partner-layout')

@section('title', 'Create New User')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-slate-50 via-blue-50 to-indigo-50 py-8">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Header Section -->
        <div class="mb-8">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-4">
                    <a href="/partner/settings" 
                       class="group inline-flex items-center px-4 py-2 text-sm font-medium text-gray-600 hover:text-gray-900 bg-white hover:bg-gray-50 border border-gray-300 hover:border-gray-400 rounded-lg shadow-sm transition-all duration-200">
                        <svg class="w-4 h-4 mr-2 transition-transform group-hover:-translate-x-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                        Back to Settings
                    </a>
                </div>
                <div class="text-right">
                    <h1 class="text-2xl font-bold text-gray-900">Create New User</h1>
                    <p class="text-sm text-gray-600 mt-1">Add a new user to your organization</p>
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
                
                <!-- Step 1: Role Selection -->
                <div class="p-6 sm:p-8">
                    <div class="flex items-center mb-6">
                        <div class="flex-shrink-0">
                            <div class="w-10 h-10 bg-gradient-to-r from-blue-500 to-indigo-600 rounded-full flex items-center justify-center">
                                <span class="text-white font-semibold text-lg">1</span>
                            </div>
                        </div>
                        <div class="ml-4">
                            <h2 class="text-lg font-semibold text-gray-900">Select User Role</h2>
                            <p class="text-sm text-gray-600">Choose the role and permissions for this user</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                        <!-- Role Selection -->
                        <div>
                            <label for="role_id" class="block text-sm font-medium text-gray-700 mb-2">
                                User Role <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <select name="role_id" id="role_id" required
                                        class="block w-full px-4 py-3 pr-10 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200 bg-white">
                                    <option value="">Select a role</option>
                                    @foreach($roles as $role)
                                        @php
                                            $roleName = strtolower($role->name);
                                            $isTeacher = str_contains($roleName, 'teacher');
                                            $isStudent = str_contains($roleName, 'student');
                                            
                                            if ($isTeacher) {
                                                $userType = 'teacher';
                                                $icon = '📚';
                                            } elseif ($isStudent) {
                                                $userType = 'student';
                                                $icon = '🎓';
                                            } else {
                                                $userType = 'operator';
                                                $icon = '👤';
                                            }
                                            
                                            $displayName = $role->display_name ?? ucfirst(str_replace('_', ' ', $role->name));
                                        @endphp
                                        
                                        <option value="{{ $role->id }}" 
                                                data-name="{{ $role->name }}" 
                                                data-user-type="{{ $userType }}"
                                                data-icon="{{ $icon }}">
                                            {{ $icon }} {{ $displayName }}
                                            @if($role->description) - {{ $role->description }}@endif
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

                        <!-- Quick Teacher/Student Selection -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Quick Select Existing Record
                            </label>
                            
                            <!-- Teacher Quick Select -->
                            <div id="teacherQuickSelect" class="hidden">
                                <div class="flex space-x-2">
                                    <div class="flex-1">
                                        <select id="quick_teacher_select" class="block w-full px-3 py-3 text-sm border border-blue-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200">
                                            <option value="">-- Select existing teacher --</option>
                                            @forelse($teachers as $teacher)
                                                <option value="{{ $teacher->id }}" 
                                                        data-name="{{ $teacher->full_name_en ?? $teacher->full_name_bn }}"
                                                        data-email="{{ $teacher->email }}"
                                                        data-phone="{{ $teacher->mobile }}"
                                                        data-teacher-data="{{ json_encode($teacher->toArray()) }}">
                                                    {{ $teacher->full_name_en ?? $teacher->full_name_bn }} 
                                                    @if($teacher->teacher_id) ({{ $teacher->teacher_id }}) @endif
                                                    @if($teacher->user_id) - ⚠️ Has account @endif
                                                </option>
                                            @empty
                                                <option value="" disabled>No teachers found</option>
                                            @endforelse
                                        </select>
                                    </div>
                                    <button type="button" id="quick_populate_teacher_btn" class="px-4 py-3 text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 rounded-lg focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-200 disabled:opacity-50 disabled:cursor-not-allowed" disabled>
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path>
                                        </svg>
                                    </button>
                                </div>
                            </div>

                            <!-- Student Quick Select -->
                            <div id="studentQuickSelect" class="hidden">
                                <div class="flex space-x-2">
                                    <div class="flex-1">
                                        <select id="quick_student_select" class="block w-full px-3 py-3 text-sm border border-green-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 transition duration-200">
                                            <option value="">-- Select existing student --</option>
                                            @forelse($students as $student)
                                                <option value="{{ $student->id }}" 
                                                        data-name="{{ $student->full_name }}"
                                                        data-email="{{ $student->email }}"
                                                        data-phone="{{ $student->phone }}"
                                                        data-student-data="{{ json_encode($student->toArray()) }}">
                                                    {{ $student->full_name }} 
                                                    @if($student->student_id) ({{ $student->student_id }}) @endif
                                                    @if($student->user_id) - ⚠️ Has account @endif
                                                </option>
                                            @empty
                                                <option value="" disabled>No students found</option>
                                            @endforelse
                                        </select>
                                    </div>
                                    <button type="button" id="quick_populate_student_btn" class="px-4 py-3 text-sm font-medium text-white bg-green-600 hover:bg-green-700 rounded-lg focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-colors duration-200 disabled:opacity-50 disabled:cursor-not-allowed" disabled>
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path>
                                        </svg>
                                    </button>
                                </div>
                            </div>

                            <!-- Default message when no teacher/student role selected -->
                            <div id="noQuickSelect" class="text-sm text-gray-500 italic py-3">
                                Select a teacher or student role to see quick selection options
                            </div>
                        </div>
                    </div>
                    
                    <!-- Role Type Indicator -->
                    <div id="roleTypeIndicator" class="mt-6 hidden">
                        <div class="flex items-center space-x-2 p-3 rounded-lg border">
                            <div id="roleIcon" class="text-2xl"></div>
                            <div>
                                <div id="roleTypeName" class="text-sm font-medium text-gray-900"></div>
                                <div id="roleTypeDescription" class="text-xs text-gray-500"></div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Hidden field to store user type -->
                    <input type="hidden" name="user_type" id="user_type" value="">
                    
                    <!-- Debug: Show current user type (remove in production) -->
                    <div id="debugUserType" class="mt-2 text-xs text-gray-500">
                        <strong>Debug - Current user type:</strong> <span id="debugUserTypeValue" class="font-mono bg-yellow-100 px-2 py-1 rounded font-bold">[Not set yet]</span>
                    </div>
                </div>

                <!-- Step 2: Basic Information -->
                <div class="p-6 sm:p-8">
                    <div class="flex items-center mb-6">
                        <div class="flex-shrink-0">
                            <div class="w-10 h-10 bg-gradient-to-r from-purple-500 to-pink-600 rounded-full flex items-center justify-center">
                                <span class="text-white font-semibold text-lg">2</span>
                            </div>
                        </div>
                        <div class="ml-4">
                            <h2 class="text-lg font-semibold text-gray-900">Basic Information</h2>
                            <p class="text-sm text-gray-600">Enter the user's basic details</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Full Name -->
                        <div class="relative">
                            <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                                Full Name <span class="text-red-500">*</span>
                                <span id="name_lock_indicator" class="hidden ml-2 text-xs text-green-600 font-medium">
                                    <svg class="w-3 h-3 inline mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd"></path>
                                    </svg>
                                    Auto-populated
                                </span>
                            </label>
                            <div class="relative">
                                <input type="text" name="name" id="name" required
                                       class="block w-full px-3 py-2 pr-10 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200"
                                       placeholder="Enter full name">
                                <button type="button" id="name_unlock_btn" class="hidden absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-gray-600" title="Unlock field for editing">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 11V7a4 4 0 118 0m-4 8v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2z"></path>
                                    </svg>
                                </button>
                            </div>
                        </div>

                        <!-- Email -->
                        <div class="relative">
                            <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                                Email Address <span class="text-red-500">*</span>
                                <span id="email_lock_indicator" class="hidden ml-2 text-xs text-green-600 font-medium">
                                    <svg class="w-3 h-3 inline mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd"></path>
                                    </svg>
                                    Auto-populated
                                </span>
                            </label>
                            <div class="relative">
                                <input type="email" name="email" id="email" required
                                       class="block w-full px-3 py-2 pr-10 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200"
                                       placeholder="Enter email address">
                                <button type="button" id="email_unlock_btn" class="hidden absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-gray-600" title="Unlock field for editing">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 11V7a4 4 0 118 0m-4 8v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2z"></path>
                                    </svg>
                                </button>
                            </div>
                        </div>

                        <!-- Phone, Password, Confirm Password - 3 Column Grid -->
                        <div class="md:col-span-2">
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                <!-- Phone Number -->
                                <div class="relative">
                                    <label for="phone" class="block text-sm font-medium text-gray-700 mb-2">
                                        Phone Number <span class="text-red-500">*</span>
                                        <span id="phone_lock_indicator" class="hidden ml-2 text-xs text-green-600 font-medium">
                                            <svg class="w-3 h-3 inline mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd"></path>
                                            </svg>
                                            Auto-populated
                                        </span>
                                    </label>
                                    <div class="relative">
                                        <input type="tel" name="phone" id="phone" required
                                               class="block w-full px-3 py-2 pr-10 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200"
                                               placeholder="Enter phone number">
                                        <button type="button" id="phone_unlock_btn" class="hidden absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-gray-600" title="Unlock field for editing">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 11V7a4 4 0 118 0m-4 8v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2z"></path>
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                                
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
                    
                    <!-- Auto-populated Data Controls -->
                    <div id="autoPopulatedControls" class="hidden mt-6 p-4 bg-green-50 border border-green-200 rounded-lg">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-2">
                                <svg class="w-5 h-5 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                </svg>
                                <span class="text-sm font-medium text-green-800">Data auto-populated from existing record</span>
                            </div>
                            <button type="button" id="clearAutoPopulatedBtn" class="px-3 py-1 text-xs font-medium text-red-600 bg-white border border-red-300 rounded hover:bg-red-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition-colors duration-200">
                                Clear & Edit Manually
                            </button>
                        </div>
                        <p class="mt-2 text-xs text-green-700">
                            Fields are locked to prevent accidental changes. Click the unlock button next to each field or use "Clear & Edit Manually" to modify the data.
                        </p>
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
    const userTypeInputs = document.querySelectorAll('input[name="user_type"]');
    const submitBtn = document.getElementById('submitBtn');
    const submitText = document.getElementById('submitText');
    const submitIcon = document.getElementById('submitIcon');
    const loadingOverlay = document.getElementById('loadingOverlay');
    const resetBtn = document.getElementById('resetBtn');

    // Handle role selection changes
    const roleSelect = document.getElementById('role_id');
    const userTypeField = document.getElementById('user_type');
    const roleTypeIndicator = document.getElementById('roleTypeIndicator');
    
    console.log('Elements found:', {
        roleSelect: roleSelect ? 'YES' : 'NO',
        userTypeField: userTypeField ? 'YES' : 'NO',
        form: form ? 'YES' : 'NO'
    });
    const roleIcon = document.getElementById('roleIcon');
    const roleTypeName = document.getElementById('roleTypeName');
    const roleTypeDescription = document.getElementById('roleTypeDescription');
    const debugUserType = document.getElementById('debugUserType');
    const debugUserTypeValue = document.getElementById('debugUserTypeValue');
    
    function handleRoleChange() {
        console.log('=== handleRoleChange called ===');
        const selectedOption = roleSelect.options[roleSelect.selectedIndex];
        console.log('Selected option:', selectedOption);
        console.log('Selected value:', selectedOption.value);
        
        if (selectedOption.value && selectedOption.value !== '') {
            const userType = selectedOption.getAttribute('data-user-type');
            const icon = selectedOption.getAttribute('data-icon');
            const roleName = selectedOption.getAttribute('data-name');
            
            console.log('Data attributes:', {
                userType: userType,
                icon: icon,
                roleName: roleName
            });
            
            // CRITICAL: Set user type immediately
            let finalUserType = userType;
            
            if (!finalUserType) {
                // Fallback: determine user type from role name
                const nameToCheck = (roleName || selectedOption.textContent).toLowerCase();
                console.log('Checking role name:', nameToCheck);
                
                if (nameToCheck.includes('teacher')) {
                    finalUserType = 'teacher';
                } else if (nameToCheck.includes('student')) {
                    finalUserType = 'student';
                } else {
                    finalUserType = 'operator';
                }
                console.log('Fallback user type detected:', finalUserType);
            }
            
            // SET THE USER TYPE FIELD
            userTypeField.value = finalUserType;
            debugUserTypeValue.textContent = finalUserType;
            
            console.log('✓✓✓ User type field NOW set to:', userTypeField.value);
            console.log('✓✓✓ Debug display NOW shows:', debugUserTypeValue.textContent);
            
            // Show role type indicator
            roleTypeIndicator.classList.remove('hidden');
            roleIcon.textContent = icon || '👤';
            roleTypeName.textContent = roleName || selectedOption.textContent.trim();
            
            // Set description based on user type
            let description = '';
            
            if (finalUserType === 'teacher') {
                description = 'Can manage courses, create questions, and view student progress';
                roleTypeIndicator.querySelector('.border').className = 'flex items-center space-x-2 p-3 rounded-lg border border-green-200 bg-green-50';
            } else if (finalUserType === 'student') {
                description = 'Can access learning materials, take exams, and view results';
                roleTypeIndicator.querySelector('.border').className = 'flex items-center space-x-2 p-3 rounded-lg border border-purple-200 bg-purple-50';
            } else {
                description = 'Standard system user with basic permissions';
                roleTypeIndicator.querySelector('.border').className = 'flex items-center space-x-2 p-3 rounded-lg border border-blue-200 bg-blue-50';
            }
            roleTypeDescription.textContent = description;
            

            // Show relevant section based on detected user type
            console.log('Final user type:', finalUserType);
            
            // Handle quick selection visibility
            const teacherQuickSelect = document.getElementById('teacherQuickSelect');
            const studentQuickSelect = document.getElementById('studentQuickSelect');
            const noQuickSelect = document.getElementById('noQuickSelect');
            
            // Hide all quick selects first
            teacherQuickSelect.classList.add('hidden');
            studentQuickSelect.classList.add('hidden');
            noQuickSelect.classList.add('hidden');
            
            if (finalUserType === 'teacher') {
                console.log('Teacher role selected - showing quick select only');
                teacherQuickSelect.classList.remove('hidden');
            } else if (finalUserType === 'student') {
                console.log('Student role selected - showing quick select only');
                studentQuickSelect.classList.remove('hidden');
            } else {
                console.log('No specific section to show for user type:', finalUserType);
                noQuickSelect.classList.remove('hidden');
            }
        } else {
            // Hide indicator and sections if no role selected
            roleTypeIndicator.classList.add('hidden');
            debugUserType.classList.add('hidden');
            userTypeField.value = '';
            console.log('No role selected, user type cleared');
        }
    }
    
    roleSelect.addEventListener('change', function() {
        console.log('Role changed to:', roleSelect.value);
        handleRoleChange();
    });
    
    // Initialize on page load if there's a selected value
    if (roleSelect.value) {
        console.log('Initial role value:', roleSelect.value);
        handleRoleChange();
    }
    
    // Also trigger on any interaction
    roleSelect.addEventListener('click', function() {
        console.log('Role select clicked');
    });

    // Form submission
    form.addEventListener('submit', function(e) {
        e.preventDefault();
        
        console.log('Form submit triggered');
        
        // Ensure a role is selected
        if (!roleSelect.value) {
            alert('Please select a user role');
            roleSelect.focus();
            return false;
        }
        
        // CRITICAL: Ensure user_type is ALWAYS set before submission
        if (roleSelect.value) {
            const selectedOption = roleSelect.options[roleSelect.selectedIndex];
            const userType = selectedOption.getAttribute('data-user-type');
            
            if (userType) {
                userTypeField.value = userType;
                console.log('✓ User type set to:', userType);
            } else {
                // Fallback: detect from role name
                const roleName = (selectedOption.getAttribute('data-name') || selectedOption.textContent).toLowerCase();
                let detectedType = 'operator';
                
                if (roleName.includes('teacher')) {
                    detectedType = 'teacher';
                } else if (roleName.includes('student')) {
                    detectedType = 'student';
                }
                
                userTypeField.value = detectedType;
                console.log('✓ User type detected and set to:', detectedType);
            }
        }
        
        // Final validation: user_type MUST be set
        if (!userTypeField.value) {
            alert('Error: User type could not be determined. Please select a role again.');
            roleSelect.focus();
            return false;
        }
        
        // Debug: Log form data before submission
        const formData = new FormData(form);
        console.log('Form data being submitted:');
        for (let [key, value] of formData.entries()) {
            console.log(key + ': ' + value);
        }
        
        // Validate required fields
        if (!roleSelect.value) {
            showNotification('Please select a user role', 'error');
            return;
        }
        
        if (!userTypeField.value) {
            showNotification('User type could not be determined. Please try selecting the role again.', 'error');
            return;
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
                'Accept': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showNotification('User created successfully!', 'success');
                setTimeout(() => {
                    window.location.href = '{{ route("partner.settings.index") }}';
                }, 1500);
            } else {
                throw new Error(data.message || 'Failed to create user');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showNotification(error.message || 'An error occurred while creating the user', 'error');
            
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
            // Reset to operator as default
            document.querySelector('input[name="user_type"][value="operator"]').checked = true;
        }
    });

    // Handle quick teacher selection (top section)
    const quickTeacherSelect = document.getElementById('quick_teacher_select');
    const quickPopulateTeacherBtn = document.getElementById('quick_populate_teacher_btn');
    
    if (quickTeacherSelect && quickPopulateTeacherBtn) {
        quickTeacherSelect.addEventListener('change', function() {
            quickPopulateTeacherBtn.disabled = !this.value;
        });
        
        quickPopulateTeacherBtn.addEventListener('click', function() {
            const selectedOption = quickTeacherSelect.options[quickTeacherSelect.selectedIndex];
            if (selectedOption.value) {
                populateTeacherData(selectedOption);
            }
        });
    }

    
    // Handle quick student selection (top section)
    const quickStudentSelect = document.getElementById('quick_student_select');
    const quickPopulateStudentBtn = document.getElementById('quick_populate_student_btn');
    
    if (quickStudentSelect && quickPopulateStudentBtn) {
        quickStudentSelect.addEventListener('change', function() {
            quickPopulateStudentBtn.disabled = !this.value;
        });
        
        quickPopulateStudentBtn.addEventListener('click', function() {
            const selectedOption = quickStudentSelect.options[quickStudentSelect.selectedIndex];
            if (selectedOption.value) {
                populateStudentData(selectedOption);
            }
        });
    }

    // Field locking functionality
    function lockField(fieldId) {
        const field = document.getElementById(fieldId);
        const lockIndicator = document.getElementById(fieldId + '_lock_indicator');
        const unlockBtn = document.getElementById(fieldId + '_unlock_btn');
        
        if (field && lockIndicator && unlockBtn) {
            field.readOnly = true;
            field.classList.add('bg-gray-50', 'text-gray-600', 'cursor-not-allowed');
            field.classList.remove('focus:ring-2', 'focus:ring-blue-500', 'focus:border-blue-500');
            lockIndicator.classList.remove('hidden');
            unlockBtn.classList.remove('hidden');
        }
    }
    
    function unlockField(fieldId) {
        const field = document.getElementById(fieldId);
        const lockIndicator = document.getElementById(fieldId + '_lock_indicator');
        const unlockBtn = document.getElementById(fieldId + '_unlock_btn');
        
        if (field && lockIndicator && unlockBtn) {
            field.readOnly = false;
            field.classList.remove('bg-gray-50', 'text-gray-600', 'cursor-not-allowed');
            field.classList.add('focus:ring-2', 'focus:ring-blue-500', 'focus:border-blue-500');
            lockIndicator.classList.add('hidden');
            unlockBtn.classList.add('hidden');
        }
    }
    
    function showAutoPopulatedControls() {
        document.getElementById('autoPopulatedControls').classList.remove('hidden');
    }
    
    function hideAutoPopulatedControls() {
        document.getElementById('autoPopulatedControls').classList.add('hidden');
    }
    
    function clearAllAutoPopulatedData() {
        // Unlock and clear all fields
        ['name', 'email', 'phone'].forEach(fieldId => {
            unlockField(fieldId);
            document.getElementById(fieldId).value = '';
        });
        
        // Remove hidden teacher/student ID fields
        document.querySelectorAll('input[name="teacher_id"], input[name="student_id"]').forEach(field => field.remove());
        
        // Hide controls
        hideAutoPopulatedControls();
        
        // Reset quick selects
        const quickTeacherSelect = document.getElementById('quick_teacher_select');
        const quickStudentSelect = document.getElementById('quick_student_select');
        if (quickTeacherSelect) quickTeacherSelect.value = '';
        if (quickStudentSelect) quickStudentSelect.value = '';
        
        showNotification('Auto-populated data cleared. You can now edit fields manually.', 'info');
    }

    // Reusable function to populate teacher data
    function populateTeacherData(selectedOption) {
        try {
            const teacherData = JSON.parse(selectedOption.getAttribute('data-teacher-data'));
            const teacherId = selectedOption.value;
            
            // Populate main form fields
            document.getElementById('name').value = teacherData.full_name_en || teacherData.full_name_bn || '';
            document.getElementById('email').value = teacherData.email || '';
            document.getElementById('phone').value = teacherData.mobile || '';
            
            // Lock the populated fields
            lockField('name');
            lockField('email');
            lockField('phone');
            
            // Show auto-populated controls
            showAutoPopulatedControls();
            
            // Remove existing teacher hidden fields
            document.querySelectorAll('input[name^="teacher"]').forEach(field => field.remove());
            
            // Create hidden field with existing teacher ID (for linking, not creating new record)
            const teacherIdField = document.createElement('input');
            teacherIdField.type = 'hidden';
            teacherIdField.name = 'teacher_id';
            teacherIdField.value = teacherId;
            form.appendChild(teacherIdField);
            
            showNotification('Teacher data populated successfully! Fields are locked to prevent accidental changes.', 'success');
        } catch (error) {
            console.error('Error parsing teacher data:', error);
            showNotification('Error populating teacher data', 'error');
        }
    }

    // Reusable function to populate student data
    function populateStudentData(selectedOption) {
        try {
            const studentData = JSON.parse(selectedOption.getAttribute('data-student-data'));
            const studentId = selectedOption.value;
            
            // Populate main form fields
            document.getElementById('name').value = studentData.full_name || '';
            document.getElementById('email').value = studentData.email || '';
            document.getElementById('phone').value = studentData.phone || '';
            
            // Lock the populated fields
            lockField('name');
            lockField('email');
            lockField('phone');
            
            // Show auto-populated controls
            showAutoPopulatedControls();
            
            // Remove existing student hidden fields
            document.querySelectorAll('input[name^="student"]').forEach(field => field.remove());
            
            // Create hidden field with existing student ID (for linking, not creating new record)
            const studentIdField = document.createElement('input');
            studentIdField.type = 'hidden';
            studentIdField.name = 'student_id';
            studentIdField.value = studentId;
            form.appendChild(studentIdField);
            
            showNotification('Student data populated successfully! Fields are locked to prevent accidental changes.', 'success');
        } catch (error) {
            console.error('Error parsing student data:', error);
            showNotification('Error populating student data', 'error');
        }
    }
    
    // Event listeners for unlock buttons
    document.getElementById('name_unlock_btn').addEventListener('click', function() {
        unlockField('name');
        showNotification('Name field unlocked for editing', 'info');
    });
    
    document.getElementById('email_unlock_btn').addEventListener('click', function() {
        unlockField('email');
        showNotification('Email field unlocked for editing', 'info');
    });
    
    document.getElementById('phone_unlock_btn').addEventListener('click', function() {
        unlockField('phone');
        showNotification('Phone field unlocked for editing', 'info');
    });
    
    // Event listener for clear auto-populated data button
    document.getElementById('clearAutoPopulatedBtn').addEventListener('click', function() {
        if (confirm('Are you sure you want to clear all auto-populated data? This will unlock all fields for manual editing.')) {
            clearAllAutoPopulatedData();
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
