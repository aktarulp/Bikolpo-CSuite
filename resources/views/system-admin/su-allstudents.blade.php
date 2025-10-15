@extends('layouts.system-admin-layout')

@section('title', 'All Students - System Admin')

@section('content')
<div class="min-h-screen bg-gray-50 dark:bg-gray-900">
    <!-- Top Summary Section -->
    <div class="bg-white dark:bg-gray-800 shadow-sm border-b border-gray-200 dark:border-gray-700">
        <div class="px-4 sm:px-6 lg:px-8 py-4">
            <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-4">
                <!-- Total Students -->
                <div class="bg-blue-50 dark:bg-blue-900/20 rounded-lg p-3 border border-blue-200 dark:border-blue-800">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="w-8 h-8 bg-blue-500 rounded-full flex items-center justify-center">
                                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                                </svg>
                            </div>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium text-blue-600 dark:text-blue-400">Total Students</p>
                            <p class="text-lg font-bold text-blue-900 dark:text-blue-100">{{ $totalStudents }}</p>
                        </div>
                    </div>
                </div>

                <!-- Active Students -->
                <div class="bg-green-50 dark:bg-green-900/20 rounded-lg p-3 border border-green-200 dark:border-green-800">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="w-8 h-8 bg-green-500 rounded-full flex items-center justify-center">
                                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                            </div>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium text-green-600 dark:text-green-400">Active</p>
                            <p class="text-lg font-bold text-green-900 dark:text-green-100">{{ $activeStudents }}</p>
                        </div>
                    </div>
                </div>

                <!-- Inactive Students -->
                <div class="bg-yellow-50 dark:bg-yellow-900/20 rounded-lg p-3 border border-yellow-200 dark:border-yellow-800">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="w-8 h-8 bg-yellow-500 rounded-full flex items-center justify-center">
                                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                                </svg>
                            </div>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium text-yellow-600 dark:text-yellow-400">Inactive</p>
                            <p class="text-lg font-bold text-yellow-900 dark:text-yellow-100">{{ $inactiveStudents ?? 0 }}</p>
                        </div>
                    </div>
                </div>

                <!-- Deleted -->
                <div class="bg-gray-50 dark:bg-gray-900/20 rounded-lg p-3 border border-gray-200 dark:border-gray-700">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="w-8 h-8 bg-gray-500 rounded-full flex items-center justify-center">
                                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                </svg>
                            </div>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Deleted</p>
                            <p class="text-lg font-bold text-gray-900 dark:text-gray-100">{{ $softDeletedStudents }}</p>
                        </div>
                    </div>
                </div>

                <!-- Total Partners -->
                <div class="bg-purple-50 dark:bg-purple-900/20 rounded-lg p-3 border border-purple-200 dark:border-purple-800">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="w-8 h-8 bg-purple-500 rounded-full flex items-center justify-center">
                                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                </svg>
                            </div>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium text-purple-600 dark:text-purple-400">Total Partners</p>
                            <p class="text-lg font-bold text-purple-900 dark:text-purple-100">{{ $totalPartners }}</p>
                        </div>
                    </div>
                </div>

                <!-- Login Access Card -->
                <div class="bg-indigo-50 dark:bg-indigo-900/20 rounded-lg p-3 border border-indigo-200 dark:border-indigo-800">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="w-8 h-8 bg-indigo-500 rounded-full flex items-center justify-center">
                                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"></path>
                                </svg>
                            </div>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium text-indigo-600 dark:text-indigo-400">Login Access</p>
                            <p class="text-lg font-bold text-indigo-900 dark:text-indigo-100">{{ $studentsWithLoginAccess ?? 0 }}</p>
                        </div>
                    </div>
                </div>

                <!-- New Registrations Card -->
                <div class="bg-teal-50 dark:bg-teal-900/20 rounded-lg p-3 border border-teal-200 dark:border-teal-800">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="w-8 h-8 bg-teal-500 rounded-full flex items-center justify-center">
                                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path>
                                </svg>
                            </div>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium text-teal-600 dark:text-teal-400">New This Month</p>
                            <p class="text-lg font-bold text-teal-900 dark:text-teal-100">{{ $newStudentsThisMonth ?? 0 }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Filters & Search Section -->
    <div class="bg-white dark:bg-gray-800 shadow-sm border-b border-gray-200 dark:border-gray-700">
        <div class="px-4 sm:px-6 lg:px-8 py-4">
            <div class="space-y-4">
                <!-- Search and Filters Row -->
                <div class="flex flex-col sm:flex-row gap-4">
                    <!-- Search Input -->
                    <div class="flex-1">
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                </svg>
                            </div>
                            <input type="text" 
                                   id="searchInput"
                                   placeholder="Search by Name, Mobile or Email" 
                                   class="block w-full pl-10 pr-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md leading-5 bg-white dark:bg-gray-700 placeholder-gray-500 dark:placeholder-gray-400 focus:outline-none focus:placeholder-gray-400 focus:ring-1 focus:ring-blue-500 focus:border-blue-500 text-sm">
                        </div>
                    </div>

                    <!-- Partner Filter -->
                    <div class="sm:w-48">
                        <select id="partnerFilter" class="block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 text-sm">
                            <option value="">All Partners</option>
                            @foreach($partners as $partner)
                                <option value="{{ $partner->id }}">{{ $partner->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Status Filter -->
                    <div class="sm:w-32">
                        <select id="statusFilter" class="block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 text-sm">
                            <option value="">All Status</option>
                            <option value="active">Active</option>
                            <option value="suspended">Suspended</option>
                            <option value="soft_deleted">Soft Deleted</option>
                        </select>
                    </div>

                    <!-- Login Enabled Filter -->
                    <div class="sm:w-36">
                        <select id="loginEnabledFilter" class="block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 text-sm">
                            <option value="">All Login</option>
                            <option value="yes">Login Enabled</option>
                            <option value="no">Login Disabled</option>
                        </select>
                    </div>

                    <!-- Date Range Filter -->
                    <div class="sm:w-40">
                        <input type="date" 
                               id="dateFrom"
                               class="block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 text-sm">
                    </div>

                    <!-- Filter Button -->
                    <button id="filterBtn" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path>
                        </svg>
                        Filter
                    </button>

                    <!-- Clear Filters Button -->
                    <button id="clearFiltersBtn" class="inline-flex items-center px-4 py-2 border border-gray-300 dark:border-gray-600 text-sm font-medium rounded-md text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                        Clear
                    </button>
                </div>

                <!-- Soft Delete Toggle -->
                <div class="flex items-center space-x-4">
                    <label class="inline-flex items-center">
                        <input type="checkbox" id="showDeleted" class="form-checkbox h-4 w-4 text-blue-600 transition duration-150 ease-in-out">
                        <span class="ml-2 text-sm text-gray-700 dark:text-gray-300">Show Deleted Only</span>
                    </label>
                    <label class="inline-flex items-center">
                        <input type="checkbox" id="showAllStudents" checked class="form-checkbox h-4 w-4 text-blue-600 transition duration-150 ease-in-out">
                        <span class="ml-2 text-sm text-gray-700 dark:text-gray-300">Show All Students</span>
                    </label>
                </div>
            </div>
        </div>
    </div>

    <!-- Pagination -->
    <div class="bg-white dark:bg-gray-800 px-4 py-3 flex items-center justify-between border-t border-gray-200 dark:border-gray-700 sm:px-6">
        <div class="flex-1 flex justify-between sm:hidden">
            @if ($students->onFirstPage())
                <span class="relative inline-flex items-center px-4 py-2 border border-gray-300 dark:border-gray-600 text-sm font-medium rounded-md text-gray-400 dark:text-gray-500 bg-gray-100 dark:bg-gray-800 cursor-not-allowed">
                    Previous
                </span>
            @else
                <a href="{{ $students->previousPageUrl() }}" class="relative inline-flex items-center px-4 py-2 border border-gray-300 dark:border-gray-600 text-sm font-medium rounded-md text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                    Previous
                </a>
            @endif

            @if ($students->hasMorePages())
                <a href="{{ $students->nextPageUrl() }}" class="ml-3 relative inline-flex items-center px-4 py-2 border border-gray-300 dark:border-gray-600 text-sm font-medium rounded-md text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                    Next
                </a>
            @else
                <span class="ml-3 relative inline-flex items-center px-4 py-2 border border-gray-300 dark:border-gray-600 text-sm font-medium rounded-md text-gray-400 dark:text-gray-500 bg-gray-100 dark:bg-gray-800 cursor-not-allowed">
                    Next
                </span>
            @endif
        </div>
        <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
            <div>
                <p class="text-sm text-gray-700 dark:text-gray-300">
                    Showing <span class="font-medium">{{ $students->firstItem() }}</span> to <span class="font-medium">{{ $students->lastItem() }}</span> of <span class="font-medium">{{ $students->total() }}</span> results
                </p>
            </div>
            <div>
                {{ $students->links() }}
            </div>
        </div>
    </div>

    <!-- Bulk Actions Bar (Hidden by default) -->
    <div id="bulkActionsBar" class="bg-blue-50 dark:bg-blue-900/20 border-b border-blue-200 dark:border-blue-800 hidden">
        <div class="px-4 sm:px-6 lg:px-8 py-3">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-4">
                    <span class="text-sm font-medium text-blue-900 dark:text-blue-100">
                        <span id="selectedCount">0</span> students selected
                    </span>
                    <select id="bulkActionSelect" class="block px-3 py-1 border border-blue-300 dark:border-blue-600 bg-white dark:bg-gray-700 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 text-sm">
                        <option value="">Bulk Actions</option>
                        <option value="suspend">Suspend</option>
                        <option value="activate">Activate</option>
                        <option value="restore">Restore</option>
                        <option value="hard_delete">Hard Delete</option>
                        <option value="export_csv">Export CSV</option>
                        <option value="export_pdf">Export PDF</option>
                    </select>
                    <button id="applyBulkAction" class="inline-flex items-center px-3 py-1 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        Apply
                    </button>
                </div>
                <button id="clearSelection" class="text-sm text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-200">
                    Clear Selection
                </button>
            </div>
        </div>
    </div>

    <!-- Data Table -->
    <div class="bg-white dark:bg-gray-800 shadow-sm">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                <thead class="bg-gray-50 dark:bg-gray-700">
                    <tr>
                        <th scope="col" class="px-2 py-2 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider w-8">
                            <input type="checkbox" id="selectAll" class="form-checkbox h-3 w-3 text-blue-600">
                        </th>
                        <th scope="col" class="px-3 py-2 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider w-48">
                            Student
                        </th>
                        <th scope="col" class="px-2 py-2 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider w-24">
                            Partner
                        </th>
                        <th scope="col" class="px-2 py-2 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider w-20">
                            Joined
                        </th>
                        <th scope="col" class="px-2 py-2 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider w-16">
                            Tests
                        </th>
                        <th scope="col" class="px-2 py-2 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider w-16">
                            Score
                        </th>
                        <th scope="col" class="px-2 py-2 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider w-20">
                            Status
                        </th>
                        <th scope="col" class="px-2 py-2 text-center text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider w-20">
                            Login Enabled
                        </th>
                        <th scope="col" class="px-2 py-2 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider w-24">
                            Actions
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700" id="studentsTableBody">
                    @forelse($students as $student)
                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700" data-student-id="{{ $student->id }}">
                        <td class="px-2 py-2 whitespace-nowrap">
                            <input type="checkbox" class="student-checkbox form-checkbox h-3 w-3 text-blue-600" value="{{ $student->id }}">
                        </td>
                        <td class="px-3 py-2 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 h-6 w-6">
                                    <div class="h-6 w-6 rounded-full bg-gray-300 dark:bg-gray-600 flex items-center justify-center">
                                        <span class="text-xs font-medium text-gray-700 dark:text-gray-300">
                                            {{ substr($student->full_name, 0, 1) }}
                                        </span>
                                    </div>
                                </div>
                                <div class="ml-2 min-w-0 flex-1">
                                    <div class="text-xs font-medium text-gray-900 dark:text-gray-100 truncate">
                                        {{ $student->full_name }}
                                    </div>
                                    <div class="text-xs text-gray-500 dark:text-gray-400 truncate">
                                        {{ $student->phone }}
                                    </div>
                                </div>
                            </div>
                        </td>
                        <td class="px-2 py-2 whitespace-nowrap text-xs text-gray-900 dark:text-gray-100 truncate">
                            {{ $student->partner->name ?? 'N/A' }}
                        </td>
                        <td class="px-2 py-2 whitespace-nowrap text-xs text-gray-900 dark:text-gray-100">
                            {{ $student->created_at->format('M d, Y') }}
                        </td>
                        <td class="px-2 py-2 whitespace-nowrap text-xs text-gray-900 dark:text-gray-100 text-center">
                            {{ $student->exam_results_count ?? 0 }}
                        </td>
                        <td class="px-2 py-2 whitespace-nowrap text-xs text-gray-900 dark:text-gray-100 text-center">
                            {{ $student->average_score ?? 0 }}%
                        </td>
                        <td class="px-2 py-2 whitespace-nowrap">
                            @if($student->status === 'suspended')
                                <span class="inline-flex items-center px-1.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200">
                                    🔴
                                </span>
                            @else
                                <span class="inline-flex items-center px-1.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200">
                                    🟢
                                </span>
                            @endif
                        </td>
                        <td class="px-2 py-2 whitespace-nowrap text-center">
                            @if($student->has_login_access)
                                <div class="relative inline-block" x-data="{ open: false }">
                                    <button @click="open = !open" 
                                            class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200 hover:bg-green-200 dark:hover:bg-green-800 transition-colors cursor-pointer">
                                        <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0l1.403 5.591c.194.776.74 1.396 1.47 1.624l5.591 1.403c1.756.426 1.756 2.924 0 3.35l-5.591 1.403c-.73.228-1.276.848-1.47 1.624l-1.403 5.591c-.426 1.756-2.924 1.756-3.35 0l-1.403-5.591c-.194-.776-.74-1.396-1.47-1.624l-5.591-1.403c-1.756-.426-1.756-2.924 0-3.35l5.591-1.403c.73-.228 1.276-.848 1.47-1.624l1.403-5.591z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        </svg>
                                        Yes
                                    </button>
                                    
                                    <!-- Popup Menu -->
                                    <div x-show="open" 
                                         @click.away="open = false"
                                         x-transition:enter="transition ease-out duration-100"
                                         x-transition:enter-start="transform opacity-0 scale-95"
                                         x-transition:enter-end="transform opacity-100 scale-100"
                                         x-transition:leave="transition ease-in duration-75"
                                         x-transition:leave-start="transform opacity-100 scale-100"
                                         x-transition:leave-end="transform opacity-0 scale-95"
                                         class="absolute right-0 mt-2 w-48 bg-white dark:bg-gray-800 rounded-md shadow-lg z-50 border border-gray-200 dark:border-gray-700">
                                        <div class="py-1">
                                            <button onclick="disableLogin({{ $student->id }})" 
                                                    class="flex items-center w-full px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700">
                                                <svg class="w-4 h-4 mr-3 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192L5.636 18.364M12 2.25a9.75 9.75 0 100 19.5 9.75 9.75 0 000-19.5z"></path>
                                                </svg>
                                                Disable Login
                                            </button>
                                            <button onclick="resetPassword({{ $student->id }})" 
                                                    class="flex items-center w-full px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700">
                                                <svg class="w-4 h-4 mr-3 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"></path>
                                                </svg>
                                                Reset Password
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            @else
                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200">
                                    ❌ No
                                </span>
                            @endif
                        </td>
                        <td class="px-2 py-2 whitespace-nowrap text-xs font-medium">
                            <div class="relative" x-data="{ open: false }">
                                <!-- Action Menu Button -->
                                <button @click="open = !open" 
                                        class="inline-flex items-center px-2 py-1 text-xs font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-1 focus:ring-blue-500">
                                    ⋯
                                </button>

                                <!-- Dropdown Menu -->
                                <div x-show="open" 
                                     @click.away="open = false"
                                     x-transition:enter="transition ease-out duration-100"
                                     x-transition:enter-start="transform opacity-0 scale-95"
                                     x-transition:enter-end="transform opacity-100 scale-100"
                                     x-transition:leave="transition ease-in duration-75"
                                     x-transition:leave-start="transform opacity-100 scale-100"
                                     x-transition:leave-end="transform opacity-0 scale-95"
                                     class="absolute right-0 z-10 mt-1 w-48 origin-top-right bg-white dark:bg-gray-800 rounded-md shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none">
                                    <div class="py-1">
                                        <!-- View Profile -->
                                        <button onclick="viewStudent({{ $student->id }})" 
                                                class="flex items-center w-full px-3 py-1.5 text-xs text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700">
                                            <span class="mr-2">🔍</span>
                                            View Profile
                                        </button>
                                        
                                        <!-- Edit Info -->
                                        <button onclick="editStudent({{ $student->id }})" 
                                                class="flex items-center w-full px-3 py-1.5 text-xs text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700">
                                            <span class="mr-2">✏️</span>
                                            Edit Info
                                        </button>
                                        
                                        <!-- Suspend/Reactivate -->
                                        @if($student->status === 'suspended')
                                            <button onclick="reactivateStudent({{ $student->id }})" 
                                                    class="flex items-center w-full px-3 py-1.5 text-xs text-green-700 dark:text-green-300 hover:bg-green-50 dark:hover:bg-green-900/20">
                                                <span class="mr-2">✅</span>
                                                Reactivate
                                            </button>
                                        @else
                                            <button onclick="suspendStudent({{ $student->id }})" 
                                                    class="flex items-center w-full px-3 py-1.5 text-xs text-yellow-700 dark:text-yellow-300 hover:bg-yellow-50 dark:hover:bg-yellow-900/20">
                                                <span class="mr-2">🚫</span>
                                                Suspend
                                            </button>
                                        @endif
                                        
                                        <!-- Divider -->
                                        <div class="border-t border-gray-200 dark:border-gray-600 my-1"></div>
                                        
                                        <!-- Export Data -->
                                        <button onclick="exportStudentData({{ $student->id }})" 
                                                class="flex items-center w-full px-3 py-1.5 text-xs text-purple-700 dark:text-purple-300 hover:bg-purple-50 dark:hover:bg-purple-900/20">
                                            <span class="mr-2">📤</span>
                                            Export Data
                                        </button>
                                        
                                        <!-- Send Message -->
                                        <button onclick="sendMessage({{ $student->id }})" 
                                                class="flex items-center w-full px-3 py-1.5 text-xs text-indigo-700 dark:text-indigo-300 hover:bg-indigo-50 dark:hover:bg-indigo-900/20">
                                            <span class="mr-2">💬</span>
                                            Send Message
                                        </button>
                                        
                                        <!-- Divider -->
                                        <div class="border-t border-gray-200 dark:border-gray-600 my-1"></div>
                                        
                                        <!-- Delete Student -->
                                        <button onclick="deleteStudent({{ $student->id }})" 
                                                class="flex items-center w-full px-3 py-1.5 text-xs text-red-700 dark:text-red-300 hover:bg-red-50 dark:hover:bg-red-900/20">
                                            <span class="mr-2">🗑️</span>
                                            Delete Student
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="9" class="px-6 py-4 text-center text-sm text-gray-500 dark:text-gray-400">
                            No students found.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

    </div>

    <!-- Reporting Buttons -->
    <div class="bg-white dark:bg-gray-800 shadow-sm border-t border-gray-200 dark:border-gray-700">
        <div class="px-4 sm:px-6 lg:px-8 py-4">
            <div class="flex flex-wrap gap-3">
                <button class="inline-flex items-center px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    Export Current View to Excel
                </button>
                <button class="inline-flex items-center px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                    </svg>
                    Download Full Report (PDF)
                </button>
                <button class="inline-flex items-center px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                    </svg>
                    Generate Partner-wise Summary
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Student Detail Modal -->
<div id="studentModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white dark:bg-gray-800">
        <div class="mt-3">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100" id="modalTitle">Student Details</h3>
                <button onclick="closeModal()" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-200">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            <div id="modalContent" class="space-y-4">
                <!-- Student details will be loaded here -->
            </div>
            <div class="flex justify-end space-x-3 mt-6">
                <button onclick="closeModal()" class="px-4 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 rounded-md">
                    Close
                </button>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Wait a bit to ensure all elements are rendered
    setTimeout(() => {
        initializeCheckboxes();
        initializeFilters();
    }, 100);
});

function initializeCheckboxes() {
    // Bulk selection functionality
    const selectAllCheckbox = document.getElementById('selectAll');
    const studentCheckboxes = document.querySelectorAll('.student-checkbox');
    const bulkActionsBar = document.getElementById('bulkActionsBar');
    const selectedCount = document.getElementById('selectedCount');
    const clearSelection = document.getElementById('clearSelection');

    // Select all functionality
    if (selectAllCheckbox) {
        selectAllCheckbox.addEventListener('change', function() {
            studentCheckboxes.forEach(checkbox => {
                checkbox.checked = this.checked;
            });
            updateBulkActionsBar();
        });
    }

    // Individual checkbox functionality
    studentCheckboxes.forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            updateBulkActionsBar();
            updateSelectAllState();
        });
    });

    // Clear selection
    if (clearSelection) {
        clearSelection.addEventListener('click', function() {
            studentCheckboxes.forEach(checkbox => {
                checkbox.checked = false;
            });
            if (selectAllCheckbox) selectAllCheckbox.checked = false;
            updateBulkActionsBar();
        });
    }

    function updateBulkActionsBar() {
        const checkedBoxes = document.querySelectorAll('.student-checkbox:checked');
        if (checkedBoxes.length > 0) {
            if (bulkActionsBar) bulkActionsBar.classList.remove('hidden');
            if (selectedCount) selectedCount.textContent = checkedBoxes.length;
        } else {
            if (bulkActionsBar) bulkActionsBar.classList.add('hidden');
        }
    }

    function updateSelectAllState() {
        const totalCheckboxes = studentCheckboxes.length;
        const checkedBoxes = document.querySelectorAll('.student-checkbox:checked');
        
        if (selectAllCheckbox) {
            if (checkedBoxes.length === 0) {
                selectAllCheckbox.indeterminate = false;
                selectAllCheckbox.checked = false;
            } else if (checkedBoxes.length === totalCheckboxes) {
                selectAllCheckbox.indeterminate = false;
                selectAllCheckbox.checked = true;
            } else {
                selectAllCheckbox.indeterminate = true;
            }
        }
    }
}

