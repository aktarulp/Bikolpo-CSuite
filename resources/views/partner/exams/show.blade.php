@extends('layouts.partner-layout')

@section('title', 'Exam Details')

@section('content')
<div class="min-h-screen bg-gray-50 dark:bg-gray-900 py-6">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-6">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900 dark:text-white">{{ $exam->title }}</h1>
                    <p class="mt-2 text-gray-600 dark:text-gray-400">Exam ID: #{{ $exam->id }}</p>
                </div>
                <div class="flex space-x-3">
                    <a href="{{ route('partner.exams.edit', $exam) }}" 
                       class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:bg-gray-800 dark:border-gray-600 dark:text-gray-300 dark:hover:bg-gray-700">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                        </svg>
                        Edit Exam
                    </a>
                    <a href="{{ route('partner.exams.index') }}" 
                       class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:bg-gray-800 dark:border-gray-600 dark:text-gray-300 dark:hover:bg-gray-700">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                        Back to Exams
                    </a>
                </div>
            </div>
        </div>

        <!-- Exam Information Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Main Exam Details -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Basic Information -->
                <div class="bg-white dark:bg-gray-800 shadow-lg rounded-lg overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                        <h2 class="text-lg font-semibold text-gray-900 dark:text-white">Basic Information</h2>
                    </div>
                    <div class="px-6 py-4">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">Exam Title</label>
                                <p class="mt-1 text-sm text-gray-900 dark:text-white">{{ $exam->title }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">Exam Type</label>
                                <span class="mt-1 inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                    {{ $exam->exam_type === 'online' ? 'bg-green-100 text-green-800' : 'bg-orange-100 text-orange-800' }}">
                                    {{ ucfirst($exam->exam_type) }}
                                </span>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">Status</label>
                                <span class="mt-1 inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                    @if($exam->status === 'published') bg-green-100 text-green-800
                                    @elseif($exam->status === 'draft') bg-gray-100 text-gray-800
                                    @elseif($exam->status === 'ongoing') bg-blue-100 text-blue-800
                                    @elseif($exam->status === 'completed') bg-purple-100 text-purple-800
                                    @else bg-red-100 text-red-800 @endif">
                                    {{ ucfirst($exam->status) }}
                                </span>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">Created</label>
                                <p class="mt-1 text-sm text-gray-900 dark:text-white">{{ $exam->created_at->format('M d, Y H:i') }}</p>
                            </div>
                        </div>
                        @if($exam->description)
                        <div class="mt-4">
                            <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">Description</label>
                            <p class="mt-1 text-sm text-gray-900 dark:text-white">{{ $exam->description }}</p>
                        </div>
                        @endif
                    </div>
                </div>

                <!-- Exam Schedule -->
                <div class="bg-white dark:bg-gray-800 shadow-lg rounded-lg overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                        <h2 class="text-lg font-semibold text-gray-900 dark:text-white">Exam Schedule</h2>
                    </div>
                    <div class="px-6 py-4">
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">Start Time</label>
                                <p class="mt-1 text-sm text-gray-900 dark:text-white">{{ $exam->start_time->format('M d, Y H:i') }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">End Time</label>
                                <p class="mt-1 text-sm text-gray-900 dark:text-white">{{ $exam->end_time->format('M d, Y H:i') }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">Duration</label>
                                <p class="mt-1 text-sm text-gray-900 dark:text-white">{{ $exam->duration }} minutes</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Exam Configuration -->
                <div class="bg-white dark:bg-gray-800 shadow-lg rounded-lg overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                        <h2 class="text-lg font-semibold text-gray-900 dark:text-white">Exam Configuration</h2>
                    </div>
                    <div class="px-6 py-4">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">Total Questions</label>
                                <p class="mt-1 text-sm text-gray-900 dark:text-white">{{ $exam->total_questions }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">Passing Marks</label>
                                <p class="mt-1 text-sm text-gray-900 dark:text-white">{{ $exam->passing_marks }}%</p>
                            </div>
                            @if($exam->question_head)
                            <div class="md:col-span-2">
                                <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">Question Head</label>
                                <p class="mt-1 text-sm text-gray-900 dark:text-white">{{ $exam->question_head }}</p>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="space-y-6">
                <!-- Quick Actions -->
                <div class="bg-white dark:bg-gray-800 shadow-lg rounded-lg overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Quick Actions</h3>
                    </div>
                    <div class="px-6 py-4 space-y-3">
                        <a href="{{ route('partner.exams.assign-questions', $exam) }}" 
                           class="w-full flex items-center px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-md transition-colors duration-200">
                            <svg class="w-4 h-4 mr-3 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                            Assign Questions
                        </a>
                        <a href="{{ route('partner.exams.assign', $exam) }}" 
                           class="w-full flex items-center px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-md transition-colors duration-200">
                            <svg class="w-4 h-4 mr-3 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                            </svg>
                            Assign Students
                        </a>
                        <a href="{{ route('partner.exams.results', $exam) }}" 
                           class="w-full flex items-center px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-md transition-colors duration-200">
                            <svg class="w-4 h-4 mr-3 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                            </svg>
                            View Results
                        </a>
                        <a href="{{ route('partner.exams.export', $exam) }}" 
                           class="w-full flex items-center px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-md transition-colors duration-200">
                            <svg class="w-4 h-4 mr-3 text-teal-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                            Export Data
                        </a>
                    </div>
                </div>

                <!-- Exam Options -->
                <div class="bg-white dark:bg-gray-800 shadow-lg rounded-lg overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Exam Options</h3>
                    </div>
                    <div class="px-6 py-4 space-y-3">
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-gray-600 dark:text-gray-400">Allow Retake</span>
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                {{ $exam->allow_retake ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                {{ $exam->allow_retake ? 'Yes' : 'No' }}
                            </span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-gray-600 dark:text-gray-400">Show Results Immediately</span>
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                {{ $exam->show_results_immediately ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                {{ $exam->show_results_immediately ? 'Yes' : 'No' }}
                            </span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-gray-600 dark:text-gray-400">Negative Marking</span>
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                {{ $exam->has_negative_marking ? 'bg-red-100 text-red-800' : 'bg-gray-100 text-gray-800' }}">
                                {{ $exam->has_negative_marking ? 'Yes' : 'No' }}
                            </span>
                        </div>
                        @if($exam->has_negative_marking)
                        <div class="text-sm text-gray-600 dark:text-gray-400">
                            <span class="font-medium">Negative Marks:</span> {{ $exam->negative_marks_per_question }} per wrong answer
                        </div>
                        @endif
                    </div>
                </div>

                <!-- Status Actions -->
                @if($exam->status === 'draft')
                <div class="bg-white dark:bg-gray-800 shadow-lg rounded-lg overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Publish Exam</h3>
                    </div>
                    <div class="px-6 py-4">
                        <form action="{{ route('partner.exams.publish', $exam) }}" method="POST">
                            @csrf
                            <button type="submit" 
                                    class="w-full px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-colors duration-200">
                                Publish Exam
                            </button>
                        </form>
                    </div>
                </div>
                @elseif($exam->status === 'published')
                <div class="bg-white dark:bg-gray-800 shadow-lg rounded-lg overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Unpublish Exam</h3>
                    </div>
                    <div class="px-6 py-4">
                        <form action="{{ route('partner.exams.unpublish', $exam) }}" method="POST">
                            @csrf
                            <button type="submit" 
                                    class="w-full px-4 py-2 bg-yellow-600 text-white rounded-md hover:bg-yellow-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-500 transition-colors duration-200">
                                Unpublish Exam
                            </button>
                        </form>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
