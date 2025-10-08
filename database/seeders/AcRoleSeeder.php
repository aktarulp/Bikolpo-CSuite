<?php

namespace Database\Seeders;

use App\Models\EnhancedRole;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AcRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = [
            ['name' => 'student', 'display_name' => 'Student', 'level' => 2, 'is_system' => true],
        ];

        foreach ($roles as $roleData) {
            EnhancedRole::firstOrCreate(['name' => $roleData['name']], $roleData);
        }
    }
}
