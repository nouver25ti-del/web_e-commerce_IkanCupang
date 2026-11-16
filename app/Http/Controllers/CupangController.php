<?php

namespace App\Http\Controllers;

use App\Models\Cupang;
use Illuminate\Http\Request;

/**
 * Sisi PELANGGAN: melihat katalog dan menambah ke keranjang.
 * Pengelolaan produk (tambah/ubah/hapus) ada di Admin\CupangController.
 */
class CupangController extends Controller
{
    public function index(Request $request)
    {
        $q = trim((string) $request->query('q', ''));
        $jenis = $request->query('jenis');

        $cupangs = Cupang::query()
            ->when($q !== '', fn ($query) => $query->where(
                fn ($w) => $w->where('nama', 'like', "%{$q}%")->orWhere('kode', 'like', "%{$q}%")
            ))
            ->when(in_array($jenis, Cupang::JENIS, true), fn ($query) => $query->where('jenis', $jenis))
            ->orderBy('id')
            ->get();

        $jumlahKeranjang = array_sum(session('cart', []));

        return view('cupang.index', compact('cupangs', 'q', 'jenis', 'jumlahKeranjang'));
    }

    public function beli(Cupang $cupang)
    {
        $cart = session('cart', []);
        $jumlah = $cart[$cupang->id] ?? 0;

        if ($jumlah >= $cupang->stok) {
            return $this->kembali('Stok tidak cukup.');
        }

        $cart[$cupang->id] = $jumlah + 1;
        session(['cart' => $cart]);

        return $this->kembali('Ditambahkan ke keranjang.');
    }

    private function kembali(string $pesan)
    {
        return redirect(route('cupang.index').'#produk')->with('status', $pesan);
    }
}
