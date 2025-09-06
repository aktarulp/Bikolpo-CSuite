<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Select Exam</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
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
</head>
<body class="bg-gradient-to-br from-gray-50 to-gray-100 min-h-screen">
    <div class="container mx-auto px-4 py-8">
        <!-- Header -->
        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center w-20 h-20 bg-primaryGreen rounded-full mb-4">
                <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                </svg>
            </div>
            <h1 class="text-3xl md:text-4xl font-bold text-gray-900 mb-2">Select Your Exam</h1>
            <p class="text-lg text-gray-600">You have access to multiple exams. Choose the one you want to take.</p>
        </div>

        <!-- Student Info -->
        <div class="max-w-2xl mx-auto mb-8">
            <div class="bg-white rounded-2xl shadow-lg border border-gray-200 p-6">
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-3">
                        <div class="w-12 h-12 bg-primaryGreen rounded-full flex items-center justify-center">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Logged in as</p>
                            <p class="font-medium text-gray-900">{{ session('student_info.student_name') ?? 'Student' }}</p>
                        </div>
                    </div>
                    
                    <a href="{{ route('public.quiz.access') }}" class="text-primaryGreen hover:text-emerald-600 font-medium text-sm hover:underline">
                        Logout
                    </a>
                </div>
            </div>
        </div>

        <!-- Available Exams -->
        <div class="max-w-4xl mx-auto">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($availableExams as $examData)
                    @php
                        $exam = $examData['exam'];
                        $status = $examData['status'];
                        $canTake = $examData['can_take'];
                        
                        // Status colors and messages
                        $statusConfig = [
                            'active' => [
                                'color' => 'bg-green-100 text-green-800 border-green-200',
                                'icon' => 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z',
                                'message' => 'Ready to start'
                            ],
                            'scheduled' => [
                                'color' => 'bg-blue-100 text-blue-800 border-blue-200',
                                'icon' => 'M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z',
                                'message' => 'Scheduled for later'
                            ],
                            'completed' => [
                                'color' => 'bg-gray-100 text-gray-800 border-gray-200',
                                'icon' => 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z',
                                'message' => 'Already completed'
                            ],
                            'unavailable' => [
                                'color' => 'bg-red-100 text-red-800 border-red-200',
                                'icon' => 'M6 18L18 6M6 6l12 12',
                                'message' => 'Not available'
                            ]
                        ];
                        
                        $config = $statusConfig[$status] ?? $statusConfig['unavailable'];
                    @endphp
                    
                    <div class="bg-white rounded-2xl shadow-lg border border-gray-200 overflow-hidden hover:shadow-xl transition-all duration-200 {{ $canTake ? 'hover:border-primaryGreen' : 'opacity-75' }}">
                        <!-- Exam Header -->
                        <div class="p-6 border-b border-gray-100">
                            <div class="flex items-start justify-between mb-3">
                                <h3 class="text-lg font-semibold text-gray-900 line-clamp-2">{{ $exam->title }}</h3>
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $config['color'] }}">
                                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $config['icon'] }}"></path>
                                    </svg>
                                    {{ ucfirst($status) }}
                                </span>
                            </div>
                            
                            <p class="text-sm text-gray-600 mb-4">
                                {{ Str::limit($exam->description, 100) ?: 'No description available' }}
                            </p>
                            
                            <div class="text-xs text-gray-500">
                                <span class="font-medium">Partner:</span> {{ $exam->partner->name ?? 'Unknown' }}
                            </div>
                        </div>
                        
                        <!-- Exam Details -->
                        <div class="p-6 space-y-3">
                            <div class="flex items-center justify-between text-sm">
                                <span class="text-gray-500">Duration:</span>
                                <span class="font-medium text-gray-900">{{ $exam->duration }} minutes</span>
                            </div>
                            
                            <div class="flex items-center justify-between text-sm">
                                <span class="text-gray-500">Questions:</span>
                                <span class="font-medium text-gray-900">{{ $exam->total_questions ?? 'Not set' }}</span>
                            </div>
                            
                            @if($status === 'scheduled')
                                <div class="flex items-center justify-between text-sm">
                                    <span class="text-gray-500">Starts:</span>
                                    <span class="font-medium text-gray-900">{{ $exam->formatted_start_time }}</span>
                                </div>
                            @endif
                            
                            @if($status === 'active')
                                <div class="flex items-center justify-between text-sm">
                                    <span class="text-gray-500">Ends:</span>
                                    <span class="font-medium text-gray-900">{{ $exam->formatted_end_time }}</span>
                                </div>
                            @endif
                        </div>
                        
                        <!-- Action Button -->
                        <div class="px-6 pb-6">
                            @if($canTake)
                                @if($status === 'active')
                                    <a href="{{ route('public.quiz.start', $exam) }}" 
                                       class="w-full bg-primaryGreen hover:bg-emerald-600 text-white font-medium py-3 px-4 rounded-xl transition-colors duration-200 text-center block">
                                        Start Exam
                                    </a>
                                @elseif($status === 'scheduled')
                                    <a href="{{ route('public.quiz.waiting', $exam) }}" 
                                       class="w-full bg-blue-500 hover:bg-blue-600 text-white font-medium py-3 px-4 rounded-xl transition-colors duration-200 text-center block">
                                        Go to Waiting Room
                                    </a>
                                @else
                                    <button disabled class="w-full bg-gray-300 text-gray-500 font-medium py-3 px-4 rounded-xl cursor-not-allowed">
                                        Not Available
                                    </button>
                                @endif
                            @else
                                <div class="text-center py-3">
                                    <span class="text-sm text-gray-500">Already completed</span>
                                </div>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
            
            <!-- No Exams Message -->
            @if($availableExams->isEmpty())
                <div class="text-center py-12">
                    <div class="mx-auto h-24 w-24 bg-gray-100 rounded-full flex items-center justify-center mb-6">
                        <svg class="h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                    </div>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">No exams available</h3>
                    <p class="text-gray-500 mb-6">You don't have access to any exams at the moment.</p>
                    <a href="{{ route('public.quiz.access') }}" 
                       class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-primaryGreen hover:bg-emerald-600">
                        Try Different Access Code
                    </a>
                </div>
            @endif
        </div>
    </div>
</body>
</html>
