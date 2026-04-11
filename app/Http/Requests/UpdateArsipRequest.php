<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateArsipRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'judul' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'kategori' => 'required|string|in:Surat,Dokumen,Laporan,Kontrak,Proposal,Lainnya',
            'tanggal_arsip' => 'required|date',
            'file' => 'nullable|file|mimes:pdf,doc,docx,xls,xlsx,jpg,png,jpeg|max:5120',
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'judul.required' => 'Judul arsip wajib diisi',
            'judul.max' => 'Judul arsip maksimal 255 karakter',
            'kategori.required' => 'Kategori arsip wajib dipilih',
            'kategori.in' => 'Kategori arsip tidak valid',
            'tanggal_arsip.required' => 'Tanggal arsip wajib diisi',
            'tanggal_arsip.date' => 'Format tanggal tidak valid',
            'file.file' => 'File yang diupload tidak valid',
            'file.mimes' => 'Format file harus: PDF, DOC, DOCX, XLS, XLSX, JPG, PNG, JPEG',
            'file.max' => 'Ukuran file maksimal 5MB',
        ];
    }

    /**
     * Get custom attributes for validator errors.
     */
    public function attributes(): array
    {
        return [
            'judul' => 'judul arsip',
            'deskripsi' => 'deskripsi arsip',
            'kategori' => 'kategori arsip',
            'tanggal_arsip' => 'tanggal arsip',
            'file' => 'file arsip',
        ];
    }
}
