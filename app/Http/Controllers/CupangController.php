<?php

namespace App\Http\Controllers;

use App\Models\Cupang;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

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

    public function create()
    {
        return view('cupang.create', [
            'cupang' => new Cupang(['jenis' => Cupang::JENIS[0], 'warna' => 'Biru', 'harga' => 0, 'stok' => 0]),
        ]);
    }

    public function store(Request $request)
    {
        Cupang::create($this->validated($request));

        return $this->kembali('Cupang ditambahkan.');
    }

    public function edit(Cupang $cupang)
    {
        return view('cupang.edit', compact('cupang'));
    }

    public function update(Request $request, Cupang $cupang)
    {
        $cupang->update($this->validated($request, $cupang));

        return $this->kembali('Perubahan disimpan.');
    }

    public function destroy(Cupang $cupang)
    {
        $cupang->delete();

        return $this->kembali('Cupang dihapus.');
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

    private function validated(Request $request, ?Cupang $cupang = null): array
    {
        return $request->validate([
            'kode'  => ['required', 'max:20', Rule::unique('cupangs', 'kode')->ignore($cupang?->id)],
            'nama'  => ['required', 'max:100'],
            'jenis' => ['required', Rule::in(Cupang::JENIS)],
            'warna' => ['required', Rule::in(array_keys(Cupang::WARNA))],
            'harga' => ['required', 'integer', 'min:0'],
            'stok'  => ['required', 'integer', 'min:0'],
        ], [
            'kode.required'  => 'Isi kode cupang.',
            'kode.unique'    => 'Kode ini sudah dipakai cupang lain.',
            'nama.required'  => 'Isi nama cupang.',
            'harga.required' => 'Isi harga.',
            'stok.required'  => 'Isi stok.',
        ]);
    }

    private function kembali(string $pesan)
    {
        return redirect(route('cupang.index').'#produk')->with('status', $pesan);
    }
}
