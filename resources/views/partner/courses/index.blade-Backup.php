@extends('layouts.partner-layout')

@section('title', 'Courses')

@section('content')
<!-- Mobile-First Courses Grid View -->
<div class="min-h-screen bg-gradient-to-br from-gray-50 via-white to-gray-50 dark:from-gray-900 dark:via-gray-900 dark:to-gray-800">
    <!-- Enhanced Sticky Header with Search & Filter -->
    <div class="sticky top-0 z-20 bg-white/95 dark:bg-gray-900/95 backdrop-blur-lg border-b border-gray-200 dark:border-gray-700 shadow-sm">
        <div class="px-4 py-4 sm:px-6 lg:px-8">
            <!-- Title & Action Row -->
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-4">
                <div class="flex-1 min-w-0">
                    <h1 class="text-2xl sm:text-3xl font-bold text-gray-900 dark:text-white">
                        Courses
                    </h1>
                    <p class="text-xs sm:text-sm text-gray-500 dark:text-gray-400 mt-1">
                        <span class="inline-flex items-center gap-1">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                            </svg>
                            {{ $courses->total() }} {{ Str::plural('course', $courses->total()) }}
                        </span>
                    </p>
                </div>
                <a href="{{ route('partner.courses.create') }}" 
                   class="flex-shrink-0 inline-flex items-center justify-center gap-2 px-4 py-2.5 sm:px-6 sm:py-3 bg-gradient-to-r from-orange-600 to-pink-600 hover:from-orange-700 hover:to-pink-700 text-white text-sm sm:text-base font-semibold rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 active:scale-95 touch-manipulation">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    <span class="hidden sm:inline">Add Course</span>
                </a>
            </div>
            
            <!-- Search & Filter Bar -->
            <div class="flex flex-col sm:flex-row gap-3">
                <!-- Search Input -->
                <div class="flex-1 relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </div>
                    <input type="text" 
                           id="courseSearch"
                           placeholder="Search courses by name or code..."
                           class="block w-full pl-10 pr-3 py-2.5 border border-gray-300 dark:border-gray-600 rounded-xl bg-white dark:bg-gray-800 text-gray-900 dark:text-white placeholder-gray-500 dark:placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent transition-all duration-200">
                </div>
                
                <!-- Filter Dropdown -->
                <div class="sm:w-48 relative" x-data="{ open: false }">
                    <button @click="open = !open" 
                            @click.away="open = false"
                            class="w-full inline-flex items-center justify-between gap-2 px-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-xl bg-white dark:bg-gray-800 text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent transition-all duration-200">
                        <span class="text-sm font-medium">Filter by</span>
                        <svg class="w-4 h-4 transform transition-transform duration-200" :class="{ 'rotate-180': open }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </button>
                    
                    <div x-show="open" 
                         x-transition:enter="transition ease-out duration-200"
                         x-transition:enter-start="opacity-0 transform scale-95 -translate-y-1"
                         x-transition:enter-end="opacity-100 transform scale-100 translate-y-0"
                         x-transition:leave="transition ease-in duration-150"
                         x-transition:leave-start="opacity-100 transform scale-100 translate-y-0"
                         x-transition:leave-end="opacity-0 transform scale-95 -translate-y-1"
                         class="absolute right-0 mt-2 w-56 bg-white dark:bg-gray-800 rounded-lg shadow-lg border border-gray-200 dark:border-gray-700 z-50 overflow-hidden">
                        <div class="p-2">
                            <button class="w-full text-left px-3 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-md transition-colors duration-150">
                                All Courses
                            </button>
                            <button class="w-full text-left px-3 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-md transition-colors duration-150">
                                Most Subjects
                            </button>
                            <button class="w-full text-left px-3 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-md transition-colors duration-150">
                                Recently Added
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="px-4 py-6 sm:px-6 lg:px-8">
        <!-- Success Message -->
        @if(session('success'))
        <div class="mb-4 bg-gradient-to-r from-green-50 to-emerald-50 dark:from-green-900/20 dark:to-emerald-900/20 border-l-4 border-green-500 rounded-xl p-4 shadow-lg animate-fade-in">
            <div class="flex items-start gap-3">
                <div class="flex-shrink-0">
                    <svg class="w-6 h-6 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div class="flex-1">
                    <p class="text-green-800 dark:text-green-300 font-semibold">{{ session('success') }}</p>
                </div>
                <button onclick="this.parentElement.parentElement.remove()" class="flex-shrink-0 text-green-600 hover:text-green-800 dark:text-green-400 dark:hover:text-green-200">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
        </div>
        @endif

        <!-- Error Message -->
        @if(session('error'))
        <div class="mb-4 bg-gradient-to-r from-red-50 to-pink-50 dark:from-red-900/20 dark:to-pink-900/20 border-l-4 border-red-500 rounded-xl p-4 shadow-lg animate-fade-in">
            <div class="flex items-start gap-3">
                <div class="flex-shrink-0">
                    <svg class="w-6 h-6 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div class="flex-1">
                    <p class="text-red-800 dark:text-red-300 font-semibold">{{ session('error') }}</p>
                </div>
                <button onclick="this.parentElement.parentElement.remove()" class="flex-shrink-0 text-red-600 hover:text-red-800 dark:text-red-400 dark:hover:text-red-200">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
        </div>
        @endif

        @if($courses->count() > 0)
            <!-- Courses Grid Container -->
            <div id="coursesContainer" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4 sm:gap-5 lg:gap-6">
                @foreach($courses as $course)
                    @php
                        $colors = [
                            ['gradient' => 'from-purple-500 to-pink-500', 'bg' => 'bg-purple-50 dark:bg-purple-900/20', 'text' => 'text-purple-600 dark:text-purple-400', 'border' => 'border-purple-200 dark:border-purple-800', 'icon' => 'bg-purple-100 dark:bg-purple-900/50', 'hover' => 'hover:bg-purple-50 dark:hover:bg-purple-900/30'],
                            ['gradient' => 'from-blue-500 to-cyan-500', 'bg' => 'bg-blue-50 dark:bg-blue-900/20', 'text' => 'text-blue-600 dark:text-blue-400', 'border' => 'border-blue-200 dark:border-blue-800', 'icon' => 'bg-blue-100 dark:bg-blue-900/50', 'hover' => 'hover:bg-blue-50 dark:hover:bg-blue-900/30'],
                            ['gradient' => 'from-green-500 to-emerald-500', 'bg' => 'bg-green-50 dark:bg-green-900/20', 'text' => 'text-green-600 dark:text-green-400', 'border' => 'border-green-200 dark:border-green-800', 'icon' => 'bg-green-100 dark:bg-green-900/50', 'hover' => 'hover:bg-green-50 dark:hover:bg-green-900/30'],
                            ['gradient' => 'from-orange-500 to-red-500', 'bg' => 'bg-orange-50 dark:bg-orange-900/20', 'text' => 'text-orange-600 dark:text-orange-400', 'border' => 'border-orange-200 dark:border-orange-800', 'icon' => 'bg-orange-100 dark:bg-orange-900/50', 'hover' => 'hover:bg-orange-50 dark:hover:bg-orange-900/30'],
                            ['gradient' => 'from-indigo-500 to-purple-500', 'bg' => 'bg-indigo-50 dark:bg-indigo-900/20', 'text' => 'text-indigo-600 dark:text-indigo-400', 'border' => 'border-indigo-200 dark:border-indigo-800', 'icon' => 'bg-indigo-100 dark:bg-indigo-900/50', 'hover' => 'hover:bg-indigo-50 dark:hover:bg-indigo-900/30'],
                            ['gradient' => 'from-pink-500 to-rose-500', 'bg' => 'bg-pink-50 dark:bg-pink-900/20', 'text' => 'text-pink-600 dark:text-pink-400', 'border' => 'border-pink-200 dark:border-pink-800', 'icon' => 'bg-pink-100 dark:bg-pink-900/50', 'hover' => 'hover:bg-pink-50 dark:hover:bg-pink-900/30'],
                        ];
                        $color = $colors[$loop->index % count($colors)];
                    @endphp
                    
                    <!-- Grid Card -->
                    <div class="course-card group" 
                         data-name="{{ strtolower($course->name) }}" 
                         data-code="{{ strtolower($course->code) }}"
                         data-subjects="{{ $course->subjects_count }}">
                        <div class="relative bg-white dark:bg-gray-800 rounded-2xl border {{ $color['border'] }} shadow-sm hover:shadow-xl transition-all duration-300 overflow-hidden transform hover:-translate-y-1">
                            <!-- Gradient Top Bar -->
                            <div class="absolute top-0 left-0 right-0 h-1 bg-gradient-to-r {{ $color['gradient'] }}"></div>
                            
                            <!-- Card Content -->
                            <div class="p-5 pt-6">
                                <!-- Icon & Header -->
                                <div class="flex items-start justify-between mb-4">
                                    <div class="w-12 h-12 {{ $color['icon'] }} rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                                        <svg class="w-6 h-6 {{ $color['text'] }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                        </svg>
                                    </div>
                                    
                                    <!-- Course Code Badge -->
                                    <span class="inline-flex items-center gap-1 px-2 py-1 {{ $color['bg'] }} {{ $color['text'] }} rounded-lg text-xs font-semibold">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                                        </svg>
                                        {{ $course->code }}
                                    </span>
                                </div>
                                
                                <!-- Course Name -->
                                <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-2 group-hover:{{ $color['text'] }} transition-colors duration-300 line-clamp-2">
                                    {{ $course->name }}
                                </h3>
                                
                                <!-- Description -->
                                @if($course->description)
                                    <p class="text-sm text-gray-600 dark:text-gray-400 mb-4 line-clamp-2">
                                        {{ $course->description }}
                                    </p>
                                @endif
                                
                                <!-- Stats Badge -->
                                <div class="inline-flex items-center gap-2 px-3 py-2 {{ $color['bg'] }} rounded-xl mb-4">
                                    <svg class="w-4 h-4 {{ $color['text'] }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                    </svg>
                                    <span class="text-sm font-semibold {{ $color['text'] }}">{{ $course->subjects_count }} {{ Str::plural('Subject', $course->subjects_count) }}</span>
                                </div>
                                
                                <!-- Action Buttons -->
                                <div class="flex gap-2">
                                    <a href="{{ route('partner.courses.show', $course) }}" 
                                       class="flex-1 inline-flex items-center justify-center gap-1.5 px-3 py-2.5 bg-gradient-to-r {{ $color['gradient'] }} text-white rounded-xl text-xs font-semibold hover:shadow-lg transition-all duration-300 active:scale-95 touch-manipulation">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                        </svg>
                                        View
                                    </a>
                                    <div class="flex gap-2">
                                        <a href="{{ route('partner.courses.edit', $course) }}" 
                                           class="inline-flex items-center justify-center gap-1 px-3 py-2.5 bg-gradient-to-r from-emerald-500 to-green-500 text-white rounded-xl text-xs font-semibold hover:shadow-lg transition-all duration-300 active:scale-95 touch-manipulation">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                            </svg>
                                        </a>
                                        <form action="{{ route('partner.courses.destroy', $course) }}" method="POST" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" 
                                                    class="inline-flex items-center justify-center gap-1 px-3 py-2.5 bg-gradient-to-r from-red-500 to-pink-500 text-white rounded-xl text-xs font-semibold hover:shadow-lg transition-all duration-300 active:scale-95 touch-manipulation">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="mt-8 bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-4">
                {{ $courses->links() }}
            </div>
        @else
            <!-- Enhanced Empty State -->
            <div class="flex items-center justify-center min-h-[60vh]">
                <div class="text-center max-w-md mx-auto px-4">
                    <!-- Animated Icon Container -->
                    <div class="relative inline-block mb-8">
                        <div class="absolute inset-0 bg-gradient-to-r from-orange-400 to-pink-400 rounded-full blur-3xl opacity-20 animate-pulse"></div>
                        <div class="relative w-32 h-32 sm:w-40 sm:h-40 bg-gradient-to-br from-orange-100 via-pink-100 to-purple-100 dark:from-orange-900/20 dark:via-pink-900/20 dark:to-purple-900/20 rounded-3xl flex items-center justify-center shadow-2xl transform hover:scale-105 transition-transform duration-300">
                            <svg class="w-16 h-16 sm:w-20 sm:h-20 text-orange-600 dark:text-orange-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                            </svg>
                        </div>
                    </div>
                    
                    <h3 class="text-2xl sm:text-3xl font-bold text-gray-900 dark:text-white mb-4">
                        No Courses Yet
                    </h3>
                    <p class="text-sm sm:text-base text-gray-600 dark:text-gray-400 mb-8 leading-relaxed">
                        Start building your academic catalog by creating your first course. Add subjects, topics, and questions to get started.
                    </p>
                    
                    <a href="{{ route('partner.courses.create') }}" 
                       class="inline-flex items-center justify-center gap-2 px-8 py-4 bg-gradient-to-r from-orange-600 to-pink-600 hover:from-orange-700 hover:to-pink-700 text-white font-semibold rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 active:scale-95 touch-manipulation">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                        </svg>
                        <span>Create Your First Course</span>
                    </a>
                </div>
            </div>
        @endif
    </div>
</div>

<!-- Enhanced Styles & Scripts -->
<style>
/* Touch optimization */
@media (hover: none) and (pointer: coarse) {
    .touch-manipulation {
        -webkit-tap-highlight-color: transparent;
        touch-action: manipulation;
    }
}

/* Line clamp fallback */
.line-clamp-1 {
    display: -webkit-box;
    -webkit-line-clamp: 1;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

.line-clamp-2 {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

/* Fade in animation */
@keyframes fadeIn {
    from {
        opacity: 0;
        transform: translateY(-10px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.animate-fade-in {
    animation: fadeIn 0.3s ease-out;
}

/* Mobile-optimized grid */
@media (max-width: 640px) {
    .grid-cols-1 {
        grid-template-columns: repeat(1, minmax(0, 1fr));
    }
}

/* Enhanced card hover effects */
.course-card:hover {
    z-index: 10;
}

</style>

<!-- Search functionality -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('courseSearch');
    const courseCards = document.querySelectorAll('.course-card');
    
    if (searchInput && courseCards.length > 0) {
        searchInput.addEventListener('input', function(e) {
            const searchTerm = e.target.value.toLowerCase();
            
            courseCards.forEach(card => {
                const name = card.getAttribute('data-name') || '';
                const code = card.getAttribute('data-code') || '';
                
                if (name.includes(searchTerm) || code.includes(searchTerm)) {
                    card.style.display = 'block';
                } else {
                    card.style.display = 'none';
                }
            });
        });
    }
});
</script>

@endsection
