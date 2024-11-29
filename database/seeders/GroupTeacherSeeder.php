<?php

namespace Database\Seeders;

use App\Models\GroupTeacher;
use Illuminate\Database\Seeder;

class GroupTeacherSeeder extends Seeder
{
    public function run(): void
    {
        for ($i = 1; $i < 5; $i++) {
            GroupTeacher::create([
                'group_id' => $i,
                'teacher_id' => $i,
            ]);
        }
    }
}
