<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\TeacherCreateRequest;
use App\Http\Requests\TeacherUpdateRequest;
use App\Http\Resources\TeacherCollection;
use App\Http\Resources\TeacherResource;
use App\Models\Teacher;
use Symfony\Component\HttpFoundation\JsonResponse;

class TeacherController extends Controller
{
    public function index(): TeacherCollection
    {
        $teacher = Teacher::with("groups")->get();

        return new TeacherCollection($teacher);
    }

    public function show(Teacher $teacher): TeacherResource|JsonResponse
    {
        if (!$teacher) {
            return response()->json(['message' => 'Teacher not found'], 404);
        }

        return new TeacherResource($teacher);
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

    public function update(Teacher $teacher, TeacherUpdateRequest $request)
    {
        $fields = ['first_name', 'last_name', 'birthday', 'phone', 'email'];
        try {
            foreach ($fields as $field) {
                $newValue = $request->get($field);

                if ($teacher->$field !== $newValue) {
                    $teacher->$field = $newValue;
                }
            }
            $teacher->save();

            return response()->json(['message' => 'Teacher updated successfully'], 200);
        } catch (\Exception $e) {
            return response()->json([
                "message" => "Failed to update teacher",
                "error" => $e->getMessage()
            ], 500);
        }
    }

    public function destroy(Teacher $teacher)
    {
        try {
            $teacher->delete();

            return response()->json(['message' => 'Teacher deleted successfully'], 200);
        } catch (\Exception $e) {
            return response()->json([
                "message" => "Failed to delete teacher",
                "error" => $e->getMessage()
            ], 500);
        }
    }
}
