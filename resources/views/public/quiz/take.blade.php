<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $exam->title }} - Quiz</title>
    
    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body class="bg-gray-100 font-sans leading-relaxed text-gray-800 antialiased">
    <div class="flex flex-col lg:flex-row items-start justify-center min-h-screen p-1 sm:p-2 md:p-4 gap-2 sm:gap-4 lg:gap-6">
        <!-- Participants Sidebar -->
        <div class="hidden lg:block landscape:block w-80 landscape:w-64 bg-blue-50 p-6 landscape:p-4 rounded-xl shadow-inner sticky top-4">
            <h3 class="text-lg landscape:text-base font-semibold text-gray-800 mb-4 landscape:mb-3 flex items-center">
                <svg class="w-5 h-5 landscape:w-4 landscape:h-4 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                </svg>
                Participants ({{ $participants->count() }})
            </h3>
            
            <div class="space-y-3 landscape:space-y-2 max-h-96 landscape:max-h-64 overflow-y-auto">
                @forelse($participants as $participant)
                    <div class="flex items-center space-x-3 landscape:space-x-2 p-3 landscape:p-2 bg-white rounded-lg shadow-sm border border-gray-200">
                        <!-- Profile Picture -->
                        <div class="flex-shrink-0">
                            @if($participant['photo'])
                                <img src="{{ asset('storage/' . $participant['photo']) }}" 
                                     alt="{{ $participant['name'] }}" 
                                     class="w-10 h-10 landscape:w-8 landscape:h-8 rounded-full object-cover border-2 border-gray-300">
                            @else
                                <div class="w-10 h-10 landscape:w-8 landscape:h-8 rounded-full bg-gradient-to-br from-blue-400 to-blue-600 flex items-center justify-center text-white font-semibold text-sm landscape:text-xs border-2 border-gray-300">
                                    {{ strtoupper(substr($participant['name'], 0, 1)) }}
                                </div>
                            @endif
                        </div>
                        
                        <!-- Participant Info -->
                        <div class="flex-1 min-w-0">
                            <div class="flex items-center gap-2 landscape:gap-1">
                                <p class="text-sm landscape:text-xs font-medium text-gray-900 truncate">
                                    {{ $participant['name'] }}
                                </p>
                                @if($participant['is_current_user'])
                                    <span class="inline-flex items-center px-2 py-0.5 landscape:px-1.5 landscape:py-0.5 rounded-full text-xs landscape:text-xs font-bold bg-blue-600 text-white">
                                        You
                                    </span>
                                @endif
                            </div>
                            <p class="text-xs landscape:text-xs text-gray-500 truncate">
                                {{ $participant['phone'] }}
                            </p>
                            <div class="flex items-center mt-1">
                                @if($participant['status'] === 'in_progress')
                                    <span class="inline-flex items-center px-2 py-1 landscape:px-1.5 landscape:py-0.5 rounded-full text-xs landscape:text-xs font-medium bg-green-100 text-green-800">
                                        <span class="w-2 h-2 landscape:w-1.5 landscape:h-1.5 bg-green-400 rounded-full mr-1 animate-pulse"></span>
                                        <span class="landscape:hidden">Taking Quiz</span>
                                        <span class="hidden landscape:inline">Active</span>
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2 py-1 landscape:px-1.5 landscape:py-0.5 rounded-full text-xs landscape:text-xs font-medium bg-gray-100 text-gray-800">
                                        <span class="w-2 h-2 landscape:w-1.5 landscape:h-1.5 bg-gray-400 rounded-full mr-1"></span>
                                        <span class="landscape:hidden">Completed</span>
                                        <span class="hidden landscape:inline">Done</span>
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-8 landscape:py-4">
                        <svg class="w-12 h-12 landscape:w-8 landscape:h-8 mx-auto text-gray-400 mb-3 landscape:mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                        <p class="text-sm landscape:text-xs text-gray-500">No other participants yet</p>
                    </div>
                @endforelse
            </div>
        </div>

        <!-- Main Quiz Container -->
        <div class="w-full max-w-4xl landscape:max-w-3xl bg-white rounded-2xl sm:rounded-3xl shadow-2xl p-2 sm:p-4 md:p-6 lg:p-8 xl:p-12 landscape:p-4">
            <!-- Mobile Participants Section -->
            <div class="lg:hidden landscape:hidden mb-4 sm:mb-6 bg-blue-50 p-3 sm:p-4 rounded-xl">
                <h3 class="text-base sm:text-lg font-semibold text-gray-800 mb-2 sm:mb-3 flex items-center">
                    <svg class="w-4 h-4 sm:w-5 sm:h-5 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                    </svg>
                    Participants ({{ $participants->count() }})
                </h3>
                <div class="flex space-x-2 sm:space-x-3 overflow-x-auto pb-2 scrollbar-hide">
                    @forelse($participants as $participant)
                        <div class="flex-shrink-0 flex items-center space-x-2 sm:space-x-3 p-2 sm:p-3 bg-white rounded-lg shadow-sm border border-gray-200 min-w-0 min-w-[140px] sm:min-w-[160px]">
                            <div class="flex-shrink-0">
                                @if($participant['photo'])
                                    <img src="{{ asset('storage/' . $participant['photo']) }}" 
                                         alt="{{ $participant['name'] }}" 
                                         class="w-8 h-8 sm:w-10 sm:h-10 rounded-full object-cover border border-gray-300">
                                @else
                                    <div class="w-8 h-8 sm:w-10 sm:h-10 rounded-full bg-gradient-to-br from-blue-400 to-blue-600 flex items-center justify-center text-white font-semibold text-xs sm:text-sm border border-gray-300">
                                        {{ strtoupper(substr($participant['name'], 0, 1)) }}
                                    </div>
                                @endif
                            </div>
                            <div class="min-w-0 flex-1">
                                <div class="flex items-center gap-1">
                                    <p class="text-xs sm:text-sm font-medium text-gray-900 truncate">
                                        {{ $participant['name'] }}
                                    </p>
                                    @if($participant['is_current_user'])
                                        <span class="inline-flex items-center px-1.5 py-0.5 rounded-full text-xs font-bold bg-blue-600 text-white">
                                            You
                                        </span>
                                    @endif
                                </div>
                                <div class="flex items-center mt-1">
                                    @if($participant['status'] === 'in_progress')
                                        <span class="w-2 h-2 bg-green-400 rounded-full animate-pulse"></span>
                                        <span class="ml-1 text-xs text-green-600">Active</span>
                                    @else
                                        <span class="w-2 h-2 bg-gray-400 rounded-full"></span>
                                        <span class="ml-1 text-xs text-gray-500">Done</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @empty
                        <p class="text-sm text-gray-500">No other participants yet</p>
                    @endforelse
                </div>
            </div>

            <!-- Header and Progress -->
            <header class="text-center mb-4 sm:mb-6 md:mb-8">
                <h1 class="text-xl sm:text-2xl md:text-3xl lg:text-4xl xl:text-5xl font-extrabold text-blue-700 tracking-tight mb-2 px-2">{{ $exam->title }}</h1>
                <p class="text-xs sm:text-sm md:text-base text-gray-500 font-medium px-2">{{ $exam->description ?? 'Test your knowledge with our curated questions!' }}</p>
                
                <!-- Countdown Timer and Progress Bar -->
                <div class="flex flex-col sm:flex-row items-center justify-between mt-3 sm:mt-4 md:mt-6 gap-3 sm:gap-4 px-2">
                    <div class="flex flex-col items-center order-1 sm:order-1">
                        <div id="countdown-timer" class="w-14 h-14 sm:w-16 sm:h-16 md:w-20 md:h-20 rounded-full flex items-center justify-center p-1 sm:p-2 watch-bezel">
                            <div id="countdown-display" class="w-full h-full rounded-full flex items-center justify-center text-center font-bold text-xs sm:text-sm md:text-base text-gray-100 bg-gray-900 shadow-inner watch-face border-2 border-gray-600">
                                --:--
                            </div>
                        </div>
                        <div id="timer-status" class="text-xs sm:text-sm font-medium text-gray-600 mt-1 sm:mt-2 text-center">
                            Time Remaining
                        </div>
                    </div>
                    <div class="relative flex-1 w-full sm:w-auto order-2 sm:order-2 max-w-xs sm:max-w-none">
                        <div class="overflow-hidden h-2 sm:h-3 mb-2 text-xs flex rounded-full bg-gray-200 shadow-inner">
                            <div id="progress-bar" style="width:0%" class="shadow-none flex flex-col text-center whitespace-nowrap text-white justify-center bg-blue-500 transition-all duration-500 ease-in-out rounded-full shadow-lg"></div>
                        </div>
                        <div class="flex justify-between text-xs sm:text-sm font-semibold text-gray-500">
                            <span id="current-question-display">Question 1</span>
                            <span id="total-questions-display">of {{ $questions->count() }}</span>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Main Quiz Section with Navigator -->
            <div class="flex flex-col lg:flex-row landscape:flex-row gap-4 sm:gap-6 lg:gap-8 landscape:gap-4">
                <!-- Question Block -->
                <main class="w-full lg:w-2/3 landscape:w-2/3">
                    <form id="examForm" action="{{ route('public.quiz.submit', $exam) }}" method="POST">
                        @csrf
                        
                        <div class="mb-4 sm:mb-6 md:mb-8">
                            <h2 id="question-text" class="text-base sm:text-lg md:text-xl lg:text-2xl font-bold mb-3 sm:mb-4 md:mb-6 px-1"></h2>
                            <div id="options-container" class="space-y-2 sm:space-y-3 md:space-y-4">
                                <!-- Options will be dynamically added here -->
                            </div>
                        </div>

                        <!-- Navigation Buttons -->
                        <div class="nav-buttons flex flex-row justify-between items-center mt-4 sm:mt-6 md:mt-8 lg:mt-10 gap-1 sm:gap-2 md:gap-3">
                            <button type="button" id="prev-btn" class="flex-1 sm:flex-none px-2 sm:px-4 md:px-6 py-2 sm:py-2.5 md:py-3 rounded-full text-xs sm:text-sm font-semibold text-gray-700 bg-gray-200 hover:bg-gray-300 transition-colors duration-200 disabled:opacity-50 disabled:cursor-not-allowed min-h-[44px] sm:min-h-[40px]">
                                <span class="hidden sm:inline">← Previous</span>
                                <span class="sm:hidden">← Prev</span>
                            </button>
                            <button type="button" id="skip-btn" class="flex-1 sm:flex-none px-2 sm:px-4 md:px-6 py-2 sm:py-2.5 md:py-3 rounded-full text-xs sm:text-sm font-semibold text-white bg-orange-500 hover:bg-orange-600 transition-colors duration-200 shadow-lg min-h-[44px] sm:min-h-[40px]">
                                <span class="hidden sm:inline">Skip</span>
                                <span class="sm:hidden">Skip</span>
                            </button>
                            <button type="button" id="next-btn" class="flex-1 sm:flex-none px-2 sm:px-4 md:px-6 py-2 sm:py-2.5 md:py-3 rounded-full text-xs sm:text-sm font-semibold text-white bg-blue-500 hover:bg-blue-600 transition-colors duration-200 min-h-[44px] sm:min-h-[40px]">
                                <span class="hidden sm:inline">Next →</span>
                                <span class="sm:hidden">Next →</span>
                            </button>
                        </div>
                    </form>
                </main>
                
                <!-- Question Navigator and Legend -->
                <div class="w-full lg:w-1/3 landscape:w-1/3 bg-gray-50 p-3 sm:p-4 md:p-6 landscape:p-4 rounded-xl shadow-inner">
                    <h3 class="text-sm sm:text-base md:text-lg font-semibold text-gray-800 mb-2 sm:mb-3 md:mb-4">Question Navigator</h3>
                    <div id="navigator-container" class="grid grid-cols-6 sm:grid-cols-7 md:grid-cols-8 lg:grid-cols-6 gap-1 sm:gap-1.5 md:gap-2 mb-3 sm:mb-4 md:mb-6">
                        <!-- Navigator buttons dynamically added here -->
                    </div>

                    <!-- Legend -->
                    <div class="mb-4">
                        <h4 class="text-xs sm:text-sm font-semibold text-gray-600 mb-1.5 sm:mb-2">Legend</h4>
                        <div class="space-y-1.5 sm:space-y-2">
                            <div class="flex items-center">
                                <span class="block w-3 h-3 sm:w-4 sm:h-4 rounded-full bg-blue-500"></span>
                                <span class="ml-2 text-xs sm:text-sm text-gray-700">Current Question</span>
                            </div>
                            <div class="flex items-center">
                                <span class="block w-3 h-3 sm:w-4 sm:h-4 rounded-full bg-green-500"></span>
                                <span class="ml-2 text-xs sm:text-sm text-gray-700">Answered</span>
                            </div>
                            <div class="flex items-center">
                                <span class="block w-3 h-3 sm:w-4 sm:h-4 rounded-full bg-orange-500"></span>
                                <span class="ml-2 text-xs sm:text-sm text-gray-700">Skipped</span>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Submit Button -->
                    <button type="button" id="submit-btn" class="w-full px-4 py-3 rounded-full text-sm font-bold text-white bg-green-500 hover:bg-green-600 transition-colors duration-200 shadow-lg">
                        <span class="hidden sm:inline">🚀 Submit Quiz</span>
                        <span class="sm:hidden">Submit</span>
                    </button>
                </div>
            </div>

            <!-- Result Modal -->
            <div id="result-modal" class="fixed inset-0 bg-gray-900 bg-opacity-75 flex items-center justify-center p-2 sm:p-4 transition-opacity duration-300 hidden z-50">
                <div class="bg-white rounded-xl p-4 sm:p-6 md:p-8 lg:p-10 text-center shadow-lg transform transition-transform duration-300 scale-95 w-full max-w-xs sm:max-w-sm md:max-w-md mx-2">
                    <h3 id="modal-title" class="text-base sm:text-lg md:text-xl lg:text-2xl font-bold mb-2 sm:mb-3 md:mb-4 px-2"></h3>
                    <p id="modal-message" class="text-xs sm:text-sm md:text-base lg:text-lg text-gray-700 mb-3 sm:mb-4 md:mb-6 px-2"></p>
                    <button id="close-modal-btn" class="w-full sm:w-auto px-4 sm:px-6 py-2 sm:py-3 rounded-full text-xs sm:text-sm font-semibold text-white bg-green-500 hover:bg-green-600 transition-colors duration-200 min-h-[44px]">
                        Okay
                    </button>
                </div>
            </div>

            <!-- Completion Message Modal -->
            <div id="completion-modal" class="fixed inset-0 bg-gray-900 bg-opacity-75 flex items-center justify-center p-2 sm:p-4 transition-opacity duration-300 hidden z-50">
                <div class="bg-white rounded-xl p-4 sm:p-6 md:p-8 lg:p-10 text-center shadow-lg transform transition-transform duration-300 scale-95 w-full max-w-xs sm:max-w-sm md:max-w-md mx-2">
                    <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <h3 id="completion-modal-title" class="text-base sm:text-lg md:text-xl lg:text-2xl font-bold mb-2 sm:mb-3 md:mb-4 px-2"></h3>
                    <p id="completion-modal-message" class="text-xs sm:text-sm md:text-base lg:text-lg text-gray-700 mb-3 sm:mb-4 md:mb-6 px-2"></p>
                    <div class="flex flex-col sm:flex-row gap-2 sm:gap-3">
                        <button id="review-btn" class="w-full sm:w-1/2 px-4 sm:px-6 py-2 sm:py-3 rounded-full text-xs sm:text-sm font-semibold text-white bg-blue-500 hover:bg-blue-600 transition-colors duration-200 min-h-[44px]">
                            Review Answers
                        </button>
                        <button id="submit-exam-btn" class="w-full sm:w-1/2 px-4 sm:px-6 py-2 sm:py-3 rounded-full text-xs sm:text-sm font-bold text-white bg-green-500 hover:bg-green-600 transition-colors duration-200 min-h-[44px]">
                            Submit Exam
                        </button>
                    </div>
                    <button id="close-completion-modal-btn" class="mt-3 w-full px-4 sm:px-6 py-2 sm:py-3 rounded-full text-xs sm:text-sm font-semibold text-gray-700 bg-gray-200 hover:bg-gray-300 transition-colors duration-200 min-h-[44px]">
                        Continue
                    </button>
                </div>
            </div>
        </div>
    </div>

    <style>
    /* Copy Protection Styles */
    * {
        -webkit-user-select: none !important;
        -moz-user-select: none !important;
        -ms-user-select: none !important;
        user-select: none !important;
        -webkit-touch-callout: none !important;
        -webkit-tap-highlight-color: transparent !important;
    }
    
    /* Allow selection only for input fields and textareas */
    input, textarea, [contenteditable="true"] {
        -webkit-user-select: text !important;
        -moz-user-select: text !important;
        -ms-user-select: text !important;
        user-select: text !important;
    }
    
    /* Disable drag and drop */
    * {
        -webkit-user-drag: none !important;
        -khtml-user-drag: none !important;
        -moz-user-drag: none !important;
        -o-user-drag: none !important;
        user-drag: none !important;
    }
    
    /* Hide text cursor */
    body {
        cursor: default !important;
    }
    
    /* Disable image dragging */
    img {
        -webkit-user-drag: none !important;
        -khtml-user-drag: none !important;
        -moz-user-drag: none !important;
        -o-user-drag: none !important;
        user-drag: none !important;
        pointer-events: none !important;
    }
    
    /* Allow pointer events for interactive elements */
    button, a, input, textarea, select, [onclick], .tab-button, .btn, .button, .option-btn, .navigator-btn {
        pointer-events: auto !important;
        -webkit-user-select: auto !important;
        -moz-user-select: auto !important;
        -ms-user-select: auto !important;
        user-select: auto !important;
        -webkit-touch-callout: auto !important;
    }
    
    /* Allow selection and interaction for quiz elements */
    .option-btn, .navigator-btn, button, input, textarea, select {
        -webkit-user-select: auto !important;
        -moz-user-select: auto !important;
        -ms-user-select: auto !important;
        user-select: auto !important;
        -webkit-touch-callout: auto !important;
        -webkit-tap-highlight-color: rgba(0, 0, 0, 0.1) !important;
    }
    
    /* Allow text selection within quiz content */
    #question-text, .option-btn span, .navigator-btn {
        -webkit-user-select: text !important;
        -moz-user-select: text !important;
        -ms-user-select: text !important;
        user-select: text !important;
    }
    
    /* Disable context menu */
    body {
        -webkit-context-menu: none !important;
        -moz-context-menu: none !important;
        -ms-context-menu: none !important;
        context-menu: none !important;
    }
    
    
    .option-btn.selected {
        background-color: #22c55e;
        color: white;
        border-color: #22c55e;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        position: relative;
    }
    .option-btn.selected:hover {
        background-color: #16a34a;
    }
    
    /* Ensure quiz elements are fully interactive */
    .option-btn, .navigator-btn {
        cursor: pointer !important;
        -webkit-user-select: none !important;
        -moz-user-select: none !important;
        -ms-user-select: none !important;
        user-select: none !important;
        -webkit-touch-callout: none !important;
        -webkit-tap-highlight-color: rgba(0, 0, 0, 0.1) !important;
    }
    
    .option-btn:hover, .navigator-btn:hover {
        transform: translateY(-1px);
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }
    
    .option-btn:active, .navigator-btn:active {
        transform: translateY(0);
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }
    .navigator-btn.current {
        background-color: #3b82f6;
        color: white;
        border-color: #3b82f6;
    }
    .navigator-btn.answered {
        background-color: #22c55e;
        color: white;
        border-color: #22c55e;
    }
    .navigator-btn.skipped {
        background-color: #f97316;
        color: white;
        border-color: #f97316;
    }
    .selected-icon {
        position: absolute;
        right: 0.75rem;
        top: 50%;
        transform: translateY(-50%);
        width: 1rem;
        height: 1rem;
    }
    @media (min-width: 640px) {
        .selected-icon {
            right: 1rem;
            width: 1.5rem;
            height: 1.5rem;
        }
    }
    @keyframes pulse-once {
        0% { transform: scale(1); }
        50% { transform: scale(1.05); }
        100% { transform: scale(1); }
    }
    .animate-pulse-once {
        animation: pulse-once 0.5s ease-in-out;
    }
    .watch-bezel {
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1), inset 0 2px 4px rgba(255, 255, 255, 0.5), inset 0 -2px 4px rgba(0, 0, 0, 0.2);
        background-image: linear-gradient(145deg, #e0e0e0, #ffffff);
    }
    .watch-face {
        box-shadow: inset 0 2px 4px rgba(0, 0, 0, 0.6);
    }
    
    /* Mobile-specific improvements */
    @media (max-width: 640px) {
        .option-btn {
            min-height: 48px; /* Better touch target */
            padding: 12px 16px;
            font-size: 14px;
        }
        .navigator-btn {
            min-height: 36px;
            min-width: 36px;
            font-size: 12px;
        }
        .option-btn.selected .selected-icon {
            right: 0.5rem;
            width: 0.875rem;
            height: 0.875rem;
        }
        
        /* Better spacing for mobile */
        .main-quiz-container {
            margin: 0;
            border-radius: 16px;
        }
        
        /* Improve text readability on mobile */
        h1, h2, h3 {
            line-height: 1.2;
        }
        
        /* Better button spacing */
        .nav-buttons {
            gap: 8px;
        }
    }
    
    /* Extra small mobile devices */
    @media (max-width: 480px) {
        .option-btn {
            min-height: 52px;
            padding: 14px 12px;
            font-size: 13px;
        }
        
        .navigator-btn {
            min-height: 24px;
            min-width: 24px;
            font-size: 9px;
        }
        
        /* Reduce padding on very small screens */
        .main-container {
            padding: 4px;
        }
        
        .quiz-container {
            padding: 12px;
        }
        
        /* More columns on very small screens */
        #navigator-container {
            grid-template-columns: repeat(auto-fit, minmax(24px, 1fr)) !important;
            gap: 2px !important;
        }
    }
    
    /* Small mobile devices */
    @media (min-width: 481px) and (max-width: 640px) {
        #navigator-container {
            grid-template-columns: repeat(auto-fit, minmax(32px, 1fr)) !important;
            gap: 4px !important;
        }
        
        .navigator-btn {
            min-height: 32px !important;
            min-width: 32px !important;
            font-size: 11px !important;
        }
    }
    
    /* Medium mobile devices */
    @media (min-width: 641px) and (max-width: 768px) {
        #navigator-container {
            grid-template-columns: repeat(auto-fit, minmax(36px, 1fr)) !important;
            gap: 5px !important;
        }
        
        .navigator-btn {
            min-height: 36px !important;
            min-width: 36px !important;
            font-size: 12px !important;
        }
    }
    
    /* Prevent zoom on input focus on mobile */
    @media screen and (max-width: 768px) {
        input, textarea, select {
            font-size: 16px !important;
        }
    }
    
    /* Hide scrollbar for mobile participants */
    .scrollbar-hide {
        -ms-overflow-style: none;
        scrollbar-width: none;
    }
    .scrollbar-hide::-webkit-scrollbar {
        display: none;
    }
    
    /* Better touch targets for mobile */
    @media (max-width: 768px) {
        button, .option-btn, .navigator-btn {
            min-height: 44px;
            touch-action: manipulation;
        }
        
        /* Improve tap targets */
        .option-btn:active {
            transform: scale(0.98);
        }
        
        .navigator-btn:active {
            transform: scale(0.95);
        }
        
        /* Navigation buttons in single row */
        .nav-buttons {
            gap: 4px;
        }
        
        /* Ensure buttons fit well in single row */
        #prev-btn, #skip-btn, #submit-btn, #next-btn {
            font-size: 11px;
            padding: 8px 4px;
            min-height: 40px;
        }
        
        /* Make sure text doesn't wrap */
        .nav-buttons button {
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
        
        /* Responsive question navigator grid */
        #navigator-container {
            grid-template-columns: repeat(auto-fit, minmax(28px, 1fr)) !important;
            gap: 3px !important;
        }
        
        /* Smaller navigator buttons on mobile */
        .navigator-btn {
            min-height: 28px !important;
            min-width: 28px !important;
            font-size: 10px !important;
            padding: 2px !important;
        }
    }
    
    /* Landscape mobile optimization */
    @media (max-width: 768px) and (orientation: landscape) {
        .main-container {
            padding: 8px;
        }
        
        .quiz-container {
            padding: 16px;
        }
        
        .header {
            margin-bottom: 16px;
        }
        
        .timer-container {
            flex-direction: row;
            gap: 16px;
        }
        
        /* Force desktop layout in landscape */
        .flex-col.lg\\:flex-row {
            flex-direction: row !important;
        }
        
        /* Adjust main container for landscape */
        .w-full.max-w-4xl {
            max-width: calc(100vw - 280px) !important;
        }
        
        /* Ensure proper spacing in landscape */
        .gap-2.sm\\:gap-4.lg\\:gap-6 {
            gap: 1rem !important;
        }
        
        /* Adjust header spacing for landscape */
        .mb-4.sm\\:mb-6.md\\:mb-8 {
            margin-bottom: 1.5rem !important;
        }
        
        /* Adjust question text size for landscape */
        .text-base.sm\\:text-lg.md\\:text-xl.lg\\:text-2xl {
            font-size: 1.125rem !important;
        }
        
        /* Adjust option buttons for landscape */
        .option-btn {
            min-height: 40px !important;
            padding: 8px 12px !important;
            font-size: 13px !important;
        }
        
        /* Adjust navigator buttons for landscape */
        .navigator-btn {
            min-height: 32px !important;
            min-width: 32px !important;
            font-size: 11px !important;
        }
        
        /* Adjust timer for landscape */
        .w-14.h-14.sm\\:w-16.sm\\:h-16.md\\:w-20.md\\:h-20 {
            width: 3.5rem !important;
            height: 3.5rem !important;
        }
        
        /* Adjust progress bar for landscape */
        .h-2.sm\\:h-3 {
            height: 0.5rem !important;
        }
    }
    </style>

    <script>
    // Copy Protection JavaScript
    (function() {
        'use strict';
        
        // Disable right-click context menu
        document.addEventListener('contextmenu', function(e) {
            e.preventDefault();
            return false;
        });
        
        // Disable keyboard shortcuts for copy, cut, paste, select all, print, save
        document.addEventListener('keydown', function(e) {
            // Disable Ctrl+A (Select All)
            if (e.ctrlKey && e.keyCode === 65) {
                e.preventDefault();
                return false;
            }
            // Disable Ctrl+C (Copy)
            if (e.ctrlKey && e.keyCode === 67) {
                e.preventDefault();
                return false;
            }
            // Disable Ctrl+X (Cut)
            if (e.ctrlKey && e.keyCode === 88) {
                e.preventDefault();
                return false;
            }
            // Disable Ctrl+V (Paste)
            if (e.ctrlKey && e.keyCode === 86) {
                e.preventDefault();
                return false;
            }
            // Disable Ctrl+P (Print)
            if (e.ctrlKey && e.keyCode === 80) {
                e.preventDefault();
                return false;
            }
            // Disable Ctrl+S (Save)
            if (e.ctrlKey && e.keyCode === 83) {
                e.preventDefault();
                return false;
            }
            // Disable F12 (Developer Tools)
            if (e.keyCode === 123) {
                e.preventDefault();
                return false;
            }
            // Disable Ctrl+Shift+I (Developer Tools)
            if (e.ctrlKey && e.shiftKey && e.keyCode === 73) {
                e.preventDefault();
                return false;
            }
            // Disable Ctrl+Shift+J (Console)
            if (e.ctrlKey && e.shiftKey && e.keyCode === 74) {
                e.preventDefault();
                return false;
            }
            // Disable Ctrl+U (View Source)
            if (e.ctrlKey && e.keyCode === 85) {
                e.preventDefault();
                return false;
            }
            // Disable Ctrl+Shift+C (Inspect Element)
            if (e.ctrlKey && e.shiftKey && e.keyCode === 67) {
                e.preventDefault();
                return false;
            }
        });
        
        // Disable text selection except for quiz elements
        document.addEventListener('selectstart', function(e) {
            // Allow selection for quiz interactive elements
            if (e.target.closest('.option-btn, .navigator-btn, button, input, textarea, select, #question-text')) {
                return true;
            }
            e.preventDefault();
            return false;
        });
        
        // Disable drag start
        document.addEventListener('dragstart', function(e) {
            e.preventDefault();
            return false;
        });
        
        // Disable print
        window.addEventListener('beforeprint', function(e) {
            e.preventDefault();
            return false;
        });
        
        // Developer tools detection
        let devtools = {open: false, orientation: null};
        const threshold = 160;
        
        setInterval(function() {
            if (window.outerHeight - window.innerHeight > threshold || 
                window.outerWidth - window.innerWidth > threshold) {
                if (!devtools.open) {
                    devtools.open = true;
                    // Redirect or show warning when dev tools are opened
                    document.body.innerHTML = '<div style="display:flex;justify-content:center;align-items:center;height:100vh;font-family:Arial;font-size:24px;color:red;">Developer tools detected. This page is protected.</div>';
                }
            } else {
                devtools.open = false;
            }
        }, 500);
        
        // Disable console
        console.clear();
        console.log = function() {};
        console.warn = function() {};
        console.error = function() {};
        console.info = function() {};
        console.debug = function() {};
        
        // Disable image saving
        document.addEventListener('dragstart', function(e) {
            if (e.target.tagName === 'IMG') {
                e.preventDefault();
                return false;
            }
        });
        
        // Disable text selection with mouse except for quiz elements
        document.addEventListener('mousedown', function(e) {
            // Allow interaction for quiz elements
            if (e.target.closest('.option-btn, .navigator-btn, button, input, textarea, select, #question-text')) {
                return true;
            }
            if (e.detail > 1) { // Multiple clicks
                e.preventDefault();
                return false;
            }
        });
        
        // Disable text selection with touch except for quiz elements
        document.addEventListener('touchstart', function(e) {
            // Allow interaction for quiz elements
            if (e.target.closest('.option-btn, .navigator-btn, button, input, textarea, select, #question-text')) {
                return true;
            }
            if (e.touches.length > 1) {
                e.preventDefault();
                return false;
            }
        });
        
        // Disable long press context menu on mobile except for quiz elements
        document.addEventListener('touchend', function(e) {
            // Allow interaction for quiz elements
            if (e.target.closest('.option-btn, .navigator-btn, button, input, textarea, select, #question-text')) {
                return true;
            }
            e.preventDefault();
        });
        
        // Disable zoom on double tap except for quiz elements
        let lastTouchEnd = 0;
        document.addEventListener('touchend', function(e) {
            // Allow interaction for quiz elements
            if (e.target.closest('.option-btn, .navigator-btn, button, input, textarea, select, #question-text')) {
                return true;
            }
            const now = (new Date()).getTime();
            if (now - lastTouchEnd <= 300) {
                e.preventDefault();
            }
            lastTouchEnd = now;
        }, false);
        
        
    })();
    
    // Questions data
    @php
    $questionsData = $questions->map(function($q) {
        $options = [];
        if (!empty($q->option_a)) $options[] = $q->option_a;
        if (!empty($q->option_b)) $options[] = $q->option_b;
        if (!empty($q->option_c)) $options[] = $q->option_c;
        if (!empty($q->option_d)) $options[] = $q->option_d;
        
        return [
            'id' => $q->id,
            'question' => $q->question_text,
            'type' => $q->question_type ?? 'mcq',
            'options' => $options,
            'marks' => $q->marks ?? 1
        ];
    })->toArray();
    @endphp
    const questions = @json($questionsData);

    // State management
    const state = {
        currentQuestionIndex: 0,
        answers: new Array(questions.length).fill(null),
        skipped: new Array(questions.length).fill(false),
        isSubmitted: false,
        timer: null
    };

    // Load state from localStorage if available
    function loadStateFromStorage() {
        try {
            const savedState = localStorage.getItem(`exam_${examId}_state`);
            const savedTime = localStorage.getItem(`exam_${examId}_time`);
            
            if (savedState) {
                const parsedState = JSON.parse(savedState);
                state.currentQuestionIndex = parsedState.currentQuestionIndex || 0;
                state.answers = parsedState.answers || new Array(questions.length).fill(null);
                state.skipped = parsedState.skipped || new Array(questions.length).fill(false);
                state.isSubmitted = parsedState.isSubmitted || false;
            }
            
            if (savedTime) {
                const savedTimeRemaining = parseInt(savedTime);
                if (!isNaN(savedTimeRemaining) && savedTimeRemaining > 0) {
                    timeRemaining = savedTimeRemaining;
                }
            }
        } catch (e) {
            console.error('Error loading state from storage:', e);
        }
    }

    // Save state to localStorage
    function saveStateToStorage() {
        try {
            const stateToSave = {
                currentQuestionIndex: state.currentQuestionIndex,
                answers: state.answers,
                skipped: state.skipped,
                isSubmitted: state.isSubmitted
            };
            localStorage.setItem(`exam_${examId}_state`, JSON.stringify(stateToSave));
            localStorage.setItem(`exam_${examId}_time`, timeRemaining.toString());
        } catch (e) {
            console.error('Error saving state to storage:', e);
        }
    }

    // Clear state from localStorage (when exam is submitted)
    function clearStateFromStorage() {
        try {
            localStorage.removeItem(`exam_${examId}_state`);
            localStorage.removeItem(`exam_${examId}_time`);
        } catch (e) {
            console.error('Error clearing state from storage:', e);
        }
    }

    const QUIZ_DURATION = {{ $exam->duration * 60 }};
    let timeRemaining = {{ $remainingTime }};
    const examId = {{ $exam->id }};

    // Load saved state on initialization
    loadStateFromStorage();

    // DOM elements
    const questionTextEl = document.getElementById('question-text');
    const optionsContainerEl = document.getElementById('options-container');
    const prevBtn = document.getElementById('prev-btn');
    const nextBtn = document.getElementById('next-btn');
    const skipBtn = document.getElementById('skip-btn');
    const submitBtn = document.getElementById('submit-btn');
    const progressBar = document.getElementById('progress-bar');
    const currentQuestionDisplay = document.getElementById('current-question-display');
    const countdownDisplayEl = document.getElementById('countdown-display');
    const timerStatusEl = document.getElementById('timer-status');
    const navigatorContainer = document.getElementById('navigator-container');
    const resultModal = document.getElementById('result-modal');
    const modalTitle = document.getElementById('modal-title');
    const modalMessage = document.getElementById('modal-message');
    const closeModalBtn = document.getElementById('close-modal-btn');
    const examForm = document.getElementById('examForm');
    // Completion modal elements
    const completionModal = document.getElementById('completion-modal');
    const completionModalTitle = document.getElementById('completion-modal-title');
    const completionModalMessage = document.getElementById('completion-modal-message');
    const reviewBtn = document.getElementById('review-btn');
    const submitExamBtn = document.getElementById('submit-exam-btn');
    const closeCompletionModalBtn = document.getElementById('close-completion-modal-btn');

    // Rendering functions
    function render() {
        renderQuestion();
            updateNavigation();
            updateProgress();
        renderNavigator();
    }

    function renderQuestion() {
        const question = questions[state.currentQuestionIndex];
        // Clean question text by removing any "(Question #)" patterns
        const cleanQuestionText = question.question.replace(/\s*\(Question\s*#?\d*\)/gi, '').trim();
        questionTextEl.textContent = `${state.currentQuestionIndex + 1}. ${cleanQuestionText}`;
        optionsContainerEl.innerHTML = '';
        
        // Determine if we should use Bangla option labels
        const useBanglaLabels = "{{ $exam->question_language }}" === "bangla";
        
        if (question.type === 'mcq' && question.options.length > 0) {
            question.options.forEach((option, index) => {
                const optionBtn = document.createElement('button');
                optionBtn.type = 'button';
                optionBtn.className = 'option-btn w-full text-left px-3 sm:px-4 md:px-6 py-2.5 sm:py-3 md:py-4 rounded-xl border-2 border-gray-200 text-sm sm:text-base md:text-lg font-medium transition-colors duration-200 hover:bg-gray-100 flex items-center gap-2 sm:gap-3 md:gap-4';
                
                // Create option label (A, B, C, D or Bangla equivalents)
                const optionLabel = document.createElement('div');
                optionLabel.className = 'flex-shrink-0 w-5 h-5 sm:w-6 sm:h-6 md:w-8 md:h-8 rounded-full bg-blue-100 text-blue-600 font-bold text-xs sm:text-sm flex items-center justify-center border-2 border-blue-200';
                
                // Use Bangla labels if question_language is bangla, otherwise use English
                if (useBanglaLabels) {
                    // Use the ba, bb, bc, bd values from the exam
                    const banglaLabels = [
                        "{{ $exam->ba ?? 'ক' }}",
                        "{{ $exam->bb ?? 'খ' }}",
                        "{{ $exam->bc ?? 'গ' }}",
                        "{{ $exam->bd ?? 'ঘ' }}"
                    ];
                    optionLabel.textContent = banglaLabels[index] || String.fromCharCode(65 + index);
                } else {
                    optionLabel.textContent = String.fromCharCode(65 + index); // A, B, C, D
                }
                
                // Create option text
                const optionText = document.createElement('span');
                optionText.className = 'flex-1';
                optionText.textContent = option;
                
                optionBtn.appendChild(optionLabel);
                optionBtn.appendChild(optionText);
                
                // Check if this option is selected by comparing with the stored option letter
                const optionLetter = String.fromCharCode(65 + index).toLowerCase(); // A, B, C, D -> a, b, c, d
                if (state.answers[state.currentQuestionIndex] === optionLetter) {
                    optionBtn.classList.add('selected');
                    optionLabel.classList.remove('bg-blue-100', 'text-blue-600', 'border-blue-200');
                    optionLabel.classList.add('bg-blue-600', 'text-white', 'border-blue-600');
                    
                    const checkIcon = document.createElementNS("http://www.w3.org/2000/svg", "svg");
                    checkIcon.setAttribute("class", "selected-icon");
                    checkIcon.setAttribute("viewBox", "0 0 24 24");
                    checkIcon.setAttribute("fill", "none");
                    checkIcon.setAttribute("stroke", "currentColor");
                    checkIcon.setAttribute("stroke-width", "2");
                    checkIcon.setAttribute("stroke-linecap", "round");
                    checkIcon.setAttribute("stroke-linejoin", "round");
                    checkIcon.innerHTML = '<polyline points="20 6 9 17 4 12"></polyline>';
                    optionBtn.appendChild(checkIcon);
                }

                optionBtn.addEventListener('click', () => {
                    if (!state.isSubmitted) {
                        // Store the option letter (A, B, C, D) instead of the full text
                        const optionLetter = String.fromCharCode(65 + index).toLowerCase(); // A, B, C, D -> a, b, c, d
                        state.answers[state.currentQuestionIndex] = optionLetter;
                        state.skipped[state.currentQuestionIndex] = false;
                        render();
                        saveStateToStorage(); // Save state after each answer
                    }
                });

                optionsContainerEl.appendChild(optionBtn);
            });
        } else if (question.type === 'descriptive') {
            const textarea = document.createElement('textarea');
            textarea.name = `answers[${question.id}]`;
            textarea.rows = 4;
            textarea.className = 'w-full px-3 sm:px-4 py-2 sm:py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 resize-none text-sm sm:text-base min-h-[100px]';
            textarea.placeholder = 'Type your detailed answer here...';
            textarea.value = state.answers[state.currentQuestionIndex] || '';
            
            textarea.addEventListener('input', () => {
                if (!state.isSubmitted) {
                    state.answers[state.currentQuestionIndex] = textarea.value;
                    state.skipped[state.currentQuestionIndex] = false;
                    updateProgress();
                    updateNavigation();
                    renderNavigator();
                }
            });
            
            optionsContainerEl.appendChild(textarea);
        }
    }

    function renderNavigator() {
        navigatorContainer.innerHTML = '';
        questions.forEach((q, index) => {
            const navBtn = document.createElement('button');
            navBtn.type = 'button';
            navBtn.textContent = index + 1;
            navBtn.className = 'navigator-btn w-7 h-7 sm:w-8 sm:h-8 rounded-full text-xs font-semibold flex items-center justify-center border-2 border-gray-300';

            if (index === state.currentQuestionIndex) {
                navBtn.classList.add('current');
            } else if (state.answers[index] !== null) {
                navBtn.classList.add('answered');
            } else if (state.skipped[index]) {
                navBtn.classList.add('skipped');
            }
            
            navBtn.addEventListener('click', () => {
                if (!state.isSubmitted) {
                    state.currentQuestionIndex = index;
                    render();
                }
            });
            navigatorContainer.appendChild(navBtn);
        });
    }

    function updateNavigation() {
        const currentAnswer = state.answers[state.currentQuestionIndex];
        const hasAnswer = currentAnswer !== null && currentAnswer.trim() !== '';
        
        prevBtn.disabled = state.currentQuestionIndex === 0 || state.isSubmitted;
        // Always keep next button enabled, even on the last question
        nextBtn.disabled = state.isSubmitted || (!hasAnswer && state.currentQuestionIndex < questions.length - 1);
        skipBtn.style.display = state.isSubmitted ? 'none' : 'block';
        submitBtn.style.display = state.isSubmitted ? 'none' : 'block';
        
        // Update next button text based on position
        if (state.currentQuestionIndex === questions.length - 1) {
            nextBtn.innerHTML = '<span class="hidden sm:inline">Jump to Skipped</span><span class="sm:hidden">Skip →</span>';
        } else {
            nextBtn.innerHTML = '<span class="hidden sm:inline">Next →</span><span class="sm:hidden">Next →</span>';
        }
        
        // Skip button always shows "Skip"
        skipBtn.textContent = 'Skip';
        skipBtn.classList.remove('bg-green-500', 'hover:bg-green-600');
        skipBtn.classList.add('bg-orange-500', 'hover:bg-orange-600');
    }

    function updateProgress() {
        const answeredCount = state.answers.filter(answer => answer !== null && answer.trim() !== '').length;
        const progressPercentage = (answeredCount / questions.length) * 100;
        progressBar.style.width = `${progressPercentage}%`;
        progressBar.classList.add('animate-pulse-once');
        setTimeout(() => {
            progressBar.classList.remove('animate-pulse-once');
        }, 500);
        
        currentQuestionDisplay.textContent = `Question ${state.currentQuestionIndex + 1}`;
    }

    function updateTimer() {
        const minutes = Math.floor(timeRemaining / 60);
        const seconds = Math.floor(timeRemaining % 60);
        countdownDisplayEl.textContent = `${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`;
        
        // Update timer colors based on remaining time
        updateTimerColors();
        
        // Save time remaining to localStorage
        saveStateToStorage();
        
        if (timeRemaining <= 0) {
            clearInterval(state.timer);
            submitQuiz(true);
        } else {
            timeRemaining--;
        }
    }

    function updateTimerColors() {
        const totalDuration = QUIZ_DURATION;
        const timePercentage = (timeRemaining / totalDuration) * 100;
        
        // Remove all color classes from timer display
        countdownDisplayEl.classList.remove(
            'text-green-500', 'text-yellow-500', 'text-orange-500', 'text-red-500', 'text-red-600', 
            'animate-pulse', 'bg-green-100', 'bg-yellow-100', 'bg-orange-100', 'bg-red-100', 'bg-red-200',
            'border-green-300', 'border-yellow-300', 'border-orange-300', 'border-red-300', 'border-red-400'
        );
        
        // Remove all color classes from status text
        timerStatusEl.classList.remove(
            'text-green-600', 'text-yellow-600', 'text-orange-600', 'text-red-600', 'text-red-700',
            'animate-pulse'
        );
        
        if (timePercentage > 50) {
            // Green: More than 50% time remaining
            countdownDisplayEl.classList.add('text-green-500', 'bg-green-100', 'border-green-300');
            timerStatusEl.classList.add('text-green-600');
            timerStatusEl.textContent = 'Plenty of Time';
        } else if (timePercentage > 25) {
            // Yellow: 25-50% time remaining
            countdownDisplayEl.classList.add('text-yellow-500', 'bg-yellow-100', 'border-yellow-300');
            timerStatusEl.classList.add('text-yellow-600');
            timerStatusEl.textContent = 'Time Running Out';
        } else if (timePercentage > 10) {
            // Orange: 10-25% time remaining
            countdownDisplayEl.classList.add('text-orange-500', 'bg-orange-100', 'border-orange-300');
            timerStatusEl.classList.add('text-orange-600');
            timerStatusEl.textContent = 'Hurry Up!';
        } else if (timeRemaining > 180) {
            // Red: Less than 10% but more than 3 minutes
            countdownDisplayEl.classList.add('text-red-500', 'bg-red-100', 'border-red-300');
            timerStatusEl.classList.add('text-red-600');
            timerStatusEl.textContent = 'Almost Over!';
        } else {
            // Blinking Red: Less than 3 minutes remaining
            countdownDisplayEl.classList.add('text-red-600', 'bg-red-200', 'border-red-400', 'animate-pulse');
            timerStatusEl.classList.add('text-red-700', 'animate-pulse');
            timerStatusEl.textContent = 'FINAL 3 MINUTES!';
        }
    }

    // Event handlers
    function handlePrev() {
        if (state.currentQuestionIndex > 0) {
            state.currentQuestionIndex--;
            render();
            saveStateToStorage(); // Save state after navigation
        }
    }

    function handleNext() {
        if (state.currentQuestionIndex < questions.length - 1) {
            state.currentQuestionIndex++;
            render();
            saveStateToStorage(); // Save state after navigation
        } else {
            // Reached the last question, find the first skipped question
            const firstSkippedIndex = state.skipped.findIndex((skipped, index) => 
                skipped && index !== state.currentQuestionIndex
            );
            
            if (firstSkippedIndex !== -1) {
                // Jump to the first skipped question
                state.currentQuestionIndex = firstSkippedIndex;
                render();
                saveStateToStorage();
            } else {
                // No skipped questions, show completion message
                showCompletionMessage();
            }
        }
    }
    
    function showCompletionMessage() {
        // Check if all questions have been answered
        const answeredCount = state.answers.filter(answer => answer !== null).length;
        const totalQuestions = questions.length;
        
        let title = '';
        let message = '';
        if (answeredCount === totalQuestions) {
            title = '🎉 All Questions Answered!';
            message = 'Congratulations! You have answered all questions.<br><br>';
            message += 'You can now submit your exam or review your answers if time permits.';
        } else {
            const skippedCount = state.skipped.filter(skipped => skipped).length;
            title = '✅ Review Completed!';
            message = 'Great job! You\'ve reached the end of the questions.<br><br>';
            if (skippedCount > 0) {
                message += `You have <strong>${skippedCount}</strong> skipped question${skippedCount > 1 ? 's' : ''}.<br><br>`;
            }
            message += 'You can now submit your exam or review your answers if time permits.';
        }
        
        completionModalTitle.textContent = title;
        completionModalMessage.innerHTML = message;
        completionModal.classList.remove('hidden');
    }
    
    function hideCompletionModal() {
        completionModal.classList.add('hidden');
    }
    
    function handleSkip() {
        state.skipped[state.currentQuestionIndex] = true;
        state.answers[state.currentQuestionIndex] = null;
        saveStateToStorage(); // Save state after skipping
        handleNext();
    }

    function handleSubmit() {
        // Show confirmation modal before submitting
        if (confirm('Are you sure you want to submit your quiz? You can still answer more questions if you continue.')) {
            submitQuiz();
        }
    }

    function submitQuiz(timedOut = false) {
        if (state.isSubmitted) return;
        
        // Add answers to the form as hidden inputs
        questions.forEach((question, index) => {
            if (state.answers[index] !== null) {
                // Remove existing input if it exists
                const existingInput = examForm.querySelector(`input[name="answers[${question.id}]"]`);
                if (existingInput) {
                    existingInput.remove();
                }
                
                // Create new hidden input
                const input = document.createElement('input');
                input.type = 'hidden';
                input.name = `answers[${question.id}]`;
                input.value = state.answers[index];
                examForm.appendChild(input);
            }
        });
        
        // Clear saved state since exam is being submitted
        clearStateFromStorage();
        
        if (timedOut) {
            showResult('Time\'s Up!', 'Your time has run out. Your quiz has been submitted automatically.', true);
        } else {
            showResult('Quiz Complete!', 'Your quiz has been submitted successfully.', true);
        }
        
        // Submit the form using regular form submission
        // This will handle redirects properly
        examForm.submit();
    }

    function showResult(title, message, shouldSubmit = false) {
        modalTitle.textContent = title;
        modalMessage.textContent = message;
        resultModal.classList.remove('hidden');
        
        if (shouldSubmit) {
            state.isSubmitted = true;
            clearInterval(state.timer);
            render();
        }
    }

    function hideResult() {
        resultModal.classList.add('hidden');
    }

    // Initialization
    document.addEventListener('DOMContentLoaded', () => {
        prevBtn.addEventListener('click', handlePrev);
        nextBtn.addEventListener('click', handleNext);
        skipBtn.addEventListener('click', handleSkip);
        submitBtn.addEventListener('click', handleSubmit);
        closeModalBtn.addEventListener('click', hideResult);
        // Completion modal event listeners
        reviewBtn.addEventListener('click', () => {
            hideCompletionModal();
            // Could implement review functionality here if needed
        });
        submitExamBtn.addEventListener('click', () => {
            hideCompletionModal();
            handleSubmit();
        });
        closeCompletionModalBtn.addEventListener('click', hideCompletionModal);
        
        state.timer = setInterval(updateTimer, 1000);
        render();
        
        // Initialize timer colors
        updateTimerColors();
        
        // Prevent accidental navigation
        window.addEventListener('beforeunload', function(e) {
            if (timeRemaining > 0 && !state.isSubmitted) {
                e.preventDefault();
                e.returnValue = 'Are you sure you want to leave? Your quiz progress will be lost.';
                return e.returnValue;
            }
        });
    });
    </script>
</body>
</html>