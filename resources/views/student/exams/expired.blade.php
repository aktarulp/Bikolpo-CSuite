@extends('layouts.student-layout')

@section('title', 'Exams Expired')

@section('content')
<div class="min-h-screen bg-gray-50 dark:bg-[#0d1117] transition-colors duration-500">
    <div class="sticky top-0 z-10 bg-white/95 dark:bg-[#161b22]/95 backdrop-blur-sm shadow-md border-b border-gray-200 dark:border-gray-800 px-4 sm:px-6 lg:px-8 py-4">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-2">
            <div>
                <h1 class="text-2xl sm:text-3xl font-extrabold text-gray-900 dark:text-white leading-tight">
                    ⏰ Exams Expired
                </h1>
                <p class="text-gray-500 dark:text-gray-400 text-sm mt-1">
                    No exams are currently available
                </p>
            </div>
        </div>
    </div>

    <div class="px-4 sm:px-6 lg:px-8 py-8">
        <div class="max-w-2xl mx-auto text-center">
            <div class="bg-white dark:bg-[#161b22] rounded-2xl shadow-xl border border-gray-100 dark:border-gray-800 p-8">
                <div class="mx-auto flex items-center justify-center h-24 w-24 rounded-full bg-amber-500/10 dark:bg-amber-900/40">
                    <svg class="h-12 w-12 text-amber-500 dark:text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <h3 class="mt-6 text-2xl font-extrabold text-gray-900 dark:text-white">No Exams Available</h3>
                <p class="mt-4 text-lg text-gray-500 dark:text-gray-400">
                    There are currently no exams available for you. Please check back later or contact your instructor for more information.
                </p>
                <div class="mt-8">
                    <a href="{{ route('student.dashboard') }}" 
                       class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-full shadow-lg text-white bg-gradient-to-r from-blue-500 to-indigo-600 hover:from-blue-600 hover:to-indigo-700 transition-all duration-300 transform hover:scale-[1.03]">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                        Back to Dashboard
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection