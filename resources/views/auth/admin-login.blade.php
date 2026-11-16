@extends('layouts.app')

@section('title', 'Login Admin')

@section('content')
<main class="formpage">
  <a class="back" href="{{ route('cupang.index') }}">← Kembali ke toko</a>
  <span class="eyebrow tag">Khusus pengelola</span>
  <h1>Login Admin</h1>
  <p class="hint">Halaman ini hanya untuk admin Toko Cupang.</p>

  <form method="POST" action="{{ route('admin.login') }}">
    @csrf
    <label for="email">Email admin</label>
    <input id="email" name="email" type="email" value="{{ old('email') }}" autocomplete="username" required autofocus>
    @error('email')<p class="err">{{ $message }}</p>@enderror

    <label for="password">Kata sandi</label>
    <input id="password" name="password" type="password" autocomplete="current-password" required>
    @error('password')<p class="err">{{ $message }}</p>@enderror

    <label class="cek"><input type="checkbox" name="remember" value="1"> Ingat saya</label>

    <div class="row"><button class="lime">Masuk ke panel</button></div>
  </form>

  <p class="authlinks small">Bukan admin? <a href="{{ route('login') }}">Login pelanggan</a></p>
</main>
@endsection
