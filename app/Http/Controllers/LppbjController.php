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


    }
    // MENAMPILKAN DATA & SEARCH
    public function index(Request $request)
        {
            // 1. Mulai Query
            $query = Lppbj::query();

            // 2. Logic SEARCH (Pencarian)
            if ($request->filled('search')) {
                $query->where('nama_lppbj', 'LIKE', '%' . $request->search . '%');
            }

            // 3. Logic FILTER KATEGORI
            // Menggunakan 'filled' agar tidak error jika value kosong
            if ($request->filled('filter_kategori')) {
                // Pastikan kolom di database bernama 'kriteria'
                $query->where('kriteria', $request->filter_kategori);
            }

          

            // 5. Logic SORTING (Urutan)
            if ($request->filled('sort')) {
                switch ($request->sort) {
                    case 'name_asc':
                        $query->orderBy('nama_lppbj', 'asc');
                        break;
                    case 'name_desc':
                        $query->orderBy('nama_lppbj', 'desc');
                        break;
                    case 'oldest':
                        $query->orderBy('created_at', 'asc');
                        break;
                    case 'newest':
                    default:
                        $query->orderBy('created_at', 'desc');
                        break;
                }
            } else {
                // Default: Data terbaru paling atas
                $query->orderBy('created_at', 'desc');
            }

            // 6. Pagination (Menjaga agar filter tidak hilang saat pindah halaman)
            $perPage = $request->input('per_page', 15);
            $data = $query->paginate($perPage)->withQueryString(); 

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