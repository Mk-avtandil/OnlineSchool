<?php

namespace Database\Seeders;

use App\Models\GroupStudent;
use Illuminate\Database\Seeder;

class GroupStudentSeeder extends Seeder
{
    public function run(): void
    {
        for ($i = 1; $i <= 10; $i++) {
            GroupStudent::create([
                'group_id' => $i,
                'student_id' => $i,
            ]);
        }
    }
}
