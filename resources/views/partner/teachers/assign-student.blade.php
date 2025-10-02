@extends('layouts.partner-layout')

@section('title', 'Assign Students to Teacher')

@section('content')
<div class="flex-1 overflow-y-auto custom-scrollbar bg-gray-50 dark:bg-gray-900 min-h-screen p-3 sm:p-4 lg:p-6">
    <div class="max-w-6xl mx-auto">

        <!-- Page Header -->
        <div class="mb-6 sm:mb-8">
            <div class="flex flex-col sm:flex-row sm:items-center gap-4 mb-6">
                <div class="flex items-center gap-3">
                    <a href="{{ route('partner.teachers.show', $teacher) }}" 
                       class="w-10 h-10 bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 flex items-center justify-center hover:bg-gray-50 dark:hover:bg-gray-700 transition-all duration-200 group">
                        <i class="fas fa-arrow-left text-gray-500 dark:text-gray-400 group-hover:text-blue-600 dark:group-hover:text-blue-400 transition-colors"></i>
                    </a>
                    <div class="flex items-center gap-3">
                        <div class="w-12 h-12 bg-gradient-to-r from-blue-500 to-indigo-600 rounded-xl flex items-center justify-center shadow-lg">
                            <i class="fas fa-user-graduate text-white text-lg"></i>
                        </div>
                        <div>
                            <h1 class="text-xl sm:text-2xl lg:text-3xl font-bold text-gray-900 dark:text-white">Assign Students</h1>
                            <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">Assign students to {{ $teacher->full_name }}</p>
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
                            <p class="text-sm text-blue-600 dark:text-blue-400 font-medium mt-1">{{ $teacher->designation }}</p>
                        @endif
                    </div>
                    
                    <div class="space-y-3 text-sm">
                        <div class="flex justify-between">
                            <span class="text-gray-600 dark:text-gray-400">Current Students:</span>
                            <span class="font-medium text-gray-900 dark:text-white">{{ $teacher->students->count() }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600 dark:text-gray-400">Available Students:</span>
                            <span class="font-medium text-gray-900 dark:text-white">{{ $availableStudents->count() }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Assignment Form -->
            <div class="lg:col-span-2">
                <form action="{{ route('partner.teachers.assign-student.store', $teacher) }}" method="POST">
                    @csrf
                    
                    <!-- Available Students -->
                    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden mb-6">
                        <div class="bg-gradient-to-r from-blue-50 to-indigo-50 dark:from-blue-900/20 dark:to-indigo-900/20 px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 bg-blue-100 dark:bg-blue-900/50 rounded-lg flex items-center justify-center">
                                        <i class="fas fa-user-graduate text-blue-600 dark:text-blue-400 text-sm"></i>
                                    </div>
                                    <div>
                                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Available Students</h3>
                                        <p class="text-sm text-gray-600 dark:text-gray-400">Select students to assign</p>
                                    </div>
                                </div>
                                <div class="flex gap-2">
                                    <button type="button" onclick="selectAll()" class="text-sm text-blue-600 hover:text-blue-700 dark:text-blue-400 font-medium">Select All</button>
                                    <button type="button" onclick="deselectAll()" class="text-sm text-gray-600 hover:text-gray-700 dark:text-gray-400 font-medium">Deselect All</button>
                                </div>
                            </div>
                        </div>
                        
                        <div class="p-6">
                            @if($availableStudents->count() > 0)
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                    @foreach($availableStudents as $student)
                                        <label class="flex items-center p-4 border border-gray-200 dark:border-gray-700 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 cursor-pointer transition-colors">
                                            <input type="checkbox" name="student_ids[]" value="{{ $student->id }}" 
                                                   class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                            <div class="ml-3 flex-1">
                                                <div class="flex items-center gap-3">
                                                    <div class="w-10 h-10 rounded-full bg-blue-100 dark:bg-blue-900/30 flex items-center justify-center">
                                                        <span class="text-sm font-medium text-blue-600 dark:text-blue-400">{{ substr($student->name, 0, 1) }}</span>
                                                    </div>
                                                    <div>
                                                        <p class="text-sm font-medium text-gray-900 dark:text-white">{{ $student->name }}</p>
                                                        <p class="text-xs text-gray-500 dark:text-gray-400">{{ $student->student_id }}</p>
                                                        @if($student->course)
                                                            <p class="text-xs text-blue-600 dark:text-blue-400">{{ $student->course->name }}</p>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </label>
                                    @endforeach
                                </div>
                            @else
                                <div class="text-center py-8">
                                    <div class="w-16 h-16 bg-gray-100 dark:bg-gray-700 rounded-full flex items-center justify-center mx-auto mb-4">
                                        <i class="fas fa-user-graduate text-2xl text-gray-400"></i>
                                    </div>
                                    <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-2">No Available Students</h3>
                                    <p class="text-gray-600 dark:text-gray-400">All students are already assigned to teachers.</p>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Currently Assigned Students -->
                    @if($teacher->students->count() > 0)
                        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden mb-6">
                            <div class="bg-gradient-to-r from-green-50 to-emerald-50 dark:from-green-900/20 dark:to-emerald-900/20 px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 bg-green-100 dark:bg-green-900/50 rounded-lg flex items-center justify-center">
                                        <i class="fas fa-check text-green-600 dark:text-green-400 text-sm"></i>
                                    </div>
                                    <div>
                                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Currently Assigned Students</h3>
                                        <p class="text-sm text-gray-600 dark:text-gray-400">{{ $teacher->students->count() }} students assigned</p>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="p-6">
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                    @foreach($teacher->students as $student)
                                        <div class="flex items-center p-4 bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 rounded-lg">
                                            <div class="flex items-center gap-3 flex-1">
                                                <div class="w-10 h-10 rounded-full bg-green-100 dark:bg-green-900/30 flex items-center justify-center">
                                                    <span class="text-sm font-medium text-green-600 dark:text-green-400">{{ substr($student->name, 0, 1) }}</span>
                                                </div>
                                                <div>
                                                    <p class="text-sm font-medium text-gray-900 dark:text-white">{{ $student->name }}</p>
                                                    <p class="text-xs text-gray-500 dark:text-gray-400">{{ $student->student_id }}</p>
                                                </div>
                                            </div>
                                            <i class="fas fa-check-circle text-green-500"></i>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @endif

                    <!-- Form Actions -->
                    @if($availableStudents->count() > 0)
                        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
                            <div class="flex flex-col sm:flex-row gap-4 justify-between items-center">
                                <div class="text-sm text-gray-600 dark:text-gray-400">
                                    <i class="fas fa-info-circle mr-1"></i>
                                    Select students to assign to this teacher
                                </div>
                                <div class="flex flex-col sm:flex-row gap-3 w-full sm:w-auto">
                                    <a href="{{ route('partner.teachers.show', $teacher) }}" 
                                       class="px-6 py-3 bg-gray-100 hover:bg-gray-200 dark:bg-gray-700 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-300 font-medium rounded-lg transition-colors duration-200 text-center">
                                        Cancel
                                    </a>
                                    <button type="submit" 
                                            class="px-8 py-3 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white font-semibold rounded-lg shadow-lg hover:shadow-xl transition-all duration-300">
                                        <i class="fas fa-user-plus mr-2"></i>
                                        Assign Selected Students
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
function selectAll() {
    const checkboxes = document.querySelectorAll('input[name="student_ids[]"]');
    checkboxes.forEach(checkbox => checkbox.checked = true);
}

function deselectAll() {
    const checkboxes = document.querySelectorAll('input[name="student_ids[]"]');
    checkboxes.forEach(checkbox => checkbox.checked = false);
}
</script>
@endsection
