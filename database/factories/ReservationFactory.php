<?php

namespace Database\Factories;

use App\Models\Destination;
use App\Models\Customer;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Reservation>
 */
class ReservationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // ===== FETCH RANDOM DESTINATION =====
        // Uses existing destinations from database
        $destination = Destination::inRandomOrder()->first() ?? Destination::factory()->create();

        // ===== FETCH RANDOM CUSTOMER =====
        // Uses existing customers created by CustomerFactory
        // Ambil customer dari database yang sudah di-seed
        $customer = Customer::inRandomOrder()->first() ?? Customer::factory()->create();

        // ===== CALCULATE RESERVATION DETAILS =====
        $quantity = $this->faker->numberBetween(1, 6);
        $totalPrice = $destination->price * $quantity;
        $reservationDate = $this->faker->dateTimeBetween('2025-09-01', '2025-11-30');

        // ===== CREATE TIMESTAMP LOGIC =====
        $createdAt = Carbon::instance($reservationDate)->subDays($this->faker->numberBetween(0, 15));

        return [
            'customer_id' => $customer->id,
            'customer_name' => $customer->name,
            'destination_id' => $destination->id,
            'reservation_date' => $reservationDate,
            'quantity' => $quantity,
            'total_price' => $totalPrice,
            'status' => $this->faker->randomElement(['pending', 'confirmed', 'cancelled']),
            'notes' => $this->faker->optional(0.3)->sentence(),
            'created_at' => $createdAt,
            'updated_at' => now(),
        ];
    }

    /**
     * State: Set status to pending
     * Used for newly created reservations awaiting confirmation
     *
     * @return static
     */
    public function pending(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'pending',  // ⏳ Awaiting admin confirmation
        ]);
    }

    /**
     * State: Set status to confirmed
     * Used for approved and confirmed reservations
     *
     * @return static
     */
    public function confirmed(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'confirmed',  // ✓ Approved and confirmed
        ]);
    }

    /**
     * State: Set status to cancelled
     * Used for cancelled or rejected reservations
     *
     * @return static
     */
    public function cancelled(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'cancelled',  // ✗ Cancelled or rejected
        ]);
    }
}

