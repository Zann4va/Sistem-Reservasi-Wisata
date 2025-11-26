<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     * 
     * This master seeder orchestrates all database seeding in proper order:
     * 1. Users (admin credentials)
     * 2. Destinations (10 tourist attractions)
     * 3. Customers (20 customer records)
     * 4. Reservations (50 reservation records)
     *
     * @return void
     */
    public function run(): void
    {
        // ===== SEED EXECUTION ORDER =====
        // Order matters: Users & Destinations first, then Customers, then Reservations
        // (Reservations have FK to both Destinations and Customers)
        $this->call([
            UserSeeder::class,           // Admin user credentials
            DestinationSeeder::class,    // 10 Indonesian destinations
            CustomerSeeder::class,       // 20 customer records
            ReservationSeeder::class,    // 50 reservation records
        ]);
    }
}

