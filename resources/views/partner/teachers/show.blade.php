@extends('layouts.partner-layout')

@section('title', 'Teacher Details')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-slate-50 via-blue-50 to-indigo-100 dark:from-gray-900 dark:via-slate-900 dark:to-gray-800">
    <!-- Mobile-First Container -->
    <div class="container mx-auto px-4 py-6 sm:px-6 lg:px-8">
        <div class="max-w-7xl mx-auto">
            
            <!-- Enhanced Page Header -->
            <div class="mb-8">
                <!-- Navigation Bar -->
                <div class="flex items-center justify-between mb-6">
                    <a href="{{ route('partner.teachers.index') }}" 
                       class="group flex items-center gap-3 px-4 py-3 bg-white dark:bg-gray-800 rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 hover:scale-105 border border-gray-200 dark:border-gray-700">
                        <i class="fas fa-arrow-left text-gray-600 dark:text-gray-400 group-hover:text-blue-600 dark:group-hover:text-blue-400 transition-colors"></i>
                        <span class="font-semibold text-gray-700 dark:text-gray-300 group-hover:text-blue-600 dark:group-hover:text-blue-400 transition-colors">Back to Teachers</span>
                    </a>
                    
                    <a href="{{ route('partner.teachers.edit', $teacher) }}" 
                       class="group flex items-center gap-3 px-6 py-3 bg-gradient-to-r from-blue-600 to-purple-600 hover:from-blue-700 hover:to-purple-700 text-white font-semibold rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:scale-105">
                        <i class="fas fa-edit"></i>
                        <span class="hidden sm:inline">Edit Teacher</span>
                    </a>
                </div>
            </div>

            <!-- Hero Section -->
            <div class="mb-8">
                <!-- Teacher Profile Hero Card -->
                <div class="bg-white dark:bg-gray-800 rounded-3xl shadow-2xl border border-gray-200 dark:border-gray-700 overflow-hidden">
                    <!-- Hero Background -->
                    <div class="relative bg-gradient-to-r from-blue-600 via-purple-600 to-indigo-600 px-6 py-8 sm:px-8 sm:py-12">
                        <!-- Decorative Elements -->
                        <div class="absolute top-0 right-0 w-32 h-32 bg-white/10 rounded-full -translate-y-16 translate-x-16"></div>
                        <div class="absolute bottom-0 left-0 w-24 h-24 bg-white/5 rounded-full translate-y-12 -translate-x-12"></div>
                        
                        <!-- Teacher Profile -->
                        <div class="relative flex flex-col sm:flex-row items-center sm:items-start gap-6">
                            <!-- Teacher Avatar -->
                            <div class="relative">
                                <div class="w-24 h-24 sm:w-32 sm:h-32 rounded-3xl overflow-hidden bg-white/20 backdrop-blur-sm border-4 border-white/30 shadow-2xl">
                                    @if($teacher->photo)
                                        <img src="{{ $teacher->photo_url }}" alt="{{ $teacher->full_name }}" class="w-full h-full object-cover"
                                             onerror="this.onerror=null;this.src='data:image/svg+xml;utf8,\
                                             <svg xmlns=\'http://www.w3.org/2000/svg\' width=\'128\' height=\'128\' viewBox=\'0 0 128 128\'>\
                                               <rect width=\'128\' height=\'128\' rx=\'24\' fill=\'%236b7280\'/>\
                                               <text x=\'50%\' y=\'54%\' dominant-baseline=\'middle\' text-anchor=\'middle\' fill=\'white\' font-size=\'48\' font-family=\'Inter, Arial, sans-serif\'>{{ urlencode(Str::substr($teacher->full_name,0,1)) }}</text>\
                                             </svg>'">
                                    @else
                                        <div class="w-full h-full bg-gradient-to-br from-white/30 to-white/10 flex items-center justify-center">
                                            <i class="fas fa-user text-white text-3xl sm:text-4xl"></i>
                                        </div>
                                    @endif
                                </div>
                                <!-- Status Indicator -->
                                <div class="absolute -bottom-2 -right-2 w-8 h-8 bg-green-500 rounded-full border-4 border-white flex items-center justify-center shadow-lg">
                                    <i class="fas fa-check text-white text-sm"></i>
                                </div>
                            </div>
                            
                            <!-- Teacher Details -->
                            <div class="flex-1 text-center sm:text-left">
                                <h1 class="text-2xl sm:text-3xl lg:text-4xl font-bold text-white mb-2">
                                    {{ $teacher->full_name }}
                                </h1>
                                <p class="text-blue-100 text-lg sm:text-xl mb-4">
                                    {{ $teacher->designation ?? 'Teacher' }}
                                    @if($teacher->department)
                                        • {{ $teacher->department }}
                                    @endif
                                </p>
                                
                                <!-- Contact Info -->
                                <div class="flex flex-col sm:flex-row gap-4 text-blue-100">
                                    <div class="flex items-center justify-center sm:justify-start gap-2">
                                        <i class="fas fa-id-badge"></i>
                                        <span class="font-mono">{{ $teacher->teacher_id }}</span>
                                    </div>
                                    <div class="flex items-center justify-center sm:justify-start gap-2">
                                        <i class="fas fa-phone"></i>
                                        <span>{{ $teacher->phone }}</span>
                                    </div>
                                    @if($teacher->email)
                                        <div class="flex items-center justify-center sm:justify-start gap-2">
                                            <i class="fas fa-envelope"></i>
                                            <span class="truncate">{{ $teacher->email }}</span>
                                        </div>
                                    @endif
                                </div>
                                
                                <!-- Status Badge -->
                                <div class="mt-4 flex justify-center sm:justify-start">
                                    @php
                                        $statusConfig = [
                                            'Active' => ['bg-green-500', 'text-white', 'bg-green-500/20'],
                                            'Inactive' => ['bg-red-500', 'text-white', 'bg-red-500/20'],
                                            'On Leave' => ['bg-yellow-500', 'text-white', 'bg-yellow-500/20']
                                        ];
                                        $status = $statusConfig[$teacher->employment_status] ?? ['bg-gray-500', 'text-white', 'bg-gray-500/20'];
                                    @endphp
                                    <span class="inline-flex items-center gap-2 px-4 py-2 rounded-full text-sm font-semibold {{ $status[0] }} {{ $status[1] }} backdrop-blur-sm border border-white/30">
                                        <i class="fas fa-circle text-xs"></i>
                                        {{ $teacher->employment_status }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main Content Grid -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 lg:gap-8">
                <!-- Main Content -->
                <div class="lg:col-span-2 space-y-6">

                    <!-- Information Cards -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Personal Information Card -->
                        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl border border-gray-200 dark:border-gray-700 overflow-hidden">
                            <!-- Card Header -->
                            <div class="bg-gradient-to-r from-blue-500 to-cyan-500 px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 bg-white/20 rounded-xl flex items-center justify-center">
                                        <i class="fas fa-user text-white text-lg"></i>
                                    </div>
                                    <div>
                                        <h3 class="text-lg font-bold text-white">Personal Information</h3>
                                        <p class="text-blue-100 text-sm">Basic details and background</p>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Card Content -->
                            <div class="p-6 space-y-4">
                                <div class="flex items-center justify-between py-3 border-b border-gray-100 dark:border-gray-700">
                                    <div class="flex items-center gap-3">
                                        <div class="w-8 h-8 bg-blue-100 dark:bg-blue-900/30 rounded-lg flex items-center justify-center">
                                            <i class="fas fa-venus-mars text-blue-600 dark:text-blue-400 text-sm"></i>
                                        </div>
                                        <span class="text-sm font-medium text-gray-600 dark:text-gray-400">Gender</span>
                                    </div>
                                    <span class="text-sm font-semibold text-gray-900 dark:text-white">{{ $teacher->gender }}</span>
                                </div>
                                
                                @if($teacher->date_of_birth)
                                    <div class="flex items-center justify-between py-3 border-b border-gray-100 dark:border-gray-700">
                                        <div class="flex items-center gap-3">
                                            <div class="w-8 h-8 bg-green-100 dark:bg-green-900/30 rounded-lg flex items-center justify-center">
                                                <i class="fas fa-calendar text-green-600 dark:text-green-400 text-sm"></i>
                                            </div>
                                            <span class="text-sm font-medium text-gray-600 dark:text-gray-400">Date of Birth</span>
                                        </div>
                                        <span class="text-sm font-semibold text-gray-900 dark:text-white">{{ $teacher->date_of_birth->format('M d, Y') }}</span>
                                    </div>
                                @endif
                                
                                @if($teacher->blood_group)
                                    <div class="flex items-center justify-between py-3 border-b border-gray-100 dark:border-gray-700">
                                        <div class="flex items-center gap-3">
                                            <div class="w-8 h-8 bg-red-100 dark:bg-red-900/30 rounded-lg flex items-center justify-center">
                                                <i class="fas fa-heart text-red-600 dark:text-red-400 text-sm"></i>
                                            </div>
                                            <span class="text-sm font-medium text-gray-600 dark:text-gray-400">Blood Group</span>
                                        </div>
                                        <span class="text-sm font-semibold text-gray-900 dark:text-white">{{ $teacher->blood_group }}</span>
                                    </div>
                                @endif
                                
                                @if($teacher->mother_name)
                                    <div class="flex items-center justify-between py-3">
                                        <div class="flex items-center gap-3">
                                            <div class="w-8 h-8 bg-purple-100 dark:bg-purple-900/30 rounded-lg flex items-center justify-center">
                                                <i class="fas fa-female text-purple-600 dark:text-purple-400 text-sm"></i>
                                            </div>
                                            <span class="text-sm font-medium text-gray-600 dark:text-gray-400">Mother's Name</span>
                                        </div>
                                        <span class="text-sm font-semibold text-gray-900 dark:text-white">{{ $teacher->mother_name }}</span>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <!-- Professional Information Card -->
                        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl border border-gray-200 dark:border-gray-700 overflow-hidden">
                            <!-- Card Header -->
                            <div class="bg-gradient-to-r from-purple-500 to-pink-500 px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 bg-white/20 rounded-xl flex items-center justify-center">
                                        <i class="fas fa-briefcase text-white text-lg"></i>
                                    </div>
                                    <div>
                                        <h3 class="text-lg font-bold text-white">Professional Information</h3>
                                        <p class="text-purple-100 text-sm">Career and work details</p>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Card Content -->
                            <div class="p-6 space-y-4">
                                @if($teacher->designation)
                                    <div class="flex items-center justify-between py-3 border-b border-gray-100 dark:border-gray-700">
                                        <div class="flex items-center gap-3">
                                            <div class="w-8 h-8 bg-purple-100 dark:bg-purple-900/30 rounded-lg flex items-center justify-center">
                                                <i class="fas fa-id-badge text-purple-600 dark:text-purple-400 text-sm"></i>
                                            </div>
                                            <span class="text-sm font-medium text-gray-600 dark:text-gray-400">Designation</span>
                                        </div>
                                        <span class="text-sm font-semibold text-gray-900 dark:text-white">{{ $teacher->designation }}</span>
                                    </div>
                                @endif
                                
                                @if($teacher->department)
                                    <div class="flex items-center justify-between py-3 border-b border-gray-100 dark:border-gray-700">
                                        <div class="flex items-center gap-3">
                                            <div class="w-8 h-8 bg-indigo-100 dark:bg-indigo-900/30 rounded-lg flex items-center justify-center">
                                                <i class="fas fa-building text-indigo-600 dark:text-indigo-400 text-sm"></i>
                                            </div>
                                            <span class="text-sm font-medium text-gray-600 dark:text-gray-400">Department</span>
                                        </div>
                                        <span class="text-sm font-semibold text-gray-900 dark:text-white">{{ $teacher->department }}</span>
                                    </div>
                                @endif
                                
                                @if($teacher->joining_date)
                                    <div class="flex items-center justify-between py-3 border-b border-gray-100 dark:border-gray-700">
                                        <div class="flex items-center gap-3">
                                            <div class="w-8 h-8 bg-green-100 dark:bg-green-900/30 rounded-lg flex items-center justify-center">
                                                <i class="fas fa-calendar-plus text-green-600 dark:text-green-400 text-sm"></i>
                                            </div>
                                            <span class="text-sm font-medium text-gray-600 dark:text-gray-400">Joining Date</span>
                                        </div>
                                        <span class="text-sm font-semibold text-gray-900 dark:text-white">{{ $teacher->joining_date->format('M d, Y') }}</span>
                                    </div>
                                @endif
                                
                                @if($teacher->experience_years)
                                    <div class="flex items-center justify-between py-3">
                                        <div class="flex items-center gap-3">
                                            <div class="w-8 h-8 bg-orange-100 dark:bg-orange-900/30 rounded-lg flex items-center justify-center">
                                                <i class="fas fa-award text-orange-600 dark:text-orange-400 text-sm"></i>
                                            </div>
                                            <span class="text-sm font-medium text-gray-600 dark:text-gray-400">Experience</span>
                                        </div>
                                        <span class="text-sm font-semibold text-gray-900 dark:text-white">{{ $teacher->experience_years }} years</span>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
            </div>

                <!-- Sidebar -->
                <div class="space-y-6">
                    <!-- Quick Stats Card -->
                    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl border border-gray-200 dark:border-gray-700 overflow-hidden">
                        <!-- Card Header -->
                        <div class="bg-gradient-to-r from-emerald-500 to-teal-500 px-6 py-4">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 bg-white/20 rounded-xl flex items-center justify-center">
                                    <i class="fas fa-chart-bar text-white text-lg"></i>
                                </div>
                                <div>
                                    <h3 class="text-lg font-bold text-white">Quick Stats</h3>
                                    <p class="text-emerald-100 text-sm">Performance overview</p>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Stats Content -->
                        <div class="p-6 space-y-4">
                            <div class="flex items-center justify-between p-4 bg-gradient-to-r from-blue-50 to-blue-100 dark:from-blue-900/20 dark:to-blue-800/20 rounded-xl">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 bg-blue-500 rounded-xl flex items-center justify-center">
                                        <i class="fas fa-book text-white"></i>
                                    </div>
                                    <div>
                                        <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Courses</p>
                                        <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $teacher->courses->count() }}</p>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="flex items-center justify-between p-4 bg-gradient-to-r from-purple-50 to-purple-100 dark:from-purple-900/20 dark:to-purple-800/20 rounded-xl">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 bg-purple-500 rounded-xl flex items-center justify-center">
                                        <i class="fas fa-graduation-cap text-white"></i>
                                    </div>
                                    <div>
                                        <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Subjects</p>
                                        <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $teacher->subjects->count() }}</p>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="flex items-center justify-between p-4 bg-gradient-to-r from-green-50 to-green-100 dark:from-green-900/20 dark:to-green-800/20 rounded-xl">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 bg-green-500 rounded-xl flex items-center justify-center">
                                        <i class="fas fa-users text-white"></i>
                                    </div>
                                    <div>
                                        <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Students</p>
                                        <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $teacher->students->count() }}</p>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="flex items-center justify-between p-4 bg-gradient-to-r from-orange-50 to-orange-100 dark:from-orange-900/20 dark:to-orange-800/20 rounded-xl">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 bg-orange-500 rounded-xl flex items-center justify-center">
                                        <i class="fas fa-layer-group text-white"></i>
                                    </div>
                                    <div>
                                        <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Batches</p>
                                        <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $teacher->batches->count() }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Contact Information Card -->
                    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl border border-gray-200 dark:border-gray-700 overflow-hidden">
                        <!-- Card Header -->
                        <div class="bg-gradient-to-r from-indigo-500 to-blue-500 px-6 py-4">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 bg-white/20 rounded-xl flex items-center justify-center">
                                    <i class="fas fa-address-book text-white text-lg"></i>
                                </div>
                                <div>
                                    <h3 class="text-lg font-bold text-white">Contact Information</h3>
                                    <p class="text-indigo-100 text-sm">Get in touch</p>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Contact Content -->
                        <div class="p-6 space-y-4">
                            <div class="flex items-center gap-4 p-4 bg-gray-50 dark:bg-gray-700 rounded-xl">
                                <div class="w-10 h-10 bg-blue-500 rounded-xl flex items-center justify-center">
                                    <i class="fas fa-phone text-white"></i>
                                </div>
                                <div class="flex-1">
                                    <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Primary Phone</p>
                                    <p class="text-sm font-semibold text-gray-900 dark:text-white">{{ $teacher->phone }}</p>
                                </div>
                            </div>
                            
                            @if($teacher->alternate_phone)
                                <div class="flex items-center gap-4 p-4 bg-gray-50 dark:bg-gray-700 rounded-xl">
                                    <div class="w-10 h-10 bg-green-500 rounded-xl flex items-center justify-center">
                                        <i class="fas fa-phone-alt text-white"></i>
                                    </div>
                                    <div class="flex-1">
                                        <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Alternate Phone</p>
                                        <p class="text-sm font-semibold text-gray-900 dark:text-white">{{ $teacher->alternate_phone }}</p>
                                    </div>
                                </div>
                            @endif
                            
                            @if($teacher->email)
                                <div class="flex items-center gap-4 p-4 bg-gray-50 dark:bg-gray-700 rounded-xl">
                                    <div class="w-10 h-10 bg-purple-500 rounded-xl flex items-center justify-center">
                                        <i class="fas fa-envelope text-white"></i>
                                    </div>
                                    <div class="flex-1">
                                        <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Email Address</p>
                                        <p class="text-sm font-semibold text-gray-900 dark:text-white break-all">{{ $teacher->email }}</p>
                                    </div>
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
