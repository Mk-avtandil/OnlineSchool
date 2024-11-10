<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CourseCollection;
use App\Http\Resources\GroupCollection;
use App\Http\Resources\LessonCollection;
use App\Models\Course;

class CourseController extends Controller
{
    public function index()
    {
        $courses = Course::with("groups")->paginate(3);

        return new CourseCollection($courses);
    }

    public function getCourseGroups(Course $course)
    {
        $groups = $course->groups()->with(['students', 'teachers'])->get();

        return new GroupCollection($groups);
    }

    public function getCourseLessons(Course $course)
    {
        $groups = $course->lessons()->with(['materials', 'homeworks'])->get();

        return new LessonCollection($groups);
    }
}

