<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StudentStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'matrix_id' => ['required', 'max:255', 'string'],
            'nfc_tag' => ['required', 'max:255', 'string'],
            'user_id' => ['required', 'exists:users,id'],
            'faculty_id' => ['required', 'exists:faculties,id'],
            'is_active' => ['required', 'boolean'],
        ];
    }
}
