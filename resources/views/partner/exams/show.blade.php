@extends('layouts.partner-layout')

@section('title', 'Exam Details')

@section('content')
<div class="min-h-screen bg-gray-50 dark:bg-gray-900 py-0">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
                          <!-- Header -->
         <div class="mb-1">
             <div class="flex items-center justify-between">

                 <div class="flex space-x-3">
                     <!-- Header actions can be added here if needed in the future -->
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
                         <div class="flex items-center justify-between flex-wrap gap-3">
                             <div class="flex items-center space-x-3">
                                 <span class="inline-flex items-center px-3 py-1.5 rounded-lg text-sm font-bold bg-gradient-to-r from-blue-500 to-indigo-600 text-white shadow-lg ring-2 ring-blue-200 dark:ring-blue-800/50 transform hover:scale-105 transition-all duration-200">
                                     #{{ $exam->id }}
                                 </span>
                                 <h2 class="text-lg font-semibold text-gray-900 dark:text-white">{{ $exam->title }}</h2>
                             </div>
                             <a href="{{ route('partner.exams.index') }}" 
                                class="inline-flex items-center px-4 py-2 text-sm font-medium rounded-md text-white bg-orange-600 hover:bg-orange-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500 transition-all duration-200 shadow-lg whitespace-nowrap border border-orange-600"
                                style="background-color: #ea580c; color: white; text-decoration: none;">
                                 <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="color: white;">
                                     <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                                 </svg>
                                 <span style="color: white; font-weight: 500;">Back to Exams</span>
                             </a>
                         </div>
                     </div>
                                                              <div class="px-4 py-3">
                         <!-- Exam Details Grid -->
                         <div class="mt-3">
                             <div class="grid grid-cols-2 md:grid-cols-5 gap-4">
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
                                     <div class="text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">Exam Type</div>
                                     <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                         {{ $exam->exam_type === 'online' ? 'bg-green-100 text-green-800' : 'bg-orange-100 text-orange-800' }}">
                                         {{ ucfirst($exam->exam_type) }}
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
                                     <div class="text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">Language</div>
                                     <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                         {{ $exam->question_language === 'bangla' ? 'bg-blue-100 text-blue-800' : 'bg-gray-100 text-gray-800' }}">
                                         {{ $exam->question_language === 'bangla' ? '🇧🇩 Bangla' : '🇺🇸 English' }}
                                     </span>
                                 </div>
                             </div>
                         </div>
                         
                         <!-- Schedule Section -->
                         <div class="mt-6 pt-4 border-t border-gray-200 dark:border-gray-700">
                             <label class="block text-sm font-medium text-gray-500 dark:text-gray-400 mb-3">Schedule</label>
                             <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                 <div class="flex items-center space-x-2">
                                     <svg class="w-4 h-4 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                         <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                     </svg>
                                     <span class="text-sm text-gray-900 dark:text-white">
                                         <span class="font-medium">Start:</span> {{ $exam->start_time->format('M d, Y H:i') }}
                                     </span>
                                 </div>
                                 <div class="flex items-center justify-between">
                                     <div class="flex items-center space-x-2">
                                         <svg class="w-4 h-4 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                             <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                         </svg>
                                         <span class="text-sm text-gray-900 dark:text-white">
                                             <span class="font-medium">End:</span> {{ $exam->end_time->format('M d, Y H:i') }}
                                         </span>
                                     </div>
                                     <div class="flex items-center space-x-2">
                                         <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                             <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                         </svg>
                                         <span class="text-sm text-gray-900 dark:text-white">
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
                     </div>
                                 </div>
                                 
                                                                 <!-- Students Assigned Section -->
                                <div class="bg-white dark:bg-gray-800 shadow-lg rounded-lg overflow-hidden">
                                    <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Students Assigned</h3>
                                    </div>
                                    <div class="px-6 py-4">
                                        @if($exam->accessCodes->count() > 0)
                                            <!-- Compact horizontal layout for students -->
                                            <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4">
                                                <div class="flex flex-wrap gap-3 items-center">
                                                    @foreach($exam->accessCodes as $accessCode)
                                                        <div class="flex items-center space-x-2 bg-white dark:bg-gray-600 rounded-lg px-3 py-2 shadow-sm border border-gray-200 dark:border-gray-500">
                                                            <!-- Student Avatar -->
                                                            <span class="inline-flex items-center justify-center w-6 h-6 bg-green-100 text-green-800 text-xs font-medium rounded-full">
                                                                {{ strtoupper(substr($accessCode->student->full_name ?? 'S', 0, 1)) }}
                                                            </span>
                                                            
                                                            <!-- Student Info -->
                                                            <div class="flex flex-col min-w-0">
                                                                <span class="text-xs font-medium text-gray-900 dark:text-white truncate max-w-24" title="{{ $accessCode->student->full_name ?? 'Unknown Student' }}">
                                                                    {{ $accessCode->student->full_name ?? 'Unknown' }}
                                                                </span>
                                                                <span class="text-xs text-gray-500 dark:text-gray-400 truncate max-w-20" title="{{ $accessCode->student->phone ?? 'No phone number' }}">
                                                                    {{ $accessCode->student->phone ?? 'No phone' }}
                                                                </span>
                                                            </div>
                                                            
                                                            <!-- Access Code -->
                                                            <div class="flex flex-col items-center">
                                                                <span class="text-xs font-mono text-gray-900 dark:text-white bg-gray-100 dark:bg-gray-500 px-2 py-1 rounded text-center min-w-16" title="{{ $accessCode->access_code ?? 'No code' }}">
                                                                    {{ $accessCode->access_code ?? 'No code' }}
                                                                </span>
                                                                @if($accessCode->status === 'active')
                                                                    <span class="inline-flex items-center px-1.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800 mt-1">
                                                                        Waiting
                                                                    </span>
                                                                @elseif($accessCode->status === 'used')
                                                                    <span class="inline-flex items-center px-1.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 mt-1">
                                                                        Submitted
                                                                    </span>
                                                                @else
                                                                    <span class="inline-flex items-center px-1.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800 mt-1">
                                                                        {{ ucfirst($accessCode->status ?? 'Unknown') }}
                                                                    </span>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                            
                                            <!-- Summary Stats -->
                                            <div class="mt-4 text-sm text-gray-600 dark:text-gray-400">
                                                <span class="font-medium">Total Students:</span> {{ $exam->accessCodes->count() }} | 
                                                <span class="font-medium">Waiting:</span> {{ $exam->accessCodes->where('status', 'active')->count() }} | 
                                                <span class="font-medium">Submitted:</span> {{ $exam->accessCodes->where('status', 'used')->count() }}
                                            </div>
                                        @else
                                            <div class="text-center py-8">
                                                <div class="mx-auto h-16 w-16 bg-gray-100 dark:bg-gray-700 rounded-full flex items-center justify-center mb-4">
                                                    <svg class="h-8 w-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                                                    </svg>
                                                </div>
                                                <h4 class="text-lg font-medium text-gray-900 dark:text-white mb-2">No Students Assigned</h4>
                                                <p class="text-gray-500 dark:text-gray-400 mb-4">This exam doesn't have any students assigned yet.</p>
                                                <a href="{{ route('partner.exams.assign', $exam) }}" 
                                                   class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                                                    </svg>
                                                    Assign Students
                                                </a>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                 
                                 <!-- Questions Assigned Section -->
                                 <div class="bg-white dark:bg-gray-800 shadow-lg rounded-lg overflow-hidden">
                                     <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                                         <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Questions Assigned</h3>
                                     </div>
                                     <div class="px-6 py-4">
                                         @if($exam->questions->count() > 0)
                                             <div class="space-y-2">
                                                 @foreach($exam->questions as $question)
                                                     <div class="flex items-center justify-between py-2 px-3 bg-gray-50 dark:bg-gray-700 rounded-lg">
                                                         <div class="flex items-center space-x-3">
                                                             <span class="inline-flex items-center justify-center w-6 h-6 bg-blue-100 text-blue-800 text-xs font-medium rounded-full">
                                                                 {{ $loop->iteration }}
                                                             </span>
                                                             <span class="text-sm text-gray-900 dark:text-white font-medium">
                                                                 {{ Str::limit($question->question_text, 80) }}
                                                             </span>
                                                         </div>
                                                         <div class="flex items-center space-x-4">
                                                             <span class="text-xs text-gray-500 dark:text-gray-400">
                                                                 {{ ucfirst($question->question_type) }}
                                                             </span>
                                                             <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                                 {{ $question->pivot->marks ?? 1 }} marks
                                                             </span>
                                                         </div>
                                                     </div>
                                                 @endforeach
                                             </div>
                                             <div class="mt-4 text-sm text-gray-600 dark:text-gray-400">
                                                 <span class="font-medium">Total Questions:</span> {{ $exam->questions->count() }} | 
                                                 <span class="font-medium">Total Marks:</span> {{ $exam->questions->sum('pivot.marks') ?? $exam->questions->count() }}
                                             </div>
                                         @else
                                             <div class="text-center py-8">
                                                 <div class="mx-auto h-16 w-16 bg-gray-100 dark:bg-gray-700 rounded-full flex items-center justify-center mb-4">
                                                     <svg class="h-8 w-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                         <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                                     </svg>
                                                 </div>
                                                 <h4 class="text-lg font-medium text-gray-900 dark:text-white mb-2">No Questions Assigned</h4>
                                                 <p class="text-gray-500 dark:text-gray-400 mb-4">This exam doesn't have any questions assigned yet.</p>
                                                 <a href="{{ route('partner.exams.assign-questions', $exam) }}" 
                                                    class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                                     <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                         <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                                     </svg>
                                                     Assign Questions
                                                 </a>
                                             </div>
                                         @endif
                                     </div>
                                 </div>
            </div>

            <!-- Sidebar -->
            <div class="space-y-6">
                                 <!-- Quick Actions -->
                 <div class="bg-white dark:bg-gray-800 shadow-lg rounded-lg overflow-hidden">
                     <div class="px-4 py-3 border-b border-gray-200 dark:border-gray-700">
                         <div class="flex items-center justify-between">
                             <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Quick Actions</h3>
                             @if($exam->status === 'draft')
                                 @if($exam->questions->count() == $exam->total_questions)
                                     <form action="{{ route('partner.exams.publish', $exam) }}" method="POST" class="inline">
                                         @csrf
                                         <button type="submit" 
                                                 class="inline-flex items-center gap-2 px-3 py-1.5 bg-gradient-to-r from-green-500 to-emerald-600 text-white text-xs font-medium rounded-md hover:from-green-600 hover:to-emerald-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transform hover:scale-105 transition-all duration-200 shadow-md">
                                             <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                 <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M9 19l3 3m0 0l3-3m-3 3V10"></path>
                                             </svg>
                                             Publish
                                         </button>
                                     </form>
                                 @else
                                     <button type="button" 
                                             onclick="showPublishError()"
                                             class="inline-flex items-center gap-2 px-3 py-1.5 bg-gradient-to-r from-green-500 to-emerald-600 text-white text-xs font-medium rounded-md hover:from-green-600 hover:to-emerald-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transform hover:scale-105 transition-all duration-200 shadow-md">
                                         <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                             <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M9 19l3 3m0 0l3-3m-3 3V10"></path>
                                         </svg>
                                         Publish
                                     </button>
                                 @endif
                             @elseif($exam->status === 'published')
                                 <form action="{{ route('partner.exams.unpublish', $exam) }}" method="POST" class="inline">
                                     @csrf
                                     <button type="submit" 
                                             class="inline-flex items-center gap-2 px-3 py-1.5 bg-gradient-to-r from-yellow-500 to-orange-600 text-white text-xs font-medium rounded-md hover:from-yellow-600 hover:to-orange-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-500 transform hover:scale-105 transition-all duration-200 shadow-md">
                                         <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                             <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728L5.636 5.636m12.728 12.728L18.364 5.636M5.636 18.364l12.728-12.728"></path>
                                         </svg>
                                         Unpublish
                                     </button>
                                 </form>
                             @endif
                         </div>
                     </div>
                     <div class="px-4 py-3 space-y-2">
                        <a href="{{ route('partner.exams.edit', $exam) }}" 
                           class="w-full flex items-center px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-md transition-colors duration-200">
                            <svg class="w-4 h-4 mr-3 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                            </svg>
                            Edit Exam
                        </a>
                        <a href="{{ route('partner.exams.assign-questions', $exam) }}" 
                           class="quick-action-item w-full flex items-center justify-between px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-md transition-colors duration-200">
                            <div class="flex items-center">
                                <svg class="w-4 h-4 mr-3 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                                <span>Assign Questions</span>
                            </div>
                            <div class="flex items-center space-x-2">
                                <span class="question-counter inline-flex items-center px-2 py-1 rounded-full text-xs font-medium
                                    @if($exam->questions->count() == 0) bg-red-100 text-red-800 danger
                                    @elseif($exam->questions->count() < $exam->total_questions) bg-yellow-100 text-yellow-800 warning
                                    @else bg-green-100 text-green-800 complete @endif">
                                    {{ $exam->questions->count() }}/{{ $exam->total_questions }}
                                </span>
                                @if($exam->questions->count() < $exam->total_questions)
                                    <svg class="status-icon w-3 h-3 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                                    </svg>
                                @elseif($exam->questions->count() == $exam->total_questions)
                                    <svg class="status-icon w-3 h-3 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                @endif
                            </div>
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
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                            </svg>
                            View Results
                        </a>
                        <a href="{{ route('partner.exams.paper-parameters', $exam) }}" 
                           class="w-full flex items-center px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-md transition-colors duration-200">
                            <svg class="w-4 h-4 mr-3 text-teal-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 15a2 2 0 01-2 2H7l-4 4V5a2 2 0 012-2h14a2 2 0 012 2z"></path>
                            </svg>
                            Download Question Paper
                        </a>
                        <div class="border-t border-gray-200 dark:border-gray-700 my-2"></div>
                        <form action="{{ route('partner.exams.destroy', $exam) }}" method="POST" class="block">
                            @csrf @method('DELETE')
                            <button type="submit" 
                                    class="w-full flex items-center px-4 py-2 text-sm text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-900/20 rounded-md transition-colors duration-200"
                                    onclick="return confirm('Are you sure you want to delete this exam? This action cannot be undone.')">
                                <svg class="w-4 h-4 mr-3 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                </svg>
                                Delete Exam
                            </button>
                        </form>
                    </div>
                </div>

            </div>
        </div>




    </div>
