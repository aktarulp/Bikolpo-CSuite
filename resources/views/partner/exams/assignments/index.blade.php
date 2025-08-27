@extends('layouts.partner-layout')

@section('title', 'Exam Assignments')

@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Assignments for: {{ $exam->title }}</h1>
            <p class="text-gray-600 dark:text-gray-400">Create student access codes by phone number</p>
        </div>
        <a href="{{ route('partner.exams.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg">Back</a>
    </div>

    <div class="bg-white dark:bg-gray-800 rounded-lg shadow">
        <div class="p-6 border-b border-gray-200 dark:border-gray-700">
            <h2 class="text-lg font-semibold text-gray-900 dark:text-white">Bulk Add Assignments</h2>
            <p class="text-sm text-gray-500 dark:text-gray-400">Paste phone numbers (and optional names) one per line: 017XXXXXXXX, Name</p>
        </div>
        <div class="p-6">
            <form method="POST" action="{{ route('partner.exams.assignments.store', $exam) }}" onsubmit="return prepareEntries()">
                @csrf
                <textarea id="bulk" class="w-full rounded-md border p-3 h-40" placeholder="017XXXXXXXX, Mahmud\n018XXXXXXXX\n..."></textarea>
                <input type="hidden" name="entries" id="entries">
                <div class="mt-4">
                    <button class="bg-primaryGreen hover:bg-green-600 text-white px-4 py-2 rounded-lg">Generate Codes</button>
                </div>
            </form>
        </div>
    </div>

    <div class="bg-white dark:bg-gray-800 rounded-lg shadow">
        <div class="p-6 border-b border-gray-200 dark:border-gray-700 flex items-center justify-between">
            <h2 class="text-lg font-semibold text-gray-900 dark:text-white">Assignments ({{ $assignments->total() }})</h2>
            <a href="{{ route('partner.exams.show', $exam) }}" class="text-blue-600 dark:text-blue-400">View Exam</a>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                <thead class="bg-gray-50 dark:bg-gray-700/50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Phone</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Name</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Code</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Attempts</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Used</th>
                        <th class="px-6 py-3"></th>
                    </tr>
                </thead>
                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                    @foreach($assignments as $a)
                        <tr>
                            <td class="px-6 py-3 text-sm">{{ $a->phone }}</td>
                            <td class="px-6 py-3 text-sm">{{ $a->student_name }}</td>
                            <td class="px-6 py-3 font-mono text-sm">{{ $a->access_code }}</td>
                            <td class="px-6 py-3 text-sm">{{ $a->attempts }}</td>
                            <td class="px-6 py-3 text-sm">{{ $a->used_at ? $a->used_at->format('M d, H:i') : '-' }}</td>
                            <td class="px-6 py-3 text-sm text-right">
                                <form action="{{ route('partner.exams.assignments.regenerate', [$exam, $a]) }}" method="POST" class="inline">@csrf<button class="text-indigo-600">Regenerate</button></form>
                                <form action="{{ route('partner.exams.assignments.destroy', [$exam, $a]) }}" method="POST" class="inline ml-3">@csrf @method('DELETE')<button class="text-red-600">Delete</button></form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="p-6 border-t border-gray-200 dark:border-gray-700">{{ $assignments->links() }}</div>
    </div>
</div>

<script>
function prepareEntries() {
    const raw = document.getElementById('bulk').value.trim();
    if (!raw) return false;
    const lines = raw.split(/\n+/).map(l => l.trim()).filter(Boolean);
    const entries = lines.map(line => {
        const [phone, name] = line.split(',').map(s => (s||'').trim());
        return { phone, student_name: name || null };
    });
    document.getElementById('entries').value = JSON.stringify(entries);
    return true;
}
</script>
@endsection

