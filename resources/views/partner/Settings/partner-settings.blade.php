@extends('layouts.partner-layout')

@section('title', 'Partner Settings')

@push('styles')
<style>
    @layer utilities {
        .animate-shimmer {
            animation: shimmer 3s ease-in-out infinite;
        }
        
        .animate-float {
            animation: float 6s ease-in-out infinite;
        }
        
        .animate-float-reverse {
            animation: float 4s ease-in-out infinite reverse;
        }
        
        .animate-float-delayed {
            animation: float 5s ease-in-out infinite 1s;
        }
        
        .custom-scrollbar {
            scrollbar-width: thin;
            scrollbar-color: #cbd5e1 #f1f5f9;
        }
        
        .custom-scrollbar::-webkit-scrollbar {
            width: 6px;
        }
        
        .custom-scrollbar::-webkit-scrollbar-track {
            background: #f1f5f9;
            border-radius: 3px;
        }
        
        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 3px;
        }
        
        .custom-scrollbar::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
        }
    }
    
    @keyframes shimmer {
        0%, 100% { transform: rotate(0deg); }
        50% { transform: rotate(180deg); }
    }
    
    @keyframes float {
        0%, 100% { transform: translateY(0px) rotate(0deg); }
        50% { transform: translateY(-20px) rotate(180deg); }
    }
</style>
@endpush

