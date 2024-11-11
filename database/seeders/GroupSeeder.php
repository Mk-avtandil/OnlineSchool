<?php

namespace Database\Seeders;

use App\Models\Group;
use Illuminate\Database\Seeder;

class GroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Group::create([
            'id' => 1,
            'course_id' => 1,
            'title' => 'A2 level',
            'Description' => 'Test description',
            'start_time' => '10:00',
            'end_time' => '12:00',
        ]);

        Group::create([
            'id' => 2,
            'course_id' => 1,
            'title' => 'C1 level',
            'Description' => 'Test description',
            'start_time' => '10:00',
            'end_time' => '12:00',
        ]);

        Group::create([
            'id' => 3,
            'course_id' => 2,
            'title' => 'Smart people groups',
            'Description' => 'Test description',
            'start_time' => '10:00',
            'end_time' => '12:00',
        ]);

        Group::create([
            'id' => 4,
            'course_id' => 2,
            'title' => 'New group for men',
            'Description' => 'Test description',
            'start_time' => '10:00',
            'end_time' => '12:00',
        ]);

        Group::create([
            'id' => 5,
            'course_id' => 3,
            'title' => 'Morning group',
            'Description' => 'English group',
            'start_time' => '10:00',
            'end_time' => '12:00',
        ]);

        Group::create([
            'id' => 6,
            'course_id' => 3,
            'title' => 'Night group',
            'Description' => 'with OOP',
            'start_time' => '10:00',
            'end_time' => '12:00',
        ]);
    }
}
