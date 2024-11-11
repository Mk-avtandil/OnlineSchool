<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\LessonCreateRequest;
use App\Http\Resources\LessonCollection;
use App\Models\Lesson;

class LessonController extends Controller
{
    public function index($courseId): LessonCollection
    {
        $lessons = Lesson::where('course_id', $courseId)->with(['materials.files', 'homeworks'])->get();

        return new LessonCollection($lessons);
    }

    public function store(LessonCreateRequest $request, $courseId)
    {
        $lesson = Lesson::create([
            'title' => $request->title,
            'description' => $request->description,
            'course_id' => $courseId,
        ]);

        if ($request->has('materials')) {
            foreach ($request->materials as $materialData) {
                $material = $lesson->materials()->create([]);

                if (isset($materialData['files'])) {
                    foreach ($materialData['files'] as $file) {
                        $filePath = $file->store('materials', 'public');

                        $material->files()->create([
                            'file_path' => $filePath,
                        ]);
                    }
                }
            }
        }

        return response()->json([
            'message' => 'Lesson created successfully with materials and files!',
            'lesson' => $lesson,
        ], 201);

    }
}
