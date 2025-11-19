<?php

namespace Database\Seeders;

use App\Models\Reservation;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class ReservationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * Generate 70+ reservasi dengan tanggal dari Jan 2025 - Nov 2025 menggunakan Factory
     */
    public function run(): void
    {
        // Generate 70 random reservations menggunakan factory
        Reservation::factory(70)->create();

        // Generate beberapa dengan status tertentu
        Reservation::factory(10)->pending()->create();
        Reservation::factory(15)->confirmed()->create();
        Reservation::factory(5)->cancelled()->create();
    }
}
