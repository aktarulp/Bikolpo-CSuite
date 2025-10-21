@extends('layouts.partner-layout')

@section('title', $course->name)

@section('content')
<div class="min-h-screen bg-gradient-to-br from-slate-50 via-blue-50 to-indigo-50 dark:from-gray-900 dark:via-slate-900 dark:to-indigo-950 -m-6 p-4 sm:p-6 lg:p-8">
    <div class="max-w-7xl mx-auto space-y-6">
        
        {{-- Header Section --}}
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl border-2 border-gray-200 dark:border-gray-700 overflow-hidden">
            {{-- Gradient Header --}}
            <div class="relative bg-gradient-to-br from-indigo-600 via-purple-600 to-pink-600 p-6 sm:p-8">
                {{-- Decorative Pattern --}}
                <div class="absolute inset-0 bg-[url('data:image/svg+xml,%3Csvg width="30" height="30" viewBox="0 0 30 30" xmlns="http://www.w3.org/2000/svg"%3E%3Cg fill="%23ffffff" fill-opacity="0.07"%3E%3Crect width="2" height="2"/%3E%3C/g%3E%3C/svg%3E')]"></div>
                
                <div class="relative z-10">
                    <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-4">
                        <div class="flex items-start gap-4">
                            {{-- Back Button --}}
                            <a href="{{ route('partner.courses.index') }}" 
                               class="w-12 h-12 bg-white/20 backdrop-blur-sm rounded-xl flex items-center justify-center hover:bg-white/30 transition-all duration-200 border border-white/30 shadow-lg hover:scale-105 flex-shrink-0">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                                </svg>
                            </a>
                            
                            {{-- Course Icon & Name --}}
                            <div class="flex items-start gap-4">
                                <div class="w-16 h-16 sm:w-20 sm:h-20 bg-white/20 backdrop-blur-sm rounded-2xl flex items-center justify-center text-white font-bold text-2xl sm:text-3xl shadow-2xl border border-white/30 flex-shrink-0">
                                    {{ substr($course->name, 0, 1) }}
                                </div>
                                <div class="flex-1 min-w-0">
                                    <h1 class="text-2xl sm:text-3xl lg:text-4xl font-extrabold text-white mb-2 leading-tight">
                                        {{ $course->name }}
                                    </h1>
                                    <div class="flex flex-wrap items-center gap-3">
                                        <span class="px-3 py-1.5 bg-white/20 backdrop-blur-sm text-white text-sm font-bold rounded-full border border-white/30 shadow-lg">
                                            {{ $course->code }}
                                        </span>
                                        <span class="px-3 py-1.5 bg-green-500/90 backdrop-blur-sm text-white text-sm font-bold rounded-full border border-white/30 shadow-lg">
                                            {{ ucfirst($course->status ?? 'active') }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        {{-- Action Button --}}
                        <a href="{{ route('partner.courses.edit', $course) }}" 
                           class="group bg-white hover:bg-gray-50 text-gray-900 font-bold px-6 py-3 rounded-xl shadow-xl hover:shadow-2xl transition-all duration-200 inline-flex items-center justify-center gap-2 hover:scale-105 border-2 border-white/30">
                            <svg class="w-5 h-5 group-hover:rotate-12 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                            </svg>
                            <span>Edit Course</span>
                        </a>
                    </div>
                </div>

                {{-- Wave Divider --}}
                <div class="absolute bottom-0 left-0 right-0">
                    <svg viewBox="0 0 1200 120" preserveAspectRatio="none" class="w-full h-6">
                        <path d="M321.39,56.44c58-10.79,114.16-30.13,172-41.86,82.39-16.72,168.19-17.73,250.45-.39C823.78,31,906.67,72,985.66,92.83c70.05,18.48,146.53,26.09,214.34,3V0H0V27.35A600.21,600.21,0,0,0,321.39,56.44Z" class="fill-white dark:fill-gray-800"></path>
                    </svg>
                </div>
            </div>

            {{-- Description --}}
            @if($course->description)
            <div class="p-6 sm:p-8 border-b border-gray-200 dark:border-gray-700">
                <div class="flex items-start gap-3">
                    <div class="w-10 h-10 bg-blue-100 dark:bg-blue-900/30 rounded-xl flex items-center justify-center flex-shrink-0">
                        <svg class="w-5 h-5 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div class="flex-1">
                        <h3 class="text-sm font-bold text-gray-600 dark:text-gray-400 uppercase mb-2">Description</h3>
                        <p class="text-gray-700 dark:text-gray-300 leading-relaxed">{{ $course->description }}</p>
                    </div>
                </div>
            </div>
            @endif
        </div>

        {{-- Quick Stats Bar --}}
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg border-2 border-gray-200 dark:border-gray-700 overflow-hidden">
            <div class="grid grid-cols-2 sm:grid-cols-4 divide-x divide-y sm:divide-y-0 divide-gray-200 dark:divide-gray-700">
                {{-- Subjects Count --}}
                <div class="p-4 sm:p-6 hover:bg-orange-50 dark:hover:bg-orange-900/10 transition-colors">
                    <div class="flex items-center gap-3">
                        <div class="w-12 h-12 bg-gradient-to-br from-orange-500 to-amber-600 rounded-xl flex items-center justify-center shadow-md">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                        </div>
                        <div>
                            <p class="text-2xl sm:text-3xl font-bold text-orange-600 dark:text-orange-400">{{ $course->subjects_count ?? $course->subjects->count() }}</p>
                            <p class="text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase">Subjects</p>
                        </div>
                    </div>
                </div>

                {{-- Batches Count --}}
                <div class="p-4 sm:p-6 hover:bg-purple-50 dark:hover:bg-purple-900/10 transition-colors">
                    <div class="flex items-center gap-3">
                        <div class="w-12 h-12 bg-gradient-to-br from-purple-500 to-pink-600 rounded-xl flex items-center justify-center shadow-md">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                            </svg>
                        </div>
                        <div>
                            <p class="text-2xl sm:text-3xl font-bold text-purple-600 dark:text-purple-400">{{ $course->batches_count ?? $course->batches->count() }}</p>
                            <p class="text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase">Batches</p>
                        </div>
                    </div>
                </div>

                {{-- Students Count --}}
                <div class="p-4 sm:p-6 hover:bg-emerald-50 dark:hover:bg-emerald-900/10 transition-colors">
                    <div class="flex items-center gap-3">
                        <div class="w-12 h-12 bg-gradient-to-br from-emerald-500 to-green-600 rounded-xl flex items-center justify-center shadow-md">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                            </svg>
                        </div>
                        <div>
                            <p class="text-2xl sm:text-3xl font-bold text-emerald-600 dark:text-emerald-400">{{ $course->enrollments_count ?? $course->enrollments->count() }}</p>
                            <p class="text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase">Students</p>
                        </div>
                    </div>
                </div>

                {{-- Duration/Hours --}}
                <div class="p-4 sm:p-6 hover:bg-blue-50 dark:hover:bg-blue-900/10 transition-colors">
                    <div class="flex items-center gap-3">
                        <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-xl flex items-center justify-center shadow-md">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div>
                            <p class="text-2xl sm:text-3xl font-bold text-blue-600 dark:text-blue-400">{{ $course->duration ?? 'N/A' }}</p>
                            <p class="text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase">Duration</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Course Details Grid --}}
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            {{-- Subjects --}}
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg border-2 border-gray-200 dark:border-gray-700 overflow-hidden hover:shadow-xl transition-shadow duration-300">
                <div class="bg-gradient-to-r from-orange-500 to-amber-600 p-4 sm:p-6">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <div class="w-12 h-12 bg-white/20 backdrop-blur-sm rounded-xl flex items-center justify-center border border-white/30">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                            </div>
                            <h3 class="text-xl font-bold text-white">Subjects</h3>
                        </div>
                        <span class="px-3 py-1.5 bg-white/20 backdrop-blur-sm text-white text-sm font-bold rounded-full border border-white/30">
                            {{ $course->subjects->count() }}
                        </span>
                    </div>
                </div>
                <div class="p-6">
                    @if($course->subjects->count() > 0)
                    <div class="space-y-3">
                        @foreach($course->subjects as $subject)
                        <div class="group flex items-center gap-3 p-4 bg-gray-50 dark:bg-gray-700/50 rounded-xl hover:bg-orange-50 dark:hover:bg-orange-900/20 hover:border-orange-200 dark:hover:border-orange-800 border-2 border-transparent transition-all duration-200">
                            <div class="w-10 h-10 bg-gradient-to-br from-orange-500 to-amber-600 rounded-lg flex items-center justify-center text-white font-bold shadow-md group-hover:scale-110 transition-transform duration-200">
                                {{ $loop->iteration }}
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="font-bold text-gray-900 dark:text-white truncate">{{ $subject->name }}</p>
                                @if($subject->code)
                                <p class="text-sm text-gray-600 dark:text-gray-400">{{ $subject->code }}</p>
                                @endif
                            </div>
                        </div>
                        @endforeach
                    </div>
                    @else
                    <div class="text-center py-12">
                        <div class="w-16 h-16 bg-gray-100 dark:bg-gray-700 rounded-2xl flex items-center justify-center mx-auto mb-4">
                            <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                        </div>
                        <p class="text-gray-500 dark:text-gray-400 font-medium">No subjects added yet</p>
                    </div>
                    @endif
                </div>
            </div>

            {{-- Batches --}}
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg border-2 border-gray-200 dark:border-gray-700 overflow-hidden hover:shadow-xl transition-shadow duration-300">
                <div class="bg-gradient-to-r from-purple-500 to-pink-600 p-4 sm:p-6">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <div class="w-12 h-12 bg-white/20 backdrop-blur-sm rounded-xl flex items-center justify-center border border-white/30">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                                </svg>
                            </div>
                            <h3 class="text-xl font-bold text-white">Batches</h3>
                        </div>
                        <span class="px-3 py-1.5 bg-white/20 backdrop-blur-sm text-white text-sm font-bold rounded-full border border-white/30">
                            {{ $course->batches->count() }}
                        </span>
                    </div>
                </div>
                <div class="p-6">
                    @if($course->batches->count() > 0)
                    <div class="space-y-3">
                        @foreach($course->batches as $batch)
                        <div class="group flex items-center justify-between p-4 bg-gray-50 dark:bg-gray-700/50 rounded-xl hover:bg-purple-50 dark:hover:bg-purple-900/20 hover:border-purple-200 dark:hover:border-purple-800 border-2 border-transparent transition-all duration-200">
                            <div class="flex items-center gap-3 flex-1 min-w-0">
                                <div class="w-10 h-10 bg-gradient-to-br from-purple-500 to-pink-600 rounded-lg flex items-center justify-center text-white font-bold shadow-md group-hover:scale-110 transition-transform duration-200">
                                    {{ $loop->iteration }}
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="font-bold text-gray-900 dark:text-white truncate">{{ $batch->name }}</p>
                                    <p class="text-sm text-gray-600 dark:text-gray-400">{{ $batch->year }}</p>
                                </div>
                            </div>
                            <span class="px-3 py-1.5 bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-400 text-xs font-bold rounded-full border border-green-200 dark:border-green-800 flex-shrink-0 ml-2">
                                {{ $batch->students_count ?? 0 }}
                            </span>
                        </div>
                        @endforeach
                    </div>
                    @else
                    <div class="text-center py-12">
                        <div class="w-16 h-16 bg-gray-100 dark:bg-gray-700 rounded-2xl flex items-center justify-center mx-auto mb-4">
                            <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                            </svg>
                        </div>
                        <p class="text-gray-500 dark:text-gray-400 font-medium">No batches created yet</p>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        {{-- Enrolled Students --}}
        @if($course->enrollments->count() > 0)
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg border-2 border-gray-200 dark:border-gray-700 overflow-hidden hover:shadow-xl transition-shadow duration-300">
            <div class="bg-gradient-to-r from-emerald-500 to-green-600 p-4 sm:p-6">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="w-12 h-12 bg-white/20 backdrop-blur-sm rounded-xl flex items-center justify-center border border-white/30">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-white">Enrolled Students</h3>
                    </div>
                    <span class="px-3 py-1.5 bg-white/20 backdrop-blur-sm text-white text-sm font-bold rounded-full border border-white/30">
                        {{ $course->enrollments->count() }}
                    </span>
                </div>
            </div>
            <div class="p-6">
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                    @foreach($course->enrollments->take(12) as $enrollment)
                    <div class="group flex items-center gap-3 p-4 bg-gray-50 dark:bg-gray-700/50 rounded-xl hover:bg-emerald-50 dark:hover:bg-emerald-900/20 hover:border-emerald-200 dark:hover:border-emerald-800 border-2 border-transparent transition-all duration-200">
                        <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-full flex items-center justify-center text-white font-bold text-lg shadow-md group-hover:scale-110 transition-transform duration-200">
                            {{ substr($enrollment->student->full_name, 0, 1) }}
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="font-bold text-gray-900 dark:text-white truncate">{{ $enrollment->student->full_name }}</p>
                            <p class="text-sm text-gray-600 dark:text-gray-400 truncate">{{ $enrollment->student->student_id }}</p>
                        </div>
                    </div>
                    @endforeach
                </div>
                
                @if($course->enrollments->count() > 12)
                <div class="mt-6 text-center">
                    <a href="{{ route('partner.enrollments.index', ['course_id' => $course->id]) }}" 
                       class="inline-flex items-center justify-center gap-2 bg-gradient-to-r from-emerald-600 to-green-600 hover:from-emerald-700 hover:to-green-700 text-white font-bold px-6 py-3 rounded-xl shadow-md hover:shadow-lg transition-all duration-200 hover:scale-105">
                        View all {{ $course->enrollments->count() }} students
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                        </svg>
                    </a>
                </div>
                @endif
            </div>
        </div>
        @endif
    </div>
</div>
@endsection
