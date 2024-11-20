<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterUserRequest extends FormRequest
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
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed|max:255',
            'password_confirmation' => 'required|string|min:6|same:password|max:255',
        ];
    }
    public function messages(): array
    {
        return [
            'name.required' => 'Поле "Имя" обязательно для заполнения.',
            'name.string' => 'Поле "Имя" должно быть строкой.',
            'name.max' => 'Имя не должно превышать 255 символов.',

            'email.required' => 'Поле "Email" обязательно для заполнения.',
            'email.string' => 'Поле "Email" должно быть строкой.',
            'email.email' => 'Введите правильный адрес электронной почты.',
            'email.max' => 'Email не должен превышать 255 символов.',
            'email.unique' => 'Этот email уже используется. Пожалуйста, выберите другой.',

            'password.required' => 'Поле "Пароль" обязательно для заполнения.',
            'password.string' => 'Пароль должен быть строкой.',
            'password.min' => 'Пароль должен содержать минимум 6 символов.',
            'password.confirmed' => 'Пароль и подтверждение пароля не совпадают.',
            'password.max' => 'Пароль не должно превышать 255 символов.',

            'password_confirmation.required' => 'Поле "Подтверждение пароля" обязательно для заполнения.',
            'password_confirmation.string' => 'Подтверждение пароля должно быть строкой.',
            'password_confirmation.min' => 'Подтверждение пароля должно содержать минимум 6 символов.',
            'password_confirmation.same' => 'Подтверждение пароля должно совпадать с паролем.',
            'password_confirmation.max' => 'Подтвержение пароля не должно превышать 255 символов.',
        ];
    }
}
