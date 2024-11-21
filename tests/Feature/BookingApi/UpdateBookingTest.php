<?php

namespace Tests\Feature\BookingApi;

use App\Models\Booking;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class UpdateBookingTest extends TestCase
{
    use RefreshDatabase;

    protected $user;

    protected function setUp(): void
    {
        parent::setUp();

        // Создаем пользователя и авторизуем его
        $this->user = User::factory()->create([
            'password' => Hash::make('password'),
        ]);
        $this->actingAs($this->user);
    }

    /**
     * Тест успешного обновления данных бронирования.
     */
    public function test_successful_booking_update()
    {
        // Создаем тестовую запись бронирования
        $booking = Booking::factory()->create([
            'user_id' => $this->user->id,
            'check_in_date' => '2030-01-01',
            'check_out_date' => '2030-01-05',
        ]);


        $response = $this->put(route('booking.update', $booking->id), [
            'check_in_date' => '2030-02-01',
            'check_out_date' => '2030-02-05',
        ]);

        // Проверяем статус ответа и данные в БД
        $response->assertStatus(200);
        $this->assertDatabaseHas('bookings', [
            'id' => $booking->id,
            'check_in_date' => '2030-02-01',
            'check_out_date' => '2030-02-05',
        ]);
    }
}
