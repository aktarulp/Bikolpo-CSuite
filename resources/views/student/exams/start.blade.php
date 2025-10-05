@extends('layouts.partner-layout')

@section('title', 'Start Exam - ' . $exam->title)

@section('content')
<div class="min-h-screen bg-gradient-to-br from-blue-50 via-indigo-50 to-purple-50 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Hero Section -->
        <div class="bg-gradient-to-r from-blue-600 to-indigo-700 rounded-3xl p-12 text-center text-white relative overflow-hidden mb-8">
            <!-- Floating Elements -->
            <div class="absolute top-10 left-10 w-20 h-20 bg-white/20 rounded-full animate-pulse"></div>
            <div class="absolute top-20 right-20 w-16 h-16 bg-white/20 rounded-full animate-pulse" style="animation-delay: 1s;"></div>
            <div class="absolute bottom-10 left-1/4 w-12 h-12 bg-white/20 rounded-full animate-pulse" style="animation-delay: 2s;"></div>
            
            <!-- Main Content -->
            <div class="relative z-10">
                <div class="mx-auto h-28 w-28 bg-white/20 rounded-3xl flex items-center justify-center mb-8 shadow-2xl">
                    <svg class="w-16 h-16 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                    </svg>
                </div>
                
                <h1 class="text-5xl sm:text-6xl font-bold mb-6 leading-tight">{{ $exam->title }}</h1>
                
                <div class="inline-flex items-center px-8 py-4 bg-white/20 backdrop-blur-sm rounded-2xl border border-white/30">
                    <div class="w-3 h-3 bg-green-400 rounded-full mr-4 animate-pulse"></div>
                    <span class="text-xl font-medium">Ready to begin your exam</span>
                </div>
            </div>
        </div>

        <!-- Main Content Grid -->
        <div class="grid grid-cols-1 xl:grid-cols-3 gap-8">
            
            <!-- Left Column: Exam Details -->
            <div class="xl:col-span-2 space-y-8">
                
                <!-- Exam Information Panel -->
                <div class="bg-gradient-to-r from-emerald-500 to-teal-600 rounded-3xl p-8 text-white shadow-2xl">
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
                                        <div class="text-xl font-bold">{{ $exam->passing_marks }}%</div>
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
                <div class="bg-white rounded-3xl p-8 shadow-2xl border border-gray-100">
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
                <div class="bg-gradient-to-r from-amber-400 to-orange-500 rounded-3xl p-8 shadow-2xl">
                    <h3 class="text-2xl font-bold text-white mb-6 flex items-center">
                        <div class="w-10 h-10 bg-white/20 rounded-xl flex items-center justify-center mr-4">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        ⚠️ Important Instructions
                    </h3>
                    
                    <div class="space-y-4">
                        <div class="flex items-start bg-white/20 backdrop-blur-sm rounded-xl p-4 border border-white/30">
                            <div class="w-6 h-6 bg-white rounded-full flex items-center justify-center mr-3 mt-1 flex-shrink-0">
                                <svg class="w-4 h-4 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                            </div>
                            <span class="text-white font-medium">You have <strong>{{ $exam->duration }} minutes</strong> to complete</span>
                        </div>
                        
                        <div class="flex items-start bg-white/20 backdrop-blur-sm rounded-xl p-4 border border-white/30">
                            <div class="w-6 h-6 bg-white rounded-full flex items-center justify-center mr-3 mt-1 flex-shrink-0">
                                <svg class="w-4 h-4 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                            </div>
                            <span class="text-white font-medium">Timer starts immediately when you begin</span>
                        </div>
                        
                        <div class="flex items-start bg-white/20 backdrop-blur-sm rounded-xl p-4 border border-white/30">
                            <div class="w-6 h-6 bg-white rounded-full flex items-center justify-center mr-3 mt-1 flex-shrink-0">
                                <svg class="w-4 h-4 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                            </div>
                            <span class="text-white font-medium">No pausing or restarting allowed</span>
                        </div>
                        
                        <div class="flex items-start bg-white/20 backdrop-blur-sm rounded-xl p-4 border border-white/30">
                            <div class="w-6 h-6 bg-white rounded-full flex items-center justify-center mr-3 mt-1 flex-shrink-0">
                                <svg class="w-4 h-4 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                            </div>
                            <span class="text-white font-medium">Ensure stable internet connection</span>
                        </div>
                        
                        <div class="flex items-start bg-white/20 backdrop-blur-sm rounded-xl p-4 border border-white/30">
                            <div class="w-6 h-6 bg-white rounded-full flex items-center justify-center mr-3 mt-1 flex-shrink-0">
                                <svg class="w-4 h-4 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                            </div>
                            <span class="text-white font-medium">Don't refresh or close browser</span>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="space-y-6">
                    <a href="{{ route('student.exams.take', $exam) }}" 
                       class="w-full flex justify-center py-5 px-8 rounded-2xl text-xl font-bold text-white bg-gradient-to-r from-emerald-500 to-teal-600 hover:from-emerald-600 hover:to-teal-700 transform hover:scale-105 transition-all duration-300 shadow-2xl border-2 border-emerald-400 hover:border-emerald-300">
                        <svg class="w-7 h-7 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h1m4 0h1m-6 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        🚀 Start Exam Now
                    </a>
                    
                    <a href="{{ route('student.exams.available') }}" 
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

// Initialize time updates
setInterval(updateCurrentTime, 1000);
updateCurrentTime();
</script>
@endsection
