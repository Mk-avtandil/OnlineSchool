<?php

namespace App\Policies;

use App\Models\Course;
use App\Models\Group;
use App\Models\User;

class GroupPolicy
{
    public function view(User $user, Group $group): bool
    {
        if ($user->hasRole(['admin', 'super_admin'])) {
            return true;
        }

        if ($user->hasRole('student')) {
            return $group->students->pluck('user_id')->contains($user->id);
        }

        if ($user->hasRole('teacher')) {
            return $group->teachers->pluck('user_id')->contains($user->id);
        }

        return false;
    }

    public function viewAny(User $user, Course $course)
    {
        if ($user->hasRole(['admin', 'super_admin'])) {
            return Group::where('course_id', $course->id);
        }

        if ($user->hasRole('student')) {
            return Group::where('course_id', $course->id)
                ->whereHas('students', fn($query) => $query->where('user_id', $user->id));
        }

        if ($user->hasRole('teacher')) {
            return Group::where('course_id', $course->id)
                ->whereHas('teachers', fn($query) => $query->where('user_id', $user->id));
        }

        return Group::query()->whereRaw('0 = 1');
    }
}
