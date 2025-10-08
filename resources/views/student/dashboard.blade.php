@extends('layouts.partner-layout')

@section('content')
<div class="space-y-6">
    <!-- Welcome Header -->
    <div class="bg-gradient-to-r from-blue-50 to-indigo-100 dark:from-blue-900/20 dark:to-indigo-900/20 rounded-xl p-6 border border-blue-200 dark:border-blue-800">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-gray-900 dark:text-white mb-2">
                    Welcome back, {{ $user->name ?? 'Student' }}!
                </h1>
                <p class="text-gray-600 dark:text-gray-400">
                    Student Dashboard - Track your learning progress
                </p>
                @if($student ?? null)
                    <p class="text-sm text-blue-600 dark:text-blue-400 mt-1">
                        Student ID: {{ $student->student_id ?? 'Not assigned' }}
                    </p>
                @endif
            </div>
            <div class="hidden md:block">
                <div class="w-16 h-16 bg-blue-500 rounded-full flex items-center justify-center">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14zm-4 6v-7.5l4-2.222"></path>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Stats -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <!-- Available Exams -->
        <div class="bg-white dark:bg-gray-800 rounded-xl p-6 border border-gray-200 dark:border-gray-700 shadow-sm hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Available Exams</p>
                    <p class="text-3xl font-bold text-gray-900 dark:text-white">{{ $stats['available_exams'] ?? 0 }}</p>
                </div>
                <div class="w-12 h-12 bg-green-100 dark:bg-green-900/50 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Completed Exams -->
        <div class="bg-white dark:bg-gray-800 rounded-xl p-6 border border-gray-200 dark:border-gray-700 shadow-sm hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Completed Exams</p>
                    <p class="text-3xl font-bold text-gray-900 dark:text-white">{{ $stats['completed_exams'] ?? 0 }}</p>
                </div>
                <div class="w-12 h-12 bg-blue-100 dark:bg-blue-900/50 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Average Score -->
        <div class="bg-white dark:bg-gray-800 rounded-xl p-6 border border-gray-200 dark:border-gray-700 shadow-sm hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Average Score</p>
                    <p class="text-3xl font-bold text-gray-900 dark:text-white">{{ $stats['average_score'] ?? 0 }}%</p>
                </div>
                <div class="w-12 h-12 bg-purple-100 dark:bg-purple-900/50 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Study Streak -->
        <div class="bg-white dark:bg-gray-800 rounded-xl p-6 border border-gray-200 dark:border-gray-700 shadow-sm hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Study Streak</p>
                    <p class="text-3xl font-bold text-gray-900 dark:text-white">{{ $stats['study_streak'] ?? 0 }} days</p>
                </div>
                <div class="w-12 h-12 bg-orange-100 dark:bg-orange-900/50 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-orange-600 dark:text-orange-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 18.657A8 8 0 016.343 7.343S7 9 9 10c0-2 .5-5 2.986-7C14 5 16.09 5.777 17.656 7.343A7.975 7.975 0 0120 13a7.975 7.975 0 01-2.343 5.657z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.879 16.121A3 3 0 1012.015 11L11 14H9c0 .768.293 1.536.879 2.121z"></path>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="bg-white dark:bg-gray-800 rounded-xl p-6 border border-gray-200 dark:border-gray-700 shadow-sm">
        <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Quick Actions</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
            <a href="{{ route('student.exams.available') }}" class="flex items-center p-4 bg-gradient-to-r from-green-50 to-emerald-50 dark:from-green-900/20 dark:to-emerald-900/20 rounded-lg hover:from-green-100 hover:to-emerald-100 dark:hover:from-green-900/30 dark:hover:to-emerald-900/30 transition-all duration-200 border border-green-200 dark:border-green-800">
                <div class="w-10 h-10 bg-green-500 rounded-lg flex items-center justify-center mr-3">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                </div>
                <div>
                    <p class="text-sm font-semibold text-gray-900 dark:text-white">Take Exam</p>
                    <p class="text-xs text-gray-600 dark:text-gray-400">Start a new exam</p>
                </div>
            </a>
            
            <a href="{{ route('student.exams.history') }}" class="flex items-center p-4 bg-gradient-to-r from-blue-50 to-indigo-50 dark:from-blue-900/20 dark:to-indigo-900/20 rounded-lg hover:from-blue-100 hover:to-indigo-100 dark:hover:from-blue-900/30 dark:hover:to-indigo-900/30 transition-all duration-200 border border-blue-200 dark:border-blue-800">
                <div class="w-10 h-10 bg-blue-500 rounded-lg flex items-center justify-center mr-3">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div>
                    <p class="text-sm font-semibold text-gray-900 dark:text-white">Exam History</p>
                    <p class="text-xs text-gray-600 dark:text-gray-400">View past results</p>
                </div>
            </a>
            
            <a href="#" class="flex items-center p-4 bg-gradient-to-r from-purple-50 to-violet-50 dark:from-purple-900/20 dark:to-violet-900/20 rounded-lg hover:from-purple-100 hover:to-violet-100 dark:hover:from-purple-900/30 dark:hover:to-violet-900/30 transition-all duration-200 border border-purple-200 dark:border-purple-800">
                <div class="w-10 h-10 bg-purple-500 rounded-lg flex items-center justify-center mr-3">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                    </svg>
                </div>
                <div>
                    <p class="text-sm font-semibold text-gray-900 dark:text-white">My Profile</p>
                    <p class="text-xs text-gray-600 dark:text-gray-400">Update profile</p>
                </div>
            </a>
            
            <a href="#" class="flex items-center p-4 bg-gradient-to-r from-orange-50 to-amber-50 dark:from-orange-900/20 dark:to-amber-900/20 rounded-lg hover:from-orange-100 hover:to-amber-100 dark:hover:from-orange-900/30 dark:hover:to-amber-900/30 transition-all duration-200 border border-orange-200 dark:border-orange-800">
                <div class="w-10 h-10 bg-orange-500 rounded-lg flex items-center justify-center mr-3">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                    </svg>
                </div>
                <div>
                    <p class="text-sm font-semibold text-gray-900 dark:text-white">Progress</p>
                    <p class="text-xs text-gray-600 dark:text-gray-400">View analytics</p>
                </div>
            </a>
        </div>
    </div>

    <!-- Recent Exams & Upcoming Exams -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Recent Exam Results -->
        <div class="bg-white dark:bg-gray-800 rounded-xl p-6 border border-gray-200 dark:border-gray-700 shadow-sm">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-lg font-semibold text-gray-900 dark:text-white">Recent Results</h2>
                <a href="{{ route('student.exams.history') }}" class="text-sm text-blue-600 hover:text-blue-700 dark:text-blue-400 dark:hover:text-blue-300">View All</a>
            </div>
            <div class="space-y-3">
                @if(isset($recentResults) && count($recentResults) > 0)
                    @foreach($recentResults as $result)
                        <div class="flex items-center justify-between p-3 bg-gray-50 dark:bg-gray-700 rounded-lg">
                            <div class="flex items-center space-x-3">
                                <div class="w-10 h-10 bg-blue-100 dark:bg-blue-900/50 rounded-lg flex items-center justify-center">
                                    <svg class="w-5 h-5 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-900 dark:text-white">{{ $result->exam_title ?? 'Exam' }}</p>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">{{ $result->created_at->format('M d, Y') ?? 'Recently' }}</p>
                                </div>
                            </div>
                            <div class="text-right">
                                <p class="text-sm font-bold {{ ($result->score ?? 0) >= 70 ? 'text-green-600 dark:text-green-400' : 'text-red-600 dark:text-red-400' }}">
                                    {{ $result->score ?? 0 }}%
                                </p>
                                <p class="text-xs text-gray-500 dark:text-gray-400">
                                    {{ ($result->score ?? 0) >= 70 ? 'Passed' : 'Failed' }}
                                </p>
                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="text-center py-8">
                        <svg class="w-12 h-12 text-gray-400 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        <p class="text-sm text-gray-500 dark:text-gray-400">No exam results yet</p>
                        <p class="text-xs text-gray-400 dark:text-gray-500 mt-1">Take your first exam to see results here</p>
                    </div>
                @endif
            </div>
        </div>

        <!-- Upcoming Exams -->
        <div class="bg-white dark:bg-gray-800 rounded-xl p-6 border border-gray-200 dark:border-gray-700 shadow-sm">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-lg font-semibold text-gray-900 dark:text-white">Available Exams</h2>
                <a href="{{ route('student.exams.available') }}" class="text-sm text-blue-600 hover:text-blue-700 dark:text-blue-400 dark:hover:text-blue-300">View All</a>
            </div>
            <div class="space-y-3">
                @if(isset($availableExams) && count($availableExams) > 0)
                    @foreach($availableExams as $exam)
                        <div class="flex items-center justify-between p-3 bg-gray-50 dark:bg-gray-700 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-600 transition-colors">
                            <div class="flex items-center space-x-3">
                                <div class="w-10 h-10 bg-green-100 dark:bg-green-900/50 rounded-lg flex items-center justify-center">
                                    <svg class="w-5 h-5 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-900 dark:text-white">{{ $exam->title ?? 'Exam Title' }}</p>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">{{ $exam->duration ?? 60 }} minutes • {{ $exam->total_questions ?? 0 }} questions</p>
                                </div>
                            </div>
                            <a href="{{ route('student.exams.show', $exam->id ?? '#') }}" class="px-3 py-1 bg-blue-500 hover:bg-blue-600 text-white text-xs font-medium rounded-md transition-colors">
                                Start
                            </a>
                        </div>
                    @endforeach
                @else
                    <div class="text-center py-8">
                        <svg class="w-12 h-12 text-gray-400 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <p class="text-sm text-gray-500 dark:text-gray-400">No exams available</p>
                        <p class="text-xs text-gray-400 dark:text-gray-500 mt-1">Check back later for new exams</p>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Performance Chart Section -->
    <div class="bg-white dark:bg-gray-800 rounded-xl p-6 border border-gray-200 dark:border-gray-700 shadow-sm">
        <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Performance Overview</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <!-- Subject Performance -->
            <div class="space-y-3">
                <h3 class="text-sm font-medium text-gray-700 dark:text-gray-300">Subject Performance</h3>
                @if(isset($subjectPerformance) && count($subjectPerformance) > 0)
                    @foreach($subjectPerformance as $subject)
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-gray-600 dark:text-gray-400">{{ $subject->name ?? 'Subject' }}</span>
                            <div class="flex items-center space-x-2">
                                <div class="w-16 bg-gray-200 dark:bg-gray-700 rounded-full h-2">
                                    <div class="bg-blue-500 h-2 rounded-full" style="width: {{ $subject->average_score ?? 0 }}%"></div>
                                </div>
                                <span class="text-sm font-medium text-gray-900 dark:text-white">{{ $subject->average_score ?? 0 }}%</span>
                            </div>
                        </div>
                    @endforeach
                @else
                    <p class="text-sm text-gray-500 dark:text-gray-400">No performance data available</p>
                @endif
            </div>

            <!-- Weekly Activity -->
            <div class="space-y-3">
                <h3 class="text-sm font-medium text-gray-700 dark:text-gray-300">Weekly Activity</h3>
                <div class="grid grid-cols-7 gap-1">
                    @for($i = 0; $i < 7; $i++)
                        <div class="h-8 bg-gray-100 dark:bg-gray-700 rounded flex items-center justify-center">
                            <span class="text-xs text-gray-600 dark:text-gray-400">{{ ['S', 'M', 'T', 'W', 'T', 'F', 'S'][$i] }}</span>
                        </div>
                    @endfor
                </div>
                <p class="text-xs text-gray-500 dark:text-gray-400">Study activity for this week</p>
            </div>

            <!-- Achievement Badges -->
            <div class="space-y-3">
                <h3 class="text-sm font-medium text-gray-700 dark:text-gray-300">Recent Achievements</h3>
                <div class="grid grid-cols-3 gap-2">
                    <div class="flex flex-col items-center p-2 bg-yellow-50 dark:bg-yellow-900/20 rounded-lg">
                        <div class="w-8 h-8 bg-yellow-500 rounded-full flex items-center justify-center mb-1">
                            <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                            </svg>
                        </div>
                        <span class="text-xs text-yellow-700 dark:text-yellow-300 font-medium">First Exam</span>
                    </div>
                    <div class="flex flex-col items-center p-2 bg-green-50 dark:bg-green-900/20 rounded-lg">
                        <div class="w-8 h-8 bg-green-500 rounded-full flex items-center justify-center mb-1">
                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <span class="text-xs text-green-700 dark:text-green-300 font-medium">High Score</span>
                    </div>
                    <div class="flex flex-col items-center p-2 bg-purple-50 dark:bg-purple-900/20 rounded-lg">
                        <div class="w-8 h-8 bg-purple-500 rounded-full flex items-center justify-center mb-1">
                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 18.657A8 8 0 016.343 7.343S7 9 9 10c0-2 .5-5 2.986-7C14 5 16.09 5.777 17.656 7.343A7.975 7.975 0 0120 13a7.975 7.975 0 01-2.343 5.657z"></path>
                            </svg>
                        </div>
                        <span class="text-xs text-purple-700 dark:text-purple-300 font-medium">Streak</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
