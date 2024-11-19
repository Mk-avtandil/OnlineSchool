<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ScheduleCreateRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'course' => ['required', 'string', 'max:100'],
            'group' => ['required', 'string', 'max:100'],
            'teacher' => ['required', 'string', 'max:100'],
            'start_time' => ['required', 'date_format:H:i'],
            'end_time' => ['required', 'date_format:H:i', 'after:start_time'],
        ];
    }
}
