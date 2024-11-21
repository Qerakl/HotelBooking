<?php

namespace Tests\Feature\BookingApi;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class StoreBookingTest extends TestCase
{
    use RefreshDatabase, WithFaker;

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
     * Тест успешного создания booking.
     *
     * @return void
     */
    public function test_successful_booking(){
        $response = $this->post(route('booking.store'), [
            'check_in_date' => '2030-01-01',
            'check_out_date' => '2030-01-05',
        ]);

        $response->assertStatus(201);
        $this->assertDatabaseHas('bookings', [
            'check_in_date' => '2030-01-01',
            'user_id' => $this->user->id,
        ]);
    }



}
