@extends('layouts.partner-layout')

@section('title', 'Access Control')

@section('content')
<div class="space-y-4 md:space-y-6" x-data="accessControlManager()">
    <!-- Page Header -->
    <div class="bg-gradient-to-br from-indigo-900 via-purple-900 to-pink-900 rounded-2xl shadow-2xl p-4 md:p-6 lg:p-8">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <div class="flex-1">
                <div class="flex items-center space-x-3 mb-2">
                    <div class="bg-white/10 backdrop-blur-sm p-2 md:p-3 rounded-xl">
                        <svg class="w-6 h-6 md:w-8 md:h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                        </svg>
                    </div>
                    <div>
                        <h1 class="text-2xl md:text-3xl lg:text-4xl font-bold text-white drop-shadow-lg">Access Control</h1>
                        <p class="text-slate-200 text-sm md:text-base">Manage roles and permissions</p>
                    </div>
                </div>
            </div>
            <div class="flex flex-wrap gap-2 sm:gap-3">
                @can('users-manage-roles')
                <a href="{{ route('partner.access-control.create-role') }}" 
                   class="bg-white hover:bg-slate-50 text-slate-900 font-semibold px-4 md:px-6 py-2.5 md:py-3 rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 flex items-center space-x-2 group">
                    <svg class="w-5 h-5 group-hover:rotate-90 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                    <span>Create Role</span>
                </a>
                @endcan
            </div>
        </div>
    </div>

    <!-- Roles Overview -->
    <div class="bg-white dark:bg-gray-800 rounded-xl md:rounded-2xl shadow-lg border-2 border-gray-100 dark:border-gray-700">
        <div class="p-4 md:p-6 border-b border-gray-200 dark:border-gray-700">
            <div class="flex items-center space-x-2">
                <div class="bg-gradient-to-r from-indigo-600 to-purple-600 p-2 rounded-lg">
                    <svg class="w-4 h-4 md:w-5 md:h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                    </svg>
                </div>
                <h2 class="text-base md:text-lg font-bold text-gray-900 dark:text-white">Roles & Permissions</h2>
            </div>
        </div>

        <div class="p-4 md:p-6">
            <!-- Roles Grid -->
            <div class="grid grid-cols-1 lg:grid-cols-2 xl:grid-cols-3 gap-4 md:gap-6">
                @foreach($roles as $role)
                <div class="bg-gradient-to-br from-gray-50 to-gray-100 dark:from-gray-700 dark:to-gray-800 rounded-xl p-4 md:p-6 border border-gray-200 dark:border-gray-600 hover:shadow-lg transition-all duration-300">
                    <div class="flex items-start justify-between mb-4">
                        <div class="flex-1">
                            <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-1">{{ $role->name }}</h3>
                            <p class="text-sm text-gray-600 dark:text-gray-400">{{ $role->permissions->count() }} permissions</p>
                        </div>
                        <div class="flex items-center space-x-2">
                            @can('users-manage-roles')
                            <button @click="editRolePermissions({{ $role->id }}, '{{ $role->name }}')" 
                                    class="p-2 text-blue-600 hover:text-blue-800 hover:bg-blue-50 rounded-lg transition-colors duration-200">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                </svg>
                            </button>
                            @if(!in_array($role->name, ['Admin', 'Super Admin']))
                            <button @click="deleteRole({{ $role->id }}, '{{ $role->name }}')" 
                                    class="p-2 text-red-600 hover:text-red-800 hover:bg-red-50 rounded-lg transition-colors duration-200">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                </svg>
                            </button>
                            @endif
                            @endcan
                        </div>
                    </div>

                    <!-- Permission Summary -->
                    <div class="space-y-2">
                        @php
                            $groupedPermissions = $role->permissions->groupBy(function($permission) {
                                if (str_starts_with($permission->name, 'menu-')) {
                                    return substr($permission->name, 5);
                                }
                                $parts = explode('-', $permission->name, 2);
                                return $parts[0] ?? 'other';
                            });
                        @endphp

                        @foreach($groupedPermissions->take(3) as $module => $modulePermissions)
                        <div class="flex items-center justify-between text-sm">
                            <span class="font-medium text-gray-700 dark:text-gray-300 capitalize">{{ $module }}</span>
                            <span class="bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200 px-2 py-1 rounded-full text-xs font-medium">
                                {{ $modulePermissions->count() }}
                            </span>
                        </div>
                        @endforeach

                        @if($groupedPermissions->count() > 3)
                        <div class="text-xs text-gray-500 dark:text-gray-400 text-center pt-2">
                            +{{ $groupedPermissions->count() - 3 }} more modules
                        </div>
                        @endif
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Permission Editor Modal -->
    <div x-show="showPermissionModal" 
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center p-4 z-50"
         style="display: none;">
        
        <div x-show="showPermissionModal"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 transform scale-95"
             x-transition:enter-end="opacity-100 transform scale-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100 transform scale-100"
             x-transition:leave-end="opacity-0 transform scale-95"
             class="bg-white dark:bg-gray-800 rounded-2xl shadow-2xl max-w-4xl w-full max-h-[90vh] overflow-hidden">
            
            <!-- Modal Header -->
            <div class="bg-gradient-to-r from-indigo-600 to-purple-600 p-6">
                <div class="flex items-center justify-between">
                    <h3 class="text-xl font-bold text-white" x-text="'Edit Permissions for ' + currentRole.name"></h3>
                    <button @click="closePermissionModal()" class="text-white hover:text-gray-200 transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
            </div>

            <!-- Modal Body -->
            <div class="p-6 overflow-y-auto max-h-[calc(90vh-200px)]">
                <form @submit.prevent="updateRolePermissions()">
                    <div class="space-y-6">
                        <!-- Permission Groups -->
                        <template x-for="(module, moduleKey) in permissionStructure" :key="moduleKey">
                            <div class="bg-gray-50 dark:bg-gray-700 rounded-xl p-4">
                                <div class="flex items-center justify-between mb-4">
                                    <h4 class="text-lg font-semibold text-gray-900 dark:text-white capitalize" x-text="module.label"></h4>
                                    <div class="flex items-center space-x-2">
                                        <label class="flex items-center">
                                            <input type="checkbox" 
                                                   :checked="isModuleFullySelected(moduleKey)"
                                                   @change="toggleModulePermissions(moduleKey, $event.target.checked)"
                                                   class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                            <span class="ml-2 text-sm text-gray-700 dark:text-gray-300">Select All</span>
                                        </label>
                                    </div>
                                </div>

                                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-3">
                                    <!-- Menu Permission -->
                                    <label class="flex items-center p-3 bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-600 hover:bg-gray-50 dark:hover:bg-gray-750 transition-colors">
                                        <input type="checkbox" 
                                               :name="'permissions[]'"
                                               :value="module.menu_permission"
                                               x-model="selectedPermissions"
                                               class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                        <div class="ml-3">
                                            <div class="text-sm font-medium text-gray-900 dark:text-white">Menu Access</div>
                                            <div class="text-xs text-gray-500 dark:text-gray-400" x-text="module.menu_permission"></div>
                                        </div>
                                    </label>

                                    <!-- Button Permissions -->
                                    <template x-for="(button, buttonKey) in module.buttons" :key="buttonKey">
                                        <label class="flex items-center p-3 bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-600 hover:bg-gray-50 dark:hover:bg-gray-750 transition-colors">
                                            <input type="checkbox" 
                                                   :name="'permissions[]'"
                                                   :value="button.permission"
                                                   x-model="selectedPermissions"
                                                   class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                            <div class="ml-3">
                                                <div class="text-sm font-medium text-gray-900 dark:text-white" x-text="button.label"></div>
                                                <div class="text-xs text-gray-500 dark:text-gray-400" x-text="button.permission"></div>
                                            </div>
                                        </label>
                                    </template>
                                </div>
                            </div>
                        </template>
                    </div>

                    <!-- Modal Footer -->
                    <div class="flex items-center justify-end space-x-3 pt-6 border-t border-gray-200 dark:border-gray-600">
                        <button type="button" 
                                @click="closePermissionModal()"
                                class="px-4 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 rounded-lg transition-colors">
                            Cancel
                        </button>
                        <button type="submit" 
                                :disabled="loading"
                                class="px-6 py-2 text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 disabled:opacity-50 disabled:cursor-not-allowed rounded-lg transition-colors">
                            <span x-show="!loading">Update Permissions</span>
                            <span x-show="loading" class="flex items-center">
                                <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                                Updating...
                            </span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
