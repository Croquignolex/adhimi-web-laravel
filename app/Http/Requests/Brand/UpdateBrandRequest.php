<?php

namespace App\Http\Requests\Brand;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateBrandRequest extends FormRequest
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
            'name' => ['required', 'string', Rule::unique('brands', 'name')->ignore($this->brand)],
            'website' => "nullable|string",
            'description' => "nullable|string",
            'seo_title' => "nullable|string",
            'seo_description' => "nullable|string",
        ];
    }
}
