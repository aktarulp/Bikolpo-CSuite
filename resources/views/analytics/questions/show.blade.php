<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Question Analytics - {{ $question->id }} - {{ config('app.name', 'Laravel') }}</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <!-- Chart.js for data visualization -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    
    <style>
        .gradient-bg {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
        .card-hover {
            transition: all 0.3s ease;
        }
        .card-hover:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(0,0,0,0.1);
        }
    </style>
</head>
<body class="font-sans antialiased bg-gray-50">
    <div class="min-h-screen">
        <!-- Navigation Header -->
        <nav class="gradient-bg shadow-lg">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <svg class="h-8 w-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <h1 class="text-xl font-bold text-white">Question Analytics</h1>
                            <p class="text-blue-100 text-sm">Detailed performance analysis</p>
                        </div>
                    </div>
                    <div class="flex items-center space-x-4">
                        @if($question->question_type === 'mcq')
                            <a href="{{ route('partner.questions.mcq.edit', $question) }}" 
                               class="text-white hover:text-blue-200 transition-colors duration-200 flex items-center space-x-2 bg-blue-600 hover:bg-blue-700 px-4 py-2 rounded-lg">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                </svg>
                                <span>Edit MCQ</span>
                            </a>
                        @elseif($question->question_type === 'descriptive')
                            <a href="{{ route('partner.questions.descriptive.edit', $question) }}" 
                               class="text-white hover:text-blue-200 transition-colors duration-200 flex items-center space-x-2 bg-blue-600 hover:bg-blue-700 px-4 py-2 rounded-lg">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                </svg>
                                <span>Edit Descriptive</span>
                            </a>
                        @endif
                        <a href="{{ route('analytics.questions.index') }}" 
                           class="text-white hover:text-blue-200 transition-colors duration-200 flex items-center space-x-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                            </svg>
                            <span>Back to Analytics</span>
                        </a>
                    </div>
                </div>
            </div>
        </nav>

        <!-- Main Content -->
        <div class="max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
            
            <!-- Question Details -->
            <div class="bg-white rounded-xl shadow-lg p-6 mb-8 card-hover">
                <div class="flex items-start justify-between">
                    <div class="flex-1">
                        <h2 class="text-2xl font-bold text-gray-900 mb-2">Question #{{ $question->id }}</h2>
                        <div class="prose max-w-none">
                            <p class="text-gray-700 text-lg leading-relaxed">{{ $question->question_text }}</p>
                        </div>
                        <div class="mt-4 flex flex-wrap gap-4 text-sm text-gray-600">
                            <span class="flex items-center">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                                </svg>
                                Type: {{ ucfirst($question->question_type) }}
                            </span>
                            <span class="flex items-center">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                Correct Answer: {{ $question->correct_answer }}
                            </span>
                        </div>
                    </div>
                    <div class="ml-6">
                        <div class="text-right">
                            <div class="text-3xl font-bold text-blue-600">{{ $analytics['correct_percentage'] }}%</div>
                            <div class="text-sm text-gray-500">Accuracy Rate</div>
                            <div class="mt-4">
                                @if($question->question_type === 'mcq')
                                    <a href="{{ route('partner.questions.mcq.edit', $question) }}" 
                                       class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                        </svg>
                                        Edit MCQ Question
                                    </a>
                                @elseif($question->question_type === 'descriptive')
                                    <a href="{{ route('partner.questions.descriptive.edit', $question) }}" 
                                       class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                        </svg>
                                        Edit Descriptive Question
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Performance Metrics -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <div class="bg-white rounded-xl shadow-lg p-6 card-hover">
                    <div class="flex items-center">
                        <div class="p-3 bg-blue-100 rounded-full">
                            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-600">Total Appearances</p>
                            <p class="text-2xl font-semibold text-gray-900">{{ $analytics['total_appearances'] }}</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-lg p-6 card-hover">
                    <div class="flex items-center">
                        <div class="p-3 bg-green-100 rounded-full">
                            <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-600">Correct Answers</p>
                            <p class="text-2xl font-semibold text-gray-900">{{ $analytics['total_correct'] }}</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-lg p-6 card-hover">
                    <div class="flex items-center">
                        <div class="p-3 bg-red-100 rounded-full">
                            <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-600">Incorrect Answers</p>
                            <p class="text-2xl font-semibold text-gray-900">{{ $analytics['total_incorrect'] }}</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-lg p-6 card-hover">
                    <div class="flex items-center">
                        <div class="p-3 bg-yellow-100 rounded-full">
                            <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-600">Answer Rate</p>
                            <p class="text-2xl font-semibold text-gray-900">{{ $analytics['answer_rate'] }}%</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Performance by Exam -->
            @if($performanceByExam->count() > 0)
            <div class="bg-white rounded-xl shadow-lg p-6 mb-8 card-hover">
                <h3 class="text-lg font-semibold text-gray-900 mb-6">Performance by Exam</h3>
                <div class="space-y-4">
                    @foreach($performanceByExam as $examPerformance)
                        <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                            <div class="flex-1">
                                <h4 class="font-medium text-gray-900">{{ $examPerformance->exam->title ?? 'Exam #' . $examPerformance->exam_id }}</h4>
                                <p class="text-sm text-gray-600">{{ $examPerformance->total_attempts }} attempts</p>
                            </div>
                            <div class="text-right">
                                <span class="text-lg font-bold text-blue-600">{{ $examPerformance->accuracy_percentage }}%</span>
                                <p class="text-xs text-gray-500">{{ $examPerformance->correct_attempts }}/{{ $examPerformance->total_attempts }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            @endif

            <!-- Answer Distribution (for MCQ) -->
            @if($question->question_type === 'mcq' && $answerDistribution->count() > 0)
            <div class="bg-white rounded-xl shadow-lg p-6 mb-8 card-hover">
                <h3 class="text-lg font-semibold text-gray-900 mb-6">Answer Distribution</h3>
                <div class="space-y-3">
                    @foreach($answerDistribution as $distribution)
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-3">
                                <span class="w-8 h-8 bg-blue-100 text-blue-800 rounded-full flex items-center justify-center text-sm font-bold">
                                    {{ strtoupper($distribution->student_answer) }}
                                </span>
                                <span class="font-medium text-gray-900">Option {{ strtoupper($distribution->student_answer) }}</span>
                            </div>
                            <div class="text-right">
                                <span class="text-lg font-bold text-gray-900">{{ $distribution->count }}</span>
                                <p class="text-xs text-gray-500">students</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            @endif

            <!-- Recent Attempts -->
            @if($recentAttempts->count() > 0)
            <div class="bg-white rounded-xl shadow-lg p-6 card-hover">
                <h3 class="text-lg font-semibold text-gray-900 mb-6">Recent Attempts</h3>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Student</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Answer</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Result</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($recentAttempts as $attempt)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                        {{ $attempt->student->full_name ?? 'Student #' . $attempt->student_id }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ $attempt->student_answer ?? 'No answer' }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                            @if($attempt->is_correct) bg-green-100 text-green-800
                                            @elseif($attempt->is_skipped) bg-yellow-100 text-yellow-800
                                            @else bg-red-100 text-red-800 @endif">
                                            @if($attempt->is_correct) Correct
                                            @elseif($attempt->is_skipped) Skipped
                                            @else Incorrect @endif
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $attempt->question_answered_at ? $attempt->question_answered_at->format('M d, Y H:i') : 'N/A' }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            @endif
        </div>
    </div>
</body>
</html>
