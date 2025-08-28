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
        
        $user = auth()->user();
        if (!$user) {
            throw new \Exception('User not found.');
        }
        
        // Fix: Access the partner relationship properly
        $partner = $user->partner;
        if (!$partner) {
            throw new \Exception('Partner profile not found for user ID: ' . $userId);
        }
        
        return (int) $partner->id;
    }

    /**
     * Get the authenticated user's partner model
     *
     * @return Partner
     * @throws \Exception
     */
    protected function getPartner(): Partner
    {
        $partner = auth()->user()->partner;
        if (!$partner) {
            throw new \Exception('Partner profile not found. Please contact administrator.');
        }
        
        return $partner;
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
