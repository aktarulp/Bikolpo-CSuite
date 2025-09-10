@extends('layouts.partner-layout')

@section('title', 'Question History Details')

@section('content')
<div class="py-12">
    <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900">
                <!-- Header -->
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-2xl font-bold text-gray-900">Question History Details</h2>
                    <div class="flex space-x-3">
                        <a href="{{ route('partner.question-history.edit', $questionHistory) }}" 
                           class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded">
                            Edit Record
                        </a>
                        <a href="{{ route('partner.question-history.index') }}" 
                           class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded">
                            Back to List
                        </a>
                    </div>
                </div>

                <!-- Status Badge -->
                <div class="mb-6">
                    @if($questionHistory->is_verified)
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                            <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                            </svg>
                            Verified
                        </span>
                    @else
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-yellow-100 text-yellow-800">
                            <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                            </svg>
                            Unverified
                        </span>
                    @endif
                </div>

                <!-- Main Content -->
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                    <!-- Question Information -->
                    <div class="space-y-6">
                        <div class="bg-gray-50 p-6 rounded-lg">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">Question Information</h3>
                            
                            <div class="space-y-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Question ID</label>
                                    <p class="mt-1 text-sm text-gray-900">{{ $questionHistory->question_id }}</p>
                                </div>
                                
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Question Text</label>
                                    <div class="mt-1 p-3 bg-white border border-gray-200 rounded-md">
                                        <p class="text-sm text-gray-900">{{ $questionHistory->question->question_text ?? 'Question not found' }}</p>
                                    </div>
                                </div>
                                
                                @if($questionHistory->question)
                                    <div class="grid grid-cols-2 gap-4">
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700">Subject</label>
                                            <p class="mt-1 text-sm text-gray-900">{{ $questionHistory->question->subject?->name ?? 'N/A' }}</p>
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700">Topic</label>
                                            <p class="mt-1 text-sm text-gray-900">{{ $questionHistory->question->topic?->name ?? 'N/A' }}</p>
                                        </div>
                                    </div>
                                    
                                    <div class="grid grid-cols-2 gap-4">
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700">Question Type</label>
                                            <p class="mt-1 text-sm text-gray-900">{{ $questionHistory->question->questionType?->name ?? 'N/A' }}</p>
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700">Status</label>
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                                {{ $questionHistory->question->status === 'active' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                                {{ ucfirst($questionHistory->question->status ?? 'Unknown') }}
                                            </span>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <!-- Partner Information -->
                        <div class="bg-blue-50 p-6 rounded-lg">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">Partner Information</h3>
                            
                            <div class="space-y-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Partner ID</label>
                                    <p class="mt-1 text-sm text-gray-900">{{ $questionHistory->partner_id }}</p>
                                </div>
                                
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Partner Name</label>
                                    <p class="mt-1 text-sm text-gray-900">{{ $questionHistory->partner->name ?? $questionHistory->partner->email ?? 'N/A' }}</p>
                                </div>
                                
                                @if($questionHistory->partner)
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Email</label>
                                        <p class="mt-1 text-sm text-gray-900">{{ $questionHistory->partner->email ?? 'N/A' }}</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Exam Information -->
                    <div class="space-y-6">
                        <div class="bg-green-50 p-6 rounded-lg">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">Exam Details</h3>
                            
                            <div class="space-y-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Public Exam Name</label>
                                    <p class="mt-1 text-sm text-gray-900">{{ $questionHistory->public_exam_name }}</p>
                                </div>
                                
                                @if($questionHistory->private_exam_name)
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Private Exam Name</label>
                                        <p class="mt-1 text-sm text-gray-900">{{ $questionHistory->private_exam_name }}</p>
                                    </div>
                                @endif
                                
                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Exam Month</label>
                                        <p class="mt-1 text-sm text-gray-900">{{ $questionHistory->exam_month }}</p>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Exam Year</label>
                                        <p class="mt-1 text-sm text-gray-900">{{ $questionHistory->exam_year }}</p>
                                    </div>
                                </div>
                                
                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Exam Board</label>
                                        <p class="mt-1 text-sm text-gray-900">{{ $questionHistory->exam_board ?? 'N/A' }}</p>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Exam Type</label>
                                        <p class="mt-1 text-sm text-gray-900">{{ $questionHistory->exam_type ?? 'N/A' }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Question Details -->
                        <div class="bg-purple-50 p-6 rounded-lg">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">Question Details</h3>
                            
                            <div class="space-y-4">
                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Question Number</label>
                                        <p class="mt-1 text-sm text-gray-900">{{ $questionHistory->question_number ?? 'N/A' }}</p>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Marks Allocated</label>
                                        <p class="mt-1 text-sm text-gray-900">{{ $questionHistory->marks_allocated ?? 'N/A' }}</p>
                                    </div>
                                </div>
                                
                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Subject Name</label>
                                        <p class="mt-1 text-sm text-gray-900">{{ $questionHistory->subject_name ?? 'N/A' }}</p>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Topic Name</label>
                                        <p class="mt-1 text-sm text-gray-900">{{ $questionHistory->topic_name ?? 'N/A' }}</p>
                                    </div>
                                </div>
                                
                                @if($questionHistory->source_reference)
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Source Reference</label>
                                        <p class="mt-1 text-sm text-gray-900">{{ $questionHistory->source_reference }}</p>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <!-- Verification Details -->
                        @if($questionHistory->is_verified)
                            <div class="bg-green-50 p-6 rounded-lg">
                                <h3 class="text-lg font-semibold text-gray-900 mb-4">Verification Details</h3>
                                
                                <div class="space-y-4">
                                    @if($questionHistory->verified_by)
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700">Verified By</label>
                                            <p class="mt-1 text-sm text-gray-900">{{ $questionHistory->verified_by }}</p>
                                        </div>
                                    @endif
                                    
                                    @if($questionHistory->verified_at)
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700">Verified At</label>
                                            <p class="mt-1 text-sm text-gray-900">{{ $questionHistory->verified_at->format('M d, Y \a\t g:i A') }}</p>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @endif

                        <!-- Remarks -->
                        @if($questionHistory->remarks)
                            <div class="bg-gray-50 p-6 rounded-lg">
                                <h3 class="text-lg font-semibold text-gray-900 mb-4">Remarks</h3>
                                <p class="text-sm text-gray-900">{{ $questionHistory->remarks }}</p>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Record Metadata -->
                <div class="mt-8 pt-6 border-t border-gray-200">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-sm text-gray-500">
                        <div>
                            <span class="font-medium">Created:</span> {{ $questionHistory->created_at->format('M d, Y \a\t g:i A') }}
                        </div>
                        <div>
                            <span class="font-medium">Updated:</span> {{ $questionHistory->updated_at->format('M d, Y \a\t g:i A') }}
                        </div>
                        <div>
                            <span class="font-medium">Record ID:</span> {{ $questionHistory->record_id }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
