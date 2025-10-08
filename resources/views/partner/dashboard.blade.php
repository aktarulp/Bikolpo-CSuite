@extends('layouts.partner-layout')

@section('title', 'Partner Dashboard')

@section('content')
<!-- Modern Dashboard with Glassmorphism -->
<div class="min-h-screen bg-gradient-to-br from-slate-50 via-blue-50 to-indigo-100 dark:from-gray-900 dark:via-slate-900 dark:to-gray-900">
    <div class="max-w-7xl mx-auto space-y-4 p-3 md:p-4">
        
        <!-- Error Display -->
        @if(isset($error))
        <div class="bg-red-500/10 backdrop-blur-xl border border-red-500/20 text-red-700 dark:text-red-300 px-6 py-4 rounded-2xl shadow-lg" role="alert">
            <div class="flex items-center space-x-3">
                <x-icon name="warning" class="w-6 h-6" />
                <div>
                    <strong class="font-bold">Error:</strong>
                    <span class="block sm:inline">{{ $error }}</span>
                </div>
            </div>
        </div>
        @endif

        <!-- Slim Header -->
        <div class="relative bg-white/80 dark:bg-gray-800/80 rounded-2xl shadow border border-gray-200/70 dark:border-gray-700/60 p-4">
            <div class="flex flex-col lg:flex-row items-start lg:items-center justify-between gap-4">
                <!-- Title Section -->
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-lg bg-emerald-600 flex items-center justify-center text-white">
                        <x-icon name="dashboard" class="w-5 h-5" />
                    </div>
                    <div>
                        <h1 class="text-2xl lg:text-3xl font-bold text-gray-900 dark:text-white">Dashboard</h1>
                        <p class="text-gray-600 dark:text-gray-400 text-sm">Welcome back! Here's your overview</p>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="flex items-center gap-2">
                    <button id="refreshStatsBtn"
                            class="inline-flex items-center gap-2 px-4 py-2 rounded-lg bg-gray-900 text-white dark:bg-gray-700 hover:bg-gray-800 dark:hover:bg-gray-600 transition-colors">
                        <x-icon name="refresh" class="w-4 h-4" />
                        <span class="text-sm font-medium">Refresh</span>
                    </button>
                    <a href="{{ route('partner.exams.create') }}"
                       class="inline-flex items-center gap-2 px-4 py-2 rounded-lg border border-orange-300/60 text-orange-700 dark:text-orange-300 hover:bg-orange-50 dark:hover:bg-orange-900/20 transition-colors">
                        <span class="text-sm font-semibold">+ Exam</span>
                    </a>
                </div>
            </div>
        </div>

        <!-- Statistics Cards Grid -->
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-4">
            <!-- Questions Card -->
            <div class="group relative overflow-hidden bg-gradient-to-br from-blue-500 to-blue-600 dark:from-blue-600 dark:to-blue-700 rounded-2xl p-3 shadow-lg hover:shadow-xl transition-all duration-200 cursor-pointer" 
                 onclick="document.getElementById('questionBreakdownModal').classList.remove('hidden')">
                <div class="relative z-10">
                    <div class="flex items-center gap-2 mb-2">
                        <div class="w-8 h-8 bg-white/20 backdrop-blur-sm rounded-lg flex items-center justify-center shadow">
                            <x-icon name="warning" class="w-4 h-4 text-white" />
                        </div>
                        <p class="text-white/90 text-sm font-semibold">Questions</p>
                    </div>
                    <p class="text-2xl font-black text-white" data-stat="total_questions">{{ $stats['total_questions'] }}</p>
                </div>
            </div>

            <!-- Exams Card -->
            <div class="group relative overflow-hidden bg-gradient-to-br from-cyan-500 to-cyan-600 dark:from-cyan-600 dark:to-cyan-700 rounded-2xl p-3 shadow-lg hover:shadow-xl transition-all duration-200">
                <div class="relative z-10">
                    <div class="flex items-center gap-2 mb-2">
                        <div class="w-8 h-8 bg-white/20 backdrop-blur-sm rounded-lg flex items-center justify-center shadow">
                            <x-icon name="document" class="w-4 h-4 text-white" />
                        </div>
                        <p class="text-white/90 text-sm font-semibold">Exams</p>
                    </div>
                    <p class="text-2xl font-black text-white" data-stat="total_exams">{{ $stats['total_exams'] }}</p>
                </div>
            </div>

            <!-- Students Card -->
            <div class="group relative overflow-hidden bg-gradient-to-br from-emerald-500 to-emerald-600 dark:from-emerald-600 dark:to-emerald-700 rounded-2xl p-3 shadow-lg hover:shadow-xl transition-all duration-200">
                <div class="relative z-10">
                    <div class="flex items-center gap-2 mb-2">
                        <div class="w-8 h-8 bg-white/20 backdrop-blur-sm rounded-lg flex items-center justify-center shadow">
                            <svg class="w-4 h-4 text-white" viewBox="-40.61 0 538.137 538.137" xmlns="http://www.w3.org/2000/svg" fill="currentColor"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <g id="Group 13" data-name="Group 13" transform="translate(-1124.204 -2310.279)"> <path id="path206" d="M849.627-1498.45a45.108,45.108,0,0,0,25.4,17.053c1.012-14.893,1.995-30.133-1.967-44.547-1.484-5.387-4.047-11.04-9.067-13.493-4.157-2.04-9.327-1.373-13.26,1.067-5.633,3.507-10.064,10.32-9.553,16.933a45.154,45.154,0,0,0,8.445,22.987" transform="translate(490 4018.328)" fill="#fff"></path> <path id="path208" d="M836.869-1666.089s35.916-18.467,38.947-21.453,4.611-6.053,8.623-4.573,2.543,5.48,2.543,5.48,5.144-1.307,7.391,1.573-1.928,10.907-1.928,10.907,35.447-25.52,40.575-22.227c9.187,5.893-34.9,29.653-32.521,31.547,1.095.88,8.9-.787,17.139-2.453,9.637-1.96,19.863-3.907,20.62-1.787,1.4,3.92-5.48,6.867-15.187,10.36s-34.685,12.32-46.212,16.747-24.688,9.267-24.688,9.267l-33.467,16.76-13.748-36.693,31.915-13.453" transform="translate(490 4018.328)" fill="#fff"></path> </g> </g></svg>
                        </div>
                        <p class="text-white/90 text-sm font-semibold">Students</p>
                    </div>
                    <p class="text-2xl font-black text-white" data-stat="total_students">{{ $stats['total_students'] }}</p>
                </div>
            </div>

            <!-- Courses Card -->
            <div class="group relative overflow-hidden bg-gradient-to-br from-orange-500 to-orange-600 dark:from-orange-600 dark:to-orange-700 rounded-2xl p-3 shadow-lg hover:shadow-xl transition-all duration-200">
                <div class="relative z-10">
                    <div class="flex items-center gap-2 mb-2">
                        <div class="w-8 h-8 bg-white/20 backdrop-blur-sm rounded-lg flex items-center justify-center shadow">
                            <x-icon name="book" class="w-4 h-4 text-white" />
                        </div>
                        <p class="text-white/90 text-sm font-semibold">Courses</p>
                    </div>
                    <p class="text-2xl font-black text-white" data-stat="total_courses">{{ $stats['total_courses'] }}</p>
                </div>
            </div>

            <!-- Batches Card -->
            <div class="group relative overflow-hidden bg-gradient-to-br from-indigo-500 to-indigo-600 dark:from-indigo-600 dark:to-indigo-700 rounded-2xl p-3 shadow-lg hover:shadow-xl transition-all duration-200">
                <div class="relative z-10">
                    <div class="flex items-center gap-2 mb-2">
                        <div class="w-8 h-8 bg-white/20 backdrop-blur-sm rounded-lg flex items-center justify-center shadow">
                            <x-icon name="batch" class="w-4 h-4 text-white" />
                        </div>
                        <p class="text-white/90 text-sm font-semibold">Batches</p>
                    </div>
                    <p class="text-2xl font-black text-white" data-stat="total_batches">{{ $stats['total_batches'] }}</p>
                </div>
            </div>
        </div>

        <!-- Info Banner - Only show if there's a discrepancy -->
        @php
            $totalQuestionsInDB = \App\Models\Question::where('partner_id', auth()->user()->partner->id ?? 0)->count();
            $validQuestions = $stats['total_questions'];
            $orphanedQuestions = $totalQuestionsInDB - $validQuestions;
        @endphp
        
        @if($orphanedQuestions > 0)
        <div class="bg-gradient-to-r from-amber-50 to-orange-50 dark:from-amber-900/20 dark:to-orange-900/20 border-l-4 border-amber-500 rounded-xl p-4 shadow-lg">
            <div class="flex items-start gap-3">
                <div class="flex-shrink-0">
                    <x-icon name="warning" class="w-6 h-6 text-amber-600 dark:text-amber-400" />
                </div>
                <div class="flex-1">
                    <h4 class="text-amber-900 dark:text-amber-300 font-bold text-lg mb-1">
                        {{ $orphanedQuestions }} Question{{ $orphanedQuestions > 1 ? 's' : '' }} Need Attention
                    </h4>
                    <p class="text-amber-800 dark:text-amber-400 text-sm mb-2">
                        You have <strong>{{ $totalQuestionsInDB }} total questions</strong> in the database, but only <strong>{{ $validQuestions }} are properly linked to your courses</strong>. 
                        Questions without valid course links won't appear in the questions list or be available for exams.
                    </p>
                    <div class="flex gap-2 mt-3">
                        <a href="{{ route('partner.questions.index') }}" class="inline-flex items-center gap-2 bg-amber-600 hover:bg-amber-700 text-white px-4 py-2 rounded-lg font-semibold text-sm transition-colors shadow-md">
                            <x-icon name="eye" class="w-4 h-4" />
                            View Questions
                        </a>
                        <button onclick="alert('To fix: Edit each question and assign it to a course that belongs to you.')" class="inline-flex items-center gap-2 bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700 text-amber-700 dark:text-amber-400 px-4 py-2 rounded-lg font-semibold text-sm transition-colors border border-amber-300 dark:border-amber-700">
                            <x-icon name="info" class="w-4 h-4" />
                            How to Fix
                        </button>
                    </div>
                </div>
            </div>
        </div>
        @endif

        <!-- Analytics & Quick Actions Row -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Question Analytics - Spans 2 columns -->
            <div class="lg:col-span-2 relative overflow-hidden bg-white/70 dark:bg-gray-800/70 backdrop-blur-2xl rounded-3xl shadow-2xl border border-white/20 dark:border-gray-700/50 p-6">
                <div class="absolute top-0 right-0 w-64 h-64 bg-gradient-to-br from-purple-500/10 to-pink-500/10 rounded-full blur-3xl"></div>
                
                <div class="relative z-10">
                    <div class="flex items-center space-x-4 mb-6">
                        <div class="p-3 rounded-2xl bg-gradient-to-br from-purple-500 to-pink-500 shadow-lg">
                            <x-icon name="dashboard" class="w-8 h-8 text-white" />
                        </div>
                        <div>
                            <h3 class="text-2xl font-bold text-gray-900 dark:text-white">Question Analytics</h3>
                            <p class="text-gray-600 dark:text-gray-400 text-sm">Performance insights at a glance</p>
                        </div>
                    </div>
                    
                    <div class="grid grid-cols-3 gap-4 mb-6">
                        <div class="bg-gradient-to-br from-purple-50 to-purple-100 dark:from-purple-900/20 dark:to-purple-900/30 rounded-2xl p-4 border border-purple-200 dark:border-purple-700/50">
                            <p class="text-3xl font-black text-purple-600 dark:text-purple-400 mb-1">{{ number_format($stats['total_question_attempts']) }}</p>
                            <p class="text-xs font-semibold text-purple-700 dark:text-purple-300">Total Attempts</p>
                        </div>
                        <div class="bg-gradient-to-br from-green-50 to-green-100 dark:from-green-900/20 dark:to-green-900/30 rounded-2xl p-4 border border-green-200 dark:border-green-700/50">
                            <p class="text-3xl font-black text-green-600 dark:text-green-400 mb-1">{{ number_format($stats['total_correct_answers']) }}</p>
                            <p class="text-xs font-semibold text-green-700 dark:text-green-300">Correct Answers</p>
                        </div>
                        <div class="bg-gradient-to-br from-blue-50 to-blue-100 dark:from-blue-900/20 dark:to-blue-900/30 rounded-2xl p-4 border border-blue-200 dark:border-blue-700/50">
                            <p class="text-3xl font-black text-blue-600 dark:text-blue-400 mb-1">{{ $stats['overall_accuracy'] }}%</p>
                            <p class="text-xs font-semibold text-blue-700 dark:text-blue-300">Accuracy Rate</p>
                        </div>
                    </div>
                    
                    <div class="flex flex-wrap gap-3">
                        <a href="{{ route('analytics.questions.index') }}" 
                           class="group relative overflow-hidden bg-gradient-to-r from-purple-600 to-pink-600 hover:from-pink-600 hover:to-purple-600 text-white px-5 py-2.5 rounded-xl transition-all duration-300 shadow-lg hover:shadow-xl font-semibold flex items-center space-x-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                            </svg>
                            <span>View Analytics</span>
                        </a>
                        <a href="{{ route('partner.questions.index') }}" 
                           class="bg-white/80 dark:bg-gray-700/80 hover:bg-white dark:hover:bg-gray-700 text-purple-600 dark:text-purple-400 border-2 border-purple-200 dark:border-purple-700 px-5 py-2.5 rounded-xl transition-all duration-300 shadow-lg hover:shadow-xl font-semibold flex items-center space-x-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <span>Manage Questions</span>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="relative overflow-hidden bg-white/70 dark:bg-gray-800/70 backdrop-blur-2xl rounded-3xl shadow-2xl border border-white/20 dark:border-gray-700/50 p-6">
                <div class="absolute top-0 right-0 w-48 h-48 bg-gradient-to-br from-blue-500/10 to-indigo-500/10 rounded-full blur-3xl"></div>
                
                <div class="relative z-10">
                    <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-4 flex items-center space-x-2">
                        <svg class="w-6 h-6 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                        </svg>
                        <span>Quick Actions</span>
                    </h3>
                    
                    <div class="space-y-3">
                        <a href="{{ route('partner.questions.mcq.create') }}" 
                           class="group flex items-center p-4 bg-gradient-to-r from-blue-50 to-blue-100 dark:from-blue-900/20 dark:to-blue-900/30 rounded-xl hover:shadow-lg transition-all duration-300 border border-blue-200 dark:border-blue-700/50">
                            <div class="w-10 h-10 bg-blue-600 rounded-xl flex items-center justify-center mr-3 group-hover:scale-110 transition-transform duration-300">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                </svg>
                            </div>
                            <div>
                                <h4 class="font-bold text-gray-900 dark:text-white">Add Question</h4>
                                <p class="text-xs text-gray-600 dark:text-gray-400">Create MCQ</p>
                            </div>
                        </a>

                        <a href="{{ route('partner.exams.create') }}" 
                           class="group flex items-center p-4 bg-gradient-to-r from-orange-50 to-orange-100 dark:from-orange-900/20 dark:to-orange-900/30 rounded-xl hover:shadow-lg transition-all duration-300 border border-orange-200 dark:border-orange-700/50">
                            <div class="w-10 h-10 bg-orange-600 rounded-xl flex items-center justify-center mr-3 group-hover:scale-110 transition-transform duration-300">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                                </svg>
                            </div>
                            <div>
                                <h4 class="font-bold text-gray-900 dark:text-white">Schedule Exam</h4>
                                <p class="text-xs text-gray-600 dark:text-gray-400">Create new exam</p>
                            </div>
                        </a>

                        <a href="{{ route('analytics.questions.index') }}" 
                           class="group flex items-center p-4 bg-gradient-to-r from-purple-50 to-purple-100 dark:from-purple-900/20 dark:to-purple-900/30 rounded-xl hover:shadow-lg transition-all duration-300 border border-purple-200 dark:border-purple-700/50">
                            <div class="w-10 h-10 bg-purple-600 rounded-xl flex items-center justify-center mr-3 group-hover:scale-110 transition-transform duration-300">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                                </svg>
                            </div>
                            <div>
                                <h4 class="font-bold text-gray-900 dark:text-white">Analytics</h4>
                                <p class="text-xs text-gray-600 dark:text-gray-400">View insights</p>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Demo Data Seeding -->
        @if($stats['total_students'] == 0)
        <div class="relative overflow-hidden bg-gradient-to-r from-blue-500/10 to-indigo-500/10 backdrop-blur-xl rounded-3xl shadow-xl border border-blue-200/50 dark:border-blue-700/50 p-6">
            <div class="flex flex-col md:flex-row items-center justify-between gap-4">
                <div class="flex items-center space-x-4">
                    <div class="w-12 h-12 bg-blue-600 rounded-2xl flex items-center justify-center shadow-lg">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-lg font-bold text-blue-900 dark:text-blue-100">Get Started with Demo Data</h3>
                        <p class="text-blue-700 dark:text-blue-300 text-sm">No students found. Create demo students for testing.</p>
                    </div>
                </div>
                <div class="flex flex-wrap gap-3">
                    <button id="seedDemoStudentsBtn" 
                            class="bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-indigo-600 hover:to-blue-600 text-white px-6 py-3 rounded-xl transition-all duration-300 shadow-lg hover:shadow-xl font-semibold flex items-center space-x-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                        </svg>
                        <span>Create Demo Students</span>
                    </button>
                </div>
            </div>
            <div id="seedingStatus" class="mt-4 hidden">
                <div class="flex items-center space-x-2 text-blue-700 dark:text-blue-300">
                    <svg class="animate-spin w-5 h-5" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    <span id="seedingMessage">Creating demo students...</span>
                </div>
            </div>
        </div>
        @endif

        <!-- Recent Activities -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Recent Exams -->
            <div class="relative overflow-hidden bg-white/70 dark:bg-gray-800/70 backdrop-blur-2xl rounded-3xl shadow-2xl border border-white/20 dark:border-gray-700/50">
                <div class="p-6 border-b border-gray-200/50 dark:border-gray-700/50 bg-gradient-to-r from-blue-50/50 to-indigo-50/50 dark:from-blue-900/10 dark:to-indigo-900/10">
                    <h3 class="text-xl font-bold text-gray-900 dark:text-white flex items-center space-x-2">
                        <svg class="w-6 h-6 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        <span>Recent Exams</span>
                    </h3>
                </div>
                <div class="p-6">
                    @if($recent_exams->count() > 0)
                        <div class="space-y-3">
                            @foreach($recent_exams as $exam)
                                <div class="flex items-center justify-between p-4 bg-gradient-to-r from-gray-50 to-gray-100 dark:from-gray-700/50 dark:to-gray-700/30 rounded-xl hover:shadow-md transition-all duration-300 border border-gray-200/50 dark:border-gray-600/50">
                                    <div>
                                        <h4 class="font-bold text-gray-900 dark:text-white">{{ $exam->title }}</h4>
                                        <p class="text-sm text-gray-600 dark:text-gray-400">
                                            ID: {{ $exam->id }} • {{ $exam->status }}
                                        </p>
                                    </div>
                                    <div class="text-right">
                                        <p class="text-sm text-gray-600 dark:text-gray-400 mb-1">
                                            {{ $exam->start_time->format('M d, Y') }}
                                        </p>
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold
                                            @if($exam->status === 'published') bg-green-500 text-white
                                            @elseif($exam->status === 'draft') bg-gray-500 text-white
                                            @else bg-yellow-500 text-white @endif">
                                            {{ ucfirst($exam->status) }}
                                        </span>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-12">
                            <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                            <p class="text-gray-500 dark:text-gray-400 font-medium">No recent exams</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Recent Results -->
            <div class="relative overflow-hidden bg-white/70 dark:bg-gray-800/70 backdrop-blur-2xl rounded-3xl shadow-2xl border border-white/20 dark:border-gray-700/50">
                <div class="p-6 border-b border-gray-200/50 dark:border-gray-700/50 bg-gradient-to-r from-green-50/50 to-emerald-50/50 dark:from-green-900/10 dark:to-emerald-900/10">
                    <h3 class="text-xl font-bold text-gray-900 dark:text-white flex items-center space-x-2">
                        <svg class="w-6 h-6 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <span>Recent Results</span>
                    </h3>
                </div>
                <div class="p-6">
                    @if($recent_results->count() > 0)
                        <div class="space-y-3">
                            @foreach($recent_results as $result)
                                <div class="flex items-center justify-between p-4 bg-gradient-to-r from-gray-50 to-gray-100 dark:from-gray-700/50 dark:to-gray-700/30 rounded-xl hover:shadow-md transition-all duration-300 border border-gray-200/50 dark:border-gray-600/50">
                                    <div>
                                        <h4 class="font-bold text-gray-900 dark:text-white">{{ $result->student->full_name }}</h4>
                                        <p class="text-sm text-gray-600 dark:text-gray-400">{{ $result->exam->title }}</p>
                                    </div>
                                    <div class="text-right">
                                        <p class="text-2xl font-black text-gray-900 dark:text-white mb-1">
                                            {{ number_format($result->percentage, 1) }}%
                                        </p>
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold
                                            @if($result->percentage >= 80) bg-green-500 text-white
                                            @elseif($result->percentage >= 60) bg-yellow-500 text-white
                                            @else bg-red-500 text-white @endif">
                                            {{ $result->grade }}
                                        </span>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-12">
                            <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <p class="text-gray-500 dark:text-gray-400 font-medium">No recent results</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Question Breakdown Modal -->
