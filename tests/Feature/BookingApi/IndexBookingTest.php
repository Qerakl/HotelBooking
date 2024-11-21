<?php

namespace Tests\Feature\BookingApi;

use App\Models\Booking;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class IndexBookingTest extends TestCase
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
     * Тест на успешное получение списка бронирований при авторизованном пользователе.
     */
    public function test_index_with_authorized_user()
    {
        Booking::factory()->create(['user_id' => $this->user->id]);
        Booking::factory()->create(['user_id' => $this->user->id]);

        $this->actingAs($this->user);

        $response = $this->get(route('booking.index'));

        $response->assertStatus(200);
        $response->assertJsonCount(13);
    }

    /**
     * Тест на доступ к методам без авторизации.
     */
    public function test_index_without_authorization()
    {
        Booking::factory()->create(['user_id' => $this->user->id]);

        $response = $this->get(route('booking.index'));

        $response->assertStatus(302);
    }
}
