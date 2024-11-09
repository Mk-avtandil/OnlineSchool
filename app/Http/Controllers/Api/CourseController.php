<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CourseCollection;
use App\Models\Course;

class CourseController extends Controller
{
    public function index()
    {
        $courses = Course::with("groups")->paginate(3);

        return new CourseCollection($courses);
    }
}

