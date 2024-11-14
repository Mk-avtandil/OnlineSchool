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
        try {
            Solution::create([
                'answer' => $request->get('answer'),
                'homework_id' => $homeworkId,
                'student_id' => 1,
            ]);

            return response()->json(['message' => 'Solution created successfully'], 201);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to create solution', 'error' => $e->getMessage()], 500);
        }
    }
}
