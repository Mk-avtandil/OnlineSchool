<?php

namespace Database\Seeders;

use App\Models\Course;
use Illuminate\Database\Seeder;

class CourseSeeder extends Seeder
{
    public function run(): void
    {
        $courses = array(
            array("course_name" => "Web Development Bootcamp", "description" => "Learn HTML, CSS, JavaScript, and more to build modern websites."),
            array("course_name" => "Introduction to Python", "description" => "A beginner's guide to programming with Python and its basics."),
            array("course_name" => "Data Science with R", "description" => "Explore data analysis, visualization, and machine learning using R."),
            array("course_name" => "Advanced JavaScript", "description" => "Deep dive into advanced JavaScript concepts like closures, promises, and async."),
        );

        foreach ($courses as $courseData) {
            $course = Course::create([
                'title' => $courseData['course_name'],
                'description' => $courseData['description'],
                'price' => rand(5000, 20000),
            ]);

            $course->groups()->create([
                'title' => $courseData['course_name'] . ' Group',
                'Description' => 'Group description test',
            ]);

            for ($j = 1; $j < 6; $j++) {
                $lesson = $course->lessons()->create([
                    'title' => 'Lesson ' . $j,
                    'Description' => 'Lesson ' . $j . ' description',
                ]);

                $homework = $lesson->homeworks()->create([
                    'title' => 'Homework ' . $j,
                    'description' => 'Homework ' . $j . ' description',
                    'deadline' => now()->addDays(rand(1, 30)),
                ]);
            }
        }
    }
}
