@extends('layouts.partner-layout')

@section('title', 'Teacher Details')

@section('content')
<div class="flex-1 overflow-y-auto custom-scrollbar bg-gray-50 dark:bg-gray-900 min-h-screen p-3 sm:p-4 lg:p-6">
    <div class="max-w-6xl mx-auto">

        <!-- Page Header -->
        <div class="mb-6 sm:mb-8">
            <div class="flex flex-col sm:flex-row sm:items-center gap-4 mb-6">
                <div class="flex items-center gap-3">
                    <a href="{{ route('partner.teachers.index') }}" 
                       class="w-10 h-10 bg-gradient-to-r from-gray-100 to-gray-200 dark:from-gray-700 dark:to-gray-600 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 flex items-center justify-center hover:from-gray-200 hover:to-gray-300 dark:hover:from-gray-600 dark:hover:to-gray-500 transition-all duration-200 group">
                        <svg class="w-5 h-5 text-gray-700 dark:text-gray-200 group-hover:text-blue-600 dark:group-hover:text-blue-400 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                    </a>
                    <div class="flex items-center gap-3">
                        <div class="w-12 h-12 bg-gradient-to-r from-teal-500 to-cyan-600 rounded-xl flex items-center justify-center shadow-lg">
                            <i class="fas fa-chalkboard-teacher text-white text-lg"></i>
                        </div>
                        <div>
                            <h1 class="text-xl sm:text-2xl lg:text-3xl font-bold text-gray-900 dark:text-white">Teacher Details</h1>
                            <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">Complete teacher profile information</p>
                        </div>
                    </div>
                </div>
                <div class="flex flex-col sm:flex-row gap-3 sm:ml-auto">
                    <a href="{{ route('partner.teachers.edit', $teacher) }}" 
                       class="inline-flex items-center justify-center px-4 py-2.5 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg shadow-sm transition-colors duration-200">
                        <i class="fas fa-edit mr-2"></i>
                        Edit Teacher
                    </a>
                    
                    <a href="{{ route('partner.teachers.assignments', $teacher) }}" 
                       class="inline-flex items-center justify-center px-4 py-2.5 bg-green-600 hover:bg-green-700 text-white font-medium rounded-lg shadow-sm transition-colors duration-200">
                        <i class="fas fa-tasks mr-2"></i>
                        Assignments
                    </a>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Left Column - Teacher Profile -->
            <div class="lg:col-span-1 space-y-6">
                <!-- Profile Card -->
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
                    <div class="relative h-32 bg-gradient-to-r from-teal-500 to-cyan-600">
                        <div class="absolute inset-0 bg-black bg-opacity-20"></div>
                    </div>
                    <div class="relative px-6 pb-6">
                        <div class="flex flex-col items-center -mt-16">
                            <div class="w-24 h-24 rounded-full border-4 border-white dark:border-gray-800 shadow-lg overflow-hidden bg-white">
                                @if($teacher->photo)
                                    <img src="{{ $teacher->photo_url }}" alt="{{ $teacher->full_name }}" class="w-full h-full object-cover">
                                @else
                                    <div class="w-full h-full flex items-center justify-center bg-gray-100 dark:bg-gray-700">
                                        <span class="text-3xl">{{ $teacher->getGenderIcon() }}</span>
                                    </div>
                                @endif
                            </div>
                            <div class="text-center mt-4">
                                <h2 class="text-xl font-bold text-gray-900 dark:text-white">{{ $teacher->full_name }}</h2>
                                <p class="text-sm text-gray-500 dark:text-gray-400">{{ $teacher->teacher_id }}</p>
                                @if($teacher->designation)
                                    <p class="text-sm font-medium text-teal-600 dark:text-teal-400 mt-1">{{ $teacher->designation }}</p>
                                @endif
                                <div class="mt-3">
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium {{ $teacher->getStatusBadgeClass() }}">
                                        {{ $teacher->status }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Quick Stats -->
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Quick Stats</h3>
                    <div class="grid grid-cols-2 gap-4">
                        <div class="text-center p-3 bg-blue-50 dark:bg-blue-900/20 rounded-lg">
                            <div class="text-2xl font-bold text-blue-600 dark:text-blue-400">{{ $teacher->courses->count() }}</div>
                            <div class="text-xs text-gray-600 dark:text-gray-400">Courses</div>
                        </div>
                        <div class="text-center p-3 bg-green-50 dark:bg-green-900/20 rounded-lg">
                            <div class="text-2xl font-bold text-green-600 dark:text-green-400">{{ $teacher->subjects->count() }}</div>
                            <div class="text-xs text-gray-600 dark:text-gray-400">Subjects</div>
                        </div>
                        <div class="text-center p-3 bg-purple-50 dark:bg-purple-900/20 rounded-lg">
                            <div class="text-2xl font-bold text-purple-600 dark:text-purple-400">{{ $teacher->students->count() }}</div>
                            <div class="text-xs text-gray-600 dark:text-gray-400">Students</div>
                        </div>
                        <div class="text-center p-3 bg-orange-50 dark:bg-orange-900/20 rounded-lg">
                            <div class="text-2xl font-bold text-orange-600 dark:text-orange-400">{{ $teacher->batches->count() }}</div>
                            <div class="text-xs text-gray-600 dark:text-gray-400">Batches</div>
                        </div>
                    </div>
                </div>

                <!-- Contact Information -->
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Contact Information</h3>
                    <div class="space-y-3">
                        <div class="flex items-center">
                            <i class="fas fa-phone w-5 text-gray-400 mr-3"></i>
                            <span class="text-gray-900 dark:text-white">{{ $teacher->mobile }}</span>
                        </div>
                        @if($teacher->alt_mobile)
                            <div class="flex items-center">
                                <i class="fas fa-phone-alt w-5 text-gray-400 mr-3"></i>
                                <span class="text-gray-900 dark:text-white">{{ $teacher->alt_mobile }}</span>
                            </div>
                        @endif
                        @if($teacher->email)
                            <div class="flex items-center">
                                <i class="fas fa-envelope w-5 text-gray-400 mr-3"></i>
                                <span class="text-gray-900 dark:text-white">{{ $teacher->email }}</span>
                            </div>
                        @endif
                        @if($teacher->emergency_contact_name)
                            <div class="pt-3 border-t border-gray-200 dark:border-gray-700">
                                <p class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Emergency Contact</p>
                                <div class="flex items-center mb-1">
                                    <i class="fas fa-user w-5 text-gray-400 mr-3"></i>
                                    <span class="text-gray-900 dark:text-white">{{ $teacher->emergency_contact_name }}</span>
                                </div>
                                @if($teacher->emergency_contact_number)
                                    <div class="flex items-center">
                                        <i class="fas fa-phone w-5 text-gray-400 mr-3"></i>
                                        <span class="text-gray-900 dark:text-white">{{ $teacher->emergency_contact_number }}</span>
                                    </div>
                                @endif
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Right Column - Detailed Information -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Personal Details -->
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
                    <div class="bg-gradient-to-r from-blue-50 to-indigo-50 dark:from-blue-900/20 dark:to-indigo-900/20 px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Personal Details</h3>
                    </div>
                    <div class="p-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            @if($teacher->full_name_bn)
                                <div>
                                    <label class="block text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">Name (Bengali)</label>
                                    <p class="text-gray-900 dark:text-white">{{ $teacher->full_name_bn }}</p>
                                </div>
                            @endif
                            @if($teacher->father_name)
                                <div>
                                    <label class="block text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">Father's Name</label>
                                    <p class="text-gray-900 dark:text-white">{{ $teacher->father_name }}</p>
                                </div>
                            @endif
                            @if($teacher->mother_name)
                                <div>
                                    <label class="block text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">Mother's Name</label>
                                    <p class="text-gray-900 dark:text-white">{{ $teacher->mother_name }}</p>
                                </div>
                            @endif
                            <div>
                                <label class="block text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">Gender</label>
                                <p class="text-gray-900 dark:text-white">{{ $teacher->gender }}</p>
                            </div>
                            @if($teacher->dob)
                                <div>
                                    <label class="block text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">Date of Birth</label>
                                    <p class="text-gray-900 dark:text-white">{{ $teacher->dob->format('F j, Y') }} 
                                        @if($teacher->age)
                                            <span class="text-sm text-gray-500">({{ $teacher->age }} years old)</span>
                                        @endif
                                    </p>
                                </div>
                            @endif
                            @if($teacher->blood_group)
                                <div>
                                    <label class="block text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">Blood Group</label>
                                    <p class="text-gray-900 dark:text-white">{{ $teacher->blood_group }}</p>
                                </div>
                            @endif
                        </div>
                        
                        @if($teacher->present_address || $teacher->permanent_address)
                            <div class="mt-6 pt-6 border-t border-gray-200 dark:border-gray-700">
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    @if($teacher->present_address)
                                        <div>
                                            <label class="block text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">Present Address</label>
                                            <p class="text-gray-900 dark:text-white">{{ $teacher->present_address }}</p>
                                        </div>
                                    @endif
                                    @if($teacher->permanent_address)
                                        <div>
                                            <label class="block text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">Permanent Address</label>
                                            <p class="text-gray-900 dark:text-white">{{ $teacher->permanent_address }}</p>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Professional Information -->
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
                    <div class="bg-gradient-to-r from-purple-50 to-violet-50 dark:from-purple-900/20 dark:to-violet-900/20 px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Professional Information</h3>
                    </div>
                    <div class="p-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            @if($teacher->department)
                                <div>
                                    <label class="block text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">Department</label>
                                    <p class="text-gray-900 dark:text-white">{{ $teacher->department }}</p>
                                </div>
                            @endif
                            @if($teacher->subject_specialization)
                                <div>
                                    <label class="block text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">Subject Specialization</label>
                                    <p class="text-gray-900 dark:text-white">{{ $teacher->subject_specialization }}</p>
                                </div>
                            @endif
                            @if($teacher->joining_date)
                                <div>
                                    <label class="block text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">Joining Date</label>
                                    <p class="text-gray-900 dark:text-white">{{ $teacher->joining_date->format('F j, Y') }}</p>
                                </div>
                            @endif
                            @if($teacher->experience_years)
                                <div>
                                    <label class="block text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">Experience</label>
                                    <p class="text-gray-900 dark:text-white">{{ $teacher->experience_years }} years</p>
                                </div>
                            @endif
                            @if($teacher->highest_degree)
                                <div>
                                    <label class="block text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">Highest Degree</label>
                                    <p class="text-gray-900 dark:text-white">{{ $teacher->highest_degree }}</p>
                                </div>
                            @endif
                            @if($teacher->institution_name)
                                <div>
                                    <label class="block text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">Institution</label>
                                    <p class="text-gray-900 dark:text-white">{{ $teacher->institution_name }}</p>
                                </div>
                            @endif
                        </div>
                        
                        @if($teacher->salary_amount || $teacher->salary_type)
                            <div class="mt-6 pt-6 border-t border-gray-200 dark:border-gray-700">
                                <h4 class="text-md font-medium text-gray-900 dark:text-white mb-4">Salary Information</h4>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    @if($teacher->salary_type)
                                        <div>
                                            <label class="block text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">Salary Type</label>
                                            <p class="text-gray-900 dark:text-white">{{ $teacher->salary_type }}</p>
                                        </div>
                                    @endif
                                    @if($teacher->salary_amount)
                                        <div>
                                            <label class="block text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">Salary Amount</label>
                                            <p class="text-gray-900 dark:text-white">৳{{ number_format($teacher->salary_amount, 2) }}</p>
                                        </div>
                                    @endif
                                    @if($teacher->payment_method)
                                        <div>
                                            <label class="block text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">Payment Method</label>
                                            <p class="text-gray-900 dark:text-white">{{ $teacher->payment_method }}</p>
                                        </div>
                                    @endif
                                    @if($teacher->account_details)
                                        <div>
                                            <label class="block text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">Account Details</label>
                                            <p class="text-gray-900 dark:text-white">{{ $teacher->account_details }}</p>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Assignments -->
                @if($teacher->courses->count() > 0 || $teacher->subjects->count() > 0 || $teacher->students->count() > 0 || $teacher->batches->count() > 0)
                    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
                        <div class="bg-gradient-to-r from-green-50 to-emerald-50 dark:from-green-900/20 dark:to-emerald-900/20 px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                            <div class="flex items-center justify-between">
                                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Current Assignments</h3>
                                <div class="flex gap-2">
                                    <button onclick="removeAssignments({{ $teacher->id }})" 
                                            class="text-sm text-red-600 hover:text-red-700 dark:text-red-400 dark:hover:text-red-300 font-medium px-3 py-1 rounded-lg hover:bg-red-50 dark:hover:bg-red-900/20 transition-colors">
                                        <i class="fas fa-minus-circle mr-1"></i>
                                        Remove Assignments
                                    </button>
                                    <a href="{{ route('partner.teachers.assignments', $teacher) }}" 
                                       class="text-sm text-green-600 hover:text-green-700 dark:text-green-400 dark:hover:text-green-300 font-medium px-3 py-1 rounded-lg hover:bg-green-50 dark:hover:bg-green-900/20 transition-colors">
                                        <i class="fas fa-cog mr-1"></i>
                                        Manage All
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="p-6">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                @if($teacher->courses->count() > 0)
                                    <div>
                                        <h4 class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Courses ({{ $teacher->courses->count() }})</h4>
                                        <div class="space-y-1">
                                            @foreach($teacher->courses->take(3) as $course)
                                                <span class="inline-block px-2 py-1 bg-blue-100 dark:bg-blue-900/30 text-blue-800 dark:text-blue-300 text-xs rounded mr-1 mb-1">{{ $course->name }}</span>
                                            @endforeach
                                            @if($teacher->courses->count() > 3)
                                                <span class="text-xs text-gray-500">+{{ $teacher->courses->count() - 3 }} more</span>
                                            @endif
                                        </div>
                                    </div>
                                @endif
                                
                                @if($teacher->subjects->count() > 0)
                                    <div>
                                        <h4 class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Subjects ({{ $teacher->subjects->count() }})</h4>
                                        <div class="space-y-1">
                                            @foreach($teacher->subjects->take(3) as $subject)
                                                <span class="inline-block px-2 py-1 bg-green-100 dark:bg-green-900/30 text-green-800 dark:text-green-300 text-xs rounded mr-1 mb-1">{{ $subject->name }}</span>
                                            @endforeach
                                            @if($teacher->subjects->count() > 3)
                                                <span class="text-xs text-gray-500">+{{ $teacher->subjects->count() - 3 }} more</span>
                                            @endif
                                        </div>
                                    </div>
                                @endif
                                
                                @if($teacher->batches->count() > 0)
                                    <div>
                                        <h4 class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Batches ({{ $teacher->batches->count() }})</h4>
                                        <div class="space-y-1">
                                            @foreach($teacher->batches->take(3) as $batch)
                                                <span class="inline-block px-2 py-1 bg-purple-100 dark:bg-purple-900/30 text-purple-800 dark:text-purple-300 text-xs rounded mr-1 mb-1">{{ $batch->name }}</span>
                                            @endforeach
                                            @if($teacher->batches->count() > 3)
                                                <span class="text-xs text-gray-500">+{{ $teacher->batches->count() - 3 }} more</span>
                                            @endif
                                        </div>
                                    </div>
                                @endif
                                
                                @if($teacher->students->count() > 0)
                                    <div>
                                        <h4 class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Students ({{ $teacher->students->count() }})</h4>
                                        <p class="text-sm text-gray-600 dark:text-gray-400">{{ $teacher->students->count() }} students assigned</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Notes -->
                @if($teacher->notes)
                    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Additional Notes</h3>
                        <p class="text-gray-700 dark:text-gray-300 leading-relaxed">{{ $teacher->notes }}</p>
                    </div>
                @endif

                <!-- System Information -->
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">System Information</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 text-sm">
                        <div>
                            <label class="block text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">Created</label>
                            <p class="text-gray-900 dark:text-white">{{ $teacher->created_at->format('F j, Y \a\t g:i A') }}</p>
                            @if($teacher->creator)
                                <p class="text-xs text-gray-500">by {{ $teacher->creator->name }}</p>
                            @endif
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">Last Updated</label>
                            <p class="text-gray-900 dark:text-white">{{ $teacher->updated_at->format('F j, Y \a\t g:i A') }}</p>
                            @if($teacher->updater)
                                <p class="text-xs text-gray-500">by {{ $teacher->updater->name }}</p>
                            @endif
                        </div>
                    </div>
                </div>
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

function removeAssignments(teacherId) {
    if (confirm('Are you sure you want to remove assignments for this teacher?')) {
        // You can implement the removal logic here
        alert('Remove Assignments functionality - Teacher ID: ' + teacherId);
        // Example: 
        // fetch(`/partner/teachers/${teacherId}/remove-assignments`, {
        //     method: 'DELETE',
        //     headers: {
        //         'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        //     }
        // }).then(() => location.reload());
    }
}
</script>
@endsection
