<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\GroupCreateRequest;
use App\Http\Requests\GroupUpdateRequest;
use App\Http\Resources\GroupCollection;
use App\Http\Resources\GroupResource;
use App\Models\Course;
use App\Models\Group;
use App\Policies\GroupPolicy;
use App\Services\GroupService;
use Symfony\Component\HttpFoundation\JsonResponse;

class GroupController extends Controller
{
    protected GroupService $groupService;

    public function __construct(GroupService $groupService)
    {
        $this->groupService = $groupService;
    }

    public function index(Course $course): GroupCollection
    {
        $user = auth()->user();

        $groupQuery = app(GroupPolicy::class)->viewAny($user, $course);

        $groups = $groupQuery->with('course')->get();

        return new GroupCollection($groups);
    }

    public function show(Group $group): GroupResource
    {
        $this->authorize('view', $group);
        return new GroupResource($group);
    }

    public function store(GroupCreateRequest $request, Course $course): JsonResponse
    {
        try {
            $this->groupService->validateStudents($request->get('students'), $course);

            $group = Group::create([
                'title' => $request->get('title'),
                'description' => $request->get('description'),
                'course_id' => $course->id,
            ]);

            $this->groupService->syncRelations($group, $request->get('students'), $request->get('teachers'));

            return response()->json(['message' => 'Group created successfully', 'group' => $group], 201);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to create group', 'error' => $e->getMessage()], 500);
        }
    }

    public function update(Group $group, GroupUpdateRequest $request): JsonResponse
    {
        try {
            $group->update([
                'title' => $request->get('title'),
                'description' => $request->get('description'),
            ]);

            return response()->json(['message' => 'Group updated successfully'], 200);
        } catch (\Exception $e) {
            return response()->json(["message" => 'Failed to update group', 'error' => $e->getMessage()], 500);
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

    public function getAllGroups(): GroupCollection
    {
        $groups = Group::with('students', 'teachers', 'course')->get();

        return new GroupCollection($groups);
    }

    public function removeStudent(GroupUpdateRequest $request, Group $group): JsonResponse
    {
        $studentId = $request->input('student_id');

        $group->students()->detach($studentId);

        return response()->json(['message' => 'Student removed successfully!']);
    }

    public function removeTeacher(GroupUpdateRequest $request, Group $group): JsonResponse
    {
        $teacherId = $request->input('teacher_id');

        $group->teachers()->detach($teacherId);

        return response()->json(['message' => 'Teacher removed successfully!']);
    }

    public function addStudents(GroupUpdateRequest $request, Group $group): JsonResponse
    {
        try {
            $studentIds = $request->input('student_ids');

            $this->groupService->validateStudents($studentIds, $group->course);

            $group->students()->syncWithoutDetaching($studentIds);

            return response()->json(['message' => 'Students added successfully!']);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to add students', 'error' => $e->getMessage()], 400);
        }
    }

    public function addTeachers(GroupUpdateRequest $request, Group $group): JsonResponse
    {
        try {
            $teacherIds = $request->input('teacher_ids');

            $group->teachers()->syncWithoutDetaching($teacherIds);

            return response()->json(['message' => 'Teachers added successfully!']);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to add teachers', 'error' => $e->getMessage()], 400);
        }
    }
}
