<?php

namespace Database\Factories;

use App\Models\Member;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Member>
 */
class MemberFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $code = 'MB' . str_pad(fake()->unique()->numberBetween(1, 9999), 5, '0', STR_PAD_LEFT);
        $currentDate = now();
        $futureDateTime = fake()->dateTimeBetween($currentDate, '+1 years');
        
        return [
            'code' => $code,
            'name' => fake()->name,
            'email' => fake()->unique()->safeEmail,
            'phone' => fake()->unique()->phoneNumber,
            'address' => fake()->city . ' ' . fake()->streetAddress,
            'birthday' => fake()->date(),
            'gender' => fake()->randomElement([1, 2, 3]),
            'expired_date' => $futureDateTime,
            'is_member' => 2,
        ];
    }
}
