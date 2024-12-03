<?php

namespace App\Policies;

use App\Models\Course;
use App\Models\Lesson;
use App\Models\User;

class LessonPolicy
{
    public function view(User $user, Lesson $lesson)
    {
        $course = $lesson->course;

        if ($user->hasRole(['admin', 'super_admin'])) {
            return true;
        }

        if ($user->hasRole('student')) {
            return $course->groups()
                ->whereHas('students', fn($query) => $query->where('user_id', $user->id))
                ->exists();
        }

        if ($user->hasRole('teacher')) {
            return $course->groups()
                ->whereHas('teachers', fn($query) => $query->where('user_id', $user->id))
                ->exists();
        }

        return false;
    }

    public function viewAny(User $user, Course $course)
    {
        if ($user->hasRole(['admin', 'super_admin'])) {
            return Lesson::where('course_id', $course->id);
        }

        if ($user->hasRole('student')) {
            return Lesson::where('course_id', $course->id)
                ->whereHas('course.groups', function ($query) use ($user) {
                    $query->whereHas('students', fn($query) => $query->where('user_id', $user->id));
                });
        }

        if ($user->hasRole('teacher')) {
            return Lesson::where('course_id', $course->id)
                ->whereHas('course.groups', function ($query) use ($user) {
                    $query->whereHas('teachers', fn($query) => $query->where('user_id', $user->id));
                });
        }

        return Lesson::query()->whereRaw('0 = 1');
    }

    public function create(User $user, Course $course)
    {
        if ($user->hasRole(['admin', 'super_admin'])) {
            return true;
        }

        if ($user->hasRole('teacher')) {
            $isTeacherInCourse = $course->groups()->whereHas('teachers', function ($query) use ($user) {
                $query->where('user_id', $user->id);
            })->exists();

            return $isTeacherInCourse;
        }

        return false;
    }
}
