@extends('layouts.partner-layout')

@section('title', 'Batches by Course')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-purple-50 via-pink-50 to-blue-50 dark:from-gray-900 dark:via-purple-900 dark:to-indigo-900 -m-6 p-4 sm:p-6 lg:p-8">
    <div class="max-w-7xl mx-auto space-y-4 sm:space-y-6">
        
        <!-- Page Header with Stats -->
        <div class="bg-white/80 dark:bg-gray-800/80 backdrop-blur-lg rounded-2xl p-4 sm:p-6 shadow-xl border border-purple-200 dark:border-purple-700">
            <div class="flex flex-col lg:flex-row lg:justify-between lg:items-center gap-4">
                <!-- Title & Description -->
                <div class="space-y-2">
                    <h1 class="text-2xl sm:text-3xl lg:text-4xl font-bold bg-gradient-to-r from-purple-600 via-pink-600 to-blue-600 bg-clip-text text-transparent flex items-center gap-2">
                        <svg class="w-8 h-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                        </svg>
                        Batches by Course
                    </h1>
                    <p class="text-sm sm:text-base text-gray-600 dark:text-gray-300">Organized view of all batches grouped by their courses</p>
                    
                    <!-- Stats -->
                    <div class="flex flex-wrap gap-3 mt-3">
                        <div class="inline-flex items-center gap-2 px-4 py-2 bg-gradient-to-r from-orange-100 to-amber-100 dark:from-orange-900/30 dark:to-amber-900/30 rounded-xl border border-orange-200 dark:border-orange-700">
                            <svg class="w-5 h-5 text-orange-600 dark:text-orange-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                            </svg>
                            <span class="text-sm font-bold text-orange-900 dark:text-orange-300">{{ $courses->count() }} Courses</span>
                        </div>
                        <div class="inline-flex items-center gap-2 px-4 py-2 bg-gradient-to-r from-purple-100 to-pink-100 dark:from-purple-900/30 dark:to-pink-900/30 rounded-xl border border-purple-200 dark:border-purple-700">
                            <svg class="w-5 h-5 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                            </svg>
                            <span class="text-sm font-bold text-purple-900 dark:text-purple-300">{{ $totalBatches }} Batches</span>
                        </div>
                    </div>
                </div>

                <!-- Add New Button -->
                <a href="{{ route('partner.batches.create') }}" 
                   class="w-full lg:w-auto inline-flex items-center justify-center gap-2 bg-gradient-to-r from-green-500 to-emerald-600 hover:from-green-600 hover:to-emerald-700 text-white px-6 py-3 rounded-xl font-semibold shadow-lg hover:shadow-xl transform hover:scale-105 transition-all duration-200">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    <span>Add New Batch</span>
                </a>
            </div>
        </div>

        <!-- Courses with Batches (Accordion Style) -->
        @if($courses->count() > 0)
            <div class="space-y-4">
                @foreach($courses as $index => $course)
                    <div x-data="{ open: {{ $index === 0 ? 'true' : 'false' }} }" 
                         class="bg-white/90 dark:bg-gray-800/90 backdrop-blur-lg rounded-2xl shadow-xl border border-gray-200 dark:border-gray-700 overflow-hidden transition-all duration-300">
                        
                        <!-- Course Header (Clickable) -->
                        <button @click="open = !open" 
                                class="w-full px-4 sm:px-6 py-4 sm:py-5 flex items-center justify-between hover:bg-gradient-to-r hover:from-orange-50 hover:to-amber-50 dark:hover:from-orange-900/20 dark:hover:to-amber-900/20 transition-all duration-200"
                                :class="{ 'bg-gradient-to-r from-orange-50 to-amber-50 dark:from-orange-900/20 dark:to-amber-900/20': open }">
                            <div class="flex items-center gap-3 sm:gap-4 flex-1">
                                <!-- Course Icon -->
                                <div class="w-12 h-12 sm:w-14 sm:h-14 bg-gradient-to-br from-orange-500 to-amber-600 rounded-xl flex items-center justify-center shadow-lg flex-shrink-0">
                                    <svg class="w-6 h-6 sm:w-7 sm:h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                    </svg>
                                </div>
                                
                                <!-- Course Info -->
                                <div class="flex-1 text-left">
                                    <h3 class="text-base sm:text-lg font-bold text-gray-900 dark:text-white">{{ $course->name }}</h3>
                                    <p class="text-xs sm:text-sm text-gray-600 dark:text-gray-400 flex items-center gap-2 mt-1">
                                        <span class="font-semibold">Code: {{ $course->code }}</span>
                                        <span class="text-gray-400 dark:text-gray-500">•</span>
                                        <span class="inline-flex items-center gap-1">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                                            </svg>
                                            {{ $course->batches->count() }} {{ $course->batches->count() === 1 ? 'Batch' : 'Batches' }}
                                        </span>
                                    </p>
                                </div>

                                <!-- Batch Count Badge -->
                                <div class="hidden sm:flex items-center gap-2 px-4 py-2 bg-purple-100 dark:bg-purple-900/30 rounded-xl border border-purple-200 dark:border-purple-700">
                                    <svg class="w-5 h-5 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                                    </svg>
                                    <span class="text-sm font-bold text-purple-900 dark:text-purple-300">{{ $course->batches->count() }}</span>
                                </div>
                            </div>

                            <!-- Expand/Collapse Icon -->
                            <div class="ml-3">
                                <svg class="w-6 h-6 text-gray-600 dark:text-gray-400 transition-transform duration-300" 
                                     :class="{ 'rotate-180': open }"
                                     fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </div>
                        </button>

                        <!-- Batches List (Expandable) -->
                        <div x-show="open"
                             x-transition:enter="transition ease-out duration-300"
                             x-transition:enter-start="opacity-0 -translate-y-2"
                             x-transition:enter-end="opacity-100 translate-y-0"
                             x-transition:leave="transition ease-in duration-200"
                             x-transition:leave-start="opacity-100 translate-y-0"
                             x-transition:leave-end="opacity-0 -translate-y-2"
                             class="border-t border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900/30">
                            
                            @if($course->batches->count() > 0)
                                <!-- Mobile Card View -->
                                <div class="block lg:hidden divide-y divide-gray-200 dark:divide-gray-700">
                                    @foreach($course->batches as $batch)
                                        <div class="p-4 hover:bg-white dark:hover:bg-gray-800/50 transition-colors duration-200">
                                            <div class="flex items-start justify-between mb-3">
                                                <div class="flex-1">
                                                    <h4 class="text-sm font-bold text-gray-900 dark:text-white mb-1">{{ $batch->name }}</h4>
                                                    <p class="text-xs text-gray-600 dark:text-gray-400">📅 Year: {{ $batch->year }}</p>
                                                </div>
                                                <div class="flex flex-col items-end gap-2">
                                                    <span class="inline-flex px-2.5 py-1 text-xs font-bold rounded-full shadow-sm
                                                        @if($batch->status === 'active') 
                                                            bg-gradient-to-r from-green-400 to-emerald-500 text-white
                                                        @else 
                                                            bg-gradient-to-r from-red-400 to-pink-500 text-white
                                                        @endif">
                                                        {{ ucfirst($batch->status) }}
                                                    </span>
                                                    <span class="inline-flex items-center gap-1 px-2.5 py-1 text-xs font-bold rounded-full shadow-sm bg-gradient-to-r from-blue-400 to-indigo-500 text-white">
                                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                                        </svg>
                                                        {{ $batch->students_count ?? 0 }}
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="flex gap-2">
                                                <a href="{{ route('partner.batches.edit', $batch) }}" 
                                                   class="flex-1 text-center bg-gradient-to-r from-indigo-500 to-purple-600 hover:from-indigo-600 hover:to-purple-700 text-white px-3 py-2 rounded-lg text-xs font-semibold shadow-md hover:shadow-lg transition-all duration-200">
                                                    ✏️ Edit
                                                </a>
                                                <form action="{{ route('partner.batches.destroy', $batch) }}" method="POST" class="flex-1">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" 
                                                            onclick="return confirm('Delete this batch? This action cannot be undone.')"
                                                            class="w-full bg-gradient-to-r from-red-500 to-pink-600 hover:from-red-600 hover:to-pink-700 text-white px-3 py-2 rounded-lg text-xs font-semibold shadow-md hover:shadow-lg transition-all duration-200">
                                                        🗑️ Delete
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>

                                <!-- Desktop Table View -->
                                <div class="hidden lg:block overflow-x-auto">
                                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                                        <thead class="bg-gradient-to-r from-purple-100 to-pink-100 dark:from-purple-900/50 dark:to-pink-900/50">
                                            <tr>
                                                <th class="px-6 py-3 text-left text-xs font-bold text-purple-900 dark:text-purple-200 uppercase tracking-wider">Batch Name</th>
                                                <th class="px-6 py-3 text-left text-xs font-bold text-purple-900 dark:text-purple-200 uppercase tracking-wider">Year</th>
                                                <th class="px-6 py-3 text-left text-xs font-bold text-purple-900 dark:text-purple-200 uppercase tracking-wider">Status</th>
                                                <th class="px-6 py-3 text-left text-xs font-bold text-purple-900 dark:text-purple-200 uppercase tracking-wider">Students</th>
                                                <th class="px-6 py-3 text-left text-xs font-bold text-purple-900 dark:text-purple-200 uppercase tracking-wider">Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody class="bg-white dark:bg-gray-800/50 divide-y divide-gray-200 dark:divide-gray-700">
                                            @foreach($course->batches as $batch)
                                                <tr class="hover:bg-purple-50 dark:hover:bg-purple-900/20 transition-colors duration-200">
                                                    <td class="px-6 py-4">
                                                        <div class="text-sm font-bold text-gray-900 dark:text-white">{{ $batch->name }}</div>
                                                    </td>
                                                    <td class="px-6 py-4">
                                                        <span class="text-sm font-semibold text-gray-700 dark:text-gray-300">📅 {{ $batch->year }}</span>
                                                    </td>
                                                    <td class="px-6 py-4">
                                                        <span class="inline-flex px-3 py-1 text-xs font-bold rounded-full shadow-sm
                                                            @if($batch->status === 'active') 
                                                                bg-gradient-to-r from-green-400 to-emerald-500 text-white
                                                            @else 
                                                                bg-gradient-to-r from-red-400 to-pink-500 text-white
                                                            @endif">
                                                            {{ ucfirst($batch->status) }}
                                                        </span>
                                                    </td>
                                                    <td class="px-6 py-4">
                                                        <span class="inline-flex items-center gap-2 px-3 py-1.5 text-sm font-bold rounded-lg shadow-sm bg-gradient-to-r from-blue-500 to-indigo-600 text-white">
                                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                                            </svg>
                                                            {{ $batch->students_count ?? 0 }}
                                                        </span>
                                                    </td>
                                                    <td class="px-6 py-4">
                                                        <div class="flex gap-2">
                                                            <a href="{{ route('partner.batches.edit', $batch) }}" 
                                                               class="inline-flex items-center gap-1 bg-gradient-to-r from-indigo-500 to-purple-600 hover:from-indigo-600 hover:to-purple-700 text-white px-3 py-1.5 rounded-lg text-xs font-semibold shadow-md hover:shadow-lg transition-all duration-200">
                                                                ✏️ Edit
                                                            </a>
                                                            <form action="{{ route('partner.batches.destroy', $batch) }}" method="POST" class="inline">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" 
                                                                        onclick="return confirm('Delete this batch? This action cannot be undone.')"
                                                                        class="inline-flex items-center gap-1 bg-gradient-to-r from-red-500 to-pink-600 hover:from-red-600 hover:to-pink-700 text-white px-3 py-1.5 rounded-lg text-xs font-semibold shadow-md hover:shadow-lg transition-all duration-200">
                                                                    🗑️ Delete
                                                                </button>
                                                            </form>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @else
                                <!-- No Batches in this Course -->
                                <div class="p-8 text-center">
                                    <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-purple-100 dark:bg-purple-900/30 mb-3">
                                        <svg class="w-8 h-8 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                                        </svg>
                                    </div>
                                    <p class="text-sm text-gray-600 dark:text-gray-400 mb-4">No batches yet for this course</p>
                                    <a href="{{ route('partner.batches.create') }}" 
                                       class="inline-flex items-center gap-2 px-4 py-2 bg-gradient-to-r from-green-500 to-emerald-600 hover:from-green-600 hover:to-emerald-700 text-white text-sm font-semibold rounded-lg shadow-md hover:shadow-lg transition-all duration-200">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                        </svg>
                                        Create Batch
                                    </a>
                                </div>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <!-- No Courses -->
            <div class="bg-white/90 dark:bg-gray-800/90 backdrop-blur-lg rounded-2xl shadow-xl border border-gray-200 dark:border-gray-700 p-12 text-center">
                <div class="inline-flex items-center justify-center w-24 h-24 rounded-full bg-gradient-to-br from-purple-100 to-pink-100 dark:from-purple-900 dark:to-pink-900 mb-6">
                    <svg class="w-12 h-12 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                    </svg>
                </div>
                <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-3">No courses yet!</h3>
                <p class="text-gray-600 dark:text-gray-400 mb-6">You need to create courses first before adding batches.</p>
                <a href="{{ route('partner.courses.index') }}" 
                   class="inline-flex items-center gap-2 px-6 py-3 bg-gradient-to-r from-orange-500 to-amber-600 hover:from-orange-600 hover:to-amber-700 text-white font-bold rounded-xl shadow-lg hover:shadow-xl transform hover:scale-105 transition-all duration-200">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                    </svg>
                    Manage Courses
                </a>
            </div>
        @endif
    </div>
</div>
@endsection
