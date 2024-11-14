<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GroupUpdateRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'title' => ['string', 'max:100'],
            'description' => ['string'],
            'start_time' => ['date_format:H:i'],
            'end_time' => ['date_format:H:i', 'after:start_time'],
        ];
    }
}
