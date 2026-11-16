@extends('layouts.app')

@section('title', 'Toko Cupang')

@section('content')
<header class="hero">
  <div class="photo" role="img" aria-label="Dua ikan cupang halfmoon, merah dan kuning"></div>
  <nav class="nav" aria-label="Menu utama">
    <span class="logo">Toko Cupang</span>
    <a href="#produk">Produk</a><a href="#kontak">Tentang</a><a href="#kontak">Kontak</a>
    <a class="cart" href="#produk" aria-label="Keranjang: {{ $jumlahKeranjang }} item"><svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor"><path d="M5 8h14l1 13H4zM8 8a4 4 0 018 0" stroke="currentColor" stroke-width="2" fill-opacity=".9"/></svg><b>{{ $jumlahKeranjang }}</b></a>
  </nav>
  <div class="copy">
    <span class="eyebrow">Spesialis cupang hias</span>
    <h1>Cupang cantik pilihan peternak</h1>
    <p class="lead">Toko Cupang menyediakan plakat, halfmoon, crowntail, dan giant yang sehat, aktif, dan siap kirim ke seluruh Indonesia.</p>
    <div class="cta"><a class="btn" href="#kontak">Hubungi kami →</a><a class="btn lime" href="#produk">Belanja sekarang →</a></div>
  </div>
</header>

<section id="produk">
  <div class="head">
    <div><h2>Cupang pilihan</h2><p>Kelola stok, harga, dan warna langsung dari sini.</p></div>
    <a class="btn lime" href="{{ route('cupang.create') }}">+ Tambah cupang</a>
  </div>

  <form class="tools" method="GET" action="{{ route('cupang.index') }}#produk">
    @if ($jenis) <input type="hidden" name="jenis" value="{{ $jenis }}"> @endif
    <input name="q" value="{{ $q }}" placeholder="Cari nama atau kode cupang…" aria-label="Cari cupang">
    <button class="lime">Cari</button>
  </form>

  <div class="chips">
    <a class="chip" href="{{ route('cupang.index', ['q' => $q ?: null]) }}#produk" @if (! $jenis) aria-current="true" @endif>Semua</a>
    @foreach (\App\Models\Cupang::JENIS as $j)
      <a class="chip" href="{{ route('cupang.index', ['jenis' => $j, 'q' => $q ?: null]) }}#produk" @if ($jenis === $j) aria-current="true" @endif>{{ $j }}</a>
    @endforeach
  </div>

  <div class="grid">
    @forelse ($cupangs as $c)
      <article class="item">
        <div class="pic">
          <span class="badge {{ $c->stok > 0 ? '' : 'out' }}">{{ $c->stok > 0 ? 'Stok '.$c->stok : 'Habis' }}</span>
          @include('cupang._ikan', ['warna' => $c->warna, 'id' => $c->id])
        </div>
        <div class="info">
          <h3>{{ $c->nama }}</h3>
          <span class="sub">{{ $c->kode }} · {{ $c->jenis }} · {{ $c->warna }}</span>
          <span class="price">Rp {{ number_format($c->harga, 0, ',', '.') }}</span>
          <div class="act">
            <form class="buy" method="POST" action="{{ route('cupang.beli', $c) }}">
              @csrf
              <button class="lime" @disabled($c->stok < 1)>Beli</button>
            </form>
            <a class="btn" href="{{ route('cupang.edit', $c) }}">Edit</a>
            <form method="POST" action="{{ route('cupang.destroy', $c) }}" onsubmit="return confirm('Hapus cupang ini?')">
              @csrf
              @method('DELETE')
              <button>Hapus</button>
            </form>
          </div>
        </div>
      </article>
    @empty
      <p class="empty">Belum ada cupang yang cocok. Tambahkan cupang baru untuk mulai.</p>
    @endforelse
  </div>
</section>
@endsection
