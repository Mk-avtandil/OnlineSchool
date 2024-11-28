<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class StudentSeeder extends Seeder
{
    public function run(): void
    {
        $people = array(
            array("first_name" => "John", "last_name" => "Smith"),
            array("first_name" => "Maria", "last_name" => "Johnson"),
            array("first_name" => "Alexey", "last_name" => "Petrov"),
            array("first_name" => "Svetlana", "last_name" => "Ivanova"),
            array("first_name" => "Dmitry", "last_name" => "Sokolov"),
            array("first_name" => "Olga", "last_name" => "Mikhailova"),
            array("first_name" => "Konstantin", "last_name" => "Volkov"),
            array("first_name" => "Catherine", "last_name" => "Brown"),
            array("first_name" => "Maxim", "last_name" => "Davis"),
            array("first_name" => "Anna", "last_name" => "Wilson")
        );


        foreach ($people as $person) {
            $user = User::create([
                'email' => $person['first_name'] . '@gmail.com',
                'password' => Hash::make('12345678'),
            ]);

            $user->student()->create([
                'first_name' => $person['first_name'],
                'last_name' => $person['last_name'],
                'birthday' => date('Y-m-d', strtotime('21.11.1997')),
                'phone' => '0704323433',
            ]);

            $user->assignRole('student');
        }
    }
}
