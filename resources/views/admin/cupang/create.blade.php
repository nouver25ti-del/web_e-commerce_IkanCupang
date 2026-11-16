@extends('layouts.admin')

@section('title', 'Tambah cupang')

@section('content')
<main class="formpage">
  <a class="back" href="{{ route('admin.cupang.index') }}">← Kembali ke daftar</a>
  <h1>Tambah cupang</h1>
  <form method="POST" action="{{ route('admin.cupang.store') }}" enctype="multipart/form-data">
    @include('admin.cupang._form')
    <div class="row">
      <a class="btn" href="{{ route('admin.cupang.index') }}">Batal</a>
      <button class="lime">Simpan</button>
    </div>
  </form>
</main>
@endsection
