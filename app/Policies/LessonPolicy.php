<?php

namespace App\Policies;

use App\Models\Course;
use App\Models\Lesson;
use App\Models\User;

class LessonPolicy
{
    public function view(User $user, Lesson $lesson): bool
    {
        if ($user->hasRole('student')) {
            return $lesson->course->groups()->whereHas('students', function ($query) use ($user) {
                $query->where('students.user_id', $user->id);
            })->exists();
        }

        if ($user->hasRole('teacher')) {
            return $lesson->course->groups()->where('teacher_id', $user->id)->exists();
        }

        return false;
    }
}
