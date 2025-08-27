<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Quiz Result - {{ $exam->title }}</title>
    
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
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <h1 class="text-3xl font-bold text-gray-900 mb-2">Quiz Completed!</h1>
                <p class="text-gray-600">Congratulations on completing {{ $exam->title }}</p>
            </div>

            <!-- Result Card -->
            <div class="bg-white rounded-xl shadow-xl p-8">
                <!-- Score Summary -->
                <div class="text-center mb-8">
                    <div class="inline-flex items-center justify-center w-24 h-24 rounded-full 
                        {{ $result->percentage >= 70 ? 'bg-green-100' : ($result->percentage >= 50 ? 'bg-yellow-100' : 'bg-red-100') }} mb-4">
                        <span class="text-3xl font-bold 
                            {{ $result->percentage >= 70 ? 'text-green-600' : ($result->percentage >= 50 ? 'text-yellow-600' : 'text-red-600') }}">
                            {{ number_format($result->percentage, 1) }}%
                        </span>
                    </div>
                    
                    <h2 class="text-2xl font-bold text-gray-900 mb-2">
                        {{ $result->percentage >= 70 ? 'Excellent!' : ($result->percentage >= 50 ? 'Good Job!' : 'Keep Practicing!') }}
                    </h2>
                    
                    <p class="text-gray-600">
                        You scored <span class="font-semibold">{{ $result->score }}</span> out of 
                        <span class="font-semibold">{{ $result->total_questions }}</span> total marks
                    </p>
                </div>

                <!-- Performance Details -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                    <div class="text-center p-4 bg-gray-50 rounded-lg">
                        <div class="text-2xl font-bold text-gray-900">{{ $result->correct_answers }}</div>
                        <div class="text-sm text-gray-600">Correct Answers</div>
                    </div>
                    
                    <div class="text-center p-4 bg-gray-50 rounded-lg">
                        <div class="text-2xl font-bold text-gray-900">{{ $result->wrong_answers }}</div>
                        <div class="text-sm text-gray-600">Wrong Answers</div>
                    </div>
                    
                    <div class="text-center p-4 bg-gray-50 rounded-lg">
                        <div class="text-2xl font-bold text-gray-900">{{ $result->unanswered }}</div>
                        <div class="text-sm text-gray-600">Unanswered</div>
                    </div>
                </div>

                <!-- Time Information -->
                <div class="mb-8">
                    <h3 class="text-lg font-semibold text-gray-900 border-b border-gray-200 pb-2 mb-4">Time Information</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="flex items-center">
                            <svg class="w-5 h-5 text-gray-400 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <span class="text-sm text-gray-600">Started: <span class="font-medium">{{ $result->started_at->format('M d, Y g:i A') }}</span></span>
                        </div>
                        
                        <div class="flex items-center">
                            <svg class="w-5 h-5 text-gray-400 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <span class="text-sm text-gray-600">Completed: <span class="font-medium">{{ $result->completed_at->format('M d, Y g:i A') }}</span></span>
                        </div>
                        
                        <div class="flex items-center">
                            <svg class="w-5 h-5 text-gray-400 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <span class="text-sm text-gray-600">Duration: <span class="font-medium">{{ $result->started_at->diffInMinutes($result->completed_at) }} minutes</span></span>
                        </div>
                        
                        <div class="flex items-center">
                            <svg class="w-5 h-5 text-gray-400 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <span class="text-sm text-gray-600">Time Limit: <span class="font-medium">{{ $exam->duration }} minutes</span></span>
                        </div>
                    </div>
                </div>

                <!-- Pass/Fail Status -->
                <div class="mb-8">
                    <div class="text-center p-4 rounded-lg 
                        {{ $result->percentage >= $exam->passing_marks ? 'bg-green-50 border border-green-200' : 'bg-red-50 border border-red-200' }}">
                        <div class="flex items-center justify-center">
                            @if($result->percentage >= $exam->passing_marks)
                                <svg class="w-6 h-6 text-green-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <span class="text-lg font-semibold text-green-800">PASSED</span>
                            @else
                                <svg class="w-6 h-6 text-red-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                                <span class="text-lg font-semibold text-red-800">FAILED</span>
                            @endif
                        </div>
                        <p class="text-sm mt-2 
                            {{ $result->percentage >= $exam->passing_marks ? 'text-green-700' : 'text-red-700' }}">
                            Passing mark: {{ $exam->passing_marks }}%
                        </p>
                    </div>
                </div>

                <!-- Performance Insights -->
                <div class="mb-8">
                    <h3 class="text-lg font-semibold text-gray-900 border-b border-gray-200 pb-2 mb-4">Performance Insights</h3>
                    <div class="space-y-3">
                        @if($result->percentage >= 90)
                            <div class="flex items-center p-3 bg-green-50 rounded-lg">
                                <svg class="w-5 h-5 text-green-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                <span class="text-sm text-green-800">Outstanding performance! You've mastered this material.</span>
                            </div>
                        @elseif($result->percentage >= 80)
                            <div class="flex items-center p-3 bg-blue-50 rounded-lg">
                                <svg class="w-5 h-5 text-blue-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                <span class="text-sm text-blue-800">Great work! You have a solid understanding of the subject.</span>
                            </div>
                        @elseif($result->percentage >= 70)
                            <div class="flex items-center p-3 bg-yellow-50 rounded-lg">
                                <svg class="w-5 h-5 text-yellow-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                <span class="text-sm text-yellow-800">Good job! Consider reviewing areas where you struggled.</span>
                            </div>
                        @else
                            <div class="flex items-center p-3 bg-red-50 rounded-lg">
                                <svg class="w-5 h-5 text-red-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.34 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                                </svg>
                                <span class="text-sm text-red-800">Keep practicing! Review the material and try again.</span>
                            </div>
                        @endif
                        
                        @if($result->unanswered > 0)
                            <div class="flex items-center p-3 bg-orange-50 rounded-lg">
                                <svg class="w-5 h-5 text-orange-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <span class="text-sm text-orange-800">You left {{ $result->unanswered }} question(s) unanswered. Try to answer all questions next time.</span>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="flex flex-col sm:flex-row gap-4">
                    <a href="{{ route('public.quiz.access') }}" 
                       class="flex-1 flex justify-center py-3 px-6 border border-gray-300 rounded-lg shadow-sm text-base font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primaryGreen transition-all duration-200">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                        </svg>
                        Take Another Quiz
                    </a>
                    
                    <button onclick="window.print()" 
                            class="flex-1 flex justify-center py-3 px-6 border border-gray-300 rounded-lg shadow-sm text-base font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primaryGreen transition-all duration-200">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path>
                        </svg>
                        Print Result
                    </button>
                </div>
            </div>

            <!-- Footer -->
            <div class="text-center">
                <p class="text-sm text-gray-500">
                    &copy; {{ date('Y') }} CSuite. All rights reserved.
                </p>
            </div>
        </div>
    </div>

    <style>
        @media print {
            body { background: white; }
            .bg-gradient-to-br { background: white !important; }
            .shadow-xl { box-shadow: none !important; }
            .rounded-xl { border-radius: 0 !important; }
        }
    </style>
</body>
</html>
