<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateBookingRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return  $this->booking && $this->booking->user_id === auth()->id();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'check_in_date' => 'required|date|after_or_equal:today',
            'check_out_date' => 'required|date|after:check_in_date',
        ];
    }


    /**
     * Get custom messages for validation errors.
     */
    public function messages(): array
    {
        return [
            'check_in_date.required_without_all' => 'Дата заезда обязательна для заполнения, если не указана дата выезда.',
            'check_out_date.required_without_all' => 'Дата выезда обязательна для заполнения, если не указана дата заезда.',
            'check_in_date.date' => 'Дата заезда должна быть корректной датой.',
            'check_in_date.after_or_equal' => 'Дата заезда не может быть раньше сегодняшнего дня.',
            'check_out_date.date' => 'Дата выезда должна быть корректной датой.',
            'check_out_date.after' => 'Дата выезда должна быть позже даты заезда.',
        ];
    }

}
