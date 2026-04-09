<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateDonasiKeluarRequest extends FormRequest
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
            'jenis_donasi' => 'required|string|max:255',
            'tujuan' => 'required|string|max:255',
            'jumlah' => 'required|numeric|min:0',
            'satuan' => 'nullable|string|max:50',
            'nominal' => 'nullable|numeric|min:0',
            'keterangan' => 'nullable|string|max:1000',
        ];

        // For barang, satuan and nominal are required
        if ($this->isJenisBarang($this->jenis_donasi)) {
            $rules['satuan'] = 'required|string|max:50';
            $rules['nominal'] = 'required|numeric|min:0';
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
            'tujuan.required' => 'Tujuan donasi wajib diisi',
            'jumlah.required' => 'Jumlah wajib diisi',
            'jumlah.numeric' => 'Jumlah harus berupa angka',
            'satuan.required' => 'Satuan wajib diisi untuk donasi barang',
            'nominal.required' => 'Nominal wajib diisi untuk donasi barang',
        ];
    }

    /**
     * Get the data to be validated from the request.
     */
    protected function prepareForValidation(): void
    {
        // Normalize numeric inputs
        $this->merge([
            'jumlah' => $this->normalizeNumber($this->jumlah),
            'nominal' => $this->normalizeNumber($this->nominal),
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
