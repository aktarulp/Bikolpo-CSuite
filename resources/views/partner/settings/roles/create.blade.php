@extends('layouts.partner-layout')

@section('title', 'Create New Role')

@section('styles')
<style>
    /* Only keeping essential animations that aren't available in Tailwind */
    .loading-spinner {
        border: 3px solid #f3f3f3;
        border-top: 3px solid #6366f1;
        border-radius: 50%;
        width: 24px;
        height: 24px;
        animation: spin 1s linear infinite;
    }
    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }
</style>
@endsection

@section('content')
<div class="min-h-screen bg-gray-50 dark:bg-gray-900">
    <!-- Mobile Header -->
    <div class="lg:hidden bg-white dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700 px-4 py-3">
        <div class="flex items-center justify-between">
            <div class="flex items-center space-x-3">
                <a href="{{ route('partner.settings.role-permission-management') }}" class="text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                    </svg>
                </a>
                <h1 class="text-lg font-semibold text-gray-900 dark:text-white">Create Role</h1>
            </div>
        </div>
    </div>

    <!-- Desktop Header -->
    <div class="hidden lg:block bg-white dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16">
                <div class="flex items-center space-x-4">
                    <a href="{{ route('partner.settings.role-permission-management') }}" class="text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                        </svg>
                    </a>
                    <div>
                        <nav class="flex" aria-label="Breadcrumb">
                            <ol class="inline-flex items-center space-x-1 md:space-x-2">
                                <li class="inline-flex items-center">
                                    <a href="{{ route('partner.settings.role-permission-management') }}" class="text-sm text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-300">
                                        Role Management
                                    </a>
                                </li>
                                <li>
                                    <div class="flex items-center">
                                        <svg class="w-4 h-4 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                                        </svg>
                                        <span class="ml-1 text-sm font-medium text-gray-900 dark:text-white">Create Role</span>
                                    </div>
                                </li>
                            </ol>
                        </nav>
                        <h1 class="text-xl font-bold text-gray-900 dark:text-white">Create New Role</h1>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-6 lg:py-8">
        <!-- Form Container -->
        <form id="createRoleForm" class="space-y-6">

            <!-- Basic Information Card -->
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
                <div class="px-4 sm:px-6 py-4 bg-gradient-to-r from-indigo-50 to-purple-50 dark:from-indigo-900/20 dark:to-purple-900/20 border-b border-gray-200 dark:border-gray-700">
                    <div class="flex items-center space-x-3">
                        <div class="flex-shrink-0 w-10 h-10 bg-indigo-600 dark:bg-indigo-500 rounded-lg flex items-center justify-center">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Basic Information</h3>
                            <p class="text-sm text-gray-600 dark:text-gray-400">Configure the fundamental properties of the role</p>
                        </div>
                    </div>
                </div>
                <div class="p-4 sm:p-6 space-y-4">
                    <!-- Hidden Role Name Field -->
                    <input type="text" class="hidden" id="roleName" name="name" readonly>
                    
                    <!-- Role Display Name -->
                    <div>
                        <label for="roleDisplayName" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Role Name <span class="text-red-500">*</span>
                        </label>
                        <input type="text" class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-white transition-colors duration-200" id="roleDisplayName" name="display_name" required
                               placeholder="e.g., Senior Manager, Content Editor">
                        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Human-readable name for the role</p>
                    </div>
                    
                    <!-- Description -->
                    <div>
                        <label for="roleDescription" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Description</label>
                        <textarea class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-white transition-colors duration-200" id="roleDescription" name="description" rows="3"
                              placeholder="Describe the role's purpose and responsibilities..."></textarea>
                    </div>
                </div>
            </div>

            <!-- Role Configuration Card -->
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
                <div class="px-4 sm:px-6 py-4 bg-gradient-to-r from-blue-50 to-cyan-50 dark:from-blue-900/20 dark:to-cyan-900/20 border-b border-gray-200 dark:border-gray-700">
                    <div class="flex items-center space-x-3">
                        <div class="flex-shrink-0 w-10 h-10 bg-blue-600 dark:bg-blue-500 rounded-lg flex items-center justify-center">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Role Configuration</h3>
                            <p class="text-sm text-gray-600 dark:text-gray-400">Set the role's level and hierarchy settings</p>
                        </div>
                    </div>
                </div>
                <div class="p-4 sm:p-6">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <!-- Role Level -->
                        <div>
                            <label for="roleLevel" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Role Level <span class="text-red-500">*</span>
                            </label>
                            <select class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white transition-colors duration-200" id="roleLevel" name="level" required>
                                <option value="">Select Level</option>
                                <option value="3">3 - Student/Teacher/Operator Level</option>
                                <option value="4">4 - Custom Level</option>
                                <option value="5">5 - Custom Level</option>
                            </select>
                            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Higher numbers = lower privileges</p>
                        </div>
                        
                        <!-- Status -->
                        <div>
                            <label for="roleStatus" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Status</label>
                            <select class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white transition-colors duration-200" id="roleStatus" name="status">
                                <option value="active">Active</option>
                                <option value="inactive">Inactive</option>
                            </select>
                        </div>
                        
                        <!-- Parent Role -->
                        <div>
                            <label for="roleParent" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Parent Role</label>
                            <select class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white transition-colors duration-200" id="roleParent" name="parent_role_id">
                                @foreach($roles as $role)
                                    <option value="{{ $role->id }}">{{ $role->display_name }} (Level {{ $role->level }})</option>
                                @endforeach
                            </select>
                            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Roles this role inherits from</p>
                        </div>
                        
                        <!-- Inherit Permissions -->
                        <div>
                            <label for="inheritPermissions" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Inherit Permissions</label>
                            <select class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white transition-colors duration-200" id="inheritPermissions" name="inherit_permissions">
                                <option value="0">No - Manual permission assignment only</option>
                                <option value="1">Yes - Inherit from parent roles</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Permissions Card -->
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
                <div class="px-4 sm:px-6 py-4 bg-gradient-to-r from-green-50 to-emerald-50 dark:from-green-900/20 dark:to-emerald-900/20 border-b border-gray-200 dark:border-gray-700">
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between space-y-3 sm:space-y-0">
                        <div class="flex items-center space-x-3">
                            <div class="flex-shrink-0 w-10 h-10 bg-green-600 dark:bg-green-500 rounded-lg flex items-center justify-center">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"></path>
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Permissions</h3>
                                <p class="text-sm text-gray-600 dark:text-gray-400">Assign specific permissions to this role</p>
                            </div>
                        </div>
                        <div class="flex items-center space-x-2">
                            <button type="button" onclick="selectAllPermissions()" class="inline-flex items-center px-3 py-1.5 text-xs font-medium text-green-700 bg-green-100 hover:bg-green-200 dark:text-green-300 dark:bg-green-800/50 dark:hover:bg-green-700/50 rounded-lg transition-colors duration-200">
                                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                Select All
                            </button>
                            <button type="button" onclick="clearAllPermissions()" class="inline-flex items-center px-3 py-1.5 text-xs font-medium text-gray-700 bg-gray-100 hover:bg-gray-200 dark:text-gray-300 dark:bg-gray-700 dark:hover:bg-gray-600 rounded-lg transition-colors duration-200">
                                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                                Clear All
                            </button>
                        </div>
                    </div>
                </div>
                <div class="p-4 sm:p-6">
                    <div class="space-y-4 max-h-96 overflow-y-auto" id="permissionsContainer">
                        @foreach($permissions->groupBy('module') as $module => $modulePermissions)
                            <div class="border border-gray-200 dark:border-gray-600 rounded-lg p-4">
                                <div class="flex items-center justify-between mb-3">
                                    <h4 class="text-sm font-semibold text-gray-900 dark:text-white flex items-center">
                                        <svg class="w-4 h-4 mr-2 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                                        </svg>
                                        {{ $module }}
                                    </h4>
                                    <span class="inline-flex items-center px-2 py-1 text-xs font-medium bg-green-100 dark:bg-green-800/50 text-green-800 dark:text-green-200 rounded-full">
                                        {{ $modulePermissions->count() }} permissions
                                    </span>
                                </div>
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-2">
                                    @foreach($modulePermissions as $permission)
                                        <label class="flex items-start p-3 bg-gray-50 dark:bg-gray-700/50 rounded-lg border border-gray-200 dark:border-gray-600 hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors duration-200 cursor-pointer">
                                            <input type="checkbox" class="w-4 h-4 text-green-600 bg-gray-100 border-gray-300 rounded focus:ring-green-500 dark:focus:ring-green-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600 mt-0.5 mr-3" name="permission_ids[]" value="{{ $permission->id }}">
                                            <div class="flex-1 min-w-0">
                                                <div class="font-medium text-gray-900 dark:text-white text-sm">{{ $permission->display_name }}</div>
                                                <div class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">{{ $permission->description }}</div>
                                            </div>
                                        </label>
                                    @endforeach
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Form Actions -->
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-end space-y-3 sm:space-y-0 sm:space-x-3 pt-6 border-t border-gray-200 dark:border-gray-700">
                <a href="{{ route('partner.settings.role-permission-management') }}" class="inline-flex items-center justify-center px-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 dark:focus:ring-offset-gray-900 transition-colors duration-200">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                    Cancel
                </a>
                <button type="submit" class="inline-flex items-center justify-center px-6 py-2.5 border border-transparent rounded-lg text-sm font-medium text-white bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-900 transition-all duration-200 shadow-sm hover:shadow-md">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                    Create Role
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Loading Overlay -->
<div id="loadingOverlay" class="fixed inset-0 bg-gray-900 bg-opacity-50 hidden flex items-center justify-center z-50 backdrop-blur-sm">
    <div class="bg-white dark:bg-gray-800 rounded-2xl p-6 flex items-center space-x-4 shadow-2xl border border-gray-200 dark:border-gray-700">
        <div class="loading-spinner"></div>
        <span class="text-gray-900 dark:text-white font-medium">Creating role...</span>
    </div>
