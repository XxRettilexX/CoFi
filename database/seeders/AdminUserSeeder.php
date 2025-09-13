<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@cofi.com'], // evita duplicati
            [
                'name' => 'Admin',
                'email' => 'admin@cofi.com',
                'password' => Hash::make('admin123'), // puoi cambiarla
                'role' => 'admin',
            ]
        );
    }
}
