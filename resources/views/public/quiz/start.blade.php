<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Extraordinary Countdown - {{ $exam->title }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
    </style>
</head>
<body class="bg-gray-900 text-white min-h-screen flex items-center justify-center p-4">

    <!-- The main countdown container with the pill shape -->
    <div class="bg-gradient-to-br from-indigo-800 to-purple-900 p-8 md:p-12 rounded-3xl shadow-2xl text-center max-w-4xl w-full border border-purple-700">
        <h1 class="text-3xl md:text-5xl font-extrabold mb-8 md:mb-12 tracking-wide leading-tight">
            Your Exam will Start in...
                    </h1>
                    
        <div class="grid grid-cols-2 sm:grid-cols-4 gap-6 md:gap-8">
            <!-- Days block -->
            <div class="bg-white/10 backdrop-blur-sm shadow-lg rounded-full transition-transform transform hover:scale-105 duration-300 ease-in-out w-24 h-24 md:w-32 md:h-32 flex flex-col items-center justify-center">
                <span id="days" class="block text-4xl md:text-6xl font-bold mb-1 md:mb-2 text-transparent bg-clip-text bg-gradient-to-br from-yellow-300 to-orange-400">00</span>
                <span class="block text-sm md:text-lg text-gray-300 uppercase tracking-wider">Days</span>
                    </div>
                    
            <!-- Hours block -->
            <div class="bg-white/10 backdrop-blur-sm shadow-lg rounded-full transition-transform transform hover:scale-105 duration-300 ease-in-out w-24 h-24 md:w-32 md:h-32 flex flex-col items-center justify-center">
                <span id="hours" class="block text-4xl md:text-6xl font-bold mb-1 md:mb-2 text-transparent bg-clip-text bg-gradient-to-br from-green-300 to-teal-400">00</span>
                <span class="block text-sm md:text-lg text-gray-300 uppercase tracking-wider">Hours</span>
            </div>

            <!-- Minutes block -->
            <div class="bg-white/10 backdrop-blur-sm shadow-lg rounded-full transition-transform transform hover:scale-105 duration-300 ease-in-out w-24 h-24 md:w-32 md:h-32 flex flex-col items-center justify-center">
                <span id="minutes" class="block text-4xl md:text-6xl font-bold mb-1 md:mb-2 text-transparent bg-clip-text bg-gradient-to-br from-blue-300 to-cyan-400">00</span>
                <span class="block text-sm md:text-lg text-gray-300 uppercase tracking-wider">Minutes</span>
                </div>
                
            <!-- Seconds block -->
            <div class="bg-white/10 backdrop-blur-sm shadow-lg rounded-full transition-transform transform hover:scale-105 duration-300 ease-in-out w-24 h-24 md:w-32 md:h-32 flex flex-col items-center justify-center">
                <span id="seconds" class="block text-4xl md:text-6xl font-bold mb-1 md:mb-2 text-transparent bg-clip-text bg-gradient-to-br from-pink-300 to-rose-400">00</span>
                <span class="block text-sm md:text-lg text-gray-300 uppercase tracking-wider">Seconds</span>
                                    </div>
                                </div>
                                
        <p id="countdownMessage" class="mt-8 text-md md:text-xl font-light text-gray-400 tracking-wide hidden">
            Countdown finished!
        </p>

        <!-- Exam Information -->
        <div class="mt-8 p-6 bg-white/5 backdrop-blur-sm rounded-2xl border border-white/10">
            <h2 class="text-2xl font-bold mb-4 text-white">{{ $exam->title }}</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                <div class="flex justify-between">
                    <span class="text-gray-300">Duration:</span>
                    <span class="text-white font-semibold">{{ $exam->duration }} minutes</span>
                                        </div>
                <div class="flex justify-between">
                    <span class="text-gray-300">Questions:</span>
                    <span class="text-white font-semibold">{{ $exam->total_questions ?? 'N/A' }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-300">Passing Marks:</span>
                    <span class="text-white font-semibold">{{ $exam->passing_marks }}</span>
                            </div>
                <div class="flex justify-between">
                    <span class="text-gray-300">Student:</span>
                    <span class="text-white font-semibold">{{ $accessInfo['student_name'] }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Action Buttons -->
        <div class="mt-8 space-y-4">
            <form method="POST" action="{{ route('public.quiz.start-quiz', $exam->id) }}" id="startForm" class="hidden">
                            @csrf
                            <button type="submit" 
                        class="bg-gradient-to-r from-green-500 to-emerald-600 hover:from-green-600 hover:to-emerald-700 text-white font-bold py-4 px-8 rounded-2xl shadow-lg transform hover:scale-105 transition-all duration-300 w-full">
                                🚀 Start Exam Now
                            </button>
                        </form>
                        
                        <a href="{{ route('public.quiz.access') }}" 
               class="inline-block bg-white/10 hover:bg-white/20 text-white font-medium py-3 px-6 rounded-xl border border-white/30 hover:border-white/50 transition-all duration-300">
                            ↩️ Go Back
                        </a>
        </div>
    </div>

    <script>
        // Set the date we're counting down to (exam start time)
        const countDownDate = new Date('{{ $exam->start_time }}').getTime();

        // Update the countdown every 1 second
        const x = setInterval(function() {
            // Get today's date and time
            const now = new Date();
            const distance = countDownDate - now.getTime();

            // Time calculations for days, hours, minutes and seconds
            const days = Math.floor(distance / (1000 * 60 * 60 * 24));
            const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
            const seconds = Math.floor((distance % (1000 * 60)) / 1000);

            // Display the result in the respective elements
            document.getElementById("days").innerHTML = String(days).padStart(2, '0');
            document.getElementById("hours").innerHTML = String(hours).padStart(2, '0');
            document.getElementById("minutes").innerHTML = String(minutes).padStart(2, '0');
            document.getElementById("seconds").innerHTML = String(seconds).padStart(2, '0');

            // If the countdown is over, show the start button
            if (distance < 0) {
                clearInterval(x);
                document.getElementById("days").innerHTML = "00";
                document.getElementById("hours").innerHTML = "00";
                document.getElementById("minutes").innerHTML = "00";
                document.getElementById("seconds").innerHTML = "00";
                document.getElementById("countdownMessage").classList.remove("hidden");
                document.querySelector('.grid').classList.add('hidden');
                document.getElementById("startForm").classList.remove("hidden");
            }
        }, 1000);
    </script>

</body>
</html>