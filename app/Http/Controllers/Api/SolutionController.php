<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\SolutionCreateRequest;
use App\Models\Solution;
use Symfony\Component\HttpFoundation\JsonResponse;

class SolutionController extends Controller
{
    public function store(SolutionCreateRequest $request, $homeworkId): JsonResponse
    {
        $solution = Solution::create([
            'answer' => $request->get('answer'),
            'homework_id' => $homeworkId,
            'student_id' => 1,
        ]);

        if ($request->hasFile('files')) {
            $solution->addFiles($request->file('files'));
        }

        return response()->json([
            'message' => 'Lesson created successfully!',
            'lesson' => $solution,
        ], 201);
    }
}
