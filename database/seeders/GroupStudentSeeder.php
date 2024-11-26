<?php

namespace Database\Seeders;

use App\Models\GroupStudent;
use Illuminate\Database\Seeder;

class GroupStudentSeeder extends Seeder
{
    public function run(): void
    {
        GroupStudent::create([
            'group_id' => 1,
            'student_id' => 1,
        ]);

        GroupStudent::create([
            'group_id' => 1,
            'student_id' => 2,
        ]);

        GroupStudent::create([
            'group_id' => 2,
            'student_id' => 3,
        ]);
    }
}
