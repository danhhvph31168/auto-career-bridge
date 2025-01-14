<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Workshop>
 */
class WorkshopFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'university_id' => rand(1, 5),
            'title' => fake()->title(),
            'address' => fake()->address(),
            'requirement' => fake()->text(50),
            'description' => fake()->text(50),
            'start_date' => fake()->dateTime(),
            'end_date' => fake()->dateTime(),
            'slug' => fake()->slug(20),
        ];
    }
}
