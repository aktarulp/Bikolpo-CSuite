@extends('layouts.partner-layout')

@section('title', 'Edit Profile')

@section('content')
<div class="space-y-6">
    <!-- Page Header -->
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Edit Profile</h1>
            <p class="text-gray-600 dark:text-gray-400">Update your profile information</p>
        </div>
        <a href="{{ route('partner.profile.show-partnar') }}" 
           class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg transition-colors duration-200">
            View Profile
        </a>
    </div>

    <div class="max-w-4xl space-y-6">
        <!-- Profile Information Form -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md border border-gray-200 dark:border-gray-700">
            <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Profile Information</h3>
            </div>
            <div class="p-6">
                @include('profile.partials.update-profile-information-form')
            </div>
        </div>

        <!-- Password Update Form -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md border border-gray-200 dark:border-gray-700">
            <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Update Password</h3>
            </div>
            <div class="p-6">
                @include('profile.partials.update-password-form')
            </div>
        </div>

        <!-- Delete Account Form -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md border border-gray-200 dark:border-gray-700">
            <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Delete Account</h3>
            </div>
            <div class="p-6">
                @include('profile.partials.delete-user-form')
            </div>
        </div>
    </div>
</div>
@endsection
