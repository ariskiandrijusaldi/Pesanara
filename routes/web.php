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
