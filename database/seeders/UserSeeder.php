<?php

namespace Database\Seeders;

use App\Models\Users;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Buat admin user
        Users::create([
            'username' => 'Dimas',
            'email' => 'dimas@wisata.com',
            'password' => Hash::make('admin123'),
            'No_Handphone' => '081234567890',
            'role' => 'admin',
        ]);

        Users::create([
            'Username' => 'Iwan',
            'email' => 'iwan@wisata.com',
            'password' => Hash::make('admin123'),
            'No_Handphone' => '089876543210',
            'role' => 'admin',
        ]);
    }
}
