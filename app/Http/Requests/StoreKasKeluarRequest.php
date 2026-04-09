<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreKasKeluarRequest extends FormRequest
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
            'jenis_pengeluaran' => 'required|string|max:255',
            'nominal' => 'required|numeric|min:0',
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
            'jenis_pengeluaran.required' => 'Jenis pengeluaran wajib diisi',
            'jenis_pengeluaran.max' => 'Jenis pengeluaran tidak boleh lebih dari 255 karakter',
            'nominal.required' => 'Nominal wajib diisi',
            'nominal.numeric' => 'Nominal harus berupa angka',
            'nominal.min' => 'Nominal tidak boleh negatif',
        ];
    }

    /**
     * Get the data to be validated from the request.
     */
    protected function prepareForValidation(): void
    {
        // Normalize numeric input
        $this->merge([
            'nominal' => $this->normalizeNumber($this->nominal),
        ]);
    }

    /**
     * Normalize number format - remove dots used as thousand separators
     */
    private function normalizeNumber($value)
    {
        if ($value === null || $value === '') {
            return 0;
        }

        // Remove all dots (thousand separators)
        return (int) str_replace('.', '', (string) $value);
    }
}
