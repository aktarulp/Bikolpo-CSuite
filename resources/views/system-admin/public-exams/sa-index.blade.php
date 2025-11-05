@extends('system-admin.system-admin-layout')

@section('title', 'Public Exams')

@section('content')
<div class="flex-1 bg-gradient-to-br from-slate-50 via-blue-50 to-indigo-50 dark:from-gray-900 dark:via-slate-900 dark:to-gray-900 min-h-screen">
    <div class="max-w-7xl mx-auto space-y-6 p-6">
        <!-- Modern Page Header with Glassmorphism -->
        <div class="relative overflow-hidden bg-white/80 dark:bg-gray-800/80 backdrop-blur-xl rounded-3xl shadow-2xl border border-white/20 dark:border-gray-700/50 p-8">
            <!-- Decorative Background Elements -->
            <div class="absolute top-0 right-0 w-64 h-64 bg-gradient-to-br from-primaryGreen/10 to-blue-500/10 rounded-full blur-3xl -z-10"></div>
            <div class="absolute bottom-0 left-0 w-48 h-48 bg-gradient-to-tr from-purple-500/10 to-pink-500/10 rounded-full blur-3xl -z-10"></div>
            
            <div class="flex flex-col lg:flex-row gap-6 items-start lg:items-center justify-between relative z-10">
                <!-- Title Section -->
                <div class="space-y-3">
                    <div class="flex items-center gap-4">
                        <div class="relative">
                            <div class="w-14 h-14 bg-gradient-to-br from-primaryGreen via-emerald-500 to-teal-500 rounded-2xl flex items-center justify-center shadow-lg transform rotate-3 hover:rotate-6 transition-transform duration-300">
                                <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path>
                                </svg>
                            </div>
                            <div class="absolute -top-1 -right-1 w-4 h-4 bg-green-400 rounded-full animate-ping"></div>
                            <div class="absolute -top-1 -right-1 w-4 h-4 bg-green-500 rounded-full"></div>
                        </div>
                        <div>
                            <h1 class="text-3xl lg:text-4xl font-black bg-gradient-to-r from-gray-900 via-gray-700 to-gray-600 dark:from-white dark:via-gray-200 dark:to-gray-400 bg-clip-text text-transparent">
                                Exams Hub
                            </h1>
                            <p class="text-sm lg:text-base text-gray-600 dark:text-gray-400 font-medium mt-1">
                                Create, manage, and monitor your examinations with ease
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Actions Section -->
                <div class="flex flex-col sm:flex-row gap-3 w-full lg:w-auto">
                    <!-- Search and Filter -->
                    <div class="flex-1 lg:flex-initial">
                        <form method="GET" action="{{ route('system-admin.public-exams.index') }}" id="filterForm" class="flex flex-col sm:flex-row gap-3">
                            <div class="relative flex-1 lg:w-64">
                                <svg class="absolute left-4 top-1/2 transform -translate-y-1/2 w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                </svg>
                                <input type="text" name="q" id="searchInput" value="{{ request('q') }}" 
                                    placeholder="Search exams..." 
                                    class="pl-12 pr-4 py-3 rounded-xl border-2 border-gray-200 dark:border-gray-600 bg-white dark:bg-gray-800 text-gray-900 dark:text-white placeholder-gray-400 focus:ring-2 focus:ring-primaryGreen focus:border-primaryGreen transition-all duration-200 w-full shadow-sm hover:shadow-md" />
                            </div>
                            <select name="status" id="statusSelect" 
                                class="px-4 py-3 rounded-xl border-2 border-gray-200 dark:border-gray-600 bg-white dark:bg-gray-800 text-gray-900 dark:text-white focus:ring-2 focus:ring-primaryGreen focus:border-primaryGreen transition-all duration-200 text-sm font-medium shadow-sm hover:shadow-md cursor-pointer">
                                <option value="">All Status</option>
                                @php($statuses=['draft','published','ongoing','completed','cancelled'])
                                @foreach($statuses as $s)
                                    <option value="{{ $s }}" {{ request('status')===$s ? 'selected' : '' }}>{{ ucfirst($s) }}</option>
                                @endforeach
                            </select>
                        </form>
                    </div>
                    
                    <!-- Create Button -->
                    <a href="{{ route('system-admin.public-exams.create') }}" 
                       class="group relative inline-flex items-center justify-center gap-3 px-8 py-4 bg-gradient-to-r from-primaryGreen via-emerald-500 to-teal-500 hover:from-teal-500 hover:via-emerald-500 hover:to-primaryGreen text-white font-bold rounded-2xl transition-all duration-300 transform hover:scale-105 hover:shadow-2xl shadow-xl overflow-hidden">
                        <span class="absolute inset-0 w-full h-full bg-gradient-to-r from-white/0 via-white/20 to-white/0 transform -skew-x-12 -translate-x-full group-hover:translate-x-full transition-transform duration-700"></span>
                        <svg class="w-6 h-6 relative z-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                        </svg>
                        <span class="relative z-10 whitespace-nowrap">Create Exam</span>
                    </a>
                </div>
            </div>
        </div>

        <!-- Modern Stats Cards -->
        @isset($counts)
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-4">
            <!-- Total Card -->
            <div class="group relative overflow-hidden bg-gradient-to-br from-cyan-500 via-blue-500 to-indigo-600 dark:from-cyan-600 dark:via-blue-600 dark:to-indigo-700 rounded-xl p-2.5 shadow-xl hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2 hover:scale-105 border border-cyan-400/20">
                <div class="absolute top-0 right-0 w-16 h-16 bg-white/10 rounded-full -mr-6 -mt-6 blur-xl"></div>
                <div class="absolute bottom-0 left-0 w-10 h-10 bg-indigo-300/20 rounded-full -ml-4 -mb-4"></div>
                <div class="relative z-10">
                    <div class="flex items-center justify-between mb-1.5">
                        <div class="w-6 h-6 bg-white/25 backdrop-blur-md rounded-lg flex items-center justify-center shadow-lg ring-1 ring-white/30 group-hover:scale-110 transition-transform duration-300">
                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                            </svg>
                        </div>
                        <div class="w-5 h-5 bg-yellow-400/30 rounded-full flex items-center justify-center animate-pulse">
                            <span class="text-white text-[10px] font-bold">📊</span>
                        </div>
                    </div>
                    <p class="text-white/90 text-[10px] font-bold uppercase tracking-wider mb-1">Total Exams</p>
                    <p class="text-2xl font-black text-white drop-shadow-lg">{{ $counts['all'] ?? 0 }}</p>
                </div>
            </div>

            <!-- Draft Card -->
            <div class="group relative overflow-hidden bg-gradient-to-br from-amber-500 to-orange-600 dark:from-amber-600 dark:to-orange-700 rounded-xl p-2.5 shadow-lg hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-1">
                <div class="absolute top-0 right-0 w-12 h-12 bg-white/10 rounded-full -mr-4 -mt-4"></div>
                <div class="relative z-10">
                    <div class="flex items-center justify-between mb-1.5">
                        <div class="w-6 h-6 bg-white/20 backdrop-blur-sm rounded-lg flex items-center justify-center">
                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                            </svg>
                        </div>
                    </div>
                    <p class="text-white/80 text-[10px] font-semibold uppercase tracking-wider mb-0.5">Draft</p>
                    <p class="text-2xl font-black text-white">{{ $counts['draft'] ?? 0 }}</p>
                </div>
            </div>

            <!-- Published Card -->
            <div class="group relative overflow-hidden bg-gradient-to-br from-emerald-500 to-green-600 dark:from-emerald-600 dark:to-green-700 rounded-xl p-2.5 shadow-lg hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-1">
                <div class="absolute top-0 right-0 w-12 h-12 bg-white/10 rounded-full -mr-4 -mt-4"></div>
                <div class="relative z-10">
                    <div class="flex items-center justify-between mb-1.5">
                        <div class="w-6 h-6 bg-white/20 backdrop-blur-sm rounded-lg flex items-center justify-center">
                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                    </div>
                    <p class="text-white/80 text-[10px] font-semibold uppercase tracking-wider mb-0.5">Published</p>
                    <p class="text-2xl font-black text-white">{{ $counts['published'] ?? 0 }}</p>
                </div>
            </div>

            <!-- Ongoing Card -->
            <div class="group relative overflow-hidden bg-gradient-to-br from-blue-500 to-indigo-600 dark:from-blue-600 dark:to-indigo-700 rounded-xl p-2.5 shadow-lg hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-1">
                <div class="absolute top-0 right-0 w-12 h-12 bg-white/10 rounded-full -mr-4 -mt-4"></div>
                <div class="relative z-10">
                    <div class="flex items-center justify-between mb-1.5">
                        <div class="w-6 h-6 bg-white/20 backdrop-blur-sm rounded-lg flex items-center justify-center">
                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                    </div>
                    <p class="text-white/80 text-[10px] font-semibold uppercase tracking-wider mb-0.5">Ongoing</p>
                    <p class="text-2xl font-black text-white">{{ $counts['ongoing'] ?? 0 }}</p>
                </div>
            </div>

            <!-- Completed Card -->
            <div class="group relative overflow-hidden bg-gradient-to-br from-purple-500 to-pink-600 dark:from-purple-600 dark:to-pink-700 rounded-xl p-2.5 shadow-lg hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-1">
                <div class="absolute top-0 right-0 w-12 h-12 bg-white/10 rounded-full -mr-4 -mt-4"></div>
                <div class="relative z-10">
                    <div class="flex items-center justify-between mb-1.5">
                        <div class="w-6 h-6 bg-white/20 backdrop-blur-sm rounded-lg flex items-center justify-center">
                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                        </div>
                    </div>
                    <p class="text-white/80 text-[10px] font-semibold uppercase tracking-wider mb-0.5">Completed</p>
                    <p class="text-2xl font-black text-white">{{ $counts['completed'] ?? 0 }}</p>
                </div>
            </div>
        </div>
        @endisset

        <!-- Modern Exams Grid/List -->
        <div class="bg-white/80 dark:bg-gray-800/80 backdrop-blur-xl rounded-3xl shadow-2xl border border-white/20 dark:border-gray-700/50 overflow-hidden">
            <!-- Header -->
            <div class="p-6 border-b border-gray-200 dark:border-gray-700 bg-gradient-to-r from-slate-50 via-blue-50 to-indigo-50 dark:from-gray-800 dark:via-slate-800 dark:to-gray-800">
                <div class="flex flex-wrap gap-4 items-center justify-between">
                    <h2 class="text-xl font-black text-gray-900 dark:text-white flex items-center gap-3">
                        <div class="w-10 h-10 bg-gradient-to-br from-primaryGreen to-teal-500 rounded-xl flex items-center justify-center shadow-lg">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                            </svg>
                        </div>
                        <span>Exam List <span class="text-primaryGreen">({{ $exams->total() }})</span></span>
                    </h2>
                </div>
            </div>

            @if($exams->count() > 0)
                <div class="overflow-x-auto">
                    <table class="min-w-full">
                        <thead>
                            <tr class="border-b-2 border-gray-200 dark:border-gray-700">
                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 dark:text-gray-300 uppercase tracking-wider">Exam Code</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 dark:text-gray-300 uppercase tracking-wider">Exam Details</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 dark:text-gray-300 uppercase tracking-wider">Type</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 dark:text-gray-300 uppercase tracking-wider">Questions</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 dark:text-gray-300 uppercase tracking-wider">Students</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 dark:text-gray-300 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-4 text-center text-xs font-bold text-gray-700 dark:text-gray-300 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 dark:divide-gray-700/50">
                            @foreach($exams as $exam)
                                <tr class="hover:bg-gradient-to-r hover:from-blue-50/50 hover:to-indigo-50/50 dark:hover:from-gray-700/30 dark:hover:to-slate-700/30 transition-all duration-300 group border-b border-gray-100 dark:border-gray-700/30">
                                    <!-- ID Column -->
                                    <td class="px-6 py-5">
                                        <span class="inline-flex items-center px-3 py-1.5 rounded-full text-xs font-bold bg-gradient-to-r from-blue-100 to-indigo-100 dark:from-blue-900/40 dark:to-indigo-900/40 text-blue-700 dark:text-blue-300 shadow-sm border border-blue-200 dark:border-blue-800/50">
                                            {{ $exam->course ? $exam->course->code : '' }}-{{ $exam->exam_number }}
                                        </span>
                                    </td>
                                    
                                    <!-- Title Column -->
                                    <td class="px-6 py-5">
                                        <div class="flex flex-col">
                                            <a href="#" onclick="alert('Exam details are managed by partners. As a system administrator, you can view but not modify exams.')" class="text-base font-bold text-gray-900 dark:text-white hover:text-primaryGreen dark:hover:text-primaryGreen transition-colors duration-200 line-clamp-1">
                                                {{ $exam->title }}
                                            </a>
                                            <span class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                                                Created {{ $exam->created_at->diffForHumans() }}
                                            </span>
                                        </div>
                                    </td>
                                    
                                    <!-- Type Column -->
                                    <td class="px-6 py-5">
                                        @if($exam->exam_type === 'online')
                                            <span class="inline-flex items-center gap-2 px-3 py-2 rounded-xl text-xs font-bold bg-gradient-to-r from-emerald-100 to-green-100 dark:from-emerald-900/40 dark:to-green-900/40 text-emerald-700 dark:text-emerald-300 shadow-sm">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                                </svg>
                                                Online
                                            </span>
                                        @else
                                            <span class="inline-flex items-center gap-2 px-3 py-2 rounded-xl text-xs font-bold bg-gradient-to-r from-orange-100 to-amber-100 dark:from-orange-900/40 dark:to-amber-900/40 text-orange-700 dark:text-orange-300 shadow-sm">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                                </svg>
                                                Offline
                                            </span>
                                        @endif
                                    </td>
                                    
                                    <!-- Questions Column -->
                                    <td class="px-6 py-5">
                                        <div class="flex flex-col gap-2">
                                            <div class="flex items-center gap-2">
                                                <span class="inline-flex items-center px-3 py-1.5 rounded-lg text-sm font-bold
                                                    @if(($exam->assigned_questions_count ?? 0) > 0) 
                                                        bg-blue-100 dark:bg-blue-900/40 text-blue-700 dark:text-blue-300
                                                    @else 
                                                        bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-400
                                                    @endif shadow-sm">
                                                    {{ $exam->assigned_questions_count ?? 0 }}/{{ $exam->total_questions ?? 0 }}
                                                </span>
                                            </div>
                                            @if(($exam->assigned_questions_count ?? 0) > 0 && ($exam->total_questions ?? 0) > 0)
                                                <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-1.5">
                                                    <div class="bg-gradient-to-r from-blue-500 to-indigo-500 h-1.5 rounded-full transition-all duration-300" 
                                                         style="width: {{ round((($exam->assigned_questions_count / $exam->total_questions) * 100), 1) }}%"></div>
                                                </div>
                                            @endif
                                        </div>
                                    </td>
                                    
                                    <!-- Students Column -->
                                    <td class="px-6 py-5">
                                        <div class="flex items-center gap-2">
                                            <span class="inline-flex items-center gap-2 px-3 py-1.5 rounded-lg text-sm font-bold
                                                @if(($exam->assigned_students_count ?? 0) > 0)
                                                    bg-purple-100 dark:bg-purple-900/40 text-purple-700 dark:text-purple-300
                                                @else
                                                    bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-400
                                                @endif shadow-sm">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                                                </svg>
                                                {{ $exam->assigned_students_count ?? 0 }}
                                            </span>
                                        </div>
                                    </td>
                                    
                                    <!-- Status Column -->
                                    <td class="px-6 py-5">
                                        <span class="inline-flex items-center gap-2 px-3 py-2 rounded-xl text-xs font-bold shadow-sm
                                            @if($exam->status === 'published') bg-gradient-to-r from-emerald-100 to-green-100 dark:from-emerald-900/40 dark:to-green-900/40 text-emerald-700 dark:text-emerald-300
                                            @elseif($exam->status === 'draft') bg-gradient-to-r from-gray-100 to-slate-100 dark:from-gray-700 dark:to-slate-700 text-gray-700 dark:text-gray-300
                                            @elseif($exam->status === 'ongoing') bg-gradient-to-r from-blue-100 to-indigo-100 dark:from-blue-900/40 dark:to-indigo-900/40 text-blue-700 dark:text-blue-300
                                            @elseif($exam->status === 'completed') bg-gradient-to-r from-purple-100 to-pink-100 dark:from-purple-900/40 dark:to-pink-900/40 text-purple-700 dark:text-purple-300
                                            @else bg-gradient-to-r from-red-100 to-rose-100 dark:from-red-900/40 dark:to-rose-900/40 text-red-700 dark:text-red-300 @endif">
                                            <span class="w-2 h-2 rounded-full 
                                                @if($exam->status === 'published') bg-emerald-500
                                                @elseif($exam->status === 'draft') bg-gray-500
                                                @elseif($exam->status === 'ongoing') bg-blue-500 animate-pulse
                                                @elseif($exam->status === 'completed') bg-purple-500
                                                @else bg-red-500 @endif"></span>
                                            {{ ucfirst($exam->status) }}
                                        </span>
                                    </td>
                                    
                                    <!-- Actions Column -->
                                    <td class="px-6 py-5">
                                        <div class="flex justify-center">
                                            <a href="{{ route('system-admin.public-exams.show', $exam) }}" 
                                               class="group inline-flex items-center justify-center gap-2 px-4 py-2.5 rounded-xl text-sm font-bold bg-gradient-to-r from-blue-500 to-indigo-500 hover:from-indigo-500 hover:to-blue-500 text-white shadow-lg hover:shadow-xl transition-all duration-300 transform hover:scale-105"
                                               title="View Exam Configuration">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                </svg>
                                                <span class="hidden sm:inline">Configure</span>
                                            </a>
                                            
                                            <!-- Dropdown Menu -->
                                            <div x-show="open" 
                                                 @click.away="open = false"
                                                 x-transition:enter="transition ease-out duration-200"
                                                 x-transition:enter-start="transform opacity-0 scale-90"
                                                 x-transition:enter-end="transform opacity-100 scale-100"
                                                 x-transition:leave="transition ease-in duration-100"
                                                 x-transition:leave-start="transform opacity-100 scale-100"
                                                 x-transition:leave-end="transform opacity-0 scale-90"
                                                 class="absolute right-0 bottom-full mb-3 w-64 bg-white/95 dark:bg-gray-800/95 backdrop-blur-xl rounded-2xl shadow-2xl border border-gray-200/50 dark:border-gray-700/50 overflow-hidden" style="z-index: 999999 !important;">
                                                <div class="py-2">
                                                    <!-- View Details -->
                                                    <a href="{{ route('system-admin.public-exams.show', $exam) }}" 
                                                       class="flex items-center px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700">
                                                        <svg class="w-4 h-4 mr-3 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                        </svg>
                                                        View Details
                                                    </a>
                                                    
                                                    <!-- Edit Exam -->
                                                    <a href="#" onclick="alert('Exam editing is managed by partners. As a system administrator, you can view but not modify exams.')" 
                                                       class="flex items-center px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700">
                                                        <svg class="w-4 h-4 mr-3 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                                        </svg>
                                                        Edit Exam
                                                    </a>
                                                    
                                                    <!-- Publish/Unpublish -->
                                                    @if($exam->status === 'draft')
                                                        <form action="#" method="POST" class="block" onsubmit="alert('Exam publishing is managed by partners. As a system administrator, you can view but not modify exams.'); return false;">
                                                            @csrf
                                                            <button type="submit" 
                                                                    class="w-full flex items-center px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700">
                                                                <svg class="w-4 h-4 mr-3 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M9 19l3 3m0 0l3-3m-3 3V10"></path>
                                                                </svg>
                                                                Publish
                                                            </button>
                                                        </form>
                                                    @elseif($exam->status === 'published')
                                                        <form action="#" method="POST" class="block" onsubmit="alert('Exam unpublishing is managed by partners. As a system administrator, you can view but not modify exams.'); return false;">
                                                            @csrf
                                                            <button type="submit" 
                                                                    class="w-full flex items-center px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700">
                                                                <svg class="w-4 h-4 mr-3 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728L5.636 5.636m12.728 12.728L18.364 5.636M5.636 18.364l12.728-12.728"></path>
                                                                </svg>
                                                                Unpublish
                                                            </button>
                                                        </form>
                                                    @endif
                                                    
                                                    <div class="border-t border-gray-200 dark:border-gray-700 my-1"></div>
                                                    
                                                    <!-- Assign Questions -->
                                                    <a href="#" onclick="alert('Question assignment is managed by partners. As a system administrator, you can view but not modify exams.')" 
                                                       class="flex items-center justify-between px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700">
                                                        <div class="flex items-center">
                                                            <svg class="w-4 h-4 mr-3 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                                            </svg>
                                                            <span>Assign Questions</span>
                                                        </div>
                                                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium
                                                            @if(($exam->assigned_questions_count ?? 0) == 0) bg-red-100 text-red-800
                                                            @elseif(($exam->assigned_questions_count ?? 0) < ($exam->total_questions ?? 0)) bg-yellow-100 text-yellow-800
                                                            @else bg-green-100 text-green-800 @endif">
                                                            {{ $exam->assigned_questions_count ?? 0 }}/{{ $exam->total_questions ?? 0 }}
                                                        </span>
                                                    </a>
                                                    
                                                    <!-- Assign Students -->
                                                    <a href="#" onclick="alert('Student assignment is managed by partners. As a system administrator, you can view but not modify exams.')" 
                                                       class="flex items-center px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700">
                                                        <svg class="w-4 h-4 mr-3 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                                                        </svg>
                                                        Assign Students
                                                    </a>
                                                    
                                                    <!-- View Results -->
                                                    <a href="#" onclick="alert('Exam results are managed by partners. As a system administrator, you can view but not modify exams.')" 
                                                       class="flex items-center px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700">
                                                        <svg class="w-4 h-4 mr-3 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                                                        </svg>
                                                        View Results
                                                    </a>
                                                    
                                                    <!-- Download Question Paper -->
                                                    <a href="#" onclick="alert('Question paper download is managed by partners. As a system administrator, you can view but not modify exams.')" 
                                                       class="flex items-center px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700">
                                                        <svg class="w-4 h-4 mr-3 text-teal-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 15a2 2 0 01-2 2H7l-4 4V5a2 2 0 012-2h14a2 2 0 012 2z"></path>
                                                        </svg>
                                                        Download Question Paper
                                                    </a>
                                                    
                                                    <div class="border-t border-gray-200 dark:border-gray-700 my-1"></div>
                                                    
                                                    <!-- Delete Exam -->
                                                    <form action="#" method="POST" class="block" onsubmit="alert('Exam deletion is managed by partners. As a system administrator, you can view but not modify exams.'); return false;">
                                                        @csrf @method('DELETE')
                                                        <button type="submit" 
                                                                class="w-full flex items-center px-4 py-2 text-sm text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-900/20"
                                                                onclick="return confirm('Are you sure you want to delete this exam? This action cannot be undone.')">
                                                            <svg class="w-4 h-4 mr-3 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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
                
                <!-- Modern Pagination -->
                <div class="p-6 border-t border-gray-200 dark:border-gray-700 bg-gradient-to-r from-slate-50 via-blue-50 to-indigo-50 dark:from-gray-800 dark:via-slate-800 dark:to-gray-800">
                    {{ $exams->links() }}
                </div>
            @else
                <!-- Modern Empty State -->
                <div class="p-16 text-center">
                    <div class="relative inline-block mb-8">
                        <div class="absolute inset-0 bg-gradient-to-r from-primaryGreen/20 to-blue-500/20 rounded-full blur-2xl"></div>
                        <div class="relative w-32 h-32 bg-gradient-to-br from-slate-100 to-slate-200 dark:from-slate-700 dark:to-slate-800 rounded-3xl flex items-center justify-center shadow-xl transform rotate-6 hover:rotate-12 transition-transform duration-300">
                            <svg class="w-16 h-16 text-gray-400 dark:text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                        </div>
                    </div>
                    <h3 class="text-3xl font-black text-gray-900 dark:text-white mb-3">No Exams Found</h3>
                    <p class="text-lg text-gray-600 dark:text-gray-400 mb-8 max-w-md mx-auto">
                        Start building your assessment system by creating your first exam
                    </p>
                    <a href="#" onclick="alert('Exam creation is managed by partners. As a system administrator, you can view but not create exams.')" 
                       class="group relative inline-flex items-center justify-center gap-3 px-8 py-4 bg-gradient-to-r from-primaryGreen via-emerald-500 to-teal-500 hover:from-teal-500 hover:via-emerald-500 hover:to-primaryGreen text-white font-bold rounded-2xl transition-all duration-300 transform hover:scale-105 hover:shadow-2xl shadow-xl overflow-hidden">
                        <span class="absolute inset-0 w-full h-full bg-gradient-to-r from-white/0 via-white/20 to-white/0 transform -skew-x-12 -translate-x-full group-hover:translate-x-full transition-transform duration-700"></span>
                        <svg class="w-6 h-6 relative z-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                        </svg>
                        <span class="relative z-10">Create Your First Exam</span>
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>

<script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const filterForm = document.getElementById('filterForm');
    const searchInput = document.getElementById('searchInput');
    const statusSelect = document.getElementById('statusSelect');
    
    // Auto-submit form when status dropdown changes
    statusSelect.addEventListener('change', function() {
        filterForm.submit();
    });
    
    // Debounced search input - submit after user stops typing for 500ms
    let searchTimeout;
    searchInput.addEventListener('input', function() {
        clearTimeout(searchTimeout);
        searchTimeout = setTimeout(() => {
            if (this.value.length >= 2 || this.value.length === 0) {
                filterForm.submit();
            }
        }, 500);
    });
    
    // Add loading indicator when form is being submitted
    filterForm.addEventListener('submit', function() {
        // Add a subtle loading state to the form
        const submitButton = filterForm.querySelector('button[type="submit"]');
        if (submitButton) {
            submitButton.disabled = true;
            submitButton.innerHTML = 'Filtering...';
        }
    });
});
</script>
@endsection 
