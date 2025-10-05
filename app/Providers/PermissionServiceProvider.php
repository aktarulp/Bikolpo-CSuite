<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Blade;
use App\Models\EnhancedUser;
use App\Models\EnhancedRole;
use App\Models\EnhancedPermission;

class PermissionServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        // Define custom gates for permission checking
        Gate::define('permission', function (EnhancedUser $user, string $permission) {
            return $this->userHasPermission($user, $permission);
        });

        Gate::define('role', function (EnhancedUser $user, string $role) {
            return $this->userHasRole($user, $role);
        });

        // Register custom Blade directives
        Blade::directive('can', function ($expression) {
            return "<?php if (auth()->check() && auth()->user()->can({$expression})): ?>";
        });

        Blade::directive('endcan', function () {
            return '<?php endif; ?>';
        });

        Blade::directive('canany', function ($expression) {
            return "<?php if (auth()->check() && auth()->user()->canAny({$expression})): ?>";
        });

        Blade::directive('endcanany', function () {
            return '<?php endif; ?>';
        });

        Blade::directive('hasrole', function ($expression) {
            return "<?php if (auth()->check() && auth()->user()->hasRole({$expression})): ?>";
        });

        Blade::directive('endhasrole', function () {
            return '<?php endif; ?>';
        });

        Blade::directive('hasanyrole', function ($expression) {
            return "<?php if (auth()->check() && auth()->user()->hasAnyRole({$expression})): ?>";
        });

        Blade::directive('endhasanyrole', function () {
            return '<?php endif; ?>';
        });
    }

    /**
     * Check if user has a specific permission
     * Note: Direct user permissions have been removed. We now rely solely on role-based permissions.
     */
    private function userHasPermission(EnhancedUser $user, string $permission): bool
    {
        // Check role-based permissions only
        return $user->roles()
            ->whereHas('permissions', function ($query) use ($permission) {
                $query->where('module_name', $permission)->orWhere('name', $permission);
            })
            ->exists();
    }

    /**
     * Check if user has a specific role
     */
    private function userHasRole(EnhancedUser $user, string $role): bool
    {
        return $user->roles()->where('name', $role)->exists();
    }
}
