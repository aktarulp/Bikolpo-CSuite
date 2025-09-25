@extends('layouts.partner-layout')

@section('content')
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
    <div class="bg-white dark:bg-gray-900 rounded-lg shadow overflow-hidden">
        <div class="md:flex">
            <!-- Sidebar for md+ screens, top tabs for mobile -->
            <aside class="w-full md:w-64 border-b md:border-b-0 md:border-r border-gray-100 dark:border-gray-800 bg-gray-50 dark:bg-gray-800">
                <!-- Mobile Tabs -->
                <nav class="md:hidden flex items-center justify-between p-3">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">Settings</h3>
                    <button id="settingsMenuToggle" class="text-gray-600 dark:text-gray-300 focus:outline-none" aria-label="Toggle settings menu">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
                    </button>
                </nav>

                <div id="settingsNav" class="px-2 py-3 md:py-6">
                    <ul class="space-y-1">
                        <li>
                            <button data-target="#user-management" class="settings-tab w-full text-left flex items-center gap-3 px-3 py-2 rounded-md text-sm font-medium text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700 focus:outline-none active" aria-controls="user-management" aria-selected="true">
                                <i class="fas fa-users w-4"></i>
                                <span>User Management</span>
                </button>
                        </li>
                        <li>
                            <button data-target="#partner-profile-management" class="settings-tab w-full text-left flex items-center gap-3 px-3 py-2 rounded-md text-sm font-medium text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700 focus:outline-none" aria-controls="partner-profile-management" aria-selected="false">
                                <i class="fas fa-user-tie w-4"></i>
                                <span>Partner Profile</span>
                </button>
                        </li>
                        <li>
                            <button data-target="#role-permission-grid" class="settings-tab w-full text-left flex items-center gap-3 px-3 py-2 rounded-md text-sm font-medium text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700 focus:outline-none" aria-controls="role-permission-grid" aria-selected="false">
                                <i class="fas fa-user-lock w-4"></i>
                                <span>Roles & Permissions</span>
                </button>
                        </li>
                    </ul>
        </div>
            </aside>

            <main class="flex-1 p-4 md:p-6">
                <div id="settingsContent">
                    <section id="user-management" class="settings-panel">
                @include('partner.Settings.partials.user-management')
                    </section>

                    <section id="partner-profile-management" class="hidden settings-panel">
                        @include('partner.Settings.partials.partner-profile-management')
                    </section>

                    <section id="role-permission-grid" class="hidden settings-panel">
                        @include('partner.Settings.partials.role-permission-grid')
                    </section>
            </div>
            </main>
        </div>
    </div>
</div>

@push('styles')
    {{-- No custom styles are pushed here; Tailwind CSS handles styling directly in HTML --}}
@endpush

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
    const tabs = document.querySelectorAll('.settings-tab');
    const panels = document.querySelectorAll('.settings-panel');

    function showPanel(targetId) {
        panels.forEach(p => p.classList.add('hidden'));
        const target = document.querySelector(targetId);
        if (target) target.classList.remove('hidden');
    }

    tabs.forEach(tab => {
        tab.addEventListener('click', function() {
            // Deselect all
            tabs.forEach(t => t.classList.remove('bg-primaryGreen/10', 'text-primaryGreen', 'font-semibold', 'border-l-4', 'border-primaryGreen'));
            tabs.forEach(t => t.classList.add('text-gray-700', 'dark:text-gray-200', 'hover:bg-gray-100', 'dark:hover:bg-gray-700'));
            tabs.forEach(t => t.querySelector('i')?.classList.remove('text-primaryGreen'));
            tabs.forEach(t => t.setAttribute('aria-selected', 'false'));

            // Select current
            this.classList.add('bg-primaryGreen/10', 'text-primaryGreen', 'font-semibold', 'border-l-4', 'border-primaryGreen');
            this.classList.remove('text-gray-700', 'dark:text-gray-200', 'hover:bg-gray-100', 'dark:hover:bg-gray-700');
            this.querySelector('i')?.classList.add('text-primaryGreen');
            this.setAttribute('aria-selected', 'true');

            const target = this.getAttribute('data-target');
            showPanel(target);
        });
    });

    // On first load ensure first tab is active
    if (tabs.length) {
        tabs[0].classList.add('bg-primaryGreen/10', 'text-primaryGreen', 'font-semibold', 'border-l-4', 'border-primaryGreen');
        tabs[0].classList.remove('text-gray-700', 'dark:text-gray-200', 'hover:bg-gray-100', 'dark:hover:bg-gray-700');
        tabs[0].querySelector('i')?.classList.add('text-primaryGreen');
        tabs[0].setAttribute('aria-selected', 'true');
    }

    // Mobile toggle for nav
    const toggle = document.getElementById('settingsMenuToggle');
    const nav = document.getElementById('settingsNav');
    if (toggle && nav) {
        toggle.addEventListener('click', () => {
            nav.classList.toggle('hidden');
        });
    }
});
</script>
@endpush

@endsection
