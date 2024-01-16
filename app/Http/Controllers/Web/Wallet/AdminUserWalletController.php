<?php

namespace App\Http\Controllers\Web\Wallet;

use App\Http\Controllers\Controller;
use App\Models\Core\User;
use App\Models\User\Wallet;
use App\Services\Core\DataTableService;
use Illuminate\View\View;

class AdminUserWalletController extends Controller
{
    public function __invoke(User $user): View
    {
        $searchFields = [
            ['balance', __('Balance')],
            ['on_order', __('On Order')],
        ];
        $orderFields = [
            ['balance', __('Balance')],
            ['currency_id', __('Currency')],
            ['on_order', __('On Order')],
            ['is_system', __('System')],
        ];

        $queryBuilder = wallet::query()
            ->where('user_id', $user->id)
            ->where('is_system', INACTIVE)
            ->orderByDesc('created_at');

        $data['dataTable'] = app(DataTableService::class)
            ->setSearchFields($searchFields)
            ->setOrderFields($orderFields)
            ->create($queryBuilder);

        $data['title'] = __('User Wallet: :user', ['user' => $user->profile->full_name]);
        $data['userId'] = $user->id;
        $data['title'] = __('User Wallet: :user', ['user' => $user->profile->full_name]);
        return view('user_transaction_history.wallets', $data);
    }
}
