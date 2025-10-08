@extends('layouts.partner-layout')

@section('title', 'Topics')

@section('content')
<!-- Mobile-First Colorful Design -->
<div class="space-y-4 sm:space-y-6">
    <!-- Header Section -->
    <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-4">
        <div>
            <h1 class="text-2xl sm:text-3xl font-bold bg-gradient-to-r from-teal-600 via-cyan-600 to-blue-600 bg-clip-text text-transparent">
                🎯 Topics & Chapters
            </h1>
            <p class="text-sm sm:text-base text-gray-600 dark:text-gray-400 mt-1">Organize your subject content</p>
        </div>
        <a href="{{ route('partner.topics.create') }}" 
           class="group relative w-full sm:w-auto inline-flex items-center justify-center gap-2 bg-gradient-to-r from-purple-600 via-pink-600 to-rose-600 hover:from-rose-600 hover:via-pink-600 hover:to-purple-600 text-white px-6 sm:px-8 py-3.5 rounded-2xl font-bold shadow-2xl hover:shadow-purple-500/50 transition-all duration-500 transform hover:scale-110 hover:-translate-y-1 overflow-hidden">
            <span class="absolute inset-0 w-full h-full bg-gradient-to-r from-white/0 via-white/30 to-white/0 transform -skew-x-12 -translate-x-full group-hover:translate-x-full transition-transform duration-1000"></span>
            <svg class="w-5 h-5 relative z-10 group-hover:rotate-180 transition-transform duration-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"></path>
            </svg>
            <span class="relative z-10 tracking-wide">Add Topic</span>
            <div class="absolute inset-0 rounded-2xl bg-gradient-to-r from-purple-600 to-rose-600 opacity-0 group-hover:opacity-100 blur-xl transition-opacity duration-500"></div>
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

    @if($topics->count() > 0)
        <!-- List View Layout (Mobile-First) -->
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg overflow-hidden">
            <div class="divide-y divide-gray-200 dark:divide-gray-700">
            @foreach($topics as $index => $topic)
                @php
                    // Vibrant color schemes for cards
                    $colors = [
                        ['from' => 'from-teal-500', 'to' => 'to-cyan-400', 'badge' => 'bg-teal-100 text-teal-800', 'icon' => 'bg-teal-500', 'chapter' => 'bg-teal-500'],
                        ['from' => 'from-violet-500', 'to' => 'to-purple-400', 'badge' => 'bg-violet-100 text-violet-800', 'icon' => 'bg-violet-500', 'chapter' => 'bg-violet-500'],
                        ['from' => 'from-emerald-500', 'to' => 'to-green-400', 'badge' => 'bg-emerald-100 text-emerald-800', 'icon' => 'bg-emerald-500', 'chapter' => 'bg-emerald-500'],
                        ['from' => 'from-amber-500', 'to' => 'to-orange-400', 'badge' => 'bg-amber-100 text-amber-800', 'icon' => 'bg-amber-500', 'chapter' => 'bg-amber-500'],
                        ['from' => 'from-rose-500', 'to' => 'to-pink-400', 'badge' => 'bg-rose-100 text-rose-800', 'icon' => 'bg-rose-500', 'chapter' => 'bg-rose-500'],
                        ['from' => 'from-sky-500', 'to' => 'to-blue-400', 'badge' => 'bg-sky-100 text-sky-800', 'icon' => 'bg-sky-500', 'chapter' => 'bg-sky-500'],
                        ['from' => 'from-fuchsia-500', 'to' => 'to-pink-400', 'badge' => 'bg-fuchsia-100 text-fuchsia-800', 'icon' => 'bg-fuchsia-500', 'chapter' => 'bg-fuchsia-500'],
                        ['from' => 'from-lime-500', 'to' => 'to-green-400', 'badge' => 'bg-lime-100 text-lime-800', 'icon' => 'bg-lime-500', 'chapter' => 'bg-lime-500'],
                    ];
                    $color = $colors[$index % count($colors)];
                @endphp
                
                <!-- List Item -->
                <div class="group hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors duration-200">
                    <div class="p-4 sm:p-6">
                        <div class="flex flex-col lg:flex-row lg:items-center gap-4">
                            <!-- Left: Chapter Number & Topic Info -->
                            <div class="flex items-start gap-3 sm:gap-4 flex-1 min-w-0">
                                <!-- Chapter Number Badge -->
                                @if($topic->chapter_number)
                                    <div class="flex-shrink-0 w-12 h-12 sm:w-14 sm:h-14 rounded-xl {{ $color['chapter'] }} flex items-center justify-center text-white font-bold text-lg shadow-lg">
                                        {{ $topic->chapter_number }}
                                    </div>
                                @else
                                    <div class="flex-shrink-0 w-12 h-12 sm:w-14 sm:h-14 rounded-xl bg-gray-300 dark:bg-gray-600 flex items-center justify-center text-white shadow-lg">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                        </svg>
                                    </div>
                                @endif
                                
                                <!-- Topic Details -->
                                <div class="flex-1 min-w-0">
                                    <div class="flex flex-wrap items-center gap-2 mb-2">
                                        <h3 class="text-base sm:text-lg font-bold text-gray-900 dark:text-white">
                                            {{ $topic->name }}
                                        </h3>
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold {{ $color['badge'] }}">
                                            {{ $topic->code }}
                                        </span>
                                    </div>
                                    
                                    @if($topic->description)
                                        <p class="text-sm text-gray-600 dark:text-gray-400 mb-3 line-clamp-2">
                                            {{ $topic->description }}
                                        </p>
                                    @endif
                                    
                                    <!-- Subject & Course Tags -->
                                    <div class="flex flex-wrap items-center gap-2">
                                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-lg bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 text-xs font-medium">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                            </svg>
                                            {{ $topic->subject->name }}
                                        </span>
                                        
                                        @if($topic->subject->course)
                                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-lg bg-gradient-to-r {{ $color['from'] }} {{ $color['to'] }} text-white text-xs font-medium">
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                                </svg>
                                                {{ $topic->subject->course->name }}
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Right: Action Buttons -->
                            <div class="flex flex-wrap lg:flex-nowrap gap-2 lg:flex-shrink-0">
                                <a href="{{ route('partner.topics.edit', $topic) }}" 
                                   class="inline-flex items-center justify-center gap-1.5 px-3 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg text-sm font-semibold shadow-md hover:shadow-lg transition-all duration-200 active:scale-95">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                    </svg>
                                    <span class="hidden sm:inline">Edit</span>
                                </a>
                                <form action="{{ route('partner.topics.destroy', $topic) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                            class="inline-flex items-center justify-center gap-1.5 px-3 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg text-sm font-semibold shadow-md hover:shadow-lg transition-all duration-200 active:scale-95">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                        </svg>
                                        <span class="hidden sm:inline">Delete</span>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg p-4 sm:p-6">
            {{ $topics->links() }}
        </div>
    @else
        <!-- Empty State -->
        <div class="bg-gradient-to-br from-teal-50 via-cyan-50 to-blue-50 dark:from-gray-800 dark:via-gray-800 dark:to-gray-800 rounded-2xl shadow-lg p-8 sm:p-12 text-center">
            <div class="w-20 h-20 sm:w-24 sm:h-24 mx-auto mb-6 bg-gradient-to-br from-teal-500 to-cyan-500 rounded-full flex items-center justify-center shadow-xl">
                <svg class="w-10 h-10 sm:w-12 sm:h-12 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                </svg>
            </div>
            <h3 class="text-xl sm:text-2xl font-bold text-gray-900 dark:text-white mb-2">No topics yet</h3>
            <p class="text-sm sm:text-base text-gray-600 dark:text-gray-400 mb-6 max-w-md mx-auto">
                Break down your subjects into manageable topics and chapters. This helps organize your content for better learning.
            </p>
            <a href="{{ route('partner.topics.create') }}" 
               class="inline-flex items-center gap-2 px-6 py-3 bg-gradient-to-r from-teal-600 to-cyan-600 hover:from-teal-700 hover:to-cyan-700 text-white rounded-xl font-semibold shadow-lg hover:shadow-xl transition-all duration-300 transform hover:scale-105">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                <span>Add Your First Topic</span>
            </a>
        </div>
    @endif
</div>
@endsection
