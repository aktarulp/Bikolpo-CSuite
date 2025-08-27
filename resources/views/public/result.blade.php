@extends('layouts.app')

@section('title', 'Quiz Result')

@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">{{ $exam->title }} - Result</h1>
            <p class="text-gray-600 dark:text-gray-400">Score: {{ number_format($result->percentage,1) }}%</p>
        </div>
        <a href="{{ route('public.join') }}" class="text-blue-600">Join another quiz</a>
    </div>

    <div class="bg-white dark:bg-gray-800 rounded-lg shadow">
        <div class="p-6">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                <div>
                    <div class="text-sm text-gray-500">Correct</div>
                    <div class="text-xl font-semibold">{{ $result->correct_answers }}</div>
                </div>
                <div>
                    <div class="text-sm text-gray-500">Wrong</div>
                    <div class="text-xl font-semibold">{{ $result->wrong_answers }}</div>
                </div>
                <div>
                    <div class="text-sm text-gray-500">Unanswered</div>
                    <div class="text-xl font-semibold">{{ $result->unanswered }}</div>
                </div>
                <div>
                    <div class="text-sm text-gray-500">Marks</div>
                    <div class="text-xl font-semibold">{{ $result->score }}/{{ $exam->questionSet->total_marks }}</div>
                </div>
            </div>
        </div>
        <div class="border-t border-gray-200 dark:border-gray-700 p-6">
            <h2 class="text-lg font-semibold mb-4">Answers</h2>
            <div class="space-y-4">
            @foreach($questions as $index=>$q)
                <div>
                    <div class="text-sm text-gray-500">Question {{ $index+1 }}</div>
                    <div class="font-medium">{!! nl2br(e($q->question_text)) !!}</div>
                    <div class="mt-1 text-sm">Your answer: <span class="font-semibold">{{ $result->answers[$q->id] ?? '-' }}</span> · Correct: <span class="font-semibold">{{ $q->correct_answer }}</span></div>
                </div>
            @endforeach
            </div>
        </div>
    </div>
</div>
@endsection

