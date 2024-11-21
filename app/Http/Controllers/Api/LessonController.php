<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\LessonCreateRequest;
use App\Http\Resources\LessonCollection;
use App\Http\Resources\LessonResource;
use App\Models\Lesson;
use Illuminate\Support\Facades\Auth;

class LessonController extends Controller
{
    public function index($courseId): LessonCollection
    {
        $user = Auth::user();

        $lessonsQuery = Lesson::where('course_id', $courseId)->with('media', 'homeworks');

        if ($user->hasRole('student')) {
            $lessonsQuery->whereHas('course.groups.students', function ($query) use ($user) {
                $query->where('students.user_id', $user->id);
            });
        }

        if ($user->hasRole('teacher')) {
            $lessonsQuery->whereHas('course.groups.teachers', function ($query) use ($user) {
                $query->where('teachers.user_id', $user->id);
            });
        }

        $lessons = $lessonsQuery->get();

        if ($lessons->isEmpty()) {
            abort(403, 'You do not have access to this lesson!');
        }

        return new LessonCollection($lessons);
    }


    public function show(Lesson $lesson)
    {
        if (!$lesson) {
            return response()->json(['message' => 'Lesson not found'], 404);
        }

        return new LessonResource($lesson);
    }

    public function store(LessonCreateRequest $request, $courseId)
    {
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

    public function update(Lesson $lesson, LessonCreateRequest $request)
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

    public function destroy(Lesson $lesson)
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
