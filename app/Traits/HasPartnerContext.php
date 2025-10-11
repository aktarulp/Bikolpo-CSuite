<?php

namespace App\Traits;

use App\Models\Partner;

trait HasPartnerContext
{
    /**
     * Get the authenticated user's partner ID
     *
     * @return int
     * @throws \Exception
     */
    protected function getPartnerId(): int
    {
        $userId = auth()->id();
        if (!$userId) {
            throw new \Exception('User not authenticated.');
        }
        
        // ALWAYS get fresh user data from database to avoid session cache issues
        $user = \App\Models\EnhancedUser::find($userId);
        if (!$user) {
            throw new \Exception('User not found.');
        }
        
        // First check if user has a direct partner_id (for sub-users)
        if ($user->partner_id) {
            return (int) $user->partner_id;
        }
        
        throw new \Exception('Partner profile not found for user ID: ' . $userId);
    }

    /**
     * Get the authenticated user's partner model
     *
     * @return Partner
     * @throws \Exception
     */
    protected function getPartner(): Partner
    {
        $userId = auth()->id();
        if (!$userId) {
            throw new \Exception('User not authenticated.');
        }
        
        // ALWAYS get fresh user data from database to avoid session cache issues
        $user = \App\Models\EnhancedUser::find($userId);
        if (!$user) {
            throw new \Exception('User not found.');
        }
        
        // First check if user has a direct partner_id (for sub-users)
        if ($user->partner_id) {
            $partner = \App\Models\Partner::find($user->partner_id);
            if ($partner) {
                return $partner;
            }
        }
        
        throw new \Exception('Partner profile not found. Please contact administrator.');
    }

    /**
     * Ensure the authenticated user has a partner profile
     *
     * @return bool
     */
    protected function ensurePartnerContext(): bool
    {
        try {
            $this->getPartnerId();
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }
}