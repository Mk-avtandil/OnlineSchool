<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class StudentSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::create([
            'email' => 'avtandil@gmail.com',
            'password' => Hash::make('12345678'),
        ]);

        $user->student()->create([
            'first_name' => 'Avtandil',
            'last_name' => 'Kurbanov',
            'birthday' => date('Y-m-d', strtotime('12.04.1997')),
            'phone' => '0704323433',
        ]);

        $user->assignRole('student');

        $user = User::create([
            'email' => 'dastan@gmail.com',
            'password' => Hash::make('12345678'),
        ]);

        $user->student()->create([
            'first_name' => 'Dastan',
            'last_name' => 'Dastanov',
            'birthday' => date('Y-m-d', strtotime('12.12.1992')),
            'phone' => '0704319033',
        ]);

        $user->assignRole('student');

        $user = User::create([
            'email' => 'baitur@gmail.com',
            'password' => Hash::make('12345678'),
        ]);

        $user->student()->create([
            'first_name' => 'Baitur',
            'last_name' => 'Baiturov',
            'birthday' => date('Y-m-d', strtotime('12.12.1992')),
            'phone' => '0704319000',
        ]);

        $user->assignRole('student');
    }
}
