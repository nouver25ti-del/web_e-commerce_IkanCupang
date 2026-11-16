<?php

namespace Database\Seeders;

use App\Models\Cupang;
use Illuminate\Database\Seeder;

class CupangSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            ['CP-001', 'Plakat Blue Rim',       'Plakat',      'Biru',   35000, 12],
            ['CP-002', 'Halfmoon Red Dragon',   'Halfmoon',    'Merah',  75000, 6],
            ['CP-003', 'Crowntail Nemo',        'Crowntail',   'Kuning', 50000, 0],
            ['CP-004', 'Giant Violet',          'Giant',       'Ungu',   120000, 3],
            ['CP-005', 'Plakat Black Samurai',  'Plakat',      'Hitam',  45000, 8],
            ['CP-006', 'Double Tail Snow',      'Double Tail', 'Putih',  90000, 4],
        ];

        foreach ($data as [$kode, $nama, $jenis, $warna, $harga, $stok]) {
            Cupang::updateOrCreate(['kode' => $kode], compact('nama', 'jenis', 'warna', 'harga', 'stok'));
        }
    }
}
