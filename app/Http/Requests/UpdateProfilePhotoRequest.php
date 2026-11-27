<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProfilePhotoRequest extends FormRequest
{
    /**
     * The route is already limited to students.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * The picture must be a real image (JPG or PNG) of at most 2 MB.
     *
     * @return array<string, array<int, string>>
     */
    public function rules(): array
    {
        return [
            'photo' => ['required', 'image', 'mimes:jpg,jpeg,png', 'max:2048'],
        ];
    }
}
