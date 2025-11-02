@extends('layouts.partner-layout')

@section('title', 'Enrollment Report - Grouped by Course & Batch')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-slate-50 via-blue-50 to-indigo-50 dark:from-gray-900 dark:via-slate-900 dark:to-indigo-950 -m-6 p-4 sm:p-6 lg:p-8" x-data="{ showFilters: false }">
    <div class="max-w-7xl mx-auto space-y-6">
    
    {{-- Flash Messages --}}
    @if(session('success'))
    <div class="mb-6 bg-gradient-to-r from-emerald-50 to-green-50 dark:from-emerald-900/20 dark:to-green-900/20 border-l-4 border-emerald-500 p-4 rounded-xl shadow-sm animate-slide-in">
        <div class="flex items-center">
            <svg class="w-5 h-5 text-emerald-500 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            <p class="text-sm font-medium text-emerald-800 dark:text-emerald-300">{{ session('success') }}</p>
        </div>
    </div>
    @endif

    @if(session('error'))
    <div class="mb-6 bg-gradient-to-r from-red-50 to-pink-50 dark:from-red-900/20 dark:to-pink-900/20 border-l-4 border-red-500 p-4 rounded-xl shadow-sm animate-slide-in">
        <div class="flex items-center">
            <svg class="w-5 h-5 text-red-500 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            <p class="text-sm font-medium text-red-800 dark:text-red-300">{{ session('error') }}</p>
        </div>
    </div>
    @endif

        {{-- Header Section --}}
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h1 class="text-2xl sm:text-3xl lg:text-4xl font-extrabold text-gray-900 dark:text-white mb-1">
                    Enrollment Report
                </h1>
                <p class="text-sm sm:text-base text-gray-600 dark:text-gray-400">
                    Students grouped by course and batch
                </p>
            </div>
            <div class="flex flex-col sm:flex-row gap-2">
                <a href="{{ route('partner.enrollments.create') }}" 
                   class="group inline-flex items-center justify-center gap-2 px-4 py-2.5 bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 text-white rounded-xl font-semibold shadow-lg hover:shadow-xl transition-all duration-200 hover:scale-105">
                    <svg class="w-4 h-4 group-hover:rotate-90 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"></path>
                    </svg>
                    <span>New Enrollment</span>
                </a>
                <a href="{{ route('partner.enrollments.bulk-create') }}" 
                   class="group inline-flex items-center justify-center gap-2 px-4 py-2.5 bg-gradient-to-r from-emerald-600 to-teal-600 hover:from-emerald-700 hover:to-teal-700 text-white rounded-xl font-semibold shadow-lg hover:shadow-xl transition-all duration-200 hover:scale-105">
                    <svg class="w-4 h-4 group-hover:rotate-12 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                    </svg>
                    <span>Bulk Enrollment</span>
                </a>
            </div>
        </div>

        {{-- Tab Navigation --}}
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl border border-gray-200 dark:border-gray-700 overflow-hidden">
            <div class="border-b border-gray-200 dark:border-gray-700">
                <nav class="flex -mb-px">
                    <a href="{{ route('partner.enrollments.index') }}" 
                       class="inline-flex items-center justify-center px-6 py-4 text-sm font-bold border-b-2 border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 dark:text-gray-400 dark:hover:text-gray-300 dark:hover:border-gray-600">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        Student View
                    </a>
                    <a href="{{ route('partner.enrollments.grouped-report') }}" 
                       class="inline-flex items-center justify-center px-6 py-4 text-sm font-bold border-b-2 border-indigo-500 text-indigo-600 dark:text-indigo-400 dark:border-indigo-400 bg-indigo-50 dark:bg-indigo-900/20">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                        </svg>
                        Course & Batch View
                    </a>
                </nav>
            </div>

            {{-- Filters Section --}}
            <div class="overflow-hidden">
                {{-- Filter Toggle (Mobile) --}}
                <div class="sm:hidden">
                    <button @click="showFilters = !showFilters" 
                            class="w-full px-4 py-3 flex items-center justify-between bg-gray-50 dark:bg-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 transition-colors">
                        <span class="font-semibold text-gray-700 dark:text-gray-300">Filters</span>
                        <svg class="w-5 h-5 text-gray-500 transition-transform duration-200" :class="{ 'rotate-180': showFilters }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </button>
                </div>

                {{-- Filter Form --}}
                <form method="GET" action="{{ route('partner.enrollments.grouped-report') }}" 
                      class="p-4 sm:p-6" 
                      :class="{ 'hidden': showFilters === false }"
                      x-show="showFilters || window.innerWidth >= 640">
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                        {{-- Search --}}
                        <div class="space-y-2">
                            <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300">Search Student</label>
                            <div class="relative">
                                <svg class="absolute left-3 top-1/2 transform -translate-y-1/2 w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                </svg>
                                <input type="text" name="search" value="{{ request('search') }}" 
                                       placeholder="Name, ID, Email..."
                                       class="w-full pl-10 pr-4 py-2.5 border-2 border-gray-200 dark:border-gray-600 rounded-xl focus:ring-4 focus:ring-indigo-500/20 focus:border-indigo-500 dark:bg-gray-700 dark:text-white transition-all duration-200">
                            </div>
                        </div>

                        {{-- Status Filter --}}
                        <div class="space-y-2">
                            <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300">Status</label>
                            <select name="status" class="w-full px-4 py-2.5 border-2 border-gray-200 dark:border-gray-600 rounded-xl focus:ring-4 focus:ring-indigo-500/20 focus:border-indigo-500 dark:bg-gray-700 dark:text-white transition-all duration-200">
                                <option value="all" {{ request('status') == 'all' ? 'selected' : '' }}>All Status</option>
                                @foreach($statuses as $key => $label)
                                    <option value="{{ $key }}" {{ request('status') == $key ? 'selected' : '' }}>{{ $label }}</option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Course Filter --}}
                        <div class="space-y-2">
                            <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300">Course</label>
                            <select name="course_id" class="w-full px-4 py-2.5 border-2 border-gray-200 dark:border-gray-600 rounded-xl focus:ring-4 focus:ring-indigo-500/20 focus:border-indigo-500 dark:bg-gray-700 dark:text-white transition-all duration-200">
                                <option value="all" {{ request('course_id') == 'all' ? 'selected' : '' }}>All Courses</option>
                                @foreach($courses as $course)
                                    <option value="{{ $course->id }}" {{ request('course_id') == $course->id ? 'selected' : '' }}>{{ $course->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Actions --}}
                        <div class="flex flex-col sm:flex-row gap-2">
                            <button type="submit" class="flex-1 bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 text-white font-semibold px-4 py-2.5 rounded-xl transition-all duration-200 shadow-md hover:shadow-lg">
                                <span class="flex items-center justify-center gap-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.414A1 1 0 013 6.707V4z"></path>
                                    </svg>
                                    Filter
                                </span>
                            </button>
                            <a href="{{ route('partner.enrollments.grouped-report') }}" class="flex-1 bg-gray-600 hover:bg-gray-700 text-white font-semibold px-4 py-2.5 rounded-xl transition-all duration-200 shadow-md hover:shadow-lg text-center">
                                Clear
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        {{-- Enrollments Table Grouped by Course & Batch --}}
        <div class="space-y-6">
            @forelse($groupedEnrollments as $courseId => $batches)
                @php
                    $course = $batches->first()?->first()?->course;
                    if (!$course) continue;
                @endphp
                
                {{-- Course Header --}}
                <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg border border-gray-200 dark:border-gray-700 overflow-hidden">
                    <div class="bg-gradient-to-r from-indigo-500 to-purple-600 px-4 sm:px-6 py-4">
                        <div class="flex items-center gap-4">
                            <div class="w-14 h-14 bg-white/20 backdrop-blur-md rounded-xl flex items-center justify-center text-white font-bold text-xl flex-shrink-0 shadow-lg">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                </svg>
                            </div>
                            <div class="flex-1 min-w-0">
                                <h3 class="text-xl font-bold text-white truncate">
                                    {{ $course->name }}
                                </h3>
                                <p class="text-indigo-100 dark:text-indigo-200 truncate">
                                    {{ $course->code }} • {{ $batches->collapse()->count() }} {{ $batches->collapse()->count() === 1 ? 'Student' : 'Students' }}
                                </p>
                            </div>
                        </div>
                    </div>

                    {{-- Batches --}}
                    @foreach($batches as $batchId => $enrollments)
                        @php
                            $batch = $enrollments->first()?->batch;
                        @endphp
                        
                        {{-- Batch Header with indentation --}}
                        <div class="bg-gray-50 dark:bg-gray-700/50 px-4 sm:px-6 py-3 border-b border-gray-200 dark:border-gray-700 ml-6 md:ml-8">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 bg-purple-500 rounded-lg flex items-center justify-center text-white font-bold flex-shrink-0">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                    </svg>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <h4 class="text-lg font-bold text-gray-900 dark:text-white truncate">
                                        {{ $batch ? $batch->display_name : 'No Batch Assigned' }}
                                    </h4>
                                    <p class="text-sm text-gray-600 dark:text-gray-400">
                                        {{ $batch ? $batch->year : '' }} • {{ $enrollments->count() }} {{ $enrollments->count() === 1 ? 'Student' : 'Students' }}
                                    </p>
                                </div>
                            </div>
                        </div>

                        {{-- Students in Batch with indentation --}}
                        <div class="block lg:hidden divide-y divide-gray-200 dark:divide-gray-700">
                            @foreach($enrollments as $enrollment)
                            <div class="p-4 hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors ml-16">
                                <div class="flex items-center gap-3">
                                    <div class="w-12 h-12 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-xl flex items-center justify-center text-white font-bold text-lg flex-shrink-0 shadow-lg">
                                        {{ substr($enrollment->student->full_name, 0, 1) }}
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <p class="text-sm font-bold text-gray-900 dark:text-white truncate">
                                            {{ $enrollment->student->full_name }}
                                        </p>
                                        <div class="flex flex-wrap items-center gap-x-3 gap-y-1 text-xs">
                                            <span class="text-gray-600 dark:text-gray-400">
                                                <span class="font-semibold">ID:</span> {{ $enrollment->student->student_id }}
                                            </span>
                                            <span class="text-gray-600 dark:text-gray-400">
                                                {{ $enrollment->enrolled_at->format('M d, Y') }}
                                            </span>
                                            @if($enrollment->status === 'active')
                                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-bold bg-emerald-100 text-emerald-800 dark:bg-emerald-900/30 dark:text-emerald-400 border border-emerald-200 dark:border-emerald-800">
                                                Active
                                            </span>
                                            @elseif($enrollment->status === 'completed')
                                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-bold bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-400 border border-blue-200 dark:border-blue-800">
                                                Completed
                                            </span>
                                            @elseif($enrollment->status === 'dropped')
                                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-bold bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400 border border-red-200 dark:border-red-800">
                                                Dropped
                                            </span>
                                            @elseif($enrollment->status === 'suspended')
                                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-bold bg-amber-100 text-amber-800 dark:bg-amber-900/30 dark:text-amber-400 border border-amber-200 dark:border-amber-800">
                                                Suspended
                                            </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>

                        {{-- Desktop View: Table with indentation --}}
                        <div class="hidden lg:block overflow-x-auto ml-16">
                            <table class="w-full">
                                <thead>
                                    <tr class="bg-gray-50 dark:bg-gray-700/50 border-b border-gray-200 dark:border-gray-700">
                                        <th class="px-6 py-3 text-left text-xs font-bold text-gray-700 dark:text-gray-300 uppercase tracking-wider">Student</th>
                                        <th class="px-6 py-3 text-left text-xs font-bold text-gray-700 dark:text-gray-300 uppercase tracking-wider">Student ID</th>
                                        <th class="px-6 py-3 text-left text-xs font-bold text-gray-700 dark:text-gray-300 uppercase tracking-wider">Enrolled Date</th>
                                        <th class="px-6 py-3 text-left text-xs font-bold text-gray-700 dark:text-gray-300 uppercase tracking-wider">Status</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                                    @foreach($enrollments as $enrollment)
                                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors">
                                        {{-- Student --}}
                                        <td class="px-6 py-4">
                                            <div class="flex items-center gap-3">
                                                <div class="w-10 h-10 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-xl flex items-center justify-center text-white font-bold flex-shrink-0 shadow-lg">
                                                    {{ substr($enrollment->student->full_name, 0, 1) }}
                                                </div>
                                                <div class="min-w-0">
                                                    <p class="text-sm font-bold text-gray-900 dark:text-white truncate">{{ $enrollment->student->full_name }}</p>
                                                    <p class="text-xs text-gray-500 dark:text-gray-400 truncate">{{ $enrollment->student->email }}</p>
                                                </div>
                                            </div>
                                        </td>

                                        {{-- Student ID --}}
                                        <td class="px-6 py-4">
                                            <p class="text-sm font-semibold text-gray-900 dark:text-white">{{ $enrollment->student->student_id }}</p>
                                        </td>

                                        {{-- Enrolled Date --}}
                                        <td class="px-6 py-4">
                                            <div class="flex items-center gap-2">
                                                <svg class="w-4 h-4 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                                </svg>
                                                <div>
                                                    <p class="text-sm font-semibold text-gray-900 dark:text-white">{{ $enrollment->enrolled_at->format('M d, Y') }}</p>
                                                    <p class="text-xs text-gray-500 dark:text-gray-400">{{ $enrollment->enrolled_at->format('g:i A') }}</p>
                                                </div>
                                            </div>
                                        </td>

                                        {{-- Status --}}
                                        <td class="px-6 py-4">
                                            @if($enrollment->status === 'active')
                                            <span class="inline-flex items-center px-3 py-1.5 rounded-full text-xs font-bold bg-emerald-100 text-emerald-800 dark:bg-emerald-900/30 dark:text-emerald-400 border border-emerald-200 dark:border-emerald-800">
                                                Active
                                            </span>
                                            @elseif($enrollment->status === 'completed')
                                            <span class="inline-flex items-center px-3 py-1.5 rounded-full text-xs font-bold bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-400 border border-blue-200 dark:border-blue-800">
                                                Completed
                                            </span>
                                            @elseif($enrollment->status === 'dropped')
                                            <span class="inline-flex items-center px-3 py-1.5 rounded-full text-xs font-bold bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400 border border-red-200 dark:border-red-800">
                                                Dropped
                                            </span>
                                            @elseif($enrollment->status === 'suspended')
                                            <span class="inline-flex items-center px-3 py-1.5 rounded-full text-xs font-bold bg-amber-100 text-amber-800 dark:bg-amber-900/30 dark:text-amber-400 border border-amber-200 dark:border-amber-800">
                                                Suspended
                                            </span>
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endforeach
                </div>
            @empty
            <div class="col-span-full">
                <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl border border-gray-200 dark:border-gray-700 p-12 text-center">
                    <div class="w-24 h-24 bg-gradient-to-br from-indigo-500 to-purple-500 rounded-full flex items-center justify-center mx-auto mb-6 shadow-2xl">
                        <svg class="w-12 h-12 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-3">No Enrollments Found</h3>
                    <p class="text-gray-600 dark:text-gray-400 mb-6 max-w-md mx-auto">
                        There are no enrollments matching your current filters.
                    </p>
                    <a href="{{ route('partner.enrollments.index') }}" 
                       class="inline-flex items-center gap-2 bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 text-white font-semibold px-6 py-3 rounded-xl transition-all duration-200 hover:scale-105 shadow-lg hover:shadow-xl">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                        </svg>
                        <span>Create New Enrollment</span>
                    </a>
                </div>
            </div>
            @endforelse
        </div>
    </div>
</div>
@endsection