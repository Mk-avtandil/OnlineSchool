<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StudentUpdateRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'first_name' => ['string', 'max:20'],
            'last_name' => ['string', 'max:20'],
            'birthday' => ['date'],
            'phone' => ['string', 'max:20'],
        ];
    }
}
