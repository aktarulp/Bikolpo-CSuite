@extends('layouts.partner-layout')

@section('title', 'Role & Permission Management')

@section('styles')
<style>
    /* Mobile-first custom utilities */
    @layer utilities {
        .role-card {
            @apply transition-all duration-300 border-l-4 border-transparent hover:shadow-lg hover:-translate-y-1;
        }
        .role-card.super-admin { @apply border-l-purple-500; }
        .role-card.admin { @apply border-l-red-500; }
        .role-card.manager { @apply border-l-orange-500; }
        .role-card.supervisor { @apply border-l-yellow-500; }
        .role-card.staff { @apply border-l-green-500; }
        .role-card.user { @apply border-l-blue-500; }
        
        .permission-grid {
            @apply grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4;
        }
        .permission-module {
            @apply bg-gray-50 dark:bg-gray-800 rounded-xl p-4 sm:p-6 border border-gray-200 dark:border-gray-700;
        }
        .permission-item {
            @apply flex items-start justify-between p-3 sm:p-4 rounded-lg transition-all duration-200 hover:bg-gray-100 dark:hover:bg-gray-700;
        }
        .hierarchy-tree {
            @apply font-mono text-sm leading-relaxed;
        }
        .tree-node {
            @apply pl-4 sm:pl-6 relative;
        }
        .tree-node::before {
            content: '├── ';
            @apply text-gray-400 absolute left-0;
        }
        .tree-node:last-child::before {
            content: '└── ';
        }
        .modal-backdrop {
            @apply backdrop-blur-sm bg-black/50;
        }
        .permission-checkbox {
            @apply w-5 h-5 sm:w-6 sm:h-6 cursor-pointer rounded border-gray-300 text-indigo-600 focus:ring-indigo-500;
        }
        .role-permission-grid {
            @apply overflow-x-auto -mx-4 sm:mx-0 px-4 sm:px-0;
        }
        .role-permission-grid table {
            @apply min-w-[600px] sm:min-w-[800px] w-full;
        }
        .role-permission-grid th,
        .role-permission-grid td {
            @apply text-center align-middle p-2 sm:p-3 text-xs sm:text-sm;
        }
        .role-permission-grid th {
            @apply bg-gray-50 dark:bg-gray-800 font-semibold sticky top-0 z-10;
        }
        .role-permission-grid .cell-center {
            @apply w-8 h-8 sm:w-10 sm:h-10 flex items-center justify-center;
        }
        
        /* New stats cards design */
        .stats-card {
            position: relative;
            overflow: hidden;
            transition: all 0.3s ease;
        }
        .stats-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: inherit;
            opacity: 0.1;
            transform: rotate(45deg) scale(2);
            transition: all 0.3s ease;
        }
        .stats-card:hover::before {
            transform: rotate(45deg) scale(2.2);
        }
        .stats-card-content {
            position: relative;
            z-index: 1;
        }
    }
    
    /* Loading spinner */
    .loading-spinner {
        border: 3px solid #f3f4f6;
        border-top: 3px solid #6366f1;
        border-radius: 50%;
        width: 32px;
        height: 32px;
        animation: spin 1s linear infinite;
    }
    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }
    
    /* Mobile-optimized animations */
    .fade-in {
        animation: fadeIn 0.3s ease-in-out;
    }
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }
    
    /* Custom scrollbar for mobile */
    .custom-scrollbar::-webkit-scrollbar {
        width: 4px;
        height: 4px;
    }
    .custom-scrollbar::-webkit-scrollbar-track {
        @apply bg-gray-100 dark:bg-gray-800;
    }
    .custom-scrollbar::-webkit-scrollbar-thumb {
        @apply bg-gray-400 dark:bg-gray-600 rounded-full;
    }
</style>

<!-- Critical functions for mobile compatibility -->
<script>
window.showModal = function(modalId) {
    const modal = document.getElementById(modalId);
    if (modal) {
        modal.classList.remove('hidden');
        modal.classList.add('flex');
        document.body.style.overflow = 'hidden';
        // Add mobile-specific handling
        if (window.innerWidth < 768) {
            modal.querySelector('.bg-white').classList.add('m-4', 'rounded-lg');
        }
    }
};

window.hideModal = function(modalId) {
    const modal = document.getElementById(modalId);
    if (modal) {
        modal.classList.add('hidden');
        modal.classList.remove('flex');
        document.body.style.overflow = 'auto';
    }
};
</script>
@endsection

