<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Antrian;
use App\Models\Layanan;
use App\Models\Instansi;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Admin
        User::factory()->create([
            'name' => 'admin',
            'email' => 'admin@example.com',
            'password' => '12345',
            'role' => 'admin'
        ]);

        User::factory()->create([
            'name' => 'peserta1',
            'email' => 'peserta1@example.com',
            'password' => '12345',
            'role' => 'peserta'
        ]);
    

        // Instansi & Layanan
        $instansis = Instansi::factory(3)->create();
        $users = User::all();

        $instansis->each(function ($instansi) use ($users) {
            $layanans = Layanan::factory(5)->create([
                'instansi_id' => $instansi->id,
            ]);

            $layanans->each(function ($layanan) use ($instansi, $users) {
                if ($users->count() > 0) {
                    Antrian::factory(10)->create([
                        'layanan_id' => $layanan->id,
                        'instansi_id' => $instansi->id,
                        'user_id' => $users->random()->id,
                    ]);
                }
            });
        });
    }
}
