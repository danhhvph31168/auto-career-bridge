<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\University>
 */
class UniversityFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'logo' => 'https://cdn-icons-png.flaticon.com/512/158/158245.png',
            'email' => fake()->unique()->safeEmail(),
            'phone' => rand(1, 99999999),
            'address' => fake()->address(),
            'description' => fake()->text(50),
            'url' => fake()->url(),
        ];
    }
}
