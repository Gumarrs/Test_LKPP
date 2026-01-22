<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon; // Library pengolah tanggal

class Lppbj extends Model
{
    use HasFactory;

    // Izinkan semua kolom diisi
    protected $guarded = [];

    // Beritahu Laravel kalau kolom ini adalah Tanggal
    protected $dates = ['tanggal_mulai', 'masa_berlaku'];

    // --- LOGIKA STATUS OTOMATIS ---
    // Atribut ini tidak ada di database, tapi dihitung saat dipanggil
    public function getStatusAttribute()
    {
        $now = Carbon::now();
        $expired = Carbon::parse($this->masa_berlaku);

        // Jika tanggal masa berlaku sudah lewat hari ini
        if ($expired->lessThan($now)) {
            return 'Tidak Berlaku';
        }

        // Hitung selisih bulan
        $selisihBulan = $now->diffInMonths($expired);

        if ($selisihBulan < 3) {
            return '< 3 Bulan';
        } elseif ($selisihBulan < 6) {
            return '< 6 Bulan';
        } else {
            return 'Berlaku';
        }
    }
}