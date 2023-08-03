<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreMerchantRequest extends FormRequest
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
            'organisation' => [
                'required',
                Rule::exists('organisations', 'id')
            ],
            'name' => "required|string|unique:users,name",
            'email' => "required|email|unique:users,email",
            'phone' => "nullable|string",
            'description' => "nullable|string",
        ];
    }
}
