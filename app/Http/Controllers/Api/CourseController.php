<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CourseCreateRequest;
use App\Http\Resources\CourseCollection;
use App\Http\Resources\CourseResource;
use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\JsonResponse;

class CourseController extends Controller
{
    public function index(Request $request): CourseCollection
    {
        $user = Auth::user();

        $courses = Course::with(['groups', 'lessons']);

        if ($user->hasRole('student')) {
            $courses = Course::whereHas('groups.students', function ($query) use ($user) {
               $query->where('students.user_id', $user->id);
            })->with(["groups", "lessons"]);
        }

        if ($user->hasRole('teacher')) {
            $courses = Course::whereHas('groups.teachers', function ($query) use ($user) {
                $query->where('teachers.user_id', $user->id);
            })->with(['groups', 'lessons']);
        }

        if ($request->has('search')) {
            $courses->where('title', 'like', '%' . $request->input('search') . '%');
        }

        $result = $courses->paginate(6);

        return new CourseCollection($result);
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

    public function show(Course $course): CourseResource|JsonResponse
    {
        if (!$course) {
            return response()->json(['message' => 'Course not found'], 404);
        }

        return new CourseResource($course);
    }

    public function update(Course $course, CourseCreateRequest $request)
    {
        try {
            $course->update([
                'title' => $request->get('title'),
                'description' => $request->get('description'),
                'price' => $request->get('price'),
            ]);

            return response()->json(['message' => 'Course updated successfully'], 200);
        } catch (\Exception $e) {
            return response()->json([
                "message" => "Failed to update course",
                "error" => $e->getMessage()
            ], 500);
        }
    }

    public function destroy(Course $course)
    {
        try {
            $course->delete();

            return response()->json(['message' => 'Course deleted successfully'], 200);
        } catch (\Exception $e) {
            return response()->json([
                "message" => "Failed to delete course",
                "error" => $e->getMessage()
            ], 500);
        }
    }
}

