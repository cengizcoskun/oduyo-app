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

Route::get('/payment/success', [PaymentController::class, 'success'])->name('payment.success');


Route::match(['GET','POST'],'/payment/error', [PaymentController::class, 'error']);

// Route::post('/payment/error', [PaymentController::class, 'error']);

