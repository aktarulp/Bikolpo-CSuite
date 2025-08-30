<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Quiz Start - {{ $exam->title }}</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <style>
        .hero-gradient {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
        
        .card-modern {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.3);
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.1);
        }
        
        .timer-card {
            background: linear-gradient(135deg, #ff6b6b 0%, #ee5a24 100%);
            transform: perspective(1000px) rotateX(5deg);
        }
        
        .info-panel {
            background: linear-gradient(135deg, #4ecdc4 0%, #44a08d 100%);
        }
        
        .action-panel {
            background: linear-gradient(135deg, #a8edea 0%, #fed6e3 100%);
        }
        
        .floating-element {
            animation: float 6s ease-in-out infinite;
        }
        
        .floating-element:nth-child(2) { animation-delay: 2s; }
        .floating-element:nth-child(3) { animation-delay: 4s; }
        
        @keyframes float {
            0%, 100% { transform: translateY(0px) rotate(0deg); }
            50% { transform: translateY(-20px) rotate(5deg); }
        }
        
        .pulse-glow {
            animation: pulseGlow 3s ease-in-out infinite alternate;
        }
        
        @keyframes pulseGlow {
            from { box-shadow: 0 0 30px rgba(102, 126, 234, 0.4); }
            to { box-shadow: 0 0 50px rgba(102, 126, 234, 0.8); }
        }
        
        .slide-in {
            animation: slideIn 0.8s ease-out;
        }
        
        .slide-in:nth-child(1) { animation-delay: 0.1s; }
        .slide-in:nth-child(2) { animation-delay: 0.2s; }
        .slide-in:nth-child(3) { animation-delay: 0.3s; }
        .slide-in:nth-child(4) { animation-delay: 0.4s; }
        
        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateX(-50px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }
        
        .progress-ring {
            transform: rotate(-90deg);
        }
        
        .progress-ring-circle {
            transition: stroke-dasharray 0.5s ease-in-out;
        }
        
        .geometric-shape {
            position: absolute;
            opacity: 0.1;
            animation: rotate 20s linear infinite;
        }
        
        @keyframes rotate {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }
        
        .neon-border {
            position: relative;
        }
        
        .neon-border::before {
            content: '';
            position: absolute;
            top: -2px;
            left: -2px;
            right: -2px;
            bottom: -2px;
            background: linear-gradient(45deg, #ff6b6b, #4ecdc4, #45b7d1, #96ceb4, #feca57);
            border-radius: inherit;
            z-index: -1;
            animation: borderGlow 3s ease-in-out infinite alternate;
        }
        
        @keyframes borderGlow {
            from { opacity: 0.5; }
            to { opacity: 1; }
        }
    </style>
</head>
<body class="font-sans antialiased bg-gradient-to-br from-indigo-100 via-purple-100 to-pink-100 min-h-screen overflow-x-hidden">
    
    <!-- Geometric Background Elements -->
    <div class="fixed inset-0 overflow-hidden pointer-events-none">
        <div class="geometric-shape absolute top-20 left-20 w-32 h-32 border-4 border-indigo-300 rounded-full"></div>
        <div class="geometric-shape absolute top-40 right-40 w-24 h-24 border-4 border-purple-300 transform rotate-45"></div>
        <div class="geometric-shape absolute bottom-20 left-1/3 w-20 h-20 border-4 border-pink-300 rounded-full"></div>
        <div class="geometric-shape absolute bottom-40 right-20 w-28 h-28 border-4 border-blue-300 transform rotate-12"></div>
    </div>

    <div class="min-h-screen flex items-center justify-center py-8 px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="max-w-7xl w-full space-y-8">
            
            <!-- Hero Section -->
            <div class="hero-gradient rounded-3xl p-12 text-center text-white relative overflow-hidden">
                <!-- Floating Elements -->
                <div class="absolute top-10 left-10 w-20 h-20 bg-white/20 rounded-full floating-element"></div>
                <div class="absolute top-20 right-20 w-16 h-16 bg-white/20 rounded-full floating-element"></div>
                <div class="absolute bottom-10 left-1/4 w-12 h-12 bg-white/20 rounded-full floating-element"></div>
                
                <!-- Main Content -->
                <div class="relative z-10">
                    <div class="mx-auto h-28 w-28 bg-white/20 rounded-3xl flex items-center justify-center mb-8 pulse-glow">
                        <svg class="w-16 h-16 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                        </svg>
                    </div>
                    
                    <h1 class="text-5xl sm:text-6xl font-bold mb-6 leading-tight">{{ $exam->title }}</h1>
                    
                    <div class="inline-flex items-center px-8 py-4 bg-white/20 backdrop-blur-sm rounded-2xl border border-white/30">
                        <div class="w-3 h-3 bg-green-400 rounded-full mr-4 animate-pulse"></div>
                        <span class="text-xl font-medium">Welcome, <span class="font-bold text-yellow-300">{{ $accessInfo['student_name'] }}</span></span>
                    </div>
                </div>
            </div>

            <!-- Countdown Section -->
            <div class="timer-card rounded-3xl p-10 text-white text-center shadow-2xl">
                <h2 class="text-3xl font-bold mb-8">⏰ Exam Starts In</h2>
                
                <div class="grid grid-cols-2 md:grid-cols-4 gap-6 mb-8">
                    <div class="slide-in">
                        <div class="bg-white/20 backdrop-blur-sm rounded-2xl p-6 border border-white/30">
                            <div class="text-4xl md:text-5xl font-bold" id="countdown-days">00</div>
                            <div class="text-lg font-medium opacity-90">Days</div>
                        </div>
                    </div>
                    <div class="slide-in">
                        <div class="bg-white/20 backdrop-blur-sm rounded-2xl p-6 border border-white/30">
                            <div class="text-4xl md:text-5xl font-bold" id="countdown-hours">00</div>
                            <div class="text-lg font-medium opacity-90">Hours</div>
                        </div>
                    </div>
                    <div class="slide-in">
                        <div class="bg-white/20 backdrop-blur-sm rounded-2xl p-6 border border-white/30">
                            <div class="text-4xl md:text-5xl font-bold" id="countdown-minutes">00</div>
                            <div class="text-lg font-medium opacity-90">Minutes</div>
                        </div>
                    </div>
                    <div class="slide-in">
                        <div class="bg-white/20 backdrop-blur-sm rounded-2xl p-6 border border-white/30">
                            <div class="text-4xl md:text-5xl font-bold" id="countdown-seconds">00</div>
                            <div class="text-lg font-medium opacity-90">Seconds</div>
                        </div>
                    </div>
                </div>
                
                <!-- Circular Progress -->
                <div class="flex justify-center mb-6">
                    <div class="relative">
                        <svg class="w-32 h-32 progress-ring">
                            <circle class="text-white/20" stroke-width="8" stroke="currentColor" fill="transparent" r="56" cx="64" cy="64"></circle>
                            <circle class="progress-ring-circle text-white" stroke-width="8" stroke="currentColor" fill="transparent" r="56" cx="64" cy="64" 
                                    stroke-dasharray="351.86" stroke-dashoffset="0" id="progress-circle"></circle>
                        </svg>
                        <div class="absolute inset-0 flex items-center justify-center">
                            <span class="text-2xl font-bold" id="progress-percentage">100%</span>
                        </div>
                    </div>
                </div>
                
                <div class="text-lg opacity-90">Time Remaining</div>
            </div>

            <!-- Main Content Grid -->
            <div class="grid grid-cols-1 xl:grid-cols-3 gap-8">
                
                <!-- Left Column: Exam Details -->
                <div class="xl:col-span-2 space-y-8">
                    
                    <!-- Exam Information Panel -->
                    <div class="info-panel rounded-3xl p-8 text-white shadow-2xl">
                        <h3 class="text-2xl font-bold mb-8 flex items-center">
                            <div class="w-10 h-10 bg-white/20 rounded-xl flex items-center justify-center mr-4">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                            </div>
                            📋 Exam Information
                        </h3>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="space-y-4">
                                <div class="bg-white/20 backdrop-blur-sm rounded-xl p-5 border border-white/30">
                                    <div class="flex items-center">
                                        <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center mr-4">
                                            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                        </div>
                                        <div>
                                            <div class="text-sm opacity-80 font-medium">Duration</div>
                                            <div class="text-xl font-bold">{{ $exam->duration }} minutes</div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="bg-white/20 backdrop-blur-sm rounded-xl p-5 border border-white/30">
                                    <div class="flex items-center">
                                        <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center mr-4">
                                            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                        </div>
                                        <div>
                                            <div class="text-sm opacity-80 font-medium">Questions</div>
                                            <div class="text-xl font-bold">{{ $exam->total_questions ?? 'N/A' }}</div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="bg-white/20 backdrop-blur-sm rounded-xl p-5 border border-white/30">
                                    <div class="flex items-center">
                                        <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center mr-4">
                                            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                                            </svg>
                                        </div>
                                        <div>
                                            <div class="text-sm opacity-80 font-medium">Passing Marks</div>
                                            <div class="text-xl font-bold">{{ $exam->passing_marks }}</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="space-y-4">
                                <div class="bg-white/20 backdrop-blur-sm rounded-xl p-5 border border-white/30">
                                    <div class="flex items-center">
                                        <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center mr-4">
                                            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                        </div>
                                        <div>
                                            <div class="text-sm opacity-80 font-medium">Start Time</div>
                                            <div class="text-xl font-bold">{{ $exam->start_time->format('M d, Y g:i A') }}</div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="bg-white/20 backdrop-blur-sm rounded-xl p-5 border border-white/30">
                                    <div class="flex items-center">
                                        <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center mr-4">
                                            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                        </div>
                                        <div>
                                            <div class="text-sm opacity-80 font-medium">End Time</div>
                                            <div class="text-xl font-bold text-red-200">{{ $exam->end_time->format('M d, Y g:i A') }}</div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="bg-white/20 backdrop-blur-sm rounded-xl p-5 border border-white/30">
                                    <div class="flex items-center">
                                        <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center mr-4">
                                            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                        </div>
                                        <div>
                                            <div class="text-sm opacity-80 font-medium">Current Time</div>
                                            <div class="text-xl font-bold" id="current-time">{{ now()->format('M d, Y g:i A') }}</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Exam Description -->
                    @if($exam->description)
                    <div class="card-modern rounded-3xl p-8 shadow-2xl">
                        <h3 class="text-2xl font-bold text-gray-800 mb-6 flex items-center">
                            <div class="w-10 h-10 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-xl flex items-center justify-center mr-4">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                            </div>
                            📝 Exam Description
                        </h3>
                        <div class="bg-gradient-to-r from-indigo-50 to-purple-50 rounded-2xl p-6 border border-indigo-100">
                            <p class="text-gray-700 leading-relaxed text-lg">{{ $exam->description }}</p>
                        </div>
                    </div>
                    @endif
                </div>

                <!-- Right Column: Instructions & Actions -->
                <div class="space-y-8">
                    
                    <!-- Instructions Panel -->
                    <div class="action-panel rounded-3xl p-8 shadow-2xl">
                        <h3 class="text-2xl font-bold text-gray-800 mb-6 flex items-center">
                            <div class="w-10 h-10 bg-gradient-to-br from-amber-500 to-orange-600 rounded-xl flex items-center justify-center mr-4">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            ⚠️ Important Instructions
                        </h3>
                        
                        <div class="space-y-4">
                            <div class="flex items-start bg-white/50 backdrop-blur-sm rounded-xl p-4 border border-white/50">
                                <div class="w-6 h-6 bg-green-500 rounded-full flex items-center justify-center mr-3 mt-1 flex-shrink-0">
                                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                </div>
                                <span class="text-gray-700 font-medium">You have <strong class="text-green-600">{{ $exam->duration }} minutes</strong> to complete</span>
                            </div>
                            
                            <div class="flex items-start bg-white/50 backdrop-blur-sm rounded-xl p-4 border border-white/50">
                                <div class="w-6 h-6 bg-green-500 rounded-full flex items-center justify-center mr-3 mt-1 flex-shrink-0">
                                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                </div>
                                <span class="text-gray-700 font-medium">Timer starts immediately when you begin</span>
                            </div>
                            
                            <div class="flex items-start bg-white/50 backdrop-blur-sm rounded-xl p-4 border border-white/50">
                                <div class="w-6 h-6 bg-green-500 rounded-full flex items-center justify-center mr-3 mt-1 flex-shrink-0">
                                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                </div>
                                <span class="text-gray-700 font-medium">No pausing or restarting allowed</span>
                            </div>
                            
                            <div class="flex items-start bg-white/50 backdrop-blur-sm rounded-xl p-4 border border-white/50">
                                <div class="w-6 h-6 bg-green-500 rounded-full flex items-center justify-center mr-3 mt-1 flex-shrink-0">
                                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                </div>
                                <span class="text-gray-700 font-medium">Ensure stable internet connection</span>
                            </div>
                            
                            <div class="flex items-start bg-white/50 backdrop-blur-sm rounded-xl p-4 border border-white/50">
                                <div class="w-6 h-6 bg-green-500 rounded-full flex items-center justify-center mr-3 mt-1 flex-shrink-0">
                                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                </div>
                                <span class="text-gray-700 font-medium">Don't refresh or close browser</span>
                            </div>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="space-y-6">
                        <form method="POST" action="{{ route('public.quiz.start-quiz', $exam->id) }}">
                            @csrf
                            <button type="submit" 
                                    class="neon-border w-full flex justify-center py-5 px-8 rounded-2xl text-xl font-bold text-white bg-gradient-to-r from-emerald-500 to-teal-600 hover:from-emerald-600 hover:to-teal-700 transform hover:scale-105 transition-all duration-300 shadow-2xl">
                                <svg class="w-7 h-7 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h1m4 0h1m-6 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                🚀 Start Exam Now
                            </button>
                        </form>
                        
                        <a href="{{ route('public.quiz.access') }}" 
                           class="w-full flex justify-center py-5 px-8 rounded-2xl text-xl font-medium text-gray-700 bg-gradient-to-r from-gray-100 to-gray-200 hover:from-gray-200 hover:to-gray-300 transform hover:scale-105 transition-all duration-300 shadow-lg border-2 border-gray-200 hover:border-gray-300">
                            <svg class="w-7 h-7 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                            </svg>
                            ↩️ Go Back
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Professional Countdown Timer
        function updateCountdown() {
            const now = new Date();
            const examStart = new Date('{{ $exam->start_time }}');
            const timeDiff = examStart - now;
            
            if (timeDiff <= 0) {
                // Exam has started
                document.querySelectorAll('.slide-in').forEach(item => {
                    item.innerHTML = `
                        <div class="bg-white/20 backdrop-blur-sm rounded-2xl p-6 border border-white/30">
                            <div class="text-4xl md:text-5xl font-bold">READY</div>
                            <div class="text-lg font-medium opacity-90">To Start</div>
                        </div>
                    `;
                });
                
                // Update circular progress
                const circle = document.getElementById('progress-circle');
                circle.style.strokeDasharray = '351.86';
                circle.style.strokeDashoffset = '351.86';
                document.getElementById('progress-percentage').textContent = '0%';
                return;
            }
            
            const days = Math.floor(timeDiff / (1000 * 60 * 60 * 24));
            const hours = Math.floor((timeDiff % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            const minutes = Math.floor((timeDiff % (1000 * 60 * 60)) / (1000 * 60));
            const seconds = Math.floor((timeDiff % (1000 * 60)) / 1000);
            
            // Update countdown display
            document.getElementById('countdown-days').textContent = days.toString().padStart(2, '0');
            document.getElementById('countdown-hours').textContent = hours.toString().padStart(2, '0');
            document.getElementById('countdown-minutes').textContent = minutes.toString().padStart(2, '0');
            document.getElementById('countdown-seconds').textContent = seconds.toString().padStart(2, '0');
            
            // Update circular progress
            const totalTime = examStart - new Date('{{ $exam->end_time }}');
            const remainingTime = examStart - now;
            const progress = Math.max(0, Math.min(100, (remainingTime / totalTime) * 100));
            
            const circle = document.getElementById('progress-circle');
            const circumference = 2 * Math.PI * 56; // r = 56
            const offset = circumference - (progress / 100) * circumference;
            circle.style.strokeDasharray = circumference;
            circle.style.strokeDashoffset = offset;
            
            document.getElementById('progress-percentage').textContent = Math.round(progress) + '%';
        }
        
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
        
        // Initialize countdown and time updates
        setInterval(updateCountdown, 1000);
        setInterval(updateCurrentTime, 1000);
        updateCountdown();
        updateCurrentTime();
    </script>
</body>
</html>
