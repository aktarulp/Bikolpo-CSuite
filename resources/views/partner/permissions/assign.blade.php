@extends('layouts.partner-layout')

@section('title', 'Assign Permissions - ' . ($role->display_name ?? ucwords(str_replace('_', ' ', $role->name))))

@section('content')
<div class="space-y-4 sm:space-y-6">
    <!-- Header with Glassmorphism Effect -->
    <div class="bg-white/80 dark:bg-gray-800/80 backdrop-blur-lg rounded-2xl shadow-sm border border-gray-100/50 dark:border-gray-700/50 p-5 sm:p-6">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div class="space-y-1">
                <h1 class="text-2xl sm:text-3xl font-bold bg-gradient-to-r from-gray-800 to-gray-600 dark:from-white dark:to-gray-300 bg-clip-text text-transparent">
                    Assign Permissions
                </h1>
                <p class="text-sm text-gray-500 dark:text-gray-400">Manage CRUD access for each module in the system</p>
            </div>
            <div class="flex flex-wrap gap-2">
                <a href="{{ route('partner.settings.index') }}" class="inline-flex items-center px-4 py-2.5 rounded-xl bg-white dark:bg-gray-700 text-gray-700 dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-gray-600 text-sm font-medium shadow-sm transition-colors duration-200 border border-gray-200 dark:border-gray-600">
                    <x-icon name="arrow-left" class="w-4 h-4 mr-2" />
                    Back to Settings
                </a>
            </div>
        </div>
        
        <!-- Role Info Badge -->
        <div class="mt-4 flex flex-wrap items-center gap-3">
            <div class="px-3 py-1.5 bg-blue-50 dark:bg-blue-900/30 text-blue-700 dark:text-blue-300 rounded-full text-sm font-medium border border-blue-100 dark:border-blue-800 flex items-center">
                <x-icon name="shield" class="w-4 h-4 mr-1.5" />
                {{ $role->display_name ?? ucwords(str_replace('_',' ', $role->name)) }}
            </div>
            <div class="px-3 py-1.5 bg-gray-50 dark:bg-gray-700 text-gray-600 dark:text-gray-300 rounded-full text-xs font-mono border border-gray-200 dark:border-gray-600">
                {{ $role->name }}
            </div>
        </div>
    </div>

    <!-- Form Container -->
    <form method="POST" action="{{ route('partner.access-control.role.assign.save', $role) }}" class="bg-white dark:bg-gray-800/80 backdrop-blur-lg rounded-2xl shadow-sm border border-gray-100/50 dark:border-gray-700/50 overflow-hidden">
        @csrf
        @method('PUT')

        <!-- Success Message -->
        @if(session('success'))
            <div class="mb-4 mx-5 mt-5 px-4 py-3 rounded-xl bg-green-50 dark:bg-green-900/30 border border-green-200 dark:border-green-800 text-green-700 dark:text-green-300 text-sm font-medium">
                <div class="flex items-center">
                    <x-icon name="check-circle" class="w-5 h-5 mr-2 flex-shrink-0" />
                    {{ session('success') }}
                </div>
            </div>
        @endif

        <!-- Mobile View - Card Layout -->
        <div class="sm:hidden space-y-3 p-4">
            @foreach($modules as $m)
                @php $flags = $flagsByKey[$m['key']] ?? ['create'=>false,'read'=>false,'update'=>false,'delete'=>false]; @endphp
                <div class="bg-white/50 dark:bg-gray-700/50 rounded-xl border border-gray-100 dark:border-gray-700 p-4 shadow-sm">
                    <div class="flex items-center justify-between">
                        <div>
                            <h3 class="font-semibold text-gray-900 dark:text-white">{{ $m['label'] }}</h3>
                            <div class="text-xs text-gray-500 dark:text-gray-400 font-mono mt-0.5">menu-{{ $m['key'] }}</div>
                        </div>
                    </div>
                    
                    <div class="mt-3 grid grid-cols-2 gap-3">
                        <!-- Create Toggle -->
                        <label class="flex items-center justify-between p-2.5 rounded-lg border border-emerald-100 dark:border-emerald-900/50 bg-emerald-50/50 dark:bg-emerald-900/10">
                            <span class="text-sm font-medium text-emerald-700 dark:text-emerald-300">Create</span>
                            <span class="inline-flex items-center">
                                <input type="checkbox" name="modules[{{ $m['key'] }}][create]" value="1" class="sr-only toggle-input" {{ $flags['create'] ? 'checked' : '' }}>
                                <span class="toggle-track emerald">
                                    <span class="toggle-thumb"></span>
                                </span>
                            </span>
                        </label>

                        <!-- Read Toggle -->
                        <label class="flex items-center justify-between p-2.5 rounded-lg border border-blue-100 dark:border-blue-900/50 bg-blue-50/50 dark:bg-blue-900/10">
                            <span class="text-sm font-medium text-blue-700 dark:text-blue-300">Read</span>
                            <span class="inline-flex items-center">
                                <input type="checkbox" name="modules[{{ $m['key'] }}][read]" value="1" class="sr-only toggle-input" {{ $flags['read'] ? 'checked' : '' }}>
                                <span class="toggle-track blue">
                                    <span class="toggle-thumb"></span>
                                </span>
                            </span>
                        </label>

                        <!-- Update Toggle -->
                        <label class="flex items-center justify-between p-2.5 rounded-lg border border-amber-100 dark:border-amber-900/50 bg-amber-50/50 dark:bg-amber-900/10">
                            <span class="text-sm font-medium text-amber-700 dark:text-amber-300">Update</span>
                            <span class="inline-flex items-center">
                                <input type="checkbox" name="modules[{{ $m['key'] }}][update]" value="1" class="sr-only toggle-input" {{ $flags['update'] ? 'checked' : '' }}>
                                <span class="toggle-track amber">
                                    <span class="toggle-thumb"></span>
                                </span>
                            </span>
                        </label>

                        <!-- Delete Toggle -->
                        <label class="flex items-center justify-between p-2.5 rounded-lg border border-red-100 dark:border-red-900/50 bg-red-50/50 dark:bg-red-900/10">
                            <span class="text-sm font-medium text-red-700 dark:text-red-300">Delete</span>
                            <span class="inline-flex items-center">
                                <input type="checkbox" name="modules[{{ $m['key'] }}][delete]" value="1" class="sr-only toggle-input" {{ $flags['delete'] ? 'checked' : '' }}>
                                <span class="toggle-track red">
                                    <span class="toggle-thumb"></span>
                                </span>
                            </span>
                        </label>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Desktop View - Table Layout -->
        <div class="hidden sm:block overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                <thead class="bg-gray-50 dark:bg-gray-700/50">
                    <tr>
                        <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-gray-500 dark:text-gray-300 uppercase tracking-wider">Module</th>
                        <th scope="col" class="px-6 py-4 text-center text-xs font-semibold text-emerald-600 dark:text-emerald-400 uppercase tracking-wider">Create</th>
                        <th scope="col" class="px-6 py-4 text-center text-xs font-semibold text-blue-600 dark:text-blue-400 uppercase tracking-wider">Read</th>
                        <th scope="col" class="px-6 py-4 text-center text-xs font-semibold text-amber-600 dark:text-amber-400 uppercase tracking-wider">Update</th>
                        <th scope="col" class="px-6 py-4 text-center text-xs font-semibold text-red-600 dark:text-red-400 uppercase tracking-wider">Delete</th>
                    </tr>
                </thead>
                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                    @foreach($modules as $m)
                        @php $flags = $flagsByKey[$m['key']] ?? ['create'=>false,'read'=>false,'update'=>false,'delete'=>false]; @endphp
                        <tr class="hover:bg-gray-50/50 dark:hover:bg-gray-700/50 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900 dark:text-white">{{ $m['label'] }}</div>
                                <div class="text-xs text-gray-500 dark:text-gray-400 font-mono">menu-{{ $m['key'] }}</div>
                            </td>
                            
                            <!-- Create Toggle -->
                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                <label class="inline-flex items-center cursor-pointer">
                                    <input type="checkbox" name="modules[{{ $m['key'] }}][create]" value="1" class="sr-only toggle-input" {{ $flags['create'] ? 'checked' : '' }}>
                                    <span class="toggle-track emerald"><span class="toggle-thumb"></span></span>
                                </label>
                            </td>
                            
                            <!-- Read Toggle -->
                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                <label class="inline-flex items-center cursor-pointer">
                                    <input type="checkbox" name="modules[{{ $m['key'] }}][read]" value="1" class="sr-only toggle-input" {{ $flags['read'] ? 'checked' : '' }}>
                                    <span class="toggle-track blue"><span class="toggle-thumb"></span></span>
                                </label>
                            </td>
                            
                            <!-- Update Toggle -->
                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                <label class="inline-flex items-center cursor-pointer">
                                    <input type="checkbox" name="modules[{{ $m['key'] }}][update]" value="1" class="sr-only toggle-input" {{ $flags['update'] ? 'checked' : '' }}>
                                    <span class="toggle-track amber"><span class="toggle-thumb"></span></span>
                                </label>
                            </td>
                            
                            <!-- Delete Toggle -->
                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                <label class="inline-flex items-center cursor-pointer">
                                    <input type="checkbox" name="modules[{{ $m['key'] }}][delete]" value="1" class="sr-only toggle-input" {{ $flags['delete'] ? 'checked' : '' }}>
                                    <span class="toggle-track red"><span class="toggle-thumb"></span></span>
                                </label>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Form Actions -->
        <div class="px-6 py-4 bg-gray-50 dark:bg-gray-800/50 border-t border-gray-100 dark:border-gray-700 flex flex-col sm:flex-row items-center justify-between gap-4">
            <p class="text-xs text-gray-500 dark:text-gray-400">
                Toggle permissions for the <span class="font-medium">{{ $role->display_name ?? $role->name }}</span> role
            </p>
            <div class="flex flex-col sm:flex-row gap-3 w-full sm:w-auto">
                <a href="{{ route('partner.settings.index') }}" class="inline-flex items-center justify-center px-5 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg text-sm font-medium text-gray-700 dark:text-gray-200 bg-white dark:bg-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-200">
                    Cancel
                </a>
                <button type="submit" class="inline-flex items-center justify-center px-5 py-2.5 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all duration-200">
                    <x-icon name="save" class="w-4 h-4 mr-2" />
                    Save Changes
                </button>
            </div>
        </div>
    </form>
