<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\GroupCreateRequest;
use App\Http\Requests\GroupUpdateRequest;
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

    public function update(Group $group, GroupUpdateRequest $request): JsonResponse
    {
        $fields = ['title', 'description', 'start_time', 'end_time'];
        try {
            foreach ($fields as $field) {
                $newValue = $request->get($field);

                if ($group->$field !== $newValue) {
                    $group->$field = $newValue;
                }
            }
            $group->save();

            if ($request->has('students') && count($request->get('students')) > 0) {
                $students = Student::find($request->get('students'));
                $group->students()->sync($students);
            }

            if ($request->has('teachers') && count($request->get('teachers')) > 0) {
                $teachers = Teacher::find($request->get('teachers'));
                $group->teachers()->sync($teachers);
            }

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

    public function removeStudent(GroupUpdateRequest $request, $groupId)
    {
        $group = Group::findOrFail($groupId);
        $studentId = $request->input('student_id');

        $group->students()->detach($studentId);

        return response()->json(['message' => 'Student removed successfully!']);
    }

    public function removeTeacher(GroupUpdateRequest $request, $groupId)
    {
        $group = Group::findOrFail($groupId);
        $teacherId = $request->input('teacher_id');

        $group->teachers()->detach($teacherId);

        return response()->json(['message' => 'Teacher removed successfully!']);
    }
}
