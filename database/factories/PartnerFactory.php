<?php

namespace Database\Factories;

use App\Models\Partner;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Partner>
 */
class PartnerFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Partner::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->company(),
            'email' => $this->faker->unique()->safeEmail(),
            'phone' => '01' . $this->faker->numberBetween(300000000, 999999999),
            'address' => $this->faker->streetAddress(),
            'city' => $this->faker->city(),
            'description' => $this->faker->paragraph(),
            'status' => 'active',
            'flag' => 'active',
            'user_id' => User::factory(),
        ];
    }
}
