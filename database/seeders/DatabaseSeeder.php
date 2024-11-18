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
        $this->call([
            RolesSeeder::class,
            PermissionsSeeder::class,
            RolesPermissionsSeeder::class,
            UserSeeder::class,
            CourseSeeder::class,
            GroupSeeder::class,
            StudentSeeder::class,
            TeacherSeeder::class,
            LessonSeeder::class,
            GroupStudentSeeder::class
        ]);
    }
}
