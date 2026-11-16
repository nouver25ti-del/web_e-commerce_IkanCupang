# 🐟 Toko Cupang

Website e-commerce sederhana untuk menjual ikan cupang hias (plakat, halfmoon, crowntail, giant, dan double tail). Dibangun dengan **Laravel 12**, dengan pemisahan yang jelas antara sisi **pelanggan** dan sisi **admin**.

## Fitur

### Pelanggan (customer)
- Melihat katalog cupang lengkap dengan foto, harga, jenis, warna, dan stok.
- Mencari cupang berdasarkan nama atau kode, serta memfilter berdasarkan jenis.
- Mendaftar akun dan login.
- Menambahkan cupang ke keranjang (dibatasi oleh stok yang tersedia).

### Admin
- Login lewat halaman khusus admin.
- Dashboard ringkasan: jumlah produk, total stok, dan jumlah produk yang habis.
- Tambah, ubah, dan hapus data cupang (kode, nama, jenis, warna, harga, stok).
- Unggah, ganti, atau hapus foto cupang (JPG, PNG, WebP, maksimal 2 MB).
- Mencari produk berdasarkan nama atau kode.

### Keamanan
- Halaman login pelanggan dan admin dipisah, dibedakan oleh kolom `role` pada tabel `users`.
- Akun admin tidak bisa masuk lewat login pelanggan, dan sebaliknya.
- Pendaftaran publik selalu menghasilkan akun pelanggan. Akun admin hanya dibuat lewat seeder.
- Area `/admin` hanya bisa diakses oleh role `admin`.
- Login dibatasi 5 kali percobaan gagal.

## Teknologi

| Bagian | Yang dipakai |
|---|---|
| Framework | Laravel 12 (PHP 8.2+) |
| Database | MySQL |
| Tampilan | Blade dan CSS kustom (`public/css/toko.css`) |
| Sesi | Database session |

## Halaman dan rute

| Alamat | Keterangan | Akses |
|---|---|---|
| `/` | Katalog toko | Semua |
| `/login` | Login pelanggan | Tamu |
| `/register` | Daftar pelanggan | Tamu |
| `/admin/login` | Login admin | Tamu |
| `/admin/cupang` | Daftar dan kelola produk | Admin |
| `/admin/cupang/create` | Tambah produk | Admin |
| `/admin/cupang/{id}/edit` | Ubah produk | Admin |

## Cara menjalankan

Pastikan sudah terpasang PHP 8.2 atau lebih baru, Composer, dan MySQL. Bisa memakai Laragon atau XAMPP.

```bash
# 1. Clone repositori
git clone https://github.com/<username>/web_e-commerce_IkanCupang.git
cd web_e-commerce_IkanCupang

# 2. Pasang dependensi
composer install

# 3. Salin file environment lalu buat app key
cp .env.example .env
php artisan key:generate
```

Buka file `.env`, lalu sesuaikan koneksi database:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=toko_cupang
DB_USERNAME=root
DB_PASSWORD=
```

Buat database `toko_cupang` di MySQL, lalu jalankan:

```bash
# 4. Buat tabel dan isi data awal
php artisan migrate --seed

# 5. Jalankan server
php artisan serve
```

Buka `http://127.0.0.1:8000` di browser.

## Akun demo

Dibuat otomatis oleh `UserSeeder`.

| Peran | Email | Kata sandi | Halaman login |
|---|---|---|---|
| Admin | `admin@tokocupang.test` | `admin12345` | `/admin/login` |
| Pelanggan | `pelanggan@tokocupang.test` | `pelanggan123` | `/login` |

> ⚠️ Segera ganti kata sandi ini di `database/seeders/UserSeeder.php` sebelum website dipasang di server sungguhan.

## Struktur penting

```
app/
├── Http/
│   ├── Controllers/
│   │   ├── AuthController.php          # login, daftar, logout
│   │   ├── CupangController.php        # katalog dan keranjang (pelanggan)
│   │   └── Admin/CupangController.php  # kelola produk (admin)
│   └── Middleware/EnsureRole.php       # pembatas akses berdasarkan role
└── Models/
    ├── Cupang.php
    └── User.php
resources/views/
├── auth/        # login pelanggan, login admin, daftar
├── admin/       # panel kelola produk
├── cupang/      # katalog toko
└── layouts/     # layout toko dan layout admin
routes/web.php   # semua rute
```

## Catatan

- Foto produk disimpan di `public/uploads/cupang/`.
- Keranjang disimpan di session, sehingga hilang saat pengguna logout. Fitur checkout dan riwayat pesanan belum tersedia.
- Jangan unggah file `.env` ke repositori publik.

## Lisensi

Proyek ini dibuat untuk keperluan pembelajaran. Framework Laravel berlisensi [MIT](https://opensource.org/licenses/MIT).
