<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckPermission
{
    /**
     * Handle an incoming request.
     * Accepts permissions separated by pipe (|) or comma (,).
     * Grant access if the user has ANY of the listed permissions via their roles.
     */
    public function handle(Request $request, Closure $next, string ...$permissions): Response
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        $user = auth()->user();

        // Parse permission arguments (support multiple, with | or , separators)
        $requested = [];
        foreach ($permissions as $p) {
            foreach (preg_split('/[|,]/', $p) as $part) {
                $part = trim($part);
                if ($part !== '') {
                    $requested[] = $part;
                }
            }
        }
        $requested = array_values(array_unique($requested));

        if (empty($requested)) {
            return $next($request);
        }

        // Check through role-based permissions only
        $hasAny = false;
        foreach ($user->roles as $role) {
            foreach ($requested as $permName) {
                if ($role->hasPermission($permName)) {
                    $hasAny = true;
                    break 2;
                }
            }
        }

        if (!$hasAny) {
            \Log::warning('RBAC permission denied', [
                'user_id' => $user->id,
                'user_roles' => $user->roles()->pluck('name')->toArray(),
                'required_permissions' => $requested,
                'url' => $request->url(),
            ]);

            // 403 Forbidden, or redirect. Use 403 to make it explicit.
            abort(403, 'Insufficient permissions');
        }

        return $next($request);
    }
}
