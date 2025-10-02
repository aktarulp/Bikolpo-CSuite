@extends('layouts.partner-layout')

@section('title', 'Assign Courses to Teacher')

@section('content')
<div class="flex-1 overflow-y-auto custom-scrollbar bg-gray-50 dark:bg-gray-900 min-h-screen p-3 sm:p-4 lg:p-6">
    <div class="max-w-6xl mx-auto">

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
                            <i class="fas fa-book text-white text-lg"></i>
                        </div>
                        <div>
                            <h1 class="text-xl sm:text-2xl lg:text-3xl font-bold text-gray-900 dark:text-white">Assign Courses</h1>
                            <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">Assign courses to {{ $teacher->full_name }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Teacher Info -->
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
                    
                    <div class="space-y-3 text-sm">
                        <div class="flex justify-between">
                            <span class="text-gray-600 dark:text-gray-400">Current Courses:</span>
                            <span class="font-medium text-gray-900 dark:text-white">{{ $teacher->courses->count() }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600 dark:text-gray-400">Available Courses:</span>
                            <span class="font-medium text-gray-900 dark:text-white">{{ $availableCourses->count() }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Assignment Form -->
            <div class="lg:col-span-2">
                <form action="{{ route('partner.teachers.assign-course.store', $teacher) }}" method="POST">
                    @csrf
                    
                    <!-- Available Courses -->
                    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden mb-6">
                        <div class="bg-gradient-to-r from-green-50 to-emerald-50 dark:from-green-900/20 dark:to-emerald-900/20 px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 bg-green-100 dark:bg-green-900/50 rounded-lg flex items-center justify-center">
                                        <i class="fas fa-book text-green-600 dark:text-green-400 text-sm"></i>
                                    </div>
                                    <div>
                                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Available Courses</h3>
                                        <p class="text-sm text-gray-600 dark:text-gray-400">Select courses to assign</p>
                                    </div>
                                </div>
                                <div class="flex gap-2">
                                    <button type="button" onclick="selectAllCourses()" class="text-sm text-green-600 hover:text-green-700 dark:text-green-400 font-medium">Select All</button>
                                    <button type="button" onclick="deselectAllCourses()" class="text-sm text-gray-600 hover:text-gray-700 dark:text-gray-400 font-medium">Deselect All</button>
                                </div>
                            </div>
                        </div>
                        
                        <div class="p-6">
                            @if($availableCourses->count() > 0)
                                <div class="grid grid-cols-1 gap-4">
                                    @foreach($availableCourses as $course)
                                        <label class="flex items-center p-4 border border-gray-200 dark:border-gray-700 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 cursor-pointer transition-colors">
                                            <input type="checkbox" name="course_ids[]" value="{{ $course->id }}" 
                                                   class="w-4 h-4 text-green-600 bg-gray-100 border-gray-300 rounded focus:ring-green-500 dark:focus:ring-green-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                            <div class="ml-4 flex-1">
                                                <div class="flex items-center justify-between">
                                                    <div>
                                                        <h4 class="text-lg font-medium text-gray-900 dark:text-white">{{ $course->name }}</h4>
                                                        <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">{{ $course->description ?? 'No description available' }}</p>
                                                        <div class="flex items-center gap-4 mt-2 text-xs text-gray-500">
                                                            <span><i class="fas fa-clock mr-1"></i>{{ $course->duration ?? 'N/A' }}</span>
                                                            <span><i class="fas fa-users mr-1"></i>{{ $course->students->count() }} students</span>
                                                            @if($course->subjects->count() > 0)
                                                                <span><i class="fas fa-book-open mr-1"></i>{{ $course->subjects->count() }} subjects</span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <div class="text-right">
                                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-300">
                                                            {{ $course->status ?? 'Active' }}
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </label>
                                    @endforeach
                                </div>
                            @else
                                <div class="text-center py-8">
                                    <div class="w-16 h-16 bg-gray-100 dark:bg-gray-700 rounded-full flex items-center justify-center mx-auto mb-4">
                                        <i class="fas fa-book text-2xl text-gray-400"></i>
                                    </div>
                                    <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-2">No Available Courses</h3>
                                    <p class="text-gray-600 dark:text-gray-400">All courses are already assigned to this teacher.</p>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Currently Assigned Courses -->
                    @if($teacher->courses->count() > 0)
                        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden mb-6">
                            <div class="bg-gradient-to-r from-blue-50 to-indigo-50 dark:from-blue-900/20 dark:to-indigo-900/20 px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 bg-blue-100 dark:bg-blue-900/50 rounded-lg flex items-center justify-center">
                                        <i class="fas fa-check text-blue-600 dark:text-blue-400 text-sm"></i>
                                    </div>
                                    <div>
                                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Currently Assigned Courses</h3>
                                        <p class="text-sm text-gray-600 dark:text-gray-400">{{ $teacher->courses->count() }} courses assigned</p>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="p-6">
                                <div class="grid grid-cols-1 gap-4">
                                    @foreach($teacher->courses as $course)
                                        <div class="flex items-center p-4 bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg">
                                            <div class="flex-1">
                                                <h4 class="text-lg font-medium text-gray-900 dark:text-white">{{ $course->name }}</h4>
                                                <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">{{ $course->description ?? 'No description available' }}</p>
                                                <div class="flex items-center gap-4 mt-2 text-xs text-gray-500">
                                                    <span><i class="fas fa-users mr-1"></i>{{ $course->students->count() }} students</span>
                                                    @if($course->subjects->count() > 0)
                                                        <span><i class="fas fa-book-open mr-1"></i>{{ $course->subjects->count() }} subjects</span>
                                                    @endif
                                                </div>
                                            </div>
                                            <i class="fas fa-check-circle text-blue-500 text-xl"></i>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @endif

                    <!-- Form Actions -->
                    @if($availableCourses->count() > 0)
                        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
                            <div class="flex flex-col sm:flex-row gap-4 justify-between items-center">
                                <div class="text-sm text-gray-600 dark:text-gray-400">
                                    <i class="fas fa-info-circle mr-1"></i>
                                    Select courses to assign to this teacher
                                </div>
                                <div class="flex flex-col sm:flex-row gap-3 w-full sm:w-auto">
                                    <a href="{{ route('partner.teachers.show', $teacher) }}" 
                                       class="px-6 py-3 bg-gray-100 hover:bg-gray-200 dark:bg-gray-700 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-300 font-medium rounded-lg transition-colors duration-200 text-center">
                                        Cancel
                                    </a>
                                    <button type="submit" 
                                            class="px-8 py-3 bg-gradient-to-r from-green-600 to-emerald-600 hover:from-green-700 hover:to-emerald-700 text-white font-semibold rounded-lg shadow-lg hover:shadow-xl transition-all duration-300">
                                        <i class="fas fa-book mr-2"></i>
                                        Assign Selected Courses
                                    </button>
                                </div>
                            </div>
                        </div>
                    @endif
                </form>
            </div>
        </div>
    </div>
</div>

<script>
function selectAllCourses() {
    const checkboxes = document.querySelectorAll('input[name="course_ids[]"]');
    checkboxes.forEach(checkbox => checkbox.checked = true);
}

function deselectAllCourses() {
    const checkboxes = document.querySelectorAll('input[name="course_ids[]"]');
    checkboxes.forEach(checkbox => checkbox.checked = false);
}
</script>
@endsection
