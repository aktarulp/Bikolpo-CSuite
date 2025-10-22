@php
    use Illuminate\Support\Facades\Storage;
@endphp
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Bikolpo Live | {{ $exam->title }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
        .glass-effect {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
        .hover-lift {
            transition: all 0.3s ease;
        }
        .hover-lift:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>
<body class="bg-gray-900 text-white min-h-screen p-4">

    <div class="max-w-7xl mx-auto space-y-6">
        
        <!-- Partner Information Section -->
        <div class="bg-gradient-to-r from-blue-600 to-indigo-700 p-6 md:p-8 rounded-2xl shadow-2xl text-center hover-lift">
            <div class="glass-effect rounded-xl p-4 border border-white/20">
                <p class="text-lg md:text-xl text-gray-200 font-medium">
                    This Exam is hosted by <br/>
                    <span class="text-white font-bold text-xl md:text-2xl">{{ $exam->partner->name ?? 'Bikolpo Live' }}</span>
                </p>
            </div>
        </div>

        <!-- Countdown, Exam Info, and Instructions Section -->
        <div class="flex flex-col xl:flex-row gap-6 items-stretch">
            <!-- Compact Exam Information -->
            <div class="glass-effect rounded-2xl p-6 shadow-2xl hover-lift flex-1 max-w-sm h-80 flex flex-col">
                <h3 class="text-xl font-bold mb-4 text-white flex items-center">
                    <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    Exam Details
                </h3>
                
                <div class="space-y-3 flex-1 flex flex-col justify-center">
                    <div class="flex justify-between items-center py-2 border-b border-white/10">
                        <span class="text-gray-300 text-sm">Duration:</span>
                        <span class="text-white font-semibold">{{ $exam->duration }} min</span>
                    </div>
                    <div class="flex justify-between items-center py-2 border-b border-white/10">
                        <span class="text-gray-300 text-sm">Questions:</span>
                        <span class="text-white font-semibold">{{ $exam->total_questions ?? 'N/A' }}</span>
                    </div>
                    <div class="flex justify-between items-center py-2 border-b border-white/10">
                        <span class="text-gray-300 text-sm">Passing:</span>
                        <span class="text-white font-semibold">{{ $exam->passing_marks }}</span>
                    </div>
                    <div class="flex justify-between items-center py-2">
                        <span class="text-gray-300 text-sm">Start:</span>
                        <span class="text-white font-semibold text-xs">{{ $exam->start_time->format('M d, g:i A') }}</span>
                    </div>
                </div>
            </div>

            <!-- Countdown Section -->
            <div class="bg-gradient-to-br from-indigo-800 to-purple-900 p-6 md:p-8 rounded-3xl shadow-2xl text-center border border-purple-700 hover-lift flex-1 max-w-sm h-80 flex flex-col justify-between relative">
                        <div>
                    <h1 id="countdownTitle" class="text-2xl md:text-3xl font-extrabold mb-6 tracking-wide leading-tight">
                        Exam Starts In
                    </h1>

                    <!-- Countdown Display -->
                    <div id="countdownDisplay" class="flex justify-center gap-4 mb-6">
                        <!-- Hours block -->
                        <div class="bg-white/10 backdrop-blur-sm shadow-lg rounded-full transition-transform transform hover:scale-105 duration-300 ease-in-out w-20 h-20 md:w-24 md:h-24 flex flex-col items-center justify-center">
                            <span id="hours" class="block text-2xl md:text-3xl font-bold mb-1 text-transparent bg-clip-text bg-gradient-to-br from-green-300 to-teal-400">00</span>
                            <span class="block text-xs md:text-sm text-gray-300 uppercase tracking-wider">Hours</span>
                        </div>
                        
                        <!-- Minutes block -->
                        <div class="bg-white/10 backdrop-blur-sm shadow-lg rounded-full transition-transform transform hover:scale-105 duration-300 ease-in-out w-20 h-20 md:w-24 md:h-24 flex flex-col items-center justify-center">
                            <span id="minutes" class="block text-2xl md:text-3xl font-bold mb-1 text-transparent bg-clip-text bg-gradient-to-br from-blue-300 to-cyan-400">00</span>
                            <span class="block text-xs md:text-sm text-gray-300 uppercase tracking-wider">Minutes</span>
                        </div>
                        
                        <!-- Seconds block -->
                        <div class="bg-white/10 backdrop-blur-sm shadow-lg rounded-full transition-transform transform hover:scale-105 duration-300 ease-in-out w-20 h-20 md:w-24 md:h-24 flex flex-col items-center justify-center">
                            <span id="seconds" class="block text-2xl md:text-3xl font-bold mb-1 text-transparent bg-clip-text bg-gradient-to-br from-pink-300 to-rose-400">00</span>
                            <span class="block text-xs md:text-sm text-gray-300 uppercase tracking-wider">Seconds</span>
                        </div>
                    </div>
                    
                    <!-- Start Button (Hidden initially) -->
                    <div id="startButtonDisplay" class="hidden flex flex-col items-center justify-center space-y-4">
                        <img src="{{ asset('images/q-start.png') }}?v={{ time() }}" 
                             alt="Start Exam" 
                             class="w-36 h-36 md:w-44 md:h-44 object-contain shadow-2xl hover:scale-105 transition-all duration-300 cursor-pointer transform hover:shadow-3xl"
                             onclick="document.getElementById('startForm').submit()"
                             onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                        <div class="w-36 h-36 md:w-44 md:h-44 bg-gradient-to-br from-green-400 to-emerald-500 rounded-full flex items-center justify-center shadow-2xl hover:scale-105 transition-all duration-300 cursor-pointer transform hover:shadow-3xl" 
                             onclick="document.getElementById('startForm').submit()"
                             style="display: none;">
                            <svg class="w-12 h-12 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h1m4 0h1m-6 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                    </div>
                        
                        </div>
                        
                <!-- Go Back Button at Bottom -->
                <div class="mt-4">
                    <a href="{{ route('public.quiz.access') }}" 
                       class="inline-block bg-white/10 hover:bg-white/20 text-white font-medium py-2 px-4 rounded-xl border border-white/30 hover:border-white/50 transition-all duration-300 text-sm">
                        ↩️ Go Back
                    </a>
                </div>
            </div>

            <!-- Compact Instructions -->
            <div class="glass-effect rounded-2xl p-6 shadow-2xl hover-lift flex-1 max-w-sm h-80 flex flex-col">
                <h3 class="text-xl font-bold mb-4 text-white flex items-center">
                    <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    Instructions
                </h3>
                
                <div class="space-y-2 flex-1 flex flex-col justify-center">
                    <div class="flex items-start">
                        <div class="w-4 h-4 bg-green-500 rounded-full flex items-center justify-center mr-3 mt-0.5 flex-shrink-0">
                            <svg class="w-2 h-2 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"></path>
                            </svg>
                        </div>
                        <span class="text-gray-300 font-medium text-xs">You have <strong class="text-green-400">{{ $exam->duration }} minutes</strong> to complete</span>
                    </div>
                    
                    <div class="flex items-start">
                        <div class="w-4 h-4 bg-green-500 rounded-full flex items-center justify-center mr-3 mt-0.5 flex-shrink-0">
                            <svg class="w-2 h-2 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"></path>
                            </svg>
                        </div>
                        <span class="text-gray-300 font-medium text-xs">Timer starts immediately when you begin</span>
                    </div>
                    
                    <div class="flex items-start">
                        <div class="w-4 h-4 bg-green-500 rounded-full flex items-center justify-center mr-3 mt-0.5 flex-shrink-0">
                            <svg class="w-2 h-2 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"></path>
                            </svg>
                        </div>
                        <span class="text-gray-300 font-medium text-xs">No pausing or restarting allowed</span>
                    </div>
                    
                    <div class="flex items-start">
                        <div class="w-4 h-4 bg-green-500 rounded-full flex items-center justify-center mr-3 mt-0.5 flex-shrink-0">
                            <svg class="w-2 h-2 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"></path>
                            </svg>
                        </div>
                        <span class="text-gray-300 font-medium text-xs">Ensure stable internet connection</span>
                    </div>
                    
                    <div class="flex items-start">
                        <div class="w-4 h-4 bg-green-500 rounded-full flex items-center justify-center mr-3 mt-0.5 flex-shrink-0">
                            <svg class="w-2 h-2 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"></path>
                            </svg>
                </div>
                        <span class="text-gray-300 font-medium text-xs">Don't refresh or close browser</span>
                </div>
                </div>
            </div>
            </div>

        <!-- Main Content Grid -->
        <div class="grid grid-cols-1 gap-6">
            
            <!-- Full Width: Participant List -->
            <div class="space-y-6">
                <!-- Participant List -->
                <div class="glass-effect rounded-2xl p-6 shadow-2xl hover-lift">
                    <h3 class="text-2xl font-bold text-white mb-4 flex items-center">
                        <div class="w-10 h-10 bg-gradient-to-br from-green-500 to-emerald-600 rounded-lg flex items-center justify-center mr-3">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                            </svg>
                        </div>
                        👥 Participant List
                    </h3>
                    
                    <div class="bg-white/5 backdrop-blur-sm rounded-xl p-4 border border-white/10">
                        @if(isset($participants) && $participants->count() > 0)
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                                @foreach($participants as $participant)
                                <div class="flex items-center p-3 rounded-lg border hover:shadow-md transition-all duration-200 {{ $participant['status'] === 'completed' ? 'bg-gradient-to-r from-blue-50 to-indigo-50 border-blue-100' : 'bg-gradient-to-r from-green-50 to-emerald-50 border-green-100' }} {{ $participant['id'] == $accessInfo['student_id'] ? 'ring-2 ring-yellow-400 ring-opacity-50' : '' }}">
                                    <div class="relative w-10 h-10 rounded-full overflow-hidden mr-3 flex-shrink-0 border-2 {{ $participant['status'] === 'completed' ? 'border-blue-400' : 'border-green-400' }}">
                                        @if(isset($participant['photo']) && $participant['photo'])
                                            <img src="{{ Storage::url($participant['photo']) }}" 
                                                 alt="{{ $participant['name'] }}" 
                                                 class="w-full h-full object-cover"
                                                 onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                                            <div class="w-full h-full flex items-center justify-center {{ $participant['status'] === 'completed' ? 'bg-gradient-to-br from-blue-400 to-indigo-500' : 'bg-gradient-to-br from-green-400 to-emerald-500' }}" style="display: none;">
                                                <span class="text-white font-bold text-sm">{{ substr($participant['name'], 0, 1) }}</span>
                                            </div>
                                        @else
                                            <div class="w-full h-full flex items-center justify-center {{ $participant['status'] === 'completed' ? 'bg-gradient-to-br from-blue-400 to-indigo-500' : 'bg-gradient-to-br from-green-400 to-emerald-500' }}">
                                                <span class="text-white font-bold text-sm">{{ substr($participant['name'], 0, 1) }}</span>
                                            </div>
                                        @endif
                                        
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <div class="text-gray-800 font-medium text-sm truncate flex items-center">
                                            {{ $participant['name'] }}
                                            @if($participant['id'] == $accessInfo['student_id'])
                                                <span class="ml-2 px-2 py-1 bg-gradient-to-r from-yellow-400 to-orange-500 text-white text-xs font-bold rounded-full shadow-md">
                                                    YOU
                                                </span>
                                            @endif
                                        </div>
                                        <div class="text-gray-500 text-xs">
                                            @if($participant['status'] === 'completed')
                                                Completed {{ $participant['completed_at']->diffForHumans() }}
                                            @else
                                                {{ $participant['course_name'] ?? 'Course' }}>{{ $participant['batch_name'] ?? 'Batch' }}>{{ $participant['student_id'] ?? 'ID' }}
                                            @endif
                                            <span class="ml-2 text-xs text-red-500">({{ $participant['status'] }})</span>
                                        </div>
                                    </div>
                                    <div class="flex items-center">
                                        @if($participant['status'] === 'completed')
                                            <span class="w-2 h-2 bg-blue-400 rounded-full"></span>
                                            <span class="text-xs text-gray-600 font-medium ml-2">Completed</span>
                                        @else
                                            <span class="w-2 h-2 bg-green-400 rounded-full animate-pulse"></span>
                                            <span class="text-xs text-gray-600 font-medium ml-2">Waiting</span>
                                        @endif
                                    </div>
                                </div>
                                @endforeach
                            </div>
                            
                            <div class="mt-4 p-3 bg-blue-50 rounded-lg border border-blue-200">
                                <div class="flex items-center text-blue-800">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    <span class="text-sm font-medium">
                                        {{ $participants->where('status', 'waiting')->count() }} waiting, {{ $participants->where('status', 'completed')->count() }} completed
                                    </span>
                                </div>
                            </div>
                        @else
                            <div class="text-center py-8">
                                <div class="w-16 h-16 bg-gray-200 rounded-full flex items-center justify-center mx-auto mb-4">
                                    <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                    </svg>
                                </div>
                                <p class="text-gray-400 text-sm">No participants assigned to this exam</p>
                        </div>
                        @endif
                        </div>
                    </div>
                    
                <!-- Action Buttons -->
                <div class="glass-effect rounded-2xl p-6 shadow-2xl hover-lift">
                    <div class="text-center">
                        <form method="POST" action="{{ route('public.quiz.start-quiz', $exam->id) }}" id="startForm" class="hidden">
                            @csrf
                            <button type="submit" 
                                    class="bg-gradient-to-r from-green-500 to-emerald-600 hover:from-green-600 hover:to-emerald-700 text-white font-bold py-4 px-8 rounded-2xl shadow-lg transform hover:scale-105 transition-all duration-300 w-full max-w-md mx-auto">
                                🚀 Start Exam Now
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Set the date we're counting down to (exam start time)
        const countDownDate = new Date('{{ $exam->start_time }}').getTime();
        const now = new Date();
        const initialDistance = countDownDate - now.getTime();

        // Check if exam has already started when page loads
        if (initialDistance <= 0) {
            // Exam has already started, show start button immediately
            document.getElementById("hours").innerHTML = "00";
            document.getElementById("minutes").innerHTML = "00";
            document.getElementById("seconds").innerHTML = "00";
            document.getElementById("countdownTitle").classList.add("hidden");
            document.getElementById("countdownDisplay").classList.add("hidden");
            document.getElementById("startButtonDisplay").classList.remove("hidden");
            document.getElementById("startForm").classList.remove("hidden");
        } else {
            // Exam hasn't started yet, start countdown
            // Update the countdown every 1 second
            const x = setInterval(function() {
                // Get today's date and time
                const now = new Date();
                const distance = countDownDate - now.getTime();

                // Time calculations for hours, minutes and seconds
                const hours = Math.floor(distance / (1000 * 60 * 60));
                const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                const seconds = Math.floor((distance % (1000 * 60)) / 1000);

                // Display the result in the respective elements
                document.getElementById("hours").innerHTML = String(hours).padStart(2, '0');
                document.getElementById("minutes").innerHTML = String(minutes).padStart(2, '0');
                document.getElementById("seconds").innerHTML = String(seconds).padStart(2, '0');

                // If the countdown is over, show the start button
                if (distance <= 0) {
                    clearInterval(x);
                    document.getElementById("hours").innerHTML = "00";
                    document.getElementById("minutes").innerHTML = "00";
                    document.getElementById("seconds").innerHTML = "00";
                    document.getElementById("countdownTitle").classList.add("hidden");
                    document.getElementById("countdownDisplay").classList.add("hidden");
                    document.getElementById("startButtonDisplay").classList.remove("hidden");
                    document.getElementById("startForm").classList.remove("hidden");
                }
            }, 1000);
        }
    </script>

</body>
</html>