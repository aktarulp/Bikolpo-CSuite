@extends('layouts.app')

@section('title', 'Create Question Set - Step 2')

@section('content')
<div class="max-w-3xl mx-auto">
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
        <p class="text-gray-700 dark:text-gray-300">This is a placeholder for Step 2 of the question set creation process. Add your step-2 form or actions here.</p>

        <div class="mt-6 flex gap-3 justify-end">
            <a href="{{ route('partner.question-sets.create') }}" class="px-4 py-2 rounded-md bg-gray-100 hover:bg-gray-200 dark:bg-gray-700 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-200">Back to Step 1</a>
            <a href="{{ route('partner.question-sets.index') }}" class="px-4 py-2 rounded-md bg-primaryGreen hover:bg-green-600 text-white">Finish</a>
        </div>
    </div>
</div>
@endsection 

