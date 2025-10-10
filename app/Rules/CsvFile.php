<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Http\UploadedFile;

class CsvFile implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string, ?string=): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (!$value instanceof UploadedFile) {
            $fail('The :attribute must be a file.');
            return;
        }

        // Check file extension
        $extension = strtolower($value->getClientOriginalExtension());
        $allowedExtensions = ['csv', 'txt'];
        if (!in_array($extension, $allowedExtensions)) {
            $fail('The :attribute must be a file of type: csv, txt.');
            return;
        }

        // Check MIME type
        $mimeType = $value->getMimeType();
        $allowedMimeTypes = [
            'text/csv',
            'text/plain',
            'application/csv',
            'application/vnd.ms-excel',
            'text/x-csv',
            'application/x-csv'
        ];
        
        if (!in_array($mimeType, $allowedMimeTypes)) {
            // If MIME type check fails, still allow if extension is correct
            // This handles cases where the MIME type detection is not accurate
            if (!in_array($extension, $allowedExtensions)) {
                $fail('The :attribute must be a file of type: csv, txt.');
                return;
            }
        }

        // Check file size (2MB max)
        if ($value->getSize() > 2048 * 1024) {
            $fail('The :attribute may not be greater than 2048 kilobytes.');
            return;
        }
    }
}