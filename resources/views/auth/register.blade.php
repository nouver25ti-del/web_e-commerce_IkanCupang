@extends('layouts.app')

@section('title', 'Daftar')

@section('content')
<main class="formpage">
  <a class="back" href="{{ route('cupang.index') }}">← Kembali ke toko</a>
  <span class="eyebrow tag">Pelanggan</span>
  <h1>Buat akun</h1>

  <form method="POST" action="{{ route('register') }}">
    @csrf
    <label for="name">Nama lengkap</label>
    <input id="name" name="name" value="{{ old('name') }}" autocomplete="name" required autofocus>
    @error('name')<p class="err">{{ $message }}</p>@enderror

    <label for="email">Email</label>
    <input id="email" name="email" type="email" value="{{ old('email') }}" autocomplete="username" required>
    @error('email')<p class="err">{{ $message }}</p>@enderror

    <label for="password">Kata sandi</label>
    <input id="password" name="password" type="password" autocomplete="new-password" minlength="8" required>
    @error('password')<p class="err">{{ $message }}</p>@enderror

    <label for="password_confirmation">Ulangi kata sandi</label>
    <input id="password_confirmation" name="password_confirmation" type="password" autocomplete="new-password" required>

    <div class="row"><button class="lime">Daftar</button></div>
  </form>

  <p class="authlinks">Sudah punya akun? <a href="{{ route('login') }}">Masuk</a></p>
</main>
@endsection