@section('content')
<div class="flex-1 overflow-y-auto custom-scrollbar p-4 lg:p-8">
    <!-- Page Header -->
    <div class="mb-8">
        <div class="bg-gradient-to-br from-indigo-500 via-purple-500 to-purple-700 rounded-[40px] p-8 shadow-[0_20px_40px_rgba(0,0,0,0.1)] relative overflow-hidden">
            <!-- Shimmer overlay -->
            <div class="absolute inset-0 w-[200%] h-[200%] -top-[50%] -right-[50%] bg-[radial-gradient(circle,rgba(255,255,255,0.1)_0%,transparent_70%)] animate-shimmer"></div>
            
            <!-- Decorative Elements -->
            <div class="absolute w-[120px] h-[120px] -top-[30px] -left-[30px] rounded-full bg-white/10 backdrop-blur-md animate-float"></div>
            <div class="absolute w-[80px] h-[80px] -bottom-[20px] right-[20%] rounded-full bg-white/10 backdrop-blur-md animate-float-reverse"></div>
            <div class="absolute w-[60px] h-[60px] top-[50%] -right-[15px] rounded-full bg-white/10 backdrop-blur-md animate-float-delayed"></div>
            
            <div class="flex flex-col lg:flex-row lg:items-start lg:justify-between gap-6">
                <!-- Left Side - Title and Description -->
                <div class="flex-1 relative z-10">
                    <h1 class="text-[2.5rem] font-extrabold text-white drop-shadow-[0_4px_8px_rgba(0,0,0,0.2)] mb-2">
                        Partner Settings
                    </h1>
                    <p class="text-[1.1rem] font-normal text-white/90 drop-shadow-[0_2px_4px_rgba(0,0,0,0.1)]">
                        Manage your partner account settings, users, roles, and permissions
                    </p>
                </div>
                
                <!-- Refresh Button -->
                <div class="flex-shrink-0">
                    <button onclick="refreshData()" class="bg-gradient-to-r from-red-500 to-orange-500 text-white px-6 py-2.5 rounded-xl text-sm font-medium whitespace-nowrap shadow-[0_4px_15px_rgba(238,90,36,0.3)] transition-all duration-300 hover:-translate-y-0.5 hover:shadow-[0_6px_20px_rgba(238,90,36,0.4)]">
                        <i class="fas fa-sync-alt mr-2 transition-transform duration-300 hover:rotate-180"></i>
                        Refresh Data
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Management Cards Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
        <!-- User Management Card -->
        <div class="bg-gradient-to-br from-blue-50 to-indigo-100 border-2 border-blue-200 shadow-[0_8px_32px_rgba(0,0,0,0.1)] rounded-xl p-6 transition-all duration-300 hover:shadow-[0_15px_40px_rgba(0,0,0,0.15)] hover:-translate-y-1 hover:border-blue-300">
            <div class="flex items-start justify-between mb-4">
                <div class="flex items-center">
                    <div class="w-8 h-8 rounded-xl bg-gradient-to-br from-blue-500 to-blue-600 flex items-center justify-center text-white shadow-sm transition-all duration-300 hover:scale-110 mr-3">
                        <i class="fas fa-users-cog text-sm"></i>
                    </div>
                    <div>
                        <h3 class="text-base font-bold text-gray-900">User Management</h3>
                        <p class="text-xs text-gray-600 mt-1">Manage user accounts</p>
                    </div>
                </div>
            </div>
            
            <a href="{{ route('partner.settings.user-management') }}" class="bg-gradient-to-r from-blue-600 to-indigo-600 text-white py-2 px-4 rounded-lg hover:shadow-lg transition-all duration-300 inline-flex items-center justify-center text-xs font-medium hover:-translate-y-0.5 active:scale-95 relative overflow-hidden group w-full shadow-blue-600/30">
                <i class="fas fa-arrow-right mr-2 transition-transform duration-300 group-hover:translate-x-1"></i>Access User Management
            </a>
        </div>

        <!-- Role Management Card -->
        <div class="bg-gradient-to-br from-emerald-50 to-green-100 border-2 border-emerald-200 shadow-[0_8px_32px_rgba(0,0,0,0.1)] rounded-xl p-6 transition-all duration-300 hover:shadow-[0_15px_40px_rgba(0,0,0,0.15)] hover:-translate-y-1 hover:border-emerald-300">
            <div class="flex items-start justify-between mb-4">
                <div class="flex items-center">
                    <div class="w-8 h-8 rounded-xl bg-gradient-to-br from-emerald-500 to-emerald-600 flex items-center justify-center text-white shadow-sm transition-all duration-300 hover:scale-110 mr-3">
                        <i class="fas fa-user-tag text-sm"></i>
                    </div>
                    <div>
                        <h3 class="text-base font-bold text-gray-900">Role Management</h3>
                        <p class="text-xs text-gray-600 mt-1">Configure roles & permissions</p>
                    </div>
                </div>
            </div>
            
            <a href="{{ route('partner.settings.role-permission-management') }}" class="bg-gradient-to-r from-emerald-600 to-green-600 text-white py-2 px-4 rounded-lg hover:shadow-lg transition-all duration-300 inline-flex items-center justify-center text-xs font-medium hover:-translate-y-0.5 active:scale-95 relative overflow-hidden group w-full shadow-emerald-600/30">
                <i class="fas fa-arrow-right mr-2 transition-transform duration-300 group-hover:translate-x-1"></i>Access Role Management
            </a>
        </div>
    </div>

    <!-- Stats Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 lg:gap-6 mb-8">
        <!-- Users Card -->
        <div class="bg-gradient-to-br from-blue-100 via-blue-200 to-blue-300 border-2 border-transparent rounded-2xl p-4 sm:p-5 transition-all duration-300 hover:shadow-xl hover:-translate-y-1 relative overflow-hidden shadow-lg hover:shadow-2xl sm:p-5 lg:p-6 min-h-[120px] sm:min-h-[140px] lg:min-h-[160px]">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-700 mb-1">Total Users</p>
                    <p class="text-xl sm:text-2xl lg:text-3xl font-bold text-gray-900">{{ $stats['total_users'] ?? 0 }}</p>
                    <p class="text-xs text-gray-600 mt-1">Active accounts</p>
                </div>
                <div class="w-10 h-10 sm:w-12 sm:h-12 lg:w-14 lg:h-14 rounded-2xl flex items-center justify-center text-white shadow-lg transition-all duration-300 hover:scale-110 hover:rotate-12 bg-gradient-to-br from-blue-500 via-blue-600 to-blue-700 shadow-blue-500/30 hover:shadow-blue-500/50">
                    <i class="fas fa-users text-sm sm:text-lg"></i>
                </div>
            </div>
        </div>

        <!-- Roles Card -->
        <div class="bg-gradient-to-br from-emerald-100 via-emerald-200 to-emerald-300 border-2 border-transparent rounded-2xl p-4 sm:p-5 transition-all duration-300 hover:shadow-xl hover:-translate-y-1 relative overflow-hidden shadow-lg hover:shadow-2xl sm:p-5 lg:p-6 min-h-[120px] sm:min-h-[140px] lg:min-h-[160px]">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-700 mb-1">Roles</p>
                    <p class="text-xl sm:text-2xl lg:text-3xl font-bold text-gray-900">{{ $stats['total_roles'] ?? 0 }}</p>
                    <p class="text-xs text-gray-600 mt-1">User roles defined</p>
                </div>
                <div class="w-10 h-10 sm:w-12 sm:h-12 lg:w-14 lg:h-14 rounded-2xl flex items-center justify-center text-white shadow-lg transition-all duration-300 hover:scale-110 hover:rotate-12 bg-gradient-to-br from-emerald-500 via-emerald-600 to-emerald-700 shadow-emerald-500/30 hover:shadow-emerald-500/50">
                    <i class="fas fa-user-tag text-sm sm:text-lg"></i>
                </div>
            </div>
        </div>

        <!-- Permissions Card -->
        <div class="bg-gradient-to-br from-purple-100 via-purple-200 to-purple-300 border-2 border-transparent rounded-2xl p-4 sm:p-5 transition-all duration-300 hover:shadow-xl hover:-translate-y-1 relative overflow-hidden shadow-lg hover:shadow-2xl sm:p-5 lg:p-6 min-h-[120px] sm:min-h-[140px] lg:min-h-[160px]">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-700 mb-1">Permissions</p>
                    <p class="text-xl sm:text-2xl lg:text-3xl font-bold text-gray-900" id="totalPermissionsCount">Loading...</p>
                    <p class="text-xs text-gray-600 mt-1">System permissions</p>
                </div>
                <div class="w-10 h-10 sm:w-12 sm:h-12 lg:w-14 lg:h-14 rounded-2xl flex items-center justify-center text-white shadow-lg transition-all duration-300 hover:scale-110 hover:rotate-12 bg-gradient-to-br from-purple-500 via-purple-600 to-purple-700 shadow-purple-500/30 hover:shadow-purple-500/50">
                    <i class="fas fa-key text-sm sm:text-lg"></i>
                </div>
            </div>
        </div>

        <!-- Partner Card -->
        <div class="bg-gradient-to-br from-amber-100 via-amber-200 to-amber-300 border-2 border-transparent rounded-2xl p-4 sm:p-5 transition-all duration-300 hover:shadow-xl hover:-translate-y-1 relative overflow-hidden shadow-lg hover:shadow-2xl sm:p-5 lg:p-6 min-h-[120px] sm:min-h-[140px] lg:min-h-[160px]">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-700 mb-1">Partner</p>
                    <p class="text-lg sm:text-xl lg:text-2xl font-bold text-gray-900">{{ $partner?->name ?? 'N/A' }}</p>
                    <p class="text-xs text-gray-600 mt-1">Your organization</p>
                </div>
                <div class="w-10 h-10 sm:w-12 sm:h-12 lg:w-14 lg:h-14 rounded-2xl flex items-center justify-center text-white shadow-lg transition-all duration-300 hover:scale-110 hover:rotate-12 bg-gradient-to-br from-amber-500 via-amber-600 to-amber-700 shadow-amber-500/30 hover:shadow-amber-500/50">
                    <i class="fas fa-building text-sm sm:text-lg"></i>
                </div>
            </div>
        </div>
    </div>


    <!-- User Management Section -->
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden fade-in mb-8">
        <!-- Header -->
        <div class="px-4 sm:px-6 py-4 sm:py-5 border-b border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-750">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div class="flex-1 min-w-0">
                    <h5 class="text-lg sm:text-xl font-semibold text-gray-900 dark:text-white mb-1">User Management</h5>
                    <p class="text-sm text-gray-600 dark:text-gray-400">Oversee all user accounts and their statuses</p>
                </div>
                <a href="{{ route('partner.settings.users.create') }}" class="inline-flex items-center justify-center px-4 py-2.5 border border-transparent rounded-xl text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 dark:focus:ring-offset-gray-800 transition-all duration-200 shadow-sm hover:shadow-md">
                    <i class="fas fa-plus mr-2"></i>
                    <span>Create User</span>
                </a>
            </div>
        </div>
        
        <!-- Users Content -->
        <div class="p-4 sm:p-6">
            @if($stats['users'] && $stats['users']->isNotEmpty())
                <!-- Desktop Table -->
                <div class="hidden lg:block overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                        <thead class="bg-gray-50 dark:bg-gray-700">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Name</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Email</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Role</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                            @foreach($stats['users']->take(5) as $user)
                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors duration-150">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-medium text-gray-900 dark:text-white">{{ $user->name }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-500 dark:text-gray-400">{{ $user->email }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $user->status == 'active' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                            {{ ucfirst($user->status) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                        {{ $user->roles->first()->display_name ?? 'N/A' }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                
                <!-- Mobile Cards -->
                <div class="lg:hidden space-y-4">
                     @foreach($stats['users']->take(5) as $user)
                        <div class="bg-gray-50 dark:bg-gray-700 rounded-xl p-4 border border-gray-200 dark:border-gray-600">
                            <div class="flex items-center justify-between mb-2">
                                <h6 class="text-base font-semibold text-gray-900 dark:text-white">{{ $user->name }}</h6>
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $user->status == 'active' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                    {{ ucfirst($user->status) }}
                                </span>
                            </div>
                            <p class="text-sm text-gray-500 dark:text-gray-400 truncate">{{ $user->email }}</p>
                            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Role: {{ $user->roles->first()->display_name ?? 'N/A' }}</p>
                        </div>
                    @endforeach
                </div>
            @else
                <!-- Empty State -->
                <div class="text-center py-12 sm:py-16">
                    <div class="inline-flex items-center justify-center w-16 h-16 sm:w-20 sm:h-20 bg-gray-100 dark:bg-gray-700 rounded-full mb-4">
                        <i class="fas fa-users text-gray-400 text-2xl sm:text-3xl"></i>
                    </div>
                    <h3 class="text-lg sm:text-xl font-medium text-gray-900 dark:text-white mb-2">No users found</h3>
                    <p class="text-sm sm:text-base text-gray-500 dark:text-gray-400 mb-6 max-w-md mx-auto">Users you create will be displayed here.</p>
                </div>
            @endif
        </div>
    </div>

    <!-- Roles Management Section -->
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden fade-in mb-8">
        <!-- Header -->
        <div class="px-4 sm:px-6 py-4 sm:py-5 border-b border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-750">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div class="flex-1 min-w-0">
                    <h5 class="text-lg sm:text-xl font-semibold text-gray-900 dark:text-white mb-1">Roles Management</h5>
                    <p class="text-sm text-gray-600 dark:text-gray-400">Manage user roles and their permissions</p>
                </div>
                <a href="{{ route('partner.settings.roles.create') }}" class="inline-flex items-center justify-center px-4 py-2.5 border border-transparent rounded-xl text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800 transition-all duration-200 shadow-sm hover:shadow-md">
                    <i class="fas fa-plus mr-2"></i>
                    <span>Create Role</span>
                </a>
            </div>
        </div>
        
        <!-- Roles Content -->
        <div class="p-4 sm:p-6">
            @if($stats['roles'] && $stats['roles']->isNotEmpty())
                <!-- Desktop Table -->
                <div class="hidden lg:block overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                        <thead class="bg-gray-50 dark:bg-gray-700">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Role</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Level</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Users</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                            @foreach($stats['roles']->take(5) as $role)
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
                                        <span class="text-sm text-gray-600 dark:text-gray-400">{{ $role->users->count() }}</span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                
                <!-- Mobile Cards -->
                <div class="lg:hidden space-y-4">
                    @foreach($stats['roles']->take(5) as $role)
                        <div class="bg-gray-50 dark:bg-gray-700 rounded-xl p-4 border border-gray-200 dark:border-gray-600">
                            <div class="flex items-start justify-between mb-3">
                                <div class="flex-1 min-w-0">
                                    <h6 class="text-base font-semibold text-gray-900 dark:text-white mb-1">{{ $role->display_name }}</h6>
                                    <div class="flex items-center space-x-2">
                                        {!! $role->level_badge !!}
                                        {!! $role->status_badge !!}
                                    </div>
                                </div>
                            </div>
                            <div class="text-sm text-gray-600 dark:text-gray-400">{{ $role->users->count() }} Users</div>
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
                    <p class="text-sm sm:text-base text-gray-500 dark:text-gray-400 mb-6 max-w-md mx-auto">Roles will be displayed here once they are created.</p>
                </div>
            @endif
        </div>
    </div>

    <!-- Recent Activity Section -->
    <div class="bg-gradient-to-br from-white via-gray-50/50 to-gray-100/30 border border-gray-200/50 rounded-2xl shadow-lg overflow-hidden backdrop-blur-sm transition-all duration-300 hover:shadow-xl hover:border-gray-200/80">
        <div class="p-6 sm:p-7 border-b border-gray-200/50 bg-gradient-to-r from-indigo-50 via-purple-50/50 to-pink-50/30 relative overflow-hidden">
            <!-- Decorative elements -->
            <div class="absolute top-0 right-0 w-32 h-32 bg-gradient-to-br from-indigo-200/20 to-purple-200/20 rounded-full blur-3xl -translate-y-1/2 translate-x-1/2"></div>
            <div class="absolute bottom-0 left-0 w-24 h-24 bg-gradient-to-br from-pink-200/20 to-purple-200/20 rounded-full blur-2xl translate-y-1/2 -translate-x-1/2"></div>
            
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 relative z-10">
                <div>
                    <div class="flex items-center gap-3 mb-2">
                        <div class="w-8 h-8 rounded-xl bg-gradient-to-br from-indigo-500 to-purple-600 flex items-center justify-center shadow-lg shadow-indigo-500/20">
                            <i class="fas fa-chart-line text-white text-sm"></i>
                        </div>
                        <h3 class="text-xl sm:text-2xl font-bold bg-gradient-to-r from-gray-900 to-gray-700 bg-clip-text text-transparent">Recent Activity</h3>
                    </div>
                    <p class="text-sm text-gray-600 ml-11">Latest system activities and user actions</p>
                </div>
                <button onclick="loadRecentActivity()" class="bg-gradient-to-r from-indigo-500 to-purple-600 hover:from-indigo-600 hover:to-purple-700 text-white px-5 sm:px-7 py-2.5 sm:py-3 rounded-xl hover:shadow-lg transition-all duration-300 text-sm font-medium whitespace-nowrap self-start sm:self-auto hover:-translate-y-0.5 active:scale-95 w-full sm:w-auto shadow-indigo-500/30 hover:shadow-indigo-500/50 group">
                    <i class="fas fa-sync-alt mr-2 transition-transform duration-300 group-hover:rotate-180"></i>
                    Refresh Activity
                </button>
            </div>
        </div>
        
        <!-- Desktop Table View -->
        <div class="overflow-x-auto hidden sm:block bg-gradient-to-b from-white/50 to-gray-50/30">
            <table class="w-full">
                <thead class="bg-gradient-to-r from-indigo-50/50 via-purple-50/30 to-pink-50/20 border-b border-gray-200/50 backdrop-blur-sm">
                    <tr>
                        <th class="py-4 px-6 text-left text-xs font-semibold text-indigo-700 uppercase tracking-wider">User</th>
                        <th class="py-4 px-6 text-left text-xs font-semibold text-purple-700 uppercase tracking-wider">Action</th>
                        <th class="py-4 px-6 text-left text-xs font-semibold text-pink-700 uppercase tracking-wider">Description</th>
                        <th class="py-4 px-6 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider hidden lg:table-cell">IP Address</th>
                        <th class="py-4 px-6 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Time</th>
                    </tr>
                </thead>
                <tbody id="recentActivityTable" class="divide-y divide-gray-200/30">
                    <!-- Loading state -->
                    <tr class="hover:bg-gradient-to-r hover:from-indigo-50/20 hover:to-purple-50/20 transition-all duration-300">
                        <td colspan="5" class="text-center py-16">
                            <div class="flex flex-col items-center">
                                <div class="relative mb-4">
                                    <div class="w-16 h-16 rounded-full bg-gradient-to-br from-indigo-100 to-purple-100 flex items-center justify-center shadow-lg">
                                        <i class="fas fa-spinner fa-spin text-2xl text-transparent bg-clip-text bg-gradient-to-r from-indigo-600 to-purple-600"></i>
                                    </div>
                                    <div class="absolute -top-1 -right-1 w-5 h-5 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-full animate-pulse"></div>
                                </div>
                                <p class="text-lg font-semibold bg-gradient-to-r from-gray-900 to-gray-700 bg-clip-text text-transparent mb-2">Loading activity...</p>
                                <p class="text-sm text-gray-500">Please wait while we fetch the latest data</p>
                            </div>
                        </td>
                    </tr>
                    <!-- Sample row for styling reference -->
                    <tr class="hover:bg-gradient-to-r hover:from-indigo-50/20 hover:to-purple-50/20 transition-all duration-300">
                        <td class="py-4 px-6">
                            <div class="flex items-center">
                                <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-blue-400 to-blue-600 flex items-center justify-center shadow-md shadow-blue-500/20 mr-3">
                                    <i class="fas fa-user text-white text-sm"></i>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-900">John Doe</p>
                                    <p class="text-xs text-gray-500">john@example.com</p>
                                </div>
                            </div>
                        </td>
                        <td class="py-4 px-6">
                            <span class="px-3 py-1 text-xs font-medium rounded-full bg-gradient-to-r from-green-100 to-emerald-100 text-green-800 border border-green-200">Login</span>
                        </td>
                        <td class="py-4 px-6">
                            <p class="text-sm text-gray-900">User logged in successfully</p>
                        </td>
                        <td class="py-4 px-6 hidden lg:table-cell">
                            <p class="text-sm text-gray-600 font-mono">192.168.1.100</p>
                        </td>
                        <td class="py-4 px-6">
                            <p class="text-sm text-gray-600">2 minutes ago</p>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        
        <!-- Mobile Activity Cards -->
        <div id="recentActivityCards" class="sm:hidden p-4 space-y-4">
            <!-- Loading Card -->
            <div class="bg-gradient-to-br from-white via-gray-50/50 to-gray-100/20 border border-gray-200/50 rounded-2xl p-5 shadow-lg backdrop-blur-sm transition-all duration-300 hover:shadow-xl hover:border-gray-200/80 relative overflow-hidden">
                <!-- Decorative elements -->
                <div class="absolute top-2 right-2 w-20 h-20 bg-gradient-to-br from-indigo-100/20 to-purple-100/20 rounded-full blur-2xl"></div>
                
                <div class="flex items-center mb-4 relative z-10">
                    <div class="w-12 h-12 rounded-2xl bg-gradient-to-br from-indigo-100 to-purple-100 flex items-center justify-center mr-4 flex-shrink-0 shadow-lg shadow-indigo-500/20">
                        <i class="fas fa-spinner fa-spin text-lg text-transparent bg-clip-text bg-gradient-to-r from-indigo-600 to-purple-600"></i>
                    </div>
                    <div class="flex-1">
                        <p class="text-base font-semibold bg-gradient-to-r from-gray-900 to-gray-700 bg-clip-text text-transparent">Loading activity...</p>
                        <p class="text-sm text-gray-500">Please wait while we fetch the latest data</p>
                    </div>
                </div>
                <div class="flex items-center justify-between">
                    <span class="px-3 py-1 text-xs font-medium rounded-full bg-gradient-to-r from-indigo-100 to-purple-100 text-indigo-800 border border-indigo-200">Loading</span>
                    <div class="flex items-center text-xs text-gray-500">
                        <i class="fas fa-clock mr-1"></i>
                        <span>--</span>
                    </div>
                </div>
            </div>
            
            <!-- Sample Activity Card -->
            <div class="bg-gradient-to-br from-white via-gray-50/50 to-gray-100/20 border border-gray-200/50 rounded-2xl p-5 shadow-lg backdrop-blur-sm transition-all duration-300 hover:shadow-xl hover:border-gray-200/80 relative overflow-hidden group">
                <!-- Decorative elements -->
                <div class="absolute top-2 right-2 w-20 h-20 bg-gradient-to-br from-blue-100/20 to-cyan-100/20 rounded-full blur-2xl opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                
                <div class="flex items-center mb-4 relative z-10">
                    <div class="w-12 h-12 rounded-2xl bg-gradient-to-br from-blue-400 to-cyan-600 flex items-center justify-center mr-4 flex-shrink-0 shadow-lg shadow-blue-500/20 transition-all duration-300 group-hover:scale-110">
                        <i class="fas fa-user text-white text-lg"></i>
                    </div>
                    <div class="flex-1">
                        <p class="text-base font-semibold text-gray-900">John Doe</p>
                        <p class="text-sm text-gray-500">john@example.com</p>
                    </div>
                </div>
                <div class="mb-3">
                    <div class="flex items-center mb-2">
                        <span class="px-3 py-1 text-xs font-medium rounded-full bg-gradient-to-r from-green-100 to-emerald-100 text-green-800 border border-green-200 mr-2">Login</span>
                        <span class="text-xs text-gray-600">Successful login</span>
                    </div>
                </div>
                <div class="flex items-center justify-between text-xs text-gray-500">
                    <div class="flex items-center">
                        <i class="fas fa-network-wired mr-1"></i>
                        <span class="font-mono">192.168.1.100</span>
                    </div>
                    <div class="flex items-center">
                        <i class="fas fa-clock mr-1"></i>
                        <span>2 min ago</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
// Load total permissions count
function loadPermissionsCount() {
    fetch('/api/permissions')
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                document.getElementById('totalPermissionsCount').textContent = data.permissions.length;
            }
        })
        .catch(error => {
            console.error('Error loading permissions count:', error);
            document.getElementById('totalPermissionsCount').textContent = 'Error';
        });
}

