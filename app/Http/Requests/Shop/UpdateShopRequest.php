<?php

namespace App\Http\Requests\Shop;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateShopRequest extends FormRequest
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
                Rule::unique('shops', 'name')
                    ->where('organisation_id', $this->input('organisation'))
                    ->ignore($this->shop)
            ],
            'organisation' => "required|string|exists:organisations,id",
            'description' => "nullable|string",
        ];
    }
}
