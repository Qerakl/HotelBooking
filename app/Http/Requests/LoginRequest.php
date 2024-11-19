<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'email' => 'required|email|exists:users,email|max:255|string',
            'password' => 'required|string|min:6|max:255',
        ];
    }

    public function messages()
    {
        return [
            'email.required' => 'Поле email обязательно для заполнения.',
            'email.email' => 'Введите корректный адрес электронной почты.',
            'email.exists' => 'Пользователь с указанным email не найден.',
            'email.max' => 'Email не должен превышать 255 символов.',
            'password.required' => 'Поле пароль обязательно для заполнения.',
            'password.string' => 'Пароль должен быть строкой.',
            'password.min' => 'Пароль должен содержать не менее 6 символов.',
            'password.max' => 'Пароль не должен превышать 255 символов.',
        ];
    }
}
