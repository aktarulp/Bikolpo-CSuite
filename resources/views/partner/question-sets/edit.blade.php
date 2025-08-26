@extends('layouts.partner-layout')

@section('title', 'Edit Question Set')

@section('content')
<div class="max-w-2xl mx-auto">
	<div class="flex justify-between items-center mb-6">
		<div>
			<h1 class="text-3xl font-bold text-gray-900 dark:text-white">Edit Question Set</h1>
			<p class="text-gray-600 dark:text-gray-400">Update details and settings</p>
		</div>
		<div class="flex items-center gap-2">
			<a href="{{ route('partner.question-sets.index') }}" 
			   class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg">
				Back to Sets
			</a>
			<a href="{{ route('partner.question-sets.show', $questionSet) }}" 
			   class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg">
				Manage Questions
			</a>
		</div>
	</div>

	<div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6">
		<!-- Meta summary -->
		<div class="grid grid-cols-2 gap-4 mb-6 text-sm text-gray-600 dark:text-gray-300">
			<div><span class="font-medium">Set ID:</span> #{{ $questionSet->id }}</div>
			<div><span class="font-medium">Created:</span> {{ $questionSet->created_at->format('M d, Y') }}</div>
			<div><span class="font-medium">Questions:</span> {{ $questionSet->total_questions }}</div>
		</div>

		<form action="{{ route('partner.question-sets.update', $questionSet) }}" method="POST">
			@csrf
			@method('PUT')

			<div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
				<div>
					<label class="block text-sm font-medium mb-2">Question Set Name</label>
					<input type="text" name="name" value="{{ old('name', $questionSet->name) }}" required
						   class="w-full rounded-md border p-2">
					@error('name')
						<p class="text-red-500 text-sm mt-1">{{ $message }}</p>
					@enderror
				</div>
			</div>

			<div class="mb-6">
				<label class="block text-sm font-medium mb-2">Status</label>
				<select name="status" class="w-full rounded-md border p-2">
					@php($current = old('status', $questionSet->status))
					<option value="draft" {{ $current === 'draft' ? 'selected' : '' }}>Draft</option>
					<option value="published" {{ $current === 'published' ? 'selected' : '' }}>Published</option>
					<option value="archived" {{ $current === 'archived' ? 'selected' : '' }}>Archived</option>
				</select>
			</div>

			<div class="mb-6">
				<label class="block text-sm font-medium mb-2">Description</label>
				<textarea name="description" rows="3" class="w-full rounded-md border p-2">{{ old('description', $questionSet->description) }}</textarea>
				@error('description')
					<p class="text-red-500 text-sm mt-1">{{ $message }}</p>
				@enderror
			</div>

			<div class="flex justify-between items-center">
				<p class="text-xs text-gray-500 dark:text-gray-400">Note: Questions are auto-calculated from attached questions.</p>
				<div class="space-x-3">
					<a href="{{ route('partner.question-sets.index') }}" 
					   class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-md">Cancel</a>
					<button type="submit" class="bg-primaryGreen hover:bg-green-600 text-white px-4 py-2 rounded-md">Update Question Set</button>
				</div>
			</div>
		</form>
	</div>
</div>
@endsection 


