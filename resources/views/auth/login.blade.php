@extends('layouts.app')

@section('title', 'Masuk')

@section('content')
<main class="formpage">
  <a class="back" href="{{ route('cupang.index') }}">← Kembali ke toko</a>
  <span class="eyebrow tag">Pelanggan</span>
  <h1>Masuk</h1>
  <p class="hint">Masuk untuk memasukkan cupang ke keranjang.</p>

  <form method="POST" action="{{ route('login') }}">
    @csrf
    <label for="email">Email</label>
    <input id="email" name="email" type="email" value="{{ old('email') }}" autocomplete="username" required autofocus>
    @error('email')<p class="err">{{ $message }}</p>@enderror

    <label for="password">Kata sandi</label>
    <input id="password" name="password" type="password" autocomplete="current-password" required>
    @error('password')<p class="err">{{ $message }}</p>@enderror

    <label class="cek"><input type="checkbox" name="remember" value="1"> Ingat saya</label>

    <div class="row"><button class="lime">Masuk</button></div>
  </form>

  <p class="authlinks">Belum punya akun? <a href="{{ route('register') }}">Daftar</a></p>
  <p class="authlinks small">Pengelola toko? <a href="{{ route('admin.login') }}">Login admin</a></p>
</main>
@endsection
