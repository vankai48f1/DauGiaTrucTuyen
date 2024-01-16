<?php

use App\Http\Controllers\Api\PaypalController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::any('webhook/paypal', [PaypalController::class, 'webhookPaypal'])
    ->name('webhook.paypal');

