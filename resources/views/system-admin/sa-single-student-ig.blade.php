@extends('system-admin.system-admin-layout')

@section('title', 'Student Interactive Grid - System Admin')

@section('content')
<div class="min-h-screen bg-gray-50 dark:bg-gray-900">
    <!-- Header -->
    <div class="bg-white dark:bg-gray-800 shadow-sm border-b border-gray-200 dark:border-gray-700">
        <div class="px-4 sm:px-6 lg:px-8 py-4">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Student Interactive Grid</h1>
                    <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">Interactive data management for {{ $student->full_name }}</p>
                </div>
                <div class="mt-4 sm:mt-0 flex space-x-3">
                    <a href="{{ route('system-admin.all-students') }}" 
                       class="inline-flex items-center px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white text-sm font-medium rounded-lg transition-colors duration-200">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                        Back to Students
                    </a>
                    <button id="saveAllBtn" 
                            class="inline-flex items-center px-4 py-2 bg-green-600 hover:bg-green-700 text-white text-sm font-medium rounded-lg transition-colors duration-200">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        Save Changes
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Student Info Card -->
    <div class="bg-white dark:bg-gray-800 shadow-sm border-b border-gray-200 dark:border-gray-700">
        <div class="px-4 sm:px-6 lg:px-8 py-4">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <!-- Student Basic Info -->
                <div class="bg-blue-50 dark:bg-blue-900/20 rounded-lg p-4 border border-blue-200 dark:border-blue-800">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="w-10 h-10 bg-blue-500 rounded-full flex items-center justify-center">
                                <span class="text-white font-bold text-lg">{{ substr($student->full_name, 0, 1) }}</span>
                            </div>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium text-blue-600 dark:text-blue-400">Student ID</p>
                            <p class="text-lg font-bold text-blue-900 dark:text-blue-100">#{{ $student->id }}</p>
                        </div>
                    </div>
                </div>

                <!-- Partner Info -->
                <div class="bg-green-50 dark:bg-green-900/20 rounded-lg p-4 border border-green-200 dark:border-green-800">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="w-10 h-10 bg-green-500 rounded-full flex items-center justify-center">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                </svg>
                            </div>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium text-green-600 dark:text-green-400">Partner</p>
                            <p class="text-lg font-bold text-green-900 dark:text-green-100">{{ $student->partner->name ?? 'N/A' }}</p>
                        </div>
                    </div>
                </div>

                <!-- Test Results -->
                <div class="bg-purple-50 dark:bg-purple-900/20 rounded-lg p-4 border border-purple-200 dark:border-purple-800">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="w-10 h-10 bg-purple-500 rounded-full flex items-center justify-center">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium text-purple-600 dark:text-purple-400">Tests Taken</p>
                            <p class="text-lg font-bold text-purple-900 dark:text-purple-100">{{ $student->exam_results_count ?? 0 }}</p>
                        </div>
                    </div>
                </div>

                <!-- Average Score -->
                <div class="bg-orange-50 dark:bg-orange-900/20 rounded-lg p-4 border border-orange-200 dark:border-orange-800">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="w-10 h-10 bg-orange-500 rounded-full flex items-center justify-center">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                                </svg>
                            </div>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium text-orange-600 dark:text-orange-400">Avg Score</p>
                            <p class="text-lg font-bold text-orange-900 dark:text-orange-100">{{ $student->average_score ?? 0 }}%</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Interactive Grid -->
    <div class="bg-white dark:bg-gray-800 shadow-sm">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700" id="studentGrid">
                <thead class="bg-gray-50 dark:bg-gray-700">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                            Field
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                            Current Value
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                            Actions
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                    <!-- Basic Information -->
                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-gray-100">
                            Full Name
                        </td>
                        <td class="px-6 py-4">
                            <div class="editable-cell" data-field="full_name" data-value="{{ $student->full_name }}">
                                <span class="text-sm text-gray-900 dark:text-gray-100">{{ $student->full_name }}</span>
                                <button class="edit-btn ml-2 text-blue-600 hover:text-blue-800" style="display: none;">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                    </svg>
                                </button>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                            Click to edit
                        </td>
                    </tr>

                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-gray-100">
                            Student ID
                        </td>
                        <td class="px-6 py-4">
                            <div class="editable-cell" data-field="student_id" data-value="{{ $student->student_id ?? '' }}">
                                <span class="text-sm text-gray-900 dark:text-gray-100">{{ $student->student_id ?? 'N/A' }}</span>
                                <button class="edit-btn ml-2 text-blue-600 hover:text-blue-800" style="display: none;">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                    </svg>
                                </button>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                            Click to edit
                        </td>
                    </tr>

                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-gray-100">
                            Email
                        </td>
                        <td class="px-6 py-4">
                            <div class="editable-cell" data-field="email" data-value="{{ $student->email ?? '' }}">
                                <span class="text-sm text-gray-900 dark:text-gray-100">{{ $student->email ?? 'N/A' }}</span>
                                <button class="edit-btn ml-2 text-blue-600 hover:text-blue-800" style="display: none;">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                    </svg>
                                </button>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                            Click to edit
                        </td>
                    </tr>

                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-gray-100">
                            Phone
                        </td>
                        <td class="px-6 py-4">
                            <div class="editable-cell" data-field="phone" data-value="{{ $student->phone ?? '' }}">
                                <span class="text-sm text-gray-900 dark:text-gray-100">{{ $student->phone ?? 'N/A' }}</span>
                                <button class="edit-btn ml-2 text-blue-600 hover:text-blue-800" style="display: none;">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                    </svg>
                                </button>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                            Click to edit
                        </td>
                    </tr>

                    <!-- Personal Information -->
                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-gray-100">
                            Date of Birth
                        </td>
                        <td class="px-6 py-4">
                            <div class="editable-cell" data-field="date_of_birth" data-value="{{ $student->date_of_birth ? $student->date_of_birth->format('Y-m-d') : '' }}">
                                <span class="text-sm text-gray-900 dark:text-gray-100">{{ $student->date_of_birth ? $student->date_of_birth->format('M d, Y') : 'N/A' }}</span>
                                <button class="edit-btn ml-2 text-blue-600 hover:text-blue-800" style="display: none;">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                    </svg>
                                </button>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                            Click to edit
                        </td>
                    </tr>

                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-gray-100">
                            Gender
                        </td>
                        <td class="px-6 py-4">
                            <div class="editable-cell" data-field="gender" data-value="{{ $student->gender }}">
                                <span class="text-sm text-gray-900 dark:text-gray-100">{{ ucfirst($student->gender) }}</span>
                                <button class="edit-btn ml-2 text-blue-600 hover:text-blue-800" style="display: none;">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                    </svg>
                                </button>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                            Click to edit
                        </td>
                    </tr>

                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-gray-100">
                            Blood Group
                        </td>
                        <td class="px-6 py-4">
                            <div class="editable-cell" data-field="blood_group" data-value="{{ $student->blood_group ?? '' }}">
                                <span class="text-sm text-gray-900 dark:text-gray-100">{{ $student->blood_group ?? 'N/A' }}</span>
                                <button class="edit-btn ml-2 text-blue-600 hover:text-blue-800" style="display: none;">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                    </svg>
                                </button>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                            Click to edit
                        </td>
                    </tr>

                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-gray-100">
                            Religion
                        </td>
                        <td class="px-6 py-4">
                            <div class="editable-cell" data-field="religion" data-value="{{ $student->religion ?? '' }}">
                                <span class="text-sm text-gray-900 dark:text-gray-100">{{ $student->religion ?? 'N/A' }}</span>
                                <button class="edit-btn ml-2 text-blue-600 hover:text-blue-800" style="display: none;">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                    </svg>
                                </button>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                            Click to edit
                        </td>
                    </tr>

                    <!-- Address Information -->
                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-gray-100">
                            Address
                        </td>
                        <td class="px-6 py-4">
                            <div class="editable-cell" data-field="address" data-value="{{ $student->address ?? '' }}">
                                <span class="text-sm text-gray-900 dark:text-gray-100">{{ $student->address ?? 'N/A' }}</span>
                                <button class="edit-btn ml-2 text-blue-600 hover:text-blue-800" style="display: none;">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                    </svg>
                                </button>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                            Click to edit
                        </td>
                    </tr>

                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-gray-100">
                            City
                        </td>
                        <td class="px-6 py-4">
                            <div class="editable-cell" data-field="city" data-value="{{ $student->city ?? '' }}">
                                <span class="text-sm text-gray-900 dark:text-gray-100">{{ $student->city ?? 'N/A' }}</span>
                                <button class="edit-btn ml-2 text-blue-600 hover:text-blue-800" style="display: none;">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                    </svg>
                                </button>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                            Click to edit
                        </td>
                    </tr>

                    <!-- Educational Information -->
                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-gray-100">
                            School/College
                        </td>
                        <td class="px-6 py-4">
                            <div class="editable-cell" data-field="school_college" data-value="{{ $student->school_college ?? '' }}">
                                <span class="text-sm text-gray-900 dark:text-gray-100">{{ $student->school_college ?? 'N/A' }}</span>
                                <button class="edit-btn ml-2 text-blue-600 hover:text-blue-800" style="display: none;">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                    </svg>
                                </button>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                            Click to edit
                        </td>
                    </tr>

                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-gray-100">
                            Class/Grade
                        </td>
                        <td class="px-6 py-4">
                            <div class="editable-cell" data-field="class_grade" data-value="{{ $student->class_grade ?? '' }}">
                                <span class="text-sm text-gray-900 dark:text-gray-100">{{ $student->class_grade ?? 'N/A' }}</span>
                                <button class="edit-btn ml-2 text-blue-600 hover:text-blue-800" style="display: none;">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                    </svg>
                                </button>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                            Click to edit
                        </td>
                    </tr>

                    <!-- Family Information -->
                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-gray-100">
                            Father Name
                        </td>
                        <td class="px-6 py-4">
                            <div class="editable-cell" data-field="father_name" data-value="{{ $student->father_name ?? '' }}">
                                <span class="text-sm text-gray-900 dark:text-gray-100">{{ $student->father_name ?? 'N/A' }}</span>
                                <button class="edit-btn ml-2 text-blue-600 hover:text-blue-800" style="display: none;">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                    </svg>
                                </button>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                            Click to edit
                        </td>
                    </tr>

                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-gray-100">
                            Father Phone
                        </td>
                        <td class="px-6 py-4">
                            <div class="editable-cell" data-field="father_phone" data-value="{{ $student->father_phone ?? '' }}">
                                <span class="text-sm text-gray-900 dark:text-gray-100">{{ $student->father_phone ?? 'N/A' }}</span>
                                <button class="edit-btn ml-2 text-blue-600 hover:text-blue-800" style="display: none;">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                    </svg>
                                </button>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                            Click to edit
                        </td>
                    </tr>

                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-gray-100">
                            Mother Name
                        </td>
                        <td class="px-6 py-4">
                            <div class="editable-cell" data-field="mother_name" data-value="{{ $student->mother_name ?? '' }}">
                                <span class="text-sm text-gray-900 dark:text-gray-100">{{ $student->mother_name ?? 'N/A' }}</span>
                                <button class="edit-btn ml-2 text-blue-600 hover:text-blue-800" style="display: none;">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                    </svg>
                                </button>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                            Click to edit
                        </td>
                    </tr>

                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-gray-100">
                            Mother Phone
                        </td>
                        <td class="px-6 py-4">
                            <div class="editable-cell" data-field="mother_phone" data-value="{{ $student->mother_phone ?? '' }}">
                                <span class="text-sm text-gray-900 dark:text-gray-100">{{ $student->mother_phone ?? 'N/A' }}</span>
                                <button class="edit-btn ml-2 text-blue-600 hover:text-blue-800" style="display: none;">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                    </svg>
                                </button>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                            Click to edit
                        </td>
                    </tr>

                    <!-- Guardian Information -->
                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-gray-100">
                            Guardian
                        </td>
                        <td class="px-6 py-4">
                            <div class="editable-cell" data-field="guardian" data-value="{{ $student->guardian ?? '' }}">
                                <span class="text-sm text-gray-900 dark:text-gray-100">{{ $student->guardian ?? 'N/A' }}</span>
                                <button class="edit-btn ml-2 text-blue-600 hover:text-blue-800" style="display: none;">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                    </svg>
                                </button>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                            Click to edit
                        </td>
                    </tr>

                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-gray-100">
                            Guardian Name
                        </td>
                        <td class="px-6 py-4">
                            <div class="editable-cell" data-field="guardian_name" data-value="{{ $student->guardian_name ?? '' }}">
                                <span class="text-sm text-gray-900 dark:text-gray-100">{{ $student->guardian_name ?? 'N/A' }}</span>
                                <button class="edit-btn ml-2 text-blue-600 hover:text-blue-800" style="display: none;">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                    </svg>
                                </button>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                            Click to edit
                        </td>
                    </tr>

                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-gray-100">
                            Guardian Phone
                        </td>
                        <td class="px-6 py-4">
                            <div class="editable-cell" data-field="guardian_phone" data-value="{{ $student->guardian_phone ?? '' }}">
                                <span class="text-sm text-gray-900 dark:text-gray-100">{{ $student->guardian_phone ?? 'N/A' }}</span>
                                <button class="edit-btn ml-2 text-blue-600 hover:text-blue-800" style="display: none;">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                    </svg>
                                </button>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                            Click to edit
                        </td>
                    </tr>

                    <!-- System Information -->
                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-gray-100">
                            Partner
                        </td>
                        <td class="px-6 py-4">
                            <div class="editable-cell" data-field="partner_id" data-value="{{ $student->partner_id }}">
                                <span class="text-sm text-gray-900 dark:text-gray-100">{{ $student->partner->name ?? 'N/A' }}</span>
                                <button class="edit-btn ml-2 text-blue-600 hover:text-blue-800" style="display: none;">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                    </svg>
                                </button>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                            Click to edit
                        </td>
                    </tr>

                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-gray-100">
                            Status
                        </td>
                        <td class="px-6 py-4">
                            <div class="editable-cell" data-field="status" data-value="{{ $student->status }}">
                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium
                                    @if($student->status === 'active') bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200
                                    @elseif($student->status === 'suspended') bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200
                                    @else bg-gray-100 text-gray-800 dark:bg-gray-900 dark:text-gray-200
                                    @endif">
                                    {{ ucfirst($student->status) }}
                                </span>
                                <button class="edit-btn ml-2 text-blue-600 hover:text-blue-800" style="display: none;">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                    </svg>
                                </button>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                            Click to edit
                        </td>
                    </tr>

                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-gray-100">
                            Enable Login
                        </td>
                        <td class="px-6 py-4">
                            <div class="editable-cell" data-field="enable_login" data-value="{{ $student->enable_login }}">
                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium
                                    @if($student->enable_login === 'y') bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200
                                    @else bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200
                                    @endif">
                                    {{ $student->enable_login === 'y' ? 'Yes' : 'No' }}
                                </span>
                                <button class="edit-btn ml-2 text-blue-600 hover:text-blue-800" style="display: none;">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                    </svg>
                                </button>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                            Click to edit
                        </td>
                    </tr>

                    <!-- Read-only Information -->
                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-gray-100">
                            Enroll Date
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">
                            {{ $student->enroll_date ? $student->enroll_date->format('M d, Y') : 'N/A' }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                            Read only
                        </td>
                    </tr>

                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-gray-100">
                            Created At
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">
                            {{ $student->created_at->format('M d, Y H:i') }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                            Read only
                        </td>
                    </tr>

                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-gray-100">
                            Updated At
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">
                            {{ $student->updated_at->format('M d, Y H:i') }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                            Read only
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    initializeInteractiveGrid();
});

function initializeInteractiveGrid() {
    // Show edit buttons on hover
    document.querySelectorAll('tr').forEach(row => {
        row.addEventListener('mouseenter', function() {
            this.querySelectorAll('.edit-btn').forEach(btn => {
                btn.style.display = 'inline-block';
            });
        });
        
        row.addEventListener('mouseleave', function() {
            this.querySelectorAll('.edit-btn').forEach(btn => {
                btn.style.display = 'none';
            });
        });
    });

    // Edit button functionality
    document.querySelectorAll('.edit-btn').forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.stopPropagation();
            const cell = this.closest('.editable-cell');
            const field = cell.dataset.field;
            const currentValue = cell.dataset.value;
            
            if (field === 'partner_id') {
                showPartnerDropdown(cell, currentValue);
            } else if (field === 'status') {
                showStatusDropdown(cell, currentValue);
            } else if (field === 'gender') {
                showGenderDropdown(cell, currentValue);
            } else if (field === 'blood_group') {
                showBloodGroupDropdown(cell, currentValue);
            } else if (field === 'religion') {
                showReligionDropdown(cell, currentValue);
            } else if (field === 'guardian') {
                showGuardianDropdown(cell, currentValue);
            } else if (field === 'enable_login') {
                showEnableLoginDropdown(cell, currentValue);
            } else if (field === 'date_of_birth') {
                showDateInput(cell, currentValue, field);
            } else {
                showTextInput(cell, currentValue, field);
            }
        });
    });
}

