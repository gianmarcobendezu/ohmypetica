<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Crear permisos
        $permissions = [
            'delete records',
            'view reports',
            // Agrega más permisos aquí
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // Crear roles
        $roles = [
            'admin',
            'staff',
            // Agrega más roles aquí
        ];

        foreach ($roles as $role) {
            Role::firstOrCreate(['name' => $role]);
        }

        // Asignar permisos a los roles
        $admin = Role::findByName('admin');
        $staff = Role::findByName('staff');

        $admin->givePermissionTo('delete records');
        $staff->givePermissionTo('view reports');
    }
}
