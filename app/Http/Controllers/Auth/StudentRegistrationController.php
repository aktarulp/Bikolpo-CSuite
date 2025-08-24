<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Student;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class StudentRegistrationController extends Controller
{
    public function showRegistrationForm()
    {
        return view('auth.student.register');
    }

    public function register(Request $request)
    {
        Log::info('Student registration attempt', ['request_data' => $request->except(['password', 'password_confirmation'])]);
        
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'role_type' => 'required|string|in:student',
        ], [
            'email.unique' => 'This email is already registered.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            DB::beginTransaction();

            // Get student role
            $studentRole = Role::where('name', 'student')->first();
            if (!$studentRole) {
                throw new \Exception('Student role not found');
            }

            // Create user account
            $user = User::create([
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role_id' => $studentRole->id,
                'email_verified_at' => now(), // Auto-verify for students
                'name' => null, // Will be filled later in profile
                'phone' => null, // Will be filled later in profile
            ]);

            Log::info('User created successfully', [
                'user_id' => $user->id,
                'user_email' => $user->email,
                'user_role' => $user->role,
            ]);

            // Create basic student record (can be completed later)
            $student = Student::create([
                'user_id' => $user->id,
                'status' => 'active',
                // Other fields will be null and can be filled later in profile
            ]);

            Log::info('Student record created successfully', [
                'student_id' => $student->id,
                'user_id' => $user->id,
            ]);

            DB::commit();

            // Logout the user and redirect to login page with success message
            auth()->logout();

            Log::info('Student registration completed successfully', [
                'user_id' => $user->id,
                'email' => $user->email,
                'is_authenticated' => auth()->check()
            ]);

            return redirect()->route('student.login')
                ->with('success', 'Registration completed successfully! You can now login with your email and password.');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Failed to create student account', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return redirect()->back()
                ->withErrors(['email' => 'Registration failed. Please try again.'])
                ->withInput();
        }
    }
}
