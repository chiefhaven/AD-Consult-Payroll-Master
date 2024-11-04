<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreHolidayRequest extends FormRequest
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
            'description' => 'nullable|string',
            'holiday_type' => 'required|string|in:National,Religious,Other', // specify holiday types
            'date' => 'required|date',
            'recurring' => 'required|boolean',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'The holiday name is required.',
            'name.string' => 'The holiday name must be a string.',
            'holiday_type.required' => 'The holiday type is required.',
            'holiday_type.in' => 'The holiday type must be one of the following: National, Religious, Other.',
            'date.required' => 'The date of the holiday is required.',
            'date.date' => 'The date must be a valid date.',
            'recurring.required' => 'The recurring field is required.',
            'recurring.boolean' => 'The recurring field must be true or false.',
        ];
    }
}
