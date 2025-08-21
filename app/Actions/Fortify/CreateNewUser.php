<?php

namespace App\Actions\Fortify;

use App\Models\User;
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
            'name' => ['nullable', 'string', 'max:255'],
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique(User::class),
            ],
            'password' => $this->passwordRules(),
            'role' => ['nullable', 'string', 'in:student,partner'],
            'phone' => ['nullable', 'string', 'max:20'],
        ])->validate();

        return User::create([
            'name' => $input['name'] ?? null,
            'email' => $input['email'],
            'password' => Hash::make($input['password']),
            'role' => $input['role'] ?? 'student',
            'phone' => $input['phone'] ?? null,
        ]);
    }
}