function showTextInput(cell, currentValue, field) {
    const input = document.createElement('input');
    input.type = 'text';
    input.value = currentValue;
    input.className = 'w-full px-2 py-1 border border-blue-300 rounded text-sm focus:outline-none focus:ring-2 focus:ring-blue-500';
    
    const saveBtn = document.createElement('button');
    saveBtn.innerHTML = '✓';
    saveBtn.className = 'ml-2 px-2 py-1 bg-green-600 text-white rounded text-xs hover:bg-green-700';
    saveBtn.onclick = () => saveCell(cell, field, input.value);
    
    const cancelBtn = document.createElement('button');
    cancelBtn.innerHTML = '✕';
    cancelBtn.className = 'ml-1 px-2 py-1 bg-red-600 text-white rounded text-xs hover:bg-red-700';
    cancelBtn.onclick = () => cancelEdit(cell);
    
    cell.innerHTML = '';
    cell.appendChild(input);
    cell.appendChild(saveBtn);
    cell.appendChild(cancelBtn);
    input.focus();
}

function showPartnerDropdown(cell, currentValue) {
    const select = document.createElement('select');
    select.className = 'w-full px-2 py-1 border border-blue-300 rounded text-sm focus:outline-none focus:ring-2 focus:ring-blue-500';
    
    // Add options from partners data
    const partners = @json($partners);
    partners.forEach(partner => {
        const option = document.createElement('option');
        option.value = partner.id;
        option.textContent = partner.name;
        if (partner.id == currentValue) option.selected = true;
        select.appendChild(option);
    });
    
    const saveBtn = document.createElement('button');
    saveBtn.innerHTML = '✓';
    saveBtn.className = 'ml-2 px-2 py-1 bg-green-600 text-white rounded text-xs hover:bg-green-700';
    saveBtn.onclick = () => saveCell(cell, 'partner_id', select.value);
    
    const cancelBtn = document.createElement('button');
    cancelBtn.innerHTML = '✕';
    cancelBtn.className = 'ml-1 px-2 py-1 bg-red-600 text-white rounded text-xs hover:bg-red-700';
    cancelBtn.onclick = () => cancelEdit(cell);
    
    cell.innerHTML = '';
    cell.appendChild(select);
    cell.appendChild(saveBtn);
    cell.appendChild(cancelBtn);
}

