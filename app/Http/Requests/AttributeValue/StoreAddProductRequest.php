<?php

namespace App\Http\Requests\AttributeValue;

use Illuminate\Foundation\Http\FormRequest;

class StoreAddProductRequest extends FormRequest
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
            'name' => "required|string",
            'description' => "nullable|string",
        ];
    }
}
