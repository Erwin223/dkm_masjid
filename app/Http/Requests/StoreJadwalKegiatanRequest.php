<?php

namespace App\Http\Requests;

use App\Models\JadwalKegiatan;
use App\Models\KasKeluar;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreJadwalKegiatanRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->can('create', JadwalKegiatan::class) ?? false;
    }

    /**
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
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
                Rule::exists('kas_keluar', 'id')->where(fn ($query) => $query->where('status', KasKeluar::STATUS_APPROVED)),
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
