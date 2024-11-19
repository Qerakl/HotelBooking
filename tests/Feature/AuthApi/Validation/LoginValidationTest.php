<?php

namespace Tests\Feature\AuthApi\Validation;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class LoginValidationTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /**
     * Тест валидации на пустой email.
     *
     * @return void
     */

    public function test_login_validation_with_empty_email(){

        $response = $this->post('/api/auth/login', [
            'email' => '',
            'password' => 'password'
        ]);

        $response->assertStatus(302);
        $response->assertSessionHasErrors('email');
    }
    /**
     * Тест валидации на пустой пароль.
     *
     * @return void
     */
    public function test_login_validation_with_empty_password(){
        $user = User::factory()->create();
        $response = $this->post('/api/auth/login', [
            'email' => $user->email,
            'password' => ''
        ]);

        $response->assertStatus(302);
        $response->assertSessionHasErrors('password');
    }


}
