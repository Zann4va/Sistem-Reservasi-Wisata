<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Customer>
 */
class CustomerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // ===== INDONESIAN NAMES DATABASE (100+ authentic names) =====
        // Curated list of common Indonesian names (male & female)
        $indonesianNames = [
            // MALE NAMES (60)
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
            'Rustam Hidayat',
            'Basuki Harjono',
            'Cahyo Widianto',
            'Didik Sutrisno',
            'Efriansyah Putra',
            'Fery Hermanto',
            'Gatot Sumarno',
            'Hendra Kusuma',
            'Irfan Harahap',
            'Jono Widjaja',
            'Koko Setiawan',

            // FEMALE NAMES (60)
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
            'Esti Nurjanah',
            'Fiona Rahmawati',
            'Gisela Dewantari',
            'Hesti Purnama',
            'Indah Permatasari',
            'Juwita Sari',
            'Kemala Wijaya',
            'Lestari Kusuma',
            'Mutiara Putri',
            'Nisa Ramadhani',
            'Ovilya Handayani',
        ];

        // ===== INDONESIAN CITIES =====
        $indonesianCities = [
            'Jakarta',
            'Bandung',
            'Surabaya',
            'Yogyakarta',
            'Medan',
            'Makassar',
            'Bali',
            'Lombok',
            'Semarang',
            'Malang',
            'Bogor',
            'Tangerang',
            'Depok',
            'Bekasi',
            'Cirebon',
            'Batang',
            'Purwokerto',
            'Sragen',
            'Klaten',
            'Salatiga',
        ];

        // ===== INDONESIAN PROVINCES =====
        $indonesianProvinces = [
            'DKI Jakarta',
            'Jawa Barat',
            'Jawa Timur',
            'DI Yogyakarta',
            'Jawa Tengah',
            'Sumatera Utara',
            'Sumatera Barat',
            'Riau',
            'Jambi',
            'Sumatera Selatan',
            'Lampung',
            'Bali',
            'Nusa Tenggara Barat',
            'Nusa Tenggara Timur',
            'Kalimantan Barat',
            'Kalimantan Tengah',
            'Kalimantan Selatan',
            'Kalimantan Timur',
            'Sulawesi Utara',
            'Sulawesi Tengah',
            'Sulawesi Selatan',
            'Papua',
        ];

        // ===== INDONESIAN EMAIL DOMAINS =====
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

        // ===== GENERATE AUTHENTIC INDONESIAN DATA =====
        // Generate UNIQUE name - tidak boleh ada nama yang sama
        do {
            $name = $this->faker->randomElement($indonesianNames);
        } while (\App\Models\Customer::where('name', $name)->exists());
        
        $nameForEmail = strtolower(str_replace(' ', '.', $name));
        $domain = $this->faker->randomElement($emailDomains);
        $randomSuffix = $this->faker->numberBetween(1, 9999);
        $email = $nameForEmail . $randomSuffix . '@' . $domain;

        // Generate Indonesian phone number (0XX XXXXXXXX format)
        // Phone juga unique
        do {
            $phonePrefix = $this->faker->numberBetween(81, 89);
            $phoneSuffix = $this->faker->numberBetween(10000000, 999999999);
            $phone = '0' . $phonePrefix . $phoneSuffix;
        } while (\App\Models\Customer::where('phone', $phone)->exists());

        return [
            'name' => $name,
            'email' => $email,
            'phone' => $phone,
            'address' => $this->faker->address(),
            'city' => $this->faker->randomElement($indonesianCities),
            'province' => $this->faker->randomElement($indonesianProvinces),
            'postal_code' => $this->faker->numerify('#####'),
            'notes' => $this->faker->optional(0.3)->sentence(),
        ];
    }
}