</div>
@endsection

@section('scripts')
<script>
// Initialize form
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('createRoleForm');
    const loadingOverlay = document.getElementById('loadingOverlay');

    // Form submission
    form.addEventListener('submit', function(e) {
        e.preventDefault();

        // Validate required fields
        const displayName = document.getElementById('roleDisplayName').value.trim();
        const roleLevel = document.getElementById('roleLevel').value;
        
        if (!displayName) {
            showToast('Please enter a role name', 'error');
            return;
        }
        
        if (!roleLevel) {
            showToast('Please select a role level', 'error');
            return;
        }

        // Show loading overlay
        loadingOverlay.classList.remove('hidden');

        // Collect form data
        const formData = new FormData(form);
        const data = {};

        // Convert FormData to object
        for (let [key, value] of formData.entries()) {
            if (key === 'permission_ids[]') {
                if (!data.permission_ids) {
                    data.permission_ids = [];
                }
                data.permission_ids.push(parseInt(value));
            } else if (key === 'inherit_permissions') {
                data.inherit_permissions = value === '1';
            } else {
                data[key] = value;
            }
        }

        // Add required fields
        data.is_system = false;

        console.log('Creating role with data:', data);

        // Submit the form
        fetch('/roles', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify(data)
        })
        .then(response => response.json())
        .then(data => {
            loadingOverlay.classList.add('hidden');

            if (data.success) {
                showToast('✅ Role created successfully!', 'success');
                setTimeout(() => {
                    window.location.href = '{{ route("partner.settings.role-permission-management") }}';
                }, 1500);
            } else {
                showToast('❌ Error: ' + (data.message || 'Unknown error occurred'), 'error');
            }
        })
        .catch(error => {
            loadingOverlay.classList.add('hidden');
            console.error('Error:', error);
            showToast('❌ An error occurred while creating the role', 'error');
        });
    });
});

