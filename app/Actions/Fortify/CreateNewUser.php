<?php

namespace App\Actions\Fortify;

use App\Models\User;
use App\Models\Partner;
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
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique(User::class),
            ],
            'password' => $this->passwordRules(),
            'is_partner_registration' => ['boolean'],
            'partner_name' => ['nullable', 'string', 'max:255', 'required_if:is_partner_registration,true'],
            'partner_email' => ['nullable', 'string', 'email', 'max:255', 'unique:partners,email', 'required_if:is_partner_registration,true'],
            'partner_phone' => ['nullable', 'string', 'max:20', 'required_if:is_partner_registration,true'],
            'partner_address' => ['nullable', 'string', 'max:255', 'required_if:is_partner_registration,true'],
        ])->validate();

        $user = User::create([
            'name' => $input['name'],
            'email' => $input['email'],
            'password' => Hash::make($input['password']),
            'status' => 'active', // Default status
        ]);

        if (isset($input['is_partner_registration']) && $input['is_partner_registration']) {
            $partner = Partner::create([
                'name' => $input['partner_name'],
                'email' => $input['partner_email'],
                'phone' => $input['partner_phone'],
                'address' => $input['partner_address'],
                'user_id' => $user->id,
                'status' => 'active', // Default status
            ]);

            $user->partner_id = $partner->id;
            $user->save();

            // Assign 'partner_admin' role
            $partnerAdminRole = Role::where('name', 'partner_admin')->first();
            if ($partnerAdminRole) {
                $user->assignRole($partnerAdminRole->id);
            }
        } else {
            // Assign 'student' role by default for non-partner registrations
            $studentRole = Role::where('name', 'student')->first();
            if ($studentRole) {
                $user->assignRole($studentRole->id);
            }
        }

        return $user;
    }
}