function initializeFilters() {
    console.log('initializeFilters called');
    
    // Filter functionality
    const filterBtn = document.getElementById('filterBtn');
    const searchInput = document.getElementById('searchInput');
    const partnerFilter = document.getElementById('partnerFilter');
    const statusFilter = document.getElementById('statusFilter');
    const loginEnabledFilter = document.getElementById('loginEnabledFilter');
    const dateFrom = document.getElementById('dateFrom');
    const showDeleted = document.getElementById('showDeleted');
    const showAllStudents = document.getElementById('showAllStudents');

    console.log('Filter elements found:', {
        filterBtn: !!filterBtn,
        searchInput: !!searchInput,
        partnerFilter: !!partnerFilter,
        statusFilter: !!statusFilter,
        loginEnabledFilter: !!loginEnabledFilter,
        dateFrom: !!dateFrom,
        showDeleted: !!showDeleted,
        showAllStudents: !!showAllStudents
    });


    // Real-time search with debouncing
    let searchTimeout;
    if (searchInput) {
        searchInput.addEventListener('input', function() {
            clearTimeout(searchTimeout);
            searchTimeout = setTimeout(() => {
                applyFilters();
            }, 500); // Wait 500ms after user stops typing
        });
    }

    // Filter on change
    if (partnerFilter) {
        console.log('Adding change listener to partnerFilter');
        partnerFilter.addEventListener('change', applyFilters);
    }
    if (statusFilter) {
        console.log('Adding change listener to statusFilter');
        statusFilter.addEventListener('change', applyFilters);
    }
    if (loginEnabledFilter) {
        console.log('Adding change listener to loginEnabledFilter');
        loginEnabledFilter.addEventListener('change', applyFilters);
    }
    if (dateFrom) {
        console.log('Adding change listener to dateFrom');
        dateFrom.addEventListener('change', applyFilters);
    }

    if (filterBtn) {
        filterBtn.addEventListener('click', function() {
            applyFilters();
        });
    }

    // Clear filters functionality
    const clearFiltersBtn = document.getElementById('clearFiltersBtn');
    if (clearFiltersBtn) {
        clearFiltersBtn.addEventListener('click', function() {
            // Reset all filter inputs
            if (searchInput) searchInput.value = '';
            if (partnerFilter) partnerFilter.value = '';
            if (statusFilter) statusFilter.value = '';
            if (loginEnabledFilter) loginEnabledFilter.value = '';
            if (dateFrom) dateFrom.value = '';
            if (showDeleted) showDeleted.checked = false;
            if (showAllStudents) showAllStudents.checked = false;
            
            // Apply filters (which will now be empty)
            applyFilters();
        });
    }

    // Soft delete toggle
    if (showSoftDeleted) {
        showSoftDeleted.addEventListener('change', function() {
            if (this.checked) {
                if (showAllStudents) showAllStudents.checked = false;
            }
            applyFilters();
        });
    }

    // Show all students toggle
    if (showAllStudents) {
        showAllStudents.addEventListener('change', function() {
            if (this.checked) {
                if (showDeleted) showDeleted.checked = false;
            }
            applyFilters();
        });
    }
}

