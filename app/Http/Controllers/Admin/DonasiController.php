<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Http\Request;
use App\Models\DonasiMasuk;
use App\Models\DonasiKeluar;
use App\Models\Donatur;
use App\Notifications\ApprovalRequested;

class DonasiController extends Controller
{
    private const JENIS_BARANG = ['Barang', 'Makanan', 'Pakaian', 'Lainnya'];

    // ==================== DONASI MASUK ====================

    public function masuk()
    {
        $data       = DonasiMasuk::with('donatur')->orderBy('tanggal', 'desc')->paginate(10);
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
            ]);
        }

        // Tentukan nama donatur
        if ($request->donatur_id) {
            $namaDonatur = Donatur::find($request->donatur_id)->nama;
        } else {
            $namaDonatur = $request->donatur_nama ?: 'Hamba Allah';
        }

        $jumlah = $this->normalizeNumber($payload['jumlah'] ?? 0);
        $total = $isBarang ? 0 : $jumlah;

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
            ]);
        }

        if ($request->donatur_id) {
            $namaDonatur = Donatur::find($request->donatur_id)->nama;
        } else {
            $namaDonatur = $request->donatur_nama ?: 'Hamba Allah';
        }

        $jumlah = $this->normalizeNumber($payload['jumlah'] ?? 0);
        $total = $isBarang ? 0 : $jumlah;

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
        $donasi = DonasiMasuk::findOrFail($id);

        if (!$donasi->deletionRequest) {
            \App\Models\DeletionRequest::create([
                'model_type' => get_class($donasi),
                'model_id' => $donasi->id,
                'user_id' => auth()->id(),
                'status' => 'pending',
            ]);

            $ketuas = \App\Models\Admin::where('role', 'ketua')->get();
            $adminName = auth()->user()->name ?? 'Admin';
            foreach ($ketuas as $ketua) {
                $ketua->notify(new \App\Notifications\DeletionRequested($adminName, 'Donasi Masuk'));
            }
        }

        return redirect()->route('donasi.masuk')
            ->with('success', 'Permintaan penghapusan telah dikirim. Menunggu persetujuan ketua.');
    }

    // ==================== DONASI KELUAR ====================

    public function keluar()
    {
        $data = DonasiKeluar::with('approver')
            ->orderByRaw("CASE status WHEN 'pending' THEN 0 WHEN 'rejected' THEN 1 ELSE 2 END")
            ->orderBy('tanggal', 'desc')
            ->paginate(10);
        $totalKeluar = DonasiKeluar::approved()->get()->sum('nilai_dana');
        $pendingKeluar = DonasiKeluar::pending()->get()->sum('nilai_dana');
        return view('admin.donasi.donasi_keluar_index', compact('data', 'totalKeluar', 'pendingKeluar'));
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
            ]);
        }

        DonasiKeluar::create([
            'tanggal'      => $request->tanggal,
            'jenis_donasi' => $request->jenis_donasi,
            'tujuan'       => $request->tujuan,
            'jumlah'       => $this->normalizeNumber($payload['jumlah'] ?? 0),
            'satuan'       => $isBarang ? trim((string) $request->satuan) : null,
            'nominal'      => null,
            'keterangan'   => $request->keterangan,
        ]);

        $ketuas = Admin::where('role', 'ketua')->get();
        $adminName = auth()->user()->name ?? 'Admin';
        foreach ($ketuas as $ketua) {
            $ketua->notify(new ApprovalRequested($adminName, 'Donasi Keluar'));
        }

        return redirect()->route('donasi.keluar')
            ->with('success', 'Data donasi keluar berhasil ditambahkan dengan status pending.');
    }

    public function keluarEdit($id)
    {
        $donasi = DonasiKeluar::findOrFail($id);
        return view('admin.donasi.donasi_keluar_edit', compact('donasi'));
    }

    public function keluarUpdate(Request $request, $id)
    {
        $donasiKeluar = DonasiKeluar::findOrFail($id);
        if ($donasiKeluar->isFinalized()) {
            return redirect()->route('donasi.keluar')
                ->with('error', 'Hanya donasi keluar berstatus pending yang bisa diubah.');
        }

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
            ]);
        }

        $donasiKeluar->update([
            'tanggal'      => $request->tanggal,
            'jenis_donasi' => $request->jenis_donasi,
            'tujuan'       => $request->tujuan,
            'jumlah'       => $this->normalizeNumber($payload['jumlah'] ?? 0),
            'satuan'       => $isBarang ? trim((string) $request->satuan) : null,
            'nominal'      => null,
            'keterangan'   => $request->keterangan,
        ]);

        return redirect()->route('donasi.keluar')
            ->with('success', 'Data donasi keluar berhasil diupdate');
    }

    public function keluarDelete($id)
    {
        $donasi = DonasiKeluar::findOrFail($id);

        if ($donasi->isFinalized()) {
            return redirect()->route('donasi.keluar')
                ->with('error', 'Hanya donasi keluar berstatus pending yang bisa diajukan untuk dihapus.');
        }

        if (!$donasi->deletionRequest) {
            \App\Models\DeletionRequest::create([
                'model_type' => get_class($donasi),
                'model_id' => $donasi->id,
                'user_id' => auth()->id(),
                'status' => 'pending',
            ]);

            $ketuas = \App\Models\Admin::where('role', 'ketua')->get();
            $adminName = auth()->user()->name ?? 'Admin';
            foreach ($ketuas as $ketua) {
                $ketua->notify(new \App\Notifications\DeletionRequested($adminName, 'Donasi Keluar'));
            }
        }

        return redirect()->route('donasi.keluar')
            ->with('success', 'Permintaan penghapusan telah dikirim. Menunggu persetujuan ketua.');
    }

    public function keluarApprove(Request $request, int $id)
    {
        abort_unless($request->user()?->isKetua(), 403);

        $donasiKeluar = DonasiKeluar::findOrFail($id);
        $donasiKeluar->approve($request->user());

        return redirect()->route('donasi.keluar')
            ->with('success', 'Donasi keluar berhasil di-approve.');
    }

    public function keluarReject(Request $request, int $id)
    {
        abort_unless($request->user()?->isKetua(), 403);

        $validated = $request->validate([
            'rejection_reason' => 'required|string|max:2000',
        ], [
            'rejection_reason.required' => 'Alasan penolakan wajib diisi.',
        ]);

        $donasiKeluar = DonasiKeluar::findOrFail($id);
        $donasiKeluar->reject($request->user(), $validated['rejection_reason']);

        return redirect()->route('donasi.keluar')
            ->with('success', 'Donasi keluar berhasil ditolak.');
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
