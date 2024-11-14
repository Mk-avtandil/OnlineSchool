<?php

namespace Database\Factories;

use App\Models\Group;
use App\Models\GroupStudent;
use App\Models\Student;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\GroupStudent>
 */
class GroupStudentFactory extends Factory
{
    protected $model = GroupStudent::class;

    public function definition(): array
    {
        return [
            'student_id' => Student::inRandomOrder()->first()->id,
            'group_id' => Group::inRandomOrder()->first()->id,
        ];
    }
}
