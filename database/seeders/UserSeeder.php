<?php

namespace Database\Seeders;

use App\Models\Users;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Seed default admin users for the application.
     * 
     * Creates 2 admin users with default credentials for testing.
     * For production: change passwords and credentials before deployment.
     *
     * @return void
     */
    public function run(): void
    {
        // ===== ADMIN USER #1 =====
        // Default admin user for development/testing
        Users::create([
            'username' => 'Dimas',                          // Username for login
            'email' => 'dimas@wisata.com',                 // Email identifier
            'password' => Hash::make('admin123'),          // Hashed password (Hash::make)
            'No_Handphone' => '081234567890',              // Phone number (Indonesian format)
            'role' => 'admin',                             // Admin role for authorization
        ]);

        // ===== ADMIN USER #2 =====
        // Secondary admin user for testing multi-user scenarios
        Users::create([
            'username' => 'Iwan',                          // Username for login
            'email' => 'iwan@wisata.com',                  // Email identifier
            'password' => Hash::make('admin123'),          // Hashed password (Hash::make)
            'No_Handphone' => '089876543210',              // Phone number (Indonesian format)
            'role' => 'admin',                             // Admin role for authorization
        ]);
        // ==== ADMIN USER #3 ====
        // Third admin user for testing multi-user scenarios
        Users::create([
            'username' => 'Septian',                       // Username for login
            'email' => 'septian@wisata.com',               // Email identifier
            'password' => Hash::make('admin123'),          // Hashed password (Hash::make)
            'No_Handphone' => '089876543210',              // Phone number (Indonesian format)
            'role' => 'admin',                             // Admin role for authorization
        ]);
    }
}
