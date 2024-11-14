<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\HomeworkCreateRequest;
use App\Http\Resources\HomeworkResource;
use App\Models\Homework;
use Illuminate\Http\JsonResponse;

class HomeworkController extends Controller
{

    public function show(Homework $homework): HomeworkResource|JsonResponse
    {
        if (!$homework) {
            return response()->json(['message' => 'Homework not found'], 404);
        }

        return new HomeworkResource($homework);
    }

    public function store(HomeworkCreateRequest $request, $lessonId): JsonResponse
    {
        try {
            Homework::create([
                'title' => $request->get('title'),
                'description' => $request->get('description'),
                'deadline' => $request->get('deadline'),
                'lesson_id' => $lessonId,
            ]);

            return response()->json(['message' => 'Homework created successfully'], 201);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to create homework', 'error' => $e->getMessage()], 500);
        }
    }
}
