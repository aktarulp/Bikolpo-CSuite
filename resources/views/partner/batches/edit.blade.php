@extends('layouts.partner-layout')

@section('title', 'Edit Batch')

@section('content')
<div class="space-y-6">
    <!-- Page Header -->
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Edit Batch</h1>
            <p class="text-gray-600 dark:text-gray-400">Update batch information</p>
        </div>
        <a href="{{ route('partner.batches.index') }}" 
           class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg transition-colors duration-200">
            Back to Batches
        </a>
    </div>

    <!-- Edit Form -->
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md border border-gray-200 dark:border-gray-700">
        <div class="p-6 border-b border-gray-200 dark:border-gray-700">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Batch Information</h3>
        </div>
        
        <form action="{{ route('partner.batches.update', $batch) }}" method="POST" class="p-6 space-y-6">
            @csrf
            @method('PUT')
            
                         <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Batch Name -->
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Batch Name *</label>
                    <input type="text" id="name" name="name" value="{{ old('name', $batch->name) }}" required
                           class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primaryGreen focus:border-primaryGreen dark:bg-gray-700 dark:text-white"
                           placeholder="e.g., Morning Batch, Evening Batch">
                    @error('name')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                                   <!-- Year -->
                   <div>
                       <label for="year" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Year *</label>
                       <input type="number" id="year" name="year" value="{{ old('year', $batch->year) }}" required min="2000" max="2030"
                              class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primaryGreen focus:border-primaryGreen dark:bg-gray-700 dark:text-white"
                              placeholder="e.g., 2024">
                       @error('year')
                           <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                       @enderror
                   </div>

                <!-- Status -->
                <div>
                    <label for="status" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Status *</label>
                    <select id="status" name="status" required
                            class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primaryGreen focus:border-primaryGreen dark:bg-gray-700 dark:text-white">
                        <option value="">Select Status</option>
                        <option value="active" {{ old('status', $batch->status) == 'active' ? 'selected' : '' }}>Active</option>
                        <option value="inactive" {{ old('status', $batch->status) == 'inactive' ? 'selected' : '' }}>Inactive</option>
                    </select>
                    @error('status')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Form Actions -->
            <div class="flex justify-end space-x-3 pt-6 border-t border-gray-200 dark:border-gray-700">
                <a href="{{ route('partner.batches.index') }}" 
                   class="px-6 py-2 border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors duration-200">
                    Cancel
                </a>
                <button type="submit" 
                        class="px-6 py-2 bg-primaryGreen hover:bg-green-600 text-white rounded-lg transition-colors duration-200">
                    Update Batch
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
