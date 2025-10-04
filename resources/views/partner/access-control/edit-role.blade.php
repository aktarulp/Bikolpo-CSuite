@extends('layouts.partner-layout')

@section('title', 'Edit Role Permissions')

@push('styles')
<style>
    .permission-card {
        transition: all 0.2s ease-in-out;
    }
    .permission-card:hover {
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    }
    .permission-card.selected {
        border-color: #3b82f6;
        background-color: #eff6ff;
    }
    .dark .permission-card.selected {
        background-color: #1e3a8a;
    }
</style>
@endpush

@section('content')
<div class="min-h-screen bg-gray-50 dark:bg-gray-900">
    <!-- Mobile-First Header -->
    <div class="bg-white dark:bg-gray-800 shadow-sm border-b border-gray-200 dark:border-gray-700">
        <div class="px-4 py-6 sm:px-6 lg:px-8">
            <!-- Mobile Header -->
            <div class="flex items-center justify-between mb-4 sm:hidden">
                <div class="flex items-center space-x-3">
                    <div class="p-2 bg-blue-50 dark:bg-blue-900/30 rounded-lg">
                        <svg class="w-6 h-6 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                        </svg>
                    </div>
                    <div>
                        <h1 class="text-xl font-bold text-gray-900 dark:text-white">Edit Role</h1>
                        <p class="text-sm text-gray-600 dark:text-gray-400">{{ $role->name }}</p>
                    </div>
                </div>
                <a href="{{ route('partner.settings.index') }}" 
                   class="p-2 bg-gray-100 hover:bg-gray-200 dark:bg-gray-700 dark:hover:bg-gray-600 text-gray-800 dark:text-gray-200 rounded-lg shadow-sm transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                </a>
            </div>

            <!-- Desktop Header -->
            <div class="hidden sm:flex items-center justify-between">
                <div class="flex items-center space-x-4">
                    <div class="p-3 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-xl shadow-lg">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                        </svg>
                    </div>
                    <div>
                        <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Edit Role Permissions</h1>
                        <p class="text-gray-600 dark:text-gray-400 mt-1">Manage permissions for {{ $role->name }}</p>
                    </div>
                </div>
                <a href="{{ route('partner.settings.index') }}" 
                   class="inline-flex items-center space-x-2 bg-gray-100 hover:bg-gray-200 dark:bg-gray-700 dark:hover:bg-gray-600 text-gray-800 dark:text-gray-200 font-medium px-6 py-3 rounded-lg shadow-sm hover:shadow-md transition-all duration-200">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    <span>Back to Settings</span>
                </a>
            </div>

            <!-- Mobile Description -->
            <p class="text-sm text-gray-600 dark:text-gray-400 mt-2 sm:hidden">Manage permissions for {{ $role->name }}</p>
        </div>
    </div>

    <!-- Main Content -->
    <div class="px-4 py-6 sm:px-6 lg:px-8">
        <!-- Role Info Card -->
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-4 sm:p-6 mb-6">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-3">
                    <div class="p-2 bg-blue-50 dark:bg-blue-900/30 rounded-lg">
                        <svg class="w-5 h-5 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                    </div>
                    <div>
                        <h2 class="text-lg font-semibold text-gray-900 dark:text-white">Role: {{ $role->name }}</h2>
                        <p class="text-sm text-gray-600 dark:text-gray-400">Configure permissions for this role</p>
                    </div>
                </div>
                <button onclick="refreshData()" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-colors">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                    </svg>
                    Refresh Data
                </button>
            </div>
        </div>

        <!-- Permissions Form -->
        <form action="{{ route('partner.access-control.update-role-permissions', $role) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')
            
            <div class="space-y-6">
                <!-- Permission Groups -->
                @foreach($permissionConfig as $moduleKey => $module)
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
                    <!-- Module Header -->
                    <div class="bg-gray-50 dark:bg-gray-700 px-4 py-4 sm:px-6 border-b border-gray-200 dark:border-gray-600">
                        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between space-y-3 sm:space-y-0">
                            <div class="flex items-center space-x-3">
                                <div class="p-2 bg-blue-50 dark:bg-blue-900/30 rounded-lg">
                                    <svg class="w-5 h-5 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                                    </svg>
                                </div>
                                <h4 class="text-lg font-semibold text-gray-900 dark:text-white">{{ $module['label'] }}</h4>
                            </div>
                            <label class="flex items-center space-x-2">
                                <input type="checkbox" 
                                       class="module-select-all rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                                       data-module="{{ $moduleKey }}">
                                <span class="text-sm text-gray-700 dark:text-gray-300 font-medium">Select All</span>
                            </label>
                        </div>
                    </div>

                    <!-- Permissions Grid -->
                    <div class="p-4 sm:p-6">
                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3">
                            <!-- Menu Permission -->
                            <label class="permission-card flex items-start p-4 bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-600 hover:border-blue-300 dark:hover:border-blue-500 transition-all duration-200 cursor-pointer">
                                <input type="checkbox" 
                                       name="permissions[]"
                                       value="menu-{{ $moduleKey }}"
                                       class="permission-checkbox mt-1 rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                                       data-module="{{ $moduleKey }}"
                                       {{ $role->permissions->contains('name', 'menu-' . $moduleKey) ? 'checked' : '' }}>
                                <div class="ml-3 min-w-0 flex-1">
                                    <div class="text-sm font-medium text-gray-900 dark:text-white">Menu Access</div>
                                    <div class="text-xs text-gray-500 dark:text-gray-400 truncate">menu-{{ $moduleKey }}</div>
                                </div>
                            </label>

                            <!-- Button Permissions -->
                            @foreach($module['buttons'] as $buttonKey => $buttonLabel)
                            <label class="permission-card flex items-start p-4 bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-600 hover:border-blue-300 dark:hover:border-blue-500 transition-all duration-200 cursor-pointer">
                                <input type="checkbox" 
                                       name="permissions[]"
                                       value="{{ $moduleKey }}-{{ $buttonKey }}"
                                       class="permission-checkbox mt-1 rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                                       data-module="{{ $moduleKey }}"
                                       {{ $role->permissions->contains('name', $moduleKey . '-' . $buttonKey) ? 'checked' : '' }}>
                                <div class="ml-3 min-w-0 flex-1">
                                    <div class="text-sm font-medium text-gray-900 dark:text-white">{{ $buttonLabel }}</div>
                                    <div class="text-xs text-gray-500 dark:text-gray-400 truncate">{{ $moduleKey }}-{{ $buttonKey }}</div>
                                </div>
                            </label>
                            @endforeach
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            <!-- Form Actions -->
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-4 sm:p-6">
                <div class="flex flex-col sm:flex-row items-stretch sm:items-center justify-end space-y-3 sm:space-y-0 sm:space-x-3">
                    <a href="{{ route('partner.settings.index') }}" 
                       class="w-full sm:w-auto px-6 py-3 text-sm font-medium text-gray-700 dark:text-gray-300 bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 rounded-lg transition-colors text-center">
                        Cancel
                    </a>
                    <button type="submit" 
                            class="w-full sm:w-auto px-8 py-3 text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 rounded-lg transition-colors shadow-sm hover:shadow-md">
                        Update Permissions
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
// Refresh Data Function
function refreshData() {
    // Show loading state
    const refreshButtons = document.querySelectorAll('button[onclick="refreshData()"]');
    refreshButtons.forEach(button => {
        button.disabled = true;
        button.innerHTML = `
            <svg class="animate-spin w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
            Refreshing...
        `;
    });
    
    // Simulate refresh (you can replace this with actual refresh logic)
    setTimeout(() => {
        // Reload the current page to refresh the data
        location.reload();
    }, 1000);
}

