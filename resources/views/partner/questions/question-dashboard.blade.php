@extends('layouts.app')

@section('title', 'Questions Dashboard')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-slate-50 via-blue-50 to-indigo-100 dark:from-gray-900 dark:via-gray-800 dark:to-gray-900">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
        <!-- Header Section -->
        <div class="text-center mb-4 relative">
            <!-- View All Questions Button - Top Right -->
            <div class="absolute top-0 right-0">
                <a href="{{ route('partner.questions.list') }}" 
                   class="group relative inline-flex items-center justify-center px-6 py-3 bg-gradient-to-r from-indigo-600 to-blue-600 hover:from-indigo-700 hover:to-blue-700 text-white font-semibold rounded-2xl shadow-lg hover:shadow-xl transform hover:-translate-y-1 transition-all duration-300">
                    <svg class="w-5 h-5 mr-2 group-hover:rotate-12 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                    </svg>
                    View All Questions
                </a>
            </div>

            <div class="inline-flex items-center justify-center w-16 h-16 bg-gradient-to-r from-blue-600 to-indigo-600 rounded-full mb-4 shadow-lg">
                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/>
                </svg>
            </div>
            <h1 class="text-4xl font-bold bg-gradient-to-r from-gray-900 via-blue-800 to-indigo-800 bg-clip-text text-transparent dark:from-white dark:via-blue-200 dark:to-indigo-200 mb-3">
                Questions Dashboard
            </h1>
            <p class="text-lg text-gray-600 dark:text-gray-300 max-w-2xl mx-auto">
                Get a comprehensive overview of your educational content and track your question bank performance
            </p>
        </div>

        <!-- Action Buttons -->
        <div class="flex justify-center mb-12">
            <!-- Button removed - moved to top right -->
        </div>

        <!-- Stats Cards Grid -->
        <div class="space-y-3 mb-6">
            <!-- First Row - Total Questions Card Only -->
            <div class="flex justify-center">
                <div class="group relative bg-white dark:bg-gray-800 rounded-3xl shadow-xl border border-gray-100 dark:border-gray-700 p-3 transform hover:scale-105 hover:shadow-2xl transition-all duration-500 overflow-hidden w-full max-w-2xl">
                    <div class="absolute top-0 right-0 w-24 h-24 bg-gradient-to-br from-indigo-100 to-blue-100 dark:from-indigo-900/20 dark:to-blue-900/20 rounded-full -translate-y-12 translate-x-12 group-hover:scale-110 transition-transform duration-500"></div>
                    <div class="relative z-10 text-center">
                        <div class="flex items-center justify-center mb-2">
                            <div class="p-2 bg-gradient-to-r from-indigo-500 to-blue-500 rounded-2xl shadow-lg">
                                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </div>
                        </div>
                        <h3 class="text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase tracking-wider mb-1">Total Questions</h3>
                        <p class="text-3xl font-bold text-gray-900 dark:text-white mb-1">{{ number_format($totalQuestions) }}</p>
                        <p class="text-xs text-gray-500 dark:text-gray-400">Active questions in your bank</p>
                    </div>
                </div>
            </div>

            <!-- Second Row - Three Question Type Cards -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Total MCQs Card -->
                <div class="group relative bg-white dark:bg-gray-800 rounded-3xl shadow-xl border border-gray-100 dark:border-gray-700 p-6 transform hover:scale-105 hover:shadow-2xl transition-all duration-500 overflow-hidden">
                    <div class="absolute top-0 right-0 w-32 h-32 bg-gradient-to-br from-emerald-100 to-green-100 dark:from-emerald-900/20 dark:to-green-900/20 rounded-full -translate-y-16 translate-x-16 group-hover:scale-110 transition-transform duration-500"></div>
                    <div class="relative z-10">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="text-sm font-semibold text-gray-600 dark:text-gray-400 uppercase tracking-wider">Total MCQs</h3>
                            <div class="p-3 bg-gradient-to-r from-emerald-500 to-green-500 rounded-2xl shadow-lg">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                                </svg>
                            </div>
                        </div>
                        <p class="text-4xl font-bold text-gray-900 dark:text-white mb-2">{{ number_format($totalMcq) }}</p>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Multiple choice questions</p>
                    </div>
                </div>

                <!-- Descriptive Questions Card -->
                <div class="group relative bg-white dark:bg-gray-800 rounded-3xl shadow-xl border border-gray-100 dark:border-gray-700 p-6 transform hover:scale-105 hover:shadow-2xl transition-all duration-500 overflow-hidden">
                    <div class="absolute top-0 right-0 w-32 h-32 bg-gradient-to-br from-amber-100 to-orange-100 dark:from-amber-900/20 dark:to-orange-900/20 rounded-full -translate-y-16 translate-x-16 group-hover:scale-110 transition-transform duration-500"></div>
                    <div class="relative z-10">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="text-sm font-semibold text-gray-600 dark:text-gray-400 uppercase tracking-wider">Descriptive</h3>
                            <div class="p-3 bg-gradient-to-r from-amber-500 to-orange-500 rounded-2xl shadow-lg">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                </svg>
                            </div>
                        </div>
                        <p class="text-4xl font-bold text-gray-900 dark:text-white mb-2">{{ number_format($totalDescriptive ?? 0) }}</p>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Descriptive questions</p>
                    </div>
                </div>

                <!-- Comprehensive Questions Card -->
                <div class="group relative bg-white dark:bg-gray-800 rounded-3xl shadow-xl border border-gray-100 dark:border-gray-700 p-6 transform hover:scale-105 hover:shadow-2xl transition-all duration-500 overflow-hidden">
                    <div class="absolute top-0 right-0 w-32 h-32 bg-gradient-to-br from-purple-100 to-violet-100 dark:from-purple-900/20 dark:to-violet-900/20 rounded-full -translate-y-16 translate-x-16 group-hover:scale-110 transition-transform duration-500"></div>
                    <div class="relative z-10">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="text-sm font-semibold text-gray-600 dark:text-gray-400 uppercase tracking-wider">Comprehensive</h3>
                            <div class="p-3 bg-gradient-to-r from-purple-500 to-violet-500 rounded-2xl shadow-lg">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                                </svg>
                            </div>
                        </div>
                        <p class="text-4xl font-bold text-gray-900 dark:text-white mb-2">{{ number_format($totalComprehensive ?? 0) }}</p>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Comprehensive questions</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Content Breakdown Section -->
        <div class="bg-white dark:bg-gray-800 rounded-3xl shadow-2xl border border-gray-100 dark:border-gray-700 p-8 mb-8">
            <div class="text-center mb-8">
                <h2 class="text-3xl font-bold text-gray-900 dark:text-white mb-2">Question Breakdown</h2>
                <p class="text-gray-600 dark:text-gray-300">Detailed analysis of your question distribution across different categories</p>
            </div>

            <!-- Course-wise Breakdown -->
            <div class="mb-12">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-xl font-semibold text-gray-800 dark:text-white flex items-center">
                        <div class="w-2 h-8 bg-gradient-to-b from-blue-500 to-indigo-600 rounded-full mr-4"></div>
                        Questions by Course
                    </h3>
                    <span class="text-sm text-gray-500 dark:text-gray-400">{{ $questionsByCourse->count() }} courses</span>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4">
                    @foreach ($questionsByCourse as $course)
                        <div class="group bg-gradient-to-br from-blue-50 to-indigo-50 dark:from-blue-900/20 dark:to-indigo-900/20 rounded-2xl p-4 border border-blue-100 dark:border-blue-800/30 hover:shadow-lg transform hover:-translate-y-1 transition-all duration-300">
                            <div class="flex items-center">
                                <div class="p-3 bg-gradient-to-r from-blue-500 to-indigo-600 rounded-xl mr-4 shadow-lg">
                                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                                    </svg>
                                </div>
                                <div class="flex-1">
                                    <p class="font-semibold text-gray-800 dark:text-white text-sm">{{ $course->name }}</p>
                                    <p class="text-2xl font-bold text-blue-600 dark:text-blue-400">{{ $course->total_questions }}</p>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">Questions</p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Subject-wise Breakdown -->
            <div class="mb-12">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-xl font-semibold text-gray-800 dark:text-white flex items-center">
                        <div class="w-2 h-8 bg-gradient-to-b from-pink-500 to-rose-600 rounded-full mr-4"></div>
                        Questions by Subject
                    </h3>
                    <span class="text-sm text-gray-500 dark:text-gray-400">{{ $questionsBySubject->count() }} subjects</span>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4">
                    @foreach ($questionsBySubject as $subject)
                        <div class="group bg-gradient-to-br from-pink-50 to-rose-50 dark:from-pink-900/20 dark:to-rose-900/20 rounded-2xl p-4 border border-pink-100 dark:border-pink-800/30 hover:shadow-lg transform hover:-translate-y-1 transition-all duration-300">
                            <div class="flex items-center">
                                <div class="p-3 bg-gradient-to-r from-pink-500 to-rose-600 rounded-xl mr-4 shadow-lg">
                                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"/>
                                    </svg>
                                </div>
                                <div class="flex-1">
                                    <p class="font-semibold text-gray-800 dark:text-white text-sm">{{ $subject->name }}</p>
                                    <p class="text-2xl font-bold text-pink-600 dark:text-pink-400">{{ $subject->total_questions }}</p>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">Questions</p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Topic-wise Breakdown -->
            <div>
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-xl font-semibold text-gray-800 dark:text-white flex items-center">
                        <div class="w-2 h-8 bg-gradient-to-b from-emerald-500 to-green-600 rounded-full mr-4"></div>
                        Questions by Topic
                    </h3>
                    <span class="text-sm text-gray-500 dark:text-gray-400">{{ $questionsByTopic->count() }} topics</span>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4">
                    @foreach ($questionsByTopic as $topic)
                        <div class="group bg-gradient-to-br from-emerald-50 to-green-50 dark:from-emerald-900/20 dark:to-green-900/20 rounded-2xl p-4 border border-emerald-100 dark:border-emerald-800/30 hover:shadow-lg transform hover:-translate-y-1 transition-all duration-300">
                            <div class="flex items-center">
                                <div class="p-3 bg-gradient-to-r from-emerald-500 to-green-600 rounded-xl mr-4 shadow-lg">
                                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                                    </svg>
                                </div>
                                <div class="flex-1">
                                    <p class="font-semibold text-gray-800 dark:text-white text-sm">{{ $topic->name }}</p>
                                    <p class="text-2xl font-bold text-emerald-600 dark:text-emerald-400">{{ $topic->total_questions }}</p>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">Questions</p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Quick Actions Footer -->
        <div class="text-center">
            <div class="inline-flex items-center space-x-2 text-gray-500 dark:text-gray-400">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <span class="text-sm">Need help? Check our documentation or contact support</span>
            </div>
        </div>
    </div>
