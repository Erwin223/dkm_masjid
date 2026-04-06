<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
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

    public function store(Request $request)
    {
        $request->merge([
            'jumlah' => $this->normalizeNumber($request->jumlah),
        ]);

        $request->validate([
            'tanggal'    => 'required|date',
            'sumber'     => 'required',
            'jumlah'     => 'required|numeric',
            'keterangan' => 'nullable',
        ]);

        KasMasuk::create([
            'tanggal'    => $request->tanggal,
            'sumber'     => $request->sumber,
            'jumlah'     => $request->jumlah,
            'keterangan' => $request->keterangan,
        ]);

        return redirect()->route('kas.masuk.index')
            ->with('success', 'Data kas masuk berhasil ditambahkan');
    }

    public function edit($id)
    {
        $data = KasMasuk::findOrFail($id);
        return view('admin.kas_masuk.edit', compact('data'));
    }

    public function update(Request $request, $id)
    {
        $request->merge([
            'jumlah' => $this->normalizeNumber($request->jumlah),
        ]);

        $request->validate([
            'tanggal'    => 'required|date',
            'sumber'     => 'required',
            'jumlah'     => 'required|numeric',
            'keterangan' => 'nullable',
        ]);

        KasMasuk::findOrFail($id)->update([
            'tanggal'    => $request->tanggal,
            'sumber'     => $request->sumber,
            'jumlah'     => $request->jumlah,
            'keterangan' => $request->keterangan,
        ]);

        return redirect()->route('kas.masuk.index')
            ->with('success', 'Data kas masuk berhasil diperbarui');
    }

    public function delete($id)
    {
        KasMasuk::findOrFail($id)->delete();
        return redirect()->route('kas.masuk.index')
            ->with('success', 'Data kas masuk berhasil dihapus');
    }

    private function normalizeNumber($value): float|int
    {
        if ($value === null || $value === '') {
            return 0;
        }

        if (is_numeric($value)) {
            return $value + 0;
        }

        $value = preg_replace('/[^0-9,.-]/', '', (string) $value) ?? '';
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

            if (count($parts) > 2 || (isset($parts[1]) && strlen($parts[1]) === 3)) {
                $value = str_replace('.', '', $value);
            }
        }

        return is_numeric($value) ? $value + 0 : 0;
    }
}
