@extends('layouts.student-layout')

@section('title', 'My Exams')

@section('content')
<div class="space-y-6">
    <!-- Page Header -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div>
            <h1 class="text-2xl md:text-3xl font-bold text-gray-900 dark:text-white">My Exams</h1>
            <p class="text-gray-600 dark:text-gray-400 mt-1">View all exams assigned to you</p>
        </div>
        <a href="{{ route('student.dashboard') }}" 
           class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-gray-600 to-gray-700 hover:from-gray-700 hover:to-gray-800 text-white rounded-lg shadow-md hover:shadow-lg transition-all duration-300 transform hover:-translate-y-0.5">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Back to Dashboard
        </a>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <div class="bg-gradient-to-br from-primaryGreen/10 to-emerald-50 dark:from-primaryGreen/20 dark:to-emerald-900/30 rounded-xl p-5 border border-primaryGreen/20 shadow-sm">
            <div class="flex items-center">
                <div class="p-3 rounded-lg bg-primaryGreen/10">
                    <svg class="w-6 h-6 text-primaryGreen" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <h3 class="text-lg font-bold text-gray-900 dark:text-white">{{ $assignedExams->count() }}</h3>
                    <p class="text-gray-600 dark:text-gray-400 text-sm">Total Exams</p>
                </div>
            </div>
        </div>

        <div class="bg-gradient-to-br from-blue-50 to-blue-100 dark:from-blue-900/30 dark:to-blue-800/20 rounded-xl p-5 border border-blue-200 dark:border-blue-800/50 shadow-sm">
            <div class="flex items-center">
                <div class="p-3 rounded-lg bg-blue-100 dark:bg-blue-900/50">
                    <svg class="w-6 h-6 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <h3 class="text-lg font-bold text-gray-900 dark:text-white">{{ $assignedExams->where('status', 'published')->count() }}</h3>
                    <p class="text-gray-600 dark:text-gray-400 text-sm">Available Now</p>
                </div>
            </div>
        </div>

        <div class="bg-gradient-to-br from-amber-50 to-amber-100 dark:from-amber-900/30 dark:to-amber-800/20 rounded-xl p-5 border border-amber-200 dark:border-amber-800/50 shadow-sm">
            <div class="flex items-center">
                <div class="p-3 rounded-lg bg-amber-100 dark:bg-amber-900/50">
                    <svg class="w-6 h-6 text-amber-600 dark:text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002-2h2a2 2 0 002 2"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <h3 class="text-lg font-bold text-gray-900 dark:text-white">{{ $assignedExams->where('studentResults.*.status', 'completed')->count() }}</h3>
                    <p class="text-gray-600 dark:text-gray-400 text-sm">Completed</p>
                </div>
            </div>
        </div>
    </div>

    <!-- My Exams -->
    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg overflow-hidden">
        <div class="p-5 md:p-6 border-b border-gray-200 dark:border-gray-700">
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3">
                <h2 class="text-lg md:text-xl font-bold text-gray-900 dark:text-white">
                    Assigned Exams
                </h2>
                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-primaryGreen/10 text-primaryGreen dark:bg-primaryGreen/20">
                    {{ $assignedExams->count() }} exams
                </span>
            </div>
        </div>

        @if($assignedExams->count() > 0)
            <!-- Mobile View - Card Layout -->
            <div class="lg:hidden">
                <div class="divide-y divide-gray-200 dark:divide-gray-700">
                    @foreach($assignedExams as $exam)
                        <div class="p-5 hover:bg-gray-50 dark:hover:bg-gray-750 transition-colors duration-200">
                            <div class="flex justify-between items-start">
                                <div>
                                    <h3 class="font-bold text-gray-900 dark:text-white">{{ $exam->title }}</h3>
                                    <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">ID: {{ $exam->id }}</p>
                                </div>
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                    @if($exam->status === 'published' && now()->between($exam->start_time, $exam->end_time))
                                        bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200
                                    @elseif($exam->status === 'published')
                                        bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200
                                    @else
                                        bg-gray-100 text-gray-800 dark:bg-gray-600 dark:text-gray-200
                                    @endif">
                                    @if($exam->status === 'published' && now()->between($exam->start_time, $exam->end_time))
                                        Available
                                    @elseif($exam->status === 'published')
                                        Scheduled
                                    @else
                                        {{ ucfirst($exam->status) }}
                                    @endif
                                </span>
                            </div>

                            <div class="mt-4 flex flex-wrap gap-2">
                                @php
                                    $result = $exam->studentResults->first();
                                @endphp

                                @if($result && $result->status === 'completed')
                                    <a href="{{ route('student.exams.result', $exam) }}" 
                                       class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white text-sm font-medium rounded-lg shadow-md hover:shadow-lg transition-all duration-300">
                                        View Result
                                    </a>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Desktop View - Table Layout -->
            <div class="hidden lg:block overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                    <thead class="bg-gray-50 dark:bg-gray-750">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Exam ID</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Exam Name</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Schedule</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Total Questions</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Status</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Actions</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Results</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200 dark:bg-gray-800 dark:divide-gray-700">
                        @foreach($assignedExams as $exam)
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-750 transition-colors duration-200">
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-white">
                                    {{ $exam->id }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white">
                                    {{ $exam->title }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                    @if($exam->start_time && $exam->end_time)
                                        {{ $exam->start_time->format('M d, Y g:i A') }}
                                    @else
                                        <span class="text-gray-400">Not scheduled</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white">
                                    {{ $exam->total_questions ?? 0 }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                        @if($exam->status === 'published' && now()->between($exam->start_time, $exam->end_time))
                                            bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200
                                        @elseif($exam->status === 'published')
                                            bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200
                                        @else
                                            bg-gray-100 text-gray-800 dark:bg-gray-600 dark:text-gray-200
                                        @endif">
                                        @if($exam->status === 'published' && now()->between($exam->start_time, $exam->end_time))
                                            Available
                                        @elseif($exam->status === 'published')
                                            Scheduled
                                        @else
                                            {{ ucfirst($exam->status) }}
                                        @endif
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm">
                                    @php
                                        $canTakeExam = $exam->status === 'published' && 
                                                      now()->between($exam->start_time, $exam->end_time);
                                        $isUpcoming = $exam->status === 'published' && 
                                                     now()->lt($exam->start_time);
                                    @endphp
                                    
                                    @if($canTakeExam)
                                        <a href="{{ route('student.exams.start', $exam) }}" 
                                           class="inline-flex items-center px-3 py-1.5 bg-gradient-to-r from-primaryGreen to-emerald-600 hover:from-primaryGreen/90 hover:to-emerald-700 text-white text-xs font-medium rounded-lg shadow transition-all duration-300">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"></path>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                            Start Now
                                        </a>
                                    @elseif($isUpcoming)
                                        <span class="inline-flex items-center px-3 py-1.5 text-xs font-medium rounded-lg text-amber-700 bg-amber-100 dark:bg-amber-900 dark:text-amber-200">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                            <span id="countdown-table-{{ $exam->id }}" data-start-time="{{ $exam->start_time->timestamp }}">
                                                {{ $exam->start_time->diffForHumans() }}
                                            </span>
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-3 py-1.5 text-xs font-medium rounded-lg text-gray-500 bg-gray-100 dark:bg-gray-700">
                                            @if($exam->status !== 'published')
                                                Not Published
                                            @else
                                                Not Available
                                            @endif
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm">
                                    @php
                                        $result = $exam->studentResults->first();
                                    @endphp
                                    
                                    @if($result)
                                        @if($result->status === 'completed')
                                            <a href="{{ route('student.exams.result', $exam) }}" 
                                               class="inline-flex items-center px-3 py-1.5 bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white text-xs font-medium rounded-lg shadow transition-all duration-300">
                                                View Result
                                            </a>
                                        @elseif($result->status === 'in_progress')
                                            <span class="inline-flex items-center px-3 py-1.5 text-xs font-medium rounded-lg text-amber-700 bg-amber-100 dark:bg-amber-900 dark:text-amber-200">
                                                In Progress
                                            </span>
                                        @endif
                                    @else
                                        <span class="inline-flex items-center px-3 py-1.5 text-xs font-medium rounded-lg text-gray-500 bg-gray-100 dark:bg-gray-700">
                                            Not Attempted
                                        </span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="p-12 text-center">
                <div class="mx-auto flex items-center justify-center h-16 w-16 rounded-full bg-primaryGreen/10">
                    <svg class="h-8 w-8 text-primaryGreen" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                </div>
                <h3 class="mt-4 text-lg font-medium text-gray-900 dark:text-white">No exams assigned</h3>
                <p class="mt-1 text-gray-500 dark:text-gray-400">You don't have any exams assigned to you yet.</p>
                <div class="mt-6">
                    <a href="{{ route('student.dashboard') }}" 
                       class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-primaryGreen to-emerald-600 hover:from-primaryGreen/90 hover:to-emerald-700 text-white rounded-lg shadow-md hover:shadow-lg transition-all duration-300">
                        Back to Dashboard
                    </a>
                </div>
            </div>
        @endif
    </div>
</div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Function to update countdown
    function updateCountdown() {
        const countdownElements = document.querySelectorAll('[id^="countdown-"], [id^="countdown-table-"]');
        
        countdownElements.forEach(element => {
            const startTime = parseInt(element.dataset.startTime);
            const examStartTime = new Date(startTime * 1000);
            const now = new Date();
            
            // If exam time has passed, redirect to refresh the page
            if (now >= examStartTime) {
                window.location.reload();
                return;
            }
            
            // Calculate time difference
            const diff = examStartTime - now;
            
            // Calculate days, hours, minutes, seconds
            const days = Math.floor(diff / (1000 * 60 * 60 * 24));
            const hours = Math.floor((diff % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            const minutes = Math.floor((diff % (1000 * 60 * 60)) / (1000 * 60));
            const seconds = Math.floor((diff % (1000 * 60)) / 1000);
            
            // Format the display
            let displayText = '';
            if (days > 0) {
                displayText = `${days}d ${hours}h ${minutes}m`;
            } else if (hours > 0) {
                displayText = `${hours}h ${minutes}m ${seconds}s`;
            } else if (minutes > 0) {
                displayText = `${minutes}m ${seconds}s`;
            } else {
                displayText = `${seconds}s`;
            }
            
            element.textContent = displayText;
        });
    }
    
    // Update countdown immediately and then every second
    updateCountdown();
    setInterval(updateCountdown, 1000);
});
</script>
@endsection
