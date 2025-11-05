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
            'email' => 'admin@wisata.com',
            'password' => Hash::make('admin123'),
            'No_Handphone' => '081234567890',
            'role' => 'admin',
        ]);

        // Buat user biasa (customer)
        Users::create([
            'username' => 'Santoso',
            'email' => 'customer1@wisata.com',
            'password' => Hash::make('customer123'),
            'No_Handphone' => '082345678901',
            'role' => 'user',
        ]);

        Users::create([
            'username' => 'Sugiono',
            'email' => 'customer2@wisata.com',
            'password' => Hash::make('customer123'),
            'No_Handphone' => '083456789012',
            'role' => 'user',
        ]);
    }
}
