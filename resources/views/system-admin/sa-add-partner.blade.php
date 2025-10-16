@extends('layouts.system-admin-layout')

@section('title', 'Add Partner - System Admin')

@section('content')
<div class="min-h-screen bg-gray-50 dark:bg-gray-900">
    <!-- Header -->
    <div class="bg-white dark:bg-gray-800 shadow-sm border-b border-gray-200 dark:border-gray-700">
        <div class="px-4 sm:px-6 lg:px-8 py-4">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Add New Partner</h1>
                    <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">Create a new coaching center or partner account</p>
                </div>
                <div class="mt-4 sm:mt-0 flex space-x-3">
                    <button type="submit" 
                            form="partner-form"
                            class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white text-sm font-semibold rounded-lg transition-all duration-200 hover:shadow-lg transform hover:-translate-y-0.5">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        Create Partner
                    </button>
                    <a href="{{ route('system-admin.all-partners') }}" 
                       class="inline-flex items-center px-4 py-2 bg-white/80 dark:bg-slate-700/80 hover:bg-white dark:hover:bg-slate-700 border border-slate-200 dark:border-slate-600 rounded-lg text-sm font-semibold text-slate-700 dark:text-slate-300 transition-all duration-200 hover:shadow-md">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                        Cancel & Back
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Form -->
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <form id="partner-form" action="{{ route('system-admin.store-partner') }}" method="POST" class="space-y-8">
            @csrf
            
            <!-- Basic Information -->
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
                <div class="flex items-center mb-6">
                    <div class="w-10 h-10 bg-blue-100 dark:bg-blue-900/20 rounded-lg flex items-center justify-center mr-4">
                        <svg class="w-5 h-5 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <h2 class="text-xl font-semibold text-gray-900 dark:text-white">Basic Information</h2>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Institute Name -->
                    <div>
                        <label for="institute_name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Institute Name <span class="text-red-500">*</span>
                        </label>
                        <input type="text" 
                               id="institute_name" 
                               name="institute_name" 
                               value="{{ old('institute_name') }}"
                               class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white transition-colors duration-200"
                               placeholder="Enter institute name"
                               required>
                        @error('institute_name')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Institute Name (Bangla) -->
                    <div>
                        <label for="institute_name_bangla" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Institute Name (Bangla)
                        </label>
                        <input type="text" 
                               id="institute_name_bangla" 
                               name="institute_name_bangla" 
                               value="{{ old('institute_name_bangla') }}"
                               class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white transition-colors duration-200"
                               placeholder="Enter institute name in Bangla">
                        @error('institute_name_bangla')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Primary Contact Person -->
                    <div>
                        <label for="primary_contact_person" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Primary Contact Person <span class="text-red-500">*</span>
                        </label>
                        <input type="text" 
                               id="primary_contact_person" 
                               name="primary_contact_person" 
                               value="{{ old('primary_contact_person') }}"
                               class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white transition-colors duration-200"
                               placeholder="Enter primary contact person name"
                               required>
                        @error('primary_contact_person')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Primary Contact Number -->
                    <div>
                        <label for="primary_contact_no" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Primary Contact Number <span class="text-red-500">*</span>
                        </label>
                        <input type="tel" 
                               id="primary_contact_no" 
                               name="primary_contact_no" 
                               value="{{ old('primary_contact_no') }}"
                               class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white transition-colors duration-200"
                               placeholder="Enter primary contact number"
                               required>
                        @error('primary_contact_no')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Email -->
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Email Address <span class="text-red-500">*</span>
                        </label>
                        <input type="email" 
                               id="email" 
                               name="email" 
                               value="{{ old('email') }}"
                               class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white transition-colors duration-200"
                               placeholder="Enter email address"
                               required>
                        @error('email')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Year of Establishment -->
                    <div>
                        <label for="year_of_establishment" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Year of Establishment
                        </label>
                        <input type="number" 
                               id="year_of_establishment" 
                               name="year_of_establishment" 
                               value="{{ old('year_of_establishment') }}"
                               min="1900" 
                               max="{{ date('Y') }}"
                               class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white transition-colors duration-200"
                               placeholder="Enter establishment year">
                        @error('year_of_establishment')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Contact Information -->
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
                <div class="flex items-center mb-6">
                    <div class="w-10 h-10 bg-green-100 dark:bg-green-900/20 rounded-lg flex items-center justify-center mr-4">
                        <svg class="w-5 h-5 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                        </svg>
                    </div>
                    <h2 class="text-xl font-semibold text-gray-900 dark:text-white">Contact Information</h2>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Mobile -->
                    <div>
                        <label for="mobile" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Mobile Number
                        </label>
                        <input type="tel" 
                               id="mobile" 
                               name="mobile" 
                               value="{{ old('mobile') }}"
                               class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white transition-colors duration-200"
                               placeholder="Enter mobile number">
                        @error('mobile')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Alternate Mobile -->
                    <div>
                        <label for="alternate_mobile" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Alternate Mobile
                        </label>
                        <input type="tel" 
                               id="alternate_mobile" 
                               name="alternate_mobile" 
                               value="{{ old('alternate_mobile') }}"
                               class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white transition-colors duration-200"
                               placeholder="Enter alternate mobile number">
                        @error('alternate_mobile')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Website -->
                    <div>
                        <label for="website" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Website
                        </label>
                        <input type="url" 
                               id="website" 
                               name="website" 
                               value="{{ old('website') }}"
                               class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white transition-colors duration-200"
                               placeholder="Enter website URL">
                        @error('website')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Facebook Page -->
                    <div>
                        <label for="facebook_page" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Facebook Page
                        </label>
                        <input type="url" 
                               id="facebook_page" 
                               name="facebook_page" 
                               value="{{ old('facebook_page') }}"
                               class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white transition-colors duration-200"
                               placeholder="Enter Facebook page URL">
                        @error('facebook_page')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Address Information -->
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
                <div class="flex items-center mb-6">
                    <div class="w-10 h-10 bg-purple-100 dark:bg-purple-900/20 rounded-lg flex items-center justify-center mr-4">
                        <svg class="w-5 h-5 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                    </div>
                    <h2 class="text-xl font-semibold text-gray-900 dark:text-white">Address Information</h2>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Division -->
                    <div>
                        <label for="division_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Division <span class="text-red-500">*</span>
                        </label>
                        <select id="division_id" 
                                name="division_id" 
                                class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white transition-colors duration-200"
                                required>
                            <option value="">Select Division</option>
                            @foreach(\App\Models\Division::active()->ordered()->get() as $division)
                                <option value="{{ $division->id }}" {{ old('division_id') == $division->id ? 'selected' : '' }}>
                                    {{ $division->name }} @if($division->name_bangla) ({{ $division->name_bangla }}) @endif
                                </option>
                            @endforeach
                        </select>
                        @error('division_id')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- District -->
                    <div>
                        <label for="district_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            District <span class="text-red-500">*</span>
                        </label>
                        <select id="district_id" 
                                name="district_id" 
                                class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white transition-colors duration-200"
                                disabled>
                            <option value="">Select District</option>
                        </select>
                        @error('district_id')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Upazila/PS -->
                    <div>
                        <label for="upazila_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Upazila/PS <span class="text-red-500">*</span>
                        </label>
                        <select id="upazila_id" 
                                name="upazila_id" 
                                class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white transition-colors duration-200"
                                disabled>
                            <option value="">Select Upazila/PS</option>
                        </select>
                        @error('upazila_id')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Post Office -->
                    <div>
                        <label for="post_office" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Post Office
                        </label>
                        <input type="text" 
                               id="post_office" 
                               name="post_office" 
                               value="{{ old('post_office') }}"
                               class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white transition-colors duration-200"
                               placeholder="Enter post office">
                        @error('post_office')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Post Code -->
                    <div>
                        <label for="post_code" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Post Code
                        </label>
                        <input type="text" 
                               id="post_code" 
                               name="post_code" 
                               value="{{ old('post_code') }}"
                               class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white transition-colors duration-200"
                               placeholder="Enter post code">
                        @error('post_code')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Village/Road No -->
                    <div>
                        <label for="village_road_no" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Village/Road No
                        </label>
                        <input type="text" 
                               id="village_road_no" 
                               name="village_road_no" 
                               value="{{ old('village_road_no') }}"
                               class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white transition-colors duration-200"
                               placeholder="Enter village/road number">
                        @error('village_road_no')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Flat/House No -->
                    <div>
                        <label for="flat_house_no" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Flat/House No
                        </label>
                        <input type="text" 
                               id="flat_house_no" 
                               name="flat_house_no" 
                               value="{{ old('flat_house_no') }}"
                               class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white transition-colors duration-200"
                               placeholder="Enter flat/house number">
                        @error('flat_house_no')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Business Information -->
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
                <div class="flex items-center mb-6">
                    <div class="w-10 h-10 bg-orange-100 dark:bg-orange-900/20 rounded-lg flex items-center justify-center mr-4">
                        <svg class="w-5 h-5 text-orange-600 dark:text-orange-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                        </svg>
                    </div>
                    <h2 class="text-xl font-semibold text-gray-900 dark:text-white">Business Information</h2>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Subscription Plan -->
                    <div>
                        <label for="subscription_plan" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Subscription Plan <span class="text-red-500">*</span>
                        </label>
                        <select id="subscription_plan" 
                                name="subscription_plan" 
                                class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white transition-colors duration-200"
                                required>
                            <option value="">Select Plan</option>
                            <option value="free" {{ old('subscription_plan') == 'free' ? 'selected' : '' }}>Free</option>
                            <option value="basic" {{ old('subscription_plan') == 'basic' ? 'selected' : '' }}>Basic</option>
                            <option value="premium" {{ old('subscription_plan') == 'premium' ? 'selected' : '' }}>Premium</option>
                            <option value="enterprise" {{ old('subscription_plan') == 'enterprise' ? 'selected' : '' }}>Enterprise</option>
                        </select>
                        @error('subscription_plan')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Status -->
                    <div>
                        <label for="status" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Status <span class="text-red-500">*</span>
                        </label>
                        <select id="status" 
                                name="status" 
                                class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white transition-colors duration-200"
                                required>
                            <option value="">Select Status</option>
                            <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>Active</option>
                            <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                            <option value="pending" {{ old('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                        </select>
                        @error('status')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                </div>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Auto-generate slug from institute name
    const instituteNameInput = document.getElementById('institute_name');
    const slugInput = document.getElementById('slug');
    
    if (instituteNameInput && slugInput) {
        instituteNameInput.addEventListener('input', function() {
            const slug = this.value
                .toLowerCase()
                .replace(/[^a-z0-9\s-]/g, '')
                .replace(/\s+/g, '-')
                .replace(/-+/g, '-')
                .trim('-');
            slugInput.value = slug;
        });
    }

    // Cascading dropdown functionality
    const divisionSelect = document.getElementById('division_id');
    const districtSelect = document.getElementById('district_id');
    const upazilaSelect = document.getElementById('upazila_id');

    // Division change handler
    divisionSelect.addEventListener('change', function() {
        const divisionId = this.value;
        
        // Reset district and upazila
        districtSelect.innerHTML = '<option value="">Select District</option>';
        upazilaSelect.innerHTML = '<option value="">Select Upazila/PS</option>';
        
        if (divisionId) {
            // Enable district select
            districtSelect.disabled = false;
            
            // Fetch districts
            fetch(`/system-admin/api/districts/${divisionId}`)
                .then(response => response.json())
                .then(data => {
                    data.forEach(district => {
                        const option = document.createElement('option');
                        option.value = district.id;
                        option.textContent = district.name + (district.name_bangla ? ` (${district.name_bangla})` : '');
                        districtSelect.appendChild(option);
                    });
                })
                .catch(error => {
                    console.error('Error fetching districts:', error);
                });
        } else {
            districtSelect.disabled = true;
            upazilaSelect.disabled = true;
        }
    });

    // District change handler
    districtSelect.addEventListener('change', function() {
        const districtId = this.value;
        
        // Reset upazila
        upazilaSelect.innerHTML = '<option value="">Select Upazila/PS</option>';
        
        if (districtId) {
            // Enable upazila select
            upazilaSelect.disabled = false;
            
            // Fetch upazilas
            fetch(`/system-admin/api/upazilas/${districtId}`)
                .then(response => response.json())
                .then(data => {
                    data.forEach(upazila => {
                        const option = document.createElement('option');
                        option.value = upazila.id;
                        option.textContent = upazila.name + (upazila.name_bangla ? ` (${upazila.name_bangla})` : '');
                        upazilaSelect.appendChild(option);
                    });
                })
                .catch(error => {
                    console.error('Error fetching upazilas:', error);
                });
        } else {
            upazilaSelect.disabled = true;
        }
    });
});
</script>
@endpush

@endsection
