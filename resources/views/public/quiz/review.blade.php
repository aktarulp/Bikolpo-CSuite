<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Exam Review - {{ $exam->title }}</title>
    
    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-gradient-to-br from-blue-50 via-indigo-50 to-purple-50 min-h-screen">
    <div class="min-h-screen py-4">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="text-center mb-4">
                <div class="inline-flex items-center justify-center w-12 h-12 bg-gradient-to-br from-primaryGreen to-emerald-500 rounded-full shadow-lg mb-2">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                </div>
                <h1 class="text-2xl font-bold text-gray-900 mb-1">Exam Review</h1>
                <p class="text-sm text-gray-600">{{ $exam->title }}</p>
            </div>

            <!-- Performance Summary -->
            <div class="bg-white rounded-xl shadow-lg overflow-hidden mb-4">
                <div class="bg-gradient-to-r from-primaryGreen to-emerald-600 text-white p-4">
                    <div class="grid grid-cols-2 lg:grid-cols-5 gap-4 items-center">
                        <div class="text-center lg:text-left">
                            <h2 class="text-lg font-bold">{{ $exam->title }}</h2>
                            <p class="text-emerald-100 text-sm">Performance Review</p>
                        </div>
                        
                        <div class="text-center">
                            <div class="inline-flex items-center justify-center w-16 h-16 bg-white/20 rounded-full backdrop-blur-sm">
                                <div class="text-center">
                                    <div class="text-xl font-bold">{{ number_format($result->percentage ?? 0, 1) }}%</div>
                                    <div class="text-xs text-emerald-100">Score</div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="text-center">
                            <div class="text-lg font-bold">{{ $result->grade ?? 'N/A' }}</div>
                            <div class="text-emerald-100 text-sm">Grade</div>
                        </div>
                        
                        <div class="text-center">
                            <div class="text-lg font-bold">{{ $analytics['correct_answers'] ?? 0 }}/{{ $analytics['total_questions'] ?? 0 }}</div>
                            <div class="text-emerald-100 text-sm">Correct</div>
                        </div>
                        
                        <div class="text-center lg:text-right">
                            <div class="text-center">
                                <div class="text-lg font-bold">#{{ $studentRank ?? 'N/A' }}</div>
                                <div class="text-emerald-100 text-sm">Rank</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Performance Metrics -->
                <div class="p-4">
                    <div class="grid grid-cols-4 gap-3">
                        <div class="text-center">
                            <div class="bg-green-50 rounded-lg p-3 border border-green-200">
                                <div class="text-xl font-bold text-green-600">{{ $analytics['correct_answers'] ?? 0 }}</div>
                                <div class="text-xs text-gray-600 font-medium">Correct</div>
                            </div>
                        </div>
                        
                        <div class="text-center">
                            <div class="bg-red-50 rounded-lg p-3 border border-red-200">
                                <div class="text-xl font-bold text-red-600">{{ $analytics['incorrect_answers'] ?? 0 }}</div>
                                <div class="text-xs text-gray-600 font-medium">Incorrect</div>
                            </div>
                        </div>
                        
                        <div class="text-center">
                            <div class="bg-orange-50 rounded-lg p-3 border border-orange-200">
                                <div class="text-xl font-bold text-orange-600">{{ $analytics['skipped_questions'] ?? 0 }}</div>
                                <div class="text-xs text-gray-600 font-medium">Skipped</div>
                            </div>
                        </div>
                        
                        <div class="text-center">
                            <div class="bg-blue-50 rounded-lg p-3 border border-blue-200">
                                <div class="text-xl font-bold text-blue-600">{{ number_format($analytics['accuracy_percentage'] ?? 0, 1) }}%</div>
                                <div class="text-xs text-gray-600 font-medium">Accuracy</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Review Tabs -->
            <div class="bg-white rounded-xl shadow-lg overflow-hidden mb-4">
                <div class="border-b border-gray-200">
                    <div class="flex items-center justify-between px-4">
                        <nav class="flex space-x-4" aria-label="Tabs">
                            <button onclick="showTab('all')" id="tab-all" class="tab-button active py-3 px-2 border-b-2 border-primaryGreen font-medium text-xs text-primaryGreen">
                                All Questions ({{ $analytics['total_questions'] ?? 0 }})
                            </button>
                            <button onclick="showTab('analytics')" id="tab-analytics" class="tab-button py-3 px-2 border-b-2 border-transparent font-medium text-xs text-gray-500 hover:text-gray-700 hover:border-gray-300">
                                📊 Analytics & Insights
                            </button>
                        </nav>
                        
                        <!-- Global Explanation Toggle Button -->
                        <button onclick="toggleAllExplanations()" 
                                class="inline-flex items-center px-4 py-2.5 rounded-xl text-sm font-semibold bg-gradient-to-r from-blue-500 to-blue-600 text-white hover:from-blue-600 hover:to-blue-700 border-0 shadow-lg hover:shadow-xl transform hover:scale-105 transition-all duration-300 focus:outline-none focus:ring-4 focus:ring-blue-300"
                                id="global-explanation-btn">
                            <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                            </svg>
                            Show Explanation
                        </button>
                    </div>
                </div>

                <!-- Tab Content -->
                <div class="p-4">
                    <!-- All Questions Tab -->
                    <div id="content-all" class="tab-content">
                        <div class="space-y-3">
                            @foreach($questionStats as $index => $questionStat)
                                @include('public.quiz.partials.question-detail', ['questionStat' => $questionStat, 'index' => $index, 'exam' => $exam])
                            @endforeach
                        </div>
                    </div>

                    <!-- Analytics Tab -->
                    <div id="content-analytics" class="tab-content hidden">
                        <div class="space-y-6">
                            <!-- Performance Overview -->
                            <div class="bg-gradient-to-r from-blue-50 to-indigo-50 rounded-xl p-6 border border-blue-200">
                                <h3 class="text-lg font-bold text-gray-900 mb-4 flex items-center">
                                    <svg class="w-5 h-5 mr-2 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    Performance Overview
                                </h3>
                                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                                    <div class="text-center">
                                        <div class="text-2xl font-bold text-green-600">{{ $analytics['correct_answers'] ?? 0 }}</div>
                                        <div class="text-sm text-gray-600">Correct</div>
                                    </div>
                                    <div class="text-center">
                                        <div class="text-2xl font-bold text-red-600">{{ $analytics['incorrect_answers'] ?? 0 }}</div>
                                        <div class="text-sm text-gray-600">Incorrect</div>
                                    </div>
                                    <div class="text-center">
                                        <div class="text-2xl font-bold text-orange-600">{{ $analytics['skipped_questions'] ?? 0 }}</div>
                                        <div class="text-sm text-gray-600">Skipped</div>
                                    </div>
                                    <div class="text-center">
                                        <div class="text-2xl font-bold text-blue-600">{{ $analytics['total_questions'] ?? 0 }}</div>
                                        <div class="text-sm text-gray-600">Total</div>
                                    </div>
                                </div>
                            </div>

                            <!-- Score Analysis -->
                            <div class="bg-gradient-to-r from-green-50 to-emerald-50 rounded-xl p-6 border border-green-200">
                                <h3 class="text-lg font-bold text-gray-900 mb-4 flex items-center">
                                    <svg class="w-5 h-5 mr-2 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                    </svg>
                                    Score Analysis
                                </h3>
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                    <div class="text-center">
                                        <div class="text-3xl font-bold text-green-600">{{ $result->percentage ?? 0 }}%</div>
                                        <div class="text-sm text-gray-600">Overall Score</div>
                                    </div>
                                    <div class="text-center">
                                        <div class="text-3xl font-bold text-blue-600">{{ $result->marks_obtained ?? 0 }}/{{ $result->total_marks ?? 0 }}</div>
                                        <div class="text-sm text-gray-600">Marks Obtained</div>
                                    </div>
                                    <div class="text-center">
                                        <div class="text-3xl font-bold text-purple-600">#{{ $studentRank ?? 'N/A' }}</div>
                                        <div class="text-sm text-gray-600">Your Rank</div>
                                    </div>
                                </div>
                            </div>

                            <!-- Subject-wise Performance -->
                            <div class="bg-gradient-to-r from-purple-50 to-pink-50 rounded-xl p-6 border border-purple-200">
                                <h3 class="text-lg font-bold text-gray-900 mb-4 flex items-center">
                                    <svg class="w-5 h-5 mr-2 text-purple-600" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M3 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z" clip-rule="evenodd"></path>
                                    </svg>
                                    Subject-wise Performance
                                </h3>
                                <div class="space-y-3">
                                    @php
                                        $subjects = $questionStats->groupBy('question.subject.name');
                                    @endphp
                                    @foreach($subjects as $subjectName => $questions)
                                        @php
                                            $correct = $questions->where('is_correct', true)->count();
                                            $total = $questions->count();
                                            $percentage = $total > 0 ? round(($correct / $total) * 100, 1) : 0;
                                        @endphp
                                        <div class="flex items-center justify-between p-3 bg-white rounded-lg border border-gray-200">
                                            <div class="flex items-center">
                                                <div class="w-3 h-3 rounded-full mr-3
                                                    @if($percentage >= 80) bg-green-500
                                                    @elseif($percentage >= 60) bg-yellow-500
                                                    @else bg-red-500 @endif">
                                                </div>
                                                <span class="font-medium text-gray-900">{{ $subjectName ?? 'General' }}</span>
                                            </div>
                                            <div class="text-right">
                                                <div class="text-sm font-bold text-gray-900">{{ $correct }}/{{ $total }}</div>
                                                <div class="text-xs text-gray-500">{{ $percentage }}%</div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>

                            <!-- Time Analysis -->
                            <div class="bg-gradient-to-r from-yellow-50 to-orange-50 rounded-xl p-6 border border-yellow-200">
                                <h3 class="text-lg font-bold text-gray-900 mb-4 flex items-center">
                                    <svg class="w-5 h-5 mr-2 text-yellow-600" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"></path>
                                    </svg>
                                    Time Analysis
                                </h3>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div class="text-center">
                                        <div class="text-2xl font-bold text-yellow-600">{{ $result->time_taken_formatted ?? 'N/A' }}</div>
                                        <div class="text-sm text-gray-600">Total Time</div>
                                    </div>
                                    <div class="text-center">
                                        <div class="text-2xl font-bold text-orange-600">{{ $exam->duration ?? 0 }} min</div>
                                        <div class="text-sm text-gray-600">Time Limit</div>
                                    </div>
                                </div>
                            </div>

                            <!-- Recommendations -->
                            <div class="bg-gradient-to-r from-indigo-50 to-blue-50 rounded-xl p-6 border border-indigo-200">
                                <h3 class="text-lg font-bold text-gray-900 mb-4 flex items-center">
                                    <svg class="w-5 h-5 mr-2 text-indigo-600" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                                    </svg>
                                    Recommendations
                                </h3>
                                <div class="space-y-3">
                                    @if(($analytics['correct_answers'] ?? 0) / ($analytics['total_questions'] ?? 1) >= 0.8)
                                        <div class="flex items-start p-3 bg-green-100 rounded-lg border border-green-200">
                                            <svg class="w-5 h-5 text-green-600 mt-0.5 mr-3" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                            </svg>
                                            <div>
                                                <div class="font-medium text-green-800">Excellent Performance!</div>
                                                <div class="text-sm text-green-700">You scored above 80%. Keep up the great work!</div>
                                            </div>
                                        </div>
                                    @elseif(($analytics['correct_answers'] ?? 0) / ($analytics['total_questions'] ?? 1) >= 0.6)
                                        <div class="flex items-start p-3 bg-yellow-100 rounded-lg border border-yellow-200">
                                            <svg class="w-5 h-5 text-yellow-600 mt-0.5 mr-3" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                            </svg>
                                            <div>
                                                <div class="font-medium text-yellow-800">Good Performance</div>
                                                <div class="text-sm text-yellow-700">You scored above 60%. Focus on weak areas to improve further.</div>
                                            </div>
                                        </div>
                                    @else
                                        <div class="flex items-start p-3 bg-red-100 rounded-lg border border-red-200">
                                            <svg class="w-5 h-5 text-red-600 mt-0.5 mr-3" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                                            </svg>
                                            <div>
                                                <div class="font-medium text-red-800">Needs Improvement</div>
                                                <div class="text-sm text-red-700">Focus on studying the topics you got wrong. Practice more questions.</div>
                                            </div>
                                        </div>
                                    @endif
                                    
                                    @if(($analytics['skipped_questions'] ?? 0) > 0)
                                        <div class="flex items-start p-3 bg-blue-100 rounded-lg border border-blue-200">
                                            <svg class="w-5 h-5 text-blue-600 mt-0.5 mr-3" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                                            </svg>
                                            <div>
                                                <div class="font-medium text-blue-800">Time Management</div>
                                                <div class="text-sm text-blue-700">You skipped {{ $analytics['skipped_questions'] ?? 0 }} questions. Try to answer all questions next time.</div>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex flex-col sm:flex-row gap-2 justify-center">
                <a href="{{ route('public.quiz.result', ['exam' => $exam->id, 'result' => $result->id]) }}" 
                   class="flex-1 sm:flex-none flex justify-center items-center py-2 px-6 bg-gray-600 hover:bg-gray-700 text-white font-medium rounded-lg shadow-md hover:shadow-lg transition-all duration-200">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Back to Result
                </a>
                
                <a href="{{ route('public.quiz.access') }}" 
                   class="flex-1 sm:flex-none flex justify-center items-center py-2 px-6 bg-primaryGreen hover:bg-green-600 text-white font-medium rounded-lg shadow-md hover:shadow-lg transition-all duration-200">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                    Take Another Quiz
                </a>
            </div>
        </div>
    </div>

    <script>
        function showTab(tabName) {
            // Hide all tab contents
            document.querySelectorAll('.tab-content').forEach(content => {
                content.classList.add('hidden');
            });
            
            // Remove active class from all tab buttons
            document.querySelectorAll('.tab-button').forEach(button => {
                button.classList.remove('active', 'border-primaryGreen', 'text-primaryGreen');
                button.classList.add('border-transparent', 'text-gray-500');
            });
            
            // Show selected tab content
            document.getElementById('content-' + tabName).classList.remove('hidden');
            
            // Add active class to selected tab button
            const activeButton = document.getElementById('tab-' + tabName);
            activeButton.classList.add('active', 'border-primaryGreen', 'text-primaryGreen');
            activeButton.classList.remove('border-transparent', 'text-gray-500');
        }

        function toggleAllExplanations() {
            const explanations = document.querySelectorAll('[id^="explanation-"]');
            const button = document.getElementById('global-explanation-btn');
            const isHidden = explanations[0].classList.contains('hidden');
            
            explanations.forEach(explanation => {
                if (isHidden) {
                    explanation.classList.remove('hidden');
                } else {
                    explanation.classList.add('hidden');
                }
            });
            
            if (isHidden) {
                button.innerHTML = `
                    <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M3.707 2.293a1 1 0 00-1.414 1.414l14 14a1 1 0 001.414-1.414l-1.473-1.473A10.014 10.014 0 0019.542 10C18.268 5.943 14.478 3 10 3a9.958 9.958 0 00-4.512 1.074l-1.78-1.781zm4.261 4.26l1.514 1.515a2.003 2.003 0 012.45 2.45l1.514 1.514a4 4 0 00-5.478-5.478z" clip-rule="evenodd"></path>
                        <path d="M12.454 16.697L9.75 13.992a4 4 0 01-3.742-3.741L2.335 6.578A9.98 9.98 0 00.458 10c1.274 4.057 5.065 7 9.542 7 .847 0 1.669-.105 2.454-.303z"></path>
                    </svg>
                    Hide Explanation
                `;
            } else {
                button.innerHTML = `
                    <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                    </svg>
                    Show Explanation
                `;
            }
        }
    </script>
</body>
</html>