</div>
@endsection

@push('styles')
<style>
/* Quick Action Panel Styling */
.quick-action-item {
    transition: all 0.3s ease;
}

.quick-action-item:hover {
    transform: translateX(2px);
}

/* Question Counter Styling */
.question-counter {
    transition: all 0.3s ease;
    animation: pulse-gentle 2s infinite;
}

.question-counter.complete {
    animation: none;
    box-shadow: 0 0 0 2px rgba(34, 197, 94, 0.2);
}

.question-counter.warning {
    animation: pulse-warning 1.5s infinite;
}

.question-counter.danger {
    animation: pulse-danger 1s infinite;
}

/* Status Icons */
.status-icon {
    transition: all 0.3s ease;
}

.quick-action-item:hover .status-icon {
    transform: scale(1.1);
}

/* Animations */
@keyframes pulse-gentle {
    0%, 100% { opacity: 1; }
    50% { opacity: 0.8; }
}

@keyframes pulse-warning {
    0%, 100% { 
        opacity: 1; 
        transform: scale(1);
    }
    50% { 
        opacity: 0.7; 
        transform: scale(1.05);
    }
}

@keyframes pulse-danger {
    0%, 100% { 
        opacity: 1; 
        transform: scale(1);
    }
    50% { 
        opacity: 0.6; 
        transform: scale(1.1);
    }
}

