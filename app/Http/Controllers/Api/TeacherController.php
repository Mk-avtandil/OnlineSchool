<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\TeacherCreateRequest;
use App\Http\Resources\TeacherCollection;
use App\Models\Teacher;
use Symfony\Component\HttpFoundation\JsonResponse;

class TeacherController extends Controller
{
    public function index(): TeacherCollection
    {
        $teacher = Teacher::with("groups")->get();

        return new TeacherCollection($teacher);
    }

    public function store(TeacherCreateRequest $request): JsonResponse
    {
        try {
            Teacher::create([
                'first_name' => $request->get('first_name'),
                'last_name' => $request->get('last_name'),
                'birthday' => $request->get('birthday'),
                'phone' => $request->get('phone'),
                'email' => $request->get('email'),
            ]);
            return response()->json(['message' => 'Teacher created successfully'], 201);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to create teacher', 'error' => $e->getMessage()], 500);
        }
    }
}
