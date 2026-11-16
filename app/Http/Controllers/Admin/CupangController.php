<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Cupang;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

/**
 * Sisi ADMIN: kelola data cupang. Hanya bisa diakses user ber-role "admin".
 */
class CupangController extends Controller
{
    public function index(Request $request)
    {
        $q = trim((string) $request->query('q', ''));

        $cupangs = Cupang::query()
            ->when($q !== '', fn ($query) => $query->where(
                fn ($w) => $w->where('nama', 'like', "%{$q}%")->orWhere('kode', 'like', "%{$q}%")
            ))
            ->orderBy('id')
            ->get();

        $ringkas = [
            'produk' => Cupang::count(),
            'stok'   => (int) Cupang::sum('stok'),
            'habis'  => Cupang::where('stok', 0)->count(),
        ];

        return view('admin.cupang.index', compact('cupangs', 'q', 'ringkas'));
    }

    public function create()
    {
        return view('admin.cupang.create', [
            'cupang' => new Cupang(['jenis' => Cupang::JENIS[0], 'warna' => 'Biru', 'harga' => 0, 'stok' => 0]),
        ]);
    }

    public function store(Request $request)
    {
        $data = $this->validated($request);
        $data['gambar'] = $this->simpanGambar($request);
        Cupang::create($data);

        return $this->kembali('Cupang ditambahkan.');
    }

    public function edit(Cupang $cupang)
    {
        return view('admin.cupang.edit', compact('cupang'));
    }

    public function update(Request $request, Cupang $cupang)
    {
        $data = $this->validated($request, $cupang);
        unset($data['gambar']);

        if ($request->hasFile('gambar')) {
            $this->hapusFile($cupang->gambar);
            $data['gambar'] = $this->simpanGambar($request);
        } elseif ($request->boolean('hapus_gambar')) {
            $this->hapusFile($cupang->gambar);
            $data['gambar'] = null;
        }

        $cupang->update($data);

        return $this->kembali('Perubahan disimpan.');
    }

    public function destroy(Cupang $cupang)
    {
        $this->hapusFile($cupang->gambar);
        $cupang->delete();

        return $this->kembali('Cupang dihapus.');
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
            'gambar' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ], [
            'gambar.image'    => 'File harus berupa gambar.',
            'gambar.mimes'    => 'Format gambar harus JPG, PNG, atau WebP.',
            'gambar.max'      => 'Ukuran gambar maksimal 2 MB.',
            'gambar.uploaded' => 'Gambar gagal diunggah. Ukuran maksimal 2 MB.',
            'kode.required'  => 'Isi kode cupang.',
            'kode.unique'    => 'Kode ini sudah dipakai cupang lain.',
            'nama.required'  => 'Isi nama cupang.',
            'harga.required' => 'Isi harga.',
            'stok.required'  => 'Isi stok.',
        ]);
    }

    private function simpanGambar(Request $request): ?string
    {
        if (! $request->hasFile('gambar')) {
            return null;
        }

        $file = $request->file('gambar');
        $nama = Str::random(20).'.'.$file->extension();
        $file->move(public_path('uploads/cupang'), $nama);

        return $nama;
    }

    private function hapusFile(?string $nama): void
    {
        if ($nama) {
            @unlink(public_path('uploads/cupang/'.basename($nama)));
        }
    }

    private function kembali(string $pesan)
    {
        return redirect()->route('admin.cupang.index')->with('status', $pesan);
    }
}
