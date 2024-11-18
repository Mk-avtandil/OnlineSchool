<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StudentCreateRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'first_name' => ['required', 'string', 'max:20'],
            'last_name' => ['required', 'string', 'max:20'],
            'birthday' => ['required', 'date'],
            'phone' => ['required', 'string', 'max:20'],
        ];
    }
}
