@extends('layouts.student-layout')

@section('title', 'My Profile')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100 dark:from-gray-900 dark:to-gray-800 py-8">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-8">
            <div>
                <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Student Profile</h1>
                <p class="text-gray-600 dark:text-gray-400 mt-1">Showcase your academic journey</p>
            </div>
            <a href="{{ route('student.dashboard') }}" 
               class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-gray-600 to-gray-700 hover:from-gray-700 hover:to-gray-800 text-white rounded-xl shadow-md hover:shadow-lg transition-all duration-300 transform hover:-translate-y-0.5">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Dashboard
            </a>
        </div>

        <!-- Main Profile Card -->
        <div class="bg-white dark:bg-gray-800 rounded-3xl shadow-xl overflow-hidden border border-gray-200 dark:border-gray-700 transition-all duration-300 hover:shadow-2xl">
            <!-- Profile Header with Gradient -->
            <div class="relative bg-gradient-to-r from-primaryGreen via-emerald-500 to-teal-500 p-8 text-white">
                <!-- Decorative Elements -->
                <div class="absolute top-0 right-0 w-32 h-32 bg-white/10 rounded-full -translate-y-16 translate-x-16"></div>
                <div class="absolute bottom-0 left-0 w-24 h-24 bg-white/10 rounded-full translate-y-12 -translate-x-12"></div>
                
                <div class="relative z-10 flex flex-col md:flex-row items-center gap-6">
                    <!-- Profile Image -->
                    <div class="relative">
                        <div class="w-28 h-28 rounded-2xl bg-white/20 p-1 backdrop-blur-sm">
                            <div class="w-full h-full rounded-xl bg-gradient-to-br from-white to-gray-100 flex items-center justify-center overflow-hidden shadow-lg">
                                @if($student->photo)
                                    <img src="{{ asset('storage/' . $student->photo) }}" alt="{{ $student->full_name }}" class="w-full h-full object-cover">
                                @else
                                    <span class="text-3xl font-bold text-gray-700">
                                        {{ strtoupper(substr($student->full_name, 0, 1)) }}
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="absolute bottom-2 right-2 w-8 h-8 bg-green-400 rounded-full border-4 border-white dark:border-gray-800 flex items-center justify-center">
                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                        </div>
                    </div>
                    
                    <!-- Profile Info -->
                    <div class="flex-1 text-center md:text-left">
                        <h2 class="text-3xl font-bold">{{ $student->full_name }}</h2>
                        <p class="text-white/90 mt-1 text-lg">{{ $student->course->name ?? 'Student' }}</p>
                        <p class="text-sm text-white/80 mt-2 flex items-center justify-center md:justify-start">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                            Student ID: {{ $student->student_id }}
                        </p>
                        
                        <!-- Tags -->
                        <div class="mt-4 flex flex-wrap gap-2 justify-center md:justify-start">
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-white/20 backdrop-blur-sm text-white">
                                {{ $student->batch->name ?? 'No Batch' }}
                            </span>
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-white/20 backdrop-blur-sm text-white">
                                {{ ucfirst($student->gender) }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Stats Section -->
            <div class="p-8">
                <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-6 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-primaryGreen" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                    </svg>
                    Academic Performance
                </h3>
                
                <!-- Stats Grid -->
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
                    <!-- Exams Taken -->
                    <div class="bg-gradient-to-br from-blue-50 to-blue-100 dark:from-blue-900/20 dark:to-blue-800/20 rounded-2xl p-5 border border-blue-200 dark:border-blue-800/30 shadow-sm hover:shadow-md transition-all duration-300">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-gray-600 dark:text-gray-400 text-sm">Exams Taken</p>
                                <h4 class="text-2xl font-bold text-gray-900 dark:text-white mt-1">{{ $examStats['total'] }}</h4>
                            </div>
                            <div class="p-3 rounded-xl bg-blue-100 dark:bg-blue-900/30">
                                <svg class="w-6 h-6 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                            </div>
                        </div>
                        <div class="mt-3 w-full bg-gray-200 dark:bg-gray-700 rounded-full h-2">
                            <div class="bg-gradient-to-r from-blue-500 to-blue-600 h-2 rounded-full" style="width: {{ min(100, $examStats['total'] * 10) }}%"></div>
                        </div>
                    </div>

                    <!-- Passed Exams -->
                    <div class="bg-gradient-to-br from-green-50 to-green-100 dark:from-green-900/20 dark:to-green-800/20 rounded-2xl p-5 border border-green-200 dark:border-green-800/30 shadow-sm hover:shadow-md transition-all duration-300">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-gray-600 dark:text-gray-400 text-sm">Passed</p>
                                <h4 class="text-2xl font-bold text-gray-900 dark:text-white mt-1">{{ $examStats['passed'] }}</h4>
                            </div>
                            <div class="p-3 rounded-xl bg-green-100 dark:bg-green-900/30">
                                <svg class="w-6 h-6 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                        </div>
                        <div class="mt-3 w-full bg-gray-200 dark:bg-gray-700 rounded-full h-2">
                            <div class="bg-gradient-to-r from-green-500 to-green-600 h-2 rounded-full" style="width: {{ $examStats['total'] > 0 ? ($examStats['passed'] / $examStats['total'] * 100) : 0 }}%"></div>
                        </div>
                    </div>

                    <!-- Average Score -->
                    <div class="bg-gradient-to-br from-amber-50 to-amber-100 dark:from-amber-900/20 dark:to-amber-800/20 rounded-2xl p-5 border border-amber-200 dark:border-amber-800/30 shadow-sm hover:shadow-md transition-all duration-300">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-gray-600 dark:text-gray-400 text-sm">Average Score</p>
                                <h4 class="text-2xl font-bold text-gray-900 dark:text-white mt-1">{{ $examStats['average'] }}%</h4>
                            </div>
                            <div class="p-3 rounded-xl bg-amber-100 dark:bg-amber-900/30">
                                <svg class="w-6 h-6 text-amber-600 dark:text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"></path>
                                </svg>
                            </div>
                        </div>
                        <div class="mt-3 w-full bg-gray-200 dark:bg-gray-700 rounded-full h-2">
                            <div class="bg-gradient-to-r from-amber-500 to-amber-600 h-2 rounded-full" style="width: {{ $examStats['average'] }}%"></div>
                        </div>
                    </div>

                    <!-- Enrolled -->
                    <div class="bg-gradient-to-br from-purple-50 to-purple-100 dark:from-purple-900/20 dark:to-purple-800/20 rounded-2xl p-5 border border-purple-200 dark:border-purple-800/30 shadow-sm hover:shadow-md transition-all duration-300">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-gray-600 dark:text-gray-400 text-sm">Enrolled</p>
                                <h4 class="text-2xl font-bold text-gray-900 dark:text-white mt-1">{{ $student->enroll_date ? $student->enroll_date->diffForHumans() : 'N/A' }}</h4>
                            </div>
                            <div class="p-3 rounded-xl bg-purple-100 dark:bg-purple-900/30">
                                <svg class="w-6 h-6 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                            </div>
                        </div>
                        <div class="mt-3 w-full bg-gray-200 dark:bg-gray-700 rounded-full h-2">
                            <div class="bg-gradient-to-r from-purple-500 to-purple-600 h-2 rounded-full" style="width: {{ min(100, $student->enroll_date ? $student->enroll_date->diffInDays(now()) : 0) }}%"></div>
                        </div>
                    </div>
                </div>

                <!-- Achievement Badges -->
                <div class="mb-8">
                    <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-4 flex items-center">
                        <svg class="w-5 h-5 mr-2 text-primaryGreen" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                        </svg>
                        Achievements
                    </h3>
                    
                    <div class="flex flex-wrap gap-4 justify-center">
                        @if($examStats['passed'] >= 10)
                            <div class="flex flex-col items-center bg-gradient-to-br from-yellow-50 to-amber-50 dark:from-yellow-900/20 dark:to-amber-900/20 rounded-2xl p-5 border border-yellow-200 dark:border-yellow-800/30 w-32">
                                <div class="w-14 h-14 rounded-full bg-gradient-to-br from-yellow-400 to-orange-500 flex items-center justify-center mb-3 shadow-lg">
                                    <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                                <h4 class="font-bold text-gray-900 dark:text-white text-center">Top Performer</h4>
                                <p class="text-xs text-gray-600 dark:text-gray-400 text-center mt-1">10+ exams passed</p>
                            </div>
                        @endif
                        
                        @if($examStats['average'] >= 80)
                            <div class="flex flex-col items-center bg-gradient-to-br from-blue-50 to-indigo-50 dark:from-blue-900/20 dark:to-indigo-900/20 rounded-2xl p-5 border border-blue-200 dark:border-blue-800/30 w-32">
                                <div class="w-14 h-14 rounded-full bg-gradient-to-br from-blue-400 to-indigo-500 flex items-center justify-center mb-3 shadow-lg">
                                    <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                                <h4 class="font-bold text-gray-900 dark:text-white text-center">Consistent</h4>
                                <p class="text-xs text-gray-600 dark:text-gray-400 text-center mt-1">80%+ average</p>
                            </div>
                        @endif
                        
                        @if($examStats['total'] >= 5)
                            <div class="flex flex-col items-center bg-gradient-to-br from-green-50 to-teal-50 dark:from-green-900/20 dark:to-teal-900/20 rounded-2xl p-5 border border-green-200 dark:border-green-800/30 w-32">
                                <div class="w-14 h-14 rounded-full bg-gradient-to-br from-green-400 to-teal-500 flex items-center justify-center mb-3 shadow-lg">
                                    <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                    </svg>
                                </div>
                                <h4 class="font-bold text-gray-900 dark:text-white text-center">Dedicated</h4>
                                <p class="text-xs text-gray-600 dark:text-gray-400 text-center mt-1">5+ exams taken</p>
                            </div>
                        @endif
                        
                        @if($examStats['total'] == 0)
                            <div class="flex flex-col items-center bg-gradient-to-br from-gray-50 to-gray-100 dark:from-gray-800/20 dark:to-gray-700/20 rounded-2xl p-5 border border-gray-200 dark:border-gray-700/30 w-32">
                                <div class="w-14 h-14 rounded-full bg-gradient-to-br from-gray-400 to-gray-500 flex items-center justify-center mb-3 shadow-lg">
                                    <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                    </svg>
                                </div>
                                <h4 class="font-bold text-gray-900 dark:text-white text-center">Newbie</h4>
                                <p class="text-xs text-gray-600 dark:text-gray-400 text-center mt-1">Get started!</p>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="mt-8 pt-6 border-t border-gray-200 dark:border-gray-700">
                    <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-4 flex items-center">
                        <svg class="w-5 h-5 mr-2 text-primaryGreen" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z"></path>
                        </svg>
                        Share Your Success
                    </h3>
                    
                    <div class="flex flex-col sm:flex-row gap-4">
                        <!-- Share to Facebook -->
                        <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(route('student.profile.show', $student->id)) }}&quote=🌟 Check out my academic journey on Bikolpo Live! I'm a student at {{ $student->course->name ?? 'Bikolpo Live' }} and I've taken {{ $examStats['total'] }} exams with an average score of {{ $examStats['average'] }}%. #BikolpoLive #Education #StudentLife" 
                           target="_blank"
                           class="flex-1 inline-flex items-center justify-center px-6 py-4 bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white rounded-xl shadow-md hover:shadow-lg transition-all duration-300 transform hover:-translate-y-1">
                            <svg class="w-6 h-6 mr-3" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z"></path>
                            </svg>
                            <span class="font-medium">Share on Facebook</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Bikolpo Live Branding -->
        <div class="mt-8 text-center">
            <p class="text-gray-600 dark:text-gray-400 text-sm">
                Proudly powered by 
                <span class="font-bold text-transparent bg-clip-text bg-gradient-to-r from-primaryGreen to-emerald-600">Bikolpo Live</span>
            </p>
        </div>
    </div>
</div>

<!-- Custom Styles -->
<style>
    .dark .bg-gradient-to-r {
        background: linear-gradient(90deg, #10b981, #059669, #047857);
    }
    
    .dark .bg-gradient-to-br {
        background: linear-gradient(135deg, #10b981, #059669);
    }
</style>
@endsection