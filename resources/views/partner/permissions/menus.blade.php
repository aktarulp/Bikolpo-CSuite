@extends('layouts.partner-layout')

@section('title', 'Permissions (Nav)')

@section('content')
<div class="space-y-6">
    <div class="bg-white rounded-xl border border-gray-200 p-5 shadow-sm">
        <div class="flex items-center justify-between mb-4">
            <div>
                <h1 class="text-xl font-semibold text-gray-900">Permissions (Nav)</h1>
                <p class="text-sm text-gray-500">Grant or revoke access to the 11 sidebar menus per role. Action-level permissions are managed in Access Control.</p>
            </div>
            <a href="{{ route('partner.settings.index') }}" class="inline-flex items-center px-3 py-2 rounded-lg bg-gray-100 text-gray-700 hover:bg-gray-200 text-sm">Back to Settings</a>
        </div>

        @if(session('success'))
            <div class="mb-4 rounded-lg border border-green-200 bg-green-50 text-green-700 px-4 py-2 text-sm">{{ session('success') }}</div>
        @endif

        <div class="overflow-x-auto">
            <table class="min-w-full border-separate" style="border-spacing:0 8px;">
                <thead>
                    <tr>
                        <th class="text-left text-xs font-semibold text-gray-500 px-3 py-2">Role</th>
                        @foreach($menuKeys as $menu)
                            <th class="text-left text-xs font-semibold text-gray-500 px-3 py-2">{{ \Illuminate\Support\Str::title(str_replace(['menu-','-'], ['', ' '], $menu)) }}</th>
                        @endforeach
                        <th class="px-3 py-2"></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($roles as $role)
                        <tr class="bg-white border border-gray-200">
                            <td class="px-3 py-2 text-sm font-medium text-gray-900">
                                {{ $role->display_name ?? ucwords(str_replace('_',' ',$role->name)) }}
                                <div class="text-xs text-gray-500">System: {{ $role->name }} | Level: {{ $role->level ?? '—' }}</div>
                            </td>
                            <td colspan="{{ count($menuKeys)+1 }}" class="px-3 py-2">
<form method="POST" action="{{ route('partner.nav-permissions.update', ['enhancedRole' => $role->id]) }}" class="flex flex-wrap gap-3 items-center">
                                    @csrf
                                    @method('PUT')
                                    @foreach($menuKeys as $menu)
                                        <label class="inline-flex items-center space-x-2 bg-gray-50 border border-gray-200 px-3 py-2 rounded-lg text-sm">
                                            <input type="checkbox" name="menus[{{ $menu }}]" value="1" class="rounded" {{ ($permissionsByRole[$role->id][$menu] ?? false) ? 'checked' : '' }}>
                                            <span>{{ \Illuminate\Support\Str::title(str_replace(['menu-','-'], ['', ' '], $menu)) }}</span>
                                        </label>
                                    @endforeach
                                    <button type="submit" class="ml-auto inline-flex items-center px-3 py-2 rounded-lg bg-primaryGreen text-white text-sm hover:opacity-90">Save</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="mt-4 text-xs text-gray-500">Note: Only the 11 sidebar menus are managed here. Button/action permissions are available under Access Control.</div>
    </div>
</div>
@endsection