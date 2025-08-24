@extends('layouts.partner-layout')

@section('title', 'Batch Details')

@section('content')
<div class="space-y-6">
    <!-- Page Header -->
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Batch Details</h1>
            <p class="text-gray-600 dark:text-gray-400">View batch information</p>
        </div>
        <div class="flex space-x-3">
            <a href="{{ route('partner.batches.edit', $batch) }}" 
               class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg transition-colors duration-200">
                Edit Batch
            </a>
            <a href="{{ route('partner.batches.index') }}" 
               class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg transition-colors duration-200">
                Back to Batches
            </a>
        </div>
    </div>

    <!-- Batch Information -->
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md border border-gray-200 dark:border-gray-700">
        <div class="p-6 border-b border-gray-200 dark:border-gray-700">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Batch Information</h3>
        </div>
        
        <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Batch Name</label>
                    <p class="text-lg text-gray-900 dark:text-white">{{ $batch->name }}</p>
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Year</label>
                    <p class="text-lg text-gray-900 dark:text-white">{{ $batch->year }}</p>
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Status</label>
                    <span class="inline-flex px-3 py-1 text-sm font-semibold rounded-full
                        @if($batch->status === 'active') bg-green-100 text-green-800
                        @else bg-red-100 text-red-800 @endif">
                        {{ ucfirst($batch->status) }}
                    </span>
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Created At</label>
                    <p class="text-lg text-gray-900 dark:text-white">{{ $batch->created_at->format('M d, Y H:i A') }}</p>
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Last Updated</label>
                    <p class="text-lg text-gray-900 dark:text-white">{{ $batch->updated_at->format('M d, Y H:i A') }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Actions -->
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md border border-gray-200 dark:border-gray-700">
        <div class="p-6 border-b border-gray-200 dark:border-gray-700">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Actions</h3>
        </div>
        
        <div class="p-6">
            <div class="flex space-x-4">
                <a href="{{ route('partner.batches.edit', $batch) }}" 
                   class="bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-2 rounded-lg transition-colors duration-200">
                    Edit Batch
                </a>
                
                <form action="{{ route('partner.batches.destroy', $batch) }}" method="POST" class="inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" 
                            class="bg-red-600 hover:bg-red-700 text-white px-6 py-2 rounded-lg transition-colors duration-200"
                            onclick="return confirm('Are you sure you want to delete this batch?')">
                        Delete Batch
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
