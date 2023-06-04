<?php

namespace App\Http\Requests\Profile;

use Illuminate\Foundation\Http\FormRequest;

class UpdateAvatarRequest extends FormRequest
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
//        $mimetypes = implode(',', [
//            'image/jpg', 'image/jpeg', 'image/png',
//            'application/msword', 'application/pdf', 'text/plain',
//            'video/mp4', 'video/mpeg', 'video/quicktime', 'video/x-msvideo', 'video/x-ms-wmv',
//        ]);

        return [
            'avatar' => "required|file|mimetypes:image/jpg,image/jpeg,image/png|max:1024",
        ];
    }
}
