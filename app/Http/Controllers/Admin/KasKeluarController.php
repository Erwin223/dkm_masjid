<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreKasKeluarRequest;
use App\Http\Requests\UpdateKasKeluarRequest;
use App\Models\Admin;
use App\Models\KasKeluar;
use App\Services\CashBalanceService;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class KasKeluarController extends Controller
{
    public function index()
    {
        $this->authorize('viewAny', KasKeluar::class);

        $data            = KasKeluar::with('approver')
            ->orderByRaw("CASE status WHEN 'pending' THEN 0 WHEN 'rejected' THEN 1 ELSE 2 END")
            ->orderBy('tanggal', 'desc')
            ->get();
        $totalKeluar     = KasKeluar::approved()->sum('nominal');
        $pendingKeluar   = KasKeluar::pending()->sum('nominal');
        $keluarBulanIni  = KasKeluar::approved()->whereMonth('tanggal', Carbon::now()->month)
                               ->whereYear('tanggal', Carbon::now()->year)
                               ->sum('nominal');
        $jmlBulanIni     = KasKeluar::approved()->whereMonth('tanggal', Carbon::now()->month)
                               ->whereYear('tanggal', Carbon::now()->year)
                               ->count();

        return view('admin.kas_keluar.index', compact(
            'data', 'totalKeluar', 'pendingKeluar', 'keluarBulanIni', 'jmlBulanIni'
        ));
    }

    public function create()
    {
        $this->authorize('create', KasKeluar::class);

        return view('admin.kas_keluar.create');
    }

    public function store(StoreKasKeluarRequest $request): RedirectResponse
    {
        KasKeluar::create($request->validated());

        return redirect()->route('kas.keluar.index')
            ->with('success', 'Kas keluar berhasil ditambahkan dengan status pending.');
    }

    public function edit($id)
    {
        $data = KasKeluar::findOrFail($id);
        $this->authorize('update', $data);

        return view('admin.kas_keluar.edit', compact('data'));
    }

    public function update(UpdateKasKeluarRequest $request, $id): RedirectResponse
    {
        $kasKeluar = KasKeluar::findOrFail($id);
        $this->authorize('update', $kasKeluar);
        $kasKeluar->update($request->validated());

        return redirect()->route('kas.keluar.index')
            ->with('success', 'Data kas keluar berhasil diupdate');
    }

    public function destroy($id): RedirectResponse
    {
        $kasKeluar = KasKeluar::findOrFail($id);
        $this->authorize('delete', $kasKeluar);

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

    public function approve(Request $request, int $id, CashBalanceService $cashBalanceService): RedirectResponse
    {
        $kasKeluar = KasKeluar::findOrFail($id);
        $this->authorize('approve', $kasKeluar);

        /** @var Admin $user */
        $user = $request->user();
        $kasKeluar->approve($user, $cashBalanceService);

        return redirect()->route('kas.keluar.index')
            ->with('success', 'Kas keluar berhasil di-approve dan saldo utama kini terpotong.');
    }

    public function reject(Request $request, int $id): RedirectResponse
    {
        $kasKeluar = KasKeluar::findOrFail($id);
        $this->authorize('reject', $kasKeluar);

        $validated = $request->validate([
            'rejection_reason' => 'required|string|max:2000',
        ], [
            'rejection_reason.required' => 'Alasan penolakan wajib diisi.',
        ]);

        /** @var Admin $user */
        $user = $request->user();
        $kasKeluar->reject($user, $validated['rejection_reason']);

        return redirect()->route('kas.keluar.index')
            ->with('success', 'Kas keluar berhasil ditolak.');
    }
}
