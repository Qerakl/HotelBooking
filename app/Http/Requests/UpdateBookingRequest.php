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
            'check_in_date' => 'sometimes|date|after_or_equal:today',
            'check_out_date' => 'sometimes|date|after:check_in_date',
            'status' => 'sometimes|in:confirmed,unconfirmed',
        ];
    }
    /**
     * Get custom messages for validation errors.
     */
    public function messages(): array
    {
        return [
            'check_in_date.date' => 'Дата заезда должна быть корректной датой.',
            'check_in_date.after_or_equal' => 'Дата заезда не может быть раньше сегодняшнего дня.',
            'check_out_date.date' => 'Дата выезда должна быть корректной датой.',
            'check_out_date.after' => 'Дата выезда должна быть позже даты заезда.',
            'status.in' => 'Статус должен быть либо "confirmed", либо "unconfirmed".',
        ];
    }
}
