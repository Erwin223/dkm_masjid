<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DeletionRequest;
use App\Models\Arsip;
use App\Models\DistribusiZakat;
use App\Models\DonasiKeluar;
use App\Models\JadwalKegiatan;
use App\Models\KasKeluar;
use App\Notifications\DeletionProcessed;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PersetujuanKetuaController extends Controller
{
    public function index()
    {
        abort_unless(auth()->user()?->isKetua(), 403);

        $requests = DeletionRequest::with(['model', 'user'])
            ->where('status', 'pending')
            ->orderBy('created_at', 'desc')
            ->get();

        $pendingKasKeluar = KasKeluar::with('approver')
            ->pending()
            ->orderBy('tanggal', 'desc')
            ->get();

        $pendingKegiatan = JadwalKegiatan::with(['kasKeluar', 'approver'])
            ->pending()
            ->orderBy('tanggal', 'asc')
            ->get();

        $pendingDonasiKeluar = DonasiKeluar::with('approver')
            ->pending()
            ->orderBy('tanggal', 'desc')
            ->get();

        $pendingDistribusiZakat = DistribusiZakat::with(['mustahik', 'approver'])
            ->pending()
            ->orderBy('tanggal', 'desc')
            ->get();

        $pendingApprovalCount =
            $pendingKasKeluar->count() +
            $pendingKegiatan->count() +
            $pendingDonasiKeluar->count() +
            $pendingDistribusiZakat->count();
        $pendingDeletionCount = $requests->count();

        return view('admin.deletion_approvals.index', compact(
            'requests',
            'pendingKasKeluar',
            'pendingKegiatan',
            'pendingDonasiKeluar',
            'pendingDistribusiZakat',
            'pendingApprovalCount',
            'pendingDeletionCount'
        ));
    }

    public function approve($id)
    {
        abort_unless(auth()->user()?->isKetua(), 403);

        $request = DeletionRequest::findOrFail($id);

        if ($request->status !== 'pending') {
            return redirect()->back()->with('error', 'Status permintaan sudah tidak valid.');
        }

        if ($request->model) {
            if ($request->model instanceof Arsip && $request->model->file && Storage::disk('public')->exists($request->model->file)) {
                Storage::disk('public')->delete($request->model->file);
            }

            $request->model->delete();
        }

        $request->update(['status' => 'approved']);

        if ($request->user) {
            $moduleName = class_basename($request->model_type);
            $request->user->notify(new DeletionProcessed($moduleName, true));
        }

        return redirect()->back()
            ->with('success', 'Permintaan penghapusan disetujui dan data telah dihapus.');
    }

    public function reject($id)
    {
        abort_unless(auth()->user()?->isKetua(), 403);

        $request = DeletionRequest::findOrFail($id);

        if ($request->status !== 'pending') {
            return redirect()->back()->with('error', 'Status permintaan sudah tidak valid.');
        }

        $request->update(['status' => 'rejected']);

        if ($request->user) {
            $moduleName = class_basename($request->model_type);
            $request->user->notify(new DeletionProcessed($moduleName, false));
        }

        return redirect()->back()
            ->with('success', 'Permintaan penghapusan ditolak. Data tidak dihapus.');
    }
}
