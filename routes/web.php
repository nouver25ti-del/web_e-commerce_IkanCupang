<?php

use App\Http\Controllers\CupangController;
use Illuminate\Support\Facades\Route;

Route::get('/', [CupangController::class, 'index'])->name('cupang.index');
Route::resource('cupang', CupangController::class)->except(['index', 'show']);
Route::post('keranjang/{cupang}', [CupangController::class, 'beli'])->name('cupang.beli');
