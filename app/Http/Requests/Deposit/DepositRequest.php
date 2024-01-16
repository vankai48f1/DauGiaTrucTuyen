<?php

namespace App\Http\Requests\Deposit;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class DepositRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'amount' => [
                'required',
                'numeric',
                'between:0.01, 99999999999.99',
            ],
            'payment_method' => [
                'required',
                Rule::in(array_keys(payment_methods())),
            ],
            'bank_account_id' => [
                'required_if:payment_method,' . PAYMENT_METHOD_BANK,
                Rule::exists('bank_accounts', 'id')
                    ->where("is_active", ACTIVE)
                    ->where('user_id', Auth::id()),
            ],
            'deposit_policy' => [
                'accepted',
            ],
        ];
    }
}
