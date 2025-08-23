@extends('layouts.dashboard')

@section('title', 'Partner Profile')

@section('content')
<div class="space-y-6">
    <!-- Page Header -->
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md border border-gray-200 dark:border-gray-700">
        <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
                <div class="mb-4 sm:mb-0">
                    <h1 class="text-2xl font-bold text-gray-900 dark:text-white">
                        Partner Profile
                    </h1>
                    <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">
                        Manage your educational institution profile and showcase your services
                    </p>
                </div>
                <div class="flex space-x-3">
                    <a href="{{ route('partner.profile.edit') }}" 
                       class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-primaryGreen hover:bg-primaryGreen/90 rounded-lg shadow-sm hover:shadow-md transition-all duration-200">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                        </svg>
                        Edit Profile
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Hero Header Section -->
    <div class="relative">
        <div class="absolute inset-0 bg-gradient-to-r from-blue-600 via-purple-600 to-indigo-600 rounded-2xl shadow-lg"></div>
        <div class="relative px-6 py-8 text-center">
            <div class="flex flex-col lg:flex-row items-center justify-between">
                <div class="flex-1 text-center lg:text-left">
                    <h6 class="text-xl lg:text-3xl font-bold text-white mb-3">
                        @php
                            $hour = now()->hour;
                            $greeting = '';
                            if ($hour < 12) {
                                $greeting = 'Good Morning';
                            } elseif ($hour < 17) {
                                $greeting = 'Good Afternoon';
                            } else {
                                $greeting = 'Good Evening';
                            }
                            
                            $partnerName = $partner->user->name ?? $partner->institute_name ?? $partner->owner_name ?? 'Partner';
                            
                            // Helper function to get proper partner category display name
                            function getPartnerCategoryDisplayName($category) {
                                $categories = [
                                    'school' => 'School',
                                    'college' => 'College',
                                    'university' => 'University',
                                    'coaching_center' => 'Coaching Center',
                                    'training_institute' => 'Training Institute',
                                    'tutoring_service' => 'Tutoring Service',
                                    'home_tutor' => 'Home Tutor',
                                    'teacher' => 'Teacher',
                                    'online_education' => 'Online Education',
                                    'skill_development' => 'Skill Development Center',
                                    'language_center' => 'Language Center',
                                    'computer_training' => 'Computer Training Center',
                                    'other' => 'Other'
                                ];
                                
                                return $categories[$category] ?? $category;
                            }
                        @endphp
                        {{ $greeting }},<br>{{ $partnerName }}! 👋
                    </h6>
                    <p class="text-lg text-blue-100 mb-4 max-w-2xl">
                        @if($partner->institute_name)
                            Manage your {{ strtolower(getPartnerCategoryDisplayName($partner->partner_category) ?? 'educational institution') }} profile and showcase your services to students
                        @else
                            Complete your profile to start attracting students and growing your educational business
                        @endif
                    </p>
                    <div class="flex flex-wrap gap-2 justify-center lg:justify-start">
                        <span class="inline-flex items-center px-3 py-1.5 bg-white/20 backdrop-blur-sm rounded-full text-white text-sm font-medium">
                            🏫 {{ getPartnerCategoryDisplayName($partner->partner_category) ?? 'Educational Partner' }}
                        </span>
                        @if($partner->division)
                        <span class="inline-flex items-center px-3 py-1.5 bg-white/20 backdrop-blur-sm rounded-full text-white text-sm font-medium">
                            📍 {{ $partner->division }}
                            @if($partner->district)
                                , {{ $partner->district }}
                            @endif
                        </span>
                        @endif
                        <span class="inline-flex items-center px-3 py-1.5 bg-white/20 backdrop-blur-sm rounded-full text-white text-sm font-medium">
                            ✨ {{ ucfirst($partner->status ?? 'Active') }}
                        </span>
                        @if($partner->year_of_establishment || $partner->established_year)
                        <span class="inline-flex items-center px-3 py-1.5 bg-white/20 backdrop-blur-sm rounded-full text-white text-sm font-medium">
                            🏛️ Est. {{ $partner->year_of_establishment ?? $partner->established_year }}
                        </span>
                        @endif
                    </div>
                </div>
                <div class="mt-6 lg:mt-0">
                    <a href="{{ route('partner.profile.edit') }}" 
                       class="inline-flex items-center px-6 py-3 bg-white text-blue-600 font-bold rounded-xl shadow-xl hover:shadow-2xl transform hover:-translate-y-1 transition-all duration-300">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                        </svg>
                        Edit Profile
                    </a>
                </div>
            </div>
        </div>
    </div>

        

        <!-- Main Profile Content -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            
            <!-- Left Column - Profile Card -->
            <div class="lg:col-span-1">
                <div class="bg-white/80 dark:bg-gray-800/80 backdrop-blur-sm rounded-2xl border border-gray-200 dark:border-gray-700 shadow-xl hover:shadow-2xl transition-all duration-300 sticky top-8">
                    <div class="p-6">
                        <!-- Profile Picture -->
                        <div class="text-center mb-6">
                            <div class="relative inline-block">
                                <div class="w-32 h-32 rounded-full border-4 border-blue-200 dark:border-blue-700 overflow-hidden bg-gradient-to-br from-blue-100 to-purple-100 dark:from-blue-900 dark:to-purple-900 mx-auto">
                                    @if($partner->logo)
                                        <img src="{{ Storage::url($partner->logo) }}" alt="Partner Logo" class="w-full h-full object-cover">
                                    @else
                                        <div class="w-full h-full flex items-center justify-center">
                                            <svg class="w-16 h-16 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                            </svg>
                                        </div>
                                    @endif
                                </div>
                                <div class="absolute -bottom-2 -right-2 w-8 h-8 bg-green-500 rounded-full border-4 border-white dark:border-gray-800 flex items-center justify-center">
                                    <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                    </svg>
                                </div>
                            </div>
                            
                            <!-- Platinum Partner Badge -->
                            <div class="mt-4 mb-4">
                                <div class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-amber-400 via-yellow-300 to-amber-500 rounded-full shadow-lg transform hover:scale-105 transition-all duration-300 border-2 border-amber-200">
                                    <div class="flex items-center space-x-2">
                                        <svg class="w-5 h-5 text-amber-800" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                        </svg>
                                        <span class="text-sm font-bold text-amber-800 tracking-wide">PLATINUM PARTNER</span>
                                        <svg class="w-5 h-5 text-amber-800" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                        </svg>
                                    </div>
                                </div>
                            </div>
                            
                            <h2 class="text-2xl font-bold text-gray-900 dark:text-white mt-4">
                                {{ $partner->user->name ?? '' }}
                            </h2>
                            @if($partner->user->name && $partner->institute_name && $partner->user->name !== $partner->institute_name)
                                <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">{{ $partner->institute_name }}</p>
                            @endif
                            
                            <!-- Institute Name in Bangla -->
                            @if($partner->institute_name_bangla)
                                <p class="text-sm text-gray-500 dark:text-gray-400 mt-1 font-medium">{{ $partner->institute_name_bangla }}</p>
                            @endif
                        </div>

                        <!-- Quick Stats -->
                        <div class="space-y-3 mb-6">
                            <div class="flex items-center justify-between p-3 bg-blue-50 dark:bg-blue-900/20 rounded-xl border border-blue-200 dark:border-blue-800">
                                <span class="text-blue-700 dark:text-blue-300 font-medium">📅 Member Since</span>
                                <span class="font-semibold text-blue-900 dark:text-blue-100">{{ $partner->created_at->format('M Y') }}</span>
                            </div>
                            <div class="flex items-center justify-between p-3 bg-purple-50 dark:bg-purple-900/20 rounded-xl border border-purple-200 dark:border-purple-800">
                                <span class="text-purple-700 dark:text-purple-300 font-medium">🔄 Last Updated</span>
                                <span class="font-semibold text-purple-900 dark:text-purple-100">{{ $partner->updated_at->format('M d, Y') }}</span>
                            </div>
                            <div class="flex items-center justify-between p-3 bg-green-50 dark:bg-green-900/20 rounded-xl border border-green-200 dark:border-green-800">
                                <span class="text-green-700 dark:text-green-300 font-medium">📊 Status</span>
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                    @if($partner->status === 'active') bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200
                                    @elseif($partner->status === 'inactive') bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200
                                    @elseif($partner->status === 'pending') bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200
                                    @else bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200 @endif">
                                    {{ ucfirst($partner->status ?? 'Active') }}
                                </span>
                            </div>
                            @if($partner->year_of_establishment || $partner->established_year)
                            <div class="flex items-center justify-between p-3 bg-amber-50 dark:bg-amber-900/20 rounded-xl border border-amber-200 dark:border-amber-800">
                                <span class="text-amber-700 dark:text-amber-300 font-medium">🏛️ Established</span>
                                <span class="font-semibold text-amber-900 dark:text-amber-100">{{ $partner->year_of_establishment ?? $partner->established_year }}</span>
                            </div>
                            @endif
                        </div>

                        <!-- Contact Info -->
                        <div class="space-y-3">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-3">📞 Contact Information</h3>
                            @if($partner->mobile)
                            <div class="flex items-center space-x-3 p-3 bg-blue-50 dark:bg-blue-900/20 rounded-xl">
                                <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                                </svg>
                                <span class="text-gray-700 dark:text-gray-300">{{ $partner->mobile }}</span>
                            </div>
                            @endif
                            @if($partner->alternate_mobile)
                            <div class="flex items-center space-x-3 p-3 bg-green-50 dark:bg-green-900/20 rounded-xl">
                                <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                                </svg>
                                <span class="text-gray-700 dark:text-gray-300">{{ $partner->alternate_mobile }}</span>
                            </div>
                            @endif
                            @if($partner->website)
                            <div class="flex items-center space-x-3 p-3 bg-purple-50 dark:bg-purple-900/20 rounded-xl">
                                <svg class="w-5 h-5 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"></path>
                                </svg>
                                <a href="{{ $partner->website }}" target="_blank" class="text-purple-600 dark:text-purple-400 hover:underline">{{ parse_url($partner->website, PHP_URL_HOST) ?? $partner->website }}</a>
                            </div>
                            @endif
                            @if($partner->facebook_page)
                            <div class="flex items-center space-x-3 p-3 bg-blue-50 dark:bg-blue-900/20 rounded-xl">
                                <svg class="w-5 h-5 text-blue-500" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                                </svg>
                                <a href="{{ $partner->facebook_page }}" target="_blank" class="text-blue-600 dark:text-blue-400 hover:underline">Facebook Page</a>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Column - Detailed Information -->
            <div class="lg:col-span-2 space-y-6">
                
                <!-- Basic Information Section -->
                <div class="bg-white/80 dark:bg-gray-800/80 backdrop-blur-sm rounded-2xl border border-gray-200 dark:border-gray-700 shadow-xl hover:shadow-2xl transition-all duration-300">
                    <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 bg-gradient-to-r from-blue-50 to-purple-50 dark:from-blue-900/50 dark:to-purple-900/50 rounded-t-2xl">
                        <h3 class="text-xl font-bold text-transparent bg-clip-text bg-gradient-to-r from-blue-600 to-purple-600 dark:from-blue-400 dark:to-purple-400 flex items-center">
                            <svg class="w-6 h-6 mr-3 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                            🎯 Basic Information
                        </h3>
                    </div>
                    <div class="p-3">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                            <div class="space-y-2.5">
                                <div class="group">
                                    <label class="block text-xs font-semibold text-blue-600 dark:text-blue-400 mb-1 uppercase tracking-wide">🏫 Institute Name</label>
                                    <div class="relative">
                                        <p class="text-sm font-medium text-gray-800 dark:text-gray-200 bg-gradient-to-r from-blue-50 to-indigo-50 dark:from-blue-900/20 dark:to-indigo-900/20 px-3 py-2 rounded-lg border border-blue-200 dark:border-blue-700 shadow-sm group-hover:shadow-md transition-all duration-200">
                                            {{ $partner->institute_name ?? 'Not provided' }}
                                        </p>
                                        <div class="absolute inset-0 bg-gradient-to-r from-blue-500/10 to-indigo-500/10 rounded-lg opacity-0 group-hover:opacity-100 transition-opacity duration-200"></div>
                                    </div>
                                </div>
                                <div class="group">
                                    <label class="block text-xs font-semibold text-purple-600 dark:text-purple-400 mb-1 uppercase tracking-wide">🏷️ Partner Category</label>
                                    <div class="relative">
                                        <p class="text-sm font-medium text-gray-800 dark:text-gray-200 bg-gradient-to-r from-purple-50 to-pink-50 dark:from-purple-900/20 dark:to-pink-900/20 px-3 py-2 rounded-lg border border-purple-200 dark:border-purple-700 shadow-sm group-hover:shadow-md transition-all duration-200">
                                            {{ getPartnerCategoryDisplayName($partner->partner_category) ?? 'Not provided' }}
                                        </p>
                                        <div class="absolute inset-0 bg-gradient-to-r from-purple-500/10 to-pink-500/10 rounded-lg opacity-0 group-hover:opacity-100 transition-opacity duration-200"></div>
                                    </div>
                                </div>
                                <div class="group">
                                    <label class="block text-xs font-semibold text-emerald-600 dark:text-emerald-400 mb-1 uppercase tracking-wide">👤 Owner Name</label>
                                    <div class="relative">
                                        <p class="text-sm font-medium text-gray-800 dark:text-gray-200 bg-gradient-to-r from-emerald-50 to-teal-50 dark:from-emerald-900/20 dark:to-teal-900/20 px-3 py-2 rounded-lg border border-emerald-200 dark:border-emerald-700 shadow-sm group-hover:shadow-md transition-all duration-200">
                                            {{ $partner->owner_name ?? 'Not provided' }}
                                        </p>
                                        <div class="absolute inset-0 bg-gradient-to-r from-emerald-500/10 to-teal-500/10 rounded-lg opacity-0 group-hover:opacity-100 transition-opacity duration-200"></div>
                                    </div>
                                </div>
                                <div class="group">
                                    <label class="block text-xs font-semibold text-amber-600 dark:text-amber-400 mb-1 uppercase tracking-wide">🎯 Director/Manager</label>
                                    <div class="relative">
                                        <p class="text-sm font-medium text-gray-800 dark:text-gray-200 bg-gradient-to-r from-amber-50 to-orange-50 dark:from-amber-900/20 dark:to-orange-900/20 px-3 py-2 rounded-lg border border-amber-200 dark:border-amber-700 shadow-sm group-hover:shadow-md transition-all duration-200">
                                            {{ $partner->owner_director_name ?? 'Not provided' }}
                                        </p>
                                        <div class="absolute inset-0 bg-gradient-to-r from-amber-500/10 to-orange-500/10 rounded-lg opacity-0 group-hover:opacity-100 transition-opacity duration-200"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="space-y-2.5">
                                <div class="group">
                                    <label class="block text-xs font-semibold text-cyan-600 dark:text-cyan-400 mb-1 uppercase tracking-wide">🔗 Short Name</label>
                                    <div class="relative">
                                        <p class="text-sm font-medium text-gray-800 dark:text-gray-200 bg-gradient-to-r from-cyan-50 to-sky-50 dark:from-cyan-900/20 dark:to-sky-900/20 px-3 py-2 rounded-lg border border-cyan-200 dark:border-cyan-700 shadow-sm group-hover:shadow-md transition-all duration-200">
                                            {{ $partner->slug ?? 'Not provided' }}
                                        </p>
                                        <div class="absolute inset-0 bg-gradient-to-r from-cyan-500/10 to-sky-500/10 rounded-lg opacity-0 group-hover:opacity-100 transition-opacity duration-200"></div>
                                    </div>
                                </div>
                                <div class="group">
                                    <label class="block text-xs font-semibold text-indigo-600 dark:text-indigo-400 mb-1 uppercase tracking-wide">🔗 Short Name (বাংলা)</label>
                                    <div class="relative">
                                        <p class="text-sm font-medium text-gray-800 dark:text-gray-200 bg-gradient-to-r from-indigo-50 to-violet-50 dark:from-indigo-900/20 dark:to-violet-900/20 px-3 py-2 rounded-lg border border-indigo-200 dark:border-indigo-700 shadow-sm group-hover:shadow-md transition-all duration-200">
                                            {{ $partner->slug_bangla ?? 'Not provided' }}
                                        </p>
                                        <div class="absolute inset-0 bg-gradient-to-r from-indigo-500/10 to-violet-500/10 rounded-lg opacity-0 group-hover:opacity-100 transition-opacity duration-200"></div>
                                    </div>
                                </div>
                                <div class="group">
                                    <label class="block text-xs font-semibold text-rose-600 dark:text-rose-400 mb-1 uppercase tracking-wide">🏛️ Year of Estd.</label>
                                    <div class="relative">
                                        <p class="text-sm font-medium text-gray-800 dark:text-gray-200 bg-gradient-to-r from-rose-50 to-pink-50 dark:from-rose-900/20 dark:to-pink-900/20 px-3 py-2 rounded-lg border border-rose-200 dark:border-rose-700 shadow-sm group-hover:shadow-md transition-all duration-200">
                                            {{ $partner->year_of_establishment ?? $partner->established_year ?? 'Not provided' }}
                                        </p>
                                        <div class="absolute inset-0 bg-gradient-to-r from-rose-500/10 to-pink-500/10 rounded-lg opacity-0 group-hover:opacity-100 transition-opacity duration-200"></div>
                                    </div>
                                </div>
                                <div class="group">
                                    <label class="block text-xs font-semibold text-lime-600 dark:text-lime-400 mb-1 uppercase tracking-wide">📋 EIIN Number</label>
                                    <div class="relative">
                                        <p class="text-sm font-medium text-gray-800 dark:text-gray-200 bg-gradient-to-r from-lime-50 to-green-50 dark:from-lime-900/20 dark:to-green-900/20 px-3 py-2 rounded-lg border border-lime-200 dark:border-lime-700 shadow-sm group-hover:shadow-md transition-all duration-200">
                                            {{ $partner->eiin_no ?? 'Not provided' }}
                                        </p>
                                        <div class="absolute inset-0 bg-gradient-to-r from-lime-500/10 to-green-500/10 rounded-lg opacity-0 group-hover:opacity-100 transition-opacity duration-200"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Additional Basic Info Row -->
                        <div class="mt-3 grid grid-cols-1 md:grid-cols-2 gap-3">
                            <div class="group">
                                <label class="block text-xs font-semibold text-fuchsia-600 dark:text-fuchsia-400 mb-1 uppercase tracking-wide">📋 Trade License</label>
                                <div class="relative">
                                    <p class="text-sm font-medium text-gray-800 dark:text-gray-200 bg-gradient-to-r from-fuchsia-50 to-purple-50 dark:from-fuchsia-900/20 dark:to-purple-900/20 px-3 py-2 rounded-lg border border-fuchsia-200 dark:border-fuchsia-700 shadow-sm group-hover:shadow-md transition-all duration-200">
                                        {{ $partner->trade_license_no ?? 'Not provided' }}
                                    </p>
                                    <div class="absolute inset-0 bg-gradient-to-r from-fuchsia-500/10 to-purple-500/10 rounded-lg opacity-0 group-hover:opacity-100 transition-opacity duration-200"></div>
                                </div>
                            </div>
                            <div class="group">
                                <label class="block text-xs font-semibold text-slate-600 dark:text-slate-400 mb-1 uppercase tracking-wide">📋 TIN Number</label>
                                <div class="relative">
                                    <p class="text-sm font-medium text-gray-800 dark:text-gray-200 bg-gradient-to-r from-slate-50 to-gray-50 dark:from-slate-900/20 dark:to-gray-900/20 px-3 py-2 rounded-lg border border-slate-200 dark:border-slate-700 shadow-sm group-hover:shadow-md transition-all duration-200">
                                        {{ $partner->tin_no ?? 'Not provided' }}
                                    </p>
                                    <div class="absolute inset-0 bg-gradient-to-r from-slate-500/10 to-gray-500/10 rounded-lg opacity-0 group-hover:opacity-100 transition-opacity duration-200"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Contact Information Section -->
                <div class="bg-white/80 dark:bg-gray-800/80 backdrop-blur-sm rounded-2xl border border-emerald-200 dark:border-emerald-700 shadow-xl hover:shadow-2xl transition-all duration-300">
                    <div class="px-6 py-4 border-b border-emerald-200 dark:border-emerald-700 bg-gradient-to-r from-emerald-50 to-teal-50 dark:from-emerald-900/50 dark:to-teal-900/50 rounded-t-2xl">
                        <h3 class="text-xl font-bold text-transparent bg-clip-text bg-gradient-to-r from-emerald-600 to-teal-600 dark:from-emerald-400 dark:to-teal-400 flex items-center">
                            <svg class="w-6 h-6 mr-3 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                            </svg>
                            📞 Contact Information
                        </h3>
                    </div>
                    <div class="p-3">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                            <div class="space-y-2.5">
                                <div class="group">
                                    <label class="block text-xs font-semibold text-blue-600 dark:text-blue-400 mb-1 uppercase tracking-wide">📱 Mobile</label>
                                    <div class="relative">
                                        <p class="text-sm font-medium text-gray-800 dark:text-gray-200 bg-gradient-to-r from-blue-50 to-indigo-50 dark:from-blue-900/20 dark:to-indigo-900/20 px-3 py-2 rounded-lg border border-blue-200 dark:border-blue-700 shadow-sm group-hover:shadow-md transition-all duration-200">
                                            {{ $partner->mobile ?? 'Not provided' }}
                                        </p>
                                        <div class="absolute inset-0 bg-gradient-to-r from-blue-500/10 to-indigo-500/10 rounded-lg opacity-0 group-hover:opacity-100 transition-opacity duration-200"></div>
                                    </div>
                                </div>
                                <div class="group">
                                    <label class="block text-xs font-semibold text-emerald-600 dark:text-emerald-400 mb-1 uppercase tracking-wide">📱 Alt Mobile</label>
                                    <div class="relative">
                                        <p class="text-sm font-medium text-gray-800 dark:text-gray-200 bg-gradient-to-r from-emerald-50 to-teal-50 dark:from-emerald-900/20 dark:to-teal-900/20 px-3 py-2 rounded-lg border border-emerald-200 dark:border-emerald-700 shadow-sm group-hover:shadow-md transition-all duration-200">
                                            {{ $partner->alternate_mobile ?? 'Not provided' }}
                                        </p>
                                        <div class="absolute inset-0 bg-gradient-to-r from-emerald-500/10 to-teal-500/10 rounded-lg opacity-0 group-hover:opacity-100 transition-opacity duration-200"></div>
                                    </div>
                                </div>
                                <div class="group">
                                    <label class="block text-xs font-semibold text-purple-600 dark:text-purple-400 mb-1 uppercase tracking-wide">🌐 Website</label>
                                    <div class="relative">
                                        <p class="text-sm font-medium text-gray-800 dark:text-gray-200 bg-gradient-to-r from-purple-50 to-pink-50 dark:from-purple-900/20 dark:to-pink-900/20 px-3 py-2 rounded-lg border border-purple-200 dark:border-purple-700 shadow-sm group-hover:shadow-md transition-all duration-200">
                                            @if($partner->website)
                                                <a href="{{ $partner->website }}" target="_blank" class="text-blue-600 dark:text-blue-400 hover:underline">{{ parse_url($partner->website, PHP_URL_HOST) ?? $partner->website }}</a>
                                            @else
                                                Not provided
                                            @endif
                                        </p>
                                        <div class="absolute inset-0 bg-gradient-to-r from-purple-500/10 to-pink-500/10 rounded-lg opacity-0 group-hover:opacity-100 transition-opacity duration-200"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="space-y-2.5">
                                <div class="group">
                                    <label class="block text-xs font-semibold text-cyan-600 dark:text-cyan-400 mb-1 uppercase tracking-wide">📘 Facebook</label>
                                    <div class="relative">
                                        <p class="text-sm font-medium text-gray-800 dark:text-gray-200 bg-gradient-to-r from-cyan-50 to-sky-50 dark:from-cyan-900/20 dark:to-sky-900/20 px-3 py-2 rounded-lg border border-cyan-200 dark:border-cyan-700 shadow-sm group-hover:shadow-md transition-all duration-200">
                                            @if($partner->facebook_page)
                                                <a href="{{ $partner->facebook_page }}" target="_blank" class="text-blue-600 dark:text-blue-400 hover:underline">Facebook Page</a>
                                            @else
                                                Not provided
                                            @endif
                                        </p>
                                        <div class="absolute inset-0 bg-gradient-to-r from-cyan-500/10 to-sky-500/10 rounded-lg opacity-0 group-hover:opacity-100 transition-opacity duration-200"></div>
                                    </div>
                                </div>
                                <div class="group">
                                    <label class="block text-xs font-semibold text-amber-600 dark:text-amber-400 mb-1 uppercase tracking-wide">👨‍💼 Primary Contact</label>
                                    <div class="relative">
                                        <p class="text-sm font-medium text-gray-800 dark:text-gray-200 bg-gradient-to-r from-amber-50 to-orange-50 dark:from-amber-900/20 dark:to-orange-900/20 px-3 py-2 rounded-lg border border-amber-200 dark:border-amber-700 shadow-sm group-hover:shadow-md transition-all duration-200">
                                            {{ $partner->primary_contact_person ?? 'Not provided' }}
                                        </p>
                                        <div class="absolute inset-0 bg-gradient-to-r from-amber-500/10 to-orange-500/10 rounded-lg opacity-0 group-hover:opacity-100 transition-opacity duration-200"></div>
                                    </div>
                                </div>
                                <div class="group">
                                    <label class="block text-xs font-semibold text-rose-600 dark:text-rose-400 mb-1 uppercase tracking-wide">📞 Primary Contact No</label>
                                    <div class="relative">
                                        <p class="text-sm font-medium text-gray-800 dark:text-gray-200 bg-gradient-to-r from-rose-50 to-pink-50 dark:from-rose-900/20 dark:to-pink-900/20 px-3 py-2 rounded-lg border border-rose-200 dark:border-rose-700 shadow-sm group-hover:shadow-md transition-all duration-200">
                                            {{ $partner->primary_contact_no ?? 'Not provided' }}
                                        </p>
                                        <div class="absolute inset-0 bg-gradient-to-r from-rose-500/10 to-pink-500/10 rounded-lg opacity-0 group-hover:opacity-100 transition-opacity duration-200"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Additional Contact Info Row -->
                        <div class="mt-3 grid grid-cols-1 md:grid-cols-2 gap-3">
                            <div class="group">
                                <label class="block text-xs font-semibold text-indigo-600 dark:text-indigo-400 mb-1 uppercase tracking-wide">👩‍💼 Alt Contact</label>
                                <div class="relative">
                                    <p class="text-sm font-medium text-gray-800 dark:text-gray-200 bg-gradient-to-r from-indigo-50 to-violet-50 dark:from-indigo-900/20 dark:to-violet-900/20 px-3 py-2 rounded-lg border border-indigo-200 dark:border-indigo-700 shadow-sm group-hover:shadow-md transition-all duration-200">
                                        {{ $partner->alternate_contact_person ?? 'Not provided' }}
                                    </p>
                                    <div class="absolute inset-0 bg-gradient-to-r from-indigo-500/10 to-violet-500/10 rounded-lg opacity-0 group-hover:opacity-100 transition-opacity duration-200"></div>
                                </div>
                            </div>
                            <div class="group">
                                <label class="block text-xs font-semibold text-lime-600 dark:text-lime-400 mb-1 uppercase tracking-wide">📞 Alt Contact No</label>
                                <div class="relative">
                                    <p class="text-sm font-medium text-gray-800 dark:text-gray-200 bg-gradient-to-r from-lime-50 to-green-50 dark:from-lime-900/20 dark:to-green-900/20 px-3 py-2 rounded-lg border border-lime-200 dark:border-lime-700 shadow-sm group-hover:shadow-md transition-all duration-200">
                                        {{ $partner->alternate_contact_no ?? 'Not provided' }}
                                    </p>
                                    <div class="absolute inset-0 bg-gradient-to-r from-lime-500/10 to-green-500/10 rounded-lg opacity-0 group-hover:opacity-100 transition-opacity duration-200"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Location Information Section -->
                <div class="bg-white/80 dark:bg-gray-800/80 backdrop-blur-sm rounded-2xl border border-gray-200 dark:border-gray-700 shadow-xl hover:shadow-2xl transition-all duration-300">
                    <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 bg-gradient-to-r from-green-50 to-emerald-50 dark:from-green-900/50 dark:to-emerald-900/50 rounded-t-2xl">
                        <h3 class="text-xl font-bold text-transparent bg-clip-text bg-gradient-to-r from-green-600 to-emerald-600 dark:from-green-400 dark:to-emerald-400 flex items-center">
                            <svg class="w-6 h-6 mr-3 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                            🗺️ Location Information
                        </h3>
                    </div>
                    <div class="p-3">
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
                            <div class="group">
                                <label class="block text-xs font-semibold text-blue-600 dark:text-blue-400 mb-1 uppercase tracking-wide">🏛️ Division</label>
                                <div class="relative">
                                    <p class="text-sm font-medium text-gray-800 dark:text-gray-200 bg-gradient-to-r from-blue-50 to-indigo-50 dark:from-blue-900/20 dark:to-indigo-900/20 px-3 py-2 rounded-lg border border-blue-200 dark:border-blue-700 shadow-sm group-hover:shadow-md transition-all duration-200">
                                        {{ $partner->division ?? 'Not provided' }}
                                    </p>
                                    <div class="absolute inset-0 bg-gradient-to-r from-blue-500/10 to-indigo-500/10 rounded-lg opacity-0 group-hover:opacity-100 transition-opacity duration-200"></div>
                                </div>
                            </div>
                            <div class="group">
                                <label class="block text-xs font-semibold text-emerald-600 dark:text-emerald-400 mb-1 uppercase tracking-wide">🏘️ District</label>
                                <div class="relative">
                                    <p class="text-sm font-medium text-gray-800 dark:text-gray-200 bg-gradient-to-r from-emerald-50 to-teal-50 dark:from-emerald-900/20 dark:to-teal-900/20 px-3 py-2 rounded-lg border border-emerald-200 dark:border-emerald-700 shadow-sm group-hover:shadow-md transition-all duration-200">
                                        {{ $partner->district ?? 'Not provided' }}
                                    </p>
                                    <div class="absolute inset-0 bg-gradient-to-r from-emerald-500/10 to-teal-500/10 rounded-lg opacity-0 group-hover:opacity-100 transition-opacity duration-200"></div>
                                </div>
                            </div>
                            <div class="group">
                                <label class="block text-xs font-semibold text-purple-600 dark:text-purple-400 mb-1 uppercase tracking-wide">🏢 Upazila</label>
                                <div class="relative">
                                    <p class="text-sm font-medium text-gray-800 dark:text-gray-200 bg-gradient-to-r from-purple-50 to-pink-50 dark:from-purple-900/20 dark:to-pink-900/20 px-3 py-2 rounded-lg border border-purple-200 dark:border-purple-700 shadow-sm group-hover:shadow-md transition-all duration-200">
                                        {{ $partner->upazila ?? 'Not provided' }}
                                    </p>
                                    <div class="absolute inset-0 bg-gradient-to-r from-purple-500/10 to-pink-500/10 rounded-lg opacity-0 group-hover:opacity-100 transition-opacity duration-200"></div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Additional Location Info Row -->
                        <div class="mt-3 grid grid-cols-1 md:grid-cols-3 gap-3">
                            <div class="group">
                                <label class="block text-xs font-semibold text-amber-600 dark:text-amber-400 mb-1 uppercase tracking-wide">📮 Post Office</label>
                                <div class="relative">
                                    <p class="text-sm font-medium text-gray-800 dark:text-gray-200 bg-gradient-to-r from-amber-50 to-orange-50 dark:from-amber-900/20 dark:to-orange-900/20 px-3 py-2 rounded-lg border border-amber-200 dark:border-amber-700 shadow-sm group-hover:shadow-md transition-all duration-200">
                                        {{ $partner->post_office ?? 'Not provided' }}
                                    </p>
                                    <div class="absolute inset-0 bg-gradient-to-r from-amber-500/10 to-orange-500/10 rounded-lg opacity-0 group-hover:opacity-100 transition-opacity duration-200"></div>
                                </div>
                            </div>
                            <div class="group">
                                <label class="block text-xs font-semibold text-rose-600 dark:text-rose-400 mb-1 uppercase tracking-wide">📮 Post Code</label>
                                <div class="relative">
                                    <p class="text-sm font-medium text-gray-800 dark:text-gray-200 bg-gradient-to-r from-rose-50 to-pink-50 dark:from-rose-900/20 dark:to-pink-900/20 px-3 py-2 rounded-lg border border-rose-200 dark:border-rose-700 shadow-sm group-hover:shadow-md transition-all duration-200">
                                        {{ $partner->post_code ?? 'Not provided' }}
                                    </p>
                                    <div class="absolute inset-0 bg-gradient-to-r from-rose-500/10 to-pink-500/10 rounded-lg opacity-0 group-hover:opacity-100 transition-opacity duration-200"></div>
                                </div>
                            </div>
                            <div class="group">
                                <label class="block text-xs font-semibold text-cyan-600 dark:text-cyan-400 mb-1 uppercase tracking-wide">🛣️ Village/Road</label>
                                <div class="relative">
                                    <p class="text-sm font-medium text-gray-800 dark:text-gray-200 bg-gradient-to-r from-cyan-50 to-sky-50 dark:from-cyan-900/20 dark:to-sky-900/20 px-3 py-2 rounded-lg border border-cyan-200 dark:border-cyan-700 shadow-sm group-hover:shadow-md transition-all duration-200">
                                        {{ $partner->village_road_no ?? 'Not provided' }}
                                    </p>
                                    <div class="absolute inset-0 bg-gradient-to-r from-cyan-500/10 to-sky-500/10 rounded-lg opacity-0 group-hover:opacity-100 transition-opacity duration-200"></div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Final Location Info Row -->
                        <div class="mt-3 grid grid-cols-1 md:grid-cols-2 gap-3">
                            <div class="group">
                                <label class="block text-xs font-semibold text-indigo-600 dark:text-indigo-400 mb-1 uppercase tracking-wide">🏠 Flat/House</label>
                                <div class="relative">
                                    <p class="text-sm font-medium text-gray-800 dark:text-gray-200 bg-gradient-to-r from-indigo-50 to-violet-50 dark:from-indigo-900/20 dark:to-violet-900/20 px-3 py-2 rounded-lg border border-indigo-200 dark:border-indigo-700 shadow-sm group-hover:shadow-md transition-all duration-200">
                                        {{ $partner->flat_house_no ?? 'Not provided' }}
                                    </p>
                                    <div class="absolute inset-0 bg-gradient-to-r from-indigo-500/10 to-violet-500/10 rounded-lg opacity-0 group-hover:opacity-100 transition-opacity duration-200"></div>
                                </div>
                            </div>
                            <div class="group">
                                <label class="block text-xs font-semibold text-lime-600 dark:text-lime-400 mb-1 uppercase tracking-wide">📍 Short Address</label>
                                <div class="relative">
                                    <p class="text-sm font-medium text-gray-800 dark:text-gray-200 bg-gradient-to-r from-lime-50 to-green-50 dark:from-lime-900/20 dark:to-green-900/20 px-3 py-2 rounded-lg border border-lime-200 dark:border-lime-700 shadow-sm group-hover:shadow-md transition-all duration-200">
                                        {{ $partner->short_address ?? 'Not provided' }}
                                    </p>
                                    <div class="absolute inset-0 bg-gradient-to-r from-lime-500/10 to-green-500/10 rounded-lg opacity-0 group-hover:opacity-100 transition-opacity duration-200"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>



                <!-- Subscription Information Section -->
                <div class="bg-white/80 dark:bg-gray-800/80 backdrop-blur-sm rounded-2xl border border-gray-200 dark:border-gray-700 shadow-xl hover:shadow-2xl transition-all duration-300">
                    <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 bg-gradient-to-r from-amber-50 to-orange-50 dark:from-amber-900/50 dark:to-orange-900/50 rounded-t-2xl">
                        <h3 class="text-xl font-bold text-transparent bg-clip-text bg-gradient-to-r from-amber-600 to-orange-600 dark:from-amber-400 dark:to-orange-400 flex items-center">
                            <svg class="w-6 h-6 mr-3 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                            </svg>
                            💳 Subscription Information
                        </h3>
                    </div>
                    <div class="p-3">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                            <div class="group">
                                <label class="block text-xs font-semibold text-blue-600 dark:text-blue-400 mb-1 uppercase tracking-wide">💳 Plan</label>
                                <div class="relative">
                                    <p class="text-sm font-medium text-gray-800 dark:text-gray-200 bg-gradient-to-r from-blue-50 to-indigo-50 dark:from-blue-900/20 dark:to-indigo-900/20 px-3 py-2 rounded-lg border border-blue-200 dark:border-blue-700 shadow-sm group-hover:shadow-md transition-all duration-200">
                                        {{ $partner->subscription_plan ?? 'Not specified' }}
                                    </p>
                                    <div class="absolute inset-0 bg-gradient-to-r from-blue-500/10 to-indigo-500/10 rounded-lg opacity-0 group-hover:opacity-100 transition-opacity duration-200"></div>
                                </div>
                            </div>
                            <div class="group">
                                <label class="block text-xs font-semibold text-emerald-600 dark:text-emerald-400 mb-1 uppercase tracking-wide">💰 Payment Status</label>
                                <div class="relative">
                                    <p class="text-sm font-medium text-gray-800 dark:text-gray-200 bg-gradient-to-r from-emerald-50 to-teal-50 dark:from-emerald-900/20 dark:to-teal-900/20 px-3 py-2 rounded-lg border border-emerald-200 dark:border-emerald-700 shadow-sm group-hover:shadow-md transition-all duration-200">
                                        @if($partner->payment_status)
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                                @if($partner->payment_status === 'paid') bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200
                                                @elseif($partner->payment_status === 'pending') bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200
                                                @elseif($partner->payment_status === 'failed') bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200
                                                @else bg-gray-100 text-gray-800 dark:bg-gray-900 dark:text-gray-200 @endif">
                                                {{ ucfirst($partner->payment_status) }}
                                            </span>
                                        @else
                                            Not specified
                                        @endif
                                    </p>
                                    <div class="absolute inset-0 bg-gradient-to-r from-emerald-500/10 to-teal-500/10 rounded-lg opacity-0 group-hover:opacity-100 transition-opacity duration-200"></div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Additional Subscription Info Row -->
                        <div class="mt-3 grid grid-cols-1 md:grid-cols-2 gap-3">
                            <div class="group">
                                <label class="block text-xs font-semibold text-purple-600 dark:text-purple-400 mb-1 uppercase tracking-wide">📅 Start Date</label>
                                <div class="relative">
                                    <p class="text-sm font-medium text-gray-800 dark:text-gray-200 bg-gradient-to-r from-purple-50 to-pink-50 dark:from-purple-900/20 dark:to-pink-900/20 px-3 py-2 rounded-lg border border-purple-200 dark:border-purple-700 shadow-sm group-hover:shadow-md transition-all duration-200">
                                        @if($partner->subscription_start_date)
                                            {{ \Carbon\Carbon::parse($partner->subscription_start_date)->format('M d, Y') }}
                                        @else
                                            Not specified
                                        @endif
                                    </p>
                                    <div class="absolute inset-0 bg-gradient-to-r from-purple-500/10 to-pink-500/10 rounded-lg opacity-0 group-hover:opacity-100 transition-opacity duration-200"></div>
                                </div>
                            </div>
                            <div class="group">
                                <label class="block text-xs font-semibold text-amber-600 dark:text-amber-400 mb-1 uppercase tracking-wide">📅 End Date</label>
                                <div class="relative">
                                    <p class="text-sm font-medium text-gray-800 dark:text-gray-200 bg-gradient-to-r from-amber-50 to-orange-50 dark:from-amber-900/20 dark:to-orange-900/20 px-3 py-2 rounded-lg border border-amber-200 dark:border-amber-700 shadow-sm group-hover:shadow-md transition-all duration-200">
                                        @if($partner->subscription_end_date)
                                            {{ \Carbon\Carbon::parse($partner->subscription_end_date)->format('M d, Y') }}
                                        @else
                                            Not specified
                                        @endif
                                    </p>
                                    <div class="absolute inset-0 bg-gradient-to-r from-amber-500/10 to-orange-500/10 rounded-lg opacity-0 group-hover:opacity-100 transition-opacity duration-200"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Additional Information Section -->
                <div class="bg-white/80 dark:bg-gray-800/80 backdrop-blur-sm rounded-2xl border border-gray-200 dark:border-gray-700 shadow-xl hover:shadow-2xl transition-all duration-300">
                    <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 bg-gradient-to-r from-indigo-50 to-cyan-50 dark:from-indigo-900/50 dark:to-cyan-900/50 rounded-t-2xl">
                        <h3 class="text-xl font-bold text-transparent bg-clip-text bg-gradient-to-r from-indigo-600 to-cyan-600 dark:from-indigo-400 dark:to-cyan-400 flex items-center">
                            <svg class="w-6 h-6 mr-3 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            ℹ️ Additional Information
                        </h3>
                    </div>
                    <div class="p-3">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                            <div class="group">
                                <label class="block text-xs font-semibold text-blue-600 dark:text-blue-400 mb-1 uppercase tracking-wide">📝 Description</label>
                                <div class="relative">
                                    <p class="text-sm font-medium text-gray-800 dark:text-gray-200 bg-gradient-to-r from-blue-50 to-indigo-50 dark:from-blue-900/20 dark:to-indigo-900/20 px-3 py-2 rounded-lg border border-blue-200 dark:border-blue-700 shadow-sm group-hover:shadow-md transition-all duration-200 min-h-[60px]">
                                        {{ $partner->description ?? 'No description provided' }}
                                    </p>
                                    <div class="absolute inset-0 bg-gradient-to-r from-blue-500/10 to-indigo-500/10 rounded-lg opacity-0 group-hover:opacity-100 transition-opacity duration-200"></div>
                                </div>
                            </div>
                            <div class="group">
                                <label class="block text-xs font-semibold text-emerald-600 dark:text-emerald-400 mb-1 uppercase tracking-wide">🗺️ Map Location</label>
                                <div class="relative">
                                    <p class="text-sm font-medium text-gray-800 dark:text-gray-200 bg-gradient-to-r from-emerald-50 to-teal-50 dark:from-emerald-900/20 dark:to-teal-900/20 px-3 py-2 rounded-lg border border-emerald-200 dark:border-emerald-700 shadow-sm group-hover:shadow-md transition-all duration-200">
                                        @if($partner->map_location)
                                            <a href="{{ $partner->map_location }}" target="_blank" class="text-blue-600 dark:text-blue-400 hover:underline">View on Map</a>
                                        @else
                                            Not provided
                                        @endif
                                    </p>
                                    <div class="absolute inset-0 bg-gradient-to-r from-emerald-500/10 to-teal-500/10 rounded-lg opacity-0 group-hover:opacity-100 transition-opacity duration-200"></div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Status and Category Row -->
                        <div class="mt-3 grid grid-cols-1 md:grid-cols-2 gap-3">
                            <div class="group">
                                <label class="block text-xs font-semibold text-purple-600 dark:text-purple-400 mb-1 uppercase tracking-wide">🏷️ Category</label>
                                <div class="relative">
                                    <p class="text-sm font-medium text-gray-800 dark:text-gray-200 bg-gradient-to-r from-purple-50 to-pink-50 dark:from-purple-900/20 dark:to-pink-900/20 px-3 py-2 rounded-lg border border-purple-200 dark:border-purple-700 shadow-sm group-hover:shadow-md transition-all duration-200">
                                        @if($partner->category)
                                            @php
                                                $categories = [
                                                    'school' => 'School',
                                                    'college' => 'College',
                                                    'university' => 'University',
                                                    'coaching_center' => 'Coaching Center',
                                                    'training_institute' => 'Training Institute',
                                                    'other' => 'Other'
                                                ];
                                            @endphp
                                            {{ $categories[$partner->category] ?? ucfirst($partner->category) }}
                                        @else
                                            Not specified
                                        @endif
                                    </p>
                                    <div class="absolute inset-0 bg-gradient-to-r from-purple-500/10 to-pink-500/10 rounded-lg opacity-0 group-hover:opacity-100 transition-opacity duration-200"></div>
                                </div>
                            </div>
                            <div class="group">
                                <label class="block text-xs font-semibold text-amber-600 dark:text-amber-400 mb-1 uppercase tracking-wide">📊 Status</label>
                                <div class="relative">
                                    <p class="text-sm font-medium text-gray-800 dark:text-gray-200 bg-gradient-to-r from-amber-50 to-orange-50 dark:from-amber-900/20 dark:to-orange-900/20 px-3 py-2 rounded-lg border border-amber-200 dark:border-amber-700 shadow-sm group-hover:shadow-md transition-all duration-200">
                                        @if($partner->status)
                                            <span class="inline-flex items-center px-2.5000000000000004 py-0.5 rounded-full text-xs font-medium 
                                                @if($partner->status === 'active') bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200
                                                @elseif($partner->status === 'inactive') bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200
                                                @elseif($partner->status === 'pending') bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200
                                                @else bg-gray-100 text-gray-800 dark:bg-gray-900 dark:text-gray-200 @endif">
                                                {{ ucfirst($partner->status) }}
                                            </span>
                                        @else
                                            Active
                                        @endif
                                    </p>
                                    <div class="absolute inset-0 bg-gradient-to-r from-amber-500/10 to-orange-500/10 rounded-lg opacity-0 group-hover:opacity-100 transition-opacity duration-200"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>

</div>
@endsection
