<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
<title>@yield('title', 'Toko Cupang')</title>
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Caveat:wght@500&family=Inter:wght@400;600;800&display=swap">
<link rel="stylesheet" href="{{ asset('css/toko.css') }}">
</head>
<body>
@yield('content')

<footer id="kontak">
  <h3>Toko Cupang</h3>
  <p>Kami merawat setiap cupang sebelum dikirim dan mengemasnya dengan aman. Tanyakan stok atau pesanan khusus lewat WhatsApp.</p>
  <p>Pekanbaru, Riau · Senin–Sabtu, 09.00–17.00</p>
</footer>

@if (session('status'))
  <div class="toast on" id="toast" role="status">{{ session('status') }}</div>
  <script>setTimeout(function(){document.getElementById('toast').classList.remove('on')},2500)</script>
@endif
</body>
</html>
