<?php

namespace Database\Seeders;

use App\Models\Course;
use Illuminate\Database\Seeder;

class CourseSeeder extends Seeder
{
    public function run(): void
    {
        $course = Course::create([
            'title' => 'English',
            'description' => 'American English',
            'price' => 10000,
        ]);

        $course->groups()->create([
            'title' => 'Group A',
            'Description' => 'Test description',
        ]);

        $course->groups()->create([
            'title' => 'Group B',
            'Description' => 'Test description',
        ]);

        $course->lessons()->create([
            'title' => 'Lesson 1',
            'Description' => 'To be',
        ]);

        $course->lessons()->create([
            'title' => 'Lesson 2',
            'Description' => 'Present simple',
        ]);

        $course = Course::create([
            'title' => 'Spanish',
            'description' => 'New course',
            'price' => 12000,
        ]);

        $course->groups()->create([
            'title' => 'C1 level',
            'Description' => 'Test description',
        ]);

        $course->lessons()->create([
            'title' => 'Lesson 1',
            'Description' => 'Checking level',
        ]);

        $course = Course::create([
            'title' => 'Backend',
            'description' => 'bootcamp course',
            'price' => 15000,
        ]);

        $course->groups()->create([
            'title' => 'Group №1',
            'Description' => 'Test description',
        ]);

        $course->lessons()->create([
            'title' => 'Lesson 1',
            'Description' => 'Sql',
        ]);

        $course = Course::create([
            'title' => 'Frontend',
            'description' => 'bootcamp course',
            'price' => 10000,
        ]);

        $course->groups()->create([
            'title' => 'Morning group',
            'Description' => 'Test description',
        ]);

        $course->lessons()->create([
            'title' => 'Lesson 1',
            'Description' => 'HTML + CSS',
        ]);

        $course = Course::create([
            'title' => 'Computer Science',
            'description' => 'For developers',
            'price' => 20000,
        ]);

        $course->groups()->create([
            'title' => 'Group for senior developers',
            'Description' => 'Test description',
        ]);

        $course->lessons()->create([
            'title' => 'Lesson 1',
            'Description' => 'Binary tree',
        ]);
    }
}
