<?php

namespace Database\Seeders;

use App\Models\GroupStudent;
use Illuminate\Database\Seeder;

class GroupStudentSeeder extends Seeder
{
    public function run(): void
    {
        $groupCount = 4;
        $studentCount = 1;

        for ($groupId = 1; $groupId <= $groupCount; $groupId++) {
            for ($i = 0; $i < 5; $i++) {
                GroupStudent::create([
                    'group_id' => $groupId,
                    'student_id' => $studentCount,
                ]);

                $studentCount++;
            }
        }
    }
}
