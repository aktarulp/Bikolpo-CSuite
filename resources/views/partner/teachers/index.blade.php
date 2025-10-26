@extends('layouts.partner-layout')

@section('title', 'Teachers Management')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-slate-50 via-blue-50 to-indigo-50 dark:from-gray-900 dark:via-slate-900 dark:to-gray-900">
    <div class="container mx-auto px-4 py-6 sm:px-6 lg:px-8 max-w-7xl">
        
        <!-- Ultra Modern Header with Glassmorphism -->
        <div class="relative mb-8">
            <!-- Background Blur Effect -->
            <div class="absolute inset-0 bg-gradient-to-r from-blue-600/10 via-purple-600/10 to-indigo-600/10 rounded-3xl blur-xl"></div>
            
            <!-- Header Content -->
            <div class="relative bg-white/80 dark:bg-gray-800/80 backdrop-blur-xl rounded-3xl p-6 sm:p-8 border border-white/20 dark:border-gray-700/50 shadow-2xl">
                <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-6">
                    <!-- Title Section -->
                    <div class="flex items-center gap-4">
                        <div class="relative">
                            <div class="w-16 h-16 bg-gradient-to-br from-blue-500 via-purple-500 to-indigo-600 rounded-2xl flex items-center justify-center shadow-2xl transform rotate-3 hover:rotate-0 transition-transform duration-500">
                                <i class="fas fa-chalkboard-teacher text-white text-2xl"></i>
                            </div>
                            <div class="absolute -top-1 -right-1 w-6 h-6 bg-gradient-to-r from-emerald-400 to-cyan-400 rounded-full animate-pulse"></div>
                        </div>
                        <div>
                            <h1 class="text-3xl sm:text-4xl lg:text-5xl font-black bg-gradient-to-r from-gray-900 via-blue-600 to-indigo-600 dark:from-white dark:via-blue-400 dark:to-indigo-400 bg-clip-text text-transparent leading-tight">
                                Teachers
                            </h1>
                            <p class="text-sm sm:text-base text-gray-600 dark:text-gray-400 font-medium mt-1">
                                Manage your teaching staff with precision
                            </p>
                        </div>
                    </div>
                    
                    <!-- Action Button -->
                    <div class="flex-shrink-0">
                        <!-- Add Teacher Button -->
                        <a href="{{ route('partner.teachers.create') }}" 
                           class="group relative inline-flex items-center justify-center px-6 py-4 bg-gradient-to-r from-blue-600 via-purple-600 to-indigo-600 hover:from-blue-700 hover:via-purple-700 hover:to-indigo-700 text-white font-bold rounded-2xl shadow-2xl hover:shadow-3xl transition-all duration-500 transform hover:scale-105 hover:-translate-y-1">
                            <div class="absolute inset-0 bg-gradient-to-r from-blue-600 via-purple-600 to-indigo-600 rounded-2xl blur opacity-75 group-hover:opacity-100 transition-opacity duration-500"></div>
                            <div class="relative flex items-center gap-3">
                                <div class="w-8 h-8 bg-white/20 rounded-lg flex items-center justify-center">
                                    <i class="fas fa-plus text-lg"></i>
                                </div>
                                <span class="hidden sm:inline text-lg">Add New Teacher</span>
                                <span class="sm:hidden text-lg">Add Teacher</span>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Flash Messages -->
        @if(session('success'))
            <div id="successMessage" class="mb-6 p-4 bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 rounded-xl shadow-lg transition-all duration-300">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 bg-green-100 dark:bg-green-900/30 rounded-lg flex items-center justify-center">
                            <svg class="w-5 h-5 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                        </div>
                        <div>
                            <h4 class="text-sm font-semibold text-green-800 dark:text-green-200">Success!</h4>
                            <p class="text-sm text-green-700 dark:text-green-300">{{ session('success') }}</p>
                        </div>
                    </div>
                    <button onclick="dismissMessage('successMessage')" class="text-green-400 hover:text-green-600 dark:text-green-500 dark:hover:text-green-300 transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
            </div>
        @endif

        @if(session('error'))
            <div id="errorMessage" class="mb-6 p-4 bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-xl shadow-lg transition-all duration-300">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 bg-red-100 dark:bg-red-900/30 rounded-lg flex items-center justify-center">
                            <svg class="w-5 h-5 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </div>
                        <div>
                            <h4 class="text-sm font-semibold text-red-800 dark:text-red-200">Error!</h4>
                            <p class="text-sm text-red-700 dark:text-red-300">{{ session('error') }}</p>
                        </div>
                    </div>
                    <button onclick="dismissMessage('errorMessage')" class="text-red-400 hover:text-red-600 dark:text-red-500 dark:hover:text-red-300 transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
            </div>
        @endif

        <!-- Compact Modern Stats Cards -->
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-3 sm:gap-4 mb-8">
            <!-- Total Teachers Card -->
            <div class="group relative bg-white/80 dark:bg-gray-800/80 backdrop-blur-xl rounded-xl p-4 border border-white/30 dark:border-gray-700/50 shadow-lg hover:shadow-xl transition-all duration-300 transform hover:scale-102 hover:-translate-y-1">
                <div class="absolute inset-0 bg-gradient-to-br from-blue-500/5 to-indigo-600/5 rounded-xl opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                <div class="relative flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-lg flex items-center justify-center shadow-md">
                            <i class="fas fa-users text-white text-xs"></i>
                        </div>
                        <div>
                            <p class="text-xs font-medium text-gray-600 dark:text-gray-400">Total</p>
                            <p class="text-lg font-bold text-gray-900 dark:text-white">{{ $stats['total_teachers'] }}</p>
                    </div>
                    </div>
                    <div class="w-2 h-2 bg-gradient-to-r from-blue-400 to-indigo-500 rounded-full animate-pulse"></div>
                </div>
            </div>
            
            <!-- Active Teachers Card -->
            <div class="group relative bg-white/80 dark:bg-gray-800/80 backdrop-blur-xl rounded-xl p-4 border border-white/30 dark:border-gray-700/50 shadow-lg hover:shadow-xl transition-all duration-300 transform hover:scale-102 hover:-translate-y-1">
                <div class="absolute inset-0 bg-gradient-to-br from-emerald-500/5 to-green-600/5 rounded-xl opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                <div class="relative flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 bg-gradient-to-br from-emerald-500 to-green-600 rounded-lg flex items-center justify-center shadow-md">
                            <i class="fas fa-check-circle text-white text-xs"></i>
                        </div>
                        <div>
                            <p class="text-xs font-medium text-gray-600 dark:text-gray-400">Active</p>
                            <p class="text-lg font-bold text-gray-900 dark:text-white">{{ $stats['active_teachers'] }}</p>
                    </div>
                    </div>
                    <div class="w-2 h-2 bg-gradient-to-r from-emerald-400 to-green-500 rounded-full animate-pulse"></div>
                </div>
            </div>
            
            <!-- Inactive Teachers Card -->
            <div class="group relative bg-white/80 dark:bg-gray-800/80 backdrop-blur-xl rounded-xl p-4 border border-white/30 dark:border-gray-700/50 shadow-lg hover:shadow-xl transition-all duration-300 transform hover:scale-102 hover:-translate-y-1">
                <div class="absolute inset-0 bg-gradient-to-br from-red-500/5 to-rose-600/5 rounded-xl opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                <div class="relative flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 bg-gradient-to-br from-red-500 to-rose-600 rounded-lg flex items-center justify-center shadow-md">
                            <i class="fas fa-times-circle text-white text-xs"></i>
                        </div>
                        <div>
                            <p class="text-xs font-medium text-gray-600 dark:text-gray-400">Inactive</p>
                            <p class="text-lg font-bold text-gray-900 dark:text-white">{{ $stats['inactive_teachers'] }}</p>
                    </div>
                    </div>
                    <div class="w-2 h-2 bg-gradient-to-r from-red-400 to-rose-500 rounded-full animate-pulse"></div>
                </div>
            </div>
            
            <!-- On Leave Teachers Card -->
            <div class="group relative bg-white/80 dark:bg-gray-800/80 backdrop-blur-xl rounded-xl p-4 border border-white/30 dark:border-gray-700/50 shadow-lg hover:shadow-xl transition-all duration-300 transform hover:scale-102 hover:-translate-y-1">
                <div class="absolute inset-0 bg-gradient-to-br from-amber-500/5 to-orange-600/5 rounded-xl opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                <div class="relative flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 bg-gradient-to-br from-amber-500 to-orange-600 rounded-lg flex items-center justify-center shadow-md">
                            <i class="fas fa-calendar-times text-white text-xs"></i>
                        </div>
                        <div>
                            <p class="text-xs font-medium text-gray-600 dark:text-gray-400">On Leave</p>
                            <p class="text-lg font-bold text-gray-900 dark:text-white">{{ $stats['on_leave_teachers'] }}</p>
                    </div>
                    </div>
                    <div class="w-2 h-2 bg-gradient-to-r from-amber-400 to-orange-500 rounded-full animate-pulse"></div>
                </div>
            </div>
        </div>


        <!-- Ultra Modern Teachers Grid -->
        @if($teachers->count() > 0)
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6 sm:gap-8">
                @foreach($teachers as $teacher)
                    <div class="group relative bg-white/70 dark:bg-gray-800/70 backdrop-blur-xl rounded-3xl shadow-2xl hover:shadow-3xl border border-white/20 dark:border-gray-700/50 overflow-hidden transition-all duration-700 transform hover:scale-105 hover:-translate-y-3">
                        <!-- Background Gradient Effect -->
                        <div class="absolute inset-0 bg-gradient-to-br from-blue-500/5 via-purple-500/5 to-indigo-500/5 opacity-0 group-hover:opacity-100 transition-opacity duration-700"></div>
                        
                        <!-- Teacher Photo Section -->
                        <div class="relative w-full aspect-square bg-gradient-to-br from-blue-50 via-indigo-50 to-purple-50 dark:from-gray-700 dark:via-gray-600 dark:to-gray-500 overflow-hidden">
                            @if($teacher->photo)
                                <img src="{{ $teacher->photo_url }}" alt="{{ $teacher->full_name }}" class="w-full h-full object-cover object-center group-hover:scale-110 transition-transform duration-700" style="aspect-ratio: 1/1;" 
                                     onerror="this.onerror=null;this.src='data:image/svg+xml;utf8,\
                                     <svg xmlns=\'http://www.w3.org/2000/svg\' width=\'200\' height=\'200\' viewBox=\'0 0 200 200\'>\
                                       <rect width=\'200\' height=\'200\' rx=\'40\' fill=\'%236b7280\'/>\
                                       <text x=\'50%\' y=\'54%\' dominant-baseline=\'middle\' text-anchor=\'middle\' fill=\'white\' font-size=\'80\' font-family=\'Inter, Arial, sans-serif\'>{{ urlencode(Str::substr($teacher->full_name,0,1)) }}</text>\
                                     </svg>'">
                            @else
                                <div class="w-full h-full flex items-center justify-center" style="aspect-ratio: 1/1;">
                                    <div class="w-24 h-24 bg-white/90 dark:bg-gray-800/90 rounded-3xl flex items-center justify-center shadow-2xl group-hover:scale-110 transition-transform duration-500">
                                        <span class="text-4xl">{{ $teacher->getGenderIcon() }}</span>
                                    </div>
                                </div>
                            @endif
                            
                            <!-- Status Badge - Moved to Left -->
                            <div class="absolute bottom-4 left-4">
                                <span class="inline-flex items-center px-3 py-1.5 rounded-2xl text-xs font-bold {{ $teacher->getStatusBadgeClass() }} backdrop-blur-sm shadow-lg">
                                    {{ $teacher->employment_status }}
                                </span>
                            </div>
                            
                            <!-- Floating Action Menu - Moved to Right -->
                            <div class="absolute bottom-3 right-3 opacity-0 group-hover:opacity-100 transition-all duration-300 transform translate-y-2 group-hover:translate-y-0">
                                <div class="flex gap-2">
                                    <a href="{{ route('partner.teachers.show', $teacher) }}" 
                                       class="w-10 h-10 bg-blue-600 hover:bg-blue-700 text-white rounded-xl flex items-center justify-center shadow-lg hover:shadow-xl transition-all duration-300 hover:scale-110"
                                       title="View Teacher">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                        </svg>
                                    </a>
                                    <a href="{{ route('partner.teachers.edit', $teacher) }}" 
                                       class="w-10 h-10 bg-emerald-600 hover:bg-emerald-700 text-white rounded-xl flex items-center justify-center shadow-lg hover:shadow-xl transition-all duration-300 hover:scale-110"
                                       title="Edit Teacher">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                        </svg>
                                    </a>
                                    <button onclick="deleteTeacher('{{ $teacher->teacher_id }}', '{{ $teacher->full_name }}')" 
                                            class="w-10 h-10 bg-red-600 hover:bg-red-700 text-white rounded-xl flex items-center justify-center shadow-lg hover:shadow-xl transition-all duration-300 hover:scale-110"
                                            title="Delete Teacher">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Teacher Info Section -->
                        <div class="relative p-6">
                            <!-- Name and ID -->
                            <div class="mb-4">
                                <h3 class="text-sm font-bold text-gray-900 dark:text-white truncate mb-2">{{ $teacher->full_name }}</h3>
                                <div class="flex items-center gap-2 text-sm">
                                    <span class="font-semibold text-gray-500 dark:text-gray-400">{{ $teacher->teacher_id }}</span>
                                    @if($teacher->designation)
                                        <span class="text-gray-400 dark:text-gray-500">|</span>
                                        <span class="font-bold text-blue-600 dark:text-blue-400">{{ $teacher->designation }}</span>
                                    @endif
                                </div>
                            </div>


                            <!-- Stats Badges -->
                            <div class="flex gap-2 mb-4">
                                <span class="inline-flex items-center justify-center px-3 py-1.5 bg-blue-100 dark:bg-blue-900/30 text-blue-800 dark:text-blue-200 text-xs font-semibold rounded-full">
                                    <svg class="w-3 h-3 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                    </svg>
                                    {{ $teacher->courses->count() }} Courses
                                </span>
                                <span class="inline-flex items-center justify-center px-3 py-1.5 bg-emerald-100 dark:bg-emerald-900/30 text-emerald-800 dark:text-emerald-200 text-xs font-semibold rounded-full">
                                    <svg class="w-3 h-3 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 010 5z"></path>
                                    </svg>
                                    {{ $teacher->students->count() }} Students
                                </span>
                            </div>

                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Modern Pagination -->
            <div class="mt-12 flex justify-center">
                <div class="bg-white/70 dark:bg-gray-800/70 backdrop-blur-xl rounded-2xl p-4 border border-white/20 dark:border-gray-700/50 shadow-xl">
                {{ $teachers->links() }}
                </div>
            </div>
        @else
            <!-- Ultra Modern Empty State -->
            <div class="relative">
                <!-- Background Blur Effect -->
                <div class="absolute inset-0 bg-gradient-to-r from-blue-600/5 via-purple-600/5 to-indigo-600/5 rounded-3xl blur-xl"></div>
                
                <!-- Empty State Content -->
                <div class="relative bg-white/80 dark:bg-gray-800/80 backdrop-blur-xl rounded-3xl p-12 text-center border border-white/20 dark:border-gray-700/50 shadow-2xl">
                    <!-- Animated Icon -->
                    <div class="relative mb-8">
                        <div class="w-32 h-32 bg-gradient-to-br from-blue-500 via-purple-500 to-indigo-600 rounded-3xl flex items-center justify-center mx-auto shadow-2xl transform rotate-3 hover:rotate-0 transition-transform duration-700">
                            <i class="fas fa-chalkboard-teacher text-white text-5xl"></i>
                        </div>
                        <div class="absolute -top-2 -right-2 w-8 h-8 bg-gradient-to-r from-emerald-400 to-cyan-400 rounded-full animate-pulse"></div>
                        <div class="absolute -bottom-2 -left-2 w-6 h-6 bg-gradient-to-r from-pink-400 to-rose-400 rounded-full animate-pulse delay-300"></div>
                </div>
                    
                    <!-- Content -->
                    <h3 class="text-3xl font-black text-gray-900 dark:text-white mb-4">
                        @if(request()->hasAny(['search', 'status', 'department']))
                            No Teachers Found
                        @else
                            No Teachers Yet
                        @endif
                    </h3>
                    <p class="text-lg text-gray-600 dark:text-gray-400 mb-8 max-w-md mx-auto">
                    @if(request()->hasAny(['search', 'status', 'department']))
                            No teachers match your search criteria. Try adjusting your filters or search terms.
                    @else
                            Get started by adding your first teacher to build your teaching team.
                    @endif
                </p>
                    
                    <!-- Action Button -->
                <a href="{{ route('partner.teachers.create') }}" 
                       class="group relative inline-flex items-center justify-center px-8 py-4 bg-gradient-to-r from-blue-600 via-purple-600 to-indigo-600 hover:from-blue-700 hover:via-purple-700 hover:to-indigo-700 text-white font-bold rounded-2xl shadow-2xl hover:shadow-3xl transition-all duration-500 transform hover:scale-105 hover:-translate-y-1">
                        <div class="absolute inset-0 bg-gradient-to-r from-blue-600 via-purple-600 to-indigo-600 rounded-2xl blur opacity-75 group-hover:opacity-100 transition-opacity duration-500"></div>
                        <div class="relative flex items-center gap-3">
                            <div class="w-8 h-8 bg-white/20 rounded-lg flex items-center justify-center">
                                <i class="fas fa-plus text-lg"></i>
                            </div>
                            <span class="text-lg">
                                @if(request()->hasAny(['search', 'status', 'department']))
                                    Clear Filters & Add Teacher
                                @else
                    Add First Teacher
                                @endif
                            </span>
                        </div>
                </a>
                </div>
            </div>
        @endif
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div id="deleteModal" class="fixed inset-0 bg-black/50 backdrop-blur-sm z-50 hidden flex items-center justify-center p-4">
    <div class="bg-white dark:bg-gray-800 rounded-3xl shadow-2xl max-w-md w-full mx-4 transform transition-all duration-300 scale-95 opacity-0" id="deleteModalContent">
        <div class="p-8">
            <!-- Icon -->
            <div class="w-16 h-16 bg-red-100 dark:bg-red-900/30 rounded-2xl flex items-center justify-center mx-auto mb-6">
                <svg class="w-8 h-8 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.732-.833-2.5 0L4.268 18.5c-.77.833.192 2.5 1.732 2.5z"></path>
                </svg>
            </div>
            
            <!-- Content -->
            <h3 class="text-2xl font-bold text-gray-900 dark:text-white text-center mb-4">Delete Teacher</h3>
            <p class="text-gray-600 dark:text-gray-400 text-center mb-8">
                Are you sure you want to delete <span class="font-semibold text-gray-900 dark:text-white" id="teacherName"></span>? 
                This action will move the teacher to the deleted section where you can restore them later.
            </p>
            
            <!-- Actions -->
            <div class="flex gap-3">
                <button onclick="closeDeleteModal()" 
                        class="flex-1 px-6 py-3 bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-300 font-semibold rounded-xl transition-all duration-200">
                    Cancel
                </button>
                <button onclick="confirmDelete()" 
                        class="flex-1 px-6 py-3 bg-red-600 hover:bg-red-700 text-white font-semibold rounded-xl transition-all duration-200 shadow-lg hover:shadow-xl">
                    Delete Teacher
                </button>
            </div>
        </div>
    </div>
