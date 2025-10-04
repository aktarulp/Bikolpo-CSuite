<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

use App\Models\EnhancedUser;
use App\Models\EnhancedRole;
use App\Models\EnhancedPermission;
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
        // $this->authorize('viewAny', EnhancedUser::class);

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

        $currentUser = EnhancedUser::find(auth()->id());
        $currentUserLevel = $currentUser->getHighestRoleLevel();

        // Filter roles - only show roles with level >= current user's level (same or lower privilege)
        $roles = EnhancedRole::active()
            ->where('level', '>=', $currentUserLevel)
            ->orderBy('level')
            ->get();

        // Get current partner ID
        $partnerId = $this->getPartnerId();

        // Get teachers from current partner (prioritize those without user accounts)
        $teachers = \App\Models\Teacher::where('partner_id', $partnerId)
            ->orderByRaw('user_id IS NULL DESC') // Show teachers without user accounts first
            ->orderBy('full_name_en')
            ->get();

        // Get students from current partner (prioritize those without user accounts)
        $students = \App\Models\Student::where('partner_id', $partnerId)
            ->orderByRaw('user_id IS NULL DESC') // Show students without user accounts first
            ->orderBy('full_name')
            ->get();

        // Debug: Log the counts
        \Log::info('UserManagementController create method', [
            'partner_id' => $partnerId,
            'teachers_count' => $teachers->count(),
            'students_count' => $students->count(),
            'teachers_without_users' => $teachers->whereNull('user_id')->count(),
            'students_without_users' => $students->whereNull('user_id')->count()
        ]);

        // Get the default role (first role in the filtered list)
        $defaultRole = $roles->first();

        return view('partner.settings.create-user', compact('roles', 'teachers', 'students', 'defaultRole'));
    }

    /**
     * Store a newly created user with comprehensive teacher/student data.
     */
    public function store(Request $request)
    {
        // Base validation rules
        $rules = [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'phone' => 'required|string|max:20|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'role_id' => 'required|exists:roles,id',
            'user_type' => 'required|in:teacher,student,operator',
        ];
        
        // Ensure role_id is properly cast to integer
        if ($request->has('role_id')) {
            $request->merge(['role_id' => (int)$request->role_id]);
        }

        // Add teacher-specific validation rules
        if ($request->user_type === 'teacher') {
            if ($request->has('teacher_id')) {
                // Linking to existing teacher - only validate teacher_id
                $rules['teacher_id'] = 'required|exists:teachers,id';
            } else {
                // Creating new teacher - validate all teacher fields
                $rules = array_merge($rules, [
                    'teacher.full_name_en' => 'required|string|max:255',
                    'teacher.full_name_bn' => 'nullable|string|max:255',
                    'teacher.gender' => 'required|in:male,female,other',
                    'teacher.dob' => 'required|date',
                    'teacher.mobile' => 'required|string|max:20',
                    'teacher.designation' => 'required|string|max:255',
                    'teacher.department' => 'nullable|string|max:255',
                    'teacher.joining_date' => 'required|date',
                    'teacher.present_address' => 'nullable|string|max:500',
                    'teacher.blood_group' => 'nullable|in:A+,A-,B+,B-,AB+,AB-,O+,O-',
                    'teacher.default_role' => 'nullable|exists:roles,name',
                ]);
            }
        }

        // Add student-specific validation rules
        if ($request->user_type === 'student') {
            if ($request->has('student_id')) {
                // Linking to existing student - only validate student_id
                $rules['student_id'] = 'required|exists:students,id';
            } else {
                // Creating new student - validate all student fields
                $rules = array_merge($rules, [
                    'student.full_name' => 'required|string|max:255',
                    'student.date_of_birth' => 'required|date',
                    'student.gender' => 'required|in:male,female,other',
                    'student.address' => 'nullable|string|max:500',
                    'student.city' => 'nullable|string|max:100',
                    'student.school_college' => 'nullable|string|max:255',
                    'student.class_grade' => 'nullable|string|max:50',
                    'student.father_name' => 'nullable|string|max:255',
                    'student.mother_name' => 'nullable|string|max:255',
                    'student.blood_group' => 'nullable|in:A+,A-,B+,B-,AB+,AB-,O+,O-',
                    'student.religion' => 'nullable|in:Islam,Hinduism,Christianity,Buddhism',
                    'student.default_role' => 'nullable|exists:roles,name',
                ]);
            }
        }

        // Ensure role_id is properly cast to integer
        $request->merge(['role_id' => (int)$request->role_id]);
        
        $validated = $request->validate($rules);
        
        // Log the validated data for debugging
        \Log::info('Creating user with validated data:', [
            'name' => $validated['name'],
            'email' => $validated['email'],
            'role_id' => $validated['role_id'],
            'role_id_type' => gettype($validated['role_id']),
            'user_type' => $validated['user_type']
        ]);

        DB::beginTransaction();

        try {
            // Log the incoming request data for debugging
            \Log::info('User creation request data:', [
                'validated' => $validated,
                'request_all' => $request->all()
            ]);
            
            // Get the role with error handling
            $roleId = (int)$validated['role_id'];
            
            // Log the role ID and its type
            \Log::info('Role ID and type:', [
                'role_id' => $roleId,
                'role_id_type' => gettype($roleId),
                'role_id_value' => $roleId
            ]);
            
            $selectedRole = EnhancedRole::find($roleId);
            
            if (!$selectedRole) {
                throw new \Exception("Role with ID {$roleId} not found");
            }
            
            // Log role information with detailed type information
            \Log::info('Using role:', [
                'id' => $selectedRole->id,
                'id_type' => gettype($selectedRole->id),
                'name' => $selectedRole->name,
                'name_type' => gettype($selectedRole->name),
                'role_object' => $selectedRole->toArray()
            ]);
            
            // Create the user
            $user = new EnhancedUser();
            $user->name = $validated['name'];
            $user->email = $validated['email'];
            $user->phone = $validated['phone'];
            $user->password = Hash::make($validated['password']);
            $user->role_id = $roleId;
            // Safely get role name with type checking
            $roleName = $selectedRole->name;
            if (!is_string($roleName)) {
                if (is_object($roleName) && method_exists($roleName, '__toString')) {
                    $roleName = (string)$roleName;
                } else {
                    $roleName = 'user';
                    \Log::warning('Invalid role name type, defaulting to "user"', [
                        'role_name' => $roleName,
                        'role_name_type' => gettype($roleName)
                    ]);
                }
            }
            $user->role = strtolower($roleName);
            $user->partner_id = $this->getPartnerId();
            $user->status = 'active';
            $user->email_verified_at = now();
            $user->created_by = auth()->id();
            $user->updated_by = auth()->id();
            
            // Save the user with error handling
            if (!$user->save()) {
                throw new \Exception('Failed to save user');
            }
            
            // Ensure the user is properly loaded with the role
            $user->load('roles');
            
            \Log::info('User created successfully', ['user_id' => $user->id]);
            
            // Create teacher record if user_type is teacher
            if ($validated['user_type'] === 'teacher' && isset($validated['teacher'])) {
                $teacherData = $validated['teacher'];
                $teacherData['user_id'] = $user->id;
                $teacherData['partner_id'] = $this->getPartnerId();
                $teacherData['created_by'] = auth()->id();
                $teacherData['updated_by'] = auth()->id();
                $teacherData['status'] = 'Active';
                $teacherData['enable_login'] = 'y';
                
                // Generate teacher ID
                $lastTeacher = \App\Models\Teacher::where('partner_id', $this->getPartnerId())
                    ->whereNotNull('teacher_id')
                    ->orderBy('id', 'desc')
                    ->first();
                
                $nextNumber = $lastTeacher ? (int)substr($lastTeacher->teacher_id, -3) + 1 : 1;
                $teacherData['teacher_id'] = 'TCH-' . date('Y') . '-' . str_pad($nextNumber, 3, '0', STR_PAD_LEFT);

                \App\Models\Teacher::create($teacherData);
            }

            // Create student record if user_type is student
            if ($validated['user_type'] === 'student' && isset($validated['student'])) {
                $studentData = $validated['student'];
                $studentData['user_id'] = $user->id;
                $studentData['partner_id'] = $this->getPartnerId();
                $studentData['created_by'] = auth()->id();
                $studentData['status'] = 'active';
                $studentData['enable_login'] = 'y';
                $studentData['enroll_date'] = now();
                
                // Generate student ID
                $lastStudent = \App\Models\Student::where('partner_id', $this->getPartnerId())
                    ->whereNotNull('student_id')
                    ->orderBy('id', 'desc')
                    ->first();
                
                $nextNumber = $lastStudent ? (int)substr($lastStudent->student_id, -3) + 1 : 1;
                $studentData['student_id'] = 'STU-' . date('Y') . '-' . str_pad($nextNumber, 3, '0', STR_PAD_LEFT);

                \App\Models\Student::create($studentData);
            }

            // Link to existing teacher or student if specified
            if ($validated['user_type'] === 'teacher' && $request->has('teacher_id') && !isset($validated['teacher'])) {
                $teacher = \App\Models\Teacher::where('id', $request->teacher_id)
                    ->where('partner_id', $this->getPartnerId())
                    ->first();

                if ($teacher) {
                    $teacher->user_id = $user->id;
                    $teacher->save();
                }
            } elseif ($validated['user_type'] === 'student' && $request->has('student_id') && !isset($validated['student'])) {
                $student = \App\Models\Student::where('id', $request->student_id)
                    ->where('partner_id', $this->getPartnerId())
                    ->first();

                if ($student) {
                    $student->user_id = $user->id;
                    $student->save();
                }
            }

            // Create teacher record if user_type is teacher
            if ($validated['user_type'] === 'teacher' && isset($validated['teacher'])) {
                $teacherData = $validated['teacher'];
                $teacherData['user_id'] = $user->id;
                $teacherData['partner_id'] = $this->getPartnerId();
                $teacherData['created_by'] = auth()->id();
                $teacherData['updated_by'] = auth()->id();
                $teacherData['status'] = 'Active';
                $teacherData['enable_login'] = 'y';
                
                // Generate teacher ID
                $lastTeacher = \App\Models\Teacher::where('partner_id', $this->getPartnerId())
                    ->whereNotNull('teacher_id')
                    ->orderBy('id', 'desc')
                    ->first();
                
                $nextNumber = $lastTeacher ? (int)substr($lastTeacher->teacher_id, -3) + 1 : 1;
                $teacherData['teacher_id'] = 'TCH-' . date('Y') . '-' . str_pad($nextNumber, 3, '0', STR_PAD_LEFT);

                \App\Models\Teacher::create($teacherData);
            }

            // Create student record if user_type is student
            if ($validated['user_type'] === 'student' && isset($validated['student'])) {
                $studentData = $validated['student'];
                $studentData['user_id'] = $user->id;
                $studentData['partner_id'] = $this->getPartnerId();
                $studentData['created_by'] = auth()->id();
                $studentData['status'] = 'active';
                $studentData['enable_login'] = 'y';
                $studentData['enroll_date'] = now();
                
                // Generate student ID
                $lastStudent = \App\Models\Student::where('partner_id', $this->getPartnerId())
                    ->whereNotNull('student_id')
                    ->orderBy('id', 'desc')
                    ->first();
                
                $nextNumber = $lastStudent ? (int)substr($lastStudent->student_id, -3) + 1 : 1;
                $studentData['student_id'] = 'STU-' . date('Y') . '-' . str_pad($nextNumber, 3, '0', STR_PAD_LEFT);

                \App\Models\Student::create($studentData);
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'User created successfully',
                'redirect' => route('partner.settings.users.index')
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Error creating user: ' . $e->getMessage(), [
                'exception' => $e,
                'trace' => $e->getTraceAsString()
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'Error creating user: ' . $e->getMessage(),
                'user_data' => isset($user) ? $user->toArray() : null
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
                $students = \App\Models\Student::where('user_id', null)
                    ->where('status', 'active')
                    ->where('flag', 'active')
                    ->where('enable_login', 'y') // Only students with login enabled
                    ->select('id', 'full_name as name', 'email', 'phone', 'partner_id')
                    ->orderBy('full_name')
                    ->limit(50) // Limit to prevent too many results
                    ->get();
            } else {
                $students = \App\Models\Student::where('partner_id', $partnerId)
                    ->where('user_id', null) // Only students without user accounts
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

    /**
     * Get teachers for auto-population in create user form.
     */
    public function getTeachers()
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
            
            // If no partner_id, try to get teachers from all partners (for testing)
            if (!$partnerId) {
                $teachers = \App\Models\Teacher::where('user_id', null)
                    ->where('status', 'Active')
                    ->where('enable_login', 'y') // Only teachers with login enabled
                    ->select('id', 'full_name_en as name', 'email', 'mobile as phone', 'partner_id')
                    ->orderBy('full_name_en')
                    ->limit(50) // Limit to prevent too many results
                    ->get();
            } else {
                $teachers = \App\Models\Teacher::where('partner_id', $partnerId)
                    ->where('user_id', null) // Only teachers without user accounts
                    ->where('status', 'Active')
                    ->where('enable_login', 'y') // Only teachers with login enabled
                    ->select('id', 'full_name_en as name', 'email', 'mobile as phone')
                    ->orderBy('full_name_en')
                    ->get();
            }

            return response()->json([
                'success' => true,
                'data' => $teachers,
                'debug' => [
                    'partner_id' => $partnerId,
                    'count' => $teachers->count(),
                    'message' => $partnerId ? "Found teachers for partner {$partnerId}" : "Found teachers from all partners (no partner_id set)"
                ]
            ]);
        } catch (\Exception $e) {
            Log::error('Error fetching teachers: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch teachers: ' . $e->getMessage()
            ], 500);
        }
    }
}
