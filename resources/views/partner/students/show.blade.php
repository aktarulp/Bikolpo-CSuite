@extends('layouts.partner-layout')

@section('title', 'Student Details')

@section('content')
<div class="space-y-6">
    <!-- Page Header -->
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Student Details</h1>
            <p class="text-gray-600 dark:text-gray-400">View student information</p>
        </div>
        <div class="flex items-center space-x-3">
            <a href="{{ route('partner.students.edit', $student) }}" 
               class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition-colors duration-200">
                Edit Student
            </a>
            <a href="{{ route('partner.students.index') }}" 
               class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg transition-colors duration-200">
                Back to Students
            </a>
        </div>
    </div>

    <!-- Student Information -->
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md overflow-hidden">
        <div class="p-6">
            <div class="flex items-start space-x-6">
                <!-- Student Photo -->
                <div class="flex-shrink-0">
                    @if($student->photo)
                        <img class="h-32 w-32 rounded-lg object-cover border-4 border-gray-200 dark:border-gray-600" 
                             src="{{ Storage::url($student->photo) }}" 
                             alt="{{ $student->full_name }}">
                    @else
                        <div class="h-32 w-32 rounded-lg bg-gray-300 dark:bg-gray-600 flex items-center justify-center">
                            <span class="text-gray-600 dark:text-gray-400 font-medium text-4xl">
                                {{ substr($student->full_name, 0, 1) }}
                            </span>
                        </div>
                    @endif
                </div>

                <!-- Student Details -->
                <div class="flex-1">
                    <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">{{ $student->full_name }}</h2>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-3">
                            <div>
                                <label class="text-sm font-medium text-gray-500 dark:text-gray-400">Student ID</label>
                                <p class="text-gray-900 dark:text-white">{{ $student->student_id ?? 'Not assigned' }}</p>
                            </div>
                            <div>
                                <label class="text-sm font-medium text-gray-500 dark:text-gray-400">Email</label>
                                <p class="text-gray-900 dark:text-white">{{ $student->email }}</p>
                            </div>
                            <div>
                                <label class="text-sm font-medium text-gray-500 dark:text-gray-400">Phone</label>
                                <p class="text-gray-900 dark:text-white">{{ $student->phone ?? 'Not provided' }}</p>
                            </div>
                            <div>
                                <label class="text-sm font-medium text-gray-500 dark:text-gray-400">Date of Birth</label>
                                <p class="text-gray-900 dark:text-white">{{ $student->date_of_birth->format('F j, Y') }}</p>
                            </div>
                        </div>
                        
                        <div class="space-y-3">
                            <div>
                                <label class="text-sm font-medium text-gray-500 dark:text-gray-400">Gender</label>
                                <p class="text-gray-900 dark:text-white capitalize">{{ $student->gender }}</p>
                            </div>
                            <div>
                                <label class="text-sm font-medium text-gray-500 dark:text-gray-400">School/College</label>
                                <p class="text-gray-900 dark:text-white">{{ $student->school_college ?? 'Not provided' }}</p>
                            </div>
                            <div>
                                <label class="text-sm font-medium text-gray-500 dark:text-gray-400">Class/Grade</label>
                                <p class="text-gray-900 dark:text-white">{{ $student->class_grade ?? 'Not provided' }}</p>
                            </div>
                            <div>
                                <label class="text-sm font-medium text-gray-500 dark:text-gray-400">Status</label>
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                    @if($student->status === 'active') bg-green-100 text-green-800
                                    @else bg-red-100 text-red-800 @endif">
                                    {{ ucfirst($student->status) }}
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- Address Information -->
                    @if($student->address || $student->city)
                        <div class="mt-6 pt-6 border-t border-gray-200 dark:border-gray-700">
                            <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-3">Address Information</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                @if($student->address)
                                    <div>
                                        <label class="text-sm font-medium text-gray-500 dark:text-gray-400">Address</label>
                                        <p class="text-gray-900 dark:text-white">{{ $student->address }}</p>
                                    </div>
                                @endif
                                @if($student->city)
                                    <div>
                                        <label class="text-sm font-medium text-gray-500 dark:text-gray-400">City</label>
                                        <p class="text-gray-900 dark:text-white">{{ $student->city }}</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endif

                    <!-- Parent Information -->
                    @if($student->parent_name || $student->parent_phone)
                        <div class="mt-6 pt-6 border-t border-gray-200 dark:border-gray-700">
                            <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-3">Parent Information</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                @if($student->parent_name)
                                    <div>
                                        <label class="text-sm font-medium text-gray-500 dark:text-gray-400">Parent Name</label>
                                        <p class="text-gray-900 dark:text-white">{{ $student->parent_name }}</p>
                                    </div>
                                @endif
                                @if($student->parent_phone)
                                    <div>
                                        <label class="text-sm font-medium text-gray-500 dark:text-gray-400">Parent Phone</label>
                                        <p class="text-gray-900 dark:text-white">{{ $student->parent_phone }}</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Exam Results -->
    @if($student->examResults && $student->examResults->count() > 0)
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Exam Results</h3>
            </div>
            <div class="divide-y divide-gray-200 dark:divide-gray-700">
                @foreach($student->examResults as $result)
                    <div class="p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <h4 class="text-lg font-medium text-gray-900 dark:text-white">{{ $result->exam->title }}</h4>
                                <p class="text-sm text-gray-600 dark:text-gray-400">
                                    Taken on {{ $result->created_at->format('F j, Y \a\t g:i A') }}
                                </p>
                            </div>
                            <div class="text-right">
                                <p class="text-2xl font-bold text-gray-900 dark:text-white">
                                    {{ $result->score ?? 'N/A' }}
                                </p>
                                <p class="text-sm text-gray-600 dark:text-gray-400">Score</p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif
</div>
@endsection
