<?php

namespace Database\Seeders;

use App\Models\Teacher;
use Illuminate\Database\Seeder;

class TeacherSeeder extends Seeder
{
    public function run(): void
    {
        Teacher::create([
            'first_name' => 'Maksat',
            'last_name' => 'Maksatov',
            'birthday' => date('Y-m-d', strtotime('12.04.1997')),
            'phone' => '0702320433',
            'email' => 'maksat@gmail.com',
        ]);

        Teacher::create([
            'first_name' => 'Vlad',
            'last_name' => 'Vladov',
            'birthday' => date('Y-m-d', strtotime('12.04.1997')),
            'phone' => '0707329033',
            'email' => 'vlad@gmail.com',
        ]);

        Teacher::create([
            'first_name' => 'Chika',
            'last_name' => 'Sultanov',
            'birthday' => date('Y-m-d', strtotime('12.04.1997')),
            'phone' => '0709229153',
            'email' => 'chika@gmail.com',
        ]);
    }
}