function accessControlManager() {
    return {
        showPermissionModal: false,
        loading: false,
        currentRole: { id: null, name: '' },
        selectedPermissions: [],
        permissionStructure: {},

        init() {
            this.loadPermissionStructure();
        },

        async loadPermissionStructure() {
            try {
                const response = await fetch('{{ route("partner.access-control.permission-structure") }}');
                const data = await response.json();
                
                if (data.success) {
                    this.permissionStructure = data.structure;
                }
            } catch (error) {
                console.error('Error loading permission structure:', error);
            }
        },

        async editRolePermissions(roleId, roleName) {
            this.currentRole = { id: roleId, name: roleName };
            this.loading = true;
            
            try {
                const response = await fetch(`/partner/access-control/roles/${roleId}/permissions`);
                const data = await response.json();
                
                if (data.success) {
                    this.selectedPermissions = data.permissions;
                    this.showPermissionModal = true;
                }
            } catch (error) {
                console.error('Error loading role permissions:', error);
                alert('Error loading role permissions');
            } finally {
                this.loading = false;
            }
        },

        async updateRolePermissions() {
            this.loading = true;
            
            try {
                const response = await fetch(`/partner/access-control/roles/${this.currentRole.id}/permissions`, {
                    method: 'PUT',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({
                        permissions: this.selectedPermissions
                    })
                });
                
                const data = await response.json();
                
                if (data.success) {
                    alert('Permissions updated successfully');
                    this.closePermissionModal();
                    location.reload();
                } else {
                    alert(data.message || 'Error updating permissions');
                }
            } catch (error) {
                console.error('Error updating permissions:', error);
                alert('Error updating permissions');
            } finally {
                this.loading = false;
            }
        },

        async deleteRole(roleId, roleName) {
            if (!confirm(`Are you sure you want to delete the role "${roleName}"?`)) {
                return;
            }
            
            try {
                const response = await fetch(`/partner/access-control/roles/${roleId}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                });
                
                const data = await response.json();
                
                if (data.success) {
                    alert('Role deleted successfully');
                    location.reload();
                } else {
                    alert(data.message || 'Error deleting role');
                }
            } catch (error) {
                console.error('Error deleting role:', error);
                alert('Error deleting role');
            }
        },

        closePermissionModal() {
            this.showPermissionModal = false;
            this.currentRole = { id: null, name: '' };
            this.selectedPermissions = [];
        },

        isModuleFullySelected(moduleKey) {
            const module = this.permissionStructure[moduleKey];
            if (!module) return false;
            
            const modulePermissions = [module.menu_permission];
            Object.values(module.buttons).forEach(button => {
                modulePermissions.push(button.permission);
            });
            
            return modulePermissions.every(permission => 
                this.selectedPermissions.includes(permission)
            );
        },

        toggleModulePermissions(moduleKey, selected) {
            const module = this.permissionStructure[moduleKey];
            if (!module) return;
            
            const modulePermissions = [module.menu_permission];
            Object.values(module.buttons).forEach(button => {
                modulePermissions.push(button.permission);
            });
            
            if (selected) {
                // Add all module permissions
                modulePermissions.forEach(permission => {
                    if (!this.selectedPermissions.includes(permission)) {
                        this.selectedPermissions.push(permission);
                    }
                });
            } else {
                // Remove all module permissions
                this.selectedPermissions = this.selectedPermissions.filter(permission => 
                    !modulePermissions.includes(permission)
                );
            }
        }
    }
}
</script>
@endsection
