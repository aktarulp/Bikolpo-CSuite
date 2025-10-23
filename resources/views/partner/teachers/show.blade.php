@extends('layouts.partner-layout')

@section('title', 'Teacher Details')

@section('content')
<div class="flex-1 overflow-y-auto custom-scrollbar bg-gray-50 dark:bg-gray-900 min-h-screen p-4 sm:p-6 lg:p-8">
    <div class="max-w-7xl mx-auto">
        
        <!-- Page Header -->
        <div class="mb-6 sm:mb-8">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div>
                    <div class="flex items-center gap-3 mb-2">
                        <div class="w-10 h-10 bg-gradient-to-r from-teal-500 to-cyan-600 rounded-xl flex items-center justify-center shadow-lg">
                            <i class="fas fa-chalkboard-teacher text-white text-lg"></i>
                        </div>
                        <div>
                            <h1 class="text-2xl sm:text-3xl font-bold text-gray-900 dark:text-white">Teacher Details</h1>
                            <p class="text-sm text-gray-600 dark:text-gray-400">View teacher information and assignments</p>
                        </div>
                    </div>
                </div>
                <div class="flex flex-col sm:flex-row gap-3">
                    <a href="{{ route('partner.teachers.index') }}" 
                       class="inline-flex items-center justify-center px-4 py-2.5 bg-gray-600 hover:bg-gray-700 text-white font-semibold rounded-lg shadow-lg hover:shadow-xl transition-all duration-300">
                        <i class="fas fa-arrow-left mr-2"></i>
                        Back to Teachers
                    </a>
                    <a href="{{ route('partner.teachers.edit', $teacher) }}" 
                       class="inline-flex items-center justify-center px-4 py-2.5 bg-gradient-to-r from-teal-600 to-cyan-600 hover:from-teal-700 hover:to-cyan-700 text-white font-semibold rounded-lg shadow-lg hover:shadow-xl transition-all duration-300 transform hover:scale-105">
                        <i class="fas fa-edit mr-2"></i>
                        Edit Teacher
                    </a>
                </div>
            </div>
        </div>

        <!-- Teacher Information -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Main Info Card -->
            <div class="lg:col-span-2">
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700">
                    <div class="p-6">
                        <div class="flex items-start space-x-6">
                            <!-- Teacher Photo -->
                            <div class="flex-shrink-0">
                                <div class="w-24 h-24 rounded-full overflow-hidden bg-gradient-to-br from-teal-100 to-cyan-100 dark:from-teal-900/30 dark:to-cyan-900/30 flex items-center justify-center">
                                    @if($teacher->photo)
                                        <img src="{{ asset('storage/' . $teacher->photo) }}" alt="{{ $teacher->full_name }}" class="w-full h-full object-cover">
                                    @else
                                        <i class="fas fa-user text-2xl text-teal-600 dark:text-teal-400"></i>
                                    @endif
                                </div>
                            </div>
                            
                            <!-- Teacher Info -->
                            <div class="flex-1 min-w-0">
                                <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-2">{{ $teacher->full_name }}</h2>
                                
                                <div class="flex flex-wrap gap-4 text-sm">
                                    <div class="flex items-center text-gray-600 dark:text-gray-400">
                                        <i class="fas fa-id-badge mr-2 text-teal-600"></i>
                                        <span class="font-medium">ID:</span>
                                        <span class="ml-1">{{ $teacher->teacher_id }}</span>
                                    </div>
                                    <div class="flex items-center text-gray-600 dark:text-gray-400">
                                        <i class="fas fa-phone mr-2 text-teal-600"></i>
                                        <span>{{ $teacher->phone }}</span>
                                    </div>
                                    @if($teacher->email)
                                        <div class="flex items-center text-gray-600 dark:text-gray-400">
                                            <i class="fas fa-envelope mr-2 text-teal-600"></i>
                                            <span>{{ $teacher->email }}</span>
                                        </div>
                                    @endif
                                </div>
                                
                                <!-- Status Badge -->
                                <div class="mt-4">
                                    @php
                                        $statusColors = [
                                            'Active' => 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-300',
                                            'Inactive' => 'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-300',
                                            'On Leave' => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-300'
                                        ];
                                    @endphp
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium {{ $statusColors[$teacher->employment_status] ?? 'bg-gray-100 text-gray-800' }}">
                                        <i class="fas fa-circle text-xs mr-2"></i>
                                        {{ $teacher->employment_status }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Additional Details -->
                <div class="mt-6 grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Personal Information -->
                    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700">
                        <div class="p-6">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4 flex items-center">
                                <i class="fas fa-user mr-2 text-teal-600"></i>
                                Personal Information
                            </h3>
                            <div class="space-y-3">
                                <div>
                                    <span class="text-sm font-medium text-gray-500 dark:text-gray-400">Gender:</span>
                                    <span class="ml-2 text-gray-900 dark:text-white">{{ $teacher->gender }}</span>
                                </div>
                                @if($teacher->date_of_birth)
                                    <div>
                                        <span class="text-sm font-medium text-gray-500 dark:text-gray-400">Date of Birth:</span>
                                        <span class="ml-2 text-gray-900 dark:text-white">{{ $teacher->date_of_birth->format('M d, Y') }}</span>
                                    </div>
                                @endif
                                @if($teacher->blood_group)
                                    <div>
                                        <span class="text-sm font-medium text-gray-500 dark:text-gray-400">Blood Group:</span>
                                        <span class="ml-2 text-gray-900 dark:text-white">{{ $teacher->blood_group }}</span>
                                    </div>
                                @endif
                                @if($teacher->mother_name)
                                    <div>
                                        <span class="text-sm font-medium text-gray-500 dark:text-gray-400">Mother's Name:</span>
                                        <span class="ml-2 text-gray-900 dark:text-white">{{ $teacher->mother_name }}</span>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Professional Information -->
                    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700">
                        <div class="p-6">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4 flex items-center">
                                <i class="fas fa-briefcase mr-2 text-teal-600"></i>
                                Professional Information
                            </h3>
                            <div class="space-y-3">
                                @if($teacher->designation)
                                    <div>
                                        <span class="text-sm font-medium text-gray-500 dark:text-gray-400">Designation:</span>
                                        <span class="ml-2 text-gray-900 dark:text-white">{{ $teacher->designation }}</span>
                                    </div>
                                @endif
                                @if($teacher->department)
                                    <div>
                                        <span class="text-sm font-medium text-gray-500 dark:text-gray-400">Department:</span>
                                        <span class="ml-2 text-gray-900 dark:text-white">{{ $teacher->department }}</span>
                                    </div>
                                @endif
                                @if($teacher->joining_date)
                                    <div>
                                        <span class="text-sm font-medium text-gray-500 dark:text-gray-400">Joining Date:</span>
                                        <span class="ml-2 text-gray-900 dark:text-white">{{ $teacher->joining_date->format('M d, Y') }}</span>
                                    </div>
                                @endif
                                @if($teacher->experience_years)
                                    <div>
                                        <span class="text-sm font-medium text-gray-500 dark:text-gray-400">Experience:</span>
                                        <span class="ml-2 text-gray-900 dark:text-white">{{ $teacher->experience_years }} years</span>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="space-y-6">
                <!-- Quick Stats -->
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Quick Stats</h3>
                        <div class="space-y-4">
                            <div class="flex items-center justify-between">
                                <span class="text-sm text-gray-600 dark:text-gray-400">Courses Assigned</span>
                                <span class="text-lg font-semibold text-gray-900 dark:text-white">{{ $teacher->courses->count() }}</span>
                            </div>
                            <div class="flex items-center justify-between">
                                <span class="text-sm text-gray-600 dark:text-gray-400">Subjects</span>
                                <span class="text-lg font-semibold text-gray-900 dark:text-white">{{ $teacher->subjects->count() }}</span>
                            </div>
                            <div class="flex items-center justify-between">
                                <span class="text-sm text-gray-600 dark:text-gray-400">Students</span>
                                <span class="text-lg font-semibold text-gray-900 dark:text-white">{{ $teacher->students->count() }}</span>
                            </div>
                            <div class="flex items-center justify-between">
                                <span class="text-sm text-gray-600 dark:text-gray-400">Batches</span>
                                <span class="text-lg font-semibold text-gray-900 dark:text-white">{{ $teacher->batches->count() }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Contact Information -->
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Contact Information</h3>
                        <div class="space-y-3">
                            <div class="flex items-center">
                                <i class="fas fa-phone text-teal-600 mr-3"></i>
                                <span class="text-gray-900 dark:text-white">{{ $teacher->phone }}</span>
                            </div>
                            @if($teacher->alternate_phone)
                                <div class="flex items-center">
                                    <i class="fas fa-phone-alt text-teal-600 mr-3"></i>
                                    <span class="text-gray-900 dark:text-white">{{ $teacher->alternate_phone }}</span>
                                </div>
                            @endif
                            @if($teacher->email)
                                <div class="flex items-center">
                                    <i class="fas fa-envelope text-teal-600 mr-3"></i>
                                    <span class="text-gray-900 dark:text-white">{{ $teacher->email }}</span>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
