@extends('layouts.admin')

@section('title', 'Kelola cupang')

@section('content')
<main class="admin">
  <div class="head">
    <div><h1>Kelola cupang</h1><p>Atur stok, harga, warna, dan foto produk.</p></div>
    <a class="btn lime" href="{{ route('admin.cupang.create') }}">+ Tambah cupang</a>
  </div>

  <div class="stats">
    <div><b>{{ $ringkas['produk'] }}</b><span>Produk</span></div>
    <div><b>{{ $ringkas['stok'] }}</b><span>Total stok</span></div>
    <div><b>{{ $ringkas['habis'] }}</b><span>Stok habis</span></div>
  </div>

  <form class="tools" method="GET" action="{{ route('admin.cupang.index') }}">
    <input name="q" value="{{ $q }}" placeholder="Cari nama atau kode cupang…" aria-label="Cari cupang">
    <button class="lime">Cari</button>
  </form>

  <div class="tblwrap">
    <table class="tbl">
      <thead>
        <tr><th>Foto</th><th>Kode</th><th>Nama</th><th>Jenis</th><th>Warna</th><th class="num">Harga</th><th class="num">Stok</th><th></th></tr>
      </thead>
      <tbody>
        @forelse ($cupangs as $c)
          <tr>
            <td class="thumb">
              @if ($c->gambar)
                <img src="{{ asset('uploads/cupang/'.$c->gambar) }}" alt="{{ $c->nama }}" loading="lazy">
              @else
                @include('cupang._ikan', ['warna' => $c->warna, 'id' => $c->id])
              @endif
            </td>
            <td>{{ $c->kode }}</td>
            <td>{{ $c->nama }}</td>
            <td>{{ $c->jenis }}</td>
            <td>{{ $c->warna }}</td>
            <td class="num">Rp {{ number_format($c->harga, 0, ',', '.') }}</td>
            <td class="num">@if ($c->stok > 0){{ $c->stok }}@else<span class="out">Habis</span>@endif</td>
            <td class="aksi">
              <a class="btn" href="{{ route('admin.cupang.edit', $c) }}">Edit</a>
              <form method="POST" action="{{ route('admin.cupang.destroy', $c) }}" onsubmit="return confirm('Hapus cupang ini?')">
                @csrf
                @method('DELETE')
                <button>Hapus</button>
              </form>
            </td>
          </tr>
        @empty
          <tr><td colspan="8" class="empty">Belum ada cupang yang cocok.</td></tr>
        @endforelse
      </tbody>
    </table>
  </div>
</main>
@endsection
