<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('tampilan.landing');
})->name('landing');

Route::get('/landing', function () {
    return redirect()->route('landing');
});

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'create'])->name('login');
    Route::post('/login', [AuthController::class, 'store']);
});

Route::post('/logout', [AuthController::class, 'destroy'])->middleware('auth')->name('logout');

Route::get('/dashboard', [AuthController::class, 'dashboard'])->middleware('auth')->name('dashboard');

Route::get('/pemesanan', function () {
    return view('tampilan.pemesanan');
})->name('pemesanan');

Route::get('/qris-instan', function () {
    return view('tampilan.qris-instan');
})->name('qris-instan');

Route::get('/pembayaran-qris', function () {
    return view('tampilan.pembayaran-qris');
})->name('pembayaran-qris');

Route::middleware(['auth', 'role:kasir'])->group(function () {
    Route::get('/stok-menu', function () {
        return view('tampilan.stok-menu');
    })->name('stok-menu');

    Route::get('/kasir-order-monitor', function () {
        return view('tampilan.kasir-order-monitor');
    })->name('kasir-order-monitor');
});

Route::middleware(['auth', 'role:owner'])->get('/laporan-penjualan', function () {
    return view('tampilan.laporan-penjualan');
})->name('laporan-penjualan');
