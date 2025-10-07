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

            <!-- Additional Contact Information -->
            <div class="border-t border-gray-200 dark:border-gray-700 pt-6">
                <h4 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Additional Contact Information</h4>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="mobile" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Mobile Number
                        </label>
                        <input type="text" id="mobile" name="mobile"
                               value="{{ old('mobile', $partner->mobile ?? '') }}"
                               placeholder="01XXXXXXXXX"
                               class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-primaryGreen focus:border-transparent">
                        @error('mobile')
                            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="alternate_mobile" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Alternate Mobile
                        </label>
                        <input type="text" id="alternate_mobile" name="alternate_mobile"
                               value="{{ old('alternate_mobile', $partner->alternate_mobile ?? '') }}"
                               placeholder="01XXXXXXXXX"
                               class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-primaryGreen focus:border-transparent">
                        @error('alternate_mobile')
                            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="website" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Website
                        </label>
                        <input type="url" id="website" name="website"
                               value="{{ old('website', $partner->website ?? '') }}"
                               placeholder="https://example.com"
                               class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-primaryGreen focus:border-transparent">
                        @error('website')
                            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="facebook_page" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Facebook Page
                        </label>
                        <input type="url" id="facebook_page" name="facebook_page"
                               value="{{ old('facebook_page', $partner->facebook_page ?? '') }}"
                               placeholder="https://facebook.com/..."
                               class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-primaryGreen focus:border-transparent">
                        @error('facebook_page')
                            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Additional Contact Information -->
            <div class="border-t border-gray-200 dark:border-gray-700 pt-6">
                <h4 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Additional Contact Information</h4>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="mobile" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Mobile Number
                        </label>
                        <input type="text" id="mobile" name="mobile"
                               value="{{ old('mobile', $partner->mobile ?? '') }}"
                               placeholder="01XXXXXXXXX"
                               class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-primaryGreen focus:border-transparent">
                        @error('mobile')
                            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="alternate_mobile" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Alternate Mobile
                        </label>
                        <input type="text" id="alternate_mobile" name="alternate_mobile"
                               value="{{ old('alternate_mobile', $partner->alternate_mobile ?? '') }}"
                               placeholder="01XXXXXXXXX"
                               class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-primaryGreen focus:border-transparent">
                        @error('alternate_mobile')
                            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="website" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Website
                        </label>
                        <input type="url" id="website" name="website"
                               value="{{ old('website', $partner->website ?? '') }}"
                               placeholder="https://example.com"
                               class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-primaryGreen focus:border-transparent">
                        @error('website')
                            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="facebook_page" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Facebook Page
                        </label>
                        <input type="url" id="facebook_page" name="facebook_page"
                               value="{{ old('facebook_page', $partner->facebook_page ?? '') }}"
                               placeholder="https://facebook.com/..."
                               class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-primaryGreen focus:border-transparent">
                        @error('facebook_page')
                            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Location Details -->
            <div class="border-t border-gray-200 dark:border-gray-700 pt-6">
                <h4 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Location Details</h4>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="division" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Division
                        </label>
                        <input type="text" id="division" name="division"
                               value="{{ old('division', $partner->division ?? '') }}"
                               class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-primaryGreen focus:border-transparent">
                        @error('division')
                            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="district" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            District
                        </label>
                        <input type="text" id="district" name="district"
                               value="{{ old('district', $partner->district ?? '') }}"
                               class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-primaryGreen focus:border-transparent">
                        @error('district')
                            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="upazila" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Upazila
                        </label>
                        <input type="text" id="upazila" name="upazila"
                               value="{{ old('upazila', $partner->upazila ?? '') }}"
                               class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-primaryGreen focus:border-transparent">
                        @error('upazila')
                            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="post_office" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Post Office
                        </label>
                        <input type="text" id="post_office" name="post_office"
                               value="{{ old('post_office', $partner->post_office ?? '') }}"
                               class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-primaryGreen focus:border-transparent">
                        @error('post_office')
                            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="post_code" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Post Code
                        </label>
                        <input type="text" id="post_code" name="post_code"
                               value="{{ old('post_code', $partner->post_code ?? '') }}"
                               class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-primaryGreen focus:border-transparent">
                        @error('post_code')
                            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="village_road_no" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Village/Road No
                        </label>
                        <input type="text" id="village_road_no" name="village_road_no"
                               value="{{ old('village_road_no', $partner->village_road_no ?? '') }}"
                               class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-primaryGreen focus:border-transparent">
                        @error('village_road_no')
                            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="flat_house_no" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Flat/House No
                        </label>
                        <input type="text" id="flat_house_no" name="flat_house_no"
                               value="{{ old('flat_house_no', $partner->flat_house_no ?? '') }}"
                               class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-primaryGreen focus:border-transparent">
                        @error('flat_house_no')
                            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Institution Details -->
            <div class="border-t border-gray-200 dark:border-gray-700 pt-6">
                <h4 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Institution Details</h4>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="institute_name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Institute Name
                        </label>
                        <input type="text" id="institute_name" name="institute_name"
                               value="{{ old('institute_name', $partner->institute_name ?? '') }}"
                               class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-primaryGreen focus:border-transparent">
                        @error('institute_name')
                            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="institute_name_bangla" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Institute Name (Bangla)
                        </label>
                        <input type="text" id="institute_name_bangla" name="institute_name_bangla"
                               value="{{ old('institute_name_bangla', $partner->institute_name_bangla ?? '') }}"
                               class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-primaryGreen focus:border-transparent">
                        @error('institute_name_bangla')
                            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="partner_category" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Partner Category
                        </label>
                        <input type="text" id="partner_category" name="partner_category"
                               value="{{ old('partner_category', $partner->partner_category ?? '') }}"
                               class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-primaryGreen focus:border-transparent">
                        @error('partner_category')
                            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="category" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Category
                        </label>
                        <input type="text" id="category" name="category"
                               value="{{ old('category', $partner->category ?? '') }}"
                               class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-primaryGreen focus:border-transparent">
                        @error('category')
                            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="established_year" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Established Year
                        </label>
                        <input type="number" id="established_year" name="established_year"
                               value="{{ old('established_year', $partner->established_year ?? '') }}"
                               min="1900" max="{{ date('Y') }}"
                               class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-primaryGreen focus:border-transparent">
                        @error('established_year')
                            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="year_of_establishment" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Year of Establishment
                        </label>
                        <input type="number" id="year_of_establishment" name="year_of_establishment"
                               value="{{ old('year_of_establishment', $partner->year_of_establishment ?? '') }}"
                               min="1900" max="{{ date('Y') }}"
                               class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-primaryGreen focus:border-transparent">
                        @error('year_of_establishment')
                            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Legal Information -->
            <div class="border-t border-gray-200 dark:border-gray-700 pt-6">
                <h4 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Legal Information</h4>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="eiin_no" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            EIIN Number
                        </label>
                        <input type="text" id="eiin_no" name="eiin_no"
                               value="{{ old('eiin_no', $partner->eiin_no ?? '') }}"
                               class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-primaryGreen focus:border-transparent">
                        @error('eiin_no')
                            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="trade_license_no" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Trade License Number
                        </label>
                        <input type="text" id="trade_license_no" name="trade_license_no"
                               value="{{ old('trade_license_no', $partner->trade_license_no ?? '') }}"
                               class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-primaryGreen focus:border-transparent">
                        @error('trade_license_no')
                            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="tin_no" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            TIN Number
                        </label>
                        <input type="text" id="tin_no" name="tin_no"
                               value="{{ old('tin_no', $partner->tin_no ?? '') }}"
                               class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-primaryGreen focus:border-transparent">
                        @error('tin_no')
                            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Contact Persons -->
            <div class="border-t border-gray-200 dark:border-gray-700 pt-6">
                <h4 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Contact Persons</h4>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="owner_name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Owner Name
                        </label>
                        <input type="text" id="owner_name" name="owner_name"
                               value="{{ old('owner_name', $partner->owner_name ?? '') }}"
                               class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-primaryGreen focus:border-transparent">
                        @error('owner_name')
                            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="owner_director_name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Owner/Director Name
                        </label>
                        <input type="text" id="owner_director_name" name="owner_director_name"
                               value="{{ old('owner_director_name', $partner->owner_director_name ?? '') }}"
                               class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-primaryGreen focus:border-transparent">
                        @error('owner_director_name')
                            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="primary_contact_person" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Primary Contact Person
                        </label>
                        <input type="text" id="primary_contact_person" name="primary_contact_person"
                               value="{{ old('primary_contact_person', $partner->primary_contact_person ?? '') }}"
                               class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-primaryGreen focus:border-transparent">
                        @error('primary_contact_person')
                            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="primary_contact_no" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Primary Contact Number
                        </label>
                        <input type="text" id="primary_contact_no" name="primary_contact_no"
                               value="{{ old('primary_contact_no', $partner->primary_contact_no ?? '') }}"
                               placeholder="01XXXXXXXXX"
                               class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-primaryGreen focus:border-transparent">
                        @error('primary_contact_no')
                            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="alternate_contact_person" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Alternate Contact Person
                        </label>
                        <input type="text" id="alternate_contact_person" name="alternate_contact_person"
                               value="{{ old('alternate_contact_person', $partner->alternate_contact_person ?? '') }}"
                               class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-primaryGreen focus:border-transparent">
                        @error('alternate_contact_person')
                            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="alternate_contact_no" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Alternate Contact Number
                        </label>
                        <input type="text" id="alternate_contact_no" name="alternate_contact_no"
                               value="{{ old('alternate_contact_no', $partner->alternate_contact_no ?? '') }}"
                               placeholder="01XXXXXXXXX"
                               class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-primaryGreen focus:border-transparent">
                        @error('alternate_contact_no')
                            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Academic Information -->
            <div class="border-t border-gray-200 dark:border-gray-700 pt-6">
                <h4 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Academic Information</h4>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="target_group" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Target Group
                        </label>
                        <input type="text" id="target_group" name="target_group"
                               value="{{ old('target_group', $partner->target_group ?? '') }}"
                               class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-primaryGreen focus:border-transparent">
                        @error('target_group')
                            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="class_range" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Class Range
                        </label>
                        <input type="text" id="class_range" name="class_range"
                               value="{{ old('class_range', $partner->class_range ?? '') }}"
                               placeholder="e.g., Class 1-12"
                               class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-primaryGreen focus:border-transparent">
                        @error('class_range')
                            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>



                    <div>
                        <label for="total_students" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Total Students
                        </label>
                        <input type="number" id="total_students" name="total_students"
                               value="{{ old('total_students', $partner->total_students ?? '') }}"
                               min="0"
                               class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-primaryGreen focus:border-transparent">
                        @error('total_students')
                            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="mt-6">
                    <label for="subjects_offered" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Subjects Offered
                    </label>
                    <textarea id="subjects_offered" name="subjects_offered" rows="3"
                              placeholder="e.g., Mathematics, Science, English, Bangla"
                              class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-primaryGreen focus:border-transparent">{{ old('subjects_offered', $partner->subjects_offered ?? '') }}</textarea>
                    @error('subjects_offered')
                        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mt-6">
                    <label for="custom_courses" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Custom Courses
                    </label>
                    <textarea id="custom_courses" name="custom_courses" rows="3"
                              placeholder="Describe any custom or specialized courses offered"
                              class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-primaryGreen focus:border-transparent">{{ old('custom_courses', $partner->custom_courses ?? '') }}</textarea>
                    @error('custom_courses')
                        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- System Settings -->
            <div class="border-t border-gray-200 dark:border-gray-700 pt-6">
                <h4 class="text-lg font-medium text-gray-900 dark:text-white mb-4">System Settings</h4>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="status" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Status
                        </label>
                        <select id="status" name="status"
                                class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-primaryGreen focus:border-transparent">
                            <option value="active" {{ old('status', $partner->status ?? '') == 'active' ? 'selected' : '' }}>Active</option>
                            <option value="inactive" {{ old('status', $partner->status ?? '') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                        </select>
                        @error('status')
                            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="batch_system" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Batch System
                        </label>
                        <div class="flex items-center">
                            <input type="checkbox" id="batch_system" name="batch_system" value="1"
                                   {{ old('batch_system', $partner->batch_system ?? false) ? 'checked' : '' }}
                                   class="h-4 w-4 text-primaryGreen focus:ring-primaryGreen border-gray-300 rounded">
                            <label for="batch_system" class="ml-2 text-sm text-gray-700 dark:text-gray-300">
                                Enable batch system for students
                            </label>
                        </div>
                        @error('batch_system')
                            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Additional Information -->
            <div class="border-t border-gray-200 dark:border-gray-700 pt-6">
                <h4 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Additional Information</h4>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="slug" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Slug
                        </label>
                        <input type="text" id="slug" name="slug"
                               value="{{ old('slug', $partner->slug ?? '') }}"
                               placeholder="institution-slug"
                               class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-primaryGreen focus:border-transparent">
                        @error('slug')
                            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="slug_bangla" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Slug (Bangla)
                        </label>
                        <input type="text" id="slug_bangla" name="slug_bangla"
                               value="{{ old('slug_bangla', $partner->slug_bangla ?? '') }}"
                               placeholder="institution-slug-bangla"
                               class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-primaryGreen focus:border-transparent">
                        @error('slug_bangla')
                            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="mt-6">
                    <label for="short_address" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Short Address
                    </label>
                    <textarea id="short_address" name="short_address" rows="2"
                              placeholder="Brief address summary"
                              class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-primaryGreen focus:border-transparent">{{ old('short_address', $partner->short_address ?? '') }}</textarea>
                    @error('short_address')
                        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mt-6">
                    <label for="map_location" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Map Location
                    </label>
                    <textarea id="map_location" name="map_location" rows="2"
                              placeholder="Google Maps coordinates or embed code"
                              class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-primaryGreen focus:border-transparent">{{ old('map_location', $partner->map_location ?? '') }}</textarea>
                    @error('map_location')
                        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>
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
