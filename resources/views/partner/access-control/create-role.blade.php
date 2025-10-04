@extends('layouts.partner-layout')

@section('title', 'Create Role')

@push('styles')
<style>
    .form-input {
        transition: all 0.2s ease-in-out;
    }
    .form-input:focus {
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(59, 130, 246, 0.15);
    }
    .form-card {
        transition: all 0.2s ease-in-out;
    }
    .form-card:hover {
        box-shadow: 0 8px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
    }
</style>
@endpush

@section('content')
<div class="min-h-screen bg-gray-50 dark:bg-gray-900" x-data="roleCreationManager()">
    <!-- Mobile-First Header -->
    <div class="bg-white dark:bg-gray-800 shadow-sm border-b border-gray-200 dark:border-gray-700">
        <div class="px-4 py-6 sm:px-6 lg:px-8">
            <!-- Mobile Header -->
            <div class="flex items-center justify-between mb-4 sm:hidden">
                <div class="flex items-center space-x-3">
                    <div class="p-2 bg-green-50 dark:bg-green-900/30 rounded-lg">
                        <svg class="w-6 h-6 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path>
                        </svg>
                    </div>
                    <div>
                        <h1 class="text-xl font-bold text-gray-900 dark:text-white">Create Role</h1>
                        <p class="text-sm text-gray-600 dark:text-gray-400">Define new role permissions</p>
                    </div>
                </div>
                <a href="{{ route('partner.settings.index') }}" 
                   class="p-2 bg-gray-100 hover:bg-gray-200 dark:bg-gray-700 dark:hover:bg-gray-600 text-gray-800 dark:text-gray-200 rounded-lg shadow-sm transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                </a>
            </div>

            <!-- Desktop Header -->
            <div class="hidden sm:flex items-center justify-between">
                <div class="flex items-center space-x-4">
                    <div class="p-3 bg-gradient-to-br from-green-500 to-emerald-600 rounded-xl shadow-lg">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path>
                        </svg>
                    </div>
                    <div>
                        <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Create New Role</h1>
                        <p class="text-gray-600 dark:text-gray-400 mt-1">Define a new role with specific permissions</p>
                    </div>
                </div>
                <a href="{{ route('partner.settings.index') }}" 
                   class="inline-flex items-center space-x-2 bg-gray-100 hover:bg-gray-200 dark:bg-gray-700 dark:hover:bg-gray-600 text-gray-800 dark:text-gray-200 font-medium px-6 py-3 rounded-lg shadow-sm hover:shadow-md transition-all duration-200">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    <span>Back to Settings</span>
                </a>
            </div>

            <!-- Mobile Description -->
            <p class="text-sm text-gray-600 dark:text-gray-400 mt-2 sm:hidden">Define a new role with specific permissions</p>
        </div>
    </div>

    <!-- Main Content -->
    <div class="px-4 py-6 sm:px-6 lg:px-8">
        <!-- Role Creation Form -->
        <form @submit.prevent="createRole()" class="space-y-6">
            <!-- Basic Information Card -->
            <div class="form-card bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
                <div class="bg-gray-50 dark:bg-gray-700 px-4 py-4 sm:px-6 border-b border-gray-200 dark:border-gray-600">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-3">
                            <div class="p-2 bg-green-50 dark:bg-green-900/30 rounded-lg">
                                <svg class="w-5 h-5 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                            </div>
                            <h2 class="text-lg font-semibold text-gray-900 dark:text-white">Role Information</h2>
                        </div>
                        <div class="flex items-center space-x-3">
                            <a href="{{ route('partner.settings.index') }}" 
                               class="px-4 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 rounded-lg transition-colors">
                                Cancel
                            </a>
                            <button type="submit" 
                                    :disabled="loading"
                                    class="px-6 py-2 text-sm font-medium text-white bg-green-600 hover:bg-green-700 disabled:opacity-50 disabled:cursor-not-allowed rounded-lg transition-colors shadow-sm hover:shadow-md">
                                <span x-show="!loading" class="flex items-center">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                    </svg>
                                    Create Role
                                </span>
                                <span x-show="loading" class="flex items-center">
                                    <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 718-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 714 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                    </svg>
                                    Creating...
                                </span>
                            </button>
                        </div>
                    </div>
                </div>

                <div class="p-4 sm:p-6 space-y-6">
                    <!-- Hidden role name field - auto-generated from display name -->
                    <input type="hidden" 
                           id="role_name" 
                           x-model="form.name">

                    <div>
                        <label for="role_display_name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Role Name <span class="text-red-500">*</span>
                        </label>
                        <input type="text" 
                               id="role_display_name" 
                               x-model="form.display_name"
                               @input="updateRoleName()"
                               class="form-input w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent dark:bg-gray-700 dark:text-white"
                               placeholder="Enter role name (e.g., Content Manager, Teacher Assistant)"
                               required>
                        <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">
                            <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            System name will be auto-generated: <span x-text="form.name || 'role_name_here'" class="font-mono text-blue-600 dark:text-blue-400"></span>
                        </p>
                        <div x-show="errors.display_name" class="mt-2 text-sm text-red-600" x-text="errors.display_name"></div>
                        <div x-show="errors.name" class="mt-2 text-sm text-red-600" x-text="errors.name"></div>
                    </div>

                    <div>
                        <label for="role_description" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Description
                        </label>
                        <textarea 
                               id="role_description" 
                               x-model="form.description"
                               rows="3"
                               class="form-input w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent dark:bg-gray-700 dark:text-white resize-none"
                               placeholder="Brief description of what this role can do"></textarea>
                        <div x-show="errors.description" class="mt-2 text-sm text-red-600" x-text="errors.description"></div>
                    </div>

                    <div>
                        <label for="copy_from" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Copy Permission From
                        </label>
                        <select 
                               id="copy_from" 
                               x-model="copyFromRole"
                               @change="handleCopyFromChange()"
                               class="form-input w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent dark:bg-gray-700 dark:text-white">
                            <option value="">Start with blank permissions</option>
                            @foreach($existingRoles as $role)
                            <option value="{{ $role->id }}">{{ $role->display_name ?? ucwords(str_replace('_', ' ', $role->name)) }}</option>
                            @endforeach
                        </select>
                        <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">
                            <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            You can copy permissions from an existing role or start fresh and configure manually
                        </p>
                    </div>
                </div>
            </div>

            <!-- Info Card -->
            <div class="bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-xl p-4 sm:p-6">
                <div class="flex items-start space-x-3">
                    <div class="p-2 bg-blue-100 dark:bg-blue-900/30 rounded-lg flex-shrink-0">
                        <svg class="w-5 h-5 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div>
                        <h4 class="text-sm font-semibold text-blue-900 dark:text-blue-200 mb-2">Next Steps</h4>
                        <p class="text-sm text-blue-800 dark:text-blue-300 leading-relaxed">
                            After creating the role, you can assign specific permissions from the Access Control page. 
                            If you selected a role to copy from above, those permissions will be automatically applied to your new role.
                        </p>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
