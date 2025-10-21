<?php

if (!function_exists('storage_url')) {
    /**
     * Generate a URL for a file stored in the public disk.
     * This helper provides backward compatibility for both
     * old (storage/app/public) and new (public/uploads) storage paths.
     *
     * @param string|null $path
     * @return string
     */
    function storage_url($path)
    {
        if (empty($path)) {
            return '';
        }

        // Use Storage facade to get the correct URL based on configuration
        return \Illuminate\Support\Facades\Storage::disk('public')->url($path);
    }
}

if (!function_exists('storage_asset')) {
    /**
     * Legacy helper for backward compatibility.
     * Converts old asset('storage/...') calls to work with new structure.
     *
     * @param string|null $path
     * @return string
     */
    function storage_asset($path)
    {
        if (empty($path)) {
            return '';
        }

        // Remove 'storage/' prefix if present (legacy format)
        $cleanPath = str_replace('storage/', '', $path);
        
        return storage_url($cleanPath);
    }
}