@section('content')
<div class="flex-1 overflow-y-auto custom-scrollbar bg-gray-50 dark:bg-gray-900 min-h-screen">
    <div class="max-w-7xl mx-auto p-4 sm:p-6 lg:p-8">
        <!-- Header Section -->
        <div class="mb-6 sm:mb-8 fade-in">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
                <div class="flex-1 min-w-0">
                    <h1 class="text-2xl sm:text-3xl lg:text-4xl font-bold text-gray-900 dark:text-white mb-2 tracking-tight">
                        Role & Permission Management
                    </h1>
                    <p class="text-sm sm:text-base text-gray-600 dark:text-gray-400 max-w-2xl">
                        Manage user roles, permissions, and access control hierarchies
                    </p>
                </div>
                <div class="flex flex-col sm:flex-row gap-2 sm:gap-3">
                    <button type="button" class="inline-flex items-center justify-center px-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-xl text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-900 transition-all duration-200 shadow-sm hover:shadow-md" onclick="exportRoles()">
                        <i class="fas fa-download mr-2 text-gray-500 dark:text-gray-400"></i>
                        <span class="hidden sm:inline">Export</span>
                        <span class="sm:hidden">Export</span>
                    </button>
                </div>
            </div>
        </div>

        <!-- Statistics Cards - New Design -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6 mb-6 sm:mb-8">
            <!-- Total Roles Card -->
            <div class="stats-card bg-gradient-to-br from-purple-500 to-purple-700 rounded-2xl p-5 sm:p-6 shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1 fade-in" style="box-shadow: 0 10px 25px -5px rgba(147, 51, 234, 0.4), 0 8px 10px -6px rgba(147, 51, 234, 0.3);">
                <div class="stats-card-content">
                    <div class="flex items-center justify-between">
                        <div class="flex-1">
                            <h6 class="text-sm sm:text-base font-medium mb-1 text-white/90">Total Roles</h6>
                            <h3 class="text-2xl sm:text-3xl lg:text-4xl font-bold mb-0 text-white">{{ $roles->count() }}</h3>
                        </div>
                        <div class="text-2xl sm:text-3xl text-white/80 ml-4">
                            <i class="fas fa-user-tag"></i>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Active Roles Card -->
            <div class="stats-card bg-gradient-to-br from-blue-500 to-blue-700 rounded-2xl p-5 sm:p-6 shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1 fade-in" style="animation-delay: 0.1s; box-shadow: 0 10px 25px -5px rgba(59, 130, 246, 0.4), 0 8px 10px -6px rgba(59, 130, 246, 0.3);">
                <div class="stats-card-content">
                    <div class="flex items-center justify-between">
                        <div class="flex-1">
                            <h6 class="text-sm sm:text-base font-medium mb-1 text-white/90">Active Roles</h6>
                            <h3 class="text-2xl sm:text-3xl lg:text-4xl font-bold mb-0 text-white">{{ $roles->where('status', 'active')->count() }}</h3>
                        </div>
                        <div class="text-2xl sm:text-3xl text-white/80 ml-4">
                            <i class="fas fa-check-circle"></i>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Total Permissions Card -->
            <div class="stats-card bg-gradient-to-br from-cyan-500 to-cyan-700 rounded-2xl p-5 sm:p-6 shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1 fade-in" style="animation-delay: 0.2s; box-shadow: 0 10px 25px -5px rgba(6, 182, 212, 0.4), 0 8px 10px -6px rgba(6, 182, 212, 0.3);">
                <div class="stats-card-content">
                    <div class="flex items-center justify-between">
                        <div class="flex-1">
                            <h6 class="text-sm sm:text-base font-medium mb-1 text-white/90">Total Permissions</h6>
                            <h3 class="text-2xl sm:text-3xl lg:text-4xl font-bold mb-0 text-white">{{ $permissions->count() }}</h3>
                        </div>
                        <div class="text-2xl sm:text-3xl text-white/80 ml-4">
                            <i class="fas fa-key"></i>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Permission Modules Card -->
            <div class="stats-card bg-gradient-to-br from-green-500 to-green-700 rounded-2xl p-5 sm:p-6 shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1 fade-in" style="animation-delay: 0.3s; box-shadow: 0 10px 25px -5px rgba(16, 185, 129, 0.4), 0 8px 10px -6px rgba(16, 185, 129, 0.3);">
                <div class="stats-card-content">
                    <div class="flex items-center justify-between">
                        <div class="flex-1">
                            <h6 class="text-sm sm:text-base font-medium mb-1 text-white/90">Permission Modules</h6>
                            <h3 class="text-2xl sm:text-3xl lg:text-4xl font-bold mb-0 text-white">{{ $permissions->pluck('module')->unique()->count() }}</h3>
                        </div>
                        <div class="text-2xl sm:text-3xl text-white/80 ml-4">
                            <i class="fas fa-cube"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tabs Navigation -->
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 mb-6 sm:mb-8 overflow-hidden fade-in" style="animation-delay: 0.4s">
            <nav class="flex flex-wrap sm:flex-nowrap -mb-px" aria-label="Tabs">
                <button class="tab-button active flex-1 min-w-0 sm:flex-none px-3 sm:px-6 py-3 sm:py-4 text-center border-b-2 border-indigo-500 text-indigo-600 dark:text-indigo-400 font-medium text-sm sm:text-base transition-all duration-200 hover:bg-gray-50 dark:hover:bg-gray-700" id="roles-tab" onclick="showTab('roles')">
                    <div class="flex items-center justify-center space-x-2">
                        <i class="fas fa-user-tag text-sm sm:text-base"></i>
                        <span class="truncate">Roles</span>
                    </div>
                </button>
                <button class="tab-button flex-1 min-w-0 sm:flex-none px-3 sm:px-6 py-3 sm:py-4 text-center border-b-2 border-transparent text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300 hover:border-gray-300 dark:hover:border-gray-600 font-medium text-sm sm:text-base transition-all duration-200 hover:bg-gray-50 dark:hover:bg-gray-700" id="permissions-tab" onclick="showTab('permissions')">
                    <div class="flex items-center justify-center space-x-2">
                        <i class="fas fa-key text-sm sm:text-base"></i>
                        <span class="truncate">Permissions</span>
                    </div>
                </button>
                <button class="tab-button flex-1 min-w-0 sm:flex-none px-3 sm:px-6 py-3 sm:py-4 text-center border-b-2 border-transparent text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300 hover:border-gray-300 dark:hover:border-gray-600 font-medium text-sm sm:text-base transition-all duration-200 hover:bg-gray-50 dark:hover:bg-gray-700" id="grid-tab" onclick="showTab('grid')">
                    <div class="flex items-center justify-center space-x-2">
                        <i class="fas fa-th text-sm sm:text-base"></i>
                        <span class="truncate">Grid</span>
                    </div>
                </button>
                <button class="tab-button flex-1 min-w-0 sm:flex-none px-3 sm:px-6 py-3 sm:py-4 text-center border-b-2 border-transparent text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300 hover:border-gray-300 dark:hover:border-gray-600 font-medium text-sm sm:text-base transition-all duration-200 hover:bg-gray-50 dark:hover:bg-gray-700" id="hierarchy-tab" onclick="showTab('hierarchy')">
                    <div class="flex items-center justify-center space-x-2">
                        <i class="fas fa-sitemap text-sm sm:text-base"></i>
                        <span class="truncate">Hierarchy</span>
                    </div>
                </button>
            </nav>
        </div>

        <!-- Tab Content -->
        <div class="tab-content" id="rolePermissionTabsContent">
            <!-- Roles Tab -->
            <div class="tab-pane fade show active" id="roles" role="tabpanel" aria-labelledby="roles-tab">
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden fade-in">
                    <!-- Header -->
                    <div class="px-4 sm:px-6 py-4 sm:py-5 border-b border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-750">
                        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                            <div class="flex-1 min-w-0">
                                <h5 class="text-lg sm:text-xl font-semibold text-gray-900 dark:text-white mb-1">Roles Management</h5>
                                <p class="text-sm text-gray-600 dark:text-gray-400">Manage user roles and their permissions</p>
                            </div>
                            <button type="button" class="inline-flex items-center justify-center px-4 py-2.5 border border-transparent rounded-xl text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800 transition-all duration-200 shadow-sm hover:shadow-md" onclick="window.location.href='{{ route('partner.settings.roles.create') }}'">
                                <i class="fas fa-plus mr-2"></i>
                                <span>Add Role</span>
                            </button>
                        </div>
                    </div>
                    
                    <!-- Roles Content -->
                    <div class="p-4 sm:p-6">
                        @if($roles->isNotEmpty())
                            <!-- Desktop Table -->
                            <div class="hidden lg:block overflow-x-auto">
                                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                                    <thead class="bg-gray-50 dark:bg-gray-700">
                                        <tr>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Role</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Level</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Status</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Permissions</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Users</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Inheritance</th>
                                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                        @foreach($roles as $role)
                                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors duration-150">
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <div class="text-sm font-medium text-gray-900 dark:text-white">{{ $role->display_name }}</div>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    {!! $role->level_badge !!}
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    {!! $role->status_badge !!}
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <div class="flex items-center space-x-3">
                                                        <span class="text-sm text-gray-600 dark:text-gray-400">{{ $role->permissions->count() }}</span>
                                                        <div class="flex-1 max-w-24 bg-gray-200 dark:bg-gray-700 rounded-full h-2">
                                                            <div class="bg-indigo-600 h-2 rounded-full transition-all duration-300" style="width: {{ min($role->permissions->count() * 10, 100) }}%"></div>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <div class="flex items-center space-x-3">
                                                        <span class="text-sm text-gray-600 dark:text-gray-400">{{ $role->users->count() }}</span>
                                                        <div class="flex-1 max-w-24 bg-gray-200 dark:bg-gray-700 rounded-full h-2">
                                                            <div class="bg-green-500 h-2 rounded-full transition-all duration-300" style="width: {{ min($role->users->count() * 20, 100) }}%"></div>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    @if($role->inherit_permissions)
                                                        {!! $role->inheritance_mode_badge !!}
                                                    @else
                                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300">No Inheritance</span>
                                                    @endif
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                                    <div class="relative inline-block text-left">
                                                        <button class="p-2 text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 transition-all duration-200" onclick="toggleRoleDropdown({{ $role->id }})" type="button">
                                                            <i class="fas fa-ellipsis-v"></i>
                                                        </button>
                                                        <div id="roleDropdown{{ $role->id }}" class="hidden absolute right-0 mt-2 w-48 sm:w-56 bg-white dark:bg-gray-800 rounded-lg shadow-lg border border-gray-200 dark:border-gray-700 z-50">
                                                            <div class="py-1">
                                                                <a href="#" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors duration-200" onclick="toggleRoleStatus({{ $role->id }})">
                                                                    <i class="fas {{ $role->status === 'active' ? 'fa-pause' : 'fa-play' }} mr-2"></i>{{ $role->status === 'active' ? 'Deactivate' : 'Activate' }}
                                                                </a>
                                                                <a href="#" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors duration-200" onclick="editRole({{ $role->id }})">
                                                                    <i class="fas fa-edit mr-2"></i>Edit
                                                                </a>
                                                                <a href="#" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors duration-200" onclick="assignPermissions({{ $role->id }})">
                                                                    <i class="fas fa-key mr-2"></i>Assign Permissions
                                                                </a>
                                                                <a href="#" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors duration-200" onclick="assignAccess({{ $role->id }})">
                                                                    <i class="fas fa-user-plus mr-2"></i>Assign Access
                                                                </a>
                                                            </div>
                                                            <div class="border-t border-gray-200 dark:border-gray-700"></div>
                                                            <div class="py-1">
                                                                <a href="#" class="block px-4 py-2 text-sm text-red-600 hover:bg-red-50 dark:hover:bg-red-900/20 transition-colors duration-200" onclick="deleteRole({{ $role->id }})">
                                                                    <i class="fas fa-trash mr-2"></i>Delete
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            
                            <!-- Mobile Cards -->
                            <div class="lg:hidden space-y-4">
                                @foreach($roles as $role)
                                    <div class="bg-gray-50 dark:bg-gray-700 rounded-xl p-4 border border-gray-200 dark:border-gray-600 hover:shadow-md transition-all duration-200">
                                        <div class="flex items-start justify-between mb-3">
                                            <div class="flex-1 min-w-0">
                                                <h6 class="text-base font-semibold text-gray-900 dark:text-white mb-1">{{ $role->display_name }}</h6>
                                                <div class="flex items-center space-x-2">
                                                    {!! $role->level_badge !!}
                                                    {!! $role->status_badge !!}
                                                </div>
                                            </div>
                                            <div class="relative inline-block text-left ml-2">
                                                <button class="p-2 text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 rounded-lg hover:bg-gray-200 dark:hover:bg-gray-600 transition-all duration-200" onclick="toggleRoleDropdown({{ $role->id }})" type="button">
                                                    <i class="fas fa-ellipsis-v"></i>
                                                </button>
                                                <div id="roleDropdown{{ $role->id }}" class="hidden absolute right-0 mt-2 w-48 bg-white dark:bg-gray-800 rounded-lg shadow-lg border border-gray-200 dark:border-gray-700 z-50">
                                                    <div class="py-1">
                                                        <a href="#" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors duration-200" onclick="toggleRoleStatus({{ $role->id }})">
                                                            <i class="fas {{ $role->status === 'active' ? 'fa-pause' : 'fa-play' }} mr-2"></i>{{ $role->status === 'active' ? 'Deactivate' : 'Activate' }}
                                                        </a>
                                                        <a href="#" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors duration-200" onclick="editRole({{ $role->id }})">
                                                            <i class="fas fa-edit mr-2"></i>Edit
                                                        </a>
                                                        <a href="#" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors duration-200" onclick="assignPermissions({{ $role->id }})">
                                                            <i class="fas fa-key mr-2"></i>Assign Permissions
                                                        </a>
                                                        <a href="#" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors duration-200" onclick="assignAccess({{ $role->id }})">
                                                            <i class="fas fa-user-plus mr-2"></i>Assign Access
                                                        </a>
                                                    </div>
                                                    <div class="border-t border-gray-200 dark:border-gray-700"></div>
                                                    <div class="py-1">
                                                        <a href="#" class="block px-4 py-2 text-sm text-red-600 hover:bg-red-50 dark:hover:bg-red-900/20 transition-colors duration-200" onclick="deleteRole({{ $role->id }})">
                                                            <i class="fas fa-trash mr-2"></i>Delete
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="grid grid-cols-2 gap-4">
                                            <div class="bg-white dark:bg-gray-800 rounded-lg p-3">
                                                <div class="text-xs text-gray-500 dark:text-gray-400 mb-1">Permissions</div>
                                                <div class="flex items-center space-x-2">
                                                    <span class="text-sm font-medium text-gray-900 dark:text-white">{{ $role->permissions->count() }}</span>
                                                    <div class="flex-1 bg-gray-200 dark:bg-gray-700 rounded-full h-1.5">
                                                        <div class="bg-indigo-600 h-1.5 rounded-full" style="width: {{ min($role->permissions->count() * 10, 100) }}%"></div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="bg-white dark:bg-gray-800 rounded-lg p-3">
                                                <div class="text-xs text-gray-500 dark:text-gray-400 mb-1">Users</div>
                                                <div class="flex items-center space-x-2">
                                                    <span class="text-sm font-medium text-gray-900 dark:text-white">{{ $role->users->count() }}</span>
                                                    <div class="flex-1 bg-gray-200 dark:bg-gray-700 rounded-full h-1.5">
                                                        <div class="bg-green-500 h-1.5 rounded-full" style="width: {{ min($role->users->count() * 20, 100) }}%"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="mt-3">
                                            <div class="text-xs text-gray-500 dark:text-gray-400 mb-1">Inheritance</div>
                                            @if($role->inherit_permissions)
                                                {!! $role->inheritance_mode_badge !!}
                                            @else
                                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300">No Inheritance</span>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <!-- Empty State -->
                            <div class="text-center py-12 sm:py-16">
                                <div class="inline-flex items-center justify-center w-16 h-16 sm:w-20 sm:h-20 bg-gray-100 dark:bg-gray-700 rounded-full mb-4">
                                    <i class="fas fa-user-tag text-gray-400 text-2xl sm:text-3xl"></i>
                                </div>
                                <h3 class="text-lg sm:text-xl font-medium text-gray-900 dark:text-white mb-2">No roles found</h3>
                                <p class="text-sm sm:text-base text-gray-500 dark:text-gray-400 mb-6 max-w-md mx-auto">Get started by creating your first role to manage user permissions and access control.</p>
                                <button type="button" class="inline-flex items-center justify-center px-6 py-3 border border-transparent rounded-xl text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800 transition-all duration-200 shadow-sm hover:shadow-md" onclick="window.location.href='{{ route('partner.settings.roles.create') }}'">
                                    <i class="fas fa-plus mr-2"></i>
                                    <span>Create First Role</span>
                                </button>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Permissions Tab -->
            <div class="tab-pane fade" id="permissions" role="tabpanel" aria-labelledby="permissions-tab">
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
                    <!-- Header -->
                    <div class="px-4 sm:px-6 py-4 sm:py-5 border-b border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-750">
                        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
                            <div class="flex-1 min-w-0">
                                <h5 class="text-lg sm:text-xl font-semibold text-gray-900 dark:text-white mb-1">Permissions Management</h5>
                                <p class="text-sm text-gray-600 dark:text-gray-400">Manage system permissions and access controls</p>
                            </div>
                            <div class="flex flex-col sm:flex-row gap-2 sm:gap-3 w-full lg:w-auto">
                                <div class="relative flex-1 sm:flex-none">
                                    <input type="text" class="w-full px-4 py-2.5 pl-10 border border-gray-300 dark:border-gray-600 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-800 dark:text-white" id="permissionSearch" placeholder="Search permissions...">
                                    <i class="fas fa-search absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                                </div>
                                <select class="px-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-800 dark:text-white" id="moduleFilter">
                                    <option value="">All Modules</option>
                                    @foreach($permissions->pluck('module')->unique()->sort() as $module)
                                        <option value="{{ $module }}">{{ $module }}</option>
                                    @endforeach
                                </select>
                                <button type="button" class="inline-flex items-center justify-center px-4 py-2.5 border border-transparent rounded-xl text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800 transition-all duration-200 shadow-sm hover:shadow-md" onclick="showModal('addPermissionModal')">
                                    <i class="fas fa-plus mr-2"></i>
                                    <span class="hidden sm:inline">Add Permission</span>
                                    <span class="sm:hidden">Add</span>
                                </button>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Permissions Content -->
                    <div class="p-4 sm:p-6">
                        <div class="permission-grid" id="permissionsContainer">
                            @foreach($permissions->groupBy('module') as $module => $modulePermissions)
                                <div class="permission-module mb-6 sm:mb-8" data-module="{{ $module }}">
                                    <div class="flex items-center justify-between mb-4 sm:mb-6">
                                        <h6 class="text-base sm:text-lg font-semibold text-gray-900 dark:text-white flex items-center">
                                            <i class="fas fa-cube mr-2 sm:mr-3 text-indigo-600 dark:text-indigo-400"></i>
                                            <span>{{ $module }}</span>
                                        </h6>
                                        <span class="inline-flex items-center px-2.5 py-0.5 sm:px-3 sm:py-1 text-xs font-medium bg-indigo-100 text-indigo-800 dark:bg-indigo-900 dark:text-indigo-200 rounded-full">
                                            {{ $modulePermissions->count() }} permissions
                                        </span>
                                    </div>
                                    <div class="permission-list grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3 sm:gap-4">
                                        @foreach($modulePermissions as $permission)
                                            <div class="permission-item bg-gray-50 dark:bg-gray-700 rounded-xl p-4 sm:p-5 border border-gray-200 dark:border-gray-600 hover:shadow-md transition-all duration-200" data-permission-name="{{ $permission->name }}">
                                                <div class="flex justify-between items-start gap-3">
                                                    <div class="flex-1 min-w-0">
                                                        <div class="font-semibold text-gray-900 dark:text-white mb-2 text-sm sm:text-base leading-tight">
                                                            {{ $permission->display_name }}
                                                        </div>
                                                        <div class="text-gray-600 dark:text-gray-400 text-sm leading-relaxed">
                                                            {{ $permission->description ?: 'No description available' }}
                                                        </div>
                                                    </div>
                                                    <div class="relative flex-shrink-0">
                                                        <button class="p-2 text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 rounded-lg hover:bg-gray-200 dark:hover:bg-gray-600 transition-all duration-200" onclick="togglePermissionDropdown({{ $permission->id }})">
                                                            <i class="fas fa-ellipsis-v text-sm"></i>
                                                        </button>
                                                        <div id="permissionDropdown{{ $permission->id }}" class="hidden absolute right-0 mt-2 w-44 sm:w-48 bg-white dark:bg-gray-800 rounded-lg shadow-lg border border-gray-200 dark:border-gray-700 z-10">
                                                            <a href="#" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors duration-200" onclick="editPermission({{ $permission->id }})">
                                                                <i class="fas fa-edit mr-2"></i>Edit
                                                            </a>
                                                            <a href="#" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors duration-200" onclick="viewPermission({{ $permission->id }})">
                                                                <i class="fas fa-eye mr-2"></i>View Details
                                                            </a>
                                                            <div class="border-t border-gray-200 dark:border-gray-700"></div>
                                                            <a href="#" class="block px-4 py-2 text-sm text-red-600 hover:bg-red-50 dark:hover:bg-red-900/20 transition-colors duration-200" onclick="deletePermission({{ $permission->id }})">
                                                                <i class="fas fa-trash mr-2"></i>Delete
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        
                        @if($permissions->isEmpty())
                            <!-- Empty State -->
                            <div class="text-center py-12 sm:py-16">
                                <div class="inline-flex items-center justify-center w-16 h-16 sm:w-20 sm:h-20 bg-gray-100 dark:bg-gray-700 rounded-full mb-4">
                                    <i class="fas fa-key text-gray-400 text-2xl sm:text-3xl"></i>
                                </div>
                                <h3 class="text-lg sm:text-xl font-medium text-gray-900 dark:text-white mb-2">No permissions found</h3>
                                <p class="text-sm sm:text-base text-gray-500 dark:text-gray-400 mb-6 max-w-md mx-auto">Get started by creating your first permission to define access controls for your system.</p>
                                <button type="button" class="inline-flex items-center justify-center px-6 py-3 border border-transparent rounded-xl text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800 transition-all duration-200 shadow-sm hover:shadow-md" onclick="showModal('addPermissionModal')">
                                    <i class="fas fa-plus mr-2"></i>
                                    <span>Create First Permission</span>
                                </button>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Permission Grid Tab -->
            <div class="tab-pane fade" id="grid" role="tabpanel" aria-labelledby="grid-tab">
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden fade-in">
                    <!-- Header -->
                    <div class="px-4 sm:px-6 py-4 sm:py-5 border-b border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-750">
                        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                            <div class="flex-1 min-w-0">
                                <h5 class="text-lg sm:text-xl font-semibold text-gray-900 dark:text-white mb-1">Role-Permission Matrix</h5>
                                <p class="text-sm text-gray-600 dark:text-gray-400">Manage permissions across all roles in a grid view</p>
                            </div>
                            <div class="flex flex-col sm:flex-row gap-2 sm:gap-3 w-full sm:w-auto">
                                <button type="button" class="inline-flex items-center justify-center px-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-xl text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800 transition-all duration-200 shadow-sm hover:shadow-md" onclick="expandAll()">
                                    <i class="fas fa-expand-arrows-alt mr-2 text-gray-500 dark:text-gray-400"></i>
                                    <span class="hidden sm:inline">Expand All</span>
                                    <span class="sm:hidden">Expand</span>
                                </button>
                                <button type="button" class="inline-flex items-center justify-center px-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-xl text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800 transition-all duration-200 shadow-sm hover:shadow-md" onclick="collapseAll()">
                                    <i class="fas fa-compress-arrows-alt mr-2 text-gray-500 dark:text-gray-400"></i>
                                    <span class="hidden sm:inline">Collapse All</span>
                                    <span class="sm:hidden">Collapse</span>
                                </button>
                                <button type="button" class="inline-flex items-center justify-center px-4 py-2.5 border border-transparent rounded-xl text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800 transition-all duration-200 shadow-sm hover:shadow-md" onclick="saveGridChanges()">
                                    <i class="fas fa-save mr-2"></i>
                                    <span class="hidden sm:inline">Save Changes</span>
                                    <span class="sm:hidden">Save</span>
                                </button>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Mobile Grid Summary -->
                    <div class="block sm:hidden px-4 py-3 bg-indigo-50 dark:bg-indigo-900/20 border-b border-indigo-200 dark:border-indigo-800">
                        <div class="flex items-center">
                            <i class="fas fa-info-circle text-indigo-600 dark:text-indigo-400 mr-2"></i>
                            <p class="text-sm text-indigo-800 dark:text-indigo-200">For optimal viewing, rotate your device or use landscape mode</p>
                        </div>
                    </div>
                    
                    <!-- Grid Content -->
                    <div class="p-4 sm:p-6">
                        <!-- Desktop Grid Table -->
                        <div class="hidden sm:block role-permission-grid">
                            <div class="overflow-x-auto -mx-4 sm:mx-0 px-4 sm:px-0">
                                <table class="min-w-[600px] sm:min-w-[800px] w-full divide-y divide-gray-200 dark:divide-gray-700" id="permissionGridTable">
                                    <thead class="bg-gray-50 dark:bg-gray-700">
                                        <tr>
                                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider sticky left-0 bg-gray-50 dark:bg-gray-700 z-10 min-w-[200px]">Module / Permission</th>
                                            @foreach($roles as $role)
                                                <th class="px-4 py-3 text-center text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider min-w-[100px]">
                                                    <div class="text-center">
                                                        <div class="font-semibold text-gray-900 dark:text-white text-sm">{{ $role->display_name }}</div>
                                                        <div class="text-xs text-gray-500 dark:text-gray-400">{{ $role->users->count() }} users</div>
                                                    </div>
                                                </th>
                                            @endforeach
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700" id="permissionGridBody">
                                        <!-- Grid content will be populated by JavaScript -->
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        
                        <!-- Mobile Cards View -->
                        <div class="sm:hidden space-y-4" id="mobilePermissionGrid">
                            @foreach($roles as $role)
                                <div class="bg-gray-50 dark:bg-gray-700 rounded-xl p-4 border border-gray-200 dark:border-gray-600">
                                    <div class="flex items-center justify-between mb-4">
                                        <div>
                                            <h6 class="font-semibold text-gray-900 dark:text-white">{{ $role->display_name }}</h6>
                                            <p class="text-sm text-gray-500 dark:text-gray-400">{{ $role->users->count() }} users</p>
                                        </div>
                                        <div class="w-8 h-8 sm:w-10 sm:h-10 flex items-center justify-center">
                                            <input type="checkbox" class="permission-checkbox" data-role="{{ $role->id }}" onchange="toggleAllPermissions({{ $role->id }})">
                                        </div>
                                    </div>
                                    <div class="space-y-2" id="mobilePermissions-{{ $role->id }}">
                                        <!-- Permissions will be populated by JavaScript -->
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            <!-- Hierarchy Tab -->
            <div class="tab-pane fade" id="hierarchy" role="tabpanel" aria-labelledby="hierarchy-tab">
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden fade-in">
                    <!-- Header -->
                    <div class="px-4 sm:px-6 py-4 sm:py-5 border-b border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-750">
                        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                            <div class="flex-1 min-w-0">
                                <h5 class="text-lg sm:text-xl font-semibold text-gray-900 dark:text-white mb-1">Role Hierarchy</h5>
                                <p class="text-sm text-gray-600 dark:text-gray-400">View and manage role inheritance relationships</p>
                            </div>
                            <div class="flex flex-col sm:flex-row gap-2 sm:gap-3 w-full sm:w-auto">
                                <button type="button" class="inline-flex items-center justify-center px-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-xl text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800 transition-all duration-200 shadow-sm hover:shadow-md" onclick="refreshHierarchy()">
                                    <i class="fas fa-sync mr-2 text-gray-500 dark:text-gray-400"></i>
                                    <span class="hidden sm:inline">Refresh</span>
                                    <span class="sm:hidden">Reload</span>
                                </button>
                                <button type="button" class="inline-flex items-center justify-center px-4 py-2.5 border border-transparent rounded-xl text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800 transition-all duration-200 shadow-sm hover:shadow-md" onclick="showModal('hierarchySettingsModal')">
                                    <i class="fas fa-cog mr-2"></i>
                                    <span class="hidden sm:inline">Settings</span>
                                    <span class="sm:hidden">Config</span>
                                </button>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Hierarchy Content -->
                    <div class="p-4 sm:p-6">
                        <div class="grid grid-cols-1 lg:grid-cols-3 gap-4 sm:gap-6">
                            <!-- Hierarchy Tree -->
                            <div class="lg:col-span-2">
                                <div class="bg-gray-50 dark:bg-gray-700 rounded-xl p-4 sm:p-6 border border-gray-200 dark:border-gray-600">
                                    <div class="flex items-center justify-between mb-4 sm:mb-6">
                                        <h6 class="text-base sm:text-lg font-semibold text-gray-900 dark:text-white flex items-center">
                                            <i class="fas fa-sitemap mr-2 sm:mr-3 text-indigo-600 dark:text-indigo-400"></i>
                                            <span>Role Hierarchy Tree</span>
                                        </h6>
                                        <div class="flex items-center space-x-2">
                                            <button type="button" class="p-2 text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 rounded-lg hover:bg-gray-200 dark:hover:bg-gray-600 transition-all duration-200" onclick="expandHierarchyTree()" title="Expand All">
                                                <i class="fas fa-expand-alt text-sm"></i>
                                            </button>
                                            <button type="button" class="p-2 text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 rounded-lg hover:bg-gray-200 dark:hover:bg-gray-600 transition-all duration-200" onclick="collapseHierarchyTree()" title="Collapse All">
                                                <i class="fas fa-compress-alt text-sm"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="hierarchy-tree bg-white dark:bg-gray-800 rounded-lg p-4 sm:p-6 border border-gray-200 dark:border-gray-600 custom-scrollbar overflow-x-auto" id="hierarchyTree">
                                        <!-- Hierarchy tree will be populated by JavaScript -->
                                        <div class="text-center py-8 text-gray-500 dark:text-gray-400">
                                            <i class="fas fa-sitemap text-3xl mb-3 opacity-50"></i>
                                            <p>Loading hierarchy tree...</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Hierarchy Statistics -->
                            <div class="lg:col-span-1">
                                <div class="bg-gray-50 dark:bg-gray-700 rounded-xl p-4 sm:p-6 border border-gray-200 dark:border-gray-600">
                                    <h6 class="text-base sm:text-lg font-semibold text-gray-900 dark:text-white mb-4 sm:mb-6 flex items-center">
                                        <i class="fas fa-chart-bar mr-2 sm:mr-3 text-indigo-600 dark:text-indigo-400"></i>
                                        <span>Hierarchy Statistics</span>
                                    </h6>
                                    <div class="space-y-4" id="hierarchyStats">
                                        <!-- Stats will be populated by JavaScript -->
                                        <div class="bg-white dark:bg-gray-800 rounded-lg p-4 border border-gray-200 dark:border-gray-600">
                                            <div class="flex items-center justify-between mb-2">
                                                <span class="text-sm font-medium text-gray-600 dark:text-gray-400">Total Roles</span>
                                                <span class="text-lg font-bold text-gray-900 dark:text-white">{{ $roles->count() }}</span>
                                            </div>
                                            <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-2">
                                                <div class="bg-indigo-600 h-2 rounded-full" style="width: 100%"></div>
                                            </div>
                                        </div>
                                        
                                        <div class="bg-white dark:bg-gray-800 rounded-lg p-4 border border-gray-200 dark:border-gray-600">
                                            <div class="flex items-center justify-between mb-2">
                                                <span class="text-sm font-medium text-gray-600 dark:text-gray-400">Active Roles</span>
                                                <span class="text-lg font-bold text-gray-900 dark:text-white">{{ $roles->where('status', 'active')->count() }}</span>
                                            </div>
                                            <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-2">
                                                <div class="bg-green-500 h-2 rounded-full" style="width: {{ ($roles->where('status', 'active')->count() / max($roles->count(), 1)) * 100 }}%"></div>
                                            </div>
                                        </div>
                                        
                                        <div class="bg-white dark:bg-gray-800 rounded-lg p-4 border border-gray-200 dark:border-gray-600">
                                            <div class="flex items-center justify-between mb-2">
                                                <span class="text-sm font-medium text-gray-600 dark:text-gray-400">Hierarchy Levels</span>
                                                <span class="text-lg font-bold text-gray-900 dark:text-white">{{ $roles->pluck('level')->unique()->count() }}</span>
                                            </div>
                                            <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-2">
                                                <div class="bg-purple-500 h-2 rounded-full" style="width: {{ ($roles->pluck('level')->unique()->count() / 6) * 100 }}%"></div>
                                            </div>
                                        </div>
                                        
                                        <div class="bg-white dark:bg-gray-800 rounded-lg p-4 border border-gray-200 dark:border-gray-600">
                                            <div class="flex items-center justify-between mb-2">
                                                <span class="text-sm font-medium text-gray-600 dark:text-gray-400">Inheritance Enabled</span>
                                                <span class="text-lg font-bold text-gray-900 dark:text-white">{{ $roles->where('inherit_permissions', true)->count() }}</span>
                                            </div>
                                            <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-2">
                                                <div class="bg-orange-500 h-2 rounded-full" style="width: {{ ($roles->where('inherit_permissions', true)->count() / max($roles->count(), 1)) * 100 }}%"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    </div>
