@extends('layouts.partner-layout')

@section('title', 'Exam Results - ' . $exam->title)

@section('content')
<div class="min-h-screen bg-gray-50 dark:bg-gray-900 py-0">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-6">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-3">
                    <a href="{{ route('partner.exams.show', $exam) }}" 
                       class="inline-flex items-center px-3 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-600 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                        Back to Exam
                    </a>
                    <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Exam Results</h1>
                </div>
                <div class="flex space-x-3">
                    <a href="{{ route('partner.exams.export', $exam) }}" 
                       class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-green-600 border border-transparent rounded-lg hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        Export Results
                    </a>
                </div>
            </div>
        </div>

        <!-- Exam Information Card -->
        <div class="bg-white dark:bg-gray-800 shadow-lg rounded-lg overflow-hidden mb-6">
            <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                <div class="flex items-center space-x-3">
                    <span class="inline-flex items-center px-3 py-1.5 rounded-lg text-sm font-bold bg-gradient-to-r from-blue-500 to-indigo-600 text-white shadow-lg ring-2 ring-blue-200 dark:ring-blue-800/50">
                        #{{ $exam->id }}
                    </span>
                    <h2 class="text-lg font-semibold text-gray-900 dark:text-white">{{ $exam->title }}</h2>
                </div>
            </div>
            <div class="px-6 py-4">
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                    <div class="text-center">
                        <div class="text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">Status</div>
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                            @if($exam->status === 'published') bg-green-100 text-green-800
                            @elseif($exam->status === 'draft') bg-gray-100 text-gray-800
                            @elseif($exam->status === 'ongoing') bg-blue-100 text-blue-800
                            @elseif($exam->status === 'completed') bg-purple-100 text-purple-800
                            @else bg-red-100 text-red-800 @endif">
                            {{ ucfirst($exam->status) }}
                        </span>
                    </div>
                    <div class="text-center">
                        <div class="text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">Total Questions</div>
                        <span class="text-sm font-semibold text-gray-900 dark:text-white">{{ $exam->total_questions }}</span>
                    </div>
                    <div class="text-center">
                        <div class="text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">Passing Marks</div>
                        <span class="text-sm font-semibold text-gray-900 dark:text-white">{{ $exam->passing_marks }}%</span>
                    </div>
                    <div class="text-center">
                        <div class="text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">Duration</div>
                        <span class="text-sm font-semibold text-gray-900 dark:text-white">
                            @php
                                $hours = floor($exam->duration / 60);
                                $minutes = $exam->duration % 60;
                            @endphp
                            @if($hours > 0)
                                {{ $hours }}H{{ $minutes > 0 ? ' ' . $minutes . 'M' : '' }}
                            @else
                                {{ $minutes }}M
                            @endif
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Statistics Cards -->
        @if($results->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
            @php
                $totalStudents = $results->total();
                $passedStudents = $results->where('percentage', '>=', $exam->passing_marks)->count();
                $failedStudents = $totalStudents - $passedStudents;
                $avgScore = $results->avg('percentage');
                $avgTime = $results->whereNotNull('started_at')->whereNotNull('completed_at')->avg(function($result) {
                    return $result->started_at->diffInMinutes($result->completed_at);
                });
            @endphp
            
            <div class="bg-white dark:bg-gray-800 shadow-lg rounded-lg p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-8 h-8 bg-blue-100 dark:bg-blue-900 rounded-lg flex items-center justify-center">
                            <svg class="w-5 h-5 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Total Students</p>
                        <p class="text-2xl font-semibold text-gray-900 dark:text-white">{{ $totalStudents }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white dark:bg-gray-800 shadow-lg rounded-lg p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-8 h-8 bg-green-100 dark:bg-green-900 rounded-lg flex items-center justify-center">
                            <svg class="w-5 h-5 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Passed</p>
                        <p class="text-2xl font-semibold text-gray-900 dark:text-white">{{ $passedStudents }}</p>
                        <p class="text-sm text-gray-500 dark:text-gray-400">{{ $totalStudents > 0 ? round(($passedStudents / $totalStudents) * 100, 1) : 0 }}%</p>
                    </div>
                </div>
            </div>

            <div class="bg-white dark:bg-gray-800 shadow-lg rounded-lg p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-8 h-8 bg-red-100 dark:bg-red-900 rounded-lg flex items-center justify-center">
                            <svg class="w-5 h-5 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Failed</p>
                        <p class="text-2xl font-semibold text-gray-900 dark:text-white">{{ $failedStudents }}</p>
                        <p class="text-sm text-gray-500 dark:text-gray-400">{{ $totalStudents > 0 ? round(($failedStudents / $totalStudents) * 100, 1) : 0 }}%</p>
                    </div>
                </div>
            </div>

            <div class="bg-white dark:bg-gray-800 shadow-lg rounded-lg p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-8 h-8 bg-purple-100 dark:bg-purple-900 rounded-lg flex items-center justify-center">
                            <svg class="w-5 h-5 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Average Score</p>
                        <p class="text-2xl font-semibold text-gray-900 dark:text-white">{{ round($avgScore, 1) }}%</p>
                        @if($avgTime)
                        <p class="text-sm text-gray-500 dark:text-gray-400">Avg: {{ round($avgTime) }} min</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Results Table -->
        <div class="bg-white dark:bg-gray-800 shadow-lg rounded-lg overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                <h3 class="text-lg font-medium text-gray-900 dark:text-white">Student Results</h3>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                    <thead class="bg-gray-50 dark:bg-gray-700">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Student</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Score</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Percentage</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Time Taken</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Completed</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Details</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                        @forelse($results as $result)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-10 w-10">
                                        <div class="h-10 w-10 rounded-full bg-gray-300 dark:bg-gray-600 flex items-center justify-center">
                                            <span class="text-sm font-medium text-gray-700 dark:text-gray-300">
                                                {{ strtoupper(substr($result->student->full_name, 0, 1)) }}
                                            </span>
                                        </div>
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-medium text-gray-900 dark:text-white">{{ $result->student->full_name }}</div>
                                        <div class="text-sm text-gray-500 dark:text-gray-400">{{ $result->student->student_id }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900 dark:text-white">{{ $result->score }}/{{ $result->total_questions }}</div>
                                <div class="text-sm text-gray-500 dark:text-gray-400">
                                    {{ $result->correct_answers }} correct, {{ $result->wrong_answers }} wrong
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <span class="text-sm font-medium text-gray-900 dark:text-white">{{ $result->percentage }}%</span>
                                    <div class="ml-2 w-16 bg-gray-200 dark:bg-gray-700 rounded-full h-2">
                                        <div class="bg-blue-600 h-2 rounded-full" style="width: {{ $result->percentage }}%"></div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($result->percentage >= $exam->passing_marks)
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200">
                                        Passed
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200">
                                        Failed
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white">
                                @if($result->time_taken)
                                    {{ $result->time_taken }} min
                                @else
                                    <span class="text-gray-500 dark:text-gray-400">-</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white">
                                @if($result->completed_at)
                                    {{ $result->completed_at->format('M d, Y H:i') }}
                                @else
                                    <span class="text-gray-500 dark:text-gray-400">Not completed</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <button class="text-blue-600 hover:text-blue-900 dark:text-blue-400 dark:hover:text-blue-300" 
                                        onclick="showResultDetails({{ $result->id }})">
                                    View Details
                                </button>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="px-6 py-4 text-center text-gray-500 dark:text-gray-400">
                                No results found for this exam.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            <!-- Pagination -->
            @if($results->hasPages())
            <div class="px-6 py-4 border-t border-gray-200 dark:border-gray-700">
                {{ $results->links() }}
            </div>
            @endif
        </div>
        @else
        <!-- No Results State -->
        <div class="bg-white dark:bg-gray-800 shadow-lg rounded-lg p-12 text-center">
            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
            </svg>
            <h3 class="mt-2 text-sm font-medium text-gray-900 dark:text-white">No results yet</h3>
            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                Students haven't taken this exam yet or results haven't been processed.
            </p>
        </div>
        @endif
    </div>
</div>

<!-- Result Details Modal -->
<div id="resultModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
    <div class="relative top-20 mx-auto p-5 border w-11/12 md:w-3/4 lg:w-1/2 shadow-lg rounded-md bg-white dark:bg-gray-800">
        <div class="mt-3">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-medium text-gray-900 dark:text-white">Result Details</h3>
                <button onclick="closeResultModal()" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            <div id="resultDetails" class="space-y-4">
                <!-- Result details will be loaded here -->
            </div>
        </div>
    </div>
</div>

<script>
function showResultDetails(resultId) {
    // This would typically make an AJAX call to get detailed result information
    // For now, we'll show a placeholder
    document.getElementById('resultDetails').innerHTML = `
        <div class="text-center py-8">
            <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-blue-600 mx-auto"></div>
            <p class="mt-4 text-gray-500 dark:text-gray-400">Loading result details...</p>
        </div>
    `;
    document.getElementById('resultModal').classList.remove('hidden');
}

function closeResultModal() {
    document.getElementById('resultModal').classList.add('hidden');
}

// Close modal when clicking outside
document.getElementById('resultModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeResultModal();
    }
});
</script>
@endsection
