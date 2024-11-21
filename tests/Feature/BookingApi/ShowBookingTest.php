<?php

namespace Tests\Feature\BookingApi;

use App\Models\Booking;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class ShowBookingTest extends TestCase
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
     * Тест на успешное получение данных бронирования при авторизованном пользователе.
     */
    public function test_show_with_authorized_user()
    {
        $booking = Booking::factory()->create(['user_id' => $this->user->id]);

        // Авторизуем пользователя
        $this->actingAs($this->user);

        $response = $this->get(route('booking.show', $booking->id));

        $response->assertStatus(200);
        $response->assertJson([
            'id' => $booking->id,
        ]);
    }

    /**
     * Тест на доступ к данным бронирования без авторизации.
     */
    public function test_show_without_authorization()
    {
        $booking = Booking::factory()->create(['user_id' => $this->user->id]);

        // Отправляем GET запрос без авторизации
        $response = $this->get(route('booking.show', $booking->id));

        $response->assertStatus(302);
    }

    /**
     * Тест на доступ к чужому бронированию.
     */
    public function test_show_with_invalid_user()
    {
        $anotherUser = User::factory()->create();
        $booking = Booking::factory()->create(['user_id' => $this->user->id]);

        // Авторизуем другого пользователя
        $this->actingAs($anotherUser);

        $response = $this->get(route('booking.show', $booking->id));

        $response->assertStatus(403);
    }
}
