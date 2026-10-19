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
