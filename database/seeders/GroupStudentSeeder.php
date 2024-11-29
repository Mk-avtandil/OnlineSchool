<?php

namespace Database\Seeders;

use App\Models\GroupStudent;
use Illuminate\Database\Seeder;

class GroupStudentSeeder extends Seeder
{
    public function run(): void
    {
        $j = 1;

        while ($j <= 20) {
            GroupStudent::create([
                'group_id' => $j,
                'student_id' => (($j - 1) % 10) + 1,
            ]);

            $j++;
        }
    }
}
