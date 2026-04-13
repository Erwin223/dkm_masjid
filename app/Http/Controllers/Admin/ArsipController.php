<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreArsipRequest;
use App\Http\Requests\UpdateArsipRequest;
use App\Models\Arsip;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ArsipController extends Controller
{
    // =======================
    // LIST DATA
    // =======================
    public function index()
    {
        $data = Arsip::orderBy('tanggal_arsip', 'desc')->get();
        return view('admin.arsip.index', compact('data'));
    }

    // =======================
    // FORM CREATE
    // =======================
    public function create()
    {
        $kategori_list = ['Surat', 'Dokumen', 'Laporan', 'Kontrak', 'Proposal', 'Lainnya'];
        $jenis_surat_list = ['masuk', 'keluar'];
        return view('admin.arsip.create', compact('kategori_list', 'jenis_surat_list'));
    }

    // =======================
    // SIMPAN DATA
    // =======================
    public function store(StoreArsipRequest $request)
    {
        $validated = $request->validated();

        $file_path = null;
        $nama_file_asli = null;

        // UPLOAD FILE
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $nama_file_asli = $file->getClientOriginalName();
            $file_path = $file->store('arsip', 'public');
        }

        Arsip::create([
            'judul' => $validated['judul'],
            'deskripsi' => $validated['deskripsi'],
            'kategori' => $validated['kategori'],
            'jenis_surat' => $validated['jenis_surat'] ?? null,
            'tanggal_arsip' => $validated['tanggal_arsip'],
            'file' => $file_path,
            'nama_file_asli' => $nama_file_asli
        ]);

        return redirect()->route('arsip.index')
            ->with('success', 'Arsip berhasil ditambahkan');
    }

    // =======================
    // FORM EDIT
    // =======================
    public function edit($id)
    {
        $data = Arsip::findOrFail($id);
        $kategori_list = ['Surat', 'Dokumen', 'Laporan', 'Kontrak', 'Proposal', 'Lainnya'];
        $jenis_surat_list = ['masuk', 'keluar'];
        return view('admin.arsip.edit', compact('data', 'kategori_list', 'jenis_surat_list'));
    }

    // =======================
    // UPDATE DATA
    // =======================
    public function update(UpdateArsipRequest $request, $id)
    {
        $validated = $request->validated();
        $data = Arsip::findOrFail($id);

        $file_path = $data->file;
        $nama_file_asli = $data->nama_file_asli;

        if ($request->hasFile('file')) {
            if ($data->file && Storage::disk('public')->exists($data->file)) {
                Storage::disk('public')->delete($data->file);
            }

            $file = $request->file('file');
            $nama_file_asli = $file->getClientOriginalName();
            $file_path = $file->store('arsip', 'public');
        }

        $data->update([
            'judul' => $validated['judul'],
            'deskripsi' => $validated['deskripsi'],
            'kategori' => $validated['kategori'],
            'jenis_surat' => $validated['jenis_surat'] ?? null,
            'tanggal_arsip' => $validated['tanggal_arsip'],
            'file' => $file_path,
            'nama_file_asli' => $nama_file_asli
        ]);

        return redirect()->route('arsip.index')
            ->with('success', 'Arsip berhasil diupdate');
    }

    // =======================
    // HAPUS DATA
    // =======================
    public function destroy($id)
    {
        $data = Arsip::findOrFail($id);

        // HAPUS FILE JIKA ADA
        if ($data->file && Storage::disk('public')->exists($data->file)) {
            Storage::disk('public')->delete($data->file);
        }

        $data->delete();

        return redirect()->route('arsip.index')
            ->with('success', 'Arsip berhasil dihapus');
    }

    // =======================
    // DOWNLOAD FILE
    // =======================
    public function download($id)
    {
        $data = Arsip::findOrFail($id);
        $file_path = storage_path('app/public/' . $data->file);

        if (!file_exists($file_path)) {
            return redirect()->route('arsip.index')
                ->with('error', 'File tidak ditemukan');
        }

        return response()->download($file_path, $data->nama_file_asli);
    }
}
