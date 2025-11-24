<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Destination>
 */
class DestinationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // ===== INDONESIAN LOCATIONS DATABASE =====
        // Curated list of Indonesian provinces and popular tourist areas
        $indonesianLocations = [
            'Jakarta, DKI Jakarta',
            'Bandung, Jawa Barat',
            'Surabaya, Jawa Timur',
            'Yogyakarta, DI Yogyakarta',
            'Medan, Sumatera Utara',
            'Makassar, Sulawesi Selatan',
            'Bali, Bali',
            'Lombok, Nusa Tenggara Barat',
            'Komodo, Nusa Tenggara Timur',
            'Sumatra, Sumatera Utara',
            'Borneo, Kalimantan',
            'Sulawesi, Sulawesi Tengah',
            'Flores, Nusa Tenggara Timur',
            'Raja Ampat, Papua Barat',
            'Gili Islands, Nusa Tenggara Barat',
        ];

        // ===== DESTINATION NAMES DATABASE =====
        // Generic names that can be combined with random numbers for variety
        $destinationNames = [
            'Pantai Pasir Putih',
            'Bukit Pemandangan Alam',
            'Taman Nasional Lestari',
            'Pulau Eksotis',
            'Puncak Gunung Abadi',
            'Danau Indah Alami',
            'Kawah Vulkanik Aktif',
            'Hutan Hujan Tropis',
            'Teluk Berpasir Hitam',
            'Candi Bersejarah',
            'Lembah Eksotis',
            'Pantai Batu Karang',
        ];

        // ===== PRICE TIERS (in Rupiah) =====
        // Realistic price range for Indonesian tourist destinations
        $priceTiers = [
            250000,  // Budget
            280000,
            300000,
            350000,
            450000,  // Mid-range
            500000,
            520000,
            600000,  // Premium
            750000,
            800000,  // Luxury
        ];

        // ===== GENERATE DESTINATION DATA =====
        $name = $this->faker->randomElement($destinationNames) . ' ' . rand(1, 99);
        $description = $this->faker->paragraph(5);
        $location = $this->faker->randomElement($indonesianLocations);
        $price = $this->faker->randomElement($priceTiers);
        $rating = $this->faker->randomFloat(1, 4.0, 5.0);
        $totalVisitors = $this->faker->numberBetween(5000, 25000);

        return [
            'name' => $name,
            'description' => $description,
            'location' => $location,
            'price' => $price,
            'image_url' => $this->faker->imageUrl(600, 400, 'nature'),
            'rating' => $rating,
            'total_visitors' => $totalVisitors,
        ];
    }

    /**
     * State: Premium destination with high price and rating
     * Used for luxury/exclusive travel packages
     *
     * @return static
     */
    public function premium(): static
    {
        return $this->state(fn (array $attributes) => [
            // Premium tier pricing (Rp 600K - 800K)
            'price' => $this->faker->randomElement([
                600000,  // Rp 600.000
                750000,  // Rp 750.000
                800000,  // Rp 800.000
            ]),
            // High star rating (4.7 - 5.0)
            'rating' => $this->faker->randomFloat(1, 4.7, 5.0),
            // High visitor count (15K - 25K)
            'total_visitors' => $this->faker->numberBetween(15000, 25000),
        ]);
    }

    /**
     * State: Budget-friendly destination with lower price and moderate rating
     * Used for affordable travel packages
     *
     * @return static
     */
    public function budget(): static
    {
        return $this->state(fn (array $attributes) => [
            // Budget tier pricing (Rp 250K - 350K)
            'price' => $this->faker->randomElement([
                250000,  // Rp 250.000
                280000,  // Rp 280.000
                300000,  // Rp 300.000
                350000,  // Rp 350.000
            ]),
            // Moderate star rating (4.0 - 4.7)
            'rating' => $this->faker->randomFloat(1, 4.0, 4.7),
            // Moderate visitor count (5K - 15K)
            'total_visitors' => $this->faker->numberBetween(5000, 15000),
        ]);
    }
}
