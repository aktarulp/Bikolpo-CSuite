@extends('layouts.app')

@section('title', 'Student Profile')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    <!-- Page Header -->
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Student Profile</h1>
            <p class="text-gray-600 dark:text-gray-400">View and manage your profile information</p>
        </div>
        <a href="{{ route('student.profile.edit') }}" 
           class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition-colors duration-200">
            Edit Profile
        </a>
    </div>

    <!-- Profile Information -->
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md border border-gray-200 dark:border-gray-700">
        <div class="p-6 border-b border-gray-200 dark:border-gray-700">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Personal Information</h3>
        </div>
        
        <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Profile Photo -->
                <div class="md:col-span-2 flex justify-center">
                    <div class="relative">
                        @if($student->photo)
                            <img src="{{ Storage::url($student->photo) }}" 
                                 alt="Profile Photo" 
                                 class="w-32 h-32 rounded-full object-cover border-4 border-gray-200 dark:border-gray-700">
                        @else
                            <div class="w-32 h-32 rounded-full bg-gray-200 dark:bg-gray-700 flex items-center justify-center">
                                <i class="fas fa-user text-4xl text-gray-400 dark:text-gray-500"></i>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Full Name -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Full Name</label>
                    <p class="mt-1 text-sm text-gray-900 dark:text-white">{{ $student->full_name }}</p>
                </div>

                <!-- Student ID -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Student ID</label>
                    <p class="mt-1 text-sm text-gray-900 dark:text-white">{{ $student->student_id ?? 'Not assigned' }}</p>
                </div>

                <!-- Email -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Email Address</label>
                    <p class="mt-1 text-sm text-gray-900 dark:text-white">{{ $student->email }}</p>
                </div>

                <!-- Phone -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Phone Number</label>
                    <p class="mt-1 text-sm text-gray-900 dark:text-white">{{ $student->phone ?? 'Not provided' }}</p>
                </div>

                <!-- Date of Birth -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Date of Birth</label>
                    <p class="mt-1 text-sm text-gray-900 dark:text-white">{{ $student->date_of_birth->format('F d, Y') }}</p>
                </div>

                <!-- Gender -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Gender</label>
                    <p class="mt-1 text-sm text-gray-900 dark:text-white">{{ ucfirst($student->gender) }}</p>
                </div>

                <!-- Address -->
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Address</label>
                    <p class="mt-1 text-sm text-gray-900 dark:text-white">{{ $student->address ?? 'Not provided' }}</p>
                </div>

                <!-- City -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">City</label>
                    <p class="mt-1 text-sm text-gray-900 dark:text-white">{{ $student->city ?? 'Not provided' }}</p>
                </div>

                <!-- School/College -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">School/College</label>
                    <p class="mt-1 text-sm text-gray-900 dark:text-white">{{ $student->school_college ?? 'Not provided' }}</p>
                </div>

                <!-- Class/Grade -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Class/Grade</label>
                    <p class="mt-1 text-sm text-gray-900 dark:text-white">{{ $student->class_grade ?? 'Not provided' }}</p>
                </div>

                <!-- Parent Name -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Parent/Guardian Name</label>
                    <p class="mt-1 text-sm text-gray-900 dark:text-white">{{ $student->parent_name ?? 'Not provided' }}</p>
                </div>

                <!-- Parent Phone -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Parent/Guardian Phone</label>
                    <p class="mt-1 text-sm text-gray-900 dark:text-white">{{ $student->parent_phone ?? 'Not provided' }}</p>
                </div>

                <!-- Status -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Status</label>
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                        @if($student->status === 'active') bg-green-100 text-green-800
                        @else bg-red-100 text-red-800 @endif">
                        {{ ucfirst($student->status) }}
                    </span>
                </div>

                <!-- Member Since -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Member Since</label>
                    <p class="mt-1 text-sm text-gray-900 dark:text-white">{{ $student->created_at->format('F d, Y') }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md border border-gray-200 dark:border-gray-700">
        <div class="p-6 border-b border-gray-200 dark:border-gray-700">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Quick Actions</h3>
        </div>
        
        <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <a href="{{ route('student.dashboard') }}" 
                   class="flex items-center p-4 bg-blue-50 dark:bg-blue-900/20 rounded-lg hover:bg-blue-100 dark:hover:bg-blue-900/30 transition-colors duration-200">
                    <i class="fas fa-tachometer-alt text-blue-600 dark:text-blue-400 text-xl mr-3"></i>
                    <div>
                        <h4 class="font-medium text-blue-900 dark:text-blue-100">Dashboard</h4>
                        <p class="text-sm text-blue-700 dark:text-blue-300">Go to dashboard</p>
                    </div>
                </a>

                <a href="{{ route('student.exams.available') }}" 
                   class="flex items-center p-4 bg-green-50 dark:bg-green-900/20 rounded-lg hover:bg-green-100 dark:hover:bg-green-900/30 transition-colors duration-200">
                    <i class="fas fa-file-alt text-green-600 dark:text-green-400 text-xl mr-3"></i>
                    <div>
                        <h4 class="font-medium text-green-900 dark:text-green-100">Available Exams</h4>
                        <p class="text-sm text-green-700 dark:text-green-300">View exams</p>
                    </div>
                </a>

                <a href="{{ route('student.exams.history') }}" 
                   class="flex items-center p-4 bg-purple-50 dark:bg-purple-900/20 rounded-lg hover:bg-purple-100 dark:hover:bg-purple-900/30 transition-colors duration-200">
                    <i class="fas fa-history text-purple-600 dark:text-purple-400 text-xl mr-3"></i>
                    <div>
                        <h4 class="font-medium text-purple-900 dark:text-purple-100">Exam History</h4>
                        <p class="text-sm text-purple-700 dark:text-purple-300">View results</p>
                    </div>
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
