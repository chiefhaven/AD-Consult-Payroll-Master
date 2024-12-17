<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateAdministratorRequest extends FormRequest
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
            'first_name' => 'required|string|max:255',
            'middle_name' => 'nullable|string|max:255',
            'sirname' => 'required|string|max:255',
            'phone' => 'required|string|max:15',
            'alt_phone' => 'nullable|string|max:15',
            'street_address' => 'nullable|string|max:255',
            'district' => 'nullable|string|max:255',
            'country' => 'nullable|string|max:255',
            'department' => 'nullable|string|max:255',
            'role' => 'nullable|string|max:255',
            'is_active' => 'required|boolean',
        ];
    }

}
