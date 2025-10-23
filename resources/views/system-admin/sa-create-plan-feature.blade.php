@extends('system-admin.system-admin-layout')

@section('title', 'Create Plan Feature - System Admin')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-slate-50 via-blue-50 to-indigo-100 dark:from-slate-900 dark:via-slate-800 dark:to-slate-900">
    <!-- Header -->
    <div class="bg-white/80 dark:bg-slate-800/80 backdrop-blur-sm border-b border-slate-200/50 dark:border-slate-700/50">
        <div class="px-4 sm:px-6 lg:px-8 py-6">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div class="flex items-center space-x-3">
                    <div class="p-2 bg-gradient-to-r from-blue-500 to-indigo-600 rounded-lg">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                        </svg>
                    </div>
                    <div>
                        <h1 class="text-2xl font-bold bg-gradient-to-r from-slate-900 to-slate-700 dark:from-white dark:to-slate-200 bg-clip-text text-transparent">Create Feature</h1>
                        <p class="text-sm text-slate-600 dark:text-slate-400">Add a new plan feature</p>
                    </div>
                </div>
                <div class="flex items-center space-x-3">
                    <button type="submit" 
                            form="feature-form"
                            class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white text-sm font-semibold rounded-lg transition-all duration-200 hover:shadow-lg transform hover:-translate-y-0.5">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        Create Feature
                    </button>
                    <a href="{{ route('system-admin.plan-features') }}" 
                       class="inline-flex items-center px-4 py-2 bg-white/80 dark:bg-slate-700/80 hover:bg-white dark:hover:bg-slate-700 border border-slate-200 dark:border-slate-600 rounded-lg text-sm font-semibold text-slate-700 dark:text-slate-300 transition-all duration-200 hover:shadow-md">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                        Cancel & Back
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Form -->
    <div class="px-4 sm:px-6 lg:px-8 py-6">
        <form id="feature-form" action="{{ route('system-admin.plan-features.store') }}" method="POST" class="max-w-3xl mx-auto">
            @csrf
            
            <div class="space-y-6">
                <!-- Basic Information -->
                <div class="bg-white/70 dark:bg-slate-800/70 backdrop-blur-sm rounded-2xl shadow-xl border border-white/20 dark:border-slate-700/50 p-6">
                    <div class="flex items-center space-x-3 mb-6">
                        <div class="p-2 bg-gradient-to-r from-emerald-500 to-teal-600 rounded-lg">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                            </svg>
                        </div>
                        <h3 class="text-lg font-semibold text-slate-900 dark:text-white">Basic Information</h3>
                    </div>
                    
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
                        <div class="space-y-2">
                            <label for="name" class="block text-sm font-semibold text-slate-700 dark:text-slate-300">
                                Feature Name <span class="text-red-500">*</span>
                            </label>
                            <input type="text" 
                                   id="name" 
                                   name="name" 
                                   value="{{ old('name') }}"
                                   class="w-full px-4 py-3 bg-white/80 dark:bg-slate-700/80 border border-slate-200 dark:border-slate-600 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:text-white transition-all duration-200 hover:shadow-sm"
                                   placeholder="e.g., Student Dashboard"
                                   required>
                            @error('name')
                                <p class="text-sm text-red-500 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="space-y-2">
                            <label for="slug" class="block text-sm font-semibold text-slate-700 dark:text-slate-300">
                                Slug <span class="text-red-500">*</span>
                            </label>
                            <input type="text" 
                                   id="slug" 
                                   name="slug" 
                                   value="{{ old('slug') }}"
                                   class="w-full px-4 py-3 bg-white/80 dark:bg-slate-700/80 border border-slate-200 dark:border-slate-600 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:text-white transition-all duration-200 hover:shadow-sm"
                                   placeholder="e.g., student_dashboard"
                                   required>
                            <p class="text-xs text-slate-500 dark:text-slate-400">Auto-generated from name</p>
                            @error('slug')
                                <p class="text-sm text-red-500 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="mt-4">
                        <label for="description" class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-2">
                            Description
                        </label>
                        <textarea id="description" 
                                  name="description" 
                                  rows="3"
                                  class="w-full px-4 py-3 bg-white/80 dark:bg-slate-700/80 border border-slate-200 dark:border-slate-600 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:text-white transition-all duration-200 hover:shadow-sm resize-none"
                                  placeholder="Describe what this feature does...">{{ old('description') }}</textarea>
                        @error('description')
                            <p class="text-sm text-red-500 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Feature Configuration -->
                <div class="bg-white/70 dark:bg-slate-800/70 backdrop-blur-sm rounded-2xl shadow-xl border border-white/20 dark:border-slate-700/50 p-6">
                    <div class="flex items-center space-x-3 mb-6">
                        <div class="p-2 bg-gradient-to-r from-purple-500 to-pink-600 rounded-lg">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                        </div>
                        <h3 class="text-lg font-semibold text-slate-900 dark:text-white">Configuration</h3>
                    </div>
                    
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
                        <!-- Feature Type -->
                        <div class="space-y-2">
                            <label for="type" class="block text-sm font-semibold text-slate-700 dark:text-slate-300">
                                Feature Type <span class="text-red-500">*</span>
                            </label>
                            <select id="type" 
                                    name="type"
                                    onchange="toggleTypeFields()"
                                    class="w-full px-4 py-3 bg-white/80 dark:bg-slate-700/80 border border-slate-200 dark:border-slate-600 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:text-white transition-all duration-200 hover:shadow-sm"
                                    required>
                                <option value="">Select a type</option>
                                @foreach($featureTypes as $key => $label)
                                <option value="{{ $key }}" {{ old('type') == $key ? 'selected' : '' }}>{{ $label }}</option>
                                @endforeach
                            </select>
                            @error('type')
                                <p class="text-sm text-red-500 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Category -->
                        <div class="space-y-2">
                            <label for="category" class="block text-sm font-semibold text-slate-700 dark:text-slate-300">
                                Category <span class="text-red-500">*</span>
                            </label>
                            <select id="category" 
                                    name="category"
                                    class="w-full px-4 py-3 bg-white/80 dark:bg-slate-700/80 border border-slate-200 dark:border-slate-600 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:text-white transition-all duration-200 hover:shadow-sm"
                                    required>
                                <option value="">Select a category</option>
                                @foreach($categories as $key => $label)
                                <option value="{{ $key }}" {{ old('category') == $key ? 'selected' : '' }}>{{ $label }}</option>
                                @endforeach
                            </select>
                            @error('category')
                                <p class="text-sm text-red-500 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 mt-4">
                        <!-- Feature For -->
                        <div class="space-y-2">
                            <label for="feature_for" class="block text-sm font-semibold text-slate-700 dark:text-slate-300">
                                Feature For <span class="text-red-500">*</span>
                            </label>
                            <select id="feature_for" 
                                    name="feature_for"
                                    class="w-full px-4 py-3 bg-white/80 dark:bg-slate-700/80 border border-slate-200 dark:border-slate-600 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:text-white transition-all duration-200 hover:shadow-sm"
                                    required>
                                <option value="">Select target audience</option>
                                <option value="partner" {{ old('feature_for') == 'partner' ? 'selected' : '' }}>Partner Plans</option>
                                <option value="student" {{ old('feature_for') == 'student' ? 'selected' : '' }}>Student Plans</option>
                                <option value="both" {{ old('feature_for') == 'both' ? 'selected' : '' }}>Both Partner & Student</option>
                            </select>
                            <p class="text-xs text-slate-500 dark:text-slate-400">Choose which plan types this feature applies to</p>
                            @error('feature_for')
                                <p class="text-sm text-red-500 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Unit -->
                        <div class="space-y-2">
                            <label for="unit" class="block text-sm font-semibold text-slate-700 dark:text-slate-300">
                                Unit
                            </label>
                            <input type="text" 
                                   id="unit" 
                                   name="unit" 
                                   value="{{ old('unit') }}"
                                   class="w-full px-4 py-3 bg-white/80 dark:bg-slate-700/80 border border-slate-200 dark:border-slate-600 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:text-white transition-all duration-200 hover:shadow-sm"
                                   placeholder="e.g., users, GB, months">
                            <p class="text-xs text-slate-500 dark:text-slate-400">Unit of measurement (optional)</p>
                            @error('unit')
                                <p class="text-sm text-red-500 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="mt-4">
                        <label for="default_value" class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-2">
                            Default Value
                        </label>
                        <input type="text" 
                               id="default_value" 
                               name="default_value" 
                               value="{{ old('default_value') }}"
                               class="w-full px-4 py-3 bg-white/80 dark:bg-slate-700/80 border border-slate-200 dark:border-slate-600 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:text-white transition-all duration-200 hover:shadow-sm"
                               placeholder="Default value for this feature">
                        <p class="text-xs text-slate-500 dark:text-slate-400">Optional default value for this feature</p>
                        @error('default_value')
                            <p class="text-sm text-red-500 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Options for Select Type -->
                    <div id="optionsSection" class="mt-6 hidden">
                        <label for="options" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Options (for Select type)
                        </label>
                        <div id="optionsContainer">
                            <div class="flex items-center space-x-2 mb-2">
                                <input type="text" 
                                       name="options[0][key]" 
                                       placeholder="Option key" 
                                       class="flex-1 px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white">
                                <span class="text-gray-500 dark:text-gray-400">:</span>
                                <input type="text" 
                                       name="options[0][value]" 
                                       placeholder="Option label" 
                                       class="flex-1 px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white">
                                <button type="button" 
                                        onclick="removeOption(this)" 
                                        class="px-3 py-2 text-red-600 hover:text-red-800 dark:text-red-400 dark:hover:text-red-300">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                    </svg>
                                </button>
                            </div>
                        </div>
                        <button type="button" 
                                onclick="addOption()" 
                                class="mt-2 inline-flex items-center px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                            </svg>
                            Add Option
                        </button>
                        <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Add options for select type features</p>
                    </div>
                </div>

                <!-- Settings -->
                <div class="bg-white/70 dark:bg-slate-800/70 backdrop-blur-sm rounded-2xl shadow-xl border border-white/20 dark:border-slate-700/50 p-6">
                    <div class="flex items-center space-x-3 mb-6">
                        <div class="p-2 bg-gradient-to-r from-orange-500 to-red-600 rounded-lg">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 100 4m0-4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 100 4m0-4v2m0-6V4"></path>
                            </svg>
                        </div>
                        <h3 class="text-lg font-semibold text-slate-900 dark:text-white">Settings</h3>
                    </div>
                    
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
                        <div class="space-y-2">
                            <label for="sort_order" class="block text-sm font-semibold text-slate-700 dark:text-slate-300">
                                Sort Order
                            </label>
                            <input type="number" 
                                   id="sort_order" 
                                   name="sort_order" 
                                   value="{{ old('sort_order', 0) }}"
                                   min="0"
                                   class="w-full px-4 py-3 bg-white/80 dark:bg-slate-700/80 border border-slate-200 dark:border-slate-600 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:text-white transition-all duration-200 hover:shadow-sm"
                                   placeholder="0">
                            <p class="text-xs text-slate-500 dark:text-slate-400">Lower numbers appear first</p>
                            @error('sort_order')
                                <p class="text-sm text-red-500 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex items-center justify-center lg:justify-start">
                            <div class="flex items-center space-x-3 p-4 bg-slate-50 dark:bg-slate-700/50 rounded-xl">
                                <input type="checkbox" 
                                       id="is_active" 
                                       name="is_active" 
                                       value="1"
                                       {{ old('is_active', true) ? 'checked' : '' }}
                                       class="h-5 w-5 text-blue-600 focus:ring-blue-500 border-slate-300 rounded transition-colors">
                                <label for="is_active" class="text-sm font-semibold text-slate-700 dark:text-slate-300">
                                    Active Feature
                                </label>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </form>
    </div>