// Load recent activity
function loadRecentActivity() {
    fetch('/api/users/recent-activity')
        .then(response => response.json())
        .then(data => {
            const tbody = document.getElementById('recentActivityTable');
            const cards = document.getElementById('recentActivityCards');
            if (data.success && data.activities.length > 0) {
                tbody.innerHTML = data.activities.slice(0, 10).map(activity => `
                    <tr class="activity-row">
                        <td class="py-4 px-6 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="w-10 h-10 rounded-full bg-gradient-to-br from-gray-400 to-gray-500 flex items-center justify-center mr-4 flex-shrink-0 shadow-sm">
                                    <i class="fas fa-user text-white text-sm"></i>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-900">${activity.user_name || 'Unknown User'}</p>
                                    <p class="text-xs text-gray-500">${activity.user_email || ''}</p>
                                </div>
                            </div>
                        </td>
                        <td class="py-4 px-6 whitespace-nowrap">
                            <span class="px-3 py-1 text-xs font-medium rounded-full ${getActionBadgeColor(activity.action)}">${formatAction(activity.action || '')}</span>
                        </td>
                        <td class="py-4 px-6 hidden sm:table-cell">
                            <p class="text-sm text-gray-900 max-w-xs truncate">${activity.description}</p>
                        </td>
                        <td class="py-4 px-6 hidden sm:table-cell">
                            <code class="text-xs text-gray-500 bg-gray-100 px-2 py-1 rounded-md">${activity.ip_address || 'N/A'}</code>
                        </td>
                        <td class="py-4 px-6 whitespace-nowrap">
                            <p class="text-sm text-gray-900">${formatTimestamp(activity.created_at)}</p>
                        </td>
                    </tr>
                `).join('');

                // Render mobile cards
                cards.innerHTML = data.activities.slice(0, 10).map(activity => `
                    <div class="activity-card">
                        <div class="flex items-center mb-2">
                            <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-gray-400 to-gray-500 flex items-center justify-center mr-3 flex-shrink-0 shadow-sm">
                                <i class="fas fa-user text-white text-sm"></i>
                            </div>
                            <div class="min-w-0">
                                <p class="text-sm font-medium text-gray-900 truncate">${activity.user_name || 'Unknown User'}</p>
                                <p class="text-xs text-gray-500 truncate">${activity.user_email || ''}</p>
                            </div>
                        </div>
                        <div class="flex items-center justify-between text-xs text-gray-500 mt-2">
                            <span class="badge ${getActionBadgeColor(activity.action)}">${formatAction(activity.action || '')}</span>
                            <span class="">${formatTimestamp(activity.created_at)}</span>
                        </div>
                        ${activity.description ? `<p class="text-sm text-gray-700 mt-2">${activity.description}</p>` : ''}
                        ${activity.ip_address ? `<code class="text-xs text-gray-500 bg-gray-100 px-2 py-1 rounded-md inline-block mt-2">${activity.ip_address}</code>` : ''}
                    </div>
                `).join('');
            } else {
                tbody.innerHTML = `
                    <tr>
                        <td colspan="5" class="text-center py-12 text-gray-500">
                            <div class="flex flex-col items-center">
                                <i class="fas fa-inbox text-3xl text-gray-300 mb-3"></i>
                                <p class="text-base font-medium text-gray-900">No activity found</p>
                                <p class="text-sm text-gray-500">There are no recent system activities to display</p>
                            </div>
                        </td>
                    </tr>
                `;
                cards.innerHTML = `
                    <div class="activity-card">
                        <div class="flex items-center mb-2">
                            <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-gray-400 to-gray-500 flex items-center justify-center mr-3 flex-shrink-0 shadow-sm">
                                <i class="fas fa-inbox text-white text-sm"></i>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-900">No activity found</p>
                                <p class="text-xs text-gray-500">There are no recent system activities to display</p>
                            </div>
                        </div>
                    </div>
                `;
            }
        })
        .catch(error => {
            console.error('Error loading recent activity:', error);
            document.getElementById('recentActivityTable').innerHTML = `
                <tr>
                    <td colspan="5" class="text-center py-12 text-gray-500">
                        <div class="flex flex-col items-center">
                            <i class="fas fa-exclamation-triangle text-3xl text-gray-300 mb-3"></i>
                            <p class="text-base font-medium text-gray-900">Unable to load activity</p>
                            <p class="text-sm text-gray-500">Please check your connection and try again</p>
                        </div>
                    </td>
                </tr>
            `;
            document.getElementById('recentActivityCards').innerHTML = `
                <div class="activity-card">
                    <div class="flex items-center mb-2">
                        <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-red-400 to-red-500 flex items-center justify-center mr-3 flex-shrink-0 shadow-sm">
                            <i class="fas fa-exclamation-triangle text-white text-sm"></i>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-900">Unable to load activity</p>
                            <p class="text-xs text-gray-500">Please check your connection and try again</p>
                        </div>
                    </div>
                </div>
            `;
        });
}

