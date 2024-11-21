<?php

namespace App\Policies;

use App\Models\Lesson;
use App\Models\User;

class LessonPolicy
{
    public function view(User $user, Lesson $lesson): bool
    {
        if ($user->hasRole(['admin', 'super_admin'])) {
            return true;
        }

        if ($user->hasRole('student')) {
            return $lesson->course->groups()->where('student_id', $user->id)->exists();
        }

        if ($user->hasRole('teacher')) {
            return $lesson->course->groups()->where('teacher_id', $user->id)->exists();
        }

        return false;
    }
}
