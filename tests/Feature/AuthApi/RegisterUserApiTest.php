<?php

namespace Tests\Feature\AuthApi;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class RegisterUserApiTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /**
     * тест успешной регистрации пользователя.
     *
     * @return void
     */

    public function test_successful_register(){
        $email = $this->faker->unique()->safeEmail();
        $response = $this->post('/api/auth/register', [
           'name' => $this->faker->name(),
           'email' => $email,
           'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        $response->assertStatus(200);
        $this->assertAuthenticated();
        $this->assertDatabaseHas('users', [
            'email' => $email,
        ]);
    }
}
