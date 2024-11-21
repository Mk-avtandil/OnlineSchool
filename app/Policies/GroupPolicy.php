<?php

namespace App\Policies;

use App\Models\Group;
use App\Models\User;

class GroupPolicy
{
    public function view(User $user, Group $group): bool
    {
        if ($user->hasRole(['admin', 'super_admin'])) {
            return true;
        } elseif ($user->hasRole('student')) {
            return $group->students->contains($user);
        } elseif ($user->hasRole('teacher')) {
            return $group->teachers->contains($user);
        }

        return false;
    }
}
