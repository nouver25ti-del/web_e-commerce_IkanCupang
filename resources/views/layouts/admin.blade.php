<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
<meta name="robots" content="noindex">
<title>@yield('title', 'Admin') · Admin Toko Cupang</title>
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Caveat:wght@500&family=Inter:wght@400;600;800&display=swap">
<link rel="stylesheet" href="{{ asset('css/toko.css') }}">
</head>
<body>
<header class="topbar">
  <a class="logo" href="{{ route('admin.cupang.index') }}">Toko Cupang <small>Admin</small></a>
  <nav aria-label="Menu admin">
    <a href="{{ route('cupang.index') }}">Lihat toko</a>
    <span class="who">{{ auth()->user()->name }}</span>
    <form method="POST" action="{{ route('logout') }}">
      @csrf
      <button class="lnk">Keluar</button>
    </form>
  </nav>
</header>

@yield('content')

@if (session('status'))
  <div class="toast on" id="toast" role="status">{{ session('status') }}</div>
  <script>setTimeout(function(){document.getElementById('toast').classList.remove('on')},2500)</script>
@endif
</body>
</html>
