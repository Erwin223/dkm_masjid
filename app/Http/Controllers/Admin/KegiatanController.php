<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreJadwalKegiatanRequest;
use App\Http\Requests\UpdateJadwalKegiatanRequest;
use App\Models\Admin;
use App\Models\JadwalKegiatan;
use App\Models\JadwalImam;
use App\Models\DataImam;
use App\Models\KasKeluar;
use App\Notifications\ApprovalRequested;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class KegiatanController extends Controller
{
    // ==================== JADWAL KEGIATAN ====================

    public function jadwal()
    {
        $this->authorize('viewAny', JadwalKegiatan::class);

        $kegiatan = JadwalKegiatan::with(['kasKeluar', 'approver'])
            ->orderByRaw("CASE status WHEN 'pending' THEN 0 WHEN 'rejected' THEN 1 ELSE 2 END")
            ->orderBy('tanggal', 'asc')
            ->paginate(10);

        return view('admin.kegiatan.jadwal_kegiatan', compact('kegiatan'));
    }

    public function jadwalCreate()
    {
        $this->authorize('create', JadwalKegiatan::class);

        $kasKeluar = KasKeluar::availableForActivity()->orderBy('tanggal', 'desc')->get();
        return view('admin.kegiatan.jadwal_kegiatan_create', compact('kasKeluar'));
    }

    public function jadwalStore(StoreJadwalKegiatanRequest $request): RedirectResponse
    {
        JadwalKegiatan::create($request->validated());

        $ketuas = Admin::where('role', 'ketua')->get();
        $adminName = auth()->user()->name ?? 'Admin';
        foreach ($ketuas as $ketua) {
            $ketua->notify(new ApprovalRequested($adminName, 'Jadwal Kegiatan'));
        }

        return redirect()->route('kegiatan.jadwal')
            ->with('success', 'Jadwal kegiatan berhasil ditambahkan dengan status pending.');
    }

    public function jadwalEdit($id)
    {
        $kegiatan  = JadwalKegiatan::findOrFail($id);
        $this->authorize('update', $kegiatan);

        $kasKeluar = KasKeluar::query()
            ->where(function ($query) use ($kegiatan) {
                $query->availableForActivity();

                if ($kegiatan->kas_keluar_id) {
                    $query->orWhere('id', $kegiatan->kas_keluar_id);
                }
            })
            ->orderBy('tanggal', 'desc')
            ->get();

        return view('admin.kegiatan.jadwal_kegiatan_edit', compact('kegiatan', 'kasKeluar'));
    }

    public function jadwalUpdate(UpdateJadwalKegiatanRequest $request, $id): RedirectResponse
    {
        $kegiatan = JadwalKegiatan::findOrFail($id);
        $this->authorize('update', $kegiatan);
        $kegiatan->update($request->validated());

        return redirect()->route('kegiatan.jadwal')
            ->with('success', 'Jadwal kegiatan berhasil diupdate');
    }

    public function jadwalDelete($id): RedirectResponse
    {
        $kegiatan = JadwalKegiatan::findOrFail($id);
        $this->authorize('delete', $kegiatan);

        if (!$kegiatan->deletionRequest) {
            \App\Models\DeletionRequest::create([
                'model_type' => get_class($kegiatan),
                'model_id' => $kegiatan->id,
                'user_id' => auth()->id(),
                'status' => 'pending',
            ]);

            $ketuas = \App\Models\Admin::where('role', 'ketua')->get();
            $adminName = auth()->user()->name ?? 'Admin';
            foreach ($ketuas as $ketua) {
                $ketua->notify(new \App\Notifications\DeletionRequested($adminName, 'Jadwal Kegiatan'));
            }
        }

        return redirect()->route('kegiatan.jadwal')
            ->with('success', 'Permintaan penghapusan telah dikirim. Menunggu persetujuan ketua.');
    }

    public function jadwalApprove(Request $request, int $id): RedirectResponse
    {
        $kegiatan = JadwalKegiatan::findOrFail($id);
        $this->authorize('approve', $kegiatan);

        /** @var Admin $user */
        $user = $request->user();
        $kegiatan->approve($user);

        return redirect()->route('kegiatan.jadwal')
            ->with('success', 'Kegiatan berhasil di-approve dan kini dapat tampil di website publik.');
    }

    public function jadwalReject(Request $request, int $id): RedirectResponse
    {
        $kegiatan = JadwalKegiatan::findOrFail($id);
        $this->authorize('reject', $kegiatan);

        $validated = $request->validate([
            'rejection_reason' => 'required|string|max:2000',
        ], [
            'rejection_reason.required' => 'Alasan penolakan wajib diisi.',
        ]);

        /** @var Admin $user */
        $user = $request->user();
        $kegiatan->reject($user, $validated['rejection_reason']);

        return redirect()->route('kegiatan.jadwal')
            ->with('success', 'Kegiatan berhasil ditolak.');
    }

    // ==================== DATA IMAM ====================

    public function imamData()
    {
        $imam = DataImam::orderBy('nama', 'asc')->paginate(10);
        return view('admin.kegiatan.data_imam_index', compact('imam'));
    }

    public function imamDataCreate()
    {
        return view('admin.kegiatan.data_imam_create');
    }

    public function imamDataStore(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'no_hp' => 'nullable|string|max:30',
            'alamat' => 'nullable|string|max:255',
            'status' => 'required|in:Tetap,Tamu',
            'keterangan' => 'nullable|string',
        ]);
        DataImam::create($validated);
        return redirect()->route('imam.data')->with('success', 'Data imam berhasil ditambahkan');
    }

    public function imamDataEdit($id)
    {
        $imam = DataImam::findOrFail($id);
        return view('admin.kegiatan.data_imam_edit', compact('imam'));
    }

    public function imamDataUpdate(Request $request, $id)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'no_hp' => 'nullable|string|max:30',
            'alamat' => 'nullable|string|max:255',
            'status' => 'required|in:Tetap,Tamu',
            'keterangan' => 'nullable|string',
        ]);
        DataImam::findOrFail($id)->update($validated);
        return redirect()->route('imam.data')->with('success', 'Data imam berhasil diupdate');
    }

    public function imamDataDelete($id)
    {
        DataImam::findOrFail($id)->delete();
        return redirect()->route('imam.data')->with('success', 'Data imam berhasil dihapus');
    }

    // ==================== JADWAL IMAM ====================

    public function imam()
    {
        $imam     = JadwalImam::with('imam')->orderBy('tanggal', 'asc')->paginate(10);
        $dataImam = DataImam::orderBy('nama', 'asc')->get();
        return view('admin.kegiatan.jadwal_imam', compact('imam', 'dataImam'));
    }

    public function imamCreate()
    {
        $dataImam = DataImam::orderBy('nama', 'asc')->get();
        return view('admin.kegiatan.jadwal_imam_create', compact('dataImam'));
    }

    public function imamStore(Request $request)
    {
        $validated = $request->validate([
            'imam_id'      => 'required|exists:data_imam,id',
            'tanggal'      => 'required|date',
            'hari'         => 'nullable',
            'waktu_sholat' => 'required',
            'keterangan'   => 'nullable',
        ]);
        JadwalImam::create($validated);
        return redirect()->route('kegiatan.imam')->with('success', 'Jadwal imam berhasil ditambahkan');
    }

    public function imamEdit($id)
    {
        $jadwal   = JadwalImam::findOrFail($id);
        $dataImam = DataImam::orderBy('nama', 'asc')->get();
        return view('admin.kegiatan.jadwal_imam_edit', compact('jadwal', 'dataImam'));
    }

    public function imamUpdate(Request $request, $id)
    {
        $validated = $request->validate([
            'imam_id'      => 'required|exists:data_imam,id',
            'tanggal'      => 'required|date',
            'hari'         => 'nullable',
            'waktu_sholat' => 'required',
            'keterangan'   => 'nullable',
        ]);
        JadwalImam::findOrFail($id)->update($validated);
        return redirect()->route('kegiatan.imam')->with('success', 'Jadwal imam berhasil diupdate');
    }

    public function imamDelete($id)
    {
        JadwalImam::findOrFail($id)->delete();
        return redirect()->route('kegiatan.imam')->with('success', 'Jadwal imam berhasil dihapus');
    }

    // ==================== JADWAL SHOLAT ====================

    public function sholat()
    {
        return view('admin.kegiatan.jadwal_sholat');
    }
}
