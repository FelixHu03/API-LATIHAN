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
        return [
            'nama' => fake()->name,
            'email' => fake()->unique()->safeEmail(),
            'nomorTelepon' => fake()->unique()->numerify('##########'),
            'tingkatSekolah' => fake()->randomElement(['SD','SMP', 'SMA', 'Universitas']),
        ];
    }
}
