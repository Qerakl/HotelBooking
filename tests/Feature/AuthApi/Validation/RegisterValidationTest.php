<?php

namespace Tests\Feature\AuthApi\Validation;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RegisterValidationTest extends TestCase
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
        $response->assertSessionHasErrors('name');
        $this->assertDatabaseMissing('users', [
            'email' => 'test1@test.com',
        ]);
    }

    /**
     * Тест валидации на пустой на то что это строка.
     *
     * @return void
     */

    public function test_register_invalid_name_with_not_string_field(){
        $response = $this->post('/api/auth/register', [
            'name' => true,
            'email' => 'test1@test.com',
            'password' => 'password',
        ]);

        $response->assertStatus(302);
        $response->assertSessionHasErrors('name');
        $this->assertDatabaseMissing('users', [
            'email' => 'test1@test.com',
        ]);
    }
    /**
     * Тест валидации на больше 255 символов name.
     *
     * @return void
     */

    public function test_register_invalid_name_with_max_length(){
        $name = $this->faker()->text(900);
        $response = $this->post('/api/auth/register', [
            'name' => $name,
            'email' => 'test1@test.com',
            'password' => 'password',
        ]);

        $response->assertStatus(302);
        $response->assertSessionHasErrors('name');
        $this->assertDatabaseMissing('users', [
            'email' => 'test1@test.com',
        ]);
    }
    /**
     * Тест валидации на пустой email.
     *
     * @return void
     */

    public function test_register_invalid_email_with_empty_field(){
        $response = $this->post('/api/auth/register', [
            'name' => 'Mark123',
            'email' => '',
            'password' => 'password',
        ]);

        $response->assertStatus(302);
        $response->assertSessionHasErrors('email');
        $this->assertDatabaseMissing('users', [
            'name' => 'Mark123',
        ]);
    }

    /**
     * Тест валидации на больше 255 символов email.
     *
     * @return void
     */

    public function test_register_invalid_email_with_max_length(){
        $email = $this->faker()->text(900);
        $response = $this->post('/api/auth/register', [
            'name' => 'Mark123',
            'email' => $email . '@test.com',
            'password' => 'password',
        ]);

        $response->assertStatus(302);
        $response->assertSessionHasErrors('email');
        $this->assertDatabaseMissing('users', [
            'email' => 'test1@test.com',
        ]);
    }

    /**
     * Тест валидации на тип строки email.
     *
     * @return void
     */

    public function test_register_invalid_with_type_email(){
        $response = $this->post('/api/auth/register', [
            'name' => fake()->name(),
            'email' => 'test',
            'password' => 'password',
        ]);

        $response->assertStatus(302);
        $response->assertSessionHasErrors('email');
        $this->assertDatabaseMissing('users', [
            'email' => 'test1@test.com',
        ]);
    }
}
