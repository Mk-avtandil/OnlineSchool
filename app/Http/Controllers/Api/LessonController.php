<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\LessonCreateRequest;
use App\Http\Resources\LessonCollection;
use App\Http\Resources\LessonResource;
use App\Models\Course;
use App\Models\Lesson;
use App\Policies\LessonPolicy;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class LessonController extends Controller
{
    public function index(Course $course): LessonCollection
    {
        $user = Auth::user();

        $lessonsQuery = app(LessonPolicy::class)->viewAny($user, $course);

        $lessons = $lessonsQuery->with('course.groups', 'course', 'homeworks')->get();

        return new LessonCollection($lessons);
    }


    public function show(Lesson $lesson): LessonResource|JsonResponse
    {
        $this->authorize('view', $lesson);
        return new LessonResource($lesson);
    }

    public function store(LessonCreateRequest $request, $courseId): JsonResponse
    {
        $course = Course::findOrFail($courseId);

        $this->authorize('create', [Lesson::class, $course]);

        $lesson = Lesson::create([
            'title' => $request->title,
            'description' => $request->description,
            'course_id' => $courseId,
        ]);

        if ($request->hasFile('files')) {
            $lesson->addFiles($request->file('files'));
        }

        return response()->json([
            'message' => 'Lesson created successfully!',
            'lesson' => $lesson,
        ], 201);
    }

    public function update(Lesson $lesson, LessonCreateRequest $request): JsonResponse
    {
        try {
            $lesson->update([
                'title' => $request->get('title'),
                'description' => $request->get('description'),
            ]);

            return response()->json(['message' => 'Lesson updated successfully'], 200);
        } catch (\Exception $e) {
            return response()->json([
                "message" => "Failed to update lesson",
                "error" => $e->getMessage()
            ], 500);
        }
    }

    public function destroy(Lesson $lesson): JsonResponse
    {
        try {
            $lesson->delete();

            return response()->json(['message' => 'Lesson deleted successfully'], 200);
        } catch (\Exception $e) {
            return response()->json([
                "message" => "Failed to delete lesson",
                "error" => $e->getMessage()
            ], 500);
        }
    }
}