function showStatusDropdown(cell, currentValue) {
    const select = document.createElement('select');
    select.className = 'w-full px-2 py-1 border border-blue-300 rounded text-sm focus:outline-none focus:ring-2 focus:ring-blue-500';
    
    const statuses = ['active', 'inactive'];
    statuses.forEach(status => {
        const option = document.createElement('option');
        option.value = status;
        option.textContent = status.charAt(0).toUpperCase() + status.slice(1);
        if (status === currentValue) option.selected = true;
        select.appendChild(option);
    });
    
    const saveBtn = document.createElement('button');
    saveBtn.innerHTML = '✓';
    saveBtn.className = 'ml-2 px-2 py-1 bg-green-600 text-white rounded text-xs hover:bg-green-700';
    saveBtn.onclick = () => saveCell(cell, 'status', select.value);
    
    const cancelBtn = document.createElement('button');
    cancelBtn.innerHTML = '✕';
    cancelBtn.className = 'ml-1 px-2 py-1 bg-red-600 text-white rounded text-xs hover:bg-red-700';
    cancelBtn.onclick = () => cancelEdit(cell);
    
    cell.innerHTML = '';
    cell.appendChild(select);
    cell.appendChild(saveBtn);
    cell.appendChild(cancelBtn);
}

function showGenderDropdown(cell, currentValue) {
    const select = document.createElement('select');
    select.className = 'w-full px-2 py-1 border border-blue-300 rounded text-sm focus:outline-none focus:ring-2 focus:ring-blue-500';
    
    const genders = ['male', 'female', 'other'];
    genders.forEach(gender => {
        const option = document.createElement('option');
        option.value = gender;
        option.textContent = gender.charAt(0).toUpperCase() + gender.slice(1);
        if (gender === currentValue) option.selected = true;
        select.appendChild(option);
    });
    
    const saveBtn = document.createElement('button');
    saveBtn.innerHTML = '✓';
    saveBtn.className = 'ml-2 px-2 py-1 bg-green-600 text-white rounded text-xs hover:bg-green-700';
    saveBtn.onclick = () => saveCell(cell, 'gender', select.value);
    
    const cancelBtn = document.createElement('button');
    cancelBtn.innerHTML = '✕';
    cancelBtn.className = 'ml-1 px-2 py-1 bg-red-600 text-white rounded text-xs hover:bg-red-700';
    cancelBtn.onclick = () => cancelEdit(cell);
    
    cell.innerHTML = '';
    cell.appendChild(select);
    cell.appendChild(saveBtn);
    cell.appendChild(cancelBtn);
}

