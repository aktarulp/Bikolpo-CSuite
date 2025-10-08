<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class RequestTimingMiddleware
{
    /**
     * Handle an incoming request and log timing statistics in local/dev when enabled.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $enable = (bool) env('BKL_REQUEST_TIMING', true); // default on in local
        $thresholdMs = (int) env('BKL_TIMING_THRESHOLD_MS', 0);
        $withDb = (bool) env('BKL_TIMING_DB', true);

        $start = microtime(true);
        $dbCount = 0;
        $dbTime = 0.0;

        if ($enable && $withDb) {
            DB::connection()->enableQueryLog();
            DB::flushQueryLog();
        }

        /** @var Response $response */
        $response = $next($request);

        if ($enable) {
            $durationMs = (microtime(true) - $start) * 1000.0;
            if ($withDb) {
                $log = DB::getQueryLog();
                $dbCount = is_array($log) ? count($log) : 0;
                if (is_array($log)) {
                    foreach ($log as $entry) {
                        // Laravel reports time in milliseconds
                        $dbTime += isset($entry['time']) ? (float) $entry['time'] : 0.0;
                    }
                }
                DB::flushQueryLog();
                DB::disableQueryLog();
            }

            if ($durationMs >= $thresholdMs) {
                Log::info('http_timing', [
                    'method' => $request->getMethod(),
                    'path' => $request->getPathInfo(),
                    'status' => method_exists($response, 'getStatusCode') ? $response->getStatusCode() : null,
                    'duration_ms' => round($durationMs, 2),
                    'db_queries' => $dbCount,
                    'db_time_ms' => round($dbTime, 2),
                    'memory_peak_mb' => round(memory_get_peak_usage(true) / 1048576, 2),
                ]);
            }
        }

        return $response;
    }
}