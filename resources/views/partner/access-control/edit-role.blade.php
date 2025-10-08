@extends('layouts.partner-layout')

@section('title', 'Access Control - ' . ($role->display_name ?? ucwords(str_replace('_',' ',$role->name))))

@section('content')
<div class="space-y-6">
    <div class="bg-white rounded-xl border border-gray-200 p-5 shadow-sm">
        <div class="flex items-center justify-between mb-4">
            <div>
                <h1 class="text-xl font-semibold text-gray-900">Access Control (Actions)</h1>
                <p class="text-sm text-gray-500">Grant or revoke button-level permissions for this role. Navigation (menu) permissions are managed separately.</p>
            </div>
            <a href="{{ route('partner.settings.index') }}" class="inline-flex items-center px-3 py-2 rounded-lg bg-gray-100 text-gray-700 hover:bg-gray-200 text-sm">Back to Settings</a>
        </div>

        <form method="POST" action="{{ route('partner.access-control.update-role-permissions', $role) }}" id="actionPermForm">
            @csrf
            @method('PUT')

            <div class="space-y-5">
                @foreach($modules as $module)
                    <div class="border border-gray-200 rounded-lg p-4">
                        <div class="flex items-center justify-between mb-3">
                            <h2 class="text-sm font-semibold text-gray-800">{{ $module['label'] }}</h2>
                            <div class="text-xs text-gray-500">Module: <code>{{ $module['key'] }}</code></div>
                        </div>
                        @php $buttons = $module['buttons'] ?? []; @endphp
                        @if(count($buttons) > 0)
                            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-2">
                                @foreach($buttons as $buttonKey => $label)
                                    @php $permName = $module['key'] . '-' . $buttonKey; @endphp
                                    <label class="inline-flex items-center space-x-2 bg-gray-50 border border-gray-200 px-3 py-2 rounded-lg text-sm">
                                        <input type="checkbox" name="permissions[]" value="{{ $permName }}" class="rounded" {{ ($checked[$permName] ?? false) ? 'checked' : '' }}>
                                        <span>{{ $label }}</span>
                                        <span class="ml-2 text-xs text-gray-400">(<code>{{ $permName }}</code>)</span>
                                    </label>
                                @endforeach
                            </div>
                        @else
                            <div class="text-xs text-gray-500">No action permissions defined for this module.</div>
                        @endif
                    </div>
                @endforeach
            </div>

            <div class="mt-4 flex items-center justify-end">
                <button type="submit" class="inline-flex items-center px-4 py-2 rounded-lg bg-primaryGreen text-white text-sm hover:opacity-90">Save</button>
            </div>
        </form>
    </div>
</div>
@endsection
