@extends('layouts.partner-layout')

@section('title', $course->name)

@section('content')
<div class="min-h-screen bg-gradient-to-br from-slate-50 via-blue-50/30 to-indigo-50/50 dark:from-slate-900 dark:via-slate-800 dark:to-slate-900 py-4 sm:py-6 lg:py-8 px-4 sm:px-6 lg:px-8">
    
    {{-- Header Section --}}
    <div class="mb-8">
        <div class="bg-gradient-to-r from-slate-900 via-blue-900 to-indigo-900 rounded-3xl shadow-2xl p-6 sm:p-8 relative overflow-hidden">
            {{-- Background Pattern --}}
            <div class="absolute inset-0 bg-[url('data:image/svg+xml,%3Csvg width="60" height="60" viewBox="0 0 60 60" xmlns="http://www.w3.org/2000/svg"%3E%3Cg fill="none" fill-rule="evenodd"%3E%3Cg fill="%23ffffff" fill-opacity="0.05"%3E%3Ccircle cx="30" cy="30" r="2"/%3E%3C/g%3E%3C/g%3E%3C/svg%3E')] opacity-20"></div>
            
            <div class="relative z-10">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-6">
                    <div class="space-y-3">
                        <div class="flex items-center gap-3">
                            <a href="{{ route('partner.courses.index') }}" 
                               class="w-12 h-12 bg-white/10 backdrop-blur-sm rounded-2xl flex items-center justify-center hover:bg-white/20 transition-colors">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                                </svg>
                            </a>
                            <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-xl flex items-center justify-center text-white font-bold text-lg">
                                {{ substr($course->name, 0, 1) }}
                            </div>
                            <div>
                                <h1 class="text-3xl sm:text-4xl font-bold text-white">{{ $course->name }}</h1>
                                <p class="text-slate-200 text-lg">{{ $course->code }}</p>
                            </div>
                        </div>
                        
                        {{-- Stats Cards --}}
                        <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 mt-6">
                            <div class="bg-white/10 backdrop-blur-sm rounded-xl p-4 border border-white/20">
                                <div class="text-2xl font-bold text-white">{{ $course->subjects_count ?? $course->subjects->count() }}</div>
                                <div class="text-sm text-slate-300">Subjects</div>
                            </div>
                            <div class="bg-white/10 backdrop-blur-sm rounded-xl p-4 border border-white/20">
                                <div class="text-2xl font-bold text-purple-400">{{ $course->batches_count ?? $course->batches->count() }}</div>
                                <div class="text-sm text-slate-300">Batches</div>
                            </div>
                            <div class="bg-white/10 backdrop-blur-sm rounded-xl p-4 border border-white/20">
                                <div class="text-2xl font-bold text-emerald-400">{{ $course->enrollments_count ?? $course->enrollments->count() }}</div>
                                <div class="text-sm text-slate-300">Students</div>
                            </div>
                            <div class="bg-white/10 backdrop-blur-sm rounded-xl p-4 border border-white/20">
                                <div class="text-2xl font-bold text-blue-400">Active</div>
                                <div class="text-sm text-slate-300">Status</div>
                            </div>
                        </div>
                    </div>
                    
                    {{-- Action Button --}}
                    <div class="flex-shrink-0">
                        <a href="{{ route('partner.courses.edit', $course) }}" 
                           class="group bg-white hover:bg-slate-50 text-slate-900 font-bold px-6 py-4 rounded-2xl shadow-xl hover:shadow-2xl transition-all duration-300 flex items-center gap-3 hover:scale-105">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                            </svg>
                            <span>Edit Course</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Course Description --}}
    @if($course->description)
    <div class="mb-8">
        <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-lg border border-slate-200 dark:border-slate-700 p-6">
            <h3 class="text-lg font-bold text-slate-900 dark:text-white mb-3">Description</h3>
            <p class="text-slate-600 dark:text-slate-400">{{ $course->description }}</p>
        </div>
    </div>
    @endif

    {{-- Course Details Grid --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        {{-- Subjects --}}
        <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-lg border border-slate-200 dark:border-slate-700 overflow-hidden">
            <div class="bg-gradient-to-r from-orange-50 to-amber-50 dark:from-orange-900/20 dark:to-amber-900/20 px-6 py-4 border-b border-slate-200 dark:border-slate-700">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-gradient-to-br from-orange-500 to-amber-600 rounded-xl flex items-center justify-center">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-slate-900 dark:text-white">Subjects</h3>
                </div>
            </div>
            <div class="p-6">
                @if($course->subjects->count() > 0)
                <div class="space-y-3">
                    @foreach($course->subjects as $subject)
                    <div class="flex items-center justify-between p-4 bg-slate-50 dark:bg-slate-700/50 rounded-xl hover:bg-slate-100 dark:hover:bg-slate-700 transition-colors">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 bg-orange-100 dark:bg-orange-900/30 rounded-lg flex items-center justify-center">
                                <span class="text-orange-600 dark:text-orange-400 font-bold text-sm">{{ $loop->iteration }}</span>
                            </div>
                            <div>
                                <p class="font-semibold text-slate-900 dark:text-white">{{ $subject->name }}</p>
                                @if($subject->code)
                                <p class="text-xs text-slate-500 dark:text-slate-400">{{ $subject->code }}</p>
                                @endif
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                @else
                <div class="text-center py-8 text-slate-500 dark:text-slate-400">
                    <svg class="w-12 h-12 mx-auto mb-3 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    <p>No subjects added yet</p>
                </div>
                @endif
            </div>
        </div>

        {{-- Batches --}}
        <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-lg border border-slate-200 dark:border-slate-700 overflow-hidden">
            <div class="bg-gradient-to-r from-purple-50 to-pink-50 dark:from-purple-900/20 dark:to-pink-900/20 px-6 py-4 border-b border-slate-200 dark:border-slate-700">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-gradient-to-br from-purple-500 to-pink-600 rounded-xl flex items-center justify-center">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-slate-900 dark:text-white">Batches</h3>
                </div>
            </div>
            <div class="p-6">
                @if($course->batches->count() > 0)
                <div class="space-y-3">
                    @foreach($course->batches as $batch)
                    <div class="flex items-center justify-between p-4 bg-slate-50 dark:bg-slate-700/50 rounded-xl hover:bg-slate-100 dark:hover:bg-slate-700 transition-colors">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 bg-purple-100 dark:bg-purple-900/30 rounded-lg flex items-center justify-center">
                                <span class="text-purple-600 dark:text-purple-400 font-bold text-sm">{{ $loop->iteration }}</span>
                            </div>
                            <div>
                                <p class="font-semibold text-slate-900 dark:text-white">{{ $batch->name }}</p>
                                <p class="text-xs text-slate-500 dark:text-slate-400">{{ $batch->year }}</p>
                            </div>
                        </div>
                        <span class="px-3 py-1 bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-400 text-xs font-semibold rounded-full">
                            {{ $batch->students_count ?? 0 }} Students
                        </span>
                    </div>
                    @endforeach
                </div>
                @else
                <div class="text-center py-8 text-slate-500 dark:text-slate-400">
                    <svg class="w-12 h-12 mx-auto mb-3 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                    </svg>
                    <p>No batches created yet</p>
                </div>
                @endif
            </div>
        </div>
    </div>

    {{-- Enrolled Students --}}
    @if($course->enrollments->count() > 0)
    <div class="mt-8">
        <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-lg border border-slate-200 dark:border-slate-700 overflow-hidden">
            <div class="bg-gradient-to-r from-emerald-50 to-green-50 dark:from-emerald-900/20 dark:to-green-900/20 px-6 py-4 border-b border-slate-200 dark:border-slate-700">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-gradient-to-br from-emerald-500 to-green-600 rounded-xl flex items-center justify-center">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-slate-900 dark:text-white">Enrolled Students</h3>
                </div>
            </div>
            <div class="p-6">
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                    @foreach($course->enrollments->take(12) as $enrollment)
                    <div class="flex items-center gap-3 p-4 bg-slate-50 dark:bg-slate-700/50 rounded-xl">
                        <div class="w-10 h-10 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-full flex items-center justify-center text-white font-bold">
                            {{ substr($enrollment->student->full_name, 0, 1) }}
                        </div>
                        <div class="min-w-0 flex-1">
                            <p class="font-semibold text-slate-900 dark:text-white truncate">{{ $enrollment->student->full_name }}</p>
                            <p class="text-xs text-slate-500 dark:text-slate-400 truncate">{{ $enrollment->student->student_id }}</p>
                        </div>
                    </div>
                    @endforeach
                </div>
                @if($course->enrollments->count() > 12)
                <div class="mt-4 text-center">
                    <a href="{{ route('partner.enrollments.index', ['course_id' => $course->id]) }}" 
                       class="inline-flex items-center gap-2 text-blue-600 dark:text-blue-400 hover:text-blue-700 dark:hover:text-blue-300 font-semibold">
                        View all {{ $course->enrollments->count() }} students
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </a>
                </div>
                @endif
            </div>
        </div>
    </div>
    @endif
</div>
@endsection
