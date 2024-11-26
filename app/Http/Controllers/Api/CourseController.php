<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CourseCreateRequest;
use App\Http\Resources\CourseCollection;
use App\Http\Resources\CourseResource;
use App\Models\Course;
use App\Policies\CoursePolicy;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\JsonResponse;

class CourseController extends Controller
{
    public function index(Request $request): CourseCollection
    {
        $user = auth()->user();

        $coursesQuery = app(CoursePolicy::class)->viewAny($user);

        if ($request->has('search')) {
            $coursesQuery->where('title', 'like', '%' . $request->input('search') . '%');
        }

        $result = $coursesQuery->with(['groups.students', 'groups.teachers', 'lessons'])->paginate(6);

        return new CourseCollection($result);
    }

    public function store(CourseCreateRequest $request): JsonResponse
    {
        try {
            Course::create([
                'title' => $request->get('title'),
                'description' => $request->get('description'),
                'price' => $request->get('price'),
            ]);

            return response()->json(['message' => 'Course created successfully'], 201);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to create course', 'error' => $e->getMessage()], 500);
        }
    }

    public function show(Course $course): CourseResource
    {
        $this->authorize('view', $course);

        $course->load('groups.students', 'lessons');

        return new CourseResource($course);
    }

    public function update(Course $course, CourseCreateRequest $request)
    {
        try {
            $course->update([
                'title' => $request->get('title'),
                'description' => $request->get('description'),
                'price' => $request->get('price'),
            ]);

            return response()->json(['message' => 'Course updated successfully'], 200);
        } catch (\Exception $e) {
            return response()->json([
                "message" => "Failed to update course",
                "error" => $e->getMessage()
            ], 500);
        }
    }

    public function destroy(Course $course): JsonResponse
    {
        try {
            $course->delete();

            return response()->json(['message' => 'Course deleted successfully'], 200);
        } catch (\Exception $e) {
            return response()->json([
                "message" => "Failed to delete course",
                "error" => $e->getMessage()
            ], 500);
        }
    }

    public function statistics($courseId)
    {
        $course = Course::with([
            'groups.students',
            'groups.teachers',
            'lessons.homeworks.solutions.grade',
        ])->findOrFail($courseId);

//        $statistics = [
//            'course' => $course->title,
//            'groups' => [],
//        ];
//
//        foreach ($course->groups as $group) {
//            $groupData = [
//                'group_title' => $group->title,
//                'students' => [],
//                'teachers' => $group->teachers,
//            ];
//
//            foreach ($group->students as $student) {
//                $studentData = [
//                    'student' => $student->first_name . ' ' . $student->last_name,
//                    'lessons' => [],
//                ];
//
//                foreach ($course->lessons as $lesson) {
//                    $homework = $lesson->homeworks->firstWhere('lesson_id', $lesson->id);
//                    if ($homework) {
//                        $solution = $homework->solutions->firstWhere('student_id', $student->id);
//                        $grade = $solution ? $solution->grade : null;
//                        $studentData['lessons'][] = [
//                            'lesson_name' => $lesson->title,
//                            'homework' => $homework->title,
//                            'grade' => $grade ? $grade->value : 'Не оценено',
//                        ];
//                    }
//                }
//
//                $groupData['students'][] = $studentData;
//            }
//
//            $statistics['groups'][] = $groupData;
//        }

        return response()->json(['data' => $course]);
    }
}

