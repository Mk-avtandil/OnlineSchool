<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\GradeCreateRequest;
use App\Models\Grade;
use Illuminate\Http\JsonResponse;

class GradeController extends Controller
{
    public function store(GradeCreateRequest $request, $solutionId, $studentId): JsonResponse
    {
        try {
            Grade::create([
                'grade' => $request->get('grade'),
                'feedback' => $request->get('feedback'),
                'student_id' => $studentId,
                'solution_id' => $solutionId,
                'teacher_id' => 1,
            ]);

            return response()->json(['message' => 'Grade created successfully'], 201);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to create grade'], 500);
        }
    }
}
