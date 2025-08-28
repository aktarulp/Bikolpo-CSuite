@extends('layouts.partner-layout')

@section('title', 'Exams')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100 dark:from-gray-900 dark:to-gray-800 p-4">
    <div class="max-w-7xl mx-auto space-y-6">
        <!-- Enhanced Page Header -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg border border-gray-200 dark:border-gray-700 p-6">
            <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
                <div class="space-y-2">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-gradient-to-br from-primaryGreen to-emerald-500 rounded-xl flex items-center justify-center shadow-lg">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                            </svg>
                        </div>
                        <div>
                            <h1 class="text-2xl md:text-3xl font-bold bg-gradient-to-r from-gray-900 to-gray-600 dark:from-white dark:to-gray-300 bg-clip-text text-transparent">Exams Management</h1>
                            <p class="text-sm md:text-base text-gray-600 dark:text-gray-400 font-medium">Create, manage, and monitor your scheduled examinations</p>
                        </div>
                    </div>
                </div>
                <div class="flex flex-col md:flex-row gap-3 md:items-center">
                    <!-- Enhanced Search and Filter -->
                    <div class="bg-gray-50 dark:bg-gray-700 rounded-xl p-3 border border-gray-200 dark:border-gray-600">
                        <form method="GET" action="{{ route('partner.exams.index') }}" class="flex flex-col sm:flex-row gap-2">
                            <div class="relative">
                                <svg class="absolute left-2 top-1/2 transform -translate-y-1/2 w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                </svg>
                                <input type="text" name="q" value="{{ request('q') }}" placeholder="Search exams..." class="pl-8 pr-3 py-2 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 text-gray-900 dark:text-white placeholder-gray-500 dark:placeholder-gray-400 focus:ring-2 focus:ring-primaryGreen focus:border-transparent transition-all duration-200 w-48 md:w-56" />
                            </div>
                            <select name="status" class="px-3 py-2 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 text-gray-900 dark:text-white focus:ring-2 focus:ring-primaryGreen focus:border-transparent transition-all duration-200 text-sm">
                                <option value="">All Status</option>
                                @php($statuses=['draft','published','ongoing','completed','cancelled'])
                                @foreach($statuses as $s)
                                    <option value="{{ $s }}" {{ request('status')===$s ? 'selected' : '' }}>{{ ucfirst($s) }}</option>
                                @endforeach
                            </select>
                            <button class="bg-gray-200 hover:bg-gray-300 dark:bg-gray-600 dark:hover:bg-gray-500 text-gray-700 dark:text-gray-200 px-4 py-2 rounded-lg font-medium transition-all duration-200 hover:shadow-md text-sm">Filter</button>
                        </form>
                    </div>
                    <a href="{{ route('partner.exams.create') }}" 
                       class="inline-flex items-center gap-2 bg-gradient-to-r from-primaryGreen to-emerald-500 hover:from-emerald-500 hover:to-primaryGreen text-white px-4 py-2 rounded-xl font-semibold transition-all duration-200 transform hover:scale-105 hover:shadow-xl shadow-lg text-sm">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                        </svg>
                        Create Exam
                    </a>
                </div>
            </div>
        </div>

        <!-- Enhanced Status Counts -->
        @isset($counts)
        <div class="grid grid-cols-2 md:grid-cols-5 gap-3">
            <div class="bg-white dark:bg-gray-800 rounded-xl p-3 border border-gray-200 dark:border-gray-700 shadow-md hover:shadow-lg transition-all duration-200">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs font-medium text-gray-600 dark:text-gray-400">Total</p>
                        <p class="text-xl font-bold text-gray-900 dark:text-white">{{ $counts['all'] ?? 0 }}</p>
                    </div>
                    <div class="w-8 h-8 bg-gray-100 dark:bg-gray-700 rounded-lg flex items-center justify-center">
                        <svg class="w-4 h-4 text-gray-600 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                        </svg>
                    </div>
                </div>
            </div>
            <div class="bg-white dark:bg-gray-800 rounded-xl p-3 border border-gray-200 dark:border-gray-700 shadow-md hover:shadow-lg transition-all duration-200">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs font-medium text-gray-600 dark:text-gray-400">Draft</p>
                        <p class="text-xl font-bold text-gray-900 dark:text-white">{{ $counts['draft'] ?? 0 }}</p>
                    </div>
                    <div class="w-8 h-8 bg-gray-100 dark:bg-gray-700 rounded-lg flex items-center justify-center">
                        <svg class="w-4 h-4 text-gray-600 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                        </svg>
                    </div>
                </div>
            </div>
            <div class="bg-white dark:bg-gray-800 rounded-xl p-3 border border-gray-200 dark:border-gray-700 shadow-md hover:shadow-lg transition-all duration-200">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs font-medium text-gray-600 dark:text-gray-400">Published</p>
                        <p class="text-xl font-bold text-green-600 dark:text-green-400">{{ $counts['published'] ?? 0 }}</p>
                    </div>
                    <div class="w-8 h-8 bg-green-100 dark:bg-green-900/30 rounded-lg flex items-center justify-center">
                        <svg class="w-4 h-4 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                </div>
            </div>
            <div class="bg-white dark:bg-gray-800 rounded-xl p-3 border border-gray-200 dark:border-gray-700 shadow-md hover:shadow-lg transition-all duration-200">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs font-medium text-gray-600 dark:text-gray-400">Ongoing</p>
                        <p class="text-xl font-bold text-blue-600 dark:text-blue-400">{{ $counts['ongoing'] ?? 0 }}</p>
                    </div>
                    <div class="w-8 h-8 bg-blue-100 dark:bg-blue-900/30 rounded-lg flex items-center justify-center">
                        <svg class="w-4 h-4 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                </div>
            </div>
            <div class="bg-white dark:bg-gray-800 rounded-xl p-3 border border-gray-200 dark:border-gray-700 shadow-md hover:shadow-lg transition-all duration-200">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs font-medium text-gray-600 dark:text-gray-400">Completed</p>
                        <p class="text-xl font-bold text-purple-600 dark:text-purple-400">{{ $counts['completed'] ?? 0 }}</p>
                    </div>
                    <div class="w-8 h-8 bg-purple-100 dark:bg-purple-900/30 rounded-lg flex items-center justify-center">
                        <svg class="w-4 h-4 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                </div>
            </div>
            <div class="bg-white dark:bg-gray-800 rounded-xl p-3 border border-gray-200 dark:border-gray-700 shadow-md hover:shadow-lg transition-all duration-200">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs font-medium text-gray-600 dark:text-gray-400">Deleted</p>
                        <p class="text-xl font-bold text-red-600 dark:text-red-400">{{ $counts['deleted'] ?? 0 }}</p>
                    </div>
                    <div class="w-8 h-8 bg-red-100 dark:bg-red-900/30 rounded-lg flex items-center justify-center">
                        <svg class="w-4 h-4 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                        </svg>
                    </div>
                </div>
            </div>
        </div>
        @endisset

        <!-- Enhanced Exams List -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl border border-gray-200 dark:border-gray-700 overflow-hidden">
            <div class="p-4 border-b border-gray-200 dark:border-gray-700 bg-gradient-to-r from-gray-50 to-gray-100 dark:from-gray-700 dark:to-gray-800">
                <div class="flex flex-wrap gap-4 items-center">
                    <h2 class="text-lg font-bold text-gray-900 dark:text-white flex items-center gap-2">
                        <svg class="w-5 h-5 text-primaryGreen" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                        </svg>
                        Exam List ({{ $exams->total() }})
                    </h2>
                </div>
            </div>

            @if($exams->count() > 0)
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                        <thead class="bg-gray-50 dark:bg-gray-700/50">
                            <tr>
                                <th class="px-3 py-3 text-left text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider w-16">ID</th>
                                <th class="px-3 py-3 text-left text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider min-w-48">Title</th>
                                <th class="px-3 py-3 text-left text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider w-20">Type</th>
                                <th class="px-3 py-3 text-left text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider w-32" title="Questions: Assigned/Total">Total Questions</th>
                                <th class="px-3 py-3 text-left text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider w-28" title="Students Assigned to Exam">Total Students</th>
                                <th class="px-3 py-3 text-left text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider w-24">Status</th>
                                <th class="px-3 py-3 text-left text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider w-32">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                            @foreach($exams as $exam)
                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-all duration-200 group">
                                    <td class="px-3 py-3 whitespace-nowrap">
                                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-gray-200">#{{ $exam->id }}</span>
                                    </td>
                                    <td class="px-3 py-3 whitespace-nowrap">
                                        <a href="{{ route('partner.exams.show', $exam) }}" class="text-sm font-semibold text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-300 hover:underline transition-colors duration-200 block truncate max-w-xs">{{ $exam->title }}</a>
                                    </td>
                                    <td class="px-3 py-3 whitespace-nowrap">
                                        @if($exam->exam_type === 'online')
                                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 dark:bg-green-900/30 text-green-800 dark:text-green-200">
                                                Online
                                            </span>
                                        @else
                                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-orange-100 dark:bg-orange-900/30 text-orange-800 dark:text-orange-200">
                                                Offline
                                            </span>
                                        @endif
                                    </td>
                                    
                                    <td class="px-3 py-3 whitespace-nowrap">
                                        <div class="flex flex-col items-start space-y-1">
                                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium 
                                                @if(($exam->assigned_questions_count ?? 0) > 0) 
                                                    bg-blue-100 dark:bg-blue-900/30 text-blue-800 dark:text-blue-200
                                                @else 
                                                    bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-400
                                                @endif">
                                                {{ $exam->assigned_questions_count ?? 0 }}/{{ $exam->total_questions ?? 0 }}
                                            </span>
                                            @if(($exam->assigned_questions_count ?? 0) > 0 && ($exam->total_questions ?? 0) > 0)
                                                <span class="text-xs text-gray-500 dark:text-gray-400">
                                                    {{ round((($exam->assigned_questions_count / $exam->total_questions) * 100), 1) }}% filled
                                                </span>
                                            @endif
                                        </div>
                                    </td>
                                    
                                    <td class="px-3 py-3 whitespace-nowrap">
                                        <div class="flex flex-col items-start space-y-1">
                                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium
                                                @if(($exam->assigned_students_count ?? 0) > 0)
                                                    bg-purple-100 dark:bg-purple-900/30 text-purple-800 dark:text-purple-200
                                                @else
                                                    bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-400
                                                @endif">
                                                {{ $exam->assigned_students_count ?? 0 }} students
                                            </span>
                                            @if(($exam->assigned_students_count ?? 0) > 0)
                                                <span class="text-xs text-gray-500 dark:text-gray-400">
                                                    Assigned
                                                </span>
                                            @endif
                                        </div>
                                    </td>
                                    
                                    <td class="px-3 py-3 whitespace-nowrap">
                                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium
                                            @if($exam->status === 'published') bg-green-100 dark:bg-green-900/30 text-green-800 dark:text-green-200
                                            @elseif($exam->status === 'draft') bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-gray-200
                                            @elseif($exam->status === 'ongoing') bg-blue-100 dark:bg-blue-900/30 text-blue-800 dark:text-blue-200
                                            @elseif($exam->status === 'completed') bg-purple-100 dark:bg-purple-900/30 text-purple-800 dark:text-purple-200
                                            @else bg-red-100 dark:bg-red-900/30 text-red-800 dark:text-red-200 @endif">
                                            {{ ucfirst($exam->status) }}
                                        </span>
                                    </td>
                                    <td class="px-3 py-3 whitespace-nowrap">
                                        <div class="relative" x-data="{ open: false }" @click.outside="open = false" x-init="$nextTick(() => {
                                            // Close dropdown when scrolling
                                            window.addEventListener('scroll', () => { open = false; });
                                            // Close dropdown when resizing
                                            window.addEventListener('resize', () => { open = false; });
                                        })">
                                            <!-- Backdrop for dropdown -->
                                            <div x-show="open" 
                                                 x-transition:enter="transition-opacity ease-out duration-200"
                                                 x-transition:enter-start="opacity-0"
                                                 x-transition:enter-end="opacity-100"
                                                 x-transition:leave="transition-opacity ease-in duration-75"
                                                 x-transition:leave-start="opacity-100"
                                                 x-transition:leave-end="opacity-0"
                                                 class="fixed inset-0 bg-black bg-opacity-25 z-[9998]"
                                                 style="display: none;"
                                                 @click="open = false"></div>
                                            <button @click="open = !open; if(open) $nextTick(() => {
                                                const button = $el;
                                                const rect = button.getBoundingClientRect();
                                                const viewportWidth = window.innerWidth;
                                                const viewportHeight = window.innerHeight;
                                                
                                                const dropdown = $refs.dropdown;
                                                let left = rect.right - dropdown.offsetWidth;
                                                let top = rect.bottom + 4;
                                                
                                                // Ensure dropdown doesn't go off-screen to the left
                                                if (left < 8) left = 8;
                                                
                                                // Ensure dropdown doesn't go off-screen to the right
                                                if (left + dropdown.offsetWidth > viewportWidth - 8) {
                                                    left = viewportWidth - dropdown.offsetWidth - 8;
                                                }
                                                
                                                // If dropdown would go below viewport, position it above the button
                                                if (top + dropdown.offsetHeight > viewportHeight - 8) {
                                                    top = rect.top - dropdown.offsetHeight - 4;
                                                }
                                                
                                                dropdown.style.top = top + 'px';
                                                dropdown.style.left = left + 'px';
                                            })" class="inline-flex items-center px-2 py-1 rounded text-xs font-medium bg-gray-50 dark:bg-gray-700 text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-600 transition-colors duration-200 border border-gray-200 dark:border-gray-600">
                                                Actions
                                                <svg class="w-3 h-3 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                                </svg>
                                            </button>
                                            
                                            <!-- Dropdown Menu -->
                                            <div x-show="open"
                                                 x-transition:enter="transition ease-out duration-200"
                                                 x-transition:enter-start="opacity-0 scale-95"
                                                 x-transition:enter-end="opacity-100 scale-100"
                                                 x-transition:leave="transition ease-in duration-75"
                                                 x-transition:leave-start="opacity-100 scale-100"
                                                 x-transition:leave-end="opacity-0 scale-95"
                                                 class="fixed w-48 bg-white dark:bg-gray-800 rounded-lg shadow-2xl border border-gray-200 dark:border-gray-700 z-[9999] backdrop-blur-sm"
                                                 style="display: none;"
                                                 x-ref="dropdown">
                                                <div class="py-1">
                                                    <a href="{{ route('partner.exams.show', $exam) }}" class="flex items-center px-3 py-2 text-xs text-gray-700 dark:text-gray-300 hover:bg-blue-50 dark:hover:bg-blue-900/20 transition-colors duration-200 rounded mx-1">
                                                        <svg class="w-3 h-3 mr-2 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                                        </svg>
                                                        View Exam
                                                    </a>
                                                    
                                                    <a href="{{ route('partner.exams.edit', $exam) }}" class="flex items-center px-3 py-2 text-xs text-gray-700 dark:text-gray-300 hover:bg-green-50 dark:hover:bg-green-900/20 transition-colors duration-200 rounded mx-1">
                                                        <svg class="w-3 h-3 mr-2 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                                        </svg>
                                                        Edit Exam
                                                    </a>
                                                    
                                                    <a href="{{ route('partner.exams.assign', $exam) }}" class="flex items-center px-3 py-2 text-xs text-gray-700 dark:text-gray-300 hover:bg-purple-50 dark:hover:bg-purple-900/20 transition-colors duration-200 rounded mx-1">
                                                        <svg class="w-3 h-3 mr-2 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                                                        </svg>
                                                        Assign Students
                                                    </a>
                                                    
                                                    <a href="{{ route('partner.exams.assign-questions', $exam) }}" class="flex items-center px-3 py-2 text-xs text-gray-700 dark:text-gray-300 hover:bg-amber-50 dark:hover:bg-amber-900/20 transition-colors duration-200 rounded mx-1">
                                                        <svg class="w-3 h-3 mr-2 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                                        </svg>
                                                        Assign Questions
                                                    </a>
                                                    
                                                    @if($exam->status === 'draft')
                                                        <form action="{{ route('partner.exams.publish', $exam) }}" method="POST" class="block">
                                                            @csrf
                                                            <button type="submit" class="w-full text-left flex items-center px-3 py-2 text-xs text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors duration-200">
                                                                <svg class="w-3 h-3 mr-2 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M9 19l3 3m0 0l3-3m-3 3V10"></path>
                                                                </svg>
                                                                Publish Exam
                                                            </button>
                                                        </form>
                                                    @elseif($exam->status === 'published')
                                                        <form action="{{ route('partner.exams.unpublish', $exam) }}" method="POST" class="block">
                                                            @csrf
                                                            <button type="submit" class="w-full text-left flex items-center px-3 py-2 text-xs text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors duration-200">
                                                                <svg class="w-3 h-3 mr-2 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728L5.636 5.636m12.728 12.728L18.364 5.636M5.636 18.364l12.728-12.728"></path>
                                                                </svg>
                                                                Unpublish Exam
                                                            </button>
                                                        </form>
                                                    @endif
                                                    
                                                    <a href="{{ route('partner.exams.results', $exam) }}" class="flex items-center px-3 py-2 text-xs text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors duration-200">
                                                        <svg class="w-3 h-3 mr-2 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                                                        </svg>
                                                        View Results
                                                    </a>
                                                    
                                                    <a href="{{ route('partner.exams.export', $exam) }}" class="flex items-center px-3 py-2 text-xs text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors duration-200">
                                                        <svg class="w-3 h-3 mr-2 text-teal-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                                        </svg>
                                                        Export Data
                                                    </a>
                                                    
                                                    <div class="border-t border-gray-200 dark:border-gray-700 my-1"></div>
                                                    
                                                    <form action="{{ route('partner.exams.destroy', $exam) }}" method="POST" class="block">
                                                        @csrf @method('DELETE')
                                                        <button type="submit" class="w-full text-left flex items-center px-3 py-2 text-xs text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-900/20 transition-colors duration-200" onclick="return confirm('Are you sure you want to delete this exam?')">
                                                            <svg class="w-3 h-3 mr-2 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                            </svg>
                                                            Delete Exam
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                
                <!-- Enhanced Pagination -->
                <div class="p-4 border-t border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-700/50">
                    {{ $exams->links() }}
                </div>
            @else
                <!-- Enhanced Empty State -->
                <div class="p-8 text-center">
                    <div class="mx-auto w-20 h-20 bg-gray-100 dark:bg-gray-700 rounded-full flex items-center justify-center mb-4">
                        <svg class="w-10 h-10 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2">No exams found</h3>
                    <p class="text-base text-gray-600 dark:text-gray-400 mb-6 max-w-md mx-auto">Get started by creating your first exam to begin managing your assessment process</p>
                    <a href="{{ route('partner.exams.create') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-gradient-to-r from-primaryGreen to-emerald-500 hover:from-emerald-500 hover:to-primaryGreen text-white font-semibold rounded-xl transition-all duration-200 transform hover:scale-105 hover:shadow-xl shadow-lg text-sm">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                        </svg>
                        Create Your First Exam
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection 
