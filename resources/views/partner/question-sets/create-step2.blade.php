@extends('layouts.partner-layout')

@section('title', 'Create Question Set - Step 2')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Create Question Set - Step 2</h1>
            <p class="text-gray-600 dark:text-gray-400">Continue setting up your question set</p>
        </div>
        <a href="{{ route('partner.question-sets.index') }}" 
           class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg">
            Back to Question Sets
        </a>
    </div>

    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6">
        <p class="text-gray-700 dark:text-gray-300">This is a placeholder for step 2. Add your step-two form or content here.</p>
        <div class="mt-6">
            <a href="{{ route('partner.question-sets.create') }}" class="text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300">Go to Step 1</a>
        </div>
    </div>
</div>
@endsection 
