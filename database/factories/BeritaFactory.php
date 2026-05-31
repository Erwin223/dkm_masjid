<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Berita>
 */
class BeritaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $judul = $this->faker->sentence(4);

        return [
            'tanggal' => $this->faker->dateTimeBetween('-30 days', 'now'),
            'penulis' => $this->faker->name(),
            'gambar' => 'https://via.placeholder.com/500x300?text=' . urlencode(substr($judul, 0, 30)),
            'judul' => $judul,
            'sinopsis' => $this->faker->paragraph(3),
            'isi_berita' => $this->faker->paragraphs(5, true),
        ];
    }
}
