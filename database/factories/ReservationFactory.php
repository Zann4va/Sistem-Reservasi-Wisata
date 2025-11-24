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
        // ===== INDONESIAN NAMES DATABASE (80+ authentic names) =====
        // Curated list of common Indonesian names (male & female)
        $indonesianNames = [
            // MALE NAMES (40)
            'Budi Santoso',
            'Ahmad Riyadi',
            'Dimas Bagus',
            'Edi Prasetyo',
            'Fajar Santoso',
            'Galang Permana',
            'Hendra Wijaya',
            'Indra Kusuma',
            'Jaka Pratama',
            'Krisna Wijaya',
            'Laksana Budiman',
            'Maulana Arkan',
            'Nirwan Cahyo',
            'Oki Setyana',
            'Pramudya Eka',
            'Raden Mas Anom',
            'Surya Gunawan',
            'Teguh Santoso',
            'Usman Effendi',
            'Vicky Prasetyo',
            'Wawan Hermawan',
            'Xander Wijaya',
            'Yogi Pramana',
            'Zainal Arifin',
            'Arief Budiman',
            'Bambang Setiawan',
            'Candra Wijaya',
            'Danang Hermawan',
            'Eka Prasetyo',
            'Firman Wijaya',
            'Gendro Purnomo',
            'Haris Suryanto',
            'Iman Santoso',
            'Joko Susilo',
            'Kuat Gunawan',
            'Luthfi Rahman',
            'Mansur Wijaya',
            'Nanda Pratama',
            'Oman Setiawan',
            'Panji Wijaya',
            'Rinto Hermawan',
            'Slamet Riyanto',
            'Taufik Rahman',
            'Udin Suryanto',
            'Vino Wijaya',
            'Wisnu Santoso',
            'Xeno Pratama',
            'Yusuf Gunawan',
            'Zam Setiawan',
            'Arifin Wijaya',

            // FEMALE NAMES (40)
            'Siti Nurhaliza',
            'Ratna Dewi',
            'Yuni Handoko',
            'Farah Annisa',
            'Gita Wijaya',
            'Ika Putri',
            'Karina Sela',
            'Lina Marlina',
            'Mita Kusuma',
            'Nita Wijaya',
            'Putri Ayu',
            'Rina Susanti',
            'Sandra Wijaya',
            'Tari Gede',
            'Uci Nurjanah',
            'Vina Cahyani',
            'Wanda Pratama',
            'Yuki Handayani',
            'Zara Ismawati',
            'Elsa Puspita',
            'Ayu Lestari',
            'Bintang Sari',
            'Citra Dewi',
            'Diana Kusuma',
            'Evy Wijaya',
            'Fitri Handayani',
            'Gina Puspita',
            'Hana Wijaya',
            'Ika Cahyani',
            'Jeny Santoso',
            'Kirana Dewi',
            'Linda Wijaya',
            'Mega Kusuma',
            'Nia Puspita',
            'Olivia Wijaya',
            'Paramita Sari',
            'Qonita Wijaya',
            'Rani Handayani',
            'Sri Wijaya',
            'Tina Kusuma',
            'Ulfa Puspita',
            'Vanda Wijaya',
            'Winda Cahyani',
            'Xiena Dewi',
            'Yanti Wijaya',
            'Zaina Puspita',
            'Amanda Wijaya',
            'Bina Kusuma',
            'Citra Cahyani',
            'Dwi Puspita',
        ];

        // ===== INDONESIAN EMAIL DOMAINS =====
        // Popular Indonesian and international email providers
        $emailDomains = [
            'gmail.com',
            'yahoo.com',
            'outlook.com',
            'mail.com',
            'email.com',
            'inbox.com',
            'protonmail.com',
            'mailinator.com',
        ];

        // ===== GENERATE AUTHENTIC INDONESIAN EMAIL =====
        $name = $this->faker->randomElement($indonesianNames);
        $nameForEmail = strtolower(str_replace(' ', '.', $name));        // Convert to lowercase, replace space with dot
        $domain = $this->faker->randomElement($emailDomains);
        $randomSuffix = $this->faker->numberBetween(1, 9999);           // Add random suffix to avoid duplicates
        $email = $nameForEmail . $randomSuffix . '@' . $domain;         // Format: "budi.santoso1234@gmail.com"

        // ===== GENERATE INDONESIAN PHONE NUMBER =====
        // Format: 0XX XXXXXXXX (Indonesian phone format)
        $phonePrefix = $this->faker->numberBetween(81, 89);             // Operator codes: 081-089
        $phoneSuffix = $this->faker->numberBetween(10000000, 999999999);
        $phone = '0' . $phonePrefix . $phoneSuffix;                      // Format: "081234567890"

        // ===== FETCH RANDOM DESTINATION =====
        $destination = Destination::inRandomOrder()->first() ?? Destination::factory()->create();

        // ===== CALCULATE RESERVATION DETAILS =====
        $quantity = $this->faker->numberBetween(1, 6);                  // 1-6 people per reservation
        $totalPrice = $destination->price * $quantity;                  // Calculate total from price x quantity
        $reservationDate = $this->faker->dateTimeBetween('2025-09-01', '2025-11-30');

        // ===== CREATE TIMESTAMP LOGIC =====
        $createdAt = Carbon::instance($reservationDate)->subDays($this->faker->numberBetween(0, 15));

        return [
            'customer_name' => $name,
            'customer_email' => $email,
            'customer_phone' => $phone,
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

