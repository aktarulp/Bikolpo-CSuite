<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = [
            [
                'name' => 'partner',
                'display_name' => 'Educational Partner',
                'description' => 'Educational institutions, coaching centers, and training organizations',
            ],
            [
                'name' => 'student',
                'display_name' => 'Student',
                'description' => 'Individual students using the platform for learning',
            ],
        ];

        foreach ($roles as $role) {
            Role::updateOrCreate(
                ['name' => $role['name']],
                $role
            );
        }
    }
}
