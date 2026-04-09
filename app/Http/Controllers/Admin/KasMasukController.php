<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreKasMasukRequest;
use App\Http\Requests\UpdateKasMasukRequest;
use App\Models\KasMasuk;
use Carbon\Carbon;

class KasMasukController extends Controller
{
    public function index()
    {
        $data          = KasMasuk::orderBy('tanggal', 'desc')->get();
        $totalMasuk    = KasMasuk::sum('jumlah');
        $masukBulanIni = KasMasuk::whereMonth('tanggal', Carbon::now()->month)
                            ->whereYear('tanggal', Carbon::now()->year)
                            ->sum('jumlah');
        $jmlBulanIni   = KasMasuk::whereMonth('tanggal', Carbon::now()->month)
                            ->whereYear('tanggal', Carbon::now()->year)
                            ->count();

        return view('admin.kas_masuk.index', compact(
            'data', 'totalMasuk', 'masukBulanIni', 'jmlBulanIni'
        ));
    }

    public function create()
    {
        return view('admin.kas_masuk.create');
    }

    public function store(StoreKasMasukRequest $request)
    {
        KasMasuk::create($request->validated());

        return redirect()->route('kas.masuk.index')
            ->with('success', 'Data kas masuk berhasil ditambahkan');
    }

    public function edit($id)
    {
        $data = KasMasuk::findOrFail($id);
        return view('admin.kas_masuk.edit', compact('data'));
    }

    public function update(UpdateKasMasukRequest $request, $id)
    {
        KasMasuk::findOrFail($id)->update($request->validated());

        return redirect()->route('kas.masuk.index')
            ->with('success', 'Data kas masuk berhasil diperbarui');
    }

    public function delete($id)
    {
        KasMasuk::findOrFail($id)->delete();
        return redirect()->route('kas.masuk.index')
            ->with('success', 'Data kas masuk berhasil dihapus');
    }
}
