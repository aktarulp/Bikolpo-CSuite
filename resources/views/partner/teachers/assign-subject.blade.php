@extends('layouts.partner-layout')

@section('title', 'Assign Subjects to Teacher')

@section('content')
<div class="flex-1 overflow-y-auto custom-scrollbar bg-gray-50 dark:bg-gray-900 min-h-screen p-3 sm:p-4 lg:p-6">
    <div class="max-w-6xl mx-auto">

        <!-- Page Header -->
        <div class="mb-6 sm:mb-8">
            <div class="flex flex-col sm:flex-row sm:items-center gap-4 mb-6">
                <div class="flex items-center gap-3">
                    <a href="{{ route('partner.teachers.show', $teacher) }}" 
                       class="w-10 h-10 bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 flex items-center justify-center hover:bg-gray-50 dark:hover:bg-gray-700 transition-all duration-200 group">
                        <i class="fas fa-arrow-left text-gray-500 dark:text-gray-400 group-hover:text-purple-600 dark:group-hover:text-purple-400 transition-colors"></i>
                    </a>
                    <div class="flex items-center gap-3">
                        <div class="w-12 h-12 bg-gradient-to-r from-purple-500 to-violet-600 rounded-xl flex items-center justify-center shadow-lg">
                            <i class="fas fa-clipboard-list text-white text-lg"></i>
                        </div>
                        <div>
                            <h1 class="text-xl sm:text-2xl lg:text-3xl font-bold text-gray-900 dark:text-white">Assign Subjects</h1>
                            <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">Assign subjects to {{ $teacher->full_name }}</p>
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
                            <p class="text-sm text-purple-600 dark:text-purple-400 font-medium mt-1">{{ $teacher->designation }}</p>
                        @endif
                        @if($teacher->subject_specialization)
                            <p class="text-xs text-gray-600 dark:text-gray-400 mt-1">Specialization: {{ $teacher->subject_specialization }}</p>
                        @endif
                    </div>
                    
                    <div class="space-y-3 text-sm">
                        <div class="flex justify-between">
                            <span class="text-gray-600 dark:text-gray-400">Current Subjects:</span>
                            <span class="font-medium text-gray-900 dark:text-white">{{ $teacher->subjects->count() }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600 dark:text-gray-400">Available Subjects:</span>
                            <span class="font-medium text-gray-900 dark:text-white">{{ $availableSubjects->count() }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Assignment Form -->
            <div class="lg:col-span-2">
                <form action="{{ route('partner.teachers.assign-subject.store', $teacher) }}" method="POST">
                    @csrf
                    
                    <!-- Available Subjects -->
                    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden mb-6">
                        <div class="bg-gradient-to-r from-purple-50 to-violet-50 dark:from-purple-900/20 dark:to-violet-900/20 px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 bg-purple-100 dark:bg-purple-900/50 rounded-lg flex items-center justify-center">
                                        <i class="fas fa-clipboard-list text-purple-600 dark:text-purple-400 text-sm"></i>
                                    </div>
                                    <div>
                                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Available Subjects</h3>
                                        <p class="text-sm text-gray-600 dark:text-gray-400">Select subjects to assign</p>
                                    </div>
                                </div>
                                <div class="flex gap-2">
                                    <button type="button" onclick="selectAllSubjects()" class="text-sm text-purple-600 hover:text-purple-700 dark:text-purple-400 font-medium">Select All</button>
                                    <button type="button" onclick="deselectAllSubjects()" class="text-sm text-gray-600 hover:text-gray-700 dark:text-gray-400 font-medium">Deselect All</button>
                                </div>
                            </div>
                        </div>
                        
                        <div class="p-6">
                            @if($availableSubjects->count() > 0)
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                    @foreach($availableSubjects as $subject)
                                        <label class="flex items-start p-4 border border-gray-200 dark:border-gray-700 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 cursor-pointer transition-colors">
                                            <input type="checkbox" name="subject_ids[]" value="{{ $subject->id }}" 
                                                   class="w-4 h-4 text-purple-600 bg-gray-100 border-gray-300 rounded focus:ring-purple-500 dark:focus:ring-purple-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600 mt-1">
                                            <div class="ml-3 flex-1">
                                                <div class="flex items-start justify-between">
                                                    <div class="flex-1">
                                                        <h4 class="text-base font-medium text-gray-900 dark:text-white">{{ $subject->name }}</h4>
                                                        @if($subject->description)
                                                            <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">{{ Str::limit($subject->description, 80) }}</p>
                                                        @endif
                                                        <div class="flex items-center gap-3 mt-2 text-xs text-gray-500">
                                                            @if($subject->course)
                                                                <span class="inline-flex items-center px-2 py-1 rounded-full bg-blue-100 dark:bg-blue-900/30 text-blue-800 dark:text-blue-300">
                                                                    <i class="fas fa-book mr-1"></i>{{ $subject->course->name }}
                                                                </span>
                                                            @endif
                                                            @if($subject->topics->count() > 0)
                                                                <span><i class="fas fa-list mr-1"></i>{{ $subject->topics->count() }} topics</span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </label>
                                    @endforeach
                                </div>
                            @else
                                <div class="text-center py-8">
                                    <div class="w-16 h-16 bg-gray-100 dark:bg-gray-700 rounded-full flex items-center justify-center mx-auto mb-4">
                                        <i class="fas fa-clipboard-list text-2xl text-gray-400"></i>
                                    </div>
                                    <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-2">No Available Subjects</h3>
                                    <p class="text-gray-600 dark:text-gray-400">All subjects are already assigned to this teacher.</p>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Currently Assigned Subjects -->
                    @if($teacher->subjects->count() > 0)
                        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden mb-6">
                            <div class="bg-gradient-to-r from-indigo-50 to-blue-50 dark:from-indigo-900/20 dark:to-blue-900/20 px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 bg-indigo-100 dark:bg-indigo-900/50 rounded-lg flex items-center justify-center">
                                        <i class="fas fa-check text-indigo-600 dark:text-indigo-400 text-sm"></i>
                                    </div>
                                    <div>
                                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Currently Assigned Subjects</h3>
                                        <p class="text-sm text-gray-600 dark:text-gray-400">{{ $teacher->subjects->count() }} subjects assigned</p>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="p-6">
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                    @foreach($teacher->subjects as $subject)
                                        <div class="p-4 bg-indigo-50 dark:bg-indigo-900/20 border border-indigo-200 dark:border-indigo-800 rounded-lg">
                                            <div class="flex items-start justify-between">
                                                <div class="flex-1">
                                                    <h4 class="text-base font-medium text-gray-900 dark:text-white">{{ $subject->name }}</h4>
                                                    @if($subject->description)
                                                        <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">{{ Str::limit($subject->description, 60) }}</p>
                                                    @endif
                                                    <div class="flex items-center gap-3 mt-2 text-xs text-gray-500">
                                                        @if($subject->course)
                                                            <span class="inline-flex items-center px-2 py-1 rounded-full bg-blue-100 dark:bg-blue-900/30 text-blue-800 dark:text-blue-300">
                                                                <i class="fas fa-book mr-1"></i>{{ $subject->course->name }}
                                                            </span>
                                                        @endif
                                                        @if($subject->topics->count() > 0)
                                                            <span><i class="fas fa-list mr-1"></i>{{ $subject->topics->count() }} topics</span>
                                                        @endif
                                                    </div>
                                                </div>
                                                <i class="fas fa-check-circle text-indigo-500 text-lg"></i>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @endif

                    <!-- Form Actions -->
                    @if($availableSubjects->count() > 0)
                        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
                            <div class="flex flex-col sm:flex-row gap-4 justify-between items-center">
                                <div class="text-sm text-gray-600 dark:text-gray-400">
                                    <i class="fas fa-info-circle mr-1"></i>
                                    Select subjects to assign to this teacher
                                </div>
                                <div class="flex flex-col sm:flex-row gap-3 w-full sm:w-auto">
                                    <a href="{{ route('partner.teachers.show', $teacher) }}" 
                                       class="px-6 py-3 bg-gray-100 hover:bg-gray-200 dark:bg-gray-700 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-300 font-medium rounded-lg transition-colors duration-200 text-center">
                                        Cancel
                                    </a>
                                    <button type="submit" 
                                            class="px-8 py-3 bg-gradient-to-r from-purple-600 to-violet-600 hover:from-purple-700 hover:to-violet-700 text-white font-semibold rounded-lg shadow-lg hover:shadow-xl transition-all duration-300">
                                        <i class="fas fa-clipboard-list mr-2"></i>
                                        Assign Selected Subjects
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
function selectAllSubjects() {
    const checkboxes = document.querySelectorAll('input[name="subject_ids[]"]');
    checkboxes.forEach(checkbox => checkbox.checked = true);
}

function deselectAllSubjects() {
    const checkboxes = document.querySelectorAll('input[name="subject_ids[]"]');
    checkboxes.forEach(checkbox => checkbox.checked = false);
}
</script>
@endsection
