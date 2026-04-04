<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DistribusiZakat;
use App\Models\Mustahik;
use App\Models\Muzakki;
use App\Models\PenerimaanZakat;
use Illuminate\Http\Request;

class ZakatController extends Controller
{
    private const BENTUK_UANG = 'Uang';
    private const BENTUK_BARANG = 'Barang';
    private const STANDAR_FITRAH_DEFAULT = 2.5;

    public function muzakki()
    {
        $data = Muzakki::withCount('penerimaanZakat')->orderBy('nama', 'asc')->get();
        return view('admin.zakat.muzakki_index', compact('data'));
    }

    public function muzakkiCreate()
    {
        return view('admin.zakat.muzakki_create');
    }

    public function muzakkiStore(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'alamat' => 'nullable|string',
            'no_hp' => 'nullable|string|max:30',
        ]);

        Muzakki::create($validated);

        return redirect()->route('zakat.muzakki.index')
            ->with('success', 'Data muzakki berhasil ditambahkan');
    }

    public function muzakkiEdit($id)
    {
        $muzakki = Muzakki::findOrFail($id);
        return view('admin.zakat.muzakki_edit', compact('muzakki'));
    }

    public function muzakkiUpdate(Request $request, $id)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'alamat' => 'nullable|string',
            'no_hp' => 'nullable|string|max:30',
        ]);

        Muzakki::findOrFail($id)->update($validated);

        return redirect()->route('zakat.muzakki.index')
            ->with('success', 'Data muzakki berhasil diupdate');
    }

    public function muzakkiDelete($id)
    {
        Muzakki::findOrFail($id)->delete();

        return redirect()->route('zakat.muzakki.index')
            ->with('success', 'Data muzakki berhasil dihapus');
    }

    public function penerimaan()
    {
        $data = PenerimaanZakat::with('muzakki')->orderBy('tanggal', 'desc')->get();
        return view('admin.zakat.penerimaan_index', compact('data'));
    }

    public function penerimaanCreate()
    {
        $muzakkiList = Muzakki::orderBy('nama', 'asc')->get();
        return view('admin.zakat.penerimaan_create', compact('muzakkiList'));
    }

    public function penerimaanStore(Request $request)
    {
        $validated = $request->validate([
            'muzakki_id' => 'required|exists:muzakki,id',
            'tanggal' => 'required|date',
            'jenis_zakat' => 'required|string|max:255',
            'bentuk_zakat' => 'required|in:Uang,Barang',
            'jumlah_zakat' => 'nullable|numeric|min:0',
            'satuan' => 'nullable|string|max:50',
            'nominal' => 'nullable|numeric|min:0',
            'nominal_pembagian' => 'nullable|numeric|min:0',
            'jumlah_tanggungan' => 'nullable|integer|min:0',
            'standar_per_jiwa' => 'nullable|numeric|min:0',
            'metode_pembayaran' => 'nullable|string|max:255',
            'keterangan' => 'nullable|string',
        ]);

        $this->validatePenerimaanBusinessRules($request);
        $validated = $this->preparePenerimaanPayload($validated);

        PenerimaanZakat::create($validated);

        return redirect()->route('zakat.penerimaan.index')
            ->with('success', 'Penerimaan zakat berhasil ditambahkan');
    }

    public function penerimaanEdit($id)
    {
        $penerimaan = PenerimaanZakat::findOrFail($id);
        $muzakkiList = Muzakki::orderBy('nama', 'asc')->get();
        return view('admin.zakat.penerimaan_edit', compact('penerimaan', 'muzakkiList'));
    }

    public function penerimaanUpdate(Request $request, $id)
    {
        $validated = $request->validate([
            'muzakki_id' => 'required|exists:muzakki,id',
            'tanggal' => 'required|date',
            'jenis_zakat' => 'required|string|max:255',
            'bentuk_zakat' => 'required|in:Uang,Barang',
            'jumlah_zakat' => 'nullable|numeric|min:0',
            'satuan' => 'nullable|string|max:50',
            'nominal' => 'nullable|numeric|min:0',
            'nominal_pembagian' => 'nullable|numeric|min:0',
            'jumlah_tanggungan' => 'nullable|integer|min:0',
            'standar_per_jiwa' => 'nullable|numeric|min:0',
            'metode_pembayaran' => 'nullable|string|max:255',
            'keterangan' => 'nullable|string',
        ]);

        $this->validatePenerimaanBusinessRules($request);
        $validated = $this->preparePenerimaanPayload($validated);

        PenerimaanZakat::findOrFail($id)->update($validated);

        return redirect()->route('zakat.penerimaan.index')
            ->with('success', 'Penerimaan zakat berhasil diupdate');
    }

    public function penerimaanDelete($id)
    {
        PenerimaanZakat::findOrFail($id)->delete();

        return redirect()->route('zakat.penerimaan.index')
            ->with('success', 'Penerimaan zakat berhasil dihapus');
    }

    public function mustahik()
    {
        $data = Mustahik::orderBy('nama', 'asc')->get();
        return view('admin.zakat.mustahik_index', compact('data'));
    }

    public function mustahikCreate()
    {
        return view('admin.zakat.mustahik_create');
    }

    public function mustahikStore(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'alamat' => 'nullable|string',
            'no_hp' => 'nullable|string|max:30',
            'kategori_mustahik' => 'required|string|max:255',
            'keterangan' => 'nullable|string',
        ]);

        Mustahik::create($validated);

        return redirect()->route('zakat.mustahik.index')
            ->with('success', 'Data mustahik berhasil ditambahkan');
    }

    public function mustahikEdit($id)
    {
        $mustahik = Mustahik::findOrFail($id);
        return view('admin.zakat.mustahik_edit', compact('mustahik'));
    }

    public function mustahikUpdate(Request $request, $id)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'alamat' => 'nullable|string',
            'no_hp' => 'nullable|string|max:30',
            'kategori_mustahik' => 'required|string|max:255',
            'keterangan' => 'nullable|string',
        ]);

        Mustahik::findOrFail($id)->update($validated);

        return redirect()->route('zakat.mustahik.index')
            ->with('success', 'Data mustahik berhasil diupdate');
    }

    public function mustahikDelete($id)
    {
        Mustahik::findOrFail($id)->delete();

        return redirect()->route('zakat.mustahik.index')
            ->with('success', 'Data mustahik berhasil dihapus');
    }

    public function distribusi()
    {
        $data = DistribusiZakat::with('mustahik')->orderBy('tanggal', 'desc')->get();
        return view('admin.zakat.distribusi_index', compact('data'));
    }

    public function distribusiCreate()
    {
        $mustahikList = Mustahik::orderBy('nama', 'asc')->get();
        return view('admin.zakat.distribusi_create', compact('mustahikList'));
    }

    public function distribusiStore(Request $request)
    {
        $validated = $request->validate([
            'tanggal' => 'required|date',
            'mustahik_id' => 'required|exists:mustahik,id',
            'jenis_zakat' => 'required|string|max:255',
            'bentuk_zakat' => 'required|in:Uang,Barang',
            'jumlah_zakat' => 'nullable|numeric|min:0',
            'satuan' => 'nullable|string|max:50',
            'nominal' => 'nullable|numeric|min:0',
            'keterangan' => 'nullable|string',
        ]);

        $this->validateDistribusiBusinessRules($request);
        $validated = $this->prepareDistribusiPayload($validated);

        DistribusiZakat::create($validated);

        return redirect()->route('zakat.distribusi.index')
            ->with('success', 'Distribusi zakat berhasil ditambahkan');
    }

    public function distribusiEdit($id)
    {
        $distribusi = DistribusiZakat::findOrFail($id);
        $mustahikList = Mustahik::orderBy('nama', 'asc')->get();
        return view('admin.zakat.distribusi_edit', compact('distribusi', 'mustahikList'));
    }

    public function distribusiUpdate(Request $request, $id)
    {
        $validated = $request->validate([
            'tanggal' => 'required|date',
            'mustahik_id' => 'required|exists:mustahik,id',
            'jenis_zakat' => 'required|string|max:255',
            'bentuk_zakat' => 'required|in:Uang,Barang',
            'jumlah_zakat' => 'nullable|numeric|min:0',
            'satuan' => 'nullable|string|max:50',
            'nominal' => 'nullable|numeric|min:0',
            'keterangan' => 'nullable|string',
        ]);

        $this->validateDistribusiBusinessRules($request);
        $validated = $this->prepareDistribusiPayload($validated);

        DistribusiZakat::findOrFail($id)->update($validated);

        return redirect()->route('zakat.distribusi.index')
            ->with('success', 'Distribusi zakat berhasil diupdate');
    }

    public function distribusiDelete($id)
    {
        DistribusiZakat::findOrFail($id)->delete();

        return redirect()->route('zakat.distribusi.index')
            ->with('success', 'Distribusi zakat berhasil dihapus');
    }

    private function preparePenerimaanPayload(array $validated): array
    {
        $validated['nominal'] = $this->normalizeNumber($validated['nominal'] ?? null);
        $validated['nominal_pembagian'] = $this->normalizeNumber($validated['nominal_pembagian'] ?? null);
        $validated['jumlah_zakat'] = $this->normalizeNumber($validated['jumlah_zakat'] ?? null);
        $validated['standar_per_jiwa'] = $this->normalizeNumber($validated['standar_per_jiwa'] ?? null);
        $validated['jumlah_tanggungan'] = $validated['jumlah_tanggungan'] ?? null;

        if ($validated['bentuk_zakat'] === self::BENTUK_UANG) {
            $validated['jumlah_zakat'] = $validated['nominal'] ?? $validated['jumlah_zakat'];
            $validated['nominal'] = $validated['jumlah_zakat'];
            $validated['satuan'] = null;
            $validated['standar_per_jiwa'] = null;

            if ($this->isZakatFitrah($validated['jenis_zakat'])) {
                $jumlahTanggungan = (int) ($validated['jumlah_tanggungan'] ?? 0);
                $nominalPembagian = $validated['nominal_pembagian']
                    ?: ($jumlahTanggungan > 0 ? (float) $validated['nominal'] / $jumlahTanggungan : null);

                $validated['nominal_pembagian'] = $nominalPembagian;

                if ($nominalPembagian !== null && $jumlahTanggungan > 0) {
                    $validated['nominal'] = (float) $nominalPembagian * $jumlahTanggungan;
                    $validated['jumlah_zakat'] = $validated['nominal'];
                }
            } else {
                $validated['jumlah_tanggungan'] = null;
                $validated['nominal_pembagian'] = null;
            }

            return $validated;
        }

        $validated['metode_pembayaran'] = null;
        $validated['nominal_pembagian'] = null;

        if ($this->isZakatFitrah($validated['jenis_zakat'])) {
            $validated['standar_per_jiwa'] = $validated['standar_per_jiwa'] ?: self::STANDAR_FITRAH_DEFAULT;
            $validated['jumlah_zakat'] = (float) ($validated['jumlah_tanggungan'] ?? 0) * (float) $validated['standar_per_jiwa'];
            $validated['satuan'] = $validated['satuan'] ?: 'kg';
        } else {
            $validated['standar_per_jiwa'] = null;
        }

        if (empty($validated['satuan'])) {
            $validated['satuan'] = 'kg';
        }

        return $validated;
    }

    private function prepareDistribusiPayload(array $validated): array
    {
        $validated['nominal'] = $this->normalizeNumber($validated['nominal'] ?? null);
        $validated['jumlah_zakat'] = $this->normalizeNumber($validated['jumlah_zakat'] ?? null);

        if ($validated['bentuk_zakat'] === self::BENTUK_UANG) {
            $validated['jumlah_zakat'] = $validated['nominal'] ?? $validated['jumlah_zakat'];
            $validated['nominal'] = $validated['jumlah_zakat'];
            $validated['satuan'] = null;
            return $validated;
        }

        if (empty($validated['satuan'])) {
            $validated['satuan'] = 'kg';
        }

        return $validated;
    }

    private function normalizeNumber($value): ?float
    {
        if ($value === null || $value === '') {
            return null;
        }

        if (is_string($value)) {

            $value = str_replace(',', '.', $value);
        }

        return (float) $value;
    }

    private function isZakatFitrah(string $jenisZakat): bool
    {
        return str_contains(strtolower($jenisZakat), 'fitrah');
    }

    private function validatePenerimaanBusinessRules(Request $request): void
    {
        if ($request->bentuk_zakat === self::BENTUK_UANG) {
            $rules = [
                'nominal' => 'required|numeric|min:0',
                'metode_pembayaran' => 'required|string|max:255',
            ];

            if ($this->isZakatFitrah((string) $request->jenis_zakat)) {
                $rules['jumlah_tanggungan'] = 'required|integer|min:1';
                $rules['nominal_pembagian'] = 'required|numeric|min:1';
            }

            $request->validate([
                ...$rules,
            ]);
            return;
        }

        if ($this->isZakatFitrah((string) $request->jenis_zakat)) {
            $request->validate([
                'jumlah_tanggungan' => 'required|integer|min:1',
                'standar_per_jiwa' => 'required|numeric|min:0.01',
            ]);
            return;
        }

        $request->validate([
            'jumlah_zakat' => 'required|numeric|min:0.01',
            'satuan' => 'required|string|max:50',
        ]);
    }

    private function validateDistribusiBusinessRules(Request $request): void
    {
        if ($request->bentuk_zakat === self::BENTUK_UANG) {
            $request->validate([
                'nominal' => 'required|numeric|min:0',
            ]);
            return;
        }

        $request->validate([
            'jumlah_zakat' => 'required|numeric|min:0.01',
            'satuan' => 'required|string|max:50',
        ]);
    }
}
