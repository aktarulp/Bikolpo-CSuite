@extends('layouts.partner-layout')

@section('title', 'Role Permissions - ' . ($role->display_name ?? ucwords(str_replace('_', ' ', $role->name))))

@section('content')
<div class="space-y-6">
    <div class="bg-white rounded-xl border border-gray-200 p-5 shadow-sm">
        <div class="flex items-center justify-between mb-4">
            <div>
                <div class="flex items-center gap-3 mb-2">
                    <a href="{{ route('partner.nav-permissions.index') }}" class="inline-flex items-center text-gray-500 hover:text-gray-700 transition-colors">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                        </svg>
                        <span class="text-sm">All Roles</span>
                    </a>
                    <span class="text-gray-300">/</span>
                    <span class="text-sm text-gray-600">{{ $role->display_name ?? ucwords(str_replace('_', ' ', $role->name)) }}</span>
                </div>
                <h1 class="text-xl font-semibold text-gray-900">Menu Permissions</h1>
                <p class="text-sm text-gray-500">Manage access to the 11 sidebar menus for this role. Action-level permissions are managed in Access Control.</p>
            </div>
            <a href="{{ route('partner.settings.index') }}" class="inline-flex items-center px-3 py-2 rounded-lg bg-gray-100 text-gray-700 hover:bg-gray-200 text-sm">Back to Settings</a>
        </div>

        @if(session('success'))
            <div class="mb-4 rounded-lg border border-green-200 bg-green-50 text-green-700 px-4 py-2 text-sm">{{ session('success') }}</div>
        @endif

        @if(session('error'))
            <div class="mb-4 rounded-lg border border-red-200 bg-red-50 text-red-700 px-4 py-2 text-sm">{{ session('error') }}</div>
        @endif

        <!-- Role Information Card -->
        <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-6">
            <div class="flex items-center gap-3">
                <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                    </svg>
                </div>
                <div>
                    <h3 class="text-lg font-semibold text-blue-900">{{ $role->display_name ?? ucwords(str_replace('_', ' ', $role->name)) }}</h3>
                    <div class="flex items-center gap-4 text-sm text-blue-700">
                        <span>System: <span class="font-mono">{{ $role->name }}</span></span>
                        <span>Level: {{ $role->level ?? '—' }}</span>
                        <span>Users: {{ $role->users->count() }}</span>
                        <span>Total Permissions: {{ $role->permissions->count() }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Permissions Form -->
        <form method="POST" action="{{ route('partner.nav-permissions.update', ['enhancedRole' => $role->id]) }}" class="space-y-4">
            @csrf
            @method('PUT')
            
            <div class="bg-gray-50 rounded-lg p-4 border border-gray-200">
                <h4 class="text-sm font-medium text-gray-900 mb-4">Sidebar Menu Permissions</h4>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-3">
                    @foreach($menuKeys as $menu)
                        <label class="group relative flex items-center space-x-3 bg-white border border-gray-200 px-4 py-3 rounded-lg hover:border-blue-300 hover:shadow-sm transition-all cursor-pointer {{ $permissions[$menu] ? 'ring-2 ring-blue-500 ring-opacity-30 bg-blue-50' : '' }}">
                            <input type="checkbox" 
                                   name="menus[{{ $menu }}]" 
                                   value="1" 
                                   class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50" 
                                   {{ $permissions[$menu] ? 'checked' : '' }}>
                            <div class="flex-1">
                                <span class="block text-sm font-medium text-gray-900 group-hover:text-blue-900">
                                    {{ \Illuminate\Support\Str::title(str_replace(['menu-','-'], ['', ' '], $menu)) }}
                                </span>
                                <span class="block text-xs text-gray-500 font-mono">{{ $menu }}</span>
                            </div>
                            @if($permissions[$menu])
                                <div class="absolute top-2 right-2">
                                    <div class="w-2 h-2 bg-blue-500 rounded-full"></div>
                                </div>
                            @endif
                        </label>
                    @endforeach
                </div>
            </div>

            <div class="flex items-center justify-between pt-4">
                <div class="text-xs text-gray-500">
                    <p>Note: Only the 11 sidebar menus are managed here. Button/action permissions are available under Access Control.</p>
                </div>
                <div class="flex items-center gap-3">
                    <a href="{{ route('partner.nav-permissions.index') }}" class="inline-flex items-center px-4 py-2 rounded-lg bg-gray-100 text-gray-700 hover:bg-gray-200 text-sm transition-colors">
                        Cancel
                    </a>
                    <button type="submit" class="inline-flex items-center px-4 py-2 rounded-lg bg-blue-600 text-white text-sm hover:bg-blue-700 transition-colors">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        Save Permissions
                    </button>
                </div>
            </div>
        </form>
    </div>

    <!-- Quick Actions -->
    <div class="bg-white rounded-xl border border-gray-200 p-5 shadow-sm">
        <h3 class="text-lg font-semibold text-gray-900 mb-3">Quick Actions</h3>
        <div class="flex flex-wrap gap-3">
            <a href="{{ route('partner.access-control.edit-role', $role) }}" class="inline-flex items-center px-4 py-2 bg-green-600 text-white text-sm font-medium rounded-lg hover:bg-green-700 transition-colors">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                </svg>
                Edit Action Permissions
            </a>
            <a href="{{ route('partner.nav-permissions.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-600 text-white text-sm font-medium rounded-lg hover:bg-gray-700 transition-colors">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                </svg>
                View All Roles
            </a>
        </div>
    </div>
</div>

<style>
.group:hover .group-hover\:text-blue-900 {
    color: #1e3a8a;
}
</style>

@endsection