/* Dark mode adjustments */
.dark .question-counter.complete {
    box-shadow: 0 0 0 2px rgba(34, 197, 94, 0.3);
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .quick-action-item:hover {
        transform: none;
    }
    
    .quick-action-item:hover .status-icon {
        transform: none;
    }
}
</style>
@endpush

@push('scripts')
<script>
function showPublishError() {
    // Create modal container
    const modal = document.createElement('div');
    modal.className = 'fixed inset-0 z-50 flex items-center justify-center';
    modal.innerHTML = `
        <div class="fixed inset-0 bg-black bg-opacity-50 transition-opacity"></div>
        <div class="relative bg-white dark:bg-gray-800 rounded-lg shadow-xl max-w-md w-full mx-4 transform transition-all">
            <div class="px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                <div class="sm:flex sm:items-start">
                    <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                        <svg class="h-6 w-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                        </svg>
                    </div>
                    <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                        <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-white">
                            Cannot Publish Exam
                        </h3>
                        <div class="mt-2">
                            <p class="text-sm text-gray-500 dark:text-gray-300">
                                All questions must be assigned before publishing the exam. Please assign all {{ $exam->total_questions }} questions to this exam.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                <a href="{{ route('partner.exams.assign-questions', $exam) }}" 
                   class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-blue-600 text-base font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:ml-3 sm:w-auto sm:text-sm">
                    Assign Questions
                </a>
                <button type="button" onclick="this.closest('.fixed').remove()"
                        class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 dark:border-gray-600 shadow-sm px-4 py-2 bg-white dark:bg-gray-700 text-base font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                    Cancel
                </button>
            </div>
        </div>
    `;
    
    // Add modal to body
    document.body.appendChild(modal);
    
    // Close modal when clicking on backdrop
    modal.querySelector('.fixed.inset-0').addEventListener('click', function() {
        modal.remove();
    });
}
</script>
@endpush
