<?php

namespace Tests\Feature\BookingApi;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class StoreBookingValidationTest extends TestCase
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
        $response = $this->post(route('booking.store'), []);

        $response->assertStatus(302);
        $response->assertSessionHasErrors(['check_in_date', 'check_out_date']);
        $this->assertDatabaseCount('bookings', 0);
    }

    /**
     * Тест валидации формата даты.
     */
    public function test_validation_date_format()
    {
        $response = $this->post(route('booking.store'), [
            'check_in_date' => 'invalid-date',
            'check_out_date' => 'invalid-date',
        ]);

        $response->assertStatus(302);
        $response->assertSessionHasErrors(['check_in_date', 'check_out_date']);
        $this->assertDatabaseCount('bookings', 0);
    }

    /**
     * Тест валидации дата заезда должна быть не раньше сегодняшнего дня.
     */
    public function test_validation_check_in_date_not_past()
    {
        $response = $this->post(route('booking.store'), [
            'check_in_date' => '2020-01-01',
            'check_out_date' => '2030-01-01',
        ]);

        $response->assertStatus(302);
        $response->assertSessionHasErrors(['check_in_date']);
        $this->assertDatabaseCount('bookings', 0);
    }

    /**
     * Тест валидации дата выезда должна быть позже даты заезда.
     */
    public function test_validation_check_out_after_check_in()
    {
        $response = $this->post(route('booking.store'), [
            'check_in_date' => '2030-01-05',
            'check_out_date' => '2030-01-01',
        ]);

        $response->assertStatus(302);
        $response->assertSessionHasErrors(['check_out_date']);
        $this->assertDatabaseCount('bookings', 0);
    }
}
