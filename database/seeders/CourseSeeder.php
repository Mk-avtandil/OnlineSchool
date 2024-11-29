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
            array("course_name" => "Full Stack Web Development", "description" => "Master both frontend and backend development with frameworks and databases."),
            array("course_name" => "Machine Learning Essentials", "description" => "Introduction to machine learning algorithms and practical implementation."),
            array("course_name" => "UX/UI Design Fundamentals", "description" => "Learn user experience and interface design principles for intuitive applications."),
            array("course_name" => "Digital Marketing Strategy", "description" => "Understand SEO, SEM, social media, and analytics for effective marketing."),
            array("course_name" => "Cloud Computing with AWS", "description" => "Explore cloud infrastructure, services, and deployment strategies on AWS."),
            array("course_name" => "Game Development with Unity", "description" => "Learn the basics of game design and development using Unity and C#.")
        );

        foreach ($courses as $course) {
            $course = Course::create([
                'title' => $course['course_name'],
                'description' => $course['description'],
                'price' => rand(5000, 20000),
            ]);

            for ($j = 1; $j < 3; $j++) {
                $course->groups()->create([
                    'title' => 'Group №' . $j,
                    'Description' => 'Group description №' . $j,
                ]);
            }

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
