<?php

namespace App\Http\Requests\Coupon;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateCouponRequest extends FormRequest
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
            'code' => ['required', 'string', Rule::unique('coupons', 'code')->ignore($this->coupon)],
            'discount' => "required|integer|min:1|max:100",
            'promotion_started_at' => "required|date",
            'promotion_ended_at' => "required|date|after:promotion_started_at",
            'description' => "nullable|string",
        ];
    }
}
