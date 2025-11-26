<?php

namespace Database\Seeders;

use App\Models\Reservation;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class ReservationSeeder extends Seeder
{
    /**
     * Seed 50 reservation records using ReservationFactory.
     * 
     * Generates realistic test data with:
     * - Linked to existing customers
     * - Linked to existing destinations
     * - Random status distribution
     * - Realistic pricing based on destinations
     * 
     * Data Distribution (50 total):
     * - 35 random mixed statuses (70%)
     * - 10 pending reservations (20%)
     * - 5 confirmed reservations (10%)
     *
     * @return void
     */
    public function run(): void
    {
        // ===== GENERATE RANDOM RESERVATIONS =====
        // 35 reservations with random status mix
        // Uses ReservationFactory to generate with customer_id & destination_id
        Reservation::factory(100)->create();

        // ===== GENERATE STATUS-SPECIFIC RESERVATIONS =====
        // 10 pending reservations (awaiting confirmation)
        Reservation::factory(90)->pending()->create();

        // 5 confirmed reservations (approved)
        Reservation::factory(30)->confirmed()->create();

        // ===== TOTAL RESERVATIONS CREATED: 50 =====
    }
}
