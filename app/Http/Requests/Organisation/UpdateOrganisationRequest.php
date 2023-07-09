<?php

namespace App\Http\Requests\Organisation;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateOrganisationRequest extends FormRequest
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
            'name' => ['required', 'string', Rule::unique('organisations', 'name')->ignore($this->organisation)],
            'email' => "nullable|email",
            'website' => "nullable|string",
            'phone' => "nullable|string",
            'description' => "nullable|string",
            'seo_title' => "nullable|string",
            'seo_description' => "nullable|string",
        ];
    }
}
