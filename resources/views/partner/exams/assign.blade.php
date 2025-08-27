@extends('layouts.partner-layout')

@section('content')
<div class="py-6">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">Student Assignment</h1>
                    <p class="text-gray-600">Assign students to {{ $exam->title }} and generate access codes</p>
                </div>
                <div class="flex items-center space-x-3">
                    <a href="{{ route('partner.exams.export-assignments', $exam) }}" 
                       class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-lg shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primaryGreen">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        Export Assignments
                    </a>
                    <a href="{{ route('partner.exams.show', $exam) }}" 
                       class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-lg shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primaryGreen">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                        Back to Exam
                    </a>
                </div>
            </div>
        </div>

        <!-- Exam Info Card -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 mb-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Exam Details</h3>
                    <div class="space-y-2 text-sm text-gray-600">
                        <p><span class="font-medium">Title:</span> {{ $exam->title }}</p>
                        <p><span class="font-medium">Duration:</span> {{ $exam->duration }} minutes</p>
                        <p><span class="font-medium">Questions:</span> {{ $exam->total_questions ?? 'N/A' }}</p>
                        <p><span class="font-medium">Status:</span> 
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                {{ $exam->status === 'published' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                {{ ucfirst($exam->status) }}
                            </span>
                        </p>
                    </div>
                </div>
                
                <div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Time Information</h3>
                    <div class="space-y-2 text-sm text-gray-600">
                        <p><span class="font-medium">Start:</span> {{ $exam->start_time->format('M d, Y g:i A') }}</p>
                        <p><span class="font-medium">End:</span> {{ $exam->end_time->format('M d, Y g:i A') }}</p>
                        <p><span class="font-medium">Passing Marks:</span> {{ $exam->passing_marks }}</p>
                    </div>
                </div>
                
                <div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Assignment Stats</h3>
                    <div class="space-y-2 text-sm text-gray-600">
                        <p><span class="font-medium">Assigned:</span> {{ $exam->assignedStudents->count() }} students</p>
                        <p><span class="font-medium">Completed:</span> {{ $exam->studentResults->where('status', 'completed')->count() }} students</p>
                        <p><span class="font-medium">In Progress:</span> {{ $exam->studentResults->where('status', 'in_progress')->count() }} students</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <!-- Available Students -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900">Available Students</h3>
                    <p class="text-sm text-gray-600">Select students to assign to this exam</p>
                </div>
                
                <div class="p-6">
                    @if($availableStudents->count() > 0)
                        <form method="POST" action="{{ route('partner.exams.assign-students', $exam) }}" class="space-y-4">
                            @csrf
                            
                            <!-- Bulk Actions -->
                            <div class="flex items-center space-x-3 mb-4">
                                <button type="button" 
                                        onclick="selectAll()"
                                        class="text-sm text-primaryGreen hover:text-primaryGreen/80 font-medium">
                                    Select All
                                </button>
                                <button type="button" 
                                        onclick="deselectAll()"
                                        class="text-sm text-gray-600 hover:text-gray-800 font-medium">
                                    Deselect All
                                </button>
                            </div>
                            
                            <!-- Student List -->
                            <div class="space-y-3 max-h-96 overflow-y-auto">
                                @foreach($availableStudents as $student)
                                <label class="flex items-center p-3 border border-gray-200 rounded-lg cursor-pointer hover:bg-gray-50 transition-colors">
                                    <input type="checkbox" 
                                           name="student_ids[]" 
                                           value="{{ $student->id }}"
                                           class="h-4 w-4 text-primaryGreen focus:ring-primaryGreen border-gray-300 student-checkbox">
                                    <div class="ml-3 flex-1">
                                        <div class="flex items-center justify-between">
                                            <div>
                                                <p class="text-sm font-medium text-gray-900">{{ $student->full_name }}</p>
                                                <p class="text-sm text-gray-500">{{ $student->phone }}</p>
                                            </div>
                                            <div class="text-right">
                                                <p class="text-xs text-gray-500">{{ $student->class_grade }}</p>
                                                <p class="text-xs text-gray-500">{{ $student->school_college }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </label>
                                @endforeach
                            </div>
                            
                            <button type="submit" 
                                    class="w-full mt-4 px-4 py-2 bg-gradient-to-r from-primaryGreen to-emerald-600 text-white font-medium rounded-lg hover:from-primaryGreen/90 hover:to-emerald-600/90 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primaryGreen transition-all duration-200">
                                Assign Selected Students
                            </button>
                        </form>
                    @else
                        <div class="text-center py-8">
                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                            </svg>
                            <h3 class="mt-2 text-sm font-medium text-gray-900">No available students</h3>
                            <p class="mt-1 text-sm text-gray-500">All students have been assigned to this exam.</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Assigned Students -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900">Assigned Students</h3>
                    <p class="text-sm text-gray-600">Students with access codes for this exam</p>
                </div>
                
                <div class="p-6">
                    @if($exam->accessCodes->count() > 0)
                        <!-- Bulk Actions for Assigned Students -->
                        <form method="POST" action="{{ route('partner.exams.bulk-operations', $exam) }}" class="mb-4">
                            @csrf
                            <div class="flex items-center space-x-3">
                                <select name="action" class="border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-primaryGreen focus:border-primaryGreen">
                                    <option value="">Select Action</option>
                                    <option value="remove">Remove Assignment</option>
                                    <option value="regenerate">Regenerate Codes</option>
                                </select>
                                <button type="submit" 
                                        class="px-4 py-2 bg-red-600 text-white text-sm font-medium rounded-lg hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                                    Apply to Selected
                                </button>
                            </div>
                        </form>
                        
                        <!-- Assigned Students List -->
                        <div class="space-y-3 max-h-96 overflow-y-auto">
                            @foreach($exam->accessCodes as $accessCode)
                            <div class="border border-gray-200 rounded-lg p-4">
                                <div class="flex items-center justify-between">
                                    <div class="flex-1">
                                        <div class="flex items-center justify-between mb-2">
                                            <div>
                                                <p class="text-sm font-medium text-gray-900">{{ $accessCode->student->full_name }}</p>
                                                <p class="text-xs text-gray-500">{{ $accessCode->student->phone }}</p>
                                            </div>
                                            <div class="text-right">
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                                    {{ $accessCode->status === 'active' ? 'bg-green-100 text-green-800' : ($accessCode->status === 'used' ? 'bg-blue-100 text-blue-800' : 'bg-gray-100 text-gray-800') }}">
                                                    {{ ucfirst($accessCode->status) }}
                                                </span>
                                            </div>
                                        </div>
                                        
                                        <div class="flex items-center justify-between">
                                            <div class="flex items-center space-x-4">
                                                <span class="text-sm text-gray-600">
                                                    <span class="font-medium">Code:</span> 
                                                    <span class="font-mono text-lg tracking-widest">{{ $accessCode->access_code }}</span>
                                                </span>
                                                @if($accessCode->used_at)
                                                <span class="text-sm text-gray-500">
                                                    Used: {{ $accessCode->used_at->format('M d, g:i A') }}
                                                </span>
                                                @endif
                                            </div>
                                            
                                            <div class="flex items-center space-x-2">
                                                <input type="checkbox" 
                                                       name="student_ids[]" 
                                                       value="{{ $accessCode->student_id }}"
                                                       class="h-4 w-4 text-red-600 focus:ring-red-500 border-gray-300">
                                                
                                                <form method="POST" action="{{ route('partner.exams.regenerate-code', $exam) }}" class="inline">
                                                    @csrf
                                                    <input type="hidden" name="student_id" value="{{ $accessCode->student_id }}">
                                                    <button type="submit" 
                                                            class="text-sm text-primaryGreen hover:text-primaryGreen/80 font-medium"
                                                            onclick="return confirm('Are you sure you want to regenerate the access code for {{ $accessCode->student->full_name }}?')">
                                                        Regenerate
                                                    </button>
                                                </form>
                                                
                                                <form method="POST" action="{{ route('partner.exams.remove-assignment', $exam) }}" class="inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <input type="hidden" name="student_id" value="{{ $accessCode->student_id }}">
                                                    <button type="submit" 
                                                            class="text-sm text-red-600 hover:text-red-800 font-medium"
                                                            onclick="return confirm('Are you sure you want to remove {{ $accessCode->student->full_name }} from this exam?')">
                                                        Remove
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-8">
                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                            </svg>
                            <h3 class="mt-2 text-sm font-medium text-gray-900">No students assigned</h3>
                            <p class="mt-1 text-sm text-gray-500">Assign students from the left panel to get started.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function selectAll() {
        document.querySelectorAll('.student-checkbox').forEach(checkbox => {
            checkbox.checked = true;
        });
    }
    
    function deselectAll() {
        document.querySelectorAll('.student-checkbox').forEach(checkbox => {
            checkbox.checked = false;
        });
    }
</script>
@endsection