function applyFilters() {
    console.log('applyFilters called');
    
    const searchTerm = document.getElementById('searchInput')?.value || '';
    const partnerFilter = document.getElementById('partnerFilter')?.value || '';
    const statusFilter = document.getElementById('statusFilter')?.value || '';
    const loginEnabledFilter = document.getElementById('loginEnabledFilter')?.value || '';
    const dateFrom = document.getElementById('dateFrom')?.value || '';
    const showDeleted = document.getElementById('showDeleted')?.checked || false;
    const showAllStudents = document.getElementById('showAllStudents')?.checked || false;

    console.log('Filter values:', {
        searchTerm,
        partnerFilter,
        statusFilter,
        loginEnabledFilter,
        dateFrom,
        showDeleted,
        showAllStudents
    });

    // Build query parameters
    const params = new URLSearchParams();
    if (searchTerm) params.append('search', searchTerm);
    if (partnerFilter) params.append('partner', partnerFilter);
    if (statusFilter) params.append('status', statusFilter);
    if (loginEnabledFilter) params.append('login_enabled', loginEnabledFilter);
    if (dateFrom) params.append('date_from', dateFrom);
    if (showDeleted) params.append('soft_deleted', '1');
    if (showAllStudents) params.append('all_students', '1');

    // Show loading state
    const tableBody = document.getElementById('studentsTableBody');
    if (!tableBody) {
        console.error('studentsTableBody not found');
        return;
    }
    
    tableBody.innerHTML = '<tr><td colspan="9" class="px-6 py-4 text-center text-sm text-gray-500 dark:text-gray-400">Loading...</td></tr>';

    const url = `/system-admin/students?${params.toString()}`;
    console.log('Making request to:', url);

    // Make AJAX request
    fetch(url, {
        method: 'GET',
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'Accept': 'text/html',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
    })
    .then(response => {
        console.log('Response status:', response.status);
        console.log('Response headers:', response.headers);
        
        if (response.status === 302) {
            console.log('302 redirect detected');
            tableBody.innerHTML = '<tr><td colspan="9" class="px-6 py-4 text-center text-sm text-red-500">Authentication required. Please refresh the page and try again.</td></tr>';
            return;
        }
        if (!response.ok) {
            console.error('Response not ok:', response.status, response.statusText);
            throw new Error(`HTTP error! status: ${response.status}`);
        }
        return response.text();
    })
    .then(html => {
        console.log('Response HTML length:', html.length);
        console.log('Response HTML preview:', html.substring(0, 200));
        
        // Extract table body from response
        const parser = new DOMParser();
        const doc = parser.parseFromString(html, 'text/html');
        const newTableBody = doc.getElementById('studentsTableBody');

        console.log('New table body found:', !!newTableBody);
        if (newTableBody) {
            console.log('New table body HTML:', newTableBody.innerHTML.substring(0, 200));
            tableBody.innerHTML = newTableBody.innerHTML;
            // Re-initialize event listeners for new checkboxes
            initializeCheckboxes();
        } else {
            console.log('No table body found in response');
            tableBody.innerHTML = '<tr><td colspan="9" class="px-6 py-4 text-center text-sm text-gray-500 dark:text-gray-400">No students found</td></tr>';
        }
    })
    .catch(error => {
        console.error('Error filtering students:', error);
        tableBody.innerHTML = '<tr><td colspan="9" class="px-6 py-4 text-center text-sm text-red-500">Error loading data</td></tr>';
    });
}

