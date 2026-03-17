<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\KasMasuk;
use App\Models\KasKeluar;

class DashboardController extends Controller
{
    public function index()
    {
        // kas masuk
        $kasMasuk = KasMasuk::latest()->limit(5)->get();
        $totalKasMasuk = KasMasuk::sum('jumlah');

        // kas keluar
        $kasKeluar = KasKeluar::latest()->limit(5)->get();
        $totalKasKeluar = KasKeluar::sum('nominal');

        return view('admin.dashboard', compact(
            'kasMasuk',
            'totalKasMasuk',
            'kasKeluar',
            'totalKasKeluar',
        ));
    }
}
