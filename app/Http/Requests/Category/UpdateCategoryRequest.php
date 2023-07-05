<?php

namespace App\Http\Requests\Category;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateCategoryRequest extends FormRequest
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
            'name' => [
                'required', 'string',
                Rule::unique('categories', 'name')
                    ->where('group_id', $this->input('group'))
                    ->ignore($this->category)
            ],
            'group' => "required|string|exists:groups,id",
            'description' => "nullable|string",
            'seo_title' => "nullable|string",
            'seo_description' => "nullable|string",
        ];
    }
}
