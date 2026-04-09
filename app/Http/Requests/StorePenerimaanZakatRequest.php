<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StorePenerimaanZakatRequest extends FormRequest
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
        return [
            'muzakki_id' => 'required|exists:muzakki,id',
            'tanggal' => 'required|date',
            'jenis_zakat' => 'required|string|max:255',
            'bentuk_zakat' => 'required|in:Uang,Barang',
            'jumlah_zakat' => 'nullable|numeric|min:0',
            'satuan' => 'nullable|string|max:50',
            'nominal' => 'nullable|numeric|min:0',
            'nominal_pembagian' => 'nullable|numeric|min:0',
            'harga_barang_fitrah' => 'nullable|numeric|min:0',
            'jumlah_tanggungan' => 'nullable|integer|min:0',
            'standar_per_jiwa' => 'nullable|numeric|min:0',
            'metode_pembayaran' => 'nullable|string|max:255',
            'keterangan' => 'nullable|string|max:1000',
        ];
    }

    /**
     * Get custom error messages for validation rules.
     */
    public function messages(): array
    {
        return [
            'muzakki_id.required' => 'Pilih muzakki',
            'muzakki_id.exists' => 'Muzakki yang dipilih tidak valid',
            'tanggal.required' => 'Tanggal wajib diisi',
            'tanggal.date' => 'Format tanggal tidak valid',
            'jenis_zakat.required' => 'Jenis zakat wajib diisi',
            'bentuk_zakat.required' => 'Bentuk zakat wajib diisi',
            'bentuk_zakat.in' => 'Bentuk zakat harus Uang atau Barang',
            'nominal.numeric' => 'Nominal harus berupa angka',
            'jumlah_tanggungan.integer' => 'Jumlah tanggungan harus berupa angka',
        ];
    }

    /**
     * Get the data to be validated from the request.
     */
    protected function prepareForValidation(): void
    {
        // Normalize numeric inputs
        $this->merge([
            'jumlah_zakat' => $this->normalizeNumber($this->jumlah_zakat),
            'nominal' => $this->normalizeNumber($this->nominal),
            'nominal_pembagian' => $this->normalizeNumber($this->nominal_pembagian),
            'harga_barang_fitrah' => $this->normalizeNumber($this->harga_barang_fitrah),
            'standar_per_jiwa' => $this->normalizeNumber($this->standar_per_jiwa),
        ]);
    }

    /**
     * Normalize number format (handle comma as decimal separator)
     */
    private function normalizeNumber($value)
    {
        if (empty($value)) {
            return null;
        }
        return is_numeric($value) ? $value : str_replace(',', '.', $value);
    }
}
