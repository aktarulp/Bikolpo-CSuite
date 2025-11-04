@extends('system-admin.system-admin-layout')

@section('title', 'QCReator Details')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-indigo-50 via-purple-50 to-pink-50 dark:from-gray-900 dark:via-gray-800 dark:to-gray-900 py-4">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg border border-gray-200 dark:border-gray-700 p-6 mb-6">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900 dark:text-white">QCReator Details</h1>
                    <p class="text-gray-600 dark:text-gray-400 mt-1">View detailed information about this question creator</p>
                </div>
                <div class="flex items-center gap-3">
                    <a href="{{ route('system-admin.qcreators.index') }}" 
                       class="inline-flex items-center gap-2 bg-gray-200 dark:bg-gray-700 hover:bg-gray-300 dark:hover:bg-gray-600 text-gray-800 dark:text-gray-200 font-semibold rounded-xl px-4 py-2 transition-all duration-300">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                        <span>Back to List</span>
                    </a>
                    <a href="{{ route('system-admin.qcreators.edit', $qcreator) }}" 
                       class="inline-flex items-center gap-2 bg-gradient-to-r from-purple-600 to-indigo-600 hover:from-purple-700 hover:to-indigo-700 text-white font-semibold rounded-xl px-4 py-2 transition-all duration-300">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                        </svg>
                        <span>Edit</span>
                    </a>
                </div>
            </div>
        </div>

        <!-- Creator Details -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg border border-gray-200 dark:border-gray-700 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                <h2 class="text-lg font-semibold text-gray-900 dark:text-white">Creator Information</h2>
            </div>
            
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <!-- Photo -->
                    <div class="md:col-span-1">
                        <div class="bg-gray-100 dark:bg-gray-700 rounded-xl p-4 flex flex-col items-center">
                            @if($qcreator->photo)
                                <img src="{{ asset('storage/' . $qcreator->photo) }}" alt="{{ $qcreator->full_name }}" class="w-48 h-48 object-cover rounded-lg shadow-md">
                            @else
                                <div class="bg-gradient-to-br from-purple-400 to-indigo-600 w-48 h-48 rounded-lg flex items-center justify-center shadow-md">
                                    <span class="text-5xl font-bold text-white">{{ substr($qcreator->full_name, 0, 1) }}</span>
                                </div>
                            @endif
                            <h3 class="mt-4 text-xl font-bold text-gray-900 dark:text-white text-center">{{ $qcreator->full_name }}</h3>
                            <p class="text-gray-600 dark:text-gray-400 text-center">{{ $qcreator->designation ?? 'No designation' }}</p>
                        </div>
                    </div>
                    
                    <!-- Details -->
                    <div class="md:col-span-2 space-y-6">
                        <!-- Basic Information -->
                        <div class="bg-gray-50 dark:bg-gray-700/50 rounded-xl p-5">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Basic Information</h3>
                            <div class="space-y-4">
                                <div class="flex">
                                    <div class="w-1/3 text-sm font-medium text-gray-500 dark:text-gray-400">Full Name</div>
                                    <div class="w-2/3 text-sm text-gray-900 dark:text-white">{{ $qcreator->full_name }}</div>
                                </div>
                                
                                <div class="flex">
                                    <div class="w-1/3 text-sm font-medium text-gray-500 dark:text-gray-400">Designation</div>
                                    <div class="w-2/3 text-sm text-gray-900 dark:text-white">{{ $qcreator->designation ?? '-' }}</div>
                                </div>
                                
                                <div class="flex">
                                    <div class="w-1/3 text-sm font-medium text-gray-500 dark:text-gray-400">Organization</div>
                                    <div class="w-2/3 text-sm text-gray-900 dark:text-white">{{ $qcreator->organization ?? '-' }}</div>
                                </div>
                                
                                <div class="flex">
                                    <div class="w-1/3 text-sm font-medium text-gray-500 dark:text-gray-400">Email</div>
                                    <div class="w-2/3 text-sm text-gray-900 dark:text-white">{{ $qcreator->email ?? '-' }}</div>
                                </div>
                                
                                <div class="flex">
                                    <div class="w-1/3 text-sm font-medium text-gray-500 dark:text-gray-400">Phone</div>
                                    <div class="w-2/3 text-sm text-gray-900 dark:text-white">{{ $qcreator->phone ?? '-' }}</div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Experiences -->
                        <div class="bg-gray-50 dark:bg-gray-700/50 rounded-xl p-5">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Experiences</h3>
                            @if($qcreator->experiences)
                                <div class="prose prose-sm max-w-none dark:prose-invert">
                                    <p class="text-gray-700 dark:text-gray-300 whitespace-pre-line">{{ $qcreator->experiences }}</p>
                                </div>
                            @else
                                <p class="text-gray-500 dark:text-gray-400 italic">No experiences provided</p>
                            @endif
                        </div>
                        
                        <!-- Remarks -->
                        @if($qcreator->remarks)
                        <div class="bg-gray-50 dark:bg-gray-700/50 rounded-xl p-5">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Remarks</h3>
                            <div class="prose prose-sm max-w-none dark:prose-invert">
                                <p class="text-gray-700 dark:text-gray-300 whitespace-pre-line">{{ $qcreator->remarks }}</p>
                            </div>
                        </div>
                        @endif
                        
                        <!-- Metadata -->
                        <div class="bg-gray-50 dark:bg-gray-700/50 rounded-xl p-5">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Metadata</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div class="flex">
                                    <div class="w-1/2 text-sm font-medium text-gray-500 dark:text-gray-400">Created At</div>
                                    <div class="w-1/2 text-sm text-gray-900 dark:text-white">{{ $qcreator->created_at->format('M d, Y H:i') }}</div>
                                </div>
                                
                                <div class="flex">
                                    <div class="w-1/2 text-sm font-medium text-gray-500 dark:text-gray-400">Last Updated</div>
                                    <div class="w-1/2 text-sm text-gray-900 dark:text-white">{{ $qcreator->updated_at->format('M d, Y H:i') }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection