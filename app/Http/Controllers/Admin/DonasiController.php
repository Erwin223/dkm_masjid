<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\DonasiMasuk;
use App\Models\DonasiKeluar;
use App\Models\Donatur;

class DonasiController extends Controller
{
    private const JENIS_BARANG = ['Barang', 'Makanan', 'Pakaian'];

    // ==================== DONASI MASUK ====================

    public function masuk()
    {
        $data       = DonasiMasuk::with('donatur')->orderBy('tanggal', 'desc')->get();
        $totalMasuk = DonasiMasuk::sum('total');
        return view('admin.donasi.donasi_masuk_index', compact('data', 'totalMasuk'));
    }

    public function masukCreate()
    {
        $donaturList = Donatur::orderBy('nama', 'asc')->get();
        return view('admin.donasi.donasi_masuk_create', compact('donaturList'));
    }

    public function masukStore(Request $request)
    {
        $request->merge($this->normalizeDonasiMasukPayload($request));

        $payload = $request->validate([
            'tanggal'         => 'required|date',
            'donatur_id'      => 'nullable|exists:donatur,id',
            'donatur_nama'    => 'nullable|string',
            'jenis_donasi'    => 'required',
            'kategori_donasi' => 'required',
            'jumlah'          => 'required|numeric|min:0',
            'satuan'          => 'nullable|string|max:50',
            'total'           => 'nullable|numeric|min:0',
            'keterangan'      => 'nullable',
        ]);

        $isBarang = $this->isJenisBarang($request->jenis_donasi);

        if ($isBarang) {
            $request->validate([
                'satuan' => 'required|string|max:50',
                'total'  => 'required|numeric|min:0',
            ]);
        }

        // Tentukan nama donatur
        if ($request->donatur_id) {
            $namaDonatur = Donatur::find($request->donatur_id)->nama;
        } else {
            $namaDonatur = $request->donatur_nama ?: 'Hamba Allah';
        }

        $jumlah = $this->normalizeNumber($payload['jumlah'] ?? 0);
        $total = $isBarang
            ? $this->normalizeNumber($payload['total'] ?? 0)
            : $jumlah;

        DonasiMasuk::create([
            'donatur_id'      => $request->donatur_id ?: null,
            'donatur_nama'    => $namaDonatur,
            'tanggal'         => $request->tanggal,
            'jenis_donasi'    => $request->jenis_donasi,
            'kategori_donasi' => $request->kategori_donasi,
            'jumlah'          => $jumlah,
            'satuan'          => $isBarang ? trim((string) $request->satuan) : null,
            'total'           => $total,
            'keterangan'      => $request->keterangan,
        ]);

        return redirect()->route('donasi.masuk')
            ->with('success', 'Data donasi masuk berhasil ditambahkan');
    }

    public function masukEdit($id)
    {
        $donasi      = DonasiMasuk::findOrFail($id);
        $donaturList = Donatur::orderBy('nama', 'asc')->get();
        return view('admin.donasi.donasi_masuk_edit', compact('donasi', 'donaturList'));
    }

    public function masukUpdate(Request $request, $id)
    {
        $request->merge($this->normalizeDonasiMasukPayload($request));

        $payload = $request->validate([
            'tanggal'         => 'required|date',
            'donatur_id'      => 'nullable|exists:donatur,id',
            'donatur_nama'    => 'nullable|string',
            'jenis_donasi'    => 'required',
            'kategori_donasi' => 'required',
            'jumlah'          => 'required|numeric|min:0',
            'satuan'          => 'nullable|string|max:50',
            'total'           => 'nullable|numeric|min:0',
            'keterangan'      => 'nullable',
        ]);

        $isBarang = $this->isJenisBarang($request->jenis_donasi);

        if ($isBarang) {
            $request->validate([
                'satuan' => 'required|string|max:50',
                'total'  => 'required|numeric|min:0',
            ]);
        }

        if ($request->donatur_id) {
            $namaDonatur = Donatur::find($request->donatur_id)->nama;
        } else {
            $namaDonatur = $request->donatur_nama ?: 'Hamba Allah';
        }

        $jumlah = $this->normalizeNumber($payload['jumlah'] ?? 0);
        $total = $isBarang
            ? $this->normalizeNumber($payload['total'] ?? 0)
            : $jumlah;

        DonasiMasuk::findOrFail($id)->update([
            'donatur_id'      => $request->donatur_id ?: null,
            'donatur_nama'    => $namaDonatur,
            'tanggal'         => $request->tanggal,
            'jenis_donasi'    => $request->jenis_donasi,
            'kategori_donasi' => $request->kategori_donasi,
            'jumlah'          => $jumlah,
            'satuan'          => $isBarang ? trim((string) $request->satuan) : null,
            'total'           => $total,
            'keterangan'      => $request->keterangan,
        ]);

        return redirect()->route('donasi.masuk')
            ->with('success', 'Data donasi masuk berhasil diupdate');
    }

    public function masukDelete($id)
    {
        DonasiMasuk::findOrFail($id)->delete();
        return redirect()->route('donasi.masuk')
            ->with('success', 'Data donasi masuk berhasil dihapus');
    }

    // ==================== DONASI KELUAR ====================

    public function keluar()
    {
        $data        = DonasiKeluar::orderBy('tanggal', 'desc')->get();
        $totalKeluar = $data->sum('nilai_dana');
        return view('admin.donasi.donasi_keluar_index', compact('data', 'totalKeluar'));
    }

    public function keluarCreate()
    {
        return view('admin.donasi.donasi_keluar_create');
    }

    public function keluarStore(Request $request)
    {
        $request->merge($this->normalizeDonasiKeluarPayload($request));

        $payload = $request->validate([
            'tanggal'      => 'required|date',
            'jenis_donasi' => 'required',
            'tujuan'       => 'required',
            'jumlah'       => 'required|numeric|min:0',
            'satuan'       => 'nullable|string|max:50',
            'nominal'      => 'nullable|numeric|min:0',
            'keterangan'   => 'nullable',
        ]);

        $isBarang = $this->isJenisBarang($request->jenis_donasi);

        if ($isBarang) {
            $request->validate([
                'satuan'  => 'required|string|max:50',
                'nominal' => 'required|numeric|min:0',
            ]);
        }

        DonasiKeluar::create([
            'tanggal'      => $request->tanggal,
            'jenis_donasi' => $request->jenis_donasi,
            'tujuan'       => $request->tujuan,
            'jumlah'       => $this->normalizeNumber($payload['jumlah'] ?? 0),
            'satuan'       => $isBarang ? trim((string) $request->satuan) : null,
            'nominal'      => $isBarang ? $this->normalizeNumber($payload['nominal'] ?? 0) : null,
            'keterangan'   => $request->keterangan,
        ]);

        return redirect()->route('donasi.keluar')
            ->with('success', 'Data donasi keluar berhasil ditambahkan');
    }

    public function keluarEdit($id)
    {
        $donasi = DonasiKeluar::findOrFail($id);
        return view('admin.donasi.donasi_keluar_edit', compact('donasi'));
    }

    public function keluarUpdate(Request $request, $id)
    {
        $request->merge($this->normalizeDonasiKeluarPayload($request));

        $payload = $request->validate([
            'tanggal'      => 'required|date',
            'jenis_donasi' => 'required',
            'tujuan'       => 'required',
            'jumlah'       => 'required|numeric|min:0',
            'satuan'       => 'nullable|string|max:50',
            'nominal'      => 'nullable|numeric|min:0',
            'keterangan'   => 'nullable',
        ]);

        $isBarang = $this->isJenisBarang($request->jenis_donasi);

        if ($isBarang) {
            $request->validate([
                'satuan'  => 'required|string|max:50',
                'nominal' => 'required|numeric|min:0',
            ]);
        }

        DonasiKeluar::findOrFail($id)->update([
            'tanggal'      => $request->tanggal,
            'jenis_donasi' => $request->jenis_donasi,
            'tujuan'       => $request->tujuan,
            'jumlah'       => $this->normalizeNumber($payload['jumlah'] ?? 0),
            'satuan'       => $isBarang ? trim((string) $request->satuan) : null,
            'nominal'      => $isBarang ? $this->normalizeNumber($payload['nominal'] ?? 0) : null,
            'keterangan'   => $request->keterangan,
        ]);

        return redirect()->route('donasi.keluar')
            ->with('success', 'Data donasi keluar berhasil diupdate');
    }

    public function keluarDelete($id)
    {
        DonasiKeluar::findOrFail($id)->delete();
        return redirect()->route('donasi.keluar')
            ->with('success', 'Data donasi keluar berhasil dihapus');
    }

    private function isJenisBarang(?string $jenisDonasi): bool
    {
        return in_array($jenisDonasi, self::JENIS_BARANG, true);
    }

    private function normalizeDonasiMasukPayload(Request $request): array
    {
        return [
            'jumlah' => $this->normalizeNumber($request->input('jumlah')),
            'total' => $this->normalizeNumber($request->input('total')),
        ];
    }

    private function normalizeDonasiKeluarPayload(Request $request): array
    {
        return [
            'jumlah' => $this->normalizeNumber($request->input('jumlah')),
            'nominal' => $this->normalizeNumber($request->input('nominal')),
        ];
    }

    private function normalizeNumber($value): float
    {
        if ($value === null || $value === '') {
            return 0;
        }

        if (is_numeric($value)) {
            return (float) $value;
        }

        if (is_string($value)) {
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

                if (count($parts) > 2) {
                    $value = str_replace('.', '', $value);
                } elseif (isset($parts[1]) && strlen($parts[1]) === 3) {
                    $value = str_replace('.', '', $value);
                }
            }
        }

        return (float) $value;
    }
}
