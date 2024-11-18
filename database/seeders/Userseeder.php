<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class Userseeder extends Seeder
{
    public function run(): void
    {
        $student = User::create([
            'name' => 'Avtandil',
            'email' => 'avtandil@gmail.com',
            'password' => Hash::make('12345678'),
        ]);

        $student->assignRole('student');

        $teacher = User::create([
            'name' => 'Maksat',
            'email' => 'maksat@gmail.com',
            'password' => Hash::make('12345678'),
        ]);

        $teacher->assignRole('teacher');

        $admin = User::create([
            'name' => 'admin',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('12345678'),
        ]);

        $admin->assignRole('admin');

        $superadmin = User::create([
            'name' => 'superadmin',
            'email' => 'superadmin@gmail.com',
            'password' => Hash::make('12345678'),
        ]);

        $superadmin->assignRole('super_admin');
    }
}
