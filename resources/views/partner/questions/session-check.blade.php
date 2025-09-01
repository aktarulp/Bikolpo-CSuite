@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-4xl mx-auto">
        <div class="bg-white rounded-lg shadow-lg p-6 mb-6">
            <h1 class="text-3xl font-bold text-gray-800 mb-6">Session Check & MCQ Seeding</h1>
            
            <!-- Session Information -->
            <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-6">
                <h2 class="text-xl font-semibold text-blue-800 mb-4">Session Information</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <span class="font-medium text-gray-700">Authentication Status:</span>
                        <span class="ml-2 px-2 py-1 rounded text-sm {{ $sessionData['authenticated'] ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                            {{ $sessionData['authenticated'] ? 'Authenticated' : 'Not Authenticated' }}
                        </span>
                    </div>
                    <div>
                        <span class="font-medium text-gray-700">User ID:</span>
                        <span class="ml-2 text-gray-600">{{ $sessionData['user_id'] ?? 'N/A' }}</span>
                    </div>
                    <div>
                        <span class="font-medium text-gray-700">User Name:</span>
                        <span class="ml-2 text-gray-600">{{ $sessionData['user_name'] ?? 'N/A' }}</span>
                    </div>
                    <div>
                        <span class="font-medium text-gray-700">User Email:</span>
                        <span class="ml-2 text-gray-600">{{ $sessionData['user_email'] ?? 'N/A' }}</span>
                    </div>
                    <div>
                        <span class="font-medium text-gray-700">User Role:</span>
                        <span class="ml-2 text-gray-600">{{ $sessionData['user_role'] ?? 'N/A' }}</span>
                    </div>
                    <div>
                        <span class="font-medium text-gray-700">Session ID:</span>
                        <span class="ml-2 text-gray-600 font-mono text-sm">{{ $sessionData['session_id'] ?? 'N/A' }}</span>
                    </div>
                    <div>
                        <span class="font-medium text-gray-700">Session Lifetime:</span>
                        <span class="ml-2 text-gray-600">{{ $sessionData['session_lifetime'] ?? 'N/A' }} minutes</span>
                    </div>
                    <div>
                        <span class="font-medium text-gray-700">Session Driver:</span>
                        <span class="ml-2 text-gray-600">{{ $sessionData['session_driver'] ?? 'N/A' }}</span>
                    </div>
                    <div>
                        <span class="font-medium text-gray-700">Timestamp:</span>
                        <span class="ml-2 text-gray-600">{{ $sessionData['timestamp'] ?? 'N/A' }}</span>
                    </div>
                </div>
            </div>

            @if(isset($sessionData['partner']))
            <!-- Partner Information -->
            <div class="bg-green-50 border border-green-200 rounded-lg p-4 mb-6">
                <h2 class="text-xl font-semibold text-green-800 mb-4">Partner Information</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <span class="font-medium text-gray-700">Partner ID:</span>
                        <span class="ml-2 text-gray-600">{{ $sessionData['partner']['id'] }}</span>
                    </div>
                    <div>
                        <span class="font-medium text-gray-700">Partner Name:</span>
                        <span class="ml-2 text-gray-600">{{ $sessionData['partner']['name'] }}</span>
                    </div>
                    <div>
                        <span class="font-medium text-gray-700">Partner Status:</span>
                        <span class="ml-2 px-2 py-1 rounded text-sm {{ $sessionData['partner']['status'] === 'active' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                            {{ ucfirst($sessionData['partner']['status']) }}
                        </span>
                    </div>
                    <div>
                        <span class="font-medium text-gray-700">User ID:</span>
                        <span class="ml-2 text-gray-600">{{ $sessionData['partner']['user_id'] }}</span>
                    </div>
                </div>
            </div>

            <!-- Question Counts -->
            @if(isset($sessionData['question_counts']))
            <div class="bg-purple-50 border border-purple-200 rounded-lg p-4 mb-6">
                <h2 class="text-xl font-semibold text-purple-800 mb-4">Current Question Counts</h2>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div class="text-center">
                        <div class="text-3xl font-bold text-purple-600">{{ $sessionData['question_counts']['total'] }}</div>
                        <div class="text-sm text-gray-600">Total Questions</div>
                    </div>
                    <div class="text-center">
                        <div class="text-3xl font-bold text-blue-600">{{ $sessionData['question_counts']['mcq'] }}</div>
                        <div class="text-sm text-gray-600">MCQ Questions</div>
                    </div>
                    <div class="text-center">
                        <div class="text-3xl font-bold text-green-600">{{ $sessionData['question_counts']['descriptive'] }}</div>
                        <div class="text-sm text-gray-600">Descriptive Questions</div>
                    </div>
                </div>
            </div>
            @endif

            <!-- MCQ Seeding Form -->
            <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
                <h2 class="text-xl font-semibold text-yellow-800 mb-4">Seed MCQ Questions</h2>
                <form action="{{ route('partner.seed-mcq-questions') }}" method="POST" class="space-y-4">
                    @csrf
                    <div>
                        <label for="count" class="block text-sm font-medium text-gray-700 mb-2">Number of MCQ Questions to Create:</label>
                        <input type="number" id="count" name="count" value="100" min="1" max="500" 
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <p class="text-sm text-gray-500 mt-1">Maximum 500 questions allowed per request</p>
                    </div>
                    <div class="flex items-center space-x-4">
                        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-6 rounded-md transition duration-200">
                            Seed MCQ Questions
                        </button>
                        <a href="{{ route('partner.questions.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white font-medium py-2 px-6 rounded-md transition duration-200">
                            Back to Questions
                        </a>
                    </div>
                </form>
            </div>
            @else
            <!-- Not a Partner -->
            <div class="bg-red-50 border border-red-200 rounded-lg p-4">
                <h2 class="text-xl font-semibold text-red-800 mb-4">Access Denied</h2>
                <p class="text-red-700">You must be logged in as a partner to access this functionality.</p>
                <div class="mt-4">
                    <a href="{{ route('login') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-6 rounded-md transition duration-200">
                        Login
                    </a>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
