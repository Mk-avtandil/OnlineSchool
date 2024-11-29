<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class TeacherSeeder extends Seeder
{
    public function run(): void
    {
        $people = array(
            array("first_name" => "David", "last_name" => "Taylor"),
            array("first_name" => "Robert", "last_name" => "Clark"),
            array("first_name" => "Sophia", "last_name" => "Lewis"),
            array("first_name" => "James", "last_name" => "Martinez")
        );

        foreach ($people as $person) {
            $user = User::create([
                'email' => $person['first_name'] . '@gmail.com',
                'password' => Hash::make('12345678'),
            ]);

            $user->teacher()->create([
                'first_name' => $person['first_name'],
                'last_name' => $person['last_name'],
                'birthday' => date('Y-m-d', strtotime('21.11.1997')),
                'phone' => '0704323433',
            ]);

            $user->assignRole('teacher');
        }
    }
}
