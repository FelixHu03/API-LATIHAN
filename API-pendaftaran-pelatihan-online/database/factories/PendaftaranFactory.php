<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Pendaftaran>
 */
class PendaftaranFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // cara jalankan php artisan tinker
        // App\Models\Pendaftaean::factory()->create(); untuk 1 data
        // App\Models\Pendaftaean::factory(10)->create(); untuk 10 data
        return [
            'nama' => fake()->name,
            'email' => fake()->unique()->safeEmail,
            'nomor_telepon' => fake()->unique()->numerify('##########'),
            'tingkat_sekolah' => 'MDP'
        ];
    }
}