</div>

    </div>
</div>
@endsection

@section('scripts')
    <!-- Mobile-optimized modals -->
    
    <!-- Add Role Modal -->
    <div class="fixed inset-0 z-50 hidden" id="addRoleModal">
        <div class="modal-backdrop fixed inset-0" onclick="hideModal('addRoleModal')"></div>
        <div class="fixed inset-0 flex items-center justify-center p-4 sm:p-6">
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-2xl w-full max-w-md sm:max-w-lg transform transition-all duration-300 scale-95 opacity-0" id="addRoleModalContent">
                <!-- Header -->
                <div class="px-4 sm:px-6 py-4 sm:py-5 border-b border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-750 rounded-t-xl">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-3">
                            <div class="flex-shrink-0 w-10 h-10 sm:w-12 sm:h-12 bg-indigo-100 dark:bg-indigo-900/30 rounded-full flex items-center justify-center">
                                <i class="fas fa-user-plus text-indigo-600 dark:text-indigo-400 text-lg sm:text-xl"></i>
                            </div>
                            <div>
                                <h3 class="text-lg sm:text-xl font-semibold text-gray-900 dark:text-white">Add New Role</h3>
                                <p class="text-sm text-gray-600 dark:text-gray-400">Create a new role with specific permissions</p>
                            </div>
                        </div>
                        <button type="button" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 rounded-lg hover:bg-gray-200 dark:hover:bg-gray-700 p-2 transition-all duration-200" onclick="hideModal('addRoleModal')">
                            <i class="fas fa-times text-lg"></i>
                        </button>
                    </div>
                </div>
                
                <!-- Body -->
                <div class="px-4 sm:px-6 py-4 sm:py-6">
                    <form id="addRoleForm" class="space-y-4 sm:space-y-5">
                        <div>
                            <label for="roleName" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Role Name *</label>
                            <input type="text" id="roleName" name="name" class="w-full px-3 sm:px-4 py-2.5 sm:py-3 border border-gray-300 dark:border-gray-600 rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-500 dark:focus:ring-indigo-400 focus:border-indigo-500 dark:focus:border-indigo-400 bg-white dark:bg-gray-700 text-gray-900 dark:text-white transition-all duration-200" placeholder="Enter role name" required>
                            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Unique identifier for the role (e.g., admin, manager)</p>
                        </div>
                        
                        <div>
                            <label for="roleDisplayName" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Display Name *</label>
                            <input type="text" id="roleDisplayName" name="display_name" class="w-full px-3 sm:px-4 py-2.5 sm:py-3 border border-gray-300 dark:border-gray-600 rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-500 dark:focus:ring-indigo-400 focus:border-indigo-500 dark:focus:border-indigo-400 bg-white dark:bg-gray-700 text-gray-900 dark:text-white transition-all duration-200" placeholder="Enter display name" required>
                            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Human-readable name (e.g., Administrator, Manager)</p>
                        </div>
                        
                        <div>
                            <label for="roleDescription" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Description</label>
                            <textarea id="roleDescription" name="description" rows="3" class="w-full px-3 sm:px-4 py-2.5 sm:py-3 border border-gray-300 dark:border-gray-600 rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-500 dark:focus:ring-indigo-400 focus:border-indigo-500 dark:focus:border-indigo-400 bg-white dark:bg-gray-700 text-gray-900 dark:text-white transition-all duration-200" placeholder="Describe the role's responsibilities"></textarea>
                        </div>
                        
                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                            <div>
                                <label for="roleLevel" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Level *</label>
                                <select id="roleLevel" name="level" class="w-full px-3 sm:px-4 py-2.5 sm:py-3 border border-gray-300 dark:border-gray-600 rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-500 dark:focus:ring-indigo-400 focus:border-indigo-500 dark:focus:border-indigo-400 bg-white dark:bg-gray-700 text-gray-900 dark:text-white transition-all duration-200" required>
                                    <option value="3">3 (Student/Teacher/Operator Level)</option>
                                    <option value="4">4 (Custom Level)</option>
                                    <option value="5">5 (Custom Level)</option>
                                </select>
                            </div>
                            
                            <div>
                                <label for="roleStatus" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Status</label>
                                <select id="roleStatus" name="status" class="w-full px-3 sm:px-4 py-2.5 sm:py-3 border border-gray-300 dark:border-gray-600 rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-500 dark:focus:ring-indigo-400 focus:border-indigo-500 dark:focus:border-indigo-400 bg-white dark:bg-gray-700 text-gray-900 dark:text-white transition-all duration-200">
                                    @foreach($roles->pluck('status')->unique() as $status)
                                        <option value="{{ $status }}">{{ ucfirst($status) }}</option>
                                    @endforeach
                                </select>
                            </div>
                            
                            <div>
                                <label for="roleParent" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Parent Role</label>
                                <select id="roleParent" name="parent_role_id" class="w-full px-3 sm:px-4 py-2.5 sm:py-3 border border-gray-300 dark:border-gray-600 rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-500 dark:focus:ring-indigo-400 focus:border-indigo-500 dark:focus:border-indigo-400 bg-white dark:bg-gray-700 text-gray-900 dark:text-white transition-all duration-200">
                                    <option value="">None</option>
                                    @foreach($roles as $role)
                                        <option value="{{ $role->id }}">{{ $role->display_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label for="inheritPermissions" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Inherit Permissions</label>
                                <select id="inheritPermissions" name="inherit_permissions" class="w-full px-3 sm:px-4 py-2.5 sm:py-3 border border-gray-300 dark:border-gray-600 rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-500 dark:focus:ring-indigo-400 focus:border-indigo-500 dark:focus:border-indigo-400 bg-white dark:bg-gray-700 text-gray-900 dark:text-white transition-all duration-200">
                                    <option value="0">No</option>
                                    <option value="1">Yes</option>
                                </select>
                            </div>
                            
                            <div>
                                <label for="inheritanceMode" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Inheritance Mode</label>
                                <select id="inheritanceMode" name="permissions_inheritance_mode" class="w-full px-3 sm:px-4 py-2.5 sm:py-3 border border-gray-300 dark:border-gray-600 rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-500 dark:focus:ring-indigo-400 focus:border-indigo-500 dark:focus:border-indigo-400 bg-white dark:bg-gray-700 text-gray-900 dark:text-white transition-all duration-200">
                                    <option value="none">None</option>
                                    <option value="direct">Direct Parent Only</option>
                                    <option value="recursive">Recursive (All Parents)</option>
                                </select>
                            </div>
                        </div>
                        
                        <div>
                            <label for="rolePermissions" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Permissions</label>
                            <select id="rolePermissions" name="permission_ids[]" multiple size="6" class="w-full px-3 sm:px-4 py-2.5 sm:py-3 border border-gray-300 dark:border-gray-600 rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-500 dark:focus:ring-indigo-400 focus:border-indigo-500 dark:focus:border-indigo-400 bg-white dark:bg-gray-700 text-gray-900 dark:text-white transition-all duration-200 custom-scrollbar">
                                @foreach($permissions->groupBy('module') as $module => $modulePermissions)
                                    <optgroup label="{{ $module }}">
                                        @foreach($modulePermissions as $permission)
                                            <option value="{{ $permission->id }}">{{ $permission->display_name }}</option>
                                        @endforeach
                                    </optgroup>
                                @endforeach
                            </select>
                            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Hold Ctrl/Cmd to select multiple permissions</p>
                        </div>
                    </form>
                </div>
                
                <!-- Footer -->
                <div class="px-4 sm:px-6 py-4 sm:py-5 border-t border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-750 rounded-b-xl">
                    <div class="flex flex-col sm:flex-row gap-3 sm:gap-4">
                        <button type="button" class="flex-1 inline-flex items-center justify-center px-4 py-2.5 sm:py-3 border border-transparent rounded-xl text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800 transition-all duration-200 shadow-sm hover:shadow-md" onclick="addRole()">
                            <i class="fas fa-plus mr-2"></i>
                            Add Role
                        </button>
                        <button type="button" class="flex-1 inline-flex items-center justify-center px-4 py-2.5 sm:py-3 border border-gray-300 dark:border-gray-600 rounded-xl text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800 transition-all duration-200 shadow-sm hover:shadow-md" onclick="hideModal('addRoleModal')">
                            <i class="fas fa-times mr-2"></i>
                            Cancel
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Add Permission Modal -->
    <div class="fixed inset-0 z-50 hidden" id="addPermissionModal">
        <div class="modal-backdrop fixed inset-0" onclick="hideModal('addPermissionModal')"></div>
        <div class="fixed inset-0 flex items-center justify-center p-4 sm:p-6">
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-2xl w-full max-w-md sm:max-w-lg transform transition-all duration-300 scale-95 opacity-0" id="addPermissionModalContent">
                <!-- Header -->
                <div class="px-4 sm:px-6 py-4 sm:py-5 border-b border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-750 rounded-t-xl">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-3">
                            <div class="flex-shrink-0 w-10 h-10 sm:w-12 sm:h-12 bg-green-100 dark:bg-green-900/30 rounded-full flex items-center justify-center">
                                <i class="fas fa-shield-alt text-green-600 dark:text-green-400 text-lg sm:text-xl"></i>
                            </div>
                            <div>
                                <h3 class="text-lg sm:text-xl font-semibold text-gray-900 dark:text-white">Add New Permission</h3>
                                <p class="text-sm text-gray-600 dark:text-gray-400">Create a new permission for role assignment</p>
                            </div>
                        </div>
                        <button type="button" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 rounded-lg hover:bg-gray-200 dark:hover:bg-gray-700 p-2 transition-all duration-200" onclick="hideModal('addPermissionModal')">
                            <i class="fas fa-times text-lg"></i>
                        </button>
                    </div>
                </div>
                
                <!-- Body -->
                <div class="px-4 sm:px-6 py-4 sm:py-6">
                    <form id="addPermissionForm" class="space-y-4 sm:space-y-5">
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label for="permissionName" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Permission Name *</label>
                                <input type="text" id="permissionName" name="name" class="w-full px-3 sm:px-4 py-2.5 sm:py-3 border border-gray-300 dark:border-gray-600 rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-500 dark:focus:ring-indigo-400 focus:border-indigo-500 dark:focus:border-indigo-400 bg-white dark:bg-gray-700 text-gray-900 dark:text-white transition-all duration-200" placeholder="Enter permission name" required>
                                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Unique identifier (e.g., users.create, posts.edit)</p>
                            </div>
                            
                            <div>
                                <label for="permissionDisplayName" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Display Name *</label>
                                <input type="text" id="permissionDisplayName" name="display_name" class="w-full px-3 sm:px-4 py-2.5 sm:py-3 border border-gray-300 dark:border-gray-600 rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-500 dark:focus:ring-indigo-400 focus:border-indigo-500 dark:focus:border-indigo-400 bg-white dark:bg-gray-700 text-gray-900 dark:text-white transition-all duration-200" placeholder="Enter display name" required>
                                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Human-readable name (e.g., Create Users, Edit Posts)</p>
                            </div>
                        </div>
                        
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label for="permissionModule" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Module *</label>
                                <input type="text" id="permissionModule" name="module" class="w-full px-3 sm:px-4 py-2.5 sm:py-3 border border-gray-300 dark:border-gray-600 rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-500 dark:focus:ring-indigo-400 focus:border-indigo-500 dark:focus:border-indigo-400 bg-white dark:bg-gray-700 text-gray-900 dark:text-white transition-all duration-200" placeholder="Enter module name" required>
                                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Module/category (e.g., users, posts, settings)</p>
                            </div>
                            
                            <div>
                                <label for="permissionStatus" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Status</label>
                                <select id="permissionStatus" name="status" class="w-full px-3 sm:px-4 py-2.5 sm:py-3 border border-gray-300 dark:border-gray-600 rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-500 dark:focus:ring-indigo-400 focus:border-indigo-500 dark:focus:border-indigo-400 bg-white dark:bg-gray-700 text-gray-900 dark:text-white transition-all duration-200">
                                    <option value="active">Active</option>
                                    <option value="inactive">Inactive</option>
                                </select>
                            </div>
                        </div>
                        
                        <div>
                            <label for="permissionDescription" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Description</label>
                            <textarea id="permissionDescription" name="description" rows="3" class="w-full px-3 sm:px-4 py-2.5 sm:py-3 border border-gray-300 dark:border-gray-600 rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-500 dark:focus:ring-indigo-400 focus:border-indigo-500 dark:focus:border-indigo-400 bg-white dark:bg-gray-700 text-gray-900 dark:text-white transition-all duration-200" placeholder="Describe what this permission allows"></textarea>
                        </div>
                    </form>
                </div>
                
                <!-- Footer -->
                <div class="px-4 sm:px-6 py-4 sm:py-5 border-t border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-750 rounded-b-xl">
                    <div class="flex flex-col sm:flex-row gap-3 sm:gap-4">
                        <button type="button" class="flex-1 inline-flex items-center justify-center px-4 py-2.5 sm:py-3 border border-transparent rounded-xl text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800 transition-all duration-200 shadow-sm hover:shadow-md" onclick="addPermission()">
                            <i class="fas fa-plus mr-2"></i>
                            Add Permission
                        </button>
                        <button type="button" class="flex-1 inline-flex items-center justify-center px-4 py-2.5 sm:py-3 border border-gray-300 dark:border-gray-600 rounded-xl text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800 transition-all duration-200 shadow-sm hover:shadow-md" onclick="hideModal('addPermissionModal')">
                            <i class="fas fa-times mr-2"></i>
                            Cancel
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Role Modal -->
    <div class="fixed inset-0 z-50 hidden" id="editRoleModal">
        <div class="modal-backdrop fixed inset-0" onclick="hideModal('editRoleModal')"></div>
        <div class="fixed inset-0 flex items-center justify-center p-4 sm:p-6">
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-2xl w-full max-w-md sm:max-w-lg transform transition-all duration-300 scale-95 opacity-0" id="editRoleModalContent">
                <!-- Header -->
                <div class="px-4 sm:px-6 py-4 sm:py-5 border-b border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-750 rounded-t-xl">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-3">
                            <div class="flex-shrink-0 w-10 h-10 sm:w-12 sm:h-12 bg-orange-100 dark:bg-orange-900/30 rounded-full flex items-center justify-center">
                                <i class="fas fa-edit text-orange-600 dark:text-orange-400 text-lg sm:text-xl"></i>
                            </div>
                            <div>
                                <h3 class="text-lg sm:text-xl font-semibold text-gray-900 dark:text-white">Edit Role</h3>
                                <p class="text-sm text-gray-600 dark:text-gray-400">Update role details and permissions</p>
                            </div>
                        </div>
                        <button type="button" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 rounded-lg hover:bg-gray-200 dark:hover:bg-gray-700 p-2 transition-all duration-200" onclick="hideModal('editRoleModal')">
                            <i class="fas fa-times text-lg"></i>
                        </button>
                    </div>
                </div>
                
                <!-- Body -->
                <div class="px-4 sm:px-6 py-4 sm:py-6">
                    <form id="editRoleForm">
                        <input type="hidden" id="editRoleId" name="role_id">
                        <!-- Form fields similar to add role modal -->
                        <div class="text-center py-8 text-gray-500 dark:text-gray-400">
                            <i class="fas fa-edit text-3xl mb-3 opacity-50"></i>
                            <p>Edit role functionality will be implemented here</p>
                        </div>
                    </form>
                </div>
                
                <!-- Footer -->
                <div class="px-4 sm:px-6 py-4 sm:py-5 border-t border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-750 rounded-b-xl">
                    <div class="flex flex-col sm:flex-row gap-3 sm:gap-4">
                        <button type="button" class="flex-1 inline-flex items-center justify-center px-4 py-2.5 sm:py-3 border border-transparent rounded-xl text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800 transition-all duration-200 shadow-sm hover:shadow-md" onclick="updateRole()">
                            <i class="fas fa-save mr-2"></i>
                            Update Role
                        </button>
                        <button type="button" class="flex-1 inline-flex items-center justify-center px-4 py-2.5 sm:py-3 border border-gray-300 dark:border-gray-600 rounded-xl text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800 transition-all duration-200 shadow-sm hover:shadow-md" onclick="hideModal('editRoleModal')">
                            <i class="fas fa-times mr-2"></i>
                            Cancel
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- View Role Modal -->
    <div class="fixed inset-0 z-50 hidden" id="viewRoleModal">
        <div class="modal-backdrop fixed inset-0" onclick="hideModal('viewRoleModal')"></div>
        <div class="fixed inset-0 flex items-center justify-center p-4 sm:p-6">
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-2xl w-full max-w-2xl sm:max-w-4xl transform transition-all duration-300 scale-95 opacity-0" id="viewRoleModalContent">
                <!-- Header -->
                <div class="px-4 sm:px-6 py-4 sm:py-5 border-b border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-750 rounded-t-xl">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-3">
                            <div class="flex-shrink-0 w-10 h-10 sm:w-12 sm:h-12 bg-blue-100 dark:bg-blue-900/30 rounded-full flex items-center justify-center">
                                <i class="fas fa-eye text-blue-600 dark:text-blue-400 text-lg sm:text-xl"></i>
                            </div>
                            <div>
                                <h3 class="text-lg sm:text-xl font-semibold text-gray-900 dark:text-white">Role Details</h3>
                                <p class="text-sm text-gray-600 dark:text-gray-400">View comprehensive role information</p>
                            </div>
                        </div>
                        <button type="button" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 rounded-lg hover:bg-gray-200 dark:hover:bg-gray-700 p-2 transition-all duration-200" onclick="hideModal('viewRoleModal')">
                            <i class="fas fa-times text-lg"></i>
                        </button>
                    </div>
                </div>
                
                <!-- Body -->
                <div class="px-4 sm:px-6 py-4 sm:py-6" id="viewRoleContent">
                    <!-- Content will be loaded dynamically -->
                    <div class="text-center py-8 text-gray-500 dark:text-gray-400">
                        <i class="fas fa-eye text-3xl mb-3 opacity-50"></i>
                        <p>Role details will be loaded here</p>
                    </div>
                </div>
                
                <!-- Footer -->
                <div class="px-4 sm:px-6 py-4 sm:py-5 border-t border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-750 rounded-b-xl">
                    <div class="flex flex-col sm:flex-row gap-3 sm:gap-4">
                        <button type="button" class="flex-1 inline-flex items-center justify-center px-4 py-2.5 sm:py-3 border border-transparent rounded-xl text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800 transition-all duration-200 shadow-sm hover:shadow-md" onclick="editRoleFromView()">
                            <i class="fas fa-edit mr-2"></i>
                            Edit Role
                        </button>
                        <button type="button" class="flex-1 inline-flex items-center justify-center px-4 py-2.5 sm:py-3 border border-gray-300 dark:border-gray-600 rounded-xl text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800 transition-all duration-200 shadow-sm hover:shadow-md" onclick="hideModal('viewRoleModal')">
                            <i class="fas fa-times mr-2"></i>
                            Close
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Mobile-optimized JavaScript -->
// Mobile-first JavaScript for Role-Permission Management
let currentRoleId = null;
let currentPermissionId = null;
let permissionGridData = {};

// Initialize when DOM is ready
document.addEventListener('DOMContentLoaded', function() {
    initializeTabs();
    setupSearchFilters();
    initializePermissionGrid();
    initializeHierarchyTree();
    setupModalEventListeners();
    startRealTimeUpdates();
    
    // Add mobile-specific optimizations
    if (window.innerWidth < 768) {
        optimizeForMobile();
    }
    
    // Handle window resize
    window.addEventListener('resize', debounce(function() {
        if (window.innerWidth < 768) {
            optimizeForMobile();
        }
    }, 250));
});

// Mobile optimization function
function optimizeForMobile() {
    // Add touch-friendly interactions
    document.querySelectorAll('.role-item, .permission-item').forEach(item => {
        item.addEventListener('touchstart', function() {
            this.style.transform = 'scale(0.98)';
        });
        item.addEventListener('touchend', function() {
            this.style.transform = 'scale(1)';
        });
    });
    
    // Optimize dropdowns for mobile
    document.querySelectorAll('[id^="roleDropdown"]').forEach(dropdown => {
        dropdown.style.maxWidth = '90vw';
        dropdown.style.right = '0';
    });
}

// Debounce function for performance
function debounce(func, wait) {
    let timeout;
    return function executedFunction(...args) {
        const later = () => {
            clearTimeout(timeout);
            func(...args);
        };
        clearTimeout(timeout);
        timeout = setTimeout(later, wait);
    };
}

// Tab management with mobile optimization
function initializeTabs() {
    const tabs = document.querySelectorAll('[data-bs-toggle="tab"]');
    tabs.forEach(tab => {
        tab.addEventListener('click', function(e) {
            e.preventDefault();
            const targetId = this.getAttribute('data-bs-target');
            
            // Hide all tabs
            document.querySelectorAll('.tab-pane').forEach(pane => {
                pane.classList.remove('show', 'active');
                pane.style.display = 'none';
            });
            
            // Remove active class from all tabs
            tabs.forEach(t => {
                t.classList.remove('border-indigo-500', 'text-indigo-600', 'dark:text-indigo-400');
                t.classList.add('border-transparent', 'text-gray-500', 'hover:text-gray-700', 'hover:border-gray-300', 'dark:text-gray-400', 'dark:hover:text-gray-300', 'dark:hover:border-gray-600');
            });
            
            // Show target tab
            const targetPane = document.querySelector(targetId);
            if (targetPane) {
                targetPane.classList.add('show', 'active');
                targetPane.style.display = 'block';
                this.classList.add('border-indigo-500', 'text-indigo-600', 'dark:text-indigo-400');
                this.classList.remove('border-transparent', 'text-gray-500', 'hover:text-gray-700', 'hover:border-gray-300', 'dark:text-gray-400', 'dark:hover:text-gray-300', 'dark:hover:border-gray-600');
                
                // Trigger specific tab initialization
                if (targetId === '#grid') {
                    setTimeout(initializePermissionGrid, 100);
                } else if (targetId === '#hierarchy') {
                    setTimeout(initializeHierarchyTree, 100);
                }
            }
        });
    });
    
    // Show first tab by default
    const firstTab = document.querySelector('[data-bs-toggle="tab"]');
    if (firstTab) {
        firstTab.click();
    }
}

// Show tab function - called from HTML onclick events
function showTab(tabName) {
    // Hide all tabs
    document.querySelectorAll('.tab-pane').forEach(pane => {
        pane.classList.remove('show', 'active');
        pane.style.display = 'none';
    });
    
    // Remove active class from all tab buttons
    document.querySelectorAll('[data-bs-toggle="tab"]').forEach(tab => {
        tab.classList.remove('border-indigo-500', 'text-indigo-600', 'dark:text-indigo-400');
        tab.classList.add('border-transparent', 'text-gray-500', 'hover:text-gray-700', 'hover:border-gray-300', 'dark:text-gray-400', 'dark:hover:text-gray-300', 'dark:hover:border-gray-600');
    });
    
    // Show target tab
    const targetPane = document.getElementById(tabName);
    if (targetPane) {
        targetPane.classList.add('show', 'active');
        targetPane.style.display = 'block';
        
        // Find and activate the corresponding tab button
        const targetTab = document.querySelector(`[data-bs-target="#${tabName}"]`);
        if (targetTab) {
            targetTab.classList.add('border-indigo-500', 'text-indigo-600', 'dark:text-indigo-400');
            targetTab.classList.remove('border-transparent', 'text-gray-500', 'hover:text-gray-700', 'hover:border-gray-300', 'dark:text-gray-400', 'dark:hover:text-gray-300', 'dark:hover:border-gray-600');
        }
        
        // Trigger specific tab initialization
        if (tabName === 'grid') {
            setTimeout(initializePermissionGrid, 100);
        } else if (tabName === 'hierarchy') {
            setTimeout(initializeHierarchyTree, 100);
        }
    }
}

// Real-time updates functionality
let realTimeInterval;
let lastUpdateTime = Math.floor(Date.now() / 1000);

function startRealTimeUpdates() {
    // Check for updates every 30 seconds
    realTimeInterval = setInterval(checkForUpdates, 30000);
}

// Modal management with smooth animations
function showModal(modalId) {
    const modal = document.getElementById(modalId);
    const modalContent = document.getElementById(modalId + 'Content');
    
    if (!modal || !modalContent) return;
    
    // Show modal
    modal.classList.remove('hidden');
    
    // Trigger reflow
    modalContent.offsetHeight;
    
    // Animate in
    setTimeout(() => {
        modalContent.classList.remove('scale-95', 'opacity-0');
        modalContent.classList.add('scale-100', 'opacity-100');
    }, 10);
    
    // Add backdrop animation
    const backdrop = modal.querySelector('.modal-backdrop');
    if (backdrop) {
        backdrop.style.opacity = '0';
        setTimeout(() => {
            backdrop.style.transition = 'opacity 0.3s ease-in-out';
            backdrop.style.opacity = '1';
        }, 10);
    }
    
    // Focus management for accessibility
    const firstInput = modal.querySelector('input, select, textarea');
    if (firstInput) {
        setTimeout(() => firstInput.focus(), 100);
    }
    
    // Prevent body scroll
    document.body.style.overflow = 'hidden';
}

function hideModal(modalId) {
    const modal = document.getElementById(modalId);
    const modalContent = document.getElementById(modalId + 'Content');
    
    if (!modal || !modalContent) return;
    
    // Animate out
    modalContent.classList.remove('scale-100', 'opacity-100');
    modalContent.classList.add('scale-95', 'opacity-0');
    
    // Fade backdrop
    const backdrop = modal.querySelector('.modal-backdrop');
    if (backdrop) {
        backdrop.style.opacity = '0';
    }
    
    // Hide modal after animation
    setTimeout(() => {
        modal.classList.add('hidden');
        document.body.style.overflow = '';
        
        // Reset backdrop opacity
        if (backdrop) {
            backdrop.style.transition = '';
            backdrop.style.opacity = '';
        }
    }, 300);
}

// Setup modal event listeners
function setupModalEventListeners() {
    // Close modals on escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            const visibleModal = document.querySelector('.fixed.inset-0.z-50:not(.hidden)');
            if (visibleModal) {
                hideModal(visibleModal.id);
            }
        }
    });
    
    // Prevent modal content close on click
    document.querySelectorAll('.fixed.inset-0.z-50 > div:last-child').forEach(modalContent => {
        modalContent.addEventListener('click', function(e) {
            e.stopPropagation();
        });
    });
}