function roleCreationManager() {
    return {
        loading: false,
        copyFromRole: '',
        form: {
            name: '',
            display_name: '',
            description: '',
            permissions: []
        },
        errors: {},
        permissionConfig: @json($permissionConfig),
        existingRoles: @json($existingRoles),

        updateRoleName() {
            // Convert display name to lowercase role name
            // Remove special characters, replace spaces with underscores
            if (this.form.display_name) {
                this.form.name = this.form.display_name
                    .toLowerCase()
                    .replace(/[^a-z0-9\s]/g, '') // Remove special characters except spaces
                    .trim()
                    .replace(/\s+/g, '_'); // Replace spaces with underscores
            } else {
                this.form.name = '';
            }
        },

        async createRole() {
            this.loading = true;
            this.errors = {};
            
            try {
                const response = await fetch('{{ route("partner.access-control.store-role") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify(this.form)
                });
                
                const data = await response.json();
                
                if (data.success) {
                    alert('Role created successfully');
                    window.location.href = data.redirect;
                } else {
                    if (data.errors) {
                        this.errors = data.errors;
                    } else {
                        alert(data.message || 'Error creating role');
                    }
                }
            } catch (error) {
                console.error('Error creating role:', error);
                alert('Error creating role');
            } finally {
                this.loading = false;
            }
        },

        selectAllPermissions() {
            this.form.permissions = [];
            Object.keys(this.permissionConfig).forEach(menuKey => {
                const menuConfig = this.permissionConfig[menuKey];
                
                // Add menu permission
                this.form.permissions.push(`menu-${menuKey}`);
                
                // Add button permissions
                Object.keys(menuConfig.buttons).forEach(buttonKey => {
                    this.form.permissions.push(`${menuKey}-${buttonKey}`);
                });
            });
        },

        deselectAllPermissions() {
            this.form.permissions = [];
        },

        handleCopyFromChange() {
            if (!this.copyFromRole) {
                // Manual setup - clear permissions
                this.form.permissions = [];
                return;
            }

            // Find the selected role
            const selectedRole = this.existingRoles.find(role => role.id == this.copyFromRole);
            if (selectedRole && selectedRole.permissions) {
                // Copy all permissions from the selected role
                this.form.permissions = selectedRole.permissions.map(p => p.name);
            }
        },

        isModuleFullySelected(moduleKey) {
            const menuConfig = this.permissionConfig[moduleKey];
            if (!menuConfig) return false;
            
            const modulePermissions = [`menu-${moduleKey}`];
            Object.keys(menuConfig.buttons).forEach(buttonKey => {
                modulePermissions.push(`${moduleKey}-${buttonKey}`);
            });
            
            return modulePermissions.every(permission => 
                this.form.permissions.includes(permission)
            );
        },

        toggleModulePermissions(moduleKey, selected) {
            const menuConfig = this.permissionConfig[moduleKey];
            if (!menuConfig) return;
            
            const modulePermissions = [`menu-${moduleKey}`];
            Object.keys(menuConfig.buttons).forEach(buttonKey => {
                modulePermissions.push(`${moduleKey}-${buttonKey}`);
            });
            
            if (selected) {
                // Add all module permissions
                modulePermissions.forEach(permission => {
                    if (!this.form.permissions.includes(permission)) {
                        this.form.permissions.push(permission);
                    }
                });
            } else {
                // Remove all module permissions
                this.form.permissions = this.form.permissions.filter(permission => 
                    !modulePermissions.includes(permission)
                );
            }
        }
    }
}
</script>
@endsection
