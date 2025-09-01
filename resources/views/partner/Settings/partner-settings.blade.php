@extends('layouts.partner-layout')

@section('title', 'Settings')

@section('content')
@if(!$partner)
    <div class="min-h-screen bg-gray-50 dark:bg-gray-900 flex items-center justify-center">
        <div class="max-w-md w-full bg-white dark:bg-gray-800 shadow-lg rounded-lg p-6 text-center">
            <div class="text-red-500 mb-4">
                <svg class="w-16 h-16 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                </svg>
            </div>
            <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-2">Profile Not Found</h2>
            <p class="text-gray-600 dark:text-gray-400 mb-4">Your partner profile could not be found. Please complete your profile setup first.</p>
            <a href="{{ route('partner.dashboard') }}" class="inline-flex items-center px-4 py-2 bg-primaryGreen text-white rounded-lg hover:bg-primaryGreen/90 transition-colors duration-200">
                Go to Dashboard
            </a>
        </div>
    </div>
@else
<div class="min-h-screen bg-gray-50 dark:bg-gray-900">
    <!-- Page Header -->
    <div class="bg-white dark:bg-gray-800 shadow-sm border-b border-gray-200 dark:border-gray-700">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Settings</h1>
                    <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">Manage your institution's configuration and preferences</p>
                </div>
                <div class="flex items-center space-x-3">
                    <button type="button" onclick="saveAllSettings()" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-lg shadow-sm text-white bg-primaryGreen hover:bg-primaryGreen/90 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primaryGreen transition-colors duration-200">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        Save All Changes
                    </button>
                    <button type="button" onclick="exportSettings()" class="inline-flex items-center px-4 py-2 border border-gray-300 dark:border-gray-600 text-sm font-medium rounded-lg shadow-sm text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primaryGreen transition-colors duration-200">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        Export
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Tab Navigation -->
        <div class="border-b border-gray-200 dark:border-gray-700 mb-8">
            <nav class="-mb-px flex space-x-8 overflow-x-auto">
                <button onclick="switchTab('general')" class="tab-button active whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm transition-colors duration-200" data-tab="general">
                    <svg class="w-5 h-5 mr-2 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    </svg>
                    General Settings
                </button>
                <button onclick="switchTab('users')" class="tab-button whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm transition-colors duration-200" data-tab="users">
                    <svg class="w-5 h-5 mr-2 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                    </svg>
                    User Management
                </button>
                <button onclick="switchTab('permissions')" class="tab-button whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm transition-colors duration-200" data-tab="permissions">
                    <svg class="w-5 h-5 mr-2 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                    </svg>
                    Permissions
                </button>
                <button onclick="switchTab('security')" class="tab-button whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm transition-colors duration-200" data-tab="security">
                    <svg class="w-5 h-5 mr-2 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                    </svg>
                    Security
                </button>
                <button onclick="switchTab('notifications')" class="tab-button whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm transition-colors duration-200" data-tab="notifications">
                    <svg class="w-5 h-5 mr-2 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-5 5v-5z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    Notifications
                </button>
                <button onclick="switchTab('integrations')" class="tab-button whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm transition-colors duration-200" data-tab="integrations">
                    <svg class="w-5 h-5 mr-2 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                    </svg>
                    Integrations
                </button>
            </nav>
        </div>

        <!-- Tab Content -->
        <div class="tab-content">
            <!-- General Settings Tab -->
            <div id="general" class="tab-pane active">
                @include('partner.Settings.partials.general-settings')
            </div>

            <!-- User Management Tab -->
            <div id="users" class="tab-pane hidden">
                @include('partner.Settings.partials.user-management')
            </div>

            <!-- Permissions Tab -->
            <div id="permissions" class="tab-pane hidden">
                @include('partner.Settings.partials.permissions')
            </div>

            <!-- Security Tab -->
            <div id="security" class="tab-pane hidden">
                @include('partner.Settings.partials.security')
            </div>

            <!-- Notifications Tab -->
            <div id="notifications" class="tab-pane hidden">
                @include('partner.Settings.partials.notifications')
            </div>

            <!-- Integrations Tab -->
            <div id="integrations" class="tab-pane hidden">
                @include('partner.Settings.partials.integrations')
            </div>
        </div>
    </div>
</div>

