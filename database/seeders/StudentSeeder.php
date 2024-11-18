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
         Student::create([
            'user_id' => 1,
            'first_name' => 'Avtandil',
            'last_name' => 'Kurbanov',
            'birthday' => date('Y-m-d', strtotime('12.04.1997')),
            'phone' => '0704323433',
        ]);
    }
}
