@extends('layouts.app')

@section('title', 'Tambah cupang')

@section('content')
<main class="formpage">
  <a class="back" href="{{ route('cupang.index') }}#produk">← Kembali ke produk</a>
  <h1>Tambah cupang</h1>
  <form method="POST" action="{{ route('cupang.store') }}" enctype="multipart/form-data">
    @include('cupang._form')
    <div class="row">
      <a class="btn" href="{{ route('cupang.index') }}#produk">Batal</a>
      <button class="lime">Simpan</button>
    </div>
  </form>
</main>
@endsection
