<?php

namespace Database\Seeders;

use App\Models\Teacher;
use Illuminate\Database\Seeder;

class TeacherSeeder extends Seeder
{
    public function run(): void
    {
        Teacher::create([
            'user_id' => 2,
            'first_name' => 'Maksat',
            'last_name' => 'Maksatov',
            'birthday' => date('Y-m-d', strtotime('12.04.1997')),
            'phone' => '0702320433',
        ]);
    }
}
