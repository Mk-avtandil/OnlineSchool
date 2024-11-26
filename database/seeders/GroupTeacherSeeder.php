<?php

namespace Database\Seeders;

use App\Models\GroupTeacher;
use Illuminate\Database\Seeder;

class GroupTeacherSeeder extends Seeder
{
    public function run(): void
    {
        GroupTeacher::create([
            'group_id' => 1,
            'teacher_id' => 1,
        ]);
    }
}
