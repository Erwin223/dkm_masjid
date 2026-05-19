<?php

namespace App\Http\Requests;

use App\Models\JadwalKegiatan;
use App\Models\KasKeluar;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateJadwalKegiatanRequest extends FormRequest
{
    public function authorize(): bool
    {
        $kegiatan = JadwalKegiatan::query()->find($this->route('id'));

        return $kegiatan !== null && ($this->user()?->can('update', $kegiatan) ?? false);
    }

    /**
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $kegiatan = JadwalKegiatan::query()->find($this->route('id'));

        return [
            'nama_kegiatan' => 'required|string|max:255',
            'tanggal' => 'required|date',
            'waktu' => 'nullable',
            'tempat' => 'nullable|string|max:255',
            'penanggung_jawab' => 'nullable|string|max:255',
            'estimasi_anggaran' => 'nullable|numeric|min:0',
            'keterangan' => 'nullable|string',
            'kas_keluar_id' => [
                'nullable',
                'integer',
                Rule::exists('kas_keluar', 'id')->where(function ($query) use ($kegiatan) {
                    $query->where('status', KasKeluar::STATUS_APPROVED);

                    if ($kegiatan?->kas_keluar_id) {
                        $query->orWhere('id', $kegiatan->kas_keluar_id);
                    }
                }),
            ],
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'estimasi_anggaran' => $this->normalizeNumber($this->input('estimasi_anggaran')),
        ]);
    }

    private function normalizeNumber(mixed $value): ?int
    {
        if ($value === null || $value === '') {
            return null;
        }

        $normalized = preg_replace('/[^\d]/', '', (string) $value);

        return $normalized === '' ? null : (int) $normalized;
    }
}
