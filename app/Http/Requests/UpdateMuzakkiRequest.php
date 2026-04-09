<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateMuzakkiRequest extends FormRequest
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
        $muzakkiId = $this->route('id');

        return [
            'nama' => 'required|string|max:255',
            'alamat' => 'nullable|string|max:500',
            'no_hp' => 'nullable|string|max:30',
            'email' => 'nullable|email|unique:muzakki,email,' . $muzakkiId . '|max:255',
            'status' => 'nullable|in:active,inactive',
            'tahun_daftar' => 'nullable|integer|min:2000|max:2100',
        ];
    }

    /**
     * Get custom error messages for validation rules.
     */
    public function messages(): array
    {
        return [
            'nama.required' => 'Nama muzakki wajib diisi',
            'nama.max' => 'Nama tidak boleh lebih dari 255 karakter',
            'email.email' => 'Format email tidak valid',
            'email.unique' => 'Email sudah terdaftar',
            'no_hp.max' => 'Nomor HP tidak boleh lebih dari 30 karakter',
            'tahun_daftar.integer' => 'Tahun harus berupa angka',
        ];
    }
}
