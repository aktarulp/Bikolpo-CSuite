@extends('layouts.partner-layout')

@section('title', 'Edit User Profile')

@section('content')
<div class="space-y-6">
    <!-- Page Header -->
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Edit User Profile</h1>
            <p class="text-gray-600 dark:text-gray-400">Update your account information</p>
        </div>
        <a href="{{ route('partner.profile.show-user-profile') }}" 
           class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg transition-colors duration-200">
            View Profile
        </a>
    </div>

    <!-- Edit Profile Form -->
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md border border-gray-200 dark:border-gray-700">
        <div class="p-6 border-b border-gray-200 dark:border-gray-700">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Account Information</h3>
        </div>
        
        <form action="{{ route('partner.profile.update-user') }}" method="POST" class="p-6 space-y-6">
            @csrf
            @method('PUT')
            
            <!-- Basic Information -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Full Name <span class="text-red-500">*</span>
                    </label>
                    <input type="text" id="name" name="name" required
                           value="{{ old('name', $user->name ?? '') }}"
                           class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-primaryGreen focus:border-transparent">
                    @error('name')
                        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Email Address <span class="text-red-500">*</span>
                    </label>
                    <input type="email" id="email" name="email" required
                           value="{{ old('email', $user->email ?? '') }}"
                           class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-primaryGreen focus:border-transparent">
                    @error('email')
                        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="phone" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Phone Number
                    </label>
                    <input type="text" id="phone" name="phone"
                           value="{{ old('phone', $user->phone ?? '') }}"
                           placeholder="01XXXXXXXXX"
                           class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-primaryGreen focus:border-transparent">
                    @error('phone')
                        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="role" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Account Type
                    </label>
                    <div class="px-3 py-2 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg">
                        <p class="text-gray-900 dark:text-white">{{ ucfirst($user->role ?? 'User') }}</p>
                    </div>
                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Account type cannot be changed</p>
                </div>
            </div>

            <!-- Password Change Section -->
            <div class="border-t border-gray-200 dark:border-gray-700 pt-6">
                <h4 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Change Password</h4>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="current_password" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Current Password
                        </label>
                        <input type="password" id="current_password" name="current_password"
                               class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-primaryGreen focus:border-transparent">
                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Leave blank if you don't want to change password</p>
                    </div>

                    <div>
                        <label for="new_password" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            New Password
                        </label>
                        <input type="password" id="new_password" name="new_password"
                               class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-primaryGreen focus:border-transparent">
                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Minimum 8 characters</p>
                    </div>
                </div>

                <div class="mt-4">
                    <label for="new_password_confirmation" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Confirm New Password
                    </label>
                    <input type="password" id="new_password_confirmation" name="new_password_confirmation"
                           class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-primaryGreen focus:border-transparent">
                </div>
            </div>

            <!-- Submit Button -->
            <div class="flex justify-end space-x-3 pt-4 border-t border-gray-200 dark:border-gray-700">
                <a href="{{ route('partner.profile.show-user-profile') }}" 
                   class="px-4 py-2 text-gray-700 dark:text-gray-300 bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 rounded-lg transition-colors duration-200">
                    Cancel
                </a>
                <button type="submit" 
                        class="px-6 py-2 bg-primaryGreen hover:bg-green-600 text-white font-medium rounded-lg transition-colors duration-200">
                    Update Profile
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
