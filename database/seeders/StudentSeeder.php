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
            array("first_name" => "Anna", "last_name" => "Wilson"),
            array("first_name" => "Viktor", "last_name" => "Mikhailov"),
            array("first_name" => "Elena", "last_name" => "Kuznetsova"),
            array("first_name" => "Leonid", "last_name" => "Korolev"),
            array("first_name" => "Tatiana", "last_name" => "Pavlova"),
            array("first_name" => "Oleg", "last_name" => "Zaharov"),
            array("first_name" => "Irina", "last_name" => "Baranova"),
            array("first_name" => "Victor", "last_name" => "Petrovich"),
            array("first_name" => "Mikhail", "last_name" => "Romanov"),
            array("first_name" => "Alyona", "last_name" => "Sergieva"),
            array("first_name" => "Andrei", "last_name" => "Fedorov")
        );


        foreach ($people as $person) {
            $user = User::create([
                'email' => $person['first_name'] . '@gmail.com',
                'password' => Hash::make('12345678'),
            ]);

            $student = $user->student()->create([
                'first_name' => $person['first_name'],
                'last_name' => $person['last_name'],
                'birthday' => date('Y-m-d', strtotime('21.11.1997')),
                'phone' => '0704323433',
            ]);

            $student->creditCard()->create([
                'card_number' => '1234567890123456',
                'card_type' => 'visa',
                'cvv' => '1234',
                'sum' => 100000,
            ]);

            $user->assignRole('student');
        }
    }
}