</div>

<style>
/* Minimal, Tailwind-independent toggle styles */
.toggle-track {
  width: 2.5rem; /* 40px */
  height: 1.25rem; /* 20px */
  background-color: #e5e7eb; /* gray-200 */
  border-radius: 9999px;
  display: inline-block;
  position: relative;
  vertical-align: middle;
  transition: background-color 0.2s ease;
}
.toggle-thumb {
  position: absolute;
  top: 2px;
  left: 2px;
  width: 1rem; /* 16px */
  height: 1rem;
  background: #fff;
  border-radius: 9999px;
  box-shadow: 0 1px 2px rgba(0,0,0,0.15);
  transition: transform 0.2s ease;
}
.toggle-input:checked + .toggle-track .toggle-thumb {
  transform: translateX(1.25rem); /* 20px */
}
/* Checked colors per action */
.toggle-input:checked + .toggle-track.emerald { background-color: #10b981; }
.toggle-input:checked + .toggle-track.blue    { background-color: #3b82f6; }
.toggle-input:checked + .toggle-track.amber   { background-color: #f59e0b; }
.toggle-input:checked + .toggle-track.red     { background-color: #ef4444; }
/* Dark mode base */
.dark .toggle-track { background-color: #4b5563; }
/* Scrollbar (optional, non-critical) */
::-webkit-scrollbar { height: 6px; width: 6px; }
::-webkit-scrollbar-thumb { background: #c7cbd1; border-radius: 9999px; }
</style>
@endsection
