<?php

namespace Database\Seeders;

use App\Models\GroupStudent;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(CourseSeeder::class);
        $this->call(GroupSeeder::class);
        $this->call(TeacherSeeder::class);
        $this->call(StudentSeeder::class);
        $this->call(LessonSeeder::class);
        $this->call(GroupStudentSeeder::class);
    }
}