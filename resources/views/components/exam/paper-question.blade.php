<div class="question" style="margin-bottom: 10px; page-break-inside: avoid; break-inside: avoid;">
    <div class="question-number" style="font-weight: bold; color: #333;">
        Question {{ $questionNumber }} <span class="marks" style="font-weight: bold; color: #333; float: right;">[{{ $marks }} mark{{ $marks > 1 ? 's' : '' }}]</span>
    </div>

    @if($question->question_header)
        <div class="question-header" style="margin: 5px 0; font-style: italic; color: #666;">{{ $question->question_header }}</div>
    @endif

    <div class="question-text" style="margin: 5px 0;">{{ Str::replaceMatches('/\(Question\s*#\d+\)/i', '', $question->question_text) }}</div>

    @if($question->question_type === 'mcq')
        <div class="mcq-options columns-{{ $mcqColumns }}" style="display: grid; gap: 10px; margin: 5px 0; grid-template-columns: repeat({{ $mcqColumns }}, 1fr);">
            @php
                $options = collect([
                    ['label' => 'A', 'text' => $question->option_a],
                    ['label' => 'B', 'text' => $question->option_b],
                    ['label' => 'C', 'text' => $question->option_c],
                    ['label' => 'D', 'text' => $question->option_d]
                ])->filter(fn($opt) => $opt['text']);
            @endphp

            @foreach($options as $option)
                @php
                    $isCorrect = false;
                    if ($markAnswer && $question->correct_answer) {
                        if (is_string($question->correct_answer)) {
                            $isCorrect = $option['label'] === strtoupper($question->correct_answer);
                        } elseif (is_numeric($question->correct_answer)) {
                            $answerMap = [1 => 'A', 2 => 'B', 3 => 'C', 4 => 'D'];
                            $isCorrect = $option['label'] === $answerMap[$question->correct_answer];
                        }
                    }
                    $optionStyle = $isCorrect ? ' style="background-color: #e8f5e8; border-left: 4px solid #28a745; padding-left: 10px;"' : '';
                    $correctIndicator = $isCorrect ? ' <strong style="color: #28a745;">✓</strong>' : '';
                @endphp
                <div class="option" style="margin: 5px 0;"{!! $optionStyle !!}>{{ $option['label'] }}) {{ $option['text'] }}{!! $correctIndicator !!}</div>
            @endforeach
        </div>
    @endif
</div>
