@extends('layouts.partner-layout')

@section('title', 'Add Question History')

@section('content')
<div class="py-12">
    <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900">
                <!-- Header -->
                <div class="mb-6">
                    <h2 class="text-2xl font-bold text-gray-900">Add Question History Record</h2>
                    <p class="text-gray-600 mt-2">Record the history of a question appearing in public exams</p>
                </div>

                <!-- Form -->
                <form id="questionHistoryForm" class="space-y-6">
                    @csrf
                    
                    <!-- Question and Partner Selection -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="question_id" class="block text-sm font-medium text-gray-700 mb-2">
                                Select Question <span class="text-red-500">*</span>
                            </label>
                            <select id="question_id" name="question_id" required 
                                    class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                <option value="">Choose a question...</option>
                                @foreach($questions as $question)
                                    <option value="{{ $question->id }}" 
                                            data-subject="{{ $question->subject?->name ?? '' }}"
                                            data-topic="{{ $question->topic?->name ?? '' }}">
                                        {{ Str::limit($question->question_text, 100) }} (ID: {{ $question->id }})
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        
                        <div>
                            <label for="partner_id" class="block text-sm font-medium text-gray-700 mb-2">
                                Select Partner <span class="text-red-500">*</span>
                            </label>
                            <select id="partner_id" name="partner_id" required 
                                    class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                <option value="">Choose a partner...</option>
                                @foreach($partners as $partner)
                                    <option value="{{ $partner->id }}">
                                        {{ $partner->name ?? $partner->email }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <!-- Exam Details -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="public_exam_name" class="block text-sm font-medium text-gray-700 mb-2">
                                Public Exam Name <span class="text-red-500">*</span>
                            </label>
                            <input type="text" id="public_exam_name" name="public_exam_name" required
                                   placeholder="e.g., CBSE Class 10 Board Exam"
                                   class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        </div>
                        
                        <div>
                            <label for="private_exam_name" class="block text-sm font-medium text-gray-700 mb-2">
                                Private Exam Name
                            </label>
                            <input type="text" id="private_exam_name" name="private_exam_name"
                                   placeholder="e.g., Internal Assessment Test"
                                   class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="exam_month" class="block text-sm font-medium text-gray-700 mb-2">
                                Exam Month <span class="text-red-500">*</span>
                            </label>
                            <select id="exam_month" name="exam_month" required
                                    class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                <option value="">Select Month</option>
                                <option value="January">January</option>
                                <option value="February">February</option>
                                <option value="March">March</option>
                                <option value="April">April</option>
                                <option value="May">May</option>
                                <option value="June">June</option>
                                <option value="July">July</option>
                                <option value="August">August</option>
                                <option value="September">September</option>
                                <option value="October">October</option>
                                <option value="November">November</option>
                                <option value="December">December</option>
                            </select>
                        </div>
                        
                        <div>
                            <label for="exam_year" class="block text-sm font-medium text-gray-700 mb-2">
                                Exam Year <span class="text-red-500">*</span>
                            </label>
                            <input type="number" id="exam_year" name="exam_year" required min="1900" max="{{ date('Y') + 5 }}"
                                   value="{{ date('Y') }}"
                                   class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="exam_board" class="block text-sm font-medium text-gray-700 mb-2">
                                Exam Board
                            </label>
                            <input type="text" id="exam_board" name="exam_board"
                                   placeholder="e.g., CBSE, ICSE, State Board"
                                   class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        </div>
                        
                        <div>
                            <label for="exam_type" class="block text-sm font-medium text-gray-700 mb-2">
                                Exam Type
                            </label>
                            <select id="exam_type" name="exam_type"
                                    class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                <option value="">Select Type</option>
                                <option value="Board Exam">Board Exam</option>
                                <option value="Competitive Exam">Competitive Exam</option>
                                <option value="Entrance Exam">Entrance Exam</option>
                                <option value="Professional Exam">Professional Exam</option>
                                <option value="Government Exam">Government Exam</option>
                            </select>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="question_number" class="block text-sm font-medium text-gray-700 mb-2">
                                Question Number
                            </label>
                            <input type="number" id="question_number" name="question_number" min="1"
                                   placeholder="e.g., 15"
                                   class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        </div>
                        
                        <div>
                            <label for="marks_allocated" class="block text-sm font-medium text-gray-700 mb-2">
                                Marks Allocated
                            </label>
                            <input type="number" id="marks_allocated" name="marks_allocated" min="1"
                                   placeholder="e.g., 2"
                                   class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        </div>
                    </div>



                    <!-- Auto-populated fields -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="subject_name" class="block text-sm font-medium text-gray-700 mb-2">
                                Subject Name
                            </label>
                            <input type="text" id="subject_name" name="subject_name" readonly
                                   class="w-full border-gray-300 rounded-md shadow-sm bg-gray-50">
                        </div>
                        
                        <div>
                            <label for="topic_name" class="block text-sm font-medium text-gray-700 mb-2">
                                Topic Name
                            </label>
                            <input type="text" id="topic_name" name="topic_name" readonly
                                   class="w-full border-gray-300 rounded-md shadow-sm bg-gray-50">
                        </div>
                    </div>

                    <div>
                        <label for="source_reference" class="block text-sm font-medium text-gray-700 mb-2">
                            Source Reference
                        </label>
                        <input type="text" id="source_reference" name="source_reference"
                               placeholder="e.g., Previous Year Question Papers, Sample Papers"
                               class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    </div>

                    <div>
                        <label for="remarks" class="block text-sm font-medium text-gray-700 mb-2">
                            Remarks
                        </label>
                        <textarea id="remarks" name="remarks" rows="3"
                                  placeholder="Additional notes about this question's appearance in the exam..."
                                  class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500"></textarea>
                    </div>

                    <!-- Verification -->
                    <div class="flex items-center space-x-4">
                        <input type="checkbox" id="is_verified" name="is_verified" value="1"
                               class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        <label for="is_verified" class="text-sm font-medium text-gray-700">
                            Mark as Verified
                        </label>
                    </div>

                    <div id="verificationFields" class="hidden space-y-4">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="verified_by" class="block text-sm font-medium text-gray-700 mb-2">
                                    Verified By
                                </label>
                                <input type="text" id="verified_by" name="verified_by"
                                       placeholder="Your name or identifier"
                                       class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            </div>
                        </div>
                    </div>

                    <!-- Submit Buttons -->
                    <div class="flex justify-end space-x-3 pt-6 border-t border-gray-200">
                        <a href="{{ route('partner.question-history.index') }}" 
                           class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-md">
                            Cancel
                        </a>
                        <button type="submit" 
                                class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-md">
                            Create Record
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const questionSelect = document.getElementById('question_id');
    const subjectInput = document.getElementById('subject_name');
    const topicInput = document.getElementById('topic_name');
    const isVerifiedCheckbox = document.getElementById('is_verified');
    const verificationFields = document.getElementById('verificationFields');
    const form = document.getElementById('questionHistoryForm');

    // Auto-populate subject and topic when question is selected
    questionSelect.addEventListener('change', function() {
        const selectedOption = this.options[this.selectedIndex];
        if (selectedOption.value) {
            subjectInput.value = selectedOption.dataset.subject || '';
            topicInput.value = selectedOption.dataset.topic || '';
        } else {
            subjectInput.value = '';
            topicInput.value = '';
        }
    });

    // Show/hide verification fields
    isVerifiedCheckbox.addEventListener('change', function() {
        verificationFields.classList.toggle('hidden', !this.checked);
    });

    // Form submission
    form.addEventListener('submit', function(e) {
        e.preventDefault();
        
        const formData = new FormData(form);
        
        fetch('{{ route("partner.question-history.store") }}', {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
                'Accept': 'application/json',
                'Content-Type': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert(data.message);
                window.location.href = '{{ route("partner.question-history.index") }}';
            } else {
                alert('Error: ' + data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('An error occurred while creating the record.');
        });
    });
});
</script>
@endsection