// Student action functions
function viewStudent(studentId) {
    // Load student details and show modal
    document.getElementById('studentModal').classList.remove('hidden');
    document.getElementById('modalTitle').textContent = 'Student Details';
    document.getElementById('modalContent').innerHTML = `
        <div class="space-y-3">
            <div><strong>Name:</strong> <span id="studentName">Loading...</span></div>
            <div><strong>Mobile:</strong> <span id="studentMobile">Loading...</span></div>
            <div><strong>Email:</strong> <span id="studentEmail">Loading...</span></div>
            <div><strong>Partner:</strong> <span id="studentPartner">Loading...</span></div>
            <div><strong>Joined:</strong> <span id="studentJoined">Loading...</span></div>
            <div><strong>Tests Attempted:</strong> <span id="studentTests">Loading...</span></div>
            <div><strong>Average Score:</strong> <span id="studentScore">Loading...</span></div>
            <div><strong>Last Login:</strong> <span id="studentLastLogin">Loading...</span></div>
        </div>
    `;
    
    // Load student data via AJAX
    fetch(`/system-admin/students/${studentId}`)
        .then(response => response.json())
        .then(data => {
            document.getElementById('studentName').textContent = data.name;
            document.getElementById('studentMobile').textContent = data.mobile;
            document.getElementById('studentEmail').textContent = data.email || 'N/A';
            document.getElementById('studentPartner').textContent = (data.partner && data.partner.name) || 'N/A';
            document.getElementById('studentJoined').textContent = data.created_at;
            document.getElementById('studentTests').textContent = data.exam_results_count || 0;
            document.getElementById('studentScore').textContent = (data.average_score || 0) + '%';
            document.getElementById('studentLastLogin').textContent = data.last_login_at || 'Never';
        })
        .catch(error => {
            console.error('Error loading student data:', error);
        });
}

