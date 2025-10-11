@extends('layouts.partner-layout')

@section('title', 'BikolpoLive|Partner Settings')

@section('content')
<div class="min-h-screen bg-gray-50/50 p-3 sm:p-4">
    <!-- Page Header -->
    <div class="mb-4">
        <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-3 sm:p-4">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                <div>
                    <h1 class="text-xl font-bold text-gray-800 mb-1">
                        Partner Settings
                    </h1>
                    <p class="text-gray-500 text-xs">
                        Manage your organization settings, users, and permissions
                    </p>
                </div>
                <div class="flex flex-wrap gap-1">
                    <a href="{{ route('partner.settings.backup-restore') }}" class="inline-flex items-center px-3 py-1.5 bg-gradient-to-r from-green-500 to-emerald-600 text-white text-xs font-medium rounded-md hover:opacity-90 focus:outline-none focus:ring-1 focus:ring-green-500/20 focus:ring-offset-1 transition-all active:scale-[0.98]">
                        <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3-3m0 0l-3 3m3-3v12"></path>
                        </svg>
                        Backup/Restore
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Stats Section -->
    <div class="grid grid-cols-2 md:grid-cols-4 gap-3 mb-4">
        <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-3">
            <div class="flex items-center">
                <div class="p-2 rounded-lg bg-blue-50 text-blue-600">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                    </svg>
                </div>
                <div class="ml-3">
                    <p class="text-xs font-medium text-gray-500">Total Users</p>
                    <p class="text-lg font-semibold text-gray-900">{{ $stats['total_users'] ?? 0 }}</p>
                </div>
            </div>
        </div>
        
        <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-3">
            <div class="flex items-center">
                <div class="p-2 rounded-lg bg-green-50 text-green-600">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div class="ml-3">
                    <p class="text-xs font-medium text-gray-500">Active Users</p>
                    <p class="text-lg font-semibold text-gray-900">{{ $stats['active_users'] ?? 0 }}</p>
                </div>
            </div>
        </div>
        
        <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-3">
            <div class="flex items-center">
                <div class="p-2 rounded-lg bg-yellow-50 text-yellow-600">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div class="ml-3">
                    <p class="text-xs font-medium text-gray-500">Pending Users</p>
                    <p class="text-lg font-semibold text-gray-900">{{ $stats['pending_users'] ?? 0 }}</p>
                </div>
            </div>
        </div>
        
        <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-3">
            <div class="flex items-center">
                <div class="p-2 rounded-lg bg-red-50 text-red-600">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"></path>
                    </svg>
                </div>
                <div class="ml-3">
                    <p class="text-xs font-medium text-gray-500">Suspended Users</p>
                    <p class="text-lg font-semibold text-gray-900">{{ $stats['suspended_users'] ?? 0 }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- User Management Section -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-100 mb-4 overflow-hidden">
        <!-- Header -->
        <div class="px-3 py-2 border-b border-gray-100 bg-gray-50/50">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2">
                <div>
                    <h3 class="text-base font-semibold text-gray-800">User Management</h3>
                    <p class="text-xs text-gray-500 mt-0.5">Manage all user accounts and their access</p>
                </div>
                <a href="{{ route('partner.settings.users.create') }}" 
                   class="inline-flex items-center px-3 py-1.5 bg-gradient-to-r from-blue-500 to-blue-600 text-white text-xs font-medium rounded-md hover:opacity-90 focus:outline-none focus:ring-1 focus:ring-blue-500/20 focus:ring-offset-1 transition-all active:scale-[0.98]">
                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                    Create User
                </a>
            </div>
        </div>
        
        <!-- Users Content -->
        <div class="p-1">
            @if(isset($stats['users']) && $stats['users']->isNotEmpty())
                <!-- Group users by role hierarchy -->
                @php
                    // Group users by role name and sort by role level
                    // Create a proper array structure instead of trying to modify Collection elements directly
                    $usersByRoleArray = [];
                    
                    foreach ($stats['users'] as $user) {
                        $roleDisplayName = $user->getRoleDisplayName();
                        
                        // Initialize the role group if it doesn't exist
                        if (!isset($usersByRoleArray[$roleDisplayName])) {
                            $usersByRoleArray[$roleDisplayName] = [
                                'users' => collect(),
                                'name' => $roleDisplayName
                            ];
                        }
                        
                        // Add user to the role group
                        $usersByRoleArray[$roleDisplayName]['users']->push($user);
                    }
                    
                    // Convert to collection
                    $sortedRoles = collect($usersByRoleArray);
                @endphp
                
                <!-- Desktop Table -->
                <div class="hidden sm:block overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                                <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Phone</th>
                                <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                                <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Role</th>
                                <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-100">
                            @foreach($sortedRoles as $roleData)
                                <!-- Role Header -->
                                <tr class="bg-gray-50">
                                    <td colspan="6" class="px-3 py-1">
                                        <div class="flex items-center">
                                            <h4 class="text-xs font-semibold text-gray-700">{{ $roleData['name'] }}</h4>
                                            <span class="ml-2 px-1.5 py-0.5 text-xs font-medium rounded-full bg-gray-200 text-gray-700">
                                                {{ $roleData['users']->count() }} users
                                            </span>
                                        </div>
                                    </td>
                                </tr>
                                
                                <!-- Users in this role -->
                                @foreach($roleData['users'] as $user)
                                    <tr class="hover:bg-gray-50/50 transition-colors">
                                        <td class="px-3 py-2 whitespace-nowrap">
                                            <div class="flex items-center">
                                                <div class="flex-shrink-0 h-8 w-8 rounded-full bg-gray-100 flex items-center justify-center text-gray-500 font-medium text-xs">
                                                    {{ substr($user->name, 0, 1) }}
                                                </div>
                                                <div class="ml-2">
                                                    <div class="text-xs font-medium text-gray-900 truncate max-w-[120px]">{{ $user->name }}</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-3 py-2 whitespace-nowrap">
                                            <div class="text-xs text-gray-600 truncate max-w-[100px]">{{ $user->phone ?? 'N/A' }}</div>
                                        </td>
                                        <td class="px-3 py-2 whitespace-nowrap">
                                            <div class="text-xs text-gray-600 truncate max-w-[150px]">{{ $user->email }}</div>
                                        </td>
                                        <td class="px-3 py-2 whitespace-nowrap">
                                            <span class="inline-flex items-center px-1.5 py-0.5 rounded-full text-xs font-medium {{ $user->flag == 'active' ? 'bg-green-100 text-green-800' : ($user->flag == 'inactive' ? 'bg-gray-100 text-gray-800' : 'bg-red-100 text-red-800') }}">
                                                <span class="w-1 h-1 rounded-full {{ $user->flag == 'active' ? 'bg-green-500' : ($user->flag == 'inactive' ? 'bg-gray-500' : 'bg-red-500') }} mr-1"></span>
                                                {{ ucfirst($user->flag) }}
                                            </span>
                                        </td>
                                        <td class="px-3 py-2 whitespace-nowrap">
                                            <span class="px-1.5 py-0.5 text-xs font-medium rounded-full bg-blue-50 text-blue-700 truncate max-w-[100px]">
                                                {{ $user->getRoleDisplayName() }}
                                            </span>
                                        </td>
                                        <td class="px-3 py-2 whitespace-nowrap text-xs font-medium">
                                            <div class="relative inline-block text-left">
                                                <button type="button" 
                                                        class="text-blue-600 hover:text-blue-900 p-0.5 rounded hover:bg-blue-50 action-dropdown-btn"
                                                        data-user-id="{{ $user->id }}">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c-.94 1.543.826 3.31 2.37 2.37.996.608 2.296.07 2.572-1.065z"></path>
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                    </svg>
                                                </button>
                                                
                                                <!-- Dropdown menu -->
                                                <div class="hidden origin-top-right absolute right-0 mt-1 w-40 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 focus:outline-none action-dropdown-menu z-10" 
                                                     data-user-id="{{ $user->id }}">
                                                    <div class="py-1">
                                                        <a href="#" 
                                                           class="user-status-toggle block px-4 py-2 text-xs text-gray-700 hover:bg-gray-100 hover:text-gray-900" 
                                                           data-user-id="{{ $user->id }}" 
                                                           data-current-status="{{ $user->flag }}">
                                                            {{ $user->flag == 'active' ? 'Mark Inactive' : 'Mark Active' }}
                                                        </a>
                                                        <a href="#" 
                                                           class="user-password-reset block px-4 py-2 text-xs text-gray-700 hover:bg-gray-100 hover:text-gray-900" 
                                                           data-user-id="{{ $user->id }}">
                                                            Reset Password
                                                        </a>
                                                        <a href="#" 
                                                           class="user-delete block px-4 py-2 text-xs text-red-600 hover:bg-red-50" 
                                                           data-user-id="{{ $user->id }}"
                                                           data-user-name="{{ $user->name }}">
                                                            Delete User
                                                        </a>
                                                    </div>
                                                </div>

                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            @endforeach
                        </tbody>
                    </table>
                </div>
                
                <!-- Mobile Cards -->
                <div class="sm:hidden space-y-2 p-2">
                    @foreach($sortedRoles as $roleData)
                        <!-- Role Header -->
                        <div class="bg-gray-50 rounded-md p-2">
                            <div class="flex items-center justify-between">
                                <h4 class="text-xs font-semibold text-gray-700">{{ $roleData['name'] }}</h4>
                                <div class="flex space-x-1">
                                    <span class="px-1.5 py-0.5 text-xs font-medium rounded-full bg-gray-200 text-gray-700">
                                        {{ $roleData['users']->count() }} users
                                    </span>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Users in this role -->
                        @foreach($roleData['users'] as $user)
                            <div class="bg-white rounded-lg border border-gray-100 p-3 shadow-xs hover:shadow-sm transition-shadow">
                                <div class="flex items-start justify-between">
                                    <div class="flex items-center space-x-2">
                                        <div class="flex-shrink-0 h-8 w-8 rounded-full bg-blue-50 flex items-center justify-center text-blue-600 font-medium text-xs">
                                            {{ substr($user->name, 0, 1) }}
                                        </div>
                                        <div>
                                            <h4 class="text-xs font-medium text-gray-900 truncate max-w-[120px]">{{ $user->name }}</h4>
                                            <p class="text-xs text-gray-500 truncate max-w-[120px]">{{ $user->email }}</p>
                                        </div>
                                    </div>
                                    <span class="inline-flex items-center px-1.5 py-0.5 rounded-full text-xs font-medium {{ $user->flag == 'active' ? 'bg-green-100 text-green-800' : ($user->flag == 'inactive' ? 'bg-gray-100 text-gray-800' : 'bg-red-100 text-red-800') }}">
                                        {{ ucfirst($user->flag) }}
                                    </span>
                                </div>
                                <div class="mt-2 grid grid-cols-2 gap-1 text-xs">
                                    <div>
                                        <p class="text-gray-500 text-xs">Phone</p>
                                        <p class="text-gray-900 text-xs">{{ $user->phone ?? 'N/A' }}</p>
                                    </div>
                                    <div>
                                        <p class="text-gray-500 text-xs">Role</p>
                                        <p class="text-gray-900 text-xs truncate max-w-[80px]">
                                            {{ $user->getRoleDisplayName() }}
                                        </p>
                                    </div>
                                </div>
                                <div class="mt-2 flex items-center justify-between">
                                    <div class="relative inline-block text-left">
                                        <button type="button" 
                                                class="text-blue-600 hover:text-blue-900 p-0.5 rounded hover:bg-blue-50 action-dropdown-btn"
                                                data-user-id="{{ $user->id }}">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            </svg>
                                        </button>
                                        
                                        <!-- Dropdown menu -->
                                        <div class="hidden origin-top-right absolute right-0 mt-1 w-40 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 focus:outline-none action-dropdown-menu z-10" 
                                             data-user-id="{{ $user->id }}">
                                            <div class="py-1">
                                                <a href="#" 
                                                   class="user-status-toggle block px-4 py-2 text-xs text-gray-700 hover:bg-gray-100 hover:text-gray-900" 
                                                   data-user-id="{{ $user->id }}" 
                                                   data-current-status="{{ $user->flag }}">
                                                    {{ $user->flag == 'active' ? 'Mark Inactive' : 'Mark Active' }}
                                                </a>
                                                <a href="#" 
                                                   class="user-password-reset block px-4 py-2 text-xs text-gray-700 hover:bg-gray-100 hover:text-gray-900" 
                                                   data-user-id="{{ $user->id }}">
                                                    Reset Password
                                                </a>
                                                <a href="#" 
                                                   class="user-delete block px-4 py-2 text-xs text-red-600 hover:bg-red-50" 
                                                   data-user-id="{{ $user->id }}"
                                                   data-user-name="{{ $user->name }}">
                                                    Delete User
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @endforeach
                </div>
            @else
                <!-- Empty State -->
                <div class="text-center py-8">
                    <div class="w-12 h-12 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-3">
                        <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-base font-medium text-gray-900 mb-1">No users found</h3>
                    <p class="text-gray-600 text-sm mb-3">Users you create will be displayed here.</p>
                    <a href="{{ route('partner.settings.users.create') }}" 
                       class="inline-flex items-center px-3 py-1.5 bg-gradient-to-r from-blue-500 to-blue-600 text-white text-xs font-medium rounded-md hover:opacity-90 focus:outline-none focus:ring-1 focus:ring-blue-500/20 focus:ring-offset-1 transition-all">
                        <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                        </svg>
                        Create User
                    </a>
                </div>
            @endif
        </div>
    </div>

</div>

<!-- Password Reset Modal -->
<div id="passwordResetModal" class="hidden fixed inset-0 z-50 overflow-y-auto">
    <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
        <!-- Background overlay -->
        <div class="fixed inset-0 transition-opacity" aria-hidden="true">
            <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
        </div>

        <!-- Modal container -->
        <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
            <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                <div class="sm:flex sm:items-start">
                    <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                        <h3 class="text-lg leading-6 font-medium text-gray-900" id="passwordResetModalLabel">
                            Reset User Password
                        </h3>
                        <div class="mt-2">
                            <form id="passwordResetForm">
                                <input type="hidden" id="resetUserId" name="user_id">
                                <div class="mb-4">
                                    <label for="password" class="block text-sm font-medium text-gray-700">New Password</label>
                                    <div class="mt-1 relative rounded-md shadow-sm">
                                        <input type="password" name="password" id="password" class="focus:ring-blue-500 focus:border-blue-500 block w-full pr-10 sm:text-sm border-gray-300 rounded-md" required>
                                        <div class="absolute inset-y-0 right-0 pr-3 flex items-center">
                                            <button type="button" class="text-gray-400 hover:text-gray-500 toggle-password-visibility" data-target="password">
                                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path class="eye-open" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                    <path class="eye-open" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                    <path class="eye-closed hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.878 9.878L3 3m6.878 6.878L21 21" />
                                                </svg>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-4">
                                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Confirm Password</label>
                                    <div class="mt-1 relative rounded-md shadow-sm">
                                        <input type="password" name="password_confirmation" id="password_confirmation" class="focus:ring-blue-500 focus:border-blue-500 block w-full pr-10 sm:text-sm border-gray-300 rounded-md" required>
                                        <div class="absolute inset-y-0 right-0 pr-3 flex items-center">
                                            <button type="button" class="text-gray-400 hover:text-gray-500 toggle-password-visibility" data-target="password_confirmation">
                                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path class="eye-open" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                    <path class="eye-open" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                    <path class="eye-closed hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.878 9.878L3 3m6.878 6.878L21 21" />
                                                </svg>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <div id="passwordResetErrors" class="hidden mb-4">
                                    <div class="text-red-600 text-sm"></div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                <button type="button" id="confirmPasswordReset" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-blue-600 text-base font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:ml-3 sm:w-auto sm:text-sm">
                    Reset Password
                </button>
                <button type="button" id="cancelPasswordReset" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                    Cancel
                </button>
            </div>
        </div>
    </div>
</div>

<!-- JavaScript for dropdown functionality -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Handle dropdown toggle
    document.querySelectorAll('.action-dropdown-btn').forEach(button => {
        button.addEventListener('click', function(e) {
            e.stopPropagation();
            e.preventDefault();
            
            const userId = this.getAttribute('data-user-id');
            const dropdown = document.querySelector(`.action-dropdown-menu[data-user-id="${userId}"]`);
            
            // Hide all other dropdowns
            document.querySelectorAll('.action-dropdown-menu').forEach(menu => {
                if (menu !== dropdown) {
                    menu.classList.add('hidden');
                }
            });
            
            // Toggle current dropdown
            if (dropdown) {
                dropdown.classList.toggle('hidden');
            }
        });
    });
    
    // Hide dropdown when clicking elsewhere
    document.addEventListener('click', function(e) {
        if (!e.target.closest('.action-dropdown-btn') && !e.target.closest('.action-dropdown-menu')) {
            document.querySelectorAll('.action-dropdown-menu').forEach(menu => {
                menu.classList.add('hidden');
            });
        }
    });
    
    // Handle status toggle
    document.querySelectorAll('.user-status-toggle').forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            
            const userId = this.getAttribute('data-user-id');
            const currentStatus = this.getAttribute('data-current-status');
            const newStatus = currentStatus === 'active' ? 'inactive' : 'active';
            const actionText = newStatus === 'active' ? 'activate' : 'deactivate';
            
            if (confirm(`Are you sure you want to ${actionText} this user?`)) {
                // Make AJAX call to update user status
                fetch(`/partner/settings/users/${userId}/status`, {
                    method: 'PUT',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({
                        status: newStatus
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Show success message
                        alert(`User successfully ${actionText}d.`);
                        // Reload the page to reflect changes
                        location.reload();
                    } else {
                        alert('Failed to update user status: ' + (data.message || 'Unknown error'));
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('An error occurred while updating user status');
                });
            }
            
            // Hide dropdown
            this.closest('.action-dropdown-menu').classList.add('hidden');
        });
    });
    
    // Handle password reset modal
    const passwordResetModal = document.getElementById('passwordResetModal');
    const confirmPasswordReset = document.getElementById('confirmPasswordReset');
    const cancelPasswordReset = document.getElementById('cancelPasswordReset');
    const passwordResetForm = document.getElementById('passwordResetForm');
    const passwordResetErrors = document.getElementById('passwordResetErrors');
    
    // Toggle password visibility
    document.querySelectorAll('.toggle-password-visibility').forEach(button => {
        button.addEventListener('click', function() {
            const targetId = this.getAttribute('data-target');
            const targetInput = document.getElementById(targetId);
            const eyeOpen = this.querySelector('.eye-open');
            const eyeClosed = this.querySelector('.eye-closed');
            
            if (targetInput.type === 'password') {
                targetInput.type = 'text';
                eyeOpen.classList.add('hidden');
                eyeClosed.classList.remove('hidden');
            } else {
                targetInput.type = 'password';
                eyeOpen.classList.remove('hidden');
                eyeClosed.classList.add('hidden');
            }
        });
    });
    
    // Open password reset modal
    document.querySelectorAll('.user-password-reset').forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            
            const userId = this.getAttribute('data-user-id');
            document.getElementById('resetUserId').value = userId;
            passwordResetForm.reset();
            passwordResetErrors.classList.add('hidden');
            passwordResetModal.classList.remove('hidden');
            
            // Hide dropdown
            this.closest('.action-dropdown-menu').classList.add('hidden');
        });
    });
    
    // Cancel password reset
    cancelPasswordReset.addEventListener('click', function() {
        passwordResetModal.classList.add('hidden');
    });
    
    // Confirm password reset
    confirmPasswordReset.addEventListener('click', function() {
        const userId = document.getElementById('resetUserId').value;
        const formData = new FormData(passwordResetForm);
        
        // Make AJAX call to reset password
        fetch(`/partner/settings/users/${userId}/reset-password`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({
                password: formData.get('password'),
                password_confirmation: formData.get('password_confirmation')
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                passwordResetModal.classList.add('hidden');
                alert('Password reset successfully.');
            } else if (data.errors) {
                // Display validation errors
                let errorMessages = '';
                for (const field in data.errors) {
                    errorMessages += data.errors[field].join(', ') + '\n';
                }
                passwordResetErrors.querySelector('div').textContent = errorMessages;
                passwordResetErrors.classList.remove('hidden');
            } else {
                passwordResetErrors.querySelector('div').textContent = data.message || 'Failed to reset password';
                passwordResetErrors.classList.remove('hidden');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            passwordResetErrors.querySelector('div').textContent = 'An error occurred while resetting password';
            passwordResetErrors.classList.remove('hidden');
        });
    });
    
    // Handle user delete
    document.querySelectorAll('.user-delete').forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            
            const userId = this.getAttribute('data-user-id');
            const userName = this.getAttribute('data-user-name');
            
            if (confirm(`Are you sure you want to delete user ${userName}? This action cannot be undone.`)) {
                // Make AJAX call to delete user
                fetch(`/partner/settings/users/${userId}`, {
                    method: 'DELETE',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({
                        _method: 'DELETE'
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Remove the user row from the DOM
                        alert('User deleted successfully.');
                        location.reload();
                    } else {
                        alert('Failed to delete user: ' + (data.message || 'Unknown error'));
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('An error occurred while deleting user');
                });
            }
            
            // Hide dropdown
            this.closest('.action-dropdown-menu').classList.add('hidden');
        });
    });
});
</script>
@endsection