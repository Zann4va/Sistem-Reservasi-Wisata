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
        $indonesianLocations = [
            'Jakarta, DKI Jakarta', 'Bandung, Jawa Barat', 'Surabaya, Jawa Timur',
            'Yogyakarta, DI Yogyakarta', 'Medan, Sumatera Utara', 'Makassar, Sulawesi Selatan',
            'Bali, Bali', 'Lombok, Nusa Tenggara Barat', 'Komodo, Nusa Tenggara Timur',
            'Sumatra, Sumatera Utara', 'Borneo, Kalimantan', 'Sulawesi, Sulawesi Tengah',
            'Flores, Nusa Tenggara Timur', 'Raja Ampat, Papua Barat', 'Gili Islands, Nusa Tenggara Barat',
        ];

        $destinationNames = [
            'Pantai Pasir Putih', 'Bukit Pemandangan Alam', 'Taman Nasional Lestari',
            'Pulau Eksotis', 'Puncak Gunung Abadi', 'Danau Indah Alami',
            'Kawah Vulkanik Aktif', 'Hutan Hujan Tropis', 'Teluk Berpasir Hitam',
            'Candi Bersejarah', 'Lembah Eksotis', 'Pantai Batu Karang',
        ];

        return [
            'name' => $this->faker->randomElement($destinationNames) . ' ' . rand(1, 99),
            'description' => $this->faker->paragraph(5),
            'location' => $this->faker->randomElement($indonesianLocations),
            'price' => $this->faker->randomElement([250000, 280000, 300000, 350000, 450000, 500000, 520000, 600000, 750000, 800000]),
            'image_url' => $this->faker->imageUrl(600, 400, 'nature'),
            'rating' => $this->faker->randomFloat(1, 4.0, 5.0),
            'total_visitors' => $this->faker->numberBetween(5000, 25000),
        ];
    }

    /**
     * Indicate a premium destination (high price & rating)
     */
    public function premium(): static
    {
        return $this->state(fn (array $attributes) => [
            'price' => $this->faker->randomElement([600000, 750000, 800000]),
            'rating' => $this->faker->randomFloat(1, 4.7, 5.0),
            'total_visitors' => $this->faker->numberBetween(15000, 25000),
        ]);
    }

    /**
     * Indicate a budget destination (low price)
     */
    public function budget(): static
    {
        return $this->state(fn (array $attributes) => [
            'price' => $this->faker->randomElement([250000, 280000, 300000, 350000]),
            'rating' => $this->faker->randomFloat(1, 4.0, 4.7),
            'total_visitors' => $this->faker->numberBetween(5000, 15000),
        ]);
    }
}
