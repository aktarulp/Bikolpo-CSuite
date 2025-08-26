@extends('layouts.partner-layout')

@section('title', 'Question Set Details')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold text-gray-900 dark:text-white">{{ $questionSet->name }}</h1>
            <p class="text-gray-600 dark:text-gray-400">Manage questions in this set</p>
        </div>
        <div class="flex items-center gap-2">
            <a href="{{ route('partner.question-sets.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg">Back</a>
            <a href="{{ route('partner.question-sets.edit', $questionSet) }}" class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg">Edit Set</a>
        </div>
    </div>

    <!-- Summary Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6 border border-gray-200 dark:border-gray-700">
            <p class="text-sm text-gray-600 dark:text-gray-400">Total Question</p>
            <p class="text-2xl font-semibold text-gray-900 dark:text-white">{{ $questionSet->question_limit ?? '—' }}</p>
        </div>
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6 border border-gray-200 dark:border-gray-700">
            <p class="text-sm text-gray-600 dark:text-gray-400">Question Added</p>
            <p class="text-2xl font-semibold text-gray-900 dark:text-white">{{ $questionSet->total_questions }}</p>
        </div>
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6 border border-gray-200 dark:border-gray-700">
            <p class="text-sm text-gray-600 dark:text-gray-400">Question to add</p>
            <p class="text-2xl font-semibold text-gray-900 dark:text-white">
                {{ $questionSet->question_limit ? max(0, $questionSet->question_limit - $questionSet->total_questions) : '—' }}
            </p>
        </div>
    </div>

    <!-- Attached Questions -->
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md border border-gray-200 dark:border-gray-700">
        <div class="p-6 border-b border-gray-200 dark:border-gray-700 flex items-center justify-between">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Attached Questions ({{ $questionSet->questions->count() }})</h3>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                <thead class="bg-gray-50 dark:bg-gray-700">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">#</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Question</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Course / Subject / Topic</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                    @forelse($questionSet->questions as $idx => $q)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                            <td class="px-6 py-4 whitespace-nowrap text-sm">{{ $idx + 1 }}</td>
                            <td class="px-6 py-4 text-sm">
                                {!! \Illuminate\Support\Str::limit($q->question_text, 160) !!}
                                @if($q->isMcq())
                                <div class="mt-2 grid grid-cols-1 md:grid-cols-2 gap-2 text-xs text-gray-800 dark:text-gray-200">
                                    <div><span class="font-semibold mr-1">A.</span> {{ $q->option_a }}</div>
                                    <div><span class="font-semibold mr-1">B.</span> {{ $q->option_b }}</div>
                                    <div><span class="font-semibold mr-1">C.</span> {{ $q->option_c }}</div>
                                    <div><span class="font-semibold mr-1">D.</span> {{ $q->option_d }}</div>
                                </div>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-xs text-gray-600 dark:text-gray-300">
                                {{ $q->topic->subject->course->name ?? '-' }} → 
                                {{ $q->topic->subject->name ?? '-' }} → 
                                {{ $q->topic->name ?? '-' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                <form action="{{ route('partner.question-sets.remove-question', [$questionSet, $q]) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-800 dark:text-red-400 dark:hover:text-red-300" onclick="return confirm('Remove this question from the set?')">Remove</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-4 text-center text-gray-500 dark:text-gray-400">No questions attached yet.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Available Questions to Add -->
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md border border-gray-200 dark:border-gray-700">
        <div class="p-6 border-b border-gray-200 dark:border-gray-700">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Add Questions</h3>
            <p class="text-sm text-gray-500 dark:text-gray-400">Filter and select questions to add to this set.</p>
        </div>

        <div class="p-6">
            <div id="filters-form" class="grid grid-cols-1 md:grid-cols-6 gap-3 mb-4">
                <div>
                    <label class="block text-xs font-medium mb-1">Course</label>
                    <select name="course" class="w-full rounded-md border p-2 text-sm dark:bg-gray-900 dark:border-gray-700">
                        <option value="">All Courses</option>
                        @foreach(($courses ?? []) as $course)
                            <option value="{{ $course->id }}" {{ request('course') == $course->id ? 'selected' : '' }}>{{ $course->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-medium mb-1">Subject</label>
                    <select name="subject" class="w-full rounded-md border p-2 text-sm dark:bg-gray-900 dark:border-gray-700">
                        <option value="">All Subjects</option>
                        @foreach(($subjects ?? []) as $subject)
                            <option value="{{ $subject->id }}" {{ request('subject') == $subject->id ? 'selected' : '' }}>{{ $subject->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-medium mb-1">Topic</label>
                    <select name="topic" class="w-full rounded-md border p-2 text-sm dark:bg-gray-900 dark:border-gray-700">
                        <option value="">All Topics</option>
                        @foreach(($topics ?? []) as $topic)
                            <option value="{{ $topic->id }}" {{ request('topic') == $topic->id ? 'selected' : '' }}>{{ $topic->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-medium mb-1">Question Type</label>
                    <select name="question_type" class="w-full rounded-md border p-2 text-sm dark:bg-gray-900 dark:border-gray-700">
                        <option value="">All Types</option>
                        @foreach(($questionTypes ?? []) as $questionType)
                            <option value="{{ $questionType->q_type_id }}" {{ request('question_type') == $questionType->q_type_id ? 'selected' : '' }}>{{ $questionType->q_type_name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="md:col-span-2">
                    <label class="block text-xs font-medium mb-1">Search</label>
                    <div class="flex gap-2">
                        <input name="search" value="{{ request('search') }}" type="text" placeholder="Search question, course, subject, topic..." class="w-full rounded-md border p-2 text-sm dark:bg-gray-900 dark:border-gray-700">
                        <button type="button" id="apply-filters" class="px-3 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-md text-sm">Apply</button>
                        <a href="{{ route('partner.question-sets.show', $questionSet) }}" class="px-3 py-2 bg-gray-500 hover:bg-gray-600 text-white rounded-md text-sm">Clear</a>
                    </div>
                </div>
            </div>

            <form id="add-questions-form" action="{{ route('partner.question-sets.add-questions', $questionSet) }}" method="POST">
                @csrf
                <div class="flex items-center justify-between mb-3">
                    <div class="text-sm text-gray-600 dark:text-gray-300">Available: {{ $availableQuestions->firstItem() }}-{{ $availableQuestions->lastItem() }} of {{ $availableQuestions->total() }}</div>
                    <div class="flex items-center gap-2">
                        <button type="button" id="select-all-page" class="px-3 py-1.5 bg-gray-200 hover:bg-gray-300 text-gray-800 rounded-md text-sm">Select all on page</button>
                        <button type="button" id="clear-selection" class="px-3 py-1.5 bg-red-100 hover:bg-red-200 text-red-700 rounded-md text-sm">Clear selection</button>
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full border rounded-lg dark:border-gray-700">
                        <thead class="bg-gray-100 dark:bg-gray-700/50">
                            <tr>
                                <th class="p-2 text-left w-10">#</th>
                                <th class="p-2 text-left">Question</th>
                                <th class="p-2 text-left">Course / Subject / Topic</th>
                                <th class="p-2 text-left">Type</th>
                            </tr>
                        </thead>
                        <tbody class="dark:divide-gray-700">
                            @forelse($availableQuestions ?? [] as $q)
                                <tr class="border-b dark:border-gray-700">
                                    <td class="p-2 align-top">
                                        <input type="checkbox" name="question_ids[]" value="{{ $q->id }}" class="q-checkbox">
                                    </td>
                                    <td class="p-2 align-top text-sm">{!! Str::limit($q->question_text, 160) !!}</td>
                                    <td class="p-2 align-top text-xs text-gray-600 dark:text-gray-300">
                                        {{ $q->topic->subject->course->name ?? '-' }} → 
                                        {{ $q->topic->subject->name ?? '-' }} → 
                                        {{ $q->topic->name ?? '-' }}
                                    </td>
                                    <td class="p-2 align-top text-xs">{{ $q->questionType->q_type_code ?? strtoupper($q->question_type ?? '-') }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="p-4 text-center text-gray-500 dark:text-gray-400">No questions found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="mt-4 flex items-center justify-between">
                    <div>
                        {{ ($availableQuestions ?? null) ? $availableQuestions->withQueryString()->links() : '' }}
                    </div>
                    <div>
                        <button type="submit" class="bg-primaryGreen hover:bg-green-600 text-white px-4 py-2 rounded-lg">Add Selected</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const filtersWrapper = document.getElementById('filters-form');
    const applyBtn = document.getElementById('apply-filters');
    const selectAllBtn = document.getElementById('select-all-page');
    const clearSelectionBtn = document.getElementById('clear-selection');

    if (applyBtn && filtersWrapper) {
        applyBtn.addEventListener('click', function() {
            const params = new URLSearchParams(window.location.search);
            filtersWrapper.querySelectorAll('select, input[name="search"]').forEach(el => {
                if (el.name) {
                    if (el.value) params.set(el.name, el.value); else params.delete(el.name);
                }
            });
            const url = `${window.location.pathname}?${params.toString()}`;
            window.location.assign(url);
        });
    }

    if (selectAllBtn) {
        selectAllBtn.addEventListener('click', function() {
            document.querySelectorAll('.q-checkbox').forEach(cb => cb.checked = true);
        });
    }

    if (clearSelectionBtn) {
        clearSelectionBtn.addEventListener('click', function() {
            document.querySelectorAll('.q-checkbox').forEach(cb => cb.checked = false);
        });
    }
});
</script>
@endpush
@endsection 


