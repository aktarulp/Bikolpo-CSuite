<?php

namespace App\Actions\Fortify;

use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Laravel\Fortify\Contracts\CreatesNewUsers;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    /**
     * Validate and create a newly registered user.
     *
     * @param  array<string, string>  $input
     */
    public function create(array $input): User
    {
        Validator::make($input, [
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique(User::class),
            ],
            'password' => $this->passwordRules(),
            'role_type' => ['nullable', 'string', 'in:student,partner'],
        ])->validate();

        // Determine role based on registration context
        $roleType = $input['role_type'] ?? 'student';
        
        // Get the appropriate role
        $role = Role::where('name', $roleType)->first();
        if (!$role) {
            // Fallback to student role if specified role not found
            $role = Role::where('name', 'student')->first();
        }

        return User::create([
            'email' => $input['email'],
            'password' => Hash::make($input['password']),
            'role_id' => $role->id,
            'name' => null, // Will be filled later in profile
            'phone' => null, // Will be filled later in profile
        ]);
    }
}
