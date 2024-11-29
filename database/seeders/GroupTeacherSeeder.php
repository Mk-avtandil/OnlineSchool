<?php

namespace Database\Seeders;

use App\Models\GroupTeacher;
use Illuminate\Database\Seeder;

class GroupTeacherSeeder extends Seeder
{
    public function run(): void
    {
        $j = 1;

        while ($j <= 20) {
            GroupTeacher::create([
                'group_id' => $j,
                'teacher_id' => (($j - 1) % 5) + 1,
            ]);

            $j++;
        }
    }
}
