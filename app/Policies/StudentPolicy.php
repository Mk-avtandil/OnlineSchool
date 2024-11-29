<?php

namespace App\Policies;

use App\Models\Student;
use App\Models\User;

class StudentPolicy
{
    public function view(User $user, Student $student)
    {
        return $user->hasRole('student') && $user->id === $student->user_id;
    }
}
