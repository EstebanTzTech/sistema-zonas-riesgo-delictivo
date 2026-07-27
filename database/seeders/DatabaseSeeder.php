<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Crear usuario administrador para acceso al sistema
        User::updateOrCreate(
            ['email' => 'useradmintz@gmail.com'],
            [
                'name' => 'Administrador del Sistema',
                'password' => Hash::make('adminusertz'),
            ]
        );
    }
}

