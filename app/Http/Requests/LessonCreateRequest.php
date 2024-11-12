<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LessonCreateRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:100'],
            'description' => ['required', 'string'],
            'materials' => ['nullable', 'array'],
            'materials.*.files' => ['nullable', 'array'],
            'materials.*.files.*' => ['file', 'mimes:jpg,png,pdf,docx,txt,jpeg'],
        ];
    }
}