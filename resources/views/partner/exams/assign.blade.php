@extends('layouts.partner-layout')

@section('content')
<div class="min-h-screen bg-gray-50">
    <div class="max-w-6xl mx-auto px-3 sm:px-4 lg:px-6">
        <!-- Modern Header -->
        <div class="mb-6">
            <div class="bg-white rounded-lg border border-gray-200 shadow-sm">
                <div class="px-4 py-4">
                    <div class="flex items-center justify-between">
                        <!-- Left Section -->
                        <div class="flex items-center space-x-4">
                            <div>
                                <h1 class="text-xl font-bold text-gray-900">{{ $exam->title }}</h1>
                                <p class="text-sm text-gray-500 mt-1">Student Assignment Management</p>
                            </div>
                        </div>
                        
                        <!-- Right Section -->
                        <div class="flex items-center space-x-3">
                            <div class="text-right">
                                <div class="text-xs text-gray-500 uppercase tracking-wide font-medium">Total Students</div>
                                <div class="text-lg font-bold text-gray-900">{{ $exam->accessCodes->count() + $availableStudents->count() }}</div>
                            </div>
                            
                            <div class="h-8 w-px bg-gray-300"></div>
                            
                            <div class="text-right">
                                <div class="text-xs text-gray-500 uppercase tracking-wide font-medium">Assigned</div>
                                <div class="text-lg font-bold text-green-600">{{ $exam->accessCodes->count() }}</div>
                            </div>
                            
                            <div class="h-8 w-px bg-gray-300"></div>
                            
                            <div class="text-right">
                                <div class="text-xs text-gray-500 uppercase tracking-wide font-medium">Available</div>
                                <div class="text-lg font-bold text-blue-600">{{ $availableStudents->count() }}</div>
                            </div>
                            
                            <div class="h-8 w-px bg-gray-300"></div>
                            
                            <a href="{{ route('partner.exams.show', $exam) }}" 
                               class="inline-flex items-center px-3 py-2 text-gray-600 hover:text-gray-900 hover:bg-gray-100 rounded-lg transition-all duration-200">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                                </svg>
                                <span class="text-sm font-medium">Back to Exam</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="space-y-4">
            <!-- Assigned Students -->
            <div class="bg-white rounded-lg border border-gray-200">
                <div class="px-4 py-3 border-b border-gray-200 bg-gray-50">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-3">
                            <div class="flex items-center space-x-2">
                                <div class="w-2 h-2 bg-green-500 rounded-full"></div>
                                <h3 class="text-sm font-semibold text-gray-900">Assigned Students</h3>
                            </div>
                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                {{ $exam->accessCodes->count() }}
                            </span>
                        </div>
                        @if($exam->accessCodes->count() > 0)
                            <div class="text-xs text-gray-500">
                                {{ $exam->accessCodes->count() }} student{{ $exam->accessCodes->count() !== 1 ? 's' : '' }} assigned
                            </div>
                        @endif
                    </div>
                </div>
                
                <div class="p-4">
                    @if($exam->accessCodes->count() > 0)
                        <!-- Bulk Actions -->
                        <form method="POST" action="{{ route('partner.exams.bulk-operations', $exam) }}" class="mb-3">
                            @csrf
                            <div class="flex items-center space-x-2">
                                <select name="action" class="flex-1 text-xs border border-gray-300 rounded px-2 py-1.5 focus:outline-none focus:ring-1 focus:ring-primaryGreen focus:border-primaryGreen">
                                    <option value="">Bulk Actions</option>
                                    <option value="remove">Remove</option>
                                    <option value="regenerate">Regenerate Codes</option>
                                </select>
                                <button type="submit" class="px-3 py-1.5 bg-red-600 text-white text-xs font-medium rounded hover:bg-red-700 focus:outline-none focus:ring-1 focus:ring-red-500">
                                    Apply
                                </button>
                            </div>
                        </form>
                        
                                                <!-- Assigned Students List -->
                        <div class="space-y-1 max-h-80 overflow-y-auto">
                            @foreach($exam->accessCodes as $accessCode)
                            <div class="flex items-center justify-between p-2 border border-gray-200 rounded hover:bg-gray-50 transition-colors">
                                <!-- Student Info -->
                                <div class="flex items-center space-x-3 flex-1 min-w-0">
                                    <input type="checkbox" 
                                           name="student_ids[]" 
                                           value="{{ $accessCode->student_id }}"
                                           class="h-3 w-3 text-red-600 focus:ring-red-500 border-gray-300 rounded">
                                    
                                    <div class="flex-shrink-0">
                                        @if($accessCode->student->photo)
                                            <img class="h-8 w-8 rounded-full object-cover" 
                                                 src="{{ Storage::url($accessCode->student->photo) }}" 
                                                 alt="{{ $accessCode->student->full_name }}">
                                        @else
                                            <div class="h-8 w-8 rounded-full bg-blue-500 flex items-center justify-center">
                                                <span class="text-xs font-bold text-white">{{ substr($accessCode->student->full_name, 0, 1) }}</span>
                                            </div>
                                        @endif
                                    </div>
                                    
                                    <div class="flex-1 min-w-0">
                                        <div class="flex items-center space-x-2">
                                            <p class="text-sm font-medium text-gray-900 truncate">{{ $accessCode->student->full_name }}</p>
                                            @if($accessCode->used_at)
                                                <span class="text-xs text-green-600 font-medium">✓</span>
                                            @endif
                                        </div>
                                        <div class="flex items-center space-x-2 text-xs text-gray-500">
                                            <span>{{ $accessCode->student->phone }}</span>
                                            @if($accessCode->student->course)
                                                <span class="px-1.5 py-0.5 bg-blue-100 text-blue-800 rounded">{{ $accessCode->student->course->name }}</span>
                                            @endif
                                            @if($accessCode->student->batch)
                                                <span class="px-1.5 py-0.5 bg-green-100 text-green-800 rounded">{{ $accessCode->student->batch->name }}</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Access Code -->
                                <div class="flex items-center space-x-2">
                                    <div class="text-right">
                                        <div class="text-xs text-gray-500">Code</div>
                                        <div class="font-mono text-xs font-bold text-gray-900 bg-gray-100 px-2 py-1 rounded">
                                            {{ $accessCode->access_code }}
                                        </div>
                                    </div>
                                    
                                    <!-- Actions -->
                                    <div class="flex space-x-1">
                                        <form method="POST" action="{{ route('partner.exams.regenerate-code', $exam) }}" class="inline">
                                            @csrf
                                            <input type="hidden" name="student_id" value="{{ $accessCode->student_id }}">
                                            <button type="submit" 
                                                    class="text-xs text-green-600 hover:text-green-800 px-1 py-0.5 rounded hover:bg-green-50"
                                                    onclick="return confirm('Regenerate code for {{ $accessCode->student->full_name }}?')">
                                                ↻
                                            </button>
                                        </form>
                                        
                                        <form method="POST" action="{{ route('partner.exams.remove-assignment', $exam) }}" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <input type="hidden" name="student_id" value="{{ $accessCode->student_id }}">
                                            <button type="submit" 
                                                    class="text-xs text-red-600 hover:text-red-800 px-1 py-0.5 rounded hover:bg-red-50"
                                                    onclick="return confirm('Remove {{ $accessCode->student->full_name }}?')">
                                                ×
                                            </button>
                                        </form>
                                    </div>
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
            <div class="bg-white rounded-lg border border-gray-200">
                <div class="px-4 py-3 border-b border-gray-200 bg-gray-50">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-3">
                            <div class="flex items-center space-x-2">
                                <div class="w-2 h-2 bg-blue-500 rounded-full"></div>
                                <h3 class="text-sm font-semibold text-gray-900">Available Students</h3>
                            </div>
                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
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
                                        class="px-3 py-1.5 bg-primaryGreen text-white text-xs font-medium rounded hover:bg-primaryGreen/90 focus:outline-none focus:ring-1 focus:ring-primaryGreen">
                                    Assign Selected
                                </button>
                            @endif
                        </div>
                    </div>
                </div>
                
                <!-- Search and Filter Section -->
                <div id="filters-content" class="px-4 py-3 border-b border-gray-200 bg-gray-50">
                    <form method="GET" action="{{ route('partner.exams.assign', $exam) }}">
                        <div class="grid grid-cols-2 sm:grid-cols-4 gap-2">
                            <!-- Search -->
                            <div class="col-span-2">
                                <input type="text" name="search" id="search" 
                                       value="{{ request('search') }}"
                                       placeholder="Search students..."
                                       class="w-full px-2 py-1.5 text-xs border border-gray-300 rounded focus:outline-none focus:ring-1 focus:ring-primaryGreen focus:border-primaryGreen">
                            </div>
                            
                            <!-- Course -->
                            <div>
                                <select name="course_id" id="course_id" 
                                        class="w-full px-2 py-1.5 text-xs border border-gray-300 rounded focus:outline-none focus:ring-1 focus:ring-primaryGreen focus:border-primaryGreen">
                                    <option value="all" {{ request('course_id') == 'all' || !request('course_id') ? 'selected' : '' }}>All Courses</option>
                                    @foreach($courses ?? [] as $course)
                                        <option value="{{ $course->id }}" {{ request('course_id') == $course->id ? 'selected' : '' }}>{{ $course->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            
                            <!-- Batch -->
                            <div>
                                <select name="batch_id" id="batch_id" 
                                        class="w-full px-2 py-1.5 text-xs border border-gray-300 rounded focus:outline-none focus:ring-1 focus:ring-primaryGreen focus:border-primaryGreen">
                                    <option value="all" {{ request('batch_id') == 'all' || !request('batch_id') ? 'selected' : '' }}>All Batches</option>
                                    @foreach($batches ?? [] as $batch)
                                        <option value="{{ $batch->id }}" {{ request('batch_id') == $batch->id ? 'selected' : '' }}>{{ $batch->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            
                            <!-- Gender -->
                            <div>
                                <select name="gender" id="gender" 
                                        class="w-full px-2 py-1.5 text-xs border border-gray-300 rounded focus:outline-none focus:ring-1 focus:ring-primaryGreen focus:border-primaryGreen">
                                    <option value="all" {{ request('gender') == 'all' || !request('gender') ? 'selected' : '' }}>All Gender</option>
                                    <option value="male" {{ request('gender') == 'male' ? 'selected' : '' }}>Male</option>
                                    <option value="female" {{ request('gender') == 'female' ? 'selected' : '' }}>Female</option>
                                    <option value="other" {{ request('gender') == 'other' ? 'selected' : '' }}>Other</option>
                                </select>
                            </div>
                            
                            <!-- Clear Filters -->
                            <div>
                                <a href="{{ route('partner.exams.assign', $exam) }}" 
                                   class="w-full inline-flex items-center justify-center px-2 py-1.5 border border-gray-300 text-xs font-medium rounded text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-1 focus:ring-primaryGreen">
                                    Clear
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
                
                <div class="p-4">
                    @if($availableStudents->count() > 0)
                        <form id="assign-students-form" method="POST" action="{{ route('partner.exams.assign-students', $exam) }}">
                            @csrf
                            
                            <!-- Bulk Actions -->
                            <div class="flex items-center justify-between mb-3 p-2 bg-gray-50 rounded border">
                                <div class="flex items-center space-x-3">
                                    <button type="button" 
                                            onclick="selectAll()"
                                            class="text-xs text-primaryGreen hover:text-primaryGreen/80 font-medium">
                                        Select All
                                    </button>
                                    <button type="button" 
                                            onclick="deselectAll()"
                                            class="text-xs text-gray-600 hover:text-gray-800 font-medium">
                                        Deselect All
                                    </button>
                                </div>
                                <div class="text-xs text-gray-600">
                                    <span id="selected-count">0</span> selected
                                </div>
                            </div>
                            
                            <!-- Student List -->
                            <div class="space-y-1 max-h-80 overflow-y-auto">
                                @foreach($availableStudents as $student)
                                <label class="flex items-center justify-between p-2 border border-gray-200 rounded hover:bg-gray-50 transition-colors cursor-pointer">
                                    <div class="flex items-center space-x-3 flex-1 min-w-0">
                                        <input type="checkbox" 
                                               name="student_ids[]" 
                                               value="{{ $student->id }}"
                                               class="h-3 w-3 text-primaryGreen focus:ring-primaryGreen border-gray-300 rounded student-checkbox"
                                               onchange="updateSelectedCount()">
                                        
                                        <div class="flex-shrink-0">
                                            @if($student->photo)
                                                <img class="h-8 w-8 rounded-full object-cover" 
                                                     src="{{ Storage::url($student->photo) }}" 
                                                     alt="{{ $student->full_name }}">
                                            @else
                                                <div class="h-8 w-8 rounded-full bg-blue-500 flex items-center justify-center">
                                                    <span class="text-xs font-bold text-white">{{ substr($student->full_name, 0, 1) }}</span>
                                                </div>
                                            @endif
                                        </div>
                                        
                                        <div class="flex-1 min-w-0">
                                            <div class="flex items-center space-x-2">
                                                <p class="text-sm font-medium text-gray-900 truncate">{{ $student->full_name }}</p>
                                            </div>
                                            <div class="flex items-center space-x-2 text-xs text-gray-500">
                                                <span>{{ $student->phone }}</span>
                                                @if($student->course)
                                                    <span class="px-1.5 py-0.5 bg-blue-100 text-blue-800 rounded">{{ $student->course->name }}</span>
                                                @endif
                                                @if($student->batch)
                                                    <span class="px-1.5 py-0.5 bg-green-100 text-green-800 rounded">{{ $student->batch->name }}</span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="text-right text-xs text-gray-500">
                                        @if($student->class_grade)
                                            <p class="font-medium">{{ $student->class_grade }}</p>
                                        @endif
                                        @if($student->school_college)
                                            <p class="truncate max-w-[150px]">{{ $student->school_college }}</p>
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
    
    function updateSelectedCount() {
        const checkboxes = document.querySelectorAll('.student-checkbox');
        const checkedCount = document.querySelectorAll('.student-checkbox:checked').length;
        const selectedCountElement = document.getElementById('selected-count');
        
        if (selectedCountElement) {
            selectedCountElement.textContent = checkedCount;
        }
    }
</script>
@endpush
@endsection
