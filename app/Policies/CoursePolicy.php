<?php

namespace App\Policies;

use App\Models\Course;
use App\Models\User;

class CoursePolicy
{
    public function view(User $user, Course $course): bool
    {
        if ($user->hasRole(['admin', 'super_admin'])) {
            return true;
        }

        if ($user->hasRole('student')) {
            return $course->groups->pluck('students')->flatten()->contains('user_id', $user->id);
        }

        if ($user->hasRole('teacher')) {
            return $course->groups->pluck('teachers')->flatten()->contains('user_id', $user->id);
        }

        return false;
    }

    public function viewAny(User $user)
    {
        if ($user->hasRole(['admin', 'super_admin'])) {
            return Course::query();
        }

        if ($user->hasRole('student')) {
            return Course::whereHas('groups.students', function ($query) use ($user) {
                $query->where('user_id', $user->id);
            });
        }

        if ($user->hasRole('teacher')) {
            return Course::whereHas('groups.teachers', function ($query) use ($user) {
                $query->where('user_id', $user->id);
            });
        }

        return Course::query()->whereRaw('0 = 1');
    }

}
