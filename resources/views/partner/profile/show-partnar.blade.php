@extends('layouts.partner-layout')

@section('title', 'Partner Profile')

@section('content')
<div class="space-y-8">
    <!-- Page Header with Enhanced Design -->
    <div class="bg-gradient-to-r from-primaryGreen to-green-600 rounded-2xl p-8 text-white shadow-xl">
        <div class="flex justify-between items-start">
            <div class="flex-1">
                <h1 class="text-4xl font-bold mb-2">Institution Profile</h1>
                <p class="text-green-100 text-lg">Complete overview of your educational institution</p>
                <div class="flex items-center space-x-4 mt-4">
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-white/20 backdrop-blur-sm">
                        <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                        </svg>
                        {{ ucfirst($partner->status ?? 'active') }}
                    </span>
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-white/20 backdrop-blur-sm">
                        <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        {{ $partner->partner_category ?? 'Institution' }}
                    </span>
                </div>
            </div>
            <a href="{{ route('partner.profile.edit-partnar') }}" 
               class="bg-white text-primaryGreen hover:bg-gray-50 px-6 py-3 rounded-xl font-semibold transition-all duration-200 shadow-lg hover:shadow-xl transform hover:-translate-y-1">
                <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                </svg>
                Edit Profile
            </a>
        </div>
    </div>

    <!-- Main Profile Content -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Left Column - Basic Info & Logo -->
        <div class="lg:col-span-1 space-y-6">
            <!-- Institution Logo & Basic Info Card -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg border border-gray-200 dark:border-gray-700 overflow-hidden">
                <div class="p-6">
                    <!-- Logo Section -->
                    <div class="text-center mb-6">
                        @if($partner && $partner->logo)
                            <img src="{{ asset('storage/' . $partner->logo) }}" 
                                 alt="Institution Logo" 
                                 class="w-32 h-32 rounded-2xl object-cover border-4 border-white shadow-lg mx-auto">
                        @else
                            <div class="w-32 h-32 bg-gradient-to-br from-primaryGreen to-green-600 rounded-2xl flex items-center justify-center mx-auto shadow-lg">
                                <svg class="w-16 h-16 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                </svg>
                            </div>
                        @endif
                    </div>
                    
                    <!-- Basic Info -->
                    <div class="text-center">
                        <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-2">
                            {{ $partner->name ?? 'Institution Name' }}
                        </h2>
                        @if($partner->institute_name_bangla)
                            <p class="text-lg text-gray-600 dark:text-gray-400 mb-3 font-bangla">
                                {{ $partner->institute_name_bangla }}
                            </p>
                        @endif
                        <p class="text-gray-600 dark:text-gray-400 text-sm leading-relaxed">
                            {{ $partner->description ?? 'No description available' }}
                        </p>
                    </div>
                </div>
            </div>

            <!-- Quick Stats Card -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg border border-gray-200 dark:border-gray-700 p-6">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-primaryGreen" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                    </svg>
                    Quick Statistics
                </h3>
                <div class="space-y-3">
                    <div class="flex justify-between items-center p-3 bg-blue-50 dark:bg-blue-900/20 rounded-lg">
                        <span class="text-sm text-gray-600 dark:text-gray-400">Questions</span>
                        <span class="text-lg font-bold text-blue-600 dark:text-blue-400">{{ $partner->questions_count ?? 0 }}</span>
                    </div>
                    <div class="flex justify-between items-center p-3 bg-green-50 dark:bg-green-900/20 rounded-lg">
                        <span class="text-sm text-gray-600 dark:text-gray-400">Exams</span>
                        <span class="text-lg font-bold text-green-600 dark:text-green-400">{{ $partner->exams_count ?? 0 }}</span>
                    </div>
                    <div class="flex justify-between items-center p-3 bg-purple-50 dark:bg-purple-900/20 rounded-lg">
                        <span class="text-sm text-gray-600 dark:text-gray-400">Students</span>
                        <span class="text-lg font-bold text-purple-600 dark:text-purple-400">{{ $partner->students_count ?? 0 }}</span>
                    </div>
                    <div class="flex justify-between items-center p-3 bg-orange-50 dark:bg-orange-900/20 rounded-lg">
                        <span class="text-sm text-gray-600 dark:text-gray-400">Courses</span>
                        <span class="text-lg font-bold text-orange-600 dark:text-orange-400">{{ $partner->courses_count ?? 0 }}</span>
                                             </div>
                     </div>
                 </div>
             </div>

             <!-- Address Information Card -->
             <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg border border-gray-200 dark:border-gray-700 overflow-hidden">
                 <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                     <h3 class="text-xl font-semibold text-gray-900 dark:text-white flex items-center">
                         <svg class="w-6 h-6 mr-3 text-primaryGreen" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                             <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                             <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                         </svg>
                         Address Information
                     </h3>
                 </div>
                 <div class="p-6">
                     <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                         <div class="space-y-4">
                             <div>
                                 <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Address</label>
                                 <div class="flex items-start p-3 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg">
                                     <svg class="w-5 h-5 text-gray-400 mr-3 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                         <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                     </svg>
                                     <span class="text-gray-900 dark:text-white">{{ $partner->address ?? 'No address provided' }}</span>
                                 </div>
                             </div>
                             <div>
                                 <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">City</label>
                                 <div class="flex items-center p-3 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg">
                                     <svg class="w-5 h-5 text-gray-400 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                         <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                     </svg>
                                     <span class="text-gray-900 dark:text-white">{{ $partner->city ?? 'No city provided' }}</span>
                                 </div>
                             </div>
                             <div>
                                 <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Division</label>
                                 <div class="flex items-center p-3 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg">
                                     <svg class="w-5 h-5 text-gray-400 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                         <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                     </svg>
                                     <span class="text-gray-900 dark:text-white">{{ $partner->division ?? 'No division specified' }}</span>
                                 </div>
                             </div>
                             <div>
                                 <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">District</label>
                                 <div class="flex items-center p-3 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg">
                                     <svg class="w-5 h-5 text-gray-400 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                         <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                     </svg>
                                     <span class="text-gray-900 dark:text-white">{{ $partner->district ?? 'No district specified' }}</span>
                                 </div>
                             </div>
                         </div>
                         <div class="space-y-4">
                             <div>
                                 <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Upazila</label>
                                 <div class="flex items-center p-3 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg">
                                     <svg class="w-5 h-5 text-gray-400 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                         <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                     </svg>
                                     <span class="text-gray-900 dark:text-white">{{ $partner->upazila ?? 'No upazila specified' }}</span>
                                 </div>
                             </div>
                             <div>
                                 <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Post Office</label>
                                 <div class="flex items-center p-3 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg">
                                     <svg class="w-5 h-5 text-gray-400 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                         <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                     </svg>
                                     <span class="text-gray-900 dark:text-white">{{ $partner->post_office ?? 'No post office specified' }}</span>
                                 </div>
                             </div>
                             <div>
                                 <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Post Code</label>
                                 <div class="flex items-center p-3 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg">
                                     <svg class="w-5 h-5 text-gray-400 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                         <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                     </svg>
                                     <span class="text-gray-900 dark:text-white">{{ $partner->post_code ?? 'No post code specified' }}</span>
                                 </div>
                             </div>
                             <div>
                                 <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Village/Road No</label>
                                 <div class="flex items-center p-3 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg">
                                     <svg class="w-5 h-5 text-gray-400 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                         <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                     </svg>
                                     <span class="text-gray-900 dark:text-white">{{ $partner->village_road_no ?? 'No village/road number specified' }}</span>
                                 </div>
                             </div>
                         </div>
                     </div>
                 </div>
                          </div>

             <!-- Institutional Details Card -->
             <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg border border-gray-200 dark:border-gray-700 overflow-hidden">
                 <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                     <h3 class="text-xl font-semibold text-gray-900 dark:text-white flex items-center">
                         <svg class="w-6 h-6 mr-3 text-primaryGreen" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                             <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                         </svg>
                         Institutional Details
                     </h3>
                 </div>
                 <div class="p-6">
                     <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                         <div class="space-y-4">
                             <div>
                                 <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Owner/Director Name</label>
                                 <div class="flex items-center p-3 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg">
                                     <svg class="w-5 h-5 text-gray-400 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                         <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                     </svg>
                                     <span class="text-gray-900 dark:text-white">{{ $partner->owner_director_name ?? 'No owner/director specified' }}</span>
                                 </div>
                             </div>
                             <div>
                                 <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Category</label>
                                 <div class="flex items-center p-3 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg">
                                     <svg class="w-5 h-5 text-gray-400 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                         <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                                     </svg>
                                     <span class="text-gray-900 dark:text-white">{{ $partner->category ?? 'No category specified' }}</span>
                                 </div>
                             </div>
                             <div>
                                 <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Target Group</label>
                                 <div class="flex items-center p-3 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg">
                                     <svg class="w-5 h-5 text-gray-400 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                         <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                     </svg>
                                     <span class="text-gray-900 dark:text-white">{{ $partner->target_group ?? 'No target group specified' }}</span>
                                 </div>
                             </div>
                             <div>
                                 <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Class Range</label>
                                 <div class="flex items-center p-3 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg">
                                     <svg class="w-5 h-5 text-gray-400 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                         <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                     </svg>
                                     <span class="text-gray-900 dark:text-white">{{ $partner->class_range ?? 'No class range specified' }}</span>
                                 </div>
                             </div>
                         </div>
                         <div class="space-y-4">
                             <div>
                                 <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Established Year</label>
                                 <div class="flex items-center p-3 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg">
                                     <svg class="w-5 h-5 text-gray-400 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                         <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                     </svg>
                                     <span class="text-gray-900 dark:text-white">{{ $partner->established_year ?? $partner->year_of_establishment ?? 'No establishment year specified' }}</span>
                                 </div>
                             </div>
                             <div>
                                 <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Total Teachers</label>
                                 <div class="flex items-center p-3 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg">
                                     <svg class="w-5 h-5 text-gray-400 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                         <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                     </svg>
                                     <span class="text-gray-900 dark:text-white">{{ $partner->total_teachers ?? 'No teacher count specified' }}</span>
                                 </div>
                             </div>
                             <div>
                                 <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Total Students</label>
                                 <div class="flex items-center p-3 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg">
                                     <svg class="w-5 h-5 text-gray-400 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                         <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                     </svg>
                                     <span class="text-gray-900 dark:text-white">{{ $partner->total_students ?? 'No student count specified' }}</span>
                                 </div>
                             </div>
                             <div>
                                 <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Batch System</label>
                                 <div class="flex items-center p-3 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg">
                                     <svg class="w-5 h-5 text-gray-400 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                         <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                     </svg>
                                     <span class="text-gray-900 dark:text-white">{{ $partner->batch_system ? 'Yes' : 'No' }}</span>
                                 </div>
                             </div>
                         </div>
                     </div>
                 </div>
                          </div>

             <!-- Legal & Business Information Card -->
             <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg border border-gray-200 dark:border-gray-700 overflow-hidden">
                 <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                     <h3 class="text-xl font-semibold text-gray-900 dark:text-white flex items-center">
                         <svg class="w-6 h-6 mr-3 text-primaryGreen" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                             <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                         </svg>
                         Legal & Business Information
                     </h3>
                 </div>
                 <div class="p-6">
                     <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                         <div class="space-y-4">
                             <div>
                                 <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">EIIN Number</label>
                                 <div class="flex items-center p-3 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg">
                                     <svg class="w-5 h-5 text-gray-400 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                         <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                     </svg>
                                     <span class="text-gray-900 dark:text-white">{{ $partner->eiin_no ?? 'No EIIN number specified' }}</span>
                                 </div>
                             </div>
                             <div>
                                 <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Trade License No</label>
                                 <div class="flex items-center p-3 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg">
                                     <svg class="w-5 h-5 text-gray-400 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                         <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                     </svg>
                                     <span class="text-gray-900 dark:text-white">{{ $partner->trade_license_no ?? 'No trade license specified' }}</span>
                                 </div>
                             </div>
                             <div>
                                 <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">TIN Number</label>
                                 <div class="flex items-center p-3 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg">
                                     <svg class="w-5 h-5 text-gray-400 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                         <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                     </svg>
                                     <span class="text-gray-900 dark:text-white">{{ $partner->tin_no ?? 'No TIN number specified' }}</span>
                                 </div>
                             </div>
                         </div>
                         <div class="space-y-4">
                             <div>
                                 <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Subscription Plan</label>
                                 <div class="flex items-center p-3 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg">
                                     <svg class="w-5 h-5 text-gray-400 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                         <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                                     </svg>
                                     <span class="text-gray-900 dark:text-white">{{ $partner->subscription_plan ?? 'No subscription plan specified' }}</span>
                                 </div>
                             </div>
                             <div>
                                 <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Payment Status</label>
                                 <div class="flex items-center p-3 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg">
                                     @php
                                         $paymentStatus = $partner->payment_status ?? 'pending';
                                         $statusColors = [
                                             'paid' => 'text-green-600 bg-green-100',
                                             'pending' => 'text-yellow-600 bg-yellow-100',
                                             'overdue' => 'text-red-600 bg-red-100',
                                             'cancelled' => 'text-gray-600 bg-gray-100'
                                         ];
                                         $statusColor = $statusColors[$paymentStatus] ?? 'text-gray-600 bg-gray-100';
                                     @endphp
                                     <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $statusColor }} dark:bg-gray-700 dark:text-gray-300">
                                         {{ ucfirst($paymentStatus) }}
                                     </span>
                                 </div>
                             </div>
                             <div>
                                 <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Subscription Period</label>
                                 <div class="flex items-center p-3 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg">
                                     <svg class="w-5 h-5 text-gray-400 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                         <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                     </svg>
                                     <span class="text-gray-900 dark:text-white">
                                         @if($partner->subscription_start_date && $partner->subscription_end_date)
                                             {{ \Carbon\Carbon::parse($partner->subscription_start_date)->format('M d, Y') }} - {{ \Carbon\Carbon::parse($partner->subscription_end_date)->format('M d, Y') }}
                                         @else
                                             No subscription period specified
                                         @endif
                                     </span>
                                 </div>
                             </div>
                         </div>
                     </div>
                 </div>
                          </div>

             <!-- Courses & Subjects Card -->
             <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg border border-gray-200 dark:border-gray-700 overflow-hidden">
                 <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                     <h3 class="text-xl font-semibold text-gray-900 dark:text-white flex items-center">
                         <svg class="w-6 h-6 mr-3 text-primaryGreen" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                             <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                         </svg>
                         Courses & Subjects
                     </h3>
                 </div>
                 <div class="p-6">
                     <div class="space-y-4">
                         <div>
                             <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Subjects Offered</label>
                             <div class="p-3 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg">
                                 <span class="text-gray-900 dark:text-white">
                                     {{ $partner->subjects_offered ?? 'No subjects specified' }}
                                 </span>
                             </div>
                         </div>
                         <div>
                             <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Custom Courses</label>
                             <div class="p-3 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg">
                                 <span class="text-gray-900 dark:text-white">
                                     {{ $partner->custom_courses ?? 'No custom courses specified' }}
                                 </span>
                             </div>
                         </div>
                         @if($partner->course_offers)
                             <div>
                                 <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Course Offers</label>
                                 <div class="p-3 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg">
                                     <div class="flex flex-wrap gap-2">
                                         @foreach(json_decode($partner->course_offers, true) ?? [] as $course)
                                             <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200">
                                                 {{ $course }}
                                             </span>
                                         @endforeach
                                     </div>
                                 </div>
                             </div>
                         @endif
                     </div>
                 </div>
             </div>

         <!-- Right Column - Detailed Information -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Contact Information Card -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg border border-gray-200 dark:border-gray-700 overflow-hidden">
                <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white flex items-center">
                        <svg class="w-6 h-6 mr-3 text-primaryGreen" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                        </svg>
                        Contact Information
                    </h3>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Email Address</label>
                                <div class="flex items-center p-3 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg">
                                    <svg class="w-5 h-5 text-gray-400 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"></path>
                                    </svg>
                                    <span class="text-gray-900 dark:text-white">{{ $partner->email ?? 'No email provided' }}</span>
                                </div>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Phone Number</label>
                                <div class="flex items-center p-3 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg">
                                    <svg class="w-5 h-5 text-gray-400 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                                    </svg>
                                    <span class="text-gray-900 dark:text-white">{{ $partner->phone ?? 'No phone provided' }}</span>
                                </div>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Mobile</label>
                                <div class="flex items-center p-3 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg">
                                    <svg class="w-5 h-5 text-gray-400 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                                    </svg>
                                    <span class="text-gray-900 dark:text-white">{{ $partner->mobile ?? 'No mobile provided' }}</span>
                                </div>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Alternate Mobile</label>
                                <div class="flex items-center p-3 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg">
                                    <svg class="w-5 h-5 text-gray-400 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                                    </svg>
                                    <span class="text-gray-900 dark:text-white">{{ $partner->alternate_mobile ?? 'No alternate mobile provided' }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Website</label>
                                <div class="flex items-center p-3 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg">
                                    <svg class="w-5 h-5 text-gray-400 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"></path>
                                    </svg>
                                    <span class="text-gray-900 dark:text-white">{{ $partner->website ?? 'No website provided' }}</span>
                                </div>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Facebook Page</label>
                                <div class="flex items-center p-3 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg">
                                    <svg class="w-5 h-5 text-gray-400 mr-3" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                                    </svg>
                                    <span class="text-gray-900 dark:text-white">{{ $partner->facebook_page ?? 'No Facebook page provided' }}</span>
                                </div>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Primary Contact Person</label>
                                <div class="flex items-center p-3 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg">
                                    <svg class="w-5 h-5 text-gray-400 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                    </svg>
                                    <span class="text-gray-900 dark:text-white">{{ $partner->primary_contact_person ?? 'No contact person specified' }}</span>
                                </div>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Primary Contact No</label>
                                <div class="flex items-center p-3 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg">
                                    <svg class="w-5 h-5 text-gray-400 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                                    </svg>
                                    <span class="text-gray-900 dark:text-white">{{ $partner->primary_contact_no ?? 'No contact number specified' }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

    <!-- Quick Actions Section -->
    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg border border-gray-200 dark:border-gray-700 overflow-hidden">
        <div class="p-6 border-b border-gray-200 dark:border-gray-700">
            <h3 class="text-xl font-semibold text-gray-900 dark:text-white flex items-center">
                <svg class="w-6 h-6 mr-3 text-primaryGreen" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                </svg>
                Quick Actions
            </h3>
        </div>
        <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <a href="{{ route('partner.profile.edit-partnar') }}" 
                   class="group flex flex-col items-center p-6 bg-gradient-to-br from-blue-50 to-blue-100 dark:from-blue-900/20 dark:to-blue-800/20 rounded-xl hover:from-blue-100 hover:to-blue-200 dark:hover:from-blue-800/30 dark:hover:to-blue-700/30 transition-all duration-200 border border-blue-200 dark:border-blue-700">
                    <div class="w-12 h-12 bg-blue-100 dark:bg-blue-800 rounded-lg flex items-center justify-center mb-4 group-hover:scale-110 transition-transform duration-200">
                        <svg class="w-6 h-6 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                        </svg>
                    </div>
                    <h4 class="font-semibold text-gray-900 dark:text-white text-center mb-2">Edit Profile</h4>
                    <p class="text-sm text-gray-600 dark:text-gray-400 text-center">Update institution information and settings</p>
                </a>

                <a href="{{ route('partner.dashboard') }}" 
                   class="group flex flex-col items-center p-6 bg-gradient-to-br from-green-50 to-green-100 dark:from-green-900/20 dark:to-green-800/20 rounded-xl hover:from-green-100 hover:to-green-200 dark:hover:from-green-800/30 dark:hover:to-green-700/30 transition-all duration-200 border border-green-200 dark:border-green-700">
                    <div class="w-12 h-12 bg-green-100 dark:bg-green-800 rounded-lg flex items-center justify-center mb-4 group-hover:scale-110 transition-transform duration-200">
                        <svg class="w-6 h-6 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 01-2-2z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5a2 2 0 012-2h4a2 2 0 012 2v6H8V5z"></path>
                        </svg>
                    </div>
                    <h4 class="font-semibold text-gray-900 dark:text-white text-center mb-2">Dashboard</h4>
                    <p class="text-sm text-gray-600 dark:text-gray-400 text-center">Return to main dashboard</p>
                </a>

                <a href="#" 
                   class="group flex flex-col items-center p-6 bg-gradient-to-br from-purple-50 to-purple-100 dark:from-purple-900/20 dark:to-purple-800/20 rounded-xl hover:from-purple-100 hover:to-purple-200 dark:hover:from-purple-800/30 dark:hover:to-purple-700/30 transition-all duration-200 border border-purple-200 dark:border-purple-700">
                    <div class="w-12 h-12 bg-purple-100 dark:bg-purple-800 rounded-lg flex items-center justify-center mb-4 group-hover:scale-110 transition-transform duration-200">
                        <svg class="w-6 h-6 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                        </svg>
                    </div>
                    <h4 class="font-semibold text-gray-900 dark:text-white text-center mb-2">Analytics</h4>
                    <p class="text-sm text-gray-600 dark:text-gray-400 text-center">View detailed statistics and reports</p>
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
