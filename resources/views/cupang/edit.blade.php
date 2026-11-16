@extends('layouts.app')

@section('title', 'Edit cupang')

@section('content')
<main class="formpage">
  <a class="back" href="{{ route('cupang.index') }}#produk">← Kembali ke produk</a>
  <h1>Edit cupang</h1>
  <form method="POST" action="{{ route('cupang.update', $cupang) }}" enctype="multipart/form-data">
    @method('PUT')
    @include('cupang._form')
    <div class="row">
      <a class="btn" href="{{ route('cupang.index') }}#produk">Batal</a>
      <button class="lime">Simpan perubahan</button>
    </div>
  </form>
</main>
@endsection
