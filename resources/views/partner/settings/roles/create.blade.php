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
<div class="flex-1 overflow-y-auto custom-scrollbar p-4 lg:p-8">
    <!-- Header Section -->
    <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4 mb-8">
        <div>
            <nav class="flex mb-4" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-1 md:space-x-3">
                    <li class="inline-flex items-center">
                        <a href="{{ route('partner.settings.role-permission-management') }}" class="text-gray-700 hover:text-indigo-600 dark:text-gray-400 dark:hover:text-white">
                            <i class="fas fa-cog mr-2"></i>Role & Permission Management
                        </a>
                    </li>
                    <li>
                        <div class="flex items-center">
                            <i class="fas fa-chevron-right text-gray-400 mx-1"></i>
                            <span class="text-gray-500 dark:text-gray-400">Create Role</span>
                        </div>
                    </li>
                </ol>
            </nav>
            <h1 class="text-2xl lg:text-3xl font-bold text-gray-900 dark:text-white mb-2">Create New Role</h1>
            <p class="text-gray-600 dark:text-gray-400">Define a new role with specific permissions and hierarchy settings</p>
        </div>
        <div class="flex flex-col sm:flex-row gap-3">
            <a href="{{ route('partner.settings.role-permission-management') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors duration-200">
                <i class="fas fa-arrow-left mr-2"></i>Back to Roles
            </a>
        </div>
    </div>

    <!-- Create Role Form -->
    <form id="createRoleForm" class="max-w-4xl">
        <!-- Basic Information Section -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700">
            <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white flex items-center">
                    <i class="fas fa-info-circle mr-2 text-indigo-600"></i>Basic Information
                </h3>
                <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">Configure the fundamental properties of the role</p>
            </div>
            <div class="mb-6 p-6 border-b border-gray-200 dark:border-gray-700 last:border-b-0">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="mb-4 hidden">
                        <label for="roleName" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Role Name <span class="text-red-500">*</span>
                        </label>
                        <input type="text" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white" id="roleName" name="name" required
                               placeholder="Auto-generated from display name" readonly>
                        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Auto-generated from display name (lowercase, no spaces)</p>
                    </div>
                    <div class="mb-4">
                        <label for="roleDisplayName" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Display Name <span class="text-red-500">*</span>
                        </label>
                        <input type="text" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white" id="roleDisplayName" name="display_name" required
                               placeholder="e.g., Senior Manager, Content Editor">
                        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Human-readable name</p>
                    </div>
                </div>
                <div class="mb-4">
                    <label for="roleDescription" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Description</label>
                    <textarea class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white" id="roleDescription" name="description" rows="3"
                              placeholder="Describe the role's purpose and responsibilities..."></textarea>
                </div>
            </div>
        </div>

        <!-- Role Configuration Section -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700">
            <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white flex items-center">
                    <i class="fas fa-cogs mr-2 text-indigo-600"></i>Role Configuration
                </h3>
                <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">Set the role's level and hierarchy settings</p>
            </div>
            <div class="mb-6 p-6 border-b border-gray-200 dark:border-gray-700 last:border-b-0">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="mb-4">
                        <label for="roleLevel" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Role Level <span class="text-red-500">*</span>
                        </label>
                        <select class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white" id="roleLevel" name="level" required>
                            <option value="">Select Level</option>
                            <option value="3">3 - Student/Teacher/Operator Level</option>
                            <option value="4">4 - Custom Level</option>
                            <option value="5">5 - Custom Level</option>
                        </select>
                        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Higher numbers = lower privileges</p>
                    </div>
                    <div class="mb-4">
                        <label for="roleStatus" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Status</label>
                        <select class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white" id="roleStatus" name="status">
                            <option value="active">Active</option>
                            <option value="inactive">Inactive</option>
                        </select>
                    </div>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="mb-4">
                        <label for="roleParent" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Parent Role</label>
                        <select class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white" id="roleParent" name="parent_role_id">
                            <option value="">None (Root Role)</option>
                            @foreach($roles as $role)
                                <option value="{{ $role->id }}">{{ $role->display_name }} (Level {{ $role->level }})</option>
                            @endforeach
                        </select>
                        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Roles this role inherits from</p>
                    </div>
                    <div class="mb-4">
                        <label for="inheritPermissions" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Inherit Permissions</label>
                        <select class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white" id="inheritPermissions" name="inherit_permissions">
                            <option value="0">No - Manual permission assignment only</option>
                            <option value="1">Yes - Inherit from parent roles</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>

        <!-- Permissions Section -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700">
            <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white flex items-center">
                    <i class="fas fa-key mr-2 text-indigo-600"></i>Permissions
                </h3>
                <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">Assign specific permissions to this role</p>
            </div>
            <div class="mb-6 p-6 border-b border-gray-200 dark:border-gray-700 last:border-b-0">
                <div class="mb-4">
                    <div class="flex items-center justify-between mb-3">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Select Permissions</label>
                        <div class="flex items-center space-x-4 text-sm">
                            <button type="button" onclick="selectAllPermissions()" class="text-indigo-600 hover:text-indigo-800 dark:text-indigo-400 dark:hover:text-indigo-300">
                                Select All
                            </button>
                            <button type="button" onclick="clearAllPermissions()" class="text-gray-600 hover:text-gray-800 dark:text-gray-400 dark:hover:text-gray-300">
                                Clear All
                            </button>
                        </div>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-3 max-h-96 overflow-y-auto" id="permissionsContainer">
                        @foreach($permissions->groupBy('module') as $module => $modulePermissions)
                            <div class="mb-4">
                                <h5 class="text-sm font-medium text-gray-900 dark:text-white mb-2 flex items-center">
                                    <i class="fas fa-cube mr-2 text-indigo-600"></i>{{ $module }}
                                    <span class="ml-2 px-2 py-1 text-xs font-medium bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-gray-200 rounded-full">
                                        {{ $modulePermissions->count() }}
                                    </span>
                                </h5>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-2">
                                    @foreach($modulePermissions as $permission)
                                        <label class="flex items-center justify-between p-3 bg-gray-50 dark:bg-gray-700 rounded-lg border border-gray-200 dark:border-gray-600">
                                            <div class="flex-1">
                                                <div class="font-medium text-gray-900 dark:text-white text-sm">{{ $permission->display_name }}</div>
                                                <div class="text-xs text-gray-500 dark:text-gray-400">{{ $permission->description }}</div>
                                            </div>
                                            <input type="checkbox" class="w-4 h-4 text-indigo-600 bg-gray-100 border-gray-300 rounded focus:ring-indigo-500 dark:focus:ring-indigo-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600 ml-3" name="permission_ids[]" value="{{ $permission->id }}">
                                        </label>
                                    @endforeach
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        <!-- Form Actions -->
        <div class="flex justify-end space-x-3 pt-6 border-t border-gray-200 dark:border-gray-700">
            <a href="{{ route('partner.settings.role-permission-management') }}" class="px-4 py-2 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors duration-200">
                Cancel
            </a>
            <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent rounded-lg text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors duration-200">
                <i class="fas fa-save mr-2"></i>Create Role
            </button>
        </div>
    </form>
