<?php

use App\Http\Controllers\Web\Auction\AdminAuctionController;
use App\Http\Controllers\Web\Auction\AdminCategoryController;
use App\Http\Controllers\Web\Auction\AdminCompletedAuctionController;
use App\Http\Controllers\Web\BankAccount\AdminBankManagementController;
use App\Http\Controllers\Web\BankAccount\ChangeAdminBankAccountStatusController;
use App\Http\Controllers\Web\Core\{AdminDirectoryController,
    AdminMediaController,
    ApplicationSettingController,
    LanguageController,
    NavigationController,
    NoticesController,
    RoleController,
    UsersController
};
use App\Http\Controllers\Web\Currency\AdminCurrencyController;
use App\Http\Controllers\Web\Currency\CurrencyDepositOptionsController;
use App\Http\Controllers\Web\Currency\CurrencyPaymentMethodsController;
use App\Http\Controllers\Web\Currency\CurrencyWithdrawalOptionsController;
use App\Http\Controllers\Web\Dashboard\DashboardController;
use App\Http\Controllers\Web\Deposit\AdminBankDepositAdjustController;
use App\Http\Controllers\Web\Deposit\AdminBankDepositReviewController;
use App\Http\Controllers\Web\Deposit\AdminDepositHistoryController;
use App\Http\Controllers\Web\Deposit\AdminUserDepositController;
use App\Http\Controllers\Web\Dispute\AdminDisputeController;
use App\Http\Controllers\Web\KYC\AdminAddressReviewController;
use App\Http\Controllers\Web\KYC\AdminIdentityReviewController;
use App\Http\Controllers\Web\Page\AdminDynamicContentController;
use App\Http\Controllers\Web\Page\AdminPageController;
use App\Http\Controllers\Web\Page\AdminVisualEditController;
use App\Http\Controllers\Web\Store\AdminStoreController;
use App\Http\Controllers\Web\Wallet\AdminAdjustAmountController;
use App\Http\Controllers\Web\Wallet\AdminBalanceAdjustmentHistoryController;
use App\Http\Controllers\Web\Wallet\AdminUserWalletController;
use App\Http\Controllers\Web\Withdrawal\AdminUserWithdrawalController;
use App\Http\Controllers\Web\Withdrawal\AdminWithdrawalHistoryController;
use App\Http\Controllers\Web\Withdrawal\AdminWithdrawalReviewController;
use Illuminate\Support\Facades\Route;
use Rap2hpoutre\LaravelLogViewer\LogViewerController;

