@extends('layouts.app')

@section('title', 'Student Analytics - ' . $student->full_name)

@section('content')
<div class="min-h-screen bg-gray-50 dark:bg-gray-900 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md overflow-hidden mb-8">
            <div class="px-6 py-4 bg-gradient-to-r from-blue-600 to-purple-600">
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-2xl font-bold text-white">{{ $student->full_name }}</h1>
                        <p class="text-blue-100">Student ID: {{ $student->student_id }}</p>
                        <p class="text-blue-100">{{ $student->partner->name ?? 'No Institute' }}</p>
                    </div>
                    <div class="text-right text-white">
                        <div class="text-3xl font-bold">{{ $comprehensiveAnalytics['overall_accuracy'] }}%</div>
                        <div class="text-sm text-blue-100">Overall Accuracy</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Key Metrics -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6">
                <div class="flex items-center">
                    <div class="p-2 bg-green-100 dark:bg-green-900 rounded-lg">
                        <svg class="w-6 h-6 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Correct Answers</p>
                        <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $comprehensiveAnalytics['total_correct_answers'] }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6">
                <div class="flex items-center">
                    <div class="p-2 bg-red-100 dark:bg-red-900 rounded-lg">
                        <svg class="w-6 h-6 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Incorrect Answers</p>
                        <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $comprehensiveAnalytics['total_incorrect_answers'] }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6">
                <div class="flex items-center">
                    <div class="p-2 bg-yellow-100 dark:bg-yellow-900 rounded-lg">
                        <svg class="w-6 h-6 text-yellow-600 dark:text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Skipped Questions</p>
                        <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $comprehensiveAnalytics['total_skipped_questions'] }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6">
                <div class="flex items-center">
                    <div class="p-2 bg-blue-100 dark:bg-blue-900 rounded-lg">
                        <svg class="w-6 h-6 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Exams Taken</p>
                        <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $comprehensiveAnalytics['total_exams_taken'] }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Performance Overview -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
            <!-- Question Type Performance -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Performance by Question Type</h3>
                <div class="space-y-4">
                    @foreach($questionTypePerformance as $type => $stats)
                    <div>
                        <div class="flex justify-between items-center mb-2">
                            <span class="text-sm font-medium text-gray-700 dark:text-gray-300 capitalize">{{ $type }}</span>
                            <span class="text-sm text-gray-600 dark:text-gray-400">{{ $stats['correct'] }}/{{ $stats['total'] }}</span>
                        </div>
                        <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-2">
                            <div class="bg-blue-600 h-2 rounded-full" style="width: {{ $stats['total'] > 0 ? round(($stats['correct'] / $stats['total']) * 100, 2) : 0 }}%"></div>
                        </div>
                        <div class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                            {{ $stats['total'] > 0 ? round(($stats['correct'] / $stats['total']) * 100, 2) : 0 }}% accuracy
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            <!-- Difficulty Performance -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Performance by Difficulty</h3>
                <div class="space-y-4">
                    @foreach($difficultyPerformance as $difficulty => $stats)
                    <div>
                        <div class="flex justify-between items-center mb-2">
                            <span class="text-sm font-medium text-gray-700 dark:text-gray-300 capitalize">{{ $difficulty }}</span>
                            <span class="text-sm text-gray-600 dark:text-gray-400">{{ $stats['correct'] }}/{{ $stats['total'] }}</span>
                        </div>
                        <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-2">
                            <div class="bg-{{ $difficulty === 'easy' ? 'green' : ($difficulty === 'medium' ? 'yellow' : 'red') }}-600 h-2 rounded-full" style="width: {{ $stats['total'] > 0 ? round(($stats['correct'] / $stats['total']) * 100, 2) : 0 }}%"></div>
                        </div>
                        <div class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                            {{ $stats['total'] > 0 ? round(($stats['correct'] / $stats['total']) * 100, 2) : 0 }}% accuracy
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Exam Results -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md overflow-hidden mb-8">
            <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Exam Results</h3>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                    <thead class="bg-gray-50 dark:bg-gray-700">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Exam</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Score</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Grade</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Date</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                        @foreach($examResults as $result)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900 dark:text-white">{{ $result->exam->title ?? 'Unknown Exam' }}</div>
                                <div class="text-sm text-gray-500 dark:text-gray-400">{{ $result->correct_answers }}/{{ $result->total_questions }} questions</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900 dark:text-white">{{ $result->percentage }}%</div>
                                <div class="text-sm text-gray-500 dark:text-gray-400">{{ $result->score }} points</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full
                                    {{ $result->grade === 'A+' || $result->grade === 'A' ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200' : 
                                       ($result->grade === 'B' ? 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200' : 
                                       ($result->grade === 'C' ? 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200' : 
                                       'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200')) }}">
                                    {{ $result->grade }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full
                                    {{ $result->is_passed ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200' : 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200' }}">
                                    {{ $result->is_passed ? 'Passed' : 'Failed' }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                {{ $result->completed_at ? $result->completed_at->format('M j, Y g:i A') : 'N/A' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <button onclick="showExamDetails({{ $result->id }})" class="text-blue-600 hover:text-blue-900 dark:text-blue-400 dark:hover:text-blue-300">
                                    View Details
                                </button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Recent Performance -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md overflow-hidden mb-8">
            <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Recent Performance</h3>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                    <thead class="bg-gray-50 dark:bg-gray-700">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Question</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Type</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Result</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Exam</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Date</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                        @foreach($recentPerformance as $performance)
                        <tr>
                            <td class="px-6 py-4">
                                <div class="text-sm font-medium text-gray-900 dark:text-white">
                                    {{ Str::limit($performance->question->question_text ?? 'N/A', 50) }}
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full
                                    {{ $performance->question_type === 'mcq' ? 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200' : 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200' }}">
                                    {{ strtoupper($performance->question_type) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($performance->is_correct)
                                    <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200">
                                        Correct
                                    </span>
                                @elseif($performance->is_skipped)
                                    <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200">
                                        Skipped
                                    </span>
                                @else
                                    <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200">
                                        Incorrect
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                {{ $performance->exam->title ?? 'N/A' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                {{ $performance->created_at->format('M j, Y g:i A') }}
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Improvement Trend -->
        @if($improvementTrend['trend'] !== 'insufficient_data')
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6 mb-8">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Performance Trend</h3>
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600 dark:text-gray-400">Overall Change</p>
                    <p class="text-2xl font-bold {{ $improvementTrend['change'] > 0 ? 'text-green-600' : ($improvementTrend['change'] < 0 ? 'text-red-600' : 'text-gray-600') }}">
                        {{ $improvementTrend['change'] > 0 ? '+' : '' }}{{ $improvementTrend['change'] }}%
                    </p>
                </div>
                <div class="text-right">
                    <p class="text-sm text-gray-600 dark:text-gray-400">First Score</p>
                    <p class="text-lg font-semibold text-gray-900 dark:text-white">{{ $improvementTrend['first_score'] }}%</p>
                </div>
                <div class="text-right">
                    <p class="text-sm text-gray-600 dark:text-gray-400">Latest Score</p>
                    <p class="text-lg font-semibold text-gray-900 dark:text-white">{{ $improvementTrend['last_score'] }}%</p>
                </div>
                <div class="text-right">
                    <p class="text-sm text-gray-600 dark:text-gray-400">Total Exams</p>
                    <p class="text-lg font-semibold text-gray-900 dark:text-white">{{ $improvementTrend['total_exams'] }}</p>
                </div>
            </div>
        </div>
        @endif

        <!-- Difficult Questions -->
        @if($difficultQuestions->count() > 0)
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md overflow-hidden mb-8">
            <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Questions to Review</h3>
                <p class="text-sm text-gray-600 dark:text-gray-400">Questions you found difficult</p>
            </div>
            <div class="p-6">
                <div class="space-y-4">
                    @foreach($difficultQuestions as $question)
                    <div class="border border-gray-200 dark:border-gray-700 rounded-lg p-4">
                        <div class="flex justify-between items-start">
                            <div class="flex-1">
                                <p class="text-sm font-medium text-gray-900 dark:text-white mb-2">
                                    {{ $question->question->question_text ?? 'Question not available' }}
                                </p>
                                <div class="flex items-center space-x-4 text-xs text-gray-500 dark:text-gray-400">
                                    <span>Type: {{ strtoupper($question->question_type) }}</span>
                                    <span>Exam: {{ $question->exam->title ?? 'N/A' }}</span>
                                    <span>Date: {{ $question->created_at->format('M j, Y') }}</span>
                                </div>
                            </div>
                            <div class="ml-4">
                                <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200">
                                    Incorrect
                                </span>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
        @endif
    </div>
</div>

<!-- Exam Details Modal -->
<div id="examDetailsModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
    <div class="relative top-20 mx-auto p-5 border w-11/12 md:w-3/4 lg:w-1/2 shadow-lg rounded-md bg-white dark:bg-gray-800">
        <div class="mt-3">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-medium text-gray-900 dark:text-white">Exam Details</h3>
                <button onclick="closeExamDetails()" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            <div id="examDetailsContent">
                <!-- Content will be loaded here -->
            </div>
        </div>
    </div>
</div>

<script>
function showExamDetails(examResultId) {
    // Show loading state
    document.getElementById('examDetailsContent').innerHTML = `
        <div class="text-center py-8">
            <div class="animate-spin rounded-full h-8 w-8 border-b-2 border-blue-600 mx-auto"></div>
            <p class="text-gray-500 dark:text-gray-400 mt-2">Loading exam details...</p>
        </div>
    `;
    document.getElementById('examDetailsModal').classList.remove('hidden');
    
    // Fetch detailed exam results
    fetch(`/analytics/api/students/{{ $student->id }}/exam-results/${examResultId}`)
        .then(response => response.json())
        .then(data => {
            displayExamDetails(data);
        })
        .catch(error => {
            console.error('Error:', error);
            document.getElementById('examDetailsContent').innerHTML = `
                <div class="text-center py-8">
                    <p class="text-red-500">Error loading exam details. Please try again.</p>
                </div>
            `;
        });
}

function displayExamDetails(data) {
    const { exam_result, detailed_analytics, correct_questions, incorrect_questions, skipped_questions } = data;
    
    const content = `
        <div class="space-y-6">
            <!-- Exam Header -->
            <div class="bg-gradient-to-r from-blue-50 to-purple-50 dark:from-gray-700 dark:to-gray-600 rounded-lg p-4">
                <h4 class="text-xl font-bold text-gray-900 dark:text-white">${exam_result.exam.title}</h4>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mt-4">
                    <div class="text-center">
                        <div class="text-2xl font-bold text-blue-600 dark:text-blue-400">${exam_result.percentage}%</div>
                        <div class="text-sm text-gray-600 dark:text-gray-400">Score</div>
                    </div>
                    <div class="text-center">
                        <div class="text-2xl font-bold text-gray-900 dark:text-white">${exam_result.grade}</div>
                        <div class="text-sm text-gray-600 dark:text-gray-400">Grade</div>
                    </div>
                    <div class="text-center">
                        <div class="text-2xl font-bold ${exam_result.is_passed ? 'text-green-600 dark:text-green-400' : 'text-red-600 dark:text-red-400'}">${exam_result.is_passed ? 'PASSED' : 'FAILED'}</div>
                        <div class="text-sm text-gray-600 dark:text-gray-400">Status</div>
                    </div>
                    <div class="text-center">
                        <div class="text-2xl font-bold text-gray-900 dark:text-white">${exam_result.time_taken || 'N/A'}</div>
                        <div class="text-sm text-gray-600 dark:text-gray-400">Minutes</div>
                    </div>
                </div>
            </div>
            
            <!-- Performance Breakdown -->
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                <div class="bg-green-50 dark:bg-green-900 rounded-lg p-4 text-center">
                    <div class="text-2xl font-bold text-green-600 dark:text-green-400">${detailed_analytics.correct_answers}</div>
                    <div class="text-sm text-green-700 dark:text-green-300">Correct</div>
                </div>
                <div class="bg-red-50 dark:bg-red-900 rounded-lg p-4 text-center">
                    <div class="text-2xl font-bold text-red-600 dark:text-red-400">${detailed_analytics.incorrect_answers}</div>
                    <div class="text-sm text-red-700 dark:text-red-300">Incorrect</div>
                </div>
                <div class="bg-yellow-50 dark:bg-yellow-900 rounded-lg p-4 text-center">
                    <div class="text-2xl font-bold text-yellow-600 dark:text-yellow-400">${detailed_analytics.skipped_questions}</div>
                    <div class="text-sm text-yellow-700 dark:text-yellow-300">Skipped</div>
                </div>
                <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4 text-center">
                    <div class="text-2xl font-bold text-gray-600 dark:text-gray-400">${detailed_analytics.unanswered_questions}</div>
                    <div class="text-sm text-gray-700 dark:text-gray-300">Unanswered</div>
                </div>
            </div>
            
            <!-- Question Type Breakdown -->
            <div>
                <h5 class="text-lg font-semibold text-gray-900 dark:text-white mb-3">Performance by Question Type</h5>
                <div class="space-y-3">
                    ${Object.entries(detailed_analytics.question_type_breakdown).map(([type, stats]) => `
                        <div>
                            <div class="flex justify-between items-center mb-1">
                                <span class="text-sm font-medium text-gray-700 dark:text-gray-300 capitalize">${type}</span>
                                <span class="text-sm text-gray-600 dark:text-gray-400">${stats.correct}/${stats.total}</span>
                            </div>
                            <div class="w-full bg-gray-200 dark:bg-gray-600 rounded-full h-2">
                                <div class="bg-blue-600 h-2 rounded-full" style="width: ${stats.total > 0 ? Math.round((stats.correct / stats.total) * 100) : 0}%"></div>
                            </div>
                        </div>
                    `).join('')}
                </div>
            </div>
            
            <!-- Question Details -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Correct Questions -->
                <div>
                    <h5 class="text-lg font-semibold text-green-600 dark:text-green-400 mb-3">Correct Answers (${correct_questions.length})</h5>
                    <div class="space-y-2 max-h-64 overflow-y-auto">
                        ${correct_questions.map(q => `
                            <div class="bg-green-50 dark:bg-green-900 border border-green-200 dark:border-green-700 rounded p-3">
                                <p class="text-sm text-gray-900 dark:text-white">${q.question ? q.question.question_text.substring(0, 100) + '...' : 'Question not available'}</p>
                                <p class="text-xs text-green-600 dark:text-green-400 mt-1">Type: ${q.question_type.toUpperCase()}</p>
                            </div>
                        `).join('')}
                    </div>
                </div>
                
                <!-- Incorrect Questions -->
                <div>
                    <h5 class="text-lg font-semibold text-red-600 dark:text-red-400 mb-3">Incorrect Answers (${incorrect_questions.length})</h5>
                    <div class="space-y-2 max-h-64 overflow-y-auto">
                        ${incorrect_questions.map(q => `
                            <div class="bg-red-50 dark:bg-red-900 border border-red-200 dark:border-red-700 rounded p-3">
                                <p class="text-sm text-gray-900 dark:text-white">${q.question ? q.question.question_text.substring(0, 100) + '...' : 'Question not available'}</p>
                                <p class="text-xs text-red-600 dark:text-red-400 mt-1">Type: ${q.question_type.toUpperCase()}</p>
                                <p class="text-xs text-gray-600 dark:text-gray-400 mt-1">Your Answer: ${q.student_answer || 'N/A'}</p>
                                <p class="text-xs text-gray-600 dark:text-gray-400">Correct Answer: ${q.correct_answer || 'N/A'}</p>
                            </div>
                        `).join('')}
                    </div>
                </div>
                
                <!-- Skipped Questions -->
                <div>
                    <h5 class="text-lg font-semibold text-yellow-600 dark:text-yellow-400 mb-3">Skipped Questions (${skipped_questions.length})</h5>
                    <div class="space-y-2 max-h-64 overflow-y-auto">
                        ${skipped_questions.map(q => `
                            <div class="bg-yellow-50 dark:bg-yellow-900 border border-yellow-200 dark:border-yellow-700 rounded p-3">
                                <p class="text-sm text-gray-900 dark:text-white">${q.question ? q.question.question_text.substring(0, 100) + '...' : 'Question not available'}</p>
                                <p class="text-xs text-yellow-600 dark:text-yellow-400 mt-1">Type: ${q.question_type.toUpperCase()}</p>
                            </div>
                        `).join('')}
                    </div>
                </div>
            </div>
        </div>
    `;
    
    document.getElementById('examDetailsContent').innerHTML = content;
}

function closeExamDetails() {
    document.getElementById('examDetailsModal').classList.add('hidden');
}

// Close modal when clicking outside
document.getElementById('examDetailsModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeExamDetails();
    }
});
</script>
@endsection
