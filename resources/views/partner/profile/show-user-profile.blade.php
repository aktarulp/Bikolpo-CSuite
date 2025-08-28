@extends('layouts.partner-layout')

@section('title', 'User Profile')

@section('content')
<div class="space-y-6">
    <!-- Page Header -->
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-3xl font-bold text-gray-900 dark:text-white">User Profile</h1>
            <p class="text-gray-600 dark:text-gray-400">View your account information</p>
        </div>
        <a href="{{ route('partner.profile.edit-user-profile') }}" 
           class="bg-primaryGreen hover:bg-green-600 text-white px-4 py-2 rounded-lg transition-colors duration-200">
            Edit Profile
        </a>
    </div>

    <!-- User Information -->
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md border border-gray-200 dark:border-gray-700">
        <div class="p-6 border-b border-gray-200 dark:border-gray-700">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Account Information</h3>
        </div>
        
        <div class="p-6 space-y-6">
            <!-- Profile Picture and Basic Info -->
            <div class="flex items-start space-x-6">
                <!-- Profile Picture -->
                <div class="flex-shrink-0">
                    <div class="w-24 h-24 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-lg flex items-center justify-center">
                        <span class="text-3xl font-bold text-white">{{ substr($user->name ?? 'U', 0, 1) }}</span>
                    </div>
                </div>

                <!-- Basic Info -->
                <div class="flex-1">
                    <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-2">
                        {{ $user->name ?? 'User Name' }}
                    </h2>
                    <p class="text-gray-600 dark:text-gray-400 mb-4">
                        {{ $user->email ?? 'No email provided' }}
                    </p>
                    <div class="flex items-center space-x-4 text-sm text-gray-600 dark:text-gray-400">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200">
                            {{ ucfirst($user->role ?? 'User') }}
                        </span>
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200">
                            {{ $user->email_verified_at ? 'Verified' : 'Not Verified' }}
                        </span>
                    </div>
                </div>
            </div>

            <!-- Account Details -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Full Name</label>
                    <div class="px-3 py-2 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg">
                        <p class="text-gray-900 dark:text-white">{{ $user->name ?? 'No name provided' }}</p>
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Email Address</label>
                    <div class="px-3 py-2 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg">
                        <p class="text-gray-900 dark:text-white">{{ $user->email ?? 'No email provided' }}</p>
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Phone Number</label>
                    <div class="px-3 py-2 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg">
                        <p class="text-gray-900 dark:text-white">{{ $user->phone ?? 'No phone provided' }}</p>
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Account Type</label>
                    <div class="px-3 py-2 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg">
                        <p class="text-gray-900 dark:text-white">{{ ucfirst($user->role ?? 'User') }}</p>
                    </div>
                </div>
            </div>

            <!-- Account Statistics -->
            <div class="border-t border-gray-200 dark:border-gray-700 pt-6">
                <h4 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Account Statistics</h4>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                    <div class="text-center p-4 bg-blue-50 dark:bg-blue-900/20 rounded-lg">
                        <div class="text-2xl font-bold text-blue-600 dark:text-blue-400">{{ $user->created_at ? $user->created_at->diffForHumans() : 'N/A' }}</div>
                        <div class="text-sm text-gray-600 dark:text-gray-400">Member Since</div>
                    </div>
                    <div class="text-center p-4 bg-green-50 dark:bg-green-900/20 rounded-lg">
                        <div class="text-2xl font-bold text-green-600 dark:text-green-400">{{ $user->email_verified_at ? 'Yes' : 'No' }}</div>
                        <div class="text-sm text-gray-600 dark:text-gray-400">Email Verified</div>
                    </div>
                    <div class="text-center p-4 bg-purple-50 dark:bg-purple-900/20 rounded-lg">
                        <div class="text-2xl font-bold text-purple-600 dark:text-purple-400">{{ $user->last_login_at ?? 'Never' }}</div>
                        <div class="text-sm text-gray-600 dark:text-gray-400">Last Login</div>
                    </div>
                    <div class="text-center p-4 bg-orange-50 dark:bg-orange-900/20 rounded-lg">
                        <div class="text-2xl font-bold text-orange-600 dark:text-orange-400">{{ $user->updated_at ? $user->updated_at->diffForHumans() : 'N/A' }}</div>
                        <div class="text-sm text-gray-600 dark:text-gray-400">Last Updated</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md border border-gray-200 dark:border-gray-700">
        <div class="p-6 border-b border-gray-200 dark:border-gray-700">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Quick Actions</h3>
        </div>
        <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <a href="{{ route('partner.profile.edit-user-profile') }}" 
                   class="flex items-center p-4 bg-blue-50 dark:bg-blue-900/20 rounded-lg hover:bg-blue-100 dark:hover:bg-blue-900/30 transition-colors duration-200">
                    <svg class="w-8 h-8 text-blue-600 dark:text-blue-400 mr-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                    </svg>
                    <div>
                        <h4 class="font-medium text-gray-900 dark:text-white">Edit Profile</h4>
                        <p class="text-sm text-gray-600 dark:text-gray-400">Update account information</p>
                    </div>
                </a>

                <a href="{{ route('partner.dashboard') }}" 
                   class="flex items-center p-4 bg-green-50 dark:bg-green-900/20 rounded-lg hover:bg-green-100 dark:hover:bg-green-900/30 transition-colors duration-200">
                    <svg class="w-8 h-8 text-green-600 dark:text-green-400 mr-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 01-2-2z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5a2 2 0 012-2h4a2 2 0 012 2v6H8V5z"></path>
                    </svg>
                    <div>
                        <h4 class="font-medium text-gray-900 dark:text-white">Back to Dashboard</h4>
                        <p class="text-sm text-gray-600 dark:text-gray-400">Return to main dashboard</p>
                    </div>
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
