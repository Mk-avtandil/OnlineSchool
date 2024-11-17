<?php

namespace Database\Seeders;

use App\Models\Group;
use Illuminate\Database\Seeder;

class GroupSeeder extends Seeder
{
    public function run(): void
    {
        Group::create([
            'course_id' => 1,
            'title' => 'A2 level',
            'Description' => 'Test description',
        ]);

        Group::create([
            'course_id' => 1,
            'title' => 'C1 level',
            'Description' => 'Test description',
        ]);

        Group::create([
            'course_id' => 2,
            'title' => 'Group №1',
            'Description' => 'Test description',
        ]);

        Group::create([
            'course_id' => 2,
            'title' => 'Group №2',
            'Description' => 'Test description',
        ]);

        Group::create([
            'course_id' => 3,
            'title' => 'Group №1',
            'Description' => 'English group',
        ]);

        Group::create([
            'course_id' => 3,
            'title' => 'Group №2',
            'Description' => 'with OOP',
        ]);

        Group::create([
            'course_id' => 4,
            'title' => 'Group №2',
            'Description' => 'React + Javascript',
        ]);
    }
}
