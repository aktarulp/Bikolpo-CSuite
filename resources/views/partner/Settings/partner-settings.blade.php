@extends('layouts.partner-layout')

@section('title', 'BikolpoLive|Partner Settings')

@section('content')
<div class="min-h-screen bg-gray-50/50 p-4 sm:p-6">
    <!-- Page Header -->
    <div class="mb-6">
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5 sm:p-6">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div>
                    <h1 class="text-2xl font-bold text-gray-800 mb-1">
                        Partner Settings
                    </h1>
                    <p class="text-gray-500 text-sm">
                        Manage your organization settings, users, and permissions
                    </p>
                </div>
                <div class="flex flex-wrap gap-2">
                    <a href="{{ route('partner.settings.backup-restore') }}" class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-green-500 to-emerald-600 text-white text-sm font-medium rounded-lg hover:opacity-90 focus:outline-none focus:ring-2 focus:ring-green-500/20 focus:ring-offset-1 transition-all active:scale-[0.98]">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3-3m0 0l-3 3m3-3v12"></path>
                        </svg>
                        Backup/Restore
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Stats Section -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5">
            <div class="flex items-center">
                <div class="p-3 rounded-lg bg-blue-50 text-blue-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-500">Total Users</p>
                    <p class="text-2xl font-semibold text-gray-900">{{ $stats['total_users'] ?? 0 }}</p>
                </div>
            </div>
        </div>
        
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5">
            <div class="flex items-center">
                <div class="p-3 rounded-lg bg-green-50 text-green-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-500">Active Users</p>
                    <p class="text-2xl font-semibold text-gray-900">{{ $stats['active_users'] ?? 0 }}</p>
                </div>
            </div>
        </div>
        
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5">
            <div class="flex items-center">
                <div class="p-3 rounded-lg bg-yellow-50 text-yellow-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-500">Pending Users</p>
                    <p class="text-2xl font-semibold text-gray-900">{{ $stats['pending_users'] ?? 0 }}</p>
                </div>
            </div>
        </div>
        
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5">
            <div class="flex items-center">
                <div class="p-3 rounded-lg bg-red-50 text-red-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-500">Suspended Users</p>
                    <p class="text-2xl font-semibold text-gray-900">{{ $stats['suspended_users'] ?? 0 }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- User Management Section -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 mb-6 overflow-hidden">
        <!-- Header -->
        <div class="px-5 py-4 border-b border-gray-100 bg-gray-50/50">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                <div>
                    <h3 class="text-lg font-semibold text-gray-800">User Management</h3>
                    <p class="text-sm text-gray-500 mt-0.5">Manage all user accounts and their access</p>
                </div>
                <a href="{{ route('partner.settings.users.create') }}" 
                   class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-blue-500 to-blue-600 text-white text-sm font-medium rounded-lg hover:opacity-90 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:ring-offset-1 transition-all active:scale-[0.98]">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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
                            // Try to get the role level if available
                            $roleLevel = 999; // Default level
                            if ($user->role) {
                                $roleLevel = $user->role->level ?? 999;
                            } else if ($user->role_id) {
                                // Try to get role level directly
                                $role = \App\Models\EnhancedRole::find($user->role_id);
                                if ($role) {
                                    $roleLevel = $role->level ?? 999;
                                }
                            }
                            
                            $usersByRoleArray[$roleDisplayName] = [
                                'users' => collect(),
                                'level' => $roleLevel,
                                'name' => $roleDisplayName
                            ];
                        }
                        
                        // Add user to the role group
                        $usersByRoleArray[$roleDisplayName]['users']->push($user);
                    }
                    
                    // Convert to collection and sort by level
                    $sortedRoles = collect($usersByRoleArray)->sortBy('level');
                @endphp
                
                <!-- Desktop Table -->
                <div class="hidden sm:block overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-5 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                                <th class="px-5 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Phone</th>
                                <th class="px-5 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                                <th class="px-5 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                <th class="px-5 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Role</th>
                                <th class="px-5 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-100">
                            @foreach($sortedRoles as $roleData)
                                <!-- Role Header -->
                                <tr class="bg-gray-50">
                                    <td colspan="6" class="px-5 py-2">
                                        <div class="flex items-center">
                                            <h4 class="text-sm font-semibold text-gray-700">{{ $roleData['name'] }}</h4>
                                            <span class="ml-2 px-2 py-0.5 text-xs font-medium rounded-full bg-gray-200 text-gray-700">
                                                {{ $roleData['users']->count() }} users
                                            </span>
                                            <span class="ml-2 px-2 py-0.5 text-xs font-medium rounded-full {{ $roleData['level'] <= 2 ? 'bg-purple-100 text-purple-800' : ($roleData['level'] <= 4 ? 'bg-indigo-100 text-indigo-800' : 'bg-gray-100 text-gray-800') }}">
                                                Level {{ $roleData['level'] }}
                                            </span>
                                        </div>
                                    </td>
                                </tr>
                                
                                <!-- Users in this role -->
                                @foreach($roleData['users'] as $user)
                                    <tr class="hover:bg-gray-50/50 transition-colors">
                                        <td class="px-5 py-4 whitespace-nowrap">
                                            <div class="flex items-center">
                                                <div class="flex-shrink-0 h-10 w-10 rounded-full bg-gray-100 flex items-center justify-center text-gray-500 font-medium">
                                                    {{ substr($user->name, 0, 1) }}
                                                </div>
                                                <div class="ml-4">
                                                    <div class="text-sm font-medium text-gray-900">{{ $user->name }}</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-5 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-600">{{ $user->phone ?? 'N/A' }}</div>
                                        </td>
                                        <td class="px-5 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-600">{{ $user->email }}</div>
                                        </td>
                                        <td class="px-5 py-4 whitespace-nowrap">
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $user->status == 'active' ? 'bg-green-100 text-green-800' : ($user->status == 'inactive' ? 'bg-gray-100 text-gray-800' : 'bg-red-100 text-red-800') }}">
                                                <span class="w-1.5 h-1.5 rounded-full {{ $user->status == 'active' ? 'bg-green-500' : ($user->status == 'inactive' ? 'bg-gray-500' : 'bg-red-500') }} mr-1.5"></span>
                                                {{ ucfirst($user->status) }}
                                            </span>
                                        </td>
                                        <td class="px-5 py-4 whitespace-nowrap">
                                            <span class="px-2.5 py-1 text-xs font-medium rounded-full bg-blue-50 text-blue-700">
                                                {{ $user->getRoleDisplayName() }}
                                            </span>
                                        </td>
                                        <td class="px-5 py-4 whitespace-nowrap text-sm font-medium">
                                            <a href="{{ route('partner.settings.users.show', $user) }}" 
                                               class="text-blue-600 hover:text-blue-900 p-1 rounded hover:bg-blue-50">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                </svg>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            @endforeach
                        </tbody>
                    </table>
                </div>
                
                <!-- Mobile Cards -->
                <div class="sm:hidden space-y-3 p-3">
                    @foreach($sortedRoles as $roleData)
                        <!-- Role Header -->
                        <div class="bg-gray-50 rounded-lg p-3">
                            <div class="flex items-center justify-between">
                                <h4 class="text-sm font-semibold text-gray-700">{{ $roleData['name'] }}</h4>
                                <div class="flex space-x-1">
                                    <span class="px-2 py-0.5 text-xs font-medium rounded-full bg-gray-200 text-gray-700">
                                        {{ $roleData['users']->count() }} users
                                    </span>
                                    <span class="px-2 py-0.5 text-xs font-medium rounded-full {{ $roleData['level'] <= 2 ? 'bg-purple-100 text-purple-800' : ($roleData['level'] <= 4 ? 'bg-indigo-100 text-indigo-800' : 'bg-gray-100 text-gray-800') }}">
                                        L{{ $roleData['level'] }}
                                    </span>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Users in this role -->
                        @foreach($roleData['users'] as $user)
                            <div class="bg-white rounded-xl border border-gray-100 p-4 shadow-xs hover:shadow-sm transition-shadow">
                                <div class="flex items-start justify-between">
                                    <div class="flex items-center space-x-3">
                                        <div class="flex-shrink-0 h-10 w-10 rounded-full bg-blue-50 flex items-center justify-center text-blue-600 font-medium text-sm">
                                            {{ substr($user->name, 0, 1) }}
                                        </div>
                                        <div>
                                            <h4 class="text-sm font-medium text-gray-900">{{ $user->name }}</h4>
                                            <p class="text-xs text-gray-500 mt-0.5">{{ $user->email }}</p>
                                        </div>
                                    </div>
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium {{ $user->status == 'active' ? 'bg-green-100 text-green-800' : ($user->status == 'inactive' ? 'bg-gray-100 text-gray-800' : 'bg-red-100 text-red-800') }}">
                                        {{ ucfirst($user->status) }}
                                    </span>
                                </div>
                                <div class="mt-3 grid grid-cols-2 gap-2 text-xs">
                                    <div>
                                        <p class="text-gray-500">Phone</p>
                                        <p class="text-gray-900">{{ $user->phone ?? 'N/A' }}</p>
                                    </div>
                                    <div>
                                        <p class="text-gray-500">Role</p>
                                        <p class="text-gray-900">
                                            {{ $user->getRoleDisplayName() }}
                                        </p>
                                    </div>
                                </div>
                                <div class="mt-3 flex items-center justify-between">
                                    <a href="{{ route('partner.settings.users.show', $user) }}" 
                                       class="text-blue-600 hover:text-blue-900 p-1 rounded hover:bg-blue-50">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        </svg>
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    @endforeach
                </div>
            @else
                <!-- Empty State -->
                <div class="text-center py-12">
                    <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">No users found</h3>
                    <p class="text-gray-600 mb-4">Users you create will be displayed here.</p>
                    <a href="{{ route('partner.settings.users.create') }}" 
                       class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-blue-500 to-blue-600 text-white text-sm font-medium rounded-lg hover:opacity-90 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:ring-offset-1 transition-all">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                        </svg>
                        Create User
                    </a>
                </div>
            @endif
        </div>
    </div>

</div>
@endsection