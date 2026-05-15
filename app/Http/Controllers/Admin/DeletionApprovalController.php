<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\DeletionRequest;

use App\Notifications\DeletionProcessed;

class DeletionApprovalController extends Controller
{
    public function index()
    {
        $requests = DeletionRequest::with(['model', 'user'])
            ->where('status', 'pending')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('admin.deletion_approvals.index', compact('requests'));
    }

    public function approve($id)
    {
        $request = DeletionRequest::findOrFail($id);

        if ($request->status !== 'pending') {
            return redirect()->back()->with('error', 'Status permintaan sudah tidak valid.');
        }

        if ($request->model) {
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
