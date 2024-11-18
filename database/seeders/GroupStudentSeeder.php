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
    }
}