function showBloodGroupDropdown(cell, currentValue) {
    const select = document.createElement('select');
    select.className = 'w-full px-2 py-1 border border-blue-300 rounded text-sm focus:outline-none focus:ring-2 focus:ring-blue-500';
    
    const bloodGroups = ['A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', 'O+', 'O-'];
    bloodGroups.forEach(group => {
        const option = document.createElement('option');
        option.value = group;
        option.textContent = group;
        if (group === currentValue) option.selected = true;
        select.appendChild(option);
    });
    
    const saveBtn = document.createElement('button');
    saveBtn.innerHTML = '✓';
    saveBtn.className = 'ml-2 px-2 py-1 bg-green-600 text-white rounded text-xs hover:bg-green-700';
    saveBtn.onclick = () => saveCell(cell, 'blood_group', select.value);
    
    const cancelBtn = document.createElement('button');
    cancelBtn.innerHTML = '✕';
    cancelBtn.className = 'ml-1 px-2 py-1 bg-red-600 text-white rounded text-xs hover:bg-red-700';
    cancelBtn.onclick = () => cancelEdit(cell);
    
    cell.innerHTML = '';
    cell.appendChild(select);
    cell.appendChild(saveBtn);
    cell.appendChild(cancelBtn);
}

function showReligionDropdown(cell, currentValue) {
    const select = document.createElement('select');
    select.className = 'w-full px-2 py-1 border border-blue-300 rounded text-sm focus:outline-none focus:ring-2 focus:ring-blue-500';
    
    const religions = ['Islam', 'Hinduism', 'Christianity', 'Buddhism'];
    religions.forEach(religion => {
        const option = document.createElement('option');
        option.value = religion;
        option.textContent = religion;
        if (religion === currentValue) option.selected = true;
        select.appendChild(option);
    });
    
    const saveBtn = document.createElement('button');
    saveBtn.innerHTML = '✓';
    saveBtn.className = 'ml-2 px-2 py-1 bg-green-600 text-white rounded text-xs hover:bg-green-700';
    saveBtn.onclick = () => saveCell(cell, 'religion', select.value);
    
    const cancelBtn = document.createElement('button');
    cancelBtn.innerHTML = '✕';
    cancelBtn.className = 'ml-1 px-2 py-1 bg-red-600 text-white rounded text-xs hover:bg-red-700';
    cancelBtn.onclick = () => cancelEdit(cell);
    
    cell.innerHTML = '';
    cell.appendChild(select);
    cell.appendChild(saveBtn);
    cell.appendChild(cancelBtn);
}

