@extends('layouts.partner-layout')

@section('title', 'Create New User')

@section('content')
<div class="flex-1 overflow-y-auto custom-scrollbar bg-gray-50 dark:bg-gray-900 min-h-screen p-4 sm:p-6 lg:p-8">
    <div class="max-w-3xl mx-auto">

        <!-- Page Header -->
        <div class="mb-8 text-center">
            <div class="inline-block bg-gradient-to-r from-indigo-500 to-blue-500 p-3 rounded-full shadow-lg mb-4">
                <i class="fas fa-user-plus text-white text-2xl"></i>
            </div>
            <h1 class="text-3xl font-extrabold text-gray-900 dark:text-white tracking-tight">Create a New User</h1>
            <p class="mt-2 text-base text-gray-600 dark:text-gray-400">Fill in the details below to onboard a new team member.</p>
        </div>

        <!-- Create User Form -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg border border-gray-200 dark:border-gray-700">
            <form action="{{ route('partner.settings.users.store') }}" method="POST" class="p-6 sm:p-8 space-y-6">
                @csrf

                <!-- Section: User Information -->
                <div class="space-y-6">
                    <h2 class="text-lg font-semibold text-gray-900 dark:text-white border-b border-gray-200 dark:border-gray-700 pb-3">User Information</h2>
                    
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                        <!-- Name -->
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Full Name</label>
                            <div class="relative">
                                <i class="fas fa-user absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                                <input type="text" name="name" id="name" required class="pl-10 block w-full px-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm dark:bg-gray-700 dark:text-white transition duration-150">
                            </div>
                        </div>

                        <!-- Email -->
                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Email Address</label>
                            <div class="relative">
                                <i class="fas fa-envelope absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                                <input type="email" name="email" id="email" required class="pl-10 block w-full px-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm dark:bg-gray-700 dark:text-white transition duration-150">
                            </div>
                        </div>
                    </div>

                    <!-- Phone -->
                    <div>
                        <label for="phone" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Phone Number</label>
                        <div class="relative">
                            <i class="fas fa-phone absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                            <input type="text" name="phone" id="phone" class="pl-10 block w-full px-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm dark:bg-gray-700 dark:text-white transition duration-150">
                        </div>
                    </div>
                </div>

                <!-- Section: Security -->
                <div class="space-y-6 pt-6 border-t border-gray-200 dark:border-gray-700">
                    <h2 class="text-lg font-semibold text-gray-900 dark:text-white border-b border-gray-200 dark:border-gray-700 pb-3">Security</h2>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                        <!-- Password -->
                        <div>
                            <label for="password" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Password</label>
                            <div class="relative">
                                <i class="fas fa-lock absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                                <input type="password" name="password" id="password" required class="pl-10 block w-full px-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm dark:bg-gray-700 dark:text-white transition duration-150">
                            </div>
                        </div>
                        <!-- Confirm Password -->
                        <div>
                            <label for="password_confirmation" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Confirm Password</label>
                            <div class="relative">
                                <i class="fas fa-lock absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                                <input type="password" name="password_confirmation" id="password_confirmation" required class="pl-10 block w-full px-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm dark:bg-gray-700 dark:text-white transition duration-150">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Section: Role & Status -->
                <div class="space-y-6 pt-6 border-t border-gray-200 dark:border-gray-700">
                    <h2 class="text-lg font-semibold text-gray-900 dark:text-white border-b border-gray-200 dark:border-gray-700 pb-3">Role & Status</h2>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                        <!-- Role -->
                        <div>
                            <label for="role_ids" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Assign Role</label>
                            <select name="role_ids[]" id="role_ids" required class="block w-full pl-3 pr-10 py-2.5 text-base border-gray-300 dark:border-gray-600 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-lg dark:bg-gray-700 dark:text-white transition duration-150">
                                @foreach($roles as $role)
                                    <option value="{{ $role->id }}">{{ $role->display_name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <!-- Status -->
                        <div>
                            <label for="status" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Account Status</label>
                            <select name="status" id="status" required class="block w-full pl-3 pr-10 py-2.5 text-base border-gray-300 dark:border-gray-600 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-lg dark:bg-gray-700 dark:text-white transition duration-150">
                                <option value="active">Active</option>
                                <option value="inactive">Inactive</option>
                                <option value="pending">Pending</option>
                                <option value="suspended">Suspended</option>
                            </select>
                        </div>
                    </div>
                </div>

                <!-- Section: Partner Assignment -->
                <div class="space-y-6 pt-6 border-t border-gray-200 dark:border-gray-700">
                    <h2 class="text-lg font-semibold text-gray-900 dark:text-white border-b border-gray-200 dark:border-gray-700 pb-3">Partner Assignment</h2>
                    <div>
                        <label for="partner_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Assign to Partner (Optional)</label>
                        <select name="partner_id" id="partner_id" class="block w-full pl-3 pr-10 py-2.5 text-base border-gray-300 dark:border-gray-600 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-lg dark:bg-gray-700 dark:text-white transition duration-150">
                            <option value="">None</option>
                            @foreach($partners as $partner)
                                <option value="{{ $partner->id }}">{{ $partner->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="flex items-center justify-end space-x-4 pt-8">
                    <a href="{{ route('partner.settings.user-management') }}" class="px-6 py-2.5 text-sm font-medium text-gray-700 bg-gray-100 hover:bg-gray-200 dark:bg-gray-700 dark:text-gray-300 dark:hover:bg-gray-600 rounded-lg transition duration-300">Cancel</a>
                    <button type="submit" class="inline-flex items-center px-6 py-2.5 text-sm font-medium text-white bg-gradient-to-r from-indigo-600 to-blue-600 hover:from-indigo-700 hover:to-blue-700 rounded-lg shadow-lg hover:shadow-xl transition duration-300">
                        <i class="fas fa-check mr-2"></i>
                        Create User
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
