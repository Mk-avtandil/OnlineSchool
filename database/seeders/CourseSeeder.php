<?php

namespace Database\Seeders;

use App\Models\Course;
use Illuminate\Database\Seeder;

class CourseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Course::create([
            'title' => 'English',
            'description' => 'American English',
            'price' => 10000,
        ]);

        Course::create([
            'title' => 'Spanish',
            'description' => 'New course',
            'price' => 12000,
        ]);

        Course::create([
            'title' => 'Backend',
            'description' => 'bootcamp course',
            'price' => 15000,
        ]);

        Course::create([
            'title' => 'Frontend',
            'description' => 'bootcamp course',
            'price' => 10000,
        ]);

        Course::create([
            'title' => 'Computer Science',
            'description' => 'For developers',
            'price' => 20000,
        ]);
    }
}
