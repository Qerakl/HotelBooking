<?php

namespace Database\Factories;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Booking>
 */
class BookingFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'check_in_date' =>  $checkInDate = Carbon::parse($this->faker->date()),
            'check_out_date' => $checkInDate->copy()->addDays(rand(1, 5)),
            'status' => $this->faker->randomElement(['confirmed', 'unconfirmed']),
            'user_id' => User::factory(),
        ];
    }
}
