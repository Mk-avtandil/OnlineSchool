<?php

namespace Database\Seeders;

use App\Models\Student;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class StudentSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::create([
            'name' => 'Avtandil',
            'email' => 'avtandil@gmail.com',
            'password' => Hash::make('12345678'),
            'role' => 'student'
        ]);

         Student::create([
            'user_id' => $user->id,
            'first_name' => 'Avtandil',
            'last_name' => 'Kurbanov',
            'birthday' => date('Y-m-d', strtotime('12.04.1997')),
            'address' => 'Kudaibergen',
            'phone' => '0704323433',
            'email' => 'avtandil@gmail.com',
            'password' => '12345678',
        ]);

        $user = User::create([
            'name' => 'Dastan',
            'email' => 'dastan@gmail.com',
            'password' => Hash::make('12345678'),
            'role' => 'student'
        ]);

        Student::create([
            'user_id' => $user->id,
            'first_name' => 'Dastan',
            'last_name' => 'Dastanov',
            'birthday' => date('Y-m-d', strtotime('12.02.1999')),
            'address' => '8mkr',
            'phone' => '0777329033',
            'email' => 'dastan@gmail.com',
            'password' => '12345678',
        ]);

        $user = User::create([
            'name' => 'Bek',
            'email' => 'bek@gmail.com',
            'password' => Hash::make('12345678'),
            'role' => 'student'
        ]);

        Student::create([
            'user_id' => $user->id,
            'first_name' => 'Bek',
            'last_name' => 'Bekov',
            'birthday' => date('Y-m-d', strtotime('12.04.2000')),
            'address' => '2mkr',
            'phone' => '0779829053',
            'email' => 'bek@gmail.com',
            'password' => '12345678',
        ]);
    }
}