document.addEventListener('DOMContentLoaded', function() {
    // Visual state functions
    function updatePermissionCardState(checkbox) {
        const card = checkbox.closest('.permission-card');
        if (card) {
            if (checkbox.checked) {
                card.classList.add('selected');
            } else {
                card.classList.remove('selected');
            }
        }
    }
    
    function updateSelectAllVisualState(checkbox, isChecked) {
        const module = checkbox.dataset.module;
        const moduleCard = checkbox.closest('.bg-white').parentElement;
        if (moduleCard) {
            if (isChecked) {
                moduleCard.classList.add('ring-2', 'ring-blue-200', 'bg-blue-50');
                moduleCard.classList.remove('bg-white');
            } else {
                moduleCard.classList.remove('ring-2', 'ring-blue-200', 'bg-blue-50');
                moduleCard.classList.add('bg-white');
            }
        }
    }
    
    // Handle "Select All" for each module
    document.querySelectorAll('.module-select-all').forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            const module = this.dataset.module;
            const isChecked = this.checked;
            
            document.querySelectorAll(`.permission-checkbox[data-module="${module}"]`).forEach(permCheckbox => {
                permCheckbox.checked = isChecked;
                updatePermissionCardState(permCheckbox);
            });
            
            updateSelectAllVisualState(this, isChecked);
        });
    });
    
    // Update "Select All" state when individual checkboxes change
    document.querySelectorAll('.permission-checkbox').forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            const module = this.dataset.module;
            const allCheckboxes = document.querySelectorAll(`.permission-checkbox[data-module="${module}"]`);
            const checkedCheckboxes = document.querySelectorAll(`.permission-checkbox[data-module="${module}"]:checked`);
            const selectAllCheckbox = document.querySelector(`.module-select-all[data-module="${module}"]`);
            
            // Update select all checkbox state
            if (selectAllCheckbox) {
                const isFullySelected = allCheckboxes.length === checkedCheckboxes.length;
                selectAllCheckbox.checked = isFullySelected;
                updateSelectAllVisualState(selectAllCheckbox, isFullySelected);
            }
            
            // Update permission card visual state
            updatePermissionCardState(this);
        });
        
        // Initialize state for permission cards
        updatePermissionCardState(checkbox);
    });
    
    // Form submission with loading state
    const form = document.querySelector('form');
    if (form) {
        form.addEventListener('submit', function() {
            const submitBtn = form.querySelector('button[type="submit"]');
            if (submitBtn) {
                submitBtn.disabled = true;
                submitBtn.innerHTML = `
                    <svg class="animate-spin -ml-1 mr-2 h-4 w-4 inline" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 714 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    Updating...
                `;
            }
        });
    }
});
</script>
@endsection