// Helper functions
function getActionBadgeColor(action) {
    const colors = {
        'login': 'bg-green-100 text-green-800',
        'logout': 'bg-gray-100 text-gray-800',
        'create': 'bg-blue-100 text-blue-800',
        'update': 'bg-yellow-100 text-yellow-800',
        'delete': 'bg-red-100 text-red-800',
        'view': 'bg-purple-100 text-purple-800',
        'export': 'bg-indigo-100 text-indigo-800',
        'import': 'bg-pink-100 text-pink-800'
    };
    return colors[action?.toLowerCase()] || 'bg-gray-100 text-gray-800';
}

function formatAction(action) {
    if (!action) return 'Unknown';
    return action.charAt(0).toUpperCase() + action.slice(1).replace(/_/g, ' ');
}

function formatTimestamp(timestamp) {
    if (!timestamp) return 'N/A';
    const date = new Date(timestamp);
    const now = new Date();
    const diff = now - date;
    
    if (diff < 60000) return 'Just now';
    if (diff < 3600000) return `${Math.floor(diff / 60000)}m ago`;
    if (diff < 86400000) return `${Math.floor(diff / 3600000)}h ago`;
    if (diff < 604800000) return `${Math.floor(diff / 86400000)}d ago`;
    
    return date.toLocaleDateString();
}

