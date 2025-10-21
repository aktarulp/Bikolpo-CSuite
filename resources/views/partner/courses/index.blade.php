@extends('layouts.partner-layout')

@section('title', 'Courses')

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
                            <div class="w-12 h-12 bg-white/10 backdrop-blur-sm rounded-2xl flex items-center justify-center">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                </svg>
                            </div>
                            <div>
                                <h1 class="text-3xl sm:text-4xl font-bold text-white">Course Catalog</h1>
                                <p class="text-slate-200 text-lg">Manage your educational programs</p>
                            </div>
                        </div>
                    </div>
                    
                    {{-- Action Button --}}
                    <div class="flex-shrink-0">
                        <a href="{{ route('partner.courses.create') }}" 
                           class="group bg-white hover:bg-slate-50 text-slate-900 font-bold px-6 py-4 rounded-2xl shadow-xl hover:shadow-2xl transition-all duration-300 flex items-center gap-3 hover:scale-105">
                            <svg class="w-5 h-5 group-hover:rotate-90 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                            </svg>
                            <span>New Course</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Search and Filters --}}
    <div class="mb-8">
        <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-lg border border-slate-200 dark:border-slate-700 p-6">
            <div class="flex flex-col sm:flex-row gap-4">
                {{-- Search --}}
                <div class="flex-1">
                    <div class="relative">
                        <svg class="absolute left-3 top-1/2 transform -translate-y-1/2 w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                        <input type="text" 
                               id="searchInput"
                               placeholder="Search courses..." 
                               class="w-full pl-10 pr-4 py-3 border-2 border-slate-200 dark:border-slate-600 rounded-xl focus:ring-4 focus:ring-blue-500/20 focus:border-blue-500 dark:bg-slate-700 dark:text-white transition-all duration-200">
                    </div>
                </div>
                
                {{-- Filter --}}
                <div class="sm:w-48">
                    <select id="filterSelect" class="w-full px-4 py-3 border-2 border-slate-200 dark:border-slate-600 rounded-xl focus:ring-4 focus:ring-blue-500/20 focus:border-blue-500 dark:bg-slate-700 dark:text-white transition-all duration-200">
                        <option value="all">All Courses</option>
                        <option value="recent">Recently Added</option>
                        <option value="popular">Most Popular</option>
                        <option value="batches">Most Batches</option>
                    </select>
                </div>
            </div>
        </div>
    </div>

    {{-- Courses Grid --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-6">
        @forelse($courses as $course)
        <div class="group bg-white dark:bg-gray-800 rounded-2xl shadow-xl hover:shadow-2xl transition-all duration-300 border-2 border-gray-200 dark:border-gray-700 overflow-hidden hover:-translate-y-2 hover:border-indigo-500 dark:hover:border-indigo-400">
            {{-- Course Header with Gradient Background --}}
            <div class="relative bg-gradient-to-br from-indigo-500 via-purple-500 to-pink-500 p-6 pb-8">
                {{-- Decorative Pattern --}}
                <div class="absolute inset-0 bg-[url('data:image/svg+xml,%3Csvg width="20" height="20" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"%3E%3Cg fill="%23ffffff" fill-opacity="0.1"%3E%3Ccircle cx="3" cy="3" r="1.5"/%3E%3C/g%3E%3C/svg%3E')]"></div>
                
                <div class="relative z-10">
                    <div class="flex items-start justify-between mb-4">
                        <div class="flex-1 min-w-0 pr-4">
                            <h3 class="text-xl font-bold text-white mb-2 line-clamp-2 leading-tight">
                                {{ $course->name }}
                            </h3>
                            <span class="inline-block px-3 py-1 bg-white/20 backdrop-blur-sm text-white text-xs font-semibold rounded-full border border-white/30">
                                {{ $course->code }}
                            </span>
                        </div>
                        <div class="flex-shrink-0">
                            <div class="w-14 h-14 bg-white/20 backdrop-blur-sm rounded-2xl flex items-center justify-center text-white font-bold text-2xl shadow-lg border border-white/30">
                                {{ substr($course->name, 0, 1) }}
                            </div>
                        </div>
                    </div>
                    
                    {{-- Course Description --}}
                    @if($course->description)
                    <p class="text-sm text-white/90 line-clamp-2 leading-relaxed">
                        {{ $course->description }}
                    </p>
                    @endif
                </div>

                {{-- Wave Divider --}}
                <div class="absolute bottom-0 left-0 right-0">
                    <svg viewBox="0 0 1200 120" preserveAspectRatio="none" class="w-full h-8">
                        <path d="M321.39,56.44c58-10.79,114.16-30.13,172-41.86,82.39-16.72,168.19-17.73,250.45-.39C823.78,31,906.67,72,985.66,92.83c70.05,18.48,146.53,26.09,214.34,3V0H0V27.35A600.21,600.21,0,0,0,321.39,56.44Z" class="fill-white dark:fill-gray-800"></path>
                    </svg>
                </div>
            </div>

            {{-- Stats Section - Simplified Design --}}
            <div class="px-6 py-4 -mt-4 relative z-10">
                <div class="flex items-center justify-around gap-2 bg-gray-50 dark:bg-gray-700/50 rounded-xl p-3 border border-gray-200 dark:border-gray-600">
                    {{-- Batches --}}
                    <div class="text-center flex-1">
                        <div class="text-2xl font-bold text-purple-600 dark:text-purple-400">{{ $course->batches_count }}</div>
                        <div class="text-xs text-gray-600 dark:text-gray-400 font-medium">Batches</div>
                    </div>
                    
                    {{-- Divider --}}
                    <div class="w-px h-10 bg-gray-300 dark:bg-gray-600"></div>
                    
                    {{-- Students --}}
                    <div class="text-center flex-1">
                        <div class="text-2xl font-bold text-emerald-600 dark:text-emerald-400">{{ $course->enrollments_count }}</div>
                        <div class="text-xs text-gray-600 dark:text-gray-400 font-medium">Students</div>
                    </div>
                    
                    {{-- Divider --}}
                    <div class="w-px h-10 bg-gray-300 dark:bg-gray-600"></div>
                    
                    {{-- Subjects --}}
                    <div class="text-center flex-1">
                        <div class="text-2xl font-bold text-orange-600 dark:text-orange-400">{{ $course->subjects_count }}</div>
                        <div class="text-xs text-gray-600 dark:text-gray-400 font-medium">Subjects</div>
                    </div>
                </div>
            </div>

            {{-- Course Details --}}
            <div class="px-6 pb-4">
                <div class="space-y-2">
                    {{-- Duration --}}
                    @if($course->duration)
                    <div class="flex items-center gap-3 p-2 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors">
                        <div class="w-8 h-8 bg-blue-100 dark:bg-blue-900/30 rounded-lg flex items-center justify-center flex-shrink-0">
                            <svg class="w-4 h-4 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-xs text-gray-500 dark:text-gray-400">Duration</p>
                            <p class="text-sm font-semibold text-gray-900 dark:text-white truncate">{{ $course->duration }}</p>
                        </div>
                    </div>
                    @endif
                    
                    {{-- Price --}}
                    @if($course->price)
                    <div class="flex items-center gap-3 p-2 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors">
                        <div class="w-8 h-8 bg-green-100 dark:bg-green-900/30 rounded-lg flex items-center justify-center flex-shrink-0">
                            <svg class="w-4 h-4 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                            </svg>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-xs text-gray-500 dark:text-gray-400">Price</p>
                            <p class="text-sm font-semibold text-gray-900 dark:text-white">${{ number_format($course->price, 2) }}</p>
                        </div>
                    </div>
                    @endif
                    
                    {{-- Created Date --}}
                    <div class="flex items-center gap-3 p-2 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors">
                        <div class="w-8 h-8 bg-gray-100 dark:bg-gray-700 rounded-lg flex items-center justify-center flex-shrink-0">
                            <svg class="w-4 h-4 text-gray-600 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-xs text-gray-500 dark:text-gray-400">Created</p>
                            <p class="text-sm font-semibold text-gray-900 dark:text-white">{{ $course->created_at->format('M d, Y') }}</p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Actions --}}
            <div class="px-6 py-4 bg-gradient-to-r from-gray-50 to-gray-100 dark:from-gray-700/50 dark:to-gray-700/30 border-t border-gray-200 dark:border-gray-600">
                <div class="flex gap-2">
                    <a href="{{ route('partner.courses.show', $course) }}" 
                       class="flex-1 inline-flex items-center justify-center gap-2 bg-white dark:bg-gray-700 hover:bg-blue-50 dark:hover:bg-blue-900/20 text-gray-700 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400 font-semibold px-4 py-2.5 rounded-xl transition-all duration-200 border-2 border-gray-200 dark:border-gray-600 hover:border-blue-500 dark:hover:border-blue-400 shadow-sm hover:shadow-md">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                        </svg>
                        View
                    </a>
                    <a href="{{ route('partner.courses.edit', $course) }}" 
                       class="flex-1 inline-flex items-center justify-center gap-2 bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 text-white font-semibold px-4 py-2.5 rounded-xl transition-all duration-200 shadow-md hover:shadow-lg hover:scale-105">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                        </svg>
                        Edit
                    </a>
                </div>
            </div>
        </div>
        @empty
        <div class="col-span-full text-center py-16">
            <div class="w-24 h-24 bg-slate-100 dark:bg-slate-800 rounded-full flex items-center justify-center mx-auto mb-6">
                <svg class="w-12 h-12 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                </svg>
            </div>
            <h3 class="text-xl font-bold text-slate-900 dark:text-white mb-2">No Courses Found</h3>
            <p class="text-slate-500 dark:text-slate-400 mb-6">Get started by creating your first course.</p>
            <a href="{{ route('partner.courses.create') }}" 
               class="inline-flex items-center gap-2 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white font-semibold px-6 py-3 rounded-xl transition-all duration-200 hover:scale-105 shadow-lg hover:shadow-xl">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                </svg>
                Create First Course
            </a>
        </div>
        @endforelse
    </div>

    {{-- Pagination --}}
    @if($courses->hasPages())
    <div class="mt-8">
        <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-lg border border-slate-200 dark:border-slate-700 p-6">
            {{ $courses->links() }}
        </div>
    </div>
    @endif
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('searchInput');
    const filterSelect = document.getElementById('filterSelect');
    const courseCards = document.querySelectorAll('[data-course-name]');
    
    function filterCourses() {
        const searchTerm = searchInput.value.toLowerCase();
        const filterValue = filterSelect.value;
        
        courseCards.forEach(card => {
            const courseName = card.dataset.courseName.toLowerCase();
            const courseCode = card.dataset.courseCode.toLowerCase();
            const courseDescription = card.dataset.courseDescription?.toLowerCase() || '';
            
            const matchesSearch = courseName.includes(searchTerm) || 
                                courseCode.includes(searchTerm) || 
                                courseDescription.includes(searchTerm);
            
            let matchesFilter = true;
            if (filterValue === 'recent') {
                // Show only courses created in last 30 days
                const createdDate = new Date(card.dataset.createdAt);
                const thirtyDaysAgo = new Date();
                thirtyDaysAgo.setDate(thirtyDaysAgo.getDate() - 30);
                matchesFilter = createdDate > thirtyDaysAgo;
            } else if (filterValue === 'popular') {
                // Show courses with most enrollments
                const enrollments = parseInt(card.dataset.enrollmentsCount);
                matchesFilter = enrollments > 0;
            } else if (filterValue === 'batches') {
                // Show courses with most batches
                const batches = parseInt(card.dataset.batchesCount);
                matchesFilter = batches > 0;
            }
            
            if (matchesSearch && matchesFilter) {
                card.style.display = 'block';
            } else {
                card.style.display = 'none';
            }
        });
    }
    
    searchInput.addEventListener('input', filterCourses);
    filterSelect.addEventListener('change', filterCourses);
});
</script>
@endsection