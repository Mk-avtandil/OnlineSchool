<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\LessonCollection;
use App\Models\Lesson;

class LessonController extends Controller
{
    public function index($courseId): LessonCollection
    {
        $lessons = Lesson::where('course_id', $courseId)->with(['materials', 'homeworks'])->get();

        return new LessonCollection($lessons);
    }
}
