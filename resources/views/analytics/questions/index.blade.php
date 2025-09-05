<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Question Analytics Dashboard - {{ config('app.name', 'Laravel') }}</title>
    
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
        .stat-card {
            background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
        }
        .stat-card-2 {
            background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
        }
        .stat-card-3 {
            background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);
        }
        .stat-card-4 {
            background: linear-gradient(135deg, #fa709a 0%, #fee140 100%);
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
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <h1 class="text-xl font-bold text-white">Question Analytics Dashboard</h1>
                            <p class="text-blue-100 text-sm">Comprehensive insights into question performance</p>
                        </div>
                    </div>
                    <div class="flex items-center space-x-4">
                        <a href="{{ route('partner.dashboard') }}" 
                           class="text-white hover:text-blue-200 transition-colors duration-200 flex items-center space-x-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                            </svg>
                            <span>Back to Dashboard</span>
                        </a>
                    </div>
                </div>
            </div>
        </nav>

        <!-- Main Content -->
        <div class="max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
            
            <!-- Key Metrics Overview -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <!-- Total Questions -->
                <div class="stat-card rounded-xl p-6 text-white card-hover">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-blue-100 text-sm font-medium">Total Questions</p>
                            <p class="text-3xl font-bold">{{ number_format($totalQuestions) }}</p>
                            <p class="text-blue-100 text-xs mt-1">In question bank</p>
                        </div>
                        <div class="p-3 bg-white bg-opacity-20 rounded-full">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Total Attempts -->
                <div class="stat-card-2 rounded-xl p-6 text-white card-hover">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-blue-100 text-sm font-medium">Total Attempts</p>
                            <p class="text-3xl font-bold">{{ number_format($totalAttempts) }}</p>
                            <p class="text-blue-100 text-xs mt-1">Question attempts</p>
                        </div>
                        <div class="p-3 bg-white bg-opacity-20 rounded-full">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Correct Answers -->
                <div class="stat-card-3 rounded-xl p-6 text-white card-hover">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-blue-100 text-sm font-medium">Correct Answers</p>
                            <p class="text-3xl font-bold">{{ number_format($totalCorrect) }}</p>
                            <p class="text-blue-100 text-xs mt-1">{{ $totalAttempts > 0 ? round(($totalCorrect / $totalAttempts) * 100, 1) : 0 }}% success rate</p>
                        </div>
                        <div class="p-3 bg-white bg-opacity-20 rounded-full">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Overall Accuracy -->
                <div class="stat-card-4 rounded-xl p-6 text-white card-hover">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-blue-100 text-sm font-medium">Overall Accuracy</p>
                            <p class="text-3xl font-bold">{{ $overallAccuracy }}%</p>
                            <p class="text-blue-100 text-xs mt-1">Average performance</p>
                        </div>
                        <div class="p-3 bg-white bg-opacity-20 rounded-full">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Charts and Analytics -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
                <!-- Performance Distribution Chart -->
                <div class="bg-white rounded-xl shadow-lg p-6 card-hover">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Performance Distribution</h3>
                    <div class="h-64">
                        <canvas id="performanceChart"></canvas>
                    </div>
                </div>

                <!-- Answer Status Breakdown -->
                <div class="bg-white rounded-xl shadow-lg p-6 card-hover">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Answer Status Breakdown</h3>
                    <div class="space-y-4">
                        <div class="flex items-center justify-between p-4 bg-green-50 rounded-lg">
                            <div class="flex items-center space-x-3">
                                <div class="w-4 h-4 bg-green-500 rounded-full"></div>
                                <span class="font-medium text-gray-900">Correct Answers</span>
                            </div>
                            <div class="text-right">
                                <span class="text-2xl font-bold text-green-600">{{ number_format($totalCorrect) }}</span>
                                <p class="text-sm text-gray-500">{{ $totalAttempts > 0 ? round(($totalCorrect / $totalAttempts) * 100, 1) : 0 }}%</p>
                            </div>
                        </div>
                        
                        <div class="flex items-center justify-between p-4 bg-red-50 rounded-lg">
                            <div class="flex items-center space-x-3">
                                <div class="w-4 h-4 bg-red-500 rounded-full"></div>
                                <span class="font-medium text-gray-900">Incorrect Answers</span>
                            </div>
                            <div class="text-right">
                                <span class="text-2xl font-bold text-red-600">{{ number_format($totalIncorrect) }}</span>
                                <p class="text-sm text-gray-500">{{ $totalAttempts > 0 ? round(($totalIncorrect / $totalAttempts) * 100, 1) : 0 }}%</p>
                            </div>
                        </div>
                        
                        <div class="flex items-center justify-between p-4 bg-yellow-50 rounded-lg">
                            <div class="flex items-center space-x-3">
                                <div class="w-4 h-4 bg-yellow-500 rounded-full"></div>
                                <span class="font-medium text-gray-900">Skipped Questions</span>
                            </div>
                            <div class="text-right">
                                <span class="text-2xl font-bold text-yellow-600">{{ number_format($totalSkipped) }}</span>
                                <p class="text-sm text-gray-500">{{ $totalAttempts > 0 ? round(($totalSkipped / $totalAttempts) * 100, 1) : 0 }}%</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Question Performance Analysis -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
                <!-- Top Performing Questions -->
                <div class="bg-white rounded-xl shadow-lg p-6 card-hover">
                    <div class="flex items-center justify-between mb-6">
                        <h3 class="text-lg font-semibold text-gray-900">Top Performing Questions</h3>
                        <span class="text-sm text-gray-500">Highest accuracy</span>
                    </div>
                    <div class="space-y-4">
                        @forelse($topQuestions as $index => $questionStat)
                            <div class="flex items-center justify-between p-4 bg-green-50 rounded-lg border-l-4 border-green-500">
                                <div class="flex-1">
                                    <div class="flex items-center space-x-3">
                                        <span class="flex-shrink-0 w-8 h-8 bg-green-500 text-white rounded-full flex items-center justify-center text-sm font-bold">
                                            {{ $index + 1 }}
                                        </span>
                                        <div class="flex-1 min-w-0">
                                            <a href="{{ route('analytics.questions.show', $questionStat->question_id) }}" 
                                               class="text-sm font-medium text-gray-900 truncate hover:text-blue-600 transition-colors duration-200">
                                                {{ $questionStat->question->question_text ?? 'Question #' . $questionStat->question_id }}
                                            </a>
                                            <p class="text-xs text-gray-500">
                                                {{ $questionStat->total_attempts }} attempts • {{ $questionStat->correct_attempts }} correct
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <span class="text-lg font-bold text-green-600">{{ $questionStat->accuracy_percentage }}%</span>
                                </div>
                            </div>
                        @empty
                            <div class="text-center py-8">
                                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                                </svg>
                                <p class="text-gray-500 mt-2">No data available</p>
                            </div>
                        @endforelse
                    </div>
                </div>

                <!-- Questions Needing Attention -->
                <div class="bg-white rounded-xl shadow-lg p-6 card-hover">
                    <div class="flex items-center justify-between mb-6">
                        <h3 class="text-lg font-semibold text-gray-900">Questions Needing Attention</h3>
                        <span class="text-sm text-gray-500">Lowest accuracy</span>
                    </div>
                    <div class="space-y-4">
                        @forelse($worstQuestions as $index => $questionStat)
                            <div class="flex items-center justify-between p-4 bg-red-50 rounded-lg border-l-4 border-red-500">
                                <div class="flex-1">
                                    <div class="flex items-center space-x-3">
                                        <span class="flex-shrink-0 w-8 h-8 bg-red-500 text-white rounded-full flex items-center justify-center text-sm font-bold">
                                            {{ $index + 1 }}
                                        </span>
                                        <div class="flex-1 min-w-0">
                                            <a href="{{ route('analytics.questions.show', $questionStat->question_id) }}" 
                                               class="text-sm font-medium text-gray-900 truncate hover:text-blue-600 transition-colors duration-200">
                                                {{ $questionStat->question->question_text ?? 'Question #' . $questionStat->question_id }}
                                            </a>
                                            <p class="text-xs text-gray-500">
                                                {{ $questionStat->total_attempts }} attempts • {{ $questionStat->correct_attempts }} correct
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <span class="text-lg font-bold text-red-600">{{ $questionStat->accuracy_percentage }}%</span>
                                </div>
                            </div>
                        @empty
                            <div class="text-center py-8">
                                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                                </svg>
                                <p class="text-gray-500 mt-2">No data available</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>

            <!-- Quick Actions & Export -->
            <div class="bg-white rounded-xl shadow-lg p-6 card-hover">
                <h3 class="text-lg font-semibold text-gray-900 mb-6">Quick Actions & Tools</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                    <a href="{{ route('partner.questions.index') }}" 
                       class="flex items-center p-4 bg-blue-50 rounded-lg hover:bg-blue-100 transition-colors duration-200 group">
                        <div class="p-3 bg-blue-500 rounded-lg group-hover:bg-blue-600 transition-colors duration-200">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <h4 class="font-medium text-gray-900">Manage Questions</h4>
                            <p class="text-sm text-gray-600">Edit and organize questions</p>
                        </div>
                    </a>

                    <a href="{{ route('partner.exams.index') }}" 
                       class="flex items-center p-4 bg-green-50 rounded-lg hover:bg-green-100 transition-colors duration-200 group">
                        <div class="p-3 bg-green-500 rounded-lg group-hover:bg-green-600 transition-colors duration-200">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <h4 class="font-medium text-gray-900">Manage Exams</h4>
                            <p class="text-sm text-gray-600">Create and schedule exams</p>
                        </div>
                    </a>

                    <button onclick="exportAnalytics()" 
                            class="flex items-center p-4 bg-purple-50 rounded-lg hover:bg-purple-100 transition-colors duration-200 group">
                        <div class="p-3 bg-purple-500 rounded-lg group-hover:bg-purple-600 transition-colors duration-200">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <h4 class="font-medium text-gray-900">Export Data</h4>
                            <p class="text-sm text-gray-600">Download analytics report</p>
                        </div>
                    </button>

                    <a href="{{ route('partner.dashboard') }}" 
                       class="flex items-center p-4 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors duration-200 group">
                        <div class="p-3 bg-gray-500 rounded-lg group-hover:bg-gray-600 transition-colors duration-200">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2z"></path>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <h4 class="font-medium text-gray-900">Dashboard</h4>
                            <p class="text-sm text-gray-600">Back to main dashboard</p>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Performance Distribution Chart
        const ctx = document.getElementById('performanceChart').getContext('2d');
        new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: ['Correct', 'Incorrect', 'Skipped'],
                datasets: [{
                    data: [{{ $totalCorrect }}, {{ $totalIncorrect }}, {{ $totalSkipped }}],
                    backgroundColor: [
                        '#10B981',
                        '#EF4444',
                        '#F59E0B'
                    ],
                    borderWidth: 0
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            padding: 20,
                            usePointStyle: true
                        }
                    }
                }
            }
        });

        // Export Analytics Function
        function exportAnalytics() {
            // Create CSV content
            const csvContent = "data:text/csv;charset=utf-8," + 
                "Metric,Value\n" +
                "Total Questions,{{ $totalQuestions }}\n" +
                "Total Attempts,{{ $totalAttempts }}\n" +
                "Correct Answers,{{ $totalCorrect }}\n" +
                "Incorrect Answers,{{ $totalIncorrect }}\n" +
                "Skipped Questions,{{ $totalSkipped }}\n" +
                "Overall Accuracy,{{ $overallAccuracy }}%\n";
            
            // Create and download file
            const encodedUri = encodeURI(csvContent);
            const link = document.createElement("a");
            link.setAttribute("href", encodedUri);
            link.setAttribute("download", "question_analytics_" + new Date().toISOString().split('T')[0] + ".csv");
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);
        }

        // Add some interactive animations
        document.addEventListener('DOMContentLoaded', function() {
            // Animate stat cards on load
            const statCards = document.querySelectorAll('.stat-card, .stat-card-2, .stat-card-3, .stat-card-4');
            statCards.forEach((card, index) => {
                setTimeout(() => {
                    card.style.opacity = '0';
                    card.style.transform = 'translateY(20px)';
                    card.style.transition = 'all 0.6s ease';
                    setTimeout(() => {
                        card.style.opacity = '1';
                        card.style.transform = 'translateY(0)';
                    }, 100);
                }, index * 100);
            });
        });
    </script>
</body>
</html>