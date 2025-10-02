@extends('layouts.partner-layout')

@section('title', 'Manage Teacher Assignments')

@section('content')
<div class="flex-1 overflow-y-auto custom-scrollbar bg-gray-50 dark:bg-gray-900 min-h-screen p-3 sm:p-4 lg:p-6">
    <div class="max-w-7xl mx-auto">

        <!-- Page Header -->
        <div class="mb-6 sm:mb-8">
            <div class="flex flex-col sm:flex-row sm:items-center gap-4 mb-6">
                <div class="flex items-center gap-3">
                    <a href="{{ route('partner.teachers.show', $teacher) }}" 
                       class="w-10 h-10 bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 flex items-center justify-center hover:bg-gray-50 dark:hover:bg-gray-700 transition-all duration-200 group">
                        <i class="fas fa-arrow-left text-gray-500 dark:text-gray-400 group-hover:text-green-600 dark:group-hover:text-green-400 transition-colors"></i>
                    </a>
                    <div class="flex items-center gap-3">
                        <div class="w-12 h-12 bg-gradient-to-r from-green-500 to-emerald-600 rounded-xl flex items-center justify-center shadow-lg">
                            <i class="fas fa-tasks text-white text-lg"></i>
                        </div>
                        <div>
                            <h1 class="text-xl sm:text-2xl lg:text-3xl font-bold text-gray-900 dark:text-white">Manage Assignments</h1>
                            <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">Assign and manage resources for {{ $teacher->full_name }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-4 gap-6">
            <!-- Teacher Profile Sidebar -->
            <div class="lg:col-span-1">
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6 sticky top-6">
                    <div class="text-center mb-6">
                        <div class="w-20 h-20 rounded-full mx-auto mb-4 overflow-hidden bg-gray-100 dark:bg-gray-700">
                            @if($teacher->photo)
                                <img src="{{ $teacher->photo_url }}" alt="{{ $teacher->full_name }}" class="w-full h-full object-cover">
                            @else
                                <div class="w-full h-full flex items-center justify-center">
                                    <span class="text-2xl">{{ $teacher->getGenderIcon() }}</span>
                                </div>
                            @endif
                        </div>
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">{{ $teacher->full_name }}</h3>
                        <p class="text-sm text-gray-500 dark:text-gray-400">{{ $teacher->teacher_id }}</p>
                        @if($teacher->designation)
                            <p class="text-sm text-green-600 dark:text-green-400 font-medium mt-1">{{ $teacher->designation }}</p>
                        @endif
                    </div>
                    
                    <!-- Assignment Stats -->
                    <div class="space-y-3 text-sm">
                        <div class="flex justify-between items-center p-3 bg-blue-50 dark:bg-blue-900/20 rounded-lg">
                            <span class="text-gray-600 dark:text-gray-400">Courses</span>
                            <span class="font-bold text-blue-600 dark:text-blue-400">{{ $teacher->courses->count() }}</span>
                        </div>
                        <div class="flex justify-between items-center p-3 bg-purple-50 dark:bg-purple-900/20 rounded-lg">
                            <span class="text-gray-600 dark:text-gray-400">Subjects</span>
                            <span class="font-bold text-purple-600 dark:text-purple-400">{{ $teacher->subjects->count() }}</span>
                        </div>
                        <div class="flex justify-between items-center p-3 bg-green-50 dark:bg-green-900/20 rounded-lg">
                            <span class="text-gray-600 dark:text-gray-400">Students</span>
                            <span class="font-bold text-green-600 dark:text-green-400">{{ $teacher->students->count() }}</span>
                        </div>
                        <div class="flex justify-between items-center p-3 bg-orange-50 dark:bg-orange-900/20 rounded-lg">
                            <span class="text-gray-600 dark:text-gray-400">Batches</span>
                            <span class="font-bold text-orange-600 dark:text-orange-400">{{ $teacher->batches->count() }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Assignment Management -->
            <div class="lg:col-span-3 space-y-6">

                <!-- Current Assignments Form -->
                <form action="{{ route('partner.teachers.assignments.update', $teacher) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <!-- Courses Assignment -->
                    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden mb-6">
                        <div class="bg-gradient-to-r from-blue-50 to-indigo-50 dark:from-blue-900/20 dark:to-indigo-900/20 px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 bg-blue-100 dark:bg-blue-900/50 rounded-lg flex items-center justify-center">
                                    <i class="fas fa-book text-blue-600 dark:text-blue-400 text-sm"></i>
                                </div>
                                <div>
                                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Course Assignments</h3>
                                    <p class="text-sm text-gray-600 dark:text-gray-400">Select courses for this teacher</p>
                                </div>
                            </div>
                        </div>
                        <div class="p-6">
                            @if($courses->count() > 0)
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                    @foreach($courses as $course)
                                        <label class="flex items-center p-3 border border-gray-200 dark:border-gray-700 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 cursor-pointer">
                                            <input type="checkbox" name="courses[]" value="{{ $course->id }}" 
                                                   {{ $teacher->courses->contains($course->id) ? 'checked' : '' }}
                                                   class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500">
                                            <div class="ml-3">
                                                <p class="text-sm font-medium text-gray-900 dark:text-white">{{ $course->name }}</p>
                                                <p class="text-xs text-gray-500 dark:text-gray-400">{{ $course->students->count() }} students</p>
                                            </div>
                                        </label>
                                    @endforeach
                                </div>
                            @else
                                <p class="text-gray-500 dark:text-gray-400 text-center py-4">No courses available</p>
                            @endif
                        </div>
                    </div>

                    <!-- Subjects Assignment -->
                    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden mb-6">
                        <div class="bg-gradient-to-r from-purple-50 to-violet-50 dark:from-purple-900/20 dark:to-violet-900/20 px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 bg-purple-100 dark:bg-purple-900/50 rounded-lg flex items-center justify-center">
                                    <i class="fas fa-clipboard-list text-purple-600 dark:text-purple-400 text-sm"></i>
                                </div>
                                <div>
                                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Subject Assignments</h3>
                                    <p class="text-sm text-gray-600 dark:text-gray-400">Select subjects for this teacher</p>
                                </div>
                            </div>
                        </div>
                        <div class="p-6">
                            {{-- SECURITY: All data is filtered by partner_id in controller --}}
                            {{-- Only courses, subjects, students, and batches from current partner are shown --}}
                            @if($subjects->count() > 0)
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                    @foreach($subjects as $subject)
                                        <label class="subject-item flex items-center p-3 border border-gray-200 dark:border-gray-700 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 cursor-pointer"
                                               data-course="{{ $subject->course_id }}"
                                               style="display: none;">
                                            <input type="checkbox" name="subjects[]" value="{{ $subject->id }}"
                                                   {{ $teacher->subjects->contains($subject->id) ? 'checked' : '' }}
                                                   class="w-4 h-4 text-purple-600 bg-gray-100 border-gray-300 rounded focus:ring-purple-500">
                                            <div class="ml-3">
                                                <p class="text-sm font-medium text-gray-900 dark:text-white">{{ $subject->name }}</p>
                                                @if($subject->course)
                                                    <p class="text-xs text-gray-500 dark:text-gray-400">{{ $subject->course->name }} - {{ $subject->code }}</p>
                                                @endif
                                            </div>
                                        </label>
                                    @endforeach
                                </div>
                                <div id="no-subjects-message" class="hidden text-gray-500 dark:text-gray-400 text-center py-4">
                                    No subjects available for the selected courses
                                </div>
                            @else
                                <div class="text-center py-8">
                                    <i class="fas fa-clipboard-list text-gray-300 text-3xl mb-3"></i>
                                    <p class="text-gray-500 dark:text-gray-400 mb-2">No subjects available</p>
                                    <p class="text-sm text-gray-400 dark:text-gray-500">Please assign courses first to see available subjects</p>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Students Assignment -->
                    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden mb-6">
                        <div class="bg-gradient-to-r from-green-50 to-emerald-50 dark:from-green-900/20 dark:to-emerald-900/20 px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 bg-green-100 dark:bg-green-900/50 rounded-lg flex items-center justify-center">
                                        <i class="fas fa-user-graduate text-green-600 dark:text-green-400 text-sm"></i>
                                    </div>
                                    <div>
                                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Student Assignments</h3>
                                        <p class="text-sm text-gray-600 dark:text-gray-400">Select students for this teacher</p>
                                    </div>
                                </div>
                                <!-- Batch Filter -->
                                <div class="flex items-center gap-2">
                                    <label for="batch-filter" class="text-sm font-medium text-gray-700 dark:text-gray-300">Filter by Batch:</label>
                                    <select id="batch-filter" class="px-3 py-1.5 border border-gray-300 dark:border-gray-600 rounded-lg text-sm bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-green-500 focus:border-green-500">
                                        <option value="">All Batches</option>
                                        @foreach($batches as $batch)
                                            <option value="{{ $batch->id }}">{{ $batch->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="p-6">
                            @if($students->count() > 0)
                                {{-- Debug: Show student data --}}
                                @php
                                    $debugStudents = $students->take(3); // Show first 3 students for debugging
                                @endphp
                                <div class="mb-4 p-2 bg-gray-100 dark:bg-gray-800 rounded text-xs">
                                    <strong>Debug Info:</strong>
                                    Total Students: {{ $students->count() }} |
                                    Students with course_id: {{ $students->where('course_id', '!=', null)->count() }} |
                                    Teacher courses: {{ $teacher->courses->count() }}
                                </div>

                                <div id="students-container" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 max-h-64 overflow-y-auto">
                                    @foreach($students as $student)
                                        @php
                                            $shouldShow = $student->course_id && $teacher->courses->contains($student->course_id);
                                            $debugInfo = "Name: {$student->full_name}, CourseID: {$student->course_id}, TeacherCourses: " . $teacher->courses->pluck('id')->implode(',');
                                        @endphp
                                        <label class="student-item flex items-center p-3 border border-gray-200 dark:border-gray-700 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 cursor-pointer {{ $shouldShow ? '' : 'opacity-50' }}"
                                               data-batch="{{ $student->batch_id ?? '' }}"
                                               data-course-id="{{ $student->course_id ?? '' }}"
                                               style="display: {{ $shouldShow ? 'flex' : 'none' }};"
                                               title="{{ $debugInfo }}">
                                            <input type="checkbox" name="students[]" value="{{ $student->id }}" 
                                                   {{ $teacher->students->contains($student->id) ? 'checked' : '' }}
                                                   class="w-4 h-4 text-green-600 bg-gray-100 border-gray-300 rounded focus:ring-green-500">
                                            <div class="ml-3 flex-1">
                                                <p class="text-sm font-medium text-gray-900 dark:text-white">
                                                    {{ $student->full_name }}
                                                </p>
                                                <div class="flex items-center justify-between">
                                                    <p class="text-xs text-gray-500 dark:text-gray-400 px-2 py-1 bg-gray-100 dark:bg-gray-800 rounded-md font-mono">
                                                        {{ $student->student_id }}
                                                    </p>
                                                    @if($student->batch)
                                                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-300">
                                                            {{ $student->batch->name }}
                                                        </span>
                                                    @endif
                                                </div>
                                            </div>
                                        </label>
                                    @endforeach
                                </div>
                                <div id="no-students-message" class="hidden text-gray-500 dark:text-gray-400 text-center py-4">
                                    No students found for the selected courses
                                </div>
                            @else
                                <p class="text-gray-500 dark:text-gray-400 text-center py-4">No students available</p>
                            @endif
                        </div>
                    </div>

                    <!-- Form Actions -->
                    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
                        <div class="flex flex-col sm:flex-row gap-4 justify-between items-center">
                            <div class="text-sm text-gray-600 dark:text-gray-400">
                                <i class="fas fa-info-circle mr-1"></i>
                                Select assignments for this teacher and save changes
                            </div>
                            <div class="flex flex-col sm:flex-row gap-3 w-full sm:w-auto">
                                <a href="{{ route('partner.teachers.show', $teacher) }}" 
                                   class="px-6 py-3 bg-gray-100 hover:bg-gray-200 dark:bg-gray-700 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-300 font-medium rounded-lg transition-colors duration-200 text-center">
                                    Cancel
                                </a>
                                <button type="submit" 
                                        class="px-8 py-3 bg-gradient-to-r from-green-600 to-emerald-600 hover:from-green-700 hover:to-emerald-700 text-white font-semibold rounded-lg shadow-lg hover:shadow-xl transition-all duration-300">
                                    <i class="fas fa-save mr-2"></i>
                                    Save All Assignments
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
function assignStudent(teacherId) {
    // You can implement a modal or redirect to assignment page
    alert('Assign Student functionality - Teacher ID: ' + teacherId);
    // Example: window.location.href = `/partner/teachers/${teacherId}/assign-student`;
}

function assignCourse(teacherId) {
    // You can implement a modal or redirect to assignment page
    alert('Assign Course functionality - Teacher ID: ' + teacherId);
    // Example: window.location.href = `/partner/teachers/${teacherId}/assign-course`;
}

function assignSubject(teacherId) {
    // You can implement a modal or redirect to assignment page
    alert('Assign Subject functionality - Teacher ID: ' + teacherId);
    // Example: window.location.href = `/partner/teachers/${teacherId}/assign-subject`;
}

// Batch filter functionality and course-subject filtering
document.addEventListener('DOMContentLoaded', function() {
    const batchFilter = document.getElementById('batch-filter');
    const studentsContainer = document.getElementById('students-container');
    const noStudentsMessage = document.getElementById('no-students-message');
    const courseCheckboxes = document.querySelectorAll('input[name="courses[]"]');
    const subjectItems = document.querySelectorAll('.subject-item');
    const noSubjectsMessage = document.getElementById('no-subjects-message');

    // Function to update subjects visibility based on selected courses
    function updateSubjectsVisibility() {
        const selectedCourseIds = Array.from(courseCheckboxes)
            .filter(checkbox => checkbox.checked)
            .map(checkbox => checkbox.value);

        let visibleSubjectsCount = 0;

        // Handle subject items directly (no course sections)
        subjectItems.forEach(item => {
            const subjectCourseId = item.dataset.course;

            if (selectedCourseIds.length > 0 && selectedCourseIds.includes(subjectCourseId)) {
                item.style.display = 'flex';
                visibleSubjectsCount++;
            } else {
                item.style.display = 'none';
            }
        });

        // Show/hide no subjects message
        if (noSubjectsMessage) {
            if (visibleSubjectsCount === 0 && selectedCourseIds.length > 0) {
                noSubjectsMessage.classList.remove('hidden');
                noSubjectsMessage.textContent = 'No subjects available for the selected courses';
            } else if (selectedCourseIds.length === 0) {
                noSubjectsMessage.classList.remove('hidden');
                noSubjectsMessage.textContent = 'Please select courses to see available subjects';
            } else {
                noSubjectsMessage.classList.add('hidden');
            }
        }
    }

    if (batchFilter && studentsContainer) {
        batchFilter.addEventListener('change', function() {
            const selectedBatchId = this.value;
            const studentItems = studentsContainer.querySelectorAll('.student-item');
            let visibleCount = 0;

            studentItems.forEach(item => {
                const itemBatchId = item.dataset.batch;
                const itemCourseId = item.dataset.courseId;

                // Only show students that are currently visible (from selected courses)
                // and match the selected batch filter
                if (item.style.display === 'flex' &&
                    (selectedBatchId === '' || itemBatchId === selectedBatchId)) {
                    item.style.display = 'flex';
                    visibleCount++;
                } else {
                    item.style.display = 'none';
                }
            });

            // Show/hide no students message
            if (noStudentsMessage) {
                if (visibleCount === 0) {
                    noStudentsMessage.classList.remove('hidden');
                } else {
                    noStudentsMessage.classList.add('hidden');
                }
            }
        });
    }

    // Add event listeners to course checkboxes
    courseCheckboxes.forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            const courseId = this.value;
            const isChecked = this.checked;

            if (!isChecked) {
                // When unchecking a course, uncheck all subjects for that course
                subjectItems.forEach(subjectItem => {
                    const subjectCourseId = subjectItem.dataset.course;
                    if (subjectCourseId === courseId) {
                        const subjectCheckbox = subjectItem.querySelector('input[type="checkbox"]');
                        if (subjectCheckbox) {
                            subjectCheckbox.checked = false;
                        }
                    }
                });

                // When unchecking a course, also uncheck all students for that course
                const studentItems = studentsContainer.querySelectorAll('.student-item');
                studentItems.forEach(studentItem => {
                    const studentCourseId = studentItem.dataset.courseId;
                    if (studentCourseId === courseId) {
                        const studentCheckbox = studentItem.querySelector('input[type="checkbox"]');
                        if (studentCheckbox) {
                            studentCheckbox.checked = false;
                        }
                    }
                });
            }

            updateSubjectsVisibility();

            // Also update students visibility based on selected courses
            const selectedCourseIds = Array.from(courseCheckboxes)
                .filter(cb => cb.checked)
                .map(cb => cb.value);

            const studentItems = studentsContainer.querySelectorAll('.student-item');
            let visibleStudentsCount = 0;

            studentItems.forEach(item => {
                const studentCourseId = item.dataset.courseId;

                if (selectedCourseIds.length === 0 || selectedCourseIds.includes(studentCourseId)) {
                    item.style.display = 'flex';
                    visibleStudentsCount++;
                } else {
                    item.style.display = 'none';
                }
            });

            // Update no students message
            if (noStudentsMessage) {
                if (visibleStudentsCount === 0 && selectedCourseIds.length > 0) {
                    noStudentsMessage.classList.remove('hidden');
                } else {
                    noStudentsMessage.classList.add('hidden');
                }
            }
        });
    });

    // Initialize on page load
    updateSubjectsVisibility();

    // Also initialize students visibility
    const initialCourseCheckboxes = document.querySelectorAll('input[name="courses[]"]:checked');
    if (initialCourseCheckboxes.length > 0) {
        // Trigger course change event to update students
        const courseChangeEvent = new Event('change');
        initialCourseCheckboxes[0].dispatchEvent(courseChangeEvent);
    }
});
</script>
@endsection
