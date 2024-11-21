<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});


use App\Http\Controllers\PaymentController;
Route::get('/', function () {
    return view('welcome');
});

Route::post('/payment', [PaymentController::class, 'processPayment']);
