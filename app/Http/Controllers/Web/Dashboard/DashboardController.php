<?php

namespace App\Http\Controllers\Web\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Auction\Currency;
use App\Models\User\Auction;
use App\Models\User\Bid;
use App\Models\User\WalletTransaction;

class DashboardController extends Controller
{
    public function index(Currency $currency = null)
    {
        if (is_null($currency)){
            $currency = Currency::first();
        }

        abort_if(is_null($currency), 404);

        $data['currency'] = $currency;
        $data['currencies'] = Currency::where('is_active', ACTIVE)->select('symbol')->get();
        $data['title'] = __('Admin Dashboard');

        return view('dashboard.admin.index', $data);
    }

    public function totalEarnings(Currency $currency = null){
        if (is_null($currency)){
            $currency = Currency::first();
        }
        $data = [];
        if (is_null($currency)){
            return response()->json([RESPONSE_STATUS_KEY => RESPONSE_TYPE_ERROR, RESPONSE_DATA_KEY => $data]);
        }

        $data['currentMonthEarning'] = $this->_getCurrentMonthEarning($currency->symbol);
        $data['totalEarning'] = $this->_getTotalEarning($currency->symbol);

        return response()->json([RESPONSE_STATUS_KEY => RESPONSE_TYPE_SUCCESS, RESPONSE_DATA_KEY => $data]);
    }

    public function earningSources(Currency $currency = null){
        if (is_null($currency)){
            $currency = Currency::first();
        }
        $data = [];
        if (is_null($currency)){
            return response()->json([RESPONSE_STATUS_KEY => RESPONSE_TYPE_ERROR, RESPONSE_DATA_KEY => $data]);
        }

        $data['depositEarning'] = $this->_getAllDepositFeeEarning($currency->symbol)->whereMonth('created_at', now()->month)->sum('system_fee');
        $data['withdrawalEarning'] = $this->_getAllWithdrawalFeeEarning($currency->symbol)->whereMonth('created_at', now()->month)->sum('system_fee');
        $data['auctionEarning'] = $this->_getAllAuctionEarning($currency->symbol)->whereMonth('created_at', now()->month)->get()->sum('system_fee');
        $data['bidEarning'] = $this->_getAllBidEarning($currency->symbol)->whereMonth('created_at', now()->month)->sum('system_fee');

        return response()->json([RESPONSE_STATUS_KEY => RESPONSE_TYPE_SUCCESS, RESPONSE_DATA_KEY => $data]);
    }

    public function _getAllDepositFeeEarning($symbol){
        return WalletTransaction::where('txn_type', TRANSACTION_TYPE_DEPOSIT)
            ->where('currency_symbol', $symbol)
            ->where('status', PAYMENT_STATUS_COMPLETED)
            ->select(['system_fee as amount', 'currency_symbol', 'created_at']);
    }

    public function _getAllWithdrawalFeeEarning($symbol){
        return WalletTransaction::where('txn_type', TRANSACTION_TYPE_WITHDRAWAL)
            ->where('currency_symbol', $symbol)
            ->where('status', PAYMENT_STATUS_COMPLETED)
            ->select(['system_fee as amount', 'currency_symbol', 'created_at']);
    }

    public function _getAllAuctionEarning($symbol){
        return Auction::where('currency_symbol', $symbol)
            ->where('status', AUCTION_STATUS_COMPLETED)
            ->select(['system_fee as amount', 'currency_symbol', 'created_at']);
    }

    public function _getAllBidEarning($symbol){
        return Bid::where('currency_symbol', $symbol)
            ->select(['system_fee as amount', 'currency_symbol', 'created_at']);
    }

    public function _getCurrentMonthEarning($symbol){
        $totalDepositEarning = $this->_getAllDepositFeeEarning($symbol)->whereMonth('created_at', now()->month);
        $totalWithdrawalEarning = $this->_getAllWithdrawalFeeEarning($symbol)->whereMonth('created_at', now()->month);
        $totalBidEarning = $this->_getAllBidEarning($symbol)->whereMonth('created_at', now()->month);
        $totalAuctionEarning = $this->_getAllAuctionEarning($symbol)->whereMonth('created_at', now()->month);

        return $totalAuctionEarning->union($totalDepositEarning)->union($totalWithdrawalEarning)->union($totalBidEarning)->sum('amount');
    }

    public function _getTotalEarning($symbol){
        $totalDepositEarning = $this->_getAllDepositFeeEarning($symbol);
        $totalWithdrawalEarning = $this->_getAllWithdrawalFeeEarning($symbol);
        $totalBidEarning = $this->_getAllBidEarning($symbol);
        $totalAuctionEarning = $this->_getAllAuctionEarning($symbol);
        return $totalAuctionEarning->union($totalDepositEarning)->union($totalWithdrawalEarning)->union($totalBidEarning)->sum('amount');
    }
}
