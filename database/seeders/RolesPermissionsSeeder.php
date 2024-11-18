<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolesPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $superAdmin = Role::findByName('super_admin');
        $superAdmin->givePermissionTo(Permission::all());

        $admin = Role::findByName('admin');
        $admin->givePermissionTo([
            'manage courses',
            'assign teachers and students',
            'view student progress',
            'create schedule',
        ]);

        $teacher = Role::findByName('teacher');
        $teacher->givePermissionTo([
            'manage learning materials',
            'grade students',
            'check homework',
            'maintain progress journal',
        ]);

        $student = Role::findByName('student');
        $student->givePermissionTo([
            'access own courses',
            'submit homework',
            'view grades',
        ]);
    }
}
