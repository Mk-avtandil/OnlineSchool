<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StudentCreateRequest;
use App\Http\Requests\StudentUpdateRequest;
use App\Http\Resources\StudentCollection;
use App\Http\Resources\StudentResource;
use App\Models\Student;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;

class StudentController extends Controller
{
    public function index(): StudentCollection
    {
        $students = Student::with("groups")->get();

        return new StudentCollection($students);
    }

    public function detail($studentId): StudentResource
    {
        $student = Student::with(['creditCard', 'payments.course', 'groups.course'])->where('user_id', $studentId)->firstOrFail();

        $this->authorize('view', $student);

        return new StudentResource($student);
    }

    public function show(Student $student): StudentResource
    {
        return new StudentResource($student);
    }

    public function store(StudentCreateRequest $request): JsonResponse
    {
        try {
            $user = User::create([
                'email' => $request->get('email'),
                'password' => Hash::make($request->password),
            ]);

            $user->assignRole('student');
            $user->student()->create([
                'first_name' => $request->get('first_name'),
                'last_name' => $request->get('last_name'),
                'birthday' => $request->get('birthday'),
                'phone' => $request->get('phone'),
            ]);

            return response()->json(['message' => 'Student created successfully'], 201);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to create student', 'error' => $e->getMessage()], 500);
        }
    }

    public function update(Student $student, StudentUpdateRequest $request): JsonResponse
    {
        $fields = ['first_name', 'last_name', 'birthday', 'phone'];
        try {
            foreach ($fields as $field) {
                $newValue = $request->get($field);

                if ($student->$field !== $newValue) {
                    $student->$field = $newValue;
                }
            }
            $student->save();

            return response()->json(['message' => 'Student updated successfully'], 200);
        } catch (\Exception $e) {
            return response()->json([
                "message" => "Failed to update student",
                "error" => $e->getMessage()
            ], 500);
        }
    }

    public function destroy(Student $student): JsonResponse
    {
        try {
            $student->delete();

            return response()->json(['message' => 'Student deleted successfully'], 200);
        } catch (\Exception $e) {
            return response()->json([
                "message" => "Failed to delete student",
                "error" => $e->getMessage()
            ], 500);
        }
    }
}
