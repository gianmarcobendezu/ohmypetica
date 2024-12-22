<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role; // Modelo de rol
use App\Models\User; // Modelo de usuario

class AssignRolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Ejemplo de usuarios y roles
        $usersWithRoles = [
            ['email' => 'admin@ohmypetica.com', 'role' => 'admin'],
            ['email' => 'staff@ohmypetica.com', 'role' => 'staff'],
            ['email' => 'user@ohmypetica.com', 'role' => 'user'],
        ];

        foreach ($usersWithRoles as $userData) {
            // Busca al usuario por email
            $user = User::where('email', $userData['email'])->first();

            if ($user) {
                // Asigna el rol al usuario
                $role = Role::firstOrCreate(['name' => $userData['role']]); // Crea el rol si no existe
                $user->assignRole($role);
                echo "Rol '{$userData['role']}' asignado al usuario '{$userData['email']}'\n";
            } else {
                echo "Usuario con email '{$userData['email']}' no encontrado.\n";
            }
        }
    }
}
