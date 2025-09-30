@extends('layouts.partner-layout')

@section('title', 'Courses')

@section('content')
<!-- Mobile-First Courses View -->
<div class="min-h-screen bg-gradient-to-br from-gray-50 via-white to-gray-50 dark:from-gray-900 dark:via-gray-900 dark:to-gray-800">
    <!-- Sticky Header - Mobile Optimized -->
    <div class="sticky top-0 z-20 bg-white/95 dark:bg-gray-900/95 backdrop-blur-lg border-b border-gray-200 dark:border-gray-700 shadow-sm">
        <div class="px-4 py-4 sm:px-6 lg:px-8">
            <!-- Title & Action Row -->
            <div class="flex items-center justify-between gap-3 mb-4">
                <div class="flex-1 min-w-0">
                    <h1 class="text-xl sm:text-2xl lg:text-3xl font-extrabold text-gray-900 dark:text-white flex items-center gap-2">
                        <span class="inline-flex items-center justify-center w-10 h-10 sm:w-12 sm:h-12 bg-gradient-to-br from-orange-500 to-pink-500 rounded-xl shadow-lg">
                            <svg class="w-5 h-5 sm:w-6 sm:h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                            </svg>
                        </span>
                        <span class="truncate">Courses</span>
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
            <!-- Courses List Container -->
            <div id="coursesContainer" class="space-y-3">
                @foreach($courses as $course)
                    @php
                        $colors = [
                            ['gradient' => 'from-purple-500 to-pink-500', 'bg' => 'bg-purple-50 dark:bg-purple-900/20', 'text' => 'text-purple-600 dark:text-purple-400', 'border' => 'border-purple-200 dark:border-purple-800', 'icon' => 'bg-purple-100 dark:bg-purple-900/50'],
                            ['gradient' => 'from-blue-500 to-cyan-500', 'bg' => 'bg-blue-50 dark:bg-blue-900/20', 'text' => 'text-blue-600 dark:text-blue-400', 'border' => 'border-blue-200 dark:border-blue-800', 'icon' => 'bg-blue-100 dark:bg-blue-900/50'],
                            ['gradient' => 'from-green-500 to-emerald-500', 'bg' => 'bg-green-50 dark:bg-green-900/20', 'text' => 'text-green-600 dark:text-green-400', 'border' => 'border-green-200 dark:border-green-800', 'icon' => 'bg-green-100 dark:bg-green-900/50'],
                            ['gradient' => 'from-orange-500 to-red-500', 'bg' => 'bg-orange-50 dark:bg-orange-900/20', 'text' => 'text-orange-600 dark:text-orange-400', 'border' => 'border-orange-200 dark:border-orange-800', 'icon' => 'bg-orange-100 dark:bg-orange-900/50'],
                            ['gradient' => 'from-indigo-500 to-purple-500', 'bg' => 'bg-indigo-50 dark:bg-indigo-900/20', 'text' => 'text-indigo-600 dark:text-indigo-400', 'border' => 'border-indigo-200 dark:border-indigo-800', 'icon' => 'bg-indigo-100 dark:bg-indigo-900/50'],
                            ['gradient' => 'from-pink-500 to-rose-500', 'bg' => 'bg-pink-50 dark:bg-pink-900/20', 'text' => 'text-pink-600 dark:text-pink-400', 'border' => 'border-pink-200 dark:border-pink-800', 'icon' => 'bg-pink-100 dark:bg-pink-900/50'],
                        ];
                        $color = $colors[$loop->index % count($colors)];
                    @endphp
                    
                    <!-- List Item -->
                    <div class="course-card group" 
                         data-name="{{ strtolower($course->name) }}" 
                         data-code="{{ strtolower($course->code) }}"
                         data-subjects="{{ $course->subjects_count }}">
                        <div class="relative bg-white dark:bg-gray-800 rounded-xl border {{ $color['border'] }} shadow-sm hover:shadow-lg transition-all duration-300 overflow-hidden">
                            <!-- Gradient Left Bar -->
                            <div class="absolute left-0 top-0 bottom-0 w-1 bg-gradient-to-b {{ $color['gradient'] }}"></div>
                            
                            <!-- Content -->
                            <div class="flex flex-col sm:flex-row items-start sm:items-center gap-4 p-4 pl-5">
                                <!-- Icon -->
                                <div class="flex-shrink-0 w-12 h-12 {{ $color['icon'] }} rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                                    <svg class="w-6 h-6 {{ $color['text'] }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                    </svg>
                                </div>
                                
                                <!-- Course Info -->
                                <div class="flex-1 min-w-0">
                                    <div class="flex flex-col sm:flex-row sm:items-center gap-2 mb-1">
                                        <h3 class="text-base sm:text-lg font-bold text-gray-900 dark:text-white group-hover:{{ $color['text'] }} transition-colors duration-300">
                                            {{ $course->name }}
                                        </h3>
                                        <span class="inline-flex items-center gap-1 px-2 py-0.5 {{ $color['bg'] }} {{ $color['text'] }} rounded-md text-xs font-semibold w-fit">
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                                            </svg>
                                            {{ $course->code }}
                                        </span>
                                    </div>
                                    @if($course->description)
                                        <p class="text-sm text-gray-600 dark:text-gray-400 line-clamp-1 mb-2">
                                            {{ $course->description }}
                                        </p>
                                    @endif
                                    <!-- Stats Badge -->
                                    <div class="inline-flex items-center gap-1.5 px-2.5 py-1 {{ $color['bg'] }} rounded-lg">
                                        <svg class="w-4 h-4 {{ $color['text'] }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                        </svg>
                                        <span class="text-xs font-semibold {{ $color['text'] }}">{{ $course->subjects_count }} {{ Str::plural('Subject', $course->subjects_count) }}</span>
                                    </div>
                                </div>

                                <!-- Actions -->
                                <div class="flex flex-wrap sm:flex-nowrap gap-2 w-full sm:w-auto">
                                    <a href="{{ route('partner.courses.show', $course) }}" 
                                       class="flex-1 sm:flex-initial inline-flex items-center justify-center gap-1.5 px-3 py-2 bg-gradient-to-r {{ $color['gradient'] }} text-white rounded-lg text-xs font-semibold hover:shadow-lg transition-all duration-300 active:scale-95 touch-manipulation whitespace-nowrap">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                        </svg>
                                        View
                                    </a>
                                    <a href="{{ route('partner.courses.edit', $course) }}" 
                                       class="flex-1 sm:flex-initial inline-flex items-center justify-center gap-1.5 px-3 py-2 bg-gradient-to-r from-emerald-500 to-green-500 text-white rounded-lg text-xs font-semibold hover:shadow-lg transition-all duration-300 active:scale-95 touch-manipulation whitespace-nowrap">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                        </svg>
                                        Edit
                                    </a>
                                    <form action="{{ route('partner.courses.destroy', $course) }}" method="POST" class="flex-1 sm:flex-initial inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                                class="w-full inline-flex items-center justify-center gap-1.5 px-3 py-2 bg-gradient-to-r from-red-500 to-pink-500 text-white rounded-lg text-xs font-semibold hover:shadow-lg transition-all duration-300 active:scale-95 touch-manipulation whitespace-nowrap">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                            </svg>
                                            Delete
                                        </button>
                                    </form>
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
            <!-- Empty State -->
            <div class="flex items-center justify-center min-h-[60vh]">
                <div class="text-center max-w-md mx-auto px-4">
                    <!-- Animated Icon -->
                    <div class="relative inline-block mb-6">
                        <div class="absolute inset-0 bg-gradient-to-r from-orange-400 to-pink-400 rounded-full blur-2xl opacity-30 animate-pulse"></div>
                        <div class="relative w-24 h-24 sm:w-32 sm:h-32 bg-gradient-to-br from-orange-100 to-pink-100 dark:from-orange-900/30 dark:to-pink-900/30 rounded-3xl flex items-center justify-center shadow-xl">
                            <svg class="w-12 h-12 sm:w-16 sm:h-16 text-orange-600 dark:text-orange-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                            </svg>
                        </div>
                    </div>
                    
                    <h3 class="text-2xl sm:text-3xl font-bold text-gray-900 dark:text-white mb-3">
                        No Courses Yet
                    </h3>
                    <p class="text-sm sm:text-base text-gray-600 dark:text-gray-400 mb-8">
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

<!-- Styles -->
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

</style>

@endsection
