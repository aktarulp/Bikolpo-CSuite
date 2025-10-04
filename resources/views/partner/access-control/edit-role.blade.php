@extends('layouts.partner-layout')

@section('title', 'Edit Role Permissions')

@section('content')
<div class="space-y-4 md:space-y-6">
    <!-- Page Header -->
    <div class="bg-gradient-to-br from-indigo-900 via-purple-900 to-pink-900 rounded-2xl shadow-2xl p-4 md:p-6 lg:p-8">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <div class="flex-1">
                <div class="flex items-center space-x-3 mb-2">
                    <div class="bg-white/10 backdrop-blur-sm p-2 md:p-3 rounded-xl">
                        <svg class="w-6 h-6 md:w-8 md:h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                        </svg>
                    </div>
                    <div>
                        <h1 class="text-2xl md:text-3xl lg:text-4xl font-bold text-white drop-shadow-lg">Edit Role Permissions</h1>
                        <p class="text-slate-200 text-sm md:text-base">Manage permissions for {{ $role->name }}</p>
                    </div>
                </div>
            </div>
            <div class="flex flex-wrap gap-2 sm:gap-3">
                <a href="{{ route('partner.access-control.index') }}" 
                   class="bg-white/20 hover:bg-white/30 text-white font-semibold px-4 md:px-6 py-2.5 md:py-3 rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 flex items-center space-x-2 group backdrop-blur-sm">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    <span>Back to Access Control</span>
                </a>
            </div>
        </div>
    </div>

    <!-- Edit Form -->
    <div class="bg-white dark:bg-gray-800 rounded-xl md:rounded-2xl shadow-lg border-2 border-gray-100 dark:border-gray-700">
        <div class="p-4 md:p-6 border-b border-gray-200 dark:border-gray-700">
            <div class="flex items-center space-x-2">
                <div class="bg-gradient-to-r from-indigo-600 to-purple-600 p-2 rounded-lg">
                    <svg class="w-4 h-4 md:w-5 md:h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                </div>
                <h2 class="text-base md:text-lg font-bold text-gray-900 dark:text-white">Permissions for {{ $role->name }}</h2>
            </div>
        </div>

        <form action="{{ route('partner.access-control.update-role-permissions', $role) }}" method="POST" class="p-4 md:p-6">
            @csrf
            @method('PUT')
            
            <div class="space-y-6">
                <!-- Permission Groups -->
                @foreach($permissionConfig as $moduleKey => $module)
                <div class="bg-gray-50 dark:bg-gray-700 rounded-xl p-4">
                    <div class="flex items-center justify-between mb-4">
                        <h4 class="text-lg font-semibold text-gray-900 dark:text-white">{{ $module['label'] }}</h4>
                        <div class="flex items-center space-x-2">
                            <label class="flex items-center">
                                <input type="checkbox" 
                                       class="module-select-all rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                       data-module="{{ $moduleKey }}">
                                <span class="ml-2 text-sm text-gray-700 dark:text-gray-300">Select All</span>
                            </label>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-3">
                        <!-- Menu Permission -->
                        <label class="flex items-center p-3 bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-600 hover:bg-gray-50 dark:hover:bg-gray-750 transition-colors cursor-pointer">
                            <input type="checkbox" 
                                   name="permissions[]"
                                   value="menu-{{ $moduleKey }}"
                                   class="permission-checkbox rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                   data-module="{{ $moduleKey }}"
                                   {{ $role->permissions->contains('name', 'menu-' . $moduleKey) ? 'checked' : '' }}>
                            <div class="ml-3">
                                <div class="text-sm font-medium text-gray-900 dark:text-white">Menu Access</div>
                                <div class="text-xs text-gray-500 dark:text-gray-400">menu-{{ $moduleKey }}</div>
                            </div>
                        </label>

                        <!-- Button Permissions -->
                        @foreach($module['buttons'] as $buttonKey => $buttonLabel)
                        <label class="flex items-center p-3 bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-600 hover:bg-gray-50 dark:hover:bg-gray-750 transition-colors cursor-pointer">
                            <input type="checkbox" 
                                   name="permissions[]"
                                   value="{{ $moduleKey }}-{{ $buttonKey }}"
                                   class="permission-checkbox rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                   data-module="{{ $moduleKey }}"
                                   {{ $role->permissions->contains('name', $moduleKey . '-' . $buttonKey) ? 'checked' : '' }}>
                            <div class="ml-3">
                                <div class="text-sm font-medium text-gray-900 dark:text-white">{{ $buttonLabel }}</div>
                                <div class="text-xs text-gray-500 dark:text-gray-400">{{ $moduleKey }}-{{ $buttonKey }}</div>
                            </div>
                        </label>
                        @endforeach
                    </div>
                </div>
                @endforeach
            </div>

            <!-- Form Actions -->
            <div class="flex items-center justify-end space-x-3 pt-6 border-t border-gray-200 dark:border-gray-600 mt-6">
                <a href="{{ route('partner.access-control.index') }}" 
                   class="px-6 py-3 text-sm font-medium text-gray-700 dark:text-gray-300 bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 rounded-lg transition-colors">
                    Cancel
                </a>
                <button type="submit" 
                        class="px-8 py-3 text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 rounded-lg transition-colors">
                    Update Permissions
                </button>
            </div>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Handle "Select All" for each module
    document.querySelectorAll('.module-select-all').forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            const module = this.dataset.module;
            const isChecked = this.checked;
            
            document.querySelectorAll(`.permission-checkbox[data-module="${module}"]`).forEach(permCheckbox => {
                permCheckbox.checked = isChecked;
            });
        });
    });
    
    // Update "Select All" state when individual checkboxes change
    document.querySelectorAll('.permission-checkbox').forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            const module = this.dataset.module;
            const allCheckboxes = document.querySelectorAll(`.permission-checkbox[data-module="${module}"]`);
            const checkedCheckboxes = document.querySelectorAll(`.permission-checkbox[data-module="${module}"]:checked`);
            const selectAllCheckbox = document.querySelector(`.module-select-all[data-module="${module}"]`);
            
            if (selectAllCheckbox) {
                selectAllCheckbox.checked = allCheckboxes.length === checkedCheckboxes.length;
            }
        });
    });
});
</script>
@endsection
