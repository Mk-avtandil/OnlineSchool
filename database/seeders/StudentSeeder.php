<?php

namespace Database\Seeders;

use App\Models\Student;
use Illuminate\Database\Seeder;

class StudentSeeder extends Seeder
{
    public function run(): void
    {
        Student::create([
            'first_name' => 'Avtandil',
            'last_name' => 'Kurbanov',
            'birthday' => date('Y-m-d', strtotime('12.04.1997')),
            'address' => 'Kudaibergen',
            'phone' => '0704323433',
            'email' => 'avtandil@gmail.com',
        ]);

        Student::create([
            'first_name' => 'Dastan',
            'last_name' => 'Dastanov',
            'birthday' => date('Y-m-d', strtotime('12.02.1999')),
            'address' => '8mkr',
            'phone' => '0777329033',
            'email' => 'dastan@gmail.com',
        ]);

        Student::create([
            'first_name' => 'Bek',
            'last_name' => 'Bekov',
            'birthday' => date('Y-m-d', strtotime('12.04.2000')),
            'address' => '2mkr',
            'phone' => '0779829053',
            'email' => 'bek@gmail.com',
        ]);

        Student::create([
            'first_name' => 'Erjan',
            'last_name' => 'Erjanov',
            'birthday' => date('Y-m-d', strtotime('12.04.1996')),
            'address' => '1mkr',
            'phone' => '0779829053',
            'email' => 'erjan@gmail.com',
        ]);

        Student::create([
            'first_name' => 'Islam',
            'last_name' => 'Islamov',
            'birthday' => date('Y-m-d', strtotime('10.10.1990')),
            'address' => '5mkr',
            'phone' => '0779831053',
            'email' => 'islam@gmail.com',
        ]);
    }
}
