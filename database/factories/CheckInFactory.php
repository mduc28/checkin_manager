<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\CheckIn>
 */
class CheckInFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'member_id' => fake()->numberBetween(1, 2000),
            'created_at' => fake()->dateTimeBetween('-2 month', 'now'),
        ];
    }

    /**
     * Define the name of the factory.
     *
     * @return string
     */
    public function name()
    {
        return 'checkin';
    }
}
