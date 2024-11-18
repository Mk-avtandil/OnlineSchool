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
        User::create([
            'name' => 'Avtandil',
            'email' => 'avtandil@gmail.com',
            'password' => Hash::make('12345678'),
            'role' => 'student'
        ]);

        User::create([
            'name' => 'Maksat',
            'email' => 'maksat@gmail.com',
            'password' => Hash::make('12345678'),
            'role' => 'teacher'
        ]);

        User::create([
            'name' => 'admin',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('12345678'),
            'role' => 'admin'
        ]);

        User::create([
            'name' => 'superadmin',
            'email' => 'superadmin@gmail.com',
            'password' => Hash::make('12345678'),
            'role' => 'superadmin'
        ]);
    }
}
