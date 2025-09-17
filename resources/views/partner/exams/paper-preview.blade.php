@php
    $params = $params ?? [];
    $paperColumns = $paperColumns ?? 1;
    $headerSpan = $headerSpan ?? 'full';
    $fontSize = $fontSize ?? 12;
    $mcqColumns = $mcqColumns ?? 2;
@endphp
@php
    // compute margin styles in mm for preview
    $mt = $params['margin_top'] ?? 20;
    $mr = $params['margin_right'] ?? 20;
    $mb = $params['margin_bottom'] ?? 20;
    $ml = $params['margin_left'] ?? 20;
    $scale = (($params['adjust_to_percentage'] ?? 100) / 100);
    $paperSizeClass = 'preview-' . strtolower($params['paper_size'] ?? 'a4') . (($params['orientation'] ?? 'portrait') === 'landscape' ? '-landscape' : '');
    $totalQuestions = $exam->questions->count();
    $questionsPerColumn = App\Helpers\ExamPaperHelper::calculateQuestionsPerColumn($totalQuestions, $paperColumns, $params);
    $questionsPerPage = max(1, $paperColumns * max(1, $questionsPerColumn));
    $totalPages = (int) ceil($totalQuestions / $questionsPerPage);
@endphp

<div id="paperPreviewRoot" class="preview-root {{ $paperSizeClass }}" data-header-span="{{ $headerSpan }}" data-orientation="{{ $params['orientation'] ?? 'portrait' }}" data-paper-size="{{ $params['paper_size'] ?? 'A4' }}" style="font-family: '{{ $params['font_family'] ?? 'Arial' }}'; font-size: {{ $fontSize }}pt; line-height: {{ $params['line_spacing'] ?? 1.5 }}; transform: scale({{ $scale }}); transform-origin: top left; --margin-top: {{ $mt }}mm; --margin-right: {{ $mr }}mm; --margin-bottom: {{ $mb }}mm; --margin-left: {{ $ml }}mm;">
    @if(($params['include_header'] ?? true) !== false)
        @php
            $totalMarks = $exam->questions->reduce(fn($sum, $q) => $sum + (int)($q->pivot->marks ?? 1), 0);
            $headerGridSpan = ($paperColumns > 1) ? '1 / -1' : '';
        @endphp
        <x-exam.paper-header :exam="$exam" :totalMarks="$totalMarks" :fontSize="$fontSize" :headerGridSpan="$headerGridSpan"/>
    @endif

    @php
        $questionIndex = 0;
    @endphp

    @if($paperColumns > 1)
        @php
            // Multi-column layout: fill first column completely, then second column, etc.
            $questionsPerColumn = App\Helpers\ExamPaperHelper::calculateQuestionsPerColumn($exam->questions->count(), $paperColumns, $params);
        @endphp
        @for($columnIndex = 0; $columnIndex < $paperColumns; $columnIndex++)
            @php
                $questionsInThisColumn = min($questionsPerColumn, $exam->questions->count() - $questionIndex);
            @endphp
            @if($questionsInThisColumn > 0)
                <div class="question-column" data-column="{{ $columnIndex + 1 }}">
                    @for($i = 0; $i < $questionsInThisColumn && $questionIndex < $exam->questions->count(); $i++)
                        @php
                            $question = $exam->questions[$questionIndex];
                            $questionNumber = $questionIndex + 1;
                            $marks = (int)($question->pivot->marks ?? 1);
                        @endphp
                        @php
                            // ensure mcq columns propagate into params for the component
                            $paramsForQuestion = $params;
                            $paramsForQuestion['mcq_columns'] = $mcqColumns;
                        @endphp
                        <x-exam.paper-question :question="$question" :questionNumber="$questionNumber" :marks="$marks" :params="$paramsForQuestion" :mcqColumns="$mcqColumns" :markAnswer="$params['mark_answer'] ?? false"/>
                        @php $questionIndex++; @endphp
                    @endfor
                </div>
            @endif
            @if($questionIndex >= $exam->questions->count())
                @break
            @endif
        @endfor
    @else
        {{-- Single column layout: add questions sequentially --}}
        @foreach($exam->questions as $index => $question)
            @php
                $questionNumber = $index + 1;
                $marks = (int)($question->pivot->marks ?? 1);
            @endphp
            <x-exam.paper-question :question="$question" :questionNumber="$questionNumber" :marks="$marks" :params="$params" :mcqColumns="$mcqColumns" :markAnswer="$params['mark_answer'] ?? false"/>
        @endforeach
    @endif

    @for($page = 0; $page < $totalPages; $page++)
        @php
            $startIndex = $page * $questionsPerPage;
            $endIndex = min($startIndex + $questionsPerPage, $totalQuestions);
        @endphp
        <div class="page-container {{ $paperSizeClass }}" data-page-number="{{ $page + 1 }}">
            <div class="paper-container paper-columns-{{ $paperColumns }}" style="padding-top: calc(var(--margin-top)); padding-right: calc(var(--margin-right)); padding-bottom: calc(var(--margin-bottom)); padding-left: calc(var(--margin-left));">
                @if(($params['include_header'] ?? true) !== false)
                    @php
                        $totalMarks = $exam->questions->reduce(fn($sum, $q) => $sum + (int)($q->pivot->marks ?? 1), 0);
                        $headerGridSpan = ($paperColumns > 1) ? '1 / -1' : '';
                    @endphp
                    <x-exam.paper-header :exam="$exam" :totalMarks="$totalMarks" :fontSize="$fontSize" :headerGridSpan="$headerGridSpan"/>
                @endif

                @php $questionIndex = $startIndex; @endphp

                @if($paperColumns > 1)
                    @for($columnIndex = 0; $columnIndex < $paperColumns; $columnIndex++)
                        <div class="question-column" data-column="{{ $columnIndex + 1 }}">
                            @for($i = 0; $i < $questionsPerColumn && $questionIndex < $endIndex; $i++)
                                @php
                                    $question = $exam->questions[$questionIndex];
                                    $questionNumber = $questionIndex + 1;
                                    $marks = (int)($question->pivot->marks ?? 1);
                                    $paramsForQuestion = $params;
                                    $paramsForQuestion['mcq_columns'] = $mcqColumns;
                                @endphp
                                <x-exam.paper-question :question="$question" :questionNumber="$questionNumber" :marks="$marks" :params="$paramsForQuestion" :mcqColumns="$mcqColumns" :markAnswer="$params['mark_answer'] ?? false"/>
                                @php $questionIndex++; @endphp
                            @endfor
                        </div>
                    @endfor
                @else
                    @while($questionIndex < $endIndex)
                        @php
                            $question = $exam->questions[$questionIndex];
                            $questionNumber = $questionIndex + 1;
                            $marks = (int)($question->pivot->marks ?? 1);
                            $paramsForQuestion = $params;
                            $paramsForQuestion['mcq_columns'] = $mcqColumns;
                        @endphp
                        <x-exam.paper-question :question="$question" :questionNumber="$questionNumber" :marks="$marks" :params="$paramsForQuestion" :mcqColumns="$mcqColumns" :markAnswer="$params['mark_answer'] ?? false"/>
                        @php $questionIndex++; @endphp
                    @endwhile
                @endif

                @if(($params['include_footer'] ?? true) !== false)
                    @php
                        $footerSpan = ($paperColumns > 1) ? '1 / -1' : '';
                        $totalMarks = $exam->questions->reduce(fn($sum, $q) => $sum + (int)($q->pivot->marks ?? 1), 0);
                    @endphp
                    <x-exam.paper-footer :exam="$exam" :totalMarks="$totalMarks" :fontSize="$fontSize" :footerSpan="$footerSpan"/>
                @endif
            </div>
        </div>
    @endfor
</div>

@include('partner.exams.paper-preview-script')
