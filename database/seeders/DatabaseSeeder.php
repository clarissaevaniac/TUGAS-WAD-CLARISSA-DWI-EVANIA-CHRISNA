<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // Akun untuk login (aman dijalankan berulang kali)
        User::updateOrCreate(
            ['email' => 'admin@sjb.com'],
            ['name' => 'Admin SJB', 'password' => Hash::make('admin123'), 'role' => 'admin']
        );

        User::updateOrCreate(
            ['email' => 'petugas@sjb.com'],
            ['name' => 'Petugas SJB', 'password' => Hash::make('petugas123'), 'role' => 'petugas']
        );
    }
}