</div>

<script>
let teacherToDelete = null;

function deleteTeacher(teacherId, teacherName) {
    teacherToDelete = teacherId;
    document.getElementById('teacherName').textContent = teacherName;
    
    const modal = document.getElementById('deleteModal');
    const modalContent = document.getElementById('deleteModalContent');
    
    modal.classList.remove('hidden');
    
    // Trigger animation
    setTimeout(() => {
        modalContent.classList.remove('scale-95', 'opacity-0');
        modalContent.classList.add('scale-100', 'opacity-100');
    }, 10);
}

function closeDeleteModal() {
    const modal = document.getElementById('deleteModal');
    const modalContent = document.getElementById('deleteModalContent');
    
    modalContent.classList.remove('scale-100', 'opacity-100');
    modalContent.classList.add('scale-95', 'opacity-0');
    
    setTimeout(() => {
        modal.classList.add('hidden');
        teacherToDelete = null;
    }, 300);
}

function confirmDelete() {
    if (teacherToDelete) {
        // Create form and submit
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = `/partner/teachers/${teacherToDelete}`;
        
        // Add CSRF token
        const csrfToken = document.createElement('input');
        csrfToken.type = 'hidden';
        csrfToken.name = '_token';
        csrfToken.value = '{{ csrf_token() }}';
        form.appendChild(csrfToken);
        
        // Add method override for DELETE
        const methodField = document.createElement('input');
        methodField.type = 'hidden';
        methodField.name = '_method';
        methodField.value = 'DELETE';
        form.appendChild(methodField);
        
        document.body.appendChild(form);
        form.submit();
    }
}

// Close modal on backdrop click
document.getElementById('deleteModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeDeleteModal();
    }
});

// Flash message functionality
function dismissMessage(messageId) {
    const message = document.getElementById(messageId);
    if (message) {
        message.style.opacity = '0';
        message.style.transform = 'translateY(-10px)';
        setTimeout(() => {
            message.remove();
        }, 300);
    }
}

// Auto-dismiss flash messages after 5 seconds
document.addEventListener('DOMContentLoaded', function() {
    const successMessage = document.getElementById('successMessage');
    const errorMessage = document.getElementById('errorMessage');
    
    if (successMessage) {
        setTimeout(() => {
            dismissMessage('successMessage');
        }, 5000);
    }
    
    if (errorMessage) {
        setTimeout(() => {
            dismissMessage('errorMessage');
        }, 7000); // Error messages stay longer
    }
});
</script>
@endsection