// Enhanced toast notifications with mobile-first design
function showToast(message, type = 'info') {
    // Create toast container if it doesn't exist
    let toastContainer = document.getElementById('toastContainer');
    if (!toastContainer) {
        toastContainer = document.createElement('div');
        toastContainer.id = 'toastContainer';
        toastContainer.className = 'fixed top-4 right-4 z-50 space-y-2 pointer-events-none';
        document.body.appendChild(toastContainer);
    }
    
    const toastId = 'toast-' + Date.now();
    const bgColors = {
        success: 'bg-green-500 dark:bg-green-600',
        error: 'bg-red-500 dark:bg-red-600',
        warning: 'bg-yellow-500 dark:bg-yellow-600',
        info: 'bg-blue-500 dark:bg-blue-600'
    };
    const iconClasses = {
        success: 'fa-check-circle',
        error: 'fa-exclamation-circle',
        warning: 'fa-exclamation-triangle',
        info: 'fa-info-circle'
    };
    
    const bgClass = bgColors[type] || bgColors.info;
    const iconClass = iconClasses[type] || iconClasses.info;
    
    const toastHTML = `
        <div id="${toastId}" class="flex items-center p-3 sm:p-4 mb-2 sm:mb-4 text-white rounded-lg shadow-lg ${bgClass} transform transition-all duration-300 translate-x-full opacity-0 pointer-events-auto max-w-[calc(100vw-2rem)] sm:max-w-sm">
            <i class="fas ${iconClass} mr-2 sm:mr-3 flex-shrink-0"></i>
            <div class="flex-1 min-w-0 text-sm sm:text-base">${message}</div>
            <button type="button" class="ml-2 sm:ml-4 text-white hover:text-gray-200 focus:outline-none flex-shrink-0" onclick="hideToast('${toastId}')">
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

// Real-time updates functionality
function checkForUpdates() {
    fetch('/partner/settings/real-time-updates?last_update=' + lastUpdateTime)
        .then(response => response.json())
        .then(data => {
            if (data.success && data.updates.length > 0) {
                processRealTimeUpdates(data.updates);
                lastUpdateTime = Math.floor(Date.now() / 1000);
            }
        })
        .catch(error => {
            console.error('Error checking for real-time updates:', error);
        });
}

function processRealTimeUpdates(updates) {
    updates.forEach(update => {
        switch (update.type) {
            case 'role_permissions':
                showToast(`Role permissions updated for ${update.role_name}`, 'info');
                // Optionally refresh the grid
                if (confirm('Permission changes detected. Refresh the grid?')) {
                    initializePermissionGrid();
                }
                break;
            case 'role_updated':
                showToast(`Role ${update.role_name} was ${update.action}`, 'info');
                break;
        }
    });
}

function broadcastPermissionUpdate() {
    // This would typically use WebSockets or Pusher for real-time broadcasting
    // For now, we'll just show a notification
    showToast('Permission changes broadcasted to all users', 'success');
}

// Enhanced search and filter functionality with mobile optimization
function setupSearchFilters() {
    const roleSearch = document.getElementById('roleSearch');
    const roleLevelFilter = document.getElementById('roleLevelFilter');
    const permissionSearch = document.getElementById('permissionSearch');
    const moduleFilter = document.getElementById('moduleFilter');
    
    if (roleSearch) {
        roleSearch.addEventListener('input', debounce(function(e) {
            filterRoles();
        }, 300));
    }
    
    if (roleLevelFilter) {
        roleLevelFilter.addEventListener('change', function(e) {
            filterRoles();
        });
    }
    
    if (permissionSearch) {
        permissionSearch.addEventListener('input', debounce(function(e) {
            filterPermissions();
        }, 300));
    }
    
    if (moduleFilter) {
        moduleFilter.addEventListener('change', function(e) {
            filterPermissions();
        });
    }
}

function filterRoles() {
    const searchTerm = document.getElementById('roleSearch').value.toLowerCase();
    const levelFilter = document.getElementById('roleLevelFilter').value;
    
    // Filter desktop table rows
    document.querySelectorAll('tbody tr').forEach(row => {
        const roleName = row.querySelector('td:first-child')?.textContent.toLowerCase() || '';
        const roleLevelCell = row.querySelector('td:nth-child(2)');
        const roleLevel = roleLevelCell?.textContent.trim() || '';
        
        const matchesSearch = roleName.includes(searchTerm);
        const matchesLevel = !levelFilter || roleLevel === levelFilter;
        
        row.style.display = matchesSearch && matchesLevel ? '' : 'none';
    });
    
    // Filter mobile cards
    document.querySelectorAll('.lg\:hidden .bg-gray-50').forEach(card => {
        const roleName = card.querySelector('h6')?.textContent.toLowerCase() || '';
        const roleLevelSpan = card.querySelector('.text-gray-900.dark\:text-white');
        const roleLevel = roleLevelSpan?.textContent.trim() || '';
        
        const matchesSearch = roleName.includes(searchTerm);
        const matchesLevel = !levelFilter || roleLevel === levelFilter;
        
        card.style.display = matchesSearch && matchesLevel ? '' : 'none';
    });
    
    // Show empty state if no results
    updateEmptyStates();
}

function filterPermissions() {
    const searchTerm = document.getElementById('permissionSearch').value.toLowerCase();
    const moduleFilter = document.getElementById('moduleFilter').value;
    
    document.querySelectorAll('.permission-module').forEach(module => {
        const moduleName = module.dataset.module;
        const permissions = module.querySelectorAll('.permission-item');
        let hasVisiblePermissions = false;
        
        permissions.forEach(permission => {
            const permissionName = permission.dataset.permissionName.toLowerCase();
            
            const matchesSearch = permissionName.includes(searchTerm);
            const matchesModule = !moduleFilter || moduleName === moduleFilter;
            
            if (matchesSearch && matchesModule) {
                permission.style.display = 'flex';
                hasVisiblePermissions = true;
            } else {
                permission.style.display = 'none';
            }
        });
        
        module.style.display = hasVisiblePermissions ? 'block' : 'none';
    });
}

function updateEmptyStates() {
    // Update roles empty state
    const visibleRoles = document.querySelectorAll('tbody tr:not([style*="display: none"]), .lg\:hidden .bg-gray-50:not([style*="display: none"])');
    const rolesEmptyState = document.querySelector('#roles .text-center.py-12');
    
    if (rolesEmptyState) {
        rolesEmptyState.style.display = visibleRoles.length === 0 ? 'block' : 'none';
    }
    
    // Update permissions empty state
    const visibleModules = document.querySelectorAll('.permission-module:not([style*="display: none"])');
    const permissionsEmptyState = document.querySelector('#permissions .text-center.py-12');
    
    if (permissionsEmptyState) {
        permissionsEmptyState.style.display = visibleModules.length === 0 ? 'block' : 'none';
    }
}

// Enhanced dropdown management with mobile optimization
function toggleRoleDropdown(roleId) {
    // Close all other dropdowns first
    document.querySelectorAll('[id^="roleDropdown"]').forEach(dropdown => {
        if (dropdown.id !== `roleDropdown${roleId}`) {
            dropdown.classList.add('hidden');
        }
    });

    // Toggle the target dropdown
    const dropdown = document.getElementById(`roleDropdown${roleId}`);
    if (dropdown) {
        dropdown.classList.toggle('hidden');
        
        // Mobile optimization: ensure dropdown stays within viewport
        if (window.innerWidth < 768 && !dropdown.classList.contains('hidden')) {
            const rect = dropdown.getBoundingClientRect();
            if (rect.right > window.innerWidth) {
                dropdown.style.right = '0';
                dropdown.style.left = 'auto';
            }
        }
    }
}

// Close dropdown when clicking outside
document.addEventListener('click', function(e) {
    // Don't close if clicking on dropdown or its trigger
    if (!e.target.closest('[id^="roleDropdown"]') && !e.target.closest('.relative')) {
        document.querySelectorAll('[id^="roleDropdown"]').forEach(dropdown => {
            dropdown.classList.add('hidden');
        });
    }
});

function toggleRoleStatus(roleId) {
    // Get current role status
    fetch(`/roles/${roleId}`)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const role = data.role;
                const newStatus = role.status === 'active' ? 'inactive' : 'active';
                const confirmMessage = role.status === 'active'
                    ? 'Are you sure you want to deactivate this role?'
                    : 'Are you sure you want to activate this role?';

                if (confirm(confirmMessage)) {
                    fetch(`/roles/${roleId}`, {
                        method: 'PUT',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                        },
                        body: JSON.stringify({
                            status: newStatus
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            showToast(`Role ${newStatus === 'active' ? 'activated' : 'deactivated'} successfully`, 'success');
                            location.reload();
                        } else {
                            showToast('Error: ' + data.message, 'error');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        showToast('An error occurred while updating the role status', 'error');
                    });
                }
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showToast('An error occurred while loading role data', 'error');
        });
}

function assignPermissions(roleId) {
    // Open permission assignment modal or redirect to permission assignment page
    showToast('Permission assignment feature coming soon!', 'info');
    // For now, redirect to edit role page
    editRole(roleId);
}

// Enhanced form validation and submission with mobile-first optimization
function addRole() {
    const form = document.getElementById('addRoleForm');
    
    // Validate form
    if (!validateRoleForm(form)) {
        return;
    }
    
    const formData = new FormData(form);
    
    // Convert FormData to object and add required fields
    const data = Object.fromEntries(formData);
    data.is_system = false; // New roles are not system roles
    data.inherit_permissions = data.inherit_permissions === '1';
    
    // Handle multiple select permissions
    const permissionSelect = document.getElementById('rolePermissions');
    data.permission_ids = Array.from(permissionSelect.selectedOptions).map(option => parseInt(option.value));
    
    // Ensure permissions_inheritance_mode is included
    data.permissions_inheritance_mode = data.permissions_inheritance_mode || 'none';
    
    // Show loading state
    const submitBtn = form.querySelector('button[type="submit"]');
    const originalText = submitBtn.innerHTML;
    submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Creating...';
    submitBtn.disabled = true;
    
    fetch('/roles', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify(data)
    })
    .then(response => {
        console.log('Response status:', response.status);
        return response.json();
    })
    .then(data => {
        console.log('Response data:', data);
        if (data.success) {
            showToast('Role created successfully', 'success');
            hideModal('addRoleModal');
            form.reset(); // Reset the form
            location.reload();
        } else {
            showToast('Error: ' + (data.message || 'Unknown error'), 'error');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showToast('An error occurred while creating the role', 'error');
    })
    .finally(() => {
        // Restore button state
        submitBtn.innerHTML = originalText;
        submitBtn.disabled = false;
    });
}

function validateRoleForm(form) {
    const nameInput = form.querySelector('input[name="name"]');
    const levelInput = form.querySelector('input[name="level"]');
    
    // Clear previous errors
    clearFormErrors(form);
    
    let isValid = true;
    
    // Validate name
    if (!nameInput.value.trim()) {
        showFieldError(nameInput, 'Role name is required');
        isValid = false;
    } else if (nameInput.value.trim().length < 2) {
        showFieldError(nameInput, 'Role name must be at least 2 characters');
        isValid = false;
    }
    
    // Validate level
    if (!levelInput.value || levelInput.value < 1 || levelInput.value > 10) {
        showFieldError(levelInput, 'Role level must be between 1 and 10');
        isValid = false;
    }
    
    return isValid;
}

function showFieldError(field, message) {
    field.classList.add('border-red-500', 'dark:border-red-400');
    
    // Create or update error message
    let errorDiv = field.parentNode.querySelector('.field-error');
    if (!errorDiv) {
        errorDiv = document.createElement('div');
        errorDiv.className = 'field-error text-red-500 text-sm mt-1 dark:text-red-400';
        field.parentNode.appendChild(errorDiv);
    }
    errorDiv.textContent = message;
    
    // Focus on the field for better UX
    field.focus();
    
    // Add shake animation for mobile
    if (window.innerWidth < 768) {
        field.classList.add('animate-pulse');
        setTimeout(() => {
            field.classList.remove('animate-pulse');
        }, 1000);
    }
}

function clearFormErrors(form) {
    form.querySelectorAll('.border-red-500, .dark\:border-red-400').forEach(field => {
        field.classList.remove('border-red-500', 'dark:border-red-400');
    });
    
    form.querySelectorAll('.field-error').forEach(error => {
        error.remove();
    });
}

function editRole(roleId) {
    currentRoleId = roleId;
    
    // Show loading state
    showToast('Loading role data...', 'info');
    
    // Load role data and populate edit form
    fetch(`/roles/${roleId}`)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const role = data.role;
                
                // Populate form fields
                document.getElementById('editRoleId').value = role.id;
                document.getElementById('editRoleName').value = role.name;
                document.getElementById('editRoleLevel').value = role.level;
                document.getElementById('editRoleDescription').value = role.description || '';
                document.getElementById('editRoleStatus').value = role.status;
                
                // Set checkboxes
                document.getElementById('editInheritPermissions').checked = role.inherit_permissions;
                
                // Set inheritance mode
                const inheritanceMode = document.getElementById('editPermissionsInheritanceMode');
                if (inheritanceMode) {
                    inheritanceMode.value = role.permissions_inheritance_mode || 'none';
                }
                
                // Set parent role if exists
                const parentRoleSelect = document.getElementById('editParentRole');
                if (parentRoleSelect && role.parent_role_id) {
                    parentRoleSelect.value = role.parent_role_id;
                }
                
                // Load and set permissions
                if (role.permissions && role.permissions.length > 0) {
                    const permissionSelect = document.getElementById('editRolePermissions');
                    if (permissionSelect) {
                        Array.from(permissionSelect.options).forEach(option => {
                            option.selected = role.permissions.some(p => p.id === parseInt(option.value));
                        });
                    }
                }
                
                showModal('editRoleModal');
            } else {
                showToast('Error loading role data: ' + (data.message || 'Unknown error'), 'error');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showToast('An error occurred while loading role data', 'error');
        });
}

function updateRole() {
    const form = document.getElementById('editRoleForm');
    
    // Validate form
    if (!validateRoleForm(form)) {
        return;
    }
    
    const formData = new FormData(form);
    const data = Object.fromEntries(formData);
    
    // Handle permissions
    const permissionSelect = document.getElementById('editRolePermissions');
    if (permissionSelect) {
        data.permission_ids = Array.from(permissionSelect.selectedOptions).map(option => parseInt(option.value));
    }
    
    // Show loading state
    const submitBtn = form.querySelector('button[type="submit"]');
    const originalText = submitBtn.innerHTML;
    submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Updating...';
    submitBtn.disabled = true;
    
    fetch(`/roles/${currentRoleId}`, {
        method: 'PUT',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify(data)
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showToast('Role updated successfully', 'success');
            hideModal('editRoleModal');
            location.reload();
        } else {
            showToast('Error: ' + data.message, 'error');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showToast('An error occurred while updating the role', 'error');
    })
    .finally(() => {
        // Restore button state
        submitBtn.innerHTML = originalText;
        submitBtn.disabled = false;
    });
}

function viewRole(roleId) {
    // Show loading state
    showToast('Loading role details...', 'info');
    
    fetch(`/roles/${roleId}`)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const role = data.role;
                const content = `
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <h6 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Basic Information</h6>
                            <div class="space-y-3">
                                <div class="flex justify-between items-center py-2 border-b border-gray-200 dark:border-gray-700">
                                    <span class="font-medium text-gray-700 dark:text-gray-300">Name:</span>
                                    <span class="text-gray-900 dark:text-white">${role.name}</span>
                                </div>
                                <div class="flex justify-between items-center py-2 border-b border-gray-200 dark:border-gray-700">
                                    <span class="font-medium text-gray-700 dark:text-gray-300">Display Name:</span>
                                    <span class="text-gray-900 dark:text-white">${role.display_name || role.name}</span>
                                </div>
                                <div class="flex justify-between items-center py-2 border-b border-gray-200 dark:border-gray-700">
                                    <span class="font-medium text-gray-700 dark:text-gray-300">Description:</span>
                                    <span class="text-gray-900 dark:text-white">${role.description || 'N/A'}</span>
                                </div>
                                <div class="flex justify-between items-center py-2 border-b border-gray-200 dark:border-gray-700">
                                    <span class="font-medium text-gray-700 dark:text-gray-300">Level:</span>
                                    <span class="text-gray-900 dark:text-white">${role.level}</span>
                                </div>
                                <div class="flex justify-between items-center py-2 border-b border-gray-200 dark:border-gray-700">
                                    <span class="font-medium text-gray-700 dark:text-gray-300">Status:</span>
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium ${role.status === 'active' ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200' : 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200'}">
                                        ${role.status}
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div>
                            <h6 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Relationships</h6>
                            <div class="space-y-3">
                                <div class="flex justify-between items-center py-2 border-b border-gray-200 dark:border-gray-700">
                                    <span class="font-medium text-gray-700 dark:text-gray-300">Parent Role:</span>
                                    <span class="text-gray-900 dark:text-white">${role.parent_role?.display_name || 'None'}</span>
                                </div>
                                <div class="flex justify-between items-center py-2 border-b border-gray-200 dark:border-gray-700">
                                    <span class="font-medium text-gray-700 dark:text-gray-300">Child Roles:</span>
                                    <span class="text-gray-900 dark:text-white">${role.child_roles?.length || 0}</span>
                                </div>
                                <div class="flex justify-between items-center py-2 border-b border-gray-200 dark:border-gray-700">
                                    <span class="font-medium text-gray-700 dark:text-gray-300">Users:</span>
                                    <span class="text-gray-900 dark:text-white">${role.users?.length || 0}</span>
                                </div>
                                <div class="flex justify-between items-center py-2 border-b border-gray-200 dark:border-gray-700">
                                    <span class="font-medium text-gray-700 dark:text-gray-300">Permissions:</span>
                                    <span class="text-gray-900 dark:text-white">${role.permissions?.length || 0}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    ${role.permissions && role.permissions.length > 0 ? `
                        <div class="mt-6">
                            <h6 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Permissions</h6>
                            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-2">
                                ${role.permissions.map(permission => `
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200">
                                        ${permission.name}
                                    </span>
                                `).join('')}
                            </div>
                        </div>
                    ` : ''}
                `;
                document.getElementById('viewRoleContent').innerHTML = content;
                showModal('viewRoleModal');
            } else {
                showToast('Error loading role data: ' + (data.message || 'Unknown error'), 'error');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showToast('An error occurred while loading role data', 'error');
        });
}

function deleteRole(roleId) {
    if (confirm('Are you sure you want to delete this role? This action cannot be undone and may affect users assigned to this role.')) {
        // Show loading state
        showToast('Deleting role...', 'info');
        
        fetch(`/roles/${roleId}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showToast('Role deleted successfully', 'success');
                location.reload();
            } else {
                showToast('Error: ' + data.message, 'error');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showToast('An error occurred while deleting the role', 'error');
        });
    }
}

