<?php

namespace Database\Factories;

use App\Models\Instansi;
use App\Models\Layanan;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Antrian>
 */
class AntrianFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'tanggal_kunjungan' => fake()->date(),
           
            'layanan_id' => Layanan::factory(),
            'status_tiket' => fake()->randomElement(['aktif', 'selesai']),
        ];
    }
}
