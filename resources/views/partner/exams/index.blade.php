@extends('layouts.partner-layout')

@section('title', 'Exams')

@section('content')
<div class="space-y-6">
    <!-- Page Header -->
    <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
        <div>
            <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Exams</h1>
            <p class="text-gray-600 dark:text-gray-400">Manage scheduled exams</p>
        </div>
        <div class="flex flex-col md:flex-row gap-3 md:items-center">
            <form method="GET" action="{{ route('partner.exams.index') }}" class="flex gap-2">
                <input type="text" name="q" value="{{ request('q') }}" placeholder="Search title/description" class="rounded-md border p-2 w-64" />
                <select name="status" class="rounded-md border p-2">
                    <option value="">All Status</option>
                    @php($statuses=['draft','published','ongoing','completed','cancelled'])
                    @foreach($statuses as $s)
                        <option value="{{ $s }}" {{ request('status')===$s ? 'selected' : '' }}>{{ ucfirst($s) }}</option>
                    @endforeach
                </select>
                <button class="bg-gray-200 hover:bg-gray-300 text-gray-700 px-3 rounded-md">Filter</button>
            </form>
            <a href="{{ route('partner.exams.create') }}" 
               class="bg-primaryGreen hover:bg-green-600 text-white px-4 py-2 rounded-lg transition-colors duration-200 text-center">
                Create Exam
            </a>
        </div>
    </div>

    <!-- Exams List -->
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md">
        <div class="p-6 border-b border-gray-200 dark:border-gray-700">
            <div class="flex flex-wrap gap-2 items-center">
                <h2 class="text-lg font-semibold text-gray-900 dark:text-white">Exams ({{ $exams->total() }})</h2>
                @isset($counts)
                    <div class="flex flex-wrap gap-2 text-xs">
                        <a href="{{ route('partner.exams.index') }}" class="px-2 py-1 rounded-full bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-200">All {{ $counts['all'] ?? 0 }}</a>
                        <a href="{{ route('partner.exams.index', ['status'=>'draft']) }}" class="px-2 py-1 rounded-full bg-gray-100 dark:bg-gray-700">Draft {{ $counts['draft'] ?? 0 }}</a>
                        <a href="{{ route('partner.exams.index', ['status'=>'published']) }}" class="px-2 py-1 rounded-full bg-green-100 text-green-800">Published {{ $counts['published'] ?? 0 }}</a>
                        <a href="{{ route('partner.exams.index', ['status'=>'ongoing']) }}" class="px-2 py-1 rounded-full bg-blue-100 text-blue-800">Ongoing {{ $counts['ongoing'] ?? 0 }}</a>
                        <a href="{{ route('partner.exams.index', ['status'=>'completed']) }}" class="px-2 py-1 rounded-full bg-purple-100 text-purple-800">Completed {{ $counts['completed'] ?? 0 }}</a>
                    </div>
                @endisset
            </div>
        </div>

        @if($exams->count() > 0)
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                    <thead class="bg-gray-50 dark:bg-gray-700/50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">ID</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Title</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Question Set</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Duration</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Window</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-3"></th>
                        </tr>
                    </thead>
                    <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                        @foreach($exams as $exam)
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">#{{ $exam->id }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-gray-100">
                                    <a href="{{ route('partner.exams.show', $exam) }}" class="text-blue-600 dark:text-blue-400 hover:underline">{{ $exam->title }}</a>
                                    <div class="text-xs text-gray-500 dark:text-gray-400">Passing: {{ $exam->passing_marks }}%</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700 dark:text-gray-200">{{ $exam->questionSet->name }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700 dark:text-gray-200">{{ $exam->duration }} min</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700 dark:text-gray-200">{{ $exam->start_time->format('M d, H:i') }} – {{ $exam->end_time->format('M d, H:i') }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                        @if($exam->status === 'published') bg-green-100 text-green-800
                                        @elseif($exam->status === 'draft') bg-gray-100 text-gray-800
                                        @elseif($exam->status === 'ongoing') bg-blue-100 text-blue-800
                                        @elseif($exam->status === 'completed') bg-purple-100 text-purple-800
                                        @else bg-red-100 text-red-800 @endif">{{ ucfirst($exam->status) }}</span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm">
                                    <div class="flex items-center gap-3">
                                        <a href="{{ route('partner.exams.show', $exam) }}" class="text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300">View</a>
                                        <a href="{{ route('partner.exams.edit', $exam) }}" class="text-green-600 hover:text-green-800 dark:text-green-400 dark:hover:text-green-300">Edit</a>
                                        @if($exam->status === 'draft')
                                            <form action="{{ route('partner.exams.publish', $exam) }}" method="POST" class="inline">@csrf<button type="submit" class="text-orange-600 hover:text-orange-800 dark:text-orange-400 dark:hover:text-orange-300">Publish</button></form>
                                        @elseif($exam->status === 'published')
                                            <form action="{{ route('partner.exams.unpublish', $exam) }}" method="POST" class="inline">@csrf<button type="submit" class="text-yellow-600 hover:text-yellow-800 dark:text-yellow-400 dark:hover:text-yellow-300">Unpublish</button></form>
                                        @endif
                                        <a href="{{ route('partner.exams.results', $exam) }}" class="text-indigo-600 hover:text-indigo-800 dark:text-indigo-400 dark:hover:text-indigo-300">Results</a>
                                        <a href="{{ route('partner.exams.export', $exam) }}" class="text-teal-600 hover:text-teal-800 dark:text-teal-400 dark:hover:text-teal-300">Export</a>
                                        <form action="{{ route('partner.exams.destroy', $exam) }}" method="POST" class="inline">@csrf @method('DELETE')<button type="submit" class="text-red-600 hover:text-red-800 dark:text-red-400 dark:hover:text-red-300" onclick="return confirm('Are you sure you want to delete this exam?')">Delete</button></form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            <!-- Pagination -->
            <div class="p-6 border-t border-gray-200 dark:border-gray-700">
                {{ $exams->links() }}
            </div>
        @else
            <div class="p-6">
                <div class="mb-4 text-sm text-gray-600 dark:text-gray-300">
                    No exams found. Here's a demo of how your exams will look:
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                        <thead class="bg-gray-50 dark:bg-gray-700/50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">ID</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Title</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Question Set</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Duration</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Window</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-3"></th>
                            </tr>
                        </thead>
                        <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">#201</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-gray-100">
                                    SSC Physics Mock Exam
                                    <div class="text-xs text-gray-500 dark:text-gray-400">Passing: 60% · Mixed difficulty physics topics</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700 dark:text-gray-200">Demo Set: Physics Mock Test</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700 dark:text-gray-200">60 min</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700 dark:text-gray-200">Aug 25, 10:00 – Aug 25, 11:00</td>
                                <td class="px-6 py-4 whitespace-nowrap"><span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">Published</span></td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm"><span class="text-gray-400">View · Edit · Results · Export · Delete</span></td>
                            </tr>
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">#202</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-gray-100">
                                    English Grammar Weekly Test
                                    <div class="text-xs text-gray-500 dark:text-gray-400">Passing: 50% · Identify parts of speech and tenses</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700 dark:text-gray-200">Demo Set: English Grammar</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700 dark:text-gray-200">45 min</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700 dark:text-gray-200">Aug 26, 16:00 – Aug 26, 16:45</td>
                                <td class="px-6 py-4 whitespace-nowrap"><span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">Draft</span></td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm"><span class="text-gray-400">View · Edit · Publish · Delete</span></td>
                            </tr>
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">#203</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-gray-100">
                                    Bangladesh Affairs Quiz
                                    <div class="text-xs text-gray-500 dark:text-gray-400">Passing: 70% · History, culture and current affairs</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700 dark:text-gray-200">Demo Set: Bangladesh Affairs</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700 dark:text-gray-200">50 min</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700 dark:text-gray-200">Aug 27, 09:00 – Aug 27, 09:50</td>
                                <td class="px-6 py-4 whitespace-nowrap"><span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">Ongoing</span></td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm"><span class="text-gray-400">View · Results</span></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="mt-6">
                    <a href="{{ route('partner.exams.create') }}" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-primaryGreen hover:bg-green-600">Create Your First Exam</a>
                </div>
            </div>
        @endif
    </div>
</div>
@endsection 
