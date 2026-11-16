@extends('layouts.admin')

@section('title', 'Edit cupang')

@section('content')
<main class="formpage">
  <a class="back" href="{{ route('admin.cupang.index') }}">← Kembali ke daftar</a>
  <h1>Edit cupang</h1>
  <form method="POST" action="{{ route('admin.cupang.update', $cupang) }}" enctype="multipart/form-data">
    @method('PUT')
    @include('admin.cupang._form')
    <div class="row">
      <a class="btn" href="{{ route('admin.cupang.index') }}">Batal</a>
      <button class="lime">Simpan perubahan</button>
    </div>
  </form>
</main>
@endsection
