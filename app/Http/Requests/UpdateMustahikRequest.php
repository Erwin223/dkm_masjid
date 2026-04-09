<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateMustahikRequest extends FormRequest
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
            'nama' => 'required|string|max:255',
            'alamat' => 'nullable|string|max:500',
            'no_hp' => 'nullable|string|max:30',
            'kategori_mustahik' => 'required|string|max:255',
            'keterangan' => 'nullable|string|max:1000',
        ];
    }

    /**
     * Get custom error messages for validation rules.
     */
    public function messages(): array
    {
        return [
            'nama.required' => 'Nama mustahik wajib diisi',
            'nama.max' => 'Nama tidak boleh lebih dari 255 karakter',
            'kategori_mustahik.required' => 'Kategori mustahik wajib diisi',
            'no_hp.max' => 'Nomor HP tidak boleh lebih dari 30 karakter',
        ];
    }
}
