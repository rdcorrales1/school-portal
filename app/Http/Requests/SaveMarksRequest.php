<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SaveMarksRequest extends FormRequest
{
    /**
     * The route is already limited to teachers. The subject ownership check is in the controller.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Marks are whole numbers from 0 to 100. An empty box means "no change".
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'subject_id' => ['required', 'integer', 'exists:subjects,id'],
            'quarter' => ['required', 'integer', 'between:1,4'],
            'marks' => ['required', 'array'],
            'marks.*' => ['nullable', 'integer', 'between:0,100'],
        ];
    }

    /**
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'marks.*.integer' => 'Marks must be whole numbers.',
            'marks.*.between' => 'Marks must be from 0 to 100.',
        ];
    }
}