<div id="questionBreakdownModal" class="hidden fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
        <!-- Background overlay -->
        <div class="fixed inset-0 bg-gray-900/75 backdrop-blur-sm transition-opacity" aria-hidden="true" onclick="document.getElementById('questionBreakdownModal').classList.add('hidden')"></div>

        <!-- Modal panel -->
        <div class="inline-block align-bottom bg-white dark:bg-gray-800 rounded-2xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
            <div class="bg-gradient-to-br from-blue-500 to-blue-600 px-6 py-4">
                <div class="flex items-center justify-between">
                    <h3 class="text-2xl font-bold text-white flex items-center gap-2">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                        </svg>
                        Question Breakdown
                    </h3>
                    <button onclick="document.getElementById('questionBreakdownModal').classList.add('hidden')" class="text-white/80 hover:text-white transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
            </div>
            
            <div class="bg-white dark:bg-gray-800 px-6 py-6">
                <div class="space-y-4">
                    <!-- Total Questions -->
                    <div class="bg-gradient-to-r from-blue-50 to-indigo-50 dark:from-blue-900/20 dark:to-indigo-900/20 rounded-xl p-4 border border-blue-200 dark:border-blue-700">
                        <div class="flex items-center justify-between">
                            <span class="text-gray-700 dark:text-gray-300 font-semibold">Valid Questions</span>
                            <span class="text-2xl font-black text-blue-600 dark:text-blue-400">{{ $stats['total_questions'] }}</span>
                        </div>
                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Questions properly linked to your courses</p>
                    </div>

                    @if($orphanedQuestions > 0)
                    <!-- Orphaned Questions Warning -->
                    <div class="bg-gradient-to-r from-amber-50 to-orange-50 dark:from-amber-900/20 dark:to-orange-900/20 rounded-xl p-4 border border-amber-300 dark:border-amber-700">
                        <div class="flex items-center justify-between mb-2">
                            <span class="text-gray-700 dark:text-gray-300 font-semibold flex items-center gap-2">
                                <svg class="w-4 h-4 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                                </svg>
                                Orphaned Questions
                            </span>
                            <span class="text-2xl font-black text-amber-600 dark:text-amber-400">{{ $orphanedQuestions }}</span>
                        </div>
                        <p class="text-xs text-amber-700 dark:text-amber-400">Not linked to your courses - won't appear in lists</p>
                    </div>
                    @endif

                    <!-- MCQ Questions -->
                    <div class="bg-gradient-to-r from-green-50 to-emerald-50 dark:from-green-900/20 dark:to-emerald-900/20 rounded-xl p-4 border border-green-200 dark:border-green-700">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-2">
                                <div class="w-3 h-3 bg-green-500 rounded-full"></div>
                                <span class="text-gray-700 dark:text-gray-300 font-medium">MCQ Questions</span>
                            </div>
                            <span class="text-xl font-bold text-green-600 dark:text-green-400">{{ $stats['mcq_questions'] }}</span>
                        </div>
                    </div>

                    <!-- Descriptive Questions -->
                    <div class="bg-gradient-to-r from-purple-50 to-pink-50 dark:from-purple-900/20 dark:to-pink-900/20 rounded-xl p-4 border border-purple-200 dark:border-purple-700">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-2">
                                <div class="w-3 h-3 bg-purple-500 rounded-full"></div>
                                <span class="text-gray-700 dark:text-gray-300 font-medium">Descriptive Questions</span>
                            </div>
                            <span class="text-xl font-bold text-purple-600 dark:text-purple-400">{{ $stats['descriptive_questions'] }}</span>
                        </div>
                    </div>

                    <!-- True/False Questions -->
                    <div class="bg-gradient-to-r from-orange-50 to-amber-50 dark:from-orange-900/20 dark:to-amber-900/20 rounded-xl p-4 border border-orange-200 dark:border-orange-700">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-2">
                                <div class="w-3 h-3 bg-orange-500 rounded-full"></div>
                                <span class="text-gray-700 dark:text-gray-300 font-medium">True/False Questions</span>
                            </div>
                            <span class="text-xl font-bold text-orange-600 dark:text-orange-400">{{ $stats['true_false_questions'] }}</span>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="mt-6 flex gap-3">
                    <a href="{{ route('partner.questions.index') }}" class="flex-1 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white px-4 py-3 rounded-xl font-semibold text-center transition-all duration-300 shadow-lg hover:shadow-xl">
                        View All Questions
                    </a>
                    <button onclick="document.getElementById('questionBreakdownModal').classList.add('hidden')" class="px-6 py-3 bg-gray-200 dark:bg-gray-700 hover:bg-gray-300 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-300 rounded-xl font-semibold transition-colors">
                        Close
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const seedBtn = document.getElementById('seedDemoStudentsBtn');
    const seedingStatus = document.getElementById('seedingStatus');
    const seedingMessage = document.getElementById('seedingMessage');
    const refreshStatsBtn = document.getElementById('refreshStatsBtn');
    
    if (seedBtn) {
        seedBtn.addEventListener('click', async function() {
            try {
                seedBtn.disabled = true;
                seedBtn.innerHTML = `
                    <svg class="animate-spin w-5 h-5" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    <span>Creating...</span>
                `;
                
                seedingStatus.classList.remove('hidden');
                seedingMessage.textContent = 'Creating demo students...';
                
                const response = await fetch('{{ route("partner.seed-demo-students") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                });
                
                const result = await response.json();
                
                if (result.success) {
                    seedingMessage.textContent = result.message;
                    seedBtn.innerHTML = `
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        <span>Success!</span>
                    `;
                    
                    setTimeout(() => {
                        window.location.reload();
                    }, 2000);
                } else {
                    throw new Error(result.message);
                }
                
            } catch (error) {
                console.error('Error seeding demo students:', error);
                seedingMessage.textContent = 'Error: ' + error.message;
                seedBtn.innerHTML = `
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                    <span>Try Again</span>
                `;
                seedBtn.disabled = false;
            }
        });
    }
    
    
    if (refreshStatsBtn) {
        refreshStatsBtn.addEventListener('click', async function() {
            try {
                refreshStatsBtn.disabled = true;
                refreshStatsBtn.innerHTML = `
                    <svg class="animate-spin w-4 h-4" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    <span>Refreshing...</span>
                `;
                
                const response = await fetch('{{ route("partner.refresh-stats") }}', {
                    method: 'GET',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                });
                
                const result = await response.json();
                
                if (result.success) {
                    const totalQuestionsElement = document.querySelector('[data-stat="total_questions"]');
                    const totalExamsElement = document.querySelector('[data-stat="total_exams"]');
                    const totalStudentsElement = document.querySelector('[data-stat="total_students"]');
                    const totalCoursesElement = document.querySelector('[data-stat="total_courses"]');
                    const totalBatchesElement = document.querySelector('[data-stat="total_batches"]');
                    
                    if (totalQuestionsElement) totalQuestionsElement.textContent = result.stats.total_questions;
                    if (totalExamsElement) totalExamsElement.textContent = result.stats.total_exams;
                    if (totalStudentsElement) totalStudentsElement.textContent = result.stats.total_students;
                    if (totalCoursesElement) totalCoursesElement.textContent = result.stats.total_courses;
                    if (totalBatchesElement) totalBatchesElement.textContent = result.stats.total_batches;
                    
                    refreshStatsBtn.innerHTML = `
                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        <span>Refreshed!</span>
                    `;
                    
                    setTimeout(() => {
                        refreshStatsBtn.innerHTML = `
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                            </svg>
                            <span>Refresh</span>
                        `;
                        refreshStatsBtn.disabled = false;
                    }, 2000);
                } else {
                    throw new Error(result.message);
                }
                
            } catch (error) {
                console.error('Error refreshing stats:', error);
                refreshStatsBtn.innerHTML = `
                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                    <span>Error</span>
                `;
                
                setTimeout(() => {
                    refreshStatsBtn.innerHTML = `
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                        </svg>
                        <span>Refresh</span>
                    `;
                    refreshStatsBtn.disabled = false;
                }, 3000);
            }
        });
    }
});
</script>
@endpush

@endsection
