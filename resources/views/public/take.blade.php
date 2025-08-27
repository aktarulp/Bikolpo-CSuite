@extends('layouts.app')

@section('title', 'Take Quiz')

@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">{{ $exam->title }}</h1>
            <p class="text-gray-600 dark:text-gray-400">Duration: {{ $exam->duration }} minutes</p>
        </div>
        <div class="text-right">
            <div class="text-sm text-gray-500">Time Left</div>
            <div id="timer" class="text-2xl font-mono">--:--</div>
        </div>
    </div>

    <form id="quizForm" method="POST" action="{{ route('public.submit', $exam) }}">
        @csrf
        <input type="hidden" name="phone" value="{{ $assignment->phone }}">
        <input type="hidden" name="code" value="{{ $assignment->access_code }}">
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow divide-y divide-gray-200 dark:divide-gray-700">
            @foreach($questions as $index => $q)
                <div class="p-6">
                    <div class="mb-2 text-sm text-gray-500">Question {{ $index + 1 }}</div>
                    <div class="font-medium mb-3">{!! nl2br(e($q->question_text)) !!}</div>
                    <div class="space-y-2">
                        @foreach(['a','b','c','d'] as $opt)
                            @php($field = 'option_' . $opt)
                            @if($q->$field)
                                <label class="flex items-start gap-2">
                                    <input type="radio" name="answers[{{ $q->id }}]" value="{{ $opt }}" class="mt-1">
                                    <span>{{ $q->$field }}</span>
                                </label>
                            @endif
                        @endforeach
                    </div>
                </div>
            @endforeach
        </div>
        <div class="mt-4 flex items-center justify-end gap-3">
            <button type="button" onclick="submitQuiz()" class="bg-primaryGreen hover:bg-green-600 text-white px-4 py-2 rounded-md">Submit</button>
        </div>
    </form>
</div>

<script>
const startedAt = new Date(@json($result->started_at->timestamp * 1000));
const durationMinutes = {{ $exam->duration }};
const deadline = new Date(startedAt.getTime() + durationMinutes * 60000);

function updateTimer() {
    const now = new Date();
    const remainingMs = Math.max(0, deadline - now);
    const m = Math.floor(remainingMs / 60000);
    const s = Math.floor((remainingMs % 60000) / 1000);
    document.getElementById('timer').textContent = `${String(m).padStart(2,'0')}:${String(s).padStart(2,'0')}`;
    if (remainingMs <= 0) {
        submitQuiz();
    }
}

function submitQuiz() {
    document.getElementById('quizForm').submit();
}

setInterval(updateTimer, 1000);
updateTimer();
</script>
@endsection

