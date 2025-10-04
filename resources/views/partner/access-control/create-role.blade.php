@extends('layouts.partner-layout')

@section('title', 'Create Role')

@section('content')
<div class="space-y-4 md:space-y-6" x-data="roleCreationManager()">
    <!-- Page Header -->
    <div class="bg-gradient-to-br from-green-900 via-teal-900 to-blue-900 rounded-2xl shadow-2xl p-4 md:p-6 lg:p-8">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <div class="flex-1">
                <div class="flex items-center space-x-3 mb-2">
                    <div class="bg-white/10 backdrop-blur-sm p-2 md:p-3 rounded-xl">
                        <svg class="w-6 h-6 md:w-8 md:h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path>
                        </svg>
                    </div>
                    <div>
                        <h1 class="text-2xl md:text-3xl lg:text-4xl font-bold text-white drop-shadow-lg">Create Role</h1>
                        <p class="text-slate-200 text-sm md:text-base">Define a new role with specific permissions</p>
                    </div>
                </div>
            </div>
            <div class="flex flex-wrap gap-2 sm:gap-3">
                <a href="{{ route('partner.access-control.index') }}" 
                   class="bg-white/20 hover:bg-white/30 text-white font-semibold px-4 md:px-6 py-2.5 md:py-3 rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 flex items-center space-x-2 group backdrop-blur-sm">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    <span>Back to Access Control</span>
                </a>
            </div>
        </div>
    </div>

    <!-- Role Creation Form -->
    <div class="bg-white dark:bg-gray-800 rounded-xl md:rounded-2xl shadow-lg border-2 border-gray-100 dark:border-gray-700">
        <div class="p-4 md:p-6 border-b border-gray-200 dark:border-gray-700">
            <div class="flex items-center space-x-2">
                <div class="bg-gradient-to-r from-green-600 to-teal-600 p-2 rounded-lg">
                    <svg class="w-4 h-4 md:w-5 md:h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                </div>
                <h2 class="text-base md:text-lg font-bold text-gray-900 dark:text-white">Role Information</h2>
            </div>
        </div>

        <form @submit.prevent="createRole()" class="p-4 md:p-6">
            <!-- Basic Information -->
            <div class="space-y-6 mb-8">
                <div>
                    <label for="role_name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Role Name <span class="text-red-500">*</span>
                    </label>
                    <input type="text" 
                           id="role_name" 
                           x-model="form.name"
                           class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent dark:bg-gray-700 dark:text-white transition-all duration-200"
                           placeholder="Enter role name"
                           required>
                    <div x-show="errors.name" class="mt-1 text-sm text-red-600" x-text="errors.name"></div>
                </div>

                <div>
                    <label for="role_description" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Description
                    </label>
                    <textarea 
                           id="role_description" 
                           x-model="form.description"
                           rows="3"
                           class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent dark:bg-gray-700 dark:text-white transition-all duration-200"
                           placeholder="Brief description of the role"></textarea>
                    <div x-show="errors.description" class="mt-1 text-sm text-red-600" x-text="errors.description"></div>
                </div>

                <div>
                    <label for="copy_from" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Copy Access Control From
                    </label>
                    <select 
                           id="copy_from" 
                           x-model="copyFromRole"
                           @change="handleCopyFromChange()"
                           class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent dark:bg-gray-700 dark:text-white transition-all duration-200">
                        <option value="">Manual Setup</option>
                        @foreach($existingRoles as $role)
                        <option value="{{ $role->id }}">{{ $role->name }}</option>
                        @endforeach
                    </select>
                    <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Select an existing role to copy its permissions, or choose "Manual Setup" to configure manually</p>
                </div>
            </div>

            <!-- Info Message -->
            <div class="mb-8 bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg p-4">
                <div class="flex items-start">
                    <svg class="w-5 h-5 text-blue-600 dark:text-blue-400 mt-0.5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <div>
                        <h4 class="text-sm font-semibold text-blue-900 dark:text-blue-200 mb-1">Permission Assignment</h4>
                        <p class="text-sm text-blue-800 dark:text-blue-300">
                            After creating the role, you can assign permissions from the Access Control page. 
                            If you selected "Copy Access Control From" above, permissions will be automatically copied from that role.
                        </p>
                    </div>
                </div>
            </div>

            <!-- Form Actions -->
            <div class="flex items-center justify-end space-x-3 pt-6 border-t border-gray-200 dark:border-gray-600">
                <a href="{{ route('partner.access-control.index') }}" 
                   class="px-6 py-3 text-sm font-medium text-gray-700 dark:text-gray-300 bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 rounded-lg transition-colors">
                    Cancel
                </a>
                <button type="submit" 
                        :disabled="loading"
                        class="px-8 py-3 text-sm font-medium text-white bg-green-600 hover:bg-green-700 disabled:opacity-50 disabled:cursor-not-allowed rounded-lg transition-colors">
                    <span x-show="!loading">Create Role</span>
                    <span x-show="loading" class="flex items-center">
                        <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        Creating...
                    </span>
                </button>
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
            description: '',
            permissions: []
        },
        errors: {},
        permissionConfig: @json($permissionConfig),
        existingRoles: @json($existingRoles),

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
