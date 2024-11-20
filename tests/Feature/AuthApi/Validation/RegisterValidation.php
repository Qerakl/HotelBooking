<?php

namespace Tests\Feature\AuthApi\Validation;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RegisterValidation extends TestCase
{
    use RefreshDatabase, WithFaker;
    /**
     * Тест валидации на пустой name.
     *
     * @return void
     */

    public function test_register_invalid_name_with_empty_field(){
        $response = $this->post('/api/auth/register', [
            'name' => '',
            'email' => 'test1@test.com',
            'password' => 'password',
        ]);

        $response->assertStatus(302);
        $response->assertJsonValidationErrors('name');
        $this->assertDatabaseMissing('users', [
            'email' => 'test1@test.com',
        ]);
    }
}
