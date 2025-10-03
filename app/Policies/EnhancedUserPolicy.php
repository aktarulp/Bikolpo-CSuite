<?php

namespace App\Policies;

use App\Models\User;
use App\Models\EnhancedUser;
use Illuminate\Auth\Access\HandlesAuthorization;

class EnhancedUserPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any users.
     */
    public function viewAny(User $user)
    {
        // Allow if user is System Administrator or Partner Admin
        return $user->isSystemAdministrator() || $user->isPartnerAdmin();
    }

    /**
     * Determine whether the user can view the user.
     */
    public function view(User $user, EnhancedUser $model)
    {
        // Users can view their own profile or if they have permission
        return $user->id === $model->id || 
               $user->isSystemAdministrator() || 
               $user->isPartnerAdmin();
    }

    /**
     * Determine whether the user can create users.
     */
    public function create(User $user)
    {
        // Allow if user is System Administrator or Partner Admin
        return $user->isSystemAdministrator() || $user->isPartnerAdmin();
    }

    /**
     * Determine whether the user can update the user.
     */
    public function update(User $user, EnhancedUser $model)
    {
        // Users can update their own profile or if they have permission
        return $user->id === $model->id || 
               $user->isSystemAdministrator() || 
               $user->isPartnerAdmin();
    }

    /**
     * Determine whether the user can delete the user.
     */
    public function delete(User $user, EnhancedUser $model)
    {
        // Prevent self-deletion and allow if user has permission
        return $user->id !== $model->id && 
               ($user->isSystemAdministrator() || $user->isPartnerAdmin());
    }

    /**
     * Determine whether the user can bulk update users.
     */
    public function bulkUpdate(User $user)
    {
        return $user->isSystemAdministrator() || $user->isPartnerAdmin();
    }

    /**
     * Determine whether the user can view user activities.
     */
    public function viewActivities(User $user, EnhancedUser $model)
    {
        return $user->isSystemAdministrator() || $user->isPartnerAdmin();
    }

    /**
     * Determine whether the user can view user permissions.
     */
    public function viewPermissions(User $user, EnhancedUser $model)
    {
        return $user->isSystemAdministrator() || $user->isPartnerAdmin();
    }

    /**
     * Determine whether the user can export users.
     */
    public function export(User $user)
    {
        return $user->isSystemAdministrator() || $user->isPartnerAdmin();
    }

    /**
     * Determine whether the user can view statistics.
     */
    public function viewStatistics(User $user)
    {
        return $user->isSystemAdministrator() || $user->isPartnerAdmin();
    }

    /**
     * Determine whether the user can assign roles.
     */
    public function assignRoles(User $user)
    {
        return $user->isSystemAdministrator() || $user->isPartnerAdmin();
    }
}
