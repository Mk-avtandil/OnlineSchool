<?php

namespace Database\Seeders;

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
        $this->call(StudentSeeder::class);
        $this->call(LessonSeeder::class);
        $this->call(GroupStudentSeeder::class);


          // Factory
//        $students = Student::factory()->count(30)->create();
//        $teachers = Teacher::factory()->count(30)->create();
//        $courses = Course::factory()->count(30)->create();
//        $groups = Group::factory()->count(30)->create();
//        $lessons = Lesson::factory()->count(50)->create();
//        $groupStudents = GroupStudent::factory()->count(30)->create();
    }
}
