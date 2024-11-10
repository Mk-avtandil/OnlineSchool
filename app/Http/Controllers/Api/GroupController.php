<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\GroupCreateRequest;
use App\Http\Resources\GroupCollection;
use App\Models\Group;
use App\Models\Student;
use Symfony\Component\HttpFoundation\JsonResponse;

class GroupController extends Controller
{
    public function index($courseId)
    {
        $groups = Group::where('course_id', $courseId)->with(['students', 'teachers'])->get();

        return new GroupCollection($groups);
    }

    public function store(GroupCreateRequest $request, $courseId): JsonResponse
    {
        try {
            $group = Group::create([
                'title' => $request->get('title'),
                'description' => $request->get('description'),
                'start_time' => $request->get('start_time'),
                'end_time' => $request->get('end_time'),
                'course_id' => $courseId,
            ]);

            if ($request->has('students') && count($request->get('students')) > 0) {
                $students = Student::find($request->get('students'));
                $group->students()->sync($students);
            }

            return response()->json(['message' => 'Group created successfully', 'group' => $group], 201);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to create group', 'error' => $e->getMessage()], 500);
        }
    }
}