</div>

<style>
/* Custom animations and effects */
@keyframes float {
    0%, 100% { transform: translateY(0px); }
    50% { transform: translateY(-10px); }
}

.animate-float {
    animation: float 3s ease-in-out infinite;
}

/* Smooth scrolling */
html {
    scroll-behavior: smooth;
}

/* Custom scrollbar */
::-webkit-scrollbar {
    width: 8px;
}

::-webkit-scrollbar-track {
    background: #f1f5f9;
}

::-webkit-scrollbar-thumb {
    background: #cbd5e1;
    border-radius: 4px;
}

::-webkit-scrollbar-thumb:hover {
    background: #94a3b8;
}

/* Dark mode scrollbar */
.dark ::-webkit-scrollbar-track {
    background: #1e293b;
}

.dark ::-webkit-scrollbar-thumb {
    background: #475569;
}

.dark ::-webkit-scrollbar-thumb:hover {
    background: #64748b;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Add staggered animation to stats cards
    const cards = document.querySelectorAll('.grid > div');
    cards.forEach((card, index) => {
        card.style.animationDelay = `${index * 100}ms`;
        card.classList.add('animate-fade-in');
    });

    // Add hover effects to breakdown cards
    const breakdownCards = document.querySelectorAll('.grid.grid-cols-1 > div');
    breakdownCards.forEach(card => {
        card.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-8px) scale(1.02)';
        });
        
        card.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0) scale(1)';
        });
    });
});
</script>



@endsection
