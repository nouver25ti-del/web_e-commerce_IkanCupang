<?php

use App\Http\Controllers\Admin\CupangController as AdminCupangController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CupangController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| PELANGGAN (customer)
|--------------------------------------------------------------------------
*/
Route::get('/', [CupangController::class, 'index'])->name('cupang.index');

Route::middleware(['auth', 'role:customer'])->group(function () {
    Route::post('keranjang/{cupang}', [CupangController::class, 'beli'])->name('cupang.beli');
});

/*
|--------------------------------------------------------------------------
| LOGIN / DAFTAR / KELUAR
|--------------------------------------------------------------------------
| Halaman login pelanggan dan admin dipisah. Keduanya memakai tabel users,
| dibedakan oleh kolom "role".
*/
Route::middleware('guest')->group(function () {
    // Pelanggan
    Route::get('login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('login', [AuthController::class, 'login']);
    Route::get('register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('register', [AuthController::class, 'register']);

    // Admin (tidak ada pendaftaran: akun admin dibuat lewat seeder)
    Route::get('admin/login', [AuthController::class, 'showAdminLogin'])->name('admin.login');
    Route::post('admin/login', [AuthController::class, 'adminLogin']);
});

Route::post('logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');

/*
|--------------------------------------------------------------------------
| ADMIN
|--------------------------------------------------------------------------
*/
Route::prefix('admin')->name('admin.')->middleware(['auth', 'role:admin'])->group(function () {
    Route::redirect('/', '/admin/cupang');
    Route::resource('cupang', AdminCupangController::class)->except(['show']);
});
