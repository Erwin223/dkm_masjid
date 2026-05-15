<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreKasKeluarRequest;
use App\Http\Requests\UpdateKasKeluarRequest;
use App\Models\KasKeluar;
use Carbon\Carbon;

class KasKeluarController extends Controller
{
    public function index()
    {
        $data            = KasKeluar::orderBy('tanggal', 'desc')->get();
        $totalKeluar     = KasKeluar::sum('nominal');
        $keluarBulanIni  = KasKeluar::whereMonth('tanggal', Carbon::now()->month)
                               ->whereYear('tanggal', Carbon::now()->year)
                               ->sum('nominal');
        $jmlBulanIni     = KasKeluar::whereMonth('tanggal', Carbon::now()->month)
                               ->whereYear('tanggal', Carbon::now()->year)
                               ->count();

        return view('admin.kas_keluar.index', compact(
            'data', 'totalKeluar', 'keluarBulanIni', 'jmlBulanIni'
        ));
    }

    public function create()
    {
        return view('admin.kas_keluar.create');
    }

    public function store(StoreKasKeluarRequest $request)
    {
        KasKeluar::create($request->validated());

        return redirect()->route('kas.keluar.index')
            ->with('success', 'Kas keluar berhasil ditambahkan');
    }

    public function edit($id)
    {
        $data = KasKeluar::findOrFail($id);
        return view('admin.kas_keluar.edit', compact('data'));
    }

    public function update(UpdateKasKeluarRequest $request, $id)
    {
        KasKeluar::findOrFail($id)->update($request->validated());

        return redirect()->route('kas.keluar.index')
            ->with('success', 'Data kas keluar berhasil diupdate');
    }

    public function destroy($id)
    {
        $kasKeluar = KasKeluar::findOrFail($id);

        if (!$kasKeluar->deletionRequest) {
            \App\Models\DeletionRequest::create([
                'model_type' => get_class($kasKeluar),
                'model_id' => $kasKeluar->id,
                'user_id' => auth()->id(),
                'status' => 'pending',
            ]);

            $ketuas = \App\Models\Admin::where('role', 'ketua')->get();
            $adminName = auth()->user()->name ?? 'Admin';
            foreach ($ketuas as $ketua) {
                $ketua->notify(new \App\Notifications\DeletionRequested($adminName, 'Kas Keluar'));
            }
        }

        return redirect()->route('kas.keluar.index')
            ->with('success', 'Permintaan penghapusan telah dikirim. Menunggu persetujuan ketua.');
    }
}

