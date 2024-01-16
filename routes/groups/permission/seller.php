<?php

use App\Http\Controllers\Web\Auction\SellerAuctionController;
use App\Http\Controllers\Web\Auction\SellerShippingController;
use App\Http\Controllers\Web\KYC\SellerAddressController;
use App\Http\Controllers\Web\KYC\SellerAddressVerificationController;
use App\Http\Controllers\Web\Store\StoreController;
use Illuminate\Support\Facades\Route;

//KYC Address Verification
Route::put('kyc/seller/addresses/{id}/toggle-default-status', [SellerAddressController::class, 'toggleDefaultStatus'])
    ->name('kyc.seller.addresses.toggle-default-status');
Route::resource('kyc/seller/addresses', SellerAddressController::class)
    ->except('show')
    ->names('kyc.seller.addresses');
Route::resource('kyc/seller/addresses/{address}/verification', SellerAddressVerificationController::class)
    ->only('create', 'store', 'show')
    ->names('kyc.seller.addresses.verification');

//Store
Route::get('store', [StoreController::class, 'index'])->name('seller.store.index');
Route::get('store/edit', [StoreController::class, 'edit'])->name('seller.store.edit');
Route::put('store/update', [StoreController::class, 'update'])->name('seller.store.update');

//Auction
Route::get('seller/auction/create', [SellerAuctionController::class, 'create'])->name('auction.create');
Route::put('seller/auction/{auction}/start', [SellerAuctionController::class, 'start'])->name('auction.start');
Route::get('seller/auction/{auction}/edit', [SellerAuctionController::class, 'edit'])->name('auction.edit');
Route::put('seller/auction/{auction}/update', [SellerAuctionController::class, 'update'])->name('auction.update');
Route::put('seller/auction/{id}/release-money', [SellerAuctionController::class, 'releaseSellerMoney'])->name('release.seller.money');
Route::post('seller/auction/store', [SellerAuctionController::class, 'store'])->name('auction.store');

// shipping
Route::get('auction/{auction:ref_id}/seller/shipping-description', [SellerShippingController::class, 'create'])->name('seller.shipping-description.create');
Route::put('auction/{auction:ref_id}/seller/shipping-description', [SellerShippingController::class, 'store'])->name('seller.shipping-description.store');
