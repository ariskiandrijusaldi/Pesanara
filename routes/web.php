<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('tampilan.landing');
});

Route::get('/landing', function () {
    return view('tampilan.landing');
});

Route::get('/pemesanan', function () {
    return view('tampilan.pemesanan');
});

Route::get('/login', function () {
    return view('tampilan.login');
})->name('login');

Route::get('/stok-menu', function () {
    return view('tampilan.stok-menu');
})->name('stok-menu');

Route::get('/laporan-penjualan', function () {
    return view('tampilan.laporan-penjualan');
})->name('laporan-penjualan');

Route::get('/qris-instan', function () {
    return view('tampilan.qris-instan');
})->name('qris-instan');

Route::get('/pembayaran-qris', function () {
    return view('tampilan.pembayaran-qris');
})->name('pembayaran-qris');

Route::get('/kasir-order-monitor', function () {
    return view('tampilan.kasir-order-monitor');
})->name('kasir-order-monitor');
