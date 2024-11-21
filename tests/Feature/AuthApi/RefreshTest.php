<?php

namespace Tests\Feature\AuthApi;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;
use Tymon\JWTAuth\Facades\JWTAuth;

class RefreshTest extends TestCase
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
     * Тест на обновление токена для авторизованного пользователя.
     */
    public function test_refresh_with_valid_token()
    {
        $token = JWTAuth::fromUser($this->user);

        $response = $this->post('api/auth/refresh', [], [
            'Authorization' => 'Bearer ' . $token,
        ]);

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'access_token',
            'token_type',
            'expires_in',
        ]);
    }

    /**
     * Тест на попытку обновить токен без авторизации.
     */
    public function test_refresh_without_authorization()
    {
        $response = $this->post('api/auth/refresh');

        $response->assertStatus(302);
    }
}
