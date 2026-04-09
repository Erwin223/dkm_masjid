<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateDistribusiZakatRequest extends FormRequest
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
            'tanggal' => 'required|date',
            'mustahik_id' => 'required|exists:mustahik,id',
            'penerimaan_zakat_id' => 'nullable|exists:penerimaan_zakat,id',
            'jenis_zakat' => 'required|string|max:255',
            'bentuk_zakat' => 'required|in:Uang,Barang',
            'jumlah_zakat' => 'nullable|numeric|min:0',
            'satuan' => 'nullable|string|max:50',
            'nominal' => 'nullable|numeric|min:0',
            'harga_barang_fitrah' => 'nullable|numeric|min:0',
            'keterangan' => 'nullable|string|max:1000',
        ];
    }

    /**
     * Get custom error messages for validation rules.
     */
    public function messages(): array
    {
        return [
            'tanggal.required' => 'Tanggal wajib diisi',
            'tanggal.date' => 'Format tanggal tidak valid',
            'mustahik_id.required' => 'Pilih mustahik',
            'mustahik_id.exists' => 'Mustahik yang dipilih tidak valid',
            'jenis_zakat.required' => 'Jenis zakat wajib diisi',
            'bentuk_zakat.required' => 'Bentuk zakat wajib diisi',
            'bentuk_zakat.in' => 'Bentuk zakat harus Uang atau Barang',
            'nominal.numeric' => 'Nominal harus berupa angka',
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
            'harga_barang_fitrah' => $this->normalizeNumber($this->harga_barang_fitrah),
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
