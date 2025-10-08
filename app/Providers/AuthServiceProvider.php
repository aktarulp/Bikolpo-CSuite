<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Laravel\Sanctum\Sanctum;
use App\Models\EnhancedUser;
use App\Policies\EnhancedUserPolicy;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     * Policies disabled - no policy enforcement.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // EnhancedUser::class => EnhancedUserPolicy::class,
    ];

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
        // Policies disabled
        // $this->registerPolicies();

        Sanctum::usePersonalAccessTokenModel(
            \App\Models\PersonalAccessToken::class
        );

        // Grant full access to all authenticated users - no permission checking
        Gate::before(function ($user, $ability) {
            // Always allow access for authenticated users
            return $user ? true : null;
        });
    }
}
