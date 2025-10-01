@extends('layouts.partner-layout')

@section('title', 'Role & Permission Management')

@section('styles')
<style>
    @layer utilities {
        .role-card {
            @apply transition-all duration-300 border-l-4 border-transparent;
        }
        .role-card:hover {
            @apply -translate-y-0.5 shadow-lg;
        }
        .role-card.super-admin {
            @apply border-l-violet-500;
        }
        .role-card.admin {
            @apply border-l-red-500;
        }
        .role-card.manager {
            @apply border-l-orange-500;
        }
        .role-card.supervisor {
            @apply border-l-yellow-500;
        }
        .role-card.staff {
            @apply border-l-green-500;
        }
        .role-card.user {
            @apply border-l-blue-500;
        }
        .permission-grid {
            @apply grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4;
        }
        .permission-module {
            @apply bg-slate-50 dark:bg-gray-800 rounded-lg p-4 border border-slate-200 dark:border-gray-700;
        }
        .permission-item {
            @apply flex items-center justify-between p-2 rounded-md transition-colors duration-200;
        }
        .permission-item:hover {
            @apply bg-slate-100 dark:bg-gray-700;
        }
        .hierarchy-tree {
            @apply font-mono text-sm leading-6;
        }
        .tree-node {
            @apply pl-4 relative;
        }
        .tree-node::before {
            content: '├── ';
            @apply text-slate-400 absolute left-0;
        }
        .tree-node:last-child::before {
            content: '└── ';
        }
        .modal-backdrop {
            @apply backdrop-blur-sm;
        }
        .permission-checkbox {
            @apply w-5 h-5 cursor-pointer;
        }
        .role-permission-grid {
            @apply overflow-x-auto;
        }
        .role-permission-grid table {
            @apply min-w-[800px];
        }
        .role-permission-grid th,
        .role-permission-grid td {
            @apply text-center align-middle p-2 text-sm;
        }
        .role-permission-grid th {
            @apply bg-slate-50 dark:bg-gray-800 font-semibold sticky top-0 z-10;
        }
        .role-permission-grid .cell-center {
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
    }
    .loading-spinner {
        border: 3px solid #f3f3f3;
        border-top: 3px solid #6366f1;
        border-radius: 50%;
        width: 40px;
        height: 40px;
        animation: spin 1s linear infinite;
    }
    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }
    .stats-card {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    }
    .stats-card-2 {
        background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
    }
    .stats-card-3 {
        background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
    }
    .stats-card-4 {
        background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);
    }
</style>
@endsection

