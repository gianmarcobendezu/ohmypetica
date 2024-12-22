<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;


class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::firstOrCreate(
            ['email' => 'admin@ohmypetica.com'],
            ['name' => 'Admin User', 'password' => bcrypt('pass2025')]
        );

        User::firstOrCreate(
            ['email' => 'staff@ohmypetica.com'],
            ['name' => 'Staff User', 'password' => bcrypt('pass2025')]
        );

        User::firstOrCreate(
            ['email' => 'user@ohmypetica.com'],
            ['name' => 'Regular User', 'password' => bcrypt('pass2025')]
        );
    }
}
