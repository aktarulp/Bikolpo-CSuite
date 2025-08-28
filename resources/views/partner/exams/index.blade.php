@extends('layouts.partner-layout')

@section('title', 'Exams')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100 dark:from-gray-900 dark:to-gray-800 p-4">
    <div class="max-w-7xl mx-auto space-y-3">
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
        <div class="grid grid-cols-2 md:grid-cols-4 gap-3">
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
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 0 11-18 0 9 9 0 0118 0z"></path>
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
                                <th class="px-3 py-3 text-left text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider w-32">
                                    <div class="flex items-center gap-2">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        </svg>
                                        <span>Configure</span>
                                    </div>
                                </th>
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
                                        <a href="{{ route('partner.exams.show', $exam) }}" 
                                           class="inline-flex items-center justify-center px-3 py-2 rounded-lg text-xs font-medium bg-blue-50 dark:bg-blue-900/30 text-blue-700 dark:text-blue-300 hover:bg-blue-100 dark:hover:bg-blue-900/50 transition-all duration-200 border border-blue-200 dark:border-blue-700">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            </svg>
                                        </a>
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
