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
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
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
                    <input type="text" 
                           id="role_description" 
                           x-model="form.description"
                           class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent dark:bg-gray-700 dark:text-white transition-all duration-200"
                           placeholder="Brief description of the role">
                    <div x-show="errors.description" class="mt-1 text-sm text-red-600" x-text="errors.description"></div>
                </div>
            </div>

            <!-- Permissions Selection -->
            <div class="mb-8">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Permissions</h3>
                    <div class="flex items-center space-x-4">
                        <button type="button" 
                                @click="selectAllPermissions()"
                                class="text-sm text-green-600 hover:text-green-800 font-medium">
                            Select All
                        </button>
                        <button type="button" 
                                @click="deselectAllPermissions()"
                                class="text-sm text-red-600 hover:text-red-800 font-medium">
                            Deselect All
                        </button>
                    </div>
                </div>

                <div class="space-y-6">
                    @foreach($permissionConfig as $menuKey => $menuConfig)
                    <div class="bg-gray-50 dark:bg-gray-700 rounded-xl p-4">
                        <div class="flex items-center justify-between mb-4">
                            <h4 class="text-lg font-semibold text-gray-900 dark:text-white">{{ $menuConfig['label'] }}</h4>
                            <div class="flex items-center space-x-2">
                                <label class="flex items-center">
                                    <input type="checkbox" 
                                           @change="toggleModulePermissions('{{ $menuKey }}', $event.target.checked)"
                                           :checked="isModuleFullySelected('{{ $menuKey }}')"
                                           class="rounded border-gray-300 text-green-600 shadow-sm focus:border-green-300 focus:ring focus:ring-green-200 focus:ring-opacity-50">
                                    <span class="ml-2 text-sm text-gray-700 dark:text-gray-300">Select All</span>
                                </label>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-3">
                            <!-- Menu Permission -->
                            <label class="flex items-center p-3 bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-600 hover:bg-gray-50 dark:hover:bg-gray-750 transition-colors cursor-pointer">
                                <input type="checkbox" 
                                       name="permissions[]"
                                       value="menu-{{ $menuKey }}"
                                       x-model="form.permissions"
                                       class="rounded border-gray-300 text-green-600 shadow-sm focus:border-green-300 focus:ring focus:ring-green-200 focus:ring-opacity-50">
                                <div class="ml-3">
                                    <div class="text-sm font-medium text-gray-900 dark:text-white">Menu Access</div>
                                    <div class="text-xs text-gray-500 dark:text-gray-400">menu-{{ $menuKey }}</div>
                                </div>
                            </label>

                            <!-- Button Permissions -->
                            @foreach($menuConfig['buttons'] as $buttonKey => $buttonLabel)
                            <label class="flex items-center p-3 bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-600 hover:bg-gray-50 dark:hover:bg-gray-750 transition-colors cursor-pointer">
                                <input type="checkbox" 
                                       name="permissions[]"
                                       value="{{ $menuKey }}-{{ $buttonKey }}"
                                       x-model="form.permissions"
                                       class="rounded border-gray-300 text-green-600 shadow-sm focus:border-green-300 focus:ring focus:ring-green-200 focus:ring-opacity-50">
                                <div class="ml-3">
                                    <div class="text-sm font-medium text-gray-900 dark:text-white">{{ $buttonLabel }}</div>
                                    <div class="text-xs text-gray-500 dark:text-gray-400">{{ $menuKey }}-{{ $buttonKey }}</div>
                                </div>
                            </label>
                            @endforeach
                        </div>
                    </div>
                    @endforeach
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
        form: {
            name: '',
            description: '',
            permissions: []
        },
        errors: {},
        permissionConfig: @json($permissionConfig),

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
