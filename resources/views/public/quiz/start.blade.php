<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Quiz Start - {{ $exam->title }}</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-gradient-to-br from-blue-50 to-indigo-100 min-h-screen">
    <div class="min-h-screen flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-2xl w-full space-y-8">
            <!-- Header -->
            <div class="text-center">
                <div class="mx-auto h-20 w-20 bg-gradient-to-br from-primaryGreen to-emerald-500 rounded-full flex items-center justify-center shadow-lg mb-6">
                    <svg class="w-12 h-12 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                    </svg>
                </div>
                <h1 class="text-3xl font-bold text-gray-900 mb-2">{{ $exam->title }}</h1>
                <p class="text-gray-600">Welcome, {{ $accessInfo['student_name'] }}!</p>
            </div>

            <!-- Exam Details -->
            <div class="bg-white rounded-xl shadow-xl p-8">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                    <!-- Exam Info -->
                    <div class="space-y-4">
                        <h3 class="text-lg font-semibold text-gray-900 border-b border-gray-200 pb-2">Exam Information</h3>
                        
                        <div class="space-y-3">
                            <div class="flex items-center">
                                <svg class="w-5 h-5 text-gray-400 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                                <span class="text-sm text-gray-600">Duration: <span class="font-medium">{{ $exam->duration }} minutes</span></span>
                            </div>
                            
                            <div class="flex items-center">
                                <svg class="w-5 h-5 text-gray-400 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <span class="text-sm text-gray-600">Questions: <span class="font-medium">{{ $exam->total_questions ?? 'N/A' }}</span></span>
                            </div>
                            
                            <div class="flex items-center">
                                <svg class="w-5 h-5 text-gray-400 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                                </svg>
                                <span class="text-sm text-gray-600">Passing Marks: <span class="font-medium">{{ $exam->passing_marks }}</span></span>
                            </div>
                        </div>
                    </div>

                    <!-- Time Info -->
                    <div class="space-y-4">
                        <h3 class="text-lg font-semibold text-gray-900 border-b border-gray-200 pb-2">Time Information</h3>
                        
                        <div class="space-y-3">
                            <div class="flex items-center">
                                <svg class="w-5 h-5 text-gray-400 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <span class="text-sm text-gray-600">Start Time: <span class="font-medium">{{ $exam->start_time->format('M d, Y g:i A') }}</span></span>
                            </div>
                            
                            <div class="flex items-center">
                                <svg class="w-5 h-5 text-gray-400 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <span class="text-sm text-gray-600">End Time: <span class="text-red-600 font-medium">{{ $exam->end_time->format('M d, Y g:i A') }}</span></span>
                            </div>
                            
                            <div class="flex items-center">
                                <svg class="w-5 h-5 text-gray-400 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <span class="text-sm text-gray-600">Current Time: <span class="font-medium" id="current-time">{{ now()->format('M d, Y g:i A') }}</span></span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Exam Description -->
                @if($exam->description)
                <div class="mb-8">
                    <h3 class="text-lg font-semibold text-gray-900 border-b border-gray-200 pb-2 mb-3">Exam Description</h3>
                    <div class="bg-gray-50 rounded-lg p-4">
                        <p class="text-gray-700">{{ $exam->description }}</p>
                    </div>
                </div>
                @endif

                <!-- Instructions -->
                <div class="mb-8">
                    <h3 class="text-lg font-semibold text-gray-900 border-b border-gray-200 pb-2 mb-3">Important Instructions</h3>
                    <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                        <ul class="text-sm text-blue-800 space-y-2">
                            <li class="flex items-start">
                                <svg class="w-4 h-4 text-blue-600 mr-2 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                You have <strong>{{ $exam->duration }} minutes</strong> to complete this exam
                            </li>
                            <li class="flex items-start">
                                <svg class="w-4 h-4 text-blue-600 mr-2 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                The timer will start as soon as you begin the exam
                            </li>
                            <li class="flex items-start">
                                <svg class="w-4 h-4 text-blue-600 mr-2 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                You cannot pause or restart the exam once started
                            </li>
                            <li class="flex items-start">
                                <svg class="w-4 h-4 text-blue-600 mr-2 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                Ensure you have a stable internet connection
                            </li>
                            <li class="flex items-start">
                                <svg class="w-4 h-4 text-blue-600 mr-2 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                Do not refresh the page or close the browser during the exam
                            </li>
                        </ul>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="flex flex-col sm:flex-row gap-4">
                    <form method="POST" action="{{ route('public.quiz.start-quiz', $exam->id) }}" class="flex-1">
                        @csrf
                        <button type="submit" 
                                class="w-full flex justify-center py-3 px-6 border border-transparent rounded-lg shadow-sm text-base font-medium text-white bg-gradient-to-r from-primaryGreen to-emerald-600 hover:from-primaryGreen/90 hover:to-emerald-600/90 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primaryGreen transition-all duration-200 transform hover:scale-105">
                            <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h1m4 0h1m-6 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            Start Exam Now
                        </button>
                    </form>
                    
                    <a href="{{ route('public.quiz.access') }}" 
                       class="flex-1 flex justify-center py-3 px-6 border border-gray-300 rounded-lg shadow-sm text-base font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primaryGreen transition-all duration-200">
                        <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                        Go Back
                    </a>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Update current time every second
        function updateCurrentTime() {
            const now = new Date();
            const timeString = now.toLocaleDateString('en-US', {
                month: 'short',
                day: 'numeric',
                year: 'numeric'
            }) + ' ' + now.toLocaleTimeString('en-US', {
                hour: 'numeric',
                minute: '2-digit',
                hour12: true
            });
            document.getElementById('current-time').textContent = timeString;
        }

        setInterval(updateCurrentTime, 1000);
        updateCurrentTime();
    </script>
</body>
</html>
