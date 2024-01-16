<?php

use App\Http\Controllers\Web\AjaxController;
use App\Http\Controllers\Web\Auction\AuctionBidHistoryController;
use App\Http\Controllers\Web\Auction\AuctionController;
use App\Http\Controllers\Web\Auction\CommentController;
use App\Http\Controllers\Web\Store\StoreController;
use App\Http\Controllers\Web\HomeController;
use App\Http\Controllers\Web\TestController;

use App\Http\Controllers\Web\Page\PageController;
use Illuminate\Support\Facades\Route;

Route::get('/', HomeController::class)->name('home');

Route::get('/countries/{country}/states', [AjaxController::class, 'getStates'])
    ->name('ajax.get-states');


Route::get('/auctions', [AuctionController::class, 'index'])->name('auction.home');
Route::get('auction/{auction:ref_id}', [AuctionController::class,'show'])->name('auction.show');

Route::get('auction/{auction:ref_id}/bids', [AuctionBidHistoryController::class, 'index'])->name('auction.bids');
Route::get('auction/{auction:ref_id}/comments', [CommentController::class, 'index'])->name('auction.comments');
Route::get('seller/{seller:ref_id}', [StoreController::class, 'show'])->name('seller.store.show');
//Test
Route::get('test', [TestController::class, 'test'])->name('test');

//Dynamic Page (Don't place any route after this page route)
Route::get('/{page:slug}', PageController::class)->name('page');
