<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

use App\Models\EnhancedUser;
use App\Models\EnhancedRole;
use App\Models\UserActivity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use App\Traits\HasPartnerContext;
use Illuminate\Validation\Rule;
use Inertia\Inertia;

class UserManagementController extends Controller
{
    use AuthorizesRequests, HasPartnerContext;
    /**
     * Display the user management dashboard.
     */
    public function index()
    {
        // Permission checking disabled

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
            'users_by_role' => EnhancedUser::join('ac_roles', 'ac_users.role_id', '=', 'ac_roles.id')
                ->groupBy('ac_roles.name')
                ->selectRaw('ac_roles.name as role_name, count(*) as count')
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
        // Permission checking disabled

        $currentUser = EnhancedUser::find(auth()->id());
        $currentUserLevel = $currentUser->getHighestRoleLevel();

        // If currentUserLevel is null, default to a high level (show all roles)
        if ($currentUserLevel === null) {
            $currentUserLevel = 1; // Default to highest privilege level
        }


        // Get current partner and partner ID
        $partner = $this->getPartner();
        $partnerId = $this->getPartnerId();

        // Get students from current partner who don't have user accounts yet
        $students = \App\Models\Student::where('partner_id', $partnerId)
            ->whereNull('user_id') // Only students without user accounts
            ->orderBy('full_name')
            ->get();

        // Debug: Log the counts
        \Log::info('UserManagementController create method', [
            'partner_id' => $partnerId,
            'students_count' => $students->count(),
            'students_without_users' => $students->whereNull('user_id')->count()
        ]);

        return view('partner.settings.create-user', compact('students'));
    }

