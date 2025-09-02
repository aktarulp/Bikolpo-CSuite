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

        <div class="space-y-8">
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
                        <div class="space-y-2 max-h-96 overflow-y-auto">
                            @foreach($exam->accessCodes as $accessCode)
                            <div class="flex items-center justify-between p-3 border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors">
                                <!-- Left Section: Student Info -->
                                <div class="flex items-center space-x-3 flex-1 min-w-0">
                                    <!-- Student Photo -->
                                    <div class="flex-shrink-0">
                                        @if($accessCode->student->photo)
                                            <img class="h-8 w-8 rounded-full object-cover shadow-sm" 
                                                 src="{{ Storage::url($accessCode->student->photo) }}" 
                                                 alt="{{ $accessCode->student->full_name }}">
                                        @else
                                            <div class="h-8 w-8 rounded-full bg-gradient-to-br from-blue-500 to-indigo-600 flex items-center justify-center shadow-sm">
                                                <span class="text-xs font-bold text-white">{{ substr($accessCode->student->full_name, 0, 1) }}</span>
                                            </div>
                                        @endif
                                    </div>
                                    
                                    <!-- Student Details -->
                                    <div class="flex-1 min-w-0">
                                        <div class="flex items-center space-x-2">
                                            <p class="text-sm font-medium text-gray-900 truncate">{{ $accessCode->student->full_name }}</p>
                                            @if($accessCode->student->course)
                                                <span class="inline-flex items-center px-1.5 py-0.5 rounded text-xs font-medium bg-blue-100 text-blue-800">
                                                    {{ $accessCode->student->course->name }}
                                                </span>
                                            @endif
                                            @if($accessCode->student->batch)
                                                <span class="inline-flex items-center px-1.5 py-0.5 rounded text-xs font-medium bg-green-100 text-green-800">
                                                    {{ $accessCode->student->batch->name }}
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Center Section: Phone & Access Code -->
                                <div class="flex items-center space-x-3 mx-4">
                                    <span class="text-xs text-gray-600">
                                        <span class="font-medium">Phone:</span> 
                                        <span class="text-gray-500">{{ $accessCode->student->phone }}</span>
                                    </span>
                                    <span class="text-xs text-gray-600">
                                        <span class="font-medium">Code:</span> 
                                        <span class="font-mono text-sm font-bold text-gray-900 tracking-wider bg-gray-100 px-2 py-1 rounded">
                                            {{ $accessCode->access_code }}
                                        </span>
                                    </span>
                                    @if($accessCode->used_at)
                                        <span class="text-xs text-gray-500">
                                            Used: {{ $accessCode->used_at->format('M d, g:i A') }}
                                        </span>
                                    @endif
                                </div>
                                
                                <!-- Right Section: Actions -->
                                <div class="flex items-center space-x-2 flex-shrink-0">
                                    <input type="checkbox" 
                                           name="student_ids[]" 
                                           value="{{ $accessCode->student_id }}"
                                           class="h-4 w-4 text-red-600 focus:ring-red-500 border-gray-300">
                                    
                                    <form method="POST" action="{{ route('partner.exams.regenerate-code', $exam) }}" class="inline">
                                        @csrf
                                        <input type="hidden" name="student_id" value="{{ $accessCode->student_id }}">
                                        <button type="submit" 
                                                class="text-xs text-primaryGreen hover:text-primaryGreen/80 font-medium px-2 py-1 rounded hover:bg-green-50 transition-colors"
                                                onclick="return confirm('Are you sure you want to regenerate the access code for {{ $accessCode->student->full_name }}?')">
                                            Regenerate
                                        </button>
                                    </form>
                                    
                                    <form method="POST" action="{{ route('partner.exams.remove-assignment', $exam) }}" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <input type="hidden" name="student_id" value="{{ $accessCode->student_id }}">
                                        <button type="submit" 
                                                class="text-xs text-red-600 hover:text-red-800 font-medium px-2 py-1 rounded hover:bg-red-50 transition-colors"
                                                onclick="return confirm('Are you sure you want to remove {{ $accessCode->student->full_name }} from this exam?')">
                                            Remove
                                        </button>
                                    </form>
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
                            <p class="mt-1 text-sm text-gray-500">Assign students from the right panel to get started.</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Available Students -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200">
                <div class="px-6 py-4 border-b border-gray-200">
                    <div class="flex items-center justify-between">
                        <div>
                    <h3 class="text-lg font-semibold text-gray-900">Available Students</h3>
                    <p class="text-sm text-gray-600">Select students to assign to this exam</p>
                        </div>
                        <div class="flex items-center space-x-3">
                            <button type="button" 
                                    id="toggle-filters"
                                    class="inline-flex items-center px-3 py-2 border border-gray-300 shadow-sm text-sm leading-4 font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primaryGreen">
                                <span id="toggle-text">Hide Filters</span>
                                <svg id="toggle-icon" class="ml-2 -mr-0.5 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"></path>
                                </svg>
                            </button>
                            @if($availableStudents->count() > 0)
                                <button type="submit" 
                                        form="assign-students-form"
                                        class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-primaryGreen to-emerald-600 text-white font-medium rounded-lg hover:from-primaryGreen/90 hover:to-emerald-600/90 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primaryGreen transition-all duration-200">
                                    Assign Selected Students
                                </button>
                            @endif
                        </div>
                    </div>
                </div>
                
                <!-- Search and Filter Section -->
                <div id="filters-content" class="px-6 py-4 border-b border-gray-200 bg-gray-50">
                    <form method="GET" action="{{ route('partner.exams.assign', $exam) }}" class="space-y-4">
                        <div class="flex flex-wrap items-end gap-3">
                            <!-- Search -->
                            <div class="min-w-[200px]">
                                <label for="search" class="block text-xs font-medium text-gray-700 mb-1">Search</label>
                                <input type="text" name="search" id="search" 
                                       value="{{ request('search') }}"
                                       placeholder="Name, Email, ID, Phone..."
                                       class="w-full px-2 py-1.5 text-sm border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primaryGreen focus:border-primaryGreen">
                            </div>
                            
                            <!-- Course -->
                            <div class="min-w-[160px]">
                                <label for="course_id" class="block text-xs font-medium text-gray-700 mb-1">Course</label>
                                <select name="course_id" id="course_id" 
                                        class="w-full px-2 py-1.5 text-sm border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primaryGreen focus:border-primaryGreen">
                                    <option value="all" {{ request('course_id') == 'all' || !request('course_id') ? 'selected' : '' }}>All Courses</option>
                                    @foreach($courses ?? [] as $course)
                                        <option value="{{ $course->id }}" {{ request('course_id') == $course->id ? 'selected' : '' }}>{{ $course->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            
                            <!-- Batch -->
                            <div class="min-w-[160px]">
                                <label for="batch_id" class="block text-xs font-medium text-gray-700 mb-1">Batch</label>
                                <select name="batch_id" id="batch_id" 
                                        class="w-full px-2 py-1.5 text-sm border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primaryGreen focus:border-primaryGreen">
                                    <option value="all" {{ request('batch_id') == 'all' || !request('batch_id') ? 'selected' : '' }}>All Batches</option>
                                    @foreach($batches ?? [] as $batch)
                                        <option value="{{ $batch->id }}" {{ request('batch_id') == $batch->id ? 'selected' : '' }}>{{ $batch->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            
                            <!-- Gender -->
                            <div class="min-w-[120px]">
                                <label for="gender" class="block text-xs font-medium text-gray-700 mb-1">Gender</label>
                                <select name="gender" id="gender" 
                                        class="w-full px-2 py-1.5 text-sm border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primaryGreen focus:border-primaryGreen">
                                    <option value="all" {{ request('gender') == 'all' || !request('gender') ? 'selected' : '' }}>All Gender</option>
                                    <option value="male" {{ request('gender') == 'male' ? 'selected' : '' }}>Male</option>
                                    <option value="female" {{ request('gender') == 'female' ? 'selected' : '' }}>Female</option>
                                    <option value="other" {{ request('gender') == 'other' ? 'selected' : '' }}>Other</option>
                                </select>
                            </div>
                            
                            <!-- Clear Filters -->
                            <div>
                                <a href="{{ route('partner.exams.assign', $exam) }}" 
                                   class="inline-flex items-center px-3 py-1.5 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primaryGreen">
                                    Clear
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
                
                <div class="p-6">
                    @if($availableStudents->count() > 0)
                        <form id="assign-students-form" method="POST" action="{{ route('partner.exams.assign-students', $exam) }}" class="space-y-4">
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
                                            <div class="flex items-center space-x-3">
                                                <!-- Student Photo -->
                                                <div class="flex-shrink-0">
                                                    @if($student->photo)
                                                        <img class="h-10 w-10 rounded-full object-cover shadow-sm" 
                                                             src="{{ Storage::url($student->photo) }}" 
                                                             alt="{{ $student->full_name }}">
                                                    @else
                                                        <div class="h-10 w-10 rounded-full bg-gradient-to-br from-blue-500 to-indigo-600 flex items-center justify-center shadow-sm">
                                                            <span class="text-sm font-bold text-white">{{ substr($student->full_name, 0, 1) }}</span>
                                                        </div>
                                                    @endif
                                                </div>
                                            <div>
                                                <p class="text-sm font-medium text-gray-900">{{ $student->full_name }}</p>
                                                <p class="text-sm text-gray-500">{{ $student->phone }}</p>
                                                    <div class="flex items-center space-x-2 mt-1">
                                                        @if($student->course)
                                                            <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-blue-100 text-blue-800">
                                                                {{ $student->course->name }}
                                                            </span>
                                                        @endif
                                                        @if($student->batch)
                                                            <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-green-100 text-green-800">
                                                                {{ $student->batch->name }}
                                                            </span>
                                                        @endif
                                                    </div>
                                                </div>
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

// Student selection functions
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
@endpush
@endsection