function closeModal() {
    document.getElementById('studentModal').classList.add('hidden');
}

function suspendStudent(studentId) {
    if (confirm('Are you sure you want to suspend this student?')) {
        // Implement suspend functionality
        console.log('Suspending student:', studentId);
    }
}

function activateStudent(studentId) {
    if (confirm('Are you sure you want to activate this student?')) {
        // Implement activate functionality
        console.log('Activating student:', studentId);
    }
}

function restoreStudent(studentId) {
    if (confirm('Are you sure you want to restore this student?')) {
        // Implement restore functionality
        console.log('Restoring student:', studentId);
    }
}

function hardDeleteStudent(studentId) {
    if (confirm('Are you sure you want to permanently delete this student? This action cannot be undone.')) {
        // Implement hard delete functionality
        console.log('Hard deleting student:', studentId);
    }
}

// New action button functions
function editStudent(studentId) {
    // Open edit modal or redirect to edit page
    const editUrl = `/system-admin/students/${studentId}/edit`;
    window.open(editUrl, '_blank');
}

function reactivateStudent(studentId) {
    if (confirm('Are you sure you want to reactivate this student?')) {
        // Implement reactivate functionality
        fetch(`/system-admin/students/${studentId}/reactivate`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Content-Type': 'application/json',
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
            } else {
                alert('Error reactivating student: ' + (data.message || 'Unknown error'));
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error reactivating student');
        });
    }
}