function showGuardianDropdown(cell, currentValue) {
    const select = document.createElement('select');
    select.className = 'w-full px-2 py-1 border border-blue-300 rounded text-sm focus:outline-none focus:ring-2 focus:ring-blue-500';
    
    const guardians = ['Father', 'Mother', 'Other'];
    guardians.forEach(guardian => {
        const option = document.createElement('option');
        option.value = guardian;
        option.textContent = guardian;
        if (guardian === currentValue) option.selected = true;
        select.appendChild(option);
    });
    
    const saveBtn = document.createElement('button');
    saveBtn.innerHTML = '✓';
    saveBtn.className = 'ml-2 px-2 py-1 bg-green-600 text-white rounded text-xs hover:bg-green-700';
    saveBtn.onclick = () => saveCell(cell, 'guardian', select.value);
    
    const cancelBtn = document.createElement('button');
    cancelBtn.innerHTML = '✕';
    cancelBtn.className = 'ml-1 px-2 py-1 bg-red-600 text-white rounded text-xs hover:bg-red-700';
    cancelBtn.onclick = () => cancelEdit(cell);
    
    cell.innerHTML = '';
    cell.appendChild(select);
    cell.appendChild(saveBtn);
    cell.appendChild(cancelBtn);
}

function showEnableLoginDropdown(cell, currentValue) {
    const select = document.createElement('select');
    select.className = 'w-full px-2 py-1 border border-blue-300 rounded text-sm focus:outline-none focus:ring-2 focus:ring-blue-500';
    
    const options = [
        { value: 'y', text: 'Yes' },
        { value: 'n', text: 'No' }
    ];
    options.forEach(option => {
        const optionElement = document.createElement('option');
        optionElement.value = option.value;
        optionElement.textContent = option.text;
        if (option.value === currentValue) optionElement.selected = true;
        select.appendChild(optionElement);
    });
    
    const saveBtn = document.createElement('button');
    saveBtn.innerHTML = '✓';
    saveBtn.className = 'ml-2 px-2 py-1 bg-green-600 text-white rounded text-xs hover:bg-green-700';
    saveBtn.onclick = () => saveCell(cell, 'enable_login', select.value);
    
    const cancelBtn = document.createElement('button');
    cancelBtn.innerHTML = '✕';
    cancelBtn.className = 'ml-1 px-2 py-1 bg-red-600 text-white rounded text-xs hover:bg-red-700';
    cancelBtn.onclick = () => cancelEdit(cell);
    
    cell.innerHTML = '';
    cell.appendChild(select);
    cell.appendChild(saveBtn);
    cell.appendChild(cancelBtn);
}

