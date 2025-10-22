@extends('layouts.partner-layout')

@section('title', 'Edit Partner Profile')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-slate-50 via-orange-50 to-yellow-50 dark:from-gray-900 dark:via-gray-800 dark:to-gray-900 py-4 sm:py-6 lg:py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Professional Header Section -->
        <div class="mb-6 sm:mb-8 lg:mb-10">
            <!-- Breadcrumb Navigation -->
            <nav class="flex items-center space-x-2 text-sm text-gray-600 dark:text-gray-400 mb-4 sm:mb-6" aria-label="Breadcrumb">
                <a href="{{ route('partner.dashboard') }}" class="hover:text-orange-600 dark:hover:text-orange-400 transition-colors duration-200">Dashboard</a>
                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                </svg>
                <a href="{{ route('partner.profile.show-partnar') }}" class="hover:text-orange-600 dark:hover:text-orange-400 transition-colors duration-200">Profile</a>
                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                </svg>
                <span class="text-gray-900 dark:text-gray-100 font-medium">Edit Profile</span>
            </nav>
            
            <!-- Main Header -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg border border-gray-200 dark:border-gray-700 p-4 sm:p-6 lg:p-8">
                <div class="flex flex-col lg:flex-row lg:justify-between lg:items-center gap-4">
                    <div class="flex-1">
                        <div class="flex items-center gap-3 mb-3">
                            <div class="w-10 h-10 sm:w-12 sm:h-12 bg-gradient-to-br from-orange-500 to-yellow-600 rounded-xl flex items-center justify-center shadow-lg">
                                <svg class="w-5 h-5 sm:w-6 sm:h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                </svg>
                            </div>
        <div>
                                <h1 class="text-xl sm:text-2xl lg:text-3xl font-bold bg-gradient-to-r from-orange-600 via-yellow-600 to-amber-600 bg-clip-text text-transparent dark:from-orange-400 dark:via-yellow-400 dark:to-amber-400">
                                    Edit Partner Profile
                                </h1>
        </div>
    </div>

                        <!-- Quick Info -->
                        <div class="flex flex-wrap gap-2 sm:gap-3 mt-3">
                            <div class="flex items-center gap-2 px-2 py-1 bg-orange-50 dark:bg-orange-900/20 rounded-lg border border-orange-200 dark:border-orange-800">
                                <svg class="w-3 h-3 text-orange-600 dark:text-orange-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                </svg>
                                <span class="text-xs font-medium text-orange-700 dark:text-orange-300">Update Institute Information</span>
                            </div>
                            <div class="flex items-center gap-2 px-2 py-1 bg-green-50 dark:bg-green-900/20 rounded-lg border border-green-200 dark:border-green-800">
                                <svg class="w-3 h-3 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <span class="text-xs font-medium text-green-700 dark:text-green-300">Today: {{ date('M j, Y') }}</span>
                            </div>
                        </div>
        </div>
        
                    <!-- Action Buttons -->
                    <div class="flex flex-col sm:flex-row gap-2 lg:ml-6">
                        <a href="{{ route('partner.profile.show-partnar') }}" 
                           class="inline-flex items-center justify-center px-4 py-2 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm hover:shadow-md transition-all duration-200 text-sm font-semibold text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-600 min-h-[40px] touch-manipulation group">
                            <svg class="w-4 h-4 mr-2 text-gray-500 group-hover:text-gray-700 dark:text-gray-400 dark:group-hover:text-gray-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                            </svg>
                            Back to Profile
                        </a>
                        <button type="submit" form="profile-form" 
                                class="inline-flex items-center justify-center px-4 py-2 bg-gradient-to-r from-orange-600 to-yellow-600 hover:from-orange-700 hover:to-yellow-700 text-white rounded-lg shadow-lg hover:shadow-xl transition-all duration-200 text-sm font-semibold min-h-[40px] touch-manipulation group transform hover:scale-105">
                            <svg class="w-4 h-4 mr-2 group-hover:scale-110 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            Save Changes
                        </button>
                    </div>
                </div>
            </div>
                </div>

        <!-- Main Form Container -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl border border-gray-200 dark:border-gray-700 overflow-hidden">
            <form id="profile-form" action="{{ route('partner.profile.updatePartner') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf
                @method('PUT')
                
                {{-- Basic Information Section --}}
                <div class="border-b border-gray-200 dark:border-gray-700">
                    <div class="bg-gradient-to-r from-orange-50 to-yellow-50 dark:from-orange-900/20 dark:to-yellow-900/20 p-4 border-b border-gray-200 dark:border-gray-700">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 bg-gradient-to-br from-orange-500 to-yellow-500 rounded-lg flex items-center justify-center shadow-sm">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                <div>
                                <h3 class="text-lg font-bold text-gray-900 dark:text-white">Basic Information</h3>
                                <p class="text-sm text-gray-600 dark:text-gray-400">Essential institute details and contact information</p>
                            </div>
                        </div>
                </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 p-6">
                        {{-- Institute Name (English) --}}
                        <div class="relative">
                            <input type="text" name="name" value="{{ old('name', $partner->name) }}" required
                                   class="peer w-full px-3 py-3 text-sm border-2 border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 focus:border-orange-500 focus:ring-2 focus:ring-orange-500/20 transition-all duration-200 placeholder-transparent"
                                   placeholder="Institute Name">
                            <label class="absolute -top-2.5 left-3 px-1 bg-white dark:bg-gray-800 text-xs font-semibold text-gray-600 dark:text-gray-400 transition-all duration-200 peer-placeholder-shown:text-sm peer-placeholder-shown:text-gray-500 peer-placeholder-shown:top-3 peer-focus:-top-2.5 peer-focus:text-xs peer-focus:text-orange-600">
                                Institute Name *
                    </label>
                            @error('name')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                        {{-- Official Institute Name --}}
                        <div class="relative">
                            <input type="text" name="institute_name" value="{{ old('institute_name', $partner->institute_name) }}"
                                   class="peer w-full px-3 py-3 text-sm border-2 border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 focus:border-orange-500 focus:ring-2 focus:ring-orange-500/20 transition-all duration-200 placeholder-transparent"
                                   placeholder="Official/Legal Name">
                            <label class="absolute -top-2.5 left-3 px-1 bg-white dark:bg-gray-800 text-xs font-semibold text-gray-600 dark:text-gray-400 transition-all duration-200 peer-placeholder-shown:text-sm peer-placeholder-shown:text-gray-500 peer-placeholder-shown:top-3 peer-focus:-top-2.5 peer-focus:text-xs peer-focus:text-orange-600">
                                Official Institute Name
                    </label>
            </div>

                        {{-- Institute Name (Bangla) --}}
                        <div class="relative">
                            <input type="text" name="institute_name_bangla" value="{{ old('institute_name_bangla', $partner->institute_name_bangla) }}"
                                   class="peer w-full px-3 py-3 text-sm border-2 border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 focus:border-orange-500 focus:ring-2 focus:ring-orange-500/20 transition-all duration-200 placeholder-transparent"
                                   placeholder="ইনস্টিটিউট নাম">
                            <label class="absolute -top-2.5 left-3 px-1 bg-white dark:bg-gray-800 text-xs font-semibold text-gray-600 dark:text-gray-400 transition-all duration-200 peer-placeholder-shown:text-sm peer-placeholder-shown:text-gray-500 peer-placeholder-shown:top-3 peer-focus:-top-2.5 peer-focus:text-xs peer-focus:text-orange-600">
                                Institute Name (Bangla)
                </label>
            </div>

                        {{-- Email --}}
                        <div class="relative">
                            <input type="email" name="email" value="{{ old('email', $partner->email) }}" required
                                   class="peer w-full px-3 py-3 text-sm border-2 border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 focus:border-orange-500 focus:ring-2 focus:ring-orange-500/20 transition-all duration-200 placeholder-transparent"
                                   placeholder="email@example.com">
                            <label class="absolute -top-2.5 left-3 px-1 bg-white dark:bg-gray-800 text-xs font-semibold text-gray-600 dark:text-gray-400 transition-all duration-200 peer-placeholder-shown:text-sm peer-placeholder-shown:text-gray-500 peer-placeholder-shown:top-3 peer-focus:-top-2.5 peer-focus:text-xs peer-focus:text-orange-600">
                                Email *
                </label>
                            @error('email')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

                        {{-- Phone --}}
                        <div class="relative">
                            <input type="text" name="phone" value="{{ old('phone', $partner->phone) }}"
                                   class="peer w-full px-3 py-3 text-sm border-2 border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 focus:border-orange-500 focus:ring-2 focus:ring-orange-500/20 transition-all duration-200 placeholder-transparent"
                                   placeholder="01XXXXXXXXX">
                            <label class="absolute -top-2.5 left-3 px-1 bg-white dark:bg-gray-800 text-xs font-semibold text-gray-600 dark:text-gray-400 transition-all duration-200 peer-placeholder-shown:text-sm peer-placeholder-shown:text-gray-500 peer-placeholder-shown:top-3 peer-focus:-top-2.5 peer-focus:text-xs peer-focus:text-orange-600">
                                Phone
                        </label>
                    </div>

                        {{-- Mobile --}}
                        <div class="relative">
                            <input type="text" name="mobile" value="{{ old('mobile', $partner->mobile) }}"
                                   class="peer w-full px-3 py-3 text-sm border-2 border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 focus:border-orange-500 focus:ring-2 focus:ring-orange-500/20 transition-all duration-200 placeholder-transparent"
                                   placeholder="01XXXXXXXXX">
                            <label class="absolute -top-2.5 left-3 px-1 bg-white dark:bg-gray-800 text-xs font-semibold text-gray-600 dark:text-gray-400 transition-all duration-200 peer-placeholder-shown:text-sm peer-placeholder-shown:text-gray-500 peer-placeholder-shown:top-3 peer-focus:-top-2.5 peer-focus:text-xs peer-focus:text-orange-600">
                                Mobile
                        </label>
                    </div>

                        {{-- Website --}}
                        <div class="relative">
                            <input type="url" name="website" value="{{ old('website', $partner->website) }}"
                                   class="peer w-full px-3 py-3 text-sm border-2 border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 focus:border-orange-500 focus:ring-2 focus:ring-orange-500/20 transition-all duration-200 placeholder-transparent"
                                   placeholder="https://example.com">
                            <label class="absolute -top-2.5 left-3 px-1 bg-white dark:bg-gray-800 text-xs font-semibold text-gray-600 dark:text-gray-400 transition-all duration-200 peer-placeholder-shown:text-sm peer-placeholder-shown:text-gray-500 peer-placeholder-shown:top-3 peer-focus:-top-2.5 peer-focus:text-xs peer-focus:text-orange-600">
                            Website
                        </label>
                    </div>

                        {{-- Facebook Page --}}
                        <div class="relative">
                            <input type="url" name="facebook_page" value="{{ old('facebook_page', $partner->facebook_page) }}"
                                   class="peer w-full px-3 py-3 text-sm border-2 border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 focus:border-orange-500 focus:ring-2 focus:ring-orange-500/20 transition-all duration-200 placeholder-transparent"
                                   placeholder="https://facebook.com/yourpage">
                            <label class="absolute -top-2.5 left-3 px-1 bg-white dark:bg-gray-800 text-xs font-semibold text-gray-600 dark:text-gray-400 transition-all duration-200 peer-placeholder-shown:text-sm peer-placeholder-shown:text-gray-500 peer-placeholder-shown:top-3 peer-focus:-top-2.5 peer-focus:text-xs peer-focus:text-orange-600">
                            Facebook Page
                        </label>
                        </div>

                        {{-- Established Year --}}
                        <div class="relative">
                            <input type="number" name="established_year" value="{{ old('established_year', $partner->established_year) }}"
                                   class="peer w-full px-3 py-3 text-sm border-2 border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 focus:border-orange-500 focus:ring-2 focus:ring-orange-500/20 transition-all duration-200 placeholder-transparent"
                                   placeholder="2020" min="1900" max="{{ date('Y') }}">
                            <label class="absolute -top-2.5 left-3 px-1 bg-white dark:bg-gray-800 text-xs font-semibold text-gray-600 dark:text-gray-400 transition-all duration-200 peer-placeholder-shown:text-sm peer-placeholder-shown:text-gray-500 peer-placeholder-shown:top-3 peer-focus:-top-2.5 peer-focus:text-xs peer-focus:text-orange-600">
                                Established Year
                            </label>
                        </div>
                    </div>
                </div>

                {{-- Contact Persons Section --}}
                <div class="border-b border-gray-200 dark:border-gray-700">
                    <div class="bg-gradient-to-r from-orange-50 to-yellow-50 dark:from-orange-900/20 dark:to-yellow-900/20 p-4 border-b border-gray-200 dark:border-gray-700">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 bg-gradient-to-br from-orange-500 to-yellow-500 rounded-lg flex items-center justify-center shadow-sm">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                </svg>
            </div>
                    <div>
                                <h3 class="text-lg font-bold text-gray-900 dark:text-white">Contact Persons</h3>
                                <p class="text-sm text-gray-600 dark:text-gray-400">Primary and alternate contact information</p>
                            </div>
                    </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 p-6">
                        {{-- Owner/Director Name --}}
                        <div class="relative">
                            <input type="text" name="owner_director_name" value="{{ old('owner_director_name', $partner->owner_director_name) }}"
                                   class="peer w-full px-3 py-3 text-sm border-2 border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 focus:border-orange-500 focus:ring-2 focus:ring-orange-500/20 transition-all duration-200 placeholder-transparent"
                                   placeholder="Director Name">
                            <label class="absolute -top-2.5 left-3 px-1 bg-white dark:bg-gray-800 text-xs font-semibold text-gray-600 dark:text-gray-400 transition-all duration-200 peer-placeholder-shown:text-sm peer-placeholder-shown:text-gray-500 peer-placeholder-shown:top-3 peer-focus:-top-2.5 peer-focus:text-xs peer-focus:text-orange-600">
                                Owner/Director Name
                        </label>
                    </div>

                        {{-- Owner/Director's Contact --}}
                        <div class="relative">
                            <input type="text" name="owner_director_contact" value="{{ old('owner_director_contact', $partner->owner_director_contact) }}"
                                   class="peer w-full px-3 py-3 text-sm border-2 border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 focus:border-orange-500 focus:ring-2 focus:ring-orange-500/20 transition-all duration-200 placeholder-transparent"
                                   placeholder="01XXXXXXXXX">
                            <label class="absolute -top-2.5 left-3 px-1 bg-white dark:bg-gray-800 text-xs font-semibold text-gray-600 dark:text-gray-400 transition-all duration-200 peer-placeholder-shown:text-sm peer-placeholder-shown:text-gray-500 peer-placeholder-shown:top-3 peer-focus:-top-2.5 peer-focus:text-xs peer-focus:text-orange-600">
                                Owner/Director's Contact
                        </label>
                    </div>

                        {{-- Alternate Contact Person --}}
                        <div class="relative">
                            <input type="text" name="alternate_contact_person" value="{{ old('alternate_contact_person', $partner->alternate_contact_person) }}"
                                   class="peer w-full px-3 py-3 text-sm border-2 border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 focus:border-orange-500 focus:ring-2 focus:ring-orange-500/20 transition-all duration-200 placeholder-transparent"
                                   placeholder="Jane Smith">
                            <label class="absolute -top-2.5 left-3 px-1 bg-white dark:bg-gray-800 text-xs font-semibold text-gray-600 dark:text-gray-400 transition-all duration-200 peer-placeholder-shown:text-sm peer-placeholder-shown:text-gray-500 peer-placeholder-shown:top-3 peer-focus:-top-2.5 peer-focus:text-xs peer-focus:text-orange-600">
                                Alternate Contact Person
                        </label>
                    </div>

                        {{-- Alternate Contact No --}}
                        <div class="relative">
                            <input type="text" name="alternate_contact_no" value="{{ old('alternate_contact_no', $partner->alternate_contact_no) }}"
                                   class="peer w-full px-3 py-3 text-sm border-2 border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 focus:border-orange-500 focus:ring-2 focus:ring-orange-500/20 transition-all duration-200 placeholder-transparent"
                                   placeholder="01XXXXXXXXX">
                            <label class="absolute -top-2.5 left-3 px-1 bg-white dark:bg-gray-800 text-xs font-semibold text-gray-600 dark:text-gray-400 transition-all duration-200 peer-placeholder-shown:text-sm peer-placeholder-shown:text-gray-500 peer-placeholder-shown:top-3 peer-focus:-top-2.5 peer-focus:text-xs peer-focus:text-orange-600">
                                Alternate Contact No
                        </label>
                    </div>


                    </div>
                </div>

                {{-- Location Information Section --}}
                <div class="border-b border-gray-200 dark:border-gray-700">
                    <div class="bg-gradient-to-r from-orange-50 to-yellow-50 dark:from-orange-900/20 dark:to-yellow-900/20 p-4 border-b border-gray-200 dark:border-gray-700">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 bg-gradient-to-br from-orange-500 to-yellow-500 rounded-lg flex items-center justify-center shadow-sm">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
            </div>
                    <div>
                                <h3 class="text-lg font-bold text-gray-900 dark:text-white">Location Information</h3>
                                <p class="text-sm text-gray-600 dark:text-gray-400">Complete address and location details</p>
                    </div>
                    </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 p-6">
                        {{-- Division --}}
                        <div class="relative">
                            <select name="division" id="division" 
                                    class="peer w-full px-3 py-3 text-sm border-2 border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 focus:border-orange-500 focus:ring-2 focus:ring-orange-500/20 transition-all duration-200">
                                <option value="">Select Division</option>
                                @foreach($divisions as $division)
                                    <option value="{{ $division->id }}" 
                                            {{ old('division', $currentDivisionId) == $division->id ? 'selected' : '' }}>
                                        {{ $division->display_name }}
                                    </option>
                                @endforeach
                            </select>
                            <label class="absolute -top-2.5 left-3 px-1 bg-white dark:bg-gray-800 text-xs font-semibold text-gray-600 dark:text-gray-400 transition-all duration-200">
                            Division
                        </label>
                    </div>

                        {{-- District --}}
                        <div class="relative">
                            <select name="district" id="district" 
                                    class="peer w-full px-3 py-3 text-sm border-2 border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 focus:border-orange-500 focus:ring-2 focus:ring-orange-500/20 transition-all duration-200">
                                <option value="">Select District</option>
                            </select>
                            <label class="absolute -top-2.5 left-3 px-1 bg-white dark:bg-gray-800 text-xs font-semibold text-gray-600 dark:text-gray-400 transition-all duration-200">
                            District
                        </label>
                    </div>

                        {{-- Upazila --}}
                        <div class="relative">
                            <select name="upazila" id="upazila" 
                                    class="peer w-full px-3 py-3 text-sm border-2 border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 focus:border-orange-500 focus:ring-2 focus:ring-orange-500/20 transition-all duration-200">
                                <option value="">Select Upazila</option>
                            </select>
                            <label class="absolute -top-2.5 left-3 px-1 bg-white dark:bg-gray-800 text-xs font-semibold text-gray-600 dark:text-gray-400 transition-all duration-200">
                            Upazila
                        </label>
                        </div>

                        {{-- City --}}
                        <div class="relative">
                            <input type="text" name="city" value="{{ old('city', $partner->city) }}"
                                   class="peer w-full px-3 py-3 text-sm border-2 border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 focus:border-orange-500 focus:ring-2 focus:ring-orange-500/20 transition-all duration-200 placeholder-transparent"
                                   placeholder="Dhaka">
                            <label class="absolute -top-2.5 left-3 px-1 bg-white dark:bg-gray-800 text-xs font-semibold text-gray-600 dark:text-gray-400 transition-all duration-200 peer-placeholder-shown:text-sm peer-placeholder-shown:text-gray-500 peer-placeholder-shown:top-3 peer-focus:-top-2.5 peer-focus:text-xs peer-focus:text-orange-600">
                                City
                            </label>
                    </div>

                        {{-- Post Office --}}
                        <div class="relative">
                            <input type="text" name="post_office" value="{{ old('post_office', $partner->post_office) }}"
                                   class="peer w-full px-3 py-3 text-sm border-2 border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 focus:border-orange-500 focus:ring-2 focus:ring-orange-500/20 transition-all duration-200 placeholder-transparent"
                                   placeholder="Dhanmondi">
                            <label class="absolute -top-2.5 left-3 px-1 bg-white dark:bg-gray-800 text-xs font-semibold text-gray-600 dark:text-gray-400 transition-all duration-200 peer-placeholder-shown:text-sm peer-placeholder-shown:text-gray-500 peer-placeholder-shown:top-3 peer-focus:-top-2.5 peer-focus:text-xs peer-focus:text-orange-600">
                            Post Office
                        </label>
                    </div>

                        {{-- Post Code --}}
                        <div class="relative">
                            <input type="text" name="post_code" value="{{ old('post_code', $partner->post_code) }}"
                                   class="peer w-full px-3 py-3 text-sm border-2 border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 focus:border-orange-500 focus:ring-2 focus:ring-orange-500/20 transition-all duration-200 placeholder-transparent"
                                   placeholder="1205">
                            <label class="absolute -top-2.5 left-3 px-1 bg-white dark:bg-gray-800 text-xs font-semibold text-gray-600 dark:text-gray-400 transition-all duration-200 peer-placeholder-shown:text-sm peer-placeholder-shown:text-gray-500 peer-placeholder-shown:top-3 peer-focus:-top-2.5 peer-focus:text-xs peer-focus:text-orange-600">
                            Post Code
                        </label>
                    </div>

                        {{-- Village/Road No --}}
                        <div class="relative">
                            <input type="text" name="village_road_no" value="{{ old('village_road_no', $partner->village_road_no) }}"
                                   class="peer w-full px-3 py-3 text-sm border-2 border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 focus:border-orange-500 focus:ring-2 focus:ring-orange-500/20 transition-all duration-200 placeholder-transparent"
                                   placeholder="Road 7, House 15">
                            <label class="absolute -top-2.5 left-3 px-1 bg-white dark:bg-gray-800 text-xs font-semibold text-gray-600 dark:text-gray-400 transition-all duration-200 peer-placeholder-shown:text-sm peer-placeholder-shown:text-gray-500 peer-placeholder-shown:top-3 peer-focus:-top-2.5 peer-focus:text-xs peer-focus:text-orange-600">
                            Village/Road No
                        </label>
                    </div>

                        {{-- Flat/House No --}}
                        <div class="relative">
                            <input type="text" name="flat_house_no" value="{{ old('flat_house_no', $partner->flat_house_no) }}"
                                   class="peer w-full px-3 py-3 text-sm border-2 border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 focus:border-orange-500 focus:ring-2 focus:ring-orange-500/20 transition-all duration-200 placeholder-transparent"
                                   placeholder="Flat 5A">
                            <label class="absolute -top-2.5 left-3 px-1 bg-white dark:bg-gray-800 text-xs font-semibold text-gray-600 dark:text-gray-400 transition-all duration-200 peer-placeholder-shown:text-sm peer-placeholder-shown:text-gray-500 peer-placeholder-shown:top-3 peer-focus:-top-2.5 peer-focus:text-xs peer-focus:text-orange-600">
                            Flat/House No
                        </label>
            </div>

                        {{-- Map Location --}}
                        <div class="relative">
                            <input type="url" name="map_location" value="{{ old('map_location', $partner->map_location) }}"
                                   class="peer w-full px-3 py-3 text-sm border-2 border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 focus:border-orange-500 focus:ring-2 focus:ring-orange-500/20 transition-all duration-200 placeholder-transparent"
                                   placeholder="https://maps.google.com/...">
                            <label class="absolute -top-2.5 left-3 px-1 bg-white dark:bg-gray-800 text-xs font-semibold text-gray-600 dark:text-gray-400 transition-all duration-200 peer-placeholder-shown:text-sm peer-placeholder-shown:text-gray-500 peer-placeholder-shown:top-3 peer-focus:-top-2.5 peer-focus:text-xs peer-focus:text-orange-600">
                                Map Location
                        </label>
                    </div>
                    </div>
                </div>

                {{-- Institute Details Section --}}
                <div class="border-b border-gray-200 dark:border-gray-700">
                    <div class="bg-gradient-to-r from-orange-50 to-yellow-50 dark:from-orange-900/20 dark:to-yellow-900/20 p-4 border-b border-gray-200 dark:border-gray-700">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 bg-gradient-to-br from-orange-500 to-yellow-500 rounded-lg flex items-center justify-center shadow-sm">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                </svg>
            </div>
                    <div>
                                <h3 class="text-lg font-bold text-gray-900 dark:text-white">Institute Details</h3>
                                <p class="text-sm text-gray-600 dark:text-gray-400">Additional institute information and credentials</p>
                    </div>
                    </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 p-6">


                        {{-- EIIN No --}}
                        <div class="relative">
                            <input type="text" name="eiin_no" value="{{ old('eiin_no', $partner->eiin_no) }}"
                                   class="peer w-full px-3 py-3 text-sm border-2 border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 focus:border-orange-500 focus:ring-2 focus:ring-orange-500/20 transition-all duration-200 placeholder-transparent"
                                   placeholder="123456">
                            <label class="absolute -top-2.5 left-3 px-1 bg-white dark:bg-gray-800 text-xs font-semibold text-gray-600 dark:text-gray-400 transition-all duration-200 peer-placeholder-shown:text-sm peer-placeholder-shown:text-gray-500 peer-placeholder-shown:top-3 peer-focus:-top-2.5 peer-focus:text-xs peer-focus:text-orange-600">
                                EIIN No
                        </label>
                    </div>

                        {{-- Trade License No --}}
                        <div class="relative">
                            <input type="text" name="trade_license_no" value="{{ old('trade_license_no', $partner->trade_license_no) }}"
                                   class="peer w-full px-3 py-3 text-sm border-2 border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 focus:border-orange-500 focus:ring-2 focus:ring-orange-500/20 transition-all duration-200 placeholder-transparent"
                                   placeholder="TRD/2023/123456">
                            <label class="absolute -top-2.5 left-3 px-1 bg-white dark:bg-gray-800 text-xs font-semibold text-gray-600 dark:text-gray-400 transition-all duration-200 peer-placeholder-shown:text-sm peer-placeholder-shown:text-gray-500 peer-placeholder-shown:top-3 peer-focus:-top-2.5 peer-focus:text-xs peer-focus:text-orange-600">
                                Trade License No
                        </label>
                    </div>

                        {{-- TIN No --}}
                        <div class="relative">
                            <input type="text" name="tin_no" value="{{ old('tin_no', $partner->tin_no) }}"
                                   class="peer w-full px-3 py-3 text-sm border-2 border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 focus:border-orange-500 focus:ring-2 focus:ring-orange-500/20 transition-all duration-200 placeholder-transparent"
                                   placeholder="123456789">
                            <label class="absolute -top-2.5 left-3 px-1 bg-white dark:bg-gray-800 text-xs font-semibold text-gray-600 dark:text-gray-400 transition-all duration-200 peer-placeholder-shown:text-sm peer-placeholder-shown:text-gray-500 peer-placeholder-shown:top-3 peer-focus:-top-2.5 peer-focus:text-xs peer-focus:text-orange-600">
                                TIN No
                        </label>
                    </div>

                    </div>
                </div>

                {{-- Additional Information Section --}}
                <div class="border-b border-gray-200 dark:border-gray-700">
                    <div class="bg-gradient-to-r from-orange-50 to-yellow-50 dark:from-orange-900/20 dark:to-yellow-900/20 p-4 border-b border-gray-200 dark:border-gray-700">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 bg-gradient-to-br from-orange-500 to-yellow-500 rounded-lg flex items-center justify-center shadow-sm">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
            </div>
                    <div>
                                <h3 class="text-lg font-bold text-gray-900 dark:text-white">Additional Information</h3>
                                <p class="text-sm text-gray-600 dark:text-gray-400">Slugs, addresses, and other details</p>
                            </div>
                    </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 p-6">
                        {{-- Slug --}}
                        <div class="relative">
                            <input type="text" name="slug" value="{{ old('slug', $partner->slug) }}"
                                   class="peer w-full px-3 py-3 text-sm border-2 border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 focus:border-orange-500 focus:ring-2 focus:ring-orange-500/20 transition-all duration-200 placeholder-transparent"
                                   placeholder="institution-slug">
                            <label class="absolute -top-2.5 left-3 px-1 bg-white dark:bg-gray-800 text-xs font-semibold text-gray-600 dark:text-gray-400 transition-all duration-200 peer-placeholder-shown:text-sm peer-placeholder-shown:text-gray-500 peer-placeholder-shown:top-3 peer-focus:-top-2.5 peer-focus:text-xs peer-focus:text-orange-600">
                                Slug
                        </label>
                </div>

                        {{-- Slug (Bangla) --}}
                        <div class="relative">
                            <input type="text" name="slug_bangla" value="{{ old('slug_bangla', $partner->slug_bangla) }}"
                                   class="peer w-full px-3 py-3 text-sm border-2 border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 focus:border-orange-500 focus:ring-2 focus:ring-orange-500/20 transition-all duration-200 placeholder-transparent"
                                   placeholder="ইনস্টিটিউট-স্লাগ">
                            <label class="absolute -top-2.5 left-3 px-1 bg-white dark:bg-gray-800 text-xs font-semibold text-gray-600 dark:text-gray-400 transition-all duration-200 peer-placeholder-shown:text-sm peer-placeholder-shown:text-gray-500 peer-placeholder-shown:top-3 peer-focus:-top-2.5 peer-focus:text-xs peer-focus:text-orange-600">
                                Slug (Bangla)
                    </label>
                </div>

                        {{-- Short Address --}}
                        <div class="relative">
                            <input type="text" name="short_address" value="{{ old('short_address', $partner->short_address) }}"
                                   class="peer w-full px-3 py-3 text-sm border-2 border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 focus:border-orange-500 focus:ring-2 focus:ring-orange-500/20 transition-all duration-200 placeholder-transparent"
                                   placeholder="Brief address for display">
                            <label class="absolute -top-2.5 left-3 px-1 bg-white dark:bg-gray-800 text-xs font-semibold text-gray-600 dark:text-gray-400 transition-all duration-200 peer-placeholder-shown:text-sm peer-placeholder-shown:text-gray-500 peer-placeholder-shown:top-3 peer-focus:-top-2.5 peer-focus:text-xs peer-focus:text-orange-600">
                                Short Address
                    </label>
            </div>

                        {{-- Short Address Bangla --}}
                        <div class="relative">
                            <input type="text" name="short_address_bangla" value="{{ old('short_address_bangla', $partner->short_address_bangla) }}"
                                   class="peer w-full px-3 py-3 text-sm border-2 border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 focus:border-orange-500 focus:ring-2 focus:ring-orange-500/20 transition-all duration-200 placeholder-transparent"
                                   placeholder="সংক্ষিপ্ত ঠিকানা">
                            <label class="absolute -top-2.5 left-3 px-1 bg-white dark:bg-gray-800 text-xs font-semibold text-gray-600 dark:text-gray-400 transition-all duration-200 peer-placeholder-shown:text-sm peer-placeholder-shown:text-gray-500 peer-placeholder-shown:top-3 peer-focus:-top-2.5 peer-focus:text-xs peer-focus:text-orange-600">
                                Short Address Bangla
                            </label>
                    </div>
                </div>
            </div>

                {{-- Images Section --}}
                <div class="border-b border-gray-200 dark:border-gray-700">
                    <div class="bg-gradient-to-r from-orange-50 to-yellow-50 dark:from-orange-900/20 dark:to-yellow-900/20 p-4 border-b border-gray-200 dark:border-gray-700">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 bg-gradient-to-br from-orange-500 to-yellow-500 rounded-lg flex items-center justify-center shadow-sm">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                    </div>
                    <div>
                                <h3 class="text-lg font-bold text-gray-900 dark:text-white">Images</h3>
                                <p class="text-sm text-gray-600 dark:text-gray-400">Logo and cover photo uploads</p>
                    </div>
                </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 p-6">
                        {{-- Logo Upload --}}
                        <div class="relative">
                            <div class="flex items-center space-x-3">
                                @if($partner && $partner->logo)
                                    <div class="w-16 h-16 rounded-lg overflow-hidden border-2 border-gray-200 dark:border-gray-600 flex items-center justify-center bg-gradient-to-br from-orange-500 to-yellow-500">
                                        <img src="{{ asset('uploads/' . $partner->logo) }}" alt="Current Logo" class="w-full h-full object-cover">
                                    </div>
                                @else
                                    <div class="w-16 h-16 rounded-lg overflow-hidden border-2 border-gray-200 dark:border-gray-600 flex items-center justify-center bg-gradient-to-br from-orange-500 to-yellow-500">
                                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                        </svg>
                                    </div>
                                @endif
                                <div class="flex-1">
                                    <input type="file" name="logo" accept="image/*" 
                                           class="block w-full text-sm text-gray-500 dark:text-gray-400 file:mr-4 file:py-2 file:px-3 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-orange-500 file:text-white hover:file:bg-orange-600 file:cursor-pointer">
                                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">PNG, JPG, GIF up to 2MB</p>
                    </div>
                </div>
                            <label class="absolute -top-2.5 left-3 px-1 bg-white dark:bg-gray-800 text-xs font-semibold text-gray-600 dark:text-gray-400">
                                Institution Logo
                    </label>
                </div>

                        {{-- Cover Photo Upload --}}
                        <div class="relative">
                            <div class="flex items-center space-x-3">
                                @if($partner && $partner->cover_photo)
                                    <div class="w-16 h-16 rounded-lg overflow-hidden border-2 border-gray-200 dark:border-gray-600 flex items-center justify-center bg-gradient-to-br from-orange-500 to-yellow-500">
                                        <img src="{{ asset('uploads/' . $partner->cover_photo) }}" alt="Current Cover" class="w-full h-full object-cover">
                                    </div>
                                @else
                                    <div class="w-16 h-16 rounded-lg overflow-hidden border-2 border-gray-200 dark:border-gray-600 flex items-center justify-center bg-gradient-to-br from-orange-500 to-yellow-500">
                                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                        </svg>
                </div>
                                @endif
                                <div class="flex-1">
                                    <input type="file" name="cover_photo" accept="image/*" 
                                           class="block w-full text-sm text-gray-500 dark:text-gray-400 file:mr-4 file:py-2 file:px-3 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-orange-500 file:text-white hover:file:bg-orange-600 file:cursor-pointer">
                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">PNG, JPG, GIF up to 2MB</p>
                </div>
                </div>
                            <label class="absolute -top-2.5 left-3 px-1 bg-white dark:bg-gray-800 text-xs font-semibold text-gray-600 dark:text-gray-400">
                                Cover Photo
                        </label>
                    </div>
                    </div>
                </div>

                {{-- Action Buttons --}}
                <div class="flex flex-col sm:flex-row gap-3 justify-end px-6 pb-6">
                <a href="{{ route('partner.profile.show-partnar') }}" 
                       class="inline-flex items-center justify-center px-6 py-3 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 rounded-xl shadow-sm hover:shadow-md hover:bg-gray-50 dark:hover:bg-gray-600 transition-all duration-200 font-semibold text-sm min-h-[44px]">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    Cancel
                </a>
                <button type="submit" 
                            class="inline-flex items-center justify-center px-6 py-3 bg-gradient-to-r from-orange-600 to-yellow-600 hover:from-orange-700 hover:to-yellow-700 text-white rounded-xl shadow-lg hover:shadow-xl transition-all duration-200 font-semibold text-sm min-h-[44px] transform hover:scale-105">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        Save Changes
                </button>
            </div>
        </form>
    </div>
</div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const divisionSelect = document.getElementById('division');
    const districtSelect = document.getElementById('district');
    const upazilaSelect = document.getElementById('upazila');

    // Function to clear and disable a select
    function clearSelect(select) {
        select.innerHTML = '<option value="">Select ' + select.name.charAt(0).toUpperCase() + select.name.slice(1) + '</option>';
        select.disabled = true;
    }

    // Function to populate a select with options
    function populateSelect(select, options, selectedValue = null) {
        select.innerHTML = '<option value="">Select ' + select.name.charAt(0).toUpperCase() + select.name.slice(1) + '</option>';
        
        options.forEach(option => {
            const optionElement = document.createElement('option');
            optionElement.value = option.id;
            optionElement.textContent = option.display_name || option.name;
            if (selectedValue && option.id == selectedValue) {
                optionElement.selected = true;
            }
            select.appendChild(optionElement);
        });
        
        select.disabled = false;
    }

    // Division change handler
    divisionSelect.addEventListener('change', function() {
        const divisionId = this.value;
        console.log('Division selected:', divisionId);
        
        // Clear district and upazila
        clearSelect(districtSelect);
        clearSelect(upazilaSelect);
        
        if (divisionId) {
            // Fetch districts for the selected division
            fetch(`/partner/divisions/${divisionId}/districts`)
                .then(response => response.json())
                .then(data => {
                    console.log('Districts loaded:', data.districts);
                    populateSelect(districtSelect, data.districts);
                })
                .catch(error => {
                    console.error('Error fetching districts:', error);
                });
        }
    });

    // District change handler
    districtSelect.addEventListener('change', function() {
        const districtId = this.value;
        console.log('District selected:', districtId);
        
        // Clear upazila
        clearSelect(upazilaSelect);
        
        if (districtId) {
            // Fetch upazilas for the selected district
            fetch(`/partner/districts/${districtId}/upazilas`)
                .then(response => response.json())
                .then(data => {
                    console.log('Upazilas loaded:', data.upazilas);
                    populateSelect(upazilaSelect, data.upazilas);
                })
                .catch(error => {
                    console.error('Error fetching upazilas:', error);
                });
        }
    });

    // Upazila change handler
    upazilaSelect.addEventListener('change', function() {
        const upazilaId = this.value;
        console.log('Upazila selected:', upazilaId);
    });

    // Initialize: If division is pre-selected, load districts
    if (divisionSelect.value) {
        divisionSelect.dispatchEvent(new Event('change'));
    }
    
    // Pre-populate cascading dropdowns if values exist
    const currentDivisionId = {{ $currentDivisionId ?? 'null' }};
    const currentDistrictId = {{ $currentDistrictId ?? 'null' }};
    const currentUpazilaId = {{ $currentUpazilaId ?? 'null' }};
    
    if (currentDivisionId) {
        // Set division first
        divisionSelect.value = currentDivisionId;
        
        // Load districts for the selected division
        fetch(`/partner/divisions/${currentDivisionId}/districts`)
            .then(response => response.json())
            .then(data => {
                console.log('Loading districts for pre-population:', data);
                clearSelect(districtSelect);
                data.districts.forEach(district => {
                    const option = document.createElement('option');
                    option.value = district.id;
                    option.textContent = district.display_name;
                    districtSelect.appendChild(option);
                });
                
                // Set district if we have one
                if (currentDistrictId) {
                    districtSelect.value = currentDistrictId;
                    
                    // Load upazilas for the selected district
                    fetch(`/partner/districts/${currentDistrictId}/upazilas`)
                        .then(response => response.json())
                        .then(data => {
                            console.log('Loading upazilas for pre-population:', data);
                            clearSelect(upazilaSelect);
                            data.upazilas.forEach(upazila => {
                                const option = document.createElement('option');
                                option.value = upazila.id;
                                option.textContent = upazila.display_name;
                                upazilaSelect.appendChild(option);
                            });
                            
                            // Set upazila if we have one
                            if (currentUpazilaId) {
                                upazilaSelect.value = currentUpazilaId;
                            }
                        })
                        .catch(error => console.error('Error loading upazilas:', error));
                }
            })
            .catch(error => console.error('Error loading districts:', error));
    }
});
</script>
@endpush
@endsection