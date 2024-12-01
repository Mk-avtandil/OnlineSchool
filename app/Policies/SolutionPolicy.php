<?php

namespace App\Policies;

use App\Models\Solution;
use App\Models\User;

class SolutionPolicy
{
    public function view(User $user, Solution $solution)
    {
        return $user->hasRole('student') && $user->student->id === $solution->student_id;
    }
}
