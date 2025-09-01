@extends('layouts.partner-layout')

@section('title', 'Test Settings')

@section('content')
<div class="min-h-screen bg-gray-50 dark:bg-gray-900">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-8">Test Settings Page</h1>
        
        @if($partner)
            <div class="bg-white dark:bg-gray-800 shadow-sm rounded-lg border border-gray-200 dark:border-gray-700 p-6">
                <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-4">Partner Information</h2>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Partner ID</label>
                        <p class="text-gray-900 dark:text-white">{{ $partner->id ?? 'N/A' }}</p>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Name</label>
                        <p class="text-gray-900 dark:text-white">{{ $partner->name ?? 'N/A' }}</p>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Institute Name</label>
                        <p class="text-gray-900 dark:text-white">{{ $partner->institute_name ?? 'N/A' }}</p>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Email</label>
                        <p class="text-gray-900 dark:text-white">{{ $partner->email ?? 'N/A' }}</p>
                    </div>
                </div>
                
                <div class="mt-6">
                    <a href="{{ route('partner.dashboard') }}" class="inline-flex items-center px-4 py-2 bg-primaryGreen text-white rounded-lg hover:bg-primaryGreen/90 transition-colors duration-200">
                        Back to Dashboard
                    </a>
                </div>
            </div>
        @else
            <div class="bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-lg p-6">
                <h2 class="text-xl font-semibold text-red-900 dark:text-red-100 mb-2">No Partner Found</h2>
                <p class="text-red-700 dark:text-red-300">Partner profile could not be found.</p>
            </div>
        @endif
    </div>
</div>
@endsection
