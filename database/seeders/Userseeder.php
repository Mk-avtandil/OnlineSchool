<?php

namespace Database\Seeders;

use App\Models\User;
 use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class Userseeder extends Seeder
{
    public function run(): void
    {
        $admin = User::create([
            'email' => 'admin@gmail.com',
            'password' => Hash::make('12345678'),
        ]);

        $admin->assignRole('admin');

        $superadmin = User::create([
            'email' => 'superadmin@gmail.com',
            'password' => Hash::make('12345678'),
        ]);

        $superadmin->assignRole('super_admin');
    }
}
