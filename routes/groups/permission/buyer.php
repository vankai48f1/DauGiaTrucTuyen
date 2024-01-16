<?php

use App\Http\Controllers\Api\PaypalController;
use App\Http\Controllers\Web\Auction\BuyerShippingDetailController;
use App\Http\Controllers\Web\Auction\SellerAuctionController;
use App\Http\Controllers\Web\Auction\BidController;
use App\Http\Controllers\Web\Auction\CommentController;
use App\Http\Controllers\Web\BankAccount\ChangeUserBankAccountStatusController;
use App\Http\Controllers\Web\BankAccount\UserBankManagementController;
use App\Http\Controllers\Web\Buyer\BecomeASellerController;
use App\Http\Controllers\Web\Buyer\BuyerAttendedAuctionController;
use App\Http\Controllers\Web\Buyer\BuyerWonAuctionController;
use App\Http\Controllers\Web\Core\NotificationController;
use App\Http\Controllers\Web\Core\ProfileController;
use App\Http\Controllers\Web\Deposit\UserDepositController;
use App\Http\Controllers\Web\Dispute\UserDisputeController;
use App\Http\Controllers\Web\KYC\UserAddressController;
use App\Http\Controllers\Web\KYC\UserAddressVerificationController;
use App\Http\Controllers\Web\KYC\UserIdentityVerificationController;
use App\Http\Controllers\Web\Wallet\UserWalletController;
use App\Http\Controllers\Web\Withdrawal\UserWithdrawalController;
use Illuminate\Support\Facades\Route;

//User profile
Route::get('profile', [ProfileController::class, 'index'])->name('profile.index');
Route::get('profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
Route::put('profile/update', [ProfileController::class, 'update'])->name('profile.update');
Route::get('profile/change-password', [ProfileController::class, 'changePassword'])->name('profile.change-password');
Route::put('profile/change-password/update', [ProfileController::class, 'updatePassword'])->name('profile.update-password');
Route::get('profile/avatar/edit', [ProfileController::class, 'avatarEdit'])->name('profile.avatar.edit');
Route::put('profile/avatar/update', [ProfileController::class, 'avatarUpdate'])->name('profile.avatar.update');

//User Specific Notice
Route::get('notifications', [NotificationController::class, 'index'])->name('notifications.index');
Route::get('notifications/{notification}/read', [NotificationController::class, 'markAsRead'])->name('notifications.mark-as-read');
Route::get('notifications/{notification}/unread', [NotificationController::class, 'markAsUnread'])->name('notifications.mark-as-unread');

//User Verifications Controllers

Route::put('kyc/addresses/{id}/toggle-default-status', [UserAddressController::class, 'toggleDefaultStatus'])
    ->name('kyc.addresses.toggle-default-status');
Route::resource('kyc/addresses', UserAddressController::class)
    ->except('show')
    ->names('kyc.addresses');
Route::resource('kyc/addresses/{address}/verification', UserAddressVerificationController::class)
    ->only('create', 'store', 'show')
    ->names('kyc.addresses.verification');

Route::resource('kyc/identity', UserIdentityVerificationController::class)
    ->only('index', 'store')
    ->names('kyc.identity');

//Auctions
Route::get('attended-auctions', BuyerAttendedAuctionController::class)
    ->name('buyer-attended-auction.index');

Route::get('attended-auctions/won', BuyerWonAuctionController::class)
    ->name('buyer-winning-auction.index');

Route::get('seller/auction/create', [SellerAuctionController::class, 'create'])->name('auction.create');
Route::post('seller/auction/store', [SellerAuctionController::class, 'store'])->name('auction.store');

//Auction Shipping
Route::put('auction/{auction:ref_id}/confirm-delivery', [BuyerShippingDetailController::class, 'confirmProductReceived'])->name('buyer.confirm-delivery');

Route::get('auction/{auction:ref_id}/buyer/shipping-description', [BuyerShippingDetailController::class, 'create'])->name('shipping-description.create');
Route::post('auction/{auction:ref_id}/buyer/shipping-description', [BuyerShippingDetailController::class, 'update'])->name('shipping-description.update');


//Bidding
Route::post('bid/{auctionId}', [BidController::class, 'store'])->name('bid.store');

//Comment
Route::post('comments/{auctionId}/reply/{comment}', [CommentController::class, 'reply'])->name('comment.reply');
Route::resource('comments/{auctionId}', CommentController::class)
    ->only('index', 'create', 'store')
    ->names('comment');

//Dispute
Route::resource('dispute', UserDisputeController::class)->names('dispute')->parameter('dispute', 'id')->only(['create', 'store']);
Route::get('specific-dispute/{dispute_type}/{ref_id}', [UserDisputeController::class, 'specific'])->name('disputes.specific');
Route::get('dispute/{type?}', [UserDisputeController::class, 'index'])->name('dispute.index');

Route::get('wallets', [UserWalletController::class, 'index'])->name('wallets.index');

Route::get('become-a-seller', [BecomeASellerController::class, 'create'])->name('become-a-seller.create');
Route::post('become-a-seller', [BecomeASellerController::class, 'store'])->name('become-a-seller.store');

//Bank Account
Route::put('bank-accounts/toggle-status/{bankAccount}', [ChangeUserBankAccountStatusController::class, 'change'])
    ->name('bank-accounts.toggle-status');
Route::resource('bank-accounts', UserBankManagementController::class)
    ->except('show');

//Wallet Transaction
Route::resource('wallets/{wallet:currency_symbol}/deposits', UserDepositController::class)
    ->names('wallets.deposits')->except('edit', 'destroy');
Route::resource('wallets/{wallet:currency_symbol}/withdrawals', UserWithdrawalController::class)
    ->names('wallets.withdrawals')->except('edit', 'update');

//PayPal
Route::get('/paypal/return-url', [PaypalController::class, 'returnUrl'])->name('paypal.return-url');
Route::get('/paypal/cancel-url', [PaypalController::class, 'cancelUrl'])->name('paypal.cancel-url');


