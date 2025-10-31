<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Models\EnhancedUser;
use App\Models\Student;
use App\Models\EnhancedRole;

class PublicStudentRegistrationController extends Controller
{
    /**
     * Handle the student registration form submission.
     */
    public function register(Request $request)
    {
        try {
            // Validate the request
            $validated = $request->validate([
                'full_name' => 'required|string|max:255',
                'email' => 'required|email|max:255|unique:students,email|unique:ac_users,email',
                'phone' => 'nullable|string|max:20|unique:students,phone|unique:ac_users,phone',
                'password' => 'required|string|min:8|confirmed',
            ], [
                'full_name.required' => 'Full name is required.',
                'email.required' => 'Email address is required.',
                'email.email' => 'Please enter a valid email address.',
                'email.unique' => 'This email is already registered.',
                'phone.unique' => 'This phone number is already registered.',
                'password.required' => 'Password is required.',
                'password.min' => 'Password must be at least 8 characters.',
                'password.confirmed' => 'Password confirmation does not match.',
            ]);
            
            DB::beginTransaction();

            try {
                // Get the student role
                $studentRole = EnhancedRole::where('name', 'student')->first();
                
                if (!$studentRole) {
                    throw new \Exception("Student role not found");
                }
                
                // Create the student record with null partner_id (system admin ownership)
                $student = new Student();
                $student->full_name = $validated['full_name'];
                $student->email = $validated['email'];
                $student->phone = $validated['phone'] ?? '';
                $student->partner_id = null; // System admin ownership
                $student->status = 'active';
                $student->enable_login = 'y';
                $student->created_by = 1; // System admin user ID
                
                // Save the student
                if (!$student->save()) {
                    throw new \Exception('Failed to save student');
                }
                
                // Create the user account
                $user = new EnhancedUser();
                $user->name = $validated['full_name'];
                $user->email = $validated['email'];
                $user->phone = $validated['phone'] ?? '';
                $user->password = Hash::make($validated['password']);
                $user->role_id = $studentRole->id;
                $user->role = 'student';
                $user->partner_id = null; // System admin ownership
                $user->status = 'active';
                $user->email_verified_at = now();
                $user->created_by = 1; // System admin user ID
                $user->updated_by = 1; // System admin user ID
                $user->student_id = $student->id; // Link to student record
                
                // Save the user with error handling
                if (!$user->save()) {
                    throw new \Exception('Failed to save user');
                }
                
                // Update the student record to link to the user
                $student->user_id = $user->id;
                $student->save();

                DB::commit();

                return redirect()->route('student.features')->with('success', 'Registration successful! You can now log in to your account.');

            } catch (\Exception $e) {
                DB::rollBack();
                
                // Handle specific database errors
                if (strpos($e->getMessage(), 'Duplicate entry') !== false) {
                    if (strpos($e->getMessage(), 'students_email_unique') !== false || 
                        strpos($e->getMessage(), 'users_email_unique') !== false) {
                        return back()->withErrors(['email' => 'A user with this email address already exists.'])->withInput();
                    }
                    if (strpos($e->getMessage(), 'students_phone_unique') !== false || 
                        strpos($e->getMessage(), 'users_phone_unique') !== false) {
                        return back()->withErrors(['phone' => 'A user with this phone number already exists.'])->withInput();
                    }
                }
                
                \Log::error('Error creating public student registration: ' . $e->getMessage(), [
                    'exception' => $e,
                    'trace' => $e->getTraceAsString()
                ]);
                
                return back()->withErrors(['error' => 'Error creating account. Please try again.'])->withInput();
            }
        } catch (\Illuminate\Validation\ValidationException $e) {
            \Log::error('Validation error creating public student registration: ' . json_encode($e->errors()), [
                'exception' => $e,
                'trace' => $e->getTraceAsString()
            ]);
            
            return back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            \Log::error('Unexpected error creating public student registration: ' . $e->getMessage(), [
                'exception' => $e,
                'trace' => $e->getTraceAsString()
            ]);
            
            return back()->withErrors(['error' => 'An unexpected error occurred while creating the account. Please try again.'])->withInput();
        }
    }
}