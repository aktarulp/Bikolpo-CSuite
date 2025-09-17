<div class="header-container" style="grid-column: {{ $headerGridSpan }}; text-align: center; border-bottom: 2px solid #333; padding-bottom: 15px; margin-bottom: 20px;">
    <div class="exam-title" style="font-size: {{ $fontSize + 8 }}pt; font-weight: bold; margin-bottom: 10px;">{{ $exam->title }}</div>
    <div class="exam-info" style="font-size: {{ $fontSize - 2 }}pt; color: #666;">
        <strong>Exam ID:</strong> {{ $exam->id }} |
        <strong>Duration:</strong> {{ $exam->duration }} minutes |
        <strong>Total Questions:</strong> {{ $exam->total_questions }} |
        <strong>Passing Marks:</strong> {{ $exam->passing_marks }}% |
        <strong>Total Marks:</strong> {{ $totalMarks }}
    </div>
    @if($exam->question_header)
        <div class="question-header" style="margin-top: 15px; padding: 15px; background: #f9f9f9; border-radius: 5px;">{{ $exam->question_header }}</div>
    @endif
</div>
