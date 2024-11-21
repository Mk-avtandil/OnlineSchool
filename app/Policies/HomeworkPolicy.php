<?php

namespace App\Policies;

use App\Models\Homework;
use App\Models\User;

class HomeworkPolicy
{
    public function view(Homework $homework, User $user): bool
    {
        if ($user->hasRole(['admin', 'super_admin'])) {
            return true;
        }

        if ($user->hasRole(['teacher'])) {
            return $homework->lesson->course->groups()->where('student_id', $user->id)->exists();;
        }

        return false;
    }
}
