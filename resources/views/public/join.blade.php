@extends('layouts.app')

@section('title', 'Join Quiz')

@section('content')
<div class="max-w-md mx-auto bg-white dark:bg-gray-800 rounded-lg shadow p-6">
    <h1 class="text-2xl font-bold text-gray-900 dark:text-white mb-2">Join Quiz</h1>
    <p class="text-gray-600 dark:text-gray-400 mb-6">Enter your phone number and 6-digit access code.</p>

    @if ($errors->any())
        <div class="mb-4 p-3 rounded bg-red-50 text-red-700">
            {{ $errors->first() }}
        </div>
    @endif
    @if (session('error'))
        <div class="mb-4 p-3 rounded bg-red-50 text-red-700">{{ session('error') }}</div>
    @endif
    @if (session('success'))
        <div class="mb-4 p-3 rounded bg-green-50 text-green-700">{{ session('success') }}</div>
    @endif

    <form method="POST" action="{{ route('public.join.submit') }}" class="space-y-4">
        @csrf
        <div>
            <label class="block text-sm font-medium mb-1">Phone</label>
            <input type="text" name="phone" value="{{ old('phone') }}" class="w-full rounded-md border p-2" placeholder="017XXXXXXXX" required>
        </div>
        <div>
            <label class="block text-sm font-medium mb-1">Access Code</label>
            <input type="text" name="code" value="{{ old('code') }}" class="w-full rounded-md border p-2 tracking-widest text-center" maxlength="6" required>
        </div>
        <button class="w-full bg-primaryGreen hover:bg-green-600 text-white px-4 py-2 rounded-md">Start</button>
    </form>
</div>
@endsection