function deleteStudent(studentId) {
    if (confirm('Are you sure you want to delete this student? This action can be undone.')) {
        // Implement soft delete functionality
        fetch(`/system-admin/students/${studentId}/delete`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Content-Type': 'application/json',
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
            } else {
                alert('Error deleting student: ' + (data.message || 'Unknown error'));
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error deleting student');
        });
    }
}

function exportStudentData(studentId) {
    // Show export options modal
    const exportModal = document.createElement('div');
    exportModal.className = 'fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50';
    exportModal.innerHTML = `
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white dark:bg-gray-800">
            <div class="mt-3">
                <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Export Student Data</h3>
                <div class="space-y-3">
                    <button onclick="exportStudentPDF(${studentId})" class="w-full bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                        📄 Export as PDF
                    </button>
                    <button onclick="exportStudentCSV(${studentId})" class="w-full bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                        📊 Export as CSV
                    </button>
                    <button onclick="exportStudentExcel(${studentId})" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                        📈 Export as Excel
                    </button>
                </div>
                <div class="mt-4">
                    <button onclick="this.closest('.fixed').remove()" class="w-full bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded">
                        Cancel
                    </button>
                </div>
            </div>
        </div>
    `;
    document.body.appendChild(exportModal);
}

function exportStudentPDF(studentId) {
    window.open(`/system-admin/students/${studentId}/export/pdf`, '_blank');
    document.querySelector('.fixed').remove();
}

