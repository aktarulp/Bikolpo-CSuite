@extends('layouts.partner-layout')

@section('title', 'Subjects')

@section('content')
<!-- Mobile-First Colorful Design -->
<div class="space-y-4 sm:space-y-6">
    <!-- Header Section -->
    <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-4">
        <div>
            <h1 class="text-2xl sm:text-3xl font-bold bg-gradient-to-r from-purple-600 via-pink-600 to-red-600 bg-clip-text text-transparent">
                📚 Subjects
            </h1>
            <p class="text-sm sm:text-base text-gray-600 dark:text-gray-400 mt-1">Manage your course subjects</p>
        </div>
        <a href="{{ route('partner.subjects.create') }}" 
           class="w-full sm:w-auto inline-flex items-center justify-center gap-2 bg-gradient-to-r from-purple-600 to-pink-600 hover:from-purple-700 hover:to-pink-700 text-white px-4 sm:px-6 py-3 rounded-xl font-semibold shadow-lg hover:shadow-xl transition-all duration-300 transform hover:scale-105">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
            </svg>
            <span>Add Subject</span>
        </a>
    </div>

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

    @if($subjects->count() > 0)
        <!-- List View Layout (Mobile-First) -->
        <div class="space-y-3">
            @foreach($subjects as $index => $subject)
                @php
                    // Vibrant color schemes
                    $colors = [
                        ['gradient' => 'from-blue-500 to-cyan-400', 'bg' => 'bg-blue-50 dark:bg-blue-900/20', 'text' => 'text-blue-600 dark:text-blue-400', 'border' => 'border-blue-200 dark:border-blue-800', 'icon' => 'bg-blue-500'],
                        ['gradient' => 'from-purple-500 to-pink-400', 'bg' => 'bg-purple-50 dark:bg-purple-900/20', 'text' => 'text-purple-600 dark:text-purple-400', 'border' => 'border-purple-200 dark:border-purple-800', 'icon' => 'bg-purple-500'],
                        ['gradient' => 'from-green-500 to-emerald-400', 'bg' => 'bg-green-50 dark:bg-green-900/20', 'text' => 'text-green-600 dark:text-green-400', 'border' => 'border-green-200 dark:border-green-800', 'icon' => 'bg-green-500'],
                        ['gradient' => 'from-orange-500 to-yellow-400', 'bg' => 'bg-orange-50 dark:bg-orange-900/20', 'text' => 'text-orange-600 dark:text-orange-400', 'border' => 'border-orange-200 dark:border-orange-800', 'icon' => 'bg-orange-500'],
                        ['gradient' => 'from-red-500 to-pink-400', 'bg' => 'bg-red-50 dark:bg-red-900/20', 'text' => 'text-red-600 dark:text-red-400', 'border' => 'border-red-200 dark:border-red-800', 'icon' => 'bg-red-500'],
                        ['gradient' => 'from-indigo-500 to-purple-400', 'bg' => 'bg-indigo-50 dark:bg-indigo-900/20', 'text' => 'text-indigo-600 dark:text-indigo-400', 'border' => 'border-indigo-200 dark:border-indigo-800', 'icon' => 'bg-indigo-500'],
                    ];
                    $color = $colors[$index % count($colors)];
                @endphp
                
                <!-- List Item -->
                <div class="group bg-white dark:bg-gray-800 rounded-xl border {{ $color['border'] }} shadow-sm hover:shadow-lg transition-all duration-300 overflow-hidden">
                    <!-- Gradient Left Bar -->
                    <div class="absolute left-0 top-0 bottom-0 w-1 bg-gradient-to-b {{ $color['gradient'] }}"></div>
                    
                    <!-- Content -->
                    <div class="relative flex flex-col sm:flex-row items-start sm:items-center gap-4 p-4 pl-5">
                        <!-- Icon -->
                        <div class="flex-shrink-0 w-12 h-12 rounded-xl {{ $color['icon'] }} flex items-center justify-center text-white text-xl font-bold shadow-lg group-hover:scale-110 transition-transform duration-300">
                            {{ substr($subject->name, 0, 1) }}
                        </div>
                        
                        <!-- Subject Info -->
                        <div class="flex-1 min-w-0">
                            <div class="flex flex-col sm:flex-row sm:items-center gap-2 mb-1">
                                <h3 class="text-base sm:text-lg font-bold text-gray-900 dark:text-white group-hover:{{ $color['text'] }} transition-colors duration-300">
                                    {{ $subject->name }}
                                </h3>
                                <span class="inline-flex items-center px-2 py-0.5 {{ $color['bg'] }} {{ $color['text'] }} rounded-md text-xs font-semibold w-fit">
                                    {{ $subject->code }}
                                </span>
                            </div>
                            
                            <!-- Description & Course -->
                            <div class="flex flex-col sm:flex-row sm:items-center gap-2 mb-2">
                                @if($subject->description)
                                    <p class="text-sm text-gray-600 dark:text-gray-400 line-clamp-1">
                                        {{ $subject->description }}
                                    </p>
                                @endif
                            </div>
                            
                            <!-- Course & Topics Badge -->
                            <div class="flex flex-wrap items-center gap-2">
                                @if($subject->course)
                                    <div class="inline-flex items-center gap-1.5 px-2.5 py-1 {{ $color['bg'] }} rounded-lg">
                                        <svg class="w-3.5 h-3.5 {{ $color['text'] }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                        </svg>
                                        <span class="text-xs font-semibold {{ $color['text'] }}">{{ $subject->course->name }}</span>
                                    </div>
                                @endif
                                
                                <div class="inline-flex items-center gap-1.5 px-2.5 py-1 bg-gray-100 dark:bg-gray-700 rounded-lg">
                                    <svg class="w-3.5 h-3.5 text-gray-600 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                    </svg>
                                    <span class="text-xs font-semibold text-gray-600 dark:text-gray-400">{{ $subject->topics_count }} {{ Str::plural('Topic', $subject->topics_count) }}</span>
                                </div>
                            </div>
                        </div>

                        <!-- Actions -->
                        <div class="flex flex-wrap sm:flex-nowrap gap-2 w-full sm:w-auto">
                            <a href="{{ route('partner.subjects.edit', $subject) }}" 
                               class="flex-1 sm:flex-initial inline-flex items-center justify-center gap-1.5 px-3 py-2 bg-gradient-to-r from-emerald-500 to-green-500 text-white rounded-lg text-xs font-semibold hover:shadow-lg transition-all duration-300 active:scale-95 whitespace-nowrap">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                </svg>
                                Edit
                            </a>
                            <form action="{{ route('partner.subjects.destroy', $subject) }}" method="POST" class="flex-1 sm:flex-initial inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" 
                                        class="w-full inline-flex items-center justify-center gap-1.5 px-3 py-2 bg-gradient-to-r from-red-500 to-pink-500 text-white rounded-lg text-xs font-semibold hover:shadow-lg transition-all duration-300 active:scale-95 whitespace-nowrap">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                    </svg>
                                    Delete
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg p-4 sm:p-6">
            {{ $subjects->links() }}
        </div>
    @else
        <!-- Empty State -->
        <div class="bg-gradient-to-br from-purple-50 via-pink-50 to-red-50 dark:from-gray-800 dark:via-gray-800 dark:to-gray-800 rounded-2xl shadow-lg p-8 sm:p-12 text-center">
            <div class="w-20 h-20 sm:w-24 sm:h-24 mx-auto mb-6 bg-gradient-to-br from-purple-500 to-pink-500 rounded-full flex items-center justify-center shadow-xl">
                <svg class="w-10 h-10 sm:w-12 sm:h-12 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
            </div>
            <h3 class="text-xl sm:text-2xl font-bold text-gray-900 dark:text-white mb-2">No subjects yet</h3>
            <p class="text-sm sm:text-base text-gray-600 dark:text-gray-400 mb-6 max-w-md mx-auto">
                Start building your course structure by adding your first subject. Subjects help organize your content effectively.
            </p>
            <a href="{{ route('partner.subjects.create') }}" 
               class="inline-flex items-center gap-2 px-6 py-3 bg-gradient-to-r from-purple-600 to-pink-600 hover:from-purple-700 hover:to-pink-700 text-white rounded-xl font-semibold shadow-lg hover:shadow-xl transition-all duration-300 transform hover:scale-105">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                <span>Add Your First Subject</span>
            </a>
        </div>
    @endif
</div>

<!-- Styles -->
<style>
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
