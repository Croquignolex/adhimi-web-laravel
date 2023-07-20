<?php

namespace App\Http\Requests\Attribute;

use Illuminate\Foundation\Http\FormRequest;
use App\Enums\AttributeTypeEnum;
use Illuminate\Validation\Rule;

class UpdateAttributeRequest extends FormRequest
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
        $types = AttributeTypeEnum::stringify();

        return [
            'name' => ['required', 'string', Rule::unique('attributes', 'name')->ignore($this->attribute)],
            'type' => "required|in:$types",
            'description' => "nullable|string",
        ];
    }
}
