<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Waiting Room - {{ $exam->title }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primaryGreen: '#10B981',
                    }
                }
            }
        }
    </script>
    <style>
        .countdown-digit {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        .pulse-glow {
            animation: pulse-glow 2s ease-in-out infinite alternate;
        }
        @keyframes pulse-glow {
            from {
                box-shadow: 0 0 20px rgba(16, 185, 129, 0.4);
            }
            to {
                box-shadow: 0 0 30px rgba(16, 185, 129, 0.8);
            }
        }
    </style>
</head>
<body class="bg-gradient-to-br from-gray-50 to-gray-100 min-h-screen">
    <div class="container mx-auto px-4 py-8">
        <!-- Header -->
        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center w-20 h-20 bg-primaryGreen rounded-full mb-4 pulse-glow">
                <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
            <h1 class="text-3xl md:text-4xl font-bold text-gray-900 mb-2">Exam Waiting Room</h1>
            <p class="text-lg text-gray-600">Please wait while we prepare your exam</p>
        </div>

        <!-- Main Content -->
        <div class="max-w-4xl mx-auto">
            <!-- Exam Information Card -->
            <div class="bg-white rounded-2xl shadow-xl border border-gray-200 p-6 md:p-8 mb-8">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Left Column -->
                    <div class="space-y-4">
                        <div>
                            <label class="text-sm font-medium text-gray-500 uppercase tracking-wide">Exam Name</label>
                            <p class="text-xl font-semibold text-gray-900 mt-1">{{ $exam->title }}</p>
                        </div>
                        
                        <div>
                            <label class="text-sm font-medium text-gray-500 uppercase tracking-wide">Partner</label>
                            <p class="text-lg text-gray-900 mt-1">{{ $exam->partner->name ?? 'Unknown Partner' }}</p>
                        </div>
                        
                        <div>
                            <label class="text-sm font-medium text-gray-500 uppercase tracking-wide">Duration</label>
                            <p class="text-lg text-gray-900 mt-1">{{ $exam->duration }} minutes</p>
                        </div>
                    </div>
                    
                    <!-- Right Column -->
                    <div class="space-y-4">
                        <div>
                            <label class="text-sm font-medium text-gray-500 uppercase tracking-wide">Start Time</label>
                            <p class="text-lg text-gray-900 mt-1">{{ $exam->formatted_start_time }}</p>
                        </div>
                        
                        <div>
                            <label class="text-sm font-medium text-gray-500 uppercase tracking-wide">End Time</label>
                            <p class="text-lg text-gray-900 mt-1">{{ $exam->formatted_end_time }}</p>
                        </div>
                        
                        <div>
                            <label class="text-sm font-medium text-gray-500 uppercase tracking-wide">Total Questions</label>
                            <p class="text-lg text-gray-900 mt-1">{{ $exam->total_questions ?? 'Not set' }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Countdown Timer -->
            <div class="bg-gradient-to-r from-primaryGreen to-emerald-500 rounded-2xl shadow-xl p-8 text-center text-white">
                <h2 class="text-2xl font-bold mb-6">Exam Starts In</h2>
                
                <div class="grid grid-cols-4 gap-4 md:gap-8 mb-6">
                    <div class="text-center">
                        <div class="text-3xl md:text-5xl font-bold countdown-digit" id="days">--</div>
                        <div class="text-sm md:text-base opacity-90">Days</div>
                    </div>
                    <div class="text-center">
                        <div class="text-3xl md:text-5xl font-bold countdown-digit" id="hours">--</div>
                        <div class="text-sm md:text-base opacity-90">Hours</div>
                    </div>
                    <div class="text-center">
                        <div class="text-3xl md:text-5xl font-bold countdown-digit" id="minutes">--</div>
                        <div class="text-sm md:text-base opacity-90">Minutes</div>
                    </div>
                    <div class="text-center">
                        <div class="text-3xl md:text-5xl font-bold countdown-digit" id="seconds">--</div>
                        <div class="text-sm md:text-base opacity-90">Seconds</div>
                    </div>
                </div>
                
                <div class="text-lg opacity-90" id="countdown-message">
                    Please wait for the exam to begin
                </div>
                
                <!-- Human Readable Time -->
                <div class="mt-4 p-3 bg-white/20 rounded-lg">
                    <p class="text-sm opacity-90">
                        <span class="font-medium">Time until start:</span> 
                        <span id="human-time">{{ $exam->time_until_start ?? 'Calculating...' }}</span>
                    </p>
                </div>
            </div>

            <!-- Instructions -->
            <div class="bg-white rounded-2xl shadow-lg border border-gray-200 p-6 mt-8">
                <h3 class="text-xl font-semibold text-gray-900 mb-4 flex items-center">
                    <svg class="w-5 h-5 text-primaryGreen mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    What to Expect
                </h3>
                <ul class="space-y-2 text-gray-700">
                    <li class="flex items-start">
                        <svg class="w-4 h-4 text-primaryGreen mr-2 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        The exam will automatically become available at the scheduled start time
                    </li>
                    <li class="flex items-start">
                        <svg class="w-4 h-4 text-primaryGreen mr-2 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        You'll be redirected to the exam page when it's time to start
                    </li>
                    <li class="flex items-start">
                        <svg class="w-4 h-4 text-primaryGreen mr-2 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        Make sure you have a stable internet connection
                    </li>
                    <li class="flex items-start">
                        <svg class="w-4 h-4 text-primaryGreen mr-2 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        You can keep this page open - it will refresh automatically
                    </li>
                </ul>
            </div>

            <!-- Student Info -->
            <div class="bg-gray-50 rounded-2xl p-6 mt-8">
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 bg-primaryGreen rounded-full flex items-center justify-center">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Logged in as</p>
                            <p class="font-medium text-gray-900">{{ $accessInfo['student_name'] ?? 'Student' }}</p>
                        </div>
                    </div>
                    
                    <a href="{{ route('public.quiz.access') }}" class="text-primaryGreen hover:text-emerald-600 font-medium text-sm hover:underline">
                        Logout
                    </a>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Countdown Timer
        function updateCountdown() {
            const examStartTime = new Date('{{ $exam->start_time->toISOString() }}').getTime();
            const now = new Date().getTime();
            const distance = examStartTime - now;

            if (distance < 0) {
                // Exam has started, redirect to exam page
                window.location.href = '{{ route("public.quiz.start", $exam) }}';
                return;
            }

            // Calculate time units
            const days = Math.floor(distance / (1000 * 60 * 60 * 24));
            const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
            const seconds = Math.floor((distance % (1000 * 60)) / 1000);

            // Update display
            document.getElementById('days').textContent = days.toString().padStart(2, '0');
            document.getElementById('hours').textContent = hours.toString().padStart(2, '0');
            document.getElementById('minutes').textContent = minutes.toString().padStart(2, '0');
            document.getElementById('seconds').textContent = seconds.toString().padStart(2, '0');

            // Update message based on time remaining
            if (days > 0) {
                document.getElementById('countdown-message').textContent = 'Exam starts in a few days';
            } else if (hours > 0) {
                document.getElementById('countdown-message').textContent = 'Exam starts in a few hours';
            } else if (minutes > 0) {
                document.getElementById('countdown-message').textContent = 'Exam starts in a few minutes';
            } else {
                document.getElementById('countdown-message').textContent = 'Exam starts very soon!';
            }

            // Update human readable time
            const humanTimeElement = document.getElementById('human-time');
            if (humanTimeElement) {
                if (days > 0) {
                    humanTimeElement.textContent = `${days} day${days > 1 ? 's' : ''}, ${hours} hour${hours > 1 ? 's' : ''}`;
                } else if (hours > 0) {
                    humanTimeElement.textContent = `${hours} hour${hours > 1 ? 's' : ''}, ${minutes} minute${minutes > 1 ? 's' : ''}`;
                } else if (minutes > 0) {
                    humanTimeElement.textContent = `${minutes} minute${minutes > 1 ? 's' : ''}, ${seconds} second${seconds > 1 ? 's' : ''}`;
                } else {
                    humanTimeElement.textContent = `${seconds} second${seconds > 1 ? 's' : ''}`;
                }
            }
        }

        // Update countdown every second
        updateCountdown();
        setInterval(updateCountdown, 1000);

        // Auto-refresh page every 30 seconds to check if exam has started
        setInterval(() => {
            const examStartTime = new Date('{{ $exam->start_time->toISOString() }}').getTime();
            const now = new Date().getTime();
            if (now >= examStartTime) {
                window.location.reload();
            }
        }, 30000);
    </script>
</body>
</html>
