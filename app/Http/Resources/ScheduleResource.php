<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ScheduleResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'course' => $this->course,
            'group' => $this->group,
            'teacher' => $this->teacher,
            'start_time' => $this->start_time,
            'end_time' => $this->end_time,
        ];
    }
}
