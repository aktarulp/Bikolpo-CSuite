<div class="footer" style="grid-column: {{ $footerSpan }}; margin-top: 40px; text-align: center; font-size: {{ $fontSize - 2 }}pt; color: #666; border-top: 1px solid #ccc; padding-top: 20px;">
    <p>Generated on: {{ now()->format('F j, Y H:i') }}</p>
    <p>Total Questions: {{ $exam->questions->count() }} | Total Marks: {{ $totalMarks }}</p>
</div>
