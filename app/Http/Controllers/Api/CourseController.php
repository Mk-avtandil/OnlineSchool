<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CourseCreateRequest;
use App\Http\Resources\CourseCollection;
use App\Models\Course;
use Symfony\Component\HttpFoundation\JsonResponse;

class CourseController extends Controller
{
    public function index(): CourseCollection
    {
        $courses = Course::with("groups")->paginate(3);

        return new CourseCollection($courses);
    }

    public function store(CourseCreateRequest $request): JsonResponse
    {
        try {
            Course::create([
                'title' => $request->get('title'),
                'description' => $request->get('description'),
                'price' => $request->get('price'),
            ]);
            return response()->json(['message' => 'Course created successfully'], 201);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to create course', 'error' => $e->getMessage()], 500);
        }
    }
}

