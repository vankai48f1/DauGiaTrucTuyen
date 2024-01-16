<?php

use App\Http\Controllers\Web\Guest\AuthController;
use Illuminate\Support\Facades\Route;

require_once('permission/admin.php');
require_once('permission/buyer.php');
require_once('permission/seller.php');

Route::get('logout', [AuthController::class, 'logout'])->name('logout');