function exportStudentCSV(studentId) {
    window.open(`/system-admin/students/${studentId}/export/csv`, '_blank');
    document.querySelector('.fixed').remove();
}

function exportStudentExcel(studentId) {
    window.open(`/system-admin/students/${studentId}/export/excel`, '_blank');
    document.querySelector('.fixed').remove();
}

function sendMessage(studentId) {
    // Show message modal
    const messageModal = document.createElement('div');
    messageModal.className = 'fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50';
    messageModal.innerHTML = `
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white dark:bg-gray-800">
            <div class="mt-3">
                <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Send Message</h3>
                <div class="space-y-3">
                    <button onclick="sendEmail(${studentId})" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                        📧 Send Email
                    </button>
                    <button onclick="sendSMS(${studentId})" class="w-full bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                        📱 Send SMS
                    </button>
                    <button onclick="sendNotification(${studentId})" class="w-full bg-purple-600 hover:bg-purple-700 text-white font-bold py-2 px-4 rounded">
                        🔔 Send Notification
                    </button>
                </div>
                <div class="mt-4">
                    <button onclick="this.closest('.fixed').remove()" class="w-full bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded">
                        Cancel
                    </button>
                </div>
            </div>
        </div>
    `;
    document.body.appendChild(messageModal);
}

function sendEmail(studentId) {
    window.open(`/system-admin/students/${studentId}/send-email`, '_blank');
    document.querySelector('.fixed').remove();
}

function sendSMS(studentId) {
    window.open(`/system-admin/students/${studentId}/send-sms`, '_blank');
    document.querySelector('.fixed').remove();
}

function sendNotification(studentId) {
    window.open(`/system-admin/students/${studentId}/send-notification`, '_blank');
    document.querySelector('.fixed').remove();
}

// Login management functions
function disableLogin(studentId) {
    if (confirm('Are you sure you want to disable login access for this student?')) {
        fetch(`/system-admin/students/${studentId}/disable-login`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('Login access disabled successfully');
                // Refresh the page to update the UI
                location.reload();
            } else {
                alert('Error disabling login access: ' + (data.message || 'Unknown error'));
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error disabling login access');
        });
    }
}

function resetPassword(studentId) {
    if (confirm('Are you sure you want to reset the password for this student? A new temporary password will be generated.')) {
        fetch(`/system-admin/students/${studentId}/reset-password`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('Password reset successfully. New temporary password: ' + data.temporary_password);
                // Optionally copy to clipboard
                if (navigator.clipboard) {
                    navigator.clipboard.writeText(data.temporary_password);
                }
            } else {
                alert('Error resetting password: ' + (data.message || 'Unknown error'));
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error resetting password');
        });
    }
}
</script>
@endpush