function showDateInput(cell, currentValue, field) {
    const input = document.createElement('input');
    input.type = 'date';
    input.value = currentValue;
    input.className = 'w-full px-2 py-1 border border-blue-300 rounded text-sm focus:outline-none focus:ring-2 focus:ring-blue-500';
    
    const saveBtn = document.createElement('button');
    saveBtn.innerHTML = '✓';
    saveBtn.className = 'ml-2 px-2 py-1 bg-green-600 text-white rounded text-xs hover:bg-green-700';
    saveBtn.onclick = () => saveCell(cell, field, input.value);
    
    const cancelBtn = document.createElement('button');
    cancelBtn.innerHTML = '✕';
    cancelBtn.className = 'ml-1 px-2 py-1 bg-red-600 text-white rounded text-xs hover:bg-red-700';
    cancelBtn.onclick = () => cancelEdit(cell);
    
    cell.innerHTML = '';
    cell.appendChild(input);
    cell.appendChild(saveBtn);
    cell.appendChild(cancelBtn);
    input.focus();
}

function saveCell(cell, field, value) {
    const studentId = {{ $student->id }};
    
    fetch(`/system-admin/students/${studentId}/update-field`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({
            field: field,
            value: value
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Update the cell display
            updateCellDisplay(cell, field, value);
        } else {
            alert('Error updating field: ' + (data.message || 'Unknown error'));
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Error updating field');
    });
}

function updateCellDisplay(cell, field, value) {
    const studentId = {{ $student->id }};
    cell.dataset.value = value;
    
    if (field === 'partner_id') {
        const partnerName = getPartnerName(value);
        cell.innerHTML = `
            <span class="text-sm text-gray-900 dark:text-gray-100">${partnerName}</span>
            <button class="edit-btn ml-2 text-blue-600 hover:text-blue-800" style="display: none;">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                </svg>
            </button>
        `;
    } else if (field === 'status') {
        const statusClass = value === 'active' ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200' :
                           value === 'inactive' ? 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200' :
                           'bg-gray-100 text-gray-800 dark:bg-gray-900 dark:text-gray-200';
        cell.innerHTML = `
            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium ${statusClass}">
                ${value.charAt(0).toUpperCase() + value.slice(1)}
            </span>
            <button class="edit-btn ml-2 text-blue-600 hover:text-blue-800" style="display: none;">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                </svg>
            </button>
        `;
    } else if (field === 'enable_login') {
        const loginClass = value === 'y' ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200' :
                          'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200';
        cell.innerHTML = `
            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium ${loginClass}">
                ${value === 'y' ? 'Yes' : 'No'}
            </span>
            <button class="edit-btn ml-2 text-blue-600 hover:text-blue-800" style="display: none;">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                </svg>
            </button>
        `;
    } else if (field === 'date_of_birth') {
        const displayValue = value ? new Date(value).toLocaleDateString('en-US', { year: 'numeric', month: 'short', day: 'numeric' }) : 'N/A';
        cell.innerHTML = `
            <span class="text-sm text-gray-900 dark:text-gray-100">${displayValue}</span>
            <button class="edit-btn ml-2 text-blue-600 hover:text-blue-800" style="display: none;">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                </svg>
            </button>
        `;
    } else {
        const displayValue = value || 'N/A';
        cell.innerHTML = `
            <span class="text-sm text-gray-900 dark:text-gray-100">${displayValue}</span>
            <button class="edit-btn ml-2 text-blue-600 hover:text-blue-800" style="display: none;">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                </svg>
            </button>
        `;
    }
    
    // Re-attach event listeners
    const editBtn = cell.querySelector('.edit-btn');
    if (editBtn) {
        editBtn.addEventListener('click', function(e) {
            e.stopPropagation();
            const field = cell.dataset.field;
            const currentValue = cell.dataset.value;
            
            if (field === 'partner_id') {
                showPartnerDropdown(cell, currentValue);
            } else if (field === 'status') {
                showStatusDropdown(cell, currentValue);
            } else if (field === 'gender') {
                showGenderDropdown(cell, currentValue);
            } else if (field === 'blood_group') {
                showBloodGroupDropdown(cell, currentValue);
            } else if (field === 'religion') {
                showReligionDropdown(cell, currentValue);
            } else if (field === 'guardian') {
                showGuardianDropdown(cell, currentValue);
            } else if (field === 'enable_login') {
                showEnableLoginDropdown(cell, currentValue);
            } else if (field === 'date_of_birth') {
                showDateInput(cell, currentValue, field);
            } else {
                showTextInput(cell, currentValue, field);
            }
        });
    }
}

function cancelEdit(cell) {
    const field = cell.dataset.field;
    const currentValue = cell.dataset.value;
    updateCellDisplay(cell, field, currentValue);
}

function getPartnerName(partnerId) {
    const partners = @json($partners);
    const partner = partners.find(p => p.id == partnerId);
    return partner ? partner.name : 'N/A';
}
</script>
@endpush
