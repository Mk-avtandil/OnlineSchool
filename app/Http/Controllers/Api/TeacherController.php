<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\TeacherCreateRequest;
use App\Http\Requests\TeacherUpdateRequest;
use App\Http\Resources\TeacherCollection;
use App\Http\Resources\TeacherResource;
use App\Models\Teacher;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\JsonResponse;

class TeacherController extends Controller
{
    public function index(): TeacherCollection
    {
        $teacher = Teacher::with("groups")->get();

        return new TeacherCollection($teacher);
    }

    public function detail($teacherId): TeacherResource
    {
        $teacher = Teacher::where('user_id', $teacherId)->firstOrFail();
        return new TeacherResource($teacher);
    }

    public function show(Teacher $teacher): TeacherResource
    {
        return new TeacherResource($teacher);
    }

    public function store(TeacherCreateRequest $request): JsonResponse
    {
        try {
            $user = User::create([
                'email' => $request->get('email'),
                'password' => Hash::make($request->password),
            ]);

            $user->assignRole('teacher');
            $user->teacher()->create([
                'user_id' => $user->id,
                'first_name' => $request->get('first_name'),
                'last_name' => $request->get('last_name'),
                'birthday' => $request->get('birthday'),
                'phone' => $request->get('phone'),
            ]);

            return response()->json(['message' => 'Teacher created successfully'], 201);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to create teacher', 'error' => $e->getMessage()], 500);
        }
    }

    public function update(Teacher $teacher, TeacherUpdateRequest $request): JsonResponse
    {
        $fields = ['first_name', 'last_name', 'birthday', 'phone'];
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

    public function destroy(Teacher $teacher): JsonResponse
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
