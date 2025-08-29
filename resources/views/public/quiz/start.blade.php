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
        .countdown-item {
            animation: fadeInUp 0.6s ease-out;
        }
        .countdown-item:nth-child(1) { animation-delay: 0.1s; }
        .countdown-item:nth-child(2) { animation-delay: 0.2s; }
        .countdown-item:nth-child(3) { animation-delay: 0.3s; }
        .countdown-item:nth-child(4) { animation-delay: 0.4s; }
        
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        .pulse-glow {
            animation: pulseGlow 2s ease-in-out infinite alternate;
        }
        
        @keyframes pulseGlow {
            from {
                box-shadow: 0 0 20px rgba(34, 197, 94, 0.3);
            }
            to {
                box-shadow: 0 0 30px rgba(34, 197, 94, 0.6);
            }
        }
        
        .gradient-bg {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
        
        .glass-effect {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
        
        .floating {
            animation: floating 3s ease-in-out infinite;
        }
        
        @keyframes floating {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-10px); }
        }
    </style>
</head>
<body class="font-sans antialiased bg-gradient-to-br from-slate-900 via-purple-900 to-slate-900 min-h-screen overflow-x-hidden">
    <!-- Background Elements -->
    <div class="fixed inset-0 overflow-hidden pointer-events-none">
        <div class="absolute -top-40 -right-40 w-80 h-80 bg-gradient-to-br from-blue-500/20 to-purple-500/20 rounded-full blur-3xl"></div>
        <div class="absolute -bottom-40 -left-40 w-80 h-80 bg-gradient-to-tr from-green-500/20 to-blue-500/20 rounded-full blur-3xl"></div>
        <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-96 h-96 bg-gradient-to-r from-purple-500/10 to-pink-500/10 rounded-full blur-3xl"></div>
    </div>

    <div class="min-h-screen flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="max-w-4xl w-full space-y-8">
            <!-- Header with Floating Icon -->
            <div class="text-center">
                <div class="mx-auto h-24 w-24 bg-gradient-to-br from-primaryGreen via-emerald-400 to-teal-500 rounded-2xl flex items-center justify-center shadow-2xl mb-8 floating pulse-glow">
                    <svg class="w-14 h-14 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                    </svg>
                </div>
                <h1 class="text-4xl sm:text-5xl font-bold text-white mb-4 leading-tight">{{ $exam->title }}</h1>
                <div class="glass-effect rounded-2xl px-6 py-3 inline-block">
                    <p class="text-lg text-white/90 font-medium">Welcome, <span class="text-primaryGreen font-semibold">{{ $accessInfo['student_name'] }}</span>!</p>
                </div>
            </div>

            <!-- Professional Countdown Timer -->
            <div class="glass-effect rounded-3xl p-8 mb-8">
                <h2 class="text-2xl font-bold text-white text-center mb-6">Exam Starts In</h2>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4 md:gap-6">
                    <div class="countdown-item text-center">
                        <div class="bg-gradient-to-br from-red-500 to-pink-600 rounded-2xl p-4 shadow-lg">
                            <div class="text-3xl md:text-4xl font-bold text-white" id="countdown-days">00</div>
                            <div class="text-sm text-white/80 font-medium">Days</div>
                        </div>
                    </div>
                    <div class="countdown-item text-center">
                        <div class="bg-gradient-to-br from-orange-500 to-red-500 rounded-2xl p-4 shadow-lg">
                            <div class="text-3xl md:text-4xl font-bold text-white" id="countdown-hours">00</div>
                            <div class="text-sm text-white/80 font-medium">Hours</div>
                        </div>
                    </div>
                    <div class="countdown-item text-center">
                        <div class="bg-gradient-to-br from-yellow-500 to-orange-500 rounded-2xl p-4 shadow-lg">
                            <div class="text-3xl md:text-4xl font-bold text-white" id="countdown-minutes">00</div>
                            <div class="text-sm text-white/80 font-medium">Minutes</div>
                        </div>
                    </div>
                    <div class="countdown-item text-center">
                        <div class="bg-gradient-to-br from-green-500 to-emerald-500 rounded-2xl p-4 shadow-lg">
                            <div class="text-3xl md:text-4xl font-bold text-white" id="countdown-seconds">00</div>
                            <div class="text-sm text-white/80 font-medium">Seconds</div>
                        </div>
                    </div>
                </div>
                
                <!-- Progress Bar -->
                <div class="mt-6">
                    <div class="flex justify-between text-sm text-white/80 mb-2">
                        <span>Time Remaining</span>
                        <span id="progress-percentage">100%</span>
                    </div>
                    <div class="w-full bg-white/20 rounded-full h-3 overflow-hidden">
                        <div class="bg-gradient-to-r from-green-500 via-yellow-500 to-red-500 h-3 rounded-full transition-all duration-1000 ease-out" id="progress-bar" style="width: 100%"></div>
                    </div>
                </div>
            </div>

            <!-- Enhanced Exam Details -->
            <div class="glass-effect rounded-3xl p-8">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
                    <!-- Exam Info -->
                    <div class="space-y-6">
                        <h3 class="text-xl font-bold text-white border-b border-white/20 pb-3 flex items-center">
                            <svg class="w-6 h-6 text-primaryGreen mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                            Exam Information
                        </h3>
                        
                        <div class="space-y-4">
                            <div class="flex items-center p-3 bg-white/5 rounded-xl">
                                <div class="w-10 h-10 bg-gradient-to-br from-blue-500 to-blue-600 rounded-lg flex items-center justify-center mr-4">
                                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <div class="text-sm text-white/60">Duration</div>
                                    <div class="text-white font-semibold">{{ $exam->duration }} minutes</div>
                                </div>
                            </div>
                            
                            <div class="flex items-center p-3 bg-white/5 rounded-xl">
                                <div class="w-10 h-10 bg-gradient-to-br from-purple-500 to-purple-600 rounded-lg flex items-center justify-center mr-4">
                                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <div class="text-sm text-white/60">Questions</div>
                                    <div class="text-white font-semibold">{{ $exam->total_questions ?? 'N/A' }}</div>
                                </div>
                            </div>
                            
                            <div class="flex items-center p-3 bg-white/5 rounded-xl">
                                <div class="w-10 h-10 bg-gradient-to-br from-green-500 to-green-600 rounded-lg flex items-center justify-center mr-4">
                                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                                    </svg>
                                </div>
                                <div>
                                    <div class="text-sm text-white/60">Passing Marks</div>
                                    <div class="text-white font-semibold">{{ $exam->passing_marks }}</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Time Info -->
                    <div class="space-y-6">
                        <h3 class="text-xl font-bold text-white border-b border-white/20 pb-3 flex items-center">
                            <svg class="w-6 h-6 text-primaryGreen mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            Time Information
                        </h3>
                        
                        <div class="space-y-4">
                            <div class="flex items-center p-3 bg-white/5 rounded-xl">
                                <div class="w-10 h-10 bg-gradient-to-br from-indigo-500 to-indigo-600 rounded-lg flex items-center justify-center mr-4">
                                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <div class="text-sm text-white/60">Start Time</div>
                                    <div class="text-white font-semibold">{{ $exam->start_time->format('M d, Y g:i A') }}</div>
                                </div>
                            </div>
                            
                            <div class="flex items-center p-3 bg-white/5 rounded-xl">
                                <div class="w-10 h-10 bg-gradient-to-br from-red-500 to-red-600 rounded-lg flex items-center justify-center mr-4">
                                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <div class="text-sm text-white/60">End Time</div>
                                    <div class="text-red-400 font-semibold">{{ $exam->end_time->format('M d, Y g:i A') }}</div>
                                </div>
                            </div>
                            
                            <div class="flex items-center p-3 bg-white/5 rounded-xl">
                                <div class="w-10 h-10 bg-gradient-to-br from-teal-500 to-teal-600 rounded-lg flex items-center justify-center mr-4">
                                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <div class="text-sm text-white/60">Current Time</div>
                                    <div class="text-white font-semibold" id="current-time">{{ now()->format('M d, Y g:i A') }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Exam Description -->
                @if($exam->description)
                <div class="mb-8">
                    <h3 class="text-xl font-bold text-white border-b border-white/20 pb-3 mb-4 flex items-center">
                        <svg class="w-6 h-6 text-primaryGreen mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        Exam Description
                    </h3>
                    <div class="bg-white/5 rounded-xl p-6 border border-white/10">
                        <p class="text-white/90 leading-relaxed">{{ $exam->description }}</p>
                    </div>
                </div>
                @endif

                <!-- Enhanced Instructions -->
                <div class="mb-8">
                    <h3 class="text-xl font-bold text-white border-b border-white/20 pb-3 mb-4 flex items-center">
                        <svg class="w-6 h-6 text-primaryGreen mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Important Instructions
                    </h3>
                    <div class="bg-gradient-to-r from-blue-500/10 to-purple-500/10 border border-blue-500/20 rounded-xl p-6">
                        <ul class="text-white/90 space-y-3">
                            <li class="flex items-start">
                                <div class="w-6 h-6 bg-gradient-to-br from-blue-500 to-blue-600 rounded-full flex items-center justify-center mr-3 mt-0.5 flex-shrink-0">
                                    <svg class="w-3 h-3 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                </div>
                                <span>You have <strong class="text-blue-300">{{ $exam->duration }} minutes</strong> to complete this exam</span>
                            </li>
                            <li class="flex items-start">
                                <div class="w-6 h-6 bg-gradient-to-br from-blue-500 to-blue-600 rounded-full flex items-center justify-center mr-3 mt-0.5 flex-shrink-0">
                                    <svg class="w-3 h-3 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                </div>
                                <span>The timer will start as soon as you begin the exam</span>
                            </li>
                            <li class="flex items-start">
                                <div class="w-6 h-6 bg-gradient-to-br from-blue-500 to-blue-600 rounded-full flex items-center justify-center mr-3 mt-0.5 flex-shrink-0">
                                    <svg class="w-3 h-3 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                </div>
                                <span>You cannot pause or restart the exam once started</span>
                            </li>
                            <li class="flex items-start">
                                <div class="w-6 h-6 bg-gradient-to-br from-blue-500 to-blue-600 rounded-full flex items-center justify-center mr-3 mt-0.5 flex-shrink-0">
                                    <svg class="w-3 h-3 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                </div>
                                <span>Ensure you have a stable internet connection</span>
                            </li>
                            <li class="flex items-start">
                                <div class="w-6 h-6 bg-gradient-to-br from-blue-500 to-blue-600 rounded-full flex items-center justify-center mr-3 mt-0.5 flex-shrink-0">
                                    <svg class="w-3 h-3 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                </div>
                                <span>Do not refresh the page or close the browser during the exam</span>
                            </li>
                        </ul>
                    </div>
                </div>

                <!-- Enhanced Action Buttons -->
                <div class="flex flex-col sm:flex-row gap-4">
                    <form method="POST" action="{{ route('public.quiz.start-quiz', $exam->id) }}" class="flex-1">
                        @csrf
                        <button type="submit" 
                                class="w-full flex justify-center py-4 px-8 border border-transparent rounded-2xl shadow-2xl text-lg font-bold text-white bg-gradient-to-r from-primaryGreen via-emerald-500 to-teal-500 hover:from-primaryGreen/90 hover:via-emerald-500/90 hover:to-teal-500/90 focus:outline-none focus:ring-4 focus:ring-primaryGreen/30 transition-all duration-300 transform hover:scale-105 hover:shadow-primaryGreen/25">
                            <svg class="w-7 h-7 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h1m4 0h1m-6 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            Start Exam Now
                        </button>
                    </form>
                    
                    <a href="{{ route('public.quiz.access') }}" 
                       class="flex-1 flex justify-center py-4 px-8 border border-white/20 rounded-2xl shadow-lg text-lg font-medium text-white bg-white/10 hover:bg-white/20 focus:outline-none focus:ring-4 focus:ring-white/20 transition-all duration-300 backdrop-blur-sm">
                        <svg class="w-7 h-7 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                        Go Back
                    </a>
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
                document.querySelectorAll('.countdown-item').forEach(item => {
                    item.innerHTML = `
                        <div class="bg-gradient-to-br from-green-500 to-emerald-600 rounded-2xl p-4 shadow-lg">
                            <div class="text-3xl md:text-4xl font-bold text-white">READY</div>
                            <div class="text-sm text-white/80 font-medium">To Start</div>
                        </div>
                    `;
                });
                document.getElementById('progress-bar').style.width = '0%';
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
            
            // Update progress bar
            const totalTime = examStart - new Date('{{ $exam->end_time }}');
            const remainingTime = examStart - now;
            const progress = Math.max(0, Math.min(100, (remainingTime / totalTime) * 100));
            document.getElementById('progress-bar').style.width = progress + '%';
            document.getElementById('progress-percentage').textContent = Math.round(progress) + '%';
            
            // Change progress bar color based on time remaining
            const progressBar = document.getElementById('progress-bar');
            if (progress > 60) {
                progressBar.className = 'bg-gradient-to-r from-green-500 to-emerald-500 h-3 rounded-full transition-all duration-1000 ease-out';
            } else if (progress > 30) {
                progressBar.className = 'bg-gradient-to-r from-yellow-500 to-orange-500 h-3 rounded-full transition-all duration-1000 ease-out';
            } else {
                progressBar.className = 'bg-gradient-to-r from-red-500 to-pink-500 h-3 rounded-full transition-all duration-1000 ease-out';
            }
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
