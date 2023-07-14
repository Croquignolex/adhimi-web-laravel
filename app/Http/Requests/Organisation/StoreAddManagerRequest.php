<?php

namespace App\Http\Requests\Organisation;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreAddManagerRequest extends FormRequest
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
            'shop' => [
                'required',
                Rule::exists('shops', 'id')
                    ->where('organisation_id', $this->organisation->id)
            ],
            'name' => "required|string|unique:users,name",
            'email' => "required|email|unique:users,email",
            'description' => "nullable|string",
        ];
    }
}
