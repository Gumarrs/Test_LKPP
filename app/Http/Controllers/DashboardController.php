<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Lppbj;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        // 1. DATA CARD ATAS
        $total = Lppbj::count();
        $pemerintah = Lppbj::where('kriteria', 'Pemerintah')->count();
        $nonPemerintah = Lppbj::where('kriteria', 'Non-Pemerintah')->count();
        
        // Data Kategori A & B (UNTUK CHART AKREDITASI)
        $kategoriA = Lppbj::where('kategori', 'A')->count();
        $kategoriB = Lppbj::where('kategori', 'B')->count();
        
        // Expired Soon (< 3 Bulan)
        $threeMonthsLater = Carbon::now()->addMonths(3);
        $expiredSoon = Lppbj::whereBetween('masa_berlaku', [Carbon::now(), $threeMonthsLater])->count();

        // 2. DATA UNTUK CHART PENGAJUAN (Status Masa Berlaku)
        $now = Carbon::now();
        $sixMonthsLater = Carbon::now()->addMonths(6);

        $statTidakBerlaku = Lppbj::where('masa_berlaku', '<', $now)->count();
        $statKurang3Bulan = Lppbj::whereBetween('masa_berlaku', [$now, $threeMonthsLater])->count();
        $statKurang6Bulan = Lppbj::whereBetween('masa_berlaku', [$threeMonthsLater, $sixMonthsLater])->count();
        // Berlaku = Total - (Expired + <3 + <6)
        $statBerlaku = $total - ($statTidakBerlaku + $statKurang3Bulan + $statKurang6Bulan);
        if($statBerlaku < 0) $statBerlaku = 0; 

// 3. DATA TABEL
    $query = Lppbj::query();

    if ($request->has('search')) {
        $query->where('nama_lppbj', 'LIKE', '%' . $request->search . '%');
    }

    $perPage = $request->input('per_page', 15);
    $tableData = $query->latest()->paginate($perPage)->withQueryString();

    // --- LOGIKA AJAX BARU ---
    // Jika request datang dari Javascript (AJAX), kembalikan HTML tabel saja
    if ($request->ajax()) {
        $tab = $request->input('tab', 'akreditasi');
        
        if($tab == 'pengajuan') {
             return view('partials.table_pengajuan', compact('tableData'))->render();
        } else {
             return view('partials.table_akreditasi', compact('tableData'))->render();
        }
    }

    return view('dashboard', compact(
        'total', 'pemerintah', 'nonPemerintah', 'kategoriA', 'kategoriB', 'expiredSoon',
        'statTidakBerlaku', 'statKurang3Bulan', 'statKurang6Bulan', 'statBerlaku',
        'tableData', 'perPage'
    ));
    }
}