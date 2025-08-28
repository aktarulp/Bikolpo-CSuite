@extends('layouts.partner-layout')

@section('title', 'Edit Partner Profile')

@section('content')
<div class="space-y-6">
    <!-- Page Header -->
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Edit Profile</h1>
            <p class="text-gray-600 dark:text-gray-400">Update your institution information</p>
        </div>
        <a href="{{ route('partner.profile.show-partnar') }}" 
           class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg transition-colors duration-200">
            View Profile
        </a>
    </div>

    <!-- Edit Profile Form -->
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md border border-gray-200 dark:border-gray-700">
        <div class="p-6 border-b border-gray-200 dark:border-gray-700">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Institution Information</h3>
        </div>
        
        <form action="{{ route('partner.profile.updatePartner') }}" method="POST" enctype="multipart/form-data" class="p-6 space-y-6">
            @csrf
            @method('PUT')
            
            <!-- Logo Upload -->
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Institution Logo</label>
                <div class="flex items-center space-x-4">
                    @if($partner && $partner->logo)
                        <img src="{{ asset('storage/' . $partner->logo) }}" 
                             alt="Current Logo" 
                             class="w-20 h-20 rounded-lg object-cover border border-gray-200 dark:border-gray-600">
                    @else
                        <div class="w-20 h-20 bg-gradient-to-br from-primaryGreen to-green-600 rounded-lg flex items-center justify-center">
                            <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                            </svg>
                        </div>
                    @endif
                    <div class="flex-1">
                        <input type="file" name="logo" accept="image/*" 
                               class="block w-full text-sm text-gray-500 dark:text-gray-400 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-primaryGreen file:text-white hover:file:bg-green-600 file:cursor-pointer">
                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">PNG, JPG, GIF up to 2MB</p>
                    </div>
                </div>
            </div>

            <!-- Basic Information -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Institution Name <span class="text-red-500">*</span>
                    </label>
                    <input type="text" id="name" name="name" required
                           value="{{ old('name', $partner->name ?? '') }}"
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
                           value="{{ old('email', $partner->email ?? '') }}"
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
                           value="{{ old('phone', $partner->phone ?? '') }}"
                           placeholder="01XXXXXXXXX"
                           class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-primaryGreen focus:border-transparent">
                    @error('phone')
                        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="city" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        City
                    </label>
                    <input type="text" id="city" name="city"
                           value="{{ old('city', $partner->city ?? '') }}"
                           class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-primaryGreen focus:border-transparent">
                    @error('city')
                        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Address -->
            <div>
                <label for="address" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                    Address
                </label>
                <textarea id="address" name="address" rows="3"
                          class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-primaryGreen focus:border-transparent">{{ old('address', $partner->address ?? '') }}</textarea>
                @error('address')
                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Description -->
            <div>
                <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                    Description
                </label>
                <textarea id="description" name="description" rows="4"
                          class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-primaryGreen focus:border-transparent">{{ old('description', $partner->description ?? '') }}</textarea>
                @error('description')
                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Submit Button -->
            <div class="flex justify-end space-x-3 pt-4 border-t border-gray-200 dark:border-gray-700">
                <a href="{{ route('partner.profile.show-partnar') }}" 
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
