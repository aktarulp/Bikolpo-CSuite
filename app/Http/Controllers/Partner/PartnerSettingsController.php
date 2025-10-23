<?php

namespace App\Http\Controllers\Partner;

use App\Http\Controllers\Controller;
use App\Models\EnhancedUser;
use App\Models\Partner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PartnerSettingsController extends Controller
{
    /**
     * Display the partner settings page
     */
    public function index(Request $request)
    {
        try {
            // Get the authenticated user
            $user = auth()->user();
            if (!$user) {
                throw new \Exception('User not authenticated');
            }
            
            // For partner-admin users, we need to get their associated partner
            $partner = null;
            
            if ($user->role === 'partner_admin') {
                // For partner-admin, get the partner they belong to
                $partner = $user->partner;
                
                if (!$partner) {
                    return redirect()->route('partner.profile.edit')
                        ->with('error', 'Please complete your partner profile first.');
                }
            } elseif ($user->role === 'partner') {
                // For regular partner users, get their partner record
                $partner = $user->partner;
                
                if (!$partner) {
                    return redirect()->route('partner.profile.edit')
                        ->with('error', 'Please complete your partner profile first.');
                }
            } else {
                return redirect()->route('partner.dashboard')
                    ->with('error', 'Access denied. Partner role required.');
            }
            
            // Prepare basic stats with safe defaults
            $stats = [
                'total_users' => 0,
                'active_users' => 0,
                'pending_users' => 0,
                'suspended_users' => 0,
                'total_roles' => 0,
                'roles' => collect(),
                'users' => collect(),
            ];
            
            try {
                // Get users associated with this partner
                $users = EnhancedUser::where('partner_id', $partner->id)
                    ->with(['role'])
                    ->orderBy('created_at', 'desc')
                    ->get();
                
                // Calculate stats
                $stats['total_users'] = $users->count();
                $stats['active_users'] = $users->where('flag', 'active')->count();
                $stats['pending_users'] = $users->where('flag', 'pending')->count();
                $stats['suspended_users'] = $users->where('flag', 'suspended')->count();
                
                // Get unique roles
                $roles = $users->pluck('role')->filter()->unique();
                $stats['total_roles'] = $roles->count();
                $stats['roles'] = $roles;
                $stats['users'] = $users;
                
                // Return the view with the stats
                return view('partner.settings.partner-settings', [
                    'partner' => $partner,
                    'stats' => $stats
                ]);
                
            } catch (\Exception $e) {
                Log::error('Error preparing stats data: ' . $e->getMessage(), [
                    'file' => $e->getFile(),
                    'line' => $e->getLine(),
                    'trace' => $e->getTraceAsString()
                ]);
                
                // Return view with empty stats if data loading fails
                return view('partner.settings.partner-settings', [
                    'partner' => $partner,
                    'stats' => $stats
                ]);
            }
            
        } catch (\Exception $e) {
            Log::error('Critical error in partner settings: ' . $e->getMessage(), [
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return redirect()->route('partner.dashboard')
                ->with('error', 'An error occurred while loading settings. Please try again or contact support if the issue persists.');
        }
    }
}
