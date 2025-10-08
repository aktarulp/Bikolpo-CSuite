<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\EnhancedUser;
use App\Models\Partner;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;

class PartnerRegistrationTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(\Database\Seeders\RoleSeeder::class);
    }

    public function test_partner_registration_creates_user_and_partner()
    {
        $response = $this->post('/register', [
            'name' => 'Test Institute',
            'email' => 'test@institute.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ]);

        $response->assertRedirect('/');

        // Check that user was created
        $partnerRole = \App\Models\EnhancedRole::where('name', 'partner_admin')->first();
        $this->assertDatabaseHas('ac_users', [
            'name' => 'Test Institute',
            'email' => 'test@institute.com',
            'role_id' => $partnerRole->id,
        ]);

        $user = EnhancedUser::where('email', 'test@institute.com')->first();
        $this->assertNotNull($user);

        // Check that partner was created
        $this->assertDatabaseHas('partners', [
            'organization_name' => 'Test Institute',
            'user_id' => $user->id,
            'status' => 'active',
        ]);

        $partner = Partner::where('user_id', $user->id)->first();
        $this->assertNotNull($partner);

        // Check relationship
        $this->assertEquals($user->id, $partner->user_id);
        $this->assertEquals($partner->id, $user->partner->id);
    }


}
