<?php

namespace App\Http\Requests\Profile;

use Illuminate\Foundation\Http\FormRequest;
use App\Enums\GenderEnum;

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
        $genders = GenderEnum::stringify();

        return [
            'first_name' => "required|string",
            'last_name' => "nullable|string",
            'profession' => "nullable|string",
            'gender' => "required|in:$genders",
            'birthdate' => "nullable|string",
            'description' => "nullable|string",
        ];
    }
}
