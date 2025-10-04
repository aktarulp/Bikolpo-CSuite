<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleOrPermission
{
    /**
     * Handle an incoming request.
     * Accepts items separated by | or , which may be role names or permission names.
     * Grants access if the user has ANY of the roles OR ANY of the permissions.
     */
    public function handle(Request $request, Closure $next, string ...$items): Response
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        $user = auth()->user();

        // Parse items
        $list = [];
        foreach ($items as $arg) {
            foreach (preg_split('/[|,]/', $arg) as $part) {
                $part = trim($part);
                if ($part !== '') {
                    $list[] = $part;
                }
            }
        }
        $list = array_values(array_unique($list));

        if (empty($list)) {
            return $next($request);
        }

        // Role alias normalization (reuse the mapping from CheckRole)
        $aliasMap = [
            'partner_admin' => 'partner',
            'institution_admin' => 'partner',
            'instructor' => 'teacher',
            'learner' => 'student',
            'system' => 'system_administrator',
        ];

        $normalizedRoles = array_map(fn($name) => $aliasMap[strtolower($name)] ?? strtolower($name), $list);

        // Check roles first
        $hasRole = $user->roles()->whereIn('name', $normalizedRoles)->exists();
        if ($hasRole) {
            return $next($request);
        }

        // Check permissions via roles
        foreach ($user->roles as $role) {
            foreach ($list as $permName) {
                if ($role->hasPermission($permName)) {
                    return $next($request);
                }
            }
        }

        \Log::warning('RBAC role_or_permission denied', [
            'user_id' => $user->id,
            'user_roles' => $user->roles()->pluck('name')->toArray(),
            'required' => $list,
            'url' => $request->url(),
        ]);

        abort(403, 'Insufficient role or permission');
    }
}
