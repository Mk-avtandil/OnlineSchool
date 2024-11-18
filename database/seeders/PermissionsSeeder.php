<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionsSeeder extends Seeder
{
    public function run(): void
    {
        // Разрешения для супер администратора
        Permission::create(['name' => 'manage users']);
        Permission::create(['name' => 'manage courses and programs']);
        Permission::create(['name' => 'access all admin and teacher data']);

        // Разрешения для администратора
        Permission::create(['name' => 'manage courses']);
        Permission::create(['name' => 'assign teachers and students']);
        Permission::create(['name' => 'view student progress']);
        Permission::create(['name' => 'create schedule']);

        // Разрешения для преподавателя
        Permission::create(['name' => 'manage learning materials']);
        Permission::create(['name' => 'grade students']);
        Permission::create(['name' => 'check homework']);
        Permission::create(['name' => 'maintain progress journal']);

        // Разрешения для студентов
        Permission::create(['name' => 'access own courses']);
        Permission::create(['name' => 'submit homework']);
        Permission::create(['name' => 'view grades']);
    }
}
