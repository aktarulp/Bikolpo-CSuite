@extends('layouts.partner-layout')

@section('title', 'Subject Details - ' . $subject->name)

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-50 via-white to-gray-50 dark:from-gray-900 dark:via-gray-900 dark:to-gray-800">
    <!-- Header Section -->
    <div class="bg-gradient-to-r from-indigo-500 via-purple-500 to-pink-500 text-white px-4 py-8 sm:px-6 lg:px-8 shadow-lg">
        <div class="max-w-7xl mx-auto">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div class="flex-1">
                    <div class="flex items-center gap-3 mb-2">
                        <a href="{{ route('partner.subjects.index') }}" 
                           class="inline-flex items-center justify-center w-10 h-10 rounded-lg bg-white/20 hover:bg-white/30 transition-all duration-200">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                            </svg>
                        </a>
                        <div class="flex items-center gap-3">
                            <div class="w-12 h-12 bg-white/20 backdrop-blur-sm rounded-xl flex items-center justify-center">
                                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                </svg>
                            </div>
                            <div>
                                <h1 class="text-2xl sm:text-3xl lg:text-4xl font-bold">{{ $subject->name }}</h1>
                                <div class="flex flex-wrap items-center gap-2 mt-1">
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-white/20 backdrop-blur-sm rounded-lg text-sm font-semibold">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                                        </svg>
                                        {{ $subject->code }}
                                    </span>
                                    @if($subject->course)
                                        <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-white/20 backdrop-blur-sm rounded-lg text-sm font-semibold">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                            </svg>
                                            {{ $subject->course->name }}
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="flex gap-2">
                    <a href="{{ route('partner.subjects.edit', $subject) }}" 
                       class="inline-flex items-center justify-center gap-2 px-4 py-2.5 bg-white text-indigo-600 rounded-lg font-semibold hover:bg-white/90 transition-all duration-200 shadow-lg">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                        </svg>
                        <span class="hidden sm:inline">Edit Subject</span>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 -mt-6 mb-6">
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
            <!-- Topics Count -->
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-5 border-l-4 border-indigo-500">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Total Topics</p>
                        <p class="text-3xl font-bold text-gray-900 dark:text-white mt-1">{{ $subject->topics->count() }}</p>
                    </div>
                    <div class="w-12 h-12 bg-indigo-100 dark:bg-indigo-900/30 rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6 text-indigo-600 dark:text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Chapters Count -->
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-5 border-l-4 border-purple-500">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Chapters</p>
                        <p class="text-3xl font-bold text-gray-900 dark:text-white mt-1">{{ $subject->topics->whereNotNull('chapter_number')->count() }}</p>
                    </div>
                    <div class="w-12 h-12 bg-purple-100 dark:bg-purple-900/30 rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 20l4-16m2 16l4-16M6 9h14M4 15h14"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Course Info -->
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-5 border-l-4 border-pink-500">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Course</p>
                        <p class="text-lg font-bold text-gray-900 dark:text-white mt-1 truncate">
                            {{ $subject->course?->name ?? 'Not Assigned' }}
                        </p>
                    </div>
                    <div class="w-12 h-12 bg-pink-100 dark:bg-pink-900/30 rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6 text-pink-600 dark:text-pink-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                        </svg>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-8">
        <!-- Description Card -->
        @if($subject->description)
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg overflow-hidden mb-6">
            <div class="bg-gradient-to-r from-indigo-50 to-purple-50 dark:from-indigo-900/20 dark:to-purple-900/20 px-6 py-4 border-b border-indigo-100 dark:border-indigo-800">
                <h2 class="text-xl font-bold text-gray-900 dark:text-white flex items-center gap-2">
                    <svg class="w-6 h-6 text-indigo-600 dark:text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    About This Subject
                </h2>
            </div>
            <div class="p-6">
                <p class="text-gray-700 dark:text-gray-300 leading-relaxed">{{ $subject->description }}</p>
            </div>
        </div>
        @endif

        <!-- Topics List -->
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg overflow-hidden">
            <div class="bg-gradient-to-r from-purple-500 to-pink-500 px-6 py-4">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                    <h2 class="text-xl font-bold text-white flex items-center gap-2">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        Topics & Chapters ({{ $subject->topics->count() }})
                    </h2>
                    <a href="{{ route('partner.topics.create') }}" 
                       class="inline-flex items-center justify-center gap-2 px-4 py-2 bg-white text-purple-600 rounded-lg font-semibold hover:bg-white/90 transition-all duration-200 shadow-lg">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                        </svg>
                        <span>Add Topic</span>
                    </a>
                </div>
            </div>

            <div class="p-6">
                @forelse($subject->topics->sortBy('chapter_number') as $index => $topic)
                    @php
                        // Vibrant color schemes for topic cards
                        $colors = [
                            ['bg' => 'from-blue-50 to-cyan-50', 'border' => 'border-blue-500', 'badge' => 'bg-blue-100 text-blue-800', 'chapter' => 'bg-blue-500', 'icon' => 'text-blue-600'],
                            ['bg' => 'from-purple-50 to-pink-50', 'border' => 'border-purple-500', 'badge' => 'bg-purple-100 text-purple-800', 'chapter' => 'bg-purple-500', 'icon' => 'text-purple-600'],
                            ['bg' => 'from-green-50 to-emerald-50', 'border' => 'border-green-500', 'badge' => 'bg-green-100 text-green-800', 'chapter' => 'bg-green-500', 'icon' => 'text-green-600'],
                            ['bg' => 'from-orange-50 to-amber-50', 'border' => 'border-orange-500', 'badge' => 'bg-orange-100 text-orange-800', 'chapter' => 'bg-orange-500', 'icon' => 'text-orange-600'],
                            ['bg' => 'from-pink-50 to-rose-50', 'border' => 'border-pink-500', 'badge' => 'bg-pink-100 text-pink-800', 'chapter' => 'bg-pink-500', 'icon' => 'text-pink-600'],
                            ['bg' => 'from-indigo-50 to-blue-50', 'border' => 'border-indigo-500', 'badge' => 'bg-indigo-100 text-indigo-800', 'chapter' => 'bg-indigo-500', 'icon' => 'text-indigo-600'],
                        ];
                        $color = $colors[$index % count($colors)];
                    @endphp

                    <div class="group bg-gradient-to-r {{ $color['bg'] }} dark:from-gray-700 dark:to-gray-800 rounded-xl border-l-4 {{ $color['border'] }} p-5 mb-4 hover:shadow-lg transition-all duration-300 hover:-translate-y-1">
                        <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-4">
                            <div class="flex-1">
                                <div class="flex items-start gap-3 mb-3">
                                    @if($topic->chapter_number)
                                        <div class="flex-shrink-0 w-10 h-10 {{ $color['chapter'] }} rounded-full flex items-center justify-center text-white font-bold shadow-lg">
                                            {{ $topic->chapter_number }}
                                        </div>
                                    @else
                                        <div class="flex-shrink-0 w-10 h-10 bg-gray-400 rounded-full flex items-center justify-center text-white shadow-lg">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                            </svg>
                                        </div>
                                    @endif
                                    <div class="flex-1">
                                        <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-1">{{ $topic->name }}</h3>
                                        <div class="flex flex-wrap items-center gap-2">
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold {{ $color['badge'] }} dark:bg-opacity-20">
                                                {{ $topic->code }}
                                            </span>
                                            @if($topic->chapter_number)
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300">
                                                    Chapter {{ $topic->chapter_number }}
                                                </span>
                                            @endif
                                        </div>
                                        @if($topic->description)
                                            <p class="text-sm text-gray-600 dark:text-gray-400 mt-2 line-clamp-2">{{ $topic->description }}</p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="flex flex-wrap sm:flex-col gap-2">
                                <a href="{{ route('partner.topics.show', $topic) }}" 
                                   class="inline-flex items-center justify-center gap-2 px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg text-sm font-semibold shadow-md hover:shadow-lg transition-all duration-200 active:scale-95">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                    </svg>
                                    View
                                </a>
                                <a href="{{ route('partner.topics.edit', $topic) }}" 
                                   class="inline-flex items-center justify-center gap-2 px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg text-sm font-semibold shadow-md hover:shadow-lg transition-all duration-200 active:scale-95">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                    </svg>
                                    Edit
                                </a>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-12">
                        <div class="w-20 h-20 bg-gradient-to-br from-purple-100 to-pink-100 dark:from-purple-900/20 dark:to-pink-900/20 rounded-full flex items-center justify-center mx-auto mb-4">
                            <svg class="w-10 h-10 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2">No Topics Yet</h3>
                        <p class="text-gray-600 dark:text-gray-400 mb-6">Start organizing your subject by adding topics and chapters.</p>
                        <a href="{{ route('partner.topics.create') }}" 
                           class="inline-flex items-center gap-2 px-6 py-3 bg-gradient-to-r from-purple-600 to-pink-600 hover:from-purple-700 hover:to-pink-700 text-white rounded-xl font-semibold shadow-lg hover:shadow-xl transition-all duration-200 transform hover:scale-105">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                            </svg>
                            Add Your First Topic
                        </a>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection


