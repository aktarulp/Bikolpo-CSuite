@extends('layouts.partner-layout')

@section('title', 'BikolpoLive|Partner Settings')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-50 via-blue-50/30 to-gray-50 pb-8">
    <!-- Modern Page Header with Gradient -->
    <div class="sticky top-0 z-10 bg-white/80 backdrop-blur-md border-b border-gray-200/50 shadow-sm mb-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 py-4 sm:py-5">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div class="flex items-start space-x-4">
                    <div class="flex-shrink-0 w-12 h-12 sm:w-14 sm:h-14 bg-gradient-to-br from-blue-500 to-blue-600 rounded-2xl flex items-center justify-center shadow-lg shadow-blue-500/30">
                        <svg class="w-6 h-6 sm:w-7 sm:h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c-.94 1.543.826 3.31 2.37 2.37.996.608 2.296.07 2.572-1.065z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                    </div>
                    <div class="flex-1">
                        <h1 class="text-xl sm:text-2xl font-bold text-gray-900 tracking-tight">
                        Partner Settings
                    </h1>
                        <p class="text-sm text-gray-600 mt-1">
                            Manage your organization, users, and system configuration
                    </p>
                </div>
                </div>
                <div class="flex flex-wrap gap-2">
                    <a href="{{ route('partner.settings.backup-restore') }}" class="group inline-flex items-center px-4 py-2.5 bg-gradient-to-r from-emerald-500 to-green-600 text-white text-sm font-semibold rounded-xl hover:from-emerald-600 hover:to-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500 shadow-lg hover:shadow-xl transition-all duration-200 active:scale-[0.98]">
                        <svg class="w-4 h-4 mr-2 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3-3m0 0l-3 3m3-3v12"></path>
                        </svg>
                        Backup & Restore
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 space-y-6">

        <!-- Modern Stats Cards -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-5">
            <!-- Total Users Card -->
            <div class="group relative bg-white rounded-2xl shadow-sm hover:shadow-xl border border-gray-100 overflow-hidden transition-all duration-300 hover:-translate-y-1">
                <div class="absolute top-0 right-0 w-20 h-20 bg-gradient-to-br from-blue-500/10 via-blue-400/5 to-transparent rounded-bl-full"></div>
                <div class="relative p-3 sm:p-4">
                    <div class="flex items-start justify-between mb-2">
                        <div class="flex-shrink-0 w-10 h-10 sm:w-11 sm:h-11 rounded-xl bg-gradient-to-br from-blue-500 to-blue-600 flex items-center justify-center shadow-lg shadow-blue-500/30 group-hover:scale-110 transition-transform duration-300">
                            <svg class="w-5 h-5 sm:w-6 sm:h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                    </svg>
                </div>
                        <span class="px-2 py-0.5 text-xs font-semibold text-blue-700 bg-blue-50 rounded-lg">Total</span>
                    </div>
                    <div>
                        <p class="text-xs font-medium text-gray-500 mb-1">Total Users</p>
                        <p class="text-2xl sm:text-3xl font-bold text-gray-900">{{ $stats['total_users'] ?? 0 }}</p>
                </div>
            </div>
        </div>
        
            <!-- Active Users Card -->
            <div class="group relative bg-white rounded-2xl shadow-sm hover:shadow-xl border border-gray-100 overflow-hidden transition-all duration-300 hover:-translate-y-1">
                <div class="absolute top-0 right-0 w-20 h-20 bg-gradient-to-br from-emerald-500/10 via-emerald-400/5 to-transparent rounded-bl-full"></div>
                <div class="relative p-3 sm:p-4">
                    <div class="flex items-start justify-between mb-2">
                        <div class="flex-shrink-0 w-10 h-10 sm:w-11 sm:h-11 rounded-xl bg-gradient-to-br from-emerald-500 to-green-600 flex items-center justify-center shadow-lg shadow-emerald-500/30 group-hover:scale-110 transition-transform duration-300">
                            <svg class="w-5 h-5 sm:w-6 sm:h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                        <span class="px-2 py-0.5 text-xs font-semibold text-emerald-700 bg-emerald-50 rounded-lg">Active</span>
                    </div>
                    <div>
                        <p class="text-xs font-medium text-gray-500 mb-1">Active Users</p>
                        <p class="text-2xl sm:text-3xl font-bold text-gray-900">{{ $stats['active_users'] ?? 0 }}</p>
                </div>
            </div>
        </div>
        
            <!-- Pending Users Card -->
            <div class="group relative bg-white rounded-2xl shadow-sm hover:shadow-xl border border-gray-100 overflow-hidden transition-all duration-300 hover:-translate-y-1">
                <div class="absolute top-0 right-0 w-20 h-20 bg-gradient-to-br from-amber-500/10 via-amber-400/5 to-transparent rounded-bl-full"></div>
                <div class="relative p-3 sm:p-4">
                    <div class="flex items-start justify-between mb-2">
                        <div class="flex-shrink-0 w-10 h-10 sm:w-11 sm:h-11 rounded-xl bg-gradient-to-br from-amber-500 to-orange-600 flex items-center justify-center shadow-lg shadow-amber-500/30 group-hover:scale-110 transition-transform duration-300">
                            <svg class="w-5 h-5 sm:w-6 sm:h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                        <span class="px-2 py-0.5 text-xs font-semibold text-amber-700 bg-amber-50 rounded-lg">Pending</span>
                    </div>
                    <div>
                        <p class="text-xs font-medium text-gray-500 mb-1">Pending Users</p>
                        <p class="text-2xl sm:text-3xl font-bold text-gray-900">{{ $stats['pending_users'] ?? 0 }}</p>
                </div>
            </div>
        </div>
        
            <!-- Suspended Users Card -->
            <div class="group relative bg-white rounded-2xl shadow-sm hover:shadow-xl border border-gray-100 overflow-hidden transition-all duration-300 hover:-translate-y-1">
                <div class="absolute top-0 right-0 w-20 h-20 bg-gradient-to-br from-red-500/10 via-red-400/5 to-transparent rounded-bl-full"></div>
                <div class="relative p-3 sm:p-4">
                    <div class="flex items-start justify-between mb-2">
                        <div class="flex-shrink-0 w-10 h-10 sm:w-11 sm:h-11 rounded-xl bg-gradient-to-br from-red-500 to-rose-600 flex items-center justify-center shadow-lg shadow-red-500/30 group-hover:scale-110 transition-transform duration-300">
                            <svg class="w-5 h-5 sm:w-6 sm:h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 15.636 5.636m12.728 12.728L5.636 5.636"></path>
                    </svg>
                </div>
                        <span class="px-2 py-0.5 text-xs font-semibold text-red-700 bg-red-50 rounded-lg">Blocked</span>
                    </div>
                    <div>
                        <p class="text-xs font-medium text-gray-500 mb-1">Suspended</p>
                        <p class="text-2xl sm:text-3xl font-bold text-gray-900">{{ $stats['suspended_users'] ?? 0 }}</p>
                </div>
            </div>
        </div>
    </div>

        <!-- Modern User Management Section -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <!-- Gradient Header -->
            <div class="relative bg-gradient-to-r from-blue-500 to-blue-600 px-5 sm:px-6 py-5 sm:py-6">
                <div class="absolute top-0 right-0 w-48 h-48 bg-white/5 rounded-full -mr-24 -mt-24"></div>
                <div class="absolute bottom-0 left-0 w-32 h-32 bg-white/5 rounded-full -ml-16 -mb-16"></div>
                <div class="relative flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                    <div class="flex items-center space-x-3">
                        <div class="flex-shrink-0 w-12 h-12 bg-white/20 backdrop-blur-sm rounded-xl flex items-center justify-center">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                            </svg>
    </div>
                <div>
                            <h3 class="text-lg sm:text-xl font-bold text-white">User Management</h3>
                            <p class="text-sm text-blue-100 mt-0.5">Manage accounts, permissions, and access control</p>
                        </div>
                </div>
                <div class="flex flex-wrap gap-2">
                    <a href="{{ route('partner.settings.users.create-teacher') }}" 
                       class="group inline-flex items-center px-4 py-2.5 bg-white text-blue-600 text-sm font-semibold rounded-xl hover:bg-blue-50 focus:outline-none focus:ring-2 focus:ring-white/50 shadow-lg transition-all duration-200 active:scale-[0.98]">
                        <svg class="w-4 h-4 mr-2 group-hover:rotate-90 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                        </svg>
                        Teacher Login
                    </a>
                    <a href="{{ route('partner.settings.users.create') }}" 
                       class="group inline-flex items-center px-4 py-2.5 bg-white text-blue-600 text-sm font-semibold rounded-xl hover:bg-blue-50 focus:outline-none focus:ring-2 focus:ring-white/50 shadow-lg transition-all duration-200 active:scale-[0.98]">
                        <svg class="w-4 h-4 mr-2 group-hover:rotate-90 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                        </svg>
                        Student Login
                    </a>
                </div>
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
                
                <!-- Modern Desktop Table -->
                <div class="hidden lg:block overflow-hidden">
                    <div class="overflow-x-auto">
                        <table class="min-w-full">
                            <thead>
                                <tr class="bg-gradient-to-r from-gray-50 to-blue-50/20">
                                    <th class="px-5 py-4 text-left">
                                        <div class="flex items-center space-x-2">
                                            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                            </svg>
                                            <span class="text-xs font-bold text-gray-700 uppercase tracking-wider">Name</span>
                                        </div>
                                    </th>
                                    <th class="px-5 py-4 text-left">
                                        <div class="flex items-center space-x-2">
                                            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"></path>
                                            </svg>
                                            <span class="text-xs font-bold text-gray-700 uppercase tracking-wider">Login ID</span>
                                        </div>
                                    </th>
                                    <th class="px-5 py-4 text-left">
                                        <div class="flex items-center space-x-2">
                                            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                            <span class="text-xs font-bold text-gray-700 uppercase tracking-wider">Status</span>
                                        </div>
                                    </th>
                                    <th class="px-5 py-4 text-left">
                                        <div class="flex items-center space-x-2">
                                            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"></path>
                                            </svg>
                                            <span class="text-xs font-bold text-gray-700 uppercase tracking-wider">Role</span>
                                        </div>
                                    </th>
                                    <th class="px-5 py-4 text-center">
                                        <div class="flex items-center justify-center space-x-2">
                                            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z"></path>
                                            </svg>
                                            <span class="text-xs font-bold text-gray-700 uppercase tracking-wider">Actions</span>
                                        </div>
                                    </th>
                            </tr>
                        </thead>
                            <tbody class="divide-y divide-gray-100">
                            @foreach($sortedRoles as $roleData)
                                <!-- Modern Role Section Header -->
                                <tr class="bg-gradient-to-r from-gray-50 via-blue-50/20 to-white border-l-4 border-l-blue-500">
                                    <td colspan="5" class="px-5 py-3">
                                        <div class="flex items-center space-x-3">
                                            <div class="min-w-[2.5rem] h-10 px-3 rounded-full bg-gradient-to-br from-blue-500 to-blue-600 flex items-center justify-center shadow-lg">
                                                <span class="text-sm font-bold text-white">{{ $roleData['users']->count() }}</span>
                                            </div>
                                            <div class="flex items-center space-x-2 flex-1">
                                                <h4 class="text-sm font-bold text-gray-800">{{ $roleData['name'] }}</h4>
                                                <span class="text-xs text-gray-400">•</span>
                                                <span class="text-xs text-gray-600">{{ $roleData['users']->count() }} {{ Str::plural('user', $roleData['users']->count()) }}</span>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                
                                <!-- Users in this role -->
                                @foreach($roleData['users'] as $user)
                                    <tr class="group hover:bg-gradient-to-r hover:from-blue-50/40 hover:to-transparent transition-all duration-200 border-l-4 border-l-transparent hover:border-l-blue-400">
                                        <td class="px-5 py-4">
                                            <div class="flex items-center space-x-3">
                                                <div class="flex-shrink-0 w-10 h-10 rounded-xl bg-gradient-to-br from-gray-100 to-gray-200 group-hover:from-blue-100 group-hover:to-blue-200 flex items-center justify-center text-gray-600 group-hover:text-blue-700 font-bold text-sm transition-all duration-200 shadow-sm">
                                                    {{ strtoupper(substr($user->name, 0, 1)) }}
                                                </div>
                                                <div class="flex-1 min-w-0">
                                                    <div class="flex items-center space-x-2">
                                                        <p class="text-sm font-semibold text-gray-900 truncate group-hover:text-blue-700 transition-colors">
                                                            {{ $user->name }}
                                                        </p>
                                                        @if($user->id == auth()->id())
                                                            <span class="inline-flex items-center px-2 py-0.5 text-xs font-bold bg-gradient-to-r from-blue-500 to-blue-600 text-white rounded-md shadow-sm">
                                                                You
                                                            </span>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-5 py-4">
                                            <div class="flex items-center space-x-2">
                                                <svg class="w-4 h-4 text-gray-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1721 9z"></path>
                                                </svg>
                                                @php
                                                    $roleName = $user->role->name ?? 'user';
                                                    // Roles that use email for login (check if role contains 'partner', 'admin', or 'developer')
                                                    $useEmail = str_contains(strtolower($roleName), 'partner') || 
                                                                str_contains(strtolower($roleName), 'admin') || 
                                                                str_contains(strtolower($roleName), 'developer');
                                                    
                                                    if ($useEmail) {
                                                        $loginId = $user->email ?? ($user->phone ?? 'N/A');
                                                    } else {
                                                        $loginId = $user->phone ?? ($user->email ?? 'N/A');
                                                    }
                                                @endphp
                                                <span class="text-sm font-semibold text-gray-900 truncate max-w-[150px] group-hover:text-blue-600 transition-colors" title="{{ $loginId }}">{{ $loginId }}</span>
                                            </div>
                                        </td>
                                        <td class="px-5 py-4">
                                            <span class="inline-flex items-center px-3 py-1 text-xs font-semibold rounded-xl shadow-sm {{ $user->flag == 'active' ? 'bg-gradient-to-r from-emerald-100 to-green-100 text-emerald-700 border border-emerald-200/50' : ($user->flag == 'inactive' ? 'bg-gradient-to-r from-gray-100 to-gray-200 text-gray-700 border border-gray-300/50' : 'bg-gradient-to-r from-red-100 to-rose-100 text-red-700 border border-red-200/50') }}">
                                                <span class="w-1.5 h-1.5 rounded-full mr-2 {{ $user->flag == 'active' ? 'bg-emerald-500 animate-pulse' : ($user->flag == 'inactive' ? 'bg-gray-500' : 'bg-red-500') }}"></span>
                                                {{ ucfirst($user->flag) }}
                                            </span>
                                        </td>
                                        <td class="px-5 py-4">
                                            <span class="inline-flex items-center px-3 py-1.5 text-xs font-bold rounded-xl bg-gradient-to-r from-blue-100 to-blue-200 text-blue-700 border border-blue-300/50 shadow-sm">
                                                <svg class="w-3 h-3 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"></path>
                                                </svg>
                                                {{ $user->getRoleDisplayName() }}
                                            </span>
                                        </td>
                                        <td class="px-5 py-4 text-center">
                                            @if($user->id == auth()->id())
                                                <!-- Current User - Only Reset Password with modern styling -->
                                                <button type="button" 
                                                        class="user-password-reset group inline-flex items-center px-3 py-2 text-xs font-semibold text-blue-600 bg-blue-50 hover:bg-blue-100 rounded-xl border border-blue-200/50 hover:border-blue-300 shadow-sm hover:shadow transition-all duration-200 active:scale-95" 
                                                        data-user-id="{{ $user->id }}">
                                                    <svg class="w-4 h-4 mr-1.5 group-hover:rotate-12 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"></path>
                                                    </svg>
                                                    Reset Password
                                                </button>
                                            @else
                                                <!-- Other Users - Modern Full Action Menu -->
                                            <div class="relative inline-block text-left">
                                                <button type="button" 
                                                        class="group inline-flex items-center justify-center w-9 h-9 text-gray-600 hover:text-blue-600 bg-gray-100 hover:bg-blue-50 rounded-xl border border-gray-200 hover:border-blue-300 shadow-sm hover:shadow transition-all duration-200 active:scale-95 action-dropdown-btn"
                                                        data-user-id="{{ $user->id }}">
                                                    <svg class="w-5 h-5 group-hover:rotate-90 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c-.94 1.543.826 3.31 2.37 2.37.996.608 2.296.07 2.572-1.065z"></path>
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                    </svg>
                                                </button>
                                                
                                                <!-- Modern Dropdown menu -->
                                                <div class="hidden origin-top-right absolute right-0 mt-2 w-48 rounded-2xl shadow-2xl bg-white border border-gray-200/50 focus:outline-none action-dropdown-menu z-20 animate-fadeIn" 
                                                     data-user-id="{{ $user->id }}">
                                                    <div class="py-2">
                                                        <a href="#" 
                                                           class="user-status-toggle group flex items-center px-4 py-2.5 text-sm font-medium text-gray-700 hover:bg-blue-50 hover:text-blue-700 transition-all duration-150" 
                                                           data-user-id="{{ $user->id }}" 
                                                           data-current-status="{{ $user->flag }}">
                                                            <svg class="w-4 h-4 mr-3 text-gray-400 group-hover:text-blue-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                @if($user->flag == 'active')
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"></path>
                                                                @else
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                                @endif
                                                            </svg>
                                                            {{ $user->flag == 'active' ? 'Mark Inactive' : 'Mark Active' }}
                                                        </a>
                                                        <a href="#" 
                                                           class="user-password-reset group flex items-center px-4 py-2.5 text-sm font-medium text-gray-700 hover:bg-blue-50 hover:text-blue-700 transition-all duration-150" 
                                                           data-user-id="{{ $user->id }}">
                                                            <svg class="w-4 h-4 mr-3 text-gray-400 group-hover:text-blue-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"></path>
                                                            </svg>
                                                            Reset Password
                                                        </a>
                                                        <div class="border-t border-gray-100 my-1"></div>
                                                        <a href="#" 
                                                           class="user-delete group flex items-center px-4 py-2.5 text-sm font-medium text-red-600 hover:bg-red-50 transition-all duration-150" 
                                                           data-user-id="{{ $user->id }}"
                                                           data-user-name="{{ $user->name }}">
                                                            <svg class="w-4 h-4 mr-3 text-red-400 group-hover:text-red-600 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                            </svg>
                                                            Delete User
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            @endforeach
                        </tbody>
                    </table>
                </div>
                
                <!-- Modern Mobile Cards - Mobile First Design -->
                <div class="lg:hidden space-y-4 p-4">
                    @foreach($sortedRoles as $roleData)
                        <!-- Modern Role Section Header -->
                        <div class="relative bg-gradient-to-r from-blue-500 to-blue-600 rounded-2xl p-4 shadow-lg overflow-hidden">
                            <div class="absolute top-0 right-0 w-24 h-24 bg-white/10 rounded-full -mr-12 -mt-12"></div>
                            <div class="absolute bottom-0 left-0 w-16 h-16 bg-white/10 rounded-full -ml-8 -mb-8"></div>
                            <div class="relative flex items-center justify-between">
                                <div class="flex items-center space-x-3">
                                    <div class="min-w-[2.75rem] h-11 px-3 rounded-full bg-white/20 backdrop-blur-sm flex items-center justify-center shadow-lg">
                                        <span class="text-base font-bold text-white">{{ $roleData['users']->count() }}</span>
                                    </div>
                                    <div>
                                        <h4 class="text-sm font-bold text-white">{{ $roleData['name'] }}</h4>
                                        <p class="text-xs text-blue-100">{{ $roleData['users']->count() }} {{ Str::plural('user', $roleData['users']->count()) }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Modern User Cards for Mobile -->
                        @foreach($roleData['users'] as $user)
                            <div class="group bg-white rounded-2xl border border-gray-200 shadow-sm hover:shadow-xl p-4 transition-all duration-300 hover:-translate-y-1 active:scale-[0.98]">
                                <!-- User Header -->
                                <div class="flex items-start justify-between mb-3">
                                    <div class="flex items-center space-x-3 flex-1 min-w-0">
                                        <div class="flex-shrink-0 w-12 h-12 rounded-xl bg-gradient-to-br from-blue-100 to-blue-200 flex items-center justify-center shadow-md">
                                            <span class="text-base font-bold text-blue-700">{{ strtoupper(substr($user->name, 0, 1)) }}</span>
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <div class="flex items-center space-x-2 mb-1">
                                                <h4 class="text-sm font-bold text-gray-900 truncate">
                                                    {{ $user->name }}
                                                </h4>
                                                @if($user->id == auth()->id())
                                                    <span class="inline-flex items-center px-2 py-0.5 text-xs font-bold bg-gradient-to-r from-blue-500 to-blue-600 text-white rounded-md shadow-sm">
                                                        You
                                                    </span>
                                                @endif
                                        </div>
                                    </div>
                                    </div>
                                    <span class="inline-flex items-center px-2.5 py-1 text-xs font-semibold rounded-lg shadow-sm ml-2 {{ $user->flag == 'active' ? 'bg-gradient-to-r from-emerald-100 to-green-100 text-emerald-700 border border-emerald-200/50' : ($user->flag == 'inactive' ? 'bg-gradient-to-r from-gray-100 to-gray-200 text-gray-700 border border-gray-300/50' : 'bg-gradient-to-r from-red-100 to-rose-100 text-red-700 border border-red-200/50') }}">
                                        <span class="w-1.5 h-1.5 rounded-full mr-1.5 {{ $user->flag == 'active' ? 'bg-emerald-500 animate-pulse' : ($user->flag == 'inactive' ? 'bg-gray-500' : 'bg-red-500') }}"></span>
                                        {{ ucfirst($user->flag) }}
                                    </span>
                                </div>
                                
                                <!-- User Info Grid -->
                                <div class="grid grid-cols-2 gap-3 mb-3 p-3 bg-gradient-to-br from-gray-50 to-blue-50/30 rounded-xl">
                                    <div class="space-y-1">
                                        <div class="flex items-center space-x-1.5">
                                            <svg class="w-3.5 h-3.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"></path>
                                            </svg>
                                            <p class="text-xs font-semibold text-gray-500">Login ID</p>
                                    </div>
                                        @php
                                            $roleName = $user->role->name ?? 'user';
                                            // Roles that use email for login (check if role contains 'partner', 'admin', or 'developer')
                                            $useEmail = str_contains(strtolower($roleName), 'partner') || 
                                                        str_contains(strtolower($roleName), 'admin') || 
                                                        str_contains(strtolower($roleName), 'developer');
                                            
                                            if ($useEmail) {
                                                $loginId = $user->email ?? ($user->phone ?? 'N/A');
                                            } else {
                                                $loginId = $user->phone ?? ($user->email ?? 'N/A');
                                            }
                                        @endphp
                                        <p class="text-sm font-bold text-gray-900 pl-5 truncate" title="{{ $loginId }}">{{ $loginId }}</p>
                                    </div>
                                    <div class="space-y-1">
                                        <div class="flex items-center space-x-1.5">
                                            <svg class="w-3.5 h-3.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"></path>
                                            </svg>
                                            <p class="text-xs font-semibold text-gray-500">Role</p>
                                        </div>
                                        <p class="text-sm font-bold text-blue-700 pl-5 truncate">
                                            {{ $user->getRoleDisplayName() }}
                                        </p>
                                    </div>
                                </div>
                                <!-- Action Button -->
                                <div class="flex items-center justify-stretch gap-2">
                                    @if($user->id == auth()->id())
                                        <!-- Current User - Full Width Reset Password Button -->
                                        <button type="button" 
                                                class="user-password-reset flex-1 inline-flex items-center justify-center px-4 py-2.5 text-sm font-semibold text-white bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 rounded-xl shadow-md hover:shadow-lg transition-all duration-200 active:scale-95" 
                                                data-user-id="{{ $user->id }}">
                                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1721 9z"></path>
                                            </svg>
                                            Reset Password
                                        </button>
                                    @else
                                        <!-- Other Users - Modern Action Menu -->
                                        <div class="relative flex-1">
                                            <button type="button" 
                                                    class="w-full group inline-flex items-center justify-center px-4 py-2.5 text-sm font-semibold text-gray-700 bg-white border-2 border-gray-200 hover:border-blue-400 rounded-xl shadow-sm hover:shadow-md transition-all duration-200 active:scale-95 action-dropdown-btn"
                                                    data-user-id="{{ $user->id }}">
                                                <svg class="w-5 h-5 mr-2 group-hover:rotate-90 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            </svg>
                                                Actions
                                        </button>
                                        
                                            <!-- Modern Dropdown menu -->
                                            <div class="hidden origin-top-right absolute right-0 mt-2 w-full min-w-[200px] rounded-2xl shadow-2xl bg-white border border-gray-200/50 focus:outline-none action-dropdown-menu z-20 animate-fadeIn" 
                                             data-user-id="{{ $user->id }}">
                                                <div class="py-2">
                                                <a href="#" 
                                                       class="user-status-toggle group flex items-center px-4 py-3 text-sm font-medium text-gray-700 hover:bg-blue-50 hover:text-blue-700 transition-all duration-150" 
                                                   data-user-id="{{ $user->id }}" 
                                                   data-current-status="{{ $user->flag }}">
                                                        <svg class="w-5 h-5 mr-3 text-gray-400 group-hover:text-blue-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            @if($user->flag == 'active')
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"></path>
                                                            @else
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                            @endif
                                                        </svg>
                                                    {{ $user->flag == 'active' ? 'Mark Inactive' : 'Mark Active' }}
                                                </a>
                                                <a href="#" 
                                                       class="user-password-reset group flex items-center px-4 py-3 text-sm font-medium text-gray-700 hover:bg-blue-50 hover:text-blue-700 transition-all duration-150" 
                                                   data-user-id="{{ $user->id }}">
                                                        <svg class="w-5 h-5 mr-3 text-gray-400 group-hover:text-blue-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"></path>
                                                        </svg>
                                                    Reset Password
                                                </a>
                                                    <div class="border-t border-gray-100 my-1"></div>
                                                <a href="#" 
                                                       class="user-delete group flex items-center px-4 py-3 text-sm font-medium text-red-600 hover:bg-red-50 transition-all duration-150" 
                                                   data-user-id="{{ $user->id }}"
                                                   data-user-name="{{ $user->name }}">
                                                        <svg class="w-5 h-5 mr-3 text-red-400 group-hover:text-red-600 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                        </svg>
                                                    Delete User
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                    @endif
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

</div> <!-- End max-w-7xl container -->
</div> <!-- End gradient background -->

<!-- Password Reset Modal - Mobile-First Professional Design -->
<div id="passwordResetModal" class="hidden fixed inset-0 z-50 overflow-y-auto" aria-labelledby="passwordResetModalLabel" aria-modal="true" role="dialog">
    <!-- Backdrop with smooth transition -->
    <div class="fixed inset-0 bg-gradient-to-br from-gray-900/80 to-slate-900/80 backdrop-blur-sm transition-opacity duration-300" aria-hidden="true"></div>

    <!-- Modal Container - Mobile First -->
    <div class="flex min-h-full items-end sm:items-center justify-center p-0 sm:p-4">
        <div class="relative w-full sm:max-w-lg transform transition-all duration-300 ease-out">
            <!-- Modal Content -->
            <div class="bg-white rounded-t-3xl sm:rounded-2xl shadow-2xl overflow-hidden">
                
                <!-- Header with gradient background -->
                <div class="relative bg-gradient-to-br from-blue-500 to-blue-600 px-5 sm:px-6 py-6 sm:py-5">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-3">
                            <div class="flex-shrink-0 w-10 h-10 sm:w-12 sm:h-12 bg-white/20 backdrop-blur-sm rounded-xl flex items-center justify-center">
                                <svg class="w-5 h-5 sm:w-6 sm:h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"></path>
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-lg sm:text-xl font-bold text-white" id="passwordResetModalLabel">
                                    Reset Password
                        </h3>
                                <p class="text-xs sm:text-sm text-blue-100 mt-0.5">Secure your account</p>
                            </div>
                        </div>
                        <button type="button" id="closePasswordResetModal" class="flex-shrink-0 w-8 h-8 rounded-lg bg-white/10 hover:bg-white/20 flex items-center justify-center transition-colors duration-200">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>
        </div>

                <!-- Form Content -->
                <div class="px-5 sm:px-6 py-6 sm:py-5 max-h-[60vh] sm:max-h-[70vh] overflow-y-auto">
                    <form id="passwordResetForm" class="space-y-5">
                                <input type="hidden" id="resetUserId" name="user_id">
                        <input type="hidden" id="isCurrentUser" name="is_current_user" value="0">
                        
                        <!-- Current Password Field (shown only for current user) -->
                        <div class="hidden animate-fadeIn" id="currentPasswordField">
                            <label for="current_password" class="block text-sm font-semibold text-gray-700 mb-2">
                                Current Password
                                <span class="text-red-500 ml-0.5">*</span>
                            </label>
                            <div class="relative group">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-gray-400 group-focus-within:text-blue-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                                    </svg>
                                </div>
                                <input 
                                    type="password" 
                                    name="current_password" 
                                    id="current_password" 
                                    class="block w-full pl-10 pr-12 py-3 sm:py-2.5 border border-gray-300 rounded-xl text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 placeholder-gray-400"
                                    placeholder="Enter your current password"
                                >
                                <button type="button" class="absolute inset-y-0 right-0 pr-3 flex items-center toggle-password-visibility" data-target="current_password">
                                    <svg class="h-5 w-5 text-gray-400 hover:text-gray-600 transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path class="eye-open" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                    <path class="eye-open" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                    <path class="eye-closed hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.878 9.878L3 3m6.878 6.878L21 21" />
                                                </svg>
                                            </button>
                                        </div>
                            <p class="mt-1.5 text-xs text-gray-500 flex items-start">
                                <svg class="w-4 h-4 mr-1 mt-0.5 flex-shrink-0 text-blue-500" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                                </svg>
                                <span>For security, verify your identity with your current password</span>
                            </p>
                                    </div>
                        
                        <!-- New Password Field -->
                        <div>
                            <label for="password" class="block text-sm font-semibold text-gray-700 mb-2">
                                New Password
                                <span class="text-red-500 ml-0.5">*</span>
                            </label>
                            <div class="relative group">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-gray-400 group-focus-within:text-blue-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"></path>
                                    </svg>
                                </div>
                                <input 
                                    type="password" 
                                    name="password" 
                                    id="password" 
                                    class="block w-full pl-10 pr-12 py-3 sm:py-2.5 border border-gray-300 rounded-xl text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 placeholder-gray-400"
                                    placeholder="Enter new password (min. 8 characters)"
                                    required
                                >
                                <button type="button" class="absolute inset-y-0 right-0 pr-3 flex items-center toggle-password-visibility" data-target="password">
                                    <svg class="h-5 w-5 text-gray-400 hover:text-gray-600 transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path class="eye-open" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                    <path class="eye-open" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                    <path class="eye-closed hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.878 9.878L3 3m6.878 6.878L21 21" />
                                                </svg>
                                            </button>
                                        </div>
                            <!-- Password Strength Indicator -->
                            <div class="mt-2 space-y-1">
                                <div class="flex gap-1">
                                    <div id="strength-bar-1" class="h-1 flex-1 bg-gray-200 rounded-full transition-all duration-300"></div>
                                    <div id="strength-bar-2" class="h-1 flex-1 bg-gray-200 rounded-full transition-all duration-300"></div>
                                    <div id="strength-bar-3" class="h-1 flex-1 bg-gray-200 rounded-full transition-all duration-300"></div>
                                    <div id="strength-bar-4" class="h-1 flex-1 bg-gray-200 rounded-full transition-all duration-300"></div>
                                    </div>
                                <p id="strength-text" class="text-xs text-gray-500"></p>
                                </div>
                                </div>
                        
                        <!-- Confirm Password Field -->
                        <div>
                            <label for="password_confirmation" class="block text-sm font-semibold text-gray-700 mb-2">
                                Confirm New Password
                                <span class="text-red-500 ml-0.5">*</span>
                            </label>
                            <div class="relative group">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-gray-400 group-focus-within:text-blue-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                        </div>
                                <input 
                                    type="password" 
                                    name="password_confirmation" 
                                    id="password_confirmation" 
                                    class="block w-full pl-10 pr-12 py-3 sm:py-2.5 border border-gray-300 rounded-xl text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 placeholder-gray-400"
                                    placeholder="Re-enter your new password"
                                    required
                                >
                                <button type="button" class="absolute inset-y-0 right-0 pr-3 flex items-center toggle-password-visibility" data-target="password_confirmation">
                                    <svg class="h-5 w-5 text-gray-400 hover:text-gray-600 transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path class="eye-open" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                    <path class="eye-open" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                    <path class="eye-closed hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.878 9.878L3 3m6.878 6.878L21 21" />
                                                </svg>
                                            </button>
                    </div>
                </div>
                        
                        <!-- Error Display -->
                        <div id="passwordResetErrors" class="hidden">
                            <div class="bg-red-50 border-l-4 border-red-500 rounded-lg p-4">
                                <div class="flex items-start">
                                    <svg class="w-5 h-5 text-red-500 mr-2 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                                    </svg>
                                    <div class="flex-1">
                                        <p class="text-sm font-medium text-red-800">Error</p>
                                        <p class="text-sm text-red-700 mt-1"></p>
            </div>
                                </div>
                                </div>
                        </div>

                        <!-- Password Requirements -->
                        <div class="bg-blue-50 rounded-lg p-3 sm:p-4">
                            <p class="text-xs font-semibold text-blue-900 mb-2 flex items-center">
                                <svg class="w-4 h-4 mr-1.5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                                </svg>
                                Password Requirements
                            </p>
                            <ul class="space-y-1 text-xs text-blue-800">
                                <li class="flex items-start">
                                    <svg class="w-4 h-4 mr-1.5 mt-0.5 flex-shrink-0 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                    </svg>
                                    <span>Minimum 8 characters long</span>
                                </li>
                                <li class="flex items-start">
                                    <svg class="w-4 h-4 mr-1.5 mt-0.5 flex-shrink-0 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                    </svg>
                                    <span>Both passwords must match</span>
                                </li>
                            </ul>
                    </div>
                    </form>
                </div>

                <!-- Footer Actions - Sticky on mobile -->
                <div class="sticky bottom-0 bg-gray-50 px-5 sm:px-6 py-4 sm:py-3 border-t border-gray-200 flex flex-col-reverse sm:flex-row gap-2 sm:gap-3">
                    <button 
                        type="button" 
                        id="cancelPasswordReset" 
                        class="w-full sm:w-auto px-5 py-3 sm:py-2.5 text-sm font-semibold text-gray-700 bg-white border border-gray-300 rounded-xl hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-400 transition-all duration-200 active:scale-[0.98]"
                    >
                    Cancel
                    </button>
                    <button 
                        type="button" 
                        id="confirmPasswordReset" 
                        class="w-full sm:w-auto px-5 py-3 sm:py-2.5 text-sm font-bold text-white bg-gradient-to-r from-blue-500 to-blue-600 rounded-xl hover:from-blue-600 hover:to-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 shadow-lg hover:shadow-xl transition-all duration-200 active:scale-[0.98] flex items-center justify-center"
                    >
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    Reset Password
                </button>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
@keyframes fadeIn {
    from {
        opacity: 0;
        transform: translateY(-10px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.animate-fadeIn {
    animation: fadeIn 0.3s ease-out;
}

/* Smooth transitions for modal */
#passwordResetModal:not(.hidden) {
    animation: fadeIn 0.2s ease-out;
}

/* Custom scrollbar for modal content */
#passwordResetModal .overflow-y-auto::-webkit-scrollbar {
    width: 6px;
}

#passwordResetModal .overflow-y-auto::-webkit-scrollbar-track {
    background: #f3f4f6;
    border-radius: 10px;
}

#passwordResetModal .overflow-y-auto::-webkit-scrollbar-thumb {
    background: #cbd5e1;
    border-radius: 10px;
}

