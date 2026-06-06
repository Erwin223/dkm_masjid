<?php

namespace Database\Seeders;

use App\Models\Pengurus;
use Illuminate\Database\Seeder;

class DummyPengurusSeeder extends Seeder
{
    public function run(): void
    {
        // Truncate existing records to avoid duplication
        Pengurus::truncate();

        // 1. Pengurus Inti
        Pengurus::create([
            'nama' => 'H. Ahmad Fauzi, Lc.',
            'jabatan' => 'Ketua DKM',
            'no_hp' => '081234567890',
            'foto' => null,
        ]);

        Pengurus::create([
            'nama' => 'H. Kurniawan, S.T.',
            'jabatan' => 'Sekretaris',
            'no_hp' => '085712345678',
            'foto' => null,
        ]);

        Pengurus::create([
            'nama' => 'H. M. Ridwan, M.M.',
            'jabatan' => 'Bendahara',
            'no_hp' => '089612345678',
            'foto' => null,
        ]);

        // 2. Anggota/Divisi
        $divisi = [
            'Keamanan' => 12,
            'Kebersihan' => 8,
            'Perlengkapan & Logistik' => 15,
            'Humas & Kemitraan' => 6,
            'Bidang Dakwah & Ibadah' => 5,
        ];

        foreach ($divisi as $jabatan => $count) {
            for ($i = 1; $i <= $count; $i++) {
                Pengurus::create([
                    'nama' => 'Anggota ' . $jabatan . ' ' . $i,
                    'jabatan' => $jabatan,
                    'no_hp' => null,
                    'foto' => null,
                ]);
            }
        }
    }
}
