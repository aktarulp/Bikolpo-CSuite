@extends('layouts.partner-layout')

@section('content')
<div class="min-h-screen bg-gray-50">
    <div class="max-w-6xl mx-auto px-3 sm:px-4 lg:px-6">
        <!-- Colorful Header -->
        <div class="mb-6">
            <div class="bg-gradient-to-r from-blue-50 via-indigo-50 to-purple-50 rounded-xl border border-blue-200 shadow-lg">
                <div class="px-6 py-5">
                    <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between space-y-4 lg:space-y-0">
                        <!-- Left Section -->
                        <div class="flex items-center space-x-4">
                            <div class="flex items-center space-x-3">
                                <div class="p-3 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-xl shadow-lg">
                                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <h1 class="text-xl sm:text-2xl font-bold text-gray-900">#{{ $exam->id }} - {{ $exam->title }}</h1>
                                    <p class="text-sm text-gray-600 mt-1 flex items-center">
                                        <svg class="w-4 h-4 mr-1 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                                        </svg>
                                        Student Assignment Management
                                    </p>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Right Section - Cards and Back Button -->
                        <div class="flex flex-col space-y-3">
                            <!-- Stats Cards -->
                            <div class="flex flex-wrap gap-2 sm:gap-3">
                                <!-- Total Students -->
                                <div class="bg-white/60 backdrop-blur-sm rounded-lg px-3 py-1.5 border border-white/20">
                                    <div class="text-sm font-semibold text-gray-800">
                                        Total | <span class="text-xl font-bold">{{ $exam->accessCodes->count() + $availableStudents->count() }}</span>
                                    </div>
                                </div>
                                
                                <!-- Assigned Students -->
                                <div class="bg-gradient-to-br from-green-100 to-emerald-100 rounded-lg px-3 py-1.5 border border-green-200">
                                    <div class="text-sm font-semibold text-green-700">
                                        Assigned | <span class="text-xl font-bold">{{ $exam->accessCodes->count() }}</span>
                                    </div>
                                </div>
                                
                                <!-- Available Students -->
                                <div class="bg-gradient-to-br from-blue-100 to-cyan-100 rounded-lg px-3 py-1.5 border border-blue-200">
                                    <div class="text-sm font-semibold text-blue-700">
                                        Available | <span class="text-xl font-bold">{{ $availableStudents->count() }}</span>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Back Button - Right aligned on mobile -->
                            <div class="flex justify-end">
                                <a href="{{ route('partner.exams.show', $exam) }}" 
                                   class="inline-flex items-center px-3 py-1.5 bg-gradient-to-r from-gray-600 to-gray-700 text-white hover:from-gray-700 hover:to-gray-800 rounded transition-all duration-200 shadow hover:shadow-md">
                                    <svg class="w-3 h-3 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                                    </svg>
                                    <span class="text-xs font-medium">Back to Exam</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="space-y-4">
            <!-- Message Container -->
            <div id="message-container" class="fixed inset-x-0 top-0 z-50 w-full md:w-1/2 lg:w-1/3 mx-auto mt-4 px-4"></div>
            
            <!-- Assigned Students -->
            <div class="bg-white rounded border border-gray-200">
                <div class="px-3 py-2 border-b border-gray-200 bg-gray-50">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-2">
                            <div class="w-5 h-5 bg-green-500 rounded-full"></div>
                            <h3 class="text-xs font-semibold text-gray-900">Assigned Students</h3>
                            <span class="inline-flex items-center px-1.5 py-0.5 rounded text-xs font-medium bg-green-100 text-green-800">
                                {{ $exam->accessCodes->count() }}
                            </span>
                        </div>
                    </div>
                </div>
                
                <div class="p-3">
                    @if($exam->accessCodes->count() > 0)
                        <!-- Select All / Deselect All / Bulk Actions -->
                        <div class="flex flex-col sm:flex-row items-center justify-between space-y-2 sm:space-y-0 sm:space-x-4 mb-4">
                            <div class="flex space-x-2">
                                <button type="button" 
                                        onclick="selectAllAssigned()" 
                                        class="px-3 py-1.5 bg-blue-600 text-white text-xs font-medium rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-1">
                                    Select All
                                </button>
                                <button type="button" 
                                        onclick="deselectAllAssigned()" 
                                        class="px-3 py-1.5 bg-gray-600 text-white text-xs font-medium rounded-md hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-1">
                                    Deselect All
                                </button>
                            </div>
                            
                            <!-- Bulk Actions -->
                            <form id="bulk-actions-form" method="POST" action="{{ route('partner.exams.bulk-operations', $exam) }}" class="w-full sm:w-auto">
                                @csrf
                                <div class="flex items-center space-x-2">
                                    <select name="action" id="bulk-action-select" 
                                            class="flex-grow block w-full px-3 py-1.5 text-xs border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primaryGreen focus:border-primaryGreen">
                                        <option value="">Actions</option>
                                        <option value="remove">Remove</option>
                                        <option value="regenerate">Regenerate</option>
                                        <option value="send_sms">Send SMS</option>
                                    </select>
                                    <button type="submit" 
                                            class="px-3 py-1.5 bg-red-600 text-white text-xs font-medium rounded-md hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-1"
                                            onclick="return confirmBulkAction()"
                                            title="Apply Bulk Action">
                                         <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                     </button>
                                </div>
                            </form>
                        </div>
                        
                        <!-- Assigned Students List -->
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                            @foreach($exam->accessCodes as $accessCode)
                            <div class="bg-white border border-gray-200 rounded-lg shadow-sm hover:shadow-md transition-shadow duration-200 assignment-card" data-assignment-id="{{ $accessCode->id }}">
                                <div class="p-3 bg-gradient-to-br from-indigo-50 to-blue-50 rounded-t-lg border-b border-gray-200">
                                    <div class="flex items-start space-x-3">
                                        <input type="checkbox" 
                                               name="assignment_ids[]" 
                                               value="{{ $accessCode->id }}"
                                               class="mt-1 h-5 w-5 text-red-600 focus:ring-red-500 border-gray-300 rounded assigned-student-checkbox">
                                        
                                        <div class="flex-shrink-0">
                                            @if($accessCode->student->photo)
                                                <img class="h-12 w-12 rounded-full object-cover border border-gray-200" 
                                                     src="{{ Storage::url($accessCode->student->photo) }}" 
                                                     alt="{{ $accessCode->student->full_name }}">
                                            @else
                                                <div class="h-12 w-12 rounded-full bg-blue-500 flex items-center justify-center border border-gray-200">
                                                    <span class="text-base font-bold text-white">{{ substr($accessCode->student->full_name, 0, 1) }}</span>
                                                </div>
                                            @endif
                                        </div>
                                        
                                        <div class="flex-1 min-w-0">
                                            <p class="text-base font-semibold text-gray-900 leading-snug truncate">{{ $accessCode->student->full_name }}
                                                @if($accessCode->used_at)
                                                    <span class="ml-1 text-green-600 font-medium" title="Exam Taken">✓</span>
                                                @endif
                                            </p>
                                            <p class="text-sm text-gray-600 truncate">{{ $accessCode->student->phone }}</p>
                                            
                                        </div>
                                    </div>

                                    
                                </div>

                                <div class="p-4 space-y-2 bg-gradient-to-br from-white to-gray-50">
                                        <div class="flex items-center justify-between text-sm">
                                            <span class="font-medium text-gray-700">Phone:</span>
                                            <span class="text-gray-900">{{ $accessCode->student->phone ?? 'N/A' }}</span>
                                        </div>
                                        <div class="flex items-center justify-between text-sm">
                                            <span class="font-medium text-gray-700">Access Code:</span>
                                            <span class="font-mono font-bold text-blue-600 bg-blue-50 px-2 py-0.5 rounded text-sm">{{ $accessCode->access_code }}</span>
                                        </div>
                                        <div class="flex items-center justify-between text-sm sms-status-display" data-assignment-id="{{ $accessCode->id }}">
                                            <span class="font-medium text-gray-700">SMS Status:</span>
                                            <span class="font-semibold 
                                                @if($accessCode->sms_status === 'sent') text-green-600 
                                                @elseif($accessCode->sms_status === 'failed') text-red-600 
                                                @elseif($accessCode->sms_status === 'skipped_no_phone') text-yellow-600 
                                                @else text-gray-500 
                                                @endif">
                                                {{ ucfirst(str_replace('_', ' ', $accessCode->sms_status ?? 'pending')) }}
                                            </span>
                                        </div>
                                    </div>

                                <div class="border-t border-gray-200 bg-gradient-to-r from-gray-100 to-gray-200 px-4 py-3 flex justify-end space-x-2">
                                    <form method="POST" action="{{ route('partner.exams.regenerate-code', $exam) }}" class="inline regenerate-form" data-assignment-id="{{ $accessCode->id }}">
                                        @csrf
                                        <input type="hidden" name="assignment_id" value="{{ $accessCode->id }}">
                                        <button type="submit" 
                                                class="inline-flex items-center px-3 py-1.5 border border-transparent text-xs font-medium rounded-md text-green-700 bg-green-100 hover:bg-green-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500"
                                                onclick="return confirm('Regenerate code for {{ $accessCode->student->full_name }}?')">
                                            <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 1024 1024"><g><path d="M277.333333 277.333333c0-70.4 57.6-128 128-128h213.333334c70.4 0 128 57.6 128 128h85.333333c0-117.333333-96-213.333333-213.333333-213.333333H405.333333C288 64 192 160 192 277.333333v238.933334h85.333333V277.333333z"></path><path d="M98.133333 469.333333l136.533334 179.2 136.533333-179.2z"></path><path d="M746.666667 746.666667c0 70.4-57.6 128-128 128H405.333333c-70.4 0-128-57.6-128-128H192c0 117.333333 96 213.333333 213.333333 213.333333h213.333334c117.333333 0 213.333333-96 213.333333-213.333333V490.666667h-85.333333v256z"></path><path d="M652.8 554.666667l136.533333-179.2 136.533334 179.2z"></path></g></svg>
                                            Regenerate
                                        </button>
                                    </form>
                                    
                                    <form method="POST" action="{{ route('partner.exams.remove-assignment', $exam) }}" class="inline remove-form" data-assignment-id="{{ $accessCode->id }}">
                                        @csrf
                                        @method('DELETE')
                                        <input type="hidden" name="assignment_id" value="{{ $accessCode->id }}">
                                        <button type="submit" 
                                                class="inline-flex items-center px-3 py-1.5 border border-transparent text-xs font-medium rounded-md text-red-700 bg-red-100 hover:bg-red-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500"
                                                onclick="return confirm('Remove {{ $accessCode->student->full_name }}?')">
                                            <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 24 24">
                                                <g><path d="M14,18.5A2.5,2.5,0,0,1,16.5,16a2.6,2.6,0,0,1,.74.12L18,7H6l.93,13.07a1,1,0,0,0,1,.93H11l1-2h2.05A2.73,2.73,0,0,1,14,18.5Z" style="fill: #2ca9bc; stroke-width: 2;"></path><path d="M17.24,16.11,18,7H6l.93,13.07a1,1,0,0,0,1,.93H11l1-2h2" style="fill: none; stroke: #000000; stroke-linecap: round; stroke-linejoin: round; stroke-width: 2;"></path><path d="M7,7l.81-3.24a1,1,0,0,1,1-.76h6.44a1,1,0,0,1,1,.76L17,7ZM5,7H19m0,11.5A2.5,2.5,0,1,0,16.5,21,2.5,2.5,0,0,0,19,18.5Z" style="fill: none; stroke: #000000; stroke-linecap: round; stroke-linejoin: round; stroke-width: 2;"></path></g></svg>
                                            Remove
                                        </button>
                                    </form>
                                     
                                     <button type="button" 
                                             onclick="sendSms([{{ $accessCode->id }}], '{{ $accessCode->student->full_name }}')"
                                             class="inline-flex items-center p-1.5 border border-transparent text-xs font-medium rounded-md text-blue-700 bg-blue-100 hover:bg-blue-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500"
                                             title="Send SMS">
                                         <svg class="w-4 h-4 mr-1" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                         </svg>Send
                                     </button>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-12">
                            <div class="mx-auto w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mb-4">
                                <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                                </svg>
                            </div>
                            <h3 class="text-lg font-semibold text-gray-900 mb-2">No students assigned</h3>
                            <p class="text-sm text-gray-500">Assign students from the available students panel below to get started.</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Available Students -->
            <div class="bg-white rounded border border-gray-200">
                <div class="px-3 py-2 border-b border-gray-200 bg-gray-50">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-2">
                            <div class="w-5 h-5 bg-blue-500 rounded-full"></div>
                            <h3 class="text-xs font-semibold text-gray-900">Available Students</h3>
                            <span class="inline-flex items-center px-1.5 py-0.5 rounded text-xs font-medium bg-blue-100 text-blue-800">
                                {{ $availableStudents->count() }}
                            </span>
                        </div>
                        <div class="flex items-center space-x-2">
                            <button type="button" 
                                    id="toggle-filters"
                                    class="text-xs text-gray-600 hover:text-gray-900 px-2 py-1 rounded hover:bg-gray-100">
                                <span id="toggle-text">Hide Filters</span>
                            </button>
                            @if($availableStudents->count() > 0)
                                <button type="submit" 
                                        form="assign-students-form"
                                        class="px-2 py-1 bg-primaryGreen text-white text-xs font-medium rounded hover:bg-primaryGreen/90 focus:outline-none focus:ring-1 focus:ring-primaryGreen">
                                    Assign Selected
                                </button>
                            @endif
                        </div>
                    </div>
                </div>
                
                <!-- Search and Filter Section -->
                <div id="filters-content" class="px-3 py-2 border-b border-gray-200 bg-gray-50">
                    <form method="GET" action="{{ route('partner.exams.assign', $exam) }}">
                        <div class="grid grid-cols-2 sm:grid-cols-4 gap-1.5">
                            <!-- Search -->
                            <div class="col-span-2">
                                <input type="text" name="search" id="search" 
                                       value="{{ request('search') }}"
                                       placeholder="Search students..."
                                       class="w-full px-2 py-1 text-xs border border-gray-300 rounded focus:outline-none focus:ring-1 focus:ring-primaryGreen focus:border-primaryGreen">
                            </div>
                            
                            <!-- Course -->
                            <div>
                                <select name="course_id" id="course_id" 
                                        class="w-full px-2 py-1 text-xs border border-gray-300 rounded focus:outline-none focus:ring-1 focus:ring-primaryGreen focus:border-primaryGreen">
                                    <option value="all" {{ request('course_id') == 'all' || !request('course_id') ? 'selected' : '' }}>All Courses</option>
                                    @foreach($courses ?? [] as $course)
                                        <option value="{{ $course->id }}" {{ request('course_id') == $course->id ? 'selected' : '' }}>{{ $course->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            
                            <!-- Batch -->
                            <div>
                                <select name="batch_id" id="batch_id" 
                                        class="w-full px-2 py-1 text-xs border border-gray-300 rounded focus:outline-none focus:ring-1 focus:ring-primaryGreen focus:border-primaryGreen">
                                    <option value="all" {{ request('batch_id') == 'all' || !request('batch_id') ? 'selected' : '' }}>All Batches</option>
                                    @foreach($batches ?? [] as $batch)
                                        <option value="{{ $batch->id }}" {{ request('batch_id') == $batch->id ? 'selected' : '' }}>{{ $batch->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            
                            <!-- Gender -->
                            <div>
                                <select name="gender" id="gender" 
                                        class="w-full px-2 py-1 text-xs border border-gray-300 rounded focus:outline-none focus:ring-1 focus:ring-primaryGreen focus:border-primaryGreen">
                                    <option value="all" {{ request('gender') == 'all' || !request('gender') ? 'selected' : '' }}>All Gender</option>
                                    <option value="male" {{ request('gender') == 'male' ? 'selected' : '' }}>Male</option>
                                    <option value="female" {{ request('gender') == 'female' ? 'selected' : '' }}>Female</option>
                                    <option value="other" {{ request('gender') == 'other' ? 'selected' : '' }}>Other</option>
                                </select>
                            </div>
                            
                            <!-- Clear Filters -->
                            <div>
                                <a href="{{ route('partner.exams.assign', $exam) }}" 
                                   class="w-full inline-flex items-center justify-center px-2 py-1 border border-gray-300 text-xs font-medium rounded text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-1 focus:ring-primaryGreen">
                                    Clear
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
                
                <div class="p-3">
                    @if($availableStudents->count() > 0)
                        <form id="assign-students-form" method="POST" action="{{ route('partner.exams.assign-students', $exam) }}">
                            @csrf
                            
                            <!-- Bulk Actions -->
                            <div class="flex items-center justify-between mb-2 p-1.5 bg-gray-50 rounded border">
                                <div class="flex items-center space-x-2">
                                    <button type="button" 
                                            onclick="selectAll()"
                                            class="text-xs text-primaryGreen hover:text-primaryGreen/80 font-medium px-1 py-0.5 rounded hover:bg-green-50">
                                        Select All
                                    </button>
                                    <button type="button" 
                                            onclick="deselectAll()"
                                            class="text-xs text-gray-600 hover:text-gray-800 font-medium px-1 py-0.5 rounded hover:bg-gray-100">
                                        Deselect All
                                    </button>
                                </div>
                                <div class="text-xs text-gray-600">
                                    <span id="selected-count">0</span> selected
                                </div>
                            </div>
                            
                            <!-- Student List -->
                            <div class="space-y-0.5">
                                @foreach($availableStudents as $student)
                                <label class="flex items-center justify-between p-1.5 border border-gray-200 rounded hover:bg-gray-50 transition-colors cursor-pointer">
                                    <div class="flex items-center space-x-2 flex-1 min-w-0">
                                        <input type="checkbox" 
                                               name="student_ids[]" 
                                               value="{{ $student->id }}"
                                               class="h-5 w-5 text-primaryGreen focus:ring-primaryGreen border-gray-400 rounded student-checkbox"
                                               onchange="updateSelectedCount()">
                                        
                                        <div class="flex-shrink-0">
                                            @if($student->photo)
                                                <img class="h-10 w-10 rounded-full object-cover" 
                                                     src="{{ Storage::url($student->photo) }}" 
                                                     alt="{{ $student->full_name }}">
                                            @else
                                                <div class="h-10 w-10 rounded-full bg-blue-500 flex items-center justify-center">
                                                    <span class="text-xs font-bold text-white">{{ substr($student->full_name, 0, 1) }}</span>
                                                </div>
                                            @endif
                                        </div>
                                        
                                        <div class="flex-1 min-w-0">
                                            <div class="flex items-center space-x-2">
                                                <p class="text-base font-medium text-gray-900 truncate">{{ $student->full_name }}</p>
                                            </div>
                                            <div class="flex flex-col sm:flex-row sm:items-center sm:space-x-1 space-y-1 sm:space-y-0 text-base text-gray-500">
                                                @if($student->course)
                                                    <span class="px-2 py-1 bg-blue-100 text-blue-800 rounded text-xs w-fit">{{ $student->course->name }}</span>
                                                @endif
                                                @if($student->batch)
                                                    <span class="px-2 py-1 bg-green-100 text-green-800 rounded text-xs w-fit">{{ $student->batch->name }}</span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="text-right text-base text-gray-500">
                                        <div class="mb-1 sm:mb-0">
                                            <p class="font-medium">{{ $student->phone }}</p>
                                        </div>
                                        @if($student->class_grade)
                                            <div class="mb-1 sm:mb-0">
                                                <p class="font-medium">{{ $student->class_grade }}</p>
                                            </div>
                                        @endif
                                        @if($student->school_college)
                                            <div>
                                                <p class="truncate max-w-[120px]">{{ $student->school_college }}</p>
                                            </div>
                                        @endif
                                    </div>
                                </label>
                                @endforeach
                            </div>
                        </form>
                    @else
                        <div class="text-center py-12">
                            <div class="mx-auto w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mb-4">
                                <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                                </svg>
                            </div>
                            <h3 class="text-lg font-semibold text-gray-900 mb-2">No available students</h3>
                            <p class="text-sm text-gray-500">All students have been assigned to this exam.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const filterForm = document.querySelector('form[method="GET"]');
    const filterSelects = filterForm.querySelectorAll('select');
    const searchInput = document.getElementById('search');
    
    // Filter toggle functionality
    const toggleButton = document.getElementById('toggle-filters');
    const toggleText = document.getElementById('toggle-text');
    const toggleIcon = document.getElementById('toggle-icon');
    const filtersContent = document.getElementById('filters-content');
    
    // Check if filters should be hidden by default (stored in localStorage)
    const filtersHidden = localStorage.getItem('filtersHidden') === 'true';
    if (filtersHidden) {
        filtersContent.style.display = 'none';
        toggleText.textContent = 'Show Filters';
        toggleIcon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>';
    }
    
    toggleButton.addEventListener('click', function() {
        const isHidden = filtersContent.style.display === 'none';
        filtersContent.style.display = isHidden ? 'block' : 'none';
        toggleText.textContent = isHidden ? 'Hide Filters' : 'Show Filters';
        toggleIcon.innerHTML = isHidden 
            ? '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"></path>'
            : '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>';
        localStorage.setItem('filtersHidden', !isHidden);
    });
    
    // Auto-submit form when select filters change
    filterSelects.forEach(select => {
        select.addEventListener('change', function() {
            filterForm.submit();
        });
    });
    
    // Debounced search input
    let searchTimeout;
    searchInput.addEventListener('input', function() {
        clearTimeout(searchTimeout);
        searchTimeout = setTimeout(() => {
            if (this.value.length >= 2 || this.value.length === 0) {
                filterForm.submit();
            }
        }, 500);
    });
    
    // Add filter count badges
    function updateFilterCounts() {
        const activeFilters = [];
        
        if (searchInput.value) activeFilters.push('Search');
        if (document.getElementById('course_id').value !== 'all') activeFilters.push('Course');
        if (document.getElementById('batch_id').value !== 'all') activeFilters.push('Batch');
        if (document.getElementById('gender').value !== 'all') activeFilters.push('Gender');
        
        const filterHeader = document.querySelector('h3');
        if (activeFilters.length > 0) {
            const badge = document.createElement('span');
            badge.className = 'ml-2 inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-primaryGreen text-white';
            badge.textContent = activeFilters.length;
            
            // Remove existing badge if any
            const existingBadge = filterHeader.querySelector('span');
            if (existingBadge) {
                existingBadge.remove();
            }
            
            filterHeader.appendChild(badge);
        }
    }
    
    // Initialize filter counts
    updateFilterCounts();
    
    // Update counts when filters change
    filterSelects.forEach(select => {
        select.addEventListener('change', updateFilterCounts);
    });
    searchInput.addEventListener('input', updateFilterCounts);
    
    // Add loading indicator when filters are being applied
    filterForm.addEventListener('submit', function() {
        const submitButton = document.createElement('button');
        submitButton.type = 'submit';
        submitButton.className = 'inline-flex items-center px-3 py-1.5 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white';
        submitButton.innerHTML = '<svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-gray-500" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>Loading...';
        
        // Replace the clear button temporarily
        const clearButton = document.querySelector('a[href*="assign"]');
        if (clearButton) {
            clearButton.style.display = 'none';
            clearButton.parentNode.appendChild(submitButton);
        }
    });
});

// Function to display messages (like toasts)
function displayMessage(message, type = 'success') {
    const messageContainer = document.getElementById('message-container');
    if (!messageContainer) {
        console.warn('Message container not found.');
        return;
    }

    const alertDiv = document.createElement('div');
    alertDiv.className = `p-3 rounded-md mb-3 text-sm flex items-center justify-between ${type === 'success' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'}`;
    alertDiv.innerHTML = `
        <span>${message}</span>
        <button type="button" onclick="this.closest('div').remove()" class="ml-4 text-current hover:opacity-75">
            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
            </svg>
        </button>
    `;
    messageContainer.prepend(alertDiv);

    // Automatically remove after 5 seconds
    setTimeout(() => alertDiv.remove(), 5000);
}

// Student selection functions
    function selectAll() {
        document.querySelectorAll('.student-checkbox').forEach(checkbox => {
            checkbox.checked = true;
        });
        updateSelectedCount();
    }
    
    function deselectAll() {
        document.querySelectorAll('.student-checkbox').forEach(checkbox => {
            checkbox.checked = false;
        });
        updateSelectedCount();
    }
    
    // Assigned students selection functions
    function selectAllAssigned() {
        document.querySelectorAll('.assigned-student-checkbox').forEach(checkbox => {
            checkbox.checked = true;
        });
    }
    
    function deselectAllAssigned() {
        document.querySelectorAll('.assigned-student-checkbox').forEach(checkbox => {
            checkbox.checked = false;
        });
    }
    
    function updateSelectedCount() {
        const checkboxes = document.querySelectorAll('.student-checkbox');
        const checkedCount = document.querySelectorAll('.student-checkbox:checked').length;
        const selectedCountElement = document.getElementById('selected-count');
        
        if (selectedCountElement) {
            selectedCountElement.textContent = checkedCount;
        }
    }

    // Function to update SMS status on the UI
    function updateSmsStatusInUi(assignmentId, newStatus) {
        const statusSpan = document.querySelector(`.sms-status-display[data-assignment-id="${assignmentId}"] span`);
        if (statusSpan) {
            statusSpan.textContent = newStatus.replace(/_/g, ' ').split(' ').map(word => word.charAt(0).toUpperCase() + word.slice(1)).join(' ');
            statusSpan.className = 'font-semibold ';
            if (newStatus === 'sent') {
                statusSpan.classList.add('text-green-600');
            } else if (newStatus === 'failed') {
                statusSpan.classList.add('text-red-600');
            } else if (newStatus === 'skipped_no_phone') {
                statusSpan.classList.add('text-yellow-600');
            } else {
                statusSpan.classList.add('text-gray-500');
            }
        }
    }

    // Send SMS function
    async function sendSms(assignmentIds, studentName = 'selected students') {
        if (!confirm(`Send SMS to ${studentName}?`)) {
            return;
        }

        const url = `{{ route('partner.exams.send-assignment-sms', $exam) }}`;

        try {
            const response = await fetch(url, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({ assignment_ids: assignmentIds })
            });

            const data = await response.json();

            if (data.success) {
                displayMessage(data.message, 'success');
                // Update status for each sent SMS
                assignmentIds.forEach(id => updateSmsStatusInUi(id, 'sent')); // Assuming all in a successful bulk send are 'sent'
            } else {
                displayMessage(`Error: ${data.message || 'Failed to send SMS.'}`, 'error');
                // You might need to reload or fetch specific assignment statuses if individual failures are reported.
                // For now, let's assume if the overall call failed, we show a generic error.
            }
        } catch (error) {
            console.error('Error sending SMS:', error);
            displayMessage('An unexpected error occurred while sending SMS.', 'error');
        }
    }

    // Bulk Send SMS function
    async function bulkSendSms() {
        const selectedAssignmentCheckboxes = document.querySelectorAll('.assigned-student-checkbox:checked');
        const assignmentIds = Array.from(selectedAssignmentCheckboxes).map(cb => cb.value);

        if (assignmentIds.length === 0) {
            displayMessage('Please select at least one student to send SMS.', 'error');
            return;
        }
        
        const url = `{{ route('partner.exams.bulk-operations', $exam) }}`;
        const action = 'send_sms';

        try {
            const response = await fetch(url, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({ action: action, assignment_ids: assignmentIds })
            });

            const data = await response.json();

            if (data.success) {
                displayMessage(data.message, 'success');
                // For bulk operations, a full reload might still be simpler to reflect all changes accurately
                window.location.reload();
            } else {
                displayMessage(`Error: ${data.message || 'Failed to perform bulk SMS action.'}`, 'error');
            }
        } catch (error) {
            console.error('Error during bulk SMS action:', error);
            displayMessage('An unexpected error occurred during bulk SMS action.', 'error');
        }
    }

    // New function for bulk actions confirmation
    function confirmBulkAction() {
        const actionSelect = document.getElementById('bulk-action-select');
        const selectedAction = actionSelect.value;
        const selectedAssignmentCheckboxes = document.querySelectorAll('.assigned-student-checkbox:checked');
        const assignmentIds = Array.from(selectedAssignmentCheckboxes).map(cb => cb.value);

        if (assignmentIds.length === 0) {
            displayMessage('Please select at least one assignment to perform a bulk action.', 'error');
            return false;
        }

        if (selectedAction === 'send_sms') {
            bulkSendSms(); // Call the async function directly
            return false; // Prevent default form submission
        } else if (selectedAction) {
            return confirm(`Are you sure you want to ${selectedAction} ${assignmentIds.length} assignments?`);
        }

        displayMessage('Please select an action.', 'error');
        return false;
    }

    // Attach event listener to the bulk actions form
    document.getElementById('bulk-actions-form').addEventListener('submit', function(event) {
        event.preventDefault(); // Prevent default form submission
        confirmBulkAction();
    });
</script>
@endpush
@endsection
