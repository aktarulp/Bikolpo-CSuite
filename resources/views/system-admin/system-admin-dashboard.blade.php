@extends('system-admin.system-admin-layout')

@section('title', 'System Admin Dashboard')

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
                        <h1 class="text-2xl lg:text-3xl font-bold text-gray-900 dark:text-white">System Admin Dashboard</h1>
                        <p class="text-gray-600 dark:text-gray-400 text-sm">System overview and management</p>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="flex items-center gap-2">
                    <button id="refreshStatsBtn"
                            class="inline-flex items-center gap-2 px-4 py-2 rounded-lg bg-gray-900 text-white dark:bg-gray-700 hover:bg-gray-800 dark:hover:bg-gray-600 transition-colors">
                        <x-icon name="refresh" class="w-4 h-4" />
                        <span class="text-sm font-medium">Refresh</span>
                    </button>
                    <button onclick="alert('System administrators can manage exams through the admin panel.')"
                       class="inline-flex items-center gap-2 px-4 py-2 rounded-lg border border-orange-300/60 text-orange-700 dark:text-orange-300 hover:bg-orange-50 dark:hover:bg-orange-900/20 transition-colors">
                        <span class="text-sm font-semibold">+ Exam</span>
                    </button>
                </div>
            </div>
        </div>

        <!-- Platform Overview Cards -->
        <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-8 gap-3">
            <!-- Total Users Card -->
            <div class="group relative overflow-hidden bg-gradient-to-br from-blue-500 to-blue-600 dark:from-blue-600 dark:to-blue-700 rounded-lg p-3 shadow-sm hover:shadow-md transition-all duration-200">
                <div class="relative z-10 flex items-center">
                    <!-- Side Icon -->
                    <div class="w-12 h-12 bg-white/20 backdrop-blur-sm rounded-lg flex items-center justify-center shadow-lg mr-3 flex-shrink-0">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                        </svg>
                    </div>
                    <!-- Content -->
                    <div class="flex-1 min-w-0">
                        <div class="flex items-center justify-between mb-1">
                            <h3 class="text-white/90 text-xs font-semibold">📊 Users</h3>
                            <p class="text-white/80 text-xs">+12.5%</p>
                        </div>
                        <p class="text-xl font-black text-white mb-1">{{ $stats['total_students'] + $stats['total_partners'] + 1 }}</p>
                        <p class="text-white/70 text-xs">Total</p>
                    </div>
                </div>
            </div>

            <!-- Active Students Card -->
            <div class="group relative overflow-hidden bg-gradient-to-br from-emerald-500 to-emerald-600 dark:from-emerald-600 dark:to-emerald-700 rounded-lg p-3 shadow-sm hover:shadow-md transition-all duration-200">
                <div class="relative z-10 flex items-center">
                    <!-- Side Icon -->
                    <div class="w-12 h-12 bg-white/20 backdrop-blur-sm rounded-lg flex items-center justify-center shadow-lg mr-3 flex-shrink-0">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                    </div>
                    <!-- Content -->
                    <div class="flex-1 min-w-0">
                        <div class="flex items-center justify-between mb-1">
                            <h3 class="text-white/90 text-xs font-semibold">🧑‍🎓 Students</h3>
                            <p class="text-white/80 text-xs">{{ $stats['active_students_today'] ?? 0 }}</p>
                        </div>
                        <p class="text-xl font-black text-white mb-1">{{ $stats['total_students'] }}</p>
                        <p class="text-white/70 text-xs">Active</p>
                    </div>
                </div>
            </div>

            <!-- Active Partners Card -->
            <div class="group relative overflow-hidden bg-gradient-to-br from-purple-500 to-purple-600 dark:from-purple-600 dark:to-purple-700 rounded-lg p-3 shadow-sm hover:shadow-md transition-all duration-200">
                <div class="relative z-10 flex items-center">
                    <!-- Side Icon -->
                    <div class="w-12 h-12 bg-white/20 backdrop-blur-sm rounded-lg flex items-center justify-center shadow-lg mr-3 flex-shrink-0">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                        </svg>
                    </div>
                    <!-- Content -->
                    <div class="flex-1 min-w-0">
                        <div class="flex items-center justify-between mb-1">
                            <h3 class="text-white/90 text-xs font-semibold">🏫 Partners</h3>
                            <p class="text-white/80 text-xs">{{ $stats['active_partners_today'] ?? 0 }}</p>
                        </div>
                        <p class="text-xl font-black text-white mb-1">{{ $stats['total_partners'] }}</p>
                        <p class="text-white/70 text-xs">Centers</p>
                    </div>
                </div>
            </div>

            <!-- MCQ Sets Card -->
            <div class="group relative overflow-hidden bg-gradient-to-br from-orange-500 to-orange-600 dark:from-orange-600 dark:to-orange-700 rounded-lg p-3 shadow-sm hover:shadow-md transition-all duration-200">
                <div class="relative z-10 flex items-center">
                    <!-- Side Icon -->
                    <div class="w-12 h-12 bg-white/20 backdrop-blur-sm rounded-lg flex items-center justify-center shadow-lg mr-3 flex-shrink-0">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                    </div>
                    <!-- Content -->
                    <div class="flex-1 min-w-0">
                        <div class="flex items-center justify-between mb-1">
                            <h3 class="text-white/90 text-xs font-semibold">🧠 MCQ</h3>
                            <p class="text-white/80 text-xs">{{ $stats['total_exams'] }}</p>
                        </div>
                        <p class="text-xl font-black text-white mb-1">{{ $stats['total_questions'] }}</p>
                        <p class="text-white/70 text-xs">Questions</p>
                    </div>
                </div>
            </div>

            <!-- Ongoing Tests Card -->
            <div class="group relative overflow-hidden bg-gradient-to-br from-cyan-500 to-cyan-600 dark:from-cyan-600 dark:to-cyan-700 rounded-lg p-3 shadow-sm hover:shadow-md transition-all duration-200">
                <div class="relative z-10 flex items-center">
                    <!-- Side Icon -->
                    <div class="w-12 h-12 bg-white/20 backdrop-blur-sm rounded-lg flex items-center justify-center shadow-lg mr-3 flex-shrink-0">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <!-- Content -->
                    <div class="flex-1 min-w-0">
                        <div class="flex items-center justify-between mb-1">
                            <h3 class="text-white/90 text-xs font-semibold">🕒 Tests</h3>
                            <p class="text-white/80 text-xs">{{ $stats['ongoing_tests'] ?? 0 }}</p>
                        </div>
                        <p class="text-xl font-black text-white mb-1">{{ $stats['total_ongoing_tests'] ?? 0 }}</p>
                        <p class="text-white/70 text-xs">Live</p>
                    </div>
                </div>
            </div>

            <!-- Total Earnings Card -->
            <div class="group relative overflow-hidden bg-gradient-to-br from-green-500 to-green-600 dark:from-green-600 dark:to-green-700 rounded-lg p-3 shadow-sm hover:shadow-md transition-all duration-200">
                <div class="relative z-10 flex items-center">
                    <!-- Side Icon -->
                    <div class="w-12 h-12 bg-white/20 backdrop-blur-sm rounded-lg flex items-center justify-center shadow-lg mr-3 flex-shrink-0">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                        </svg>
                    </div>
                    <!-- Content -->
                    <div class="flex-1 min-w-0">
                        <div class="flex items-center justify-between mb-1">
                            <h3 class="text-white/90 text-xs font-semibold">💰 Earnings</h3>
                            <p class="text-white/80 text-xs">${{ number_format($stats['earnings_today'] ?? 0) }}</p>
                        </div>
                        <p class="text-xl font-black text-white mb-1">${{ number_format($stats['total_earnings'] ?? 0) }}</p>
                        <p class="text-white/70 text-xs">Total</p>
                    </div>
                </div>
            </div>

            <!-- Pending Payments Card -->
            <div class="group relative overflow-hidden bg-gradient-to-br from-red-500 to-red-600 dark:from-red-600 dark:to-red-700 rounded-lg p-3 shadow-sm hover:shadow-md transition-all duration-200">
                <div class="relative z-10 flex items-center">
                    <!-- Side Icon -->
                    <div class="w-12 h-12 bg-white/20 backdrop-blur-sm rounded-lg flex items-center justify-center shadow-lg mr-3 flex-shrink-0">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <!-- Content -->
                    <div class="flex-1 min-w-0">
                        <div class="flex items-center justify-between mb-1">
                            <h3 class="text-white/90 text-xs font-semibold">🧾 Pending</h3>
                            <p class="text-white/80 text-xs">{{ $stats['pending_payments_count'] ?? 0 }}</p>
                        </div>
                        <p class="text-xl font-black text-white mb-1">${{ number_format($stats['pending_payments_amount'] ?? 0) }}</p>
                        <p class="text-white/70 text-xs">Payments</p>
                    </div>
                </div>
            </div>

            <!-- System Status Card -->
            <div class="group relative overflow-hidden bg-gradient-to-br from-indigo-500 to-indigo-600 dark:from-indigo-600 dark:to-indigo-700 rounded-lg p-3 shadow-sm hover:shadow-md transition-all duration-200">
                <div class="relative z-10 flex items-center">
                    <!-- Side Icon -->
                    <div class="w-12 h-12 bg-white/20 backdrop-blur-sm rounded-lg flex items-center justify-center shadow-lg mr-3 flex-shrink-0">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                        </svg>
                    </div>
                    <!-- Content -->
                    <div class="flex-1 min-w-0">
                        <div class="flex items-center justify-between mb-1">
                            <h3 class="text-white/90 text-xs font-semibold">⚡ System</h3>
                            <p class="text-green-300 text-xs font-bold">✓ All Good</p>
                        </div>
                        <p class="text-xl font-black text-white mb-1">Online</p>
                        <p class="text-white/70 text-xs">Status</p>
                    </div>
                </div>
            </div>
        </div>


        <!-- Charts Section -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Engagement Trends Chart -->
            <div class="relative overflow-hidden bg-white/70 dark:bg-gray-800/70 backdrop-blur-2xl rounded-3xl shadow-2xl border border-white/20 dark:border-gray-700/50 p-6">
                <div class="absolute top-0 right-0 w-64 h-64 bg-gradient-to-br from-blue-500/10 to-purple-500/10 rounded-full blur-3xl"></div>
                
                <div class="relative z-10">
                    <div class="flex items-center space-x-4 mb-6">
                        <div class="p-3 rounded-2xl bg-gradient-to-br from-blue-500 to-purple-500 shadow-lg">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-2xl font-bold text-gray-900 dark:text-white">📈 Engagement Trends</h3>
                            <p class="text-gray-600 dark:text-gray-400 text-sm">User activity over the last 7 days</p>
                        </div>
                    </div>
                    
                    <div class="h-64">
                        <canvas id="engagementChart"></canvas>
                    </div>
                </div>
            </div>

            <!-- Revenue Overview Chart -->
            <div class="relative overflow-hidden bg-white/70 dark:bg-gray-800/70 backdrop-blur-2xl rounded-3xl shadow-2xl border border-white/20 dark:border-gray-700/50 p-6">
                <div class="absolute top-0 right-0 w-64 h-64 bg-gradient-to-br from-green-500/10 to-emerald-500/10 rounded-full blur-3xl"></div>
                
                <div class="relative z-10">
                    <div class="flex items-center space-x-4 mb-6">
                        <div class="p-3 rounded-2xl bg-gradient-to-br from-green-500 to-emerald-500 shadow-lg">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-2xl font-bold text-gray-900 dark:text-white">💰 Revenue Overview</h3>
                            <p class="text-gray-600 dark:text-gray-400 text-sm">Earnings breakdown by source</p>
                        </div>
                    </div>
                    
                    <div class="h-64">
                        <canvas id="revenueChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

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
                        <button onclick="alert('System administrators can access analytics through the admin panel.')" 
                           class="group relative overflow-hidden bg-gradient-to-r from-purple-600 to-pink-600 hover:from-pink-600 hover:to-purple-600 text-white px-5 py-2.5 rounded-xl transition-all duration-300 shadow-lg hover:shadow-xl font-semibold flex items-center space-x-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                            </svg>
                            <span>View Analytics</span>
                        </button>
                        <button onclick="alert('System administrators can manage all questions through the admin panel.')" 
                           class="bg-white/80 dark:bg-gray-700/80 hover:bg-white dark:hover:bg-gray-700 text-purple-600 dark:text-purple-400 border-2 border-purple-200 dark:border-purple-700 px-5 py-2.5 rounded-xl transition-all duration-300 shadow-lg hover:shadow-xl font-semibold flex items-center space-x-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <span>Manage Questions</span>
                        </button>
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
                        <button onclick="alert('System administrators can manage all questions through the admin panel.')" 
                           class="group flex items-center p-4 bg-gradient-to-r from-blue-50 to-blue-100 dark:from-blue-900/20 dark:to-blue-900/30 rounded-xl hover:shadow-lg transition-all duration-300 border border-blue-200 dark:border-blue-700/50">
                            <div class="w-10 h-10 bg-blue-600 rounded-xl flex items-center justify-center mr-3 group-hover:scale-110 transition-transform duration-300">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                </svg>
                            </div>
                            <div>
                                <h4 class="font-bold text-gray-900 dark:text-white">Manage Questions</h4>
                                <p class="text-xs text-gray-600 dark:text-gray-400">System-wide question management</p>
                            </div>
                        </button>

                        <button onclick="alert('System administrators can manage all exams through the admin panel.')" 
                           class="group flex items-center p-4 bg-gradient-to-r from-orange-50 to-orange-100 dark:from-orange-900/20 dark:to-orange-900/30 rounded-xl hover:shadow-lg transition-all duration-300 border border-orange-200 dark:border-orange-700/50">
                            <div class="w-10 h-10 bg-orange-600 rounded-xl flex items-center justify-center mr-3 group-hover:scale-110 transition-transform duration-300">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                                </svg>
                            </div>
                            <div>
                                <h4 class="font-bold text-gray-900 dark:text-white">Manage Exams</h4>
                                <p class="text-xs text-gray-600 dark:text-gray-400">System-wide exam management</p>
                            </div>
                        </button>

                        <button onclick="alert('System administrators can access comprehensive analytics through the admin panel.')" 
                           class="group flex items-center p-4 bg-gradient-to-r from-purple-50 to-purple-100 dark:from-purple-900/20 dark:to-purple-900/30 rounded-xl hover:shadow-lg transition-all duration-300 border border-purple-200 dark:border-purple-700/50">
                            <div class="w-10 h-10 bg-purple-600 rounded-xl flex items-center justify-center mr-3 group-hover:scale-110 transition-transform duration-300">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                                </svg>
                            </div>
                            <div>
                                <h4 class="font-bold text-gray-900 dark:text-white">System Analytics</h4>
                                <p class="text-xs text-gray-600 dark:text-gray-400">Comprehensive system insights</p>
                            </div>
                        </button>
                    </div>
                </div>
            </div>
        </div>


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
                                        <h4 class="font-bold text-gray-900 dark:text-white">{{ $result->student->full_name ?? 'Unknown Student' }}</h4>
                                        <p class="text-sm text-gray-600 dark:text-gray-400">{{ $result->exam ? $result->exam->title : 'Unknown Exam' }}</p>
                                    </div>
                                    <div class="text-right">
                                        <p class="text-2xl font-black text-gray-900 dark:text-white mb-1">
                                            {{ number_format($result->percentage ?? 0, 1) }}%
                                        </p>
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold
                                            @if(($result->percentage ?? 0) >= 80) bg-green-500 text-white
                                            @elseif(($result->percentage ?? 0) >= 60) bg-yellow-500 text-white
                                            @else bg-red-500 text-white @endif">
                                            {{ $result->grade ?? 'N/A' }}
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
                    <button onclick="alert('System administrators can view and manage all questions through the admin panel.')" class="flex-1 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white px-4 py-3 rounded-xl font-semibold text-center transition-all duration-300 shadow-lg hover:shadow-xl">
                        View All Questions
                    </button>
                    <button onclick="document.getElementById('questionBreakdownModal').classList.add('hidden')" class="px-6 py-3 bg-gray-200 dark:bg-gray-700 hover:bg-gray-300 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-300 rounded-xl font-semibold transition-colors">
                        Close
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<!-- Chart.js CDN -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Engagement Trends Chart
    const engagementCtx = document.getElementById('engagementChart');
    if (engagementCtx) {
        new Chart(engagementCtx, {
            type: 'line',
            data: {
                labels: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
                datasets: [{
                    label: 'Active Users',
                    data: [120, 190, 300, 500, 200, 300, 450],
                    borderColor: 'rgb(59, 130, 246)',
                    backgroundColor: 'rgba(59, 130, 246, 0.1)',
                    tension: 0.4,
                    fill: true
                }, {
                    label: 'Test Attempts',
                    data: [80, 150, 200, 350, 120, 180, 280],
                    borderColor: 'rgb(16, 185, 129)',
                    backgroundColor: 'rgba(16, 185, 129, 0.1)',
                    tension: 0.4,
                    fill: true
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'top',
                        labels: {
                            color: window.matchMedia('(prefers-color-scheme: dark)').matches ? '#fff' : '#374151'
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: {
                            color: window.matchMedia('(prefers-color-scheme: dark)').matches ? '#374151' : '#e5e7eb'
                        },
                        ticks: {
                            color: window.matchMedia('(prefers-color-scheme: dark)').matches ? '#9ca3af' : '#6b7280'
                        }
                    },
                    x: {
                        grid: {
                            color: window.matchMedia('(prefers-color-scheme: dark)').matches ? '#374151' : '#e5e7eb'
                        },
                        ticks: {
                            color: window.matchMedia('(prefers-color-scheme: dark)').matches ? '#9ca3af' : '#6b7280'
                        }
                    }
                }
            }
        });
    }

    // Revenue Overview Chart
    const revenueCtx = document.getElementById('revenueChart');
    if (revenueCtx) {
        new Chart(revenueCtx, {
            type: 'doughnut',
            data: {
                labels: ['Student Subscriptions', 'Partner Fees', 'Exam Fees', 'Premium Features'],
                datasets: [{
                    data: [45, 25, 20, 10],
                    backgroundColor: [
                        'rgb(59, 130, 246)',
                        'rgb(16, 185, 129)',
                        'rgb(245, 158, 11)',
                        'rgb(239, 68, 68)'
                    ],
                    borderWidth: 0
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            color: window.matchMedia('(prefers-color-scheme: dark)').matches ? '#fff' : '#374151',
                            padding: 20,
                            usePointStyle: true
                        }
                    }
                }
            }
        });
    }
    
    // Refresh Stats Button
    const refreshStatsBtn = document.getElementById('refreshStatsBtn');
    
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
                
                const response = await fetch('{{ route("system-admin.user-stats") }}', {
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
