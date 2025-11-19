<?php

namespace Database\Factories;

use App\Models\Destination;
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
        $indonesianNames = [
            // Nama Depan Laki-laki
            'Budi Santoso', 'Ahmad Riyadi', 'Dimas Bagus', 'Edi Prasetyo', 'Fajar Santoso',
            'Galang Permana', 'Hendra Wijaya', 'Indra Kusuma', 'Jaka Pratama', 'Krisna Wijaya',
            'Laksana Budiman', 'Maulana Arkan', 'Nirwan Cahyo', 'Oki Setyana', 'Pramudya Eka',
            'Raden Mas Anom', 'Surya Gunawan', 'Teguh Santoso', 'Usman Effendi', 'Vicky Prasetyo',
            'Wawan Hermawan', 'Xander Wijaya', 'Yogi Pramana', 'Zainal Arifin', 'Arief Budiman',
            // Nama Depan Perempuan
            'Siti Nurhaliza', 'Ratna Dewi', 'Yuni Handoko', 'Farah Annisa', 'Gita Wijaya',
            'Ika Putri', 'Karina Sela', 'Lina Marlina', 'Mita Kusuma', 'Nita Wijaya',
            'Putri Ayu', 'Rina Susanti', 'Sandra Wijaya', 'Tari Gede', 'Uci Nurjanah',
            'Vina Cahyani', 'Wanda Pratama', 'Yuki Handayani', 'Zara Ismawati', 'Elsa Puspita',
        ];

        $destination = Destination::inRandomOrder()->first() ?? Destination::factory()->create();
        $quantity = $this->faker->numberBetween(1, 6);
        $totalPrice = $destination->price * $quantity;
        $reservationDate = $this->faker->dateTimeBetween('2025-01-01', '2025-11-30');

        return [
            'customer_name' => $this->faker->randomElement($indonesianNames),
            'customer_email' => $this->faker->unique()->safeEmail(),
            'customer_phone' => '0' . $this->faker->numberBetween(81, 89) . $this->faker->numberBetween(10000000, 999999999),
            'destination_id' => $destination->id,
            'reservation_date' => $reservationDate,
            'quantity' => $quantity,
            'total_price' => $totalPrice,
            'status' => $this->faker->randomElement(['pending', 'confirmed', 'cancelled']),
            'notes' => $this->faker->optional(0.4)->sentence(),
            'created_at' => Carbon::instance($reservationDate)->subDays($this->faker->numberBetween(0, 30)),
            'updated_at' => now(),
        ];
    }

    /**
     * Indicate status is pending
     */
    public function pending(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'pending',
        ]);
    }

    /**
     * Indicate status is confirmed
     */
    public function confirmed(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'confirmed',
        ]);
    }

    /**
     * Indicate status is cancelled
     */
    public function cancelled(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'cancelled',
        ]);
    }
}
