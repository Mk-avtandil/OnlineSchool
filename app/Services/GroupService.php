<?php

namespace App\Services;

use App\Models\Group;

class GroupService
{
    public function validateStudents($students, $course)
    {
        foreach ($students as $studentId) {
            $exists = Group::where('course_id', $course->id)
                ->whereHas('students', function ($query) use ($studentId) {
                    $query->where('students.id', $studentId);
                })
                ->exists();

            if ($exists) {
                throw new \Exception("Student is already in a group of this course.");
            }
        }
    }

    public function syncRelations(Group $group, ?array $students, ?array $teachers): void
    {
        if ($students && count($students) > 0) {
            $group->students()->sync($students);
        }

        if ($teachers && count($teachers) > 0) {
            $group->teachers()->sync($teachers);
        }
    }

}
