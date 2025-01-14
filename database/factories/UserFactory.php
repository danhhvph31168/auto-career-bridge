<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $true = fake()->boolean();

        return [
            'enterprise_id' => $true ? rand(1, 5) : null,
            'university_id' => !$true ? rand(1, 5) : null,
            'role_id' => rand(1, 2),
            'username' => fake()->name(),
            'avatar' => 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQQTgjusLLzb6CoAn1Z1-985mL3nMVBXBlZWA&s',
            'phone' => rand(1, 99999999),
            'user_type' => $true ? 'enterprise' : 'university',
            'email' => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token' => Str::random(10),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     *
     * @return $this
     */
    public function unverified(): static
    {
        return $this->state(fn(array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
