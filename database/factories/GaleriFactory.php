<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Galeri>
 */
class GaleriFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $judul = $this->faker->words(3, true);
        
        return [
            'tanggal' => $this->faker->dateTimeBetween('-60 days', 'now'),
            'gambar' => 'https://via.placeholder.com/500x400?text=' . urlencode($judul),
            'judul' => $judul,
            'deskripsi' => $this->faker->paragraph(2),
        ];
    }
}
