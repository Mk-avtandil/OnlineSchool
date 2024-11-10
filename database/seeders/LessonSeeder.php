<?php

namespace Database\Seeders;

use App\Models\Lesson;
use Illuminate\Database\Seeder;

class LessonSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Lesson::create([
            'id' => 1,
            'course_id' => 1,
            'title' => 'Lesson 1',
            'Description' => 'To be',
        ]);

        Lesson::create([
            'id' => 2,
            'course_id' => 1,
            'title' => 'Lesson 2',
            'Description' => 'Present simple',
        ]);

        Lesson::create([
            'id' => 3,
            'course_id' => 2,
            'title' => 'Lesson 1',
            'Description' => 'Checking level',
        ]);

        Lesson::create([
            'id' => 4,
            'course_id' => 2,
            'title' => 'Lesson 2',
            'Description' => 'Reading books',
        ]);

        Lesson::create([
            'id' => 5,
            'course_id' => 3,
            'title' => 'Lesson 1',
            'Description' => 'Structure data',
        ]);

        Lesson::create([
            'id' => 6,
            'course_id' => 3,
            'title' => 'Lesson 2',
            'Description' => 'OOP',
        ]);
    }
}
