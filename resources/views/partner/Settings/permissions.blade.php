@extends('layouts.partner-layout')

@section('title', 'Permissions Management')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900 dark:text-gray-100">
                <div class="flex justify-between items-center mb-6">
                    <div>
                        <h2 class="text-2xl font-bold">Permissions Management</h2>
                        <p class="text-gray-600 dark:text-gray-400">Manage user roles and system permissions</p>
                    </div>
                    <div class="flex space-x-3">
                        <a href="{{ route('partner.settings.index') }}" 
                           class="px-3 py-1.5 bg-indigo-600 hover:bg-indigo-700 text-white rounded-md transition-colors duration-200 text-sm">
                            ← Back to Settings
                        </a>
                    </div>
                </div>

                <div class="space-y-8">
                    <!-- Role-Based Access Control -->
                    <div class="bg-white dark:bg-gray-800 shadow-sm rounded-lg border border-gray-200 dark:border-gray-700">
                        <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Role-Based Access Control</h3>
                            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">Define permissions for different user roles</p>
                        </div>
                        <div class="p-6 space-y-6">
                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                                @foreach($roles as $role)
                                <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4">
                                    <h4 class="font-medium text-gray-900 dark:text-white mb-2">{{ $role->name }}</h4>
                                    <p class="text-sm text-gray-600 dark:text-gray-400 mb-3">{{ $role->description }}</p>
                                    <div class="flex items-center justify-between">
                                        <span class="text-xs text-gray-500 dark:text-gray-400">Users: {{ $roleUserCounts[$role->id] ?? 0 }}</span>
                                        <div class="flex space-x-2">
                                            <button onclick="editRole({{ $role->id }})" class="text-primaryGreen hover:text-primaryGreen/80 text-sm">Edit</button>
                                            @if($roleUserCounts[$role->id] ?? 0 == 0)
                                            <button onclick="deleteRole({{ $role->id }})" class="text-red-600 hover:text-red-800 text-sm">Delete</button>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                            
                            <div class="flex justify-end">
                                <button onclick="openAddRoleModal()" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-lg shadow-sm text-white bg-primaryGreen hover:bg-primaryGreen/90 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primaryGreen transition-colors duration-200">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                    </svg>
                                    Add New Role
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Module Permissions Matrix -->
                    <div class="bg-white dark:bg-gray-800 shadow-sm rounded-lg border border-gray-200 dark:border-gray-700">
                        <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Module Permissions Matrix</h3>
                            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">Configure access levels for different system modules</p>
                        </div>
                        <div class="p-6">
                            <div class="overflow-x-auto">
                                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                                    <thead class="bg-gray-50 dark:bg-gray-700">
                                        <tr>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Module</th>
                                            @foreach($roles as $role)
                                            <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">{{ $role->name }}</th>
                                            @endforeach
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                        @php
                                            $modules = ['dashboard', 'students', 'courses', 'exams', 'reports', 'settings'];
                                        @endphp
                                        @foreach($modules as $module)
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-white">{{ ucfirst($module) }}</td>
                                            @foreach($roles as $role)
                                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                                @php
                                                    $permissions = $role->permissions[$module] ?? [];
                                                    $level = 'none';
                                                    if (in_array('full', $permissions)) $level = 'full';
                                                    elseif (in_array('limited', $permissions)) $level = 'limited';
                                                    elseif (in_array('read', $permissions)) $level = 'read';
                                                @endphp
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                                    @if($level === 'full') bg-green-100 text-green-800 dark:bg-green-900/20 dark:text-green-400
                                                    @elseif($level === 'limited') bg-yellow-100 text-yellow-800 dark:bg-yellow-900/20 dark:text-yellow-400
                                                    @elseif($level === 'read') bg-blue-100 text-blue-800 dark:bg-blue-900/20 dark:text-blue-400
                                                    @else bg-red-100 text-red-800 dark:bg-red-900/20 dark:text-red-400
                                                    @endif">
                                                    {{ ucfirst($level) }}
                                                </span>
                                            </td>
                                            @endforeach
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <!-- Advanced Permission Settings -->
                    <div class="bg-white dark:bg-gray-800 shadow-sm rounded-lg border border-gray-200 dark:border-gray-700">
                        <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Advanced Permission Settings</h3>
                            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">Configure advanced security and access control features</p>
                        </div>
                        <div class="p-6 space-y-6">
                            <form id="permissionSettingsForm" action="{{ route('partner.permissions.save-settings') }}" method="POST">
                                @csrf
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div>
                                        <h4 class="text-sm font-medium text-gray-900 dark:text-white mb-3">Permission Inheritance</h4>
                                        <div class="space-y-3">
                                            <label class="flex items-center">
                                                <input type="checkbox" name="permission_inheritance" class="rounded border-gray-300 text-primaryGreen shadow-sm focus:border-primaryGreen focus:ring-primaryGreen dark:border-gray-600 dark:bg-gray-700" 
                                                       {{ $defaultSettings['permission_inheritance'] ? 'checked' : '' }}>
                                                <span class="ml-2 text-sm text-gray-700 dark:text-gray-300">Enable role hierarchy</span>
                                            </label>
                                            <label class="flex items-center">
                                                <input type="checkbox" name="inherit_parent_permissions" class="rounded border-gray-300 text-primaryGreen shadow-sm focus:border-primaryGreen focus:ring-primaryGreen dark:border-gray-600 dark:bg-gray-700"
                                                       {{ $defaultSettings['inherit_parent_permissions'] ? 'checked' : '' }}>
                                                <span class="ml-2 text-sm text-gray-700 dark:text-gray-300">Inherit permissions from parent roles</span>
                                            </label>
                                            <label class="flex items-center">
                                                <input type="checkbox" name="allow_permission_overrides" class="rounded border-gray-300 text-primaryGreen shadow-sm focus:border-primaryGreen focus:ring-primaryGreen dark:border-gray-600 dark:bg-gray-700"
                                                       {{ $defaultSettings['allow_permission_overrides'] ? 'checked' : '' }}>
                                                <span class="ml-2 text-sm text-gray-700 dark:text-gray-300">Allow permission overrides</span>
                                            </label>
                                        </div>
                                    </div>
                                    
                                    <div>
                                        <h4 class="text-sm font-medium text-gray-900 dark:text-white mb-3">Audit & Logging</h4>
                                        <div class="space-y-3">
                                            <label class="flex items-center">
                                                <input type="checkbox" name="log_permission_changes" class="rounded border-gray-300 text-primaryGreen shadow-sm focus:border-primaryGreen focus:ring-primaryGreen dark:border-gray-600 dark:bg-gray-700"
                                                       {{ $defaultSettings['log_permission_changes'] ? 'checked' : '' }}>
                                                <span class="ml-2 text-sm text-gray-700 dark:text-gray-300">Log permission changes</span>
                                            </label>
                                            <label class="flex items-center">
                                                <input type="checkbox" name="track_user_access" class="rounded border-gray-300 text-primaryGreen shadow-sm focus:border-primaryGreen focus:ring-primaryGreen dark:border-gray-600 dark:bg-gray-700"
                                                       {{ $defaultSettings['track_user_access'] ? 'checked' : '' }}>
                                                <span class="ml-2 text-sm text-gray-700 dark:text-gray-300">Track user access</span>
                                            </label>
                                            <label class="flex items-center">
                                                <input type="checkbox" name="notify_security_events" class="rounded border-gray-300 text-primaryGreen shadow-sm focus:border-primaryGreen focus:ring-primaryGreen dark:border-gray-600 dark:bg-gray-700"
                                                       {{ $defaultSettings['notify_security_events'] ? 'checked' : '' }}>
                                                <span class="ml-2 text-sm text-gray-700 dark:text-gray-300">Notify on security events</span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                
                                <div>
                                    <h4 class="text-sm font-medium text-gray-900 dark:text-white mb-3">Session Management</h4>
                                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                        <div>
                                            <label for="session_timeout" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Session Timeout (minutes)</label>
                                            <input type="number" id="session_timeout" name="session_timeout" value="{{ $defaultSettings['session_timeout'] }}" min="5" max="480" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:ring-2 focus:ring-primaryGreen focus:border-primaryGreen dark:bg-gray-700 dark:text-white">
                                        </div>
                                        <div>
                                            <label for="max_sessions" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Max Concurrent Sessions</label>
                                            <input type="number" id="max_sessions" name="max_sessions" value="{{ $defaultSettings['max_sessions'] }}" min="1" max="10" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:ring-2 focus:ring-primaryGreen focus:border-primaryGreen dark:bg-gray-700 dark:text-white">
                                        </div>
                                        <div>
                                            <label for="idle_timeout" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Idle Timeout (minutes)</label>
                                            <input type="number" id="idle_timeout" name="idle_timeout" value="{{ $defaultSettings['idle_timeout'] }}" min="5" max="120" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:ring-2 focus:ring-primaryGreen focus:border-primaryGreen dark:bg-gray-700 dark:text-white">
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- Quick Actions -->
                    <div class="bg-white dark:bg-gray-800 shadow-sm rounded-lg border border-gray-200 dark:border-gray-700 p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <h4 class="text-lg font-medium text-gray-900 dark:text-white">Quick Actions</h4>
                                <p class="text-sm text-gray-600 dark:text-gray-400">Common permission management tasks</p>
                            </div>
                            <div class="flex space-x-3">
                                <button onclick="savePermissions()" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-lg shadow-sm text-white bg-primaryGreen hover:bg-primaryGreen/90 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primaryGreen transition-colors duration-200">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                    Save Permissions
                                </button>
                                <button onclick="resetPermissions()" class="inline-flex items-center px-4 py-2 border border-gray-300 dark:border-gray-600 text-sm font-medium rounded-lg text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primaryGreen transition-colors duration-200">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                                    </svg>
                                    Reset to Defaults
                                </button>
                                <button onclick="exportPermissions()" class="inline-flex items-center px-4 py-2 border border-gray-300 dark:border-gray-600 text-sm font-medium rounded-lg text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primaryGreen transition-colors duration-200">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                    </svg>
                                    Export Permissions
                                </button>
                                <button onclick="importPermissions()" class="inline-flex items-center px-4 py-2 border border-gray-300 dark:border-gray-600 text-sm font-medium rounded-lg text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primaryGreen transition-colors duration-200">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                                    </svg>
                                    Import Permissions
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Add Role Modal -->
<div id="addRoleModal" class="fixed inset-0 z-50 hidden">
    <div class="absolute inset-0 bg-gray-500 bg-opacity-75 transition-opacity"></div>
    
    <div class="fixed inset-0 z-10 overflow-y-auto">
        <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
            <div class="relative transform overflow-hidden rounded-lg bg-white dark:bg-gray-800 text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg">
                <div class="bg-white dark:bg-gray-800 px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <div class="mx-auto flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-full bg-primaryGreen/10 sm:mx-0 sm:h-10 sm:w-10">
                            <svg class="h-6 w-6 text-primaryGreen" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                            </svg>
                        </div>
                        <div class="mt-3 text-center sm:ml-4 sm:mt-0 sm:text-left">
                            <h3 class="text-lg font-medium leading-6 text-gray-900 dark:text-white">Add New Role</h3>
                            <div class="mt-4 space-y-4">
                                <div>
                                    <label for="new_role_name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Role Name</label>
                                    <input type="text" id="new_role_name" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-primaryGreen focus:ring-primaryGreen dark:bg-gray-700 dark:text-white sm:text-sm">
                                </div>
                                <div>
                                    <label for="new_role_description" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Description</label>
                                    <textarea id="new_role_description" rows="3" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-primaryGreen focus:ring-primaryGreen dark:bg-gray-700 dark:text-white sm:text-sm"></textarea>
                                </div>
                                <div>
                                    <label for="new_role_parent" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Parent Role (Optional)</label>
                                    <select id="new_role_parent" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-primaryGreen focus:ring-primaryGreen dark:bg-gray-700 dark:text-white sm:text-sm">
                                        <option value="">No Parent Role</option>
                                        @foreach($roles as $role)
                                        <option value="{{ $role->id }}">{{ $role->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 dark:bg-gray-700 px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6">
                    <button type="button" onclick="addNewRole()" class="inline-flex w-full justify-center rounded-md border border-transparent bg-primaryGreen px-4 py-2 text-base font-medium text-white shadow-sm hover:bg-primaryGreen/90 focus:outline-none focus:ring-2 focus:ring-primaryGreen focus:ring-offset-2 sm:ml-3 sm:w-auto sm:text-sm transition-colors duration-200">
                        Add Role
                    </button>
                    <button type="button" onclick="closeAddRoleModal()" class="mt-3 inline-flex w-full justify-center rounded-md border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 px-4 py-2 text-base font-medium text-gray-700 dark:text-gray-300 shadow-sm hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-primaryGreen focus:ring-offset-2 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm transition-colors duration-200">
                        Cancel
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Edit Role Modal -->
<div id="editRoleModal" class="fixed inset-0 z-50 hidden">
    <div class="absolute inset-0 bg-gray-500 bg-opacity-75 transition-opacity"></div>
    
    <div class="fixed inset-0 z-10 overflow-y-auto">
        <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
            <div class="relative transform overflow-hidden rounded-lg bg-white dark:bg-gray-800 text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg">
                <div class="bg-white dark:bg-gray-800 px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <div class="mx-auto flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-full bg-primaryGreen/10 sm:mx-0 sm:h-10 sm:w-10">
                            <svg class="h-6 w-6 text-primaryGreen" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                            </svg>
                        </div>
                        <div class="mt-3 text-center sm:ml-4 sm:mt-0 sm:text-left">
                            <h3 class="text-lg font-medium leading-6 text-gray-900 dark:text-white">Edit Role</h3>
                            <div class="mt-4 space-y-4">
                                <input type="hidden" id="edit_role_id">
                                <div>
                                    <label for="edit_role_name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Role Name</label>
                                    <input type="text" id="edit_role_name" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-primaryGreen focus:ring-primaryGreen dark:bg-gray-700 dark:text-white sm:text-sm">
                                </div>
                                <div>
                                    <label for="edit_role_description" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Description</label>
                                    <textarea id="edit_role_description" rows="3" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-primaryGreen focus:ring-primaryGreen dark:bg-gray-700 dark:text-white sm:text-sm"></textarea>
                                </div>
                                <div>
                                    <label for="edit_role_parent" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Parent Role (Optional)</label>
                                    <select id="edit_role_parent" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-primaryGreen focus:ring-primaryGreen dark:bg-gray-700 dark:text-white sm:text-sm">
                                        <option value="">No Parent Role</option>
                                        @foreach($roles as $role)
                                        <option value="{{ $role->id }}">{{ $role->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 dark:bg-gray-700 px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6">
                    <button type="button" onclick="updateRole()" class="inline-flex w-full justify-center rounded-md border border-transparent bg-primaryGreen px-4 py-2 text-base font-medium text-white shadow-sm hover:bg-primaryGreen/90 focus:outline-none focus:ring-2 focus:ring-primaryGreen focus:ring-offset-2 sm:ml-3 sm:w-auto sm:text-sm transition-colors duration-200">
                        Update Role
                    </button>
                    <button type="button" onclick="closeEditRoleModal()" class="mt-3 inline-flex w-full justify-center rounded-md border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 px-4 py-2 text-base font-medium text-gray-700 dark:text-gray-300 shadow-sm hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-primaryGreen focus:ring-offset-2 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm transition-colors duration-200">
                        Cancel
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Import Modal -->
<div id="importModal" class="fixed inset-0 z-50 hidden">
    <div class="absolute inset-0 bg-gray-500 bg-opacity-75 transition-opacity"></div>
    
    <div class="fixed inset-0 z-10 overflow-y-auto">
        <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
            <div class="relative transform overflow-hidden rounded-lg bg-white dark:bg-gray-800 text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg">
                <div class="bg-white dark:bg-gray-800 px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <div class="mx-auto flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-full bg-primaryGreen/10 sm:mx-0 sm:h-10 sm:w-10">
                            <svg class="h-6 w-6 text-primaryGreen" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                            </svg>
                        </div>
                        <div class="mt-3 text-center sm:ml-4 sm:mt-0 sm:text-left">
                            <h3 class="text-lg font-medium leading-6 text-gray-900 dark:text-white">Import Permissions</h3>
                            <div class="mt-4">
                                <p class="text-sm text-gray-600 dark:text-gray-400 mb-4">Paste the exported permissions data below:</p>
                                <textarea id="importData" rows="8" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-primaryGreen focus:ring-primaryGreen dark:bg-gray-700 dark:text-white sm:text-sm" placeholder='{"roles": [...], "permissions": [...], "settings": [...]}'></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 dark:bg-gray-700 px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6">
                    <button type="button" onclick="processImport()" class="inline-flex w-full justify-center rounded-md border border-transparent bg-primaryGreen px-4 py-2 text-base font-medium text-white shadow-sm hover:bg-primaryGreen/90 focus:outline-none focus:ring-2 focus:ring-primaryGreen focus:ring-offset-2 sm:ml-3 sm:w-auto sm:text-sm transition-colors duration-200">
                        Import
                    </button>
                    <button type="button" onclick="closeImportModal()" class="mt-3 inline-flex w-full justify-center rounded-md border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 px-4 py-2 text-base font-medium text-gray-700 dark:text-gray-300 shadow-sm hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-primaryGreen focus:ring-offset-2 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm transition-colors duration-200">
                        Cancel
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Modal functions
function openAddRoleModal() {
    document.getElementById('addRoleModal').classList.remove('hidden');
}

function closeAddRoleModal() {
    document.getElementById('addRoleModal').classList.add('hidden');
    document.getElementById('new_role_name').value = '';
    document.getElementById('new_role_description').value = '';
    document.getElementById('new_role_parent').value = '';
}

function openEditRoleModal(roleId) {
    // Fetch role data and populate form
    fetch(`/partner/permissions/roles/${roleId}`)
        .then(response => response.json())
        .then(data => {
            document.getElementById('edit_role_id').value = data.role.id;
            document.getElementById('edit_role_name').value = data.role.name;
            document.getElementById('edit_role_description').value = data.role.description || '';
            document.getElementById('edit_role_parent').value = data.role.parent_role_id || '';
            document.getElementById('editRoleModal').classList.remove('hidden');
        })
        .catch(error => {
            console.error('Error fetching role:', error);
            showToast('Error fetching role data', 'error');
        });
}

function closeEditRoleModal() {
    document.getElementById('editRoleModal').classList.add('hidden');
}

function openImportModal() {
    document.getElementById('importModal').classList.remove('hidden');
}

function closeImportModal() {
    document.getElementById('importModal').classList.add('hidden');
    document.getElementById('importData').value = '';
}

// Role management functions
function addNewRole() {
    const name = document.getElementById('new_role_name').value;
    const description = document.getElementById('new_role_description').value;
    const parentRoleId = document.getElementById('new_role_parent').value;
    
    if (!name) {
        showToast('Please enter a role name', 'error');
        return;
    }
    
    fetch('{{ route("partner.permissions.store-role") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({
            name: name,
            description: description,
            parent_role_id: parentRoleId || null
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showToast(data.message, 'success');
            closeAddRoleModal();
            location.reload(); // Refresh to show new role
        } else {
            showToast(data.message, 'error');
        }
    })
    .catch(error => {
        console.error('Error creating role:', error);
        showToast('Error creating role', 'error');
    });
}

function editRole(roleId) {
    openEditRoleModal(roleId);
}

function updateRole() {
    const roleId = document.getElementById('edit_role_id').value;
    const name = document.getElementById('edit_role_name').value;
    const description = document.getElementById('edit_role_description').value;
    const parentRoleId = document.getElementById('edit_role_parent').value;
    
    if (!name) {
        showToast('Please enter a role name', 'error');
        return;
    }
    
    fetch(`/partner/permissions/roles/${roleId}`, {
        method: 'PUT',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({
            name: name,
            description: description,
            parent_role_id: parentRoleId || null
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showToast(data.message, 'success');
            closeEditRoleModal();
            location.reload(); // Refresh to show updated role
        } else {
            showToast(data.message, 'error');
        }
    })
    .catch(error => {
        console.error('Error updating role:', error);
        showToast('Error updating role', 'error');
    });
}

function deleteRole(roleId) {
    if (confirm('Are you sure you want to delete this role? This action cannot be undone.')) {
        fetch(`/partner/permissions/roles/${roleId}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showToast(data.message, 'success');
                location.reload(); // Refresh to show updated roles
            } else {
                showToast(data.message, 'error');
            }
        })
        .catch(error => {
            console.error('Error deleting role:', error);
            showToast('Error deleting role', 'error');
        });
    }
}

// Settings functions
function savePermissions() {
    const form = document.getElementById('permissionSettingsForm');
    const formData = new FormData(form);
    
    fetch('{{ route("partner.permissions.save-settings") }}', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showToast(data.message, 'success');
        } else {
            showToast(data.message, 'error');
        }
    })
    .catch(error => {
        console.error('Error saving settings:', error);
        showToast('Error saving settings', 'error');
    });
}

function resetPermissions() {
    if (confirm('Are you sure you want to reset all permissions to default values? This action cannot be undone.')) {
        fetch('{{ route("partner.permissions.reset") }}', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showToast(data.message, 'success');
                location.reload(); // Refresh to show default permissions
            } else {
                showToast(data.message, 'error');
            }
        })
        .catch(error => {
            console.error('Error resetting permissions:', error);
            showToast('Error resetting permissions', 'error');
        });
    }
}

function exportPermissions() {
    fetch('{{ route("partner.permissions.export") }}')
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Create download link
                const blob = new Blob([JSON.stringify(data.data, null, 2)], { type: 'application/json' });
                const url = window.URL.createObjectURL(blob);
                const a = document.createElement('a');
                a.href = url;
                a.download = `permissions_export_${new Date().toISOString().split('T')[0]}.json`;
                document.body.appendChild(a);
                a.click();
                window.URL.revokeObjectURL(url);
                document.body.removeChild(a);
                
                showToast('Permissions exported successfully!', 'success');
            } else {
                showToast(data.message, 'error');
            }
        })
        .catch(error => {
            console.error('Error exporting permissions:', error);
            showToast('Error exporting permissions', 'error');
        });
}

function importPermissions() {
    openImportModal();
}

function processImport() {
    const importData = document.getElementById('importData').value;
    
    if (!importData) {
        showToast('Please enter import data', 'error');
        return;
    }
    
    try {
        const data = JSON.parse(importData);
        
        fetch('{{ route("partner.permissions.import") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({ data: data })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showToast(data.message, 'success');
                closeImportModal();
                location.reload(); // Refresh to show imported permissions
            } else {
                showToast(data.message, 'error');
            }
        })
        .catch(error => {
            console.error('Error importing permissions:', error);
            showToast('Error importing permissions', 'error');
        });
    } catch (error) {
        showToast('Invalid JSON format', 'error');
    }
}

// Toast notification function
function showToast(message, type = 'info') {
    // Create toast element
    const toast = document.createElement('div');
    toast.className = `fixed top-4 right-4 z-50 px-6 py-3 rounded-lg shadow-lg text-white ${
        type === 'success' ? 'bg-green-600' : 
        type === 'error' ? 'bg-red-600' : 
        'bg-blue-600'
    }`;
    toast.textContent = message;
    
    document.body.appendChild(toast);
    
    // Remove toast after 3 seconds
    setTimeout(() => {
        if (toast.parentNode) {
            toast.parentNode.removeChild(toast);
        }
    }, 3000);
}

// Close modals when clicking outside
document.addEventListener('click', function(event) {
    const addModal = document.getElementById('addRoleModal');
    const editModal = document.getElementById('editRoleModal');
    const importModal = document.getElementById('importModal');
    
    if (event.target === addModal) {
        closeAddRoleModal();
    }
    if (event.target === editModal) {
        closeEditRoleModal();
    }
    if (event.target === importModal) {
        closeImportModal();
    }
});
</script>

@endsection
