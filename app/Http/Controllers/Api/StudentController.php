<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StudentCreateRequest;
use App\Http\Resources\StudentCollection;
use App\Models\Student;
use Illuminate\Http\JsonResponse;

class StudentController extends Controller
{
    public function index(): StudentCollection
    {
        $students = Student::with("groups")->get();

        return new StudentCollection($students);
    }

    public function store(StudentCreateRequest $request): JsonResponse
    {
        try {
            Student::create([
                'first_name' => $request->get('first_name'),
                'last_name' => $request->get('last_name'),
                'birthday' => $request->get('birthday'),
                'address' => $request->get('address'),
                'phone' => $request->get('phone'),
                'email' => $request->get('email'),
            ]);
            return response()->json(['message' => 'Student created successfully'], 201);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to create student', 'error' => $e->getMessage()], 500);
        }
    }
}