<?php

namespace Tests\Feature\AuthApi;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class LoginUserApiTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create([
            'password' => Hash::make('password'),
        ]);
    }
    /**
     * Тест успешного логина.
     *
     * @return void
     */
    public function test_successful_login(){
        $response = $this->post('/api/auth/login', [
            'email' => $this->user->email,
            'password' => 'password',
        ]);

        $response->assertStatus(200);
        $this->assertAuthenticatedAs($this->user);
    }
    /**
     * тест ошибки не правильного пароля
     *
     * @return void
     */
    public function test_login_with_invalid_password(){
        $response = $this->post('/api/auth/login', [
            'email' => $this->user->email,
            'password' => 'wrong-password',
        ]);

        $response->assertStatus(401);
        $this->assertGuest();
    }

    /**
     * тест ошибки не существующего пользователя.
     *
     * @return void
     */

    public function test_login_with_invalid_email(){
        $response = $this->post('/api/auth/login', [
            'email' => $this->faker->email,
            'password' => 'wrong-password',
        ]);

        $response->assertStatus(302);
        $this->assertGuest();
    }
}
