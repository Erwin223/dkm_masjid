<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreDonasiMasukRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $rules = [
            'tanggal' => 'required|date',
            'donatur_id' => 'nullable|exists:donatur,id',
            'donatur_nama' => 'nullable|string|max:255',
            'jenis_donasi' => 'required|string|max:255',
            'kategori_donasi' => 'required|string|max:255',
            'jumlah' => 'required|numeric|min:0',
            'satuan' => 'nullable|string|max:50',
            'total' => 'nullable|numeric|min:0',
            'keterangan' => 'nullable|string|max:1000',
        ];

        if ($this->isJenisBarang($this->jenis_donasi)) {
            $rules['satuan'] = 'required|string|max:50';
            $rules['total'] = 'required|numeric|min:0';
        }

        return $rules;
    }

    /**
     * Get custom error messages for validation rules.
     */
    public function messages(): array
    {
        return [
            'tanggal.required' => 'Tanggal wajib diisi',
            'tanggal.date' => 'Format tanggal tidak valid',
            'jenis_donasi.required' => 'Jenis donasi wajib diisi',
            'kategori_donasi.required' => 'Kategori donasi wajib diisi',
            'jumlah.required' => 'Jumlah wajib diisi',
            'jumlah.numeric' => 'Jumlah harus berupa angka',
            'satuan.required' => 'Satuan wajib diisi untuk donasi barang',
            'total.required' => 'Total wajib diisi untuk donasi barang',
            'donatur_id.exists' => 'Donatur yang dipilih tidak valid',
        ];
    }

    /**
     * Get the data to be validated from the request.
     */
    protected function prepareForValidation(): void
    {
        $this->merge([
            'jumlah' => $this->normalizeNumber($this->jumlah),
            'total' => $this->normalizeNumber($this->total),
        ]);
    }

    /**
     * Check if jenis donasi is goods/barang
     */
    private function isJenisBarang(?string $jenisDonasi): bool
    {
        return in_array(strtolower($jenisDonasi), ['barang', 'makanan', 'pakaian']);
    }

    /**
     * Normalize number format
     */
    private function normalizeNumber($value)
    {
        if ($value === null || $value === '') {
            return null;
        }

        if (is_numeric($value)) {
            return $value + 0;
        }

        $value = preg_replace('/[^0-9,.-]/', '', (string) $value) ?? '';
        $value = trim($value);

        if ($value === '') {
            return null;
        }

        $hasDot = str_contains($value, '.');
        $hasComma = str_contains($value, ',');

        if ($hasDot && $hasComma) {
            $value = str_replace('.', '', $value);
            $value = str_replace(',', '.', $value);
        } elseif ($hasComma) {
            $value = str_replace('.', '', $value);
            $value = str_replace(',', '.', $value);
        }

        return is_numeric($value) ? $value + 0 : null;
    }
}
