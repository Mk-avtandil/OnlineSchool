<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Http\Resources\GroupCollection;
use App\Models\Course;

class CourseGroupsController extends Controller
{
    public function group(Course $course)
    {
        $groups = $course->groups()->with(['students', 'teachers'])->get();

        return new GroupCollection($groups);
    }
}
