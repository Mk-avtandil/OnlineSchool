<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'email' => $this->email,
            'student' => $this->student,
            'teacher' => $this->teacher,
            'role' => $this->roles->pluck('name'),
        ];
    }
}
