<?php

namespace App\Http\Requests\Profile;

use Illuminate\Foundation\Http\FormRequest;
use App\Enums\LanguageEnum;
use DateTimeZone;

class UpdateSettingsRequest extends FormRequest
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
        $languages = LanguageEnum::stringify();
        $timesZones = implode(',', DateTimeZone::listIdentifiers());

        return [
            'language' => "required|in:$languages",
            'timezone' => "required|in:$timesZones",
            'enable_payement' => 'nullable|string',
            'enable_purchase' => 'nullable|string',
            'enable_product' => 'nullable|string',
            'enable_customer' => 'nullable|string',
            'enable_saler' => 'nullable|string',
            'enable_manager' => 'nullable|string',
            'enable_merchant' => 'nullable|string',
            'enable_admin' => 'nullable|string',
            'enable_super_admin' => 'nullable|string'
        ];
    }
}
