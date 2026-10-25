<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\OrderController;
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

Route::post('/orders', [OrderController::class, 'store'])->name('orders.store');
Route::get('/orders/{order}/status', [OrderController::class, 'statusFeed'])->name('orders.status');
Route::post('/orders/{order}/pay', [OrderController::class, 'pay'])->name('orders.pay');

Route::get('/pembayaran-qris', [OrderController::class, 'payment'])->name('pembayaran-qris');

Route::get('/status-pesanan', [OrderController::class, 'status'])->name('status-pesanan');

Route::middleware(['auth', 'role:kasir,owner'])->group(function () {
    Route::get('/stok-menu', function () {
        return view('tampilan.stok-menu');
    })->name('stok-menu');

    Route::get('/kasir-order-monitor', [OrderController::class, 'monitor'])->name('kasir-order-monitor');
    Route::get('/kasir-order-monitor/feed', [OrderController::class, 'feed'])->name('kasir-order-monitor.feed');
    Route::patch('/orders/{order}', [OrderController::class, 'update'])->name('orders.update');
});

Route::middleware(['auth', 'role:owner'])->get('/laporan-penjualan', function () {
    return view('tampilan.laporan-penjualan');
})->name('laporan-penjualan');
