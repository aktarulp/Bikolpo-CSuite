@extends('layouts.partner-layout')

@section('title', 'Topics')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-slate-50 via-blue-50 to-indigo-50 dark:from-gray-900 dark:via-slate-900 dark:to-indigo-950 -m-6 p-4 sm:p-6 lg:p-8">
    <div class="max-w-7xl mx-auto space-y-6">
        
        {{-- Header Section --}}
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h1 class="text-2xl sm:text-3xl lg:text-4xl font-extrabold text-gray-900 dark:text-white mb-1">
                    Topics & Chapters
                </h1>
                <p class="text-sm sm:text-base text-gray-600 dark:text-gray-400">
                    Organize your subject content into manageable topics
                </p>
            </div>
            <a href="{{ route('partner.topics.create') }}" 
               class="group inline-flex items-center justify-center gap-2 px-6 py-3 bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 text-white rounded-xl font-semibold shadow-lg hover:shadow-xl transition-all duration-200 hover:scale-105">
                <svg class="w-5 h-5 group-hover:rotate-90 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"></path>
                </svg>
                <span>Add Topic</span>
            </a>
        </div>

        {{-- Flash Messages --}}
        @if(session('success'))
        <div class="bg-gradient-to-r from-green-50 to-emerald-50 dark:from-green-900/20 dark:to-emerald-900/20 border-l-4 border-green-500 p-4 rounded-xl shadow-sm">
            <div class="flex items-center">
                <svg class="w-5 h-5 text-green-500 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <p class="text-sm font-medium text-green-800 dark:text-green-300">{{ session('success') }}</p>
                <button onclick="this.parentElement.parentElement.remove()" class="ml-auto flex-shrink-0 text-green-600 hover:text-green-800 dark:text-green-400 dark:hover:text-green-200">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
        </div>
        @endif

        @if(session('error'))
        <div class="bg-gradient-to-r from-red-50 to-pink-50 dark:from-red-900/20 dark:to-pink-900/20 border-l-4 border-red-500 p-4 rounded-xl shadow-sm">
            <div class="flex items-center">
                <svg class="w-5 h-5 text-red-500 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <p class="text-sm font-medium text-red-800 dark:text-red-300">{{ session('error') }}</p>
                <button onclick="this.parentElement.parentElement.remove()" class="ml-auto flex-shrink-0 text-red-600 hover:text-red-800 dark:text-red-400 dark:hover:text-red-200">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
        </div>
        @endif

        @if($topics->count() > 0)
            {{-- Topics List --}}
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl border border-gray-200 dark:border-gray-700 overflow-hidden">
                {{-- Mobile View: Cards --}}
                <div class="block sm:hidden divide-y divide-gray-200 dark:divide-gray-700">
                    @foreach($topics as $index => $topic)
                        @php
                            $colors = [
                                ['bg' => 'bg-indigo-500', 'text' => 'text-indigo-700', 'light' => 'bg-indigo-50', 'dark' => 'bg-indigo-900/30', 'border' => 'border-indigo-200', 'darkBorder' => 'dark:border-indigo-800'],
                                ['bg' => 'bg-purple-500', 'text' => 'text-purple-700', 'light' => 'bg-purple-50', 'dark' => 'bg-purple-900/30', 'border' => 'border-purple-200', 'darkBorder' => 'dark:border-purple-800'],
                                ['bg' => 'bg-blue-500', 'text' => 'text-blue-700', 'light' => 'bg-blue-50', 'dark' => 'bg-blue-900/30', 'border' => 'border-blue-200', 'darkBorder' => 'dark:border-blue-800'],
                                ['bg' => 'bg-emerald-500', 'text' => 'text-emerald-700', 'light' => 'bg-emerald-50', 'dark' => 'bg-emerald-900/30', 'border' => 'border-emerald-200', 'darkBorder' => 'dark:border-emerald-800'],
                                ['bg' => 'bg-orange-500', 'text' => 'text-orange-700', 'light' => 'bg-orange-50', 'dark' => 'bg-orange-900/30', 'border' => 'border-orange-200', 'darkBorder' => 'dark:border-orange-800'],
                                ['bg' => 'bg-pink-500', 'text' => 'text-pink-700', 'light' => 'bg-pink-50', 'dark' => 'bg-pink-900/30', 'border' => 'border-pink-200', 'darkBorder' => 'dark:border-pink-800'],
                            ];
                            $color = $colors[$index % count($colors)];
                        @endphp
                        
                        <div class="p-4 hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors">
                            <div class="flex items-start gap-3 mb-3">
                                {{-- Chapter Badge --}}
                                @if($topic->chapter_number)
                                    <div class="flex-shrink-0 w-12 h-12 {{ $color['bg'] }} rounded-xl flex items-center justify-center text-white font-bold text-lg shadow-md">
                                        {{ $topic->chapter_number }}
                                    </div>
                                @else
                                    <div class="flex-shrink-0 w-12 h-12 bg-gray-400 dark:bg-gray-600 rounded-xl flex items-center justify-center text-white shadow-md">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                        </svg>
                                    </div>
                                @endif
                                
                                {{-- Topic Info --}}
                                <div class="flex-1 min-w-0">
                                    <div class="flex items-start gap-2 mb-1">
                                        <h3 class="text-base font-bold text-gray-900 dark:text-white flex-1">
                                            {{ $topic->name }}
                                        </h3>
                                    </div>
                                    <span class="inline-block px-2 py-0.5 {{ $color['light'] }} {{ $color['dark'] }} {{ $color['text'] }} dark:text-gray-300 rounded-md text-xs font-semibold border {{ $color['border'] }} {{ $color['darkBorder'] }} mb-2">
                                        {{ $topic->code }}
                                    </span>
                                    @if($topic->description)
                                        <p class="text-sm text-gray-600 dark:text-gray-400 mb-3 line-clamp-2">
                                            {{ $topic->description }}
                                        </p>
                                    @endif
                                </div>
                            </div>
                            
                            {{-- Meta Info --}}
                            <div class="flex flex-wrap items-center gap-2 mb-3">
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 bg-gray-100 dark:bg-gray-700 rounded-lg text-xs font-medium text-gray-700 dark:text-gray-300">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                    </svg>
                                    {{ $topic->subject->name }}
                                </span>
                                @if($topic->subject->course)
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 bg-indigo-100 dark:bg-indigo-900/30 text-indigo-700 dark:text-indigo-300 rounded-lg text-xs font-medium">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                        </svg>
                                        {{ $topic->subject->course->name }}
                                    </span>
                                @endif
                            </div>
                            
                            {{-- Actions --}}
                            <div class="flex gap-2">
                                <a href="{{ route('partner.topics.edit', $topic) }}" 
                                   class="flex-1 inline-flex items-center justify-center gap-1.5 px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg text-sm font-semibold shadow-md hover:shadow-lg transition-all duration-200">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                    </svg>
                                    Edit
                                </a>
                                <form action="{{ route('partner.topics.destroy', $topic) }}" method="POST" class="flex-1">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                            onclick="return confirm('Are you sure you want to delete this topic?')"
                                            class="w-full inline-flex items-center justify-center gap-1.5 px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg text-sm font-semibold shadow-md hover:shadow-lg transition-all duration-200">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                        </svg>
                                        Delete
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                </div>

                {{-- Desktop View: Table --}}
                <div class="hidden sm:block overflow-x-auto">
                    <table class="w-full">
                        <thead>
                            <tr class="bg-gradient-to-r from-slate-50 to-blue-50 dark:from-gray-800 dark:to-slate-800 border-b-2 border-indigo-500/30">
                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 dark:text-gray-200 uppercase tracking-wider">
                                    <div class="flex items-center gap-2">
                                        <svg class="w-4 h-4 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 20l4-16m2 16l4-16M6 9h14M4 15h14"></path>
                                        </svg>
                                        Chapter
                                    </div>
                                </th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 dark:text-gray-200 uppercase tracking-wider">
                                    <div class="flex items-center gap-2">
                                        <svg class="w-4 h-4 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                        </svg>
                                        Topic Details
                                    </div>
                                </th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 dark:text-gray-200 uppercase tracking-wider">
                                    <div class="flex items-center gap-2">
                                        <svg class="w-4 h-4 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                        </svg>
                                        Subject
                                    </div>
                                </th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 dark:text-gray-200 uppercase tracking-wider">
                                    <div class="flex items-center gap-2">
                                        <svg class="w-4 h-4 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                        </svg>
                                        Course
                                    </div>
                                </th>
                                <th class="px-6 py-4 text-center text-xs font-bold text-gray-700 dark:text-gray-200 uppercase tracking-wider">
                                    Actions
                                </th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                            @foreach($topics as $index => $topic)
                                @php
                                    $colors = [
                                        ['bg' => 'bg-indigo-500', 'text' => 'text-indigo-700', 'light' => 'bg-indigo-50', 'dark' => 'bg-indigo-900/30', 'border' => 'border-indigo-200', 'darkBorder' => 'dark:border-indigo-800'],
                                        ['bg' => 'bg-purple-500', 'text' => 'text-purple-700', 'light' => 'bg-purple-50', 'dark' => 'bg-purple-900/30', 'border' => 'border-purple-200', 'darkBorder' => 'dark:border-purple-800'],
                                        ['bg' => 'bg-blue-500', 'text' => 'text-blue-700', 'light' => 'bg-blue-50', 'dark' => 'bg-blue-900/30', 'border' => 'border-blue-200', 'darkBorder' => 'dark:border-blue-800'],
                                        ['bg' => 'bg-emerald-500', 'text' => 'text-emerald-700', 'light' => 'bg-emerald-50', 'dark' => 'bg-emerald-900/30', 'border' => 'border-emerald-200', 'darkBorder' => 'dark:border-emerald-800'],
                                        ['bg' => 'bg-orange-500', 'text' => 'text-orange-700', 'light' => 'bg-orange-50', 'dark' => 'bg-orange-900/30', 'border' => 'border-orange-200', 'darkBorder' => 'dark:border-orange-800'],
                                        ['bg' => 'bg-pink-500', 'text' => 'text-pink-700', 'light' => 'bg-pink-50', 'dark' => 'bg-pink-900/30', 'border' => 'border-pink-200', 'darkBorder' => 'dark:border-pink-800'],
                                    ];
                                    $color = $colors[$index % count($colors)];
                                @endphp
                                
                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if($topic->chapter_number)
                                            <div class="w-12 h-12 {{ $color['bg'] }} rounded-xl flex items-center justify-center text-white font-bold text-lg shadow-md">
                                                {{ $topic->chapter_number }}
                                            </div>
                                        @else
                                            <div class="w-12 h-12 bg-gray-400 dark:bg-gray-600 rounded-xl flex items-center justify-center text-white shadow-md">
                                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                                </svg>
                                            </div>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex items-start gap-3">
                                            <div class="min-w-0 flex-1">
                                                <h3 class="text-base font-bold text-gray-900 dark:text-white mb-1">
                                                    {{ $topic->name }}
                                                </h3>
                                                <span class="inline-block px-2.5 py-1 {{ $color['light'] }} {{ $color['dark'] }} {{ $color['text'] }} dark:text-gray-300 rounded-md text-xs font-semibold border {{ $color['border'] }} {{ $color['darkBorder'] }} mb-2">
                                                    {{ $topic->code }}
                                                </span>
                                                @if($topic->description)
                                                    <p class="text-sm text-gray-600 dark:text-gray-400 line-clamp-2">
                                                        {{ $topic->description }}
                                                    </p>
                                                @endif
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="inline-flex items-center gap-2 px-3 py-2 bg-gray-100 dark:bg-gray-700 rounded-lg">
                                            <svg class="w-4 h-4 text-gray-600 dark:text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                            </svg>
                                            <span class="text-sm font-semibold text-gray-900 dark:text-white">{{ $topic->subject->name }}</span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if($topic->subject->course)
                                            <div class="inline-flex items-center gap-2 px-3 py-2 bg-indigo-100 dark:bg-indigo-900/30 rounded-lg">
                                                <svg class="w-4 h-4 text-indigo-600 dark:text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                                </svg>
                                                <span class="text-sm font-semibold text-indigo-700 dark:text-indigo-300">{{ $topic->subject->course->name }}</span>
                                            </div>
                                        @else
                                            <span class="text-sm text-gray-400 dark:text-gray-500 italic">N/A</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center justify-center gap-2">
                                            <a href="{{ route('partner.topics.edit', $topic) }}" 
                                               class="inline-flex items-center gap-1.5 px-3 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg text-sm font-semibold shadow-md hover:shadow-lg transition-all duration-200">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                                </svg>
                                                Edit
                                            </a>
                                            <form action="{{ route('partner.topics.destroy', $topic) }}" method="POST" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" 
                                                        onclick="return confirm('Are you sure you want to delete this topic?')"
                                                        class="inline-flex items-center gap-1.5 px-3 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg text-sm font-semibold shadow-md hover:shadow-lg transition-all duration-200">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                    </svg>
                                                    Delete
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- Pagination --}}
            @if($topics->hasPages())
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg border border-gray-200 dark:border-gray-700 p-4">
                {{ $topics->links() }}
            </div>
            @endif
        @else
            {{-- Empty State --}}
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl border border-gray-200 dark:border-gray-700 p-8 sm:p-12 text-center">
                <div class="w-20 h-20 sm:w-24 sm:h-24 mx-auto mb-6 bg-gradient-to-br from-indigo-500 to-purple-500 rounded-full flex items-center justify-center shadow-2xl">
                    <svg class="w-10 h-10 sm:w-12 sm:h-12 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                </div>
                <h3 class="text-xl sm:text-2xl font-bold text-gray-900 dark:text-white mb-3">No Topics Yet</h3>
                <p class="text-sm sm:text-base text-gray-600 dark:text-gray-400 mb-6 max-w-md mx-auto">
                    Break down your subjects into manageable topics and chapters to help organize your content for better learning.
                </p>
                <a href="{{ route('partner.topics.create') }}" 
                   class="inline-flex items-center gap-2 px-6 py-3 bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 text-white rounded-xl font-semibold shadow-lg hover:shadow-xl transition-all duration-200 hover:scale-105">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    <span>Add Your First Topic</span>
                </a>
            </div>
        @endif
    </div>
</div>
@endsection
