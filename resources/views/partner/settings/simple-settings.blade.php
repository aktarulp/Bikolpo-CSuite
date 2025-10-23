@extends('layouts.partner-layout')

@section('title', 'Partner Settings')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-50 via-blue-50/30 to-gray-50 pb-8">
    <!-- Modern Page Header -->
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
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 space-y-6">
        <!-- Stats Cards -->
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
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"></path>
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

        <!-- Simple Message -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
            <div class="text-center">
                <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <h3 class="text-lg font-semibold text-gray-900 mb-2">Settings Dashboard</h3>
                <p class="text-gray-600 mb-4">This is a simplified version of the settings page. The full interface is being updated.</p>
                <div class="flex flex-col sm:flex-row gap-3 justify-center">
                    <a href="{{ route('partner.settings.users.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                        </svg>
                        Create User
                    </a>
                    <a href="{{ route('partner.dashboard') }}" class="inline-flex items-center px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition-colors">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                        </svg>
                        Back to Dashboard
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
