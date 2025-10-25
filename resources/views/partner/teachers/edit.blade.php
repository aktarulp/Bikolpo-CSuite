@extends('layouts.partner-layout')

@section('title', 'Edit Teacher')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-slate-50 via-blue-50 to-indigo-50 dark:from-gray-900 dark:via-slate-900 dark:to-gray-900">
    <div class="container mx-auto px-4 py-6 sm:px-6 lg:px-8">
        <!-- Beautiful Teacher Edit Header -->
        <div class="mb-8">
            <!-- Back Button -->
            <div class="flex items-center gap-4 mb-6">
                <a href="{{ route('partner.teachers.show', $teacher) }}" 
                   class="group flex items-center justify-center w-12 h-12 bg-white dark:bg-gray-800 rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 hover:scale-105">
                    <svg class="w-5 h-5 text-gray-600 dark:text-gray-400 group-hover:text-blue-600 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                    </svg>
                </a>
                <div class="flex-1">
                    <h1 class="text-2xl sm:text-3xl lg:text-4xl font-bold bg-gradient-to-r from-gray-900 via-blue-600 to-indigo-600 dark:from-white dark:via-blue-400 dark:to-indigo-400 bg-clip-text text-transparent">
                        Edit Teacher
                    </h1>
                </div>
            </div>

            <!-- Teacher Profile Header Card -->
            <div class="bg-white dark:bg-gray-800 rounded-3xl shadow-2xl border border-gray-200 dark:border-gray-700 overflow-hidden">
                <div class="bg-gradient-to-r from-blue-500 via-indigo-600 to-purple-600 p-8">
                    <div class="flex flex-col sm:flex-row items-center gap-6">
                        <!-- Teacher Photo -->
                        <div class="relative">
                            <div class="w-24 h-24 sm:w-32 sm:h-32 rounded-3xl overflow-hidden shadow-2xl border-4 border-white/20">
                                @if($teacher->photo)
                                    @php
                                        // Handle different photo path formats - same logic as student views
                                        $photoPath = $teacher->photo;
                                        
                                        if (str_starts_with($photoPath, 'teachers/') || str_starts_with($photoPath, 'teacher-photos/')) {
                                            $photoUrl = asset('uploads/' . $photoPath);
                                        } else {
                                            // Try both possible directories
                                            $teachersPath = 'teachers/' . $photoPath;
                                            $teacherPhotosPath = 'teacher-photos/' . $photoPath;
                                            
                                            if (Storage::disk('public')->exists($teachersPath)) {
                                                $photoUrl = asset('uploads/' . $teachersPath);
                                            } elseif (Storage::disk('public')->exists($teacherPhotosPath)) {
                                                $photoUrl = asset('uploads/' . $teacherPhotosPath);
                                            } else {
                                                $photoUrl = asset('uploads/' . $photoPath);
                                            }
                                        }
                                    @endphp
                                    <img src="{{ $photoUrl }}" alt="{{ $teacher->full_name }}" class="w-full h-full object-cover">
                                @else
                                    <div class="w-full h-full bg-gradient-to-br from-white/30 to-white/10 flex items-center justify-center">
                                        <span class="text-4xl sm:text-5xl">{{ $teacher->getGenderIcon() }}</span>
                                    </div>
                                @endif
                            </div>
                            <!-- Status Badge -->
                            <div class="absolute -bottom-2 -right-2">
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold {{ $teacher->getStatusBadgeClass() }} backdrop-blur-sm shadow-lg">
                                    {{ $teacher->employment_status }}
                                </span>
                            </div>
                        </div>

                        <!-- Teacher Information -->
                        <div class="flex-1 text-center sm:text-left">
                            <div class="mb-4">
                                <h2 class="text-2xl sm:text-3xl lg:text-4xl font-bold text-white mb-2">
                                    {{ $teacher->full_name }}
                                </h2>
                                <div class="flex flex-col sm:flex-row items-center sm:items-start gap-2 sm:gap-4">
                                    <span class="inline-flex items-center px-4 py-2 bg-white/20 backdrop-blur-sm rounded-xl text-white font-semibold text-sm">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2"></path>
                                        </svg>
                                        {{ $teacher->teacher_id }}
                                    </span>
                                    @if($teacher->designation)
                                        <span class="inline-flex items-center px-4 py-2 bg-white/20 backdrop-blur-sm rounded-xl text-white font-semibold text-sm">
                                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2-2v2m8 0V6a2 2 0 012 2v6a2 2 0 01-2 2H6a2 2 0 01-2-2V8a2 2 0 012-2V6"></path>
                                            </svg>
                                            {{ $teacher->designation }}
                                        </span>
                                    @endif
                                </div>
                            </div>
                            
                            <!-- Additional Info -->
                            <div class="flex flex-wrap gap-3 justify-center sm:justify-start">
                                @if($teacher->department)
                                    <span class="inline-flex items-center px-3 py-1.5 bg-white/10 backdrop-blur-sm rounded-lg text-white/90 text-sm">
                                        <svg class="w-3 h-3 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                        </svg>
                                        {{ $teacher->department }}
                                    </span>
                                @endif
                                @if($teacher->phone)
                                    <span class="inline-flex items-center px-3 py-1.5 bg-white/10 backdrop-blur-sm rounded-lg text-white/90 text-sm">
                                        <svg class="w-3 h-3 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                                        </svg>
                                        {{ $teacher->phone }}
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Form -->
        <form action="{{ route('partner.teachers.update', $teacher) }}" method="POST" enctype="multipart/form-data" class="space-y-8" id="teacher-form">
            @csrf
            @method('PUT')


            <!-- Personal Information Card -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl border border-gray-200 dark:border-gray-700 overflow-hidden">
                <div class="bg-gradient-to-r from-blue-500 to-indigo-600 px-6 py-4">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-white/20 rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                        </div>
                        <div>
                            <h2 class="text-xl font-bold text-white">Personal Information</h2>
                            <p class="text-blue-100 text-sm">Basic details about the teacher</p>
                        </div>
                    </div>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                        <!-- Teacher ID -->
                        <div class="relative">
                            <label for="teacher_id" class="absolute -top-2 left-3 bg-white dark:bg-gray-800 px-2 text-xs font-semibold text-indigo-600 dark:text-indigo-400 z-10">
                                Teacher ID *
                            </label>
                            <input type="text" name="teacher_id" id="teacher_id" required
                                   class="w-full px-4 py-3 pt-5 border-2 border-gray-200 dark:border-gray-600 rounded-xl focus:ring-4 focus:ring-indigo-500/20 focus:border-indigo-500 dark:bg-gray-700 dark:text-white transition-all duration-200 hover:border-gray-300 dark:hover:border-gray-500"
                                   value="{{ old('teacher_id', $teacher->teacher_id) }}"
                                   placeholder="Enter teacher ID (e.g., TCH-2024-001)">
                            @error('teacher_id')
                                <p class="mt-1 text-xs text-red-600 flex items-center gap-1">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <!-- Full Name (English) -->
                        <div class="relative">
                            <label for="full_name" class="absolute -top-2 left-3 bg-white dark:bg-gray-800 px-2 text-xs font-semibold text-blue-600 dark:text-blue-400 z-10">
                                Full Name *
                            </label>
                            <input type="text" name="full_name" id="full_name" required value="{{ old('full_name', $teacher->full_name) }}"
                                   class="w-full px-4 py-3 pt-5 border-2 border-gray-200 dark:border-gray-600 rounded-xl focus:ring-4 focus:ring-blue-500/20 focus:border-blue-500 dark:bg-gray-700 dark:text-white transition-all duration-200 hover:border-gray-300 dark:hover:border-gray-500"
                                   placeholder="Enter full name">
                            @error('full_name')
                                <p class="mt-1 text-xs text-red-600 flex items-center gap-1">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <!-- Gender -->
                        <div class="relative">
                            <label for="gender" class="absolute -top-2 left-3 bg-white dark:bg-gray-800 px-2 text-xs font-semibold text-pink-600 dark:text-pink-400 z-10">
                                Gender *
                            </label>
                            
                            
                            <select name="gender" id="gender" required 
                                    class="w-full px-4 py-3 pt-5 border-2 border-gray-200 dark:border-gray-600 rounded-xl focus:ring-4 focus:ring-pink-500/20 focus:border-pink-500 dark:bg-gray-700 dark:text-white transition-all duration-200 hover:border-gray-300 dark:hover:border-gray-500">
                                <option value="">Select Gender</option>
                                <option value="Male" {{ strtolower($teacher->gender) === 'male' ? 'selected' : '' }}>👨 Male</option>
                                <option value="Female" {{ strtolower($teacher->gender) === 'female' ? 'selected' : '' }}>👩 Female</option>
                                <option value="Other" {{ strtolower($teacher->gender) === 'other' ? 'selected' : '' }}>👤 Other</option>
                            </select>
                            @error('gender')
                                <p class="mt-1 text-xs text-red-600 flex items-center gap-1">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <!-- Date of Birth -->
                        <div class="relative">
                            <label for="date_of_birth" class="absolute -top-2 left-3 bg-white dark:bg-gray-800 px-2 text-xs font-semibold text-green-600 dark:text-green-400 z-10">
                                Date of Birth
                            </label>
                            <input type="date" name="date_of_birth" id="date_of_birth" value="{{ old('date_of_birth', $teacher->date_of_birth?->format('Y-m-d')) }}"
                                   class="w-full px-4 py-3 pt-5 border-2 border-gray-200 dark:border-gray-600 rounded-xl focus:ring-4 focus:ring-green-500/20 focus:border-green-500 dark:bg-gray-700 dark:text-white transition-all duration-200 hover:border-gray-300 dark:hover:border-gray-500">
                            @error('date_of_birth')
                                <p class="mt-1 text-xs text-red-600 flex items-center gap-1">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <!-- Blood Group -->
                        <div class="relative">
                            <label for="blood_group" class="absolute -top-2 left-3 bg-white dark:bg-gray-800 px-2 text-xs font-semibold text-red-600 dark:text-red-400 z-10">
                                Blood Group
                            </label>
                            <select name="blood_group" id="blood_group" 
                                    class="w-full px-4 py-3 pt-5 border-2 border-gray-200 dark:border-gray-600 rounded-xl focus:ring-4 focus:ring-red-500/20 focus:border-red-500 dark:bg-gray-700 dark:text-white transition-all duration-200 hover:border-gray-300 dark:hover:border-gray-500">
                                <option value="">Select Blood Group</option>
                                <option value="A+" {{ old('blood_group', $teacher->blood_group) == 'A+' ? 'selected' : '' }}>A+</option>
                                <option value="A-" {{ old('blood_group', $teacher->blood_group) == 'A-' ? 'selected' : '' }}>A-</option>
                                <option value="B+" {{ old('blood_group', $teacher->blood_group) == 'B+' ? 'selected' : '' }}>B+</option>
                                <option value="B-" {{ old('blood_group', $teacher->blood_group) == 'B-' ? 'selected' : '' }}>B-</option>
                                <option value="AB+" {{ old('blood_group', $teacher->blood_group) == 'AB+' ? 'selected' : '' }}>AB+</option>
                                <option value="AB-" {{ old('blood_group', $teacher->blood_group) == 'AB-' ? 'selected' : '' }}>AB-</option>
                                <option value="O+" {{ old('blood_group', $teacher->blood_group) == 'O+' ? 'selected' : '' }}>O+</option>
                                <option value="O-" {{ old('blood_group', $teacher->blood_group) == 'O-' ? 'selected' : '' }}>O-</option>
                            </select>
                            @error('blood_group')
                                <p class="mt-1 text-xs text-red-600 flex items-center gap-1">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <!-- Photo Upload -->
                        <div class="relative">
                            <label for="photo" class="absolute -top-2 left-3 bg-white dark:bg-gray-800 px-2 text-xs font-semibold text-purple-600 dark:text-purple-400 z-10">
                                Update Photo
                            </label>
                            <input type="file" name="photo" id="photo" accept="image/*"
                                   class="w-full px-4 py-3 pt-5 border-2 border-gray-200 dark:border-gray-600 rounded-xl focus:ring-4 focus:ring-purple-500/20 focus:border-purple-500 dark:bg-gray-700 dark:text-white transition-all duration-200 hover:border-gray-300 dark:hover:border-gray-500">
                            <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Leave empty to keep current photo. Max size: 2MB</p>
                            @error('photo')
                                <p class="mt-1 text-xs text-red-600 flex items-center gap-1">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                    </div>
                </div>
            </div>

            <!-- Professional Information -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl border border-gray-200 dark:border-gray-700 overflow-hidden">
                <div class="bg-gradient-to-r from-purple-500 to-violet-600 px-6 py-4">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-white/20 rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2-2v2m8 0V6a2 2 0 012 2v6a2 2 0 01-2 2H6a2 2 0 01-2-2V8a2 2 0 012-2V6"></path>
                            </svg>
                        </div>
                        <div>
                            <h2 class="text-xl font-bold text-white">Professional Information</h2>
                            <p class="text-purple-100 text-sm">Job details and work experience</p>
                        </div>
                    </div>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                        <!-- Designation -->
                        <div class="relative">
                            <label for="designation" class="absolute -top-2 left-3 bg-white dark:bg-gray-800 px-2 text-xs font-semibold text-purple-600 dark:text-purple-400 z-10">
                                Designation
                            </label>
                            <input type="text" name="designation" id="designation" value="{{ old('designation', $teacher->designation) }}"
                                   class="w-full px-4 py-3 pt-5 border-2 border-gray-200 dark:border-gray-600 rounded-xl focus:ring-4 focus:ring-purple-500/20 focus:border-purple-500 dark:bg-gray-700 dark:text-white transition-all duration-200 hover:border-gray-300 dark:hover:border-gray-500"
                                   placeholder="Enter designation">
                            @error('designation')
                                <p class="mt-1 text-xs text-red-600 flex items-center gap-1">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <!-- Department -->
                        <div class="relative">
                            <label for="department" class="absolute -top-2 left-3 bg-white dark:bg-gray-800 px-2 text-xs font-semibold text-violet-600 dark:text-violet-400 z-10">
                                Department
                            </label>
                            <input type="text" name="department" id="department" value="{{ old('department', $teacher->department) }}"
                                   class="w-full px-4 py-3 pt-5 border-2 border-gray-200 dark:border-gray-600 rounded-xl focus:ring-4 focus:ring-violet-500/20 focus:border-violet-500 dark:bg-gray-700 dark:text-white transition-all duration-200 hover:border-gray-300 dark:hover:border-gray-500"
                                   placeholder="Enter department">
                            @error('department')
                                <p class="mt-1 text-xs text-red-600 flex items-center gap-1">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <!-- Subject Specialization -->
                        <div class="relative">
                            <label for="subject_specialization" class="absolute -top-2 left-3 bg-white dark:bg-gray-800 px-2 text-xs font-semibold text-indigo-600 dark:text-indigo-400 z-10">
                                Subject Specialization
                            </label>
                            <input type="text" name="subject_specialization" id="subject_specialization" value="{{ old('subject_specialization', $teacher->subject_specialization) }}"
                                   class="w-full px-4 py-3 pt-5 border-2 border-gray-200 dark:border-gray-600 rounded-xl focus:ring-4 focus:ring-indigo-500/20 focus:border-indigo-500 dark:bg-gray-700 dark:text-white transition-all duration-200 hover:border-gray-300 dark:hover:border-gray-500"
                                   placeholder="Enter subject specialization">
                            @error('subject_specialization')
                                <p class="mt-1 text-xs text-red-600 flex items-center gap-1">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <!-- Joining Date -->
                        <div class="relative">
                            <label for="joining_date" class="absolute -top-2 left-3 bg-white dark:bg-gray-800 px-2 text-xs font-semibold text-emerald-600 dark:text-emerald-400 z-10">
                                Joining Date
                            </label>
                            <input type="date" name="joining_date" id="joining_date" value="{{ old('joining_date', $teacher->joining_date?->format('Y-m-d')) }}"
                                   class="w-full px-4 py-3 pt-5 border-2 border-gray-200 dark:border-gray-600 rounded-xl focus:ring-4 focus:ring-emerald-500/20 focus:border-emerald-500 dark:bg-gray-700 dark:text-white transition-all duration-200 hover:border-gray-300 dark:hover:border-gray-500">
                            @error('joining_date')
                                <p class="mt-1 text-xs text-red-600 flex items-center gap-1">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <!-- Experience Years -->
                        <div class="relative">
                            <label for="experience_years" class="absolute -top-2 left-3 bg-white dark:bg-gray-800 px-2 text-xs font-semibold text-amber-600 dark:text-amber-400 z-10">
                                Experience (Years)
                            </label>
                            <input type="number" name="experience_years" id="experience_years" min="0" value="{{ old('experience_years', $teacher->experience_years ?? 0) }}"
                                   class="w-full px-4 py-3 pt-5 border-2 border-gray-200 dark:border-gray-600 rounded-xl focus:ring-4 focus:ring-amber-500/20 focus:border-amber-500 dark:bg-gray-700 dark:text-white transition-all duration-200 hover:border-gray-300 dark:hover:border-gray-500"
                                   placeholder="Enter years of experience">
                            @error('experience_years')
                                <p class="mt-1 text-xs text-red-600 flex items-center gap-1">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <!-- Status -->
                        <div class="relative">
                            <label for="employment_status" class="absolute -top-2 left-3 bg-white dark:bg-gray-800 px-2 text-xs font-semibold text-cyan-600 dark:text-cyan-400 z-10">
                                Employment Status *
                            </label>
                            <select name="employment_status" id="employment_status" required 
                                    class="w-full px-4 py-3 pt-5 border-2 border-gray-200 dark:border-gray-600 rounded-xl focus:ring-4 focus:ring-cyan-500/20 focus:border-cyan-500 dark:bg-gray-700 dark:text-white transition-all duration-200 hover:border-gray-300 dark:hover:border-gray-500">
                                <option value="Active" {{ old('employment_status', $teacher->employment_status) == 'Active' ? 'selected' : '' }}>Active</option>
                                <option value="Inactive" {{ old('employment_status', $teacher->employment_status) == 'Inactive' ? 'selected' : '' }}>Inactive</option>
                                <option value="On Leave" {{ old('employment_status', $teacher->employment_status) == 'On Leave' ? 'selected' : '' }}>On Leave</option>
                            </select>
                            @error('employment_status')
                                <p class="mt-1 text-xs text-red-600 flex items-center gap-1">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            <!-- Contact Information -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl border border-gray-200 dark:border-gray-700 overflow-hidden">
                <div class="bg-gradient-to-r from-green-500 to-emerald-600 px-6 py-4">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-white/20 rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                            </svg>
                        </div>
                        <div>
                            <h2 class="text-xl font-bold text-white">Contact Information</h2>
                            <p class="text-green-100 text-sm">Phone numbers, email, and addresses</p>
                        </div>
                    </div>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                        <!-- Mobile -->
                        <div class="relative">
                            <label for="phone" class="absolute -top-2 left-3 bg-white dark:bg-gray-800 px-2 text-xs font-semibold text-green-600 dark:text-green-400 z-10">
                                Phone Number *
                            </label>
                            <input type="text" name="phone" id="phone" required value="{{ old('phone', $teacher->phone) }}"
                                   class="w-full px-4 py-3 pt-5 border-2 border-gray-200 dark:border-gray-600 rounded-xl focus:ring-4 focus:ring-green-500/20 focus:border-green-500 dark:bg-gray-700 dark:text-white transition-all duration-200 hover:border-gray-300 dark:hover:border-gray-500"
                                   placeholder="Enter phone number">
                            @error('phone')
                                <p class="mt-1 text-xs text-red-600 flex items-center gap-1">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <!-- Alternative Mobile -->
                        <div class="relative">
                            <label for="alternate_phone" class="absolute -top-2 left-3 bg-white dark:bg-gray-800 px-2 text-xs font-semibold text-teal-600 dark:text-teal-400 z-10">
                                Alternative Phone
                            </label>
                            <input type="text" name="alternate_phone" id="alternate_phone" value="{{ old('alternate_phone', $teacher->alternate_phone) }}"
                                   class="w-full px-4 py-3 pt-5 border-2 border-gray-200 dark:border-gray-600 rounded-xl focus:ring-4 focus:ring-teal-500/20 focus:border-teal-500 dark:bg-gray-700 dark:text-white transition-all duration-200 hover:border-gray-300 dark:hover:border-gray-500"
                                   placeholder="Enter alternative phone">
                            @error('alternate_phone')
                                <p class="mt-1 text-xs text-red-600 flex items-center gap-1">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <!-- Email -->
                        <div class="relative">
                            <label for="email" class="absolute -top-2 left-3 bg-white dark:bg-gray-800 px-2 text-xs font-semibold text-blue-600 dark:text-blue-400 z-10">
                                Email Address
                            </label>
                            <input type="email" name="email" id="email" value="{{ old('email', $teacher->email) }}"
                                   class="w-full px-4 py-3 pt-5 border-2 border-gray-200 dark:border-gray-600 rounded-xl focus:ring-4 focus:ring-blue-500/20 focus:border-blue-500 dark:bg-gray-700 dark:text-white transition-all duration-200 hover:border-gray-300 dark:hover:border-gray-500"
                                   placeholder="Enter email address">
                            @error('email')
                                <p class="mt-1 text-xs text-red-600 flex items-center gap-1">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <!-- Emergency Contact Name -->
                        <div class="relative">
                            <label for="emergency_contact_name" class="absolute -top-2 left-3 bg-white dark:bg-gray-800 px-2 text-xs font-semibold text-orange-600 dark:text-orange-400 z-10">
                                Emergency Contact Name
                            </label>
                            <input type="text" name="emergency_contact_name" id="emergency_contact_name" value="{{ old('emergency_contact_name', $teacher->emergency_contact_name) }}"
                                   class="w-full px-4 py-3 pt-5 border-2 border-gray-200 dark:border-gray-600 rounded-xl focus:ring-4 focus:ring-orange-500/20 focus:border-orange-500 dark:bg-gray-700 dark:text-white transition-all duration-200 hover:border-gray-300 dark:hover:border-gray-500"
                                   placeholder="Enter emergency contact name">
                            @error('emergency_contact_name')
                                <p class="mt-1 text-xs text-red-600 flex items-center gap-1">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <!-- Father Name -->
                        <div class="relative">
                            <label for="father_name" class="absolute -top-2 left-3 bg-white dark:bg-gray-800 px-2 text-xs font-semibold text-blue-600 dark:text-blue-400 z-10">
                                Father Name *
                            </label>
                            <input type="text" name="father_name" id="father_name" required value="{{ old('father_name', $teacher->father_name) }}"
                                   class="w-full px-4 py-3 pt-5 border-2 border-gray-200 dark:border-gray-600 rounded-xl focus:ring-4 focus:ring-blue-500/20 focus:border-blue-500 dark:bg-gray-700 dark:text-white transition-all duration-200 hover:border-gray-300 dark:hover:border-gray-500"
                                   placeholder="Enter father's name">
                            @error('father_name')
                                <p class="mt-1 text-xs text-red-600 flex items-center gap-1">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>


                        <!-- Mother Name -->
                        <div class="relative">
                            <label for="mother_name" class="absolute -top-2 left-3 bg-white dark:bg-gray-800 px-2 text-xs font-semibold text-pink-600 dark:text-pink-400 z-10">
                                Mother Name *
                            </label>
                            <input type="text" name="mother_name" id="mother_name" required value="{{ old('mother_name', $teacher->mother_name) }}"
                                   class="w-full px-4 py-3 pt-5 border-2 border-gray-200 dark:border-gray-600 rounded-xl focus:ring-4 focus:ring-pink-500/20 focus:border-pink-500 dark:bg-gray-700 dark:text-white transition-all duration-200 hover:border-gray-300 dark:hover:border-gray-500"
                                   placeholder="Enter mother's name">
                            @error('mother_name')
                                <p class="mt-1 text-xs text-red-600 flex items-center gap-1">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>


                        <!-- Emergency Contact Number -->
                        <div class="relative">
                            <label for="emergency_contact_phone" class="absolute -top-2 left-3 bg-white dark:bg-gray-800 px-2 text-xs font-semibold text-red-600 dark:text-red-400 z-10">
                                Emergency Contact Number
                            </label>
                            <input type="text" name="emergency_contact_phone" id="emergency_contact_phone" value="{{ old('emergency_contact_phone', $teacher->emergency_contact_phone) }}"
                                   class="w-full px-4 py-3 pt-5 border-2 border-gray-200 dark:border-gray-600 rounded-xl focus:ring-4 focus:ring-red-500/20 focus:border-red-500 dark:bg-gray-700 dark:text-white transition-all duration-200 hover:border-gray-300 dark:hover:border-gray-500"
                                   placeholder="Enter emergency contact number">
                            @error('emergency_contact_phone')
                                <p class="mt-1 text-xs text-red-600 flex items-center gap-1">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <!-- Emergency Contact Relation -->
                        <div class="relative">
                            <label for="emergency_contact_relation" class="absolute -top-2 left-3 bg-white dark:bg-gray-800 px-2 text-xs font-semibold text-indigo-600 dark:text-indigo-400 z-10">
                                Emergency Contact Relation *
                            </label>
                            <select name="emergency_contact_relation" id="emergency_contact_relation" required
                                    class="w-full px-4 py-3 pt-5 border-2 border-gray-200 dark:border-gray-600 rounded-xl focus:ring-4 focus:ring-indigo-500/20 focus:border-indigo-500 dark:bg-gray-700 dark:text-white transition-all duration-200 hover:border-gray-300 dark:hover:border-gray-500">
                                <option value="">Select Relation</option>
                                <option value="Father" {{ old('emergency_contact_relation', $teacher->emergency_contact_relation) == 'Father' ? 'selected' : '' }}>Father</option>
                                <option value="Mother" {{ old('emergency_contact_relation', $teacher->emergency_contact_relation) == 'Mother' ? 'selected' : '' }}>Mother</option>
                                <option value="Brother" {{ old('emergency_contact_relation', $teacher->emergency_contact_relation) == 'Brother' ? 'selected' : '' }}>Brother</option>
                                <option value="Sister" {{ old('emergency_contact_relation', $teacher->emergency_contact_relation) == 'Sister' ? 'selected' : '' }}>Sister</option>
                                <option value="Spouse" {{ old('emergency_contact_relation', $teacher->emergency_contact_relation) == 'Spouse' ? 'selected' : '' }}>Spouse</option>
                                <option value="Son" {{ old('emergency_contact_relation', $teacher->emergency_contact_relation) == 'Son' ? 'selected' : '' }}>Son</option>
                                <option value="Daughter" {{ old('emergency_contact_relation', $teacher->emergency_contact_relation) == 'Daughter' ? 'selected' : '' }}>Daughter</option>
                                <option value="Friend" {{ old('emergency_contact_relation', $teacher->emergency_contact_relation) == 'Friend' ? 'selected' : '' }}>Friend</option>
                                <option value="Other" {{ old('emergency_contact_relation', $teacher->emergency_contact_relation) == 'Other' ? 'selected' : '' }}>Other</option>
                            </select>
                            @error('emergency_contact_relation')
                                <p class="mt-1 text-xs text-red-600 flex items-center gap-1">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>
                    </div>

                    <!-- Addresses -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-6">
                        <!-- Present Address -->
                        <div class="relative">
                            <label for="present_address" class="absolute -top-2 left-3 bg-white dark:bg-gray-800 px-2 text-xs font-semibold text-indigo-600 dark:text-indigo-400 z-10">
                                Present Address
                            </label>
                            <textarea name="present_address" id="present_address" rows="3"
                                      class="w-full px-4 py-3 pt-5 border-2 border-gray-200 dark:border-gray-600 rounded-xl focus:ring-4 focus:ring-indigo-500/20 focus:border-indigo-500 dark:bg-gray-700 dark:text-white transition-all duration-200 hover:border-gray-300 dark:hover:border-gray-500"
                                      placeholder="Enter present address">{{ old('present_address', $teacher->present_address) }}</textarea>
                            @error('present_address')
                                <p class="mt-1 text-xs text-red-600 flex items-center gap-1">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <!-- Permanent Address -->
                        <div class="relative">
                            <label for="permanent_address" class="absolute -top-2 left-3 bg-white dark:bg-gray-800 px-2 text-xs font-semibold text-purple-600 dark:text-purple-400 z-10">
                                Permanent Address
                            </label>
                            <textarea name="permanent_address" id="permanent_address" rows="3"
                                      class="w-full px-4 py-3 pt-5 border-2 border-gray-200 dark:border-gray-600 rounded-xl focus:ring-4 focus:ring-purple-500/20 focus:border-purple-500 dark:bg-gray-700 dark:text-white transition-all duration-200 hover:border-gray-300 dark:hover:border-gray-500"
                                      placeholder="Enter permanent address">{{ old('permanent_address', $teacher->permanent_address) }}</textarea>
                            @error('permanent_address')
                                <p class="mt-1 text-xs text-red-600 flex items-center gap-1">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            <!-- Education & Salary -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- Education -->
                <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl border border-gray-200 dark:border-gray-700 overflow-hidden">
                    <div class="bg-gradient-to-r from-orange-500 to-red-600 px-6 py-4">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 bg-white/20 rounded-lg flex items-center justify-center">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                </svg>
                            </div>
                            <div>
                                <h2 class="text-xl font-bold text-white">Education</h2>
                                <p class="text-orange-100 text-sm">Academic qualifications</p>
                            </div>
                        </div>
                    </div>
                    <div class="p-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <!-- Highest Degree -->
                            <div class="relative">
                                <label for="highest_degree" class="absolute -top-2 left-3 bg-white dark:bg-gray-800 px-2 text-xs font-semibold text-orange-600 dark:text-orange-400 z-10">
                                    Highest Degree
                                </label>
                                <input type="text" name="highest_degree" id="highest_degree" value="{{ old('highest_degree', $teacher->highest_degree) }}"
                                       class="w-full px-4 py-3 pt-5 border-2 border-gray-200 dark:border-gray-600 rounded-xl focus:ring-4 focus:ring-orange-500/20 focus:border-orange-500 dark:bg-gray-700 dark:text-white transition-all duration-200 hover:border-gray-300 dark:hover:border-gray-500"
                                       placeholder="Enter highest degree">
                                @error('highest_degree')
                                    <p class="mt-1 text-xs text-red-600 flex items-center gap-1">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            <!-- Institution Name -->
                            <div class="relative">
                                <label for="institution_name" class="absolute -top-2 left-3 bg-white dark:bg-gray-800 px-2 text-xs font-semibold text-red-600 dark:text-red-400 z-10">
                                    Institution Name
                                </label>
                                <input type="text" name="institution_name" id="institution_name" value="{{ old('institution_name', $teacher->institution_name) }}"
                                       class="w-full px-4 py-3 pt-5 border-2 border-gray-200 dark:border-gray-600 rounded-xl focus:ring-4 focus:ring-red-500/20 focus:border-red-500 dark:bg-gray-700 dark:text-white transition-all duration-200 hover:border-gray-300 dark:hover:border-gray-500"
                                       placeholder="Enter institution name">
                                @error('institution_name')
                                    <p class="mt-1 text-xs text-red-600 flex items-center gap-1">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Salary Information -->
                <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl border border-gray-200 dark:border-gray-700 overflow-hidden">
                    <div class="bg-gradient-to-r from-emerald-500 to-teal-600 px-6 py-4">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 bg-white/20 rounded-lg flex items-center justify-center">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                                </svg>
                            </div>
                            <div>
                                <h2 class="text-xl font-bold text-white">Salary Information</h2>
                                <p class="text-emerald-100 text-sm">Payment details and methods</p>
                            </div>
                        </div>
                    </div>
                    <div class="p-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <!-- Salary Type -->
                            <div class="relative">
                                <label for="salary_type" class="absolute -top-2 left-3 bg-white dark:bg-gray-800 px-2 text-xs font-semibold text-emerald-600 dark:text-emerald-400 z-10">
                                    Salary Type
                                </label>
                                <select name="salary_type" id="salary_type" 
                                        class="w-full px-4 py-3 pt-5 border-2 border-gray-200 dark:border-gray-600 rounded-xl focus:ring-4 focus:ring-emerald-500/20 focus:border-emerald-500 dark:bg-gray-700 dark:text-white transition-all duration-200 hover:border-gray-300 dark:hover:border-gray-500">
                                    <option value="">Select Type</option>
                                    <option value="Monthly" {{ old('salary_type', $teacher->salary_type) == 'Monthly' ? 'selected' : '' }}>Monthly</option>
                                    <option value="Per Class" {{ old('salary_type', $teacher->salary_type) == 'Per Class' ? 'selected' : '' }}>Per Class</option>
                                    <option value="Per Student" {{ old('salary_type', $teacher->salary_type) == 'Per Student' ? 'selected' : '' }}>Per Student</option>
                                </select>
                                @error('salary_type')
                                    <p class="mt-1 text-xs text-red-600 flex items-center gap-1">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            <!-- Salary Amount -->
                            <div class="relative">
                                <label for="salary_amount" class="absolute -top-2 left-3 bg-white dark:bg-gray-800 px-2 text-xs font-semibold text-teal-600 dark:text-teal-400 z-10">
                                    Salary Amount
                                </label>
                                <input type="number" name="salary_amount" id="salary_amount" step="0.01" min="0" value="{{ old('salary_amount', $teacher->salary_amount) }}"
                                       class="w-full px-4 py-3 pt-5 border-2 border-gray-200 dark:border-gray-600 rounded-xl focus:ring-4 focus:ring-teal-500/20 focus:border-teal-500 dark:bg-gray-700 dark:text-white transition-all duration-200 hover:border-gray-300 dark:hover:border-gray-500"
                                       placeholder="Enter salary amount">
                                @error('salary_amount')
                                    <p class="mt-1 text-xs text-red-600 flex items-center gap-1">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            <!-- Payment Method -->
                            <div class="relative">
                                <label for="payment_method" class="absolute -top-2 left-3 bg-white dark:bg-gray-800 px-2 text-xs font-semibold text-cyan-600 dark:text-cyan-400 z-10">
                                    Payment Method
                                </label>
                                <select name="payment_method" id="payment_method" 
                                        class="w-full px-4 py-3 pt-5 border-2 border-gray-200 dark:border-gray-600 rounded-xl focus:ring-4 focus:ring-cyan-500/20 focus:border-cyan-500 dark:bg-gray-700 dark:text-white transition-all duration-200 hover:border-gray-300 dark:hover:border-gray-500">
                                    <option value="">Select Method</option>
                                    <option value="Cash" {{ old('payment_method', $teacher->payment_method) == 'Cash' ? 'selected' : '' }}>Cash</option>
                                    <option value="Bank" {{ old('payment_method', $teacher->payment_method) == 'Bank' ? 'selected' : '' }}>Bank</option>
                                    <option value="Mobile Banking" {{ old('payment_method', $teacher->payment_method) == 'Mobile Banking' ? 'selected' : '' }}>Mobile Banking</option>
                                </select>
                                @error('payment_method')
                                    <p class="mt-1 text-xs text-red-600 flex items-center gap-1">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            <!-- Account Details -->
                            <div class="relative">
                                <label for="account_details" class="absolute -top-2 left-3 bg-white dark:bg-gray-800 px-2 text-xs font-semibold text-slate-600 dark:text-slate-400 z-10">
                                    Account Details
                                </label>
                                <input type="text" name="account_details" id="account_details" value="{{ old('account_details', $teacher->account_details) }}"
                                       class="w-full px-4 py-3 pt-5 border-2 border-gray-200 dark:border-gray-600 rounded-xl focus:ring-4 focus:ring-slate-500/20 focus:border-slate-500 dark:bg-gray-700 dark:text-white transition-all duration-200 hover:border-gray-300 dark:hover:border-gray-500"
                                       placeholder="Enter account details">
                                @error('account_details')
                                    <p class="mt-1 text-xs text-red-600 flex items-center gap-1">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Notes -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl border border-gray-200 dark:border-gray-700 overflow-hidden">
                <div class="bg-gradient-to-r from-slate-500 to-gray-600 px-6 py-4">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-white/20 rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                            </svg>
                        </div>
                        <div>
                            <h2 class="text-xl font-bold text-white">Additional Notes</h2>
                            <p class="text-slate-100 text-sm">Any additional information about the teacher</p>
                        </div>
                    </div>
                </div>
                <div class="p-6">
                    <div class="relative">
                        <label for="notes" class="absolute -top-2 left-3 bg-white dark:bg-gray-800 px-2 text-xs font-semibold text-slate-600 dark:text-slate-400 z-10">
                            Notes
                        </label>
                        <textarea name="notes" id="notes" rows="4"
                                  class="w-full px-4 py-3 pt-5 border-2 border-gray-200 dark:border-gray-600 rounded-xl focus:ring-4 focus:ring-slate-500/20 focus:border-slate-500 dark:bg-gray-700 dark:text-white transition-all duration-200 hover:border-gray-300 dark:hover:border-gray-500"
                                  placeholder="Any additional information about the teacher...">{{ old('notes', $teacher->notes) }}</textarea>
                        @error('notes')
                            <p class="mt-1 text-xs text-red-600 flex items-center gap-1">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Form Actions -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl border border-gray-200 dark:border-gray-700 p-6">
                <div class="flex flex-col sm:flex-row gap-4 justify-end">
                    <a href="{{ route('partner.teachers.show', $teacher) }}" 
                       class="group flex items-center justify-center px-8 py-4 bg-gray-100 hover:bg-gray-200 dark:bg-gray-700 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-300 font-semibold rounded-xl transition-all duration-300 hover:scale-105 hover:shadow-lg">
                        <svg class="w-5 h-5 mr-2 group-hover:rotate-12 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                        Cancel
                    </a>
                    <button type="submit" 
                            class="group flex items-center justify-center px-8 py-4 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white font-semibold rounded-xl transition-all duration-300 hover:scale-105 hover:shadow-xl">
                        <svg class="w-5 h-5 mr-2 group-hover:rotate-12 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        Update Teacher
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

@endsection
