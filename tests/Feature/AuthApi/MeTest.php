<?php

namespace Tests\Feature\AuthApi;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class MeTest extends TestCase
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
     * Тест на получение информации о текущем авторизованном пользователе.
     */
    public function test_me_with_authorized_user()
    {
        $this->actingAs($this->user);

        $response = $this->post('api/auth/me');

        $response->assertStatus(200);
        $response->assertJson([
            'id' => $this->user->id,
            'email' => $this->user->email,
            'name' => $this->user->name,
        ]);
    }

    /**
     * Тест на попытку получить информацию о пользователе без авторизации.
     */
    public function test_me_without_authorization()
    {
        $response = $this->post('api/auth/me');

        $response->assertStatus(302);
    }
}
