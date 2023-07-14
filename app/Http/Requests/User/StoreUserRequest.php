<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest
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
            'name' => "required|string|unique:organisations,name",
            'email' => "nullable|email",
            'website' => "nullable|string",
            'phone' => "nullable|string",
            'description' => "nullable|string",
            'seo_title' => "nullable|string",
            'seo_description' => "nullable|string",
        ];
    }
}