// Refresh all data
function refreshData() {
    loadPermissionsCount();
    loadRecentActivity();
    
    // Show toast notification
    const toast = document.createElement('div');
    toast.className = 'fixed top-6 right-6 bg-white border border-gray-100 rounded-xl shadow-xl z-50 flex items-center p-4 min-w-[320px] backdrop-blur-sm';
    toast.style.background = 'linear-gradient(135deg, #ffffff 0%, #fafbfc 100%)';
    toast.setAttribute('role', 'alert');
    toast.innerHTML = `
        <div class="flex items-center">
            <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-green-500 to-green-600 flex items-center justify-center mr-3 shadow-sm">
                <i class="fas fa-check text-white"></i>
            </div>
            <div>
                <p class="text-sm font-medium text-gray-900">Data refreshed</p>
                <p class="text-xs text-gray-500">Statistics updated successfully</p>
            </div>
        </div>
    `;
    document.body.appendChild(toast);
    
    setTimeout(() => {
        toast.style.opacity = '0';
        toast.style.transform = 'translateX(100%)';
        toast.style.transition = 'all 0.3s ease';
        setTimeout(() => {
            toast.remove();
        }, 300);
    }, 3000);
}

// Initialize page
document.addEventListener('DOMContentLoaded', function() {
    loadPermissionsCount();
    loadRecentActivity();
    
    // Auto-refresh every 5 minutes
    setInterval(() => {
        loadRecentActivity();
    }, 300000);
});
</script>
@endsection