// Permission selection helpers
function selectAllPermissions() {
    document.querySelectorAll('input[name="permission_ids[]"]').forEach(checkbox => {
        checkbox.checked = true;
    });
    showToast('✅ All permissions selected', 'success');
}

function clearAllPermissions() {
    document.querySelectorAll('input[name="permission_ids[]"]').forEach(checkbox => {
        checkbox.checked = false;
    });
    showToast('🗑️ All permissions cleared', 'info');
}

// Enhanced toast notification system
function showToast(message, type = 'info') {
    // Create toast container if it doesn't exist
    let toastContainer = document.getElementById('toastContainer');
    if (!toastContainer) {
        toastContainer = document.createElement('div');
        toastContainer.id = 'toastContainer';
        toastContainer.className = 'fixed top-4 right-4 z-50 space-y-3';
        document.body.appendChild(toastContainer);
    }

    const toastId = 'toast-' + Date.now();
    const bgClass = type === 'success' ? 'bg-green-600' : type === 'error' ? 'bg-red-600' : 'bg-blue-600';
    const iconClass = type === 'success' ? '✅' : type === 'error' ? '❌' : 'ℹ️';

    const toastHTML = `
        <div id="${toastId}" class="flex items-center p-4 rounded-xl shadow-lg ${bgClass} text-white transform transition-all duration-300 translate-x-full opacity-0 backdrop-blur-sm">
            <span class="text-lg mr-3">${iconClass}</span>
            <div class="flex-1 font-medium">${message}</div>
            <button type="button" class="ml-4 text-white hover:text-gray-200 focus:outline-none transition-colors duration-200" onclick="hideToast('${toastId}')">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>
    `;

    toastContainer.insertAdjacentHTML('beforeend', toastHTML);

    // Animate in
    setTimeout(() => {
        const toastElement = document.getElementById(toastId);
        if (toastElement) {
            toastElement.classList.remove('translate-x-full', 'opacity-0');
            toastElement.classList.add('translate-x-0', 'opacity-100');
        }
    }, 100);

    // Auto-hide after 4 seconds
    setTimeout(() => {
        hideToast(toastId);
    }, 4000);
}

