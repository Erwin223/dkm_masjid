<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\KasMasuk;

class DashboardController extends Controller
{
    public function index()
    {
        // mengambil 5 data kas masuk terbaru
        $kasMasuk = KasMasuk::latest()->limit(5)->get();

        // menghitung total kas masuk
        $totalKasMasuk = KasMasuk::sum('jumlah');

        return view('admin.dashboard', compact(
            'kasMasuk',
            'totalKasMasuk'
        ));
    }
}
