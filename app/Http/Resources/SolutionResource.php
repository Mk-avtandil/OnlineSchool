<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SolutionResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'lesson_id' => $this->lesson_id,
            'student_id' => $this->student_id,
            'answer' => $this->answer,
            'student' => $this->student,
            'grade' => $this->grade,
            'materials' => $this->getMedia('solution_files')->map(function ($media) {
                return [
                    'id' => $media->id,
                    'url' => $media->getUrl(),
                    'name' => $media->file_name,
                ];
            }),
        ];
    }
}
