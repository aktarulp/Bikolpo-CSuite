@extends('layouts.partner-layout')

@section('title', 'Access Control')

@push('styles')
<style>
    .permission-toggle {
        transition: all 0.2s ease-in-out;
    }
    .permission-toggle:active {
        transform: scale(0.95);
    }
    .glass-effect {
        backdrop-filter: blur(10px);
        background: rgba(255, 255, 255, 0.1);
    }
    .hover-lift:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
    }
    .line-clamp-2 {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    @media (max-width: 640px) {
        .mobile-scroll {
            -webkit-overflow-scrolling: touch;
        }
    }
</style>
@endpush

@section('content')
<div class="min-h-screen bg-gray-50 dark:bg-gray-900" x-data="accessControlManager()">
    <!-- Mobile-First Header -->
    <div class="bg-white dark:bg-gray-800 shadow-sm border-b border-gray-200 dark:border-gray-700">
        <div class="px-4 py-6 sm:px-6 lg:px-8">
            <!-- Mobile Header -->
            <div class="flex items-center justify-between mb-4 sm:hidden">
                <div class="flex items-center space-x-3">
                    <div class="p-2 bg-blue-50 dark:bg-blue-900/30 rounded-lg">
                        <svg class="w-6 h-6 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                        </svg>
                    </div>
                    <h1 class="text-xl font-bold text-gray-900 dark:text-white">Access Control</h1>
                </div>
                <button id="refreshPermissionsBtnMobile"
                        type="button"
                        class="p-2 bg-gray-100 hover:bg-gray-200 text-gray-800 dark:bg-gray-700 dark:hover:bg-gray-600 dark:text-gray-200 rounded-lg shadow-sm transition-colors"
                        title="Refresh permissions from config">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582M20 20v-5h-.581M5.5 9.5A7.5 7.5 0 0119 12m0 0a7.5 7.5 0 01-13.5 2.5" />
                    </svg>
                </button>
                <a href="{{ route('partner.access-control.create-role') }}" 
                   class="p-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg shadow-sm transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                    </svg>
                </a>
            </div>

            <!-- Desktop Header -->
            <div class="hidden sm:flex items-center justify-between">
                <div class="flex items-center space-x-4">
                    <div class="p-3 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-xl shadow-lg">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                        </svg>
                    </div>
                    <div>
                        <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Access Control</h1>
                        <p class="text-gray-600 dark:text-gray-400 mt-1">Manage roles and permissions for your organization</p>
                    </div>
                </div>
                <div class="flex items-center space-x-2">
                    <button id="refreshPermissionsBtn"
                            type="button"
                            class="inline-flex items-center space-x-2 bg-gray-100 hover:bg-gray-200 text-gray-800 dark:bg-gray-700 dark:hover:bg-gray-600 dark:text-gray-200 font-medium px-4 py-3 rounded-lg shadow-sm transition-all duration-200">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582M20 20v-5h-.581M5.5 9.5A7.5 7.5 0 0119 12m0 0a7.5 7.5 0 01-13.5 2.5" />
                        </svg>
                        <span>Refresh Permissions</span>
                    </button>
                    <a href="{{ route('partner.access-control.create-role') }}" 
                       class="inline-flex items-center space-x-2 bg-blue-600 hover:bg-blue-700 text-white font-medium px-6 py-3 rounded-lg shadow-sm hover:shadow-md transition-all duration-200">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m-6 0H6" />
                        </svg>
                        <span>Create Role</span>
                    </a>
                </div>
            </div>

            <!-- Mobile Description -->
            <p class="text-sm text-gray-600 dark:text-gray-400 mt-2 sm:hidden">Manage roles and permissions for your organization</p>
        </div>
    </div>

    <!-- Main Content -->
    <div class="px-4 py-6 sm:px-6 lg:px-8">
        <!-- Search and Filter Section -->
        <div class="mb-6">
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-4 sm:p-6">
                <div class="flex flex-col space-y-4 sm:flex-row sm:items-center sm:justify-between sm:space-y-0">
                    <div class="flex items-center space-x-3">
                        <div class="p-2 bg-blue-50 dark:bg-blue-900/30 rounded-lg">
                            <svg class="w-5 h-5 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg>
                        </div>
                        <div>
                            <h2 class="text-lg font-semibold text-gray-900 dark:text-white">Roles & Permissions</h2>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Manage user roles and their access levels</p>
                        </div>
                    </div>
                    <div class="relative w-full sm:w-80">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </div>
                        <input type="text" 
                               x-model="searchQuery" 
                               @input.debounce.300ms="filterRoles()"
                               class="block w-full pl-10 pr-4 py-3 border border-gray-200 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-colors" 
                               placeholder="Search roles...">
                    </div>
                </div>
            </div>
        </div>

        <!-- Loading State -->
        <div x-show="loading" class="flex justify-center py-12">
            <div class="flex flex-col items-center space-y-4">
                <div class="animate-spin rounded-full h-12 w-12 border-t-2 border-b-2 border-blue-500"></div>
                <p class="text-gray-600 dark:text-gray-400">Loading roles...</p>
            </div>
        </div>
        
        <!-- No Results -->
        <div x-show="!loading && filteredRoles.length === 0" class="text-center py-16">
            <div class="mx-auto flex items-center justify-center h-16 w-16 rounded-full bg-gray-100 dark:bg-gray-700 mb-6">
                <svg class="h-8 w-8 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
            <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-2">No roles found</h3>
            <p class="text-gray-500 dark:text-gray-400 mb-6">Try adjusting your search or create a new role.</p>
            @can('users-manage-roles')
            <a href="{{ route('partner.access-control.create-role') }}" 
               class="inline-flex items-center space-x-2 bg-blue-600 hover:bg-blue-700 text-white font-medium px-6 py-3 rounded-lg shadow-sm hover:shadow-md transition-all duration-200">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                </svg>
                <span>Create Role</span>
            </a>
            @endcan
        </div>

        <!-- Roles Grid -->
        <div x-show="!loading && filteredRoles.length > 0" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4 sm:gap-6">
            @foreach($roles as $role)
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden hover-lift transition-all duration-300">
                <!-- Role Header (Redesigned) -->
                <div class="p-5 border-b border-gray-100 dark:border-gray-700">
                    <div class="flex items-start justify-between">
                        <div class="min-w-0 flex-1">
                            <div class="text-xs uppercase tracking-wide text-gray-500 dark:text-gray-400">Role</div>
                            <h3 class="mt-1 text-2xl font-bold text-gray-900 dark:text-white break-words">{{ $role->display_name ?? ucwords(str_replace('_', ' ', $role->name)) }}</h3>
                            <div class="mt-1 text-xs text-gray-500 dark:text-gray-400">System name: <span class="font-mono">{{ $role->name }}</span></div>
                            @if($role->description)
                                <p class="mt-3 text-sm text-gray-600 dark:text-gray-400">{{ $role->description }}</p>
                            @endif
                        </div>
                        <div class="ml-4 text-right space-y-2">
                            @if(method_exists($role, 'getLevelBadgeAttribute'))
                                <div class="inline-block">{!! $role->level_badge !!}</div>
                            @endif
                            @if(method_exists($role, 'getStatusBadgeAttribute'))
                                <div class="inline-block">{!! $role->status_badge !!}</div>
                            @endif
                        </div>
                    </div>

                    <div class="mt-4 flex flex-wrap items-center gap-2">
                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-200">
                            👥 {{ $role->users_count ?? ($role->users->count() ?? 0) }} Users
                        </span>
                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-blue-50 text-blue-700 dark:bg-blue-900/30 dark:text-blue-300">
                            🔐 {{ $role->permissions->count() }} Permissions
                        </span>

                        <div class="ml-auto flex items-center space-x-2">
                            <button @click="editRolePermissions({{ $role->id }}, '{{ $role->name }}')" 
                                    class="px-3 py-2 text-white bg-blue-600 hover:bg-blue-700 rounded-lg transition-colors duration-200 inline-flex items-center space-x-2"
                                    title="Edit Permissions">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                                <span class="hidden sm:inline">Edit Permissions</span>
                            </button>
                            <a href="{{ route('partner.access-control.edit-role', $role) }}" 
                               class="px-3 py-2 bg-gray-100 text-gray-800 hover:bg-gray-200 dark:bg-gray-700 dark:text-gray-200 dark:hover:bg-gray-600 rounded-lg transition-colors duration-200"
                               title="Edit Role">
                                Edit Role
                            </a>
                            @if(!in_array($role->name, ['Admin', 'Super Admin']))
                            <button @click="deleteRole({{ $role->id }}, '{{ $role->name }}')" 
                                    class="px-3 py-2 bg-red-50 text-red-600 hover:bg-red-100 dark:bg-red-900/20 dark:text-red-400 rounded-lg transition-colors duration-200"
                                    title="Delete Role">
                                Delete
                            </button>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Permission Summary -->
                <div class="p-4 sm:p-6">
                    @php
                        $groupedPermissions = $role->permissions->groupBy(function($permission) {
                            if (str_starts_with($permission->name, 'menu-')) {
                                return substr($permission->name, 5);
                            }
                            $parts = explode('-', $permission->name, 2);
                            return $parts[0] ?? 'other';
                        });
                    @endphp

                    @if($groupedPermissions->count() > 0)
                    <div class="space-y-4">
                        <!-- Permission Progress -->
                        <div>
                            <div class="flex items-center justify-between text-sm text-gray-600 dark:text-gray-400 mb-2">
                                <span>Permission Coverage</span>
                                <span class="font-medium">{{ $role->permissions->count() }} permissions</span>
                            </div>
                            <div class="w-full bg-gray-100 dark:bg-gray-700 rounded-full h-2">
                                <div class="bg-gradient-to-r from-blue-500 to-indigo-600 h-2 rounded-full transition-all duration-300" 
                                     style="width: {{ min(100, ($role->permissions->count() / 20) * 100) }}%;">
                                </div>
                            </div>
                        </div>

                        <!-- Permission Modules -->
                        <div class="space-y-3">
                            @foreach($groupedPermissions->take(3) as $module => $modulePermissions)
                            <div class="flex items-center justify-between">
                                <div class="flex items-center space-x-2">
                                    <div class="w-2 h-2 bg-blue-500 rounded-full"></div>
                                    <span class="text-sm font-medium text-gray-700 dark:text-gray-300 capitalize">{{ $module }}</span>
                                </div>
                                <span class="bg-blue-50 text-blue-700 dark:bg-blue-900/30 dark:text-blue-300 px-2 py-1 rounded-full text-xs font-medium">
                                    {{ $modulePermissions->count() }}
                                </span>
                            </div>
                            @endforeach
                        </div>

                        @if($groupedPermissions->count() > 3)
                        <div class="pt-3 border-t border-gray-100 dark:border-gray-700">
                            <button @click="editRolePermissions({{ $role->id }}, '{{ $role->name }}')" 
                                    class="w-full flex items-center justify-center space-x-2 text-sm font-medium text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300 transition-colors duration-200 py-2">
                                <span>View all {{ $groupedPermissions->count() }} modules</span>
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                </svg>
                            </button>
                        </div>
                        @endif
                    </div>
                    @else
                    <div class="text-center py-6">
                        <div class="w-12 h-12 bg-gray-100 dark:bg-gray-700 rounded-full flex items-center justify-center mx-auto mb-3">
                            <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                            </svg>
                        </div>
                        <p class="text-sm text-gray-500 dark:text-gray-400 mb-4">No permissions assigned yet</p>
                        <button @click="editRolePermissions({{ $role->id }}, '{{ $role->name }}')" 
                                class="text-sm font-medium text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300 transition-colors duration-200">
                            Assign permissions
                        </button>
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
         class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center p-2 sm:p-4 z-50"
         style="display: none;">
        
        <div x-show="showPermissionModal"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 transform scale-95"
             x-transition:enter-end="opacity-100 transform scale-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100 transform scale-100"
             x-transition:leave-end="opacity-0 transform scale-95"
             class="bg-white dark:bg-gray-800 rounded-xl sm:rounded-2xl shadow-2xl max-w-4xl w-full max-h-[95vh] sm:max-h-[90vh] overflow-hidden">
            
            <!-- Modal Header -->
            <div class="bg-gradient-to-r from-blue-600 to-indigo-600 p-4 sm:p-6">
                <div class="flex items-center justify-between">
                    <div class="min-w-0 flex-1">
                        <h3 class="text-lg sm:text-xl font-bold text-white truncate" x-text="'Edit Permissions for ' + currentRole.name"></h3>
                        <p class="text-blue-100 text-sm mt-1">Configure role access and permissions</p>
                    </div>
                    <button @click="closePermissionModal()" class="text-white hover:text-gray-200 transition-colors ml-4 flex-shrink-0">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
            </div>

            <!-- Modal Body -->
            <div class="p-4 sm:p-6 overflow-y-auto max-h-[calc(95vh-180px)] sm:max-h-[calc(90vh-200px)]">
                <form @submit.prevent="updateRolePermissions()">
                    <div class="space-y-6">
                        <!-- Permission Groups -->
                        <template x-for="(module, moduleKey) in permissionStructure" :key="moduleKey">
                            <div class="bg-gray-50 dark:bg-gray-700 rounded-xl p-4 sm:p-6">
                                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-4 space-y-2 sm:space-y-0">
                                    <h4 class="text-lg font-semibold text-gray-900 dark:text-white capitalize" x-text="module.label"></h4>
                                    <label class="flex items-center space-x-2">
                                        <input type="checkbox" 
                                               :checked="isModuleFullySelected(moduleKey)"
                                               @change="toggleModulePermissions(moduleKey, $event.target.checked)"
                                               class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                                        <span class="text-sm text-gray-700 dark:text-gray-300">Select All</span>
                                    </label>
                                </div>

                                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3">
                                    <!-- Menu Permission -->
                                    <label class="flex items-start p-3 bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-600 hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors cursor-pointer">
                                        <input type="checkbox" 
                                               :name="'permissions[]'"
                                               :value="module.menu_permission"
                                               x-model="selectedPermissions"
                                               class="mt-1 rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                                        <div class="ml-3 min-w-0 flex-1">
                                            <div class="text-sm font-medium text-gray-900 dark:text-white">Menu Access</div>
                                            <div class="text-xs text-gray-500 dark:text-gray-400 truncate" x-text="module.menu_permission"></div>
                                        </div>
                                    </label>

                                    <!-- Button Permissions -->
                                    <template x-for="(button, buttonKey) in module.buttons" :key="buttonKey">
                                        <label class="flex items-start p-3 bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-600 hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors cursor-pointer">
                                            <input type="checkbox" 
                                                   :name="'permissions[]'"
                                                   :value="button.permission"
                                                   x-model="selectedPermissions"
                                                   class="mt-1 rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                                            <div class="ml-3 min-w-0 flex-1">
                                                <div class="text-sm font-medium text-gray-900 dark:text-white" x-text="button.label"></div>
                                                <div class="text-xs text-gray-500 dark:text-gray-400 truncate" x-text="button.permission"></div>
                                            </div>
                                        </label>
                                    </template>
                                </div>
                            </div>
                        </template>
                    </div>

                    <!-- Modal Footer -->
                    <div class="flex flex-col sm:flex-row items-stretch sm:items-center justify-end space-y-3 sm:space-y-0 sm:space-x-3 pt-6 border-t border-gray-200 dark:border-gray-600">
                        <button type="button" 
                                @click="closePermissionModal()"
                                class="w-full sm:w-auto px-6 py-3 text-sm font-medium text-gray-700 dark:text-gray-300 bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 rounded-lg transition-colors">
                            Cancel
                        </button>
                        <button type="submit" 
                                :disabled="loading"
                                class="w-full sm:w-auto px-6 py-3 text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 disabled:opacity-50 disabled:cursor-not-allowed rounded-lg transition-colors flex items-center justify-center">
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
        // State
        showPermissionModal: false,
        loading: false,
        currentRole: { id: null, name: '' },
        selectedPermissions: [],
        permissionStructure: @json($permissionStructure ?? []),
        roles: @json($roles ?? []),
        filteredRoles: @json($roles ?? []),
        filteredPermissionStructure: {},
        searchQuery: '',
        permissionSearch: '',
        permissionStructure: {},

        init() {
            // Initialize filtered permission structure
            this.filteredPermissionStructure = { ...this.permissionStructure };
            
            // Initialize filtered roles
            this.filteredRoles = [...this.roles];
        },

        // Filter roles based on search query
        filterRoles() {
            if (!this.searchQuery) {
                this.filteredRoles = [...this.roles];
                return;
            }
            
            const query = this.searchQuery.toLowerCase();
            this.filteredRoles = this.roles.filter(role => 
                role.name.toLowerCase().includes(query) || 
                (role.description && role.description.toLowerCase().includes(query))
            );
        },
        
        // Filter permissions based on search query
        filterPermissions() {
            if (!this.permissionSearch) {
                this.filteredPermissionStructure = { ...this.permissionStructure };
                return;
            }
            
            const query = this.permissionSearch.toLowerCase();
            const filtered = {};
            
            Object.entries(this.permissionStructure).forEach(([moduleKey, module]) => {
                // Check if module name or menu permission matches
                const moduleMatches = module.name.toLowerCase().includes(query) || 
                                    module.menu_permission.toLowerCase().includes(query);
                
                // Check if any button permission matches
                const buttonMatches = Object.values(module.buttons).some(button => 
                    button.label.toLowerCase().includes(query) || 
                    button.permission.toLowerCase().includes(query)
                );
                
                if (moduleMatches || buttonMatches) {
                    // If module matches, include all its permissions
                    if (moduleMatches) {
                        filtered[moduleKey] = module;
                    } else {
                        // Otherwise, include only matching buttons
                        const filteredButtons = {};
                        Object.entries(module.buttons).forEach(([btnKey, button]) => {
                            if (button.label.toLowerCase().includes(query) || 
                                button.permission.toLowerCase().includes(query)) {
                                filteredButtons[btnKey] = button;
                            }
                        });
                        
                        if (Object.keys(filteredButtons).length > 0) {
                            filtered[moduleKey] = {
                                ...module,
                                buttons: filteredButtons
                            };
                        }
                    }
                }
            });
            
            this.filteredPermissionStructure = filtered;
        },

        async editRolePermissions(roleId, roleName) {
            this.currentRole = { id: roleId, name: roleName };
            this.loading = true;
            this.showPermissionModal = true;
            
            try {
                // Reset search when opening modal
                this.permissionSearch = '';
                this.filteredPermissionStructure = { ...this.permissionStructure };
                
                // Fetch role permissions
                const response = await fetch(`/partner/access-control/roles/${roleId}/permissions`);
                const data = await response.json();
                
                if (data.success) {
                    this.selectedPermissions = data.permissions;
                } else {
                    throw new Error(data.message || 'Failed to load permissions');
                }
            } catch (error) {
                console.error('Error loading role permissions:', error);
                alert('Error loading role permissions: ' + error.message);
                this.closePermissionModal();
            } finally {
                this.loading = false;
            }
        },

        async updateRolePermissions() {
            if (this.loading) return;
            
            this.loading = true;
            
            try {
                const response = await fetch(`/partner/access-control/roles/${this.currentRole.id}/permissions`, {
                    method: 'PUT',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({
                        permissions: this.selectedPermissions,
                        _method: 'PUT'
                    })
                });
                
                const data = await response.json();
                
                if (!response.ok) {
                    throw new Error(data.message || 'Failed to update permissions');
                }
                
                if (data.success) {
                    // Show success message
                    this.showNotification('Permissions updated successfully', 'success');
                    this.closePermissionModal();
                    
                    // Reload the page to reflect changes
                    setTimeout(() => {
                        window.location.reload();
                    }, 1000);
                } else {
                    throw new Error(data.message || 'Error updating permissions');
                }
            } catch (error) {
                console.error('Error updating permissions:', error);
                this.showNotification(error.message || 'Error updating permissions', 'error');
            } finally {
                this.loading = false;
            }
        },
        
        // Show notification
        showNotification(message, type = 'success') {
            // You can integrate with a notification library or use a simple alert
            // For example, using SweetAlert2 or your preferred notification system
            if (typeof Swal !== 'undefined') {
                Swal.fire({
                    toast: true,
                    position: 'top-end',
                    icon: type,
                    title: message,
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true
                });
            } else {
                alert(`${type.toUpperCase()}: ${message}`);
            }
        },

        async deleteRole(roleId) {
            try {
                const response = await fetch(`/partner/access-control/roles/${roleId}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json'
                    }
                });
                
                const data = await response.json();
                
                if (!response.ok) {
                    throw new Error(data.message || 'Failed to delete role');
                }
                
                if (data.success) {
                    this.showNotification('Role deleted successfully', 'success');
                    
                    // Remove the role from the UI
                    this.roles = this.roles.filter(role => role.id !== roleId);
                    this.filteredRoles = this.filteredRoles.filter(role => role.id !== roleId);
                } else {
                    throw new Error(data.message || 'Error deleting role');
                }
            } catch (error) {
                console.error('Error deleting role:', error);
                this.showNotification(error.message || 'Error deleting role', 'error');
            }
        },

        closePermissionModal() {
            if (this.loading) return;
            this.showPermissionModal = false;
            this.currentRole = { id: null, name: '' };
            this.selectedPermissions = [];
            this.permissionSearch = '';
            this.filteredPermissionStructure = { ...this.permissionStructure };
        },

        // Get count of permissions in a module
        getModulePermissionCount(moduleKey) {
            const module = this.permissionStructure[moduleKey];
            if (!module) return 0;
            
            // Count menu permission + all button permissions
            return 1 + Object.keys(module.buttons || {}).length;
        },
        
        // Get count of selected permissions in a module
        getModuleSelectedCount(moduleKey) {
            const module = this.permissionStructure[moduleKey];
            if (!module) return 0;
            
            const modulePermissions = [module.menu_permission];
            Object.values(module.buttons || {}).forEach(button => {
                modulePermissions.push(button.permission);
            });
            
            return modulePermissions.filter(permission => 
                this.selectedPermissions.includes(permission)
            ).length;
        },
        
        // Check if all permissions in a module are selected
        isModuleFullySelected(moduleKey) {
            const module = this.permissionStructure[moduleKey];
            if (!module) return false;
            
            const modulePermissions = [module.menu_permission];
            Object.values(module.buttons || {}).forEach(button => {
                modulePermissions.push(button.permission);
            });
            
            return modulePermissions.length > 0 && 
                   modulePermissions.every(permission => 
                       this.selectedPermissions.includes(permission)
                   );
        },
        
        // Check if user has a specific permission
        hasPermission(permission) {
            // This would check against the current user's permissions
            // You might need to pass the user's permissions from the backend
            return true; // Placeholder - implement actual permission check
        },

        // Toggle all permissions for a module
        toggleModulePermissions(moduleKey, selected) {
            const module = this.permissionStructure[moduleKey];
            if (!module) return;
            
            // Get all permissions in this module
            const modulePermissions = [module.menu_permission];
            Object.values(module.buttons || {}).forEach(button => {
                modulePermissions.push(button.permission);
            });
            
            if (selected) {
                // Add all module permissions that aren't already selected
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
        },
        
        // Handle permission selection changes
        onPermissionChange(permission, event) {
            if (event.target.checked) {
                if (!this.selectedPermissions.includes(permission)) {
                    this.selectedPermissions.push(permission);
                }
            } else {
                this.selectedPermissions = this.selectedPermissions.filter(p => p !== permission);
            }
        }
    }
}
</script>

<script>
(function(){
    function csrfToken(){
        var m = document.querySelector('meta[name="csrf-token"]');
        return m ? m.getAttribute('content') : '';
    }
    async function doSync(btn){
        if(!btn) return;
        btn.disabled = true;
        const original = btn.innerHTML;
        btn.innerHTML = '<svg class="animate-spin -ml-1 mr-2 h-4 w-4 inline" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg> Syncing...';
        try{
            const resp = await fetch('{{ route('partner.access-control.permissions.sync') }}', {
                method: 'POST',
                headers: { 'X-CSRF-TOKEN': csrfToken(), 'Accept':'application/json' }
            });
            const data = await resp.json();
            if(!resp.ok || !data.success){ throw new Error(data.message || 'Sync failed'); }
            // Reload to reflect any new permissions/menus
            location.reload();
        } catch(e){
            alert('Permission sync error: ' + e.message);
        } finally {
            btn.disabled = false;
            btn.innerHTML = original;
        }
    }
    const btn = document.getElementById('refreshPermissionsBtn');
    const btnM = document.getElementById('refreshPermissionsBtnMobile');
    if(btn){ btn.addEventListener('click', () => doSync(btn)); }
    if(btnM){ btnM.addEventListener('click', () => doSync(btnM)); }
})();
</script>
@endsection
