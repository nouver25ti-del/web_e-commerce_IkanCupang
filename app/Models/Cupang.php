<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cupang extends Model
{
    public const JENIS = ['Plakat', 'Halfmoon', 'Crowntail', 'Giant', 'Double Tail'];

    /** Warna => [warna terang, warna gelap] untuk ilustrasi ikan */
    public const WARNA = [
        'Biru'   => ['#4fd0ff', '#3a4cff'],
        'Merah'  => ['#ff8a7a', '#c4163f'],
        'Kuning' => ['#ffe27a', '#ff9f1c'],
        'Hitam'  => ['#8a96b8', '#1d2742'],
        'Putih'  => ['#ffffff', '#a9c8e6'],
        'Ungu'   => ['#c79cff', '#5a2fd1'],
    ];

    protected $table = 'cupangs';

    protected $fillable = ['kode', 'nama', 'jenis', 'warna', 'harga', 'stok', 'gambar'];
}
