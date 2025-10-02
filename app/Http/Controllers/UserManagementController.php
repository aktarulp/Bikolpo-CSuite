<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

use App\Models\EnhancedUser;
use App\Models\EnhancedRole;
use App\Models\EnhancedPermission;
use App\Models\UserActivity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;
use Inertia\Inertia;

class UserManagementController extends Controller
{
    use AuthorizesRequests;
    /**
     * Display the user management dashboard.
     */
    public function index()
    {
        $this->authorize('viewAny', EnhancedUser::class);

        $users = EnhancedUser::with(['partner', 'roles', 'creator'])
            ->when(request('search'), function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                      ->orWhere('email', 'like', "%{$search}%")
                      ->orWhere('phone', 'like', "%{$search}%");
                });
            })
            ->when(request('status'), function ($query, $status) {
                $query->where('status', $status);
            })
            ->when(request('role'), function ($query, $role) {
                $query->whereHas('roles', function ($q) use ($role) {
                    $q->where('name', $role);
                });
            })
            ->when(request('partner'), function ($query, $partner) {
                $query->where('partner_id', $partner);
            })
            ->orderBy(request('sort_by', 'created_at'), request('sort_order', 'desc'))
            ->paginate(request('per_page', 10));

        $roles = EnhancedRole::active()->orderBy('level')->get();
        $partners = \App\Models\Partner::all();

        $stats = [
            'total_users' => EnhancedUser::count(),
            'active_users' => EnhancedUser::where('status', EnhancedUser::STATUS_ACTIVE)->count(),
            'inactive_users' => EnhancedUser::where('status', EnhancedUser::STATUS_INACTIVE)->count(),
            'suspended_users' => EnhancedUser::where('status', EnhancedUser::STATUS_SUSPENDED)->count(),
            'pending_users' => EnhancedUser::where('status', EnhancedUser::STATUS_PENDING)->count(),
            'users_by_role' => EnhancedUser::join('user_roles', 'users.id', '=', 'user_roles.user_id')
                ->join('roles', 'user_roles.role_id', '=', 'roles.id')
                ->groupBy('roles.name')
                ->selectRaw('roles.name as role_name, count(*) as count')
                ->pluck('count', 'role_name')
                ->toArray(),
        ];

        return view('partner.settings.user-management', compact('users', 'roles', 'partners', 'stats'));
    }

    /**
     * Show the form for creating a new user.
     */
    public function create()
    {
        // $this->authorize('create', EnhancedUser::class);

        $roles = EnhancedRole::active()->orderBy('level')->get();
        $partners = \App\Models\Partner::all();

        return view('partner.settings.create-user', compact('roles', 'partners'));
    }

    /**
     * Store a newly created user.
     */
    public function store(Request $request)
    {
        $this->authorize('create', EnhancedUser::class);

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'phone' => 'nullable|string|max:20',
            'password' => 'required|string|min:8|confirmed',
            'role_ids' => 'required|array|min:1',
            'role_ids.*' => 'exists:roles,id',
            'partner_id' => 'nullable|exists:partners,id',
            'status' => ['required', Rule::in(EnhancedUser::getStatuses())],
            'permissions' => 'nullable|array',
            'permissions.*' => 'exists:permissions,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            DB::beginTransaction();

            $user = EnhancedUser::create([
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'password' => Hash::make($request->password),
                'partner_id' => $request->partner_id,
                'status' => $request->status,
                'created_by' => auth()->id(),
                'updated_by' => auth()->id(),
            ]);

            // Assign roles
            $user->roles()->attach($request->role_ids, [
                'assigned_by' => auth()->id(),
                'assigned_at' => now(),
            ]);

            // Assign direct permissions if any
            if ($request->permissions) {
                $user->permissions()->attach($request->permissions, [
                    'granted_by' => auth()->id(),
                    'granted_at' => now(),
                ]);
            }

            // Log activity
            $user->activities()->create([
                'action' => 'user_created',
                'description' => 'User account created',
                'metadata' => [
                    'created_by' => auth()->id(),
                    'roles' => $request->role_ids,
                    'permissions' => $request->permissions ?? [],
                ],
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent(),
            ]);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'User created successfully',
                'user' => $user->load(['roles', 'permissions'])
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('User creation failed: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Failed to create user: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified user.
     */
    public function show(EnhancedUser $user)
    {
        $this->authorize('view', $user);

        $user->load(['partner', 'roles', 'permissions', 'creator', 'activities' => function ($query) {
            $query->latest()->take(10);
        }]);

        return response()->json([
            'success' => true,
            'user' => $user
        ]);
    }

    /**
     * Update the specified user.
     */
    public function update(Request $request, EnhancedUser $user)
    {
        $this->authorize('update', $user);

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'phone' => 'nullable|string|max:20',
            'password' => 'nullable|string|min:8|confirmed',
            'role_ids' => 'required|array|min:1',
            'role_ids.*' => 'exists:roles,id',
            'partner_id' => 'nullable|exists:partners,id',
            'status' => ['required', Rule::in(EnhancedUser::getStatuses())],
            'permissions' => 'nullable|array',
            'permissions.*' => 'exists:permissions,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            DB::beginTransaction();

            $updateData = [
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'partner_id' => $request->partner_id,
                'status' => $request->status,
                'updated_by' => auth()->id(),
            ];

            if ($request->password) {
                $updateData['password'] = Hash::make($request->password);
            }

            $user->update($updateData);

            // Sync roles
            $user->roles()->sync($request->role_ids, [
                'assigned_by' => auth()->id(),
                'assigned_at' => now(),
            ]);

            // Sync direct permissions
            $user->permissions()->sync($request->permissions ?? [], [
                'granted_by' => auth()->id(),
                'granted_at' => now(),
            ]);

            // Log activity
            $user->activities()->create([
                'action' => 'user_updated',
                'description' => 'User account updated',
                'metadata' => [
                    'updated_by' => auth()->id(),
                    'roles' => $request->role_ids,
                    'permissions' => $request->permissions ?? [],
                    'changed_fields' => array_keys($request->except(['password', 'password_confirmation'])),
                ],
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent(),
            ]);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'User updated successfully',
                'user' => $user->load(['roles', 'permissions'])
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('User update failed: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Failed to update user: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified user.
     */
    public function destroy(EnhancedUser $user)
    {
        $this->authorize('delete', $user);

        try {
            DB::beginTransaction();

            // Log activity before deletion
            $user->activities()->create([
                'action' => 'user_deleted',
                'description' => 'User account deleted',
                'metadata' => [
                    'deleted_by' => auth()->id(),
                    'user_data' => [
                        'name' => $user->name,
                        'email' => $user->email,
                        'roles' => $user->roles->pluck('id')->toArray(),
                        'permissions' => $user->permissions->pluck('id')->toArray(),
                    ],
                ],
                'ip_address' => request()->ip(),
                'user_agent' => request()->userAgent(),
            ]);

            // Detach relationships
            $user->roles()->detach();
            $user->permissions()->detach();

            // Delete user
            $user->delete();

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'User deleted successfully'
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('User deletion failed: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete user: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Bulk update users.
     */
    public function bulkUpdate(Request $request)
    {
        $this->authorize('bulkUpdate', EnhancedUser::class);

        $validator = Validator::make($request->all(), [
            'user_ids' => 'required|array|min:1',
            'user_ids.*' => 'exists:users,id',
            'action' => 'required|string|in:activate,deactivate,suspend,assign_role,remove_role,assign_permission,remove_permission',
            'role_id' => 'required_if:action,assign_role,remove_role|exists:roles,id',
            'permission_id' => 'required_if:action,assign_permission,remove_permission|exists:permissions,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            DB::beginTransaction();

            $users = EnhancedUser::whereIn('id', $request->user_ids)->get();
            $updatedCount = 0;

            foreach ($users as $user) {
                switch ($request->action) {
                    case 'activate':
                        $user->update(['status' => EnhancedUser::STATUS_ACTIVE]);
                        $updatedCount++;
                        break;
                    
                    case 'deactivate':
                        $user->update(['status' => EnhancedUser::STATUS_INACTIVE]);
                        $updatedCount++;
                        break;
                    
                    case 'suspend':
                        $user->update(['status' => EnhancedUser::STATUS_SUSPENDED]);
                        $updatedCount++;
                        break;
                    
                    case 'assign_role':
                        $user->assignRole($request->role_id, auth()->id());
                        $updatedCount++;
                        break;
                    
                    case 'remove_role':
                        $user->roles()->detach($request->role_id);
                        $updatedCount++;
                        break;
                    
                    case 'assign_permission':
                        $user->permissions()->attach($request->permission_id, [
                            'granted_by' => auth()->id(),
                            'granted_at' => now(),
                        ]);
                        $updatedCount++;
                        break;
                    
                    case 'remove_permission':
                        $user->permissions()->detach($request->permission_id);
                        $updatedCount++;
                        break;
                }

                // Log activity for each user
                $user->activities()->create([
                    'action' => 'user_bulk_updated',
                    'description' => "User bulk action: {$request->action}",
                    'metadata' => [
                        'action' => $request->action,
                        'role_id' => $request->role_id ?? null,
                        'permission_id' => $request->permission_id ?? null,
                        'performed_by' => auth()->id(),
                    ],
                    'ip_address' => $request->ip(),
                    'user_agent' => $request->userAgent(),
                ]);
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => "Successfully updated {$updatedCount} users",
                'updated_count' => $updatedCount
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Bulk user update failed: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Failed to bulk update users: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get user activities.
     */
    public function getActivities(EnhancedUser $user)
    {
        $this->authorize('viewActivities', $user);

        $activities = $user->activities()
            ->with('user')
            ->latest()
            ->paginate(request('per_page', 20));

        return response()->json([
            'success' => true,
            'activities' => $activities
        ]);
    }

    /**
     * Get user permissions.
     */
    public function getPermissions(EnhancedUser $user)
    {
        $this->authorize('viewPermissions', $user);

        $directPermissions = $user->permissions;
        $rolePermissions = collect();

        foreach ($user->roles as $role) {
            $rolePermissions = $rolePermissions->merge($role->getAllPermissions());
        }

        $allPermissions = $directPermissions->merge($rolePermissions)->unique('id');

        return response()->json([
            'success' => true,
            'permissions' => [
                'direct' => $directPermissions,
                'through_roles' => $rolePermissions->unique('id'),
                'all' => $allPermissions
            ]
        ]);
    }

    /**
     * Export users data.
     */
    public function export(Request $request)
    {
        $this->authorize('export', EnhancedUser::class);

        $users = EnhancedUser::with(['partner', 'roles', 'permissions'])
            ->when($request->search, function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                      ->orWhere('email', 'like', "%{$search}%")
                      ->orWhere('phone', 'like', "%{$search}%");
                });
            })
            ->when($request->status, function ($query, $status) {
                $query->where('status', $status);
            })
            ->when($request->role, function ($query, $role) {
                $query->whereHas('roles', function ($q) use ($role) {
                    $q->where('name', $role);
                });
            })
            ->orderBy('created_at', 'desc')
            ->get();

        $exportData = $users->map(function ($user) {
            return [
                'ID' => $user->id,
                'Name' => $user->name,
                'Email' => $user->email,
                'Phone' => $user->phone,
                'Status' => $user->status,
                'Partner' => $user->partner?->name,
                'Roles' => $user->roles->pluck('name')->join(', '),
                'Permissions' => $user->permissions->pluck('name')->join(', '),
                'Created At' => $user->created_at->format('Y-m-d H:i:s'),
                'Updated At' => $user->updated_at->format('Y-m-d H:i:s'),
            ];
        });

        return response()->json([
            'success' => true,
            'data' => $exportData
        ]);
    }

    /**
     * Get user management statistics.
     */
    public function getStatistics()
    {
        $this->authorize('viewStatistics', EnhancedUser::class);

        $stats = [
            'total_users' => EnhancedUser::count(),
            'active_users' => EnhancedUser::where('status', EnhancedUser::STATUS_ACTIVE)->count(),
            'inactive_users' => EnhancedUser::where('status', EnhancedUser::STATUS_INACTIVE)->count(),
            'suspended_users' => EnhancedUser::where('status', EnhancedUser::STATUS_SUSPENDED)->count(),
            'pending_users' => EnhancedUser::where('status', EnhancedUser::STATUS_PENDING)->count(),
            'users_by_role' => EnhancedUser::join('user_roles', 'users.id', '=', 'user_roles.user_id')
                ->join('roles', 'user_roles.role_id', '=', 'roles.id')
                ->groupBy('roles.name')
                ->selectRaw('roles.name as role_name, count(*) as count')
                ->pluck('count', 'role_name')
                ->toArray(),
            'users_by_partner' => EnhancedUser::join('partners', 'users.partner_id', '=', 'partners.id')
                ->groupBy('partners.name')
                ->selectRaw('partners.name as partner_name, count(*) as count')
                ->pluck('count', 'partner_name')
                ->toArray(),
            'recent_users' => EnhancedUser::with(['roles'])
                ->orderBy('created_at', 'desc')
                ->take(5)
                ->get(),
            'recent_activities' => UserActivity::with(['user'])
                ->orderBy('created_at', 'desc')
                ->take(10)
                ->get(),
        ];

        return response()->json([
            'success' => true,
            'stats' => $stats
        ]);
    }

    /**
     * Get available roles and permissions for assignment.
     */
    public function getAssignableRolesAndPermissions()
    {
        $this->authorize('assignRoles', EnhancedUser::class);

        $roles = EnhancedRole::active()
            ->orderBy('level')
            ->orderBy('name')
            ->get()
            ->map(function ($role) {
                return [
                    'id' => $role->id,
                    'name' => $role->name,
                    'display_name' => $role->display_name,
                    'description' => $role->description,
                    'level' => $role->level,
                    'level_badge' => $role->level_badge,
                    'permissions_count' => $role->permissions->count(),
                ];
            });

        $permissions = EnhancedPermission::active()
            ->orderBy('module')
            ->orderBy('name')
            ->get()
            ->groupBy('module')
            ->map(function ($modulePermissions, $module) {
                return [
                    'module' => $module,
                    'permissions' => $modulePermissions->map(function ($permission) {
                        return [
                            'id' => $permission->id,
                            'name' => $permission->name,
                            'display_name' => $permission->display_name,
                            'description' => $permission->description,
                        ];
                    }),
                ];
            })
            ->values();

        return response()->json([
            'success' => true,
            'roles' => $roles,
            'permissions' => $permissions
        ]);
    }

    /**
     * Get recent user activity.
     */
    public function getRecentActivity()
    {
        $this->authorize('viewAny', EnhancedUser::class);

        $activities = UserActivity::with(['user'])
            ->orderBy('created_at', 'desc')
            ->limit(50)
            ->get()
            ->map(function ($activity) {
                return [
                    'id' => $activity->id,
                    'user_name' => $activity->user ? $activity->user->name : 'Unknown',
                    'user_email' => $activity->user ? $activity->user->email : '',
                    'action' => $activity->action,
                    'description' => $activity->description,
                    'ip_address' => $activity->ip_address,
                    'created_at' => $activity->created_at->toISOString(),
                ];
            });

        return response()->json([
            'success' => true,
            'activities' => $activities
        ]);
    }
}
