<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Partner;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;

class PartnerRegistrationTest extends TestCase
{
    use RefreshDatabase;

    public function test_partner_registration_sends_otp()
    {
        $response = $this->withoutMiddleware()
            ->post('/register', [
            'name' => 'Test Institute',
            'email' => 'test@institute.com',
            'organization_type' => 'Coaching',
            'password' => 'password123',
            'password_confirmation' => 'password123',
            'register_type' => 'partner',
        ]);

        $response->assertRedirect('/verify-otp');

        // Check that verification code was created
        $this->assertDatabaseHas('verification_codes', [
            'email' => 'test@institute.com',
            'type' => 'registration',
            'used' => false,
        ]);

        // Check that user was NOT created yet
        $this->assertDatabaseMissing('users', [
            'email' => 'test@institute.com',
        ]);

        // Check that partner was NOT created yet
        $this->assertDatabaseMissing('partners', [
            'email' => 'test@institute.com',
        ]);
    }

    public function test_otp_verification_creates_user_and_partner()
    {
        // First register to get OTP
        $this->withoutMiddleware()
            ->post('/register', [
            'name' => 'Test Institute',
            'email' => 'test@institute.com',
            'organization_type' => 'Coaching',
            'password' => 'password123',
            'password_confirmation' => 'password123',
            'register_type' => 'partner',
        ]);

        // Get the verification code from database
        $verificationCode = \App\Models\VerificationCode::where('email', 'test@institute.com')->first();
        $this->assertNotNull($verificationCode, 'Verification code should be created');
        
        // Verify OTP
        $response = $this->withoutMiddleware()
            ->post('/verify-otp', [
            'email' => 'test@institute.com',
            'otp' => $verificationCode->code,
        ]);

        $response->assertRedirect('/login');

        // Check that user was created
        $this->assertDatabaseHas('users', [
            'name' => 'Test Institute',
            'email' => 'test@institute.com',
            'role' => 'partner',
        ]);

        $user = User::where('email', 'test@institute.com')->first();
        $this->assertNotNull($user);

        // Check that partner was created
        $this->assertDatabaseHas('partners', [
            'name' => 'Test Institute',
            'email' => 'test@institute.com',
            'user_id' => $user->id,
            'partner_category' => 'Coaching',
            'status' => 'active',
        ]);

        $partner = Partner::where('email', 'test@institute.com')->first();
        $this->assertNotNull($partner);

        // Check relationship
        $this->assertEquals($user->id, $partner->user_id);
        $this->assertEquals($partner->id, $user->partner->id);

        // Check that verification code was marked as used
        $this->assertDatabaseHas('verification_codes', [
            'email' => 'test@institute.com',
            'used' => true,
        ]);
    }


}
