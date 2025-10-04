<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        $user = auth()->user();

        // Flatten role parameters: supports comma or pipe separated lists
        $required = [];
        foreach ($roles as $r) {
            foreach (preg_split('/[|,]/', $r) as $part) {
                $part = trim(strtolower($part));
                if ($part !== '') {
                    $required[] = $part;
                }
            }
        }
        $required = array_values(array_unique($required));

        // Map common aliases to canonical role names if you use them in ac_roles
        $aliasMap = [
            'partner_admin' => 'partner',
            'institution_admin' => 'partner',
            'instructor' => 'teacher',
            'learner' => 'student',
            'system' => 'system_administrator',
        ];
        $normalizedRequired = array_map(function ($name) use ($aliasMap) {
            return $aliasMap[$name] ?? $name;
        }, $required);

        // Check via ac_user_roles pivot (EnhancedUser/User -> roles relation)
        $hasRole = $user->roles()->whereIn('name', $normalizedRequired)->exists();

        // Legacy string role fallback (for users not yet assigned via pivot)
        if (!$hasRole) {
            $stringRole = strtolower($user->role ?? '');
            $stringRole = $aliasMap[$stringRole] ?? $stringRole;
            if ($stringRole !== '' && in_array($stringRole, $normalizedRequired, true)) {
                $hasRole = true;
            }
        }

        if (!$hasRole) {
            \Log::warning('RBAC role denied', [
                'user_id' => $user->id,
                'user_roles' => $user->roles()->pluck('name')->toArray(),
                'user_string_role' => $user->role ?? null,
                'required' => $normalizedRequired,
                'url' => $request->url(),
            ]);

            // Avoid loops: show 403 or send to neutral landing
            if (function_exists('abort')) {
                return abort(403, 'Insufficient role');
            }
            return redirect()->route('landing');
        }

        return $next($request);
    }
}