function hideToast(toastId) {
    const toastElement = document.getElementById(toastId);
    if (toastElement) {
        toastElement.classList.add('translate-x-full', 'opacity-0');
        toastElement.classList.remove('translate-x-0', 'opacity-100');
        setTimeout(() => {
            toastElement.remove();
        }, 300);
    }
}

// Auto-generate role name from display name
document.getElementById('roleDisplayName').addEventListener('input', function(e) {
    const displayName = this.value;
    const roleNameField = document.getElementById('roleName');

    if (displayName.trim()) {
        // Convert display name to role name format
        const roleName = displayName
            .toLowerCase()
            .replace(/[^a-z0-9\s]/g, '') // Remove special characters except spaces
            .replace(/\s+/g, '_') // Replace spaces with underscores
            .replace(/__+/g, '_') // Replace multiple underscores with single
            .replace(/^_|_$/g, ''); // Remove leading/trailing underscores

        roleNameField.value = roleName;
    } else {
        roleNameField.value = '';
    }
});

document.getElementById('inheritPermissions').addEventListener('change', function(e) {
    const permissionsSection = document.querySelector('#permissionsContainer');
    if (this.value === '1') {
        // If inheriting permissions, disable permission selection
        document.querySelectorAll('input[name="permission_ids[]"]').forEach(checkbox => {
            checkbox.checked = false;
            checkbox.disabled = true;
        });
        
        // Show info message
        if (!document.getElementById('inheritanceInfo')) {
            const info = document.createElement('div');
            info.id = 'inheritanceInfo';
            info.className = 'mt-4 p-4 bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-xl';
            info.innerHTML = `
                <div class="flex items-start space-x-3">
                    <svg class="w-5 h-5 text-blue-600 dark:text-blue-400 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <div>
                        <p class="text-sm font-medium text-blue-800 dark:text-blue-300">Permission Inheritance Enabled</p>
                        <p class="text-sm text-blue-700 dark:text-blue-400 mt-1">This role will inherit permissions from its parent roles. Manual permission assignment is disabled.</p>
                    </div>
                </div>
            `;
            permissionsSection.parentNode.insertBefore(info, permissionsSection);
        }
    } else {
        // If not inheriting, enable permission selection
        document.querySelectorAll('input[name="permission_ids[]"]').forEach(checkbox => {
            checkbox.disabled = false;
        });
        
        // Remove info message
        const info = document.getElementById('inheritanceInfo');
        if (info) {
            info.remove();
        }
    }
});

// Add input field animations
document.querySelectorAll('input, textarea, select').forEach(field => {
    field.addEventListener('focus', function() {
        this.parentElement.classList.add('transform', 'scale-105');
    });
    
    field.addEventListener('blur', function() {
        this.parentElement.classList.remove('transform', 'scale-105');
    });
});
</script>
@endsection