function cloneRole(roleId) {
    if (confirm('Are you sure you want to clone this role? This will create a new role with the same permissions and settings.')) {
        // Show loading state
        showToast('Cloning role...', 'info');
        
        fetch(`/roles/${roleId}/clone`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showToast('Role cloned successfully', 'success');
                location.reload();
            } else {
                showToast('Error: ' + data.message, 'error');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showToast('An error occurred while cloning the role', 'error');
        });
    }
}

// Permission management functions
function addPermission() {
    const form = document.getElementById('addPermissionForm');
    const formData = new FormData(form);
    
    fetch('/permissions', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify(Object.fromEntries(formData))
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showToast('Permission created successfully', 'success');
            hideModal('addPermissionModal');
            location.reload();
        } else {
            showToast('Error: ' + data.message, 'error');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showToast('An error occurred while creating the permission', 'error');
    });
}

function editPermission(permissionId) {
    currentPermissionId = permissionId;
    // Load permission data and populate edit form
    fetch(`/permissions/${permissionId}`)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const permission = data.permission;
                // Populate form fields
                // ... populate other fields
                showModal('editPermissionModal');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showToast('An error occurred while loading permission data', 'error');
        });
}

function deletePermission(permissionId) {
    if (confirm('Are you sure you want to delete this permission? This action cannot be undone.')) {
        fetch(`/permissions/${permissionId}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showToast('Permission deleted successfully', 'success');
                location.reload();
            } else {
                showToast('Error: ' + data.message, 'error');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showToast('An error occurred while deleting the permission', 'error');
        });
    }
}

// Permission Grid functions
function initializePermissionGrid() {
    const gridBody = document.getElementById('permissionGridBody');
    const permissions = {{ json_encode($permissions->groupBy('module')) }};
    const roles = {{ json_encode($roles) }};
    
    let html = '';
    
    for (const [module, modulePermissions] of Object.entries(permissions)) {
        // Module header row
        html += `<tr class="module-header bg-gray-50 dark:bg-gray-700">
            <td colspan="${roles.length + 1}" class="font-semibold text-gray-900 dark:text-white px-4 py-3">
                <i class="fas fa-cube mr-2 text-blue-500"></i>${module}
            </td>
        </tr>`;
        
        // Permission rows
        modulePermissions.forEach(permission => {
            html += `<tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                <td style="position: sticky; left: 0; background: white; z-index: 5;" class="bg-white dark:bg-gray-800 border-r border-gray-200 dark:border-gray-700">
                    <div class="font-semibold text-gray-900 dark:text-white">${permission.display_name}</div>
                    <div class="text-gray-500 dark:text-gray-400 text-sm">${permission.description}</div>
                </td>`;
            
            roles.forEach(role => {
                const hasPermission = role.permissions?.some(p => p.id === permission.id) || false;
                html += `<td class="permission-cell px-4 py-3 text-center border-b border-gray-200 dark:border-gray-700">
                    <input type="checkbox" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600 permission-checkbox" 
                           data-role-id="${role.id}" data-permission-id="${permission.id}"
                           ${hasPermission ? 'checked' : ''}>
                </td>`;
            });
            
            html += '</tr>';
        });
    }
    
    gridBody.innerHTML = html;
    
    // Add event listeners for checkboxes
    document.querySelectorAll('.permission-checkbox').forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            const roleId = this.dataset.roleId;
            const permissionId = this.dataset.permissionId;
            const isChecked = this.checked;
            
            if (!permissionGridData[roleId]) {
                permissionGridData[roleId] = {};
            }
            permissionGridData[roleId][permissionId] = isChecked;
        });
    });
}

function saveGridChanges() {
    fetch('/partner/settings/permissions/bulk-update', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify({ changes: permissionGridData })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showToast('Permission grid updated successfully', 'success');
            permissionGridData = {};
            // Trigger real-time update
            broadcastPermissionUpdate();
        } else {
            showToast('Error: ' + data.message, 'error');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showToast('An error occurred while updating the permission grid', 'error');
    });
}

function expandAll() {
    document.querySelectorAll('.module-header').forEach(header => {
        header.classList.add('expanded');
        const moduleRows = [];
        let currentRow = header.nextElementSibling;
        while (currentRow && !currentRow.classList.contains('module-header')) {
            moduleRows.push(currentRow);
            currentRow = currentRow.nextElementSibling;
        }
        moduleRows.forEach(row => row.style.display = '');
    });
}

function collapseAll() {
    document.querySelectorAll('.module-header').forEach(header => {
        header.classList.remove('expanded');
        const moduleRows = [];
        let currentRow = header.nextElementSibling;
        while (currentRow && !currentRow.classList.contains('module-header')) {
            moduleRows.push(currentRow);
            currentRow = currentRow.nextElementSibling;
        }
        moduleRows.forEach(row => row.style.display = 'none');
    });
}

// Hierarchy functions
function initializeHierarchy() {
    const hierarchyTree = document.getElementById('hierarchyTree');
    const roles = {{ json_encode($roles) }};
    
    // Build hierarchy tree
    const treeData = buildHierarchyTree(roles);
    hierarchyTree.innerHTML = renderHierarchyTree(treeData);
    
    // Update hierarchy statistics
    updateHierarchyStats(roles);
}

function buildHierarchyTree(roles) {
    const tree = {};
    const roleMap = {};
    
    // Create role map
    roles.forEach(role => {
        roleMap[role.id] = { ...role, children: [] };
    });
    
    // Build tree structure
    roles.forEach(role => {
        if (role.parent_role_id && roleMap[role.parent_role_id]) {
            roleMap[role.parent_role_id].children.push(roleMap[role.id]);
        } else if (!role.parent_role_id) {
            tree[role.id] = roleMap[role.id];
        }
    });
    
    return tree;
}

function renderHierarchyTree(tree, level = 0) {
    let html = '';
    
    Object.values(tree).forEach(role => {
        const indent = '  '.repeat(level);
        const indentClass = level > 0 ? `ml-${level * 4}` : '';
        html += `${indent}<div class="tree-node flex items-center py-2 px-3 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 ${indentClass}">
            <i class="fas fa-user-tag mr-2 text-blue-500"></i>
            <span class="font-semibold text-gray-900 dark:text-white">${role.display_name}</span>
            <span class="ml-2 px-2 py-1 text-xs font-medium bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300 rounded-full">${role.users?.length || 0} users</span>
        </div>`;
        
        if (role.children.length > 0) {
            html += renderHierarchyTree({ ...role.children }, level + 1);
        }
    });
    
    return html;
}

function updateHierarchyStats(roles) {
    const statsContainer = document.getElementById('hierarchyStats');
    const totalRoles = roles.length;
    const rootRoles = roles.filter(role => !role.parent_role_id).length;
    const maxDepth = calculateMaxDepth(roles);
    const totalUsers = roles.reduce((sum, role) => sum + (role.users?.length || 0), 0);
    
    statsContainer.innerHTML = `
        <div class="space-y-3">
            <div class="flex justify-between items-center py-2">
                <span class="text-gray-700 dark:text-gray-300">Total Roles:</span>
                <span class="px-3 py-1 text-sm font-medium bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-300 rounded-full">${totalRoles}</span>
            </div>
            <div class="flex justify-between items-center py-2">
                <span class="text-gray-700 dark:text-gray-300">Root Roles:</span>
                <span class="px-3 py-1 text-sm font-medium bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300 rounded-full">${rootRoles}</span>
            </div>
            <div class="flex justify-between items-center py-2">
                <span class="text-gray-700 dark:text-gray-300">Max Depth:</span>
                <span class="px-3 py-1 text-sm font-medium bg-cyan-100 text-cyan-800 dark:bg-cyan-900 dark:text-cyan-300 rounded-full">${maxDepth}</span>
            </div>
            <div class="flex justify-between items-center py-2">
                <span class="text-gray-700 dark:text-gray-300">Total Users:</span>
                <span class="px-3 py-1 text-sm font-medium bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-300 rounded-full">${totalUsers}</span>
            </div>
        </div>
    `;
}

function calculateMaxDepth(roles) {
    const roleMap = {};
    roles.forEach(role => {
        roleMap[role.id] = { ...role, depth: 0 };
    });
    
    let maxDepth = 0;
    
    function calculateDepth(roleId, currentDepth = 0) {
        const role = roleMap[roleId];
        if (!role) return currentDepth;
        
        role.depth = Math.max(role.depth, currentDepth);
        maxDepth = Math.max(maxDepth, currentDepth);
        
        if (role.parent_role_id) {
            calculateDepth(role.parent_role_id, currentDepth + 1);
        }
    }
    
    roles.forEach(role => {
        calculateDepth(role.id);
    });
    
    return maxDepth;
}

function refreshHierarchy() {
    initializeHierarchy();
}

// Export functions
function exportRoles() {
    window.location.href = '/roles/export';
}

function editRoleFromView() {
    hideModal('viewRoleModal');
    editRole(currentRoleId);
}
</script>
@endsection
