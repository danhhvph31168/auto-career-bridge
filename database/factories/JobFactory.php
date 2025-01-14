<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Job>
 */
class JobFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'major_id' => rand(1, 5),
            'enterprise_id' => rand(1, 5),
            'title' => fake()->title(),
            'address' => fake()->address(),
            'requirement' => fake()->text(50),
            'working_time' => '8h - 17h',
            'experience_level' => fake()->title(),
            'benefit' => fake()->text(20),
            'start_date' => fake()->dateTime(),
            'end_date' => fake()->dateTime(),
            'salary' => 1000,
            'slug' => fake()->slug(20),
            'description' => fake()->text(100),
            'type' => fake()->randomElement(['part_time', 'full_time', 'remote']),
        ];
    }
}
