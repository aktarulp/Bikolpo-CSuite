<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\EnhancedRole;

abstract class TestCase extends BaseTestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        // Ensure the 'Partner' role exists for tests
        EnhancedRole::firstOrCreate(
            ['name' => 'Partner'],
            ['display_name' => 'Partner', 'description' => 'Partner User']
        );
    }
}