</div>

<!-- Loading Overlay -->
<div id="loadingOverlay" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden flex items-center justify-center z-50">
    <div class="bg-white dark:bg-gray-800 rounded-lg p-6 flex items-center space-x-4">
        <div class="loading-spinner"></div>
        <span class="text-gray-900 dark:text-white">Creating role...</span>
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
                showToast('Role created successfully!', 'success');
                setTimeout(() => {
                    window.location.href = '{{ route("partner.settings.role-permission-management") }}';
                }, 1500);
            } else {
                showToast('Error: ' + (data.message || 'Unknown error occurred'), 'error');
            }
        })
        .catch(error => {
            loadingOverlay.classList.add('hidden');
            console.error('Error:', error);
            showToast('An error occurred while creating the role', 'error');
        });
    });
});

// Permission selection helpers
function selectAllPermissions() {
    document.querySelectorAll('input[name="permission_ids[]"]').forEach(checkbox => {
        checkbox.checked = true;
    });
}

function clearAllPermissions() {
    document.querySelectorAll('input[name="permission_ids[]"]').forEach(checkbox => {
        checkbox.checked = false;
    });
}

// Toast notification system
function showToast(message, type = 'info') {
    // Create toast container if it doesn't exist
    let toastContainer = document.getElementById('toastContainer');
    if (!toastContainer) {
        toastContainer = document.createElement('div');
        toastContainer.id = 'toastContainer';
        toastContainer.className = 'fixed top-4 right-4 z-50 space-y-2';
        document.body.appendChild(toastContainer);
    }

    const toastId = 'toast-' + Date.now();
    const bgClass = type === 'success' ? 'bg-green-500' : type === 'error' ? 'bg-red-500' : 'bg-blue-500';

    const toastHTML = `
        <div id="${toastId}" class="flex items-center p-4 mb-4 text-white rounded-lg shadow-lg ${bgClass} transform transition-all duration-300 translate-x-full opacity-0">
            <i class="fas ${type === 'success' ? 'fa-check-circle' : type === 'error' ? 'fa-exclamation-circle' : 'fa-info-circle'} mr-3"></i>
            <div class="flex-1">${message}</div>
            <button type="button" class="ml-4 text-white hover:text-gray-200 focus:outline-none" onclick="hideToast('${toastId}')">
                <i class="fas fa-times"></i>
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

    // Auto-hide after 5 seconds
    setTimeout(() => {
        hideToast(toastId);
    }, 5000);
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

// Form validation
document.getElementById('roleName').addEventListener('input', function(e) {
    // Convert to lowercase and replace spaces with underscores
    this.value = this.value.toLowerCase().replace(/[^a-z0-9_]/g, '_');
});

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
    const permissionSection = document.querySelector('#permissionsContainer').closest('.mb-6');
    if (this.value === '1') {
        // If inheriting permissions, disable permission selection
        document.querySelectorAll('input[name="permission_ids[]"]').forEach(checkbox => {
            checkbox.disabled = true;
        });
        // Show info message
        if (!document.getElementById('inheritanceInfo')) {
            const info = document.createElement('div');
            info.id = 'inheritanceInfo';
            info.className = 'mt-2 p-3 bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg';
            info.innerHTML = '<i class="fas fa-info-circle text-blue-600 dark:text-blue-400 mr-2"></i><span class="text-sm text-blue-800 dark:text-blue-300">This role will inherit permissions from its parent roles. Manual permission assignment is disabled.</span>';
            this.closest('.mb-4').appendChild(info);
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
</script>
@endsection
