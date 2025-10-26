@extends('layouts.partner-layout')

@section('title', 'Deleted Teachers')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-slate-50 via-blue-50 to-indigo-50 dark:from-gray-900 dark:via-slate-900 dark:to-gray-900">
    <div class="container mx-auto px-4 py-6 sm:px-6 lg:px-8">
        <!-- Mobile-First Header -->
        <div class="mb-8">
            <div class="flex items-center gap-4 mb-6">
                <a href="{{ route('partner.teachers.index') }}" 
                   class="group flex items-center justify-center w-12 h-12 bg-white dark:bg-gray-800 rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 hover:scale-105">
                    <svg class="w-5 h-5 text-gray-600 dark:text-gray-400 group-hover:text-blue-600 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                    </svg>
                </a>
                <div class="flex-1">
                    <h1 class="text-2xl sm:text-3xl lg:text-4xl font-bold bg-gradient-to-r from-gray-900 via-red-600 to-orange-600 dark:from-white dark:via-red-400 dark:to-orange-400 bg-clip-text text-transparent">
                        Deleted Teachers
                    </h1>
                    <p class="text-sm sm:text-base text-gray-600 dark:text-gray-400 mt-1">
                        Manage soft deleted teachers - restore or permanently delete
                    </p>
                </div>
            </div>
        </div>

        <!-- Teachers Table -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl border border-gray-200 dark:border-gray-700 overflow-hidden">
            <div class="bg-gradient-to-r from-red-500 to-orange-600 px-6 py-4">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-white/20 rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                            </svg>
                        </div>
                        <div>
                            <h2 class="text-xl font-bold text-white">Deleted Teachers</h2>
                            <p class="text-red-100 text-sm">{{ $teachers->total() }} deleted teachers found</p>
                        </div>
                    </div>
                </div>
            </div>

            @if($teachers->count() > 0)
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-gray-50 dark:bg-gray-700">
                            <tr>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider">Teacher</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider">Contact</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider">Deleted</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 dark:divide-gray-600">
                            @foreach($teachers as $teacher)
                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-4">
                                            <div class="w-12 h-12 rounded-full overflow-hidden bg-gradient-to-br from-gray-200 to-gray-300 dark:from-gray-600 dark:to-gray-700 flex items-center justify-center">
                                                @if($teacher->photo)
                                                    <img src="{{ $teacher->photo_url }}" alt="{{ $teacher->full_name }}" class="w-full h-full object-cover"
                                                         onerror="this.onerror=null;this.src='data:image/svg+xml;utf8,\
                                                         <svg xmlns=\'http://www.w3.org/2000/svg\' width=\'48\' height=\'48\' viewBox=\'0 0 48 48\'>\
                                                           <defs>\
                                                             <linearGradient id=\'grad\' x1=\'0%\' y1=\'0%\' x2=\'100%\' y2=\'100%\'>\
                                                               <stop offset=\'0%\' style=\'stop-color:%233b82f6;stop-opacity:1\' />\
                                                               <stop offset=\'100%\' style=\'stop-color:%238b5cf6;stop-opacity:1\' />\
                                                             </linearGradient>\
                                                           </defs>\
                                                           <rect width=\'48\' height=\'48\' rx=\'8\' fill=\'url(%23grad)\'/>\
                                                           <circle cx=\'24\' cy=\'18\' r=\'6\' fill=\'white\' opacity=\'0.9\'/>\
                                                           <path d=\'M17 34 Q24 28 31 34 L31 42 L17 42 Z\' fill=\'white\' opacity=\'0.9\'/>\
                                                           <text x=\'24\' y=\'38\' text-anchor=\'middle\' fill=\'white\' font-size=\'8\' font-weight=\'bold\' font-family=\'system-ui\'>{{ urlencode(Str::substr($teacher->full_name,0,1)) }}</text>\
                                                         </svg>'">
                                                @else
                                                    <i class="fas fa-user text-gray-500 dark:text-gray-400"></i>
                                                @endif
                                            </div>
                                            <div>
                                                <div class="font-semibold text-gray-900 dark:text-white">{{ $teacher->full_name }}</div>
                                                <div class="text-sm text-gray-500 dark:text-gray-400">ID: {{ $teacher->teacher_id }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="text-sm text-gray-900 dark:text-white">{{ $teacher->phone }}</div>
                                        @if($teacher->email)
                                            <div class="text-sm text-gray-500 dark:text-gray-400">{{ $teacher->email }}</div>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-red-100 text-red-800 dark:bg-red-900/20 dark:text-red-400">
                                            <i class="fas fa-trash mr-1"></i>
                                            Deleted
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-500 dark:text-gray-400">
                                        {{ $teacher->deleted_at->format('M d, Y') }}
                                        <div class="text-xs">{{ $teacher->deleted_at->diffForHumans() }}</div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-2">
                                            <!-- Restore Button -->
                                            <form action="{{ route('partner.teachers.restore', $teacher->id) }}" method="POST" class="inline">
                                                @csrf
                                                <button type="submit" 
                                                        class="group flex items-center gap-2 px-3 py-2 bg-green-100 hover:bg-green-200 dark:bg-green-900/20 dark:hover:bg-green-900/30 text-green-700 dark:text-green-400 text-sm font-medium rounded-lg transition-all duration-200 hover:scale-105"
                                                        onclick="return confirm('Are you sure you want to restore this teacher?')">
                                                    <i class="fas fa-undo text-xs"></i>
                                                    <span class="hidden sm:inline">Restore</span>
                                                </button>
                                            </form>

                                            <!-- Force Delete Button -->
                                            <form action="{{ route('partner.teachers.force-delete', $teacher->id) }}" method="POST" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" 
                                                        class="group flex items-center gap-2 px-3 py-2 bg-red-100 hover:bg-red-200 dark:bg-red-900/20 dark:hover:bg-red-900/30 text-red-700 dark:text-red-400 text-sm font-medium rounded-lg transition-all duration-200 hover:scale-105"
                                                        onclick="return confirm('Are you sure you want to permanently delete this teacher? This action cannot be undone!')">
                                                    <i class="fas fa-trash text-xs"></i>
                                                    <span class="hidden sm:inline">Delete</span>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="px-6 py-4 border-t border-gray-200 dark:border-gray-600">
                    {{ $teachers->links() }}
                </div>
            @else
                <div class="px-6 py-12 text-center">
                    <div class="w-16 h-16 mx-auto mb-4 bg-gray-100 dark:bg-gray-700 rounded-full flex items-center justify-center">
                        <i class="fas fa-trash text-2xl text-gray-400"></i>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">No Deleted Teachers</h3>
                    <p class="text-gray-500 dark:text-gray-400 mb-6">There are no soft deleted teachers to display.</p>
                    <a href="{{ route('partner.teachers.index') }}" 
                       class="inline-flex items-center gap-2 px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition-colors">
                        <i class="fas fa-arrow-left"></i>
                        Back to Teachers
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
