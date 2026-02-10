<?php

use App\Http\Controllers\ParkingController; // Sesuaikan namespace controller Anda
use Illuminate\Support\Facades\Route;

// Rute ini yang akan dipanggil oleh Python (http://127.0.0.1:8000/api/deteksi-masuk)
Route::post('/deteksi-masuk', [ParkingController::class, 'apiMasukOtomatis']);

Route::post('/set-plat-antrian', [ParkingController::class, 'setAntrian']);
Route::get('/get-plat-antrian', [ParkingController::class, 'getAntrian']);
