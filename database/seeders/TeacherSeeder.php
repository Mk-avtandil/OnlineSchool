<?php

namespace Database\Seeders;

use App\Models\Teacher;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class TeacherSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::create([
            'email' => 'maksat@gmail.com',
            'password' => Hash::make('12345678'),
        ]);

        $user->teacher()->create([
            'first_name' => 'Maksat',
            'last_name' => 'Maksatov',
            'birthday' => date('Y-m-d', strtotime('12.04.1997')),
            'phone' => '0702320433',
        ]);

        $user->assignRole('teacher');

        $user = User::create([
            'email' => 'vlad@gmail.com',
            'password' => Hash::make('12345678'),
        ]);

        $user->teacher()->create([
            'first_name' => 'Vlad',
            'last_name' => 'Vladov',
            'birthday' => date('Y-m-d', strtotime('12.04.1997')),
            'phone' => '0702322433',
        ]);

        $user->assignRole('teacher');
    }
}
