<?php

namespace App\Http\Requests\AttributeValue;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateAttributeValueRequest extends FormRequest
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
                Rule::unique('attribute_values', 'name')
                    ->where('attribute_id', $this->input('attribute'))
                    ->ignore($this->attributeValue)
            ],
            'attribute' => "required|string|exists:attributes,id",
            'value' => "required|string",
            'description' => "nullable|string",
        ];
    }
}