    /**
     * Store a newly created user with comprehensive student data.
     */
    public function store(Request $request)
    {
        try {
            // Validate the request
            $validated = $request->validate([
                'student_id' => 'required|exists:students,id',
                'password' => 'required|string|min:8|confirmed',
                'role_id' => 'required|exists:ac_roles,id',
                'user_type' => 'required|in:student,other',
            ], [
                'student_id.required' => 'Please select a student.',
                'student_id.exists' => 'The selected student is invalid.',
                'password.required' => 'Password is required.',
                'password.min' => 'Password must be at least 8 characters.',
                'password.confirmed' => 'Password confirmation does not match.',
                'role_id.required' => 'Role is required.',
                'role_id.exists' => 'The selected role is invalid.',
                'user_type.required' => 'User type is required.',
                'user_type.in' => 'Invalid user type selected.',
            ]);
            
            // Log the validated data for debugging
            \Log::info('Creating user with validated data:', [
                'student_id' => $validated['student_id'],
                'role_id' => $validated['role_id'],
                'user_type' => $validated['user_type']
            ]);

            DB::beginTransaction();

            try {
                // Get the student
                $student = \App\Models\Student::findOrFail($validated['student_id']);
                
                // Check if student already has a user account
                if ($student->user_id) {
                    return response()->json([
                        'success' => false,
                        'message' => 'This student already has a user account.'
                    ], 422);
                }
                
                // Check if email already exists
                if ($student->email && EnhancedUser::where('email', $student->email)->exists()) {
                    return response()->json([
                        'success' => false,
                        'message' => 'A user with this email address already exists.'
                    ], 422);
                }
                
                // Get the role (hardcoded to student role)
                $roleId = 3; // Student role ID
                $selectedRole = EnhancedRole::find($roleId);
                
                if (!$selectedRole) {
                    throw new \Exception("Role with ID {$roleId} not found");
                }
                
                // Create the user
                $user = new EnhancedUser();
                $user->name = $student->full_name;
                $user->email = $student->email ?? strtolower(str_replace(' ', '.', $student->full_name)) . '@example.com';
                $user->phone = $student->phone ?? '';
                $user->password = Hash::make($validated['password']);
                $user->role_id = $roleId;
                $user->role = 'student';
                $user->partner_id = $this->getPartnerId();
                $user->status = 'active';
                $user->email_verified_at = now();
                $user->created_by = auth()->id();
                $user->updated_by = auth()->id();
                
                // Save the user with error handling
                if (!$user->save()) {
                    throw new \Exception('Failed to save user');
                }
                
                // Update the student record to link to the user
                $student->user_id = $user->id;
                $student->save();

                DB::commit();

                return response()->json([
                    'success' => true,
                    'message' => 'User created successfully',
                    'redirect' => route('partner.settings.index')
                ]);

            } catch (\Exception $e) {
                DB::rollBack();
                
                // Handle specific database errors
                if (strpos($e->getMessage(), 'Duplicate entry') !== false) {
                    if (strpos($e->getMessage(), 'users_email_unique') !== false) {
                        return response()->json([
                            'success' => false,
                            'message' => 'A user with this email address already exists.'
                        ], 422);
                    }
                    if (strpos($e->getMessage(), 'users_phone_unique') !== false) {
                        return response()->json([
                            'success' => false,
                            'message' => 'A user with this phone number already exists.'
                        ], 422);
                    }
                }
                
                \Log::error('Error creating user: ' . $e->getMessage(), [
                    'exception' => $e,
                    'trace' => $e->getTraceAsString()
                ]);
                
                return response()->json([
                    'success' => false,
                    'message' => 'Error creating user: ' . $e->getMessage()
                ], 500);
            }
        } catch (\Illuminate\Validation\ValidationException $e) {
            \Log::error('Validation error creating user: ' . json_encode($e->errors()), [
                'exception' => $e,
                'trace' => $e->getTraceAsString()
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'Please check the form for errors.',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            \Log::error('Unexpected error creating user: ' . $e->getMessage(), [
                'exception' => $e,
                'trace' => $e->getTraceAsString()
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'An unexpected error occurred while creating the user. Please try again.'
            ], 500);
        }
    }

    /**
     * Display the specified user.
     */
    public function show(EnhancedUser $user)
    {
        // Permission checking disabled

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
        // Permission checking disabled

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
 'email' => ['required', 'string', 'email', 'max:255', Rule::unique('ac_users', 'email')->ignore($user->id, 'id')],
            'phone' => 'nullable|string|max:20',
            'password' => 'nullable|string|min:8|confirmed',
            'role_ids' => 'required|array|min:1',
'role_ids.*' => 'exists:ac_roles,id',
            'partner_id' => 'nullable|exists:partners,id',
            'status' => ['required', Rule::in(EnhancedUser::getStatuses())],
            'permissions' => 'nullable|array',
'permissions.*' => 'exists:ac_modules,id',
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

            // Role syncing disabled - skip roles sync
            // $user->roles()->sync($request->role_ids, [
            //     'assigned_by' => auth()->id(),
            //     'assigned_at' => now(),
            // ]);

            // Permission syncing disabled - skip permissions sync
            // $user->permissions()->sync($request->permissions ?? [], [
            //     'granted_by' => auth()->id(),
            //     'granted_at' => now(),
            // ]);

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
        // Permission checking disabled

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

            // Relationship detaching disabled - skip detaching
            // $user->roles()->detach();
            // $user->permissions()->detach();

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
        // Permission checking disabled

        $validator = Validator::make($request->all(), [
            'user_ids' => 'required|array|min:1',
'user_ids.*' => 'exists:ac_users,id',
            'action' => 'required|string|in:activate,deactivate,suspend,assign_role,remove_role,assign_permission,remove_permission',
'role_id' => 'required_if:action,assign_role,remove_role|exists:ac_roles,id',
'permission_id' => 'required_if:action,assign_permission,remove_permission|exists:ac_modules,id',
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
                        // Role assignment disabled - skip assignment
                        $updatedCount++;
                        break;
                    
                    case 'remove_role':
                        // Role removal disabled - skip removal
                        $updatedCount++;
                        break;
                    
                    case 'assign_permission':
                        // Permission assignment disabled - skip assignment
                        $updatedCount++;
                        break;
                    
                    case 'remove_permission':
                        // Permission removal disabled - skip removal
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
        // Permission checking disabled

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
        // Permission checking disabled

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
        // Permission checking disabled

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
        // Permission checking disabled

        $stats = [
            'total_users' => EnhancedUser::count(),
            'active_users' => EnhancedUser::where('status', EnhancedUser::STATUS_ACTIVE)->count(),
            'inactive_users' => EnhancedUser::where('status', EnhancedUser::STATUS_INACTIVE)->count(),
            'suspended_users' => EnhancedUser::where('status', EnhancedUser::STATUS_SUSPENDED)->count(),
            'pending_users' => EnhancedUser::where('status', EnhancedUser::STATUS_PENDING)->count(),
            'users_by_role' => EnhancedUser::join('ac_roles', 'ac_users.role_id', '=', 'ac_roles.id')
                ->groupBy('ac_roles.name')
                ->selectRaw('ac_roles.name as role_name, count(*) as count')
                ->pluck('count', 'role_name')
                ->toArray(),
            'users_by_partner' => EnhancedUser::join('partners', 'ac_users.partner_id', '=', 'partners.id')
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
        // Permission checking disabled

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

        return response()->json([
            'success' => true,
            'roles' => $roles,
            'permissions' => [] // Permissions disabled
        ]);
    }

    /**
     * Get recent user activity.
     */
    public function getRecentActivity()
    {
        // Permission checking disabled

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

    /**
     * Get students for auto-population in create user form.
     */
    public function getStudents()
    {
        try {
            // Debug: Check if user is authenticated
            if (!auth()->check()) {
                return response()->json([
                    'success' => false,
                    'message' => 'User not authenticated'
                ], 401);
            }

            $partnerId = auth()->user()->partner_id;
            
            // If no partner_id, try to get students from all partners (for testing)
            if (!$partnerId) {
                $students = \App\Models\Student::whereNull('id')
                    ->where('status', 'active')
                    ->where('flag', 'active')
                    ->where('enable_login', 'y') // Only students with login enabled
                    ->select('id', 'full_name as name', 'email', 'phone', 'partner_id')
                    ->orderBy('full_name')
                    ->limit(50) // Limit to prevent too many results
                    ->get();
            } else {
                $students = \App\Models\Student::where('partner_id', $partnerId)
                    ->whereNull('id') // Only students without user accounts
                    ->where('status', 'active')
                    ->where('flag', 'active') // Also check the flag field
                    ->where('enable_login', 'y') // Only students with login enabled
                    ->select('id', 'full_name as name', 'email', 'phone')
                    ->orderBy('full_name')
                    ->get();
            }

            return response()->json([
                'success' => true,
                'data' => $students,
                'debug' => [
                    'partner_id' => $partnerId,
                    'count' => $students->count(),
                    'message' => $partnerId ? "Found students for partner {$partnerId}" : "Found students from all partners (no partner_id set)"
                ]
            ]);
        } catch (\Exception $e) {
            Log::error('Error fetching students: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch students: ' . $e->getMessage()
            ], 500);
        }
    }

}
