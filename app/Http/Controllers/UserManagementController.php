<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

use App\Models\EnhancedUser;
use App\Models\EnhancedRole;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
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

        // Get current partner ID
        $partnerId = $this->getPartnerId();
        
        $users = EnhancedUser::with(['partner', 'role', 'creator'])
            ->where('partner_id', $partnerId) // Only show users from current partner
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
                $query->whereHas('role', function ($q) use ($role) {
                    $q->where('name', $role);
                });
            })
            ->orderBy(request('sort_by', 'created_at'), request('sort_order', 'desc'))
            ->paginate(request('per_page', 15));

        // Ensure roles are properly loaded for all users
        $users->each(function ($user) {
            if ($user->role_id && (!$user->role || !is_object($user->role))) {
                // Try to manually load the role if it's not loaded properly
                $user->setRelation('role', \App\Models\EnhancedRole::find($user->role_id));
            }
        });

        // Debug: Check if users have roles loaded
        foreach ($users as $user) {
            \Log::info("User {$user->id} - Name: {$user->name}, Role: " . $user->getRoleName() . ", Role Display: " . $user->getRoleDisplayName());
        }
        
        // Additional debugging
        \Log::info('Total users loaded: ' . $users->count());
        foreach ($users as $user) {
            \Log::info("User {$user->id} - Name: {$user->name}, Role ID: " . ($user->role_id ?? 'null') . ", Role loaded: " . ($user->relationLoaded('role') ? 'yes' : 'no') . ", Role Name: " . $user->getRoleName());
        }

        $roles = EnhancedRole::active()->orderBy('level')->get();
        $partners = \App\Models\Partner::where('id', $partnerId)->get(); // Only show current partner

        $stats = [
            'total_users' => EnhancedUser::where('partner_id', $partnerId)->count(), // Only count users from current partner
            'active_users' => EnhancedUser::where('status', EnhancedUser::STATUS_ACTIVE)->where('partner_id', $partnerId)->count(),
            'inactive_users' => EnhancedUser::where('status', EnhancedUser::STATUS_INACTIVE)->where('partner_id', $partnerId)->count(),
            'suspended_users' => EnhancedUser::where('status', EnhancedUser::STATUS_SUSPENDED)->where('partner_id', $partnerId)->count(),
            'pending_users' => EnhancedUser::where('status', EnhancedUser::STATUS_PENDING)->where('partner_id', $partnerId)->count(),
            'users_by_role' => EnhancedUser::join('ac_roles', 'ac_users.role_id', '=', 'ac_roles.id')
                ->where('ac_users.partner_id', $partnerId) // Only count users from current partner
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
        // (students not present in ac_users table)
        $students = \App\Models\Student::where('partner_id', $partnerId)
            ->where(function($query) {
                // Students where user_id is null or points to non-existent user
                $query->whereNull('user_id')
                      ->orWhere(function($subquery) {
                          $subquery->whereNotNull('user_id')
                                   ->whereNotExists(function($existsQuery) {
                                       $existsQuery->select(DB::raw(1))
                                                   ->from('ac_users')
                                                   ->whereColumn('ac_users.id', 'students.user_id');
                                   });
                      })
                      // Also check that no user has this student_id
                      ->whereNotExists(function($subquery) {
                          $subquery->select(DB::raw(1))
                                   ->from('ac_users')
                                   ->whereColumn('ac_users.student_id', 'students.id');
                      });
            })
            ->orderBy('full_name')
            ->get();

        // Debug: Log detailed information
        \Log::info('UserManagementController create method - Student query details', [
            'partner_id' => $partnerId,
            'total_students_in_partner' => \App\Models\Student::where('partner_id', $partnerId)->count(),
            'students_without_users_count' => $students->count(),
            'students_without_users_ids' => $students->pluck('id')->toArray(),
            'students_without_users_details' => $students->map(function($student) {
                return [
                    'id' => $student->id,
                    'full_name' => $student->full_name,
                    'user_id' => $student->user_id,
                    'user_exists' => $student->user_id ? EnhancedUser::find($student->user_id) ? true : false : null
                ];
            })->toArray()
        ]);

        return view('partner.settings.create-student-login', compact('students'));
    }

    /**
     * Show the form for creating a new teacher user.
     */
    public function createTeacher()
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

        // Get teachers from current partner who don't have user accounts yet
        // (teachers not present in ac_users table)
        $teachers = \App\Models\Teacher::where('partner_id', $partnerId)
            ->where(function($query) {
                // Teachers where user_id is null or points to non-existent user
                $query->whereNull('user_id')
                      ->orWhere(function($subquery) {
                          $subquery->whereNotNull('user_id')
                                   ->whereNotExists(function($existsQuery) {
                                       $existsQuery->select(DB::raw(1))
                                                   ->from('ac_users')
                                                   ->whereColumn('ac_users.id', 'teachers.user_id');
                                   });
                      });
            })
            ->orderBy('full_name')
            ->get();

        return view('partner.settings.create-teacher-login', compact('teachers'));
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
                'role_name' => 'exists:ac_roles,name', // Role is optional, defaults to 'student'
                'user_type' => 'required|in:student,other',
            ], [
                'student_id.required' => 'Please select a student.',
                'student_id.exists' => 'The selected student is invalid.',
                'password.required' => 'Password is required.',
                'password.min' => 'Password must be at least 8 characters.',
                'password.confirmed' => 'Password confirmation does not match.',
                'role_name.exists' => 'The selected role is invalid.',
                'user_type.required' => 'User type is required.',
                'user_type.in' => 'Invalid user type selected.',
            ]);
            
            // Log the validated data for debugging
            \Log::info('Creating user with validated data:', [
                'student_id' => $validated['student_id'],
                'role_name' => $validated['role_name'],
                'user_type' => $validated['user_type']
            ]);

            DB::beginTransaction();

            try {
                // Get the student
                $student = \App\Models\Student::findOrFail($validated['student_id']);
                
                // Debug: Log student information
                \Log::info('Student information in store method', [
                    'student_id' => $student->id,
                    'full_name' => $student->full_name,
                    'user_id' => $student->user_id,
                    'user_exists' => $student->user ? true : false,
                    'user_data' => $student->user ? [
                        'id' => $student->user->id,
                        'name' => $student->user->name,
                        'email' => $student->user->email
                    ] : null
                ]);
                
                // Check if student already has a user account
                // First check if student has user_id set AND that user actually exists
                if ($student->user_id && EnhancedUser::find($student->user_id)) {
                    \Log::info('Student already has user account (user_id set and user exists)', [
                        'student_id' => $student->id,
                        'user_id' => $student->user_id
                    ]);
                    return response()->json([
                        'success' => false,
                        'message' => 'This student already has a user account.'
                    ], 422);
                }
                
                // Also check if there's a user with this student_id
                $existingUser = EnhancedUser::where('student_id', $student->id)->first();
                if ($existingUser) {
                    \Log::info('Student already has user account (student_id set on user)', [
                        'student_id' => $student->id,
                        'user_id' => $existingUser->id
                    ]);
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
                
                // Get the role by name (more maintainable than hardcoded ID)
                // For students, default to 'student' role if not specified
                $roleName = $validated['role_name'] ?? 'student';
                $selectedRole = EnhancedRole::where('name', $roleName)->first();
                
                if (!$selectedRole) {
                    // If the specified role doesn't exist, default to 'student'
                    $selectedRole = EnhancedRole::where('name', 'student')->first();
                    if (!$selectedRole) {
                        throw new \Exception("Role with name 'student' not found");
                    }
                }
                
                $roleId = $selectedRole->id;
                
                // Create the user
                $user = new EnhancedUser();
                $user->name = $student->full_name;
                $user->email = $student->email ?? strtolower(str_replace(' ', '.', $student->full_name)) . '@example.com';
                $user->phone = $student->phone ?? '';
                $user->password = Hash::make($validated['password']);
                $user->role_id = $roleId;
                $user->role = 'student'; // Set role to student
                $user->partner_id = $this->getPartnerId();
                $user->status = 'active';
                $user->email_verified_at = now();
                $user->created_by = auth()->id();
                $user->updated_by = auth()->id();
                $user->student_id = $student->id; // Set the student_id on the user
                
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
                    'message' => 'Student user created successfully',
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
     * Store a newly created teacher user.
     */
    public function storeTeacher(Request $request)
    {
        try {
            // Validate the request
            $validated = $request->validate([
                'teacher_id' => 'required|exists:teachers,id',
                'password' => 'required|string|min:8|confirmed',
                'role_name' => 'exists:ac_roles,name', // Role is optional for teachers, defaults to 'operator'
                'user_type' => 'required|in:teacher,other',
            ], [
                'teacher_id.required' => 'Please select a teacher.',
                'teacher_id.exists' => 'The selected teacher is invalid.',
                'password.required' => 'Password is required.',
                'password.min' => 'Password must be at least 8 characters.',
                'password.confirmed' => 'Password confirmation does not match.',
                'role_name.exists' => 'The selected role is invalid.',
                'user_type.required' => 'User type is required.',
                'user_type.in' => 'Invalid user type selected.',
            ]);
            
            // Log the validated data for debugging
            \Log::info('Creating teacher user with validated data:', [
                'teacher_id' => $validated['teacher_id'],
                'role_name' => $validated['role_name'],
                'user_type' => $validated['user_type']
            ]);

            DB::beginTransaction();

            try {
                // Get the teacher
                $teacher = \App\Models\Teacher::findOrFail($validated['teacher_id']);
                
                // Debug: Log teacher information
                \Log::info('Teacher information in store method', [
                    'teacher_id' => $teacher->id,
                    'full_name' => $teacher->full_name,
                    'user_id' => $teacher->user_id,
                    'user_exists' => $teacher->user ? true : false,
                    'user_data' => $teacher->user ? [
                        'id' => $teacher->user->id,
                        'name' => $teacher->user->name,
                        'email' => $teacher->user->email
                    ] : null
                ]);
                
                // Check if teacher already has a user account
                // First check if teacher has user_id set AND that user actually exists
                if ($teacher->user_id && EnhancedUser::find($teacher->user_id)) {
                    \Log::info('Teacher already has user account (user_id set and user exists)', [
                        'teacher_id' => $teacher->id,
                        'user_id' => $teacher->user_id
                    ]);
                    return response()->json([
                        'success' => false,
                        'message' => 'This teacher already has a user account.'
                    ], 422);
                }
                
                // Also check if there's a user with this teacher_id
                $existingUser = EnhancedUser::where('teacher_id', $teacher->id)->first();
                if ($existingUser) {
                    \Log::info('Teacher already has user account (teacher_id set on user)', [
                        'teacher_id' => $teacher->id,
                        'user_id' => $existingUser->id
                    ]);
                    return response()->json([
                        'success' => false,
                        'message' => 'This teacher already has a user account.'
                    ], 422);
                }

                // Check if email already exists
                if ($teacher->email && EnhancedUser::where('email', $teacher->email)->exists()) {
                    return response()->json([
                        'success' => false,
                        'message' => 'A user with this email address already exists.'
                    ], 422);
                }
                
                // Get the role by name (more maintainable than hardcoded ID)
                // For teachers, default to 'operator' role if not specified
                $roleName = $validated['role_name'] ?? 'operator';
                $selectedRole = EnhancedRole::where('name', $roleName)->first();
                
                if (!$selectedRole) {
                    // If the specified role doesn't exist, default to 'operator'
                    $selectedRole = EnhancedRole::where('name', 'operator')->first();
                    if (!$selectedRole) {
                        throw new \Exception("Role with name 'operator' not found");
                    }
                }
                
                $roleId = $selectedRole->id;
                
                // Create the user
                $user = new EnhancedUser();
                $user->name = $teacher->full_name;
                $user->email = $teacher->email ?? strtolower(str_replace(' ', '.', $teacher->full_name)) . '@example.com';
                $user->phone = $teacher->phone ?? '';
                $user->password = Hash::make($validated['password']);
                $user->role_id = $roleId;
                $user->role = 'operator'; // Set role to operator for teachers
                $user->partner_id = $this->getPartnerId();
                $user->status = 'active';
                $user->email_verified_at = now();
                $user->created_by = auth()->id();
                $user->updated_by = auth()->id();
                // Set the teacher_id on the user
                $user->teacher_id = $teacher->id;
                
                // Save the user with error handling
                if (!$user->save()) {
                    throw new \Exception('Failed to save user');
                }
                
                // Update the teacher record to link to the user
                $teacher->user_id = $user->id;
                $teacher->save();

                DB::commit();

                return response()->json([
                    'success' => true,
                    'message' => 'Teacher user created successfully',
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
                
                \Log::error('Error creating teacher user: ' . $e->getMessage(), [
                    'exception' => $e,
                    'trace' => $e->getTraceAsString()
                ]);
                
                return response()->json([
                    'success' => false,
                    'message' => 'Error creating teacher user: ' . $e->getMessage()
                ], 500);
            }
        } catch (\Illuminate\Validation\ValidationException $e) {
            \Log::error('Validation error creating teacher user: ' . json_encode($e->errors()), [
                'exception' => $e,
                'trace' => $e->getTraceAsString()
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'Please check the form for errors.',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            \Log::error('Unexpected error creating teacher user: ' . $e->getMessage(), [
                'exception' => $e,
                'trace' => $e->getTraceAsString()
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'An unexpected error occurred while creating the teacher user. Please try again.'
            ], 500);
        }
    }

    /**
     * Display the specified user.
     */
    public function show(EnhancedUser $user)
    {
        // Permission checking disabled
        
        // Ensure user belongs to current partner
        $partnerId = $this->getPartnerId();
        if ($user->partner_id != $partnerId) {
            return response()->json([
                'success' => false,
                'message' => 'User not found.'
            ], 404);
        }

        $user->load(['partner', 'role', 'permissions', 'creator']);

        // Format the user data to match the expected API response
        $userData = $user->toArray();
        $userData['roles'] = $user->role ? [$user->role] : [];

        return response()->json([
            'success' => true,
            'user' => $userData
        ]);
    }

    /**
     * Update the specified user.
     */
    public function update(Request $request, EnhancedUser $user)
    {
        // Permission checking disabled
        
        // Ensure user belongs to current partner
        $partnerId = $this->getPartnerId();
        if ($user->partner_id != $partnerId) {
            return response()->json([
                'success' => false,
                'message' => 'User not found.'
            ], 404);
        }

        // Map status values to flag values
        $statusToFlagMap = [
            'active' => EnhancedUser::FLAG_ACTIVE,
            'inactive' => EnhancedUser::FLAG_INACTIVE,
            'suspended' => EnhancedUser::FLAG_INACTIVE,
            'pending' => EnhancedUser::FLAG_INACTIVE,
        ];

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('ac_users', 'email')->ignore($user->id, 'id')],
            'phone' => 'nullable|string|max:20',
            'password' => 'nullable|string|min:8|confirmed',
            'role_id' => 'required|exists:ac_roles,id',
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

            // Map the status to flag value
            $flagValue = $statusToFlagMap[$request->status] ?? EnhancedUser::FLAG_ACTIVE;

            $updateData = [
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'partner_id' => $request->partner_id,
                'flag' => $flagValue,
                'role_id' => $request->role_id,
                'updated_by' => auth()->id(),
            ];

            if ($request->password) {
                $updateData['password'] = Hash::make($request->password);
            }

            $user->update($updateData);

            // Permission syncing disabled - skip permissions sync
            // $user->permissions()->sync($request->permissions ?? [], [
            //     'granted_by' => auth()->id(),
            //     'granted_at' => now(),
            // ]);

            // Log activity (disabled)
            // $user->activities()->create([
            //     'action' => 'user_updated',
            //     'description' => 'User account updated',
            //     'metadata' => [
            //         'updated_by' => auth()->id(),
            //         'role_id' => $request->role_id,
            //         'permissions' => $request->permissions ?? [],
            //         'changed_fields' => array_keys($request->except(['password', 'password_confirmation'])),
            //     ],
            //     'ip_address' => $request->ip(),
            //     'user_agent' => $request->userAgent(),
            // ]);

            DB::commit();
            
            // Load the updated user with role
            $user->load(['role']);
            
            // Format the user data to match the expected API response
            $userData = $user->toArray();
            $userData['roles'] = $user->role ? [$user->role] : [];
            
            return response()->json([
                'success' => true,
                'message' => 'User updated successfully',
                'user' => $userData
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
     * Get recent user activity.
     */
    public function getRecentActivity()
    {
        // Permission checking disabled
        // Activity logging disabled

        return response()->json([
            'success' => true,
            'activities' => []
        ]);
    }

    /**
     * Update the specified user's status.
     */
    public function updateStatus(Request $request, EnhancedUser $user)
    {
        // Permission checking disabled
        
        // Ensure user belongs to current partner
        $partnerId = $this->getPartnerId();
        if ($user->partner_id != $partnerId) {
            return response()->json([
                'success' => false,
                'message' => 'User not found.'
            ], 404);
        }

        // Map status values to flag values
        $statusToFlagMap = [
            'active' => EnhancedUser::FLAG_ACTIVE,
            'inactive' => EnhancedUser::FLAG_INACTIVE,
            'suspended' => EnhancedUser::FLAG_INACTIVE,
            'pending' => EnhancedUser::FLAG_INACTIVE,
        ];

        // Validate only the status field
        $validator = Validator::make($request->all(), [
            'status' => ['required', Rule::in(EnhancedUser::getStatuses())],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            DB::beginTransaction();

            // Map the status to flag value
            $flagValue = $statusToFlagMap[$request->status] ?? EnhancedUser::FLAG_ACTIVE;

            // Update only the flag column
            $user->update([
                'flag' => $flagValue,
                'updated_by' => auth()->id(),
            ]);

            DB::commit();
            
            return response()->json([
                'success' => true,
                'message' => 'User status updated successfully'
            ]);
            
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('User status update failed: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Failed to update user status: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified user.
     */
    public function destroy(EnhancedUser $user)
    {
        // Permission checking disabled
        
        // Ensure user belongs to current partner
        $partnerId = $this->getPartnerId();
        if ($user->partner_id != $partnerId) {
            return response()->json([
                'success' => false,
                'message' => 'User not found.'
            ], 404);
        }

        try {
            DB::beginTransaction();

            // Log activity before deletion (disabled)
            // $user->activities()->create([
            //     'action' => 'user_deleted',
            //     'description' => 'User account deleted',
            //     'metadata' => [
            //         'deleted_by' => auth()->id(),
            //         'user_data' => [
            //             'name' => $user->name,
            //             'email' => $user->email,
            //             'roles' => $user->role ? [$user->role->id] : [],
            //             'permissions' => $user->permissions->pluck('id')->toArray(),
            //         ],
            //     ],
            //     'ip_address' => request()->ip(),
            //     'user_agent' => request()->userAgent(),
            // ]);

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
                        $user->update(['flag' => EnhancedUser::FLAG_ACTIVE]);
                        $updatedCount++;
                        break;
                    
                    case 'deactivate':
                        $user->update(['flag' => EnhancedUser::FLAG_INACTIVE]);
                        $updatedCount++;
                        break;
                    
                    case 'suspend':
                        $user->update(['flag' => EnhancedUser::FLAG_INACTIVE]);
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

                // Log activity for each user (disabled)
                // $user->activities()->create([
                //     'action' => 'user_bulk_updated',
                //     'description' => "User bulk action: {$request->action}",
                //     'metadata' => [
                //         'action' => $request->action,
                //         'role_id' => $request->role_id ?? null,
                //         'permission_id' => $request->permission_id ?? null,
                //         'performed_by' => auth()->id(),
                //     ],
                //     'ip_address' => $request->ip(),
                //     'user_agent' => $request->userAgent(),
                // ]);
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
        // Activity logging disabled

        return response()->json([
            'success' => true,
            'activities' => []
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

        if ($user->role) {
            $rolePermissions = $rolePermissions->merge($user->role->getAllPermissions());
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

        $users = EnhancedUser::with(['partner', 'role', 'permissions'])
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
                $query->whereHas('role', function ($q) use ($role) {
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
                'Roles' => $user->role ? $user->role->name : '',
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
            'recent_users' => EnhancedUser::with(['role'])
                ->orderBy('created_at', 'desc')
                ->take(5)
                ->get(),
            'recent_activities' => [],
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
     * Reset user password.
     */
    public function resetPassword(Request $request, EnhancedUser $user)
    {
        // Permission checking disabled
        
        // Ensure user belongs to current partner
        $partnerId = $this->getPartnerId();
        if ($user->partner_id != $partnerId) {
            return response()->json([
                'success' => false,
                'message' => 'User not found.'
            ], 404);
        }

        // Check if user is resetting their own password
        $isCurrentUser = ($user->id == auth()->id());
        
        // Build validation rules
        $rules = [
            'password' => 'required|string|min:8|confirmed',
        ];
        
        // If resetting own password, require current password
        if ($isCurrentUser) {
            $rules['current_password'] = 'required|string';
        }

        // Validate the request
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            // If resetting own password, verify current password first
            if ($isCurrentUser) {
                if (!Hash::check($request->current_password, $user->password)) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Current password is incorrect.',
                        'errors' => [
                            'current_password' => ['The current password is incorrect.']
                        ]
                    ], 422);
                }
            }
            
            // Update user password
            $user->update([
                'password' => Hash::make($request->password)
            ]);

            // Log activity (disabled)
            // $user->activities()->create([
            //     'action' => 'password_reset',
            //     'description' => $isCurrentUser ? 'User changed own password' : 'User password reset by administrator',
            //     'metadata' => [
            //         'reset_by' => auth()->id(),
            //         'self_reset' => $isCurrentUser,
            //     ],
            //     'ip_address' => $request->ip(),
            //     'user_agent' => $request->userAgent(),
            // ]);

            return response()->json([
                'success' => true,
                'message' => 'Password reset successfully.'
            ]);

        } catch (\Exception $e) {
            Log::error('Password reset failed: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Failed to reset password: ' . $e->getMessage()
            ], 500);
        }
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
