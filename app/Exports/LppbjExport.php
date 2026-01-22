<?php

namespace App\Exports;

use App\Models\Lppbj;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Carbon\Carbon;

class LppbjExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize, WithStyles
{
    /**
    * Ambil data dari database
    */
    public function collection()
    {
        return Lppbj::all();
    }

    /**
    * Header (Judul Kolom) di Excel
    */
    public function headings(): array
    {
        return [
            'No',
            'Nama LPPBJ',
            'Kriteria',
            'Kategori',
            'Tanggal Mulai',
            'Tanggal Berakhir',
            'Status Akreditasi',
        ];
    }

    /**
    * Isi Data per Baris
    */
    public function map($lppbj): array
    {
        return [
            $lppbj->id,
            $lppbj->nama_lppbj,
            $lppbj->kriteria,
            $lppbj->kategori,
            Carbon::parse($lppbj->tanggal_mulai)->format('d-m-Y'),
            Carbon::parse($lppbj->masa_berlaku)->format('d-m-Y'),
            $lppbj->status, // Mengambil logika status otomatis dari Model
        ];
    }

    /**
    * Styling (Biar Header Tebal/Bold)
    */
    public function styles(Worksheet $sheet)
    {
        return [
            1    => ['font' => ['bold' => true]],
        ];
    }
}