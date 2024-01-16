<?php

use App\Http\Controllers\Web\Core\ProductActiveController;
use App\Http\Controllers\Web\Guest\AuthController;
use Illuminate\Support\Facades\Route;

Route::get('login', [AuthController::class, 'loginForm'])
    ->name('login');
Route::post('login', [AuthController::class, 'login'])
    ->name('login');
Route::get('register', [AuthController::class, 'register'])
    ->name('register.index')
    ->middleware('registration.permission');
Route::post('register/store', [AuthController::class, 'storeUser'])
    ->name('register.store')
    ->middleware('registration.permission');
Route::get('forget-password', [AuthController::class, 'forgetPassword'])
    ->name('forget-password.index');
Route::post('product-activation', [ProductActiveController::class, 'store'])
    ->name('product-activation');
Route::post('forget-password/send-mail', [AuthController::class, 'sendPasswordResetMail'])
    ->name('forget-password.send-mail');
Route::get('reset-password/{user}', [AuthController::class, 'resetPassword'])
    ->name('reset-password.index');
Route::post('reset-password/{user}/update', [AuthController::class, 'updatePassword'])
    ->name('reset-password.update');
