<?php

namespace App\Http\Controllers;

use App\Exports\LppbjExport;
use Maatwebsite\Excel\Facades\Excel;

use App\Models\Lppbj;
use Illuminate\Http\Request;

class LppbjController extends Controller
{
    public function __construct()
    {
        // 1. Asesor DILARANG masuk halaman Create, Store, Edit, Update, Destroy
        $this->middleware(function ($request, $next) {
            if (auth()->user()->role == 'asesor') {
                abort(403, 'AKSES DITOLAK: Asesor hanya boleh melihat data.');
            }
            return $next($request);
        })->only(['create', 'store', 'edit', 'update', 'destroy']);

        // 2. Sekretariat DILARANG menghapus data (Destroy)
        $this->middleware(function ($request, $next) {
            if (auth()->user()->role == 'sekretariat') {
                abort(403, 'AKSES DITOLAK: Sekretariat tidak memiliki hak hapus.');
            }
            return $next($request);
        })->only(['destroy']);
    }
    // MENAMPILKAN DATA & SEARCH
    public function index(Request $request)
    {
        $query = Lppbj::query();

        // 1. Logika Search
        if ($request->has('search')) {
            $query->where('nama_lppbj', 'LIKE', '%' . $request->search . '%');
        }

        // 2. Logika Pagination Dinamis
        // Ambil nilai 'per_page' dari request, kalau tidak ada default ke 15
        $perPage = $request->input('per_page', 15);
        
        // Gunakan withQueryString() agar saat ganti halaman, parameter search tidak hilang
        $data = $query->latest()->paginate($perPage)->withQueryString();

        return view('lppbj.index', compact('data'));
    }

    // FORM TAMBAH DATA
    public function create()
    {
        return view('lppbj.create');
    }

    // SIMPAN DATA BARU
    public function store(Request $request)
    {
        $request->validate([
            'nama_lppbj' => 'required',
            'kriteria' => 'required',
            'kategori' => 'required',
            'tanggal_mulai' => 'required|date',
            'masa_berlaku' => 'required|date|after:tanggal_mulai',
        ]);

        Lppbj::create($request->all());

        return redirect()->route('lppbj.index')->with('success', 'Data Berhasil Disimpan');
    }

    // FORM EDIT DATA
    public function edit(Lppbj $lppbj)
    {
        return view('lppbj.edit', compact('lppbj'));
    }

    // UPDATE DATA
    public function update(Request $request, Lppbj $lppbj)
    {
        $request->validate([
            'nama_lppbj' => 'required',
            'kriteria' => 'required',
            'kategori' => 'required',
            'tanggal_mulai' => 'required|date',
            'masa_berlaku' => 'required|date|after:tanggal_mulai',
        ]);

        $lppbj->update($request->all());

        return redirect()->route('lppbj.index')->with('success', 'Data Berhasil Diupdate');
    }

    // HAPUS DATA
    public function destroy(Lppbj $lppbj)
    {
        $lppbj->delete();
        return redirect()->route('lppbj.index')->with('success', 'Data Berhasil Dihapus');
    }
    
    public function export()
    {
        // Download file dengan nama 'data_lppbj.xlsx'
        return Excel::download(new LppbjExport, 'data_lppbj.xlsx');
    }
    
}