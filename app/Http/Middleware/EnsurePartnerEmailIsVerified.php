<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Symfony\Component\HttpFoundation\Response;

class EnsurePartnerEmailIsVerified
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!$request->user() ||
            ($request->user()->role === 'partner' && !$request->user()->hasVerifiedEmail())) {
            return $request->expectsJson()
                ? abort(403, 'Your email address is not verified.')
                : Redirect::route('partner.verification.notice');
        }

        return $next($request);
    }
}
