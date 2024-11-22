<?php

namespace Tests\Feature\BookingApi;

use App\Models\Booking;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class FilterBookingTest extends TestCase
{
    use RefreshDatabase;

    protected $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create([
            'password' => Hash::make('password'),
        ]);
    }

    /**
     * Тест успешной фильтрации бронирований по статусу.
     */
    public function test_filter_bookings_by_status()
    {
        Booking::factory()->count(5)->create(['status' => 'confirmed']);
        Booking::factory()->count(3)->create(['status' => 'pending']);

        $this->actingAs($this->user);

        $response = $this->postJson(route('booking.filter'), ['status' => 'confirmed']);

        $response->assertStatus(200);
        $response->assertJsonCount(5, 'data');
    }

    /**
     * Тест ошибки, если статус не указан.
     */
    public function test_filter_bookings_without_status()
    {
        $this->actingAs($this->user);

        $response = $this->postJson(route('booking.filter'), []);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['status']);
    }

    /**
     * Тест ошибки для неавторизованного пользователя.
     */
    public function test_filter_bookings_unauthorized()
    {
        $response = $this->postJson(route('booking.filter'), ['status' => 'confirmed']);

        $response->assertStatus(401);
    }
}
