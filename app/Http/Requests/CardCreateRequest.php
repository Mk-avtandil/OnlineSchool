<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CardCreateRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'card_number' => ['required', 'string', 'max:16'],
            'card_type' => ['required', 'in:visa,mastercard'],
            'cvv' => ['required', 'integer', 'digits:4'],
            'sum' => ['required', 'integer', 'min:1', 'max:1000000'],
        ];
    }
}
