@extends('layouts.partner-layout')

@section('title', 'Typing Test')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900">
                <!-- Header -->
                <div class="text-center mb-8">
                    <h1 class="text-3xl font-bold text-gray-900 mb-2">Typing Speed Test</h1>
                    <p class="text-gray-600">Test your typing speed and accuracy</p>
                </div>

                                <!-- Info Cards -->
                <!-- First Row: Tutorial, Test, Game -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                    <!-- Tutorial Card -->
                    <div class="bg-gradient-to-br from-blue-500 via-blue-600 to-blue-700 p-8 rounded-2xl border-0 shadow-2xl transform hover:scale-105 transition-all duration-300 hover:shadow-blue-500/25">
                        <div class="flex items-center justify-between mb-6">
                            <div class="p-4 rounded-2xl bg-white/20 backdrop-blur-sm">
                                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 5.477 5.754 5 7.5 5s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.523 18.246 19 16.5 19c-1.746 0-3.332-.477-4.5-1.253"></path>
                                </svg>
                            </div>
                        </div>
                        <div class="text-white mb-6">
                            <h3 class="text-2xl font-bold mb-2">Tutorial</h3>
                            <p class="text-blue-100 text-lg">Master typing fundamentals</p>
                        </div>
                        <a href="{{ route('typing.tutorial') }}" class="w-full bg-white/20 hover:bg-white/30 text-white font-semibold py-4 px-6 rounded-xl transition-all duration-300 backdrop-blur-sm border border-white/30 hover:border-white/50 inline-block text-center">
                            Start Learning
                        </a>
                    </div>

                    <!-- Test Card -->
                    <div class="bg-gradient-to-br from-emerald-500 via-emerald-600 to-emerald-700 p-8 rounded-2xl border-0 shadow-2xl transform hover:scale-105 transition-all duration-300 hover:shadow-emerald-500/25">
                        <div class="flex items-center justify-between mb-6">
                            <div class="p-4 rounded-2xl bg-white/20 backdrop-blur-sm">
                                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                                </svg>
                            </div>
                        </div>
                        <div class="text-white mb-6">
                            <h3 class="text-2xl font-bold mb-2">Speed Test</h3>
                            <p class="text-emerald-100 text-lg">Test your typing skills</p>
                        </div>
                                                       <a href="{{ route('typing.speed-test') }}" class="w-full bg-white/20 hover:bg-white/30 text-white font-semibold py-4 px-6 rounded-xl transition-all duration-300 backdrop-blur-sm border border-white/30 hover:border-white/50 inline-block text-center">
                                   Begin Test
                               </a>
                    </div>

                    <!-- Typing Game Card -->
                    <div class="bg-gradient-to-br from-rose-500 via-rose-600 to-rose-700 p-8 rounded-2xl border-0 shadow-2xl transform hover:scale-105 transition-all duration-300 hover:shadow-rose-500/25">
                        <div class="flex items-center justify-between mb-6">
                            <div class="p-4 rounded-2xl bg-white/20 backdrop-blur-sm">
                                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h1m4 0h1m-6 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                        </div>
                        <div class="text-white mb-6">
                            <h3 class="text-2xl font-bold mb-2">Typing Game</h3>
                            <p class="text-rose-100 text-lg">Fun challenges & mini-games</p>
                        </div>
                        <button id="startGame" class="w-full bg-white/20 hover:bg-white/30 text-white font-semibold py-4 px-6 rounded-xl transition-all duration-300 backdrop-blur-sm border border-white/30 hover:border-white/50">
                            Play Now
                        </button>
                    </div>
                </div>

                <!-- Second Row: Total Test Taken & Total Score -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">
                    <!-- Total Test Taken Card -->
                    <div class="bg-gradient-to-br from-amber-500 via-amber-600 to-amber-700 p-6 rounded-2xl border-0 shadow-2xl transform hover:scale-105 transition-all duration-300 hover:shadow-amber-500/25">
                        <div class="flex items-center justify-between mb-4">
                            <div class="p-3 rounded-xl bg-white/20 backdrop-blur-sm">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                                </svg>
                            </div>
                        </div>
                        <div class="text-white mb-4">
                            <h3 class="text-xl font-bold mb-1">Total Tests Taken</h3>
                            <p class="text-amber-100 text-sm">Track your progress</p>
                        </div>
                        <div class="grid grid-cols-2 gap-3">
                            <div class="bg-white/20 backdrop-blur-sm rounded-lg p-3 text-center border border-white/30">
                                <div class="text-2xl font-bold text-white" id="englishTests">0</div>
                                <div class="text-amber-100 text-xs">English</div>
                            </div>
                            <div class="bg-white/20 backdrop-blur-sm rounded-lg p-3 text-center border border-white/30">
                                <div class="text-2xl font-bold text-white" id="banglaTests">0</div>
                                <div class="text-amber-100 text-xs">বাংলা</div>
                            </div>
                        </div>
                    </div>

                    <!-- Total Score Card -->
                    <div class="bg-gradient-to-br from-violet-500 via-violet-600 to-violet-700 p-6 rounded-2xl border-0 shadow-2xl transform hover:scale-105 transition-all duration-300 hover:shadow-violet-500/25">
                        <div class="flex items-center justify-between mb-4">
                            <div class="p-3 rounded-xl bg-white/20 backdrop-blur-sm">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                                </svg>
                            </div>
                        </div>
                        <div class="text-white mb-4">
                            <h3 class="text-xl font-bold mb-1">Best Performance</h3>
                            <p class="text-violet-100 text-sm">Your highest achievement</p>
                        </div>
                        <div class="grid grid-cols-2 gap-3">
                            <div class="bg-white/20 backdrop-blur-sm rounded-lg p-3 text-center border border-white/30">
                                <div class="text-3xl font-bold text-white mb-1" id="bestScore">0</div>
                                <div class="text-violet-100 text-xs">WPM</div>
                            </div>
                            <div class="bg-white/20 backdrop-blur-sm rounded-lg p-3 text-center border border-white/30">
                                <div class="text-2xl font-bold text-white mb-1" id="gameHighScore">0</div>
                                <div class="text-violet-100 text-xs">Game Score</div>
                            </div>
                        </div>
                    </div>
                </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Statistics tracking
    let bestScore = localStorage.getItem('typingBestScore') || 0;
    let englishTests = localStorage.getItem('typingEnglishTests') || 0;
    let banglaTests = localStorage.getItem('typingBanglaTests') || 0;
    let gameHighScore = localStorage.getItem('typingGameHighScore') || 0;
    
    // Update statistics display
    function updateStatisticsDisplay() {
        document.getElementById('bestScore').textContent = bestScore;
        document.getElementById('englishTests').textContent = englishTests;
        document.getElementById('banglaTests').textContent = banglaTests;
        document.getElementById('gameHighScore').textContent = gameHighScore;
    }
    
    // Initialize statistics display
    updateStatisticsDisplay();
    
    // Connect the Typing Game button
    document.getElementById('startGame').addEventListener('click', function() {
        // For now, just show an alert. You can expand this to a full game later
        alert('Typing Game coming soon! This will include fun typing challenges and mini-games.');
    });
});
</script>
@endsection
