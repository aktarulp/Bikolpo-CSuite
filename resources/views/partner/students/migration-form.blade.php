@extends('layouts.partner-layout')

@section('title', 'Student Migration')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900 dark:text-gray-100">
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-2xl font-bold">Student Migration</h2>
                    <a href="{{ route('partner.students.show', $student) }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                        Back to Student
                    </a>
                </div>

                <!-- Student Information -->
                <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg mb-6">
                    <h3 class="text-lg font-semibold mb-3">Student Information</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <p><strong>Name:</strong> {{ $student->full_name }}</p>
                            <p><strong>Student ID:</strong> {{ $student->student_id }}</p>
                            <p><strong>Email:</strong> {{ $student->email }}</p>
                        </div>
                        <div>
                            <p><strong>Current Course:</strong> {{ $student->course?->name ?? 'Not Assigned' }}</p>
                            <p><strong>Current Batch:</strong> {{ $student->batch?->name ?? 'Not Assigned' }}</p>
                            <p><strong>Enrolled:</strong> {{ $student->enroll_date ? $student->enroll_date->format('M d, Y') : 'Not Set' }}</p>
                        </div>
                    </div>
                </div>

                <!-- Migration Form -->
                <form id="migrationForm" class="space-y-6">
                    @csrf
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Course Selection -->
                        <div>
                            <label for="to_course_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                New Course (Optional)
                            </label>
                            <select id="to_course_id" name="to_course_id" class="w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                                <option value="">Keep Current Course</option>
                                @foreach($courses as $course)
                                    @if($course->id !== $student->course_id)
                                        <option value="{{ $course->id }}">
                                            {{ $course->name }} 
                                            @if($course->start_date && $course->end_date)
                                                ({{ $course->start_date->format('M d') }} - {{ $course->end_date->format('M d, Y') }})
                                            @endif
                                        </option>
                                    @endif
                                @endforeach
                            </select>
                        </div>

                        <!-- Batch Selection -->
                        <div>
                            <label for="to_batch_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                New Batch (Optional)
                            </label>
                            <select id="to_batch_id" name="to_batch_id" class="w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                                <option value="">Keep Current Batch</option>
                                @foreach($batches as $batch)
                                    @if($batch->id !== $student->batch_id)
                                        <option value="{{ $batch->id }}">
                                            {{ $batch->name }} ({{ $batch->year }})
                                            @if($batch->start_date && $batch->end_date)
                                                - {{ $batch->start_date->format('M d') }} to {{ $batch->end_date->format('M d, Y') }}
                                            @endif
                                        </option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <!-- Reason -->
                    <div>
                        <label for="reason" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Migration Reason <span class="text-red-500">*</span>
                        </label>
                        <textarea id="reason" name="reason" rows="3" required class="w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500" placeholder="Please provide a reason for this migration..."></textarea>
                    </div>

                    <!-- Notes -->
                    <div>
                        <label for="notes" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Additional Notes (Optional)
                        </label>
                        <textarea id="notes" name="notes" rows="2" class="w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500" placeholder="Any additional notes..."></textarea>
                    </div>

                    <!-- Submit Button -->
                    <div class="flex justify-end">
                        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded-lg transition duration-200">
                            Process Migration
                        </button>
                    </div>
                </form>

                <!-- Migration History -->
                @if($migrationHistory->count() > 0)
                <div class="mt-8">
                    <h3 class="text-lg font-semibold mb-4">Migration History</h3>
                    <div class="overflow-x-auto">
                        <table class="min-w-full bg-white dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-lg">
                            <thead class="bg-gray-50 dark:bg-gray-600">
                                <tr>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Date</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">From</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">To</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Reason</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Status</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 dark:divide-gray-600">
                                @foreach($migrationHistory as $migration)
                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-600">
                                    <td class="px-4 py-3 text-sm text-gray-900 dark:text-gray-100">
                                        {{ $migration->migration_date->format('M d, Y') }}
                                    </td>
                                    <td class="px-4 py-3 text-sm text-gray-900 dark:text-gray-100">
                                        @if($migration->fromCourse)
                                            {{ $migration->fromCourse->name }}
                                        @endif
                                        @if($migration->fromBatch)
                                            <br><span class="text-xs text-gray-500">{{ $migration->fromBatch->name }}</span>
                                        @endif
                                    </td>
                                    <td class="px-4 py-3 text-sm text-gray-900 dark:text-gray-100">
                                        @if($migration->toCourse)
                                            {{ $migration->toCourse->name }}
                                        @endif
                                        @if($migration->toBatch)
                                            <br><span class="text-xs text-gray-500">{{ $migration->toBatch->name }}</span>
                                        @endif
                                    </td>
                                    <td class="px-4 py-3 text-sm text-gray-900 dark:text-gray-100">
                                        {{ Str::limit($migration->reason, 50) }}
                                    </td>
                                    <td class="px-4 py-3 text-sm">
                                        <span class="px-2 py-1 text-xs font-medium rounded-full 
                                            @if($migration->status === 'completed') bg-green-100 text-green-800 
                                            @elseif($migration->status === 'pending') bg-yellow-100 text-yellow-800 
                                            @else bg-red-100 text-red-800 @endif">
                                            {{ ucfirst($migration->status) }}
                                        </span>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

<script>
document.getElementById('migrationForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    if (!confirm('Are you sure you want to process this migration? This action cannot be undone.')) {
        return;
    }
    
    const formData = new FormData(this);
    
    fetch('{{ route("partner.students.migrate.process", $student) }}', {
        method: 'POST',
        body: formData,
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('Migration completed successfully!');
            window.location.reload();
        } else {
            alert('Error: ' + data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('An error occurred while processing the migration.');
    });
});
</script>
@endsection