</div>

<script>
// Auto-generate slug from name
document.getElementById('name').addEventListener('input', function() {
    const name = this.value;
    const slug = name.toLowerCase()
        .replace(/[^a-z0-9\s-]/g, '')
        .replace(/\s+/g, '_')
        .replace(/-+/g, '_')
        .trim('_');
    document.getElementById('slug').value = slug;
});

// Toggle type-specific fields
function toggleTypeFields() {
    const type = document.getElementById('type').value;
    const optionsSection = document.getElementById('optionsSection');
    
    if (type === 'select') {
        optionsSection.classList.remove('hidden');
    } else {
        optionsSection.classList.add('hidden');
    }
}

// Add option for select type
let optionIndex = 1;
function addOption() {
    const container = document.getElementById('optionsContainer');
    const optionDiv = document.createElement('div');
    optionDiv.className = 'flex items-center space-x-2 mb-2';
    optionDiv.innerHTML = `
        <input type="text" 
               name="options[${optionIndex}][key]" 
               placeholder="Option key" 
               class="flex-1 px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white">
        <span class="text-gray-500 dark:text-gray-400">:</span>
        <input type="text" 
               name="options[${optionIndex}][value]" 
               placeholder="Option label" 
               class="flex-1 px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white">
        <button type="button" 
                onclick="removeOption(this)" 
                class="px-3 py-2 text-red-600 hover:text-red-800 dark:text-red-400 dark:hover:text-red-300">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
        </button>
    `;
    container.appendChild(optionDiv);
    optionIndex++;
}

// Remove option
function removeOption(button) {
    button.parentElement.remove();
}

// Initialize on page load
document.addEventListener('DOMContentLoaded', function() {
    toggleTypeFields();
});
</script>
@endsection
