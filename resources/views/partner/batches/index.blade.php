@extends('layouts.partner-layout')

@section('title', 'Batches')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-purple-50 via-pink-50 to-blue-50 dark:from-gray-900 dark:via-purple-900 dark:to-indigo-900 -m-6 p-4 sm:p-6 lg:p-8">
    <div class="max-w-7xl mx-auto space-y-4 sm:space-y-6">
        <!-- Page Header - Mobile First -->
        <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-4 bg-white/80 dark:bg-gray-800/80 backdrop-blur-lg rounded-2xl p-4 sm:p-6 shadow-xl border border-purple-200 dark:border-purple-700">
            <div class="space-y-1">
                <h1 class="text-2xl sm:text-3xl lg:text-4xl font-bold bg-gradient-to-r from-purple-600 via-pink-600 to-blue-600 bg-clip-text text-transparent">
                    🎓 Batches
                </h1>
                <p class="text-sm sm:text-base text-gray-600 dark:text-gray-300">Manage your coaching center batches</p>
            </div>
            <a href="{{ route('partner.batches.create') }}" 
               class="w-full sm:w-auto inline-flex items-center justify-center gap-2 bg-gradient-to-r from-green-500 to-emerald-600 hover:from-green-600 hover:to-emerald-700 text-white px-4 sm:px-6 py-3 rounded-xl font-semibold shadow-lg hover:shadow-xl transform hover:scale-105 transition-all duration-200">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                <span>Add New Batch</span>
            </a>
        </div>

        <!-- Batches List - Mobile First Design -->
        <div class="bg-white/90 dark:bg-gray-800/90 backdrop-blur-lg rounded-2xl shadow-xl border border-purple-200 dark:border-purple-700 overflow-hidden">
            <div class="p-4 sm:p-6 border-b border-purple-200 dark:border-purple-700 bg-gradient-to-r from-purple-100 to-pink-100 dark:from-purple-900 dark:to-pink-900">
                <h3 class="text-lg sm:text-xl font-bold text-gray-900 dark:text-white flex items-center gap-2">
                    <svg class="w-6 h-6 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                    </svg>
                    All Batches
                </h3>
            </div>
            
            @if($batches->count() > 0)
                <!-- Mobile Card View (visible on mobile) -->
                <div class="block lg:hidden divide-y divide-gray-200 dark:divide-gray-700">
                    @foreach($batches as $batch)
                        <div class="p-3 hover:bg-purple-50 dark:hover:bg-purple-900/20 transition-colors duration-200">
                            <div class="flex items-start justify-between mb-2">
                                <div class="flex-1">
                                    <h4 class="text-sm font-bold text-gray-900 dark:text-white mb-0.5">{{ $batch->name }}</h4>
                                    <p class="text-xs text-gray-600 dark:text-gray-400">📅 Year: {{ $batch->year }}</p>
                                </div>
                                <div class="flex flex-col items-end gap-1">
                                    <span class="inline-flex px-2.5 py-0.5 text-xs font-bold rounded-full shadow-sm
                                        @if($batch->status === 'active') 
                                            bg-gradient-to-r from-green-400 to-emerald-500 text-white
                                        @else 
                                            bg-gradient-to-r from-red-400 to-pink-500 text-white
                                        @endif">
                                        {{ ucfirst($batch->status) }}
                                    </span>
                                    <span class="inline-flex items-center gap-1 px-2.5 py-0.5 text-xs font-bold rounded-full shadow-sm bg-gradient-to-r from-blue-400 to-indigo-500 text-white">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                        </svg>
                                        {{ $batch->students_count ?? 0 }}
                                    </span>
                                </div>
                            </div>
                            <div class="flex flex-wrap gap-2">
                                <a href="{{ route('partner.batches.edit', $batch) }}" 
                                   class="flex-1 min-w-[100px] text-center bg-gradient-to-r from-indigo-500 to-purple-600 hover:from-indigo-600 hover:to-purple-700 text-white px-3 py-1.5 rounded-lg text-xs font-semibold shadow-md hover:shadow-lg transition-all duration-200">
                                    ✏️ Edit
                                </a>
                                <form action="{{ route('partner.batches.destroy', $batch) }}" method="POST" class="flex-1 min-w-[100px]">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                            class="w-full bg-gradient-to-r from-red-500 to-pink-600 hover:from-red-600 hover:to-pink-700 text-white px-3 py-1.5 rounded-lg text-xs font-semibold shadow-md hover:shadow-lg transition-all duration-200">
                                        🗑️ Delete
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Desktop Table View (hidden on mobile) -->
                <div class="hidden lg:block overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                        <thead class="bg-gradient-to-r from-purple-100 to-pink-100 dark:from-purple-900 dark:to-pink-900">
                            <tr>
                                <th class="px-6 py-4 text-left text-xs font-bold text-purple-900 dark:text-purple-100 uppercase tracking-wider">Batch Name</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-purple-900 dark:text-purple-100 uppercase tracking-wider">Year</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-purple-900 dark:text-purple-100 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-purple-900 dark:text-purple-100 uppercase tracking-wider">Students</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-purple-900 dark:text-purple-100 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                            @foreach($batches as $batch)
                                <tr class="hover:bg-purple-50 dark:hover:bg-purple-900/20 transition-colors duration-200">
                                    <td class="px-6 py-3">
                                        <div class="text-sm font-bold text-gray-900 dark:text-white">{{ $batch->name }}</div>
                                    </td>
                                    <td class="px-6 py-3">
                                        <span class="text-sm font-semibold text-gray-700 dark:text-gray-300">📅 {{ $batch->year }}</span>
                                    </td>
                                    <td class="px-6 py-3">
                                        <span class="inline-flex px-2.5 py-0.5 text-xs font-bold rounded-full shadow-sm
                                            @if($batch->status === 'active') 
                                                bg-gradient-to-r from-green-400 to-emerald-500 text-white
                                            @else 
                                                bg-gradient-to-r from-red-400 to-pink-500 text-white
                                            @endif">
                                            {{ ucfirst($batch->status) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-3">
                                        <span class="inline-flex items-center gap-1.5 px-3 py-1.5 text-sm font-bold rounded-lg shadow-sm bg-gradient-to-r from-blue-500 to-indigo-600 text-white">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                            </svg>
                                            {{ $batch->students_count ?? 0 }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-3 text-sm font-medium">
                                        <div class="flex gap-2">
                                            <a href="{{ route('partner.batches.edit', $batch) }}" 
                                               class="inline-flex items-center gap-1 bg-gradient-to-r from-indigo-500 to-purple-600 hover:from-indigo-600 hover:to-purple-700 text-white px-3 py-1.5 rounded-lg text-xs font-semibold shadow-md hover:shadow-lg transition-all duration-200">
                                                ✏️ Edit
                                            </a>
                                            <form action="{{ route('partner.batches.destroy', $batch) }}" method="POST" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" 
                                                        class="inline-flex items-center gap-1 bg-gradient-to-r from-red-500 to-pink-600 hover:from-red-600 hover:to-pink-700 text-white px-3 py-1.5 rounded-lg text-xs font-semibold shadow-md hover:shadow-lg transition-all duration-200">
                                                    🗑️ Delete
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                
                <!-- Pagination -->
                <div class="px-4 sm:px-6 py-4 border-t border-purple-200 dark:border-purple-700 bg-gradient-to-r from-purple-50 to-pink-50 dark:from-purple-900/50 dark:to-pink-900/50">
                    {{ $batches->links() }}
                </div>
            @else
                <div class="p-8 sm:p-12 text-center">
                    <div class="inline-flex items-center justify-center w-20 h-20 sm:w-24 sm:h-24 rounded-full bg-gradient-to-br from-purple-100 to-pink-100 dark:from-purple-900 dark:to-pink-900 mb-4">
                        <svg class="w-10 h-10 sm:w-12 sm:h-12 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl sm:text-2xl font-bold text-gray-900 dark:text-white mb-2">No batches yet! 🎓</h3>
                    <p class="text-sm sm:text-base text-gray-600 dark:text-gray-400 mb-6">Get started by creating your first batch.</p>
                    <a href="{{ route('partner.batches.create') }}" 
                       class="inline-flex items-center gap-2 px-6 py-3 bg-gradient-to-r from-green-500 to-emerald-600 hover:from-green-600 hover:to-emerald-700 text-white font-bold rounded-xl shadow-lg hover:shadow-xl transform hover:scale-105 transition-all duration-200">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                        </svg>
                        Add Your First Batch
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
