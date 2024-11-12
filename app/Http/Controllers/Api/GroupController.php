<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\GroupCreateRequest;
use App\Http\Resources\GroupCollection;
use App\Http\Resources\GroupResource;
use App\Models\Group;
use App\Models\Student;
use App\Models\Teacher;
use Symfony\Component\HttpFoundation\JsonResponse;

class GroupController extends Controller
{
    public function index($courseId): GroupCollection
    {
        $groups = Group::where('course_id', $courseId)->with(['students', 'teachers'])->get();

        return new GroupCollection($groups);
    }

    public function show(Group $group): GroupResource|JsonResponse
    {
        if (!$group) {
            return response()->json(['message' => 'Group not found'], 404);
        }

        return new GroupResource($group);
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

            if ($request->has('teachers') && count($request->get('teachers')) > 0) {
                $teachers = Teacher::find($request->get('teachers'));
                $group->teachers()->sync($teachers);
            }

            return response()->json(['message' => 'Group created successfully', 'group' => $group], 201);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to create group', 'error' => $e->getMessage()], 500);
        }
    }

    public function update(Group $group, GroupCreateRequest $request): JsonResponse
    {
        try {
            $group->update([
                'title' => $request->get('title'),
                'description' => $request->get('description'),
                'start_time' => $request->get('start_time'),
                'end_time' => $request->get('end_time'),
            ]);

            return response()->json(['message' => 'Group updated successfully'], 200);
        } catch (\Exception $e) {
            return response()->json([
                "message" => "Failed to update group",
                "error" => $e->getMessage()
            ], 500);
        }
    }

    public function destroy(Group $group): JsonResponse
    {
        try {
            $group->delete();

            return response()->json(['message' => 'Group deleted successfully'], 200);
        } catch (\Exception $e) {
            return response()->json([
                "message" => "Failed to delete group",
                "error" => $e->getMessage()
            ], 500);
        }
    }
}
