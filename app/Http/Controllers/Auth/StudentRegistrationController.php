<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Student;
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
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users|unique:students',
            'phone' => 'required|string|max:20|unique:users|unique:students',
            'date_of_birth' => 'required|date|before:today',
            'gender' => 'required|string|in:male,female,other',
            'address' => 'nullable|string|max:500',
            'city' => 'nullable|string|max:100',
            'school_college' => 'nullable|string|max:255',
            'class_grade' => 'nullable|string|max:100',
            'parent_name' => 'nullable|string|max:255',
            'parent_phone' => 'nullable|string|max:20',
            'password' => 'required|string|min:8|confirmed',
        ], [
            'date_of_birth.before' => 'Date of birth must be in the past.',
            'email.unique' => 'This email is already registered.',
            'phone.unique' => 'This phone number is already registered.',
            'gender.in' => 'Please select a valid gender.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            DB::beginTransaction();

            // Create user account
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'password' => Hash::make($request->password),
                'role' => 'student',
                'email_verified_at' => now(), // Auto-verify for students
            ]);

            Log::info('User created successfully', [
                'user_id' => $user->id,
                'user_email' => $user->email,
                'user_role' => $user->role,
            ]);

            // Create student record
            $student = Student::create([
                'full_name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'date_of_birth' => $request->date_of_birth,
                'gender' => $request->gender,
                'address' => $request->address,
                'city' => $request->city,
                'school_college' => $request->school_college,
                'class_grade' => $request->class_grade,
                'parent_name' => $request->parent_name,
                'parent_phone' => $request->parent_phone,
                'status' => 'active',
            ]);

            Log::info('Student record created successfully', [
                'student_id' => $student->id,
                'user_id' => $user->id,
                'full_name' => $student->full_name,
            ]);

            DB::commit();

            // Auto-login the user
            auth()->login($user);

            Log::info('Student registration completed successfully', [
                'user_id' => $user->id,
                'email' => $user->email,
                'is_authenticated' => auth()->check()
            ]);

            return redirect()->route('student.dashboard')
                ->with('success', 'Registration completed successfully! Welcome to বিকল্প কম্পিউটার.');

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
