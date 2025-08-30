@extends('layouts.partner-layout')

@section('title', 'Partner Dashboard')

@section('content')
<div class="space-y-6">
    <!-- Error Display -->
    @if(isset($error))
    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
        <strong class="font-bold">Error:</strong>
        <span class="block sm:inline">{{ $error }}</span>
    </div>
    @endif

    <!-- Page Header -->
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Dashboard</h1>
            <p class="text-gray-600 dark:text-gray-400">Welcome to your exam management dashboard</p>
        </div>
        <div class="flex space-x-3">
            <button id="refreshStatsBtn" 
                    class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg transition-colors duration-200 flex items-center space-x-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                </svg>
                <span>Refresh Stats</span>
            </button>
            <a href="{{ route('partner.questions.create') }}" 
               class="bg-primaryGreen hover:bg-green-600 text-white px-4 py-2 rounded-lg transition-colors duration-200">
                Add Question
            </a>
            <a href="{{ route('partner.exams.create') }}" 
               class="bg-primaryOrange hover:bg-orange-600 text-white px-4 py-2 rounded-lg transition-colors duration-200">
                Create Exam
            </a>
            <a href="{{ route('typing.test') }}" 
               class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition-colors duration-200">
                Typing Test
            </a>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-5 gap-6">
        <!-- Total Questions -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6 border border-gray-200 dark:border-gray-700">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-blue-100 dark:bg-blue-900">
                    <svg class="w-6 h-6 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Total Questions</p>
                    <p class="text-2xl font-semibold text-gray-900 dark:text-white" data-stat="total_questions">{{ $stats['total_questions'] }}</p>
                </div>
            </div>
        </div>



        <!-- Total Exams -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6 border border-gray-200 dark:border-gray-700">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-orange-100 dark:bg-orange-900">
                    <svg class="w-6 h-6 text-orange-600 dark:text-orange-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Total Exams</p>
                    <p class="text-2xl font-semibold text-gray-900 dark:text-white" data-stat="total_exams">{{ $stats['total_exams'] }}</p>
                </div>
            </div>
        </div>

        <!-- Total Students -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6 border border-gray-200 dark:border-gray-700">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-purple-100 dark:bg-purple-900">
                    <svg class="w-6 h-6 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Total Students</p>
                    <p class="text-2xl font-semibold text-gray-900 dark:text-white" data-stat="total_students">{{ $stats['total_students'] }}</p>
                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">From Database</p>
                </div>
            </div>
        </div>

        <!-- Total Course Offer -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6 border border-gray-200 dark:border-gray-700">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-green-100 dark:bg-green-900">
                    <svg class="w-6 h-6 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 5.477 5.754 5 7.5 5c1.747 0 3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.523 18.246 19 16.5 19c-1.746 0-3.332-.477-4.5-1.253"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Total Course Offer</p>
                    <p class="text-2xl font-semibold text-gray-900 dark:text-white" data-stat="total_courses">{{ $stats['total_courses'] }}</p>
                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Available Courses</p>
                </div>
            </div>
        </div>

        <!-- Total Batch -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6 border border-gray-200 dark:border-gray-700">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-indigo-100 dark:bg-indigo-900">
                    <svg class="w-6 h-6 text-indigo-600 dark:text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Total Batch</p>
                    <p class="text-2xl font-semibold text-gray-900 dark:text-white" data-stat="total_batches">{{ $stats['total_batches'] }}</p>
                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Active Batches</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Demo Data Seeding -->
    @if($stats['total_students'] == 0)
    <div class="bg-gradient-to-r from-blue-50 to-indigo-50 dark:from-blue-900/20 dark:to-indigo-900/20 border border-blue-200 dark:border-blue-700 rounded-lg p-6">
        <div class="flex items-center justify-between">
            <div>
                <h3 class="text-lg font-semibold text-blue-900 dark:text-blue-100">Get Started with Demo Data</h3>
                <p class="text-blue-700 dark:text-blue-300 mt-1">No students found yet. Click the button below to create demo students for testing.</p>
            </div>
            <div class="flex space-x-3">
                <button id="seedDemoStudentsBtn" 
                        class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg transition-colors duration-200 flex items-center space-x-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                    <span>Create Demo Students</span>
                </button>
                
                <button id="debugStudentCountBtn" 
                        class="bg-yellow-600 hover:bg-yellow-700 text-white px-6 py-3 rounded-lg transition-colors duration-200 flex items-center space-x-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <span>Debug Student Count</span>
                </button>
            </div>
        </div>
        <div id="seedingStatus" class="mt-4 hidden">
            <div class="flex items-center space-x-2 text-blue-700 dark:text-blue-300">
                <svg class="animate-spin w-5 h-5" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                <span id="seedingMessage">Creating demo students...</span>
            </div>
        </div>
    </div>
    @endif

    <!-- Recent Activities -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Recent Exams -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md border border-gray-200 dark:border-gray-700">
            <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Recent Exams</h3>
            </div>
            <div class="p-6">
                @if($recent_exams->count() > 0)
                    <div class="space-y-4">
                        @foreach($recent_exams as $exam)
                            <div class="flex items-center justify-between p-4 bg-gray-50 dark:bg-gray-700 rounded-lg">
                                <div>
                                    <h4 class="font-medium text-gray-900 dark:text-white">{{ $exam->title }}</h4>
                                    <p class="text-sm text-gray-600 dark:text-gray-400">
                                        Exam ID: {{ $exam->id }} • {{ $exam->status }}
                                    </p>
                                </div>
                                <div class="text-right">
                                    <p class="text-sm text-gray-600 dark:text-gray-400">
                                        {{ $exam->start_time->format('M d, Y') }}
                                    </p>
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                        @if($exam->status === 'published') bg-green-100 text-green-800
                                        @elseif($exam->status === 'draft') bg-gray-100 text-gray-800
                                        @else bg-yellow-100 text-yellow-800 @endif">
                                        {{ ucfirst($exam->status) }}
                                    </span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-gray-500 dark:text-gray-400 text-center py-4">No recent exams</p>
                @endif
            </div>
        </div>

        <!-- Recent Results -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md border border-gray-200 dark:border-gray-700">
            <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Recent Results</h3>
            </div>
            <div class="p-6">
                @if($recent_results->count() > 0)
                    <div class="space-y-4">
                        @foreach($recent_results as $result)
                            <div class="flex items-center justify-between p-4 bg-gray-50 dark:bg-gray-700 rounded-lg">
                                <div>
                                    <h4 class="font-medium text-gray-900 dark:text-white">{{ $result->student->full_name }}</h4>
                                    <p class="text-sm text-gray-600 dark:text-gray-400">{{ $result->exam->title }}</p>
                                </div>
                                <div class="text-right">
                                    <p class="text-lg font-semibold text-gray-900 dark:text-white">
                                        {{ number_format($result->percentage, 1) }}%
                                    </p>
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                        @if($result->percentage >= 80) bg-green-100 text-green-800
                                        @elseif($result->percentage >= 60) bg-yellow-100 text-yellow-800
                                        @else bg-red-100 text-red-800 @endif">
                                        {{ $result->grade }}
                                    </span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-gray-500 dark:text-gray-400 text-center py-4">No recent results</p>
                @endif
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md border border-gray-200 dark:border-gray-700">
        <div class="p-6 border-b border-gray-200 dark:border-gray-700">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Quick Actions</h3>
        </div>
        <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                <a href="{{ route('partner.questions.mcq.create') }}" 
                   class="flex items-center p-4 bg-blue-50 dark:bg-blue-900/20 rounded-lg hover:bg-blue-100 dark:hover:bg-blue-900/30 transition-colors duration-200">
                    <svg class="w-8 h-8 text-blue-600 dark:text-blue-400 mr-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                    <div>
                        <h4 class="font-medium text-gray-900 dark:text-white">Add Question</h4>
                        <p class="text-sm text-gray-600 dark:text-gray-400">Create new MCQ question</p>
                    </div>
                </a>



                <a href="{{ route('partner.exams.create') }}" 
                   class="flex items-center p-4 bg-orange-50 dark:bg-orange-900/20 rounded-lg hover:bg-orange-100 dark:hover:bg-orange-900/30 transition-colors duration-200">
                    <svg class="w-8 h-8 text-orange-600 dark:text-orange-400 mr-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                    </svg>
                    <div>
                        <h4 class="font-medium text-gray-900 dark:text-white">Schedule Exam</h4>
                        <p class="text-sm text-gray-600 dark:text-gray-400">Create new exam</p>
                    </div>
                </a>

                <a href="#" 
                   class="flex items-center p-4 bg-indigo-50 dark:bg-indigo-900/20 rounded-lg hover:bg-indigo-100 dark:hover:bg-indigo-900/30 transition-colors duration-200">
                    <svg class="w-8 h-8 text-indigo-600 dark:text-indigo-400 mr-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                    </svg>
                    <div>
                        <h4 class="font-medium text-gray-900 dark:text-white">Typing Test</h4>
                        <p class="text-sm text-gray-600 dark:text-gray-400">Create typing assessment</p>
                    </div>
                </a>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const seedBtn = document.getElementById('seedDemoStudentsBtn');
    const seedingStatus = document.getElementById('seedingStatus');
    const seedingMessage = document.getElementById('seedingMessage');
    const refreshStatsBtn = document.getElementById('refreshStatsBtn');
    const debugStudentCountBtn = document.getElementById('debugStudentCountBtn');
    
    if (seedBtn) {
        seedBtn.addEventListener('click', async function() {
            try {
                // Show loading state
                seedBtn.disabled = true;
                seedBtn.innerHTML = `
                    <svg class="animate-spin w-5 h-5" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    <span>Creating...</span>
                `;
                
                seedingStatus.classList.remove('hidden');
                seedingMessage.textContent = 'Creating demo students...';
                
                // Make API call
                const response = await fetch('{{ route("partner.seed-demo-students") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                });
                
                const result = await response.json();
                
                if (result.success) {
                    seedingMessage.textContent = result.message;
                    seedBtn.innerHTML = `
                        <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        <span>Success!</span>
                    `;
                    seedBtn.classList.remove('bg-blue-600', 'hover:bg-blue-700');
                    seedBtn.classList.add('bg-green-600', 'hover:bg-green-700');
                    
                    // Reload page after 2 seconds to show updated stats
                    setTimeout(() => {
                        window.location.reload();
                    }, 2000);
                } else {
                    throw new Error(result.message);
                }
                
            } catch (error) {
                console.error('Error seeding demo students:', error);
                seedingMessage.textContent = 'Error: ' + error.message;
                seedBtn.innerHTML = `
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                    <span>Try Again</span>
                `;
                seedBtn.disabled = false;
            }
        });
    }
    
    // Handle debug student count button
    if (debugStudentCountBtn) {
        debugStudentCountBtn.addEventListener('click', async function() {
            try {
                // Show loading state
                debugStudentCountBtn.disabled = true;
                debugStudentCountBtn.innerHTML = `
                    <svg class="animate-spin w-5 h-5" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    <span>Checking...</span>
                `;
                
                // Make API call to get student count details
                const response = await fetch('{{ route("partner.student-count") }}', {
                    method: 'GET',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                });
                
                const result = await response.json();
                
                if (result.success) {
                    // Show debug information in console and alert
                    console.log('Debug Student Count:', result);
                    
                    let debugMessage = `Partner ID: ${result.partner_id}\n`;
                    debugMessage += `Total Students: ${result.total_students}\n`;
                    debugMessage += `Students with Exams: ${result.students_with_exams}\n`;
                    debugMessage += `All Students: ${result.all_students.length}\n\n`;
                    
                    if (result.all_students.length > 0) {
                        debugMessage += 'Student Details:\n';
                        result.all_students.forEach((student, index) => {
                            debugMessage += `${index + 1}. ${student.full_name} (${student.student_id}) - Status: ${student.status}\n`;
                        });
                    }
                    
                    alert(debugMessage);
                    
                    // Update the stats on the page
                    const totalStudentsElement = document.querySelector('[data-stat="total_students"]');
                    if (totalStudentsElement) {
                        totalStudentsElement.textContent = result.total_students;
                    }
                    
                    // Show success message
                    debugStudentCountBtn.innerHTML = `
                        <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        <span>Checked!</span>
                    `;
                    debugStudentCountBtn.classList.remove('bg-yellow-600', 'hover:bg-yellow-700');
                    debugStudentCountBtn.classList.add('bg-green-600', 'hover:bg-green-700');
                    
                    // Reset button after 2 seconds
                    setTimeout(() => {
                        debugStudentCountBtn.innerHTML = `
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <span>Debug Student Count</span>
                        `;
                        debugStudentCountBtn.classList.remove('bg-green-600', 'hover:bg-green-700');
                        debugStudentCountBtn.classList.add('bg-yellow-600', 'hover:bg-yellow-700');
                        debugStudentCountBtn.disabled = false;
                    }, 2000);
                } else {
                    throw new Error(result.message);
                }
                
            } catch (error) {
                console.error('Error debugging student count:', error);
                debugStudentCountBtn.innerHTML = `
                    <svg class="w-5 h-5 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                    <span>Error</span>
                `;
                debugStudentCountBtn.classList.remove('bg-yellow-600', 'hover:bg-yellow-700');
                debugStudentCountBtn.classList.add('bg-red-600', 'hover:bg-red-700');
                
                // Reset button after 3 seconds
                setTimeout(() => {
                    debugStudentCountBtn.innerHTML = `
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                        <span>Debug Student Count</span>
                    `;
                    debugStudentCountBtn.classList.remove('bg-red-600', 'hover:bg-red-700');
                    debugStudentCountBtn.classList.add('bg-yellow-600', 'hover:bg-yellow-700');
                    debugStudentCountBtn.disabled = false;
                }, 3000);
            }
        });
    }
    
    // Handle refresh stats button
    if (refreshStatsBtn) {
        refreshStatsBtn.addEventListener('click', async function() {
            try {
                // Show loading state
                refreshStatsBtn.disabled = true;
                refreshStatsBtn.innerHTML = `
                    <svg class="animate-spin w-4 h-4" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    <span>Refreshing...</span>
                `;
                
                // Make API call to refresh stats
                const response = await fetch('{{ route("partner.refresh-stats") }}', {
                    method: 'GET',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                });
                
                const result = await response.json();
                
                if (result.success) {
                    // Update the stats on the page
                    const totalQuestionsElement = document.querySelector('[data-stat="total_questions"]');
                    const totalExamsElement = document.querySelector('[data-stat="total_exams"]');
                    const totalStudentsElement = document.querySelector('[data-stat="total_students"]');
                    const totalCoursesElement = document.querySelector('[data-stat="total_courses"]');
                    const totalBatchesElement = document.querySelector('[data-stat="total_batches"]');
                    
                    if (totalQuestionsElement) totalQuestionsElement.textContent = result.stats.total_questions;
                    if (totalExamsElement) totalExamsElement.textContent = result.stats.total_exams;
                    if (totalStudentsElement) totalStudentsElement.textContent = result.stats.total_students;
                    if (totalCoursesElement) totalCoursesElement.textContent = result.stats.total_courses;
                    if (totalBatchesElement) totalBatchesElement.textContent = result.stats.total_batches;
                    
                    // Show success message
                    refreshStatsBtn.innerHTML = `
                        <svg class="w-4 h-4 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        <span>Refreshed!</span>
                    `;
                    refreshStatsBtn.classList.remove('bg-gray-600', 'hover:bg-gray-700');
                    refreshStatsBtn.classList.add('bg-green-600', 'hover:bg-green-700');
                    
                    // Reset button after 2 seconds
                    setTimeout(() => {
                        refreshStatsBtn.innerHTML = `
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                            </svg>
                            <span>Refresh Stats</span>
                        `;
                        refreshStatsBtn.classList.remove('bg-green-600', 'hover:bg-green-700');
                        refreshStatsBtn.classList.add('bg-gray-600', 'hover:bg-gray-700');
                        refreshStatsBtn.disabled = false;
                    }, 2000);
                } else {
                    throw new Error(result.message);
                }
                
            } catch (error) {
                console.error('Error refreshing stats:', error);
                refreshStatsBtn.innerHTML = `
                    <svg class="w-4 h-4 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                    <span>Error</span>
                `;
                refreshStatsBtn.classList.remove('bg-gray-600', 'hover:bg-gray-700');
                refreshStatsBtn.classList.add('bg-red-600', 'hover:bg-red-700');
                
                // Reset button after 3 seconds
                setTimeout(() => {
                    refreshStatsBtn.innerHTML = `
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                    </svg>
                        <span>Refresh Stats</span>
                    `;
                    refreshStatsBtn.classList.remove('bg-red-600', 'hover:bg-red-700');
                    refreshStatsBtn.classList.add('bg-gray-600', 'hover:bg-gray-700');
                    refreshStatsBtn.disabled = false;
                }, 3000);
            }
        });
    }
});
</script>
@endpush

@endsection 
