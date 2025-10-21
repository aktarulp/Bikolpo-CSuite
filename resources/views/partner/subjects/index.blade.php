@extends('layouts.partner-layout')

@section('title', 'Subjects')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-slate-50 via-blue-50 to-indigo-50 dark:from-gray-900 dark:via-slate-900 dark:to-indigo-950 -m-6 p-4 sm:p-6 lg:p-8">
    <div class="max-w-7xl mx-auto space-y-6">
        
        {{-- Header Section --}}
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h1 class="text-2xl sm:text-3xl lg:text-4xl font-extrabold text-gray-900 dark:text-white mb-1">
                    Subjects
                </h1>
                <p class="text-sm sm:text-base text-gray-600 dark:text-gray-400">
                    Manage and organize your course subjects
                </p>
            </div>
            <a href="{{ route('partner.subjects.create') }}" 
               class="group inline-flex items-center justify-center gap-2 px-6 py-3 bg-gradient-to-r from-purple-600 to-pink-600 hover:from-purple-700 hover:to-pink-700 text-white rounded-xl font-semibold shadow-lg hover:shadow-xl transition-all duration-200 hover:scale-105">
                <svg class="w-5 h-5 group-hover:rotate-90 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"></path>
                </svg>
                <span>Add Subject</span>
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

        @if($subjects->count() > 0)
        @php
            // Group subjects by course
            $groupedSubjects = $subjects->groupBy('course_id');
            // Color schemes for courses
            $colors = [
                ['gradient' => 'from-blue-500 via-cyan-500 to-teal-500', 'iconBg' => 'from-blue-600 to-cyan-600', 'headerBg' => 'bg-blue-50 dark:bg-blue-900/20', 'headerText' => 'text-blue-900 dark:text-blue-100'],
                ['gradient' => 'from-purple-500 via-pink-500 to-rose-500', 'iconBg' => 'from-purple-600 to-pink-600', 'headerBg' => 'bg-purple-50 dark:bg-purple-900/20', 'headerText' => 'text-purple-900 dark:text-purple-100'],
                ['gradient' => 'from-green-500 via-emerald-500 to-teal-500', 'iconBg' => 'from-green-600 to-emerald-600', 'headerBg' => 'bg-green-50 dark:bg-green-900/20', 'headerText' => 'text-green-900 dark:text-green-100'],
                ['gradient' => 'from-orange-500 via-amber-500 to-yellow-500', 'iconBg' => 'from-orange-600 to-amber-600', 'headerBg' => 'bg-orange-50 dark:bg-orange-900/20', 'headerText' => 'text-orange-900 dark:text-orange-100'],
                ['gradient' => 'from-red-500 via-pink-500 to-fuchsia-500', 'iconBg' => 'from-red-600 to-pink-600', 'headerBg' => 'bg-red-50 dark:bg-red-900/20', 'headerText' => 'text-red-900 dark:text-red-100'],
                ['gradient' => 'from-indigo-500 via-violet-500 to-purple-500', 'iconBg' => 'from-indigo-600 to-purple-600', 'headerBg' => 'bg-indigo-50 dark:bg-indigo-900/20', 'headerText' => 'text-indigo-900 dark:text-indigo-100'],
            ];
            $courseIndex = 0;
        @endphp
        
        {{-- Subjects Grouped by Course --}}
        <div class="space-y-8">
            @foreach($groupedSubjects as $courseId => $courseSubjects)
                @php
                    $course = $courseSubjects->first()->course;
                    $color = $colors[$courseIndex % count($colors)];
                    $courseIndex++;
                @endphp
                
                {{-- Course Group --}}
                <div class="space-y-4">
                    {{-- Course Header --}}
                    <div class="{{ $color['headerBg'] }} rounded-xl p-4 border-2 border-gray-200 dark:border-gray-700">
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 bg-gradient-to-br {{ $color['iconBg'] }} rounded-xl flex items-center justify-center shadow-lg">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                </svg>
                            </div>
                            <div class="flex-1">
                                <h2 class="text-xl font-bold {{ $color['headerText'] }}">
                                    {{ $course ? $course->name : 'Uncategorized' }}
                                </h2>
                                <p class="text-sm text-gray-600 dark:text-gray-400">
                                    {{ $courseSubjects->count() }} {{ Str::plural('Subject', $courseSubjects->count()) }}
                                </p>
                            </div>
                        </div>
                    </div>
                    
                    {{-- Subjects Grid --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                        @foreach($courseSubjects as $subject)
                        {{-- Compact Subject Card --}}
                        <div class="group bg-white dark:bg-gray-800 rounded-xl shadow-lg hover:shadow-2xl transition-all duration-300 border-2 border-gray-200 dark:border-gray-700 overflow-hidden hover:-translate-y-1">
                            {{-- Compact Header --}}
                            <div class="relative bg-gradient-to-br {{ $color['gradient'] }} p-4">
                                {{-- Decorative Pattern --}}
                                <div class="absolute inset-0 bg-[url('data:image/svg+xml,%3Csvg width="30" height="30" viewBox="0 0 30 30" xmlns="http://www.w3.org/2000/svg"%3E%3Cg fill="%23ffffff" fill-opacity="0.07"%3E%3Crect width="2" height="2"/%3E%3C/g%3E%3C/svg%3E')]"></div>
                                
                                <div class="relative z-10">
                                    <div class="flex items-start gap-3 mb-3">
                                        {{-- Subject Icon --}}
                                        <div class="w-12 h-12 bg-white/20 backdrop-blur-sm rounded-xl flex items-center justify-center text-white font-bold text-lg shadow-xl border border-white/30 group-hover:scale-110 transition-transform duration-300 flex-shrink-0">
                                            {{ substr($subject->name, 0, 1) }}
                                        </div>
                                        
                                        <div class="flex-1 min-w-0">
                                            {{-- Subject Name --}}
                                            <h3 class="text-base font-bold text-white mb-1 line-clamp-2 leading-tight">
                                                {{ $subject->name }}
                                            </h3>
                                            
                                            {{-- Code Badge --}}
                                            <div class="inline-flex items-center gap-1 px-2.5 py-0.5 bg-white/20 backdrop-blur-sm text-white text-xs font-bold rounded-full border border-white/30">
                                                <span class="text-white/70">Course Code:</span>
                                                <span>{{ $subject->code }}</span>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    {{-- Topics Count Badge --}}
                                    <div class="inline-flex items-center gap-1.5 px-3 py-1 bg-white/20 backdrop-blur-sm rounded-lg border border-white/30">
                                        <svg class="w-3.5 h-3.5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                        </svg>
                                        <span class="text-xs font-bold text-white">{{ $subject->topics_count }} {{ Str::plural('Topic', $subject->topics_count) }}</span>
                                    </div>
                                </div>
                            </div>

                            {{-- Compact Actions --}}
                            <div class="p-3 bg-gray-50 dark:bg-gray-700/30">
                                <div class="flex gap-2">
                                    <a href="{{ route('partner.subjects.edit', $subject) }}" 
                                       class="flex-1 inline-flex items-center justify-center gap-1.5 bg-white dark:bg-gray-700 hover:bg-blue-50 dark:hover:bg-blue-900/20 text-gray-700 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400 font-semibold px-3 py-2 rounded-lg transition-all duration-200 border-2 border-gray-200 dark:border-gray-600 hover:border-blue-500 dark:hover:border-blue-400 shadow-sm hover:shadow-md text-sm">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                        </svg>
                                        Edit
                                    </a>
                                    <form action="{{ route('partner.subjects.destroy', $subject) }}" method="POST" class="flex-1">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                                onclick="return confirm('Are you sure you want to delete this subject?')"
                                                class="w-full inline-flex items-center justify-center gap-1.5 bg-gradient-to-r from-red-600 to-pink-600 hover:from-red-700 hover:to-pink-700 text-white font-semibold px-3 py-2 rounded-lg transition-all duration-200 shadow-md hover:shadow-lg hover:scale-105 text-sm">
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
                </div>
            @endforeach
        </div>

        {{-- Pagination --}}
        @if($subjects->hasPages())
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg p-4 sm:p-6 border-2 border-gray-200 dark:border-gray-700">
            {{ $subjects->links() }}
        </div>
        @endif
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
