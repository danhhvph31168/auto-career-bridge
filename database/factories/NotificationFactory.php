<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Notification>
 */
class NotificationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'sender_id' => rand(1, 2),
            'receiver_id' => rand(3, 5),
            'type' => rand(0,3),
            'title' => fake()->title(),
            'message' => fake()->text(10),
        ];
    }
}
