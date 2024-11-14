<?php

namespace Database\Seeders;

use App\Models\Course;
use App\Models\Group;
use App\Models\GroupStudent;
use App\Models\Lesson;
use App\Models\Student;
use App\Models\Teacher;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $students = Student::factory()->count(30)->create();
        $teachers = Teacher::factory()->count(30)->create();
        $courses = Course::factory()->count(30)->create();
        $groups = Group::factory()->count(30)->create();
        $lessons = Lesson::factory()->count(50)->create();
        $groupStudents = GroupStudent::factory()->count(30)->create();
    }
}
