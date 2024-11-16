<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GradeCreateRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'grade' => ['required', 'integer', 'max:100'],
            'feedback' => ['required', 'string', 'max:1000'],
        ];
    }
}