<!-- Toast Notification -->
<div id="toast" class="fixed top-4 right-4 z-50 max-w-sm w-full bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg shadow-lg p-4 transition-all duration-300 transform translate-x-full">
    <div class="flex items-start">
        <div class="flex-shrink-0">
            <svg id="toast-icon" class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
        </div>
        <div class="ml-3">
            <p id="toast-message" class="text-sm font-medium text-gray-900 dark:text-white"></p>
        </div>
        <div class="ml-auto pl-3">
            <button type="button" class="inline-flex text-gray-400 hover:text-gray-600" onclick="hideToast()">
                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>
    </div>
</div>
@endif
@endsection

@push('scripts')
<script>
// Tab switching functionality
function switchTab(tabName) {
    // Hide all tab panes
    document.querySelectorAll('.tab-pane').forEach(pane => {
        pane.classList.add('hidden');
    });
    
    // Remove active class from all tab buttons
    document.querySelectorAll('.tab-button').forEach(button => {
        button.classList.remove('active', 'border-primaryGreen', 'text-primaryGreen');
        button.classList.add('border-transparent', 'text-gray-500', 'dark:text-gray-400');
    });
    
    // Show selected tab pane
    document.getElementById(tabName).classList.remove('hidden');
    
    // Add active class to selected tab button
    const activeButton = document.querySelector(`[data-tab="${tabName}"]`);
    activeButton.classList.add('active', 'border-primaryGreen', 'text-primaryGreen');
    activeButton.classList.remove('border-transparent', 'text-gray-500', 'dark:text-gray-400');
}

// Save all settings
function saveAllSettings() {
    showToast('Settings saved successfully!', 'success');
    // Here you would typically collect all form data and send to backend
}

// Export settings
function exportSettings() {
    showToast('Settings exported successfully!', 'success');
    // Here you would typically generate and download a settings file
}

// Toast notification functions
function showToast(message, type = 'success') {
    const toast = document.getElementById('toast');
    const toastMessage = document.getElementById('toast-message');
    const toastIcon = document.getElementById('toast-icon');
    
    toastMessage.textContent = message;
    
    // Set icon and colors based on type
    if (type === 'success') {
        toastIcon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>';
        toast.classList.remove('bg-red-50', 'border-red-200', 'dark:bg-red-900/20', 'dark:border-red-800');
        toast.classList.add('bg-green-50', 'border-green-200', 'dark:bg-green-900/20', 'dark:border-green-800');
    } else if (type === 'error') {
        toastIcon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path>';
        toast.classList.remove('bg-green-50', 'border-green-200', 'dark:bg-green-900/20', 'dark:border-green-800');
        toast.classList.add('bg-red-50', 'border-red-200', 'dark:bg-red-900/20', 'dark:border-red-800');
    }
    
    // Show toast
    toast.classList.remove('translate-x-full');
    
    // Auto-hide after 5 seconds
    setTimeout(() => {
        hideToast();
    }, 5000);
}

function hideToast() {
    const toast = document.getElementById('toast');
    toast.classList.add('translate-x-full');
}

// Initialize first tab as active
document.addEventListener('DOMContentLoaded', function() {
    switchTab('general');
});
</script>
@endpush

@push('styles')
<style>
.tab-button.active {
    @apply border-primaryGreen text-primaryGreen;
}

.tab-button:not(.active) {
    @apply border-transparent text-gray-500 dark:text-gray-400;
}

.tab-button:hover:not(.active) {
    @apply text-gray-700 dark:text-gray-300 border-gray-300 dark:border-gray-600;
}

.tab-pane {
    animation: fadeIn 0.3s ease-in-out;
}

@keyframes fadeIn {
    from {
        opacity: 0;
        transform: translateY(10px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

/* Custom scrollbar for tab navigation */
.overflow-x-auto::-webkit-scrollbar {
    height: 4px;
}

.overflow-x-auto::-webkit-scrollbar-track {
    background: #f1f5f9;
}

.overflow-x-auto::-webkit-scrollbar-thumb {
    background: #cbd5e1;
    border-radius: 2px;
}

.overflow-x-auto::-webkit-scrollbar-thumb:hover {
    background: #94a3b8;
}

/* Dark mode scrollbar */
.dark .overflow-x-auto::-webkit-scrollbar-track {
    background: #374151;
}

.dark .overflow-x-auto::-webkit-scrollbar-thumb {
    background: #6b7280;
}

.dark .overflow-x-auto::-webkit-scrollbar-thumb:hover {
    background: #9ca3af;
}
</style>
@endpush
