<?php

namespace Database\Seeders;

use App\Models\Student;
use Illuminate\Database\Seeder;

class StudentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Student::create([
            'first_name' => 'Avtandil',
            'last_name' => 'Kurbanov',
            'birthday' => date('Y-m-d', strtotime('12.04.1997')),
            'address' => 'Bishkek city',
            'phone' => '0704323433',
            'email' => 'avtandilkgg@gmail.com',
        ]);

        Student::create([
            'first_name' => 'Dastan',
            'last_name' => 'Kushnazarov',
            'birthday' => date('Y-m-d', strtotime('12.04.1997')),
            'address' => 'Jalal-Abad',
            'phone' => '0777329033',
            'email' => 'dastan@gmail.com',
        ]);

        Student::create([
            'first_name' => 'Malika',
            'last_name' => 'Malikova',
            'birthday' => date('Y-m-d', strtotime('12.04.1997')),
            'address' => 'Vostok 5',
            'phone' => '0779829053',
            'email' => 'malika@gmail.com',
        ]);
    }
}
