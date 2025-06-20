<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Admin
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'mobile' => '081234567890',
            'password' => Hash::make('password123'),
            'utype' => 'ADM',
        ]);

        // User biasa
        User::create([
            'name' => 'Regular User',
            'email' => 'user@example.com',
            'mobile' => '089876543210',
            'password' => Hash::make('password123'),
            // tidak perlu isi utype karena default = USR
        ]);
    }
}
