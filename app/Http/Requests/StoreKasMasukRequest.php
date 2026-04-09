<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreKasMasukRequest extends FormRequest
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
            'sumber' => 'required|string|max:255',
            'jumlah' => 'required|numeric|min:0',
            'keterangan' => 'nullable|string|max:1000',
        ];
    }

    /**
     * Get error messages for validation rules.
     */
    public function messages(): array
    {
        return [
            'tanggal.required' => 'Tanggal wajib diisi',
            'tanggal.date' => 'Format tanggal tidak valid',
            'sumber.required' => 'Sumber kas wajib diisi',
            'sumber.max' => 'Sumber tidak boleh lebih dari 255 karakter',
            'jumlah.required' => 'Jumlah wajib diisi',
            'jumlah.numeric' => 'Jumlah harus berupa angka',
            'jumlah.min' => 'Jumlah tidak boleh negatif',
        ];
    }

    /**
     * Get the data to be validated from the request.
     */
    protected function prepareForValidation(): void
    {
        // Normalize numeric input
        $this->merge([
            'jumlah' => $this->normalizeNumber($this->jumlah),
        ]);
    }

    /**
     * Normalize number format (handle comma and dot as decimal separator)
     */
    private function normalizeNumber($value)
    {
        if ($value === null || $value === '') {
            return 0;
        }

        if (is_numeric($value)) {
            return $value + 0;
        }

        $value = preg_replace('/[^0-9,.-]/', '', (string) $value) ?? '';
        $value = trim($value);

        if ($value === '') {
            return 0;
        }

        $hasDot = str_contains($value, '.');
        $hasComma = str_contains($value, ',');

        if ($hasDot && $hasComma) {
            $value = str_replace('.', '', $value);
            $value = str_replace(',', '.', $value);
        } elseif ($hasComma) {
            $value = str_replace('.', '', $value);
            $value = str_replace(',', '.', $value);
        } elseif ($hasDot) {
            $parts = explode('.', $value);
            if (count($parts) > 2 || (isset($parts[1]) && strlen($parts[1]) === 3)) {
                $value = str_replace('.', '', $value);
            }
        }

        return is_numeric($value) ? $value + 0 : 0;
    }
}