@section('content')
<div class="flex-1 overflow-y-auto custom-scrollbar p-4 lg:p-8">
    <!-- Header Section -->
    <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4 mb-8">
        <div>
            <h1 class="text-2xl lg:text-3xl font-bold text-gray-900 dark:text-white mb-2">Role & Permission Management</h1>
            <p class="text-gray-600 dark:text-gray-400">Manage roles, permissions, and access control</p>
        </div>
        <div class="flex flex-col sm:flex-row gap-3">
            <button type="button" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors duration-200" onclick="exportRoles()">
                <i class="fas fa-download mr-2"></i>Export
            </button>
            <button type="button" class="inline-flex items-center px-4 py-2 border border-transparent rounded-lg text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors duration-200" onclick="showModal('addRoleModal')">
                <i class="fas fa-plus mr-2"></i>Add Role
            </button>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 lg:gap-6 mb-8">
        <div class="bg-gradient-to-br from-purple-500 to-purple-700 text-white rounded-xl p-6 shadow-lg">
            <div class="flex items-center justify-between">
                <div>
                    <h6 class="text-lg font-semibold mb-2">Total Roles</h6>
                    <h3 class="text-3xl font-bold mb-0">{{ $roles->count() }}</h3>
                </div>
                <div class="text-3xl opacity-75">
                    <i class="fas fa-user-tag"></i>
                </div>
            </div>
        </div>
        <div class="bg-gradient-to-br from-blue-500 to-blue-700 text-white rounded-xl p-6 shadow-lg">
            <div class="flex items-center justify-between">
                <div>
                    <h6 class="text-lg font-semibold mb-2">Active Roles</h6>
                    <h3 class="text-3xl font-bold mb-0">{{ $roles->where('status', 'active')->count() }}</h3>
                </div>
                <div class="text-3xl opacity-75">
                    <i class="fas fa-check-circle"></i>
                </div>
            </div>
        </div>
        <div class="bg-gradient-to-br from-cyan-500 to-cyan-700 text-white rounded-xl p-6 shadow-lg">
            <div class="flex items-center justify-between">
                <div>
                    <h6 class="text-lg font-semibold mb-2">Total Permissions</h6>
                    <h3 class="text-3xl font-bold mb-0">{{ $permissions->count() }}</h3>
                </div>
                <div class="text-3xl opacity-75">
                    <i class="fas fa-key"></i>
                </div>
            </div>
        </div>
        <div class="bg-gradient-to-br from-green-500 to-green-700 text-white rounded-xl p-6 shadow-lg">
            <div class="flex items-center justify-between">
                <div>
                    <h6 class="text-lg font-semibold mb-2">Permission Modules</h6>
                    <h3 class="text-3xl font-bold mb-0">{{ $permissions->pluck('module')->unique()->count() }}</h3>
                </div>
                <div class="text-3xl opacity-75">
                    <i class="fas fa-cube"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Tabs Navigation -->
    <div class="border-b border-gray-200 dark:border-gray-700 mb-6">
        <nav class="-mb-px flex space-x-8" aria-label="Tabs">
            <button class="border-indigo-500 text-indigo-600 dark:text-indigo-400 whitespace-nowrap py-2 px-1 border-b-2 font-medium text-sm" id="roles-tab" onclick="showTab('roles')">
                <i class="fas fa-user-tag mr-2"></i>Roles
            </button>
            <button class="border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 dark:text-gray-400 dark:hover:text-gray-300 dark:hover:border-gray-600 whitespace-nowrap py-2 px-1 border-b-2 font-medium text-sm" id="permissions-tab" onclick="showTab('permissions')">
                <i class="fas fa-key mr-2"></i>Permissions
            </button>
            <button class="border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 dark:text-gray-400 dark:hover:text-gray-300 dark:hover:border-gray-600 whitespace-nowrap py-2 px-1 border-b-2 font-medium text-sm" id="grid-tab" onclick="showTab('grid')">
                <i class="fas fa-th mr-2"></i>Permission Grid
            </button>
            <button class="border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 dark:text-gray-400 dark:hover:text-gray-300 dark:hover:border-gray-600 whitespace-nowrap py-2 px-1 border-b-2 font-medium text-sm" id="hierarchy-tab" onclick="showTab('hierarchy')">
                <i class="fas fa-sitemap mr-2"></i>Hierarchy
            </button>
        </nav>
    </div>

    <!-- Tab Content -->
    <div class="tab-content" id="rolePermissionTabsContent">
        <!-- Roles Tab -->
        <div class="tab-pane fade show active" id="roles" role="tabpanel" aria-labelledby="roles-tab">
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700">
                <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                        <h5 class="text-lg font-semibold text-gray-900 dark:text-white mb-0">Roles</h5>
                        <div class="flex flex-col sm:flex-row gap-3" style="display: none;">
                            <input type="text" class="px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" id="roleSearch" placeholder="Search roles...">
                            <select class="px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" id="roleLevelFilter">
                                <option value="">All Levels</option>
                                @foreach($roles->pluck('level')->unique()->sort() as $level)
                                    <option value="{{ $level }}">{{ $level }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6" id="rolesContainer">
                        @foreach($roles as $role)
                            <div class="role-item" data-role-name="{{ $role->name }}" data-role-level="{{ $role->level }}">
                                <div class="role-card {{ $role->name }} h-full bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700 shadow-sm hover:shadow-md transition-all duration-300">
                                    <div class="p-6">
                                        <div class="flex justify-between items-start mb-4">
                                            <div>
                                                <h6 class="text-lg font-semibold text-gray-900 dark:text-white mb-3">{{ $role->display_name }}</h6>
                                                <div class="flex flex-wrap gap-2 mb-3">
                                                    {!! $role->level_badge !!}
                                                    {!! $role->status_badge !!}
                                                    @if($role->inherit_permissions)
                                                        {!! $role->inheritance_mode_badge !!}
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="relative">
                                                <button class="p-2 text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors duration-200" onclick="toggleRoleDropdown({{ $role->id }})">
                                                    <i class="fas fa-ellipsis-v"></i>
                                                </button>
                                                <div id="roleDropdown{{ $role->id }}" class="hidden absolute right-0 mt-2 w-48 bg-white dark:bg-gray-800 rounded-lg shadow-lg border border-gray-200 dark:border-gray-700 z-10">
                                                    <a href="#" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors duration-200" onclick="editRole({{ $role->id }})">
                                                        <i class="fas fa-edit mr-2"></i>Edit
                                                    </a>
                                                    <a href="#" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors duration-200" onclick="viewRole({{ $role->id }})">
                                                        <i class="fas fa-eye mr-2"></i>View Details
                                                    </a>
                                                    <a href="#" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors duration-200" onclick="cloneRole({{ $role->id }})">
                                                        <i class="fas fa-copy mr-2"></i>Clone
                                                    </a>
                                                    <div class="border-t border-gray-200 dark:border-gray-700"></div>
                                                    <a href="#" class="block px-4 py-2 text-sm text-red-600 hover:bg-red-50 dark:hover:bg-red-900/20 transition-colors duration-200" onclick="deleteRole({{ $role->id }})">
                                                        <i class="fas fa-trash mr-2"></i>Delete
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="mb-4">
                                            <div class="flex justify-between items-center mb-2">
                                                <small class="text-gray-500 dark:text-gray-400">Permissions</small>
                                                <small class="text-gray-500 dark:text-gray-400">{{ $role->permissions->count() }}</small>
                                            </div>
                                            <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-1">
                                                <div class="bg-indigo-600 h-1 rounded-full" style="width: {{ min($role->permissions->count() * 10, 100) }}%"></div>
                                            </div>
                                        </div>
                                        
                                        <div class="mb-4">
                                            <div class="flex justify-between items-center mb-2">
                                                <small class="text-gray-500 dark:text-gray-400">Users</small>
                                                <small class="text-gray-500 dark:text-gray-400">{{ $role->users->count() }}</small>
                                            </div>
                                            <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-1">
                                                <div class="bg-green-500 h-1 rounded-full" style="width: {{ min($role->users->count() * 20, 100) }}%"></div>
                                            </div>
                                        </div>
                                        
                                        
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        <!-- Permissions Tab -->
        <div class="tab-pane fade" id="permissions" role="tabpanel" aria-labelledby="permissions-tab">
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700">
                <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                        <h5 class="text-lg font-semibold text-gray-900 dark:text-white mb-0">Permissions</h5>
                        <div class="flex flex-col sm:flex-row gap-3">
                            <input type="text" class="px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" id="permissionSearch" placeholder="Search permissions...">
                            <select class="px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" id="moduleFilter">
                                <option value="">All Modules</option>
                                @foreach($permissions->pluck('module')->unique()->sort() as $module)
                                    <option value="{{ $module }}">{{ $module }}</option>
                                @endforeach
                            </select>
                            <button type="button" class="inline-flex items-center px-4 py-2 border border-transparent rounded-lg text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors duration-200" onclick="showModal('addPermissionModal')">
                                <i class="fas fa-plus mr-2"></i>Add Permission
                            </button>
                        </div>
                    </div>
                </div>
                <div class="p-6">
                    <div class="permission-grid" id="permissionsContainer">
                        @foreach($permissions->groupBy('module') as $module => $modulePermissions)
                            <div class="permission-module mb-8" data-module="{{ $module }}">
                                <h6 class="text-lg font-semibold text-gray-900 dark:text-white mb-4 flex items-center">
                                    <i class="fas fa-cube mr-2 text-indigo-600 dark:text-indigo-400"></i>{{ $module }}
                                    <span class="inline-block px-2 py-1 text-xs font-medium bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-gray-200 rounded-full ml-2">{{ $modulePermissions->count() }}</span>
                                </h6>
                                <div class="permission-list grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                                    @foreach($modulePermissions as $permission)
                                        <div class="permission-item bg-gray-50 dark:bg-gray-700 rounded-lg p-4 border border-gray-200 dark:border-gray-600" data-permission-name="{{ $permission->name }}">
                                            <div class="flex justify-between items-start">
                                                <div class="flex-1">
                                                    <div class="font-semibold text-gray-900 dark:text-white mb-1">{{ $permission->display_name }}</div>
                                                    <div class="text-gray-600 dark:text-gray-400 text-sm">{{ $permission->description }}</div>
                                                </div>
                                                <div class="relative ml-2">
                                                    <button class="p-2 text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-600 transition-colors duration-200" onclick="togglePermissionDropdown({{ $permission->id }})">
                                                        <i class="fas fa-ellipsis-v"></i>
                                                    </button>
                                                    <div id="permissionDropdown{{ $permission->id }}" class="hidden absolute right-0 mt-2 w-48 bg-white dark:bg-gray-800 rounded-lg shadow-lg border border-gray-200 dark:border-gray-700 z-10">
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
                </div>
            </div>
        </div>

        <!-- Permission Grid Tab -->
        <div class="tab-pane fade" id="grid" role="tabpanel" aria-labelledby="grid-tab">
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700">
                <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                        <h5 class="text-lg font-semibold text-gray-900 dark:text-white mb-0">Role-Permission Matrix</h5>
                        <div class="flex flex-col sm:flex-row gap-3">
                            <button type="button" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors duration-200" onclick="expandAll()">
                                <i class="fas fa-expand-arrows-alt mr-2"></i>Expand All
                            </button>
                            <button type="button" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors duration-200" onclick="collapseAll()">
                                <i class="fas fa-compress-arrows-alt mr-2"></i>Collapse All
                            </button>
                            <button type="button" class="inline-flex items-center px-4 py-2 border border-transparent rounded-lg text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors duration-200" onclick="saveGridChanges()">
                                <i class="fas fa-save mr-2"></i>Save Changes
                            </button>
                        </div>
                    </div>
                </div>
                <div class="p-0">
                    <div class="role-permission-grid overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700" id="permissionGridTable">
                            <thead class="bg-gray-50 dark:bg-gray-700">
                                <tr>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider sticky left-0 bg-gray-50 dark:bg-gray-700 z-10" style="width: 200px;">Module / Permission</th>
                                    @foreach($roles as $role)
                                        <th class="px-4 py-3 text-center text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider" style="min-width: 100px;">
                                            <div class="text-center">
                                                <div class="font-semibold text-gray-900 dark:text-white">{{ $role->display_name }}</div>
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
            </div>
        </div>

        <!-- Hierarchy Tab -->
        <div class="tab-pane fade" id="hierarchy" role="tabpanel" aria-labelledby="hierarchy-tab">
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700">
                <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                        <h5 class="text-lg font-semibold text-gray-900 dark:text-white mb-0">Role Hierarchy</h5>
                        <div class="flex flex-col sm:flex-row gap-3">
                            <button type="button" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors duration-200" onclick="refreshHierarchy()">
                                <i class="fas fa-sync mr-2"></i>Refresh
                            </button>
                            <button type="button" class="inline-flex items-center px-4 py-2 border border-transparent rounded-lg text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors duration-200" onclick="showModal('hierarchySettingsModal')">
                                <i class="fas fa-cog mr-2"></i>Settings
                            </button>
                        </div>
                    </div>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                        <div class="lg:col-span-2">
                            <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-6">
                                <h6 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Role Hierarchy Tree</h6>
                                <div class="hierarchy-tree" id="hierarchyTree">
                                    <!-- Hierarchy tree will be populated by JavaScript -->
                                </div>
                            </div>
                        </div>
                        <div class="lg:col-span-1">
                            <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-6">
                                <h6 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Hierarchy Statistics</h6>
                                <div id="hierarchyStats">
                                    <!-- Stats will be populated by JavaScript -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Add Role Modal -->
<div class="fixed inset-0 z-50 overflow-y-auto hidden" id="addRoleModal" aria-labelledby="addRoleModalLabel" aria-hidden="true">
    <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 transition-opacity bg-gray-500 bg-opacity-75" data-bs-dismiss="modal"></div>
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen">&#8203;</span>
        <div class="inline-block w-full max-w-2xl my-8 overflow-hidden text-left align-middle transition-all transform bg-white dark:bg-gray-800 rounded-lg shadow-xl">
            <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                <div class="flex items-center justify-between">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white" id="addRoleModalLabel">Add New Role</h3>
                    <button type="button" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 rounded-lg" data-bs-dismiss="modal" aria-label="Close">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            </div>
            <div class="px-6 py-4">
                <form id="addRoleForm" class="space-y-4">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="roleName" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Role Name *</label>
                            <input type="text" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" id="roleName" name="name" required>
                            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Unique identifier for the role (e.g., admin, manager)</p>
                        </div>
                        <div>
                            <label for="roleDisplayName" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Display Name *</label>
                            <input type="text" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" id="roleDisplayName" name="display_name" required>
                            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Human-readable name (e.g., Administrator, Manager)</p>
                        </div>
                    </div>
                    <div>
                        <label for="roleDescription" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Description</label>
                        <textarea class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" id="roleDescription" name="description" rows="3"></textarea>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div>
                            <label for="roleLevel" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Level *</label>
                            <select class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" id="roleLevel" name="level" required>
                                @foreach($roles->pluck('level')->unique()->sort() as $level)
                                    <option value="{{ $level }}">{{ $level }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label for="roleStatus" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Status</label>
                            <select class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" id="roleStatus" name="status">
                                @foreach($roles->pluck('status')->unique() as $status)
                                    <option value="{{ $status }}">{{ ucfirst($status) }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label for="roleParent" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Parent Role</label>
                            <select class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" id="roleParent" name="parent_role_id">
                                <option value="">None</option>
                                @foreach($roles as $role)
                                    <option value="{{ $role->id }}">{{ $role->display_name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="inheritPermissions" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Inherit Permissions</label>
                            <select class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" id="inheritPermissions" name="inherit_permissions">
                                <option value="0">No</option>
                                <option value="1">Yes</option>
                            </select>
                        </div>
                        <div>
                            <label for="inheritanceMode" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Inheritance Mode</label>
                            <select class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" id="inheritanceMode" name="permissions_inheritance_mode">
                                <option value="none">None</option>
                                <option value="direct">Direct Parent Only</option>
                                <option value="recursive">Recursive (All Parents)</option>
                            </select>
                        </div>
                    </div>
                    <div>
                        <label for="rolePermissions" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Permissions</label>
                        <select class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" id="rolePermissions" name="permission_ids[]" multiple size="8">
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
            <div class="px-6 py-4 border-t border-gray-200 dark:border-gray-700">
                <div class="flex justify-end space-x-3">
                    <button type="button" class="px-4 py-2 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors duration-200" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="inline-flex items-center px-4 py-2 border border-transparent rounded-lg text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors duration-200" onclick="addRole()">
                        <i class="fas fa-plus mr-2"></i>Add Role
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Add Permission Modal -->
<div class="fixed inset-0 z-50 overflow-y-auto hidden" id="addPermissionModal" aria-labelledby="addPermissionModalLabel" aria-hidden="true">
    <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 transition-opacity bg-gray-500 bg-opacity-75" data-bs-dismiss="modal"></div>
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen">&#8203;</span>
        <div class="inline-block w-full max-w-lg my-8 overflow-hidden text-left align-middle transition-all transform bg-white dark:bg-gray-800 rounded-lg shadow-xl">
            <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                <div class="flex items-center justify-between">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white" id="addPermissionModalLabel">Add New Permission</h3>
                    <button type="button" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 rounded-lg" data-bs-dismiss="modal" aria-label="Close">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            </div>
            <div class="px-6 py-4">
                <form id="addPermissionForm" class="space-y-4">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="permissionName" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Permission Name *</label>
                            <input type="text" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" id="permissionName" name="name" required>
                            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Unique identifier (e.g., users.create, posts.edit)</p>
                        </div>
                        <div>
                            <label for="permissionDisplayName" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Display Name *</label>
                            <input type="text" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" id="permissionDisplayName" name="display_name" required>
                            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Human-readable name (e.g., Create Users, Edit Posts)</p>
                        </div>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="permissionModule" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Module *</label>
                            <input type="text" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" id="permissionModule" name="module" required>
                            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Module/category (e.g., users, posts, settings)</p>
                        </div>
                        <div>
                            <label for="permissionStatus" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Status</label>
                            <select class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" id="permissionStatus" name="status">
                                <option value="active">Active</option>
                                <option value="inactive">Inactive</option>
                            </select>
                        </div>
                    </div>
                    <div>
                        <label for="permissionDescription" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Description</label>
                        <textarea class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" id="permissionDescription" name="description" rows="3"></textarea>
                    </div>
                </form>
            </div>
            <div class="px-6 py-4 border-t border-gray-200 dark:border-gray-700">
                <div class="flex justify-end space-x-3">
                    <button type="button" class="px-4 py-2 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors duration-200" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="inline-flex items-center px-4 py-2 border border-transparent rounded-lg text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors duration-200" onclick="addPermission()">
                        <i class="fas fa-plus mr-2"></i>Add Permission
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Edit Role Modal -->
<div class="fixed inset-0 z-50 overflow-y-auto hidden" id="editRoleModal" aria-labelledby="editRoleModalLabel" aria-hidden="true">
    <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 transition-opacity bg-gray-500 bg-opacity-75" data-bs-dismiss="modal"></div>
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen">&#8203;</span>
        <div class="inline-block w-full max-w-2xl my-8 overflow-hidden text-left align-middle transition-all transform bg-white dark:bg-gray-800 rounded-lg shadow-xl">
            <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                <div class="flex items-center justify-between">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white" id="editRoleModalLabel">Edit Role</h3>
                    <button type="button" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 rounded-lg" data-bs-dismiss="modal" aria-label="Close">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            </div>
            <div class="px-6 py-4">
                <form id="editRoleForm">
                    <input type="hidden" id="editRoleId" name="role_id">
                    <!-- Form fields similar to add role modal -->
                </form>
            </div>
            <div class="px-6 py-4 border-t border-gray-200 dark:border-gray-700">
                <div class="flex justify-end space-x-3">
                    <button type="button" class="px-4 py-2 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors duration-200" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="inline-flex items-center px-4 py-2 border border-transparent rounded-lg text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors duration-200" onclick="updateRole()">
                        <i class="fas fa-save mr-2"></i>Update Role
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- View Role Modal -->
<div class="fixed inset-0 z-50 overflow-y-auto hidden" id="viewRoleModal" aria-labelledby="viewRoleModalLabel" aria-hidden="true">
    <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 transition-opacity bg-gray-500 bg-opacity-75" data-bs-dismiss="modal"></div>
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen">&#8203;</span>
        <div class="inline-block w-full max-w-6xl my-8 overflow-hidden text-left align-middle transition-all transform bg-white dark:bg-gray-800 rounded-lg shadow-xl">
            <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                <div class="flex items-center justify-between">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white" id="viewRoleModalLabel">Role Details</h3>
                    <button type="button" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 rounded-lg" data-bs-dismiss="modal" aria-label="Close">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            </div>
            <div class="px-6 py-4" id="viewRoleContent">
                <!-- Content will be loaded dynamically -->
            </div>
            <div class="px-6 py-4 border-t border-gray-200 dark:border-gray-700">
                <div class="flex justify-end space-x-3">
                    <button type="button" class="px-4 py-2 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors duration-200" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="inline-flex items-center px-4 py-2 border border-transparent rounded-lg text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors duration-200" onclick="editRoleFromView()">
                        <i class="fas fa-edit mr-2"></i>Edit Role
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
let currentRoleId = null;
let currentPermissionId = null;
let permissionGridData = {};

// Modal management functions
function showModal(modalId) {
    const modal = document.getElementById(modalId);
    modal.classList.remove('hidden');
    modal.classList.add('flex');
    document.body.style.overflow = 'hidden';
}

function hideModal(modalId) {
    const modal = document.getElementById(modalId);
    modal.classList.add('hidden');
    modal.classList.remove('flex');
    document.body.style.overflow = 'auto';
}

// Tab management functions
function showTab(tabName) {
    // Hide all tab panes
    document.querySelectorAll('.tab-pane').forEach(pane => {
        pane.classList.remove('show', 'active');
        pane.style.display = 'none';
    });
    
    // Remove active state from all tab buttons
    document.querySelectorAll('[id$="-tab"]').forEach(button => {
        button.classList.remove('border-indigo-500', 'text-indigo-600', 'dark:text-indigo-400');
        button.classList.add('border-transparent', 'text-gray-500', 'hover:text-gray-700', 'hover:border-gray-300', 'dark:text-gray-400', 'dark:hover:text-gray-300', 'dark:hover:border-gray-600');
    });
    
    // Show selected tab pane
    const targetPane = document.getElementById(tabName);
    if (targetPane) {
        targetPane.classList.add('show', 'active');
        targetPane.style.display = 'block';
    }
    
    // Add active state to clicked tab button
    const activeTab = document.getElementById(tabName + '-tab');
    if (activeTab) {
        activeTab.classList.remove('border-transparent', 'text-gray-500', 'hover:text-gray-700', 'hover:border-gray-300', 'dark:text-gray-400', 'dark:hover:text-gray-300', 'dark:hover:border-gray-600');
        activeTab.classList.add('border-indigo-500', 'text-indigo-600', 'dark:text-indigo-400');
    }
}

// Close modal when clicking outside
document.addEventListener('click', function(e) {
    if (e.target.classList.contains('fixed') && e.target.classList.contains('inset-0')) {
        const modal = e.target.closest('.fixed.inset-0');
        if (modal) {
            hideModal(modal.id);
        }
    }
});

// Initialize page
document.addEventListener('DOMContentLoaded', function() {
    // Show the first tab by default
    showTab('roles');
    initializePermissionGrid();
    initializeHierarchy();
    setupSearchFilters();
    startRealTimeUpdates();
});

// Real-time updates functionality
let realTimeInterval;
let lastUpdateTime = Math.floor(Date.now() / 1000);

function startRealTimeUpdates() {
    // Check for updates every 30 seconds
    realTimeInterval = setInterval(checkForUpdates, 30000);
}

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
    const iconClass = type === 'success' ? 'fa-check-circle' : type === 'error' ? 'fa-exclamation-circle' : 'fa-info-circle';
    
    const toastHTML = `
        <div id="${toastId}" class="flex items-center p-4 mb-4 text-white rounded-lg shadow-lg ${bgClass} transform transition-all duration-300 translate-x-full opacity-0">
            <i class="fas ${iconClass} mr-3"></i>
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

// Search and filter functionality
function setupSearchFilters() {
    document.getElementById('roleSearch').addEventListener('input', function(e) {
        filterRoles();
    });
    
    document.getElementById('roleLevelFilter').addEventListener('change', function(e) {
        filterRoles();
    });
    
    document.getElementById('permissionSearch').addEventListener('input', function(e) {
        filterPermissions();
    });
    
    document.getElementById('moduleFilter').addEventListener('change', function(e) {
        filterPermissions();
    });
}

function filterRoles() {
    const searchTerm = document.getElementById('roleSearch').value.toLowerCase();
    const levelFilter = document.getElementById('roleLevelFilter').value;
    
    document.querySelectorAll('.role-item').forEach(item => {
        const roleName = item.dataset.roleName.toLowerCase();
        const roleLevel = item.dataset.roleLevel;
        
        const matchesSearch = roleName.includes(searchTerm);
        const matchesLevel = !levelFilter || roleLevel === levelFilter;
        
        item.style.display = matchesSearch && matchesLevel ? 'block' : 'none';
    });
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

// Role management functions
function addRole() {
    const form = document.getElementById('addRoleForm');
    const formData = new FormData(form);
    
    fetch('/api/roles', {
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
            showToast('Role created successfully', 'success');
            hideModal('addRoleModal');
            location.reload();
        } else {
            showToast('Error: ' + data.message, 'error');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showToast('An error occurred while creating the role', 'error');
    });
}

function editRole(roleId) {
    currentRoleId = roleId;
    // Load role data and populate edit form
    fetch(`/api/roles/${roleId}`)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const role = data.role;
                // Populate form fields
                document.getElementById('editRoleId').value = role.id;
                // ... populate other fields
                showModal('editRoleModal');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showToast('An error occurred while loading role data', 'error');
        });
}

function updateRole() {
    const form = document.getElementById('editRoleForm');
    const formData = new FormData(form);
    
    fetch(`/api/roles/${currentRoleId}`, {
        method: 'PUT',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify(Object.fromEntries(formData))
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
    });
}

function viewRole(roleId) {
    fetch(`/api/roles/${roleId}`)
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
                                    <span class="text-gray-900 dark:text-white">${role.display_name}</span>
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
                                    <span class="text-gray-900 dark:text-white">${role.status}</span>
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
                `;
                document.getElementById('viewRoleContent').innerHTML = content;
                showModal('viewRoleModal');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showToast('An error occurred while loading role data', 'error');
        });
}

function deleteRole(roleId) {
    if (confirm('Are you sure you want to delete this role? This action cannot be undone.')) {
        fetch(`/api/roles/${roleId}`, {
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
    if (confirm('Are you sure you want to clone this role?')) {
        fetch(`/api/roles/${roleId}/clone`, {
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
    
    fetch('/api/permissions', {
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
    fetch(`/api/permissions/${permissionId}`)
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
        fetch(`/api/permissions/${permissionId}`, {
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
    window.location.href = '/api/roles/export';
}

function editRoleFromView() {
    hideModal('viewRoleModal');
    editRole(currentRoleId);
}
</script>
@endsection
