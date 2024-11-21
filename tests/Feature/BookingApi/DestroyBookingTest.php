<?php

namespace Tests\Feature\BookingApi;

use App\Models\Booking;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class DestroyBookingTest extends TestCase
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
     * Тест на успешное удаление бронирования для авторизованного пользователя.
     */
    public function test_destroy_with_authorized_user()
    {
        $booking = Booking::factory()->create(['user_id' => $this->user->id]);


        $this->actingAs($this->user);

        $response = $this->delete(route('booking.destroy', $booking->id));


        $response->assertStatus(200);
        $this->assertDatabaseMissing('bookings', ['id' => $booking->id]);
    }

    /**
     * Тест на попытку удалить чужое бронирование.
     */
    public function test_destroy_with_invalid_user()
    {
        $anotherUser = User::factory()->create();
        $booking = Booking::factory()->create(['user_id' => $this->user->id]);

        $this->actingAs($anotherUser);

        $response = $this->delete(route('booking.destroy', $booking->id));


        $response->assertStatus(403);
    }

    /**
     * Тест на попытку удалить бронирование без авторизации.
     */
    public function test_destroy_without_authorization()
    {
        $booking = Booking::factory()->create(['user_id' => $this->user->id]);

        // Отправляем DELETE запрос без авторизации
        $response = $this->delete(route('booking.destroy', $booking->id));

        $response->assertStatus(302);
    }
}