#passwordResetModal .overflow-y-auto::-webkit-scrollbar-thumb:hover {
    background: #94a3b8;
}

/* Mobile touch improvements */
@media (max-width: 640px) {
    #passwordResetModal input {
        font-size: 16px; /* Prevents zoom on iOS */
    }
}
</style>

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
            const currentUserId = '{{ auth()->id() }}';
            const isCurrentUser = (userId === currentUserId);
            
            document.getElementById('resetUserId').value = userId;
            document.getElementById('isCurrentUser').value = isCurrentUser ? '1' : '0';
            
            passwordResetForm.reset();
            passwordResetErrors.classList.add('hidden');
            
            // Show/hide current password field based on whether it's current user
            const currentPasswordField = document.getElementById('currentPasswordField');
            const currentPasswordInput = document.getElementById('current_password');
            
            if (isCurrentUser) {
                currentPasswordField.classList.remove('hidden');
                currentPasswordInput.setAttribute('required', 'required');
                document.getElementById('passwordResetModalLabel').textContent = 'Reset Your Password';
            } else {
                currentPasswordField.classList.add('hidden');
                currentPasswordInput.removeAttribute('required');
                document.getElementById('passwordResetModalLabel').textContent = 'Reset User Password';
            }
            
            passwordResetModal.classList.remove('hidden');
            
            // Hide dropdown if exists
            const dropdown = this.closest('.action-dropdown-menu');
            if (dropdown) {
                dropdown.classList.add('hidden');
            }
        });
    });
    
    // Cancel password reset
    cancelPasswordReset.addEventListener('click', function() {
        passwordResetModal.classList.add('hidden');
    });
    
    // Close button (X) functionality
    document.getElementById('closePasswordResetModal').addEventListener('click', function() {
        passwordResetModal.classList.add('hidden');
    });
    
    // Password strength indicator
    const passwordInput = document.getElementById('password');
    const strengthBars = [
        document.getElementById('strength-bar-1'),
        document.getElementById('strength-bar-2'),
        document.getElementById('strength-bar-3'),
        document.getElementById('strength-bar-4')
    ];
    const strengthText = document.getElementById('strength-text');
    
    passwordInput.addEventListener('input', function() {
        const password = this.value;
        let strength = 0;
        
        // Reset bars
        strengthBars.forEach(bar => {
            bar.className = 'h-1 flex-1 bg-gray-200 rounded-full transition-all duration-300';
        });
        
        if (password.length === 0) {
            strengthText.textContent = '';
            return;
        }
        
        // Calculate strength
        if (password.length >= 8) strength++;
        if (password.length >= 12) strength++;
        if (/[a-z]/.test(password) && /[A-Z]/.test(password)) strength++;
        if (/[0-9]/.test(password)) strength++;
        if (/[^a-zA-Z0-9]/.test(password)) strength++;
        
        // Normalize to 4 levels
        const level = Math.min(Math.floor(strength / 1.5), 4);
        
        // Apply colors and text
        const strengthConfig = [
            { color: 'bg-red-500', text: 'Weak password', textColor: 'text-red-600' },
            { color: 'bg-orange-500', text: 'Fair password', textColor: 'text-orange-600' },
            { color: 'bg-yellow-500', text: 'Good password', textColor: 'text-yellow-600' },
            { color: 'bg-green-500', text: 'Strong password', textColor: 'text-green-600' }
        ];
        
        if (level > 0) {
            for (let i = 0; i < level; i++) {
                strengthBars[i].className = `h-1 flex-1 ${strengthConfig[level - 1].color} rounded-full transition-all duration-300`;
            }
            strengthText.textContent = strengthConfig[level - 1].text;
            strengthText.className = `text-xs ${strengthConfig[level - 1].textColor} font-medium`;
        }
    });
    
    // Confirm password reset
    confirmPasswordReset.addEventListener('click', function() {
        const userId = document.getElementById('resetUserId').value;
        const formData = new FormData(passwordResetForm);
        const isCurrentUser = document.getElementById('isCurrentUser').value === '1';
        
        // Prepare request body
        const requestBody = {
            password: formData.get('password'),
            password_confirmation: formData.get('password_confirmation')
        };
        
        // Add current password if resetting own password
        if (isCurrentUser) {
            const currentPassword = formData.get('current_password');
            if (!currentPassword) {
                passwordResetErrors.querySelector('div').textContent = 'Current password is required';
                passwordResetErrors.classList.remove('hidden');
                return;
            }
            requestBody.current_password = currentPassword;
        }
        
        // Make AJAX call to reset password
        fetch(`/partner/settings/users/${userId}/reset-password`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify(requestBody)
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                passwordResetModal.classList.add('hidden');
                // Show success notification
                const successMsg = document.createElement('div');
                successMsg.className = 'fixed top-4 right-4 z-50 bg-green-500 text-white px-6 py-4 rounded-xl shadow-2xl flex items-center space-x-3 animate-fadeIn';
                successMsg.innerHTML = `
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <span class="font-semibold">Password reset successfully!</span>
                `;
                document.body.appendChild(successMsg);
                setTimeout(() => successMsg.remove(), 3000);
            } else if (data.errors) {
                // Display validation errors
                let errorMessages = '';
                for (const field in data.errors) {
                    errorMessages += data.errors[field].join(', ') + '<br>';
                }
                passwordResetErrors.querySelector('div p.text-sm.text-red-700').innerHTML = errorMessages;
                passwordResetErrors.classList.remove('hidden');
                // Scroll error into view
                passwordResetErrors.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
            } else {
                passwordResetErrors.querySelector('div p.text-sm.text-red-700').textContent = data.message || 'Failed to reset password';
                passwordResetErrors.classList.remove('hidden');
                // Scroll error into view
                passwordResetErrors.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
            }
        })
        .catch(error => {
            console.error('Error:', error);
            const errorElement = passwordResetErrors.querySelector('p.text-sm.text-red-700');
            if (errorElement) {
                errorElement.textContent = 'An error occurred while resetting password. Please try again.';
            }
            passwordResetErrors.classList.remove('hidden');
            // Scroll error into view
            passwordResetErrors.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
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