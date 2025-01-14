<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Enterprise>
 */
class EnterpriseFactory extends Factory
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
            'logo' => 'https://static.vecteezy.com/system/resources/previews/003/658/606/non_2x/linear-enterprise-icon-design-template-illustration-free-vector.jpg',
            'email' => fake()->unique()->safeEmail(),
            'phone' => rand(1, 99999999),
            'address' => fake()->address(),
            'tax_code' => fake()->countryCode(),
            'size' => 100,
            'introduce' => fake()->text(50),
            'industry' => fake()->text(50),
            'description' => fake()->text(50),
            'url' => fake()->url(),
            'slug' => fake()->unique()->slug(),
        ];
    }
}
