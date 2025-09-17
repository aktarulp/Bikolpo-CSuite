<?php

namespace App\Services;

use App\Models\Exam;
use Illuminate\Support\Facades\View;
use Spatie\Browsershot\Browsershot;

class PdfGeneratorService
{
    /**
     * Generate a PDF for an exam paper.
     *
     * @param Exam $exam
     * @param array $params
     * @return string The PDF content
     */
    public function generateExamPaperPdf(Exam $exam, array $params): string
    {
        $html = View::make('partner.exams.paper-preview', compact('exam', 'params'))->render();

        $pdf = Browsershot::html($html)
            ->showBackground();

        // Apply paper settings if available
        if (isset($params['paper_size'])) {
            // Browsershot uses different paper size definitions (e.g., A4, Letter, etc.)
            // and custom dimensions (width, height in mm)
            // We need to map our paper_size and orientation to Browsershot's methods
            $paperSize = $params['paper_size'];
            $orientation = $params['orientation'] ?? 'portrait';

            if (in_array($paperSize, ['A4', 'Letter', 'Legal'])) {
                $pdf->format($paperSize);
            }

            if ($orientation === 'landscape') {
                $pdf->landscape();
            }
            
            // Set margins
            $pdf->setMargins(
                $params['margin_top'] ?? 0,
                $params['margin_right'] ?? 0,
                $params['margin_bottom'] ?? 0,
                $params['margin_left'] ?? 0
            );
        }

        return $pdf->pdf();
    }

    // Additional PDF generation methods can be added here
}