Route::group(['prefix' => 'admin'], function () {
    //User Group Role
    Route::redirect('/', 'admin/dashboard');

    //Dashboard
    Route::get('dashboard/{currency?}', [DashboardController::class, 'index'])->name('admin.dashboard.index');
    Route::get('system/earning-source/{currency?}', [DashboardController::class, 'earningSources'])->name('admin.dashboard.earning-source');
    Route::get('system/total-earning/{currency?}', [DashboardController::class, 'totalEarnings'])->name('admin.dashboard.total-earning');

    //Role
    Route::resource('roles', RoleController::class)
        ->except(['show', 'edit', 'update']);
    Route::put('roles/{role}/change-status', [RoleController::class, 'changeStatus'])->name('roles.status');
    Route::get('roles/{role}/{type}/permissions', [RoleController::class, 'edit'])->name('roles.edit');
    Route::put('roles/{role}/{type}/permissions', [RoleController::class, 'update'])->name('roles.update');

    //Application Setting
    Route::get('application-settings', [ApplicationSettingController::class, 'index'])
        ->name('application-settings.index');
    Route::get('application-settings/{type}/{sub_type}', [ApplicationSettingController::class, 'edit'])
        ->name('application-settings.edit');
    Route::put('application-settings/{type}/update/{sub_type?}', [ApplicationSettingController::class, 'update'])
        ->name('application-settings.update');

    //Admin Notice
    Route::resource('notices', NoticesController::class)->except(['show']);

    //Menu
    Route::get('menu-manager/{menu_slug?}', [NavigationController::class, 'index'])->name('menu-manager.index');
    Route::post('menu-manager/{menu_slug?}/save', [NavigationController::class, 'save'])->name('menu-manager.save');

    //Language
    Route::get('languages/settings', [LanguageController::class, 'settings'])->name('languages.settings');
    Route::get('languages/translations', [LanguageController::class, 'getTranslation'])->name('languages.translations');
    Route::put('languages/settings', [LanguageController::class, 'settingsUpdate'])->name('languages.update.settings');
    Route::put('languages/sync', [LanguageController::class, 'sync'])->name('languages.sync');
    Route::resource('languages', LanguageController::class)->except('show');

    //User Managements
    Route::get('users/{user}/edit/status', [UsersController::class, 'editStatus'])->name('admin.users.edit.status');
    Route::put('users/{user}/update/status', [UsersController::class, 'updateStatus'])->name('admin.users.update.status');
    Route::resource('users', UsersController::class)->names('admin.users');

    //Laravel Log Viewer
    Route::get('logs', [LogViewerController::class, 'index'])->name('logs.index');


    //Auction Routes...............
    Route::resource('categories', AdminCategoryController::class)->names('admin.categories');

    Route::get('currencies/{currency:symbol}/payment-methods/edit', [CurrencyPaymentMethodsController::class, 'edit'])
        ->name('admin.currencies.payment-methods.edit');
    Route::put('currencies/{currency:symbol}/payment-methods/update', [CurrencyPaymentMethodsController::class, 'update'])
        ->name('admin.currencies.payment-methods.update');

    Route::get('currencies/{currency:symbol}/deposit-options/edit', [CurrencyDepositOptionsController::class, 'edit'])
        ->name('admin.currencies.deposit-options.edit');
    Route::put('currencies/{currency:symbol}/deposit-options/update', [CurrencyDepositOptionsController::class, 'update'])
        ->name('admin.currencies.deposit-options.update');

    Route::get('currencies/{currency:symbol}/withdrawal-options/edit', [CurrencyWithdrawalOptionsController::class, 'edit'])
        ->name('admin.currencies.withdrawal-options.edit');
    Route::put('currencies/{currency:symbol}/withdrawal-options/update', [CurrencyWithdrawalOptionsController::class, 'update'])
        ->name('admin.currencies.withdrawal-options.update');

    Route::resource('currencies', AdminCurrencyController::class)->names('admin.currencies');

    Route::put('auctions/{id}/release-money', [AdminAuctionController::class, 'releaseSellerMoney'])
        ->name('admin-release-money.update');

    Route::resource('auctions/completed', AdminCompletedAuctionController::class)
        ->only(['index', 'show'])
        ->names('admin.completed-auctions');
    Route::resource('auctions', AdminAuctionController::class)
        ->only('index', 'edit', 'update')
        ->names('admin.auctions');


    //KYC Address
    Route::put('kyc/address-review/{id}/approve', [AdminAddressReviewController::class, 'approve'])
        ->name('kyc.admin.address-review.approve');
    Route::resource('kyc/address-review', AdminAddressReviewController::class)
        ->only('index', 'show', 'destroy')
        ->names('kyc.admin.address-review');

    //KYC Identity
    Route::put('kyc/identity-review/{id}/approve', [AdminIdentityReviewController::class, 'approve'])
        ->name('kyc.admin.identity-review.approve');
    Route::resource('kyc/identity-review', AdminIdentityReviewController::class)
        ->only('index', 'show', 'destroy')
        ->names('kyc.admin.identity-review');

    //Store
    Route::resource('stores', AdminStoreController::class)
        ->only('index', 'edit', 'update')
        ->names('admin.stores');


    //Page Management
    Route::resource('pages', AdminPageController::class)->names('admin.pages')->except('show');
    Route::get('pages/{page:slug}/visual-edit', [AdminVisualEditController::class, 'edit'])->name('admin.pages.visual-edit');
    Route::put('pages/{page}/visual-edit', [AdminVisualEditController::class, 'update'])->name('admin.pages.visual-edit');
    Route::put('pages/{page}/published', [AdminPageController::class, 'togglePublish'])->name('admin.pages.published');
    Route::put('pages/{page}/home-page', [AdminPageController::class, 'makeHomePage'])->name('admin.pages.home-page');
    Route::get('get-dynamic-content', AdminDynamicContentController::class)->name('admin.dynamic-content');

    // Media manager
    Route::resource('media', AdminMediaController::class)->names('admin.media')->only(['index', 'store', 'destroy']);

    Route::post('media/directories', [AdminDirectoryController::class, 'store'])->name('admin.directories.store');
    Route::put('media/directories/update', [AdminDirectoryController::class, 'update'])->name('admin.directories.update');
    Route::delete('media/directories/delete', [AdminDirectoryController::class, 'delete'])->name('admin.directories.delete');

    //Dispute
    Route::get('disputes/{id}/show', [AdminDisputeController::class, 'edit'])->name('admin-dispute.edit');
    Route::get('disputes/{dispute}/read', [AdminDisputeController::class, 'markAsRead'])->name('admin-dispute.mark-as-read');
    Route::get('disputes/{dispute}/unread', [AdminDisputeController::class, 'markAsUnread'])->name('admin-dispute.mark-as-unread');
    Route::put('disputes/{id}/change-status', [AdminDisputeController::class, 'changeDisputeStatus'])->name('admin-change-dispute-status.update');
    Route::put('disputes/{id}/decline', [AdminDisputeController::class, 'declineDispute'])->name('admin-dispute-decline-status.update');
    Route::get('disputes/{type?}', [AdminDisputeController::class, 'index'])->name('admin-dispute.index');

    //System Bank Account
    Route::put('system-banks/toggle-status/{bankAccount}', [ChangeAdminBankAccountStatusController::class, 'change'])
        ->name('system-banks.toggle-status');
    Route::resource('system-banks', AdminBankManagementController::class)
        ->except('show')
        ->names('system-banks');

    // Bank Deposit Review
    Route::get('review/bank-deposits', [AdminBankDepositReviewController::class, 'index'])->name('admin.review.bank-deposits.index');
    Route::get('review/bank-deposits/{deposit}', [AdminBankDepositReviewController::class, 'show'])->name('admin.review.bank-deposits.show');
    Route::put('review/bank-deposits/{deposit}/update', [AdminBankDepositReviewController::class, 'update'])->name('admin.review.bank-deposits.update');
    Route::delete('review/bank-deposits/{deposit}/destroy', [AdminBankDepositReviewController::class, 'destroy'])->name('admin.review.bank-deposits.destroy');

    //Deposit Amount Adjustment
    Route::post('adjust/bank-deposits/{deposit}', AdminBankDepositAdjustController::class)
        ->name('admin.adjust.bank-deposits');

    //Deposit History
    Route::resource('deposit/history', AdminDepositHistoryController::class)
        ->except('create', 'store', 'edit')
        ->parameter('history', 'deposit')
        ->names('admin.deposit.history');

    //User Wallet
    Route::get('users/{user}/wallets', AdminUserWalletController::class)
        ->name('admin.users.wallets');
    Route::get('users/{user}/wallets/{wallet}/deposits', AdminUserDepositController::class)
        ->name('admin.users.wallet.deposits');
    Route::get('users/{user}/wallets/{wallet}/withdrawals', AdminUserWithdrawalController::class)
        ->name('admin.users.wallet.withdrawals');
    Route::get('users/{user}/wallets/{wallet}/adjustments', AdminBalanceAdjustmentHistoryController::class)
        ->name('admin.users.wallet.adjustments');


    //Withdrawal Review
    Route::resource('review/withdrawals', AdminWithdrawalReviewController::class)
        ->except('create', 'store', 'edit')
        ->names('admin.review.withdrawals');

    //Withdrawal History
    Route::resource('history/withdrawals', AdminWithdrawalHistoryController::class)
        ->except('create', 'store', 'edit')
        ->names('admin.history.withdrawals');

    //User adjust balance
    Route::resource('users/{user}/wallets/{wallet}/adjust-amount', AdminAdjustAmountController::class)
        ->only('create', 'store')
        ->names('admin.users.wallets.adjust-amount');
});

