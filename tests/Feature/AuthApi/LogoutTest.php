<?php

namespace Tests\Feature\AuthApi;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;
use Tymon\JWTAuth\Facades\JWTAuth;

class LogoutTest extends TestCase
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
     * Тест на выход из системы для авторизованного пользователя.
     */
    public function test_logout_with_authorized_user()
    {
        $token = JWTAuth::fromUser($this->user);

        $response = $this->post('api/auth/logout', [], [
            'Authorization' => 'Bearer ' . $token,
        ]);

        $response->assertStatus(200);
        $response->assertJson(['message' => 'Successfully logged out']);
    }

    /**
     * Тест на выход из системы без авторизации.
     */
    public function test_logout_without_authorization()
    {
        $response = $this->post('api/auth/logout');

        $response->assertStatus(302);
    }
}
