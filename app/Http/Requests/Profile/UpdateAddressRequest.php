<?php

namespace App\Http\Requests\Profile;

use Illuminate\Foundation\Http\FormRequest;

class UpdateAddressRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'street_address' => "required|string",
            'street_address_plus' => "nullable|string",
            'zipcode' => "nullable|string",
            'phone_number_one' => "nullable|string",
            'phone_number_two' => "nullable|string",
            'country' => "required|string|exists:countries,id",
            'state' => "required|string|exists:states,id",
            'description' => "nullable|string",
        ];
    }
}
