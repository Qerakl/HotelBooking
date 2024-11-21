<?php

namespace Tests\Feature\BookingApi\Validation;

use App\Models\Booking;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class UpdateBookingValidationTest extends TestCase
{
    use RefreshDatabase;

    protected $user;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create([
            'password' => Hash::make('password'),
        ]);

        $this->actingAs($this->user);
    }

    /**
     * Тест валидации обязательных полей.
     */
    public function test_validation_requires_fields()
    {
        $booking = Booking::factory()->create(['user_id' => $this->user->id]);

        $response = $this->put(route('booking.update', $booking->id), []);

        $response->assertStatus(302);
        $response->assertSessionHasErrors(['check_in_date', 'check_out_date']);
        $this->assertDatabaseHas('bookings', [
            'id' => $booking->id,
            'check_in_date' => $booking->check_in_date,
            'check_out_date' => $booking->check_out_date,
        ]);
    }

    /**
     * Тест валидации формата даты.
     */
    public function test_validation_date_format()
    {
        $booking = Booking::factory()->create(['user_id' => $this->user->id]);

        $response = $this->put(route('booking.update', $booking->id), [
            'check_in_date' => 'invalid-date',
            'check_out_date' => 'invalid-date',
        ]);

        $response->assertStatus(302);
        $response->assertSessionHasErrors(['check_in_date', 'check_out_date']);
        $this->assertDatabaseHas('bookings', [
            'id' => $booking->id,
            'check_in_date' => $booking->check_in_date,
            'check_out_date' => $booking->check_out_date,
        ]);
    }

    /**
     * Тест валидации дата заезда не может быть раньше сегодняшнего дня.
     */
    public function test_validation_check_in_date_not_past()
    {
        $booking = Booking::factory()->create(['user_id' => $this->user->id]);

        $response = $this->put(route('booking.update', $booking->id), [
            'check_in_date' => '2020-01-01',
            'check_out_date' => '2030-01-01',
        ]);

        $response->assertStatus(302);
        $response->assertSessionHasErrors(['check_in_date']);
        $this->assertDatabaseHas('bookings', [
            'id' => $booking->id,
            'check_in_date' => $booking->check_in_date,
            'check_out_date' => $booking->check_out_date,
        ]);
    }

    /**
     * Тест валидации дата выезда должна быть позже даты заезда.
     */
    public function test_validation_check_out_after_check_in()
    {
        $booking = Booking::factory()->create(['user_id' => $this->user->id]);

        $response = $this->put(route('booking.update', $booking->id), [
            'check_in_date' => '2030-01-05',
            'check_out_date' => '2030-01-01',
        ]);

        $response->assertStatus(302);
        $response->assertSessionHasErrors(['check_out_date']);
        $this->assertDatabaseHas('bookings', [
            'id' => $booking->id,
            'check_in_date' => $booking->check_in_date,
            'check_out_date' => $booking->check_out_date,
        ]);
    }
}
