<?php

namespace App\Helpers;

class ExamPaperHelper
{
    public static function calculateQuestionsPerColumn(int $totalQuestions, int $paperColumns, array $params): int
    {
        $paperSize = $params['paper_size'] ?? 'A4';
        $orientation = $params['orientation'] ?? 'portrait';
        $fontSize = (int)($params['font_size'] ?? 12);
        $lineSpacing = (float)($params['line_spacing'] ?? 1.5);

        // Paper height in mm (approximate)
        $paperHeights = [
            'A4' => $orientation === 'landscape' ? 210 : 297,
            'Letter' => $orientation === 'landscape' ? 216 : 279,
            'Legal' => $orientation === 'landscape' ? 216 : 356,
        ];

        $paperHeight = $paperHeights[$paperSize] ?? 297;

        // Calculate available height (subtract margins and header space)
        $marginTop = (int)($params['margin_top'] ?? 0);
        $marginBottom = (int)($params['margin_bottom'] ?? 0);
        $headerHeight = (($params['include_header'] ?? true) !== false) ? 40 : 0; // Approximate header height in mm

        $availableHeight = $paperHeight - $marginTop - $marginBottom - $headerHeight - 40; // 40mm padding

        // Estimate question height based on font size and line spacing
        // Average question takes about 4-6 lines depending on complexity
        $averageLinesPerQuestion = 5;
        $lineHeightMm = ($fontSize * $lineSpacing * 0.35); // Convert pt to mm approximately
        $questionHeightMm = $lineHeightMm * $averageLinesPerQuestion + 5; // 5mm spacing between questions

        // Calculate maximum questions that can fit in one column
        $maxQuestionsPerColumn = (int) floor($availableHeight / $questionHeightMm);

        // Ensure we don't have empty columns by distributing evenly with a minimum
        $questionsPerColumn = max(
            $maxQuestionsPerColumn,
            (int) ceil($totalQuestions / $paperColumns)
        );

        // But don't exceed what can physically fit
        $questionsPerColumn = min($questionsPerColumn, $maxQuestionsPerColumn ?: 20);

        // Ensure minimum of 5 questions per column if we have questions
        if ($totalQuestions > 0) {
            $questionsPerColumn = max($questionsPerColumn, 5);
        }

        return $questionsPerColumn;
    }
}
