@extends('layouts.partner-layout')

@section('title', 'Partner Profile')

@section('content')

<div class="min-h-screen bg-gradient-to-br from-slate-50 via-blue-50 to-indigo-50 dark:from-gray-900 dark:via-gray-800 dark:to-gray-900">
    <!-- Facebook-style Cover Photo Section -->
    <div class="relative bg-white dark:bg-gray-800">
        <!-- Cover Photo -->
        <div class="h-64 sm:h-80 lg:h-96 relative overflow-hidden bg-gray-200 dark:bg-gray-700">
            @if(isset($partner->cover_photo) && $partner->cover_photo)
                <img src="{{ asset('uploads/' . $partner->cover_photo) }}" 
                     alt="Cover Photo" 
                     class="w-full h-full object-cover">
            @else
                <div class="w-full h-full bg-gradient-to-br from-blue-500 to-purple-600 flex items-center justify-center">
                    <div class="text-center text-white">
                        <svg class="w-16 h-16 mx-auto mb-4 opacity-80" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                        </svg>
                        <p class="text-lg font-semibold">No Cover Photo</p>
                    </div>
                </div>
            @endif
            
            <!-- Edit Cover Photo Button -->
            <div class="absolute bottom-4 right-4">
                <button class="bg-black/50 hover:bg-black/70 text-white px-3 py-2 rounded-lg text-sm font-medium transition-colors duration-200 flex items-center space-x-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                    <span>Edit cover photo</span>
                </button>
            </div>
        </div>

        <!-- Profile Picture (Positioned over cover) -->
        <div class="absolute -bottom-16 left-4 sm:left-8">
            <div class="relative">
                <div class="w-32 h-32 sm:w-36 sm:h-36 rounded-full border-4 border-white dark:border-gray-800 overflow-hidden shadow-lg">
                    @if(isset($partner->logo) && $partner->logo)
                        <img src="{{ asset('uploads/' . $partner->logo) }}" 
                             alt="Profile Picture" 
                             class="w-full h-full object-cover">
                    @else
                        <div class="w-full h-full bg-gradient-to-br from-gray-400 to-gray-600 flex items-center justify-center">
                            <svg class="w-12 h-12 text-white" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/>
                            </svg>
                        </div>
                    @endif
                </div>
                <!-- Edit Profile Picture Button -->
                <button class="absolute -bottom-2 -right-2 w-8 h-8 bg-blue-500 hover:bg-blue-600 rounded-full border-2 border-white dark:border-gray-800 flex items-center justify-center transition-colors duration-200">
                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Profile Information Section -->
    <div class="bg-white dark:bg-gray-800 pt-20 pb-4">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col lg:flex-row lg:items-end lg:justify-between">
                <!-- Profile Info -->
                <div class="flex-1 min-w-0">
                    <h1 class="text-2xl sm:text-3xl font-bold text-gray-900 dark:text-white mb-1">
                        {{ $partner->name ?? 'Partner Name' }}
                    </h1>
                    <p class="text-lg text-gray-600 dark:text-gray-300 mb-2">
                        {{ $partner->institute_name ?? 'Institution Name' }}
                    </p>
                    @if(isset($partner->institute_name_bangla) && $partner->institute_name_bangla)
                        <p class="text-base text-gray-500 dark:text-gray-400 font-medium mb-3">
                            {{ $partner->institute_name_bangla }}
                        </p>
                    @endif
                    
                    <!-- Stats -->
                    <div class="flex items-center space-x-6 text-sm text-gray-600 dark:text-gray-400 mb-4">
                        <span class="flex items-center space-x-1">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"/>
                            </svg>
                            <span>{{ $partner->students_count ?? 0 }} students</span>
                        </span>
                        <span class="flex items-center space-x-1">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332-.477-4.5-1.253"></path>
                            </svg>
                            <span>{{ $partner->courses_count ?? 0 }} courses</span>
                        </span>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="flex flex-wrap items-center gap-3">
                <a href="{{ route('partner.profile.edit-partnar') }}" 
                       class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-semibold text-sm transition-colors duration-200">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                    </svg>
                    Edit Profile
                </a>
                    <button class="inline-flex items-center px-4 py-2 bg-gray-200 hover:bg-gray-300 dark:bg-gray-700 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-300 rounded-lg font-semibold text-sm transition-colors duration-200">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.367 2.684 3 3 0 00-5.367-2.684z"/>
                        </svg>
                        Share
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Stats Cards Section -->
    <div class="bg-white dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
            <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-4">
                <!-- Students Card -->
                <div class="bg-gradient-to-br from-blue-50 to-blue-100 dark:from-blue-900/20 dark:to-blue-800/20 rounded-lg p-3 text-center border border-blue-200 dark:border-blue-700 hover:shadow-md transition-shadow duration-200">
                    <div class="w-6 h-6 bg-blue-500 rounded-md flex items-center justify-center mx-auto mb-2">
                        <svg class="w-3 h-3 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"/>
                                    </svg>
                                </div>
                    <div class="text-lg font-bold text-blue-600 dark:text-blue-400">{{ $partner->students_count ?? 0 }}</div>
                    <div class="text-xs text-blue-500 dark:text-blue-300 font-medium">Students</div>
                        </div>
                        
                <!-- Courses Card -->
                <div class="bg-gradient-to-br from-green-50 to-green-100 dark:from-green-900/20 dark:to-green-800/20 rounded-lg p-3 text-center border border-green-200 dark:border-green-700 hover:shadow-md transition-shadow duration-200">
                    <div class="w-6 h-6 bg-green-500 rounded-md flex items-center justify-center mx-auto mb-2">
                        <svg class="w-3 h-3 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332-.477-4.5-1.253"></path>
                        </svg>
                    </div>
                    <div class="text-lg font-bold text-green-600 dark:text-green-400">{{ $partner->courses_count ?? 0 }}</div>
                    <div class="text-xs text-green-500 dark:text-green-300 font-medium">Courses</div>
            </div>

                <!-- Batches Card -->
                <div class="bg-gradient-to-br from-purple-50 to-purple-100 dark:from-purple-900/20 dark:to-purple-800/20 rounded-lg p-3 text-center border border-purple-200 dark:border-purple-700 hover:shadow-md transition-shadow duration-200">
                    <div class="w-6 h-6 bg-purple-500 rounded-md flex items-center justify-center mx-auto mb-2">
                        <svg class="w-3 h-3 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                    </svg>
                    </div>
                    <div class="text-lg font-bold text-purple-600 dark:text-purple-400">{{ $partner->batches_count ?? 0 }}</div>
                    <div class="text-xs text-purple-500 dark:text-purple-300 font-medium">Batches</div>
                </div>

                <!-- Subjects Card -->
                <div class="bg-gradient-to-br from-orange-50 to-orange-100 dark:from-orange-900/20 dark:to-orange-800/20 rounded-lg p-3 text-center border border-orange-200 dark:border-orange-700 hover:shadow-md transition-shadow duration-200">
                    <div class="w-6 h-6 bg-orange-500 rounded-md flex items-center justify-center mx-auto mb-2">
                        <svg class="w-3 h-3 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                    </div>
                    <div class="text-lg font-bold text-orange-600 dark:text-orange-400">{{ $partner->subjects_count ?? 0 }}</div>
                    <div class="text-xs text-orange-500 dark:text-orange-300 font-medium">Subjects</div>
                </div>

                <!-- Topics Card -->
                <div class="bg-gradient-to-br from-pink-50 to-pink-100 dark:from-pink-900/20 dark:to-pink-800/20 rounded-lg p-3 text-center border border-pink-200 dark:border-pink-700 hover:shadow-md transition-shadow duration-200">
                    <div class="w-6 h-6 bg-pink-500 rounded-md flex items-center justify-center mx-auto mb-2">
                        <svg class="w-3 h-3 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                        </svg>
                    </div>
                    <div class="text-lg font-bold text-pink-600 dark:text-pink-400">{{ $partner->topics_count ?? 0 }}</div>
                    <div class="text-xs text-pink-500 dark:text-pink-300 font-medium">Topics</div>
                </div>

                <!-- Questions Card -->
                <div class="bg-gradient-to-br from-indigo-50 to-indigo-100 dark:from-indigo-900/20 dark:to-indigo-800/20 rounded-lg p-3 text-center border border-indigo-200 dark:border-indigo-700 hover:shadow-md transition-shadow duration-200">
                    <div class="w-6 h-6 bg-indigo-500 rounded-md flex items-center justify-center mx-auto mb-2">
                        <svg class="w-3 h-3 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <div class="text-lg font-bold text-indigo-600 dark:text-indigo-400">{{ $partner->questions_count ?? 0 }}</div>
                    <div class="text-xs text-indigo-500 dark:text-indigo-300 font-medium">Questions</div>
                </div>
            </div>
        </div>
    </div>


    <!-- Main Content -->
    <div class="px-4 sm:px-6 lg:px-8 pb-8">
        <div class="max-w-7xl mx-auto">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 lg:gap-8">
                <!-- Left Column -->
                <div class="lg:col-span-2 space-y-6">
                    <!-- Contact Information -->
                    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl overflow-hidden">
                        <div class="bg-gradient-to-r from-indigo-500 to-purple-600 px-6 py-4">
                            <h3 class="text-xl font-bold text-white flex items-center">
                                <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                        </svg>
                                Contact Information
                    </h3>
                </div>
                        <div class="p-6">
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                                <!-- Primary Contact -->
                                <div class="space-y-4">
                                    <div class="flex items-start space-x-3">
                                        <div class="w-10 h-10 bg-blue-100 dark:bg-blue-900/30 rounded-lg flex items-center justify-center flex-shrink-0">
                                            <svg class="w-5 h-5 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                                    </svg>
                            </div>
                            <div>
                                            <h4 class="font-semibold text-gray-900 dark:text-white">Primary Contact</h4>
                                            <p class="text-gray-600 dark:text-gray-300">{{ $partner->phone ?? 'N/A' }}</p>
                                            <p class="text-gray-600 dark:text-gray-300">{{ $partner->mobile ?? 'N/A' }}</p>
                                </div>
                            </div>

                                    <div class="flex items-start space-x-3">
                                        <div class="w-10 h-10 bg-green-100 dark:bg-green-900/30 rounded-lg flex items-center justify-center flex-shrink-0">
                                            <svg class="w-5 h-5 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                    </svg>
                            </div>
                            <div>
                                            <h4 class="font-semibold text-gray-900 dark:text-white">Email</h4>
                                            <p class="text-gray-600 dark:text-gray-300">{{ $partner->email ?? 'N/A' }}</p>
                                </div>
                            </div>

                                    @if(isset($partner->website) && $partner->website)
                                    <div class="flex items-start space-x-3">
                                        <div class="w-10 h-10 bg-purple-100 dark:bg-purple-900/30 rounded-lg flex items-center justify-center flex-shrink-0">
                                            <svg class="w-5 h-5 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9v-9m0-9v9"/>
                                            </svg>
                        </div>
                            <div>
                                            <h4 class="font-semibold text-gray-900 dark:text-white">Website</h4>
                                            <a href="{{ $partner->website }}" target="_blank" class="text-blue-600 dark:text-blue-400 hover:underline">{{ $partner->website }}</a>
                                        </div>
                                    </div>
                                    @endif
                                </div>

                                <!-- Alternate Contact -->
                                <div class="space-y-4">
                                    @if(isset($partner->alternate_contact_person) && $partner->alternate_contact_person)
                                    <div class="flex items-start space-x-3">
                                        <div class="w-10 h-10 bg-orange-100 dark:bg-orange-900/30 rounded-lg flex items-center justify-center flex-shrink-0">
                                            <svg class="w-5 h-5 text-orange-600 dark:text-orange-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                            </svg>
                            </div>
                            <div>
                                            <h4 class="font-semibold text-gray-900 dark:text-white">Alternate Contact</h4>
                                            <p class="text-gray-600 dark:text-gray-300">{{ $partner->alternate_contact_person }}</p>
                                            <p class="text-gray-600 dark:text-gray-300">{{ $partner->alternate_contact_no ?? 'N/A' }}</p>
                                </div>
                            </div>
                                    @endif

                                    @if(isset($partner->owner_director_name) && $partner->owner_director_name)
                                    <div class="flex items-start space-x-3">
                                        <div class="w-10 h-10 bg-indigo-100 dark:bg-indigo-900/30 rounded-lg flex items-center justify-center flex-shrink-0">
                                            <svg class="w-5 h-5 text-indigo-600 dark:text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                                    </svg>
                            </div>
                            <div>
                                            <h4 class="font-semibold text-gray-900 dark:text-white">Owner/Director</h4>
                                            <p class="text-gray-600 dark:text-gray-300">{{ $partner->owner_director_name }}</p>
                                            <p class="text-gray-600 dark:text-gray-300">{{ $partner->owner_director_contact ?? 'N/A' }}</p>
                                </div>
                            </div>
                                    @endif
                        </div>
                    </div>
                </div>
            </div>

                    <!-- Location Information -->
                    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl overflow-hidden">
                        <div class="bg-gradient-to-r from-green-500 to-teal-600 px-6 py-4">
                            <h3 class="text-xl font-bold text-white flex items-center">
                                <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                         </svg>
                                Location Information
                     </h3>
                 </div>
                 <div class="p-6">
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                         <div class="space-y-4">
                                    @if(isset($partner->division) && $partner->division)
                                        <div class="flex items-center space-x-3">
                                            <div class="w-8 h-8 bg-blue-100 dark:bg-blue-900/30 rounded-lg flex items-center justify-center">
                                                <svg class="w-4 h-4 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                                     </svg>
                             </div>
                             <div>
                                                <p class="text-sm text-gray-500 dark:text-gray-400">Division</p>
                                                <p class="font-semibold text-gray-900 dark:text-white">{{ $partner->division }}</p>
                                 </div>
                             </div>
                                    @endif

                                    @if(isset($partner->district) && $partner->district)
                                        <div class="flex items-center space-x-3">
                                            <div class="w-8 h-8 bg-green-100 dark:bg-green-900/30 rounded-lg flex items-center justify-center">
                                                <svg class="w-4 h-4 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                                     </svg>
                             </div>
                             <div>
                                                <p class="text-sm text-gray-500 dark:text-gray-400">District</p>
                                                <p class="font-semibold text-gray-900 dark:text-white">{{ $partner->district }}</p>
                                 </div>
                             </div>
                                    @endif

                                    @if(isset($partner->upazila) && $partner->upazila)
                                        <div class="flex items-center space-x-3">
                                            <div class="w-8 h-8 bg-purple-100 dark:bg-purple-900/30 rounded-lg flex items-center justify-center">
                                                <svg class="w-4 h-4 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                                     </svg>
                             </div>
                             <div>
                                                <p class="text-sm text-gray-500 dark:text-gray-400">Upazila</p>
                                                <p class="font-semibold text-gray-900 dark:text-white">{{ $partner->upazila }}</p>
                                 </div>
                             </div>
                                    @endif
                          </div>

                         <div class="space-y-4">
                                    @if(isset($partner->city) && $partner->city)
                                        <div class="flex items-center space-x-3">
                                            <div class="w-8 h-8 bg-orange-100 dark:bg-orange-900/30 rounded-lg flex items-center justify-center">
                                                <svg class="w-4 h-4 text-orange-600 dark:text-orange-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                                     </svg>
                             </div>
                             <div>
                                                <p class="text-sm text-gray-500 dark:text-gray-400">City</p>
                                                <p class="font-semibold text-gray-900 dark:text-white">{{ $partner->city }}</p>
                                 </div>
                             </div>
                                    @endif

                                    @if(isset($partner->post_office) && $partner->post_office)
                                        <div class="flex items-center space-x-3">
                                            <div class="w-8 h-8 bg-teal-100 dark:bg-teal-900/30 rounded-lg flex items-center justify-center">
                                                <svg class="w-4 h-4 text-teal-600 dark:text-teal-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                     </svg>
                                 </div>
                                            <div>
                                                <p class="text-sm text-gray-500 dark:text-gray-400">Post Office</p>
                                                <p class="font-semibold text-gray-900 dark:text-white">{{ $partner->post_office }}</p>
                             </div>
                         </div>
                                    @endif

                                    @if(isset($partner->post_code) && $partner->post_code)
                                        <div class="flex items-center space-x-3">
                                            <div class="w-8 h-8 bg-red-100 dark:bg-red-900/30 rounded-lg flex items-center justify-center">
                                                <svg class="w-4 h-4 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 20l4-16m2 16l4-16M6 9h14M4 15h14"/>
                                     </svg>
                             </div>
                             <div>
                                                <p class="text-sm text-gray-500 dark:text-gray-400">Post Code</p>
                                                <p class="font-semibold text-gray-900 dark:text-white">{{ $partner->post_code }}</p>
                                 </div>
                             </div>
                                         @endif
                 </div>
                          </div>

                            @if(isset($partner->short_address) && $partner->short_address)
                                <div class="mt-6 p-4 bg-gray-50 dark:bg-gray-700 rounded-xl">
                                    <h4 class="font-semibold text-gray-900 dark:text-white mb-2">Short Address</h4>
                                    <p class="text-gray-600 dark:text-gray-300">{{ $partner->short_address }}</p>
                                    @if(isset($partner->short_address_bangla) && $partner->short_address_bangla)
                                        <p class="text-gray-600 dark:text-gray-300 mt-1">{{ $partner->short_address_bangla }}</p>
                                    @endif
                             </div>
                         @endif
                     </div>
                 </div>
             </div>

                <!-- Right Column -->
                <div class="space-y-6">
                    <!-- Institute Details -->
                    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl overflow-hidden">
                        <div class="bg-gradient-to-r from-purple-500 to-pink-600 px-6 py-4">
                            <h3 class="text-xl font-bold text-white flex items-center">
                                <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                        </svg>
                                Institute Details
                    </h3>
                </div>
                        <div class="p-6 space-y-4">
                            @if(isset($partner->eiin_no) && $partner->eiin_no)
                                <div class="flex items-center justify-between">
                                    <span class="text-gray-600 dark:text-gray-400">EIIN No</span>
                                    <span class="font-semibold text-gray-900 dark:text-white">{{ $partner->eiin_no }}</span>
                                </div>
                            @endif

                            @if(isset($partner->trade_license_no) && $partner->trade_license_no)
                                <div class="flex items-center justify-between">
                                    <span class="text-gray-600 dark:text-gray-400">Trade License</span>
                                    <span class="font-semibold text-gray-900 dark:text-white">{{ $partner->trade_license_no }}</span>
                            </div>
                            @endif

                            @if(isset($partner->tin_no) && $partner->tin_no)
                                <div class="flex items-center justify-between">
                                    <span class="text-gray-600 dark:text-gray-400">TIN No</span>
                                    <span class="font-semibold text-gray-900 dark:text-white">{{ $partner->tin_no }}</span>
                                </div>
                            @endif

                            @if(isset($partner->established_year) && $partner->established_year)
                                <div class="flex items-center justify-between">
                                    <span class="text-gray-600 dark:text-gray-400">Established</span>
                                    <span class="font-semibold text-gray-900 dark:text-white">{{ $partner->established_year }}</span>
                                </div>
                            @endif
                                </div>
                            </div>

                    <!-- Social Links -->
                    @if(isset($partner->facebook_page) && $partner->facebook_page)
                    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl overflow-hidden">
                        <div class="bg-gradient-to-r from-blue-500 to-blue-600 px-6 py-4">
                            <h3 class="text-xl font-bold text-white flex items-center">
                                <svg class="w-6 h-6 mr-3" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M24 4.557c-.883.392-1.832.656-2.828.775 1.017-.609 1.798-1.574 2.165-2.724-.951.564-2.005.974-3.127 1.195-.897-.957-2.178-1.555-3.594-1.555-3.179 0-5.515 2.966-4.797 6.045-4.091-.205-7.719-2.165-10.148-5.144-1.29 2.213-.669 5.108 1.523 6.574-.806-.026-1.566-.247-2.229-.616-.054 2.281 1.581 4.415 3.949 4.89-.693.188-1.452.232-2.224.084.626 1.956 2.444 3.379 4.6 3.419-2.07 1.623-4.678 2.348-7.29 2.04 2.179 1.397 4.768 2.212 7.548 2.212 9.142 0 14.307-7.721 13.995-14.646.962-.695 1.797-1.562 2.457-2.549z"/>
                                </svg>
                                Social Media
                            </h3>
                        </div>
                        <div class="p-6">
                            <a href="{{ $partner->facebook_page }}" target="_blank" 
                               class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition-colors duration-200">
                                <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                                    </svg>
                                Facebook Page
                            </a>
                                </div>
                            </div>
                    @endif

                    <!-- Quick Actions -->
                    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl overflow-hidden">
                        <div class="bg-gradient-to-r from-gray-600 to-gray-700 px-6 py-4">
                            <h3 class="text-xl font-bold text-white flex items-center">
                                <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                                </svg>
                                Quick Actions
                            </h3>
                        </div>
                        <div class="p-6 space-y-3">
                            <a href="{{ route('partner.students.index') }}" 
                               class="flex items-center justify-between p-3 bg-blue-50 dark:bg-blue-900/20 rounded-lg hover:bg-blue-100 dark:hover:bg-blue-900/30 transition-colors duration-200">
                                <div class="flex items-center">
                                    <svg class="w-5 h-5 text-blue-600 dark:text-blue-400 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"/>
                                    </svg>
                                    <span class="font-medium text-gray-900 dark:text-white">Manage Students</span>
                                </div>
                                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                </svg>
                            </a>

                            <a href="{{ route('partner.courses.index') }}" 
                               class="flex items-center justify-between p-3 bg-green-50 dark:bg-green-900/20 rounded-lg hover:bg-green-100 dark:hover:bg-green-900/30 transition-colors duration-200">
                                <div class="flex items-center">
                                    <svg class="w-5 h-5 text-green-600 dark:text-green-400 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332-.477-4.5-1.253"/>
                                    </svg>
                                    <span class="font-medium text-gray-900 dark:text-white">Manage Courses</span>
                                </div>
                                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                </svg>
                            </a>

                            <a href="{{ route('partner.enrollments.index') }}" 
                               class="flex items-center justify-between p-3 bg-purple-50 dark:bg-purple-900/20 rounded-lg hover:bg-purple-100 dark:hover:bg-purple-900/30 transition-colors duration-200">
                                <div class="flex items-center">
                                    <svg class="w-5 h-5 text-purple-600 dark:text-purple-400 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/>
                                    </svg>
                                    <span class="font-medium text-gray-900 dark:text-white">Manage Enrollments</span>
                                </div>
                                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection