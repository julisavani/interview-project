<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Task>
 */
class TaskFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $numbers = [1,2,3];
        $randomIndex = array_rand($numbers);
        return [
            'user_id' => User::inRandomOrder()->first()->id, // Create a related user and get its ID
            'subject' => $this->faker->sentence,
            'description' => $this->faker->paragraph,
            'startDate' => $this->faker->date('Y-m-d'),
            'dueDate' => $this->faker->date('Y-m-d'),
            'priority' => $numbers[$randomIndex],
        ];
    }
}
