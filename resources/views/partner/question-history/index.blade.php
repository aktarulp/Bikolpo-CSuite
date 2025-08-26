@extends('layouts.partner-layout')

@section('title', 'Question History')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900">
                <!-- Header -->
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-2xl font-bold text-gray-900">Question History</h2>
                    <a href="{{ route('partner.question-history.create') }}" 
                       class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                        Add New Record
                    </a>
                </div>

                <!-- Statistics Cards -->
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
                    <div class="bg-blue-50 p-4 rounded-lg border border-blue-200">
                        <div class="text-blue-600 text-sm font-medium">Total Records</div>
                        <div class="text-2xl font-bold text-blue-900">{{ $questionHistories->total() }}</div>
                    </div>
                    <div class="bg-green-50 p-4 rounded-lg border border-green-200">
                        <div class="text-green-600 text-sm font-medium">Verified</div>
                        <div class="text-2xl font-bold text-green-900">{{ $questionHistories->where('is_verified', true)->count() }}</div>
                    </div>
                    <div class="bg-yellow-50 p-4 rounded-lg border border-yellow-200">
                        <div class="text-yellow-600 text-sm font-medium">Unverified</div>
                        <div class="text-2xl font-bold text-yellow-900">{{ $questionHistories->where('is_verified', false)->count() }}</div>
                    </div>
                    <div class="bg-purple-50 p-4 rounded-lg border border-purple-200">
                        <div class="text-purple-600 text-sm font-medium">This Year</div>
                        <div class="text-2xl font-bold text-purple-900">{{ $questionHistories->where('exam_year', date('Y'))->count() }}</div>
                    </div>
                </div>

                <!-- Filters -->
                <div class="bg-gray-50 p-4 rounded-lg mb-6">
                    <form method="GET" action="{{ route('partner.question-history.index') }}" class="grid grid-cols-1 md:grid-cols-5 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Exam Year</label>
                            <select name="exam_year" class="w-full border-gray-300 rounded-md shadow-sm">
                                <option value="">All Years</option>
                                @foreach($examYears as $year)
                                    <option value="{{ $year }}" {{ request('exam_year') == $year ? 'selected' : '' }}>
                                        {{ $year }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Exam Month</label>
                            <select name="exam_month" class="w-full border-gray-300 rounded-md shadow-sm">
                                <option value="">All Months</option>
                                @foreach($examMonths as $month)
                                    <option value="{{ $month }}" {{ request('exam_month') == $month ? 'selected' : '' }}>
                                        {{ $month }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Exam Name</label>
                            <select name="public_exam_name" class="w-full border-gray-300 rounded-md shadow-sm">
                                <option value="">All Exams</option>
                                @foreach($examNames as $examName)
                                    <option value="{{ $examName }}" {{ request('public_exam_name') == $examName ? 'selected' : '' }}>
                                        {{ $examName }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Board</label>
                            <select name="exam_board" class="w-full border-gray-300 rounded-md shadow-sm">
                                <option value="">All Boards</option>
                                @foreach($examBoards as $board)
                                    <option value="{{ $board }}" {{ request('exam_board') == $board ? 'selected' : '' }}>
                                        {{ $board }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                            <select name="verified" class="w-full border-gray-300 rounded-md shadow-sm">
                                <option value="">All</option>
                                <option value="1" {{ request('verified') === '1' ? 'selected' : '' }}>Verified</option>
                                <option value="0" {{ request('verified') === '0' ? 'selected' : '' }}>Unverified</option>
                            </select>
                        </div>
                        <div class="md:col-span-5 flex gap-2">
                            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded">
                                Apply Filters
                            </button>
                            <a href="{{ route('partner.question-history.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded">
                                Clear Filters
                            </a>
                        </div>
                    </form>
                </div>

                <!-- Table -->
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Question
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Partner
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Exam Details
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Board & Type
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Details
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Status
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Actions
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($questionHistories as $history)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-medium text-gray-900">
                                            {{ Str::limit($history->question->question_text ?? 'N/A', 50) }}
                                        </div>
                                        <div class="text-sm text-gray-500">
                                            ID: {{ $history->question_id }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-medium text-gray-900">
                                            {{ $history->partner->name ?? $history->partner->email ?? 'N/A' }}
                                        </div>
                                        <div class="text-sm text-gray-500">
                                            Partner ID: {{ $history->partner_id }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-medium text-gray-900">
                                            {{ $history->public_exam_name }}
                                        </div>
                                        @if($history->private_exam_name)
                                            <div class="text-sm text-blue-600">
                                                {{ $history->private_exam_name }}
                                            </div>
                                        @endif
                                        <div class="text-sm text-gray-500">
                                            {{ $history->exam_month }} {{ $history->exam_year }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">
                                            {{ $history->exam_board ?? 'N/A' }}
                                        </div>
                                        <div class="text-sm text-gray-500">
                                            {{ $history->exam_type ?? 'N/A' }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">
                                            Q{{ $history->question_number ?? 'N/A' }} • {{ $history->marks_allocated ?? 'N/A' }} marks
                                        </div>

                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if($history->is_verified)
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                Verified
                                            </span>
                                            @if($history->verified_by)
                                                <div class="text-xs text-gray-500 mt-1">
                                                    by {{ $history->verified_by }}
                                                </div>
                                            @endif
                                        @else
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                                Unverified
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <div class="flex space-x-2">
                                            <a href="{{ route('partner.question-history.show', $history) }}" 
                                               class="text-blue-600 hover:text-blue-900">View</a>
                                            <a href="{{ route('partner.question-history.edit', $history) }}" 
                                               class="text-indigo-600 hover:text-indigo-900">Edit</a>
                                            <form method="POST" action="{{ route('partner.question-history.destroy', $history) }}" 
                                                  class="inline" onsubmit="return confirm('Are you sure you want to delete this record?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-900">Delete</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-4 text-center text-gray-500">
                                        No question history records found.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                @if($questionHistories->hasPages())
                    <div class="mt-6">
                        {{ $questionHistories->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
