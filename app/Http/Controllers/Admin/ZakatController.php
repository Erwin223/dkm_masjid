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
            'jumlah_zakat' => 'required|numeric|min:0',
            'jumlah_tanggungan' => 'nullable|integer|min:0',
            'metode_pembayaran' => 'required|string|max:255',
            'keterangan' => 'nullable|string',
        ]);

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
            'jumlah_zakat' => 'required|numeric|min:0',
            'jumlah_tanggungan' => 'nullable|integer|min:0',
            'metode_pembayaran' => 'required|string|max:255',
            'keterangan' => 'nullable|string',
        ]);

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
            'jumlah_zakat' => 'required|numeric|min:0',
            'keterangan' => 'nullable|string',
        ]);

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
            'jumlah_zakat' => 'required|numeric|min:0',
            'keterangan' => 'nullable|string',
        ]);

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
}
